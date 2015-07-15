<?php

class ACCOUNTING_QUICKBOOKS extends ISC_ACCOUNTING
{
	private $_ownerid;
	private $_appname;
	private $_appdesc;
	private $_appurl;
	private $_appsupporturl;
	private $_qbtype;
	private $_password;
	private $_username;
	private $_fileid;
	private $_initdata;

	protected $_permissionset;

	public $_id;
	public $_name;
	public $_description;
	public $_help;
	public $_url;
	public $_file;
	public $_supporturl;

	public function __construct()
	{
		// Setup the required variables for the module
		parent::__construct();

		$this->_id				= 'accounting_quickbooks';
		$this->_name			= GetLang('QuickBooksName');
		$this->_description		= GetLang('QuickBooksDesc');
		$this->_help			= GetLang('QuickBooksHelp');
		$this->_url				= 'http://www.quicken.com.au';
		$this->_file			= basename(__FILE__);

		// Details for the QBWC file
		$this->getSetupVariable($password, 'password');
		$this->getSetupVariable($username, 'username');
		$this->getSetupVariable($fileid, 'fileid');
		$this->_appname			= GetLang('QuickBooksApplicationName');
		$this->_appdesc			= GetLang('QuickBooksApplicationDescription');
		$this->_appurl			= GetConfig('ShopPathSSL') . '/accountinggateway.php?accounting=' . $this->getid();
		$this->_appsupporturl	= GetConfig('ShopPathSSL') . '/accountinggateway.php?action=ShowSupport&accounting=' . $this->getid();
		$this->_supporturl		= 'http://www.viewkb.com/categories/Shopping+Cart/Support+and+Technical+Questions/Shopping+Cart/Accounting+Settings/Intuit+QuickBooks/';
		$this->_ownerid			= '0749cafc-62f5-102b-83a8-001a4d0000c0';
		$this->_qbtype			= 'QBFS';
		$this->_password		= $password;
		$this->_username		= $username;
		$this->_fileid			= $fileid . substr($this->_ownerid, 8);

		$this->_permissionset	= array(
								'customer'	=> array(
													'create'	=> 1,
													'edit'		=> 2,
													'delete'	=> 4
													),
								'product'	=> array(
													'create'	=> 8,
													'edit'		=> 16,
													'delete'	=> 32
													),
								'order'		=> array(
													'create'	=> 64,
													'edit'		=> 128,
													'delete'	=> 256
													)
								);

		$this->_initdata		= array(
									array(
											'type'		=> 'account',
											'service'	=> 'add',
											'data'		=> array(
															'Name' => GetLang('QuickBooksIncomeAccountName'),
															'AccountType' => 'Income'
															)
										),
									array(
											'type'		=> 'account',
											'service'	=> 'add',
											'data'		=> array(
															'Name' => GetLang('QuickBooksCOGSAccountName'),
															'AccountType' => 'CostOfGoodsSold'
															)
										),
									array(
											'type'		=> 'account',
											'service'	=> 'add',
											'data'		=> array(
															'Name' => GetLang('QuickBooksAssetAccountName'),
															'AccountType' => 'FixedAsset'
															)
										),
								);

		// Setup the custom variables
		$this->setCustomVars();

		// Load saved variables from the database
		$this->loadAccountingVars();
	}

	/**
	* Custom variables for the checkout module. Custom variables are stored in the following format:
	* array(variable_id, variable_name, variable_type, help_text, default_value, required, [variable_options], [multi_select], [multi_select_height])
	* variable_type types are: text,number,password,radio,dropdown
	* variable_options is used when the variable type is radio or dropdown and is a name/value array.
	*/
	public function setCustomVars()
	{
		$this->_variables['scheduler'] = array(
				'name'		=> GetLang('QuickBooksScheduler'),
				'type'		=> 'dropdown',
				'help'		=> GetLang('QuickBooksSchedulerHelp'),
				'default'	=> 'never',
				'savedvalue'	=> array(),
				'required'	=> true,
				'options'	=> array(
								GetLang('QuickBooksScheduler5min')		=> '5',
								GetLang('QuickBooksScheduler10min')		=> '10',
								GetLang('QuickBooksScheduler15min')		=> '15',
								GetLang('QuickBooksScheduler30min')		=> '30',
								GetLang('QuickBooksScheduler1hour')		=> '60',
								GetLang('QuickBooksScheduler2hour')		=> '120',
								GetLang('QuickBooksScheduler6hour')		=> '360',
								GetLang('QuickBooksScheduler12hour')	=> '720',
								GetLang('QuickBooksScheduler1day')		=> '1440',
								GetLang('QuickBooksScheduler2day')		=> '2880',
								GetLang('QuickBooksScheduler1week')		=> '10080'
				),
				'multiselect' => false
			);

		$this->_variables['permission'] = array(
				'name' => GetLang('QuickBooksShowPermissionList'),
				'type' => 'custom',
				'callback' => 'showPermissionList',
				'javascript' => $this->showPermissionListJS(),
				'help' => GetLang('QuickBooksShowPermissionListHelp'),
			);

		$GLOBALS['AccountExtraJS'] = '';

		if (ModuleIsConfigured($this->getid())) {
			$this->_variables['sync'] = array(
				'heading' => GetLang('QuickBooksShowSyncHeading'),
				'name' => GetLang('QuickBooksShowSync'),
				'type' => 'custom',
				'callback' => 'showSyncList',
				'help' => GetLang('QuickBooksShowSyncHelp')
			);

			$this->_variables['spool'] = array(
				'name' => GetLang('QuickBooksShowSpoolList'),
				'type' => 'custom',
				'callback' => 'showSpoolList',
				'javascript' => '',
				'help' => GetLang('QuickBooksShowSpoolListHelp'),
				'notemplate' => true,
			);

			$GLOBALS['AccountExtraJS'] = '$("#qb-help-box-password").html("' . $this->_password . '"); $("#qb-help-box").show();';
		}

		$GLOBALS['AccountExtraJS'] .= '; $("#accounting_quickbooks_scheduler").css("width", "305px");';
	}

	/**
	 * Check to see if QuickBooks can run or not
	 *
	 * Method will check to see if this module has all the included functions to work
	 *
	 * @access public
	 * @return bool TRUE if the module is supported, FALSE if not
	 */
	public function IsSupported()
	{
		if (!class_exists('SoapServer')) {
			$this->SetError(GetLang('QuickBooksSOAPNotAvailable'));
			return false;
		}

		if (!function_exists('simplexml_load_string') || !class_exists('SimpleXMLElement')) {
			$this->SetError(GetLang('QuickBooksXMLNotAvailable'));
			return false;
		}

		if (!class_exists('XMLWriter')) {
			$this->SetError(GetLang('QuickBooksXMLWriterNotAvailable'));
			return false;
		}

		return true;
	}

	/**
	 * Show the permission list HTML
	 *
	 * Method will build and return the permission list HTML. The permission list basically let the user decide what will
	 * be synced with QuickBooks
	 *
	 * @access public
	 * @return string The permission list HTML
	 */
	public function showPermissionList()
	{
		return parent::showPermissionList($this->getid());
	}

	/**
	 * The permission list callback JavaScript
	 *
	 * Method will return the javascript callback for the permission list
	 *
	 * @access public
	 * @return string The permission list callback javascript
	 */
	public function showPermissionListJS()
	{
		return parent::showPermissionListJS($this->getid());
	}

	/**
	 * Show the sync option list
	 *
	 * Method will return the HTML for the sync list options. Basically options to sync customers, products and orders
	 *
	 * @access public
	 * @return string The sync list HTML
	 */
	public function showSyncList()
	{
		return parent::showSyncList($this->getid());
	}

	public function importSync($type, $nodeid)
	{
		return parent::importSync($this->getid(), $type, $nodeid);
	}

	/**
	 * Display the spool list
	 *
	 * Method will build and return the spool list HTML
	 *
	 * @access public
	 * @return string The spool list HTML
	 */
	public function showSpoolList()
	{
		// Fetch any results, place them in the data grid
		$GLOBALS['QuickBooksSpoolListGrid'] = $this->showSpoolListGrid();

		// Was this an ajax based sort? Return the table now
		if (array_key_exists('ajax', $_REQUEST) && $_REQUEST['ajax'] == 1) {
			$this->ParseTemplate("module.quickbooks.spoollist");
			exit;
		} else if ($GLOBALS['QuickBooksSpoolListGrid'] !== '') {
			$GLOBALS['PropertyBox'] = $this->ParseTemplate("module.quickbooks.spoollist", true);
			return $this->ParseTemplate("module.quickbooks.spooladmin", true);
		}

		return '';
	}

	/**
	 * Display the spool list grid
	 *
	 * Method will build and return the spool list grid HTML
	 *
	 * @access public
	 * @return string The spool list HTML
	 */
	public function showSpoolListGrid()
	{
		$total = $this->getAccountingSpoolCount();

		/**
		 * If we have no jobs then display nothing
		 */
		if ($total == 0) {
			return '';
		}

		// Show a list of products in a table
		$page = 0;
		$start = 0;
		$numPages = 0;
		$GLOBALS['Nav'] = "";

		if (isset($_GET['page'])) {
			$page = (int)$_GET['page'];
		} else {
			$page = 1;
		}

		// Limit the number of orders returned
		if ($page < 1) {
			$page = 1;
		}

		$start		= ($page-1) * ISC_ACCOUNTING_SPOOLS_PER_PAGE;
		$numPages	= ceil($total / ISC_ACCOUNTING_SPOOLS_PER_PAGE);

		$list = $this->getAccountingSpoolList($start, ISC_ACCOUNTING_SPOOLS_PER_PAGE);

		// Add the "(Page x of n)" label
		if($total > ISC_ACCOUNTING_SPOOLS_PER_PAGE) {
			$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

			$GLOBALS['Nav'] .= BuildPagination($total, ISC_ACCOUNTING_SPOOLS_PER_PAGE, $page, 'index.php?ToDo=getJobAccountingSettingsSpoolList&module=' . $this->getid());
		}
		else {
			$GLOBALS['Nav'] = "";
		}

		$GLOBALS['Nav'] = rtrim($GLOBALS['Nav'], ' |');

		$grid = '';
		$GLOBALS['QuickBooksModuleID'] = $this->getid();

		foreach ($list as $spoolid => $spool) {

			$desc = parent::buildAccountingSpoolDescription($spool);
			$url = parent::buildAccountingSpoolURL($spool);
			$links = '';

			if (strtolower($spool['accountingspooltype']) == 'account') {
				$GLOBALS['JobDisabled']	= 'disabled="1"';
				$GLOBALS['JobURL']		= $desc;
				$status					= GetLang('Pending');
			} else {
				$GLOBALS['JobDisabled']	= '';
				$GLOBALS['JobURL']		= '<a href="' . $url . '" target="_blank">' . $desc . '</a>';
				if ($spool['accountingspooldisabled']) {
					if ((int)$spool['accountingspoolerrno'] !== 0) {
						$status = GetLang('Failed');
						if ($spool['accountingspoolerrmsg']) {
							$status .= '<br />' . isc_html_escape($desc['accountingspoolerrmsg']);
						}
					} else {
						$status = GetLang('Disabled');
						$links .= ' <a href="#" onclick="reenableQBCheckboxes(\'' . $spoolid . '\'); return false;">' . GetLang('Reenable') . '</a>';
					}
				} else {
					$status = GetLang('Pending');
					$links .= ' <a href="#" onclick="disableQBCheckboxes(\'' . $spoolid . '\'); return false;">' . GetLang('Disable') . '</a>';
				}

				$links .= ' &nbsp;<a href="#" onclick="deleteQBCheckboxes(\'' . $spoolid . '\'); return false;">' . GetLang('Delete') . '</a>';
			}

			$GLOBALS['JobName']		= $spoolid;
			$GLOBALS['JobType']		= $spool['accountingspooltype'];
			$GLOBALS['JobImage']	= $GLOBALS['ShopPath'] . '/modules/accounting/quickbooks/images/' . $spool['accountingspooltype'] . '.gif';
			$GLOBALS['JobStatus']	= $status;
			$GLOBALS['JobLinks']	= $links;

			$grid .= $this->ParseTemplate("module.quickbooks.spoollistitem", true);
		}

		return $grid;
	}

	/**
	 * Initialise the module
	 *
	 * Method will run the necessary operations for initialising the module. Each accounting module will have this module
	 *
	 * @access protected
	 * @return bool true if is the initialising was asuccessful, FALSE otherwise
	 */
	protected function initModule()
	{
		/**
		 * Create and save our auth details if we haven't already
		 */
		if (!$this->getSetupVariable($ref, 'password')) {
			$this->setSetupVariable('password', substr(md5(uniqid(mt_rand(), true)), 0, 12));
			$this->setSetupVariable('username', GetConfig('AdminEmail'));
			$this->setSetupVariable('fileid', substr(md5(GetConfig('AdminEmail')), 0, 8));
		}

		/**
		 * Now generate our needed spool files
		 */
		foreach ($this->_initdata as $data) {
			$this->createServiceRequest($data['type'], $data['service'], $data['data']);
		}
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
	 * @return int The accountingspool record ID on success, FALSE otherwise
	 */
	public function createServiceRequest($type, $service, $nodeid)
	{
		return $this->setAccountingSpool($type, $service, $nodeid);
	}

	/**
	 * Get a setup variable
	 *
	 * Method will return a setup variable that is stored in the database
	 *
	 * @access public
	 * @param mixed &$ref The referenced value to store the setup value in
	 * @param string $name The setup variable name
	 * @return bool TRUE if the setup varaible was found, FALSE otherwise
	 */
	public function getSetupVariable(&$ref, $name)
	{
		return parent::getSetupVariable($ref, $this->getid(), $name);
	}

	/**
	 * Set a setup variable
	 *
	 * Method will set a setup variable that is stored in the database
	 *
	 * @access protected
	 * @param string $name The setup variable name
	 * @param string $val The value to store as the setup variable
	 * @return bool TRUE if the setup varaible was set successfully, FALSE otherwise
	 */
	public function setSetupVariable($name, $value)
	{
		return parent::setSetupVariable($this->getid(), $name, $value);
	}

	/**
	 * Check to see if the lock file entry exists
	 *
	 * Method will checkt to see aif a lock file entry exists. If the first argument is TRUE, then remove the lock file if it is
	 * stale first before checking to see if it exists or not
	 *
	 * @access public
	 * @param bool $clean TRUE to remove the stale lock first, FALSE not to. Default is FALSE
	 * @return bool TRUE if the lock file entry exists and is still valid, FALSE otherwise
	 */
	public function checkLockFile($clean=true)
	{
		return parent::checkLockFile($this->getid(), $clean);
	}

	/**
	 * Set a lock file entry
	 *
	 * Function will create a lock file entry. If an entry already exists then function will return FALSE without modifying the
	 * lock cache file. The second argument $expire is a timestamp of the expiry date. The default expiry timestame is 6 hours
	 *
	 * @access public
	 * @param int $expire The default expire timestamp. Default is 6 hours
	 * @return bool TRUE if the lock was created, FALSE otherwise
	 */
	public function setLockFile($expire=null)
	{
		return parent::setLockFile($this->getid(), $expire);
	}

	/**
	 * Unset a lock file entry
	 *
	 * Function will unset a lock file entry
	 *
	 * @access public
	 * @return bool TRUE if the lock exists and was unset successfully, FALSE othewise
	 */
	public function unsetLockFile()
	{
		return parent::unsetLockFile($this->getid());
	}

	/**
	 * Check to see if the customer, customer group, product or order is in a module spool list
	 *
	 * Method will check to see if the $nodeID of type $type currently exists in one of the module spool lists
	 *
	 * @access public
	 * @param int $nodeId The node ID to check for (customerid, productid, etc)
	 * @param string $type The type of $nodeId this is ('customer', 'customergroup', 'product' or 'order')
	 * @return bool TRUE if the node is currently in the spool list, FALSE if not
	 */
	public function isNodeInSpool($nodeId, $type)
	{
		if (!isId($nodeId) || $type == '') {
			return false;
		}

		if ($this->getAccountingSpool($nodeId, $type)) {
			return true;
		}

		return false;
	}

	/**
	 * Get the accounting spool record total
	 *
	 * Method will return the total amount of accounting spool records
	 *
	 * @access public
	 * @param int $parentSpoolId The optional parent spool ID. Default is NULL (count all)
	 * @param bool $useCurrentImport TRUE to only count the spools in the current import, FALSE to count all. Default is FALSE
	 * @param bool $useExecutedOnly TRUE to only count the executed spools, FALSE to count all. Default is FALSE
	 * @return int The total amount of accounting spool records on success, FALSE on failure
	 */
	public function getAccountingSpoolCount($parentSpoolId=null, $useCurrentImport=false, $useExecutedOnly=false)
	{
		$lock = '';
		if ($useCurrentImport) {
			$lock = $this->getAccountingSessionKey('UUID');

			if (!$lock || $lock == '') {
				return false;
			}
		}

		return parent::getAccountingSpoolCount($this->getid(), $parentSpoolId, $lock, $useExecutedOnly);
	}

	/**
	 * Get an accounting spool record list
	 *
	 * Method will return a ist of all the accounting spool records
	 *
	 * @access protected
	 * @param int $start The option position to start from. Default is 0 (at the start)
	 * @param int $limit The option limit to limit the amount of records return. Default is -1 (unlimited)
	 * @return int The total amount of accounting spool records on success, FALSE on failure
	 */
	public function getAccountingSpoolList($start=0, $limit=-1)
	{
		return parent::getAccountingSpoolList($this->getid(), $start, $limit);
	}

	/**
	 * Get the records of all the accountingspool children
	 *
	 * Method will return a list of all the accountingspool children associated with the parent $spoolParentId
	 *
	 * @access public
	 * @param int $parentSpoolId The spool parent ID
	 * @return array An array of all the associated children accountingspool records on success, FALSE on error
	 */
	public function getAccountingSpoolChildren($spoolParentId)
	{
		if (!isId($spoolParentId)) {
			return false;
		}

		return parent::getAccountingSpoolChildren($this->getid(), $spoolParentId);
	}

	/**
	 * Set the selected spools in $spoolIdx as children of $spoolParentId
	 *
	 * Method will set all the accountingspool records associated with the array $spoolIdx to be children of $spoolParentId
	 *
	 * @access public
	 * @param int $parentSpoolId The spool parent ID
	 * @param mixed The child spool ID / array of IDs
	 * @return bool TRUE if all the spools were associated to be children of $spoolParentId
	 */
	public function setAccountingSpoolChildren($spoolParentId, $spoolIdx)
	{
		if (isId($spoolIdx)) {
			$spoolIdx = array($spoolIdx);
		}

		if (is_array($spoolIdx)) {
			$spoolIdx = array_filter($spoolIdx, "isId");
		}

		if (!isId($spoolParentId) || !is_array($spoolIdx) || empty($spoolIdx)) {
			return false;
		}

		return parent::getAccountingSpoolChildren($this->getid(), $spoolParentId, $spoolIdx);
	}

	/**
	 * Does child service already exist in parent spool $parentSpoolId
	 *
	 * Method will check to see if the child service $service already exists in the parent spool $parentSpoolId. Will only look
	 * in the first level (will not recurse).
	 *
	 * @access public
	 * @param int $parentSpoolId The parent spool ID
	 * @param string $service The child service
	 * @return array The accountingspool child record if the child service exists, NULL if not, FALSE on error
	 */
	public function isChildServiceInSpool($parentSpoolId, $service)
	{
		if (!isId($parentSpoolId) || $service == '') {
			return false;
		}

		return parent::isChildServiceInSpool($this->getid(), $parentSpoolId, $service);
	}

	/**
	 * Get an accountingspool record data
	 *
	 * Method will return a accountingspool record data
	 *
	 * @access public
	 * @param int $spoolId The accountingspoolid ID OR if $type is not empty then $id will be the accountingspoolnodeid
	 * @param string $type The optional node type (customer, product, order, etc)
	 * @return array The spool array on success, FALSE if the recird was not found
	 */
	public function getAccountingSpool($spoolId, $type="")
	{
		return parent::getAccountingSpool($this->getid(), $spoolId, $type);
	}

	/**
	 * Set an accountingspool record data
	 *
	 * Method will set an accountingspool record data
	 *
	 * @access public
	 * @param string $type The node type (customer, product, order, etc)
	 * @param string $service The node service. This is module dependent
	 * @param mixed $nodeid The node ID OR an array containing information about the node
	 * @param int $parentSpoolId The optional parent node ID. Default is null (no parent)
	 * @param bool $assignCurrentLock TRUE to also assign the current lock, FALSE to leave as default. Default is FALSE
	 * @return int The spool ID if the data was successfully written, FASLE othereise
	 */
	public function setAccountingSpool($type, $service, $nodeid, $parentSpoolId=null, $assignCurrentLock=false)
	{
		$lock = '';
		if ($assignCurrentLock) {
			$lock = $this->getAccountingSessionKey('UUID');

			if (!$lock || $lock == '') {
					return false;
			}
		}

		return parent::setAccountingSpool($this->getid(), $type, $service, $nodeid, $parentSpoolId, $lock);
	}

	/**
	 * Unset a spool job
	 *
	 * Method will unset a accountingspool record data
	 *
	 * @access public
	 * @param int $spoolId The accountingspool ID
	 * @return bool TRUE if the job was successfully removed, FASLE othereise
	 */
	public function unsetAccountingSpool($spoolId)
	{
		return parent::unsetAccountingSpool($this->getid(), $spoolId);
	}

	/**
	 * Enable a spool job
	 *
	 * Method will enable a accountingspool record data so it can be executed by QBWC
	 *
	 * @access public
	 * @param int $spoolId The accountingspool ID
	 * @return bool TRUE if the job was successfully removed, FASLE othereise
	 */
	public function enableAccountingSpool($spoolId)
	{
		return parent::enableAccountingSpool($this->getid(), $spoolId);
	}

	/**
	 * Disable a spool job
	 *
	 * Method will disable a accountingspool record data so it will be skipped by QBWC
	 *
	 * @access public
	 * @param int $spoolId The accountingspool ID
	 * @return bool TRUE if the job was successfully removed, FASLE othereise
	 */
	public function disableAccountingSpool($spoolId)
	{
		return parent::disableAccountingSpool($this->getid(), $spoolId);
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
	public function getAccountingSpoolStatus($spoolId)
	{
		if (!isId($spoolId)) {
			return false;
		}

		return parent::getAccountingSpoolStatus($this->getid(), $spoolId);
	}

	/**
	 * Parse out which service to execute
	 *
	 * Method will return which service to execute based on the spool ID $spoolId
	 *
	 * @acces public
	 * @param mixed $spool The spool ID or spool type if $service is set
	 * @param string $service The optional spool service.
	 * @return string The service to execute on success, FALSE if not service could be found
	 */
	public function getSpoolService($spool, $service='')
	{
		if (isId($spool) && $service == '') {
			$spool		= $this->getAccountingSpool($spool);
			$type		= $spool['accountingspooltype'];
			$service	= $spool['accountingspoolservice'];
		} else {
			$type = $spool;
		}

		if ($type == '' || $service == '') {
			return false;
		}

		$realService = '';

		switch (isc_strtolower($type)) {
			case 'customer':
				$realService = 'Customer';
				break;

			case 'customergroup':
				$realService = 'Pricelevel';
				break;

			case 'product':
				$realService = 'ItemInventory';
				break;

			case 'inventorylevel':
				$realService = 'InventoryAdjustment';
				break;

			case 'order':
				$realService = 'SalesOrder';
				break;

			case 'salestaxcode':
				$realService = 'SalesTaxCode';
				break;

			case 'account':
				$realService = 'Account';
				break;

			default:
				return false;
				break;
		}

		switch (isc_strtolower($service)) {
			case 'add':
			case 'query':
				$realService .= ucfirst(isc_strtolower($service));
				break;

			case 'edit':
				$realService .= 'Mod';
				break;

			default:
				return false;
				break;
		}

		return $realService;
	}

	/**
	 * Generate the QBWC file
	 *
	 * Method will generate and return the QBWC file string
	 *
	 * @access private
	 * @return string The QBWC file
	 */
	private function generateQBWC()
	{
		$GLOBALS['AppID']			= '';
		$GLOBALS['AppName']			= htmlentities($this->_appname);
		$GLOBALS['AppURL']			= htmlentities($this->_appurl);
		$GLOBALS['AppDescription']	= htmlentities($this->_appdesc);
		$GLOBALS['AppSupportURL']	= htmlentities($this->_appsupporturl);
		$GLOBALS['CertURL']			= htmlentities(GetConfig('ShopPathSSL'));
		$GLOBALS['Username']		= htmlentities($this->_username);
		$GLOBALS['OwnerID']			= '{' . $this->_ownerid . '}';
		$GLOBALS['FileID']			= '{' . $this->_fileid . '}';
		$GLOBALS['QBType']			= $this->_qbtype;
		$GLOBALS['IsReadOnly']		= 'false';
		$GLOBALS['Scheduler']		= '';

		$scheduler = $this->GetValue('scheduler');

		if (strtolower($scheduler) !== 'never') {
			$GLOBALS["Scheduler" ] = '<Scheduler>
			<RunEveryNMinutes>' . $scheduler . '</RunEveryNMinutes>
		</Scheduler>';
		}

		return $this->ParseTemplate('module.quickbooks.qbwc', true);
	}

	/**
	 * Output the QBWC to the browser
	 *
	 * Method will generate and output the QBWC file to the browser
	 *
	 * @access public
	 */
	public function downloadQBWC()
	{
		$xml = $this->generateQBWC();

		header('Content-Type: application/x-download');
		header('Content-Disposition: attachment; filename=shoppingcart.qwc');
		header('Content-Length: ' . strlen($xml));
		print $xml;
		exit;
	}

	/**
	 * Handle the SOAP gateway requests
	 *
	 * Method will setup the SOAP server and handle the SOAP request
	 *
	 * @access public
	 */
	public function handleGateway()
	{
		require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'headers' . DIRECTORY_SEPARATOR . 'gateway.php');

		$server = new ACCOUNTING_QUICKBOOKS_SERVER(___MODULE_QB_WSDL___);
		$server->handle();
		exit;
	}

	/**
	 * Modify a pending accountingspool status
	 *
	 * Method will modify a accountingspool status. Status are 'reenable', 'disable' and 'delete'
	 *
	 * @access public
	 * @param string $status The new job status
	 * @param array $spools The array conatining all the job names to modify
	 * @return bool TRUE if the jobs were successfully canged, FASLE otherwise
	 */
	public function modifyJobStatus($status, $spools)
	{
		$spools = array_filter($spools, "isId");

		if (!count($spools)) {
			return false;
		}

		switch (strtolower($status))
		{
			case 'reenable':
				$func = 'enableAccountingSpool';
				break;
			case 'disable':
				$func = 'disableAccountingSpool';
				break;
			case 'delete':
				$func = 'unsetAccountingSpool';
				break;
			default:
				return false;
				break;
		}

		foreach ($spools as $id) {
			$this->$func($id);
		}

		return true;
	}

	/**
	 * Get an accounting reference item
	 *
	 * Method will return an accounting reference record
	 *
	 * @access public
	 * @param mixed $nodeid The ID of the referenced item (customer id, order id, etc) OR the search criteria array for the reference data
	 * @param string $type The node type (customer, product or order)
	 * @param bool $valueOnly TRUE to only return the unserialised accountingrefvalue, FALSE for the whole record. Default is TRUE
	 * @return array The accountingref record if one was found, FALSE otherwise
	 */
	public function getAccountingReference($nodeid, $type, $valueOnly=true)
	{
		return parent::getAccountingReference($this->getid(), $nodeid, $type, $valueOnly);
	}

	/**
	 * Set an accounting reference item
	 *
	 * Method will set an accounting reference record
	 *
	 * @access public
	 * @param mixed $nodeid The ID of the referenced item (customer id, order id, etc) OR the search criteria array for the reference data
	 * @param string $type The node type (customer, product or order)
	 * @param mixed $reference The reference value to store
	 * @return int The accountref record ID if the record is unique and was inserted, false otherwise
	 */
	public function setAccountingReference($nodeid, $type, $reference)
	{
		return parent::setAccountingReference($this->getid(), $nodeid, $type, $reference);
	}

	/**
	 * Unset an accounting reference item
	 *
	 * Method will unset an accounting reference record
	 *
	 * @access public
	 * @param mixed $nodeid The ID of the referenced item (customer id, order id, etc) OR the search criteria array for the reference data
	 * @param string $type The node type (customer, product or order)
	 * @return bool true if the accountingref record was unset (deleted), FALSE otherwise
	 */
	public function unsetAccountingReference($nodeid, $type)
	{
		return parent::unsetAccountingReference($this->getid(), $nodeid, $type);
	}

	/**
	 * Get the permission mask
	 *
	 * Method will return the permission mask. The permission mask is a bitmask of the current permission set
	 *
	 * @access protected
	 * @return int The current permission bitmask set
	 */
	protected function getPermissionMask()
	{
		return $this->GetValue('permission');
	}

	/**
	 * Initialise the accounting session
	 *
	 * Method will initialise the accounting session used when importing/exporting the XML spool
	 *
	 * @access public
	 * @return bool TRUE if the session was initialised, FALSE on error
	 */
	public function initAccountingSession()
	{
		$session = array(
			'UUID'				=> '',
			'LAST_ERROR'		=> '',
			'CLIENT_COUNTRY'	=> '',
			'QBXML_VERSION'		=> '',
			'COMPANY_DATA'		=> null,
		);

		return parent::initAccountingSession($this->getid(), $session);
	}

	/**
	 * Get the stored session array value
	 *
	 * Method will returned the stored session array value
	 *
	 * @access public
	 * @param string $key The key corresponding to the stored value
	 * @return mixed The stored session information on success, NULL if key does not exists, FALSE on error
	 */
	public function getAccountingSessionKey($key)
	{
		return parent::getAccountingSessionKey($this->getid(), $key);
	}

	/**
	 * Set the stored session array value
	 *
	 * Method will set the stored session array value corresponding to the key $key
	 *
	 * @access public
	 * @param string $key The key corresponding to store the value in
	 * @param mixed $val The value to store
	 * @return bool TRUE if the value was set, FALSE on error
	 */
	public function setAccountingSessionKey($key, $val)
	{
		return parent::setAccountingSessionKey($this->getid(), $key, $val);
	}

	/**
	 * Unset the transaction session
	 *
	 * Method will unset the transaction session
	 *
	 * @access public
	 * @return bool TRUE if the session was unset, FALSE on error
	 */
	public function unsetAccountingSession()
	{
		return parent::unsetAccountingSession($this->getid());
	}

	/**
	 * Get the currently active accountingspool record
	 *
	 * Method will return the currenctly active accountingspool record
	 *
	 * @access public
	 * @return array The currently active accountingspool record if one was found, FASLE is the were none
	 */
	public function getCurrentSpool()
	{
		$lock = $this->getAccountingSessionKey('UUID');

		if (!$lock || $lock == '') {
			return false;
		}

		return parent::getCurrentSpool($this->getid(), $lock);
	}

	/**
	 * Set the currently active accountingspool record
	 *
	 * Method will set the currenctly active accountingspool record
	 *
	 * @access public
	 * @param int $spoolId The spool to be set as the currently active spool
	 * @return bool TRUE if the record was set, FALSE on error
	 */
	public function setCurrentSpool($spoolId)
	{
		if (!isId($spoolId)) {
			return false;
		}

		$lock = $this->getAccountingSessionKey('UUID');

		if (!$lock || $lock == '') {
			return false;
		}

		return parent::setCurrentSpool($this->getid(), $lock, $spoolId);
	}

	/**
	 * Set the error for a spool record
	 *
	 * Method will set the error message and number for a spool record
	 *
	 * @access public
	 * @param int $spoolId The spool ID
	 * @param string $errmsg The error message
	 * @param int $errno The error number
	 * @return bool TRUE if the error message and number were set, FALSE if no record could be found
	 */
	public function setSpoolError($spoolId, $errmsg, $errno)
	{
		if (!isId($spoolId) || $errmsg == '' || !isId($errno)) {
			return false;
		}

		return parent::setSpoolError($this->getid(), $spoolId, $errmsg, $errno);
	}

	/**
	 * Set a spool record as executed
	 *
	 * Method will set a spool record as executed
	 *
	 * @access public
	 * @param int $spoolId The spool to be set as executed
	 * @param bool $forceClean TRUE to also reset the accountingspooldisabled, accountingspoolerrmsg and accountingspoolerrno fields. Default is FALSE
	 * @return bool TRUE if the spool was set, FALSE if not
	 */
	public function setSpoolAsExecuted($spoolId, $forceClean=false)
	{
		if (!isId($spoolId)) {
			return false;
		}

		$lock = $this->getAccountingSessionKey('UUID');

		if (!$lock || $lock == '') {
			return false;
		}

		return parent::setSpoolAsExecuted($this->getid(), $lock, $spoolId, $forceClean);
	}

	/**
	 * Set the spool as failed
	 *
	 * Method will set the spool as a failed executed spool
	 *
	 * @access public
	 * @param int $spoolId The spool ID
	 * @param string $errmsg The error message
	 * @param int $errno The error number
	 * @return bool TRUE if the spool was set as failed, FALSE if no record could be found
	 */
	public function setSpoolAsFailed($spoolId, $errmsg, $errno)
	{
		if (!isId($spoolId) || $errmsg == '' || !isId($errno)) {
			return false;
		}

		if (!$this->disableAccountingSpool($spoolId)) {
			return false;
		}

		if (!$this->setSpoolAsExecuted($spoolId)) {
			return false;
		}

		if (!$this->setSpoolError($spoolId, $errmsg, $errno)) {
			return false;
		}

		return true;
	}

	/**
	 * Get the next spool
	 *
	 * Method will either get the next available sibling spool, the available parent spool or FALSE based upon the spool ID $spoolId
	 *
	 * @access public
	 * @param int $spoolId The spool ID to search from
	 * @return array The next available spool if successful, FALSE if there is none
	 */
	public function getNextSpool($spoolId)
	{
		if (!isId($spoolId)) {
			return false;
		}

		$lock = $this->getAccountingSessionKey('UUID');

		if (!$lock || $lock == '') {
			return false;
		}

		return parent::getNextSpool($this->getid(), $lock, $spoolId);
	}

	/**
	 * Remove all executed spools
	 *
	 * Method will remove all executed spools
	 *
	 * @access public
	 * @return bool TRUE if operation was successful, FALSE on error
	 */
	public function removeExecutedSpool($useLock=false)
	{
		$lock = '';
		if ($useLock) {
			$lock = $this->getAccountingSessionKey('UUID');

			if (!$lock || $lock == '') {
				return false;
			}
	   }

		return parent::removeExecutedSpool($this->getid(), $lock);
	}

	/**
	 * Set the spool list for an import
	 *
	 * Method will set the unexecuted records in the accountingspool to be available for import
	 *
	 * @access public
	 * @return bool TRUE if the setting was succesful, FALSE on error
	 */
	public function setAccountingSpoolImport()
	{
		$lock = $this->getAccountingSessionKey('UUID');

		if (!$lock || $lock == '') {
			return false;
		}

		return parent::setAccountingSpoolImport($this->getid(), $lock);
	}

	/**
	 * Get the spool return
	 *
	 * Method will return the stored executed spool return. The return will be in SimpleXML format
	 *
	 * @access public
	 * @param int $spoolId The spool to retrieve from
	 * @return object The return XML object if one was found and stored, FALSE is no return was stored
	 */
	public function getAccountingSpoolReturn($spoolId)
	{
		if (!isId($spoolId)) {
			return false;
		}

		$rtn = parent::getAccountingSpoolReturn($this->getid(), $spoolId);

		if ($rtn == '') {
			return false;
		}

		$rtn = simplexml_load_string($rtn);

		if (!$rtn) {
			return false;
		}

		return $rtn;
	}

	/**
	 * Set the spool return
	 *
	 * Method will set the stored executed spool return
	 *
	 * @access public
	 * @param int $spoolId The spool ID to set the return to
	 * @param string $return The spool return
	 * @return bool TRUE if the spool exists and the return was set, FALSE otherwise
	 */
	public function setAccountingSpoolReturn($spoolId, $return)
	{
		if (!isId($spoolId)) {
			return false;
		}

		if (is_object($return) && method_exists($return, 'asXML')) {
			$return = $return->asXML();
		}

		return parent::setAccountingSpoolReturn($this->getid(), $spoolId, $return);
	}

	/**
	 * Compare the qbXML version to the currently stored version that the client is using
	 *
	 * Method will compare the qbXML version $version to the version that the client is using. Return TRUE if the $verion is lower
	 * than the client's version (meaning that the client can read it), FALSE if the $version is higher that the client's version.
	 *
	 * This function uses the version_compare() PHP function to compare versions.
	 *
	 * @access protected
	 * @param string $version The version to compare
	 * @return bool TRUE if the $version is lower than the client's version, FALSE if higher
	 */
	public function compareClientVersion($version)
	{
		$version = (string)$version;

		if ($version == '') {
			return false;
		}

		$clientVersion = $this->getAccountingSessionKey('QBXML_VERSION');
		$clientVersion = (string)$clientVersion;

		if ($clientVersion == '' || version_compare($version, $clientVersion) == 1) {
			return false;
		}

		return true;
	}

	/**
	 * Compare the client's country version of their QuickBooks
	 *
	 * Method will compare the country code $country against the client's country version of their QuickBooks
	 *
	 * @access protected
	 * @param string $country The country code to compare against
	 * @return bool TRUE if the country code $country matches the client's country code, FALSE otherwise
	 */
	public function compareClientCountry($country)
	{
		if ($country == '') {
			return false;
		}

		$clientCountry = $this->getAccountingSessionKey('CLIENT_COUNTRY');

		if ($clientCountry == '' || isc_strtolower($country) !== isc_strtolower($clientCountry)) {
			return false;
		}

		return true;
	}
}

?>
