<?php

class ISC_YMMS{
    private $data;
    private $iscached;
    private $cache_file;
    private $cur_year;
    private $cur_make;
    private $cur_model;
    private $params;

    public function __construct(){
    	
    	$TempGet = $_GET;
        $this->cache_file = ISC_BASE_PATH . '/cache/ymms.data';
        
        $GLOBALS['ISC_CLASS_NEWSEARCH'] = GetClass('ISC_NEWSEARCH');
        $params = $GLOBALS['ISC_CLASS_NEWSEARCH']-> _searchterms;
        if(isset($params['year']))
        $this->cur_year = $params['year'];
         if(isset($params['make']))
        $this->cur_make = $params['make'];
         if(isset($params['model']))
        $this->cur_model = $params['model'];
        $this->params = $params;
        $_GET = $TempGet;
        if(file_exists($this->cache_file)){
            $ymms_data_cached = file_get_contents($this->cache_file);
            $this->data = unserialize($ymms_data_cached);
            $this->iscached = TRUE;
        }else{
            $this->data = "";
            $this->iscached = FALSE;
        }
    }
    
    //2011-12-30 alandy add parameter $where.
    private function getYmmsFromDB($where = ''){
        $sql = "SELECT distinct prodstartyear, prodendyear,prodmake, prodmodel, CONCAT(prodmake, '$$', prodmodel) as keystr FROM `[|PREFIX|]import_variations` WHERE prodmake <> 'NON-SPEC VEHICLE' ".$where;
        $res = $GLOBALS['ISC_CLASS_DB']->Query($sql);
        $raw_data = array();
        while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($res)) {
            $raw_data[$row['keystr']]['make'] = $row['prodmake'];
            $raw_data[$row['keystr']]['model'] = $row['prodmodel'];
            if(!isset($raw_data[$row['keystr']]['start']) or $row['prodstartyear'] < $raw_data[$row['keystr']]['start']){
                $raw_data[$row['keystr']]['start'] = $row['prodstartyear'];
            }
            if(!isset($raw_data[$row['keystr']]['end']) or $row['prodendyear'] > $raw_data[$row['keystr']]['end']){
                $raw_data[$row['keystr']]['end'] = $row['prodendyear'];
            }
        }
        return array_values($raw_data);
    }
    
    public function setYmmsData(){
        $data = $this->getYmmsFromDB();
        $this->data = $data;
        file_put_contents($this->cache_file, serialize($data));
        $this->iscached = TRUE;
    }
    
    public function getYmmsData(){
        if(!($this->iscached)){
            $this->setYmmsData();
            $GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('general', 'YMM font_end'),'YMM cache file not found, has been created.','YMM cache file not found, has been created.');
        }
        return $this->data;
    }
    
    public function getGeneratedLink(){
        $params = $this->params;
        $NewLink = '';
        if($GLOBALS['EnableSEOUrls'] == 1){
            $NewLink .= empty($params['category'])     ? '' : "/category/".MakeURLSafe(strtolower($params['category']));
            $NewLink .= empty($params['brand'])        ? '' : "/brand/".MakeURLSafe($params['brand']);
            $NewLink .= empty($params['series'])       ? '' : "/series/".MakeURLSafe($params['series']);
            $NewLink .= empty($params['searchtext'])   ? '' : "/searchtext/".MakeURLSafe(strtolower($params['searchtext']));
            $NewLink .= empty($params['search'])       ? '' : "/searchtext/".MakeURLSafe(strtolower($params['search']));
            $NewLink .= empty($params['clearance'])    ? '' : "/clearance";
			/* The below condition is added to add a-b-testing page Keyword instead of category/brand name */
			if( isset($_REQUEST['abtesting']) && $_REQUEST['abtesting'] != "" )
			{
				$_REQUEST['abtesting'] = MakeURLNormal($_REQUEST['abtesting']);
				$NewLink  = empty($params["search_query"]) ? $NewLink : "/a-b-testing/".MakeURLSafe(strtolower($_REQUEST['abtesting'])).$NewLink;
			}
			else
			{
				$NewLink  = empty($params["search_query"]) ? $NewLink : "/".MakeURLSafe(strtolower($params['search_query'])).$NewLink;
			}
        }else{
            $tmp = array();
            empty($params['category'])     ? '' : $tmp[] = "category=".MakeURLSafe(strtolower($params['category']));
            empty($params['brand'])        ? '' : $tmp[] = "brand=".MakeURLSafe($params['brand']);
            empty($params['series'])       ? '' : $tmp[] = "series=".MakeURLSafe($params['series']);
            empty($params['searchtext'])   ? '' : $tmp[] = "searchtext=".MakeURLSafe(strtolower($params['searchtext']));
            empty($params['search'])       ? '' : $tmp[] = "searchtext=".MakeURLSafe(strtolower($params['search']));
            empty($params['clearance'])    ? '' : $tmp[] = "clearance=1";
            empty($params['search_query']) ? '' : $tmp[] = "search_query=".MakeURLSafe(strtolower($params['search_query']));
            $NewLink = '/search.php' . (count($tmp) ? '?'.implode('&',$tmp) : '');
        }
        $NewLink  = $GLOBALS["ShopPath"].$NewLink;
        return $NewLink;
    }
    
    public function GetYmmsForMyVehicleArea(){
        $column = strtolower(MakeURLNormal(isset($_GET['column'])?$_GET['column']:""));
        $year = strtolower(MakeURLNormal(isset($_GET['year'])?$_GET['year']:""));
        $make = strtolower(MakeURLNormal(isset($_GET['make'])?$_GET['make']:""));
        $model = strtolower(MakeURLNormal(isset($_GET['model'])?$_GET['model']:""));
        $gen_link = $this->getGeneratedLink();
        
        $output = "";
        $listshow = array();
        $listhide = array();
        $counter = 0;
        $ymms_array = $this->getResultArray($column, $year, $make, $model);
        foreach($ymms_array as $item){
            $counter++;
            if($GLOBALS['EnableSEOUrls'] == 1){
                $ymm_link = preg_replace('/\/'.$column.'\/[^\/]*/', '', $gen_link);
                $prefix = preg_match('/\/$/',$ymm_link)?'':'/';
                $ymm_link .= $prefix.$column.'/'.MakeURLSafe(strtolower($item));
                if($column == 'model'){
                    $ymm_link = preg_replace('/\/(make|year)\/[^\/]*/', '', $ymm_link);
                    $ymm_link .= empty($this->cur_year)?'':'/year/'.$this->cur_year;
                    $ymm_link .= empty($this->cur_make)?'':'/make/'.$this->cur_make;
                }
            }else{
                $ymm_link = preg_replace('/&?'.$column.'=[^&=]*/', '', $gen_link);
                $prefix = preg_match('/\?/',$ymm_link)?'&':'?';
                $ymm_link .= $prefix.$column.'='.MakeURLSafe(strtolower($item));
                
                if($column == 'model'){
                    $ymm_link = preg_replace('/&?(year|make)=[^&=]*/', '', $ymm_link);
                    $ymm_link .= empty($this->cur_year)?'':'&year='.$this->cur_year;
                    $ymm_link .= empty($this->cur_make)?'':'&make='.$this->cur_make;
                }
            }
            
            if($counter<11){
                $listshow[] = "<li><a href='" . $ymm_link . "'>".$item."</a></li>";
            }else{
                $listhide[] = "<li><a href='" . $ymm_link . "'>".$item."</a></li>";
            }
        }
        if($counter == 0){
            $listshow[] = "<ul><li>No options available</li></ul>";
        }
        if($counter >= 11 ) {
            $GLOBALS['FilterID'] = $column;
            $GLOBALS['ExtraValues'] = implode(" ", $listhide);
            $output .= "<ul>".implode(" ", $listshow)."</ul>";
            $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideFilterMoreLink");
        }else {
            $output .= "<ul>".implode(" ", $listshow)."</ul>";
        }
        return $output;
    }
    
    public function GetYmmsForMiddleInPage(){
        $ymmtype = strtolower(MakeURLNormal(isset($_GET['ymmtype'])?$_GET['ymmtype']:""));
        $year = strtolower(MakeURLNormal(isset($_GET['year'])?$_GET['year']:""));
        $make = strtolower(MakeURLNormal(isset($_GET['make'])?$_GET['make']:""));
        $model = strtolower(MakeURLNormal(isset($_GET['model'])?$_GET['model']:""));
        $productId = isset($_GET['productId']) ? (int)$_GET['productId'] : 0;
        $isProductDetail = isset($_GET['isProductDetail']) ? (int)$_GET['isProductDetail'] : 0;
        $output = "";
        $array_str = $impvaritions = array();
        
        if ($productId) {
            $impvaritions = ISC_PRODUCT::GetImpVariationForYMM($productId, $ymmtype, $year, $make, $model);
        }
        
        foreach(array('make','model','year') as $column){
        	
            $array_str[$column] .= "<option value='' selected>--select {$column}--</option>";;
            $ymms_array = $this->getResultArray($column, $year, $make, $model);
            if($column == 'model' and empty($ymms_array)){
                $ymms_array = $this->getResultArray($column, "", $make, $model);
            }
            //alandy_2012-2-16 add.unique model.
            if($column =='model' && !empty($ymms_array)){
            	$ymms_array = array_unique(array_map('strtoupper', $ymms_array));
            }
            
            foreach($ymms_array as $value){
                $selected = "";
                if($$column == strtolower($value)){
                    $selected = "selected";
                }
                if (!empty($impvaritions) && !ISC_PRODUCT::CheckYMMUseVariation($value, $impvaritions, $column)) {
                    continue;
                }
                $array_str[$column] .= "<option value='".MakeURLSafe(strtolower($value))."' $selected>$value</option>";
            }
              // KATE CHANGE: 2/29/2012
         	//alandy_2012-2-20 add redirct option.
        	if($isProductDetail ==1){
        		$array_str[$column] .= "<option value=1>My ".ucwords($column)." Not Showing Here</option>";
        	}

        }
        
        if($ymmtype == "make"){
            $output = $array_str['model'] . '~' . $array_str['year'];
        }elseif($ymmtype == "year"){
            $output = $array_str['make'] . '~' . $array_str['model'];
        }elseif($ymmtype == "model"){
            $output = $array_str['year'];
        }else{
            
        }
    
        return $output;
    }
    
	public function GetYmmsForDialogPage(){
        $ymmtype = strtolower(MakeURLNormal(isset($_GET['ymmtype'])?$_GET['ymmtype']:""));
        $year = strtolower(MakeURLNormal(isset($_GET['year'])?$_GET['year']:""));
        $make = strtolower(MakeURLNormal(isset($_GET['make'])?$_GET['make']:""));
        $model = strtolower(MakeURLNormal(isset($_GET['model'])?$_GET['model']:""));
        $productId = isset($_GET['productId']) ? (int)$_GET['productId'] : 0;
        $isDialogPQVQ = isset($_GET['isDialogPQVQ']) ? (int)$_GET['isDialogPQVQ'] : 0;
        
        $output = "";
        $array_str = $impvaritions = array();
        
        if ($productId) {
            $impvaritions = ISC_PRODUCT::GetImpVariationForYMM($productId, $ymmtype, '', '', '');
        }
      
        foreach(array('make','model','year') as $column){
        	$tmp = '';
            $array_str[$column] = "<option value=''>--select {$column}--</option>";
            $ymms_array = $this->getResultArray($column, $year, $make, $model,$productId);
           
            if($column == 'model' and empty($ymms_array)){
                $ymms_array = $this->getResultArray($column, "", $make, $model,$productId);
                
            }
        	switch ($column){
        		case 'year':
        			$tmp = $year;
        			break;
        		case 'make':
        			$tmp = $make;
        			break;
        		default:
        			$tmp = $model;
        			break;
        	}
        	
            foreach($ymms_array as $value){
                $selected = "";
                
               
                if($tmp == strtolower($value)){
                    $selected = "selected";
                }
                
                if (empty($impvaritions) && !ISC_PRODUCT::CheckYMMUseVariation($value, $impvaritions, $column)) {
                    continue;
                }
                $array_str[$column] .= "<option value='".strtoupper($value)."' $selected>$value</option>";
            }
            //alandy_2012-2-20 add redirct option.
            if($isDialogPQVQ ==1){
            	$array_str[$column] .= "<option value=1>My ".ucwords($column)." Not Showing Here</option>";
            }
        }
       
        if($ymmtype == "make"){
            $output = $array_str['model'] . '~' . $array_str['year'];
        }elseif($ymmtype == "year"){
            $output = $array_str['make'] . '~' . $array_str['model'];
        }elseif($ymmtype == "model"){
            $output = $array_str['year'];
        }else{
            
        }
    
        return $output;
    }
    
    
    //alandy_2011-12-30 add parameter $fromCache.
    public function getResultArray($column, $year, $make, $model,$productid = Null){
        if(!$productid){
    	$ymms_data = $this->getYmmsData();
        }else{
        //mark.
         $ymms_data = $this->getYmmsFromDB(" and productid=$productid");
        }
        $result = array();
        if($column == 'year'){
            $startyear = 0;
            $endyear = 0;
            if($make != "" or $model != ""){
                foreach($ymms_data as $item){
                    if( ($make != "" or $model != "") and ($make == "" or strtolower($item['make']) == $make) and ($model == "" or strtolower($item['model']) == $model)){
                        if($startyear == 0 or (int)$item['start'] < $startyear)
                            $startyear = (int)$item['start'];
                        if($endyear == 0 or (int)$item['end'] > $endyear)
                            $endyear = (int)$item['end'];
                    }
                }
            }
            if($startyear == 0){
                foreach($ymms_data as $item){
                    if($startyear == 0 or (int)$item['start'] < $startyear)
                        $startyear = (int)$item['start'];
                    if($endyear == 0 or (int)$item['end'] > $endyear)
                        $endyear = (int)$item['end'];
                }
            }
            
            for($i=$endyear; $i >= $startyear; $i--){
                $result[] = $i;
            }
        }elseif($column == 'make'){
            $result = array('CHEVROLET', 'GMC', 'FORD', 'DODGE', 'TOYOTA', 'NISSAN', 'HONDA', 'JEEP', 'HYUNDAI','CHRYSLER', 'INFINITI', 'LEXUS');
            $othermakes = array();
            $dialog_result = array();
            foreach($ymms_data as $item){
            	//alandy_2011-10-13 modify.
            	$item['make'] = strtoupper($item['make']);
            	$dialog_result[] = strtoupper($item['make']);
                if(!in_array($item['make'], $result)){
                    $othermakes[$item['make']] = 1;
                }
            }
            $othermakes = array_keys($othermakes);
            sort($othermakes, SORT_STRING);
            sort($dialog_result, SORT_STRING);
            foreach($othermakes as $item){
                array_push($result, $item);
            }
            //alandy_2012-2-2 add.if productid,then return othermakes.
            if($productid){
            	
            	$result = array_unique($dialog_result);
            }
                       
        }else{
            if($make == ""){
                
            }else{
                foreach($ymms_data as $item){
                    if(strtolower($item['make']) == $make and ($year == "" or $year<=$item['end'] and $year>=$item['start'])){
                        $result[$item['model']] = 1;
                    }
                }
                $result = array_keys($result);
                sort($result, SORT_STRING);
            }
        }
        return $result;
    }
}













