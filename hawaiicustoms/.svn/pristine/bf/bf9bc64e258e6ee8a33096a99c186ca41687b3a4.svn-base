<?php
/**************************************
 * Page Name         : CompItem.php
 * Containing Folder : display
 * Created By        : Baskaran B
 * Created On        : 1st January, 2010
 * Modified By       : Baskaran B
 * Modified On       : 27th January, 2010
 * Description       : Display Complementary description.
 *********************************************************/
CLASS ISC_COMPITEM_PANEL extends PANEL
{
	public function SetPanelSettings()
	{
		$prodid = $GLOBALS['ProductId'];		
		# When there is no complementary item, the tab wount be shown.
		$make = '';$model = '';$year = '';
		if($GLOBALS['EnableSEOUrls'] == 0) {
			if(isset($_REQUEST['make']) && $_REQUEST['make'] != '')
			$make = MakeURLNormal($_REQUEST['make']);
			if(isset($_REQUEST['model']) && $_REQUEST['model'] != '')
			$model = MakeURLNormal($_REQUEST['model']);
			if(isset($_REQUEST['year']) && $_REQUEST['year'] != '')
			$year = $_REQUEST['year'];
		}  else {
			if(count($GLOBALS['PathInfo']) > 0) {
				foreach($GLOBALS['PathInfo'] as $key => $value) {
					if(eregi('make=',$value)) {
						$make = MakeURLNormal(substr($value,strpos($value,'=')+1));
					} else if(eregi('model=',$value)) {
						$model = MakeURLNormal(substr($value,strpos($value,'=')+1));
					} else if(eregi('year=',$value)) {
						$year = substr($value,strpos($value,'=')+1);
					}
				}
			}
		}

		$where = '';
		if($make != '') {
			$where .= "and (prodmake = '".$make."' or prodmake = 'NON-SPEC VEHICLE')";
		}
		if($model != '') {
			$where .= " and (prodmodel = '".$model."' or prodmodel = 'ALL')";
		}
		if($year != '') {
			$where .= " and (($year between prodstartyear and prodendyear) or (prodstartyear = 'ALL'and prodendyear = 'ALL'))";
		}

		$result = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT id,productid FROM [|PREFIX|]import_variations where productid = '".$prodid."' $where order by id");
		$impvariationid = array();
		while($improw = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
			$impvariationid[] = $improw['id'];
		}
		$impid = implode("','",$impvariationid);

		$impquery = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT complementaryitems FROM [|PREFIX|]application_data where variationid in('".$impid."') ");

		$impquery1 = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT complementaryitems FROM [|PREFIX|]application_data where variationid in('".$impid."') and  complementaryitems != '' ");

		$cntoriginal1 = '';
		if($row1 = $GLOBALS["ISC_CLASS_DB"]->Fetch($impquery1)) {
			$compitems1 = $row1['complementaryitems'].",";
			$comp1 = substr($compitems1,0,-1);

			$temp1 = $comp1;
			$temp1 = htmlspecialchars_decode($temp1);
			preg_match_all('/\[([^\]]+)\]/',$temp1,$matches1);
			$compexplode1 = $matches1[1];
			$cntproducts1 = count($compexplode1);

			/*$arraycnt1 = array_count_values($compexplode1);
			 asort($arraycnt1);
			 $compunique1 = array_keys($arraycnt1);
			 rsort($compunique1);
			 $cntproducts1 = count($compunique1);*/

			$originalarray1 = array();
			$tempArr = array();
			$tempArr1 = array();

			# Checking whether the SKU are valid and present in the db -- Baskaran
			for($i = 0; $i < $cntproducts1; $i++){
				$split1 = split(",",$compexplode1[$i]);
				$sku1 = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT productid, prodname, prodcode, proddescfeature, imagefile, brandname, catname FROM [|PREFIX|]brands b, [|PREFIX|]categories c, [|PREFIX|]products p LEFT JOIN [|PREFIX|]product_images i ON p.productid = i.imageprodid AND i.imageisthumb = '1' WHERE prodcode = '".$split1[0]."' AND p.prodbrandid = b.brandid AND p.prodcatids = c.categoryid AND p.prodvisible = '1'");
				if(($GLOBALS["ISC_CLASS_DB"]->countResult($sku1) == 1) and $split1[0] != '0') {
					if(in_array($split1[0],$tempArr))continue;
					$originalarray1[] = $split1[0].",".$split1[1].",".$split1[2];
					$tempArr[] = $split1[0];
				}
				else if(($GLOBALS["ISC_CLASS_DB"]->countResult($sku1) != 1) and $split1[0] == '0') {
					if(in_array($split1[0],$tempArr1))continue;
					$originalarray1[] = $split1[0].",".$split1[1].",".$split1[2];
					$tempArr1[] = $split1[0];
				}
			}
			$cntoriginal1 = count($originalarray1);
		}	
		if($cntoriginal1 == 0 or $cntoriginal1 == '') {
			//        if($GLOBALS["ISC_CLASS_DB"]->countResult($impquery) == 0) {
			$this->DontDisplay = true;
			return;
		}
		else {
			$compitems = '';
			if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($impquery)) {
				$compitems = $row['complementaryitems'].",";
				$comp = substr($compitems,0,-1);

				$temp = $comp;
				$temp = htmlspecialchars_decode($temp);
				preg_match_all('/\[([^\]]+)\]/',$temp,$matches);
				$compexplode = $matches[1];
				$cntproducts = count($compexplode);

				/*$arraycnt = array_count_values($compexplode);
				 asort($arraycnt);
				 $compunique = array_keys($arraycnt);
				 rsort($compunique);
				 $cntproducts = count($compunique);*/

				$originalarray = array();
				for($i = 0; $i < $cntproducts; $i++){
					$split = split(",",$compexplode[$i]);
					$sku = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT productid, prodname, prodcode, proddescfeature, imagefile, brandname, catname FROM [|PREFIX|]brands b, [|PREFIX|]categories c, [|PREFIX|]products p LEFT JOIN [|PREFIX|]product_images i ON p.productid = i.imageprodid AND i.imageisthumb = '1' WHERE prodcode = '".$split[0]."' AND p.prodbrandid = b.brandid AND p.prodcatids = c.categoryid AND p.prodvisible = '1'");
					if(($GLOBALS["ISC_CLASS_DB"]->countResult($sku) == 1) and $split[0] != '0') {
						$originalarray[] = $split[0].",".$split[1].",".$split[2];
					}
					else if(($GLOBALS["ISC_CLASS_DB"]->countResult($sku) != 1) and $split[0] == '0') {
						$originalarray[] = $split[0].",".$split[1].",".$split[2];
					}
				}
				$cntoriginal = count($originalarray);

				$comparray = array();
				if($row['complementaryitems'] != '') {
					for($i = 0; $i < 1; $i++){
						$split = split(",",$originalarray[$i]);
						$skucode = $split[0];						
						$comparray[$skucode] = $skucode;						
					}
					$sku = $comparray[$skucode];
					//                print_r($comparray);exit;
					if($sku != '') {
						$result = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT proddesc,prodwarranty,proddescfeature,prod_instruction,productid FROM [|PREFIX|]products where prodcode = '".$sku."' AND prodvisible = '1'");
						$desc = '';
						if($crow = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
							$compdesc = $crow['proddesc'];
							$productid = $crow['productid'];
							$feature = $crow['proddescfeature'];
							$proddesc = $crow['proddesc'];
							$warranty = $crow['prodwarranty'];
							$instruction = $crow['prod_instruction'];
							$images = $this->complementaryImageView($productid);
							if($images != '') {
								$desc .= "<h3>Product Images</h3>".$images;
							}
							if($feature != ''){
								$desc .= "<br><h3>Feature Points</h3>".$feature;
							}
							if($compdesc != '') {
								$desc .= "<h3>Complementary Product Description</h3>".$proddesc;
							}
							if($warranty != '') {
								$desc .= "<h3>Warranty Information</h3>".$warranty;
							}
							$chart = $this->applicationchart($productid);
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
					}
					else {
						$desc = "No Data found.";
					}
				}
				else {
					$desc = "No Data found.";
				}
			}
			$GLOBALS['CompDesc'] = $desc;
		}
	}
	function complementaryImageView($productid)   {   //http://www.smartchamp.com/store/installimage.php
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

			$OnClick = "showProductImageNew('".GetConfig('ShopPath')."/productimages/".$productid.".html'".", ".$productid.", ".$y.");";
			$AdditionalView = '<div style="float:left;width:70px;height:70px;padding-right:2px;padding-left:2px">
                                            <a onclick="'.$OnClick.'" href="#">'.$ThumbImage.'</a>
                                    </div>';
			//<a onclick="'.$OnClick.'" href="#">'.$ThumbImage.'</a>;
			$GLOBALS['VideoJavascript'] = "showProductVideoNew('".$this->ProdVideoLink($productid)."');";
			$GLOBALS['AudioJavascript'] = "showProductVideoNew('".$this->ProdAudioLink($productid)."');";

			// Is there more than one video? If not, hide the "See videos" link     Added by Simha
			if ($this->GetNumVideos($productid) == '0' && $this->GetNumAudios($productid) == '0' ) {
				$GLOBALS['VideosLink'] = "none";
			}
			else {
				if ($this->GetNumVideos($productid) > 0) {
					$var = "SeeVideos";
				}
				else    {
					$GLOBALS['SpecVideosLink'] = "none";
				}
				if ($this->GetNumAudios($productid) > 0) {
					$avar = "SeeAudios";
				}
				else    {
					$GLOBALS['SpecAudiosLink'] = "none";
				}
				@$GLOBALS['SeeCompVideo'] = sprintf(GetLang($var), $this->GetNumVideos($productid));
				@$GLOBALS['SeeCompAudio'] = sprintf(GetLang($avar), $this->GetNumAudios($productid));
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
}

?>