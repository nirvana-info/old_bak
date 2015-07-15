<?php

	class CHECKOUT_SECUREPAY extends ISC_GENERIC_CREDITCARD
	{
		/*
			Checkout class constructor
		*/
		public function __construct()
		{
			// Setup the required variables for the SecurePay checkout module
			$this->_languagePrefix = "SecurePay";
			$this->_id = "checkout_securepay";
			$this->_image = "securepay.gif";

			parent::__construct();

			$this->requiresSSL = true;
			$this->_currenciesSupported = array('AUD');

			$this->_cardsSupported = array ('VISA','MC');

			$this->_liveTransactionURL = 'https://www.securepay.com.au';
			$this->_testTransactionURL = 'https://www.securepay.com.au';
			$this->_liveTransactionURI = '/xmlapi/payment';
			$this->_testTransactionURI = '/test/payment';
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

			$this->_variables['password'] = array("name" => GetLang($this->_languagePrefix.'MerchantPassword'),
			   "type" => "password",
			   "help" => GetLang($this->_languagePrefix.'MerchantPasswordHelp'),
			   "default" => "",
			   "required" => true
			);

			$this->_variables['testmode'] = array("name" => GetLang($this->_languagePrefix.'TestMode'),
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
			// SecurePay accepts payments in cents

			$ccname 		= $postData['name'];
			$cctype 		= $postData['cctype'];

			$ccissueno 		= $postData['ccissueno'];
			$ccissuedatem 	= $postData['ccissuedatem'];
			$ccissuedatey 	= $postData['ccissuedatey'];

			$ccnum 			= $postData['ccno'];
			$ccexpm 		= $postData['ccexpm'];
			$ccexpy 		= $postData['ccexpy'];
			$cccvd 			= $postData['cccvd'];

			$transactionid	= $this->GetCombinedOrderId();

			switch ($postData['cctype']) {
				case 'VISA':
					$cctype = '6';
					break;
				case 'MC':
					$cctype = '5';
					break;
				case 'AMEX':
					$cctype = '2';
					break;
				case 'DINERS':
					$cctype = '3';
					break;
				default:
					$cctype = '0';
					break;
			}

			$timestamp = strftime("%Y%d%m%H%M%S000000%z");

			$amount = number_format($this->GetGatewayAmount()*100,0,'',''); // Transaction in cents

			$xml = '<?xml version="1.0" encoding="UTF-8"?>
					<SecurePayMessage>
						<MessageInfo>
							<messageID>'. md5($transactionid).'</messageID>
							<messageTimestamp>'.$timestamp.'</messageTimestamp>
							<timeoutValue>60</timeoutValue>
							<apiVersion>xml-4.2</apiVersion>
						</MessageInfo>
						<MerchantInfo>
							<merchantID>'.$this->GetValue("merchantid").'</merchantID>
							<password>'.$this->GetValue("password").'</password>
						</MerchantInfo>
						<RequestType>Payment</RequestType>
						<Payment>
							<TxnList count="1">
								<Txn ID="1">
									<txnType>0</txnType>
									<txnSource>23</txnSource>
									<amount>'.$amount.'</amount>
									<currency>AUD</currency>
									<purchaseOrderNo>'.$transactionid.'</purchaseOrderNo>
									<CreditCardInfo>
										<cardNumber>'.$ccnum.'</cardNumber>
										<expiryDate>'.$ccexpm.'/'.$ccexpy.'</expiryDate>
										<cardType>'.$cctype.'</cardType>
									</CreditCardInfo>
								</Txn>
				  			</TxnList>
			 			</Payment>
					</SecurePayMessage>';

			return $xml;
		}

		protected function _HandleResponse($result)
		{
			if (empty($result)) {
					$this->SetError(GetLang($this->_langaugePrefix).'ConnectionError');
					return false;
			}

			$xml = new SimpleXMLElement($result);

			$statusCode = $responseMessage = '';

			if (isset($xml) && !empty($xml)) {
				$statusCode = (string)$xml->Status->statusCode;
				$responseMessage = (string)$xml->Status->statusDescription;
			}

			if($statusCode == '000') {

				$approved = (string)$xml->Payment->TxnList->Txn->approved;

				if (strtoupper($approved) != 'YES') {
					$statusCode = (string)$xml->Payment->TxnList->Txn->responseCode;
					$responseMessage = (string)$xml->Payment->TxnList->Txn->responseText;

					// Something went wrong, show the error message with the credit card form
					$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), sprintf(GetLang($this->_languagePrefix.'Failure'), '000'.$approved.$statusCode, $responseMessage));
					$this->SetError(GetLang($this->_languagePrefix.'SomethingWentWrong').sprintf(" 000 %s : %s ", $approved.$statusCode, $responseMessage));
					return false;
				}

				$amount = (string)$xml->Payment->TxnList->Txn->amount;
				$orderid = (string)$xml->Payment->TxnList->Txn->txnID;

				$updatedOrder = array(
					'ordpayproviderid' => $orderid,
					'ordpaymentstatus' => 'captured'
				);

				if (number_format($this->GetGatewayAmount()*100,0,'','') != $amount) {
					$this->SetError(GetLang($this->_languagePrefix.'PaymentMismatch'));
					return false;
				}

				$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('payment', $this->GetName()), GetLang($this->_languagePrefix.'Success'));

				// The order is valid, hook back into the checkout system's validation process
				ob_end_clean();
				$token = md5(GetConfig('EncryptionToken').$_COOKIE['SHOP_ORDER_TOKEN']);
				header(sprintf("Location:%s/finishorder.php?o=%s", $GLOBALS['ShopPathSSL'], $token));
				die();
			}
			else {
				// Something went wrong, show the error message with the credit card form
				$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', $this->GetName()), sprintf(GetLang($this->_languagePrefix.'Failure'), $statusCode, $responseMessage));
				$this->SetError(GetLang($this->_languagePrefix.'SomethingWentWrong').sprintf(" %s : %s", $statusCode, $responseMessage));
				return false;
			}
		}
	}

?>