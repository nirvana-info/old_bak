<?php

	class CHECKOUT_PAYLEAP extends ISC_GENERIC_CREDITCARD
	{
		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the CynergyData checkout module
			$this->_languagePrefix = "PayLeap";
			$this->_id = "checkout_payleap";
			$this->_image = "logo.gif";

			parent::__construct();

			$this->requiresSSL = true;
			$this->_currenciesSupported = array('USD');
		//	$this->_cardsSupported = array ('VISA','AMEX','MC','DINERS','DISCOVER');

			$this->_liveTransactionURL = 'http://secure.payleap.com';
			$this->_testTransactionURL = 'http://test.payleap.com';
			$this->_liveTransactionURI = '/SmartPayments/transact.asmx/ProcessCreditCard';
			$this->_testTransactionURI = '/SmartPayments/transact.asmx/ProcessCreditCard';
			$this->_curlSupported = true;
			$this->_fsocksSupported = true;
			$this->cardCodeRequired = true;
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

			$this->_variables['username'] = array("name" => GetLang($this->_languagePrefix.'UserName'),
			   "type" => "textbox",
			   "help" => GetLang($this->_languagePrefix.'UserNameHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['password'] = array("name" => GetLang($this->_languagePrefix.'Password'),
			   "type" => "password",
			   "help" => GetLang($this->_languagePrefix.'PasswordHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['transtype'] = array("name" => GetLang($this->_languagePrefix.'TransactionType'),
			   "type" => "dropdown",
			   "help" => GetLang($this->_languagePrefix.'TransactionTypeHelp'),
			   "default" => "no",
			   "required" => true,
			   "options" => array(GetLang($this->_languagePrefix.'TransactionTypeSale') => "SALE",
							  GetLang($this->_languagePrefix.'TransactionTypeAuth') => "AUTH"
				),
				"multiselect" => false
			);

			$this->_variables['testmode'] = array(
				"name" => "Test Mode",
				"type" => "dropdown",
				"help" => GetLang("PayMateTestModeHelp"),
				"default" => "no",
				"required" => true,
				"options" => array(
					GetLang("PayMateTestModeNo") => "NO",
					GetLang("PayMateTestModeYes") => "YES"
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

			$username = $this->GetValue('username');
			$password = $this->GetValue('password');

			if ($this->GetValue('transtype') == "SALE") {
				$transtype = 'sale';
			}
			else {
				$transtype = 'auth';
			}

			$payLeapPostData['UserName'] = $username;
			$payLeapPostData['Password'] = $password;
			$payLeapPostData['TransType'] = $transtype;
			$payLeapPostData['CardNum'] = $ccnum;
			$payLeapPostData['ExpDate'] = $ccexpm.$ccexpy;
			$payLeapPostData['PNRef'] = '';
			$payLeapPostData['MagData'] = '';
			$payLeapPostData['NameOnCard'] = $ccname;
			$payLeapPostData['Amount'] = $amount;
			$payLeapPostData['InvNum'] = $this->GetCombinedOrderId();
			$payLeapPostData['Zip'] = $billingDetails['ordbillzip'];
			$payLeapPostData['Street'] = $billingDetails['ordbillstreet1'] . ' ' . $billingDetails['ordbillstreet2'];
			$payLeapPostData['CVNum'] = $cccvd;
			$payLeapPostData['ExtData'] = '';

			return http_build_query($payLeapPostData);
		}

		protected function _HandleResponse($result)
		{
			try {
			  $xml = @new SimpleXMLElement($result);
			} catch (Exception $e) {

				// Something went wrong, show the error message with the credit card form
				$this->SetError(GetLang($this->_languagePrefix.'SomethingWentWrong'). $result);
				return false;
			}

			$responseCode = $responseMessage = '';

			if (isset($xml->Result)) {
				$responseCode = (string)$xml->Result;
			}

			if (isset($xml->RespMSG)) {
				$responseMessage = (string)$xml->RespMSG;
			}

			if($responseCode == 0 && $responseMessage == 'Approved') {
				// The order is valid, hook back into the checkout system's validation process

				$updatedOrder = array(
					'ordpayproviderid' => (string)$xml->PNRef,
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

				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), sprintf(GetLang($this->_languagePrefix.'Failure'), $responseCode, $responseMessage));

				// Something went wrong, show the error message with the credit card form
				$this->SetError(GetLang($this->_languagePrefix.'SomethingWentWrong').sprintf(" %s : %s ", $responseCode, $responseMessage));
				return false;
			}
		}
	}

?>