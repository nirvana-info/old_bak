<?php
@set_time_limit(0);
define("ISC_IMPORT_CATEGORIES_PER_PAGE", 100);
define("ISC_IMPORT_BRANDS_PER_PAGE", 100);
define("ISC_IMPORT_USERS_PER_PAGE", 100);
define("ISC_IMPORT_CUSTOMERS_PER_PAGE", 100);
define("ISC_IMPORT_PRODUCTS_PER_PAGE", 100);
define("ISC_IMPORT_ORDERS_PER_PAGE", 100);
define("ISC_IMPORT_REVIEWS_PER_PAGE", 100);
define("ISC_IMPORT_SUBSCRIBERS_PER_PAGE", 100);
define("ISC_IMPORT_WISHLISTS_PER_PAGE", 100);

while (ob_get_level()) {
	ob_end_clean();
}

/**
 * Interspire Shopping Cart Store Importer
 */
class ISC_ADMIN_CONVERTER
{
	/**
	 * @var array Array of information about the current import session.
	 */
	public $_importSession = array();

	/**
	 * @var array Multi-dimensional array comtaining the list of import fields for the importer.
	 */
	public $_importFields = array(
			"products" => array("importproductid"),
			"product_variations" => array("importoptionid"),
			"categories" => array("importcategoryid", "importparentid"),
			"brands" => array("importbrandid"),
			"customers" => array("importcustomerid"),
			"orders" => array("importorderid"),
			"users" => array("importuserid"),
			"reviews" => array("importreviewid"),
			"subscribers" => array("importsubscriberid"),
			"wishlists" => array("importwishlistid")
	);

	/**
	 * @var array Array for storing any pending log files to be written to the database at the end of page execution.
	 */
	public $_importErrors = array();

	/**
	 * @var boolean True to enable debug mode (logs all queries & errors)
	 */
	public $_Debug = false;

	/**
	 * Handle the incoming action.
	 *
	 * @param string The action to perform.
	 */
	public function HandleToDo($Do)
	{
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseLangFile(APP_ROOT."/../language/".GetConfig('Language')."/converter_language.ini");
		$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ImportStoreWizard') => "index.php?ToDo=Converter");

		if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Store_Importer) || GetConfig('DisableStoreImporters')) {
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
		}

		// Set the database to log all errors & queries if we're in debug mode
		if($this->_Debug == true) {
			$GLOBALS['ISC_CLASS_DB']->QueryLog = dirname(__FILE__)."/logs/isc.queries.txt";
			$GLOBALS['ISC_CLASS_DB']->TimeLog = dirname(__FILE__)."/logs/isc.query_time.txt";
			$GLOBALS['ISC_CLASS_DB']->ErrorLog = dirname(__FILE__)."/logs/isc.db_errors.txt";
		}

		switch (isc_strtolower($Do)) {
			case "convertercleanup": {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->CleanupConverter();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "cancelconverter": {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->CancelImport();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "cancelconvertermodule": {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->CancelModule();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "showconverterframe": {
				$this->ShowImportFrame();
				break;
			}
			case "showconverterreport": {
				$this->ShowConverterReport();
				break;
			}
			case "viewconverterlog": {
				$this->ViewConverterLog();
				break;
			}
			case "runconverter": {
				$this->RunModule();
				break;
			}
			default:
			{
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->InitializeImporter();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
			}
		}
	}

	/**
	 * Initialize the importer. This function checks if we're in an import session,
	 * if an importer is configured, if we're in a module or any other import action
	 * and then displays the appropriate page.
	 */
	public function InitializeImporter()
	{

		// Check is the import session table exists - if it does, we're currently in the middle of a session
		$query = "show tables like '[|PREFIX|]importsession'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

		if($row) {
			$this->_LoadImportSession();
		}

		// Currently in an import session, we skip straight to the modules page
		if(count($this->_importSession) > 0 && @array_key_exists('Configuration', $this->_importSession) && @array_key_exists('Warned', $this->_importSession)) {
			$className = "ISC_ADMIN_CONVERTER_".isc_strtoupper($this->_importSession['CurrentImporter']);
			require_once APP_ROOT."/includes/converter/importers/".$this->_importSession['CurrentImporter'].".php";
			$importer = new $className;

			$importer->_importSession = $this->_importSession;

			$importer->ShowModules(GetLang('ImportWizardContinue'), MSG_INFO);
		}
		// Just selected an importer
		else if(isset($_REQUEST['importer']) || $this->_importSession != false) {
			if(isset($_REQUEST['importer'])) {
				$_REQUEST['importer'] = str_replace(array(".", "/"), "", $_REQUEST['importer']); // Sanitize
				if(!file_exists(APP_ROOT."/includes/converter/importers/".$_REQUEST['importer'].".php")) {
					$this->ShowImporters("Invalid importer", MSG_ERROR);
					return;
				}

				require_once APP_ROOT."/includes/converter/importers/".$_REQUEST['importer'].".php";
				$className = "ISC_ADMIN_CONVERTER_".isc_strtoupper($_REQUEST['importer']);
				$importer = new $className;

				$configuration = 1;
				if(method_exists($importer, 'SaveConfiguration')) {
					$err = '';
					$configuration = $importer->SaveConfiguration($err);
					if($err != '') {
						$this->ShowImporters($err, MSG_ERROR);
						return;
					}
				}

				if(!$this->_CreateImportSession()) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError('', GetLang('ConverterUnableCreateImportFields'));
					exit;
					return;
				}

				if(!$importer->_CreateImportFields()) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError('', GetLang('ConverterUnableCreateImportFields'));
					exit;
					return;
				}

				if(isset($_POST['DeleteAll']) && $_POST['DeleteAll'] == 1) {
					$this->_importSession['DeleteAll'] = 1;
				}

				$this->_importSession['CurrentImporter'] = $_REQUEST['importer'];
				$this->_importSession['modules'] = array();
				$this->_importSession['Configuration'] = $configuration;
				$importer->_importSession = $this->_importSession;
			}
			else if($this->_importSession != false) {
				$className = "ISC_ADMIN_CONVERTER_".isc_strtoupper($this->_importSession['CurrentImporter']);
				require_once APP_ROOT."/includes/converter/importers/".$this->_importSession['CurrentImporter'].".php";
				$importer = new $className;
			}

			if(!array_key_exists('Warned', $this->_importSession)) {
				if(isset($_REQUEST['WarningAccept'])) {
					$this->_importSession['Warned'] = 1;
				}
				else if(method_exists($importer, 'ImportWarning')) {
					$importer->ImportWarning();
					$this->_UpdateImportSession();
					return;
				}
				else {
					// No warnings for this importer
					$this->_importSession['Warned'] = 1;
				}
			}
			$importer->ShowModules();
			$this->_UpdateImportSession();
		}
		// Not doing anything, show a list of importers
		else {
			$this->ShowImporters();
		}
	}

	/**
	 * Show a list of importers currently supported and allow configuration of the selected item.
	 *
	 * @param string The optional message to show at the top of the page.
	 * @param const A constant defining the type of message. MSG_ERROR, MSG_SUCCESS.
	 */
	public function ShowImporters($MsgDesc = '', $MsgStatus = '')
	{
			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$importers = $this->FetchImporterList();
			$GLOBALS['ImporterList'] = '';
			$GLOBALS['ConfigurationList'] = '';
			foreach($importers as $file => $info) {
				if(isset($info['configuration'])) {
					$GLOBALS['ConfigurationList'] .= "<div id=\"{$file}Configure\" class=\"ImporterConfiguration\" style=\"display: none;\"><br />" . $info['configuration'] . "</div>";
				}
				$selected = '';
				if(isset($_POST['importer']) && $_POST['importer'] == $file) {
					$selected = 'selected="selected"';
				}
				$GLOBALS['ImporterList'] .= sprintf("<option value=\"%s\" %s>%s</option>", $file, $selected, $info['title']);
			}
			$this->ParseTemplate('converters.show');
	}

	/**
	 * Show a list of modules supportedby the selected importer. Will also allow a user to run a module if they can, and show
	 * the module status.
	 *
	 * @param string The optional message to show at the top of the page.
	 * @param const A constant defining the type of message. MSG_ERROR, MSG_SUCCESS.
	 */
	public function ShowModules($MsgDesc = '', $MsgStatus = '')
	{

		// Fetch the modules for this importer
		$modules = $this->FetchModuleList();

		if(isset($this->_importSession['JustFinished']) && $this->_importSession['JustFinished'] != '') {
			if(isset($this->_importSession['ImportingAll'])) {
				$MsgDesc = GetLang('ImportAllFinished');
			}
			else {
				$MsgDesc = GetLang($this->_importSession['JustFinished'].'Finished');
			}
			$MsgStatus = MSG_SUCCESS;
			$this->_importSession['JustFinished'] = '';
			$this->_UpdateImportSession();
		}

		if ($MsgDesc != "") {
			$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
		}

		$GLOBALS['ModuleList'] = '';

		$GLOBALS['ImportTitle'] = GetLang($this->wizardTitle);

		$disable_all = false;
		if(isset($this->_importSession['CurrentModule']) && $this->_importSession['CurrentModule'] != '') {
			$disable_all = true;
		}

		$GLOBALS['ModuleHeader'] = sprintf(GetLang('ModuleHeader'), $this->title);

		$Remaining = count($this->_modules);
		$AtLeastOne = false;

		foreach($modules as $module => $info) {
			if(isset($this->_importSession['CurrentModule']) && $this->_importSession['CurrentModule'] == $module) {
				$GLOBALS['RunLink'] = sprintf("<a href=\"#\" onclick=\"RunImportModule('%s'); return false\">%s</a>", $module, "Continue Running");
				if(isset($this->_importSession[$module]['count']) && $this->_importSession[$module]['count'] > 0) {
					$percent = ceil($this->_importSession[$module]['done']/$this->_importSession[$module]['count']*100);
				}
				else {
					$percent = 0;
				}

				$GLOBALS['ModuleRun'] = sprintf("%s (%s%%)", GetLang('ImportPaused'), $percent);
			}
			else if($info['disabled'] == true || $disable_all == true || isset($info['finished'])) {
				$GLOBALS['RunLink'] = sprintf("<span class='Disabled'>%s</span>", GetLang('RunImportModule'));
			}
			else {
				$GLOBALS['RunLink'] = sprintf("<a href=\"#\" onclick=\"RunImportModule('%s'); return false\">%s</a>", $module, GetLang('RunImportModule'));
			}

			if(isset($info['finished'])) {
				$GLOBALS['ModuleClass'] = 'QuickView';
				$GLOBALS['ReportsLink'] = sprintf("<a href=\"#\" onclick=\"ShowReport('%s'); return false;\">%s</a>", $module, GetLang('ViewImportReport'));
				--$Remaining;
			}
			else {
				$GLOBALS['ModuleClass'] = '';
				$GLOBALS['ReportsLink'] = sprintf("<span class=\"Disabled\">%s</span>", GetLang('ViewImportReport'));
			}

			if(isset($this->_importSession[$module]['done'])) {
				$count = $this->_importSession[$module]['done'];
				if(isset($this->_importSession[$module]['errors'])) {
					$count -= $this->_importSession[$module]['errors'];
				}
			}

			if(isset($this->_importSession['CurrentModule']) && $this->_importSession['CurrentModule'] == $module) {
				$GLOBALS['Status'] = sprintf("<span style=\"color: maroon; font-weight: bold;\">%s</span>", GetLang('ImportPartiallyComplete'));
			}
			else if(!isset($info['finished']) || isset($info['cancelled'])) {
				$GLOBALS['Status'] = "N/A";
			}
			else if($count == 0 && isset($this->_importSession[$module]['errors']) && $this->_importSession[$module]['errors'] > 0) {
				$GLOBALS['Status'] = sprintf("<span style=\"color: red; font-weight: bold;\">%s</span>", GetLang('ImportFailed'));
			}
			else if(isset($this->_importSession[$module]['errors']) && $this->_importSession[$module]['errors'] > 0) {
				$GLOBALS['Status'] = sprintf("<span style=\"color: orange; font-weight: bold;\">%s</span>", GetLang('ImportPartial'));
			}
			else {
				$GLOBALS['Status'] = sprintf("<span style=\"color: green; font-weight: bold;\">%s</span>", GetLang('ImportSuccess'));
			}

			if(isset($info['finished'])) {
				$GLOBALS['ModuleRun'] = isc_date(GetConfig('ExtendedDisplayDateFormat'), $info['finished']);
			}
			else {
				$GLOBALS['ModuleRun'] = "Not Run Yet";
			}

			if(isset($this->_importSession[$module])) {
				$AtLeastOne = true;
			}

			// One or more dependencies still to be run
			$GLOBALS['Dependencies'] = '';
			if($info['dependencies'] != '') {
				$Dependencies = sprintf(GetLang('Dependencies'), $info['dependencies']);
				$GLOBALS['RunLink'] = sprintf("<a href=\"#\" onclick=\"alert('%s');\">%s</a>", $Dependencies, GetLang('RunImportModule'));
			}

			$GLOBALS['Module'] = $module;
			$GLOBALS['ModuleTitle'] = $info['name'];
			$GLOBALS['ModuleDesc'] = $info['description'];

			$GLOBALS['ModuleList'] .= $this->ParseTemplate('converters.modules.row', true);
		}

		if($AtLeastOne == true) {
			$GLOBALS['HideCancelButton'] = "none";
			$GLOBALS['ImportPartChecked'] = "checked=\"checked\"";
		}
		else {
			$GLOBALS['HideRollbackButton'] = "none";
			$GLOBALS['ImportAllChecked'] = " checked=\"checked\"";
		}

		if($Remaining == 0) {
			$GLOBALS['RunAllDisabled'] = "disabled='disabled'";
			$GLOBALS['HideRunAll'] = "none";
			$GLOBALS['HideImportOptions'] = 'none';
		}

		$this->ParseTemplate('converters.modules');
	}

	/**
	 * Show the "Import in Progress" iframe which contains a hidden iFrame that performs the actual import.
	 */
	public function ShowImportFrame()
	{
		$this->_LoadImportSession();

		require_once APP_ROOT."/includes/converter/importers/".$this->_importSession['CurrentImporter'].".php";
		$className = "ISC_ADMIN_CONVERTER_".isc_strtoupper($this->_importSession['CurrentImporter']);
		$importer = new $className;
		$importer->_importSession = $this->_importSession;

		$moduleList = array();

		// Chose to run all modules, get all unfinished modules and add them
		if($_REQUEST['module'] == "all") {
			foreach(array_keys($importer->_modules) as $module) {
				if(!isset($importer->_importSession[$module]['finished'])) {
					$moduleList[] = $module;
				}
			}
			$_REQUEST['module'] = array_shift($moduleList);
			$this->_importSession['ModuleStack'] = $moduleList;
			$this->_importSession['CleanupStack'] = array();
			$this->_importSession['ImportingAll'] = 1;
		}

		if(!method_exists($importer, $_REQUEST['module'])) {
			exit;
		}

		// Can this module be run? Check dependencies
		if(@is_array($importer->_modules[$_REQUEST['module']]['dependencies'])) {
			foreach($importer->_modules[$_REQUEST['module']]['dependencies'] as $dependency) {
				if(!isset($this->_importSession[$dependency])) {
					exit;
				}
			}
		}

		if(isset($this->_importSession[$_REQUEST['module']]['finished'])) {
			exit;
			return;
		}

		// Set up the import session to run this module
		$this->_importSession['CurrentModule'] = $_REQUEST['module'];
		if(!isset($this->_importSession[$_REQUEST['module']]) || (isset($this->_importSession[$_REQUEST['module']]) && isset($this->_importSession[$_REQUEST['module']]['cancelled']))) {
			$this->_importSession[$_REQUEST['module']] = array(
				"done" => 0,
				"total" => 0,
				"errors" => 0
			);
		}


		if(isset($this->_importSession['DeleteAll'])) {
			$GLOBALS['Title'] = GetLang('DeletingCurrentStoreStatusTitle');
			$GLOBALS['Description'] = GetLang('DeletingCurrentStoreStatusDesc');
		}
		else {
			$module = $this->_importSession['CurrentModule'];
			$GLOBALS['Title'] = GetLang($module.'StatusTitle');
			$GLOBALS['Description'] = GetLang($module.'StatusDesc');
		}

		$this->_UpdateImportSession();
		$GLOBALS['Random'] = time();

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$this->ParseTemplate("converters.progress");
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pagefooter.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
	 * Hide the import iFrame when a module is complete.
	 */
	public function HideImportFrame()
	{
		$this->UpdateProgress(GetLang('ImportComplete'));
		echo "<script type='text/javascript'>\n";
		echo "self.parent.ImportFinished();\n";
		echo "</script>";
	}

	/**
	 * This function removes everything from the Interspire Shopping Cart store before importing.
	 */
	public function ClearStore()
	{

		// Fetch any images
		$query = "
			SELECT pi.imagefile
			FROM [|PREFIX|]product_images pi
		";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			@unlink(APP_ROOT."../".GetConfig('ImageDirectory')."/".$row['imagefile']);
		}

		// Fetch any imported downloads
		$query = "
		SELECT pd.downfile
			FROM [|PREFIX|]product_downloads pd
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			@unlink(APP_ROOT."../".GetConfig('DownloadDirectory')."/".$row['downfile']);
		}

		$queries = array();
		$queries[] = "TRUNCATE [|PREFIX|]products";
		$queries[] = "TRUNCATE [|PREFIX|]categoryassociations";
		$queries[] = "TRUNCATE [|PREFIX|]product_customfields";
		$queries[] = "TRUNCATE [|PREFIX|]product_variations";
		$queries[] = "TRUNCATE [|PREFIX|]product_variation_combinations";
		$queries[] = "TRUNCATE [|PREFIX|]product_variation_options";
		$queries[] = "TRUNCATE [|PREFIX|]product_search";
		$queries[] = "TRUNCATE [|PREFIX|]product_images";
		$queries[] = "TRUNCATE [|PREFIX|]product_downloads";
		$queries[] = "TRUNCATE [|PREFIX|]categories";
		$queries[] = "TRUNCATE [|PREFIX|]brands";
		$queries[] = "TRUNCATE [|PREFIX|]orders";
		$queries[] = "TRUNCATE [|PREFIX|]order_products";
		$queries[] = "TRUNCATE [|PREFIX|]reviews";
		$queries[] = "TRUNCATE [|PREFIX|]subscribers";
		$queries[] = "TRUNCATE [|PREFIX|]wishlists";
		$queries[] = "TRUNCATE [|PREFIX|]wishlist_items";
		$queries[] = "TRUNCATE [|PREFIX|]customers";
		$queries[] = "TRUNCATE [|PREFIX|]shipping_addresses";

		// Delete all users bar the current user
		$queries[] = sprintf("DELETE FROM [|PREFIX|]users WHERE pk_userid!='%s'", $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUserId());

		$queries_run = 2; // Product images & downloads
		$total_queries = count($queries) + $queries_run;

		foreach ($queries as $query) {
			$GLOBALS['ISC_CLASS_DB']->Query($query);
			++$queries_run;
			$this->UpdateProgress(GetLang('ConverterDeletingStore'), $queries_run, $total_queries);
		}

		// Clear all of the contents from the data store so it'll be rebuilt when we next hit the shopping cart
		$GLOBALS['ISC_CLASS_DATA_STORE']->Clear();
	}

	/**
	 * Run an import module for an importer. This is a dummy function which calls the child class' ReallyRunModule
	 * after setting up the importer.
	 */
	public function RunModule()
	{
		$this->_LoadImportSession();

		if(isset($this->_importSession['DeleteAll'])) {
			$this->ClearStore();
			unset($this->_importSession['DeleteAll']);
			$this->_UpdateImportSession();
			echo "<script type=\"text/javascript\">self.parent.location = 'index.php?ToDo=showConverterFrame&module=".$this->_importSession['CurrentModule']."&random='+new Date().getTime();</script>\n";
			exit;
		}

		require_once APP_ROOT."/includes/converter/importers/".$this->_importSession['CurrentImporter'].".php";
		$className = "ISC_ADMIN_CONVERTER_".isc_strtoupper($this->_importSession['CurrentImporter']);
		$importer = new $className;
		$importer->_importSession = $this->_importSession;
		$importer->ReallyRunModule();
	}

	/**
	 * Run an import module. This function is the "work horse" of the import system.
	 */
	public function ReallyRunModule()
	{
		if(method_exists($this, "Connect")) {
			$this->Connect();
		}

		// Are we currently running a module?
		if($this->_importSession['CurrentModule']) {

			$this->Debug("In module");

			$module = $this->_importSession['CurrentModule'];

			// This module has just finished running. Is there a cleanup method we need to run?
			if(isset($this->_importSession[$module]['running']) == 1 && $this->_importSession[$module]['done'] >= $this->_importSession[$module]['count']) {
				if(method_exists($this, $module."Cleanup")) {
					$action = $module."Cleanup";
					$this->Debug('[CLEANUP] '.$module);
					$this->$action();
				}
				// Now we're all cleaned up, this module is complete.
				$this->_importSession['JustFinished'] = $this->_importSession['CurrentModule'];
				$this->_importSession['CleanupStack'][] = $this->_importSession['CurrentModule'];
				$this->_importSession['CurrentModule'] = '';
				$this->_importSession[$module]['finished'] = time();

				// Still have one or more modules to run? (we're doing an all)
				if(isset($this->_importSession['ModuleStack']) && count($this->_importSession['ModuleStack']) > 0) {
					$next = array_shift($this->_importSession['ModuleStack']);
					if($next) {
						$this->_UpdateImportSession();
						$this->_WritePendingImportLogs();
						if(!isset($this->_importSession[$next])) {
							echo "<script type=\"text/javascript\">self.parent.location = 'index.php?ToDo=showConverterFrame&module=".$next."&time=".time()."';</script>\n";
							exit;
						}
					}
				}

				$this->_UpdateImportSession();
				$this->_WritePendingImportLogs();
				$this->HideImportFrame(true);
			}
			// Still running a module
			else {
				$this->_importSession[$module]['running'] = 1;
				$this->$module();
			}
			$this->_UpdateImportSession();
			$this->_WritePendingImportLogs();

			// Clear all of the contents from the data store so it'll be rebuilt when we next hit the shopping cart
			$GLOBALS['ISC_CLASS_DATA_STORE']->Clear();

			echo "<script type=\"text/javascript\">setTimeout(function() { window.location = 'index.php?ToDo=runConverter&time=".time()."'}, 10);</script>\n";
			exit;
		}
	}

	/**
	 * Show the import containing the success/failure count for a particular module.
	 */
	public function ShowConverterReport()
	{
		$this->_LoadImportSession();

		if(!isset($_GET['module'])) {
			exit;
		}

		if(!isset($this->_importSession[$_GET['module']])) {
			exit;
		}

		$GLOBALS['Report'] = $this->BuildConverterReport($_GET['module'], $this->_importSession[$_GET['module']]);

		$GLOBALS['ReportTitle'] = GetLang('ReportTitle' . $_GET['module']);
		$GLOBALS['ReportDesc'] = GetLang('ReportDesc' . $_GET['module']);
		$GLOBALS['Module'] = $_GET['module'];

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$this->ParseTemplate("converters.report");
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pagefooter.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
	 * Build a report of the number of succeses & failures for a particular module.
	 *
	 * @param string The module identifier.
	 * @param array Array of information containing the statistics for this module.
	 * @return string The generated report.
	 */
	public function BuildConverterReport($module, $moduleInfo)
	{
		$report = '<ul>';
		if(isset($moduleInfo['errors'])) {
			$moduleInfo['done'] -= $moduleInfo['errors'];
		}

		foreach(array('done') as $type) {
			$amount = $moduleInfo[$type];
			$report .= "<li>\n";
			if($amount == 1) {
				$report .= GetLang('Report' . $module . ucfirst($type) . 'One');
			}
			else {
				$amount = $amount;
				$report .= sprintf(GetLang('Report' . $module . ucfirst($type) . 'Many'), $amount);
			}
			$report .= "</li>\n";
		}

		foreach(array('invalid', 'duplicates') as $type) {
			if(!isset($moduleInfo[$type])) {
				$moduleInfo[$type] = 0;
			}

			$amount = number_format($moduleInfo[$type]);
			$report .= "<li>\n";
			if($amount == 1) {
				$report .= GetLang('Report' . $module . ucfirst($type) . 'One');
				$report .= sprintf(" <a href=\"javascript:ShowReport('%s');\">%s</a>", $type, GetLang('MoreInformation'));
			}
			else if($amount > 1) {
				$amount = number_format($amount);
				$report .= sprintf(GetLang('Report' . $module . ucfirst($type) . 'Many'), $amount);
				$report .= sprintf(" <a href=\"javascript:ShowReport('%s');\">%s</a>", $type, GetLang('MoreInformation'));
			}
			else {
				$report .= sprintf(GetLang('Report' . $module . ucfirst($type) . 'Many'), $amount);
			}
			$report .= "</li>\n";
		}
		$report .= "</ul>";
		return $report;
	}

	/**
	 * View the contents of a particular log file for a module (failed/duplicate records)
	 */
	public function ViewConverterLog()
	{
		$this->_LoadImportSession();

		if(!isset($_GET['module'])) {
			exit;
		}

		if(!isset($this->_importSession[$_GET['module']])) {
			exit;
		}

		$GLOBALS['Results'] = '';
		$query = sprintf("select data from [|PREFIX|]importsession where type='log' and module='%s' and log='%s'", $_GET['module'], $GLOBALS['ISC_CLASS_DB']->Quote($_GET['log']));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$GLOBALS['Results'] .= isc_html_escape(trim($row['data']))."\n";
		}

		switch($_GET['log']) {
			case "duplicates":
				$GLOBALS['Heading'] = GetLang('LogTitleDuplicates');
				$GLOBALS['Intro'] = GetLang('LogIntroDuplicates');
				break;
			default:
				$GLOBALS['Heading'] = GetLang('LogTitleInvalid');
				$GLOBALS['Intro'] = GetLang('LogIntroInvalid');
				break;
		}
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$this->ParseTemplate("converters.log");
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pagefooter.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		exit;

	}

	/**
	 * Cancel running an entire import process. This function will also rollback any changes that were made.
	 */
	public function CancelImport()
	{
		// Check is the import session table exists - if it does, we're currently in the middle of a session
		$query = "show tables like '[|PREFIX|]importsession'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

		if(!$row) {
			$this->ShowImporters();
			return;
		}
		$this->_LoadImportSession();
		if(isset($this->_importSession['CurrentImporter'])) {
			@require_once APP_ROOT."/includes/converter/importers/".$this->_importSession['CurrentImporter'].".php";
			$className = "ISC_ADMIN_CONVERTER_".isc_strtoupper($this->_importSession['CurrentImporter']);
			$importer = new $className;
			$importer->_importSession = $this->_importSession;
			$importer->Connect();
			foreach(array_keys($importer->_modules) as $module) {
				$cleanup = "Undo".$module;
				if(method_exists($importer, $cleanup)) {
					$importer->$cleanup();
				}
			}
		}
		// Delete the import session
		$GLOBALS['ISC_CLASS_DB']->Query("drop table [|PREFIX|]importsession");
		$this->_DropImportFields();
		unset($this->_importSession);

		$this->ShowImporters(GetLang('ImportCancelled'), MSG_SUCCESS);
	}

	/**
	 * Run when a user clickls "I've Finished Importing'. This step removes the import fields, and import session.
	 */
	public function CleanupConverter()
	{
		// Check is the import session table exists - if it does, we're currently in the middle of a session
		$query = "show tables like '[|PREFIX|]importsession'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

		if(!$row) {
			$this->ShowImporters();
			return;
		}

		$this->_LoadImportSession();

		if(isset($this->_importSession['CurrentImporter'])) {
			// Delete the import session
			$GLOBALS['ISC_CLASS_DB']->Query("drop table [|PREFIX|]importsession");
			$this->_DropImportFields();
			unset($this->_importSession);
		}

		$GLOBALS['Message'] = MessageBox(GetLang('ImportStoreWizardFinishedMsg'), MSG_SUCCESS);
		$this->ParseTemplate("converters.finished");
		return;
	}

	/**
	 * Cancel running a particular import module for an importer. This function will also attempt to rollback
	 * any changes that were made by this module.
	 */
	public function CancelModule()
	{
		$this->_LoadImportSession();

		require_once APP_ROOT."/includes/converter/importers/".$this->_importSession['CurrentImporter'].".php";
		$className = "ISC_ADMIN_CONVERTER_".isc_strtoupper($this->_importSession['CurrentImporter']);
		$importer = new $className;
		$importer->_importSession = &$this->_importSession;
		$importer->Connect();

		if(isset($importer->_importSession['ImportingAll'])) {
			$CleanupStack = $this->_importSession['CleanupStack'];
			unset($this->_importSession['ImportingAll']);
			unset($this->_importSession['ModuleStack']);
		}
		else {
			$CleanupStack = array($this->_importSession['CurrentModule']);
		}

		foreach($CleanupStack as $module) {
			$cleanup = "Undo".$module;
			if(method_exists($importer, $cleanup)) {
				$importer->$cleanup();
			}
			// Delete any import logs
			$query = sprintf("delete from [|PREFIX|]importsession WHERE type='log' AND module='%s'", $module);
			$GLOBALS['ISC_CLASS_DB']->Query($query);
			$this->_importSession[$module]['cancelled'] = 1;
			$this->_importSession[$module]['finished'] = 1;
		}

		unset($this->_importSession[$this->_importSession['CurrentModule']]);
		$this->_importSession['CurrentModule'] = '';
		$this->_importSession['ModuleStack'] = array();
		$this->_UpdateImportSession();

		$importer->ShowModules(GetLang('ImportModuleCancelled'), MSG_SUCCESS);
	}


	/**
	 * Update the import progress bar.
	 *
	 * @param string The action we're performing ('Importing x of y..')
	 * @param int The number of iterms imported so far.
	 * @param int The total number of items to be imported.
	 */
	public function UpdateProgress($action, $done=0, $total=0)
	{
		static $lastPercent;
		if($total > 0) {
			$percent = ceil($done/$total*100);
		}
		else {
			$percent = 100;
		}
		// We only show an updated progress bar if the rounded percentage has actually chanegd
		if($percent == $lastPercent) {
			return;
		}

		$lastPercent = $percent;
		$action = sprintf($action, $done, $total);
		echo "<script type='text/javascript'>\n";
		echo sprintf("self.parent.UpdateProgress('%s', '%s');", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), $action), $percent);
		echo "</script>";
		flush();
	}

	/**
	 * Insert an imported product in to the database. This function also performs any necessary validation & error checking.
	 * It also handles inserting product images, downloads, custom fields, options and other product information.
	 *
	 * @param int The ID of the product from the existing system.
	 * @param array Array of product information to insert.
	 * @param string The import error message (returned by reference)
	 * @return boolean True if successful, false on failure.
	 */
	public function InsertProduct($productId, $productData, &$err)
	{
		if(!isset($productData['prodname']) || $productData['prodname'] == '') {
			$err = sprintf(GetLang('ImportProductErrorInvalid'), $productId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if(!isset($productData['categories']) || count($productData['categories']) == 0) {
			$err = sprintf(GetLang('ImportProductErrorInvalidCategory'), $productData['prodname']);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if(!isset($productData['prodprice'])) {
			$err = sprintf(GetLang('ImportProductErrorInvalidPrice'), $productData['prodname']);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if($this->IsDuplicateProduct($productData['prodname'])) {
			$err = sprintf(GetLang('ImportProductErrorDuplicate'), $productData['prodname']);
			$this->_LogImportError('duplicates', $err);
			return false;
		}

		if(isset($productData['downloads']) && count($productData['downloads']) > 0) {
			$productData['prodtype'] = 2;
		}
		else {
			$productData['prodtype'] = 1;
		}

		// We have a brand name and we've also chosen to import brand names
		if(isset($productData['prodbrandid'])) {
			$brandId = $this->GetImportBrandId($productData['prodbrandid']);
		}
		else {
			$brandId = 0;
		}

		if(!isset($productData['prodvisible']) || $productData['prodvisible'] != 0) {
			$productData['prodvisible'] = 1;
		}

		if(!isset($productData['prodfeatured']) || $productData['prodfeatured'] != 1) {
			$productData['prodfeatured'] = 0;
		}

		if(!isset($productData['prodfreeshipping']) || $productData['prodfreeshipping'] != 1) {
			$productData['prodfreeshipping'] = 0;
		}

		if(!isset($productData['prodinvtrack']) || ($productData['prodinvtrack'] != 1 && $productData['prodinvtrack'] != 2)) {
			$productData['prodinvtrack'] = 0;
		}

		if(!isset($productData['prodsearchkeywords'])) {
			$productData['prodsearchkeywords'] = '';
		}

		if(!isset($productData['prodavailability'])) {
			$productData['prodavailability'] = '';
		}

		if(!isset($productData['prodsaleprice'])) {
			$productData['prodsaleprice'] = 0;
		}

		if(!isset($productData['prodcostprice'])) {
			$productData['prodcostprice'] = 0;
		}

		if(!isset($productData['prodretailprice'])) {
			$productData['prodretailprice'] = 0;
		}

		if(!isset($productData['prodsortorder'])) {
			$productData['prodsortorder'] = 0;
		}

		if(!isset($productData['prodrelatedproducts'])) {
			$productData['prodrelatedproducts'] = -1;
		}
		else if(is_array($productData['prodrelatedproducts'])) {
			$productData['prodrelatedproducts'] = implode(",", $productData['prodrelatedproducts']);
		}

		if(!isset($productData['prodwarranty'])) {
			$productData['prodwarranty'] = '';
		}

		if(!isset($productData['prodwidth'])) {
			$productData['prodwidth'] = 0;
		}

		if(!isset($productData['proddepth'])) {
			$productData['proddepth'] = 0;
		}

		if(!isset($productData['prodheight'])) {
			$productData['prodheight'] = 0;
		}

		if(!isset($productData['prodfixedshippingcost'])) {
			$productData['prodfixedshippingcost'] = 0;
		}

		if(!isset($productData['prodoptionsrequired'])) {
			$productData['prodoptionsrequired'] = 0;
		}

		if(!isset($productData['prodnumviews'])) {
			$productData['prodnumviews'] = 0;
		}

		if(!isset($productData['prodmetakeywords'])) {
			$productData['prodmetakeywords'] = '';
		}

		if(!isset($productData['prodmetadesc'])) {
			$productData['prodmetadesc'] = '';
		}

		if(!isset($productData['prodlayoutfile'])) {
			$productData['prodlayoutfile'] = 0;
		}

		$calculatedPrice = CalcRealPrice($productData['prodprice'], @$productData['prodretailprice'], @$productData['prodretailprice'], @$productData['prodistaxable']);

		$prodCats = array();
		// Insert any category associations
		foreach($productData['categories'] as $catId) {
			$categoryId = $this->GetImportCategoryId($catId);
			$prodCats[] = $categoryId;
		}

		$prodCatsCSV = implode(',', $prodCats);

		$product = array(
			"importproductid" => $productId,
			"prodname" => $productData['prodname'],
			"prodtype" => (int)$productData['prodtype'],
			"prodcode" => $productData['prodcode'],
			"proddesc" => $productData['proddesc'],
			"prodsearchkeywords" => $productData['prodsearchkeywords'],
			"prodavailability" => $productData['prodavailability'],
			"prodprice" => (float)$productData['prodprice'],
			"prodcostprice" => (float)$productData['prodcostprice'],
			"prodretailprice" => (float)$productData['prodretailprice'],
			"prodsaleprice" => (float)$productData['prodsaleprice'],
			"prodcalculatedprice" => (float)$calculatedPrice,
			"prodsortorder" => (int)$productData['prodsortorder'],
			"prodvisible" => $productData['prodvisible'],
			"prodfeatured" => $productData['prodfeatured'],
			"prodrelatedproducts" => $productData['prodrelatedproducts'],
			"prodcurrentinv" => (int)$productData['prodcurrentinv'],
			"prodlowinv" => (int)$productData['prodlowinv'],
			"prodoptionsrequired" => $productData['prodoptionsrequired'],
			"prodwarranty" => $productData['prodwarranty'],
			"prodweight" => (float)$productData['prodweight'],
			"prodwidth" => (float)$productData['prodwidth'],
			"prodheight" => (float)$productData['prodheight'],
			"proddepth" => (float)$productData['proddepth'],
			"prodfixedshippingcost" => (float)$productData['prodfixedshippingcost'],
			"prodfreeshipping" => $productData['prodfreeshipping'],
			"prodinvtrack" => $productData['prodinvtrack'],
			"prodratingtotal" => 0,
			"prodnumratings" => 0,
			"prodnumsold" => (int)$productData['prodnumsold'],
			"proddateadded" => (int)$productData['proddateadded'],
			"prodbrandid" => $brandId,
			"prodnumviews" => (int)$productData['prodnumviews'],
			"prodmetakeywords" => $productData['prodmetakeywords'],
			"prodmetadesc" => $productData['prodmetadesc'],
			"prodcatids" => $prodCatsCSV,
			"prodmyobasset" => '',
			"prodmyobincome" => '',
			"prodmyobexpense" => '',
			"prodpeachtreegl" => ''
		);
		$productId = $this->ConvertedInsertQuery("products", $product);
		if(!$productId) {
			$err = "Failed to insert product (DEBUG)";
			$this->_LogImportError('invalid', $err);
			return false;
		}

		// Insert any category associations
		foreach($prodCats as $categoryId) {
			$association = array(
				"productid" => $productId,
				"categoryid" => $categoryId
			);
			$this->ConvertedInsertQuery("categoryassociations", $association);
		}

		// Are there any product images that need to be inserted?
		$has_thumb = false;
		$has_tiny = false;
		$thumb_file = '';
		$tiny_file = '';
		$firstImage = '';
		if(is_array($productData['images'])) {
			$GLOBALS['ISC_CLASS_ADMIN_PRODUCT'] = GetClass('ISC_ADMIN_PRODUCT');
			foreach($productData['images'] as $k => $image) {
				// Only copy across product images that exist
				if(isset($image['imagefile']) && !file_exists($image['imagefile'])) {
					continue;
				}

				// Copy the file across to the store
				$randomDir = strtolower(chr(rand(65, 90)));
				if(!is_dir(ISC_BASE_PATH."/".GetConfig('ImageDirectory')."/".$randomDir)) {
					if(!@mkdir(ISC_BASE_PATH."/".GetConfig('ImageDirectory')."/".$randomDir, 0777)) {
						$randomDir = '';
					}
				}

				if(isset($image['imagedata']) && $image['imagedata'] !== '') {
					$fileName = $randomDir."/".GenRandFileName($image['imagefilename']);
				}
				else {
					$fileName = $randomDir."/".GenRandFileName(basename($image['imagefile']));
				}

				$dest = ISC_BASE_PATH."/".GetConfig('ImageDirectory');
				$dest .= "/" . $fileName;

				if(isset($image['imagedata']) && $image['imagedata'] !== '') {
					file_put_contents($dest, $image['imagedata']);
				}
				else {
					copy($image['imagefile'], $dest);
				}

				// Is this image supposed to be a thumbnail?
				if(isset($image['imageisthumb']) && $image['imageisthumb'] == 1) {
					if(!$has_thumb) {
						$has_thumb = true;
						$thumb_file = $fileName;
					}
					continue;
				}
				// Is this image supposed to be a tiny version?
				if(isset($image['imageisthumb']) && $image['imageisthumb'] == 2) {
					if(!$has_tiny) {
						$has_tiny = true;
						$tiny_file = $fileName;
					}
					continue;
				}

				if($firstImage == '') {
					$firstImage = $fileName;
				}

				// A normal product image
				$newImage = array(
					"imageprodid" => $productId,
					"imagefile" => $fileName,
					"imageisthumb" => $image['imageisthumb'],
					"imagesort" => $k+1
				);
				$this->ConvertedInsertQuery("product_images", $newImage);
			}

			// Now the main images are done, we can build the thumbnails
			if($firstImage && !$thumb_file) {
				$thumb_file = $firstImage;
				$thumb = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($firstImage, "thumb");
			}
			else {
				// Override the existing thumbnail image with the smaller version
				$thumb = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($thumb_file, "thumb", true);
			}

			if($thumb) {
				$newImage = array(
					"imageprodid" => $productId,
					"imagefile" => $thumb,
					"imageisthumb" => 1,
					"imagesort" => 0
				);
				$this->ConvertedInsertQuery("product_images", $newImage);

				// If we don't have a tiny version, default to the thumb size and we'll generate it below
				if(!$tiny_file) {
					$tiny_file = $thumb;
				}
			}

			if($tiny_file != '') {
				$thumb = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($tiny_file, "tiny");
				if($thumb) {
					$newImage = array(
						"imageprodid" => $productId,
						"imagefile" => $thumb,
						"imageisthumb" => 2,
						"imagesort" => 0
					);
					$this->ConvertedInsertQuery("product_images", $newImage);
				}
			}
		}
		// Are there any custom fields that need to be inserted for this product?
		if(isset($productData['customfields']) && is_array($productData['customfields'])) {
			foreach($productData['customfields'] as $name => $value) {
				if($name === '') {
					continue;
				}
				$newField = array(
					"fieldprodid" => $productId,
					"fieldname" => $name,
					"fieldvalue" => $value
				);
				$this->ConvertedInsertQuery("product_customfields", $newField);
			}
		}
		$variationId = 0;
		// Are there any variations for this product?
		if(isset($productData['variations']) && is_array($productData['variations'])) {
			// Create a variation group for this set of variations
			$newVariation = array(
				"vname" => $productData['prodname']." Options",
				"vnumoptions" => 0
			);
			$variationId = $this->ConvertedInsertQuery("product_variations", $newVariation);

			// Insert the different combinations we have
			$vOptions = array();
			foreach($productData['variations'] as $variation) {
				if(!isset($variation['vcsku'])) {
					$variation['vcsku'] = '';
				}
				if(!isset($variation['vcpricediff'])) {
					$variation['vcpricediff'] = '';
				}
				if(!isset($variation['vcprice'])) {
					$variation['vcpricediff'] = 0;
				}
				if(!isset($variation['vcweightdiff'])) {
					$variation['vcweightdiff'] = '';
				}
				if(!isset($variation['vcweight'])) {
					$variation['vcweight'] = 0;
				}
				if(!isset($variation['vcstock'])) {
					$variation['vcstock'] = 0;
				}
				if(!isset($variation['vclowstock'])) {
					$variation['vclowstock'] = 0;
				}

				$imageFile = '';
				$thumbFile = '';

				// This variation has an image, we need to copy it across
				if(isset($variation['vcimage']) && $variation['vcimage'] != '') {
					if(file_exists($variation['vcimage'])) {
						// Copy across to the store
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir(ISC_BASE_PATH."/".GetConfig('ImageDirectory')."/".$randomDir)) {
							if(!@mkdir(ISC_BASE_PATH."/".GetConfig('ImageDirectory')."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}
						$fileName = $randomDir."/".GenRandFileName(basename($variation['vcimage']));
						$dest = ISC_BASE_PATH."/".GetConfig('ImageDirectory');
						$dest .= "/" . $fileName;
						if(!copy($variation['vcimage'], $dest)) {
							$imageFile = '';
							$mainDest = $dest;
						}
						else {
							$imageFile = $fileName;
							if(!isset($variation['vcthumb']) || $variation['vcthumb'] == '') {
								$variation['vcthumb'] = $dest;
							}
						}
					}
				}

				// This variation has a thumb
				if(isset($variation['vcthumb']) && $variation['vcthumb'] != '') {
					if(file_exists($variation['vcthumb'])) {
						// Copy across to the store
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir(ISC_BASE_PATH."/".GetConfig('ImageDirectory')."/".$randomDir)) {
							if(!@mkdir(ISC_BASE_PATH."/".GetConfig('ImageDirectory')."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}
						$fileName = $randomDir."/".GenRandFileName(basename($variation['vcthumb']));
						$dest = ISC_BASE_PATH."/".GetConfig('ImageDirectory');
						$dest .= "/" . $fileName;

						// Copied across the image
						if(copy($variation['vcthumb'], $dest)) {
							// Now we need to resize it
							$thumbFile = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($dest, "thumb", true);
						}
					}
				}

				// Build the list of option IDs
				$optionIds = array();
				foreach($variation['options'] as $optName => $optValue) {
					if(!isset($vOptions[$optName][$optValue])) {
						// Creating a new option
						$newOption = array(
							"vovariationid" => $variationId,
							"voname" => $optName,
							"vovalue" => $optValue
						);
						$vOptions[$optName][$optValue] = $this->ConvertedInsertQuery("product_variation_options", $newOption);
					}
					$optionIds[] = $vOptions[$optName][$optValue];
				}
				$optionIds = implode(",", $optionIds);

				// Now insert the actual combination
				$newCombination = array(
					"vcproductid" => $productId,
					"vcvariationid" => $variationId,
					"vcenabled" => 1,
					"vcoptionids" => $optionIds,
					"vcsku" => $variation['vcsku'],
					"vcpricediff" => $variation['vcpricediff'],
					"vcprice" => $variation['vcprice'],
					"vcweightdiff" => $variation['vcweightdiff'],
					"vcweight" => $variation['vcweight'],
					"vcimage" => $imageFile,
					"vcthumb" => $thumbFile,
					"vcstock" => $variation['vcstock'],
					"vclowstock" => $variation['vclowstock']
				);

				// Insert the combination
				$this->ConvertedInsertQuery("product_variation_combinations", $newCombination);
			}

			$updatedProduct = array(
				"prodvariationid" => $variationId
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $updatedProduct, "productid='".$productId."'");

			// Set the number of options for this variation set
			$updatedVariation = array(
				"vnumoptions" => count($vOptions)
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_variations", $updatedVariation, "variationid='".$variationId."'");
		}

		// Are there any downloads for this product?
		if(isset($productData['downloads']) && is_array($productData['downloads'])) {
			foreach($productData['downloads'] as $download) {
				if(!isset($download['downname']) || empty($download['downname'])) {
					$download['downname'] = basename($download['downfile']);
				}

				$download['downfile'] = realpath($download['downfile']);


				// Only copy across product images that exist
				if(!file_exists($download['downfile']) || !is_file($download['downfile'])) {
					continue;
				}

				// Copy the file across to the store
				$fileName = GenRandFileName(basename($download['downfile']));
				$dest = realpath(dirname(__FILE__) . "/../../../" . GetConfig('DownloadDirectory'));
				$dest .= "/" . $fileName;
				copy($download['downfile'], $dest);

				if(!isset($download['downdateadded'])) {
					$download['downdateadded'] = time();
				}

				if(!isset($download['downmaxdownloads'])) {
					$download['downmaxdownloads'] = 0;
				}

				if(!isset($download['downexpiresafter'])) {
					$download['downexpiresafter'] = 0;
				}

				if(!isset($download['downdescription'])) {
					$download['downdescription'] = basename($download['downfile']);
				}

				if(!isset($download['downfilezie'])) {
					$download['downfilesize'] = filesize($download['downfile']);
				}

				$newDownload = array(
					"prodhash" => '',
					"productid" => $productId,
					"downfile" => $fileName,
					"downdateadded" => (int)$download['downdateadded'],
					"downmaxdownloads" => (int)$download['downmaxdownloads'],
					"downexpiresafter" => (int)$download['downexpiresafter'],
					"downfilesize" => (int)$download['downfilesize'],
					"downname" => basename($download['downname']),
					"downdescription" => $download['downdescription']
				);

				$this->ConvertedInsertQuery("product_downloads", $newDownload);
			}
		}

		// Insert the search data for this product
		$searchData = array(
			"productid" => $productId,
			"prodname" => $productData['prodname'],
			"prodcode" => $productData['prodcode'],
			"proddesc" => $productData['proddesc'],
			"prodsearchkeywords" => $productData['prodsearchkeywords']
		);
		$this->ConvertedInsertQuery("product_search", $searchData);

		// Build the product words list
		$GLOBALS['ISC_CLASS_ADMIN_PRODUCT'] = GetClass('ISC_ADMIN_PRODUCT');
		$GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->SaveProductWords($GLOBALS['ISC_CLASS_DB']->Quote($productData['prodname']), $productId, "adding");

		return $productId;
	}

	/**
	 * Checks if a product is a duplicate based on the specified name.
	 *
	 * @param string The product name to check.
	 * @return boolean True if the product is a duplicate, false if not.
	 */
	public function IsDuplicateProduct($prodname)
	{
		static $prodcache;

		$prodname = isc_strtolower($prodname);

		if(isset($prodcache[$prodname])) {
			return true;
		}

		$query = sprintf("select productid from [|PREFIX|]products where lower(prodname)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($prodname));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		if($GLOBALS['ISC_CLASS_DB']->FetchOne($result)) {
			$prodcache[$prodname] = 1;
			return true;
		}

		return false;
	}

	/**
	 * Delete any products which have so far been imported by the importer.
	 */
	public function UndoImportProducts()
	{
		// Fetch any imported images
		$query = "
			SELECT pi.imagefile
			FROM [|PREFIX|]product_images pi
			LEFT JOIN [|PREFIX|]products p ON (p.productid=pi.imageprodid)
			WHERE p.importproductid != ''
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			@unlink(APP_ROOT."../".GetConfig('ImageDirectory')."/".$row['imagefile']);
		}

		// Fetch any imported downloads
		$query = "
			SELECT pd.downfile
			FROM [|PREFIX|]product_downloads pd
			LEFT JOIN [|PREFIX|]products p ON (p.productid=pd.productid)
			WHERE p.importproductid != ''
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			@unlink(APP_ROOT."../".GetConfig('DownloadDirectory')."/".$row['downfile']);
		}

		$queries[] = "
			DELETE p, ca, cf, v, vo, vc, ps, pi, pd
			FROM [|PREFIX|]products p
			LEFT JOIN [|PREFIX|]categoryassociations ca ON (ca.productid=p.productid)
			LEFT JOIN [|PREFIX|]product_customfields cf ON (cf.fieldprodid=p.productid)
			LEFT JOIN [|PREFIX|]product_variation_combinations vc ON (vc.vcproductid=p.productid)
			LEFT JOIN [|PREFIX|]product_variations v ON (v.variationid=p.prodvariationid)
			LEFT JOIN [|PREFIX|]product_variation_options vo ON (vo.vovariationid=v.variationid)
			LEFT JOIN [|PREFIX|]product_search ps ON (ps.productid=p.productid)
			LEFT JOIN [|PREFIX|]product_images pi ON (pi.imageprodid=p.productid)
			LEFT JOIN [|PREFIX|]product_downloads pd ON (pd.productid=p.productid)
			WHERE p.importproductid!=''
		";
		foreach ($queries as $query) {
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}
	}

	/**
	 * Insert an imported category in to the database. This function also performs any necessary validation & error checking.
	 *
	 * @param int The ID of the category from the existing system.
	 * @param array Array of category information to insert.
	 * @param string The import error message (returned by reference)
	 * @return boolean True if successful, false on failure.
	 */
	public function InsertCategory($categoryId, $categoryData, &$err)
	{
		if(!isset($categoryData['catname']) || $categoryData['catname'] == '') {
			$err = sprintf(GetLang('ImportCategoryErrorInvalid'), $categoryId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		foreach(array('catdesc', 'catviews', 'catsort', 'catmetakeywords', 'catmetadesc','catlayoutfile') as $field) {
			if(!isset($categoryData[$field])) {
				$categoryData[$field] = '';
			}
		}

		$category = array(
			"catparentid" => 0, // Insert an empty parent, CleanupCategories will correctly nest the categories
			"catname" => $categoryData['catname'],
			"catdesc" => $categoryData['catdesc'],
			"catviews" => (int)$categoryData['catviews'],
			"catsort" => (int)$categoryData['catsort'],
			"catmetakeywords" => $categoryData['catmetakeywords'],
			"catmetadesc" => $categoryData['catmetadesc'],
			"importcategoryid" => $categoryId,
			"importparentid" => $categoryData['catparentid']
		);
		$catId = $this->ConvertedInsertQuery("categories", $category);

		if(!$catId) {
			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
			$this->_LogImportError('invalid', $err);
			return false;
		}

		return $catId;
	}

	/**
	 * Correctly associate any categories with their correct parent category. This is automagically run after importing
	 * categories.
	 */
	public function ImportCategoriesCleanup()
	{
		$cats = array();
		$query = "
			SELECT c.categoryid, c.importparentid, p.categoryid AS theparentcategory
			FROM [|PREFIX|]categories c
			INNER JOIN [|PREFIX|]categories p ON (p.importcategoryid=c.importparentid)
			WHERE c.catparentid='0' AND c.importcategoryid != '0' AND c.importparentid != '0'
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$updatedCategory = array(
				"catparentid" => $row['theparentcategory']
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("categories", $updatedCategory, "categoryid='".$GLOBALS['ISC_CLASS_DB']->Quote($row['categoryid'])."'");
			$cats[] = $row['categoryid'];
		}

		// Now we need to build the parent list for each of the imported categories
		foreach($cats as $catid) {
			$parents = $this->BuildCategoryParentList($catid);
			$updatedCategory = array(
				"catparentlist" => $parents
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("categories", $updatedCategory, "categoryid='".$GLOBALS['ISC_CLASS_DB']->Quote($catid)."'");
		}
	}

	/**
	 * Build the parent list for a particular category.
	 *
	 * @param int The category ID to build the parent list for.
	 * @return string The build CSV parent list
	 */
	public function BuildCategoryParentList($catid)
	{
		static $catcache;

		if(!$catcache) {
			$query = "SELECT categoryid, catparentid FROM [|PREFIX|]categories";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$catcache[$row['categoryid']] = $row;
			}
		}

		$trail = '';

		if(isset($catcache[$catid])) {
			$category = $catcache[$catid];
			if(isset($catcache[$category['catparentid']])) {
				$trail = $this->BuildCategoryParentList($category['catparentid']) . $trail;
			}
			if($trail != '') {
				$trail .= ',';
			}
			$trail .= $category['categoryid'];
		}
		return $trail;

	}

	/**
	 * Delete any customers which have so far been imported by the importer.
	 */
	public function UndoImportCategories()
	{
		$queries[] = "DELETE FROM [|PREFIX|]categories WHERE importcategoryid!=''";
		foreach ($queries as $query) {
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}
	}

	/**
	 * Insert an imported bramd in to the database. This function also performs any necessary validation & error checking.
	 *
	 * @param int The ID of the brand from the existing system.
	 * @param array Array of brand information to insert.
	 * @param string The import error message (returned by reference)
	 * @return boolean True if successful, false on failure.
	 */
	public function InsertBrand($brandId, $brandData, &$err)
	{
		if(!isset($brandData['brandname']) || $brandData['brandname'] == '') {
			$err = sprintf(GetLang('ImportBrandErrorInvalid'), $brandId);
			$this->_LogImportError('invalid', $err);
			return false;
		}
		$brand = array(
			"importbrandid" => $brandId,
			"brandname" => $brandData['brandname'],
			"brandmetakeywords" => @$brandData['brandmetakeywords'],
			"brandmetadesc" => @$brandData['brandmetadesc'],
		);
		$id = $this->ConvertedInsertQuery("brands", $brand);
		if(!$id) {
			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
			$this->_LogImportError('invalid', $err);
			return false;
		}
		return $id;
	}

	/**
	 * Delete any brands which have so far been imported by the importer.
	 */
	public function UndoImportBrands()
	{
		$queries[] = "DELETE FROM [|PREFIX|]brands WHERE importbrandid!=''";
		foreach ($queries as $query) {
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}
	}

	/**
	 * Insert an imported customer in to the database. This function also performs any necessary validation & error checking.
	 * It also imports customer shipping addresses.
	 *
	 * @param int The ID of the customer from the existing system.
	 * @param array Array of customer information to insert.
	 * @param string The import error message (returned by reference)
	 * @return boolean True if successful, false on failure.
	 */
	public function InsertCustomer($customerId, $customerData, &$err)
	{

		if(!isset($customerData['custconemail'])) {
			$err = sprintf(GetLang('ImportCustomerErrorInvalidEmail'), $customerId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if(!isset($customerData['custpassword'])) {
			$err = sprintf(GetLang('ImportCustomerErrorInvalidPassword'), $customerData['custpassword']);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if($this->IsDuplicateCustomer($customerData['custconemail'])) {
			$err = sprintf(GetLang('ImportCustomerErrorDuplicate'), $customerData['custconemail']);
			$this->_LogImportError('duplicates', $err);
			return false;
		}

		if(!isset($customerData['custdatejoined'])) {
			$customerData['custdatejoined'] = time();
		}

		if(!isset($customerData['custconcompany'])) {
			$customerData['custconcompany'] = '';
		}

		$customer = array(
			"importcustomerid" => $customerId,
			"custpassword" => $customerData['custpassword'],
			"custconcompany" => $customerData['custconcompany'],
			"custconfirstname" => $customerData['custconfirstname'],
			"custconlastname" => $customerData['custconlastname'],
			"custconemail" => $customerData['custconemail'],
			"custconphone" => $customerData['custconphone'],
			"custdatejoined" => (int)$customerData['custdatejoined'],
			"customertoken" => $this->_GenerateUserToken(),
			"custimportpassword" => $this->passwordIdentifier.":".$customerData['custpassword']
		);
		$customerId = $this->ConvertedInsertQuery("customers", $customer);

		if(!$customerId) {
			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
			$this->_LogImportError('invalid', $err);
			return false;
		}

		// Does this customer have any shipping addresses?
		if(isset($customerData['addresses']) && is_array($customerData['addresses'])) {
			foreach($customerData['addresses'] as $address) {
				if(!isset($address['shipcountry'])) {
					continue;
				}

				if(isset($address['shipfullname'])) {
					// Convert back to first & last names
					$name = trim($address['shipfullname']);
					$name = explode(' ', $name);
					$address['shiplastname'] = array_pop($name);
					$address['shipfirstname'] = implode(' ', $name);
				}
				else if(isset($address['shipfirstname'])) {
					$address['shipfirstname'] = $address['shipfirstname'];
					if(isset($address['shiplastname'])) {
						$address['shiplastname'] = $address['shiplastname'];
					}
					else {
						$address['shiplastname'] = '';
					}
				}
				else {
					$address['shipfirstname'] = $customerData['custconfirstname'];
					$address['shiplastname'] = $customerData['custconlastname'];
				}

				if(!isset($address['shipdestination']) || $address['shipdestination'] != "commercial") {
					$address['shipdestination'] = "residential";
				}

				if(!isset($address['shipaddress2'])) {
					$address['shipaddress2'] = '';
				}

				$newAddress = array(
					"shipcustomerid" => $customerId,
					"shipfirstname" => $address['shipfirstname'],
					"shiplastname" => $address['shiplastname'],
					"shipaddress1" => $address['shipaddress1'],
					"shipaddress2" => $address['shipaddress2'],
					"shipcity" => $address['shipcity'],
					"shipstate" => $address['shipstate'],
					"shipzip" => $address['shipzip'],
					"shipcountry" => $address['shipcountry'],
					"shipphone" => $address['shipphone'],
					"shipstateid" => $this->_LookupStateId($address['shipstate'], $address['shipcountry']),
					"shipcountryid" => $this->_LookupCountryId($address['shipcountry']),
					"shipdestination" => $address['shipdestination']
				);
				$this->ConvertedInsertQuery("shipping_addresses", $newAddress);
			}
		}

		return $customerId;
	}

	/**
	 * Checks if a customer is a duplicate based on the specified email address.
	 *
	 * @param string The email address to check.
	 * @return boolean True if the customer is a duplicate, false if not.
	 */
	public function IsDuplicateCustomer($custconemail)
	{
		static $custcache;

		$custconemail = isc_strtolower($custconemail);

		if(isset($custcache[$custconemail])) {
			return true;
		}

		$query = sprintf("select customerid from [|PREFIX|]customers where lower(custconemail)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($custconemail));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		if($GLOBALS['ISC_CLASS_DB']->FetchOne($result)) {
			$custcache[$custconemail] = 1;
			return true;
		}
		return false;
	}

	/**
	 * Delete any customers which have so far been imported by the importer.
	 */
	public function UndoImportCustomers()
	{
		$queries[] = "
			DELETE c, sa
			FROM [|PREFIX|]customers c
			LEFT JOIN [|PREFIX|]shipping_addresses sa ON (c.customerid=sa.shipcustomerid)
			WHERE c.importcustomerid!=''
		";
		foreach ($queries as $query) {
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}
	}

	/**
	 * Insert an imported order in to the database. This function also performs any necessary validation & error checking.
	 * It also handles importing of ordered products.
	 *
	 * @param int The ID of the order from the existing system.
	 * @param array Array of order information to insert.
	 * @param string The import error message (returned by reference)
	 * @return boolean True if successful, false on failure.
	 */
	public function InsertOrder($orderId, $orderData, &$err)
	{
		if(!isset($orderData['orddate'])) {
			$err = sprintf(GetLang('ImportOrderErrorInvalidDate'), $orderId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if(!isset($orderData['ordtotalamount'])) {
			$err = sprintf(GetLang('ImportOrderErrorInvalidTotal'), $orderId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if(!isset($orderData['ordstatus'])) {
			$err = sprintf(GetLang('ImportOrderErrorInvalidStatus'), $orderId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if(!isset($orderData['ordbillfullname'])) {
			$err = sprintf(GetLang('ImportOrderErrorInvalidName'), $orderId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if(!is_array($orderData['products']) || count($orderData['products']) < 1) {
			$err = sprintf(GetLang('ImportOrderErrorInvalidProducts'), $orderId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		// Loop through all products to count how many digital products we have (sets the order type)
		$digital_count = 0;
		foreach($orderData['products'] as $product) {
			if(!isset($product['ordprodtype'])) {
				$prodType = $this->GetProductTypeByImportId($product['ordprodid']);
				if(!$prodType) {
					$product['ordprodtype'] = 'physical';
				}
				$product['ordprodtype'] = $prodType;
			}
			if($product['ordprodtype'] == 'digital') {
				++$digital_count;
			}
		}
		$ordIsDigital = 0;
		if($digital_count == count($orderData['products'])) {
			$ordIsDigital = 1;
		}

		if(!isset($orderData['ordhandlingcost'])) {
			$orderData['ordhandlingcost'] = 0;
		}

		if(!isset($orderData['orderpaymentmodule'])) {
			$orderData['orderpaymentmodule'] = '';
		}

		if(isset($orderData['ordbillfullname'])) {
			// Convert back to first & last names
			$name = trim($orderData['ordbillfullname']);
			$name = explode(' ', $name);
			$orderData['ordbilllastname'] = array_pop($name);
			$orderData['ordbillfirstname'] = implode(' ', $name);
		}
		else {
			$orderData['ordbillfirstname'] = $orderData['ordbillfirstname'];
			if(isset($orderData['ordbilllastname'])) {
				$orderData['ordbilllastname'] = $orderData['ordbilllastname'];
			}
			else {
				$orderData['ordbilllastname'] = '';
			}
		}

		if(!isset($orderData['ordbillstreet1'])) {
			$orderData['ordbillstreet1'] = '';
		}

		if(!isset($orderData['ordbillstreet2'])) {
			$orderData['ordbillstreet2'] = '';
		}

		if(!isset($orderData['ordbillsuburb'])) {
			$orderData['ordbillsuburb'] = '';
		}

		if(!isset($orderData['ordbillstate'])) {
			$orderData['ordbillstate'] = '';
		}

		if(!isset($orderData['ordbillzip'])) {
			$orderData['ordbillzip'] = '';
		}

		if(!isset($orderData['ordbillcountry'])) {
			$orderData['ordbillcountry'] = '';
		}

		if(isset($orderData['ordshipfullname'])) {
			// Convert back to first & last names
			$name = trim($orderData['ordshipfullname']);
			$name = explode(' ', $name);
			$orderData['ordshiplastname'] = array_pop($name);
			$orderData['ordshipfirstname'] = implode(' ', $name);
		}
		else {
			$orderData['ordshipfirstname'] = $orderData['ordshipfirstname'];
			if(isset($orderData['ordshiplastname'])) {
				$orderData['ordshiplastname'] = $orderData['ordshiplastname'];
			}
			else {
				$orderData['ordshiplastname'] = '';
			}
		}

		if(!isset($orderData['ordshipstreet1'])) {
			$orderData['ordshipstreet1'] = '';
		}

		if(!isset($orderData['ordshipstreet2'])) {
			$orderData['ordshipstreet2'] = '';
		}

		if(!isset($orderData['ordshipsuburb'])) {
			$orderData['ordshipsuburb'] = '';
		}

		if(!isset($orderData['ordshipstate'])) {
			$orderData['ordshipstate'] = '';
		}

		if(!isset($orderData['ordshipzip'])) {
			$orderData['ordshipzip'] = '';
		}

		if(!isset($orderData['ordshipcountry'])) {
			$orderData['ordshipcountry'] = '';
		}

		if(!isset($orderData['ordtrackingno'])) {
			$orderData['ordtrackingno'] = '';
		}

		// Build the new order
		$order = array(
			"importorderid" => $orderId,
			"ordcustid" => (int)$this->GetImportCustomerId($orderData['ordcustid']),
			"orddate" => (int)$orderData['orddate'],
			"ordsubtotal" => (float)$orderData['ordsubtotal'],
			"ordtaxtotal" => (float)$orderData['ordtaxtotal'],
			"ordshipcost" => (float)$orderData['ordshipcost'],
			"ordshipmethod" => $orderData['ordshipmethod'],
			"ordershipmodule" => '',
			"ordhandlingcost" => (float)$orderData['ordhandlingcost'],
			"ordtotalamount" => (float)$orderData['ordtotalamount'],
			"ordstatus" => (int)$orderData['ordstatus'],
			"orderpaymentmethod" => $orderData['orderpaymentmethod'],
			"orderpaymentmodule" => $orderData['orderpaymentmodule'],
			"ordbillfirstname" => $orderData['ordbillfirstname'],
			"ordbilllastname" => $orderData['ordbilllastname'],
			"ordbillstreet1" => $orderData['ordbillstreet1'],
			"ordbillstreet2" => $orderData['ordbillstreet2'],
			"ordbillsuburb" => $orderData['ordbillsuburb'],
			"ordbillstate" => $orderData['ordbillstate'],
			"ordbillzip" => $orderData['ordbillzip'],
			"ordbillcountry" => $orderData['ordbillcountry'],
			"ordshipfirstname" => $orderData['ordshipfirstname'],
			"ordshiplastname" => $orderData['ordshiplastname'],
			"ordshipstreet1" => $orderData['ordshipstreet1'],
			"ordshipstreet2" => $orderData['ordshipstreet2'],
			"ordshipsuburb" => $orderData['ordshipsuburb'],
			"ordshipstate" => $orderData['ordshipstate'],
			"ordshipzip" => $orderData['ordshipzip'],
			"ordshipcountry" => $orderData['ordshipcountry'],
			"ordbillcountryid" => $this->_LookupCountryId($orderData['ordbillcountry']),
			"ordbillstateid" => $this->_LookupStateId($orderData['ordbillstate'], $orderData['ordbillcountry']),
			"ordshipcountryid" => $this->_LookupCountryId($orderData['ordshipcountry']),
			"ordshipstateid" => $this->_LookupStateId($orderData['ordshipstate'], $orderData['ordshipcountry']),
			"ordisdigital" => $ordIsDigital,
			"ordtrackingno" => $orderData['ordtrackingno'],
			"orddateshipped" => (int)$orderData['orddateshipped']
		);

		// Insert the order
		$orderId = $this->ConvertedInsertQuery('orders', $order);

		if(!$orderId) {
			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
			$this->_LogImportError('invalid', $err);
			return false;
		}

		// Now we loop through and insert all of the products for the order
		foreach($orderData['products'] as $product) {
			if(!$product['ordprodname']) {
				$product['ordprodname'] = $this->GetProductNameByImportId($product['ordprodid']);
				if(!$product['ordprodname']) { // Invalid product
					$product['ordprodname'] = 'Unknown Product';
				}
			}

			if(!isset($product['ordprodcost'])) {
				continue;
			}

			if(!isset($product['ordprodqty'])) {
				continue;
			}

			if(!isset($product['ordprodsku'])) {
				$product['ordprodsku'] = '';
			}

			if(!isset($product['ordprodtype'])) {
				$prodType = $this->GetProductTypeByImportId($product['ordprodid']);
				if(!$prodType) {
					$product['ordprodtype'] = 'physical';
				}
				$product['ordprodtype'] = $prodType;
			}

			if(!isset($product['ordprodweight'])) {
				$product['ordprodweight'] = 0;
			}

			if(!isset($product['ordprodshipped'])) {
				$product['ordprodqtyshipped'] = 0;
			}
			else {
				$product['ordprodqtyshipped'] = (int)$product['ordprodqty'];
			}

			if(!isset($product['ordprodcostprice'])) {
				$product['ordprodcostprice'] = 0;
			}

			$productId = $this->GetImportProductId($product['ordprodid']);

			$orderProduct = array(
				"ordprodsku" => $product['ordprodsku'],
				"ordprodname" => $product['ordprodname'],
				"ordprodtype" => $product['ordprodtype'],
				"ordprodcost" => (float)$product['ordprodcost'],
				"ordprodweight" => (float)$product['ordprodweight'],
				"ordprodqtyshipped" => $product['orderprodqtyshipped'],
				"ordprodqty" => (int)$product['ordprodqty'],
				"orderorderid" => $orderId,
				"ordprodid" => (int)$productId,
				"ordprodvariationid" => 0,
				"ordprodoptions" => "",
				"ordprodcostprice" => (float)$product['ordprodcostprice']
			);

			$this->ConvertedInsertQuery('order_products', $orderProduct);
		}
		return $orderId;
	}

	/**
	 * Delete any orders which have so far been imported by the importer.
	 */
	public function UndoImportOrders()
	{
		$queries[] = "
			DELETE o, p
			FROM [|PREFIX|]orders o
			LEFT JOIN [|PREFIX|]order_products p ON (p.orderorderid=o.orderid)
			WHERE o.importorderid!=''
		";
		foreach ($queries as $query) {
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}
	}

	/**
	 * Insert an imported store administrator in to the database. This function also performs any necessary validation & error checking.
	 *
	 * @param int The ID of the user from the existing system.
	 * @param array Array of user information to insert.
	 * @param string The import error message (returned by reference)
	 * @return boolean True if successful, false on failure.
	 */
	public function InsertUser($userId, $userData, &$err)
	{
		if(!isset($userData['username'])) {
			$err = sprintf(GetLang('ImportUserErrorInvalidUsername'), $userId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if(!isset($userData['userpass'])) {
			$err = sprintf(GetLang('ImportUserErrorInvalidPassword'), $userData['username']);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if($this->IsDuplicateUser($userData['username'])) {
			$err = sprintf(GetLang('ImportUserErrorDuplicate'), $userData['username']);
			$this->_LogImportError('duplicates', $err);
			return false;
		}

		if(!isset($userData['userfirstname'])) {
			$userData['userfirstname'] = $userData['username'];
		}

		if(!isset($userData['userlastname'])) {
			$userData['userlastname'] = '';
		}

		if(!isset($userData['useremail'])) {
			$userData['useremail'] = '';
		}

		// Inser the user in to the database
		$newUser = array(
			"importuserid" => $userId,
			"username" => $userData['username'],
			"userpass" => $userData['userpass'],
			"userfirstname" => $userData['userfirstname'],
			"userlastname" => $userData['userlastname'],
			"userstatus" => $userData['userstatus'],
			"useremail" => $userData['useremail'],
			"userimportpass" => $this->passwordIdentifier.":".$userData['userpass'],
			"token" => $this->_GenerateUserToken()
		);

		$id = $this->ConvertedInsertQuery("users", $newUser);

		if(!$id) {
			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
			$this->_LogImportError('invalid', $err);
			return false;
		}
		return $id;
	}

	/**
	 * Checks if a user is a duplicate based on the specified username.
	 *
	 * @param string The username.
	 * @return boolean True if the user is a duplicate, false if not.
	 */
	public function IsDuplicateUser($username)
	{
		static $usercache;

		$username = isc_strtolower($username);

		if(isset($usercache[$username])) {
			return true;
		}

		$query = sprintf("select pk_userid from [|PREFIX|]users where lower(username)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($username));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		if($GLOBALS['ISC_CLASS_DB']->FetchOne($result)) {
			$usercache[$username] = 1;
			return true;
		}
		return false;
	}


	/**
	 * Delete any store administrators which have so far been imported by the importer.
	 */
	public function UndoImportUsers()
	{
		$queries[] = "DELETE FROM [|PREFIX|]users WHERE importuserid!=''";
		foreach ($queries as $query) {
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}
	}

	/**
	 * Insert an imported product review in to the database. This function also performs any necessary validation & error checking.
	 * This function also updates the matched products rating count + rating total.
	 *
	 * @param int The ID of the review from the existing system.
	 * @param array Array of review information to insert.
	 * @param string The import error message (returned by reference)
	 * @return boolean True if successful, false on failure.
	 */
	public function InsertReview($reviewId, $reviewData, &$err)
	{
		if(!isset($reviewData['revproductid'])) {
			$err = sprintf(GetLang('ImportReviewErrorInvalid'), $reviewId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if(!($productId = $this->GetImportProductId($reviewData['revproductid']))) {
			$err = sprintf(GetLang('ImportReviewErrorInvalidProduct'), $reviewId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if(!isset($reviewData['revfromname'])) {
			$err = sprintf(GetLang('ImportReviewErrorInvalidName'), $reviewId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if(!isset($reviewData['revstatus']) || $reviewData['revstatus'] != 0) {
			$reviewData['revstatus'] = 1;
		}

		if(!isset($reviewData['revtitle'])) {
			$reviewData['revtitle'] = '';
		}

		if(!isset($reviewData['revrating'])) {
			$reviewData['revrating'] = 0;
		}

		$review = array(
			"importreviewid" => $reviewId,
			"revproductid" => $productId,
			"revfromname" => $reviewData['revfromname'],
			"revdate" => (int)$reviewData['revdate'],
			"revrating" => (int)$reviewData['revrating'],
			"revtext" => $reviewData['revtext'],
			"revtitle" => $reviewData['revtitle'],
			"revstatus" => $reviewData['revstatus']
		);

		// Need to update product info with the number of ratings and total ratings counts - maybe better to do this in one query in the cleanup function?
		$query = sprintf("update [|PREFIX|]products set prodnumratings=prodnumratings+1, prodratingtotal=prodratingtotal+%d where productid='%s'", $reviewData['revrating'], $productId);
		$GLOBALS['ISC_CLASS_DB']->Query($query);

		$id = $this->ConvertedInsertQuery('reviews', $review);

		if(!$id) {
			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
			$this->_LogImportError('invalid', $err);
			return false;
		}

		return $id;
	}

	/**
	 * Delete any product reviews which have so far been imported by the importer.
	 */
	public function UndoImportReviews()
	{
		$queries[] = "DELETE FROM [|PREFIX|]reviews WHERE importreviewid!=''";
		foreach ($queries as $query) {
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}
	}

	/**
	 * Insert an imported newsletter  subscriber in to the database. This function also performs any necessary validation & error checking.
	 *
	 * @param int The ID of the subscriber from the existing system.
	 * @param array Array of subscriber information to insert.
	 * @param string The import error message (returned by reference)
	 * @return boolean True if successful, false on failure.
	 */
	public function InsertSubscriber($subscriberId, $subscriberData, &$err)
	{
		if(!isset($subscriberData['subemail']) || $subscriberData['subemail'] == '') {
			$err = sprintf(GetLang('ImportSubscriberErrorInvalid'), $subscriberId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		$subscriber = array(
			"importsubscriberid" => $subscriberId,
			"subemail" => $subscriberData['subemail'],
			"subfirstname" => $subscriberData['subfirstname']
		);
		$id = $this->ConvertedInsertQuery('subscribers', $subscriber);
		if(!$id) {
			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
			$this->_LogImportError('invalid', $err);
			return false;
		}

		return $id;
	}

	/**
	 * Delete any newsletter subscribers which have so far been imported by the importer.
	 */
	public function UndoImportSubscribers()
	{
		$queries[] = "DELETE FROM [|PREFIX|]subscribers WHERE importsubscriberid!=''";
		foreach ($queries as $query) {
			if(!$GLOBALS['ISC_CLASS_DB']->Query($query) && $GLOBALS['ISC_CLASS_DB']->GetErrorMsg() != '') {
				$Err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
				$this->Debug(array("query" => $query, "error" => $Err), "db_errors");
			}
		}
	}

	/**
	 * Insert an imported wishlist item in to the database. This function also performs any necessary validation & error checking.
	 *
	 * @param int The ID of the wishlist item from the existing system.
	 * @param array Array of wishlist information to insert.
	 * @param string The import error message (returned by reference)
	 * @return boolean True if successful, false on failure.
	 */
	public function InsertWishlist($wishlistId, $wishlistData, &$err)
	{
		if(!($productId = $this->GetImportProductId($wishlistData['productid']))) {
			$err = sprintf(GetLang('ImportWishlistErrorInvalidProduct'), $wishlistId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		if(!($customerId = $this->GetImportCustomerId($wishlistData['customerid']))) {
			$err = sprintf(GetLang('ImportWishlistErrorInvalidCustomer'), $wishlistId);
			$this->_LogImportError('invalid', $err);
			return false;
		}

		$query = "SELECT wishlistid [|PREFIX|]wishlists WHERE customerid='".(int)$customerId."'";
		$existingWishlist = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);

		// Wishlist hasn't already been created for this customer
		if(!$existingWishlist) {
			$newWishlist = array(
				'customerid' => $customerId,
				'wishlistname' => 'My Wish List',
				'ispublic' => 0
			);
			$existingWishlist = $GLOBALS['ISC_CLASS_DB']->InsertQuery('wishlists', $newWishlist);
		}

		$wishlistItem = array(
			"wishlistid" => $existingWishlist,
			"importwishlistid" => $wishlistId,
			"customerid" => $customerId,
			"productid" => $productId
		);
		$id = $this->ConvertedInsertQuery('wishlist_items', $wishlistItem);
		if(!$id) {
			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
			$this->_LogImportError('invalid', $err);
			return false;
		}

		return $id;
	}

	/**
	 * Delete any wishlist items which have so far been imported by the importer.
	 */
	public function UndoImportWishlists()
	{
		$queries[] = "DELETE FROM [|PREFIX|]wishlists WHERE importwishlistid!=''";
		foreach ($queries as $query) {
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}
	}

	/**
	 * Return the intenal product ID based off the specified imported product ID.
	 *
	 * @param int The product ID from the application we're importing from.
	 * @return int The Interspire Shopping Cart product ID.
	 */
	public function GetImportProductId($productId)
	{
		static $productIds;
		if(!is_array($productIds)) {
			$productIds = array();
		}
		if($productId === 0) {
			return 0;
		}
		if(!isset($productIds[$productId])) {
			$query = sprintf("SELECT productid FROM [|PREFIX|]products WHERE importproductid='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($productId));
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 1);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$productIds[$productId] = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
		}
		else {
			return 0;
		}
		return (int)$productIds[$productId];
	}

	/**
	 * Return the intenal category ID based off the specified imported category ID.
	 *
	 * @param int The category ID from the application we're importing from.
	 * @return int The Interspire Shopping Cart category ID.
	 */
	public function GetImportCategoryId($categoryId)
	{
		static $categoryIds;
		if(!is_array($categoryIds)) {
			$categoryIds = array();
		}
		if($categoryId === 0) {
			return 0;
		}
		if(!isset($categryIds[$categoryId])) {
			$query = sprintf("SELECT categoryid FROM [|PREFIX|]categories WHERE importcategoryid='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($categoryId));
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 1);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$categoryIds[$categoryId] = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
		}
		else {
			return 0;
		}
		return (int)$categoryIds[$categoryId];
	}

	/**
	 * Return the intenal brand ID based off the specified imported brand ID.
	 *
	 * @param int The category ID from the application we're importing from.
	 * @return int The Interspire Shopping Cart caegory ID.
	 */
	public function GetImportBrandid($brandId)
	{
		static $brandIds;
		if(!is_array($brandIds)) {
			$brandIds = array();
		}
		if($brandId === 0) {
			return 0;
		}
		if(!isset($categryIds[$brandId])) {
			$query = sprintf("SELECT brandid FROM [|PREFIX|]brands WHERE importbrandid='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($brandId));
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 1);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$brandIds[$brandId] = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
		}
		else {
			return 0;
		}

		return (int)$brandIds[$brandId];
	}

	/**
	 * Return the intenal customer ID based off the specified imported customer ID.
	 *
	 * @param int The customer ID from the application we're importing from.
	 * @return int The Interspire Shopping Cart customer ID.
	 */
	public function GetImportCustomerId($customerId)
	{
		static $customerIds;
		if(!is_array($customerIds)) {
			$customerIds = array();
		}

		if(!isset($customerIds[$customerId])) {
			$query = sprintf("SELECT customerid FROM [|PREFIX|]customers WHERE importcustomerid='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($customerId));
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 1);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$customerIds[$customerId] = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
		}
		else {
			return 0;
		}
		return (int)$customerIds[$customerId];
	}

	/**
	 * Return the intenal order ID based off the specified imported order ID.
	 *
	 * @param int The order ID from the application we're importing from.
	 * @return int The Interspire Shopping Cart order ID.
	 */
	public function GetOrderById($orderId)
	{
		static $orderIds;
		if(!is_array($orderIds)) {
			$orderIds = array();
		}

		if(!isset($orderIds[$orderId])) {
			$query = sprintf("SELECT orderid FROM [|PREFIX|]orders WHERE importorderid='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($orderId));
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 1);
			$result = $GLOBALS['ISC_CLASS_DB']-Query($query);
			$orderIds[$orderId] = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
		}
		else {
			return 0;
		}
		return (int)$orderIds[$orderId];
	}

	/**
	 * Look up a state ID based on a state/country. This function differs from the internal version as it performs internal caching of results.
	 *
	 * @param string The state to fetch the ID for.
	 * @param string The country the state belongs to.
	 * @return int The matched state ID.
	 */
	public function _LookupStateId($state, $country)
	{
		static $stateCache;
		$state = isc_strtolower($state);
		$country = isc_strtolower($country);

		if(isset($stateCache[$country][$state])) {
			return $stateCache[$country][$state];
		}

		// Look up and cache
		$query = sprintf("select stateid from [|PREFIX|]country_states s inner join [|PREFIX|]countries c on (s.statecountry = c.countryid) where lower(s.statename)='%s' and lower(c.countryname) = '%s'", $state, $country);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$stateCache[$country][$state] = $row['stateid'];
			return $row['stateid'];
		}
		return 0;
	}

	/**
	 * Look up a country ID based on a country name. This function differs from the internal version as it performs internal caching of results.
	 *
	 * @param string The country name to lookup.
	 * @reurn int The matched country ID.
	 */
	public function _LookupCountryId($country)
	{
		static $countryCache;
		$country = isc_strtolower($country);
		if(isset($countryCache[$country])) {
			return $countryCache[$country];
		}

		// Look up and cache
		$query = sprintf("select countryid from [|PREFIX|]countries where lower(countryname='%s')", $country);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$countryCache[$country] = $row['countryid'];
			return $row['countryid'];
		}
		return 0;
	}

	/**
	 * Look up a country ID based on a country code. This function differs from the internal version as it performs internal caching of results.
	 *
	 * @param string The country code to lookup.
	 * @reurn int The matched country ID.
	 */
	public function _LookupCountryCode($country)
	{
		static $countryCache;
		$country = isc_strtolower($country);
		if(isset($countryCache[$country])) {
			return $countryCache[$country];
		}

		// Look up and cache
		$query = sprintf("select countryid from [|PREFIX|]countries where lower(countryiso2='%s')", $country);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$countryCache[$country] = $row['countryid'];
			return (int)$row['countryid'];
		}
		return 0;
	}

	/**
	 * Generate a token of a random length for customers and users.
	 *
	 * @return string The generated random token.
	 */
	public function _GenerateUserToken()
	{
		// Generate a random string which is used to store user credentials in the session
		$token = "";

		for($i = 0; $i < rand(20, 40); $i++) {
			if(rand(1, 2) == 1) {
				$token .= chr(rand(65, 90));
			}
			else {
				$token .= chr(rand(48, 57));
			}
		}

		return $token;
	}

	/**
	 * Gets & parses a converter template. This has its own method because converter templates are
	 * stored independently of the rest of the store.
	 *
	 * @param string The name of the template.
	 * @param boolean True to return the template, false to output.
	 */
	public function ParseTemplate($template, $return = false)
	{
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("../includes/converter/templates/".$template);
		return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate($return);
	}

	/**
	 * Create the import session table in the database. This is used to store all of the information about
	 * the current import session.
	 */
	public function _CreateImportSession()
	{
		$query = "drop table if exists [|PREFIX|]importsession";
		$GLOBALS['ISC_CLASS_DB']->Query($query);

		$query = "create table [|PREFIX|]importsession (
			type varchar(20) not null default '',
			module varchar(30) not null default '',
			log varchar(30) not null default '',
			data text not null
		)";
		if($GLOBALS['ISC_CLASS_DB']->Query($query)) {
			$query = "insert into [|PREFIX|]importsession (type,data) values ('primary', '')";
			if($GLOBALS['ISC_CLASS_DB']->Query($query)) {
				return true;
			}
			else {
				return false;
			}
			$this->_importSession = array();
		}
		else {
			return false;
		}
	}

	/**
	 * Load the import ession from the database. Populates the _importSession variable.
	 */
	public function _LoadImportSession()
	{
		$query = "select data from [|PREFIX|]importsession where type='primary' and data!=''";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$this->_importSession = unserialize($GLOBALS['ISC_CLASS_DB']->FetchOne($result));
	}

	/**
	 * Takes the current import session imformation from _importSession and writes it to the database.
	 */
	public function _UpdateImportSession()
	{
		$importSession = serialize($this->_importSession);
		$updatedSession = array(
			"data" => $importSession
		);
		$GLOBALS['ISC_CLASS_DB']->UpdateQuery("importsession", $updatedSession, "type='primary'");
	}

	/**
	 * Log an import error. This only writes the error to memory. To commit, call _WritePendingImportLogs().
	 *
	 * @param string The type of error (duplicate, invalid, etc)
	 * @param string The message to add to the error log.
	 */
	public function _LogImportError($type, $message)
	{
		$module = $this->_importSession['CurrentModule'];

		if(!isset($this->_importErrors[$module][$type])) {
			$this->_importErrors[$module][$type] = '';
		}

		$this->_importErrors[$module][$type] .= $message."\n";

		++$this->_importSession[$module]['errors'];

		if(isset($this->_importSession[$module][$type])) {
			++$this->_importSession[$module][$type];
		}
		else {
			$this->_importSession[$module][$type] = 1;
		}
	}

	/**
	 * Write any pending import logs in memory to the import sesion database.
	 */
	public function _WritePendingImportLogs()
	{
		if(count($this->_importErrors) == 0) {
			return false;
		}

		foreach($this->_importErrors as $module => $typeLog) {
			foreach($typeLog as $type => $log) {
				$query = sprintf("insert into [|PREFIX|]importsession (type,module,log,data) values ('log','%s','%s','%s')", $GLOBALS['ISC_CLASS_DB']->Quote($module), $GLOBALS['ISC_CLASS_DB']->Quote($type), $GLOBALS['ISC_CLASS_DB']->Quote($log));
				$GLOBALS['ISC_CLASS_DB']->Query($query);
			}
		}
	}

	/**
	 * Create the temporary import fields in the database.
	 */
	public function _CreateImportFields()
	{

		// This can take a very long time on stores with a large amount of data
		@set_time_limit(0);

		foreach($this->_importFields as $table => $fields) {
			$query = "DESCRIBE [|PREFIX|]".$table;
			$tableColumns = array();
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$tableColumns[] = $row['Field'];
			}
			foreach($fields as $field) {
				// If the column exists, drop it first
				if(in_array($field, $tableColumns)) {
					$GLOBALS['ISC_CLASS_DB']->Query("ALTER TABLE [|PREFIX|]".$table." DROP ".$field);
				}
				$type = " int(11) not null default '0'";
				if(isset($this->_importFieldsType) && isset($this->_importFieldsType[$table][$field])) {
					if($this->_importFieldsType[$table][$field] == 'varchar') {
						$type = " varchar(200) not null default ''";
					}
				}
				$queries[] = sprintf("alter table [|PREFIX|]%s add %s %s", $table, $field, $type);
			}
		}

		foreach($queries as $query) {
			if(!$GLOBALS['ISC_CLASS_DB']->Query($query)) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Remove the temporary import fields from the database.
	 */
	public function _DropImportFields()
	{
		foreach($this->_importFields as $table => $fields) {
			foreach($fields as $field) {
				$queries[] = sprintf("alter table [|PREFIX|]%s drop %s", $table, $field);
			}
		}

		foreach($queries as $query) {
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}

	}

	/**
	 * Perform a database INSERT query based off an array of fields.
	 *
	 * @param string The table name to insert into.
	 * @param array Array of field => value pairs to insert.
	 * @return int The database row insert ID.
	 */
	public function DbInsertArray($table, $fields)
	{
		$query = sprintf("insert into [|PREFIX|]%s (%s) values ('%s')", $table, implode(",", array_keys($fields)), implode("','", $fields));
		$this->Debug(var_export($fields, true), "db-$table");
		$GLOBALS['ISC_CLASS_DB']->Query($query);
		return $GLOBALS['ISC_CLASS_DB']->LastId();
	}

	/**
	 * Fetch a list of supported importers by checking the importers directory.
	 *
	 * @return array Array of importers containing importer ID and configuraiton fields.
	 */
	public function FetchImporterList()
	{
		$importerRoot = APP_ROOT."/includes/converter/importers/";
		$files = scandir($importerRoot);
		foreach($files as $file) {
			if(!is_file($importerRoot.$file) || isc_substr($file, -3) != "php") {
				continue;
			}
			require_once $importerRoot.$file;
			$file = isc_substr($file, 0, isc_strlen($file)-4);
			$className = "ISC_ADMIN_CONVERTER_".isc_strtoupper($file);
			if(!class_exists($className)) {
				continue;
			}
			$converter = new $className;
			$importers[$file] = array(
				"title" => $converter->title
			);
			if(method_exists($converter, "Configure")) {
				$importers[$file]['configuration'] = $converter->Configure();
			}
		}
		return $importers;
	}

	/**
	 * Fetch a list of modules for the current importer.
	 *
	 * @return array Array of modules containing module information, dependancies and disabled status.
	 */
	public function FetchModuleList()
	{
		$modules = array();

		foreach($this->_modules as $module => $info) {
			$modules[$module] = array(
				"name" => $info['name'],
				"description" => $info['description'],
				"disabled" => false,
				"dependencies" => ""
			);

			if(isset($this->_importSession[$module]['finished'])) {
				$modules[$module]['finished'] = $this->_importSession[$module]['finished'];
			}
			else {
				if(isset($info['dependencies']) && is_array($info['dependencies'])) {
					foreach($info['dependencies'] as $dependency) {
						if(!isset($this->_importSession[$dependency]) || !isset($this->_importSession[$dependency]['finished'])) {
							$modules[$module]['dependencies'][] = $this->_modules[$dependency]['name'];
						}
					}
					if(is_array($modules[$module]['dependencies']) && count($modules[$module]['dependencies']) > 0) {
						$modules[$module]['disabled'] = true;
						$modules[$module]['dependencies'] = " - " . implode("\\n - ", $modules[$module]['dependencies']);
					}
				}
			}
		}
		return $modules;
	}

	/**
	 * Log debug information to the import debug file.
	 *
	 * @param string The message to log.
	 * @param string The file to save the message to.
	 */
	public function Debug($message, $file="")
	{
		if(!$this->_Debug) {
			return;
		}

		if(is_array($message)) {
			$message = var_export($message, true);
		}
		if($file == '') {
			$file = 'log';
		}
		$fp = fopen(APP_ROOT."/includes/converter/logs/{$file}.txt", "a+");
		fwrite($fp, "[".isc_date("r")."] ".$message."\n\n");
		fclose($fp);
	}

	/**
	 * Convert a MySQL datetime field to a UNIX timestamp.
	 *
	 * @param string The date time field.
	 * @param int The generated UNIX timestamp.
	 */
	public function DatetimeToUnix($DateTime)
	{
		if($DateTime == '') {
			return 0;
		}
		return strtotime($DateTime);
	}

	/**
	 * Convert a URL to a location in the file system based on the Interspire Shopping Cart URL.
	 *
	 * @param string The URL to convert to a relative path on the file system.
	 * @param string An error message, passed by reference.
	 * @return string The file system path to the URL.
	 */
	public function URLToPath($url, &$err)
	{
		if(isc_substr($GLOBALS['ShopPath'], -1) == '/') {
			$GLOBALS['ShopPath'] = isc_substr($GLOBALS['ShopPath'], 0, -1);
		}
		$ourURL = @parse_url($GLOBALS['ShopPath']);
		$theirURL = @parse_url($url);
		if(!is_array($ourURL) && !is_array($theirURL) || $theirURL['scheme'] != 'http') {
			$err = GetLang('InvalidImportURL');
			return false;
		}

		if($ourURL['host'] != $theirURL['host']) {
			$err = GetLang('InvalidImportURLDomain');
			return false;
		}
		if(isset($ourURL['path'])) {
			$upDirectories = str_repeat("../", isc_substr_count($ourURL['path'], "/"));
		}
		else {
			$upDirectories = '';
		}

		if(isset($theirURL['path'])) {
			if(isc_substr($theirURL['path'], 0, 1) == "/") {
				$theirURL['path'] = isc_substr($theirURL['path'], 1);
			}
		} else {
			$theirURL['path'] = '';
		}
		return APP_ROOT."/../".$upDirectories.$theirURL['path'];
	}

	/**
	 * Convert a yes/no entry to an integer value (0, 1)
	 */
	public function YesNoToInt($value)
	{
		$val = isc_strtolower($value);
		switch($val) {
			case "yes":
			case "on":
			case "y":
			case "true":
			case 1:
				return 1;
				break;
			case "no":
			case "off":
			case "n":
			case "false":
				return 0;
		}
	}

	/**
	 * Perform an insert query of data form the imported store to the new store and convert the data to the right encoding.
	 */
	public function ConvertedInsertQuery($table, $data)
	{
		if(isset($this->_importSession['Configuration']['charset'])) {
			foreach($data as $k => $v) {
				// It's only strings that we need to convert
				if(!is_string($v)) {
					continue;
				}
				$convertedString = isc_convert_charset($this->_importSession['Configuration']['charset'], GetConfig('CharacterSet'), $v);
				// If the conversion failed, skip it and carry on
				if(!$convertedString) {
					continue;
				}
				$data[$k] = $convertedString;
			}
		}
		return $GLOBALS['ISC_CLASS_DB']->InsertQuery($table, $data);
	}

	/**
	 * Look up the name of a product based on the imported product id.
	 *
	 * @param int The product ID.
	 * @return string The name of the product that has been looked up.
	 */
	public function GetProductNameByImportId($importId)
	{
		static $products;
		if(!is_array($products)) {
			$products = array();
		}

		if(isset($products[$importId])) {
			return $products[$importId];
		}

		$query = "SELECT prodname FROM [|PREFIX|]products WHERE importproductid='".$GLOBALS['ISC_CLASS_DB']->Quote($importId)."'";
		$products[$importId] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
		return $products[$importId];
	}

	/**
	 * Look up the type of a product based on the imported product id.
	 *
	 * @param int The product ID.
	 * @return string The type of the product that has been looked up.
	 */
	public function GetProductTypeByImportId($importId)
	{
		static $products;
		if(!is_array($products)) {
			$products = array();
		}

		if(isset($products[$importId])) {
			return $products[$importId];
		}

		$query = "SELECT prodtype FROM [|PREFIX|]products WHERE importproductid='".$GLOBALS['ISC_CLASS_DB']->Quote($importId)."'";
		$type = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
		if($type == 2) {
			$products[$importId] = 'digital';
		}
		else {
			$products[$importId] = 'physical';
		}
		return $products[$importId];
	}
}
?>