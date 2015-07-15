<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'entity.base.php');

class ISC_ENTITY_ORDER extends ISC_ENTITY_BASE
{
	private $shipping;

	protected $tableName;
	protected $primaryKeyName;
	protected $customKeyName;
	protected $searchFields;

	/**
	 * Constructor
	 *
	 * Base constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		parent::__construct();

		$this->shipping = new ISC_ENTITY_SHIPPING;
		$this->tableName = 'orders';
		$this->primaryKeyName = 'orderid';
		$this->customKeyName = 'ordformsessionid';
		$this->searchFields = array(
				'orderid',
				'ordtoken',
				'ordcustid',
				'ordbillfirstname',
				'ordbilllastname',
				'ordbillemail',
				'ordshipfirstname',
				'ordshiplastname',
				'ordshipemail'
		);
	}

	/**
	 * Parse the order data
	 *
	 * Method will parse the order data to be inserted into the database
	 *
	 * @access private
	 * @param array &$input The referenced input data
	 * @param array &$parsed The referneced array to store the parsed information in
	 * @return NULL
	 */
	private function parsedata(&$input, &$parsed)
	{
		// Load the shipping address if we don't have a custom one
		if (array_key_exists('shippingaddressid', $input) && isId($input['shippingaddressid'])) {
			$input['shippingaddress'] = $GLOBALS['ISC_CLASS_ACCOUNT']->GetShippingAddress($input['shippingaddressid']);
		}

		// Load the billing address if we don't have a custom one
		if (array_key_exists('billingaddressid', $input) && isId($input['billingaddressid'])) {
			$input['billingaddress'] = $GLOBALS['ISC_CLASS_ACCOUNT']->GetShippingAddress($input['billingaddressid']);
		}

		// If we don't have a shipping address for this order then it's a digital order - we need to set up an empty
		// array with the address fields
		if(!isset($input['shippingaddress'])) {
			$input['shippingaddress'] = array(
				'shipfirstname'		=> '',
				'shiplastname'		=> '',
				'shipaddress1'		=> '',
				'shipaddress2'		=> '',
				'shipcity'			=> '',
				'shipstate'			=> '',
				'shipzip'			=> '',
				'shipcountry'		=> '',
				'shipcountryid'		=> '',
				'shipstateid'		=> '',
				'shipcompany'		=> '',
			);
		}

		if(!isset($input['ordstatus'])) {
			$input['ordstatus'] = 0;
		}

		if(!isset($input['orddate'])) {
			$input['orddate'] = time();
		}

		// Get the amount that went through the payment gateway
		if (array_key_exists('gatewayamount', $input)) {
			$orderGatewayAmount = $input['gatewayamount'];
		}
		else {
			$orderGatewayAmount = 0;
		}

		// Get the amount of store credit that was used
		if (array_key_exists('storecreditamount', $input)) {
			$orderStoreCreditAmount = $input['storecreditamount'];
		}
		else {
			$orderStoreCreditAmount = 0;
		}

		// Get the amount used from any gift certificates
		if (array_key_exists('giftcertificateamount', $input)) {
			$orderGiftCertificateAmount = $input['giftcertificateamount'];
		}
		else {
			$orderGiftCertificateAmount = 0;
		}

		$providerName = '';
		$providerId = '';

		// Order was paid for entirely with gift certificates
		if ($input['paymentmethod'] == "giftcertificate") {
			$providerName = "giftcertificate";
			$providerid = '';
		}
		// Order was paid for entirely using store credit
		else if ($input['paymentmethod'] == "storecredit") {
			$providerName = 'storecredit';
			$providerId = '';
		}
		// Went through some sort of payment gateway
		else {
			if ($input['gatewayamount'] > 0) {
				if (GetModuleById('checkout', $provider, $input['paymentmethod']) && is_object($provider)) {
					$providerName = $provider->GetDisplayName();
					$providerId = $provider->GetId();
				}
				else {
					$providerId = $input['paymentmethod'];
					$providerName = $input['paymentmethodname'];
				}
			}
			else {
				$providerName = '';
				$providerId = '';
			}
		}

		// Get the customer ID
		if (!array_key_exists('customerid', $input)) {
			$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
			$input['customerid'] = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerIdByToken($input['customertoken']);
		}

		// Loop through all of the products in this order to see if they're entirely
		// gift certificates
		$onlyGiftCertificates = true;
		foreach ($input['products'] as $product) {
			if (isset($product['type']) && $product['type'] != 'giftcertificate') {
				$onlyGiftCertificates = false;
			}
		}

		// Fetch the country codes for the billing and shipping addresses
		$billingCountryCode = GetCountryISO2ByName($input['billingaddress']['shipcountry']);
		$shippingCountryCode = '';
		if(isset($input['shippingaddress']['shipcountry'])) {
			$shippingCountryCode = GetCountryISO2ByName($input['shippingaddress']['shipcountry']);
		}

		$ipCountryName = '';
		$ipCountryCode = '';

		if (!array_key_exists('geoipcountry', $input) && !array_key_exists('geoipcountrycode', $input)) {
			// Attempt to determine the GeoIP location based on their IP address

			require_once ISC_BASE_PATH."/lib/geoip/geoip.php";
			$gi = geoip_open(ISC_BASE_PATH."/lib/geoip/GeoIP.dat", GEOIP_STANDARD);
			$ipCountryCode = geoip_country_code_by_addr($gi, GetIP());

			// If we get the country, look up the country name as well
			if ($ipCountryCode) {
				$ipCountryName = geoip_country_name_by_addr($gi, GetIP());
			}
		}

		if(!isset($input['vendorid'])) {
			$input['vendorid'] = 0;
		}

		if (!array_key_exists('extraInfo', $input)) {
			$input['extraInfo'] = array();
		}

		if (array_key_exists('giftcertificates', $input) && is_array($input['giftcertificates'])) {
			$input['extraInfo']['giftcertificates'] = $input['giftcertificates'];
		}

		if (!array_key_exists('ordshippingzoneid', $input)) {
			$input['ordshippingzoneid'] = 0;
		}

		if (!array_key_exists('ordshippingzone', $input)) {
			$input['ordshippingzone'] = '';
		}

		if (array_key_exists('shipemail', $input['billingaddress'])) {
			$input["ordbillemail"] = $input['billingaddress']['shipemail'];
		}
		else if(!isset($input['ordbillemail'])) {
			$input['ordbillemail'] = '';
		}
		if (array_key_exists('shipphone', $input['billingaddress'])) {
			$input["ordbillphone"] = $input['billingaddress']['shipphone'];
		}
		else {
			$input['ordbillphone'] = '';
		}
		if (isset($input['shippingaddress']) && is_array($input['shippingaddress']) && array_key_exists('shipemail', $input['shippingaddress'])) {
			$input["ordshipemail"] = $input['shippingaddress']['shipemail'];
		}
		else if(!isset($input['ordshipemail'])) {
			$input["ordshipemail"] = '';
		}
		if (isset($input['shippingaddress']) && is_array($input['shippingaddress']) && array_key_exists('shipphone', $input['shippingaddress'])) {
			$input["ordshipphone"] = $input['shippingaddress']['shipphone'];
		}
		else {
			$input['ordshipphone'] = '';
		}

		if (!isset($input['shippingcost']) || $input['shippingcost'] == '') {
			$input['shippingcost'] = 0;
		}

		if (!isset($input['handlingcost']) || $input['handlingcost'] == '') {
			$input['handlingcost'] = 0;
		}

		// If we don't have a billing or shipping email address but we have a customer, fetch & use the email address
		// from the customer
		if((!$input['ordbillemail'] || !$input['ordshipemail']) && $input['customerid']) {
			$query = "
				SELECT custconemail
				FROM [|PREFIX|]customers
				WHERE customerid='".(int)$input['customerid']."'
			";
			$email = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			foreach(array('ordbillemail', 'ordshipemail') as $field) {
				if(!$input[$field]) {
					$input[$field] = $email;
				}
			}
		}


		// If we don't have a billing or shipping phone but we have a customer, fetch & use the phone
		// from the customer
		if((!$input['ordbillphone'] || !$input['ordshipphone']) && $input['customerid']) {
			$query = "
				SELECT custconphone
				FROM [|PREFIX|]customers
				WHERE customerid='".(int)$input['customerid']."'
			";
			$phone = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			foreach(array('ordbillphone', 'ordshipphone') as $field) {
				if(!$input[$field]) {
					$input[$field] = $phone;
				}
			}
		}

		// Determine the actual number of items in this order
		$totalNumItems = 0;
		foreach($input['products'] as $product) {
			$totalNumItems += $product['quantity'];
		}

		$defaultCurrency = GetDefaultCurrency();

		$parsed	= array(
			'ordtoken' => $input['pending_token'],
			'ordvendorid' => $input['vendorid'],
			'ordcustid' => $input['customerid'],
			'orddate' => $input['orddate'],
			'ordsubtotal' => $input['itemtotal'],
			'ordtaxtotal' => $input['taxcost'],
			'ordtaxrate' => $input['taxrate'],
			'ordtaxname' => $input['taxname'],
			'ordtotalincludestax' => $input['totalincludestax'],
			'ordshipcost' => $input['shippingcost'],
			'ordshipmethod' => $input['shippingprovider'],
			'ordershipmodule' => $input['shippingmodule'],
			'ordhandlingcost' => $input['handlingcost'],
			'ordtotalamount' => $input['totalcost'],
			'ordgatewayamount' => $orderGatewayAmount,
			'ordstorecreditamount' => $orderStoreCreditAmount,
			'ordgiftcertificateamount' => $orderGiftCertificateAmount,
			'ordstatus' => $input['ordstatus'],
			'ordtotalqty' => $totalNumItems,
			'orderpaymentmethod' => $providerName,
			'orderpaymentmodule' => $providerId,
			'ordbillfirstname' => $input['billingaddress']['shipfirstname'],
			'ordbilllastname' => $input['billingaddress']['shiplastname'],
			'ordbillcompany' => $input['billingaddress']['shipcompany'],
			'ordbillstreet1' => $input['billingaddress']['shipaddress1'],
			'ordbillstreet2' => $input['billingaddress']['shipaddress2'],
			'ordbillsuburb' => $input['billingaddress']['shipcity'],
			'ordbillstate' => $input['billingaddress']['shipstate'],
			'ordbillzip' => $input['billingaddress']['shipzip'],
			'ordbillcountry' => $input['billingaddress']['shipcountry'],
			'ordshipfirstname' => $input['shippingaddress']['shipfirstname'],
			'ordshiplastname' => $input['shippingaddress']['shiplastname'],
			'ordshipcompany' => $input['shippingaddress']['shipcompany'],
			'ordshipstreet1' => $input['shippingaddress']['shipaddress1'],
			'ordshipstreet2' => $input['shippingaddress']['shipaddress2'],
			'ordshipsuburb' => $input['shippingaddress']['shipcity'],
			'ordshipstate' => $input['shippingaddress']['shipstate'],
			'ordshipzip' => $input['shippingaddress']['shipzip'],
			'ordshipcountry' => $input['shippingaddress']['shipcountry'],
			'ordbillcountryid' => (int)$input['billingaddress']['shipcountryid'],
			'ordbillstateid' => (int)$input['billingaddress']['shipstateid'],
			'ordshipcountryid' => (int)$input['shippingaddress']['shipcountryid'],
			'ordshipstateid' => (int)$input['shippingaddress']['shipstateid'],
			'ordisdigital' => $input['isdigitalorder'],
			'ordonlygiftcerts' => (int) $onlyGiftCertificates,
			'extrainfo' => serialize($input['extraInfo']),
			'ordbillcountrycode' => $billingCountryCode,
			'ordshipcountrycode' => $shippingCountryCode,
			'ordgeoipcountry' => $ipCountryName,
			'ordgeoipcountrycode' => $ipCountryCode,
			'ordcurrencyid' => (int)$input['currencyid'],
			'orddefaultcurrencyid' => (int)$defaultCurrency['currencyid'],
			'ordcurrencyexchangerate' => $input['currencyexchangerate'],
			'ordshippingzoneid' => $input['ordshippingzoneid'],
			'ordshippingzone' => $input['ordshippingzone'],
			'ordbillemail' => $input['ordbillemail'],
			'ordbillphone' => $input['ordbillphone'],
			'ordshipemail' => $input['ordshipemail'],
			'ordshipphone' => $input['ordshipphone'],
		);

		$parsed['ordcustmessage'] = '';
		if(isset($input['ordercomments'])) {
			$parsed['ordcustmessage'] = $input['ordercomments'];
		}

		$parsed['ordnotes'] = '';
		if(isset($input['ordnotes'])) {
			$parsed['ordnotes'] = $input['ordnotes'];
		}

		$parsed['ordtrackingno'] = '';
		if(isset($input['ordtrackingno'])) {
			$parsed['ordtrackingno'] = $input['ordtrackingno'];
		}

		$parsed['ordipaddress'] = '';
		if(isset($input['ipaddress'])) {
			$parsed['ordipaddress'] = $input['ipaddress'];
		}

		if(isset($input['ordformsessionid']) && isId($input['ordformsessionid'])) {
			$parsed['ordformsessionid'] = $input['ordformsessionid'];
		}
	}

	/**
	 * Add all the products
	 *
	 * Method will add all the products within the $input['products'] array
	 *
	 * @access private
	 * @param array &$input The referenced input data
	 * @return bool TRUE if all the products were added, FALSE otherwise
	 */
	private function addProducts(&$input, $editingExisting=false)
	{
		if (!array_key_exists('products', $input) || !is_array($input['products'])) {
			return false;
		}

		$existingOrder = array();
		if($editingExisting) {
			$existingOrder = GetOrder($input['orderid'], true);
		}

		$couponsUsed = array();
		$giftCertificates = array();

		foreach ($input['products'] as $product) {

			$existingProduct = false;
			if(isset($product['existing_order_product']) && isset($existingOrder['products'][$product['existing_order_product']])) {
				$existingProduct = $existingOrder['products'][$product['existing_order_product']];
				unset($existingOrder['products'][$product['existing_order_product']]);
			}

			if(!isset($product['product_code'])) {
				$product['product_code'] = '';
			}

			if(!isset($product['variation_id'])) {
				$product['variation_id'] = 0;
			}


			if(isset($product['discount_price'])) {
				$price = $product['discount_price'];
			}
			else {
				$price = $product['product_price'];
			}

			// Set up some default values for the product
			$newProduct = array(
				'ordprodsku'			=> $product['product_code'],
				"ordprodname"			=> $product['product_name'],
				"ordprodtype"			=> '',
				"ordprodcost"			=> $price,
				"ordprodoriginalcost"	=> $product['product_price'],
				"ordprodweight"			=> 0,
				"ordprodqty"			=> $product['quantity'],
				"orderorderid"			=> $input['orderid'],
				"ordprodid"				=> $product['product_id'],
				"ordprodvariationid"	=> $product['variation_id'],
				"ordprodoptions"		=> '',
				"ordprodcostprice"		=> 0,
				"ordprodfixedshippingcost" => 0,
				"ordprodistaxable"		=> 1
			);

            //YMM info added by Simha
            $newProduct['ordyear']  = $product['year'];
            $newProduct['ordmake']  = $product['make'];
            $newProduct['ordmodel'] = $product['model'];

			//blessen
			if (isset($input['offerid']))  $newProduct['offerid'] = $input['offerid'];
            
            /*
            $mmyvals =  array(
                "omake"             => $product['make'],
                "model"            => $product['model'],
                "year"             => $product['year'],                      
            );                               
            $MMYInfo = serialize($mmyvals);              
            $newProduct['mmyinfo'] =  $MMYInfo;
            */
			//YMM info added by Simha Ends
            
			// This product is a gift certificate so set the appropriate values
			if (isset($product['type']) && $product['type'] == "giftcertificate") {
				// Gift certificates can't be edited
				if(isset($product['existing_order_product'])) {
					continue;
				}

				$newProduct['ordprodtype'] = 'giftcertificate';
				$giftCertificates[] = $product;
			}

			// Normal product
			else {
				if(isset($product['data'])) {
					$newProduct['ordprodtype'] = $product['data']['prodtype'];
				}
				else {
					$newProduct['ordprodtype'] = 'physical';
				}
			}

			if(isset($product['data']['prodcostprice'])) {
				$newProduct['ordprodcostprice'] = (float)$product['data']['prodcostprice'];
			}

			if(isset($product['options'])) {
				$newProduct['ordprodoptions'] = serialize($product['options']);
			}

			if (isset($product['data']['prodweight'])) {
				$newProduct['ordprodweight'] = $product['data']['prodweight'];
			}

			if (isset($product['data']['prodfixedshippingcost'])) {
				$newProduct['ordprodfixedshippingcost'] = $product['data']['prodfixedshippingcost'];
			}

			if (isset($product['data']['prodistaxable'])) {
				$newProduct['ordprodistaxable'] = $product['data']['prodistaxable'];
			}

			if (isset($product['event_date']) && isset($product['event_name'])) {
				$newProduct['ordprodeventdate'] = $product['event_date'];
				$newProduct['ordprodeventname'] = $product['event_name'];
			}

			// If wrapping has been applied to this product, add it in
			if(isset($product['wrapping'])) {
				$newProduct['ordprodwrapid'] = $product['wrapping']['wrapid'];
				$newProduct['ordprodwrapname'] = $product['wrapping']['wrapname'];
				$newProduct['ordprodwrapcost'] = $product['wrapping']['wrapprice'];
				if(isset($product['wrapping']['wrapmessage'])) {
					$newProduct['ordprodwrapmessage'] = $product['wrapping']['wrapmessage'];
				}
			}

			if (isset($product['original_price'])) {
				$newProduct['ordoriginalprice'] = $product['original_price'];
			}

			if(is_array($existingProduct)) {
				$ordProdID = $existingProduct['orderprodid'];
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('order_products', $newProduct, "orderprodid='".(int)$ordProdID."'");

				// Delete any existing product fields we don't have
				$query = "
					SELECT orderfieldid, filename
					FROM [|PREFIX|]order_configurable_fields
					WHERE ordprodid='".$ordProdID."' AND fieldtype='file'
				";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($field = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					@unlink(ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/configured_products/'.$field['filename']);
				}
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('order_configurable_fields', "WHERE ordprodid='".$ordProdID."'");
			}
			else {
				$ordProdID = $GLOBALS['ISC_CLASS_DB']->InsertQuery("order_products", $newProduct);
                
                /* To insert the complementary items to order_products table -- Baskaran */
                if($product['compitem'] == 1) {                                                                   
                    for($y=0; $y<count($product['complementary']); $y++)   {    
                        $compprice          = $product['complementary'][$y]['comp_original_price'];     
                        $CompProduct = array(
                            'ordprodsku'            => $product['complementary'][$y]['comp_product_code'],
                            "ordprodname"            => $product['complementary'][$y]['comp_product_name'],
                            "ordprodtype"            => '',
                            "ordprodcost"            => $product['complementary'][$y]['comp_original_price'],
                            "ordprodoriginalcost"    => $product['complementary'][$y]['comp_original_price'],
                            "ordprodweight"            => 0,
                            "ordprodqty"            => $product['complementary'][$y]['quantity'],
                            "orderorderid"            => $input['orderid'],
                            "ordprodid"                => $product['complementary'][$y]['comp_productid'],
                            "ordprodvariationid"    => '',
                            "ordprodoptions"        => '',
                            "ordprodcostprice"        => 0,
                            "ordprodfixedshippingcost" => 0,
                            "ordprodistaxable"        => 1,
                            "ordoriginalprice"        => $product['complementary'][$y]['comp_original_price'],
                            "ordcompmainproductid"    => $product['complementary'][$y]['comp_mainproductid']
                        );
                        
                        /* $path = ISC_BASE_PATH."/simha.txt";
                        $fp = fopen($path, "w+");
                        if ($fp) {
                            fwrite($fp, implode("\r\n", $CompProduct)."\r\n----------------------\r\n");
                            fclose($fp);
                        } */                                                         
                        $ordProdID1 = $GLOBALS['ISC_CLASS_DB']->InsertQuery("order_products", $CompProduct); 
                    }        
			    }
                /* Code Ends */
            }
			// Add configurable product fields come with the order to database
			if(isset($product['product_fields'])) {
				foreach ($product['product_fields'] as $fieldId => $field) {


					//move the uploaded file to configured_products folder from the temp folder.
					if($field['fieldType'] == 'file' && trim($field['fileName']) != '') {
						$filePath = ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/configured_products/'.$field['fileName'];
						$fileTmpPath = ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/configured_products_tmp/'.$field['fileName'];

						//do not remove the temp file here, because the payment may not successful
						//the file should still be viewable in in the cart,
						@copy($fileTmpPath, $filePath);
					}



					$fieldArray = array(
						'ordprodid' 		=> (int)$ordProdID,
						'fieldid'			=> (int)$fieldId,
						'orderid'			=> (int)$input['orderid'],
						'fieldname'			=> $field['fieldName'],
						'fieldtype'			=> $field['fieldType'],
						'textcontents'		=> '',
						'filename'			=> '',
						'filetype'			=> '',
						'originalfilename'	=> '',
						'productid'			=> $product['product_id'],
					);

					if($field['fieldType'] == 'file' && trim($field['fileName']) != '') {
						$fieldArray['filename'] = trim($field['fileName']);
						$fieldArray['filetype'] = trim($field['fileType']);
						$fieldArray['originalfilename'] = trim($field['fileOriginName']);
					}
					else {
						$fieldArray['textcontents'] = trim($field['fieldValue']);
					}
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("order_configurable_fields", $fieldArray);
				}
			}




			// Ensure that coupons aren't being saved with gift certificates
			if (isset($product['couponcode'])) {
				$newOrderCoupon = array(
					"ordcouporderid" => $input['orderid'],
					"ordcoupprodid" => $ordProdID,
					"ordcouponid" => $product['coupon'],
					"ordcouponcode" => $product['couponcode'],
					"ordcouponamount" => $product['discount'],
					"ordcoupontype"	=> $product['coupontype']
				);

				$update_coup = false;
				if (is_array($existingProduct)) {
					$query = "SELECT ordcoupid FROM [|PREFIX|]order_coupons WHERE ordcoupprodid = '" . $ordProdID . "'";
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						$GLOBALS['ISC_CLASS_DB']->UpdateQuery("order_coupons", $newOrderCoupon, "ordcoupid = " . $row["ordcoupid"]);
						$update_coup = true;
					}
				}

				if (!$update_coup) {
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("order_coupons", $newOrderCoupon);
				}
			}
			else if (is_array($existingProduct)) {
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('order_coupons', "WHERE ordcoupprodid='".$ordProdID."'");
			}

			if(isset($existingOrder['ordinventoryupdated']) && $existingOrder['ordinventoryupdated'] == 1) {
				// If we're editing an existing order and the quantities or variation have changed, do we need to
				// update the inventory quantities?
				if(is_array($existingProduct) && (
						$existingProduct['ordprodvariationid']) != $newProduct['ordprodvariationid'] ||
						$existingProduct['ordprodqty'] != $newProduct['ordprodqty']
				) {
					AdjustProductInventory($existingProduct['ordprodid'], $existingProduct['ordprodvariationid'], @$product['data']['prodinvtrack'], '+'.$existingProduct['ordprodqty']);
					AdjustProductInventory($newProduct['ordprodid'], $newProduct['ordprodvariationid'], @$product['data']['prodinvtrack'], '-'.$newProduct['ordprodqty']);
				}

				// This is a new product in an existing order with inventory quantities
				// taken away, take them away for this product
				else if(!is_array($existingProduct)) {
					AdjustProductInventory($newProduct['ordprodid'], $newProduct['ordprodvariationid'], @$product['data']['prodinvtrack'], '+'.$newProduct['ordprodqty']);
				}
			}
		}

		// If we have one or more gift certificates to create, we need to create them now.
		if (count($giftCertificates) > 0) {
			$GLOBALS['ISC_CLASS_GIFT_CERTIFICATES'] = GetClass('ISC_GIFTCERTIFICATES');
			$GLOBALS['ISC_CLASS_GIFT_CERTIFICATES']->CreateGiftCertificatesFromOrder($input['orderid'], $giftCertificates, 1);
		}


		// Now remove any deleted items from the order
		if($editingExisting) {
			$removeItemIds = implode(',', array_keys($existingOrder['products']));

			if($removeItemIds != '') {
				$query = "
							SELECT op.orderprodid, p.productid, p.prodinvtrack
							FROM [|PREFIX|]order_products as op
							INNER JOIN [|PREFIX|]products as p
							ON op.ordprodid = p.productid
							WHERE op.orderprodid IN (".$removeItemIds.") AND ordprodid > 0
						";

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($prod = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$existingOrder['products'][$prod['orderprodid']]['prodinvtrack'] = $prod['prodinvtrack'];
				}

				//update product inventory level
				foreach($existingOrder['products'] as $rmProd) {
					if (!$rmProd['ordprodid']) {
						continue;
					}
					AdjustProductInventory($rmProd['ordprodid'], $rmProd['ordprodvariationid'],  $rmProd['prodinvtrack'], '+'.$rmProd['ordprodqty']);
				}

				// Delete any existing product fields we don't have
				$query = "
					SELECT orderfieldid, filename
					FROM [|PREFIX|]order_configurable_fields
					WHERE ordprodid IN (".$removeItemIds.") AND fieldtype='file'
				";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($field = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					@unlink(ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/configured_products/'.$field['filename']);
				}
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('order_configurable_fields', "WHERE ordprodid IN (".$removeItemIds.")");
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('order_products', "WHERE orderprodid IN (".$removeItemIds.")");
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('order_coupons', "WHERE ordcoupprodid IN (".$removeItemIds.")");
			}
		}
		return true;
	}

	/**
	 * Add all the shipping addresses
	 *
	 * Method will add all the shipping addresses within the $input['shippingaddress'] and $input['billingaddress'] arrays
	 *
	 * @access private
	 * @param array &$input The referenced input data
	 * @return bool TRUE if all the shipping addresses were added, FALSE otherwise
	 */
	private function addAddresses(&$input)
	{
		if (array_key_exists('shippingaddressid', $input) || array_key_exists('billingaddressid', $input)) {
			$addressesToUpdate = array();
			if (array_key_exists('shippingaddressid', $input)) {
				$addressesToUpdate[] = (int)$input['shippingaddressid'];
			}
			if (array_key_exists('billingaddressid', $input)) {
				$addressesToUpdate[] = (int)$input['billingaddressid'];
			}

			$addressesToUpdate = array_unique($addressesToUpdate);

			$updatedAddress = array(
				'shiplastused' => time()
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery('shipping_addresses', $updatedAddress, "shipid IN (".implode(',', $addressesToUpdate).")");
		}

		// Do we need to save an address?
		if (is_array($input['billingaddress']) && array_key_exists('saveAddress', $input['billingaddress']) && isId($input['customerid'])) {
			$address = $input['billingaddress'];
			$address['shipcustomerid'] = $input['customerid'];
			$this->shipping->add($address);
		}

		// Are we saving the shipping address too? We only do this if the customer chose to and the billing & shipping address line 1 aren't the
		// same
		if(isset($input['shippingaddress']) && is_array($input['shippingaddress']) && array_key_exists('saveAddress', $input['shippingaddress']) && isId($input['customerid'])) {
			$address = $input['shippingaddress'];
			$address['shipcustomerid'] = $input['customerid'];
			if (!$this->shipping->basicSearch($address)) {
				$this->shipping->add($address);
			} else if (isset($address['shipformsessionid']) && isId($address['shipformsessionid'])) {
				$GLOBALS['ISC_CLASS_FORM']->deleteFormSession($address['shipformsessionid']);
			}
		}

		return true;
	}

	/**
	 * Reformat the products array
	 *
	 * Method will reformat the products aray into something more standardised
	 *
	 * @access private
	 * @param array &$input The referenced input data
	 */
	private function reformatProducts(&$input)
	{
		if (!array_key_exists('products', $input) || !is_array($input['products'])) {
			return null;
		}

		$newProducts = array();

		foreach ($input['products'] as $product) {
			$tmpProd	= array();
			$price		= 0;

			if (array_key_exists('type', $product) && strtolower($product['type']) == 'giftcertificate') {
				$price = $product['giftamount'];
			} else if (array_key_exists('discount_price', $product)) {
				$price = $product['discount_price'];
			} else {
				$price = $product['product_price'];
			}

			$tmpProd['productid']	= $product['product_id'];
			$tmpProd['name']		= $product['product_name'];
			$tmpProd['amount']		= DefaultPriceFormat(CPrice($price));
			$tmpProd['quantity']	= $product['quantity'];

			$newProducts[]			= $tmpProd;
		}

		$input['products'] = $newProducts;
	}

	/**
	 * Add a order
	 *
	 * Method will add a order to the database
	 *
	 * @access public
	 * @param array $input The order details
	 * @return int The order record ID on success, FALSE otherwise
	 */
	public function add($input)
	{
		$GLOBALS['ISC_CLASS_ACCOUNT'] = GetClass('ISC_ACCOUNT');
		$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');

		$this->parsedata($input, $parsed);

		$GLOBALS['ISC_CLASS_DB']->StartTransaction();

		if (!isId($id = $GLOBALS['ISC_CLASS_DB']->InsertQuery("orders", $parsed))) {
			$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
			return false;
		}

		$input['orderid']	= $id;
		$input['date']		= time();

		if (!$this->addProducts($input)) {
			$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
			return false;
		}

		if (!$this->addAddresses($input)) {
			$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
			return false;
		}

		$GLOBALS['ISC_CLASS_DB']->CommitTransaction();

		/**
		 * For the time being, do not import any orders that DO NOT have a customer associated with it (anonymous customers)
		 */
		if (isset($input['customerid']) && isId($input['customerid'])) {
			$this->createServiceRequest('order', 'add', $input['orderid'], 'order_create');
		}

		return $input['orderid'];
	}


public function offeradd($input)
	{



		$GLOBALS['ISC_CLASS_ACCOUNT'] = GetClass('ISC_ACCOUNT');
		$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');

		$this->parsedata($input, $parsed);

		$GLOBALS['ISC_CLASS_DB']->StartTransaction();

		
		$parsed['ordsubtotal'] = $_SESSION['the_offered_price'] ;
		$parsed['ordtotalamount'] = $_SESSION['the_offered_price'] + $parsed['ordshipcost'];
		$parsed['ordgatewayamount'] =$parsed['ordtotalamount'] ;



		if (!isId($id = $GLOBALS['ISC_CLASS_DB']->InsertQuery("orders", $parsed))) {
		$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
			return false;
		}

		$parsed['ordstatus'] = 11;

	
		if (!isId($id = $GLOBALS['ISC_CLASS_DB']->InsertQuery("offers", $parsed))) {
			$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
			return false;
		}

	
		$input['orderid']	= $id;
		$input['date']		= time();
		$input['itemtotal']		= $parsed['ordtotalamount'];
		$input['gatewayamount']		= $parsed['ordgatewayamount'];
		$input['totalcost']		= $parsed['ordsubtotal'];
		$input['offerid']		= $id;
		


		if (!$this->addProducts($input)) {
			$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
			return false;
		}

		if (!$this->addAddresses($input)) {
			$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
			return false;
		}




		$GLOBALS['ISC_CLASS_DB']->CommitTransaction();

		/**
		 * For the time being, do not import any orders that DO NOT have a customer associated with it (anonymous customers)
		 */
		if (isset($input['customerid']) && isId($input['customerid'])) {
			$this->createServiceRequest('order', 'add', $input['orderid'], 'order_create');
		}

		return $input['orderid'];
	}
	/**
	 * Edit a customer
	 *
	 * Method will edit a customer's details
	 *
	 * @access public
	 * @param array $input The customer's details
	 * @return bool TRUE if the customer exists and the details were updated successfully, FALSE oterwise
	 */
	public function edit($input)
	{
		if (!array_key_exists('orderid', $input) || !isId($input['orderid'])) {
			return false;
		}

		/**
		 * Get the previous order so we can properly do the product inventory tracking
		 */
		$previousOrder = $this->get($input['orderid']);

		$this->parsedata($input, $parsed);

		unset($parsed['orddate']);
		unset($parsed['ordstatus']);

		$GLOBALS['ISC_CLASS_DB']->StartTransaction();

		if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("orders", $parsed, "orderid='" . (int)$input['orderid'] . "'") === false) {
			return false;
		}

		$input['date'] = time();

		if (!$this->addProducts($input, true)) {
			$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
			return false;
		}

		if (!$this->addAddresses($input)) {
			$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
			return false;
		}

		$GLOBALS['ISC_CLASS_DB']->CommitTransaction();

		/**
		 * For the time being, do not import any orders that DO NOT have a customer associated with it (anonymous customers)
		 */
		if (isset($input['customerid']) && isId($input['customerid'])) {

			/**
			 * Add in the previous order
			 */
			$order = $this->get($input['orderid']);
			$order['previous'] = $previousOrder;

			$this->createServiceRequest('order', 'edit', $order, 'order_edit');
		}

		return true;
	}

	/**
	 * Delete a order
	 *
	 * Method will delete a order
	 *
	 * @access public
	 * @param int $orderid The order ID
	 * @param bool $delete TRUE to delete the spool file, FALSE to mark it as deleted. Default is FALSE
	 * @param boolean True to delete any gift certificates that were purchased in this order (only use when deleting incomplete/pending orders)
	 * @return bool TRUE if the order was deleted successfully, FASLE otherwise
	 */
	public function delete($orderid, $delete=false, $deleteGiftCertificates=false)
	{
		if (!isId($orderid)) {
			return false;
		}

		/**
		 * Make sure we have a record to delete. Also too, delete the formsession if we have one
		 */
		$orderData = self::get($orderid);

		if (!$orderData) {
			return false;
		}

		/**
		 * Set up the delete queries we'll be using
		 */
		$queries = array(
			"DELETE FROM [|PREFIX|]orders WHERE orderid = " . (int)$orderid,
			"DELETE FROM [|PREFIX|]order_products WHERE orderorderid = " . (int)$orderid,
			"DELETE FROM [|PREFIX|]order_coupons WHERE ordcouporderid = " . (int)$orderid
		);

		/**
		 * If deleting gift certificates too, add that in to the mix
		 */
		if ($deleteGiftCertificates) {
			$queries[] = "DELETE FROM [|PREFIX|]gift_certificates WHERE giftcertorderid = " . (int)$orderid;
		}

		foreach ($queries as $query) {
			if (!$GLOBALS['ISC_CLASS_DB']->Query($query)) {
				return false;
			}
		}

		/**
		 * Delete the form session if we can
		 */
		if (isId($orderData['ordformsessionid'])) {
			$GLOBALS['ISC_CLASS_FORM']->deleteFormSession($orderData['custformsessionid']);
		}

		/**
		 * Create the spool file
		 */
		$orderData['isactive'] = 0;
		$this->createServiceRequest('order', 'edit', $orderData, 'order_delete');

		return true;
	}

	/**
	 * Delete old incomplete orders
	 *
	 * Method will delete all incomplete orders that are a week old
	 *
	 * @access public
	 * @return bool TRUE if all the incomplete old orders were deleted, FALSE otherwise
	 */
	public function deleteOldOrders()
	{
		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT orderid FROM [|PREFIX|]orders WHERE ordstatus=0 AND orddate < '".(time()-604800)."'");
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			self::delete($row['orderid'], true, true);
		}

		return true;
	}

	/**
	 * Delete multiple orders
	 *
	 * Method will delete multiple orders
	 *
	 * @access public
	 * @param array $orderids The array containing the IDs of the orders to delete
	 * @return bool TRUE if the orders were all deleted, FASLE otherwise
	 */
	public function multiDelete($orderids)
	{
		if (!is_array($orderids)) {
			return false;
		}

		$orderids = array_filter($orderids, 'isId');

		foreach ($orderids as $orderid) {
			self::delete($orderid);
		}

		return true;
	}

	/**
	 * Does order exists?
	 *
	 * Method will return TRUE/FLSE depending if the order exists
	 *
	 * @access public
	 * @param int $orderId The order ID
	 * @return bool TRUE if the order exists, FALASE otherwise
	 */
	public function exists($orderId)
	{
		if (!isId($orderId) || !OrderExists($orderId)) {
			return false;
		}

		return true;
	}

	/**
	 * Get the order record
	 *
	 * Method will return the order record
	 *
	 * @access public
	 * @param int $orderId The order ID
	 * @return array The order array on success, NULL if no record could be found, FALSE on error
	 */
	public function get($orderId)
	{
		if (!isId($orderId)) {
			return false;
		}

		$entity = array();
		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]orders WHERE orderid=" . (int)$orderId);
		if (!($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))) {
			return null;
		}

		$entity = $row;

		$customer = new ISC_ENTITY_CUSTOMER();
		$entity['customer'] = $customer->get($entity['ordcustid']);

		$product = new ISC_ENTITY_PRODUCT();
		$entity['products'] = array();
		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]order_products WHERE orderorderid=" . (int)$orderId);
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$entity['products'][] = $product->get($row['ordprodid']);

			$key = count($entity['products'])-1;
			$entity['products'][$key]['prodorderquantity'] = $row['ordprodqty'];
			$entity['products'][$key]['prodorderamount'] = $row['ordprodcost'];
		}

		return $entity;
	}
}

?>
