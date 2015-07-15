<?php

	class ISC_INSTALLIMAGE
	{
		var $_prodid = 0;
		var $_prodcurrentimage = 0;
		var $_prodnumimages = 0;
		var $_prodname = '';

		var $_variationid = 0;

		var $_prodimages = array();
        var $_prodthumbs = array();     
		var $_prodimagethumbs = array();

		function __construct()
		{    
            if (isset($_REQUEST['product_id'])) {
                $_GET['product_id'] = $_REQUEST['product_id'];
            }
            else if(isset($GLOBALS['PathInfo'][1])) {
                $_GET['product_id'] = preg_replace('#\.html$#i', '', $GLOBALS['PathInfo'][1]);
            }
            else {
                $_GET['product_id'] = '';
            } 
            $this->_SetImageData();
		}

		function _SetImageData()
		{
			if(isset($_GET['product_id'])) {
				$this->_prodid = (int)$_GET['product_id'];

				// Load the product name
				$query = sprintf("select prodname from [|PREFIX|]products where productid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($this->GetProductId()));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$this->_prodname = $GLOBALS['ISC_CLASS_DB']->FetchOne($result, "prodname");

				// Are we showing the image for a particular variation?
				if(isset($_GET['variation_id'])) {
					$this->_variationid = (int)$_GET['variation_id'];
					$query = "SELECT * FROM [|PREFIX|]product_variation_combinations WHERE vcproductid='".$this->_prodid."' AND combinationid='".$this->_variationid."'";
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					$variation = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
					if(!$variation['combinationid']) {
						// Invalid variation
						exit;
					}
					$this->_prodimages[] = array(
						"imagefile" => $variation['vcimage']
					);
				}
				// Otherwise, just load general images for a product
				else {
					// Load the images into an array
					//$query = sprintf("select * from [|PREFIX|]product_images where imageprodid='%d' and imageisthumb='0' order by imagesort asc", $GLOBALS['ISC_CLASS_DB']->Quote($this->GetProductId()));
					$query = sprintf("SELECT pi.imageid, pi.imageprodid, pi.imageprodhash, pi.imagefile, pi.imageisthumb, ti.imagefile thumbfile, ti.imageisthumb isThumb FROM [|PREFIX|]install_images pi
LEFT JOIN [|PREFIX|]install_images ti ON ti.imagesort = pi.imagesort AND ti.imageprodid = pi.imageprodid
 AND ti.imageisthumb='3' WHERE pi.imageprodid='%d' AND pi.imageisthumb='0' order by pi.imagesort asc", $GLOBALS['ISC_CLASS_DB']->Quote($this->GetProductId()));
                                                                                                    
                    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                    
                       

					while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						$this->_prodimages[] = $row;
					}
                    /*// Load the thumbs into an array
                    $query = sprintf("select * from [|PREFIX|]product_images where imageprodid='%d' and imageisthumb='3' order by imagesort, imageisthumb asc", $GLOBALS['ISC_CLASS_DB']->Quote($this->GetProductId()));
                    $t_result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                    
                    while($t_row = $GLOBALS['ISC_CLASS_DB']->Fetch($t_result)) {
                        $this->_prodthumbs[] = $t_row;
                    } */
				}
                
				// How many images are there?
				$this->_prodnumimages = count($this->_prodimages);

				// Which image should we show?
				if(isset($_GET['current_image'])) {
					$this->_prodcurrentimage = (int)$_GET['current_image'];
				}
                
               
                //Added for dynamic gallary
                
                 $this->CreateImageGallery();
                
                //Added for dynamic gallary ends   
                
			}
		}
        
        function CreateImageGallery()
        {
            $ImageGallery = '';  
            
            for($z=0; $z<count($this->_prodimages); $z++)   {        
                
                $ThumbImage = GetConfig('InstallImageDirectory').'/'.$this->_prodimages[$z]['thumbfile']; 
                    
                if(file_exists($ThumbImage) && $this->_prodimages[$z]['thumbfile'] != '')    {
                    $ThumbImage = $GLOBALS['ShopPath'].'/'.GetConfig('InstallImageDirectory').'/'.$this->_prodimages[$z]['thumbfile'];        
                    $ThumbImage = '<img src="'.$ThumbImage.'" alt="Image '.($z+1).'" />';
                }
                else    {
                    if(file_exists(ISC_BASE_PATH."/".GetConfig('InstallImageDirectory').'/'.$this->_prodimages[$z]['imagefile']))       {
                          $ThumbImage = $this->ScaleImage($GLOBALS['ShopPath']."/".GetConfig('InstallImageDirectory').'/'.$this->_prodimages[$z]['imagefile'], 70, 70, ISC_BASE_PATH."/".GetConfig('InstallImageDirectory').'/'.$this->_prodimages[$z]['imagefile']);
                    }
                    else    {             
                           $ThumbImage = $GLOBALS['ShopPath'].'/templates/default/images/thumb_default.gif';
                           $ThumbImage = '<img src="'.$ThumbImage.'" alt="Image '.($z+1).'" />';
                    }
                }
                
                $ImageGallery   .= '<li>
                                    <a class="thumb" href="'.$GLOBALS['ShopPath'].'/'.GetConfig('InstallImageDirectory').'/'.$this->_prodimages[$z]['imagefile'].'" title="Image '.($z+1).'">
                                        <span class="span_cls">
                                        '.$ThumbImage.'                  
                                        </span>
                                    </a>       
                                </li>';
                
            }
            $GLOBALS['InstallImageGallery']  = $ImageGallery;
            
            if(count($this->_prodimages) <= 1)    {
                $GLOBALS['HideInsControls'] = "none";
            }
            else    {
                $GLOBALS['HideInsControls'] = "";   
            } 
            //
        }

		function GetProductId()
		{
			return $this->_prodid;
		}

		function GetCurrentImage()
		{
			return $this->_prodcurrentimage;
		}

		function GetImage()
		{
			// Return the image to be displayed. Returns an array on success, false on failure.
			if(isset($this->_prodimages[$this->GetCurrentImage()])) {
				return $this->_prodimages[$this->GetCurrentImage()];
			}
			else {
				return false;
			}
		}

		function GetNumImages()
		{
			return $this->_prodnumimages;
		}

		function HandlePage()
		{
			$this->ShowImage();
		}

		function ShowImage()
		{
			if($image = $this->GetImage()) {

				// Set product name
				$GLOBALS['ProductName'] = isc_html_escape($this->_prodname);

				// Show we show the "Previous Image" link?
				if($this->GetCurrentImage() == 0) {
					$GLOBALS['HidePrevLink'] = "none";
				}
				else {
					$GLOBALS['PrevLink'] = sprintf("%s/installimage.php?product_id=%d&current_image=%d", $GLOBALS['ShopPath'], $this->GetProductId(), $this->GetCurrentImage()-1);
				}

				// Should we show the "Next Image" link?
				if($this->GetNumImages()-1 == $this->GetCurrentImage()) {
					$GLOBALS['HideNextLink'] = "none";
				}
				else {
					$GLOBALS['NextLink'] = sprintf("%s/installimage.php?product_id=%d&current_image=%d", $GLOBALS['ShopPath'], $this->GetProductId(), $this->GetCurrentImage()+1);
				}

				//
				$GLOBALS['TotalImages'] = $this->_prodnumimages;
				$GLOBALS['CurrentImage'] = sprintf(GetLang('ImageXOfY'), $this->GetCurrentImage()+1, $GLOBALS['TotalImages']);

				$GLOBALS['ImageFile'] = $image['imagefile'];
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("installimage");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
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
        
	}

?>