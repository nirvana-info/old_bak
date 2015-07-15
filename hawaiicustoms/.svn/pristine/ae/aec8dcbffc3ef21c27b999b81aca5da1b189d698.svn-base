<?php

	class ISC_REVIEW
	{

		public function HandlePage()
		{
			$action = @$_REQUEST['action'];

			switch($action) {
				case "post_review": {
					//zcs=>only login customer can access "Product Reviews"
					if (!CustomerIsSignedIn()) {
						echo '<script language="javascript">alert("Sorry! You may login to access in.");location.href="'.$GLOBALS['ShopPath'].'";</script>';
						exit(0);
					}
					//<=zcs
					$this->PostReview();
					break;
				}
                case 'review_helpful':
                    $this->ReviewHelpful();
                    break;
                case 'view':
                    $this->view();
                    break;
				default: {
					// Abandon ship!
					ob_end_clean();
					header("Location:" . $GLOBALS['ShopPath']);
					die();
				}
			}
		}

		public function PostReview()
		{
			$product_id = (int)$_POST['product_id'];

			$query = "SELECT * FROM [|PREFIX|]products WHERE productid='".(int)$product_id."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$product = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			
			if(!$product['prodname']) {
				// Abandon ship!
				ob_end_clean();
				header("Location:" . $GLOBALS['ShopPath']);
				die();
			}

			// Check that the customer has permisison to view this product
			$canView = false;
			$productCategories = explode(',', $product['prodcatids']);
			foreach($productCategories as $categoryId) {
				// Do we have permission to access this category?
				if(CustomerGroupHasAccessToCategory($categoryId)) {
					$canView = true;
				}
			}
			if($canView == false) {
				$noPermissionsPage = GetClass('ISC_403');
				$noPermissionsPage->HandlePage();
				exit;
			}

			// Are reviews disabled? Just send the customer back to the product page
			if(GetConfig('EnableProductReviews') == 0) {
				$prod_link = ProdLink($product['prodname']);
				header("Location: ".$prod_link);
				exit;
			}
			// lguan_20100619: Remove checking of rev text since it will be hide from UI
			// lguan_20100709: Remove the overall rating check, it's no more mandatory
			if(!isset($_POST['revtitle'])) {
				$_SESSION['ProductErrorMessage'] = GetLang("InvalidReviewFormInput");
				$prod_link = ProdLink($product['prodname']);
				header("Location: ".$prod_link);
				exit;
			}
			// lguan_20100709: If the rating is not selected, set it to 0
			$revrating = isset($_POST['revrating']) ? (float)$_POST['revrating'] : 0;
			$revtitle = $_POST['revtitle'];
			$revtext = $_POST['revtext'];
			$revfromname = $_POST['revfromname'];
			$captcha = '';
			if(isset($_POST['captcha'])) {
				$captcha = $_POST['captcha'];
			}
			$captcha_check = true;
			
			//lguan_20100612: Log extra rating info
			$qualityrating = isset($_POST['qualityrating']) ? (float)$_POST['qualityrating'] : 0;
			$installrating = isset($_POST['installrating']) ? (float)$_POST['installrating'] : 0;
			$valuerating = isset($_POST['valuerating']) ? (float)$_POST['valuerating'] : 0;
			$supportrating = isset($_POST['supportrating']) ? (float)$_POST['supportrating'] : 0;
			$deliveryrating = isset($_POST['deliveryrating']) ? (float)$_POST['deliveryrating'] : 0;
			
			// Should reviews be approved automatically?
			if(GetConfig('AutoApproveReviews')) {
				$status = 1;
			}
			else {
				$status = 0;
			}

			// Do we need to check captcha?
			if(GetConfig('CaptchaEnabled')) {
				if(isc_strtolower($captcha) == isc_strtolower($GLOBALS['ISC_CLASS_CAPTCHA']->LoadSecret())) {
					// Captcha validation succeeded
					$captcha_check = true;
				}
				else {
					// Captcha validation failed
					$captcha_check = false;
				}
			}

			/* To insert sku, vendorprefix in the review table -- Baskaran */
			$vendorprefix = $product['prodvendorprefix'];
            $prodsku = $product['prodcode'];
            $source = "TruckChamp.com";

			if($captcha_check) { 
			
				$orderid = 0;
				if(isset($_POST['order_id']))
				{
					$orderid = base64_decode($_POST['order_id']);
				}
				//echo $orderid ." ".$_POST['order_id']; die();
				// Everything is OK, save the darn review already!
				//lguna_20100612: Log extra infomration for prod review, including more rating info and YMM 
				$NewReview = array(
					"revproductid" => $product_id,
					"revfromname" => $revfromname,
					"revdate" => time(),
					"revtext" => $revtext,
					"revtitle" => $revtitle,
					"revstatus" => $status,
                    "revprodsku" => $prodsku,
                    "revprodvendorprefix" => $vendorprefix,
                    "revsource" => $source,
					"prodyear" => (isset($_SESSION['searchterms']['year'])?$_SESSION['searchterms']['year']:''),
					"prodmake" => (isset($_SESSION['searchterms']['make'])?$_SESSION['searchterms']['make']:''),
					"prodmodel" => (isset($_SESSION['searchterms']['model'])?$_SESSION['searchterms']['model']:''),
					"reviewtype" => ((isset($_POST['popupFlag']) && $_POST['popupFlag']==1)?1:0),
					"orderid" => $orderid,
					//zcs=>save current customer id
					'customerid' => GetClass('ISC_CUSTOMER')->GetCustomerId(),
					//<=zcs
				);
				
				//lguan_20100709: Allow NULL value for those rating options
				if ($revrating!=0) $NewReview["revrating"]=$revrating;
				if ($qualityrating!=0) $NewReview["qualityrating"]=$qualityrating;
				if ($installrating!=0) $NewReview["installrating"]=$installrating;
				if ($valuerating!=0) $NewReview["valuerating"]=$valuerating;
				if ($supportrating!=0) $NewReview["supportrating"]=$supportrating;
				if ($deliveryrating!=0) $NewReview["deliveryrating"]=$deliveryrating;
				
				if($GLOBALS['ISC_CLASS_DB']->InsertQuery("reviews", $NewReview)) {					
					// Determine what the success message should be - is the review live
					// or is it pending approval from the site owner?

					$GLOBALS['ReviewSaved'] = true;

					// If this is an automagically approved review, we need to show that & update the average rating
					//lguan_20100709: Rating will only be calculated if it is not 0
					if(($status == 1) && ($revrating!=0)) {
						$query = sprintf("update [|PREFIX|]products set prodnumratings=prodnumratings+1, prodratingtotal=prodratingtotal+%s where productid=%s", $revrating, $product_id);
						$GLOBALS['ISC_CLASS_DB']->Query($query);

						$GLOBALS['ReviewMessage'] = GetLang('ReviewSavedApproved');
					}
					else {
						$GLOBALS['ReviewMessage'] = GetLang('ReviewSavedPending');
						//2011-2-21 Ronnie add, popup review show another info
						if(@$_POST['popupFlag'] == 1){
							$GLOBALS['ReviewMessage'] = GetLang('ReviewSavedPending2');	
						}
					}
					//wirror20100728: methods for order review request
					$this->_toLocation($product_id);
					exit;
				}
				else {
					// Query failed, go back to the product review form
					$GLOBALS['ReviewError'] = true;
					//wirror20100728: methods for order review request
					$this->_toLocation($product_id);
				}
			}
			else {
				// Captcha check failed, go back to the product review form
				$GLOBALS['BadCaptcha'] = true;
			    $this->_toLocation($product_id);
			}
		}
		
		//wirror20100728: methods for order review request
		private function _toLocation($product_id){
			if(@$_POST['popupFlag'] == 1){
				$_REQUEST['productItem'] = $product_id;
				//$_REQUEST['review'] = $_POST['order_id'];
				
				$GLOBALS['ISC_CLASS_ORDER'] = GetClass('ISC_ORDER');
				
				//here need to update the requeststatus to 2 in request table 
				if(isset($_POST['order_id'])&&$_POST['order_id'] != 0 )
				{
					$orderid = base64_decode($_POST['order_id']);
					$GLOBALS['ISC_CLASS_ORDER']->UpdateReviewRequestStatus($orderid, 2);
				}
				$_REQUEST['review'] = $_POST['order_id'];
				$GLOBALS['ISC_CLASS_ORDER']->AddPopupReview();
				//header('Location:'.$_POST['submitLocation']);
				
			}else{
				$GLOBALS['ISC_CLASS_PRODUCT'] = new ISC_PRODUCT($product_id);
				$GLOBALS['ISC_CLASS_PRODUCT']->ShowPage();
			}
		}
		
		public function PostForm($host, $port, $params){
			 $flag = 0;       
			 if(!is_array($params)){
			 	$params = array();
			 }          
			 foreach ($argv as $key=>$value) {        
			     if ($flag!=0) {       
			             $params .= "&";        
			             $flag = 1;        
			     }        
			     $params.= $key."="; $params.= urlencode($value);        
			     $flag = 1;        
			 }        
		     $length = strlen($params);            
		     $fp = fsockopen($host, $port, $errno, $errstr, 10) or exit($errstr."--->".$errno);   
      
		     $header = "POST /mobile/try.php HTTP/1.1";        
		     $header .= "Host:$host";        
		     $header .= "Referer:/mobile/sendpost.php";        
		     $header .= "Content-Type: application/x-www-form-urlencoded";        
		     $header .= "Content-Length: ".$length."";        
		     $header .= "Connection: Close";       
		      
		     $header .= $params."";        
		       
		     fputs($fp,$header);   
		        
		     $inheader = 1;        
		     while (!feof($fp)) {       
		             $line = fgets($fp,1024);     
		             if ($inheader && ($line == "n" || $line == "")) {       
		                 $inheader = 0;        
		             }        
		             if ($inheader == 0) {        
		                 echo $line;        
		             }        
		     } 
	    
			 fclose($fp);  
		}
        
        public function ReviewHelpful() {
            $rid = (int)$_GET['rid'];
            $reveiws = isset($_COOKIE['product_helpful_reviews']) ? explode(',', $_COOKIE['product_helpful_reviews']) : array();
            $ret = array('success' => false);
            
            if (!in_array($rid, $reveiws)) {
                if ($GLOBALS['ISC_CLASS_DB']->Query("UPDATE [|PREFIX|]reviews SET helpfulcount = helpfulcount + 1 WHERE reviewid=$rid")) {
                    $reveiws[] = $rid;
                    setcookie('product_helpful_reviews', implode(',', $reveiws), time() + 3600 * 24, '/');
                    $review = $GLOBALS['ISC_CLASS_DB']->Fetch($GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]reviews WHERE reviewid=$rid"));
                    $review['helpfulcountmessage'] = $review['helpfulcount'] .  GetLang('ProductReviewHelFulCount');
                    $ret['data'] = $review;
                    $ret['success'] = true;
                }
            }
            echo json_encode($ret);
        }
        
        private function view() {
            $productid = $_GET['product_id'];
            
            $GLOBALS['ISC_CLASS_PRODUCT'] = new ISC_PRODUCT($productid);
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('product_review');
            $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
        }
        
	}

?>