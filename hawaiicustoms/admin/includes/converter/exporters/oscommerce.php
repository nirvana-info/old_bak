<?php

/**
 * Interspire Shopping Cart OsCommerce Exporter.
 */
class ISC_ADMIN_EXPORTER_OSCOMMERCE extends ISC_ADMIN_EXPORTER
{
	/**
	 * @var string The title of this exporter.
	 */
	var $title = "OsCommerce 2.2";

	/**
	 * @var string The language string used for the title of the export modules page.
	 */
	var $wizardTitle = 'OsCommerceExportTitle';

	/**
	 * @var array A list of modules that this exporter contains. These should be in the order that they're required to run.
	 */
	var $_modules = array(
		"ExportCategories",
		"ExportBrands",
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
		if(!isset($_POST['path'])) {
			$err = GetLang('NoOsCommercePath');
			return false;
		}

		if(isc_strpos($_POST['path'], 'http://') === 0 || isc_strpos($_POST['path'], 'https://') === 0) {
			$path = $this->URLToPath($_POST['path'], $err);
			if(!$path) {
				return false;
			}
		}
		else {
			$path = realpath(APP_ROOT."/../".$_POST['path']);
			$path = preg_replace("#[^a-z0-9\./\\:]#i", "", $path);
		}

		if(!is_dir($path) || !file_exists($path."/includes/configure.php")) {
			$err = sprintf(GetLang('InvalidOsCommercePath'), isc_html_escape($_POST['path']), isc_html_escape($_POST['path']));
			return false;
		}
		else {
			// Grab the default OsCommerce language
			require $path."/includes/configure.php";
			$GLOBALS['OSCOMMERCE_DB'] = &new MySQLDB();
			$connection = $GLOBALS['OSCOMMERCE_DB']->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

			if (!$connection) {
				list($error, $level) = $db->GetError();
				trigger_error($error, $level);
			}

			$query = "select languages_id from languages order by sort_order asc limit 1";
			$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
			$language_id = $GLOBALS['OSCOMMERCE_DB']->FetchOne($result);

			return array(
				"path" => $path,
				"language" => $language_id,
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
		if(isset($_POST['path']) && $_POST['path'] != '') {
			$GLOBALS['Path'] = isc_html_escape($_POST['path']);
		}
		$GLOBALS['HelpTitle'] = str_replace("'", "\\'", GetLang('OsCommerceLocation'));
		return $this->ParseTemplate("oscommerce.export.configure", true);
	}

	/**
	 * Connec to the OsCommerce database.
	 */
	function Connect()
	{
		include_once($this->_exportSession['Configuration']['path']."/includes/configure.php");

		$GLOBALS['OSCOMMERCE_DB'] = &new MySQLDB();
		$connection = $GLOBALS['OSCOMMERCE_DB']->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

		if($this->_Debug == true) {
			$GLOBALS['OSCOMMERCE_DB']->QueryLog = dirname(__FILE__)."/../logs/export-osc.queries.txt";
			$GLOBALS['OSCOMMERCE_DB']->TimeLog = dirname(__FILE__)."/../logs/export-osc.query_time.txt";
			$GLOBALS['OSCOMMERCE_DB']->ErrorLog = dirname(__FILE__)."/../logs/export-osc.db_errors.txt";
		}
	}

	/**
	 * Show the OsCommerce Warning Page
	 */
	function ExportWarning()
	{
		echo $this->ParseTemplate("oscommerce.export.warning");
	}

	/**
	 * This function will go in and clear everything from the OsCommerce store for tables we'll be exporting into.
	 */
	function ClearStore()
	{
		$queries[] = "TRUNCATE categories";
		$queries[] = "TRUNCATE categories_description";
		$queries[] = "TRUNCATE customers";
		$queries[] = "TRUNCATE administrators";
		$queries[] = "TRUNCATE address_book";
		$queries[] = "TRUNCATE manufacturers";
		$queries[] = "TRUNCATE manufacturers_info";
		$queries[] = "TRUNCATE orders";
		$queries[] = "TRUNCATE orders_products";
		$queries[] = "TRUNCATE products";
		$queries[] = "TRUNCATE products_description";
		$queries[] = "TRUNCATE products_attributes";
		$queries[] = "TRUNCATE products_to_categories";
		$queries[] = "TRUNCATE products_options";
		$queries[] = "TRUNCATE products_options_values";
		$queries[] = "TRUNCATE products_options_values_to_products_options";
		$queries[] = "TRUNCATE reviews";
		$queries[] = "TRUNCATE reviews_description";
		$queries[] = "TRUNCATE orders_total";

		$queries_run = 2; // Product images & downloads
		$total_queries = count($queries) + $queries_run;

		foreach ($queries as $query) {
			$GLOBALS['OSCOMMERCE_DB']->Query($query);
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
			"categories_id" => $categoryid,
			"parent_id" => $categoryData['catparentid'],
			"categories_image" => "pixel_trans.gif", // Interspire Shopping Cart doesn't support images for Categories, OsCommerce forces images - use transparent
			"sort_order" => $categoryData['catsort'],
			"date_added" => time(),
			"last_modified" => time()
		);
		$this->DbInsertArray("categories", $category);

		// Insert the category name
		$catDescription = array(
			"categories_id" => $categoryid,
			"language_id" => $this->_exportSession['Configuration']['language'],
			"categories_name" => $GLOBALS['OSCOMMERCE_DB']->Quote($categoryData['catname'])
		);
		$this->DbInsertArray("categories_description", $catDescription);
	}

	function InsertBrand($brandid, $brandData)
	{
		if(!isset($brandData['brandname']) || $brandData['brandname'] == '') {
			$err = sprintf(GetLang('ExportBrandErrorInvalid'), $brandId);
			$this->_LogExportError('invalid', $err);
			return false;
		}

		$brand = array(
			"manufacturers_id" => $brandid,
			"manufacturers_name" => $GLOBALS['OSCOMMERCE_DB']->Quote($brandData['brandname'])
		);
		$this->DbInsertArray("manufacturers", $brand);
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
			"reviews_id" => $reviewid,
			"products_id" => $reviewData['revproductid'],
			"customers_name" => $GLOBALS['OSCOMMERCE_DB']->Quote($reviewData['revfromname']),
			"reviews_rating" => $GLOBALS['OSCOMMERCE_DB']->Quote($reviewData['revrating']),
			"date_added" => $this->UnixToDateTime($reviewData['revdate']),
			"last_modified" => $this->UnixToDateTime($reviewData['revdate']),
			"reviews_read" => 0
		);

		$this->DbInsertArray("reviews", $review);

		// Insert actual review contents
		$reviewText = array(
			"reviews_id" => $reviewid,
			"languages_id" => $this->_exportSession['Configuration']['language'],
			"reviews_text" => $GLOBALS['OSCOMMERCE_DB']->Quote($reviewData['revtext'])
		);

		$this->DbInsertArray("reviews_description", $reviewText);
	}

	function InsertProduct($productid, $productData)
	{
		if(!isset($productData['prodname']) || $productData['prodname'] == '') {
			$err = sprintf(GetLang('ExportProductErrorInvalid'), $productId);
			$this->_LogImporError('invalid', $err);
			return false;
		}

		if(!isset($productData['prodprice'])) {
			$err = sprintf(GetLang('ExportProductErrorInvalidPrice'), $productData['prodname']);
			$this->_LogImporError('invalid', $err);
			return false;
		}

		$product = array(
			"products_id" => $productid,
			"products_quantity" => $productData['prodcurrentinv'],
			"products_model" => $GLOBALS['OSCOMMERCE_DB']->Quote($productData['prodcode']),
			"products_price" => (float)$productData['prodprice'],
			"products_date_added" => $this->UnixToDateTime($productData['proddateadded']),
			"products_last_modified" => $this->UnixToDateTime($productData['proddateadded']),
			"products_weight" => (float)$productData['prodweight'],
			"products_status" => (int)$productData['prodvisible'],
			"manufacturers_id" => (int)$productData['prodbrandid'],
			"products_ordered" => (int)$productData['prodnumsold']
		);

		$productDesc = array(
			"products_id" => $productid,
			"language_id" => $this->_exportSession['Configuration']['language'],
			"products_name" => $GLOBALS['OSCOMMERCE_DB']->Quote($productData['prodname']),
			"products_description" => $GLOBALS['OSCOMMERCE_DB']->Quote($productData['proddesc']),
			"products_viewed" => (int)$productData['prodnumviews']
		);
		$this->DbInsertArray("products_description", $productDesc);

		// Does this product have a thumbnail?
		$image = '';
		foreach($productData['images'] as $image) {
			if($image['imageisthumb'] == 1) {
				$image = $image['imagefile'];
				break;
			}
		}
		if($image) {
			$imageFile = basename($image);
			copy($image, $this->_exportSession['Configuration']['path'] . "/images/" . $imageFile);
			$product['products_image'] = $imageFile;
		}

		// Associate this product with any categories
		foreach($productData['categories'] as $category) {
			$insertCategory = array(
				"products_id" => $productid,
				"categories_id" => $category
			);
			$this->DbInsertArray("products_to_categories", $insertCategory);
		}

		// Product options
		foreach($productData['options'] as $option) {
			$products_options_id = $this->GetProductsOptionsId($option['optname']);
			$products_options_values_id = $this->GetProductsOptionsValuesId($option['optvalue'], $products_options_id);
			 $newOption = array(
				 "products_id" => $productid,
				 "options_id" => $products_options_id,
				 "options_values_id" => $products_options_values_id,
				 "options_values_price" => 0,
				 "price_prefix" => "+"
			);
			$this->DbInsertArray("products_attributes", $newOption);
		}

		$this->DbInsertArray("products", $product);
	}

	function GetProductsOptionsId($optname)
	{
		static $optcache, $last_id;
		$optname2 = isc_strtolower($optname);
		if(isset($optcache[$optname2])) {
			return $optcache[$optname2];
		}

		// Need to query for it, not cached
		$query = sprintf("SELECT products_options_id FROM products_options WHERE LOWER(products_options_name)='%s'", $optname2);
		$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
		$id = $GLOBALS['OSCOMMERCE_DB']->FetchOne($result);

		// Existing record was not found need to create
		if(!$id) {
			if(!$last_id) {
				$query = "SELECT MAX(products_options_id) FROM products_options";
				$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
				$last_id = $GLOBALS['OSCOMMERCE_DB']->FetchOne($result);
			}

			$query = sprintf("INSERT INTO products_options (products_options_id ,language_id, products_options_name) VALUES ('%s', '%s', '%s')", $last_id+1, $this->_exportSession['Configuration']['language'], $GLOBALS['OSCOMMERCE_DB']->Quote($optname));
			$GLOBALS['OSCOMMERCE_DB']->Query($query);
			++$last_id;
			$id = $last_id + 1;
			$optcache[$optname2] = $id;

		}
		return $id;
	}

	function GetProductsOptionsValuesId($optvalue, $optid)
	{
		static $optcache, $last_id;

		$optvalue2 = isc_strtolower($optvalue);
		if(isset($optcache[$optid][$optvalue2])) {
			return $optcache[$optid][$optvalue2];
		}

		// Need to look it up
		$query = sprintf("
			SELECT p1.products_options_values_id
			FROM (products_options_values p1, products_options_values_to_products_options p2)
			WHERE LOWER(p1.products_options_values_name)='%s' AND p1.language_id='%s' AND p2.products_options_id='%s' AND p1.products_options_values_id=p2.products_options_values_id",
			$optvalue2,
			$this->_exportSession['Configuration']['language'],
			$optid
		);
		$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
		$id = $GLOBALS['OSCOMMERCE_DB']->FetchOne($result);

		// Existing record was not found need to create
		if(!$id) {
			// Select the highest ID from the products_options_values table
			if(!$last_id) {
				$query = "SELECT MAX(products_options_values_id) FROM products_options_values";
				$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
				$last_id = $GLOBALS['OSCOMMERCE_DB']->FetchOne($result)+1;
			}
			$query = sprintf("INSERT INTO products_options_values (products_options_values_id, language_id, products_options_values_name) VALUES ('%s','%s','%s')", $last_id+1, $this->_exportSession['Configuration']['language'], $GLOBALS['OSCOMMERCE_DB']->Quote($optvalue));
			$GLOBALS['OSCOMMERCE_DB']->Query($query);
			$query = sprintf("INSERT INTO products_options_values_to_products_options (products_options_id, products_options_values_id) VALUES ('%s','%s')", $optid, $last_id+1);
			$GLOBALS['OSCOMMERCE_DB']->Query($query);
			++$last_id;
			$id = $last_id + 1;
			$optcache[$optid][$optvalue2] = $id;
		}
		return $id;
	}

	function InsertCustomer($customerid, $customerData)
	{
		if(!isset($customerData['custconemail'])) {
			$err = sprintf(GetLang('ExportCustomerErrorInvalidEmail'), $customerId);
			$this->_LogImporError('invalid', $err);
			return false;
		}

		$newCustomer = array(
			"customers_id" => $customerid,
			"customers_gender" => '',
			"customers_firstname" => $GLOBALS['OSCOMMERCE_DB']->Quote($customerData['custconfirstname']),
			"customers_lastname" => $GLOBALS['OSCOMMERCE_DB']->Quote($customerData['custconlastname']),
			"customers_dob" => "0",
			"customers_email_address" => $GLOBALS['OSCOMMERCE_DB']->Quote($customerData['custconemail']),
			"customers_telephone" =>$GLOBALS['OSCOMMERCE_DB']->Quote( $customerData['custconphone']),
			"customers_password" => $GLOBALS['OSCOMMERCE_DB']->Quote($customerData['custpassword'])
		);
		$this->DbInsertArray("customers", $newCustomer);

		// Any shipping addresses?
		if(isset($customerData['addresses'])) {
			foreach($customerData['addresses'] as $address) {
				@list($firstname, $lastname) = explode(" ", $address['shipfullname'], 2);
				$newAddress = array(
					"customers_id" => $customerid,
					"entry_gender" => '',
					"entry_company" => $GLOBALS['OSCOMMERCE_DB']->Quote($customerData['custconcompany']),
					"entry_firstname" => $GLOBALS['OSCOMMERCE_DB']->Quote($firstname),
					"entry_lastname" => $GLOBALS['OSCOMMERCE_DB']->Quote($lastname),
					"entry_street_address" => $GLOBALS['OSCOMMERCE_DB']->Quote($address['shipaddress1']),
					"entry_suburb" => $GLOBALS['OSCOMMERCE_DB']->Quote($address['shipcity']),
					"entry_postcode" => $GLOBALS['OSCOMMERCE_DB']->Quote($address['shipzip']),
					"entry_city" => '',
					"entry_state" => $GLOBALS['OSCOMMERCE_DB']->Quote($address['shipstate']),
					"entry_country_id" => $this->GetOsCommerceCountryId($address['shipcountry'])
				);
				$this->DbInsertArray("address_book", $newAddress);
			}
		}
	}

	function GetOsCommerceCountryId($country)
	{
		static $countrycache;
		$country = isc_strtolower($country);
		if(isset($countrycache[$country])) {
			return $countrycache[$country];
		}

		// Need to fetch & cache
		$query = sprintf("SELECT countries_id FROM countries WHERE LOWER(countries_name)='%s'", $GLOBALS['OSCOMMERCE_DB']->Quote($country));
		$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
		$id = $GLOBALS['OSCOMMERCE_DB']->FetchOne($result);
		$countrycache[$country] = $id;
		return $id;
	}

	function InsertOrder($orderId, $orderData)
	{
		if(!isset($orderData['ordtotalamount'])) {
			$err = sprintf(GetLang('ExportOrderErrorInvalidTotal'), $orderId);
			$this->_LogImporError('invalid', $err);
			return false;
		}

		if(!isset($orderData['products']) || !is_array($orderData['products'])) {
			$err = sprintf(GetLang('ExportOrderErrorNoProducts'), $orderId);
			$this->_LogImporError('invalid', $err);
			return false;
		}

		if($orderData['ordstatus'] == 10 || $orderData['ordstatus'] == 2 || $orderData['ordstatus'] == 3 || $orderData['ordstatus'] == 4 || $orderData['ordstatus'] == 5 || $orderData['ordstatus'] == 6) {
			$status = 3;
		}
		else if($orderData['ordstatus'] == 1 || $orderData['ordstatus'] == 7) {
			$status = 2;
		}
		else {
			$status = 1;
		}

		$newOrder = array(
			"orders_id" => $orderId,
			"customers_id" => $orderData['ordcustid'],
			"date_purchased" => $this->UnixToDatetime($orderData['orddate']),
			"orders_status" => $status,
			"payment_method" => $orderData['orderpaymentmethod'],
			"billing_name" => $orderData['ordbillfullname'],
			"billing_street_address" => $orderData['ordbillstreet1'],
			"billing_suburb" => $orderData['ordbillsuburb'],
			"billing_state" => $orderData['ordbillstate'],
			"billing_postcode" => $orderData['ordbillzip'],
			"billing_country" => $orderData['ordbillcountry'],
			"delivery_name" => $orderData['ordshipfullname'],
			"delivery_street_address" => $orderData['ordshipstreet1'],
			"delivery_suburb" => $orderData['ordshipsuburb'],
			"delivery_state" => $orderData['ordshipstate'],
			"delivery_postcode" => $orderData['ordshipzip'],
			"delivery_country" => $orderData['ordshipcountry'],
			"orders_date_finished" => $this->UnixToDatetime($orderData['orddateshipped'])
		);
		$this->DbInsertArray("orders", $newOrder);

		$orderTotal = array(
			array("orders_id" => $orderId, "class" => "ot_subtotal", "value" => $orderData['ordsubtotal'], "title" => "Sub-Total:", "sort_order" => 1),
			array("orders_id" => $orderId, "class" => "ot_tax", "value" => $orderData['ordtaxtotal'], "title" => "Tax:", "sort_order" => 2),
			array("orders_id" => $orderId, "class" => "ot_shipping", "value" => $orderData['ordshipcost'], "title" => $orderData['ordshipmethod'].":", "sort_order" => 3),
			array("orders_id" => $orderId, "class" => "ot_total", "value" => $orderData['ordtotalamount'], "title" => "Total:", "sort_order" => 3)
		);
		$this->DbMultiInsertArray("orders_total", $orderTotal);

		// Insert the products for this order
		foreach($orderData['products'] as $product) {
			$newProduct = array(
				"orders_products_id" => $product['orderprodid'],
				"orders_id" => $orderId,
				"products_id" => $product['ordprodid'],
				"products_model"=> $product['ordprodsku'],
				"products_name" => $product['ordprodname'],
				"products_price" => $product['ordprodcost'],
				"final_price" => $product['ordprodcost'],
				"products_tax" => 0,
				"products_quantity" => $product['ordprodqty']
			);
			$this->DbInsertArray("orders_products", $newProduct);
		}
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
		$GLOBALS['OSCOMMERCE_DB']->Query($query);
		return $GLOBALS['OSCOMMERCE_DB']->LastId();
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
		$GLOBALS['OSCOMMERCE_DB']->Query($query);
		return $GLOBALS['OSCOMMERCE_DB']->LastId();
	}

}

?>