<?php

class ACCOUNTING_QUICKBOOKS_HANDLERS_SENDREQUESTXML extends ACCOUNTING_QUICKBOOKS_HANDLERS_BASE
{
	protected $inputVars = array('ticket', 'strHCPResponse', 'strCompanyFileName', 'qbXMLCountry', 'qbXMLMajorVers', 'qbXMLMinorVers');

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
	}

	/**
	 * Initial setup for services
	 *
	 * Method will initialise all the service handler. This must be called the first and only time that this class is used
	 *
	 * @access private
	 * @return bool TRUE if the initialisation is successful, FALSE if not
	 */
	private function initSpoolImport()
	{
		/**
		 * If we don't have a valid qbXML and client country then we have to bail
		 */
		if (($this->data->qbXMLMajorVers . $this->data->qbXMLMinorVers) == '' || $this->data->qbXMLCountry == '') {
			$this->quickbooks->setAccountingSessionKey('LAST_ERROR', GetLang('QuickBooksSendXMLErrorNoVersionInfo'));
			return false;
		}

		/**
		 * Save our qbXML version so we can return the same qbXML version back. Store it as a compiled string so we can use version_compare()
		 */
		$this->quickbooks->setAccountingSessionKey('QBXML_VERSION', $this->data->qbXMLMajorVers . '.' . $this->data->qbXMLMinorVers);

		/**
		 * Also save the clients country version of their QuickBooks
		 */
		$this->quickbooks->setAccountingSessionKey('CLIENT_COUNTRY', $this->data->qbXMLCountry);

		/**
		 * Also store the company data, just in case if we need it
		 */
		$this->quickbooks->setAccountingSessionKey('COMPANY_DATA', $this->data->strHCPResponse);

		/**
		 * Remove any jobs that were executed. This is a fallback just in case we didn't exit out cleanly last time
		 */
		$this->quickbooks->removeExecutedSpool();

		/**
		 * Now to setup our import spool list
		 */
		return $this->quickbooks->setAccountingSpoolImport();
	}

	/**
	 * Executed a spool
	 *
	 * Method will execute a spool and return the output
	 *
	 * @access private
	 * @param int $spoolId The spool ID
	 * @return string The spool XML string if the spool was executed successfully, FALSE otherwise
	 */
	private function execSpoolImport($spoolId)
	{
		if (!isId($spoolId)) {
			return false;
		}

		$service = $this->quickbooks->getSpoolService($spoolId);

		if (!$service) {
			return false;
		}

		if ($this->service->exec($xml, $service, 'run', array('spoolId' => $spoolId))) {
			return $xml;
		}

		return false;
	}

	/**
	 * Handle the handler operation
	 *
	 * Method is the main function that will do the sendRequestXML handling
	 *
	 * @access protected
	 * @return object The sendRequestXMLResultSOAPOut object containing the clientVersion result
	 */
	protected function handle()
	{
		/**
		 * Do our authenticity check
		 */
		if (!$this->check()) {
			return new sendRequestXMLResultSOAPOut();
		}

		/**
		 * If this is the first time that this handler is executed within this session, then we will be given an XML string containing the
		 * company data
		 */
		if ($this->data->strHCPResponse !== '') {
			if (!$this->initSpoolImport()) {
				$this->quickbooks->setAccountingSessionKey('LAST_ERROR', GetLang('QuickBooksSendXMLErrorInitialising'));
				return new sendRequestXMLResultSOAPOut();
			}
		}

		/**
		 * Ok, now we check to see if we have a spool job that we can send back. If we have one but failed to generate the XML then call NoOp as
		 * the error should already be stored
		 */
		if ($spool = $this->getCurrentSpool()) {
			$xml = $this->execSpoolImport($spool['accountingspoolid']);
			if (trim($xml) !== '') {
				return new sendRequestXMLResultSOAPOut($xml);
			} else {
				$this->quickbooks->setAccountingSessionKey('LAST_ERROR', $this->getServiceError());
				return new sendRequestXMLResultSOAPOut();
			}
		}

		return new sendRequestXMLResultSOAPOut();
	}
}

/**
 * The SOAP output object
 *
 * Class is the serverVersion SOAP output object
 */
class sendRequestXMLResultSOAPOut
{
	public $sendRequestXMLResult;

	public function __construct($msg='')
	{
		$this->sendRequestXMLResult = $msg;
	}
}

?>
