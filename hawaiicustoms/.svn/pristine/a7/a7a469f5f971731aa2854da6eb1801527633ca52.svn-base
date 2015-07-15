<?php
	/**
	* ISC_ADMIN_KEYWORDS
	* Generate sitemaps
	*
	* @author Wirror Yin
	* @copyright NI
	* @date	11th Oct 2010
	*/
	class ISC_ADMIN_KEYWORDS
	{
		
		/**
		* Constructor
		*
		* @return Void
		*/
		public function __construct()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('keywords');
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
				case "getkeywords": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Keywords)) {
						$this->GetKeywords();
					} else {
						exit;
					}
					break;
				}
				case "editkeyword": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Keywords)) {
						$this->EditKeyword();
					} else {
						exit;
					}
					break;
				}
				case "savekeyword": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Keywords)) {
						$this->SaveKeyword();
					} else {
						exit;
					}
					break;
				}
				case "viewkeywords": {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Keywords)) {
						$this->ManageKeywords();
					} else {
						exit;
					}
					break;
				}
				default: {
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Keywords)) {
						$GLOBALS["BreadcrumEntries"] = array(GetLang('Home') => "index.php", GetLang('Keywords') => "index.php?ToDo=prodKeywords");
	
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->ManageKeywords();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
			}
		}
		
		/**
		 *Save Keyword
		 *@return void
		 */
		public function SaveKeyword(){
		    $type = $_POST['type'];
		    $sid = $_POST['sid'];
		    $keyword = $_POST['keyword'];
		    $oldword = $_POST['oldword'];		    
		    switch($type){
		        case 'category':
		            $this->SaveCategoryKeyword($sid, $oldword, $keyword);			    
		            break;
		        case 'subcategory':
		            $this->SaveSubcategoryKeyword($sid, $oldword, $keyword);			    
		            break;
		        case 'brand':
		            $this->SaveBrandKeyword($sid, $oldword, $keyword);
		            break;
		        case 'series':
		            $this->SaveSeriesKeyword($sid, $oldword, $keyword);
		            break;
		        default:
		            break;
		    }
		    //zcs=>[Bug #8552]clear old category/brand cache file
		    $GLOBALS['ISC_CategoryBrandCache'] = GetClass('ISC_CACHECATEGORYBRANDS');
		    $GLOBALS['ISC_CategoryBrandCache']->ClearCategoryBrandData();
		    $GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('general', 'Category_Brand back_end'),'Category Brand cache file is updated.','Category Brand  cache file is updated.');
		    //<=zcs
		}
		
		public function UpdateQuery($sql){
		    if($GLOBALS['ISC_CLASS_DB']->Query($sql)) 
		        return true;
		    else
		        return false;
		}
		
		/**
		 *Save Category Keyword
		 *@return void
		 */
		public function SaveCategoryKeyword($id, $oldword, $keyword){
		    //$query = "UPDATE [|PREFIX|]categories SET cataltkeyword=replace(cataltkeyword, '$oldword', '$keyword') WHERE categoryid=$id";
		    //$this->UpdateQuery($query);
		    $GLOBALS['ISC_CLASS_DB']->UpdateQuery('categories', array('cataltkeyword' => $keyword), "categoryid='".(int)$id."'");
		    echo 'Save category keyword success!';
		}
		
		/**
		 *Save Category Keyword
		 *@return void
		 */
		public function SaveSubcategoryKeyword($id, $oldword, $keyword){
		    //$query = "UPDATE [|PREFIX|]categories SET cataltkeyword=replace(cataltkeyword, '$oldword', '$keyword') WHERE categoryid=$id";
		    //$this->UpdateQuery($query);
		    $GLOBALS['ISC_CLASS_DB']->UpdateQuery('categories', array('cataltkeyword' => $keyword), "categoryid='".(int)$id."'");
		    echo 'Save subcategory keyword success!';
		}
		
		/**
		 *Save Category Keyword
		 *@return void
		 */
		public function SaveBrandKeyword($id, $oldword, $keyword){
		    //$query = "UPDATE [|PREFIX|]brands SET brandaltkeyword=replace(brandaltkeyword, '$oldword', '$keyword') WHERE brandid=$id";
		    //$this->UpdateQuery($query);
		    $GLOBALS['ISC_CLASS_DB']->UpdateQuery('brands', array('brandaltkeyword' => $keyword), "brandid='".(int)$id."'");
		    echo 'Save brand keyword success!';
		}
		
		/**
		 *Save Category Keyword
		 *@return void
		 */
		public function SaveSeriesKeyword($id, $oldword, $keyword){
		    //$query = "UPDATE [|PREFIX|]brand_series SET seriesaltkeyword=replace(seriesaltkeyword, '$oldword', '$keyword') WHERE seriesid=$id";
		    //$this->UpdateQuery($query);
		    $GLOBALS['ISC_CLASS_DB']->UpdateQuery('brand_series', array('seriesaltkeyword' => $keyword), "seriesid='".(int)$id."'");
		    echo 'Save series keyword success!';
		}
		
		/**
		 *Edit Keyword
		 *@return void
		 */
		public function EditKeyword(){
		    $type = $_GET['type'];
		    $sid = $_GET['sid'];
		    $keyword = $_GET['keyword'];
		    $name = urldecode($_GET['name']);
		    
		   $GLOBALS['AltMessage'] = sprintf(GetLang('AltMessage'), '"'.$keyword.'"', $type."[$name]");
		   $GLOBALS['Keyword'] = urldecode($keyword);
		   $GLOBALS['KeywordType'] = $type;
		   $GLOBALS['Sid'] = $sid;
		    
		    $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("keyword.edit");
			echo $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
		}
		
		/**
		 *Get Keywords
		 *@return array
		 */
		public function GetKeywords(){
		    $keywords = array();
		    
		    $catKeywords = $this->GetKeywordsByCategory();
		    $subcatKeywords = $this->GetKeywordsBySubcategory();
		    $brandKeywords = $this->GetKeywordsByBrand();
		    $seriesKeywords = $this->GetKeywordsBySeries();
		
		   $keywords = array_merge($keywords, $this->FormatKeywords($catKeywords, 'category'));
		   $keywords = array_merge($keywords, $this->FormatKeywords($subcatKeywords, 'subcategory'));
		   $keywords = array_merge($keywords, $this->FormatKeywords($brandKeywords, 'brand'));
		   $keywords = array_merge($keywords, $this->FormatKeywords($seriesKeywords, 'series'));
			     
		   asort($keywords);
		
		   $this->GroupArray($keywords);
		
		   return $keywords;
		}
		    
		public function GroupArray(&$arr, $reserveKey=true) {
			$tmpArr = $arr;
			$duplicatedWords = array();
			$countArr = array();
			foreach($arr as $key=>$val){
			    $countArr[$val][] = $key;
			}
			arsort($countArr);
			foreach($countArr as $word=>$valArr){
			    /*foreach($valArr as $val){
				if($reserveKey)
				    $arr[$val] = $tmpArr[$val];
				else
				    $arr[] = $tmpArr[$val];
			    }*/
			    
			    if(count($valArr)>1 && !in_array($word, $duplicatedWords)){
				$duplicatedWords[] = $word;
			    }
			}			
			
			$GLOBALS["DuplicatedWords"] = implode('_', $duplicatedWords);			
		}
		
		/**
		 *Get Format Keywords
		 *@return array
		 */		
		public function FormatKeywords($arr, $type){
		    $keywords = array();
		    //$icount = 0;
		    foreach($arr as $key=>$val){
			$subKeywords = explode(',', $val);			
			foreach($subKeywords as $word){
			    $keywords["{$type}_$key"] = trim($word);
			    //$icount++;
			}
			
		    }
		    //var_dump($keywords); echo " shirley ";	
		    return $keywords;
		}
		//Shirley 2011/3/2 add a variable $icount to split a wordlist
		public function FormatWords($arr, $type){
		    $keywords = array();
		    $icount = 0;
		    foreach($arr as $key=>$val){
			$subKeywords = explode(',', $val);			
			foreach($subKeywords as $word){
			    $keywords["{$type}_$key"+"_"+$icount] = trim($word);
			    $icount++;
			}
			
		    }
		    //var_dump($keywords); echo " shirley ";	
		    return $keywords;
		}		
		
		/**
		 *Get Keywords By Category
		 *@return array
		 */
		public function GetKeywordsByCategory(){
		    $keywords = array();
		    $query= "
        		    SELECT categoryid, cataltkeyword
        		    FROM [|PREFIX|]categories
        		    WHERE catvisible=1
        		    AND trim(ifnull(cataltkeyword,'')) <> ''
        		    AND catparentid=0";
		    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		    while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$keywords[$row['categoryid']] = $row['cataltkeyword']; 
		    }
			
		    return $keywords;
		}
		
		/**
		 *Get Keywords By Subcategory
		 *@return array
		 */
		public function GetKeywordsBySubcategory($parentId=0){
		    $keywords = array();
		    $queryFmt= "
        		    	SELECT categoryid, cataltkeyword
        			FROM [|PREFIX|]categories
        			WHERE catvisible=1
        			AND trim(ifnull(cataltkeyword,'')) <> ''
        			%s
			";
			if($parentId > 0){
				$query = sprintf($queryFmt, " AND catparentid=$parentId");
			}else{
				$query = sprintf($queryFmt, " AND catparentid>0");
			}
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$keywords[$row['categoryid']] = $row['cataltkeyword'];     
			}
			
			return $keywords;
		}
		
		/** 
		 *Get Keywords By Brand
		 *@return array
		 */
		public function GetKeywordsByBrand(){
		    $keywords = array();
		    $query= "
        		    	SELECT brandid, brandaltkeyword
        			FROM [|PREFIX|]brands
        			WHERE trim(ifnull(brandaltkeyword,'')) <> ''";
		    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		    while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$keywords[$row['brandid']] = $row['brandaltkeyword'];     
		    }
			
		    return $keywords;
		}
		
		/**
		 *Get Keywords By Series
		 *@return array
		 */
		public function GetKeywordsBySeries($brandId=0){
		    $keywords = array();
		    $queryFmt= "
        		    	SELECT seriesid, seriesaltkeyword
        			FROM [|PREFIX|]brand_series
        			WHERE trim(ifnull(seriesaltkeyword,'')) <> ''
        			%s";
		    if($brandid > 0){
		        $query = sprintf($queryFmt, " AND brandid=$brandid");
		    }else{
		        $query = sprintf($queryFmt, "");
		    }
		    
		    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		    while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$keywords[$row['seriesid']] = $row['seriesaltkeyword'];     
		    }
			
		    return $keywords;
		}
		
		/**
		 * GetSortBrandCat
		 * @return Array
		 *Shirley modified 2011/3/4
		 */
		function GetSortBrandCat($arr, $srcArr){
			$sortArrbegin = array();
			$sortArrend = array();
			$duplicatedwordarr=explode('_',$GLOBALS["DuplicatedWords"]);
			foreach($srcArr as $key=>$items){
				$itemsarr=explode(',',$items[keyword]);
				$keywords_dupl_ibool=false;
				foreach($itemsarr as $v){
					if(in_array(trim($v),$duplicatedwordarr))
						$keywords_dupl_ibool=true;
					else
					{
						foreach($items as $subkey=>$item)
						{
							$subitemarr=explode(',',$item[keyword]);
							foreach($subitemarr as $subv)
							{
								if(in_array(trim($subv),$duplicatedwordarr))
									$keywords_dupl_ibool=true;
							}
						}
					}
					
				}
				if($keywords_dupl_ibool)
					$sortArrbegin[$key]=$items;
				else
				        $sortArrend[$key]=$items;
			}
			foreach($sortArrend as $keyend=>$valueend)
			{
				$sortArrbegin[$keyend]=$valueend;
			}
			/*foreach($arr as $k=>$v){
				foreach($srcArr as $key=>$items){
					if(!in_array($key, $sortArr) && $key==$k)
						$sortArr[] = $key;
					foreach($items as $subkey=>$item){	
						if(!in_array($key, $sortArr) && $k==$subkey)
							$sortArr[] = $key;
					}
				}
			}*/
			return $sortArrbegin;
		}
		
		/**
		 * GetAllKeywords
		 * @return String
		 */
		/*public function GetAllKeywords(){
			$allKeywords = '';
			$keyArr = array();
			$dataArr = array();
			$query= "
			    SELECT * FROM
			    (SELECT cp.catname AS pname, cp.categoryid AS pid, cp.cataltkeyword AS pkeyword, c.catname AS sname, c.categoryid AS sid, c.cataltkeyword AS skeyword, 'category' AS ptype, 'subcategory' AS stype
        		    FROM [|PREFIX|]categories cp
			    LEFT JOIN [|PREFIX|]categories c ON (c.catparentid=cp.categoryid AND c.catvisible=1)
			    WHERE cp.catparentid=0
			    AND cp.catvisible=1
			    AND trim(ifnull(c.catname,'')) <> '') AS rc1
			    UNION ALL
			    SELECT * FROM
        		    (SELECT b.brandname AS pname, b.brandid AS pid, b.brandaltkeyword AS pkeyword, bs.seriesname AS sname, bs.seriesid AS sid, bs.seriesaltkeyword AS skeyword, 'brand' AS ptype, 'series' AS stype
        		    FROM [|PREFIX|]brands b
			    LEFT JOIN [|PREFIX|]brand_series bs ON (bs.brandid=b.brandid)
			    WHERE trim(ifnull(bs.seriesname,'')) <> '') AS rc2
			    ORDER BY skeyword DESC";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			    if(isset($keyArr[$row['ptype'].'_'.$row['pid']])){
				$keyArr[$row['ptype'].'_'.$row['pid']][$row['stype'].'_'.$row['sid']] =
					array(
						'id' => $row['sid'],
						'type' => $row['stype'],
						'name' =>  $row['sname'],
						'keyword' => $row['skeyword']
					);
					
				if(!empty($row['skeyword']))
					$dataArr[] = array('type' => $row['stype'],'id' => $row['sid'], 'keyword'=>$row['skeyword']);
			    }else{
				$keyArr[$row['ptype'].'_'.$row['pid']] = array(
					'id' => $row['pid'],
					'name' =>$row['pname'],
					'keyword' => $row['pkeyword'],
					'type' => $row['ptype'],
					$row['stype'].'_'.$row['sid'] => array(
							'id' => $row['sid'],
							'type' => $row['stype'],
							'name' =>  $row['sname'],
							'keyword' => $row['skeyword']
						       )
				);
				
				if(!empty($row['pkeyword']))
					$dataArr[] = array('type' => $row['ptype'],'id' => $row['pid'], 'keyword'=>$row['pkeyword']);
				if(!empty($row['skeyword']))
					$dataArr[] = array('type' => $row['stype'],'id' => $row['sid'], 'keyword'=>$row['skeyword']);
			    }
			    
			}
			$keywords = array();
			foreach($dataArr as $data){
				$keywords = array_merge($keywords, $this->FormatWords(array($data['id']=>$data['keyword']), $data['type']));
			}
			//print_r($keywords);
			$this->GroupArray($keywords);			
			$sortkeys = $this->GetSortBrandCat($keywords, $keyArr);

			foreach($sortkeys as $key){
				$items = $keyArr[$key];
				$GLOBALS['CatBrandType'] = $items['type'];
				$GLOBALS['CatBrandId'] = $items['id'];
				$GLOBALS['CatBrandName'] = $items['name'];
				$GLOBALS['CatBrandKeywords'] = strlen($items['keyword'])==0 ? GetLang('NoKeywordDefined') : $items['keyword'];
				
				$GLOBALS['SubList'] = '';
				foreach($items as $item){
					if(is_array($item)){
						$GLOBALS['ItemType'] = $item['type'];
						$GLOBALS['ItemName'] = $item['name'];
						$GLOBALS['ItemId'] = $item['id'];
						$GLOBALS['ItemKeywords'] = strlen($item['keyword'])==0 ? GetLang('NoKeywordDefined') : $item['keyword'];
						$GLOBALS['SubList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('KeywordItem');
					}
				}
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("keyword.manage.grid");
				$allKeywords .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
			foreach($sortkeys as $key){
				$items = $key;
				$GLOBALS['CatBrandType'] = $items['type'];
				$GLOBALS['CatBrandId'] = $items['id'];
				$GLOBALS['CatBrandName'] = $items['name'];
				$GLOBALS['CatBrandKeywords'] = strlen($items['keyword'])==0 ? GetLang('NoKeywordDefined') : $items['keyword'];
				
				$GLOBALS['SubList'] = '';
				foreach($items as $item){
					if(is_array($item)){
						$GLOBALS['ItemType'] = $item['type'];
						$GLOBALS['ItemName'] = $item['name'];
						$GLOBALS['ItemId'] = $item['id'];
						$GLOBALS['ItemKeywords'] = strlen($item['keyword'])==0 ? GetLang('NoKeywordDefined') : $item['keyword'];
						$GLOBALS['SubList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('KeywordItem');
					}
				}
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("keyword.manage.grid");
				$allKeywords .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}		
			
			return $allKeywords;
		}*/
		
		public function GetAllKeywords(){
			$allCategoryKeywords = '';
			$allBrandKeywords = '';
			$keyArr = array();
			//$dataArr = array();
			$this->GetTempResultSqlString();
			//$GLOBALS['ISC_CLASS_DB']->Query($this->GetTempResultSqlString());
			//var_dump($this->GetTempResultSqlString());
			//var_dump($GLOBALS['ISC_CLASS_DB']->GetErrorMsg());
			$query= "
				select t1.type, t1.pid, t1.id, group_concat(t1.keyword) keyword, t1.is_dup, 
				case when c.catname is not null then c.catname
			             when b.brandname is not null then b.brandname
				end pname, 
				case when c2.catname is not null then c2.catname
				     when s.seriesname is not null and t1.pid!=t1.id then s.seriesname
				     when b.brandname is not null and t1.pid=t1.id then b.brandname
				end name, 
				group_concat(t1.keyword_prefix,t1.keyword,keyword_suffix) keywords
				from tmp_result t1 
				left join tmp_top t2 on t1.pid = t2.pid and t1.type = t2.type
				left join isc_categories c on c.categoryid = t1.pid and t1.type = 'Category'
				left join isc_categories c2 on c2.categoryid = t1.id and t1.type = 'Category'
				left join isc_brands b on b.brandid = t1.pid and t1.type = 'Brand'
				left join isc_brand_series s on s.seriesid = t1.id and t1.type = 'Brand'
				group by t1.type, pname, name, t1.pid, t1.id
				order by t1.type desc, t2.is_top desc, pname, case when pname = name then pname else t1.is_dup end desc, name
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				//var_dump($row);
				if($row['pid']==$row['id'])
				{
					$keyArr[$row['type'].'_'.$row['pid']] =
					array(
						'id' => $row['id'],
						'type' => strtolower($row['type']),
						'name' =>  $row['name'],
						'keyword' => $row['keywords'],
						'keywordedit' => $row['keyword'],
						'is_dup' => $row['is_dup'] == 1 ? true : false
					);
					
				}
				else
				{
					$subtype = $row['type'] == 'Category' ? 'Subcategory' : 'Series';
					$keyArr[$row['type'].'_'.$row['pid']][$subtype.'_'.$row['id']] =
					array(
						'id' => $row['id'],
						'type' => strtolower($subtype),
						'name' =>  $row['name'],
						'keyword' => $row['keywords'],
						'keywordedit' => $row['keyword'],
						'is_dup' => $row['is_dup'] == 1 ? true : false
					);
				}
			}
			
			foreach($keyArr as $key){
				$items = $key;
				$GLOBALS['CatBrandType'] = $items['type'];
				$GLOBALS['CatBrandId'] = $items['id'];
				$GLOBALS['CatBrandName'] = $items['name'];
				$GLOBALS['CatBrandKeywords'] = strlen($items['keyword'])==0 ? GetLang('NoKeywordDefined') : $items['keyword'];
				$GLOBALS['CatBrandKeywordsEdit'] = $items['keywordedit'];
				$hasDup = $items['is_dup'];
				
				$GLOBALS['SubList'] = '';
				foreach($items as $item){
					if(is_array($item)){
						$GLOBALS['ItemType'] = $item['type'];
						$GLOBALS['ItemName'] = $item['name'];
						$GLOBALS['ItemId'] = $item['id'];
						$GLOBALS['ItemKeywords'] = strlen($item['keyword'])==0 ? GetLang('NoKeywordDefined') : $item['keyword'];
						$GLOBALS['ItemKeywordsEdit'] = $item['keywordedit'];
						$GLOBALS['SubList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('KeywordItem');
						
						if(!$hasDup){$hasDup = $item['is_dup'];}
					}
				}
				
				$GLOBALS['NoDupClass'] = $hasDup ? '' : 'no_dup_class';
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("keyword.manage.grid");
				//var_dump($items['type']);
				if($items['type']=='category'){
					$allCategoryKeywords .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				}else{
					$allBrandKeywords .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				}
			}
			
			$GLOBALS["AllCategoryKeywords"]=$allCategoryKeywords;
			$GLOBALS["AllBrandKeywords"]=$allBrandKeywords;
			//return $allKeywords;
		}		

		/**
		* ManageKeywords
		* 
		* @return Void
		*/
		public function ManageKeywords($MsgDesc = "", $MsgStatus = "")
		{
			if($MsgDesc != "") {
				$GLOBALS["Message"] = MessageBox($MsgDesc, $MsgStatus);
			}
			
			//$GLOBALS["AllKeywords"] = $this->GetAllKeywords();
			$this->GetAllKeywords();
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']==1){
			    echo $GLOBALS["AllKeywords"];
			    exit;
			}
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']==0){
				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("keyword.manage.edit");
				$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
				exit;
			}
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("keyword.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}
		
		public function GetTempResultSqlString()
		{
			$sqlArray=array("
drop table if exists tmp_result;","			
 create table if not exists tmp_result (type varchar(24), pid int, id int, is_dup tinyint, keyword varchar(255), keyword_prefix varchar(255) null, keyword_suffix varchar(255) null);","
 create table if not exists tmp_top (type varchar(24), pid int, is_top tinyint);","
 create temporary table tmp_keyword_prefix (keyword varchar(255), prefix varchar(255));","

 truncate table tmp_result;","
 truncate table tmp_top;","

 insert into tmp_result (type, pid, id, is_dup, keyword)
 select t.type, t.pid, t.id, 0 as is_dup,
       trim(
       substring(altkeyword, 
       locate(',', concat(',',altkeyword,','), sequence.id), 
       locate(',', concat(',',altkeyword,','), sequence.id+1) - locate(',', concat(',',altkeyword,','), 

 sequence.id) - 1
       )) AS result
 from  sequence, (
      select 'Category' as type,
             case when isc_categories.catparentid = 0 then isc_categories.categoryid
             else
                  isc_categories.catparentid
             end as pid, categoryid as id, cataltkeyword as altkeyword
      from isc_categories
      where trim(cataltkeyword) <> ''
      union all
      select 'Brand' as type,
             brandid as pid, brandid as id, brandaltkeyword as altkeyword
      from isc_brands
      where trim(brandaltkeyword) <> ''
      union all
      select 'Brand' as type,
             brandid as pid, seriesid as id, seriesaltkeyword as altkeyword
      from isc_brand_series
      where trim(seriesaltkeyword) <> ''
 ) t
 WHERE sequence.id < length(altkeyword)
 and   sequence.id = locate(',', concat(',',altkeyword,','), sequence.id)
 order by t.type, t.pid, t.id;","

 update tmp_result t1 inner join
 (select keyword, count(0) as cnt from tmp_result group by BINARY keyword having cnt > 1) t2
 on BINARY t1.keyword = t2.keyword
 set t1.is_dup = 1;","

 insert into tmp_result (type, pid, id, is_dup, keyword)
 select 'Category' as type,
        case when isc_categories.catparentid = 0 then isc_categories.categoryid
        else
             isc_categories.catparentid
        end as pid, categoryid as id, 0 as is_dup, cataltkeyword as altkeyword
 from isc_categories
 where categoryid not in (select id from tmp_result where type = 'Category');","

 insert into tmp_result (type, pid, id, is_dup, keyword)
 select 'Brand' as type, brandid as pid, brandid as id, 0 as is_dup, brandaltkeyword as altkeyword
 from isc_brands t1
 where not exists (select pid from tmp_result t2 where t1.brandid = t2.pid and t1.brandid = t2.id and type = 'Brand');","

 insert into tmp_result (type, pid, id, is_dup, keyword)
 select 'Brand' as type, brandid as pid, seriesid as id, 0 as is_dup, seriesaltkeyword as altkeyword
 from isc_brand_series t1
 where not exists (select pid, id from tmp_result t2 where t1.brandid = t2.pid and t1.seriesid = t2.id and t2.type = 'Brand');","


 insert into tmp_top (type, pid, is_top)
 select distinct type, pid, is_dup from tmp_result where is_dup = 1;","

 insert into tmp_keyword_prefix (keyword, prefix)
 select distinct keyword, '' from tmp_result where is_dup = 1;","

 update tmp_keyword_prefix 
 set prefix = concat('<span style=\'font-weight:bold;color:#',
       right(concat('00',conv(rand(2) * 1000 mod 128, 10, 16)),2),
       right(concat('00',conv(rand(5) * 1000 mod 128, 10, 16)),2),
       right(concat('00',conv(rand(7) * 1000 mod 128, 10, 16)),2),
       '\'>'
       );","

 update tmp_result t1 inner join tmp_keyword_prefix t2 on BINARY t1.keyword = t2.keyword
 set keyword_prefix = prefix,
      keyword_suffix = '</span>';","

 update tmp_result set keyword_prefix = '' where keyword_prefix is null;","
 update tmp_result set keyword_suffix = '' where keyword_suffix is null;","

 update tmp_result t inner join 
(select type, pid, id from (select type, pid, id from tmp_result where is_dup = 1) a) b
set is_dup = 1 where b.type = t.type and t.pid = b.pid and t.id = b.id;
			");
			
			foreach($sqlArray as $sql)
			{
				$GLOBALS['ISC_CLASS_DB']->Query($sql);
				//var_dump($sql."\n");
				//var_dump($GLOBALS['ISC_CLASS_DB']->GetErrorMsg()."\n");
			}	
		}
		
	}