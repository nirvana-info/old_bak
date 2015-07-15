<?php

	class CHECKOUT_EWAY extends ISC_CHECKOUT_PROVIDER
	{
		/**
		 * @var boolean Does this provider require SSL to be enabled?
		 */
		public $requiresSSL = true;

		/**
		 * @var boolean Does this provider support orders from more than one vendor?
		 */
		protected $supportsVendorPurchases = true;

		/**
		 * @var boolean Does this provider support shipping to multiple addresses?
		 */
		protected $supportsMultiShipping = true;

		/**
		 * The constructor.
		 */
		public function __construct()
		{
			// Setup the required variables for the eWay checkout module
			parent::__construct();
			$this->SetName(GetLang('EWayName'));
			$this->SetImage('eway_logo.gif');
			$this->SetDescription(GetLang('EWayDesc'));
			$this->SetHelpText(sprintf(GetLang('EWayHelp'), $GLOBALS['ShopPath']));
		}

		/**
		 * Set the configuration options for this provider.
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

			$this->_variables['customerid'] = array(
				"name" => GetLang('EWayCustomerId'),
			   "type" => "textbox",
			   "help" => GetLang('EWayCustomerIdHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['testmode'] = array(
				"name" => GetLang('TestMode'),
			   "type" => "dropdown",
			   "help" => GetLang('EWayTestModeHelp'),
			   "default" => "no",
			   "required" => true,
			   "options" => array(
				GetLang('EWayTestModeNo') => "NO",
							  GetLang('EWayTestModeYes') => "YES"
				),
				"multiselect" => false
			);

			$this->_variables['requirecvn'] = array(
				"name" => GetLang('EWayRequireCardCode'),
				"type" => "dropdown",
				"help" => GetLang('EWayRequireCardCodeHelp'),
				"default" => "no",
				"required" => true,
				"options" => array(
					GetLang('EWayRequireCardCodeNo') => "NO",
					GetLang('EWayRequireCardCodeYes') => "YES"
				),
				"multiselect" => false
			);
		}

		/**
		 * Check if this checkout module can be enabled or not.
		 *
		 * @return boolean True if this module is supported on this install, false if not.
		 */
		public function IsSupported()
		{
			if(!GetConfig('UseSSL')) {
				$this->SetError(GetLang('EWayNoSSLError'));
			}

			if($this->HasErrors()) {
				return false;
			}
			else {
				return true;
			}
		}

		/**
		 * Generate the payment form to allow users to make a payment via this provider.
		 *
		 * @return string The generated payment form.
		 */
		public function ShowPaymentForm()
		{
			$GLOBALS['EWayMonths'] = "";
			$GLOBALS['EWayYears'] = "";

			for($i = 1; $i <= 12; $i++) {
				$stamp = mktime(0, 0, 0, $i, 15, isc_date("Y"));

				$i = str_pad($i, 2, "0", STR_PAD_LEFT);

				if(@$_POST['eway_ccexpm'] == $i) {
					$sel = 'selected="selected"';
				} else {
					$sel = "";
				}

				$GLOBALS['EWayMonths'] .= sprintf("<option %s value='%s'>%s</option>", $sel, $i, isc_date("M", $stamp));
			}

			for($i = isc_date("Y"); $i < isc_date("Y")+10; $i++) {

				if(@$_POST['eway_ccexpy'] == isc_substr($i, 2, 2)) {
					$sel = 'selected="selected"';
				} else {
					$sel = "";
				}

				$GLOBALS['EWayYears'] .= sprintf("<option %s value='%s'>%s</option>", $sel, isc_substr($i, 2, 2), $i);
			}

			$require_cvv2 = $this->GetValue("requirecvn");
			if($require_cvv2 == "YES") {
				if(isset($_POST['eway_cvn'])) {
					$GLOBALS['EWayCardCode'] = $_POST['eway_cvn'];
				}
				$GLOBALS['EWayHideCardCode'] = '';
			}
			else {
				$GLOBALS['EWayHideCardCode'] = 'none';
			}

			// Grab the billing details
			$billingDetails = $this->GetBillingDetails();

			$billingAddress = isc_html_escape($billingDetails['ordbillstreet1']);
			if ($billingDetails['ordbillstreet2'] != "") {
				$billingAddress .= " " . isc_html_escape($billingDetails['ordbillstreet2']);
			}
			$billingAddress .= ", ".isc_html_escape($billingDetails['ordbillsuburb']).", ".isc_html_escape($billingDetails['ordbillstate']);
			$billingAddress .= ", ".isc_html_escape($billingDetails['ordbillcountry']);

			$GLOBALS['EWayName'] = isc_html_escape($billingDetails['ordbillfirstname'].' '.$billingDetails['ordbilllastname']);
			$GLOBALS['EWayBillingAddress'] = $billingAddress;
			$GLOBALS['EWayBillingZip'] = $billingDetails['ordbillzip'];

			// Format the amount that's going to be going through the gateway
			$gatewayAmount = $this->GetGatewayAmount();
			$GLOBALS['OrderAmount'] = CurrencyConvertFormatPrice($gatewayAmount);

			// Was there an error validating the payment? If so, pre-fill the form fields with the already-submitted values
			if($this->HasErrors()) {
				$GLOBALS['EWayName'] = isc_html_escape($_POST['eway_name']);
				$GLOBALS['EWayNum'] = isc_html_escape($_POST['eway_ccno']);
				$GLOBALS['EWayBillingAddress'] = isc_html_escape($_POST['eway_ccaddress']);
				$GLOBALS['EWayBillingZip'] = isc_html_escape($_POST['eway_zip']);

				$eway_error = implode("<br />", $this->GetErrors());
				$eway_error = str_replace("Error: ", "", $eway_error);
				$eway_error = str_replace(" You have not been billed for this transaction.", "", $eway_error);
				$GLOBALS['EWayErrorMessage'] = $eway_error;
			}
			else {
				// Hide the error message box
				$GLOBALS['HideEWayError'] = "none";
			}

			// Collect their details to send through to eWay
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("eway");
			return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		/**
		 * Process and validate input from a payment form for this provider.
		 *
		 * @return boolean True if valid details and payment has been processed. False if not.
		 */
		public function ProcessPaymentForm()
		{
			// eWay needs HTTPS, so if it's not on then stop
			if(!strtolower($_SERVER['HTTPS']) == "on") {
				ob_end_clean();
				?>
					<script type="text/javascript">
						alert("<?php echo GetLang('EWayNoSSLError'); ?>");
						document.location.href="<?php echo $GLOBALS['ShopPath']; ?>/checkout.php?action=confirm_order";
					</script>
				<?php
				die();
			}

			$bill_firstname = "";
			$bill_lastname = "";
			$result = "";
			$error = false;

			$orders = $this->GetOrders();
			list(,$order) = each($orders);

			if(isset($_POST['eway_name']) && isset($_POST['eway_ccno']) && isset($_POST['eway_ccaddress']) && isset($_POST['eway_ccexpm']) && isset($_POST['eway_ccexpy']) && isset($_POST['eway_zip'])) {
				$ccname = $_POST['eway_name'];
				$ccnum = $_POST['eway_ccno'];
				$ccaddress = $_POST['eway_ccaddress'];
				$ccexpm = $_POST['eway_ccexpm'];
				$ccexpy = $_POST['eway_ccexpy'];
				$cczip = $_POST['eway_zip'];
				$cvn = $_POST['eway_cvn'];

				$billingDetails = $this->GetBillingDetails();

				$ccemail = $billingDetails['ordbillemail'];

				// Split the billing name up into firstname and last name
				$bill_details = explode(" ", $ccname);
				$bill_firstname = $bill_details[0];

				for($i = 1; $i < count($bill_details); $i++) {
					$bill_lastname .= $bill_details[$i] . " ";
				}

				$bill_lastname = trim($bill_lastname);

				// If the email address is empty they aren't logged in
				if(empty($ccemail)) {
					return false;
				}

				// Load the pending order
				$total = $this->GetGatewayAmount();

				// Multiply the total by 100 because it's in cents
				$total *= 100;

				// Load the eWay customer ID
				$eway_id = $this->GetValue("customerid");

				// Is eWay setup in test or live mode?
				if($this->GetValue('testmode') == 'YES') {
					if($this->GetValue('requirecvn') == 'YES') {
						$eWayUrl = 'https://www.eway.com.au/gateway_cvn/xmltest/testpage.asp';
					}
					else {
						$eWayUrl = 'https://www.eway.com.au/gateway/xmltest/testpage.asp';
					}

					// If we're in test mode them "hard code" the eWay customer ID and total to one that works in test mode
					$eway_id = "87654321";
					$ccnum = "4444333322221111";
					$total = 100;
				}
				else {
					if($this->GetValue('requirecvn') == 'YES') {
						$eWayUrl = 'https://www.eway.com.au/gateway/xmlpayment.asp';
					}
					else {
 						$eWayUrl = 'https://www.eway.com.au/gateway/xmlpayment.asp';
					}
				}

				$order_desc = sprintf(GetLang('YourOrderFrom'), $GLOBALS['StoreName']);

				// Build the XML for the shipping quote
				$xml = new SimpleXMLElement("<ewaygateway/>");
				$xml->addChild('ewayCustomerID', $eway_id);
				$xml->addChild('ewayTotalAmount', $total);
				$xml->addChild('ewayCustomerFirstName', $bill_firstname);
				$xml->addChild('ewayCustomerLastName', $bill_lastname);
				$xml->addChild('ewayCustomerEmail', $ccemail);
				$xml->addChild('ewayCustomerAddress', $ccaddress);
				$xml->addChild('ewayCustomerPostcode', $cczip);
				$xml->addChild('ewayCustomerInvoiceDescription', $order_desc);
				$xml->addChild('ewayCustomerInvoiceRef', $_COOKIE['SHOP_ORDER_TOKEN']);
				$xml->addChild('ewayCardHoldersName', $ccname);
				$xml->addChild('ewayCardNumber', $ccnum);
				$xml->addChild('ewayCardExpiryMonth', $ccexpm);
				$xml->addChild('ewayCardExpiryYear', $ccexpy);

				if ($this->GetValue('requirecvn') == 'YES') {
					$xml->addChild('ewayCVN', $cvn);
				}
				else {
					$xml->addChild('ewayCVN', '');
				}
				$xml->addChild('ewayTrxnNumber', $order['orderid']);
				$xml->addChild('ewayOption1', '');
				$xml->addChild('ewayOption2', '');
				$xml->addChild('ewayOption3', '');
				$ewayXML = $xml->asXML();

				$result = PostToRemoteFileAndGetResponse($eWayUrl, $ewayXML);

				if($result === false || $result == null) {
					$this->SetError("An error occured while trying to contact eWay.");
					return false;
				}

				// We received a response from eWay, let's see what it was
				try {
				$xml = new SimpleXMLElement($result);
				} catch (Exception $e) {
					$this->SetError("An error occured with the response from eWay.");
					return false;
				}


				$order_total = (string)$total;
				$eway_amount = (string)$xml->ewayReturnAmount;

				if((string)$xml->ewayTrxnStatus == "True") {

					// If we're in test mode then we don't need to check the amounts
					$eway_test_mode = $this->GetValue("testmode");

					// The transaction was successful, make sure it was for the right amount
					if($eway_test_mode == "YES" || ($order_total == $eway_amount) ) {
						// The order is valid, hook back into the checkout system's validation process
						ob_end_clean();
						$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->GetName()), GetLang('EWayLogSuccess'));
						$token = md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']);
						header(sprintf("Location:%s/finishorder.php?o=%s", $GLOBALS['ShopPathSSL'], $token));
						die();
					}
					else {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang('EWayLogErrorTotal'), sprintf(GetLang('EWayLogErrorTotalDesc'), $order['orderid'], $eway_amount, $order_total).print_r($xml, true));
						$this->SetError(GetLang('EWayPaymentMismatch'));
						return false;
					}
				}
				else {
					// Something went wrong, show the error message with the credit card form
					$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang('EWayLogErrorGeneral'), sprintf(GetLang('EWayLogErrorGeneralDesc'), $order['orderid'], (string)$xml->ewayTrxnError));
					$this->SetError(GetLang('EWayProcessingError'));
					return false;
				}
			}
			else {
				// Bad form details, try again
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), GetLang('EWayLogErrorGeneral'), sprintf(GetLang('EWayLogErrorGeneralDesc'), $order['orderid'], (string)$xml->ewayTrxnError));
				$this->SetError(GetLang('EWayProcessingError'));
				return false;
			}
		}

		/**
		 *	Verify the order.
		 *
		 * @return boolean True if the order has been verified successfully or false if not.
		 */
		public function VerifyOrderPayment()
		{
			// The *only* way someone can end up here is AFTER the order has ALREADY been validated, so we pass an MD5 has of the pending
			// order token in the $_GET array and compare that to the pending token, returning true if they are equal and false if not.
			if(isset($_COOKIE['SHOP_ORDER_TOKEN']) && isset($_GET['o']) && md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']) == $_GET['o']) {
				$this->SetPaymentStatus(1);
				return true;
			} else {
				return false;
			}
		}
	}

?>
