<?php

/**
 * Interspire Shopping Cart X-Cart Exporter.
 */
class ISC_ADMIN_EXPORTER_XCART extends ISC_ADMIN_EXPORTER
{
	/**
	 * @var string The title of this exporter.
	 */
	var $title = "X-Cart 4.1";

	/**
	 * @var string The language string used for the title of the export modules page.
	 */
	var $wizardTitle = 'XCartExportTitle';

	/**
	 * @var array A list of modules that this exporter contains. These should be in the order that they're required to run.
	 */
	var $_modules = array(
		"ExportCategories",
		"ExportBrands",
		"ExportProducts",
		"ExportCustomers",
		"ExportOrders",
		"ExportReviews",
		"ExportWishlists"
	);

	/**
	 * Validate and save the exporter configuration.
	 *
	 * @param string Any error message encountered (passed back by reference)
	 * @return mixed False on failure, if successful, array of configuration information to save.
	 */
	function SaveConfiguration(&$err)
	{
		if(!isset($_POST['xcart_path'])) {
			$err = GetLang('NoXCartPath');
			return false;
		}

		if(isc_strpos($_POST['xcart_path'], 'http://') === 0 || isc_strpos($_POST['xcart_path'], 'https://') === 0) {
			$path = $this->URLToPath($_POST['xcart_path'], $err);
			if(!$path) {
				return false;
			}
		}
		else {
			$path = realpath(APP_ROOT."/../".$_POST['xcart_path']);
			$path = preg_replace("#[^a-z0-9\./\\:]#i", "", $path);
		}

		if(!is_dir($path) || !file_exists($path."/config.php")) {
			$err = sprintf(GetLang('InvalidXCartPath'), isc_html_escape($_POST['xcart_path']), isc_html_escape($_POST['xcart_path']));
			return false;
		}
		else {
			// Grab the default X-Cart language
			if(!defined("XCART_START")) {
				define("XCART_START", 1);
			}
			$xcart_dir = $path;
			require $path."/config.php";
			$GLOBALS['XCART_DB'] = &new MySQLDB();
			$connection = $GLOBALS['XCART_DB']->Connect($sql_host, $sql_user, $sql_password, $sql_db);

			// Modify the structure of the X-Cart customers table so we can store users' email addresses in it
			$GLOBALS['XCART_DB']->Query("ALTER TABLE xcart_customers CHANGE login login varchar(200) NOT NULL default ''");

			return array(
				"path" => $path,
				"blowfish_key" => $blowfish_key
			);
		}
	}

	/**
	 * Fetch the configuration form for this exporter.
	 *
	 * @return string The HTML configuration page for this exporter.
	 */
	function Configure()
	{
		$GLOBALS['Path'] = 'http://';
		if(isset($_POST['xcart_path']) && $_POST['xcart_path'] != '') {
			$GLOBALS['Path'] = isc_html_escape($_POST['xcart_path']);
		}
		$GLOBALS['HelpTitle'] = str_replace("'", "\\'", GetLang('XCartLocation'));
		return $this->ParseTemplate("xcart.export.configure", true);
	}

	/**
	 * Connec to the X-Cart database.
	 */
	function Connect()
	{
		if(!defined("XCART_START")) {
			define("XCART_START", 1);
		}
		$xcart_dir = $this->_exportSession['Configuration']['path'];
		@include($this->_exportSession['Configuration']['path']."/config.php");
		$GLOBALS['XCART_DB'] = &new MySQLDB();
		$connection = $GLOBALS['XCART_DB']->Connect($sql_host, $sql_user, $sql_password, $sql_db);
		if($this->_Debug == true) {
			$GLOBALS['XCART_DB']->QueryLog = dirname(__FILE__)."/../logs/export-xct.queries.txt";
			$GLOBALS['XCART_DB']->TimeLog = dirname(__FILE__)."/../logs/export-xct.query_time.txt";
			$GLOBALS['XCART_DB']->ErrorLog = dirname(__FILE__)."/../logs/export-xct.db_errors.txt";
		}
	}

	/**
	 * Show the X-Cart Warning Page
	 */
	function ExportWarning()
	{
		echo $this->ParseTemplate("xcart.export.warning");
	}

	/**
	 * This function will go in and clear everything from the OsCommerce store for tables we'll be exporting into.
	 */
	function ClearStore()
	{
		$queries[] = "TRUNCATE xcart_categories";
		$queries[] = "TRUNCATE xcart_manufacturers";
		$queries[] = "DELETE FROM xcart_customers WHERE usertype='C'";
		$queries[] = "TRUNCATE xcart_newslist_subscription";
		$queries[] = "TRUNCATE xcart_product_reviews";
		$queries[] = "TRUNCATE xcart_products";
		$queries[] = "TRUNCATE xcart_products_categories";
		$queries[] = "TRUNCATE xcart_images_T";
		$queries[] = "TRUNCATE xcart_images_P";
		$queries[] = "TRUNCATE xcart_images_D";
		$queries[] = "TRUNCATE xcart_classes";
		$queries[] = "TRUNCATE xcart_class_options";
		$queries[] = "TRUNCATE xcart_product_links";
		$queries[] = "TRUNCATE xcart_orders";
		$queries[] = "TRUNCATE xcart_order_details";
		$queries[] = "TRUNCATE xcart_wishlist";
		$queries[] = "TRUNCATE xcart_category_memberships";
		$queries[] = "TRUNCATE xcart_pricing";
		$queries[] = "TRUNCATE xcart_product_memberships";
		$queries[] = "TRUNCATE xcart_quick_prices";
		$queries[] = "TRUNCATE xcart_products_lng";
		$queries[] = "TRUNCATE xcart_variants";
		$queries[] = "TRUNCATE xcart_product_taxes";
		$queries[] = "TRUNCATE xcart_variant_items";
		$queries[] = "TRUNCATE xcart_order_extras";
		$queries[] = "TRUNCATE xcart_categories_lng";
		$queries[] = "TRUNCATE xcart_class_lng";
		$queries[] = "TRUNCATE xcart_featured_products";
		$queries[] = "TRUNCATE xcart_manufacturers_lng";
		$queries[] = "TRUNCATE xcart_product_bookmarks";
		$queries[] = "TRUNCATE xcart_product_links";
		$queries[] = "TRUNCATE xcart_product_options_ex";
		$queries[] = "TRUNCATE xcart_product_options_js";
		$queries[] = "TRUNCATE xcart_product_options_lng";
		$queries[] = "TRUNCATE xcart_product_votes";
		$queries[] = "TRUNCATE xcart_quick_flags";

		$total_queries = count($queries);
		$queries_run = 0;
		foreach ($queries as $query) {
			$GLOBALS['XCART_DB']->Query($query);
			++$queries_run;
			$this->UpdateProgress(GetLang('ExporterDeletingStore'), $queries_run, $total_queries);
		}
	}


	function InsertCategory($categoryid, $categoryData)
	{
		if(!isset($categoryData['catname']) || $categoryData['catname'] == '') {
			$err = sprintf(GetLang('ExportCategoryErrorInvalid'), $categoryId);
			$this->_LogExportError('invalid', $err);
			return false;
		}

		$category = array(
			"categoryid" => $categoryid,
			"parentid" => $categoryData['catparentid'],
			"categoryid_path" => "", // TODO - CLEANUP FUNCTION
			"category" => $GLOBALS['XCART_DB']->Quote($categoryData['catname']),
			"description" => "",
			"meta_descr" => "",
			"avail" => "Y",
			"views_stats" => $categoryData['catviews'],
			"order_by" => $categoryData['catsort']
		);

		$this->DbInsertArray("xcart_categories", $category);
	}

	function ExportProductsCleanup()
	{
		$query = "TRUNCATE xcart_categories_subcount";
		$GLOBALS['XCART_DB']->Query($query);

		$query = "SELECT c.categoryid, COUNT(p.productid) AS numproducts, COUNT(s.categoryid) AS numsubcats FROM xcart_categories c LEFT JOIN xcart_products_categories p ON (p.productid=c.categoryid) LEFT JOIN xcart_categories s ON (s.parentid=c.categoryid) GROUP BY c.categoryid";
		$result = $GLOBALS['XCART_DB']->Query($query);
		while($row = $GLOBALS['XCART_DB']->Fetch($result)) {
			$query2 = sprintf("UPDATE xcart_categories SET categoryid_path='%s' WHERE categoryid='%d'", $this->BuildParentList($row['categoryid']), $row['categoryid']);
			$GLOBALS['XCART_DB']->Query($query2);
			$query2 = sprintf("INSERT INTO xcart_categories_subcount (categoryid, subcategory_count, product_count) VALUES ('%s', '%s', '%s')", $row['categoryid'], $row['numsubcats'], $row['numproducts']);
			$GLOBALS['XCART_DB']->Query($query2);
		}
	}

	function BuildParentList($CategoryId)
	{
		static $CategoryCache;

		if(!$CategoryCache) {
			$query = "SELECT categoryid, parentid FROM xcart_categories";
			$result = $GLOBALS['XCART_DB']->Query($query);
			while($row = $GLOBALS['XCART_DB']->Fetch($result)) {
				$CategoryCache[$row['categoryid']] = $row['parentid'];
			}
		}
		$ParentList = '';
		if(isset($CategoryCache[$CategoryId])) {
			if(isset($CategoryCache[$CategoryCache[$CategoryId]]) && $CategoryCache[$CategoryCache[$CategoryId]] != 0) {
				$ParentList = $this->BuildParentList($CategoryCache[$CategoryCache[$CategoryId]]);
			}
			if($ParentList) {
				$ParentList .= "/";
			}
			if($CategoryCache[$CategoryId] != 0) {
				$ParentList .= $CategoryCache[$CategoryId];
			}
		}
		if($ParentList) {
			$ParentList .= "/";
		}
		$ParentList .= $CategoryId;
		return $ParentList;
	}

	function InsertBrand($brandid, $brandData)
	{
		if(!isset($brandData['brandname']) || $brandData['brandname'] == '') {
			$err = sprintf(GetLang('ExportBrandErrorInvalid'), $brandId);
			$this->_LogExportError('invalid', $err);
			return false;
		}

		$brand = array(
			"manufacturerid" => $brandid,
			"manufacturer" => $GLOBALS['XCART_DB']->Quote($brandData['brandname'])
		);
		$this->DbInsertArray("xcart_manufacturers", $brand);
	}

	function InsertReview($reviewid, $reviewData)
	{
		if(!isset($reviewData['revproductid'])) {
			$err = sprintf(GetLang('ExportReviewErrorInvalid'), $reviewId);
			$this->_LogExportError('invalid', $err);
			return false;
		}

		if(!isset($reviewData['revfromname'])) {
			$err = sprintf(GetLang('ExportReviewErrorInvalidName'), $reviewId);
			$this->_LogExportError('invalid', $err);
			return false;
		}

		$review = array(
			"review_id" => $reviewid,
			"productid" => $reviewData['revproductid'],
			"email" => $GLOBALS['XCART_DB']->Quote($reviewData['revfromname']),
			"message" => $GLOBALS['XCART_DB']->Quote($reviewData['revtext'])
		);

		$this->DbInsertArray("xcart_product_reviews", $review);
	}

	function InsertProduct($productid, $productData)
	{
		if(!isset($productData['prodname']) || $productData['prodname'] == '') {
			$err = sprintf(GetLang('ExportProductErrorInvalid'), $productId);
			$this->_LogExportError('invalid', $err);
			return false;
		}

		if(!isset($productData['prodprice'])) {
			$err = sprintf(GetLang('ExportProductErrorInvalidPrice'), $productData['prodname']);
			$this->_LogExportError('invalid', $err);
			return false;
		}

		if($productData['prodfreeshipping'] == 1) {
			$freeShipping = "Y";
		}
		else {
			$freeShipping = "N";
		}

		$product = array(
			"productid" => $productid,
			"productcode" => $GLOBALS['XCART_DB']->Quote($productData['prodcode']),
			"product" => $GLOBALS['XCART_DB']->Quote($productData['prodname']),
			"provider" => "",
			"distribution" => "",
			"weight" => (float)$productData['prodweight'],
			"list_price" => (float)$productData['prodprice'],
			"descr" => $GLOBALS['XCART_DB']->Quote($productData['proddesc']),
			"fulldescr" => "",
			"avail" => (int)$productData['prodcurrentinv'],
			"rating" => 0,
			"forsale" => "Y",
			"add_date" => (int)$productData['proddateadded'],
			"views_stats" => 1,
			"provider" => "provider",
			"sales_stats" => (int)$productData['prodnumsold'],
			"del_stats" => 0,
			"shipping_freight" => (int)$productData['prodfixedshippingcost'],
			"free_shipping" => $freeShipping,
			"discount_avail" => "Y",
			"min_amount" => 1,
			"dim_x" => (float)$productData['prodwidth'],
			"dim_y" => (float)$productData['prodheight'],
			"dim_z" => (float)$productData['proddepth'],
			"low_avail_limit" => (int)$productData['prodlowinv'],
			"product_type" => "N",
			"manufacturerid" => (int)$productData['prodbrandid'],
			"keywords" => ""
		);
		$this->DbInsertArray("xcart_products", $product);

		// Insert the pricing
		$pricing = array(
			"productid" => $productid,
			"quantity" => 1,
			"price" => $productData['prodprice'],
			"variantid" => 0,
			"membershipid" => 0
		);
		$priceid = $this->DbInsertArray("xcart_pricing", $pricing);

		// Quick price
		$quickPrice = array(
			"productid" => $productid,
			"priceid" => $priceid,
			"membershipid" => 0,
			"variantid" => 0
		);
		$this->DbInsertArray("xcart_quick_prices", $quickPrice);

		// Does this product have one or more images?
		$firstImage = '';
		$thumbImage = '';
		$oldSort = 100000000000;
		$productImages = array();
		foreach($productData['images'] as $image) {
			if($image['imageisthumb'] == 2) {
				continue;
			}
			if($image['imageisthumb'] == 1 && !$thumbImage) {
				$thumbImage = $image['imagefile'];
			}
			else if($image['imagesort'] < $oldSort) {
				$productImages[] = $firstImage;
				$firstImage = $image['imagefile'];
			}
			else {
				$productImages[] = $image['imagefile'];
			}
		}

		// Do we have a thumbnail?
		if($thumbImage && file_exists($thumbImage)) {
			$imageFile = basename($thumbImage);
			$imageDir = $this->_exportSession['Configuration']['path'] . "./images/". "T";
			if(!is_dir($imageDir)) {
				@mkdir($imageDir, 0777);
			}
			copy($thumbImage, $imageDir . "/" . $imageFile);
			list($width, $height, $type, $attr) = @getimagesize($thumbImage);
			$newImage = array(
				"id" => $productid,
				"image" => "",
				"image_path" => $GLOBALS['XCART_DB']->Quote("./images/T/" . $imageFile),
				"image_type" => image_type_to_mime_type($type),
				"image_x" => (int)$width,
				"image_y" => (int)$height,
				"image_size" => (int)@filesize($thumbImage),
				"date" => time(),
				"alt" => "",
				"md5" => md5($thumbImage)
			);
			$this->DbInsertArray("xcart_images_T", $newImage);
		}

		// Is there a "main" image for this product?
		if($firstImage && file_exists($firstImage)) {
			$imageFile = basename($firstImage);
			$imageDir = $this->_exportSession['Configuration']['path'] . "./images/". "P";
			if(!is_dir($imageDir)) {
				@mkdir($imageDir, 0777);
			}
			copy($firstImage, $imageDir . "/" . $imageFile);
			list($width, $height, $type, $attr) = @getimagesize($firstImage);
			$newImage = array(
				"id" => $productid,
				"image" => "",
				"image_path" => $GLOBALS['XCART_DB']->Quote("./images/P/" . $imageFile), // TODO
				"image_type" => image_type_to_mime_type($type),
				"image_x" => (float)$width,
				"image_y" => (float)$height,
				"image_size" => (int)@filesize($firstImage),
				"date" => time(),
				"alt" => "",
				"md5" => md5($firstImage)
			);
			$this->DbInsertArray("xcart_images_P", $newImage);
		}

		// And any remaining images
		if(count($productImages) > 0) {
			foreach($productImages as $prodImage) {
				if(!file_exists($prodImage)) {
					continue;
				}
				$imageFile = basename($prodImage);
				$imageDir = $this->_exportSession['Configuration']['path'] . "./images/". "D";
				if(!is_dir($imageDir)) {
					@mkdir($imageDir, 0777);
				}
				copy($imageFile, $imageDir . "/" . $imageFile);
				list($width, $height, $type, $attr) = @getimagesize($prodImage);
				$newImage = array(
					"id" => $productid,
					"image" => "",
					"image_path" => $GLOBALS['XCART_DB']->Quote("./images/D/" . $imageFile),
					"image_type" => image_type_to_mime_type($type),
					"image_x" => (int)$width,
					"image_y" => (int)$height,
					"image_size" => (int)@filesize($prodImage),
					"date" => time(),
					"alt" => "",
					"md5" => md5($prodImage)
				);
				$this->DbInsertArray("xcart_images_D", $newImage);
			}
		}

		$main = "Y";
		// Associate this product with any categories
		foreach($productData['categories'] as $category) {
			$insertCategory = array(
				"productid" => $productid,
				"categoryid" => $category,
				"main" => $main,
				"orderby" => 0
			);
			$main = "N";
			$this->DbInsertArray("xcart_products_categories", $insertCategory);
		}

		// Product options
		$option_cache = array();
		$hasOptions = false;
		foreach($productData['options'] as $option) {
			if(isset($option_cache[$option['optname']])) {
				$classid = $option_cache[$option['optname']];
			}
			else {
				$newClass = array(
					"productid" => $productid,
					"class" => $GLOBALS['XCART_DB']->Quote($option['optname']),
					"classtext" => $GLOBALS['XCART_DB']->Quote($option['optname']),
					"orderby" => 1,
				);
				$classid = $this->DbInsertArray("xcart_classes", $newClass);
				$option_cache[$option['optname']] = $classid;
			}
			 $newOption = array(
				"classid" => $classid,
				"option_name" => $GLOBALS['XCART_DB']->Quote($option['optvalue']),
				"orderby" => 1,
				"avail" => "Y",
				"price_modifier" => 0,
				"modifier_type" => ""
			);
			$this->DbInsertArray("xcart_class_options", $newOption);
			$hasOptions = true;
		}

		// Insert quick flag
		if($hasOptions == true) {
			$is_options = 'Y';
		}
		else {
			$is_options = 'N';
		}
		$newFlag = array(
			"productid" => $productid,
			"is_variants" => "",
			"is_product_options" => $is_options,
			"is_taxes" => "",
			"image_path_T" => ""
		);
		$this->DbInsertArray("xcart_quick_flags", $newFlag);
	}

	function InsertCustomer($customerid, $customerData)
	{
		if(!isset($customerData['custconemail'])) {
			$err = sprintf(GetLang('ExportCustomerErrorInvalidEmail'), $customerId);
			$this->_LogExportError('invalid', $err);
			return false;
		}

		// Get the first listed shipping address (X-Cart only supports one shipping address per user)
		if(isset($customerData['addresses']) && count($customerData['addresses']) > 0) {
			$shipAddress = array_shift($customerData['addresses']);
		}
		else {
			$shipAddress = array(
				"shipfullname" => "",
				"shipaddress1" => "",
				"shipaddress2" => "",
				"shipcity" => "",
				"shipstate" => "",
				"shipzip" => "",
				"shipcountry" => "",
				"shipphone" => ""
			);
		}

		$newCustomer = array(
			"login" => $GLOBALS['XCART_DB']->Quote($customerData['custconemail']),
			"usertype" => "C",
			"password" => "", // X-Cart passwords can't be converted back across
			"b_title" => "",
			"b_firstname" => $GLOBALS['XCART_DB']->Quote($customerData['custconfirstname']),
			"b_lastname" => $GLOBALS['XCART_DB']->Quote($customerData['custconlastname']),
			"b_address" => $GLOBALS['XCART_DB']->Quote($shipAddress['shipaddress1']),
			"b_city" => $GLOBALS['XCART_DB']->Quote($shipAddress['shipcity']),
			"b_county" => '',
			"b_state" => $GLOBALS['XCART_DB']->Quote($shipAddress['shipstate']),
			"b_country" => $GLOBALS['XCART_DB']->Quote($shipAddress['shipcountry']),
			"b_zipcode" => $GLOBALS['XCART_DB']->Quote($shipAddress['shipzip']),
			"title" => "",
			"firstname" => $GLOBALS['XCART_DB']->Quote($customerData['custconfirstname']),
			"lastname" => $GLOBALS['XCART_DB']->Quote($customerData['custconlastname']),
			"company" => $GLOBALS['XCART_DB']->Quote($customerData['custconcompany']),
			"s_title" => "",
			"s_firstname" => $GLOBALS['XCART_DB']->Quote($shipAddress['shipfirstname']),
			"s_lastname" => $GLOBALS['XCART_DB']->Quote($shipAddress['shiplastname']),
			"s_address" => $GLOBALS['XCART_DB']->Quote($shipAddress['shipaddress1']),
			"s_city" => $GLOBALS['XCART_DB']->Quote($shipAddress['shipcity']),
			"s_county" => "",
			"s_state" => $GLOBALS['XCART_DB']->Quote($shipAddress['shipstate']),
			"s_country" => $GLOBALS['XCART_DB']->Quote($shipAddress['shipcountry']),
			"s_zipcode" => $GLOBALS['XCART_DB']->Quote($shipAddress['shipzip']),
			"email" => $GLOBALS['XCART_DB']->Quote($customerData['custconemail']),
			"phone" => $GLOBALS['XCART_DB']->Quote($customerData['custconphone']),
			"fax" => "",
			"first_login" => $customerData['custdatejoined']
		);
		$this->DbInsertArray("xcart_customers", $newCustomer);
	}

	function InsertWishlist($wishlistid, $wishlistData)
	{
		$newWishlist = array(
			"login" => $this->FetchEmailByCustomerId($wishlistData['customerid']),
			"productid" => $wishlistData['productid'],
			"amount" => 1,
			"amount_purchased" => 0,
			"options" => "",
			"event_id" => 0,
			"object" => ''
		);
		$this->DbInsertArray("xcart_wishlist", $newWishlist);
	}

	function InsertOrder($orderId, $orderData)
	{
		if(!isset($orderData['ordtotalamount'])) {
			$err = sprintf(GetLang('ExportOrderErrorInvalidTotal'), $orderId);
			$this->_LogExportError('invalid', $err);
			return false;
		}

		if(!isset($orderData['products']) || !is_array($orderData['products'])) {
			$err = sprintf(GetLang('ExportOrderErrorNoProducts'), $orderId);
			$this->_LogExportError('invalid', $err);
			return false;
		}

		list($billFirst, $billLast) = explode(" ", $orderData['ordbillfullname'], 2);
		list($shipFirst, $shipLast) = explode(" ", $orderData['ordshipfullname'], 2);

		// Establish order status

		switch($orderData['ordstatus']) {
			case 1:
				$status = "I";
				break;
			case 2:
			case 4:
			case 10:
				$status = "C";
				break;
			case 3:
				$status = "B";
				break;
			case 5:
				$status = "F";
				break;
			case 6:
				$status = "D";
				break;
			case 7:
				$status = "Q";
				break;
			case 8:
			case 9:
				$status = "P";
				break;
			default:
				$status = '';
		}

		$newOrder = array(
			"orderid" => $orderId,
			"login" => $GLOBALS['XCART_DB']->Quote($this->FetchEmailByCustomerId($orderData['ordcustid'])),
			"membership" => "",
			"total" => (int)$orderData['ordtotalamount'],
			"subtotal" => (int)$orderData['ordsubtotal'],
			"tracking" => $GLOBALS['XCART_DB']->Quote($orderData['ordtrackingno']),
			"shipping_cost" => (int)$orderData['ordshipcost'],
			"tax" => (int)$orderData['ordtaxtotal'],
			"taxes_applied" => "",
			"date" => (int)$orderData['orddate'],
			"status" => $status,
			"payment_method" => $GLOBALS['XCART_DB']->Quote($orderData['orderpaymentmethod']),
			"flag" => "N",
			"notes" => "",
			"details" => "",
			"customer_notes" => "",
			"customer" => "",
			"title" => "",
			"firstname" => $GLOBALS['XCART_DB']->Quote($billFirst),
			"lastname" => $GLOBALS['XCART_DB']->Quote($billLast),
			"company" => "",
			"b_title" => "",
			"b_firstname" => $GLOBALS['XCART_DB']->Quote($billFirst),
			"b_lastname" => $GLOBALS['XCART_DB']->Quote($billLast),
			"b_address" => $GLOBALS['XCART_DB']->Quote($orderData['ordbillstreet1']),
			"b_city" => $GLOBALS['XCART_DB']->Quote($orderData['ordbillsuburb']),
			"b_county" => "",
			"b_state" => $GLOBALS['XCART_DB']->Quote($orderData['ordbillstate']),
			"b_country" => $GLOBALS['XCART_DB']->Quote($this->GetXCartISOCountry($orderData['ordbillcountry'])),
			"b_zipcode" => $GLOBALS['XCART_DB']->Quote($orderData['ordbillzip']),
			"s_title" => "",
			"s_firstname" => $GLOBALS['XCART_DB']->Quote($shipFirst),
			"s_lastname" => $GLOBALS['XCART_DB']->Quote($shipLast),
			"s_address" => $GLOBALS['XCART_DB']->Quote($orderData['ordshipstreet1']),
			"s_city" => $GLOBALS['XCART_DB']->Quote($orderData['ordshipsuburb']),
			"s_county" => "",
			"s_state" => $GLOBALS['XCART_DB']->Quote($orderData['ordshipstate']),
			"s_country" => $GLOBALS['XCART_DB']->Quote($this->GetXCartISOCountry($orderData['ordshipcountry'])),
			"s_zipcode" => $GLOBALS['XCART_DB']->Quote($orderData['ordshipzip']),
			"phone" => "",
			"url" => "",
			"email" => $GLOBALS['XCART_DB']->Quote($this->FetchEmailByCustomerId($orderData['ordcustid'])),
			"extra" => "",
			"payment_surcharge" => $GLOBALS['XCART_DB']->Quote($orderData['ordhandlingcost']),
			"tax_number" => ""
		);
		$this->DbInsertArray("xcart_orders", $newOrder);

		// Insert the products for this order
		foreach($orderData['products'] as $product) {
			$newProduct = array(
				"itemid" => $product['orderprodid'],
				"orderid" => $orderId,
				"productid" => $product['ordprodid'],
				"productcode"=> $GLOBALS['XCART_DB']->Quote($product['ordprodsku']),
				"product" => $GLOBALS['XCART_DB']->Quote($product['ordprodname']),
				"price" => (float)$product['ordprodcost'],
				"amount" => (int)$product['ordprodqty'],
				"provider" => "",
				"product_options" => "",
				"extra_data" => ""
			);
			$this->DbInsertArray("xcart_order_details", $newProduct);
		}
	}

	/**
	 * Fetch a Interspire Shopping Cart email address based on a Interspire Shopping Cart customer ID.
	*
	* @param int The customer ID.
	* @return string The email address.
	*/
	function FetchEmailByCustomerId($customerid)
	{
		static $customercache;
		if(!is_array($customercache)) {
			$customercache = array();
		}

		if(isset($customercache[$customerid])) {
			return $customercache[$customerid];
		}

		// Not cached, need to query
		$query = sprintf("SELECT custconemail FROM [|PREFIX|]customers WHERE customerid='%d'", $customerid);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$customercache[$customerid] = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
		return $customercache[$customerid];
	}

	/**
	 * Fetch an X-Cart country code based on a Interspire Shopping Cart country name.
	 *
	 * @param string The Interspire Shopping Cart country name.
	 * @return string The X-Cart country code.
	*/
	function GetXCartISOCountry($country)
	{
		static $cache;
		$country2 = isc_strtolower($country);
		if(isset($cache[$country2])) {
			return $cache[$country2];
		}

		// Need to query and cache result
		$query = sprintf("SELECT countryiso2 FROM [|PREFIX|]countries WHERE LOWER(countryname)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($country2));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$cache[$country2] = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
		return $cache[$country2];
	}

	/**
	 * Perform a database INSERT query based off an array of fields.
	 *
	 * @param string The table name to insert into.
	 * @param array Array of field => value pairs to insert.
	 * @return int The database row insert ID.
	 */
	function DbInsertArray($table, $fields)
	{
		$query = sprintf("insert into [|PREFIX|]%s (%s) values ('%s')", $table, implode(",", array_keys($fields)), implode("','", $fields));
		$this->Debug(var_export($fields, true), "db-$table");
		$GLOBALS['XCART_DB']->Query($query);
		return $GLOBALS['XCART_DB']->LastId();
	}

	/**
	 * Performs multiple database INSERT queries based off an array of fields.
	 *
	 * @param string The table name to insert into.
	 * @param array Multi-dimensional array of fields.
	 * @return int The database row insert ID.
	 */
	function DbMultiInsertArray($table, $values)
	{
		// Get a list of fields
		$fields = implode(",", array_keys($values[0]));

		$rows = array();
		foreach($values as $values) {
			$rows[] = "('".implode("','", $values)."')";
		}
		$rows = implode(", ", $rows);

		$query = sprintf("insert into [|PREFIX|]%s (%s) VALUES %s", $table, $fields, $rows);
		$this->Debug(var_export($fields, true), "db-$table");
		$GLOBALS['XCART_DB']->Query($query);
		return $GLOBALS['XCART_DB']->LastId();
	}

}

?>