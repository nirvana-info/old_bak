<?php

	class CHECKOUT_NETBILLING extends ISC_GENERIC_CREDITCARD
	{
		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the NetBilling checkout module
			$this->_languagePrefix = "NetBilling";
			$this->_id = "checkout_netbilling";
			$this->_image = "netbilling.png";

			parent::__construct();

			$this->requiresSSL = true;
			$this->_currenciesSupported = array('USD');

			$this->_liveTransactionURL = 'https://secure.netbilling.com:1402';
			$this->_testTransactionURL = 'http://secure.netbilling.com:1401';
			$this->_liveTransactionURI = '/gw/sas/direct3.1';
			$this->_testTransactionURI = '/gw/sas/direct3.1';
			$this->_curlSupported = true;
			$this->_fsocksSupported = true;
			$this->requireHeaders = true;
		}

		/**
		* Custom variables for the checkout module. Custom variables are stored in the following format:
		* array(variable_id, variable_name, variable_type, help_text, default_value, required, [variable_options], [multi_select], [multi_select_height])
		* variable_type types are: text,number,password,radio,dropdown
		* variable_options is used when the variable type is radio or dropdown and is a name/value array.
		*/
		public function SetCustomVars()
		{
			$this->_variables['displayname'] = array("name" => GetLang($this->_languagePrefix."DisplayName"),
			   "type" => "textbox",
			   "help" => GetLang('DisplayNameHelp'),
			   "default" => $this->GetName(),
			   "required" => true
			);

			$this->_variables['merchantid'] = array("name" => GetLang($this->_languagePrefix."MerchantId"),
			   "type" => "textbox",
			   "help" => GetLang($this->_languagePrefix.'MerchantIdHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['seccode'] = array("name" => GetLang($this->_languagePrefix."SecurityCode"),
			   "type" => "textbox",
			   "help" => GetLang($this->_languagePrefix.'SecurityCodeHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['cardcode'] = array("name" => GetLang($this->_languagePrefix."CardCode"),
			   "type" => "dropdown",
			   "help" => GetLang($this->_languagePrefix.'CardCodeHelp'),
			   "default" => "no",
			   "required" => true,
			   "options" => array(GetLang($this->_languagePrefix.'CardCodeNo') => "NO",
							  GetLang($this->_languagePrefix.'CardCodeYes') => "YES"
				),
				"multiselect" => false
			);

			$this->_variables['testmode'] = array("name" => GetLang($this->_languagePrefix."TestMode"),
			   "type" => "dropdown",
			   "help" => GetLang($this->_languagePrefix.'TestModeHelp'),
			   "default" => "no",
			   "required" => true,
			   "options" => array(GetLang($this->_languagePrefix.'TestModeNo') => "NO",
							  GetLang($this->_languagePrefix.'TestModeYes') => "YES"
				),
				"multiselect" => false
			);
		}


		protected function _ConstructPostData($postData)
		{
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

			$netBillingPostData['account_id']	 	= '110006559149'; // $this->GetValue('merchantid');
			$netBillingPostData['tran_type'] 		= "S";
			$netBillingPostData['amount'] 			= $this->GetGatewayAmount();
			$netBillingPostData['description'] 		= 'Payment for order';
			$netBillingPostData['dynip_sec_code'] 	= $this->GetValue('seccode');

			$netBillingPostData['pay_type'] 		= "C";
			$netBillingPostData['card_number'] 		= $ccnum;
			$netBillingPostData['card_expire'] 		= $ccexpm . $ccexpy;
			$netBillingPostData['card_cvv2'] 		= $cccvd;

			$netBillingPostData['bill_name1'] 		= $billingDetails['ordbillfirstname'];
			$netBillingPostData['bill_name2'] 		= $billingDetails['ordbilllastname'];
			$netBillingPostData['bill_street'] 		= $billingDetails['ordbillstreet1'];
			$netBillingPostData['bill_zip'] 		= $billingDetails['ordbillzip'];
			$netBillingPostData['bill_country'] 	= $billingDetails['ordbillcountry'];

			if ($this->GetValue('cardcode') == 'YES') {
				$netBillingPostData['disable_cvv2'] = 0;
			}
			else {
				$netBillingPostData['disable_cvv2'] = 1;
			}

			return http_build_query($netBillingPostData);
		}

		protected function _HandleResponse($result)
		{
			$response = array();
			parse_str($result, $response);

			if (count($response) == 1) {
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), sprintf(GetLang($this->_languagePrefix.'Failure'), '', $result));
				$this->SetError(sprintf("Something went wrong. Error %s", $result));
				return false;
			}

			$approved = 0;

			$status_code 	= $result['status_code'];
			$trans_id 		= $result['trans_id'];
			$auth_code 		= $result['auth_code'];
			$auth_date		= $result['auth_date'];
			$auth_msg 		= $result['auth_msg'];
			$avs_code 		= $result['avs_code'];
			$cvv2_code 		= $result['cvv2_code'];

			// Taken from the Sample Netbilling php class
			// If transaction was declined, check the auth message and allow retry or no retry
			// Add auth messages to the switch statement as necessary

			if($status_code == '0' || $status_code == 'F') {
				if($auth_msg == 'BAD ADDRESS') {
					$response_msg = "Invalid Address";
				}
				else if($auth_msg == 'CVV2 MISMATCH') {
					$response_msg = "Invalid CVV2";
				}
				else if($auth_msg == 'A/DECLINED') {
					$response_msg = "You have tried too many times.  Please contact support.";
				}
				else if($auth_msg == 'B/DECLINED') {
					$response_msg = "Please contact support.";
				}
				else if($auth_msg == 'C/DECLINED') {
					$response_msg = "Please contact support.";
				}
				else if($auth_msg == 'E/DECLINED') {
					$response_msg = "Your email address is invalid.";
				}
				else if($auth_msg == 'J/DECLINED') {
					$response_msg = "Your information is invalid.  Please correct";
				}
				else if($auth_msg == 'L/DECLINED') {
					$response_msg = "Invalid Address";
				}
				else {
					$response_msg = "Your card was declined.  Please try again.";
				}
			}
			else if($status_code == 'D') {
				$response_msg = "Duplicate transaction.  Please contact support";
			}
			else if ($status_code == '') {
			}
			else {
				$response_msg = "Your transaction was approved";
				$approved = 1;
			}

			if ($approved) {

				$updatedOrder = array(
					'ordpayproviderid' => $trans_id,
					'ordpaymentstatus' => 'captured'
				);

				$this->UpdateOrders($updatedOrder);

				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->GetName()), GetLang($this->_languagePrefix.'Success'));

				ob_end_clean();
				$token = md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']);
				header(sprintf("Location:%s/finishorder.php?o=%s", $GLOBALS['ShopPathSSL'], $token));
				die();
			}
			else {

				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), sprintf(GetLang($this->_languagePrefix.'Failure'), $auth_msg, $response_msg));

				$this->SetError(sprintf("Something went wrong. Error %s : %s", $auth_msg, $response_msg));
				return false;
			}
		}
	}

?>