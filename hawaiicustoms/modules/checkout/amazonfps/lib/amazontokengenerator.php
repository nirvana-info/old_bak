<?php

require_once('FPS/FPSSignatureHelper.class.php');
require_once('Crypt/HMAC.php');

class AmazonTokenCreator {
	
	public static $amazonfpsURL = 'https://fps.sandbox.amazonaws.com/';

	function process($type, $AWSAccessKeyID, $AWSSecretAccessKey)
	{
		$uniqueId = $type.'-ISC-'.microtime(true);

		// prepare the REST request array map
		$request = array(
				'Action' => 'InstallPaymentInstruction',
				'PaymentInstruction' => "MyRole == '".$type."' orSay 'Roles do not match';",
				'CallerReference' => $uniqueId,
				'TokenType' => 'Unrestricted',
		);

		$timestamp = gmdate("Y-m-d\TH:i:s\Z");
		$SERVICE_VERSION = "2007-01-08";
		$SIGNATURE_VERSION = "1";

		$array1 = array();
		$array1["Timestamp"] = $timestamp;
		$array1["Version"] = $SERVICE_VERSION;
		$array1["SignatureVersion"] = $SIGNATURE_VERSION;
		$array1["AWSAccessKeyId"] = $AWSAccessKeyID;

		$array = $request + $array1;

		$signiture = FPSSignatureHelper::generateSignature($AWSSecretAccessKey, $array);

		$sortedUrl = FPSSignatureHelper::sortedParams($array, true);

		$url = AmazonTokenCreator::$amazonfpsURL."?".$sortedUrl."&Signature=".urlencode($signiture);

		if(function_exists("curl_exec")) {
			// Use CURL if it's available
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			// Setup the proxy settings if there are any

			$response = curl_exec($ch);
			$xmlresponse = new SimpleXMLElement($response);
		}
	
		
		if (!empty($xmlresponse)) {
			//handle HTTP response. Fatal error if did not pass this step
			if($xmlresponse->Status == 'Success') {
				echo $type . ' ID : '.$xmlresponse->TokenId . "<br>";
			}
			else {
			  	//handle response (basic error handling
			  	echo "Fatal Error: <br> ";
				echo "Response: ". $xmlresponse->Errors->Error->Message ."<br>";
			}	
		}
	}
	
}

if (isset($_POST['accessKey']) && isset($_POST['accessSecret'])) {
	$aws = new AmazonTokenCreator();
	$aws->process('Caller',$_POST['accessKey'],$_POST['accessSecret']);
	$aws->process('Recipient',$_POST['accessKey'],$_POST['accessSecret']);	
}

?>

<form method="POST">

	Access ID : <input id="accessKey" name="accessKey"></input>
	Access Secret Key : <input id="accessSecret" name="accessSecret"></input>
	<input type="submit" value="Generate Tokens"></input>

</form>
