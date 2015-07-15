<?php

class ACCOUNTING_QUICKBOOKS_SERVICES_PRICELEVELMOD extends ACCOUNTING_QUICKBOOKS_SERVICES_BASE
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
		if (!$this->isChildServiceInSpool('priceleveladd', $children) && !$this->getAccountingReference($this->spoolData['accountingspoolnodeid'], 'customergroup')) {

			/**
			 * Create the spool
			 */
			$addSpoolId = $this->createChildSpool('customergroup', 'add', $this->spoolData['accountingspoolnode']);

			/**
			 * Now execute it
			 */
			if (isId($addSpoolId)) {
				if ($this->execSibling($serviceOutput, 'priceleveladd', 'run', array('spoolId' => $addSpoolId))) {
					return $serviceOutput;
				} else {
					throw new Exception('Failed in running the child service PriceLevelAdd for the PriceLevelMod spool ' . $this->spoolId);
				}
			}

			throw new Exception('Cannot initialise new child service "PriceLevelAdd" for PriceLevelMod spool ' . $this->spoolId);
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
				case 'pricelevelquery': {

					/**
					 * If the customer doesn't exists and we didn't get the proper record with the ListID, unset the reference association, create a 'customeradd'
					 * service spool job and retire this service spool job
					 */
					if (!isset($lastReturn->ListID) || $lastReturn->ListID == '') {

						/**
						 * Ok, we got the customergroup id, now to remove this bogus reference
						 */
						if (!$this->unsetAccountingReference($this->spoolData['accountingspoolnodeid'], 'customergroup')) {
							throw new Exception('Cannot unset the reference data for the PriceLevelMod spool ' . $this->spoolId);
						}

						/**
						 * Now create the customeradd child service
						 */
						$addSpoolId = $this->createChildSpool('customergroup', 'add', $this->spoolData['accountingspoolnode']);

						if (isId($addSpoolId)) {
							if ($this->execSibling($serviceOutput, 'priceleveladd', 'run', array('spoolId' => $addSpoolId))) {
								return $serviceOutput;
							} else {
								throw new Exception('Failed in running the child service PriceLevelAdd for the parent PriceLevelMod spool ' . $this->spoolId);
							}
						}

						throw new Exception('Failed in requesting the child service PriceLevelAdd for the parent PriceLevelMod spool ' . $this->spoolId);

					/**
					 * Else if we got a proper record, reset the reference association and stick the proper ListID back into the spool file
					 */
					} else {

						$referencedata = array(
							'ListID'		=> (string)$lastReturn->ListID,
							'EditSequence'	=> (string)$lastReturn->EditSequence
						);

						if (!$this->setAccountingReference($this->spoolData['accountingspoolnodeid'], 'customergroup', $referencedata)) {
							throw new Exception('Cannot reset the reference data for the PriceLevelMod spool ' . $this->spoolId);
						}

						/**
						 * Continue with this service
						 */
					}
					break;
				}

				case 'priceleveladd':
				case 'pricelevelmod': {

					/**
					 * Ok, the priceleveladd service has created this record so there is no need to run this customeradd job Force this spool as executed
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
				$querySpoolId = $this->createChildSpool('customergroup', 'query', $this->spoolData['accountingspoolnode']);

				if (isId($querySpoolId)) {
					return true;
				}

				throw new Exception('Cannot initiate an "PriceLevelQuery" override service for the PriceLevelMod spool ' . $this->spoolId);
			}

			throw new Exception('An error occured when trying to handle the response from the PriceLevelMod spool ' . $this->spoolId);
		}

		/**
		 * Save the ref id if we can. Find the customer group first using the name and then associate the ref id with that customer group. This should not determine
		 * the outcome of this mehtod as the customer group has already been inserted into QuickBooks by now
		 */
		$listid		= trim(@(string)$this->data->info->PriceLevelRet->ListID);
		$sequence	= trim(@(string)$this->data->info->PriceLevelRet->EditSequence);

		if ($listid !== '' && $sequence !== '') {

			$reference = array(
				'ListID'	=> $listid,
				'EditSequence'	=> $sequence
			);

			$this->quickbooks->setAccountingReference($this->spoolData['accountingspoolnodeid'], 'customergroup', $reference);

			return true;
		}

		throw new Exception('Cannot insert the customer using the information in the PriceLevelMod spool ' . $this->spoolId);
	}
}

?>
