<?php

	class CHECKOUT_PAYFLOWPRO extends ISC_CHECKOUT_PROVIDER
	{

		/*
			Does this payment provider require SSL?
		*/
		protected $requiresSSL = true;

		/*
			Should the order be passed through in test mode?
		*/
		private $_testmode = "";

		/**
		 * @var boolean Does this provider support orders from more than one vendor?
		 */
		protected $supportsVendorPurchases = true;


		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the Payflow Pro checkout module
			parent::__construct();

			$this->_name = GetLang('PayflowProName');
			$this->_image = "paypal_logo.gif";
			$this->_description = GetLang('PayflowProDesc');
			$this->_help = sprintf(GetLang('PayflowProHelp'), $GLOBALS['ShopPath']);
			$this->_file = basename(__FILE__);
		}


		/*
		 * Check if this checkout module can be enabled or not.
		 *
		 * @return boolean True if this module is supported on this install, false if not.
		 */
		public function IsSupported()
		{
			$errors = array();
			if(!function_exists("curl_exec")) {
				$this->SetError(GetLang('PayflowProCurlRequired'));
			}

			if(!$this->HasErrors()) {
				return true;
			}
			else {
				return false;
			}
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
				"name" => GetLang('PayflowProVendorID'),
				"type" => "textbox",
				"help" => GetLang('PayflowProVendorIDHelp'),
				"default" => "",
				"savedvalue" => array(),
				"required" => true
			);

			$this->_variables['userid'] = array(
				"name" => GetLang('PayflowProUserID'),
				"type" => "textbox",
				"help" => GetLang('PayflowProUserIDHelp'),
				"default" => "",
				"savedvalue" => array(),
				"required" => true
			);

			$this->_variables['password'] = array(
				"name" => GetLang('PayflowProPassword'),
				"type" => "password",
				"help" => GetLang('PayflowProPasswordHelp'),
				"default" => "",
				"savedvalue" => array(),
				"required" => true
			);


			$this->_variables['partnerid'] = array(
				"name" => GetLang('PayflowProPartnerID'),
				"type" => "textbox",
				"help" => GetLang('PayflowProPartnerIDHelp'),
				"default" => "",
				"savedvalue" => array(),
				"required" => true
			);


			$this->_variables['requirecvv2'] = array(
				"name" => GetLang('RequireSecurityCode'),
				"type" => "dropdown",
				"help" => GetLang('PayflowProSecurityCodeHelp'),
				"default" => "no",
				"savedvalue" => array(),
				"required" => true,
				"options" => array(
					GetLang('PayflowProSecurityCodeNo') => "NO",
					GetLang('PayflowProSecurityCodeYes') => "YES"
				),
				"multiselect" => false
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

			$this->_variables['testmode'] = array(
				"name" => "Test Mode",
				"type" => "dropdown",
				"help" => GetLang('PayflowProTestModeHelp'),
				"default" => "no",
				"savedvalue" => array(),
				"required" => true,
				"options" => array(
					GetLang('PayflowProTestModeNo') => "NO",
					GetLang('PayflowProTestModeYes') => "YES"
				),
				"multiselect" => false
			);
		}

		/**
		* ShowPaymentForm
		* Show a payment form for this particular gateway if there is one.
		* This is useful for gateways that require things like credit card details
		* to be submitted and then processed on the site.
		*/
		public function ShowPaymentForm()
		{
			$GLOBALS['PayflowProMonths'] = "";
			$GLOBALS['PayflowProYears'] = "";

			for($i = 1; $i <= 12; $i++) {
				$stamp = mktime(0, 0, 0, $i, 15, isc_date("Y"));

				$i = str_pad($i, 2, "0", STR_PAD_LEFT);

				if (@$_POST['PayflowPro_ccexpm'] == $i) {
					$sel = "SELECTED";
				} else {
					$sel = "";
				}

				$GLOBALS['PayflowProMonths'] .= sprintf("<option %s value='%s'>%s</option>", $sel, $i, isc_date("M", $stamp));
			}

			for($i = isc_date("Y"); $i < isc_date("Y")+10; $i++) {

				if (@$_POST['PayflowPro_ccexpy'] == substr($i, 2, 2)) {
					$sel = 'selected="selected"';
				} else {
					$sel = "";
				}
				$GLOBALS['PayflowProYears'] .= sprintf("<option %s value='%s'>%s</option>", $sel, substr($i, 2, 2), $i);
			}


			$requireCVV2 = $this->GetValue("requirecvv2");
			if($requireCVV2 == "YES") {
				if(isset($_POST['PayflowPro_cccode'])) {
					$GLOBALS['PayflowProCCV2'] = (int)$_POST['PayflowPro_cccode'];
				}
				$GLOBALS['PayflowProHideCVV2'] = '';
			}
			else {
				$GLOBALS['PayflowProHideCVV2'] = 'none';
			}

			// Grab the billing details for the order
			$billingDetails = $this->GetBillingDetails();

			$GLOBALS['PayflowProName'] = isc_html_escape($billingDetails['ordbillfirstname'].' '.$billingDetails['ordbilllastname']);
			$GLOBALS['PayflowProBillingAddress'] = isc_html_escape($billingDetails['ordbillstreet1']);

			if($billingDetails['ordbillstreet2'] != "") {
				$GLOBALS['PayflowProBillingAddress'] .= " " . isc_html_escape($billingDetails['ordbillstreet2']);
			}

			$GLOBALS['PayflowProCity'] = isc_html_escape($billingDetails['ordbillsuburb']);

			if($billingDetails['ordbillstateid'] != 0 && GetStateISO2ById($billingDetails['ordbillstateid'])) {
				$GLOBALS['PayflowProState'] = GetStateISO2ById($billingDetails['ordbillstateid']);
			}
			else {
				$GLOBALS['PayflowProState'] = isc_html_escape($billingDetails['ordbillstate']);
			}

			$GLOBALS['PayflowProCountry'] = GetCountryList($billingDetails['ordbillcountry'], false);

			$GLOBALS['PayflowProBillingZip'] = $billingDetails['ordbillzip'];


			// Format the amount that's going to be going through the gateway
			$GLOBALS['OrderAmount'] = FormatPrice($this->GetGatewayAmount());


			// Was there an error validating the payment? If so, pre-fill the form fields with the already-submitted values
			if($this->HasErrors()) {
				$GLOBALS['PayflowProName'] = isc_html_escape($_POST['PayflowPro_name']);
				$GLOBALS['PayflowProNum'] = isc_html_escape($_POST['PayflowPro_ccno']);
				$GLOBALS['PayflowProBillingAddress'] = isc_html_escape($_POST['PayflowPro_ccaddress']);
				$GLOBALS['PayflowProCity'] = isc_html_escape($_POST['PayflowPro_cccity']);
				$GLOBALS['PayflowProState'] = isc_html_escape($_POST['PayflowPro_ccstate']);
				$GLOBALS['PayflowProBillingZip'] = isc_html_escape($_POST['PayflowPro_zip']);
				$GLOBALS['PayflowProErrorMessage'] = implode("<br />", $this->GetErrors());
				$GLOBALS['PayflowProCountry'] = GetCountryList(isc_html_escape($_POST['PayflowPro_country']), false);
			}
			else {
				// Hide the error message box
				$GLOBALS['HidePayflowProError'] = "none";
			}

			// Collect their details to send through to Payflow Pro
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("payflowpro");
			return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
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
			$billfirstname = "";
			$billlastname = "";
			$error = false;

			$requiredFields = array(
				"PayflowPro_name"		=> GetLang('PayflowProEnterName'),
				"PayflowPro_ccno"		=> GetLang('PayflowProEnterCardNumber'),
				"PayflowPro_ccaddress"	=> GetLang('PayflowProEnterBillingAddress'),
				"PayflowPro_ccexpm"		=> GetLang('PayflowProEnterCreditCardMonth'),
				"PayflowPro_ccexpy"		=> GetLang('PayflowProEnterCreditCardYear'),
				"PayflowPro_zip"		=> GetLang('PayflowProEnterPostcode'),
				"PayflowPro_cccity"		=> GetLang('PayflowProEnterCity'),
				"PayflowPro_ccstate"	=> GetLang('PayflowProEnterState'),
				"PayflowPro_country"	=> GetLang('PayflowProEnterCountry')
			);

			$requireCVV2 = $this->GetValue("PayflowProEnterCVV2Number");
			if($requireCVV2 == "YES") {
				$requiredFields['PayflowPro_cccode'] = GetLang('PayflowProCreditCardCCV2');
			}

			foreach($requiredFields as $field => $message) {
				if(!isset($_POST[$field]) || trim($_POST[$field]) == '') {
					$this->SetError($message);
					return false;
				}
			}
			$currentMY = isc_mktime(0, 0, 0, isc_date('m')+1, 0, isc_date('y'));
			$cardMY = isc_mktime(0, 0, 0, $_POST['PayflowPro_ccexpm']+1, 0, $_POST['PayflowPro_ccexpy']);
			if ($currentMY > $cardMY) {
				$this->SetError(GetLang('PayflowProCreditCardExpired').isc_date('m/y', $currentMY)." - ".isc_date('m/y', $cardMY));
				return false;
			}

			if(isset($_COOKIE['SHOP_ORDER_TOKEN'])) {

				$ccname = $_POST['PayflowPro_name'];
				$ccnum = $_POST['PayflowPro_ccno'];
				$ccaddress = $_POST['PayflowPro_ccaddress'];
				$cccity = $_POST['PayflowPro_cccity'];
				$ccstate = $_POST['PayflowPro_ccstate'];
				$ccexpm = $_POST['PayflowPro_ccexpm'];
				$ccexpy = $_POST['PayflowPro_ccexpy'];
				$ccexp = sprintf("%s%s", $ccexpm, $ccexpy);
				$cczip = $_POST['PayflowPro_zip'];
				$cccode = $_POST['PayflowPro_cccode'];
				$cccountry = $_POST['PayflowPro_country'];

				$query = "Select currencycode from [|PREFIX|]currencies Where currencyid = '".$GLOBALS['ISC_CLASS_DB']->Quote(GetConfig('DefaultCurrencyID'))."'";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$currency = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

				// Split the billing name up into firstname and last name
				$billdetails = explode(" ", $ccname);

				for($i = 0; $i < count($billdetails)-1; $i++) {
					$billfirstname .= $billdetails[$i] . " ";
				}

				$billfirstname = trim($billfirstname);
				$billlastname = $billdetails[count($billdetails)-1];

				$orders = $this->GetOrders();
				$orderIds = '#'.implode(', #', array_keys($orders));


				// Load the paypal vendor ID
				$vendorid = $this->GetValue('vendorid');

				// Load the paypal partner ID
				$partnerid = $this->GetValue('partnerid');

				// Load the paypal partner ID
				$userid = $this->GetValue('userid');

				// Load the paypal password
				$password = $this->GetValue('password');

				// Is payflow setup in test or live mode?
				$testmode = $this->GetValue('testmode');

				// Load the paypal transaction Type
				$transactionType = $this->GetValue('transactiontype');

				if($testmode == 'YES') {
					$payflowprourl = 'https://pilot-payflowpro.paypal.com';
				}
				else {
					$payflowprourl = 'https://payflowpro.paypal.com';
				}

				$custip = GetIP();

				$orderdesc = sprintf(GetLang('YourOrderFrom'), $GLOBALS['StoreName']);


				// Fetch the customer details
				$query = sprintf("SELECT * FROM [|PREFIX|]customers WHERE customerid='".$GLOBALS['ISC_CLASS_DB']->Quote($this->GetCustomerId())."'");
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$customer = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

				// Arrange the data into name/value pairs ready to send
				$pp_values = array (
					'USER'		=> $userid,
					'VENDOR'	=> $vendorid,
					'PARTNER'	=> $partnerid,
					'PWD'		=> $password,
					'TENDER'	=> 'C',  // C - Direct Payment using credit card
					'TRXTYPE'	=> $transactionType,  // A - Authorization, S - Sale
					'ACCT'		=> $ccnum,
					'CVV2'		=> $cccode,
					'EXPDATE'	=> $ccexp,
					'AMT'		=> number_format($this->GetGatewayAmount(), 2),
					'CURRENCY'	=> $currency,
					'FIRSTNAME'	=> $billfirstname,
					'LASTNAME'	=> $billlastname,
					'STREET'	=> $ccaddress,
					'CITY'		=> $cccity,
					'STATE'		=> $ccstate,
					'ZIP'		=> $cczip,
					'COUNTRY'	=> GetCountryISO2ById($cccountry),
					'EMAIL'		=> $customer['custconemail'],
					'CUSTIP'	=> $custip,
					'INVNUM'	=> $orderIds,
					'ORDERDESC'	=> $orderdesc,
					'VERBOSITY'	=> 'MEDIUM'
				);

				$paypal_query = '';
				foreach ($pp_values as $key => $value) {
					if ($key == 'USER') {
						  $paypal_query .= $key.'['.strlen($value).']='.$value;
					} else {
						  $paypal_query .= '&'.$key.'['.strlen($value).']='.$value;
					}
				}

				$nvpArray = $this->SendData($orderIds, $payflowprourl, $paypal_query);
				$_SESSION['PayflowResponse'] = $nvpArray;
				ob_end_clean();
				$token = md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']);
				header(sprintf("Location:%s/finishorder.php?o=%s", $GLOBALS['ShopPathSSL'], $token));
			}
			else {
				// Invalid payflow response
				$this->SetError(GetLang('PayflowProInvalidOrder'));
				return false;
			}
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
		private function SendData($orderid, $submiturl, $paypal_query)
		{
			if(function_exists("curl_exec")) {
				// get data ready for API
				$useragent = $_SERVER['HTTP_USER_AGENT'];
				$headers[] = "Content-Type: text/namevalue"; //or text/xml if using XMLPay.
				$headers[] = "Content-Length : ".strlen($paypal_query);  // Length of data to be passed
				$headers[] = "X-VPS-Timeout: 45";
				$headers[] = "X-VPS-Request-ID:" . $orderid;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $submiturl);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
				curl_setopt($ch, CURLOPT_HEADER, 1);                // tells curl to include headers in response
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        // return into a variable
				curl_setopt($ch, CURLOPT_TIMEOUT, 90);              // times out after 90 secs
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);        // this line makes it work under https
				curl_setopt($ch, CURLOPT_POSTFIELDS, $paypal_query);        //adding POST data
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);       //verifies ssl certificate
				curl_setopt($ch, CURLOPT_FORBID_REUSE, true);       //forces closure of connection when done
				curl_setopt($ch, CURLOPT_POST, 1); 									//data sent as POST

				// Try to submit the transaction up to 3 times with 5 second delay.  This can be used
				// in case of network issues.  The idea here is since posting via HTTPS there
				// could be general network issues, so try a few times before tells customer there
				// is an issue.
				$i=1;
				while ($i++ <= 3) {
					$result = curl_exec($ch);
					$headers = curl_getinfo($ch);
					if ($headers['http_code'] != 200) {
						sleep(5);  // Let's wait 5 seconds to see if its a temporary network issue.
					}
					else if ($headers['http_code'] == 200) {
						// we got a good response, drop out of loop.
						break;
					}
				}

				//validate a response from the server and/or timeout issues due to network.
				if ($headers['http_code'] != 200) {
					curl_close($ch);
					exit;
				}
				curl_close($ch);
				$result = strstr($result, "RESULT");
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
					$proArray[$keyval] = $valval;
					$result = substr($result,$valuepos+1,strlen($result));
				}
			}
			else {
				$this->SetError(GetLang('PayflowProCurlRequired'));
				// Show the payment form again
				$this->ShowPaymentForm();
				die();
			}
			 return $proArray;
		}

		/**
		*	Verify the order by checking the Payflow Pro variables
		*/
		public function VerifyOrder(&$PendingOrder)
		{
			// The *only* way someone can end up here is AFTER the order has ALREADY been validated, so we pass an MD5 has of the pending
			// order token in the $_GET array and compare that to the pending token, returning true if they are equal and false if not.
			if(isset($_COOKIE['SHOP_ORDER_TOKEN']) && isset($_GET['o']) && md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']) == $_GET['o']) {

				if (!isset($_SESSION['PayflowResponse'])) {
					return false;
				}

				$nvpArray = $_SESSION['PayflowResponse'];
				// unset payflow response in session
				foreach ($_SESSION['PayflowResponse'] as $key => $value) {
					unset($_SESSION['PayflowResponse'][$key]);
				}
				unset($_SESSION['PayflowResponse']);

				$responseCode = isc_html_escape($nvpArray['RESULT']);
				$responseMsg = isc_html_escape($nvpArray['RESPMSG']);
				$transactionId = 0;

				// Load the paypal transaction Type
				$transactionType = $this->GetValue('transactiontype');
				if($transactionType == 'A') {
					$fullTransType = 'authorized';
				} elseif ($transactionType == 'S') {
					$fullTransType = 'captured';
				}


				if (isset($nvpArray['PNREF'])) {
					$transactionId = isc_html_escape($nvpArray['PNREF']);
				}
				$success = true;
				$message = '';
				if ($responseCode == 0) {
					if (isset($nvpArray['AVSADDR']) && $nvpArray['AVSADDR'] != "Y") {
						$message = GetLang('AVSCheckFailed');
					}
					if (isset($nvpArray['AVSZIP']) && $nvpArray['AVSZIP'] != "Y") {
						$message = GetLang('AVSCheckFailed');
					}
					if (isset($nvpArray['CVV2MATCH']) && $nvpArray['CVV2MATCH'] != "Y") {
						$message = GetLang('CVV2CheckFailed');
					}
				} else {
					$success = false;
				}


				$orders = $this->GetOrders();
				$order = current($orders);
				$orderIds = '#'.implode(', #', array_keys($orders));

				if ($success == true) {
					$payflowProSuccess = sprintf(GetLang('PayflowProSuccess'), $orderIds, $transactionId, $responseCode, $responseMsg." ".$message);
					$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $payflowProSuccess, $message);

					$PendingOrder['paymentstatus'] = PAYMENT_STATUS_PAID;

					$updatedOrder = array(
						'ordpayproviderid' => $transactionId,
						'ordpaymentstatus' => $fullTransType,
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

						$updatedOrder['extrainfo'] = $extraInfo;
					}

					$this->UpdateOrders($updatedOrder);

					return true;
				} else {

					// Status was declined or error, show the response message as an error
					$payflowError = sprintf(GetLang('PayflowProError'), $orderIds, $transactionId, $responseCode, $responseMsg);
					switch ($responseCode) {

						case 12: // incorrect card number or expiry date
						case 23: // Invalid account number
						case 24: // Invalid expiration date
						case 50: // Insufficient funds available
							$PendingOrder['paymentstatus'] = 3;
							$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $payflowError);
							$this->RedirectToOrderConfirmation(GetLang('PayflowProDeclinedRedirect'));
							return true;
						case 13: // referral
							$PendingOrder['paymentstatus'] = 2;
							$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $payflowError);
							return true;
						default: // a system error or duplicate transactions
							$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $payflowError);
							return false;
					}
				}
			} else {
				return false;
			}
		}


		public function DelayedCapture($order, &$message = '', $amt = 0)
		{
			$orderId = $order['orderid'];
			$transactionId = $order['ordpayproviderid'];

			$amt = number_format($amt,2);
			$extraFields = array('AMT'=>$amt);


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


				$payflowProSuccess = sprintf(GetLang('DelayedCaptureSuccessLog'), $orderId, $nvpArray['PNREF'], $message);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $payflowProSuccess);
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


				$payflowProSuccess = sprintf(GetLang('RefundSuccessLog'), $orderId, $nvpArray['PNREF'], $message);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $payflowProSuccess);
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


				$payflowProSuccess = sprintf(GetLang('VoidSuccessLog'), $orderId, $nvpArray['PNREF'], $message);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $payflowProSuccess);
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
				// Load the paypal vendor ID
			$vendorid = $this->GetValue('vendorid');

			// Load the paypal partner ID
			$partnerid = $this->GetValue('partnerid');

			// Load the paypal partner ID
			$userid = $this->GetValue('userid');

			// Load the paypal password
			$password = $this->GetValue('password');

			// Is payflow setup in test or live mode?
			$testmode = $this->GetValue('testmode');

			if($testmode == 'YES') {
				$payflowprourl = 'https://pilot-payflowpro.paypal.com';
			}
			else {
				$payflowprourl = 'https://payflowpro.paypal.com';
			}


			// Arrange the data into name/value pairs ready to send
			$pp_values = array (
				'USER'		=> $userid,
				'VENDOR'	=> $vendorid,
				'PARTNER'	=> $partnerid,
				'PWD'		=> $password,
				'TENDER'	=> 'C',  // C - Direct Payment using credit card
				'TRXTYPE'	=> $transactionType,
				'ORIGID'	=> $transactionId, //PNREF
			);

			$pp_values = array_merge($pp_values, $extraFields);
			$paypal_query = '';
			foreach ($pp_values as $key => $value) {
				if ($key == 'USER') {
					  $paypal_query .= $key.'['.strlen($value).']='.$value;
				} else {
					  $paypal_query .= '&'.$key.'['.strlen($value).']='.$value;
				}
			}

			$nvpArray = $this->SendData($orderId.time(), $payflowprourl, $paypal_query);

			return $nvpArray;
		}

	}

?>