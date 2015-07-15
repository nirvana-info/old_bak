<?php

class SIMPLEPAY_CLIENT
{
	private  $_awsAccessKeyId = null;
	private  $_awsSecretAccessKey = null;
	private  $_url = '';

	public function __construct($awsAccessKeyId, $awsSecretAccessKey, $testmode)
	{
		$this->_awsAccessKeyId = $awsAccessKeyId;
		$this->_awsSecretAccessKey = $awsSecretAccessKey;

		if ($testmode) {
			$this->_url = 'https://authorize.payments-sandbox.amazon.com/pba/paypipeline';
		}
		else { // LIVE
			$this->_url = 'https://authorize.payments.amazon.com/pba/paypipeline';
		}
	}

	public function pay(SimplePay_Pay $spay)
	{
		$parameters = array();
		$parameters['amount'] = $spay->getAmount();
		$parameters['description'] = $spay->getDescription();
		$parameters['referenceId'] = $spay->getReferenceId();

 		$paymentHash = md5($this->_awsAccessKeyId.$this->_awsSecretAccessKey.$spay->getReferenceId().$_COOKIE['SHOP_ORDER_TOKEN'].$spay->getAmount());

		$parameters['accessKey'] = $this->_awsAccessKeyId;
		$parameters['immediateReturn'] = 1;
		$parameters['returnUrl'] = $GLOBALS['ShopPathSSL'] . '/finishorder.php?sessionId='.$_COOKIE['SHOP_ORDER_TOKEN'].'&hash='.$paymentHash;
		$parameters['abandonUrl'] = 'http://www.google.com';
		$parameters['signature'] = $this->_signParameters($parameters, $this->_awsSecretAccessKey);

		$query = $this->_convertToString($parameters);

		header('Location: '.$this->_url.'?'.$query);
	}

	private function _convertToString(array $parameters)
	{
		$queryParameters = array();
		foreach ($parameters as $key => $value) {
			$queryParameters[] = $key . '=' . urlencode($value);
		}
		return implode('&', $queryParameters);
	}

	//
	// FROM AMAZON SAMPLE CODE
	// docs.amazonwebservices.com

	/**
	  * Computes RFC 2104-compliant HMAC signature for request parameters
	  * Implements AWS Signature, as per following spec:
	  *
	  * If Signature Version is 0, it signs concatenated Action and Timestamp
	  *
	  * If Signature Version is 1, it performs the following:
	  *
	  * Sorts all  parameters (including SignatureVersion and excluding Signature,
	  * the value of which is being created), ignoring case.
	  *
	  * Iterate over the sorted list and append the parameter name (in original case)
	  * and then its value. It will not URL-encode the parameter values before
	  * constructing this string. There are no separators.
	  */
	private function _signParameters(array $parameters, $key)
	{
		$signatureVersion = 1;
		$data = '';

		if (0 === $signatureVersion) {

		}
		elseif (1 === $signatureVersion) {
			uksort($parameters, 'strcasecmp');

			foreach ($parameters as $parameterName => $parameterValue) {
				$data .= $parameterName . $parameterValue;
			}
		}
		else {
			throw new Exception("Invalid Signature Version specified");
		}
		return $this->_sign($data, $key);
	}


	/**
	 * Computes RFC 2104-compliant HMAC signature.
	 */
	private function _sign($data, $key)
	{
		return base64_encode (
			pack("H*", sha1((str_pad($key, 64, chr(0x00))
			^(str_repeat(chr(0x5c), 64))) .
			pack("H*", sha1((str_pad($key, 64, chr(0x00))
			^(str_repeat(chr(0x36), 64))) . $data))))
		);
	}
}
