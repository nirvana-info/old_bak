<?php

class ACCOUNTING_QUICKBOOKS_SERVICES_CUSTOMERADD extends ACCOUNTING_QUICKBOOKS_SERVICES_BASE
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
		 * Check to see if we have a customer group and if its not set in QuickBooks. Only do this if we have version 4.0 or above!
		 */
		if ($this->quickbooks->compareClientVersion('4.0')) {
			$groupId = $this->spoolData['accountingspoolnode']['custgroupid'];

			if (isId($groupId) && !$this->isChildServiceInSpool('priceleveladd') && !$this->getAccountingReference($groupId, 'customergroup')) {

				/**
				 * Create the spool
				 */
				$groupSpoolId = $this->createChildSpool('customergroup', 'add', $this->spoolData['accountingspoolnode']['customergroup']);

				/**
				 * Now execute it
				 */
				if (isId($groupSpoolId)) {
					if ($this->execSibling($serviceOutput, 'priceleveladd', 'run', array('spoolId' => $groupSpoolId))) {
						return $serviceOutput;
					} else {
						throw new Exception('Failed in running the child service PriceLevelAdd for the parent CustomerAdd spool ' . $this->spoolId);
					}
				}

				throw new Exception('Cannot initialise new child service "PriceLevelAdd" for CustomerAdd spool ' . $this->spoolId);
			}
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
				case 'priceleveladd': {
					if ($this->quickbooks->compareClientVersion('4.0')) {
						if (!isId($groupId)) {
							throw new Exception('Cannot find/convert the customer group ListID for the CustomerAdd spool ' . $this->spoolId);
						} else if (!$this->getAccountingReference($groupId, 'customergroup')) {
							throw new Exception('Cannot retrieve the customer group ListID for the CustomerAdd spool ' . $this->spoolId);
						}
					}

					/**
					 * All good. Break so we can run this spool
					 */
					break;
				}

				case 'customerquery': {

					/**
					 * If the customer already exists and we got the proper record with the ListID, create the reference association, create a 'customermod'
					 * service spool job and retire this service spool job
					 */
					if (!isset($lastReturn->ListID) || (string)$lastReturn->ListID == '') {
						throw new Exception('Duplicate entry yet the child service CustomerQuery did not return a record for CustomerAdd spool ' . $this->spoolId);
					}

					$reference = array(
						'ListID'		=> (string)$lastReturn->ListID,
						'EditSequence'	=> (string)$lastReturn->EditSequence
					);

					if (!$this->setAccountingReference($this->spoolData['accountingspoolnodeid'], 'customer', $reference)) {
						throw new Exception('Cannot set the reference association for CustomerAdd spool ' . $this->spoolId);
					}

					/**
					 * Now create the customermod child service
					 */
					$editSpoolId = $this->createChildSpool('customer', 'edit', $this->spoolData['accountingspoolnode']);

					if (isId($editSpoolId)) {
						if ($this->execSibling($serviceOutput, 'customermod', 'run', array('spoolId' => $editSpoolId))) {
							return $serviceOutput;
						} else {
							throw new Exception('Failed in running the child service CustomerMod for the parent CustomerAdd spool ' . $this->spoolId);
						}
					}

					throw new Exception('Failed in requesting the child service CustomerMod for the parent CustomerAdd spool ' . $this->spoolId);

					break;
				}

				case 'customermod': {

					/**
					 * Ok, the customermod service has created this record so there is no need to run this job Force this spool as executed
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
		 * services to 'edit' this customer
		 */
		if (($code = parent::handleResponse()) !== true) {
			if ($code == 3100) {

				/**
				 * Just quickly check to see if we already have the ListID for this customer first. If we do then we just saved a 'customerquery' SOAP call
				 */
				$reference = $this->getAccountingReference($this->spoolData['accountingspoolnodeid'], 'customer');
				if ($reference) {

					/**
					 * Run our 'customermod' service with this information. Add this job as a child
					 */
					$editSpoolId = $this->createChildSpool('customer', 'edit', $this->spoolData['accountingspoolnode']);

					if (isId($editSpoolId)) {
						return true;
					}

					throw new Exception('Cannot initiate an "CustomerMod" override service for the CustomerAdd spool ' . $this->spoolId);
				}

				/**
				 * Ok, we didn't find a match. Run the "customerquery" service and associate it with this service
				 */
				$querySpoolId = $this->createChildSpool('customer', 'query', $this->spoolData['accountingspoolnode']);

				if (isId($querySpoolId)) {
					return true;
				}

				throw new Exception('Cannot initiate an "CustomerQuery" override service for the CustomerAdd spool ' . $this->spoolId);
			}

			throw new Exception('An error occured when trying to handle the response from the CustomerAdd spool ' . $this->spoolId);
		}

		/**
		 * Customer was successfully added, now all we need to do is to store the association information for this customer
		 */
		$listid		= trim(@(string)$this->data->info->CustomerRet->ListID);
		$sequence	= trim(@(string)$this->data->info->CustomerRet->EditSequence);
		if ($listid !== '' && $sequence !== '') {

			$reference = array(
				'ListID'		=> $listid,
				'EditSequence'	=> $sequence
			);

			$this->setAccountingReference($this->spoolData['accountingspoolnodeid'], 'customer', $reference);

			return true;
		}

		throw new Exception('Cannot insert the customer using the information in the CustomerAdd spool ' . $this->spoolId);
	}
}

?>
