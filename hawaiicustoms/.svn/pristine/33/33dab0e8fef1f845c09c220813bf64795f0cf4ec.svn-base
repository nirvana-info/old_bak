<?php

	CLASS ISC_SIDECARTMINICART_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{
			// Setup the cart values
			$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
			$GLOBALS['ISC_CLASS_CART']->SetCartValues();

			$GLOBALS['SNIPPETS']['MiniCartProductAdded'] = "";
			$GLOBALS['SNIPPETS']['MiniCartOtherProduct'] = "";

			foreach (GetAvailableModules('checkout', true, true) as $module) {
				if ($module['object']->disableNonCartCheckoutButtons) {
					$GLOBALS['HideCheckoutButton'] = 'none';
					break;
				}
			}


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
			$count = 0;
			$subtotal = 0;

			// Get a list of all products in the cart
			$product_array = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart();
			foreach($product_array as $itemId => $product) {

				$GLOBALS['ProductName'] = isc_html_escape($product['product_name']);

				// Is this product a variation?
				$GLOBALS['ProductOptions'] = '';
				if(isset($product['options']) && !empty($product['options'])) {
					$GLOBALS['ProductOptions'] .= "<small class='CartProductOptionList'>(";
					$comma = '';
					foreach($product['options'] as $name => $value) {
						if(!trim($name) || !trim($value)) {
							continue;
						}
						$GLOBALS['ProductOptions'] .= $comma.isc_html_escape($name).": ".isc_html_escape($value);
						$comma = ', ';
					}
					$GLOBALS['ProductOptions'] .= ")</small>";
				}

				$GLOBALS['ProductLink'] = '';
				if(!isset($product['type']) || $product['type'] != "giftcertificate") {
					$GLOBALS['ProductImage'] = ImageThumb($product['data']['imagefile'], ProdLink($product['data']['prodname']));
				}

				$GLOBALS['ProductLink'] = ProdLink($product['data']['prodname']);

				$GLOBALS['ProductQuantity'] = $product['quantity'];

				if(isset($product['discount_price'])) {
					$GLOBALS['ProductPrice'] = CurrencyConvertFormatPrice($product['discount_price']);
					$price = $product['discount_price'];
				}
				else if(isset($product['type']) && $product['type'] == "giftcertificate") {
					$GLOBALS['ProductPrice'] = CurrencyConvertFormatPrice($product['giftamount']);
					$price = $product['giftamount'];
				}
				else {
					$GLOBALS['ProductPrice'] = CurrencyConvertFormatPrice($product['product_price']);
					$price = $product['product_price'];
				}

				// Update the subtotal
				$subtotal += ((int)$product['quantity'] * $price);

				if($GLOBALS['ISC_CLASS_CART']->newCartItem == $itemId) {
					$GLOBALS['SNIPPETS']['MiniCartProductAdded'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("MiniCartProductAdded");
				}
				else {
					$GLOBALS['SNIPPETS']['MiniCartOtherProduct'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("MiniCartOtherProduct");
				}
			}

			$GLOBALS['CartSubTotal'] = CurrencyConvertFormatPrice($GLOBALS['CartSubTotal']);

			// Should we hide extra info on the mini cart panel?
			if($GLOBALS['ISC_CLASS_CART']->api->GetNumProductsInCart() < 2) {
				$GLOBALS['HideExtraMiniCartInfo'] = "none";
			}

		}
	}

?>
