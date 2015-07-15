<?php

	/**
	*	Post to a remote file and return the response.
	*	Vars should be passed in URL format, i.e. x=1&y=2&z=3
	*/
	if(!defined('ISC_SAFEMODE')) {
		define('ISC_SAFEMODE', @ini_get('safemode'));
	}
	function PostToRemoteFileAndGetResponse($Path, $Vars="")
	{

		$result = null;

		if(function_exists("curl_exec")) {
			// Use CURL if it's available
			$ch = curl_init($Path);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			if (!ISC_SAFEMODE && ini_get('open_basedir') == '') {
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			}
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);

			// Setup the proxy settings if there are any
			if (GetConfig('HTTPProxyServer')) {
				curl_setopt($ch, CURLOPT_PROXY, GetConfig('HTTPProxyServer'));
				if (GetConfig('HTTPProxyPort')) {
					curl_setopt($ch, CURLOPT_PROXYPORT, GetConfig('HTTPProxyPort'));
				}
			}

			if (GetConfig('HTTPSSLVerifyPeer') == 0) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			}

			if($Vars != "") {
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $Vars);
			}
			$result = curl_exec($ch);
		}
		else {
			// Use fsockopen instead
			$Path = @parse_url($Path);
			if(!isset($Path['host']) || $Path['host'] == '') {
				return null;
			}
			if(!isset($Path['port'])) {
				$Path['port'] = 80;
			}
			if(!isset($Path['path'])) {
				$Path['path'] = '/';
			}
			if(isset($Path['query'])) {
				$Path['path'] .= "?".$Path['query'];
			}

			$fp = @fsockopen($Path['host'], $Path['port'], $errorNo, $error, 10);
			@stream_set_timeout($fp, 10);
			if(!$fp) {
				return null;
			}

			$headers = array();

			// If we have one or more variables, perform a post request
			if($Vars != '') {
				$headers[] = "POST ".$Path['path']." HTTP/1.0";
				$headers[] = "Content-Length: ".strlen($Vars);
			}
			// Otherwise, let's get.
			else {
				$headers[] = "GET ".$Path['path']." HTTP/1.0";
			}
			$headers[] = "Host: ".$Path['host'];
			$headers[] = "Connection: Close";

			if($Vars != '') {
				$headers[] = "\r\n".$Vars; // Extra CRLF to indicate the start of the data transmission
			}

			if(!@fwrite($fp, implode("\r\n", $headers))) {
				return false;
			}
			while(!@feof($fp)) {
				$result .= @fgets($fp, 12800);
			}
			@fclose($fp);

			// Strip off the headers. Content starts at a double CRLF.
			$result = explode("\r\n\r\n", $result, 2);
			$result = $result[1];
		}
		return $result;
	}

	/**
	* XML API Example: Make sure the user has access to the API
	* Returns the user's ID if successful
	*/
	$xml = "<xmlrequest>
		<username>fred</username>
		<usertoken>9baa79a5871a2bdaac7b437a5b7275a8daff88d9</usertoken>
		<requesttype>authentication</requesttype>
		<requestmethod>xmlapitest</requestmethod>
		<details>
		</details>
	</xmlrequest>";

	/**
	* XML API Example: Get a list of completed orders
	* where any field contains interspire.com
	*/
	$xml = "<xmlrequest>
		<username>fred</username>
		<usertoken>9baa79a5871a2bdaac7b437a5b7275a8daff88d9</usertoken>
		<requesttype>orders</requesttype>
		<requestmethod>GetOrders</requestmethod>
		<details>
			<searchQuery>@interspire.com</searchQuery>
		</details>
	</xmlrequest>";

	/**
	* XML API Example: Get a list of completed orders
	* that were placed in the last week where the total
	* amount of the order is $200 or more and any field
	* contains the search phrase "seinfield"
	*/
	$xml = "<xmlrequest>
		<username>john</username>
		<usertoken>9baa79a5871a2bdaac7b437a5b7275a8daff88d9</usertoken>
		<requesttype>orders</requesttype>
		<requestmethod>GetOrders</requestmethod>
		<details>
			<dateRange>week</dateRange>
			<totalFrom>200</totalFrom>
			<searchQuery>seinfield</searchQuery>
		</details>
	</xmlrequest>";

	/**
	* XML API Example: Get a list of customers from America where
	* any field contains "@interspire.com". Countries are defined
	* along with their numeric ID's in the countries table
	*/
	$xml = "<xmlrequest>
		<username>fred</username>
		<usertoken>9baa79a5871a2bdaac7b437a5b7275a8daff88d9</usertoken>
		<requesttype>customers</requesttype>
		<requestmethod>GetCustomers</requestmethod>
		<details>
				<searchQuery>@interspire.com</searchQuery>
				<country>226</country>
		</details>
	</xmlrequest>";

	/**
	* XML API Example: Get a list of products where the product name contains the
	* word "laserjet" and the price is under $1,000
	*/
	$xml = "<xmlrequest>
		<username>admin</username>
		<usertoken>a6e1efb0f8b737dc92801e9cbe0b355482af1c94</usertoken>
		<requesttype>products</requesttype>
		<requestmethod>GetProducts</requestmethod>
		<details>
			<priceTo>1000</priceTo>
		</details>
	</xmlrequest>";

	//header("Content-Type:text/xml");
	echo PostToRemoteFileAndGetResponse("http://127.0.0.1/xml.php", $xml);

?>
