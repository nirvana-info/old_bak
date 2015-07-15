<?php

class ACCOUNTING_QUICKBOOKS_SERVICES_ITEMINVENTORYADD extends ACCOUNTING_QUICKBOOKS_SERVICES_BASE
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
					 * If the product already exists and we got the proper record with the ListID, create the reference association, create a 'iteminventorymod'
					 * service spool job and retire this service spool job
					 */
					if (!isset($lastReturn->ListID) || (string)$lastReturn->ListID == '') {
						throw new Exception('Duplicate entry yet the child service ItemInventoryQuery did not return a record for ItemInventoryAdd spool ' . $this->spoolId);
					}

					$reference = array(
						'ListID'		=> (string)$lastReturn->ListID,
						'EditSequence'	=> (string)$lastReturn->EditSequence
					);

					if (!$this->setAccountingReference($this->spoolData['accountingspoolnodeid'], 'product', $reference)) {
						throw new Exception('Cannot set the reference association for ItemInventoryAdd spool ' . $this->spoolId);
					}

					/**
					 * Now create the iteminventorymod child service
					 */
					$editSpoolId = $this->createChildSpool('product', 'edit', $this->spoolData['accountingspoolnode']);

					if (isId($editSpoolId)) {
						if ($this->execSibling($serviceOutput, 'iteminventorymod', 'run', array('spoolId' => $editSpoolId))) {
							return $serviceOutput;
						} else {
							throw new Exception('Failed in running the child service ItemInventoryMod for the parent ItemInventoryAdd spool ' . $this->spoolId);
						}
					}

					break;
				}

				case 'iteminventorymod': {

					/**
					 * Ok, the iteminventorymod service has created this record so there is no need to run this iteminventoryadd job. Force this spool as executed
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
		 * If we failed to insert this record, then check the response status code. If the code is 3100 'Name is not unique' then we execute the required
		 * services to 'edit' this product
		 */
		if (($code = parent::handleResponse()) !== true) {
			if ($code == 3100) {

				/**
				 * Just quickly check to see if we already have the ListID for this product first. If we do then we just saved a 'iteminventoryquery' SOAP call
				 */
				$reference = $this->getAccountingReference($this->spoolData['accountingspoolnodeid'], 'product');
				if ($reference) {

					/**
					 * Run our 'iteminventorymod' service with this information. Add this job as a child
					 */
					$editSpoolId = $this->createChildSpool('product', 'edit', $this->spoolData['accountingspoolnode']);

					if (isId($editSpoolId)) {
						return true;
					}

					throw new Exception('Cannot initiate an "ItemInventoryMod" override service for the ItemInventoryAdd spool ' . $this->spoolId);
				}

				/**
				 * Ok, we didn't find a match. Run the "iteminventoryquery" service and associate it with this service
				 */
				$querySpoolId = $this->createChildSpool('product', 'query', $this->spoolData['accountingspoolnode']);

				if (isId($querySpoolId)) {
					return true;
				}

				throw new Exception('Cannot initiate an "ItemInventoryQuery" override service for the ItemInventoryAdd spool ' . $this->spoolId);
			}

			throw new Exception('An error occured when trying to handle the response from the ItemInventoryAdd spool ' . $this->spoolId);
		}

		/**
		 * Product was successfully added, now all we need to do is to store the association information for this product
		 */
		$listid		= trim(@(string)$this->data->info->ItemInventoryRet->ListID);
		$sequence	= trim(@(string)$this->data->info->ItemInventoryRet->EditSequence);

		if ($listid !== '' && $sequence !== '') {

			$reference = array(
				'ListID'	=> $listid,
				'EditSequence'	=> $sequence
			);

			$this->quickbooks->setAccountingReference($this->spoolData['accountingspoolnodeid'], 'product', $reference);

			return true;
		}

		throw new Exception('Cannot insert the product using the information in the ItemInventoryAdd spool ' . $this->spoolId);
	}
}

?>
