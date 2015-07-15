<?php

	class CHECKOUT_PAYPALPAYMENTSPROUK extends ISC_GENERIC_CREDITCARD
	{
		public $_showBothButtons = true;

		/**
		 * @var boolean Does this provider support orders from more than one vendor?
		 */
		protected $supportsVendorPurchases = true;

		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the PayPal Payments Pro checkout module
			$this->_requiresSSL= true;
			$this->_languagePrefix = 'PayPalPaymentsPro';
			$this->_requiresCurl = true;
			$this->_curlSupported = true;

			$this->_liveTransactionURL = 'https://payflowpro.verisign.com';
			$this->_testTransactionURL = 'https://pilot-payflowpro.verisign.com';
			$this->_liveTransactionURI = '';
			$this->_testTransactionURI = '';

			$this->_cardsSupported = array('VISA', 'MC', 'SOLO', 'SWITCH');
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

			$this->_variables['vendorid'] = array(
				"name" => GetLang('VendorID'),
				"type" => "textbox",
				"help" => GetLang('VendorIDHelp'),
				"default" => "",
				"savedvalue" => array(),
				"required" => true
			);

			$this->_variables['userid'] = array(
				"name" => GetLang('UserID'),
				"type" => "textbox",
				"help" => GetLang('UserIDHelp'),
				"default" => "",
				"savedvalue" => array(),
				"required" => true
			);

			$this->_variables['partnerid'] = array(
				"name" => GetLang('PartnerID'),
				"type" => "textbox",
				"help" => GetLang('PartnerIDHelp'),
				"default" => "",
				"savedvalue" => array(),
				"required" => true
			);

			$this->_variables['password'] = array(
				"name" => GetLang('Password'),
				"type" => "password",
				"help" => GetLang('PasswordHelp'),
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
					GetLang('TransactionTypeSale') => "S",
					GetLang('TransactionTypeAuthorize') => "A"
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
		protected function _ConstructPostData($postData, $orders)
		{

			$ccname = $postData['name'];
			$ccTypeName = $postData['cctype'];
			$ccnum = $postData['ccno'];
			$ccexpm = str_pad($postData['ccexpm'], 2, '0', STR_PAD_LEFT);
			$ccexpy = $postData['ccexpy'];
			$ccexp = sprintf("%s%s", $ccexpm, $ccexpy);
			$cccvd = $postData['cccvd'];
			$ccissuenumber =$postData['ccissueno'];

			$ccissuem = $postData['ccissuedatem'];
			$ccissuey = substr($postData['ccissuedatey'], 2,4);
			$ccissuedate = sprintf("%s%s", $ccissuem, $ccissuey);

			$cardTypes = array(
					'visa'		=> '0',
					'mc'		=> '1',
					'other'		=> '8',
					'switch'	=> '9',
					'solo'		=> 'S'
			);


			$cctype = $cardTypes[strtolower($ccTypeName)];
			$currency = GetCurrencyCodeByID(GetConfig('DefaultCurrencyID'));

			$merchant = $this->GetMerchantSettings();

			$custip = $this->GetIpAddress();

			$order = current($orders);
			$orderIds = '#'.implode(', #', array_keys($orders));
			$orderdesc = sprintf(GetLang('YourOrderFrom'), $GLOBALS['StoreName']).' ('.$orderIds.')';


			$orderTax = 0;
			if($order['ordtotalincludestax']==0) {
				$orderTax = number_format($this->GetTaxCost(), 2);
			}

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
					'ordshipstreet1'		=> $billingDetails['ordbillstreet1'],
					'ordshipstreet2'		=> $billingDetails['ordbillstreet2'],
					'ordshipsuburb'			=> $billingDetails['ordbillsuburb'],
					'ordshipzip'			=> $billingDetails['ordbillzip'],
					'ordshipcountrycode'	=> $billingDetails['ordbillcountrycode'],
				);
				$shipstate = $billstate;

			} else {
				$shippingDetails = $this->GetShippingAddresses();
				$shippingDetails = $shippingDetails[$order['orderid']];

				//get ship state in ISO code
				if($shippingDetails['ordshipstateid'] != 0 && GetStateISO2ById($shippingDetails['ordshipstateid'])) {
					$shipstate = GetStateISO2ById($shippingDetails['ordshipstateid']);
				}
				else {
					$shipstate = isc_html_escape($shippingDetails['ordshipstate']);
				}
			}

			// Arrange the data into name/value pairs ready to send
			$pp_values = array (
				'USER'				=> $merchant['userid'],
				'PWD'				=> $merchant['password'],
				'VENDOR'			=> $merchant['vendorid'],
				'PARTNER'			=> $merchant['partnerid'],
				'TENDER'			=> 'C',		//Credit card for Direct Payment transactions
				'TRXTYPE'			=> $merchant['transactionType'],
				'NOTIFYURL'			=> $GLOBALS['ShopPath'].'/finishorder.php',

				/*customer details*/
				'CLIENTIP'			=> $custip,
				'EMAIL'				=> $customeremail,
				'CUSTREF'			=> $this->GetCustomerId(),
				'FIRSTNAME'			=> $billingDetails['ordbillfirstname'],
				'LASTNAME'			=> $billingDetails['ordbilllastname'],
				'STREET'			=> $billingDetails['ordbillstreet1']." ".$billingDetails['ordbillstreet2'],
				'CITY'				=> $billingDetails['ordbillsuburb'],
				'STATE'				=> $billstate,
				'ZIP'				=> $billingDetails['ordbillzip'],
				'COUNTRY'			=> $billingDetails['ordbillcountrycode'],

				/*shipping details*/
				'SHIPTOSTREET'		=> $shippingDetails['ordshipstreet1']." ".$shippingDetails['ordshipstreet2'],
				'SHIPTOCITY'		=> $shippingDetails['ordshipsuburb'],
				'SHIPTOSTATE'		=> $shipstate,
				'SHIPTOZIP'			=> $shippingDetails['ordshipzip'],
				'SHIPTOCOUNTRY'		=> $shippingDetails['ordshipcountrycode'],

				/*payment details*/
				'ACCTTYPE'			=> $cctype,
				'ACCT'				=> $ccnum,
				'CVV2'				=> $cccvd,
				'AMT'				=> number_format($order['ordgatewayamount'], 2),
				'CURRENCY'			=> $currency,
				'CARDISSUE'			=> $ccissuenumber, //Issue number of Switch or Solo card.
				'CARDSTART'			=> $ccissuedate, //Date that Switch or Solo card was issued in mmyy format.
				'EXPDATE'			=> $ccexp,
				'ITEMAMT'			=> number_format($this->GetSubTotal(), 2),
				'FREIGHTAMT'		=> number_format($this->GetShippingCost(),2),
				'HANDLINGAMT'		=> number_format($this->GetHandlingCost(), 2),
				'TAXAMT'			=> $orderTax,

				/*order details*/
				'INVNUM'			=> $orderIds,
				'MERCHANTSESSIONID'	=> $_COOKIE['SHOP_ORDER_TOKEN']
			);

			/*build name value pair string*/
			$paypal_query = '';
			foreach ($pp_values as $key => $value) {
				if($key=='USER') {
					$paypal_query .= $key.'['.strlen($value).']='.$value;
				} else {
					$paypal_query .= '&'.$key.'['.strlen($value).']='.$value;
				}
			}


			$paypal_query = rtrim($paypal_query, '&');
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
				$proArray[$keyval] = $valval;
				$result = substr($result,$valuepos+1,strlen($result));
			}
			return $proArray;
		}

		/**
		* Send the payment details to paypal and retrive the responses from paypal
		*
		* @param int $orderid, the order ID used as the unique id for the transction
		* @param string $submiturl the url used to connect to paypal
		* @param string $payal_query the name value pairs string contains the payment details
		*
		* return array $proArray Array of paypal response
		*/
		protected function _ConnectToProvider($transactionURL, $transactionURI, $gateway_postdata, $orderid = 0)
		{
			if(function_exists("curl_exec")) {
				$useragent = $_SERVER['HTTP_USER_AGENT'];
				$headers[] = "Content-Type: text/namevalue; "; //or text/xml if using XMLPay.
				$headers[] = "Content-Length : ".strlen($gateway_postdata).";";  // Length of data to be passed
				$headers[] = "X-VPS-Timeout: 45;";
				if($orderid != 0) {
					$headers[] = "X-VPS-Request-ID: ".$orderid.";";
				}

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $transactionURL.$transactionURI);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
				curl_setopt($ch, CURLOPT_VERBOSE, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        // return into a variable
				curl_setopt($ch, CURLOPT_TIMEOUT, 45);              // times out after 45 secs
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

				//turning off the server and peer verification(TrustManager Concept).
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);        // this line makes it work under https
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);

				curl_setopt($ch, CURLOPT_POSTFIELDS, $gateway_postdata);        //adding POST data

				curl_setopt($ch, CURLOPT_FORBID_REUSE, true);       //forces closure of connection when done
				curl_setopt($ch, CURLOPT_POST, 1); 									//data sent as POST


				$result = curl_exec($ch);
				curl_close($ch);
			}
			else {
				$this->SetError(GetLang('PayPalPaymentsProCurlRequired'));
				// Show the payment form again
				$this->ShowPaymentForm();
				die();
			}
			 return $result;
		}


		/**
		* ProcessPaymentForm
		* Process and validate input from a payment form for this particular
		* gateway.
		*
		* @return boolean True if valid details and payment has been processed. False if not.
		*/
		public function ProcessPaymentForm()
		{
			$result = "";
			$error = false;

			$postData = $this->_Validate();

			if ($postData === false) {
				return false;
			}

			$orders = $this->GetOrders();
			$order = current($orders);
			$orderIds = '#'.implode(', #', array_keys($orders));

			$ccemail = $order['ordbillemail'];

			if (empty($ccemail)) {
				// Get the customer's email address
				$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
				$ccemail = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerEmailAddress();
				// If the email address is empty they aren't logged in
				if(empty($ccemail)) {
					return false;
				}
			}

			// Is setup in test or live mode?
			$this->_testmode = $this->GetValue("testmode") == "YES";

			$gateway_postdata = $this->_ConstructPostData($postData,$orders);

			if ($this->_testmode) {
				$transactionURL = $this->_testTransactionURL;
				$transactionURI = $this->_testTransactionURI;
			}
			else {
				$transactionURL = $this->_liveTransactionURL;
				$transactionURI = $this->_liveTransactionURI;
			}

			if ($this->_redirect) {
				header('Location: '.$transactionURL.$transactionURI.$gateway_postdata);
			}

			$result = $this->_ConnectToProvider($transactionURL, $transactionURI, $gateway_postdata, $orderIds);
			if(!$result) {
				return false;
			}

			$this->_HandleResponse($result);
		}


		/**
		* get merchant details from the control panel setting
		*
		* @return array merchant details
		*/
		private function GetMerchantSettings()
		{
			$merchant = array();
			// Load the paypal userid
			$merchant['userid'] = $this->GetValue('userid');

			// Load the paypal vendor id
			$merchant['vendorid'] = $this->GetValue('vendorid');

			// Load the paypal partner id
			$merchant['partnerid'] = $this->GetValue('partnerid');

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
				$order = current($orders);
				$orderIds = '#'.implode(', #', array_keys($orders));

				$nvpArray = $_SESSION['PayPalPaymentsProResponse'];
				// unset paypal response in session
				unset($_SESSION['PayPalPaymentsProResponse']);

				$success = true;
				$duplicate = false;
				$responseCode = "";

				$transactionId = 0;
				$responseMsg = '';
				$message = '';
				if(isset($nvpArray['RESULT'])) {
					$responseCode = isc_html_escape($nvpArray['RESULT']);
					$responseMsg = isc_html_escape($nvpArray['RESPMSG']);
					if (isset($nvpArray['PNREF'])) {
						$transactionId = isc_html_escape($nvpArray['PNREF']);
					}

					//duplicate order, the order id had been sent to paypal before
					if(isset($nvpArray['DUPLICATE']) && $nvpArray['DUPLICATE'] == 1) {
						$success = false;
						$duplicate = true;

					//success result
					} elseif ($responseCode == 0) {
						if (isset($nvpArray['AVSADDR']) && $nvpArray['AVSADDR'] != "Y") {
							$message = GetLang('AVSCheckFailed');
						}
						if (isset($nvpArray['AVSZIP']) && $nvpArray['AVSZIP'] != "Y") {
							$message = GetLang('AVSCheckFailed');
						}
						if (isset($nvpArray['CVV2MATCH']) && $nvpArray['CVV2MATCH'] != "Y") {
							$message = GetLang('CVV2CheckFailed');
						}
					//transaction failed
					} else {
						$success = false;
					}
				} else {
					$success = false;
				}

				if ($success == true) {
					$this->SetPaymentStatus(PAYMENT_STATUS_PAID);
					if($this->GetValue('transactiontype') == 'A') {
						$paymentStatus = 'authorized';
					} else {
						$paymentStatus = 'captured';
					}


					$updatedOrder = array(
						'ordpayproviderid' => $transactionId,
						'ordpaymentstatus' => $paymentStatus,
					);

					if($message != '') {
						$extraInfo = $order['extrainfo'];
						//store the message in database
						$paymentMessage = array(
							"payment_message" => $message,
						);

						// Is there any existing extra info for the pending order?
						if($order['extrainfo'] != "") {
							$extraArray = @unserialize($order['extrainfo']);
							if(is_array($extraArray)) {
								$extraInfo = serialize(@array_merge($extraArray, $paymentMessage));
							}
						}
						else {
							$extraInfo = serialize($paymentMessage);
						}

						$updatedOrder['extrainfo'] =$extraInfo;
					}

					$this->UpdateOrders($updatedOrder);

					$paypalPaymentsProSuccess = sprintf(GetLang('PayPalPaymentsProSuccess'), $orderIds, $transactionId, $responseCode);
					$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->_name), $paypalPaymentsProSuccess,  $responseMsg." ".$message);
					return true;
				} elseif ($duplicate) {
					$paypalError = sprintf(GetLang('PayPalPaymentsProDuplicate'), $orderIds, $transactionId);
					$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->_name), $paypalError);
					return false;

				} else {

					// Status was declined or error, show the response message as an error
					$paypalError = sprintf(GetLang('PayPalPaymentsProError'), $orderIds, $transactionId, $responseCode);
					switch ($responseCode) {

						case 12: // incorrect card number or expiry date
						case 23: // Invalid account number
						case 24: // Invalid expiration date
						case 50: // Insufficient funds available
							$this->SetPaymentStatus(PAYMENT_STATUS_DECLINED);
							//$PendingOrder['paymentstatus'] = 3;
							$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->_name), $paypalError, $responseMsg);
							$this->_RedirectToOrderConfirmation(GetLang('DeclinedRedirect'));
							return true;
						case 13: // referral
							$this->SetPaymentStatus(PAYMENT_STATUS_PENDING);
							//$PendingOrder['paymentstatus'] = 2;
							$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->_name), $paypalError, $responseMsg);
							return true;
						default: // a system error or duplicate transactions
							$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->_name), $paypalError, $responseMsg);
							return false;
					}
				}
			} else {
				return false;
			}
		}

		/**
		 * Returns the checkout button for this specific module. Paypal website payment pro requires that a
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

			return $this->ParseTemplate('paypalpaymentsprouk.button', true);
		}

		/**
		* calls the correct function to retrive data from paypal depends on if token has been received from paypal
		*
		*/
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

		/*
		* send paypal with the item details in the cart, and redirect customer to paypal site
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
				$PaypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
			}
			else {
				$transactionURL = $this->_liveTransactionURL;
				$transactionURI = $this->_liveTransactionURI;
				$PaypalURL = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=';
			}

			$pp_array = array(
								'ACTION'			=> 'S',
								'TRXTYPE'			=> $merchant['transactionType'],
								'AMT'				=> number_format($amount, 2),
								'CANCELURL'			=> $GLOBALS['ShopPathSSL']."/cart.php",
								'PARTNER'			=> $merchant['partnerid'],

								'TENDER'			=> 'P',
								'USER'				=> $merchant['userid'],
								'PWD'				=> $merchant['password'],
								'VENDOR'			=> $merchant['vendorid'],
								'CURRENCY'			=> $currency,
								'REQCONFIRMSHIPPING'=> 1,
								'NOSHIPPING'		=> 0,
								'RETURNURL'			=> $GLOBALS['ShopPathSSL']."/checkout.php?action=set_external_checkout&provider=paypalpaymentsprouk",
							);

			$paypal_query = '';
			foreach ($pp_array as $key => $value) {
				$paypal_query .= $key.'['.strlen($value).']='.$value. '&';
			}
			$paypal_query = rtrim($paypal_query, '&');

			$result = $this->_ConnectToProvider($transactionURL, $transactionURI, $paypal_query, uniqid(rand()));
			$nvpArray = $this->_DecodePaypalResult($result);


			if($nvpArray['RESULT'] == 0) {
				// Redirect to paypal.com here
				$token = $nvpArray["TOKEN"];
				$PaypalURL = $PaypalURL.$token;
				header("Location: ".$PaypalURL);
			} else {
				//Redirecting to APIError.php to display errors.
				$GLOBALS['HideCartBadCouponPanel'] = "";
				$GLOBALS['BadCouponMessage'] = GetLang('ErrorConnectingToPaypal');
				$location = $GLOBALS['ShopPathSSL']."/cart.php";
				header("Location: $location");
			}
		}

		/**
		* get the shipping and payment information that customer selected from paypal
		* and redirect customer to choose a shipping provider page
		*
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
								'USER'				=> $merchant['userid'],
								'PWD'				=> $merchant['password'],
								'VENDOR'			=> $merchant['vendorid'],
								'PARTNER'			=> $merchant['partnerid'],
								'ACTION'			=> 'G',
								'TENDER'			=> 'P',
								'TRXTYPE'			=> $merchant['transactionType'],
								'TOKEN'				=> $_REQUEST['token']
							);

			$paypal_query = '';
			foreach ($pp_array as $key => $value) {
				$paypal_query .= $key.'['.strlen($value).']='.$value.'&';
			}
			$paypal_query = rtrim($paypal_query, '&');

			$result = $this->_ConnectToProvider($transactionURL, $transactionURI, $paypal_query, uniqid(rand()));
			$nvpArray = $this->_DecodePaypalResult($result);

			if(isset($nvpArray['RESULT']) && $nvpArray['RESULT'] == 0) {

				$query = "select
								countryid, countryname
							from
								[|PREFIX|]countries
							where
								countryiso2 = '".$GLOBALS['ISC_CLASS_DB']->Quote($nvpArray['SHIPTOCOUNTRY'])."'";

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				$countryInfo = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

				$countryID = $countryInfo['countryid'];
				$countryName = $countryInfo['countryname'];

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
					'shipstateid'		=> $stateID,
					'shipzip'			=> $nvpArray['SHIPTOZIP'],
					'shipcountry'		=> $countryName,
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
				$_SESSION['CHECKOUT']['PayPalExpressCheckout'] = $nvpArray;
				//only want to display paypal as the payment provider on order confirmation page, as customer has already selected the pay with paypal previously, so save paypal in provider list in session, so confirmation page will read from the session.
				$_SESSION['CHECKOUT']['ProviderListHTML'] = $this->ParseTemplate('paypalpaymentsprouk.providerlist', true);

				$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');

				if(GetConfig('CheckoutType') == 'single') {
					$returnURL = $GLOBALS['ShopPathSSL']."/checkout.php";
					$_SESSION['CHECKOUT']['GoToCheckoutStep'] = "ShippingProvider";
				} else {
					//as select billing and shipping addresses are skipped, here manually set the addresses here.
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
		* final stage, Sends the order details together with shipping quotes, taxes and handling cost to Paypal to process
		*
		*/
		public function DoExpressCheckoutPayment()
		{
			if(isset($_COOKIE['SHOP_ORDER_TOKEN'])) {
				$orders = $this->GetOrders();
				$order = current($orders);
				$orderIds = '#'.implode(', #', array_keys($orders));

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

				$currency = GetCurrencyCodeByID(GetConfig('DefaultCurrencyID'));
				$pp_array = array(
									'USER'				=> $merchant['userid'],
									'PWD'				=> $merchant['password'],
									'VENDOR'			=> $merchant['vendorid'],
									'PARTNER'			=> $merchant['partnerid'],
									'ACTION'			=> 'D',
									'TENDER'			=> 'P',
									'TRXTYPE'			=> $merchant['transactionType'],
									'TOKEN'				=> $response['TOKEN'],
									'PAYERID'			=> $response['PAYERID'],
									'AMT'				=> number_format($order['ordgatewayamount'], 2),
									'CURRENCY'			=> $currency,
								);

				$paypal_query = '';
				foreach ($pp_array as $key => $value) {
					$paypal_query .= $key.'['.strlen($value).']='.$value.'&';
				}
				$paypal_query = rtrim($paypal_query, '&');

				$result = $this->_ConnectToProvider($transactionURL, $transactionURI, $paypal_query, $orderIds);
				$nvpArray = $this->_DecodePaypalResult($result);
				$_SESSION['PayPalPaymentsProResponse'] = $nvpArray;

				@ob_end_clean();
				$token = md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']);
				header(sprintf("Location:%s/finishorder.php?o=%s", $GLOBALS['ShopPathSSL'], $token));
			}
			else {
				// Invalid PayPalPaymentsPro response
				$this->SetError(GetLang('PayPalPaymentsProInvalidOrder'));
				return false;
			}
		}

		public function DelayedCapture($order, &$message = '', $amt = 0)
		{
			$orderId = $order['orderid'];
			$transactionId = $order['ordpayproviderid'];

			$amt = number_format($amt,2);
			$extraFields = array(
					'AMT'=>$amt,
					'CAPTURECOMPLETE' => 'N'
			);

			$nvpArray = $this->GetResponseFromPaypal($transactionId, 'D', $orderId, $extraFields);
			if(empty($nvpArray)) {
				$message = GetLang('ErrorConnectToPaypal');
				return false;
			}

			if(isset($nvpArray['DUPLICATE']) && $nvpArray['DUPLICATE'] == 1) {
				$message = GetLang('DelayedCaptureDuplicateTransaction');

			} elseif($nvpArray['RESULT'] == 0) {

				if(isset($nvpArray['AVSADDR']) && $nvpArray['AVSADDR'] != 'Y') {
					$message = GetLang('AVSCheckFailed');
				}
				if (isset($nvpArray['AVSZIP']) && $nvpArray['AVSZIP']!= 'Y') {
					$message =  GetLang('AVSCheckFailed');
				}
				if (isset($nvpArray['CVV2MATCH']) && $nvpArray['CVV2MATCH'] != 'Y') {
					$message .=  GetLang('CVV2CheckFailed');
				}

				$message = GetLang('DelayedCaptureSuccess').$message;


				$updatedOrder = array(
					'ordpaymentstatus' => 'captured',
					'ordpayproviderid' => $nvpArray['PNREF'],
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('orders', $updatedOrder, "orderid='".(int)$orderId."'");


				$delayedCaptureSuccess = sprintf(GetLang('DelayedCaptureSuccessLog'), $orderId, $nvpArray['PNREF'], $message);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $delayedCaptureSuccess);
				return true;

			} else {
				$responseMsg = '';
				if(isset($nvpArray['RESPMSG'])) {
					$responseMsg = $nvpArray['RESPMSG'];
				}
				$message = sprintf(GetLang('DelayedCaptureFailed'), $responseMsg);

				$DelayedCaptureError = sprintf(GetLang('DelayedCaptureError'), $orderId, $nvpArray['RESULT']);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $DelayedCaptureError, $responseMsg);
				return false;
			}
		}

		public function DoRefund($order, &$message = '', $amt = 0)
		{
			if($amt == 0) {
				$message = GetLang('RefundIncorrectAmount');
				return false;
			}

			$transactionId = $order['ordpayproviderid'];
			$orderId = $order['orderid'];

			$orderAmount = number_format($order['ordgatewayamount'], 2);
			$amt = number_format($amt,2);
			$TotalRefundedAmt = number_format($amt+$order['ordrefundedamount'], 2);

			$extraFields = array('AMT'=>$amt);

			$nvpArray = $this->GetResponseFromPaypal($transactionId, 'C', $orderId, $extraFields);
			if(empty($nvpArray)) {
				$message = GetLang('ErrorConnectToPaypal');
				return false;
			}

			if(isset($nvpArray['DUPLICATE']) && $nvpArray['DUPLICATE'] == 1) {
				$message = GetLang('RefundDuplicateTransaction');

			} elseif($nvpArray['RESULT'] == 0) {

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


				$refundSuccess = sprintf(GetLang('RefundSuccessLog'), $orderId, $nvpArray['PNREF'], $message);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $refundSuccess);
				return true;

			} else {
				$responseMsg = '';
				if(isset($nvpArray['RESPMSG'])) {
					$responseMsg = $nvpArray['RESPMSG'];
				}
				$message = sprintf(GetLang('RefundFailed'), $responseMsg);

				$RefundError = sprintf(GetLang('RefundError'), $orderId, $nvpArray['RESULT']);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $RefundError, $responseMsg);
				return false;
			}
		}

		public function DoVoid($orderId, $transactionId, &$message = '')
		{
			$nvpArray = $this->GetResponseFromPaypal($transactionId, 'V', $orderId);
			if(empty($nvpArray)) {
				$message = GetLang('ErrorConnectToPaypal');
				return false;
			}

			if(isset($nvpArray['DUPLICATE']) && $nvpArray['DUPLICATE'] == 1) {
				$message = GetLang('VoidDuplicateTransaction');

			} elseif($nvpArray['RESULT'] == 0) {

				$message = GetLang('VoidSuccess');

				$updatedOrder = array(
					'ordpaymentstatus' => 'voided',
					'ordpayproviderid' => $nvpArray['PNREF'],
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('orders', $updatedOrder, "orderid='".(int)$orderId."'");


				$voidSuccess = sprintf(GetLang('VoidSuccessLog'), $orderId, $nvpArray['PNREF'], $message);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $voidSuccess);
				return true;

			} else {
				$responseMsg = '';
				if(isset($nvpArray['RESPMSG'])) {
					$responseMsg = $nvpArray['RESPMSG'];
				}
				$message = sprintf(GetLang('VoidFailed'), $responseMsg);

				$VoidError = sprintf(GetLang('VoidError'), $orderId, $nvpArray['RESULT']);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $VoidError, $responseMsg);
				return false;
			}
		}

		private function GetResponseFromPaypal($transactionId, $transactionType, $orderId, $extraFields = array())
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
			// Arrange the data into name/value pairs ready to send
			$pp_array = array (
				'USER'		=> $merchant['userid'],
				'PWD'		=> $merchant['password'],
				'VENDOR'	=> $merchant['vendorid'],
				'PARTNER'	=> $merchant['partnerid'],
				'TRXTYPE'	=> $transactionType,
				'TENDER'	=> 'C',  // C - Direct Payment using credit card
				'ORIGID'	=> $transactionId, //PNREF
			);

			$pp_array = array_merge($pp_array, $extraFields);
			$paypal_query = '';
			foreach ($pp_array as $key => $value) {
				$paypal_query .= $key.'['.strlen($value).']='.$value.'&';
			}
			$paypal_query = rtrim($paypal_query, '&');

			$result = $this->_ConnectToProvider($transactionURL, $transactionURI, $paypal_query, $orderId.time());
			$nvpArray = $this->_DecodePaypalResult($result);

			return $nvpArray;
		}
	}
?>