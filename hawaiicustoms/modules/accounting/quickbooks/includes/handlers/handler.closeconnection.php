<?php

class ACCOUNTING_QUICKBOOKS_HANDLERS_CLOSECONNECTION extends ACCOUNTING_QUICKBOOKS_HANDLERS_BASE
{
	protected $inputVars = array('ticket');

	/**
	 * Handle the handler operation
	 *
	 * Method is the main function that will do the closeConnection handling
	 *
	 * @access protected
	 * @return object The serverVersionResultSOAPOut object containing the closeConnection result
	 */
	protected function handle()
	{
		/**
		 * If we're not logged in then there is nothing to close
		 */
		if (!$this->check()) {
			return new closeConnectionResultSOAPOut("Unable to close connection");
		}

		/**
		 * Delete all our successfully executed jobs
		 */
		$this->quickbooks->removeExecutedSpool(true);

		/**
		 * Unset our session
		 */
		$this->quickbooks->unsetAccountingSession();

		/**
		 * Unset our lock file
		 */
		$this->quickbooks->unsetLockFile();

		return new closeConnectionResultSOAPOut("Interspire Shopping Cart connection closed successfully");
	}
}

/**
 * The SOAP output object
 *
 * Class is the serverVersion SOAP output object
 */
class closeConnectionResultSOAPOut
{
	public $closeConnectionResult;

	public function __construct($msg='')
	{
		$this->closeConnectionResult = $msg;
	}
}

?>
