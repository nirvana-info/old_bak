<?php
class ISC_CHECKOUTNEWADDRESSFORM_PANEL extends PANEL
{
	public function SetPanelSettings()
	{
		$selectedCountry = GetConfig('CompanyCountry');
		$selectedState = 0;

		if(isset($GLOBALS['SavedAddress']) && is_array($GLOBALS['SavedAddress'])) {
			$address = $GLOBALS['SavedAddress'];
			$selectedCountry = $address['shipcountry'];
			$addressVars = array(
				'account_email' => 'AccountEmail',
				'shipfirstname' => 'AddressFirstName',
				'shiplastname' => 'AddressLastName',
				'shipcompany' => 'AddressCompany',
				'shipaddress1' => 'AddressLine1',
				'shipaddress2' => 'AddressLine2',
				'shipcity' => 'AddressCity',
				'shipstate' => 'AddressState',
				'shipzip' => 'AddressZip',
				'shipphone' => 'AddressPhone'
			);
			if(isset($address['shipstateid'])) {
				$selectedState = $address['shipstateid'];
			}
			foreach($addressVars as $addressField => $formField) {
				if(isset($address[$addressField])) {
					$GLOBALS[$formField] = isc_html_escape($address[$addressField]);
				}
			}
		}

		$country_id = GetCountryIdByName($selectedCountry);
		$GLOBALS['CountryList'] = GetCountryList(GetConfig('CompanyCountry'), true);
		$GLOBALS['StateList'] = GetStateListAsOptions($country_id, $selectedState);

		// If there are no states for the country then
		// hide the dropdown and show the textbox instead
		if (GetNumStatesInCountry($country_id) == 0) {
			$GLOBALS['HideStateList'] = "none";
		}
		else {
			$GLOBALS['HideStateBox'] = "none";
		}
	}
}
?>