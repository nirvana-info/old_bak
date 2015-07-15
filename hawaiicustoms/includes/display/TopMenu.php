<?php

CLASS ISC_TOPMENU_PANEL extends PANEL
{
	public function SetPanelSettings()
	{
		// Are gift certificates enabled? If so, we need to show the gift certificates link
		if(gzte11(ISC_LARGEPRINT) && GetConfig('EnableGiftCertificates') != 0) {
			$GLOBALS['SNIPPETS']['TopMenuGiftCertificates'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("TopMenuGiftCertificates");
		}
		// Show the login/logout link as required
		if(!isset($GLOBALS['LoginOrLogoutText'])) {
			if(CustomerIsSignedIn()) {

				// If they're a customer, set their name so it's available in the templates
				$c = GetClass('ISC_CUSTOMER');
				$customerData = $c->GetCustomerDataByToken();
				$GLOBALS['CurrentCustomerFirstName'] = isc_html_escape($customerData['custconfirstname']);
				$GLOBALS['CurrentCustomerLastName'] = isc_html_escape($customerData['custconlastname']);
				$GLOBALS['CurrentCustomerEmail'] = isc_html_escape($customerData['custconemail']);

				$GLOBALS['LoginOrLogoutLink'] = "login.php?action=logout";
				$GLOBALS['LoginOrLogoutText'] = sprintf(GetLang('LogoutLink'), $GLOBALS['ShopPathNormal']);
			}
			else {
				// If they're a guest, set their name to 'Guest'
				$GLOBALS['CurrentCustomerFirstName'] = GetLang('Guest');
				$GLOBALS['CurrentCustomerLastName'] = $GLOBALS['CurrentCustomerEmail'] = '';

				$GLOBALS['LoginOrLogoutLink'] = "login.php";
				$GLOBALS['LoginOrLogoutText'] = sprintf(GetLang('SignInOrCreateAccount'), $GLOBALS['ShopPath'], $GLOBALS['ShopPath']);
			}
		}

		// Display our currency flags. Has been disabled for the time being. Theory being that this will include the whole locale (text aswell)
		$GLOBALS['CurrencyFlags'] = "";

		/*
		$GLOBALS['CurrencyFlags'] = "";

		$query = "
			SELECT cu.currencyid, cu.currencyname, co.countryname, co.countryiso2 AS countryflagname
			FROM [|PREFIX|]currencies cu
			JOIN [|PREFIX|]countries co ON cu.currencycountryid = co.countryid
			WHERE cu.currencystatus = 1
			ORDER BY currencyname ASC
			";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$total  = $GLOBALS['ISC_CLASS_DB']->CountResult($result);

		if ($total <= 1) {
			$GLOBALS['HideCurrencyFlags'] = "none";
		}
		else {
			$currenciesDone = 0;
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				++$currenciesDone;
				if (!file_exists(ISC_BASE_PATH . "/lib/flags/" . strtolower($row['countryflagname']) . ".gif")) {
					continue;
				}
				$GLOBALS["CurrencyID"] = $row['currencyid'];
				$GLOBALS['CurrencyFlagURL'] = GetConfig("ShopPath") . '/lib/flags/' . strtolower($row['countryflagname']) . '.gif';
				$GLOBALS["CurrencyName"] = isc_html_escape($row['currencyname']);

				if($row['currencyid'] == $GLOBALS['CurrentCurrency'] && $currenciesDone == $total) {
					$GLOBALS['CurrencyClass'] = ' class="Selected Last"';
				}
				else if($row['currencyid'] == $GLOBALS['CurrentCurrency']) {
					$GLOBALS['CurrencyClass'] = ' class="Selected"';
				}
				else if ($currenciesDone == $total) {
					$GLOBALS['CurrencyClass'] = ' class="Last"';
				}
				else {
					$GLOBALS['CurrencyClass'] = '';
				}
				$currencyFlag = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("HomeCurrencyFlags");
				if($row['currencyid'] == $GLOBALS['CurrentCurrency']) {
					$GLOBALS['CurrencyFlags'] = $currencyFlag . $GLOBALS['CurrencyFlags'];
				}
				else {
					$GLOBALS['CurrencyFlags'] .= $currencyFlag;
				}
			}
		}
		*/
	}
}

?>
