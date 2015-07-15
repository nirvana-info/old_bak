<?php

class ACCOUNTING_QUICKBOOKS_SERVICES_ACCOUNTQUERY extends ACCOUNTING_QUICKBOOKS_SERVICES_BASE
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
		 * This service is kind of private and so would not have any children services associated with it
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
		 * This service is kind of private and so we don't need to worry about creating children services and so forth. Just parse and return true
		 * as this will always be a child service itself and will then get deleted automatically
		 */
		parent::handleResponse();

		return true;
	}
}

?>