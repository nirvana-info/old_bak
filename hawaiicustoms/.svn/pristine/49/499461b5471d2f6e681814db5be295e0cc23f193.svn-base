<?php

/**
 * Interspire Shopping Cart OsCommerce Importer.
 */
class ISC_ADMIN_CONVERTER_OSCOMMERCE extends ISC_ADMIN_CONVERTER
{
	/**
	 * @var string The title of this importer.
	 */
	var $title = "OsCommerce 2.2";

	/**
	 * @var string The language string used for the title of the import modules page.
	 */
	var $wizardTitle = 'OsCommerceImportTitle';

	/**
	 * @var string The password identifier for this importer to use when storing imported passwords.
	 */
	var $passwordIdentifier = 'osc';

	/**
	 * @var array A list of modules that this importer contains. Also includes their dependencies.
	 */
	var $_modules = array(
		"ImportCategories" => array(
			"name" => "Import osCommerce Categories",
			"description" => "This task will import the categories from your OsCommerce store.",
		),
		"ImportBrands" => array(
			"name" => "Import osCommerce Brands",
			"description" => "This task will import the brand names from your OsCommerce store.",
		),
		"ImportProducts" => array(
			"name" => "Import osCommerce Products",
			"description" => "This task will import the products from your OsCommerce store.",
			"dependencies" => array("ImportCategories")
		),
		"ImportCustomers" => array(
			"name" => "Import osCommerce Customers",
			"description" => "This task will import the customers from your OsCommerce store.",
		),
		"ImportOrders" => array(
			"name" => "Import osCommerce Orders",
			"description" => "This task will import the orders from your OsCommerce store.",
		),
		"ImportUsers" => array(
			"name" => "Import osCommerce Store Administrators",
			"description" => "This task will import the store administrators from your OsCommerce store.",
			"dependancies" => ""
		),
		"ImportReviews" => array(
			"name" => "Import osCommerce Product Reviews",
			"description" => "This task will import the product reviews from your OsCommerce store.",
			"dependencies" => array("ImportProducts")
		),
		"ImportSubscribers" => array(
			"name" => "Import osCommerce Newsletter Subscribers",
			"description" => "This task will import the customers who've chosen to subscribe to one or more newsletters in your OsCommerce store.",
		)
	);

	/**
	 * Validate and save the importer configuration.
	 *
	 * @param string Any error message encountered (passed back by reference)
	 * @return mixed False on failure, if successful, array of configuration information to save.
	 */
	function SaveConfiguration(&$err)
	{
		if(!isset($_POST['osc_path'])) {
			$err = GetLang('NoOsCommercePath');
			return false;
		}

		if(isc_strpos($_POST['osc_path'], 'http://') === 0 || isc_strpos($_POST['osc_path'], 'https://') === 0) {
			$path = $this->URLToPath($_POST['osc_path'], $err);
			if(!$path) {
				return false;
			}
		}
		else {
			$path = realpath(APP_ROOT."/../".$_POST['osc_path']);
			$path = preg_replace("#[^a-z0-9\./\\:]#i", "", $path);
		}

		if(!is_dir($path) || !file_exists($path."/includes/configure.php")) {
			$err = sprintf(GetLang('InvalidOsCommercePath'), isc_html_escape($_POST['osc_path']), isc_html_escape($_POST['osc_path']));
			return false;
		}
		else {
			// Grab the default OsCommerce language
			require $path."/includes/configure.php";
			$GLOBALS['OSCOMMERCE_DB'] = new MySQLDB();
			$connection = $GLOBALS['OSCOMMERCE_DB']->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

			if (!$connection) {
				list($error, $level) = $db->GetError();
				trigger_error($error, $level);
			}

			$query = "select languages_id from languages order by sort_order asc limit 1";
			$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
			$language_id = $GLOBALS['OSCOMMERCE_DB']->FetchOne($result);

			// Get the collation/character set of one of the OsCommerce tables to use as a base
			$charset = '';
			$query = "SHOW CREATE TABLE customers";
			$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
			$tableStructure = $GLOBALS['OSCOMMERCE_DB']->Fetch($result);
			$tableStructure = array_pop($tableStructure);
			preg_match("#CHARSET=([a-zA-Z0-9_]+)\s?#i", $tableStructure, $matches);
			if(isset($matches[1]) && $matches[1] != '') {
				$charset = $matches[1];
			}
			return array(
				"path" => $path,
				"language" => $language_id,
				"charset" => $charset
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
		if(isset($_POST['path']) && $_POST['path'] != '') {
			$GLOBALS['Path'] = isc_html_escape($_POST['path']);
		}
		$GLOBALS['HelpTitle'] = str_replace("'", "\\'", GetLang('OsCommerceLocation'));
		return $this->ParseTemplate("oscommerce.configure", true);
	}

	/**
	 * Connec to the OsCommerce database.
	 */
	function Connect()
	{
		include($this->_importSession['Configuration']['path']."/includes/configure.php");

		$GLOBALS['OSCOMMERCE_DB'] = &new MySQLDB();
		$connection = $GLOBALS['OSCOMMERCE_DB']->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

		if($this->_Debug == true) {
			$GLOBALS['OSCOMMERCE_DB']->QueryLog = dirname(__FILE__)."/../logs/osc.queries.txt";
			$GLOBALS['OSCOMMERCE_DB']->TimeLog = dirname(__FILE__)."/../logs/osc.query_time.txt";
			$GLOBALS['OSCOMMERCE_DB']->ErrorLog = dirname(__FILE__)."/../logs/osc.db_errors.txt";
		}

	}

	/**
	 * Show the OsCommerce Warning Page
	 */
	function ImportWarning()
	{
		echo $this->ParseTemplate("oscommerce.warning");
	}

	/**
	 * Import OsCommerce orders in to the application.
	 */
	function ImportOrders()
	{
		$start = $this->_importSession['ImportOrders']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportOrders']['done'] == 0) {
			$query = "select count(orders_id) from orders";
			$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
			$this->_importSession['ImportOrders']['count'] = $GLOBALS['OSCOMMERCE_DB']->FetchOne($query);
			$this->_importSession['ImportOrders']['done'] = 0;
		}

		$query = "
			SELECT o.*, ot1.value as ordsubtotal, ot2.value as ordtaxtotal, ot3.value as ordshipcost, ot3.title as ordshipmethod, ot4.value as ordtotalamount
			FROM orders o
			LEFT JOIN orders_total ot1 ON (ot1.orders_id=o.orders_id and ot1.class='ot_subtotal')
			LEFT JOIN orders_total ot2 ON (ot2.orders_id=o.orders_id and ot2.class='ot_tax')
			LEFT JOIN orders_total ot3 ON (ot3.orders_id=o.orders_id and ot3.class='ot_shipping')
			LEFT JOIN orders_total ot4 ON (ot4.orders_id=o.orders_id and ot4.class='ot_total')
			ORDER BY o.orders_id ASC
		";
		$query .= $GLOBALS['OSCOMMERCE_DB']->AddLimit($start, ISC_IMPORT_ORDERS_PER_PAGE);
		$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);

		while($order = $GLOBALS['OSCOMMERCE_DB']->Fetch($result)) {
			switch($order['orders_status']) {
				case 3:
					$orderStatus = 10;
					break;
				case 2:
					$orderStatus = 9;
					break;
				default:
					$orderStatus = 1;
			}

			if(!$order['delivery_suburb']) {
				$order['delivery_suburb'] = $order['delivery_city'];
			}

			if(!$order['billing_suburb']) {
				$order['billing_suburb'] = $order['billing_city'];
			}

			$importOrder = array(
				"ordcustid" => $order['customers_id'],
				"orddate" => $this->DatetimeToUnix($order['date_purchased']),
				"ordsubtotal" => $order['ordsubtotal'],
				"ordtaxtotal" => $order['ordtaxtotal'],
				"ordshipcost" => $order['ordshipcost'],
				"ordshipmethod" => trim($order['ordshipmethod'], ":"),
				"ordtotalamount" => $order['ordtotalamount'],
				"ordstatus" => $orderStatus,
				"orderpaymentmethod" => $order['payment_method'],
				"ordbillfullname" => $order['billing_name'],
				"ordbillstreet1" => $order['billing_street_address'],
				"ordbillsuburb" => $order['billing_suburb'],
				"ordbillcity" => $order['billing_city'],
				"ordbillstate" => $order['billing_state'],
				"ordbillzip" => $order['billing_postcode'],
				"ordbillcountry" => $order['billing_country'],
				"ordshipfullname" => $order['delivery_name'],
				"ordshipstreet1" => $order['delivery_street_address'],
				"ordshipsuburb" => $order['delivery_suburb'],
				"ordshipstate" => $order['delivery_state'],
				"ordshipcity" => $order['delivery_city'],
				'ordbillphone' => $order['customers_telephone'],
				'ordbillemail' => $order['customers_email_address'],
				"ordshipzip" => $order['delivery_postcode'],
				"ordshipcountry" => $order['delivery_country'],
				"orddateshipped" => $this->DatetimeToUnix($order['orders_date_finished'])
			);

			$importOrder['products'] = array();

			// Fetch all of the products in this order
			$query2 = sprintf("
				SELECT op.*, p.products_weight, pd.products_attributes_filename
				FROM orders_products op
				LEFT JOIN products p ON (p.products_id=op.products_id)
				LEFT JOIN products_attributes pa ON (pa.products_id=p.products_id)
				LEFT JOIN products_attributes_download pd ON (pd.products_attributes_id=pa.products_attributes_id)
				WHERE op.orders_id='%s'
				GROUP BY op.orders_products_id
			",
				$order['orders_id']
			);
			$result2 = $GLOBALS['OSCOMMERCE_DB']->Query($query2);
			while($row = $GLOBALS['OSCOMMERCE_DB']->Fetch($result2)) {
				if($row['products_attributes_filename']) {
					$ordProdType = 'digital';
				}
				else {
					$ordProdType = 'physical';
				}
				$importOrder['products'][] = array(
					"orderprodsku" => $row['products_model'],
					"ordprodname" => $row['products_name'],
					"ordprodcost" => $row['final_price'],
					"ordprodweight" => $row['products_weight'],
					"ordprodqty" => $row['products_quantity'],
					"ordprodid" => $row['products_id'],
					"ordprodoptionid" => 0,
					"ordprodtype" => $ordProdType
				);
			}

			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingOrder'), $this->_importSession['ImportOrders']['done'], $this->_importSession['ImportOrders']['count']);
			$this->InsertOrder($order['orders_id'], $importOrder, $err);
			++$this->_importSession['ImportOrders']['done'];
		}
	}

	/**
	 * Import OsCommerce products in to the application.
	 */
	function ImportProducts()
	{
		$start = $this->_importSession['ImportProducts']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportProducts']['done'] == 0) {
			$query = "select count(products_id) from products";
			$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
			$this->_importSession['ImportProducts']['count'] = $GLOBALS['OSCOMMERCE_DB']->FetchOne($query);
			$this->_importSession['ImportProducts']['done'] = 0;
		}

		$query = sprintf("
			SELECT p.*, pd.products_name, pd.products_description, s.specials_new_products_price
			FROM products p
			INNER JOIN products_description pd ON (pd.products_id=p.products_id AND pd.language_id='%s')
			LEFT JOIN specials s ON (ISNULL(s.expires_date) AND s.products_id=p.products_id)
			ORDER BY p.products_id asc
		", $this->_importSession['Configuration']['language']);
		$query .= $GLOBALS['OSCOMMERCE_DB']->AddLimit($start, ISC_IMPORT_PRODUCTS_PER_PAGE);
		$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);

		while($product = $GLOBALS['OSCOMMERCE_DB']->Fetch($result)) {

			$importProduct = array(
				"prodname" => $product['products_name'],
				"prodtype" => 1,
				"prodcode" => $product['products_model'],
				"proddesc" => $product['products_description'],
				"prodprice" => $product['products_price'],
				"prodsaleprice" => $product['specials_new_products_price'],
				"prodcalculatedprice" => $product['products_price'],
				"prodcurrentinv" => $product['products_quantity'],
				"prodlowinv" => 0,
				"prodoptionsrequired" => 0,
				"prodweight" => $product['products_weight'],
				"prodinvtrack" => 0,
				"prodnumsold" => $product['products_ordered'],
				"proddateadded" => $this->DatetimeToUnix($product['products_date_added']),
				"prodbrandid" => $product['manufacturers_id'],
				"prodvisible" => $product['products_status'],
			);

			// Fetch any category associations
			$importProduct['categories'] = array();
			$query2 = sprintf("select * from products_to_categories where products_id='%s'", $product['products_id']);
			$result2 = $GLOBALS['OSCOMMERCE_DB']->Query($query2);
			while($category = $GLOBALS['OSCOMMERCE_DB']->Fetch($result2)) {
				$importProduct['categories'][] = $category['categories_id'];
			}

			// Fetch any associated images
			$importProduct['images'] = array();
			if($product['products_image'] != '') {
				$importProduct['images'][] = array(
					"imagefile" => $this->_importSession['Configuration']['path'] . "/" . DIR_WS_IMAGES . "/" . $product['products_image'],
					"imageisthumb" => 0
				);
				$importProduct['images'][] = array(
					"imagefile" => $this->_importSession['Configuration']['path'] . "/" . DIR_WS_IMAGES . "/" . $product['products_image'],
					"imageisthumb" => 1
				);
			}

			// Fetch any product options associated with this product.
			/*
			 * Note: At this stage, Interspire Shopping Cart does not support multiple option types
			 * per product. The importer will do its best to bring everything across
			 * and merge them in to one option type.
			 */
			$product['options'] = array();
			$query2 = sprintf("
				select distinct pa.options_id, po.products_options_name
				from products_attributes pa
				inner join products_options po ON (po.language_id='%d' and po.products_options_id = pa.options_id)
				where products_id='%s'
				order by pa.options_id
				",
				$this->_importSession['Configuration']['language'],
				$product['products_id']
			);
			$result2 = $GLOBALS['OSCOMMERCE_DB']->Query($query2);
			$option_names = array();
			$count = 0;
			while($row = $GLOBALS['OSCOMMERCE_DB']->Fetch($result2)) {
				++$count;
				$option_names[$count] = $row['products_options_name'];
			}

			if($count > 0) {
				// Build the query
				$selects = array();
				$froms = array();
				$wheres = array();
				$joins = array();
				for($i = 1; $i <= $count; ++$i) {
					$selects[] = "o".$i.".products_options_values_name as name_".$i.", a".$i.".options_values_price as pricediff_".$i.", a".$i.".price_prefix as priceprefix_".$i;
					$froms[] = sprintf('products_attributes a%1$s', $i);
					$joins[] = sprintf('inner join products_options_values o%1$s ON (o%1$s.products_options_values_id=a%1$s.options_values_id and o%1$s.language_id=%2$s)', $i, $this->_importSession['Configuration']['language']);
					if($i < $count) {
						$wheres[] = sprintf('a%s.options_id != a%s.options_id', $i, $i+1);
						$wheres[] = sprintf('a%s.options_id < a%s.options_id', $i, $i+1);
					}
					$wheres[] = sprintf("a%s.products_id='%s'", $i, $product['products_id']);
				}
				$query2 = sprintf("
					SELECT DISTINCT %s
					FROM (%s)
					%s
					WHERE %s
					ORDER BY a1.options_id
					",
					implode(", ", $selects),
					implode(", ", $froms),
					implode(" ", $joins),
					implode(" AND ", $wheres)
				);
				$result2 = $GLOBALS['OSCOMMERCE_DB']->Query($query2);
				while($row2 = $GLOBALS['OSCOMMERCE_DB']->Fetch($result2)) {
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



			$importProduct['downloads'] = array();
			// Does this product have any associated downloads?
			$query2 = sprintf("
				SELECT pd.*
				FROM products_attributes_download pd
				INNER JOIN products_attributes pa ON (pa.products_attributes_id=pd.products_attributes_id)
				WHERE pa.products_id='%s'",
				$product['products_id']
			);
			$result2 = $GLOBALS['OSCOMMERCE_DB']->Query($query2);
			while($row2 = $GLOBALS['OSCOMMERCE_DB']->Fetch($result2)) {
				$importProduct['downloads'][] = array(
					"downfile" => DIR_FS_DOWNLOAD . $row2['products_attributes_filename'],
					"downname" => $row2['products_attributes_filename'],
					"downmaxdownloads" => $row2['products_attributes_maxcount'],
					"downexpiresafter" => $row2['products_attributes_maxdays']*86400
				);
			}

			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingProduct'), $this->_importSession['ImportProducts']['done'], $this->_importSession['ImportProducts']['count']);
			$this->InsertProduct($product['products_id'], $importProduct, $err);
			++$this->_importSession['ImportProducts']['done'];
		}
	}

	/**
	 * Import OsCommerce customers in to the application.
	 */
	function ImportCustomers()
	{
		$start = $this->_importSession['ImportCustomers']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportCustomers']['done'] == 0) {
			$query = "select count(customers_id) from customers";
			$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
			$this->_importSession['ImportCustomers']['count'] = $GLOBALS['OSCOMMERCE_DB']->FetchOne($query);
			$this->_importSession['ImportCustomers']['done'] = 0;
		}
		$query = "
			SELECT c.*, ci.customers_info_date_account_created
			FROM customers c
			LEFT JOIN customers_info ci ON (ci.customers_info_id=c.customers_id)
			ORDER BY c.customers_id asc
		";
		$query .= $GLOBALS['OSCOMMERCE_DB']->AddLimit($start, ISC_IMPORT_CUSTOMERS_PER_PAGE);
		$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
		while($customer = $GLOBALS['OSCOMMERCE_DB']->Fetch($result)) {
			$importCustomer = array(
				"custpassword" => $customer['customers_password'],
				"custconfirstname" => $customer['customers_firstname'],
				"custconlastname" => $customer['customers_lastname'],
				"custconemail" => $customer['customers_email_address'],
				"custconphone" => $customer['customers_telephone'],
				"custdatejoined" => $this->DatetimeToUnix($customer['customers_info_date_account_created'])
			);

			// Does this customer have any shipping addresses we need to import?
			$importCustomer['addresses'] = array();
			$query2 = sprintf("select a.*, c.countries_name as country_name from address_book a inner join countries c on (c.countries_id=a.entry_country_id) where a.customers_id='%s'", $customer['customers_id']);
			$result2 = $GLOBALS['OSCOMMERCE_DB']->Query($query2);
			while($address = $GLOBALS['OSCOMMERCE_DB']->Fetch($result2)) {
				$importCustomer['addresses'][] = array(
					"shipfullname" => $address['entry_firstname']." ".$address['entry_lastname'],
					"shipaddress1" => $address['entry_street_address'],
					"shipcity" => $address['entry_city'],
					"shipstate" => $address['entry_state'],
					"shipzip" => $address['entry_postcode'],
					"shipcountry" => $address['country_name'],
					"shipphone" => $customer['customers_telephone'],
					"shipdestination" => "residential"
				);
			}
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingCustomer'), $this->_importSession['ImportCustomers']['done'], $this->_importSession['ImportCustomers']['count']);
			$this->InsertCustomer($customer['customers_id'], $importCustomer, $err);
			++$this->_importSession['ImportCustomers']['done'];
		}
	}

	/**
	 * Import OsCommerce categories in to the application.
	 */
	function ImportCategories()
	{
		$start = $this->_importSession['ImportCategories']['done'];
		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "select count(categories_id) from categories";
			$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
			$this->_importSession['ImportCategories']['count'] = $GLOBALS['OSCOMMERCE_DB']->FetchOne($query);
			$this->_importSession['ImportCategories']['done'] = 0;
		}

		$query = sprintf("select c.*, cl.categories_name from categories c inner join categories_description cl on (cl.categories_id=c.categories_id and cl.language_id='%s') order by c.categories_id asc", $this->_importSession['Configuration']['language']);
		$query .= $GLOBALS['OSCOMMERCE_DB']->AddLimit($start, ISC_IMPORT_CATEGORIES_PER_PAGE);
		$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
		while($category = $GLOBALS['OSCOMMERCE_DB']->Fetch($result)) {
			$importCategory = array(
				"catparentid" => $category['parent_id'],
				"catname" => $category['categories_name'],
				"catsort" => $category['sort_order']
			);
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingCategory'), $this->_importSession['ImportCategories']['done'], $this->_importSession['ImportCategories']['count']);
			$this->InsertCategory($category['categories_id'], $importCategory, $err);
			++$this->_importSession['ImportCategories']['done'];
		}
	}

	/**
	 * Import OsCommerce brands in to the application.
	 */
	function ImportBrands()
	{
		$start = $this->_importSession['ImportBrands']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "select count(manufacturers_id) from manufacturers";
			$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
			$this->_importSession['ImportBrands']['count'] = $GLOBALS['OSCOMMERCE_DB']->FetchOne($query);
			$this->_importSession['ImportBrands']['done'] = 0;
		}

		$query = "select * from manufacturers order by manufacturers_id asc";
		$query .= $GLOBALS['OSCOMMERCE_DB']->AddLimit($start, ISC_IMPORT_BRANDS_PER_PAGE);
		$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
		while($brand = $GLOBALS['OSCOMMERCE_DB']->Fetch($result)) {
			$importBrand = array(
				"brandname" => $brand['manufacturers_name']
			);
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingBrand'), $this->_importSession['ImportBrands']['done'], $this->_importSession['ImportBrands']['count']);
			$this->InsertBrand($brand['manufacturers_id'], $importBrand, $err);
			++$this->_importSession['ImportBrands']['done'];
		}
	}

	/**
	 * Import OsCommerce store administrators in to the application.
	 */
	function ImportUsers()
	{
		$start = $this->_importSession['ImportUsers']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "select count(id) from administrators";
			$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
			$this->_importSession['ImportUsers']['count'] = $GLOBALS['OSCOMMERCE_DB']->FetchOne($query);
			$this->_importSession['ImportUsers']['done'] = 0;
		}

		$query = "select * from administrators order by id asc";
		$query .= $GLOBALS['OSCOMMERCE_DB']->AddLimit($start, ISC_IMPORT_USERS_PER_PAGE);
		$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
		while($user = $GLOBALS['OSCOMMERCE_DB']->Fetch($result)) {
			$importUser = array(
				"username" => $user['user_name'],
				"userpass" => $user['user_password'],
				"userfirstname" => $user['user_name'],
				"userstatus" => 1
			);
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingUser'), $this->_importSession['ImportUsers']['done'], $this->_importSession['ImportUsers']['count']);
			$this->InsertUser($user['id'], $importUser, $err);
			++$this->_importSession['ImportUsers']['done'];
		}
	}

	/**
	 * Import OsCommerce reviews in to the application.
	 */
	function ImportReviews()
	{
		$start = $this->_importSession['ImportReviews']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "select count(reviews_id) from reviews";
			$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
			$this->_importSession['ImportReviews']['count'] = $GLOBALS['OSCOMMERCE_DB']->FetchOne($query);
			$this->_importSession['ImportReviews']['done'] = 0;
		}

		$query = sprintf("
			SELECT r.*, rd.reviews_text
			FROM reviews r
			INNER JOIN reviews_description rd ON (rd.reviews_id = r.reviews_id and rd.languages_id='%s')
			ORDER BY r.reviews_id ASC
		", $this->_importSession['Configuration']['language']);
		$query .= $GLOBALS['OSCOMMERCE_DB']->AddLimit($start, ISC_IMPORT_REVIEWS_PER_PAGE);
		$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
		while($review = $GLOBALS['OSCOMMERCE_DB']->Fetch($result)) {
			$importReview = array(
				"revproductid" => $review['products_id'],
				"revfromname" => $review['customers_name'],
				"revdate" => $this->DatetimeToUnix($review['date_added']),
				"revrating" => $review['reviews_rating'],
				"revtext" => $review['reviews_text'],
				"revstats" => 1
			);
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingReview'), $this->_importSession['ImportReviews']['done'], $this->_importSession['ImportReviews']['count']);
			$this->InsertReview($review['reviews_id'], $importReview, $err);
			++$this->_importSession['ImportReviews']['done'];
		}
	}

	/**
	 * Import OsCommerce subscribers in to the application.
	 */
	function ImportSubscribers()
	{
		$start = $this->_importSession['ImportSubscribers']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "SELECT COUNT(customers_id) FROM customers WHERE customers_newsletter != ''";
			$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
			$this->_importSession['ImportSubscribers']['count'] = $GLOBALS['OSCOMMERCE_DB']->FetchOne($query);
			$this->_importSession['ImportSubscribers']['done'] = 0;
		}

		$query = "
			SELECT customers_id, customers_email_address, customers_firstname
			FROM customers
			WHERE customers_newsletter != ''
			ORDER BY customers_id ASC
		";
		$query .= $GLOBALS['OSCOMMERCE_DB']->AddLimit($start, ISC_IMPORT_SUBSCRIBERS_PER_PAGE);
		$result = $GLOBALS['OSCOMMERCE_DB']->Query($query);
		while($subscriber = $GLOBALS['OSCOMMERCE_DB']->Fetch($result)) {
			$importSubscriber = array(
				"subemail" => $subscriber['customers_email_address'],
				"subfirstname" => $subscriber['customers_firstname']
			);

			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingSubscriber'), $this->_importSession['ImportSubscribers']['done'], $this->_importSession['ImportSubscribers']['count']);
			$this->InsertSubscriber($subscriber['customers_id'], $importSubscriber, $err);
			++$this->_importSession['ImportSubscribers']['done'];
		}
	}
}

?>