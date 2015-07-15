<?php
  
/*$weight_link = "";  
if(isset($_REQUEST['weight']) && !empty($_REQUEST['weight']))
         $weight_link = "&weight=".$_REQUEST['weight'];  
if(isset($_REQUEST['height']) && !empty($_REQUEST['height']))
         $height_link = "&height=".$_REQUEST['height'];           */

         

$filter1 = <<<P1
    <div class="Block BrandList Moveable" id="SideProductFilters" style="">
P1;

$filter2 =  <<<P1
       <div class="BlockContent">
        <ul>
P1;

$filter3 = <<<P3
        </ul>
        </div>                
        </div>
P3;

$title = "<h2>Brand</h2>";      

$dyn_filter =  $filter1.$title.$filter2;

if(count($brand_id) > 0) {
   for($j=0;$j<count($brand_id);$j++)            
   {
       $brand_query = "select brandname from isc_brands where brandid = ".$brand_id[$j];
       $brand_result = $GLOBALS['ISC_CLASS_DB']->Query($brand_query);
       $brand_row = $GLOBALS['ISC_CLASS_DB']->Fetch($brand_result);
       
        $dyn_filter .= <<<P2
        <li><a href="search.php?search_query=$srch_qry$make_link$model_link$year_link&brand=$brand_id[$j]">$brand_row[brandname]</a></li>
P2;
   }
} else {
        $dyn_filter .= <<<P2
        <li>No Brand Found</li>
P2;
}
$dyn_filter .=  $filter3;

/*-------------------------------------------Bedsize-------------------------------------------*/

$title = "<h2>BedSize</h2>";
$qry_string = $_SERVER['QUERY_STRING']."&bedsize=";
$dyn_filter .=  $filter1.$title.$filter2; 
if(count($prod_bedsize) > 0) {

	$links = $srch_qry;
    if(isset($_REQUEST['make']) && !empty($make_link))
        $links .= $make_link;
    if(isset($_REQUEST['model']) && !empty($model_link))
        $links .= $model_link;
    if(isset($_REQUEST['year']) && !empty($year_link))
        $links .= $year_link;
	if(isset($_REQUEST['cover']) && !empty($_REQUEST['cover']))
		$links .= "&cover=".$_REQUEST['cover'];
	if(isset($_REQUEST['color']) && !empty($_REQUEST['color']))
		$links .= "&color=".$_REQUEST['color'];
    
   if(!isset($_REQUEST['bedsize']))
   {
	   //$links = "";
       for($j=0;$j<count($prod_bedsize);$j++)            
       {
           $count = $count_bedsize[$prod_bedsize[$j]]['count'];
		    
           
            $dyn_filter .= <<<P2
            <li><a href="search.php?search_query=$links&bedsize=$prod_bedsize[$j]">$prod_bedsize[$j]</a> ($count)</li>
P2;
       }
   } else {
            $count = $count_bedsize[$_REQUEST['bedsize']]['count'];
            /*$links = $srch_qry.$make_link.$year_link;
            if(isset($_REQUEST['model']) && !empty($_REQUEST['model']))
                $links .= $model_link;
			if(isset($_REQUEST['cover']) && !empty($_REQUEST['cover']))
				$links .= "&cover=".$_REQUEST['cover'];
            if(isset($_REQUEST['color']) && !empty($_REQUEST['color']))
				$links .= "&color=".$_REQUEST['color'];*/
           
            
            $dyn_filter .= <<<P2
            <li>$_REQUEST[bedsize]</li>
            <li><a href="search.php?search_query=$links"><b>Redefine Search...</b></a></li>
P2;
   }

} else {
        $dyn_filter .= <<<P2
        <li>No Bedsize Found</li>
P2;
}
$dyn_filter .=  $filter3; 

/*----------------------------------------- Cover -----------------------------------------*/

$title = "<h2>Cover</h2>";
$dyn_filter .=  $filter1.$title.$filter2; 
if(count($prod_cover) > 0) {

   $links = $srch_qry;
   if(isset($_REQUEST['make']) && !empty($make_link))
        $links .= $make_link;
   if(isset($_REQUEST['model']) && !empty($model_link))
        $links .= $model_link;
   if(isset($_REQUEST['year']) && !empty($year_link))
        $links .= $year_link;
   if(isset($_REQUEST['bedsize']) && !empty($_REQUEST['bedsize']))
		$links .= "&bedsize=".$_REQUEST['bedsize'];
   if(isset($_REQUEST['color']) && !empty($_REQUEST['color']))
		$links .= "&color=".$_REQUEST['color'];
    
   if(!isset($_REQUEST['cover']))
   {
	   //$links = "";
       for($j=0;$j<count($prod_cover);$j++)            
       {
           $count = $count_cover[$prod_cover[$j]]['count'];
		   
           $dyn_filter .= <<<P2
            <li><a href="search.php?search_query=$links&cover=$prod_cover[$j]">$prod_cover[$j]</a> ($count)</li>
P2;
       }
   } else {
            $count = $count_cover[$_REQUEST['cover']]['count'];
            /*$links = $srch_qry.$make_link.$year_link;
            if(isset($_REQUEST['model']) && !empty($_REQUEST['model']))
                $links .= $model_link;
			if(isset($_REQUEST['bedsize']) && !empty($_REQUEST['bedsize']))
				$links .= "&bedsize=".$_REQUEST['bedsize'];
           if(isset($_REQUEST['color']) && !empty($_REQUEST['color']))
				$links .= "&color=".$_REQUEST['color'];*/
			            
            $dyn_filter .= <<<P2
            <li>$_REQUEST[cover]</li>
            <li><a href="search.php?search_query=$links"><b>Redefine Search...</b></a></li>
P2;
   }

} else {
        $dyn_filter .= <<<P2
        <li>No Cover Found</li>
P2;
}
$dyn_filter .=  $filter3; 

/*----------------------------------------- Color -----------------------------------------*/

$title = "<h2>Color</h2>";
$dyn_filter .=  $filter1.$title.$filter2; 
if(count($prod_color) > 0) {

   $links = $srch_qry;
   if(isset($_REQUEST['make']) && !empty($make_link))
        $links .= $make_link;
   if(isset($_REQUEST['model']) && !empty($model_link))
        $links .= $model_link;
   if(isset($_REQUEST['year']) && !empty($year_link))
        $links .= $year_link;
	if(isset($_REQUEST['cover']) && !empty($_REQUEST['cover']))
		$links .= "&cover=".$_REQUEST['cover'];
	if(isset($_REQUEST['bedsize']) && !empty($_REQUEST['bedsize']))
		$links .= "&bedsize=".$_REQUEST['bedsize'];
    
   if(!isset($_REQUEST['color']))
   {   
	   //$links = "";
       for($j=0;$j<count($prod_color);$j++)            
       {
           $count = $count_color[$prod_color[$j]]['count'];
		   
           
           $dyn_filter .= <<<P2
            <li><a href="search.php?search_query=$links&color=$prod_color[$j]">$prod_color[$j]</a> ($count)</li>
P2;
       }
   } else {
            $count = $count_color[$_REQUEST['color']]['count'];
            /*$links = $srch_qry.$make_link.$year_link;
            if(isset($_REQUEST['model']) && !empty($_REQUEST['model']))
                $links .= $model_link;
			if(isset($_REQUEST['cover']) && !empty($_REQUEST['cover']))
				$links .= "&cover=".$_REQUEST['cover'];
			if(isset($_REQUEST['bedsize']) && !empty($_REQUEST['bedsize']))
				$links .= "&bedsize=".$_REQUEST['bedsize'];*/
			
            
            $dyn_filter .= <<<P2
            <li>$_REQUEST[color]</li>
            <li><a href="search.php?search_query=$links"><b>Redefine Search...</b></a></li>
P2;
   }

} else {
        $dyn_filter .= <<<P2
        <li>No Color Found</li>
P2;
}
$dyn_filter .=  $filter3; 

//$title = "Height";

/*
$dyn_filter .=  $filter1;
for($j=0;$j<count($brand_id);$j++)            
{
 $dyn_filter .= <<<P2
        <li><a href="search.php?search_query=$srch_qry$make_link$model_link$year_link&height=$prod_price[$j]">$prod_price[$j]</a></li>
P2;
}
$dyn_filter .=  $filter2;
*/


?>