<?php
	
	define('NO_SESSION', true);
	ini_set("memory_limit","-1");

	require_once(dirname(__FILE__).'/init.php');
	require_once(dirname(__FILE__).'/class.opxml.php');
	
	function file_list($dir,$pattern="")
	{
		$arr=array();
		$dir_handle=opendir($dir);
		if($dir_handle)
		{
			while(($file=readdir($dir_handle))!==false)
			{
				if($file==='.' || $file==='..')
				{
					continue;
				}
				$tmp=realpath($dir.'/'.$file);
				if(is_dir($tmp))
				{
					$retArr=file_list($tmp,$pattern);
					if(!empty($retArr))
					{
						$arr[]=$retArr;
					}
				}
				else
				{
					if($pattern==="" || preg_match($pattern,$tmp))
					{
						$arr[]=$tmp;
					}
				}
			}
			closedir($dir_handle);
		}
		
		return $arr;
	}
	
	function modifyFileLine($filename, $linenum, $lineText)
	{
		$fp = new SplFileObject($filename);
		$fp->seek($linenum);
		$line = $fp->current();
		$fp->fseek($linenum, SEEK_CUR);
		$fp->fwrite($lineText);
	}
	
	function UsedMemory()
	{
		$memUsed = number_format(memory_get_usage()/(1024*1024), 2);
		//memory_get_peak_usage()
		//php.ini memory_limit
		return "[Memory Used: $memUsed M]";
	}
	
	function multiexplode ($delimiters,$string) {
	    $ary = explode($delimiters[0],$string);
	    array_shift($delimiters);
	    if($delimiters != NULL) {
	        foreach($ary as $key => $val) {
	             $ary[$key] = multiexplode($delimiters, $val);
	        }
	    }
	    return  $ary;
	}
	
	class SitemapGenerator
	{
		
		public static $website;
		public static $sitemap_folder = "sitemaps"; 
		public static $sitemap_index = "sitemap"; 
		
		private $Changefreq = "weekly";//"always"‚ "hourly"‚ "daily"‚ "weekly"‚ "monthly"‚ "yearly" and "never"
		private $Priority = 0.5;
		private $Last_modification;
		
		private $sitemapIndex = array();
		
		function __construct()
		{
			self::$website = GetConfig('ShopPath');
			$this->Last_modification = date("Y-m-d");//date("Y-m-d\TH:i:s").substr(date("O"),0,3).":".substr(date("O"),3);

			if(!is_dir(self::$sitemap_folder)){
				mkdir(self::$sitemap_folder);
				chmod(self::$sitemap_folder, 0777); 
			}
			
			$filename = self::$sitemap_index.'.xml';
			if(!file_exists($filename)){
				file_put_contents($filename, '');
				/*
				$fp=fopen($filename, "w+");
				if(!is_writable($filename) ){
				}
				fclose($fp);*/
				chmod($filename, 0777);     
			}
		}
		
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
			
			echo 'Executing query:<br/><font color=red>'.$query.'</font><br/>';
			
			$result = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($query, 0, $specCondition));
		
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$resultSub = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($query, $row['categoryid'], '1=1'));
				$childCount = $GLOBALS['ISC_CLASS_DB']->CountResult($resultSub);
				$isRootCate = true;
				if($childCount <= 1)
					$isRootCate = false;
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
	
		public function GetCategoryBrandURLs()
		{
			$categoryURLs = $this->GetCategoryURLS();
			$brandURLs = $this->GetBrandURLS();
			$categoryBrandURLs = array_merge(array_keys($categoryURLs), array_keys($brandURLs));

			return $categoryBrandURLs;
		}
		
		public function GetMixCategoryBrandURLs()
		{
			$mixURLs = array();
			
			$query = "
				SELECT categoryid, catname 
				FROM [|PREFIX|]categories 
				WHERE catname in (%s)
				ORDER BY catname ASC
			";
			
			echo 'Executing query:<br/><font color=red>'.$query.'</font><br/>';
			$popularCats = "'Nerf Bars', 'Fender Flares', 'Tonneau Covers', 'Bed Mats', 'Air Intakes', 'Bull Bars', 'Floor Protection', 'Exhaust Systems', 'Bug Shields', 'Performance Chips'";
			
			$result = $GLOBALS['ISC_CLASS_DB']->Query(sprintf($query, $popularCats));
		
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
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
			if(count(categoryURLs)>0)
				$mixURLs = array_merge(array_keys($categoryURLs), $mixURLs);
			sort($mixURLs);
			
			return $mixURLs;
		}
		
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
			
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))
			{
				$prodQuery = sprintf("
						SELECT prodname, brandname, prodcode
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
					while ($rowSub = $GLOBALS['ISC_CLASS_DB']->Fetch($resultLimit)) {
						if($firstRow){
						  $SKU = $rowSub['prodcode'];
						  $firstRow = false;
						}
						$url = ProdLink($rowSub['prodname']);
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
			$filenames = array();
			
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
					
					$filename = $filePrefix.'-'.preg_replace('/-{2,}/', '-' ,preg_replace('/\s+/', '-' ,MakeURLNormal($suffixName)));
					$nameLabel = 1;
				    
					while(in_array($filename, $filenames)){
						$filename = $filePrefix.'-'.$suffixName.'-'.$nameLabel;
						$nameLabel++;
					}
					array_push($filenames, $filename);
					
					if($filename == $curfilename){
						$filename .= '-1';
					}
					
					$curfilename = $filename;
						
					$this->SaveAsXML(array($filename => $countArr));
				}
			}
			
			return true;
		}
		
		public function SaveAsXML($filelist, $isRoot = false)
		{
			$adjustPath = $isRoot?'':self::$sitemap_folder.'/';
			$rootTag =  $isRoot?'sitemapindex':'urlset';
			$urlTag =  $isRoot?'sitemap':'url';
			$locTag = 'loc';
			
			foreach($filelist as $filename=>$datas){
				echo "$filename.xml is generating...<br/>";
				/*
				$xmlDoc = new DOMDocument("1.0","UTF-8");
				$xmlDoc->preserveWhiteSpace = false;   
				$xmlDoc->formatOutput = true;               
		
				$urlset = $xmlDoc->createElement("urlset");    
				$urlset = $xmlDoc->appendChild($urlset); 
				*/
				if(count($datas) > 100000)
				{	
					$tmpDatas = array_chunk($datas, 10000);
					foreach($tmpDatas as $tmps)
					{
						$xmlDoc = new OpXML();
						$urlset = $xmlDoc->addRoot($rootTag,array('xmlns'=>'http://www.sitemaps.org/schemas/sitemap/0.9'));
						foreach($tmps as $data){
							$url = $xmlDoc->addChild($urlset, $urlTag);
							$xmlDoc->addChild($url, $locTag, htmlspecialchars($data, ENT_COMPAT, "UTF-8"));
							//$xmlDoc->addChild($url, 'lastmod', $this->Last_modification);
						}
						//unset($xmlDoc);
						$saveResult = $xmlDoc->save("$adjustPath$filename.xml", "a");
					}
					
				}else{
					$xmlDoc = new OpXML();
					$urlset = $xmlDoc->addRoot($rootTag,array('xmlns'=>'http://www.sitemaps.org/schemas/sitemap/0.9'));
					foreach($datas as $data){
						
						$url = $xmlDoc->addChild($urlset, $urlTag);
						//$xmlDoc->addChild($url, $locTag, $data);
						$xmlDoc->addChild($url, $locTag, htmlspecialchars($data, ENT_QUOTES, "UTF-8"));
						//$xmlDoc->addChild($url, 'lastmod', $this->Last_modification);	
						//$xmlDoc->addChild($url, 'changefreq', $this->Changefreq);		
						//$xmlDoc->addChild($url, 'priority', $this->Priority);
	
						/*
						//create nodes
						$url = $xmlDoc->createElement("url");
						$url = $urlset->appendChild($url);
						
						//create attribute to a node
						//$name_value = $xmlDoc->createAttribute("value");
						//$name_value  =$url->appendChild($name_value);
						
						$loc = $xmlDoc->createElement("loc");
						$loc = $url->appendChild($loc);
						$loc->appendChild($xmlDoc->createTextNode($data));
						
						$lastmod = $xmlDoc->createElement("lastmod");
						$lastmod = $url->appendChild($lastmod);
						$lastmod->appendChild($xmlDoc->createTextNode($this->Last_modification));
						
						$changefreq = $xmlDoc->createElement("changefreq");
						$changefreq = $url->appendChild($changefreq);
						$changefreq->appendChild($xmlDoc->createTextNode($this->Changefreq));
						
						$priority = $xmlDoc->createElement("priority");
						$priority = $url->appendChild($priority);
						$priority->appendChild($xmlDoc->createTextNode($this->Priority));
						*/
					}
					$saveResult = $xmlDoc->save("$adjustPath$filename.xml");//$xmlDoc->save("$adjustPath$filename.xml");
				}
				if($saveResult)
				{
					echo UsedMemory()."<br/>";
					$filepath = htmlspecialchars((self::$website)."/$adjustPath$filename.xml");
					array_push($this->sitemapIndex, (self::$website)."/$adjustPath$filename.xml");
					echo 'Save '.htmlspecialchars($filename).".xml Successful.<br/>Total: $saveResult Bytes.<br/>";
					echo "<a href='$filepath'>$filepath</a><br/><br/>";
				}
				else
				{
					return false;
				}
			}
			
			return true;
		}
		
		public function GenerateAction($filelist, $isRoot = false)
		{
			try
			{
				if($this->SaveAsXML($filelist, $isRoot))
				{
					echo "Generate Success!<br/><br/>";
				}
				else
				{
					echo 'Generate Failed!<br/><br/>';
				}
			}
			catch (Exception $ex)
			{
				
			}
		}
		
		public function GetSitemapIndexArray(){
			$indexArr = array();
			if(count($this->sitemapIndex)==0)
			{
				$tmpArr = file_list(self::$sitemap_folder, "/\.xml$/i");
				foreach($tmpArr as $key=>$value){
					  $url = self::$website.str_replace(dirname(__FILE__), '', $value);
					  //$url = htmlspecialchars($url, ENT_NOQUOTES, "UTF-8");
				      $indexArr[$key] = $url;
				}
				//list($tmpArr)= self::$website.'/'.self::$sitemap_folder.'/'.each($tmpArr);
			}
			else
			{
				$indexArr = $this->sitemapIndex;
			}
			
			sort($indexArr);
			return $indexArr;	
		}
		
		public function UpdateSiteMapIndex()
		{
			$loadResult = DOMDocument::load(self::$sitemap_index.'.xml');
			if($loadResult) 
			{
				echo 'Update '.self::$sitemap_index.' success';
			}
			else
			{
				echo 'Load '.self::$sitemap_index.' failed';
			}
		}
		
		public function RunMultiThread(){
			declare(ticks=1);
			$bWaitFlag = FALSE;
			$intNum = 10;
			$pids = array();
			echo ("Startn");
			for($i = 0; $i < $intNum; $i++) {
				$pids[$i] = pcntl_fork();
				if(!$pids[$i]) {
					$str="";
					sleep(5+$i);
					for ($j=0;$j<$i;$j++) {$str.="*";}
					echo "$i -> " . time() . " $str n";
					exit();
				}
			}
			if ($bWaitFlag)
			{
				for($i = 0; $i < $intNum; $i++) {
					pcntl_waitpid($pids[$i], $status, WUNTRACED);
					echo "wait $i -> " . time() . "n";
				}
			}
			echo ("Endn"); 	
		}
	}

	$sitemapGenerator = new SitemapGenerator();
	$currentCount = 0;
	$pageCateBrand = 0;
	$pageYMM = 0;
	$hasmore = false;
	$filename = "";
	
	if(isset($_POST['actionType']) && $_POST['actionType']!=''){
		switch($_POST['actionType']){
			case 'CategoryBrand':
				$categoryBrandURLs = $sitemapGenerator->GetCategoryBrandURLs();
				$sitemapGenerator->GenerateAction(array('category-brand'=>$categoryBrandURLs));
				break;
			case 'MixCategoryBrand':
				$mixCategoryBrandURLs = $sitemapGenerator->GetMixCategoryBrandURLs();
				$sitemapGenerator->GenerateAction(array('mix-category-brand'=>$mixCategoryBrandURLs));
				break;
			case 'ProductBrand':
				$productBrandURLs = $sitemapGenerator->GetProductBrandURLs();
				$chunkArr = array_chunk($productBrandURLs, 3, true);
				$sitemapGenerator->GenerateAction($chunkArr[$_POST['currentCount']]);
				$currentCount = $_POST['currentCount'] + 1;
				$remainCount = count($chunkArr)-$currentCount;
				echo "Remaining: $remainCount<br/>";
				break;
			case 'DynamicPage':
				$pageCateBrand = $_POST['pageCount'];
				$pageYMM = $_POST['pageCount2'];
				$filename = $_POST['dynamic_filename'];
				$sitemapGenerator->GenerateDynamicPagesURLs($filename, $pageCateBrand, $pageYMM, $hasmore);
				break;
			default:
				$sitemapGenerator->GenerateAction(array(SitemapGenerator::$sitemap_index=>$sitemapGenerator->GetSitemapIndexArray()), true);
				break;
		}

	}

?>
<form id="subForm" action="sitemap_generator.php" method="post">
	<input id="actionType" type="hidden" name="actionType"/>
	<input type="hidden" name="currentCount" value="<?php echo $currentCount; ?>"/>
	<input type="hidden" name="pageCount" value="<?php echo $pageCateBrand; ?>"/>
	<input type="hidden" name="pageCount2" value="<?php echo $pageYMM; ?>"/>
	<input type="hidden" name="dynamic_filename" value="<?php echo $filename; ?>"/>
	<input type="button" onclick="postForm(this)" name="CategoryBrand" value="CategoryBrand"/>
	<input type="button" onclick="postForm(this)" name="MixCategoryBrand" value="MixCategoryBrand"/>
	<input type="button" onclick="postForm(this)" name="ProductBrand" value="<?php echo $remainCount==0?'ProductBrand':'ProductBrand>>'; ?>"/>
	<input type="button" onclick="postForm(this)" name="DynamicPage" value="<?php echo !$hasmore?'DynamicPage':'DynamicPage>>'; ?>"/>
	<input type="button" onclick="postForm(this)" name="IndexMap" value="IndexMap"/>
</form>
<script>
	function postForm(obj){
		if(obj.type='button'){
				document.getElementById('actionType').value = obj.name;
				document.getElementById('subForm').submit();
		}	
	};	
</script>
