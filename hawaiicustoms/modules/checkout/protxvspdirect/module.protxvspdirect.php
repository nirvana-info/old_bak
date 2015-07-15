<?php

	class CHECKOUT_PROTXVSPDIRECT extends ISC_GENERIC_CREDITCARD
	{

		private $simulatorTransactionURL = 'https://ukvpstest.protx.com';
		private $simulatorTransactionURI = '/vspgateway/service/vspdirect-register.vsp';


		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the Protx Vps Direct checkout module

			$this->_languagePrefix = "ProtxVspDirect";
			$this->_id = "checkout_vspdirect";
			$this->_image = "protx_logo.gif";

			parent::__construct();

			$this->requiresSSL = true;
			$this->_currenciesSupported = array("GBP");
			$this->_cardsSupported = array ('VISA','AMEX','MC', 'DINERS', 'DISCOVER', 'SOLO','MAESTRO','SWITCH','LASER');
			$this->_liveTransactionURL = 'https://ukvps.protx.com';
			$this->_testTransactionURL = 'https://ukvpstest.protx.com';
			$this->_liveTransactionURI = '/vspgateway/service/vspdirect-register.vsp';
			$this->_testTransactionURI = '/vspgateway/service/vspdirect-register.vsp';
			$this->_curlSupported = true;
			$this->_fsocksSupported = true;
		}

		/**
		* Custom variables for the checkout module. Custom variables are stored in the following format:
		* array(variable_id, variable_name, variable_type, help_text, default_value, required, [variable_options], [multi_select], [multi_select_height])
		* variable_type types are: text,number,password,radio,dropdown
		* variable_options is used when the variable type is radio or dropdown and is a name/value array.
		*/
		public function SetCustomVars()
		{
			$this->_variables['displayname'] = array("name" => GetLang('DisplayName'),
			   "type" => "textbox",
			   "help" => GetLang('DisplayNameHelp'),
			   "default" => $this->GetName(),
			   "required" => true
			);

			$this->_variables['vendorname'] = array("name" => GetLang($this->_languagePrefix.'VendorName'),
			   "type" => "textbox",
			   "help" => GetLang($this->_languagePrefix.'VendorNameHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['cardcode'] = array("name" => GetLang($this->_languagePrefix.'CardCode'),
			   "type" => "dropdown",
			   "help" => GetLang($this->_languagePrefix.'CardCodeHelp'),
			   "default" => "no",
			   "required" => true,
			   "options" => array(GetLang($this->_languagePrefix.'CardCodeNo') => "NO",
							  GetLang($this->_languagePrefix.'CardCodeYes') => "YES"
				),
				"multiselect" => false
			);

			$this->_variables['testmode'] = array("name" => GetLang($this->_languagePrefix.'TestMode'),
	   "type" => "dropdown",
			   "help" => GetLang($this->_languagePrefix.'TestModeHelp'),
			   "default" => "no",
			   "required" => true,
			   "options" => array(GetLang($this->_languagePrefix.'TestModeTest') => "TEST",
							  GetLang($this->_languagePrefix.'TestModeSimulator') => "SIMULATOR",
							  GetLang($this->_languagePrefix.'TestModeLive') => "LIVE"
				),
				"multiselect" => false
			);
		}

		public function ProcessPaymentForm()
		{
			$postData = $this->_Validate();

			if ($postData === false) {
				return false;
			}

			// Is setup in test or live mode?
			$this->_testmode = $this->GetValue("testmode") == "YES";

			$gateway_postdata = $this->_ConstructPostData($postData);


			if ($this->GetValue("testmode") == "TEST") {
				$transactionURL = $this->_testTransactionURL;
				$transactionURI = $this->_testTransactionURI;
			}
			else if ($this->GetValue("testmode") == "LIVE") {
				$transactionURL = $this->_liveTransactionURL;
				$transactionURI = $this->_liveTransactionURI;
			}
			else if ($this->GetValue("testmode") == "SIMULATOR") {
				$transactionURL = $this->simulatorTransactionURL;
				$transactionURI = $this->simulatorTransactionURI;
			}

			if ($this->_redirect) {
				$this->RedirectToProvider($transactionURL.$transactionURI,$gateway_postdata);
			}

			$result = $this->_ConnectToProvider($transactionURL, $transactionURI, $gateway_postdata);

			if (!$result) {
				$this->SetError(GetLang('CreditCardGatewayFail'));
				return false;
			}

			$this->_HandleResponse($result);
		}

		protected function _ConstructPostData($postData)
		{
			$transactionid	= $this->GetCombinedOrderId();
			$billingDetails = $this->GetBillingDetails();

			$ccname 		= $postData['name'];
			$cctype 		= $postData['cctype'];

			$ccissueno 		= $postData['ccissueno'];
			$ccissuedatem 	= $postData['ccissuedatem'];
			$ccissuedatey 	= $postData['ccissuedatey'];

			$ccnum 			= $postData['ccno'];
			$ccexpm 		= $postData['ccexpm'];
			$ccexpy 		= $postData['ccexpy'];
			$cccvd 			= $postData['cccvd'];

			$amount = number_format($this->GetGatewayAmount(),2,'.','');

			// Contstruct the POST data
			$vspdirect_post['VPSProtocol']		= '2.22';
			$vspdirect_post['TxType']			= 'PAYMENT';
			$vspdirect_post['Vendor'] 			= $this->GetValue("vendorname");
			$vspdirect_post['VendorTxCode'] 	= 'ISC-'.$transactionid;
			$vspdirect_post['Description'] 		= $transactionid;
			$vspdirect_post['CardType'] 		= $cctype;
			$vspdirect_post['CardNumber'] 		= $ccnum;

			if ($this->CardTypeHasIssueDate($cctype)) {
				$vspdirect_post['StartDate'] 	= $ccissuedatem . $ccissuedatey;
			}

			if ($this->CardTypeHasIssueNo($cctype)) {
				$vspdirect_post['IssueNumber'] 	= $ccissueno;
			}

			if ($this->CardTypeRequiresCVV2($cctype)) {
				$vspdirect_post['CV2'] 			= $cccvd;
			}

			$vspdirect_post['BillingAddress'] 	= $billingDetails['ordbillstreet1'] . " " . $billingDetails['ordbillstreet2'] . " " .
														$billingDetails['ordbillsuburb'] . " " . $billingDetails['ordbillstate'];
			$vspdirect_post['BillingPostCode'] 	= $billingDetails['ordbillzip'];

			$vspdirect_post['CardHolder'] 		= $ccname;
			$vspdirect_post['ExpiryDate'] 		= $ccexpm.$ccexpy;
			$vspdirect_post['Amount'] 			= $amount;

			$currency = GetDefaultCurrency();

			$vspdirect_post['Currency'] 		= $currency['currencycode'];

			return http_build_query($vspdirect_post);
		}

		protected function _HandleResponse($result)
		{
			$approved = 'NO';
			$response = explode("\n",$result);

			if (isset($response[1])) {
				$approved = explode("=", $response[1]);
				$approved = $approved[1];
			}

			if (isset($reponse[9])) {
				$trnAmount = explode("=", $response[9]);
				$trnAmount = urldecode($trnAmount[1]);
			}
			else {
				$trnAmount = 'Unknown';
			}

			$responseMessage = 'Undefined';

			if (isset($response[2])) {
				$responseMessage = explode("=", $response[2]);
				$responseMessage = urldecode($responseMessage[1]);
			}

			if(trim($approved) == "OK") {
				// The transaction was successful, make sure it was for the right amount
				$order_total = $this->GetGatewayAmount();

				settype($order_total, "double");
				settype($trnAmount, "double");

				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->GetName()), GetLang($this->_languagePrefix.'Success'));

				// The order is valid, hook back into the checkout system's validation process
				ob_end_clean();
				$token = md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']);
				header(sprintf("Location:%s/finishorder.php?o=%s", $GLOBALS['ShopPathSSL'], $token));
				die();

			} else {

				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), sprintf(GetLang($this->_languagePrefix.'Failure'), $approved, $responseMessage));
				// Something went wrong, show the error message with the credit card form
				$this->SetError(GetLang($this->_languagePrefix.'SomethingWentWrong').sprintf(" Error %s : %s", $approved, $responseMessage));
				return false;
			}
		}
	}

?>
