<?php

/**
 * Interspire Shopping Cart Cubecart 4.0 Importer.
 */
class ISC_ADMIN_CONVERTER_CUBECART4 extends ISC_ADMIN_CONVERTER
{
	/**
	 * @var string The title of this importer.
	 */
	var $title = "CubeCart 4.0";

	/**
	 * @var string The language string used for the title of the import modules page.
	 */
	var $wizardTitle = 'CubeCartImportTitle';

	/**
	 * @var string The password identifier for this importer to use when storing imported passwords.
	 */
	var $passwordIdentifier = 'cc4';

	/**
	 * @var boolean Array of import field types that this importer does differently (ie, if it needs a text field instead of int)
	 */
	var $_importFieldsType = array(
		"orders" => array(
			"importorderid" => "varchar"
		),
		"subscribers" => array(
			"importsubscriberid" => "varchar"
		)
	);

	/**
	 * @var array A list of modules that this importer contains. Also includes their dependencies.
	 */
	var $_modules = array(
		"ImportCategories" => array(
			"name" => "Import CubeCart Categories",
			"description" => "This task will import the categories from your CubeCart store.",
		),
		"ImportProducts" => array(
			"name" => "Import CubeCart Products",
			"description" => "This task will import the products from your CubeCart store.",
			"dependencies" => array("ImportCategories")
		),
		"ImportCustomers" => array(
			"name" => "Import CubeCart Customers",
			"description" => "This task will import the customers from your CubeCart store.",
		),
		"ImportOrders" => array(
			"name" => "Import CubeCart Orders",
			"description" => "This task will import the orders from your CubeCart store.",
		),
		"ImportUsers" => array(
			"name" => "Import CubeCart Store Administrators",
			"description" => "This task will import the store administrators from your CubeCart store.",
			"dependancies" => ""
		),
		"ImportReviews" => array(
			"name" => "Import CubeCart Product Reviews",
			"description" => "This task will import the product reviews from your CubeCart store.",
			"dependencies" => array("ImportProducts")
		),
		"ImportSubscribers" => array(
			"name" => "Import CubeCart Newsletter Subscribers",
			"description" => "This task will import any newsletter subscribers in your CubeCart store.",
		),
	);

	/**
	 * Validate and save the importer configuration.
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
			$err = sprintf(GetLang('InvalidCubeCartPath'), isc_html_excape($_POST['cubecart4_path']), isc_html_escape($_POST['cubecart4_path']));
			return false;
		}
		else {
			return array(
				"path" => $path
			);
		}
	}

	/**
	 * Fetch the configuration form for this importer.
	 *
	 * @return string The HTML configuration page for this importer.
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
	 * Show the CubeCart Warning Page
	 */
	function ImportWarning()
	{
		echo $this->ParseTemplate("cubecart4.warning");
	}

	/**
	 * Connec to the Cubecart database.
	 */
	function Connect()
	{
		@include($this->_importSession['Configuration']['path']."/includes/global.inc.php");

		$GLOBALS['CUBECART_DB'] = &new MySQLDB();
		$connection = $GLOBALS['CUBECART_DB']->Connect($glob['dbhost'], $glob['dbusername'], $glob['dbpassword'], $glob['dbdatabase']);
		$GLOBALS['CUBECART_DB']->TablePrefix = $glob['dbprefix'];
		if($this->_Debug == true) {
			$GLOBALS['CUBECART_DB']->QueryLog = dirname(__FILE__)."/../logs/cc4.queries.txt";
			$GLOBALS['CUBECART_DB']->TimeLog = dirname(__FILE__)."/../logs/cc4.query_time.txt";
			$GLOBALS['CUBECART_DB']->ErrorLog = dirname(__FILE__)."/../logs/cc4.db_errors.txt";
		}

	}

	/**
	 * Import Cubecart categories in to the application.
	 */
	function ImportCategories()
	{
		$start = $this->_importSession['ImportCategories']['done'];
		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "SELECT COUNT(cat_id) FROM [|PREFIX|]CubeCart_category";
			$result = $GLOBALS['CUBECART_DB']->Query($query);
			$this->_importSession['ImportCategories']['count'] = $GLOBALS['CUBECART_DB']->FetchOne($query);
			$this->_importSession['ImportCategories']['done'] = 0;
		}

		$query = "SELECT * FROM [|PREFIX|]CubeCart_category ORDER BY cat_id ASC";
		$query .= $GLOBALS['CUBECART_DB']->AddLimit($start, ISC_IMPORT_CATEGORIES_PER_PAGE);
		$result = $GLOBALS['CUBECART_DB']->Query($query);
		while($category = $GLOBALS['CUBECART_DB']->Fetch($result)) {
			$importCategory = array(
				"catparentid" => $category['cat_father_id'],
				"catname" => $category['cat_name'],
				"catdesc" => $category['cat_desc'],
				"catsort" => $category['priority']
			);
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingCategory'), $this->_importSession['ImportCategories']['done'], $this->_importSession['ImportCategories']['count']);
			$this->InsertCategory($category['cat_id'], $importCategory, $err);
			++$this->_importSession['ImportCategories']['done'];
		}
	}

	/**
	 * Import CubeCart orders in to the application.
	 */
	function ImportOrders()
	{
		$start = $this->_importSession['ImportOrders']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportOrders']['done'] == 0) {
			$query = "SELECT COUNT(cart_order_id) FROM [|PREFIX|]CubeCart_order_sum";
			$result = $GLOBALS['CUBECART_DB']->Query($query);
			$this->_importSession['ImportOrders']['count'] = $GLOBALS['CUBECART_DB']->FetchOne($query);
			$this->_importSession['ImportOrders']['done'] = 0;
		}

		$query = "SELECT * FROM [|PREFIX|]CubeCart_order_sum ORDER BY cart_order_id ASC";
		$query .= $GLOBALS['CUBECART_DB']->AddLimit($start, ISC_IMPORT_ORDERS_PER_PAGE);
		$result = $GLOBALS['CUBECART_DB']->Query($query);

		while($order = $GLOBALS['CUBECART_DB']->Fetch($result)) {
			switch($order['status']) {
				case 1:
					$orderStatus = 1;
					break;
				case 2:
					$orderStatus = 9;
					break;
				case 3:
					$orderStatus = 10;
					break;
				case 4:
				case 5:
					$orderStatus = 6;
					break;
				case 6:
					$orderStatus = 5;
					break;
				default:
					$orderStatus = 1;
			}

			$importOrder = array(
				"ordcustid" => $order['customer_id'],
				"orddate" => $order['time'],
				"ordsubtotal" => $order['subtotal'],
				"ordtaxtotal" => $order['total_tax'],
				"ordshipcost" => $order['total_ship'],
				"ordshipmethod" => $order['shipMethod'],
				"ordtotalamount" => $order['subtotal']+$order['total_tax']+$order['total_ship'],
				"ordstatus" => $orderStatus,
				"orderpaymentmethod" => $order['gateway'],
				"ordbillfullname" => $order['name'],
				"ordbillstreet1" => $order['add_1'],
				"ordbillstreet2" => $order['add_2'],
				"ordbillsuburb" => $order['town'],
				"ordbillstate" => $order['county'],
				"ordbillzip" => $order['postcode'],
				"ordbillcountry" => $order['country'],
				"ordshipfullname" => $order['name_d'],
				"ordshipstreet1" => $order['add_1_d'],
				"ordshipstreet2" => $order['add_2_d'],
				"ordshipsuburb" => $order['town_d'],
				"ordshipstate" => $order['county_d'],
				"ordshipzip" => $order['postcode_d'],
				"ordshipcountry" => $order['country_d'],
				"ordtrackingno" => $order['courier_tracking']
			);

			$importOrder['products'] = array();

			// Fetch all of the products in this order
			$query2 = sprintf("SELECT * FROM [|PREFIX|]CubeCart_order_inv WHERE cart_order_id='%s'", $order['cart_order_id']);
			$result2 = $GLOBALS['CUBECART_DB']->Query($query2);
			while($row = $GLOBALS['CUBECART_DB']->Fetch($result2)) {
				if($row['digital'] == 1) {
					$prodType = 'digital';
				}
				else {
					$prodType = 'physical';
				}
				$importOrder['products'][] = array(
					"ordprodsku" => $row['productCode'],
					"ordprodname" => $row['name'],
					"ordprodtype" => $prodType,
					"ordprodcost" => $row['price'],
					"ordprodqty" => $row['quantity'],
					"ordprodid" => $row['productId']
				);
			}

			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingOrder'), $this->_importSession['ImportOrders']['done'], $this->_importSession['ImportOrders']['count']);
			$this->InsertOrder($order['cart_order_id'], $importOrder, $err);
			++$this->_importSession['ImportOrders']['done'];
		}
	}

	/**
	 * Import CubeCart customers in to the application.
	 */
	function ImportCustomers()
	{
		$start = $this->_importSession['ImportCustomers']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportCustomers']['done'] == 0) {
			$query = "SELECT COUNT(customer_id) FROM [|PREFIX|]CubeCart_customer";
			$result = $GLOBALS['CUBECART_DB']->Query($query);
			$this->_importSession['ImportCustomers']['count'] = $GLOBALS['CUBECART_DB']->FetchOne($query);
			$this->_importSession['ImportCustomers']['done'] = 0;
		}

		$query = "SELECT * FROM [|PREFIX|]CubeCart_customer ORDER BY customer_id ASC";
		$query .= $GLOBALS['CUBECART_DB']->AddLimit($start, ISC_IMPORT_CUSTOMERS_PER_PAGE);
		$result = $GLOBALS['CUBECART_DB']->Query($query);
		while($customer = $GLOBALS['CUBECART_DB']->Fetch($result)) {
			$importCustomer = array(
				"custpassword" => $customer['password'],
				"custconfirstname" => $customer['firstName'],
				"custconlastname" => $customer['lastName'],
				"custconcompany" => $customer['companyName'],
				"custconemail" => $customer['email'],
				"custconphone" => $customer['phone'],
				"custdatejoined" => $customer['regTime']
			);

			// Create the shipping address for this user
			$importCustomer['addresses'] = array();
			$importCustomer['addresses'][] = array(
				"shipfullname" => $customer['firstName'].' '.$customer['lastName'],
				"shipaddress1" => $customer['add_1'],
				"shipaddress2" => $customer['add_2'],
				"shipcity" => $customer['town'],
				"shipstate" => $customer['county'],
				"shipzip" => $customer['postcode'],
				"shipcountry" => $customer['country'],
				"shipphone" => $customer['phone'],
				"shipdestination" => "residential"
			);

			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingCustomer'), $this->_importSession['ImportCustomers']['done'], $this->_importSession['ImportCustomers']['count']);
			$this->InsertCustomer($customer['customer_id'], $importCustomer, $err);
			++$this->_importSession['ImportCustomers']['done'];
		}
	}

	/**
	 * Import CubeCart reviews in to the application.
	 */
	function ImportReviews()
	{
		$start = $this->_importSession['ImportReviews']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "SELECT COUNT(id) FROM [|PREFIX|]CubeCart_reviews";
			$result = $GLOBALS['CUBECART_DB']->Query($query);
			$this->_importSession['ImportReviews']['count'] = $GLOBALS['CUBECART_DB']->FetchOne($query);
			$this->_importSession['ImportReviews']['done'] = 0;
		}

		$query = "SELECT * FROM [|PREFIX|]CubeCart_reviews ORDER BY id ASC";
		$query .= $GLOBALS['CUBECART_DB']->AddLimit($start, ISC_IMPORT_REVIEWS_PER_PAGE);
		$result = $GLOBALS['CUBECART_DB']->Query($query);
		while($review = $GLOBALS['CUBECART_DB']->Fetch($result)) {
			$importReview = array(
				"revproductid" => $review['productId'],
				"revfromname" => $review['name'],
				"revdate" => $review['time'],
				"revrating" => $review['rating'],
				"revtext" => $review['review'],
				"revtitle" => $review['title'],
				"revstatus" => $review['approved']
			);
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingReview'), $this->_importSession['ImportReviews']['done'], $this->_importSession['ImportReviews']['count']);
			$this->InsertReview($review['id'], $importReview, $err);
			++$this->_importSession['ImportReviews']['done'];
		}
	}

	/**
	 * Import CubeCart customers in to the application.
	 */
	function ImportUsers()
	{
		$start = $this->_importSession['ImportUsers']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportUsers']['done'] == 0) {
			$query = "SELECT COUNT(adminId) FROM [|PREFIX|]CubeCart_admin_users";
			$result = $GLOBALS['CUBECART_DB']->Query($query);
			$this->_importSession['ImportUsers']['count'] = $GLOBALS['CUBECART_DB']->FetchOne($query);
			$this->_importSession['ImportUsers']['done'] = 0;
		}

		$query = "SELECT * FROM [|PREFIX|]CubeCart_admin_users ORDER BY adminId ASC";
		$query .= $GLOBALS['CUBECART_DB']->AddLimit($start, ISC_IMPORT_USERS_PER_PAGE);
		$result = $GLOBALS['CUBECART_DB']->Query($query);
		while($user = $GLOBALS['CUBECART_DB']->Fetch($result)) {
			$importUser = array(
				"username" => $user['username'],
				"userpass" => $user['password'],
				"userfirstname" => $user['name'],
				"useremail" => $user['email']
			);
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingUser'), $this->_importSession['ImportUsers']['done'], $this->_importSession['ImportUsers']['count']);
			$this->InsertUser($user['adminId'], $importUser, $err);
			++$this->_importSession['ImportUsers']['done'];
		}
	}

	/**
	 * Import CubeCart subscribers in to the application.
	 */
	function ImportSubscribers()
	{
		$start = $this->_importSession['ImportSubscribers']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "SELECT COUNT(customer_id) FROM [|PREFIX|]CubeCart_customer WHERE optIn1st=1";
			$result = $GLOBALS['CUBECART_DB']->Query($query);
			$this->_importSession['ImportSubscribers']['count'] = $GLOBALS['CUBECART_DB']->FetchOne($query);
			$this->_importSession['ImportSubscribers']['done'] = 0;
		}

		$query = "SELECT customer_id, email, firstName FROM [|PREFIX|]CubeCart_customer WHERE optIn1st=1 ORDER BY customer_id ASC";
		$query .= $GLOBALS['CUBECART_DB']->AddLimit($start, ISC_IMPORT_SUBSCRIBERS_PER_PAGE);
		$result = $GLOBALS['CUBECART_DB']->Query($query);
		while($subscriber = $GLOBALS['CUBECART_DB']->Fetch($result)) {
			$importSubscriber = array(
				"subemail" => $subscriber['email'],
				"subfirstname" => $subscriber['firstName']
			);

			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingSubscriber'), $this->_importSession['ImportSubscribers']['done'], $this->_importSession['ImportSubscribers']['count']);
			$this->InsertSubscriber($subscriber['customer_id'], $importSubscriber, $err);
			++$this->_importSession['ImportSubscribers']['done'];
		}
	}

	/**
	 * Import CubeCart products in to the application.
	 */
	function ImportProducts()
	{
		$start = $this->_importSession['ImportProducts']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportProducts']['done'] == 0) {
			$query = "SELECT COUNT(productId) FROM [|PREFIX|]CubeCart_inventory";
			$result = $GLOBALS['CUBECART_DB']->Query($query);
			$this->_importSession['ImportProducts']['count'] = $GLOBALS['CUBECART_DB']->FetchOne($query);
			$this->_importSession['ImportProducts']['done'] = 0;
		}

		$query = "SELECT * FROM [|PREFIX|]CubeCart_inventory ORDER BY productId ASC";
		$query .= $GLOBALS['CUBECART_DB']->AddLimit($start, ISC_IMPORT_PRODUCTS_PER_PAGE);
		$result = $GLOBALS['CUBECART_DB']->Query($query);
		while($product = $GLOBALS['CUBECART_DB']->Fetch($result)) {
			$importProduct = array(
				"prodname" => $product['name'],
				"prodcode" => $product['productCode'],
				"proddesc" => $product['description'],
				"prodprice" => $product['price'],
				"prodsaleprice" => $product['sale_price'],
				"prodfeatured" => $product['showFeatured'],
				"prodcurrentinv" => $product['stock_level'],
				"prodlowinv" => $product['stockWarn'],
				"prodtrackinv" => $product['useStockLevel'],
				"prodweight" => $product['prodWeight'],
				"prodnumsold" => $product['popularity']
			);

			// Fetch any category associations
			$importProduct['categories'] = array();
			$query2 = sprintf("SELECT * FROM [|PREFIX|]CubeCart_cats_idx WHERE productid='%s'", $product['productId']);
			$result2 = $GLOBALS['CUBECART_DB']->Query($query2);
			while($category = $GLOBALS['CUBECART_DB']->Fetch($result2)) {
				$importProduct['categories'][] = $category['cat_id'];
			}

			$importProduct['images'] = array();

			// Get the primary image for this product
			if($product['image'] != '') {
				$importProduct['images'][] = array(
					"imagefile" => $this->_importSession['Configuration']['path'] . "/images/uploads/" . $product['image']
				);
				if(file_exists($this->_importSession['Configuration']['path'] . "/thumbs/thumb_". $product['image'])) {
					$importProduct['images'][] = array(
						"imagefile" => $this->_importSession['Configuration']['path'] . "/images/uploads/" . "thumbs/thumb_". $product['image'],
						"imageisthumb" => 1
					);
				}
			}

			// Are there any other images for this product?
			if($product['noImages'] > 0) {
				$query2 = sprintf("SELECT * FROM [|PREFIX|]CubeCart_img_idx WHERE productId='%d' ORDER BY id", $product['productId']);
				while($row2 = $GLOBALS['XCART_DB']->Fetch($row2)) {
					$importProduct['images'][] = array(
						"imagefile" => $this->_importSession['Configuration']['path'] . "/images/uploads/" . $row2['img']
					);
				}
			}

			// Does this product have a digital download?
			if($product['digitalDir'] != '') {
				$importProduct['downloads'] = array();
				$importProduct['downloads'][] = array(
					"downfile" => $this->_importSession['Configuration']['path'] . "/" . $product['digitalDir']
				);
			}

			// Fetch any product options associated with this product.
			$query2 = sprintf("
				SELECT t.option_name, b.value_id
				FROM [|PREFIX|]CubeCart_options_top t
				INNER JOIN [|PREFIX|]CubeCart_options_bot b ON (b.option_id=t.option_id)
				WHERE b.product='%s'
				ORDER BY b.value_id",
				$product['productId']);
			$result2 = $GLOBALS['CUBECART_DB']->Query($query2);
			$option_names = array();
			$count = 0;
			$option_ids = array();
			while($row = $GLOBALS['CUBECART_DB']->Fetch($result2)) {
				++$count;
				$option_names[$count] = $row['option_name'];
				$option_ids[] = $row['value_id'];
			}

			echo $query2;
			echo "\n\n\n\n<br />";

			if($count > 0) {
				// Build the query
				$selects = array();
				$froms = array();
				$wheres = array();
				$joins = array();

				for($i = 1; $i <= $count; ++$i) {
					$selects[] = "o".$i.".value_name as name_".$i.", b".$i.".option_price as pricediff_".$i.", b".$i.".option_symbol as priceprefix_".$i;
					$froms[] = sprintf('[|PREFIX|]CubeCart_options_mid o%1$s', $i);
					$father_id = array_shift($option_ids);
					$wheres[] = sprintf("o%s.father_id='%s'", $i, $father_id);
					$joins[] = "LEFT JOIN [|PREFIX|]CubeCart_options_bot b".$i." ON (b".$i.".product='".$product['productId']."' AND b".$i.".value_id=o".$i.".value_id)";
				}

				$query2 = sprintf("
					SELECT DISTINCT %s
					FROM (%s)
					%s
					WHERE %s
					ORDER BY b1.value_id",
					implode(", ", $selects),
					implode(", ", $froms),
					implode(" ", $joins),
					implode(" AND ", $wheres)
				);
				$result2 = $GLOBALS['CUBECART_DB']->Query($query2);
				while($row2 = $GLOBALS['CUBECART_DB']->Fetch($result2)) {
					$price = 0;
					$priceType = '';
					$options = array();
					foreach($option_names as $k => $optname) {
						if(!isset($row2['name_'.$k])) {
							continue;
						}
						$options[$optname] = $row2['name_'.$k];
						$priceAdjustment = $row2['pricediff_'.$k];
						$adjustType = $row2['priceprefix_'.$k];
						if($adjustType == '+') {
							$price += $priceAdjustment;
						}
						else if($adjustType == '-') {
							$price -= $priceAdjustment;
						}
					}

					// Build the combination
					if($price < 0) {
						$price = substr($price, 1);
						$priceType = 'subtract';
					}
					else if($price > 0) {
						$priceType = 'add';
					}
					else {
						$priceType = '';
					}
					$id = md5(strtolower(implode(",", $options)));
					if(isset($importProduct['variations'][$id])) {
						$importProduct['variations'][$id]['vcprice'] += $price;
					}
					else {
						$importProduct['variations'][$id] = array(
							"options" => $options,
							"vcpricediff" => $priceType,
							"vcprice" => $price
						);
					}
				}
				$importProduct['prodoptionsrequired'] = 1;
			}

			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingProduct'), $this->_importSession['ImportProducts']['done'], $this->_importSession['ImportProducts']['count']);
			$this->InsertProduct($product['productId'], $importProduct, $err);
			++$this->_importSession['ImportProducts']['done'];
		}
	}
}

?>