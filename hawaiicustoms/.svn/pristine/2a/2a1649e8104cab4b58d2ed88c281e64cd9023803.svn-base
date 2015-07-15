<?php

class ACCOUNTING_QUICKBOOKS_HANDLERS_GETLASTERROR extends ACCOUNTING_QUICKBOOKS_HANDLERS_BASE
{
	protected $inputVars = array('ticket');

	/**
	 * Handle the handler operation
	 *
	 * Method is the main function that will do the getLastError handling
	 *
	 * @access protected
	 * @return object The getLastErrorResultSOAPOut object containing the getLastError result
	 */
	protected function handle()
	{
		/**
		 * Do our authenticity check
		 */
		if (!$this->check()) {
			return new getLastErrorResultSOAPOut();
		}

		$msg = $this->quickbooks->getAccountingSessionKey('LAST_ERROR');

		if ($msg !== '') {
			return new getLastErrorResultSOAPOut($msg);
		}

		return new getLastErrorResultSOAPOut();
	}
}

/**
 * The SOAP output object
 *
 * Class is the getLastError SOAP output object
 */
class getLastErrorResultSOAPOut
{
	public $getLastErrorResult;

	public function __construct($msg='')
	{
		$this->getLastErrorResult = $msg;
	}
}

?>