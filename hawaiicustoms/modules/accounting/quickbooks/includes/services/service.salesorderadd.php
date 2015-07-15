<?php

class ACCOUNTING_QUICKBOOKS_SERVICES_SALESORDERADD extends ACCOUNTING_QUICKBOOKS_SERVICES_BASE
{
	/**
	 * Execute the service
	 *
	 * Method will check to see if additional information needs to be synced with QuickBooks. If so then create a new spool for this service. If after the new
	 * sub-spool is finished or if there was no need for it then execute the spool file
	 *
	 * @access protected
	 * @return bool true if the spool file was executed successfully, FALSE otherwise
	 */
	protected function run()
	{
		/**
		 * Check to see if we have a customer and if its not set in QuickBooks
		 */
		$customerId = $this->spoolData['accountingspoolnode']['ordcustid'];

		if (!isId($customerId)) {
			throw new Exception('Cannot find the customer ID ' . $customerId . ' for SalesOrderAdd spool ' . $this->spoolId);
		}

		if (!$this->isChildServiceInSpool('customeradd') && !$this->getAccountingReference($customerId, 'customer')) {

			/**
			 * Create the spool
			 */
			$customerSpoolId = $this->createChildSpool('customer', 'add', $this->spoolData['accountingspoolnode']['customer']);

			/**
			 * Now execute it
			 */
			if (isId($customerSpoolId)) {
				if ($this->execSibling($serviceOutput, 'customeradd', 'run', array('spoolId' => $customerSpoolId))) {
					return $serviceOutput;
				} else {
					throw new Exception('Failed in running the child service CustomerAdd for the parent SalesOrderAdd spool ' . $this->spoolId);
				}
			}

			throw new Exception('Cannot initialise new child service "CustomerAdd" for SalesOrderAdd spool ' . $this->spoolId);
		}

		/**
		 * Now to verify all the products
		 */
		$productKey = $this->getUnverifiedProduct();
		if ($productKey !== false) {

			/**
			 * Create the spool
			 */
			$productSpoolId = $this->createChildSpool('product', 'add', $this->spoolData['accountingspoolnode']['products'][$productKey]);

			/**
			 * Now execute it
			 */
			if (isId($productSpoolId)) {
				if ($this->execSibling($serviceOutput, 'iteminventoryadd', 'run', array('spoolId' => $productSpoolId))) {
					return $serviceOutput;
				} else {
					throw new Exception('Failed in running the child service ItemInventoryAdd for the parent SalesOrderAdd spool ' . $this->spoolId);
				}
			}

			throw new Exception('Cannot initialise new child service "ItemInventoryAdd" for SalesOrderAdd spool ' . $this->spoolId);
		}

		/**
		 * Check to see if we have children associated with this service
		 */
		if (!empty($this->spoolData['accountingspoolchildren'])) {

			/**
			 * Get the last child service name
			 */
			$lastChild = $this->spoolData['accountingspoolchildren'][count($this->spoolData['accountingspoolchildren'])-1];
			$lastService = $lastChild['accountingspoolrealservice'];
			$lastReturn = $lastChild['accountingspoolreturn'];

			switch (isc_strtolower($lastService))
			{
				case 'inventoryadjustmentadd': {

					/**
					 * Ok, escape this child process as it is just an addon after this process Force this spool as executed
					 */
					if (isset($lastReturn->ListID) && (string)$lastReturn->ListID !== '') {
						$this->quickbooks->setSpoolAsExecuted($this->spoolId, true);
					}

					$this->escapeService($this->spoolId);
					break;
				}
			}
		}

		/**
		 * Ok, we don't check any children as each sales order is unique so go straight into it
		 */
		return $this->manageServiceOutput();
	}

	/**
	 * Handle response from a request
	 *
	 * Method will handle the response from a request
	 *
	 * @access protected
	 * @return bool true if the response was successful and handled correctly, FALSE otherwise
	 */
	protected function response()
	{
		/**
		 * If we failed to insert this record, then check the response status code. If there is an error code then just die as each sales order should
		 * be unique
		 */
		if (($code = parent::handleResponse()) !== true) {
			throw new Exception('An error occured when trying to handle the response from the SalesOrderAdd spool ' . $this->spoolId);
		}

		/**
		 * SalesOrder was successfully added, now all we need to do is to store the association information for this order and decerement the stock on hand levels
		 */
		$txnid		= trim(@(string)$this->data->info->SalesOrderRet->TxnID);
		$sequence	= trim(@(string)$this->data->info->SalesOrderRet->EditSequence);

		if ($txnid !== '' && $sequence !== '') {

			$reference = array(
				'TnxID'			=> $txnid,
				'EditSequence'	=> $sequence
			);

			$this->quickbooks->setAccountingReference($this->spoolData['accountingspoolnodeid'], 'order', $reference);

			/**
			 * Next we need to save the order - product association id that QuickBooks use
			 */
			foreach ($this->data->info->SalesOrderRet->SalesOrderLineRet as $lineItem) {
				$productId = null;
				foreach ($this->spoolData['accountingspoolnode']['products'] as $key => $product) {
					if ($product['prodname'] == $lineItem->Desc) {
						$productId = $product['productid'];
					}
				}

				if (!isId($productId)) {
					continue;
				}

				$itemID = array(
					'TnxID'			=> $txnid,
					'EditSequence'	=> $sequence,
					'ProductID'		=> $productId,
				);

				$itemReference = array(
					'TnxID'			=> $txnid,
					'EditSequence'	=> $sequence,
					'ProductID'		=> $productId,
					'TxnLineID'		=> (string)$lineItem->TxnLineID
				);

				$this->quickbooks->setAccountingReference($itemID, 'orderlineitem', $itemReference);
			}

			/**
			 * Now assign a child spool to adjust all the product quantity levels but only if we have version 4.0 or above
			 */
			if ($this->quickbooks->compareClientVersion('4.0')) {

				$products = array();
				foreach ($this->spoolData['accountingspoolnode']['products'] as $key => $product) {
					$reference = $this->quickbooks->getAccountingReference($product['productid'], 'product');
					if (!$reference) {
						throw new Exception('Cannot find the product account reference data (Prod# ' . $product['productid'] . ') for the SalesOrderAdd spool ' . $this->spoolId);
					}

					$products[] = array(
						'ListID' => $reference['ListID'],
						'QuantityDifference' => ($product['prodorderquantity'] * -1)
					);
				}

				if (empty($products)) {
					throw new Exception('Cannot load any products for the "InventoryAdjustmentAdd" child service for the SalesOrderAdd spool ' . $this->spoolId);
				}

				$adjustSpoolId = $this->createChildSpool('inventorylevel', 'add', $products);

				if (isId($adjustSpoolId)) {
					return true;
				}

				throw new Exception('Cannot initiate an "InventoryAdjustmentAdd" child service for the SalesOrderAdd spool ' . $this->spoolId);
			}

			return true;
		}

		throw new Exception('Cannot insert the order using the information in the SalesOrderAdd spool ' . $this->spoolId);
	}

	/**
	 * Get the next unverified product key
	 *
	 * Method will return the next unverified product key within the products array
	 *
	 * @access private
	 * @return mixed The next unverified product key if there is any, FALSE if there isn't any left
	 */
	private function getUnverifiedProduct()
	{
		foreach ($this->spoolData['accountingspoolnode']['products'] as $key => $product) {
			if (!$this->getAccountingReference($product['productid'], 'product')) {
				return $key;
			}
		}

		return false;
	}
}

?>
