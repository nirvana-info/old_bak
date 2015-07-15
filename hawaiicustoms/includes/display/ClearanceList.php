<?php
/******************************************
* Page Name         : ClearanceList.php
* Containing Folder : display
* Created By        : Baskaran B
* Created On        : 18th June, 2010
* Modified By       : Baskaran B
* Modified On       : 18th June, 2010
* Description       : Display only assigned category and brand for clearance.
*****************************************************************************/

require_once(ISC_BASE_PATH . "/lib/discountcalcs.php");
CLASS ISC_CLEARANCELIST_PANEL extends PANEL
    {     
        public function SetPanelSettings()
        {
        $path = GetConfig('ShopPath');

		$params = array();
        for($i=1;$i<count($GLOBALS['PathInfo']);$i+=2)
		{
			if($GLOBALS['PathInfo'][$i+1] != '')
				$params[$GLOBALS['PathInfo'][$i]] = MakeURLNormal($GLOBALS['PathInfo'][$i+1]);
		}

		$catg_qry = "select * from [|PREFIX|]categories where catvisible=1 order by catparentid ASC , CHAR_LENGTH(catname) DESC";
		$catg_res =  $GLOBALS['ISC_CLASS_DB']->Query($catg_qry);

		$catgoryname = array();    // array for category names
				   
		while($catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($catg_res))
		{
				$catgoryname[$catg_arr['categoryid']]['catname'] = $catg_arr['catname'];
				$catgoryname[$catg_arr['categoryid']]['catparentid'] = $catg_arr['catparentid'];
		}
		$GLOBALS['categories_all'] = $catgoryname;

		@$lastSelection = $_COOKIE['last_search_selection']; 
		if( !isset($params['make']) &&  isset($lastSelection['make']) && $lastSelection['make'] != "")
		{
			$params['make'] = $lastSelection['make'];
			if( !isset($params['model']) &&  isset($lastSelection['model']) && $lastSelection['model'] != "" )
			{
				$params['model'] = $lastSelection['model'];
			}
		}
		if( !isset($params['year']) &&  isset($lastSelection['year']) && $lastSelection['year'] != "")
		{
			$params['year'] = $lastSelection['year'];
		}
        
        $where = '';
        if(isset($params['make'])) {
            $where .= "AND ( v.prodmake = '".$params['make']."' OR v.prodmake = 'NON-SPEC VEHICLE' ) ";
        }
        if(isset($params['model'])) {
            $where .= "AND ( v.prodmodel = '".$params['model']."' OR v.prodmodel = 'ALL' ) ";
        }
        if(isset($params['year'])) {
            $year = $params['year'];
            $where .= "AND ( $year between v.prodstartyear and v.prodendyear OR v.prodstartyear = 'ALL' ) ";
        }

		/*if( !isset($params['make']) || !isset($params['model']) || !isset($params['year']) )
		{*/
			$GLOBALS['UniversalCat'] = isset($params['catuniversal']) ? $params['catuniversal'] : 0;
			$GLOBALS['YearList']	=	$this->getYMMOptions($params,'year');
			$GLOBALS['MakeList']	=	$this->getYMMOptions($params,'make');
			$GLOBALS['ModelList']	=	$this->getYMMOptions($params,'model');
			$GLOBALS['YMMTable']	=	$GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ClearanceYMMOptions");
		//}

		$GLOBALS['ClearanceResults'] = "<div style='float:left'>".$GLOBALS['YMMTable']."</div>";

		$mmy_links = $this->GetYMMLinks($params);

		$query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]discounts WHERE discountname = 'Clearance' and discountenabled = 1 LIMIT 0 , 1 ");
            $flag = '0';
			if( $GLOBALS['ISC_CLASS_DB']->CountResult($query) == 1 )
			{
				$crow = $GLOBALS['ISC_CLASS_DB']->Fetch($query);
				$catid = unserialize($crow['configdata']);
				if(array_key_exists("var_catids",$catid)) {
					$flag = '1';
					$category_id = $catid['var_catids'];
				}
				else {
					$flag = '2';
					$brand_id = $catid['var_brandids'];
					$series_id = $catid['var_seriesids'];
				}
			}

            if($flag == '1') { # For Category -- Baskaran

				$clearance_qry = "select c.catname , c.categoryid , c.catuniversal , c.catimagealt , c.featurepoints , group_concat(DISTINCT brandname separator '~') as brandname , group_concat(DISTINCT p.brandseriesid separator '~') as seriesids , min(fp.prodfinalprice) as prodminprice , max(fp.prodfinalprice) as prodmaxprice , c.catimagefile as imagefile , c.cathoverimagefile , p.proddesc , prodwarranty , bs.seriesname , p.brandseriesid , count(distinct p.productid) as totalproducts,floor(SUM(p.prodratingtotal)/SUM(p.prodnumratings)) AS prodavgrating from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid LEFT JOIN [|PREFIX|]categoryassociations ca on ca.productid = p.productid LEFT JOIN [|PREFIX|]categories c on c.categoryid = ca.categoryid and c.catvisible = 1 LEFT JOIN [|PREFIX|]brands b on prodbrandid = b.brandid LEFT JOIN [|PREFIX|]brand_series AS bs ON bs.seriesid = p.brandseriesid LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid AND pi.imageisthumb=1) LEFT JOIN [|PREFIX|]product_finalprice fp ON p.productid = fp.productid WHERE 1=1 AND c.categoryid IN ($category_id) AND p.prodvisible='1' $where group by c.categoryid ORDER BY c.catdeptid ASC, c.catsort ASC, c.catname ASC";

                $catquery = $GLOBALS['ISC_CLASS_DB']->Query($clearance_qry);
                $cnt = $GLOBALS['ISC_CLASS_DB']->CountResult($catquery);

                if($cnt > '0') { 
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($catquery)) {
					$cat_id = $row['categoryid'];
                    $category_rating = 0;
					$cat_rating_res = $GLOBALS['ISC_CLASS_DB']->Query("SELECT floor(SUM(p.prodratingtotal)/SUM(p.prodnumratings))AS prodavgrating FROM [|PREFIX|]categoryassociations c INNER JOIN [|PREFIX|]products p on c.productid=p.productid where c.categoryid = '$cat_id'");
                    $cat_rating_arr = $GLOBALS['ISC_CLASS_DB']->FetchOne($cat_rating_res);
                    if (isset($cat_rating_arr['prodavgrating'])) {
                    	$category_rating = (int) $cat_rating_arr['prodavgrating'];
                    }

					$parentid = $GLOBALS['categories_all'][$row['categoryid']]['catparentid'];
					if($parentid != 0)
					{
						if(isset($GLOBALS['categories_all'][$parentid])) // if parent catg is not visible
							$mmy_links_modified = "/".MakeURLSafe(strtolower($GLOBALS['categories_all'][$parentid]['catname'])).$mmy_links;
						else
							$mmy_links_modified = "/".MakeURLSafe(strtolower($GLOBALS['categories_all'][$row['categoryid']]['catname'])).$mmy_links;
					}
					else
					{
						$mmy_links_modified = "/".MakeURLSafe(strtolower($GLOBALS['categories_all'][$row['categoryid']]['catname'])).$mmy_links;
					}

					$subcatg_link = $this->LeftCatLink($mmy_links_modified, 'subcategory', $row['catname']);
                    $link = "<a href='".$subcatg_link."'>";
                    
                    $tiplink = "<a class='thickbox1' href='".$GLOBALS['ShopPath']."/catgbrand.php?categoryid=".$row['categoryid']."&url=".urlencode($subcatg_link)."'  title=''><img src='$path/templates/default/images/fastlook_red.gif' border=0></a>";

                    $imagelink = "<a class='thickbox' href='".$GLOBALS['ShopPath']."/catgbrand.php?categoryid=".$row['categoryid']."&url=".urlencode($subcatg_link)."' title='' onmouseover='createtip(".$row['categoryid'].")' onmouseout='UnTip()'>";
                    if(isset($row['imagefile']) && !empty($row['imagefile'])) {
//                        $images = explode("~",$row['imagefile']);
//                        for($j=0;$j<count($images);$j++) {
//                            if(!empty($images[$j])) {

                                $imagefile =  "$imagelink<img src='$path/category_images/".$row['imagefile']."' alt='".isc_html_escape($row['catimagealt'])."' title='".isc_html_escape($row['catimagealt'])."'></a>";

                                $imagefile .= "<span id='span".$row['categoryid']."' style='display:none'>".$tiplink."</span>";
//                                break;
//                            }
//                        }
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
                                    $seriesids_qry = "select seriesid , brandname , seriesname from [|PREFIX|]brand_series bs left join [|PREFIX|]brands b on bs.brandid = b.brandid where seriesid in (".$seriesids.")";
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
                                                    $series_link =    $subcatg_link."/series/".MakeURLSafe(Strtolower($seriesids_arr['seriesname']));        

                                                    $GLOBALS['CatgSeriesList'] .= "<a href='".$subcatg_link."/series/".MakeURLSafe(Strtolower($seriesids_arr['seriesname']))."' $tooltipscript>".$seriesids_arr['brandname']." ".$seriesids_arr['seriesname']."</a>";        
                                                }
                                                else
                                                {
                                                    $series_link =    $subcatg_link."&series=".MakeURLSafe(Strtolower($seriesids_arr['seriesname']));

                                                    $GLOBALS['CatgSeriesList'] .= "<a href='".$subcatg_link."&series=".MakeURLSafe(Strtolower($seriesids_arr['seriesname']))."' $tooltipscript>".$seriesids_arr['brandname']." ".$seriesids_arr['seriesname']."</a>";                
                                                }
                                            }

                                            $GLOBALS['CatgSeriesList'] .= "<span id='span".$row['categoryid'].$seriesids_arr['seriesid']."' style='display:none'><a class='thickbox1'  href='".$GLOBALS['ShopPath']."/catgbrand.php?seriesid=".$seriesids_arr['seriesid']."&catname=".MakeURLSafe($row['catname'])."&url=".urlencode($series_link)."' class='' ><img src='$path/templates/default/images/fastlook_red.gif' border=0></a></span>";

                                        }
                                            $GLOBALS['CatgSeriesList'] .= "</br></div>";
                                    }
                                    
                                }

                                $content = $row['brandname']."<br>";
                                
                                if( !isset($params['category']) && ( isset($params['srch_category']) || !isset($GLOBALS['BRAND_SERIES_FLAG']) ) ) {
                                    $GLOBALS['CatgDescandBrandImage'] = isset($catg_desc_arr['catdesc']) ? $catg_desc_arr['catdesc'] : ''; // description will be added here to show it at the top of subcatg page.
                                    $GLOBALS['CatgBrandSeriesFooter'] = isset($catg_desc_arr['categoryfooter']) ? $catg_desc_arr['categoryfooter'] : '';
                                    $content .= "<h3><a href='".$path."/search.php?$qry_string&subcategory=".MakeURLSafe($row['catname'])."'>".$row['catname']."</a></h3>>";
                                    $GLOBALS['TitleLink'] = "<h2><a href='".$subcatg_link."' onmouseover='createtip(".$row['categoryid'].")' onmouseout='UnTip()'>".$row['catname']."</a></h2>";
                                }

                                /*$ProdStartPrice = GetStartingPrice($row['categoryid'], $row['prodcalculatedprice']);
                                
                                $content .= "Price starting from $".number_format($ProdStartPrice, 2, '.', '')."<br>".$imagefile;*/
                                $GLOBALS['leftsidecontent'] = $content;
                                
                                if(number_format($row['prodminprice'], 2) < number_format($row['prodmaxprice'], 2))     {      
                                    $GLOBALS['PriceRange'] = "Price range from $".number_format($row['prodminprice'], 2, '.', '')." to $".number_format($row['prodmaxprice'], 2, '.', '');
                                }
                                else    {
                                    $GLOBALS['PriceRange'] = "Available at $".number_format($row['prodminprice'], 2, '.', '');    
                                }

                                $GLOBALS['Rating'] = isset($row['prodavgrating'])?$row['prodavgrating']:0;
								$GLOBALS['RatingVisible'] = $GLOBALS['Rating']==0 ? 'display:none':'';

                                $content = "<img src='$path/templates/default/images/free-shipping2.gif'><br>".strip_tags($row['proddesc'])."<br>".$row['prodwarranty'];
                                $GLOBALS['rightsidecontent'] = $content;

                                $GLOBALS['ShippingImage'] = "<img src='$path/templates/default/images/free-shipping2.gif'>";
                                $GLOBALS['ProductWarranty'] = "<h3>".$row['prodwarranty']."</h3>";

                                $GLOBALS['ViewDetailsImage'] = "<a href='$path/catgbrand.php?categoryid=".$row['categoryid']."&url=".urlencode($subcatg_link)."' class='thickbox'><img src='$path/templates/default/images/fastlook_red.gif'></a> ";
                                
                                $content = "$link<img src='$path/templates/default/images/viewproducts.gif'></a>";
                                $GLOBALS['ViewDetailsImage'] .= $content;

                                if(IsDiscountAvailable('category', $row['categoryid']))    {
                                    $GLOBALS['ViewDetailsImage'] .= '<img id="OnSale" src="'.GetConfig('ShopPath').'/templates/default/images/clearance.gif" alt="">'; 
                                }
								if($category_rating != 0)
								{
									$GLOBALS['CatgDescandBrandImage'] .= "<br><h2>Rating : <img width='64' height='12' src='".$GLOBALS['TPL_PATH']."/images/IcoRating$category_rating.gif' alt='' /></h2>";
								}
                                $GLOBALS['RatingHide'] = $category_rating == '0'?'none':'';
                                /*if($this->IsMakeAnOffer('category', $row['categoryid'])=='yes') 
                                {    
                                    $GLOBALS['ViewDetailsImage'] .= "<h3>Qualifies for Make an Offer!</h3>";
                                }*/

                                $GLOBALS['RelatedBrands'] = $row['featurepoints'];
                                
                                $GLOBALS['lowersidecontent'] = $content;
                    $GLOBALS['ClearanceList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ClearanceCategoryListing");
                }
				 
                $GLOBALS['ClearanceResults'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ClearanceCategoryListingMain");
                }
                else {
                    $GLOBALS['ClearanceResults'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ClearanceNorecords");
                }
            }
            else if( $flag == '2') { # For brand and series -- Baskaran
                    $brand_rating = 0;
                     
                     $serquery = $GLOBALS['ISC_CLASS_DB']->Query("select c.catname , c.categoryid , c.catuniversal , group_concat(DISTINCT ca.categoryid separator '~') as subcatgids , pa.catname as parentcatname , group_concat(DISTINCT brandname separator '~') as brandname , min(fp.prodfinalprice) as prodminprice , max(fp.prodfinalprice) as prodmaxprice , bs.seriesphoto as imagefile , p.proddesc , prodwarranty , bs.seriesname, p.brandseriesid , count(distinct p.productid) as totalproducts , bs.feature_points1 , bs.feature_points2 , bs.feature_points3 , bs.feature_points4 , bs.feature_points, b.brandimagefile , b.brandlargefile , b.branddescription , b.brandfooter, bs.serieshoverimagefile from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid LEFT JOIN [|PREFIX|]categoryassociations ca on ca.productid = p.productid LEFT JOIN [|PREFIX|]categories c on c.categoryid = ca.categoryid and c.catvisible = 1 LEFT JOIN [|PREFIX|]brands b on prodbrandid = b.brandid LEFT JOIN [|PREFIX|]brand_series AS bs ON bs.seriesid = p.brandseriesid LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid AND pi.imageisthumb=1) LEFT JOIN [|PREFIX|]product_finalprice fp ON p.productid = fp.productid LEFT JOIN [|PREFIX|]categories pa on pa.categoryid = c.catparentid WHERE 1=1 AND c.categoryid is not null AND p.prodvisible='1' $where AND p.prodbrandid IN ($brand_id) AND p.brandseriesid IN ($series_id) group by p.brandseriesid ORDER BY bs.seriessort ASC , bs.seriesname ASC");
                     $cnt = $GLOBALS['ISC_CLASS_DB']->CountResult($serquery);
                     if($cnt > '0') { 
                     while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($serquery)) {
                         $brand_rating_qry = "select avg(revrating) as rating from [|PREFIX|]reviews r left join [|PREFIX|]products p on r.revproductid = p.productid left join [|PREFIX|]brands b on p.prodbrandid = b.brandid  where r.revstatus = 1 and b.brandname = '".$row['brandname']."'";
                        $brand_rating_res = $GLOBALS['ISC_CLASS_DB']->Query($brand_rating_qry);
                        $brand_rating_arr = $GLOBALS['ISC_CLASS_DB']->FetchOne($brand_rating_res);
                        if( isset($brand_rating_arr['rating']) )
                        {
                            $brand_rating = (int)$brand_rating_arr['rating'];
                        }
                         $series_link = $this->LeftCatLink($mmy_links, 'series', $row['seriesname']);
                            $link = "<a href='".$series_link."'>";
                            //$imagelink = "<a href='".$path."/catgbrand.php?seriesid=".$row['brandseriesid']."&catname=".MakeURLSafe($row['parentcatname'])."&url=$series_link' class='thickbox' title=''>";

                            $main_catg_link = "";
                            $catg_count = array();
                            $GLOBALS['CatgSeriesList'] = "";
                            if($row['subcatgids'] != "") 
                            {
                                $subcatgids = str_ireplace("~",",",$row['subcatgids']);
                                $subcatgids_qry = "select c.categoryid , c.catname as childcatname , p.categoryid as parentid , p.catname as parentcatname from [|PREFIX|]categories c left join [|PREFIX|]categories p on c.catparentid = p.categoryid where c.categoryid in (".$subcatgids.")";
                                $subcatgids_res = $GLOBALS['ISC_CLASS_DB']->Query($subcatgids_qry);
                                //$catg_count = $GLOBALS['ISC_CLASS_DB']->CountResult($subcatgids_res);
                                if( $GLOBALS['ISC_CLASS_DB']->CountResult($subcatgids_res) > 0) {
                                    while($subcatgids_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($subcatgids_res))
                                    {
                                        if($subcatgids_arr['parentid'] != 0)
                                        {
                                            $main_catg_link    =    $series_link."/category/".MakeURLSafe(Strtolower($subcatgids_arr['parentcatname']));
                                            $catg_count[$subcatgids_arr['parentid']] = $subcatgids_arr['parentcatname'];
                                        }
                                        else
                                            $catg_count[$subcatgids_arr['categoryid']] = $subcatgids_arr['childcatname'];

                                        if($GLOBALS['CatgSeriesList'] == "")
                                        {
                                            $GLOBALS['CatgSeriesList'] .= "<br><a href='javascript:' onclick=\"checkanimate('".$row['brandseriesid']."')\">View Category ></a><div id='".$row['brandseriesid']."' style='display:none'>";
                                        } 
                                        else
                                        {    
                                            $GLOBALS['CatgSeriesList'] .= "<br>";        
                                        }

                                        $tooltipscript = "onmouseover='createtip(".$subcatgids_arr['categoryid'].$row['brandseriesid'].")' onmouseout='UnTip()'";

                                        if($GLOBALS['EnableSEOUrls'] == 1)
                                        {
                                            if($subcatgids_arr['parentcatname'] == "")
                                            {
                                                $catgs_link = $series_link."/category/".MakeURLSafe(Strtolower($subcatgids_arr['childcatname']));
                                            }
                                            else
                                            {
                                                $catgs_link = $series_link."/category/".MakeURLSafe(Strtolower($subcatgids_arr['parentcatname']))."/subcategory/".MakeURLSafe(Strtolower($subcatgids_arr['childcatname']));
                                            }

                                            $GLOBALS['CatgSeriesList'] .= "<a href='".$catgs_link."' $tooltipscript>".$subcatgids_arr['childcatname']."</a>";        
                                        } 
                                        else
                                        {
                                            if($subcatgids_arr['parentcatname'] == "")
                                            {
                                                $catgs_link = $series_link."&category=".MakeURLSafe(Strtolower($subcatgids_arr['childcatname']));
                                            }
                                            else
                                            {
                                                $catgs_link = $series_link."&category=".MakeURLSafe(Strtolower($subcatgids_arr['parentcatname']))."&subcategory=".MakeURLSafe(Strtolower($subcatgids_arr['childcatname']));
                                            }

                                            $GLOBALS['CatgSeriesList'] .= "<a href='".$catgs_link."' $tooltipscript>".$subcatgids_arr['childcatname']."</a>";        
                                        }

                                        $GLOBALS['CatgSeriesList'] .= "<span id='span".$subcatgids_arr['categoryid'].$row['brandseriesid']."' style='display:none'><a class='thickbox1'  href='".$GLOBALS['ShopPath']."/catgbrand.php?categoryid=".$subcatgids_arr['categoryid']."&url=".urlencode($catgs_link)."' class='' ><img src='$path/templates/default/images/fastlook_red.gif' border=0></a></span>";

                                    }
                                        $GLOBALS['CatgSeriesList'] .= "</br></div>";

                                }
                                
                            }
                            
                            $GLOBALS['TitleLink'] = "<h2><a href='".$series_link."' onmouseover='createtip(".$row['brandseriesid'].")' onmouseout='UnTip()'>".$row['brandname']." ".$row['seriesname']." ".$row['parentcatname']."</a></h2>";
                            if(count($catg_count) == 1)
                            {
                                $GLOBALS['TitleLink'] = "<h2><a href='".$main_catg_link."' onmouseover='createtip(".$row['brandseriesid'].")' onmouseout='UnTip()'>".$row['brandname']." ".$row['seriesname']." ".$row['parentcatname']."</a></h2>";
                            }
                            else if(count($catg_count) > 1)
                            {
                                $GLOBALS['TitleLink'] = "<h2><a href='".$series_link."' onmouseover='createtip(".$row['brandseriesid'].")' onmouseout='UnTip()' onclick='return checkcategoryselection()'>".$row['brandname']." ".$row['seriesname']." ".$row['parentcatname']."</a></h2>";
                            }


                            $tiplink = "<a class='thickbox1' href='".$GLOBALS['ShopPath']."/catgbrand.php?seriesid=".$row['brandseriesid']."&catname=".MakeURLSafe($row['parentcatname'])."&url=";
                            if(count($catg_count) == 1)
                            {
                                $tiplink .= urlencode($main_catg_link)."'";
                            }
                            else if(count($catg_count) > 1)
                            {
                                $tiplink .=    "#' ";
                            }
                            else
                            {
                                $tiplink .= urlencode($series_link)."'";
                            }
                            $tiplink .= " title=''><img src='$path/templates/default/images/fastlook_red.gif' border=0></a>";

                            $imagelink = "<a class='thickbox' href='".$GLOBALS['ShopPath']."/catgbrand.php?seriesid=".$row['brandseriesid']."&catname=".MakeURLSafe($row['parentcatname'])."&url=";
                            if(count($catg_count) == 1)
                            {
                                $imagelink .= urlencode($main_catg_link)."'";
                            }
                            else if(count($catg_count) > 1)
                            {
                                $imagelink .= "#' ";
                            }
                            else
                            {
                                $imagelink .= urlencode($series_link)."'";
                            }
                            $imagelink .= " title='' onmouseover='createtip(".$row['brandseriesid'].")' onmouseout='UnTip()'>";
                            
                            if(isset($row['imagefile']) && !empty($row['imagefile'])) {
                                $images = explode("~",$row['imagefile']);
//                                for($j=0;$j<count($images);$j++) {
//                                    if(!empty($images[$j])) {
                                        $imagefile =  "$imagelink<img src='$path/series_images/".$row['imagefile']."'></a>";
//                                        break;
//                                    }
//                                }
                            } else if(empty($row['imagefile']) || empty($imagefile))
                                    $imagefile = "$imagelink<img src='$path/templates/default/images/ProductDefault.gif' border=0></a>";              

                            $GLOBALS['LeftImage'] = $imagefile;
                                    
                            $row['brandname'] = str_replace('~',' , ',$row['brandname']);
                            $GLOBALS['RelatedBrands'] = $row['brandname'];
                            
                            if(isset($row['seriesname']) && !empty($row['seriesname']) && ( !isset($params['srch_category']) || isset($params['category']) ) && isset($GLOBALS['BRAND_SERIES_FLAG'])) {

                                if(empty($row['imagefile']) || empty($imagefile))
                                {
                                        $GLOBALS['LeftImage'] = "$imagelink<img src='$path/templates/default/images/ProductDefault.gif'  alt='".isc_html_escape($row['seriesimagealt'])."' title='".isc_html_escape($row['seriesimagealt'])."'></a>";
                                        $GLOBALS['LeftImage'] .= "<span id='span".$row['brandseriesid']."' style='display:none'>".$tiplink."</span>";
                                }
                                else
                                {
                                        $GLOBALS['LeftImage'] = "$imagelink<img src='$path/series_images/".$row['imagefile']."' width='140px'  alt='".isc_html_escape($row['seriesimagealt'])."' title='".isc_html_escape($row['seriesimagealt'])."'></a>";
                                        $GLOBALS['LeftImage'] .= "<span id='span".$row['brandseriesid']."' style='display:none'>".$tiplink."</span>";
                                }
                                
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
                                
                            }

                            $GLOBALS['RelatedBrands'] = $row['feature_points'];

                            $GLOBALS['CatgDescandBrandImage'] = $row['branddescription'];
                            $GLOBALS['CatgBrandSeriesFooter'] = $row['brandfooter'];

                            if($brand_rating != 0)
                            {
                                $GLOBALS['CatgDescandBrandImage'] .= "<br><h2>Rating : <img width='64' height='12' src='".$GLOBALS['TPL_PATH']."/images/IcoRating$brand_rating.gif' alt='' /></h2>";
                            }
                            $GLOBALS['RatingHide'] = $brand_rating == '0'?'none':'';
                            $content = $row['brandname']."<br>";
                            
                            $content .= $row['catname']."<br>";
                            
                            /*$ProdStartPriceSeries = GetStartingPriceForSeries($row['brandseriesid'], $row['prodcalculatedprice']);
                            
                            $content .= "Price starting from $".number_format($ProdStartPriceSeries, 2, '.', '');*/
                            $GLOBALS['leftsidecontent'] = $content;
                            
                            //$GLOBALS['PriceRange'] = "Price range from $".number_format($row['prodminprice'], 2, '.', '')." to $".number_format($row['prodmaxprice'], 2, '.', '');
                            
                            if(number_format($row['prodminprice'], 2) < number_format($row['prodmaxprice'], 2))     {      
                                $GLOBALS['PriceRange'] = "Price range from $".number_format($row['prodminprice'], 2, '.', '')." to $".number_format($row['prodmaxprice'], 2, '.', '');
                            }
                            else    {
                                $GLOBALS['PriceRange'] = "Available at $".number_format($row['prodminprice'], 2, '.', '');    
                            }
                            
                            $GLOBALS['Rating'] = isset($row['prodavgrating'])?$row['prodavgrating']:0;
							$GLOBALS['RatingVisible'] = $GLOBALS['Rating']==0 ? 'display:none':'';

                            $content = "<img src='$path/templates/default/images/free-shipping2.gif'><br>".strip_tags($row['proddesc'])."<br>".$row['prodwarranty'];
                            $GLOBALS['rightsidecontent'] = $content;

                            $GLOBALS['ShippingImage'] = "<img src='$path/templates/default/images/free-shipping2.gif'>";
                            $GLOBALS['ProductWarranty'] = "<h3>".$row['prodwarranty']."</h3>";
                            
                            $GLOBALS['ViewDetailsImage'] = "<a class='thickbox' href='".$GLOBALS['ShopPath']."/catgbrand.php?seriesid=".$row['brandseriesid']."&catname=".MakeURLSafe($row['parentcatname'])."&url=";
                            if(count($catg_count) > 1)
                                $GLOBALS['ViewDetailsImage'] .= "#'";
                            else if(count($catg_count) == 1)
                                $GLOBALS['ViewDetailsImage'] .= urlencode($main_catg_link)."'";
                            else
                                $GLOBALS['ViewDetailsImage'] .= urlencode($series_link)."'";
                            $GLOBALS['ViewDetailsImage'] .= "><img src='$path/templates/default/images/fastlook_red.gif'></a> ";

                            $content = "$link";
                            if(count($catg_count) == 1)
                            {
                                $content = "<a href='".$main_catg_link."'>";
                            }
                            else if(count($catg_count) > 1)
                            {
                                $content = "<a href='".$series_link."' onclick='return checkcategoryselection()'>";
                            }
                            $content .= "<img src='$path/templates/default/images/viewproducts.gif'></a>";

                            $GLOBALS['ViewDetailsImage'] .= $content;

                            if(IsDiscountAvailable('series', $row['brandseriesid']))    {
                                $GLOBALS['ViewDetailsImage'] .= '<img id="OnSale" src="'.GetConfig('ShopPath').'/templates/default/images/clearance" alt="">'; 
                            } 
                            
                           /* if($this->IsMakeAnOffer('series', $row['brandseriesid'])=='yes') 
                            {    
                                $GLOBALS['ViewDetailsImage'] .= "<h3>Qualifies for Make an Offer!</h3>";
                            } */
                             
                            $GLOBALS['lowersidecontent'] = $content;
                            
                            $GLOBALS['ClearanceList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ClearanceCategoryListing");
                            
                            $GLOBALS['HideCompareItems'] = "none";
                   }

                $GLOBALS['ClearanceResults'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ClearanceCategoryListingMain");
            }
            else {
                    $GLOBALS['ClearanceResults'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ClearanceNorecords");
                }
            }
			else {
				$GLOBALS['ClearanceResults'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ClearanceNorecords");
			}
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
											if(strtoupper($filter_value) != "NON-SPEC VEHICLE" && strtolower($filter_value) != "all")
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

		/**
	 * @desc Create YMM links
	 * @params search paramsters
	 */
	 function GetYMMLinks($params)
	 {
		$NewLink = '';

		
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
		}

		return $NewLink;
	 }

    }
?>
