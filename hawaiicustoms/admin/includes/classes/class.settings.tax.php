<?php
/**
 * Tax settings/configuration management.
 */
class ISC_ADMIN_SETTINGS_TAX
{
	/**
	 * The constructor.
	 */
	public function __construct()
	{
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('settings.tax');

		if (isset($_REQUEST['currentTab'])) {
			$GLOBALS['CurrentTab'] = (int)$_REQUEST['currentTab'];
		} else {
			$GLOBALS['CurrentTab'] = 0;
		}
	}

	/**
	 * Handle the incoming action.
	 *
	 * @param string The name of the action we wish to perform.
	 */
	public function HandleToDo($do)
	{
		if (!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			return;
		}

		$GLOBALS['BreadcrumEntries'] = array (
			GetLang('Home') => "index.php",
			GetLang('Settings') => "index.php?ToDo=viewSettings",
		);

		switch (isc_strtolower($do))
		{
			case "settingsedittaxstatus":
			{
				$GLOBALS['BreadcrumEntries'][GetLang('TaxSettings')] = "index.php?ToDo=viewTaxSettings";

				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->UpdateTaxStatus();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "settingssavetaxsettings":
			{
				$GLOBALS['BreadcrumEntries'][GetLang('TaxSettings')] = "index.php?ToDo=viewTaxSettings";
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->SaveTaxSettings();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "settingsdeletetaxrates":
			{
				$GLOBALS['BreadcrumEntries'][GetLang('TaxSettings')] = "index.php?ToDo=viewTaxSettings";
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->DeleteTaxRates();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "settingsaddtaxrate":
			{
				$GLOBALS['BreadcrumEntries'][GetLang('TaxSettings')] = "index.php?ToDo=viewTaxSettings";
				$GLOBALS['BreadcrumEntries'][GetLang('AddTaxRate')] = "index.php?ToDo=settingsAddTaxRate";
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->AddTaxRate();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "settingssavenewtaxrate":
			{
				$GLOBALS['BreadcrumEntries'][GetLang('TaxSettings')] = "index.php?ToDo=viewTaxSettings";
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->SaveNewTaxRate();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "settingsedittaxrate":
			{
				$GLOBALS['BreadcrumEntries'][GetLang('TaxSettings')] = "index.php?ToDo=viewTaxSettings";
				$GLOBALS['BreadcrumEntries'][GetLang('EditTaxRate')] = "index.php?ToDo=settingsEditTaxRate";
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->EditTaxRate();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "settingssaveupdatedtaxrate":
			{
				$GLOBALS['BreadcrumEntries'][GetLang('TaxSettings')] = "index.php?ToDo=viewTaxSettings";
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->SaveUpdatedTaxRate();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			default:
				$GLOBALS['BreadcrumEntries'][GetLang('TaxSettings')] = "index.php?ToDo=viewTaxSettings";
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->ManageTaxSettings();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
		}
	}

	/**
	 * Return a list of available tax type options (what tax rates are based on - subtotal or subtotal + shipping)
	 *
	 * @param int The selected tax type.
	 * @return string The built list of available tax type options.
	 */
	private function GetTaxTypeOptions($selected = "")
	{
		$output = "";

		if ($selected == "0") {
			$sel = 'selected="selected"';
		} else {
			$sel = "";
		}

		$output .= sprintf("<option value='0' %s>%s</option>", $sel, GetLang('OrderSubTotal'));

		if ($selected == "1") {
			$sel = 'selected="selected"';
		} else {
			$sel = "";
		}

		$output .= sprintf("<option value='1' %s>%s</option>", $sel, GetLang('OrderSubTotalAndShipping'));
		return $output;
	}

	/**
	 * Show the store tax configuration and if tax is per state/country, the list of configured tax rates.
	 *
	 * @param array An array of messages to show if any.
	 */
	private function ManageTaxSettings($messages=array())
	{
		$GLOBALS['Message'] = GetFlashMessageBoxes();

		// Show a list of tax rates in a table
		$GLOBALS['TaxGrid'] = "";
		$GLOBALS['TaxRatesIntro'] = GetLang('TaxRatesIntro');

		// Get the results for the query
		$taxResult = $this->GetTaxRatesList();

		$GLOBALS['NoTaxRates'] = '';
		$GLOBALS['PricesIncludeTaxChecked'] = '';
		$GLOBALS['LocationSpecificTaxChecked'] = '';
		$GLOBALS['TaxTabs'] = '';
		$GLOBALS['HideGlobalTax'] = '';
		$GLOBALS['DefaultTab'] = 0;
		$GLOBALS['ShowTaxTableHeaders'] = '';
		$GLOBALS['TaxIntro'] = GetLang('TaxRatesIntro');
		$GLOBALS['TaxOptionsMessage'] = '';
		$GLOBALS['DefaultTaxRate'] = 0;
		$GLOBALS['DefaultTaxRateName'] = '';

		// Do we show the default tax form or the country/state specific one?
		if(GetConfig("TaxTypeSelected") != 1) {
			if (GetConfig('DefaultTaxRate') > 0) {
				$GLOBALS['DefaultTaxRateChecked'] = 'checked="checked"';
				$GLOBALS['DefaultTaxRate'] = FormatPrice(GetConfig('DefaultTaxRate'), false, false);
				$GLOBALS['DefaultTaxRateName'] = isc_html_escape(GetConfig('DefaultTaxRateName'));
				if(GetConfig('DefaultTaxRateBasedOn') == 'subtotal_and_shipping') {
					$GLOBALS['BasedOnSubTotalAndShipping'] = 'selected="selected"';
				}
				else {
					$GLOBALS['BasedOnSubTotal'] = 'selected="selected"';
				}
			} else {
				$GLOBALS['NoTaxChecked'] = 'checked="checked"';
				$GLOBALS['HideGlobalTax'] = 'none';
			}
		} else {
			$GLOBALS['LocationSpecificTaxChecked'] = 'checked="checked"';
			$GLOBALS['HideGlobalTax'] = 'none';
			$GLOBALS['DefaultTab'] = 1;

			$GLOBALS['TaxIntro'] = GetLang('TaxOptionsSettingsIntro');

			$count = 1;
			$GLOBALS['TaxTabs'] = sprintf('<li><a href="#" id="tab%d" onclick="ShowTab(%d)">%s</a></li>', $count, $count, GetLang('TaxOptions'));
		}

		if(GetConfig('PricesIncludeTax') == 1) {
			$GLOBALS['PricesIncludeTaxChecked'] = 'checked="checked"';
		}
		else {
			$GLOBALS['PricesIncludeTaxChecked'] = '';
		}

		if ($GLOBALS['ISC_CLASS_DB']->CountResult($taxResult) > 0) {
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($taxResult)) {
				// Output the sub pages details
				$countries = array();
				$states = array();

				$GLOBALS['TaxRateId'] = (int) $row['taxrateid'];
				$GLOBALS['TaxName'] = isc_html_escape($row['taxratename']);
				$GLOBALS['TaxRate'] = FormatPrice($row['taxratepercent'], false, false);

				$countries = GetCountriesByIds($row['taxratecountry']);

				if ($row['taxratestates'] != "") {
					$states = GetStatesByIds($row['taxratestates']);
				}

				if (count($states) == 0) {
					// This applies to one country and all of its states
					if (count($countries) > 0) {
						$GLOBALS['AppliesTo'] = $countries[0];
					} else {
						$GLOBALS['AppliesTo'] = GetLang('AllCountries');
					}
				}
				else {
					// One country, many states
					$GLOBALS['AppliesTo'] = $countries[0];
					$GLOBALS['AppliesTo'] .= "<ul>";

					foreach ($states as $state) {
						$GLOBALS['AppliesTo'] .= sprintf("<li>%s</li>", $state);
					}

					$GLOBALS['AppliesTo'] .= "</ul>";
				}

				if ($row['taxratestatus'] == 1) {
					$GLOBALS['Status'] = sprintf("<a title='%s' href='index.php?ToDo=settingsEditTaxStatus&amp;taxRateId=%d&amp;status=0'><img border='0' src='images/tick.gif' alt='tick'></a>", GetLang('TaxStatusDisable'), $row['taxrateid']);
				}
				else {
					$GLOBALS['Status'] = sprintf("<a title='%s' href='index.php?ToDo=settingsEditTaxStatus&amp;taxRateId=%d&amp;status=1'><img border='0' src='images/cross.gif' alt='tick'></a>", GetLang('TaxStatusEnable'), $row['taxrateid']);
				}

				$GLOBALS['EditRateLink'] = sprintf("<a title='%s' href='index.php?ToDo=settingsEditTaxRate&amp;taxRateId=%d'>%s</a>", GetLang('TaxRateEdit'), $row['taxrateid'], GetLang('Edit'));

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("tax.manage.row");
				$GLOBALS['TaxGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
		}
		else {
			// There are no tax rates in the database
			$GLOBALS['DisableDelete'] = "style='display:none'";
			$GLOBALS['DisplayGrid'] = "none";
			$GLOBALS['TaxOptionsMessage'] = MessageBox(GetLang('NoTaxRates'), MSG_INFO);
			$GLOBALS['ShowTaxTableHeaders'] = 'none';
		}

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.tax.manage");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
	 * Get a list of configured tax rates ordered by name.
	 *
	 * @return resource The resource result from the database query fetching the tax rates.
	 */
	private function GetTaxRatesList()
	{
		$query = "select * from [|PREFIX|]tax_rates order by taxratename asc";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		return $result;
	}

	/**
	 * Update the status (enabled or disabled) for a tax rate.
	 */
	private function UpdateTaxStatus()
	{
		if (isset($_GET['taxRateId']) && isset($_GET['status'])) {
			$taxRateId = (int)$_GET['taxRateId'];
			$status = (int)$_GET['status'];

			$updatedRate = array(
				"taxratestatus" => $status
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("tax_rates", $updatedRate, "taxrateid='".$GLOBALS['ISC_CLASS_DB']->Quote($taxRateId)."'");

			$err = $GLOBALS['ISC_CLASS_DB']->Error();

			if ($err == "") {
				$query = sprintf("SELECT taxratename FROM [|PREFIX|]tax_rates WHERE taxrateid='%d'", $taxRateId);
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$taxName = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($taxRateId, $taxName);

				FlashMessage(GetLang('TaxStatusSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewTaxSettings');
			} else {
				FlashMessage(GetLang('TaxErrStatusNotChanged'), MSG_ERROR, 'index.php?ToDo=viewTaxSettings');
			}
		}
	}

	/**
	 * Save an updated version of the store tax settings.
	 */
	private function SaveTaxSettings()
	{
		// If the default tax rate is a number make sure its > 0
		if (is_numeric($_POST['DefaultTaxRate']) && $_POST['DefaultTaxRate'] < 0) {
			$messages = array(GetLang('SettingsNotSaved') => MSG_ERROR);
			$this->ManageTaxSettings($messages);
			return;
		}

		$_POST['DefaultTaxRate'] = DefaultPriceFormat($_POST['DefaultTaxRate']);

		// If the default tax rate is not a number make sure it is empty
		if (!is_numeric($_POST['DefaultTaxRate']) && $_POST['DefaultTaxRate'] !== '') {
			$messages = array(GetLang('SettingsNotSaved') => MSG_ERROR);
			$this->ManageTaxSettings($messages);
			return;
		}

		if(isset($_POST['PricesIncludeTax']) == 1) {
			$GLOBALS['ISC_NEW_CFG']['PricesIncludeTax'] = 1;
		}
		else {
			$GLOBALS['ISC_NEW_CFG']['PricesIncludeTax'] = 0;
		}

		if (isset($_POST['DefaultTaxRate'])) {
			if (trim($_POST['DefaultTaxRate']) === '') {
				$GLOBALS['ISC_NEW_CFG']['DefaultTaxRate'] = '';
			} else {
				$GLOBALS['ISC_NEW_CFG']['DefaultTaxRate'] = (float) $_POST['DefaultTaxRate'];
			}
		} else {
			$GLOBALS['ISC_NEW_CFG']['DefaultTaxRate'] = 0;
		}

		if(isset($_POST['DefaultTaxRateName'])) {
			$GLOBALS['ISC_NEW_CFG']['DefaultTaxRateName'] = $_POST['DefaultTaxRateName'];
		}
		else {
			$GLOBALS['ISC_NEW_CFG']['DefaultTaxRateName'] = '';
		}

		if(isset($_POST['DefaultTaxRateBasedOn'])) {
			$GLOBALS['ISC_NEW_CFG']['DefaultTaxRateBasedOn'] = $_POST['DefaultTaxRateBasedOn'];
		}
		else {
			$GLOBALS['ISC_NEW_CFG']['DefaultTaxRateBasedOn'] = '';
		}

		// Only update the product prices if the tax settings have chaned
		if(GetConfig('TaxTypeSelected') != $_POST['TaxType'] || GetConfig('PricesIncludeTax') != $GLOBALS['ISC_NEW_CFG']['PricesIncludeTax']) {
			$updatePrices = true;
		}
		else {
			$updatePrices = false;
		}

		$GLOBALS['ISC_NEW_CFG']['TaxTypeSelected'] = (int)$_POST['TaxType'];

		// Delete any country/state tax rates if TaxTypeSelected != 1
		if($GLOBALS['ISC_NEW_CFG']['TaxTypeSelected'] != 1) {
			$query = "delete from [|PREFIX|]tax_rates";
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}

		// Set the default tax rate to 0 if we're using country/state tax rates
		if ($GLOBALS['ISC_NEW_CFG']['TaxTypeSelected'] != 2) {
			$GLOBALS['ISC_NEW_CFG']['DefaultTaxRate'] = 0;
			$GLOBALS['ISC_NEW_CFG']['DefaultTaxRateName'] = '';
		}

		// Let the app know we've saved tax settings (so home page can switch to quick links)
		$GLOBALS['ISC_NEW_CFG']['TaxConfigured'] = 1;
		$messages = array();

		$settings = GetClass('ISC_ADMIN_SETTINGS');
		if ($settings->CommitSettings($messages)) {
			// Update the tax rate for all products in the store
			if($updatePrices) {
				$settings->_UpdateProductPrices();
			}

			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
			if($GLOBALS['ISC_NEW_CFG']['TaxTypeSelected'] == 1) {
				FlashMessage(GetLang('SettingsSavedSuccessfullyNewTaxStyle'), MSG_SUCCESS, 'index.php?ToDo=viewTaxSettings');
			} else {
				FlashMessage(GetLang('SettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewTaxSettings');
			}
		} else {
			FlashMessage(GetLang('SettingsNotSaved'), MSG_ERROR, 'index.php?ToDo=viewTaxSettings');
		}
	}

	/**
	 * Delete one or more selected tax rates from the store.
	 */
	private function DeleteTaxRates()
	{
		if (isset($_POST['taxrates'])) {
			$taxids = implode(',', array_map('intval', $_POST['taxrates']));
			// Delete the tax rates
			$query = sprintf("delete from [|PREFIX|]tax_rates where taxrateid in (%s)", $taxids);
			$GLOBALS['ISC_CLASS_DB']->Query($query);
			$err = $GLOBALS['ISC_CLASS_DB']->Error();

			if ($err != "") {
				FlashMessage($err, MSG_ERROR, 'index.php?ToDo=viewTaxSettings');
			} else {

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['taxrates']));

				$this->ManageTaxSettings();
			}
		}
		else {
			$this->ManageTaxSettings();
		}
	}

	/**
	 * Show the form to add a new tax rate to the store.
	 */
	private function AddTaxRate()
	{
		$GLOBALS['FormAction'] = "SettingsSaveNewTaxRate";
		$GLOBALS['TaxRateTitle'] = GetLang('AddTaxRate');
		$GLOBALS['CancelMessage'] = GetLang('CancelAddTaxRate');
		$GLOBALS['CountryList'] = GetCountryList(0, true, "AllCountries", 0, true);
		$GLOBALS['TaxEnabled'] = 'checked="checked"';
		$GLOBALS['BasedOnSubTotalAndShipping'] = 'selected="selected"';
		$GLOBALS['HideStateList'] = "none";

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("tax.form");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
	 * Fetch information about a new or updated tax rate from the POSTed form and return it.
	 *
	 * @return array An array of information about the tax rate.
	 */
	private function GetTaxRateDataFromPost()
	{
		$data = array();

		$fields = array(
			'taxratename',
			'taxratebasedon',
			'taxratecountry'
		);
		foreach($fields as $field) {
			if(isset($_POST[$field])) {
				$data[$field] = $_POST[$field];
			}
			else {
				$data[$field] = '';
			}
		}

		$data['taxratecountry'] = (int)$data['taxratecountry'];

		if (isset($_POST['taxratestates'])) {
			$data['taxratestates'] = $_POST['taxratestates'];
		} else {
			$data['taxratestates'] = array(0);
		}

		if(isset($_POST['taxratepercent'])) {
			$data['taxratepercent'] = $_POST['taxratepercent'];
		}
		else {
			$data['taxratepercent'] = 0;
		}

		if (isset($_POST['taxratestatus'])) {
			$data['taxratestatus'] = 1;
		} else {
			$data['taxratestatus'] = 0;
		}

		if($_POST['taxaddress'] == 'shipping') {
			$data['taxaddress'] = 'shipping';
		}
		else {
			$data['taxaddress'] = 'billing';
		}

		if (isset($_POST['taxrateid'])) {
			$data['taxrateid'] = (int)$_POST['taxrateid'];
		}

		// Did the user choose "All States" and other states?
		// If so just make the selection all states
		if (in_array(0, $data['taxratestates'])) {
			$data['taxratestates'] = array(0);
		}

		$data['taxratestates'] = implode(",", $data['taxratestates']);
		$data['taxratestates'] = sprintf(",%s,", $data['taxratestates']);

		return $data;
	}

	/**
	 * Save a new tax rate in the database.
	 */
	private function SaveNewTaxRate()
	{
		$data = $this->GetTaxRateDataFromPost();

		// Is there already a tax rate setup for the selected country and state(s)?
		if (!$this->TaxRateSetupFor($data['taxratecountry'], $data['taxratestates'])) {
			$newTaxRate = array(
				"taxratename" => $data['taxratename'],
				"taxratepercent" => DefaultPriceFormat($data['taxratepercent']),
				"taxratecountry" => $data['taxratecountry'],
				"taxratestates" => $data['taxratestates'],
				"taxratebasedon" => $data['taxratebasedon'],
				"taxratestatus" => $data['taxratestatus'],
				'taxaddress' => $data['taxaddress']
			);
			$GLOBALS['ISC_CLASS_DB']->InsertQuery("tax_rates", $newTaxRate);
			if ($GLOBALS['ISC_CLASS_DB']->Error() == "") {

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($GLOBALS['ISC_CLASS_DB']->LastId(), $data['taxratename']);

				$this->ManageTaxSettings(array(GetLang('TaxRateAddedSuccessfully') => MSG_SUCCESS));
			}
			else {
				$this->ManageTaxSettings(array(sprintf(GetLang('TaxRateNotAdded'), $GLOBALS['ISC_CLASS_DB']->Error()) => MSG_ERROR));
			}
		}
		else {
			// There's already a tax rate setup for this country and state(s)
			$this->ManageTaxSettings(array(GetLang('TaxRateAlreadySetup') => MSG_ERROR));
		}
	}

	/**
	 * Check if a tax rate has been set up for a particular country and any states.
	 *
	 * @param int The country ID to check if a tax rate has been set up for.
	 * @param string a CSV list of any states to also check.
	 * @return boolean True if a tax rate is already set up, false if not.
	 */
	private function TaxRateSetupFor($country, $states)
	{
		$country = (int)$country;
		$states = implode(',', array_map('intval', explode(',', $states)));
		$query = sprintf("select count(taxrateid) as num from [|PREFIX|]tax_rates where taxratecountry='%s' and taxratestates='%s'", $country, $states);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

		if ($row['num'] == 0) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Show the form to update an existing tax rate.
	 */
	private function EditTaxRate()
	{
		$GLOBALS['FormAction'] = "SettingsSaveUpdatedTaxRate";
		$GLOBALS['TaxRateTitle'] = GetLang('EditTaxRate');
		$GLOBALS['CancelMessage'] = GetLang('CancelAddTaxRate');

		if (isset($_GET['taxRateId'])) {
			$taxRateId = (int)$_GET['taxRateId'];
			$query = sprintf("select * from [|PREFIX|]tax_rates where taxrateid='%d'", $taxRateId);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			$GLOBALS['hiddenFields'] = sprintf("<input type='hidden' name='taxrateid' value='%d' />", $taxRateId);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$GLOBALS['TaxRateName'] = isc_html_escape($row['taxratename']);

				if ($row['taxratebasedon'] == "subtotal") {
					$GLOBALS['BasedOnSubTotal'] = 'selected="selected"';
				} else {
					$GLOBALS['BasedOnSubTotalAndShipping'] = 'selected="selected"';
				}

				if($row['taxaddress'] == 'shipping') {
					$GLOBALS['TaxAddressShipping'] = 'selected="selected"';
				}
				else {
					$GLOBALS['TaxAddressBilling'] = 'selected="selected"';
				}

				$GLOBALS['CountryList'] = GetCountryList($row['taxratecountry'], true, "AllCountries", 0, true);
				$row['taxratestates'] = trim($row['taxratestates'], ',');
				if ($row['taxratestates'] == "0") {
					$sel_first = true;
				} else {
					$sel_first = false;
				}

				// If there's at least one state for this country in the database, show the list
				if (GetNumStatesInCountry($row['taxratecountry']) > 0) {
					$GLOBALS['StateList'] = GetStateListAsOptions($row['taxratecountry'], explode(",", $row['taxratestates']), true, "AllStates", "0", $sel_first);
				}
				else {
					$GLOBALS['HideStateList'] = "none";
				}

				if ($row['taxratestatus'] == 1) {
					$GLOBALS['TaxEnabled'] = 'checked="checked"';
				}

				$GLOBALS['TaxRatePercent'] = FormatPrice($row['taxratepercent'], false, false);

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("tax.form");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
			else {
				$this->ManageTaxSettings();
			}
		}
		else {
			$this->ManageTaxSettings();
		}
	}

	/**
	 * Save an updated tax rate in the database.
	 */
	private function SaveUpdatedTaxRate()
	{
		$data = $this->GetTaxRateDataFromPost();
		$updatedRate = array(
			"taxratename" => $data['taxratename'],
			"taxratepercent" => DefaultPriceFormat($data['taxratepercent']),
			"taxratecountry" => $data['taxratecountry'],
			"taxratestates" => $data['taxratestates'],
			"taxratebasedon" => $data['taxratebasedon'],
			"taxratestatus" => (int)$data['taxratestatus'],
			'taxaddress' => $data['taxaddress']
		);
		$GLOBALS['ISC_CLASS_DB']->UpdateQuery("tax_rates", $updatedRate, "taxrateid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$data['taxrateid'])."'");

		if ($GLOBALS['ISC_CLASS_DB']->Error() == "") {
			$this->ManageTaxSettings(array(GetLang('TaxRateUpdatedSuccessfully') => MSG_SUCCESS));

			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($data['taxrateid'], $data['taxratename']);
		}
		else {
			$this->ManageTaxSettings(array(sprintf(GetLang('TaxRateNotUpdated'), $GLOBALS['ISC_CLASS_DB']->Error()) => MSG_ERROR));
		}
	}
}

?>