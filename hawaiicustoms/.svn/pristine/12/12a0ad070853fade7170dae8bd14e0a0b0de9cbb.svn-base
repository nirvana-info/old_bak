<?php
@set_time_limit(0);
define("ISC_EXPORT_CATEGORIES_PER_PAGE", 100);
define("ISC_EXPORT_BRANDS_PER_PAGE", 100);
define("ISC_EXPORT_USERS_PER_PAGE", 100);
define("ISC_EXPORT_CUSTOMERS_PER_PAGE", 100);
define("ISC_EXPORT_PRODUCTS_PER_PAGE", 100);
define("ISC_EXPORT_ORDERS_PER_PAGE", 100);
define("ISC_EXPORT_REVIEWS_PER_PAGE", 100);
define("ISC_EXPORT_SUBSCRIBERS_PER_PAGE", 100);
define("ISC_EXPORT_WISHLISTS_PER_PAGE", 100);

while (ob_get_level()) {
	ob_end_clean();
}

/**
 * Interspire Shopping Cart Store Exporter
 */
class ISC_ADMIN_EXPORTER
{
	/**
	 * @var array Array of information about the current export session.
	 */
	protected $_exportSession = array();

	/**
	 * @var array Array for storing any pending log files to be written to the database at the end of page execution.
	 */
	protected $_exportErrors = array();

	/**
	 * @var boolean True to enable debug mode (logs all queries & errors)
	 */
	protected $_Debug = false;

	/**
	 * Handle the incoming action.
	 *
	 * @param string The action to perform.
	 */
	public function HandleToDo($Do)
	{
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseLangFile(APP_ROOT."/../language/".GetConfig('Language')."/converter_language.ini");
		$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ExportStoreWizard') => "index.php?ToDo=Exporter");

		if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Store_Importer) || GetConfig('DisableStoreImporters')) {
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
		}

		// Set the database to log all errors & queries if we're in debug mode
		if($this->_Debug == true) {
			$GLOBALS['ISC_CLASS_DB']->QueryLog = dirname(__FILE__)."/logs/export-sts.queries.txt";
			$GLOBALS['ISC_CLASS_DB']->TimeLog = dirname(__FILE__)."/logs/export-sts.query_time.txt";
			$GLOBALS['ISC_CLASS_DB']->ErrorLog = dirname(__FILE__)."/logs/export-sts.db_errors.txt";
		}

		switch (isc_strtolower($Do))
		{
			case "cancelexporter": {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->CancelExporter();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "showexporterframe": {
				$this->ShowExporterFrame();
				break;
			}
			case "runexporter": {
				$this->RunModule();
				break;
			}
			default:
			{
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->InitializeExporter();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
			}
		}
	}

	protected function ShowExportSummary()
	{
		$className = "ISC_ADMIN_EXPORTER_".isc_strtoupper($this->_exportSession['CurrentExporter']);
		require_once APP_ROOT."/includes/converter/exporters/".$this->_exportSession['CurrentExporter'].".php";
		$exporter = new $className;

		$exporter->_exportSession = $this->_exportSession;

		$report = '';
		foreach($exporter->_modules as $module) {
			if(isset($this->_exportSession[$module])) {
				$moduleInfo = $this->_exportSession[$module];
				if(isset($moduleInfo['errors'])) {
					$moduleInfo['done'] -= $moduleInfo['errors'];
				}
				foreach(array('done') as $type) {
					$amount = number_format($moduleInfo[$type]);
					$report .= "<li>\n";
					if($moduleInfo[$type] == 1) {
						$report .= GetLang('Report' . $module . ucfirst($type) . 'One');
					}
					else {
						$report .= sprintf(GetLang('Report' . $module . ucfirst($type) . 'Many'), $amount);
					}
					$report .= "</li>\n";
				}
			}
		}
		$GLOBALS['Report'] = $report;

		$GLOBALS['Message'] = MessageBox(GetLang('ExportStoreSuccess'), MSG_SUCCESS);

		// Remove the import session
		$GLOBALS['ISC_CLASS_DB']->Query("drop table [|PREFIX|]export_session");

		$this->ParseTemplate("exporters.finished");
	}

	protected function CancelExporter()
	{
		// Check is the export session table exists - if it does, we're currently in the middle of a session
		$query = "show tables like '[|PREFIX|]export_session'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

		if($row) {
			$GLOBALS['ISC_CLASS_DB']->Query("DROP [|PREFIX|]");
		}

		$this->ShowExporters(GetLang('ExportSessionCancelled'), MSG_SUCCESS);
	}



	/**
	 * Initialize the exporter. This function checks if we're in an export session,
	 * if an exporter is configured, if we're in a module or any other export action
	 * and then displays the appropriate page.
	 */
	protected function InitializeExporter()
	{

		// Check is the export session table exists - if it does, we're currently in the middle of a session
		$query = "show tables like '[|PREFIX|]export_session'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

		if($row) {
			$this->_LoadExportSession();
		}

		if(isset($this->_exportSession['FinishedAll'])) {
			$this->ShowExportSummary();
			return;
		}

		// Currently in an export session, we skip straight to the continue page
		if($row && @array_key_exists('Configuration', $this->_exportSession) && @array_key_exists('Warned', $this->_exportSession)) {
			$className = "ISC_ADMIN_EXPORTER_".isc_strtoupper($this->_exportSession['CurrentExporter']);
			require_once APP_ROOT."/includes/converter/exporters/".$this->_exportSession['CurrentExporter'].".php";
			$exporter = new $className;

			$exporter->_exportSession = $this->_exportSession;

			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$this->ParseTemplate("exporters.run");
		}

		if(isset($_REQUEST['WarningAccept'])) {
			$this->_exportSession['Warned'] = 1;
		}

		// Just selected an exporter
		else if(isset($_REQUEST['exporter']) || $row) {
			if(isset($_REQUEST['exporter'])) {
				$_REQUEST['exporter'] = str_replace(array(".", "/"), "", $_REQUEST['exporter']); // Sanitize
				if(!file_exists(APP_ROOT."/includes/converter/exporters/".$_REQUEST['exporter'].".php")) {
					$this->ShowExporters("Invalid exporter", MSG_ERROR);
					return;
				}

				require_once APP_ROOT."/includes/converter/exporters/".$_REQUEST['exporter'].".php";
				$className = "ISC_ADMIN_EXPORTER_".isc_strtoupper($_REQUEST['exporter']);
				$exporter = new $className;

				$configuration = 1;
				if(method_exists($exporter, 'SaveConfiguration')) {
					$err = '';
					$configuration = $exporter->SaveConfiguration($err);
					if(!is_array($configuration)) {
						$this->ShowExporters($err, MSG_ERROR);
						return;
					}
				}

				$this->_CreateExportSession();
				$this->_exportSession['CurrentExporter'] = $_REQUEST['exporter'];
				$this->_exportSession['modules'] = array();
				$this->_exportSession['Configuration'] = $configuration;
				$exporter->_exportSession = $this->_exportSession;
			}
			else if($row) {
				$className = "ISC_ADMIN_EXPORTER_".isc_strtoupper($this->_exportSession['CurrentExporter']);
				require_once APP_ROOT."/includes/converter/exporters/".$this->_exportSession['CurrentExporter'].".php";
				$exporter = new $className;
			}

			if(!array_key_exists('Warned', $this->_exportSession)) {
				// No warnings for this exporter
				if(method_exists($exporter, 'ExportWarning')) {
					$exporter->ExportWarning();
					$this->_UpdateExportSession();
					return;
				}
				$this->_exportSession['Warned'] = 1;
			}

			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$this->ParseTemplate("exporters.run.tpl");

			$this->_UpdateExportSession();
		}
		// Not doing anything, show a list of exporters
		else {
			$this->ShowExporters();
		}
	}

	/**
	 * Show a list of exporters currently supported and allow configuration of the selected item.
	 *
	 * @param string The optional message to show at the top of the page.
	 * @param const A constant defining the type of message. MSG_ERROR, MSG_SUCCESS.
	 */
	protected function ShowExporters($MsgDesc = '', $MsgStatus = '')
	{
			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			$exporters = $this->FetchExporterList();
			$GLOBALS['ExporterList'] = '';
			$GLOBALS['ConfigurationList'] = '';
			foreach($exporters as $file => $info) {
				if(isset($info['configuration'])) {
					$GLOBALS['ConfigurationList'] .= "<div id=\"{$file}Configure\" class=\"ExporterConfiguration\" style=\"display: none;\"><br />" . $info['configuration'] . "</div>";
				}
				$selected = '';
				if(isset($_POST['exporter']) && $_POST['exporter'] == $file) {
					$selected = 'selected="selected"';
				}
				$GLOBALS['ExporterList'] .= sprintf("<option value=\"%s\" %s>%s</option>", $file, $selected, $info['title']);
			}
			$this->ParseTemplate('exporters.show');
	}

	/**
	 * Show the "Export in Progress" iframe which contains a hidden iFrame that performs the actual export.
	 */
	protected function ShowExporterFrame()
	{
		$this->_LoadExportSession();

		require_once APP_ROOT."/includes/converter/exporters/".$this->_exportSession['CurrentExporter'].".php";
		$className = "ISC_ADMIN_EXPORTER_".isc_strtoupper($this->_exportSession['CurrentExporter']);
		$exporter = new $className;
		$exporter->_exportSession = $this->_exportSession;

		$moduleList = array();

		// First hit has no module attached, so we need to build the modules list
		if(!isset($_REQUEST['module']) || !$_REQUEST['module']) {
			// Chose to run all modules, get all unfinished modules and add them
			foreach($exporter->_modules as $module) {
				if(!isset($exporter->_exportSession[$module]['finished'])) {
					$moduleList[] = $module;
				}
			}
			// First iteration? Delete existing store content
			if(count($moduleList) == count($exporter->_modules)) {
				$this->_exportSession['DeleteAll'] = 1;
			}

			$_REQUEST['module'] = array_shift($moduleList);
			if(!$_REQUEST['module']) {
				$this->_exportSession['AllFinished'] = 1;
				$this->_UpdateExportSession();
				$this->HideExportFrame();
			}
			$this->_exportSession['ModuleStack'] = $moduleList;
			$this->_exportSession['CleanupStack'] = array();
			$this->_exportSession['ExportingAll'] = 1;

		}

		if(!method_exists($exporter, $_REQUEST['module'])) {
			exit;
		}

		if(isset($this->_exportSession[$_REQUEST['module']]['finished'])) {
			exit;
			return;
		}

		// Set up the export session to run this module
		$this->_exportSession['CurrentModule'] = $_REQUEST['module'];
		if(!isset($this->_exportSession[$_REQUEST['module']]) || (isset($this->_exportSession[$_REQUEST['module']]) && isset($this->_exportSession[$_REQUEST['module']]['cancelled']))) {
			$this->_exportSession[$_REQUEST['module']] = array(
				"done" => 0,
				"total" => 0,
				"errors" => 0
			);
		}


		if(isset($this->_exportSession['DeleteAll'])) {
			$GLOBALS['Title'] = GetLang('ExportDeletingStoreStatusTitle');
			$GLOBALS['Description'] = GetLang('ExportDeletingStoreStatusDesc');
		}
		else {
			$module = $this->_exportSession['CurrentModule'];
			$GLOBALS['Title'] = GetLang($module.'StatusTitle');
			$GLOBALS['Description'] = GetLang($module.'StatusDesc');
		}

		$GLOBALS['Random'] = time();
		$this->_UpdateExportSession();

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$this->ParseTemplate("exporters.progress");
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pagefooter.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
	 * Hide the export iFrame when a module is complete.
	 */
	protected function HideExportFrame()
	{
		$this->UpdateProgress(GetLang('ExportComplete'));
		echo "<script type='text/javascript'>\n";
		echo "self.parent.ExportFinished();\n";
		echo "</script>";
	}

	/**
	 * Run an export module for an exporter. This is a dummy function which calls the child class' ReallyRunModule
	 * after setting up the exporter.
	 */
	protected function RunModule()
	{
		$this->_LoadExportSession();

		if(!$this->_exportSession['CurrentExporter']) {
			exit;
		}

		require_once APP_ROOT."/includes/converter/exporters/".$this->_exportSession['CurrentExporter'].".php";
		$className = "ISC_ADMIN_EXPORTER_".isc_strtoupper($this->_exportSession['CurrentExporter']);
		$exporter = new $className;
		$exporter->_exportSession = $this->_exportSession;
		$exporter->Connect();

		if(isset($this->_exportSession['DeleteAll'])) {
			$exporter->ClearStore();
			unset($exporter->_exportSession['DeleteAll']);
			$exporter->_UpdateExportSession();
			echo "<script type=\"text/javascript\">self.parent.location = 'index.php?ToDo=showExporterFrame&module=".$this->_exportSession['CurrentModule']."&random='+new Date().getTime();</script>\n";
			exit;
		}
		$exporter->ReallyRunModule();
	}

	/**
	 * Run an export module. This function is the "work horse" of the export system.
	 */
	protected function ReallyRunModule()
	{
		if(method_exists($this, "Connect")) {
			$this->Connect();
		}

		// Are we currently running a module?
		if($this->_exportSession['CurrentModule']) {

			$this->Debug("[A] In module - {$this->_exportSession['CurrentModule']}");

			$module = $this->_exportSession['CurrentModule'];

			// This module has just finished running. Is there a cleanup method we need to run?
			if(isset($this->_exportSession[$module]['running']) == 1 && $this->_exportSession[$module]['done'] >= $this->_exportSession[$module]['count']) {
				if(method_exists($this, $module."Cleanup")) {
					$action = $module."Cleanup";
					$this->$action();
				}
				// Now we're all cleaned up, this module is complete.
				$this->_exportSession['JustFinished'] = $this->_exportSession['CurrentModule'];
				$this->_exportSession['CleanupStack'][] = $this->_exportSession['CurrentModule'];
				$this->_exportSession['CurrentModule'] = '';
				$this->_exportSession[$module]['finished'] = time();

				// Still have one or more modules to run? (we're doing an all)
				if(isset($this->_exportSession['ModuleStack']) && count($this->_exportSession['ModuleStack']) > 0) {
					$next = array_shift($this->_exportSession['ModuleStack']);
					if($next) {
						$this->_UpdateExportSession();
						$this->_WritePendingExportLogs();
						if(!isset($this->_exportSession[$next])) {
							echo "<script type=\"text/javascript\">self.parent.location = 'index.php?ToDo=showExporterFrame&module=".$next."&time=".time()."';</script>\n";
							exit;
						}
					}
				}

				$this->_exportSession['FinishedAll'] = 1;
				$this->_UpdateExportSession();
				$this->_WritePendingExportLogs();
				$this->HideExportFrame(true);
			}
			// Still running a module
			else {
				$this->_exportSession[$module]['running'] = 1;
				$this->$module();
			}
			$this->_UpdateExportSession();
			$this->_WritePendingExportLogs();

			echo "<script type=\"text/javascript\">setTimeout(function() { window.location = 'index.php?ToDo=runExporter&time=".time()."'}, 10);</script>\n";
			exit;
		}
	}

	/**
	 * Show the export containing the success/failure count for a particular module.
	 */
	protected function ShowExporterReport()
	{
		$this->_LoadExportSession();

		if(!isset($_GET['module'])) {
			exit;
		}

		if(!isset($this->_exportSession[$_GET['module']])) {
			exit;
		}

		$GLOBALS['Report'] = $this->BuildExporterReport($_GET['module'], $this->_exportSession[$_GET['module']]);

		$GLOBALS['ReportTitle'] = GetLang('ReportTitle' . $_GET['module']);
		$GLOBALS['ReportDesc'] = GetLang('ReportDesc' . $_GET['module']);
		$GLOBALS['Module'] = $_GET['module'];

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$this->ParseTemplate("exporters.report");
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
	protected function BuildExporterReport($module, $moduleInfo)
	{
		$report = '<ul>';
		if(isset($moduleInfo['errors'])) {
			$moduleInfo['done'] -= $moduleInfo['errors'];
		}

		foreach(array('done') as $type) {
			$amount = number_format($moduleInfo[$type]);
			$report .= "<li>\n";
			if($amount == 1) {
				$report .= GetLang('Report' . $module . ucfirst($type) . 'One');
			}
			else {
				$amount = number_format($amount);
				$report .= sprintf(GetLang('Report' . $module . ucfirst($type) . 'Many'), $amount);
			}
			$report .= "</li>\n";
		}

		foreach(array('invalid') as $type) {
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
	protected function ViewExporterLog()
	{
		$this->_LoadExportSession();

		if(!isset($_GET['module'])) {
			exit;
		}

		if(!isset($this->_exportSession[$_GET['module']])) {
			exit;
		}

		$GLOBALS['Results'] = '';
		$query = sprintf("select data from [|PREFIX|]export_session where type='log' and module='%s' and log='%s'", $_GET['module'], $GLOBALS['ISC_CLASS_DB']->Quote($_GET['log']));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$GLOBALS['Results'] .= isc_html_escape(trim($row['data']))."\n";
		}

		switch($_GET['log'])
		{
			case "duplicates":
				$GLOBALS['Heading'] = GetLang('LogTitleDuplicates');
				$GLOBALS['Intro'] = GetLang('LogIntroDuplicates');
				break;
			default:
				$GLOBALS['Heading'] = GetLang('LogTitleInvalid');
				$GLOBALS['Intro'] = GetLang('LogTitleInvalid');
				break;
		}
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$this->ParseTemplate("exporters.log");
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pagefooter.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		exit;

	}

	/**
	 * Update the export progress bar.
	 *
	 * @param string The action we're performing ('Exporting x of y..')
	 * @param int The number of iterms exported so far.
	 * @param int The total number of items to be exported.
	 */
	protected function UpdateProgress($action, $done=0, $total=0)
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

	protected function ExportOrders()
	{
		$start = $this->_exportSession['ExportOrders']['done'];

		// On our first iteration, store the number of records in this table we'll be exporting
		if($this->_exportSession['ExportOrders']['done'] == 0) {
			$query = "SELECT COUNT(orderid) FROM [|PREFIX|]orders";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$this->_exportSession['ExportOrders']['count'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			$this->_exportSession['ExportOrders']['done'] = 0;
		}

		$query = "
			SELECT *
			FROM [|PREFIX|]orders o
			ORDER BY o.orderid ASC
		";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, ISC_EXPORT_ORDERS_PER_PAGE);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		while($order = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$order['products'] = array();

			// Select the products for this order
			$query2 = sprintf("
				SELECT *
				FROM [|PREFIX|]order_products
				WHERE orderorderid='%s'",
				$order['orderid']
			);
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
			while($row2 = $GLOBALS['ISC_CLASS_DB']->Fetch($result2)) {
				$order['products'][] = $row2;
			}

			$this->UpdateProgress(GetLang('StatusExportingOrder'), $this->_exportSession['ExportOrders']['done'], $this->_exportSession['ExportOrders']['count']);
			$this->InsertOrder($order['orderid'], $order);
			++$this->_exportSession['ExportOrders']['done'];
		}
	}

	protected function ExportCategories()
	{
		$start = $this->_exportSession['ExportCategories']['done'];

		// On our first iteration, store the number of records in this table we'll be exporting
		if($this->_exportSession['ExportCategories']['done'] == 0) {
			$query = "SELECT COUNT(categoryid) FROM [|PREFIX|]categories";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$this->_exportSession['ExportCategories']['count'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			$this->_exportSession['ExportCategories']['done'] = 0;
		}
		$query = "SELECT * FROM [|PREFIX|]categories ORDER BY categoryid ASC";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, ISC_EXPORT_CATEGORIES_PER_PAGE);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($category = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$this->UpdateProgress(GetLang('StatusExportingCategory'), $this->_exportSession['ExportCategories']['done'], $this->_exportSession['ExportCategories']['count']);
			$this->InsertCategory($category['categoryid'], $category);
			++$this->_exportSession['ExportCategories']['done'];

		}
	}

	protected function ExportBrands()
	{
		$start = $this->_exportSession['ExportBrands']['done'];

		// On our first iteration, store the number of records in this table we'll be exporting
		if($this->_exportSession['ExportBrands']['done'] == 0) {
			$query = "SELECT COUNT(brandid) FROM [|PREFIX|]brands";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$this->_exportSession['ExportBrands']['count'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			$this->_exportSession['ExportBrands']['done'] = 0;
		}
		$query = "SELECT * FROM [|PREFIX|]brands ORDER BY brandid ASC";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, ISC_EXPORT_CATEGORIES_PER_PAGE);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($brand = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$this->UpdateProgress(GetLang('StatusExportingBrand'), $this->_exportSession['ExportBrands']['done'], $this->_exportSession['ExportBrands']['count']);
			$this->InsertBrand($brand['brandid'], $brand);
			++$this->_exportSession['ExportBrands']['done'];

		}
	}

	protected function ExportCustomers()
	{
		$start = $this->_exportSession['ExportCustomers']['done'];

		// On our first iteration, store the number of records in this table we'll be exporting
		if($this->_exportSession['ExportCustomers']['done'] == 0) {
			$query = "SELECT COUNT(customerid) FROM [|PREFIX|]customers";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$this->_exportSession['ExportCustomers']['count'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			$this->_exportSession['ExportCustomers']['done'] = 0;
		}
		$query = "SELECT * FROM [|PREFIX|]customers ORDER BY customerid ASC";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, ISC_EXPORT_CUSTOMERS_PER_PAGE);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$customer['addresses'] = array();
		while($customer = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			// Fetch any shipping addresses for this customer
			$query2 = sprintf("SELECT * FROM [|PREFIX|]shipping_addresses WHERE shipcustomerid='%d'", $customer['customerid']);
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2)) {
				$customer['addresses'][] = $row;
			}

			$this->UpdateProgress(GetLang('StatusExportingCustomer'), $this->_exportSession['ExportCustomers']['done'], $this->_exportSession['ExportCustomers']['count']);
			$this->InsertCustomer($customer['customerid'], $customer);
			++$this->_exportSession['ExportCustomers']['done'];
		}
	}

	protected function ExportUsers()
	{
		$start = $this->_exportSession['ExportUsers']['done'];

		// On our first iteration, store the number of records in this table we'll be exporting
		if($this->_exportSession['ExportUsers']['done'] == 0) {
			$query = "SELECT COUNT(pk_userid) FROM [|PREFIX|]users";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$this->_exportSession['ExportUsers']['count'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			$this->_exportSession['ExportUsers']['done'] = 0;
		}
		$query = "SELECT * FROM [|PREFIX|]users ORDER BY pk_userid ASC";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, ISC_EXPORT_USERS_PER_PAGE);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($user = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$this->UpdateProgress(GetLang('StatusExportingUser'), $this->_exportSession['ExportUsers']['done'], $this->_exportSession['ExportUsers']['count']);
			$this->InsertUser($user['pk_userid'], $user);
			++$this->_exportSession['ExportUsers']['done'];

		}
	}

	protected function ExportReviews()
	{
		$start = $this->_exportSession['ExportReviews']['done'];

		// On our first iteration, store the number of records in this table we'll be exporting
		if($this->_exportSession['ExportReviews']['done'] == 0) {
			$query = "SELECT COUNT(reviewid) FROM [|PREFIX|]reviews";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$this->_exportSession['ExportReviews']['count'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			$this->_exportSession['ExportReviews']['done'] = 0;
		}
		$query = "SELECT * FROM [|PREFIX|]reviews ORDER BY reviewid ASC";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, ISC_EXPORT_REVIEWS_PER_PAGE);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($review = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$this->UpdateProgress(GetLang('StatusExportingReview'), $this->_exportSession['ExportReviews']['done'], $this->_exportSession['ExportReviews']['count']);
			$this->InsertReview($review['reviewid'], $review);
			++$this->_exportSession['ExportReviews']['done'];

		}
	}

	protected function ExportSubscribers()
	{
		$start = $this->_exportSession['ExportSubscribers']['done'];

		// On our first iteration, store the number of records in this table we'll be exporting
		if($this->_exportSession['ExportSubscribers']['done'] == 0) {
			$query = "SELECT COUNT(subscriberid) FROM [|PREFIX|]subscribers";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$this->_exportSession['ExportSubscribers']['count'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			$this->_exportSession['ExportSubscribers']['done'] = 0;
		}
		$query = "SELECT * FROM [|PREFIX|]subscribers ORDER BY subsciberid ASC";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, ISC_EXPORT_SUBSCRIBERS_PER_PAGE);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($subscriber = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$this->UpdateProgress(GetLang('StatusExportingSubscriber'), $this->_exportSession['ExportSubscribers']['done'], $this->_exportSession['ExportSubscribers']['count']);
			$this->InsertSubscriber($subscriber['subscriberid'], $subscriber);
			++$this->_exportSession['ExportSubscribers']['done'];

		}
	}

	protected function ExportProducts()
	{
		$start = $this->_exportSession['ExportProducts']['done'];

		// On our first iteration, store the number of records in this table we'll be exporting
		if($this->_exportSession['ExportProducts']['done'] == 0) {
			$query = "SELECT COUNT(productid) FROM [|PREFIX|]products";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$this->_exportSession['ExportProducts']['count'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			$this->_exportSession['ExportProducts']['done'] = 0;
		}
		$query = "SELECT * FROM [|PREFIX|]products ORDER BY productid ASC";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, ISC_EXPORT_CATEGORIES_PER_PAGE);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($product = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

			// Fetch any categories for this product
			$product['categories'] = array();
			$query2 = sprintf("SELECT * FROM [|PREFIX|]categoryassociations WHERE productid='%d'", $product['productid']);
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
			while($category = $GLOBALS['ISC_CLASS_DB']->Fetch($result2)) {
				$product['categories'][] = $category['categoryid'];
			}

			// Fetch any images for this product
			$product['images'] = array();
			$query2 = sprintf("SELECT * FROM [|PREFIX|]product_images WHERE imageprodid='%d'", $product['productid']);
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
			while($image = $GLOBALS['ISC_CLASS_DB']->Fetch($result2)) {
				$image['imagefile'] = realpath(ISC_BASE_PATH.'/'.GetConfig('ImageDirectory')."/".$image['imagefile']);
				$product['images'][] = $image;
			}

			// Fetch any custom fields for this product
			$product['custom_fields'] = array();
			$query2 = sprintf("SELECT * FROM [|PREFIX|]product_customfields WHERE fieldprodid='%d'", $product['productid']);
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
			while($field = $GLOBALS['ISC_CLASS_DB']->Fetch($result2)) {
				$product['custom_fields'][] = $field;
			}

			// Fetch any product options
			$product['options'] = array();
			$query2 = sprintf("SELECT * FROM [|PREFIX|]product_options WHERE optprodid='%d'", $product['productid']);
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
			while($option = $GLOBALS['ISC_CLASS_DB']->Fetch($result2)) {
				$product['options'][] = $option;
			}

			// Fetch any product downloads
			$product['downloads'] = array();
			$query2 = sprintf("SELECT * FROM [|PREFIX|]product_downloads WHERE productid='%d'", $product['productid']);
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
			while($download = $GLOBALS['ISC_CLASS_DB']->Fetch($result2)) {
				$download['downfile'] = realpath(ISC_BASE_PATH.'/'.GetConfig('DownloadDirectory')."/".$download['downfile']);
				$product['downloads'][] = $download;
			}

			$this->UpdateProgress(GetLang('StatusExportingProduct'), $this->_exportSession['ExportProducts']['done'], $this->_exportSession['ExportProducts']['count']);
			$this->InsertProduct($product['productid'], $product);
			++$this->_exportSession['ExportProducts']['done'];
		}
	}

	protected function ExportWishlists()
	{
		$start = $this->_exportSession['ExportWishlists']['done'];

		// On our first iteration, store the number of records in this table we'll be exporting
		if($this->_exportSession['ExportWishlists']['done'] == 0) {
			$query = "SELECT COUNT(*) FROM [|PREFIX|]wishlists";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$this->_exportSession['ExportWishlists']['count'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			$this->_exportSession['ExportWishlists']['done'] = 0;
		}
		$query = "SELECT * FROM [|PREFIX|]wishlists ORDER BY productid ASC";
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, ISC_EXPORT_WISHLISTS_PER_PAGE);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($wishlist = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$this->UpdateProgress(GetLang('StatusExportingWishlist'), $this->_exportSession['ExportWishlists']['done'], $this->_exportSession['ExportWishlists']['count']);
			$this->InsertWishlist($wishlist['wishlistid'], $wishlist);
			++$this->_exportSession['ExportWishlists']['done'];
		}
	}

	/**
	 * Gets & parses a exporter template. This has its own method because exporter templates are
	 * stored independently of the rest of the store.
	 *
	 * @param string The name of the template.
	 * @param boolean True to return the template, false to output.
	 */
	protected function ParseTemplate($template, $return = false)
	{
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("../includes/converter/templates/".$template);
		return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate($return);
	}

	/**
	 * Create the export session table in the database. This is used to store all of the information about
	 * the current export session.
	 */
	protected function _CreateExportSession()
	{
		$query = "create table [|PREFIX|]export_session (
			type varchar(20) not null default '',
			module varchar(30) not null default '',
			log varchar(30) not null default '',
			data text not null
		)";
		$GLOBALS['ISC_CLASS_DB']->Query($query);

		$query = "insert into [|PREFIX|]export_session (type,data) values ('primary', '')";
		$GLOBALS['ISC_CLASS_DB']->Query($query);
		$this->_exportSession = array();
	}

	/**
	 * Load the export ession from the database. Populates the _exportSession variable.
	 */
	protected function _LoadExportSession()
	{
		$query = "select data from [|PREFIX|]export_session where type='primary'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$this->_exportSession = @unserialize($GLOBALS['ISC_CLASS_DB']->FetchOne($result));
	}

	/**
	 * Takes the current export session imformation from _exportSession and writes it to the database.
	 */
	protected function _UpdateExportSession()
	{
		$exportSession = serialize($this->_exportSession);
		$query = sprintf("update [|PREFIX|]export_session set data='%s' where type='primary'", $GLOBALS['ISC_CLASS_DB']->Quote($exportSession));
		$GLOBALS['ISC_CLASS_DB']->Query($query);
	}

	/**
	 * Log an export error. This only writes the error to memory. To commit, call _WritePendingExportLogs().
	 *
	 * @param string The type of error (duplicate, invalid, etc)
	 * @param string The message to add to the error log.
	 */
	protected function _LogExportError($type, $message)
	{
		$module = $this->_exportSession['CurrentModule'];

		if(!isset($this->_exportErrors[$module][$type])) {
			$this->_exportErrors[$module][$type] = '';
		}

		$this->_exportErrors[$module][$type] .= $message."\n";

		++$this->_exportSession[$module]['errors'];

		if(isset($this->_exportSession[$module][$type])) {
			++$this->_exportSession[$module][$type];
		} else {
			$this->_exportSession[$module][$type] = 1;
		}
	}

	/**
	 * Write any pending export logs in memory to the export sesion database.
	 */
	protected function _WritePendingExportLogs()
	{
		if(count($this->_exportErrors) == 0) {
			return false;
		}

		foreach($this->_exportErrors as $module => $typeLog) {
			foreach($typeLog as $type => $log) {
				$query = sprintf("insert into [|PREFIX|]export_session (type,module,log,data) values ('log','%s','%s','%s')", $GLOBALS['ISC_CLASS_DB']->Quote($module), $GLOBALS['ISC_CLASS_DB']->Quote($type), $GLOBALS['ISC_CLASS_DB']->Quote($log));
				$GLOBALS['ISC_CLASS_DB']->Query($query);
			}
		}
	}

	/**
	 * Fetch a list of supported exporters by checking the exporters directory.
	 *
	 * @return array Array of exporters containing exporter ID and configuraiton fields.
	 */
	protected function FetchExporterList()
	{
		$exporterRoot = APP_ROOT."/includes/converter/exporters/";
		$files = scandir($exporterRoot);

		foreach($files as $file) {
			if(!is_file($exporterRoot.$file) || isc_substr($file, -3) != "php") {
				continue;
			}

			require_once $exporterRoot.$file;
			$file = isc_substr($file, 0, isc_strlen($file)-4);
			$className = "ISC_ADMIN_EXPORTER_".isc_strtoupper($file);
			if(!class_exists($className)) {
				continue;
			}
			$exporter = new $className;
			$exporters[$file] = array(
				"title" => $exporter->title,
				"configuration" => ""
			);
			if(method_exists($exporter, "Configure")) {
				$exporters[$file]['configuration'] = $exporter->Configure();
			}
		}
		return $exporters;
	}

	/**
	 * Log debug information to the export debug file.
	 *
	 * @param string The message to log.
	 * @param string The file to save the message to.
	 */
	protected function Debug($message, $file="")
	{
		if($this->_Debug == false) {
			return;
		}
		if(is_array($message)) {
			$message = var_export($message, true);
		}
		if($file == '') {
			$file = 'log';
		}
		$fp = fopen(APP_ROOT."/includes/converter/logs/export-{$file}.txt", "a+");
		fwrite($fp, "[".isc_date("r")."] ".$message."\n\n");
		fclose($fp);
	}

	/**
	 * Convert a MySQL datetime field to a UNIX timestamp.
	 *
	 * @param string The date time field.
	 * @param int The generated UNIX timestamp.
	 */
	protected function DatetimeToUnix($DateTime)
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
	protected function URLToPath($url, &$err)
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

		$upDirectories = str_repeat("../", isc_substr_count($ourURL['path'], "/"));
		if(isc_substr($theirURL['path'], 0, 1) == "/") {
			$theirURL['path'] = isc_substr($theirURL['path'], 1);
		}
		return APP_ROOT."/../".$upDirectories.$theirURL['path'];
	}

	/**
	 * Convert a Interspire Shopping Cart integer value to a yes/no value for the selected application
	 */
	protected function IntToYesNo($value)
	{
		if($value == 1 && isset($this->yesValue)) {
			return $this->yesValue;
		}
		else if(isset($this->noValue)) {
			return $this->noValue;
		}
	}

	protected function UnixToDatetime($stamp)
	{
		return date("Y-m-d H:i:s", $stamp);
	}
}
?>