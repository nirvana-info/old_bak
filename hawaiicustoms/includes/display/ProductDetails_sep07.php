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

			//temp script to shortern the product name
			$pid  = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductId();
			$querytemp = "SELECT prodbrandid FROM  [|PREFIX|]products where productid = ".$pid."  ";
			$resulttemp = $GLOBALS['ISC_CLASS_DB']->Query($querytemp);
			$brand = $GLOBALS['ISC_CLASS_DB']->Fetch($resulttemp);

			if ($brand['prodbrandid'] == 37)
			{
				$querytemp1 = "SELECT c.catname, c.catcombine FROM [|PREFIX|]categories 	c left join [|PREFIX|]categoryassociations ca on c.categoryid = ca.categoryid  left join [|PREFIX|]products p on ca.productid = p.productid where p.productid =  '".$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()."' ";
				$resulttemp1 = $GLOBALS['ISC_CLASS_DB']->Query($querytemp1);
				$cat = $GLOBALS['ISC_CLASS_DB']->Fetch($resulttemp1);

				if ($cat['catcombine'] != "")
				$GLOBALS['ProductName'] = $cat['catcombine']." Part Number ".isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetSKU());
				else
				$GLOBALS['ProductName'] = $cat['catname']." Part Number ".isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetSKU());
			}
			else
			{
				$GLOBALS['ProductName'] = isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetProductName());
			}
			//temp script to shortern the product name

			//$GLOBALS['ProductName'] = isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetProductName());




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
				/*-$file = realpath(ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/'.$thumb);

				if($thumb != '' && file_exists($file))
				{
					$attribs = @getimagesize($file);
					$width = $attribs[0];
					$height = $attribs[1];
					$width_str = "";

					if($width > 220) // width of the image
					{
						$height = ceil((220/$width)*$height);
						$width = 220;
					}
					
					if($height > 220) // height of the image
					{
						$width = ceil((220/$height)*$width);
						$height = 220;
					}

					$thumbImage = '<img src="'.GetConfig('ShopPath').'/'.GetConfig('ImageDirectory').'/'.$thumb.'" alt="" width="'.$width.'"  height="'.$height.'" />';
					/* 
					if($width > 220) // width of the image
					{
						$width = 220;
						$height = 0;
					}
					else if($height > 220) // height of the image
					{
						$height = 220;
						$width = 0;
					}
					*/
					/* Below code is to dynamically create the thumbnail image */
					//$thumbImage = "<img src='".GetConfig('ShopPath')."/thumbimage.php?width=$width&height=$height&path=".GetConfig('ImageDirectory')."/".$thumb."' alt=''>";
					
				//-}
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
                
                $catquery = " SELECT DISTINCT c.categoryid, p.brandseriesid
                FROM isc_categories c                                                 
                LEFT JOIN isc_categoryassociations ca ON c.categoryid = ca.categoryid 
                LEFT JOIN isc_products p ON ca.productid = p.productid AND p.prodvisible='1'
                WHERE p.productid= ".$GLOBALS['ProductId']."";                                                              

                $relcats = array();
                $brandseries = 0;
                $catresult = $GLOBALS['ISC_CLASS_DB']->Query($catquery);
                while($catrow = $GLOBALS['ISC_CLASS_DB']->Fetch($catresult)) { 
                    $relcats[]   = $catrow['categoryid'];
                    $brandseries = $catrow['brandseriesid'];
                } 
                $productCats = $relcats;
                
                $discounttype = 0;
				$discountname = "";
                //$DiscountInfo = GetRuleModuleInfo();                
                //$FinalPrice    = $GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice();  
                //$FinalPrice    = $GLOBALS['ProductPrice'];
                $FinalPrice    = $GLOBALS['ISC_CLASS_PRODUCT']->GetPrice(); 
                $SalePrice     = $GLOBALS['ISC_CLASS_PRODUCT']->GetSalePrice();
                if((float)$SalePrice > 0 && $SalePrice < $FinalPrice)    {
                    $DiscountPrice = $SalePrice;
                }
                else    {
                    $DiscountPrice = $FinalPrice;     
                    $DiscountPrice = CalculateDiscountPrice($FinalPrice, $DiscountPrice, $productCats[0], $brandseries, $discounttype, $discountname);
                }
                 
                /*
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
                */  
                
				if ($GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice() > $GLOBALS['ISC_CLASS_PRODUCT']->GetRetailPrice()) {
					$GLOBALS['RetailPrice'] = "<strike>".CurrencyConvertFormatPrice($GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice())."</strike>";                   
                    // blessen
					//$GLOBALS['PriceLabel'] = GetLang('YourPrice');

					$GLOBALS['PriceLabel'] = GetLang('Price');
					$savings = $GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice() - $GLOBALS['ISC_CLASS_PRODUCT']->GetRetailPrice();

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
                    $GLOBALS['HideRating'] = "none";                    
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
                                         
                            
                        
                }
            }

            //Check for item in Cart Session   
            @$CartItems = $_SESSION['CART']['ITEMS'];
            $compids = array();
//            $GLOBALS['ISC_CLASS_PRODUCT']->GetProductId();
            //print_r($CartItems);
            if(is_array($CartItems)) {
                foreach($CartItems as $key => $item)   {
                    if($item['product_id']==$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId())    {  
                        if($item['compitem']==1)    {
                            foreach($item['complementary'] as $citem)   {
                                $compids[$citem['comp_productid']] = $citem['quantity'];      
                            }
                        }    
                        break;   
                    }         
                }         
            }
            //Check for item in Cart Session Ends
            
			# Complementary items -- Baskaran
            $productid = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductId();
            $comptype = $GLOBALS['ISC_CLASS_PRODUCT']->GetCompSelectionType(); 

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
            
            $result = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT id,productid FROM [|PREFIX|]import_variations where productid = '".$productid."' $where order by id");
            $impvariationid = '';
            while($improw = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                $impvariationid[] = $improw['id'];
            }
            $impid = implode("','",$impvariationid);
            $impquery = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT complementaryitems FROM [|PREFIX|]application_data where variationid in('".$impid."') AND complementaryitems != ''");
            if($GLOBALS["ISC_CLASS_DB"]->countResult($impquery) > 0) {
				$compitems = '';
				while($joinrecord = $GLOBALS["ISC_CLASS_DB"]->Fetch($impquery)) {
					$compitems .= $joinrecord['complementaryitems'].",";
				}
                $comp = substr($compitems,0,-1);
                if($comp != '') {
                    
                    # Spliting the string with [ ] with regular expression -- Baskaran
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
                    $tempArr = array();
                    $tempArr1 = array();
                    
                    # Checking whether the SKU are valid and present in the db -- Baskaran
                    for($i = 0; $i < $cntproducts; $i++){
                        $split = split(",",$compexplode[$i]);
                        $sku = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT productid, prodname, prodcode, proddescfeature, imagefile, brandname, catname FROM [|PREFIX|]brands b, [|PREFIX|]categories c, [|PREFIX|]products p LEFT JOIN [|PREFIX|]product_images i ON p.productid = i.imageprodid AND i.imageisthumb = '1' WHERE prodcode = '".$split[0]."' AND p.prodbrandid = b.brandid AND p.prodcatids = c.categoryid AND p.prodvisible = '1'");
                        if(($GLOBALS["ISC_CLASS_DB"]->countResult($sku) == 1) and $split[0] != '0') {
                            if(in_array($split[0],$tempArr))continue;
                                $originalarray[] = $split[0].",".$split[1].",".$split[2];
                                $tempArr[] = $split[0];
                        }                                                          
                        else if(($GLOBALS["ISC_CLASS_DB"]->countResult($sku) != 1) and $split[0] == '0') {
                            if(in_array($split[0],$tempArr1))continue;
                                $originalarray[] = $split[0].",".$split[1].",".$split[2];
                                $tempArr1[] = $split[0];
                        }
                    }
                    $cntoriginal = count($originalarray);
                    # Ordering the resultent array which is come from above one with the no thanks option '0' is the key to create the array -- Baskaran
                    $arrManipulate = array();
                    $nothanks = array();
                    for($i = 0; $i < $cntoriginal; $i++) {
                        $orsplit = split(",",$originalarray[$i]);
                        if(($i == 0) and ($orsplit[0] == 0)) {
                            $arrManipulate[] = $orsplit[0].",".$orsplit[1].",".$orsplit[2];
                        }
                        else if(($i != 0) and ($orsplit[0] == '0')) {
                            $nothanks[] = $orsplit[0].",".$orsplit[1].",".$orsplit[2];
                        }
                        else {
                            $arrManipulate[] = $orsplit[0].",".$orsplit[1].",".$orsplit[2];
                        }
                    }
                    
                    if(count($nothanks) > 0) {
                        $arrOrder = array_merge($arrManipulate,$nothanks);
                    }
                    else {
                        $arrOrder = $arrManipulate;
                    }
                
                    $cntarrOrder = count($arrOrder);                    
                    
                    if($cntarrOrder > 0) { 
                    $complementary = "<table cellspacing='2' cellpadding='0' border='0' width='100%'>";
				    for($i = 0; $i < $cntarrOrder; $i++){
					  $split = split(",",$arrOrder[$i]);
					  $sku = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT productid, prodname, prodcode, proddescfeature, imagefile, brandname, catname FROM [|PREFIX|]brands b, [|PREFIX|]categories c, [|PREFIX|]products p LEFT JOIN [|PREFIX|]product_images i ON p.productid = i.imageprodid AND i.imageisthumb = '1' WHERE prodcode = '".$split[0]."' AND p.prodbrandid = b.brandid AND p.prodcatids = c.categoryid AND p.prodvisible = '1'");

					  $skurow = $GLOBALS["ISC_CLASS_DB"]->Fetch($sku);
					  $brandname = $skurow['brandname'];
					  $catname = $skurow['catname'];
					  $skucode = $skurow['prodcode'];
					  $productid = $split[0] != '0' ? $skurow['productid'] : '0'; # $split[0] is sku code, $split[1] is comp. price
					  $path = $skurow['imagefile'];
					  $feature = $skurow['proddescfeature'];
					  $prodimage = '';
					  if($skurow['imagefile'] != '')
					  {
						  $prodimage = GetConfig('ShopPath')."/product_images/$path";
					  }
					  else {
						  $prodimage = GetConfig('ShopPath')."/templates/CongoWorld/images/ProductDefault.gif";
					  }
					  $compdesc = html_entity_decode($split[2]);
					  $compprice = "<b>Price :".CurrencyConvertFormatPrice($split[1])."</b>";
                      $price = CurrencyConvertFormatPrice($split[1]);
					  $feature = addslashes($feature);
					  $esc = htmlentities($feature, ENT_QUOTES);
					  $pricefeature = $esc.isc_html_escape($compprice);                  

					  //$pricefeature = $esc.isc_html_escape($compprice);    
                      
                      $seltype  = $product['comp_type']; //blessen

                        if(isset($compids[$productid]))
                        {
                            $sel = $compids[$productid];
                            $styleval = "style='display: block;'";
                            $checked  = "checked = 'checked'";
                        }
                        else    {
                            $sel = 0;
                            $styleval = "style='display: none;'";
                            $checked  = ""; 
                        }                    
                        
                                    
						if($i == 0 and $productid != 0) {
                            if(count($compids) == 0)    {
                                $styleval = "style='display: block;'";
                                $checked  = " checked = 'checked' ";
                            }
                            $complementary .='<input type="hidden" name="hidmake" value="'.$make.'" id="hidmake" />';
                            $complementary .='<input type="hidden" name="hidmodel" value="'.$model.'" id="hidmodel" />';
                            $complementary .='<input type="hidden" name="hidyear" value="'.$year.'" id="hidyear" />';
                            $complementary .='<input type="hidden" name="hidselcomp" value="'.$comptype.'" id="hidselcomp" />';
							//Kate: $complementary .= "<tr><td><input type='checkbox' name='rdprod[]' id='rdprod_".$i."' value='".$productid."' $checked onclick='ActiveProductTab(\"CompItem_Tab\");ShowCompDesc(\"$skucode\",this.id);unCheck()'>"."<label id='complabel' for='rdprod_".$i."' onmouseover= 'loadHoverImage(event, \"$prodimage\", \"$pricefeature\");' onmouseout = 'hideTip();'>&nbsp;<a href='#Compl'>$catname $brandname $skucode</a></label>"."$compdesc"."</td>
							$complementary .= "<tr><td><input type='checkbox' name='rdprod[]' id='rdprod_".$i."' value='".$productid."' $checked onclick='ActiveProductTab(\"CompItem_Tab\");ShowCompDesc(\"$skucode\",this.id);unCheck(\"$seltype\",this.id)'>"."<label id='complabel' for='rdprod_".$i."' onmouseover= 'loadHoverImage(event, \"$prodimage\", \"$pricefeature\");' onmouseout = 'hideTip();'>&nbsp;<a href='#Compl'>$skucode</a></label>"." $compdesc"."</td>

                            <td><div $styleval id='compqty_".$productid."'>".
                                $this->BuildOption('compqty['.$productid.']', $sel)
                                ."</div></td><td><div id='pr_".$productid."' $styleval></div><b>$price<b></td>
                                </tr>";
						}
						else if($i == 0 and $productid == 0){
                            if(count($compids) == 0)    {
                                $checked  = " checked = 'checked' ";
                            }
                            $complementary .='<input type="hidden" name="hidmake" value="'.$make.'" id="hidmake" />';
                            $complementary .='<input type="hidden" name="hidmodel" value="'.$model.'" id="hidmodel" />';
                            $complementary .='<input type="hidden" name="hidyear" value="'.$year.'" id="hidyear" />';
                            $complementary .='<input type="hidden" name="hidselcomp" value="'.$comptype.'" id="hidselcomp" />';
//						$complementary .= "<tr><td><input type='checkbox' name='rdprod[]' id='rdprod_".$i."' value='".$productid."' checked = 'checked'>"."<label for='rdprod_".$i."'>&nbsp;$split[2]</label>"."</td></tr>";
                            $complementary .= "<tr><td><input type='checkbox' name='nothanks' id='nothanks' value='$productid' $checked onclick='Check()'>"."<label for='nothanks'>&nbsp;$split[2]</label><input type = 'hidden' name = 'isremovable' value = '1' />"."</td></tr>";
						}
						else if($i != 0 and $productid != 0){
							//Kate: $complementary .= "<tr><td><input type='checkbox' name='rdprod[]' id='rdprod_".$i."' value='".$productid."' $checked onclick='ActiveProductTab(\"CompItem_Tab\");ShowCompDesc(\"$skucode\",this.id);unCheck()'>"."<label id='complabel' for='rdprod_".$i."' onmouseover= 'loadHoverImage(event, \"$prodimage\", \"$pricefeature\");' onmouseout = 'hideTip();'>&nbsp;<a href='#Compl'>$catname $brandname $skucode</a></label>"."$compdesc"."</td>
							$complementary .= "<tr><td><input type='checkbox' name='rdprod[]' id='rdprod_".$i."' value='".$productid."' $checked onclick='ActiveProductTab(\"CompItem_Tab\");ShowCompDesc(\"$skucode\",this.id);unCheck(\"$seltype\", this.id)'>"."<label id='complabel' for='rdprod_".$i."' onmouseover= 'loadHoverImage(event, \"$prodimage\", \"$pricefeature\");' onmouseout = 'hideTip();'>&nbsp;<a href='#Compl'>$skucode</a></label>"." $compdesc"."</td>
                            <td><div $styleval id='compqty_".$productid."'>".
                                $this->BuildOption('compqty['.$productid.']', $sel)
                                ."</div></td><td><div id='pr_".$productid."' $styleval></div><b>$price</b></td>
                                </tr>";
						}
						else if($i != 0 and $productid == 0) {
							$complementary .= "<tr><td><input type='checkbox' name='nothanks' id='nothanks' value='$productid' onclick='Check()'>"."<label for='nothanks'>&nbsp;$split[2]</label><input type = 'hidden' name = 'isremovable' value = '1' />"."</td></tr>";
						}
						$complementary .='<input type="hidden" name="hidRadio" value="'.$brandname." ".$skucode.'" id="hid_rdprod_'.$i.'" />';
				  }
			  $complementary .= "</table>";
			  $GLOBALS['complementaryproducts'] = $complementary;
			  $GLOBALS['complementarypaneltoshow'] = "%%Panel.ComplementartyItems%%<hr />";
                }
                }
            }		

            /* Code Ends */                
			if(GetConfig('AddToCartButtonPosition') == 'middle' && $GLOBALS['ISC_CLASS_PRODUCT']->IsPurchasingAllowed()) {
				require_once ISC_BASE_PATH.'/includes/display/SideProductAddToCart.php';
				ISC_SIDEPRODUCTADDTOCART_PANEL::LoadAddToCartOptions('middle');
//blessen
				/* Baskaran */
                $referer = array("http://www.truckchamp.com/pages/overstock-f150-nerfs-reg-cab",
                            "http://www.truckchamp.com/pages/overstock-f150-nerfs-super-cab", 
                            "http://www.truckchamp.com/pages/overstock-f150-nerfs-super-crew",
                            "http://www.truckchamp.com/pages/overstock-f150-nerfs-bedrails",
                            "http://www.truckchamp.com/pages/overstock-f150-nerfs-bullbars",
							"http://www.truckchamp.com/pages/overstock-ram-reg-cab",
							"http://www.truckchamp.com/pages/overstock-ram-nerfs-quad-cab",
							"http://www.truckchamp.com/pages/overstock-ram-bedrails",
							"http://www.truckchamp.com/pages/overstock-ram-bullbars"
                            );
                if(isset($_SERVER["HTTP_REFERER"]) && trim(strtolower($_SERVER["HTTP_REFERER"]), '/')) {
                    $url = $_SERVER["HTTP_REFERER"];
                    $prodidcode = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductId(); 
                    if(in_array($url,$referer)) {
                        $querycode = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT couponcode from [|PREFIX|]coupons
                                            where ( couponcode = 'FX4598' OR couponcode = 'FX3222' OR couponcode = 'FX3343' OR couponcode = 'FX4599' ) 
                                            AND ( couponappliestovalues = '$prodidcode' ||  couponappliestovalues REGEXP '^$prodidcode,' ||  
                                            couponappliestovalues REGEXP ',$prodidcode,' ||  couponappliestovalues REGEXP ',$prodidcode' )");
                        $rowcode = $GLOBALS["ISC_CLASS_DB"]->Fetch($querycode);
                        $coupon = $rowcode['couponcode'];
                        $GLOBALS['Promotion'] = '1';
						if($coupon != "")
						{
							$GLOBALS['PopupCoupon'] = "<script>alert('The coupon code ".$coupon." will be applied to your cart. If you choose to purchase this product, the final discounted price will be reflected at checkout.');</script>";
						}
                    }
                    else {
                        $GLOBALS['Promotion'] = '0';
                    }
                }
                else {
                    $GLOBALS['Promotion'] = '0';
                }
                /* Baskaran */
if ($GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice() > $GLOBALS['ISC_CLASS_PRODUCT']->GetRetailPrice())           
				{
$GLOBALS['SNIPPETS']['ProductAddToCart'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductAddToCart1");
				}
				else
				{ 
$GLOBALS['SNIPPETS']['ProductAddToCart'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductAddToCart");
				} 

                //Added by Simha
                if(isc_strtolower($GLOBALS['ISC_CLASS_PRODUCT']->IsTestData())=='yes')  {
                    $GLOBALS['SNIPPETS']['ProductAddToCart'] = "<hr>".GetLang('ThisIsTestData');
                }
                
				//blessen                        
				// original $GLOBALS['SNIPPETS']['ProductAddToCart'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductAddToCart");
			}
             
			$price_for_shipping = $GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice();   
            //blessen 
            //$GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice() replaced by GetPrice                                                                          
            if($GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice() > $GLOBALS['ISC_CLASS_PRODUCT']->GetRetailPrice() && (float)$GLOBALS['ISC_CLASS_PRODUCT']->GetRetailPrice() > 0)
			{           
				$price_for_shipping = $GLOBALS['ISC_CLASS_PRODUCT']->GetRetailPrice();
                $GLOBALS['ProductPrice'] = CurrencyConvertFormatPrice($GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice());
                $GLOBALS['ProductPrice'] = "<strike>".$GLOBALS['ProductPrice']."</strike>&nbsp;&nbsp;<b alt='Price may be adjusted. Add to your cart and see the final price.'  Title='Price may be adjusted. Add to your cart and see the final price.'>(".GetLang('CheckPriceInCart').")</b>";                                                                                             
			}  
                    
            if($GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice() > $DiscountPrice && $discounttype == 1)
            {           
				$price_for_shipping = $DiscountPrice;
                $GLOBALS['ProductPrice'] = CurrencyConvertFormatPrice($GLOBALS['ISC_CLASS_PRODUCT']->GetFinalPrice());
                $GLOBALS['ProductPrice'] = "<strike>".$GLOBALS['ProductPrice']."</strike>&nbsp;&nbsp;<b alt='Price may be adjusted. Add to your cart and see the final price.'  Title='Price may be adjusted. Add to your cart and see the final price.'>(".GetLang('CheckPriceInCart').")</b>";                                                                                             
            } 
            
            $GLOBALS['ShowOnSaleImage'] = '';
            
            if(isset($DiscountPrice) && $discounttype==0 && ($DiscountPrice < $FinalPrice))    {
                //&& GetConfig('ShowOnSale')
				$price_for_shipping = $DiscountPrice;
                $GLOBALS['ProductPrice']    = "<strike>".CurrencyConvertFormatPrice($FinalPrice)."</strike>";       
                $GLOBALS['DiscountPrice']   = "".CurrencyConvertFormatPrice($DiscountPrice).""; 
                    if(GetConfig('ShowOnSale'))    {
						if(strtolower($discountname) == "clearance")
						{
							$GLOBALS['ShowOnSaleImage'] = '<img id="OnSale" src="'.GetConfig('ShopPath').'/templates/default/images/clearance.gif" alt="">';                  
						}
						else
						{
							$GLOBALS['ShowOnSaleImage'] = '<img id="OnSale" src="'.GetConfig('ShopPath').'/templates/default/images/onsale.gif" alt="">';
						}
                    }
                }
			
			$price = 0;
			$upper_price = 0;
			$shipping_qry = "SELECT variablename, variableval FROM isc_shipping_vars WHERE methodid='1' AND modulename='shipping_bytotal' AND ( variablename LIKE 'cost_0' OR variablename LIKE 'lower_0' OR variablename LIKE 'upper_0' )";
			$shipping_res = $GLOBALS['ISC_CLASS_DB']->Query($shipping_qry);
			while($shipping_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($shipping_res))
			{
				if($shipping_arr['variablename'] == 'cost_0')
					$price = $shipping_arr['variableval'];

				if($shipping_arr['variablename'] == 'upper_0')
					$upper_price = $shipping_arr['variableval'];
			}

			if($price_for_shipping < $upper_price)
				$GLOBALS['ShippingPrice'] = "$".$price;
			else
				$GLOBALS['ShippingPrice'] = "Ships Freight Free, see <a href='".$GLOBALS['ShopPath']."/pages/8'>policy</a> for details";
              
//blessen
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($GLOBALS['ISC_CLASS_PRODUCT']->BuildTitle());
		}
        /*
		function BuildOption($selected = 1) {
            $select = "<select name='compqty[]' id='compqty'>";
            $options = '';
            for($i=1; $i<31; $i++){
                $sel = '';
                if($selected == $i) {
                    $sel = 'selected="selected"';
                }
                $options .= '<option value='.$i.' '.$sel.'>'.$i.'</option>';
            }
            $select = $select.$options."</select>";
            return $select;
        }
        */
        
        
        public function BuildOption($name, $selected=0) {
            $select = "<select name='$name' id='compqty'>";
            $options = '';
            for($i=0; $i<30; $i++){
                $sel = '';
                if($selected == ($i+1)) {
                    $sel = 'selected="selected"';
                }
                $options .= '<option value='.($i+1).' '.$sel.'>'.($i+1).'</option>';
            }
            $select = $select.$options."</select>";
            return $select;
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