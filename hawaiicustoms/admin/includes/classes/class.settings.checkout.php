<?php

class ISC_ADMIN_SETTINGS_CHECKOUT
{
	public function __construct()
	{
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('settings.checkout');
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseFrontendLangFile();

		include_once(ISC_BASE_PATH . '/lib/form.php');
		$GLOBALS['ISC_CLASS_FORM'] = new ISC_FORM();
	}

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
			GetLang('CheckoutSettings') => "index.php?ToDo=viewCheckoutSettings"
		);

		switch(isc_strtolower($Do))
		{
			case "saveupdatedcheckoutsettings":
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->SaveUpdatedCheckoutSettings();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			case "viewcheckoutsettings":
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->ManageCheckoutSettings();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;

			default:
				$this->ManageCheckoutSettings();
				break;
		}
	}

	private function ManageCheckoutSettings($messages=array())
	{
		$GLOBALS['Message'] = GetFlashMessageBoxes();

		$GLOBALS['CheckoutJavaScript'] = "";
		$GLOBALS['CheckoutProviders'] = $this->GetCheckoutProvidersAsOptions();

		// Which checkout modules are enabled?
		$checkouts = GetEnabledCheckoutModules();
		$GLOBALS['CheckoutTabs'] = "";
		$GLOBALS['CheckoutDivs'] = "";
		$count = 1;

		// Setup each shipping module with its own tab
		foreach ($checkouts as $checkout) {
			$GLOBALS['CheckoutTabs'] .= sprintf('<li><a href="#" id="tab%d" onclick="ShowTab(%d)">%s</a></li>', $count, $count, $checkout['name']);
			$GLOBALS['CheckoutDivs'] .= sprintf('<div id="div%d" style="padding-top: 10px;">%s</div>', $count, $checkout['object']->getpropertiessheet($count));
			$count++;
		}

		// Get a list of order statuses for the status change notifications
		$statuses = explode(",", GetConfig('OrderStatusNotifications'));
		$GLOBALS['OrderStatusEmailList'] = '';
		$query = "SELECT * FROM [|PREFIX|]order_status ORDER BY statusorder ASC";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			if (in_array($row['statusid'], $statuses)) {
				$sel = 'selected="selected"';
			} else {
				$sel = '';
			}

			$GLOBALS['OrderStatusEmailList'] .= sprintf("<option value='%s' %s>%s</option>", $row['statusid'], $sel, sprintf(GetLang('OrderStatusChangedTo'), $row['statusdesc']));
		}

		if (GetConfig('UpdateInventoryLevels') == 1) {
			$GLOBALS['UpdateInventorySuccessfulSelected'] = 'selected="selected"';
		}
		else {
			$GLOBALS['UpdateInventoryCompletedSelected'] = 'selected="selected"';
		}

		if (GetConfig('CurrencyLocation') == 'right') {
			$GLOBALS['RightCurrencyToken'] = GetConfig('CurrencyToken');
		} else {
			$GLOBALS['LeftCurrencyToken'] = GetConfig('CurrencyToken');
		}

		if(GetConfig('CheckoutType') == 'single') {
			$GLOBALS['CheckoutTypeSingleSelected'] = 'selected="selected"';
		}
		else {
			$GLOBALS['CheckoutTypeMultiSelected'] = 'selected="selected"';
		}

		if(GetConfig('GuestCheckoutEnabled')) {
			$GLOBALS['GuestCheckoutChecked'] = 'checked="checked"';
		}
		else {
			$GLOBALS['HideGuestCheckoutCreateAccounts'] = 'display: none';
		}

		if(GetConfig('GuestCheckoutCreateAccounts')) {
			$GLOBALS['GuestCheckoutCreateAccountsCheck'] = 'checked="checked"';
		}

		if(GetConfig('DigitalOrderHandlingFee') > 0) {
			$GLOBALS['DigitalOrderHandlingFeeChecked'] = 'checked="checked"';
			$GLOBALS['DigitalOrderHandlingFee'] = GetConfig('DigitalOrderHandlingFee');
		}
		else {
			$GLOBALS['HideDigitalOrderHandlingFee'] = 'display: none';
		}

		if(GetConfig('EnableOrderComments')) {
			$GLOBALS['IsEnableOrderComments'] = "checked=\"checked\"";
		}

		if(GetConfig('EnableOrderTermsAndConditions')) {
			$GLOBALS['IsEnableOrderTermsAndConditions'] = "checked=\"checked\"";
		}
		else {
			$GLOBALS['IsEnableOrderTermsAndConditions'] = "";
			$GLOBALS['HideOrderTermsAndConditions'] = 'display:none;';
		}

		if(GetConfig('OrderTermsAndConditionsType') != "textarea") {
			$GLOBALS['HideOrderTermsAndConditionsTextarea'] = 'display: none';
		} else {
			$GLOBALS['IsEnableOrderTermsAndConditionsTextarea'] = "checked=\"checked\"";
			$GLOBALS['OrderTermsAndConditions'] = GetConfig('OrderTermsAndConditions');
		}

		if(GetConfig('OrderTermsAndConditionsType') != "link") {
			$GLOBALS['HideOrderTermsAndConditionsLink'] = 'display: none';
			$GLOBALS['OrderTermsAndConditionsLink'] = "http://";
		} else {
			$GLOBALS['IsEnableOrderTermsAndConditionsLink'] = "checked=\"checked\"";
			$GLOBALS['OrderTermsAndConditionsLink'] = GetConfig('OrderTermsAndConditionsLink');
		}

		if(GetConfig('MultipleShippingAddresses') && gzte11(ISC_MEDIUMPRINT)) {
			$GLOBALS['IsMultipleShippingAddressesEnabled'] = "checked=\"checked\"";
		}
		else if(!gzte11(ISC_MEDIUMPRINT)) {
			$GLOBALS['HideMultiShipping'] = 'display: none';
		}

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.checkout.manage");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	private function SaveUpdatedCheckoutSettings()
	{
		// Firstly we will delete *all* existing module variables for shippers. This way, if one
		// was previously configured and unchecked then its old variables wont be saved and it
		// wont be marked as configured even when it's not
		$GLOBALS['ISC_CLASS_DB']->DeleteQuery('module_vars', "WHERE modulename like 'checkout_%'");

		if (!isset($_POST['checkoutproviders'])) {
			$_POST['checkoutproviders'] = array();
		}

		$enabledStack = array();
		$messages = array();

		// Can the selected payment modules be enabled?
		foreach ($_POST['checkoutproviders'] as $provider) {
			GetModuleById('checkout', $module, $provider);
			if (is_object($module)) {
			// Is this checkout provider supported on this server?
				if($module->IsSupported() == false) {
					$errors = $module->GetErrors();
					foreach($errors as $error) {
						FlashMessage($error, MSG_ERROR);
					}
					continue;
				}

				// Otherwise, this checkout provider is fine, so add it to the stack of enabled
				$enabledStack[] = $provider;
			}
		}

		$checkoutproviders = implode(",", $enabledStack);
		$GLOBALS['ISC_NEW_CFG']['CheckoutMethods'] = $checkoutproviders;

		// Save the order settings they specified too
		if ($_POST['updateinventory'] == 1) {
			$GLOBALS['ISC_NEW_CFG']['UpdateInventoryLevels'] = 1;
		}
		else {
			$GLOBALS['ISC_NEW_CFG']['UpdateInventoryLevels'] = 0;
		}

		if(isset($_POST['EnableDigitalOrderHandlingFee'])) {
			$GLOBALS['ISC_NEW_CFG']['DigitalOrderHandlingFee'] = $_POST['DigitalOrderHandlingFee'];
		}

		// Save any selected notification statuses
		if (isset($_POST['orderstatusemails']) && is_array($_POST['orderstatusemails'])) {
			$GLOBALS['ISC_NEW_CFG']['OrderStatusNotifications'] = implode(",", array_map("intval", $_POST['orderstatusemails']));
		}

		if($_POST['CheckoutType'] == 'single') {
			$GLOBALS['ISC_NEW_CFG']['CheckoutType'] = 'single';
		}
		else {
			$GLOBALS['ISC_NEW_CFG']['CheckoutType'] = 'multipage';
		}

		if(isset($_POST['EnableOrderComments'])) {
			$GLOBALS['ISC_NEW_CFG']['EnableOrderComments'] = 1;
		}
		else {
			$GLOBALS['ISC_NEW_CFG']['EnableOrderComments'] = 0;
		}


		if(isset($_POST['EnableOrderTermsAndConditions']) && isset($_POST['OrderTermsAndConditionsType'])) {

			if($_POST['OrderTermsAndConditionsType'] == 'link') {
				if(trim($_POST['OrderTermsAndConditionsLink']) == '' || trim($_POST['OrderTermsAndConditionsLink']) == "http://") {
					FlashMessage(GetLang('EnterTermsAndConditionsLink'), MSG_ERROR);
				} else {
					$GLOBALS['ISC_NEW_CFG']['OrderTermsAndConditionsLink'] = $_POST['OrderTermsAndConditionsLink'];
				}
			} else {
				if(trim($_POST['OrderTermsAndConditionsTextarea']) == '') {
					FlashMessage(GetLang('EnterTermsAndConditions'), MSG_ERROR);
				} else {
					$GLOBALS['ISC_NEW_CFG']['OrderTermsAndConditions'] = $_POST['OrderTermsAndConditionsTextarea'];
				}
			}
			$GLOBALS['ISC_NEW_CFG']['OrderTermsAndConditionsType'] = $_POST['OrderTermsAndConditionsType'];
			$GLOBALS['ISC_NEW_CFG']['EnableOrderTermsAndConditions'] = 1;
		}
		else {
			$GLOBALS['ISC_NEW_CFG']['EnableOrderTermsAndConditions'] = 0;
			$GLOBALS['ISC_NEW_CFG']['OrderTermsAndConditions'] = "";
		}

		if(isset($_POST['MultipleShippingAddresses'])) {
			$GLOBALS['ISC_NEW_CFG']['MultipleShippingAddresses'] = 1;
		}
		else {
			$GLOBALS['ISC_NEW_CFG']['MultipleShippingAddresses'] = 0;
		}

		$GLOBALS['ISC_NEW_CFG']['GuestCheckoutEnabled'] = 0;
		$GLOBALS['ISC_NEW_CFG']['GuestCheckoutCreateAccounts'] = 0;

		if(isset($_POST['GuestCheckoutEnabled'])) {
			$GLOBALS['ISC_NEW_CFG']['GuestCheckoutEnabled'] = 1;
			if(isset($_POST['GuestCheckoutCreateAccounts'])) {
				$GLOBALS['ISC_NEW_CFG']['GuestCheckoutCreateAccounts'] = 1;
			}
		}

		$settings = GetClass('ISC_ADMIN_SETTINGS');
		$messages = array();
		if ($settings->CommitSettings($messages)) {
			// Save the module settings to the module_vars table
			// First, delete all existing entries

			foreach($messages as $message => $status) {
				FlashMessage($message, $status);
			}

			// Delete existing module configuration
			$GLOBALS['ISC_CLASS_DB']->DeleteQuery('module_vars', "WHERE modulename LIKE 'checkout\_%'");

			// Now get all checkout variables (they are in an array from $_POST)
			foreach($enabledStack as $module_id) {
				$vars = array();
				if(isset($_POST[$module_id])) {
					$vars = $_POST[$module_id];
				}

				GetModuleById('checkout', $module, $module_id);
				$module->SaveModuleSettings($vars);
			}

			// Rebuild the cache of the checkout module variables
			$GLOBALS['ISC_CLASS_DATA_STORE']->UpdateCheckoutModuleVars();

			if ($GLOBALS['ISC_CLASS_DB']->Error() == "") {

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();

				FlashMessage(GetLang('CheckoutSettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewCheckoutSettings');
			}
			else {
				FlashMessage(GetLang('CheckoutSettingsNotSaved'), MSG_ERROR, 'index.php?ToDo=viewCheckoutSettings');

			}
		} else {
			FlashMessage(GetLang('CheckoutSettingsNotSaved'), MSG_ERROR, 'index.php?ToDo=viewCheckoutSettings');
		}
	}

	public function GetCheckoutProvidersAsOptions()
	{
		// Get a list of all available checkout providers as <option> tags
		$checkouts = GetAvailableModules('checkout');
		$output = "";

		foreach ($checkouts as $checkout) {
			$sel = '';
			if($checkout['enabled']) {
				$sel = 'selected="selected"';
			}
			$output .= sprintf("<option %s value='%s'>%s</option>", $sel, $checkout['id'], $checkout['name']);
		}

		return $output;
	}
}

?>