<?php

class ACCOUNTING_QUICKBOOKS_SERVICES_INVENTORYADJUSTMENTADD extends ACCOUNTING_QUICKBOOKS_SERVICES_BASE
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
			throw new Exception('An error occured when trying to handle the response from the InventoryAdjustmentAdd spool ' . $this->data->spoolID);
		}

		return true;
	}
}

?>
