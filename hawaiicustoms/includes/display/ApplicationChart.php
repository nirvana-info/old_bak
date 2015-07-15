<?php
CLASS ISC_APPLICATIONCHART_PANEL extends PANEL
{
	public function SetPanelSettings()
	{
		$GLOBALS['ProductDesc'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetDesc();
		if(!trim($GLOBALS['ProductDesc'])) {
			$GLOBALS['HidePanels'][] = 'ApplicationChart';   
		}
        $prodid = $GLOBALS['ProductId'];
        /* Column names starting with 'VQ' have been taken */
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
            $impquery = "SELECT id, prodstartyear, prodendyear, prodmodel, prodmake,prodsubmodel, cabsize_generalname,      bedsize_generalname, $cname FROM [|PREFIX|]import_variations WHERE `productid` = $prodid ORDER BY prodmake, prodmodel";
        }
        else {
            $impquery = "SELECT id, prodstartyear, prodendyear, prodmodel, prodmake,prodsubmodel
                        FROM [|PREFIX|]import_variations WHERE `productid` = $prodid and prodmake != '' ORDER BY prodmake, prodmodel";
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
                foreach($colsep as $val){ 
                 //2010-11-15 Ronnie modify, VQcabsize,VQbedsize not is Special
                 /*if($val == 'VQcabsize') {
                       if($makemodel['cabsize_generalname'] != ''){      
                            $comma = $makemodel['cabsize_generalname'];      
                       }
                       else {
                           $comma = $makemodel[$val];
                       }
                 	 $comma = $makemodel[$val];
                 }
                 else if($val == 'VQbedsize') {
                       if($makemodel['bedsize_generalname'] != ''){      
                            $comma = $makemodel['bedsize_generalname'];      
                       }
                       else {
                           $comma = $makemodel[$val];
                       }
                 }
                 else {*/
                    $comma = $makemodel[$val];       
                 //}
                 
                $m[$str][$i][] = $comma;
                }
            }    
            
        $i++;
        }   
        $cnt = count($m);
        /* Creating the table to display the Application chart */ 
        $html = '<div style="overflow:auto;width:99%">';                           
        $html .= '<table border="0" cellpadding="1" cellspacing="1" width="100%" bgcolor="#808080" style="overflow:auto;">';  
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
            $html .= '<tr><td colspan="'.$colspan.'" bgcolor="#cccccc"><a href="JavaScript://" onclick=toggle('.$j.') style="padding-left:3px" >'.$key.'</a></td></tr>';
            /* Checking for the condition whether the result records exceeds 50 rows. And if exceeds means we have to show 'click title to see details' and the rows should be collapsed */ 
            $split = split(' - ',$key);
            $make = strtolower($split[0]);
            if(stristr($key,$get) == true or stristr($key,$model) == true){
            /* If records less than 50 means records are displayed else the records are hide leaving the searched make open */
                if($cntrec < 51) {   
                    $html .= '<tr id= "sub'.$j.'" style="display:none" bgcolor="#ffffff"><td style="padding-left:3px" colspan="'.$colspan.'">Click on the title to see details.</td></tr>';
                    $html .= '<tbody id = "'.$j.'" style="display:">';
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
                    $html .= '<tr id= "sub'.$j.'" '.$displaytag1.' bgcolor="#ffffff"><td style="padding-left:3px" colspan="'.$colspan.'">Click on the title to see details.</td></tr>';
                    $html .= "<tbody id = '".$j."' ".$displaytag2.">";
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
                    $html .= '<tr id= "sub'.$j.'" style="display:none" bgcolor="#ffffff"><td style="padding-left:3px" colspan="'.$colspan.'">Click on the title to see details.</td></tr>';
                    $html .= '<tbody id = "'.$j.'" style="display:">';
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
                    $html .= '<tr id= "sub'.$j.'" style="display:" bgcolor="#ffffff"><td style="padding-left:3px" colspan="'.$colspan.'">Click on the title to see details.</td></tr>';
                    $html .= "<tbody id = '".$j."' style='display:none'>";
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
        if($cntrec > 0) {               
            $GLOBALS['ApplicationChart'] = $html;
        }
        else {
            $GLOBALS['ApplicationChart'] = "No Records Found.";
        }
	}
}
 
?>