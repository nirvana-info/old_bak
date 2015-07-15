<?php

CLASS ISC_SIDESHOPBYBRAND_PANEL extends PANEL
{
	var $cacheable = true;
	var $cacheId = "brands.products.sideshopbybrand";

	function SetPanelSettings()
	{
		$output = "";
		$GLOBALS['ISC_CategoryBrandCache'] = GetClass('ISC_CACHECATEGORYBRANDS');
		$cachedCategoryBrands = $GLOBALS['ISC_CategoryBrandCache']->getCategoryBrandsData();
		//var_export($cachedCategoryBrands);
		$mybrands = $GLOBALS['ISC_CategoryBrandCache']->GetBrandsIndexpage($cachedCategoryBrands);
		//$mycategorys = $GLOBALS['ISC_CategoryBrandCache']->GetAllCategories($cachedCategoryBrands);
		//$mysubcategorys = $GLOBALS['ISC_CategoryBrandCache']->GetSubCategories($cachedCategoryBrands);
		//$myCategoryBrands = $GLOBALS['ISC_CategoryBrandCache']->GetCategoryBrands($cachedCategoryBrands);
		//var_dump($mycategorys);
		
		$path = GetConfig('ShopPath');
		// Get the link to the "all brands" page
		$GLOBALS['AllBrandsLink'] = BrandLink();
		
		//wirror20110328: show arrow image
		$GLOBALS['arrowimage'] = "<img src='$path/templates/default/images/imgHdrDropDownIcon.gif' border='0' id='brand_listimage'/>";
		
		/*// Get the 10 most popular brands
		$query = "SELECT brandid, brandname, COUNT(*) AS num
			FROM [|PREFIX|]brands b, [|PREFIX|]products p
			WHERE p.prodbrandid = b.brandid
			AND prodvisible=1
			GROUP BY prodbrandid
			ORDER BY brandname ASC
			";
		//$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 10+1);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);*/
		$extra_output = ""; // for brands exceeding more than 10
		$x = 1;
		foreach ($mybrands as $brand) {
			
				//$GLOBALS['BrandLink'] = BrandLink($row['brandname']);
				$GLOBALS['BrandLink'] = $this->LeftBrandLink($brand['brandname']);                        //Added by Simha
				$GLOBALS['BrandName'] = isc_html_escape($brand['brandname']);
			if($x <= 10) {
				$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ShopByBrandItem");
			} else {
				$extra_output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ShopByBrandItem");
			}
			++$x;
		}

		if($x > 11) {
			$GLOBALS['FilterID'] = "brand";
            $GLOBALS['ExtraValues'] = $extra_output;
            $GLOBALS['SNIPPETS']['ShopByBrandAllItem'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideFilterMoreLink"); 
			//$GLOBALS['SNIPPETS']['ShopByBrandAllItem'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ShopByBrandAllItem");
		}

		if(!$output) {
			$this->DontDisplay = true;
		}

		$output = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output, $GLOBALS['SNIPPETS']);
		$GLOBALS['SNIPPETS']['SideShopByBrandList'] = $output;
	}

	/**
    * @desc Create Brand links
    * @params Brandname
    */
    function LeftBrandLink($BrandName)
    {
        $NewLink = '';
        if ($GLOBALS['EnableSEOUrls'] == 1) {
            $NewLink = sprintf("%s/%s", GetConfig('ShopPath'), MakeURLSafe(strtolower($BrandName)));
        } else {
            $NewLink = sprintf("%s/search.php?search_query=%s", GetConfig('ShopPath'), MakeURLSafe($BrandName));
        }
        return $NewLink;
    }


}

?>