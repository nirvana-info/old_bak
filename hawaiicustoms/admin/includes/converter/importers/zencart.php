<?php

/**
 * Interspire Shopping Cart ZenCart Importer.
 */
class ISC_ADMIN_CONVERTER_ZENCART extends ISC_ADMIN_CONVERTER
{
	/**
	 * @var string The title of this importer.
	 */
	var $title = "ZenCart 1.3.8";

	/**
	 * @var string The language string used for the title of the import modules page.
	 */
	var $wizardTitle = 'ZenCartImportTitle';

	/**
	 * @var string The password identifier for this importer to use when storing imported passwords.
	 */
	var $passwordIdentifier = 'zct';

	/**
	 * @var array A list of modules that this importer contains. Also includes their dependencies.
	 */
	var $_modules = array(
		"ImportCategories" => array(
			"name" => "Import ZenCart Categories",
			"description" => "This task will import the categories from your ZenCart store.",
		),
		"ImportBrands" => array(
			"name" => "Import ZenCart Brands",
			"description" => "This task will import the brand names from your ZenCart store.",
		),
		"ImportProducts" => array(
			"name" => "Import ZenCart Products",
			"description" => "This task will import the products from your ZenCart store.",
			"dependencies" => array("ImportCategories")
		),
		"ImportCustomers" => array(
			"name" => "Import ZenCart Customers",
			"description" => "This task will import the customers from your ZenCart store.",
		),
		"ImportOrders" => array(
			"name" => "Import ZenCart Orders",
			"description" => "This task will import the orders from your ZenCart store.",
		),
		"ImportUsers" => array(
			"name" => "Import ZenCart Store Administrators",
			"description" => "This task will import the store administrators from your ZenCart store.",
			"dependancies" => ""
		),
		"ImportReviews" => array(
			"name" => "Import ZenCart Product Reviews",
			"description" => "This task will import the product reviews from your ZenCart store.",
			"dependencies" => array("ImportProducts")
		),
		"ImportSubscribers" => array(
			"name" => "Import ZenCart Newsletter Subscribers",
			"description" => "This task will import the customers who've chosen to subscribe to one or more newsletters in your ZenCart store.",
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
		if(!isset($_POST['path'])) {
			$err = GetLang('NoZenCartPath');
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
			$err = sprintf(GetLang('InvalidZenCartPath'), isc_html_escape($_POST['path']), isc_html_escape($_POST['path']));
			return false;
		}
		else {
			// Grab the default ZenCart language
			require $path."/includes/configure.php";
			if(!defined('DB_PREFIX')) {
				define('DB_PREFIX', '');
			}
			$GLOBALS['ZENCART_DB'] = new MySQLDB();
			$GLOBALS['ZENCART_DB']->TablePrefix = DB_PREFIX;
			$connection = $GLOBALS['ZENCART_DB']->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

			if (!$connection) {
				list($error, $level) = $db->GetError();
				trigger_error($error, $level);
			}

			$query = "select languages_id from [|PREFIX|]languages order by sort_order asc limit 1";
			$result = $GLOBALS['ZENCART_DB']->Query($query);
			$language_id = $GLOBALS['ZENCART_DB']->FetchOne($result);

			// Get the collation/character set of one of the ZenCart tables to use as a base
			$query = "SHOW CREATE TABLE [|PREFIX|]customers";
			$result = $GLOBALS['ZENCART_DB']->Query($query);
			$tableStructure = $GLOBALS['ZENCART_DB']->Fetch($result);
			$tableStructure = array_pop($tableStructure);
			$chartset = '';
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
		$GLOBALS['HelpTitle'] = str_replace("'", "\\'", GetLang('ZenCartLocation'));
		return $this->ParseTemplate("zencart.configure", true);
	}

	/**
	 * Connec to the ZenCart database.
	 */
	function Connect()
	{
		include($this->_importSession['Configuration']['path']."/includes/configure.php");

		$GLOBALS['ZENCART_DB'] = new MySQLDB();
		$connection = $GLOBALS['ZENCART_DB']->Connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

		if($this->_Debug == true) {
			$GLOBALS['ZENCART_DB']->QueryLog = dirname(__FILE__)."/../logs/zct.queries.txt";
			$GLOBALS['ZENCART_DB']->TimeLog = dirname(__FILE__)."/../logs/zct.query_time.txt";
			$GLOBALS['ZENCART_DB']->ErrorLog = dirname(__FILE__)."/../logs/zct.db_errors.txt";
		}

	}

	/**
	 * Show the ZenCart Warning Page
	 */
	function ImportWarning()
	{
		echo $this->ParseTemplate("zencart.warning");
	}

	/**
	 * Import ZenCart orders in to the application.
	 */
	function ImportOrders()
	{
		$start = $this->_importSession['ImportOrders']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportOrders']['done'] == 0) {
			$query = "select count(orders_id) from [|PREFIX|]orders";
			$result = $GLOBALS['ZENCART_DB']->Query($query);
			$this->_importSession['ImportOrders']['count'] = $GLOBALS['ZENCART_DB']->FetchOne($query);
			$this->_importSession['ImportOrders']['done'] = 0;
		}

		$query = "
			SELECT o.*, ot1.value as ordsubtotal, ot2.value as ordtaxtotal, ot3.value as ordshipcost, ot3.title as ordshipmethod, ot4.value as ordtotalamount
			FROM [|PREFIX|]orders o
			LEFT JOIN [|PREFIX|]orders_total ot1 ON (ot1.orders_id=o.orders_id and ot1.class='ot_subtotal')
			LEFT JOIN [|PREFIX|]orders_total ot2 ON (ot2.orders_id=o.orders_id and ot2.class='ot_tax')
			LEFT JOIN [|PREFIX|]orders_total ot3 ON (ot3.orders_id=o.orders_id and ot3.class='ot_shipping')
			LEFT JOIN [|PREFIX|]orders_total ot4 ON (ot4.orders_id=o.orders_id and ot4.class='ot_total')
			ORDER BY o.orders_id ASC
		";
		$query .= $GLOBALS['ZENCART_DB']->AddLimit($start, ISC_IMPORT_ORDERS_PER_PAGE);
		$result = $GLOBALS['ZENCART_DB']->Query($query);

		while($order = $GLOBALS['ZENCART_DB']->Fetch($result)) {
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
				"ordshipcity" => $order['delivery_city'],
				'ordbillphone' => $order['customers_telephone'],
				'ordbillemail' => $order['customers_email_address'],
				"ordshipstate" => $order['delivery_state'],
				"ordshipzip" => $order['delivery_postcode'],
				"ordshipcountry" => $order['delivery_country'],
				"orddateshipped" => $this->DatetimeToUnix($order['orders_date_finished'])
			);

			$importOrder['products'] = array();

			// Fetch all of the products in this order
			$query2 = sprintf("
				SELECT op.*, p.products_weight, pd.products_attributes_filename
				FROM [|PREFIX|]orders_products op
				LEFT JOIN [|PREFIX|]products p ON (p.products_id=op.products_id)
				LEFT JOIN [|PREFIX|]products_attributes pa ON (pa.products_id=p.products_id)
				LEFT JOIN [|PREFIX|]products_attributes_download pd ON (pd.products_attributes_id=pa.products_attributes_id)
				WHERE op.orders_id='%s'",
				$order['orders_id']
			);
			$result2 = $GLOBALS['ZENCART_DB']->Query($query2);
			while($row = $GLOBALS['ZENCART_DB']->Fetch($result2)) {
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
	 * Import ZenCart products in to the application.
	 */
	function ImportProducts()
	{
		$start = $this->_importSession['ImportProducts']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportProducts']['done'] == 0) {
			$query = "select count(products_id) from [|PREFIX|]products";
			$result = $GLOBALS['ZENCART_DB']->Query($query);
			$this->_importSession['ImportProducts']['count'] = $GLOBALS['ZENCART_DB']->FetchOne($query);
			$this->_importSession['ImportProducts']['done'] = 0;
		}

		$query = sprintf("
			SELECT p.*, pd.products_name, pd.products_description, s.specials_new_products_price
			FROM [|PREFIX|]products p
			INNER JOIN [|PREFIX|]products_description pd ON (pd.products_id=p.products_id AND pd.language_id='%s')
			LEFT JOIN [|PREFIX|]specials s ON (ISNULL(s.expires_date) AND s.products_id=p.products_id)
			ORDER BY p.products_id asc
		", $this->_importSession['Configuration']['language']);
		$query .= $GLOBALS['ZENCART_DB']->AddLimit($start, ISC_IMPORT_PRODUCTS_PER_PAGE);

		$result = $GLOBALS['ZENCART_DB']->Query($query);

		while($product = $GLOBALS['ZENCART_DB']->Fetch($result)) {

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
				"prodbrandid" => $product['manufacturers_id']
			);

			// Fetch any category associations
			$importProduct['categories'] = array();
			$query2 = sprintf("select * from [|PREFIX|]products_to_categories where products_id='%s'", $product['products_id']);
			$result2 = $GLOBALS['ZENCART_DB']->Query($query2);
			while($category = $GLOBALS['ZENCART_DB']->Fetch($result2)) {
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
				from [|PREFIX|]products_attributes pa
				inner join [|PREFIX|]products_options po ON (po.language_id='%d' and po.products_options_id = pa.options_id)
				where products_id='%s' and po.products_options_type in (0, 2)
				order by pa.options_id
				",
				$this->_importSession['Configuration']['language'],
				$product['products_id']
			);

			$result2 = $GLOBALS['ZENCART_DB']->Query($query2);
			$option_names = array();
			$count = 0;
			while($row = $GLOBALS['ZENCART_DB']->Fetch($result2)) {
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
					$froms[] = sprintf('[|PREFIX|]products_attributes a%1$s', $i);
					$joins[] = sprintf('inner join [|PREFIX|]products_options_values o%1$s ON (o%1$s.products_options_values_id=a%1$s.options_values_id and o%1$s.language_id=%2$s)', $i, $this->_importSession['Configuration']['language']);
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

				$result2 = $GLOBALS['ZENCART_DB']->Query($query2);
				while($row2 = $GLOBALS['ZENCART_DB']->Fetch($result2)) {
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
				FROM [|PREFIX|]products_attributes_download pd
				INNER JOIN [|PREFIX|]products_attributes pa ON (pa.products_attributes_id=pd.products_attributes_id)
				WHERE pa.products_id='%s'",
				$product['products_id']
			);
			$result2 = $GLOBALS['ZENCART_DB']->Query($query2);
			while($row2 = $GLOBALS['ZENCART_DB']->Fetch($result2)) {
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
	 * Import ZenCart customers in to the application.
	 */
	function ImportCustomers()
	{
		$start = $this->_importSession['ImportCustomers']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportCustomers']['done'] == 0) {
			$query = "select count(customers_id) from [|PREFIX|]customers";
			$result = $GLOBALS['ZENCART_DB']->Query($query);
			$this->_importSession['ImportCustomers']['count'] = $GLOBALS['ZENCART_DB']->FetchOne($query);
			$this->_importSession['ImportCustomers']['done'] = 0;
		}
		$query = "
			SELECT c.*, ci.customers_info_date_account_created
			FROM [|PREFIX|]customers c
			LEFT JOIN [|PREFIX|]customers_info ci ON (ci.customers_info_id=c.customers_id)
			ORDER BY c.customers_id asc
		";
		$query .= $GLOBALS['ZENCART_DB']->AddLimit($start, ISC_IMPORT_CUSTOMERS_PER_PAGE);
		$result = $GLOBALS['ZENCART_DB']->Query($query);
		while($customer = $GLOBALS['ZENCART_DB']->Fetch($result)) {
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
			$query2 = sprintf("select a.*, c.countries_name as country_name from [|PREFIX|]address_book a inner join [|PREFIX|]countries c on (c.countries_id=a.entry_country_id) where a.customers_id='%s'", $customer['customers_id']);
			$result2 = $GLOBALS['ZENCART_DB']->Query($query2);
			while($address = $GLOBALS['ZENCART_DB']->Fetch($result2)) {
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
	 * Import ZenCart categories in to the application.
	 */
	function ImportCategories()
	{
		$start = $this->_importSession['ImportCategories']['done'];
		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "select count(categories_id) from [|PREFIX|]categories";
			$result = $GLOBALS['ZENCART_DB']->Query($query);
			$this->_importSession['ImportCategories']['count'] = $GLOBALS['ZENCART_DB']->FetchOne($query);
			$this->_importSession['ImportCategories']['done'] = 0;
		}

		$query = sprintf("select c.*, cl.categories_name from [|PREFIX|]categories c inner join [|PREFIX|]categories_description cl on (cl.categories_id=c.categories_id and cl.language_id='%s') order by c.categories_id asc", $this->_importSession['Configuration']['language']);
		$query .= $GLOBALS['ZENCART_DB']->AddLimit($start, ISC_IMPORT_CATEGORIES_PER_PAGE);
		$result = $GLOBALS['ZENCART_DB']->Query($query);
		while($category = $GLOBALS['ZENCART_DB']->Fetch($result)) {
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
	 * Import ZenCart brands in to the application.
	 */
	function ImportBrands()
	{
		$start = $this->_importSession['ImportBrands']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "select count(manufacturers_id) from [|PREFIX|]manufacturers";
			$result = $GLOBALS['ZENCART_DB']->Query($query);
			$this->_importSession['ImportBrands']['count'] = $GLOBALS['ZENCART_DB']->FetchOne($query);
			$this->_importSession['ImportBrands']['done'] = 0;
		}

		$query = "select * [|PREFIX|]from manufacturers order by manufacturers_id asc";
		$query .= $GLOBALS['ZENCART_DB']->AddLimit($start, ISC_IMPORT_BRANDS_PER_PAGE);
		$result = $GLOBALS['ZENCART_DB']->Query($query);
		while($brand = $GLOBALS['ZENCART_DB']->Fetch($result)) {
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
	 * Import ZenCart store administrators in to the application.
	 */
	function ImportUsers()
	{
		$start = $this->_importSession['ImportUsers']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "select count(id) from [|PREFIX|]administrators";
			$result = $GLOBALS['ZENCART_DB']->Query($query);
			$this->_importSession['ImportUsers']['count'] = $GLOBALS['ZENCART_DB']->FetchOne($query);
			$this->_importSession['ImportUsers']['done'] = 0;
		}

		$query = "select * from [|PREFIX|]administrators order by id asc";
		$query .= $GLOBALS['ZENCART_DB']->AddLimit($start, ISC_IMPORT_USERS_PER_PAGE);
		$result = $GLOBALS['ZENCART_DB']->Query($query);
		while($user = $GLOBALS['ZENCART_DB']->Fetch($result)) {
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
	 * Import ZenCart reviews in to the application.
	 */
	function ImportReviews()
	{
		$start = $this->_importSession['ImportReviews']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "select count(reviews_id) from [|PREFIX|]reviews";
			$result = $GLOBALS['ZENCART_DB']->Query($query);
			$this->_importSession['ImportReviews']['count'] = $GLOBALS['ZENCART_DB']->FetchOne($query);
			$this->_importSession['ImportReviews']['done'] = 0;
		}

		$query = sprintf("
			SELECT r.*, rd.reviews_text
			FROM [|PREFIX|]reviews r
			INNER JOIN [|PREFIX|]reviews_description rd ON (rd.reviews_id = r.reviews_id and rd.languages_id='%s')
			ORDER BY r.reviews_id ASC
		", $this->_importSession['Configuration']['language']);
		$query .= $GLOBALS['ZENCART_DB']->AddLimit($start, ISC_IMPORT_REVIEWS_PER_PAGE);
		$result = $GLOBALS['ZENCART_DB']->Query($query);
		while($review = $GLOBALS['ZENCART_DB']->Fetch($result)) {
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
	 * Import ZenCart subscribers in to the application.
	 */
	function ImportSubscribers()
	{
		$start = $this->_importSession['ImportSubscribers']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "SELECT COUNT(customers_id) FROM [|PREFIX|]customers WHERE customers_newsletter != ''";
			$result = $GLOBALS['ZENCART_DB']->Query($query);
			$this->_importSession['ImportSubscribers']['count'] = $GLOBALS['ZENCART_DB']->FetchOne($query);
			$this->_importSession['ImportSubscribers']['done'] = 0;
		}

		$query = "
			SELECT customers_id, customers_email_address, customers_firstname
			FROM [|PREFIX|]customers
			WHERE customers_newsletter != ''
			ORDER BY customers_id ASC
		";
		$query .= $GLOBALS['ZENCART_DB']->AddLimit($start, ISC_IMPORT_SUBSCRIBERS_PER_PAGE);
		$result = $GLOBALS['ZENCART_DB']->Query($query);
		while($subscriber = $GLOBALS['ZENCART_DB']->Fetch($result)) {
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