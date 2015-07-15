<?php

	/*
		The Interspire Interspire Shopping Cart API. At the moment it only provides outbound
		functionality to get data out, however this will be expanded to an inbound
		API in future as mentioned in the internal product roadmap.

		@ author Mitchell Harper
		@ date December 2007
		@ copyright Interspire Pty. Ltd.
	*/

	include_once(dirname(__FILE__) . "/api/class.orders.api.php");
	include_once(dirname(__FILE__) . "/api/class.customers.api.php");
	include_once(dirname(__FILE__) . "/api/class.products.api.php");

	class API
	{

		/**
		* The XML request string
		*/
		var $_request = "";

		/**
		* A reference to the XML object
		*/
		var $_xml = null;

		/**
		* The user's account id
		*/
		var $_userid = 0;

		/**
		* The orders API
		*/
		var $_api_orders = null;

		/**
		* The customers API
		*/
		var $_api_customers = null;

		/**
		* The products API
		*/
		var $_api_products = null;

		/**
		* Constructor
		* The API's constructor checks we're running at least PHP 5 and
		* have the SimpleXML extension installed (comes with PHP 5 by default)
		*/
		function __construct($Request)
		{
			// Store the request XML as a local variable
			$this->_request = $Request;

			// Setup the API subclasses
			$this->SetupSubClasses();

			// Make sure the are running PHP 5 and have the SimpleXML extension loaded
			$this->CheckRequirements();

			// Make sure the XML request is in a valid format
			$this->CheckRequest();

			// Authenticate the user
			$this->_userid = $this->Authenticate();
		}

		/**
		* Setup the API subclasses from the includes/classes/api folder
		*/
		function SetupSubClasses()
		{
			$this->_api_orders = new API_ORDERS();
			$this->_api_customers = new API_CUSTOMERS();
			$this->_api_products = new API_PRODUCTS();
		}

		/**
		* Make sure the XML request's format is valid
		*/
		function CheckRequest()
		{
			if($this->_request != "") {

				// Store a refernece to the XML object
				$this->_xml = new SimpleXMLElement($this->_request);

				$required_options = array('username', 'usertoken', 'requesttype', 'requestmethod', 'details');

				foreach ($required_options as $option) {
					if (!isset($this->_xml->$option) || empty($this->_xml->$option)) {
						$this->BadRequest('The xml format you have sent is invalid');
					}
				}
			}
			else {
				$this->BadRequest('The xml format you have sent is invalid');
			}
		}

		/**
		* Make sure they are running PHP 5 and SimpleXML
		*/
		function CheckRequirements()
		{
			$version_check = version_compare(PHP_VERSION, '5.0.0');

			if($version_check < 0) {
				$this->BadRequest('Sorry, the XML-API requires PHP5 or higher to work. You have ' . PHP_VERSION);
			}

			if(!extension_loaded('SimpleXML')) {
				$this->BadRequest('The XML-API requires the SimpleXML extension to be loaded.');
			}
		}

		/**
		* Authenticate the user against the database
		*/
		function Authenticate()
		{
			$username = strval($this->_xml->username);
			$usertoken = strval($this->_xml->usertoken);

			$query = sprintf("select pk_userid from [|PREFIX|]users where lower(username)='%s' and lower(usertoken)='%s' and userstatus='1' and userapi='1'", $GLOBALS['ISC_CLASS_DB']->Quote($username),$GLOBALS['ISC_CLASS_DB']->Quote( $usertoken));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if(!$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$this->BadRequest('The user details you provided are incorrect or the user does not have access to the API XML.');
			}
			return $row['pk_userid'];
		}

		/**
		* Run the XML API request and return the required details
		*/
		function RunRequest()
		{
			switch(strtolower($this->_xml->requesttype)) {
				case "authentication": {
					$this->RunAuthRequest();
					break;
				}
				case "orders": {
					$response = $this->_api_orders->DoIt($this->_xml, $this->_xml->requestmethod);

					if(is_array($response)) {
						$this->ReturnRequest($response);
					}
					else {
						$this->BadRequest(sprintf("The orders API doesn't support the request method of '%s'", $this->_xml->requestmethod));
					}
					break;
				}
				case "customers": {
					$response = $this->_api_customers->DoIt($this->_xml, $this->_xml->requestmethod);

					if(is_array($response)) {
						$this->ReturnRequest($response);
					}
					else {
						$this->BadRequest(sprintf("The customers API doesn't support the request method of '%s'", $this->_xml->requestmethod));
					}
					break;
				}
				case "products": {
					$response = $this->_api_products->DoIt($this->_xml, $this->_xml->requestmethod);

					if(is_array($response)) {
						$this->ReturnRequest($response);
					}
					else {
						$this->BadRequest(sprintf("The products API doesn't support the request method of '%s'", $this->_xml->requestmethod));
					}
					break;
				}
				default: {
					$this->BadRequest('The XML API doesn\'t understand requests of type "' . $this->_xml->requesttype . '"');
				}
			}
		}

		/**
		* Run an authentication request
		*/
		function RunAuthRequest()
		{
			switch(strtolower($this->_xml->requestmethod)) {
				case "xmlapitest": {
					$this->ReturnRequest(array("userid" => $this->_userid));
					break;
				}
				default: {
					$this->BadRequest('The XML API doesn\'t understand authentication requests types of method "' . $this->_xml->requestmethod . '"');
				}
			}
		}

		/**
		* Return the response in the Interspire standard XML API format
		*/
		function ReturnRequest($output='')
		{
			$this->PrintHeader();
		?>
			<status>SUCCESS</status>
			<data><?php
					$xml_output = $this->CreateOutput($output);
					echo $xml_output . "\n";
				?>
			</data>
			<?php
			$this->PrintFooter();
		}

		/**
		* Formats return data into XML output
		*/
		function CreateOutput($output)
		{
			if (!is_array($output)) {
				return sprintf('%s', isc_html_escape($output)) . "\n";
			}

			$xml_output = '';
			foreach ($output as $name => $data) {
				if (is_numeric($name)) {
					$name = 'item';
				}
				$quoted_name = isc_html_escape($name);

				if (!is_array($data)) {
					$xml_output .= sprintf('<%s>%s</%s>', $quoted_name, isc_html_escape($data), $quoted_name);
					continue;
				}

				$xml_output .= sprintf('<%s>', $quoted_name);

				if (is_array($data)) {
					foreach ($data as $k => $v) {
						if (is_array($v)) {
							$xml_output .= '<item>' . CreateOutput($v) . '</item>';
							continue;
						}
						if (is_numeric($k)) {
							$k = 'item';
						}
						$k_quoted = isc_html_escape($k);
						$xml_output .= sprintf('<%s>%s</%s>', $k_quoted, isc_html_escape($v), $k_quoted);
					}
				}
				$xml_output .= sprintf('</%s>', $quoted_name);
			}

			return $this->FormatXML($xml_output);
		}

		/**
		* Format a string into XML elements
		*/
		function FormatXML($xml)
		{
			$xml = (string)$xml;
			$newxml = '';

			$len = strlen($xml);
			$tags = array();
			$InCData = false;
			$alphabet = array_merge(range('a','z'), range('A','Z'), range('0', '9'), range(0, 9));
			$numbers = range('0', '9');

			for($char=0;$char < $len; ++$char) {

				if($xml[$char] == "<" && $InCData !== true && $xml[$char+1] != "?") {
					// starting some sort of tag!
					// is it a closing tag?!
					if($xml[$char+1] == "/") {
						// its a closing tag! for what tho?
						$num = 2;
						$tagName = '';
						while(in_array($xml[$char+$num], $alphabet, true) || (in_array((int)$xml[$char+$num], $numbers, true) && is_numeric($xml[$char+$num]))) {
							$tagName .= $xml[$char+$num];
							++$num;
						}

						// continue until the end of the tag
						while($xml[$char+$num] != '>') {
							++$num;
						}

						if($lastaction == "closed") {
							$newxml = $newxml . "\n". str_repeat("\t",max(count($tags)-1,0)).substr($xml, $char, $num+1);
						}else {
							$newxml = $newxml . substr($xml, $char, $num+1);
						}


						$char = $char + $num;

						if(in_array($tagName, $tags)) {
							// we need to kill the tag, but only the most recent one
							$size = count($tags);
							if($size > 0) {
								foreach($tags as $key=>$tmpTag) {
									if($tmpTag == $tagName) {
										$lastKey = $key;
									}
								}
								// $lastKey holds the tag we want to kill
								$tmpArray = array();
								foreach($tags as $key=>$tmpTag) {
									if($key != $lastKey) {
										$tmpArray[] = $tmpTag;
									}
								}
								$tags = $tmpArray;
							}
						}

					$lastaction = "closed";

					} elseif($xml[$char].$xml[$char+1].$xml[$char+2].$xml[$char+3].$xml[$char+4].$xml[$char+5].$xml[$char+6].$xml[$char+7].$xml[$char+8] == "<![CDATA[") {
						// its a cdata!
						$InCData = true; // don't need to do anything else
						$newxml = $newxml . $xml[$char];
						$lastaction = '';
					} else {
						// must be an opening tag...
						$num = 1;
						$tagName = '';
						while(in_array($xml[$char+$num], $alphabet, true) || (in_array((int)$xml[$char+$num], $numbers, true) && is_numeric($xml[$char+$num]))){
							$tagName .= $xml[$char+$num];
							++$num;
						}
						$owntag = false;

						// continue until the end of the tag, make sure its not a single one
						while($xml[$char+$num] != '>'){
							if($xml[$char+$num].$xml[$char+$num+1] == "/>") {
								// self contained tag! don't add it
								$owntag = true;
								break;
							}
							++$num;
						}

						if(!$owntag) {

							$newxml = $newxml."\n".str_repeat("\t",count($tags)). substr($xml, $char, $num+1);

							$tags[] = $tagName;

							$char = $char + $num;
						}else {
							$newxml = $newxml."\n".str_repeat("\t",count($tags)). substr($xml, $char, $num+2) ;
							$char = $char + $num + 1;
						}
						$lastaction = 'opened';

					}

				}elseif($InCData === true && $xml[$char-2].$xml[$char-1].$xml[$char] == "]]>") {
					$newxml = $newxml . '>';
					$InCData = false;
				}else {
					$newxml = $newxml . $xml[$char];
				}

			}
			return $newxml;
		}

		/**
		* PrintHeader
		* Output the XML
		*/
		function PrintHeader()
		{
			header("Content-Type: text/xml");
			$datenow = isc_date("r");

			echo '<';
			?>?xml version="1.0" encoding="<?php echo GetConfig("CharacterSet"); ?>" ?>
			<response>
			<?php
		}

		function PrintFooter()
		{
			echo "</response>\n";
			exit;
		}

		/**
		* BadRequest
		* Returns a 'bad request' error message in xml format.
		*/
		function BadRequest($error='')
		{
			$this->PrintHeader();
		?>
			<status>FAILED</status>
			<errormessage>
				<?php echo isc_html_escape($error) . "\n"; ?>
			</errormessage>
		<?php
			$this->PrintFooter();
			die();
		}




	}

?>
