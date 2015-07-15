<?php

	class ISC_ORDER
	{
		private $pendingData = array();
		private $customerInfo = array();

		private $orderToken = '';
		private $paymentProvider = null;
		
		function __construct()
		{
			$this->_convertURL();
		}

		public function HandlePage()
		{
			$action = "";
			
			if (count($GLOBALS['PathInfo']) > 0 ){
				if (isset ($GLOBALS['PathInfo'][1])) {
					$_REQUEST['action'] = $GLOBALS['PathInfo'][1];
				}
				else
				{
					$_REQUEST['action'] = $GLOBALS['PathInfo'][0];
				}
			}
			
			if(isset($_REQUEST['action'])) {
				$action = isc_strtolower($_REQUEST['action']);
			}
			//wirror20100728: methods for order review request
			switch($action) {
				case 'review':
					$this->ReviewOperations();
					break;
				default: {
					// Set up the incoming order details
					$this->SetOrderData();
					$this->FinishOrder();
				}
			}
		}
		//wirror20100728: methods for order review request
		private function _convertURL(){
			if($GLOBALS['EnableSEOUrls'] == 1 && !empty($GLOBALS['PathInfo'])) {  // checking seo is enabled and pathinfo is not empty as pathinfo will be set only when redirected to index page
				$count_pathinfo = count($GLOBALS['PathInfo']); // to get the count of the parameter, i.e if its odd, query string is applied.
				if( $count_pathinfo % 2 == 0 ) {
					$_REQUEST['search_query'] = MakeURLNormal($GLOBALS['PathInfo'][1]);
					for($i=0;$i<count($GLOBALS['PathInfo']);$i+=2)
					{
						if($GLOBALS['PathInfo'][$i+1] != '')
							$_REQUEST[$GLOBALS['PathInfo'][$i]] = MakeURLNormal($GLOBALS['PathInfo'][$i+1]);
					}
				} else {
					$_REQUEST['search_query'] = MakeURLNormal($GLOBALS['PathInfo'][0]);
					for($i=1;$i<count($GLOBALS['PathInfo']);$i+=2)
					{
						if($GLOBALS['PathInfo'][$i+1] != '')
							$_REQUEST[$GLOBALS['PathInfo'][$i]] = MakeURLNormal($GLOBALS['PathInfo'][$i+1]);
					}
				}

			} else { // this condition is entered when seo is disabled. also in redefine search this will be accessed.
				foreach($_GET as $key => $value){
					$_GET[$key] = MakeURLNormal($value);
					$_REQUEST[$key] = MakeURLNormal($value);
				}
			}
		}
		//wirror20100728: methods for order review request
		public function ReviewOperations(){
			if(isset($_REQUEST['operation']) && $_REQUEST['operation'] != ""){
				switch($_REQUEST['operation']) {
					case 'add':
						$this->AddPopupReview();
						break;
					default: {
						$this->ReviewOrder();
				}
			}
			}else{
				$this->ReviewOrder();
			}
		}
		
		//wirror20100728: methods for order review request
		public function AddPopupReview(){
			$GLOBALS['ReviewOrder'] = $_REQUEST['review'];

			$productId = $_REQUEST['productItem'];
			$GLOBALS['ISC_CLASS_PRODUCT'] = new ISC_PRODUCT($productId);

			//2011-3-2 Ronnie add, change Next link
			$GLOBALS['ExReviewPageLink']=GetConfig('ShopPathNormal').$_SERVER['REDIRECT_URL'];

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle("Write Your Review");
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("order.review.popup");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

		}
		//wirror20100728: methods for order review request
		public function UpdateReviewRequestStatus($orderIds, $status)
		{
			
			if(!is_array($orderIds)) {
				$orderIds = array($orderIds);
			}
		
			foreach($orderIds as $orderId) {
				$order = GetOrder($orderId, false);
		
				if (!$order['orderid']) {
					return false;
				}
		
				// Start transaction
				$GLOBALS['ISC_CLASS_DB']->Query("START TRANSACTION");
		
				$updatedStatus = array(
					'requestdate' => date('Y-m-d H:i:s',time()),
					"requeststatus" => (int)$status
				);
		
				// Update the status for this order review request
				if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("requests", $updatedStatus, "orderid='".$GLOBALS['ISC_CLASS_DB']->Quote($orderId)."'")) {
					// Log this action if we are in the control panel
					if (defined('ISC_ADMIN_CP')) {
						//$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($orderId, $statusName);
					}
				}
				// Was there an error? If not, commit
				if ($GLOBALS['ISC_CLASS_DB']->Error() == "") {
					$GLOBALS['ISC_CLASS_DB']->Query("COMMIT");
					return true;
				}
				else {
					return false;
				}
			}
		
			return false;
		}
		//wirror20100728: methods for order review request
		public function ReviewOrder(){
			$orderId = $_REQUEST['review'];
			//2010-12-6 Ronnie add,orderId decode
			$orderId2 = base64_decode($_REQUEST['review']);
			
			$GLOBALS['ImagePart'] = '<a href="#">'.GetLang('ImagePart').'</a>';
			$GLOBALS['ProductDescTitle'] = GetLang('ProductDesc');
			$GLOBALS['ProductPriceLabel'] = '<a href="#">'.GetLang('ProductPrice').'</a>';
			$GLOBALS['ProductDetails'] = GetLang('ProductDetails');
			$GLOBALS['AddReviewText'] = GetLang('AddReview');
			//2010-12-06 Ronnie modify
			/*$GLOBALS['OrderCouponCode'] = $this->GetCouponCode($orderId);
			if(empty($GLOBALS['OrderCouponCode']))
			{
				$GLOBALS['ShowOrderCouponCode'] = "display:none";
			}
			else
			{
				$GLOBALS['ShowOrderCouponCode'] = "";
			}*/
			
			//2010-11-11 Ronnie modify ,Does not show goods of not exist ,sql and p.prodvisible=1
			/*$query = "
				SELECT o.*, p.*,pi.imagefile
				FROM [|PREFIX|]order_products o
				LEFT JOIN [|PREFIX|]products p ON (p.productid=o.ordprodid)
				LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid)
				WHERE orderorderid='" . $orderId . "' and pi.imageisthumb=1 and p.prodvisible=1
				ORDER BY ordprodname";*/
			$query = "
				SELECT oa.orddate,o.*, p.*,pi.imagefile
				FROM [|PREFIX|]order_products o
				LEFT JOIN [|PREFIX|]products p ON (p.productid=o.ordprodid)
				LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid)
				LEFT JOIN [|PREFIX|]orders oa ON (oa.orderid=o.orderorderid) 
				WHERE (orderorderid='" . $orderId . "' or orderorderid='".$orderId2."') and pi.imageisthumb=1 and p.prodvisible=1
				ORDER BY ordprodname";
			
			$pResult = $GLOBALS['ISC_CLASS_DB']->Query($query);

			$counter = 1;
			
			$orderdate ="";
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($pResult)) {
				
				//2010-12-6 Ronnie add
				$orderId=$row['orderorderid'];
				$GLOBALS['OrderCouponCode'] = $this->GetCouponCode($orderId);
				if(empty($GLOBALS['OrderCouponCode']))
				{
					$GLOBALS['ShowOrderCouponCode'] = "display:none";
				}
				else
				{
					$GLOBALS['ShowOrderCouponCode'] = "";
				}
				
				if($counter%2 == 0)
					$GLOBALS['RowColor'] = 'grayrow';
				else
					$GLOBALS['RowColor'] = 'whiterow';
			
				$counter++;
				
				$GLOBALS['ReviewURL'] = $_SERVER['REQUEST_URI'].'/productItem/'.$row['productid'].'/operation/add';
				
				//product thumbnail
				$prodimage = '';
	            $file = realpath(ISC_BASE_PATH.'/product_images/' . $row['imagefile']);
	            if($row['imagefile'] != '' && file_exists($file))
	            {
	                $prodimage = GetConfig('ShopPath')."/product_images/".$row['imagefile'];
	            }
	            else {
	                $prodimage = GetConfig('ShopPath')."/templates/CongoWorld/images/ProductDefault.gif";
	            }
				$GLOBALS['ProductThumb'] = '<img src="'.$prodimage.'"/>';
				
				$GLOBALS['ProductCode'] = isc_html_escape($row['ordprodsku']);
				
				$GLOBALS['ProductDesc'] = $row['ordprodqty']." x ".$row['ordprodname'];
					
				$GLOBALS['ProductPrice'] = CalculateProductPriceRetail($row);
				
				$GLOBALS['ProductLink'] = ProdLink($row['prodname']);
				
				if (isId($row['prodvariationid']) || trim($row['prodconfigfields'])!='' || $row['prodeventdaterequired'] == 1) {
					$GLOBALS['ProductURL'] = $GLOBALS['ProductLink'];
					$GLOBALS['ProductAddText'] = GetLang('ProductChooseOptionLink');
				} else {		
					$GLOBALS['ProductURL'] = $GLOBALS['ProductLink'];
	
					//blessen
					if (intval($row['prodretailprice']) <= 0 )
					{
						$GLOBALS['ProductAddText'] = "<img src='$path/templates/default/images/view.gif' border=0>";
					}
					else
					{
						$GLOBALS['ProductAddText'] = "<img src='$path/templates/default/images/view.gif' border=0>";
					}
				}
				
				$GLOBALS['ProductList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("OrderedProductsItem");
				
				//2010-12-6 Ronnie modify
				$orderdate =isc_date('m/d/y', $row['orddate']);//date('m/d/Y',$row['orddate']);
			}
			$GLOBALS['OrderReviewTitle'] = sprintf(GetLang('OrderReviewTitle'),$orderdate).'#['.$orderId.']';
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle("Order Review");
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("order.review");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}
		
		private function GetCouponCode($orderid)
		{
			if(!isset($orderid) || !is_numeric($orderid))
			{
				return "";
			}
			//2010-11-25 Ronnie modify 
			/*$query = " select coupon_code from [|PREFIX|]order_review_request where id in (select templateid from [|PREFIX|]requests where orderid=" . $orderid . ")";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			if($row =  $GLOBALS['ISC_CLASS_DB']->Fetch($result))
			{
				if(!empty($row['coupon_code']) )
				{
					return GetLang('CouponCode').":". $row['coupon_code'];
				}
			}*/
			$query = " select couponcode from [|PREFIX|]coupons where couponenabled=1 and orderid = '" . $orderid . "'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			if($row =  $GLOBALS['ISC_CLASS_DB']->Fetch($result))
			{
				if(!empty($row['couponcode']) )
				{
					return $row['couponcode'];
				}
			}
			return "";
		}

		private function SetOrderData()
		{
			// Some payment providers like WorldPay simply "fetch" FinishOrder.php and so it
			// doesn't factor in cookies stored by Interspire Shopping Cart, so we have to pass back the
			// order token manually from those payment providers. We do this by taking the
			// cart ID passed back from the provider which stores the order's unique token.
			if(isset($_COOKIE['SHOP_ORDER_TOKEN'])) {
				$this->orderToken = $_COOKIE['SHOP_ORDER_TOKEN'];
			}
			else if(isset($_REQUEST['provider'])) {
				GetModuleById('checkout', $this->paymentProvider, $_REQUEST['provider']);

				if(in_array("GetOrderToken", get_class_methods($this->paymentProvider))) {
					$this->orderToken = $this->paymentProvider->GetOrderToken();
				}
				else {
					ob_end_clean();
					header(sprintf("Location:%s", $GLOBALS['ShopPath']));
					die();
				}
			}

			// Load the pending orders from the database
			$this->pendingData = LoadPendingOrdersByToken($this->orderToken, true);

			if(!$this->orderToken || $this->pendingData === false) {
				$this->BadOrder();
				exit;
			}

			if($this->paymentProvider === null) {
				GetModuleById('checkout', $this->paymentProvider, $this->pendingData['paymentmodule']);
			}

			if($this->paymentProvider) {
				$this->paymentProvider->SetOrderData($this->pendingData);
			}
		}

		/**
		 * Get the array of order details from the order we're showing the thank you page.
		 */
		public function GetOrder()
		{
			die('BIG FAT FATAL ERROR');
			return $this->_orderRow;
		}

		/**
		*	Show the "Thanks for Your Order" page and email an invoice to the customer.
		*	Also clear the outstanding order cookies and related data
		*/
		private function ThanksForYourOrder()
		{
			// Reload all fo the information about the order as there's a good chance
			// a fair bit of it has changed now
			$this->SetOrderData();

            //get current field ids from data base
            $result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]order_scripts");
                                         
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                if($row['scripttype']=='orderscript')    {
                    $GLOBALS['CampaignCode'] = $row['scriptvalue'];
                }
                elseif($row['scripttype']=='ordermsg')    {
                    $GLOBALS['OrderCompleteMsg'] = $row['scriptvalue'];
                }
            }
            
            //blessen start
			$OrderToken = $_COOKIE['SHOP_ORDER_TOKEN']; 
            $CATEGORYID = array();
			$CATEGORYNAME = array();
			$PRODUCTID =  array();
			$PRODUCTNAME = array();

            $result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT o.orderid, o.ordsubtotal,o.ordtotalamount,op.ordprodid,op.ordprodname,c.categoryid,c.catname,cu.custconfirstname,cu.custconlastname,cu.custconemail  FROM [|PREFIX|]orders o left join [|PREFIX|]order_products op on o.orderid = op.orderorderid left join [|PREFIX|]categoryassociations ca on ca.productid = op.ordprodid left join [|PREFIX|]categories c on c.categoryid = ca.categoryid left join [|PREFIX|]customers cu on cu.customerid  = o.ordcustid  WHERE ordtoken='".$OrderToken."'");
                  
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

                 $TOTAL = number_format($row['ordsubtotal'], 2); 
                 $ORDERNUMBER = $row['orderid'];
				 array_push($CATEGORYID, $row['categoryid']);
				 array_push($CATEGORYNAME, $row['catname']);	 
				 array_push($PRODUCTID, $row['ordprodid']);
				 array_push($PRODUCTNAME, $row['ordprodname']);
				 $FIRSTNAME = $row['custconfirstname'];
				 $LASTNAME = $row['custconlastname'];
				 $EMAIL = $row['custconemail'];
			    }

			$CATEGORYID1 = implode(",",array_unique($CATEGORYID));
			$CATEGORYNAME1 =  implode(",",array_unique($CATEGORYNAME));
			$PRODUCTID1 =  implode(",",array_unique($PRODUCTID));
			$PRODUCTNAME1 =  implode(",",array_unique($PRODUCTNAME));

 
			 $GLOBALS['CampaignCode'] = str_ireplace('[TOTAL]', $TOTAL, $GLOBALS['CampaignCode']); 
			 $GLOBALS['CampaignCode'] = str_ireplace('[ORDERNUMBER]', $ORDERNUMBER, $GLOBALS['CampaignCode']);
			 $GLOBALS['CampaignCode'] = str_ireplace('[CATEGORYID]', $CATEGORYID1, $GLOBALS['CampaignCode']);
			 $GLOBALS['CampaignCode'] = str_ireplace('[CATEGORYNAME]', $CATEGORYNAME1, $GLOBALS['CampaignCode']);
			 $GLOBALS['CampaignCode'] = str_ireplace('[PRODUCTID]', $PRODUCTID1, $GLOBALS['CampaignCode']);
			 $GLOBALS['CampaignCode'] = str_ireplace('[PRODUCTNAME]', $PRODUCTNAME1, $GLOBALS['CampaignCode']);
			 $GLOBALS['CampaignCode'] = str_ireplace('[FIRSTNAME]', $FIRSTNAME, $GLOBALS['CampaignCode']);
			 $GLOBALS['CampaignCode'] = str_ireplace('[LASTNAME]', $LASTNAME, $GLOBALS['CampaignCode']);
			 $GLOBALS['CampaignCode'] = str_ireplace('[EMAIL]', $EMAIL, $GLOBALS['CampaignCode']);
			//blessen start

			$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
			$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');

			// Trigger all active new order notification methods
			$this->_SendOrderNotifications();

			// Do we need to add them to a Interspire Email Marketer mailing list?
			$this->_SubscribeCustomerToLists();

			// Update the current uses of each rule
			$ruleUses = $GLOBALS['ISC_CLASS_CART']->api->Get('RULE_USES');

			require_once(ISC_BASE_PATH . "/lib/rule.php");
			UpdateRuleUses($ruleUses);

			$GLOBALS['HideError'] = "none";
			$GLOBALS['HidePaidOrderConfirmation'] = '';
			$GLOBALS['HideAwaitingPayment'] = "none";

			$GLOBALS['HideStoreCreditUse'] = 'none';
            # Added for displaying the success message for sweepstakes after successfull payment -- Baskaran 
            $cdate = date('Y-m-d');
            $succquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]sweepstakes_master WHERE active = '1' AND startdate <= '$cdate' AND enddate >= '$cdate' LIMIT 0 , 1 ");
            $succmsg = $GLOBALS['ISC_CLASS_DB']->Fetch($succquery);
            $sweepstakesId = $succmsg['sweepstakesid'];
            $successMessage = $succmsg['successmessage'];
            if ($_SESSION['SweepstakesRegister'] == 1) {
                $GLOBALS['SweepstakesRegister'] = '';
                $GLOBALS['SuccessMessage'] = $successMessage;
            }
            else {
                $GLOBALS['SweepstakesRegister'] = 'none';
                $GLOBALS['SuccessMessage'] = '';
            }
            /* Ends here */
			if($this->pendingData['storecreditamount'] > 0) {
				$GLOBALS['HideStoreCreditUse'] = '';
				$GLOBALS['StoreCreditUsed'] = CurrencyConvertFormatPrice($this->pendingData['storecreditamount']);

				$GLOBALS['StoreCreditBalance'] = CurrencyConvertFormatPrice($GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerStoreCredit($this->pendingData['customerid']));
				$GLOBALS['ISC_LANG']['OrderCreditDeducted'] = sprintf(GetLang('OrderCreditDeducted'), GetConfig('CurrencyToken') . $GLOBALS['StoreCreditUsed']);
			}

			// If it was an offline payment method, show the post-purchase message and hide other messages
			if(is_object($this->paymentProvider) && $this->paymentProvider->GetPaymentType() == PAYMENT_PROVIDER_OFFLINE && method_exists($this->paymentProvider, 'GetOfflinePaymentMessage')) {
				$GLOBALS['OrderTotal'] = CurrencyConvertFormatPrice($this->pendingData['gatewayamount']);
				$GLOBALS['HidePaidOrderConfirmation'] = "none";
				$GLOBALS['PaymentMessage'] = nl2br($this->paymentProvider->GetOfflinePaymentMessage());
				$GLOBALS['SNIPPETS']['OfflinePaymentMessage'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("OfflinePaymentMessage");
			}
			else {
				// Was the order declined?
				if($this->pendingData['status'] == 6) {
					$GLOBALS['HideError'] = '';
					$GLOBALS['ErrorMessage'] = sprintf(GetLang('ErroOrderDeclined'), GetConfig('OrderEmail'), GetConfig('OrderEmail'));
					$GLOBALS['HidePaidOrderConfirmation'] = 'none';
					$GLOBALS['ISC_LANG']['ThanksForYourOrder'] = GetLang('YourPaymentWasDeclined');
				}
				// Order is still awaiting payment
				else if($this->pendingData['status'] == 7) {
					$GLOBALS['HidePaidOrderConfirmation'] = "none";
					$GLOBALS['HideAwaitingPayment'] = "";
				}
				// Otherwise, order was successful
				else {
					// Is it a physical or digital order?
                       $orders = array_shift($this->pendingData['orders']);
                       $sql = "SELECT * FROM [|PREFIX|]order_products WHERE orderorderid={$orders['orderid']}";
                       $query = $GLOBALS['ISC_CLASS_DB']->Query($sql);
                       $productTypes = array();
                       while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($query)) {
                           $productTypes[] = $row['ordprodtype'];
                       }
                       
                       $GLOBALS['HideDigitalOrderDownloadLink'] = $GLOBALS['HidePhysicalViewOrderLink'] = 'none';
                       $GLOBALS['OrderConfirmation'] = '';
                       if (in_array('physical', $productTypes)) {
                           $GLOBALS['OrderConfirmation'] .= '<p>' . GetLang($this->pendingData['isguest'] ? 'PhysicalOrderConfirmationGuestCheckout' : 'PhysicalOrderConfirmation') . '</p>';
                            if (!$this->pendingData['isguest']) {
                                $GLOBALS['HidePhysicalViewOrderLink'] = '';
                            }
                            $GLOBALS['OrderConfirmation'] = '<p>' . preg_replace("/&lt;!--ORDER_NUMBER--&gt;/", "$ORDERNUMBER", $GLOBALS['OrderCompleteMsg']) . '</p>';
                       }
                       
                       if (in_array('giftcertificate', $productTypes)) {
                           $GLOBALS['HidePhysicalViewOrderLink'] = '';
                           $GLOBALS['OrderConfirmation'] .= '<p>' . GetLang($this->pendingData['isguest'] ? 'GiftcertificateOrderConfirmationGuestCheckout' : 'GiftcertificateOrderConfirmation') . '</p>';
                       }
                       
                       if (in_array('digital', $productTypes)) {
                           $GLOBALS['HideDigitalOrderDownloadLink'] = '';
                           $GLOBALS['OrderConfirmation'] .= '<p>' . GetLang($this->pendingData['isguest'] ? 'DigitalOrderConfirmationGuestCheckout' : 'DigitalOrderConfirmation') . '</p>';
                       }
                       
                       if ($this->pendingData['isguest']) {
                           $GLOBALS['HidePhysicalViewOrderLink'] = $GLOBALS['HideDigitalOrderDownloadLink'] = 'none';
                       }
           
                       /*
					if($this->pendingData['isdigital'] == 1) {

						// If this order has no customer ID associated with it (guest checkout with no account creation) then display an alternative text with no download link
						if (!isId($this->pendingData['customerid'])) {
							$GLOBALS['DigitalOrderConfirmation'] = GetLang('DigitalOrderConfirmationGuestCheckout');
							$GLOBALS['HideDigitalOrderDownloadLink'] = 'none';
						}
						// Otherwise display nthe normal text with the download link in it
						else {
							$GLOBALS['DigitalOrderConfirmation'] = GetLang('DigitalOrderConfirmation');
							$GLOBALS['HideDigitalOrderDownloadLink'] = 'none';
						}

						$GLOBALS['HidePhysicalOrderConfirmation'] = "none";
						$GLOBALS['HidePhysicalViewOrderLink'] = "none";
					}
					else {

						// If this order has no customer ID associated with it (guest checkout with no account creation) then display an alternative text with no view order link
						if (!isId($this->pendingData['customerid'])) {
							$GLOBALS['PhysicalOrderConfirmation'] = GetLang('PhysicalOrderConfirmationGuestCheckout');
							$GLOBALS['HidePhysicalViewOrderLink'] = 'none';
						}
						// Otherwise display nthe normal text with the download link in it
						else {
							//$GLOBALS['PhysicalOrderConfirmation'] = GetLang('PhysicalOrderConfirmation');
							// 2011-06-29 johnny modify to add ordernum
							$GLOBALS['OrderCompleteMsg'] = preg_replace("/&lt;!--ORDER_NUMBER--&gt;/", "$ORDERNUMBER", $GLOBALS['OrderCompleteMsg']);
							$GLOBALS['PhysicalOrderConfirmation'] = $GLOBALS['OrderCompleteMsg'];
							$GLOBALS['HidePhysicalViewOrderLink'] = '';
						}

						$GLOBALS['HideDigitalOrderConfirmation'] = "none";
						$GLOBALS['HideDigitalOrderDownloadLink'] = "none";
					}
                    */
				}
			}

			// Include the conversion code for each analytics module
			$GLOBALS['ConversionCode'] = '';
			$analyticsModules = GetAvailableModules('analytics', true, true);
			foreach($analyticsModules as $module) {
				$module['object']->SetOrderData($this->pendingData);
				$trackingCode = $module['object']->GetConversionCode();
				if($trackingCode != '') {
					$GLOBALS['ConversionCode'] .= "
						<!-- Start conversion code for ".$module['id']." -->
						".$trackingCode."
						<!-- End conversion code for ".$module['id']." -->
					";
				}
			}

			// Include the conversion tracking code for affiliates
			foreach($this->pendingData['orders'] as $order) {
				if(strlen(GetConfig('AffiliateConversionTrackingCode')) > 0) {
					$converted_code = GetConfig('AffiliateConversionTrackingCode');
					$converted_code = str_ireplace('%%ORDER_AMOUNT%%', $order['ordsubtotal'], $converted_code);
					$converted_code = str_ireplace('%%ORDER_ID%%', $order['orderid'], $converted_code);
					$GLOBALS['ConversionCode'] .= '\n\n' . $converted_code;
				}
			}
            if(isset($GLOBALS['CampaignCode']))    {
                $GLOBALS['ConversionCode'] .= $GLOBALS['CampaignCode'];
            }
            
			// Empty the users cart and kill the checkout process
			$this->EmptyCartAndKillCheckout();

			// Are product update options enabled?
			if(GetConfig('MailXMLAPIValid') && GetConfig('UseMailAPIForUpdates')) {
				$order = current($this->pendingData['orders']);
				$email = $order['ordbillemail'];
				$GLOBALS['CustomerEmail'] = $email;
				$GLOBALS['ProductUpdatesList'] = "";

				$query = "
					SELECT DISTINCT ordprodid, ordprodname
					FROM [|PREFIX|]order_products
					WHERE orderorderid IN (".implode(array_keys($this->pendingData['orders'])).")
					ORDER BY ordprodname
				";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$GLOBALS['ProductName'] = isc_html_escape($row['ordprodname']);
					$GLOBALS['ProductId'] = $row['ordprodid'];
					$GLOBALS['ProductUpdatesList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductUpdatesRadio");
				}
			}
			else {
				// Hide the product updates div
				$GLOBALS['HideProductUpdates'] = "none";
			}

			if(method_exists($this->paymentProvider, 'ShowOrderConfirmation')) {
				$GLOBALS['OrderConfirmationDetails'] = $this->paymentProvider->ShowOrderConfirmation($this->pendingData);
			}

			// Show the order confirmation screen
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetLang('ThanksForYourOrder'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("order");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	Complete the order after the customer is brought back from the payment provider
		*/
		public function FinishOrder()
		{
			$queries = array();

			// Orders are still incomplete, so we need to validate them
			if($this->pendingData['status'] == 0) {
				// Verify the pending order
				$newStatus = VerifyPendingOrder($this->orderToken);

				// This order is not valid
				if($newStatus !== false) {
					if(CompletePendingOrder($this->orderToken, $newStatus)) {
                        
                       /*  $cdate = strtotime(date('Y-m-d'));
                        $edate = strtotime('2010-12-15');
                        if($cdate <= $edate) {*/ # This condition should be checked dynamically, For static its hardcoded -- Baskaran
                            $this->AddSweepstakes($this->orderToken);
                       // }
						// Order was saved. Show the confirmation screen and email an invoice to the customer
						$this->ThanksForYourOrder();
						return;
					}
				}

				// If we're still here, something bad has happened to the order
				// Order was declined and we're rejecting all declined payments
				if($newStatus == ORDER_STATUS_DECLINED) {
					$Msg = sprintf(GetLang('ErroOrderDeclined'), GetConfig('OrderEmail'), GetConfig('OrderEmail'));
					$this->BadOrder(GetLang('YourPaymentWasDeclined'), $Msg);
				}
				// Otherwise for some reason the payment provider said the payment was bad
				else {
					$this->BadOrder();
				}
			}
			// Order is already complete - there's a good chance the customer has refreshed the page,
			// or they've come back from somewhere like PayPal who in the mean time has already sent
			// us a ping back to validate and begin processing the order - show the thank you page
			else {
				if($this->pendingData['status'] == ORDER_STATUS_DECLINED) {
					$Msg = sprintf(GetLang('ErroOrderDeclined'), GetConfig('OrderEmail'), GetConfig('OrderEmail'));
					$this->BadOrder(GetLang('YourPaymentWasDeclined'), $Msg);
				}
				else {
					$this->ThanksForYourOrder();
					return;
				}
			}
		}
        # Used to enter the sweepstakes entry after the successfull payment -- Baskaran
        private function AddSweepstakes($ord) {
            $cdate = date('Y-m-d');
            $squery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]sweepstakes_master WHERE active = '1' AND startdate <= '$cdate' AND enddate >= '$cdate' LIMIT 0 , 1 ");
            $row = $GLOBALS['ISC_CLASS_DB']->Fetch($squery);
            $sweepstakesId = $row['sweepstakesid'];
            if($sweepstakesId != '') {
                
                if (isset($_COOKIE['SHOP_ORDER_TOKEN'])) {
                    $query = "
                        SELECT *
                        FROM [|PREFIX|]orders o
                        LEFT JOIN [|PREFIX|]order_products op ON o.orderid = op.orderorderid
                        WHERE ordtoken='".$ord."' ";
                    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                    $ord = '';
                    while($order = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                        $ord[] = $order;
                    }
                }
                $email = $ord[0]['ordbillemail'];
				if(isset($_COOKIE['JOIN_MAILING_LIST']))
				{
					$newsletter = 1;
				}
				else
				{
					$newsletter = 0;
				}
                $sweepstakesid = $sweepstakesId;
                $addedby = "system";
                $createddate = date('Y-m-d H:i:s',$ord[0]['orddate']);
                $userDetails = array(
                    'email' => $email,
                    'firstname' => $ord[0]['ordbillfirstname'],
                    'lastname' => $ord[0]['ordbilllastname'],
                    'phonenumber' => $ord[0]['ordbillphone'],
                    'addressline1' => $ord[0]['ordbillstreet1'],
                    'addressline2' => $ord[0]['ordbillstreet2'],
                    'city' => $ord[0]['ordbillsuburb'],
                    'state' => $ord[0]['ordbillstate'],
                    'country' => $ord[0]['ordbillcountry'],
                    'zipcode' => $ord[0]['ordbillzip'],
                    'receivingmail' => $newsletter,
                    'year' => $ord[0]['ordyear'],
                    'make' => $ord[0]['ordmake'],
                    'model' => $ord[0]['ordmodel'],
                    'orderid' => $ord[0]['orderid'],
                    'sweepstakesid' =>$sweepstakesid,
                    'addedby' => $addedby,
                    'createddate' => $createddate
                );
                $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT email FROM [|PREFIX|]sweepstakes_users where email = '".$email."' and sweepstakesid = '$sweepstakesid'");
                $cnt = $GLOBALS['ISC_CLASS_DB']->CountResult($query);
                # Checking for whether a user can enter 5 enteries for a sweepstakes for one email id -- Baskaran
    //            $GLOBALS['SweepstakesRegister'] = 'none';
                $_SESSION['SweepstakesRegister'] = '';
               if($cnt < 5) {
                    $GLOBALS['ISC_CLASS_DB']->InsertQuery("sweepstakes_users", $userDetails);
                    $_SESSION['SweepstakesRegister'] = 1;
               }
            }
        }

		/**
		*	Something went wrong when trying to validate the order, show an error with the stores order email address for help
		*/
		public function BadOrder($Title="", $Message="", $Detailed="")
		{
			$GLOBALS['ErrorTitle'] = GetLang('OrderError');
			if($Title) {
				$GLOBALS['ISC_LANG']['SomethingWentWrong'] = $Title;
			}

			if($Message == "") {
				$GLOBALS['ErrorMessage'] = sprintf(GetLang('BadOrderDetailsFromProvider'), GetConfig('OrderEmail'), GetConfig('OrderEmail'));
			}
			else {
				$GLOBALS['ErrorMessage'] = $Message;
			}

			if($Detailed != "") {
				$GLOBALS['ErrorDetails'] = $Detailed;
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($GLOBALS['ErrorTitle']);
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("error");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			exit;
		}

		/**
		*	Check which order notification methods are enabled and trigger each one
		*/
		public function _SendOrderNotifications()
		{

			// Firstly, are there any order notification methods that are enabled?
			$notifications = GetEnabledNotificationModules();

			if(is_array($notifications) && count($notifications) > 0) {
				foreach($notifications as $notifier) {
					// Instantiate the notification object by reference
					if(GetModuleById('notification', $notify_object, $notifier['object']->GetId())) {
						// Set the required variables
						foreach($this->pendingData['orders'] as $order) {
							$query = "
								SELECT SUM(ordprodqty)
								FROM [|PREFIX|]order_products
								WHERE orderorderid='".(int)$order['orderid']."'
							";
							$numItems = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
							$notify_object->SetOrderId($order['orderid']);
							$notify_object->SetOrderTotal($order['ordtotalamount']);
							$notify_object->SetOrderNumItems($numItems);
							$notify_object->SetOrderPaymentMethod($order['orderpaymentmethod']);

							$response = $notify_object->SendNotification();
							if(isset($response['outcome']) && $response['outcome'] == "fail") {
								$GLOBALS['ISC_CLASS_LOG']->LogSystemError(array('notification', $notify_object->_name), GetLang('NotificationOrderError'), $response['message']);
							}
							else if(isset($response['outcome']) && $response['outcome'] == "success") {
								$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('notification', $notify_object->_name), GetLang('NotificationOrderSuccess'), $response['message']);
							}
						}
					}
				}
			}
		}

		/**
		*	Do we need to subscribe the customer to either of our mailing lists?
		*	If they ticked yes then the appropriate cookies were set before they
		*	chose their shipping provider and entered their payment details
		*/
		public function _SubscribeCustomerToLists()
		{
			if(!empty($this->customerInfo)) {
				$email = $this->customerInfo['custemail'];
				$firstName = $this->customerInfo['custfirstname'];
			}
			else {
				$order = current($this->pendingData['orders']);
				$email = $order['ordbillemail'];
				$firstName = $order['ordbillfirstname'];
			}

						// Should we add them to our special offers & discounts mailing list?
			if(isset($_COOKIE['JOIN_ORDER_LIST']) || GetConfig('MailOrderListAutoSubscribe') == 1) {
				// Is Interspire Email Marketer integrated?
				if(GetConfig('MailXMLAPIValid') && GetConfig('UseMailerForNewsletter') && GetConfig('MailNewsletterList') > 0) {
					// Add them to the Interspire Email Marketer orders list
					$GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO'] = GetClass('ISC_ADMIN_SENDSTUDIO');
					foreach($this->pendingData['orders'] as $order) {

						// Wrap this order in an array as AddSubscriberToOrderList() accepts an array of order. We send them one
						// at a time so we can process the errors for each one
						$order = array($order);
						$result = $GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO']->AddSubscriberToOrderList($order);
						if(isset($result['status']) && $result['status'] == "fail") {
							$GLOBALS['ISC_CLASS_LOG']->LogSystemError('ssnx', GetLang('SendStudioErrorOrderList'), $result['message']);
						}
						else if(isset($result['status'])) {
							$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess('ssnx', $result['message']);
						}
					}
				}

				ISC_UnsetCookie("JOIN_ORDER_LIST");
			}

			// Should we add them to our newsletter mailing list?
			if(isset($_COOKIE['JOIN_MAILING_LIST'])) {
				// Is Interspire Email Marketer integrated or should we just use the built-in list?
				if(GetConfig('MailXMLAPIValid') && GetConfig('UseMailerForNewsletter') && GetConfig('MailNewsletterList') > 0) {
					// Add them to the Interspire Email Marketer list
					$GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO'] = GetClass('ISC_ADMIN_SENDSTUDIO');
					$result = $GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO']->AddSubscriberToNewsletter($firstName, $email);
					if(isset($result['status']) && $result['status'] == "fail") {
						$GLOBALS['ISC_CLASS_LOG']->LogSystemError('ssnx', GetLang('SendStudioErrorNewsletter'), $result['message']);
					}
				}
				// commented the else condition as need to store it into subscriber table everytime and also separating it from sweepstakes.
				//else {
					$GLOBALS['ISC_CLASS_SUBSCRIBE'] = GetClass('ISC_SUBSCRIBE');
					$result = $GLOBALS['ISC_CLASS_SUBSCRIBE']->AddSubscriberToNewsletter($firstName, $email);
				//}

				ISC_UnsetCookie("JOIN_MAILING_LIST");
			}
		}

		public function EmptyCartAndKillCheckout()
		{
			// Unset all of the unset the cart the user previously had
			unset($_SESSION['CART']);
			$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
			$GLOBALS['ISC_CLASS_CART']->SetNumItemsInCart();

			ISC_UnsetCookie("SHOP_ORDER_TOKEN");

			// Unset our checkout session
			unset($_SESSION['CHECKOUT']);
		}
	}

?>
