<?php

class ACCOUNTING_QUICKBOOKS_SERVICES_ITEMINVENTORYMOD extends ACCOUNTING_QUICKBOOKS_SERVICES_BASE
{
	/**
	 * Execute the service
	 *
	 * Method will chekc to see if additional information needs to be synced with QuickBooks. If so then create a new spool for this service. If after the new
	 * sub-spool is finished or if there was no need for it then execute the spool file
	 *
	 * @access protected
	 * @return bool true if the spool file was executed successfully, FALSE otherwise
	 */
	protected function run()
	{
		/**
		 * Check to see if we have a product and if its not set in QuickBooks
		 */
		if (!$this->isChildServiceInSpool('iteminventoryadd') && !$this->getAccountingReference($this->spoolData['accountingspoolnodeid'], 'product')) {

			/**
			 * Create the spool
			 */
			$addSpoolId = $this->createChildSpool('product', 'add', $this->spoolData['accountingspoolnode']);

			/**
			 * Now execute it
			 */
			if (isId($addSpoolId)) {
				if ($this->execSibling($serviceOutput, 'iteminventoryadd', 'run', array('spoolId' => $addSpoolId))) {
					return $serviceOutput;
				} else {
					throw new Exception('Failed in running the child service ItemInventoryAdd for the parent ItemInventoryMod spool ' . $this->spoolId);
				}
			}

			throw new Exception('Cannot initialise new child service "ItemInventoryAdd" for ItemInventoryMod spool ' . $this->spoolId);
		}

		/**
		 * Ok, now check to see whats in the children spool
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
				case 'iteminventoryquery': {

					/**
					 * If the product doesn't exists and we didn't get the proper record with the ListID, unset the reference association, create a 'iteminventoryadd'
					 * service spool job and retire this service spool job
					 */
					if (!isset($lastReturn->ListID) || (string)$lastReturn->ListID == '') {

						/**
						 * Ok, we got the product id, now to remove this bogus reference
						 */
						if (!$this->unsetAccountingReference($this->spoolData['accountingspoolnodeid'], 'product')) {
							throw new Exception('Cannot unset the reference data for the ItemInventoryMod spool ' . $this->spoolId);
						}

						/**
						 * Now create the iteminventoryadd child service
						 */
						$addSpoolId = $this->createChildSpool('product', 'add', $this->spoolData['accountingspoolnode']);

						if (isId($addSpoolId)) {
							if ($this->execSibling($serviceOutput, 'iteminventoryadd', 'run', array('spoolId' => $addSpoolId))) {
								return $serviceOutput;
							} else {
								throw new Exception('Failed in running the child service ItemInventoryAdd for the parent ItemInventoryMod spool ' . $this->spoolId);
							}
						}

						throw new Exception('Failed in requesting the child service ItemInventoryAdd for the parent ItemInventoryMod spool ' . $this->spoolId);

					/**
					 * Else if we got a proper record, reset the reference association and stick the proper ListID back into the spool file
					 */
					} else {

						$referencedata = array(
							'ListID'		=> (string)$lastReturn->ListID,
							'EditSequence'	=> (string)$lastReturn->EditSequence
						);

						if (!$this->setAccountingReference($this->spoolData['accountingspoolnodeid'], 'product', $referencedata)) {
							throw new Exception('Cannot reset the reference data for the ItemInventoryMod spool ' . $this->spoolId);
						}

						/**
						 * Continue with this service
						 */
					}
					break;
				}

				case 'iteminventoryadd':
				case 'iteminventorymod': {

					/**
					 * Ok, the iteminventoryadd service has created this record so there is no need to run this iteminventorymod job. Force this spool as executed
					 */
					if (isset($lastReturn->ListID) && (string)$lastReturn->ListID !== '') {
						$this->quickbooks->setSpoolAsExecuted($this->spoolId, true);
					}

					$this->escapeService($this->spoolId);
					break;
				}
			}
		}

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
		 * If QuickBooks cannot find our product then query it for the proper information with the 'iteminventoryquery' service
		 */
		if (($code = parent::handleResponse()) !== true) {

			/**
			 * 3120 means the record cannot be found and 3200 means that the EditSequence is out of sync. Either way the reference data is stale
			 */
			if ($code == 3120 || $code == 3200) {

				/**
				 * Ok, we didn't find a match. Run the "iteminventoryquery" service and associate it with this service
				 */
				$querySpoolId = $this->createChildSpool('product', 'query', $this->spoolData['accountingspoolnode']);

				if (isId($querySpoolId)) {
					return true;
				}

				throw new Exception('Cannot initiate an "ItemInventoryQuery" override service for the ItemInventoryMod spool ' . $this->spoolId);
			}

			throw new Exception('An error occured when trying to handle the response from the ItemInventoryMod spool ' . $this->spoolId);
		}

		/**
		 * Save the ref id if we can. Find the product first using the name and then associate the ref id with that product. This should not determine
		 * the outcome of this mehtod as the product has already been inserted into QuickBooks by now
		 */
		$listid		= trim(@(string)$this->data->info->ItemInventoryRet->ListID);
		$sequence	= trim(@(string)$this->data->info->ItemInventoryRet->EditSequence);

		if ($listid !== '' && $sequence !== '') {

			$reference = array(
				'ListID'		=> $listid,
				'EditSequence'	=> $sequence
			);

			$this->quickbooks->setAccountingReference($this->spoolData['accountingspoolnodeid'], 'product', $reference);

			/**
			 * Update our inventory levels if we can
			 */
			if (isset($this->data->info->ItemInventoryRet->QuantityOnHand)) {
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('products', array('prodcurrentinv' => (int)$this->data->info->ItemInventoryRet->QuantityOnHand), 'productid="' . $this->spoolData['accountingspoolnodeid'] . '"');
			}

			return true;
		}

		throw new Exception('Cannot update the product using the information in the ItemInventoryMod spool ' . $this->spoolId);
	}
}

?>
