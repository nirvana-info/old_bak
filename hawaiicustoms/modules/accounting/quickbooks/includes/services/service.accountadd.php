<?php

class ACCOUNTING_QUICKBOOKS_SERVICES_ACCOUNTADD extends ACCOUNTING_QUICKBOOKS_SERVICES_BASE
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
				case 'accountquery': {

					/**
					 * If the account already exists and we got the proper record with the ListID, create the reference association, create a 'accountmod'
					 * service spool job and retire this service spool job
					 */
					if (!isset($lastReturn->ListID) || (string)$lastReturn->ListID == '') {
						throw new Exception('Duplicate entry yet the child service AccountQuery did not return a record for AccountAdd spool ' . $this->spoolId);
					}

					$reference = array(
						'ListID'		=> (string)$lastReturn->ListID,
						'EditSequence'	=> (string)$lastReturn->EditSequence,
						'Name'			=> $this->spoolData['accountingspoolnode']['Name'],
						'AccountType'	=> $this->spoolData['accountingspoolnode']['AccountType'],
					);

					if (!$this->setAccountingReference($this->spoolData['accountingspoolnode'], 'account', $reference)) {
						throw new Exception('Cannot set the reference association for AccountAdd spool ' . $this->spoolId);
					}

					/**
					 * Now create the accountmod child service using this spools xml data. Only call this if we have version 6.0 or above!
					 */
					if ($this->quickbooks->compareClientVersion('6.0')) {
						$editSpoolId = $this->createChildSpool('account', 'edit', $reference);

						if (isId($editSpoolId)) {
							if ($this->execSibling($serviceOutput, 'accountmod', 'run', array('spoolId' => $editSpoolId))) {
								return $serviceOutput;
							} else {
								throw new Exception('Failed in running the child service AccountMod for the parent AccountAdd spool ' . $this->spoolId);
							}
						}

					/**
					 * Else we just escape it
					 */
					} else {
						$this->quickbooks->setSpoolAsExecuted($this->spoolId, true);
						$this->escapeService($this->spoolId);
					}

					break;
				}

				case 'accountmod': {

					/**
					 * Ok, the accountmod service has created this record so there is no need to run this accountadd job. Force this spool as executed
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
		 * services to 'edit' this account
		 */
		if (($code = parent::handleResponse()) !== true) {
			if ($code == 3100) {

				/**
				 * Just quickly check to see if we already have the ListID for this account first. If we do then we just saved a 'accountmod' SOAP call.
				 */
				$reference = $this->getAccountingReference($this->spoolData['accountingspoolnode'], 'account');
				if ($reference) {

					/**
					 * Only call the AccountMod if we have version 6.0 or above! If so then forcefully set this service as executed
					 */
					if (!$this->quickbooks->compareClientVersion('6.0')) {
						$this->quickbooks->setSpoolAsExecuted($this->spoolId, true);
						return true;
					}

					/**
					 * Run our 'accountmod' service with this information. Add this job as a child
					 */
					$editSpoolId = $this->createChildSpool('account', 'edit', $reference);

					if (isId($editSpoolId)) {
						return true;
					}

					throw new Exception('Cannot initiate an "AccountMod" override service for the AccountAdd spool ' . $this->spoolId);
				}

				/**
				 * Ok, we didn't find a match. Run the "accountquery" service and associate it with this service
				 */
				$querySpoolId = $this->createChildSpool('account', 'query', $this->spoolData['accountingspoolnode']);

				if (isId($querySpoolId)) {
					return true;
				}

				throw new Exception('Cannot initiate an "AccountQuery" override service for the AccountAdd spool ' . $this->spoolId);
			}

			throw new Exception('An error occured when trying to handle the response from the AccountAdd spool ' . $this->spoolId);
		}

		/**
		 * Account was successfully added, now all we need to do is to store the association information for this account
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

		throw new Exception('Cannot insert the account using the information in the AccountAdd spool ' . $this->spoolId);
	}
}

?>
