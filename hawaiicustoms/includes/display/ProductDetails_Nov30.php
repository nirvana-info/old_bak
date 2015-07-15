<?php
        
    require_once(ISC_BASE_PATH . "/lib/discountcalcs.php");
    
	CLASS ISC_PRODUCTDETAILS_PANEL extends PANEL
	{
		
		var $_prodimages = array();

		public function SetPanelSettings()
		{
			$GLOBALS['HideProductErrorMessage']='display:none';

			if(isset($_SESSION['ProductErrorMessage']) && $_SESSION['ProductErrorMessage']!='') {
				$GLOBALS['HideProductErrorMessage']='';
				$GLOBALS['ProductErrorMessage']=$_SESSION['ProductErrorMessage'];
				unset($_SESSION['ProductErrorMessage']);
			}

			$GLOBALS['ProductCartQuantity'] = '';
			if(isset($GLOBALS['CartQuantity'.$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()])) {
				$GLOBALS['ProductCartQuantity'] = (int)$GLOBALS['CartQuantity'.$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()];
			}

			$GLOBALS['ProductName'] = isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetProductName());
			$GLOBALS['ProductId'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductId();
			$GLOBALS['ProductPrice'] = '';

			// Get the vendor information
			$vendorInfo = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductVendor();
			$GLOBALS['HideVendorDetails'] = 'display: none';
			$GLOBALS['VendorName'] = '';
			if(is_array($vendorInfo)) {
				//$GLOBALS['HideVendorDetails'] = '';
				$GLOBALS['VendorName'] = '<a href="'.VendorLink($vendorInfo).'">'.isc_html_escape($vendorInfo['vendorname']).'</a>';
			}

			// Can this product be gift wrapped? And do we have any gift wrapping options set up?
			if($GLOBALS['ISC_CLASS_PRODUCT']->CanBeGiftWrapped() && $GLOBALS['ISC_CLASS_PRODUCT']->GetProductType() == PT_PHYSICAL) {
				$GLOBALS['HideGiftWrapMessage'] = '';
				$GLOBALS['GiftWrappingAvailable'] = GetLang('GiftWrappingOptionsAvailable');
			}
			else {
				$GLOBALS['HideGiftWrapMessage'] = 'display: none';
			}

			$thumb = '';
			$GLOBALS['ImagePopupJavascript'] =  "showProductImageNew('".$this->ProdImageLink($GLOBALS['ProductId'])."', 0, 0);";  
            //$GLOBALS['VideoPopupJavascript'] =  "showProductVideoNew('".GetConfig('ShopPath')."/productvideo.php', ".$GLOBALS['ProductId'].");";         
            $GLOBALS['VideoPopupJavascript'] =  "showProductVideoNew('".$this->ProdVideoLink($GLOBALS['ProductId'])."');";         
            
            //$GLOBALS['AudioPopupJavascript'] =  "showProductVideoNew('".GetConfig('ShopPath')."/productaudio.php', ".$GLOBALS['ProductId'].");";           
            $GLOBALS['AudioPopupJavascript'] =  "showProductVideoNew('".$this->ProdAudioLink($GLOBALS['ProductId'])."');";            
			// If we're showing images as a lightbox, we need to load up the URLs for the other images for this product
			if(GetConfig('ProductImageMode') == 'lightbox') {
				$GLOBALS['AdditionalStylesheets'] = array(
					GetConfig('ShopPath').'/javascript/jquery/plugins/lightbox/lightbox.css'
				);

				$GLOBALS['LightBoxImageList'] = '';
				$query = "
					SELECT imagefile
					FROM [|PREFIX|]product_images
					WHERE imageprodid='".$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()."' AND imageisthumb=0
					ORDER BY imagesort ASC
				";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($image = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$GLOBALS['LightBoxImageList'] .= '<a ';
					$GLOBALS['LightBoxImageList'] .= 'href="'.$GLOBALS['ShopPath'].'/'.GetConfig('ImageDirectory').'/'.$image['imagefile'].'" ';
					$GLOBALS['LightBoxImageList'] .= 'title="'.isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetProductName()).'"';
					$GLOBALS['LightBoxImageList'] .= '>&nbsp;</a>';
				}
				$GLOBALS['ImagePopupJavascript'] = "showProductImageLightBox(); return false;";
				$GLOBALS['LightBoxImageJavascript'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('ProductImagesLightBox');
			}

			// Is there a thumbnail image we can show?
			$thumb = $GLOBALS['ISC_CLASS_PRODUCT']->GetThumb();
			$thumbImage = '';

			if($thumb == '' && GetConfig('DefaultProductImage') != '') {
				if(GetConfig('DefaultProductImage') == 'template') {
					$thumb = GetConfig('ShopPath').'/templates/'.GetConfig('template').'/images/ProductDefault.gif';
				}
				else {
					$thumb = GetConfig('ShopPath').'/'.GetConfig('DefaultProductImage');
				}
				$thumbImage = '<img src="'.$thumb.'" alt="" />';
			}
			else if($thumb != '') {
				$thumbImage = '<img src="'.GetConfig('ShopPath').'/'.GetConfig('ImageDirectory').'/'.$thumb.'" alt="" />';
			}

			// Is there more than one image? If not, hide the "See more pictures" link
			if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumImages() == 0) {
				$GLOBALS['HideMorePicturesLink'] = "none";
				$GLOBALS['ThumbImage'] = $thumbImage;
			}
			else {
				$GLOBALS['ThumbImage'] = '<a href="#" onclick="'.$GLOBALS['ImagePopupJavascript'].'">'.$thumbImage.'</a>';

				if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumImages() == 2) {
					$var = "MorePictures1";
				}
				else if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumImages() == 1) {
					$var = "SeeLargerImage";
				}
				else {
					$var = "MorePictures2";
				}
				$GLOBALS['SeeMorePictures'] = sprintf(GetLang($var), $GLOBALS['ISC_CLASS_PRODUCT']->GetNumImages() - 1);
				
                $this->SetAdditionalView();
                
			}

            // Is there more than one video? If not, hide the "See videos" link     Added by Simha
            if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumVideos() == 0 && $GLOBALS['ISC_CLASS_PRODUCT']->GetNumAudios() == 0 ) {
                $GLOBALS['HideVideosLink'] = "none";
            }
            else {                 
                if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumVideos() > 0) {
                    $var = "SeeVideos";
                }
                else    {
                    $GLOBALS['HideSpecVideosLink'] = "none"; 
                } 
                if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumAudios() > 0) {
                    $avar = "SeeAudios";
                }
                else    {
                    $GLOBALS['HideSpecAudiosLink'] = "none";
                } 
                $GLOBALS['SeeVideos'] = sprintf(GetLang($var), $GLOBALS['ISC_CLASS_PRODUCT']->GetNumVideos());  
                $GLOBALS['SeeAudios'] = sprintf(GetLang($avar), $GLOBALS['ISC_CLASS_PRODUCT']->GetNumAudios());   
            }
            //more Videos link ends Added by Simha   
            
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
            
            //Added by Simha to hide Not For Sale Msg 
            $GLOBALS['DisplayNotForSaleMsg'] = 'none';    
            
			if($GLOBALS['ISC_CLASS_PRODUCT']->IsPurchasingAllowed()) {
				if(!GetConfig('ShowProductShipping')) {
					$GLOBALS['HideShipping'] = 'none';
				} else if ($GLOBALS['ISC_CLASS_PRODUCT']->GetProductType() == PT_PHYSICAL) {
					if ($GLOBALS['ISC_CLASS_PRODUCT']->GetFixedShippingCost() != 0) {
						// Is there a fixed shipping cost?
						$GLOBALS['ShippingPrice'] = sprintf("%s %s", CurrencyConvertFormatPrice($GLOBALS['ISC_CLASS_PRODUCT']->GetFixedShippingCost()), GetLang('FixedShippingCost'));
					}
					else if ($GLOBALS['ISC_CLASS_PRODUCT']->HasFreeShipping()) {
						// Does this product have free shipping?
						$GLOBALS['ShippingPrice'] = GetLang('FreeShipping');
					}
					else {
						// Shipping calculated at checkout
						$GLOBALS['ShippingPrice'] = GetLang('CalculatedAtCheckout');
					}
				} else {
					$GLOBALS['ShippingPrice'] = GetLang('CalculatedAtCheckout');
				}

				// Is tax already included in this price?
				if(GetConfig('TaxTypeSelected') > 0 && $GLOBALS['ISC_CLASS_PRODUCT']->GetProductTaxable()) {
					if(GetConfig('PricesIncludeTax')) {
						if(GetConfig('TaxTypeSelected') == 2 && GetConfig('DefaultTaxRateName')) { //not included
							$GLOBALS['IncludingExcludingTax'] = sprintf(GetLang('ProductIncludingTax1'), isc_html_escape(GetConfig('DefaultTaxRateName')));
						}
						else {
							$GLOBALS['IncludingExcludingTax'] = GetLang('ProductIncludingTax2');
						}
					}
					else {
						if(GetConfig('TaxTypeSelected') == 2) {
							if(GetConfig('DefaultTaxRateName')) {
								$GLOBALS['IncludingExcludingTax'] = sprintf(GetLang('ProductIncludingTax1'), isc_html_escape(GetConfig('DefaultTaxRateName')));
							}
							else {
								$GLOBALS['IncludingExcludingTax'] = GetLang('ProductIncludingTax2');
							}
						}
						else {
							$GLOBALS['IncludingExcludingTax'] = GetLang('ProductExcludingTax2');
						}
					}
				}

				$GLOBALS['ProductPrice'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetCalculatedPrice();
                
                $catquery = " SELECT DISTINCT c.categoryid
                FROM isc_categories c                                                 
                LEFT JOIN isc_categoryassociations ca ON c.categoryid = ca.categoryid 
                LEFT JOIN isc_products p ON ca.productid = p.productid AND p.prodvisible='1'
                WHERE p.productid= ".$GLOBALS['ProductId']."";                                                              

                $relcats = array();
                $catresult = $GLOBALS['ISC_CLASS_DB']->Query($catquery);
                while($catrow = $GLOBALS['ISC_CLASS_DB']->Fetch($catresult)) { 
                    $relcats[] = $catrow['categoryid'];
                } 
                $productCats = $relcats;
                
                $DiscountInfo = GetRuleModuleInfo();                
                $FinalPrice   = $GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice();  
                foreach($DiscountInfo as $DiscountInfoSub)   {  
                    $catids = explode(",", $DiscountInfoSub['catids']);
                    foreach($catids as $catid) {
                        if(in_array($catid, $productCats)) {     
                            $DiscountAmount = $FinalPrice * ((int)$DiscountInfoSub['amount']/100); 
                            if ($DiscountAmount < 0) {
                                $DiscountAmount = 0;
                            }
                            $DiscountAmount  = $FinalPrice - $DiscountAmount; 
                        } 
                    }  
                }  
                
				if ($GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice() < $GLOBALS['ISC_CLASS_PRODUCT']->GetRetailPrice()) {
					$GLOBALS['RetailPrice'] = "<strike>".CurrencyConvertFormatPrice($GLOBALS['ISC_CLASS_PRODUCT']->GetRetailPrice())."</strike>";
					// blessen
					//$GLOBALS['PriceLabel'] = GetLang('YourPrice');

					$GLOBALS['PriceLabel'] = GetLang('Price');
					$savings = $GLOBALS['ISC_CLASS_PRODUCT']->GetRetailPrice() - $GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice();

					$GLOBALS['HideRRP'] = "none";

					//$GLOBALS['YouSave'] = "<span class=\"YouSave\">".sprintf(GetLang('YouSave'), "<span class=
					//'YouSaveAmount'>".CurrencyConvertFormatPrice($savings)."</span>")."</span>";


				} else {
					$GLOBALS['PriceLabel'] = GetLang('Price');
					$GLOBALS['HideRRP'] = "none";
				}
			}
			else {
				$GLOBALS['PriceLabel'] = GetLang('Price');
				$GLOBALS['HideShipping'] = 'none';
				if($GLOBALS['ISC_CLASS_PRODUCT']->ArePricesHidden() || !GetConfig('ShowProductPrice')) {
					if($GLOBALS['ISC_CLASS_PRODUCT']->GetProductCallForPricingLabel()) {
						$GLOBALS['ProductPrice'] = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseGL($GLOBALS['ISC_CLASS_PRODUCT']->GetProductCallForPricingLabel());
					}
					else {
						$GLOBALS['HidePrice'] = "display: none;";
					}
				} else {
					$GLOBALS['ProductPrice'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetCalculatedPrice();
				}

				$GLOBALS['HideRRP'] = 'none';
                //To display not for sale message Added by Simha
                $GLOBALS['DisplayNotForSaleMsg'] = '';
            }

			// Is this product linked to a brand?
			if ($GLOBALS['ISC_CLASS_PRODUCT']->GetBrandName() != "" && GetConfig('ShowProductBrand')) {
				$GLOBALS['BrandName'] = isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetBrandName());
				$GLOBALS['BrandLink'] = BrandLink($GLOBALS['ISC_CLASS_PRODUCT']->GetBrandName());
			}
			else {
				$GLOBALS['HideBrandLink'] = "none";
			}

			if ($GLOBALS['ISC_CLASS_PRODUCT']->GetProductType() == PT_PHYSICAL && GetConfig('ShowProductWeight')) {
				// It's a physical product
                
				$prodweight = $GLOBALS['ISC_CLASS_PRODUCT']->GetWeight();
                # Added to hide the weight lable while the value is 0.00 Baskaran
                if($prodweight == '0.00 LBS') {
                    $GLOBALS['HideWeight'] = "none";
                }
                else {
                    $GLOBALS['ProductWeight'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetWeight();
                }
			}
			else {
				// It's a digital product
				$GLOBALS['HideWeight'] = "none";
			}

			$product = $GLOBALS['ISC_CLASS_PRODUCT']->GetProduct();
			$dimensions = array(
				'ProductHeight' => 'prodheight',
				'ProductWidth' => 'prodwidth',
				'ProductDepth' => 'proddepth'
			);
			foreach($dimensions as $global => $field) {
				if($product[$field] > 0) {
					$GLOBALS[$global] = FormatWeight($product[$field], false);
					$hasDimensions = true;
				}
				else {
					$GLOBALS['Hide'.$global] = 'display: none';
				}
			}

			if(!isset($hasDimensions)) {
				$GLOBALS['HideDimensions'] = 'display: none';
			}

			// Are reviews disabled? Then don't show anything related to reviews
			if(GetConfig('EnableProductReviews') == 0) {
				$GLOBALS['HideReviewLink'] = "none";
				$GLOBALS['HideRating'] = "none";
				$GLOBALS['HideReviews'] = "none";
			}
			else {
				// How many reviews are there?
				if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumReviews() == 0) {
					$GLOBALS['HideReviewLink'] = "none";
				}
				else {
					$GLOBALS['HideNoReviewsMessage'] = "none";
					if ($GLOBALS['ISC_CLASS_PRODUCT']->GetNumReviews() == 1) {
						$GLOBALS['ReviewLinkText'] = GetLang('ReviewLinkText1');
					} else {
						$GLOBALS['ReviewLinkText'] = sprintf(GetLang('ReviewLinkText2'), $GLOBALS['ISC_CLASS_PRODUCT']->GetNumReviews());
					}
				}
			}

			// Has a product availability been given?
			if ($GLOBALS['ISC_CLASS_PRODUCT']->GetAvailability() != "") {
				$GLOBALS['Availability'] = isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetAvailability());
			} else {
				$GLOBALS['HideAvailability'] = "none";
			}

			// Is there an SKU for this product?
			if ($GLOBALS['ISC_CLASS_PRODUCT']->GetSKU() != "" && GetConfig('ShowProductSKU')) {
				$GLOBALS['SKU'] = isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetSKU());
			}
			else {
				$GLOBALS['HideSKU'] = "none";
			}

			if(!GetConfig('ShowProductRating')) {
				$GLOBALS['HideRating'] = "none";
			}

			$GLOBALS['Rating'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetRating();
			$GLOBALS['CartLink'] = CartLink();

            /* Baskaran added to display image in product detail page */
            $brandimage = $GLOBALS['ISC_CLASS_PRODUCT']->GetProdbrandimagefile();
            
            $imageurl = '';
            if($brandimage != '' || !empty($brandimage)) {
                $imageurl = GetConfig('ShopPath')."/product_images/".$brandimage;
            }
            else {
                $imageurl = GetConfig('ShopPath')."/templates/CongoWorld/images/ProductDefault.gif";
            }
            $GLOBALS['ImageUrl'] = $imageurl;
            /* Baskaran ends */


			$GLOBALS['ProductId'] = (int) $GLOBALS['ISC_CLASS_PRODUCT']->_prodid;

			$GLOBALS['ImagePage'] = sprintf("%s/productimage.php", $GLOBALS['ShopPath']);

			$GLOBALS['ProductNumReviews'] = (int) $GLOBALS['ISC_CLASS_PRODUCT']->GetNumReviews();

			// Does this product have any bulk discount?
			if ($GLOBALS['ISC_CLASS_PRODUCT']->CanUseBulkDiscounts()) {
				$GLOBALS['HideBulkDiscountLink'] = '';
				$GLOBALS['BulkDiscountThickBoxTitle'] = sprintf(GetLang('BulkDiscountThickBoxTitle'), isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetProductName()));

				require_once ISC_BASE_PATH.'/includes/display/SideProductAddToCart.php';
				$GLOBALS['BulkDiscountThickBoxRates'] = ISC_SIDEPRODUCTADDTOCART_PANEL::GetProductBulkDiscounts();
				$GLOBALS['ProductBulkDiscountThickBox'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductBulkDiscountThickBox");
			} else {
				$GLOBALS['HideBulkDiscountLink'] = 'none';
			}

			if (GetConfig('ShowInventory') == 1 && $GLOBALS['ISC_CLASS_PRODUCT']->GetProductInventoryTracking() > 0) {
				$GLOBALS['InventoryList'] = '';
				if ($GLOBALS['ISC_CLASS_PRODUCT']->GetProductInventoryTracking() == 2) {
					$variations = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductVariations();
					if (empty($options)) {
						$GLOBALS['HideCurrentStock'] = "display: none;";
					}
				}
				else if ($GLOBALS['ISC_CLASS_PRODUCT']->GetProductInventoryTracking() == 1) {
					$currentStock = $GLOBALS['ISC_CLASS_PRODUCT']->GetInventoryLevel();
					if ($currentStock <= 0) {
						$GLOBALS['InventoryList'] = GetLang('SoldOut');
					}
					else {
						$GLOBALS['InventoryList'] = $currentStock;
					}
				}
			}
			else {
				$GLOBALS['HideCurrentStock'] = "display: none;";
			}
            /* Added for to display the "Make an offer" Button -- Baskaran */
            # Checked for the selected series offer is 'yes'
            
            $GLOBALS['HideOfferButton'] = 'none';
            if(GetConfig('ShowBestOffer') == '1') {
                if($GLOBALS['ISC_CLASS_PRODUCT']->GetSeriesOffer() == 'yes'){
                    $GLOBALS['HideOfferButton'] = '';
                }
                else {
                    # Checking for the selected sub category offer is 'yes'
                    if($GLOBALS['ISC_CLASS_PRODUCT']->GetCategoryOffer() == 'yes'){
                        $GLOBALS['HideOfferButton'] = '';
                    }
                    else {
                        # Checking brand offer is 'yes' and corresponding series offer are 'no'
                        if($GLOBALS['ISC_CLASS_PRODUCT']->GetBrandOffer() == 'yes' and $GLOBALS['ISC_CLASS_PRODUCT']->GetSeriesCntOffer() == 0) {
                            $GLOBALS['HideOfferButton'] = '';
                        }
                        else {
                            # Checking for Root category offer is 'yes' and corresponding sub category offer are 'no'
                            if($GLOBALS['ISC_CLASS_PRODUCT']->GetRootCategoryOffer() == 'yes' and $GLOBALS['ISC_CLASS_PRODUCT']->GetSubCategoryCntOffer() == 0) {
                                $GLOBALS['HideOfferButton'] = '';
                            }
                            else {
                                $GLOBALS['HideOfferButton'] = 'none';
                            }
                        }
                    }
                }
            }
            /* Code Ends */                
			if(GetConfig('AddToCartButtonPosition') == 'middle' && $GLOBALS['ISC_CLASS_PRODUCT']->IsPurchasingAllowed()) {
				require_once ISC_BASE_PATH.'/includes/display/SideProductAddToCart.php';
				ISC_SIDEPRODUCTADDTOCART_PANEL::LoadAddToCartOptions('middle');
//blessen
if ($GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice() < $GLOBALS['ISC_CLASS_PRODUCT']->GetRetailPrice())
				{
$GLOBALS['SNIPPETS']['ProductAddToCart'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductAddToCart1");
				}
				else
				{
$GLOBALS['SNIPPETS']['ProductAddToCart'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductAddToCart");
				}

				//blessen                        
				// original $GLOBALS['SNIPPETS']['ProductAddToCart'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductAddToCart");
			}
                
            //blessen
            if ($GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice() < $GLOBALS['ISC_CLASS_PRODUCT']->GetRetailPrice())
			{
                $GLOBALS['ProductPrice'] = CurrencyConvertFormatPrice($GLOBALS['ISC_CLASS_PRODUCT']->GetRetailPrice());
                $GLOBALS['ProductPrice'] = "<strike>".$GLOBALS['ProductPrice']."</strike>&nbsp;&nbsp;<b alt='Price may be adjusted. Add to your cart and see the final price.'  Title='Price may be adjusted. Add to your cart and see the final price.'>(".GetLang('CheckPriceInCart').")</b>";                                                                                             
			} 
            
            $GLOBALS['ShowOnSaleImage'] = '';
        
            if(isset($DiscountAmount) && ($DiscountAmount < $FinalPrice) && GetConfig('ShowOnSale'))    {
                $GLOBALS['ProductPrice']    = "<strike>".CurrencyConvertFormatPrice($FinalPrice)."</strike>";       
                $GLOBALS['DiscountPrice']   = "".CurrencyConvertFormatPrice($DiscountAmount).""; 
                $GLOBALS['ShowOnSaleImage'] = '<img id="OnSale" src="'.GetConfig('ShopPath').'/templates/default/images/onsale.gif" alt="">';
            }

//blessen
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($GLOBALS['ISC_CLASS_PRODUCT']->BuildTitle());
		}

        public function SetAdditionalView()   {   //http://www.smartchamp.com/store/installimage.php
            
            $query = sprintf("SELECT pi.imageid, pi.imageprodid, pi.imageprodhash, pi.imagefile, pi.imageisthumb, ti.imagefile thumbfile, ti.imageisthumb isThumb FROM [|PREFIX|]product_images pi
LEFT JOIN [|PREFIX|]product_images ti ON ti.imagesort = pi.imagesort AND ti.imageprodid = pi.imageprodid
 AND ti.imageisthumb='3' WHERE pi.imageprodid='%d' AND pi.imageisthumb='0' order by pi.imagesort asc", $GLOBALS['ISC_CLASS_DB']->Quote($GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()));
                                                                                                    
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);      
            
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $this->_prodimages[] = $row;
            }
            $GLOBALS['AdditionalViewGallery'] = '';
            
            for ($y=0; $y<count($this->_prodimages); $y++)   {
                
                $ThumbImage = $GLOBALS['ImageDirectory'].'/'.$this->_prodimages[$y]['thumbfile']; 
                    
                if(file_exists(ISC_BASE_PATH."/".$ThumbImage) && $this->_prodimages[$y]['thumbfile'] != '')    {  //file_exists($ThumbImage) && 
                    $ThumbImage = $GLOBALS['ShopPath'].'/'.$GLOBALS['ImageDirectory'].'/'.$this->_prodimages[$y]['thumbfile'];
                    $ThumbImage = '<img id="Image'.$y.'" src="'.$ThumbImage.'" alt="">'; 
                }  
                else if(file_exists(ISC_BASE_PATH."/".$GLOBALS['ImageDirectory'].'/'.$this->_prodimages[$y]['imagefile']))   {
                    $ThumbImage = $this->ScaleImage($GLOBALS['ShopPath']."/".$GLOBALS['ImageDirectory'].'/'.$this->_prodimages[$y]['imagefile'], 70, 70, ISC_BASE_PATH."/".$GLOBALS['ImageDirectory'].'/'.$this->_prodimages[$y]['imagefile']); 
                }
                else    {
                    $ThumbImage = GetConfig('ShopPath').'/templates/default/images/thumb_default.gif';
                    $ThumbImage = '<img id="Image'.$y.'" src="'.$ThumbImage.'" alt="">';
                }
                
                $OnClick = "showProductImageNew('".$this->ProdImageLink($GLOBALS['ProductId'])."', 0, ".$y.");";
                $AdditionalView = '<div style="float:left;width:70px;height:70px;padding-right:2px;padding-left:2px">
                                        <a onclick="'.$OnClick.'" href="#">
                                            '.$ThumbImage.'
                                        </a>
                                    </div>';
                $GLOBALS['AdditionalViewGallery'] .= $AdditionalView;
                
            }
            //$output2 = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output2, $GLOBALS['SNIPPETS']);
            $GLOBALS['SNIPPETS']['AdditionalView'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("AdditionalView");
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
         * Generate the link to a product image.
         *
         * @param string The name of the product to generate the link to.
         * @return string The generated link to the product.
         */
        function ProdImageLink($prod)
        {
            if ($GLOBALS['EnableSEOUrls'] == 1) {      
                return sprintf("%s/%s/%s.html", GetConfig('ShopPath'), PRODUCTIMAGE_LINK_PART, MakeURLSafe($prod));
            } else {
                return sprintf("%s/productimage.php?product_id=%s", GetConfig('ShopPath'), MakeURLSafe($prod));
            }                 
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
        
	}

?>