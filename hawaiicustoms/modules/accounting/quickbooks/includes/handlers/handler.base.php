<?php

abstract class ACCOUNTING_QUICKBOOKS_HANDLERS_BASE extends ISC_SERVICEHANDLER_SERVICES
{
	protected $service;
	protected $quickbooks;

	/**
	 * Constructor
	 *
	 * Base constructor
	 *
	 * @access public
	 * @param string $op The operation to preform
	 * @param array &$data The referenced data array
	 * @param array &$parent The referenced handler parent object
	 */
	public function __construct($op, &$data, &$parent)
	{
		parent::__construct($op, $data, $parent);

		$this->service = new ACCOUNTING_QUICKBOOKS_SERVICES();

		GetModuleById('accounting', $this->quickbooks, 'accounting_quickbooks');
	}

	/**
	 * Check user's authentication
	 *
	 * Method will compared the supplied uuid $this->data->ticket to the user's sessions stored uuid
	 *
	 * @access protected
	 * @return bool true if the uuids match, FALSE if they do not
	 */
	protected function checkAuthenticity()
	{
		$val = $this->quickbooks->getAccountingSessionKey('UUID');

		if (isset($this->data->ticket) && $val == $this->data->ticket) {
			return true;
		}

		return false;
	}

	/**
	 * Check input fields
	 *
	 * Method will check to see if the required imnput fields are present in the $this->data variable
	 *
	 * @access protected
	 * @return bool true if all fields are present, FALSE if not
	 */
	protected function checkInput()
	{
		if (!isset($this->inputVars) || !is_array($this->inputVars)) {
			return true;
		}

		foreach ($this->inputVars as $field) {
			if (!isset($this->data->$field)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Run full sanity check on authenticity and input fields
	 *
	 * Method will run an authenticity and input fields check. Return false on any failure
	 *
	 * @access protected
	 * @return bool true if all the checking is successful, FALSE if anything failured
	 */
	protected function check()
	{
		if ($this->checkInput() && $this->checkAuthenticity()) {
			return true;
		}

		$this->quickbooks->setAccountingSessionKey('LAST_ERROR', GetLang('QuickBooksGeneralErrorCheckFailed'));
		return false;
	}

	/**
	 * Get the last error in the service handler
	 *
	 * Method will return the last error within the service handler
	 *
	 * @access protected
	 * @return strng The last service error message
	 */
	protected function getServiceError()
	{
		return $this->service->getLastError();
	}

	/**
	 * Get the current spooled job
	 *
	 * Method will return the current spooled job
	 *
	 * @access protected
	 * @return array The current active spool if one is available, FALSE if not
	 */
	protected function getCurrentSpool()
	{
		return $this->quickbooks->getCurrentSpool();
	}

	/**
	 * Get the current spooled job
	 *
	 * Method will return the current spooled job
	 *
	 * @access protected
	 * @param int $id The id of the current spool
	 * @return bool true if the job was set, FALSE otherwsie
	 */
	protected function setCurrentSpool($id)
	{
		return $this->quickbooks->setCurrentSpool($id);
	}

	/**
	 * Sets a job as executed
	 *
	 * Method will set a job as executed
	 *
	 * @access protected
	 * @param int $id The id of the current spool
	 */
	protected function setSpoolAsExecuted($id)
	{
		return $this->quickbooks->setSpoolAsExecuted($id);
	}

	/**
	 * Set the current spool as done and sets the next spool
	 *
	 * Method will set the current spool as done and if we have any, set the next spool as the current spool
	 *
	 * @access protected
	 * @param string $originalSpoolId The original current spool when the receiveResponseXML handler was executed
	 */
	protected function assignNextService($originalSpoolId)
	{
		if (!$this->getCurrentSpool()) {

			/**
			 * Only go looking for a new job if we do not have a current job
			 */
			$nextSpool = $this->quickbooks->getNextSpool($originalSpoolId);
			if ($nextSpool) {
				$this->setCurrentSpool($nextSpool['accountingspoolid']);
			}
		}
	}

	abstract protected function handle();
}

?>
