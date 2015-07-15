<?php
 require_once(ISC_BASE_PATH . "/lib/discountcalcs.php");         
	CLASS ISC_MAKEAOFFERCONTENT_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{

			$_SESSION['you_save'] = 0;  //blessen

			$GLOBALS['SNIPPETS']['OfferItems'] = "";

			$count = 0;
			$subtotal = 0;

			$_SESSION['CHECKOUT'] = array();

			// Get a list of all products in the cart
			$GLOBALS['ISC_CLASS_MAKEAOFFER'] = GetClass('ISC_MAKEAOFFER');
			$product_array = $GLOBALS['ISC_CLASS_MAKEAOFFER']->api->GetProductsInCart();

			$GLOBALS['AdditionalCheckoutButtons'] = '';


			// Go through all the checkout modules looking for one with a GetSidePanelCheckoutButton function defined
			$ShowCheckoutButton = false;
			if (!empty($product_array)) {
				foreach (GetAvailableModules('checkout', true, true) as $module) {
					if(isset($module['object']->_showBothButtons) && $module['object']->_showBothButtons) {
						$ShowCheckoutButton = true;
						$GLOBALS['AdditionalCheckoutButtons'] .= $module['object']->GetCheckoutButton();
					} elseif (method_exists($module['object'], 'GetCheckoutButton')) {
						$GLOBALS['AdditionalCheckoutButtons'] .= $module['object']->GetCheckoutButton();
					} else {
						$ShowCheckoutButton = true;
					}
				}
			}

			$GLOBALS['HideMultipleAddressShipping'] = 'display: none';
			if(gzte11(ISC_MEDIUMPRINT) && $GLOBALS['ISC_CLASS_MAKEAOFFER']->api->GetNumPhysicalProducts() > 1 && $ShowCheckoutButton && GetConfig("MultipleShippingAddresses")) {
				$GLOBALS['HideMultipleAddressShipping'] = '';
			}

			$GLOBALS['HideCheckoutButton'] = '';

			if (!$ShowCheckoutButton) {
				$GLOBALS['HideCheckoutButton'] = 'display: none';
				$GLOBALS['HideMultipleAddressShippingOr'] = 'display: none';
			}

			$wrappingOptions = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('GiftWrapping');
			if(empty($wrappingOptions)) {
				$publicWrappingOptions = false;
			}
			else {
				$publicWrappingOptions = true;
			}

			if(!GetConfig('ShowThumbsInCart')) {
				$GLOBALS['HideThumbColumn'] = 'display: none';
				$GLOBALS['ProductNameSpan'] = 2;
			}
			else {
				$GLOBALS['HideThumbColumn'] = '';
				$GLOBALS['ProductNameSpan'] = 1;
			}

			$wrappingAdjustment = 0;
			$itemTotal = 0;






			foreach ($product_array as $k => $product) {
				$GLOBALS['CartItemId'] = (int) $product['cartitemid'];

				// If the item in the cart is a gift certificate, we need to show a special type of row
				if (isset($product['type']) && $product['type'] == "giftcertificate") {
					$GLOBALS['GiftCertificateName'] = isc_html_escape($product['data']['prodname']);
					$GLOBALS['GiftCertificateAmount'] = CurrencyConvertFormatPrice($product['giftamount']);

					$GLOBALS['GiftCertificateTo'] = isc_html_escape($product['certificate']['to_name']);

					$GLOBALS["Quantity" . $product['quantity']] = 'selected="selected"';

					$GLOBALS['ProductPrice'] = CurrencyConvertFormatPrice($product['giftamount']);
					$GLOBALS['ProductTotal'] = CurrencyConvertFormatPrice($product['giftamount'] * $product['quantity']);

					$itemTotal += $product['giftamount']*$product['quantity'];

									}
					// Normal product in the cart - show a product row

				else {
					$GLOBALS['ProductLink'] = ProdLink($product['data']['prodname']);
					//$GLOBALS['ProductAvailability'] = isc_html_escape($product['data']['prodavailability']);
					$GLOBALS['ItemId'] = (int) $product['data']['productid'];
					$GLOBALS['VariationId'] = (int) $product['variation_id'];
					$GLOBALS['ProductQuantity'] = (int) $product['quantity'];

				//blessen
				$GLOBALS['prodretailprice'] =  CurrencyConvertFormatPrice($product['data']['prodretailprice']);  

				


				//$GLOBALS['saveprice'] =  CurrencyConvertFormatPrice($product['data']['prodretailprice'] - $product['data']['prodcalculatedprice']);  
				//blessen


					// Should we show thumbnails in the cart?
					if (GetConfig('ShowThumbsInCart')) {
						$GLOBALS['ProductImage'] = $this->ImageThumb($product['data']['imagefile'], ProdLink($product['data']['prodname']));
					}

					$GLOBALS['UpdateCartQtyJs'] = "Cart.UpdateQuantity(this.options[this.selectedIndex].value);";

					$GLOBALS['HideCartProductFields'] = 'display:none;';
					$GLOBALS['CartProductFields'] = '';
					$this->GetProductFieldDetails($product['product_fields'], $k);

									

					if($product['data']['prodtype'] == PT_PHYSICAL && $product['data']['prodwrapoptions'] != -1 && $publicWrappingOptions == true) {
						$GLOBALS['HideWrappingOptions'] = '';

						
					}

					$subtotalPrice = 0;
					$discounttype = 0;
					 $prodid = $product['data']['productid'];
				
				

$querytemp1 = "SELECT c.categoryid FROM [|PREFIX|]categories  c left join [|PREFIX|]categoryassociations ca on c.categoryid = ca.categoryid  left join [|PREFIX|]products p on ca.productid = p.productid where p.productid =  '".$prodid."' ";
$resulttemp1 = $GLOBALS['ISC_CLASS_DB']->Query($querytemp1);
$catid = $GLOBALS['ISC_CLASS_DB']->FetchOne($resulttemp1); 

$querytemp1 = "SELECT brandseriesid FROM [|PREFIX|]products where productid =  '".$prodid."' ";
$resulttemp1 = $GLOBALS['ISC_CLASS_DB']->Query($querytemp1);
 $brandseriesid = $GLOBALS['ISC_CLASS_DB']->FetchOne($resulttemp1); 



$product['discount_price'] = CalculateDiscountPrice($product['product_price'], $product['product_price'], $catid, $brandseriesid, $discounttype);       

// client telling that retails price should less than product price. 
if ($product['data']['prodretailprice'] > 0 and  $product['discount_price'] > 0)
					{
if ($product['data']['prodretailprice'] < $product['discount_price']  )
		$product['discount_price'] = $product['data']['prodretailprice'];
					}


					if (isset($product['discount_price'])) {
						$subtotalPrice = $product['discount_price'];
					} else {
						$subtotalPrice = $product['product_price'];
					}
                    
                    $GLOBALS['ShowOnSaleImage'] = '';
                    
					if (isset($product['discount_price']) && $product['discount_price'] != $product['original_price'] && GetConfig('ShowOnSale')) {
						$GLOBALS['ProductPrice'] = sprintf("<s class='CartStrike'>%s</s> %s", CurrencyConvertFormatPrice($product['original_price']), CurrencyConvertFormatPrice($subtotalPrice));   
                        if(isset($product['discount']) && isset($product['couponcode']))    {
                            $GLOBALS['ShowOnSaleImage'] = "Coupon Applied"; 
                        }
                        else    {
                            $GLOBALS['ShowOnSaleImage'] = '<img id="OnSale" src="'.GetConfig('ShopPath').'/templates/default/images/onsale.gif" alt="">';                                      
                        }
					} else {
						$GLOBALS['ProductPrice'] = CurrencyConvertFormatPrice($subtotalPrice);
					}
		
					if (isset($_SESSION['the_offered_price']))
					{			
					$GLOBALS['offerprice'] = $_SESSION['the_offered_price'];
					$GLOBALS['ProductTotal'] = CurrencyConvertFormatPrice(($_SESSION['the_offered_price']));
					$itemTotal = $_SESSION['the_offered_price'];
					$GLOBALS['CartItemQty'] = 1;
					$GLOBALS['userclicked'] = "yes";
					}
					else
					{
					$GLOBALS['ProductTotal'] = CurrencyConvertFormatPrice($subtotalPrice);
					$GLOBALS['CartItemQty'] = 1;
					//$GLOBALS['CartItemTotal'] = CurrencyConvertFormatPrice($subtotalPrice);
					}
					

					$GLOBALS['actualprice'] = $subtotalPrice ;	
					if (isset($_SESSION['the_offered_price']))
					{

					//$_SESSION['you_save'] +=  $product['data']['prodcalculatedprice'] - $_SESSION['the_offered_price'] ;  
					$_SESSION['you_save'] +=  $subtotalPrice - $_SESSION['the_offered_price'] ;  
					}	
									
					$GLOBALS['ProductName'] = isc_html_escape($product['data']['prodname']);

					
				$GLOBALS['SNIPPETS']['OfferItems'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("Offeritem");
							

					
				}
				$GLOBALS["Quantity" . $product['quantity']] = "";
			}





			//$GLOBALS['CartItemTotal'] = CurrencyConvertFormatPrice($itemTotal);


			
			

		

			
			if (isset($_SESSION['the_offered_price']))
			$GLOBALS['CartSubTotal'] = CurrencyConvertFormatPrice($_SESSION['the_offered_price']);
			else
			$GLOBALS['CartSubTotal'] = CurrencyConvertFormatPrice($GLOBALS['CartSubTotal']);


			$GLOBALS['CartSaveTotal'] = CurrencyConvertFormatPrice($_SESSION['you_save']);  //blessen
            /* Added for to hide the "You save" label and value -- Baskaran */
            if($_SESSION['you_save'] != '0.00') { 
               $GLOBALS['HideSaveTotal'] = '';
            }
            else {                  
                $GLOBALS['HideSaveTotal'] = "none";
            }            
            /* Baskaran */
			if (!gzte11(ISC_LARGEPRINT)) {
				$GLOBALS['HidePanels'][] = "SideGiftCertificateCodeBox";
			}

			// Are there any products in the cart?
			if ($GLOBALS['ISC_CLASS_MAKEAOFFER']->api->GetNumProductsInCart() == 0) {
				$GLOBALS['HideShoppingCartGrid'] = "none";
			} else {
				$GLOBALS['HideShoppingCartEmptyMessage'] = "none";
			}
		}

		public function GetProductFieldDetails($productFields, $cartItemId)
		{
			// custom product fields on cart page
			$GLOBALS['HideCartProductFields'] = 'display:none;';
			$GLOBALS['CartProductFields'] = '';
			if(isset($productFields) && !empty($productFields) && is_array($productFields)) {
				$GLOBALS['HideCartProductFields'] = '';
				foreach($productFields as $filedId => $field) {

					switch ($field['fieldType']) {
						//field is a file
						case 'file': {

							//file is an image, display the image
							$fieldValue = '<a target="_Blank" href="'.$GLOBALS['ShopPath'].'/viewfile.php?cartitem='.$cartItemId.'&prodfield='.$filedId.'">'.isc_html_escape($field['fileOriginName']).'</a>';
							break;
						}
						//field is a checkbox
						case 'checkbox': {
							$fieldValue = GetLang('Checked');
							break;
						}
						//if field is a text area or short text display first
						default: {
							if(isc_strlen($field['fieldValue'])>50) {
								$fieldValue = isc_substr(isc_html_escape($field['fieldValue']), 0, 50)." ..";
							} else {
								$fieldValue = isc_html_escape($field['fieldValue']);
							}
						}
					}
					if(trim($fieldValue) != '') {
						$GLOBALS['CartProductFields'] .= '<dt> <img style="vertical-align: middle;" src="'.$GLOBALS['TPL_PATH'].'/images/NodeJoin.gif" /> '.isc_html_escape($field['fieldName']).':</dt>';
						$GLOBALS['CartProductFields'] .= '<dd>'.$fieldValue.'</dd>';
					}
				}
			}
		}

		public function ImageThumb($thumb, $link='', $target='')
		{
			$width = "";
			$height="";

			if(!$thumb) {
				switch(GetConfig('DefaultProductImage')) {
					case 'template':
						$thumb = GetConfig('ShopPath').'/templates/'.GetConfig('template').'/images/ProductDefault.gif';
						break;
					case '':
						$thumb = '';
						break;
					default:
						$thumb = GetConfig('ShopPath').'/'.GetConfig('DefaultProductImage');
				}
			}
			else {

				$file = realpath(ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/'.$thumb);

				if($thumb != '' && file_exists($file))
				{
					$attribs = @getimagesize($file);
					$width = $attribs[0];
					$height = $attribs[1];
					$width_str = "";

					if($width > 150) // width of the image
					{
						$height = ceil((150/$width)*$height);
						$width = 150;
					}
					
					if($height > 150) // height of the image
					{
						$width = ceil((150/$height)*$width);
						$height = 150;
					}
				}
				$thumb = $GLOBALS['ShopPath'].'/'.GetConfig('ImageDirectory').'/'.$thumb;
			}

			if(!$thumb) {
				return '';
			}

			if($target != '') {
				$target = 'target="'.$target.'"';
			}

			$imageThumb = '';
			if($link != '') {
				$imageThumb .= '<a href="'.$link.'" '.$target.'>';
			}

			$imageThumb .= '<img src="'.$thumb.'" alt="" width="'.$width.'" height="'.$height.'" />';

			if($link != '') {
				$imageThumb .= '</a>';
			}

			return $imageThumb;
		}
	}

?>
