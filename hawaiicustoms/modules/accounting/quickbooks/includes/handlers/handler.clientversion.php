<?php

class ACCOUNTING_QUICKBOOKS_HANDLERS_CLIENTVERSION extends ACCOUNTING_QUICKBOOKS_HANDLERS_BASE
{
	protected $inputVars = array('strVersion');

	/**
	 * Handle the handler operation
	 *
	 * Method is the main function that will do the clientVersion handling
	 *
	 * @access protected
	 * @return object The clientVersionResultSOAPOut object containing the clientVersion result
	 */
	protected function handle()
	{
		/**
		 * Check for required version field
		 */
		if (!$this->checkInput() || $this->data->strVersion == '') {
			return $this->errorClientVersion(GetLang('QuickBooksClientVersionErrorMissing'));
		}

		/**
		 * Do we have a supported version?
		 */
		if (version_compare($this->data->strVersion, ___MODULE_QB_SUPPORTED_VERSION___) === -1) {
			return $this->errorClientVersion(sprintf(GetLang('QuickBooksClientVersionUnsupported'), $this->data->strVersion, GetConfig('QuickBooksClientSupportedVersion')));
		}

		/**
		 * We have a version that we can use
		 */
		return $this->passClientVersion();
	}

	/**
	 * Error return SOAP object
	 *
	 * Method will return the error SOAP object
	 *
	 * @access private
	 * @param string $msg The message to put in the error message
	 * @return object The error clientVersionResultSOAPOut object
	 */
	private function errorClientVersion($msg)
	{
		return new clientVersionResultSOAPOut('E:' . $msg);
	}

	/**
	 * Warn return SOAP object
	 *
	 * Method will return the warning SOAP object
	 *
	 * @access private
	 * @param string $msg The message to put in the warning message
	 * @return object The warn clientVersionResultSOAPOut object
	 */
	private function warnClientVersion($msg)
	{
		return new clientVersionResultSOAPOut('W:' . $msg);
	}

	/**
	 * OK return SOAP object
	 *
	 * Method will return the OK SOAP object
	 *
	 * @access private
	 * @return object The OK clientVersionResultSOAPOut object
	 */
	private function okClientVersion()
	{
		return new clientVersionResultSOAPOut('O:' . GetConfig('QuickBooksClientLatestVersion'));
	}

	/**
	 * Pass return SOAP object
	 *
	 * Method will return the pass SOAP object
	 *
	 * @access private
	 * @return object The pass clientVersionResultSOAPOut object
	 */
	private function passClientVersion()
	{
		return new clientVersionResultSOAPOut();
	}
}

/**
 * The SOAP output object
 *
 * Class is the clientVersion SOAP output object
 */
class clientVersionResultSOAPOut
{
	public $clientVersionResult;

	public function __construct($msg='')
	{
		$this->clientVersionResult = $msg;
	}
}

?>