<?php

	/**
	* ISC_ADMIN_SITEMAPS
	* Generate sitemaps
	*
	* @author Wirror Yin
	* @copyright NI
	* @date	24th Aug 2010
	*/

	class ISC_ADMIN_SITEMAPS
	{
		
		public static $website;
		public static $sitemap_folder; 
		public static $sitemap_index = "sitemap"; 
		
		private $Changefreq = "weekly";//"always"᾿"hourly"᾿"daily"᾿"weekly"᾿"monthly"᾿"yearly" and "never"
		private $Priority = 0.5;
		private $Last_modification;
		
		private $xmlConfig = array(
								'IndexRoot' => 'sitemapindex',
								'IndexUrl' => 'sitemap',
								'NormalRoot' => 'urlset',
								'NormalUrl' => 'url',
								'childNodes' => array('loc')
		                     );
		
		private $sitemapIndex = array();
		
		/**
		* Constructor
		* Work out which addon we're running so we can show it in the breadcrum trail amongst other things
		*
		* @return Void
		*/
		public function __construct()
		{
			ini_set("memory_limit","-1");
			require_once(ISC_BASE_PATH .'/class.opxml.php');
			
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('sitemaps');
			
			self::$website = GetConfig('ShopPath');
			self::$sitemap_folder = ISC_BASE_PATH.'/'."sitemaps";
			$this->Last_modification = date("Y-m-d");//date("Y-m-d\TH:i:s").substr(date("O"),0,3).":".substr(date("O"),3);
			
			//otherwise, the sitemaps folder and sitemap.xml need to be create by the admin
			if(!is_dir(self::$sitemap_folder)){
				if(mkdir(self::$sitemap_folder)){
					chmod(self::$sitemap_folder, 0777); 
				}
			}
			
			$filename = self::$sitemap_index.'.xml';
			if(!file_exists(ISC_BASE_PATH . '/' .$filename)){
				file_put_contents(ISC_BASE_PATH . '/' .$filename, '');
				chmod($filename, 0777);     
			}
		}

		/**
		* HandleToDo
		* Which sitemap function should we run?
		*
		* @param String $ToDo The function to run
		* @return Void
		*/
		public function HandleToDo($Do)
		{
			switch (isc_strtolower($Do)) {
				case "savesitemapconfig": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Sitemaps)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SaveSitemapConfig();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "updatesitemapconfig": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Sitemaps)) {
						$this->UpdateSitemapConfig();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "createcbsitemap": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Sitemaps)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateCategoryBrandSitemap();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "createmixcbsitemap": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Sitemaps)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateMixCategoryBrandSitemap();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "createpbsitemap": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Sitemaps)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateProductBrandSitemap();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "createdynamicsitemap": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Sitemaps)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateDynamicPageSitemap();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "createstaticsitemap": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Sitemaps)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateStaticPageSitemap();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "createsitemapindex": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Sitemaps)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->CreateSitemapIndex();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				}
				case "prevsitemap": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Sitemaps)) {
						$this->PreviewSitemap();
					} else {
						exit;
					}
					break;
				}
				default: {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Sitemaps)) {
						$GLOBALS["BreadcrumEntries"] = array(GetLang('Home') => "index.php", GetLang('Sitemap') => "index.php?ToDo=viewSitemaps");
	
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->ManageSitemaps();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
			}
		}
		
		/**
		 * Preview Sitemaps according to the type
		 *
		 */
		public function PreviewSitemap(){
			
			if(!isset($_GET['MapType']))
				exit('no maptype defined!');
				
			$GLOBALS['SitemapType'] = $_GET['MapType'];
			
			$uQuery = "SELECT * FROM [|PREFIX|]sitemap_setting limit 0,1";
            $uResult = $GLOBALS['ISC_CLASS_DB']->Query($uQuery);
            if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($uResult)){
				$this->xmlConfig['IndexRoot'] = $row['indexroot'];
				$this->xmlConfig['IndexUrl'] = $row['indexurl'];
				$this->xmlConfig['NormalRoot'] = $row['normalroot'];
				$this->xmlConfig['NormalUrl'] = $row['normalurl'];
				$this->xmlConfig['childNodes'] = explode(',', $row['childnodes']);
            }else{
				$this->xmlConfig["MaxmumRecords"] = "50,000";
				$this->xmlConfig["IndexRootName"] = "sitemapindex";
				$this->xmlConfig["NormalRootName"] = "urlset";
				$this->xmlConfig["IndexUrlName"] = "sitemap";
				$this->xmlConfig["NormalUrlName"] = "url";
				$this->xmlConfig['childNodes'] = array('loc');
            }
			
			
			switch($_GET['MapType']){
				
				case 'Category-Brand': {
					$isRoot = false;
					$datas = array('http://test.site.com/a/brand/b',
								   'http://test.site.com/a/brand/c',
								   'http://test.site.com/a/brand/d');
					$GLOBALS['GenerateUrl'] = "index.php?ToDo=createCbSitemap";
					$GLOBALS['RemindMessage'] = "This a preview page for category-brand.";
					break;
				}
				case 'Mix-Category-Brand': {
					$isRoot = false;
					$datas = array('http://test.site.com/a/brand/b',
								   'http://test.site.com/b/series/c',
								   'http://test.site.com/c/subcategory/d');
					$GLOBALS['GenerateUrl'] = "index.php?ToDo=createMixCbSitemap";
					$GLOBALS['RemindMessage'] = "This a preview page for mix-category-brand.";
					break;
				}
				case 'Brand-Product': {
					$isRoot = false;
					$datas = array('http://test.site.com/a.html',
								   'http://test.site.com/b.html',
								   'http://test.site.com/c.html');
					$GLOBALS['GenerateUrl'] = "index.php?ToDo=createPbSitemap";
					$GLOBALS['RemindMessage'] = "This a preview page for brand-product.";
					break;
				}
				case 'Dynamic-Page': {
					$isRoot = false;
					$datas = array('http://test.site.com/a/year/2010',
								   'http://test.site.com/b/make/ford',
								   'http://test.site.com/c/model/c2500');
					$GLOBALS['GenerateUrl'] = "index.php?ToDo=createDynamicSitemap";
					$GLOBALS['RemindMessage'] = "This a preview page for dynamic-page.";
					break;
				}
				case 'Static-Page': {
					$isRoot = false;
					$datas = array('http://test.site.com/a',
								   'http://test.site.com/a/subcategory/b',
								   'http://test.site.com/a/brand/c');
					$GLOBALS['GenerateUrl'] = "index.php?ToDo=createStaticSitemap";
					$GLOBALS['RemindMessage'] = "This a preview page for static-page.";
					break;
				}
				case 'Index-Map': {
					$isRoot = true;
					$datas = array('http://test.site.com/sitemaps/a.xml',
								   'http://test.site.com/sitemaps/b.xml',
								   'http://test.site.com/sitemaps/c.xml');
					$GLOBALS['GenerateUrl'] = "index.php?ToDo=createSitemapIndex";
					$GLOBALS['RemindMessage'] = "This a preview page for index-map.";
					break;
				}
				default:{
					$isRoot = false;
					$datas = array('http://test.site.com/a/',
								   'http://test.site.com/b/',
								   'http://test.site.com/c/');
					break;
				}
			}
			
			$rootTag =  $isRoot?$this->xmlConfig['IndexRoot']:$this->xmlConfig['NormalRoot'];
			$urlTag =  $isRoot?$this->xmlConfig['IndexUrl']:$this->xmlConfig['NormalUrl'];
			$childTags = array();
			
			$xmlDoc = new OpXML();
			$urlset = $xmlDoc->addRoot($rootTag,array('xmlns'=>'http://www.sitemaps.org/schemas/sitemap/0.9'));
			
			foreach($datas as $data){
				$url = $xmlDoc->addChild($urlset, $urlTag);
				foreach($this->xmlConfig['childNodes'] as $tag){
					if($tag == 'loc'){
						$childTags[$tag] = htmlspecialchars($data, ENT_QUOTES, "UTF-8");
					}else if($tag == 'lastmod'){
						$childTags[$tag] = date("Y-m-d");
					}else if($tag == 'changefreq'){
						$childTags[$tag] = 'weekly';
					}else if($tag == 'priority'){
						$childTags[$tag] = '0.5';
					}
				}
				foreach($childTags as $childTag => $childVal){
					$xmlDoc->addChild($url, $childTag, $childVal);
				}
			}

			$GLOBALS['PreviewTemplate'] = str_replace("\n",'<br/>',htmlspecialchars($xmlDoc->__toString(), ENT_QUOTES, "UTF-8"));
			
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("sitemaps.preview");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}
		
		/**
		 * SaveSitemapConfig
		 *
		 */
		public function SaveSitemapConfig(){
			$urlChildren = '';
			if(isset($_POST['ISSelectReplacement_urlChildNodes']) && is_array($_POST['ISSelectReplacement_urlChildNodes'])){
				$urlChildren = implode(',',$_POST['ISSelectReplacement_urlChildNodes']);
			}
			
			$configData = array(
					'maxrecord' => $_POST['maxRecord'],
					'indexroot' => $_POST['indexRootName'],
					'normalroot' => $_POST['normalRootName'],
					'indexurl' => $_POST['indexUrlName'],
					'normalurl' => $_POST['normalUrlName'],
					'childnodes' => $urlChildren
				);
	    	$GLOBALS['ISC_CLASS_DB']->InsertQuery('sitemap_setting', $configData);
	    	
	    	$location= 'index.php?ToDo=manageSitemap';
			header('Location: '.$location);
			exit;
		}
		
		/**
		 * UpdateSitemapConfig
		 *
		 */
		public function UpdateSitemapConfig(){
			
			$itemid = $_POST['sitemapId'];
			$urlChildren = '';
			if(isset($_POST['ISSelectReplacement_urlChildNodes']) && is_array($_POST['ISSelectReplacement_urlChildNodes'])){
				$urlChildren = implode(',',$_POST['ISSelectReplacement_urlChildNodes']);
			}
            
			$configData = array(
					'maxrecord' => $_POST['maxRecord'],
					'indexroot' => $_POST['indexRootName'],
					'normalroot' => $_POST['normalRootName'],
					'indexurl' => $_POST['indexUrlName'],
					'normalurl' => $_POST['normalUrlName'],
					'childnodes' => $urlChildren
				);
				
			$GLOBALS['ISC_CLASS_DB']->Query("START TRANSACTION");
	
			// Update the status for this order review request
			if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("sitemap_setting", $configData, "id='".$GLOBALS['ISC_CLASS_DB']->Quote($itemid)."'")) {
				// Log this action if we are in the control panel
				if (defined('ISC_ADMIN_CP')) {
					//$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($orderId, $statusName);
				}
			}
			// Was there an error? If not, commit
			if ($GLOBALS['ISC_CLASS_DB']->Error() == "") {
				$GLOBALS['ISC_CLASS_DB']->Query("COMMIT");
			}
			
			$location= 'index.php?ToDo=manageSitemap';
			header('Location: '.$location);
			exit;
		}
		
		/**
		 * CreateCategoryBrandSitemap
		 *
		 */
		public function CreateCategoryBrandSitemap(){
			$categoryBrandURLs = $this->GetCategoryBrandURLs();
			$this->SaveAsXML(array('category-brand'=>$categoryBrandURLs));
			$this->ManageSitemaps();
		}
		
		/**
		 * CreateMixCategoryBrandSitemap
		 *
		 */
		public function CreateMixCategoryBrandSitemap(){
			$mixCategoryBrandURLs = $this->GetMixCategoryBrandURLs();
			$this->SaveAsXML(array('mix-category-brand'=>$mixCategoryBrandURLs));
			$this->ManageSitemaps();
		}
		
		/**
		 * CreateProductBrandSitemap
		 *
		 */
		public function CreateProductBrandSitemap(){
			$productBrandURLs = $this->GetProductBrandURLs();
			$this->SaveAsXML($productBrandURLs);
			$this->ManageSitemaps();
		}
		
		/**
		 * CreateDynamicPageSitemap
		 *
		 */
		public function CreateDynamicPageSitemap(){
			$hasmore = false;
			$pageYMM = isset($_POST['pageCount2']) ? $_POST['pageCount2'] : 0;
			$pageCateBrand = isset($_POST['pageCount']) ? $_POST['pageCount'] : 0;
			$filename = isset($_POST['dynamic_filename']) ? $_POST['dynamic_filename'] : '';
			$this->GenerateDynamicPagesURLs($filename, $pageCateBrand, $pageYMM, $hasmore);
			
			$GLOBALS["PageYMM"] = $pageYMM;
			$GLOBALS["PageCateBrand"] = $pageCateBrand;
			$GLOBALS["DynamicFileName"] = $filename;
			$GLOBALS["GenerateLabel"] = $hasmore?GetLang('Generate').'>>':GetLang('Generate');
			$this->ManageSitemaps();
		}
		
		/**
		 * Create StaticPageSitemap
		 *
		 */
		public function CreateStaticPageSitemap(){
			$staticPageURLs = $this->GetStaticPageURLs();
			$this->SaveAsXML(array('static-pages'=>$staticPageURLs));
			$this->ManageSitemaps();
		}
		
		/**
		 * CreateSitemapIndex
		 *
		 */
		public function CreateSitemapIndex(){
			
			$this->SaveAsXML(array(self::$sitemap_index=>$this->GetSitemapIndexArray()), true);
			$this->ManageSitemaps();
		}
		
		/**
		 * GetSitemapIndexArray
		 *
		 */
		public function GetSitemapIndexArray(){
			$indexArr = array();
			if(count($this->sitemapIndex)==0)
			{
				$tmpArr = file_list(self::$sitemap_folder, "/\.xml$/i");
				foreach($tmpArr as $key=>$value){
					  $url = self::$website.str_replace(ISC_BASE_PATH, '', $value);
					  //$url = htmlspecialchars($url, ENT_NOQUOTES, "UTF-8");
				      $indexArr[$key] = $url;
				}
			}
			else
			{
				$indexArr = $this->sitemapIndex;
			}
			
			sort($indexArr);
			return $indexArr;	
		}
		
		/**
		 * GetCategoryURLS
		 *
		 */
		public function GetCategoryURLS($specCondition='1=1'){
			$categoryURLs = array();
			
			//categories
			$query = "
				SELECT categoryid, catname 
				FROM [|PREFIX|]categories 
				WHERE catparentid=%d
				AND %s 
				ORDER BY catname ASC
			";
			
			$queryProds = "
				SELECT distinct p.productid
				FROM [|PREFIX|]categoryassociations cs
				INNER JOIN [|PREFIX|]products p ON cs.productid = p.productid
				WHERE cs.categoryid=%d AND p.prodvisible=1
			";
			
			//echo 'Executing query:<br/><font color=red>'.$query.'</font><br/>';
			$result = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($query, 0, $specCondition));
		
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$resultSub = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($query, $row['categoryid'], '1=1'));
				$isRootCate = true;
				while ($rowSub = $GLOBALS['ISC_CLASS_DB']->Fetch($resultSub)) {
					$resultProds = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($queryProds, $rowSub['categoryid']));
					$hasProds = $GLOBALS['ISC_CLASS_DB']->FetchOne($resultProds);
					if($hasProds) {
						if($isRootCate) {
							$url = $this->FormatLink($row['catname']);
							//$url = htmlspecialchars($url, ENT_NOQUOTES, "UTF-8");
							$categoryURLs[$url] = 1;
							$isRootCate = false;
						}
				
						$prodIds = array();
						while($prodRow = $GLOBALS['ISC_CLASS_DB']->Fetch($resultProds))
						{
							$prodIds[] = $prodRow['productid'];
						}
						
						$url = $this->FormatLink($row['catname'], array('subcategory'=>$rowSub['catname']));
						//$url = htmlspecialchars($url, ENT_NOQUOTES, "UTF-8");
						$categoryURLs[$url] = $prodIds;
						if(strpos($url,'fuel-delivery'))
						{
							//print_r($prodIds);
						}
					}
				}
			}
			return $categoryURLs;
		}
		
		/**
		 * GetBrandURLS
		 *
		 */
		public function GetBrandURLS(){
			$brandURLs = array();
			
			//brand-series
			$query = "SELECT brandid, brandname
					  FROM [|PREFIX|]brands
					  GROUP BY brandname
					  ORDER BY brandname ASC
					 ";
					 
			$queryProds = "
				SELECT p.productid
				FROM [|PREFIX|]products p
				LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid 
				LEFT JOIN [|PREFIX|]categoryassociations ca on ca.productid = p.productid 
				LEFT JOIN [|PREFIX|]categories c on c.categoryid = ca.categoryid and c.catvisible = 1 
				LEFT JOIN [|PREFIX|]brands b ON p.prodbrandid = b.brandid
				LEFT JOIN [|PREFIX|]brand_series bs ON p.brandseriesid = bs.seriesid 
				LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid AND pi.imageisthumb=1) 
				LEFT JOIN [|PREFIX|]product_finalprice fp ON p.productid = fp.productid 
				WHERE b.brandid=%d  
				AND bs.seriesid=%d 
				AND p.prodvisible=1
				AND c.categoryid is not null
				GROUP BY p.productid, v.prodmake
			";
			
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$isRootBrand = true;
				$query = "SELECT seriesname, seriesid
					  FROM [|PREFIX|]brand_series bs
					  WHERE bs.brandid = %d
					  ORDER BY seriesname ASC
					 ";
				
				$resultSub = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($query, $row['brandid']));
				while ($rowSub = $GLOBALS['ISC_CLASS_DB']->Fetch($resultSub)) {
					$resultProds = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($queryProds, $row['brandid'], $rowSub['seriesid']));
					$hasProds = $GLOBALS['ISC_CLASS_DB']->FetchOne($resultProds);
					if($hasProds) {
						if($isRootBrand) {
							$url = $this->FormatLink($row['brandname']);
							//$url = htmlspecialchars($url, ENT_NOQUOTES, "UTF-8");
							$brandURLs[$url] = 1;
							$isRootBrand = false;
						}
				
						$prodIds = array();
						while($prodRow = $GLOBALS['ISC_CLASS_DB']->Fetch($resultProds))
						{
							$prodIds[] = $prodRow['productid'];
						}
						
						$url = $this->FormatLink($row['brandname'], array('series'=>$rowSub['seriesname']));
						//$url = htmlspecialchars($url, ENT_NOQUOTES, "UTF-8");
						$brandURLs[$url] = $prodIds;
					}
				}
			}
			
			return $brandURLs;
		}
	
		/**
		 * GetCategoryBrandURLs
		 *
		 */
		public function GetCategoryBrandURLs()
		{
			$categoryURLs = $this->GetCategoryURLS();
			$brandURLs = $this->GetBrandURLS();
			$categoryBrandURLs = array_merge(array_keys($categoryURLs), array_keys($brandURLs));

			return $categoryBrandURLs;
		}
		
		/**
		 * Get Custom mix-category-brand Url from custom page 
		 */
		public function GetCustomMixCategoryBrandURLs($catidlist)
		{
			$customURL = array();
			$query = "SELECT DISTINCT(cp.visiturl)
            		  FROM [|PREFIX|]custom_products cp 
            		  INNER JOIN [|PREFIX|]custom_contents cc on cc.contentid=cp.contentid
            		  WHERE cp.enabled=1
			  AND REPLACE(cc.`description`,'custom products content for category#','') IN (".trim($catidlist,",").")
            		  ";
			//echo "|| ".str_replace("[|PREFIX|]","isc_",$query)."<hr>";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				array_push($customURL, $row['visiturl']);
			}
			
			return $customURL;
		}
		
		/**
		 * GetMixCategoryBrandURLs
		 *
		 */
		public function GetMixCategoryBrandURLs()
		{
			$mixURLs = array();
			
			$query = "
				SELECT categoryid, catname 
				FROM [|PREFIX|]categories 
				WHERE catname in (%s)
				ORDER BY catname ASC
			";
			//echo 'Executing query:<br/><font color=red>'.$query.'</font><br/>';
			// leo 2011-11-16 we should use popular categories entered by admin on the web page
			//$popularCats = "'Nerf Bars', 'Fender Flares', 'Tonneau Covers', 'Bed Mats', 'Air Intakes', 'Bull Bars', 'Floor Protection', 'Exhaust Systems', 'Bug Shields', 'Performance Chips'";
			$popularCats="";
			$categories = explode(",",$_POST['popularCats']);
			// store new popular categories into isc_sitemap_setting table
			$squery = "UPDATE [|PREFIX|]sitemap_setting SET popularcatlist='".$_POST['popularCats']."'";
		        $sresult = $GLOBALS['ISC_CLASS_DB']->Query($squery);
			foreach($categories as $category)
			{
				$popularCats.="'".trim($category)."',";
			}
			$popularCats=trim($popularCats,",");
			//echo $popularCats."<hr>";die();
			//echo "xx ".sprintf(str_replace("[|PREFIX|]","isc_",$query), $popularCats)."<br><hr>";
			// end of 2011-11-16
			$result = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($query, $popularCats));
			$catidlist="";
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$catidlist.="'".$row['categoryid']."',";
				$brandFlag = true;
				$queryBrand = "
					SELECT c.catname, b.brandname
					FROM [|PREFIX|]products p
					LEFT JOIN [|PREFIX|]categoryassociations ca on ca.productid = p.productid 
					LEFT JOIN [|PREFIX|]categories c on c.categoryid = ca.categoryid and c.catvisible = 1 
					LEFT JOIN [|PREFIX|]brands b ON p.prodbrandid = b.brandid
					WHERE c.catparentid=%d
					AND p.prodvisible='1'
					ORDER BY catname ASC
				";
				//echo "yy ".sprintf(str_replace("[|PREFIX|]","isc_",$queryBrand), $row['categoryid'])."<br><hr>";
				$resultBrand = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($queryBrand, $row['categoryid']));
				while ($rowBrand = $GLOBALS['ISC_CLASS_DB']->Fetch($resultBrand)) {
					$urlBrand = $this->FormatLink($row['catname'], array(
																'subcategory' => $rowBrand['catname'],
																'brand' => $rowBrand['brandname']
															   ));
					//$urlBrand = htmlspecialchars($urlBrand, ENT_NOQUOTES, "UTF-8");
					if($brandFlag){
						array_push($mixURLs, $urlBrand);
					}
					$brandFlag = false;
				}
				
				$query = "
					SELECT c.categoryid, c.catname, b.brandname, bs.seriesname 
					FROM [|PREFIX|]products p
					LEFT JOIN [|PREFIX|]categoryassociations ca on ca.productid = p.productid 
					LEFT JOIN [|PREFIX|]categories c on c.categoryid = ca.categoryid and c.catvisible = 1 
					LEFT JOIN [|PREFIX|]brands b ON p.prodbrandid = b.brandid
					LEFT JOIN [|PREFIX|]brand_series bs ON p.brandseriesid = bs.seriesid 
					WHERE c.catparentid=%d
					AND p.prodvisible='1'
					GROUP BY seriesname
					ORDER BY catname ASC
				";
				//echo "zz ".sprintf(str_replace("[|PREFIX|]","isc_",$query), $row['categoryid'])."<br><hr>";
				$resultSub = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($query, $row['categoryid']));
				while ($rowSub = $GLOBALS['ISC_CLASS_DB']->Fetch($resultSub)) {
					$url = $this->FormatLink($row['catname'], array(
																'subcategory' => $rowSub['catname'],
																'brand' => $rowSub['brandname'],
																'series' => $rowSub['seriesname']
															   ));
					//$url = htmlspecialchars($url, ENT_NOQUOTES, "UTF-8");
					array_push($mixURLs, $url);
				}
			}
			
			$categoryURLs = $this->GetCategoryURLS("catname in ($popularCats)");
			$mixURLs = array_merge(array_keys($categoryURLs), $mixURLs, $this->GetCustomMixCategoryBrandURLs($catidlist));
			sort($mixURLs);
			return $mixURLs;
		}
		
		/**
		 * GetProductBrandURLs
		 *
		 */
		public function GetProductBrandURLs()
		{
			$filesize = 50000;
			$filePrefix = 'products';
			$dynamicPagesFiles = array();
			
			$query = "
				SELECT brandid, brandname
				FROM [|PREFIX|]brands
			";
		
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			//alandy_2012-2-20 modify sitemap product url.
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))
			{
				$prodQuery = sprintf("
						SELECT prodname, brandname, prodcode,prodvendorprefix
						FROM [|PREFIX|]brands b, [|PREFIX|]products p
						WHERE p.prodbrandid=b.brandid AND brandid=%d
						",$row['brandid']);
				//echo "Deep query:<br/><font color=red>$prodQuery</font><br/>";
				
				$prodResult = $GLOBALS['ISC_CLASS_DB']->Query($prodQuery);
				$total_results = $GLOBALS['ISC_CLASS_DB']->CountResult($prodResult);
			
				$num_files = ceil($total_results / $filesize);
				
				for($fileIndex=0; $fileIndex < $num_files; $fileIndex++)
				{
					$categoryURLs = array();
					$newQuery = $prodQuery;
					$newQuery .= $GLOBALS['ISC_CLASS_DB']->AddLimit($fileIndex*$filesize, $filesize);
					$resultLimit = $GLOBALS['ISC_CLASS_DB']->Query($newQuery);
					$firstRow = true;
					$SKU = '';
					$vendorprefix = '';
					while ($rowSub = $GLOBALS['ISC_CLASS_DB']->Fetch($resultLimit)) {
						if($firstRow){
						  $SKU = $rowSub['prodcode'];
						  $firstRow = false;
						}
						$url = ProdLinkSKU($rowSub['prodvendorprefix'], encode_sku($rowSub['prodcode']));
						//$url = htmlspecialchars($url, ENT_NOQUOTES, "UTF-8");
						array_push($categoryURLs, $url);
					}
					
					if($num_files < 2){
						$dynamicPagesFiles[$filePrefix.'-'.preg_replace("/\s+/",'-',strtolower($row['brandname']))] = $categoryURLs;
					}else{
						$dynamicPagesFiles[$filePrefix.'-'.preg_replace("/\s+/",'-',strtolower($row['brandname'])).'-'.$SKU] = $categoryURLs;
					}
				}
				
			}
			
			return $dynamicPagesFiles;
		}
		
		public function GetStaticPageURLs()
		{
			$staticPages = array();	
			if(isset($_REQUEST['staticULRs']) &&  !empty($_REQUEST['staticULRs']))
				$staticPages = explode(',', $_REQUEST['staticULRs']);
				
			return $staticPages;
		}
		
		/**
		 * _generalYMM
		 *
		 */
		private function _generalYMM($prodIds){
			$prodIds = implode(',', $prodIds);
			$arrYears = range(1995, 2010);
			$arrMakes = array('Chevrolet', 'GMC', 'Ford', 'Dodge', 'Toyota', 'Nissan', 'Honda', 'Jeep', 'Hyundai', 'Chrysler', 'Infiniti', 'Lexus');
			$arrYMM = array();
	          
			foreach($arrYears as $year){
				foreach($arrMakes as $make){
					$ymm_qry = "SELECT distinct prodmodel 
						FROM [|PREFIX|]products p 
						LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid 
						WHERE p.prodvisible='1'
						AND p.productid IN($prodIds) 
						AND('$year' between prodstartyear and prodendyear OR prodstartyear = 'all' )
						";
						//AND prodmake='$make'
					$ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
					while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
					{
							if ($GLOBALS['EnableSEOUrls'] == 1) {
						 		$yearTmp = "/year/$year";
								$makeTmp = "/make/".strtolower($make);
								$modelTmp = "/model/".MakeURLSafe(strtolower($ymm_row['prodmodel']));
							}else{
								$yearTmp = "&year=$year";
								$makeTmp = "&make=".strtolower($make);
								$modelTmp = "&model=".MakeURLSafe(strtolower($ymm_row['prodmodel']));
							}
							$arrYMM[] = "$yearTmp$makeTmp$modelTmp";
					}
				}	
			}
			
			return $arrYMM;
		}
		
		/**
		 * GenerateDynamicPagesURLs
		 *
		 */
		public function GenerateDynamicPagesURLs(& $curfilename, & $pageCateBrand, & $pageYMM, & $hasmore = false)
		{
			$filesize = 50000;
			$pagesize = 1;
			$totalsize = $filesize * $pagesize;
			$filePrefix = 'dynamic-pages';
			
			//$categoryBrandURLs = $this->GetCategoryBrandURLs();
			$categoryURLs = $this->GetCategoryURLS();
			$brandURLs = $this->GetBrandURLS();
			$categoryBrandURLs = array_merge(array_keys($categoryURLs), array_keys($brandURLs));
			
			$urlCount = 1;
			$countName = 'Cake'.$urlCount;
			$$countName = array();
			
			$countCateBrand = count($categoryBrandURLs);
			$countFlag = true;
			
			for($cc=$pageCateBrand; $cc<$countCateBrand ; $cc++){
				/*
				reset($ymmURLs);
				while(next($ymmURLs)){
					current($ymmURLs);
				}*/
				if(isset($categoryURLs[$categoryBrandURLs[$cc]])){
					$ymmURLs = $this->_generalYMM($categoryURLs[$categoryBrandURLs[$cc]]);
				}else{
					$ymmURLs = $this->_generalYMM($brandURLs[$categoryBrandURLs[$cc]]);
				}
				$countYMM = count($ymmURLs);
				$pageYMM = $countFlag ? $pageYMM : 0;
				for($yy=$pageYMM; $yy<$countYMM; $yy++){
					if(count($$countName) < $filesize){
						array_push($$countName, $categoryBrandURLs[$cc].$ymmURLs[$yy]);
					}else{
						if($urlCount < $pagesize-1){
							$urlCount++;
							$countName = 'Cake'.$urlCount;
							$$countName = array();
							array_push($$countName, $categoryBrandURLs[$cc].$ymmURLs[$yy]);
						}else{
							$pageCateBrand = $cc;
							$pageYMM = $yy;
							$hasmore = true;
							break;
						}
					}
				}
				$countFlag = false;
				
				if($hasmore){
					break;
				}
			}
			
			if($pageCateBrand==0 && $pageYMM==0 && !$hasmore){
				$this->SaveAsXML(array($filePrefix => $$countName));
			}else{
				for($ii=1; $ii<=$urlCount; $ii++){
					$countName = 'Cake'.$ii;
					$countArr = $$countName;
					if ($GLOBALS['EnableSEOUrls'] == 1) {
						$nameArr = explode('/', $countArr[0]);
						for($i=4; $i<count($nameArr); $i+=2){
							$newArr[$nameArr[$i]] = $nameArr[$i+1];
						}
					}else{
						$delimiters = Array("?","&","=");
						$res = multiexplode($delimiters,$countArr[0]);
						foreach($res[1] as $value)
						{
							$newArr[$value[0]]=$value[1];
						}
					}
					
					if(isset($newArr['series'])){
						$suffixName = $newArr['series'];
					}
					else if(isset($newArr['brand'])){
						$suffixName = $newArr['brand'];
					}
					else if(isset($newArr['subcategory'])){
						$suffixName = $newArr['subcategory'];
					}else{
						if ($GLOBALS['EnableSEOUrls'] == 1) {
							$suffixName = $nameArr[3];
						}else{
							$suffixName = $newArr['search_query'];
						}
					}
					
					$filename = $filePrefix.'-'.$this->GenerateFilename($filePrefix, $this->MakeFileNameSafe(MakeURLNormal($suffixName)));
					
					$curfilename = $filename;
						
					$this->SaveAsXML(array($filename => $countArr));
				}
			}
			
			return true;
		}
		
		/**
		 * SaveAsXML
		 *
		 */
		public function SaveAsXML($filelist, $isRoot = false)
		{
			$adjustPath = $isRoot ? ISC_BASE_PATH . '/' : self::$sitemap_folder.'/';
			
			$uQuery = "SELECT * FROM [|PREFIX|]sitemap_setting limit 0,1";
            $uResult = $GLOBALS['ISC_CLASS_DB']->Query($uQuery);
            if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($uResult)){
				$this->xmlConfig['IndexRoot'] = $row['indexroot'];
				$this->xmlConfig['IndexUrl'] = $row['indexurl'];
				$this->xmlConfig['NormalRoot'] = $row['normalroot'];
				$this->xmlConfig['NormalUrl'] = $row['normalurl'];
				$this->xmlConfig['childNodes'] = explode(',', $row['childnodes']);
            }else{
				$this->xmlConfig["MaxmumRecords"] = "50,000";
				$this->xmlConfig["IndexRootName"] = "sitemapindex";
				$this->xmlConfig["NormalRootName"] = "urlset";
				$this->xmlConfig["IndexUrlName"] = "sitemap";
				$this->xmlConfig["NormalUrlName"] = "url";
				$this->xmlConfig['childNodes'] = array('loc');
            }
			
			$rootTag =  $isRoot?$this->xmlConfig['IndexRoot']:$this->xmlConfig['NormalRoot'];
			$urlTag =  $isRoot?$this->xmlConfig['IndexUrl']:$this->xmlConfig['NormalUrl'];
			$childTags = array();

			foreach($filelist as $filename=>$datas){
				//echo "$filename.xml is generating...<br/>";
				if(count($datas) > 100000)
				{	
					$tmpDatas = array_chunk($datas, 10000);
					foreach($tmpDatas as $tmps)
					{
						$xmlDoc = new OpXML();
						$urlset = $xmlDoc->addRoot($rootTag,array('xmlns'=>'http://www.sitemaps.org/schemas/sitemap/0.9'));
						foreach($tmps as $data){
							$url = $xmlDoc->addChild($urlset, $urlTag);
							foreach($this->xmlConfig['childNodes'] as $tag){
								if($tag == 'loc'){
									$childTags[$tag] = htmlspecialchars($data, ENT_QUOTES, "UTF-8");
								}else if($tag == 'lastmod'){
									$childTags[$tag] = date("Y-m-d");
								}else if($tag == 'changefreq'){
									$childTags[$tag] = 'weekly';
								}else if($tag == 'priority'){
									$childTags[$tag] = '0.5';
								}
							}
							foreach($childTags as $childTag => $childVal){
								$xmlDoc->addChild($url, $childTag, $childVal);
							}
						}
						$saveResult = $xmlDoc->save("$adjustPath$filename.xml", "a");
					}
					
				}else{
					$xmlDoc = new OpXML();
					$urlset = $xmlDoc->addRoot($rootTag,array('xmlns'=>'http://www.sitemaps.org/schemas/sitemap/0.9'));
					foreach($datas as $data){
						$url = $xmlDoc->addChild($urlset, $urlTag);
						foreach($this->xmlConfig['childNodes'] as $tag){
							if($tag == 'loc'){
								$childTags[$tag] = htmlspecialchars($data, ENT_QUOTES, "UTF-8");
//var_dump($childTags[$tag]);echo "<br>";
							}else if($tag == 'lastmod'){
								$childTags[$tag] = date("Y-m-d");
							}else if($tag == 'changefreq'){
								$childTags[$tag] = 'weekly';
							}else if($tag == 'priority'){
								$childTags[$tag] = '0.5';
							}
						}
						foreach($childTags as $childTag => $childVal){
							$xmlDoc->addChild($url, $childTag, $childVal);
						}
					}
					$saveResult = $xmlDoc->save("$adjustPath$filename.xml");
				}
				if($saveResult)
				{
					$filepath = htmlspecialchars((self::$website)."/$adjustPath$filename.xml");
					array_push($this->sitemapIndex, (self::$website)."/$adjustPath$filename.xml");
					//echo 'Save '.htmlspecialchars($filename).".xml Successful.<br/>Total: $saveResult Bytes.<br/>";
					$filepath = str_replace(ISC_BASE_PATH.'/', '', $filepath);
					//return $filepath;
				}
				else
				{
					return false;
				}
			}

		}

		/**
		* ManageSitemaps
		* 
		* @return Void
		*/
		public function ManageSitemaps($MsgDesc = "", $MsgStatus = "")
		{
			if($MsgDesc != "") {
				$GLOBALS["Message"] = MessageBox($MsgDesc, $MsgStatus);
			}
			
			if(!isset($GLOBALS["GenerateLabel"]))
				$GLOBALS["GenerateLabel"] = GetLang('Generate');
			
			if(isset($_POST['currentTab'])){
				$GLOBALS["CurrentTab"] = $_POST['currentTab'];
			}else{
				$GLOBALS["CurrentTab"] = 0;
			}
			
			$indexArr = file_list(self::$sitemap_folder, "/\.xml$/i");
			$cbArr = $this->FilterArray(self::$sitemap_folder.'/category-brand', $indexArr);
			$mcbArr = $this->FilterArray(self::$sitemap_folder.'/mix-category-brand', $indexArr);
			$pbArr = $this->FilterArray(self::$sitemap_folder.'/products', $indexArr);
			$dpArr = $this->FilterArray(self::$sitemap_folder.'/dynamic-pages', $indexArr);
			$spArr = $this->FilterArray(self::$sitemap_folder.'/static-pages', $indexArr);
			
			if(count($cbArr) > 0){
				$GLOBALS["CatBrandResult"] = "";
				foreach($cbArr as $val){
					$val = str_replace(ISC_BASE_PATH, GetConfig('ShopPath'), $val);
					$GLOBALS["CatBrandResult"] .= "<a href='$val'>$val</a><br/>";
				}
			}else{
				$GLOBALS["CatBrandResult"] = "<span style='color: red;'>You haven't generated the category-brand sitemap yet!</span>";
			}
			
			if(count($mcbArr) > 0){
				$GLOBALS["MixCatBrandResult"] = "";
				foreach($mcbArr as $val){
					$val = str_replace(ISC_BASE_PATH, GetConfig('ShopPath'), $val);
					$GLOBALS["MixCatBrandResult"] .= "<a href='$val'>$val</a><br/>";
				}
			}else{
				$GLOBALS["MixCatBrandResult"] = "<span style='color: red;'>You haven't generated the mix-category-brand sitemap yet!</span>";
			}
			
			if(count($pbArr) > 0){
				$GLOBALS["ProdBrandResult"] = "";
				foreach($pbArr as $val){
					$val = str_replace(ISC_BASE_PATH, GetConfig('ShopPath'), $val);
					$GLOBALS["ProdBrandResult"] .= "<a href='$val'>$val</a><br/>";
				}
			}else{
				$GLOBALS["ProdBrandResult"] = "<span style='color: red;'>You haven't generated the product-brand sitemap yet!</span>";
			}
			
			if(count($dpArr) > 0){
				$GLOBALS["DynmicPageResult"] = "";
				foreach($dpArr as $val){
					$val = str_replace(ISC_BASE_PATH, GetConfig('ShopPath'), $val);
					$GLOBALS["DynmicPageResult"] .= "<a href='$val'>$val</a><br/>";
				}
			}else{
				$GLOBALS["DynmicPageResult"] = "<span style='color: red;'>You haven't generated the dynamic-page sitemap yet!</span>";
			}
			
			if(count($spArr) > 0){
				$GLOBALS["StaticPageResult"] = "";
				if(class_exists('DOMDocument')){
				    $xml = new DOMDocument();
				    $xml->load(self::$sitemap_folder.'/static-pages.xml');
    				$locDom = $xml->getElementsByTagName('loc');
    				foreach($locDom as $loc){
    					//$GLOBALS["StaticPageResult"] .= $loc->nodeValue.'&#13;&#10;';
    					$GLOBALS["StaticPageResult"] .= '<option>'.$loc->nodeValue.'</option>';
    				}
				}else{//ini_set("display_errors","1");
				    $xml = new OpXML();
				    $xml->load(self::$sitemap_folder.'/static-pages.xml');
				    $locDom = $xml->getElementsByTagName('loc');
				    foreach($locDom as $loc){
    					$GLOBALS["StaticPageResult"] .= '<option>'.$loc.'</option>';
    				}
				}
								
			}else{
				$GLOBALS["StaticPageResult"] = "<span style='color: red;'>You haven't generated the static-pages sitemap yet!</span>";
			}
			
			$indexSitemap = ISC_BASE_PATH.'/sitemap.xml';
			if(file_exists($indexSitemap)){
				$indexSitemap = str_replace(ISC_BASE_PATH, GetConfig('ShopPath'), $indexSitemap);
				$GLOBALS["IndexMapResult"] = "<a href='$indexSitemap'>$indexSitemap</a>";
			}else{
				$GLOBALS["IndexMapResult"] = "<span style='color: red;'>You haven't generated the index sitemap yet!</span>";
			}
			
			$uQuery = "SELECT * FROM [|PREFIX|]sitemap_setting limit 0,1";
            $uResult = $GLOBALS['ISC_CLASS_DB']->Query($uQuery);
            if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($uResult)){
            	$GLOBALS["SitemapId"] = $row['id'];
				$GLOBALS["MaxmumRecords"] = $row['maxrecord'];
				$GLOBALS["IndexRootName"] = $row['indexroot'];
				$GLOBALS["NormalRootName"] = $row['normalroot'];
				$GLOBALS["IndexUrlName"] = $row['indexurl'];
				$GLOBALS["NormalUrlName"] = $row['normalurl'];
				$GLOBALS["PopularCatList"] = $row['popularcatlist']; //leo 2011-11-17 new setting for popular categories list
				$GLOBALS["UrlChildOption"] = $this->_GetUrlChildOption(explode(',', $row['childnodes']));
				
				$this->xmlConfig['IndexRoot'] = $row['indexroot'];
				$this->xmlConfig['IndexUrl'] = $row['indexurl'];
				$this->xmlConfig['NormalRoot'] = $row['normalroot'];
				$this->xmlConfig['NormalUrl'] = $row['normalurl'];
				$this->xmlConfig['childNodes'] = explode(',', $row['childnodes']);
            }else{
            	$GLOBALS["SitemapId"] = $hasSetting;
				$GLOBALS["MaxmumRecords"] = "50,000";
				$GLOBALS["IndexRootName"] = "sitemapindex";
				$GLOBALS["NormalRootName"] = "urlset";
				$GLOBALS["IndexUrlName"] = "sitemap";
				$GLOBALS["NormalUrlName"] = "url";
				$GLOBALS["UrlChildOption"] = $this->_GetUrlChildOption(array('loc'));
            }
            
            $GLOBALS["PopularYearsStart"] = "1995";
			$GLOBALS["PopularYearsEnd"] = "2010";
			$GLOBALS["PopularCategories"] = $GLOBALS["PopularCatList"]; //"Nerf Bars, Fender Flares - Fender Trim, Tonneau Covers, Bed Mats, Air Intakes, Bull Bars & Grille Guards, Floor Protection, Exhaust Systems, Bug Shields - Bug Deflectors, Performance Chips";
			$GLOBALS["PopularMakes"] = "Chevrolet, GMC, Ford, Dodge, Toyota, Nissan, Honda, Jeep, Hyundai, Chrysler, Infiniti, Lexus";
			
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("sitemaps.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}
		
		private function _GetUrlChildOption($selected){
			
			if(!is_array($selected)){
				$selected = array();
			}
			
			$returnOpt = '';
			$options = array('loc', 'lastmod', 'changefreq', 'priority');
			foreach($options as $option){
				if(in_array($option, $selected))
					$returnOpt .= "<option value='$option' selected='selected'>$option</option>";
				else
					$returnOpt .= "<option value='$option'>$option</option>";
			}
			
			return $returnOpt;
		}
		
		public function FilterArray($word, $arr){
			$resultArr = array();
			foreach($arr as $val){
				if (is_numeric(strpos($val, $word)) && strpos($val, $word)==0)
				{
					$resultArr[] = $val;
				}
			}
			
			return $resultArr;
		}
		
		/**
		 * FormatLink
		 * Format the special Link for sitemap
		 *
		 */
		public function FormatLink($mmy_link, $propertys)
		{
			$NewLink = '';
			if ($GLOBALS['EnableSEOUrls'] == 1) {
				$params = '';
				foreach($propertys as $key=>$val)
				{
					$params .= '/'.$key.'/'.MakeURLSafe(strtolower($val));
				}
				$NewLink = sprintf("%s/%s%s", GetConfig('ShopPath'), MakeURLSafe(strtolower($mmy_link)), $params);
			} else {
				$params = '';
				foreach($propertys as $key=>$val)
				{
					$params .= '&'.$key.'='.MakeURLSafe(strtolower($val));
				}
				$NewLink = sprintf("%s/search.php?search_query=%s%s", GetConfig('ShopPath'), MakeURLSafe(strtolower($mmy_link)), $params);
			}
			return $NewLink;
		}
		
		/*
		 * MakeFileNameSafe
		 */
		public function MakeFileNameSafe($val){
			$val = preg_replace('/\s+/', '-', $val);
			$val = preg_replace('/-{2,}/', '-', $val);
			$val = str_replace("/", "{47}", $val);
			return $val;
		}
		
		/*
		 * GenerateFilename
		 */
		public function GenerateFilename($prefix, $curFilename){
			$newFilename = $curFilename;
			$match = array();
			$sitemapFolder = self::$sitemap_folder;
			$tmpArr = file_list($sitemapFolder, "/^(.*)$prefix(.*)\.xml$/i");
			foreach($tmpArr as $key=>$value){
				$filename = str_replace("$sitemapFolder/$prefix-", '', $value);
				$filename = str_replace('.xml', '', $filename);
				preg_match_all("/^$curFilename\d*$/", $filename, $m);
				if(!empty($m[0]))
					$match[] = $m[0][0];
			}
			sort($match);
			$matchLen = count($match);
			if($matchLen > 0)
				$newFilename = sprintf("$curFilename%s",str_replace($curFilename,'',$match[$matchLen-1])+1);
			
			return $newFilename;
		}

		/**
		* _BadSitemap
		* Redirect to the home page if the sitemap's details are invalid or it couldn't be loaded
		*
		* @param String $Message An optional error message to be displayed after the user has been redirected to the home page
		* @return Void
		*/
		private function _BadSitemap($Message='')
		{
			if($Message != '') {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage($Message, MSG_ERROR);
				exit;
			}
			else {
				ob_end_clean();
				header("Location: index.php?ToDo=");
				die();
			}
		}
	}

?>