<?php

/**
 * Interspire Shopping Cart CubeCart Exporter.
 */
class ISC_ADMIN_EXPORTER_CUBECART4 extends ISC_ADMIN_EXPORTER
{
	/**
	 * @var string The title of this exporter.
	 */
	var $title = "CubeCart 4.0";

	/**
	 * @var string The language string used for the title of the export modules page.
	 */
	var $wizardTitle = 'CubeCartExportTitle';

	/**
	 * @var array A list of modules that this exporter contains. These should be in the order that they're required to run.
	 */
	var $_modules = array(
		"ExportCategories",
		"ExportProducts",
		"ExportCustomers",
		"ExportOrders",
		"ExportReviews"
	);

	/**
	 * Validate and save the exporter configuration.
	 *
	 * @param string Any error message encountered (passed back by reference)
	 * @return mixed False on failure, if successful, array of configuration information to save.
	 */
	function SaveConfiguration(&$err)
	{
		if(!isset($_POST['cubecart4_path'])) {
			$err = GetLang('NoCubeCartPath');
			return false;
		}

		if(isc_strpos($_POST['cubecart4_path'], 'http://') === 0 || isc_strpos($_POST['cubecart4_path'], 'https://') === 0) {
			$path = $this->URLToPath($_POST['cubecart4_path'], $err);
			if(!$path) {
				return false;
			}
		}
		else {
			$path = realpath(APP_ROOT."/../".$_POST['cubecart4_path']);
			$path = preg_replace("#[^a-z0-9\./\\:]#i", "", $path);
		}

		if(!is_dir($path) || !file_exists($path."/includes/global.inc.php")) {
			$err = sprintf(GetLang('InvalidCubeCartPath'), isc_html_escape($_POST['cubecart4_path']), isc_html_escape($_POST['cubecart4_path']));
			return false;
		}
		else {
			return array(
				"path" => $path
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
		if(isset($_POST['cubecart4_path']) && $_POST['cubecart4_path'] != '') {
			$GLOBALS['Path'] = isc_html_escape($_POST['cubecart4_path']);
		}
		$GLOBALS['HelpTitle'] = str_replace("'", "\\'", GetLang('CubeCartLocation'));
		return $this->ParseTemplate("cubecart4.configure", true);
	}

	/**
	 * Connec to the CubeCart database.
	 */
	function Connect()
	{
		include($this->_exportSession['Configuration']['path']."/includes/global.inc.php");

		$GLOBALS['CUBECART_DB'] = &new MySQLDB();
		$connection = $GLOBALS['CUBECART_DB']->Connect($glob['dbhost'], $glob['dbusername'], $glob['dbpassword'], $glob['dbdatabase']);
		$GLOBALS['CUBECART_DB']->TablePrefix = $glob['dbprefix'];
		if($this->_Debug == true) {
			$GLOBALS['CUBECART_DB']->QueryLog = dirname(__FILE__)."/../logs/export-cc4.queries.txt";
			$GLOBALS['CUBECART_DB']->TimeLog = dirname(__FILE__)."/../logs/export-cc4.query_time.txt";
			$GLOBALS['CUBECART_DB']->ErrorLog = dirname(__FILE__)."/../logs/export-cc4.db_errors.txt";
		}
	}

	/**
	 * Show the CubeCart Warning Page
	 */
	function ExportWarning()
	{
		echo $this->ParseTemplate("cubecart4.export.warning");
	}

	/**
	 * This function will go in and clear everything from the OsCommerce store for tables we'll be exporting into.
	 */
	function ClearStore()
	{
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_Downloads";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_category";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_cats_idx";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_cats_lang";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_customer";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_img_idx";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_inv_lang";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_inventory";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_options_bot";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_options_mid";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_options_top";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_order_inv";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_order_sum";
		$queries[] = "TRUNCATE [|PREFIX|]CubeCart_reviews";

		$total_queries = count($queries);
		$queries_run = 0;
		foreach ($queries as $query) {
			$GLOBALS['CUBECART_DB']->Query($query);
			++$queries_run;
			$this->UpdateProgress(GetLang('ExporterDeletingStore'), $queries_run, $total_queries);
		}

		// Clear the CubeCart cache
		$cacheRoot = $this->_exportSession['Configuration']['path'] . "/cache";
		$cacheDir = @scandir($cacheRoot);
		if(is_array($cacheDir)) {
			foreach($cacheDir as $file) {
				if(is_dir($cacheRoot . "/" . $file)) {
					continue;
				}
				@unlink($cacheRoot . "/" . $file);
			}
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
			"cat_name" => $GLOBALS['CUBECART_DB']->Quote($categoryData['catname']),
			"cat_desc" => "",
			"cat_id" => $categoryid,
			"cat_father_id" => $categoryData['catparentid'],
			"cat_image" => "",
			"per_ship" => 0,
			"item_ship" => 0,
			"item_int_ship" => 0,
			"per_int_ship" => 0,
			"noProducts" => 0,
			"hide" => 0,
			"cat_metatitle" => "",
			"cat_metadesc" => "",
			"priority" => $categoryData['catparentid']
		);

		$this->DbInsertArray("CubeCart_category", $category);
	}

	function ExportProductsCleanup()
	{
		// Need to loop through all categories and set noProducts.
		$query = "SELECT c.cat_id, COUNT(pc.productId) AS numproducts FROM [|PREFIX|]CubeCart_category c LEFT JOIN [|PREFIX|]CubeCart_cats_idx pc ON (pc.cat_id=c.cat_id) GROUP BY c.cat_id";
		$result = $GLOBALS['CUBECART_DB']->Query($query);
		while($row = $GLOBALS['CUBECART_DB']->Fetch($result)) {
			$query2 = sprintf("UPDATE [|PREFIX|]CubeCart_category SET noProducts='%d' WHERE cat_id='%d'", $row['numproducts'], $row['cat_id']);
			$GLOBALS['CUBECART_DB']->Query($query2);
		}
	}

	function InsertReview($reviewid, $reviewData)
	{
		$review = array(
			"id" => $reviewid,
			"approved" => $reviewData['revstatus'],
			"productId" => $reviewData['revproductid'],
			"type" => 0,
			"rating" => $reviewData['revrating'],
			"name" => $GLOBALS['CUBECART_DB']->Quote($reviewData['revfromname']),
			"email" => "",
			"title" => $GLOBALS['CUBECART_DB']->Quote($reviewData['revtitle']),
			"review" => $GLOBALS['CUBECART_DB']->Quote($reviewData['revtext']),
			"ip" => "",
			"time" => $reviewData['revdate']
		);

		$this->DbInsertArray("CubeCart_reviews", $review);
	}

	function InsertProduct($productid, $productData)
	{
		$isDigital = 0;
		$digitalFile = '';
		if(is_array($productData['downloads'])) {
			$download = array_shift($productData['downloads']);
			if($download && file_exists($download['downfile'])) {
				$isDigital = 1;
				if(!is_dir($this->_exportSession['Configuration']['path'] . "/downloads")) {
					@mkdir($this->_exportSession['Configuration']['path'] . "/downloads", 0777);
				}
				@copy($download['downlfile'], $this->_exportSession['Configuration']['path'] . "/downloads/" . basename($download['downfile']));
				$digitalFile = "downloads/" . basename($download['downfile']);
			}
		}

		if($productData['prodinvtrack']) {
			$track = 1;
		}
		else {
			$track = 0;
		}

		$product = array(
			"productId" => $productid,
			"productCode" => $GLOBALS['CUBECART_DB']->Quote($productData['prodcode']),
			"quantity" => 1,
			"description" => $GLOBALS['CUBECART_DB']->Quote($productData['proddesc']),
			"price" => $productData['prodprice'],
			"name" => $GLOBALS['CUBECART_DB']->Quote($productData['prodname']),
			"popularity" => $productData['prodnumsold'],
			"sale_price" => $productData['prodsaleprice'],
			"stock_level" => $productData['prodcurrentinv'],
			"stockWarn" => $productData['prodlowinv'],
			"useStockLevel" => $track,
			"digital" => $isDigital,
			"digitalDir" => $digitalFile,
			"prodWeight" => $productData['prodweight'],
			"taxType" => 0,
			"showFeatured" => $productData['prodfeatured'],
			"prod_metatitle" => "",
			"prod_metadesc" => "",
			"prod_metakeywords" => "",
			"eanupcCode" => ""
		);

		// Does this product have one or more images?
		$firstImage = '';
		$thumbImage = '';
		$productImages = array();
		foreach($productData['images'] as $image) {
			if($image['imageisthumb'] == 1) {
				$thumbImage = $image['imagefile'];
			}
			else if($image['imageisthumb'] == 2) {
				continue;
			}
			else if(!$firstImage) {
				$firstImage = $image['imagefile'];
			}
			else {
				$productImages[] = $image['imagefile'];
			}
		}

		if(!$firstImage && $thumbImage) {
			$firstImage = $thumbImage;
		}

		// Is there a "main" image for this product?
		if($firstImage) {
			$imageFile = basename($firstImage);
			$imageDir = $this->_exportSession['Configuration']['path'] . "./images/uploads";
			if(!is_dir($imageDir)) {
				@mkdir($imageDir, 0777);
			}
			copy($firstImage, $imageDir . "/" . $imageFile);
			$product['image'] = $GLOBALS['CUBECART_DB']->Quote($imageFile);
			if($thumbImage) {
				copy($thumbImage, $imageDir . "/thumbs/thumb_" . $imageFile);
			}
		}
		$product['noImages'] = count($productImages);

		// And any remaining images
		if(count($productImages) > 0) {
			foreach($productImages as $prodImage) {
				if(!file_exists($prodImage)) {
					continue;
				}
				$imageFile = basename($prodImage);
				$imageDir = $this->_exportSession['Configuration']['path'] . "./images/uploads";
				if(!is_dir($imageDir)) {
					@mkdir($imageDir, 0777);
				}
				copy($imageFile, $imageDir . "/" . $imageFile);
				$newImage = array(
					"productId" => $productid,
					"img" => $GLOBALS['CUBECART_DB']->Quote($imageFile)
				);
				$this->DbInsertArray("CubeCart_img_idx", $newImage);
			}
		}

		// Associate this product with any categories
		$mainCat = 0;
		foreach($productData['categories'] as $category) {
			if(!$mainCat) {
				$mainCat = $category;
			}
			$insertCategory = array(
				"cat_id" => $category,
				"productId" => $productid
			);
			$this->DbInsertArray("CubeCart_cats_idx", $insertCategory);
		}
		$product['cat_id'] = $mainCat;

		$this->DbInsertArray("CubeCart_inventory", $product);

		// Product options
		foreach($productData['options'] as $option) {
			$products_option_id = $this->GetProductsOptionId($option['optname']);
			$products_options_values_id = $this->GetProductsValueId($option['optvalue'], $products_option_id);
			$newOption = array(
				"product" => $productid,
				"option_id" => $this->GetProductsOptionId($option['optname']),
				"value_id" => $this->GetProductsValueId($option['optvalue'], $products_option_id),
				"option_price" => 0,
				"option_symbol" => "+"
			);
			$this->DbInsertArray("CubeCart_options_bot", $newOption);
		}
	}

	function GetProductsOptionId($optname)
	{
		static $optcache;
		$optname2 = isc_strtolower($optname);
		if(isset($optcache[$optname2])) {
			return $optcache[$optname2];
		}

		// Need to query for it, not cached
		$query = sprintf("SELECT option_id FROM [|PREFIX|]CubeCart_options_top WHERE LOWER(option_name)='%s'", $optname2);
		$result = $GLOBALS['CUBECART_DB']->Query($query);
		$id = $GLOBALS['CUBECART_DB']->FetchOne($result);

		// Existing record was not found need to create
		if(!$id) {
			$query = sprintf("INSERT INTO [|PREFIX|]CubeCart_options_top (option_name) VALUES ('%s')", $GLOBALS['CUBECART_DB']->Quote($optname));
			$GLOBALS['CUBECART_DB']->Query($query);
			$id = $GLOBALS['CUBECART_DB']->LastId();
			$optcache[$optname2] = $id;

		}
		return $id;
	}

	function GetProductsValueId($optvalue, $optid)
	{
		static $optcache;

		$optvalue2 = isc_strtolower($optvalue);
		if(isset($optcache[$optid][$optvalue2])) {
			return $optcache[$optid][$optvalue2];
		}

		// Need to look it up
		$query = sprintf("SELECT value_id FROM [|PREFIX|]CubeCart_options_mid WHERE father_id='%d' AND LOWER(value_name)='%s'", $optid, $GLOBALS['CUBECART_DB']->Quote($optvalue2));
		$result = $GLOBALS['CUBECART_DB']->Query($query);
		$id = $GLOBALS['CUBECART_DB']->FetchOne($result);

		// Existing record was not found need to create
		if(!$id) {
			$query = sprintf("INSERT INTO [|PREFIX|]CubeCart_options_mid (value_name, father_id) VALUES ('%s', '%d')", $GLOBALS['CUBECART_DB']->Quote($optvalue), $optid);
			$GLOBALS['CUBECART_DB']->Query($query);
			$id = $GLOBALS['CUBECART_DB']->LastId();
			$optcache[$optid][$optvalue2] = $id;
		}
		return $id;
	}

	function InsertCustomer($customerid, $customerData)
	{
		// Get the first listed shipping address (CubeCart only supports one shipping address per user)
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

		$customer = array(
			"email" => $GLOBALS['CUBECART_DB']->Quote($customerData['custconemail']),
			"password" => $customerData['custpassword'],
			"title" => "",
			"firstName" => $GLOBALS['CUBECART_DB']->Quote($customerData['custconfirstname']),
			"lastName" => $GLOBALS['CUBECART_DB']->Quote($customerData['custconlastname']),
			"companyName" => $GLOBALS['CUBECART_DB']->Quote($customerData['custconcompany']),
			"add_1" => $GLOBALS['CUBECART_DB']->Quote($shipAddress['shipaddress1']),
			"add_2" => $GLOBALS['CUBECART_DB']->Quote($shipAddress['shipaddress2']),
			"town" => $GLOBALS['CUBECART_DB']->Quote($shipAddress['shipcity']),
			"county" => $GLOBALS['CUBECART_DB']->Quote($shipAddress['shipstate']),
			"postcode" => $GLOBALS['CUBECART_DB']->Quote($shipAddress['shipzip']),
			"country" => $this->GetCubeCartISOCountry($shipAddress['shipcountry']),
			"phone" => $GLOBALS['CUBECART_DB']->Quote($customerData['custconphone']),
			"mobile" => "",
			"customer_id" => $customerid,
			"regTime" => $customerData['custdatejoined'],
			"ipAddress" => "",
			"noOrders" => 0,
			"type" => 1
		);
		$this->DbInsertArray("CubeCart_customer", $customer);
	}

	function InsertOrder($orderId, $orderData)
	{
		// Establish order status
		switch($orderData['ordstatus']) {
			case 1:
			case 7:
				$status = 1;
				break;
			case 2:
			case 10:
			case 4:
				$status = 3;
				break;
			case 3:
			case 8:
			case 9:
				$status = 2;
				break;
			case 5:
				$status = 6;
				break;
			case 6:
				$status = 4;
				break;
		}

		$order = array(
			"cart_order_id" => $orderId,
			"customer_id" => $orderData['ordcustid'],
			"name" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordbillfullname']),
			"add_1" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordbillstreet1']),
			"add_2" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordbillstreet2']),
			"town" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordbillsuburb']),
			"county" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordbillstate']),
			"postcode" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordbillzip']),
			"country" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordbillcountry']),
			"name_d" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordshipfullname']),
			"add_1_d" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordshipstreet1']),
			"add_2_d" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordshipstreet2']),
			"town_d" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordshipsuburb']),
			"county_d" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordshipstate']),
			"postcode_d" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordshipzip']),
			"country_d" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordshipcountry']),
			"phone" => "",
			"mobile" => "",
			"subtotal" => $orderData['ordsubtotal'],
			"discount" => 0,
			"prod_total" => $orderData['ordtotalamount'],
			"total_tax" => $orderData['ordtaxtotal'],
			"total_ship" => $orderData['ordshipcost'],
			"status" => $status,
			"sec_order_id" => "",
			"ip" => "",
			"time" => $orderData['orddate'],
			"email" => "",
			"comments" => "",
			"ship_date" => $orderData['orddateshipped'],
			"shipMethod" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordshipmethod']),
			"gateway" => $GLOBALS['CUBECART_DB']->Quote($orderData['orderpaymentmethod']),
			"currency" => "",
			"customer_comments" => "",
			"tax1_disp" => "Tax",
			"tax1_amt" => $orderData['ordtaxtotal'],
			"tax2_disp" => "",
			"tax2_amt" => "",
			"tax3_disp" => "",
			"tax3_amt" => "",
			"offline_capture" => "",
			"courier_tracking" => $GLOBALS['CUBECART_DB']->Quote($orderData['ordtrackingno']),
			"companyName" => "",
			"companyName_d" => "",
			"basket" => ""
		);
		$this->DbInsertArray("CubeCart_order_sum", $order);

		// Insert the products for this order
		foreach($orderData['products'] as $product) {
			if($product['ordprodtype'] == "digital") {
				$isDigital = 1;
			} else {
				$isDigital = 0;
			}

			$newProduct = array(
				"productId" => $product['ordprodid'],
				"productCode" => $product['ordprodsku'],
				"name" => $GLOBALS['CUBECART_DB']->Quote($product['ordprodname']),
				"quantity" => $product['ordprodqty'],
				"price" => $product['ordprodcost'],
				"cart_order_id" => $orderId,
				"product_options" => "",
				"digital" => $isDigital,
				"stockUpdated" => 1,
				"custom" => "",
				"couponId" => 0
			);
			$this->DbInsertArray("CubeCart_order_inv", $newProduct);
		}
	}

	/**
	 * Fetch an CubeCart ISO3 country code based on a Interspire Shopping Cart country name.
	 *
	 * @param string The Interspire Shopping Cart country name.
	 * @return string The CubeCart country code.
	*/
	function GetCubeCartISOCountry($country)
	{
		static $cache;
		$country2 = isc_strtolower($country);
		if(isset($cache[$country2])) {
			return $cache[$country2];
		}

		// Need to query and cache result
		$query = sprintf("SELECT iso3 FROM [|PREFIX|]CubeCart_iso_countries WHERE LOWER(printable_name)='%s'", $GLOBALS['CUBECART_DB']->Quote($country2));
		$result = $GLOBALS['CUBECART_DB']->Query($query);
		$cache[$country2] = $GLOBALS['CUBECART_DB']->FetchOne($result);
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
		$GLOBALS['CUBECART_DB']->Query($query);
		return $GLOBALS['CUBECART_DB']->LastId();
	}
}

?>