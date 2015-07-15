<?php
	// Include the application initialization files
	include_once(dirname(__FILE__) . "/../../../init.php");

	// Retrieve the XML sent in the HTTP POST request to the ResponseHandler
	if (isset($HTTP_RAW_POST_DATA)) {
		$xml_response = $HTTP_RAW_POST_DATA;
	} else {
		$xml_response = file_get_contents("php://input");
	}
	if (get_magic_quotes_gpc()) {
		$xml_response = stripslashes($xml_response);
	}

	// If this is not a post request we don't need to do anything
	if (empty($xml_response)) {
		$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('payment', 'checkout_googlecheckout'), 'Invalid request recieved from '.isc_html_escape($_SERVER['REMOTE_ADDR']));
		die();
	}

	error_reporting(E_ALL);
	ini_set('display_errors', 'on');

	require_once(dirname(__FILE__).'/class.handler.php');
	$handler = new GOOGLE_CHECKOUT_HANDLER($xml_response);

?>