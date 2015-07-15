<?php

class ACCOUNTING_QUICKBOOKS_SERVICES_CUSTOMERMOD extends ACCOUNTING_QUICKBOOKS_SERVICES_BASE
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
		 * Check to see if we have a customer and if its not set in QuickBooks
		 */
		if (!$this->isChildServiceInSpool('customeradd') && !$this->getAccountingReference($this->spoolData['accountingspoolnodeid'], 'customer')) {

			/**
			 * Create the spool
			 */
			$addSpoolId = $this->createChildSpool('customer', 'add', $this->spoolData['accountingspoolnode']);

			/**
			 * Now execute it
			 */
			if (isId($addSpoolId)) {
				if ($this->execSibling($serviceOutput, 'customeradd', 'run', array('spoolId' => $addSpoolId))) {
					return $serviceOutput;
				} else {
					throw new Exception('Failed in running the child service CustomerAdd for the CustomerMod spool ' . $this->spoolId);
				}
			}

			throw new Exception('Cannot initialise new child service "CustomerAdd" for CustomerMod spool ' . $this->spoolId);
		}

		/**
		 * Check to see if we have a customer group and if its not set in QuickBooks. Only do this if we have version 4.0 or above!
		 */
		if ($this->quickbooks->compareClientVersion('4.0')) {
			$groupID = $this->spoolData['accountingspoolnode']['custgroupid'];

			if (isId($groupID) && !$this->isChildServiceInSpool('priceleveladd') && !$this->getAccountingReference($groupID, 'customergroup')) {

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
						throw new Exception('Failed in running the child service PriceLevelAdd for the parent CustomerMod spool ' . $this->spoolId);
					}
				}

				throw new Exception('Cannot initialise new child service "PriceLevelAdd" for CustomerMod spool ' . $this->spoolId);
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
						if (!isId($groupID)) {
							throw new Exception('Cannot find/convert the customer group ListID for the CustomerMod spool job ' . $this->spoolId);
						} else if (!$this->getAccountingReference($groupID, 'customergroup')) {
							throw new Exception('Cannot retrieve the customer group ListID for the CustomerMod spool job ' . $this->spoolId);
						}
					}

					/**
					 * All good. Break so we can run this spool
					 */
					break;
				}

				case 'customerquery': {

					/**
					 * If the customer doesn't exists and we didn't get the proper record with the ListID, unset the reference association, create a 'customeradd'
					 * service spool job and retire this service spool job
					 */
					if (!isset($lastReturn->ListID) || (string)$lastReturn->ListID == '') {

						/**
						 * Ok, we got the customer id, now to remove this bogus reference
						 */
						if (!$this->unsetAccountingReference($this->spoolData['accountingspoolnodeid'], 'customer')) {
							throw new Exception('Cannot unset the reference data for the CustomerMod spool ' . $this->spoolId);
						}

						/**
						 * Now create the customeradd child service
						 */
						$addSpoolId = $this->createChildSpool('customer', 'add', $this->spoolData['accountingspoolnode']);

						if (isId($addSpoolId)) {
							if ($this->execSibling($serviceOutput, 'customeradd', 'run', array('spoolId' => $addSpoolId))) {
								return $serviceOutput;
							} else {
								throw new Exception('Failed in running the child service CustomerAdd for the parent CustomerMod spool ' . $this->spoolId);
							}
						}

						throw new Exception('Failed in requesting the child service CustomerAdd for the parent CustomerMod spool ' . $this->spoolId);

					/**
					 * Else if we got a proper record, reset the reference association and stick the proper ListID back into the spool file
					 */
					} else {

						$referencedata = array(
							'ListID'		=> (string)$lastReturn->ListID,
							'EditSequence'	=> (string)$lastReturn->EditSequence
						);

						if (!$this->setAccountingReference($this->spoolData['accountingspoolnodeid'], 'customer', $referencedata)) {
							throw new Exception('Cannot reset the reference data for the CustomerMod spool ' . $this->spoolId);
						}

						/**
						 * Continue with this service
						 */
					}
					break;
				}

				case 'customeradd':
				case 'customermod': {

					/**
					 * Ok, the preious services have already created this record so there is no need to run this job Force this spool as executed
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
		 * If QuickBooks cannot find our customer then query it for the proper information with the 'customerquery' service
		 */
		if (($code = parent::handleResponse()) !== true) {

			/**
			 * 3120 means the record cannot be found and 3200 means that the EditSequence is out of sync. Either way the reference data is stale
			 */
			if ($code == 3120 || $code == 3200) {

				/**
				 * Ok, we didn't find a match. Run the "customerquery" service and associate it with this service
				 */
				$querySpoolId = $this->createChildSpool('customer', 'query', $this->spoolData['accountingspoolnode']);

				if (isId($querySpoolId)) {
					return true;
				}

				throw new Exception('Cannot initiate an "CustomerQuery" override service for the CustomerMod spool ' . $this->spoolId);
			}

			throw new Exception('An error occured when trying to handle the response from the CustomerMod spool ' . $this->spoolId);
		}

		/**
		 * Save the ref id if we can. Find the customer first using their email address and then associate the ref id with that customer. This should not determine
		 * the outcome of this mehtod as the customer has already been inserted into QuickBooks by now
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

		throw new Exception('Cannot update the customer using the information in the CustomerMod spool ' . $this->spoolId);
	}
}

?>
