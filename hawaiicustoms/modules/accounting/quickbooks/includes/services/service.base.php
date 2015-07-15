<?php

abstract class ACCOUNTING_QUICKBOOKS_SERVICES_BASE extends ISC_SERVICEHANDLER_SERVICES
{
	protected $entity;
	protected $quickbooks;
	protected $spoolId;
	protected $spoolData;

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

		$this->entity = new ACCOUNTING_QUICKBOOKS_ENTITIES();

		GetModuleById('accounting', $this->quickbooks, 'accounting_quickbooks');

		/**
		 * Now assign the spool data
		 */
		$this->spoolId = $this->data->spoolId;
		$this->spoolData = $this->quickbooks->getAccountingSpool($this->data->spoolId);
	}

	/**
	 * Base method for handling the response XML
	 *
	 * Method will decide weather or not the response XML was a success and to handle all the logging. If the response was a success then the job
	 * file will be removed, else the job file will be marked as failed
	 *
	 * @access protected
	 * @return mixed true if the response was a success, the status error code if the response failed
	 */
	protected function handleResponse()
	{
		$attribs = $this->data->info->attributes();

		/**
		 * Check to see if this request was unsuccessful
		 */
		if ((int)$attribs['statusCode'] > 0) {

			/**
			 * Mark this job as failed
			 */
			$this->quickbooks->setSpoolAsFailed($this->data->spoolId, html_entity_decode($attribs['statusMessage']), (int)$attribs['statusCode']);
			return (int)$attribs['statusCode'];
		}

		return true;
	}

	/**
	 * Set a child spool
	 *
	 * Method will set a child spool
	 *
	 * @access protected
	 * @param string $type The node type (customer, product, order, etc)
	 * @param string $service The node service. This is module dependent
	 * @param mixed $nodeid The node ID OR an array containing information about the node
	 * @param bool $setAsCurrent TRUE to set this child spool as the current spool, FALSE not to. Default is TRUE
	 * @return int The spool ID if the data was successfully written, FASLE othereise
	 */
	protected function createChildSpool($type, $service, $nodeid, $setAsCurrent=true)
	{
		$spoolId = $this->quickbooks->setAccountingSpool($type, $service, $nodeid, $this->data->spoolId, true);
		if (!isId($spoolId)) {
			return false;
		}

		/**
		 * Now mark it as the current spool if we can
		 */
		if ($setAsCurrent) {
			if (!$this->quickbooks->setCurrentSpool($spoolId)) {
				return false;
			}
		}

		return $spoolId;
	}

	/**
	 * Get the spool session data
	 *
	 * Method will get the saved spool session data
	 *
	 * @access protected
	 * @param int $spoolId The spool ID that is associated with this data
	 * @return object The spool return SimpleXML object on success, FALSE on failure
	 */
	protected function getAccountingSpoolReturn($spoolId)
	{
		return $this->quickbooks->getAccountingSpoolReturn($spoolId);
	}

	/**
	 * Set the spool session data
	 *
	 * Method will set the saved spool session data
	 *
	 * @access protected
	 * @param int $spoolId The spool ID that is associated with this data
	 * @param mixed $input The data to store
	 * @return bool TRUE if the data was successfully stored, FALSE otherwise
	 */
	protected function setAccountingSpoolReturn($spoolId, $input)
	{
		return $this->quickbooks->setAccountingSpoolReturn($spoolId, $input);
	}

	/**
	 * Get child spool service
	 *
	 * Method will get the child spool that is associated with this job
	 *
	 * @access protected
	 * @param int $spoolId The spool ID
	 * @return array An array of all the children accountingspool records, FALSE on failure
	 */
	protected function getAccountingSpoolChildren($spoolId)
	{
		if (!isId($spoolId)) {
			return false;
		}

		return $this->quickbooks->getAccountingSpoolChildren($spoolId);
	}

	/**
	 * Set a child service
	 *
	 * Method will set a child spool $spoolId to the spool $parentSpoolId
	 *
	 * @access protected
	 * @param mixed $spoolId The child spool ID
	 * @param int $parentSpoolId The parent spool ID
	 * @param bool $setAsAvailable TRUE to set the new child spool as the current spool. Default is TRUE
	 * @return bool TRUE if the child was added successfully, FALSE otherwise
	 */
	protected function setAccountingSpoolChildren($parentSpoolId, $spoolId, $setAsAvailable=true)
	{
		if (!isId($parentSpoolId) || !isID($spoolId)) {
			return false;
		}

		if (!$this->quickbooks->setAccountingSpoolChildren($parentSpoolId, $spoolId)) {
			return false;
		}

		if ($setAsAvailable) {
			$this->quickbooks->setCurrentSpool($spoolID);
		}

		return true;
	}

	/**
	 * Does child service already exist in this spool
	 *
	 * Method will check to see if the child service $service already exists in this spool
	 *
	 * @access public
	 * @param string $service The child service
	 * @return array The accountingspool child record if the child service exists, NULL if not, FALSE on error
	 */
	protected function isChildServiceInSpool($service)
	{
		if ($service == '') {
			return false;
		}

		return $this->quickbooks->isChildServiceInSpool($this->data->spoolId, $service);
	}

	/**
	 * Get the placecard value
	 *
	 * Method will get the placecard value to be replaced by thye ListID
	 *
	 * @access protected
	 * @param string $val The value to get
	 * @param string $getVal 'nodeid' to return the nodeid, 'type' for the type, 'refkey' for the reference key, '*' for the whole array. Default is 'nodeid'
	 * @return string The integer value on success, the original value otherwise
	 */
	protected function getPlaceCard($val, $getVal='nodeid')
	{
		return $this->quickbooks->getPlaceCard($val, $getVal);
	}

	/**
	 * Set the placecard value
	 *
	 * Method will set the placecard value
	 *
	 * @access protected
	 * @param string $type The type of the node
	 * @param int $nodeid The node ID
	 * @param string $refkey The reference key to associate with this node ID
	 * @return int The set placecard value
	 */
	protected function setPlaceCard($type, $nodeid, $refkey)
	{
		return $this->quickbooks->setPlaceCard($type, $nodeid, $refkey);
	}

	/**
	 * Convert all placecards within a string
	 *
	 * Method will convert all placecards within a given string
	 *
	 * @access protected
	 * @param string &$str The referenced string to do the replacements with
	 * @return int The amount of relacements done
	 */
	protected function convertPlaceCards(&$str)
	{
		return $this->quickbooks->convertPlaceCards($str);
	}

	/**
	 * Get an accounting reference item
	 *
	 * Method will return an accounting reference record
	 *
	 * @access public
	 * @param int $nodeid The ID of the referenced item (customer id, order id, etc)
	 * @param string $type The node type (customer, product or order)
	 * @return bool true if the reference value was found, fALSE otherwise
	 */
	public function getAccountingReference($nodeid, $type)
	{
		return $this->quickbooks->getAccountingReference($nodeid, $type);
	}

	/**
	 * Set an accounting reference
	 *
	 * Method will set an accounting reference record
	 *
	 * @access public
	 * @param int $nodeid The ID of the referenced item (customer id, order id, etc)
	 * @param string $type The node type (customer, product or order)
	 * @param mixed $reference The reference value to store (its not referrenced!)
	 * @return int The accountref record ID if the record is unique and was inserted, false otherwise
	 */
	public function setAccountingReference($nodeid, $type, $reference)
	{
		return $this->quickbooks->setAccountingReference($nodeid, $type, $reference);
	}

	/**
	 * Unset an accounting reference item
	 *
	 * Method will unset an accounting reference record
	 *
	 * @access public
	 * @param int $nodeid The ID of the referenced item (customer id, order id, etc)
	 * @param string $type The node type (customer, product or order)
	 * @return bool true if the accountingref record was unset (deleted), FALSE otherwise
	 */
	public function unsetAccountingReference($nodeid, $type)
	{
		return $this->quickbooks->unsetAccountingReference($nodeid, $type);
	}

	/**
	 * Escape the current spool
	 *
	 * Method will escape the current spool. This is only valid for a previous executed child service that has made the parent
	 * no longer valid (the child did the parents work). This function will not work if this spool has no children
	 *
	 * @access protected
	 * @param int $spoolID The spool ID
	 * @return bool TRUE if the spool was successfully escaped, FALSE if job cannot be found or has no children
	 */
	protected function escapeService($spoolId)
	{
		if (!isId($spoolId)) {
			return false;
		}

		$children = $this->getAccountingSpoolChildren($spoolId);

		if (!is_array($children) || empty($children)) {
			return false;
		}

		/**
		 * Set it done in the session
		 */
		$rtn = $this->quickbooks->setSpoolAsExecuted($spoolId);

		/**
		 * Set the child savedata to the parent
		 */
		$return = $children[count($children)-1]['accountingspoolreturn'];
		if (is_object($return) && method_exists($return, 'asXML')) {
			$this->quickbooks->setAccountingSpoolReturn($spoolId, $return);
		}

		return true;
	}

	/**
	 * Manage the service output
	 *
	 * Method will manage the service outout
	 *
	 * @access protected
	 * @return string The service output
	 */
	protected function manageServiceOutput()
	{
		$status = $this->quickbooks->getAccountingSpoolStatus($this->data->spoolId);

		/**
		 * If this job is no longer available then either execute the next available job or return an empty string
		 */
		if ($status === 1) {
			if ($nextSpool = $this->quickbooks->getNextSpool($this->data->spoolId)) {
				$this->quickbooks->setCurrentSpool($nextSpool['accountingspoolid']);
				$nextService = $this->quickbooks->getSpoolService($nextSpool['accountingspoolid']);
				if ($nextService !== '' && $this->execSibling($output, $nextService, 'run', array('spoolId' => $nextSpool['accountingspoolid']))) {
					return $output;
				}
			}

			return '';
		}

		/**
		 * See which method we are going to execute in the entity
		 */
		$thisService = $this->spoolData['accountingspoolrealservice'];
		if (substr(isc_strtolower($thisService), -5) == 'query') {
			$func = 'xmlquery';
		} else {
			$func = 'xml';
		}

		/**
		 * Now run it
		 */
		$data = array(
			'nodeId' => $this->spoolData['accountingspoolnodeid'],
			'service' => $this->spoolData['accountingspoolrealservice'],
			'nodeData' => $this->spoolData['accountingspoolnode']
		);

		$this->entity->exec($xml, $this->spoolData['accountingspooltype'], $func, $data);

		if ($xml !== '') {
			return $xml;
		} else {
			throw new Exception('Cannot execute the spool file ' . $this->data->spoolId);
		}
	}

	/**
	 * Convert a SimpleXML object into an associative array
	 *
	 * Method will recursively convert a SimpleXML object into an associative array
	 *
	 * @access protected
	 * @param object $obj The SimpleXML object
	 * @return array The converted array on success, false otherwise
	 */
	protected function xml2array($obj)
	{
		if (!is_object($obj)) {
			return false;
		}

		$arr = array();

		foreach ($obj->children() as $tag => $val) {
			if (count($val->children())) {
				$arr[$tag] = $this->xml2array($val);
			} else {
				$arr[$tag] = (string)$val;
			}
		}

		return $arr;
	}

	abstract protected function run();
	abstract protected function response();
}

?>
