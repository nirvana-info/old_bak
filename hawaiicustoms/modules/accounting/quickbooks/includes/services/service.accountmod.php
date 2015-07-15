<?php

class ACCOUNTING_QUICKBOOKS_SERVICES_ACCOUNTMOD extends ACCOUNTING_QUICKBOOKS_SERVICES_BASE
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
		 * Check to see if we have a account and if its not set in QuickBooks
		 */
		if (!$this->isChildServiceInSpool('accountadd') && !$this->getAccountingReference($this->spoolData['accountingspoolnode'], 'account')) {

			/**
			 * Create the spool
			 */
			$addSpoolId = $this->createChildSpool('account', 'add', $this->spoolData['accountingspoolnode']);

			/**
			 * Now execute it
			 */
			if (isId($addSpoolId)) {
				if ($this->execSibling($serviceOutput, 'accountadd', 'run', array('spoolId' => $addSpoolId))) {
					return $serviceOutput;
				} else {
					throw new Exception('Failed in running the child service AccountAdd for the parent AccountMod spool ' . $this->spoolId);
				}
			}
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
				case 'accountquery': {

					/**
					 * If the account doesn't exists and we didn't get the proper record with the ListID, unset the reference association, create a 'accountadd'
					 * service spool job and retire this service spool job
					 */
					if (!isset($lastReturn->ListID) || (string)$lastReturn->ListID == '') {

						/**
						 * Ok, we got the account id, now to remove this bogus reference
						 */
						if (!$this->unsetAccountingReference($this->spoolData['accountingspoolnode'], 'account')) {
							throw new Exception('Cannot unset the reference data for the AccountingMod spool ' . $this->spoolId);
						}

						/**
						 * Now create the iteminventoryadd child service
						 */
						$addSpoolId = $this->createChildSpool('account', 'add', $this->spoolData['accountingspoolnode']);

						if (isId($addSpoolId)) {
							if ($this->execSibling($serviceOutput, 'accountadd', 'run', array('spoolId' => $addSpoolId))) {
								return $serviceOutput;
							} else {
								throw new Exception('Failed in running the child service AccountAdd for the parent AccountMod spool ' . $this->spoolId);
							}
						}

						throw new Exception('Failed in requesting the child service AccountAdd for the parent AccountMod spool ' . $this->spoolId);

					/**
					 * Else if we got a proper record, reset the reference association and stick the proper ListID back into the spool file
					 */
					} else {

						$referencedata = array(
							'ListID'		=> (string)$lastReturn->ListID,
							'EditSequence'	=> (string)$lastReturn->EditSequence,
							'Name'			=> $this->spoolData['accountingspoolnode']['Name'],
							'AccountType'	=> $this->spoolData['accountingspoolnode']['AccountType'],
						);

						if (!$this->setAccountingReference($this->spoolData['accountingspoolnode'], 'account', $referencedata)) {
							throw new Exception('Cannot reset the reference data for the AccountMod spool ' . $this->spoolId);
						}

						/**
						 * Continue with this service
						 */
					}
					break;
				}

				case 'accountadd':
				case 'accountmod': {

					/**
					 * Ok, the accountadd service has created this record so there is no need to run this accountmod job Force this spool as executed
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
		 * If QuickBooks cannot find our account then query it for the proper information with the 'accountquery' service
		 */
		if (($code = parent::handleResponse()) !== true) {

			/**
			 * 3120 means the record cannot be found and 3200 means that the EditSequence is out of sync. Either way the reference data is stale
			 */
			if ($code == 3120 || $code == 3200) {

				/**
				 * Ok, we didn't find a match. Run the "accountquery" service and associate it with this service
				 */
				$querySpoolId = $this->createChildSpool('account', 'query', $this->spoolData['accountingspoolnode']);

				if (isId($querySpoolId)) {
					return true;
				}

				throw new Exception('Cannot initiate an "AccountQuery" override service for the AccountMod spool ' . $this->spoolId);
			}

			throw new Exception('An error occured when trying to handle the response from the AccountMod spool ' . $this->spoolId);
		}

		/**
		 * Save the ref id if we can. Find the account first using the name and then associate the ref id with that account. This should not determine
		 * the outcome of this mehtod as the account has already been inserted into QuickBooks by now
		 */
		$listid		= trim(@(string)$this->data->info->AccountRet->ListID);
		$sequence	= trim(@(string)$this->data->info->AccountRet->EditSequence);

		if ($listid !== '' && $sequence !== '') {

			$reference = array(
				'ListID'		=> $listid,
				'EditSequence'	=> $sequence,
				'Name'			=> $this->spoolData['accountingspoolnode']['Name'],
				'AccountType'	=> $this->spoolData['accountingspoolnode']['AccountType'],
			);

			$this->quickbooks->setAccountingReference($this->spoolData['accountingspoolnode'], 'account', $reference);

			return true;
		}

		throw new Exception('Cannot insert the account using the information in the AccountMod spool ' . $this->spoolId);
	}
}

?>