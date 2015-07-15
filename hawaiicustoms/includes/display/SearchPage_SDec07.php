<?php

    require_once(ISC_BASE_PATH . "/lib/discountcalcs.php");                               // Added by Simha for onsale addition
    
	CLASS ISC_SEARCHPAGE_PANEL extends PANEL
	{
		public $searchterms; //assigning search terms

		public function SetPanelSettings()
		{
			$count = 0;
			$output = "";
			$params = $GLOBALS['ISC_CLASS_SEARCH']-> _searchterms;
			$this->searchterms = $params;

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
			$ext_links .= $seo_delim."make=".$params['make']; 
			}
			
            if(isset($_REQUEST['model']) && !empty($_REQUEST['model']) && ( !isset($params['model_flag']) || $params['model_flag'] != 0 ) ) {
			$GLOBALS['MMY'] .= strtoupper($_REQUEST['model'])."<br>";
			$ext_links .= $seo_delim."model=".strtoupper($params['model']); 
			} 
			else if(isset($params['model']))
            $ext_links .= $seo_delim."model=".$params['model'];

			/* this condition has been added seperately here to show submodel at last */
            if(isset($params['submodel'])) {
            $GLOBALS['MMY'] .= strtoupper($params['submodel'])."<br>";                    
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

				$catg_desc_qry = "select catdesc from [|PREFIX|]categories where categoryid = ".$selected_catg;
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

			// for breadcrumbs
            $this->_BuildBreadCrumbs();

			/* the below line has been commented as client told to remove it */
			//$GLOBALS['SearchPhrase'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SearchPhrase");     
            if($GLOBALS['ISC_CLASS_SEARCH']->GetNumResults() > 30 ) {
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
			if($GLOBALS['ISC_CLASS_SEARCH']->GetNumResults() > 0) {

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

					if( isset($params['partnumber']) || $params['flag_srch_category'] == 1 || ( isset($params['flag_srch_category']) && isset($GLOBALS['BRAND_SERIES_FLAG']) && $GLOBALS['BRAND_SERIES_FLAG'] == 1 ))  // this is for product listing page 
                    {

							if( isset($params['srch_category']) )  {
								$GLOBALS['CatgDescandBrandImage'] = isset($catg_desc_arr['catdesc']) ? $catg_desc_arr['catdesc'] : ''; // description will be added here to show it at the top of product listing page.
							}

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
							$GLOBALS['BrandName'] = $row['brandname']; 
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

												if(($m = array_search(strtolower($val),$OwnValue[$qualifier_id]))!==false && $OwnAssoc[$qualifier_id][$m]['vname'] != "")
													$val = $OwnAssoc[$qualifier_id][$m]['vname'];
												else if( isset($ParentValue[$qualifier_id]) && (($m = array_search(strtolower($val),$ParentValue[$qualifier_id]))!==false) && $ParentAssoc[$qualifier_id][$m]['vname'] != "")
													$val = $ParentAssoc[$qualifier_id][$m]['vname'];

												/* -- Setting display name for qualifier value ends-- */

												$GLOBALS['VehicleOptions'] .= $key." : ".$val."<br>"; 

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
												
												$GLOBALS['ProdOptions'] .= $key." : ".$val."<br>"; 
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
									$vq_column_title = "Product Name / Vehicle Options";
							}
							else
							{
								if($vq_column_title == "")
									$vq_column_title = "Vehicle Options";
								else if($vq_column_title != "Vehicle Options")
									$vq_column_title = "Product Name / Vehicle Options";
							}

							if(empty($GLOBALS['VehicleOptions']))
								$GLOBALS['VehicleOptions'] = "&nbsp;";
							if(empty($GLOBALS['ProdOptions']))
								$GLOBALS['ProdOptions'] = "&nbsp;";
							
							/*--- the below lines are added for back 2 search link in the product detail page. Also modified line no 56 & 60 --- */
							if($GLOBALS['EnableSEOUrls'] == 1)
								$GLOBALS['ProductLink'] .= "/refer=true".$ext_links;
							else
								$GLOBALS['ProductLink'] .= "&refer=true".$ext_links;

							### Added by Simha for onsale addition   
							// Determine the price of this product
							//$GLOBALS['ProductPrice'] = CalculateProductPrice_retail($row);
							$GLOBALS['ProductPrice'] = CalculateProductPriceRetail($row);

							$FinalPrice         = $GLOBALS['ProductPrice'];  
                            $SalePrice          = $row['prodsaleprice'];  
							//$DiscountAmount = $FinalPrice;
							if((float)$SalePrice >0 && $SalePrice < $FinalPrice)    {
                                $DiscountPrice = $SalePrice;
                            }
                            else    {   
                                $DiscountPrice = $FinalPrice;
                                $DiscountPrice = CalculateDiscountPrice($FinalPrice, $DiscountPrice, $row['categoryid'], $row['brandseriesid']);                               
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
                            
							if(isset($DiscountPrice) && $DiscountPrice < $FinalPrice )    {     //&& GetConfig('ShowOnSale')
								$GLOBALS['ProductPrice']  = '<strike>'.CurrencyConvertFormatPrice($FinalPrice).'</strike>'; 
								$GLOBALS['ProductPrice'] .= '<br>'.CurrencyConvertFormatPrice($DiscountPrice).'';     
								$GLOBALS['ShowOnSaleImage'] = '<img id="OnSale" src="'.GetConfig('ShopPath').'/templates/default/images/onsale.gif" alt="">';                  
                                if(GetConfig('ShowOnSale'))    {
								    $GLOBALS['ProductPrice'] .= '<br>'.$GLOBALS['ShowOnSaleImage'].'';
                                }
							}
							else    {
								$GLOBALS['ProductPrice']  = ''.CurrencyConvertFormatPrice($FinalPrice).'';
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

							$GLOBALS['SearchResultList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SubCategoryProductsItem");
				
					} 
					else if($GLOBALS['results_page_flag'] == 0) // subcategory page
					{
							$subcatg_link = $this->LeftCatLink($mmy_links, 'subcategory', $row['catname']);
							$link = "<a href='".$subcatg_link."'>";
							if(isset($row['imagefile']) && !empty($row['imagefile'])) {
                                $images = explode("~",$row['imagefile']);
                                for($j=0;$j<count($images);$j++) {
                                    if(!empty($images[$j])) {
                                        $imagefile =  "$link<img src='$path/category_images/".$images[$j]."'></a>";
                                        break;
                                    }
                                }
                            } else if(empty($row['imagefile']) || empty($imagefile))
                                    $imagefile = "$link<img src='$path/templates/default/images/ProductDefault.gif' border=0></a>";

							$GLOBALS['LeftImage'] = $imagefile;
							$GLOBALS['ProductsCount'] = "(".$row['totalproducts'].") Products Available";
                                    
                            $row['brandname'] = str_replace('~',' , ',$row['brandname']);
							//$GLOBALS['RelatedBrands'] = $row['brandname'];

							if(!empty($row['seriesname']))
                            $row['brandname'] .= "<br>".$row['seriesname'];
							
							if($row['seriesids'] != "") 
							{
								$seriesids = str_ireplace("~",",",$row['seriesids']);
								$seriesids_qry = "select brandname , seriesname from isc_brand_series bs left join isc_brands b on bs.brandid = b.brandid where seriesid in (".$seriesids.")";
								$seriesids_res = $GLOBALS['ISC_CLASS_DB']->Query($seriesids_qry);
								if( $GLOBALS['ISC_CLASS_DB']->CountResult($seriesids_res) > 0) {
									while($seriesids_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($seriesids_res))
									{
										if(!isset($params['brand'])) {
											if($GLOBALS['EnableSEOUrls'] == 1)
												$GLOBALS['ProductsCount'] .= "<br><a href='".$subcatg_link."/brand/".MakeURLSafe(Strtolower($seriesids_arr['brandname']))."/series/".MakeURLSafe(Strtolower($seriesids_arr['seriesname']))."'>".$seriesids_arr['brandname']." ".$seriesids_arr['seriesname']."</a>";		
											else
												$GLOBALS['ProductsCount'] .= "<br><a href='".$subcatg_link."&brand=".MakeURLSafe(Strtolower($seriesids_arr['brandname']))."&series=".MakeURLSafe(Strtolower($seriesids_arr['seriesname']))."'>".$seriesids_arr['brandname']." ".$seriesids_arr['seriesname']."</a>";		
										}
										else
										{
											if($GLOBALS['EnableSEOUrls'] == 1)
												$GLOBALS['ProductsCount'] .= "<br><a href='".$subcatg_link."/series/".MakeURLSafe(Strtolower($seriesids_arr['seriesname']))."'>".$seriesids_arr['brandname']." ".$seriesids_arr['seriesname']."</a>";		
											else
												$GLOBALS['ProductsCount'] .= "<br><a href='".$subcatg_link."&series=".MakeURLSafe(Strtolower($seriesids_arr['seriesname']))."'>".$seriesids_arr['brandname']." ".$seriesids_arr['seriesname']."</a>";				
										}
									}
								}
								
							}

							$content = $row['brandname']."<br>";
							
							if( !isset($params['category']) && ( isset($params['srch_category']) || !isset($GLOBALS['BRAND_SERIES_FLAG']) ) ) {
								$GLOBALS['CatgDescandBrandImage'] = isset($catg_desc_arr['catdesc']) ? $catg_desc_arr['catdesc'] : ''; // description will be added here to show it at the top of subcatg page.
								$content .= "<h3><a href='".$path."/search.php?$qry_string&subcategory=".MakeURLSafe($row['catname'])."'>".$row['catname']."</a></h3>>";
								$GLOBALS['TitleLink'] = "<h2><a href='".$subcatg_link."'>".$row['catname']."</a></h2>";
							}

							$content .= "Price starting from $".number_format($row['prodcalculatedprice'], 2, '.', '')."<br>".$imagefile;
                            $GLOBALS['leftsidecontent'] = $content;
							$GLOBALS['PriceRange'] = "Price starting from $".number_format($row['prodcalculatedprice'], 2, '.', '');
                            
                            $content = "<img src='$path/templates/default/images/free-shipping2.gif'><br>".strip_tags($row['proddesc'])."<br>".$row['prodwarranty'];
                            $GLOBALS['rightsidecontent'] = $content;

							$GLOBALS['ShippingImage'] = "<img src='$path/templates/default/images/free-shipping2.gif'>";
							$GLOBALS['ProductWarranty'] = "<h3>".$row['prodwarranty']."</h3>";
                            
                            $content = "$link<img src='$path/templates/default/images/view.gif'></a>";
							$GLOBALS['ViewDetailsImage'] = $content;
                            
                            $GLOBALS['lowersidecontent'] = $content;
                            
                            $GLOBALS['SearchResultList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SubCategoryListing");
					}
					else	// series page
					{      
                            
							$series_link = $this->LeftCatLink($mmy_links, 'series', $row['seriesname']);
                            $link = "<a href='".$series_link."'>";
							
                            if(isset($row['imagefile']) && !empty($row['imagefile'])) {
                                $images = explode("~",$row['imagefile']);
                                for($j=0;$j<count($images);$j++) {
                                    if(!empty($images[$j])) {
                                        $imagefile =  "$link<img src='$path/category_images/".$images[$j]."'></a>";
                                        break;
                                    }
                                }
                            } else if(empty($row['imagefile']) || empty($imagefile))
                                    $imagefile = "$link<img src='$path/templates/default/images/ProductDefault.gif' border=0></a>";

							$GLOBALS['LeftImage'] = $imagefile;
							        
                            $row['brandname'] = str_replace('~',' , ',$row['brandname']);
							$GLOBALS['RelatedBrands'] = $row['brandname'];
                            
                            if(isset($row['seriesname']) && !empty($row['seriesname']) && ( !isset($params['srch_category']) || isset($params['category']) ) && isset($GLOBALS['BRAND_SERIES_FLAG'])) {

								if(empty($row['imagefile']) || empty($imagefile))
										$GLOBALS['LeftImage'] = "$link<img src='$path/templates/default/images/ProductDefault.gif'></a>";
								else
										$GLOBALS['LeftImage'] = "$link<img src='$path/series_images/".$row['imagefile']."' width='140px'></a>";
								
								$GLOBALS['TitleLink'] = "<h2><a href='".$series_link."'>".$row['brandname']." ".$row['seriesname']." ".$row['parentcatname']."</a></h2>";
								//"<h3>".$row['catname']."</h3>
								$GLOBALS['ProductsCount'] = "(".$row['totalproducts'].") Products Available";
								$GLOBALS['RelatedBrands'] = "<ul class='featurepoints'>";
									if(!empty($row['feature_points1']))	
									$GLOBALS['RelatedBrands'] .= "<li>".$row['feature_points1']."</li>";
									if(!empty($row['feature_points2']))	
									$GLOBALS['RelatedBrands'] .= "<li>".$row['feature_points2']."</li>";
									if(!empty($row['feature_points3']))	
									$GLOBALS['RelatedBrands'] .= "<li>".$row['feature_points3']."</li>";
									if(!empty($row['feature_points4']))	
									$GLOBALS['RelatedBrands'] .= "<li>".$row['feature_points4']."</li>";

								$GLOBALS['RelatedBrands'] .= "</ul>";	

								/*if(isset($row['brandlargefile']) && !empty($row['brandlargefile'])) {
									$brand_image_path = "product_images/".$row['brandlargefile'];
									if(file_exists($brand_image_path)) {
										$GLOBALS['CatgDescandBrandImage'] = "<img src='$path/product_images/".$row['brandlargefile']."'>";
									} else if(isset($row['brandimagefile']) && !empty($row['brandimagefile'])) {
										$brand_image_path = "product_images/".$row['brandimagefile'];
										if(file_exists($brand_image_path))
											$GLOBALS['CatgDescandBrandImage'] = "<img src='$path/product_images/".$row['brandimagefile']."'>";
									}
								} else if(isset($row['brandimagefile']) && !empty($row['brandimagefile'])) {
										$brand_image_path = "product_images/".$row['brandimagefile'];
										if(file_exists($brand_image_path))
											$GLOBALS['CatgDescandBrandImage'] = "<img src='$path/product_images/".$row['brandimagefile']."'>";
								}*/
								
							}

							$GLOBALS['CatgDescandBrandImage'] = $row['branddescription'];

							if($row['subcatgids'] != "") 
							{
								$subcatgids = str_ireplace("~",",",$row['subcatgids']);
								$subcatgids_qry = "select catname from [|PREFIX|]categories where categoryid in (".$subcatgids.")";
								$subcatgids_res = $GLOBALS['ISC_CLASS_DB']->Query($subcatgids_qry);
								if( $GLOBALS['ISC_CLASS_DB']->CountResult($subcatgids_res) > 0) {
									while($subcatgids_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($subcatgids_res))
									{
										if($GLOBALS['EnableSEOUrls'] == 1)
										{
											$GLOBALS['ProductsCount'] .= "<br><a href='".$series_link."/subcategory/".MakeURLSafe(Strtolower($subcatgids_arr['catname']))."'>".$subcatgids_arr['catname']."</a>";		
										} 
										else
										{
											$GLOBALS['ProductsCount'] .= "<br><a href='".$series_link."&subcategory=".MakeURLSafe(Strtolower($subcatgids_arr['catname']))."'>".$subcatgids_arr['catname']."</a>";		
										}
									}
								}
								
							}
                            
                            $content = $row['brandname']."<br>";
                            
                            $content .= $row['catname']."<br>";
                            
                            $content .= "Price starting from $".number_format($row['prodcalculatedprice'], 2, '.', '');
                            $GLOBALS['leftsidecontent'] = $content;
							$GLOBALS['PriceRange'] = "Price starting from $".number_format($row['prodcalculatedprice'], 2, '.', '');
                            
                            $content = "<img src='$path/templates/default/images/free-shipping2.gif'><br>".strip_tags($row['proddesc'])."<br>".$row['prodwarranty'];
                            $GLOBALS['rightsidecontent'] = $content;

							$GLOBALS['ShippingImage'] = "<img src='$path/templates/default/images/free-shipping2.gif'>";
							$GLOBALS['ProductWarranty'] = "<h3>".$row['prodwarranty']."</h3>";
                            
                            $content = "$link<img src='$path/templates/default/images/view.gif'></a>";
							$GLOBALS['ViewDetailsImage'] = $content;
                            
                            $GLOBALS['lowersidecontent'] = $content;
                            
                            $GLOBALS['SearchResultList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SubCategoryListing");
                            
                            $GLOBALS['HideCompareItems'] = "none";
                   } 
							
				}

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
				//$GLOBALS['SearchResults'] = $GLOBALS['SearchResultList']; // commented by vikas
				if(isset($params['partnumber']) || $params['flag_srch_category'] == 1 || ( isset($params['flag_srch_category']) && isset($GLOBALS['BRAND_SERIES_FLAG']) && $GLOBALS['BRAND_SERIES_FLAG'] == 1 )) {

					if ($GLOBALS['EnableSEOUrls'] == 1)
					{
						$GLOBALS['ProductBrand'] = "<a href='$path$mmy_links/orderby/brandname/sortby/$sort'>Brand</a>";    

						$GLOBALS['ProductPartNumber'] = "<a href='$path$mmy_links/orderby/prodcode/sortby/$sort'>Part Number</a>";

						$GLOBALS['ProductPrice'] = "<a href='$path$mmy_links/orderby/prodcalculatedprice/sortby/$sort'>Price</a>";
					}
					else
					{
						$GLOBALS['ProductBrand'] = "<a href='$path/search.php?search_query=$mmy_links&orderby=brandname&sortby=$sort'>Brand</a>";    

						$GLOBALS['ProductPartNumber'] = "<a href='$path/search.php?search_query=$mmy_links&orderby=prodcode&sortby=$sort'>Part Number</a>";

						$GLOBALS['ProductPrice'] = "<a href='$path/search.php?search_query=$mmy_links&orderby=prodcalculatedprice&sortby=$sort'>Price</a>";
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
						
						$GLOBALS['ProductDetails'] = "Details";  
						
						$GLOBALS['SearchResults'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SubCategoryProductsItemHeader");
				
				} else {

//		                $GLOBALS['SearchResults'] = "<div>".$GLOBALS['SearchResultList']."</div>";
						$GLOBALS['SearchResults'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SubCategoryListingMain");

                }

				if ($GLOBALS['EnableSEOUrls'] == 1) {
					$back2url = $_SESSION['back2url'] = preg_replace("/^\//","",$_SERVER['REQUEST_URI']);
				} else {
					$back2url = $_SESSION['back2url'] = "search.php?".$_SERVER['QUERY_STRING'];
				}
				ISC_SetCookie("back2search",$back2url,0,"/");

				// Showing the syndication option?
				if(GetConfig('RSSNewProducts') != 0 && GetConfig('RSSCategories') != 0 && GetConfig('RSSSyndicationIcons') != 0) {
					$GLOBALS['RSSURL'] = SearchLink($GLOBALS['ISC_CLASS_SEARCH']->GetQuery(), 0, false);
					$GLOBALS['SNIPPETS']['SearchResultsFeed'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SearchResultsFeed");
				}

			}
			else {
				// No search results were found
				$GLOBALS['HideSearchResults'] = "none";
				$GLOBALS['HidePanels'][] = 'SearchPageProducts';
			}
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
					$GLOBALS['CatTrailLink'] = $GLOBALS['ShopPath'].$mmy_links;
				else
					$GLOBALS['CatTrailLink'] = $GLOBALS['ShopPath']."/search.php?search_query=".$mmy_links;

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

		if(isset($GLOBALS['ISC_SRCH_CATG_NAME']) && !isset($params['category']))
			$NewLink = MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_CATG_NAME']));
		else if(isset($GLOBALS['ISC_SRCH_BRAND_NAME']))
			$NewLink = MakeURLSafe(strtolower($GLOBALS['ISC_SRCH_BRAND_NAME']));

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
	 */
	 function LeftCatLink($mmy_link, $property, $RootCatName)
	 {
		$NewLink = '';
		if ($GLOBALS['EnableSEOUrls'] == 1) {
			$NewLink = sprintf("%s%s/%s/%s", GetConfig('ShopPath'), $mmy_link, $property, MakeURLSafe(strtolower($RootCatName)));
		} else {
			$NewLink = sprintf("%s/search.php?search_query=%s&%s=%s", GetConfig('ShopPath'), $mmy_link, $property, MakeURLSafe($RootCatName));
		}
		return $NewLink;
	 }


	}

?>
