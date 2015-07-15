<?php

CLASS ISC_SIDECARTCONTENTS_PANEL extends PANEL
{
	public function SetPanelSettings()
	{
		// Setup the cart values

		$total = $count = 0;
		$GLOBALS['SNIPPETS']['SideCartItems'] = '';

		if(!isset($_SESSION['CART']['ITEMS']) || empty($_SESSION['CART']['ITEMS'])) {
			$this->DontDisplay = true;
			return;
		}

		if (isset($_SESSION['CART']['ITEMS'])) {
			foreach ($_SESSION['CART']['ITEMS'] as $item) {
				$total += ($item['product_price'] * $item['quantity']);
				$count += $item['quantity'];
				if(!isset($item['type']) || $item['type'] != "giftcertificate") {
					$GLOBALS['ProductName'] = "<a href=\"".ProdLink($item['product_name'])."\">".isc_html_escape($item['product_name'])."</a>";
				}
				else {
					$GLOBALS['ProductName'] = isc_html_escape($item['product_name']);
				}

				// Is this product a variation?
				$GLOBALS['ProductOptions'] = '';
				if(isset($item['options']) && !empty($item['options'])) {
					$GLOBALS['ProductOptions'] .= "<br /><small>(";
					$comma = '';
					foreach($item['options'] as $name => $value) {
						if(!trim($name) || !trim($value)) {
							continue;
						}
						$GLOBALS['ProductOptions'] .= $comma.isc_html_escape($name).": ".isc_html_escape($value);
						$comma = ', ';
					}
					$GLOBALS['ProductOptions'] .= ")</small>";
				}

				$GLOBALS['ProductPrice'] = CurrencyConvertFormatPrice(($item['product_price'] * $item['quantity']));
				$GLOBALS['ProductQuantity'] = $item['quantity'];

				$GLOBALS['SNIPPETS']['SideCartItems'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCartItem");
			}

		}

		if ($count == 1) {
			$GLOBALS['SideCartItemCount'] = GetLang('SideCartYouHave1Item');
		} else {
			$GLOBALS['SideCartItemCount'] = sprintf(GetLang('SideCartYouHaveXItems'), $count);
		}
		$GLOBALS['ISC_LANG']['SideCartTotalCost'] = sprintf(GetLang('SideCartTotalCost'), CurrencyConvertFormatPrice($total));

		// Go through all the checkout modules looking for one with a GetSidePanelCheckoutButton function defined
		$GLOBALS['AdditionalCheckoutButtons'] = '';
		$HideCheckout = false;
		foreach (GetAvailableModules('checkout', true, true) as $module) {
			if (method_exists($module['object'], 'GetSidePanelCheckoutButton')) {
				$GLOBALS['AdditionalCheckoutButtons'] .= $module['object']->GetSidePanelCheckoutButton();
			}

			if ($module['object']->disableNonCartCheckoutButtons) {
				$HideCheckout = true;
			}

		}

		if ($HideCheckout) {
			$GLOBALS['SNIPPETS']['SideCartContentsCheckoutLink'] = '';
		} else {
			$GLOBALS['SNIPPETS']['SideCartContentsCheckoutLink'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('SideCartContentsCheckoutLink');
		}

	}
}

?>