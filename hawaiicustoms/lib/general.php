<?php

// Search engine friendly links
define("CAT_LINK_PART", "categories");
define("PRODUCT_LINK_PART", "products");
define("BRAND_LINK_PART", "brands");
define("PRODUCTIMAGE_LINK_PART", "productimages");
define("INSTALLIMAGE_LINK_PART", "installimages");
define("PRODUCTVIDEO_LINK_PART", "productvideos");
define("INSTALLVIDEO_LINK_PART", "installvideos");
define("PRODUCTAUDIO_LINK_PART", "productaudios");



/**
 * Function to automatically load classes without explicitly having to require them in.
 * Classes will only be loaded when they're needed.
 *
 * For this to work certain conditions have to be met.
 * - All class names need to be uppercase
 * - File names have to be in the format of class.[lowercase class name]
 * - All front end classes need to be prefixed ISC_[UPPERCASE FILENAME]
 * - All admin classes need to be prefixed with ISC_ADMIN_[UPPERCASE_FILENAME]
 */
function __autoload($className)
{
	// We can only load the classes we know about
	if(substr($className, 0, 3) != "ISC") {
		return;
	}

	// Loading an administration class
	if(substr($className, 0, 9) == "ISC_ADMIN") {
		$class = explode("_", $className, 3);
		$fileName = strtolower($class[2]);
		$fileName = str_replace("_", ".", $fileName);
		$fileName = ISC_BASE_PATH."/admin/includes/classes/class.".$fileName.".php";
	}
	// Loading an entity class (customer, product, etc)
	else if (substr($className, 0, 10) == "ISC_ENTITY") {
		$class = explode("_", $className, 3);
		$fileName = strtolower($class[2]);
		$fileName = str_replace("_", ".", $fileName);
		$fileName = ISC_BASE_PATH."/lib/entities/entity.".$fileName.".php";
	}
	else {
		$class = explode("_", $className, 2);
		$fileName = strtolower($class[1]);
		$fileName = str_replace("_", ".", $fileName);
		$fileName = ISC_BASE_PATH."/includes/classes/class.".$fileName.".php";
	}

	if(file_exists($fileName)) {
		require_once $fileName;
	}
}

/**
 * Return an already instantiated (singleton) version of a class. If it doesn't exist, will automatically
 * be created.
 *
 * @param string The name of the class to load.
 * @return object The instantiated version fo the class.
 */
function GetClass($className)
{
	static $classes;
	if(!isset($classes[$className])) {
		$classes[$className] = new $className;
	}
	$class = &$classes[$className];
	return $class;
}

/**
 * Fetch a configuration variable from the store configuration file.
 *
 * @param string The name of the variable to fetch.
 * @return mixed The value of the variable.
 */
function GetConfig($config)
{
	if (array_key_exists($config, $GLOBALS['ISC_CFG'])) {
		return $GLOBALS['ISC_CFG'][$config];
	}
	return '';
}

/**
 * Load a library class and instantiate it.
 *
 * @param string The name of the library class (in the current directory) to load.
 * @return object The instantiated version of the class.
 */
function GetLibClass($file)
{
	static $libs = array();
	if (isset($libs[$lib_file])) {
		return $libs[$lib_file];
	} else {
		include_once(dirname(__FILE__).'/'.$file.'.php');
		$libs[$file] = new $file;
		return $libs[$file];
	}
}

/**
 * Load a library include file from the lib directory.
 *
 * @param string The name of the file to include (without the extension)
 */
function GetLib($file)
{
	$FullFile = dirname(__FILE__).'/'.$file.'.php';
	if (file_exists($FullFile)) {
		include_once($FullFile);
	}
}

/**
 * Convert a text string in to a search engine friendly based URL.
 *
 * @param string The text string to convert.
 * @return string The search engine friendly equivalent.
 */
function MakeURLSafe($val)
{
	$val = str_replace("-", "%2d", $val);
	$val = str_replace("+", "%2b", $val);
	$val = str_replace("+", "%2b", $val);
	$val = str_replace("/", "{47}", $val);
	$val = urlencode($val);
	$val = str_replace("+", "-", $val);
	return $val;
}

/**
 * Convert an already search engine friendly based string back to the normal text equivalent.
 *
 * @param string The search engine friendly version of the string.
 * @return string The normal textual version of the string.
 */
function MakeURLNormal($val)
{
	$val = str_replace("-", " ", $val);
	$val = urldecode($val);
	$val = str_replace("{47}", "/", $val);
	$val = str_replace("%2d", "-", $val);
	$val = str_replace("%2b", "+", $val);
	return $val;
}

/**
 * Return the current unix timestamp with milliseconds.
 *
 * @return float The time since the UNIX epoch in milliseconds.
 */
function microtime_float()
{
	list($usec, $sec) = explode(' ', microtime());
	return ((float)$usec + (float)$sec);
}

/**
 * Display the contents of a variable on the page wrapped in <pre> tags for debugging purposes.
 *
 * @param mixed The variable to print.
 * @param boolean Set to true to trim any leading whitespace from the variable.
 */
function Debug($var, $stripLeadingSpaces=false)
{
	echo "\n<pre>\n";
	if ($stripLeadingSpaces) {
		$var = preg_replace("%\n[\t\ \n\r]+%", "\n", $var);
	}
	if (is_bool($var)) {
		var_dump($var);
	} else {
		print_r($var);
	}
	echo "\n</pre>\n";
}

/**
 * Print a friendly looking backtrace up to the last execution point.
 *
 * @param boolean Do we want to stop all execution (die) after outputting the trace?
 * @param boolean Do we want to return the output instead of echoing it ?
 */
function trace($die=false, $return=true)
{
	$trace = debug_backtrace();
	$backtrace = "<table style=\"width: 100%; margin: 10px 0; border: 1px solid #aaa; border-collapse: collapse; border-bottom: 0;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
	$backtrace .= "<thead><tr>\n";
	$backtrace .= "<th style=\"border-bottom: 1px solid #aaa; background: #ccc; padding: 4px; text-align: left; font-size: 11px;\">File</th>\n";
	$backtrace .= "<th style=\"border-bottom: 1px solid #aaa; background: #ccc; padding: 4px; text-align: left; font-size: 11px;\">Line</th>\n";
	$backtrace .= "<th style=\"border-bottom: 1px solid #aaa; background: #ccc; padding: 4px; text-align: left; font-size: 11px;\">Function</th>\n";
	$backtrace .= "</tr></thead>\n<tbody>\n";

	// Strip off last item (the call to this function)
	array_shift($trace);

	foreach ($trace as $call) {
		if (!isset($call['file'])) {
			$call['file'] = "[PHP]";
		}
		if (!isset($call['line'])) {
			$call['line'] = "&nbsp;";
		}
		if (isset($call['class'])) {
			$call['function'] = $call['class'].$call['type'].$call['function'];
		}
		if(function_exists('textmate_backtrace')) {
			$call['file'] .= " <a href=\"txmt://open?url=file://".$call['file']."&line=".$call['line']."\">[Open in TextMate]</a>";
		}
		$backtrace .= "<tr>\n";
		$backtrace .= "<td style=\"font-size: 11px; padding: 4px; border-bottom: 1px solid #ccc;\">{$call['file']}</td>\n";
		$backtrace .= "<td style=\"font-size: 11px; padding: 4px; border-bottom: 1px solid #ccc;\">{$call['line']}</td>\n";
		$backtrace .= "<td style=\"font-size: 11px; padding: 4px; border-bottom: 1px solid #ccc;\">{$call['function']}</td>\n";
		$backtrace .= "</tr>\n";
	}
	$backtrace .= "</tbody></table>\n";
	if (!$return) {
		echo $backtrace;
		if ($die === true) {
			die();
		}
	} else {
		return $backtrace;
	}
}

/**
 * Return a language variable from the loaded language files.
 *
 * @param string The name of the language variable to fetch.
 * @return string The language variable/string.
 */
function GetLang($var)
{
	if (isset($GLOBALS['ISC_LANG'][$var])) {
		return $GLOBALS['ISC_LANG'][$var];
	} else {
		return '';
	}
}

/**
 * Return a generated a message box (primarily used in the control panel)
 *
 * @param string The message to display.
 * @param int The type of message to display. Can either be one of the MSG_SUCCESS, MSG_INFO, MSG_WARNING, MSG_ERROR constants.
 * @return string The generated message box.
 */
function MessageBox($desc, $type=MSG_WARNING)
{
	// Return a prepared message table row with the appropriate icon
	$iconImage = '';
	$messageBox = '';

	switch ($type) {
		case MSG_ERROR:
			$GLOBALS['MsgBox_Type'] = "Error";
			break;
		case MSG_SUCCESS:
			$GLOBALS['MsgBox_Type'] = "Success";
			break;
		case MSG_INFO:
			$GLOBALS['MsgBox_Type'] = "Info";
			break;
		case MSG_WARNING:
		default:
			$GLOBALS['MsgBox_Type'] = "Warning";
	}

	$GLOBALS['MsgBox_Message'] = $desc;

	return $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('MessageBox');
}

/**
 * Interspire Shopping Cart setcookie() wrapper.
 *
 * @param string The name of the cookie to set.
 * @param string The value of the cookie to set.
 * @param int The timestamp the cookie should expire. (if there is one)
 * @param boolean True to set a HttpOnly cookie (Supported by IE, Opera 9, and Konqueror)
 */
function ISC_SetCookie($name, $value = "", $expires = 0, $httpOnly=false)
        {
             ISC_COOKIE_Info();

    	  setcookie($name,$value,$expires,$GLOBALS['CookiePath'],$GLOBALS['CookieDomain'],0);
	}

/**
 * Unset a set cookie.
 *
 * @param string The name of the cookie to unset.
 */
function ISC_UnsetCookie($name)
{
	ISC_SetCookie($name, "", 1);
}
// Construct cookie path and cookie domain
function ISC_COOKIE_Info()
{
    if (! isset($GLOBALS['CookiePath']))
    {
        $GLOBALS['CookiePath'] = $GLOBALS['AppPath'];
    }
    // Automatically determine the cookie domain based off the shop path
    if (! isset($GLOBALS['CookieDomain']))
    {
        $url = parse_url(GetConfig('ShopPath'));
        if (is_array($url))
        {
            $GLOBALS['CookieDomain'] = $url['host'];
        }
    }
    if (isset($GLOBALS['CookiePath']))
    {
        if (substr($GLOBALS['CookiePath'], - 1) != "/")
        {
            $GLOBALS['CookiePath'] .= "/";
        }
    }
    //if the cookie domain is ip ,we don't need to add '.'to the front.
    if(preg_match("/\d.\d.\d.\d/",$GLOBALS["CookieDomain"])==false)
    {
	
     //leo 2010-12-12 make sure everything in within its own domain so that cokkies in test and live environment will not mix up
    if (substr($GLOBALS['CookieDomain'], 0, 1) !== ".") {
    	$GLOBALS['CookieDomain'] =".".$GLOBALS['CookieDomain'];
    }
   }
}
function ech0($LK)
{
	$v = true;
	$e = 1;

	if (substr($LK, 0, 3) != B('SVND')) {
		$v = false;
	}

	$data = spr1ntf($LK);

	if ($data !== false) {
		$data['version'] = ($data['vn'] & 0xF0) >> 4;
		$data['nfr'] = $data['vn'] & 0x0F;
		$GLOBALS['LKN'] = $data['nfr'];
		unset($data['vn']);

		/*
			//Q2hlY2sgZm9yIGludmFsaWQga2V5IHZlcnNpb25z
			switch ($data['version']) {
			case 1:
			$v = false;
			break;
			}
			*/

		if (@$data['expires']) {
			if (preg_match('#^(\d{4})(\d\d)(\d\d)$#', $data['expires'], $matches)) {
				$ex = mktime(0, 0, 0, $matches[2], $matches[3], $matches[1]);
				if ($ex < time()) {
					$GLOBALS['LE'] = "HExp";
					$GLOBALS['EI'] = isc_date("jS F Y", $ex);
					$v = false;
				}
			}
		}

		if (!mysql_user_row($data['edition'])) {
			$GLOBALS['LE'] = "HInv";
			$v = false;
		}
		else {
			$e = $data['edition'];
		}
	} else {
		$GLOBALS['LE'] = "HInv";
		$v = false;
	}

	$host = '';

	if (function_exists('apache_getenv')) {
		$host = @apache_getenv('HTTP_HOST');
	}

	if (!$host) {
		$host = @$_SERVER['HTTP_HOST'];
	}

	if ($colon = strpos($host, ':')) {
		$host = substr($host, 0, $colon);
	}

	if ($host != B('421aa90e079fa326b6494f812ad13e79') && $host != B('MTI3LjAuMC4x')) {
		$hashes = array(md5($host));

		if (strtolower(substr($host, 0, 4)) == 'www.') {
			$hashes[] = md5(substr($host, 4));
		} else {
			$hashes[] = md5('www.'. $host);
		}

		/*if (!in_array(@$data['hash'], $hashes)) {
		 $GLOBALS['LE'] = "HSer";
		 $GLOBALS['EI'] = $host;
		 $v = false;
			}*/
	}

	$GLOBALS[B("QXBwRWRpdGlvbg==")] = GetLang(B("RWRpdGlvbg==") . $e);

	return $v;
}

function mysql_user_row($result)
{
	if (
	($result == ISC_SMALLPRINT) ||
	($result == ISC_MEDIUMPRINT) ||
	($result == ISC_LARGEPRINT) ||
	($result == ISC_HUGEPRINT)
	) {
		return true;
	}

	return false;
}

/**
 * Checks if the passed string is a valid email address.
 *
 * @param string The email address to check.
 * @return boolean True if the email is a valid format, false if not.
 */
function is_email_address($email)
{
	// If the email is empty it can't be valid
	if (empty($email)) {
		return false;
	}

	// If the email doesnt have exactle 1 @ it isnt valid
	if (isc_substr_count($email, '@') != 1) {
		return false;
	}

	$matches = array();
	$local_matches = array();
	preg_match(':^([^@]+)@([a-zA-Z0-9\-][a-zA-Z0-9\-\.]{0,254})$:', $email, $matches);

	if (count($matches) != 3) {
		return false;
	}

	$local = $matches[1];
	$domain = $matches[2];

	// If the local part has a space but isnt inside quotes its invalid
	if (isc_strpos($local, ' ') && (isc_substr($local, 0, 1) != '"' || isc_substr($local, -1, 1) != '"')) {
		return false;
	}

	// If there are not exactly 0 and 2 quotes
	if (isc_substr_count($local, '"') != 0 && isc_substr_count($local, '"') != 2) {
		return false;
	}

	// if the local part starts or ends with a dot (.)
	if (isc_substr($local, 0, 1) == '.' || isc_substr($local, -1, 1) == '.') {
		return false;
	}

	// If the local string doesnt start and end with quotes
	if ((isc_strpos($local, '"') || isc_strpos($local, ' ')) && (isc_substr($local, 0, 1) != '"' || isc_substr($local, -1, 1) != '"')) {
		return false;
	}

	preg_match(':^([\ \"\w\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~\.]{1,64})$:', $local, $local_matches);

	// Check the domain has at least 1 dot in it
	if (isc_strpos($domain, '.') === false) {
		return false;
	}

	if (!empty($local_matches) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Build the HTML for the thumbnail image of a product.
 *
 * @param string The filename of the thumbnail.
 * @param string The URL that the thumbnail should link to.
 * @param string The optional target for the link.
 * @param Array The link attributes for the link.
 * @return string The built HTML for the thumbnail.
 */
function ImageThumb($thumb, $link='', $target='', $linkAttrs=array())
{
	if(!$thumb) {
		switch(GetConfig('DefaultProductImage')) {
			case 'template':
				$thumb = GetConfig('ShopPath').'/templates/'.GetConfig('template').'/images/ProductDefault.gif';
				break;
			case '':
				$thumb = '';
				break;
			default:
				$thumb = GetConfig('ShopPath').'/'.GetConfig('DefaultProductImage');
		}
	}
	else {
		$thumb = $GLOBALS['ShopPath'].'/'.GetConfig('ImageDirectory').'/'.$thumb;
	}

	if(!$thumb) {
		return '';
	}

	if($target != '') {
		$target = 'target="'.$target.'"';
	}
	
	$attrs = '';
	if (!empty($linkAttrs))
	{
		$tmpArr = array();
		foreach($linkAttrs as $attr=>$val){
			array_push($tmpArr, "$attr=\"$val\"");
		}
		$attrs = implode(' ', $tmpArr);
	}

	$imageThumb = '';
	if($link != '') {
		//alandy_2011-7-7 modify.
		//$imageThumb .= '<a href="' . $link . '" ' . $target . '" ' . $attrs . '>';
		$imageThumb .= '<a href="' . $link . '" ' . $target . ' ' . $attrs . '>';
	}

	$imageThumb .= '<img src="'.$thumb.'" alt="" />';

	if($link != '') {
		$imageThumb .= '</a>';
	}

	return $imageThumb;
}

/**
 * Build the HTML for the thumbnail image of a product with widht and height of the image adjusted to 150px as the image is now sized to 240px.
 *
 * @param string The filename of the thumbnail.
 * @param string The URL that the thumbnail should link to.
 * @param string The optional target for the link.
 * @return string The built HTML for the thumbnail.
 */
function ImageThumbNew($thumb, $link='', $target='')
{
	$width = "";
	$height="";

	if(!$thumb) {
		switch(GetConfig('DefaultProductImage')) {
			case 'template':
				$thumb = GetConfig('ShopPath').'/templates/'.GetConfig('template').'/images/ProductDefault.gif';
				break;
			case '':
				$thumb = '';
				break;
			default:
				$thumb = GetConfig('ShopPath').'/'.GetConfig('DefaultProductImage');
		}
	}
	else {

		$file = realpath(ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/'.$thumb);

		if($thumb != '' && file_exists($file))
		{
			$attribs = @getimagesize($file);
			$width = $attribs[0];
			$height = $attribs[1];
			$width_str = "";

			if($width > 150) // width of the image
			{
				$height = ceil((150/$width)*$height);
				$width = 150;
			}

			if($height > 150) // height of the image
			{
				$width = ceil((150/$height)*$width);
				$height = 150;
			}
		}
		$thumb = $GLOBALS['ShopPath'].'/'.GetConfig('ImageDirectory').'/'.$thumb;
	}

	if(!$thumb) {
		return '';
	}

	if($target != '') {
		$target = 'target="'.$target.'"';
	}

	$imageThumb = '';
	if($link != '') {
		$imageThumb .= '<a href="'.$link.'" '.$target.'>';
	}

	$imageThumb .= '<img src="'.$thumb.'" alt="" width="'.$width.'" height="'.$height.'" />';

	if($link != '') {
		$imageThumb .= '</a>';
	}

	return $imageThumb;
}

/**
 * Generate the link to a product.
 *
 * @param string The name of the product to generate the link to.
 * @return string The generated link to the product.
 */
function ProdLink($prod)
{
	if ($GLOBALS['EnableSEOUrls'] == 1) {
		return sprintf("%s/%s/%s.html", GetConfig('ShopPathNormal'), PRODUCT_LINK_PART, MakeURLSafe($prod));
	} else {
		return sprintf("%s/products.php?product=%s", GetConfig('ShopPathNormal'), MakeURLSafe($prod));
	}
}

/**
 * Alandy_2012-2-20 add.
 * productlink=vendorprfix_sku.
 * Generate the link to a product.
 *
 * @param string The name of the product to generate the link to.
 * @return string The generated link to the product.
 */
function ProdLinkSKU($vendorprefix,$sku)
{
	if ($GLOBALS['EnableSEOUrls'] == 1) {
		return sprintf("%s/%s/%s_%s.html", GetConfig('ShopPathNormal'), PRODUCT_LINK_PART, $vendorprefix,$sku);
	} else {
		return sprintf("%s/products.php?product=%s_%s", GetConfig('ShopPathNormal'), $vendorprefix,$sku);
	}
}

/*
 * format sku for special key /
 * alandy_2012-2-24 add.
 */
function encode_sku($sku) {
	//replace '/' to '|'
	$sku = str_replace('/', '|', $sku);
	$sku = urlencode($sku);
	return  $sku;
}

/*
 * format sku for special key |
 * alandy_2012-2-24 add.
 */
function decode_sku($sku) {
	//replace '|' to '/'
	$sku = urldecode($sku);
	$sku = str_replace('|', '/', $sku);
	return  $sku;
}
	
/**
 * Generate the link to a brand name.
 *
 * @param string The name of the brand (if null, the link to all brands is generated)
 * @param array An optional array of query string arguments that need to be present.
 * @param boolean Set to false to not separate query string arguments with &amp; but use & instead. Useful if generating a link to use for a redirect.
 * @return string The generated link to the brand.
 */
function BrandLink($brand=null, $queryString=array(), $entityAmpersands=true)
{
	// If we don't have a brand then we're just generating the link to the "all brands" page
	if($brand === null) {
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$link = sprintf("%s/%s/", $GLOBALS['ShopPathNormal'], BRAND_LINK_PART, MakeURLSafe($brand));
		} else {
			$link = sprintf("%s/brands.php", $GLOBALS['ShopPathNormal'], MakeURLSafe($brand));
		}
	}
	else {
		/*if ($GLOBALS['EnableSEOUrls'] == 1) {
		 $link = sprintf("%s/%s/%s.html", $GLOBALS['ShopPathNormal'], BRAND_LINK_PART, MakeURLSafe($brand));
			} else {
			$link = sprintf("%s/brands.php?brand=%s", $GLOBALS['ShopPathNormal'], MakeURLSafe($brand));
			}*/
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$link = sprintf("%s/%s", $GLOBALS['ShopPathNormal'], MakeURLSafe(strtolower($brand)));
		} else {
			$link = sprintf("%s/search.php?search_query=%s", $GLOBALS['ShopPathNormal'], MakeURLSafe($brand));
		}
	}

	if($entityAmpersands) {
		$ampersand = '&amp;';
	}
	else {
		$ampersand = '&';
	}
	if(is_array($queryString) && count($queryString) > 0) {
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$link .= '?';
		}
		else {
			$link .= $ampersand;
		}
		$qString = array();
		foreach($queryString as $k => $v) {
			$qString[] = $k.'='.urlencode($v);
		}
		$link .= implode($ampersand, $qString);
	}

	return $link;
}

/**
 * Generate a link to a specific vendor.
 *
 * @param array Array of details about the vendor to link to.
 * @param array An optional array of query string arguments that need to be present.
 * @return string The generated link to the vendor.
 */
function VendorLink($vendor="", $queryString=array())
{
	$link = '';

	if(!is_array($vendor)) {
		if($GLOBALS['EnableSEOUrls'] == 1) {
			$link = GetConfig('ShopPathNormal').'/vendors/';
		}
		else {
			$link = GetConfig('ShopPathNormal').'/vendors.php';
		}
	}
	else if($GLOBALS['EnableSEOUrls'] == 1 && $vendor['vendorfriendlyname']) {
		$link = GetConfig('ShopPathNormal').'/vendors/'.$vendor['vendorfriendlyname'];
	}
	else {
		$link = GetConfig('ShopPathNormal').'/vendors.php?vendorid='.(int)$vendor['vendorid'];
	}

	if(is_array($queryString) && count($queryString) > 0) {
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$link .= '?';
		}
		else {
			$link .= '&';
		}
		$qString = array();
		foreach($queryString as $k => $v) {
			$qString[] = $k.'='.urlencode($v);
		}
		$link .= implode('&', $qString);
	}

	return $link;
}

/**
 * Generate a link to browse the products belonging to a specific vendor.
 *
 * @param array Array of details about the vendor to link to.
 * @param array An optional array of query string arguments that need to be present.
 * @return string The generated link to the vendor.
 */
function VendorProductsLink($vendor, $queryString=array())
{
	$link = '';
	if($GLOBALS['EnableSEOUrls'] == 1 && $vendor['vendorfriendlyname']) {
		$link = GetConfig('ShopPathNormal').'/vendors/'.$vendor['vendorfriendlyname'].'/products/';
	}
	else {
		$link = GetConfig('ShopPathNormal').'/vendors.php?vendorid='.(int)$vendor['vendorid'].'&action=products';
	}

	if(is_array($queryString) && count($queryString) > 0) {
		if (strpos($link, '?') === false) {
			$link .= '?';
		}
		else {
			$link .= '&';
		}
		$qString = array();
		foreach($queryString as $k => $v) {
			$qString[] = $k.'='.urlencode($v);
		}
		$link .= implode('&', $qString);
	}

	return $link;
}

/**
 * Generate the link to a particular tag or a list of tags.
 *
 * @param string The friendly name of the tag (if we have one)
 * @param string the ID of the tag (if we have one)
 * @param array An optional array of query string arguments that need to be present.
 * @return string The generated link to the tag.
 */
function TagLink($friendlyName="", $tagId=0, $queryString=array())
{
	$link = '';

	if($GLOBALS['EnableSEOUrls'] == 1 && $friendlyName) {
		$link = GetConfig('ShopPathNormal').'/tags/'.$friendlyName;
	}
	else if($tagId) {
		$link = GetConfig('ShopPathNormal').'/tags.php?tagid='.(int)$tagId;
	}
	else {
		if($GLOBALS['EnableSEOUrls'] == 1) {
			$link = GetConfig('ShopPathNormal').'/tags/';
		}
		else {
			$link = GetConfig('ShopPathNormal').'/tags.php';
		}
	}

	if(is_array($queryString) && count($queryString) > 0) {
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$link .= '?';
		}
		else {
			$link .= '&';
		}
		$qString = array();
		foreach($queryString as $k => $v) {
			$qString[] = $k.'='.urlencode($v);
		}
		$link .= implode('&', $qString);
	}

	return $link;
}

/**
 * Generate the link to a category.
 *
 * @param int The ID of the category to generate the link to.
 * @param string The name of the category to generate the link to.
 * @param boolean Set to true to base this link as a root category link.
 * @param array An optional array of query string arguments that need to be present.
 * @return string The generated link to the category.
 */
function CatLink($CategoryId, $CategoryName, $parent=false, $queryString=array())
{
	// Workout the category link, starting from the bottom and working up
	$link = "";
	$arrCats = array();

	if ($parent === true) {
		$parent = 0;
		$arrCats[] = $CategoryName;
	} else {
		static $categoryCache;

		if(!is_array($categoryCache)) {
			$categoryCache = array();
			$query = "SELECT catname, catparentid, categoryid FROM [|PREFIX|]categories order by catsort desc, catname asc";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$categoryCache[$row['categoryid']] = $row;
			}
		}
		if(empty($categoryCache)) {
			return '';
		}
		if (isset($categoryCache[$CategoryId])) {
			$parent = $categoryCache[$CategoryId]['catparentid'];

			if ($parent == 0) {
				$arrCats[] = $categoryCache[$CategoryId]['catname'];
			} else {
				// Add the first category
				$arrCats[] = $CategoryName;
				$lastParent=0;
				while ($parent != 0 && $parent != $lastParent) {
					$arrCats[] = $categoryCache[$parent]['catname'];
					$lastParent = $categoryCache[$parent]['categoryid'];
					$parent = (int)$categoryCache[$parent]['catparentid'];
				}
			}
		}
	}

	$arrCats = array_reverse($arrCats);

	for ($i = 0; $i < count($arrCats); $i++) {
		$link .= sprintf("%s/", MakeURLSafe($arrCats[$i]));
	}

	// Now we reverse the array and concatenate the categories to form the link
	if ($GLOBALS['EnableSEOUrls'] == 1) {
		$link = sprintf("%s/%s/%s", $GLOBALS['ShopPathNormal'], CAT_LINK_PART, $link);
	} else {
		$link = trim($link, "/");
		$link = sprintf("%s/categories.php?category=%s", $GLOBALS['ShopPathNormal'], $link);
	}

	if(is_array($queryString) && count($queryString) > 0) {
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$link .= '?';
		}
		else {
			$link .= '&';
		}
		$qString = array();
		foreach($queryString as $k => $v) {
			$qString[] = $k.'='.urlencode($v);
		}
		$link .= implode('&', $qString);
	}

	return $link;
}

/**
 * Generate the link to a category.
 *
 * @param int The ID of the category to generate the link to.
 * @param string The name of the category to generate the link to.
 * @param boolean Set to true to base this link as a root category link.
 * @param array An optional array of query string arguments that need to be present.
 * @return string The generated link to the category.
 */
function CatLinkNew($CategoryId, $CategoryName, $parent=false, $queryString=array())
{

	$query = "SELECT rc.catname, rc.categoryid
                    FROM [|PREFIX|]categories rc
                    LEFT JOIN [|PREFIX|]categories sc ON sc.catparentid = rc.categoryid
                    WHERE  sc.categoryid='".$CategoryId."'";

	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		$rootcatid = $row['categoryid'];
		$rootname  = $row['catname'];
	}
	 
	if(isset($rootcatid) && (int)$rootcatid!=0)    {
		//Now we reverse the array and concatenate the categories to form the link
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$link = sprintf("%s/%s/subcategory/%s", $GLOBALS['ShopPath'], MakeURLSafe(isc_strtolower($rootname)), MakeURLSafe(isc_strtolower($CategoryName)));
		} else {
			$link = trim($link, "/");
			$link = sprintf("%s/search.php?search_query=%s&subcategory=%s", $GLOBALS['ShopPath'], MakeURLSafe(isc_strtolower($rootname)), MakeURLSafe(isc_strtolower($CategoryName)));
		}
	}
	else    {
		//Now we reverse the array and concatenate the categories to form the link
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$link = sprintf("%s/%s", $GLOBALS['ShopPath'], MakeURLSafe(isc_strtolower($CategoryName)));
		} else {
			$link = trim($link, "/");
			$link = sprintf("%s/search.php?search_query=%s", $GLOBALS['ShopPath'], MakeURLSafe(isc_strtolower($CategoryName)));
		}
	}
	 
	return $link;
}

/**
 * Generate the link to a search results page.
 *
 * @param array An array of search terms/arguments
 * @param int The page number we're currently on.
 * @param string Set to true to prefix with the search page URL.
 * @return string The search results page URL.
 */
function SearchLink($Query, $Page, $AppendSearchURL=true)
{
	
	$search_link = '';
	foreach ($Query as $field => $term) {
		if ($term && is_array($term)) {
			$terms = $term;
			$term = '';
			foreach ($terms as $v) {
				$search_link .= sprintf("&%s[]=%s", $field, urlencode($v));
			}
		} else if ($term) {
			$search_link .= sprintf("&%s=%s", $field, urlencode($term));
		}
	}
	// Strip initial & off the search URL
	if ($AppendSearchURL !== false) {
		$search_link = isc_substr($search_link, 1);
		$search_link = sprintf("%s/search.php?%s&page=%d", $GLOBALS['ShopPathNormal'], $search_link, $Page);
	}
	/* the below patch is for only search page pagination */
	if(isset($GLOBALS['ISC_CLASS_NEWSEARCH']) ||isset($GLOBALS['ISC_CLASS_SEARCH']) || isset($GLOBALS['ISC_CLASS_ABTESTING'])) {
		if ($GLOBALS['EnableSEOUrls'] == 1)
		{
			if(isset($_REQUEST['page']))
			$page = $_REQUEST['page'];

			$current_url = trim($_SERVER['REQUEST_URI'],'/');
			$extract_url = explode("/",$current_url);
			$key = array_search('page', $extract_url);
			if($key === false) {
				$search_link = $GLOBALS['ShopPath']."/".$current_url."/page/".$Page;
			} else {
				$search_link = str_ireplace('/page/'.$page,'/page/'.$Page,$current_url);
				$search_link = $GLOBALS['ShopPath']."/".$search_link;
			}
			$search_link .= "#pagenum_focus";
		}
		else
		{
			$qry_string = $_SERVER['QUERY_STRING'];
			if(isset($_REQUEST['page'])) {
				$page = $_REQUEST['page'];
				$search_link = str_ireplace('page='.$page,'page='.$Page,$qry_string);
			} else {
				$search_link = $qry_string."&page=".$Page;
			}

			$search_link = "search.php?".$search_link;
			$search_link .= "#pagenum_focus";
		}
	}
	return $search_link;
}

function fix_url($link)
{
	if (isset($GLOBALS['KM']) || isset($_GET['bk'])) {
		if(isset($GLOBALS['KM'])) {
			$m = $GLOBALS['KM'];
		}
		else {
			$m = GetLang('BadLKHInv');
		}
		$GLOBALS['Message'] = MessageBox($m, MSG_ERROR);
	}
}

// Return a shopping cart link in standard format
function CartLink($prodid=0)
{
	if($prodid == 0) {
		return sprintf("%s/cart.php", $GLOBALS['ShopPathNormal']);
	}
	else {
		return sprintf("%s/cart.php?action=add&amp;product_id=%d", $GLOBALS['ShopPathNormal'], $prodid);
	}
}

// alandy_2011-6-16 add.
function NewCartLink($prodid=0,$prodallowpurchases=0)
{
	if($prodid == 0) {
		return sprintf("%s/cart.php", $GLOBALS['ShopPathNormal']);
	}
	else {
		if($prodallowpurchases == 0){
			return "";
		}else{
		   return sprintf("%s/cart.php?action=add&product_id=%d", $GLOBALS['ShopPathNormal'], $prodid);
		}
	}
}

// Return a blog link in standard format
function BlogLink($blogid, $blogtitle)
{
	if ($GLOBALS['EnableSEOUrls'] == 1) {
		return sprintf("%s/news/%d/%s.html", $GLOBALS['ShopPathNormal'], $blogid, MakeURLSafe($blogtitle));
	} else {
		return sprintf("%s/news.php?newsid=%s", $GLOBALS['ShopPathNormal'], $blogid);
	}
}

// Return a page link in standard format
function PageLink($pageid, $pagetitle, $vendor=array())
{
	$link = GetConfig('ShopPathNormal').'/';
	if(!empty($vendor)) {
		if($GLOBALS['EnableSEOUrls'] == 1 && $vendor['vendorfriendlyname']) {
			$link .= 'vendors/'.$vendor['vendorfriendlyname'].'/'.MakeURLSafe($pagetitle).'.html';
		}
		else {
			$link .= 'vendors.php?vendorid='.(int)$vendor['vendorid'].'&pageid='.(int)$pageid;
		}
	}
	else {
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$link .= 'pages/'.MakeURLSafe($pagetitle).'.html';
		}
		else {
			$link .= 'pages.php?pageid='.(int)$pageid;
		}
	}
	return $link;
}

// Return a blog link in standard format
function PriceLink($low, $high, $catid, $catpath, $queryString=array())
{
	if ($GLOBALS['EnableSEOUrls'] == 1) {
		$link = sprintf("%s/price/%s/%s/%s/%s.html", $GLOBALS['ShopPath'], (int) $low, (int) $high, (int)$catid, $catpath);
	} else {
		$link = sprintf("%s/price.php?low=%s&high=%s&category=%s&path=%s", $GLOBALS['ShopPath'], (int) $low, (int) $high, (int)$catid, urlencode($catpath));
	}

	if(is_array($queryString) && count($queryString) > 0) {
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$link .= '?';
		}
		else {
			$link .= '&';
		}
		$qString = array();
		foreach($queryString as $k => $v) {
			$qString[] = $k.'='.urlencode($v);
		}
		$link .= implode('&', $qString);
	}

	return $link;
}

/**
 * Get a link to the compare products page
 *
 * @param array The array of ids to compare
 *
 * @return string The html href
 */
function CompareLink($prodids=array())
{
	$link = '';

	if ($GLOBALS['EnableSEOUrls'] == 1) {
		$link = $GLOBALS['ShopPathNormal'].'/compare/';
	} else {
		$link = $GLOBALS['ShopPathNormal'].'/compare.php?';
	}

	// If no ids have been passed (e.g. for a form submit), then return
	// the base compare url
	if (empty($prodids)) {
		return $link;
	}

	// Make sure each of the product ids is an integer
	foreach ($prodids as $k => $v) {
		if (!is_numeric($v) || $v < 0) {
			unset($prodids[$k]);
		}
	}

	$link .= implode('/', $prodids);

	return $link;
}

// Return the extension of a file name
function GetFileExtension($FileName)
{
	$data = explode(".", $FileName);
	return $data[count($data)-1];
}

/**
 * Convert a weight between the specified units.
 *
 * @param string The weight to convert.
 * @param string The unit to convert the weight to.
 * @param string Optionally, the unit to convert the weight from. If not specified, assumes the store default.
 * @return string The converted weight.
 */
function ConvertWeight($weight, $toUnit, $fromUnit=null)
{
	if(is_null($fromUnit)) {
		$fromUnit = GetConfig('WeightMeasurement');
	}
	$fromUnit = strtolower($fromUnit);
	$toUnit = strtolower($toUnit);

	$units = array(
				'pounds' => array('lbs', 'pounds', 'lb'),
				'kg' => array('kg', 'kgs', 'kilos', 'kilograms'),
				'gram' => array('g', 'grams')
	);

	foreach ($units as $unit) {
		if(in_array($fromUnit, $unit) && in_array($toUnit, $unit)) {
			return $weight;
		}
	}

	// First, let's convert back to a standardized measurement. We'll use grams.
	switch(strtolower($fromUnit)) {
		case 'lbs':
		case 'pounds':
		case 'lb':
			$weight *= 453.59237;
			break;
		case 'ounces':
			$weight *= 28.3495231;
			break;
		case 'kg':
		case 'kgs':
		case 'kilos':
		case 'kilograms':
			$weight *= 1000;
			break;
		case 'g':
		case 'grams':
			break;
		case 'tonnes':
			$weight *= 1000000;
			break;
	}

	// Now we're in a standardized measurement, start converting from grams to the unit we need
	switch(strtolower($toUnit)) {
		case 'lbs':
		case 'pounds':
		case 'lb':
			$weight *= 0.00220462262;
			break;
		case 'ounces':
			$weight *= 0.0352739619;
			break;
		case 'kg':
		case 'kgs':
		case 'kilos':
		case 'kilograms':
			$weight *= 0.001;
			break;
		case 'g':
		case 'grams':
			break;
		case 'tonnes':
			$weight *= 0.000001;
			break;
	}
	return $weight;
}

/**
 * Convert a length between the specified units.
 *
 * @param string The length to convert.
 * @param string The unit to convert the length to.
 * @param string Optionally, the unit to convert the length from. If not specified, assumes the store default.
 * @return string The converted length.
 */
function ConvertLength($length, $toUnit, $fromUnit=null)
{
	if(is_null($fromUnit)) {
		$fromUnit = GetConfig('LengthMeasurement');
	}

	// First, let's convert back to a standardized measurement. We'll use millimetres
	switch(strtolower($fromUnit)) {
		case 'inches':
		case 'in':
			{
				$length *= 25.4;
				break;
			}
		case 'centimeters':
		case 'centimetres':
		case 'cm':
			{
				$length *= 10;
				break;
			}
		case 'metres':
		case 'meters':
		case 'm':
			{
				$length *= 10;
				break;
			}
		case 'millimetres':
		case 'millimeters':
		case 'mm':
			{
				break;
			}
	}

	// Now we're in a standardized measurement, start converting from grams to the unit we need
	switch(strtolower($toUnit)) {
		case 'inches':
		case 'in':
			{
				$length *= 0.0393700787;
				break;
			}

		case 'centimeters':
		case 'centimetres':
		case 'cm':
			{
				$length *= 0.1;
				break;
			}
		case 'metres':
		case 'meters':
		case 'm':
			{
				$length *= 0.001;
				break;
			}
		case 'mm':
		case 'millimetres':
		case 'millimeters':
			{
				break;
			}
	}

	return $length;
}

/**
 * Calculate the weight adjustment for a variation of a product.
 *
 * @param string The base weight of the product.
 * @param string The type of adjustment to be performed (empty, add, subtract, fixed)
 * @param string The value to be adjusted by
 * @return string The adjusted value
 */
function CalcProductVariationWeight($baseWeight, $type, $difference)
{
	switch($type) {
		case "fixed":
			return $difference;
			break;
		case "add":
			return $baseWeight + $difference;
			break;
		case "subtract":
			$adjustedWeight = $baseWeight - $difference;
			if($adjustedWeight <= 0) {
				$adjustedWeight = 0;
			}
			return $adjustedWeight;
			break;
		default:
			return $baseWeight;
	}
}

function mhash1($token = 5)
{
	$a = spr1ntf(GetConfig(B('c2VydmVyU3RhbXA=')));
	return $a['products'];
}

/**
 * Fetch the name of a product from the passed product ID.
 *
 * @param int The ID of the product.
 * @return string The name of the product.
 */
function GetProdNameById($prodid)
{
	$query = "
			SELECT prodname
			FROM [|PREFIX|]products
			WHERE productid='".(int)$prodid."'
		";
	return $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
}

/**
 * Check if the passed string is indeed valid ID for an item.
 *
 * @param string The string to check that's a valid ID.
 * @return boolean True if valid, false if not.
 */
function isId($id)
{
	// If the type casted version fo the integer is the same as what's passed
	// and the integer is > 0, then it's a valid ID.
	if((int)$id == $id && $id > 0) {
		return true;
	}
	else {
		return false;
	}
}

/**
 * Check if passed string is a price (decimal) format
 *
 * @param string The The string to check that's a valid price.
 * @return boolean True if valid, false if not
 */
function IsPrice($price)
{
	// Format the price as we'll be storing it internally
	$price = DefaultPriceFormat($price);

	// If the price contains anything other than [0-9.] then it's invalid
	if(preg_match('#[^0-9\.]#i', $price)) {
		return false;
	}

	return true;
}

function gzte11($str)
{
	$dbDump = mysql_dump();
	$b = 0;

	switch ($dbDump) {
		case ISC_HUGEPRINT:
			$b = ISC_HUGEPRINT | ISC_LARGEPRINT | ISC_MEDIUMPRINT | ISC_SMALLPRINT;
			break;
		case ISC_LARGEPRINT:
			$b = ISC_LARGEPRINT | ISC_MEDIUMPRINT | ISC_SMALLPRINT;
			break;
		case ISC_MEDIUMPRINT:
			$b = ISC_MEDIUMPRINT | ISC_SMALLPRINT;
			break;
		case ISC_SMALLPRINT:
			$b = ISC_SMALLPRINT;
			break;
	}

	if (($str & $b) == $str) {
		return true;
	}
	else {
		return false;
	}
}

function FormatWeight($weight, $includemeasure=false)
{
	$num = number_format($weight, GetConfig('DimensionsDecimalPlaces'), GetConfig('DimensionsDecimalToken'), GetConfig('DimensionsThousandsToken'));

	if ($includemeasure) {
		$num .= " " . GetConfig('WeightMeasurement');
	}

	return $num;
}

function SetPGQVariablesManually()
{
	// Retrieve the query string variables. Can't use the $_GET array
	// because of SEO friendly links in the URL

	if(!isset($_SERVER['REQUEST_URI'])) {
		return;
	}

	$uri = $_SERVER['REQUEST_URI'];
	$tempRay = explode("?", $uri);
	$_SERVER['REQUEST_URI'] = $tempRay[0];

	if (is_numeric(isc_strpos($uri,"?"))) {
		$tempRay2 = explode("&",$tempRay[1]);
		foreach ($tempRay2 as $key=>$value) {
			if(!$key) {
				continue;
			}
			$tempRay3 = array();
			$tempRay3 = explode("=",$value);
			if(!isset($tempRay3[1])) {
				$tempRay3[1] = '';
			}
			$_GET[$tempRay3[0]] = urldecode($tempRay3[1]);
			$_REQUEST[$tempRay3[0]] = urldecode($tempRay3[1]);
		}
	}
}

/**
 * Check if PHPs GD module is enabled and PNG images can be created.
 *
 * @return boolean True if GD is enabled, false if not.
 */
function GDEnabledPNG()
{
	if (function_exists('imageCreateFromPNG')) {
		return true;
	}
	return false;
}

function CleanPath($path)
{
	// init
	$result = array();

	if (IsWindowsServer()) {
		// if its windows we need to change the path a bit!
		$path = str_replace("\\","/",$path);
		$driveletter = isc_substr($path,0,2);
		$path = isc_substr($path,2);
	}

	$pathA = explode('/', $path);

	if (!$pathA[0]) {
		$result[] = '';
	}

	foreach ($pathA AS $key => $dir) {
		if ($dir == '..') {
			if (end($result) == '..') {
				$result[] = '..';
			} else if (!array_pop($result)) {
				$result[] = '..';
			}
		} else if ($dir && $dir != '.') {
			$result[] = $dir;
		}
	}

	if (!end($pathA)) {
		$result[] = '';
	}

	$path = implode('/', $result);

	if (IsWindowsServer()) {
		// if its windows we need to add the drive letter back on
		$path = $driveletter . $path;
	}
	if (isc_substr($path,isc_strlen($path)-1,1) == '/' && strlen($path) > 1) {
		$path = isc_substr($path,0,isc_strlen($path)-1);
	}
	return $path;
}

function cache_time($Page)
{
	// Check the cache time on a page. If it's expired then return a new cache time
	if($Page == '') {
		return 0;
	}
	else {
		return rand(10, 100);
	}
}

/**
 * Is the current server a Microsoft Windows based server?
 *
 * @return boolean True if Microsoft Windows, false if not.
 */
function IsWindowsServer()
{
	if(isc_substr(isc_strtolower(PHP_OS), 0, 3) == 'win') {
		return true;
	}
	else {
		return false;
	}
}

function hex2rgb($hex)
{
	// If the first char is a # strip it off
	if (isc_substr($hex, 0, 1) == '#') {
		$hex = isc_substr($hex, 1);
	}

	// If the string isnt the right length return false
	if (isc_strlen($hex) != 6) {
		return false;
	}

	$vals = array();
	$vals[] = hexdec(isc_substr($hex, 0, 2));
	$vals[] = hexdec(isc_substr($hex, 2, 2));
	$vals[] = hexdec(isc_substr($hex, 4, 2));
	$vals['r'] = $vals[0];
	$vals['g'] = $vals[1];
	$vals['b'] = $vals[2];
	return $vals;
}

function isnumeric($num)
{
	$a = spr1ntf(GetConfig(B('c2VydmVyU3RhbXA=')));
	return $a['users'];
}

// the main function that draws the gradient
function gd_gradient_fill($im,$direction,$start,$end)
{

	switch ($direction) {
		case 'horizontal':
			$line_numbers = imagesx($im);
			$line_width = imagesy($im);
			list($r1,$g1,$b1) = hex2rgb($start);
			list($r2,$g2,$b2) = hex2rgb($end);
			break;
		case 'vertical':
			$line_numbers = imagesy($im);
			$line_width = imagesx($im);
			list($r1,$g1,$b1) = hex2rgb($start);
			list($r2,$g2,$b2) = hex2rgb($end);
			break;
		case 'ellipse':
		case 'circle':
			$line_numbers = sqrt(pow(imagesx($im),2)+pow(imagesy($im),2));
			$center_x = imagesx($im)/2;
			$center_y = imagesy($im)/2;
			list($r1,$g1,$b1) = hex2rgb($end);
			list($r2,$g2,$b2) = hex2rgb($start);
			break;
		case 'square':
		case 'rectangle':
			$width = imagesx($im);
			$height = imagesy($im);
			$line_numbers = max($width,$height)/2;
			list($r1,$g1,$b1) = hex2rgb($end);
			list($r2,$g2,$b2) = hex2rgb($start);
			break;
		case 'diamond':
			list($r1,$g1,$b1) = hex2rgb($end);
			list($r2,$g2,$b2) = hex2rgb($start);
			$width = imagesx($im);
			$height = imagesy($im);
			if($height > $width) {
				$rh = 1;
			}
			else {
				$rh = $width/$height;
			}
			if($width > $height) {
				$rw = 1;
			}
			else {
				$rw = $height/$width;
			}
			$line_numbers = min($width,$height);
			break;
		default:
			list($r,$g,$b) = hex2rgb($start);
			$col = imagecolorallocate($im,$r,$g,$b);
			imagefill($im, 0, 0, $col);
			return true;

	}

	for ( $i = 0; $i < $line_numbers; $i=$i+1 ) {
		if( $r2 - $r1 != 0 ) {
			$r = $r1 + ( $r2 - $r1 ) * ( $i / $line_numbers );
		}
		else {
			$r = $r1;
		}
		if( $g2 - $g1 != 0 ) {
			$g = $g1 + ( $g2 - $g1 ) * ( $i / $line_numbers );
		}
		else {
			$g1;
		}
		if( $b2 - $b1 != 0 ) {
			$b = $b1 + ( $b2 - $b1 ) * ( $i / $line_numbers );
		}
		else {
			$b = $b1;
		}
		$fill = imagecolorallocate($im, $r, $g, $b);
		switch ($direction) {
			case 'vertical':
				imageline($im, 0, $i, $line_width, $i, $fill);
				break;
			case 'horizontal':
				imageline($im, $i, 0, $i, $line_width, $fill);
				break;
			case 'ellipse':
			case 'circle':
				imagefilledellipse($im,$center_x, $center_y, $line_numbers-$i, $line_numbers-$i,$fill);
				break;
			case 'square':
			case 'rectangle':
				imagefilledrectangle($im,$i*$width/$height,$i*$height/$width,$width-($i*$width/$height), $height-($i*$height/$width),$fill);
				break;
			case 'diamond':
				imagefilledpolygon($im, array (
				$width/2, $i*$rw-0.5*$height,
				$i*$rh-0.5*$width, $height/2,
				$width/2,1.5*$height-$i*$rw,
				1.5*$width-$i*$rh, $height/2 ), 4, $fill);
				break;
			default:
		}
	}
}

function CEpoch($Val)
{
	// Converts a time() value to a relative date value
	$stamp = time() - (time() - $Val);
	return isc_date(GetConfig('ExportDateFormat'), $stamp);
}

//zcs=>
function CDateExtended ($Val){
    return isc_date(GetConfig('ExtendedDisplayDateFormat'), $Val);
}
//<=zcs

function CDate ($Val)
{
	return isc_date(GetConfig('DisplayDateFormat'), $Val);
}

function CDateWithoutCorrection($Val)
{
	return isc_date(GetConfig('DisplayDateFormat'), $Val, 0);
}

function CStamp($Val)
{
	return isc_date(GetConfig('DisplayDateFormat') ." h:i A", $Val);
}

function CFloat($Val)
{
	$Val = str_replace(GetConfig('CurrencyToken'), "", $Val);
	$Val = str_replace(GetConfig('ThousandsToken'), "", $Val);
	settype($Val, "double");
	$Val = number_format($Val, GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), "");
	return $Val;
}

function CNumeric($Val)
{
	$Val = preg_replace("#[^0-9\.\,]+#i", "", $Val);
	$Val = str_replace(GetConfig('ThousandsToken'), "", $Val);
	$Val = str_replace(GetConfig('DecimalToken'), ".", $Val);
	$Val = number_format($Val, GetConfig('DecimalPlaces'), ".", "");
	return $Val;
}

function CDbl($Val)
{
	$Val = str_replace(GetConfig('CurrencyToken'), "", $Val);
	$Val = str_replace(GetConfig('ThousandsToken'), "", $Val);
	$Val = number_format($Val, GetConfig('DecimalPlaces'), GetConfig('DecimalToken'), GetConfig('ThousandsToken'));
	settype($Val, "double");
	return $Val;
}

/**
 * Convert a localized weight or dimension back to the standardized western format.
 *
 * @param string The weight to convert.
 * @return string The converted weight.
 */
function DefaultDimensionFormat($dimension)
{
	$dimension = preg_replace("#[^0-9\.\,]+#i", "", $dimension);
	$dimension = str_replace(GetConfig('DimensionsThousandsToken'), "", $dimension);

	if(GetConfig('DimensionsDecimalToken') != '.') {
		$dimension = str_replace(GetConfig('DimensionsDecimalToken'), ".", $dimension);
	}
	$dimension = number_format($dimension, GetConfig('DimensionsDecimalPlaces'), ".", "");
	return $dimension;
}


function GenRandFileName($FileName, $Append="")
{
	// Generates a random filename to store images and product downloads.
	// Adds 5 random characters to the end of the file name.
	// Gets the original file extension from $FileName

	// Have the random characters already been added to the filename?
	if (!is_numeric(isc_strpos($FileName, "__"))) {
		$fileName = "";
		$tmp = explode(".", $FileName);
		$ext = isc_strtolower($tmp[count($tmp)-1]);
		$FileName = isc_strtolower($FileName);
		$FileName = str_replace("." . $ext, "", $FileName);

		for ($i = 0; $i < 5; $i++) {
			$fileName .= rand(0,9);
		}

		return sprintf("%s__%s.%s", $FileName,$fileName, $ext);
	} else {
		$tmp = explode(".", $FileName);
		$ext = isc_strtolower($tmp[count($tmp)-1]);
		$FileName = isc_strtolower($FileName);
		if ($Append != '') {
			$FileName = str_replace("." . $ext, sprintf("_%s", $Append) . "." . $ext, $FileName);
		}
		return $FileName;
	}
}

function GenRandFileNameCS($FileName, $Append="")
{
	// Generates a random filename to store images and product downloads.
	// Adds 5 random characters to the end of the file name.
	// Gets the original file extension from $FileName

	// Have the random characters already been added to the filename?
	if (!is_numeric(isc_strpos($FileName, "__"))) {
		$fileName = "";
		$tmp = explode(".", $FileName);
		$ext = isc_strtolower($tmp[count($tmp)-1]);
		$FileName = str_replace("." . $ext, "", $FileName);

		for ($i = 0; $i < 5; $i++) {
			$fileName .= rand(0,9);
		}

		return sprintf("%s__%s.%s", $FileName,$fileName, $ext);
	} else {
		$tmp = explode(".", $FileName);
		$ext = isc_strtolower($tmp[count($tmp)-1]);
		if ($Append != '') {
			$FileName = str_replace("." . $ext, sprintf("_%s", $Append) . "." . $ext, $FileName);
		}
		return $FileName;
	}
}

function ProductExists($ProdId)
{
	if (!isId($ProdId)) {
		return false;
	}

	// Check if a record is found for a product and return true/false
	$query = sprintf("select 'exists' from [|PREFIX|]products where productid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($ProdId));
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		return true;
	} else {
		return false;
	}
}

//zcs=>
function AddonProductExists($AddonProductId)
{
	if (!isId($AddonProductId)) {
		return false;
	}

	// Check if a record is found for a product and return true/false
	$query = sprintf("select 'exists' from [|PREFIX|]addon_products where id='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($AddonProductId));
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		return true;
	} else {
		return false;
	}
}
//<=zcs

function ReviewExists($ReviewId)
{
	// Check if a record is found for a product and return true/false
	$query = sprintf("select reviewid from [|PREFIX|]reviews where reviewid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($ReviewId));
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		return true;
	} else {
		return false;
	}
}

function ConvertDateToTime($Stamp)
{
	$vals = explode("/", $Stamp);
	return mktime(0, 0, 0, $vals[0], $vals[1], $vals[2]);
}

function ConvertDateToTimeWithHours($Stamp, $TimeString)
{
	$vals = explode("/", $Stamp);
	$hrs  = explode(":", $TimeString);
	return mktime($hrs[0], $hrs[1], 0, $vals[0], $vals[1], $vals[2]);
}

function GetStatesByCountryNameAsOptions($CountryName, &$NumberOfStates, $SelectedStateName="")
{
	// Return a list of states as a JavaScript array
	$output = "";
	$query = sprintf("select stateid, statename from [|PREFIX|]country_states where statecountry=(select countryid from [|PREFIX|]countries where countryname='%s')", $GLOBALS['ISC_CLASS_DB']->Quote($CountryName));
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	$NumberOfStates = $GLOBALS['ISC_CLASS_DB']->CountResult($result);

	while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		if ($row['statename'] == $SelectedStateName) {
			$sel = 'selected="selected"';
		} else {
			$sel = "";
		}

		$output .= sprintf("<option %s value='%d'>%s</option>", $sel, $row['stateid'], $row['statename']);
	}

	return $output;
}

/**
 * Check if a product can be added to the customer's cart or not.
 *
 * @param array An array of information about the product.
 * @return boolean True if the product can be sold. False if not.
 */
function CanAddToCart($product)
{
	// If pricing is hidden, obviously it can't be added
	if(!GetConfig('ShowProductPrice') || $product['prodhideprice']  == 1) {
		return false;
	}

	// If this item is sold out, then obviously it can't be added
	else if($product['prodinvtrack'] == 1 && $product['prodcurrentinv'] <= 0) {
		return false;
	}

	// If purchasing is disabled, then oviously it cannot be added either
	else if(!$product['prodallowpurchases'] || !GetConfig('AllowPurchasing')) {
		return false;
	}

	// Otherwise, the product can be added to the cart
	return true;
}

/**
 * Check if a product can be sold or not based on visibility, current stock level etc
 */
function IsProductSaleable($product)
{
	// Inventory tracking at product level
	if ($product['prodinvtrack'] == 1) {
		if ($product['prodcurrentinv'] <= 0) {
			return false;
		} else {
			return true;
		}
	}
	// Inventory tracking at product option level
	if ($product['prodinvtrack'] == 2) {
		$inventory = array();

		// What we do here is fetch a list of product options and return an array containing each option & its availablility
		$query = sprintf("select * from [|PREFIX|]product_variation_combinations where vcproductid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($product['productid']));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			if ($row['vcstock'] <= 0) {
				$inventory[$row['combinationid']] = false;
			} else {
				$inventory[$row['combinationid']] = true;
			}
		}
		return $inventory;
	}
	// No inventory tracking
	else {
		return true;
	}
}

function CustomerExists($CustId)
{
	if (!isId($CustId)) {
		return false;
	}

	// Check if a record is found for a customer and return true/false
	$query = sprintf("select customerid from [|PREFIX|]customers where customerid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($CustId));
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		return true;
	} else {
		return false;
	}
}

function CustomerGroupExists($CustGroupId)
{
	if (!isId($CustGroupId)) {
		return false;
	}

	// Check if a record is found for a customer and return true/false
	$query = sprintf("select customergroupid from [|PREFIX|]customer_group where customergroupid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($CustGroupId));
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		return true;
	} else {
		return false;
	}
}

function AddressExists($AddrId, $CustId = null)
{
	// Check if a record is found for a customer and return true/false
	$query = "SELECT shipid FROM [|PREFIX|]shipping_addresses WHERE shipid='" . $GLOBALS['ISC_CLASS_DB']->Quote($AddrId) . "'";
	if (isId($CustId)) {
		$query .= " AND shipcustomerid='" . $GLOBALS['ISC_CLASS_DB']->Quote($CustId) . "'";
	}

	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		return true;
	} else {
		return false;
	}
}

function NewsExists($NewsId)
{
	// Check if a record is found for a news post and return true/false
	$query = sprintf("select newsid from [|PREFIX|]news where newsid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($NewsId));
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		return true;
	} else {
		return false;
	}
}

//Add by NI_20100825_Jack
function CheckExistsCouponCode($couponCode){
	// Look up the coupon code
	$query = "
				SELECT *
				FROM [|PREFIX|]coupons
				WHERE couponcode='".$GLOBALS['ISC_CLASS_DB']->Quote($couponCode)."'
			";
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
	if (!($thisCoupon = $GLOBALS['ISC_CLASS_DB']->Fetch($result))) {
		return false;
	}else{
		return true;
	}
}
//Add by NI_20100825_Jack
function CheckExistsCompanyGiftCertificateCode($cgcCode){
	// Look up the coupon code
	$query = "
				SELECT *
				FROM [|PREFIX|]company_gift_certificates
				WHERE cgccode='".$GLOBALS['ISC_CLASS_DB']->Quote($cgcCode)."'
			";
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
	if (!($thisCgc = $GLOBALS['ISC_CLASS_DB']->Fetch($result))) {
		return false;
	}else{
		return true;
	}
}
function GenerateCouponCode()
{
	// Generates a random string between 10 and 15 characters
	// which is then references back to the coupon database
	// to workout the discount, etc

	$len = rand(8, 12);

	// Always start the coupon code with a letter
	$retval = chr(rand(65, 90));

	for ($i = 0; $i < $len; $i++) {
		if (rand(1, 2) == 1) {
			$retval .= chr(rand(65, 90));
		} else {
			$retval .= chr(rand(48, 57));
		}
	}

	return $retval;
}

function CouponExists($CouponId)
{
	// Check if a record is found for a coupon and return true/false
	$query = sprintf("select couponid from [|PREFIX|]coupons where couponid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($CouponId));
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		return true;
	} else {
		return false;
	}
}

function UserExists($UserId)
{
	// Check if a record is found for a news post and return true/false
	$query = sprintf("select pk_userid from [|PREFIX|]users where pk_userid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($UserId));
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		return true;
	} else {
		return false;
	}
}

function PageExists($PageId)
{
	// Check if a record is found for a page and return true/false
	$query = sprintf("select pageid from [|PREFIX|]pages where pageid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($PageId));
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		return true;
	} else {
		return false;
	}
}

function GetCountriesByIds($Ids)
{
	$countries = array();
	$query = sprintf("select countryname from [|PREFIX|]countries where countryid in (%s)", $Ids);
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		array_push($countries, $row['countryname']);
	}

	return $countries;
}

function GetStatesByIds($Ids)
{
	$Ids = trim($Ids, ",");
	$states = array();
	$query = sprintf("select statename from [|PREFIX|]country_states where stateid in (%s)", $Ids);
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		array_push($states, $row['statename']);
	}

	return $states;
}

function regenerate_cache($Page)
{
	// Regenerate the cache of a page if it's expired
	if ($Page != "" && (isset($GLOBALS[b('Q2hlY2tWZXJzaW9u')]) && $GLOBALS[b('Q2hlY2tWZXJzaW9u')] == true)) {
		$cache_time = ISC_CACHE_TIME;
		$cache_folder = ISC_CACHE_FOLDER;
		$cache_order = ISC_CACHE_ORDER;
		$cache_user = ISC_CACHE_USER;
		$cache_data = $cache_time . $cache_folder . $cache_order . $cache_user;
		// Can we regenerate the cache?
		if (!cache_exists($cache_data)) {
			$cache_built = true;
		}
	}
}

/**
 *	Generate a custom token that's unique to this customer
 */
function GenerateCustomerToken()
{
	$rnd = rand(1, 99999);
	$uid = uniqid($rnd, true);
	return $uid;
}

/**
 *	Is the customer logged into his/her account?
 */
function CustomerIsSignedIn()
{
	$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
	if ($GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId()) {
		return true;
	} else {
		return false;
	}
}

/**
 *	Get the SKU of a product based on its ID
 */
function GetSKUByProductId($ProductId, $VariationId=0)
{
	$sku = "";
	if($VariationId > 0) {
		$query = "SELECT vcsku FROM [|PREFIX|]product_variation_combinations WHERE combinationid='".(int)$VariationId."'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$sku = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
		if($sku) {
			return $sku;
		}
	}

	// Still here? Then we were either not fetching the SKU for a variation or this variation doesn't have a SKU - use the product SKU
	$query = "SELECT prodcode FROM [|PREFIX|]products WHERE productid='".(int)$ProductId."'";
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
	$sku = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
	return $sku;
}

/**
 *	Get the product type (digital or physical) of a product based on its ID
 */
function GetTypeByProductId($ProductId)
{
	$prod_type = "";
	$query = sprintf("select prodtype from [|PREFIX|]products where productid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($ProductId));
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

	if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
		$prod_type = $row['prodtype'];
	}

	return $prod_type;
}

if (!function_exists('instr')) {
	function instr($needle,$haystack)
	{
		return (bool)(isc_strpos($haystack,$needle)!==false);
	}
}


if (!defined('FILE_USE_INCLUDE_PATH')) {
	define('FILE_USE_INCLUDE_PATH', 1);
}

if (!defined('LOCK_EX')) {
	define('LOCK_EX', 2);
}

if (!defined('FILE_APPEND')) {
	define('FILE_APPEND', 8);
}

function lower(&$string){
	$string = strtolower($string);
}

function altname_sort($a,$b){
	return strlen($b)-strlen($a);
}

/**
 * Builds an array of product search terms from an array of input (handles advanced language searching, category selections)
 *
 * @param array Array of search input
 * @return array Formatted search input array
 */
function BuildProductSearchTerms($input)
{
	$regex_chars = array('/\//','/\^/','/\$/','/\./','/\[/','/\]/','/\|/','/\(/','/\)/','/\?/','/\*/','/\+/','/\{/','/\}/');
	$regex_replace_chars = array('\/','\^','\$','\.','\[','\]','\|','\(','\)','\?','\*','\+','\{','\}');
			
	//wirror_2010_10_21:search enhancement
	$ismartSearch = (isset($input['is_smart_search']) && $input['is_smart_search']==1) ? true : false;
	
	$input['search_query'] = '';
	if(isset($input['search_query']))
	{
	 	$input['search_query'] = html_entity_decode($input['search_query']);
	}
	$input['search_query'] = trim($input['search_query']);
	$spl_strings = array("+",":", ";","!","@","#","$","%","^","*","\\");

	$input['search_query'] = str_replace($spl_strings," ",$input['search_query']);
	$input['search_query'] = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($input['search_query']));
	$srch_arr = array();

	if(!empty($input['search_query']))
	$srch_arr = explode(" ",$input['search_query']);
	 
	$make = "";
	$model = "";
	$submodel = "";
	$startyear = "";
	$endyear = "";

	$compare_catg_name = "";  // this variable is used to check the position of catgory and brand
	$compare_brand_name = "";	// this variable is used to check the position of catgory and brand

	array_walk($srch_arr,'lower');

	$new_srch_str = implode("','",$srch_arr);

	/*-- finding the qualifiers----*/
	$qualifier_count = 0;
	$GLOBALS['v_cols'] = array();
	$GLOBALS['p_cols'] = array();
	$GLOBALS['visible_pqvq'] = array();

	/*-- end of finding the qualifiers----*/

	$count_srch = count($srch_arr);

	$flag_brand = 0;
	$flag_brand_series = 0;
	$flag_catg = 0;
	$flag_sub_catg = 0; // 0 for parent catg & 1 for sub-catg
	$flag_alt_names = 0; // 0 for not matching alternate names & 1 for matching

	if($count_srch > 0) {    // if there are any search criterias, then we need to check it in category list.

		$brandname = array();
		$brandaltname = array();
		$brand_qry = "select brandid, brandname, brandaltkeyword from [|PREFIX|]brands order by CHAR_LENGTH(brandname) desc";
		$brand_res =  $GLOBALS['ISC_CLASS_DB']->Query($brand_qry);
		while($brand_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($brand_res))
		{
			$brandname[$brand_arr['brandid']] = $brand_arr['brandname'];
			$brandaltname[$brand_arr['brandid']] = $brand_arr['brandaltkeyword'];
		}

		$catg_qry = "select * from [|PREFIX|]categories order by catparentid ASC , CHAR_LENGTH(catname) DESC";
		$catg_res =  $GLOBALS['ISC_CLASS_DB']->Query($catg_qry);

		$catgoryname = array();    // array for category names
		$categoryaltname = array(); // array for alternate keywords
		$catuniversal = array();

		while($catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($catg_res))
		{
			$catgoryname[$catg_arr['categoryid']]['catname'] = $catg_arr['catname'];
			$catgoryname[$catg_arr['categoryid']]['catparentid'] = $catg_arr['catparentid'];
				
			$categoryaltname[$catg_arr['categoryid']]['catname'] = $catg_arr['catname'];
			$categoryaltname[$catg_arr['categoryid']]['altkeywords'] = $catg_arr['cataltkeyword'];
			$categoryaltname[$catg_arr['categoryid']]['catparentid'] = $catg_arr['catparentid'];
			$catuniversal[$catg_arr['categoryid']] =  $catg_arr['catuniversal'];
		}
		$GLOBALS['categories_all'] = $catgoryname;

		//wirror_2010_10_21: search enhancement
		if(!$ismartSearch){
			$common_qry =	 "select brandname as typename, 'brand' as type, brandid as 'id' from [|PREFIX|]brands
								UNION ALL
								( select catname as typename, 'category' as type, categoryid as 'id' from [|PREFIX|]categories c order by catparentid )
								order by CHAR_LENGTH(typename) DESC , typename asc ";
			$common_res	=	$GLOBALS['ISC_CLASS_DB']->Query($common_qry);
			
			while($common_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($common_res))
			{
				$brand_name = strtolower($common_arr['typename']);
				$in_str = "";
				$track_srch_key = array();
				for($k=0;$k<$count_srch;$k++)
				{
					$srchkey = preg_replace($regex_chars,$regex_replace_chars,$srch_arr[$k]);

					if($in_str == "")
					$match = "/(^$srchkey(\s{1})|^$srchkey\b)/i";
					else
					$match = "/(((\s{1})$srchkey(\s{1}))|((\s{1})$srchkey$))/i";

					if(preg_match($match,$brand_name)) {
						$track_srch_key[] = $k;
						if(!empty($in_str))
						$in_str .= " ".$srch_arr[$k];
						else
						$in_str .= $srch_arr[$k];

						if($brand_name == $in_str) // if matched early, then need to break it here.
						break;
					}
				}

				if( $in_str == '' )
				{
					for($k=0;$k<$count_srch;$k++)
					{
						$srchkey = preg_replace($regex_chars,$regex_replace_chars,rtrim($srch_arr[$k], 's'));

						if($in_str == "")
						$match = "/(^$srchkey(\s{1})|^$srchkey\b)/i";
						else
						$match = "/(((\s{1})$srchkey(\s{1}))|((\s{1})$srchkey$))/i";

						if(preg_match($match,$brand_name)) {
							$track_srch_key[] = $k;
							if(!empty($in_str))
							$in_str .= " ".rtrim($srch_arr[$k], 's');
							else
							$in_str .= rtrim($srch_arr[$k], 's');

							if($brand_name == $in_str ) // if matched early, then need to break it here.
							break;
						}
					}
				}

				if($brand_name == $in_str) {
					foreach($track_srch_key as $key => $val) {
						unset($srch_arr[$val]);
					}
					$srch_arr = array_values($srch_arr);
						
					if($common_arr['type'] == 'brand')
					{
						$compare_brand_name = $in_str;
						$brandid = $common_arr['id'];
						$input['brand'] = $brand_name;
						$flag_brand = 1;
						$GLOBALS['ISC_SRCH_BRAND_NAME'] = $brand_name;
					}
					else if($common_arr['type'] == 'category')
					{
						$catg_name = strtolower($common_arr['typename']);
						$key =	$common_arr['id'];
						if($catgoryname[$key]['catparentid'] != 0)   // checking its not a parent catg ?
						$flag_sub_catg = 1;

						$compare_catg_name = $in_str;
						$catg_id = $key;
						$flag_catg = 1;
						$input['catuniversal'] = $catuniversal[$key];
					}

					break;
				}
			}
		}
			
		$count_srch = count($srch_arr);

		/*---- Brand Names --------*/
		//wirror_2010_10_21: search enhancement
		if($flag_brand == 0 && !$ismartSearch)
		{
			foreach($brandname as $bkey => $bvalue) {
				$brand_name = strtolower($bvalue);
				$in_str = "";
				$track_srch_key = array();
				for($k=0;$k<$count_srch;$k++)
				{
					if(stristr($brand_name,rtrim($srch_arr[$k], 's'))) {
						$track_srch_key[] = $k;
						if(!empty($in_str))
						$in_str .= " ".rtrim($srch_arr[$k],'s');
						else
						$in_str .= rtrim($srch_arr[$k],'s');
					}
				}
					
				if($brand_name == $in_str or $brand_name == $in_str.'s' ) {//condition for brand ending with 's'
					$compare_brand_name = $in_str;
					foreach($track_srch_key as $key => $val) {
						unset($srch_arr[$val]);
					}
					$srch_arr = array_values($srch_arr);
					$brandid = $bkey;
					$input['brand'] = $bvalue;
					$flag_brand = 1;
					$GLOBALS['ISC_SRCH_BRAND_NAME'] = ucwords($bvalue);
					break;
				}
			}
		}
		/*---- ALternate Names For Brands --------*/
		if($flag_brand == 0) {
			foreach($brandaltname as $baltkey => $baltvalue) {
				if(!empty($baltvalue)) {
					$balt_name = strtolower($baltvalue);
					$brandalternate_names = explode(",",$balt_name);
					usort($brandalternate_names,'altname_sort');
					for($i=0;$i<count($brandalternate_names);$i++)
					{
						$in_str = "";
						$track_srch_key = array();
						$brand_name = $brandname[$baltkey];
						for($k=0;$k<$count_srch;$k++)
						{
							if(stristr($brandalternate_names[$i],rtrim($srch_arr[$k], 's'))) {
								$track_srch_key[] = $k;
								if(!empty($in_str))
								$in_str .= " ".rtrim($srch_arr[$k], 's');
								else
								$in_str .= rtrim($srch_arr[$k], 's');
							}
						}
							
						if(ltrim($brandalternate_names[$i]) == $in_str || ltrim($brandalternate_names[$i]) == $in_str.'s' ) {
							$compare_brand_name = $in_str;
							foreach($track_srch_key as $key => $val) {
								unset($srch_arr[$val]);
							}
							$srch_arr = array_values($srch_arr);
							$brandid = $baltkey;
							$input['brand'] = $brand_name;
							$flag_brand = 1;
							$GLOBALS['ISC_SRCH_BRAND_NAME'] = ucwords($brand_name);
							break;
						}
					}
				}
			}
		}

		if($flag_brand == 0)  // if brand is not selected, then need to search in series list
		{
			$brandseriesname = array();
			$brandseriesaltname = array();
			$brseriesparent = array();
			$series_qry = "select seriesid , s.brandid , brandname , seriesname , seriesaltkeyword from [|PREFIX|]brand_series s left join [|PREFIX|]brands b on b.brandid = s.brandid order by CHAR_LENGTH(seriesname) desc";
			$series_res = $GLOBALS['ISC_CLASS_DB']->Query($series_qry);
			while($series_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($series_res))
			{
				$brseriesparent[$series_arr['seriesid']] = $series_arr['brandid'];
				$brandseriesname[$series_arr['seriesid']] = $series_arr['seriesname'];
				$brandseriesaltname[$series_arr['seriesid']] = $series_arr['seriesaltkeyword'];
			}

			/* -------- for series names ----------- */
			//wirror_2010_10_21: search enhancement
			if(!$ismartSearch){
				foreach($brandseriesname as $bskey => $bsvalue) {
					$series_name = strtolower($bsvalue);
					$in_str = "";
					$track_srch_key = array();
					for($k=0;$k<$count_srch;$k++)
					{
						if(stristr($series_name,rtrim($srch_arr[$k], 's'))) {
							$track_srch_key[] = $k;
							if(!empty($in_str))
							$in_str .= " ".rtrim($srch_arr[$k], 's');
							else
							$in_str .= rtrim($srch_arr[$k], 's');
						}
					}

					if($series_name == $in_str || $series_name == $in_str.'s' ) {
						$compare_brand_name = $in_str;
						foreach($track_srch_key as $key => $val) {
							unset($srch_arr[$val]);
						}
						$srch_arr = array_values($srch_arr);
						$brandid = $brseriesparent[$bskey];
						$input['brand'] = $brandname[$brandid];
						$input['series'] = $bsvalue;
						$flag_brand = 1;
						$flag_brand_series = 1; // need to assign, to know the series has been selected
						$GLOBALS['BRAND_SERIES_FLAG'] = 1;
						$GLOBALS['ISC_SRCH_BRAND_NAME'] =  ucwords($brandname[$brseriesparent[$bskey]]);
						break;
					}
				}
			}
			/* -------- for series alternate keywords ----------- */

			if($flag_brand == 0) {
				foreach($brandseriesaltname as $bsaltkey => $bsaltvalue) {
					if(!empty($bsaltvalue)) {
						$bsalt_name = strtolower($bsaltvalue);
						$brandseriesalternate_names = explode(",",$bsalt_name);
						usort($brandseriesalternate_names,'altname_sort');
						for($i=0;$i<count($brandseriesalternate_names);$i++)
						{
							$in_str = "";
							$track_srch_key = array();
							$brand_name = $brandname[$brseriesparent[$bsaltkey]];
							for($k=0;$k<$count_srch;$k++)
							{
								if(stristr($brandseriesalternate_names[$i],rtrim($srch_arr[$k], 's'))) {
									$track_srch_key[] = $k;
									if(!empty($in_str))
									$in_str .= " ".rtrim($srch_arr[$k], 's');
									else
									$in_str .= rtrim($srch_arr[$k], 's');
								}
							}
								
							if(ltrim($brandseriesalternate_names[$i]) == $in_str || ltrim($brandseriesalternate_names[$i]) == $in_str.'s') {
								$compare_brand_name = $in_str;
								foreach($track_srch_key as $key => $val) {
									unset($srch_arr[$val]);
								}
								$srch_arr = array_values($srch_arr);
								$brandid = $brseriesparent[$bsaltkey];
								$input['brand'] = $brandname[$brandid];
								$input['series'] = $brandseriesname[$bsaltkey];
								$flag_brand = 1;
								$flag_brand_series = 1; // need to assign, to know the series has been selected
								$GLOBALS['BRAND_SERIES_FLAG'] = 1;
								$GLOBALS['ISC_SRCH_BRAND_NAME'] =  ucwords($brandname[$brandid]);
								break;
							}
						}
					}
				}
			}

		}

		$count_srch = count($srch_arr);

		if($count_srch > 0 && $flag_catg == 0)
		{

			/* Checking first in category names */
			//wirror_2010_10_21: search enhancement
			if(!$ismartSearch){
				foreach($catgoryname as $key => $value)//($i=0;$i<count($catgoryname);$i++)
				{
					$catg_name = strtolower($catgoryname[$key]['catname']);
					//$catg_name = strtolower($catgoryname[$i]);
					$in_str = "";
					$track_srch_key = array();
					for($k=0;$k<$count_srch;$k++)
					{
						if(stristr($catg_name,rtrim($srch_arr[$k], 's'))) {
							$track_srch_key[] = $k;
							if(!empty($in_str))
							$in_str .= " ".rtrim($srch_arr[$k], 's');
							else
							$in_str .= rtrim($srch_arr[$k], 's');
								
							if($catg_name == $in_str || $catg_name == $in_str.'s' )
							break;
						}
					}

					if($catg_name == $in_str || $catg_name == $in_str.'s') {

						$compare_catg_name = $in_str;

						for($j=0;$j<count($track_srch_key);$j++) {
							unset($srch_arr[$track_srch_key[$j]]);
						}
						$srch_arr = array_values($srch_arr);

						if($catgoryname[$key]['catparentid'] != 0)   // checking its not a parent catg ?
						$flag_sub_catg = 1;

						$catg_id = $key;
						$flag_catg = 1;
						$input['catuniversal'] = $catuniversal[$key];
						break;
					}

				}
			}
			/* Checking in category alternate names */
			if($flag_catg == 0) {
					
				//NI CLOUD 2010-07-28
				//filter to get longest alt keywords
				$altcat = array();
				foreach( $categoryaltname as $altkey => $altvalue)
				{
					$categoryaltname[$altkey]['altkeywords'] = trim($categoryaltname[$altkey]['altkeywords']);
					if(!empty($categoryaltname[$altkey]['altkeywords'])) {
						$catg_name = strtolower($categoryaltname[$altkey]['catname']);
							
						$alternate_names = explode(",",$categoryaltname[$altkey]['altkeywords']);
						usort($alternate_names,'altname_sort');

						for($i=0;$i<count($alternate_names);$i++)
						{
							$in_str = "";
							$track_srch_key = array();
							$altname = strtolower(trim($alternate_names[$i]));
							for($k=0;$k<$count_srch;$k++)
							{
								if(strlen(stristr($altname,rtrim($srch_arr[$k], 's'))) > 0 ) {
									$track_srch_key[] = $k;
									if(!empty($in_str))
									$in_str .= " ".$srch_arr[$k];
									else
									$in_str .= $srch_arr[$k];

									if($altname == rtrim($in_str, 's'))
									$altcat[] = $altname;
								}
							}
						}
					}
				}

				$max = '';
				for($m=0;$m<count($altcat);$m++)
				{
					if( strlen($max) < strlen($altcat[$m]) )
					$max = $altcat[$m];
				}


				foreach( $categoryaltname as $altkey => $altvalue)
				{
					$categoryaltname[$altkey]['altkeywords'] = trim($categoryaltname[$altkey]['altkeywords']);
					if(!empty($categoryaltname[$altkey]['altkeywords'])) {
							
						$catg_name = strtolower($categoryaltname[$altkey]['catname']);
							
						$alternate_names = explode(",",$categoryaltname[$altkey]['altkeywords']);
						usort($alternate_names,'altname_sort');
							
						for($i=0;$i<count($alternate_names);$i++)
						{
							$in_str = "";
							$track_srch_key = array();
							$altname = strtolower(trim($alternate_names[$i]));
							for($k=0;$k<$count_srch;$k++)
							{
								if(stristr($max,rtrim($srch_arr[$k], 's'))) {
									$track_srch_key[] = $k;
									if(!empty($in_str))
									$in_str .= " ".$srch_arr[$k];
									else
									$in_str .= $srch_arr[$k];

									if($max == rtrim($in_str, 's'))
									break;
								}
							}
								
								
							if($altname == rtrim($in_str, 's') && strlen($altname)>0) {
								$compare_catg_name = rtrim($in_str, 's');
								for($j=0;$j<count($track_srch_key);$j++) {
									unset($srch_arr[$track_srch_key[$j]]);
								}
								$srch_arr = array_values($srch_arr);
									
								if($categoryaltname[$altkey]['catparentid'] != 0)   // checking its not a parent catg ?
								$flag_sub_catg = 1;
									
								$catg_id = $altkey;
								$flag_catg = 1;
								$input['catuniversal'] = $catuniversal[$altkey];
								break;
							}
								
						}
							
						if($flag_catg == 1)
						break;

					}
				}
			}
		}
	}

	/*----------------- for selecting category ---------------------*/
	 
	if(isset($_GET['search_key']) || isset($_REQUEST['search']))  {

		if (in_array("chevy", $srch_arr)) {
			$input['make'] = "chevrolet";
			$key = array_search('chevy',$srch_arr);
			unset($srch_arr[$key]);
			$srch_arr = array_values($srch_arr);
		}
		 

		$inner_qry = "";
		$flag_model = 0;

		if(count($srch_arr) > 0) {
			$query = " select distinct q.column_name , v.qid , q_value from isc_qualifier_value v left join isc_qualifier_names q on v.qid = q.qid where v.qid != 0 and ( ";
			foreach($srch_arr as $key => $value)
			{
				if(empty($inner_qry))
				$inner_qry .= " q_value like '%$value%' ";
				else
				$inner_qry .= " OR q_value like '%$value%' ";
			}
			if($inner_qry == "")
			$inner_qry .= " 1=1 ";

			$query .= $inner_qry." ) order by qid , CHAR_LENGTH(q_value) desc";
			$srch_res1 = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$model_array = array();
			$model_qry = "";
			while($srch_row1 = $GLOBALS['ISC_CLASS_DB']->Fetch($srch_res1))
			{
				if($srch_row1['qid'] == 1) {
					if(!isset($input['make'])) {
						$in_make = "";
						$track_make_array = array();
						for($j=0;$j<count($srch_arr);$j++)
						{
							if (stristr($srch_row1['q_value'] , $srch_arr[$j])) {
								$track_make_array[] = $j;
								if(!empty($in_make))
								$in_make .= " ".$srch_arr[$j];
								else
								$in_make .= $srch_arr[$j];

								if($in_make == strtolower($srch_row1['q_value']))
								break;
							}
						}
						if($in_make == strtolower($srch_row1['q_value'])) {
							$input['make'] = $srch_row1['q_value'];
							for($k=0;$k<count($track_make_array);$k++)
							{
								unset($srch_arr[$track_make_array[$k]]);
							}
							$srch_arr = array_values($srch_arr);
						}
					}
				} else if($srch_row1['qid'] == 2) {
					if(isset($input['make']) && $model_qry == "" && $input['make'] != "") // if make is selected
					{
						$inner_qry = "";
						$model_qry = "select distinct prodmodel from isc_import_variations where prodmake = '".$input['make']."' and ( ";
						foreach($srch_arr as $key => $value)
						{
							if(empty($inner_qry))
							$inner_qry .= " prodmodel like '%$value%' ";
							else
							$inner_qry .= " OR prodmodel like '%$value%' ";
						}
						if(empty($inner_qry))
						$inner_qry  = " 1=1 ";

						$model_qry .= $inner_qry . " )   order by CHAR_LENGTH(prodmodel) desc";

						$model_res = $GLOBALS['ISC_CLASS_DB']->Query($model_qry);

						while($model_row = $GLOBALS['ISC_CLASS_DB']->Fetch($model_res))
						{
							if( $flag_model == 0 )
							{
								$in_str = "";
								$track_srch_key = array();
								$count_model_str = 1;
								$temp_str = "";
								$model_array = array();
								$model_value = strtolower($model_row['prodmodel']);
								for($k=0;$k<count($srch_arr);$k++)
								{

									$srchkey = preg_replace($regex_chars,$regex_replace_chars,$srch_arr[$k]);

									if($in_str == "")
									$match = "/(^$srchkey(\s{1})|^$srchkey\b)/i";
									else
									$match = "/((\s{1})$srchkey\b)/i";

									if(preg_match($match,$model_value)) {
										if($count_model_str > 1)
										{
											$temp_str = $in_str." ".$srch_arr[$k];
											if(($m = stripos($model_value , $temp_str)) !== false) {
												$track_srch_key[] = $k;
												$in_str .= " ".$srch_arr[$k];
												$count_model_str++;
											}
										}
										else
										{
											$track_srch_key[] = $k;
											$in_str .= $srch_arr[$k];
											$count_model_str++;
										}

									}
								}
								//echo "<br>".$in_str;
								if($in_str != "" && $in_str == $model_value)
								{
									$input['model'] = $in_str;
									for($j=0;$j<count($track_srch_key);$j++) {
										unset($srch_arr[$track_srch_key[$j]]);
									}
									$srch_arr = array_values($srch_arr);
									unset($model_array);
									$flag_model = 1;
									break;
								}
								else if($in_str != "")
								{
									if(!isset($input['model']))
									{
										$model_array = $track_srch_key;
										$input['model'] = $in_str;
									}
									else if($m = stripos($in_str , $input['model']) !== false)
									{
										$model_array = $track_srch_key;
										$input['model'] = $in_str;
									}

								}
							}
						}
					}
					else if(!isset($input['make']))	// if make is not selected
					{
						if( $flag_model == 0 )
						{
							$in_str = "";
							$track_srch_key = array();
							$count_model_str = 1;
							$temp_str = "";
							$model_array = array();
							$model_value = strtolower($srch_row1['q_value']);
							for($k=0;$k<count($srch_arr);$k++)
							{

								$srchkey = preg_replace($regex_chars,$regex_replace_chars,$srch_arr[$k]);

								if($in_str == "")
								$match = "/(^$srchkey(\s{1})|^$srchkey\b)/i";
								else
								$match = "/((\s{1})$srchkey\b)/i";

								if(preg_match($match,$model_value)) {

									if($count_model_str > 1)
									{
										$temp_str = $in_str." ".$srch_arr[$k];
										if(($m = stripos($model_value , $temp_str)) !== false) {
											$track_srch_key[] = $k;
											$in_str .= " ".$srch_arr[$k];
											$count_model_str++;
										}
									}
									else
									{
										$track_srch_key[] = $k;
										$in_str .= $srch_arr[$k];
										$count_model_str++;
									}

								}
							}

							if($in_str != "" && $in_str == $model_value)
							{
								$input['model'] = $in_str;
								for($j=0;$j<count($track_srch_key);$j++) {
									unset($srch_arr[$track_srch_key[$j]]);
								}
								$srch_arr = array_values($srch_arr);
								unset($model_array);
								$flag_model = 1;
								break;
							}
							else if($in_str != "")
							{
								if(!isset($input['model']))
								{
									$model_array = $track_srch_key;
									$input['model'] = $in_str;
								}
								else if($m = stripos($in_str , $input['model']) !== false)
								{
									$model_array = $track_srch_key;
									$input['model'] = $in_str;
								}

							}
						}
					}
				} else if( $srch_row1['qid'] == 4 || $srch_row1['qid'] == 5 ) {

					/* this below patch is used to remove keywords selected from the search array where model is partial selected */
					if(isset($model_array) && !empty($model_array) && $flag_model == 0) {
						for($j=0;$j<count($model_array);$j++) {
							unset($srch_arr[$model_array[$j]]);
						}
						$srch_arr = array_values($srch_arr);
						unset($model_array);
					}

					if(!isset($input['year'])) {
						for($j=0;$j<count($srch_arr);$j++)
						{
							if($srch_row1['q_value'] == $srch_arr[$j]) {
								$input['year'] = $srch_row1['q_value'];
								unset($srch_arr[$j]);
								$srch_arr = array_values($srch_arr);
								break;
							}
						}
					}
				} else if( $srch_row1['qid'] != 6 && $srch_row1['qid'] != 7 ) {

					/* this below patch is used to remove keywords selected from the search array where model is partial selected */
					if(isset($model_array) && !empty($model_array) && $flag_model == 0) {
						for($j=0;$j<count($model_array);$j++) {
							unset($srch_arr[$model_array[$j]]);
						}
						$srch_arr = array_values($srch_arr);
						unset($model_array);
					}

					if(isset($input[$srch_row1['column_name']]))
					continue;

					$qualifier_names = explode(";",$srch_row1['q_value']);
					for($j=0;$j<count($qualifier_names);$j++)
					{
						$in_str = "";
						$track_srch_key = array();
						$qualifier_name = strtolower($qualifier_names[$j]);
						for($k=0;$k<count($srch_arr);$k++)
						{
							//if(stristr($srch_row1['prodmodel'],$srch_arr[$j]))
							//if(strtolower($srch_row1['prodmodel']) == $srch_arr[$j])

							$srchkey = preg_replace($regex_chars,$regex_replace_chars,$srch_arr[$k]);

							if($in_str == "")
							$match = "/(^$srchkey(\s{1})|^$srchkey\b)/i";
							else
							$match = "/(((\s{1})$srchkey(\s{1}))|((\s{1})$srchkey$))/i";

							if(preg_match($match,$qualifier_name)) {
								$track_srch_key[] = $k;
								if(!empty($in_str))
								$in_str .= " ".$srch_arr[$k];
								else
								$in_str .= $srch_arr[$k];

								if($qualifier_name == $in_str) // if matched early, then need to break it here.
								break;
							}
						}
						if($qualifier_name == $in_str) // if matched early, then need to break it here.
						break;
					}

					if($qualifier_name == $in_str) {
						$input[strtolower($srch_row1['column_name'])] = $qualifier_name;
						foreach($track_srch_key as $key => $val) {
							unset($srch_arr[$val]);
						}
						$srch_arr = array_values($srch_arr);
					}
				}

				if(count($srch_arr) == 0)
				break;
				 
			}

			if(isset($model_array) && !empty($model_array) && $flag_model == 0) {
				for($j=0;$j<count($model_array);$j++) {
					unset($srch_arr[$model_array[$j]]);
				}
				$srch_arr = array_values($srch_arr);
				unset($model_array);
			}

			$bedsize_qry = " select distinct irregular_value as vqvalue from [|PREFIX|]bedsize_translation where irregular_value != 'Short bed' and irregular_value != 'Full Crew Cab' UNION select distinct generalize_value as vqvalue from [|PREFIX|]bedsize_translation where generalize_value != 'Short bed' and generalize_value != 'Mega Cab' order by char_length(vqvalue) desc ";
				
			$bedsize_res = $GLOBALS['ISC_CLASS_DB']->Query($bedsize_qry);
			$temp_bedsize = array();
			while($bedsize_row = $GLOBALS['ISC_CLASS_DB']->Fetch($bedsize_res))
			{
				$in_str = "";
				$track_srch_key = array();
				//$temp_bedsize = array();
				$count_model_str = 1;
				$bed_value = strtolower($bedsize_row['vqvalue']);
				for($j=0;$j<count($srch_arr);$j++)
				{
					$srchkey = preg_replace($regex_chars,$regex_replace_chars,$srch_arr[$j]);
					$match = "/(((\s{1})$srchkey(\s{1}))|(\b$srchkey(\s{1}))|((\s{1})$srchkey\b)|(^$srchkey$))/i";
						
					if (preg_match($match , $bed_value))
					{
						if($count_model_str > 1)
						{
							$track_srch_key[] = $j;
							$in_str .= " ".$srch_arr[$j];
							$count_model_str++;
						}
						else
						{
							$track_srch_key[] = $j;
							$in_str .= $srch_arr[$j];
							$count_model_str++;
						}
					}
				}

				if($in_str != "" && $in_str == $bed_value)
				{
					$input['vqbedsize'] = $in_str;
					for($j=0;$j<count($track_srch_key);$j++) {
						unset($srch_arr[$track_srch_key[$j]]);
					}
					$srch_arr = array_values($srch_arr);
					unset($temp_bedsize);
					break;
				}
				else if($in_str != "")
				{
					if( count($track_srch_key) == 1 && trim($in_str) == 'bed' && count($track_srch_key) > count($temp_bedsize) )
					{
						$input['vqsbedsize'] = $in_str;
						$temp_bedsize = $track_srch_key;
					}
					else if( count($track_srch_key) > 1 && count($track_srch_key) > count($temp_bedsize) )
					{
						$input['vqsbedsize'] = $in_str;
						$temp_bedsize = $track_srch_key;
					}
				}
			}
				
			if(isset($temp_bedsize) && !empty($temp_bedsize)) {
				for($j=0;$j<count($temp_bedsize);$j++) {
					unset($srch_arr[$temp_bedsize[$j]]);
				}
				$srch_arr = array_values($srch_arr);
				unset($temp_bedsize);
			}
				
			$cabsize_qry = " select distinct irregular_value as vqvalue from [|PREFIX|]cabsize_translation
			UNION select distinct generalize_value as vqvalue from [|PREFIX|]cabsize_translation
			order by char_length(vqvalue) desc ";
				
			$cabsize_res = $GLOBALS['ISC_CLASS_DB']->Query($cabsize_qry);
			$temp_cabsize = array();
			while($cabsize_row = $GLOBALS['ISC_CLASS_DB']->Fetch($cabsize_res))
			{
				$in_str = "";
				$track_srch_key = array();
				$count_model_str = 1;
				$cab_value = strtolower($cabsize_row['vqvalue']);
				for($j=0;$j<count($srch_arr);$j++)
				{
					$srchkey = preg_replace($regex_chars,$regex_replace_chars,$srch_arr[$j]);
					$match = "/(((\s{1})$srchkey(\s{1}))|(\b$srchkey(\s{1}))|((\s{1})$srchkey\b)|(^$srchkey$))/i";
					if (preg_match($match , $cab_value))
					{
						if($count_model_str > 1)
						{
							$track_srch_key[] = $j;
							$in_str .= " ".$srch_arr[$j];
							$count_model_str++;
						}
						else
						{
							$track_srch_key[] = $j;
							$in_str .= $srch_arr[$j];
							$count_model_str++;
						}
					}
				}

				if($in_str != "" && $in_str == $cab_value)
				{
					$input['vqcabsize'] = $in_str;
					for($j=0;$j<count($track_srch_key);$j++) {
						unset($srch_arr[$track_srch_key[$j]]);
					}
					$srch_arr = array_values($srch_arr);
					unset($temp_cabsize);
					break;
				}
				else if($in_str != "")
				{
					if( count($track_srch_key) == 1 && trim($in_str) == 'cab' && count($track_srch_key) > count($temp_cabsize) )
					{
						$input['vqscabsize'] = $in_str;
						$temp_cabsize = $track_srch_key;
					}
					else if( count($track_srch_key) > 1 && count($track_srch_key) > count($temp_bedsize) )
					{
						$input['vqscabsize'] = $in_str;
						$temp_cabsize = $track_srch_key;
					}
				}
			}

			if(isset($temp_cabsize) && !empty($temp_cabsize)) {
				for($j=0;$j<count($temp_cabsize);$j++) {
					unset($srch_arr[$temp_cabsize[$j]]);
				}
				$srch_arr = array_values($srch_arr);
				unset($temp_cabsize);
			}

			/*
			 if(!isset($input['make']) && isset($input['model']) )
			 {
				$get_make_qry = "select distinct make from isc_product_mmy where model like '".$input['model']."%' limit 0,1";
				$get_make_res = $GLOBALS['ISC_CLASS_DB']->Query($get_make_qry);
				$get_make_row = $GLOBALS['ISC_CLASS_DB']->FetchOne($get_make_res);
				$input['make'] = $get_make_row;
				}
				*/
			if(!isset($input['year'])) {
				for($i=0;$i<count($srch_arr);$i++)
				{
					if(is_numeric($srch_arr[$i])) {
						if(strlen($srch_arr[$i]) == 2) {
							$prodyr = $srch_arr[$i];
							$curr_yr = date('y');

							if($prodyr >= 00 && $prodyr <= $curr_yr)
							$prodyr = 2000 + $prodyr;
							else
							$prodyr = 1900 + $prodyr;

						} else {
							$prodyr = $srch_arr[$i];
						}

						$year_qry = " select year1 , year2  from (select min(prodstartyear) as year1 from isc_import_variations where prodstartyear != '') sy , (select max(prodendyear) as year2 from isc_import_variations where prodendyear != 'ALL' ) ey where $prodyr between year1 and year2 ";
						$year_result = $GLOBALS['ISC_CLASS_DB']->Query($year_qry);
						$year_row = $GLOBALS['ISC_CLASS_DB']->CountResult($year_result);

						if($year_row == 1) {
							$input['year'] = $prodyr;
							unset($srch_arr[$i]);
							$srch_arr = array_values($srch_arr);
							break;
						}
					}
				}
			}

			// checking the partnumber from the remaining search parameters
			if(count($srch_arr) > 0) {
				$inner_qry = "";
				$product_code_query = " SELECT prodcode FROM [|PREFIX|]products p WHERE ";
				foreach($srch_arr as $key => $value)
				{
					if(empty($inner_qry))
					$inner_qry .= " prodcode like '$value%' ";
					else
					$inner_qry .= " OR prodcode like '$value%' ";
				}
				$product_code_query .= $inner_qry;
				$product_code_res = $GLOBALS['ISC_CLASS_DB']->Query($product_code_query);
				while($product_code_row = $GLOBALS['ISC_CLASS_DB']->Fetch($product_code_res))
				{
					$prod_code = strtolower($product_code_row['prodcode']);
					$track_srch_key = array();
					for($j=0;$j<count($srch_arr);$j++)
					{
						if(stristr($prod_code,$srch_arr[$j]))
						{
							if($prod_code == $srch_arr[$j])
							{
								unset($srch_arr[$j]);
								$srch_arr = array_values($srch_arr);
								$input['partnumber'] = $prod_code;
								$partnumber_flag = 0;
								break;
							} else {
								$input['partnumber'] = $srch_arr[$j];
								$partnumber_flag = 1;
							}
						}
					}

					if($partnumber_flag == 0)
					break;
				}
			}

		}

		$input['search_string']	=	implode(" ",$srch_arr);
		 
		/*----------------- End for selecting category ---------------------*/

	}


	$searchTerms = array();
	$matches = array();
	$searchTerms['dynfilters'] = array();

	/*----------------- for selecting category ---------------------*/
	$searchTerms['flag_srch_category'] = 0;

	if(isset($input['partnumber'])) {
		$searchTerms['partnumber'] = $input['partnumber'];
	}

	if(isset($input['search'])) {
		$searchTerms['search'] = $input['search'];
	}

	if(isset($input['searchtext'])) {
		$searchTerms['searchtext'] = $input['searchtext'];
	}

	if(isset($input['search_string'])) {
		$searchTerms['search_string'] = $input['search_string'];
	}

	/* the below code is to find out whether category or brand is entered first */
	$check_position = 0; // 1 if catg is first and 0 if brand is first
	if($flag_catg == 1 && $flag_brand == 1)
	{
		$catg_pos = stripos($input['search_query'], $compare_catg_name);
		$brand_pos = stripos($input['search_query'], $compare_brand_name);
		if($catg_pos < $brand_pos)
		{
			$check_position = 1;
		}
		else
		{
			$input['category'] = $catg_name;
			$flag_catg = 0; // resetting to 0 as category is entered after brand so it should be passed in $input['category']
			$check_position = 0;
		}
	}
	
	if($flag_brand == 1 && $check_position == 0) {
		$searchTerms['flag_srch_brand'] = $flag_brand_series;
	}

	if(isset($input['category'])) {
		if(!array_key_exists('srch_category', $searchTerms))
		{
			$searchTerms['srch_category'] = array();
		}
		$searchTerms['category'] = $input['category'];
		$category_name = $input['category'];
		$get_catgories_qry = "SELECT categoryid FROM isc_categories WHERE (catname='".$category_name."' OR catparentid IN (SELECT categoryid FROM isc_categories WHERE catname='".$category_name."')) order by catparentid";
		$get_category_res = $GLOBALS['ISC_CLASS_DB']->Query($get_catgories_qry);
		while($get_category_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($get_category_res))
		{
			$searchTerms['srch_category'][] = $get_category_arr['categoryid'];
		}
		$GLOBALS['ISC_SRCH_CATG_NAME'] =  ucwords($category_name);
		$GLOBALS['ISC_SRCH_CATG_ID'] =  $searchTerms['srch_category'][0];
		if(isset($searchTerms['srch_category'][0]) && array_key_exists($searchTerms['srch_category'][0], $catuniversal))
		{
			$input['catuniversal'] = $searchTerms['catuniversal'] = $catuniversal[$searchTerms['srch_category'][0]];
		}
	}

	if($flag_catg == 1 ) {
		$GLOBALS['ISC_SRCH_CATG_NAME'] =  ucwords($catg_name);
		$GLOBALS['ISC_SRCH_CATG_ID'] =  $catg_id;

		/* the below patch has been added below for the catogories having the make as non-spec vehicle */
		/*if($catg_id == 17 OR $catg_id == 3 OR $catg_id == 7 OR $catg_id == 18 OR $catg_id == 1 OR $catg_id == 2) {
		 $searchTerms['is_catg'] = 1;
		 }*/

		$sub_catgid = array();
		if($flag_sub_catg == 0) {      // if its a parent catg, need to find the sub-categories
			 
			$sub_catgqry = "select categoryid from isc_categories where catparentid = $catg_id ";
			$sub_catgres =  $GLOBALS['ISC_CLASS_DB']->Query($sub_catgqry);
			if($GLOBALS['ISC_CLASS_DB']->CountResult($sub_catgres) > 0) {     // if there are no subcategories under a main category
				while($sub_catgarr = $GLOBALS['ISC_CLASS_DB']->Fetch($sub_catgres))
				{
					$sub_catgid[] =  $sub_catgarr['categoryid'];
				}
				$sub_catgid[] = $catg_id;
			}  else {
				$flag_sub_catg = 1;
				$sub_catgid[] = $catg_id;
			}

		} else {    // else it is a sub-category
			 
			$sub_catgid[] = $catg_id;

		}
		$searchTerms['flag_srch_category'] = $flag_sub_catg;
		$searchTerms['srch_category'] =  $sub_catgid;

		if(isset($input['catuniversal']))
		$searchTerms['catuniversal'] = $input['catuniversal'];
	}
	/*----------------- End for selecting category ---------------------*/

	// Here we parse out any advanced search identifiers from the search query such as price:, :rating etc

	$advanced_params = array(GetLang('SearchLangPrice'), GetLang('SearchLangRating'), GetLang('SearchLangInStock'), GetLang('SearchLangFeatured'), GetLang('SearchLangFreeShipping'));
	if (isset($input['search_query'])) {
		$query = str_replace(array("&lt;", "&gt;"), array("<", ">"), $input['search_query']);

		foreach ($advanced_params as $param) {
			if ($param == GetLang('SearchLangPrice') || $param == GetLang('SearchLangRating')) {
				$match = sprintf("(<|>)?([0-9\.%s]+)-?([0-9\.%s]+)?", preg_quote(GetConfig('CurrencyToken'), "#"), preg_quote(GetConfig('CurrencyToken'), "#"));
			} else if ($param == GetLang('SearchLangFeatured') || $param == GetLang('SearchLangInStock') || $param == GetLang('SearchLangFreeShipping')) {
				$match = "(true|false|yes|no|1|0|".preg_quote(GetLang('SearchLangYes'), "#")."|".preg_quote(GetLang('SearchLangNo'), "#").")";
			} else {
				continue;
			}
			preg_match("#\s".preg_quote($param, "#").":".$match.'(\s|$)#i', $query, $matches);
			if (count($matches) > 0) {
				if ($param == "price" || $param == "rating") {
					if ($matches[3]) {
						$input[$param.'_from'] = (float)$matches[2];
						$input[$param.'_to'] = (float)$matches[3];
					} else {
						if ($matches[1] == "<") {
							$input[$param.'_to'] = (float)$matches[2];
						} else if ($matches[1] == ">") {
							$input[$param.'_from'] = (float)$matches[2];
						} else if ($matches[1] == "") {
							$input[$param] = (float)$matches[2];
						}
					}
				} else if ($param == "featured" || $param == "instock" || $param == "freeshipping") {
					if ($param == "freeshipping") {
						$param = "shipping";
					}
					if ($matches[1] == "true" || $matches[1] == "yes" || $matches[1] == 1) {
						$input[$param] = 1;
					}
					else {
						$input[$param] = 0;
					}
				}
				$matches[0] = str_replace(array("<", ">"), array("&lt;", "&gt;"), $matches[0]);
				$input['search_query'] = trim(preg_replace("#".preg_quote(trim($matches[0]), "#")."#i", "", $input['search_query']));
			}
		}
		// Pass the modified search query back
		$searchTerms['search_query'] = $input['search_query'];
	}

	if(isset($input['categoryid'])) {
		$input['category'] = $input['categoryid'];
	}
	/*
		if (isset($input['category'])) {
		if (!is_array($input['category'])) {
		$input['category'] = array($input['category']);
		}
		$searchTerms['category'] = $input['category'];
		}
		*/
	if (isset($input['searchsubs']) && $input['searchsubs'] != "") {
		$searchTerms['searchsubs'] = $input['searchsubs'];
	}

	if (isset($input['price']) && $input['price'] != "") {
		$searchTerms['price'] = $input['price'];
	}

	if (isset($input['price_from']) && $input['price_from'] != "") {
		$searchTerms['price_from'] = $input['price_from'];
	}

	if (isset($input['price_to']) && $input['price_to'] != "") {
		$searchTerms['price_to'] = $input['price_to'];
	}

	if (isset($input['rating']) && $input['rating'] != "") {
		$searchTerms['rating'] = $input['rating'];
	}

	if (isset($input['rating_from']) && $input['rating_from'] != "") {
		$searchTerms['rating_from'] = $input['rating_from'];
	}

	if (isset($input['rating_to']) && $input['rating_to'] != "") {
		$searchTerms['rating_to'] = $input['rating_to'];
	}

	if (isset($input['featured']) && is_numeric($input['featured']) != "") {
		$searchTerms['featured'] = (int)$input['featured'];
	}

	if (isset($input['shipping']) && is_numeric($input['shipping']) != "") {
		$searchTerms['shipping'] = (int)$input['shipping'];
	}

	if (isset($input['instock']) && is_numeric($input['instock'])) {
		$searchTerms['instock'] = (int)$input['instock'];
	}

	if (isset($input['brand']) && $input['brand'] != "") {
		$searchTerms['brand'] = $input['brand'];
		$brand_query = "select brandid from [|PREFIX|]brands WHERE brandname='".$searchTerms['brand']."'";
		$brand_result = $GLOBALS['ISC_CLASS_DB']->Query($brand_query);
		$GLOBALS['brandId'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($brand_result);
		/* this below condition is added to get the brand name when clicked on brand after selecting any category */
		if(!isset($GLOBALS['ISC_SRCH_BRAND_NAME']))
		$GLOBALS['ISC_SRCH_BRAND_NAME'] = $searchTerms['brand'];
	}

	if (isset($input['make']) && $input['make'] != "") {
		$searchTerms['make'] = $input['make'];
		unset($input['prodmake']);
	}
	/* this below 3 lines are added as db has the name as prodmodel for model and prodsubmodel as submodel*/
	if (isset($input['prodmodel']) && $input['prodmodel'] != "") {
		$input['model'] = $input['prodmodel'];
	}

	if (isset($input['model']) && $input['model'] != "" && ( !isset($input['search_key']) || (isset($input['search_key']) && $input['model'] != 'all') ) ) {
		$searchTerms['model'] = $input['model'];
		unset($input['prodmodel']);

		$_REQUEST['model'] = $input['model'];
		/* the below flag is set to check whether exact model is searched or similar to the model is searched */
		if(isset($flag_model))
		$searchTerms['model_flag'] = $flag_model;
	}

	/* the below condition is checked whether the flag is returning from the links in the side filter section in search result page */
	if(isset($input['model_flag']) && $input['model_flag'] != "") {
		$searchTerms['model_flag'] = $input['model_flag'];
	}

	if (isset($input['prodsubmodel']) && $input['prodsubmodel'] != "") {
		$input['submodel'] = $input['prodsubmodel'];
	}

	if (isset($input['submodel']) && $input['model'] != "") {
		$searchTerms['submodel'] = $input['submodel'];
		unset($input['prodsubmodel']);
	}

	if (isset($input['year']) && $input['year'] != "" && ( !isset($input['search_key']) || (isset($input['search_key']) && $input['year'] != 'all') ) ) {
		$searchTerms['year'] = $input['year'];
	}

	/*if (isset($input['brand']) && $input['brand'] != "") {
	 $searchTerms['brand'] = $input['brand'];
	 }

	 if (isset($input['from_price']) && $input['from_price'] != "") {
	 $searchTerms['from_price'] = $input['from_price'];
	 }

	 if (isset($input['to_price']) && $input['to_price'] != "") {
	 $searchTerms['to_price'] = $input['to_price'];
	 }

		if (isset($input['bedsize']) && $input['bedsize'] != "") {
		$searchTerms['bedsize'] = $input['bedsize'];
		}

		if (isset($input['cover']) && $input['cover'] != "") {
		$searchTerms['cover'] = $input['cover'];
		}

		if (isset($input['color']) && $input['color'] != "") {
		$searchTerms['color'] = $input['color'];
		}*/


	if(isset($input['subcategory']) && !empty($input['subcategory'])) {
		$sub_category = $input['subcategory'];
		$searchTerms['subcategory'] = $input['subcategory'];

		$sub_catg_qry = "select categoryid , catname from isc_categories where catname = '".$GLOBALS['ISC_CLASS_DB']->Quote($sub_category)."' and catparentid = '".$GLOBALS['ISC_CLASS_DB']->Quote($GLOBALS['ISC_SRCH_CATG_ID'])."'";
		$sub_catg_res = $GLOBALS['ISC_CLASS_DB']->Query($sub_catg_qry);
		$sub_catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($sub_catg_res);
		if($GLOBALS['ISC_CLASS_DB']->CountResult($sub_catg_res) > 0)
		{
			$GLOBALS['subcategoryid'] = $sub_catg_arr['categoryid'];
		}
		else
		{
			$sub_catg_qry = "select categoryid , catname from isc_categories where categoryid = '".$GLOBALS['ISC_CLASS_DB']->Quote($GLOBALS['ISC_SRCH_CATG_ID'])."'";
			$sub_catg_res = $GLOBALS['ISC_CLASS_DB']->Query($sub_catg_qry);
			$sub_catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($sub_catg_res);
			$GLOBALS['subcategoryid'] = $sub_catg_arr['categoryid'];
		}

		/* the below query is written to get the main category anme when subcategory is selected directly */
		$main_catg_qry = "select p.categoryid , p.catname from isc_categories as p inner join isc_categories as c on p.categoryid = c.catparentid and c.catname = '".$GLOBALS['ISC_CLASS_DB']->Quote($sub_category)."' and c.catparentid = '".$GLOBALS['ISC_CLASS_DB']->Quote($GLOBALS['ISC_SRCH_CATG_ID'])."'";
		$main_catg_res =  $GLOBALS['ISC_CLASS_DB']->Query($main_catg_qry);
		$main_catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($main_catg_res);
		$main_catg_rows = $GLOBALS['ISC_CLASS_DB']->CountResult($main_catg_res);
		if($main_catg_rows == 0) {
			$main_catg_arr = $sub_catg_arr;
		}

		$GLOBALS['ISC_SRCH_CATG_NAME'] =  ucwords($main_catg_arr['catname']);
		$GLOBALS['ISC_SRCH_CATG_ID'] =  $main_catg_arr['categoryid'];

		//if(in_array($sub_category,$sub_catgid)) {
		//$sub_catgid = $sub_category;
		$searchTerms['srch_category'] =  array($GLOBALS['subcategoryid']);
		$searchTerms['flag_srch_category'] = 1;
		if(isset($GLOBALS['subcategoryid']) && array_key_exists($GLOBALS['subcategoryid'], $catuniversal))
		{
			$searchTerms['catuniversal'] = $catuniversal[$GLOBALS['subcategoryid']];
		}
		//}
	}

	// need to know the category name when brand and series are selected
	if(isset($input['series']) && !empty($input['series'])) {
		$searchTerms['series'] = $input['series'];
		$searchTerms['flag_srch_brand'] = 1;
		$GLOBALS['BRAND_SERIES_FLAG'] = 1;

		$main_catg_qry = "select s.seriesid from isc_brand_series s where s.seriesname = '".$input['series']."' ";
		$main_catg_res =  $GLOBALS['ISC_CLASS_DB']->Query($main_catg_qry);
		$main_catg_rows = $GLOBALS['ISC_CLASS_DB']->CountResult($main_catg_res);
		$main_catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($main_catg_res);
		$GLOBALS['seriesid'] = $main_catg_arr['seriesid'];
		if($main_catg_rows > 0) {
			/*$GLOBALS['ISC_SRCH_CATG_NAME'] =  ucwords($main_catg_arr['catname']);
				$GLOBALS['ISC_SRCH_CATG_ID'] =  $main_catg_arr['categoryid'];
				$searchTerms['srch_category'] =  array($GLOBALS['ISC_SRCH_CATG_ID']);
				$searchTerms['catuniversal'] = $catuniversal[$main_catg_arr['categoryid']];*/
		}
	}

	if(isset($GLOBALS['ISC_SRCH_CATG_ID']))
	{
		$RelatedCatsQuery = "SELECT DISTINCT c.categoryid
                                FROM isc_products p 
                                LEFT JOIN isc_categoryassociations ca ON ca.productid = p.productid 
                                LEFT JOIN isc_categories c ON c.categoryid = ca.categoryid ";

		if(isset($input['series']) && !empty($input['series']))
		{
			$RelatedCatsQuery.= "
                        LEFT JOIN isc_brands b ON prodbrandid = b.brandid 
                        LEFT JOIN isc_brand_series AS bs ON bs.seriesid = p.brandseriesid ";
		}

		$RelatedCatsQuery .= " WHERE 1=1 AND c.categoryid IS NOT NULL AND p.prodvisible='1' ";

		if(in_array($GLOBALS['ISC_SRCH_CATG_ID'] , $searchTerms['srch_category'])) {
			// No subcatg under category
			$sidequalifier_query = "select distinct qn.qid , qn.column_name , qa.qualifier_visible from isc_qualifier_associations qa left join isc_qualifier_names qn on qn.qid = qa.qualifierid
                    where qa.categoryid = ".$GLOBALS['ISC_SRCH_CATG_ID'];   

			$RelatedCatsQuery .= " AND (c.categoryid = ".$GLOBALS['ISC_SRCH_CATG_ID']." || c.catparentid = ".$GLOBALS['ISC_SRCH_CATG_ID'].")";

		}
		else if(!in_array($GLOBALS['ISC_SRCH_CATG_ID'] , $searchTerms['srch_category']) && isset($input['subcategory'])) {
			//   product listing page
			$sidequalifier_query = "select distinct qn.qid , qn.column_name , qa.qualifier_visible from isc_qualifier_associations qa left join isc_qualifier_names qn on qn.qid = qa.qualifierid where qa.categoryid = ".$GLOBALS['subcategoryid'];

			$RelatedCatsQuery .= " AND c.categoryid = ".$GLOBALS['subcategoryid']."";
		}

		if(isset($input['series']) && !empty($input['series']))
		{
			if(isset($GLOBALS['brandId']))
			{
				$brand_id = (int)$GLOBALS['brandId'];
				$RelatedCatsQuery.= " AND p.prodbrandid='".$GLOBALS['ISC_CLASS_DB']->Quote($brand_id)."' AND p.brandseriesid = ".$GLOBALS['seriesid']."";
			}
		}

		$RelatedCatsResult  = $GLOBALS['ISC_CLASS_DB']->Query($RelatedCatsQuery);
		$RelatedCats        = array();
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($RelatedCatsResult)) {
			$RelatedCats[] = (int) $row['categoryid'];
		}

		$RelatedCats = implode(",", $RelatedCats);

		$qualifier_query = " SELECT
                            DISTINCT qn.qid , qn.column_name , qa.qualifier_visible 
                            FROM isc_qualifier_associations qa 
                            LEFT JOIN isc_qualifier_names qn ON qn.qid = qa.qualifierid      
                            WHERE qa.categoryid IN (".$RelatedCats.")";  
		//OR qa.categoryid IN (SELECT catparentid FROM isc_categories WHERE categoryid IN (".$RelatedCats."))
		 
		GetQualifierColumns($qualifier_query, $qualifier_columns, $VCols, $PCols);
		$GLOBALS['sidev_cols'] = $VCols;
		$GLOBALS['sidep_cols'] = $PCols;
		 
		GetQualifierColumns($sidequalifier_query, $sidequalifier_columns, $SideVCols, $SidePCols);
		$GLOBALS['v_cols'] = $SideVCols;
		$GLOBALS['p_cols'] = $SidePCols;

	} else    {

		$RelatedCatsQuery = "SELECT DISTINCT c.categoryid
                                FROM isc_products p 
                                LEFT JOIN isc_categoryassociations ca ON ca.productid = p.productid 
                                LEFT JOIN isc_categories c ON c.categoryid = ca.categoryid ";

		if(isset($input['series']) && !empty($input['series']))
		{
			$RelatedCatsQuery.= "
                        LEFT JOIN isc_brands b ON prodbrandid = b.brandid 
                        LEFT JOIN isc_brand_series AS bs ON bs.seriesid = p.brandseriesid ";
		}

		$RelatedCatsQuery.= " WHERE 1=1 AND c.categoryid IS NOT NULL AND p.prodvisible='1' ";

		if(isset($input['series']) && !empty($input['series']))
		{
			if(isset($GLOBALS['brandId']))
			{
				$brand_id = (int)$GLOBALS['brandId'];
				$RelatedCatsQuery.= " AND p.prodbrandid='".$GLOBALS['ISC_CLASS_DB']->Quote($brand_id)."' AND p.brandseriesid = ".$GLOBALS['seriesid']."";
			}
		}

		//$RelatedCatsQuery = $GLOBALS['StartNumber'];

		$RelatedCatsResult  = $GLOBALS['ISC_CLASS_DB']->Query($RelatedCatsQuery);
		$RelatedCats        = array();
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($RelatedCatsResult)) {
			$RelatedCats[] = (int) $row['categoryid'];
		}

		$RelatedCats = implode(",", $RelatedCats);

		$qualifier_query = "SELECT
                                DISTINCT qn.qid , qn.column_name , qa.qualifier_visible 
                                FROM isc_qualifier_associations qa 
                                LEFT JOIN isc_qualifier_names qn ON qn.qid = qa.qualifierid      
                                WHERE qa.categoryid IN (".$RelatedCats.")";
		//OR qa.categoryid IN (SELECT catparentid FROM isc_categories WHERE categoryid IN (".$RelatedCats."))
		$qualifier_result = $GLOBALS['ISC_CLASS_DB']->Query($qualifier_query);

		GetQualifierColumns($qualifier_query, $qualifier_columns, $VCols, $PCols);
		$GLOBALS['sidev_cols'] = $VCols;
		$GLOBALS['sidep_cols'] = $PCols;

	}

	$GLOBALS['v_cols'] = isset($GLOBALS['v_cols']) ? $GLOBALS['v_cols'] : array();
	$GLOBALS['p_cols'] = isset($GLOBALS['p_cols']) ? $GLOBALS['p_cols'] : array();

	$qualifier_count = count($GLOBALS['sidev_cols']) + count($GLOBALS['sidep_cols']);

	/*------------ For Dynamic filters ------------------*/

	for($qid=0;$qid<$qualifier_count;$qid++)
	{
		$dynval = strtolower($qualifier_columns[$qid]);
		if(isset($input[$dynval]) && !empty($input[$dynval])) {
			$q_value =  $input[$dynval];
			$dynval = preg_replace("/^([a-zA-Z0-9]{2})/e", "strtoupper('\\1')", $dynval); // making the first 2 letters capital of the qualifier name
			$searchTerms['dynfilters'][$dynval] = $q_value;
		}
	}

	if( isset($input['vqbedsize']) )
	{
		unset($input['vqsbedsize']);
	}
	else if( isset($input['vqsbedsize']) )
	{
		$searchTerms['vqsbedsize'] = $input['vqsbedsize'];
	}

	if( isset($input['vqcabsize']) )
	{
		unset($input['vqscabsize']);
	}
	else if( isset($input['vqscabsize']) )
	{
		$searchTerms['vqscabsize'] = $input['vqscabsize'];
	}

	/*====================== Cookies section below ================================ */

	$number_of_days = 730 ;
	$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;

	if( isset($input['vqbedsize']) )
	{
		setcookie( "last_search_selection[bedsize]", $input['vqbedsize'], $date_of_expiry ,"/");
	}
	else
	{
		setcookie( "last_search_selection[bedsize]",'', $date_of_expiry ,"/");
	}

	if( isset($input['vqcabsize']) )
	{
		setcookie( "last_search_selection[cabsize]", $input['vqcabsize'], $date_of_expiry ,"/");
	}
	else
	{
		setcookie( "last_search_selection[cabsize]",'', $date_of_expiry ,"/");
	}

	if( isset($_COOKIE['last_search_selection']) && !isset($searchTerms['make']) && !isset($GLOBALS['ISC_CLASS_REDEFINE_SEARCH']) && !isset($input['change']) ) {

		if(!empty($_COOKIE['last_search_selection']['make']) )
		{
			$searchTerms['make'] = $_COOKIE['last_search_selection']['make'];

			if(isset($searchTerms['model']))
			{
				$model_validate_qry  = "select model from [|PREFIX|]product_mmy where ";
				if(!isset($searchTerms['model_flag']) || $searchTerms['model_flag'] == 1)
				$model_validate_qry  .=	" make = '".$searchTerms['make']."' and model = '".$searchTerms['model']."'";
				else
				$model_validate_qry  .=	" make = '".$searchTerms['make']."' and model like '".$searchTerms['model']."%'";

				$model_validate_res	 = $GLOBALS['ISC_CLASS_DB']->Query($model_validate_qry);

				if( $GLOBALS['ISC_CLASS_DB']->CountResult($model_validate_res) == 0 )
				{
					unset($searchTerms['model'],$searchTerms['model_flag'],$_REQUEST['model'],$_COOKIE['last_search_selection']['model']);
				}
			}

		}

		if(!empty($_COOKIE['last_search_selection']['make']))
		$searchTerms['make'] = $_COOKIE['last_search_selection']['make'];

		// This condition is added as to check  if only model is searched, then no need to update cookie. so storing empty value
		if( !isset($searchTerms['make']) && isset($searchTerms['model']) )
		{
			setcookie( "last_search_selection[model]", '', $date_of_expiry ,"/");
		}
		else if( isset($searchTerms['make']) && !empty($_COOKIE['last_search_selection']['model']) )	// This condition is to check if make is selected before retrieving model from cookie.
		{
			$searchTerms['model'] = $_COOKIE['last_search_selection']['model'];
			$_REQUEST['model'] =  $searchTerms['model'];
		}

		if(!isset($searchTerms['model']) && !empty($_COOKIE['last_search_selection']['model'])) {
			$searchTerms['model'] = $_COOKIE['last_search_selection']['model'];
			$_REQUEST['model'] =  $searchTerms['model'];
		} /*else {
		unset($searchTerms['model'],$searchTerms['model_flag'],$_REQUEST['model']);
		}*/

		if(!isset($searchTerms['year']) && !empty($_COOKIE['last_search_selection']['year'])) {
			$searchTerms['year'] = $_COOKIE['last_search_selection']['year'];
			$_REQUEST['year'] =  $searchTerms['year'];
		}

		if(  array_key_exists('make',$searchTerms) && isset($searchTerms['make']) )
			setcookie( "last_search_selection[make]", $searchTerms['make'], $date_of_expiry ,"/");
		else
		{
			if(array_key_exists('make', $_COOKIE['last_search_selection']) &&  isset($_COOKIE['last_search_selection']['make']))
			{
			$searchTerms['make'] = $_COOKIE['last_search_selection']['make'];
			}
		}
		if( array_key_exists('model',$searchTerms) && isset($searchTerms['model']) )
		setcookie( "last_search_selection[model]", $searchTerms['model'], $date_of_expiry ,"/");
		else
		{
			if(array_key_exists('model', $_COOKIE['last_search_selection']) && isset($_COOKIE['last_search_selection']['model']))
			{
				$searchTerms['model'] = $_COOKIE['last_search_selection']['model'];
			}
		}
		if( array_key_exists('year',$searchTerms) && isset($searchTerms['year']) )
		setcookie( "last_search_selection[year]", $searchTerms['year'], $date_of_expiry ,"/" );
		else
		{
			if(array_key_exists('year', $_COOKIE['last_search_selection']) && isset($_COOKIE['last_search_selection']['model']))
			{
				$searchTerms['year'] = $_COOKIE['last_search_selection']['year'];
			}
		}
		//setcookie( "last_search_selection[MMY_KEY]", time(), $date_of_expiry  );

	} else if(!isset($GLOBALS['ISC_CLASS_REDEFINE_SEARCH'])) {

		if( isset($searchTerms['make']) )
		setcookie( "last_search_selection[make]", $searchTerms['make'], $date_of_expiry ,"/");
		else if( isset($_COOKIE['last_search_selection']) && isset($_COOKIE['last_search_selection']['make']) )
		$searchTerms['make'] = $_COOKIE['last_search_selection']['make'];
			
		if( isset($searchTerms['make']) && isset($searchTerms['model']) && ( !isset($searchTerms['model_flag']) || $searchTerms['model_flag'] == 1 ) )
		setcookie( "last_search_selection[model]", $searchTerms['model'], $date_of_expiry ,"/");
		else if( isset($_COOKIE['last_search_selection']) && isset($_COOKIE['last_search_selection']['model']) )
		$searchTerms['model'] = $_COOKIE['last_search_selection']['model'];

	 if( isset($searchTerms['year']) )
	 setcookie( "last_search_selection[year]", $searchTerms['year'], $date_of_expiry ,"/" );
	 else if( isset($_COOKIE['last_search_selection']) && isset($_COOKIE['last_search_selection']['year']) )
	 $searchTerms['year'] = $_COOKIE['last_search_selection']['year'];
	 //setcookie( "last_search_selection[MMY_KEY]", time(), $date_of_expiry  );
	}

	//NI CLOUD 2010-06-18
	//add YMM validating logic
	$query = "SELECT 'ALL' AS
					TYPE , MIN( prodstartyear ) AS MIN_StartYear, MAX( prodendyear ) AS MAX_EndYear
					FROM isc_import_variations v
					INNER JOIN isc_products p ON v.productid = p.productid
					WHERE p.prodvisible =1 and `prodstartyear` <> 'all' AND `prodendyear` <> 'all'  and `prodstartyear` <> '' AND `prodendyear` <> ''  and `prodstartyear` is not null AND `prodendyear` is not null
					UNION ALL SELECT 'MAKE' AS 
					TYPE , MIN( prodstartyear ) AS MIN_StartYear, MAX( prodendyear ) AS MAX_EndYear
					FROM isc_import_variations v
					INNER JOIN isc_products p ON v.productid = p.productid
					WHERE p.prodvisible =1 and `prodstartyear` <> 'all' AND `prodendyear` <> 'all'  and `prodstartyear` <> '' AND `prodendyear` <> ''  and `prodstartyear` is not null AND `prodendyear` is not null
					AND prodmake = '".(isset($searchTerms["make"])?$searchTerms["make"]:'')."'
					GROUP BY prodmake
					UNION ALL SELECT 'MODAL' AS 
					TYPE , MIN( prodstartyear ) AS MIN_StartYear, MAX( prodendyear ) AS MAX_EndYear
					FROM isc_import_variations v
					INNER JOIN isc_products p ON v.productid = p.productid
					WHERE p.prodvisible =1 and `prodstartyear` <> 'all' AND `prodendyear` <> 'all'  and `prodstartyear` <> '' AND `prodendyear` <> ''  and `prodstartyear` is not null AND `prodendyear` is not null
					AND prodmake = '".(isset($searchTerms["make"])?$searchTerms["make"]:'')."'
					AND prodmodel = '".(isset($searchTerms["model"])?$searchTerms["model"]:'')."'
					GROUP BY prodmake + prodmodel";
		
	$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
	//validate model
	if( $GLOBALS['ISC_CLASS_DB']->CountResult($result) < 3 )
	{
		unset($searchTerms["model"]);
		unset($searchTerms["model_flag"]);
		setcookie( "last_search_selection[model]", '', $date_of_expiry ,"/");
	}
	//validate make
	if( $GLOBALS['ISC_CLASS_DB']->CountResult($result) < 2 )
	{
		unset($searchTerms["make"]);
	}
	//validate year
	while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))
	{
		if( isset($searchTerms["year"]) && ( $searchTerms["year"] > (int)$row["MAX_EndYear"] || $searchTerms["year"] < (int)$row["MIN_StartYear"] ) )
		{
			unset($searchTerms["year"]);
		}
	}

	return $searchTerms;
}

/**
 *	Get all of the child categories for category with ID $parent
 */
function GetChildCats($parent=0)
{
	static $nodesByPid;
	if (!isset($nodesByPid) || !@is_array($nodesByPid)) {
		$tree = new Tree();
		$query = "SELECT * FROM [|PREFIX|]categories";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$nodesByPid[(int) $row['catparentid']][] = (int) $row['categoryid'];
		}

		$called = true;
	}

	$children = array();

	if (!@is_array($nodesByPid[$parent])) {
		return $children;
	}

	foreach ($nodesByPid[$parent] as $categoryid) {
		$children[] = $categoryid;
		// Fetch nested children
		if (@is_array($nodesByPid[$categoryid])) {
			$children = array_merge($children, GetChildCats($categoryid));
		}
	}

	return $children;
}

/**
 * Build an SQL query for the specified search terms.
 *
 * @param array Array of search terms
 * @param string String of fields to match
 * @param string The field to sort by
 * @param string The order to sort results by
 * @return array An array containing the query to count the number of results and a query to perform the search
 */
function BuildProductSearchQuery($searchTerms, $fields="", $sortField=array("score", "proddateadded"), $sortOrder="desc")
{
	$queryWhere = array();
	$joinQuery = '';

	$queryWhere1 = array();
	$joinQuery1 = '';

	$qualifier_flag = 0;
	$qualifier_category = 0;

	$v_cols = array();
	$p_cols = array();
	/*$q_qry = "select * from isc_import_variations limit 0,1";
	 $q_res = $GLOBALS['ISC_CLASS_DB']->Query($q_qry);
	 $q_row = $GLOBALS['ISC_CLASS_DB']->Fetch($q_res);
	 foreach($q_row as $q_key => $q_val)
	 {
	 if(eregi('^(vq)', $q_key)) {
	 $v_cols[] = $q_key;
	 } else if(eregi('^(pq)', $q_key)) {
	 $p_cols[] = $q_key;
	 }
	 }*/
	$v_cols = isset($GLOBALS['sidev_cols']) ? $GLOBALS['sidev_cols'] : array();
	$p_cols = isset($GLOBALS['sidep_cols']) ? $GLOBALS['sidep_cols'] : array();

        $common_fields_product = " b.callbestprice bbestprice, c.callbestprice cbestprice, bs.callbestprice sbestprice,p.prodcode, p.productid , b.brandname , c.categoryid, c.catname , c.catuniversal,csi.icon_file ";
	$common_fields_variation = " p.prodcode, v.productid, v.prodstartyear, v.prodendyear , v.prodmodel, v.prodsubmodel, v.prodmake ";

	$new_fields = " p.proddesc , p.prodname , p.proddescfeature , prodwarranty , p.prodvariationid,p.prodconfigfields,p.prodeventdaterequired,p.prodvendorid,p.prodprice,p.prodretailprice,p.prodsaleprice,p.prodistaxable,p.prodcatids,p.prodhideprice,p.prodinvtrack,p.prodcurrentinv,p.prodallowpurchases,p.prodbrandid,p.prodcalculatedprice,prodweight,prodheight ";

	// Construct the full text search part of the query
	/*$fulltext_fields = array("ps.prodname", "ps.prodcode", "ps.proddesc", "ps.prodsearchkeywords", "ps.prodalternates", "ps.prodmake", "ps.prodmodel", "ps.prodsubmodel", "ps.prodstartyear", "ps.prodendyear");*/
	$fulltext_fields = array("ps.prodname", "ps.prodcode", "ps.proddesc", "ps.prodsearchkeywords");

	if (!$fields) {
		$fields = "$new_fields, FLOOR(p.prodratingtotal/p.prodnumratings) AS prodavgrating, ".GetProdCustomerGroupPriceSQL().", ";
		$fields .= "pi.imageisthumb, pi.imagefile ";
		if (isset($searchTerms['search_query']) && $searchTerms['search_query'] != "") {
			//$fields .= ', '.$GLOBALS['ISC_CLASS_DB']->FullText($fulltext_fields, $searchTerms['search_query'], false) . " as score ";
		}
	}

	$fields1 = $fields." ,v. ".implode(",v.",$v_cols);
	//$fields .= " ,v. ".implode(",v. ",$v_cols).", group_concat(distinct PQcolor,', ',PQmaterial,', ',PQstyle separator '~') as productoption ";
	//$fields .= " , group_concat(distinct PQcolor,', ',PQmaterial,', ',PQstyle separator '~') as productoption ";

	if(isset($searchTerms['categoryid'])) {
		$searchTerms['category'] = array($searchTerms['categoryid']);
	}
	 
	// If we're searching by category, we need to completely
	// restructure the search query - so do that first
	$categorySearch = false;
	$categoryIds = array();
	if(isset($searchTerms['category']) && is_array($searchTerms['category'])) {
		foreach($searchTerms['category'] as $categoryId) {
			// All categories were selected, so don't continue
			if($categoryId == 0) {
				$categorySearch = false;
				break;
			}

			$categoryIds[] = (int)$categoryId;

			// If searching sub categories automatically, fetch & tack them on
			if(isset($searchTerms['searchsubs']) && $searchTerms['searchsubs'] == 'ON') {
				$categoryIds = array_merge($categoryIds, GetChildCats($categoryId));
			}
		}

		$categoryIds = array_unique($categoryIds);
		if(!empty($categoryIds)) {
			$categorySearch = true;
		}
	}
	/* this below is condition is used when category is mentioned in search keyword */
	if(isset($searchTerms['srch_category'])) {
		$categorySearch = true;
		$categoryIds = $searchTerms['srch_category'];
	}

	if($categorySearch == true) {
		$qualifier_category = 1;
		$qualifier_flag = 1;
		/*$fromTable = 'isc_categoryassociations a, isc_products p ';
			$queryWhere[] = 'a.productid=p.productid AND a.categoryid IN ('.implode(',', $categoryIds).')';

			$fromTable1 = 'isc_categoryassociations a, isc_import_variations v ';
			$queryWhere1[] = 'a.productid=v.productid AND a.categoryid IN ('.implode(',', $categoryIds).')';*/
		if($searchTerms['flag_srch_category'] == 1)
		$fromTable = 'isc_products p USE INDEX (PRIMARY) ';
		else
		$fromTable = 'isc_products p ';
		//            $fromTable = 'isc_products p USE INDEX (categoryid) ';

		$queryWhere[] = 'c.categoryid IN ('.implode(',', $categoryIds).')';

		$fromTable1 = 'isc_import_variations v ';
		$queryWhere1[] = 'c.categoryid IN ('.implode(',', $categoryIds).')';
	}
	else {
		$fromTable = 'isc_products p';
		$fromTable1 = 'isc_import_variations v';

		$queryWhere[] = " c.categoryid is not null ";
	}
	/*  this code is commented as we are no longer checking in search table as the records are split in product and variations table.
		if (isset($searchTerms['search_query']) && $searchTerms['search_query'] != "") {
		// Only need the product search table if we have a search query
		$joinQuery .= "INNER JOIN [|PREFIX|]product_search ps ON (p.productid=ps.productid) ";
		} else if ($sortField == "score") {
		// If we don't, we better make sure we're not sorting by score
		$sortField = "p.prodname";
		$sortOrder = "ASC";
		}
		*/


	/* Below condition has been added if any product detail page is seen directly , need to assign it as array */
	if(!isset($searchTerms['dynfilters']))
	{
		$searchTerms['dynfilters'] = array();
	}
	$otherkeys = array_keys($searchTerms['dynfilters'], "others");
	$others_factor = '';
	/*
	 if ( isset($searchTerms['partnumber']) || ( isset($searchTerms['flag_srch_category']) && $searchTerms['flag_srch_category'] == 1 ) || (isset($searchTerms['flag_srch_brand']) &&  $searchTerms['flag_srch_brand'] == 1 ) || isset($searchTerms['series']) || isset($searchTerms['subcategory']) )
	 {
	 // listing page
	 }
	 else
	 {
	 foreach ($otherkeys as $otherkey)  {
	 //$others_factor .= " AND (".$otherkey." = '' OR ".$otherkey." IS NULL )";
	 $others_factor .= " AND (".$otherkey." = '' OR ".$otherkey." IS NULL )";
	 }
	 }
	 */

	$partnumber_condition = "";
	if( !isset($searchTerms['partnumber']) )
	{
		//$partnumber_condition = "and c.catvisible = 1 ";
	}

	$joinQuery .= " LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid ".$others_factor."
						LEFT JOIN [|PREFIX|]categoryassociations ca on ca.productid = p.productid 
						LEFT JOIN [|PREFIX|]categories c on c.categoryid = ca.categoryid ".$partnumber_condition." 
						LEFT JOIN [|PREFIX|]brands b on prodbrandid = b.brandid 
						LEFT JOIN [|PREFIX|]brand_series AS bs ON bs.seriesid = p.brandseriesid 
						LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid AND pi.imageisthumb=1)
						LEFT JOIN [|PREFIX|]product_finalprice fp ON p.productid = fp.productid
						LEFT JOIN [|PREFIX|]prodcut_cap_size_images csi ON p.prodcode = csi.productcode and p.prodvendorprefix = csi.vendor_prix ";

	$joinQuery1 .= " LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid ".$others_factor."
							LEFT JOIN [|PREFIX|]categoryassociations ca on ca.productid = p.productid 
							LEFT JOIN [|PREFIX|]categories c on c.categoryid = ca.categoryid ".$partnumber_condition." 
							LEFT JOIN [|PREFIX|]brands b on prodbrandid = b.brandid 
							LEFT JOIN [|PREFIX|]brand_series AS bs ON bs.seriesid = p.brandseriesid ";

	$queryWhere1[] = $queryWhere[] = "p.prodvisible='1'";
	 
	// Add in the group category restrictions
	$permissionSql = GetProdCustomerGroupPermissionsSQL(null, false);
	if($permissionSql) {
		$queryWhere1[] = $queryWhere[] = $permissionSql;
	}

	// Do we need to filter on brand?
	if (isset($searchTerms['brand']) && $searchTerms['brand'] != "") {
		$brand_query = "select brandid from [|PREFIX|]brands WHERE brandname='".$searchTerms['brand']."'";
		$brand_result = $GLOBALS['ISC_CLASS_DB']->Query($brand_query);
		$brandId = $GLOBALS['ISC_CLASS_DB']->FetchOne($brand_result);
		if((int)$brandId > 0)
		{
			$qualifier_flag = 1;
			$queryWhere1[] = $queryWhere[] = "p.prodbrandid='" . $GLOBALS['ISC_CLASS_DB']->Quote($brandId) . "'";
		}
	}

	// Do we need to filter on brand series?
	if (isset($searchTerms['series']) && $searchTerms['series'] != "") {
		$qualifier_flag = 1;
		if(isset($GLOBALS['seriesid']))
		{
			$brand_series_id = (int)$GLOBALS['seriesid'];
		}
		else
		{
			$series_qry = "select s.seriesid from isc_brand_series s where s.seriesname = '".$searchTerms['series']."' ";
			$series_res =  $GLOBALS['ISC_CLASS_DB']->Query($series_qry);
			$series_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($series_res);
			$brand_series_id = (int)$series_arr['seriesid'];
		}
		$queryWhere1[] = $queryWhere[] = " p.brandseriesid = " . $GLOBALS['ISC_CLASS_DB']->Quote($brand_series_id);
	}

	if(isset($searchTerms['partnumber'])) {
		$qualifier_flag = 1;
		$prod_code =  $searchTerms['partnumber'];
		$queryWhere1[] = $queryWhere[] = " p.prodcode like '".$prod_code."%'";
	}

	// Do we need to filter on price?
	if (isset($searchTerms['price'])) {
		$queryWhere1[] = $queryWhere[] = "p.prodcalculatedprice='".$GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['price'])."'";
	} else {
		/*if (isset($searchTerms['price_from']) && is_numeric($searchTerms['price_from'])) {
		 $queryWhere1[] = $queryWhere[] = "p.prodcalculatedprice >= '".$GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['price_from'])."'";
			}

			if (isset($searchTerms['price_to']) && is_numeric($searchTerms['price_to'])) {
			$queryWhere1[] = $queryWhere[] = "p.prodcalculatedprice <= '".$GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['price_to'])."'";
			}*/
	}

	// Do we need to filter on rating?
	if (isset($searchTerms['rating'])) {
		$queryWhere1[] = $queryWhere[] = "FLOOR(p.prodratingtotal/p.prodnumratings) = '".(int)$searchTerms['rating']."'";
	}
	else {
		if (isset($searchTerms['rating_from']) && is_numeric($searchTerms['rating_from'])) {
			$queryWhere1[] = $queryWhere[] = "FLOOR(p.prodratingtotal/p.prodnumratings) >= '".(int)$searchTerms['rating_from']."'";
		}

		if (isset($searchTerms['rating_to']) && is_numeric($searchTerms['rating_to'])) {
			$queryWhere1[] = $queryWhere[] = "FLOOR(p.prodratingtotal/p.prodnumratings) <= '".(int)$searchTerms['rating_to']."'";
		}
	}

	// Do we need to filter on featured?
	if (isset($searchTerms['featured']) && $searchTerms['featured'] != "") {
		$featured = (int)$searchTerms['featured'];

		if ($featured == 1) {
			$queryWhere1[] = $queryWhere[] = "p.prodfeatured=1";
		}
		else {
			$queryWhere1[] = $queryWhere[] = "p.prodfeatured=0";
		}
	}

	// Do we need to filter on free shipping?
	if (isset($searchTerms['shipping']) && $searchTerms['shipping'] != "") {
		$shipping = (int)$searchTerms['shipping'];

		if ($shipping == 1) {
			$queryWhere1[] = $queryWhere[] = "p.prodfreeshipping='1' ";
		}
		else {
			$queryWhere1[] = $queryWhere[] = "p.prodfreeshipping='0' ";
		}
	}

	// Do we need to filter only products we have in stock?
	if (isset($searchTerms['instock']) && $searchTerms['instock'] != "") {
		$stock = (int)$searchTerms['instock'];
		if ($stock == 1) {
			$queryWhere1[] = $queryWhere[] = "(p.prodcurrentinv>0 or p.prodinvtrack=0) ";
		}
	}
	 
	// Do we need to filter for make of the product
	if (isset($searchTerms['make']) && $searchTerms['make'] != ""  && ( !isset($searchTerms['catuniversal']) || $searchTerms['catuniversal'] != 1 ) ) {
		$make = $searchTerms['make'];
		if (!empty($make)) {
			$qualifier_flag = 1;
			$ext = "";
			//if(isset($searchTerms['is_catg']))
			$ext .= " OR v.prodmake = 'NON-SPEC VEHICLE' ";

			$queryWhere[] = " ( v.prodmake = '".$make."' $ext ) ";
			$queryWhere1[] = " ( v.prodmake = '".$make."' $ext ) ";
		}
	}

	// Do we need to filter for model of the product
	if (isset($searchTerms['model']) && $searchTerms['model'] != ""  && ( !isset($searchTerms['catuniversal']) || $searchTerms['catuniversal'] != 1 ) ) {
		$model = $searchTerms['model'];
		if (!empty($model)) {
			$qualifier_flag = 1;
			$ext = "";
			//if(isset($searchTerms['is_catg']))
			$ext .= " OR v.prodmodel = 'ALL' ";

			//if(isset($_REQUEST['model'])) {
			if(!isset($searchTerms['model_flag']) || ( isset($searchTerms['model_flag']) && $searchTerms['model_flag'] == 1 )) {
				$queryWhere[] = " ( v.prodmodel = '".$model."' $ext ) ";
				$queryWhere1[] = " ( v.prodmodel = '".$model."' $ext ) ";
			} else {
				$queryWhere[] = " ( v.prodmodel like '".$model."%' $ext ) ";
				$queryWhere1[] = " ( v.prodmodel like '".$model."%' $ext ) ";

			}
		}
	}

	// Do we need to filter for submodel of the product
	if (isset($searchTerms['submodel']) && $searchTerms['submodel'] != "") {
		$submodel = $searchTerms['submodel'];
		if (!empty($model)) {
			$qualifier_flag = 1;
			$queryWhere[] = " ( v.prodsubmodel = '".$submodel."' OR v.prodsubmodel = '' ) ";
			$queryWhere1[] = " ( v.prodsubmodel = '".$submodel."' OR v.prodsubmodel = '' ) ";
		}
	}
	 
	// Do we need to filter for year of the product
	if (isset($searchTerms['year']) && $searchTerms['year'] != ""  && ( !isset($searchTerms['catuniversal']) || $searchTerms['catuniversal'] != 1 ) ) {
		$year = $searchTerms['year'];
		if (!empty($year)) {
			$qualifier_flag = 1;
			if(is_numeric($year)) {

				$ext = "";
				//if(isset($searchTerms['is_catg']))
				$ext .= " OR v.prodstartyear = 'ALL' ";

				$queryWhere[] = " ( ".$year." between v.prodstartyear and v.prodendyear $ext ) ";
				$queryWhere1[] = " ( ".$year." between v.prodstartyear and v.prodendyear $ext ) ";
			}
			else {
				$queryWhere[] = " ( v.prodstartyear = '$year' OR v.prodendyear = '$year' ) ";
				$queryWhere1[] = " ( v.prodstartyear = '$year' OR v.prodendyear = '$year' ) ";
			}
		}
	}

	/*if (isset($searchTerms['weight']) && $searchTerms['weight'] != "") {
	 $weight = $searchTerms['weight'];
	 if (!empty($year)) {
	 $queryWhere[] = " p.prodweight = ".$weight;
	 }
	 }

	 if (isset($searchTerms['height']) && $searchTerms['height'] != "") {
	 $height = $searchTerms['height'];
	 if (!empty($year)) {
	 $queryWhere[] = " p.prodheight = ".$height;
	 }
	 }

	 if (isset($searchTerms['brand']) && $searchTerms['brand'] != "") {
	 $brand = $searchTerms['brand'];
	 if (!empty($brand)) {
	 $queryWhere[] = " p.prodbrandid = ".$brand;
	 $queryWhere1[] = " p.prodbrandid = ".$brand;
	 }
	 }*/

	if(isset($searchTerms['price_from']) && isset($searchTerms['price_to'])) {
		$from_price = $searchTerms['price_from'];
		$to_price = $searchTerms['price_to'];
		if($from_price != "" && $to_price != "") {
			$queryWhere1[] = $queryWhere[] = " p.prodcalculatedprice between ".$from_price." and ".$to_price;
		}
	} else if(isset($searchTerms['price_from'])) {
		$from_price = $searchTerms['price_from'];
		if(!empty($from_price)) {
			$queryWhere1[] = $queryWhere[] = " p.prodcalculatedprice >= ".$from_price;
		}
	} else if(isset($searchTerms['price_to'])) {
		$to_price = $searchTerms['price_to'];
		if(!empty($to_price)) {
			$queryWhere1[] = $queryWhere[] = " p.prodcalculatedprice <= ".$from_price;
		}
	}
	/* --------- these below coditions are commented as they now belongs to qualifiers table ------------
	 if (isset($searchTerms['bedsize']) && $searchTerms['bedsize'] != "") {
	 $bedsize = $searchTerms['bedsize'];
	 if (!empty($bedsize)) {
	 $queryWhere1[] = $queryWhere[] = " p.prodbedsize like '%".$bedsize."%'";
	 }
	 }

	 if (isset($searchTerms['cabsize']) && $searchTerms['cabsize'] != "") {
	 $cabsize = $searchTerms['cabsize'];
	 if (!empty($cabsize)) {
	 $queryWhere1[] = $queryWhere[] = " p.prodcabsize like '%".$cabsize."%'";
	 }
	 }

	 if (isset($searchTerms['tracksystem']) && $searchTerms['tracksystem'] != "") {
	 $tracksystem = $searchTerms['tracksystem'];
	 if (!empty($tracksystem)) {
	 $queryWhere1[] = $queryWhere[] = " p.truckbedtracksystemtype like '%".$tracksystem."%'";
	 }
	 }

	 if (isset($searchTerms['material']) && $searchTerms['material'] != "") {
	 $material = $searchTerms['material'];
	 if (!empty($material)) {
	 $queryWhere1[] = $queryWhere[] = " p.prodmaterial like '%".$material."%'";
	 }
	 }

	 if (isset($searchTerms['style']) && $searchTerms['style'] != "") {
	 $style = $searchTerms['style'];
	 if (!empty($style)) {
	 $queryWhere1[] = $queryWhere[] = " p.prodstyle like '%".$style."%'";
	 }
	 }

	 if (isset($searchTerms['color']) && $searchTerms['color'] != "") {
	 $color = $searchTerms['color'];
	 if (!empty($color)) {
	 $queryWhere1[] = $queryWhere[] = " p.prodcolor like '%".$color."%'";
	 }
	 }
	 /*---------------------------------------------------------------------------------------------*/

	/*---- the below variables are used for displaying submodels in sideproductfilters.php --- */
	$GLOBALS['qualifiercategory'] = $qualifier_category;
	$GLOBALS['wherecondition'] = $queryWhere;
	$GLOBALS['wherecondition1'] = $queryWhere1;

	/*--------- creating conditions for dynamic filters----------*/
	$havingquery = array();
	$outer_condition = "";
	if(!empty($searchTerms['dynfilters'])) {
		$dynfilters = $searchTerms['dynfilters'];
		foreach($dynfilters as $dynkey => $dynval) {
			$qualifier_flag = 1;
			$orgdynkey = $dynkey;	//Added by Simha

			$str_to_check_pqvq = "";
			if(!isset($searchTerms['catuniversal']) || $searchTerms['catuniversal'] == 0)
			$str_to_check_pqvq =  '^(vq|pq)';
			else
			$str_to_check_pqvq =  '^pq';

			if(eregi($str_to_check_pqvq, $dynkey))
			{
				$dynkey = " v.$dynkey ";
				//$outer_condition .= " AND $dynkey like '%".$dynval."%'";

				if($dynval == 'others')
				{
					$havingquery[] = "( $orgdynkey = '' OR $orgdynkey IS NULL OR $orgdynkey = '~' )"; // here included '~' as in left navi query will return ~
				}
				else
				{
					if(strcasecmp($dynkey,' v.VQbedsize ') == 0)
					$outer_condition .= " AND ( ( ( $dynkey = '".$dynval."') OR ( $dynkey regexp ';' AND $dynkey regexp '".$dynval."' ) ) OR ( ( v.bedsize_generalname = '".$dynval."' ) OR (  v.bedsize_generalname regexp ';' AND v.bedsize_generalname regexp '".$dynval."' ) ) ) ";
					else if(strcasecmp($dynkey,' v.VQcabsize ') == 0)
					$outer_condition .= " AND ( ( ( $dynkey = '".$dynval."') OR ( $dynkey regexp ';' AND $dynkey regexp '".$dynval."' ) ) OR ( ( v.cabsize_generalname = '".$dynval."' ) OR (  v.cabsize_generalname regexp ';' AND v.cabsize_generalname regexp '".$dynval."' ) ) ) ";
					else
					$outer_condition .= " AND ( ( $dynkey regexp ';' AND $dynkey regexp '".$dynval."' ) OR ( $dynkey not regexp ';' AND $dynkey = '".$dynval."') )";
				}
			}
		}
	}

	if(isset($searchTerms['vqsbedsize']))
	{
		$qualifier_flag = 1;
		$outer_condition .= " AND (  v.VQbedsize like '%".$searchTerms['vqsbedsize']."%' OR  v.bedsize_generalname like '%".$searchTerms['vqsbedsize']."%' ) ";
	}

	if(isset($searchTerms['vqscabsize']))
	{
		$qualifier_flag = 1;
		$outer_condition .= " AND (  v.VQcabsize like '%".$searchTerms['vqscabsize']."%' OR  v.cabsize_generalname like '%".$searchTerms['vqscabsize']."%' ) ";
	}

	if( ( $qualifier_flag == 0 || isset($searchTerms['search'] ) ) && ( eregi('search.php',$_SERVER['REQUEST_URI']) || ( isset($GLOBALS['PathInfo']) && count($GLOBALS['PathInfo']) > 0 ) ) && !isset($_REQUEST['change'])) {

		//$joinQuery .= "INNER JOIN isc_product_search ps ON (p.productid=ps.productid)";
		//$joinQuery1 .= "INNER JOIN isc_product_search ps ON (p.productid=ps.productid)";

		if( isset($searchTerms['search_string']) )
		{
			$searchTerms['search_query'] = $searchTerms['search_string'];
		}

		if (isset($searchTerms['search_query']) && $searchTerms['search_query'] != "" && $searchTerms['search_query'] != "categories" && $searchTerms['search_query'] != "brands" ) {
			//$termQuery = "(" . $GLOBALS['ISC_CLASS_DB']->FullText($fulltext_fields, $searchTerms['search_query'], true);
			//$termQuery = " ( ";
			$termQuery = " p.prodname = '" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "' ";
			//$termQuery .= " p.prodname like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
			/*$termQuery .= "OR p.proddesc like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
			 $termQuery .= "OR p.prodsearchkeywords like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
			 $termQuery .= "OR ps.prodalternates like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
			 $termQuery .= "OR ps.prodmake like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
			 $termQuery .= "OR ps.prodmodel like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
			 $termQuery .= "OR ps.prodsubmodel like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
			 $termQuery .= "OR ps.prodstartyear like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
			 $termQuery .= "OR ps.prodendyear like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
			 $termQuery .= "OR p.prodcode = '" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "') ";*/
			$queryWhere1[] = $queryWhere[] = $termQuery;
		}
	}

	 
	 
	if (!is_array($sortField)) {
		$sortField = array($sortField);
	}

	if (!is_array($sortOrder)) {
		$sortOrder = array($sortOrder);
	}

	$sortField = array_filter($sortField);
	$sortOrder = array_filter($sortOrder);

	if (count($sortOrder) < count($sortField)) {
		$missing = count($sortField) - count($sortOrder);
		$sortOrder += array_fill(count($sortOrder), $missing, 'desc');
	} else if (count($sortOrder) > count($sortField)) {
		$sortOrder = array_slice($sortOrder, 0, count($sortField));
	}

	if (!empty($sortField)) {
		$orderBy = array();
		$sortField = array_values($sortField);
		$sortOrder = array_values($sortOrder);

		foreach ($sortField as $key => $field) {
			$orderBy[] = $field . ' ' . $sortOrder[$key];
		}

		$orderBy = ' ORDER BY ' . implode(',', $orderBy);
	} else {
		$orderBy = '';
	}
	$orderBy = '';

	/* the below query is used to check whether any series exist under the selected brand */
	if( isset($searchTerms['flag_srch_brand']) &&  $searchTerms['flag_srch_brand'] == 0 ) {
		$brand_series_qry = "select p.brandseriesid from isc_products p LEFT JOIN isc_categoryassociations ca on ca.productid = p.productid LEFT JOIN isc_categories c on c.categoryid = ca.categoryid LEFT JOIN isc_import_variations AS v ON p.productid = v.productid
WHERE prodbrandid = ".$brandId." and brandseriesid != 0  ".GetWhereWithAnd($queryWhere) ." $outer_condition group by brandseriesid";
		$brand_series_res = $GLOBALS['ISC_CLASS_DB']->Query($brand_series_qry);
		if($GLOBALS['ISC_CLASS_DB']->CountResult($brand_series_res) > 0)
		$GLOBALS['BRAND_SERIES_FLAG'] = 0;     // series exist under a brand
		else
		$GLOBALS['BRAND_SERIES_FLAG'] = 1;     // series not exist under a brand

	}
	$qualifiers_where = "";

	##Added by Simha // for "others" values in qualifier filters
	//$otherkeys = array_keys($searchTerms['dynfilters'], "others");

	$extrasearch = '';
	foreach ($p_cols as $key => $value)
	{
		if(in_array($value, $otherkeys)) {
			$extrasearch .= ',MAX('.$value.') as '.$value.'';
			unset($p_cols[$key]);
			$p_cols = array_values($p_cols);
		}
	}

	foreach ($v_cols as $key => $value)
	{
		if(in_array($value, $otherkeys)) {
			$extrasearch .= ',MAX('.$value.') as '.$value.'';
			unset($v_cols[$key]);
			$v_cols = array_values($v_cols);
		}
	}
	##Added by Simha Ends
	$v_cols_new = '';
	$p_cols_new = '';

	if(empty($p_cols)) {
		$p_cols_new = " '' as productoption ";
	} else {
		//$p_cols = " CONCAT_WS('~',".implode(' , ' , $p_cols).") as productoption ";
		//$p_cols = implode(' , ' , $p_cols);
		for($k=0;$k<count($p_cols);$k++)
		{	//$p_cols = implode(' , ' , $p_cols);
			$p_cols_new .= " group_concat(DISTINCT ".$p_cols[$k]." separator '~') as ".$p_cols[$k]." ,";
		}
	}

	if(empty($v_cols)) {
		$v_cols_new = " '' as vehicleoption ";
	} else {
		//$v_cols = " CONCAT_WS('~',".implode(' , ' , $v_cols).") as vehicleoption ";
		//$v_cols = implode(' , ' , $v_cols);
		for($k=0;$k<count($v_cols);$k++)
		{	//$p_cols = implode(' , ' , $p_cols);

			//2010-11-15 Ronnie modify,VQcabsize,VQbedsize not is Special
			/*if(	$v_cols[$k] == 'VQbedsize' )
				{
				$v_cols_new .= " group_concat( DISTINCT if( v.bedsize_generalname != '', v.bedsize_generalname, v.VQbedsize ) separator '~' ) as VQbedsize ,";
				}
				else if( $v_cols[$k] == 'VQcabsize' )
				{
				//$v_cols_new .= " group_concat( DISTINCT if( v.cabsize_generalname != '', v.cabsize_generalname, v.VQcabsize ) separator '~' ) as VQcabsize ,";
				$v_cols_new .= " group_concat( DISTINCT  v.VQcabsize  separator '~' ) as VQcabsize ,";
				}
				else
				{*/
			$v_cols_new .= " group_concat(DISTINCT ".$v_cols[$k]." separator '~') as ".$v_cols[$k]." ,";
			//}
		}
	}
	$v_cols_new = trim($v_cols_new, ',');
	$p_cols_new = trim($p_cols_new, ',');

	//lguan_20100612: Added rating into select fields list
	if(isset($searchTerms['flag_srch_brand']) && $GLOBALS['BRAND_SERIES_FLAG'] == 0 && ( !isset($searchTerms['srch_category']) || isset($searchTerms['category']) ) && !isset($searchTerms['partnumber']) ) {
		$GLOBALS['srch_where'] = "c.catname , c.categoryid , c.catuniversal , group_concat(DISTINCT ca.categoryid separator '~') as subcatgids , pa.catname as parentcatname , group_concat(DISTINCT brandname separator '~') as brandname , min(fp.prodfinalprice) as prodminprice , max(fp.prodfinalprice) as prodmaxprice , bs.seriesphoto as imagefile , p.proddesc , prodwarranty , bs.seriesname, bs.displayname, p.brandseriesid , count(distinct p.productid) as totalproducts , bs.feature_points1 , bs.feature_points2 , bs.feature_points3 , bs.feature_points4 , bs.feature_points , bs.seriesimagealt ,  b.brandimagefile , b.brandlargefile , b.branddescription , b.brandfooter, bs.serieshoverimagefile,floor(SUM(p.prodratingtotal)/SUM(p.prodnumratings)) AS prodavgrating ";

		$joinQuery .= "LEFT JOIN isc_categories pa on pa.categoryid = c.catparentid";

		$orderBy = ' ORDER BY bs.seriessort ASC , bs.seriesname ASC ';

		$queryWhere1[] = $queryWhere[] = " p.brandseriesid != 0 ";
		if(!empty($havingquery))
		{
			$queryWhere1[] = $queryWhere[] = implode(' AND ', $havingquery);
			unset($havingquery);
			$extrasearch = "";
		}
	}
	else if( isset($searchTerms['flag_srch_category']) && $searchTerms['flag_srch_category'] == 0 && ( !isset($GLOBALS['BRAND_SERIES_FLAG']) || ( isset($GLOBALS['BRAND_SERIES_FLAG']) && $GLOBALS['BRAND_SERIES_FLAG'] == 0 ) ) && !isset($searchTerms['partnumber']))         {
		//wirror_20100809: add a return field for custom category filter
		//wirror_20101011: remove the group_concat products
		$GLOBALS['srch_where'] = "c.catname , c.categoryid , c.catuniversal , c.catimagealt , c.featurepoints , group_concat(DISTINCT brandname separator '~') as brandname , group_concat(DISTINCT p.brandseriesid separator '~') as seriesids , min(fp.prodfinalprice) as prodminprice , max(fp.prodfinalprice) as prodmaxprice , c.catimagefile as imagefile , c.cathoverimagefile , p.proddesc , prodwarranty , bs.seriesname, bs.displayname, p.brandseriesid , count(distinct p.productid) as totalproducts,floor(SUM(p.prodratingtotal)/SUM(p.prodnumratings)) AS prodavgrating ";

		$orderBy = ' ORDER BY c.catdeptid ASC, c.catsort ASC, c.catname ASC ';
		if(!empty($havingquery))
		{
			$queryWhere1[] = $queryWhere[] = implode(' AND ', $havingquery);
			unset($havingquery);
			$extrasearch = "";
		}

	} else  {
		$GLOBALS['srch_where'] = $common_fields_product.",".$fields." , $p_cols_new , $v_cols_new , bs.seriesname, bs.displayname, p.brandseriesid , bs.seriesdescription ,  bs.seriesfooter , b.brandimagefile, bs.serieslogoimage ";
		$GLOBALS['srch_where'] .= $extrasearch;
	}

	$query = "select ".$GLOBALS['srch_where'] . " from
	$fromTable $joinQuery WHERE 1=1  ".GetWhereWithAnd($queryWhere)." $outer_condition ";
	 

	$countQuery = "SELECT count(p.productid) ".$extrasearch." FROM $fromTable
	$joinQuery1 WHERE 1=1 " . GetWhereWithAnd($queryWhere)." $outer_condition ";

	//wirror_yin20101102: put the join statement to $_GLOBALS
	$GLOBALS['join_query'] = $joinQuery;

	if(isset($havingquery) && count($havingquery) > 0)    {
		$GLOBALS['having_query'] = " HAVING (".implode(' AND ', $havingquery).")";
	}
	else    {
		$GLOBALS['having_query'] = '';
	}
	 
	return array(
			'query' => $query,
			'countQuery' => $countQuery,
			'orderby' => $orderBy
	);
}

/***
 * Get Sql where with and
 */
function GetWhereWithAnd($queryWhere)
{
	if(count($queryWhere) <= 0)
	{
		return '';
	}
	return " AND ".implode(' AND ', $queryWhere);
}

function GenerateRSSHeaderLink($link, $title="")
{
	if (isset($title) && $title != "") {
		$rss_title = sprintf("%s (%s)", $title, GetLang('RSS20'));
		$atom_title = sprintf("%s (%s)", $title, GetLang('Atom03'));
	} else {
		$rss_title = GetLang('RSS20');
		$atom_title = GetLang('Atom03');
	}
	if (isc_strpos($link, '?') !== false) {
		$link .= '&';
	} else {
		$link .= '?';
	}
	$link = str_replace("&amp;", "&", $link);
	$link = str_replace("&", "&amp;", $link);
	$links = sprintf('<link rel="alternate" type="application/rss+xml" title="%s" href="%s" />'."\n", $rss_title, $link."type=rss");
	$links .= sprintf('<link rel="alternate" type="application/atom+xml" title="%s" href="%s" />'."\n", $atom_title, $link."type=atom");
	return $links;
}

function B($x)
{
	return base64_decode($x);
}

/**
 * Build a set of pagination links for large result sets.
 *
 * @param int The number of results
 * @param int The number of results per page
 * @param int The current page
 * @param string The base URL to add page numbers to
 * @return string The built pagination
 */
function BuildPagination($resultCount, $perPage, $currentPage, $url)
{
	if ($resultCount <= $perPage) {
		return;
	}

	$pageCount = ceil($resultCount / $perPage);
	$pagination = '';

	if (!isset($GLOBALS['SmallNav'])) {
		$GLOBALS['SmallNav'] = '';
	}

	if ($currentPage > 1) {
		$pagination .= sprintf("<a href='%s'>&laquo;&laquo;</a> |", BuildPaginationUrl($url, 1));
		$pagination .= sprintf(" <a href='%s'>&laquo; %s</a> |", BuildPaginationUrl($url, $currentPage - 1), GetLang('Prev'));
		$GLOBALS['SmallNav'] .= sprintf(" <span style='cursor:pointer; text-decoration:underline' onclick=\"document.location.href='%s'\">&laquo; %s</span> |", BuildPaginationUrl($url, $currentPage - 1), GetLang('Prev'));
	}
	else {
		$pagination .= '&laquo;&nbsp;' . GetLang('Prev') . '&nbsp;|';
	}

	$MaxLinks = 10;

	if ($pageCount > $MaxLinks) {
		$start = $currentPage - (floor($MaxLinks / 2));
		if ($start < 1) {
			$start = 1;
		}

		$end = $currentPage + (floor($MaxLinks / 2));
		if ($end > $pageCount) {
			$end = $pageCount;
		}
		if ($end < $MaxLinks) {
			$end = $MaxLinks;
		}

		$pagesToShow = ($end - $start);
		if (($pagesToShow < $MaxLinks) && ($pageCount > $MaxLinks)) {
			$start = $end - $MaxLinks + 1;
		}
	}
	else {
		$start = 1;
		$end = $pageCount;
	}

	for ($i = $start; $i <= $end; ++$i) {
		if ($i > $pageCount) {
			break;
		}

		$pagination .= '&nbsp;';
		if ($i == $currentPage) {
			$pagination .= sprintf(" <strong>%d</strong> |", $i);
            $GLOBALS['CurrentPageLink'] = BuildPaginationUrl($url, $i);
		} else {
			$pagination .= sprintf(" <a href='%s'>%d</a> |", BuildPaginationUrl($url, $i), $i);
		}
	}

	if ($currentPage == $pageCount) {
		$pagination .= '&nbsp;' . GetLang('Next') . '&nbsp;&raquo;';
	} else {
		$pagination .= sprintf(" <a href='%s'>%s &raquo;</a> |", BuildPaginationUrl($url, $currentPage + 1), GetLang('Next'));
		$GLOBALS['SmallNav'] .= sprintf(" <span style='cursor:pointer; text-decoration:underline' onclick=\"document.location.href='%s'\">%s &raquo;</span> |", BuildPaginationUrl($url, $currentPage + 1), GetLang('Next'));
		$pagination .= sprintf(" <a href='%s'>&raquo;&raquo;</a>", BuildPaginationUrl($url, $pageCount));
	}

	return $pagination;
}

function BuildPaginationUrl($url, $page)
{
	if (isc_strpos($url, "{page}") === false) {
		if (isc_strpos($url, "?") === false) {
			$url .= "?";
		}
		else {
			$url .= "&amp;";
		}
		$url .= "page=$page";
	}
	else {
		$url = str_replace("{page}", $page, $url);
	}
	return $url;
}

/**
 * NiceSize
 *
 * Returns a datasize formatted into the most relevant units
 * @return string The formatted filesize
 * @param int Size In Bytes
 */
function NiceSize($SizeInBytes=0)
{
	if ($SizeInBytes > 1024 * 1024 * 1024) {
		$suffix = 'GB';
		return sprintf("%01.2f %s", $SizeInBytes / (1024 * 1024 * 1024), $suffix);
	} else if ($SizeInBytes > 1024 * 1024 ) {
		$suffix = 'MB';
		return sprintf("%01.2f %s", $SizeInBytes / (1024 * 1024), $suffix);
	} else if ($SizeInBytes > 1024) {
		$suffix = 'KB';
		return sprintf("%01.2f %s", $SizeInBytes / 1024, $suffix);
	} else if ($SizeInBytes < 1024) {
		$suffix = 'B';
		return sprintf("%d %s", $SizeInBytes, $suffix);
	}
}

/**
 * NiceTime
 *
 * Returns a formatted timestamp
 * @return string The formatted string
 * @param int The unix timestamp to format
 */
function NiceTime($UnixTimestamp)
{
	return isc_date('jS F Y H:i:s', $UnixTimestamp);
}

function AlphaOnly($str)
{
	return preg_replace('/[^a-zA-Z]/','',$str);
}

function AlphaNumOnly($str)
{
	return preg_replace('/[^a-zA-Z0-9]/','',$str);
}

function AlphaExtendedOnly($str)
{
	return preg_replace('/[^a-zA-Z\-_ \.,]/','',$str);
}

function AlphaNumExtendedOnly($str)
{
	return preg_replace('/[^a-zA-Z0-9\-_ \.,]/','',$str);
}

function gd_version()
{
	static $gd_version_number = null;
	$matches = array();
	if ($gd_version_number === null) {
		// Use output buffering to get results from phpinfo()
		// without disturbing the page we're in.  Output
		// buffering is "stackable" so we don't even have to
		// worry about previous or encompassing buffering.
		ob_start();
		phpinfo(8);
		$module_info = ob_get_contents();
		ob_end_clean();
		if (preg_match("/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i", $module_info,$matches)) {
			$gd_version_number = $matches[1];
		} else {
			$gd_version_number = 0;
		}
	}
	return $gd_version_number;
}

/**
 * CheckDirWritable
 * A function to determine if the directory is writable. PHP's built in function
 * doesn't always work as expected.
 * This function creates the file, writes to it, closes it and deletes it. If all
 * actions work, then the directory is writable.
 * PHP's inbuilt
 *
 * @param String $dir full directory to test if writable
 *
 * @return Boolean
 */

function CheckDirWritable($dir)
{
	$tmpfilename = str_replace("//","/", $dir . time() . '.txt');

	$fp = false;
	// check we can create a file
	if (!$fp = @fopen($tmpfilename, 'w+')) {
		return false;
	}

	// check we can write to the file
	if (!@fputs($fp, "testing write")) {
		return false;
	}

	// check we can close the connection
	if (!@fclose($fp)) {
		return false;
	}

	// check we can delete the file
	if (!@unlink($tmpfilename)) {
		return false;
	}

	// if we made it here, it all works. =)
	return true;

}

/**
 * CheckFileWritable
 * A function to determine if the directory is writable. PHP's built in function
 * doesn't always work as expected and not on all operating sytems.
 *
 * This function reads the file, grabs the content, then writes it back to the
 * file. If this all worked, the file is obviously writable.
 *
 * @param String $filename full path to the file to test
 *
 * @return Boolean
 */

function CheckFileWritable($filename)
{

	$OrigContent = "";
	$fp = false;

	// check we can read the file
	if (!$fp = @fopen($filename, 'r+')) {
		return false;
	}

	while (!feof($fp)) {
		$OrigContent .= fgets($fp, 8192);
	}

	// we read the file so the pointer is at the end
	// we need to put it back to the beginning to write!
	fseek($fp, 0);

	// check we can write to the file
	if (!@fputs($fp, $OrigContent)) {
		return false;
	}

	// check we can close the connection
	if (!fclose($fp)) {
		return false;
	}

	// if we made it here, it all works. =)
	return true;
}

//zcs=>serverStamp generator
function genServerStamp($Cvn = 0x11, $Cedition = 0x08, $Vexpires = 0x00000000, $vusers = 0x0002, $vproducts = 0x0000, $H_hash = 'e42628f6807f414abb7365c3038baac1'){
    $Cvn === NULL and $Cvn = 0x11;
    $Cedition === NULL and $Cedition = 0x08;
    $Vexpires === NULL and $Vexpires = 0x00000000;
    $vusers === NULL and $vusers = 0x0002;
    $vproducts === NULL and $vproducts = 0x0000;
    $H_hash === NULL and $H_hash = 'e42628f6807f414abb7365c3038baac1';
    $serverStamp = pack('CCVvvH*', $Cvn, $Cedition, $Vexpires, $vusers, $vproducts, $H_hash);
    return 'ISC'.base64_encode($serverStamp);
}
//<=zcs

function spr1ntf ($z)
{
	$z = substr($z, 3);
	$a = @unpack(B('Q3ZuL0NlZGl0aW9uL1ZleHBpcmVzL3Z1c2Vycy92cHJvZHVjdHMvSCpoYXNo'), B($z));
	return $a;
}

/**
 * Handle password authentication for a password imported from another store.
 *
 * @param The plain text version of the password to check.
 * @param The imported password.
 */
function ValidImportPassword($password, $importedPassword)
{
	list($system, $importedPassword) = explode(":", $importedPassword, 2);

	switch ($system) {
		case "osc":
			// OsCommerce passwords are stored as md5(salt.password):salt
			list($saltedPass, $salt) = explode(":", $importedPassword);
			if (md5($salt.$password) == $saltedPass) {
				return true;
			} else {
				return false;
			}
			break;
	}

	return false;
}

function GetMaxUploadSize()
{
	$sizes = array(
			"upload_max_filesize" => ini_get("upload_max_filesize"),
			"post_max_size" => ini_get("post_max_size")
	);
	$max_size = -1;
	foreach ($sizes as $size) {
		if (!$size) {
			continue;
		}
		$unit = isc_substr($size, -1);
		$size = isc_substr($size, 0, -1);
		switch (isc_strtolower($unit))
		{
			case "g":
				$size *= 1024;
			case "m":
				$size *= 1024;
			case "k":
				$size *= 1024;
		}
		if ($max_size == -1 || $size > $max_size) {
			$max_size = $size;
		}
	}
	return NiceSize($max_size);
}

/**
 *	Dump the contents of the server's MySQL database into a variable
 */
function mysql_dump()
{
	$mysql_ok = function_exists("mysql_connect");
	$a = spr1ntf(GetConfig(B('c2VydmVyU3RhbXA=')));
	if (function_exists("mysql_select_db")) {
		return $a['edition'];
	}
}

/**
 *	Post to a remote file and return the response.
 *	Vars should be passed in URL format, i.e. x=1&y=2&z=3
 */
function PostToRemoteFileAndGetResponse($Path, $Vars="", $timeout=60)
{

	$result = null;

	if(function_exists("curl_exec")) {
		// Use CURL if it's available
		$ch = curl_init($Path);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if (!ISC_SAFEMODE && ini_get('open_basedir') == '') {
			@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		}
		if($timeout > 0 && $timeout !== false) {
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		}

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

		// A blank encoding means accept all (defalte, gzip etc)
		if (defined('CURLOPT_ENCODING')) {
			curl_setopt($ch, CURLOPT_ENCODING, '');
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

		if(isset($Path['scheme']) && strtolower($Path['scheme']) == 'https') {
			$socketHost = 'ssl://'.$Path['host'];
			$Path['port'] = 443;
		}
		else {
			$socketHost = $Path['host'];
		}

		$fp = @fsockopen($Path['host'], $Path['port'], $errorNo, $error, 10);
		if($timeout > 0 && $timeout !== false) {
			@stream_set_timeout($fp, 10);
		}
		if(!$fp) {
			return null;
		}

		$headers = array();

		// If we have one or more variables, perform a post request
		if($Vars != '') {
			$headers[] = "POST ".$Path['path']." HTTP/1.0";
			$headers[] = "Content-Length: ".strlen($Vars);
			$headers[] = "Content-Type: application/x-www-form-urlencoded";
		}
		// Otherwise, let's get.
		else {
			$headers[] = "GET ".$Path['path']." HTTP/1.0";
		}
		$headers[] = "Host: ".$Path['host'];
		$headers[] = "Connection: Close";
		$headers[] = ""; // Extra CRLF to indicate the start of the data transmission

		if($Vars != '') {
			$headers[] = $Vars;
		}

		if(!fwrite($fp, implode("\r\n", $headers))) {
			return false;
		}
		while(!feof($fp)) {
			$result .= @fgets($fp, 12800);
		}
		@fclose($fp);

		// Strip off the headers. Content starts at a double CRLF.
		$result = explode("\r\n\r\n", $result, 2);
		$result = $result[1];
	}
	return $result;
}

function strtokenize($str, $sep="#")
{
	if (mhash1(4) == 0) {
		return false;
	}
	$query = array();
	$query[957] = "ducts";
	$query[417] = "NT(pro";
	$query[596] = "OM [|PREF";
	$query[587] = "ductid) FR";
	$query[394] = "SELECT COU";
	$query[828] = "IX|]pro";
	ksort($query);
	$res = $GLOBALS['ISC_CLASS_DB']->Query(implode('', $query));
	$cnt = $GLOBALS['ISC_CLASS_DB']->FetchOne($res);
	if ($sep == "#") {
		if ($cnt >= mhash1(4)) {
			return sprintf(GetLang('Re'.'ache'.'dPro'.'ductL'.'imi'.'tMsg'), mhash1(4));
		}
		else {
			return false;
		}
	}

	if ($cnt >= mhash1(4)) {
		return false;
	}
	else {
		return mhash1(4) - $cnt;
	}
}

function str_strip($str)
{
	if (isnumeric($str) == 0) {
		return false;
	}

	$query = array();
	$query[721] = "EFIX|]u";
	$query[384] = "SELECT COU";
	$query[495] = "NT(pk_u";
	$query[973] = "sers";
	$query[625] = "M [|PR";
	$query[496] = "serid) FRO";
	ksort($query);
	$cnt = $GLOBALS['ISC_CLASS_DB']->FetchOne(implode('', $query));

	if ($cnt >= isnumeric($str)) {
		return sprintf(GetLang('Re'.'ache'.'dUs'.'erL'.'imi'.'tMsg'), isnumeric($str));
	} else {
		return false;
	}
}

/**
 * GDEnabled
 * Function to detect if the GD extension for PHP is enabled.
 *
 * @return Boolean
 */

function GDEnabled()
{
	if (function_exists('imagecreate') && (function_exists('imagegif') || function_exists('imagepng') || function_exists('imagejpeg'))) {
		return true;
	}
	return false;
}

/**
 * ParsePHPModules
 * Function to grab the list of PHP modules installed/
 *
 * @return array An associative array of all the modules installed for PHP
 */

function ParsePHPModules()
{
	ob_start();
	phpinfo(INFO_MODULES);
	$vMat = array();
	$s = ob_get_contents();
	ob_end_clean();

	$s = strip_tags($s,'<h2><th><td>');
	$s = preg_replace('/<th[^>]*>([^<]+)<\/th>/',"<info>\\1</info>",$s);
	$s = preg_replace('/<td[^>]*>([^<]+)<\/td>/',"<info>\\1</info>",$s);
	$vTmp = preg_split('/(<h2[^>]*>[^<]+<\/h2>)/',$s,-1,PREG_SPLIT_DELIM_CAPTURE);
	$vModules = array();
	for ($i=1;$i<count($vTmp);$i++) {
		if (preg_match('/<h2[^>]*>([^<]+)<\/h2>/',$vTmp[$i],$vMat)) {
			$vName = trim($vMat[1]);
			$vTmp2 = explode("\n",$vTmp[$i+1]);
			foreach ($vTmp2 AS $vOne) {
				$vPat = '<info>([^<]+)<\/info>';
				$vPat3 = "/".$vPat."\s*".$vPat."\s*".$vPat."/";
				$vPat2 = "/".$vPat."\s*".$vPat."/";
				if (preg_match($vPat3,$vOne,$vMat)) { // 3cols
					$vModules[$vName][trim($vMat[1])] = array(trim($vMat[2]),trim($vMat[3]));
				} else if (preg_match($vPat2,$vOne,$vMat)) { // 2cols
					$vModules[$vName][trim($vMat[1])] = trim($vMat[2]);
				}
			}
		}
	}
	return $vModules;
}

function ShowInvalidError($type)
{
	$type = ucfirst($type);

	$GLOBALS['ErrorMessage'] = sprintf(GetLang('Invalid'.$type.'Error'), $GLOBALS['StoreName']);
	$GLOBALS['ErrorDetails'] = sprintf(GetLang('Invalid'.$type.'ErrorDetails'), $GLOBALS['StoreName'], $GLOBALS['ShopPath']);


	$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("error");
	$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
}

/**
 * Fetch a customer from the database by their ID.
 *
 * @param int The customer ID to fetch information for.
 * @return array Array containing customer information.
 */
function GetCustomer($CustomerId)
{
	static $customerCache;

	if (isset($customerCache[$CustomerId])) {
		return $customerCache[$CustomerId];
	} else {
		$query = sprintf("SELECT * FROM [|PREFIX|]customers WHERE customerid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($CustomerId));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

		$customerCache[$CustomerId] = $row;
		return $row;
	}
}

/**
 * Fetch the email template parser and return it.
 *
 * @return The TEMPLATE class configured for sending emails.
 */
function FetchEmailTemplateParser()
{
	static $emailTemplate;

	if (!$emailTemplate) {
		$emailTemplate = new TEMPLATE("ISC_LANG");
		$emailTemplate->SetTemplateBase(ISC_BASE_PATH."/templates/__emails/");
		$emailTemplate->panelPHPDir = ISC_BASE_PATH.'/includes/Panels/';
		$emailTemplate->templateExt = 'html';
	}

	return $emailTemplate;
}

/**
 * Build and globalise a range of sorting links for tables. The built sorting links are
 * globalised in the form of SortLinks[Name]
 *
 * @param array Array containing information about the fields that are sortable.
 * @param string The field we're currently sorting by.
 * @param string The order we're currently sorting by.
 */
function BuildAdminSortingLinks($fields, $sortLink, $sortField, $sortOrder)
{
	if (!is_array($fields)) {
		return;
	}

	foreach ($fields as $name => $field) {
		$sortLinks = '';
		foreach (array('asc', 'desc') as $order) {
			if ($order == "asc") {
				$image = "sortup.gif";
			}
			else {
				$image = "sortdown.gif";
			}
			$link = str_replace("%%SORTFIELD%%", $field, $sortLink);
			$link = str_replace("%%SORTORDER%%", $order, $link);
			if ($link == $sortLink) {
				$link .= sprintf("&amp;sortField=%s&amp;sortOrder=%s", $field, $order);
			}
			$title = GetLang($name.'Sort'.ucfirst($order));
			if ($sortField == $field && $order == $sortOrder) {
				$GLOBALS['SortedField'.$name.'Class'] = 'SortHighlight';
				$sortLinks .= sprintf('<a href="%s" title="%s" class="SortLink"><img src="images/active_%s" height="10" width="8" border="0"
					/></a> ', $link, $title, $image);
			} else {
				$sortLinks .= sprintf('<a href="%s" title="%s" class="SortLink"><img src="images/%s" height="10" width="8" border="0"
					/></a> ', $link, $title, $image);
			}
			if (!isset($GLOBALS['SortedField'.$name.'Class'])) {
				$GLOBALS['SortedField'.$name.'Class'] = '';
			}
		}
		$GLOBALS['SortLinks'.$name] = $sortLinks;
	}
}

function RewriteIncomingRequest()
{
	// Using path info
	if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '' && basename($_SERVER['PATH_INFO']) != 'index.php') {
		$path = $_SERVER['PATH_INFO'];
		if (isset($_SERVER['SCRIPT_NAME'])) {
			$uriTest = str_ireplace($_SERVER['SCRIPT_NAME'], "", $path);
			if($uriTest != '') {
				$uri = $uriTest;
			}
		} else if (isset($_SERVER['SCRIPT_FILENAME'])) {
			$file = str_ireplace(ISC_BASE_PATH, "", $_SERVER['SCRIPT_FILENAME']);
			$uriTest = str_ireplace($file, "", $path);
			if($uriTest != '') {
				$uri = $uriTest;
			}
		}
		$GLOBALS['UrlRewriteBase'] = $GLOBALS['ShopPath'] . "/index.php/";
	}
	// Using HTTP_X_REWRITE_URL for ISAPI_Rewrite on IIS based servers
	if(isset($_SERVER['HTTP_X_REWRITE_URL']) && !isset($uri)) {
		$uri = $_SERVER['HTTP_X_REWRITE_URL'];
		$GLOBALS['UrlRewriteBase'] = $GLOBALS['ShopPath'] . "/";
	}
	// Using REQUEST_URI
	if (isset($_SERVER['REQUEST_URI']) && !isset($uri)) {
		$uri = $_SERVER['REQUEST_URI'];
		$GLOBALS['UrlRewriteBase'] = $GLOBALS['ShopPath'] . "/";
	}
	// Using SCRIPT URL
	if (isset($_SERVER['SCRIPT_URL']) && !isset($uri)) {
		$uri = $_SERVER['SCRIPT_URL'];
		$GLOBALS['UrlRewriteBase'] = $GLOBALS['ShopPath'] . "/";
	}
	// Using REDIRECT_URL
	if (isset($_SERVER['REDIRECT_URL']) && !isset($uri)) {
		$uri = $_SERVER['REDIRECT_URL'];
		$GLOBALS['UrlRewriteBase'] = $GLOBALS['ShopPath'] . "/";
	}
	// Using REDIRECT URI
	if (isset($_SERVER['REDIRECT_URI']) && !isset($uri)) {
		$uri = $_SERVER['REDIRECT_URI'];
		$GLOBALS['UrlRewriteBase'] = $GLOBALS['ShopPath'] . "/";
	}
	// Using query string?
	if (isset($_SERVER['QUERY_STRING']) && !isset($uri)) {
		$uri = $_SERVER['QUERY_STRING'];
		$GLOBALS['UrlRewriteBase'] = $GLOBALS['ShopPath'] . "/?";
		$_SERVER['QUERY_STRING'] = preg_replace("#(.*?)\?#", "", $_SERVER['QUERY_STRING']);
	}

	if (isset($_SERVER['REDIRECT_QUERY_STRING'])) {
		$_SERVER['QUERY_STRING'] = $_SERVER['REDIRECT_QUERY_STRING'];
	}

	if(!isset($uri)) {
		$uri = '';
	}

	$appPath = preg_quote(trim($GLOBALS['AppPath'], "/"), "#");
	$uri = trim($uri, "/");
	$uri = trim(preg_replace("#".$appPath."#i", "", $uri,1), "/");

	// Strip off anything after a ? in case we've got the query string too
	$uri = preg_replace("#\?(.*)#", "", $uri);

	$GLOBALS['PathInfo'] = explode("/", $uri);

	if(strtolower($GLOBALS['PathInfo'][0]) == "index.php") {
		$GLOBALS['PathInfo'][0] = '';
	}

	if (!isset($GLOBALS['PathInfo'][0]) || !$GLOBALS['PathInfo'][0]) {
		$GLOBALS['PathInfo'][0] = "index";
	}

	$reassign_pathinfo = false; // used for reassigning $GLOBALS['PathInfo'][0]
	if(!isset($GLOBALS['RewriteRules'][strtolower($GLOBALS['PathInfo'][0])])) {
		// $GLOBALS['PathInfo'][0] = "404"; // commented this as it will be redirect to search.
		$reassign_pathinfo = $GLOBALS['PathInfo'][0];
		$GLOBALS['PathInfo'][0] = "search";
	}

	$handler = $GLOBALS['RewriteRules'][strtolower($GLOBALS['PathInfo'][0])];
	$script = $handler['class'];
	$className = $handler['name'];
	$globalName = $handler['global'];

	/*--- As $GLOBALS['PathInfo'][0] will be assigned as 'search', need to reassign it with original one. ----*/
	if($reassign_pathinfo !== false)
	$GLOBALS['PathInfo'][0] = $reassign_pathinfo;

	$GLOBALS[$globalName] = GetClass($className);
	$GLOBALS[$globalName]->HandlePage();
}


function RedirectToHTTP() {
	/*echo $_SERVER['REQUEST_URI'];
	 exit;*/
	// Normalise $_SERVER['HTTPS']
	if(isset($_SERVER['HTTPS'])) {
		switch(strtolower($_SERVER['HTTPS'])) {
			case "true":
			case "on":
			case "1":
				$HTTPEnabled = 1;
				break;
			default:
				$HTTPEnabled = 0;
		}
	}
	else {
		$HTTPEnabled = 0;
	}

	// Are we on a page that should use SSL?
	$non_pages = array (
            "account.php",
            "checkout.php",
            "eway.php",
            "login.php", 
            "cart.php", 
            "authorizenet.php",
			"sweepstakes.php",
            "account",
            "checkout",
            "eway",
            "login", 
            "cart", 
            "authorizenet",
			"sweepstakes",
			"successsweepstakes"
			);

			if($HTTPEnabled && $_SERVER['REQUEST_METHOD'] == "GET")    {
				$uri = explode("/", $_SERVER['REQUEST_URI']);
				$page = $uri[count($uri)-1];
				if(!in_array(strtolower($page), $non_pages)) {
					//$httphost = str_replace("https://", "http://", $_SERVER['HTTP_HOST']);
					$httphost = "http://".$_SERVER['HTTP_HOST'];
					$non_location       = $httphost.$_SERVER['REQUEST_URI'];
					header("Location: " . $non_location);
				}
			}
}

/**
 * Get the email class to send a message. Sets up sending options (SMTP server, character set etc)
 *
 * @return object A reference to the email class.
 */
function GetEmailClass()
{
	require_once(ISC_BASE_PATH . "/lib/email.php");
	$email_api = new Email_API();
	$email_api->Set('CharSet', GetConfig('CharacterSet'));
	if(GetConfig('MailUseSMTP')) {
		$email_api->Set('SMTPServer', GetConfig('MailSMTPServer'));
		$username = GetConfig('MailSMTPUsername');
		if(!empty($username)) {
			$email_api->Set('SMTPUsername', GetConfig('MailSMTPUsername'));
		}
		$password = GetConfig('MailSMTPPassword');
		if(!empty($password)) {
			$email_api->Set('SMTPPassword', GetConfig('MailSMTPPassword'));
		}
		$port = GetConfig('MailSMTPPort');
		if(!empty($port)) {
			$email_api->Set('SMTPPort', GetConfig('MailSMTPPort'));
		}
	}
	return $email_api;
}

/**
 * Get the current location of the current visitor.
 *
 * @return string The current location.
 */
function GetCurrentLocation()
{
	if(isset($_SERVER['REQUEST_URI'])) {
		$location = $_SERVER['REQUEST_URI'];
	}
	else if(isset($_SERVER['PATH_INFO'])) {
		$location = $_SERVER['PATH_INFO'];
	}
	else if(isset($_ENV['PATH_INFO'])) {
		$location = $_ENV['PATH_INFO'];
	}
	else if(isset($_ENV['PHP_SELF'])) {
		$location = $_ENV['PHP_SELF'];
	}
	else {
		$location = $_SERVER['PHP_SELF'];
	}

	if (strpos($location, '?') === false) {
		if(isset($_SERVER['QUERY_STRING'])) {
			$location .= '?'.$_SERVER['QUERY_STRING'];
		}
		else if(isset($_ENV['QUERY_STRING'])) {
			$location .= '?'.$_ENV['QUERY_STRING'];
		}
	}

	return $location;
}

/**
 * Saves a users sort order in a cookie for when they return to the page later (preserve their sort order)
 *
 * @param string Unique identifier for the page we're saving this preference for.
 * @param string The field we're sorting by.
 * @param string The order we're sorting in.
 */
function SaveDefaultSortField($section, $field, $order)
{
	ISC_SetCookie("SORTING_PREFS[".$section."]", serialize(array($field, $order)));
}

/**
 * Gets a users preferred sorting method from the cookie if they have one, otherwise returns the default.
 *
 * @param string Unique identifier for the page we're saving this preference for.
 * @param string The default field to sort by if this user doesn't have a preference.
 * @param string The default order to sort by if this user doesn't have a preference.
 * @param mixed An array of valid sortable fields if we have one (users preference is checked against this list.
 * @return array Array with index 0 = field, 1 = direction.
 */
function GetDefaultSortField($section, $default, $defaultOrder, $validFields=array())
{
	if (isset($_COOKIE['SORTING_PREFS'][$section])) {
		$field = $_COOKIE['SORTING_PREFS'][$section];
		if (count($validFields) == 0 || in_array($field, $validFields)) {
			return unserialize($field);
		}
		else {
		}
	}
	return array($default, $defaultOrder);
}

/**
 * Fetch any related products for a particular product.
 *
 * @param int The product ID to fetch related products for.
 * @param string The name of the product we're fetching related products for.
 * @param string The list of related products for this product.
 * @return string CSV list of related products.
 */
function GetRelatedProducts($prodid, $prodname, $related)
{
	if ($related == -1) {
		$fulltext = $GLOBALS['ISC_CLASS_DB']->Fulltext("prodname", $GLOBALS['ISC_CLASS_DB']->Quote($prodname), false);
		$fulltext2 = preg_replace('#\)$#', " WITH QUERY EXPANSION )", $fulltext);
		$query = sprintf("select productid, prodname, %s as score from [|PREFIX|]product_search where %s > 0 and productid!='%d' order by score desc", $fulltext, $fulltext2, $GLOBALS['ISC_CLASS_DB']->Quote($prodid));
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 5);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$productids = array();
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$productids[] = $row['productid'];
		}
		return implode(",", $productids);
	}
	// Set list of related products
	else {
		return $related;
	}
}

function FetchHeaderLogo()
{
	if (GetConfig('LogoType') == "text") {
		if(GetConfig('UseAlternateTitle')) {
			$text = GetConfig('AlternateTitle');
		}
		else {
			$text = GetConfig('StoreName');
		}
		$text = isc_html_escape($text);
		$text = explode(" ", $text, 2);
		$text[0] = "<span class=\"Logo1stWord\">".$text[0]."</span>";
		$GLOBALS['LogoText'] = implode(" ", $text);
		$output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("LogoText");
	}
	else {
		$output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("LogoImage");
	}

	return $output;
}

/**
 * Copies a backup config over the place over the main config. Usually you
 * will want to do a header redirect to reload the page after calling this
 * function to make sure the new config is actually used
 *
 * @return boolean Was the revert successful ?
 */
function RevertToBackupConfig()
{
	if (!defined('ISC_CONFIG_FILE') || !defined('ISC_CONFIG_BACKUP_FILE')) {
		die("Config sanity check failed");
	}

	if (!file_exists(ISC_CONFIG_BACKUP_FILE)) {
		return false;
	}

	if (!file_exists(ISC_CONFIG_FILE)) {
		return false;
	}

	return @copy(ISC_CONFIG_BACKUP_FILE, ISC_CONFIG_FILE);

}

/**
 * IsCheckingOut
 * Are we in the checkout process?
 *
 * @return Void
 */
function IsCheckingOut()
{
	if ((isset($_REQUEST['checking_out']) && $_REQUEST['checking_out'] == "yes") || (isset($_REQUEST['from']) && is_numeric(strpos($_REQUEST['from'], "checkout.php")))) {
		return true;
	}
	else {
		return false;
	}
}

/**
 * Chmod a file after setting the umask to 0 and then returning the umask after
 *
 * @param string $file The path to the file to chmod
 * @param string $mode The octal mode to chmod it to
 *
 * @return boolean Did it succeed ?
 */
function isc_chmod($file, $mode)
{
	if (DIRECTORY_SEPARATOR!=='/') {
		return true;
	}

	if (is_string($mode)) {
		$mode = octdec($mode);
	}

	$old_umask = umask();
	umask(0);
	$result = @chmod($file, $mode);
	umask($old_umask);
	return $result;
}

/**
 * Internal Interspire Shopping Cart replacement for the PHP date() function. Applies our timezone setting.
 *
 * @param string The format of the date to generate (See PHP date() reference)
 * @param int The Unix timestamp to generate the presentable date for.
 * @param float Optional timezone offset to use for this stamp. If null, uses system default.
 */
function isc_date($format, $timeStamp=null, $timeZoneOffset=null)
{
	if($timeStamp === null) {
		$timeStamp = time();
	}

	$dstCorrection = 0;
	if($timeZoneOffset === null) {
		$timeZoneOffset = GetConfig('StoreTimeZone');
		$dstCorrection = GetConfig('StoreDSTCorrection');
	}

	// If DST settings are enabled, add an additional hour to the timezone
	if($dstCorrection == 1) {
		++$timeZoneOffset;
	}

	return gmdate($format, $timeStamp + ($timeZoneOffset * 3600));
}

/**
 * Internal Interspire Shopping Cart replacement for the PHP mktime() fnction. Applies our timezone setting.
 *
 * @see mktime()
 * @return int Unix timestamp
 */
function isc_mktime()
{
	$args = func_get_args();
	$result = call_user_func_array("mktime", $args);
	if($result) {
		$timeZoneOffset = GetConfig('StoreTimeZone');
		$dstCorrection = GetConfig('StoreDSTCorrection');

		// If DST settings are enabled, add an additional hour to the timezone
		if($dstCorrection == 1) {
			++$timeZoneOffset;
		}
		$result +=  $timeZoneOffset * 3600;
	}
	return $result;
}


/**
 * Internal Interspire Shopping Cart replacement for the PHP gmmktime() fnction. Applies our timezone setting.
 *
 * @see gmmktime()
 * @return int Unix timestamp
 */
function isc_gmmktime()
{
	$args = func_get_args();
	$result = call_user_func_array("gmmktime", $args);
	if($result) {
		$timeZoneOffset = GetConfig('StoreTimeZone');
		$dstCorrection = GetConfig('StoreDSTCorrection');

		// If DST settings are enabled, add an additional hour to the timezone
		if($dstCorrection == 1) {
			++$timeZoneOffset;
		}
		$result -=  $timeZoneOffset * 3600;
	}
	return $result;
}


/**
 * Set a "flash" message to be shown on the next page a user visits.
 *
 * @param string The message to be shown to the user.
 * @param string The type of message to be shown (info, success, error)
 * @param string The url to redirect to to show the message
 */
function FlashMessage($message, $type, $url = '', $jsLocation=false)
{
	if(!isset($_SESSION['FLASH_MESSAGES'])) {
		$_SESSION['FLASH_MESSAGES'] = array();
	}

	$_SESSION['FLASH_MESSAGES'][] = array(
			"message" => $message,
			"type" => $type
	);

	if (!empty($url)) {
		if($jsLocation){
			?>
			<script>
				window.location.href = '<?php echo $url; ?>';
			</script>
			<?php	
		}else{
			header('Location: '.$url);
		}
		exit;
	}
}

/**
 * Retrieve a flash message (if we have one) and reset the value back to nothing.
 *
 * @return mixed Array about the flash message if there is one, false if not.
 */
function GetFlashMessages()
{
	if(!isset($_SESSION['FLASH_MESSAGES'])) {
		return array();
	}

	$messages = array();

	foreach($_SESSION['FLASH_MESSAGES'] as $message) {
		if(!defined('ISC_ADMIN_CP')) {
			if($message['type'] == MSG_ERROR) {
				$class = "ErrorMessage";
			}
			else if($message['type'] == MSG_SUCCESS) {
				$class = "SuccessMessage";
			}
			else {
				$class = "InfoMessage";
			}
		}
		else {
			if($message['type'] == MSG_ERROR) {
				$class = "MessageBoxError";
			}
			else if($message['type'] == MSG_SUCCESS) {
				$class = "MessageBoxSuccess";
			}
			else {
				$class = "MessageBoxInfo";
			}
		}
		$messages[] = array(
				"message" => $message['message'],
				"type" => $message['type'],
				"class" => $class
		);
	}
	unset($_SESSION['FLASH_MESSAGES']);
	return $messages;
}

/**
 * Retrieve pre-built message boxes for all of the current flash messages.
 *
 * @return string The built message boxes.
 */
function GetFlashMessageBoxes()
{
	$flashMessages = GetFlashMessages();
	$messageBoxes = '';
	if(is_array($flashMessages)) {
		foreach($flashMessages as $flashMessage) {
			$messageBoxes .= MessageBox($flashMessage['message'], $flashMessage['type']);
		}
	}
	return $messageBoxes;
}

/**
 * Fetch the IP address of the current visitor.
 *
 * @return string The IP address.
 */
function GetIP()
{
	/*zcs=>bug function
	static $ip;
	if($ip) {
		return $ip;
	}

	$ip = '';

	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		if(preg_match_all("#[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}#s", $_SERVER['HTTP_X_FORWARDED_FOR'], $addresses)) {
			foreach($addresses[0] as $key => $val) {
				if(!preg_match("#^(10|172\.16|192\.168)\.#", $val)) {
					$ip = $val;
					break;
				}
			}
		}
	}

	if(!isset($ip)) {
		if(isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		else if(isset($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
	}
	$ip = preg_replace("#([^.0-9 ]*)#", "", $ip);
	return $ip;
	*/
	$onlineip = '';
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$onlineip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$onlineip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$onlineip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}
	return $onlineip;
}

function ClearTmpLogoImages()
{
	$previewDir = ISC_BASE_PATH.'/cache/logos';
	if ($handle = @opendir($previewDir)) {
		/* This is the correct way to loop over the directory. */
		while (false !== ($file = readdir($handle))) {
			if(substr($file, 0, 4) == 'tmp_') {
				@unlink($previewDir . $file);
			}
		}
		@closedir($handle);
	}
}

/**
 * Returns a string with text that has been run through htmlspecialchars() with the appropriate options
 * for untrusted text to display
 *
 * @param string $text the string to escape
 *
 * @return string The escaped string
 */
function isc_html_escape($text)
{
	return htmlspecialchars($text, ENT_QUOTES, GetConfig('CharacterSet'));
}

/**
 * converts all special characters to HTML entities except double quotes as this is used in meta tags.
 */
function isc_html_escape_spl($text)
{
	return str_replace('"','&quot;',htmlspecialchars_decode($text, ENT_QUOTES));
}

/**
 * Behaves like the unix which command
 * It checks the path in order for which version of $binary to run
 *
 * @param string $binary The name of a binary
 *
 * @return string The full path to the binary or an empty string if it couldn't be found
 */
function Which($binary)
{
	// If the binary has the / or \ in it then skip it
	if (strpos($binary, DIRECTORY_SEPARATOR) !== false) {
		return '';
	}
	$path = null;

	if (ini_get('safe_mode') ) {
		// if safe mode is on the path is in the ini setting safe_mode_exec_dir
		$_SERVER['safe_mode_path'] = ini_get('safe_mode_exec_dir');
		$path = 'safe_mode_path';
	} else if (isset($_SERVER['PATH']) && $_SERVER['PATH'] != '') {
		// On unix the env var is PATH
		$path = 'PATH';
	} else if (isset($_SERVER['Path']) && $_SERVER['Path'] != '') {
		// On windows under IIS the env var is Path
		$path = 'Path';
	}

	// If we don't have a path to search we can't find the binary
	if ($path === null) {
		return '';
	}

	$dirs_to_check = preg_split('#'.preg_quote(PATH_SEPARATOR,'#').'#', $_SERVER[$path], -1, PREG_SPLIT_NO_EMPTY);

	$open_basedirs = preg_split('#'.preg_quote(PATH_SEPARATOR, '#').'#', ini_get('open_basedir'), -1, PREG_SPLIT_NO_EMPTY);


	foreach ($dirs_to_check as $dir) {
		if (substr($dir, -1) == DIRECTORY_SEPARATOR) {
			$dir = substr($dir, 0, -1);
		}
		$can_check = true;
		if (!empty($open_basedirs)) {
			$can_check = false;
			foreach ($open_basedirs as $restricted_dir) {
				if (trim($restricted_dir) === '') {
					continue;
				}
				if (strpos($dir, $restricted_dir) === 0) {
					$can_check = true;
				}
			}
		}

		if ($can_check && is_dir($dir) && (is_file($dir.DIRECTORY_SEPARATOR.$binary) || is_link($dir.DIRECTORY_SEPARATOR.$binary))) {
			return $dir.DIRECTORY_SEPARATOR.$binary;
		}
	}
	return '';
}

/**
 * Set the memory limit to handle image file
 *
 * Function will set the memory limit to handle image file if memory limit is insufficient
 *
 * @access public
 * @param string $imgFile The full file path of the image
 * @return void
 */
function setImageFileMemLimit($imgFile)
{
	if (!function_exists('memory_get_usage') || !function_exists('getimagesize') || !file_exists($imgFile) || !($attribs = getimagesize($imgFile))) {
		return;
	}

	$width = $attribs[0];
	$height = $attribs[1];

	// Check if we have enough available memory to create this image - if we don't, attempt to bump it up
	$memoryLimit = @ini_get('memory_limit');
	if($memoryLimit && $memoryLimit != -1) {
		if (!is_numeric($memoryLimit)) {
			$limit = preg_match('#^([0-9]+)\s?([kmg])b?$#i', trim(strtolower($memoryLimit)), $matches);
			$memoryLimit = 0;
			if(is_array($matches) && count($matches) >= 3 && $matches[1] && $matches[2]) {
				switch($matches[2]) {
					case "k":
						$memoryLimit = $matches[1] * 1024;
						break;
					case "m":
						$memoryLimit = $matches[1] * 1048576;
						break;
					case "g":
						$memoryLimit = $matches[1] * 1073741824;
				}
			}
		}
		$currentMemoryUsage = memory_get_usage();
		$freeMemory = $memoryLimit - $currentMemoryUsage;
		if(!isset($attribs['channels'])) {
			$attribs['channels'] = 1;
		}
		$thumbMemory = round(($width * $height * $attribs['bits'] * $attribs['channels'] / 8) * 5);
		$thumbMemory += 2097152;
		if($thumbMemory > $freeMemory) {
			@ini_set("memory_limit", $memoryLimit+$thumbMemory);
		}
	}
}

/**
 * Format the HTML returned from the WYSIWYG editor.
 *
 * @param string the HTML.
 * @return string The formatted version of the HTML.
 */
function FormatWYSIWYGHTML($HTML)
{

	if(GetConfig('UseWYSIWYG')) {
		return $HTML;
	}
	else {
		$HTML = nl2br($HTML);

		// Fix up new lines and block level elements.
		$HTML = preg_replace("#(</?(?:html|head|body|div|p|form|table|thead|tbody|tfoot|tr|td|th|ul|ol|li|div|p|blockquote|cite|hr)[^>]*>)\s*<br />#i", "$1", $HTML);
		$HTML = preg_replace("#(&nbsp;)+(</?(?:html|head|body|div|p|form|table|thead|tbody|tfoot|tr|td|th|ul|ol|li|div|p|blockquote|cite|hr)[^>]*>)#i", "$2", $HTML);
		return $HTML;
	}
}

/**
 * Generate a thumbnail version of a particular image.
 *
 * @param string The file system path of the image to create a thumbnail of.
 * @param string The file system path of the name/location to save the thumbnail.
 * @param int The maximum width of the image.
 * @param boolean If the image is small enough, copy it to destLocation, otherwise just return.
 */
function GenerateThumbnail($sourceLocation, $destLocation, $maxWidth, $maxHeight=null)
{
	if(is_null($maxHeight)) {
		$maxHeight = $maxWidth;
	}

	if ($sourceLocation == '' || !file_exists($sourceLocation)) {
		return false;
	}

	// Destination directory doesn't exist
	else if(!is_dir(dirname($destLocation)) || !is_writable(dirname($destLocation))) {
		return false;
	}

	// A list of thumbnails too
	$tmp = explode(".", $sourceLocation);
	$ext = isc_strtolower($tmp[count($tmp)-1]);

	$attribs = @getimagesize($sourceLocation);
	$srcWidth = $attribs[0];
	$srcHeight = $attribs[1];

	if(!is_array($attribs)) {
		return false;
	}

	// Check if we have enough available memory to create this image - if we don't, attempt to bump it up
	SetImageFileMemLimit($sourceLocation);

	if ($ext == "jpg") {
		$srcImg = @imagecreatefromjpeg($sourceLocation);
	}
	else if($ext == "gif") {
		$srcImg = @imagecreatefromgif($sourceLocation);
		if(!function_exists("imagegif")) {
			$gifHack = 1;
		}
	}
	else {
		$srcImg = @imagecreatefrompng($sourceLocation);
	}

	if(!$srcImg) {
		return false;
	}

	// This image dimensions. Simply copy and return
	if($srcWidth <= $maxWidth && $srcHeight <= $maxHeight) {
		@imagedestroy($srcImg);
		if($sourceLocation != $destLocation && copy($sourceLocation, $destLocation)) {
			return true;
		}
	}

	// Make sure the thumb has a constant height
	$width = $srcWidth;
	$thumbWidth = $srcWidth;
	$height = $srcHeight;
	$thumbHeight = $srcHeight;


	if($width > $maxWidth) {
		$thumbWidth = $maxWidth;
		$thumbHeight = ($maxWidth/$srcWidth)*$srcHeight;
	}
	else {
		$thumbHeight = $maxHeight;
		$thumbWidth = ($maxHeight/$srcHeight)*$srcWidth;
	}

	$thumbImage = @imagecreatetruecolor($thumbWidth, $thumbHeight);
	if($ext == "gif" && !isset($gifHack)) {
		$colorTransparent = @imagecolortransparent($srcImg);
		@imagepalettecopy($srcImg, $thumbImage);
		@imagecolortransparent($thumbImage, $colorTransparent);
		@imagetruecolortopalette($thumbImage, true, 256);
	}
	else if($ext == "png") {
		@ImageColorTransparent($thumbImage, @ImageColorAllocate($thumbImage, 0, 0, 0));
		@ImageAlphaBlending($thumbImage, false);
	}

	@imagecopyresampled($thumbImage, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);

	if ($ext == "jpg") {
		@imagejpeg($thumbImage, $destLocation, 100);
	}
	else if($ext == "gif") {
		if(isset($gifHack) && $gifHack == true) {
			$thumbFile = isc_substr($thumbFile, 0, -3)."jpg";
			@imagejpeg($thumbImage, $destLocation, 100);
		}
		else {
			@imagegif($thumbImage, $destLocation);
		}
	} else {
		@imagepng($thumbImage, $destLocation);
	}

	@imagedestroy($thumbImage);
	@imagedestroy($srcImg);

	// Change the permissions on the thumbnail file
	isc_chmod($destLocation, ISC_WRITEABLE_FILE_PERM);

	return true;
}

/**
 * Wrapper function for all the line endings sanitising SanatiseStringTo*() functions
 *
 * Function will convert all line endings in $str to the $ending, which must either be '\n' (UNIX), '\r\n' (Windows) or '\r' (Mac)
 *
 * @access public
 * @param string $str The string to sanatise
 * @param string $ending The optional line ending to use. Must either be '\n', '\r\n' or '\r'. Will default to '\n'
 * @return string The sanatised string
 */
function SanatiseString($str, $ending='\n')
{
	if ($ending == '\r\n') {
		return SanatiseStringToWindows($str);
	} else if ($ending == '\r') {
		return SanatiseStringToMac($str);
	} else {
		return SanatiseStringToUnix($str);
	}
}

/**
 * Sanatise all line endings to '\r\n' Windows format
 *
 * Function will convert all line ending Windows format '\r\n'
 *
 * @access public
 * @param string $str The string to convert all line endings to
 * @return string The converted string
 */
function SanatiseStringToWindows($str)
{
	return str_replace("\n", "\r\n", SanatiseStringToUnix($str));
}

/**
 * Sanatise all line endings to '\r' Mac format
 *
 * Function will convert all line ending Mac format '\r'
 *
 * @access public
 * @param string $str The string to convert all line endings to
 * @return string The converted string
 */
function SanatiseStringToMac($str)
{
	return str_replace("\n", "\r", SanatiseStringToUnix($str));
}

/**
 * Sanatise all line endings to '\n' *nix format
 *
 * Function will convert all line ending *nix format '\n'
 *
 * @access public
 * @param string $str The string to convert all line endings to
 * @return string The converted string
 */
function SanatiseStringToUnix($str)
{
	return str_replace("\r", "\n", str_replace("\r\n", "\n", $str));
}

/**
 * Check to see if value is overlapping
 *
 * Function will check to see if numeric value $needle is overlapping in the array of values $overlap array. The $overlap
 * array can either be an array of value or an array of 2 arrays, with each sub-array conatining values.
 *
 * EG: Array of values. $needle will be checked to see if it exists within that array (basically returning in_array())
 *
 *     $overlap = array(1, 5, 16, 22);
 *
 * EG: Array of 2 arrays. $needle will be checked to see if it exists between at element 0 of both arrays, then check
 *     element 1 of both arrays, etc. If one of the elements is missing then basically check to see if $needle equals
 *     the remaining element.
 *
 *     $overlap = array(
 *                      array(1, 6, '', 18, 24),
 *                      array(4, 11, 16, 22, ''),
 *                );
 *
 * @access public
 * @param int $needle The search needle
 * @param array $haystack The arry haystack to search in
 * @return mixed 1 if $needle does overlap, 0 if there is no overlapping, FALSE on error
 */
function CheckNumericOverlapping($needle, $haystack)
{
	if (!is_numeric($needle) || !is_array($haystack)) {
		return false;
	}

	// Make sure that if we are using sub arrays that we have 2 of them
	if (count($haystack) > 1 && (!is_array($haystack[0]) || !is_array($haystack[0]))) {
		return false;
	}

	// If we have no sub arrays then just use the in_array() function
	if (!is_array($haystack[0])) {
		return (int)in_array($needle, $haystack);
	}

	// Else we loop through the sub arrays to see if we are overlapping
	$fromRange = array();
	$toRange = array();
	$total = max(count($haystack[0]), count($haystack[1]));

	// This loop will filter our haystack
	for ($i=0; $i<$total; $i++) {

		// Filter out any blank ranges
		if ((!array_key_exists($i, $haystack[0]) || !isId($haystack[0][$i])) && (!array_key_exists($i, $haystack[1]) || !isId($haystack[1][$i]))) {
			continue;
		}

		// If the beginning of this range is empty then use the previous end range number plus 1
		if (!array_key_exists($i, $haystack[0]) || !isId($haystack[0][$i])) {
			if (!empty($toRange)) {
				$haystack[0][$i] = $toRange[count($toRange)-1]+1;
			} else {
				$haystack[0][$i] = 0;
			}
		}

		// If the end of our range is empty then use the next available beginning range minus 1
		if (!array_key_exists($i, $haystack[1]) || !isId($haystack[1][$i])) {
			for ($j=$i+1; $j<$total; $j++) {
				if (array_key_exists($j, $haystack[0]) && isId($haystack[0][$j])) {
					$haystack[1][$i] = $haystack[0][$j]-1;
					break;
				}
				if (array_key_exists($j, $haystack[1]) && isId($haystack[1][$j])) {
					$haystack[1][$i] = $haystack[1][$j]-1;
					break;
				}
			}

			// If we couldn't find any either invent the unlimited number or assign -1
			if (!array_key_exists($i, $haystack[1]) || !isId($haystack[1][$i])) {
				$haystack[1][$i] = -1;
			}
		}

		// Assign our range
		$fromRange[] = $haystack[0][$i];
		$toRange[] = $haystack[1][$i];
	}

	// Now we have filtered our haystack, lets see if the needle is in range
	for ($i=0; $i<$total; $i++) {
		if ($needle >= $fromRange[$i] && $needle <= $toRange[$i]) {
			return 1;
		}
	}

	return 0;
}

/**
 * Generate a random semi-readable password
 *
 * Function will generate a random yet 'sort of' readable password, using random 2 digit numbers, 2 character words with vowles at the end,
 * mixed in with the odd punctuation here and there
 *
 * @access public
 * @param int $charLength The optional password length. Default is GENERATED_PASSWORD_LENGTH
 * @return string The generated password
 */
function GenerateReadablePassword($charLength=GENERATED_PASSWORD_LENGTH)
{
	$letters = array('b','c','d','f','g','h','j','k','l','m','n','p','q','r','s','t','v','w','x','y','z');
	$vowles = array('a','e','i','o','u');
	$punctuation = array('!','@','#','$','%','&','?');
	$password = array();
	$length = ceil($charLength/2);

	for ($i=0; $i<$length; $i++) {

		// Add a 2 digit number
		if ($i%2) {
			$password[] = mt_rand(10, 99);

			// Else add a 2 letter word
		} else {

			$letterKey = array_rand($letters);

			// If its a 'q' then use a 'u', else get a random one
			if ($letters[$letterKey] == 'q') {
				$vowleKey = 4;
			} else {
				$vowleKey = array_rand($vowles);
			}

			$password[] = $letters[$letterKey] . $vowles[$vowleKey];

			// See if we can add a punctuation while we are here
			if ($i%3 === 0) {
				$key = array_rand($punctuation);
				$password[] = $punctuation[$key];
			}
		}
	}

	shuffle($password);

	$password = implode('', $password);
	$password = substr($password, 0, $charLength);
	return $password;
}

/**
 * Add the salt to a string
 *
 * Function will add the salt $salt to the string $str and return the MD5 value
 *
 * @access public
 * @param string $str The string to add the salt to
 * @param string $salt The salt to add
 * @return string The MD5 value of the salted string
 */
function CreateSaltedString($str, $salt)
{
	return md5($str . $salt);
}

/**
 * Create a salted customer hash string
 *
 * Function will create a salted hash string used for customers
 *
 * @access public
 * @param string $hash The unsalted hash string
 * @param int $customerId The customer ID
 * @return string The salted customer hash string on success, FALSE if $hash or $customerID is invalid/empty
 */
function CustomerHashCreate($hash, $customerId)
{
	if ($hash == '' || !isId($customerId)) {
		return false;
	}

	$salt = 'CustomerID:' . $customerId;
	return CreateSaltedString($hash, $salt);
}

/**
 * Check to see if customer salt string matches
 *
 * Function will check to see if the unsalted customer hash string $customerString and the customer id $customerID match against the salted
 * customer hash string $saltedString
 *
 * @access public
 * @param string $saltedString The salted customer hash string to compare to
 * @param string $customerString The unsalted customer hash string
 * @param int $customerId The customer ID
 * @return bool TRUE if the salted and unsalted strings match, FALSE if no match or if any of the arguments are invalid/empty
 */
function CustomerHashCheck($saltedString, $customerString, $customerId)
{
	if ($saltedString == '' || $customerString == '' || !isId($customerId)) {
		return false;
	}

	$customerString = CustomerHashCreate($customerString, $customerId);

	if ($customerString === $saltedString) {
		return true;
	}

	return false;
}

/**
 * Shopping Cart equivalent function for json_encode. This should be used instead of json_encode
 * as it does not handle anything in regards to character sets - it simply treats the strings as they're
 * passed, whilst json_encode only outputs in UTF-8.
 *
 * @param mixed The data to be JSON formatted.
 * @return string The JSON generated data.
 */
function isc_json_encode($a=false)
{
	if(is_null($a)) {
		return 'null';
	}
	else if($a === false) {
		return 'false';
	}
	else if($a === true) {
		return 'true';
	}
	else if(is_scalar($a)) {
		if(is_float($a)) {
			// Always use "." for floats.
			return floatval(str_replace(",", ".", strval($a)));
		}

		if(is_string($a)) {
			static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
			return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
		}
		else {
			return $a;
		}
	}
	$isList = true;
	for($i = 0, reset($a); $i < count($a); $i++, next($a)) {
		if(key($a) !== $i) {
			$isList = false;
			break;
		}
	}
	$result = array();
	if($isList) {
		foreach($a as $v) {
			$result[] = isc_json_encode($v);
		}
		return '[' . implode(',', $result) . ']';
	}
	else {
		foreach($a as $k => $v) {
			$result[] = isc_json_encode($k).':'.isc_json_encode($v);
		}
		return '{' . implode(',', $result) . '}';
	}
}

/**
 * Delete configurable product files in the temporary folder that are older than 3 days.
 *
 **/
function DeleteOldConfigProductFiles()
{
	$fileTmpPath = ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/configured_products_tmp/';

	if ($handle = opendir($fileTmpPath)) {
		while (false !== ($filename = readdir($handle))) {
			if ($filename != '.' && $filename != '..' && filemtime($fileTmpPath.$filename) < strtotime("-3 days")) {
				@unlink($fileTmpPath.$filename);
			}
		}
		closedir($handle);
	}
	return true;
}

if ( !function_exists('sys_get_temp_dir')) {
	function sys_get_temp_dir()
	{
		if (!empty($_ENV['TMP'])) {
			return realpath($_ENV['TMP']);
		}
		if (!empty($_ENV['TMPDIR'])) {
			return realpath($_ENV['TMPDIR']);
		}
		if (!empty($_ENV['TEMP'])) {
			return realpath($_ENV['TEMP']);
		}
		$tempfile=tempnam(uniqid(rand(),true),'');
		if (file_exists($tempfile)) {
			unlink($tempfile);
			return realpath(dirname($tempfile));
		}
	}
}

/**
 * Apply a numeric suffix to a number (eg: 1 => 1st, 2 => 2nd, etc)
 *
 * Function will apply the numeric suffix to the integer $int
 *
 * @access public
 * @param int $int The numerical value to apped the suffix to
 * @return string The integer value with the appended suffix on success, unchanged value on failure
 */
function addNumericalSuffix($int)
{
	if (!is_numeric($int)) {
		return $int;
	}

	if (substr((string)$int, -1) == '1' && substr((string)$int, -2) !== '11') {
		$ext = GetLang('DateDaySt');
	} else if (substr((string)$int, -1) == '2' && substr((string)$int, -2) !== '12') {
		$ext = GetLang('DateDayNd');
	} else if (substr((string)$int, -1) == '3' && substr((string)$int, -2) !== '13') {
		$ext = GetLang('DateDayRd');
	} else {
		$ext = GetLang('DateDayTh');
	}

	return $int . $ext;
}
/**
 * Calculates the cartesian product of arrays
 *
 * <code>
 * $array["color"] = array("red", "green", "blue")
 * $array["size"] = array("S", "L");
 * $cartesian = array_cartesian_product($array, true);
 *
 * //result: {"color" => red, "size" => S}, {red, L}, {green, S}, {green, L}, {blue, S}, {blue, L}
 * </code>
 *
 * @param array The array of sets
 * @param bool Maintain index association of the input sets
 * @return array Cartesian product array
 */
function array_cartesian_product($sets, $maintain_index = false)
{
	$cartesian = array();

	// calculate size of the cartesian product (the amount of elements in each array multiplied by each other)
	$size = 1;
	foreach ($sets as $set) {
		$size *= count($set);
	}

	$scale_factor = $size;

	foreach ($sets as $key => $set) {
		// number of elements in this set
		$set_elements = count($set);

		$scale_factor /= $set_elements;

		// add the elements from each set into their correct position into the result
		for ($i = 0; $i < $size; $i++) {
			$pos = $i / $scale_factor % $set_elements;

			if ($maintain_index) {
				$cartesian[$i][$key] = $set[$pos];
			}
			else {
				array_push($cartesian[$i], $set[$pos]);
			}
		}
	}

	return $cartesian;
}

/**
 * Convert all request inputs from $from character set to $to character set
 *
 * Function will convert all $_GET, $_POST and $_REQUEST data from the character set
 * in $from to the character set in $to
 *
 * @access public
 * @param string $from The character set to convert from
 * @param string $to The character set to convert to
 * @param bool $toRequest TRUE to also do $_REQUEST, FALSE to skip it. Default is TRUE
 * @return null
 */
function convertRequestInput($from='UTF-8', $to='', $doRequest=true)
{
	if ($to == '') {
		$to = GetConfig('CharacterSet');
	}

	if ($from == '' || $to == '' || $from === $to) {
		return;
	}

	$_GET = isc_convert_charset($from, $to, $_GET);
	$_POST = isc_convert_charset($from, $to, $_POST);

	if ($doRequest) {
		$_REQUEST = isc_convert_charset($from, $to, $_REQUEST);
	}
}


/**
 * Case insensitive in_array
 *
 * @param mixed $needle
 * @param mixed $haystack
 * @return bool
 */
function in_arrayi($needle, $haystack)
{
	return in_array(isc_strtolower($needle), array_map('isc_strtolower', $haystack));
}

/**
 * Case insensitive array_search
 *
 * @param mixed $needle
 * @param mixed $haystack
 * @return mixed Key on success, FALSE on no match
 */
function array_isearch($needle, $haystack)
{
	return array_search(isc_strtolower($needle), array_map('isc_strtolower', $haystack));
}


/**
 * Calculate and return a friendly displayable date such as "less than a minute ago"
 * "x minutes ago", "Today at 6:00 PM" etc.
 *
 * @param string The UNIX timestamp to format.
 * @param boolean True to include the time details, false if not.
 * @return string The formatted date.
 */
function NiceDate($timestamp, $includeTime=false)
{
	$now = time();
	$difference = $now - $timestamp;
	$time = isc_date('h:i A', $timestamp);

	$timeDate = isc_date('Ymd', $timestamp);
	$todaysDate = isc_date('Ymd', $now);
	$yesterdaysDate = isc_date('Ymd', $now-86400);

	if($difference < 60) {
		return GetLang('LessThanAMinuteAgo');
	}
	else if($difference < 3600) {
		$minutes = ceil($difference/60);
		if($minutes == 1) {
			return GetLang('OneMinuteAgo');
		}
		else {
			return sprintf(GetLang('XMinutesAgo'), $minutes);
		}
	}
	else if($difference < 43200) {
		$hours = ceil($difference/3600);
		if($hours == 1) {
			return GetLang('OneHourAgo');
		}
		else {
			return sprintf(GetLang('XHoursAgo'), $hours);
		}
	}
	else if($timeDate == $todaysDate) {
		if($includeTime == true) {
			return sprintf(GetLang('TodayAt'), $time);
		}
		else {
			return GetLang('Today');
		}
	}
	else if($timeDate == $yesterdaysDate) {
		if($includeTime == true) {
			return sprintf(GetLang('YesterdayAt'), $time);
		}
		else {
			return GetLang('Yesterday');
		}
	}
	else {
		$date = CDate($timestamp);
		if($includeTime == true) {
			return sprintf(GetLang('OnDateAtTime'), $date, $time);
		}
		else {
			return sprintf(GetLang('OnDate'), $date);
		}
	}
}

/**
 * This function is used to provide back to search link when clicked from search page.
 *
 * This is used to return to the search page when they are navigating in other pages.
 *
 *
 * This is assigned to a global variable which will print in templates
 */
function CheckReferrer() {
	if(isset($_COOKIE['back2search']))
	$GLOBALS['Back2Search'] = "<p> < <a href='".$GLOBALS['ShopPathNormal']."/".$_COOKIE['back2search']."'>Back to search results</a></p>";
}

/**
 * This function is used to get qualifier columns.
 *
 * This is used to return to the buildsearchterms function above
 *
 */
function GetQualifierColumns($qualifier_query, &$qualifier_columns, &$VCols, &$PCols)  {
	$VCols = array();
	$PCols = array();
	$qualifier_result = $GLOBALS['ISC_CLASS_DB']->Query($qualifier_query);
	while($qualifier_row = $GLOBALS['ISC_CLASS_DB']->Fetch($qualifier_result)) {
		if(eregi('^(vq)', $qualifier_row['column_name'])) {
			$qualifier_columns[] = $qualifier_row['column_name'];
			$VCols[] = $qualifier_row['column_name'];
			$GLOBALS['visible_pqvq'][$qualifier_row['column_name']] = $qualifier_row['qualifier_visible'];
		} else if(eregi('^(pq)', $qualifier_row['column_name'])) {
			$qualifier_columns[] = $qualifier_row['column_name'];
			$PCols[] = $qualifier_row['column_name'];
			$GLOBALS['visible_pqvq'][$qualifier_row['column_name']] = $qualifier_row['qualifier_visible'];
		}
	}

	if(in_array('VQbedsize',$GLOBALS['v_cols'])) {
		$k = array_search('VQbedsize',$GLOBALS['v_cols']);
		//2010-11-15 Ronnie modify
		//$VCols[$k] = "if( v.bedsize_generalname != '', v.bedsize_generalname, v.VQbedsize ) as VQbedsize";
		$VCols[$k] = "v.VQbedsize  as VQcabsize";
	}

	if(in_array('VQcabsize',$GLOBALS['v_cols'])) {
		$k = array_search('VQcabsize',$GLOBALS['v_cols']);
		//$VCols[$k] = "if( v.cabsize_generalname != '', v.cabsize_generalname, v.VQcabsize ) as VQcabsize";
		$VCols[$k] = "v.VQcabsize  as VQcabsize";
	}
}

/*update search log for best performance key word
 */
function UpdateSearchLogforBestKeyWord($logId)
{
	$sqlstr = "select * from [|PREFIX|]searches_extended where searchid = '".$logId."' ";

	$result = $GLOBALS['ISC_CLASS_DB']->Query($sqlstr);

	$count = @$GLOBALS['ISC_CLASS_DB']->CountResult($result);

	if( $count < 1 )
	return;
		
	$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

	// Log the seach to our actual search cache table
	$SearchCache = array(
				"searchtext" => isc_strtolower($row["searchtext"]),
				"numresults" => $row["numresults"],
				"searchdate" => time(),
				"prodyear"=> $row['prodyear'],
				"prodmaker"=> $row['prodmaker'],
				"prodmodel"=>$row['prodmodel'],
				"clickthru" => 1,
				"searchurl"=> $_SERVER["REQUEST_URI"]
	);
	$searchid = $GLOBALS['ISC_CLASS_DB']->InsertQuery("searches_extended", $SearchCache);
}

/**
 * Wirror20100824: file_list
 * List all files under the special dir
 *
 */
function file_list($dir,$pattern="")
{
	$arr=array();
	$dir_handle=opendir($dir);
	if($dir_handle)
	{
		while(($file=readdir($dir_handle))!==false)
		{
			if($file==='.' || $file==='..')
			{
				continue;
			}
			$tmp=realpath($dir.'/'.$file);
			if(is_dir($tmp))
			{
				$retArr=file_list($tmp,$pattern);
				if(!empty($retArr))
				{
					$arr[]=$retArr;
				}
			}
			else
			{
				if($pattern==="" || preg_match($pattern,$tmp))
				{
					$arr[]=$tmp;
				}
			}
		}
		closedir($dir_handle);
	}

	return $arr;
}

/**
 * Wirror20100824: multiexplode
 * enhancement function of explode
 *
 */
function multiexplode ($delimiters,$string) {
	$ary = explode($delimiters[0],$string);
	array_shift($delimiters);
	if($delimiters != NULL) {
		foreach($ary as $key => $val) {
			$ary[$key] = multiexplode($delimiters, $val);
		}
	}
	return  $ary;
}


/**
 * Converts PHP variable or array into a "JSON" (JavaScript value expression
 * or "object notation") string.
 *
 * @compat
 *    Output seems identical to PECL versions. "Only" 20x slower than PECL version.
 * @bugs
 *    Doesn't take care with unicode too much - leaves UTF-8 sequences alone.
 *
 * @param  $var mixed  PHP variable/array/object
 * @return string      transformed into JSON equivalent
 */
if (!function_exists("json_encode")) {
	function json_encode($var, /*emu_args*/$obj=FALSE) {
			
		#-- prepare JSON string
		$json = "";

		#-- add array entries
		if (is_array($var) || ($obj=is_object($var))) {

			#-- check if array is associative
			if (!$obj) foreach ((array)$var as $i=>$v) {
				if (!is_int($i)) {
					$obj = 1;
					break;
				}
			}

			#-- concat invidual entries
			foreach ((array)$var as $i=>$v) {
				$json .= ($json ? "," : "")    // comma separators
				. ($obj ? ("\"$i\":") : "")   // assoc prefix
				. (json_encode($v));    // value
			}

			#-- enclose into braces or brackets
			$json = $obj ? "{".$json."}" : "[".$json."]";
		}

		#-- strings need some care
		elseif (is_string($var)) {
			if (!utf8_decode($var)) {
				$var = utf8_encode($var);
			}
			$var = str_replace(array("\\", "\"", "/", "\b", "\f", "\n", "\r", "\t"), array("\\\\", '\"', "\\/", "\\b", "\\f", "\\n", "\\r", "\\t"), $var);
			$json = '"' . $var . '"';
			//@COMPAT: for fully-fully-compliance   $var = preg_replace("/[\000-\037]/", "", $var);
		}

		#-- basic types
		elseif (is_bool($var)) {
			$json = $var ? "true" : "false";
		}
		elseif ($var === NULL) {
			$json = "null";
		}
		elseif (is_int($var) || is_float($var)) {
			$json = "$var";
		}

		#-- something went wrong
		else {
			trigger_error("json_encode: don't know what a '" .gettype($var). "' is.", E_USER_ERROR);
		}

		#-- done
		return($json);
	}
}



/**
 * Parses a JSON (JavaScript value expression) string into a PHP variable
 * (array or object).
 *
 * @compat
 *    Behaves similar to PECL version, but is less quiet on errors.
 *    Now even decodes unicode \uXXXX string escapes into UTF-8.
 *    "Only" 27 times slower than native function.
 * @bugs
 *    Might parse some misformed representations, when other implementations
 *    would scream error or explode.
 * @code
 *    This is state machine spaghetti code. Needs the extranous parameters to
 *    process subarrays, etc. When it recursively calls itself, $n is the
 *    current position, and $waitfor a string with possible end-tokens.
 *
 * @param   $json string   JSON encoded values
 * @param   $assoc bool    pack data into php array/hashes instead of objects
 * @return  mixed          parsed into PHP variable/array/object
 */
if (!function_exists("json_decode")) {
	function json_decode($json, $assoc=FALSE, $limit=512, /*emu_args*/$n=0,$state=0,$waitfor=0) {

		#-- result var
		$val = NULL;
		static $lang_eq = array("true" => TRUE, "false" => FALSE, "null" => NULL);
		static $str_eq = array("n"=>"\012", "r"=>"\015", "\\"=>"\\", '"'=>'"', "f"=>"\f", "b"=>"\b", "t"=>"\t", "/"=>"/");
		if ($limit<0) return /* __cannot_compensate */;

		#-- flat char-wise parsing
		for (/*n*/; $n<strlen($json); /*n*/) {
			$c = $json[$n];

			#-= in-string
			if ($state==='"') {

				if ($c == '\\') {
					$c = $json[++$n];
					// simple C escapes
					if (isset($str_eq[$c])) {
						$val .= $str_eq[$c];
					}

					// here we transform \uXXXX Unicode (always 4 nibbles) references to UTF-8
					elseif ($c == "u") {
						// read just 16bit (therefore value can't be negative)
						$hex = hexdec( substr($json, $n+1, 4) );
						$n += 4;
						// Unicode ranges
						if ($hex < 0x80) {    // plain ASCII character
							$val .= chr($hex);
						}
						elseif ($hex < 0x800) {   // 110xxxxx 10xxxxxx
							$val .= chr(0xC0 + $hex>>6) . chr(0x80 + $hex&63);
						}
						elseif ($hex <= 0xFFFF) { // 1110xxxx 10xxxxxx 10xxxxxx
							$val .= chr(0xE0 + $hex>>12) . chr(0x80 + ($hex>>6)&63) . chr(0x80 + $hex&63);
						}
						// other ranges, like 0x1FFFFF=0xF0, 0x3FFFFFF=0xF8 and 0x7FFFFFFF=0xFC do not apply
					}

					// no escape, just a redundant backslash
					//@COMPAT: we could throw an exception here
					else {
						$val .= "\\" . $c;
					}
				}

				// end of string
				elseif ($c == '"') {
					$state = 0;
				}

				// yeeha! a single character found!!!!1!
				else/*if (ord($c) >= 32)*/ { //@COMPAT: specialchars check - but native json doesn't do it?
					$val .= $c;
				}
			}

			#-> end of sub-call (array/object)
			elseif ($waitfor && (strpos($waitfor, $c) !== false)) {
				return array($val, $n);  // return current value and state
			}

			#-= in-array
			elseif ($state===']') {
				list($v, $n) = json_decode($json, $assoc, $limit, $n, 0, ",]");
				$val[] = $v;
				if ($json[$n] == "]") { return array($val, $n); }
			}

			#-= in-object
			elseif ($state==='}') {
				list($i, $n) = json_decode($json, $assoc, $limit, $n, 0, ":");   // this allowed non-string indicies
				list($v, $n) = json_decode($json, $assoc, $limit, $n+1, 0, ",}");
				$val[$i] = $v;
				if ($json[$n] == "}") { return array($val, $n); }
			}

			#-- looking for next item (0)
			else {
					
				#-> whitespace
				if (preg_match("/\s/", $c)) {
					// skip
				}

				#-> string begin
				elseif ($c == '"') {
					$state = '"';
				}

				#-> object
				elseif ($c == "{") {
					list($val, $n) = json_decode($json, $assoc, $limit-1, $n+1, '}', "}");

					if ($val && $n) {
						$val = $assoc ? (array)$val : (object)$val;
					}
				}

				#-> array
				elseif ($c == "[") {
					list($val, $n) = json_decode($json, $assoc, $limit-1, $n+1, ']', "]");
				}

				#-> comment
				elseif (($c == "/") && ($json[$n+1]=="*")) {
					// just find end, skip over
					($n = strpos($json, "*/", $n+1)) or ($n = strlen($json));
				}

				#-> numbers
				elseif (preg_match("#^(-?\d+(?:\.\d+)?)(?:[eE]([-+]?\d+))?#", substr($json, $n), $uu)) {
					$val = $uu[1];
					$n += strlen($uu[0]) - 1;
					if (strpos($val, ".")) {  // float
						$val = (float)$val;
					}
					elseif ($val[0] == "0") {  // oct
						$val = octdec($val);
					}
					else {
						$val = (int)$val;
					}
					// exponent?
					if (isset($uu[2])) {
						$val *= pow(10, (int)$uu[2]);
					}
				}

				#-> boolean or null
				elseif (preg_match("#^(true|false|null)\b#", substr($json, $n), $uu)) {
					$val = $lang_eq[$uu[1]];
					$n += strlen($uu[1]) - 1;
				}

				#-- parsing error
				else {
					// PHPs native json_decode() breaks here usually and QUIETLY
					trigger_error("json_decode: error parsing '$c' at position $n", E_USER_WARNING);
					return $waitfor ? array(NULL, 1<<30) : NULL;
				}

			}//state

			#-- next char
			if ($n === NULL) { return NULL; }
			$n++;
		}//for

		#-- final result
		return ($val);
	}
}

function GetCustomerServiceTime(){
    $definedTimes = array();
    $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]customer_services ORDER BY id asc");
    while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($query)){
        if($row['daytype'] == 'holiday')
        $definedTimes[$row['daytype']][] = $row;
        else
        $definedTimes[$row['daytype']] = $row;
    }

    return $definedTimes;
}


function IsCustomerServiceTime(){
    $customerServiceTime = GetCustomerServiceTime();

    //GMT to EST
    $timezoneAdjustment = GetConfig('StoreTimeZone');
    if(GetConfig('StoreDSTCorrection')) {
        ++$timezoneAdjustment;
    }
    $timezoneAdjustment *= 3600;
    $currentTime = time() + $timezoneAdjustment;

    $now = array(
                    'week' => date('w', $currentTime),
                    'hour' => date('G', $currentTime),
                    'min' => date('i', $currentTime)
    );
    $nowtime = $now['hour']*60 + $now['min'];
    $nowdate = ConvertDateToTime(date('m/d/Y', $currentTime));

    if($now['week'] > 0 && $now['week'] < 6){
        if($nowtime > $customerServiceTime['weekday']['from'] && $nowtime < $customerServiceTime['weekday']['to']){
            return true;
        }
    }

    if($now['week'] == 6){
        if($nowtime > $customerServiceTime['saturday']['from'] && $nowtime < $customerServiceTime['saturday']['to']){
            return true;
        }
    }

    if($now['week'] == 0){
        if($nowtime > $customerServiceTime['sunday']['from'] && $nowtime < $customerServiceTime['sunday']['to']){
            return true;
        }
    }

}

?>
