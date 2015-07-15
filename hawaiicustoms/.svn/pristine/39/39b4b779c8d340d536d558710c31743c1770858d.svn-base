<?php

/**
 * *********  Revise History  ********
 * lguan_20100525: Log YMM with smart search statics logging
 * 
 * 
 */
 
	class ISC_ABTESTING
	{

		var $_pagetitle = "";
		var $_searchterms = array();
		var $_numresults = 0;
		var $_numpages = 0;
		var $_currentpage = 1;

		function __construct()
		{
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

					$_REQUEST['search_query'] = MakeURLNormal($GLOBALS['PathInfo'][1]);
					for($i=2;$i<count($GLOBALS['PathInfo']);$i+=2)
					{
						if($GLOBALS['PathInfo'][$i+1] != '')
							$_REQUEST[$GLOBALS['PathInfo'][$i]] = MakeURLNormal($GLOBALS['PathInfo'][$i+1]);
					}
					$GLOBALS['PathInfo'][1] = MakeURLNormal($GLOBALS['PathInfo'][1]);

			} else { // this condition is entered when seo is disabled. also in redefine search this will be accessed.

				if(!isset($_REQUEST['search_key']))
				{
					foreach($_GET as $key => $value){
						$_GET[$key] = MakeURLNormal($value);
						$_REQUEST[$key] = MakeURLNormal($value);
					}
				}

			}
			
			if(!isset($GLOBALS['PathInfo'][1]) || $GLOBALS['PathInfo'][1] == "")
			header("Location:".$GLOBALS["ShopPath"]);

			$this->_searchterms['search_query'] = $_REQUEST['search_query'];

			if (count($GLOBALS['PathInfo']) > 0 ){
				if (isset ($GLOBALS['PathInfo'][1])) {
					$_REQUEST['pageid'] = $GLOBALS['PathInfo'][1];
				}
				else
				{
					$_REQUEST['pageid'] = $GLOBALS['PathInfo'][0];
				}

				if (!is_numeric($_REQUEST['pageid']))
				{
					$pagename = $_REQUEST['pageid'];
					$query = "SELECT pageid FROM [|PREFIX|]abtesting_pages WHERE LOWER(pagename)='".$GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($pagename))."' ";
					$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
					$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);
					$_REQUEST['pageid']  = $row['pageid'];
				}
			}

			if (isset($_REQUEST['search_query_adv'])) {
				$_GET['search_query'] = $_REQUEST['search_query'] = $_REQUEST['search_query_adv'];
			}
			if (isset($_REQUEST['search_query'])) {

				$GLOBALS['OriginalSearchQuery'] = isc_html_escape(html_entity_decode($_REQUEST['search_query']));
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

		/**
		*	Run the full text searches to find matching products
		*/
		function DoSearch($Start, &$Search_Result, &$Search_Count)
		{
			$category_ids = array();
			
			if(isset($_REQUEST['pageid'])) {
					$pageid = (int)$_REQUEST['pageid'];
					$query = sprintf("select * from [|PREFIX|]abtesting_pages where pageid='%d' and pagestatus = 1", $GLOBALS['ISC_CLASS_DB']->Quote($pageid));
			}
			else if(isset($GLOBALS['PathInfo'][1])) {
				$page = preg_replace('#\.html$#i', '', $GLOBALS['PathInfo'][1]);
				$page = $GLOBALS['ISC_CLASS_DB']->Quote(MakeURLNormal($page));
				$query = sprintf("select * from [|PREFIX|]abtesting_pages where pagename='%s' and pagestatus = 1", $page);
			}

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			
			if(!$row)
			{
				ob_end_clean();
				header("Location: ".GetConfig('ShopPath').'/index.php');
				exit;
			}

			$temp_srch_qry = $_REQUEST['search_query'];
			if($row['pagetype'] == 2)
			{
				$subcatg_qry = "select catname from [|PREFIX|]categories where categoryid = ".$row['pagecategoryid'];
				$subcatg_res =  $GLOBALS['ISC_CLASS_DB']->Query($subcatg_qry);
				$subcatg_arr =  $GLOBALS['ISC_CLASS_DB']->Fetch($subcatg_res);
				$_REQUEST['search_query'] = $subcatg_arr['catname'];
				//$_REQUEST['search_query'] = $temp_cat_name;
			}
			else if($row['pagetype'] == 3)
			{
				$subcatg_qry = "select c.categoryid as catid , c.catname as childname , p.categoryid , p.catname 
									from [|PREFIX|]categories c 
									left join [|PREFIX|]categories p on c.catparentid = p.categoryid
									where c.categoryid = '".$row['pagecategoryid']."'";
					
				$subcatg_res =  $GLOBALS['ISC_CLASS_DB']->Query($subcatg_qry);
				$subcatg_arr =  $GLOBALS['ISC_CLASS_DB']->Fetch($subcatg_res);
				
				if( $subcatg_arr['categoryid'] != "" )
				{
					$_REQUEST['search_query'] = $subcatg_arr['catname'];
					$_REQUEST['subcategory'] = $subcatg_arr['childname'];
				}
				else
				{
					$_REQUEST['search_query'] = $subcatg_arr['childname'];
					$_REQUEST['subcategory'] = $subcatg_arr['childname'];
				}
			}

			// Set the incoming search terms	
			$this->_searchterms = BuildProductSearchTerms($_REQUEST);
			//$this->_searchterms['search_query'] = $temp_srch_qry;

			$params = $this->_searchterms;

			if( $row['pagetype'] == 2 && isset($params['subcategory']) && $params['subcategory'] != "" )
			{
				$row['pagetype'] = 3;
			}

			$GLOBALS['CatgDescandBrandImage'] = $row['pageheaderdesc'];
			$GLOBALS['CatgBrandSeriesFooter'] = $row['pagefooterdesc'];
			$GLOBALS['CategoryTrackingCodeTop'] = isset($row['pagecontrolscript']) ? $row['pagecontrolscript'] : '';
			$GLOBALS['CategoryTrackingCodeBottom'] = isset($row['pagetrackingscript']) ? $row['pagetrackingscript'] : '';
			$this->_pagetitle = $row['pagetitle'];

			$GLOBALS['pagetype'] = $row['pagetype'];

			if($row['pagetype'] == 1) // static
			{
				$GLOBALS['results_page_flag'] = 1;
				$Search_Result = $row['pagecontent'];
				$Search_Count = 1;
				return;
			}
			else if($row['pagetype'] == 2)
			{
				$GLOBALS['results_page_flag'] = 0;
				$custom_cond = "";
				if(isset($params['brand']))
				{
					$custom_cond .= " and cp.brandname = '".$params['brand']."' ";
				}
				if($row['pagecontent'] == 1) // custom content
				{

					if( isset($params['make']) || isset($params['model']) || isset($params['year']) )
					{
						$concat_cond = "";
						if( isset($params['make']))
						{
							$concat_cond .= " and ( v.prodmake = 'NON-SPEC VEHICLE' OR v.prodmake = '".$params['make']."') ";
						}

						if( isset($params['model']))
						{
							$concat_cond .= " and ( v.prodmodel = 'all' OR v.prodmodel = '".$params['model']."') ";
						}

						if( isset($params['year']))
						{
							$concat_cond .= " and ( v.prodstartyear = 'all' OR ".$params['year']." between v.prodstartyear and v.prodendyear) ";
						}

						$temp_query = " SELECT  group_concat(distinct cp.categoryid) as catid , group_concat(distinct cp.subcategoryid) as subcatid FROM [|PREFIX|]abtesting_custom_products cp INNER JOIN [|PREFIX|]abtesting_pages cc on cc.pageid=cp.pageid WHERE cp.enabled=1 and cc.pageid = ".$pageid." ORDER BY cp.displayorder ASC ";
						$temp_result = $GLOBALS['ISC_CLASS_DB']->Query($temp_query);
						$temp_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($temp_result);

						$ccatg_qry = " SELECT group_concat( distinct ca.categoryid) as catids from [|PREFIX|]categoryassociations ca inner join [|PREFIX|]import_variations v on v.productid = ca.productid where ca.categoryid in (".$temp_arr['catid'].",".$temp_arr['subcatid'].") ".$concat_cond;
						$ccatg_result = $GLOBALS['ISC_CLASS_DB']->Query($ccatg_qry);
						$ccatg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($ccatg_result);

						$cc_query = " SELECT cp.productids, cp.categoryid, cp.subcategoryid, cp.brandid, cp.seriesid, cp.description FROM [|PREFIX|]abtesting_custom_products cp INNER JOIN [|PREFIX|]abtesting_pages cc on cc.pageid=cp.pageid WHERE cp.enabled=1 and cc.pageid = ".$pageid." ".$custom_cond;

						$ccatg_arr['catids'] = (isset($ccatg_arr['catids']) && $ccatg_arr['catids'] != '') ? $ccatg_arr['catids'] : '';

						$cc_query .= " and ( cp.categoryid in (".$ccatg_arr['catids'].") OR cp.subcategoryid in (".$ccatg_arr['catids'].") ) ";
						
						$cc_query .= " ORDER BY cp.displayorder ASC ";
					}
					else
					{
						$cc_query = " SELECT cp.productids, cp.categoryid, cp.subcategoryid, cp.brandid, cp.seriesid, cp.description FROM [|PREFIX|]abtesting_custom_products cp INNER JOIN [|PREFIX|]abtesting_pages cc on cc.pageid=cp.pageid WHERE cp.enabled=1 and cc.pageid = ".$pageid." ".$custom_cond." ORDER BY cp.displayorder ASC ";
					}

					$cc_result = $GLOBALS['ISC_CLASS_DB']->Query($cc_query);

					$total_count = $GLOBALS['ISC_CLASS_DB']->CountResult($cc_result);

					$Search_Count = $total_count;
					
					if($total_count > 0)
					{
						$GLOBALS['pagecontent'] = $row['pagecontent'];
						$GLOBALS['CustomPage'] = "";
						while($ccrow = $GLOBALS['ISC_CLASS_DB']->Fetch($cc_result)) 
						{
							$GLOBALS['CustomPage'] .= $ccrow['description'];
						}
						return;
					}
					//2010-11-30 Ronnie modify
					//return;
				}
				//2010-11-30 Ronnie add,no result show Dynamic content
				//echo "123".$total_count;
				if($total_count==0){$row['pagecontent']=0;}
				//echo "456".$row['pagecontent'];
				if($row['pagecontent'] == 0) // Dynamic content
				{	
					$getsubcatqry = "select group_concat(distinct c.categoryid) as catids from isc_categories c 
						where c.catparentid = ".$row['pagecategoryid'] ;
					$gersubcatres = $GLOBALS['ISC_CLASS_DB']->Query($getsubcatqry);
					$gersubcatarr = $GLOBALS['ISC_CLASS_DB']->Fetch($gersubcatres);
					$gersubcatarr['catids'] .= ",".$row['pagecategoryid'];

					$this->_searchterms['srch_category'] = $params['srch_category'] = explode(",",$gersubcatarr['catids']);

					/*$count_qry = "SELECT count(p.productid) as tot FROM isc_products p LEFT JOIN isc_import_variations AS v ON v.productid = p.productid LEFT JOIN isc_categoryassociations ca on ca.productid = p.productid LEFT JOIN isc_categories c on c.categoryid = ca.categoryid LEFT JOIN isc_brands b on prodbrandid = b.brandid LEFT JOIN isc_brand_series AS bs ON bs.seriesid = p.brandseriesid WHERE 1=1 AND c.categoryid IN (".$gersubcatarr['catids'].") AND p.prodvisible='1' ".$concat_cond." ".$dynamic_cond." group by c.categoryid";
					

					$catquery = "select c.catname , c.categoryid , c.catuniversal , c.catimagealt , c.featurepoints , c.videourlwidthheight , c.thumbnailvideoimage , c.pricerange , c.warrantyinfo , group_concat(DISTINCT brandname separator '~') as brandname , group_concat(DISTINCT p.brandseriesid separator '~') as seriesids , min(fp.prodfinalprice) as prodminprice , max(fp.prodfinalprice) as prodmaxprice , c.catimagefile as imagefile , c.cathoverimagefile , p.proddesc , prodwarranty , bs.seriesname, bs.displayname, p.brandseriesid , count(distinct p.productid) as totalproducts,floor(SUM(p.prodratingtotal)/SUM(p.prodnumratings)) AS prodavgrating from isc_products p LEFT JOIN isc_import_variations AS v ON v.productid = p.productid LEFT JOIN isc_categoryassociations ca on ca.productid = p.productid LEFT JOIN isc_categories c on c.categoryid = ca.categoryid LEFT JOIN isc_brands b on prodbrandid = b.brandid LEFT JOIN isc_brand_series AS bs ON bs.seriesid = p.brandseriesid LEFT JOIN isc_product_images pi ON (p.productid=pi.imageprodid AND pi.imageisthumb=1) LEFT JOIN isc_product_finalprice fp ON p.productid = fp.productid WHERE 1=1 AND c.categoryid IN (".$gersubcatarr['catids'].") AND p.prodvisible='1' ".$concat_cond." ".$dynamic_cond." group by c.categoryid ORDER BY c.catdeptid ASC, c.catsort ASC, c.catname ASC LIMIT 0, 16";
					$GLOBALS['SearchResults'] = $GLOBALS['ISC_CLASS_DB']->Query($catquery);*/
					
					// Build the search query using our terms & the fields we want
					$searchQueries = BuildProductSearchQuery($this->_searchterms);

					$group =  " group by c.categoryid ";
					$orderby = $searchQueries['orderby'];
					
					/* below template variables are added for subcategory page to add category specific tracking code*/
					if(isset($params['srch_category']))
					{
						$selected_catg = end($params['srch_category']);
						if($selected_catg != '')
						{
							$script_query = "select catname , catpagetitle , catmetakeywords , catmetadesc , controlscript , trackingscript from [|PREFIX|]categories where categoryid = ".$selected_catg;
							$script_result = $GLOBALS['ISC_CLASS_DB']->Query($script_query);
							$script_array = $GLOBALS['ISC_CLASS_DB']->Fetch($script_result);
			
							/* the below lines assign meta discription, keywords and title for the categories*/
							$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaKeywords($script_array['catmetakeywords']);
							$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaDescription($script_array['catmetadesc']);
							if($script_array['catpagetitle'] != "")
								$this->_pagetitle = $script_array['catpagetitle'];
							else
								$this->_pagetitle = ucwords($script_array['catname']);
						}
					}
				}
			}
			else if($row['pagetype'] == 3)
			{
				$GLOBALS['results_page_flag'] = 2;
				$this->_searchterms['srch_category'][] = $params['srch_category'][] = $row['pagecategoryid'];
				// Build the search query using our terms & the fields we want
				$searchQueries = BuildProductSearchQuery($this->_searchterms);
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
			}


			/* the below three lines has been added to group by SKU as same sku was showing in multiple products */
            
            $searchQueries['query'] .= $group.$GLOBALS['having_query'].$orderby;
            $searchQueries['countQuery'] .= $group.$GLOBALS['having_query'];
            
            //$searchQueries['countQuery'] = "select count(*) from ( ".$searchQueries['countQuery']." ) p ";
			$count_res = $GLOBALS['ISC_CLASS_DB']->Query($searchQueries['countQuery']); 
            $Search_Count = $GLOBALS['ISC_CLASS_DB']->CountResult($count_res); 

			// Add the limit
			$searchQueries['query'] .= $GLOBALS['ISC_CLASS_DB']->AddLimit($Start, GetConfig('CategoryProductsPerPage'));
			$Search_Result = $GLOBALS['ISC_CLASS_DB']->Query($searchQueries['query']);
			$GLOBALS['DoSearchQuery'] = $searchQueries['query'];

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

			include_once(dirname(__FILE__) . "/class.brands.php");

			$GLOBALS['CompareLink'] = CompareLink();

			$GLOBALS['ISC_CLASS_BRANDS'] = GetClass('ISC_BRANDS');
			$GLOBALS['BrandNameOptions'] = $GLOBALS['ISC_CLASS_BRANDS']->GetBrandsAsOptions(@$this->_searchterms['brand']);
			$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
			$GLOBALS['CategoryOptions'] = $GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->GetCategoryOptions($selected_cats, "<option %s value='%d'>%s</option>", 'selected="selected"', "", false, 1);

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
					
					/* ---- the below below lines are commented for not showing as alternate names are shown instead - start ---- */	    
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
				/****if( $GLOBALS['ISC_CLASS_DB']->CountResult($GLOBALS['SearchResults']) == 1 )
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
				}***/

				// Load up a list of related searches
				/***$related_searches = $this->GetRelatedSearchTerms($this->_searchterms['search_query']);

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
				}***/

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

			$GLOBALS['OriginalSearchQuery'] = implode(" ",$searchquerystring);
			$GLOBALS['FormattedSearchQuery'] = $GLOBALS['OriginalSearchQuery'];
            /* ----------------------------------------------------------------------- */

			/*---- The below two variables are added to set the search title and page title again after resetting ----*/
            //$GLOBALS['SearchTitle'] = $this->_numresults." ".sprintf(GetLang('SearchResultsFor'), $GLOBALS['OriginalSearchQuery']);
            
            //if( isset($this->_searchterms['partnumber']) || (isset($this->_searchterms['flag_srch_category']) && $this->_searchterms['flag_srch_category'] == 1 ) || ( isset($this->_searchterms['flag_srch_category']) && isset($GLOBALS['BRAND_SERIES_FLAG']) && $GLOBALS['BRAND_SERIES_FLAG'] == 1 )) 
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
				$GLOBALS['SearchTitle'] = $this->GetSearchResultMessage();
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
				$GLOBALS['OriginalSearchQuery'] =  $this->_searchterms['searchtext'];
			}

			if(isset($this->_searchterms['search'])) {
				//$searchquerystring = array();
				$GLOBALS['OriginalSearchQuery'] =  $this->_searchterms['search'];
				$GLOBALS['RedefinedSearchQuery'] = $GLOBALS['OriginalSearchQuery'];
			}

			// Hide the search form if we have just performed a search
			if (!empty($this->_searchterms)) {
				$GLOBALS['AutoHideSearchForm'] = "true";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($this->_pagetitle);
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("abtesting");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();     
		}
	}
    
    //templ/master/sidecaztgegorylist.html    //subcategory/brand listing
    //sideshopbybrand.html                   // home page
?>