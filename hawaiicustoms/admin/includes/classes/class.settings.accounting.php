<?php
class ISC_ADMIN_SETTINGS_ACCOUNTING
{
	/**
	 * Handle the action for this section.
	 *
	 * @param string The name of the action to do.
	 */
	public function HandleToDo($Do)
	{
		if (isset($_REQUEST['currentTab'])) {
			$GLOBALS['CurrentTab'] = (int)$_REQUEST['currentTab'];
		}
		else {
			$GLOBALS['CurrentTab'] = 0;
		}

		$GLOBALS['BreadcrumEntries'] = array (
			GetLang('Home') => "index.php",
			GetLang('Settings') => "index.php?ToDo=viewSettings",
			GetLang('AccountingSettings') => "index.php?ToDo=viewAccountingSettings"
		);

		if (!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings) || !gzte11(ISC_MEDIUMPRINT)) {
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			return;
		}

		/**
		 * Load the language file
		 */
		$lang = 'en';

		if (strpos(GetConfig('Language'), '/') === false) {
			$lang = GetConfig('Language');
		}

		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseLangFile(ISC_BASE_PATH . '/modules/accounting/quickbooks/lang/' . $lang . '/language.ini');

		switch(isc_strtolower($Do))
		{
			case "viewaccountingsettings": {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->ManageAccountingSettings();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "saveupdatedaccountingsettings": {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->SaveUpdatedAccountingSettings();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "getfileaccountingsettings": {
				$this->getFileAccountingSettings();
				break;
			}
			case "disablejobaccountingsettings": {
				$this->disableJobAccountingSettings();
				break;
			}
			case "reenablejobaccountingsettings": {
				$this->reenableJobAccountingSettings();
				break;
			}
			case "deletejobaccountingsettings": {
				$this->deleteJobAccountingSettings();
				break;
			}
			case "getjobaccountingsettingsspoollist": {
				$this->getJobAccountingSettingsSpoolList();
				break;
			}
			case "showaccountingsettingssyncpopup": {
				$this->showAccountingSettingsSyncPopup();
				break;
			}
			case "importaccountingsettingssyncnodes": {
				$this->importAccountingSettingsSyncNodes();
				break;
			}
			default:
				if(!isset($_REQUEST['ajax'])) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				}
				$this->ManageAccountingSettings();
				if(!isset($_REQUEST['ajax'])) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				}
				break;
		}
	}


	public function ManageAccountingSettings($messages=array())
	{
		$GLOBALS['Message'] = GetFlashMessageBoxes();

		$GLOBALS['AccountingProviders'] = $this->_getAccountingPackagesAsOptions();

		// Which shipping modules are enabled?
		$accountings = GetAvailableModules('accounting', true, false, true);

		$GLOBALS['AccountingTabs'] = "";
		$GLOBALS['AccountingDivs'] = "";
		$GLOBALS['SSLIsConfigured'] = GetConfig('UseSSL');
		$count = 2;

		// Setup each shipping module with its own tab
		foreach ($accountings as $accounting) {
			$GLOBALS['AccountingTabs'] .= sprintf('<li><a href="#" id="tab%d" onclick="ShowTab(%d)">%s</a></li>', $count, $count, $accounting['name']);
			$GLOBALS['AccountingDivs'] .= sprintf('<div id="div%d" style="padding-top: 10px;">%s</div>', $count, $accounting['object']->getpropertiessheet($count));

			$count++;
		}

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.accounting.manage");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	private function _getAccountingPackagesAsOptions()
	{
		// Get a list of all available accounting packages as <option> tags
		$packages = GetAvailableModules('accounting');
		$output = "";

		foreach ($packages as $package) {
			$sel = '';
			if($package['enabled']) {
				$sel = 'selected="selected"';
			}
			$output .= sprintf("<option %s value='%s'>%s</option>", $sel, $package['id'], $package['name']);
		}

		return $output;
	}

	public function SaveUpdatedAccountingSettings()
	{
		$originalAccountSettings = GetConfig('AccountingMethods');
		$enabledStack = array();
		$messages = array();

		// Can the selected payment modules be enabled?
		if (isset($_POST['accountingproviders']) && is_array($_POST['accountingproviders'])) {
			foreach ($_POST['accountingproviders'] as $moduleid) {
				GetModuleById('accounting', $module, $moduleid);
				if (is_object($module)) {
				// Is this checkout provider supported on this server?
					if($module->IsSupported() == false) {
						$errors = $module->GetErrors();
						foreach($errors as $error) {
							FlashMessage($error, MSG_ERROR);
						}

						return $this->ManageAccountingSettings();
					}

					// Otherwise, this accounting module is fine, so add it to the stack of enabled
					$enabledStack[] = $moduleid;
				}
			}
		}

		$accountingproviders = implode(",", $enabledStack);
		$GLOBALS['ISC_NEW_CFG']['AccountingMethods'] = $accountingproviders;

		$settings = GetClass('ISC_ADMIN_SETTINGS');
		$messages = array();
		if ($settings->CommitSettings($messages)) {
			if (is_array($messages) && !empty($messages)) {
				foreach($messages as $message => $status) {
					FlashMessage($message, $status);
				}
			}

			// Delete existing module configuration
			$GLOBALS['ISC_CLASS_DB']->DeleteQuery('module_vars', "WHERE modulename LIKE 'accounting\_%' AND MID(variablename, 1, 6) != 'setup_'");

			// Now get all checkout variables (they are in an array from $_POST)
			foreach($enabledStack as $module_id) {
				$vars = array();
				if(isset($_POST[$module_id])) {
					$vars = $_POST[$module_id];
				}

				GetModuleById('accounting', $module, $module_id);
				$module->SaveModuleSettings($vars, false);
			}

			/**
			 * Initialise our accounting modules. Only initialise the modules that were selected, no the modules that were already selected
			 */
			$old		= explode(',', $originalAccountSettings);
			$new		= explode(',', $accountingproviders);
			$accounting	= GetClass('ISC_ACCOUNTING');

			$accounting->initModules(array_diff($new, $old));

			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
			FlashMessage(GetLang('AccountingSettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewAccountingSettings&currentTab='.((int) $_POST['currentTab']));
		}
		else {
			FlashMessage(GetLang('AccountingSettingsNotSaved'), MSG_ERROR, 'index.php?ToDo=viewAccountingSettings&currentTab='.((int) $_POST['currentTab']));
		}
	}

	public function getFileAccountingSettings()
	{
		switch (strtolower(substr($_REQUEST["module"], 11))) {
			case "quickbooks": {
				switch (strtolower($_REQUEST["action"])) {
					case "qbwc": {
						GetModuleById("accounting", $module, $_REQUEST["module"]);

						$module->downloadQBWC();

						break;
					}
				}

				break;
			}
		}
	}

	public function disableJobAccountingSettings()
	{
		return $this->statusJobAccountingSettings('disable');
	}

	public function reenableJobAccountingSettings()
	{
		return $this->statusJobAccountingSettings('reenable');
	}

	public function deleteJobAccountingSettings()
	{
		return $this->statusJobAccountingSettings('delete');
	}

	private function statusJobAccountingSettings($status)
	{
		if (!array_key_exists('selectedJobs', $_REQUEST) || !count($jobs = array_filter(explode(',', $_REQUEST['selectedJobs'])))) {
			return;
		}

		GetModuleById('accounting', $module, $_REQUEST['module']);

		$module->modifyJobStatus($status, $jobs);

		FlashMessage(GetLang('AccountingSettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewAccountingSettings&currentTab='.((int) $_POST['currentTab']));
	}

	public function getJobAccountingSettingsSpoolList()
	{
		if (!array_key_exists('module', $_REQUEST)) {
			print '';
			exit;
		}

		GetModuleById("accounting", $module, $_REQUEST['module']);

		/**
		 * Force the ajax request variable just in case
		 */
		$_REQUEST['ajax'] = '1';

		$module->showSpoolList();
		exit;
	}

	public function showAccountingSettingsSyncPopup()
	{
		if (!array_key_exists('categories', $_REQUEST) || !is_array($categories = explode('|', $_REQUEST['categories']))) {
			print '';
			exit;
		}

		for ($i=0; $i<count($categories); $i++) {
			$categories[$i] = "'" . $categories[$i] . "'";
		}

		$GLOBALS['ImportCategories'] = '[' . implode(',', $categories) . ']';
		$GLOBALS['ModuleID'] = $_REQUEST['moduleid'];

		// Show the frame which holds the upgrade progress bar/details etc
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("accounting.import.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pagefooter.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	private function getAccountingSettingsSyncNodesType($section)
	{
		$table = '';
		$column = '';

		switch (strtolower($section)) {
			case 'customer':
				$table = 'customers';
				$column = 'customerid';
				break;

			case 'product':
				$table = 'products';
				$column = 'productid';
				break;

			case 'order':
				$table = 'orders';
				$column = 'orderid';
				break;

			default;
				return false;
				break;
		}

		return array('table' => $table, 'column' => $column);
	}

	private function resetAccountingSettingsSyncNodes($section)
	{
		if ($section == '') {
			return false;
		}

		$setup = $this->getAccountingSettingsSyncNodesType($section);

		if (!$setup) {
			return false;
		}

		if (!array_key_exists('AccountingImport', $_SESSION)) {
			$_SESSION['AccountingImport'] = array();
		}

		$_SESSION['AccountingImport'][$section] = array(
					'nodeidx' => array(),
					'total' => 0,
		);

		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT " . $setup['column'] . " AS nodeid FROM [|PREFIX|]" . $setup['table']);

		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$_SESSION['AccountingImport'][$section]['nodeidx'][] = $row['nodeid'];
		}

		$_SESSION['AccountingImport'][$section]['total'] = count($_SESSION['AccountingImport'][$section]['nodeidx']);
		return true;
	}

	private function importAccountingSettingsSyncNodes()
	{
		$rtn = array('status' => false);

		if (!array_key_exists('section', $_POST) || $_POST['section'] == '') {
			print isc_json_encode($rtn);
			exit;
		}

		if (!array_key_exists('moduleid', $_POST) || $_POST['moduleid'] == '') {
			print isc_json_encode($rtn);
			exit;
		}

		if (array_key_exists('reset', $_POST) && $_POST['reset'] == 1) {
			if (!$this->resetAccountingSettingsSyncNodes($_POST['section'])) {
				print isc_json_encode($rtn);
				exit;
			}
		}

		if (!array_key_exists('AccountingImport', $_SESSION) || !array_key_exists($_POST['section'], $_SESSION['AccountingImport'])) {
			print isc_json_encode($rtn);
			exit;
		}

		GetModuleById("accounting", $module, $_REQUEST['moduleid']);

		if (!$module) {
			print isc_json_encode($rtn);
			exit;
		}

		$rtn['status'] = true;
		$session =& $_SESSION['AccountingImport'][$_POST['section']];

		if (empty($session['nodeidx'])) {
			$rtn['percent'] = 100;
			$rtn['total'] = 0;
			print isc_json_encode($rtn);
			exit;
		}

		$importAmount = ceil($session['total'] / 100);
		$importAmount = max(1, $importAmount);

		$rtn['total'] = $importAmount;

		for ($i=0; $i<$importAmount; $i++) {
			if (!isset($session['nodeidx'][$i])) {
				break;
			}

			$module->importSync($_POST['section'], $session['nodeidx'][$i]);

			unset($session['nodeidx'][$i]);
		}

		if (!empty($session['nodeidx'])) {
			$_SESSION['AccountingImport'][$_POST['section']]['nodeidx'] = array_values($_SESSION['AccountingImport'][$_POST['section']]['nodeidx']);
			$total = $session['total'] - count($session['nodeidx']);
			$rtn['percent'] = round(($total/$session['total']) * 100);
		} else {
			$rtn['percent'] = 100;
		}

		print isc_json_encode($rtn);
		exit;
	}
}
?>