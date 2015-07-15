<?php

	if (!defined('ISC_BASE_PATH')) {
		die();
	}

	require_once(ISC_BASE_PATH.'/lib/class.xml.php');
    include_once ISC_BASE_PATH . '/lib/discountcalcs.php';

	class ISC_ADMIN_REMOTE_ORDERS extends ISC_XML_PARSER
	{
		public function __construct()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('orders');
			parent::__construct();
		}

		public function HandleToDo()
		{
			/**
			 * Convert the input character set from the hard coded UTF-8 to their
			 * selected character set
			 */
			convertRequestInput();

			$what = isc_strtolower(@$_REQUEST['w']);

			if(!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
				exit;
			}

			switch ($what) {
				case "updatemultiorderstatusrequest":
					$this->updateOrderStatusBoxRequest();
					break;
				case 'viewgiftwrappingdetails':
					$this->ViewGiftWrappingDetails();
					break;
				case 'createshipment':
					$this->CreateShipment();
					break;
				case 'savenewshipment':
					$this->SaveNewShipment();
					break;
				case 'getshipmentquickview':
					$this->GetShipmentQuickView();
					break;
				case 'viewordernotes':
					$this->ViewOrderNotes();
					break;
				case 'viewcustomfields':
					$this->ViewCustomFields();
					break;
				case 'saveordernotes':
					$this->SaveOrderNotes();
					break;
				case 'loadorderproductfieldsdata':
					$this->LoadOrderProductFields();
					break;
				case 'ordersearchcustomers':
					$this->SearchCustomers();
					break;
				case 'delayedcapture':
					$this->DelayedCapture();
					break;
				case 'loadrefundform':
					$this->LoadRefundForm();
					break;
				case 'voidtransaction':
					$this->VoidTransaction();
					break;
				case 'orderloadcustomeraddresses':
					$this->LoadCustomerAddresses();
					break;
				case 'orderloadcustomerymm':
					$this->orderLoadCustomerYMM();
					break;
				case 'ordersearchproducts':
					$this->SearchProducts();
					break;
				case 'orderremoveproduct':
					$this->OrderRemoveProduct();
					break;
				case 'orderconfigureproduct':
					$this->OrderConfigureProduct();
					break;
				case 'orderaddnewproduct':
					$this->OrderAddProduct();
					break;
				case 'orderupdatetotals':
					$this->OrderUpdateTotals();
					break;
				case 'ordercouponlist':
					$this->OrderCouponList();
					break;
				case 'orderapplycouponcode':
					$this->OrderApplyCouponCode();
					break;
				case 'orderremovegiftcertificate':
					$this->OrderRemoveGiftCertificate();
					break;
				case 'orderselectgiftwrap':
					$this->OrderSelectGiftWrap();
					break;
				case 'ordersavegiftwrap':
					$this->OrderSaveGiftWrap();
					break;
				case 'orderremovegiftwrap':
					$this->OrderRemoveGiftWrap();
					break;
				case 'updateordertimeout':
					$this->UpdateOrderTimeout();
					break;
				case 'orderupdateproductconfig':
					$this->OrderUpdateProductConfig();
					break;
				case 'ordercalculateshipping':
					$this->OrderCalculateShipping();
					break;
				case 'ordersaveshipping':
					$this->OrderSaveShipping();
					break;
				case 'orderremovecoupon':
					$this->OrderRemoveCoupon();
					break;
				case 'previewordrequest':
					$this->PreviewOrderReq();
					break;
				case 'previewordrequestmulty':
					$this->PreviewOrderReqMulty();
					break;
				case 'viewordreview':
					$this->ViewOrderReview();
					break;
                case 'orderremovecompanygiftcertificate':
					$this->OrderRemoveCompanyGiftCertificate();
					break;
			}
		}
		
		/*
		 * Showing the content of the order review request.
		 */
		public function PreviewOrderReq()
		{
			$GLOBALS['ISC_CLASS_ADMIN_REQUESTS'] = GetClass('ISC_ADMIN_REQUESTS');
			if(isset($_GET['selectedId']))
				$selectedId = $_GET['selectedId'];
			else
				$selectedId = 0;
			$GLOBALS['ISC_CLASS_ADMIN_REQUESTS']->TemplateRequest($selectedId);
		}
		/*
		 * Showing the content of the order review request. multy select
		 */
		public function PreviewOrderReqMulty()
		{
			$GLOBALS['ISC_CLASS_ADMIN_REQUESTS'] = GetClass('ISC_ADMIN_REQUESTS');
			if(isset($_GET['selectedId']))
				$selectedId = $_GET['selectedId'];
			else
				$selectedId = 0;
			$GLOBALS['ISC_CLASS_ADMIN_REQUESTS']->TemplateRequestMulty($selectedId);
		}

		/**
		 * Showing the customer review for the order.
		 */
		public function ViewOrderReview()
		{
			if(!isset($_REQUEST['orderId'])) {
				exit;
			}
	
			$order = GetOrder($_REQUEST['orderId'], true);
			if(!isset($order['orderid']) || $order['ordisdigital'] == 1 || ($order['ordtotalqty']-$order['ordtotalshipped']) <= 0) {
				exit;
			}
	
			$GLOBALS['OrderId'] = $order['orderid'];
			$GLOBALS['OrderDate'] = CDate($order['orddate']);
			$GLOBALS['ReviewContent'] = '<tr><th>ProductId</th><th>ProductName</th><th>ReviewText</th><th>ReviewRating</th></tr>';
			$resultCnt = 0;
			
			$query = "
                SELECT r.*, p.productid, p.prodname
				FROM [|PREFIX|]reviews r
				LEFT JOIN [|PREFIX|]products p ON (p.productid=r.revproductid)
				LEFT JOIN [|PREFIX|]order_products o ON (o.ordprodid=p.productid)
				WHERE o.orderorderid='" . $GLOBALS['OrderId'] . "'
				AND r.orderid='" . $GLOBALS['OrderId'] . "'
				AND r.reviewtype=1
				ORDER BY revdate DESC";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)){
				if (isc_strlen($row['prodname']) > 100) {
					$prodName = isc_html_escape(sprintf("%s...", isc_substr($row['prodname'], 0, 100)));
				} else {
					$prodName = isc_html_escape($row['prodname']);
				}
				
				if (isc_strlen($row['revtext']) > 100) {
					$reviewText = isc_html_escape(sprintf("%s...", isc_substr($row['revtext'], 0, 100)));
				} else if (isc_strlen($row['revtext']) == 0) {
					$reviewText = '[no comment]';
				}else{
					$reviewText = isc_html_escape($row['revtext']);
				}
				
				$resultCnt++;
				
				$reviewRate = sprintf("<img width=\"64\" height=\"12\" src=\"%s/images/IcoRating%s.gif\" alt=\"\" />", $GLOBALS['TPL_PATH'], $row['revrating']);
				
				$GLOBALS['ReviewContent'] .= '<tr><td>'.$row['productid'].
                                             '</td><td>'.$prodName.
                                             '</td><td>'.$reviewText.
											 '</td><td>'.$reviewRate.
                                             '</td></tr>';	
			} 
			
			if($resultCnt == 0){ 
				$GLOBALS['ReviewContent'] = '<tr>
												<td class="ReviewContent">
													'.GetLang('NoReviewReceived').'
												</td>
											 </tr>';
			}
			
			//$GLOBALS['ShowApprove'] = '';
			$GLOBALS['ShowApprove'] = 'none';
			
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('order.review');
			return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		 * Remove an applied coupon from this order.
		 */
		private function OrderRemoveCoupon()
		{
			if(!isset($_REQUEST['couponCode']) || !isset($_REQUEST['orderSession'])) {
				exit;
			}

			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$orderClass->GetCartApi($_REQUEST['orderSession'])->RemoveCouponCode($_REQUEST['couponCode']);

			// Generate the order summary again
			$response['orderSummary'] = $orderClass->GenerateOrderSummaryTable();
            $response['orderTable'] = $orderClass->GenerateOrderItemsGrid(true);

			echo isc_json_encode($response);
			exit;
		}

		/**
		 * Save the selected shipping method for this order.
		 */
		private function OrderSaveShipping()
		{
			if(!isset($_REQUEST['orderSession']) || !isset($_REQUEST['shippingMethod'])) {
				exit;
			}

			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$orderClass->GetCartApi($_REQUEST['orderSession']);

			$shippingMethods = $orderClass->GetCartApi()->Get('SHIPPING_QUOTES');

			if($_REQUEST['shippingMethod'] == 'existing') {
				$order = GetOrder($orderClass->GetCartApi()->Get('EXISTING_ORDER'));
				$shippingMethod = array(
					'methodName' => $order['ordshipmethod'],
					'methodCost' => $order['ordshipcost'],
					'methodId' => 'existing',
					'methodModule' => $order['ordershipmodule'],
					'handlingCost' => $order['ordhandlingcost']
				);
			}
			else if($_REQUEST['shippingMethod'] == 'custom') {
				$shippingMethod = array(
					'methodName' => $_REQUEST['customName'],
					'methodCost' => DefaultPriceFormat($_REQUEST['customPrice']),
					'methodId' => '',
					'methodModule' => 'custom',
					'handlingCost' => 0
				);
			}
			else if(isset($shippingMethods[$_REQUEST['shippingMethod']])) {
				$quote = $shippingMethods[$_REQUEST['shippingMethod']];
				$shippingMethod = array(
					'methodName' => $quote['description'],
					'methodCost' => $quote['price'],
					'methodId' => $quote['methodId'],
					'methodModule' => $quote['module'],
					'handlingCost' => $quote['handling']
				);
			}
			else {
				exit;
			}

			$orderClass->GetCartApi()->Set('SHIPPING_METHOD', $shippingMethod);
			$response = array(
				'orderSummary' => $orderClass->GenerateOrderSummaryTable(),
			);
			echo isc_json_encode($response);
			exit;
		}

		/**
		 * Calculate the shipping for an order that's being edited/created.
		 */
		private function OrderCalculateShipping()
		{
			if(!isset($_REQUEST['orderSession'])) {
				exit;
			}

			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$orderClass->GetCartApi($_REQUEST['orderSession']);

			$cartProducts = $orderClass->GetCartApi()->GetProductsInCart();

			$cartClass = GetClass('ISC_CART');
			$address = array(
				'shipzip' => @$_REQUEST['ordshipzip'],
				'shipstate' => @$_REQUEST['ordshipstate'],
				'shipcountry' => @$_REQUEST['ordshipcountry'],
				'shipcountryid' => GetCountryIdByName(@$_REQUEST['ordshipcountry'])
			);
			$address['shipstateid'] = GetStateByName($address['shipstate'], $address['shipcountryid']);

			$shippingMethods = $cartClass->GetAvailableShippingMethodsForProducts($address, $cartProducts, $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId());
			$orderClass->GetCartApi()->Set('SHIPPING_QUOTES', $shippingMethods);

			$existingShippingMethod = $orderClass->GetCartApi()->Get('SHIPPING_METHOD');

			$GLOBALS['ShippingMethods'] = '';
			foreach($shippingMethods as $quoteId => $quote) {
				$checked = '';
				if(is_array($existingShippingMethod) && $quote['description'] == $existingShippingMethod['methodName']) {
					$hasChecked = true;
					$checked = 'checked="checked"';
				}
				$GLOBALS['MethodChecked'] = $checked;
				$GLOBALS['MethodName'] = isc_html_escape($quote['description']);
				$GLOBALS['MethodCost'] = FormatPrice($quote['price']);
				$GLOBALS['MethodId'] = $quoteId;
				$GLOBALS['ShippingMethods'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderShippingMethodChoice');
			}

			$GLOBALS['HideNoShipingMethods'] = 'display: none';
			if(!empty($shippingMethods)) {
				$GLOBALS['HideNoShippingMethods'] = '';
			}

			$existingOrder = $orderClass->GetCartApi()->Get('EXISTING_ORDER');
			$order = GetOrder($existingOrder);
			if($existingOrder !== false && $order['ordshipmethod']) {
				$checked = '';
				if(!isset($hasChecked) && (!is_array($existingShippingMethod) || $order['ordshipmethod'] == $existingShippingMethod['methodName'])) {
					$checked = 'checked="checked"';
				}
				$GLOBALS['MethodChecked'] = $checked;
				$GLOBALS['MethodName'] = sprintf(GetLang('ExistingShippingMethod'), isc_html_escape($order['ordshipmethod']));
				$GLOBALS['MethodCost'] = FormatPrice($order['ordshipcost']);
				$GLOBALS['MethodId'] = 'existing';
				$GLOBALS['ShippingMethods'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderShippingMethodChoice').$GLOBALS['ShippingMethods'];
			}

			$GLOBALS['CustomChecked'] = '';
			$GLOBALS['HideCustom'] = 'display: none';
			if(is_array($existingShippingMethod) && $existingShippingMethod['methodModule'] == 'custom') {
				$GLOBALS['CustomChecked'] = 'checked="checked"';
				$GLOBALS['CustomName'] = isc_html_escape($existingShippingMethod['methodName']);
				$GLOBALS['CustomPrice'] = FormatPrice($existingShippingMethod['methodCost'], false, false);
				$GLOBALS['HideCustom'] = '';
			}

			/* The below patch is added to check the custom shipping if no other shipping method exist - vikas - starts */
			if($GLOBALS['ShippingMethods'] == "")
			{
				$GLOBALS['CustomChecked'] = 'checked="checked"';
				$GLOBALS['CustomName'] = "Custom";
				$GLOBALS['HideCustom'] = '';
			}
			// below custom name has been added as client told to make it readonly.
			if(!isset($GLOBALS['CustomName']))
			{
				$GLOBALS['CustomName'] = "Custom";
			}
			/* - ends -*/
			echo $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderShippingMethodWindow');
			exit;
		}

		/**
		 * Update the configuration (variation, configurable fields etc) for an item in an order that's
		 * being edited/created.
		 */
		private function OrderUpdateProductConfig()
		{
			if(!isset($_REQUEST['cartItemId']) && !isset($_REQUEST['productId']) || !isset($_REQUEST['orderSession'])) {
				exit;
			}

			$cartOptions = array(
				'updateQtfIfExists' => false
			);
			if(isset($_REQUEST['ordcustid']) && $_REQUEST['ordcustid'] != 0) {
				$customerClass = GetClass('ISC_CUSTOMER');
				$customer = $customerClass->GetCustomerInfo($_REQUEST['ordcustid']);
				if(isset($customer['custgroupid'])) {
					$cartOptions['customerGroup'] = $customer['custgroupid'];
				}
			}
			else if(isset($_REQUEST['custgroupid']) && $_REQUEST['custgroupid'] != 0) {
				$cartOptions['customerGroup'] = (int)$_REQUEST['custgroupid'];
			}

			if(isset($_REQUEST['variationId'])) {
				$variationId = $_REQUEST['variationId'];
			}
			else {
				$variationId = 0;
			}

			$productFields = $this->BuildProductConfigurableFieldData();
			$orderClass = GetClass('ISC_ADMIN_ORDERS');

			$orderClass->GetCartApi($_REQUEST['orderSession']);

			// Attempt to update the selected variation
			if(!$orderClass->GetCartApi()->UpdateItemVariation($_REQUEST['cartItemId'], $variationId)) {
				$errors = implode("\n", $orderClass->GetCartApi()->GetErrors());
			}

			if(!isset($errors) && !$orderClass->GetCartApi()->UpdateItemConfiguration($_REQUEST['cartItemId'], $productFields)) {
				$errors = implode("\n", $orderClass->GetCartApi()->GetErrors());
			}

			if(!isset($errors) && !$orderClass->GetCartApi()->UpdateEventDate($_REQUEST['cartItemId'], $_REQUEST['EventDate'])) {
				$errors = implode("\n", $orderClass->GetCartApi()->GetErrors());
			}

			if(isset($errors)) {
				if(!$errors) {
					$errors = GetLang('ErrorUpdatingOrderProduct');
				}

				$response = array(
					'error' => $errors
				);
			}
			else {
				$product = $orderClass->GetCartApi()->GetProductInCart($_REQUEST['cartItemId']);
				$response = array(
					'productRow' => $orderClass->GenerateOrderItemRow($_REQUEST['cartItemId'], $product),
					'orderSummary' => $orderClass->GenerateOrderSummaryTable(),
					'productRowId' => $_REQUEST['cartItemId']
				);
			}

			if(isset($_REQUEST['ajaxFormUpload'])) {
				echo '<textarea>'.isc_json_encode($response).'</textarea>';
				exit;
			}

			echo isc_json_encode($response);
			exit;
		}

		/**
		 * Update the order session for the order that's being edited/created so that it doesn't
		 * timeout.
		 */
		private function UpdateOrderTimeout()
		{
			if(!isset($_REQUEST['orderSession'])) {
				exit;
			}
			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$orderClass->GetCartApi($_REQUEST['orderSession'])->Set('LAST_UPDATED', time());
			echo 1;
			exit;
		}

		/**
		 * Remove the gift wrapping for an item in the order that's being editied/created.
		 */
		private function OrderRemoveGiftWrap()
		{
			if(!isset($_REQUEST['itemId']) || !isset($_REQUEST['orderSession'])) {
				exit;
			}

			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$orderClass->GetCartApi($_REQUEST['orderSession'])->RemoveGiftWrapping($_REQUEST['itemId']);
			$product = $orderClass->GetCartApi()->GetProductInCart($_REQUEST['itemId']);
			$response = array(
				'productRow' => $orderClass->GenerateOrderItemRow($_REQUEST['itemId'], $product),
				'orderSummary' => $orderClass->GenerateOrderSummaryTable(),
				'productRowId' => $_REQUEST['itemId']
			);

			echo isc_json_encode($response);
			exit;
		}

		/**
		 * Save the gift wrapping configuration for an item in the order that's being created/edited.
		 */
		private function OrderSaveGiftWrap()
		{

			if(!isset($_REQUEST['itemId']) || !isset($_REQUEST['orderSession'])) {
				exit;
			}

			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$api = $orderClass->GetCartApi($_REQUEST['orderSession']);

			// Wrapping couldn't be applied so throw an error
			if(!$api->ApplyGiftWrapping($_REQUEST['itemId'], $_REQUEST['giftwraptype'], $_REQUEST['giftwrapping'], $_REQUEST['giftmessage'])) {
				$response = array(
					'error' =>implode("\n", $api->GetErrors())
				);
				echo isc_json_encode($response);
				exit;
			}

			$response = array(
				'orderTable' => $orderClass->GenerateOrderItemsGrid(),
				'orderSummary' => $orderClass->GenerateOrderSummaryTable()
			);

			echo isc_json_encode($response);
			exit;
		}

		/**
		 * Show the modal dialogue to choose the gift wrapping for an item in an order.
		 */
		private function OrderSelectGiftWrap()
		{
			if(!isset($_REQUEST['itemId']) || !isset($_REQUEST['orderSession'])) {
				exit;
			}

			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$cartProduct = $orderClass->GetCartApi($_REQUEST['orderSession'])->GetProductInCart($_REQUEST['itemId'], true);

			if(!is_array($cartProduct)) {
				exit;
			}

			$GLOBALS['GiftWrappingTitle'] = sprintf(GetLang('GiftWrappingForX'), isc_html_escape($cartProduct['product_name']));
			$GLOBALS['ProductName'] = $cartProduct['product_name'];
			$GLOBALS['ItemId'] = $_REQUEST['itemId'];

			$wrapOptions = "";
			if (isset($cartProduct['data']['prodwrapoptions'])) {
				$wrapOptions = $cartProduct['data']['prodwrapoptions'];
			}

			if ($cartProduct["product_id"]) {
				// if the product does exist still, get the actual set of wrap options
				$query = "SELECT prodwrapoptions FROM [|PREFIX|]products WHERE productid = " . $cartProduct["product_id"];
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				if ($wo = $GLOBALS['ISC_CLASS_DB']->FetchOne($result, 'prodwrapoptions')) {
					$wrapOptions = $wo;
				}
			}

			// Get the available gift wrapping options for this product
			if($cartProduct['data']['prodwrapoptions'] == 0) {
				$giftWrapWhere = "wrapvisible='1'";
			}
			else if($cartProduct['data']['prodwrapoptions'] == -1) {
				exit;
			}
			else {
				$wrapOptions = implode(',', array_map('intval', explode(',', $wrapOptions)));
				$giftWrapWhere = "wrapid IN (".$wrapOptions.")";
			}
			$query = "
				SELECT *
				FROM [|PREFIX|]gift_wrapping
				WHERE ".$giftWrapWhere."
				ORDER BY wrapname ASC
			";
			$wrappingOptions = array();
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($wrap = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$wrappingOptions[$wrap['wrapid']] = $wrap;
			}

			// This product is already wrapped, select the existing value
			$selectedWrapping = 0;
			$GLOBALS['GiftWrapMessage'] = '';
			if(isset($cartProduct['wrapping'])) {
				$selectedWrapping = $cartProduct['wrapping']['wrapid'];
			}

			if(isset($cartProduct['wrapping']['wrapmessage'])) {
				$GLOBALS['GiftWrapMessage'] = isc_html_escape($cartProduct['wrapping']['wrapmessage']);
			}

			$GLOBALS['HideGiftWrapMessage'] = 'display: none';

			// Build the list of wrapping options
			$GLOBALS['WrappingOptions'] = '';
			$GLOBALS['GiftWrapPreviewLinks'] = '';
			foreach($wrappingOptions as $option) {
				$sel = '';
				if($selectedWrapping == $option['wrapid']) {
					$sel = 'selected="selected"';
					if($option['wrapallowcomments']) {
						$GLOBALS['HideGiftWrapMessage'] = '';
					}
				}
				$classAdd = '';
				if($option['wrapallowcomments']) {
					$classAdd = 'AllowComments';
				}

				if($option['wrappreview']) {
					$classAdd .= ' HasPreview';
					$previewLink = GetConfig('ShopPath').'/'.GetConfig('ImageDirectory').'/'.$option['wrappreview'];
					if($sel) {
						$display = '';
					}
					else {
						$display = 'display: none';
					}
					$GLOBALS['GiftWrapPreviewLinks'] .= '<a id="GiftWrappingPreviewLink'.$option['wrapid'].'" class="GiftWrappingPreviewLinks" target="_blank" href="'.$previewLink.'" style="'.$display.'">'.GetLang('Preview').'</a>';
				}

				$GLOBALS['WrappingOptions'] .= '<option class="'.$classAdd.'" value="'.$option['wrapid'].'" '.$sel.'>'.isc_html_escape($option['wrapname']).' ('.CurrencyConvertFormatPrice($option['wrapprice']).')</option>';
			}

			if($cartProduct['quantity'] > 1) {
				$GLOBALS['ExtraClass'] = 'PL40';
				$GLOBALS['GiftWrapModalClass'] = 'SelectGiftWrapMultiple';
				$GLOBALS['GiftWrappingOptions'] = '';
				for($i = 1; $i <= $cartProduct['quantity']; ++$i) {
					$GLOBALS['GiftWrappingId'] = $i;
					$GLOBALS['GiftWrappingOptions'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderGiftWrappingOptions');
				}
			}
			else {
				$GLOBALS['HideSplitWrappingOptions'] = 'display: none';
			}

			$GLOBALS['HideWrappingTitle']		= 'display: none';
			$GLOBALS['HideWrappingSeparator']	= 'display: none';
			$GLOBALS['GiftWrappingId'] = 'all';
			$GLOBALS['GiftWrappingOptionsSingle'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderGiftWrappingOptions');

			echo $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderSelectGiftWrapping');
			exit;
		}

		/**
		 * Remove an applied gift certificate from the order that's being edited/created.
		 */
		private function OrderRemoveGiftCertificate()
		{
			if(!isset($_REQUEST['giftCertificateId']) || !isset($_REQUEST['orderSession'])) {
				exit;
			}

			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$orderClass->GetCartApi($_REQUEST['orderSession'])->RemoveAppliedGiftCertificate($_REQUEST['giftCertificateId']);

			// Generate the order summary again
			$response['orderSummary'] = $orderClass->GenerateOrderSummaryTable();

			echo isc_json_encode($response);
			exit;
		}

		/**
		 * Added by vikas
		 * Display list of coupon codes available for the selected products.
		 * 
		 */
		private function OrderCouponList()
		{
			if(!isset($_REQUEST['orderSession'])) {
				exit;
			}

			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$orderClass->GetCartApi($_REQUEST['orderSession']);

			$productids = array();
			$valid_couponcodes = array();
			$GLOBALS['CcString'] = "";
			$cartProducts = $orderClass->GetCartApi()->GetProductsInCart();
			foreach($cartProducts as $key => $val)
			{
				$productids[] = $val['product_id'];
			}

			$coupon_qry = "SELECT * from [|PREFIX|]coupons where couponenabled = 1 and (couponexpires = 0 || UNIX_TIMESTAMP(current_date()) < couponexpires ) order by couponappliesto asc , couponappliestovalues asc";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($coupon_qry);
			while ($arr = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) 
			{
				if( $arr['couponappliesto'] == 'categories')
				{
					if( $arr['couponappliestovalues'] == 0 )
					{
						$valid_couponcodes[] = $arr['couponcode'];
					}
					else
					{
						$catg_qry = "SELECT group_concat(productid) as productid from [|PREFIX|]categoryassociations where categoryid in (".$arr['couponappliestovalues'].")";
						$catg_res = $GLOBALS['ISC_CLASS_DB']->Query($catg_qry);
						$catg_arr = $GLOBALS['ISC_CLASS_DB']->FetchOne($catg_res);
						if($catg_arr != "")
						{
							if( count($productids) == 0 ) // if there are no products added in cart, show the coupon
							{
								$valid_couponcodes[] = $arr['couponcode'];
							}
							else
							{
								$product_ids = explode(",",$catg_arr);
								for($i=0;$i < count($productids);$i++)
								{
									if( in_array($productids[$i] ,  $product_ids))
									{
										$valid_couponcodes[] = $arr['couponcode'];
									}
								}
							}
						}
					}
				}
				else if( $arr['couponappliesto'] == 'products')
				{
						if($arr['couponappliestovalues'] != "")
						{
							if( count($productids) == 0 ) // if there are no products added in cart, show the coupon
							{
								$valid_couponcodes[] = $arr['couponcode'];
							}
							else
							{
								$product_ids = explode(",",$arr['couponappliestovalues']);
								for($i=0;$i < count($productids);$i++)
								{
									if( in_array($productids[$i] ,  $product_ids))
									{
										$valid_couponcodes[] = $arr['couponcode'];
									}
								}
							}
						}
				}
				
			}

			$valid_couponcodes = array_unique($valid_couponcodes);
			sort($valid_couponcodes);
			$GLOBALS['CcString'] .= "<select name='coupon' onchange='selectcoupon(this.value);'>";
			$GLOBALS['CcString'] .= "<option value=''> ----- SELECT ---- </option>";
			foreach($valid_couponcodes as $key => $code)
			{
				$GLOBALS['CcString'] .= "<option value='$code'>$code</option>";
			}
			$GLOBALS['CcString'] .= "</select>";

			
			echo $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderCouponListWindow');
			exit;
		}

		/**
		 * Apply a coupon code or gift certificate code to the order that's being created/edited.
		 */
		private function OrderApplyCouponCode()
		{
			if(!isset($_REQUEST['couponCode']) || !isset($_REQUEST['orderSession'])) {
				exit;
			}

			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$api = $orderClass->GetCartApi($_REQUEST['orderSession']);

			$response = array();

			$code = trim($_REQUEST['couponCode']);

			// If we were passed a gift certificate code, attempt to apply it first
			if(isc_strlen($code) == GIFT_CERTIFICATE_LENGTH && gzte11(ISC_LARGEPRINT)) {
				if(!$api->ApplyGiftCertificate($code)) {
					$errors = implode("\n", $api->GetErrors());
				}
			} elseif (!(CheckExistsCouponCode($code)) && CheckExistsCompanyGiftCertificateCode($code)) {
                if (!$api->ApplyCompanyGiftCertificate($code)) {
                    $errors = implode("\n", $api->GetErrors());
                }
            } else {
                // Otherwise, it must be a coupon code
				if(!$api->ApplyCoupon($code)) {
					$errors = implode("\n", $api->GetErrors());
				}
				else {
					// If we've applied a coupon code, we need to refresh the entire grid of order items
					// as prices may have also changed.
					$response['orderTable'] = $orderClass->GenerateOrderItemsGrid();
				}
			}

			if(isset($errors)) {
				$response['error'] = $errors;
			}

			// Generate the order summary again
			$response['orderSummary'] = $orderClass->GenerateOrderSummaryTable();

			echo isc_json_encode($response);
			exit;
		}

		/**
		 * Remove a product/item from the order that's being edited/created.
		 */
		private function OrderRemoveProduct()
		{
			if(!isset($_REQUEST['cartItemId']) || !isset($_REQUEST['orderSession'])) {
				exit;
			}

			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$rowId = $orderClass->GetCartApi($_REQUEST['orderSession'])->RemoveItem($_REQUEST['cartItemId']);

			$response = array(
				'orderSummary' => $orderClass->GenerateOrderSummaryTable()
			);
			echo isc_json_encode($response);
			exit;
		}

		/**
		 * Show the window to configure an item (variations, configurable fields) etc in the
		 * order that's being created/edited.
		 */
		private function OrderConfigureProduct()
		{
			if(!isset($_REQUEST['cartItemId']) || !isset($_REQUEST['orderSession'])) {
				exit;
			}

			// Initialize the cart management API
			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$orderClass->GetCartApi($_REQUEST['orderSession']);

			$existingProduct = $orderClass->GetCartApi()->GetProductInCart($_REQUEST['cartItemId']);
			if(is_array($existingProduct)) {
				if(isset($_REQUEST['productId']) && $existingProduct['product_id'] != $_REQUEST['productId']) {
					$existingProduct = false;
				}
				else {
					$_REQUEST['productId'] = $existingProduct['product_id'];
				}
			}

			// Fetch the product class on the front end as it'll be doing most of the work for this page
			$productClass = new ISC_PRODUCT($_REQUEST['productId']);
			if(!$productClass->GetProductId()) {
				exit;
			}

			if(!is_array($existingProduct) && !isset($_REQUEST['productId'])) {
				exit;
			}
			else if(is_array($existingProduct)) {
				$GLOBALS['EditingExistingProduct'] = 1;
				$GLOBALS['Intro'] = GetLang('OrderConfigureProductEdit');
				$GLOBALS['ButtonLabel'] = GetLang('OrderConfigureProductEditButton');
				$productPrice = $existingProduct['product_price'];
				$GLOBALS['VariationId'] = $existingProduct['variation_id'];
			}
			else {
				$GLOBALS['Intro'] = GetLang('OrderConfigureProduct');
				$GLOBALS['ButtonLabel'] = GetLang('AddProductToOrder');

				// Finally, determine the price based on the customer group
				$product = $productClass->GetProduct();
				$productPrice = CalcProdCustomerGroupPrice($product, $product['prodcalculatedprice']);
			}

			$GLOBALS['ProductPrice'] = FormatPrice($productPrice);

			$productVariations = $productClass->GetProductVariations();

			$GLOBALS['ProductName'] = isc_html_escape($productClass->GetProductName());
			$GLOBALS['ProductId'] = (int)$productClass->GetProductId();
			$GLOBALS['OrderSession'] = isc_html_escape($_REQUEST['orderSession']);
			$GLOBALS['CartItemId'] = isc_html_escape($_REQUEST['cartItemId']);
			$GLOBALS['Quantity'] = (int)$_REQUEST['quantity'];
			$GLOBALS['ProductOptionRequired'] = 0;

			$GLOBALS['VariationList'] = '';
			if(!empty($productVariations)) {
				// If we have an existing variation already, look up the combination
				$existingCombination = array();
				if(is_array($existingProduct) && $existingProduct['variation_id']) {
					$query = "
						SELECT vcoptionids
						FROM [|PREFIX|]product_variation_combinations
						WHERE combinationid='".(int)$existingProduct['variation_id']."'
					";
					$existingCombination = explode(',', $GLOBALS['ISC_CLASS_DB']->FetchOne($query));
				}
				if($productClass->IsOptionRequired()) {
					$GLOBALS['ProductOptionRequired'] = 1;
					$GLOBALS['VariationRequired'] = '*';
				}
				else {
					$GLOBALS['VariationRequired'] = '&nbsp;';
				}

				$GLOBALS['VariationNumber'] = 0;
				foreach($productVariations as $name => $options) {
					$GLOBALS['VariationNumber']++;
					$optionList = '';

					foreach($options as $option) {
						$sel = '';
						if(in_array($option['voptionid'], $existingCombination)) {
							$sel = 'selected="selected"';
						}
						$optionList .= '<option value="'.$option['voptionid'].'" '.$sel.'>'.isc_html_escape($option['vovalue']).'</option>';
					}

					$GLOBALS['VariationOptions'] = $optionList;
					$GLOBALS['VariationName'] = isc_html_escape($name);
					$GLOBALS['VariationList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderProductConfigurationVariation');
				}
				$GLOBALS['ProductVariationJavascript'] = $productClass->GetProductVariationCombinationJavascript();
			}
			else {
				$GLOBALS['HideVariationList'] = 'display: none';
			}

			$fields = $productClass->GetProductFields($_REQUEST['productId']);

			$GLOBALS['ProductFields'] = '';
			if(!empty($fields)) {
				foreach($fields as $field) {
					$GLOBALS['FieldId'] = $field['id'];
					$GLOBALS['FieldRequired'] = '&nbsp;';
					$requiredClass = '';
					$GLOBALS['FieldName'] = isc_html_escape($field['name']).':';
					$GLOBALS['HideFieldHelp'] = 'display: none';
					$GLOBALS['FieldHelp'] = '';
					$GLOBALS['HideFileCurrentValue'] = 'display: none';

					$existingValue = '';
					if(isset($existingProduct['product_fields'][$field['id']])) {
						if($field['type'] == 'file') {
							$existingValue = isc_html_escape($existingProduct['product_fields'][$field['id']]['fileOriginName']);
							$existingFileName = $existingProduct['product_fields'][$field['id']]['fileName'];
						}
						else {
							$existingValue = isc_html_escape($existingProduct['product_fields'][$field['id']]['fieldValue']);
						}
					}

					if($field['required'] == 1) {
						$requiredClass = 'FieldRequired';
						$GLOBALS['FieldRequired'] = '*';
					}

					switch($field['type']) {
						case 'textarea':
							$inputField = '<textarea cols="30" rows="3" name="productFields['.$field['id'].']" class="Field300 '.$requiredClass.'">'.$existingValue.'</textarea>';
							break;
						case 'file':
							if($existingValue) {
								$requiredClass .= 'HasExistingValue';
							}
							$inputField = '<input type="file" name="productFields['.$field['id'].']" class="Field300 '.$requiredClass.'" />';
							$help = array();
							if($field['fileSize'] > 0) {
								$help[] = GetLang('MaximumSize').': '.NiceSize($field['fileSize']*1024);
							}
							if($field['fileType'] != '') {
								$help[] = GetLang('AllowedTypes').': '.'<span class="FileTypes">'.isc_strtoupper(isc_html_escape($field['fileType']).'</span>');
							}
							$help = implode('. ', $help);
							if($help != '') {
								$GLOBALS['HideFieldHelp'] = '';
								$GLOBALS['FieldHelp'] = '<em>('.$help.')</em>';
							}

							if($existingValue) {
								$GLOBALS['HideFileCurrentValue'] = '';
								if(!$field['required']) {
									$GLOBALS['HideRemoveFile'] = 'display: none';
								}
								$GLOBALS['CurrentFileName'] = $existingValue;
								if(isset($existingProduct['product_fields'][$field['id']]['fieldExisting'])) {
									$fileDirectory = 'configured_products';
								}
								else {
									$fileDirectory = 'configured_products_tmp';
								}
								$GLOBALS['CurrentFileLink'] = GetConfig('ShopPath').'/'.GetConfig('ImageDirectory').'/'.$fileDirectory.'/'.$existingFileName;
							}
							break;
						case 'checkbox':
							$checked = '';
							if($existingValue) {
								$checked = 'checked="checked"';
							}
							$inputField = '<label><input type="checkbox" name="productFields['.$field['id'].']" '.$checked.' value="1" /> '.GetLang('TickToSelect').'</label>';
							break;
						default:
							$inputField = '<input type="text" name="productFields['.$field['id'].']" class="Field300 '.$requiredClass.'" value="'.$existingValue.'"/>';
					}

					$GLOBALS['InputField'] = $inputField;
					$GLOBALS['ProductFields'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderProductConfigurationField');
				}
			}
			else {
				$GLOBALS['HideConfigurableFields'] = 'display: none';
			}

			if ($productClass->GetEventDateRequired() == 1) {

				$this->LoadEventDate($productClass, $existingProduct);

			} else {
				$GLOBALS['EventDate'] = '';
				$GLOBALS['HideEventDate'] = 'display : none;';
			}

			echo $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderProductConfiguration');
			exit;
		}


		public function LoadEventDate($product, $existingProduct)
		{
			$currentDate = $existingProduct['event_date'];

			$GLOBALS['EventDateName'] = $product->GetEventDateFieldName();

			$from_stamp = $product->GetEventDateLimitedStartDate();
			$to_stamp = $product->GetEventDateLimitedEndDate();

			$to_day = isc_date("d", $to_stamp);
			$from_day = isc_date("d", $from_stamp);

			$to_month = isc_date("m", $to_stamp);
			$from_month = isc_date("m", $from_stamp);

			$to_year = isc_date("Y", $to_stamp);
			$from_year = isc_date("Y", $from_stamp);

			$to_date = isc_date('jS M Y',$to_stamp);
			$from_date = isc_date('jS M Y',$from_stamp);

			$eventDateInvalidMessage = sprintf(GetLang('EventDateInvalid'), strtolower($GLOBALS['EventDateName']));

			$comp_date = '';
			$comp_date_end = '';
			$eventDateErrorMessage = '';

			$edlimited = $product->GetEventDateLimited();
			if (empty($edlimited)) {
				$from_year = isc_date('Y');
				$to_year = isc_date('Y',isc_gmmktime(0, 0, 0, 0,0,isc_date('Y')+5));
				$GLOBALS['EventDateLimitations'] = '';
			} else {
				if ($product->getEventDateLimitedType() == 1) {
					$GLOBALS['EventDateLimitations'] = sprintf(GetLang('EventDateLimitations1'), $from_date,$to_date);

					$comp_date = isc_date('Y/m/d', $from_stamp);
					$comp_date_end = isc_date('Y/m/d', $to_stamp);

					$eventDateErrorMessage = sprintf(GetLang('EventDateLimitationsLong1'), strtolower($GLOBALS['EventDateName']),$from_date, $to_date);

				} else if ($product->getEventDateLimitedType() == 2) {
					$to_year = isc_date('Y', isc_gmmktime(0, 0, 0, isc_date('m',$from_stamp),isc_date('d',$from_stamp),isc_date('Y',$from_stamp)+5));
					$GLOBALS['EventDateLimitations'] = sprintf(GetLang('EventDateLimitations2'), $from_date);

					$comp_date = isc_date('Y/m/d', $from_stamp);

					$eventDateErrorMessage = sprintf(GetLang('EventDateLimitationsLong2'), strtolower($GLOBALS['EventDateName']),$from_date);


				} else if ($product->getEventDateLimitedType() == 3) {
					$from_year = isc_date('Y', time());
					$GLOBALS['EventDateLimitations'] = sprintf(GetLang('EventDateLimitations3'),$to_date);

					$comp_date = isc_date('Y/m/d', $to_stamp);

					$eventDateErrorMessage = sprintf(GetLang('EventDateLimitationsLong3'), strtolower($GLOBALS['EventDateName']),$to_date);
				}
			}


			$GLOBALS['OverviewToDays'] = $this->_GetDayOptions(isc_date('j', $currentDate));
			$GLOBALS['OverviewToMonths'] = $this->_GetMonthOptions(isc_date('n', $currentDate));
			$GLOBALS['OverviewToYears'] = $this->_GetYearOptions($from_year,$to_year,isc_date('Y', $currentDate));

			$GLOBALS['EventDateMonthStyle'] = ' width : 44px; font-size : 90%;';
			$GLOBALS['EventDateDayStyle'] = 'width : 40px; font-size : 90%;';
			$GLOBALS['EventDateYearStyle'] = 'width : 50px; font-size : 90%;';

			$GLOBALS['EventDate'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderProductEventDate');

			$GLOBALS['EventDateJavascript'] = sprintf("var eventDateData = {type:'%s',compDate:'%s',compDateEnd:'%s',invalidMessage:'%s',errorMessage:'%s'};",
				$product->getEventDateLimitedType(),
				$comp_date,
				$comp_date_end,
				$eventDateInvalidMessage,
				$eventDateErrorMessage
			);
		}

		private function _GetDayOptions($d)
		{
			$output = "";

			$output .= '<option value=\'-1\'>---</option>';

			for($i = 1; $i <= 31; $i++) {

				if ($i == $d) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				}

				$output .= sprintf("<option value='%d' %s>%s</option>", $i, $selected, $i);
			}

			return $output;
		}

		/**
			*	Return a list of months as option tags
			*/
		private function _GetMonthOptions($m)
		{
			$output = "";
			$output .= '<option value=\'-1\'>---</option>';

			for($i = 1; $i <= 12; $i++) {
				$stamp = isc_gmmktime(0, 0, 0, $i, 1, 2000);
				$month = isc_date("M", $stamp);

				if ($i == $m) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				}

				$output .= sprintf("<option value='%d' %s >%s</option>", $i, $selected, $month);
			}

			return $output;
		}

		/**
			*	Return a list of years as option tags
			*/
		private function _GetYearOptions($from, $to, $y)
		{
			$output = "";
			$output .= '<option value=\'-1\'>---</option>';

			for($i = $from; $i <= $to; $i++) {

				if ($i == $y) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				}

				$output .= sprintf("<option value='%d' %s >%s</option>", $i, $selected,  $i);
			}

			return $output;
		}


		/**
		 * Build a normalized array containing information about configurable product fields
		 * from the POST.
		 *
		 * @return array A normalized array of files/fields for configurable fields.
		 */
		private function BuildProductConfigurableFieldData()
		{
			$configurableFields = array();
			if(isset($_REQUEST['productFields']) && is_array($_REQUEST['productFields'])) {
				$configurableFields = $_REQUEST['productFields'];
			}

			if(isset($_FILES['productFields']) && is_array($_FILES['productFields'])) {
				$fileFields = array_keys($_FILES['productFields']);
				foreach(array_keys($_FILES['productFields']['name']) as $fieldId) {
					$configurableFields[$fieldId] = array();
					foreach($fileFields as $field) {
						if(!isset($_FILES['productFields'][$field][$fieldId])) {
							continue;
						}
						$configurableFields[$fieldId][$field] = $_FILES['productFields'][$field][$fieldId];
					}
				}
			}
			return $configurableFields;
		}

		/**
		 * Add a product to the order that's being created/edited.
		 */
		private function OrderAddProduct()
		{
			if(!isset($_REQUEST['cartItemId']) && !isset($_REQUEST['productId']) || !isset($_REQUEST['orderSession'])) {
				exit;
			}

			$cartOptions = array(
				'updateQtyIfExists' => false
			);

			if (isset($_REQUEST['EventDate'])) {
				$cartOptions['EventDate'] = isc_gmmktime(0,0,0,$_REQUEST['EventDate']['Mth'],$_REQUEST['EventDate']['Day'],$_REQUEST['EventDate']['Yr']);
			}

			if(isset($_REQUEST['ordcustid']) && $_REQUEST['ordcustid'] != 0) {
				$customerClass = GetClass('ISC_CUSTOMER');
				$customer = $customerClass->GetCustomerInfo($_REQUEST['ordcustid']);
				if(isset($customer['custgroupid'])) {
					$cartOptions['customerGroup'] = $customer['custgroupid'];
				}
			}
			else if(isset($_REQUEST['custgroupid']) && $_REQUEST['custgroupid'] != 0) {
				$cartOptions['customerGroup'] = (int)$_REQUEST['custgroupid'];
			}

			if(isset($_REQUEST['variationId'])) {
				$variationId = $_REQUEST['variationId'];
			}
			else {
				$variationId = 0;
			}

			if(isset($_REQUEST['customerGroup'])) {
				$orderDetails['customerGroup'] = (int)$_REQUEST['customerGroup'];
			}

			/* -- Added below condition to check if YMM values coming from dropdown, then need to decode - starts */

			if( isset($_REQUEST['ymmID']) && $_REQUEST['ymmID'] == 0)
			{
				if(isset($_REQUEST['ymmmake']))
					$_REQUEST['ymmmake'] = MakeURLNormal($_REQUEST['ymmmake']);

				if(isset($_REQUEST['ymmmodel']))
					$_REQUEST['ymmmodel'] = MakeURLNormal($_REQUEST['ymmmodel']);
			}

			/* -- ends -- */
			$productFields = $this->BuildProductConfigurableFieldData();
			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			$rowId = $orderClass->GetCartApi($_REQUEST['orderSession'])->AddItem($_REQUEST['productId'], $_REQUEST['quantity'], $variationId, $productFields, $_REQUEST['cartItemId'], $cartOptions);

			if($rowId === false) {
				$errors = implode("\n", $orderClass->GetCartApi()->GetErrors());
				if(!$errors) {
					$errors = GetLang('ErrorAddingProductToOrder');
				}

				$response = array(
					'error' => $errors
				);
			}
			else {
				$product = $orderClass->GetCartApi()->GetProductInCart($rowId);
                $catquery = " SELECT DISTINCT c.categoryid, p.brandseriesid
                FROM isc_categories c                                                 
                LEFT JOIN isc_categoryassociations ca ON c.categoryid = ca.categoryid 
                LEFT JOIN isc_products p ON ca.productid = p.productid AND p.prodvisible='1'
                WHERE p.productid= ".$product['product_id']."";                                                              

                $relcats = array();
                $brandseries = 0;
                $catresult = $GLOBALS['ISC_CLASS_DB']->Query($catquery);
                while($catrow = $GLOBALS['ISC_CLASS_DB']->Fetch($catresult)) { 
                    $relcats[]   = $catrow['categoryid'];
                    $brandseries = $catrow['brandseriesid'];
                }
                if ($product['data']['prodsaleprice'] > 0 && $product['data']['prodsaleprice'] < $product['product_price']) {
                    $product['product_price'] = $product['data']['prodsaleprice'];
                } else {
                    $product['discount_price'] = CalculateDiscountPrice($product['product_price'], $product['product_price'], $relcats[0], $brandseries);
                    $orderClass->GetCartApi()->SetItemValue($rowId, 'discount_price', $product['discount_price']);
//                    $product['product_price'] = CalculateDiscountPrice($product['product_price'], $product['product_price'], $relcats[0], $brandseries);
                }
				$product['vendorprefix'] = $orderClass->GetProductVendorprefix($product['product_id']);
                $orderClass->GetCartApi()->SetItemValue($rowId, 'product_price', $product['product_price']);
				
				$response = array(
					'productRow' => $orderClass->GenerateOrderItemRow($rowId, $product),
					'orderSummary' => $orderClass->GenerateOrderSummaryTable(),
					'productRowId' => $rowId
				);

				if($_REQUEST['cartItemId'] != $rowId) {
					$response['removeRow'] = (string)$_REQUEST['cartItemId'];
				}
			}

			if(isset($_REQUEST['ajaxFormUpload'])) {
				echo '<textarea>'.isc_json_encode($response).'</textarea>';
				exit;
			}

			echo isc_json_encode($response);
			exit;
		}

		/**
		 * Update the totals for all of the items in the order that's being created/edited.
		 */
		private function OrderUpdateTotals($silent=false)
		{
            $products = array();
            $cartItem = $_REQUEST['cartItem'];
            $orderClass = GetClass('ISC_ADMIN_ORDERS');
            $api = $orderClass->GetCartApi($_REQUEST['orderSession']);
            
            foreach ($cartItem as $itemId => $product) {
                if ($itemId === "rowtemplate" || $product['productid'] == 0) {
					continue;
				}
                if (isset($products[$product['productid']])) {
                    $products[$product['productid']]['quantity'] += ($product['quantity'] > 1 ? $product['quantity'] : 1);
                    $products[$product['productid']]['prodprice'] = $product['prodprice'];
                }else {
                    $products[$product['productid']] = array_merge($product, array('item_id' => $itemId));
                }
                unset($_REQUEST['cartItem'][$itemId]);
            }
            foreach ($products as $product) {
                $_REQUEST['cartItem'][$product['item_id']] = $product;
            }
            
            // remove old product in cart
            $cartItem = $api->GetProductsInCart();
            foreach (array_keys($cartItem) as $itemId) {
                if (!isset($_REQUEST['cartItem'][$itemId])) {
                    $api->RemoveItem($itemId);
                }
            }
            unset($cartItem, $products);
            
			if(!isset($_REQUEST['orderSession']) || !isset($_REQUEST['cartItem']) || !is_array($_REQUEST['cartItem'])) {
				exit;
			}

			$errors = array();
			foreach($_REQUEST['cartItem'] as $itemId => $product) {
				if ($itemId === "rowtemplate") {
					continue;
				}

				// If this item doesn't already exist in the cart, then it's something the user has added
				// themselves (fake product etc), so we need to add it
                
				$origProd = $api->GetProductInCart($itemId);
				
				if(!is_array($origProd) && $product['productid'] == 0 && $api->AddVirtualItem($product, $itemId) === false) {
					if ($api->HasErrors()) {
						$errors[] = implode("\n", $api->GetErrors());
					}
					continue;
				}
				if($api->UpdateCartProduct($itemId, $product) === false && $product['productid'] != 0) {
					if ($api->HasErrors()) {
						$errors[] = implode("\n", $api->GetErrors());
					}
					continue;
				}
                
				// 2011-08-22 johnny modify
				if($product['productid'] == 0){
					$errors[] = "Invalid SKU/Product name detected.";
					continue;
				}
				if(!$orderClass -> CheckProductExist($product['productid'], $product['prodcode'], $product['prodname'])){
					$errors[] = "Unmatched SKU-Product Name detected.";
					continue;
				}
                
//                $itemId = $api->AddItem($product['productid'], $product['quantity'], null, null, $itemId);
                $origProd = $api->GetProductInCart($itemId);
                
				//alandy add reset price function.
				if(isset($product['resetPrice']) && $product['resetPrice']==1){
					$api->SetItemValue($itemId, 'is_reset_price', $product['resetPrice']);
                    $api->SetItemValue($itemId, 'product_price', $product['prodprice']);
				}else{
					$api->SetItemValue($itemId, 'is_reset_price', 0);
						//alandy_20110428 added. now we need to refetch the product latest saleprice & prodprice.
                    $query = "SELECT * FROM [|PREFIX|]products WHERE productid='".$origProd['product_id']."'";

                    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);

                    while($product = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                        $product_newsaleprice=$product['prodsaleprice'];
                        $product_newprodprice=$product['prodprice'];
                    }

                    if( $product_newsaleprice > 0 && $product_newsaleprice < $origProd['product_price']){
                        $origProd['product_price'] = $product_newsaleprice;
                        $api->SetItemValue($itemId, 'product_price', $origProd['product_price']);
                    }
                        
				}              
   
			}
			
			$response = array(
				'orderTable' => $orderClass->GenerateOrderItemsGrid(true),
				'orderSummary' => $orderClass->GenerateOrderSummaryTable()
			);
			

			if(!empty($errors)) {
				$errors = array_unique($errors);
				$response['error'] = implode("\n", $errors);
			}

			if($silent == false || isset($response['error'])) {
				echo isc_json_encode($response);
				exit;
			}
		}

		/**
		 * Return a JSON response with all of the addresses from the address book
		 * for the selected customer.
		 */
		private function LoadCustomerAddresses()
		{
			$tags = array();
			if(!isset($_REQUEST['customerId']) || !IsId($_REQUEST['customerId'])) {
				exit;
			}

			$orderClass = GetClass('ISC_ADMIN_ORDERS');
			echo isc_json_encode($orderClass->LoadCustomerAddresses($_REQUEST['customerId']));
			exit;
		}
	private function orderLoadCustomerYMM()
		{
			
			$tags = array();
			if(!isset($_REQUEST['customerId']) || !IsId($_REQUEST['customerId'])) {
				exit;
			}

			$orderClass = GetClass('ISC_ADMIN_CLARION');
			echo $orderClass->fnLoadCustomerYMM($_REQUEST['customerId'],$type=1);
			exit;
		}


		private function LoadRefundForm()
		{
			if(!isset($_REQUEST['orderid'])) {
				exit;
			}
			$orderId = $_REQUEST['orderid'];

			$GLOBALS['CurrencyToken'] = GetConfig('CurrencyToken');
			$GLOBALS['OrderId'] = (int)$orderId;
			echo $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderRefundForm');
			exit;
		}


		private function VoidTransaction()
		{
			if(!isset($_REQUEST['orderid'])) {
				exit;
			}
			$orderId = $_REQUEST['orderid'];
			$order = GetOrder($_REQUEST['orderid']);
			if(!isset($order['orderid'])) {
				exit;
			}

			$message = '';
			$provider = null;
			$paymentStatus = 2;
			$msgStatus = MSG_ERROR;
			$transactionId = trim($order['ordpayproviderid']);
			if($transactionId == '') {
				$message = GetLang('OrderTranscationIDNotFound');
			}
			elseif(!GetModuleById('checkout', $provider, $order['orderpaymentmodule'])) {
				$message = GetLang('PaymentMethodNotExist');
			}
			elseif(!$provider->IsEnabled()) {
				$message = GetLang('PaymentProviderIsDisabled');
			}
			elseif(!method_exists($provider, "DoVoid")) {
				$message = GetLang('VoidNotAvailable');
			}
			else {
				//still here, perform a delay capture
				if($provider->DoVoid($orderId, $transactionId, $message)) {

					$paymentStatus = 1;
					$msgStatus = MSG_SUCCESS;
					//update order status
					$orderStatus = ORDER_STATUS_CANCELLED;
					UpdateOrderStatus($order['orderid'], $orderStatus, true);
				}
			}

			FlashMessage($message, $msgStatus);
			$tags[] = $this->MakeXMLTag('status', $paymentStatus);
			$tags[] = $this->MakeXMLTag('message', $message, true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		private function DelayedCapture()
		{
			if(!isset($_REQUEST['orderid'])) {
				exit;
			}
			$orderId = $_REQUEST['orderid'];
			$order = GetOrder($_REQUEST['orderid']);
			if(!isset($order['orderid'])) {
				exit;
			}
			$message = '';
			$provider = null;
			$paymentStatus = 2;
			$msgStatus = MSG_ERROR;
			$transactionId = trim($order['ordpayproviderid']);
			if($transactionId == '') {
				$message = GetLang('OrderTranscationIDNotFound');
			}
			elseif(!GetModuleById('checkout', $provider, $order['orderpaymentmodule'])) {
				$message = GetLang('PaymentMethodNotExist');
			}
			elseif(!$provider->IsEnabled()) {
				$message = GetLang('PaymentProviderIsDisabled');
			}
			elseif(!method_exists($provider, "DelayedCapture")) {
				$message = GetLang('DelayedCaptureNotAvailable');
			}
			else {
				//still here, perform a delay capture
				if($provider->DelayedCapture($order, $message, $order['ordgatewayamount'])) {
					$paymentStatus = 1;
					$msgStatus = MSG_SUCCESS;
					//update order status
					if($order['ordisdigital'] == 0 && ($order['ordtotalqty']-$order['ordtotalshipped']) > 0) {
						$orderStatus = ORDER_STATUS_AWAITING_SHIPMENT;
					} else {
						$orderStatus = ORDER_STATUS_COMPLETED;
					}

					UpdateOrderStatus($order['orderid'], $orderStatus, true);
				}
			}

			FlashMessage($message, $msgStatus);
			$tags[] = $this->MakeXMLTag('status', $paymentStatus);
			$tags[] = $this->MakeXMLTag('message', $message, true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		private function SaveOrderNotes()
		{
			if(!isset($_REQUEST['orderId'])) {
				exit;
			}

			$order = GetOrder($_REQUEST['orderId']);
			if(!isset($order['orderid'])) {
				exit;
			}

			$updatedOrder = array(
				'ordnotes' => urldecode($_REQUEST['ordnotes'])
			);

			if(!$GLOBALS['ISC_CLASS_DB']->UpdateQuery("orders", $updatedOrder, "orderid='".(int)$_REQUEST['orderId']."'")) {
				exit;
			}

			$message = sprintf(GetLang('OrderNotesSuccessMsg'), $order['orderid']);
			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('message', $message, true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		private function ViewOrderNotes()
		{
			if(!isset($_REQUEST['orderId']) || ! isId($_REQUEST['orderId'])) {
				exit;
			}

			// Load the order
			$order = GetOrder($_REQUEST['orderId']);
			if(!$order || ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId())) {
				exit;
			}

			$GLOBALS['OrderID'] = $order['orderid'];
			$GLOBALS['OrderNotes'] = isc_html_escape($order['ordnotes']);

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("orders.notes.popup");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		private function ViewCustomFields()
		{
			if(!isset($_REQUEST['orderId']) || ! isId($_REQUEST['orderId'])) {
				exit;
			}

			// Load the order
			$order = GetOrder($_REQUEST['orderId']);
			if(!$order || ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $order['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId())) {
				exit;
			}

			$fields = null;
			if ($order['ordcustomfields'] !== '') {
				$fields = unserialize($order['ordcustomfields']);
			}

			$GLOBALS['OrderID'] = $order['orderid'];
			$GLOBALS['OrderCustomFieldsPopupHeading'] = sprintf(GetLang('OrderCustomFieldsPopupHeading'), $order['orderid']);
			$GLOBALS['OrderCustomFields'] = '';

			if (!is_array($fields) || empty($fields)) {
				$GLOBALS['HideCustomFields'] = 'none';
			} else {
				$GLOBALS['HideMissingCustomFields'] = 'none';

				foreach ($fields as $widgetId => $data) {
					if ($data['type'] == 'singlecheckbox') {
						$data['data'] = GetLang('Yes');
					}

					$GLOBALS['CustomFieldLabel'] = isc_html_escape($data['label']);
					$GLOBALS['CustomFieldData'] = isc_html_escape($data['data']);
					$GLOBALS['OrderCustomFields'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrderCustomFields');
				}
			}

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("orders.customfields.popup");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		public function GetShipmentQuickView()
		{
			if(!isset($_REQUEST['shipmentId'])) {
				exit;
			}

			$GLOBALS['ISC_CLASS_ADMIN_SHIPMENTS'] = GetClass('ISC_ADMIN_SHIPMENTS');
			echo $GLOBALS['ISC_CLASS_ADMIN_SHIPMENTS']->GetShipmentQuickView($_REQUEST['shipmentId']);
		}

		/**
		 * Create a shipment of one or more items from an order.
		 */
		public function CreateShipment()
		{
			$GLOBALS['ISC_CLASS_ADMIN_SHIPMENTS'] = GetClass('ISC_ADMIN_SHIPMENTS');
			$GLOBALS['ISC_CLASS_ADMIN_SHIPMENTS']->CreateShipment();
		}

		/**
		 * Save a shipment of one or more items from an order.
		 */
		public function SaveNewShipment()
		{
			$GLOBALS['ISC_CLASS_ADMIN_SHIPMENTS'] = GetClass('ISC_ADMIN_SHIPMENTS');
			$GLOBALS['ISC_CLASS_ADMIN_SHIPMENTS']->SaveNewShipment();
		}

		/**
		 * View the details for gift wrapping for a particular item.
		 */
		public function ViewGiftWrappingDetails()
		{
			if(!isset($_REQUEST['orderprodid']) || !IsId($_REQUEST['orderprodid'])) {
				exit;
			}

			$query = "
				SELECT *
				FROM [|PREFIX|]order_products
				WHERE orderprodid='".(int)$_REQUEST['orderprodid']."'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$orderProduct = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			if(!isset($orderProduct['ordprodid']) || !$orderProduct['ordprodwrapname']) {
				exit;
			}

			$GLOBALS['ProductName'] = isc_html_escape($orderProduct['ordprodname']);
			$GLOBALS['ProductQuantity'] = $orderProduct['ordprodqty'];
			$GLOBALS['WrapName'] = isc_html_escape($orderProduct['ordprodwrapname']);
			$GLOBALS['WrapPrice'] = FormatPrice($orderProduct['ordprodwrapcost']);
			if($orderProduct['ordprodwrapmessage']) {
				$GLOBALS['WrapMessage'] = nl2br(isc_html_escape($orderProduct['ordprodwrapmessage']));
			}
			else {
				$GLOBALS['HideWrapMessage'] = 'display: none';
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("order.viewwrapping");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function updateOrderStatusBoxRequest()
		{
			$success = (int)@$_REQUEST['success'];
			$failed = (int)@$_REQUEST['failed'];
			$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]order_status WHERE statusid='" . $GLOBALS['ISC_CLASS_DB']->Quote(@$_REQUEST['statusId']) . "'");
			$_SESSION["canupdateorder"]="";

			if (isId(@$_REQUEST['orderId']) && isId(@$_REQUEST['statusId']) && ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) && UpdateOrderStatus($_REQUEST['orderId'], $_REQUEST['statusId'])) {
				echo '1';
				$success++;
			} else {
				echo '0';
				$failed++;
			}

			$message = sprintf(GetLang('OrderUpdateStatusReport'), $success, $row['statusdesc']);
			if ($failed) {
				$message .= sprintf(GetLang('OrderUpdateStatusReportFail'), $failed);
			}

			MessageBox($message, MSG_SUCCESS);
			//2011-4-21 ronnie add
			if($_SESSION["canupdateorder"]!=""){
				//echo MessageBox($_SESSION["canupdateorder"], MSG_ERROR);
				echo $_SESSION["canupdateorder"];
			};
			exit;
		}

		public function LoadOrderProductFields()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ORDERS'] = GetClass('ISC_ADMIN_ORDERS');
			$GLOBALS['ISC_CLASS_ADMIN_ORDERS']->LoadOrderProductFieldsFullView();
		}

		private function SearchProducts()
		{
			if(!isset($_REQUEST['searchQuery']) || $_REQUEST['searchQuery'] == '') {
				exit;
			}

			$groupId = 0;
			if(isset($_REQUEST['ordcustid']) && $_REQUEST['ordcustid'] != 0) {
				$customerClass = GetClass('ISC_CUSTOMER');
				$customer = $customerClass->GetCustomerInfo($_REQUEST['ordcustid']);
				if(isset($customer['custgroupid'])) {
				 $groupId = $customer['custgroupid'];
				}
			}
			else if(isset($_REQUEST['custgroupid']) && $_REQUEST['custgroupid'] != 0) {
				$groupId = (int)$_REQUEST['custgroupid'];
			}

			$numProducts = 0;
			$products = GetClass('ISC_ADMIN_PRODUCT');
			/***********************************************************************
				Altered By Mayank Jaitly 12 July 2010
				Original Code is in the else
			/***********************************************************************/
			
			if(isset($_REQUEST['w']) && $_REQUEST['w']=='orderSearchProducts') {
				$result = $products->_GetProductList(0, 'ct.catuniversal,p.prodname', 'asc', $numProducts, 'DISTINCT p.*, '.GetProdCustomerGroupPriceSQL($groupId), true);
			}
			else {
			$result = $products->_GetProductList(0, 'p.prodname', 'asc', $numProducts, 'DISTINCT p.*, '.GetProdCustomerGroupPriceSQL($groupId), true);
			}
			if($numProducts == 0) {
				$searchQuery = isc_html_escape($_REQUEST['searchQuery']);
				$GLOBALS['OrderProductSearchNone'] = sprintf(GetLang('OrderProductSearchNone'), $searchQuery);
				echo $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrdersProductSearchNoResults');
				exit;
			}

			while($product = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$GLOBALS['ProductId'] = $product['productid'];
				$GLOBALS['ProductName'] = isc_html_escape($product['prodname']);
				$GLOBALS['ProductLink'] = ProdLink($product['prodname']);
				$actualPrice = CalcRealPrice($product['prodprice'], $product['prodretailprice'], $product['prodsaleprice'], $product['prodistaxable']);
				$actualPrice = CalcProdCustomerGroupPrice($product, $actualPrice, $groupId);
				$GLOBALS['ProductPrice'] = FormatPrice($actualPrice);
				$GLOBALS['RawProductPrice'] = FormatPrice($actualPrice, false, false, true);
				$GLOBALS['ProductCode'] = isc_html_escape($product['prodcode']);
				$isConfigurable = false;
				if($product['prodvariationid'] != 0 || $product['prodconfigfields'] != 0) {
					$isConfigurable = true;
				}
				$GLOBALS['ProductConfigurable'] = (int)$isConfigurable;
				
				/************************************************************************
					Code Altered by Mayank Jaitly on 01 July 2010
					Original code is with comment area
				echo $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrdersProductSearchResult');
				/***************************************************************************/				
				
				/// Start of alteration
				if(isset($_REQUEST['ajaxsearchtype']) && $_REQUEST['ajaxsearchtype']=='2') {
					$GLOBALS['SKU']=isc_html_escape($product['prodvendorprefix']);
					echo $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrdersProductSearchResultSKU');
				}
				else {
					echo $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrdersProductSearchResult');
				}
				
				//// End of alteration
			}
		}

		private function SearchCustomers()
		{
			if(!isset($_REQUEST['searchQuery']) || $_REQUEST['searchQuery'] == '') {
				exit;
			}

			$numCustomers = 0;
			$customer = GetClass('ISC_ADMIN_CUSTOMERS');
			//alandy_2011-6-20 modify.
			$result = $customer->_GetCustomerList(0, 'custconlastname', 'asc', $numCustomers, true,true);

			if($numCustomers == 0) {
				$searchQuery = isc_html_escape($_REQUEST['searchQuery']);
				$GLOBALS['OrderCustomerSearchNone'] = sprintf(GetLang('OrderCustomerSearchNone'), $searchQuery);
				echo $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrdersCustomerSearchNoResults');
				exit;
			}

			while($customer = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$GLOBALS['CustomerId'] = $customer['customerid'];
				$GLOBALS['CustomerFirstName'] = isc_html_escape($customer['custconfirstname']);
				$GLOBALS['CustomerLastName'] = isc_html_escape($customer['custconlastname']);

				$GLOBALS['CustomerPhone'] = '';
				if($customer['custconphone']) {
					$GLOBALS['CustomerPhone'] = isc_html_escape($customer['custconphone']) . '<br />';
				}

				$GLOBALS['CustomerEmail'] = '';
				if($customer['custconemail']) {
					$GLOBALS['CustomerEmail'] = isc_html_escape($customer['custconemail']).'<br />';
				}

				$GLOBALS['CustomerCompany'] = '';
				if($customer['custconcompany']) {
					$GLOBALS['CustomerCompany'] = isc_html_escape($customer['custconcompany']).'<br />';
				}

				$GLOBALS['HideChangeLink'] = 'display: none';

				echo $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('OrdersCustomerSearchResult');
			}
		}
        
        public function OrderRemoveCompanyGiftCertificate() {
            $orderClass = GetClass('ISC_ADMIN_ORDERS');
            $ret = array();
            $orderClass->GetCartApi($_REQUEST['orderSession'])->RemoveAppliedCompanyGiftCertificate($_REQUEST['cgcId']);
            $ret['orderSummary'] = $orderClass->GenerateOrderSummaryTable();
            echo json_encode($ret);
        }
	}
?>
