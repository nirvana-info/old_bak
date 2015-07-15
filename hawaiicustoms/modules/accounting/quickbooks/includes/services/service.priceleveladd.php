<?php

class ACCOUNTING_QUICKBOOKS_SERVICES_PRICELEVELADD extends ACCOUNTING_QUICKBOOKS_SERVICES_BASE
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
				case 'pricelevelquery': {

					/**
					 * If the customer already exists and we got the proper record with the ListID, create the reference association, create a 'customermod'
					 * service spool job and retire this service spool job
					 */
					if (!isset($lastReturn->ListID) || (string)$lastReturn->ListID == '') {
						throw new Exception('Duplicate entry yet the child service PriceLevelQuery did not return a record for PriceLevelAdd spool ' . $this->spoolId);
					}

					$reference = array(
						'ListID'		=> (string)$lastReturn->ListID,
						'EditSequence'	=> (string)$lastReturn->EditSequence
					);

					if (!$this->setAccountingReference($this->spoolData['accountingspoolnodeid'], 'customergroup', $reference)) {
						throw new Exception('Cannot set the reference association for PriceLevelAdd spool ' . $this->spoolId);
					}

					/**
					 * Now create the customermod child service
					 */
					$editSpoolId = $this->createChildSpool('customergroup', 'edit', $this->spoolData['accountingspoolnode']);

					if (isId($editSpoolId)) {
						if ($this->execSibling($serviceOutput, 'pricelevelmod', 'run', array('spoolId' => $editSpoolId))) {
							return $serviceOutput;
						} else {
							throw new Exception('Failed in running the child service PriceLevelMod for the parent PriceLevelAdd spool ' . $this->spoolId);
						}
					}

					throw new Exception('Failed in requesting the child service PriceLevelMod for the parent PriceLevelAdd spool ' . $this->spoolId);

					break;

				}

				case 'pricelevelmod': {

					/**
					 * Ok, the pricelevelmod service has created this record so there is no need to run this priceleveladd job Force this spool as executed
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
				 * Just quickly check to see if we already have the ListID for this customer group first. If we do then we just saved a 'pricelevelquery' SOAP call
				 */
				$reference = $this->getAccountingReference($this->spoolData['accountingspoolnodeid'], 'customergroup');
				if ($reference) {

					/**
					 * Run our 'pricelevelmod' service with this information. Add this job as a child
					 */
					$editSpoolId = $this->createChildSpool('customergroup', 'edit', $this->spoolData['accountingspoolnode']);

					if (isId($editSpoolId)) {
						return true;
					}

					throw new Exception('Cannot initiate an "PriceLEvelMod" override service for the PriceLevelAdd spool ' . $this->spoolId);
				}

				$servicedata = array(
					'info' => $object
				);

				/**
				 * Ok, we didn't find a match. Run the "pricelevelquery" service and associate it with this service
				 */
				$querySpoolId = $this->createChildSpool('customergroup', 'query', $this->spoolData['accountingspoolnode']);

				if (isId($querySpoolId)) {
					return true;
				}

				throw new Exception('Cannot initiate an "PriceLevelQuery" override service for the PriceLevelAdd spool ' . $this->spoolId);
			}

			throw new Exception('An error occured when trying to handle the response from the PriceLevelAdd spool ' . $this->spoolId);
		}

		/**
		 * Customer group was successfully added, now all we need to do is to store the association information for this customer group
		 */
		$listid		= trim(@(string)$this->data->info->PriceLevelRet->ListID);
		$sequence	= trim(@(string)$this->data->info->PriceLevelRet->EditSequence);

		if ($listid !== '' && $sequence !== '') {

			$reference = array(
				'ListID'	=> $listid,
				'EditSequence'	=> $sequence
			);

			$this->setAccountingReference($this->spoolData['accountingspoolnodeid'], 'customergroup', $reference);

			return true;
		}

		throw new Exception('Cannot insert the customer group using the information in the PriceLEvelAdd spool ' . $this->spoolId);
	}
}

?>
