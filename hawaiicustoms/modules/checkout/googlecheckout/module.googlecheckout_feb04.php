<?php
	class CHECKOUT_GOOGLECHECKOUT extends ISC_CHECKOUT_PROVIDER
	{
		/**
		* @var object The google cart object
		*/
		public $cart = null;

		/**
		 * @var boolean Disable the checkout links/buttons everywhere except on the main cart page
		 */
		public $disableNonCartCheckoutButtons = true;

		/**
		* @var boolean Don't show google checkout on the confirm page
		*/
		public $showOnConfirmPage = false;

		// Only USD and GBP default currencies are supported by Google
		public $supportedCurrencies = array('USD', 'GBP');

		/**
		 * The url to the xml processing api php file
		 *
		 * @var string
		 **/
		public $xmlUrl = '';

		private $defaultZoneGFilter = null;

		/**
		 * Checkout class constructor. Does the setup of some member variables.
		 *
		 * @return void
		 */
		public function __construct()
		{
			// Setup the required variables for the PayPal checkout module
			parent::__construct();

			$this->xmlUrl = $GLOBALS['ShopPathSSL'].'/modules/checkout/googlecheckout/xml.php';

			$this->_name = GetLang('GoogleCheckoutName');
			$this->_image = "google_checkout.gif";
			$this->_description = GetLang('GoogleCheckoutDesc');
			$this->_help = sprintf(GetLang('GoogleCheckoutHelp'), $this->xmlUrl);
			$this->_height = 0;

			if ($this->GetValue('testmode') === 'YES') {
				$this->_server_type = 'sandbox';
			} else {
				$this->_server_type = 'production';
			}

			if (GetConfig('TaxTypeSelected') == 1 && GetConfig('PricesIncludeTax') == 1) {
				$this->_help .= MessageBox(GetLang('GoogleCheckoutTaxWarning'), MSG_ERROR);
			}

			require_once(dirname(__FILE__).'/library/googlerequest.php');
			$this->request = new GoogleRequest($this->GetValue('merchantid'), $this->GetValue('merchanttoken'), $this->_server_type, $this->GetDefaultCurrencyCode());

			include_once(dirname(__FILE__).'/library/googleshipping.php');
			$this->defaultZoneGFilter = new GoogleShippingFilters();
			$this->defaultZoneGFilter->SetAllowedWorldArea(true);
		}

		/*
		 * Check if this checkout module can be enabled or not.
		 *
		 * @return boolean True if this module is supported on this install, false if not.
		 */
		public function IsSupported()
		{
			if (!in_array($this->GetDefaultCurrencyCode(), $this->supportedCurrencies)) {
				$this->SetError(GetLang('GoogleCheckoutSupportedCurrenciesError'));
			}

			// Return true if there are no errors
			if(!$this->HasErrors()) {
				return true;
			}
			else {
				return false;
			}
		}

		/**
		 * Get the currency code of the default currency for the store
		 *
		 * @return void
		 **/
		public function GetDefaultCurrencyCode()
		{
			static $code = '';

			if ($code != '') {
				return $code;
			}

			$defaultCurrency = GetDefaultCurrency();
			$code = $defaultCurrency['currencycode'];
			return $code;
		}

		/**
		 * Setup the module specific variables to show on the settings for this module
		 *
		 * @return void
		 **/
		public function SetCustomVars()
		{
			$this->_variables['merchantid'] = array (
				"name" => GetLang('GoogleCheckoutMerchantId'),
				"type" => "textbox",
				"help" => GetLang('GoogleCheckoutMerchantIdHelp'),
				"default" => "",
				"required" => true
			);

			$this->_variables['merchanttoken'] = array (
				"name" => GetLang('GoogleCheckoutMerchantToken'),
				"type" => "textbox",
				"help" => GetLang('GoogleCheckoutMerchantTokenHelp'),
				"default" => "",
				"required" => true
			);

			$this->_variables['testmode'] = array (
				"name" => GetLang('GoogleCheckoutTestMode'),
				"type" => "dropdown",
				"help" => GetLang("GoogleCheckoutTestModeHelp"),
				"default" => "NO",
				"required" => true,
				"options" => array(
					GetLang("GoogleCheckoutTestModeYes") => "YES",
					GetLang("GoogleCheckoutTestModeNo") => "NO",
				),
				"multiselect" => false
			);
			$this->_variables['fallbackshippingcost'] = array (
				"name" => GetLang('GoogleCheckoutFallbackShippingCost'),
				"type" => "textbox",
				"help" => GetLang("GoogleCheckoutFallbackShippingCostHelp"),
				"default" => "0",
				"required" => true,
			);

			$this->_variables['autoapproveprotected'] = array (
				"name" => GetLang('GoogleCheckoutAutoApproveProtected'),
				"type" => "dropdown",
				"help" => GetLang("GoogleCheckoutAutoApproveProtectedHelp"),
				"default" => "NO",
				"required" => true,
				"options" => array(
					GetLang("GoogleCheckoutAutoApproveProtectedYes") => "YES",
					GetLang("GoogleCheckoutAutoApproveProtectedNo") => "NO",
				),
				"multiselect" => false
			);

			$this->_variables['orderchargestatus'] = array(
				'name' => GetLang('GoogleCheckoutOrderStatusOnCharge'),
				'type' => 'dropdown',
				'help' => GetLang('GoogleCheckoutOrderStatusOnChargeHelp'),
				'default' => ORDER_STATUS_AWAITING_FULFILLMENT,
				'required' => true,
				'options' => array(
				),
				'multiselect' => false
			);

			$query = "
				SELECT *
				FROM [|PREFIX|]order_status
				WHERE statusid IN (".ORDER_STATUS_AWAITING_FULFILLMENT.",".ORDER_STATUS_AWAITING_SHIPMENT.",".ORDER_STATUS_COMPLETED.")
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($status = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$this->_variables['orderchargestatus']['options'][$status['statusdesc']] = $status['statusid'];
			}
		}

		/**
		 * Returns the checkout button for this specific module. Google checkout requires that a
		 * seperate button be used for checking out using them
		 *
		 * @return string The html to show for the button
		 **/
		public function GetCheckoutButton()
		{
			$this->BuildCart();

			$ShowNormalCheckoutButton = false;
			foreach (GetAvailableModules('checkout', true, true) as $module) {
				if (!method_exists($module['object'], 'GetCheckoutButton')) {
					$ShowNormalCheckoutButton = true;
					break;
				}
			}

			if ($ShowNormalCheckoutButton) {
				$GLOBALS['GoogleCheckoutOrUse'] = GetLang('GoogleCheckoutOrUse');
			} else {
				$GLOBALS['GoogleCheckoutOrUse'] = '';
			}

			$GLOBALS['GoogleCheckoutButton'] = $this->cart->CheckoutButtonCode('large', true, 'en_US', false, 'white');

			return $this->ParseTemplate('googlecheckout.button', true);
		}

		/**
		 * Build the representation of the shopping cart using the google checkout objects
		 *
		 * @return void
		 **/
		private function BuildCart()
		{
			if ($this->cart === null) {
				include_once(dirname(__FILE__).'/library/googlecart.php');
				include_once(dirname(__FILE__).'/library/googleitem.php');

				$id = $this->GetValue('merchantid');
				$key =$this->GetValue('merchanttoken');

				$currency = $this->GetDefaultCurrencyCode();

				$this->cart = new GoogleCart($id, $key, $this->_server_type, $currency);
				$this->cart->SetMerchantPrivateData($_COOKIE['SHOP_SESSION_TOKEN']);
				$this->cart->SetEditCartUrl($GLOBALS['ShopPathSSL'].'/cart.php');
				$this->cart->SetContinueShoppingUrl($GLOBALS['ShopPath']);
				$this->cart->SetRequestBuyerPhone('true');

				// Add tax rules
				$this->AddTaxInformationToCart();

				// Add the analytics tracking to the cart
				$this->AddAnalyticsToCart();

				// Merchant calculations are only available for US based stores
				if ($this->GetDefaultCurrencyCode() == 'USD') {
					$this->cart->SetMerchantCalculations($this->xmlUrl, "true", "true", "true");
				} else {
					$this->cart->SetMerchantCalculations($this->xmlUrl, "false", "false", "false");
				}

				$coupon_discount = 0;
				$items_total = 0;

				$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
				$items = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart();

				foreach ($items as $item) {
					$item_price = $item['product_price'];

					if(GetConfig('TaxTypeSelected') == 2) {
						// The product price is already 100% + tax rate, so we need to get it back to what
						// it was before tax was applied
						$item_price = ($item_price / (100 + GetConfig('DefaultTaxRate'))) * 100;
					}

					if (isset($item['discount_price'])) {
						$coupon_discount += ($item['product_price'] - $item['discount_price']);
					}

					$items_total += $item_price * $item['quantity'];

					// Gift certificates won't have a weight set
					if (!isset($item['data']['prodweight'])) {
						$item['data']['prodweight'] = 0;
					}

					// Build a description using the product variation data
					$description = "";
					if (isset($item['options']) && !empty($item['options'])) {
						foreach ($item['options'] as $name => $value) {
							if ($description != "") {
								$description .= ", ";
							}

							$description .= $name . ": " . $value;
						}
					}

					$google_item = new GoogleItem($item['product_name'], $description, $item['quantity'], $item_price, $item['data']['prodweight']);

					if ($item['data']['prodtype'] == PT_DIGITAL || $item['data']['prodtype'] == PT_GIFTCERTIFICATE) {
						$google_item->SetEmailDigitalDelivery(true);
					}

					$this->cart->AddItem($google_item);

					// does this item have gift wrapping?
					if (isset($item['wrapping'])) {
						$wrapping = $item['wrapping'];
						$wrap_price = $wrapping['wrapprice'];

						if(GetConfig('TaxTypeSelected') == 2) {
							// The product price is already 100% + tax rate, so we need to get it back to what
							// it was before tax was applied
							$wrap_price = ($wrap_price / (100 + GetConfig('DefaultTaxRate'))) * 100;
						}

						$google_item = new GoogleItem("Gift Wrapping: " . $wrapping['wrapname'], $wrapping['wrapmessage'], $item['quantity'], $wrap_price);
						$this->cart->AddItem($google_item);
					}

				}

				if (isset($_SESSION['CART']['GIFTCERTIFICATES']) && is_array($_SESSION['CART']['GIFTCERTIFICATES'])) {
					foreach ($_SESSION['CART']['GIFTCERTIFICATES'] as $giftcert) {
						$giftcertname = GetLang('GiftCertificate').' ('.$giftcert['giftcertcode'].')';
						$google_item = new GoogleItem($giftcertname, '', 1, min($giftcert['giftcertbalance'], $items_total) * -1);
						$google_item->SetEmailDigitalDelivery(true);
						$this->cart->AddItem($google_item);
					}
				}


				if ($coupon_discount > 0) {
					$google_item = new GoogleItem(GetLang('GoogleCheckoutDiscountFromCoupons'), '', 1, $coupon_discount * -1);
					$google_item->SetEmailDigitalDelivery(true);
					$this->cart->AddItem($google_item);
				}


				$GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_CHECKOUT');
				$orderSummary = $GLOBALS['ISC_CLASS_CHECKOUT']->CalculateOrderSummary();

				// Add shipping information
				if ($orderSummary['digitalOrder'] == 0) {
					$this->AddShippingInformationToCart();
				} else {
					$this->AddDigitalShippingInformationToCart();
				}

				$this->DebugLog($this->cart->GetXML());
			}
		}

		/**
		 * If the google analytics module is configured, add the tracking code to the checkout xml request
		 *
		 * @return void
		 **/
		private function AddAnalyticsToCart()
		{
			$module = null;
			GetModuleById('analytics', $module, 'analytics_googleanalytics');

			if ($module !== null) {
				$tracking_code = $module->GetValue('trackingcode');
				$account_id = '';

				if (strpos($tracking_code, 'pageTracker')) {
					preg_match('#_getTracker\("([^"]+)"\);#', $tracking_code, $matches);
					if (isset($matches[1])) {
						$account_id = $matches[1];
					}
				} elseif (strpos($tracking_code, 'urchin')) {
					preg_match('#_uacct\s+=\s+"([^"]+)";#', $tracking_code, $matches);
					if (isset($matches[1])) {
						$account_id = $matches[1];
					}
				}

				if ($account_id != '') {
					$this->cart->AddGoogleAnalyticsTracking($account_id);
				}
			}
		}

		/**
		 * Add the taxation information to the google object representation of the customers cart
		 *
		 * @return void
		 **/
		private function AddTaxInformationToCart()
		{
			if (!GetConfig('TaxConfigured')) {
				$GLOBALS['ISC_CLASS_LOG']->LogSystemDebug(array('payment', $this->GetName()), "Tax isn't configured at line: ".__LINE__);
				return;
			}

			switch (GetConfig('TaxTypeSelected')) {
				case 2:
				{
					// Avoid divide by 0 errors
					if (GetConfig('DefaultTaxRate') == 0) {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemDebug(array('payment', $this->GetName()), "Tax isn't configured at line: ".__LINE__);
						return;
					}

					// Flat rate taxing
					if (GetConfig('DefaultTaxRateBasedOn') == 'subtotal') {
						$shipping_taxed = 'false';
					} else {
						$shipping_taxed = 'true';
					}

					include_once(dirname(__FILE__).'/library/googletax.php');
					$tax_rule = new GoogleDefaultTaxRule(GetConfig('DefaultTaxRate') / 100, $shipping_taxed);
					$tax_rule->SetWorldArea(true);
					$this->cart->AddDefaultTaxRules($tax_rule);
					break;
				}
				case 1:
				{
					if (GetConfig('PricesIncludeTax') == 1) {
						return;
					}

					$query = "SELECT *
					FROM [|PREFIX|]tax_rates
					WHERE taxratestatus=1";
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

					while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						// Flat rate taxing
						if ($row['taxratebasedon'] == 'subtotal') {
							$shipping_taxed = 'false';
						} else {
							$shipping_taxed = 'true';
						}

						include_once(dirname(__FILE__).'/library/googletax.php');
						$tax_rule = new GoogleDefaultTaxRule($row['taxratepercent'] / 100, $shipping_taxed);

						if ($row['taxratecountry'] == 0) {
							$tax_rule->SetWorldArea();
							$this->cart->AddDefaultTaxRules($tax_rule);
							continue;
						}

						$country = GetCountryISO2ById($row['taxratecountry']);

						$query = sprintf("SELECT taxratestates FROM [|PREFIX|]tax_rates WHERE taxratecountry='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($row['taxratecountry']));
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

						$states = array();

						while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

							$state = $row['taxratestates'];
							$stateIds = explode(",", $state);

							foreach ($stateIds as $id) {

								if (!empty($id)) {
									$state = GetStateInfoById($id);
									$states[] = $state['stateabbrv'];
								}
							}
						}

						if (empty($states)) {
							$tax_rule->AddPostalArea($country);
						} else {
							$tax_rule->SetStateAreas($states);
						}

						$this->cart->AddDefaultTaxRules($tax_rule);
					}
				}
			}
		}

		/**
		 * Add the digital only order specific shipping information to the google
		 * object representation of the customers cart.
		 *
		 * @return void
		 **/
		private function AddDigitalShippingInformationToCart()
		{
			$ship = new GoogleFlatRateShipping('DigitalShip', 0);

			$Gfilter = new GoogleShippingFilters();

			$Gfilter->SetAllowedWorldArea(true);

			// Shipping restrictions are used if the merchant callback calculation fails
			$ship->AddShippingRestrictions($Gfilter);

			$this->cart->AddShipping($ship);
		}

		/**
		 * Add the shipping information to the google object representation of the customers cart.
		 *
		 * @return void
		 **/
		private function AddShippingInformationToCart()
		{
			$shippingZones = GetShippingZoneInfo();

			$defaultZone = null;
			$coveredLocations = array();

			$defaultShippingMethods = array();

			// Do all the normal zones first (skip the default one)
			// this is so that we can work out where "everywhere else" equates to
			foreach ($shippingZones as $shippingZone) {
				// If the zone has no enabled methods
				if (!isset($shippingZone['methods'])) {
					continue;
				}

				// Skip the default zone for now
				if (!isset($shippingZone['locationtype'])) {
					continue;
				}

				foreach ($shippingZone['methods'] as $method) {
					$module = null;
					if (!GetModuleById('shipping', $module, $method['methodmodule'])) {
						continue;
					}

					if ($module === null) {
						continue;
					}

					$module->SetMethodId($method['methodid']);

					$deliveryMethods = $module->GetAvailableDeliveryMethods();

					foreach ($deliveryMethods as $deliveryMethod) {
						$shipping_name = $deliveryMethod. ' ('.$shippingZone['zonename'].')';

						// If it's a flat rate
						if ($module->_flatrate) {
							$defaultCost = $module->GetValue('defaultcost');
							if ($defaultCost === null) {
								$defaultCost = $this->GetValue('fallbackshippingcost');
							}
							$ship = new GoogleMerchantCalculatedShipping($shipping_name, $defaultCost);
						}
						// It's a dynamic one
						else {
							$ship = new GoogleMerchantCalculatedShipping($shipping_name, $this->GetValue('fallbackshippingcost'));
						}

						$ShippingRestrictions = $this->GetShippingRestrictions($shippingZone);
						$this->AddDefaultShippingRestrictions($shippingZone);

						if ($ShippingRestrictions !== false) {
							// Address filters are used when a customer goes to the google checkout page
							$ship->AddAddressFilters($ShippingRestrictions);

							// Shipping restrictions are used if the merchant callback calculation fails
							$ship->AddShippingRestrictions($ShippingRestrictions);
						}
						$this->cart->AddShipping($ship);
					}
				}
			}

			// Now add the methods for the default zone
			foreach ($shippingZones as $shippingZone) {
				// If the zone has no enabled methods
				if (!isset($shippingZone['methods'])) {
					continue;
				}

				// Skip any non-default zones now
				if (isset($shippingZone['locationtype'])) {
					continue;
				}

				foreach ($shippingZone['methods'] as $method) {

					$module = null;
					if (!GetModuleById('shipping', $module, $method['methodmodule'])) {
						continue;
					}

					if ($module === null) {
						continue;
					}

					$module->SetMethodId($method['methodid']);

					$deliveryMethods = $module->GetAvailableDeliveryMethods();

					foreach ($deliveryMethods as $deliveryMethod) {
						$shipping_name = $deliveryMethod;

						// If it's a flat rate
						if ($module->_flatrate) {
							$defaultCost = $module->GetValue('defaultcost');
							if ($defaultCost === null) {
								$defaultCost = $this->GetValue('fallbackshippingcost');
							}
							$ship = new GoogleMerchantCalculatedShipping($shipping_name, $defaultCost);
						}
						// It's a dynamic one
						else {
							$ship = new GoogleMerchantCalculatedShipping($shipping_name, $this->GetValue('fallbackshippingcost'));
						}

						if ($this->defaultZoneGFilter) {
							// Address filters are used when a customer goes to the google checkout page
							$ship->AddAddressFilters($this->defaultZoneGFilter);

							// Shipping restrictions are used if the merchant callback calculation fails
							$ship->AddShippingRestrictions($this->defaultZoneGFilter);
						}
						$this->cart->AddShipping($ship);
					}
				}
			}
		}

		/**
		 * Get the shipping restrictions in the google filter module format for a specific zone
		 * so we can add it as part of the shipping rules
		 *
		 * @return object
		 **/
		private function GetShippingRestrictions($zone)
		{
			$Gfilter = new GoogleShippingFilters();

			// Handle the default zone
			if (!isset($zone['locationtype'])) {
				$Gfilter->SetAllowedWorldArea(true);
				return $Gfilter;
			}

			switch ($zone['locationtype']) {
				case 'zip':
				{
					foreach ($zone['locations'] as $location) {

						$pos = strpos($location['locationvalue'], '?');

						if ($pos === false) {
							$Gfilter->AddAllowedZipPattern($location['locationvalue']);
						}
						else {

							$tmp = substr($location['locationvalue'], 0, $pos);
							$tmp .= '*';
							$Gfilter->AddAllowedZipPattern($tmp);
						}

					}
					break;
				}
				case 'state':
				{
					foreach ($zone['locations'] as $location) {
						$country = GetCountryISO2ById($location['locationcountryid']);
						$state = GetStateISO2ById($location['locationvalueid']);

						if (empty($state)) {
							$state = GetStateById($location['locationvalueid']);
						}

						if (empty($location['locationvalueid']) && $country == 'US') {
							// If they have selected all states in the us, handle it differently
							$Gfilter->SetAllowedCountryArea('ALL');
							continue;
						} elseif (empty($location['locationvalueid'])) {
							$Gfilter->AddAllowedPostalArea($country);
							continue;
						}

						if ($country == 'US' && $this->GetDefaultCurrencyCode() == 'USD') {
							$Gfilter->AddAllowedStateArea($state);
						} else {
							$Gfilter->AddAllowedPostalArea($country, $state);
						}
					}
					break;
				}
				case 'country':
				{
					foreach ($zone['locations'] as $location) {
						$Gfilter->AddAllowedPostalArea(GetCountryISO2ById($location['locationvalueid']));
					}
					break;
				}
			}

			return $Gfilter;
		}

		/**
		 * Set the shipping restrictions in the google filter module format for the default zone
		 * so we can add it as part of the shipping rules
		 *
		 * @return void
		 **/
		private function AddDefaultShippingRestrictions($zone)
		{

			switch ($zone['locationtype']) {
				case 'zip':
				{
					foreach ($zone['locations'] as $location) {
						$this->defaultZoneGFilter->AddExcludedPostalArea(GetCountryISO2ById($location['locationcountryid']));
					}
					return false;
					break;
				}
				case 'state':
				{
					foreach ($zone['locations'] as $location) {
						$country = GetCountryISO2ById($location['locationcountryid']);
						$state = GetStateISO2ById($location['locationvalueid']);

						if (empty($state)) {
							$state = GetStateById($location['locationvalueid']);
						}

						if (empty($location['locationvalueid']) && $country == 'US') {
							// If they have selected all states in the us, handle it differently
							$this->defaultZoneGFilter->SetExcludedCountryArea('ALL');
							break 2;
						} elseif (empty($location['locationvalueid'])) {
							continue;
						}

						if ($country == 'US' && $this->GetDefaultCurrencyCode() == 'USD') {
							$this->defaultZoneGFilter->AddExcludedStateArea($state);
						} else {
							$this->defaultZoneGFilter->AddExcludedPostalArea($country, $state);
						}
					}
					break;
				}
				case 'country':
				{
					foreach ($zone['locations'] as $location) {
						$this->defaultZoneGFilter->AddExcludedPostalArea(GetCountryISO2ById($location['locationvalueid']));
					}
					break;
				}
			}
		}

		/**
		 * Return the unique order token which was saved as a cookie pre-payment
		 *
		 * @return string The Cart Id
		 */
		public function GetOrderToken()
		{
			return $this->cartid;
		}

		/**
		 * Handle the status change of an order. This is used to send google notifications so that ISC and
		 * the Google control panel keep the order state at the same stage. It is also so that you can
		 * approve, ship etc orders from the ISC control panel.
		 *
		 * @param integer $orderid The ISC order id whose status is changing
		 * @param integer $oldstatus The status id the order is changing from. Order status are defined in lib/init.php.
		 * @param integer $newstatus The new status id the order is changing to.
		 * @param mixed $data Extra data associated with the status change
		 *
		 * @return void
		 **/
		public function HandleStatusChange($orderid, $oldstatus, $newstatus, $data = '')
		{
			$request_result = '';

			$query = "
				SELECT *
				FROM [|PREFIX|]orders
				WHERE orderpaymentmodule = '".$GLOBALS['ISC_CLASS_DB']->Quote($this->GetId())."'
				AND orderid = '".$GLOBALS['ISC_CLASS_DB']->Quote($orderid)."'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$order = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			switch ($newstatus) {
				case ORDER_STATUS_CANCELLED:
				{
					$request_result = $this->request->SendCancelOrder($order['ordpayproviderid'], GetLang('GoogleCheckoutOrderCancelledByVendor'), '');
					break;
				}
				case ORDER_STATUS_REFUNDED:
				{
					$request_result = $this->request->SendRefundOrder($order['ordpayproviderid'], $data, GetLang('GoogleCheckoutOrderRefundedByVendor'), 'def');
					break;
				}
				case ORDER_STATUS_AWAITING_FULFILLMENT:
				case ORDER_STATUS_AWAITING_SHIPMENT:
				case ORDER_STATUS_AWAITING_PICKUP:
				case ORDER_STATUS_SHIPPED:
				case ORDER_STATUS_COMPLETED:
				case ORDER_STATUS_PARTIALLY_SHIPPED:
				{
					switch ($oldstatus) {
						case ORDER_STATUS_AWAITING_PAYMENT:
						{
							$request_result = $this->request->SendChargeOrder($order['ordpayproviderid'], 0);
							break;
						}
					}
					if ($newstatus == ORDER_STATUS_COMPLETED) {
						$request_result = $this->request->SendDeliverOrder($order['ordpayproviderid']);
					}
					break;
				}
			}

			$GLOBALS['ISC_CLASS_LOG']->LogSystemDebug(array('payment', $this->GetName()), "Status change for #$orderid from ".GetOrderStatusById($oldstatus)." to ".GetOrderStatusById($newstatus));
		}

		/**
		 * Send google the new tracking number
		 *
		 * @param string $orderid
		 * @param string $trackingnum
		 *
		 * @return void
		 **/
		public function HandleUpdateTrackingNum($orderid, $trackingnum)
		{
			$query = "
				SELECT *
				FROM [|PREFIX|]orders
				WHERE orderpaymentmodule = '".$GLOBALS['ISC_CLASS_DB']->Quote($this->GetId())."'
				AND orderid = '".$GLOBALS['ISC_CLASS_DB']->Quote($orderid)."'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$order = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			$request_result = $this->request->SendTrackingData($order['ordpayproviderid'], $this->GetShippingProvider($order['ordershipmodule']), $trackingnum);

			$GLOBALS['ISC_CLASS_LOG']->LogSystemDebug(array('payment', $this->GetName()), "Google request result: ".print_r($request_result, true));
		}

		/**
		 * Get the shipping provider name in a format google recognises
		 *
		 * @return string
		 **/
		private function GetShippingProvider($moduleid)
		{
			switch ($moduleid) {
				case 'shipping_ups':
				{
					return 'UPS';
					break;
				}
				case 'shipping_usps':
				{
					return 'USPS';
					break;
				}
				case 'shipping_fedex':
				{
					return 'FedEx';
					break;
				}
				case 'shipping_dhl':
				{
					return 'DHL';
					break;
				}
				default:
				{
					return 'Other';
				}
			}
		}
	}

?>