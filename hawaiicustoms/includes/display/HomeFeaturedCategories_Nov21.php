<?php

	CLASS ISC_HOMEFEATUREDCATEGORIES_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{
			
			$count = 0;
			$GLOBALS['SNIPPETS']['HomeFeaturedCategories'] = '';

            $categories = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('RootCategories');           
            
			if (GetConfig('HomeFeaturedCategories') > 0) {
				if(GetConfig('EnableProductReviews') == 0) {
					$GLOBALS['HideProductRating'] = "display: none";
				}  
				//$query = " SELECT cat.categoryid, cat.catname,  FROM [|PREFIX|]categories cat  WHERE cat.catpopular = '1'  ORDER BY RAND()";
                //
                $query = " SELECT c.catname, c.catimagefile, c.categoryid, c.catuniversal,c.catparentid, MIN(p.prodcalculatedprice) AS prodcalculatedprice, p.prodvisible RootVisible, sp.prodvisible SubVisible,
                MIN(sp.prodcalculatedprice) AS subprodcalculatedprice
                FROM isc_categories c                                                 
                LEFT JOIN isc_categoryassociations ca ON c.categoryid = ca.categoryid 
                LEFT JOIN isc_products p ON ca.productid = p.productid AND p.prodvisible='1'
                LEFT JOIN isc_categories sc ON sc.catparentid = c.categoryid AND sc.catvisible = 1     
                LEFT JOIN isc_categoryassociations sca ON sc.categoryid = sca.categoryid 
                LEFT JOIN isc_products sp ON sca.productid = sp.productid AND sp.prodvisible='1' 
                WHERE 1=1 
                AND c.catvisible = 1
                AND (p.prodvisible='1' || sp.prodvisible='1' )
                AND c.catpopular = '1'
                GROUP BY c.categoryid ORDER BY c.catname "; 
                              
				$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, GetConfig('HomeFeaturedCategories'));

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                
				if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
					$GLOBALS['AlternateClass'] = '';
					while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

						if($GLOBALS['AlternateClass'] == 'Odd') {
							$GLOBALS['AlternateClass'] = 'Even';
						}
						else {
							$GLOBALS['AlternateClass'] = 'Odd';
						}
                        $path = GetConfig('ShopPath');  
                        $CatLink = "$path/search.php?search_query=".urlencode($row['catname']);     
						$GLOBALS['CategoryName'] = isc_html_escape($row['catname']);
						$GLOBALS['CategoryLink'] = $CatLink;
						$categoryid = $row['categoryid'];
						$catparentid = $row['catparentid'];



                        if($row['SubVisible'] && $row['RootVisible'])    {
                            $Price = min($row['prodcalculatedprice'], $row['subprodcalculatedprice']);
                        }
                        else if($row['RootVisible'])   {
                            $Price = $row['prodcalculatedprice'];
                        }
                        else if($row['SubVisible'])   {
                            $Price = $row['subprodcalculatedprice'];
                        }




						if ($Price < 100 and $row['catuniversal'] == 1 )
												{

						//check whether it is non-universal
						if ($catparentid != 0)
							{
							$query4 = "SELECT catuniversal FROM isc_categories  WHERE  categoryid  = '".$catparentid."' ";
							$result4 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
							$row4 = $GLOBALS['ISC_CLASS_DB']->Fetch($result4);
							$catuniversal = $row4['catuniversal'];
							if ($catuniversal == 0)
													{
										//need to find out the lowest starting-from-price among the non-universal subcategories in the same category, 
										$query2 ="SELECT min(prodcalculatedprice) as minsubprice FROM [|PREFIX|]products p LEFT JOIN isc_categoryassociations ca ON p.productid  = ca.productid  LEFT JOIN isc_categories c ON ca.categoryid  = c.categoryid  WHERE  c.catparentid   = '".$catparentid."'  and c.catuniversal = 0 ";
										$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
										$row2 = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
										$nonuniversal_minsubprice = $row2['minsubprice'];

										//When looking for the starting-from-price of the universal subcategory, any price less than (50% X $a) should be ignored.
										$query2 ="SELECT min(prodcalculatedprice) as minsubprice FROM [|PREFIX|]products p LEFT JOIN isc_categoryassociations ca ON p.productid  = ca.productid  LEFT JOIN isc_categories c ON ca.categoryid  = c.categoryid  WHERE  c.catparentid   = '".$catparentid."'  and c.catuniversal = 1 ";
										$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
										$row2 = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
										$universal_minsubprice = $row2['minsubprice'];

										if ($universal_minsubprice >= ($nonuniversal_minsubprice / 2) )
													{

													$price = min($nonuniversal_minsubprice, $universal_minsubprice);

													}


								}


							}
	

						}



						// Determine the price of this product
						$DisStartPrice = number_format($Price, 2, '.', '');
						$GLOBALS['CategoryPrice'] = "Price starting from $".$DisStartPrice;
                        $imageThumb = '';
                        $GLOBALS['CategoryThumb'] = '';
                        if(file_exists(ISC_BASE_PATH.'/category_images/'.$row['catimagefile']) && $row['catimagefile']!='')    {
						    //$GLOBALS['CategoryThumb'] = ImageThumb($row['catimagefile'], $CatLink);
                            $imageThumb .= '<a href="'.$CatLink.'" >';  
                            $imageThumb .= '<img src="'.$GLOBALS['ShopPath'].'/category_images/'.$row['catimagefile'].'" alt="" />';     
                            $imageThumb .= '</a>';
                            $GLOBALS['CategoryThumb'] = $imageThumb;
                        }
						else
						{

						
						$thumb = GetConfig('ShopPath').'/templates/'.GetConfig('template').'/images/ProductDefault.gif';
						$thumbImage = '<img src="'.$thumb.'" alt="" />';
                        $thumbImage .= '<noscript>'.ISC_BASE_PATH.'/category_images/'.$row['catimagefile']."</noscript>";
						$GLOBALS['CategoryThumb'] = $thumbImage;

						}

                        
						$GLOBALS['SNIPPETS']['HomeFeaturedCategories'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("HomeFeaturedCategoriesItem");
					}
				} else {
					$this->DontDisplay = true;
					$GLOBALS['HideHomeFeaturedProductsPanel'] = "none";
				}
			} else {
				$this->DontDisplay = true;
				$GLOBALS['HideHomeFeaturedProductsPanel'] = "none";
			}
		}
	}

?>
