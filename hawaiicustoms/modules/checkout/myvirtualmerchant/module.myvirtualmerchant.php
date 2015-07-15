<?php

	class CHECKOUT_MYVIRTUALMERCHANT extends ISC_GENERIC_CREDITCARD
	{
		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the MyVirtualMerchant checkout module
			$this->_languagePrefix = "MyVirtualMerchant";
			$this->_id = "checkout_myvirtualmerchant";
			$this->_image = "vm_logo.jpg";

			parent::__construct();

			$this->requiresSSL = true;
			$this->_currenciesSupported = array('USD');

			$this->_liveTransactionURL = 'https://www.myvirtualmerchant.com';
			$this->_testTransactionURL = 'https://www.myvirtualmerchant.com';
			$this->_liveTransactionURI = '/VirtualMerchant/process.do';
			$this->_testTransactionURI = '/VirtualMerchant/process.do';
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
			$this->_variables['displayname'] = array("name" => GetLang($this->_languagePrefix.'DisplayName'),
			   "type" => "textbox",
			   "help" => GetLang('DisplayNameHelp'),
			   "default" => $this->GetName(),
			   "required" => true
			);

			$this->_variables['merchantid'] = array("name" => GetLang($this->_languagePrefix.'MerchantId'),
			   "type" => "textbox",
			   "help" => GetLang($this->_languagePrefix.'MerchantIdHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['userid'] = array("name" => GetLang($this->_languagePrefix.'UserId'),
			   "type" => "textbox",
			   "help" => GetLang($this->_languagePrefix.'UserIdHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['merchantpin'] = array("name" => GetLang($this->_languagePrefix.'MerchantPin'),
			   "type" => "textbox",
			   "help" => GetLang($this->_languagePrefix.'MerchantPinHelp'),
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

			$amount = ($this->GetGatewayAmount());

			$order_desc = sprintf(GetLang('YourOrderFrom'), $GLOBALS['StoreName']);

			$myvPostData['ssl_merchant_id'] 			= $this->GetValue('merchantid');
			$myvPostData['ssl_pin']			 			= $this->GetValue('merchantpin');
			$myvPostData['ssl_user_id'] 				= $this->GetValue('userid');
			$myvPostData['ssl_card_number'] 			= $ccnum;
			$myvPostData['ssl_exp_date'] 				= $ccexpm.$ccexpy;

			if ($this->GetValue('cardcode') == 'YES') {
				$myvPostData['ssl_cvv2cvc2_indicator'] 	= '1';
				$myvPostData['ssl_cvv2cvc2'] 			= $cccvd;
				$myvPostData['ssl_avs_zip'] 			= $billingDetails['ordbillzip'];
				$myvPostData['ssl_avs_address'] 		= $billingDetails['ordbillstreet1'];
				$myvPostData['ssl_address2'] 			= $billingDetails['ordbillstreet2'];
				$myvPostData['ssl_city'] 				= $billingDetails['ordbillsuburb'];
				$myvPostData['ssl_state'] 				= $billingDetails['ordbillstate'];
				$myvPostData['ssl_avs_zip'] 			= $billingDetails['ordbillzip'];
				$myvPostData['ssl_country'] 			= $billingDetails['ordbillcountry'];

			}

			$myvPostData['ssl_customer_code']	 		= '1111';
			$myvPostData['ssl_transaction_type'] 		= 'ccsale';
			$myvPostData['ssl_amount'] 					= $this->GetGatewayAmount();
			$myvPostData['ssl_salestax'] 				= '0';

			$myvPostData['ssl_show_form'] 				= 'false';
			$myvPostData['ssl_receipt_link_method'] 	= 'post';
			$myvPostData['ssl_result_format'] 			= 'ascii';

			return http_build_query($myvPostData);
		}

		protected function _HandleResponse($response)
		{
			$result = array();

  			$response = str_replace("\n", "&", $response);

  			parse_str($response, $result);

			$responseCode = $responseMessage = $ssl_result = '';

			if (isset($result['ssl_result'])) {
				$ssl_result = $result['ssl_result'];
			}

			if (isset($result['errorCode'])) {
				$responseCode = $result['errorCode'];
			}
			if (isset($result['errorMessage'])) {
				$responseMessage = $result['errorMessage'];
			}

			if ($responseMessage == '' && isset($result['ssl_result_message'])) {
				$responseMessage = $result['ssl_result_message'];
			}

			if($ssl_result == '0') {

				$updatedOrder = array(
					'ordpayproviderid' => $result['ssl_txn_id'],
					'ordpaymentstatus' => 'captured'
				);

				$this->UpdateOrders($updatedOrder);

				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->GetName()), GetLang($this->_languagePrefix.'Success'));

				// The order is valid, hook back into the checkout system's validation process
				ob_end_clean();
				$token = md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']);
				header(sprintf("Location:%s/finishorder.php?o=%s", $GLOBALS['ShopPathSSL'], $token));
				die();
			}
			else {

				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), sprintf(GetLang($this->_languagePrefix.'Failure'), $responseCode, $responseMessage));

				// Something went wrong, show the error message with the credit card form
				$this->SetError(GetLang($this->_languagePrefix.'SomethingWentWrong').sprintf(" %s : %s", $responseCode, $responseMessage));
				return false;
			}
		}
	}

?>