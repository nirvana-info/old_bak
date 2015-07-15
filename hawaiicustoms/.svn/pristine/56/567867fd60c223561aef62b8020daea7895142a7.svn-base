<?php

/**************************************
* Page Name         : complementarydesc.php
* Containing Folder : store
* Created By        : Baskaran B
* Created On        : 20th January, 2010
* Modified By       : N/A
* Modified On       : N/A
* Description       : Display selected Complementary description.
*********************************************************/

include(dirname(__FILE__) . "/init.php");

?>
<script>
    function togglechart(id) {
        var e = document.getElementById('t'+id);
        var f = document.getElementById('subs'+id);
           if(e.style.display == 'none')  {
              e.style.display = '';
              f.style.display = 'none';
           }
           else {
              e.style.display = 'none';
              f.style.display = '';
           }
    }
</script>
<?php
    function ComplementaryImageView($productid)   {   //http://www.smartchamp.com/store/installimage.php
        $_prodimages = array();            
        $query = sprintf("SELECT pi.imageid, pi.imageprodid, pi.imageprodhash, pi.imagefile, pi.imageisthumb, ti.imagefile thumbfile, ti.imageisthumb isThumb FROM [|PREFIX|]product_images pi LEFT JOIN [|PREFIX|]product_images ti ON ti.imagesort = pi.imagesort AND ti.imageprodid = pi.imageprodid AND ti.imageisthumb='3' WHERE pi.imageprodid='%d' AND pi.imageisthumb='0' order by pi.imagesort asc", $productid);
                                                                                                    
        $result = $GLOBALS['ISC_CLASS_DB']->Query($query);      
            
        while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
            $_prodimages[] = $row;
        }
        $GLOBALS['ViewGallery'] = '';
        $AdditionalView = '';
            
        for ($y=0; $y<count($_prodimages); $y++)   {
            
            $ThumbImage = $GLOBALS['ImageDirectory'].'/'.$_prodimages[$y]['thumbfile']; 
                
            if(file_exists(ISC_BASE_PATH."/".$ThumbImage) && $_prodimages[$y]['thumbfile'] != '')    {  //file_exists($ThumbImage) && 
                $ThumbImage = $GLOBALS['ShopPath'].'/'.$GLOBALS['ImageDirectory'].'/'.$_prodimages[$y]['thumbfile'];
                $ThumbImage = '<img id="Image'.$y.'" src="'.$ThumbImage.'" alt="">'; 
            }  
            else if(file_exists(ISC_BASE_PATH."/".$GLOBALS['ImageDirectory'].'/'.$_prodimages[$y]['imagefile']))   {
                $ThumbImage = ScaleImage($GLOBALS['ShopPath']."/".$GLOBALS['ImageDirectory'].'/'.$_prodimages[$y]['imagefile'], 70, 70, ISC_BASE_PATH."/".$GLOBALS['ImageDirectory'].'/'.$_prodimages[$y]['imagefile']); 
            }
            else    {
                $ThumbImage = GetConfig('ShopPath').'/templates/default/images/thumb_default.gif';
                $ThumbImage = '<img id="Image'.$y.'" src="'.$ThumbImage.'" alt="">';
            }
            
            //$OnClick = "showProductImageNew('".GetConfig('ShopPath')."/productimage.php', ".$productid.", ".$y.");";
            $OnClick = "showProductImageNew('".GetConfig('ShopPath')."/productimages/".$productid.".html'".", ".$productid.", ".$y.");";
            $AdditionalView = '<div style="float:left;width:70px;height:70px;padding-right:2px;padding-left:2px">
                                        <a onclick="'.$OnClick.'" href="#">'.$ThumbImage.'</a>
                                </div>';
		    //<a onclick="'.$OnClick.'" href="#">'.$ThumbImage.'</a>;
            $GLOBALS['VideoJavascript'] = "showProductVideoNew('".ProdVideoLink($productid)."');";            
            $GLOBALS['AudioJavascript'] = "showProductVideoNew('".ProdAudioLink($productid)."');";
            
            // Is there more than one video? If not, hide the "See videos" link     Added by Simha 
            if (GetNumVideos($productid) == 0 && GetNumAudios($productid) == 0 ) {
                $GLOBALS['VideosLink'] = "none";
            }
            else {                 
                if (GetNumVideos($productid) > 0) {
                    $var = "SeeVideos";
                }
                else    {
                    $GLOBALS['SpecVideosLink'] = "none"; 
                } 
                if (GetNumAudios($productid) > 0) {
                    $avar = "SeeAudios";
                }
                else    {
                    $GLOBALS['SpecAudiosLink'] = "none";
                } 
                @$GLOBALS['SeeCompVideo'] = sprintf(GetLang($var), GetNumVideos($productid));  
                @$GLOBALS['SeeCompAudio'] = sprintf(GetLang($avar), GetNumAudios($productid));   
            }   
            $GLOBALS['ViewGallery'] .= $AdditionalView;
        }
        //$output2 = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output2, $GLOBALS['SNIPPETS']);
        $CompImageView = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ImageView");
	    return $CompImageView;
}

    function ScaleImage($location, $maxw=NULL, $maxh=NULL, $File){ 
    $img = @getimagesize($File); 
        if($img){
            $w = $img[0];
            $h = $img[1];

            $dim = array('w','h');
            foreach($dim AS $val){
                $max = "max{$val}";
                if(${$val} > ${$max} && ${$max}){
                    $alt = ($val == 'w') ? 'h' : 'w';
                    $ratio = ${$alt} / ${$val};
                    ${$val} = ${$max};
                    ${$alt} = ${$val} * $ratio;
                }
            }
            return("<img src='{$location}' alt='image' width='{$w}' height='{$h}' />");
        }
    }
    
    function GetNumVideos($productid) {
        $query = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT COUNT(videoid) AS numvideos FROM [|PREFIX|]product_videos pv WHERE pv.videoprodid=$productid AND (pv.videofile LIKE '%.flv' || pv.systemvideofile LIKE '%.flv' || pv.videofile LIKE '%.swf' || pv.systemvideofile LIKE '%.swf') ");
        $video = 0;
        if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($query)) {
            $video = $row['numvideos'];
        }
        return $video;
    }
    
    function GetNumAudios($productid) {
        $query = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT COUNT(audioid) AS numaudios FROM [|PREFIX|]audio_clips ac WHERE ac.audioprodid=$productid AND (ac.audiofile LIKE '%.flv' || ac.systemaudiofile LIKE '%.flv' || ac.audiofile LIKE '%.swf' || ac.systemaudiofile LIKE '%.swf')"); 
        $audio = 0;
        if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($query)) {
            $audio = $row['numaudios'];
        }
        return $audio;
    }
    
    //Added by Simha     
    /**
     * Generate the link to a product image.
     *
     * @param string The name of the product to generate the link to.
     * @return string The generated link to the product.
     */
    function ProdVideoLink($prod)
    {
        if ($GLOBALS['EnableSEOUrls'] == 1) {      
            return sprintf("%s/%s/%s.html", GetConfig('ShopPath'), PRODUCTVIDEO_LINK_PART, MakeURLSafe($prod));
        } else {
            return sprintf("%s/productvideo.php?product_id=%s", GetConfig('ShopPath'), MakeURLSafe($prod));
        }                 
    }
    
    //Added by Simha     
    /**
     * Generate the link to a product audio.
     *
     * @param string The name of the product to generate the link to.
     * @return string The generated link to the product.
     */
    function ProdAudioLink($prod)
    {
        if ($GLOBALS['EnableSEOUrls'] == 1) {      
            return sprintf("%s/%s/%s.html", GetConfig('ShopPath'), PRODUCTAUDIO_LINK_PART, MakeURLSafe($prod));
        } else {
            return sprintf("%s/productaudio.php?product_id=%s", GetConfig('ShopPath'), MakeURLSafe($prod));
        }                 
    }
    
    function applicationchart($prodid) {
        $prodid = $prodid;
        /* Column names starting with 'VQ' have been taken */
//        $column = "SHOW COLUMNS FROM [|PREFIX|]import_variations WHERE field LIKE 'VQ%' OR field = 'cabsize_generalname' OR field = 'bedsize_generalname' ";
        $column = "SHOW COLUMNS FROM [|PREFIX|]import_variations WHERE field LIKE 'VQ%'";
        $rescol = $GLOBALS["ISC_CLASS_DB"]->Query($column); 
        $colname = '';
        $col = '';
        while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($rescol)) {
            $col[] = $row['Field'];
            $colname .= $row['Field'].",";
        }
        $c = substr($colname,0,-1);

        $colquery = "SELECT $c FROM [|PREFIX|]import_variations WHERE `productid` = $prodid ORDER BY prodmake, prodmodel";
        $colresult = $GLOBALS["ISC_CLASS_DB"]->Query($colquery);
        $colvalue = '';
            $colsep = '';        
        while($colrow = $GLOBALS['ISC_CLASS_DB']->Fetch($colresult)) {
            foreach($col as $key) {
                if(!empty($colrow[$key])){
            $colsep[$key] = $key;
                }
            }    
        } 
        $flag = '';
        $cntcol = count($colsep);
        $width = 100 / ($cntcol + 2); 
        /* $flag = 1 means that this product has some VQs and we have to display the chart according to this */
        if(!empty($colsep)) {
            $flag = 1;
        }
        else {
            $flag = 2;
        }
        if($flag == 1) {
            $cname = join(',',$colsep);            
            foreach($colsep as $k){
                $display = "select * from [|PREFIX|]qualifier_names where column_name = '".$k."' ";
                $displayresult = $GLOBALS["ISC_CLASS_DB"]->Query($display);
                $cntdisplay = $GLOBALS["ISC_CLASS_DB"]->CountResult($displayresult);
                if($cntdisplay > 0)
                {
                    $filter_var = array('vq','pq');
                    $dis = $GLOBALS['ISC_CLASS_DB']->Fetch($displayresult); 
                                  
                    if($dis["display_names"] != '' || !empty($dis["display_names"]) )
                    {
                        $displayname[] = $dis["display_names"];
                    }
                    else {
//                        $displayname[] = $k;
                        $displayname[] = ucfirst(str_ireplace($filter_var,"",$k)); 
                    }
                }
               else {
                    $displayname[] = ucfirst(str_ireplace($filter_var,"",$k)); 
                }
            }               
        }   
        if($flag == 1) {
            $impquery = "SELECT id, prodstartyear, prodendyear, prodmodel, prodmake,prodsubmodel, cabsize_generalname,bedsize_generalname, $cname FROM [|PREFIX|]import_variations WHERE `productid` = $prodid ORDER BY prodmake, prodmodel";
        }
        else {
            $impquery = "SELECT id, prodstartyear, prodendyear, prodmodel, prodmake,prodsubmodel
                        FROM [|PREFIX|]import_variations WHERE `productid` = $prodid ORDER BY prodmake, prodmodel";
        }
        $impresult = $GLOBALS["ISC_CLASS_DB"]->Query($impquery);     
        $cntrec = $GLOBALS["ISC_CLASS_DB"]->CountResult($impresult);
        
        $impdata = ''; 
        $i=0;   
        $m = array();                    
        while($makemodel = $GLOBALS['ISC_CLASS_DB']->Fetch($impresult)){
            $str = $makemodel['prodmake'].' - '.$makemodel['prodmodel'];
            if($makemodel['prodstartyear'] == $makemodel['prodendyear']) {
                $prodrange = $makemodel['prodstartyear'];
            }
            else {
                $prodrange = $makemodel['prodstartyear']." - ".$makemodel['prodendyear'];
            }
            $m[$str][$i][] = $prodrange;
            /* If there is no submodels we have display 'All Submodels' */
            if($makemodel['prodsubmodel'] != '' || !empty($makemodel['prodsubmodel'])) {
                $m[$str][$i][] = $makemodel['prodsubmodel'];            
            }
            else {
                $m[$str][$i][] = "All Submodels";
            }
            $comma = '';
            if($flag == 1) {
           /* echo "<pre>";
                print_r($colsep);*/
                foreach($colsep as $val){ 
                    
                 if($val == 'VQcabsize') {
                       if($makemodel['cabsize_generalname'] != ''){      
                            $comma = $makemodel['cabsize_generalname'];      
                       }
                       else {
                           $comma = $makemodel[$val];
                       }
                 }
                 else if($val == 'VQbedsize') {
                       if($makemodel['bedsize_generalname'] != ''){      
                            $comma = $makemodel['bedsize_generalname'];      
                       }
                       else {
                           $comma = $makemodel[$val];
                       }
                 }
                 else {
                    $comma = $makemodel[$val];       
                 }
                 
                $m[$str][$i][] = $comma;
                }
            }    
            
        $i++;
        }   
        $cnt = count($m);
        /* Creating the table to display the Application chart */
        $html = '<div style="overflow:auto;width:99%">';
        $html .= '<table border="0" cellpadding="1" cellspacing="1" width="100%" bgcolor="#808080">';  
        if($flag == 1) { 
            $html .= '<tr><td bgcolor="#cccccc" style="padding-left:3px" width='.$width.'% valign="top"><b>Year</b></td>';
            $html .= '<td bgcolor="#cccccc" style="padding-left:3px" width='.$width.'% valign="top"><b>Submodel</b></td>';  
            }
        else {
            $html .= '<tr><td bgcolor="#cccccc" style="padding-left:3px" width="50%" valign="top"><b>Year</b></td>';
            $html .= '<td bgcolor="#cccccc" style="padding-left:3px" width="50%" valign="top"><b>Submodel</b></td>';  
        }
        if($flag == 1) {
            for($l = 0;$l<count($displayname);$l++) {
                $html .= '<td bgcolor="#cccccc" style="padding-left:3px" width='.$width.'% valign="top"><b>'.wordwrap($displayname[$l]).'</b></td>';
            }
        }
        $html .= '</tr>';
        if($flag == 1) {
            $colspan = $cntcol + 2;
        } 
        else {
            $colspan = 2;
        }
        $j = 1;  
        $none = 'style = "display:none"';
        $block = 'style = display:';
        
        $seo_url = $_SERVER['REQUEST_URI']; 
        $querystring_url = $_SERVER['QUERY_STRING']; 
        if($GLOBALS['EnableSEOUrls'] == 1) {
            $delimeter = '/';
            $url = $seo_url;
        }
        else {
            $delimeter = '&';
            $url = $querystring_url;
        }
        if(eregi($delimeter.'make',$url))  { 
            $split_make = split($delimeter."make=",$url);
            $split_model = split($delimeter."model",$split_make[1]);
            $make_value = $split_model[0];
        }
        if(eregi($delimeter.'model',$url)) {
            $split_modelurl = split($delimeter."model=",$url);
            $model_value =$split_modelurl[1];
        }
                
        $get = '';
        if(isset($make_value)){
            $get = strtolower(urldecode($make_value));
        }
        else {
            $get = 0;
        }
        if(isset($model_value) != '') {
            $model = strtolower(urldecode($model_value));
        }
        else {
            $model = 0; 
        }
        foreach($m as $key => $first){
            $html .= '<tr><td colspan="'.$colspan.'" bgcolor="#cccccc"><a href="JavaScript://" onclick=togglechart('.$j.') style="padding-left:3px" >'.$key.'</a></td></tr>';
            /* Checking for the condition whether the result records exceeds 50 rows. And if exceeds means we have to show 'click title to see details' and the rows should be collapsed */ 
            $split = split(' - ',$key);
            $make = strtolower($split[0]);
            if(stristr($key,$get) == true or stristr($key,$model) == true){
            /* If records less than 50 means records are displayed else the records are hide leaving the searched make open */
                if($cntrec < 51) {   
                    $html .= '<tr id= "subs'.$j.'" style="display:none" bgcolor="#ffffff"><td style="padding-left:3px" colspan="'.$colspan.'">Click on the title to see details.</td></tr>';
                    $html .= '<tbody id = "t'.$j.'" style="display:">';
                    foreach($first as $second){ 
                        $html .= '<tr>';
                        foreach($second as $third){  
                            $html .='<td bgcolor="#ffffff" style="padding-left:3px" width='.$width.'%><small>'.wordwrap($third).'</small></td>';
                        }
                        $html .= '</tr>';
                    }
                    $html .= "</tbody>";
                }
                else {
                  
                     if(stristr($key,$get) == true and stristr($key,$model) == true) {
                        $displaytag1 = $none;
                        $displaytag2 = $block;
                    }
                    else if(stristr($key,$get) == true and !$model) {
                        $displaytag1 = $none;
                        $displaytag2 = $block;
                    }  
                    else if(stristr($key,$model) == true and !$get) {
                        $displaytag1 = $none;
                        $displaytag2 = $block;
                    }                                
                    else {                        
                        $displaytag1 = $block;
                        $displaytag2 = $none;
                    } 
                    $html .= '<tr id= "subs'.$j.'" '.$displaytag1.' bgcolor="#ffffff"><td style="padding-left:3px" colspan="'.$colspan.'">Click on the title to see details.</td></tr>';
                    $html .= "<tbody id = 't".$j."' ".$displaytag2.">";
                    foreach($first as $second){ 
                        $html .= '<tr>';
                        foreach($second as $third){  
                            $html .='<td bgcolor="#ffffff" style="padding-left:3px" width='.$width.'%><small>'.wordwrap($third).'</small></td>';
                        }
                        $html .= '</tr>';
                    }
                    $html .= "</tbody>";
                }
            }
            else {
                 if($cntrec < 51) {
                    $html .= '<tr id= "subs'.$j.'" style="display:none" bgcolor="#ffffff"><td style="padding-left:3px" colspan="'.$colspan.'">Click on the title to see details.</td></tr>';
                    $html .= '<tbody id = "t'.$j.'" style="display:">';
                    foreach($first as $second){ 
                        $html .= '<tr>';
                        foreach($second as $third){  
                            $html .='<td bgcolor="#ffffff" style="padding-left:3px" width='.$width.'%><small>'.wordwrap($third).'</small></td>';
                        }
                        $html .= '</tr>';
                    }
                    $html .= "</tbody>";
                }
                else {  
                    $html .= '<tr id= "subs'.$j.'" style="display:" bgcolor="#ffffff"><td style="padding-left:3px" colspan="'.$colspan.'">Click on the title to see details.</td></tr>';
                    $html .= "<tbody id = 't".$j."' style='display:none'>";
                    foreach($first as $second){ 
                        $html .= '<tr>';
                        foreach($second as $third){  
                            $html .='<td bgcolor="#ffffff" style="padding-left:3px" width='.$width.'%><small>'.wordwrap($third).'</small></td>';
                        }
                        $html .= '</tr>';
                    }
                    $html .= "</tbody>";
                }
            }
        $j++;
        }
        $html .= '</table></div>'; 
//        echo $html;    exit; #To check the table without style sheet
        /* $html has the chart structure and this variable is pass to the global variable */
        $ApplicationChart = '';
        if($cntrec > 0) {               
            $ApplicationChart = $html;
        }
        else {
            $ApplicationChart = "No Records Found.";
        }
        return $ApplicationChart;
}


	$sku = $_GET['prodsku'];
	$result = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT proddesc,prodwarranty,proddescfeature,prod_instruction,productid FROM [|PREFIX|]products p LEFT JOIN [|PREFIX|]product_images i ON p.productid = i.imageprodid AND i.imageisthumb = '1' where prodcode = '".$sku."' ");
	$desc = '';
	if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
//		$desc = $row['proddescfeature'].$row['proddesc'].$row['prodwarranty'].$row['prod_instruction'];
		$productid = $row['productid'];
		$feature = $row['proddescfeature'];
		$proddesc = $row['proddesc'];
		$warranty = $row['prodwarranty'];
		$instruction = $row['prod_instruction'];

		$images = ComplementaryImageView($productid);
		if($images != '') {
			$desc .= "<h3>Product Images</h3>".$images."<div style='height: 0pt; clear: both;'/>";
		}
		if($feature != ''){
			$desc .= "<br><h3>Feature Points</h3>".$feature;
		}
		if($proddesc != '') {
			$desc .= "<h3>Complementary Product Description</h3>".$proddesc;
		}
		if($warranty != '') {
			$desc .= "<h3>Warranty Information</h3>".$warranty;
		}
        $chart = applicationchart($productid);
        if($chart != '') {
            $desc .= "<h3>Application Guide</h3>".$chart;
        }
		if($instruction != '') {
			$desc .= "<h3>Instruction</h3>".$instruction;
		}
	}
	else {
		$desc = "No Data found.";
	}

	$compdesc = $desc;
	echo $compdesc;
?>