<?php

	define("ISC_REVIEWS_PER_PAGE", 20);

	class ISC_ADMIN_REVIEW
	{
		public $_customSearch = array();
		
		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('reviews');
			switch(isc_strtolower($Do))
			{
				case "editreview2": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Reviews)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Reviews') => "index.php?ToDo=viewReviews");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditReviewStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "editreview": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Reviews)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Reviews') => "index.php?ToDo=viewReviews", GetLang('EditReview') => "index.php?ToDo=editReview");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditReviewStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "previewreview": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Reviews)) {
						$this->PreviewReview();
						die();
					} else {
						echo '<script type="text/javascript">window.close();</script>';
					}

					break;
				}
				case "disapprovereviews": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Reviews)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Reviews') => "index.php?ToDo=viewReviews");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DisapproveReviews();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "approvereviews": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Reviews)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Reviews') => "index.php?ToDo=viewReviews");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->ApproveReviews();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "deletereviews": {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Delete_Reviews)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Reviews') => "index.php?ToDo=viewReviews");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteReviews();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
                case "loadreviewseries": {
                    if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Delete_Reviews)) {

                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Reviews') => "index.php?ToDo=viewReviews");                       
                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }                    
                        $this->LoadSeriesList();     
                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }
                        
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                } 
                case "loadreviewcategories": {
                	// lguan_20100612: Added for adding categories into product rating 
                    if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Delete_Reviews)) {

                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Reviews') => "index.php?ToDo=viewReviews");                       
                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }                    
                        $this->loadSubCategoriesList();     
                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }
                        
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                } 
                case "searchreviews":{
                	//wiyin_20100624: add advanced search
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Reviews)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Reviews') => "index.php?ToDo=viewReviews", GetLang('SearchReviews') => "index.php?ToDo=searchReviews");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SearchReviews();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
                }
                case "customreviewsearch":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Products') => "index.php?ToDo=viewProducts", GetLang('CustomView') => "index.php?ToDo=customProductSearch");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CustomSearch();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
                case "searchreviewsredirect":{
                	//wiyin_20100624: add advanced search
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Reviews)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Reviews') => "index.php?ToDo=viewReviews", GetLang('SearchReviews') => "index.php?ToDo=searchReviews");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SearchReviewsRedirect();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
                }
				case "prodreviewoverviewgrid":{
					//wiyin_20100624: product reviews overview
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Reviews)) {
						$reviewClass = GetClass('ISC_ADMIN_REVIEW_OVERVIEW');
						$reviewClass->ProductReviewOverviewGrid();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
                }
				default: {
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Reviews)) {
						if(isset($_GET['searchQuery'])) {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Reviews') => "index.php?ToDo=viewReviews", GetLang('SearchResults') => "index.php?ToDo=viewReviews");
						}
						else {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Reviews') => "index.php?ToDo=viewReviews");
						}

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						$this->ManageReviews();

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
			}
		}
		
		public function CustomSearch()
		{
			SetSession('reviewsearch', (int) $_GET['searchId']);

			if ($_GET['searchId'] > 0) {
				$this->_customSearch = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->LoadSearch($_GET['searchId']);
				$_REQUEST = array_merge($_REQUEST, $this->_customSearch['searchvars']);
			}

			if (isset($_REQUEST['new'])) {
				$this->ManageReviews(GetLang('CustomSearchSaved'), MSG_SUCCESS);
			} else {
				$this->ManageReviews();
			}
		}
		
		
		/**
		*	This function checks to see if the user wants to save the search details as a custom search,
		*	and if they do one is created. They are then forwarded onto the search results
		*/
		public function SearchReviewsRedirect()
		{
			// Are we saving this as a custom search?
			if(isset($_GET['viewName']) && $_GET['viewName'] != '') {
				if(isset($_GET['ISSelectReplacement_category'])) {
					unset($_GET['ISSelectReplacement_category']);
				}

				$search_id = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->SaveSearch($_GET['viewName'], $_GET);

				if($search_id > 0) {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($search_id, $_GET['viewName']);   
					ob_end_clean();
					header(sprintf("Location:index.php?ToDo=customReviewSearch&searchId=%d&new=true", $search_id));
					exit;
				}
				else {
					$this->ManageReviews(sprintf(GetLang('ViewAlreadExists'), isc_html_escape($_GET['viewName'])), MSG_ERROR);
				}

			}
			// Plain search
			else {
                $this->ManageReviews();
			}
		}
		
		public function SearchReviews()
		{
			//wiyin_20100624: Fetching calendar options
			$from_stamp = 0;
			$to_stamp = 0;
			$calendaInfo = NULL;
			if (isset($_GET['datetype'])) {
				$GLOBALS['CurrentDate'] = $_GET['datetype'];
				$calendaInfo['DateType'] = $GLOBALS['CurrentDate'];
				if(isset($_GET['from'])) {
					$datestamp = strtotime($_GET['from']);
					$calendaInfo['From']['Yr'] = isc_date('Y', $datestamp);
					$calendaInfo['From']['Mth'] = isc_date('m', $datestamp);
					$calendaInfo['From']['Day'] = isc_date('d', $datestamp);
				}
				if(isset($_GET['to'])) {
					$datestamp = strtotime($_GET['to']);
					$calendaInfo['To']['Yr'] = isc_date('Y', $datestamp);
					$calendaInfo['To']['Mth'] = isc_date('m', $datestamp);
					$calendaInfo['To']['Day'] = isc_date('d', $datestamp);
				}
			}
			else {
				$GLOBALS['CurrentDate'] = "Last30Days";
				$calendaInfo['DateType'] = $GLOBALS['CurrentDate'];
			}
			$cal = $this->CalculateCalendarRestrictions($calendaInfo);
			// Set the global variables for the select boxes
			$from_stamp = $cal['start'];
			$to_stamp = $cal['end'];
			$GLOBALS['CalendarDateTypeOptions'] = $this->_GetCalendarDateTypesAsOptions($GLOBALS['CurrentDate']);
			$GLOBALS['FromStamp'] = $from_stamp;
			$GLOBALS['ToStamp'] = $to_stamp;
			
			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
			$GLOBALS['CategoryOptions'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions("", "<option %s value='%d'>%s</option>", "selected=\"selected\"", "", false);

			$GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS');
			$GLOBALS['BrandNameOptions'] = $GLOBALS['ISC_CLASS_ADMIN_BRANDS']->GetBrandsAsOptions();

			if (GetConfig('CurrencyLocation') == 'right') {
				$GLOBALS['CurrencyTokenLeft'] = '';
				$GLOBALS['CurrencyTokenRight'] = GetConfig('CurrencyToken');
			} else {
				$GLOBALS['CurrencyTokenLeft'] = GetConfig('CurrencyToken');
				$GLOBALS['CurrencyTokenRight'] = '';
			}

			if(!gzte11(ISC_MEDIUMPRINT)) {
				$GLOBALS['HideInventoryOptions'] = "none";
			}
			
			//wiyin_20100624: Showing date range seletion for product reviews
			$GLOBALS['FromDatePicker'] = $this->getDatePickerHtml("fromPicker", "Calendar[From]", isc_date('m/d/Y', $from_stamp));
			$GLOBALS['ToDatePicker'] = $this->getDatePickerHtml("toPicker", "Calendar[To]", isc_date('m/d/Y', $to_stamp));

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("reviews.search");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function EditReviewStep2()
		{
			// Save the updated review
			$reviewId = (int)$_POST['reviewId'];
			$arrData = array();
			$existingData = array();
			// Fetch the existing review
			$this->_GetReviewData($reviewId, $existingData);
			$this->_GetReviewData(0, $arrData);
			/*// If the rating has changed and this review is approved we need to remove the old rating from the total
			if(isset($existingData['revrating']) && $existingData['revrating'] != 0 && $existingData['revrating'] != $arrData['revrating'] && $existingData['revstatus'] == 1) {
				$query = sprintf("update [|PREFIX|]products set prodratingtotal=prodratingtotal-%1.1f+%1.1f where productid=%d", 
												$existingData['revrating'], 
												((isset($arrData['revrating'])&&$arrData['revrating']!=0)?$arrData['revrating']:0), 
												$existingData['revproductid']);
				$GLOBALS['ISC_CLASS_DB']->Query($query);
			}
			// Has the status changed?
			if($arrData['revstatus'] != $existingData['revstatus']) {
				// This view is now approved
				if(($arrData['revstatus'] == 1) && isset($arrData['revrating']) && $arrData['revrating']!=0) {
					$query = sprintf("update [|PREFIX|]products set prodnumratings=prodnumratings+1, prodratingtotal=prodratingtotal+%1.1f where productid=%d", $arrData['revrating'], $existingData['revproductid']);
					$GLOBALS['ISC_CLASS_DB']->Query($query);
				}
				// Review is now unapproved
				else {
					// has the rating
					$totalUpdate = '';
					if ($existingData['revstatus'] == 1 && isset($existingData['revrating']) && $existingData['revrating']!=0) {
						$totalUpdate = sprintf(", prodratingtotal=prodratingtotal-%1.1f", ((isset($arrData['revrating'])&&$arrData['revrating']!=0)?$arrData['revrating']:0));
						$query = sprintf("update [|PREFIX|]products set prodnumratings=prodnumratings-1 %s where productid=%s", $totalUpdate, $existingData['revproductid']);
						$GLOBALS['ISC_CLASS_DB']->Query($query);
					}
				}
			}*/
			
			//lguan_20100709: Allow NULL value for those rating options
			$updatedReview = array(
				"revfromname" => $arrData['revfromname'],
				//"revtext" => $arrData['revtext'],
				"revtitle" => $arrData['revtitle'],
				"revstatus" => $arrData['revstatus'],
				"revrating" => ((isset($arrData['revrating']) && $arrData['revrating']!=0)?$arrData['revrating']:NULL),
				"qualityrating" => ((isset($arrData['qualityrating']) && $arrData['qualityrating']!=0)?$arrData['qualityrating']:NULL),
				"installrating" => ((isset($arrData['installrating']) && $arrData['installrating']!=0)?$arrData['installrating']:NULL),
				"valuerating" => ((isset($arrData['valuerating']) && $arrData['valuerating']!=0)?$arrData['valuerating']:NULL),
				"supportrating" => ((isset($arrData['supportrating']) && $arrData['supportrating']!=0)?$arrData['supportrating']:NULL),
				"deliveryrating" => ((isset($arrData['deliveryrating']) && $arrData['deliveryrating']!=0)?$arrData['deliveryrating']:NULL)
			);
			
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("reviews", $updatedReview, "reviewid='".$GLOBALS['ISC_CLASS_DB']->Quote($reviewId)."'", true);
			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
			if ($err != "") {
								
				$this->ManageReviews($err, MSG_ERROR);
			} else {
				$query = "	SELECT revrating
								FROM [|PREFIX|]reviews r
								WHERE revproductid = ".$existingData['revproductid'] ." AND revstatus = 1 ";

				$revtotal = 0;
				$revcount = 0;

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				while($review = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$revtotal += (float)$review['revrating'];
					$revcount++;
				}

				$query = "	UPDATE [|PREFIX|]products
							SET prodratingtotal=$revtotal, prodnumratings=$revcount
							WHERE productid=".$existingData['revproductid'];

				$GLOBALS['ISC_CLASS_DB']->Query($query);
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($reviewId, $arrData['revtitle']);

				$this->ManageReviews(GetLang('ReviewUpdatedSuccessfully'), MSG_SUCCESS);
			}
		}

		private function _GetReviewData($ReviewId, &$RefArray)
		{
			// Gets the details of a review Returns the data to the array
			// referenced by the $RefArray variable.

			if ($ReviewId == 0) {
				// Get the data from the form
				$RefArray['reviewid'] = $_POST['reviewId'];
				$RefArray['revfromname'] = $_POST['revfromname'];
				$RefArray['revrating'] = $_POST['revrating'];
				//$RefArray['revtext'] = $_POST['revtext'];
				$RefArray['revtitle'] = $_POST['revtitle'];
				$RefArray['revstatus'] = $_POST['revstatus'];
				$RefArray['qualityrating'] = $_POST['qualityrating'];
				$RefArray['installrating'] = $_POST['installrating'];
				$RefArray['valuerating'] = $_POST['valuerating'];
				$RefArray['supportrating'] = $_POST['supportrating'];
				$RefArray['deliveryrating'] = $_POST['deliveryrating'];
			} else {
				// Get the data from the database
				$query = "
					SELECT r.*, p.prodvendorid
					FROM [|PREFIX|]reviews r
					LEFT JOIN [|PREFIX|]products p ON (p.productid=r.revproductid)
					WHERE reviewid='".(int)$ReviewId."'
				";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$RefArray = $row;
				}
			}
		}

		private function _GetStatusOptions($Status = -1)
		{
			// Output option fields containing status values
			if ($Status == 0) {
				$sel = "selected=\"selected\"";
			} else {
				$sel = "";
			}

			$output = sprintf("<option value=0 %s>%s</option>", $sel, GetLang('Pending'));

			if ($Status == 1) {
				$sel = "selected=\"selected\"";
			} else {
				$sel = "";
			}

			$output .= sprintf("<option value=1 %s>%s</option>", $sel, GetLang('Approved'));

			if ($Status == 2) {
				$sel = 'selected="selected"';
			} else {
				$sel = "";
			}

			$output .= sprintf("<option value=2 %s>%s</option>", $sel, GetLang('Disapproved'));

			return $output;
		}

		private function _GetRatingOptions($Rating)
		{
			// Output option fields containing rating values
			if ($Rating == 0.5) {
				$sel = "selected=\"selected\"";
			} else {
				$sel = "";
			}
			$output .= sprintf("<option value=0.5 %s>%s</option>", $sel, GetLang('0_5Star'));
			
			if ($Rating == 1) {
				$sel = "selected=\"selected\"";
			} else {
				$sel = "";
			}

			$output .= sprintf("<option value=1 %s>%s</option>", $sel, GetLang('1Star'));
			if ($Rating == 1.5) {
				$sel = "selected=\"selected\"";
			} else {
				$sel = "";
			}
			$output .= sprintf("<option value=1.5 %s>%s</option>", $sel, GetLang('1_5Star'));

			if ($Rating == 2) {
				$sel = "selected=\"selected\"";
			} else {
				$sel = "";
			}

			$output .= sprintf("<option value=2 %s>%s</option>", $sel, GetLang('2Stars'));
			if ($Rating == 2.5) {
				$sel = "selected=\"selected\"";
			} else {
				$sel = "";
			}
			$output .= sprintf("<option value=2.5 %s>%s</option>", $sel, GetLang('2_5Star'));

			if ($Rating == 3) {
				$sel = "selected=\"selected\"";
			} else {
				$sel = "";
			}

			$output .= sprintf("<option value=3 %s>%s</option>", $sel, GetLang('3Stars'));
			
			if ($Rating == 3.5) {
				$sel = "selected=\"selected\"";
			} else {
				$sel = "";
			}
			$output .= sprintf("<option value=3.5 %s>%s</option>", $sel, GetLang('3_5Star'));

			if ($Rating == 4) {
				$sel = "selected=\"selected\"";
			} else {
				$sel = "";
			}

			$output .= sprintf("<option value=4 %s>%s</option>", $sel, GetLang('4Stars'));

			if ($Rating == 4.5) {
				$sel = "selected=\"selected\"";
			} else {
				$sel = "";
			}
			$output .= sprintf("<option value=4.5 %s>%s</option>", $sel, GetLang('4_5Star'));
			
			if ($Rating == 5) {
				$sel = "selected=\"selected\"";
			} else {
				$sel = "";
			}

			$output .= sprintf("<option value=5 %s>%s</option>", $sel, GetLang('5Stars'));
			return $output;
		}

		private function EditReviewStep1()
		{
			// Show the form to edit a product
			$reviewId = (int)$_GET['reviewId'];
			$arrData = array();

			// Make sure the product exists
			if (ReviewExists($reviewId)) {
				$this->_GetReviewData($reviewId, $arrData);

				// Does this user have permission to edit this review?
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $arrData['prodvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewReviews');
				}

				$GLOBALS['ReviewId'] = $reviewId;
				$GLOBALS['FromName'] = isc_html_escape($arrData['revfromname']);
				$GLOBALS['Title'] = isc_html_escape($arrData['revtitle']);
				$GLOBALS['Review'] = isc_html_escape($arrData['revtext']);
				$GLOBALS['StatusOptions'] = $this->_GetStatusOptions($arrData['revstatus']);
				$GLOBALS['RatingOptions'] = $this->_GetRatingOptions($arrData['revrating']);
				//lguan_20100612: Show extra ratings
				$GLOBALS['RatingQualityOptions'] = $this->_GetRatingOptions($arrData['qualityrating']);
				$GLOBALS['RatingInstallOptions'] = $this->_GetRatingOptions($arrData['installrating']);
				$GLOBALS['RatingValueOptions'] = $this->_GetRatingOptions($arrData['valuerating']);
				$GLOBALS['RatingSupportOptions'] = $this->_GetRatingOptions($arrData['supportrating']);
				$GLOBALS['RatingDeliveryOptions'] = $this->_GetRatingOptions($arrData['deliveryrating']);
				
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("review.form");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			} else {
				// The review doesn't exist
				$this->ManageReviews(GetLang('ReviewDoesntExist'), MSG_ERROR);
			}
		}

		private function PreviewReview()
		{
			$GLOBALS['Rating'] = "";

			// Preview a review
			if (isset($_GET['reviewId'])) {
				$reviewId = $_GET['reviewId'];
				$query = sprintf("select * from [|PREFIX|]reviews r inner join [|PREFIX|]products p on r.revproductid=p.productid where r.reviewid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($reviewId));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

				if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$GLOBALS['Product'] = isc_html_escape($row['prodname']);
					$GLOBALS['Title'] = isc_html_escape($row['revtitle']);
					$GLOBALS['Review'] = str_replace("\n", "<br />", isc_html_escape($row['revtext']));

					$ratingText = sprintf(GetLang('ReviewRated'), $row['revrating']);

					if ($row['revfromname'] == "") {
						$GLOBALS['Author'] = GetLang('NA');
					} else {
						$GLOBALS['Author'] = isc_html_escape($row['revfromname']);
					}

					//lguan_20100612: Showing extra ratings
					$GLOBALS['Rating'] = $this->wrapRatingImages($row['revrating']);
					$GLOBALS['RatingQuality'] = $this->wrapRatingImages($row['qualityrating']);
					$GLOBALS['RatingInstall'] = $this->wrapRatingImages($row['installrating']);
					$GLOBALS['RatingValue'] = $this->wrapRatingImages($row['valuerating']);
					$GLOBALS['RatingSupport'] = $this->wrapRatingImages($row['supportrating']);
					$GLOBALS['RatingDelivery'] = $this->wrapRatingImages($row['deliveryrating']);
					// lguan_20100612: Showing YMM info
					$GLOBALS['RateYear'] =$row['prodyear'];
					$GLOBALS['RateMake'] = $row['prodmake'];
					$GLOBALS['RateModel'] = $row['prodmodel'];

					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("review.preview");
					$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
				} else {
					echo '<script type="text/javascript">window.close();</script>';
				}
			} else {
				echo '<script type="text/javascript">window.close();</script>';
			}
		}

		private function ApproveReviews()
		{
			if (isset($_POST['reviews'])) {
				$err = '';
				$msg = $this->DoApproveReviews($_POST['reviews'], $err);
				if ($err != "") {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['reviews']));
					$this->ManageReviews($err, MSG_ERROR);
				} else {
					$this->ManageReviews($msg, MSG_SUCCESS);
				}
			} else {
				if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Reviews)) {
					$this->ManageReviews();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

		private function DisapproveReviews()
		{
			if (isset($_POST['reviews'])) {
				$err = '';
				$msg = $this->DoDisapproveReviews($_POST['reviews'], $err);
				if ($err != "") {
					$this->ManageReviews($err, MSG_ERROR);
				} else {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['reviews']));

					$this->ManageReviews($msg, MSG_SUCCESS);
				}
			} else {
				if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Reviews)) {
					$this->ManageReviews();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

		private function DeleteReviews()
		{
			if (isset($_POST['reviews'])) {
				$err = '';
				$msg = $this->DoDeleteReviews($_POST['reviews'], $err);
				if ($err != "") {
					$this->ManageReviews($err, MSG_ERROR);
				} else {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['reviews']));

					$this->ManageReviews($msg, MSG_SUCCESS);
				}
			} else {
				if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Reviews)) {
					$this->ManageReviews();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

		public function DoApproveReviews($reviews, &$err)
		{
			$this->DoReviews($reviews, 'approve');

			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
			if($err) {
				return false;
			}

			return GetLang('ReviewsApprovedSuccessfully');
		}

		public function DoDisapproveReviews($reviews, &$err)
		{
			$this->DoReviews($reviews, 'disapprove');

			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
			if ($err != "") {
				return false;
			}

			return GetLang('ReviewsDisapprovedSuccessfully');
		}

		public function DoDeleteReviews($reviews, &$err)
		{
			$this->DoReviews($reviews, 'delete');

			$err = $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
			if ($err != "") {
				return false;
			}
			return GetLang('ReviewsDeletedSuccessfully');
		}

		private function DoReviews($reviews, $method)
		{

			if(!is_array($reviews)) {
				$reviews = array($reviews);
			}

			$reviewids = implode(",", array_map('intval', $reviews));

			// We need to fetch the product for each review to update it accordingly
			$vendorId = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
			$queryWhere = '';
			if($vendorId > 0) {
				$queryWhere .= " AND prodvendorid='".(int)$vendorId."'";
			}
			$query = "	SELECT reviewid, revproductid
						FROM [|PREFIX|]reviews r
						INNER JOIN [|PREFIX|]products p ON (p.productid=r.revproductid)
						WHERE reviewid IN (".$reviewids.")".$queryWhere;

			$updatedReviews = array();
			$updatedProducts = array();

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($review = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$updatedReviews[] = (int)$review['reviewid'];
				$updatedProducts[] = (int)$review['revproductid'];
			}

			$updatedProducts = array_unique($updatedProducts);

			// Now we update the reviews to approve them
			$reviewids = implode("','", $updatedReviews);
			if($reviewids) {

				$reviewUpdate = array();

				if ($method == 'approve') {
					$reviewUpdate = array("revstatus" => 1);
				}
				else if ($method == 'disapprove') {
					$reviewUpdate = array("revstatus" => 0);
				}

				if ($method == 'delete') {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('reviews', "WHERE reviewid IN ('".$reviewids."')");
				}
				else {
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery("reviews", $reviewUpdate, "reviewid IN ('".$reviewids."')");
				}

				// Now we need to update the products with the new review total
				foreach($updatedProducts as $productid) {

					$query = "	SELECT revrating
								FROM [|PREFIX|]reviews r
								WHERE revproductid = $productid AND revstatus = 1 ";

					$revtotal = 0;
					$revcount = 0;

					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

					while($review = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						$revtotal += (float)$review['revrating'];
						$revcount++;
					}

					$query = "	UPDATE [|PREFIX|]products
								SET prodratingtotal=$revtotal, prodnumratings=$revcount
								WHERE productid=$productid";

					$GLOBALS['ISC_CLASS_DB']->Query($query);
				}
			}
		}

		public function ManageReviewsGrid(&$numReviews)
		{
			// Show a list of reviews in a table
			$page = 0;
			$start = 0;
			$numReviews = 0;
			$numPages = 0;
			$GLOBALS['ReviewGrid'] = "";
			$GLOBALS['Nav'] = "";
			$max = 0;
			$searchURL = '';
            $filterURL = '';
            
            //Added by Simha
            if(isset($_GET['brandid'])) {
                $filterURL .= "&amp;brandid=".trim($_GET['brandid'])."";
            }
            if(isset($_GET['seriesid'])) {                                       
                $filterURL .= "&amp;seriesid=".trim($_GET['seriesid'])."";
            }    
            //Added by Simha Ends
           
            //lguan_20100612: Category supporting in product rating
            if(isset($_GET['catid'])) {                                       
                $filterURL .= "&amp;catid=".trim($_GET['catid'])."";
            }   
            if(isset($_GET['subcatid'])) {                                       
                $filterURL .= "&amp;subcatid=".trim($_GET['subcatid'])."";
            }   
            //lguan_20100615: Append information for from and to
            if(isset($GLOBALS['FromStamp']) && is_numeric($GLOBALS['FromStamp'])) {
            	$filterURL .= "&amp;from=".isc_date('m/d/Y', $GLOBALS['FromStamp'])."";
            }
            if (isset($GLOBALS['ToStamp']) && is_numeric($GLOBALS['ToStamp'])) {
            	$filterURL .= "&amp;to=".isc_date('m/d/Y', $GLOBALS['ToStamp'])."";
            }
            if (isset($_GET['datetype']) ) {
            	$filterURL .= "&amp;datetype=".$_GET['datetype']."";
            }
            //wiyin_20100628: get the review status
            if(isset($_GET['reviewStatus'])) {                                       
                $GLOBALS['reviewStatus'] = (int)$_GET['reviewStatus'];
            }
            if(isset($_GET['ISSelectReplacement_category'])) { 
            	$cateList = $_GET['ISSelectReplacement_category'];
            	if (is_array($cateList)) { 
	            	if (!in_array(0, $cateList))
					   $GLOBALS['CateList'] = $cateList;
            	}
            }

			if (isset($_GET['searchQuery'])) {
				$query = $_GET['searchQuery'];
				$GLOBALS['Query'] = $query;
				$searchURL = sprintf("&amp;searchQuery=%s", urlencode($query));
			} else {
				$query = "";
				$GLOBALS['Query'] = "";
			}

			if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'asc') {
				$sortOrder = 'asc';
			} else {
				$sortOrder = "desc";
			}

			$sortLinks = array(
				"OrderId" => "r.orderid",
				"Review" => "r.revtitle",
				"Name" => "p.prodname",
				"By" => "r.revfromname",
				"Rating" => "r.revrating",
				"Date" => "r.revdate",
				"Status" => "r.revstatus",
				"RatingQuality" => "r.qualityrating",
				"RatingInstall" => "r.installrating",
				"RatingValue" => "r.valuerating",
				"RatingSupport" => "r.supportrating",
				"RatingDelivery" => "r.deliveryrating"
			);

			if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
				$sortField = $_GET['sortField'];
				SaveDefaultSortField("ManageReviews", $_REQUEST['sortField'], $sortOrder);
			}
			else {
				list($sortField, $sortOrder) = GetDefaultSortField("ManageReviews", "r.reviewid", $sortOrder);
			}

			if (isset($_GET['page'])) {
				$page = (int)$_GET['page'];
			} else {
				$page = 1;
			}
			$GLOBALS['Page'] = $page;

			$sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
			$GLOBALS['SortURL'] = $sortURL;

			// Limit the number of questions returned
			if ($page == 1) {
				$start = 1;
			} else {
				$start = ($page * ISC_REVIEWS_PER_PAGE) - (ISC_REVIEWS_PER_PAGE-1);
			}

			$start = $start-1;

			// Get the results for the query
			$reviewResult = $this->_GetReviewList($query, $start, $sortField, $sortOrder, $numReviews);
			$numPages = ceil($numReviews / ISC_REVIEWS_PER_PAGE);

			// Add the "(Page x of n)" label
			if($numReviews > ISC_REVIEWS_PER_PAGE) {
				$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);
				$GLOBALS['Nav'] .= BuildPagination($numReviews, ISC_REVIEWS_PER_PAGE, $page, sprintf("index.php?ToDo=viewReviews%s%s%s", $sortURL, $filterURL, $searchURL));
			}
			else {
				$GLOBALS['Nav'] = "";
			}

			$GLOBALS['Nav'] = rtrim($GLOBALS['Nav'], ' |');
			$GLOBALS['SearchQuery'] = $query;
			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;

			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewReviews&amp;".$searchURL."&amp;page=".$page.$filterURL, $sortField, $sortOrder);

			// Workout the maximum size of the array
			$max = $start + ISC_REVIEWS_PER_PAGE;

			if ($max > $numReviews) {
				$max = $numReviews;
			}

			if($numReviews > 0) {
				// Display the reviews
				while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($reviewResult)) {
					$GLOBALS['ReviewId'] = $row['reviewid'];
					$GLOBALS['ProdName'] = isc_html_escape($row['prodname']);
					$GLOBALS['ProdLink'] = ProdLink($row['prodname']);
					if (isc_strlen($row['revtext']) > 100) {
						$GLOBALS['ReviewTitle'] = isc_html_escape(sprintf("%s...", isc_substr($row['revtitle'], 0, 100)));
					} else {
						$GLOBALS['ReviewTitle'] = isc_html_escape($row['revtitle']);
					}

					//lguan_20100612: Show extra rating options
					$GLOBALS['Rating'] = $this->wrapRatingImages($row['revrating']);
					$GLOBALS['RatingQuality'] = $this->wrapRatingImages($row['qualityrating']);
					$GLOBALS['RatingInstall'] = $this->wrapRatingImages($row['installrating']);
					$GLOBALS['RatingValue'] = $this->wrapRatingImages($row['valuerating']);
					$GLOBALS['RatingSupport'] = $this->wrapRatingImages($row['supportrating']);
					$GLOBALS['RatingDelivery'] = $this->wrapRatingImages($row['deliveryrating']);
					
					if ($row['revfromname'] != "") {
						$GLOBALS['PostedBy'] = isc_html_escape($row['revfromname']);
					} else {
						$GLOBALS['PostedBy'] = GetLang('NA');
					}

					$GLOBALS['Date'] = CDate($row['revdate']);
					$GLOBALS['PreviewLink'] = sprintf("<a title='%s' href='javascript:PreviewReview(%d)'>%s</a>", GetLang('PreviewReview'), $row['reviewid'], GetLang('Preview'));

					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Reviews)) {
						$GLOBALS['EditLink'] = sprintf("<a title='%s' href='index.php?ToDo=editReview&amp;reviewId=%d'>%s</a>", GetLang('EditReview'), $row['reviewid'], GetLang('Edit'));
					} else {
						$GLOBALS['EditLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
					}

					switch($row['revstatus'])
					{
						case "0":
						{
							$GLOBALS['Status'] = GetLang('Pending');
							break;
						}
						case "1":
						{
							$GLOBALS['Status'] = sprintf("<font color='green'>%s</font>", GetLang('Approved'));
							break;
						}
						case "2":
						{
							$GLOBALS['Status'] = sprintf("<font color='red'>%s</font>", GetLang('Disapproved'));
							break;
						}
					}
					
					$revOrderid = $row['orderid'];
					
					//$orderInformations = $this->GetOrderInformationsByOrderId($revOrderid);
					if(is_numeric($revOrderid) && $revOrderid > 0 && isset($row["ordcustid"])){//viewOrders&orderId
                      $GLOBALS["OrderId"]= "<a href='index.php?ToDo=viewOrders&orderId=".$row["orderid"]."' >".$row["orderid"]."</a>";
	                 }
	                 else 
	                 {
	                 	$GLOBALS["OrderId"]= "unknown";
	                 }
				  

					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("reviews.manage.row");
					$GLOBALS['ReviewGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
					
				 	
				}
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("reviews.manage.grid");
				return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				
			}
		}

		private function ManageReviews($MsgDesc = "", $MsgStatus = "")
		{
			//lguan_20100612: Fetching calendar options
			$from_stamp = 0;
			$to_stamp = 0;
			$calendaInfo = NULL;
			if (isset($_GET['datetype'])) {
				$GLOBALS['CurrentDate'] = $_GET['datetype'];
				$calendaInfo['DateType'] = $GLOBALS['CurrentDate'];
				if(isset($_GET['from'])) {
					$datestamp = strtotime($_GET['from']);
					$calendaInfo['From']['Yr'] = gmdate('Y', $datestamp);
					$calendaInfo['From']['Mth'] = gmdate('m', $datestamp);
					$calendaInfo['From']['Day'] = gmdate('d', $datestamp);print(isc_date('d', $datestamp));
				}
				if(isset($_GET['to'])) {
					$datestamp = strtotime($_GET['to']);
					$calendaInfo['To']['Yr'] = gmdate('Y', $datestamp);
					$calendaInfo['To']['Mth'] = gmdate('m', $datestamp);
					$calendaInfo['To']['Day'] = gmdate('d', $datestamp);
				}
			}
			else if(isset($_GET['Calendar']['DateType'])){
				$GLOBALS['CurrentDate'] = $_GET['Calendar']['DateType'];
				$calendaInfo['DateType'] = $GLOBALS['CurrentDate'];
				if($GLOBALS['CurrentDate'] == 'Custom'){
					if(isset($_GET['Calendar']['From'])) {
						$datestamp = strtotime($_GET['Calendar']['From']);
						$calendaInfo['From']['Yr'] = gmdate('Y', $datestamp);
						$calendaInfo['From']['Mth'] = gmdate('m', $datestamp);
						$calendaInfo['From']['Day'] = gmdate('d', $datestamp);
					}
					if(isset($_GET['Calendar']['To'])) {
						$datestamp = strtotime($_GET['Calendar']['To']);
						$calendaInfo['To']['Yr'] = gmdate('Y', $datestamp);
						$calendaInfo['To']['Mth'] = gmdate('m', $datestamp);
						$calendaInfo['To']['Day'] = gmdate('d', $datestamp);
					}
				}
			}
			else {
				$GLOBALS['CurrentDate'] = "Last30Days";
				$calendaInfo['DateType'] = $GLOBALS['CurrentDate'];
			}
			$cal = $this->CalculateCalendarRestrictions($calendaInfo);
			// Set the global variables for the select boxes
			$from_stamp = $cal['start'];
			$to_stamp = $cal['end'];
			$GLOBALS['CalendarDateTypeOptions'] = $this->_GetCalendarDateTypesAsOptions($GLOBALS['CurrentDate']);
			$GLOBALS['FromStamp'] = $from_stamp;
			$GLOBALS['ToStamp'] = $to_stamp;

			// Fetch any results, place them in the data grid
			$numReviews = 0;
			$GLOBALS['ReviewDataGrid'] = $this->ManageReviewsGrid($numReviews);

			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['ReviewDataGrid'];
				return;
			}

			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			// Do we need to disable the delete button?
			if (!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Delete_Reviews) || $numReviews == 0) {
				$GLOBALS['DisableDelete'] = "DISABLED";
			}

			if (!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Reviews) || $numReviews == 0) {
				$GLOBALS['DisableApproved'] = "DISABLED";
				$GLOBALS['DisableDisapproved'] = "DISABLED";
			}

			$GLOBALS['ReviewIntro'] = GetLang('ManageReviewsIntro');
			
			//wiyin_20100623: set the value of currentTab
			if(isset($_REQUEST['currentTab'])) {
				$GLOBALS['CurrentTab'] = (int)$_REQUEST['currentTab'];
			}
			else {
				$GLOBALS['CurrentTab'] = 0;
			}
			$GLOBALS['HideClearResults'] = "";

			if($numReviews == 0) {
				$GLOBALS['DisplayGrid'] = "none";
				$GLOBALS['HideClearResults'] = "none";
				if(count($_GET) > 1) {
					if ($MsgDesc == "") {
						$GLOBALS['Message'] = MessageBox(GetLang('NoReviews'), MSG_ERROR);
					}
				}
				else {
					$GLOBALS['Message'] = MessageBox(GetLang('NoReviews1'), MSG_SUCCESS);
					//$GLOBALS['DisplaySearch'] = "none";
				}
			}

			//lguan_20100612: Build the filter type list
			$filterByCategory = false;
            if(isset($_GET['catid']) || isset($_GET['subcatid']))
            {
                $filterByCategory = true;
            }  
            $GLOBALS['FiltersList'] = $this->ListFilterTypes($filterByCategory);
            if ($filterByCategory) {
            	$GLOBALS['CategoryFilterVisible'] ="";
            	$GLOBALS['BrandFilterVisible'] ="style='display:none'";
            }
            else {
            	$GLOBALS['CategoryFilterVisible'] ="style='display:none'";
            	$GLOBALS['BrandFilterVisible'] ="";
            }

            $GLOBALS['ListBrands'] = $this->ListBrands();
            $GLOBALS['SeriesList'] = $this->FilterSeries();
			//lguan_20100612: Render the category list
			$GLOBALS['CategoriesList'] = $this->ListRootCategories();
			$GLOBALS['SubCategoriesList'] = $this->ListSubCategories();

			//lguan_20100612: Showing date range seletion for product reviews
			$GLOBALS['FromDatePicker'] = $this->getDatePickerHtml("fromPicker", "Calendar[From]", isc_date('m/d/Y', $from_stamp));
			$GLOBALS['ToDatePicker'] = $this->getDatePickerHtml("toPicker", "Calendar[To]", isc_date('m/d/Y', $to_stamp));

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("reviews.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		private function _GetReviewList(&$Query, $Start, $SortField, $SortOrder, &$NumReviews)
		{
			// Return an array containing details about reviews.
			// Takes into account search values too.

			// PostgreSQL is case sensitive for likes, so all matches are done in lower case
			$Query = trim(isc_strtolower($Query));

			$query = "
				SELECT r.*, p.prodname,o.ordcustid
				FROM [|PREFIX|]reviews r
				INNER JOIN [|PREFIX|]products p ON (p.productid=r.revproductid)
				left join [|PREFIX|]orders o on (r.orderid = o.orderid)
			";
			$countQuery = "
				SELECT COUNT(reviewid)
				FROM [|PREFIX|]reviews r
				INNER JOIN [|PREFIX|]products p ON (p.productid=r.revproductid)
			";

			$queryWhere = ' WHERE 1=1 ';

            //Added by Simha
            if(isset($_GET['brandid']) && $_GET['brandid'] != 0) {
                $queryWhere .= " AND prodbrandid='".trim($_GET['brandid'])."'";
            }
            if(isset($_GET['seriesid']) && $_GET['seriesid'] != 0) {
                $queryWhere .= " AND brandseriesid='".trim($_GET['seriesid'])."'";
            }    
            //Added by Simha Ends
            
            //lguan_20100612: Category support in product rating, consider the category selection in filter
            if (isset($_GET['catid']) || isset($_GET['subcatid'])) {
            	$filterCategory = (isset($_GET['subcatid']) && ($_GET['subcatid']!=0))
            						? $_GET['subcatid']
            						: $_GET['catid'];
            	if ($filterCategory != 0) {
	            	// Get all sub categories
	            	$catquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT categoryid FROM [|PREFIX|]categories where categoryid=".$filterCategory." OR catparentid=".$filterCategory);
            		$catlistid = array();
                    while($catrow = $GLOBALS['ISC_CLASS_DB']->Fetch($catquery)) {
                        $catlistid[] = $catrow['categoryid'];
                    }
                   
					$query .= "INNER JOIN [|PREFIX|]categoryassociations c ON c.productid=p.productid";
					$countQuery .= "INNER JOIN [|PREFIX|]categoryassociations c ON c.productid=p.productid";
	            	$queryWhere .= " AND c.categoryid IN (".implode(",",$catlistid).")";
            	}
            }
            
            //lguan_20100615: Append the limitation for from and to
			if(isset($GLOBALS['FromStamp']) && is_numeric($GLOBALS['FromStamp'])) {
				$timestamp = $GLOBALS['FromStamp'];
            	$queryWhere .= " AND r.revdate>=$timestamp";
            }
            if (isset($GLOBALS['ToStamp']) && is_numeric($GLOBALS['ToStamp'])) {
            	$timestamp = $GLOBALS['ToStamp'];
            	$queryWhere .= " AND r.revdate<=$timestamp";
            }
            
            //wiyin_20100628: add query condition by revstatus and category
            if (isset($GLOBALS['reviewStatus']) && is_numeric($GLOBALS['reviewStatus'])) {
            	$reviewStatus = $GLOBALS['reviewStatus'];
            	$queryWhere .= " AND r.revstatus=$reviewStatus";
            }
            if (isset($GLOBALS['CateList'])) {
            	$cateArr = $GLOBALS['CateList'];
            	$query .= "INNER JOIN [|PREFIX|]categoryassociations c ON c.productid=p.productid";
				$countQuery .= "INNER JOIN [|PREFIX|]categoryassociations c ON c.productid=p.productid";
            	$queryWhere .= sprintf(" AND c.categoryid in (%s)", implode(",", $cateArr));
            }
            
			if($Query != '') {
				if(isset($_REQUEST['isAdvanced']) && $_REQUEST['isAdvanced'] == 1){
					$queryWhere .= " AND (prodname like '%".$Query."%' OR revtitle like '%".$Query."%')";
				}else{
					$queryWhere .= " AND prodname like '%".$Query."%'";
				}
			}

			// Only fetch product reviews which belong to the current vendor
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$queryWhere .= " AND prodvendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
			}

			$query .= $queryWhere;
			$countQuery .= $queryWhere;

			$result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
			$NumReviews = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

			$query .= " ORDER BY ".$SortField." ".$SortOrder;

			// Add the limit
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($Start, ISC_REVIEWS_PER_PAGE);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			return $result;
		}
		
		private function GetOrderInformationsByOrderId($orderid =0)
		{
			if(empty($orderid) || !is_numeric($orderid))
			{
				return array();
			}
			$sql = "SELECT distinct o.orderid, o.ordcustid
					from [|PREFIX|]orders o 
					WHERE o.orderid='".$orderid."'";
			
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($sql);
			
			$arr = array();
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2)) {
				$arr[] = array(
					"orderid"=>$row["orderid"],
					"customerid"=> $row["ordcustid"]
				);
			}
			return  $arr;
			
		}
        
        private function LoadSeriesList()    {
              echo $FilteredSeriesList = $this->FilterSeries();
        }
        
        /**
         * lguan_20100612: Load categories list into html echo string
         */
        private function loadSubCategoriesList() {
        	echo $this->ListSubCategories();
        }
        
        private function ListBrands() {   
            
            if(!isset($_GET['brandid']))
            {
                $selectedBrands = array();
            }  
            else    {
                $selectedBrands = array(trim($_GET['brandid']));
            }
                                 
            $GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS');    
            $GLOBALS['BrandsList']  = '<select size="1" name="brandlist" onchange="getSeries();"  id="brandlist" class="Field200">';
            $GLOBALS['BrandsList'] .= "<option value='0'>All Brands</option>";
            $GLOBALS['BrandsList'] .= $GLOBALS["ISC_CLASS_ADMIN_BRANDS"]->GetBrandOptions($selectedBrands, "<option %s value='%d'>%s</option>", 'selected="selected"', " ", false);
            $GLOBALS['BrandsList'] .= '</select>';
            
            return $GLOBALS['BrandsList'];

        }
                
        private function FilterSeries() {     
            //$brands = explode(',', $_GET['brandids']); 
            $brands = array();
            
            if(isset($_GET['brandid']))    {
                $brands[] = $_GET['brandid'];
            }                  
            if(!isset($_GET['seriesid']))
            {
                $selectedSeries = array();
            }  
            else    {
                $selectedSeries = array(trim($_GET['seriesid']));
            }
                                                
            $GLOBALS['ISC_CLASS_ADMIN_BRANDS'] = GetClass('ISC_ADMIN_BRANDS');
            $GLOBALS['FilteredSeriesList']  = '<select size="1" name="serieslist" id="serieslist" onchange="FilterReviews();" class="Field200">';
            $GLOBALS['FilteredSeriesList'] .= "<option value='0'>All Series</option>";
            $GLOBALS['FilteredSeriesList'] .= $GLOBALS["ISC_CLASS_ADMIN_BRANDS"]->GetSeriesOptions($selectedSeries, "<option %s value='%d'>%s</option>", 'selected="selected"', " ", false, $brands);
            $GLOBALS['FilteredSeriesList'] .= '</select>';
            
            return $GLOBALS['FilteredSeriesList'];

        }
        
        /**
         * List all root categories, for support rating by categories
         * 
         * lguan_20100612: Created
         */
        private function ListRootCategories() {   
            
            if(!isset($_GET['catid']))
            {
                $selectedCategory = 0;
            }  
            else    {
                $selectedCategory = $_GET['catid'];
            }
                                 
            $GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');    
            $GLOBALS['CategoriesList']  = '<select size="1" name="categorieslist" onchange="loadSubCategories();"  id="categorieslist" class="Field200">';
            $GLOBALS['CategoriesList'] .= "<option value='0'>All Categories</option>";
            $GLOBALS['CategoriesList'] .= $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetFlatCategories($selectedCategory, "<option %s value='%d'>%s</option>", "selected=\"selected\"", 0);
            $GLOBALS['CategoriesList'] .= '</select>';
            
            return $GLOBALS['CategoriesList'];

        }
        
		/**
		 * Generate sub categories list for selection
		 * Hisotry:
		 * 		lguan_20100612: Creation
		 */
		private function ListSubCategories() {	
			if(!isset($_GET['catid']))
            {
                $selectedCategory = 0;
            }  
            else    {
                $selectedCategory = $_GET['catid'];
            }
			if(!isset($_GET['subcatid']))
            {
                $selectedSubCategory = 0;
            }  
            else    {
                $selectedSubCategory = $_GET['subcatid'];
            }
            
			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
            $GLOBALS['SubCategoriesList']  = '<select name="subcategorieslist" id="subcategorieslist" class="Field200" onchange="FilterReviews();">';
            $GLOBALS['SubCategoriesList'] .= "<option value='0'>All Sub-categories</option>";
            if (isset($selectedCategory) && $selectedCategory!=0) {
            	$GLOBALS['SubCategoriesList'] .= $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetFlatCategories($selectedSubCategory, "<option %s value='%d'>%s</option>", "selected=\"selected\"", $selectedCategory);
            }
            $GLOBALS['SubCategoriesList'] .= '</select>';		
			return $GLOBALS['SubCategoriesList'];
		}
	
		/**
		 * Create html list for filter types
		 */
        private function ListFilterTypes($filterByCategory) {   
            $GLOBALS['FiltersList']  = '<select size="1" name="filtertypelist" onchange="switchFilter();"  id="filtertypelist" class="Field100">';
            $GLOBALS['FiltersList'] .= sprintf("<option value='0' %s>By Brand</option>", $filterByCategory?"":"selected");
            $GLOBALS['FiltersList'] .= sprintf("<option value='1' %s>By Category</option>", $filterByCategory?"selected":"");
            $GLOBALS['FiltersList'] .= '</select>';
            
            return $GLOBALS['FiltersList'];

        }
        
        /**
         * Wrap up rating values into a series of star images, return htmls contained the images
         * 
         * lguan_20100612: Created for showing extra ratings all over the functions
         */
        protected function wrapRatingImages($ratedValue) {
        	/*$ratedValue = round($ratedValue);
        	$ratingHtml = '';
        	$ratingText = sprintf(GetLang('ReviewRated'), $ratedValue);
        	
			for ($r = 0; $r < $ratedValue; $r++) {
				$ratingHtml .= sprintf("<img title='%s' width='13' height='12' src='images/rating_on.gif'>", $ratingText);
			}

			for ($r = $ratedValue; $r < 5; $r++) {
				$ratingHtml .= sprintf("<img title='%s' width='13' height='12' src='images/rating_off.gif'>", $ratingText);
			}*/
        	$ratedValue = $this->getRoundValue($ratedValue);
        	$ratingText = sprintf(GetLang('ReviewRated'), $ratedValue);
        	$ratingHtml = sprintf("<img title='%s'  src='images/IcoRating%s.gif'>", $ratingText,$ratedValue);
			
			return $ratingHtml;
        }
        
        //process num,return int,int+0.5.
        // just show the right rating images.
        private function getRoundValue($num)
        {
        	$i = floor($num);
        	$r = $num-$i;
        	if($r <0.3)
        	{
        		return $i;
        	}
        	else if($r >0.7)
        	{
        		return round($num);
        	}
        	else 
        	{
        		return $i + 0.5;
        	}
        }
	        	
		/**
		*	Return a fromdate and todate between which to show stats
		*/
		protected function CalculateCalendarRestrictions($calendarinfo=array()) {
	
			$rightnow = time();
			$today = isc_gmmktime(0, 0, 0, isc_date("m"), isc_date("d"), isc_date("Y"));
			$yesterday = isc_gmmktime(0, 0, 0, isc_date("m"), isc_date("d")-1, isc_date("Y"));
			$startdate = 0;
			$enddate = 0;
	
			if(isset($calendarinfo['DateType'])) {
				switch(isc_strtolower($calendarinfo['DateType'])) {
					case "today": {
						$startdate = $today;
						$enddate = $rightnow;
						break;
					}
					case "yesterday": {
						$startdate = $yesterday;
						$enddate = $today-1;
						break;
					}
					case "last24hours": {
						$startdate = $rightnow - 86400;
						$enddate = $rightnow;
						break;
					}
					case "last7days": {
						$startdate = isc_gmmktime(0, 0, 0, isc_date("m"), isc_date("d") - 7, isc_date("Y"));
						$enddate = $rightnow;
						break;
					}
					case "last30days": {
						$startdate = isc_gmmktime(0, 0, 0, isc_date("m"), isc_date("d")-30, isc_date("Y"));
						$enddate = $rightnow;
						break;
					}
					case "thismonth": {
						$startdate = isc_gmmktime(0, 0, 0, isc_date("m"), 1, isc_date("Y"));
						$enddate = $rightnow;
						break;
					}
					case "lastmonth": {
						$startdate = isc_gmmktime(0, 0, 0, isc_date("m")-1, 1, isc_date("Y"));
						$enddate = isc_gmmktime(0, 0, 0, isc_date("m"), 1, isc_date("Y"));
						break;
					}
					case "alltime": {
						$startdate = 0;
						$enddate = $rightnow;
						break;
					}
					case "custom": {
						$startdate = isc_gmmktime(0, 0, 0, $calendarinfo['From']['Mth'], $calendarinfo['From']['Day'], $calendarinfo['From']['Yr']);
						$enddate = isc_gmmktime(23, 59, 59, $calendarinfo['To']['Mth'], ($calendarinfo['To']['Day']), $calendarinfo['To']['Yr']);
						break;
					}
				}
			}
			else {
				// Default to last 30 days
				$startdate = isc_gmmktime(0, 0, 0, isc_date("m"), isc_date("d")-30, isc_date("Y"));
				$enddate = $rightnow;
			}

			return array("start" => $startdate,
				"end" => $enddate
				);
		}
		
		/**
			*	Get a list of date types as option tags
			*/
		protected function _GetCalendarDateTypesAsOptions($Selected = "")
		{
	
			$output = "";
			$date_types = array("Today" => GetLang('Today'),
				"Yesterday" => GetLang('Yesterday'),
				"Last24Hours" => GetLang('Last24Hours'),
				"Last7Days" => GetLang('Last7Days'),
				"Last30Days" => GetLang('Last30Days'),
				"ThisMonth" => GetLang('ThisMonth'),
				"AllTime" => GetLang('AllTime'),
				"Custom" => GetLang('Custom')
				);
	
			foreach($date_types as $val=>$text) {
				if($val == $Selected) {
					$sel = 'selected="selected"';
				}
				else {
					$sel = "";
				}
	
				$output .= sprintf("<option value='%s' %s>%s</option>", $val, $sel, $text);
			}
	
			return $output;
		}
			
		/**
		 * Generate HTML snippets for date picker
		 * @param unknown_type $elementId
		 * @param unknown_type $currentValue
		 */
        private function getDatePickerHtml($elementId, $elementName, $currentValue) {
        	return "<input type='text' id='$elementId' name='$elementName' readonly='true' class='datepicker' value='$currentValue'>";
        }
	}
?>