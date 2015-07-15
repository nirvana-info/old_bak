<?php

	function SetupSSLOptions()
	{
		// Some hosts do not set $_SERVER['HTTPS'], so the only way we can detect SSL urls is if
		// they set the SCRIPT_URI and it contains https://
		if(isset($_SERVER['SCRIPT_URI']) && substr($_SERVER['SCRIPT_URI'], 0, 8) == 'https://') {
			$_SERVER['HTTPS'] = 'on';
		}

		// Normalise $_SERVER['HTTPS']
		if(isset($_SERVER['HTTPS'])) {
			switch(strtolower($_SERVER['HTTPS'])) {
				case "true":
				case "on":
				case "1":
					$_SERVER['HTTPS'] = 'on';
					break;
				default:
					$_SERVER['HTTPS'] = 'off';
			}
		}
		else {
			$_SERVER['HTTPS'] = 'off';
		}

		$GLOBALS['ISC_CFG']['ShopPathNormal'] = GetConfig('ShopPath');
		// Is SSL enabled for the checkout process? If so setup the checkout links as such
		if(GetConfig('UseSSL')) {
			// Are we on a page that should use SSL?
			$ssl_pages = array (
				"account.php",
				"checkout.php",
				"eway.php",
				"login.php",
				"authorizenet.php",
				"cart.php"
			);

			$uri = explode("/", $_SERVER['PHP_SELF']);
			$page = $uri[count($uri)-1];

			/* added the below code for checking the cart url */
			$cartpage = strpos($_SERVER['REQUEST_URI'], '/cart');

			if (in_array($page, $ssl_pages) || $cartpage !== false) {
				$GLOBALS['ISC_CFG']['ShopPath'] = str_replace("http://", "https://", GetConfig('ShopPath'));
                # To reset the 'ShopPathNormal' variable to ssl the below line is added -- Baskaran.
                $GLOBALS['ISC_CFG']['ShopPathNormal'] = GetConfig('ShopPath');

				// If we're not accessing this page via HTTPS then we need to redirect the user to the HTTPS version
				if((!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") && $_SERVER['REQUEST_METHOD'] == "GET") {
					ob_end_clean();

					if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != '') {
						$location = $_SERVER['PATH_INFO'];
					}
					elseif(isset($_ENV['PATH_INFO']) && $_ENV['PATH_INFO'] != '') {
						$location = $_ENV['PATH_INFO'];
					}
					elseif(isset($_ENV['PHP_SELF']) && $_ENV['PHP_SELF'] != '') {
						$location = $_ENV['PHP_SELF'];
					}
					else {
						$location = $_SERVER['PHP_SELF'];
					}
					$location = basename($location);

					/* Added below code to redirect to cart.php page with secure URL */
					if ($cartpage !== false )
					{
						$location = "cart.php";
					}

					if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '') {
						$location .= "?".$_SERVER['QUERY_STRING'];
					}
					else if(isset($_ENV['QUERY_STRING']) && $_ENV['QUERY_STRING'] != '') {
						$location = "?".$_ENV['QUERY_STRING'];
					}
					header("Location: " . GetConfig('ShopPath') . '/' . $location);
					exit;
				}
			}

			$GLOBALS['ISC_CFG']['ShopPathSSL'] = str_replace("http://", "https://", GetConfig('ShopPath'));
		}
		else {
			$GLOBALS['ISC_CFG']['ShopPathSSL'] = GetConfig('ShopPath');
		}


		// If we're still on a HTTPS link (maybe this page requires it for a certain checkout module)
		// override the shop path with the HTTPS version
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
			$GLOBALS['ISC_CFG']['ShopPath'] = str_replace("http://", "https://", GetConfig('ShopPath'));
                # To reset the 'ShopPathNormal' variable to ssl the below line is added -- Baskaran.
                $GLOBALS['ISC_CFG']['ShopPathNormal'] = GetConfig('ShopPath');
            
		}

		// Now that the variables are stored in the config section, we just map them back to the existing globals we had
		$GLOBALS['ShopPath'] = GetConfig('ShopPath');
		$GLOBALS['ShopPathSSL'] = GetConfig('ShopPathSSL');
		$GLOBALS['ShopPathNormal'] = GetConfig('ShopPathNormal');
	}

?>