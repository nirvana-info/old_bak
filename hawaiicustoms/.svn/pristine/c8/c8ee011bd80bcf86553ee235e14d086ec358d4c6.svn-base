<?php

/**
 * Interspire Shopping Cart X-Cart Importer.
 */
class ISC_ADMIN_CONVERTER_XCART extends ISC_ADMIN_CONVERTER
{
	/**
	 * @public string The title of this importer.
	 */
	public $title = "X-Cart 4.1";

	/**
	 * @public string The language string used for the title of the import modules page.
	 */
	public $wizardTitle = 'XCartImportTitle';

	/**
	 * @public string The password identifier for this importer to use when storing imported passwords.
	 */
	public $passwordIdentifier = 'xca';

	/**
	 * @public boolean Array of import field types that this importer does differently (ie, if it needs a text field instead of int)
	 */
	public $_importFieldsType = array(
		"customers" => array(
			"importcustomerid" => "varchar"
		)
	);

	/**
	 * @public array A list of modules that this importer contains. Also includes their dependencies.
	 */
	public $_modules = array(
		"ImportCategories" => array(
			"name" => "Import X-Cart Categories",
			"description" => "This task will import the categories from your X-Cart store.",
		),
		"ImportBrands" => array(
			"name" => "Import X-Cart Brands",
			"description" => "This task will import the brand names from your X-Cart store.",
		),
		"ImportProducts" => array(
			"name" => "Import X-Cart Products",
			"description" => "This task will import the products from your X-Cart store.",
			"dependencies" => array("ImportCategories")
		),
		"ImportCustomers" => array(
			"name" => "Import X-Cart Customers",
			"description" => "This task will import the customers from your X-Cart store.",
		),
		"ImportOrders" => array(
			"name" => "Import X-Cart Orders",
			"description" => "This task will import the orders from your X-Cart store.",
		),
		"ImportUsers" => array(
			"name" => "Import X-Cart Store Administrators",
			"description" => "This task will import the store administrators from your X-Cart store.",
			"dependancies" => ""
		),
		"ImportReviews" => array(
			"name" => "Import X-Cart Product Reviews",
			"description" => "This task will import the product reviews from your X-Cart store.",
			"dependencies" => array("ImportProducts")
		),
		"ImportSubscribers" => array(
			"name" => "Import X-Cart Newsletter Subscribers",
			"description" => "This task will import any newsletter subscribers in your X-Cart store.",
		),
		"ImportWishlists" => array(
			"name" => "Import X-Cart Customer Wishlists",
			"description" => "This task will import any customer wishlists from your X-Cart store.",
			"dependencies" => array("ImportProducts", "ImportCustomers")
		)
	);

	/**
	 * Validate and save the importer configuration.
	 *
	 * @param string Any error message encountered (passed back by reference)
	 * @return mixed False on failure, if successful, array of configuration information to save.
	 */
	public function SaveConfiguration(&$err)
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

		if(!is_dir($path) && !file_exists($path."/config.php")) {
			$err = sprintf(GetLang('InvalidXCartPath'), isc_html_escape($_POST['xcart_path']), isc_html_escape($_POST['xcart_path']));
			return false;
		}
		else {
			// Grab the default X-Cart language
			define("XCART_START", 1);
			$xcart_dir = $path;
			require $path."/config.php";
			$GLOBALS['XCART_DB'] = &new MySQLDB();
			$connection = $GLOBALS['XCART_DB']->Connect($sql_host, $sql_user, $sql_password, $sql_db);

			return array(
				"path" => $path,
				"blowfish_key" => $blowfish_key,
				'downloads_path' => $path
			);
		}
	}

	/**
	 * Fetch the configuration form for this importer.
	 *
	 * @return string The HTML configuration page for this importer.
	 */
	public function Configure()
	{
		$GLOBALS['Path'] = 'http://';
		if(isset($_POST['xcart_path']) && $_POST['xcart_path'] != '') {
			$GLOBALS['Path'] = isc_html_escape($_POST['xcart_path']);
		}
		$GLOBALS['HelpTitle'] = str_replace("'", "\\'", GetLang('XCartLocation'));
		return $this->ParseTemplate("xcart.configure", true);
	}

	/**
	 * Show the X-Cart Warning Page
	 */
	public function ImportWarning()
	{
		echo $this->ParseTemplate("xcart.warning");
	}

	/**
	 * Connec to the X-Cart database.
	 */
	public function Connect()
	{
		define("XCART_START", 1);
		$xcart_dir = $this->_importSession['Configuration']['path'];
		@include($this->_importSession['Configuration']['path']."/config.php");
		$GLOBALS['XCART_DB'] = &new MySQLDB();
		$connection = $GLOBALS['XCART_DB']->Connect($sql_host, $sql_user, $sql_password, $sql_db);
		if($this->_Debug == true) {
			$GLOBALS['XCART_DB']->QueryLog = dirname(__FILE__)."/../logs/xct.queries.txt";
			$GLOBALS['XCART_DB']->TimeLog = dirname(__FILE__)."/../logs/xct.query_time.txt";
			$GLOBALS['XCART_DB']->ErrorLog = dirname(__FILE__)."/../logs/xct.db_errors.txt";
		}
	}

	/**
	 * Import X-Cart categories in to the application.
	 */
	public function ImportCategories()
	{
		$start = $this->_importSession['ImportCategories']['done'];
		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "select count(categoryid) from xcart_categories";
			$result = $GLOBALS['XCART_DB']->Query($query);
			$this->_importSession['ImportCategories']['count'] = $GLOBALS['XCART_DB']->FetchOne($query);
			$this->_importSession['ImportCategories']['done'] = 0;
		}

		$query = "
			SELECT *
			FROM xcart_categories
			ORDER BY categoryid ASC
		";
		$query .= $GLOBALS['XCART_DB']->AddLimit($start, ISC_IMPORT_CATEGORIES_PER_PAGE);
		$result = $GLOBALS['XCART_DB']->Query($query);
		while($category = $GLOBALS['XCART_DB']->Fetch($result)) {
			$importCategory = array(
				"catparentid" => $category['parentid'],
				"catname" => $category['category'],
				"catdesc" => $category['description'],
				"catviews" => $category['views_stats']
			);
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingCategory'), $this->_importSession['ImportCategories']['done'], $this->_importSession['ImportCategories']['count']);
			$this->InsertCategory($category['categoryid'], $importCategory, $err);
			++$this->_importSession['ImportCategories']['done'];
		}
	}

	/**
	 * Import X-Cart brands in to the application.
	 */
	public function ImportBrands()
	{
		$start = $this->_importSession['ImportBrands']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "select count(manufacturerid) from xcart_manufacturers";
			$result = $GLOBALS['XCART_DB']->Query($query);
			$this->_importSession['ImportBrands']['count'] = $GLOBALS['XCART_DB']->FetchOne($query);
			$this->_importSession['ImportBrands']['done'] = 0;
		}

		$query = "SELECT * FROM xcart_manufacturers ORDER BY manufacturerid ASC";
		$query .= $GLOBALS['XCART_DB']->AddLimit($start, ISC_IMPORT_BRANDS_PER_PAGE);
		$result = $GLOBALS['XCART_DB']->Query($query);
		while($brand = $GLOBALS['XCART_DB']->Fetch($result)) {
			$importBrand = array(
				"brandname" => $brand['manufacturer']
			);
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingBrand'), $this->_importSession['ImportBrands']['done'], $this->_importSession['ImportBrands']['count']);
			$this->InsertBrand($brand['manufacturerid'], $importBrand, $err);
			++$this->_importSession['ImportBrands']['done'];
		}
	}

	/**
	 * Import X-Cart subscribers in to the application.
	 */
	public function ImportSubscribers()
	{
		$start = $this->_importSession['ImportSubscribers']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "SELECT COUNT(email) FROM xcart_newslist_subscription";
			$result = $GLOBALS['XCART_DB']->Query($query);
			$this->_importSession['ImportSubscribers']['count'] = $GLOBALS['XCART_DB']->FetchOne($query);
			$this->_importSession['ImportSubscribers']['done'] = 0;
		}

		$query = "SELECT * FROM xcart_newslist_subscription ORDER BY email ASC";
		$query .= $GLOBALS['XCART_DB']->AddLimit($start, ISC_IMPORT_SUBSCRIBERS_PER_PAGE);
		$result = $GLOBALS['XCART_DB']->Query($query);
		while($subscriber = $GLOBALS['XCART_DB']->Fetch($result)) {
			$importSubscriber = array(
				"subemail" => $subscriber['email'],
				"subfirstname" => ''
			);

			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingSubscriber'), $this->_importSession['ImportSubscribers']['done'], $this->_importSession['ImportSubscribers']['count']);
			$this->InsertSubscriber(md5($subscriber['email']), $importSubscriber, $err);
			++$this->_importSession['ImportSubscribers']['done'];
		}
	}

	/**
	 * Import X-Cart customers in to the application.
	 */
	public function ImportCustomers()
	{
		$start = $this->_importSession['ImportCustomers']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportCustomers']['done'] == 0) {
			$query = "SELECT COUNT(login) FROM xcart_customers WHERE usertype='C'";
			$result = $GLOBALS['XCART_DB']->Query($query);
			$this->_importSession['ImportCustomers']['count'] = $GLOBALS['XCART_DB']->FetchOne($query);
			$this->_importSession['ImportCustomers']['done'] = 0;
		}

		$query = "SELECT * FROM xcart_customers WHERE usertype='C' ORDER BY login ASC";
		$query .= $GLOBALS['XCART_DB']->AddLimit($start, ISC_IMPORT_CUSTOMERS_PER_PAGE);
		$result = $GLOBALS['XCART_DB']->Query($query);
		while($customer = $GLOBALS['XCART_DB']->Fetch($result)) {
			$importCustomer = array(
				"custpassword" => md5($this->GetXCartPassword($customer['password'])),
				"custconfirstname" => $customer['firstname'],
				"custconlastname" => $customer['lastname'],
				"custconcompany" => $customer['company'],
				"custconemail" => $customer['email'],
				"custconphone" => $customer['phone'],
				"custdatejoined" => $customer['first_login']
			);

			$customer['s_address'] = explode("\n", $customer['s_address']);

			// Create the shipping address for this user
			$importCustomer['addresses'] = array();
			$importCustomer['addresses'][] = array(
				"shipfullname" => $customer['s_firstname'].' '.$customer['s_lastname'],
				"shipaddress1" => $customer['s_address'][0],
				"shipaddress2" => $customer['s_address'][1],
				"shipcity" => $customer['s_city'],
				"shipstate" => $this->GetXCartStateName($customer['s_state'], $customer['s_country']),
				"shipzip" => $customer['s_zipcode'],
				"shipcountry" => $this->GetCountryName($customer['s_country']),
				"shipphone" => $customer['phone'],
				"shipdestination" => "residential"
			);

			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingCustomer'), $this->_importSession['ImportCustomers']['done'], $this->_importSession['ImportCustomers']['count']);
			$this->InsertCustomer($customer['login'], $importCustomer, $err);
			++$this->_importSession['ImportCustomers']['done'];
		}
	}

	/**
	 * Import X-Cart reviews in to the application.
	 */
	public function ImportReviews()
	{
		$start = $this->_importSession['ImportReviews']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($start == 0) {
			$query = "SELECT COUNT(review_id) FROM xcart_product_reviews";
			$result = $GLOBALS['XCART_DB']->Query($query);
			$this->_importSession['ImportReviews']['count'] = $GLOBALS['XCART_DB']->FetchOne($query);
			$this->_importSession['ImportReviews']['done'] = 0;
		}

		$query = "SELECT * FROM xcart_product_reviews ORDER BY review_id ASC";
		$query .= $GLOBALS['XCART_DB']->AddLimit($start, ISC_IMPORT_REVIEWS_PER_PAGE);
		$result = $GLOBALS['XCART_DB']->Query($query);
		while($review = $GLOBALS['XCART_DB']->Fetch($result)) {
			if(isc_strpos($review['email'], "(") !== 0) {
				// Review name inside email field
				$fromName = isc_substr($review['email'], 0, isc_strpos($review['email'], "("));
			}
			else {
				$from = explode("@", $review['email'], 2);
				$fromName = $from[1];
			}
			$importReview = array(
				"revproductid" => $review['productid'],
				"revfromname" => trim($fromName),
				"revdate" => time(),
				"revtext" => $review['message'],
				"revstatus" => 1
			);
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingReview'), $this->_importSession['ImportReviews']['done'], $this->_importSession['ImportReviews']['count']);
			$this->InsertReview($review['review_id'], $importReview, $err);
			++$this->_importSession['ImportReviews']['done'];
		}
	}

	/**
	 * Import X-Cart customers in to the application.
	 */
	public function ImportUsers()
	{
		$start = $this->_importSession['ImportUsers']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportUsers']['done'] == 0) {
			$query = "SELECT COUNT(login) FROM xcart_customers WHERE usertype='A'";
			$result = $GLOBALS['XCART_DB']->Query($query);
			$this->_importSession['ImportUsers']['count'] = $GLOBALS['XCART_DB']->FetchOne($query);
			$this->_importSession['ImportUsers']['done'] = 0;
		}

		$query = "SELECT * FROM xcart_customers WHERE usertype='A' ORDER BY login ASC";
		$query .= $GLOBALS['XCART_DB']->AddLimit($start, ISC_IMPORT_USERS_PER_PAGE);
		$result = $GLOBALS['XCART_DB']->Query($query);
		while($user = $GLOBALS['XCART_DB']->Fetch($result)) {
			$importUser = array(
				"username" => $user['login'],
				"userpass" => md5($this->GetXCartPassword($user['password'])),
				"userfirstname" => $user['b_firstname'],
				"userlastname" => $user['b_lastname'],
				"useremail" => $user['email']
			);
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingUser'), $this->_importSession['ImportUsers']['done'], $this->_importSession['ImportUsers']['count']);
			$this->InsertUser($user['login'], $importUser, $err);
			++$this->_importSession['ImportUsers']['done'];
		}
	}

	/**
	 * Import X-Cart products in to the application.
	 */
	public function ImportProducts()
	{
		$start = $this->_importSession['ImportProducts']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportProducts']['done'] == 0) {
			$query = "SELECT COUNT(productid) FROM xcart_products";
			$result = $GLOBALS['XCART_DB']->Query($query);
			$this->_importSession['ImportProducts']['count'] = $GLOBALS['XCART_DB']->FetchOne($query);
			$this->_importSession['ImportProducts']['done'] = 0;
		}

		$query = "
			SELECT p.*, f.productid AS prodfeatured, if(p.list_price = 0, pp.price, p.list_price) as list_price
			FROM xcart_products p
			LEFT JOIN xcart_featured_products f ON (f.productid=p.productid)
			LEFT JOIN xcart_pricing pp ON (pp.productid=p.productid AND quantity <= 1 AND variantid=0 AND membershipid=0)
			ORDER BY p.productid ASC
		";
		$query .= $GLOBALS['XCART_DB']->AddLimit($start, ISC_IMPORT_PRODUCTS_PER_PAGE);
		$result = $GLOBALS['XCART_DB']->Query($query);
		while($product = $GLOBALS['XCART_DB']->Fetch($result)) {
			if($product['prodfeatured']) {
				$productFeatured = 1;
			}
			else {
				$productFeatured = 0;
			}

			if($product['fulldescr'] != '') {
				$product['descr'] = $product['fulldescr'];
			}

			$importProduct = array(
				"prodname" => $product['product'],
				"prodcode" => $product['productcode'],
				"proddesc" => $product['descr'],
				"prodprice" => $product['list_price'],
				"prodvisible" => $this->YesNoToInt($product['forsale']),
				"prodfeatured" => $productFeatured,
				"prodcurrentinv" => $product['avail'],
				"prodlowinv" => $product['low_avail_limit'],
				"prodweight" => $product['weight'],
				"prodwidth" => $product['dim_x'],
				"prodheight" => $product['dim_y'],
				"proddepth" => $product['dim_z'],
				"prodfixedshippingcost" => $product['shipping_freight'],
				"prodfreeshipping" => $this->YesNoToInt($product['free_shipping']),
				"prodnumsold" => $product['sales_stats'],
				"proddateadded" => $product['add_date'],
				"prodbrandid" => $product['manufacturerid'],
				"prodmetakeywords" => $product['keywords']
			);

			if($product['distribution'] != '') {
				$importProduct['downloads'] = array(
					array(
						"downfile" => $this->_importSession['Configuration']['downloads_path'].'/'.$product['distribution']
					)
				);
			}

			// Fetch any category associations
			$importProduct['categories'] = array();
			$query2 = sprintf("SELECT * FROM xcart_products_categories WHERE productid='%s'", $product['productid']);
			$result2 = $GLOBALS['XCART_DB']->Query($query2);
			while($category = $GLOBALS['XCART_DB']->Fetch($result2)) {
				$importProduct['categories'][] = $category['categoryid'];
			}

			$importProduct['images'] = array();

			// Fetch the product thumbnail
			$query2 = sprintf("SELECT * FROM xcart_images_T WHERE id='%d' ORDER BY orderby", $product['productid']);
			$query2 .= $GLOBALS['XCART_DB']->AddLimit(0, 1);
			$result2 = $GLOBALS['XCART_DB']->Query($query2);
			$thumbnail = $GLOBALS['XCART_DB']->Fetch($result2);
			if($thumbnail) {
				if($thumbnail['image_path'] != '') {
					$importProduct['images'][] = array(
						"imagefile" => $this->_importSession['Configuration']['path'] . "/" . $thumbnail['image_path'],
						"imageisthumb" => 1
					);
				}
				else {
					$importProduct['images'][] = array(
						"imagedata" => $thumbnail['image'],
						"imagefilename" => md5(uniqid(true)).$this->GetXCartImageExtension($thumbnail['image_type']),
						"imageisthumb" => 1
					);
				}

			}

			// Fetch primary image
			$query2 = sprintf("SELECT * FROM xcart_images_P WHERE id='%d' ORDER BY orderby", $product['productid']);
			$query2 .= $GLOBALS['XCART_DB']->AddLimit(0, 1);
			$result2 = $GLOBALS['XCART_DB']->Query($query2);
			$image = $GLOBALS['XCART_DB']->Fetch($result2);
			if($image) {
				if($image['image_path'] != '') {
					$importProduct['images'][] = array(
						"imagefile" => $this->_importSession['Configuration']['path'] . "/" . $image['image_path'],
						"imageisthumb" => 0
					);
				}
				else {
					$importProduct['images'][] = array(
						"imagedata" => $image['image'],
						"imagefilename" => md5(uniqid(true)).$this->GetXCartImageExtension($image['image_type']),
						"imageisthumb" => 0
					);
				}
			}

			// Are there any additional images?
			$query2 = sprintf("SELECT * FROM xcart_images_D WHERE id='%d'", $product['productid']);
			$result2 = $GLOBALS['XCART_DB']->Query($query2);
			while($row2 = $GLOBALS['XCART_DB']->Fetch($result2)) {
				if($row2['image_path'] != '') {
					$importProduct['images'][] = array(
						"imagefile" => $this->_importSession['Configuration']['path'] . "/" . $row2['image_path'],
						"imageisthumb" => 0
					);
				}
				else {
					$importProduct['images'][] = array(
						"imagedata" => $row2['image'],
						"imagefilename" => md5(uniqid(true)).$this->GetXCartImageExtension($row2['image_type']),
						"imageisthumb" => 0
					);
				}
			}

			// Fetch any product options associated with this product.
			$query2 = sprintf("SELECT DISTINCT class, classid FROM xcart_classes WHERE productid='%s' ORDER BY classid", $product['productid']);
			$result2 = $GLOBALS['XCART_DB']->Query($query2);
			$count = 0;
			$option_names = array();
			$option_ids = array();

			while($row = $GLOBALS['XCART_DB']->Fetch($result2)) {
				++$count;
				$option_names[$count] = $row['class'];
				$option_ids[] = $row['classid'];
			}

			if($count > 0) {
				// Build the query
				$selects = array();
				$froms = array();
				$wheres = array();

				for($i = 1; $i <= $count; ++$i) {
					$selects[] = "o".$i.".option_name as name_".$i.", o".$i.".price_modifier as pricediff_".$i;
					$froms[] = sprintf('xcart_class_options o%1$s', $i);
					$classid = array_shift($option_ids);
					$wheres[] = sprintf("o%s.classid='%s'", $i, $classid);
				}

				$query2 = sprintf("
					SELECT DISTINCT %s
					FROM (%s)
					WHERE %s
					ORDER BY o1.classid",
					implode(", ", $selects),
					implode(", ", $froms),
					implode(" AND ", $wheres)
				);
				$result2 = $GLOBALS['XCART_DB']->Query($query2);
				while($row2 = $GLOBALS['XCART_DB']->Fetch($result2)) {
					$price = 0;
					$priceType = '';
					$options = array();
					foreach($option_names as $k => $optname) {
						if(!isset($row2['name_'.$k])) {
							continue;
						}
						$options[$optname] = $row2['name_'.$k];
						$priceAdjustment = $row2['pricediff_'.$k];
						$price += $priceAdjustment;
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

			// Fetch any related products for this product
			$product['prodrelatedproducts'] = array();
			$query2 = sprintf("SELECT * FROM xcart_product_links WHERE productid1='%s' ORDER BY orderby", $product['productid']);
			$result2 = $GLOBALS['XCART_DB']->Query($query2);
			while($row2 = $GLOBALS['XCART_DB']->Fetch($result2)) {
				$product['prodrelatedproducts'][] = $row2['productid2'];
			}

			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingProduct'), $this->_importSession['ImportProducts']['done'], $this->_importSession['ImportProducts']['count']);
			$this->InsertProduct($product['productid'], $importProduct, $err);
			++$this->_importSession['ImportProducts']['done'];
		}
	}

	/**
	 * Import X-Cart orders in to the application.
	 */
	public function ImportOrders()
	{
		$start = $this->_importSession['ImportOrders']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportOrders']['done'] == 0) {
			$query = "select count(orderid) from xcart_orders";
			$result = $GLOBALS['XCART_DB']->Query($query);
			$this->_importSession['ImportOrders']['count'] = $GLOBALS['XCART_DB']->FetchOne($query);
			$this->_importSession['ImportOrders']['done'] = 0;
		}

		$query = "
			SELECT o.*, s.shipping
			FROM xcart_orders o
			LEFT JOIN xcart_shipping s ON (s.shippingid=o.shippingid)
			ORDER BY o.orderid ASC
		";
		$query .= $GLOBALS['XCART_DB']->AddLimit($start, ISC_IMPORT_ORDERS_PER_PAGE);
		$result = $GLOBALS['XCART_DB']->Query($query);

		while($order = $GLOBALS['XCART_DB']->Fetch($result)) {
			switch($order['status']) {
				case "I": // Not finished
				case "Q": // Queued
				case "B": // Backordered
					$orderStatus = 1;
					break;
				case "P": //Processed
					$orderStatus = 9;
					break;
				case "D": // Declined
					$orderStatus = 6;
					break;
				case "F": // Failed
					$orderStatus = 5;
					break;
				case "C": // Complete
					$orderStatus = 10;
					break;
				default:
					$orderStatus = 1;
			}

			$order['b_address'] = explode("\n", $order['b_address']);
			$order['s_address'] = explode("\n", $order['s_address']);

			$importOrder = array(
				"ordcustid" => $order['login'],
				"orddate" => $order['date'],
				"ordsubtotal" => $order['subtotal'],
				"ordtaxtotal" => $order['tax'],
				"ordshipcost" => $order['shipping_cost'],
				"ordshipmethod" => $order['shipping'],
				"ordhandlingcost" => $order['payment_surcharge'],
				"ordtotalamount" => $order['total'],
				"ordstatus" => $orderStatus,
				"orderpaymentmethod" => $order['payment_method'],
				"ordbillfullname" => $order['b_firstname'] . ' ' . $order['b_lastname'],
				"ordbillstreet1" => $order['b_address'][0],
				"ordbillstreet2" => $order['b_address'][1],
				"ordbillsuburb" => $order['b_city'],
				"ordbillstate" => $this->GetXCartStateName($order['b_state'], $order['b_country']),
				"ordbillzip" => $order['b_zipcode'],
				"ordbillcountry" => $this->GetCountryName($order['b_country']),
				"ordshipfullname" => $order['s_firstname'] . ' ' . $order['s_lastname'],
				"ordshipstreet1" => $order['s_address'][0],
				"ordshipstreet2" => $order['s_address'][1],
				"ordshipsuburb" => $order['s_city'],
				"ordshipstate" => $this->GetXCartStateName($order['s_state'], $order['b_country']),
				"ordshipzip" => $order['s_zipcode'],
				"ordshipcountry" => $this->GetCountryName($order['s_country']),
				"ordtrackingno" => $order['tracking']
			);

			$importOrder['products'] = array();

			// Fetch all of the products in this order
			$query2 = sprintf("SELECT * FROM xcart_order_details WHERE orderid='%s'", $order['orderid']);
			$result2 = $GLOBALS['XCART_DB']->Query($query2);
			while($row = $GLOBALS['XCART_DB']->Fetch($result2)) {
				$importOrder['products'][] = array(
					"ordprodsku" => $row['productcode'],
					"ordprodname" => $row['product'],
					"ordprodcost" => $row['price'],
					"ordprodqty" => $row['amount'],
					"ordprodid" => $row['productid']
				);
			}

			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingOrder'), $this->_importSession['ImportOrders']['done'], $this->_importSession['ImportOrders']['count']);
			$this->InsertOrder($order['orderid'], $importOrder, $err);
			++$this->_importSession['ImportOrders']['done'];
		}
	}

	/**
	 * Import X-Cart wishlists in to the application.
	 */
	public function ImportWishlists()
	{
		$start = $this->_importSession['ImportWishlists']['done'];

		// On our first iteration, store the number of records in this table we'll be importing
		if($this->_importSession['ImportWishlists']['done'] == 0) {
			$query = "SELECT COUNT(wishlistid) FROM xcart_wishlist";
			$result = $GLOBALS['XCART_DB']->Query($query);
			$this->_importSession['ImportWishlists']['count'] = $GLOBALS['XCART_DB']->FetchOne($query);
			$this->_importSession['ImportWishlists']['done'] = 0;
		}

		$query = "SELECT * FROM xcart_wishlist ORDER BY wishlistid ASC";
		$query .= $GLOBALS['XCART_DB']->AddLimit($start, ISC_IMPORT_WISHLISTS_PER_PAGE);
		$result = $GLOBALS['XCART_DB']->Query($query);
		while($wishlist = $GLOBALS['XCART_DB']->Fetch($result)) {
			$importWishlist = array(
				"customerid" => $wishlist['login'],
				"productid" => $wishlist['productid']
			);
			$err = '';
			$this->UpdateProgress(GetLang('StatusImportingWishlist'), $this->_importSession['ImportWishlists']['done'], $this->_importSession['ImportWishlists']['count']);
			$this->InsertWishlist($wishlist['wishlistid'], $importWishlist, $err);
			++$this->_importSession['ImportWishlists']['done'];
		}
	}

	/**
	 * Convert a encrypted X-Cart password to the plaintext equivilent.
	 *
	 * @param string The X-Cart encrypted password.
	 * @return string The decrypted password.
	 */
	public function GetXCartPassword($pass)
	{
		if(!isset($GLOBALS['blowfish']) && !is_object($GLOBALS['blowfish'])) {
			require $this->_importSession['Configuration']['path']."/include/blowfish.php";
			$GLOBALS['blowfish'] = new ctBlowfish();
		}
		$blowfish_key = $this->_importSession['Configuration']['blowfish_key'];
		$pass = explode("-", $pass, 2);
		if($pass[0] == "B") {
			$decrypted = trim(func_bf_decrypt($pass[1], $blowfish_key));
			// X-Cart also applies an 8 character CRC, so we need to strip that
			$decrypted = isc_substr($decrypted, 0, -8);
			return $decrypted;
		}
		return false;
	}

	/**
	 * Return an image extension based on the passed mime type.
	 *
	 * @param string The mime type
	 * @return string The matching extension.
	 */
	public function GetXCartImageExtension($mime)
	{
		switch(strtolower($mime)) {
			case 'image/png':
				return '.png';
				break;
			case 'image/gif':
				return '.gif';
				break;
			default:
				return '.jpg';
		}
	}

	/**
	 * Get an X-Cart state name based on the passed code.
	 *
	 * @param string The state code.
	 * @param string The ISO code of the country the state is in.
	 * @return string The name of the state.
	 */
	public function GetXCartStateName($code, $countryCode)
	{
		static $cache;
		if(isset($cache[$countryCode][$code])) {
			return $cache[$countryCode][$code];
		}

		$query = "
			SELECT state
			FROM xcart_states
			WHERE code='".$GLOBALS['XCART_DB']->Quote($code)."' AND country_code='".$GLOBALS['XCART_DB']->Quote($countryCode)."'
		";
		$cache[$countryCode][$code] = $GLOBALS['XCART_DB']->FetchOne($query);
		return $cache[$countryCode][$code];
	}

	/**
	 * Lookup an Interspire Shopping Cart country name based on the passed X-Cart country code.
	 *
	 * @param string The country code.
	 * @return string The country name.
	 */
	public function GetCountryName($code)
	{
		static $cache;
		if(isset($cache[$code])) {
			return $cache[$code];
		}

		$query = "
			SELECT countryname
			FROM [|PREFIX|]countries
			WHERE countryiso2='".$GLOBALS['ISC_CLASS_DB']->Quote($code)."'
		";
		$cache[$code] = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
		return $cache[$code];
	}
}

?>