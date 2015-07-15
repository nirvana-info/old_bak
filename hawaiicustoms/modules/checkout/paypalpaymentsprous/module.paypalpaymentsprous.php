<?php

	class CHECKOUT_PAYPALPAYMENTSPROUS extends ISC_GENERIC_CREDITCARD
	{
		public $_showBothButtons = true;

		/**
		 * @var boolean Does this provider support orders from more than one vendor?
		 */
		protected $supportsVendorPurchases = true;

		/**
		 * @var boolean Does this provider support shipping to multiple addresses?
		 */
		protected $supportsMultiShipping = true;

		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the PayPal Payments Pro checkout module
			$this->requiresSSL= true;
			$this->_languagePrefix = 'PayPalPaymentsPro';
			$this->_requiresCurl = true;
			$this->_curlSupported = true;

			$this->_liveTransactionURL = 'https://api-3t.paypal.com';
			$this->_testTransactionURL = 'https://api-3t.sandbox.paypal.com';
			$this->_liveTransactionURI = '/nvp';
			$this->_testTransactionURI = '/nvp';


			$this->_cardsSupported = array('VISA', 'AMEX', 'MC', 'DISCOVER');
			$this->_currenciesSupported = array('USD', 'EUR', 'GBP', 'JPY', 'CAD', 'AUD');
			$this->_image = "paypal_logo.gif";
			$this->_file = basename(__FILE__);
			parent::__construct();

		}


		/**
		* Custom variables for the checkout module. Custom variables are stored in the following format:
		* array(variable_id, variable_name, variable_type, help_text, default_value, required, [variable_options], [multi_select], [multi_select_height])
		* variable_type types are: text,number,password,radio,dropdown
		* variable_options is used when the variable type is radio or dropdown and is a name/value array.
		*/
		public function setcustomvars()
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

			$this->_variables['cardcode'] = array(
				"name" => GetLang('RequireSecurityCode'),
				"type" => "dropdown",
				"help" => GetLang('PayPalPaymentsProSecurityCodeHelp'),
				"default" => "no",
				"savedvalue" => array(),
				"required" => true,
				"options" => array(
					GetLang('PayPalPaymentsProSecurityCodeNo') => "NO",
					GetLang('PayPalPaymentsProSecurityCodeYes') => "YES"
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
		* ProcessPaymentForm
		* Process and validate input from a payment form for this particular
		* gateway.
		*
		* @return boolean True if valid details and payment has been processed. False if not.
		*/
		protected function _ConstructPostData($postData)
		{
			$ccname = $postData['name'];
			$ccTypeName = $postData['cctype'];
			$ccnum = $postData['ccno'];
			$ccexpm = str_pad($postData['ccexpm'], 2, '0', STR_PAD_LEFT);
			$ccexpy = $postData['ccexpy']+2000;
			$ccexp = sprintf("%s%s", $ccexpm, $ccexpy);
			$cccvd = $postData['cccvd'];

			if($ccTypeName=='MC') {
				$cctype = 'MasterCard';
			} else {
				$cctype = ucfirst(strtolower($ccTypeName));
			}
			$currency = GetCurrencyCodeByID(GetConfig('DefaultCurrencyID'));

			$merchant = $this->GetMerchantSettings();

			//load all orders for this transaction
			$orders = $this->GetOrders();
			$order = current($orders);
			$orderIds = '#'.implode(', #', array_keys($orders));
			$orderdesc = sprintf(GetLang('YourOrderFrom'), $GLOBALS['StoreName']).' ('.$orderIds.')';
			$custip = $this->GetIpAddress();

			// Fetch the customer details
			$query = sprintf("SELECT custconemail FROM [|PREFIX|]customers WHERE customerid='".$GLOBALS['ISC_CLASS_DB']->Quote($this->GetCustomerId())."'");
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$customeremail = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

			// Grab the billing details for the order
			$billingDetails = $this->GetBillingDetails();

			//get bill state in ISO code
			if($billingDetails['ordbillstateid'] != 0 && GetStateISO2ById($billingDetails['ordbillstateid'])) {
				$billstate = GetStateISO2ById($billingDetails['ordbillstateid']);
			}
			else {
				$billstate = isc_html_escape($billingDetails['ordbillstate']);
			}

			//if it's a digital order use billing address as shipping address
			if(isset($order['ordisdigital']) && $order['ordisdigital'] == 1) {
				$shippingDetails = array (
					'ordshipfirstname'		=> $billingDetails['ordbillfirstname'],
					'ordshiplastname'		=> $billingDetails['ordbilllastname'],
					'ordshipstreet1'		=> $billingDetails['ordbillstreet1'],
					'ordshipstreet2'		=> $billingDetails['ordbillstreet2'],
					'ordshipsuburb'			=> $billingDetails['ordbillsuburb'],
					'ordshipzip'			=> $billingDetails['ordbillzip'],
					'ordshipcountrycode'	=> $billingDetails['ordbillcountrycode'],
					'ordshipphone'			=> $billingDetails['ordbillphone'],

				);
				$shipstate = $billstate;
			} else {
				$shippingDetails = $this->GetShippingAddresses();
				$shippingDetails = $shippingDetails[$order['orderid']];


				//get ship state in ISO code
				if($shippingDetails['ordshipstateid'] != 0) {
					$shipstate = GetStateISO2ById($shippingDetails['ordshipstateid']);
				}
				else {
					$shipstate = isc_html_escape($shippingDetails['ordshipstate']);
				}
			}


			// Arrange the data into name/value pairs ready to send
			$pp_values = array (

				'METHOD'			=> 'DoDirectPayment',
				'USER'				=> $merchant['username'],
				'PWD'				=> $merchant['password'],
				'SIGNATURE'			=> $merchant['signature'],
				'VERSION'			=> '52.0',
				'PAYMENTACTION'		=> $merchant['transactionType'],

				/*customer details*/
				'IPADDRESS'			=> $custip,
				'FIRSTNAME'			=> $billingDetails['ordbillfirstname'],
				'LASTNAME'			=> $billingDetails['ordbilllastname'],
				'STREET'			=> $billingDetails['ordbillstreet1']." ".$billingDetails['ordbillstreet2'],
				'CITY'				=> $billingDetails['ordbillsuburb'],
				'STATE'				=> $billstate,
				'ZIP'				=> $billingDetails['ordbillzip'],
				'COUNTRYCODE'		=> $billingDetails['ordbillcountrycode'],
				'EMAIL'				=> $customeremail,
				'PHONENUM'			=> $billingDetails['ordbillphone'],

				/*shipping details*/
				'SHIPTONAME'		=> $shippingDetails['ordshipfirstname']." ".$shippingDetails['ordshiplastname'],
				'SHIPTOSTREET'		=> $shippingDetails['ordshipstreet1'],
				'SHIPTOSTREET2'		=> $shippingDetails['ordshipstreet2'],
				'SHIPTOCITY'		=> $shippingDetails['ordshipsuburb'],
				'SHIPTOSTATE'		=> $shipstate,
				'SHIPTOZIP'			=> $shippingDetails['ordshipzip'],
				'SHIPTOCOUNTRYCODE'	=> $shippingDetails['ordshipcountrycode'],
				'SHIPTOPHONENUM'	=> $shippingDetails['ordshipphone'],

				/*payment details*/
				'CREDITCARDTYPE'	=> $cctype,
				'ACCT'				=> $ccnum,
				'EXPDATE'			=> $ccexp,
				'CVV2'				=> $cccvd,
				'CURRENCYCODE'		=> $currency,
				'AMT'				=> number_format($order['ordgatewayamount'],2,'.',''),

				'INVNUM'			=> $orderIds,
			);

			if($order['ordstorecreditamount']+$order['ordgiftcertificateamount'] ==0) {
				$AmountDetails = array(
					'ITEMAMT'			=> number_format($this->GetSubTotal(),2,'.',''),
					'SHIPPINGAMT'		=> number_format($this->GetShippingCost(),2,'.',''),
					'HANDLINGAMT'		=> number_format($this->GetHandlingCost(),2,'.',''),
					'TAXAMT'			=> number_format($this->GetTaxCost(),2,'.',''),
				);
				$pp_values = array_merge($pp_values, $AmountDetails);
			}


			$paypal_query = http_build_query($pp_values);

			return $paypal_query;
		}

		/**
		* save the response in session and redirect customer to finish order
		* @param string $response the response returned from paypal
		* @param array $pendingOrder
		*
		*/
		protected function _HandleResponse($response, $pendingOrder=array())
		{
			//decode response and fetch it into array
			$nvpArray = $this->_DecodePaypalResult($response);

			$_SESSION['PayPalPaymentsProResponse'] = $nvpArray;
			@ob_end_clean();
			$token = md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']);
			header(sprintf("Location:%s/finishorder.php?o=%s", $GLOBALS['ShopPathSSL'], $token));
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

			// Is PayPal Payments setup in test or live mode?
			$merchant['testmode'] = $this->GetValue('testmode');

			return $merchant;
		}

		/**
		*	Verify the order by checking the PayPalPaymentsPro Pro variables
		*/
		public function VerifyOrderPayment()
		{
			// The *only* way someone can end up here is AFTER the order has ALREADY been validated, so we pass an MD5 has of the pending
			// order token in the $_GET array and compare that to the pending token, returning true if they are equal and false if not.
			if(isset($_COOKIE['SHOP_ORDER_TOKEN']) && isset($_GET['o']) && md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']) == $_GET['o']) {

				$orders = $this->GetOrders();
				$orderIds = '#'.implode(', #', array_keys($orders));

				$nvpArray = $_SESSION['PayPalPaymentsProResponse'];
				// unset PayPalPaymentsPro response in session
				unset($_SESSION['PayPalPaymentsProResponse']);

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
				if (isc_substr(isc_strtolower($responseMsg), 0, 7) == 'success') {

					$updatedOrder = array(
						'ordpayproviderid' => $transactionId,
						'ordpaymentstatus' => $paymentStatus
					);
					$this->UpdateOrders($updatedOrder);

					$PayPalPaymentsProSuccess = sprintf(GetLang('PayPalPaymentsProSuccess'), $orderIds, $transactionId, $responseMsg);
					$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $PayPalPaymentsProSuccess);

					//set order status
					$this->SetPaymentStatus($orderStatus);
					//$PendingOrder['paymentstatus'] = $orderStatus;
					return true;
				} else {

					$errorMsg = '';
					if(isset($nvpArray['L_LONGMESSAGE0'])) {
						$errorMsg = isc_html_escape($nvpArray['L_LONGMESSAGE0']);
					}
					// Status was declined or error, show the response message as an error
					$PayPalPaymentsProError = sprintf(GetLang('PayPalPaymentsProError'), $orderIds, $transactionId, $responseMsg, $nvpArray['L_ERRORCODE0']);

					$PayPalMessage = $nvpArray['L_SHORTMESSAGE0']."<br />".$nvpArray['L_LONGMESSAGE0'];
					$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $PayPalPaymentsProError, $PayPalMessage);
					return false;
				}
			} else {
				return false;
			}
		}

		/**
		 * Returns the checkout button for this specific module. Paypal Express Checkout requires that a
		 * seperate button be used for checking out using them
		 *
		 * @return string The html to show for the button
		 **/
		public function GetCheckoutButton()
		{
			$ShowNormalCheckoutButton = false;
			foreach (GetAvailableModules('checkout', true, true) as $module) {
				if (!method_exists($module['object'], 'GetCheckoutButton')) {
					$ShowNormalCheckoutButton = true;
					break;
				}
			}

			if ($ShowNormalCheckoutButton) {
				$GLOBALS['PayPalPaymentsProOrUse'] = GetLang('PayPalPaymentsProOrUse');
			} else {
				$GLOBALS['PayPalPaymentsProOrUse'] = '';
			}

			return $this->ParseTemplate('paypalpaymentsprous.button', true);
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
		* Set Express Checkout step in Paypal Express checkout
		* it sends cart details to paypal and redirect customer to paypal login page.
		*
		*/
		private function SetExpressCheckout()
		{
			$currency = GetCurrencyCodeByID(GetConfig('DefaultCurrencyID'));

			$merchant = $this->GetMerchantSettings();

			$amount=0;
			foreach($_SESSION['CART']['ITEMS'] as $item) {
				$amount += $item['product_price'];
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

								'RETURNURL'			=> $GLOBALS['ShopPathSSL']."/checkout.php?action=set_external_checkout&provider=paypalpaymentsprous",
								'CANCELURL'			=> $GLOBALS['ShopPathSSL']."/cart.php",
								'NOSHIPPING'		=> 0,
							);

			$paypal_query = http_build_query($pp_array);

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

			$paypal_query = http_build_query($pp_array);

			// get the customer details from paypal
			$result = $this->_ConnectToProvider($transactionURL, $transactionURI, $paypal_query);
			$nvpArray = $this->_DecodePaypalResult($result);

			if(strtolower($nvpArray['ACK']) == 'success') {
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
				$GLOBALS['ISC_CLASS_CHECKOUT'] -> SetOrderShippingAddress($address);

				$_SESSION['CHECKOUT']['PayPalExpressCheckout'] = $nvpArray;
				//only want to display paypal as the payment provider on order confirmation page, as customer has already selected the pay with paypal previously, so save paypal in provider list in session, so confirmation page will read from the session.
				$_SESSION['CHECKOUT']['ProviderListHTML'] = $this->ParseTemplate('paypalpaymentsprous.providerlist', true);

				$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
				$GLOBALS['ISC_CLASS_CART']->SetCartValues();

				//skip choose a billing and shipping address step
				if(GetConfig('CheckoutType') == 'single') {
					$returnURL = $GLOBALS['ShopPathSSL']."/checkout.php";
					$_SESSION['CHECKOUT']['GoToCheckoutStep'] = "ShippingProvider";
				} else {
					//set the address to the session
					$GLOBALS['ISC_CLASS_CHECKOUT'] -> SetOrderBillingAddress($address);
					$GLOBALS['ISC_CLASS_CHECKOUT'] -> SetOrderShippingAddress($address);
					$returnURL = $GLOBALS['ShopPathSSL']."/checkout.php?action=choose_shipper";
				}
				header("Location: ".$returnURL);
			}
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
				$orderIds = '#'.implode(', #', array_keys($orders));
				$order_desc = sprintf(GetLang('YourOrderFrom'), $GLOBALS['StoreName']).' ('.$orderIds.')';

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

				// unset PayPalPaymentsPro response in session
				unset($_SESSION['CHECKOUT']['PayPalExpressCheckout']);

				$shippingDetails = $this->GetShippingAddresses();
				$shippingDetails = $shippingDetails[$order['orderid']];

				if($shippingDetails['ordshipstateid'] != 0 && GetStateISO2ById($shippingDetails['ordshipstateid'])) {
					$shipstate = GetStateISO2ById($shippingDetails['ordshipstateid']);
				}
				else {
					$shipstate = isc_html_escape($shippingDetails['ordshipstate']);
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
								'INVNUM'			=> $orderIds,
								'NAME'				=> $shippingDetails['ordshipfirstname']." ".$shippingDetails['ordshiplastname'],
								'SHIPTOSTREET'		=> $shippingDetails['ordshipstreet1'],
								'SHIPTOSTREET2'		=> $shippingDetails['ordshipstreet2'],
								'SHIPTOCITY'		=> $shippingDetails['ordshipsuburb'],
								'SHIPTOSTATE'		=> $shipstate,
								'SHIPTOZIP'			=> $shippingDetails['ordshipzip'],
								'SHIPTOCOUNTRY'		=> $shippingDetails['ordshipcountrycode'],
								'PHONENUM'			=> $shippingDetails['ordshipphone'],
						);


				$paypal_query = http_build_query($pp_array);

				$result = $this->_ConnectToProvider($transactionURL, $transactionURI, $paypal_query);
				$nvpArray = $this->_DecodePaypalResult($result);
				$_SESSION['PayPalPaymentsProResponse'] = $nvpArray;

				$token = md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']);
				header(sprintf("Location:%s/finishorder.php?o=%s", $GLOBALS['ShopPathSSL'], $token));
			}
			else {
				// Invalid PayPalPaymentsPro response
				$this->SetError(GetLang('PayPalPaymentsProInvalidOrder'));
				return false;
			}
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