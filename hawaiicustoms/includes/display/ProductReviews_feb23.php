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

			$GLOBALS['ProductId'] = (int)$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId();

			// Are there any reviews for this product? If so, load them
			if(GetConfig('EnableProductReviews') == 1) {
				if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumReviews() > 0) {
					$this->LoadProductReviews();
				}
				else {
					$this->DontDisplay = true;
					return;
					//$GLOBALS['NoReviews'] = GetLang('NoReviews');
				}
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
					$GLOBALS["ReviewRating" . (int) $_POST['revrating']] = 'selected="selected"';
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
			// Setup paging data
			$reviewsTotal = $GLOBALS['ISC_CLASS_PRODUCT']->GetNumReviews();
			$reviewsPerPage = GetConfig('ProductReviewsPerPage');
			$pages = ceil($reviewsTotal / $reviewsPerPage);

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
				$reviewLink = ProdLink($GLOBALS['ISC_CLASS_PRODUCT']->GetProductName());
				if($GLOBALS['EnableSEOUrls'] == 1) {
					$reviewLink .= '?revpage=';
				}
				else {
					$reviewLink .= '&revpage=';
				}

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

			// Load all reviews for this product
			/*$query = "
				SELECT *
				FROM [|PREFIX|]reviews
				WHERE revproductid='".(int)$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()."' AND revstatus='1'
				ORDER BY revdate DESC
			";*/
			
			$query = " SELECT r.* FROM [|PREFIX|]reviews r left join [|PREFIX|]products p on r.revproductid = p.productid WHERE r.revstatus = 1 and ";
			if((int)$GLOBALS['ISC_CLASS_PRODUCT']->_prodbrandseriesid != 0)
				$query .= " p.brandseriesid = ".(int)$GLOBALS['ISC_CLASS_PRODUCT']->_prodbrandseriesid;
			else if((int)$GLOBALS['ISC_CLASS_PRODUCT']->_prodbrandid != 0)
				$query .= " p.prodbrandid = ".(int)$GLOBALS['ISC_CLASS_PRODUCT']->_prodbrandid;
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, $reviewsPerPage);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			$GLOBALS['ProductReviews'] = "";

			$GLOBALS['AlternateReviewClass'] = '';
			$GLOBALS['ReviewNumber'] = $GLOBALS['ReviewStart'];
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$GLOBALS['ReviewRating'] = (int) $row['revrating'];
				$GLOBALS['ReviewTitle'] = isc_html_escape($row['revtitle']);
				$GLOBALS['ReviewDate'] = isc_date(GetConfig('DisplayDateFormat'), $row['revdate']);

				if ($row['revfromname'] != "") {
					$GLOBALS['ReviewName'] = isc_html_escape($row['revfromname']);
				} else {
					$GLOBALS['ReviewName'] = GetLang('Unknown');
				}
				
				$GLOBALS['ReviewName'] = $row['revsource'];

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

			$GLOBALS['ProductReviewList'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductReviewList");
		}
	}

?>