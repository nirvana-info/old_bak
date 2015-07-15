<?php

abstract class ACCOUNTING_QUICKBOOKS_ENTITIES_BASE extends ISC_SERVICEHANDLER_SERVICES
{
	protected $quickbooks;
	protected $xmlNode;

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

		GetModuleById('accounting', $this->quickbooks, 'accounting_quickbooks');

		$this->xmlNode = new XMLWriter();
		$this->xmlNode->openMemory();
	}

	/**
	 * Create an XML node with CDATA in it
	 *
	 * Method will create an XML node called $name with CDATA $value
	 *
	 * @access protected
	 * @param string $name The XML Node name
	 * @param string $value The XML Node value
	 * @return void
	 */
	protected function writeElementCData($name, $value)
	{
		$this->xmlNode->startElement($name);
		$this->xmlNode->writeCData(utf8_encode($value));
		$this->xmlNode->endElement();
	}

	/**
	 * Output the service XML
	 *
	 * Method will construct the XML string using the information stored in $this->xmlNode and return the XML string
	 *
	 * @access protected
	 * @param bool $isQuery TRUE if this service is a query, FALSE if not (add, mod, etc). Default is FALSE
	 * @return string The constructed XML string
	 */
	protected function buildOutput($isQuery=false)
	{
		/**
		 * Add the replacement for the client's qbXML version
		 */
		$clientVersion = $this->quickbooks->getAccountingSessionKey('QBXML_VERSION');
		$clientCountry = $this->quickbooks->getAccountingSessionKey('CLIENT_COUNTRY');

		/**
		 * If this version 2-3 and where are UK/CA then we need to prepend the country code in the version
		 */
		if ((isc_strtolower($clientCountry) == "uk" || isc_strtolower($clientCountry) == "ca") && version_compare($clientVersion, "3.0") !== 1) {
			$version = isc_strtoupper($clientCountry) . (string)$clientVersion;
		} else {
			$version = (string)$clientVersion;
		}

		$GLOBALS['VersionNo'] = $version;
		$GLOBALS['EntityType'] = $this->data->service;
		$GLOBALS['EntityXML'] = $this->xmlNode->outputMemory(true);

		$xml = $this->quickbooks->ParseTemplate('module.quickbooks.qbxml', true);

		/**
		 * If this is a query then remove the <$this->data->service> tags. Why can't everything be the same
		 */
		if ($isQuery) {
			$xml = str_replace('<' . $this->data->service . '>', '', $xml);
			$xml = str_replace('</' . $this->data->service . '>', '', $xml);
		}

		return $xml;
	}
}

?>