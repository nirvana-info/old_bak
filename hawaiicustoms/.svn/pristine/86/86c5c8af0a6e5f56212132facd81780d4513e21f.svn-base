<?php

	CLASS ISC_PRODUCTINSTRUCTION_PANEL extends PANEL
	{
		function SetPanelSettings()
		{
			if(!isset($GLOBALS['ISC_CLASS_PRODUCT'])) {
				$this->DontDisplay = true;
				return;
			}

			
			

			$instruction = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductInstruction();
			if(strpos($instruction, "<") === false) {
				$instruction = nl2br($instruction);
			}
			$instruction_file = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductInsFile();
			if ($instruction_file != "")
			{

$pos1 = stripos($instruction_file, "http://");
if ($pos1 === false) {
     $instruction_file =  "instruction_file/".$instruction_file;
} 

			$GLOBALS['InstructionFile'] = '<a href="'.$instruction_file.'" target="_blank">Read Instuction File</a>';
			$GLOBALS['Adobe'] = 'Download Adobe Reader<a href="http://get.adobe.com/uk/reader/" target="_blank"><IMG SRC="/images/adobe_reader.jpg"  ALT="Download Adobe Reader">
</a>';
			}
			
			

			

		 $GLOBALS['ProductInstruction'] = $instruction;
			
if ( ($instruction == "" and $instruction_file == "") && ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumInsImages() == 0) && ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumInsVideos() == 0))
			{
				$this->DontDisplay = true;

			}

		    //$GLOBALS['InstallImagePopupJS'] = "showProductImageNew('".GetConfig('ShopPath')."/installimage.php', ".$GLOBALS['ProductId'].");";             
			//$GLOBALS['InsVideoPopupJavascript'] = "showProductVideoNew('".GetConfig('ShopPath')."/installvideo.php', ".$GLOBALS['ProductId'].");";          
            $GLOBALS['InstallImagePopupJS']     = "showProductImageNew('".$this->InsImageLink($GLOBALS['ProductId'])."', 0, 0);";             
            $GLOBALS['InsVideoPopupJavascript'] = "showProductVideoNew('".$this->InsVideoLink($GLOBALS['ProductId'])."');";          
            
            // Is there more than one video? If not, hide the "See Ins videos" link     Added by Simha
            if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumInsVideos() == 0) {
                $GLOBALS['HideInsVideosLink'] = "none";    
            }
            else {
                if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumInsVideos() > 0) {
                    $var = "SeeInsVideos";
                } 
                $GLOBALS['SeeInsVideos'] = sprintf(GetLang($var), $GLOBALS['ISC_CLASS_PRODUCT']->GetNumInsVideos());    
            }
            //more Ins Videos link ends Added by Simha         
        
   
            $thumb = $GLOBALS['ISC_CLASS_PRODUCT']->GetInstallThumb();
            $thumbImage = '';

            if($thumb == '' && GetConfig('DefaultProductImage') != '') {
                if(GetConfig('DefaultProductImage') == 'template') {
                    $thumb = GetConfig('ShopPath').'/templates/'.GetConfig('template').'/images/ProductDefault.gif';
                }
                else {
                    $thumb = GetConfig('ShopPath').'/'.GetConfig('DefaultProductImage');
                }
                //$thumbImage = '';
				$thumbImage = '<img src="" alt="" />';
            }
            else if($thumb != '') {
                $thumbImage = '<img src="'.GetConfig('ShopPath').'/'.GetConfig('InstallImageDirectory').'/'.$thumb.'" alt="" />';
			}
            
            // Is there more than one image? If not, hide the "See more pictures" link
            if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumInsImages() == 0) {
                $GLOBALS['HideMorePicturesLink'] = "none";
                $GLOBALS['ThumbImage'] = $thumbImage;
            }
            else
				{

                $GLOBALS['ThumbImage'] = '<a href="#" onclick="'.$GLOBALS['InstallImagePopupJS'].'">'.$thumbImage.'</a>';

                if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumInsImages() == 2) {
                    $var = "MorePictures1";
                }
                else if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumInsImages() == 1) {
                    $var = "SeeLargerImage";
                }
                else {
                    $var = "MorePictures2";
                }
                $GLOBALS['SeeInsPictures'] = sprintf(GetLang($var), $GLOBALS['ISC_CLASS_PRODUCT']->GetNumInsImages() - 1);    
                $this->SetAdditionalView();
            }
 
		}

        public function SetAdditionalView()   {   //http://www.smartchamp.com/store/installimage.php
            
            $query = sprintf("SELECT pi.imageid, pi.imageprodid, pi.imageprodhash, pi.imagefile, pi.imageisthumb, ti.imagefile thumbfile, ti.imageisthumb isThumb FROM [|PREFIX|]install_images pi
LEFT JOIN [|PREFIX|]install_images ti ON ti.imagesort = pi.imagesort AND ti.imageprodid = pi.imageprodid
 AND ti.imageisthumb='3' WHERE pi.imageprodid='%d' AND pi.imageisthumb='0' order by pi.imagesort asc", $GLOBALS['ISC_CLASS_DB']->Quote($GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()));
                                                                                                    
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);      
            
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $this->_prodimages[] = $row;
            }
            $GLOBALS['InsAdditionalViewGallery'] = '';
            
            for ($y=0; $y<count($this->_prodimages); $y++)   {
                
                $ThumbImage = GetConfig('InstallImageDirectory').'/'.$this->_prodimages[$y]['thumbfile']; 
                    
                if(file_exists(ISC_BASE_PATH."/".$ThumbImage) && $this->_prodimages[$y]['thumbfile'] != '')    {  //file_exists($ThumbImage) && 
                    $ThumbImage = $GLOBALS['ShopPath'].'/'.GetConfig('InstallImageDirectory').'/'.$this->_prodimages[$y]['thumbfile'];
                    $ThumbImage = '<img id="Image'.$y.'" src="'.$ThumbImage.'" alt="">'; 
                }
                else if(file_exists(ISC_BASE_PATH."/".GetConfig('InstallImageDirectory').'/'.$this->_prodimages[$y]['imagefile']))   {
                    $ThumbImage = $this->ScaleImage($GLOBALS['ShopPath']."/".GetConfig('InstallImageDirectory').'/'.$this->_prodimages[$y]['imagefile'], 70, 70, ISC_BASE_PATH."/".GetConfig('InstallImageDirectory').'/'.$this->_prodimages[$y]['imagefile']); 
                }
                else    {
                    $ThumbImage = GetConfig('ShopPath').'/templates/default/images/thumb_default.gif';
                    $ThumbImage = '<img id="Image'.$y.'" src="'.$ThumbImage.'" alt="">';
                }
                //$OnClick = "showProductImageNew('".GetConfig('ShopPath')."/installimage.php', ".$GLOBALS['ProductId'].", ".$y.");";
                $OnClick = "showProductImageNew('".$this->InsImageLink($GLOBALS['ProductId'])."', 0, ".$y.");"; 
                
                $AdditionalView = '<div style="float:left;width:70px;height:70px;padding-right:2px;padding-left:2px">
                                        <a onclick="'.$OnClick.'" href="#">
                                            '.$ThumbImage.'
                                        </a>
                                    </div>';
                $GLOBALS['InsAdditionalViewGallery'] .= $AdditionalView;
                
            }
            //$output2 = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output2, $GLOBALS['SNIPPETS']);
            $GLOBALS['SNIPPETS']['InsAdditionalView'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("InsAdditionalView");
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
        
        //Added by Simha     
        /**
         * Generate the link to a product.
         *
         * @param string The name of the product to generate the link to.
         * @return string The generated link to the product.
         */
        function InsImageLink($prod)
        {
            if ($GLOBALS['EnableSEOUrls'] == 1) {      
                return sprintf("%s/%s/%s.html", GetConfig('ShopPath'), INSTALLIMAGE_LINK_PART, MakeURLSafe($prod));
            } else {
                return sprintf("%s/installimage.php?product_id=%s", GetConfig('ShopPath'), MakeURLSafe($prod));
            }                 
        }
        
        //Added by Simha     
        /**
         * Generate the link to a product.
         *
         * @param string The name of the product to generate the link to.
         * @return string The generated link to the product.
         */
        function InsVideoLink($prod)
        {
            if ($GLOBALS['EnableSEOUrls'] == 1) {
                return sprintf("%s/%s/%s.html", GetConfig('ShopPath'), INSTALLVIDEO_LINK_PART, MakeURLSafe($prod));
            } else {
                return sprintf("%s/installvideo.php?product_id=%s", GetConfig('ShopPath'), MakeURLSafe($prod));
            }                 
        }
        
        
	}

?>
