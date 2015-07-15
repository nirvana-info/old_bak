<?php

	class CHECKOUT_PLUGNPAY extends ISC_GENERIC_CREDITCARD
	{
		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the PayJunction checkout module
			$this->_languagePrefix = "PlugNPay";
			$this->_id = "checkout_plugnpay";
			$this->_image = "plugnpay.gif";

			parent::__construct();

			$this->requiresSSL = true;
			$this->_currenciesSupported = array('USD');
		//	$this->_cardsSupported = array ('VISA','AMEX','MC','DINERS','DISCOVER');

			$this->_liveTransactionURL = 'https://pay1.plugnpay.com';
			$this->_testTransactionURL = 'https://pay1.plugnpay.com';
			$this->_liveTransactionURI = '/payment/pnpremote.cgi';
			$this->_testTransactionURI = '/payment/pnpremote.cgi';
			$this->_curlSupported = true;
			$this->_fsocksSupported = true;
			$this->supportsMultiShipping = true;
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

			$this->_variables['accountname'] = array("name" => GetLang($this->_languagePrefix.'AccountName'),
			   "type" => "textbox",
			   "help" => GetLang($this->_languagePrefix.'AccountNameHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['accountpassword'] = array("name" => GetLang($this->_languagePrefix.'AccountPassword'),
			   "type" => "password",
			   "help" => GetLang($this->_languagePrefix.'AccountPasswordHelp'),
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

			$billingDetails = $this->GetBillingDetails();


			$data['publisher-name'] 	= $this->GetValue('accountname');
			$data['mode'] 				= 'auth';
			$data['ipaddress'] 			= $_SERVER['REMOTE_ADDR'];
			$data['convert'] 			= 'underscores';
			$data['authtype'] 			= 'authpostauth';
			$data['paymethod']			= 'credit';
			$data['dontsndmail'] 		= 'yes';
			$data['shipinfo'] 			= 1;
			$data['easycart'] 			= 1;

			$data["email"] 				= $billingDetails['ordbillemail'];
			$data["address1"]			= $billingDetails['ordbillstreet1'];
			$data["address2"] 			= $billingDetails['ordbillstreet2'];
			$data["city"] 				= $billingDetails['ordbillsuburb'];
			$data["state"]	 			= $billingDetails['ordbillstate'];
			$data["zip"] 				= $billingDetails['ordbillzip'];
			$data["country"] 			= $billingDetails['ordbillcountry'];

			$data["card-number"] 		= $ccnum;
			$data["card-name"] 			= $ccname;
			$data["card-amount"] 		= $amount;
			$data["card-exp"] 			= $ccexpm . $ccexpy;
			$data["cc-cvv"] 			= $cccvd;



			return http_build_query($data);
		}

		protected function _HandleResponse($result)
		{
			$response = array();
			parse_str($result, $response);

			$responseMessage = $responseCode = '';

			if (isset($response['FinalStatus'])) {
				$responseCode = $response['FinalStatus'];
			}

			if (isset($response['MErrMsg'])) {
				$responseMessage = $response['MErrMsg'];
			}

			if($responseCode == 'success') {

				$updatedOrder = array(
					'ordpayproviderid' => $response['orderID'],
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

				if ($responseMessage == '') {
					$responseMessage = GetLang($this->_languagePrefix.'UnknownError');
				}
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), sprintf(GetLang($this->_languagePrefix.'Failure'), $responseCode, $responseMessage));

				// Something went wrong, show the error message with the credit card form
				$this->SetError(GetLang($this->_languagePrefix.'SomethingWentWrong').sprintf(" %s : %s ", $responseCode, $responseMessage));
				return false;
			}
		}
	}

?>