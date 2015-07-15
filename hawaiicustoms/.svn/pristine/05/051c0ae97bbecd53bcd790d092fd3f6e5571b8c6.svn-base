<?php

	class CHECKOUT_PAYPALEXPRESS extends ISC_CHECKOUT_PROVIDER
	{
		public $_showBothButtons = true;
		public $showOnConfirmPage = true;

		protected $supportsVendorPurchases = true;

		private $_liveTransactionURL = 'https://api-3t.paypal.com';
		private $_testTransactionURL = 'https://api-3t.sandbox.paypal.com';
		private $_liveTransactionURI = '/nvp';
		private $_testTransactionURI = '/nvp';

		/**
		 * The constructor.
		 */
		public function __construct()
		{
			parent::__construct();

			$this->SetImage('paypal_logo.gif');
			$this->SetName(GetLang('PayPalExpressName'));
			$this->SetDescription(GetLang('PayPalExpressDesc'));
			$this->_help = sprintf(GetLang('PayPalExpressHelp'), GetConfig('ShopPathSSL'), GetConfig('ShopPathSSL'));
		}

		/**
		 * Check if this checkout module can be enabled or not.
		 *
		 * @return boolean True if this module is supported on this install, false if not.
		 */
		public function IsSupported()
		{
			$currency = GetDefaultCurrency();

			$supportedCurrencies = array(
				'USD',
				'EUR',
				'GBP',
				'JPY',
				'CAD',
				'AUD',
				'MXP'
			);

			// Check if the default currency is supported by the payment gateway
			if (!in_array($currency['currencycode'], $supportedCurrencies)) {
				$this->SetError(sprintf(GetLang('PayPalExpressCurrecyNotSupported'),implode(',', $supportedCurrencies)));
			}

			if($this->HasErrors()) {
				return false;
			}
			else {
				return true;
			}
		}

		public function SetCustomVars()
		{
			$this->_variables['displayname'] = array(
				"name" => GetLang('DisplayName'),
				"type" => "textbox",
				"help" => GetLang('DisplayNameHelp'),
				"default" => $this->getname(),
				"savedvalue" => array(),
				"required" => true
			);

			$this->_variables['username'] = array(
				"name" => GetLang('PayPalAPIUsername'),
				"type" => "textbox",
				"help" => GetLang('PayPalAPIUsernameHelp'),
				"default" => "",
				"savedvalue" => array(),
				"required" => true
			);

			$this->_variables['password'] = array(
				"name" => GetLang('PayPalAPIPassword'),
				"type" => "password",
				"help" => GetLang('PayPalAPIPasswordHelp'),
				"default" => "",
				"savedvalue" => array(),
				"required" => true
			);

			$this->_variables['signature'] = array(
				"name" => GetLang('PayPalAPISignature'),
				"type" => "textbox",
				"help" => GetLang('PayPalAPISignatureHelp'),
				"default" => "",
				"savedvalue" => array(),
				"required" => true
			);

			$this->_variables['transactiontype'] = array(
				"name" => GetLang('TransactionType'),
				"type" => "dropdown",
				"help" => GetLang('TransactionTypeHelp'),
				"default" => "no",
				"savedvalue" => array(),
				"required" => true,
				"options" => array(
					GetLang('TransactionTypeSale') => "Sale",
					GetLang('TransactionTypeAuthorize') => "Authorization"
				),
				"multiselect" => false
			);

			$this->_variables['testmode'] = array(
				"name" => GetLang('TestMode'),
				"type" => "dropdown",
				"help" => GetLang('TestModeHelp'),
				"default" => "no",
				"savedvalue" => array(),
				"required" => true,
				"options" => array(
					GetLang('TestModeNo') => "NO",
					GetLang('TestModeYes') => "YES"
				),
				"multiselect" => false
			);
		}

		/**
		* decode response line from paypal and store it in an array
		*
		* @param string $result response come back from paypal
		*
		* @return array contents response from paypal.
		*/
		private function _DecodePaypalResult($result)
		{
			// prepare responses into array
			$proArray = array();
			while (strlen($result)) {
				// name
				$keypos = strpos($result,'=');
				$keyval = substr($result,0,$keypos);
				// value
				if(strpos($result, '&') !== false) {
					$valuepos = strpos($result, '&');
				}
				else {
					$valuepos = strlen($result);
				}
				$valval = substr($result,$keypos+1,$valuepos-$keypos-1);
				// decoding the respose
				$proArray[urldecode($keyval)] = urldecode($valval);
				$result = substr($result,$valuepos+1,strlen($result));
			}
			return $proArray;
		}

		/**
		* Get merchant's payment gateway details from the backend
		*
		* @return array merchants details
		*/
		private function GetMerchantSettings()
		{
			$merchant = array();
			// Load the paypal api username
			$merchant['username'] = $this->GetValue('username');

			// Load the paypal api signature
			$merchant['signature'] = $this->GetValue('signature');

			// Load the paypal password
			$merchant['password'] = $this->GetValue('password');

			// Load the paypal transaction Type
			$merchant['transactionType'] = $this->GetValue('transactiontype');

			// Is PayPal Express Checkout setup in test or live mode?
			$merchant['testmode'] = $this->GetValue('testmode');

			return $merchant;
		}

		/**
		 * Returns the checkout button for this specific module. Paypal Express Checkout requires that a
		 * seperate button be used for checking out using them
		 *
		 * @return string The html to show for the button
		 **/
		public function GetCheckoutButton()
		{
			$showNormalCheckoutButton = false;
			foreach (GetAvailableModules('checkout', true, true) as $module) {
				if (!method_exists($module['object'], 'GetCheckoutButton')) {
					$showNormalCheckoutButton = true;
					break;
				}
			}

			if ($showNormalCheckoutButton) {
				$GLOBALS['PayPalExpressOrUse'] = GetLang('PayPalExpressOrUse');
			} else {
				$GLOBALS['PayPalExpressOrUse'] = '';
			}

			return $this->ParseTemplate('paypalexpress.button', true);
		}



		public function GetSidePanelCheckoutButton()
		{
			$showNormalCheckoutButton = false;
			foreach (GetAvailableModules('checkout', true, true) as $module) {
				if (!method_exists($module['object'], 'GetCheckoutButton')) {
					$showNormalCheckoutButton = true;
					break;
				}
			}

			if ($showNormalCheckoutButton) {
				$GLOBALS['PayPalExpressOrUse'] = GetLang('PayPalExpressOrUse');
			} else {
				$GLOBALS['PayPalExpressOrUse'] = '';
			}

			return $this->ParseTemplate('paypalexpress.button', true);
		}

		public function SetCheckoutData()
		{
			if(!GetConfig('GuestCheckoutEnabled') && !CustomerIsSignedIn()) {
				@ob_end_clean();
				header("Location: ".GetConfig('ShopPath').'/checkout.php?action=checkout&bad_login=1');
				exit;
			}
			if(!isset($_REQUEST['token'])) {
				$this->SetExpressCheckout();
			} else {
				$this->GetExpressCheckoutDetails();
			}

		}

		/**
		* Redirect the customer to PalPal site to enter their payment details
		* This is called when customer checkout through the normal checkout process,
		* transfer customers from order confirmation page to paypal
		*
		*/
		public function TransferToProvider()
		{
			$this->SetExpressCheckout('orderConfirmPage');
			exit;
		}

		/**
		* Set Express Checkout step in Paypal Express checkout
		* it sends cart details to paypal and redirect customer to paypal login page.
		*
		*/
		private function SetExpressCheckout($checkoutFrom='')
		{
			$currency = GetCurrencyCodeByID(GetConfig('DefaultCurrencyID'));

			$merchant = $this->GetMerchantSettings();

			$amount=0;

			//if user click the paypal button on order confirmation page
			if(isset($_COOKIE['SHOP_ORDER_TOKEN']) && $checkoutFrom == 'orderConfirmPage') {
				$amount = number_format($this->gettotal(), 2,'.','');
				//don't display shipping address in PayPal
				$noShipping = 1;
			} else {
				//display shipping address in PayPal
				$noShipping = 0;
				foreach($_SESSION['CART']['ITEMS'] as $item) {
					$amount += $item['product_price'];
				}
			}

			if($merchant['testmode'] == 'YES') {
				$transactionURL = $this->_testTransactionURL;
				$transactionURI = $this->_testTransactionURI;
				$PaypalExpressCheckoutURL = 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';
			}
			else {
				$transactionURL = $this->_liveTransactionURL;
				$transactionURI = $this->_liveTransactionURI;
				$PaypalExpressCheckoutURL = 'https://www.paypal.com/webscr&cmd=_express-checkout&token=';
			}

			$pp_array = array(
								'METHOD'			=> 'SetExpressCheckout',
								'USER'				=> $merchant['username'],
								'PWD'				=> $merchant['password'],
								'SIGNATURE'			=> $merchant['signature'],
								'VERSION'			=> '52.0',
								'PAYMENTACTION'		=> $merchant['transactionType'],

								'AMT'				=> number_format($amount,2,'.',''),
								'CURRENCYCODE'		=> $currency,
								'PAYMENTACTION'		=> $merchant['transactionType'],

								'RETURNURL'			=> $GLOBALS['ShopPathSSL']."/checkout.php?action=set_external_checkout&provider=paypalexpress",
								'CANCELURL'			=> $GLOBALS['ShopPathSSL']."/cart.php",
								'NOSHIPPING'		=> $noShipping,
							);

			$paypal_query = '';
			foreach ($pp_array as $key => $value) {
				$paypal_query .= $key.'='.urlencode($value).'&';
			}
			$paypal_query = rtrim($paypal_query, '&');

			$result = $this->_ConnectToProvider($transactionURL, $transactionURI, $paypal_query);
			$nvpArray = $this->_DecodePaypalResult($result);

			//if data is sent to paypal successfully, a token for this transaction will return from paypal
			if(strtolower($nvpArray['ACK']) == 'success') {
				// Redirect to paypal.com here
				$token = $nvpArray["TOKEN"];
				$PayPalURL = $PaypalExpressCheckoutURL.$token;
				header("Location: ".$PayPalURL);
			} else {
				//Redirecting to APIError.php to display errors.
				$GLOBALS['HideCartBadCouponPanel'] = "";
				$GLOBALS['BadCouponMessage'] = GetLang('ErrorConnectingToPaypal');
				$location = $GLOBALS['ShopPathSSL']."/cart.php";
				header("Location: $location");
			}
		}


		/**
		* Get Express Checkout Details step
		* When customer come back from paypal after they select the payment method and shipping address in paypal,
		* This function takes the shipping address and redirect customer to choose shipping provider page.
		*/
		private function GetExpressCheckoutDetails()
		{
			$merchant = $this->GetMerchantSettings();
			if($merchant['testmode'] == 'YES') {
				$transactionURL = $this->_testTransactionURL;
				$transactionURI = $this->_testTransactionURI;
			}
			else {
				$transactionURL = $this->_liveTransactionURL;
				$transactionURI = $this->_liveTransactionURI;
			}

			$pp_array = array(
								'METHOD'			=> 'GetExpressCheckoutDetails',
								'USER'				=> $merchant['username'],
								'PWD'				=> $merchant['password'],
								'SIGNATURE'			=> $merchant['signature'],
								'VERSION'			=> '52.0',
								'PAYMENTACTION'		=> $merchant['transactionType'],
								'TOKEN'				=> $_REQUEST['token']
							);

			$paypal_query = '';
			foreach ($pp_array as $key => $value) {
				$paypal_query .= $key.'='.urlencode($value).'&';
			}
			$paypal_query = rtrim($paypal_query, '&');

			// get the customer details from paypal
			$result = $this->_ConnectToProvider($transactionURL, $transactionURI, $paypal_query);
			$nvpArray = $this->_DecodePaypalResult($result);

			if(strtolower($nvpArray['ACK']) == 'success') {

				$_SESSION['CHECKOUT']['PayPalExpressCheckout'] = $nvpArray;
				// if user started paypal express checkout at confirmation page, redirect user back to confirmation page
				if(isset($_COOKIE['SHOP_ORDER_TOKEN'])) {

					// Load the pending order
					$orders = LoadPendingOrdersByToken($_COOKIE['SHOP_ORDER_TOKEN']);
					if(!is_array($orders)) {
						@ob_end_clean();
						header("Location: ".$GLOBALS['ShopPathSSL']."/checkout.php?action=confirm_order");
						die();
					}

					$this->SetOrderData($orders);

					$this->DoExpressCheckoutPayment();
					exit;
				}

				$countryName = trim($nvpArray['SHIPTOCOUNTRYNAME']);
				$query = "select
								countryid
							from
								[|PREFIX|]countries
							where
								countryname = '".$GLOBALS['ISC_CLASS_DB']->Quote($countryName)."'";

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				$countryID = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

				$stateName = trim($nvpArray['SHIPTOSTATE']);

				$stateID = $this -> GetStateId($countryID, $stateName);
				if(isset($nvpArray['PHONENUM'])) {
					$phone = $nvpArray['PHONENUM'];
				} else {
					$phone = 1;
				}
				$address = array(
					'shipfirstname'		=> $nvpArray['FIRSTNAME'],
					'shiplastname'		=> $nvpArray['LASTNAME'],
					'shipcompany'		=> '',
					'shipaddress1'		=> $nvpArray['SHIPTOSTREET'],
					'shipaddress2'		=> '',
					'shipcity'			=> $nvpArray['SHIPTOCITY'],
					'shipstate'			=> $nvpArray['SHIPTOSTATE'],
					'shipzip'			=> $nvpArray['SHIPTOZIP'],
					'shipcountry'		=> $countryName,
					'shipstateid'		=> $stateID,
					'shipcountryid'		=> $countryID,
					'shipdestination'	=> 'residential',
					'shipphone'			=> $phone
				);
				if(CustomerIsSignedIn()) {
					$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
					$customerID = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
					$address['shipcustomerid'] = $customerID;

					// check if the customer's address we get back from paypal is already exist in the customer's ISC address book
					$addressid = $this->GetAddressID($address);

					if($addressid > 0) {
						//if address is already in ISC address book, set the ISC address id to session so it can be selected by default on the checkout page.
						$_SESSION['CHECKOUT']['SelectAddress'] = $addressid;
					} else {
						//if address isn't in ISC address book, add it to customer's address book.
						$_SESSION['CHECKOUT']['SelectAddress'] = $GLOBALS['ISC_CLASS_DB']->InsertQuery("shipping_addresses", $address, 1);
					}
				}
				$address['shipemail'] = $nvpArray['EMAIL'];
				$address['saveAddress'] = 0;

				$GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_CHECKOUT');
				//set the address to the session
				$GLOBALS['ISC_CLASS_CHECKOUT'] -> SetOrderBillingAddress($address);

				if($nvpArray['FIRSTNAME']." ".$nvpArray['LASTNAME'] != $nvpArray['SHIPTONAME']) {
					$_SESSION['CHECKOUT']['GoToCheckoutStep'] = "BillingAddress";
					$firstName = trim(preg_replace('/\s.*$/', '', $nvpArray['SHIPTONAME']));
					$lastName = trim(str_replace($firstName, '', $nvpArray['SHIPTONAME']));
					$address['shipfirstname'] = $firstName;
					$address['shiplastname'] = $lastName;
				} else {
					$_SESSION['CHECKOUT']['GoToCheckoutStep'] = "ShippingProvider";
				}
				$GLOBALS['ISC_CLASS_CHECKOUT'] -> SetOrderShippingAddress($address);


				// Only want to display paypal as the payment provider on order confirmation page, as customer has already selected the pay with paypal previously, so save paypal in provider list in session, so confirmation page will read from the session.
				$_SESSION['CHECKOUT']['ProviderListHTML'] = $this->ParseTemplate('paypalexpress.providerlist', true);


				$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
				$GLOBALS['ISC_CLASS_CART']->SetCartValues();

				// Skip choose a billing and shipping address step
				if(GetConfig('CheckoutType') == 'single') {
					$returnURL = $GLOBALS['ShopPathSSL']."/checkout.php";
				} else {
					//set the address to the session
					$GLOBALS['ISC_CLASS_CHECKOUT']->SetOrderBillingAddress($address);
					$GLOBALS['ISC_CLASS_CHECKOUT']->SetOrderShippingAddress($address);
					$returnURL = $GLOBALS['ShopPathSSL']."/checkout.php?action=choose_shipper";
				}

				header("Location: ".$returnURL);
			}
		}


		private function GetStateID($countryID,$stateName)
		{
			$stateID=0;
			$query = "Select
							stateid
						from
							[|PREFIX|]country_states
						where
							stateabbrv = '".$GLOBALS['ISC_CLASS_DB']->Quote($stateName)."'
							AND
							statecountry = '".$GLOBALS['ISC_CLASS_DB']->Quote($countryID)."'
					";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$stateID = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

			if(!$stateID) {
				$query = "Select
							stateid
						from
							[|PREFIX|]country_states
						where
							statename = '".$GLOBALS['ISC_CLASS_DB']->Quote($stateName)."'
							AND
							statecountry = '".$GLOBALS['ISC_CLASS_DB']->Quote($countryID)."'
					";

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$stateID = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
			}
			return $stateID;
		}

		/**
		* Get address ID by address details and customer ID
		*
		* @param array address details
		* @return string The generated address form.
		*
		*/
		private function GetAddressID($address)
		{
			$whereSql = '';
			foreach ($address as $field => $value) {
				if($field == 'shipcustomerid') {
					$whereSql .= $field." = ".(int)$value." AND ";
				} else {
					$whereSql .= $field." = '".$GLOBALS['ISC_CLASS_DB']->Quote($value)."' AND ";
				}
			}
			$whereSql = rtrim($whereSql, ' AND ');
			$query = "Select shipid
					From
						[|PREFIX|]shipping_addresses
					Where ".$whereSql;

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$addressid = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

			if($addressid > 0) {
				return $addressid;
			} else {
				return 0;
			}
		}

		/**
		* Sends the order details to Paypal to process
		*
		*/
		public function DoExpressCheckoutPayment()
		{
			if(isset($_COOKIE['SHOP_ORDER_TOKEN'])) {

				$orders = $this->GetOrders();
				reset($orders);
				$order = current($orders);
				$orderId = '#'.implode(', #', array_keys($orders));

				$merchant = $this->GetMerchantSettings();

				if($merchant['testmode'] == 'YES') {
					$transactionURL = $this->_testTransactionURL;
					$transactionURI = $this->_testTransactionURI;
				}
				else {
					$transactionURL = $this->_liveTransactionURL;
					$transactionURI = $this->_liveTransactionURI;
				}

				$response = $_SESSION['CHECKOUT']['PayPalExpressCheckout'];

				// unset PayPalExpress response in session
				unset($_SESSION['CHECKOUT']['PayPalExpressCheckout']);

				if($order['ordisdigital']) {
					$addressDetails = $this->GetBillingDetails();
					$shippingDetails = array (
										'firstname' => $addressDetails['ordbillfirstname'],
										'lastname' => $addressDetails['ordbilllastname'],
										'street1' => $addressDetails['ordbillstreet1'],
										'street2' => $addressDetails['ordbillstreet2'],
										'city' => $addressDetails['ordbillsuburb'],
										'state' => $addressDetails['ordbillstate'],
										'zip' => $addressDetails['ordbillzip'],
										'countrycode' => $addressDetails['ordbillcountrycode'],
										'phone' => $addressDetails['ordbillphone'],
										'stateid' => $addressDetails['ordbillstateid']
					);
				} else {
					$addressDetails = $this->GetShippingAddresses();
					$addressDetails = $addressDetails[$order['orderid']];
					$shippingDetails = array (
										'firstname' => $addressDetails['ordshipfirstname'],
										'lastname' => $addressDetails['ordshiplastname'],
										'street1' => $addressDetails['ordshipstreet1'],
										'street2' => $addressDetails['ordshipstreet2'],
										'city' => $addressDetails['ordshipsuburb'],
										'state' => $addressDetails['ordshipstate'],
										'zip' => $addressDetails['ordshipzip'],
										'countrycode' => $addressDetails['ordshipcountrycode'],
										'phone' => $addressDetails['ordshipphone'],
										'stateid' => $addressDetails['ordshipstateid']
					);

				}

				if($shippingDetails['stateid'] != 0 && GetStateISO2ById($shippingDetails['stateid'])) {
					$shipstate = GetStateISO2ById($shippingDetails['stateid']);
				}
				else {
					$shipstate = isc_html_escape($shippingDetails['state']);
				}
				$currency = GetCurrencyCodeByID(GetConfig('DefaultCurrencyID'));
				$pp_array = array(
								'METHOD'			=> 'DoExpressCheckoutPayment',
								'USER'				=> $merchant['username'],
								'PWD'				=> $merchant['password'],
								'SIGNATURE'			=> $merchant['signature'],
								'VERSION'			=> '52.0',
								'TOKEN'				=> $response['TOKEN'],
								'PAYERID'			=> $response['PAYERID'],
								'PAYMENTACTION'		=> $merchant['transactionType'],
								'AMT'				=> number_format($order['ordgatewayamount'],2,'.',''),
								'CURRENCYCODE'		=> $currency,

								'IPADDRESS'			=> $this->GetIpAddress(),
								'ITEMAMT'			=> number_format($this->GetSubTotal(),2,'.',''),
								'SHIPPINGAMT'		=> number_format($this->GetShippingCost(),2,'.',''),
								'HANDLINGAMT'		=> number_format($this->GetHandlingCost(),2,'.',''),
								'TAXAMT'			=> number_format($this->GetTaxCost(),2,'.',''),
								'INVNUM'			=> $orderId,
								'NAME'				=> $shippingDetails['firstname']." ".$shippingDetails['lastname'],
								'SHIPTOSTREET'		=> $shippingDetails['street1'],
								'SHIPTOSTREET2'		=> $shippingDetails['street2'],
								'SHIPTOCITY'		=> $shippingDetails['city'],
								'SHIPTOSTATE'		=> $shipstate,
								'SHIPTOZIP'			=> $shippingDetails['zip'],
								'SHIPTOCOUNTRY'		=> $shippingDetails['countrycode'],
								'PHONENUM'			=> $shippingDetails['phone'],
								'BUTTONSOURCE'		=> "Interspire_cart_EC_AU"
						);

				$paypal_query = '';
				foreach ($pp_array as $key => $value) {
					$paypal_query .= $key.'='.urlencode($value)."&";
				}
				$paypal_query = rtrim($paypal_query, '&');

				$result = $this->_ConnectToProvider($transactionURL, $transactionURI, $paypal_query);
				$nvpArray = $this->_DecodePaypalResult($result);

				$_SESSION['PayPalExpressResponse'] = $nvpArray;

				$token = md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']);
				header(sprintf("Location:%s/finishorder.php?o=%s", $GLOBALS['ShopPathSSL'], $token));
			}
			else {
				// Invalid PayPalExpress response
				$this->SetError(GetLang('PayPalExpressInvalidOrder'));
				return false;
			}
		}

		/**
		*	Verify the order by checking the PayPal Express Checkout variables
		*/
		public function VerifyOrderPayment()
		{
			// The *only* way someone can end up here is AFTER the order has ALREADY been validated, so we pass an MD5 has of the pending
			// order token in the $_GET array and compare that to the pending token, returning true if they are equal and false if not.
			if(isset($_COOKIE['SHOP_ORDER_TOKEN']) && isset($_GET['o']) && md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']) == $_GET['o']) {


				$orders = $this->GetOrders();
				reset($orders);
				$orderId = '#'.implode(', #', array_keys($orders));

				//$orders = $this->GetOrders();
				//$orderIds = '#'.implode(', #', array_keys($orders));
				$order = LoadPendingOrderByToken($_COOKIE['SHOP_ORDER_TOKEN']);
				$orderId = '#'.$order['orderid'];

				$nvpArray = $_SESSION['PayPalExpressResponse'];
				unset($_SESSION['PayPalExpressResponse']);

				$responseMsg = isc_html_escape($nvpArray['ACK']);
				$transactionId = '';
				if (isset($nvpArray['TRANSACTIONID'])) {
					$transactionId = isc_html_escape($nvpArray['TRANSACTIONID']);
				}

				$orderStatus = PAYMENT_STATUS_PAID;
				// Load the paypal transaction Type
				$transactionType = $this->GetValue('transactiontype');
				if($transactionType == 'Authorization') {
					$paymentStatus = 'authorized';
				} elseif ($transactionType == 'Sale') {
					$paymentStatus = 'captured';
				}

				//if transaction is successful
				if (strtolower($responseMsg) == 'success') {

					$updatedOrder = array(
						'ordpayproviderid' => $transactionId,
						'ordpaymentstatus' => $paymentStatus
					);
					$this->UpdateOrders($updatedOrder);

					$paymentSuccess = sprintf(GetLang('PayPalExpressSuccess'), $orderId, $transactionId, $responseMsg);
					$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $paymentSuccess);

					//set order status
					$this->SetPaymentStatus($orderStatus);

					return true;
				} else {

					$errorMsg = '';
					if(isset($nvpArray['L_LONGMESSAGE0'])) {
						$errorMsg = isc_html_escape($nvpArray['L_LONGMESSAGE0']);
					}
					// Status was declined or error, show the response message as an error
					$error = sprintf(GetLang('PayPalExpressError'), $orderId, $transactionId, $responseMsg, $errorMsg);
					$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $error);
					return false;
				}
			} else {
				return false;
			}
		}

		protected function _ConnectToProvider($transactionURL, $transactionURI, $gateway_postdata)
		{
			$responseHeader = '';


			if(function_exists("curl_exec")) {

				// Use CURL if it's available
				$ch = curl_init($transactionURL.$transactionURI);

				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_HEADER, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $gateway_postdata);
				curl_setopt($ch, CURLOPT_TIMEOUT, 60);
				curl_setopt($ch, CURLOPT_VERBOSE, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

				// Setup the proxy settings if there are any
				if (GetConfig('HTTPProxyServer')) {
					curl_setopt($ch, CURLOPT_PROXY, GetConfig('HTTPProxyServer'));
					if (GetConfig('HTTPProxyPort')) {
						curl_setopt($ch, CURLOPT_PROXYPORT, GetConfig('HTTPProxyPort'));
					}
				}

				if (GetConfig('HTTPSSLVerifyPeer') == 0) {
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				}

				$result = curl_exec($ch);
				$result = explode("\n\r\n", $result);
					$responseHeader = $result[0];
					$result = $result[1];

				if(curl_errno($ch)) {
					$this->SetError(GetLang('CreditCardCurlError'). $this->GetValue('displayname') . ":" .curl_error($ch));
					return false;
				}
			}
			else if(function_exists("fsockopen")) {

				$header = "POST " . $transactionURI . " HTTP/1.0\r\n";
				$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
				$header .= "Content-Length: " . strlen($gateway_postdata) . "\r\n\r\n";

				$url = parse_url($transactionURL);

				if ($url['scheme'] == 'https') {
						$url['host'] = 'ssl://'.$url['host'];
				}

				if (!isset($url['port']) || $url['port'] == '') {
					if ($url['scheme'] == 'http') {
						$url['port'] = 80;
					}
					else if ($url['scheme'] == 'https') {
						$url['port'] = 443;
					}
				}
				if($fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30)) {
					@fputs($fp, $header . $gateway_postdata);

					// Read the body data
					$result = "";
					$responseHeader = '';
					$headerdone = false;

					while(!@feof($fp)) {
						$line = @fgets($fp, 1024);

						if(@strcmp($line, "\r\n") == 0) {
							// Header has been read
							$headerdone = true;
						}
						else if (!$headerdone) {
							// Read the header
							$responseHeader .= (string)$line;
						}
						else if($headerdone) {
							// Header has been read, read the contents
							$result .= $line;
						}
					}

				}
				else {
					$this->SetError(GetLang('CreditCardFSockError') . $this->GetValue('displayname'));
					return false;
				}
			}
			else {
				$this->SetError(GetLang('CreditCardConnectionMethod') . $this->GetValue('displayname'));
				return false;
			}

			if (empty($result)) {
				return $responseHeader;
			}

			return $result;
		}



		private function GetResponseFromProvider($transactionType, $extraFields=array())
		{
			$merchant = $this->GetMerchantSettings();

			if($merchant['testmode'] == 'YES') {
				$transactionURL = $this->_testTransactionURL;
				$transactionURI = $this->_testTransactionURI;
			}
			else {
				$transactionURL = $this->_liveTransactionURL;
				$transactionURI = $this->_liveTransactionURI;
			}


			//NOTE=$note
			$pp_array = array(
				'METHOD'			=> $transactionType,
				'USER'				=> $merchant['username'],
				'PWD'				=> $merchant['password'],
				'SIGNATURE'			=> $merchant['signature'],
				'VERSION'			=> '52.0',
			);

			$pp_array = array_merge($pp_array, $extraFields);

			$paypal_query = http_build_query($pp_array);

			$result = $this->_ConnectToProvider($transactionURL, $transactionURI, $paypal_query);
			$nvpArray = $this->_DecodePaypalResult($result);

			return $nvpArray;
		}



		public function DelayedCapture($order, &$message = '', $amt = 0)
		{

			$orderId = $order['orderid'];
			$originalTransId = $order['ordpayproviderid'];

			if($amt == 0) {
				$message = GetLang('DelayedCaptureIncorrectAmount');
				return false;
			}

			$extraFields = array(
								'AUTHORIZATIONID' => $originalTransId,
								'AMT' => number_format($amt,2,'.',''),
								'CURRENCYCODE' => GetCurrencyCodeByID(GetConfig('DefaultCurrencyID')),
								'COMPLETETYPE' => 'Complete'
								);

			$nvpArray = $this->GetResponseFromProvider('DoCapture', $extraFields);
			if(empty($nvpArray)) {
				$message = GetLang('ErrorConnectToPaypal');
				return false;
			}

			$transactionId = '';
			if (isset($nvpArray['TRANSACTIONID'])) {
				$transactionId = isc_html_escape($nvpArray['TRANSACTIONID']);
			}

			if(strtolower($nvpArray['ACK']) == 'success') {
				$message = GetLang('DelayedCaptureSuccess');

				$updatedOrder = array(
					'ordpaymentstatus' => 'captured',
					'ordpayproviderid' => $transactionId,
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('orders', $updatedOrder, "orderid='".(int)$orderId."'");


				$DelayedCaptureSuccess = sprintf(GetLang('DelayedCaptureSuccessLog'), $orderId, $transactionId);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $DelayedCaptureSuccess, $message);
				return true;

			} else {
				$errorMsg = '';
				if(isset($nvpArray['L_LONGMESSAGE0'])) {
					$errorMsg = isc_html_escape($nvpArray['L_LONGMESSAGE0']);
				}

				$message = sprintf(GetLang('DelayedCaptureFailed'), $errorMsg);

				$DelayedCaptureError = sprintf(GetLang('DelayedCaptureError'), $orderId);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $DelayedCaptureError, $errorMsg);
				return false;
			}
		}


		public function DoRefund($order, &$message = '', $amt = 0)
		{
			if($amt == 0) {
				$message = GetLang('RefundIncorrectAmount');
				return false;
			}


			$originalTransId = $order['ordpayproviderid'];
			$orderId = $order['orderid'];

			$orderAmount = number_format($order['ordgatewayamount'],2,'.','');
			$amt = number_format($amt,2,'.','');
			$TotalRefundedAmt = number_format($amt+$order['ordrefundedamount'],2,'.','');

			$extraFields = array();
			if($orderAmount == $amt) {
				$extraFields = array('REFUNDTYPE' => 'Full',
									'TRANSACTIONID' => $originalTransId);
			}
			elseif ($orderAmount > $amt) {
				$extraFields = array(
									'REFUNDTYPE' => 'Partial',
									'AMT' => $amt,
									'CURRENCYCODE' => GetCurrencyCodeByID(GetConfig('DefaultCurrencyID')),
									'TRANSACTIONID' => $originalTransId,
								);
			}

			$nvpArray = $this->GetResponseFromProvider('RefundTransaction', $extraFields);
			if(empty($nvpArray)) {
				$message = GetLang('ErrorConnectToPaypal');
				return false;
			}

			$transactionId = '';
			if (isset($nvpArray['REFUNDTRANSACTIONID'])) {
				$transactionId = isc_html_escape($nvpArray['REFUNDTRANSACTIONID']);
			}

			if (strtolower($nvpArray['ACK']) == 'success') {
				$message = GetLang('RefundSuccess');

				//if total refunded is less than the order total amount
				if($TotalRefundedAmt < $orderAmount) {
					$paymentStatus = 'partially refunded';
				} else {
					$paymentStatus = 'refunded';
				}


				$updatedOrder = array(
					'ordpaymentstatus' => $paymentStatus,
					'ordrefundedamount'	=> $TotalRefundedAmt,
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('orders', $updatedOrder, "orderid='".(int)$orderId."'");


				$refundSuccess = sprintf(GetLang('RefundSuccessLog'), $orderId, $transactionId);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $refundSuccess, $message);
				return true;


			} else {
				$errorMsg = '';
				if(isset($nvpArray['L_LONGMESSAGE0'])) {
					$errorMsg = isc_html_escape($nvpArray['L_LONGMESSAGE0']);
				}

				$message = sprintf(GetLang('RefundFailed'), $errorMsg);

				$refundError = sprintf(GetLang('RefundError'), $orderId);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $refundError, $errorMsg);
				return false;
			}
		}



		public function DoVoid($orderId, $originalTransId, &$message = '')
		{

			$extraFields = array(
								'AUTHORIZATIONID' => $originalTransId,
								);

			$nvpArray = $this->GetResponseFromProvider('DoVoid', $extraFields);
			if(empty($nvpArray)) {
				$message = GetLang('ErrorConnectToPaypal');
				return false;
			}

			$transactionId = '';
			if (isset($nvpArray['AUTHORIZATIONID'])) {
				$transactionId = isc_html_escape($nvpArray['AUTHORIZATIONID']);
			}

			if(strtolower($nvpArray['ACK']) == 'success') {
				$message = GetLang('VoidSuccess');

				$updatedOrder = array(
					'ordpaymentstatus' => 'void',
					'ordpayproviderid' => $transactionId,
				);

				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('orders', $updatedOrder, "orderid='".(int)$orderId."'");


				$voidSuccess = sprintf(GetLang('VoidSuccessLog'), $orderId, $transactionId);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $voidSuccess, $message);
				return true;


			} else {
				$errorMsg = '';
				if(isset($nvpArray['L_LONGMESSAGE0'])) {
					$errorMsg = isc_html_escape($nvpArray['L_LONGMESSAGE0']);
				}

				$message = sprintf(GetLang('VoidFailed'), $errorMsg);

				$voidError = sprintf(GetLang('VoidError'), $orderId);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $voidError, $errorMsg);
				return false;
			}
		}
	}

?>