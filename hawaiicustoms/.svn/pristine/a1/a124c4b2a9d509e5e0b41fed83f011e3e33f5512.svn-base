<?php

	CLASS ISC_PRODUCTREVIEWS_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{
			// Are reviews disabled? Then don't show anything related to reviews
			if(GetConfig('EnableProductReviews') == 0) {
				$this->DontDisplay = true;
				return;
			}
            
            $GLOBALS['StyleProductReviews'] = CustomerIsSignedIn() ? 'style="text-decoration:none;float:right;"' : 'style="display:none;"';

			$GLOBALS['ProductId'] = (int)$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId();
			$GLOBALS['ProductName'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductName();
			
			//2010-11-11 Ronnie add ,if product not exist,show error Message
			$GLOBALS['HideErrorReviewMessage'] = "none";
			if($GLOBALS['ProductId']==0){
				$GLOBALS['HideErrorReviewMessage'] = "block";
				$GLOBALS['HideReviewMessage'] = "none";
				$GLOBALS['Divstyle'] = "style='display:none'";
				$GLOBALS['ReviewMessage']=sprintf(GetLang('InvalidProductError'),GetConfig('StoreName'));
				$GLOBALS['ReviewErrorMessage']=GetLang('InvalidProductErrorDetails');				
				return ;
			}
			

			// Are there any reviews for this product? If so, load them
			if(GetConfig('EnableProductReviews') == 1) {
				//if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumReviews() > 0) {
					$this->LoadProductReviews();
				/*}
				else {
					$this->DontDisplay = true;
					return;
					//$GLOBALS['NoReviews'] = GetLang('NoReviews');
				}*/
			}
			

			// Is captcha enabled?
			if (GetConfig('CaptchaEnabled') == false) {
				$GLOBALS['HideReviewCaptcha'] = "none";
			}
			else {
				// Generate the captcha image
				$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
				$GLOBALS['ISC_CLASS_CAPTCHA']->CreateSecret();
				$GLOBALS['CaptchaImage'] = $GLOBALS['ISC_CLASS_CAPTCHA']->ShowCaptcha();
				$GLOBALS['CaptchaImage2'] = $GLOBALS['ShopPath'] . "/captcha.php?" . rand(500,8000);
			}
			// Should we automatically show the comments form? This is set if captcha fails
			if ((isset($GLOBALS['BadCaptcha']) && $GLOBALS['BadCaptcha'] == true) || (isset($GLOBALS['ReviewError']) && $GLOBALS['ReviewError'] == true) ) {
				$GLOBALS['AutoShowReviewForm'] = "1";
				if(isset($_POST['revtitle'])) {
					$GLOBALS['RevTitle'] = isc_html_escape($_POST['revtitle']);
				}

				if(isset($_POST['revtext'])) {
					$GLOBALS['RevText'] = isc_html_escape($_POST['revtext']);
				}

				if(isset($_POST['revfromname'])) {
					$GLOBALS['RevFromName'] = isc_html_escape($_POST['revfromname']);
				}

				if(isset($_POST['revrating'])) {
					$tempindex= str_replace('.', '_', $_POST['revrating']);
					//$GLOBALS["ReviewRating" . (int) $_POST['revrating']] = 'selected="selected"';
					$GLOBALS["ReviewRating" . $tempindex] = 'selected="selected"';
				}
				if(isset($_POST['qualityrating'])) {
					$tempindex= str_replace('.', '_', $_POST['qualityrating']);
					//$GLOBALS["ReviewRating" . (int) $_POST['revrating']] = 'selected="selected"';
					$GLOBALS["QualityRating" . $tempindex] = 'selected="selected"';
				}
				if(isset($_POST['installrating'])) {
					$tempindex= str_replace('.', '_', $_POST['installrating']);
					//$GLOBALS["ReviewRating" . (int) $_POST['revrating']] = 'selected="selected"';
					$GLOBALS["InstallRating" . $tempindex] = 'selected="selected"';
				}
				if(isset($_POST['supportrating'])) {
					$tempindex= str_replace('.', '_', $_POST['supportrating']);
					//$GLOBALS["ReviewRating" . (int) $_POST['revrating']] = 'selected="selected"';
					$GLOBALS["SupportRating" . $tempindex] = 'selected="selected"';
				}
				if(isset($_POST['deliveryrating'])) {
					$tempindex= str_replace('.', '_', $_POST['deliveryrating']);
					//$GLOBALS["ReviewRating" . (int) $_POST['revrating']] = 'selected="selected"';
					$GLOBALS["DeliveryRating" . $tempindex] = 'selected="selected"';
				}
				if(isset($_POST['valuerating'])) {
					$tempindex= str_replace('.', '_', $_POST['valuerating']);
					//$GLOBALS["ReviewRating" . (int) $_POST['revrating']] = 'selected="selected"';
					$GLOBALS["ValueRating" . $tempindex] = 'selected="selected"';
				}
				
				
				if (isset($GLOBALS['BadCaptcha'])) {
					$GLOBALS['ReviewError'] = GetLang('ReviewBadCaptcha');
				} else {
					$GLOBALS['ReviewError'] = GetLang('ReviewInternalError');
				}

				$GLOBALS['ReviewErrorMessage'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductReviewBadCaptcha");
			}

			// Is there a message to show above the reviews?
			if (!isset($GLOBALS['ReviewMessage'])) {
				$GLOBALS['HideReviewMessage'] = "none";
			}

			// Should we go straight to the reviews?
			if (isset($GLOBALS['ReviewSaved'])) {
				$GLOBALS['JumpToReviews'] = "1";
			}
		}

		Private function LoadProductReviews()
		{
			$GLOBALS["reviewOrderId"] = $_REQUEST['review'];
            
            $query = " SELECT %s 
				   FROM [|PREFIX|]reviews r
				   LEFT JOIN [|PREFIX|]products p on r.revproductid = p.productid
                   LEFT JOIN [|PREFIX|]customers c ON r.customerid = c.customerid
				   WHERE r.revstatus = 1 and";
			
			if((int)$GLOBALS['ISC_CLASS_PRODUCT']->_prodbrandseriesid != 0)
				$query .= " p.brandseriesid = ".(int)$GLOBALS['ISC_CLASS_PRODUCT']->_prodbrandseriesid;
			else if((int)$GLOBALS['ISC_CLASS_PRODUCT']->_prodbrandid != 0)
				$query .= " p.prodbrandid = ".(int)$GLOBALS['ISC_CLASS_PRODUCT']->_prodbrandid;
            $query .= ' %s';
            
			// Setup paging data
            $result = $GLOBALS['ISC_CLASS_DB']->Fetch($GLOBALS['ISC_CLASS_DB']->Query(sprintf($query, 'COUNT(*) AS num', '')));
			$reviewsTotal = $result['num'];
			$reviewsPerPage = GetConfig('ProductReviewsPerPage');
			$pages = ceil($reviewsTotal / $reviewsPerPage);
            
            // dada sort review
            $canSort = array(1,2,3,4);
            $sort = (isset($_GET['sort']) && in_array($_GET['sort'], $canSort)) ? $_GET['sort'] : 1;
            foreach ($canSort as $item) {
                $GLOBALS["SortSelected_$item"] = $sort == $item ? 'selected="selected"' : '';
            }

			$revpage = 1;
			$start = 0;

			if (isset($_GET['revpage'])) {
				$revpage = (int)$_GET['revpage'];
			}

			if ($revpage < 1) {
				$revpage = 1;
			}
			elseif ($revpage > $pages) {
				$revpage = $pages;
			}

			$start = ($revpage - 1) * $reviewsPerPage;

			$GLOBALS['ProductNumReviews'] = $reviewsTotal;
			$GLOBALS['ReviewStart'] = $start + 1;
			$GLOBALS['ReviewEnd'] = $start + $reviewsPerPage;

			// do we need to show paging?
			if ($pages > 1) {
				
				// Form the previous and next links
				$reviewLink = $GLOBALS['ShopPath'] . "/postreview.php?action=view&product_id=" . $GLOBALS['ISC_CLASS_PRODUCT']->GetProductId() . "&sort=$sort&revpage=";
				
				//2011-3-2 Ronnie add, change Next link
				if(isset($GLOBALS['ExReviewPageLink'])){$reviewLink=$GLOBALS['ExReviewPageLink'];}
				
                /*
				if($GLOBALS['EnableSEOUrls'] == 1) {
					$reviewLink .= '?revpage=';
				}
				else {
					$reviewLink .= '&revpage=';
				}
                 */
                

				if ($GLOBALS['ReviewEnd'] > $reviewsTotal) {
					$GLOBALS['ReviewEnd'] = $reviewsTotal;
				}

				// show a previous link
				if ($revpage > 1) {
					$GLOBALS["ReviewLink"] = $reviewLink . ($revpage - 1);
					$GLOBALS["PrevRevLink"] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductReviewPreviousLink");
				}

				// show a next link
				if ($revpage < $pages) {
					$GLOBALS["ReviewLink"] = $reviewLink . ($revpage + 1);
					$GLOBALS["NextRevLink"] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductReviewNextLink");
				}

				$GLOBALS['ProductReviewPaging'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductReviewPaging");
			}
            $GLOBALS['ProductReviewSort'] = $reviewsTotal > 1 ? $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductReviewSort") : '';
            $GLOBALS['HideNoReviewsMessage'] = $reviewsTotal ? 'none' : '';
			// dada 2012-02-29 sorting
            $sorting = ' ORDER BY %s ';
			switch ($sort) {
                case 1:
                    $sorting = sprintf($sorting, "revrating ASC");
                    break;
                case 2:
                    $sorting = sprintf($sorting, "revrating DESC");
                    break;
                case 3:
                    $sorting = sprintf($sorting, "revdate DESC");
                    break;
                default:
                    $sorting = sprintf($sorting, "revdate ASC");
            }
            
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, $reviewsPerPage);
			$result = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($query, "r.*, p.prodname, c.custconlastname, c.custconfirstname", $sorting));

			$GLOBALS['ProductReviews'] = "";

			$GLOBALS['AlternateReviewClass'] = '';
			$GLOBALS['ReviewNumber'] = $GLOBALS['ReviewStart'];
            
            // dada 20120229 already review helpful
            $reveiws = isset($_COOKIE['product_helpful_reviews']) ? explode(',', $_COOKIE['product_helpful_reviews']) : array();
            
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $GLOBALS['ReviewId'] = $row['reviewid'];
				$GLOBALS['ReviewRating'] = isset($row['revrating'])?$row['revrating']:'0';//(int) $row['revrating'];
				$GLOBALS['ReviewTitle'] = isc_html_escape($row['revtitle']);
				$GLOBALS['ReviewDate'] = isc_date('M jS, Y', $row['revdate']);
				//lguan_20100612: Showing extra ratings
				$GLOBALS['RatingQuality'] = isset($row['qualityrating'])?$row['qualityrating']:'0';
				$GLOBALS['RatingInstall'] = isset($row['installrating'])?$row['installrating']:'0';
				$GLOBALS['RatingValue'] = isset($row['valuerating'])?$row['valuerating']:'0';
				$GLOBALS['RatingSupport'] = isset($row['supportrating'])?$row['supportrating']:'0';
				$GLOBALS['RatingDelivery'] = isset($row['deliveryrating'])?$row['deliveryrating']:'0';
                $GLOBALS['ReviewHelpfulCount'] = $row['helpfulcount'] ? $row['helpfulcount'] .  GetLang('ProductReviewHelFulCount') : '';

                $GLOBALS['ReviewName'] = "{$row['custconlastname']} {$row['custconfirstname']}";
                if (trim($GLOBALS['ReviewName']) == '') {
                    $GLOBALS['ReviewName'] = GetLang('Unknown');
                }
                
                $GLOBALS['ProductReviewHelpFul'] = !in_array($row['reviewid'], $reveiws) ? GetLang('ProductReviewHelpFul')."&nbsp;&nbsp;<a onclick=\"review_helpful(this, event);\" href=\"" . GetConfig('ShopPathNormal') . "/postreview.php?action=review_helpful&rid={$row['reviewid']}\">[Yes]</a>" : '';
                
                $GLOBALS['RateYear'] = $row['prodyear'] ? $row['prodyear'] : GetLang('Unknown');
                $GLOBALS['RateMake'] = $row['prodmake'];
                $GLOBALS['RateModel'] = $row['prodmodel'];
                $GLOBALS['ProductName'] = $row['prodname'];
				
				$GLOBALS['ReviewText'] = nl2br(isc_html_escape($row['revtext']));

				$GLOBALS['ProductReviews'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductReviewItem");
				++$GLOBALS['ReviewNumber'];
				if($GLOBALS['AlternateReviewClass']) {
					$GLOBALS['AlternateReviewClass'] = '';
				}
				else {
					$GLOBALS['AlternateReviewClass'] = 'Alt';
				}
			}

			//2011-2-18 Ronnie add
			//echo "111".$GLOBALS['ReviewMessage']."::".GetLang('ReviewSavedPending');
			if($GLOBALS['ReviewMessage'] == GetLang('ReviewSavedPending2')){
				$GLOBALS['DisplayProductReviews']="style='display:none'";
			}
			
			$GLOBALS['ProductReviewList'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductReviewList");
		}
	}

?>
