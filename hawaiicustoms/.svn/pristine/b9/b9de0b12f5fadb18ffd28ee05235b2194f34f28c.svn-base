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
                $query = " SELECT c.catname, c.catimagefile, c.categoryid, MIN(p.prodcalculatedprice) AS prodcalculatedprice, p.prodvisible RootVisible, sp.prodvisible SubVisible,
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

                        if($row['SubVisible'] && $row['RootVisible'])    {
                            $DisStartPrice = number_format(min($row['prodcalculatedprice'], $row['subprodcalculatedprice']), 2, '.', '');
                        }
                        else if($row['RootVisible'])   {
                            $DisStartPrice = number_format($row['prodcalculatedprice'], 2, '.', '');
                        }
                        else if($row['SubVisible'])   {
                            $DisStartPrice = number_format($row['subprodcalculatedprice'], 2, '.', '');
                        }

						// Determine the price of this product
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
