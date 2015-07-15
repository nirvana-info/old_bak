<?php

	class ISC_PRODUCT
	{

		public $_product = array();

		public $_prodid = 0;
		public $_prodprice = 0;
		public $_prodcalculatedprice = 0;
		public $_prodretailprice = 0;
		public $_prodsaleprice = 0;
		public $_prodimages = 0;
        public $_prodvideos = 0;			//Added by Simha
        public $_prodaudios = 0;            //Added by Simha
        public $_prodinsvideos = 0;			//Added by Simha
        public $_prodinsimages = 0;         //Added by Simha
		public $_prodfixedshippingcost = 0;
		public $_prodtype = 0;
		public $_prodweight = 0;
		public $_prodavgrating = 0;
		public $_prodoptionsrequired = 0;
		public $_prodnumreviews = 0;
		public $_prodnumcustomfields = 0;
		public $_prodnumbulkdiscounts = 0;
		public $_prodinvtrack = 0;
		public $_prodcurrentinv = 0;

		public $_prodallowpurchases = 1;
		public $_prodhideprice = 0;
		public $_prodcallforpricinglabel = '';

		public $_prodname = "";
		public $_prodthumb = "";
		public $_proddesc = "";
        public $_proddescfeature = ""; //Added by Simha
        public $_prodtestdata = "No"; //Added by Simha
		public $_prodmfg = ""; /* added by vikas-clarion */
        public $_prodbrandimagefile = ""; /* Added by Baskaran */
        public $_prodseries = ""; 
        public $_prodcategory = ""; 
        public $_cntoffer = "";
        public $_prodbrandoffer = "";
        public $_prodsubcategorycnt = "";
        public $_prodcatoffer = ""; 
		public $_prodcompitem = ""; 
        public $_comptype = ""; /* Ends here*/      
		public $_prodbrandname = "";
		public $_prodavailability = "";
		public $_prodrelatedproducts = "";
		public $_prodlayoutfile = "";
		public $_prodsku = "";

		public $_prodpagetitle = '';
		public $_prodmetakeywords = '';
		public $_prodmetadesc = '';

		public $_prodfreeshipping = false;
		public $_prodvariations = array();
		public $_prodvariationcombinations = array();
		public $_prodvariationoptions = array();

		public $_prodeventdatelimited;
		public $_prodeventdaterequired;
		public $_prodeventdatefieldname;
		public $_prodeventdatelimitedtype;
		public $_prodeventdatelimitedstartdate;
		public $_prodeventdatelimitedenddate;
		public $_offer;

		public $_currencyrecord = null;
		
		/* below variables are used in review page */
		public $_prodbrandid = 0;
		public $_prodbrandseriesid = 0;

		/* Adding YMM to title */
		public $_prodymmselection = array();
		
		//alandy_2012-2-28 add.
		public $_search_prefix = '';

		public function __construct($productid=0)
		{
			/* alandy_2012-1-13 commit.
			if($GLOBALS['EnableSEOUrls'] == 1)
			{
				$url_array = split('/', strtolower($_SERVER['REQUEST_URI']));
				$searchlogid = $url_array[array_search('searchlogid', $url_array, true)+1];
			}
			else
			{
				$searchlogid = $_GET['SearchLogId'];
			}
			*/
				
			//alandy_2012-1-13 modify.
			if(isset($_SESSION['SearchLogId'])){
				$searchlogid = $_SESSION['SearchLogId'];
				unset($_SESSION['SearchLogId']);
			}else{
				$searchlogid = '';
			}
			
			if(isnumeric($searchlogid))
			{
				UpdateSearchLogforBestKeyWord($searchlogid);
			}
			
			/*alandy_2012-1-13 commit.
			//get search log id if exist
			if($GLOBALS['EnableSEOUrls'] == 1)
			{
				$url_array = split('/', strtolower($_SERVER['REQUEST_URI']));
				$searchlogid = $url_array[array_search('searchlogid', $url_array, true)+1];
			}
			else
			{
				$searchlogid = $_GET['SearchLogId'];
			}
			*/
			
			// validate URL coming from other sites - vikas
			$this->ValidateURLFromOtherSites();
			
			// Load the data for this product
			$this->_SetProductData($productid);
			
			//alandy_2012-3-8 add product detail url.
			$GLOBALS['detailUrl'] =  $GLOBALS['ShopPath'].$_SERVER['REQUEST_URI'];

			// Add it to the list of recently viewed products
			if($productid == 0) {
				// We must load the CSS file here for the product details bulk discount thickbox as it needs to be defined before the
				// headers get built
				if (GetConfig('BulkDiscountEnabled') && $this->_prodnumbulkdiscounts > 0) {
					$GLOBALS['AdditionalStylesheets'][] = GetConfig('AppPath').'/javascript/jquery/plugins/imodal/imodal.css';
				}

				$this->_AddToRecentlyViewedProducts();

				// Workout the breadcrumb(s)
				$this->_BuildBreadCrumbs();

				// Track a view for this page
				$this->_TrackView();
			}
		}

		public function _SetProductData($productid=0)
		{
			//alandy_2012-2-29 add.
			$this->_search_prefix = $GLOBALS['ShopPathNormal'].'/';
			$GLOBALS['ISC_CLASS_REMOTE'] = GetClass('ISC_REMOTE');
			
			if ($productid == 0) {
				// Retrieve the query string variables. Can't use the $_GET array
				// because of SEO friendly links in the URL
				SetPGQVariablesManually();
				if (isset($_REQUEST['product'])) {
					$product = $_REQUEST['product'];
					
					//alandy_2012-2-20 modify.add vendorprefix#sku
					if(stristr($product, '_')){
						list($productVendorprefix,$productSKU) = explode('_', $product);
						
						$productSKU = decode_sku($productSKU);
						
						$productSQL = sprintf("p.prodvendorprefix='%s' and p.prodcode = '%s'", $productVendorprefix,$productSKU);
					}else{
						$product = $GLOBALS['ISC_CLASS_DB']->Quote(MakeURLNormal($product));
						$productSQL = sprintf("p.prodname='%s'", $product);
					}
				}
				else if(isset($GLOBALS['PathInfo'][1])) {
					//alandy_2012-2-20 modify.add vendorprefix#sku
					$htmlUrl = preg_replace('#\.html$#i', '', $GLOBALS['PathInfo'][1]);
					
					if(stristr($htmlUrl, '_')){
						$product = $htmlUrl;
						list($productVendorprefix,$productSKU) = explode('_', $product);
						
						$productSKU = decode_sku($productSKU);
						
						$productSQL = sprintf("p.prodvendorprefix='%s' and p.prodcode = '%s'", $productVendorprefix,$productSKU);
					}else{
						$product = $GLOBALS['ISC_CLASS_DB']->Quote(MakeURLNormal($htmlUrl));
						$productSQL = sprintf("p.prodname='%s'", $product);
					}
				}
				else {
					$product = '';
					$product = $GLOBALS['ISC_CLASS_DB']->Quote(MakeURLNormal($product));
					$productSQL = sprintf("p.prodname='%s'", $product);
				}
				
				//$product = $GLOBALS['ISC_CLASS_DB']->Quote(MakeURLNormal($product));
				//$productSQL = sprintf("p.prodname='%s'", $product);
			}
			else {
				$productSQL = sprintf("p.productid='%s'", (int)$productid);
			}
			
			$query = "
				SELECT p.*, prodratingtotal/prodnumratings AS prodavgrating, imageisthumb, imagefile, ".GetProdCustomerGroupPriceSQL().", infl.instructionfile, infl.systeminstructionfile, artfl.articlefile, artfl.systemarticlefile,
				(SELECT COUNT(fieldid) FROM [|PREFIX|]product_customfields WHERE fieldprodid=p.productid) AS numcustomfields,
				(SELECT COUNT(reviewid) FROM [|PREFIX|]reviews WHERE revstatus='1' AND revproductid=p.productid AND revstatus='1') AS numreviews,
				(SELECT brandname FROM [|PREFIX|]brands WHERE brandid=p.prodbrandid) AS prodbrandname,
                (SELECT brandimagefile FROM [|PREFIX|]brands WHERE brandid=p.prodbrandid) AS prodbrandimagefile,
                (SELECT proddesc FROM [|PREFIX|]brand_series where seriesid = p.brandseriesid and brandid = p.prodbrandid) AS prodseriesdesc,
				(SELECT COUNT(imageid) FROM [|PREFIX|]product_images pi WHERE pi.imageprodid=p.productid AND imageisthumb=0) AS numimages,      
                (SELECT COUNT(imageid) FROM [|PREFIX|]install_images ti WHERE ti.imageprodid=p.productid AND imageisthumb=0) AS numinsimages,      
                (SELECT COUNT(videoid) FROM [|PREFIX|]product_videos pv WHERE pv.videoprodid=p.productid AND (pv.videofile LIKE '%.flv' || pv.systemvideofile LIKE '%.flv' || pv.videofile LIKE '%.swf' || pv.systemvideofile LIKE '%.swf')) AS numvideos, 
                (SELECT COUNT(videoid) FROM [|PREFIX|]install_videos iv WHERE iv.videoprodid=p.productid AND (iv.videofile LIKE '%.flv' || iv.systemvideofile LIKE '%.flv' || iv.videofile LIKE '%.swf' || iv.systemvideofile LIKE '%.swf')) AS numinsvideos,   
                (SELECT COUNT(audioid) FROM [|PREFIX|]audio_clips ac WHERE ac.audioprodid=p.productid AND (ac.audiofile LIKE '%.flv' || ac.systemaudiofile LIKE '%.flv' || ac.audiofile LIKE '%.swf' || ac.systemaudiofile LIKE '%.swf')) AS numaudios,
				(SELECT COUNT(discountid) FROM [|PREFIX|]product_discounts WHERE discountprodid=p.productid) AS numbulkdiscounts
				FROM [|PREFIX|]products p
				LEFT JOIN [|PREFIX|]product_images pi ON (pi.imageisthumb=1 AND p.productid=pi.imageprodid)
                LEFT JOIN [|PREFIX|]instruction_files infl ON p.productid = infl.instructionprodid
                LEFT JOIN [|PREFIX|]article_files artfl ON p.productid = artfl.articleprodid 
				WHERE ".$productSQL." AND p.prodvisible='1'
			";			// Query for ins images, videos, ins videos added by Simha  
			
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$this->_product = $row;
				$this->_prodid = $row['productid'];
				$this->_prodname = $row['prodname'];
				$this->_prodsku = $row['prodcode'];
				$this->_prodthumb = $row['imagefile'];
				$proddescription = '';
                /*if($row['prodseriesdesc'] != '' and !empty($row['prodseriesdesc'])) {    # Baskaran
                    $proddescription = $row['prodseriesdesc'];
                }
                else {
                    $proddescription = $row['proddesc'];
                } */
                $proddescription = $row['prodseriesdesc']." ".$row['proddesc']; 
                $this->_proddesc = $proddescription;
                $this->_proddescfeature = $row['proddescfeature'];  //Added by Simha				
                $this->_prodinsimages = $row['numinsimages'];		//Added by Simha
				$this->_prodmfg = $row['prodmfg']; /*--- added by vikas-clarion-- */
				$this->_prodimages = $row['numimages'];				//Added by Simha
				$this->_prodvideos = $row['numvideos'];   			//Added by Simha
                $this->_prodaudios = $row['numaudios'];               //Added by Simha 
                $this->_prodtestdata = $row['testdata'];               //Added by Simha 
                $this->_prodinsvideos = $row['numinsvideos']; 
                $this->_prodbrandimagefile = $row['prodbrandimagefile']; # Baskaran
				$this->_prodcompitem = $row['complementaryitems']; # Baskaran
                $this->_comptype = $row['comp_type']; 
				$this->_prodprice = $row['prodprice'];
				$this->_prodretailprice = $row['prodretailprice'];
				$this->_prodsaleprice = $row['prodsaleprice'];
				$this->_prodfixedshippingcost = $row['prodfixedshippingcost'];
				$this->_prodbrandname = $row['prodbrandname'];
				$this->_prodweight = $row['prodweight'];
				$this->_prodavgrating = $this->getRoundValue((float)$row['prodavgrating']);
				$this->_prodcalculatedprice = $row['prodcalculatedprice'];
				$this->_prodoptionsrequired = $row['prodoptionsrequired'];
				$this->_prodnumreviews = $row['numreviews'];
				$this->_prodavailability = $row['prodavailability'];
				$this->_prodnumcustomfields = $row['numcustomfields'];
				$this->_prodnumbulkdiscounts = $row['numbulkdiscounts'];
				$this->_prodeventdatelimited = $row['prodeventdatelimited'];
				$this->_prodeventdaterequired = $row['prodeventdaterequired'];
				$this->_prodeventdatefieldname = $row['prodeventdatefieldname'];
				$this->_prodeventdatelimitedtype = $row['prodeventdatelimitedtype'];
				$this->_prodeventdatelimitedstartdate = $row['prodeventdatelimitedstartdate'];
				$this->_prodeventdatelimitedenddate = $row['prodeventdatelimitedenddate'];
				$this->_offer = $row['offer'];
				
				$this->_prodbrandid = $row['prodbrandid'];
				$this->_prodbrandseriesid = $row['brandseriesid'];

				$this->_prodrelatedproducts = $row['prodrelatedproducts'];
				if($row['prodlayoutfile'] != '') {
					$File = str_replace(array(".html", ".htm"), "", $row['prodlayoutfile']);
					if(!file_exists(ISC_BASE_PATH."/templates/".GetConfig('template')."/".$row['prodlayoutfile'])) {
						$this->_prodlayoutfile = 'product';
					}
					else {
						$this->_prodlayoutfile = $File;
					}
				}
				else {
					$this->_prodlayoutfile = 'product';
				}
				$this->_prodpagetitle = $row['prodpagetitle'];
				$this->_prodmetakeywords = $row['prodmetakeywords'];
				$this->_prodmetadesc = $row['prodmetadesc'];
				$this->_prodinvtrack = $row['prodinvtrack'];
				$this->_prodcurrentinv = $row['prodcurrentinv'];

				if ($row['prodtype'] == 1) {
					$this->_prodtype = PT_PHYSICAL;
				} else {
					$this->_prodtype = PT_DIGITAL;
				}

				if ($row['prodfreeshipping'] == 0) {
					$this->_prodfreeshipping = false;
				} else {
					$this->_prodfreeshipping = true;
				}

				$this->_prodallowpurchases = $row['prodallowpurchases'];
				$this->_prodhideprice = $row['prodhideprice'];
				$this->_prodcallforpricinglabel = $row['prodcallforpricinglabel'];

				// If there are product variations, set them up
				if($row['prodvariationid'] > 0) {
					$this->SetupProductVariations();
				}

				$GLOBALS['CurrentProductLink'] = ProdLink($this->_prodname);
				
				//alandy_2012-2-28 modify.
				$categorylink = $GLOBALS['ISC_CLASS_REMOTE']->getCategorySearchLinkByProductid($this->_prodid);
				if(!empty($categorylink)){
					$this->_search_prefix .= $categorylink;
				}
				
			}
			//alandy_2012-2-29 add for search dialog.
			$catname_link = $GLOBALS['ShopPathNormal'];
			$catname = $GLOBALS['ISC_CLASS_REMOTE']->getCategoryNameByProductid($this->_prodid);
			$GLOBALS['searchBrandname'] = $this->_prodbrandname;
			$GLOBALS['searchSeriesname'] = $this->getSeriesnameById($this->_prodbrandid,$this->_prodbrandseriesid);
			$GLOBALS['searchCatname'] = $catname;
			$GLOBALS['searchCatnameLink'] = $catname_link.'/'.MakeURLSafe($catname);
			$GLOBALS['searchPrefix'] = $this->_search_prefix;
						
            /* Added to check whether we need to display the Offer button -- Baskaran */
            $seriesquery = "SELECT p.*,s.offer FROM [|PREFIX|]products p LEFT JOIN [|PREFIX|]brand_series s ON (s.seriesid = p.brandseriesid) where ".$productSQL." AND p.prodvisible='1'";
            $seriesresult = $GLOBALS['ISC_CLASS_DB']->Query($seriesquery);
            if ($srow = $GLOBALS['ISC_CLASS_DB']->Fetch($seriesresult)) {
                $this->_prodseries = $srow['offer'];
            }
            
            $categoryquery = "SELECT c.categoryid, c.catparentid, c.offer FROM [|PREFIX|]products p LEFT JOIN [|PREFIX|]categoryassociations ca ON ( ca.productid = p.productid ) LEFT JOIN [|PREFIX|]categories c ON ( c.categoryid = ca.categoryid ) WHERE ".$productSQL." AND p.prodvisible = '1' AND c.catparentid != 0";
            $categoryresult = $GLOBALS['ISC_CLASS_DB']->Query($categoryquery);
            if ($crow = $GLOBALS['ISC_CLASS_DB']->Fetch($categoryresult)) {
                $this->_product['catparentid'] = $crow['catparentid'];
                $this->_prodcategory = $crow['offer'];
            }
            
            $allseriesquery = "SELECT count( s.offer ) as cntoffer FROM [|PREFIX|]products p LEFT JOIN [|PREFIX|]brand_series s ON ( s.brandid = p.prodbrandid ) WHERE ".$productSQL." AND p.prodvisible = '1' AND s.offer = 'yes'";
            $allseriesresult = $GLOBALS['ISC_CLASS_DB']->Query($allseriesquery);
            if($allrow = $GLOBALS['ISC_CLASS_DB']->Fetch($allseriesresult)) {
                $this->_cntoffer = $allrow['cntoffer'];
            }
            
            $brandquery = "SELECT b.offer FROM [|PREFIX|]products p LEFT JOIN [|PREFIX|]brands b ON (b.brandid = p.prodbrandid) WHERE ".$productSQL." AND p.prodvisible = '1'";
            $brandresult = $GLOBALS['ISC_CLASS_DB']->Query($brandquery);
            if ($brow = $GLOBALS['ISC_CLASS_DB']->Fetch($brandresult)) {
                $this->_prodbrandoffer = $brow['offer'];
            }
            
            $subcategoryquery = "SELECT count( c.offer ) as cntoffer FROM [|PREFIX|]products p LEFT JOIN [|PREFIX|]categories c ON ( c.categoryid = p.prodcatids ) WHERE ".$productSQL." AND p.prodvisible = '1' AND c.offer = 'yes'";
            $subcategoryresult = $GLOBALS['ISC_CLASS_DB']->Query($subcategoryquery);
            if ($subrow = $GLOBALS['ISC_CLASS_DB']->Fetch($subcategoryresult)) {
                $this->_prodsubcategorycnt = $subrow['cntoffer'];
            }
            
            $catofferquery = "SELECT c.offer FROM [|PREFIX|]products p LEFT JOIN [|PREFIX|]categories c ON (c.categoryid = p.prodcatids) WHERE ".$productSQL." AND p.prodvisible = '1' AND c.catparentid = 0";
            $catofferresult = $GLOBALS['ISC_CLASS_DB']->Query($catofferquery);
            if ($catrow = $GLOBALS['ISC_CLASS_DB']->Fetch($catofferresult)) {
                $this->_prodcatoffer = $catrow['offer'];
            }
            /* Ends here */
			
			/* Reassigning the rating as the rating calculation changed as per client requirements - vikas */
			//wirror_20110330
			$ratingquery = "select IFNULL(SUM(p.prodnumratings),0) as total_reviews , IFNULL(SUM(p.prodratingtotal)/SUM(p.prodnumratings),0) as rating from [|PREFIX|]products p where p.prodvisible = 1 and p.productid=$row[productid] and";

			if($this->_prodbrandseriesid != 0)
				$ratingquery .= " p.brandseriesid = ".$this->_prodbrandseriesid;
			else if($this->_prodbrandid != 0)
				$ratingquery .= " p.prodbrandid = ".$this->_prodbrandid;

			$ratingresult = $GLOBALS['ISC_CLASS_DB']->Query($ratingquery);
			$ratingrow = $GLOBALS['ISC_CLASS_DB']->Fetch($ratingresult);
			if(isset($ratingrow['rating']))
				$this->_prodavgrating = $this->getRoundValue((float)$ratingrow['rating']);
			else
				$this->_prodavgrating = 0;

			if(isset($ratingrow['total_reviews']))
				$this->_prodnumreviews = $ratingrow['total_reviews'];
			else
				$this->_prodnumreviews = 0;
			
			
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
		*	Track a view for this product by updating the prodnumviews field in the products table
		*/
		public function _TrackView()
		{
			$query = sprintf("update [|PREFIX|]products set prodnumviews=prodnumviews+1 where productid='%d'", $this->_prodid);
			$GLOBALS['ISC_CLASS_DB']->Query($query);
            
            /* To get the date of the viewed product -- Baskaran */
            $viewcount = array (
                            "productid" => $this->_prodid,
                            "viewdate" => time()
                            );
            $GLOBALS['ISC_CLASS_DB']->InsertQuery("product_view_count", $viewcount);
            /* Code Ends */
	    
			//update the view count of products_statistics for the product statistics -- Mingxing
			$query = sprintf("update [|PREFIX|]products_statistics set prodnumviews=prodnumviews+1 where productid='%d'", $this->_prodid);
			$GLOBALS['ISC_CLASS_DB']->Query($query);
			//end -- Mingxing
		}

		public function _AddToRecentlyViewedProducts()
		{
			/*
				Store this product's ID in a persistent cookie
				that will be used to remember the last 5 products
				that this person has viewed
			*/

			$viewed_products = array();

			if (isset($_COOKIE['RECENTLY_VIEWED_PRODUCTS'])) {
				$viewed_products = explode(",", $_COOKIE['RECENTLY_VIEWED_PRODUCTS']);
			}

			if (in_array($this->GetProductId(), $viewed_products)) {
				// Remove it from the array
				foreach ($viewed_products as $k=>$v) {
					if ($v == $this->GetProductId()) {
						unset($viewed_products[$k]);
					}
				}
			}

			// Add it to the list
			$viewed_products[] = $this->GetProductId();

			// Only store the 5 most recent product Id's
			if (count($viewed_products) > 5) {
				$reverse_viewed_products = array_reverse($viewed_products);
				$viewed_products = array();

				for ($i = 0; $i < 5; $i++) {
					$viewed_products[] = $reverse_viewed_products[$i];
				}

				// Reverse the array so the oldest products show first
				$viewed_products = array_reverse($viewed_products);
			}

			$new_viewed_products = implode(",", $viewed_products);

			// Persist the cookie for 30 days
			ISC_SetCookie("RECENTLY_VIEWED_PRODUCTS", $new_viewed_products, time() + (3600*24*30));

			// Persist the cookie session-wide for use on the cart page
			$_SESSION['RECENTLY_VIEWED_PRODUCTS'] = $new_viewed_products;
		}

		public function SetupProductVariations()
		{
			// Get a list of product variations for this product from the database
			$optionList = array();
			$query = "
				SELECT *
				FROM [|PREFIX|]product_variation_combinations
				WHERE vcproductid='".$GLOBALS['ISC_CLASS_DB']->Quote($this->GetProductId())."' AND vcenabled='1'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while ($combination = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$variationOptions = explode(",", $combination['vcoptionids']);

				// Product options must be sorted numerically for the javascript selections to work
				sort($variationOptions);

				$combination['vcoptionids'] = implode(",", $variationOptions);
				$this->_prodvariationcombinations[] = $combination;

				// Add the list of options available to the list we'll be selecting below
				$optionList = array_merge($optionList, $variationOptions);
			}

			if(!empty($optionList)) {
				// Fetch the list of option names and values
				$optionList = implode(",", array_unique($optionList));
				$query = "
					SELECT *
					FROM [|PREFIX|]product_variation_options
					WHERE voptionid IN (".$optionList.")
					ORDER BY vooptionsort, vovaluesort
				";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$variationNames = array();
				$count = 0;
				while($option = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					if(!isset($variationNames[$option['voname']])) {
						++$count;
						$variationNames[$option['voname']] = $count;
					}
					else {
						$count = $variationNames[$option['voname']];
					}
					if(!isset($this->_prodvariations[$option['voname']])) {
						$this->_prodvariations[$option['voname']] = array();
					}
					$this->_prodvariations[$option['voname']][] = $option;
					$this->_prodvariationslookup[$option['voptionid']] = $count;
					$this->_prodvariationoptions[$option['voptionid']] = $option;
				}
			}
		}
		public function GetVariationCombination($combination)
		{
			if(!is_array($combination)) {
				$combination = explode(",", $combination);
			}

			// Sort it numerically
			sort($combination, SORT_NUMERIC);
			$combination = implode(",", $combination);

			foreach($this->_prodvariationcombinations as $variation) {
				// Sort this combination numerically too
				$vcombination = explode(",", $variation['vcoptionids']);
				sort($vcombination, SORT_NUMERIC);
				$vcombination = implode(",", $vcombination);
				if($vcombination == $combination) {
					return $variation['combinationid'];
				}
			}

			// Nothing found, return false
			return false;
		}

		public function GetProductVariationCombinationJavascript()
		{
			if(empty($this->_prodvariationcombinations)) {
				return '';
			}
			$script = "<script type=\"text/javascript\">\n";
			$script .= " var VariationList = new Array();\n";

			foreach($this->_prodvariationcombinations as $variation) {
				$variationPrice = CurrencyConvertFormatPrice(CalcProductVariationPrice($this->_prodcalculatedprice, $variation['vcpricediff'], $variation['vcprice'], $this->_product));

				$youSave = $this->_prodretailprice - CalcProductVariationPrice($this->_prodcalculatedprice, $variation['vcpricediff'], $variation['vcprice'], $this->_product);
				$variationSaveAmount = '';
				if($youSave > 0) {
					$variationSaveAmount = CurrencyConvertFormatPrice($youSave);
				}

				$variationWeight = FormatWeight(CalcProductVariationWeight($this->_prodweight, $variation['vcweightdiff'], $variation['vcweight']), true);

				if($variation['vcthumb'] != '') {
					$thumb = $GLOBALS['ShopPath']."/".GetConfig('ImageDirectory')."/".$variation['vcthumb'];
				}
				else {
					$thumb = '';
				}
				if($variation['vcimage'] != '') {
					$image = $GLOBALS['ShopPath'].'/'.GetConfig('ImageDirectory').'/'.$variation['vcimage'];
				}
				else {
					$image = '';
				}

				$ids = explode(",", $variation['vcoptionids']);
				$optionList = array();
				foreach($ids as $id) {
					$key = $this->_prodvariationslookup[$id];
					$optionList[$key] = $id;
				}
				ksort($optionList);
				$optionList = implode(",", $optionList);

				$script .= " VariationList[".$variation['combinationid']."] = {";
				$script .= " combination: '".$optionList."', ";
				$script .= " saveAmount: '".$variationSaveAmount."', ";
				$script .= " price: '".$variationPrice."', ";
				$script .= " sku: '".isc_html_escape($variation['vcsku'])."', ";
				$script .= " weight: '".$variationWeight."', ";
				$script .= " thumb: '".$thumb."', ";
				$script .= " image: '".$image."', ";
				// Tracking inventory on a product variation level
				if($this->_prodinvtrack == 2) {
					if(GetConfig('ShowInventory') == 1) {
						$script .= "stock: '".$variation['vcstock']."', ";
					}
					if($variation['vcstock'] <= 0) {
						$script .= " instock: false";
					}
					else {
						$script .= " instock: true";
					}
				}
				else {
					$script .= " instock: true";
				}
				$script .= "};\n";
			}

			$script .= "</script>";
			return $script;

		}

		public function GetProductVariations()
		{
			return $this->_prodvariations;
		}

		public function GetProductInventoryTracking()
		{
			return $this->_prodinvtrack;
		}

		public function GetInventoryLevel()
		{
			return $this->_prodcurrentinv;
		}

		public function IsOptionRequired()
		{
			if ($this->_prodoptionsrequired == 1) {
				return true;
			} else {
				return false;
			}
		}

		public function _BuildBreadCrumbs()
		{
			/*
				Build a list of one or more breadcrumb trails for this
				product based on which categories it appears in
			*/

			// Build the arrays that will contain the category names to build the trails
			$count = 0;

			$GLOBALS['BreadCrumbs'] = "";
			$GLOBALS['FindByCategory'] = "";

			$path = GetConfig('ShopPath'); 

			// First we need to fetch the parent lists of all of the categories
			$trailCategories = array();
			$crumbList = array();
			$query = sprintf("
				SELECT c.categoryid, c.catparentlist
				FROM [|PREFIX|]categoryassociations ca
				INNER JOIN [|PREFIX|]categories c ON (c.categoryid=ca.categoryid)
				WHERE ca.productid='%d'",
				$GLOBALS['ISC_CLASS_DB']->Quote($this->GetProductId())
			);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				if ($row['catparentlist'] == '') {
					$row['catparentlist'] = $row['categoryid'];
				}
				$cats = explode(",", $row['catparentlist']);
				$trailCategories = array_merge($trailCategories, $cats);
				$crumbList[$row['categoryid']] = $row['catparentlist'];
			}

			$trailCategories = implode(",", array_unique($trailCategories));
			$categories = array();
			$catparentid = array();
			if ($trailCategories != '') {
				// Now load the names for the parent categories from the database
				$query = sprintf("SELECT categoryid, catparentid, catname FROM [|PREFIX|]categories WHERE categoryid IN (%s)", $trailCategories);
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$categories[$row['categoryid']] = $row['catname'];
					$catparentid[$row['categoryid']] = $row['catparentid'];
				}
			}

			// Now we have all of the information we need to build the trails, lets actually build them
			foreach ($crumbList as $productcatid => $trail) {
				$GLOBALS['CatTrailLink'] = $GLOBALS['ShopPath'];
				$GLOBALS['CatTrailName'] = GetLang('Home');
				$GLOBALS['BreadcrumbItems'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("BreadcrumbItem");
				$GLOBALS['FindByCategoryItems'] = "";

				$cats = explode(",", $trail);
				$breadcrumbitems = "";
				$findbycategoryitems = "";
				$hasAccess = true;

				foreach ($cats as $categoryid) {
					if(!CustomerGroupHasAccessToCategory($categoryid)) {
						/*
						if customer doesn't have access to this category and this category is the category of the product,
						dont print the trail, otherwise just exclude the category from the trail
						*/
						if ($categoryid == $productcatid) {
							$hasAccess = false;
							break;
						}
						continue;
					}
					if (isset($categories[$categoryid])) {
						$catname = $categories[$categoryid];
						/* this below patch is for passing mmy variable in the breadcrumbs for returning to search page */
                        $mmy_links = "";
                        if($GLOBALS['EnableSEOUrls'] == 0) {
                            if(isset($_REQUEST['make']) && $_REQUEST['make'] != '')
							{
								$mmy_links .= "&make=".urlencode($_REQUEST['make']);
								$this->_prodymmselection['make'] = $_REQUEST['make'];
							}
                            if(isset($_REQUEST['model']) && $_REQUEST['model'] != '')
							{
								$mmy_links .= "&model=".urlencode($_REQUEST['model']);
								$this->_prodymmselection['model'] = $_REQUEST['model'];
							}
                            /*if(isset($params['model_flag']) && $params['model_flag'] == 0)
                            $mmy_links .= "&model_flag=".$params['model_flag'];*/
                            if(isset($_REQUEST['year']) && $_REQUEST['year'] != '')
							{
								$mmy_links .= "&year=".$_REQUEST['year'];
								$this->_prodymmselection['year'] = $_REQUEST['year'];
							}
                        }  else {
                            if(count($GLOBALS['PathInfo']) > 0) {
                                foreach($GLOBALS['PathInfo'] as $key => $value) {
                                    if(eregi('make=',$value)) {
                                        $mmy_links .= "/make/".substr($value,strpos($value,'=')+1);
										$this->_prodymmselection['make'] = substr($value,strpos($value,'=')+1);
                                    } else if(eregi('model=',$value)) {
                                        $mmy_links .= "/model/".substr($value,strpos($value,'=')+1);
										$this->_prodymmselection['model'] = substr($value,strpos($value,'=')+1);
                                    } else if(eregi('year=',$value)) {
                                        $mmy_links .= "/year/".substr($value,strpos($value,'=')+1);
										$this->_prodymmselection['year'] = substr($value,strpos($value,'=')+1);
                                    }
                                }
                            }
                        }

						if($catparentid[$categoryid] == 0) {
							$GLOBALS['ISC_SRCH_CATG_ID'] = $categoryid; // this is added to show the category when clicked on any product on homepage
							$_SESSION['catg_name'] = $GLOBALS['ISC_SRCH_CATG_NAME'] = $catname; // this is added to show the category when clicked on any product on homepage
							$catparentname = MakeURLSafe(strtolower($catname));    
							
							if($GLOBALS['EnableSEOUrls'] == 0)
								$GLOBALS['CatTrailLink'] = "$path/search.php?search_query=".$catparentname.$mmy_links;
							else
								$GLOBALS['CatTrailLink'] = "$path/".$catparentname.$mmy_links;
                        }
                        else
						{
							if($GLOBALS['EnableSEOUrls'] == 0)
								$GLOBALS['CatTrailLink'] = "$path/search.php?search_query=".$catparentname."&sub_category=".$categoryid.$mmy_links;
							else
								$GLOBALS['CatTrailLink'] = "$path/".$catparentname."/subcategory/".MakeURLSafe(strtolower($catname)).$mmy_links;
						}

						//$GLOBALS['CatTrailLink'] = CatLink($categoryid, $catname);
						$GLOBALS['CatTrailName'] = isc_html_escape($catname);
						$breadcrumbitems .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("BreadcrumbItem");
						$findbycategoryitems .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductFindByCategoryItem");
					}
				}

				if ($hasAccess) {

			//temp script to shortern the product name
			$pid  = $this->GetProductId();
			$querytemp = "SELECT prodbrandid FROM  [|PREFIX|]products where productid = ".$pid."  ";
			$resulttemp = $GLOBALS['ISC_CLASS_DB']->Query($querytemp);
			$brand = $GLOBALS['ISC_CLASS_DB']->Fetch($resulttemp);

			if ($brand['prodbrandid'] == 37)
					{
						$query = "SELECT c.catname, c.catcombine FROM [|PREFIX|]categories 	c left join [|PREFIX|]categoryassociations ca on c.categoryid = ca.categoryid  left join [|PREFIX|]products p on ca.productid = p.productid where p.productid =  '".$this->GetProductId()."' ";
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
						$cat = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

						if ($cat['catcombine'] != "")
						$GLOBALS['CatTrailName'] = $cat['catcombine']." Part Number ".isc_html_escape($this->GetSKU());
						else
						$GLOBALS['CatTrailName'] = $cat['catname']." Part Number ".isc_html_escape($this->GetSKU());
					}
					else
					{
						$GLOBALS['CatTrailName'] = isc_html_escape($this->GetProductName());
					}
					//temp script to shorten the product name

					//$GLOBALS['CatTrailName'] = isc_html_escape($this->GetProductName());
					$GLOBALS['BreadcrumbItems'] .= $breadcrumbitems . $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("BreadcrumbItemCurrent");
					$GLOBALS['BreadCrumbs'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductBreadCrumb");
					$GLOBALS['FindByCategory'] .= $findbycategoryitems . $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductFindByCategory");
				}
			}
		}

		public function HandlePage()
		{
			$this->ShowPage();
		}

		public function HasFreeShipping()
		{
			return $this->_prodfreeshipping;
		}

		public function GetFixedShippingCost()
		{
			return $this->_prodfixedshippingcost;
		}

		public function GetProduct()
		{
			return $this->_product;
		}

		public function GetProductName()
		{
			return $this->_prodname;
		}

		public function GetProductId()
		{
			return $this->_prodid;
		}

		public function GetThumb()
		{
			return $this->_prodthumb;
		}

		public function GetDesc()
		{
			return $this->_proddesc;
		}
		/*-- added by vikas-clarion--*/
		public function GetProdMfg()
		{
			return $this->_prodmfg;
		}
		// GetDescFeature & GetNumInsImages Added by Simha
        public function GetDescFeature()
        {
            return $this->_proddescfeature;
        } 
        /* Added by Baskaran */
        public function GetProdbrandimagefile() 
        {
            return $this->_prodbrandimagefile;
        }
        public function GetSeriesOffer()
        {
            return $this->_prodseries;
        }
        public function GetCategoryOffer()
        {
            return $this->_prodcategory;
        }
         public function GetSeriesCntOffer()
        {
            return $this->_cntoffer;
        }
        public function GetBrandOffer()
        {
            return $this->_prodbrandoffer;
        }
        public function GetSubCategoryCntOffer()
        {
            return $this->_prodsubcategorycnt;
        }
        public function GetRootCategoryOffer()
        {
            return $this->_prodcatoffer;
        }
		public function GetComplItem()
        {
            return $this->_prodcompitem;
        }
        public function GetCompSelectionType()
        {
            return $this->_comptype;
        }
        /* Ends here */
		public function GetNumImages()
		{
			return $this->_prodimages;
		}

        public function GetNumVideos()
        {
            return $this->_prodvideos;
        }

        public function GetNumAudios()
        {
            return $this->_prodaudios;
        }

        public function GetNumInsVideos()
        {
            return $this->_prodinsvideos;
        }

        public function GetNumInsImages()
        {
            return $this->_prodinsimages;
        }
        public function Getoffer()
        {
            return $this->_offer;
        }
        
		public function GetPrice()
		{
			return $this->_prodprice;
		}

		public function GetRetailPrice()
		{
			return $this->_prodretailprice;
		}

		public function GetSalePrice()
		{
			return $this->_prodsaleprice;
		}

		public function GetCalculatedPrice()
		{
			return CalculateProductPrice($this->_product, true, true, false);
		}

		public function GetFinalPrice()
		{                                                                                 
            return CalcProdCustomerGroupPrice($this->_product, $this->_prodcalculatedprice);
		}

		public function GetBrandName()
		{
			return $this->_prodbrandname;
		}

		public function GetProductType()
		{
			return $this->_prodtype;
		}

		public function GetWeight()
		{
			return FormatWeight($this->_prodweight, true);
		}

		public function GetRating()
		{
			return $this->_prodavgrating;
		}

		public function GetNumReviews()
		{
			return $this->_prodnumreviews;
		}

		public function GetSKU()
		{
			return $this->_prodsku;
		}

		public function GetAvailability()
		{
			return $this->_prodavailability;
		}

		public function GetNumCustomFields()
		{
			return $this->_prodnumcustomfields;
		}

		public function GetNumBulkDiscounts()
		{
			return $this->_prodnumbulkdiscounts;
		}

		public function GetEventDateRequired()
		{
			return $this->_prodeventdaterequired;
		}

		public function GetEventDateLimited()
		{
			return $this->_prodeventdatelimited;
		}
		public function GetEventDateFieldName()
		{
			return $this->_prodeventdatefieldname;
		}
		public function GetEventDateLimitedType()
		{
			return $this->_prodeventdatelimitedtype;
		}
		public function GetEventDateLimitedStartDate()
		{
			return $this->_prodeventdatelimitedstartdate;
		}
		public function GetEventDateLimitedEndDate()
		{
			return $this->_prodeventdatelimitedenddate;
		}

		/**
		 * Does this product have usable bulk discounts
		 *
		 * Method will check to see if this product has any bulks discounts without any product variations
		 *
		 * @access public
		 * @return bool TRUE if this product has any usable bulk discounts, FALSE if not
		 */
		public function CanUseBulkDiscounts()
		{
			if (GetConfig('BulkDiscountEnabled') && $this->GetNumBulkDiscounts() > 0 && empty($this->_prodvariations)) {
				return true;
			}

			return false;
		}

		public function GetRelatedProducts()
		{
			// Related products are set to automatic, find them
			return GetRelatedProducts($this->_prodid, $this->_prodname, $this->_prodrelatedproducts);
		}

		public function IsPurchasingAllowed()
		{
			return ($this->_prodallowpurchases && (bool)GetConfig('AllowPurchasing'));
		}

		public function ArePricesHidden()
		{
			if(!GetConfig('ShowProductPrice') || $this->_prodhideprice == 1) {
				return true;
			}

			return false;
		}

		public function GetProductCallForPricingLabel()
		{
			return $this->_prodcallforpricinglabel;
		}

		public function GetPageTitle()
		{
			return $this->_prodpagetitle;
		}

		public function GetProductWarranty()
		{
			return $this->_product['prodwarranty'];
		}

		//blessen
		public function GetProductInstruction()
		{
			return $this->_product['prod_instruction'];
		}

		public function GetProductInsFile()
		{
            if($this->_product['systeminstructionfile']=="" || $this->_product['systeminstructionfile']==null)    {
                return $this->_product['instructionfile'];
            }
            else    {
                return $this->_product['systeminstructionfile']; 
            }    
		}

		public function GetProductArticle()
		{
			return $this->_product['prod_article'];
		}

		public function GetProductArtFile()
		{
			if($this->_product['systemarticlefile']=="" || $this->_product['systemarticlefile']==null)    {
                return $this->_product['articlefile'];
            }
            else    {
                return $this->_product['systemarticlefile']; 
            } 
		}

		/**
		 * Get the details of the vendor that this product belongs to (if there are any)
		 *
		 * @return array The details of the vendor. False if there aren't any
		 */
		public function GetProductVendor()
		{
			if(!gzte11(ISC_HUGEPRINT) || $this->_product['prodvendorid'] == 0) {
				return false;
			}

			$vendorCache = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('Vendors');
			if(isset($vendorCache[$this->_product['prodvendorid']])) {
				return $vendorCache[$this->_product['prodvendorid']];
			}

			return false;
		}

		/**
		 * Check if the current product is taxable or not.
		 *
		 * @return boolean True if taxable, false if not.
		 */
		public function GetProductTaxable()
		{
			return $this->_product['prodistaxable'];
		}
        
        /**
         * Check if the current product is taxable or not.
         *
         * @return boolean True if taxable, false if not.
         */
        public function IsTestData()
        {
            return $this->_product['testdata'];
        }

		public function BuildTitle()
		{
			$title = '';
			if ($this->GetPageTitle()!="") {
				$title = $this->GetPageTitle();
			} elseif ($this->GetProductName()!="") {
				$title = sprintf("%s - %s", $this->GetProductName(), GetConfig('StoreName'));
			} else {
				$title = sprintf("%s %s", GetConfig('StoreName'), GetLang('Products'));
			}

			/* Adding YMM to page title */
			if( !empty($this->_prodymmselection) )
			{
				$tempTitle = array();
				if( isset($this->_prodymmselection['year']) )
				{
					$tempTitle[] = $this->_prodymmselection['year'];					
				}
				if( isset($this->_prodymmselection['make']) )
				{
					$this->_prodymmselection['make'] = MakeURLNormal($this->_prodymmselection['make']);
					$tempTitle[] = ucwords(strtolower($this->_prodymmselection['make']));
				}
				if( isset($this->_prodymmselection['model']) )
				{
					$this->_prodymmselection['model'] = MakeURLNormal($this->_prodymmselection['model']);
					$tempTitle[] = ucwords(strtolower($this->_prodymmselection['model']));
				}
				$tempTitle[] = $title;

				$title = implode(" ",$tempTitle);
			}

			return $title;
		}

		public function ShowPage()
		{
      
			if ($this->_prodid > 0) {
                $GLOBALS['ProductIds'] = $this->_prodid;
				// Check that the customer has permisison to view this product
				$canView = false;
				$path = GetConfig('ShopPath');
				$productCategories = explode(',', $this->_product['prodcatids']);
				foreach($productCategories as $categoryId) {
					// Do we have permission to access this category?
					if(CustomerGroupHasAccessToCategory($categoryId)) {
						$canView = true;
					}
				}
				if($canView == false) {
					$noPermissionsPage = GetClass('ISC_403');
					$noPermissionsPage->HandlePage();
					exit;
				}

				if ($this->_prodmetakeywords != "") {
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaKeywords(isc_html_escape($this->_prodmetakeywords));
				}

				if ($this->_prodmetadesc != "") {
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetMetaDescription(isc_html_escape($this->_prodmetadesc));
				}

				$GLOBALS['CompareLink'] = CompareLink();

				// If we're showing images as a lightbox, we need to load up the URLs for the other images for this product
				if(GetConfig('ProductImageMode') == 'lightbox') {
					$GLOBALS['AdditionalStylesheets'][]  = 					GetConfig('ShopPath').'/javascript/jquery/plugins/lightbox/lightbox.css';
				}

				$url_string = $_SERVER['REQUEST_URI'];
                if(isset($_SERVER['QUERY_STRING']))
                $url_string .= $_SERVER['QUERY_STRING'];
                
                if(eregi('refer=true',$url_string) && isset($_SESSION['back2url'])) {
                   $GLOBALS['B2Search'] = "&nbsp;< <a href='$path/".$_SESSION['back2url']."'>Back to search results</a>";                  
                } else {
					$_SESSION['v_cols'] = array();
					$_SESSION['p_cols'] = array();
				}
				
				//zcs=>only login customer can access "Product Reviews"
				$GLOBALS['StyleProductReviews'] = CustomerIsSignedIn() ? 'style="text-decoration:none;"' : 'style="display:none;"';
				//<=zcs

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate($this->_prodlayoutfile);
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
			// Visiting an invalid product, show a lovely error message
			else {
				ShowInvalidError('product');
				die();
			}
		}

		/**
		 * Check if the current product has tags or not.
		 *
		 * @return boolean True if the product has tags, false if not.
		 */
		public function ProductHasTags()
		{
			return (bool)$this->_product['prodhastags'];
		}

		/**
		 * Can the product be gift wrapped? This depends on two things - are there any gift
		 * wrapping options available and has this product been configured to allow gift wrapping?
		 */
		public function CanBeGiftWrapped()
		{
			if($this->_product['prodwrapoptions'] == -1) {
				return false;
			}
			else {
				$wrapCache = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('GiftWrapping');
				if(!empty($wrapCache)) {
					return true;
				}
			}

			return false;
		}
		//Added by Simha to get first thumb image
		public function GetInstallThumb()   {
            $query = sprintf("SELECT pi.imageid, pi.imageprodid, pi.imageprodhash, pi.imagefile, pi.imageisthumb, ti.imagefile thumbfile, ti.imageisthumb isThumb FROM [|PREFIX|]install_images pi
LEFT JOIN [|PREFIX|]install_images ti ON ti.imagesort = pi.imagesort AND ti.imageprodid = pi.imageprodid
 AND ti.imageisthumb='3' WHERE pi.imageprodid='%d' AND pi.imageisthumb='0' order by pi.imagesort asc LIMIT 1", $this->_prodid);
                                                                                                    
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);   
            
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                return $row['thumbfile'];
            }
        }

		public function GetProductFields($productId)
		{
			$fields = array();
			if($productId == 0) {
				return $fields;
			}
			// Get the product fields for this product from the database
			$query = "Select *
					From [|PREFIX|]product_configurable_fields
					Where fieldprodid='".(int)$productId."'
					Order by fieldsortorder ASC";
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				$fields[] = array(
					"id"		=> $row['productfieldid'],
					"name"		=> $row['fieldname'],
					"type"		=> $row['fieldtype'],
					"fileType"	=> $row['fieldfiletype'],
					"fileSize"	=> $row['fieldfilesize'],
					"required"	=> $row['fieldrequired']
				);
			}
			return $fields;
		}

		public function GetEventDateFields()
		{
			return array(
				'prodeventdaterequired' => $this->_product['prodeventdaterequired'],
				'prodeventdatefieldname' => $this->_product['prodeventdatefieldname'],
				'prodeventdatelimited' => $this->_product['prodeventdatelimited'],
				'prodeventdatelimitedtype' => $this->_product['prodeventdatelimitedtype'],
				'prodeventdatelimitedstartdate' => $this->_product['prodeventdatelimitedstartdate'],
				'prodeventdatelimitedenddate' => $this->_product['prodeventdatelimitedenddate'],
			);
		}

		/*
		*	This function is used to validate the URL sent from K&N site.
		*	Here it will generate the URL as it is being done in TruckChamp site and redirect it accordingly.
		*/

		public function ValidateURLFromOtherSites()
		{
			if(isset($GLOBALS['PathInfo'][1]) && strtolower($GLOBALS['PathInfo'][1]) == "k&n")
			{
				$prodcode = isset($GLOBALS['PathInfo'][2]) ? trim($GLOBALS['PathInfo'][2]) : '';
				
				if($prodcode != '')
				{
					$prodnameqry = "SELECT p.prodname from [|PREFIX|]products p left join [|PREFIX|]vendors v on  p.prodvendorid = v.vendorid  where prodcode = '".$prodcode."' and v.vendorname = 'k&n'";
					$prodnameres = $GLOBALS['ISC_CLASS_DB']->Query($prodnameqry);
					if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($prodnameres)) 
					{	
						$prodlink = ProdLink($row['prodname']);
						header("Location: ".$prodlink);
						exit;
					}
				}
			}
		}
    
    /**
     * return array format array('startYear' => [int], 'endYear' => [int], 'model' => [list], 'make' => [list])
     * 
     * @param int $productId
     * @param int $year
     * @param string $make
     * @return array
     */
    public static function GetImpVariationForYMM($productId, $ymmtype='', $year = 0, $make = '', $model = '') {
        $impvaritions = array(
            'startYear' => null,
            'endYear' => null,
            'model' => array(),
            'make' => array()
        );
        $sql ="SELECT prodstartyear AS startYear,prodendyear AS endYear,prodmodel AS model,prodmake AS make FROM `[|PREFIX|]import_variations` WHERE productid IN($productId)";
        if ($ymmtype == 'make' && $make)
            $sql .= " AND prodmake=UPPER('$make')";
        elseif ($ymmtype == 'year' && $year)
            $sql .= " AND prodstartyear <= $year AND prodendyear >= $year";
        elseif ($ymmtype == 'model' && $model)
            $sql .= " AND prodmodel=UPPER('$model')";
        elseif(!$ymmtype) {
            if ($make)
                $sql .= " AND prodmake=UPPER('$make')";
            if ($year) 
                $sql .= " AND prodstartyear <= $year AND prodendyear >= $year";
            if ($model)
                $sql .= " AND prodmodel=UPPER('$model')";
        }
        
        $query = $GLOBALS['ISC_CLASS_DB']->Query($sql);

        while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($query)) {
            $row['startYear'] = ($row['startYear'] == 'ALL' ? 0 : $row['startYear']);
            $row['endYear'] = ($row['endYear'] == 'ALL' ? 0 : $row['endYear']);
            
            if (!$make || ($make && strtolower($row['make']) == strtolower($make))) {
                if ($impvaritions['startYear'] === null)
                    $impvaritions['startYear'] = $row['startYear'];
                else {
                    if ($row['startYear'] && $row['startYear'] < $impvaritions['startYear'])
                        $impvaritions['startYear'] = $row['startYear'];
                }
                if ($impvaritions['endYear'] === null)
                    $impvaritions['endYear'] = $row['endYear'];
                else {
                    if ($row['endYear'] && $row['endYear'] > $impvaritions['endYear'])
                        $impvaritions['endYear'] = $row['endYear'];
                }
            }
            
            if ($year && ($row['startYear'] > $year || $row['endYear'] < $year)) {
                continue;
            }
            
            if ($row['model'] != 'ALL' && !isset($impvaritions['model'][$row['model']])) {
                $impvaritions['model'][] = $row['model'];
            }
            
            if (($row['make'] != 'NON-SPEC VEHICLE' && !isset($impvaritions['make'][$row['make']])))
                $impvaritions['make'][] = $row['make'];
        }
        
        return $impvaritions;
    }
    
    /**
     * check Ymm selector value use Variation, an Variation is return by ISC_PRODUCT::GetImpVariationForYMM()
     * 
     * @param mix $value
     * @param array $variation
     * @param string $type
     * @return bool
     */
    public static function CheckYMMUseVariation($value, $variation, $type) {
        $value = strtoupper($value);
        if ($type == 'year' && $variation['startYear'] && ($value < $variation['startYear'] || $value > $variation['endYear'])) {
            return false;
        }elseif ($type == 'make' && !empty($variation['make']) && !in_array($value, $variation['make'])) {
            return false;
        }elseif ($type == 'model' && !empty($variation['model']) && !in_array($value, $variation['model'])) {
            return false;
        }
        return true;
    }
   
    /**
     * get product of $product all categoryids include parent cateogry id
     * 
     * @param integer $productid 
     * @return array
     */
    public static function GetProductCategoryids($productid) {
       $sql = "SELECT categoryid,catparentid FROM `[|PREFIX|]categories` WHERE categoryid IN (
                SELECT categoryid
                FROM  `[|PREFIX|]categoryassociations` 
                WHERE productid =$productid)"; 
       $query = $GLOBALS['ISC_CLASS_DB']->Fetch($GLOBALS['ISC_CLASS_DB']->Query($sql));
       return $query ? array($query['categoryid'], $query['catparentid']) : array();
    }
    
    /**
     * get product pq/vq
     * 
     * @param string $where  where condition for sql in import_variations table
     * @return string
     */
    public static function GetProductPQVQHtml($productid, $where = '') {
        $catids = self::GetProductCategoryids($productid);
        $qualifies = $lines = $impvariations = array();
        if (!empty($catids)) {
            $sql = "SELECT qn.qid,qn.column_name, qa.displayname AS ad, qn.display_names qd FROM [|PREFIX|]qualifier_associations qa
                    LEFT JOIN  `[|PREFIX|]qualifier_names` qn ON qn.qid = qa.qualifierid
                    WHERE qa.`categoryid` 
                    IN (". implode(',', $catids) . ")";
            $query = $GLOBALS['ISC_CLASS_DB']->Query($sql);

            while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($query)) {
               $qualifies[$row['column_name']] = $row['ad'] ? $row['ad'] : ($row['qd'] ? $row['qd'] : $row['column_name']);
            }
        }
        
        $sql = "SELECT %s FROM [|PREFIX|]import_variations where productid = '".$productid."' $where order by id";
        if (!empty($qualifies)) {
            $qualifierColumn = implode(',', array_keys($qualifies));
            $result = $GLOBALS["ISC_CLASS_DB"]->Query(sprintf($sql, "DISTINCT $qualifierColumn"));
            while($improw = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                foreach ($qualifies as $key => $value) {
                    if ($improw[$key]) {
                        foreach (explode(',', preg_replace("/[;]/", ',', $improw[$key])) as $t_pqvq ) {
                            if (!isset($lines[$value])) {
                                $lines[$value][] = $t_pqvq;
                            } else {
                                if (!in_array($t_pqvq, $lines[$value])) {                                
                                    $lines[$value][]= $t_pqvq;
                                }
                            }
                        }
                        
                    }
                }
            }
            $impvariations[] = '<ul style="list-style-type:none;margin:10px 0 0 2px;">';
            foreach ($lines as $key => $value) {
                $impvariations[] = "<li style=\"text-align:left;\"><b style=\"margin-right:3px;\">$key:</b>" . implode(',', $value) . "<div style=\"clear:both;\"></div></li>";
            }
            $impvariations[] = '</ul>';
        }
        return implode('', $impvariations);
    }
    
   	
	/*
     * return searies name.
     */
	public function getSeriesnameById($brandid,$brandseriesid){
		$seriesname = '';
		if($brandid > 0 && $brandseriesid >0){
			$sql = "select seriesname from [|PREFIX|]brand_series where brandid=".$brandid." and seriesid = ".$brandseriesid;
			$query = $GLOBALS['ISC_CLASS_DB']->Query($sql);
			while($rs = $GLOBALS['ISC_CLASS_DB']->Fetch($query)){
				$seriesname = $rs['seriesname'];
			}
			
		}
		return $seriesname;
	}
	
	

	}

?>