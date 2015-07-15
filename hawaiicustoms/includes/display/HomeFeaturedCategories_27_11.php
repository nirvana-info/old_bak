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
				
                $result = $this->GetPopularCategories();
                
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
                        //$CatLink = "$path/search.php?search_query=".urlencode($row['catname']);     
						$GLOBALS['CategoryName'] = isc_html_escape($row['catname']);
						$CatLink = $this->LeftCatLink($GLOBALS['CategoryName']);   
                        $GLOBALS['CategoryLink'] = $CatLink;
                        /*
                        if($row['SubVisible'] && $row['RootVisible'])    {
                            $DisStartPrice = number_format(min($row['prodcalculatedprice'], $row['subprodcalculatedprice']), 2, '.', '');
                        }
                        else if($row['RootVisible'])   {
                            $DisStartPrice = number_format($row['prodcalculatedprice'], 2, '.', '');
                        }
                        else if($row['SubVisible'])   {
                            $DisStartPrice = number_format($row['subprodcalculatedprice'], 2, '.', '');
                        }
                        */
                        
                        $DisStartPrice = number_format($row['prodcalculatedprice'], 2, '.', '');   
                        
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
                        else
                        {
                            $thumb = GetConfig('ShopPath').'/templates/'.GetConfig('template').'/images/ProductDefault.gif';
                            $thumbImage = '<img src="'.$thumb.'" alt="" />';                                                     
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
        
        function GetPopularCategories()  {   

            $aquery   = array();   

            $aquery[] = "CREATE TEMPORARY TABLE temp
                        SELECT ca.categoryid, MIN(p.prodcalculatedprice) AS prodcalculatedprice 
                        FROM isc_products p
                        INNER JOIN isc_categoryassociations ca ON p.productid = ca.productid
                        WHERE prodvisible='1' GROUP BY ca.categoryid";

            $aquery[] = "CREATE TEMPORARY TABLE cats
                        SELECT DISTINCT c.categoryid, c.catname, c.catimagefile, t.prodcalculatedprice
                        FROM temp t
                        INNER JOIN isc_categories c ON t.categoryid = c.categoryid
                        WHERE c.catvisible = 1 AND c.catpopular=1";

            $aquery[] = "INSERT INTO cats
                        SELECT DISTINCT c.categoryid, c.catname, c.catimagefile, t.prodcalculatedprice
                        FROM isc_categories sc
                        INNER JOIN temp t ON t.categoryid = sc.categoryid
                        INNER JOIN isc_categories c ON sc.catparentid = c.categoryid
                        WHERE c.catvisible = 1 AND c.catpopular=1";
                    
            for($i=0; $i<count($aquery); $i++)
            {
                $result = $GLOBALS['ISC_CLASS_DB']->Query($aquery[$i]); 
            }

            $query  = "SELECT catname, categoryid, catimagefile, MIN(prodcalculatedprice) AS prodcalculatedprice 
                        FROM cats GROUP BY categoryid ORDER BY catname";
                        
            $query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, GetConfig('HomeFeaturedCategories'));
                    
            $popularcatresult = $GLOBALS['ISC_CLASS_DB']->Query($query);        

            /*
            $validcats = array();

            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $validcats[] = $row;  
            }
            */
            $aquery   = array();
            $aquery[] = "DROP TABLE cats";
            $aquery[] = "DROP TABLE temp";

            for($i=0; $i<count($aquery); $i++)
            {
                $result = $GLOBALS['ISC_CLASS_DB']->Query($aquery[$i]); 
            }
             
            return $popularcatresult;
          
        }
        
        
        /**
        * @desc Create Category links
        * @params Rootcatname
        */
        function LeftCatLink($RootCatName)
        {
            $NewLink = '';
            if ($GLOBALS['EnableSEOUrls'] == 1) {
                $NewLink = sprintf("%s/%s/", GetConfig('ShopPath'), MakeURLSafe($RootCatName));
            } else {
                $NewLink = sprintf("%s/search.php?search_query=%s", GetConfig('ShopPath'), MakeURLSafe($RootCatName));
            }
            return $NewLink;
        }
        
        
	}

?>
