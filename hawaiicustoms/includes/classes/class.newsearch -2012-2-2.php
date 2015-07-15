<?php

/**
 * *********  Revise History  ********
 * lguan_20100525: Log YMM with smart search statics logging
 *
 *
 */

class ISC_NEWSEARCH
{

	var $_pagetitle = "";
	var $_searchterms = array();
	var $_numresults = 0;
	var $_numpages = 0;
	var $_currentpage = 1;

	function __construct()
	{
		/*if($GLOBALS['EnableSEOUrls'] == 1)
			{
			$url_array = split('/', strtolower($_SERVER['REQUEST_URI']));
			$searchlogid = $url_array[array_search('searchlogid', $url_array, true)+1];
			}
			else
			{
			$searchlogid = $_GET['SearchLogId'];
			}
			if( $searchlogid > 0 )
			UpdateSearchLogforBestKeyWord($searchlogid);*/
			
		$this->_SetSearchData();
	}

	function HandlePage()
	{
		$action = "";
		if (isset($_REQUEST['action'])) {
			$action = isc_strtolower($_REQUEST['action']);
		}
		
		switch ($action) {
			case "tips": {
				$this->ShowSearchTips();
				break;
			}
			case "ajaxsearch": {
				$this->DoAjaxSearch();
				break;
			}
			case "tracksearchclick": {
				$this->TrackSearchClick();
				break;
			}
			default: {
				$this->ShowSearchPage();
			}
		}
	}

	/**
		*	Return the number of results from a search
		*/
	function GetNumResults()
	{
		return $this->_numresults;
	}

	/**
		*	Return the number of pages
		*/
	function GetNumPages()
	{
		return $this->_numpages;
	}

	/**
		*	Return the page we're currently on
		*/
	function GetPage()
	{
		return $this->_currentpage;
	}

	/**
		*	Return the search query
		*/
	function GetQuery()
	{
		return $this->_searchterms;
	}

	function _SetSearchData()
	{
		if($GLOBALS['EnableSEOUrls'] == 1 && !empty($GLOBALS['PathInfo'])) {  // checking seo is enabled and pathinfo is not empty as pathinfo will be set only when redirected to index page
			$count_pathinfo = count($GLOBALS['PathInfo']); // to get the count of the parameter, i.e if its odd, query string is applied.
			
			if( $count_pathinfo % 2 == 0 ) {
				//wirror_20100913: when the smartsearch is set with empty keyword
				if($GLOBALS['PathInfo'][0] == 'is_smart_search'|| $GLOBALS['PathInfo'][0] != 'search')
				$_REQUEST['search_query'] = '';
				else
				$_REQUEST['search_query'] = MakeURLNormal($GLOBALS['PathInfo'][1]);
				for($i=0;$i<count($GLOBALS['PathInfo']);$i+=2)
				{
					if($GLOBALS['PathInfo'][$i+1] != '')
					$_REQUEST[$GLOBALS['PathInfo'][$i]] = MakeURLNormal($GLOBALS['PathInfo'][$i+1]);
				}
			} else {
				$_REQUEST['search_query'] = MakeURLNormal($GLOBALS['PathInfo'][0]);
				for($i=1;$i<count($GLOBALS['PathInfo']);$i+=2)
				{
					if($GLOBALS['PathInfo'][$i+1] != '')
					$_REQUEST[$GLOBALS['PathInfo'][$i]] = MakeURLNormal($GLOBALS['PathInfo'][$i+1]);
				}
			}
			

		} else { // this condition is entered when seo is disabled. also in redefine search this will be accessed.

			if(!isset($_REQUEST['search_key']))
			{
				foreach($_GET as $key => $value){
					$_GET[$key] = MakeURLNormal($value);
					$_REQUEST[$key] = MakeURLNormal($value);
				}
			}

		}
		
		// if user visit home page,then clear the sear query.
		if($_SERVER["REQUEST_URI"] == "/")
		{
			$_REQUEST['search_query'] = "";
		}
		
		//wirror_20110330
		if(isset($_REQUEST['brand']) && isset($_REQUEST['category'])){
			$_REQUEST['search_query'] = $_REQUEST['brand'];
		}
		
		if (isset($_REQUEST['search_query_adv'])) {
			$_GET['search_query'] = $_REQUEST['search_query'] = $_REQUEST['search_query_adv'];
		}
		
		if (isset($_REQUEST['search_query'])) {

			// Set the incoming search terms
			//alandy mark.init search params.
			$this->_searchterms = $this->BuildProductSearchTerms2($_REQUEST);
			//var_dump($this->_searchterms);exit;
			$this->CheckSeriesFlag();
			//check if ymm already in search keywords
			//if so overwrite ymm in url
			/*$tmpRequest = $_REQUEST;
				unset($tmpRequest["make"]);
				unset($tmpRequest["year"]);
				unset($tmpRequest["model"]);
				$tmpTerms = BuildProductSearchTerms($tmpRequest);
				$this->_searchterms = BuildProductSearchTerms($_REQUEST);

				if( isset($tmpTerms["year"]) && $this->_searchterms["year"] !== $tmpTerms["year"] )
				{
				$this->_searchterms["year"] = $tmpTerms["year"];
				setcookie( "last_search_selection[year]", $this->_searchterms["year"], $date_of_expiry ,"/");
				}
				if( isset($tmpTerms["make"]) && $this->_searchterms["make"] !== $tmpTerms["make"])
				{
				$this->_searchterms["make"] = $tmpTerms["make"];
				setcookie( "last_search_selection[make]", $this->_searchterms["make"], $date_of_expiry ,"/");
				if( isset($tmpTerms["model"]) && $this->_searchterms["model"] !== $tmpTerms["model"])
				{
				$this->_searchterms["model"] = $tmpTerms["model"];
				$this->_searchterms["model_flag"] = 1;
				setcookie( "last_search_selection[model]", $this->_searchterms["model"], $date_of_expiry ,"/");
				setcookie( "last_search_selection[model_flag]", 1, $date_of_expiry ,"/");
				}
				}*/
			//wirror_20110520:Product detail page: "Products" shows up in smart search box
			if(isset($_REQUEST['is_smart_search'])){
				$OriginalSearchQuery = $_REQUEST['search_query'];
			}else if($_REQUEST['SearchLogId']){
				$search_text_query = "select searchtext from [|PREFIX|]searches_extended WHERE searchid='".$GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['SearchLogId'])."'";
				$search_text_result = $GLOBALS['ISC_CLASS_DB']->Query($search_text_query);
				$OriginalSearchQuery = $GLOBALS['ISC_CLASS_DB']->FetchOne($search_text_result);
			}else{
				$OriginalSearchQuery = '';
			}
			$GLOBALS['OriginalSearchQuery'] = ucwords(isc_html_escape(html_entity_decode($OriginalSearchQuery)));
			$GLOBALS['FormattedSearchQuery'] = isc_html_escape($this->_searchterms['search_query']);
			$GLOBALS['SearchTitle'] = sprintf(GetLang('SearchResultsFor'), $GLOBALS['OriginalSearchQuery']);
			$this->_pagetitle = sprintf(GetLang('SearchSimpleTitle'), GetConfig('StoreName'), $GLOBALS['SearchTitle']);
			
		}
		else {
			// No search query set, show the advanced search form
			$GLOBALS['SearchTitle'] = sprintf(GetLang('SearchXStore'), $GLOBALS['StoreName']);
			$this->_pagetitle = sprintf(GetLang('SearchAdvancedTitle'), GetConfig('StoreName'));

		}
	}
	
	function CheckSeriesFlag()
	{
	/*$brandWhere = "";
		if (isset( $this->_searchterms['brand']) &&  $this->_searchterms['brand'] != "") {
			$brand_query = "select brandid from [|PREFIX|]brands WHERE brandname='". $this->_searchterms['brand']."'";
			$brand_result = $GLOBALS['ISC_CLASS_DB']->Query($brand_query);
			$brandId = $GLOBALS['ISC_CLASS_DB']->FetchOne($brand_result);
			if((int)$brandId > 0)
			{
				$qualifier_flag = 1;
				$brandWhere =  " and p.prodbrandid='" . $GLOBALS['ISC_CLASS_DB']->Quote($brandId) . "'";
			}
		}*/
		
		$queryWhere = $this->GetWhereBySearchItems($outer_condition,$havingquery);
		if(!empty($havingquery))
		{
			$queryWhere[] = implode(' AND ', $havingquery);
			unset($havingquery);
		}
		
		//$queryWhere = array_filter($queryWhere,"myclear");
		
		$where2 = "";
		if(count($queryWhere) > 0)
		{
			$where2 .=" and " .implode(' AND ', $queryWhere);
		}
		
		/* the below query is used to check whether any series exist under the selected brand */
		if( isset($this->_searchterms['flag_srch_brand']) &&  $this->_searchterms['flag_srch_brand'] == 0  && !empty($this->_searchterms['brand'])) {

			$brand_series_qry = "select p.brandseriesid from isc_products p LEFT JOIN isc_categoryassociations ca on ca.productid = p.productid LEFT JOIN isc_categories c on c.categoryid = ca.categoryid LEFT JOIN isc_import_variations AS v ON p.productid = v.productid
WHERE prodbrandid in(select brandid from [|PREFIX|]brands WHERE brandname='". $this->_searchterms['brand']."')  and brandseriesid != 0 $where2 $outer_condition group by brandseriesid";
		
			
			$brand_series_res = $GLOBALS['ISC_CLASS_DB']->Query($brand_series_qry);
			if($GLOBALS['ISC_CLASS_DB']->CountResult($brand_series_res) > 0)
			$GLOBALS['BRAND_SERIES_FLAG'] = 0;     // series exist under a brand
			else
			$GLOBALS['BRAND_SERIES_FLAG'] = 1;     // series not exist under a brand

		}
	}

	function TrackSearchClick()
	{
		if (!isset($_GET['searchid'])) {
			exit;
		}

		// Update the search click to record a visit to a product
		$query = sprintf("update [|PREFIX|]searches_extended set clickthru='1' where searchid='%d'", (int)$_GET['searchid']);
		$GLOBALS['ISC_CLASS_DB']->Query($query);
		echo 1;
		exit;
	}

	function DoAjaxSearch()
	{
		if (isset($_GET['search_query']) && isc_strlen($_GET['search_query']) >= 3) {
			$searchterms = BuildProductSearchTerms($_REQUEST);

			// Build the search query using our terms & the fields we want
			$searchQueries = BuildProductSearchQuery($searchterms);

			$Search_Count = $GLOBALS['ISC_CLASS_DB']->FetchOne($searchQueries['countQuery']);

			// No results?
			if ($Search_Count == 0) {
				exit;
			}

			// Add the limit
			$searchQueries['query'] .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 5);
			$Search_Result = $GLOBALS['ISC_CLASS_DB']->Query($searchQueries['query']);
			while ($product = $GLOBALS['ISC_CLASS_DB']->Fetch($Search_Result)) {
				$product['imagefile'] = '';
				$products[$product['productid']] = $product;
			}

			// Fetch product images
			$productids = implode(",", array_keys($products));
			$query = sprintf("select imageprodid, imagefile from [|PREFIX|]product_images where imageprodid in (%s) and imageisthumb=2", $GLOBALS['ISC_CLASS_DB']->Quote($productids));
			$Result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($productimage = $GLOBALS['ISC_CLASS_DB']->Fetch($Result)) {
				$products[$productimage['imageprodid']]['imagefile'] = $productimage['imagefile'];
			}


			$view_all = '';
			if ($Search_Count > 5) {
				$view_all = sprintf(' view_all="%s"', $this->EscapeEntity(sprintf('<a href="%s/search.php?search_query=%s">%s &raquo;</a>', $GLOBALS['ShopPathNormal'], $_REQUEST['search_query'], GetLang('QuickSearchViewAll'))));
			}
			echo '<?xml version="1.0"?>'."\n";
			echo sprintf('<results type="%s" result_count="%s"%s>'."\n", GetLang('QuickSearchProducts'), $Search_Count, $view_all);
			foreach ($products as $product) {
				if ($product['imagefile']) {
					$image =  sprintf("%s/%s/%s", $GLOBALS['ShopPathNormal'], GetConfig('ImageDirectory'), $product['imagefile']);
				} else {
					$image = GetLang('QuickSearchNoImage');
				}
				if(GetConfig('EnableProductReviews')) {
					$ratingimg = sprintf("%s/images/IcoRating%s.gif", $GLOBALS['TPL_PATH'], (int)$product['prodavgrating']);
				}
				else {
					$ratingimg = '';
				}
				echo sprintf('<result title="%s" price="%s" url="%s" image="%s" ratingimg="%s" />'."\n", $this->EscapeEntity($product['prodname']), $this->EscapeEntity(CalculateProductPrice_retail($product)), ProdLink($product['prodname']), $this->EscapeEntity($image), $this->EscapeEntity($ratingimg));
			}
			echo "</results>\n";
		}
	}

	function EscapeEntity($string)
	{
		return str_replace(array('&', '"', '<', '>'), array( '&amp;','&quot;', '&lt;', '&gt;'), $string);
	}

	/**
		*	Is $Word a word that's saved in the product_words table? If so we wont spell check it because it's
		*	part of a product's name and we can assume it's spelled correctly already
		*/
	function IsProductWord($Word)
	{
		$query = sprintf("select count(wordid) as num from [|PREFIX|]product_words where lower(word)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($Word));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

		if ($row['num'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	/**
		*	If pSpell is installed the we can run a spell check and suggest on their search keywords
		*	if it's enabled from the settings page and pSpell is installed
		*/
	function Suggest($sentence, &$has_suggestion, &$changed_words)
	{
		/* --- this below patch is for getting alternate keywords as per client request ---- starts ---*/
		
		if(!empty($this->_searchterms['srch_category'])) {
			$words = explode(" ", $sentence);
			$has_suggestion = false;
			$GetAltkey_query = "select cataltkeyword from isc_categories where categoryid in ( ".implode(',',$this->_searchterms['srch_category'])." )";
			$GetAltkey_result = $GLOBALS['ISC_CLASS_DB']->Query($GetAltkey_query);
			while($GetAltkey_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($GetAltkey_result)) {
				if(!empty($GetAltkey_arr['cataltkeyword'])) {
					$changed_words[] = $GetAltkey_arr['cataltkeyword'];
					$has_suggestion = true;
				}
			}
			return implode(" ", $changed_words);
		} else {
			$has_suggestion = false;
			return $sentence;
		}
		/* --- this below patch is for getting alternate keywords as per client request ---- ends ---*/

		if (function_exists("pspell_new") && GetConfig('SearchSuggest')) {
			$spell = @pspell_new("en");
			if ($spell === false) {
				return $sentence;
			}
			$words = explode(" ", $sentence);
			
			$word_count = 0;
			$has_suggestion = false;

			foreach ($words as $word) {
				if (!pspell_check($spell, $word) && !$this->IsProductWord(isc_strtolower($word))) {
					$suggestions = pspell_suggest($spell, $word);

					if (!empty($suggestions) && isc_strtolower($suggestions[0]) != isc_strtolower($words[$word_count])) {
						// There was at least one suggestion
						$changed_words[] = array($words[$word_count], $suggestions[0]);
						$words[$word_count] = $suggestions[0];
						$has_suggestion = true;
					}
				}

				$word_count++;
			}

			return implode(" ", $words);
		}
		else {
			$has_suggestion = false;
			return $sentence;
		}
	}

	function GetSearchQueries($params=array())
	{
		
		if(isset($params['flag_srch_brand']) &&  $params['flag_srch_brand'] == 0 && $GLOBALS['BRAND_SERIES_FLAG'] == 0 && ( !isset($params['srch_category']) || isset($params['category']) ) && !isset($params['partnumber']) )
		{
			return $this->GetSeriesQuery();
		}
		else if(isset($params['flag_srch_category']) && $params['flag_srch_category'] == 0 && ( !isset($GLOBALS['BRAND_SERIES_FLAG']) || (  isset($GLOBALS['BRAND_SERIES_FLAG']) && $GLOBALS['BRAND_SERIES_FLAG'] == 0 ) ) && !isset($params['partnumber'])  )
		{
			return $this->GetCategoryQuery();
		}
		else
		{
			//return BuildProductSearchQuery($this->_searchterms);
			return $this->GetProductQuery();
		}
	}
	/**
		*	Run the full text searches to find matching products
		*/
	function DoSearch($Start, &$Search_Result, &$Search_Count)
	{

		$category_ids = array();
		$params = $this->_searchterms;

		// Build the search query using our terms & the fields we want
		//$searchQueries = $this->GetSearchQueries($this->_searchterms);
		$searchQueries = $this->GetSearchQueries($this->_searchterms);
					
		$orderby = "";
		

		/* the below 4 lines has been added to group by SKU or by catid as same sku was showing in multiple products by vikas*/
		if(isset($params['flag_srch_brand']) &&  $params['flag_srch_brand'] == 0 && $GLOBALS['BRAND_SERIES_FLAG'] == 0 && ( !isset($params['srch_category']) || isset($params['category']) ) && !isset($params['partnumber']) )
		{
			$GLOBALS['results_page_flag'] = 1;
			$group =  " group by p.brandseriesid ";
			$orderby = $searchQueries['orderby'];

			$seo_query = "select brandname , brandpagetitle , brandmetakeywords , brandmetadesc  , controlscript , trackingscript from [|PREFIX|]brands where brandname = '".$params['brand']."'";
			$seo_result = $GLOBALS['ISC_CLASS_DB']->Query($seo_query);
			$seo_array = $GLOBALS['ISC_CLASS_DB']->Fetch($seo_result);

			/* the below lines assign meta discription, keywords and title for the brand*/
			if(isset($seo_array['brandmetakeywords']))
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaKeywords($seo_array['brandmetakeywords']);

			if(isset($seo_array['brandmetadesc']))
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaDescription($seo_array['brandmetadesc']);

			if($seo_array['brandpagetitle'] != "")
			$this->_pagetitle = $seo_array['brandpagetitle'];
			else
			$this->_pagetitle = $seo_array['brandname'];

			$GLOBALS['CategoryTrackingCodeTop'] = isset($seo_array['controlscript']) ? $seo_array['controlscript'] : '';
			$GLOBALS['CategoryTrackingCodeBottom'] = isset($seo_array['trackingscript']) ? $seo_array['trackingscript'] : '';

		}
		else if(isset($params['flag_srch_category']) && $params['flag_srch_category'] == 0 && ( !isset($GLOBALS['BRAND_SERIES_FLAG']) || (  isset($GLOBALS['BRAND_SERIES_FLAG']) && $GLOBALS['BRAND_SERIES_FLAG'] == 0 ) ) && !isset($params['partnumber'])  )
		{
			$GLOBALS['results_page_flag'] = 0;
			$group =  " group by c.categoryid ";
			$orderby = $searchQueries['orderby'];

			/* below template variables are added for subcategory page to add category specific tracking code*/
			if(isset($params['srch_category']))
			{
				//alandy_2011-11-9 mark.
				$selected_catg = end($params['srch_category']);
				if($selected_catg != '')
				{
					$script_query = "select catname , catpagetitle , catmetakeywords , catmetadesc , controlscript , trackingscript from [|PREFIX|]categories where categoryid = ".$selected_catg;
					$script_result = $GLOBALS['ISC_CLASS_DB']->Query($script_query);
					$script_array = $GLOBALS['ISC_CLASS_DB']->Fetch($script_result);

					$GLOBALS['ISC_SRCH_CATG_NAME'] = ucwords($script_array["catname"]);

					$GLOBALS['CategoryTrackingCodeTop'] = $script_array['controlscript'];
					$GLOBALS['CategoryTrackingCodeBottom'] = $script_array['trackingscript'];

					/* the below lines assign meta discription, keywords and title for the categories*/
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaKeywords($script_array['catmetakeywords']);
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaDescription($script_array['catmetadesc']);
					if($script_array['catpagetitle'] != "")
					$this->_pagetitle = $script_array['catpagetitle'];
					else
					$this->_pagetitle = $script_array['catname'];
				}
			}

		}
		else {
			$GLOBALS['results_page_flag'] = 2;
			$group =  " group by p.productid ";

			if(isset($_REQUEST['orderby']) && !empty($_REQUEST['orderby']))
			{
				if($_REQUEST['orderby'] == "brandname")
				{
					$orderby = " order by brandname ".(isset($_REQUEST['sortby']) ? $_REQUEST['sortby'] : "asc")." , seriesname ";
				}
				else
				{
					$orderby = " order by ".$_REQUEST['orderby']." ";
				}
			}
			else
			$orderby = " order by p.prodprice ";

			if(isset($_REQUEST['sortby']) && !empty($_REQUEST['sortby']))
			$orderby .= $_REQUEST['sortby'];
			else
			$orderby .= " asc";

			if(isset($params['brand']))
			{

				$seo_query = "select brandname , brandpagetitle , brandmetakeywords , brandmetadesc from [|PREFIX|]brands where brandname = '".$params['brand']."'";
				$seo_result = $GLOBALS['ISC_CLASS_DB']->Query($seo_query);
				$brand_array = $GLOBALS['ISC_CLASS_DB']->Fetch($seo_result);

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaKeywords($brand_array['brandmetakeywords']);
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaDescription($brand_array['brandmetadesc']);
				if($brand_array['brandpagetitle'] != "")
				$this->_pagetitle = $brand_array['brandpagetitle'];
				else
				$this->_pagetitle = $brand_array['brandname'];
					
			}

			if(isset($params['series']))
			{

				$seo_query = "select seriesname , seriespagetitle , seriesmetakeywords , seriesmetadesc from [|PREFIX|]brand_series where seriesname = '".$params['series']."'";
				$seo_result = $GLOBALS['ISC_CLASS_DB']->Query($seo_query);
				$series_array = $GLOBALS['ISC_CLASS_DB']->Fetch($seo_result);
					
				/* the below lines assign meta discription, keywords and title for the brand*/
				if(!empty($series_array['seriesmetakeywords']))
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaKeywords($series_array['seriesmetakeywords']);
					
				if(!empty($series_array['seriesmetadesc']))
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaDescription($series_array['seriesmetadesc']);
					
				if(!empty($series_array['seriespagetitle']))
				$this->_pagetitle = $series_array['seriespagetitle'];
				else
				$this->_pagetitle = $series_array['seriesname'];


			}
			else if(isset($params['srch_category']) && !isset($params['category']))
			{
				$selected_catg = end($params['srch_category']);
				if($selected_catg != '')
				{
					$script_query = "select catname , catpagetitle , catmetakeywords , catmetadesc , controlscript , trackingscript from [|PREFIX|]categories where categoryid = ".$selected_catg;
					$script_result = $GLOBALS['ISC_CLASS_DB']->Query($script_query);
					$script_array = $GLOBALS['ISC_CLASS_DB']->Fetch($script_result);

					$GLOBALS['CategoryTrackingCodeTop'] = $script_array['controlscript'];
					$GLOBALS['CategoryTrackingCodeBottom'] = $script_array['trackingscript'];

					/* the below lines assign meta discription, keywords and title for the categories */
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaKeywords($script_array['catmetakeywords']);
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaDescription($script_array['catmetadesc']);

					if($script_array['catpagetitle'] != "")
					$this->_pagetitle = $script_array['catpagetitle'];
					else
					$this->_pagetitle = $script_array['catname'];
				}
			}

		}

		/* the below three lines has been added to group by SKU as same sku was showing in multiple products */

		$searchQueries['query'] .= $group .$orderby ;//.$GLOBALS['having_query'].$orderby;
		$searchQueries['countQuery'] .= $group;//.$GLOBALS['having_query'];

		/*
		 $searchQueries['query'] .= $group.$orderby;
		 $searchQueries['countQuery'] .= $group;
		 */

		//$searchQueries['countQuery'] = "select count(*) from ( ".$searchQueries['countQuery']." ) p ";
	
		$count_res = $GLOBALS['ISC_CLASS_DB']->Query($searchQueries['countQuery']);
		$Search_Count = $GLOBALS['ISC_CLASS_DB']->CountResult($count_res);
        
		// Run the query
		//$Search_Count = $GLOBALS['ISC_CLASS_DB']->FetchOne($searchQueries['countQuery']);
		//echo $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();	
		//echo $searchQueries['countQuery']."<br/>";
		//echo $searchQueries['query'];
		// Add the limit
		$searchQueries['query'] .= $GLOBALS['ISC_CLASS_DB']->AddLimit($Start, GetConfig('CategoryProductsPerPage'));
		//var_dump($searchQueries['query']);exit;
		$Search_Result = $GLOBALS['ISC_CLASS_DB']->Query($searchQueries['query']);
		$GLOBALS['DoSearchQuery'] = $searchQueries['query'];	
		
		if(isset($params['flag_srch_brand']) &&  $params['flag_srch_brand'] == 0 && $GLOBALS['BRAND_SERIES_FLAG'] == 0 && ( !isset($params['srch_category']) || isset($params['category']) ) && !isset($params['partnumber']) )
		{
			//process groucontact data for seriess page. not used now.
			
		}
		else if(isset($params['flag_srch_category']) && $params['flag_srch_category'] == 0 && ( !isset($GLOBALS['BRAND_SERIES_FLAG']) || (  isset($GLOBALS['BRAND_SERIES_FLAG']) && $GLOBALS['BRAND_SERIES_FLAG'] == 0 ) ) && !isset($params['partnumber'])  )
		{
			//process groucontact data for subcategory page. not used now.
			
		}
		else
		{
			//product page. process old groupcontact data.
			
			$productData = array();
			$productIds = array();
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($Search_Result)) {
				$productData[] = $row;
				$productIds[] = $row['productid'];
			}			
			$productIds = array_unique($productIds);
			
			$productIdWhere = " and p.productid in(".implode(',', $productIds).")";
			//var_dump($searchQueries['PVCols']);
			if(isset($searchQueries['PVCols']) && count($searchQueries['PVCols']) >0)
			{
				// fetch pq vq datas.
				$vpCols = $searchQueries['PVCols'];
				$vpQuery = $searchQueries["PVQuery"]. $productIdWhere;
				//echo  $vpQuery;
				$temp_Result = $GLOBALS['ISC_CLASS_DB']->Query($vpQuery);

				$vpData = array();
				// put product data to array
				while($row2 = $GLOBALS['ISC_CLASS_DB']->Fetch($temp_Result)) {
					foreach($vpCols as $key)
					{
						if(empty($row2[$key])) // filter empty element.
						{
							continue;
						}
						$vpData[$row2["productid"]][$key][] = $row2[$key];
					}
				}
				
				foreach($productData as &$product)
				{
					$pid = $product["productid"];
					foreach($vpCols as $key)
					{
						$temp = array();
						if(isset($vpData[$pid]) && isset($vpData[$pid][$key]))
						{
							$temp = $vpData[$pid][$key];
						}
						$temp = array_unique($temp);
						//var_dump($temp);
						
						$product[$key] = implode('~', $temp);
						
						
					}
				}			
				
			}
			
			//var_dump($productData);			
			//$Search_Result = $productData;
			$GLOBALS["SearProductsInfos"] = $productData;
			
		}
	

	}

	/**
		*	Use full text to find related searches in the searches table
		*/
	function GetRelatedSearchTerms($Query)
	{

		$related_searches = array();

		$query = "select searchtext, ";
		$query .= $GLOBALS['ISC_CLASS_DB']->FullText(array("searchtext"), $Query, true) . " as score ";
		$query .= "from [|PREFIX|]searches where ";
		$query .= $GLOBALS['ISC_CLASS_DB']->FullText(array("searchtext"), $Query, true);
		$query .= sprintf(" and lower(searchtext) != '%s'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($Query)));
		$query .= " order by score desc ";

		// Add the limit
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 3);
		
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			array_push($related_searches, $row['searchtext']);
		}

		return $related_searches;
	}

	/**
		*	Save a record of this search in the searches table,
		*	or update the numsearches field if it's not a new search
		*/
	function LogSearch($Query, $NumResults=0)
	{

		// Has this query already been logged?
		// lguan_20100526: Take YMM into consideration
		$query = sprintf("select searchid from [|PREFIX|]searches where lower(searchtext)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($Query)));
		// cloud 2010-06-07 fix bug, getting ymm value from search terms, instead of session
		if (isset($this->_searchterms['year']) && $this->_searchterms['year']!='')
		$query .= sprintf(" and lower(prodyear)='%s'", $this->_searchterms['year']);
		if (isset($this->_searchterms['make']) && $this->_searchterms['make']!='')
		$query .= sprintf(" and lower(prodmaker)='%s'", $this->_searchterms['make']);
		if (isset($this->_searchterms['model']) && $this->_searchterms['model']!='')
		$query .= sprintf(" and lower(prodmodel)='%s'", $this->_searchterms['model']);

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

		// lguan_20100526: Log YMM in search statics
		// cloud 2010-06-07 fix bug, getting ymm value from search terms, instead of session
		if (!isset($row['searchid']) || $row['searchid'] == 0) {
			// A search isn't already logged for this query by the same person
			$SearchLog = array(
					"searchtext" => $Query,
					"numsearches" => 1,
					"prodyear"=> isset($this->_searchterms['year'])?$this->_searchterms['year']:'',
					"prodmaker"=> isset($this->_searchterms['make'])?$this->_searchterms['make']:'',
					"prodmodel"=>isset($this->_searchterms['model'])?$this->_searchterms['model']:'',
					"searchurl"=>$_SERVER["REQUEST_URI"]
			);
			$GLOBALS['ISC_CLASS_DB']->InsertQuery("searches", $SearchLog);
		}
		else {
			// This search term is already logged, just update the numsearches field
			$query = sprintf("update [|PREFIX|]searches set numsearches=numsearches+1 where searchid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote((int) $row['searchid']));
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}

		// Log the seach to our actual search cache table
		// lguan_20100526: Log YMM in search statics
		// cloud 2010-06-07 fix bug, getting ymm value from search terms, instead of session
		$SearchCache = array(
				"searchtext" => isc_strtolower($Query),
				"numresults" => $NumResults,
				"searchdate" => time(),	
				"prodyear"=> isset($this->_searchterms['year'])?$this->_searchterms['year']:'',
				"prodmaker"=> isset($this->_searchterms['make'])?$this->_searchterms['make']:'',
				"prodmodel"=>isset($this->_searchterms['model'])?$this->_searchterms['model']:'',
				"searchurl"=> $_SERVER["REQUEST_URI"]
		);
		$searchid = $GLOBALS['ISC_CLASS_DB']->InsertQuery("searches_extended", $SearchCache);

		// Was this search a recommendation or correction click?
		$this->_CheckSearchCorrection($Query, $NumResults);
		return $searchid;
	}

	/**
	 * Checks if a search correction is being performed, if so, logs it
	 */
	function _CheckSearchCorrection($Query, $NumResults)
	{
		$oldsearchid = '';
		if (isset($_GET['correction'])) {
			$oldsearchid = (int)$_GET['correction'];
			unset($_GET['correction']);
			$type = 'correction';
		}
		else if (isset($_GET['recommendation'])) {
			$oldsearchid = (int)$_GET['recommendation'];
			unset($_GET['recommendation']);
			$type = 'recommendation';
		}
		if ($oldsearchid > 0) {
			// Fetch the old search from the database to get its result count & search terms
			$query = sprintf("select * from [|PREFIX|]searches_extended where searchid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($oldsearchid));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			if (!$row) {
				return $oldsearchid;
			}

			$SearchCorrection = array(
					"correctiontype" => $type,
					"correction" => $Query,
					"numresults" => $NumResults,
					"oldsearchtext" => $row['searchtext'],
					"oldnumresults" => $row['numresults'],
					"correctdate" => time()
			);
			$GLOBALS['ISC_CLASS_DB']->InsertQuery("search_corrections", $SearchCorrection);
		}
	}

	/**
	 * Show the search tips page.
	 */
	function ShowSearchTips()
	{
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(GetLang("SearchTips"));
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("search_tips");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
		* Get the display message from DB to display for the search result
		*/
	function GetSearchResultMessage()
	{
		$where = "";
		$msg_qry = "select value from [|PREFIX|]display ";

		if($GLOBALS['results_page_flag'] == 0)
		$msg_qry .= " where messageid = 3 ";
		else if($GLOBALS['results_page_flag'] == 2)
		$msg_qry .= " where messageid = 2 ";

		$msg_res = $GLOBALS['ISC_CLASS_DB']->Query($msg_qry);
		$msg_row = $GLOBALS['ISC_CLASS_DB']->FetchOne($msg_res);

		$srch_result_msg = html_entity_decode($msg_row);
		$srch_result_msg = str_ireplace("<!--PRODUCT-NUMBER-->",$this->_numresults,$srch_result_msg);
		$srch_result_msg = str_ireplace("<!--SEARCH-STRING-->",$GLOBALS['OriginalSearchQuery'],$srch_result_msg);

		return $srch_result_msg;
	}
	
	function GetSearchCategoryResultMessage()
	{
		$str = "";
		$str =html_entity_decode('<p><span style="font-family: arial,sans-serif;">&lt;!--PRODUCT-NUMBER--&gt; Sub</span>categories Found </p>');
		
		$str = str_ireplace("<!--PRODUCT-NUMBER-->",$this->_numresults,$str);
		
		return $str;
	}

	/**
		*	Show the search page. If there are results, show them too. If we're in advanced mode then
		*	show the advanced search options as well.
		*/
	function ShowSearchPage()
	{
		if (isset($_GET['category'])) {
			$selected_cats = $_GET['category'];
		} else {
			$selected_cats = 0;
		}

		if (isset($_GET['mode']) && $_GET['mode'] == "advanced") {
			$GLOBALS['HideAdvancedLink'] = "none";
		}
		
		//alandy_2012-1-19 add.
		
		if(isset($_COOKIE['showDialog']) && !empty($_COOKIE['showDialog'])){
			$GLOBALS['showDialog'] = 5;
			unset($_COOKIE['showDialog']);
			
		}
		
		if(isset($_COOKIE['brandname'])) $GLOBALS['dialogBrandname']= $_COOKIE['brandname'];
		if(isset($_COOKIE['seriesname'])) $GLOBALS['dialogSeriesname']= $_COOKIE['seriesname'];
		if(isset($_COOKIE['categoryname'])) $GLOBALS['dialogCategoryname']= $_COOKIE['categoryname'];
		if(isset($_COOKIE['category_link'])) $GLOBALS['dialogCategorylink']= $_COOKIE['category_link'];
		$GLOBALS['dialogVehicle'] =  $_COOKIE['last_search_selection']['year'].' '.$_COOKIE['last_search_selection']['make'].' '.$_COOKIE['last_search_selection']['model'];
		
		/*
		$current_url = trim($_SERVER['REQUEST_URI'],"/");
		if(!empty($current_url)){
			$parame = explode("/",$current_url);
			foreach($parame as $val){
				if(in_array($val,array('showDialog'))){
					$GLOBALS['showDialog'] = 5;
					break;
				}
			}
		}
		*/
		
		include_once(dirname(__FILE__) . "/class.brands.php");

		$GLOBALS['CompareLink'] = CompareLink();

		$GLOBALS['ISC_CLASS_BRANDS'] = GetClass('ISC_BRANDS');
		$GLOBALS['BrandNameOptions'] = $GLOBALS['ISC_CLASS_BRANDS']->GetBrandsAsOptions(@$this->_searchterms['brand']);
		$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
		$GLOBALS['CategoryOptions'] = $GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->GetCategoryOptions($selected_cats, "<option %s value='%d'>%s</option>", 'selected="selected"', "", false, 1);
		//var_dump($GLOBALS['CategoryOptions']);exit;
		if ((isset($_GET['searchsubs']) && $_GET['searchsubs'] == "ON") || @$this->_searchterms['search_query'] == "") {
			$GLOBALS['IsSearchSubs'] = 'checked="checked"';
		}

		if (isset($this->_searchterms['price_from']) && is_numeric($this->_searchterms['price_from'])) {
			$GLOBALS['PriceFrom'] = $this->_searchterms['price_from'];
		}

		if (isset($this->_searchterms['price_to']) && is_numeric($this->_searchterms['price_to'])) {
			$GLOBALS['PriceTo'] = $this->_searchterms['price_to'];
		}

		if (isset($this->_searchterms['featured'])) {
			$GLOBALS["Featured" . $this->_searchterms['featured']] = 'selected="selected"';
		}

		if (isset($this->_searchterms['shipping'])) {
			$GLOBALS["Shipping" . $this->_searchterms['shipping']] = 'selected="selected"';
		}

		if (@$this->_searchterms['search_query'] != "") {
			
			$GLOBALS['SNIPPETS']['RelatedSearches'] = "";
			$has_suggestion = false;
			$changed_words = array();
			$query = $this->Suggest($this->_searchterms['search_query'], $has_suggestion, $changed_words);
			
			// Are we on a particular page?
			if (isset($_REQUEST['page'])) {
				$page = (int)$_REQUEST['page'];
				$this->_currentpage = $page;

				if ($page == 1) {
					$start = 0;
				} else {
					$start = ($page-1) * GetConfig('CategoryProductsPerPage');
				}
			}
			else {
				$start = 0;
			}

			// Did pSpell make a suggestion?
			if ($query != $this->_searchterms['search_query']) {
				// pSpell made a suggestion
				$words = explode(" ", $this->_searchterms['search_query']);
					
				/* ---- the below below lines are commented for nSearchResultsot showing as alternate names are shown instead - start ---- */
				/*foreach ($words as $k=>$word) {
				 foreach ($changed_words as $changed_word) {
				 if ($word == $changed_word[0]) {
				 $words[$k] = "<strong>" . $changed_word[1] . "</strong>";
				 }
				 }
					}

					$GLOBALS['SuggestQuery'] = implode(" ", $words);
					$GLOBALS['SuggestQueryEscaped'] = urlencode($query);*/
				/* ------------ ends ---------- */

				/* --- this below patch is for getting alternate keywords as per client request ---- starts ---*/

				$GLOBALS['NewSuggestQuery'] = "";
				
				foreach($changed_words as $key => $value) {
					$words = explode(",",$value);
					for($i=0;$i<count($words);$i++)
					{
						$words[$i] = trim($words[$i]);
						$GLOBALS['NewSuggestQuery'][] = "<a href='".$GLOBALS['ShopPathNormal']."/search.php?search_query=".urlencode($words[$i])."&search_key=1'>".$words[$i]."</a>";
					}
				}


				if(!empty($GLOBALS['NewSuggestQuery']))
				$GLOBALS['NewSuggestQuery'] = implode(" , ",$GLOBALS['NewSuggestQuery']);

				/* ------ ends ----- */


				$GLOBALS['ShowSearchSuggestion'] = "";
			}
			else {
				// No search suggestion
				$GLOBALS['ShowSearchSuggestion'] = "none";
			}					
	
			// Load up a list of results which the panel will take care of displaying
			$this->DoSearch($start, $GLOBALS['SearchResults'], $this->_numresults);
		
			//NI CLOUD
			//filter for single cat or brand
			$count = $GLOBALS['ISC_CLASS_DB']->CountResult($GLOBALS['SearchResults']);
			
			//var_dump($GLOBALS['DoSearchQuery']);
			//echo $count;
			if( $count == 1 )
			{
				$sresult = $GLOBALS['ISC_CLASS_DB']->Query($GLOBALS['DoSearchQuery']);
				$row = $GLOBALS['ISC_CLASS_DB']->Fetch($sresult);
					
				if( !isset($row["prodcode"]) )
				{
					if( isset($row["parentcatname"]) )
					{
						$query = "SELECT b.* FROM [|PREFIX|]brands b, [|PREFIX|]brand_series bs  WHERE b.brandid = bs.brandid and bs.seriesid = ".$row["brandseriesid"];
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
						if( $GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0 )
						{
							$crow = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
							if( $crow["displayproducts"] == '1' )
							{
								header("Location:".$GLOBALS["ShopPath"].$_SERVER["REQUEST_URI"]."/series/".MakeURLSafe($row["seriesname"]));
							}
						}
					}
					else
					{
						$query = "SELECT * FROM [|PREFIX|]categories c WHERE c.categoryid = (SELECT catparentid FROM [|PREFIX|]categories where categoryid = ".$row["categoryid"].")";
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
						if( $GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0 )
						{
							$crow = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
							if( strtolower($crow["displayproducts"]) == 'on' )
							{
								header("Location:".$GLOBALS["ShopPath"].$_SERVER["REQUEST_URI"]."/subcategory/".MakeURLSafe($row["catname"]));
							}
						}
						else
						{
							$query = "(SELECT * FROM [|PREFIX|]categories where categoryid = ".$row["categoryid"].")";
							$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
							$crow = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
							if( strtolower($crow["displayproducts"]) == 'on' )
							header("Location:".$GLOBALS["ShopPath"].$_SERVER["REQUEST_URI"]."/subcategory/".MakeURLSafe($row["catname"]));
						}
					}
				}
			}

			// Log the search result
			if ($start == 0) {
				//wirror_20100913: filter the request from yahoo,google,msn & baidu
				$userAgent = $_SERVER['HTTP_USER_AGENT'];
				$webSpiders = array('Yahoo! Slurp', 'Baiduspider', 'Googlebot', 'msnbot');
				$noSpider = true;
				foreach($webSpiders as $spider){
					if(strpos($userAgent, $spider) !== false){
						$noSpider = false;
						break;
					}
				}
					
				// lguan_20100520: Only do the log if smart search flag is on, means we only log the search terms user input in smart search box
				if($GLOBALS['EnableSEOUrls'] == 1)
				{
					$url_array = split('/', strtolower($_SERVER['REQUEST_URI']));
					$is_smart_search = $url_array[array_search('is_smart_search', $url_array, true)+1];
					if (isset($is_smart_search) && ($is_smart_search==1) && isset($this->_searchterms['search_query']) && strlen($this->_searchterms['search_query']) > 0 && $noSpider)	{

						$GLOBALS['SearchId'] = $this->LogSearch($this->_searchterms['search_query'], $this->_numresults);

					}
				}
				else
				{
					if (isset($_GET['is_smart_search']) && ($_GET['is_smart_search']==1) && isset($this->_searchterms['search_query']) && strlen($this->_searchterms['search_query']) > 0 && $noSpider)	{

						$GLOBALS['SearchId'] = $this->LogSearch($this->_searchterms['search_query'], $this->_numresults);

					}
				}
			}

			// Load up a list of related searches
			$related_searches = $this->GetRelatedSearchTerms($this->_searchterms['search_query']);

			if (!empty($related_searches)) {
				foreach ($related_searches as $related_search) {
					$GLOBALS['RelatedSearchQuery'] = urlencode($related_search);
					$GLOBALS['RelatedSearchText'] = isc_html_escape($related_search);
					$GLOBALS['SNIPPETS']['RelatedSearches'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("RelatedSearchItem");
				}

				$GLOBALS['SNIPPETS']['RelatedSearches'] = trim($GLOBALS['SNIPPETS']['RelatedSearches'], ", ");
			}
			else {
				$GLOBALS['HideRelatedSearches'] = "none";
			}

			/* this below patch has been added to hide the below 3 sections as per client requirements */
			if($this->_numresults == 0) {
				$GLOBALS['HideRelatedSearches'] = "none";

				if(!empty($GLOBALS['NewSuggestQuery']))
				$GLOBALS['ShowSearchSuggestion'] = "";
				else
				$GLOBALS['ShowSearchSuggestion'] = "none";

				$GLOBALS['SearchTitle'] = "";
			} else
			$GLOBALS['ShowSearchSuggestion'] = "none";

			// How many pages of results are there?
			$this->_numpages = ceil($this->_numresults / GetConfig('CategoryProductsPerPage'));
		}
		else {
			// Show the advanced mode box instead and hide everything else if there's no search term
			if (@$this->_searchterms['search_query'] == "") {
				$GLOBALS['HideRelatedSearches'] = "none";
				$GLOBALS['ShowSearchSuggestion'] = "none";
				$GLOBALS['HideSearchResults'] = "none";
				$GLOBALS['HideNoResults'] = "none";
			}
		}

		/* Re-writing the search keywords as per the selection in the search field */
		$originalsearchquery = isset($GLOBALS['OriginalSearchQuery']) ? $GLOBALS['OriginalSearchQuery'] : '';
		$GLOBALS['OriginalSearchQuery'] = "";
		$searchquerystring = array();
		$ymmTitle = array(); // This variable is used to get YMM and add it to title tag.
		if(isset($GLOBALS['ISC_SRCH_BRAND_NAME']))
		$searchquerystring[] =  $GLOBALS['ISC_SRCH_BRAND_NAME'];
		if(isset($this->_searchterms['partnumber']))
		$searchquerystring[] =  $this->_searchterms['partnumber'];
		if(isset($GLOBALS['ISC_SRCH_CATG_NAME']))
		$searchquerystring[] =  $GLOBALS['ISC_SRCH_CATG_NAME'];
		if(isset($this->_searchterms['year']))
		{
			$searchquerystring[] =  $this->_searchterms['year'];
			$ymmTitle[] = $this->_searchterms['year'];
		}
		if(isset($this->_searchterms['make']))
		{
			$searchquerystring[] =  strtoupper($this->_searchterms['make']);
			$ymmTitle[] = ucwords(strtolower($this->_searchterms['make']));
		}
		if(isset($_REQUEST['model']) && !empty($_REQUEST['model']))
		{
			$searchquerystring[] = $_REQUEST['model'];
			$ymmTitle[] = ucwords(strtolower($_REQUEST['model']));
		}
		if(isset($this->_searchterms['submodel']))
		$searchquerystring[] =  ucwords(strtolower($this->_searchterms['submodel']));
		if(!empty($this->_searchterms['dynfilters']))
		$searchquerystring[] = implode(" ",$this->_searchterms['dynfilters']);

		if(empty($searchquerystring) && $originalsearchquery != 'categories' && $originalsearchquery != 'brands' && !isset($_REQUEST['change'])) // when none of the above selection is made, need to show the search keyword entered
		$searchquerystring[] = $originalsearchquery;

		$GLOBALS['OriginalSearchQuery'] = ucwords(implode(" ",$searchquerystring));
		$GLOBALS['FormattedSearchQuery'] = $GLOBALS['OriginalSearchQuery'];
		/* ----------------------------------------------------------------------- */

		/*---- The below two variables are added to set the search title and page title again after resetting ----*/
		//$GLOBALS['SearchTitle'] = $this->_numresults." ".sprintf(GetLang('SearchResultsFor'), $GLOBALS['OriginalSearchQuery']);

		//if( isset($this->_searchterms['partnumber']) || (isset($this->_searchterms['flag_srch_category']) && $this->_searchterms['flag_srch_category'] == 1 ) || ( isset($this->_searchterms['flag_srch_category']) && isset($GLOBALS['BRAND_SERIES_FLAG']) && $GLOBALS['BRAND_SERIES_FLAG'] == 1 ))
		
		if(isset($GLOBALS['results_page_flag']))
		{
			if($GLOBALS['results_page_flag'] == 2)
			{
				$GLOBALS['SearchTitle'] = $this->GetSearchResultMessage();
				//$GLOBALS['SearchTitle'] = $this->_numresults." ".sprintf(GetLang('SpecificResultsFor'), "Parts",  $GLOBALS['OriginalSearchQuery']);
			}
			else if($GLOBALS['results_page_flag'] == 1)
			{
				$GLOBALS['SearchTitle'] = $this->_numresults." ".sprintf(GetLang('SpecificResultsFor'), "Series", $GLOBALS['OriginalSearchQuery']);
			}
			else
			{
				$GLOBALS['SearchTitle'] = $this->GetSearchCategoryResultMessage();
			}
		}
		

		/*
			else {
			if(isset($this->_searchterms['srch_category']) || !isset($GLOBALS['BRAND_SERIES_FLAG']))
			{
			$GLOBALS['SearchTitle'] = $this->GetSearchResultMessage();
			//$GLOBALS['SearchTitle'] = $this->_numresults." ".sprintf(GetLang('SpecificResultsFor'), "Subcategories",  $GLOBALS['OriginalSearchQuery']);
			}
			else
			{
			$GLOBALS['SearchTitle'] = $this->_numresults." ".sprintf(GetLang('SpecificResultsFor'), "Series", $GLOBALS['OriginalSearchQuery']);
			}
			}
			*/
	
		if($this->_numresults==0)    {
			$GLOBALS['RedefinedSearchQuery'] = $GLOBALS['OriginalSearchQuery'];
			if($GLOBALS['OriginalSearchQuery']=='')   {
				$GLOBALS['SearchTitle'] = '';
			}
			else   {
				$GLOBALS['SearchTitle'] = $this->_numresults." ".sprintf(GetLang('SearchResultsFor'), $GLOBALS['OriginalSearchQuery']);
			}
		}

		if(trim($this->_pagetitle) == "")
		$this->_pagetitle = sprintf(GetLang('SearchSimpleTitle'), GetConfig('StoreName'), strip_tags($GLOBALS['SearchTitle']));

		/*-- Prefixing YMM to actual title tag --*/
		if(!empty($ymmTitle))
		{
			$ymmTitle[] = 	$this->_pagetitle;
			$this->_pagetitle = implode($ymmTitle," ");
		}

		if( $this->_numresults==0 && isset($this->_searchterms['searchtext']) )
		{
			$GLOBALS['RedefinedSearchQuery'] = $GLOBALS['OriginalSearchQuery'];
		}

		$GLOBALS['OriginalSearchQuery'] = '';
		if(isset($this->_searchterms['searchtext'])) {
			//$searchquerystring = array();
			$GLOBALS['OriginalSearchQuery'] =  ucwords($this->_searchterms['searchtext']);
		}

		if(isset($this->_searchterms['search'])) {
			//$searchquerystring = array();
			$GLOBALS['OriginalSearchQuery'] =  ucwords($this->_searchterms['search']);
			$GLOBALS['RedefinedSearchQuery'] = $GLOBALS['OriginalSearchQuery'];
		}

			
		// Hide the search form if we have just performed a search
		if (!empty($this->_searchterms)) {
			$GLOBALS['AutoHideSearchForm'] = "true";
		}
		
		
				
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($this->_pagetitle);
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("newsearch");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		
		
	}
	
	//zcs=>
	function _AdjustKeywords($keywords, $name = '', $delimiter = ','){
		if($name) $name = '[NAME]'.$name;//to distinguish it as a NAME
		$keywordsArray = explode($delimiter, $keywords);
		$keywordsArray[] = $name;//join
		foreach($keywordsArray as $i => $keyword){
			if(trim($keyword) == ''){
				unset($keywordsArray[$i]);
			}
		}
		return implode($delimiter, $keywordsArray);
	}
	function _checkKeywordName(&$keyword){
		$flag = '[NAME]';
		return stripos($keyword, $flag) === 0 && ($keyword = str_ireplace($flag, '', $keyword));
	}
	function _isMatchedKeyword($keyword, $searchPartial, $searchQuery){
		$keyword = trim($keyword);
		$searchPartial = trim($searchPartial);
		$searchQuery = trim($searchQuery);
		if($this->_checkKeywordName($keyword)){
			return !empty($searchQuery) && $keyword == $searchQuery;//for NAME, must match all in critical
		}else{
			return !empty($searchPartial) && preg_match("/^{$searchPartial}s?$/i", $keyword);//normal match
		}
	}
	//<=zcs

	//templ/master/sidecaztgegorylist.html    //subcategory/brand listing
	//sideshopbybrand.html                   // home page
	function BuildProductSearchTerms2($input)
	{
		$GLOBALS['ISC_CategoryBrandCache'] = GetClass('ISC_CACHECATEGORYBRANDS');
	    $cachedCategoryBrands = $GLOBALS['ISC_CategoryBrandCache']->getCategoryBrandsData();
	    $BrandsForSearch = $GLOBALS['ISC_CategoryBrandCache']->GetBrandsForSearch($cachedCategoryBrands);
	    $CategoryForSearch = $GLOBALS['ISC_CategoryBrandCache']->GetCategoryForSearch($cachedCategoryBrands);
	    $TypeForSearch = $GLOBALS['ISC_CategoryBrandCache']->GetTypeForSearch($cachedCategoryBrands);
	   
		//wirror_2010_10_21:search enhancement
		$ismartSearch = (isset($input['is_smart_search']) && $input['is_smart_search']==1) ? true : false;
		
		$input['search_query'] = html_entity_decode($input['search_query']);
		$input['search_query'] = trim($input['search_query']);
		
		
		
			$regex_chars = array('/\//','/\^/','/\$/','/\./','/\[/','/\]/','/\|/','/\(/','/\)/','/\?/','/\*/','/\+/','/\{/','/\}/');
				$regex_replace_chars = array('\/','\^','\$','\.','\[','\]','\|','\(','\)','\?','\*','\+','\{','\}');
		
		$spl_strings = array("+",":", ";","!","@","#","$","%","^","*","\\");

		$input['search_query'] = str_replace($spl_strings," ",$input['search_query']);
		$input['search_query'] = preg_replace('/[ ]{2,}|[\t]/', ' ', trim($input['search_query']));
		$srch_arr = array();

		if(!empty($input['search_query']))
		$srch_arr = explode(" ",$input['search_query']);

		$make = "";
		$model = "";
		$submodel = "";
		$startyear = "";
		$endyear = "";

		$compare_catg_name = "";  // this variable is used to check the position of catgory and brand
		$compare_brand_name = "";	// this variable is used to check the position of catgory and brand

		array_walk($srch_arr,'lower');

		$new_srch_str = implode("','",$srch_arr);

		/*-- finding the qualifiers----*/
		$qualifier_count = 0;
		$GLOBALS['v_cols'] = array();
		$GLOBALS['p_cols'] = array();
		$GLOBALS['visible_pqvq'] = array();

		/*-- end of finding the qualifiers----*/

		$count_srch = count($srch_arr);
		
		$find_catg_id = array();      //alandy_2011-11-4 add.
		$find_parent_catg_id = array();
		$flag_brand = 0;
		$flag_brand_series = 0;
		$flag_catg = 0;
		$flag_sub_catg = 0; // 0 for parent catg & 1 for sub-catg
		$flag_alt_names = 0; // 0 for not matching alternate names & 1 for matching
		
		if($count_srch > 0 || isset($input['subcategory'])) {    // if there are any search criterias, then we need to check it in category list.

			$brandname = array();
			$brandaltname = array();
			//$brand_qry = "select brandid, brandname, brandaltkeyword from [|PREFIX|]brands order by CHAR_LENGTH(brandname) desc";
			//$brand_res =  $GLOBALS['ISC_CLASS_DB']->Query($brand_qry);
			//while($brand_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($brand_res))
			foreach ($BrandsForSearch as $brand_arr)
			{
				$brandname[$brand_arr['brandid']] = $brand_arr['brandname'];
				$brandaltname[$brand_arr['brandid']] = $this->_AdjustKeywords($brand_arr['brandaltkeyword'], $brand_arr['brandname']);//ltrim($brand_arr['brandaltkeyword'].','.$brand_arr['brandname'], ',');//zcs=Can accept brand name
			}

			//$catg_qry = "select * from [|PREFIX|]categories order by catparentid ASC , CHAR_LENGTH(catname) DESC";
			//$catg_res =  $GLOBALS['ISC_CLASS_DB']->Query($catg_qry);

			$catgoryname = array();    // array for category names
			$categoryaltname = array(); // array for alternate keywords
			$catuniversal = array();

			//while($catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($catg_res))
			foreach($CategoryForSearch as $catg_arr)
			{
				$catgoryname[$catg_arr['categoryid']]['catname'] = $catg_arr['catname'];
				$catgoryname[$catg_arr['categoryid']]['catparentid'] = $catg_arr['catparentid'];

				$categoryaltname[$catg_arr['categoryid']]['catname'] = $catg_arr['catname'];
				$categoryaltname[$catg_arr['categoryid']]['altkeywords'] = $this->_AdjustKeywords($catg_arr['cataltkeyword'], $catg_arr['catname']);//ltrim($catg_arr['cataltkeyword'].','.$catg_arr['catname'], ',');//zcs=Can accept category name
				$categoryaltname[$catg_arr['categoryid']]['catparentid'] = $catg_arr['catparentid'];
				$catuniversal[$catg_arr['categoryid']] =  $catg_arr['catuniversal'];
			}
			$GLOBALS['categories_all'] = $catgoryname;

			//wirror_2010_10_21: search enhancement
			if(!$ismartSearch){
				/*$common_qry =	 "select brandname as typename, 'brand' as type, brandid as 'id' from [|PREFIX|]brands
								UNION ALL
								( select catname as typename, 'category' as type, categoryid as 'id' from [|PREFIX|]categories c order by catparentid )
								order by CHAR_LENGTH(typename) DESC , typename asc ";
				$common_res	=	$GLOBALS['ISC_CLASS_DB']->Query($common_qry);*/
			
				//while($common_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($common_res))
				foreach ($TypeForSearch as $common_arr)
				{
					$brand_name = strtolower($common_arr['typename']);
					$in_str = "";
					$track_srch_key = array();
					for($k=0;$k<$count_srch;$k++)
					{
						$srchkey = preg_replace($regex_chars,$regex_replace_chars,$srch_arr[$k]);

						if($in_str == "")
						$match = "/(^$srchkey(\s{1})|^$srchkey\b)/i";
						else
						$match = "/(((\s{1})$srchkey(\s{1}))|((\s{1})$srchkey$))/i";

						if(preg_match($match,$brand_name)) {
							$track_srch_key[] = $k;
							if(!empty($in_str))
							$in_str .= " ".$srch_arr[$k];
							else
							$in_str .= $srch_arr[$k];

							if($brand_name == $in_str) // if matched early, then need to break it here.
							break;
						}
					}

					if( $in_str == '' )
					{
						for($k=0;$k<$count_srch;$k++)
						{
							$srchkey = preg_replace($regex_chars,$regex_replace_chars,rtrim($srch_arr[$k], 's'));

							if($in_str == "")
							$match = "/(^$srchkey(\s{1})|^$srchkey\b)/i";
							else
							$match = "/(((\s{1})$srchkey(\s{1}))|((\s{1})$srchkey$))/i";

							if(preg_match($match,$brand_name)) {
								$track_srch_key[] = $k;
								if(!empty($in_str))
								$in_str .= " ".rtrim($srch_arr[$k], 's');
								else
								$in_str .= rtrim($srch_arr[$k], 's');

								if($brand_name == $in_str ) // if matched early, then need to break it here.
								break;
							}
						}
					}

					if($brand_name == $in_str) {
						foreach($track_srch_key as $key => $val) {
							unset($srch_arr[$val]);
						}
						$srch_arr = array_values($srch_arr);

						if($common_arr['type'] == 'brand')
						{
							$compare_brand_name = $in_str;
							$brandid = $common_arr['id'];
							$input['brand'] = $brand_name;
							$flag_brand = 1;
							$GLOBALS['ISC_SRCH_BRAND_NAME'] = $brand_name;
						}
						else if($common_arr['type'] == 'category')
						{
							$catg_name = strtolower($common_arr['typename']);
							$key =	$common_arr['id'];
							if($catgoryname[$key]['catparentid'] != 0)   // checking its not a parent catg ?
							$flag_sub_catg = 1;

							$compare_catg_name = $in_str;
							$catg_id = $key;
							//alandy_2011-11-4 add.
							$find_catg_id[] = $key;
							
							$flag_catg = 1;
							$input['catuniversal'] = $catuniversal[$key];
						}

						break;
					}
				}
			}

			$count_srch = count($srch_arr);

			/*---- Brand Names --------*/
			//wirror_2010_10_21: search enhancement
			if($flag_brand == 0 && !$ismartSearch)
			{ 
				foreach($brandname as $bkey => $bvalue) {
					$brand_name = strtolower($bvalue);
					$in_str = "";
					$track_srch_key = array();
					for($k=0;$k<$count_srch;$k++)
					{
						if(stristr($brand_name,rtrim($srch_arr[$k], 's'))) {
							$track_srch_key[] = $k;
							if(!empty($in_str))
							$in_str .= " ".rtrim($srch_arr[$k],'s');
							else
							$in_str .= rtrim($srch_arr[$k],'s');
						}
					}

					if($brand_name == $in_str or $brand_name == $in_str.'s' ) {//condition for brand ending with 's'
						$compare_brand_name = $in_str;
						foreach($track_srch_key as $key => $val) {
							unset($srch_arr[$val]);
						}
						$srch_arr = array_values($srch_arr);
						$brandid = $bkey;
						$input['brand'] = $bvalue;
						$flag_brand = 1;
						$GLOBALS['ISC_SRCH_BRAND_NAME'] = ucwords($bvalue);
						break;
					}
				}
			}
			/*---- ALternate Names For Brands --------*/
			if($flag_brand == 0) {
				foreach($brandaltname as $baltkey => $baltvalue) {
					if(!empty($baltvalue)) {
						$balt_name = strtolower($baltvalue);
						$brandalternate_names = explode(",",$balt_name);
						usort($brandalternate_names,'altname_sort');
						for($i=0;$i<count($brandalternate_names);$i++)
						{
							$in_str = "";
							$track_srch_key = array();
							$brand_name = $brandname[$baltkey];
							for($k=0;$k<$count_srch;$k++)
							{
								if(stristr($brandalternate_names[$i],rtrim($srch_arr[$k], 's'))) {
									$track_srch_key[] = $k;
									if(!empty($in_str))
									$in_str .= " ".rtrim($srch_arr[$k], 's');
									else
									$in_str .= rtrim($srch_arr[$k], 's');
								}
							}
						
							//if(ltrim($brandalternate_names[$i]) == $in_str || ltrim($brandalternate_names[$i]) == $in_str.'s' ) {
							if($this->_isMatchedKeyword($brandalternate_names[$i], $in_str, $input['search_query'])){//zcs=[New version]
								$compare_brand_name = $in_str;
								foreach($track_srch_key as $key => $val) {
									unset($srch_arr[$val]);
								}
								$srch_arr = array_values($srch_arr);
								$brandid = $baltkey;
								$input['brand'] = $brand_name;
								$flag_brand = 1;
								$GLOBALS['ISC_SRCH_BRAND_NAME'] = ucwords($brand_name);
								break;
							}
						}
					}
				}
			}

			if($flag_brand == 0)  // if brand is not selected, then need to search in series list
			{
				$brandseriesname = array();
				$brandseriesaltname = array();
				$brseriesparent = array();
				$series_qry = "select seriesid , s.brandid , brandname , seriesname , seriesaltkeyword from [|PREFIX|]brand_series s left join [|PREFIX|]brands b on b.brandid = s.brandid order by CHAR_LENGTH(seriesname) desc";
				$series_res = $GLOBALS['ISC_CLASS_DB']->Query($series_qry);
				while($series_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($series_res))
				{
					$brseriesparent[$series_arr['seriesid']] = $series_arr['brandid'];
					$brandseriesname[$series_arr['seriesid']] = $series_arr['seriesname'];
					$brandseriesaltname[$series_arr['seriesid']] = $this->_AdjustKeywords($series_arr['seriesaltkeyword'], $series_arr['seriesname']);//ltrim($series_arr['seriesaltkeyword'].','.$series_arr['seriesname'], ',');//zcs=Can accept series name
				}			

				/* -------- for series names ----------- */
				//wirror_2010_10_21: search enhancement
				if(!$ismartSearch){
					foreach($brandseriesname as $bskey => $bsvalue) {
						$series_name = strtolower($bsvalue);
						$in_str = "";
						$track_srch_key = array();
						for($k=0;$k<$count_srch;$k++)
						{
							if(stristr($series_name,rtrim($srch_arr[$k], 's'))) {
								$track_srch_key[] = $k;
								if(!empty($in_str))
								$in_str .= " ".rtrim($srch_arr[$k], 's');
								else
								$in_str .= rtrim($srch_arr[$k], 's');
							}
						}

						if($series_name == $in_str || $series_name == $in_str.'s' ) {
							$compare_brand_name = $in_str;
							foreach($track_srch_key as $key => $val) {
								unset($srch_arr[$val]);
							}
							$srch_arr = array_values($srch_arr);
							$brandid = $brseriesparent[$bskey];
							$input['brand'] = $brandname[$brandid];
							$input['series'] = $bsvalue;
							$flag_brand = 1;
							$flag_brand_series = 1; // need to assign, to know the series has been selected
							$GLOBALS['BRAND_SERIES_FLAG'] = 1;
							$GLOBALS['ISC_SRCH_BRAND_NAME'] =  ucwords($brandname[$brseriesparent[$bskey]]);
							break;
						}
					}
				}
				/* -------- for series alternate keywords ----------- */

				if($flag_brand == 0) {
					foreach($brandseriesaltname as $bsaltkey => $bsaltvalue) {
						if(!empty($bsaltvalue)) {
							$bsalt_name = strtolower($bsaltvalue);
							$brandseriesalternate_names = explode(",",$bsalt_name);
							usort($brandseriesalternate_names,'altname_sort');
							for($i=0;$i<count($brandseriesalternate_names);$i++)
							{
								$in_str = "";
								$track_srch_key = array();
								$brand_name = $brandname[$brseriesparent[$bsaltkey]];
								for($k=0;$k<$count_srch;$k++)
								{
									if(stristr($brandseriesalternate_names[$i],rtrim($srch_arr[$k], 's'))) {
										$track_srch_key[] = $k;
										if(!empty($in_str))
										$in_str .= " ".rtrim($srch_arr[$k], 's');
										else
										$in_str .= rtrim($srch_arr[$k], 's');
									}
								}

								//if(ltrim($brandseriesalternate_names[$i]) == $in_str || ltrim($brandseriesalternate_names[$i]) == $in_str.'s') {
								if($this->_isMatchedKeyword($brandseriesalternate_names[$i], $in_str, $input['search_query'])){//zcs=[New version]
									$compare_brand_name = $in_str;
									foreach($track_srch_key as $key => $val) {
										unset($srch_arr[$val]);
									}
									$srch_arr = array_values($srch_arr);
									$brandid = $brseriesparent[$bsaltkey];
									$input['brand'] = $brandname[$brandid];
									$input['series'] = $brandseriesname[$bsaltkey];
									$flag_brand = 1;
									$flag_brand_series = 1; // need to assign, to know the series has been selected
									$GLOBALS['BRAND_SERIES_FLAG'] = 1;
									$GLOBALS['ISC_SRCH_BRAND_NAME'] =  ucwords($brandname[$brandid]);
									break;
								}
							}
						}
					}
				}

			}

			$count_srch = count($srch_arr);

			if($count_srch > 0 && $flag_catg == 0)
			{

				/* Checking first in category names */
				//wirror_2010_10_21: search enhancement
				if(!$ismartSearch){
					foreach($catgoryname as $key => $value)//($i=0;$i<count($catgoryname);$i++)
					{
						$catg_name = strtolower($catgoryname[$key]['catname']);
						//$catg_name = strtolower($catgoryname[$i]);
						$in_str = "";
						$track_srch_key = array();
						for($k=0;$k<$count_srch;$k++)
						{
							if(stristr($catg_name,rtrim($srch_arr[$k], 's'))) {
								$track_srch_key[] = $k;
								if(!empty($in_str))
								$in_str .= " ".rtrim($srch_arr[$k], 's');
								else
								$in_str .= rtrim($srch_arr[$k], 's');

								if($catg_name == $in_str || $catg_name == $in_str.'s' )
								break;
							}
						}

						if($catg_name == $in_str || $catg_name == $in_str.'s') {

							$compare_catg_name = $in_str;

							for($j=0;$j<count($track_srch_key);$j++) {
								unset($srch_arr[$track_srch_key[$j]]);
							}
							$srch_arr = array_values($srch_arr);

							if($catgoryname[$key]['catparentid'] != 0)   // checking its not a parent catg ?
							$flag_sub_catg = 1;

							$catg_id = $key;
							
							//alandy_2011-11-4 add.
							$find_catg_id[] = $key;
							
							$flag_catg = 1;
							$input['catuniversal'] = $catuniversal[$key];
							//alandy_2011-11-4 commit.
							//break;
						}

					}
				}
				//alandy_2012-1-6 add flag_catg=0.
				/* Checking in category alternate names */
				if($flag_catg == 0) {

					//NI CLOUD 2010-07-28
					//filter to get longest alt keywords
					$altcat = array();
					foreach( $categoryaltname as $altkey => $altvalue)
					{
						$categoryaltname[$altkey]['altkeywords'] = trim($categoryaltname[$altkey]['altkeywords']);
						if(!empty($categoryaltname[$altkey]['altkeywords'])) {
							$alternate_names = explode(",",$categoryaltname[$altkey]['altkeywords']);
							usort($alternate_names,'altname_sort');

							for($i=0;$i<count($alternate_names);$i++)
							{
								$in_str = "";
								$track_srch_key = array();
								$altname = strtolower(trim($alternate_names[$i]));
								for($k=0;$k<$count_srch;$k++)
								{
									if(strlen(stristr($altname,rtrim($srch_arr[$k], 's'))) > 0 ) {
										$track_srch_key[] = $k;
										if(!empty($in_str))
										$in_str .= " ".$srch_arr[$k];
										else
										$in_str .= $srch_arr[$k];
										
										//2011-11-11 11:11 alandy_modify.
										//if($altname == rtrim($in_str, 's') && !empty($in_str)){
										if($this->_isMatchedKeyword($altname, $in_str, $input['search_query'])){//zcs=[New version]
											$catg_name = strtolower($categoryaltname[$altkey]['catname']);//zcs=fix Bug #8574
											$altcat[] = $altname;
											$find_catg_id[] = $altkey;
											
											if($categoryaltname[$altkey]['catparentid'] == 0){
												$find_parent_catg_id[] = $altkey;
											}
										}
									}
								}
							}
						}
					}

					$max = '';
					for($m=0;$m<count($altcat);$m++)
					{
						if( strlen($max) < strlen($altcat[$m]) )
						$max = $altcat[$m];
					}

                    //alandy mark. about search categoryid.
                     //var_dump($count_srch);  $count_srch=1;
                     //var_dump($max);          "catalytic";
                     //var_dump($srch_arr);    array(1) { [0]=> string(9) "catalytic" } ;
                   /*  
					foreach($categoryaltname as $altkey => $altvalue)
					{ 
						$categoryaltname[$altkey]['altkeywords'] = trim($categoryaltname[$altkey]['altkeywords']);
						if(!empty($categoryaltname[$altkey]['altkeywords'])) {

							$catg_name = strtolower($categoryaltname[$altkey]['catname']);
							
							$alternate_names = explode(",",$categoryaltname[$altkey]['altkeywords']);
							usort($alternate_names,'altname_sort');
							
							for($i=0;$i<count($alternate_names);$i++)
							{
								$in_str = "";
								$track_srch_key = array();
								$altname = strtolower(trim($alternate_names[$i]));
							
								//eg:catalytic
								for($k=0;$k<$count_srch;$k++)
								{ 	
									
									if(!empty($in_str)){
										$in_str .= " ".$srch_arr[$k];
									}else{
										$in_str .= $srch_arr[$k];
									}
									
									if(($altname == rtrim($in_str,'s')) && !empty($in_str)){
										
										$find_catg_id[] = $altkey;
										
									}
									/* alandy_2011-11-4 commit.
									if(stristr($max,rtrim($srch_arr[$k], 's'))) {
										$track_srch_key[] = $k;
										if(!empty($in_str))
										$in_str .= " ".$srch_arr[$k];
										else
										$in_str .= $srch_arr[$k];
                                        
										if($max == rtrim($in_str, 's'))
										break;
									}
									/////////////////////////////
								}
								
								/* alandy_2011-11-4 commit.
								if($altname == rtrim($in_str, 's') && strlen($altname)>0 && !empty($in_str)) {
									$compare_catg_name = rtrim($in_str, 's');
									for($j=0;$j<count($track_srch_key);$j++) {
										unset($srch_arr[$track_srch_key[$j]]);
									}
									$srch_arr = array_values($srch_arr);

									if($categoryaltname[$altkey]['catparentid'] != 0)   // checking its not a parent catg ?
									$flag_sub_catg = 1;

									$catg_id = $altkey;
																		
									$flag_catg = 1;
									$input['catuniversal'] = $catuniversal[$altkey];
									break;
								}
								///////////////////////
							}

							//if($flag_catg == 1)
							//break;

						}
					}
					*/
				}
			}
		}
	
		//2011-11-4 alandy add.
		if(!empty($find_catg_id)){
			$tmpSubCat = array();//zcs=
			foreach ($find_catg_id as $valid){
				if($categoryaltname[$valid]['catparentid'] != 0){   // checking its not a parent catg ?
					//$flag_sub_catg = 1;//zcs=[Old version]
					$tmpSubCat[] = $valid;//zcs=remember sub cats
				}

				$catg_id = $valid;

				$flag_catg = 1;
				$input['catuniversal'] = $catuniversal[$valid];
				break;
			}
			//zcs=>Only if here has one sub cat,we will assign this flag to 1 ([NOTE]it seems the FLAG may affect the shown of "Landing Page" OR "Product List")
			if(count($tmpSubCat) == 1){
				$flag_sub_catg = 1;
			}
			//<=zcs
		}
		
//alandy mark exit;
//var_dump($find_catg_id);
//exit;
		/*----------------- for selecting category ---------------------*/

		if(isset($_GET['search_key']) || isset($_REQUEST['search']))  {

			if (in_array("chevy", $srch_arr)) {
				$input['make'] = "chevrolet";
				$key = array_search('chevy',$srch_arr);
				unset($srch_arr[$key]);
				$srch_arr = array_values($srch_arr);
			}

			$inner_qry = "";
			$flag_model = 0;

			if(count($srch_arr) > 0) {
				$query = " select distinct q.column_name , v.qid , q_value from isc_qualifier_value v left join isc_qualifier_names q on v.qid = q.qid where v.qid != 0 and ( ";
				foreach($srch_arr as $key => $value)
				{
					if(empty($inner_qry))
					$inner_qry .= " q_value like '%$value%' ";
					else
					$inner_qry .= " OR q_value like '%$value%' ";
				}
				if($inner_qry == "")
				$inner_qry .= " 1=1 ";

				$query .= $inner_qry." ) order by qid , CHAR_LENGTH(q_value) desc";
				$srch_res1 = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$model_array = array();
				$model_qry = "";
				while($srch_row1 = $GLOBALS['ISC_CLASS_DB']->Fetch($srch_res1))
				{
					if($srch_row1['qid'] == 1) {
						if(!isset($input['make'])) {
							$in_make = "";
							$track_make_array = array();
							for($j=0;$j<count($srch_arr);$j++)
							{
								if (stristr($srch_row1['q_value'] , $srch_arr[$j])) {
									$track_make_array[] = $j;
									if(!empty($in_make))
									$in_make .= " ".$srch_arr[$j];
									else
									$in_make .= $srch_arr[$j];

									if($in_make == strtolower($srch_row1['q_value']))
									break;
								}
							}
							if($in_make == strtolower($srch_row1['q_value'])) {
								$input['make'] = $srch_row1['q_value'];
								for($k=0;$k<count($track_make_array);$k++)
								{
									unset($srch_arr[$track_make_array[$k]]);
								}
								$srch_arr = array_values($srch_arr);
							}
						}
					} else if($srch_row1['qid'] == 2) {
						if(isset($input['make']) && $model_qry == "" && $input['make'] != "") // if make is selected
						{
							$inner_qry = "";
							$model_qry = "select distinct prodmodel from isc_import_variations where prodmake = '".$input['make']."' and ( ";
							foreach($srch_arr as $key => $value)
							{
								if(empty($inner_qry))
								$inner_qry .= " prodmodel like '%$value%' ";
								else
								$inner_qry .= " OR prodmodel like '%$value%' ";
							}
							if(empty($inner_qry))
							$inner_qry  = " 1=1 ";

							$model_qry .= $inner_qry . " )   order by CHAR_LENGTH(prodmodel) desc";

							$model_res = $GLOBALS['ISC_CLASS_DB']->Query($model_qry);

							while($model_row = $GLOBALS['ISC_CLASS_DB']->Fetch($model_res))
							{
								if( $flag_model == 0 )
								{
									$in_str = "";
									$track_srch_key = array();
									$count_model_str = 1;
									$temp_str = "";
									$model_array = array();
									$model_value = strtolower($model_row['prodmodel']);
									for($k=0;$k<count($srch_arr);$k++)
									{

										$srchkey = preg_replace($regex_chars,$regex_replace_chars,$srch_arr[$k]);

										if($in_str == "")
										$match = "/(^$srchkey(\s{1})|^$srchkey\b)/i";
										else
										$match = "/((\s{1})$srchkey\b)/i";

										if(preg_match($match,$model_value)) {
											if($count_model_str > 1)
											{
												$temp_str = $in_str." ".$srch_arr[$k];
												if(($m = stripos($model_value , $temp_str)) !== false) {
													$track_srch_key[] = $k;
													$in_str .= " ".$srch_arr[$k];
													$count_model_str++;
												}
											}
											else
											{
												$track_srch_key[] = $k;
												$in_str .= $srch_arr[$k];
												$count_model_str++;
											}

										}
									}
									//echo "<br>".$in_str;
									if($in_str != "" && $in_str == $model_value)
									{
										$input['model'] = $in_str;
										for($j=0;$j<count($track_srch_key);$j++) {
											unset($srch_arr[$track_srch_key[$j]]);
										}
										$srch_arr = array_values($srch_arr);
										unset($model_array);
										$flag_model = 1;
										break;
									}
									else if($in_str != "")
									{
										if(!isset($input['model']))
										{
											$model_array = $track_srch_key;
											$input['model'] = $in_str;
										}
										else if($m = stripos($in_str , $input['model']) !== false)
										{
											$model_array = $track_srch_key;
											$input['model'] = $in_str;
										}

									}
								}
							}
						}
						else if(!isset($input['make']))	// if make is not selected
						{
							if( $flag_model == 0 )
							{
								$in_str = "";
								$track_srch_key = array();
								$count_model_str = 1;
								$temp_str = "";
								$model_array = array();
								$model_value = strtolower($srch_row1['q_value']);
								for($k=0;$k<count($srch_arr);$k++)
								{

									$srchkey = preg_replace($regex_chars,$regex_replace_chars,$srch_arr[$k]);

									if($in_str == "")
									$match = "/(^$srchkey(\s{1})|^$srchkey\b)/i";
									else
									$match = "/((\s{1})$srchkey\b)/i";

									if(preg_match($match,$model_value)) {

										if($count_model_str > 1)
										{
											$temp_str = $in_str." ".$srch_arr[$k];
											if(($m = stripos($model_value , $temp_str)) !== false) {
												$track_srch_key[] = $k;
												$in_str .= " ".$srch_arr[$k];
												$count_model_str++;
											}
										}
										else
										{
											$track_srch_key[] = $k;
											$in_str .= $srch_arr[$k];
											$count_model_str++;
										}

									}
								}

								if($in_str != "" && $in_str == $model_value)
								{
									$input['model'] = $in_str;
									for($j=0;$j<count($track_srch_key);$j++) {
										unset($srch_arr[$track_srch_key[$j]]);
									}
									$srch_arr = array_values($srch_arr);
									unset($model_array);
									$flag_model = 1;
									break;
								}
								else if($in_str != "")
								{
									if(!isset($input['model']))
									{
										$model_array = $track_srch_key;
										$input['model'] = $in_str;
									}
									else if($m = stripos($in_str , $input['model']) !== false)
									{
										$model_array = $track_srch_key;
										$input['model'] = $in_str;
									}

								}
							}
						}
					} else if( $srch_row1['qid'] == 4 || $srch_row1['qid'] == 5 ) {

						/* this below patch is used to remove keywords selected from the search array where model is partial selected */
						if(isset($model_array) && !empty($model_array) && $flag_model == 0) {
							for($j=0;$j<count($model_array);$j++) {
								unset($srch_arr[$model_array[$j]]);
							}
							$srch_arr = array_values($srch_arr);
							unset($model_array);
						}

						if(!isset($input['year'])) {
							for($j=0;$j<count($srch_arr);$j++)
							{
								if($srch_row1['q_value'] == $srch_arr[$j]) {
									$input['year'] = $srch_row1['q_value'];
									unset($srch_arr[$j]);
									$srch_arr = array_values($srch_arr);
									break;
								}
							}
						}
					} else if( $srch_row1['qid'] != 6 && $srch_row1['qid'] != 7 ) {

						/* this below patch is used to remove keywords selected from the search array where model is partial selected */
						if(isset($model_array) && !empty($model_array) && $flag_model == 0) {
							for($j=0;$j<count($model_array);$j++) {
								unset($srch_arr[$model_array[$j]]);
							}
							$srch_arr = array_values($srch_arr);
							unset($model_array);
						}

						if(isset($input[$srch_row1['column_name']]))
						continue;

						$qualifier_names = explode(";",$srch_row1['q_value']);
						for($j=0;$j<count($qualifier_names);$j++)
						{
							$in_str = "";
							$track_srch_key = array();
							$qualifier_name = strtolower($qualifier_names[$j]);
							for($k=0;$k<count($srch_arr);$k++)
							{
								//if(stristr($srch_row1['prodmodel'],$srch_arr[$j]))
								//if(strtolower($srch_row1['prodmodel']) == $srch_arr[$j])

								$srchkey = preg_replace($regex_chars,$regex_replace_chars,$srch_arr[$k]);

								if($in_str == "")
								$match = "/(^$srchkey(\s{1})|^$srchkey\b)/i";
								else
								$match = "/(((\s{1})$srchkey(\s{1}))|((\s{1})$srchkey$))/i";

								if(preg_match($match,$qualifier_name)) {
									$track_srch_key[] = $k;
									if(!empty($in_str))
									$in_str .= " ".$srch_arr[$k];
									else
									$in_str .= $srch_arr[$k];

									if($qualifier_name == $in_str) // if matched early, then need to break it here.
									break;
								}
							}
							if($qualifier_name == $in_str) // if matched early, then need to break it here.
							break;
						}

						if($qualifier_name == $in_str) {
							$input[strtolower($srch_row1['column_name'])] = $qualifier_name;
							foreach($track_srch_key as $key => $val) {
								unset($srch_arr[$val]);
							}
							$srch_arr = array_values($srch_arr);
						}
					}

					if(count($srch_arr) == 0)
					break;

				}

				if(isset($model_array) && !empty($model_array) && $flag_model == 0) {
					for($j=0;$j<count($model_array);$j++) {
						unset($srch_arr[$model_array[$j]]);
					}
					$srch_arr = array_values($srch_arr);
					unset($model_array);
				}

				$bedsize_qry = " select distinct irregular_value as vqvalue from [|PREFIX|]bedsize_translation where irregular_value != 'Short bed' and irregular_value != 'Full Crew Cab' UNION select distinct generalize_value as vqvalue from [|PREFIX|]bedsize_translation where generalize_value != 'Short bed' and generalize_value != 'Mega Cab' order by char_length(vqvalue) desc ";

				$bedsize_res = $GLOBALS['ISC_CLASS_DB']->Query($bedsize_qry);
				$temp_bedsize = array();
				while($bedsize_row = $GLOBALS['ISC_CLASS_DB']->Fetch($bedsize_res))
				{
					$in_str = "";
					$track_srch_key = array();
					//$temp_bedsize = array();
					$count_model_str = 1;
					$bed_value = strtolower($bedsize_row['vqvalue']);
					for($j=0;$j<count($srch_arr);$j++)
					{
						$srchkey = preg_replace($regex_chars,$regex_replace_chars,$srch_arr[$j]);
						$match = "/(((\s{1})$srchkey(\s{1}))|(\b$srchkey(\s{1}))|((\s{1})$srchkey\b)|(^$srchkey$))/i";

						if (preg_match($match , $bed_value))
						{
							if($count_model_str > 1)
							{
								$track_srch_key[] = $j;
								$in_str .= " ".$srch_arr[$j];
								$count_model_str++;
							}
							else
							{
								$track_srch_key[] = $j;
								$in_str .= $srch_arr[$j];
								$count_model_str++;
							}
						}
					}

					if($in_str != "" && $in_str == $bed_value)
					{
						$input['vqbedsize'] = $in_str;
						for($j=0;$j<count($track_srch_key);$j++) {
							unset($srch_arr[$track_srch_key[$j]]);
						}
						$srch_arr = array_values($srch_arr);
						unset($temp_bedsize);
						break;
					}
					else if($in_str != "")
					{
						if( count($track_srch_key) == 1 && trim($in_str) == 'bed' && count($track_srch_key) > count($temp_bedsize) )
						{
							$input['vqsbedsize'] = $in_str;
							$temp_bedsize = $track_srch_key;
						}
						else if( count($track_srch_key) > 1 && count($track_srch_key) > count($temp_bedsize) )
						{
							$input['vqsbedsize'] = $in_str;
							$temp_bedsize = $track_srch_key;
						}
					}
				}

				if(isset($temp_bedsize) && !empty($temp_bedsize)) {
					for($j=0;$j<count($temp_bedsize);$j++) {
						unset($srch_arr[$temp_bedsize[$j]]);
					}
					$srch_arr = array_values($srch_arr);
					unset($temp_bedsize);
				}

				$cabsize_qry = " select distinct irregular_value as vqvalue from [|PREFIX|]cabsize_translation
			UNION select distinct generalize_value as vqvalue from [|PREFIX|]cabsize_translation
			order by char_length(vqvalue) desc ";

				$cabsize_res = $GLOBALS['ISC_CLASS_DB']->Query($cabsize_qry);
				$temp_cabsize = array();
				while($cabsize_row = $GLOBALS['ISC_CLASS_DB']->Fetch($cabsize_res))
				{
					$in_str = "";
					$track_srch_key = array();
					$count_model_str = 1;
					$cab_value = strtolower($cabsize_row['vqvalue']);
					for($j=0;$j<count($srch_arr);$j++)
					{
						$srchkey = preg_replace($regex_chars,$regex_replace_chars,$srch_arr[$j]);
						$match = "/(((\s{1})$srchkey(\s{1}))|(\b$srchkey(\s{1}))|((\s{1})$srchkey\b)|(^$srchkey$))/i";
						if (preg_match($match , $cab_value))
						{
							if($count_model_str > 1)
							{
								$track_srch_key[] = $j;
								$in_str .= " ".$srch_arr[$j];
								$count_model_str++;
							}
							else
							{
								$track_srch_key[] = $j;
								$in_str .= $srch_arr[$j];
								$count_model_str++;
							}
						}
					}

					if($in_str != "" && $in_str == $cab_value)
					{
						$input['vqcabsize'] = $in_str;
						for($j=0;$j<count($track_srch_key);$j++) {
							unset($srch_arr[$track_srch_key[$j]]);
						}
						$srch_arr = array_values($srch_arr);
						unset($temp_cabsize);
						break;
					}
					else if($in_str != "")
					{
						if( count($track_srch_key) == 1 && trim($in_str) == 'cab' && count($track_srch_key) > count($temp_cabsize) )
						{
							$input['vqscabsize'] = $in_str;
							$temp_cabsize = $track_srch_key;
						}
						else if( count($track_srch_key) > 1 && count($track_srch_key) > count($temp_bedsize) )
						{
							$input['vqscabsize'] = $in_str;
							$temp_cabsize = $track_srch_key;
						}
					}
				}

				if(isset($temp_cabsize) && !empty($temp_cabsize)) {
					for($j=0;$j<count($temp_cabsize);$j++) {
						unset($srch_arr[$temp_cabsize[$j]]);
					}
					$srch_arr = array_values($srch_arr);
					unset($temp_cabsize);
				}

				/*
				 if(!isset($input['make']) && isset($input['model']) )
				 {
				 $get_make_qry = "select distinct make from isc_product_mmy where model like '".$input['model']."%' limit 0,1";
				 $get_make_res = $GLOBALS['ISC_CLASS_DB']->Query($get_make_qry);
				 $get_make_row = $GLOBALS['ISC_CLASS_DB']->FetchOne($get_make_res);
				 $input['make'] = $get_make_row;
				 }
				 */
				if(!isset($input['year'])) {
					for($i=0;$i<count($srch_arr);$i++)
					{
						if(is_numeric($srch_arr[$i])) {
							if(strlen($srch_arr[$i]) == 2) {
								$prodyr = $srch_arr[$i];
								$curr_yr = date('y');

								if($prodyr >= 00 && $prodyr <= $curr_yr)
								$prodyr = 2000 + $prodyr;
								else
								$prodyr = 1900 + $prodyr;

							} else {
								$prodyr = $srch_arr[$i];
							}

							$year_qry = " select year1 , year2  from (select min(prodstartyear) as year1 from isc_import_variations where prodstartyear != '') sy , (select max(prodendyear) as year2 from isc_import_variations where prodendyear != 'ALL' ) ey where $prodyr between year1 and year2 ";
							$year_result = $GLOBALS['ISC_CLASS_DB']->Query($year_qry);
							$year_row = $GLOBALS['ISC_CLASS_DB']->CountResult($year_result);

							if($year_row == 1) {
								$input['year'] = $prodyr;
								unset($srch_arr[$i]);
								$srch_arr = array_values($srch_arr);
								break;
							}
						}
					}
				}

				// checking the partnumber from the remaining search parameters
				if(count($srch_arr) > 0) {
					$inner_qry = "";
					$product_code_query = " SELECT prodcode FROM [|PREFIX|]products p WHERE ";
					foreach($srch_arr as $key => $value)
					{
						if(empty($inner_qry))
						$inner_qry .= " prodcode like '$value%' ";
						else
						$inner_qry .= " OR prodcode like '$value%' ";
					}
					$product_code_query .= $inner_qry;
					$product_code_res = $GLOBALS['ISC_CLASS_DB']->Query($product_code_query);
					while($product_code_row = $GLOBALS['ISC_CLASS_DB']->Fetch($product_code_res))
					{
						$prod_code = strtolower($product_code_row['prodcode']);
						$track_srch_key = array();
						for($j=0;$j<count($srch_arr);$j++)
						{
							if(stristr($prod_code,$srch_arr[$j]))
							{
								if($prod_code == $srch_arr[$j])
								{
									unset($srch_arr[$j]);
									$srch_arr = array_values($srch_arr);
									$input['partnumber'] = $prod_code;
									$partnumber_flag = 0;
									break;
								} else {
									$input['partnumber'] = $srch_arr[$j];
									$partnumber_flag = 1;
								}
							}
						}

						if($partnumber_flag == 0)
						break;
					}
				}

			}

			$input['search_string']	=	implode(" ",$srch_arr);

			/*----------------- End for selecting category ---------------------*/

		}


		$searchTerms = array();
		$matches = array();
		$searchTerms['dynfilters'] = array();

		/*----------------- for selecting category ---------------------*/
		$searchTerms['flag_srch_category'] = 0;

		if(isset($input['partnumber'])) {
			$searchTerms['partnumber'] = $input['partnumber'];
		}

		if(isset($input['search'])) {
			$searchTerms['search'] = $input['search'];
		}

		if(isset($input['searchtext'])) {
			$searchTerms['searchtext'] = $input['searchtext'];
		}

		if(isset($input['search_string'])) {
			$searchTerms['search_string'] = $input['search_string'];
		}

		/* the below code is to find out whether category or brand is entered first */
		$check_position = 0; // 1 if catg is first and 0 if brand is first
		
		//alandy_2011-11-9 mark.
		if($flag_catg == 1 && $flag_brand == 1)
		{
			$catg_pos = stripos($input['search_query'], $compare_catg_name);
			$brand_pos = stripos($input['search_query'], $compare_brand_name);
			if($catg_pos < $brand_pos)
			{
				$check_position = 1;
			}
			else
			{
				$input['category'] = $catg_name;
				$flag_catg = 0; // resetting to 0 as category is entered after brand so it should be passed in $input['category']
				$check_position = 0;
			}
		}

		if($flag_brand == 1 && $check_position == 0) {
			$searchTerms['flag_srch_brand'] = $flag_brand_series;
		}

		if(isset($input['category'])) {
			$searchTerms['category'] = $input['category'];
			$category_name = $input['category'];
			$get_catgories_qry = "SELECT categoryid FROM isc_categories WHERE (catname='".$category_name."' OR catparentid IN (SELECT categoryid FROM isc_categories WHERE catname='".$category_name."')) order by catparentid";
			$get_category_res = $GLOBALS['ISC_CLASS_DB']->Query($get_catgories_qry);
			while($get_category_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($get_category_res))
			{
				$searchTerms['srch_category'][] = $get_category_arr['categoryid'];
			}
			$GLOBALS['ISC_SRCH_CATG_NAME'] =  ucwords($category_name);
			$GLOBALS['ISC_SRCH_CATG_ID'] =  $searchTerms['srch_category'][0];
			$input['catuniversal'] = $searchTerms['catuniversal'] = $catuniversal[$searchTerms['srch_category'][0]];
		}

		if($flag_catg == 1 ) {
			$GLOBALS['ISC_SRCH_CATG_NAME'] =  ucwords($catg_name);
			$GLOBALS['ISC_SRCH_CATG_ID'] =  $catg_id;

			/* the below patch has been added below for the catogories having the make as non-spec vehicle */
			/*if($catg_id == 17 OR $catg_id == 3 OR $catg_id == 7 OR $catg_id == 18 OR $catg_id == 1 OR $catg_id == 2) {
			 $searchTerms['is_catg'] = 1;
			 }*/
/*
			$sub_catgid = array();
			if($flag_sub_catg == 0) {      // if its a parent catg, need to find the sub-categories

				$sub_catgqry = "select categoryid from isc_categories where catparentid = $catg_id ";
				//$sub_catgqry = "select categoryid from isc_categories where catparentid in(".implode(',',$catg_id).")";
				
				$sub_catgres =  $GLOBALS['ISC_CLASS_DB']->Query($sub_catgqry);
				if($GLOBALS['ISC_CLASS_DB']->CountResult($sub_catgres) > 0) {     // if there are no subcategories under a main category
					while($sub_catgarr = $GLOBALS['ISC_CLASS_DB']->Fetch($sub_catgres))
					{
						$sub_catgid[] =  $sub_catgarr['categoryid'];
					}
					$sub_catgid[] = $catg_id;
				}  else {
					$flag_sub_catg = 1;
					$sub_catgid[] = $catg_id;
				}

			} else {    // else it is a sub-category

				$sub_catgid[] = $catg_id;

			}
		*/	
			//alandy 2011-9-14 add multi category search.
			/*
			if(!empty($max)){
				$newsearch="SELECT categoryid,catparentid FROM isc_categories WHERE catname LIKE '%".$max."%' OR catmetakeywords LIKE '%".$max."%'";
					
				$newsearch_result =  $GLOBALS['ISC_CLASS_DB']->Query($newsearch);
				if($GLOBALS['ISC_CLASS_DB']->CountResult($newsearch) > 0) {
					while($rs = $GLOBALS['ISC_CLASS_DB']->Fetch($newsearch_result))
					{
						$newsub_catgid[] =  $rs['categoryid'];
					}

					$searchTerms['srch_category'] =  $newsub_catgid;
				}
			}else{
				$searchTerms['srch_category'] =  $sub_catgid;
			}
			*/
			
			if(!empty($find_catg_id)){
				$sub_catgid = array();//zcs=fix Bug #8370
				$sub_catgqry = "select categoryid from isc_categories where catparentid in (".implode(',',$find_catg_id).")";
				
				//$sub_catgqry = "select categoryid from isc_categories where catparentid in(".implode(',',$catg_id).")";

				$sub_catgres =  $GLOBALS['ISC_CLASS_DB']->Query($sub_catgqry);
				if($GLOBALS['ISC_CLASS_DB']->CountResult($sub_catgres) > 0) {     // if there are no subcategories under a main category
					while($sub_catgarr = $GLOBALS['ISC_CLASS_DB']->Fetch($sub_catgres))
					{
						$sub_catgid[] =  $sub_catgarr['categoryid'];
					}
					
				} 
				$searchTerms['srch_category'] = array_merge($find_catg_id,$sub_catgid);
			}
			
			//var_dump($searchTerms['srch_category']);exit;
			//alandy test.
		    //$searchTerms['srch_category']=array(663,664,588,587,590,34);
		    
			$searchTerms['flag_srch_category'] = $flag_sub_catg;
			//$searchTerms['srch_category'] =  $sub_catgid;
			//var_dump($searchTerms['srch_category']);
			//exit;

			if(isset($input['catuniversal']))
			$searchTerms['catuniversal'] = $input['catuniversal'];
		}
		
		if(!empty($find_parent_catg_id)){
			$searchTerms['srch_parent_category'] = $find_parent_catg_id;
		}
		
		/*----------------- End for selecting category ---------------------*/

		// Here we parse out any advanced search identifiers from the search query such as price:, :rating etc

		$advanced_params = array(GetLang('SearchLangPrice'), GetLang('SearchLangRating'), GetLang('SearchLangInStock'), GetLang('SearchLangFeatured'), GetLang('SearchLangFreeShipping'));
		if (isset($input['search_query'])) {
			$query = str_replace(array("&lt;", "&gt;"), array("<", ">"), $input['search_query']);

			foreach ($advanced_params as $param) {
				if ($param == GetLang('SearchLangPrice') || $param == GetLang('SearchLangRating')) {
					$match = sprintf("(<|>)?([0-9\.%s]+)-?([0-9\.%s]+)?", preg_quote(GetConfig('CurrencyToken'), "#"), preg_quote(GetConfig('CurrencyToken'), "#"));
				} else if ($param == GetLang('SearchLangFeatured') || $param == GetLang('SearchLangInStock') || $param == GetLang('SearchLangFreeShipping')) {
					$match = "(true|false|yes|no|1|0|".preg_quote(GetLang('SearchLangYes'), "#")."|".preg_quote(GetLang('SearchLangNo'), "#").")";
				} else {
					continue;
				}
				preg_match("#\s".preg_quote($param, "#").":".$match.'(\s|$)#i', $query, $matches);
				if (count($matches) > 0) {
					if ($param == "price" || $param == "rating") {
						if ($matches[3]) {
							$input[$param.'_from'] = (float)$matches[2];
							$input[$param.'_to'] = (float)$matches[3];
						} else {
							if ($matches[1] == "<") {
								$input[$param.'_to'] = (float)$matches[2];
							} else if ($matches[1] == ">") {
								$input[$param.'_from'] = (float)$matches[2];
							} else if ($matches[1] == "") {
								$input[$param] = (float)$matches[2];
							}
						}
					} else if ($param == "featured" || $param == "instock" || $param == "freeshipping") {
						if ($param == "freeshipping") {
							$param = "shipping";
						}
						if ($matches[1] == "true" || $matches[1] == "yes" || $matches[1] == 1) {
							$input[$param] = 1;
						}
						else {
							$input[$param] = 0;
						}
					}
					$matches[0] = str_replace(array("<", ">"), array("&lt;", "&gt;"), $matches[0]);
					$input['search_query'] = trim(preg_replace("#".preg_quote(trim($matches[0]), "#")."#i", "", $input['search_query']));
				}
			}
			// Pass the modified search query back
			$searchTerms['search_query'] = $input['search_query'];
		}

		if(isset($input['categoryid'])) {
			$input['category'] = $input['categoryid'];
		}
		/*
		 if (isset($input['category'])) {
		 if (!is_array($input['category'])) {
		 $input['category'] = array($input['category']);
		 }
		 $searchTerms['category'] = $input['category'];
		 }
		 */
		if (isset($input['searchsubs']) && $input['searchsubs'] != "") {
			$searchTerms['searchsubs'] = $input['searchsubs'];
		}

		if (isset($input['price']) && $input['price'] != "") {
			$searchTerms['price'] = $input['price'];
		}

		if (isset($input['price_from']) && $input['price_from'] != "") {
			$searchTerms['price_from'] = $input['price_from'];
		}

		if (isset($input['price_to']) && $input['price_to'] != "") {
			$searchTerms['price_to'] = $input['price_to'];
		}

		if (isset($input['rating']) && $input['rating'] != "") {
			$searchTerms['rating'] = $input['rating'];
		}

		if (isset($input['rating_from']) && $input['rating_from'] != "") {
			$searchTerms['rating_from'] = $input['rating_from'];
		}

		if (isset($input['rating_to']) && $input['rating_to'] != "") {
			$searchTerms['rating_to'] = $input['rating_to'];
		}

		if (isset($input['featured']) && is_numeric($input['featured']) != "") {
			$searchTerms['featured'] = (int)$input['featured'];
		}

		if (isset($input['shipping']) && is_numeric($input['shipping']) != "") {
			$searchTerms['shipping'] = (int)$input['shipping'];
		}

		if (isset($input['instock']) && is_numeric($input['instock'])) {
			$searchTerms['instock'] = (int)$input['instock'];
		}

		if (isset($input['brand']) && $input['brand'] != "") {
			$searchTerms['brand'] = $input['brand'];
			$brand_query = "select brandid from [|PREFIX|]brands WHERE brandname='".$searchTerms['brand']."'";
			$brand_result = $GLOBALS['ISC_CLASS_DB']->Query($brand_query);
			$GLOBALS['brandId'] = $GLOBALS['ISC_CLASS_DB']->FetchOne($brand_result);
			/* this below condition is added to get the brand name when clicked on brand after selecting any category */
			if(!isset($GLOBALS['ISC_SRCH_BRAND_NAME']))
			$GLOBALS['ISC_SRCH_BRAND_NAME'] = $searchTerms['brand'];
		}

		if (isset($input['make']) && $input['make'] != "") {
			$searchTerms['make'] = $input['make'];
			unset($input['prodmake']);
		}
		/* this below 3 lines are added as db has the name as prodmodel for model and prodsubmodel as submodel*/
		if (isset($input['prodmodel']) && $input['prodmodel'] != "") {
			$input['model'] = $input['prodmodel'];
		}

		if (isset($input['model']) && $input['model'] != "" && ( !isset($input['search_key']) || (isset($input['search_key']) && $input['model'] != 'all') ) ) {
			$searchTerms['model'] = $input['model'];
			unset($input['prodmodel']);

			$_REQUEST['model'] = $input['model'];
			/* the below flag is set to check whether exact model is searched or similar to the model is searched */
			if(isset($flag_model))
			$searchTerms['model_flag'] = $flag_model;
		}

		/* the below condition is checked whether the flag is returning from the links in the side filter section in search result page */
		if(isset($input['model_flag']) && $input['model_flag'] != "") {
			$searchTerms['model_flag'] = $input['model_flag'];
		}

		if (isset($input['prodsubmodel']) && $input['prodsubmodel'] != "") {
			$input['submodel'] = $input['prodsubmodel'];
		}

		if (isset($input['submodel']) && $input['model'] != "") {
			$searchTerms['submodel'] = $input['submodel'];
			unset($input['prodsubmodel']);
		}

		if (isset($input['year']) && $input['year'] != "" && ( !isset($input['search_key']) || (isset($input['search_key']) && $input['year'] != 'all') ) ) {
			$searchTerms['year'] = $input['year'];
		}

		/*if (isset($input['brand']) && $input['brand'] != "") {
		 $searchTerms['brand'] = $input['brand'];
		 }

		 if (isset($input['from_price']) && $input['from_price'] != "") {
		 $searchTerms['from_price'] = $input['from_price'];
		 }

		 if (isset($input['to_price']) && $input['to_price'] != "") {
		 $searchTerms['to_price'] = $input['to_price'];
		 }

		 if (isset($input['bedsize']) && $input['bedsize'] != "") {
		 $searchTerms['bedsize'] = $input['bedsize'];
		 }

		 if (isset($input['cover']) && $input['cover'] != "") {
		 $searchTerms['cover'] = $input['cover'];
		 }

		 if (isset($input['color']) && $input['color'] != "") {
		 $searchTerms['color'] = $input['color'];
		 }*/


		if(isset($input['subcategory']) && !empty($input['subcategory'])) {
			$sub_category = $input['subcategory'];
			$searchTerms['subcategory'] = $input['subcategory'];
			
			//alandy_2011-11-11 modify.
			//$sub_catg_qry = "select categoryid , catname from isc_categories where catname = '".$sub_category."' and catparentid = ".$GLOBALS['ISC_SRCH_CATG_ID'];
			$sub_catg_qry = "select categoryid , catname from isc_categories where catname = '".$sub_category."'";
			$sub_catg_res = $GLOBALS['ISC_CLASS_DB']->Query($sub_catg_qry);
			$sub_catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($sub_catg_res);
			if($GLOBALS['ISC_CLASS_DB']->CountResult($sub_catg_res) > 0)
			{
				$GLOBALS['subcategoryid'] = $sub_catg_arr['categoryid'];
			}
			else
			{
				$sub_catg_qry = "select categoryid , catname from isc_categories where categoryid = ".$GLOBALS['ISC_SRCH_CATG_ID'];
				$sub_catg_res = $GLOBALS['ISC_CLASS_DB']->Query($sub_catg_qry);
				$sub_catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($sub_catg_res);
				$GLOBALS['subcategoryid'] = $sub_catg_arr['categoryid'];
			}

			/* the below query is written to get the main category anme when subcategory is selected directly */
			//alandy_2011-11-11 modify.
			//$main_catg_qry = "select p.categoryid , p.catname from isc_categories as p inner join isc_categories as c on p.categoryid = c.catparentid and c.catname = '".$sub_category."' and c.catparentid = ".$GLOBALS['ISC_SRCH_CATG_ID'];
			$main_catg_qry = "select p.categoryid , p.catname from isc_categories as p inner join isc_categories as c on p.categoryid = c.catparentid and c.catname = '".$sub_category;
			$main_catg_res =  $GLOBALS['ISC_CLASS_DB']->Query($main_catg_qry);
			$main_catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($main_catg_res);
			$main_catg_rows = $GLOBALS['ISC_CLASS_DB']->CountResult($main_catg_res);
			if($main_catg_rows == 0) {
				$main_catg_arr = $sub_catg_arr;
			}

			$GLOBALS['ISC_SRCH_CATG_NAME'] =  ucwords($main_catg_arr['catname']);
			$GLOBALS['ISC_SRCH_CATG_ID'] =  $main_catg_arr['categoryid'];

			//if(in_array($sub_category,$sub_catgid)) {
			//$sub_catgid = $sub_category;
			$searchTerms['srch_category'] =  array($GLOBALS['subcategoryid']);
			$searchTerms['flag_srch_category'] = 1;
			$searchTerms['catuniversal'] = $catuniversal[$GLOBALS['subcategoryid']];
			//}
		}

		// need to know the category name when brand and series are selected
		if(isset($input['series']) && !empty($input['series'])) {
			$searchTerms['series'] = $input['series'];
			$searchTerms['flag_srch_brand'] = 1;
			$GLOBALS['BRAND_SERIES_FLAG'] = 1;

			$main_catg_qry = "select s.seriesid from isc_brand_series s where s.seriesname = '".$input['series']."' ";
			$main_catg_res =  $GLOBALS['ISC_CLASS_DB']->Query($main_catg_qry);
			$main_catg_rows = $GLOBALS['ISC_CLASS_DB']->CountResult($main_catg_res);
			$main_catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($main_catg_res);
			$GLOBALS['seriesid'] = $main_catg_arr['seriesid'];
			if($main_catg_rows > 0) {
				/*$GLOBALS['ISC_SRCH_CATG_NAME'] =  ucwords($main_catg_arr['catname']);
				 $GLOBALS['ISC_SRCH_CATG_ID'] =  $main_catg_arr['categoryid'];
				 $searchTerms['srch_category'] =  array($GLOBALS['ISC_SRCH_CATG_ID']);
				 $searchTerms['catuniversal'] = $catuniversal[$main_catg_arr['categoryid']];*/
			}
		}

		if(isset($GLOBALS['ISC_SRCH_CATG_ID']))
		{
			$RelatedCatsQuery = "SELECT DISTINCT c.categoryid
                                FROM isc_products p 
                                LEFT JOIN isc_categoryassociations ca ON ca.productid = p.productid 
                                LEFT JOIN isc_categories c ON c.categoryid = ca.categoryid ";

			if(isset($input['series']) && !empty($input['series']))
			{
				$RelatedCatsQuery.= "
                        LEFT JOIN isc_brands b ON prodbrandid = b.brandid 
                        LEFT JOIN isc_brand_series AS bs ON bs.seriesid = p.brandseriesid ";
			}

			$RelatedCatsQuery .= " WHERE 1=1 AND c.categoryid IS NOT NULL AND p.prodvisible='1' ";

			$temp_categories_ids = $searchTerms['srch_category'];
			if(!isset($temp_categories_ids))
			{
				$temp_categories_ids = array();
			}
			if(in_array($GLOBALS['ISC_SRCH_CATG_ID'],$temp_categories_ids)) {
				// No subcatg under category
				$sidequalifier_query = "select distinct qn.qid , qn.column_name , qa.qualifier_visible from isc_qualifier_associations qa left join isc_qualifier_names qn on qn.qid = qa.qualifierid
                    where qa.categoryid = ".$GLOBALS['ISC_SRCH_CATG_ID'];   

				$RelatedCatsQuery .= " AND (c.categoryid = ".$GLOBALS['ISC_SRCH_CATG_ID']." || c.catparentid = ".$GLOBALS['ISC_SRCH_CATG_ID'].")";

			}
			else if(!in_array($GLOBALS['ISC_SRCH_CATG_ID'] , $temp_categories_ids) && isset($input['subcategory'])) {
				//   product listing page
				$sidequalifier_query = "select distinct qn.qid , qn.column_name , qa.qualifier_visible from isc_qualifier_associations qa left join isc_qualifier_names qn on qn.qid = qa.qualifierid where qa.categoryid = ".$GLOBALS['subcategoryid'];

				$RelatedCatsQuery .= " AND c.categoryid = ".$GLOBALS['subcategoryid']."";
			}

			if(isset($input['series']) && !empty($input['series']))
			{
				$brand_id = (int)$GLOBALS['brandId'];
				$RelatedCatsQuery.= " AND p.prodbrandid='".$GLOBALS['ISC_CLASS_DB']->Quote($brand_id)."' AND p.brandseriesid = ".$GLOBALS['seriesid']."";
			}

			$RelatedCatsResult  = $GLOBALS['ISC_CLASS_DB']->Query($RelatedCatsQuery);
			$RelatedCats        = array();
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($RelatedCatsResult)) {
				$RelatedCats[] = (int) $row['categoryid'];
			}
			if(count($RelatedCats)> 0)
			{

				$RelatedCats = implode(",", $RelatedCats);
	
				$qualifier_query = " SELECT
	                            DISTINCT qn.qid , qn.column_name , qa.qualifier_visible 
	                            FROM isc_qualifier_associations qa 
	                            LEFT JOIN isc_qualifier_names qn ON qn.qid = qa.qualifierid      
	                            WHERE qa.categoryid IN (".$RelatedCats.")";  
				//OR qa.categoryid IN (SELECT catparentid FROM isc_categories WHERE categoryid IN (".$RelatedCats."))
	
				GetQualifierColumns($qualifier_query, $qualifier_columns, $VCols, $PCols);
				$GLOBALS['sidev_cols'] = $VCols;
				$GLOBALS['sidep_cols'] = $PCols;
				
				if(isset($sidequalifier_query))
				{
					GetQualifierColumns($sidequalifier_query, $sidequalifier_columns, $SideVCols, $SidePCols);
					$GLOBALS['v_cols'] = $SideVCols;
					$GLOBALS['p_cols'] = $SidePCols;
				}
			}

		} else    {

			$RelatedCatsQuery = "SELECT DISTINCT c.categoryid
                                FROM isc_products p 
                                LEFT JOIN isc_categoryassociations ca ON ca.productid = p.productid 
                                LEFT JOIN isc_categories c ON c.categoryid = ca.categoryid ";

			if(isset($input['series']) && !empty($input['series']))
			{
				$RelatedCatsQuery.= "
                        LEFT JOIN isc_brands b ON prodbrandid = b.brandid 
                        LEFT JOIN isc_brand_series AS bs ON bs.seriesid = p.brandseriesid ";
			}

			$RelatedCatsQuery.= " WHERE 1=1 AND c.categoryid IS NOT NULL AND p.prodvisible='1' ";

			if(isset($input['series']) && !empty($input['series']))
			{
				$brand_id = (int)$GLOBALS['brandId'];
				$RelatedCatsQuery.= " AND p.prodbrandid='".$GLOBALS['ISC_CLASS_DB']->Quote($brand_id)."' AND p.brandseriesid = ".$GLOBALS['seriesid']."";
			}

			//$RelatedCatsQuery = $GLOBALS['StartNumber'];

			$RelatedCatsResult  = $GLOBALS['ISC_CLASS_DB']->Query($RelatedCatsQuery);
			$RelatedCats        = array();
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($RelatedCatsResult)) {
				$RelatedCats[] = (int) $row['categoryid'];
			}
			if(count($RelatedCats)> 0)
			{
				$RelatedCats = implode(",", $RelatedCats);
	
				$qualifier_query = "SELECT
	                                DISTINCT qn.qid , qn.column_name , qa.qualifier_visible 
	                                FROM isc_qualifier_associations qa 
	                                LEFT JOIN isc_qualifier_names qn ON qn.qid = qa.qualifierid      
	                                WHERE qa.categoryid IN (".$RelatedCats.")";
				//OR qa.categoryid IN (SELECT catparentid FROM isc_categories WHERE categoryid IN (".$RelatedCats."))
				$qualifier_result = $GLOBALS['ISC_CLASS_DB']->Query($qualifier_query);
	
				GetQualifierColumns($qualifier_query, $qualifier_columns, $VCols, $PCols);
				$GLOBALS['sidev_cols'] = $VCols;
				$GLOBALS['sidep_cols'] = $PCols;
			}

		}

		$GLOBALS['v_cols'] = isset($GLOBALS['v_cols']) ? $GLOBALS['v_cols'] : array();
		$GLOBALS['p_cols'] = isset($GLOBALS['p_cols']) ? $GLOBALS['p_cols'] : array();

		$qualifier_count = count($GLOBALS['sidev_cols']) + count($GLOBALS['sidep_cols']);

		/*------------ For Dynamic filters ------------------*/

		for($qid=0;$qid<$qualifier_count;$qid++)
		{
			$dynval = strtolower($qualifier_columns[$qid]);
			if(isset($input[$dynval]) && !empty($input[$dynval])) {
				$q_value =  $input[$dynval];
				$dynval = preg_replace("/^([a-zA-Z0-9]{2})/e", "strtoupper('\\1')", $dynval); // making the first 2 letters capital of the qualifier name
				$searchTerms['dynfilters'][$dynval] = $q_value;
			}
		}

		if( isset($input['vqbedsize']) )
		{
			unset($input['vqsbedsize']);
		}
		else if( isset($input['vqsbedsize']) )
		{
			$searchTerms['vqsbedsize'] = $input['vqsbedsize'];
		}

		if( isset($input['vqcabsize']) )
		{
			unset($input['vqscabsize']);
		}
		else if( isset($input['vqscabsize']) )
		{
			$searchTerms['vqscabsize'] = $input['vqscabsize'];
		}

		/*====================== Cookies section below ================================ */

		$number_of_days = 730 ;
		$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;

		if( isset($input['vqbedsize']) )
		{
			setcookie( "last_search_selection[bedsize]", $input['vqbedsize'], $date_of_expiry ,"/");
		}
		else
		{
			setcookie( "last_search_selection[bedsize]",'', $date_of_expiry ,"/");
		}

		if( isset($input['vqcabsize']) )
		{
			setcookie( "last_search_selection[cabsize]", $input['vqcabsize'], $date_of_expiry ,"/");
		}
		else
		{
			setcookie( "last_search_selection[cabsize]",'', $date_of_expiry ,"/");
		}

		if( isset($_COOKIE['last_search_selection']) && !isset($searchTerms['make']) && !isset($GLOBALS['ISC_CLASS_REDEFINE_SEARCH']) && !isset($input['change']) ) {

			if(!empty($_COOKIE['last_search_selection']['make']) )
			{
				$searchTerms['make'] = $_COOKIE['last_search_selection']['make'];

				if(isset($searchTerms['model']))
				{
					$model_validate_qry  = "select model from [|PREFIX|]product_mmy where ";
					if(!isset($searchTerms['model_flag']) || $searchTerms['model_flag'] == 1)
					$model_validate_qry  .=	" make = '".$searchTerms['make']."' and model = '".$searchTerms['model']."'";
					else
					$model_validate_qry  .=	" make = '".$searchTerms['make']."' and model like '".$searchTerms['model']."%'";

					$model_validate_res	 = $GLOBALS['ISC_CLASS_DB']->Query($model_validate_qry);

					if( $GLOBALS['ISC_CLASS_DB']->CountResult($model_validate_res) == 0 )
					{
						unset($searchTerms['model'],$searchTerms['model_flag'],$_REQUEST['model'],$_COOKIE['last_search_selection']['model']);
					}
				}

			}

			if(!empty($_COOKIE['last_search_selection']['make']))
			$searchTerms['make'] = $_COOKIE['last_search_selection']['make'];

			// This condition is added as to check  if only model is searched, then no need to update cookie. so storing empty value
			if( !isset($searchTerms['make']) && isset($searchTerms['model']) )
			{
				setcookie( "last_search_selection[model]", '', $date_of_expiry ,"/");
			}
			else if( isset($searchTerms['make']) && !empty($_COOKIE['last_search_selection']['model']) )	// This condition is to check if make is selected before retrieving model from cookie.
			{
				$searchTerms['model'] = $_COOKIE['last_search_selection']['model'];
				$_REQUEST['model'] =  $searchTerms['model'];
			}

			if(!isset($searchTerms['model']) && !empty($_COOKIE['last_search_selection']['model'])) {
				$searchTerms['model'] = $_COOKIE['last_search_selection']['model'];
				$_REQUEST['model'] =  $searchTerms['model'];
			} /*else {
			unset($searchTerms['model'],$searchTerms['model_flag'],$_REQUEST['model']);
			}*/

			if(!isset($searchTerms['year']) && !empty($_COOKIE['last_search_selection']['year'])) {
				$searchTerms['year'] = $_COOKIE['last_search_selection']['year'];
				$_REQUEST['year'] =  $searchTerms['year'];
			}

			if( isset($searchTerms['make']) )
			setcookie( "last_search_selection[make]", $searchTerms['make'], $date_of_expiry ,"/");
			else
			{
				if(isset($_COOKIE['last_search_selection']['make']))
				$searchTerms['make'] = $_COOKIE['last_search_selection']['make'];
			}
			if( isset($searchTerms['model']) )
			setcookie( "last_search_selection[model]", $searchTerms['model'], $date_of_expiry ,"/");
			else
			{
				if(isset($_COOKIE['last_search_selection']['model']))
				{
					$searchTerms['model'] = $_COOKIE['last_search_selection']['model'];
				}
			}
			if( isset($searchTerms['year']) )
			setcookie( "last_search_selection[year]", $searchTerms['year'], $date_of_expiry ,"/" );
			else
			{
				if(isset($_COOKIE['last_search_selection']['year']))
				$searchTerms['year'] = $_COOKIE['last_search_selection']['year'];
			}
			//setcookie( "last_search_selection[MMY_KEY]", time(), $date_of_expiry  );

		} else if(!isset($GLOBALS['ISC_CLASS_REDEFINE_SEARCH'])) {

			if( isset($searchTerms['make']) )
			setcookie( "last_search_selection[make]", $searchTerms['make'], $date_of_expiry ,"/");
			else if( isset($_COOKIE['last_search_selection']) && isset($_COOKIE['last_search_selection']['make']) )
			$searchTerms['make'] = $_COOKIE['last_search_selection']['make'];

			if( isset($searchTerms['make']) && isset($searchTerms['model']) && ( !isset($searchTerms['model_flag']) || $searchTerms['model_flag'] == 1 ) )
			setcookie( "last_search_selection[model]", $searchTerms['model'], $date_of_expiry ,"/");
			else if( isset($_COOKIE['last_search_selection']) && isset($_COOKIE['last_search_selection']['model']) )
			$searchTerms['model'] = $_COOKIE['last_search_selection']['model'];

			if( isset($searchTerms['year']) )
			setcookie( "last_search_selection[year]", $searchTerms['year'], $date_of_expiry ,"/" );
			else if( isset($_COOKIE['last_search_selection']) && isset($_COOKIE['last_search_selection']['year']) )
			$searchTerms['year'] = $_COOKIE['last_search_selection']['year'];
			//setcookie( "last_search_selection[MMY_KEY]", time(), $date_of_expiry  );
		}

		//NI CLOUD 2010-06-18
		//add YMM validating logic
		$query = "SELECT 'ALL' AS
					TYPE , MIN( prodstartyear ) AS MIN_StartYear, MAX( prodendyear ) AS MAX_EndYear
					FROM isc_import_variations v
					INNER JOIN isc_products p ON v.productid = p.productid
					WHERE p.prodvisible =1 and `prodstartyear` <> 'all' AND `prodendyear` <> 'all'  and `prodstartyear` <> '' AND `prodendyear` <> ''  and `prodstartyear` is not null AND `prodendyear` is not null
					UNION ALL SELECT 'MAKE' AS 
					TYPE , MIN( prodstartyear ) AS MIN_StartYear, MAX( prodendyear ) AS MAX_EndYear
					FROM isc_import_variations v
					INNER JOIN isc_products p ON v.productid = p.productid
					WHERE p.prodvisible =1 and `prodstartyear` <> 'all' AND `prodendyear` <> 'all'  and `prodstartyear` <> '' AND `prodendyear` <> ''  and `prodstartyear` is not null AND `prodendyear` is not null
					AND prodmake = '".(isset($searchTerms["make"])?$searchTerms["make"]:'')."'
					GROUP BY prodmake
					UNION ALL SELECT 'MODAL' AS 
					TYPE , MIN( prodstartyear ) AS MIN_StartYear, MAX( prodendyear ) AS MAX_EndYear
					FROM isc_import_variations v
					INNER JOIN isc_products p ON v.productid = p.productid
					WHERE p.prodvisible =1 and `prodstartyear` <> 'all' AND `prodendyear` <> 'all'  and `prodstartyear` <> '' AND `prodendyear` <> ''  and `prodstartyear` is not null AND `prodendyear` is not null
					AND prodmake = '".(isset($searchTerms["make"])?$searchTerms["make"]:'')."'
					AND prodmodel = '".(isset($searchTerms["model"])?$searchTerms["model"]:'')."'
					GROUP BY prodmake + prodmodel";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		//validate model
		if( $GLOBALS['ISC_CLASS_DB']->CountResult($result) < 3 )
		{
			unset($searchTerms["model"]);
			unset($searchTerms["model_flag"]);
			//alandy_2012-1-31 commit.don't unset model cookie.
			//setcookie( "last_search_selection[model]", '', $date_of_expiry ,"/");
		}
		//validate make
		if( $GLOBALS['ISC_CLASS_DB']->CountResult($result) < 2 )
		{
			unset($searchTerms["make"]);
		}
		//validate year
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))
		{
			if( isset($searchTerms["year"]) && ( $searchTerms["year"] > (int)$row["MAX_EndYear"] || $searchTerms["year"] < (int)$row["MIN_StartYear"] ) )
			{
				unset($searchTerms["year"]);
			}
		}
		/* the below query is used to check whether any series exist under the selected brand */
		/*if( isset($searchTerms['flag_srch_brand']) &&  $searchTerms['flag_srch_brand'] == 0  && !empty($searchTerms['brand'])) {

			$brand_series_qry = "select p.brandseriesid from isc_products p LEFT JOIN isc_categoryassociations ca on ca.productid = p.productid LEFT JOIN isc_categories c on c.categoryid = ca.categoryid LEFT JOIN isc_import_variations AS v ON p.productid = v.productid
WHERE prodbrandid in(select brandid from [|PREFIX|]brands WHERE brandname='". $searchTerms['brand']."')  and brandseriesid != 0 $where2 $outer_condition group by brandseriesid";
			echo $brand_series_qry;
			$brand_series_res = $GLOBALS['ISC_CLASS_DB']->Query($brand_series_qry);
			if($GLOBALS['ISC_CLASS_DB']->CountResult($brand_series_res) > 0)
			$GLOBALS['BRAND_SERIES_FLAG'] = 0;     // series exist under a brand
			else
			$GLOBALS['BRAND_SERIES_FLAG'] = 1;     // series not exist under a brand

		}*/
		
		$searchTerms["ismartSearch"] = $ismartSearch;
		
		return $searchTerms;
	}

	function GetJoinCountQueryTables()
	{
		$tables = "	LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid 
					LEFT JOIN [|PREFIX|]categoryassociations ca on ca.productid = p.productid 
					LEFT JOIN [|PREFIX|]categories c on c.categoryid = ca.categoryid 
					LEFT JOIN [|PREFIX|]brands b on prodbrandid = b.brandid 
					LEFT JOIN [|PREFIX|]brand_series AS bs ON bs.seriesid = p.brandseriesid ";
		return $tables;
	}

	function GetJoinQueryTables()
	{
		$tables = " LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid 
					LEFT JOIN [|PREFIX|]categoryassociations ca on ca.productid = p.productid 
					LEFT JOIN [|PREFIX|]categories c on c.categoryid = ca.categoryid 
					LEFT JOIN [|PREFIX|]brands b on prodbrandid = b.brandid 
					LEFT JOIN [|PREFIX|]brand_series AS bs ON bs.seriesid = p.brandseriesid 
					LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid AND pi.imageisthumb=1) 
					LEFT JOIN [|PREFIX|]product_finalprice fp ON p.productid = fp.productid 
					LEFT JOIN [|PREFIX|]prodcut_cap_size_images csi ON p.prodcode = csi.productcode and p.prodvendorprefix = csi.vendor_prix ";
		return $tables;
	}
	
	function myclear($a)
	{
		/*if(empty($a))
		{
			return false;
		}*/
		if(is_string($a))
		{
			$a = trim($a);
		}
		return $a <> "";
	}

	function GetCategoryQuery()
	{
		$Subcateids = implode(',', $this->_searchterms["srch_category"]) ;
		
		$queryWhere = $this->GetWhereBySearchItems($outer_condition,$havingquery);
		
		if(!empty($havingquery))
		{
			$queryWhere[] = implode(' AND ', $havingquery);
			unset($havingquery);
		}
		//$queryWhere = array_filter($queryWhere,"myclear");
		
		$where = "";
		if(count($queryWhere) > 0)
		{
			$where = " and " .implode(' AND ', $queryWhere);
		}
		//alandy_2011-11-4 modify category where.
		
		if(empty($Subcateids)){
			$where = "WHERE 1=1  $where $outer_condition ";
		}else{
			$where = "WHERE 1=1 AND c.categoryid IN (".$Subcateids.") $where $outer_condition ";
		}

		//$where = "WHERE 1=1 AND c.categoryid IN (".$Subcateids.") $where $outer_condition ";
		$fromTable = " isc_products p ";
		$orderBy= " ORDER BY c.catdeptid ASC, c.catsort ASC, c.catname ASC";
		$countQuery = " SELECT count(p.productid) from " .$fromTable . $this->GetJoinCountQueryTables().$where;
		$GLOBALS['srch_where'] = "c.catname , c.categoryid , c.catuniversal , c.catimagealt , c.featurepoints , group_concat(DISTINCT brandname separator '~') as brandname ,
				 group_concat(DISTINCT p.brandseriesid separator '~') as seriesids , min(fp.prodfinalprice) as prodminprice , max(fp.prodfinalprice) as prodmaxprice , 
				c.catimagefile as imagefile , c.cathoverimagefile , p.proddesc , prodwarranty , bs.seriesname, bs.displayname, p.brandseriesid , 
				count(distinct p.productid) as totalproducts,floor(SUM(p.prodratingtotal)/SUM(p.prodnumratings)) AS prodavgrating";
		$query ="select " .$GLOBALS['srch_where'] ." from ".$fromTable;
		$query .= $this->GetJoinQueryTables().$where;
		return array(
			'query' => $query,
			'countQuery' => $countQuery,
			'orderby' => $orderBy
		);

	}

	function GetSeriesQuery()
	{
		$qualifier_flag = 0;
		$brandWhere = "";
		if (isset( $this->_searchterms['brand']) &&  $this->_searchterms['brand'] != "") {
			$brand_query = "select brandid from [|PREFIX|]brands WHERE brandname='". $this->_searchterms['brand']."'";
			$brand_result = $GLOBALS['ISC_CLASS_DB']->Query($brand_query);
			$brandId = $GLOBALS['ISC_CLASS_DB']->FetchOne($brand_result);
			if((int)$brandId > 0)
			{
				$qualifier_flag = 1;
				$brandWhere =  " and p.prodbrandid='" . $GLOBALS['ISC_CLASS_DB']->Quote($brandId) . "'";
			}
		}
		
		$queryWhere = $this->GetWhereBySearchItems($outer_condition,$havingquery);
		if(!empty($havingquery))
		{
			$queryWhere[] = implode(' AND ', $havingquery);
			unset($havingquery);
		}
		
		//$queryWhere = array_filter($queryWhere,"myclear");
		
		$where = $brandWhere;
		$where2 = "";
		if(count($queryWhere) > 0)
		{
			$where .=" and " .implode(' AND ', $queryWhere);
			$where2 .=" and " .implode(' AND ', $queryWhere);
		}		

		$where = "WHERE 1=1 AND c.categoryid is not null $where AND p.brandseriesid != 0  $outer_condition ";
		$fromTable = " isc_products p ";
		$joinQuery = " LEFT JOIN isc_categories pa on pa.categoryid = c.catparentid ";
		$orderBy= " ORDER BY bs.seriessort ASC , bs.seriesname ASC ";
		$countQuery = " SELECT count(p.productid) from " .$fromTable . $this->GetJoinCountQueryTables().$joinQuery.$where;
		$GLOBALS['srch_where'] = "c.catname , c.categoryid , c.catuniversal , group_concat(DISTINCT ca.categoryid separator '~') as subcatgids , pa.catname as parentcatname ,
		 group_concat(DISTINCT brandname separator '~') as brandname , min(fp.prodfinalprice) as prodminprice , max(fp.prodfinalprice) as prodmaxprice , bs.seriesphoto as imagefile , 
		 p.proddesc , prodwarranty , bs.seriesname, bs.displayname, p.brandseriesid , count(distinct p.productid) as totalproducts , bs.feature_points1 , bs.feature_points2 ,
		  bs.feature_points3 , bs.feature_points4 , bs.feature_points , bs.seriesimagealt ,  b.brandimagefile , b.brandlargefile , b.branddescription , b.brandfooter, bs.serieshoverimagefile,
		  floor(SUM(p.prodratingtotal)/SUM(p.prodnumratings)) AS prodavgrating ";
		
		$query ="select " .$GLOBALS['srch_where'] ." from ".$fromTable;
		$query .= $this->GetJoinQueryTables().$joinQuery.$where;
		return array(
			'query' => $query,
			'countQuery' => $countQuery,
			'orderby' => $orderBy
		);

	}

	function GetWhereBySearchItems(&$outer_condition="",&$havingquery=array())
	{
		$qualifier_flag =0;
		$searchTerms = $this->_searchterms;
		$queryWhere = array();
		$queryWhere1 = array();
		$queryWhere1[] = $queryWhere[] = "p.prodvisible='1'";
		
		//return $queryWhere1;

		// Add in the group category restrictions
		$permissionSql = GetProdCustomerGroupPermissionsSQL(null, false);
		if($permissionSql && !empty($permissionSql)) {
			$queryWhere1[] = $queryWhere[] = $permissionSql;
		}

		// Do we need to filter on brand?
		if (isset($searchTerms['brand']) && $searchTerms['brand'] != "") {
			$brand_query = "select brandid from [|PREFIX|]brands WHERE brandname='".$searchTerms['brand']."'";
			$brand_result = $GLOBALS['ISC_CLASS_DB']->Query($brand_query);
			$brandId = $GLOBALS['ISC_CLASS_DB']->FetchOne($brand_result);
			if((int)$brandId > 0)
			{
				$qualifier_flag = 1;
				$queryWhere1[] = $queryWhere[] = "p.prodbrandid='" . $GLOBALS['ISC_CLASS_DB']->Quote($brandId) . "'";
			}
		}

		// Do we need to filter on brand series?
		if (isset($searchTerms['series']) && $searchTerms['series'] != "") {
			$qualifier_flag = 1;
			if(isset($GLOBALS['seriesid']))
			{
				$brand_series_id = (int)$GLOBALS['seriesid'];
			}
			else
			{
				$series_qry = "select s.seriesid from isc_brand_series s where s.seriesname = '".$searchTerms['series']."' ";
				$series_res =  $GLOBALS['ISC_CLASS_DB']->Query($series_qry);
				$series_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($series_res);
				$brand_series_id = (int)$series_arr['seriesid'];
			}
			$queryWhere1[] = $queryWhere[] = " p.brandseriesid = " . $GLOBALS['ISC_CLASS_DB']->Quote($brand_series_id);
		}

		if(isset($searchTerms['partnumber'])) {
			$qualifier_flag = 1;
			$prod_code =  $searchTerms['partnumber'];
			$queryWhere1[] = $queryWhere[] = " p.prodcode like '".$prod_code."%'";
		}

		// Do we need to filter on price?
		if (isset($searchTerms['price'])) {
			$queryWhere1[] = $queryWhere[] = "p.prodcalculatedprice='".$GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['price'])."'";
		} else {
			/*if (isset($searchTerms['price_from']) && is_numeric($searchTerms['price_from'])) {
			 $queryWhere1[] = $queryWhere[] = "p.prodcalculatedprice >= '".$GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['price_from'])."'";
			 }

			 if (isset($searchTerms['price_to']) && is_numeric($searchTerms['price_to'])) {
			 $queryWhere1[] = $queryWhere[] = "p.prodcalculatedprice <= '".$GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['price_to'])."'";
			 }*/
		}

		// Do we need to filter on rating?
		if (isset($searchTerms['rating'])) {
			$queryWhere1[] = $queryWhere[] = "FLOOR(p.prodratingtotal/p.prodnumratings) = '".(int)$searchTerms['rating']."'";
		}
		else {
			if (isset($searchTerms['rating_from']) && is_numeric($searchTerms['rating_from'])) {
				$queryWhere1[] = $queryWhere[] = "FLOOR(p.prodratingtotal/p.prodnumratings) >= '".(int)$searchTerms['rating_from']."'";
			}

			if (isset($searchTerms['rating_to']) && is_numeric($searchTerms['rating_to'])) {
				$queryWhere1[] = $queryWhere[] = "FLOOR(p.prodratingtotal/p.prodnumratings) <= '".(int)$searchTerms['rating_to']."'";
			}
		}

		// Do we need to filter on featured?
		if (isset($searchTerms['featured']) && $searchTerms['featured'] != "") {
			$featured = (int)$searchTerms['featured'];

			if ($featured == 1) {
				$queryWhere1[] = $queryWhere[] = "p.prodfeatured=1";
			}
			else {
				$queryWhere1[] = $queryWhere[] = "p.prodfeatured=0";
			}
		}

		// Do we need to filter on free shipping?
		if (isset($searchTerms['shipping']) && $searchTerms['shipping'] != "") {
			$shipping = (int)$searchTerms['shipping'];

			if ($shipping == 1) {
				$queryWhere1[] = $queryWhere[] = "p.prodfreeshipping='1' ";
			}
			else {
				$queryWhere1[] = $queryWhere[] = "p.prodfreeshipping='0' ";
			}
		}

		// Do we need to filter only products we have in stock?
		if (isset($searchTerms['instock']) && $searchTerms['instock'] != "") {
			$stock = (int)$searchTerms['instock'];
			if ($stock == 1) {
				$queryWhere1[] = $queryWhere[] = "(p.prodcurrentinv>0 or p.prodinvtrack=0) ";
			}
		}

		// Do we need to filter for make of the product
		if (isset($searchTerms['make']) && $searchTerms['make'] != ""  && ( !isset($searchTerms['catuniversal']) || $searchTerms['catuniversal'] != 1 ) ) {
			$make = $searchTerms['make'];
			if (!empty($make)) {
				$qualifier_flag = 1;
				$ext = "";
				//if(isset($searchTerms['is_catg']))
				$ext .= " OR v.prodmake = 'NON-SPEC VEHICLE' ";

				$queryWhere[] = " ( v.prodmake = '".$make."' $ext ) ";
				$queryWhere1[] = " ( v.prodmake = '".$make."' $ext ) ";
			}
		}

		// Do we need to filter for model of the product
		if (isset($searchTerms['model']) && $searchTerms['model'] != ""  && ( !isset($searchTerms['catuniversal']) || $searchTerms['catuniversal'] != 1 ) ) {
			$model = $searchTerms['model'];
			if (!empty($model)) {
				$qualifier_flag = 1;
				$ext = "";
				//if(isset($searchTerms['is_catg']))
				$ext .= " OR v.prodmodel = 'ALL' ";

				//if(isset($_REQUEST['model'])) {
				if(!isset($searchTerms['model_flag']) || ( isset($searchTerms['model_flag']) && $searchTerms['model_flag'] == 1 )) {
					$queryWhere[] = " ( v.prodmodel = '".$model."' $ext ) ";
					$queryWhere1[] = " ( v.prodmodel = '".$model."' $ext ) ";
				} else {
					$queryWhere[] = " ( v.prodmodel like '".$model."%' $ext ) ";
					$queryWhere1[] = " ( v.prodmodel like '".$model."%' $ext ) ";

				}
			}
		}

		// Do we need to filter for submodel of the product
		if (isset($searchTerms['submodel']) && $searchTerms['submodel'] != "") {
			$submodel = $searchTerms['submodel'];
			if (!empty($model)) {
				$qualifier_flag = 1;
				$queryWhere[] = " ( v.prodsubmodel = '".$submodel."' OR v.prodsubmodel = '' ) ";
				$queryWhere1[] = " ( v.prodsubmodel = '".$submodel."' OR v.prodsubmodel = '' ) ";
			}
		}

		// Do we need to filter for year of the product
		if (isset($searchTerms['year']) && $searchTerms['year'] != ""  && ( !isset($searchTerms['catuniversal']) || $searchTerms['catuniversal'] != 1 ) ) {
			$year = $searchTerms['year'];
			if (!empty($year)) {
				$qualifier_flag = 1;
				if(is_numeric($year)) {

					$ext = "";
					//if(isset($searchTerms['is_catg']))
					$ext .= " OR v.prodstartyear = 'ALL' ";

					$queryWhere[] = " ( ".$year." between v.prodstartyear and v.prodendyear $ext ) ";
					$queryWhere1[] = " ( ".$year." between v.prodstartyear and v.prodendyear $ext ) ";
				}
				else {
					$queryWhere[] = " ( v.prodstartyear = '$year' OR v.prodendyear = '$year' ) ";
					$queryWhere1[] = " ( v.prodstartyear = '$year' OR v.prodendyear = '$year' ) ";
				}
			}
		}



		if(isset($searchTerms['price_from']) && isset($searchTerms['price_to'])) {
			$from_price = $searchTerms['price_from'];
			$to_price = $searchTerms['price_to'];
			if($from_price != "" && $to_price != "") {
				$queryWhere1[] = $queryWhere[] = " p.prodcalculatedprice between ".$from_price." and ".$to_price;
			}
		} else if(isset($searchTerms['price_from'])) {
			$from_price = $searchTerms['price_from'];
			if(!empty($from_price)) {
				$queryWhere1[] = $queryWhere[] = " p.prodcalculatedprice >= ".$from_price;
			}
		} else if(isset($searchTerms['price_to'])) {
			$to_price = $searchTerms['price_to'];
			if(!empty($to_price)) {
				$queryWhere1[] = $queryWhere[] = " p.prodcalculatedprice <= ".$from_price;
			}
		}


		/*---- the below variables are used for displaying submodels in sideproductfilters.php --- */
	
		$GLOBALS['wherecondition'] = $queryWhere;
		$GLOBALS['wherecondition1'] = $queryWhere1;

		/*--------- creating conditions for dynamic filters----------*/
		$havingquery = array();
		$outer_condition = "";
		if(!empty($searchTerms['dynfilters'])) {
			$dynfilters = $searchTerms['dynfilters'];
			foreach($dynfilters as $dynkey => $dynval) {
				$qualifier_flag = 1;
				$orgdynkey = $dynkey;	//Added by Simha

				$str_to_check_pqvq = "";
				if(!isset($searchTerms['catuniversal']) || $searchTerms['catuniversal'] == 0)
				$str_to_check_pqvq =  '^(vq|pq)';
				else
				$str_to_check_pqvq =  '^pq';

				if(eregi($str_to_check_pqvq, $dynkey))
				{
					$dynkey = " v.$dynkey ";
					//$outer_condition .= " AND $dynkey like '%".$dynval."%'";

					if($dynval == 'others')
					{
						$havingquery[] = "( $orgdynkey = '' OR $orgdynkey IS NULL OR $orgdynkey = '~' )"; // here included '~' as in left navi query will return ~
					}
					else
					{
						if(strcasecmp($dynkey,' v.VQbedsize ') == 0)
						$outer_condition .= " AND ( ( ( $dynkey = '".$dynval."') OR ( $dynkey regexp ';' AND $dynkey regexp '".$dynval."' ) ) OR ( ( v.bedsize_generalname = '".$dynval."' ) OR (  v.bedsize_generalname regexp ';' AND v.bedsize_generalname regexp '".$dynval."' ) ) ) ";
						else if(strcasecmp($dynkey,' v.VQcabsize ') == 0)
						$outer_condition .= " AND ( ( ( $dynkey = '".$dynval."') OR ( $dynkey regexp ';' AND $dynkey regexp '".$dynval."' ) ) OR ( ( v.cabsize_generalname = '".$dynval."' ) OR (  v.cabsize_generalname regexp ';' AND v.cabsize_generalname regexp '".$dynval."' ) ) ) ";
						else
						$outer_condition .= " AND ( ( $dynkey regexp ';' AND $dynkey regexp '".$dynval."' ) OR ( $dynkey not regexp ';' AND $dynkey = '".$dynval."') )";
					}
				}
			}
		}

		if(isset($searchTerms['vqsbedsize']))
		{
			$qualifier_flag = 1;
			$outer_condition .= " AND (  v.VQbedsize like '%".$searchTerms['vqsbedsize']."%' OR  v.bedsize_generalname like '%".$searchTerms['vqsbedsize']."%' ) ";
		}

		if(isset($searchTerms['vqscabsize']))
		{
			$qualifier_flag = 1;
			$outer_condition .= " AND (  v.VQcabsize like '%".$searchTerms['vqscabsize']."%' OR  v.cabsize_generalname like '%".$searchTerms['vqscabsize']."%' ) ";
		}

		if( ( $qualifier_flag == 0 && isset($searchTerms['search'] ) ) && ( eregi('search.php',$_SERVER['REQUEST_URI']) || ( isset($GLOBALS['PathInfo']) && count($GLOBALS['PathInfo']) > 0 ) ) && !isset($_REQUEST['change'])) {

			//$joinQuery .= "INNER JOIN isc_product_search ps ON (p.productid=ps.productid)";
			//$joinQuery1 .= "INNER JOIN isc_product_search ps ON (p.productid=ps.productid)";

			if( isset($searchTerms['search_string']) )
			{
				$searchTerms['search_query'] = $searchTerms['search_string'];
			}

			if ( isset($searchTerms['search_query']) && $searchTerms['search_query'] != "" && $searchTerms['search_query'] != "categories" && $searchTerms['search_query'] != "brands" ) {
				//$termQuery = "(" . $GLOBALS['ISC_CLASS_DB']->FullText($fulltext_fields, $searchTerms['search_query'], true);
				//$termQuery = " ( ";
				//$termQuery = " p.prodname = '" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "' ";
				//$termQuery .= " p.prodname like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
				/*$termQuery .= "OR p.proddesc like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
				 $termQuery .= "OR p.prodsearchkeywords like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
				 $termQuery .= "OR ps.prodalternates like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
				 $termQuery .= "OR ps.prodmake like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
				 $termQuery .= "OR ps.prodmodel like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
				 $termQuery .= "OR ps.prodsubmodel like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
				 $termQuery .= "OR ps.prodstartyear like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
				 $termQuery .= "OR ps.prodendyear like '%" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "%' ";
				 $termQuery .= "OR p.prodcode = '" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "') ";*/
				//$queryWhere1[] = $queryWhere[] = $termQuery;
				
				//$termQuery = " p.prodname = '" . $GLOBALS['ISC_CLASS_DB']->Quote($searchTerms['search_query']) . "' ";
				//$queryWhere1[] = $queryWhere[] = $termQuery;
			}
		}
		


		return $queryWhere1;

	}

	function GetProductQuery($fields="")
	{
		$searchTerms = $this->_searchterms;
		$queryWhere = array();
		
		$v_cols = array();
		$p_cols = array();

		$v_cols = isset($GLOBALS['sidev_cols']) ? $GLOBALS['sidev_cols'] : array();
		$p_cols = isset($GLOBALS['sidep_cols']) ? $GLOBALS['sidep_cols'] : array();

		//2011-3-23 Ronnie add, add fields {b.callbestprice bbestprice, c.callbestprice cbestprice, bs.callbestprice sbestprice}
		$common_fields_product = " b.callbestprice bbestprice, c.callbestprice cbestprice, bs.callbestprice sbestprice, p.prodcode, p.productid , b.brandname , c.categoryid, c.catname , c.catuniversal,p.proddateadded,csi.icon_file ";
		$common_fields_variation = " p.prodcode, v.productid, v.prodstartyear, v.prodendyear , v.prodmodel, v.prodsubmodel, v.prodmake ";

		$new_fields = " p.proddesc , p.prodname , p.proddescfeature , prodwarranty , p.prodvariationid,p.prodconfigfields,p.prodeventdaterequired,p.prodvendorid,p.prodprice,p.prodretailprice,p.prodsaleprice,p.prodistaxable,p.prodcatids,p.prodhideprice,p.prodinvtrack,p.prodcurrentinv,p.prodallowpurchases,p.prodbrandid,p.prodcalculatedprice,prodweight,prodheight ";

		// Construct the full text search part of the query
		/*$fulltext_fields = array("ps.prodname", "ps.prodcode", "ps.proddesc", "ps.prodsearchkeywords", "ps.prodalternates", "ps.prodmake", "ps.prodmodel", "ps.prodsubmodel", "ps.prodstartyear", "ps.prodendyear");*/
		$fulltext_fields = array("ps.prodname", "ps.prodcode", "ps.proddesc", "ps.prodsearchkeywords");

		if (!$fields) {
			$fields = "$new_fields, FLOOR(p.prodratingtotal/p.prodnumratings) AS prodavgrating, ".GetProdCustomerGroupPriceSQL().", ";
			$fields .= "pi.imageisthumb, pi.imagefile ";
			if (isset($searchTerms['search_query']) && $searchTerms['search_query'] != "") {
				//$fields .= ', '.$GLOBALS['ISC_CLASS_DB']->FullText($fulltext_fields, $searchTerms['search_query'], false) . " as score ";
			}
		}

		$fields1 = $fields." ,v. ".implode(",v.",$v_cols);

		if(isset($searchTerms['categoryid'])) {
			$searchTerms['category'] = array($searchTerms['categoryid']);
		}

		// If we're searching by category, we need to completely
		// restructure the search query - so do that first
		$categorySearch = false;
		$categoryIds = array();
		if(isset($searchTerms['category']) && is_array($searchTerms['category'])) {
			foreach($searchTerms['category'] as $categoryId) {
				// All categories were selected, so don't continue
				if($categoryId == 0) {
					$categorySearch = false;
					break;
				}

				$categoryIds[] = (int)$categoryId;

				// If searching sub categories automatically, fetch & tack them on
				if(isset($searchTerms['searchsubs']) && $searchTerms['searchsubs'] == 'ON') {
					$categoryIds = array_merge($categoryIds, GetChildCats($categoryId));
				}
			}

			$categoryIds = array_unique($categoryIds);
			if(!empty($categoryIds)) {
				$categorySearch = true;
			}
		}
		/* this below is condition is used when category is mentioned in search keyword */
		if(isset($searchTerms['srch_category'])) {
			$categorySearch = true;
			$categoryIds = $searchTerms['srch_category'];
		}

		if($categorySearch == true) {
			$qualifier_category = 1;
			$qualifier_flag = 1;
			/*$fromTable = 'isc_categoryassociations a, isc_products p ';
			 $queryWhere[] = 'a.productid=p.productid AND a.categoryid IN ('.implode(',', $categoryIds).')';

			 $fromTable1 = 'isc_categoryassociations a, isc_import_variations v ';
			 $queryWhere1[] = 'a.productid=v.productid AND a.categoryid IN ('.implode(',', $categoryIds).')';*/
			if($searchTerms['flag_srch_category'] == 1)
			$fromTable = 'isc_products p USE INDEX (PRIMARY) ';
			else
			$fromTable = 'isc_products p ';
			//            $fromTable = 'isc_products p USE INDEX (categoryid) ';

			$queryWhere[] = 'c.categoryid IN ('.implode(',', $categoryIds).')';

			//$fromTable1 = 'isc_import_variations v ';
			$queryWhere1[] = 'c.categoryid IN ('.implode(',', $categoryIds).')';
		}
		else {
			$fromTable = 'isc_products p';
			//$fromTable1 = 'isc_import_variations v';

			$queryWhere[] = " c.categoryid is not null ";
		}
			$GLOBALS['qualifiercategory'] = $qualifier_category;
		/*  this code is commented as we are no longer checking in search table as the records are split in product and variations table.
		 if (isset($searchTerms['search_query']) && $searchTerms['search_query'] != "") {
		 // Only need the product search table if we have a search query
		 $joinQuery .= "INNER JOIN [|PREFIX|]product_search ps ON (p.productid=ps.productid) ";
		 } else if ($sortField == "score") {
		 // If we don't, we better make sure we're not sorting by score
		 $sortField = "p.prodname";
		 $sortOrder = "ASC";
		 }
		 */


		/* Below condition has been added if any product detail page is seen directly , need to assign it as array */
		if(!isset($searchTerms['dynfilters']))
		{
			$searchTerms['dynfilters'] = array();
		}
		$otherkeys = array_keys($searchTerms['dynfilters'], "others");
		$others_factor = '';
		/*
		 if ( isset($searchTerms['partnumber']) || ( isset($searchTerms['flag_srch_category']) && $searchTerms['flag_srch_category'] == 1 ) || (isset($searchTerms['flag_srch_brand']) &&  $searchTerms['flag_srch_brand'] == 1 ) || isset($searchTerms['series']) || isset($searchTerms['subcategory']) )
		 {
		 // listing page
		 }
		 else
		 {
		 foreach ($otherkeys as $otherkey)  {
		 //$others_factor .= " AND (".$otherkey." = '' OR ".$otherkey." IS NULL )";
		 $others_factor .= " AND (".$otherkey." = '' OR ".$otherkey." IS NULL )";
		 }
		 }
		 */

		$partnumber_condition = "";
		if( !isset($searchTerms['partnumber']) )
		{
			//$partnumber_condition = "and c.catvisible = 1 ";
		}
		$queryWhereTemp = $this->GetWhereBySearchItems($outer_condition,$havingquery);			
		$queryWhere = array_merge($queryWhere,$queryWhereTemp);
		
		$where = "";
		if(count($queryWhere) > 0)
		{
			$where = " and " .implode(' AND ',$queryWhere);
		}
		
		$qualifiers_where = "";

		##Added by Simha // for "others" values in qualifier filters
		//$otherkeys = array_keys($searchTerms['dynfilters'], "others");

		$extrasearch = '';
		foreach ($p_cols as $key => $value)
		{
			if(in_array($value, $otherkeys)) {
				$extrasearch .= ',MAX('.$value.') as '.$value.'';
				unset($p_cols[$key]);
				$p_cols = array_values($p_cols);
			}
		}

		foreach ($v_cols as $key => $value)
		{
			if(in_array($value, $otherkeys)) {
				$extrasearch .= ',MAX('.$value.') as '.$value.'';
				unset($v_cols[$key]);
				$v_cols = array_values($v_cols);
			}
		}
		##Added by Simha Ends
		$v_cols_new = '';
		$p_cols_new = '';
		
		if(empty($p_cols)) {
			$p_cols_new = " '' as productoption ";
		}
		else 
		{
			$p_cols_new = " '' as temp_1088 ";//just for a empty column,don't cause sql error
		}
		if(empty($v_cols)) {
			$v_cols_new = " '' as vehicleoption ";
		}
		else 
		{
			$v_cols_new = " '' as temp_1089 "; //just for a empty column,don't cause sql error
		}

		/*if(empty($p_cols)) {
			$p_cols_new = " '' as productoption ";
		} else {
			//$p_cols = " CONCAT_WS('~',".implode(' , ' , $p_cols).") as productoption ";
			//$p_cols = implode(' , ' , $p_cols);
			for($k=0;$k<count($p_cols);$k++)
			{	//$p_cols = implode(' , ' , $p_cols);
				$p_cols_new .= " group_concat(DISTINCT ".$p_cols[$k]." separator '~') as ".$p_cols[$k]." ,";
			}
		}

		if(empty($v_cols)) {
			$v_cols_new = " '' as vehicleoption ";
		} else {
			//$v_cols = " CONCAT_WS('~',".implode(' , ' , $v_cols).") as vehicleoption ";
			//$v_cols = implode(' , ' , $v_cols);
			for($k=0;$k<count($v_cols);$k++)
			{	//$p_cols = implode(' , ' , $p_cols);

				//2010-11-15 Ronnie modify,VQcabsize,VQbedsize not is Special
				/*if(	$v_cols[$k] == 'VQbedsize' )
				 {
				 $v_cols_new .= " group_concat( DISTINCT if( v.bedsize_generalname != '', v.bedsize_generalname, v.VQbedsize ) separator '~' ) as VQbedsize ,";
				 }
				 else if( $v_cols[$k] == 'VQcabsize' )
				 {
				 //$v_cols_new .= " group_concat( DISTINCT if( v.cabsize_generalname != '', v.cabsize_generalname, v.VQcabsize ) separator '~' ) as VQcabsize ,";
				 $v_cols_new .= " group_concat( DISTINCT  v.VQcabsize  separator '~' ) as VQcabsize ,";
				 }
				 else
				 {*/
				/*$v_cols_new .= " group_concat(DISTINCT ".$v_cols[$k]." separator '~') as ".$v_cols[$k]." ,";
				//}
			}
		}
		$v_cols_new = trim($v_cols_new, ',');
		$p_cols_new = trim($p_cols_new, ',');*/
		
		//$GLOBALS['srch_where'] = $common_fields_product.",".$fields." , $p_cols_new , $v_cols_new , bs.seriesname, bs.displayname, p.brandseriesid , bs.seriesdescription ,  bs.seriesfooter , b.brandimagefile, bs.serieslogoimage ";
		$GLOBALS['srch_where'] = $common_fields_product.",".$fields." , $p_cols_new , $v_cols_new , bs.seriesname, bs.displayname, p.brandseriesid , bs.seriesdescription ,  bs.seriesfooter , b.brandimagefile, bs.serieslogoimage ";
		$GLOBALS['srch_where'] .= $extrasearch;
		
		##Added by mike
		$v_cols_new2 = '';
		$p_cols_new2 = '';

		if(!empty($p_cols)) {			
			for($k=0;$k<count($p_cols);$k++)
			{
				$p_cols_new2 .= " ".$p_cols[$k]." as ".$p_cols[$k]." ,";
			}
		}

		if(!empty($v_cols)) {			
			for($k=0;$k<count($v_cols);$k++)
			{
				$v_cols_new2 .= " ".$v_cols[$k]."  as ".$v_cols[$k]." ,";
				
			}
		}
	/*	$v_cols_new2 = trim($v_cols_new2, ',');
		$p_cols_new2 = trim($p_cols_new2, ',');*/
		
		$PVCols = array_merge($p_cols,$v_cols);
		$PVColumns = $p_cols_new2.$v_cols_new2;
		$PVColumns = trim($PVColumns,',');
		
		$PVQuery = '';
		if(count($PVCols) > 0)
		{
			$PVQuery =" select p.productid,".$PVColumns ." FROM $fromTable
			".$this->GetJoinCountQueryTables()." WHERE 1=1 $where $outer_condition ";
		}		
	
		$query = "select ".$GLOBALS['srch_where'] . " from
		$fromTable ".$this->GetJoinQueryTables()." WHERE 1=1 $where $outer_condition ";
	 

		$countQuery = "SELECT count(p.productid) ".$extrasearch." FROM $fromTable
		".$this->GetJoinCountQueryTables()." WHERE 1=1 $where $outer_condition ";

		//wirror_yin20101102: put the join statement to $_GLOBALS
		$GLOBALS['join_query'] = $this->GetJoinQueryTables();
		
		return array(
			'query' => $query,
			'countQuery' => $countQuery,
			'orderby' => "",
			'PVCols' =>$PVCols,
			'PVQuery' => $PVQuery
	);

	}

}
?>