<?php

    require_once(ISC_BASE_PATH . "/lib/discountcalcs.php");                               // Added by Simha for onsale addition
    
	CLASS ISC_ABSEARCHPAGE_PANEL extends PANEL
	{
		public $searchterms; //assigning search terms

		public function SetPanelSettings()
		{

			$params = $GLOBALS['ISC_CLASS_ABTESTING']-> _searchterms;
			$this->searchterms = $params;

			if($GLOBALS['pagetype'] == 1)
			{
				return;
			}
			if( $GLOBALS['pagetype'] == 2 && isset($GLOBALS['pagecontent']) && $GLOBALS['pagecontent'] == 1)
			{
				$this->YMMSelectors($params);
				$GLOBALS['SearchResults'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AbSubCategoryListingMain");
				return;
			}
			if($GLOBALS['ISC_CLASS_ABTESTING']->GetNumResults() == 0)
			{
				$this->YMMSelectors($params);
				$GLOBALS['SearchResults'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AbSubCategoryListingMain");
				return;				
			}


			$count = 0;
			$output = "";
			
			/* Checking the search string. If it is used in any search, will be retained. else it will not be retained - starts */
			if( isset($this->searchterms['search']) )
			{
				$search_str	=	trim(str_ireplace($this->searchterms['search_string'] ,"", $this->searchterms['search']));
				if($search_str == '')
				{
					unset($this->searchterms['search'],$params['search']);
				}
				else
				{
					$this->searchterms['search'] = $params['search'] = $search_str;
				}
			}

			$path = GetConfig('ShopPath');

			/* the below mmy links are passed to the breadcrumbs */
            $mmy_links = "";
            
			/*---------- This below section is for generating search phrase----------*/
            $GLOBALS['Category'] = "";
            $GLOBALS['MMY'] = "";
            $GLOBALS['PQ'] = "";
            $GLOBALS['VQ'] = "";
            $GLOBALS['SearchPhrase'] = "";
			$ext_links = ""; // this variable is passed to the product detail page
            $seo_delim = "&";
            if($GLOBALS['EnableSEOUrls'] == 1)
            $seo_delim = "/"; 

            if(isset($GLOBALS['ISC_SRCH_CATG_NAME']))
            $GLOBALS['Category'] .=  $GLOBALS['ISC_SRCH_CATG_NAME'];
            
			if(isset($params['year'])) {
            $GLOBALS['MMY'] .=  $params['year']."<br>";
			$ext_links .= $seo_delim."year=".$params['year'];
			}
            
			if(isset($params['make'])) {
            $GLOBALS['MMY'] .=  strtoupper($params['make'])."<br>";
			$ext_links .= $seo_delim."make=".MakeURLSafe($params['make']); 
			}
			
            if(isset($params['model']) && ( !isset($params['model_flag']) || $params['model_flag'] == 1 ) ) {
			$GLOBALS['MMY'] .= strtoupper($params['model'])."<br>";
			$ext_links .= $seo_delim."model=".MakeURLSafe($params['model']); 
			} 
			/*else if(isset($params['model']))
            $ext_links .= $seo_delim."model=".$params['model'];*/

			/* this condition has been added seperately here to show submodel at last */
            if(isset($params['submodel'])) {
            $GLOBALS['MMY'] .= MakeURLSafe($params['submodel'])."<br>";                    
            }
            
			/*if(isset($params['year'])) {
            $ext_links .= $seo_delim."year=".$params['year'];                
            }*/

			if(isset($params['dynfilters']) && !empty($params['dynfilters'])) {
                foreach($params['dynfilters'] as $key => $value) {
                    if(eregi('vq',$key)) {
                      $key = str_ireplace('vq','',$key);  
                      $GLOBALS['VQ'] .=  ucfirst($key).": $value<br>"; 
                    } else if(eregi('pq',$key)) {
                      $key = str_ireplace('pq','',$key);
                      $GLOBALS['PQ'] .=  ucfirst($key).": $value<br>";     
                    }
                }
            }

			$filter_var = array('vq','pq');

			/* this below patch is used for getting description of the category. Here currently the selected category id will be last one in the $params['srch_category'] array. if input['category'] is used then it will be the first one */

			if(!empty($params['srch_category'])) 
			{
				if(isset($params['category']))
					$selected_catg = $params['srch_category'][0];
				else
					$selected_catg = end($params['srch_category']);
				//wirror_20100806: add selected files like pagecontenttype and customcontentid;
				$catg_desc_qry = "select pagecontenttype, customcontentid, catdesc , categoryfooter  from [|PREFIX|]categories where categoryid = ".$selected_catg;
				$catg_desc_res = $GLOBALS['ISC_CLASS_DB']->Query($catg_desc_qry);
				if( $GLOBALS['ISC_CLASS_DB']->CountResult($catg_desc_res) > 0)
					$catg_desc_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($catg_desc_res);
				
				
				/* this below patch is used to show the display name for the qualifiers from the qualifier association table */
				$map_names = array();
				$display_names = array();
				$filter_names = "select qid , column_name , display_names from [|PREFIX|]qualifier_names where column_name regexp '^(pq|vq)'";
				$filter_result = $GLOBALS['ISC_CLASS_DB']->Query($filter_names);
				while($filter_row = $GLOBALS['ISC_CLASS_DB']->Fetch($filter_result)) {
					$map_names[$filter_row['qid']] = $filter_row['column_name'];
					$display_names[$filter_row['qid']] = $filter_row['display_names'];
				}
				$this->GetAssocDetails($selected_catg, $OwnAssoc, $ParentAssoc, $OwnValue, $ParentValue);       
			}

			if(isset($params['brand']))
			{
				$brand_desc_arr = array();
				$brand_desc_qry = "select branddescription , brandfooter from [|PREFIX|]brands where brandname = '".$params['brand']."'";
				$brand_desc_res = $GLOBALS['ISC_CLASS_DB']->Query($brand_desc_qry);
				if( $GLOBALS['ISC_CLASS_DB']->CountResult($brand_desc_res) > 0)
					$brand_desc_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($brand_desc_res);
			}

			// for breadcrumbs
            $this->_BuildBreadCrumbs();

			/* the below line has been commented as client told to remove it */
			//$GLOBALS['SearchPhrase'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SearchPhrase");     
            if($GLOBALS['ISC_CLASS_ABTESTING']->GetNumResults() > 30 ) {
				$msg_qry = "select value from [|PREFIX|]display where messageid = 1";
				$msg_res = $GLOBALS['ISC_CLASS_DB']->Query($msg_qry); 
				$msg_row = $GLOBALS['ISC_CLASS_DB']->FetchOne($msg_res);
				$GLOBALS['SearchPhrase'] = $msg_row;
				//$GLOBALS['SearchPhrase'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SearchPhrase");
			}
            
            /*if(!empty($params['dynfilters']))
            $GLOBALS['SearchPhrase'] .= " ".implode(" ",$params['dynfilters']);
            /*---------- Ending section for generating search phrase----------*/
			$vq_column_title = "";
			$GLOBALS['SearchResultList'] = "";
			if($GLOBALS['ISC_CLASS_ABTESTING']->GetNumResults() > 0) {

				$brand_rating = 0;
				$category_rating = 0;
				if($GLOBALS['results_page_flag'] == 1)
				{
					$brand_rating_qry = "select avg(revrating) as rating from [|PREFIX|]reviews r left join [|PREFIX|]products p on r.revproductid = p.productid left join [|PREFIX|]brands b on p.prodbrandid = b.brandid  where r.revstatus = 1 and b.brandname = '".$params['brand']."'";
					$brand_rating_res = $GLOBALS['ISC_CLASS_DB']->Query($brand_rating_qry);
					$brand_rating_arr = $GLOBALS['ISC_CLASS_DB']->FetchOne($brand_rating_res);
					if( isset($brand_rating_arr['rating']) )
					{
						$brand_rating = (int)$brand_rating_arr['rating'];
					}
				}
				else if ($GLOBALS['results_page_flag'] == 0 && isset($selected_catg)) {
					// 3rdAug2010: added the condition "isset($selected_catg)" as no need to show rating when only YMM is selected
					// lguan_20100612: Category page mode, calculate the rating
                    $catquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT categoryid FROM [|PREFIX|]categories where catparentid = $selected_catg");
                    $catlistid = array();
                    while($catrow = $GLOBALS['ISC_CLASS_DB']->Fetch($catquery)) {
                        $catlistid[] = $catrow['categoryid'];
                    }	
                    $catcountlist = implode(",",$catlistid);
					//lguan_20100612: Changed following codes to get product rating for categories
                    if(count($catlistid) > 0){
                    	$catcountlist = $selected_catg.",".$catcountlist;                         
                    }
                    $cat_rating_res = $GLOBALS['ISC_CLASS_DB']->Query("SELECT floor(SUM(p.prodratingtotal)/SUM(p.prodnumratings))AS prodavgrating FROM [|PREFIX|]categoryassociations c INNER JOIN [|PREFIX|]products p on c.productid=p.productid where c.categoryid IN ($catcountlist)");
                    $cat_rating_arr = $GLOBALS['ISC_CLASS_DB']->FetchOne($cat_rating_res);
                    if (isset($cat_rating_arr['prodavgrating'])) {
                    	$category_rating = (int) $cat_rating_arr['prodavgrating'];
                    }
				}

				/* displaying the dropdowns for YMM */
				if( !isset($params['make']) || !isset($params['year']) || !isset($params['model']) || ( isset($params['model_flag']) && $params['model_flag'] == 0 ) )
				{
					$this->YMMSelectors($params);
				}

				// We have at least one result, let's show it to the world!
				$GLOBALS['HideNoResults'] = "none";

				// Only show the "compare" option if there are 2 or more products on this page
				if(GetConfig('EnableProductComparisons') == 0 || $GLOBALS['ISC_CLASS_DB']->CountResult($GLOBALS['SearchResults']) < 2) {
					$GLOBALS['HideCompareItems'] = "none";

				}

				if(GetConfig('EnableProductReviews') == 0) {
					$GLOBALS['HideProductRating'] = "display: none";
				}

				$GLOBALS['AlternateClass'] = '';

				$counter = 1;
				$CurCatId = 0;

				$mmy_links = $this->GetYMMLinks($params);
				$mmy_links .= $this->GetOtherLinks($params);

				//wirror_code_mark_begin
				//wirror_20100809: record the searched productids
				$searchedProductIds = array();
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($GLOBALS['SearchResults'])) {

					/* Added by Simha to check inf prodcucts comes from different categories*/
					 if(empty($params['srch_category']) || !isset($params['srch_category']))    {   
						 if($CurCatId != $row['categoryid'])    
						 {
							 $CurCatId = $row['categoryid'];
							 $map_names = array();
							 $display_names = array();
							 $filter_names = "SELECT DISTINCT qn.qid, qn.column_name, qn.display_names from 
                                                [|PREFIX|]qualifier_names qn
                                                LEFT JOIN [|PREFIX|]qualifier_associations qa ON qa.qualifierid = qn.qid
                                                WHERE (qa.categoryid = '$CurCatId') 
                                                AND qn.column_name regexp '^(pq|vq)'";
                                                // || qa.categoryid IN (SELECT catparentid FROM isc_categories WHERE categoryid = '$CurCatId')
                                                
							 $filter_result = $GLOBALS['ISC_CLASS_DB']->Query($filter_names);
							 while($filter_row = $GLOBALS['ISC_CLASS_DB']->Fetch($filter_result)) {
								 $map_names[$filter_row['qid']] = $filter_row['column_name'];                                
								 $display_names[$filter_row['qid']] = $filter_row['display_names'];
							 }
							 $this->GetAssocDetails($CurCatId, $OwnAssoc, $ParentAssoc, $OwnValue, $ParentValue);
						}
					}
					/* Added by Simha Ends */

					$GLOBALS['SearchTrackClass'] = "TrackLink";
					$imagefile = ""; 

					if($GLOBALS['AlternateClass'] == 'Odd') {
						$GLOBALS['AlternateClass'] = 'Even';
					}
					else {
						$GLOBALS['AlternateClass'] = 'Odd';
					}

					$qry_string = $_SERVER['QUERY_STRING'];
					if(isset($_GET['page'])) {
						$page = "&page=".$_GET['page'];
						$qry_string = str_ireplace($page,'',$qry_string);
					}

					if ($GLOBALS['EnableSEOUrls'] == 1) {

						if(isset($_GET['search_key']))
							$qry_string = str_ireplace('&search_key='.$_GET['search_key'],'',$qry_string);

						if(isset($params['search_query']) && !strstr($qry_string,'search_query='))
							$qry_string .= "search_query=".MakeURLSafe($params['search_query']);
						if(isset($params['make']) && !strstr($qry_string,'make='))
							$qry_string .= "&make=".MakeURLSafe($params['make']);
						if(isset($params['model']) && !strstr($qry_string,'model='))
							$qry_string .= "&model=".MakeURLSafe($params['model']);
						if(isset($params['year']) && !strstr($qry_string,'year='))
							$qry_string .= "&year=".MakeURLSafe($params['year']);
						if(isset($params['make']) && !strstr($qry_string,'make='))
							$qry_string .= "&make=".MakeURLSafe($params['make']);
						if(isset($params['model_flag']) && !strstr($qry_string,'model_flag='))
							$qry_string .= "&model_flag=".MakeURLSafe($params['model_flag']);
						if(isset($params['submodel']) && !strstr($qry_string,'submodel='))
							$qry_string .= "&submodel=".MakeURLSafe($params['submodel']);
					}

					if( $GLOBALS['results_page_flag'] == 0 && !isset($params['srch_category']) )
					{
						break;
					}

					if( $GLOBALS['pagetype'] == 3 )  // this is for product listing page 
                    {
							//wirror_mark_condition1
							/*if( isset($params['srch_category']) )  {
								$GLOBALS['CatgDescandBrandImage'] = isset($catg_desc_arr['catdesc']) ? $catg_desc_arr['catdesc'] : ''; // description will be added here to show it at the top of product listing page.
							}*/

							/*if(isset($params['category']) || ( !isset($params['subcategory']) && isset($params['series']) ))
							{
								$GLOBALS['CatgDescandBrandImage'] = $row['seriesdescription'];
								//$GLOBALS['CatgBrandSeriesFooter'] = $row['seriesfooter'];
								$GLOBALS['CatgBrandSeriesFooter'] = "";

								if( ( isset($params['category']) || isset($params['subcategory']) ) && $GLOBALS['CatgDescandBrandImage'] == "" )
								{
									$GLOBALS['CatgDescandBrandImage'] = isset($catg_desc_arr['catdesc']) ? $catg_desc_arr['catdesc'] : '';
									//$GLOBALS['CatgBrandSeriesFooter'] = isset($catg_desc_arr['categoryfooter']) ? $catg_desc_arr['categoryfooter'] : '';
									$GLOBALS['CatgBrandSeriesFooter'] = "";
								}

							}
							else if(isset($params['srch_category']))
							{
								$GLOBALS['CatgDescandBrandImage'] = isset($catg_desc_arr['catdesc']) ? $catg_desc_arr['catdesc'] : '';	
								$GLOBALS['CatgBrandSeriesFooter'] = isset($catg_desc_arr['categoryfooter']) ? $catg_desc_arr['categoryfooter'] : '';
								if( isset($params['series']) && $row['seriesdescription'] != "" )
								{
									$GLOBALS['CatgDescandBrandImage'] = $row['seriesdescription'];
									//$GLOBALS['CatgBrandSeriesFooter'] = $row['seriesfooter'];
									$GLOBALS['CatgBrandSeriesFooter'] = "";
								}

								if($GLOBALS['CatgDescandBrandImage'] == '' && $GLOBALS['CatgBrandSeriesFooter'] == '' && isset($params['brand']))
								{
									$GLOBALS['CatgDescandBrandImage'] = isset($brand_desc_arr['branddescription']) ? $brand_desc_arr['branddescription'] : '';
									//$GLOBALS['CatgBrandSeriesFooter'] = isset($brand_desc_arr['brandfooter']) ? $brand_desc_arr['brandfooter'] : '';
									$GLOBALS['CatgBrandSeriesFooter'] = "";
								}

							}
							else if(isset($params['brand']))
							{
								$GLOBALS['CatgDescandBrandImage'] = isset($brand_desc_arr['branddescription']) ? $brand_desc_arr['branddescription'] : '';
								$GLOBALS['CatgBrandSeriesFooter'] = isset($brand_desc_arr['brandfooter']) ? $brand_desc_arr['brandfooter'] : '';
							}*/

							/* No need to show footer description when YMM are selected */
							/*if( isset($params['make']) || isset($params['model']) || isset($params['year']) )
							{
								$GLOBALS['CatgBrandSeriesFooter'] = "";
							}*/

							$GLOBALS['ProductCartQuantity'] = '';
							if(isset($GLOBALS['CartQuantity'.$row['productid']])) {
								$GLOBALS['ProductCartQuantity'] = (int)$GLOBALS['CartQuantity'.$row['productid']];
							}

							if($counter%2 == 0)
								$GLOBALS['RowColor'] = 'grayrow';
							else
								$GLOBALS['RowColor'] = 'whiterow';
						
							$counter++;

							$GLOBALS['ProductId'] = (int) $row['productid'];
							$GLOBALS['ProductName'] = isc_html_escape($row['prodname']);
							$GLOBALS['ProductLink'] = ProdLink($row['prodname']);
							$GLOBALS['ProductRating'] = (int)$row['prodavgrating'];
							//$GLOBALS['BrandName'] = $row['brandname']; 

							/* -- The below code is added to display the brand and series logo -- */
							$GLOBALS['BrandName'] = "";
							$brandlogo = realpath(ISC_BASE_PATH.'/product_images/'.$row['brandimagefile']);
							if( $row['brandimagefile'] != '' && file_exists($brandlogo) )
							{
								$GLOBALS['BrandName'] .= "<img src=\"".$GLOBALS['ShopPath']."/product_images/".$row['brandimagefile']."\" class=\"BrandSeriesLogo\" />";
							}
							else
							{
								$GLOBALS['BrandName'] .= $row['brandname'];
							}

							$serieslogo = realpath(ISC_BASE_PATH.'/series_images/'.$row['serieslogoimage']);
							if( $row['serieslogoimage'] != '' && file_exists($serieslogo) )
							{
								$GLOBALS['BrandName'] .= "<br><img src=\"".$GLOBALS['ShopPath']."/series_images/".$row['serieslogoimage']."\" />";
							}
							else
							{
								$GLOBALS['BrandName'] .= "<br>".$row['seriesname'];
							}

							/* --- ends --- */
							$GLOBALS['ProdCode'] = $row['prodcode']; 
							//$GLOBALS['ProdDesc'] = $this->strip_html_tags($row['proddesc']); 
							
							//$GLOBALS['ProdOptions'] = $row['productoption']; 
							$GLOBALS['VehicleOptions'] = "";
							$GLOBALS['ProdOptions'] = "";
							foreach($row as $key => $val) {
								  if($val != "" && $val != "~")  {
																					 
								  
										if(($qualifier_id=array_search($key,$map_names)) !== false)   {    
											
											if(eregi('^vq',$key)) {   
												$val = trim($val, "~");
												$val = preg_split('/[~;]+/', $val);
												$val = array_unique($val);
												$val = array_values($val);
												$val = implode(",", $val);
												/* -- Setting display name for qualifier name -- */ 
												if( isset($OwnAssoc[$qualifier_id])  && $OwnAssoc[$qualifier_id][0]['qname'] != '' )
												  $key = $OwnAssoc[$qualifier_id][0]['qname'];
												else if( isset($ParentAssoc[$qualifier_id])  && $ParentAssoc[$qualifier_id][0]['qname'] != '' )
												  $key = $ParentAssoc[$qualifier_id][0]['qname'];
												else {
													if(isset($display_names[$qualifier_id]) && !empty($display_names[$qualifier_id]))
														$key = $display_names[$qualifier_id];
													else
														$key = ucfirst(str_ireplace($filter_var,"",$key)); 
												}

												/* -- Setting display name for qualifier name ends -- */

												/* -- Setting display name for qualifier value -- */

												if( isset($OwnValue[$qualifier_id]) && ($m = array_search(strtolower($val),$OwnValue[$qualifier_id]))!==false && $OwnAssoc[$qualifier_id][$m]['vname'] != "")
													$val = $OwnAssoc[$qualifier_id][$m]['vname'];
												else if( isset($ParentValue[$qualifier_id]) && (($m = array_search(strtolower($val),$ParentValue[$qualifier_id]))!==false) && $ParentAssoc[$qualifier_id][$m]['vname'] != "")
													$val = $ParentAssoc[$qualifier_id][$m]['vname'];

												/* -- Setting display name for qualifier value ends-- */

												//$GLOBALS['VehicleOptions'] .= "<b>".$key."</b> : ".$val."<br>"; 
												$GLOBALS['VehicleOptions'] .= "<div class='qualifierwrap'><div class='qualifiertitle'>".$key." :</div> ".$val."</div>";
											}
											
											if(eregi('^pq',$key)) {                             
												$val = trim($val, "~");
												$val = preg_split('/[~;]+/', $val);
												$val = array_unique($val);
												$val = array_values($val);
												$val = implode(",", $val);
												/* -- Setting display name for qualifier name -- */

												if( isset($OwnAssoc[$qualifier_id])  && $OwnAssoc[$qualifier_id][0]['qname'] != '' )
												  $key = $OwnAssoc[$qualifier_id][0]['qname'];
												else if( isset($ParentAssoc[$qualifier_id])  && $ParentAssoc[$qualifier_id][0]['qname'] != '' )
												  $key = $ParentAssoc[$qualifier_id][0]['qname'];
												else {
												  if(isset($display_names[$qualifier_id]) && !empty($display_names[$qualifier_id]))
														$key = $display_names[$qualifier_id];
												  else
														$key = ucfirst(str_ireplace($filter_var,"",$key)); 
												}

												/* -- Setting display name for qualifier name ends -- */

												/* -- Setting display name for qualifier value -- */

												if( isset($OwnValue[$qualifier_id]) && ($m = array_search(strtolower($val),$OwnValue[$qualifier_id]))!==false && $OwnAssoc[$qualifier_id][$m]['vname'] != '')                         
												{                                  
													$val = $OwnAssoc[$qualifier_id][$m]['vname'];     
												}
												else if(isset($ParentValue[$qualifier_id]) && (($m = array_search(strtolower($val),$ParentValue[$qualifier_id]))!==false) && $ParentValue[$qualifier_id][$m]['vname'] != '')
												{
													$val = $ParentAssoc[$qualifier_id][$m]['vname'];        
												}

												/* -- Setting display name for qualifier value ends-- */
												
												//$GLOBALS['ProdOptions'] .= "<b>".$key."</b> : ".$val."<br>"; 
												$GLOBALS['ProdOptions'] .= "<div class='qualifierwrap'><div class='qualifiertitle'>".$key." :</div> ".$val."</div>";
											}
									  }
								  }
							}

							if(isset($row['vehicleoption']))
								$GLOBALS['VehicleOptions'] = $row['vehicleoption'];

							if(isset($row['productoption']))
								$GLOBALS['ProdOptions'] = $row['productoption'];

							if( isset($row['catuniversal']) && $row['catuniversal'] == 1 ) // if there are no VQ's and its universal category, need to show the below message
							{
								$GLOBALS['VehicleOptions'] = $GLOBALS['ProductName'];
								if($vq_column_title == "")
									$vq_column_title = "Product Name";
								else if($vq_column_title != "Product Name")
									$vq_column_title = "Product Name / Vehicle";
							}
							else
							{
								if($vq_column_title == "")
									$vq_column_title = "Vehicle Options";
								else if($vq_column_title != "Vehicle Options")
									$vq_column_title = "Product Name / Vehicle";
							}

							if(empty($GLOBALS['ProdOptions']) && empty($GLOBALS['VehicleOptions']))
								$GLOBALS['ProdOptions'] = "&nbsp;";
							if(empty($GLOBALS['VehicleOptions']))
								$GLOBALS['VehicleOptions'] = "&nbsp;";
							
							/*--- the below lines are added for back 2 search link in the product detail page. Also modified line no 56 & 60 --- */
							if($GLOBALS['EnableSEOUrls'] == 1)
							{
								$GLOBALS['ProductLink'] .= "/refer=true".$ext_links;
								if( isset($GLOBALS['SearchId']))
									$GLOBALS['ProductLink'] .= '/SearchLogId/'.$GLOBALS['SearchId'];
							}
							else
							{
								$GLOBALS['ProductLink'] .= "&refer=true".$ext_links;
								if( isset($GLOBALS['SearchId']))
									$GLOBALS['ProductLink'] .= '&SearchLogId='.$GLOBALS['SearchId'];
							}

							### Added by Simha for onsale addition   
							// Determine the price of this product
							//$GLOBALS['ProductPrice'] = CalculateProductPrice_retail($row);
							$GLOBALS['ProductPrice'] = CalculateProductPriceRetail($row);

							$FinalPrice         = $GLOBALS['ProductPrice'];  
                            $SalePrice          = $row['prodsaleprice'];  
							//$DiscountAmount = $FinalPrice;
                            $discounttype = 0;
							$discountname = '';
							if((float)$SalePrice >0 && $SalePrice < $FinalPrice)    {
                                $DiscountPrice = $SalePrice;
                            }
                            else    {   
                                $DiscountPrice = $FinalPrice;
                                $DiscountPrice = CalculateDiscountPrice($FinalPrice, $DiscountPrice, $row['categoryid'], $row['brandseriesid'], $discounttype, $discountname);                
                                /*if($discounttype == 0)    {
                                    $DiscountPrice = $FinalPrice;
                                }*/               
                            }
                            
                            
                            /*
							foreach($DiscountInfo as $DiscountInfoSub)   {  
                                if(isset($DiscountInfoSub['catids']))    {
								    $catids = explode(",", $DiscountInfoSub['catids']); 
								    foreach($catids as $catid) {
									    if($catid == $row['categoryid']) {
										    $DiscountAmount = $FinalPrice * ((int)$DiscountInfoSub['amount']/100); 
										    if ($DiscountAmount < 0) {
											    $DiscountAmount = 0;
										    }                                                                         
										    $DiscountPrice  = $FinalPrice - $DiscountAmount;  
									    } 
								    }  
                                }
							}       
                            */      
                            
							if(isset($DiscountPrice) && $DiscountPrice < $FinalPrice && $discounttype==0)    {     //&& GetConfig('ShowOnSale')
								$GLOBALS['ProductPrice']  = '<strike>'.CurrencyConvertFormatPrice($FinalPrice).'</strike>'; 
								$GLOBALS['ProductPrice'] .= '<br><div class="finalprice">'.CurrencyConvertFormatPrice($DiscountPrice).'</div> '; 
								
								if(strtolower($discountname) == "clearance")
								{
									$GLOBALS['ShowOnSaleImage'] = '<img id="OnSale" src="'.GetConfig('ShopPath').'/templates/default/images/clearance.gif" alt="">';                  
								}
								else
								{
									$GLOBALS['ShowOnSaleImage'] = '<img id="OnSale" src="'.GetConfig('ShopPath').'/templates/default/images/onsale.gif" alt="">';                  
								}
                                if(GetConfig('ShowOnSale'))    {
								    $GLOBALS['ProductPrice'] .= ''.$GLOBALS['ShowOnSaleImage'].'';
                                }
							}
							else    {
								$GLOBALS['ProductPrice']  = '<div class="finalprice">'.CurrencyConvertFormatPrice($FinalPrice).'</div>';
							}
							### Added by Simha Ends
							
							// commented the below line by vikas
							//$GLOBALS['ProductThumb'] = ImageThumb($row['imagefile'], ProdLink($row['prodname']));
							$GLOBALS['ProductThumb'] = ImageThumb($row['imagefile'], $GLOBALS['ProductLink']);

							if (isId($row['prodvariationid']) || trim($row['prodconfigfields'])!='' || $row['prodeventdaterequired'] == 1) {
								//$GLOBALS['ProductURL'] = ProdLink($row['prodname']); // commented by vikas
								$GLOBALS['ProductURL'] = $GLOBALS['ProductLink'];
								$GLOBALS['ProductAddText'] = GetLang('ProductChooseOptionLink');
							} else {
								//$GLOBALS['ProductURL'] = CartLink($row['productid']);
									//$GLOBALS['ProductURL'] = ProdLink($row['prodname']); // commented by vikas
									$GLOBALS['ProductURL'] = $GLOBALS['ProductLink'];

									//blessen
									if (intval($row['prodretailprice']) <= 0 )
									{
										//$GLOBALS['ProductAddText'] = GetLang('ProductAddToCartLink'); // commented by vikas on 15-7-09
										$GLOBALS['ProductAddText'] = "<img src='$path/templates/default/images/view.gif' border=0>";
									}
									else
									{
										//$GLOBALS['ProductAddText'] = GetLang('ProductAddToCartLink1'); // commented by vikas on 15-7-09
										$GLOBALS['ProductAddText'] = "<img src='$path/templates/default/images/view.gif' border=0>";
									}
									//blessen

								// original $GLOBALS['ProductAddText'] = GetLang('ProductAddToCartLink');
							}

							if (CanAddToCart($row) && GetConfig('ShowAddToCartLink')) {
								$GLOBALS['HideActionAdd'] = '';
							} else {
								$GLOBALS['HideActionAdd'] = 'none';
							}

							$GLOBALS['HideProductVendorName'] = 'display: none';
							$GLOBALS['ProductVendor'] = '';
							if(GetConfig('ShowProductVendorNames') && $row['prodvendorid'] > 0) {
								$vendorCache = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('Vendors');
								if(isset($vendorCache[$row['prodvendorid']])) {
									$GLOBALS['ProductVendor'] = '<a href="'.VendorLink($vendorCache[$row['prodvendorid']]).'">'.isc_html_escape($vendorCache[$row['prodvendorid']]['vendorname']).'</a>';
									$GLOBALS['HideProductVendorName'] = '';
								}
							}

							$GLOBALS['CartURL'] = CartLink($row['productid']);
							if( isset($GLOBALS['SearchId']))
									$GLOBALS['CartURL'] .= '&SearchLogId='.$GLOBALS['SearchId'];

							$offer = $this->IsProductMakeanOffer($row['brandseriesid'],$row['brandname'],$row['categoryid']);
							if($offer == 'yes')
								 $GLOBALS['HideOfferButton'] = 'block';
							else 
								 $GLOBALS['HideOfferButton'] = 'none';

							$GLOBALS['SearchResultList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SubCategoryProductsItem");
				
					} 
					else if( $GLOBALS['pagetype'] == 2 ) // subcategory page
					{		//wirror_mark_condition2
							$isDynamicPage = ($catg_desc_arr['pagecontenttype']==0) ? true : false ;

							$mmy_links_modified = $mmy_links;
							if(!isset($GLOBALS['ISC_SRCH_CATG_ID']))
							{
								$parentid = $GLOBALS['categories_all'][$row['categoryid']]['catparentid'];
								if($parentid != 0)
								{
									if(isset($GLOBALS['categories_all'][$parentid])) // if parent catg is not visible
										$mmy_links_modified = $mmy_links;
									else
										$mmy_links_modified = $mmy_links;
								}
								else
								{
									$mmy_links_modified = $mmy_links;
								}
							}

							//Modify 2010/10/19 Ronnie
							$subcatg_link = $this->LeftCatLink($mmy_links_modified, 'subcategory', $row['catname'],$GLOBALS['ISC_SRCH_CATG_NAME']);
							$link = "<a href='".$subcatg_link."'>";

							$tiplink = "<a class='thickbox1' href='".$GLOBALS['ShopPath']."/catgbrand.php?categoryid=".$row['categoryid']."&url=".urlencode($subcatg_link)."'  title=''><img src='$path/templates/default/images/fastlook_red.gif' border=0></a>";

							$imagelink = "<a class='thickbox' href='".$GLOBALS['ShopPath']."/catgbrand.php?categoryid=".$row['categoryid']."&url=".urlencode($subcatg_link)."' title='' onmouseover='createtip(".$row['categoryid'].")' onmouseout='UnTip()'>";

							//$imagelink = "<a href='".$GLOBALS['ShopPath']."/catgbrand.php?categoryid=".$row['categoryid']."&url=$subcatg_link' class='thickbox' title=''>";
							if(isset($row['imagefile']) && !empty($row['imagefile'])) {
                                $images = explode("~",$row['imagefile']);
                                for($j=0;$j<count($images);$j++) {
                                    if(!empty($images[$j])) {

										$imagefile =  "$imagelink<img src='$path/category_images/".$images[$j]."' alt='".$row['catimagealt']."' title='".$row['catimagealt']."'></a>";

										$imagefile .= "<span id='span".$row['categoryid']."' style='display:none'>".$tiplink."</span>";
										break;
                                    }
                                }
                            } else if(empty($row['imagefile']) || empty($imagefile)) {
                                    $imagefile = "$imagelink<img src='$path/templates/default/images/ProductDefault.gif' border=0></a>";

									$imagefile .= "<span id='span".$row['categoryid']."' style='display:none'>".$tiplink."</span>";
							}

							$GLOBALS['LeftImage'] = $imagefile;
							$GLOBALS['ProductsCount'] = "(".$row['totalproducts'].") Products Available";
                                    
                            $row['brandname'] = str_replace('~',' , ',$row['brandname']);
							//$GLOBALS['RelatedBrands'] = $row['brandname'];

							if(!empty($row['seriesname']))
                            $row['brandname'] .= "<br>".$row['seriesname'];
							
							$GLOBALS['CatgSeriesList'] = "";
							if($row['seriesids'] != "") 
							{
								$seriesids = str_ireplace("~",",",$row['seriesids']);
								$seriesids_qry = "select seriesid , brandname , seriesname from isc_brand_series bs left join isc_brands b on bs.brandid = b.brandid where seriesid in (".$seriesids.")";
								$seriesids_res = $GLOBALS['ISC_CLASS_DB']->Query($seriesids_qry);
								if( $GLOBALS['ISC_CLASS_DB']->CountResult($seriesids_res) > 0) {
									while($seriesids_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($seriesids_res))
									{

										if($GLOBALS['CatgSeriesList'] == "")
										{
											$GLOBALS['CatgSeriesList'] .= "<br><a href='javascript:' onclick=\"checkanimate('".$row['categoryid']."')\">View Brands ></a><div id='".$row['categoryid']."' style='display:block'>";
										}
										else
										{	
											$GLOBALS['CatgSeriesList'] .= "<br>";		
										}

										$tooltipscript = "onmouseover='createtip(".$row['categoryid'].$seriesids_arr['seriesid'].")' onmouseout='UnTip()'";

										if(!isset($params['brand'])) {
											if($GLOBALS['EnableSEOUrls'] == 1)
											{
												$series_link = $subcatg_link."/brand/".MakeURLSafe(Strtolower($seriesids_arr['brandname']))."/series/".MakeURLSafe(Strtolower($seriesids_arr['seriesname']));	

												$GLOBALS['CatgSeriesList'] .= "<a href='".$subcatg_link."/brand/".MakeURLSafe(Strtolower($seriesids_arr['brandname']))."/series/".MakeURLSafe(Strtolower($seriesids_arr['seriesname']))."' $tooltipscript>".$seriesids_arr['brandname']." ".$seriesids_arr['seriesname']."</a>";		
											}
											else
											{
												$series_link = $subcatg_link."&brand=".MakeURLSafe(Strtolower($seriesids_arr['brandname']))."&series=".MakeURLSafe(Strtolower($seriesids_arr['seriesname']));	

												$GLOBALS['CatgSeriesList'] .= "<a href='".$subcatg_link."&brand=".MakeURLSafe(Strtolower($seriesids_arr['brandname']))."&series=".MakeURLSafe(Strtolower($seriesids_arr['seriesname']))."' $tooltipscript>".$seriesids_arr['brandname']." ".$seriesids_arr['seriesname']."</a>";		
											}
										}
										else
										{
											if($GLOBALS['EnableSEOUrls'] == 1)
											{
												$series_link =	$subcatg_link."/series/".MakeURLSafe(Strtolower($seriesids_arr['seriesname']));		

												$GLOBALS['CatgSeriesList'] .= "<a href='".$subcatg_link."/series/".MakeURLSafe(Strtolower($seriesids_arr['seriesname']))."' $tooltipscript>".$seriesids_arr['brandname']." ".$seriesids_arr['seriesname']."</a>";		
											}
											else
											{
												$series_link =	$subcatg_link."&series=".MakeURLSafe(Strtolower($seriesids_arr['seriesname']));

												$GLOBALS['CatgSeriesList'] .= "<a href='".$subcatg_link."&series=".MakeURLSafe(Strtolower($seriesids_arr['seriesname']))."' $tooltipscript>".$seriesids_arr['brandname']." ".$seriesids_arr['seriesname']."</a>";				
											}
										}
										
										//wirror20100728: keep the catname consistent with the displayname 
										$GLOBALS['CatgSeriesList'] .= "<span id='span".$row['categoryid'].$seriesids_arr['seriesid']."' style='display:none'><a class='thickbox1'  href='".$GLOBALS['ShopPath']."/catgbrand.php?seriesid=".$seriesids_arr['seriesid']."&catname=".rawurlencode($row['catname'])."&url=".urlencode($series_link)."' class='' ><img src='$path/templates/default/images/fastlook_red.gif' border=0></a></span>";

									}
										$GLOBALS['CatgSeriesList'] .= "</br></div>";
								}
								
							}

							$content = $row['brandname']."<br>";
					
							if(!isset($params['category']) && ( isset($params['srch_category']) || !isset($GLOBALS['BRAND_SERIES_FLAG']) ) ) {
								
								/*$GLOBALS['CatgBrandSeriesFooter'] = isset($catg_desc_arr['categoryfooter']) ? $catg_desc_arr['categoryfooter'] : '';
								if( isset($params['make']) || isset($params['model']) || isset($params['year']) || isset($params['brand']) )
								{
									$GLOBALS['CatgBrandSeriesFooter'] = "";
								}*/
								$content .= "<h3><a href='".$path."/search.php?$qry_string&subcategory=".MakeURLSafe($row['catname'])."'>".$row['catname']."</a></h3>>";
								$GLOBALS['TitleLink'] = "<h2><a href='".$subcatg_link."' onmouseover='createtip(".$row['categoryid'].")' onmouseout='UnTip()'>".$row['catname']."</a></h2>";
							}
							
							/*	copy the code to outer		
							//lguan_20100612: Show overal product rating at category landing page
							if($category_rating != 0)
							{
								$GLOBALS['CatgDescandBrandImage'] .= "<br><h2>Rating : <img width='64' height='12' src='".$GLOBALS['TPL_PATH']."/images/IcoRating$category_rating.gif' alt='' /></h2>";
							}
							*/
							
                            /*$ProdStartPrice = GetStartingPrice($row['categoryid'], $row['prodcalculatedprice']);
                            
							$content .= "Price starting from $".number_format($ProdStartPrice, 2, '.', '')."<br>".$imagefile;*/
                            $GLOBALS['leftsidecontent'] = $content;
							
                            if(number_format($row['prodminprice'], 2 ,'.', '') < number_format($row['prodmaxprice'], 2 ,'.', ''))     {      
                                $GLOBALS['PriceRange'] = "Price range from $".number_format($row['prodminprice'], 2, '.', '')." to $".number_format($row['prodmaxprice'], 2, '.', '');
                            }
                            else    {
                                $GLOBALS['PriceRange'] = "Available at $".number_format($row['prodminprice'], 2, '.', '');    
                            }
                           
                            //lguan_20100612: Show product ratings in categories/sub-categories page
                            $GLOBALS['Rating'] = isset($row['prodavgrating'])?$row['prodavgrating']:0;
							$GLOBALS['RatingVisible'] = $GLOBALS['Rating']==0 ? 'display:none':'';
                            
                            $content = "<img src='$path/templates/default/images/free-shipping2.gif'><br>".strip_tags($row['proddesc'])."<br>".$row['prodwarranty'];
                            $GLOBALS['rightsidecontent'] = $content;

							$GLOBALS['ShippingImage'] = "<img src='$path/templates/default/images/free-shipping2.gif'>";
							$GLOBALS['ProductWarranty'] = "<h3>".$row['prodwarranty']."</h3>";

							$GLOBALS['ViewDetailsImage'] = "<a href='$path/catgbrand.php?categoryid=".$row['categoryid']."&url=".urlencode($subcatg_link)."' class='thickbox'><img src='$path/templates/default/images/fastlook_red.gif'></a> ";
                            
                            $content = "$link<img src='$path/templates/default/images/viewproducts.gif'></a>";
							$GLOBALS['ViewDetailsImage'] .= $content;
                            
							$discountname = '';
                            if(IsDiscountAvailable('category', $row['categoryid'], $discountname))    {
								if(strtolower($discountname) == "clearance")
								{
									$GLOBALS['ViewDetailsImage'] .= '<img id="OnSale" src="'.GetConfig('ShopPath').'/templates/default/images/clearance.gif" alt="">';                  
								}
								else
								{
									$GLOBALS['ViewDetailsImage'] .= '<img id="OnSale" src="'.GetConfig('ShopPath').'/templates/default/images/onsale.gif" alt="">'; 
								}
                            } 
                            
                            if($this->IsMakeAnOffer('category', $row['categoryid'])=='yes') 
                            {    
                                $GLOBALS['ViewDetailsImage'] .= "<h3>Qualifies for Make an Offer!</h3>";
                            }

							$GLOBALS['RelatedBrands'] = $row['featurepoints'];
                            
                            $GLOBALS['lowersidecontent'] = $content;

								
								$GLOBALS['SearchResultList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SubCategoryListing");
								


					}
							
				}
				///wirror_code_mark_end

				$get_variables = $_GET;
				$sort_qry = "$path/search.php?search_query=".urlencode($params['search_query']);
				unset($get_variables['orderby'],$get_variables['sort'],$get_variables['search_query'],$get_variables['sortby']);
				$i=0;
				foreach($get_variables as $key => $value)
                {
                    $sort_qry .= "&$key=$value";
                }
                if(isset($_REQUEST['sortby']) && $_REQUEST['sortby'] == 'desc') {
                    $sort = "asc ";
					$img = "&nbsp;<img src='$path/templates/default/images/ArrowDown.gif' border=0>";
				} else {
                    $sort = "desc ";
					$img = "&nbsp;<img src='$path/templates/default/images/ArrowUp.gif' border=0>";
				}
				
				//wirror_code_mark_begin
				//$GLOBALS['SearchResults'] = $GLOBALS['SearchResultList']; // commented by vikas
				if(isset($params['partnumber']) || $params['flag_srch_category'] == 1 || ( isset($params['flag_srch_category']) && isset($GLOBALS['BRAND_SERIES_FLAG']) && $GLOBALS['BRAND_SERIES_FLAG'] == 1 )) {

					$path = $path."/a-b-testing";

					if ($GLOBALS['EnableSEOUrls'] == 1)
					{
						$GLOBALS['ProductBrand'] = "<a href='$path$mmy_links/orderby/brandname/sortby/$sort'>Brand / Series</a>";    

						$GLOBALS['ProductPartNumber'] = "<a href='$path$mmy_links/orderby/prodcode/sortby/$sort'>Image / Part#</a>";

						$GLOBALS['ProductDetails'] = "<a href='$path$mmy_links/orderby/prodfinalprice/sortby/$sort'>Price</a>";
					}
					else
					{
						$GLOBALS['ProductBrand'] = "<a href='$path/search.php?search_query=$mmy_links&orderby=brandname&sortby=$sort'>Brand / Series</a>";    

						$GLOBALS['ProductPartNumber'] = "<a href='$path/search.php?search_query=$mmy_links&orderby=prodcode&sortby=$sort'>Image / Part#</a>";

						$GLOBALS['ProductDetails'] = "<a href='$path/search.php?search_query=$mmy_links&orderby=prodfinalprice&sortby=$sort'>Price</a>";
					}

						if(isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'brandname')
						$GLOBALS['ProductBrand'] .= $img;
						
						$GLOBALS['ProductVQ'] = $vq_column_title;    
						/*if(isset($_GET['orderby']) && $_GET['orderby'] == 'brandname')
						$GLOBALS['Product_VQ'] .= $img;*/ 
						
						if(isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'prodcode')
						$GLOBALS['ProductPartNumber'] .= $img;
							
						$GLOBALS['ProductPQ'] = "Product Options";    
						/*if(isset($_GET['orderby']) && $_GET['orderby'] == 'productoption')
						$GLOBALS['SearchResults'] .= $img;*/  
						
						if(isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'prodcalculatedprice')
						$GLOBALS['ProductPrice'] .= $img;
						
						if(isset($_REQUEST['orderby']) && $_REQUEST['orderby'] == 'prodfinalprice')
						$GLOBALS['ProductDetails'] .= $img; 
						
						$GLOBALS['SearchResults'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AbSubCategoryProductsItemHeader");
				
				} else {

						//lguan_20100612: Show overal product rating at category landing page
						/*if($category_rating != 0)
						{
							$GLOBALS['CatgDescandBrandImage'] .= "<br><h2>Rating : <img width='64' height='12' src='".$GLOBALS['TPL_PATH']."/images/IcoRating$category_rating.gif' alt='' /></h2>";
						}*/
						
//		                $GLOBALS['SearchResults'] = "<div>".$GLOBALS['SearchResultList']."</div>";
						$GLOBALS['SearchResults'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AbSubCategoryListingMain");

						if( $GLOBALS['results_page_flag'] == 0 && !isset($params['srch_category']) )
						{
							$GLOBALS['SearchLink'] = "";
							if(isset($params['searchtext']))
								$GLOBALS['SearchLink'] .= "/searchtext/".MakeURLSafe(strtolower($params['searchtext']));
							if(isset($params['search']))
								$GLOBALS['SearchLink'] .= "/searchtext/".MakeURLSafe(strtolower($params['search']));
							if(isset($params['model']) && !isset($params['make']) )
								$GLOBALS['SearchLink'] .= "/model/".MakeURLSafe(strtolower($params['model']));
							if(isset($params['model_flag']) && $params['model_flag'] == 0 && !isset($params['make']))
								$GLOBALS['SearchLink'] .= "/model_flag/".MakeURLSafe(strtolower($params['model_flag']));

							$GLOBALS['SearchResults'] = "";
							if( isset($GLOBALS['YMMTable']) )
							{
								$GLOBALS['SearchResults'] .= "<div>".$GLOBALS['YMMTable']."</div>";
							}
                            if($_REQUEST['is_smart_search']){
                                $GLOBALS['SearchResults'] .= '<p class="ErrorMessage">'.GetLang('SearchYourSearch').' <strong>"'.htmlspecialchars($GLOBALS['OriginalSearchQuery']).'"</strong> '.GetLang('SearchDidNotMatch').'</p>';
                                if($GLOBALS['OriginalSearchQuery']=='')   {
                                    $GLOBALS['SearchTitle'] = '';
                                }else{
                                    $GLOBALS['SearchTitle'] = " ".sprintf(GetLang('SearchResultsFor'), $GLOBALS['OriginalSearchQuery']); 
                                }
                            }
							//$GLOBALS['SearchResults'] .= "<div style='width:100%'><p class='InfoMessage'>Please choose a category or brand</p></div>";
							$GLOBALS['CategoryBrandList'] = "%%Panel.StaticFeaturedCategories%%
							%%Panel.StaticFeaturedBrands%%";
							$GLOBALS['HidePanels'][] = 'SearchPagingTop';
						}

                }

				$GLOBALS['SearchResults']	.=	"<script type=\"text/javascript\"> $('.focushiddendiv').css({'position':'absolute', 'margin-top':'-200px', 'display':'block'}); </script>";

				if ($GLOBALS['EnableSEOUrls'] == 1) {
					$back2url = $_SESSION['back2url'] = preg_replace("/^\//","",$_SERVER['REQUEST_URI']);
				} else {
					$back2url = $_SESSION['back2url'] = "search.php?".$_SERVER['QUERY_STRING'];
				}
				ISC_SetCookie("back2search",$back2url,0,"/");

			}
			else {
				$this->YMMSelectors($params);
				$GLOBALS['SearchResults'] = "<div>".$GLOBALS['YMMTable']."</div>";
				$GLOBALS['CategoryBrandList'] = "%%Panel.StaticFeaturedCategories%%
				%%Panel.StaticFeaturedBrands%%";
				// No search results were found
				// commented below code as need to show the favorite categories and brands as in homepage
				/*$GLOBALS['HideSearchResults'] = "none";
				$GLOBALS['HidePanels'][] = 'SearchPageProducts';*/
			}
		}
		
		//wirror_20100809: Is $subArr the completed subarray of $srcArr?
		function is_subarray($subArr, $srcArr){
			foreach($subArr as $item){
				if(in_array($item, $srcArr) && $item != 0){
					return true;
				}
			}
			
			return false;
		}
		
		function strip_html_tags($content)
        {
            $regex_pattern = "/<\/?\w+((\s+(\w|\w[\w-]*\w)(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/";
            
            $str = preg_replace($regex_pattern,',',$content);
            
            $regex_pattern = '/,+/';
            
            $str = preg_replace($regex_pattern,', ',$str); 
            
            $extr = htmlspecialchars($str); 

            $final_str = trim($extr, ", ");
            
            return  $final_str;
        }

        public function _BuildBreadCrumbs()
        {
            /*
                Build a list of one or more breadcrumb trails for this
                product based on which categories it appears in
            */

            // Build the arrays that will contain the category names to build the trails
            $count = 0;

			$link_params = $params = $this->searchterms; // assinging the parameters 
			unset($link_params['subcategory'],$link_params['series']); // unsetting the subcategory parameter as it not required in link
			$mmy_links = $this->GetYMMLinks($link_params); // getting ymm links
			$mmy_links .= $this->GetOtherLinks($link_params); // getting ymm links

            $GLOBALS['BreadCrumbs'] = "";
            $breadcrumbitems = "";
            
            //$categories = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('RootCategories');
            if(isset($GLOBALS['ISC_SRCH_CATG_NAME'])) {
                
                $GLOBALS['BreadCrumbs'] .= "<div class='Block Moveable Breadcrumb' id='ProductBreadcrumb'>";
                
                $GLOBALS['CatTrailLink'] = $GLOBALS['ShopPath'];
                $GLOBALS['CatTrailName'] = GetLang('Home');
                
                $GLOBALS['BreadcrumbItems'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("BreadcrumbItem");
                
                $catg_id_selected = $GLOBALS['ISC_SRCH_CATG_ID'];
                $catg_selected = $GLOBALS['ISC_SRCH_CATG_NAME'];
                
                if ($GLOBALS['EnableSEOUrls'] == 1)
                	//Modify 2010/10/19 Ronnie
                	//$GLOBALS['CatTrailLink'] = $GLOBALS['ShopPath'].$mmy_links;
					$GLOBALS['CatTrailLink'] = $GLOBALS['ShopPath']."/".MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_CATG_NAME']));
				else
					$GLOBALS['CatTrailLink'] = $GLOBALS['ShopPath']."/search.php?search_query=".MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_CATG_NAME']));

                $GLOBALS['CatTrailName'] = $GLOBALS['ISC_SRCH_CATG_NAME'];
                
                if(isset($params['subcategory']) && !empty($params['subcategory'])) {
                    
                    $breadcrumbitems .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("BreadcrumbItem");
                    $GLOBALS['CatTrailName'] = $params['subcategory'];
                    /**$query = sprintf("SELECT categoryid, catparentid, catname FROM [|PREFIX|]categories WHERE categoryid IN (%s)", $_REQUEST['sub_category']);
                    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                    while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                        $GLOBALS['CatTrailName'] = $row['catname'];
                    }**/
                    
                    $GLOBALS['BreadcrumbItems'] .= $breadcrumbitems.$GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("BreadcrumbItemCurrent");
                    $GLOBALS['BreadCrumbs'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductBreadCrumb"); 
                    
                } else {
                    
                    $GLOBALS['BreadcrumbItems'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("BreadcrumbItemCurrent"); 
                    $GLOBALS['BreadCrumbs'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductBreadCrumb");             
                    
                }
                
                $GLOBALS['BreadCrumbs'] .= "</div>";
                
            }


        }
		
		public function GetAssocDetails($CategoryId, &$OwnAssoc, &$ParentAssoc, &$OwnValue, &$ParentValue)   {
    
		$OwnAssoc       = array();
        $ParentAssoc    = array(); 
        $OwnValue       = array();   
        $ParentValue    = array();     
        $own_assoc_query = 
            "SELECT qa.qualifierid, qa.displayname qname,  
            qvalue, 
            qv.displayname vname  
            FROM [|PREFIX|]qualifier_associations qa 
            LEFT JOIN  [|PREFIX|]qvalue_associations qv on qa.associd = qv.associd 
            WHERE qa.categoryid = ".$CategoryId;
            
        $own_assoc_result = $GLOBALS['ISC_CLASS_DB']->Query($own_assoc_query);
        
        while($own_assoc_row = $GLOBALS['ISC_CLASS_DB']->Fetch($own_assoc_result)) {
			 $qualifierid = $own_assoc_row['qualifierid'];
             $OwnAssoc[$qualifierid][] = $own_assoc_row;
             $OwnValue[$qualifierid][] = strtolower($own_assoc_row['qvalue']);
        }
            
        //Parent category details
        $parcatid_query = "select catparentid from [|PREFIX|]categories WHERE categoryid='".$CategoryId."'";
        $parcatid_result = $GLOBALS['ISC_CLASS_DB']->Query($parcatid_query);   
        $ParentCatId = $GLOBALS['ISC_CLASS_DB']->FetchOne($parcatid_result);
        
        if($ParentCatId != 0)    {       
            $parent_assoc_query = 
                "SELECT qa.qualifierid, qa.displayname qname,  
                qvalue, 
                qv.displayname vname 
                FROM [|PREFIX|]qualifier_associations qa 
                LEFT JOIN  [|PREFIX|]qvalue_associations qv on qa.associd = qv.associd 
                WHERE qa.categoryid = ".$ParentCatId;
                
            $parent_assoc_result = $GLOBALS['ISC_CLASS_DB']->Query($parent_assoc_query);
            
            while($parent_assoc_row = $GLOBALS['ISC_CLASS_DB']->Fetch($parent_assoc_result)) {
	 			 $qualifierid = $parent_assoc_row['qualifierid'];
                 $ParentAssoc[$qualifierid][]     = $parent_assoc_row;
                 $ParentValue[$qualifierid][]     = strtolower($parent_assoc_row['qvalue']);
            }  
        } else {
				$ParentAssoc[0] = array();
		}
        
        }

		/**
	 * @desc Create YMM links
	 * @params search paramsters
	 */
	 function GetYMMLinks($params)
	 {
		$NewLink = '';

		if(isset($params['search_query']))
			$NewLink = MakeURLSafe(strtolower($GLOBALS['PathInfo'][1]));
		//$NewLink = MakeURLSafe(strtolower($params['search_query']));
		/*else if(isset($GLOBALS['ISC_SRCH_BRAND_NAME']))
			$NewLink = MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_BRAND_NAME']));*/

		if( isset($params['brand']) && $NewLink == MakeURLSafe(strtolower($params['brand'])) )
			unset($params['brand']);

		if($NewLink != "") {
			if($GLOBALS['EnableSEOUrls'] == 1)
				$NewLink = "/".$NewLink;
		}

		if ($GLOBALS['EnableSEOUrls'] == 1) {
			if(isset($params['make']) && !empty($params['make']))
			$NewLink .= "/make/".MakeURLSafe(strtolower($params['make']));
			if(isset($params['model']) && !empty($params['model']))
			$NewLink .= "/model/".MakeURLSafe(strtolower($params['model']));
			if(isset($params['model_flag']) && $params['model_flag'] == 0)
			$NewLink .= "/model_flag/".$params['model_flag'];
			if(isset($params['submodel']) && !empty($params['submodel']))
			$NewLink .= "/submodel/".MakeURLSafe(strtolower($params['submodel']));
			if(isset($params['year']) && !empty($params['year']))
			$NewLink .= "/year/".$params['year'];
			if(isset($params['category']) && !empty($params['category']))
			$NewLink .= "/category/".MakeURLSafe(strtolower($params['category']));
			if(isset($params['brand']) && $NewLink != strtolower($params['brand']))
			$NewLink .= "/brand/".MakeURLSafe(strtolower($params['brand']));
			if(isset($params['series']))
			$NewLink .= "/series/".MakeURLSafe(strtolower($params['series']));
			if(isset($params['subcategory']))
			$NewLink .= "/subcategory/".MakeURLSafe(strtolower($params['subcategory']));
			if(isset($params['searchtext']))
			$NewLink .= "/searchtext/".MakeURLSafe(strtolower($params['searchtext']));
			if(isset($params['search']))
			$NewLink .= "/searchtext/".MakeURLSafe(strtolower($params['search']));
			if( isset($params['vqsbedsize']) )
			{
				$NewLink .= "/vqsbedsize/".MakeURLSafe(strtolower($params['vqsbedsize']));
			}
			if( isset($params['vqscabsize']) )
			{
				$NewLink .= "/vqscabsize/".MakeURLSafe(strtolower($params['vqscabsize']));
			}
		} else {
			if(isset($params['make']) && !empty($params['make']))
			$NewLink .= "&make=".MakeURLSafe($params['make']);
			if(isset($params['model']) && !empty($params['model']))
			$NewLink .= "&model=".MakeURLSafe($params['model']);
			if(isset($params['model_flag']) && $params['model_flag'] == 0)
			$NewLink .= "&model_flag=".$params['model_flag'];
			if(isset($params['submodel']) && !empty($params['submodel']))
			$NewLink .= "&submodel=".MakeURLSafe($params['submodel']);
			if(isset($params['year']) && !empty($params['year']))
			$NewLink .= "&year=".$params['year'];
			if(isset($params['category']) && !empty($params['category']))
			$NewLink .= "&category=".MakeURLSafe(strtolower($params['category']));
			if(isset($params['brand']) && $NewLink != strtolower($params['brand']))
			$NewLink .= "&brand=".MakeURLSafe($params['brand']);
			if(isset($params['series']))
			$NewLink .= "&series=".MakeURLSafe($params['series']);
			if(isset($params['subcategory']))
			$NewLink .= "&subcategory=".MakeURLSafe($params['subcategory']);
			if(isset($params['searchtext']))
			$NewLink .= "&searchtext=".MakeURLSafe(strtolower($params['searchtext']));
			if(isset($params['search']))
			$NewLink .= "&searchtext=".MakeURLSafe(strtolower($params['search']));
			if( isset($params['vqsbedsize']) )
			{
				$NewLink .= "&vqsbedsize=".MakeURLSafe(strtolower($params['vqsbedsize']));
			}
			if( isset($params['vqscabsize']) )
			{
				$NewLink .= "&vqscabsize=".MakeURLSafe(strtolower($params['vqscabsize']));
			}
		}

		return $NewLink;
	 }


	 /**
	 * @desc Create qualifier links
	 * @params $params
	 */
	 function GetOtherLinks($params)
	 {

		$NewLink = '';

		if ($GLOBALS['EnableSEOUrls'] == 1) {
			foreach($params['dynfilters'] as $key => $value) {
				$NewLink .= "/".strtolower($key)."/".MakeURLSafe(strtolower($value));
			}
		} else {
			foreach($params['dynfilters'] as $key => $value) {
				$NewLink .= "&".strtolower($key)."=".MakeURLSafe(strtolower($value));
			}
		}
		return $NewLink;
	 }

	  /**
	 * @desc Create Category links
	 * @params Rootcatname
	 * add @params $category Ronnie
	 */
	 function LeftCatLink($mmy_link, $property, $RootCatName,$category)
	 {
	 	$category=MakeURLSafe(strtolower($category));
	 	
		$NewLink = '';
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			//$NewLink = sprintf("%s%s/%s/%s", GetConfig('ShopPath')."/a-b-testing", $mmy_link, $property, MakeURLSafe(strtolower($RootCatName)));
			//Modify 2010/10/19 Ronnie
			//echo " aa:".$mmy_link." bb:".$property." cc:".$RootCatName."\end ";
			$NewLink = sprintf("%s/%s/%s/%s", GetConfig('ShopPath'), $category, $property ,MakeURLSafe(strtolower($RootCatName)));
		} else {
			//Modify 2010/10/19 Ronnie
			//$NewLink = sprintf("%s/search.php?search_query=%s&%s=%s", GetConfig('ShopPath'), $mmy_link, $property, MakeURLSafe($RootCatName));
			$NewLink = sprintf("%s/search.php?search_query=%s&%s=%s", GetConfig('ShopPath'), $category ,"subcategory" ,MakeURLSafe($RootCatName));
		}
		return $NewLink;
	 }

    function IsMakeAnOffer($type, $id)
    {
        $offer = "";
        if($type=='category')
        {
            $offer_query = "select offer from [|PREFIX|]categories WHERE categoryid='".$id."'";
            $offer_result = $GLOBALS['ISC_CLASS_DB']->Query($offer_query);   
            $offer = $GLOBALS['ISC_CLASS_DB']->FetchOne($offer_result);
        }
        else if($type=='series')
        {
            $offer_query = "select offer from [|PREFIX|]brand_series WHERE seriesid='".$id."'";
            $offer_result = $GLOBALS['ISC_CLASS_DB']->Query($offer_query);   
            $offer = $GLOBALS['ISC_CLASS_DB']->FetchOne($offer_result);
        }
        return isc_strtolower($offer);
    }

	function IsProductMakeanOffer($seriesid=0,$brandname='',$categoryid=0) 
	{
		$makeanoffer = 'no';
		$series = $GLOBALS['ISC_CLASS_DB']->Query("SELECT offer FROM [|PREFIX|]brand_series where seriesid = '$seriesid ' and offer = 'yes' ");
		if($srow = $GLOBALS['ISC_CLASS_DB']->Fetch($series)) {
			return $makeanoffer = $srow['offer'];
		} 

		$category = $GLOBALS['ISC_CLASS_DB']->Query("SELECT c.offer as childoffer FROM [|PREFIX|]categories c where c.categoryid = '$categoryid' ");
		if($crow = $GLOBALS['ISC_CLASS_DB']->Fetch($category)) {
			if($crow['childoffer'] == 'yes') {
				return $makeanoffer = 'yes';
			}
		}
		return $makeanoffer;
	}

	function getYMMOptions($params,$ymm_type)
	{
			switch($ymm_type)
			{
				case 'year'		: 	
									$options = "<option value=''>--select year--</option>";
									$filter_array = array();
									$ymm_qry = "select group_concat(v.prodstartyear separator '~') as prodstartyear , group_concat(v.prodendyear separator '~') as prodendyear from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
									if( isset($params['make']) && $GLOBALS['UniversalCat'] == 0 )
										$ymm_qry .= " and prodmake = '".$params['make']."' ";
									if( isset($params['model']) && (!isset($params['model_flag']) || $params['model_flag'] == 1) && $GLOBALS['UniversalCat'] == 0 )
										$ymm_qry .= " and prodmodel = '".$params['model']."' ";

									$ymm_qry .= " group by p.productid ";	
									$ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
									while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
									{
										$grp_startyear = explode("~",$ymm_row['prodstartyear']); 
										$grp_endyear = explode("~",$ymm_row['prodendyear']);
										for($g=0;$g<count($grp_startyear);$g++)
										{
											$prod_start_year = $grp_startyear[$g];
											$prod_end_year = $grp_endyear[$g]; 

											if(is_numeric($prod_start_year) && is_numeric($prod_end_year)) 
											{
												$prod_year_diff = $prod_end_year - $prod_start_year;
												for($i=0;$i<=$prod_year_diff;$i++)
												{
													$actual_year = $prod_start_year + $i;
													if(in_array($actual_year,$filter_array)) {
													   $count_filter_array[$actual_year]++;        
													}  else {
														$filter_array[] = $actual_year;
														$count_filter_array[$actual_year] = 1;
													}
												}
											}
										}
									}
									rsort($filter_array);
									foreach($filter_array as $key => $value)
									{
										$selected = "";
										if ( isset($params['year']) && strcasecmp($params['year'], $value) == 0 )
											$selected = " selected";

										$options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>";
									}
									break;
				case 'make'		: 
									$options = "<option value=''>--select make--</option>";
									$filter_array = array();
									$ymm_qry = "select group_concat(DISTINCT v.prodmake separator '~') as prodmake from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
									$ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
									while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
									{
										$filters = explode('~',$ymm_row['prodmake']);
										for($j=0;$j<count($filters);$j++) 
									    {
											$filter_value = $filters[$j]; 
											if(strtoupper($filter_value) != "NON-SPEC VEHICLE" && strtolower($filter_value) != "all" && $filter_value != "")
											{
												if(in_array($filter_value,$filter_array))   {
													$count_filter_array[$filter_value]++;
												} else {
													$filter_array[] = $filter_value;
													$count_filter_array[$filter_value] = 1;
												}
											}
									    }
									}
									sort($filter_array);
									$all_makes = array('CHEVROLET', 'GMC', 'FORD', 'DODGE', 'TOYOTA', 'NISSAN', 'HONDA', 'JEEP', 'HYUNDAI','CHRYSLER', 'INFINITI', 'LEXUS');
									//$temp_arr =  array_diff($filter_array,$all_makes);	// commented as client told to include the above makes in other list also
									$temp_arr =  $filter_array;

									foreach($all_makes as $key => $value) 
									{
										$selected = "";
										if ( isset($params['make']) && strcasecmp($params['make'], $value) == 0 )
											$selected = " selected";		
										
										$options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>"; 
									}

									$options .= "<option value=''>------------</option>"; 

									foreach($temp_arr as $key => $value ) 
									{
										$selected = "";
										if ( isset($params['make']) && strcasecmp($params['make'], $value) == 0 )
											$selected = " selected";		

										$options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>";
									}
									break;
				case 'model'	: 
									$options = "<option value=''>--select model--</option>";
									if(isset($params['make']))
									{	
										$filter_array = array();
										$ymm_qry = "select distinct prodmodel from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
										if( isset($params['make']) )
											$ymm_qry .= " and prodmake = '".$params['make']."' ";
										if( isset($params['year']) && $GLOBALS['UniversalCat'] == 0 )
											$ymm_qry .= " and ".$params['year']." between prodstartyear and prodendyear ";

										//$ymm_qry .= " group by p.productid ";	
										$ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
										while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
										{
											if(!empty($ymm_row['prodmodel']) && $ymm_row['prodmodel'] != '~') {
											   $filters = explode('~',$ymm_row['prodmodel']);
											   for($j=0;$j<count($filters);$j++) 
											   {
													$filter_value = ucwords(strtolower($filters[$j]));
													if(strtolower($filter_value) != "all")
													{
														if(in_array($filter_value,$filter_array))   {
														} else {
															$filter_array[] = $filter_value;
														}
													}
											   }
											}
										}
										sort($filter_array);
										foreach($filter_array as $key => $value)
										{
											$selected = "";
											if ( isset($params['model']) && strcasecmp($params['model'], $value) == 0 )
												$selected = " selected";

											$options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>";
										}
									}
									break;
			}

			return $options;

	}

	function YMMSelectors($params)
	{
			if( isset($params['model']) && !isset($params['make']) )
			{
				unset($params['model']);
			}

			$GLOBALS['UniversalCat'] = isset($params['catuniversal']) ? $params['catuniversal'] : 0;
			$GLOBALS['YearList']	=	$this->getYMMOptions($params,'year');
			$GLOBALS['MakeList']	=	$this->getYMMOptions($params,'make');
			$GLOBALS['ModelList']	=	$this->getYMMOptions($params,'model');
			$GLOBALS['YMMTable']	=	$GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("YMMOptions");
	}

}

?>
