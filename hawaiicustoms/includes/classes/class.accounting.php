<?php

require_once(dirname(__FILE__).'/class.module.php');

if (!defined('ISC_ACCOUNTING_SPOOLS_PER_PAGE')) {
	define('ISC_ACCOUNTING_SPOOLS_PER_PAGE', 20);
}

/**
* The Interspire Shopping Cart accounting base class, used by all accounting modules
*/
class ISC_ACCOUNTING extends ISC_MODULE
{
	/*
		The url of the accounting module
	*/
	public $_url = "";

	/**
	* @var string $type The type of module this is
	*/
	public $type = 'accounting';

	/*
		The module's file name
	*/
	public $_file = "";

	public $_image = "";

	protected $spoolPath;

	public function __construct()
	{
		parent::__construct();

		$this->spoolPath = ISC_BASE_PATH . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'spool';
	}

	/*
		Return the URL of the accounting module
	*/
	public function geturl()
	{
		return $this->_url;
	}

	/*
		Return the file name of the accounting module
	*/
	public function getfile()
	{
		return $this->_file;
	}

	/*
		Load any saved values from the database and put them into the savedvalue attribute of the custom variable
	*/
	public function loadAccountingVars()
	{
		$this->LoadCustomVars();
	}

	public function CheckEnabled()
	{
		$accounting_methods = explode(",", GetConfig('AccountingMethods'));
		if(in_array($this->getid(), $accounting_methods)) {
			return true;
		}
		else {
			return false;
		}
	}

	/*
		Return a HTML-formatted list of properties for this Accounting module
	*/
	public function GetPropertiesSheet($tab_id)
	{
		$this->tabId = $tab_id;

		$GLOBALS['AccountingJavaScript'] = "";
		$GLOBALS['HelpText'] = $this->gethelptext();
		$GLOBALS['HelpIcon'] = "success";
		$GLOBALS['Properties'] = "";
		$GLOBALS['ShipperId'] = $this->GetName();

		$mod_dir = str_replace($this->type.'_', '', $this->GetId());

		$GLOBALS['HideSelectAllLinks'] = 'display: none';

		// Add the logo
		$image = $this->GetImage();
		if ($image != "") {
			$GLOBALS['HelpTip'] = "";
			$GLOBALS['PropertyBox'] = sprintf("<img style='margin-top:5px' src='%s' />", $this->GetImage());
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.property");
			$GLOBALS['Properties'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		foreach ($this->GetCustomVars() as $id=>$var) {
			/**
			 * Check for a heading
			 */
			if (array_key_exists('heading', $var)) {
				$GLOBALS['Properties'] .= '<tr><td colspan="2">&nbsp;</td></tr>';
				$GLOBALS['Properties'] .= '<tr><td class="Heading2" colspan="2">' . htmlentities($var['heading']) . '</td></tr>';
			}

			$GLOBALS['PropertyBox'] = "";
			$GLOBALS['PropertyName'] = $var['name'] . ":";
			$GLOBALS['HelpTip'] = "";
			$GLOBALS['FieldId'] = $this->GetId().'_'.$id;

			if($var['type'] == 'dropdown' && isset($var['multiselect']) && $var['multiselect'] == true) {
				$GLOBALS['HideSelectAllLinks'] = '';
			}
			else {
				$GLOBALS['HideSelectAllLinks'] = 'display: none';
			}

			$GLOBALS['PropertyBox'] = $this->_buildformitem($id, $var, false);
			$help_id = rand(1000,100000);

			if ($var['help'] != "") {
				$GLOBALS['HelpTip'] = sprintf("<img onmouseout=\"HideHelp('d%d')\" onmouseover=\"ShowHelp('d%d', '%s', '%s')\" src=\"images/help.gif\" width=\"24\" height=\"16\" border=\"0\"><div style=\"display:none\" id=\"d%d\"></div>", $help_id, $help_id, $var['name'], $var['help'], $help_id);
			}

			/**
			 * Check for personal template
			 */
			if (array_key_exists('template', $var) && $var['template'] != '') {
				$GLOBALS['Properties'] .= $this->ParseTemplate($var['template'], true);
			} else if (array_key_exists('notemplate', $var) && $var['notemplate']) {
				$GLOBALS['Properties'] .= $GLOBALS['PropertyBox'];
			} else {
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('module.property');
				$GLOBALS['Properties'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
		}

		$GLOBALS['AccountingJavaScript'] .= $GLOBALS['ValidationJavascript'];

		// First check if the accounting provider is configured.
		$configured = false;
		if(!empty($this->moudleVariables)) {
			$configured = true;
		}

		if (empty($this->_variables)) {
			// Hide the heading of the property sheet if there aren't any properties
			$GLOBALS['HidePropSheet'] = "none";
		}
		else {
			$GLOBALS['HidePropSheet'] = "";
		}

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.propertysheet");
		$sheet = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		return $sheet;
	}

	protected function showPermissionList($moduleid)
	{
		$output	= '<div style="float:left;"><input type="hidden" id="' . $moduleid . '[permission]" name="' . $moduleid . '[permission]" value="" /><select size="11" multiple="multiple" name="tmpperm" id="tmpperm" class="Field300 ISSelectReplacement">';
		$mask	= $this->getPermissionMask();
		$config	= ModuleIsConfigured($this->getid());

		foreach ($this->_permissionset as $cat => $set) {
			foreach ($set as $sub => $flag) {

				if (!$config || ($flag & $mask) == $flag) {
					$checked = 'selected="selected"';
				} else {
					$checked = '';
				}

				$output .= '<option value="' . $flag . '" ' . $checked . '>' . GetLang('QuickBooksPerm' . ucfirst(strtolower($cat)) . ucfirst(strtolower($sub))) . '</option>';
			}
		}

		$output .= '</select><br style="clear:left" /></div>';

		return $output;
	}

	protected function showPermissionListJS($moduleid)
	{
		return '
		var total  = 0;
		var select = document.getElementById("tmpperm");

		for (var i=0; i<select.options.length; i++) {
			if (select.options[i].selected) {
				total += parseInt(select.options[i].value);
			}
		}

		document.getElementById("' . $moduleid . '[permission]").value = total;
		';
	}

	protected function showSyncList($moduleid)
	{
		$html = '<div style="padding-bottom: 10px; float:left;">
			<select multiple="multiple" name="tmpsync" id="tmpsync" style="height:90px;" class="Field300 ISSelectReplacement">';

		foreach (array_keys($this->_permissionset) as $cat) {
			$html .= '<option value="' . $cat . '">' . GetLang('QuickBooksSync' . ucfirst(strtolower($cat))) . '</option>';
		}

		$html .= '
			</select><br style="clear:both;" />
			<input type="button" value="' . GetLang('QuickBooksShowSyncButton') . '" class="FormButton" style="margin-top:10px; width:120px;" onClick="initAccountingImport();" />
			<br style="clear:left" />
		</div>

		<script type="text/javascript"><!--

			function initAccountingImport()
			{
				var cats   = [];
				var select = document.getElementById("tmpsync");

				for (var i=0; i<select.options.length; i++) {
					if (select.options[i].selected) {
						cats[cats.length] = select.options[i].value;
					}
				}

				if (cats.length < 1) {
					alert("' . addslashes(GetLang('QuickBooksShowSyncErrorSelect')) . '");
				} else {
					tb_show("", "index.php?ToDo=showAccountingSettingsSyncPopup&categories=" + cats.join("|") + "&moduleid=' . $moduleid . '&TB_iframe=true&height=150&width=450&modal=true&random="+new Date().getTime(), "");
				}
			}

		//--></script>';

		return $html;
	}

	public function importSync($moduleid, $type, $nodeid)
	{
		GetModuleById("accounting", $module, $moduleid);

		$class	= "ISC_ENTITY_" . isc_strtoupper($type);
		$entity	= new $class;
		$data	= $entity->get($nodeid);

		if (!$data) {
			return false;
		}

		if ($module->hasPermission(isc_strtolower($type) . '_create')) {
			return $module->createServiceRequest($type, 'add', $data);
		}

		return false;
	}

	/**
	 * Initialise an accounting module
	 *
	 * Method will initialise the accounting module $module. Method will then execute the initialising method within the module $module
	 *
	 * @access public
	 * @param array $modules The module ID array of the modules to initialise
	 * @return bool TRUE if the modules was initialised, FALSE otherwise
	 */
	public function initModules($modules)
	{
		if (!is_array($modules)) {
			return false;
		}

		$objects = array();

		foreach ($modules as $module) {
			$obj =& $objects[];
			if (substr($module, 0, 11) !== $this->type . '_' || !GetModuleById($this->type, $obj, $module)) {
				return false;
			}
		}

		foreach ($objects as $object) {
			$object->initModule();
		}

		return true;
	}

	/**
	 * Check to see if the customer, customer group, product or order is in a module spool list
	 *
	 * Method will check to see if the $nodeID of type $type currently exists in one of the module spool lists. It is up to the developer to
	 * also check to see if these customer/products will be imported for orders that are in the import list
	 *
	 * @access public
	 * @param int $nodeId The node ID to check for (customerid, productid, etc)
	 * @param string $type The type of $nodeId this is ('customer', 'customergroup', 'product' or 'order')
	 * @return array An array of all the module IDs that this node is currently in the list for. If this node is not
	 *               in a list then the array will be empty. FALSE if an error occured
	 */
	public function isNodeInSpool($nodeId, $type)
	{
		if (!isId($nodeId) || $type == '') {
			return false;
		}

		$modules = explode(",", GetConfig('AccountingMethods'));
		$selected = array();

		if (!is_array($modules)) {
			return false;
		}

		$objects = array();

		foreach ($modules as $module) {
			$obj =& $objects[];
			if (substr($module, 0, 11) !== $this->type . '_' || !GetModuleById($this->type, $obj, $module)) {
				return false;
			}
		}

		foreach ($objects as $object) {
			if ($object->isNodeInSpool($nodeId, $type)) {
				$selected[$object->getid()] = $object->_name;
			}
		}

		return $selected;
	}

	/**
	 * Get a setup variable
	 *
	 * Method will return a setup variable that is stored in the database
	 *
	 * @access protected
	 * @param mixed &$ref The referenced value to store the setup value in
	 * @param string $moduleid The module ID
	 * @param string $name The setup variable name
	 * @return bool TRUE if the setup varaible was found, FALSE otherwise
	 */
	protected function getSetupVariable(&$ref, $moduleid, $name)
	{
		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]module_vars WHERE variablename = '" . $GLOBALS['ISC_CLASS_DB']->Quote('setup_' . $name) . "'");

		if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$ref = $row['variableval'];
			return $row['variableid'];
		}

		return false;
	}

	/**
	 * Set a setup variable
	 *
	 * Method will set a setup variable that is stored in the database
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param string $name The setup variable name
	 * @param string $val The value to store as the setup variable
	 * @return bool TRUE if the setup varaible was set successfully, FALSE otherwise
	 */
	protected function setSetupVariable($moduleid, $name, $val)
	{
		if (isId($id = self::getSetupVariable($ref, $moduleid, $name))) {
			return ($GLOBALS['ISC_CLASS_DB']->UpdateQuery('module_vars', array('variableval' => $val), "variableid='" . $GLOBALS['ISC_CLASS_DB']->Quote($id) . "'") !== false);
		} else {
			$savedata = array(
				'modulename'	=> $moduleid,
				'variablename'	=> 'setup_' . $name,
				'variableval'	=> $val,
			);

			return (bool)$GLOBALS['ISC_CLASS_DB']->InsertQuery('module_vars', $savedata);
		}
	}

	/**
	 * Check to see if the lock file entry exists
	 *
	 * Method will checkt to see aif a lock file entry exists. If the second argument is TRUE, then remove the lock file if it is
	 * stale first before checking to see if it exists or not
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param bool $clean TRUE to remove the stale lock first, FALSE not to. Default is FALSE
	 * @return bool TRUE if the lock file entry exists and is still valid, FALSE otherwise
	 */
	protected function checkLockFile($moduleid, $clean=true)
	{
		if ($moduleid == '' || substr($moduleid, 0, 11) !== $this->type . '_') {
			return false;
		}

		$locks = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('LockFiles');

		if ($clean && array_key_exists($moduleid, $locks) && $locks[$moduleid] <= time()) {
			unset($locks[$moduleid]);

			if (!$GLOBALS['ISC_CLASS_DATA_STORE']->Save('LockFiles', $locks)) {
				return false;
			}

			$GLOBALS['ISC_CLASS_DATA_STORE']->Reload('LockFiles');
		}

		/**
		 * If our lock file doesn't exists then we need to clean up the spool entries
		 */
		if (!array_key_exists($moduleid, $locks)) {

			/**
			 * Delete all child spools
			 */
			$GLOBALS['ISC_CLASS_DB']->DeleteQuery('accountingspool', "WHERE accountingspoollock != '' AND accountingspoolparentid > 0");

			/**
			 * Now update the exists locked spools to unlocked
			 */
			$savedata = array(
				'accountingspoolstatus' => '0',
				'accountingspooldisabled' => '0',
				'accountingspoolerrmsg' => '',
				'accountingspoolerrno' => '0'
			);

			$GLOBALS['ISC_CLASS_DB']->UpdateQuery('accountingspool', $savedata, "accountingspoollock != ''");
		}

		return array_key_exists($moduleid, $locks);
	}

	/**
	 * Set a lock file entry
	 *
	 * Function will create a lock file entry. If an entry already exists then function will return FALSE without modifying the
	 * lock cache file. The second argument $expire is a timestamp of the expiry date. The default expiry timestame is 2 hours
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $expire The default expire timestamp. Default is 2 hours
	 * @return bool TRUE if the entry was created, FALSE otherwise
	 */
	protected function setLockFile($moduleid, $expire=null)
	{
		if (is_null($expire)) {
			$expire = time()+7200;
		}

		if ($moduleid == '' || substr($moduleid, 0, 11) !== $this->type . '_' || $expire <= time()) {
			return false;
		}

		$locks = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('LockFiles');

		if (array_key_exists($moduleid, $locks)) {
			return false;
		}

		$locks[$moduleid] = $expire;

		if (!$GLOBALS['ISC_CLASS_DATA_STORE']->Save('LockFiles', $locks)) {
			return false;
		}

		$GLOBALS['ISC_CLASS_DATA_STORE']->Reload('LockFiles');

		return true;
	}

	/**
	 * Unset a lock file entry
	 *
	 * Function will unset a lock file entry
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @return bool TRUE if the entry exists and was unset successfully, FALSE othewise
	 */
	protected function unsetLockFile($moduleid)
	{
		if ($moduleid == '' || substr($moduleid, 0, 11) !== $this->type . '_') {
			return false;
		}

		$locks = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('LockFiles');

		if (!array_key_exists($moduleid, $locks)) {
			return false;
		}

		unset($locks[$moduleid]);

		if (!$GLOBALS['ISC_CLASS_DATA_STORE']->Save('LockFiles', $locks)) {
			return false;
		}

		$GLOBALS['ISC_CLASS_DATA_STORE']->Reload('LockFiles');

		return true;
	}

	/**
	 * Create a service request for each configured module
	 *
	 * Method will initialise each configured module and call the method for creating the service request
	 *
	 * @access public
	 * @param string $type The service request type (customer, product, etc)
	 * @param string $service The server to preform (add, edit, etc)
	 * @param mixed $nodeid The node ID OR an array containing information about the node
	 * @param string $permission The optional permission string needed for this service to work (customer_create, product_edit, etc). Default will not check for permission
	 * @return array A array containing the module id as the key and the accountingspoolid on success or FALSE on failure as the value
	 */
	public function createServiceRequest($type, $service, $nodeid, $permission='')
	{
		$rtn = array();

		foreach (GetAvailableModules($this->type, false, true) as $module) {
			if ($permission !== '' && !$module['object']->hasPermission($permission)) {
				continue;
			}

			$rtn[$module['object']->getid()] = $module['object']->createServiceRequest($type, $service, $nodeid);
		}

		return $rtn;
	}

	/**
	 * Get an accounting reference
	 *
	 * Method will return an accounting reference record
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $nodeid The ID of the referenced item (customer id, order id, etc)
	 * @param string $type The node type (customer, product or order)
	 * @param bool $valueOnly TRUE to only return the unserialised accountingrefvalue, FALSE for the whole record. Default is TRUE
	 * @return array The accountingref record if one was found, FALSE otherwise
	 */
	protected function getAccountingReference($moduleid, $nodeid, $type, $valueOnly=true)
	{
		/**
		 * If we are an ID then match on the nodeid
		 */
		if (isId($nodeid)) {
			$query = "
					SELECT *
					FROM [|PREFIX|]accountingref
					WHERE accountingrefmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'
						AND accountingreftype='" . $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($type)) . "'
						AND ((accountingrefnodeid != 0 AND accountingrefnodeid='" . $GLOBALS['ISC_CLASS_DB']->Quote($nodeid) . "')
							OR (accountingrefnodeid = 0 AND accountingrefid='" . $GLOBALS['ISC_CLASS_DB']->Quote($nodeid) . "'))";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$row['accountingrefvalue'] = unserialize($row['accountingrefvalue']);

				if ($valueOnly) {
					return $row['accountingrefvalue'];
				} else {
					return $row;
				}
			}

		/**
		 * Else if we are an array the unserialize the reference data for each record and match it against the search criteria
		 */
		} else if (is_array($nodeid) && !empty($nodeid)) {
			$query = "
					SELECT *
					FROM [|PREFIX|]accountingref
					WHERE accountingrefmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'
						AND accountingreftype='" . $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($type)) . "'";

			$result		= $GLOBALS['ISC_CLASS_DB']->Query($query);
			$accountid	= false;

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

				$reference = unserialize($row['accountingrefvalue']);
				if (!is_array($reference)) {
					continue;
				}

				$passed	= true;

				foreach ($nodeid as $key => $val) {
					if (!array_key_exists($key, $reference) || $reference[$key] !== $val) {
						$passed = false;
					}
				}

				if ($passed) {
					$row['accountingrefvalue'] = $reference;

					if ($valueOnly) {
						return $row['accountingrefvalue'];
					} else {
						return $row;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Set an accounting reference
	 *
	 * Method will set an accounting reference record
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $nodeid The ID of the referenced item (customer id, order id, etc) OR the search criteria array for the reference data
	 * @param string $type The node type (customer, product or order)
	 * @param string $reference The reference data to store
	 * @return int The accountingrefid ID if the record was inserted/updated, FALSE otherwise
	 */
	protected function setAccountingReference($moduleid, $nodeid, $type, $reference)
	{
		if ($moduleid == '' || $nodeid == '' || $type == '') {
			return false;
		}

		$savedata = array(
			'accountingrefmoduleid'	=> $moduleid,
			'accountingreftype'		=> $type,
			'accountingrefvalue'	=> serialize($reference)
		);

		if (isId($nodeid)) {
			$savedata['accountingrefnodeid'] = $nodeid;
		} else {
			$savedata['accountingrefnodeid'] = 0;
		}

		$output = self::getAccountingReference($moduleid, $nodeid, $type, false);

		if (is_array($output) && isId($output['accountingrefid'])) {
			$rtn = $GLOBALS['ISC_CLASS_DB']->UpdateQuery('accountingref', $savedata, "accountingrefid='" . $GLOBALS['ISC_CLASS_DB']->Quote($output['accountingrefid']) . "'");
			$id = $output['accountingrefid'];
		} else {
			$rtn = $GLOBALS['ISC_CLASS_DB']->InsertQuery('accountingref', $savedata);
			$id = $rtn;
		}

		if ($rtn !== false) {
			return $id;
		}
	}

	/**
	 * Unset an accounting reference
	 *
	 * Method will unset an accounting reference record
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $nodeid The ID of the referenced item (customer id, order id, etc)
	 * @param string $type The node type (customer, product or order)
	 * @return bool TRUE if the record was deleted, FALSE otherwise
	 */
	protected function unsetAccountingReference($moduleid, $nodeid, $type)
	{
		$output = self::getAccountingReference($moduleid, $nodeid, $type, false);
		if (is_array($output) && isId($output['accountingrefid'])) {
			return $GLOBALS['ISC_CLASS_DB']->DeleteQuery('accountingref', "WHERE accountingrefid='" . $GLOBALS['ISC_CLASS_DB']->Quote($output['accountingrefid']) . "'");
		}

		return true;
	}

	/**
	 * Get the accounting spool record total
	 *
	 * Method will return the total amount of accounting spool records
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $parentSpoolId The optional parent spool ID. Default is NULL (count all)
	 * @param string $lock The optional accountingspoollock value to count in. Default is empty (count all)
	 * @param bool $useExecutedOnly TRUE to count only executed spools, FALSE to count all. Default is FALSE (count all)
	 * @return int The total amount of accounting spool records on success, FALSE on failure
	 */
	protected function getAccountingSpoolCount($moduleid, $parentSpoolId=null, $lock='', $useExecutedOnly=false)
	{
		if ($moduleid == "") {
			return false;
		}

		$query = "SELECT COUNT(*) AS total
				FROM [|PREFIX|]accountingspool
				WHERE accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'";

		if (isId($parentSpoolId)) {
			$query .= " AND accountingspoolparentid=" . (int)$parentSpoolId;
		}

		if ($lock !== '') {
			$query .= " AND accountingspoollock='" . $GLOBALS['ISC_CLASS_DB']->Quote($lock) . "'";
		}

		if ($useExecutedOnly) {
			$query .= " AND accountingspoolstatus=1";
		}

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$record = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

		if (!$record) {
			return false;
		}

		return (int)$record['total'];
	}

	/**
	 * Get an accounting spool record list
	 *
	 * Method will return a ist of all the accounting spool records
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $start The option position to start from. Default is 0 (at the start)
	 * @param int $limit The option limit to limit the amount of records return. Default is -1 (unlimited)
	 * @return int The total amount of accounting spool records on success, FALSE on failure
	 */
	protected function getAccountingSpoolList($moduleid, $start=0, $limit=-1)
	{
		if ($moduleid == "" || !is_numeric($start) || !is_numeric($limit)) {
			return false;
		}

		if ($start < 0) {
			$start = 0;
		}

		if ($limit < -1) {
			$limit -1;
		}

		$list = array();
		$query = "SELECT accountingspoolid FROM [|PREFIX|]accountingspool WHERE accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'";

		/**
		 * Can only use $start if $limit is set
		 */
		if ($limit > -1) {
			if ($start > 0) {
				$query .= " LIMIT " . (int)$start . "," . (int)$limit;
			} else {
				$query .= " LIMIT " . (int)$limit;
			}
		}

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$list[$row['accountingspoolid']] = self::getAccountingSpool($moduleid, $row['accountingspoolid']);
		}

		return $list;
	}

	/**
	 * Get the records of all the accountingspool children
	 *
	 * Method will return a list of all the accountingspool children associated with the parent $spoolParentId
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $parentSpoolId The spool parent ID
	 * @return array An array of all the associated children accountingspool records on success, FALSE on error
	 */
	protected function getAccountingSpoolChildren($moduleid, $spoolParentId)
	{
		if ($moduleid == '' || !isId($spoolParentId)) {
			return false;
		}

		$children = array();

		$query = "SELECT accountingspoolid
				FROM [|PREFIX|]accountingspool
				WHERE accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "' AND accountingspoolparentid=" . (int)$spoolParentId . "
				ORDER BY accountingspoolid ASC";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$children[] = self::getAccountingSpool($moduleid, $row['accountingspoolid']);
		}

		return $children;
	}

	/**
	 * Set the selected spools in $spoolIdx as children of $spoolParentId
	 *
	 * Method will set all the accountingspool records associated with the array $spoolIdx to be children of $spoolParentId
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $parentSpoolId The parent spool ID
	 * @param mixed The child spool ID / array of IDs
	 * @return bool TRUE if all the spools were associated to be children of $spoolParentId
	 */
	public function setAccountingSpoolChildren($moduleid, $parentSpoolId, $spoolIdx)
	{
		if (isId($spoolIdx)) {
			$spoolIdx = array($spoolIdx);
		}

		if (is_array($spoolIdx)) {
			$spoolIdx = array_filter($spoolIdx, "isId");
		}

		if (!isId($parentSpoolId) || !is_array($spoolIdx) || empty($spoolIdx)) {
			return false;
		}

		$query = "UPDATE [|PREFIX|]accountingspool
					SET accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "' AND accountingspoolparentid = " . (int)$parentSpoolId . "
					WHERE accountingspoolid IN(" . implode(',', $spoolIdx) . ")";

		return ($GLOBALS['ISC_CLASS_DB']->Query($query) !== false);
	}

	/**
	 * Does child service already exist in parent spool $parentSpoolId
	 *
	 * Method will check to see if the child service $service already exists in the parent spool $parentSpoolId. Will only look
	 * in the first level (will not recurse).
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $parentSpoolId The parent spool ID
	 * @param string $service The child service
	 * @return array The accountingspool child record if the child service exists, NULL if not, FALSE on error
	 */
	public function isChildServiceInSpool($moduleid, $parentSpoolId, $service)
	{
		if ($moduleid == '' || !isId($parentSpoolId) || $service == '') {
			return false;
		}

		$query = "SELECT accountingspoolid, accountingspooltype, accountingspoolservice
				FROM [|PREFIX|]accountingspool
				WHERE accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "' AND accountingspoolparentid = " . (int)$parentSpoolId;

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$realService = $this->getSpoolService($row['accountingspooltype'], $row['accountingspoolservice']);

			if (isc_strtolower($service) == isc_strtolower($realService)) {
				return self::getAccountingSpool($row['accountingspoolid']);
			}
		}

		return null;
	}

	/**
	 * Get an accounting spool record
	 *
	 * Method will get an accounting spool record
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $spoolId The accountingspoolid ID OR if $type is not empty then $id will be the accountingspoolnodeid
	 * @param string $type The optional node type (customer, product, order, etc)
	 * @return array The spool array on success, FALSE if the recird was not found
	 */
	protected function getAccountingSpool($moduleid, $spoolId, $type="")
	{
		static $entities = array();

		if (!isId($spoolId) || $moduleid == "") {
			return false;
		}

		if ($type == "") {
			$query = "SELECT *
					FROM [|PREFIX|]accountingspool
					WHERE accountingspoolid=" . (int)$spoolId . " AND accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'";

		} else {
			$query = "SELECT *
					FROM [|PREFIX|]accountingspool
					WHERE accountingspoolnodeid=" . (int)$spoolId . " AND accountingspooltype='" . $GLOBALS['ISC_CLASS_DB']->Quote($type) . "'
						AND accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'";
		}

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$record = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

		if (!$record) {
			return false;
		}

		/**
		 * If we have a nodeid then get the database record that is associated with that nodeid
		 */
		if (isId($record['accountingspoolnodeid']) && $record['accountingspoolserial'] == '') {
			$key = isc_strtolower($record['accountingspooltype']);
			$class = "ISC_ENTITY_" . isc_strtoupper($record['accountingspooltype']);

			if (!array_key_exists($key, $entities)) {
				$entities[$key] = new $class();
			}

			$record['accountingspoolnode'] = $entities[$key]->get($record['accountingspoolnodeid']);

		/**
		 * Else the data is in the accountingspoolserial
		 */
		} else if ($record['accountingspoolserial'] !== '') {
			$record['accountingspoolnode'] = unserialize($record['accountingspoolserial']);

		/**
		 * Else we do not have any information to get
		 */
		} else {
			$record['accountingspoolnode'] = false;
		}

		/**
		 * Get our real service name
		 */
		$record['accountingspoolrealservice'] = $this->getSpoolService($record['accountingspooltype'], $record['accountingspoolservice']);

		/**
		 * Get our parsed return data
		 */
		$record['accountingspoolreturn'] = $this->getAccountingSpoolReturn($spoolId);

		/**
		 * Assign any children if we have any
		 */
		$record['accountingspoolchildren'] = self::getAccountingSpoolChildren($moduleid, $spoolId);

		return $record;
	}

	/**
	 * Set an accounting spool record
	 *
	 * Method will create an accounting spool record
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param string $type The node type (customer, product, order, etc)
	 * @param string $service The node service. This is module dependent
	 * @param mixed $nodeid The node ID OR an array containing information about the node
	 * @param int $parentSpoolId The optional parent node ID. Default is null (no parent)
	 * @param string $lock The optional accountingspoollock value
	 * @return int The accountingspool record ID on success, FALSE if failed
	 */
	protected function setAccountingSpool($moduleid, $type, $service, $nodeid, $parentSpoolId=null, $lock='')
	{
		if ($moduleid == '' || $type == '' || $service == '') {
			return false;
		}

		$savedata = array(
			'accountingspoolmoduleid' => $moduleid,
			'accountingspooltype' => $type,
			'accountingspoolservice' => $service
		);

		if (isId($nodeid)) {
			$savedata['accountingspoolnodeid'] = $nodeid;
		} else if (is_array($nodeid)) {

			/**
			 * Get out node ID if we can
			 */
			$key = '';
			switch (isc_strtolower($type)) {
				case 'customer':
					$key = 'customerid';
					break;

				case 'customergroup':
					$key = 'customergroupid';
					break;

				case 'product':
					$key = 'productid';
					break;

				case 'order':
					$key = 'orderid';
					break;
			}

			if (array_key_exists($key, $nodeid)) {
				$savedata['accountingspoolnodeid'] = $nodeid[$key];
			}

			$savedata['accountingspoolserial'] = serialize($nodeid);

		} else {
			return false;
		}

		if (isId($parentSpoolId)) {
			$savedata['accountingspoolparentid'] = $parentSpoolId;
		}

		if ($lock !== '') {
			$savedata['accountingspoollock'] = $lock;
		}

		$id = $GLOBALS['ISC_CLASS_DB']->InsertQuery('accountingspool', $savedata);

		if (isId($id)) {
			return $id;
		}

		return false;
	}

	/**
	 * Unset (delete) an accounting spool record
	 *
	 * Method will delete an accounting spool record
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $spoolId The accountingspool ID
	 * @return bool TRUE if the record was deleted, FALSE otherwise
	 */
	protected function unsetAccountingSpool($moduleid, $spoolId)
	{
		if (!isId($spoolId) || $moduleid == '') {
			return false;
		}

		return $GLOBALS['ISC_CLASS_DB']->DeleteQuery("accountingspool", "WHERE accountingspoolid=" . (int)$spoolId . " AND accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'");
	}

	/**
	 * Enable an accounting spool record
	 *
	 * Method will enable an accounting spool record so it can be executed by QBWC
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $spoolId The accountingspool ID
	 * @return bool TRUE if the record was enabled, FALSE otherwise
	 */
	protected function enableAccountingSpool($moduleid, $spoolId)
	{
		if (!isId($spoolId) || $moduleid == '') {
			return false;
		}

		$query = "SELECT *
				FROM [|PREFIX|]accountingspool
				WHERE accountingspoolid=" . (int)$spoolId . " AND accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		if ($GLOBALS['ISC_CLASS_DB']->CountResult($result) <= 0) {
			return false;
		}

		$savedata = array(
			'accountingspooldisabled' => 0,
			'accountingspoollock' => ''
		);

		return (bool)$GLOBALS['ISC_CLASS_DB']->UpdateQuery("accountingspool", $savedata, "accountingspoolid=" . (int)$spoolId);
	}

	/**
	 * Disable an accounting spool record
	 *
	 * Method will disable an accounting spool record so it will be skipped by QBWC
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param int $spoolId The accountingspool ID
	 * @return bool TRUE if the record was disabled, FALSE otherwise
	 */
	protected function disableAccountingSpool($moduleid, $spoolId)
	{
		if (!isId($spoolId) || $moduleid == '') {
			return false;
		}

		$query = "SELECT *
				FROM [|PREFIX|]accountingspool
				WHERE accountingspoolid=" . (int)$spoolId . " AND accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		if ($GLOBALS['ISC_CLASS_DB']->CountResult($result) <= 0) {
			return false;
		}

		return ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("accountingspool", array("accountingspooldisabled" => "1"), "accountingspoolid=" . (int)$spoolId) !== false);
	}

	/**
	 * Get the spool status
	 *
	 * Method will return the accounting spool status of $spoolId
	 *
	 * @access public
	 * @param int $spoolId The spool ID
	 * @return mixed 1 if the status is TRUE, 0 if status is FALSE, NULL is status is NULL, FALSE on error
	 */
	protected function getAccountingSpoolStatus($moduleid, $spoolId)
	{
		if (!isId($spoolId) || $moduleid == '') {
			return false;
		}

		$query = "SELECT IFNULL(accountingspoolstatus, '*') AS accountingspoolstatus
					FROM [|PREFIX|]accountingspool
					WHERE accountingspoolid=" . (int)$spoolId . " AND accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$record = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

		if (!$record) {
			return false;
		} else if ($record['accountingspoolstatus'] == '*') {
			return null;
		} else {
			return (int)$record['accountingspoolstatus'];
		}
	}

	/**
	 * Get the spool return
	 *
	 * Method will return the stored executed spool return
	 *
	 * @access public
	 * @param string $moduleid The module ID
	 * @param int $spoolId The spool ID to retrieve from
	 * @return string The return string if one was found and stored, FALSE is no return was stored
	 */
	protected function getAccountingSpoolReturn($moduleid, $spoolId)
	{
		if ($moduleid == '' || !isId($spoolId)) {
			return false;
		}

		$query = "SELECT accountingspoolreturn
				FROM [|PREFIX|]accountingspool
				WHERE accountingspoolid=" . (int)$spoolId . " AND accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$record = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

		if (!$record || $record['accountingspoolreturn'] == '') {
			return false;
		}

		return $record['accountingspoolreturn'];
	}

	/**
	 * Set the spool return
	 *
	 * Method will set the stored executed spool return
	 *
	 * @access public
	 * @param string $moduleid The module ID
	 * @param int $spoolId The spool ID to set the return to
	 * @param string $return The spool return
	 * @return bool TRUE if the spool exists and the return was set, FALSE otherwise
	 */
	protected function setAccountingSpoolReturn($moduleid, $spoolId, $return)
	{
		if ($moduleid == '' || !isId($spoolId)) {
			return false;
		}

		$savedata = array(
			'accountingspoolreturn' => $return
		);

		$rtn = $GLOBALS['ISC_CLASS_DB']->UpdateQuery('accountingspool', $savedata, "accountingspoolid=" . (int)$spoolId . " AND accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'");

		return ($rtn !== false);
	}

	/**
	 * Build spool description
	 *
	 * Method will build the spool description
	 *
	 * @access protected
	 * @param array $spool The accountingspool record array
	 * @return string The description
	 */
	protected function buildAccountingSpoolDescription($spool)
	{
		if (!is_array($spool) || empty($spool)) {
			return '';
		}

		$action = ucfirst(GetLang("QuickBooksAction" . ucfirst(isc_strtolower($spool['accountingspoolservice']))));
		$type = GetLang('QuickBooksType' . ucfirst(isc_strtolower($spool['accountingspooltype'])));;
		$name = '';

		switch (isc_strtolower($spool['accountingspooltype'])) {
			case 'customer':
				$name = $spool['accountingspoolnode']['custconfirstname'] . ' ' . $spool['accountingspoolnode']['custconlastname'];
				break;

			case 'customergroup':
				$name = $spool['accountingspoolnode']['groupname'];
				break;

			case 'product':
				$name = $spool['accountingspoolnode']['prodname'];
				break;

			case 'order':
				$name = GetLang('OrderNo') . $spool['accountingspoolnode']['orderid'];
				break;

			case 'salestaxcode';
			case 'account':
				$name = $spool['accountingspoolnode']['Name'];
				break;
		}

		return sprintf(GetLang('QuickBooksSpoolDesc'), $action, $type, isc_html_escape($name));
	}

	/**
	 * Build spool url
	 *
	 * Method will build the spool url
	 *
	 * @access protected
	 * @param array $spool The accountingspool record array
	 * @return string The url
	 */
	protected function buildAccountingSpoolURL($spool)
	{
		if (!is_array($spool) || empty($spool)) {
			return '';
		}

		$url = '#';

		switch (isc_strtolower($spool['accountingspooltype'])) {
			case 'customer':
				$url = 'index.php?ToDo=viewCustomers&searchQuery=' . $spool['accountingspoolnodeid'];
				break;

			case 'customergroup':
				$url = 'index.php?ToDo=editCustomerGroup&groupId=' . $spool['accountingspoolnodeid'];
				break;

			case 'product':
				$url = 'index.php?ToDo=viewProducts&searchQuery=' . $spool['accountingspoolnodeid'];
				break;

			case 'order':
				$url = 'index.php?ToDo=viewOrders&searchQuery=' . $spool['accountingspoolnodeid'];
				break;
		}

		return $url;
	}

	/**
	 * Get the permissions set array
	 *
	 * Method will return an array containing the permissions set array
	 *
	 * @access public
	 * @param int $mask The optional permission mask to build the permission set array with. Default is the current module permission mask
	 * @return array The permission set array
	 */
	public function getPermissions($mask=null)
	{
		if (is_null($mask)) {
			$mask = $this->getPermissionMask();
		}

		$perms = array();

		foreach ($this->_permissionset as $cat => $set) {
			$perms[$cat] = array();
			foreach ($set as $sub => $flag) {
				if (($flag & $mask) == $flag) {
					$perms[$cat][$sub] = $flag;
				}
			}
		}

		return $perms;
	}

	/**
	 * Check to see if we have permission to do something
	 *
	 * Method will check to see if the user can edit a customer or add a product against the current permission set. The permission category $cat can either be the category
	 * or both the category and subcategory with an underscore separating them both (eg: 'customer_create')
	 *
	 * @access public
	 * @params string $cat The permission set category (customer, product, etc)
	 * @params string $sub The permission set sub-category (create, edit, etc)
	 * @return bool TRUE if the user has permission, FALSE otherwise
	 */
	public function hasPermission($cat, $sub='')
	{
		if ($sub == "" && strpos($cat, '_')) {
			list($cat, $sub) = explode('_', $cat, 2);
		}

		if ($cat == '' || $sub == '' || !array_key_exists($cat, $this->_permissionset) || !array_key_exists($sub, $this->_permissionset[$cat])) {
			return false;
		}

		return (($this->_permissionset[$cat][$sub] & $this->getPermissionMask()) == $this->_permissionset[$cat][$sub]);
	}

	/**
	 * Initialise the accounting session
	 *
	 * Method will initialise the accounting session used when importing/exporting the XML spool
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param array $initVal The initialised value
	 * @return bool TRUE if the session was initialised, FALSE on error
	 */
	protected function initAccountingSession($moduleid, $initVal=array())
	{
		if ($moduleid == '' || !is_array($initVal)) {
			return false;
		}

		$modkey = isc_strtoupper($moduleid);

		if (!array_key_exists($modkey, $_SESSION)) {
			$_SESSION[$modkey] = $initVal;
		}

		return true;
	}

	/**
	 * Get the stored session array value
	 *
	 * Method will returned the stored session array value
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param string $key The key corresponding to the stored value
	 * @return mixed The stored session information on success, NULL if key does not exists, FALSE on error
	 */
	protected function getAccountingSessionKey($moduleid, $key)
	{
		if ($moduleid == '' || $key == '') {
			return false;
		}

		$modkey = isc_strtoupper($moduleid);

		if (!isset($_SESSION[$modkey]) || !is_array($_SESSION[$modkey]) || !array_key_exists($key, $_SESSION[$modkey])) {
			return null;
		}

		return $_SESSION[$modkey][$key];
	}

	/**
	 * Set the stored session array value
	 *
	 * Method will set the stored session array value corresponding to the key $key
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param string $key The key corresponding to store the value in
	 * @param mixed $val The value to store
	 * @return bool TRUE if the value was set, FALSE on error
	 */
	protected function setAccountingSessionKey($moduleid, $key, $val)
	{
		if ($moduleid == '' || $key == '') {
			return false;
		}

		$modkey = isc_strtoupper($moduleid);

		if (!isset($_SESSION[$modkey]) || !is_array($_SESSION[$modkey])) {
			return false;
		}

		$_SESSION[$modkey][$key] = $val;

		return true;
	}

	/**
	 * Unset the transaction session
	 *
	 * Method will unset the transaction session
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @return bool TRUE if the session was unset, FALSE on error
	 */
	protected function unsetAccountingSession($moduleid)
	{
		if ($moduleid == '') {
			return false;
		}

		$modkey = isc_strtoupper($moduleid);

		if (isset($_SESSION[$modkey])) {
			unset($_SESSION[$modkey]);
		}

		return !isset($_SESSION[$modkey]);
	}

	/**
	 * Get the currently active accountingspool record
	 *
	 * Method will return the currenctly active accountingspool record
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param string $lock The accountingspoollock value
	 * @return array The currently active accountingspool record if one was found, FASLE is the were none
	 */
	protected function getCurrentSpool($moduleid, $lock)
	{
		if ($moduleid == '' || $lock == '') {
			return false;
		}

		$query = "SELECT accountingspoolid
				FROM [|PREFIX|]accountingspool
				WHERE accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "' AND accountingspoollock='" . $GLOBALS['ISC_CLASS_DB']->Quote($lock) . "'
				AND accountingspoolstatus IS NULL";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

		if (!$row) {
			return false;
		}

		return self::getAccountingSpool($moduleid, $row['accountingspoolid']);
	}

	/**
	 * Set the currently active accountingspool record
	 *
	 * Method will set the currenctly active accountingspool record
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param string $lock The accountingspoollock value
	 * @param int $spoolId The spool to be set as the currently active spool
	 * @return bool TRUE if the record was set, FALSE on error
	 */
	protected function setCurrentSpool($moduleid, $lock, $spoolId)
	{
		if ($moduleid == '' || $lock == '' || !isId($spoolId)) {
			return false;
		}

		$query = "UPDATE [|PREFIX|]accountingspool
				SET accountingspoolstatus=IF(accountingspoolid = " . $spoolId . ", NULL, 1)
				WHERE accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "' AND accountingspoollock='" . $GLOBALS['ISC_CLASS_DB']->Quote($lock) . "'
				AND (accountingspoolid = " . $spoolId . " OR accountingspoolstatus IS NULL)";

		if ($GLOBALS['ISC_CLASS_DB']->Query($query) === false) {
			return false;
		}

		return true;
	}

	/**
	 * Set the error for a spool record
	 *
	 * Method will set the error message and number for a spool record
	 *
	 * @access public
	 * @param string $moduleid The module ID
	 * @param int $spoolId The spool ID
	 * @param string $errmsg The error message
	 * @param int $errno The error number
	 * @return bool TRUE if the error message and number were set, FALSE if no record could be found
	 */
	public function setSpoolError($moduleid, $spoolId, $errmsg, $errno)
	{
		if ($moduleid == '' || !isId($spoolId) || !is_string($errmsg) || !is_numeric($errno)) {
			return false;
		}

		$savedata = array(
			'accountingspoolerrmsg' => $errmsg,
			'accountingspoolerrno' => (int)$errno
		);

		return ($GLOBALS['ISC_CLASS_DB']->UpdateQuery('accountingspool', $savedata, "accountingspoolid=" . (int)$spoolId . " AND accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'") !== false);
	}

	/**
	 * Set a spool record as executed
	 *
	 * Method will set a spool record as executed
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param string $lock The accountingspoollock value
	 * @param int $spoolId The spool to be set as executed
	 * @param bool $forceClean TRUE to also reset the accountingspooldisabled, accountingspoolerrmsg and accountingspoolerrno fields. Default is FALSE
	 * @return bool TRUE if the spool was set, FALSE if not
	 */
	protected function setSpoolAsExecuted($moduleid, $lock, $spoolId, $forceClean=false)
	{
		if ($moduleid == '' || $lock == '' || !isId($spoolId)) {
			return false;
		}

		$savedata = array(
			"accountingspoolstatus" => 1
		);

		if ($forceClean) {
			$savedata["accountingspooldisabled"] = 0;
			$savedata["accountingspoolerrmsg"] = "";
			$savedata["accountingspoolerrno"] = 0;
		}

		return ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("accountingspool", $savedata, "accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "' AND accountingspoollock='" . $GLOBALS['ISC_CLASS_DB']->Quote($lock) . "' AND accountingspoolid=" . (int)$spoolId) !== false);
	}

	/**
	 * Get the next spool
	 *
	 * Method will either get the next available sibling spool, the available parent spool or FALSE based upon the spool ID $spoolId
	 *
	 * @access protected
	 * @param string $moduleid The module ID
	 * @param string $lock The accountingspoollock value
	 * @param int $spoolId The spool ID to search from
	 * @return array The next available spool if successful, FALSE if there is none
	 */
	protected function getNextSpool($moduleid, $lock, $spoolId)
	{
		if ($moduleid == '' || $lock == '' || !isId($spoolId)) {
			return false;
		}

		$spool = self::getAccountingSpool($moduleid, $spoolId);

		if (!$spool) {
			return false;
		}

		/**
		 * If we have no parent
		 */
		if (!isId($spool['accountingspoolparentid'])) {
			$query = "SELECT accountingspoolid
					FROM [|PREFIX|]accountingspool
					WHERE accountingspoolparentid = 0 AND accountingspoolstatus = 0 AND accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "'
						AND accountingspoollock='" . $GLOBALS['ISC_CLASS_DB']->Quote($lock) . "' AND accountingspoolid != " . $spoolId . "
					ORDER BY accountingspoolid ASC
					LIMIT 1";

		/**
		 * If we do
		 */
		} else {
			$query = "(SELECT accountingspoolid
						FROM [|PREFIX|]accountingspool
						WHERE accountingspoolparentid = " . $spool['accountingspoolparentid'] . " AND accountingspoolstatus = 0
							AND accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "' AND accountingspoollock='" . $GLOBALS['ISC_CLASS_DB']->Quote($lock) . "'
							AND accountingspoolid != " . $spoolId . "
						ORDER BY accountingspoolid ASC
						LIMIT 1)
						UNION
						(SELECT " . $spool['accountingspoolparentid'] . ")";
		}

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			if (isId($row['accountingspoolid'])) {
				return self::getAccountingSpool($moduleid, $row['accountingspoolid']);
			}
		}

		return false;
	}

	/**
	 * Remove all executed spools
	 *
	 * Method will remove all executed spools
	 *
	 * @access public
	 * @param string $moduleid The module ID
	 * @param string $lock The optional lock value. Default is empty string (no lock)
	 * @return bool TRUE if operation was successful, FALSE on error
	 */
	public function removeExecutedSpool($moduleid, $lock='')
	{
		if ($moduleid == '') {
			return false;
		}

		$where = "WHERE accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "' AND accountingspoolstatus = 1 AND accountingspoolerrno = 0";
		if ($lock !== '') {
			$where .= " AND accountingspoollock='" . $GLOBALS['ISC_CLASS_DB']->Quote($lock) . "'";
		}

		return $GLOBALS['ISC_CLASS_DB']->DeleteQuery('accountingspool', $where);
	}

	/**
	 * Set the spool list for an import
	 *
	 * Method will set the unexecuted records in the accountingspool to be available for import
	 *
	 * @access public
	 * @param string $moduleid The module ID
	 * @param string $lock The accountingspoollock value to be set
	 * @return bool TRUE if the setting was succesful, FALSE on error
	 */
	protected function setAccountingSpoolImport($moduleid, $lock)
	{
		if ($moduleid == '' || $lock == '') {
			return false;
		}

		$savedata = array(
			'accountingspoollock' => $lock,
			'accountingspoolstatus' => 0
		);

		$rtn = $GLOBALS['ISC_CLASS_DB']->UpdateQuery('accountingspool', $savedata, "accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "' AND accountingspooldisabled = 0 AND accountingspoollock = ''");

		if ($rtn === false) {
			return false;
		}

		/**
		 * 'Unlock' any orders that have not been processed as we do not want to deal with them
		 */
		$query = "UPDATE [|PREFIX|]accountingspool a
						JOIN [|PREFIX|]orders o ON a.accountingspoolnodeid = o.orderid
					SET accountingspoollock=''
					WHERE a.accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "' AND a.accountingspoollock='" . $GLOBALS['ISC_CLASS_DB']->Quote($lock) . "'
						AND a.accountingspooltype='order' AND (o.ordstatus != 10 AND o.ordstatus != 2)";

		$GLOBALS['ISC_CLASS_DB']->Query($query);

		/**
		 * Set the first job as the active one
		 */
		$query = "UPDATE [|PREFIX|]accountingspool
				SET accountingspoolstatus = NULL
				WHERE accountingspoolmoduleid='" . $GLOBALS['ISC_CLASS_DB']->Quote($moduleid) . "' AND accountingspoollock='" . $GLOBALS['ISC_CLASS_DB']->Quote($lock) . "'
				ORDER BY accountingspoolid ASC
				LIMIT 1";

		return ($GLOBALS['ISC_CLASS_DB']->Query($query) !== false);
	}
}

?>
