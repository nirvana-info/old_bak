<?php

	class CHECKOUT_AUTHORIZENET extends ISC_CHECKOUT_PROVIDER
	{
		/**
		 * @var boolean True if this checkout module requires SSL or not.
		 */
		protected $requiresSSL = true;

		/**
		 * @var boolean Does this provider support orders from more than one vendor?
		 */
		protected $supportsVendorPurchases = true;
		protected $supportsMultiShipping = true;

		/**
		 * The constructor.
		 */
		public function __construct()
		{
			// Setup the required variables for the Authorize.net checkout module
			parent::__construct();

			$this->SetName(GetLang('AuthorizeNetName'));
			$this->SetImage("authorizenet_logo.gif");
			$this->SetDescription(GetLang('AuthorizeNetDesc'));
			$this->SetHelpText(sprintf(GetLang('AuthorizeNetHelp'), $GLOBALS['ShopPath']));
		}

		/**
		 * Check to make sure all the critical dependencies are available
		 *
		 * @return boolean
		 **/
		public function IsSupported()
		{
			if (function_exists('curl_exec') && defined('CURL_VERSION_SSL')) {
				return true;
			}
			else if (in_array('ssl', stream_get_transports())) {
				return true;
			}
			else {
				$this->SetError(GetLang('AuthorizeNetSSLNotAvailable'));
				return false;
			}
		}

		/**
		 * Set up the configuration options for this module.
		 */
		public function SetCustomVars()
		{
			$this->_variables['displayname'] = array(
				"name" => GetLang('DisplayName'),
				"type" => "textbox",
				"help" => GetLang('DisplayNameHelp'),
				"default" => $this->GetName(),
				"required" => true
			);

			$this->_variables['merchantid'] = array(
				"name" => GetLang('AuthorizeNetApiLoginId'),
				"type" => "textbox",
				"help" => GetLang('AuthorizeNetMerchantIDHelp'),
				"default" => "",
				"required" => true
			);

			$this->_variables['transactionkey'] = array(
				"name" => GetLang('AuthorizeNetTransationKey'),
				"type" => "password",
				"help" => GetLang('AuthorizeNetTransactionKeyHelp'),
				"default" => "",
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
					GetLang('TransactionTypeSale') => "AUTH_CAPTURE",
					GetLang('TransactionTypeAuthorize') => "AUTH_ONLY"
				),
				"multiselect" => false
			);

			$this->_variables['testmode'] = array(
				"name" => GetLang('AuthorizeNetTestMode'),
				"type" => "dropdown",
				"help" => GetLang('AuthorizeNetTestModeHelp'),
				"default" => "no",
				"required" => true,
				"options" => array(
					GetLang('AuthorizeNetTestModeNo') => "NO",
					GetLang('AuthorizeNetTestModeYes') => "YES"
				),
				"multiselect" => false
			);

			$this->_variables['requirecvv2'] = array(
				"name" => GetLang('AuthorizeNetRequireCardCode'),
				"type" => "dropdown",
				"help" => GetLang('AuthorizeNetCardCodeHelp'),
				"default" => "no",
				"required" => true,
				"options" => array(
					GetLang('AuthorizeNetCardCodeNo') => "NO",
					GetLang('AuthorizeNetCardCodeYes') => "YES"
				),
				"multiselect" => false
			);
		}

		/**
		 * Generate the payment form to collect payment details and pass them back
		 * to the payment provider.
		 *
		 * @param $respons is used to display the error message of cc details for make an offer functionality in class.finalizeoffer.php -- Baskaran
		 * @return string The generated payment form.
		 */
		public function ShowPaymentForm($response = '')
		{
			// Authorize.net needs HTTPS, so if it's not on then stop
			if(!strtolower($_SERVER['HTTPS']) == "on") {
				ob_end_clean();
				?>
					<script type="text/javascript">
						alert("<?php echo GetLang('AuthorizeNetNoSSLError'); ?>");
						document.location.href="<?php echo $GLOBALS['ShopPath']; ?>/checkout.php?action=confirm_order";
					</script>
				<?php
				die();
			}

			$GLOBALS['AuthorizeNetMonths'] = "";
			$GLOBALS['AuthorizeNetYears'] = "";

			for($i = 1; $i <= 12; $i++) {
				$stamp = mktime(0, 0, 0, $i, 15, isc_date("Y"));

				$i = str_pad($i, 2, "0", STR_PAD_LEFT);

				if (@$_POST['AuthorizeNet_ccexpm'] == $i) {
					$sel = 'selected="selected"';
				} else {
					$sel = "";
				}

				$GLOBALS['AuthorizeNetMonths'] .= sprintf("<option %s value='%s'>%s</option>", $sel, $i, isc_date("M", $stamp));
			}

			for($i = isc_date("Y"); $i < isc_date("Y")+10; $i++) {

				if (@$_POST['AuthorizeNet_ccexpy'] == substr($i, 2, 2)) {
					$sel = 'selected="selected"';
				} else {
					$sel = "";
				}
				$GLOBALS['AuthorizeNetYears'] .= sprintf("<option %s value='%s'>%s</option>", $sel, substr($i, 2, 2), $i);
			}

			$require_cvv2 = $this->GetValue("requirecvv2");
			if($require_cvv2 == "YES") {
				if(isset($_POST['AuthorizeNet_cccode'])) {
					$GLOBALS['AuthorizeNetCCV2'] = (int)$_POST['AuthorizeNet_cccode'];
				}
				$GLOBALS['AuthorizeNetHideCVV2'] = '';
			}
			else {
				$GLOBALS['AuthorizeNetHideCVV2'] = 'none';
			}

			// Grab the billing details for the order
			$billingDetails = $this->GetBillingDetails();

			$GLOBALS['AuthorizeNetName'] = isc_html_escape($billingDetails['ordbillfirstname'].' '.$billingDetails['ordbilllastname']);
			$GLOBALS['AuthorizeNetBillingAddress'] = isc_html_escape($billingDetails['ordbillstreet1']);

			if($billingDetails['ordbillstreet2'] != "") {
				$GLOBALS['AuthorizeNetBillingAddress'] .= " " . isc_html_escape($billingDetails['ordbillstreet2']);
			}

			$GLOBALS['AuthorizeNetCity'] = isc_html_escape($billingDetails['ordbillsuburb']);

			if($billingDetails['ordbillstateid'] != 0 && GetStateISO2ById($billingDetails['ordbillstateid'])) {
				$GLOBALS['AuthorizeNetState'] = GetStateISO2ById($billingDetails['ordbillstateid']);
			}
			else {
				$GLOBALS['AuthorizeNetState'] = isc_html_escape($billingDetails['ordbillstate']);
			}

			$GLOBALS['AuthorizeNetBillingZip'] = isc_html_escape($billingDetails['ordbillzip']);

            if ($_SESSION['makeaoffer'] == "Yes") { # Baskaran
				if(isset($_COOKIE['SHOP_ORDER_TOKEN'])) {
					$token = $_COOKIE['SHOP_ORDER_TOKEN'];
					$cusquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]offers where ordtoken = '$token'");
					$cusrow = $GLOBALS['ISC_CLASS_DB']->Fetch($cusquery);
					$GLOBALS['AuthorizeNetName'] = isc_html_escape($cusrow['ordbillfirstname'].' '.$billingDetails['ordbilllastname']);
					$GLOBALS['AuthorizeNetBillingAddress'] = isc_html_escape($cusrow['ordbillstreet1']);

					if($cusrow['ordbillstreet2'] != "") {
						$GLOBALS['AuthorizeNetBillingAddress'] .= " " . isc_html_escape($cusrow['ordbillstreet2']);
					}

					$GLOBALS['AuthorizeNetCity'] = isc_html_escape($cusrow['ordbillsuburb']);

					if($cusrow['ordbillstateid'] != 0 && GetStateISO2ById($cusrow['ordbillstateid'])) {
						$GLOBALS['AuthorizeNetState'] = GetStateISO2ById($cusrow['ordbillstateid']);
					}
					else {
						$GLOBALS['AuthorizeNetState'] = isc_html_escape($cusrow['ordbillstate']);
					}

					$GLOBALS['AuthorizeNetBillingZip'] = isc_html_escape($cusrow['ordbillzip']);
				}
            }

			// Format the amount that's going to be going through the gateway
			$GLOBALS['OrderAmount'] = CurrencyConvertFormatPrice($this->GetGatewayAmount());

            $GLOBALS['EnablePay'] = '<script>setTimeout(function() {$("#submitButton").removeAttr("disabled");}, 10000);</script>';
			// Was there an error validating the payment? If so, pre-fill the form fields with the already-submitted values
			if($this->HasErrors() or $response != '') { # Baskaran
				$GLOBALS['AuthorizeNetName'] = isc_html_escape($_POST['AuthorizeNet_name']);
				$GLOBALS['AuthorizeNetNum'] = isc_html_escape($_POST['AuthorizeNet_ccno']);
				$GLOBALS['AuthorizeNetBillingAddress'] = isc_html_escape($_POST['AuthorizeNet_ccaddress']);
				$GLOBALS['AuthorizeNetCity'] = isc_html_escape($_POST['AuthorizeNet_cccity']);
				$GLOBALS['AuthorizeNetState'] = isc_html_escape($_POST['AuthorizeNet_ccstate']);
				$GLOBALS['AuthorizeNetBillingZip'] = isc_html_escape($_POST['AuthorizeNet_zip']);
				if ($_SESSION['makeaoffer'] == "Yes") {
                    $GLOBALS['AuthorizeNetErrorMessage'] = $response; # Baskaran
                }
                else {
				    $GLOBALS['AuthorizeNetErrorMessage'] = implode("<br />", $this->GetErrors());
                }
			}
			else {
				// Hide the error message box
				$GLOBALS['HideAuthorizeNetError'] = "none";
			}

			// Collect their details to send through to Authorize.NET


		if ($_SESSION['makeaoffer'] == "Yes")	
			{
				$GLOBALS['OrderAmount'] = $_SESSION['makeaoffertotal'];
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("authorizenetoffer");
			}
			else
			{
				$GLOBALS['OrderAmount'] = CurrencyConvertFormatPrice($this->GetGatewayAmount());
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("authorizenet");
			}

			//$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("authorizenet");
			return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		/**
		 * Process the details entered on the payment form.
		 *
		 * @return boolean True if valid details and payment has been processed. False if not.
		 */
		public function ProcessPaymentForm()
		{
			$bill_firstname = "";
			$bill_lastname = "";
			$result = "";
			$an_data = "";
			$an_uri = "/gateway/transact.dll";
			$error = false;

			$requiredFields = array(
				"AuthorizeNet_name",
				"AuthorizeNet_ccno",
				"AuthorizeNet_ccaddress",
				"AuthorizeNet_ccexpm",
				"AuthorizeNet_ccexpy",
				"AuthorizeNet_zip",
				"AuthorizeNet_cccity",
				"AuthorizeNet_ccstate"
			);

			$require_cvv2 = $this->GetValue("requirecvv2");
			if($require_cvv2 == "YES") {
				$requiredFields[] = "AuthorizeNet_cccode";
			}

			$missingFields = false;
			foreach($requiredFields as $field) {
				if(!isset($_POST[$field]) || !$_POST[$field]) {
					$missingFields = true;
				}
			}

			if(isset($_COOKIE['SHOP_ORDER_TOKEN']) && $missingFields == false) {
				$ccname = $_POST['AuthorizeNet_name'];
				$ccnum = $_POST['AuthorizeNet_ccno'];
				$ccaddress = $_POST['AuthorizeNet_ccaddress'];
				$cccity = $_POST['AuthorizeNet_cccity'];
				$ccstate = $_POST['AuthorizeNet_ccstate'];
				$ccexpm = $_POST['AuthorizeNet_ccexpm'];
				$ccexpy = $_POST['AuthorizeNet_ccexpy'];
				$ccexp = sprintf("%s%s", $ccexpm, $ccexpy);
				$cczip = $_POST['AuthorizeNet_zip'];

				if($require_cvv2 == "YES") {
					$cccode = $_POST['AuthorizeNet_cccode'];
				}

				// Split the billing name up into firstname and last name
				$bill_details = explode(" ", $ccname);

				for($i = 0; $i < count($bill_details)-1; $i++) {
					$bill_firstname .= $bill_details[$i] . " ";
				}

				$bill_firstname = trim($bill_firstname);
				$bill_lastname = $bill_details[count($bill_details)-1];

				// Load the Authorize.net merchant ID
				$merchant_id = $this->GetValue("merchantid");

				// Load the tranaction key
				$transaction_key = $this->GetValue("transactionkey");

				// Is Authorize.net setup in test or live mode?
				$test_mode = $this->GetValue("testmode");

				// Load the Authorize.net transaction Type
				$transactionType = $this->GetValue('transactiontype');

				if($test_mode == "YES") {
					$an_url = "https://test.authorize.net/gateway/transact.dll";
					$an_pp_url = "test.authorize.net";
				}
				else {
					$an_url = "https://secure.authorize.net/gateway/transact.dll";
					$an_pp_url = "secure.authorize.net";
				}

				$orders = $this->GetOrders();
				if(count($orders) == 1) {
					list(,$order) = each($orders);
					$invoiceNum = $order['orderid'];
				}
				else {
					$invoiceNum = '';
				}

				$orderIdArr = array_keys($orders);
				$orderIds = '#'.implode(', #', $orderIdArr);
				$orderIds2 = implode(',', $orderIdArr);
				//wirror_20110520
				$desc_sql = "SELECT GROUP_CONCAT(CONCAT('<', p.prodvendorprefix, '><', p.prodcode, '>') SEPARATOR ',') AS prod_desc
					     FROM [|PREFIX|]order_products op
					     INNER JOIN [|PREFIX|]products p ON (p.productid = op.ordprodid)
					     WHERE op.orderorderid IN ($orderIds2)
					     GROUP BY op.orderorderid
					     ORDER BY op.orderorderid ASC
					     ";
				$desc_result = $GLOBALS['ISC_CLASS_DB']->Query($desc_sql);
				$descs = array();
				while($desc = $GLOBALS['ISC_CLASS_DB']->Fetch($desc_result)){
					$descs[] = $desc['prod_desc'];
				}
				if(!empty($descs)){
					$more_desc = implode(',', $descs);
				}else{
					$more_desc = '';
				}
				$order_desc = sprintf(GetLang('YourOrderFrom'), $GLOBALS['StoreName']).' ('.$orderIds.')'.$more_desc;

				$orderIdArr = array_keys($orders);
				$orderIds = '#'.implode(', #', $orderIdArr);
				$orderIds2 = implode(',', $orderIdArr);
				//wirror_20110520
				$desc_sql = "SELECT GROUP_CONCAT(CONCAT(' ', p.prodvendorprefix, ' ', p.prodcode) SEPARATOR ',') AS prod_desc
					     FROM [|PREFIX|]order_products op
					     INNER JOIN [|PREFIX|]products p ON (p.productid = op.ordprodid)
					     WHERE op.orderorderid IN ($orderIds2)
					     GROUP BY op.orderorderid
					     ORDER BY op.orderorderid ASC
					     ";
				$desc_result = $GLOBALS['ISC_CLASS_DB']->Query($desc_sql);
				$descs = array();
				while($desc = $GLOBALS['ISC_CLASS_DB']->Fetch($desc_result)){
					$descs[] = $desc['prod_desc'];
				}
				if(!empty($descs)){
					$more_desc = implode(',', $descs);
				}else{
					$more_desc = '';
				}

				$order_desc = sprintf(GetLang('YourOrderFrom'), $GLOBALS['StoreName']).' ('.$orderIds.')'.$more_desc;
				// END of modification by KATE H. 20110524

				$addressDetails = $this->GetBillingDetails();
				$email = '';
				if(isset($addressDetails['ordbillemail'])) {
					$email = $addressDetails['ordbillemail'];
				}

				// Arrange the data into name/value pairs ready to send
				$an_values = array (
					"x_login"				=> $merchant_id,
					"x_version"				=> "3.1",
					"x_delim_char"			=> "|",
					"x_delim_data"			=> "true",
					"x_url"					=> "false",
					//"x_duplicate_window"	=> "28800",
					"x_duplicate_window"	=> "10",
					"x_type"				=> $transactionType,
					"x_method"				=> "CC",
					"x_tran_key"			=> $transaction_key,
					"x_relay_response"		=> "false",
					"x_card_num"			=> $ccnum,
					"x_exp_date"			=> $ccexp,
					'x_invoice_num'			=> $invoiceNum,
					"x_description"			=> $order_desc,
					"x_amount"				=> $this->GetGatewayAmount(),
					"x_first_name"			=> $bill_firstname,
					"x_last_name"			=> $bill_lastname,
					"x_address"				=> $ccaddress,
					"x_email"				=> $email,
					"x_city"				=> $cccity,
					"x_state"				=> $ccstate,
					"x_zip"					=> $cczip,
					"shop_order_token"		=> $_COOKIE['SHOP_ORDER_TOKEN']
				);

				$require_cvv2 = $this->GetValue("requirecvv2");
				if($require_cvv2 == "YES") {
					$an_values['x_card_code'] = $cccode;
				}

				// Merge the name/value pairs into a string
				foreach($an_values as $k=>$v) {
					$an_data .= sprintf("%s=%s&", $k, urlencode($v));
				}

				$an_data = rtrim($an_data, '&');

				$an_response = $this->ConnectToProvider($an_url, $an_pp_url, $an_data);
				if(!$an_response || empty($an_response)) {
					return false;
				}
				// Based on specific items in the array we can determine if the transaction was successful or not
				if($an_response[0] == 1) { // 1 is a success, 2 is declined and 3 is an error

					$extraInfo = '';
					$paymentStatus = '';

					if($transactionType == 'AUTH_ONLY') {
						$paymentStatus = 'authorized';
					} else if ($transactionType == 'AUTH_CAPTURE') {
						$paymentStatus = 'captured';
					}

					//store credit card number, used in refund transaction
					$cc_vars = array(
						"cc_ccno" => substr($ccnum, -4),
					);

					// Is there any existing extra info for the pending order?
					if($order['extrainfo'] != "") {
						$extraArray = @unserialize($order['extrainfo']);
						if(is_array($extraArray)) {
							$extraInfo = serialize(@array_merge($extraArray, $cc_vars));
						}
					}
					else {
						$extraInfo = serialize($cc_vars);
					}

					// Save the authorization key
					$updatedOrder = array(
						'ordpayproviderid' => $an_response[6],
						'ordpaymentstatus' => $paymentStatus,
						'extrainfo' => $extraInfo
					);

					$this->UpdateOrders($updatedOrder);

					$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->GetName()), sprintf(GetLang('AuthorizeNetSuccess'), $invoiceNum), print_r($updatedOrder, true));
					ob_end_clean();
					$token = md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']);
					header(sprintf("Location:%s/finishorder.php?o=%s", $GLOBALS['ShopPathSSL'], $token));
					die();
				}
				else {
					// Status was declined or error, show the response message as an error
					if($an_response[2] == 11) {
						$duplicateMessage = sprintf(GetLang('AuthorizeNetErrorDuplicate'), GetConfig('AdminEmail'));
						$this->SetError($duplicateMessage);
					}
					else {
						$this->SetError($an_response[3]);
					}

					if($an_response[0] == 2) {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), sprintf(GetLang('AuthorizeNetErrorDeclined'), $invoiceNum, $an_response[3]) , $an_response[3]);
					}
					else {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), sprintf(GetLang('AuthorizeNetErrorInvalid'), $invoiceNum, $an_response[3]), $an_response[3]);
					}
					return false;
				}
			}
			else {
				// Invalid Authorize.net response
				$this->SetError(GetLang('AuthorizeNetMissingFields'));
				return false;
			}
		}

		private function ConnectToProvider($an_url, $an_pp_url, $an_data)
		{
			$an_response = array();
			// Use Authorize.net's API to charge the credit card
			if(function_exists("curl_exec")) {
				// Use CURL if it's available
				$ch = @curl_init($an_url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $an_data);
				curl_setopt($ch, CURLOPT_TIMEOUT, 60);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

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

				if(curl_error($ch) != '') {
					$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang('AuthorizeNetErrorInvalid'), curl_error($ch));
					$this->SetError(GetLang('AuthorizeNetNotSupported'));
					$this->ShowPaymentForm();
					die();
				}
			}
			else if(function_exists("fsockopen")) {
				$header = "";
				$header .= "POST " . $an_url . " HTTP/1.0\r\n";
				$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
				$header .= "Content-Length: " . strlen($an_data) . "\r\n\r\n";

				if($fp = @fsockopen("ssl://" . $an_pp_url, 443, $errno, $errstr, 30)) {
					@fputs($fp, $header . $an_data);

					// Read the body data
					$result = "";
					$headerdone = false;

					while(!@feof($fp)) {
						$line = @fgets($fp, 1024);

						if(@strcmp($line, "\r\n") == 0) {
							// Read the header
							$headerdone = true;
						}
						else if($headerdone) {
							// Header has been read, read the contents
							$result .= $line;
						}
					}
				}
				else {
					$this->SetError(sprintf(GetLang('AuthorizeNetFSocketError'), $an_pp_url));
					return false;
				}
			}
			else {
				$this->SetError(GetLang('AuthorizeNetNotSupported'));
				return false;
			}

			// Check to see the we got a response
			if ($result == "") {
				$this->SetError(sprintf(GetLang('AuthorizeNetNoResult'), $an_pp_url));
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang('AuthorizeNetNoResultLogSubject'), sprintf(GetLang('AuthorizeNetNoResultLogMsg'), $an_url));
				return false;
			}

			$an_response = explode("|", $result);
			for ($i=0; $i<count($an_response); $i++) {
				$an_response[$i] = trim($an_response[$i], '"');
			}
			return $an_response;
		}

		/**
		 * Verify the order was successful on the "Thank you" page.
		 */
		public function VerifyOrderPayment()
		{
			if(isset($_COOKIE['SHOP_ORDER_TOKEN']) && isset($_GET['o']) && md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']) == $_GET['o']) {
				$this->SetPaymentStatus(PAYMENT_STATUS_PAID);
				return true;
			}
			else {
				return false;
			}
		}


		private function GetResponseFromProvider($transactionType, $extraFields=array())
		{
				// Load the Authorize.net merchant ID
			$merchant_id = $this->GetValue("merchantid");

			// Load the tranaction key
			$transaction_key = $this->GetValue("transactionkey");

			// Is Authorize.net setup in test or live mode?
			$test_mode = $this->GetValue("testmode");

			if($test_mode == "YES") {
				$an_url = "https://test.authorize.net/gateway/transact.dll";
				$an_pp_url = "test.authorize.net";
			}
			else {
				$an_url = "https://secure.authorize.net/gateway/transact.dll";
				$an_pp_url = "secure.authorize.net";
			}

			// Arrange the data into name/value pairs ready to send
			$an_values = array (
				"x_login"				=> $merchant_id,
				"x_version"				=> "3.1",
				"x_delim_char"			=> "|",
				"x_delim_data"			=> "true",
				"x_type"				=> $transactionType,
				"x_method"				=> "CC",
				"x_tran_key"			=> $transaction_key,
				"x_relay_response"		=> "false"
			);

			$an_values = array_merge($an_values, $extraFields);

			$an_data = '';
			// Merge the name/value pairs into a string
			foreach($an_values as $k=>$v) {
				$an_data .= sprintf("%s=%s&", $k, urlencode($v));
			}

			$an_data = rtrim($an_data, '&');
			$an_response = $this->ConnectToProvider($an_url, $an_pp_url, $an_data);
			return $an_response;
		}

		public function DelayedCapture($order, &$message = '', $amt=0)
		{
			if($amt == 0 || $amt > $order['ordgatewayamount']) {
				$message = GetLang('DelayedCaptureIncorrectAmount');
				return false;
			}

			$amt = number_format($amt, 2);
			$orderId = $order['orderid'];
			$transactionId = $order['ordpayproviderid'];

			$extraFields = array(
				"x_trans_id" => $transactionId,
			);

			$an_response = $this->GetResponseFromProvider("PRIOR_AUTH_CAPTURE", $extraFields);
			if(!$an_response || empty($an_response)) {
				$message = GetLang('ErrorConnectToProvider');
				return false;
			}
			// Based on specific items in the array we can determine if the transaction was successful or not
			if($an_response[0] == 1) { // 1 is a success, 2 is declined and 3 is an error

				//set the message that's displayed in the front end
				$message = GetLang('DelayedCaptureSuccess');


				// Save the authorization key
				$updatedOrder = array(
					'ordpaymentstatus' => 'captured'
				);

				//update the orders table with new transaction details
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('orders', $updatedOrder, "orderid='".(int)$orderId."'");


				//log the transaction in store logs
				$delayedCaptureSuccess = sprintf(GetLang('DelayedCaptureSuccessLog'), $orderId, $an_response[4]);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->GetName()), $delayedCaptureSuccess, $an_response[3]);

				return true;
			}
			else {
				//set the message that's displayed in the front end
				$message = sprintf(GetLang('DelayedCaptureFailed'), $an_response[3], $an_response[4]);

				//log the transaction in store logs
				$delayedCaptureError = sprintf(GetLang('DelayedCaptureError'), $orderId, $an_response[4]);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $delayedCaptureError, $an_response[3]);
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

			$extraInfo = @unserialize($order['extrainfo']);
			if(!isset($extraInfo['cc_ccno'])) {
				$message = GetLang('RefundMissingInfo');
				return false;
			}

			$ccnum = $extraInfo['cc_ccno'];

			$extraFields = array(
				'x_amount' => $amt,
				"x_trans_id" => $transactionId,
				'x_card_num' => $extraInfo['cc_ccno'],
				'x_invoice_num' => $orderId,
			);

			$an_response = $this->GetResponseFromProvider('CREDIT', $extraFields);
			if(!$an_response || empty($an_response)) {
				$message = GetLang('ErrorConnectToProvider');
				return false;
			}

			if($an_response[0] == 1) {

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

				//update the orders table with new transaction details
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('orders', $updatedOrder, "orderid='".(int)$orderId."'");


				$refundSuccess = sprintf(GetLang('RefundSuccessLog'), $orderId);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $refundSuccess);
				return true;

			} else {
				$responseMsg = '';
				$transid = '';
				if(isset($an_response[3])) {
					$responseMsg = $an_response[3];
				}
				if(isset($an_response[6])) {
					$transid = isc_html_escape($an_response[6]);
				}
				$message = sprintf(GetLang('RefundFailed'), $responseMsg, $transid);

				$RefundError = sprintf(GetLang('RefundError'), $orderId, $transid);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $RefundError, $responseMsg);
				return false;

			}
		}

		public function DoVoid($orderId, $transactionId, &$message = '')
		{
			$extraFields = array(
				"x_trans_id" => $transactionId
			);

			$an_response = $this->GetResponseFromProvider('VOID', $extraFields);
			if(!$an_response || empty($an_response)) {
				$message = GetLang('ErrorConnectToProvider');
				return false;
			}

			if($an_response[0] == 1) {

				$message = GetLang('VoidSuccess');

				$updatedOrder = array(
					'ordpaymentstatus'	=> 'void',
					'ordpayproviderid'	=> $an_response[6],
				);
				//update the orders table with new transaction details
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('orders', $updatedOrder, "orderid='".(int)$orderId."'");

				$voidSuccess = sprintf(GetLang('VoidSuccessLog'), $orderId, $an_response[6]);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment',  $this->GetName()), $voidSuccess);
				return true;

			} else {
				$responseMsg = '';
				$transid = '';
				if(isset($an_response[3])) {
					$responseMsg = $an_response[3];
				}
				if(isset($an_response[6])) {
					$transid = isc_html_escape($an_response[6]);
				}
				$message = sprintf(GetLang('VoidFailed'), $responseMsg, $transid);

				$voidError = sprintf(GetLang('VoidError'), $orderId, $transid);
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), $voidError, $responseMsg);
				return false;
			}
		}
	}
?>