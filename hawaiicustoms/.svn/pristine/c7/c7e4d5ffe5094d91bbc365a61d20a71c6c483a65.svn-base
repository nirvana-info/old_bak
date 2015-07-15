<?php

	CLASS ISC_CARTCONTENT_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{

			$_SESSION['you_save'] = 0;  //blessen

			$GLOBALS['SNIPPETS']['CartItems'] = "";

			$count = 0;
			$subtotal = 0;

			$_SESSION['CHECKOUT'] = array();

			// Get a list of all products in the cart
			$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
			$GLOBALS['ISC_CLASS_CART']->api->RemoveGoogleCheckoutCouponFlag(); // Added for google cehckout remove link
			$product_array = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart();

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
			if(gzte11(ISC_MEDIUMPRINT) && $GLOBALS['ISC_CLASS_CART']->api->GetNumPhysicalProducts() > 1 && $ShowCheckoutButton && GetConfig("MultipleShippingAddresses")) {
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

			$comptotal = 0; # To get all the complementary product total -- Baskaran
            $compprice = 0;
                                   
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

					$GLOBALS['SNIPPETS']['CartItems'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CartItemGiftCertificate");
				}
				// Normal product in the cart - show a product row
				else {
//					$GLOBALS['ProductLink'] = ProdLink($product['data']['prodname']);
//                    echo $GLOBALS['ProductLink'];exit;
                    if ($GLOBALS['EnableSEOUrls'] == 1) {
                        $symbol = '/';
                        $make = ''; $model = ''; $year = '';
                        if(($product['make']!='') or ($product['make']!='') or ($product['make']!='')) {
                            if($product['make'] != '') {
                                $make = "make=".MakeURLSafe($product['make']).$symbol;
                            }
                            if($product['model'] != '') {
                                $model = "model=".MakeURLSafe($product['model']);
                            }
                            if($product['year'] != '') {
                                $year = "year=".$product['year'].$symbol;
                            }
                            $GLOBALS['ProductLink'] = ProdLink($product['data']['prodname']).$symbol."refer=true".$symbol.$year.$make.$model;
                        }
                        else {
                            $GLOBALS['ProductLink'] = ProdLink($product['data']['prodname']);
                        }
                    } else {
                        $symbol = '&';
                        $make = ''; $model = ''; $year = '';
                        if(($product['make']!='') or ($product['make']!='') or ($product['make']!='')) {
                        if($product['make'] != '') {
                            $make = "make=".MakeURLSafe($product['make']).$symbol;
                        }
                        if($product['model'] != '') {
                            $model = "model=".MakeURLSafe($product['model']);
                        }
                        if($product['year'] != '') {
                            $year = "year=".$product['year'].$symbol;
                        }
                        $GLOBALS['ProductLink'] = ProdLink($product['data']['prodname']).$symbol."refer=true".$symbol.$year.$make.$model;
                        }
                        else {
                            $GLOBALS['ProductLink'] = ProdLink($product['data']['prodname']);
                        }
                    }
					$GLOBALS['ProductAvailability'] = isc_html_escape($product['data']['prodavailability']);
					$GLOBALS['ItemId'] = (int) $product['data']['productid'];
					$GLOBALS['VariationId'] = (int) $product['variation_id'];
					$GLOBALS['ProductQuantity'] = (int) $product['quantity'];

//blessen
				$GLOBALS['prodretailprice'] =  CurrencyConvertFormatPrice($product['data']['prodretailprice']);  

if  ($product['data']['prodretailprice'] > $product['data']['prodcalculatedprice'])
				$_SESSION['you_save'] +=  ($product['data']['prodretailprice'] - $product['data']['prodcalculatedprice']) *  $product['quantity'];  


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

					$GLOBALS['EventDate'] = '';
					if (isset($product['event_date'])) {
						$GLOBALS['EventDate'] = '<div style="font-style: italic; font-size:10px; color:gray">(' . $product['event_name'] . ': ' . isc_date('M jS Y', $product['event_date']) . ')</div>';
					}

					// Can this product be wrapped?
					$GLOBALS['GiftWrappingName'] = '';
					$GLOBALS['HideGiftWrappingAdd'] = '';
					$GLOBALS['HideGiftWrappingEdit'] = 'display: none';
					$GLOBALS['HideGiftWrappingPrice'] = 'display: none';
					$GLOBALS['GiftWrappingPrice'] = '';
					$GLOBALS['GiftMessagePreview'] = '';
					$GLOBALS['HideGiftMessagePreview'] = 'display: none';
					$GLOBALS['HideWrappingOptions'] = 'display: none';

					if($product['data']['prodtype'] == PT_PHYSICAL && $product['data']['prodwrapoptions'] != -1 && $publicWrappingOptions == true) {
						$GLOBALS['HideWrappingOptions'] = '';

						if(isset($product['wrapping'])) {
							$GLOBALS['GiftWrappingName'] = isc_html_escape($product['wrapping']['wrapname']);
							$GLOBALS['HideGiftWrappingAdd'] = 'display: none';
							$GLOBALS['HideGiftWrappingEdit'] = '';
							$GLOBALS['HideGiftWrappingPrice'] = '';
							$wrappingAdjustment += $product['wrapping']['wrapprice']*$product['quantity'];
							$GLOBALS['GiftWrappingPrice'] = CurrencyConvertFormatPrice($product['wrapping']['wrapprice']);
							if(isset($product['wrapping']['wrapmessage'])) {
								if(isc_strlen($product['wrapping']['wrapmessage']) > 30) {
									$product['wrapping']['wrapmessage'] = substr($product['wrapping']['wrapmessage'], 0, 27).'...';
								}
								$GLOBALS['GiftMessagePreview'] = isc_html_escape($product['wrapping']['wrapmessage']);
								if($product['wrapping']['wrapmessage']) {
									$GLOBALS['HideGiftMessagePreview'] = '';
								}
							}
						}
					}

					$subtotalPrice = 0;
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

                    // Add if by NI_20100830_Jack
                    $GLOBALS['CGC_ShowOnSaleImage'] = '';
					if(count($product['appliedcgc'])){
                        //$GLOBALS['ProductTotal'] = sprintf("<s class='CartStrike'>%s</s> %s", CurrencyConvertFormatPrice(($subtotalPrice * $product['quantity'])), CurrencyConvertFormatPrice(($subtotalPrice * $product['quantity'])));   
					$GLOBALS['ProductTotal'] = CurrencyConvertFormatPrice(($subtotalPrice * $product['quantity']));
                        $GLOBALS['CGC_ShowOnSaleImage'] = "CGC Applied"; 
                    }else{
					    $GLOBALS['ProductTotal'] = CurrencyConvertFormatPrice(($subtotalPrice * $product['quantity']));
                    }

					$itemTotal += $subtotalPrice * $product['quantity'];

					// If we're using a cart quantity drop down, load that
					if (GetConfig('TagCartQuantityBoxes') == 'dropdown') {
						$GLOBALS["Quantity" . $product['quantity']] = "selected=\"selected\"";
						if(isset($GLOBALS["Quantity0"])) {
							$GLOBALS['QtyOptionZero'] = "<option ".$GLOBALS["Quantity0"]." value='0'>0</option>";
						}
						else {
							$GLOBALS['QtyOptionZero'] = "<option value='0'>0</option>";
						}

						// Fixes products being displayed with '0' quantity when the quantity is greater than 30 (hard coded limit in snippet)
						if ($product['quantity'] > 30) {
							$GLOBALS["QtyOptionSelected"] = "<option ".$GLOBALS["Quantity" . $product['quantity']]." value='" . $product['quantity'] . "'>" . $product['quantity'] . "</option>";
						}

						$GLOBALS['CartItemQty'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CartItemQtySelect");
					}
					// Otherwise, load the textbox
					else {
						$GLOBALS['CartItemQty'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CartItemQtyText");
					}

					// Is this product a variation?
					$GLOBALS['ProductOptions'] = '';
					if(isset($product['options']) && !empty($product['options'])) {
						$GLOBALS['ProductOptions'] .= "<br /><small>(";
						$comma = '';
						foreach($product['options'] as $name => $value) {
							if(!trim($name) || !trim($value)) {
								continue;
							}
							$GLOBALS['ProductOptions'] .= $comma.isc_html_escape($name).": ".isc_html_escape($value);
							$comma = ', ';
						}
						$GLOBALS['ProductOptions'] .= ")</small>";
					}

					
					//temp script to shortern the product name
					$pid  = $product['data']['productid'];
					$pcode  = $product['data']['prodcode'];
					$querytemp = "SELECT prodbrandid FROM  [|PREFIX|]products where productid = ".$pid."  ";
					$resulttemp = $GLOBALS['ISC_CLASS_DB']->Query($querytemp);
					$brand = $GLOBALS['ISC_CLASS_DB']->Fetch($resulttemp);

					if ($brand['prodbrandid'] == 37)
					{
						$querytemp1 = "SELECT c.catname, c.catcombine FROM [|PREFIX|]categories 	c left join [|PREFIX|]categoryassociations ca on c.categoryid = ca.categoryid  left join [|PREFIX|]products p on ca.productid = p.productid where p.productid =  '".$pid."' ";
						$resulttemp1 = $GLOBALS['ISC_CLASS_DB']->Query($querytemp1);
						$cat = $GLOBALS['ISC_CLASS_DB']->Fetch($resulttemp1);

						if ($cat['catcombine'] != "")
						$GLOBALS['ProductName'] = $cat['catcombine']." Part Number ".$pcode;
						else
						$GLOBALS['ProductName'] = $cat['catname']." Part Number ".$pcode;
					}
					else
					{
						$GLOBALS['ProductName'] = isc_html_escape($product['data']['prodname']);
					}
					//temp script to shortern the product name

					//temp script to shortern the product name
                    $GLOBALS['complementaryrow']    = '';
                    $compitem                       = $product['compitem'];
                                               
                    if($compitem == 1) { 
                        for($y=0; $y<count($product['complementary']); $y++)   {
                            /* Added for to display the complementary product in the cart -- Baskaran */ 
                            $compproductid      = $product['complementary'][$y]['comp_productid'];
                            $compmainproductid  = $product['complementary'][$y]['comp_mainproductid'];
                            $mainproductid      = $product['product_id'];
                            $GLOBALS['CompCartItemId']  = $y;

                            if($mainproductid == $compmainproductid)    { 
                                $GLOBALS['CompProdName'] = $compprodname = isc_html_escape($product['complementary'][$y]['comp_product_name']);
                                $compsku = isc_html_escape($product['complementary'][$y]['comp_product_code']);
                                $compprice = $product['complementary'][$y]['comp_original_price'];
                                $GLOBALS['CompProductPrice'] = $comppriceformat = CurrencyConvertFormatPrice($product['complementary'][$y]['comp_original_price']);
                                $query = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT imagefile FROM [|PREFIX|]products p LEFT JOIN [|PREFIX|]product_images i ON p.productid = i.imageprodid AND i.imageisthumb = '1' where p.productid = '$compproductid' AND p.prodvisible = '1' ");
                                $path = '';
                                if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($query)) {
                                    $path = $row['imagefile'];
                                }
                                if($path != '')
                                {
                                    //$GLOBALS['ProdImage'] = GetConfig('ShopPath')."/product_images/$path";
									$GLOBALS['ProdImage'] = $this->ImageThumb($path);
                                }
                                else {
                                    $GLOBALS['ProdImage'] = GetConfig('ShopPath')."/templates/CongoWorld/images/ProductDefault.gif";
                                }

                                //Added for complementary products - By Simha..
                                // If we're using a cart quantity drop down, load that
                                if (GetConfig('TagCartQuantityBoxes') == 'dropdown') {
                                    $GLOBALS["CompQuantity" . $product['complementary'][$y]['quantity']] = "selected=\"selected\"";
                                    if(isset($GLOBALS["Quantity0"])) {
                                        $GLOBALS['CompCartQtyOptionZero'] = "<option ".$GLOBALS["Quantity0"]." value='0'>0</option>";
                                    }
                                    else {
                                        $GLOBALS['CompCartQtyOptionZero'] = "<option value='0'>0</option>";
                                    } 
                                                                        
                                    //alandy_2011-8-10 modify.comp limit.
                                    if(isset($_SESSION['complementary'][$product['complementary'][$y]['comp_productid']]['limit']) && $_SESSION['complementary'][$product['complementary'][$y]['comp_productid']]['limit']>0){
                                    	$limitcomp=$_SESSION['complementary'][$product['complementary'][$y]['comp_productid']]['limit'];
                                    }else{
                                    	$limitcomp=10;
                                    }
                                    
                                    $str="";
                                    
                                    for($i=1;$i<=$limitcomp;$i++){
                                    	if($i==$product['complementary'][$y]['quantity']){
                                    		$str .= "<option selected value=".$i.">".$i."</option>"; 
                                    	}else{
                                    		$str .= "<option value=".$i.">".$i."</option>";
                                    	}
                                    }
                                    $GLOBALS['Compoption']=$str;
                                     
                                    // Fixes products being displayed with '0' quantity when the quantity is greater than 30 (hard coded limit in snippet)
                                    if ($product['quantity'] > 10) {                            //Needed to be changed for the complementary
                                        $GLOBALS["CompCartQtyOptionSelected"] = "<option ".$GLOBALS["Quantity" . $product['complementary'][$y]['quantity']]." value='" . $product['complementary'][$y]['quantity'] . "'>" . $product['complementary'][$y]['quantity'] . "</option>";
                                    }

                                    $GLOBALS['CompCartItemQty'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CompItemQtySelect");
                                }
                                // Otherwise, load the textbox
                                else {
                                    $GLOBALS['CompCartItemQty'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CompItemQtyText");
                                }       
                                //Added for complementary products Ends - By Simha..
                                
                                $GLOBALS['CompProductTotal'] = CurrencyConvertFormatPrice(($compprice * $product['complementary'][$y]['quantity']));
                                $GLOBALS['complementaryrow'].= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ComplementaryItem"); 

                                $comptotal += $compprice * $product['complementary'][$y]['quantity'];
                            }
                            $GLOBALS["CompQuantity" . $product['complementary'][$y]['quantity']] = "";
                        }
                    }
                    /* Code Ends */

					//$GLOBALS['ProductName'] = isc_html_escape($product['data']['prodname']);

					//blessen
					$withoutdollar = str_replace("$", "", $GLOBALS['prodretailprice']);
					if (intval($withoutdollar) <=  0 )
							{
							$GLOBALS['SNIPPETS']['CartItems'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CartItem");
							}
							else
							{
							$GLOBALS['SNIPPETS']['CartItems'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CartItem1");
							}
					//blessen

					// original $GLOBALS['SNIPPETS']['CartItems'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CartItem");
				}
				$GLOBALS["Quantity" . $product['quantity']] = "";
			}

			if($wrappingAdjustment > 0) {
				$GLOBALS['GiftWrappingTotal'] = CurrencyConvertFormatPrice($wrappingAdjustment);
			}
			else {
				$GLOBALS['HideGiftWrappingTotal'] = 'display: none';
			}

			$GLOBALS['HideAdjustedTotal'] = "none";

			$GLOBALS['AdjustedCartSubTotal'] = $GLOBALS['CartSubTotal'] - $GLOBALS['CartSubTotalDiscount'];
			$itemTotal += $comptotal; # Baskaran
			$GLOBALS['CartItemTotal'] = CurrencyConvertFormatPrice($itemTotal);


			$GLOBALS['SNIPPETS']['Coupons'] = '';

			$coupons = $GLOBALS['ISC_CLASS_CART']->api->GetAppliedCouponCodes();
			if (count($coupons)) {
				foreach ($coupons as $coupon) {
					$GLOBALS['CouponId'] = $coupon['couponid'];
					$GLOBALS['CouponCode'] = $coupon['couponcode'];
					//zcs=>append && show coupon-name
					$query = "
						SELECT couponname
						FROM [|PREFIX|]coupons
						WHERE couponid='".$coupon['couponid']."'
					";
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
					$GLOBALS['CouponName'] = $row['couponname'];
					//<=zcs
					// percent coupon
					if ($coupon['coupontype'] == 1) {
						$discount = $coupon['discount'] . "%";
					}
					else {
						$discount = CurrencyConvertFormatPrice($coupon['discount']);
					}
					$GLOBALS['CouponDiscount'] = $discount;

					$GLOBALS['SNIPPETS']['Coupons'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CartCoupon");
				}
			}

			$GLOBALS['SNIPPETS']['CompanyGiftCertificates'] = '';
			// Add by NI_20100826_Jack
			// Has the customer chosen one or more Company gift certificates to apply to this order? We need to show them
			if (isset($_SESSION['CART']['COMPANYGIFTCERTIFICATES']) && is_array($_SESSION['CART']['COMPANYGIFTCERTIFICATES']) && count($_SESSION['CART']['COMPANYGIFTCERTIFICATES'])) {
                $certificates = $_SESSION['CART']['COMPANYGIFTCERTIFICATES'];
                $hash_producttotal = array();
                foreach ($product_array as $k => $product) {
                    $hash_producttotal[$k] = (isset($product['discount_price'])?$product['discount_price']:$product['product_price']) * $product['quantity'];
                    if(isset($product['complementary'])){
                        foreach($product['complementary'] as $compitemtmp){
                            $hash_producttotal[$k] += $compitemtmp['comp_original_price'] * $compitemtmp['quantity'];
                        }
                    }
                }
                uasort($certificates, "CompanyGiftCertificateSort");
                foreach ($certificates as $certificate) {
                    $cgcproductused = 0;
                    $cgcproductremain = $certificate['cgcbalance'];
                    foreach ($product_array as $k => $product) {
                        if($product['appliedcgc'][$certificate['cgcid']]){
                            if($cgcproductremain > $hash_producttotal[$k]){
                                $cgcproductused += $hash_producttotal[$k];
                                $cgcproductremain -= $hash_producttotal[$k];
                                $hash_producttotal[$k] = 0;
                            }else{
                                $cgcproductused += $cgcproductremain;
                                $hash_producttotal[$k] = $hash_producttotal[$k] - $cgcproductremain;
                                $cgcproductremain = 0;
                                break;
                            }
                        }
                    }
					$GLOBALS['CompanyGiftCertificateCode'] = isc_html_escape($certificate['cgccode']);
					$GLOBALS['CompanyGiftCertificateId'] = $certificate['cgcid'];
					$GLOBALS['CompanyGiftCertificateBalance'] = $certificate['cgcbalance'];
//					if ($GLOBALS['CompanyGiftCertificateBalance'] > $GLOBALS['AdjustedCartSubTotal']) {
//						$GLOBALS['CompanyGiftCertificateRemaining'] = $certificate['cgcbalance'] - $GLOBALS['AdjustedCartSubTotal'];
//						$GLOBALS['CompanyCertificateAmountUsed'] = $certificate['cgcbalance'] - $GLOBALS['CompanyGiftCertificateRemaining'];
//					} else {
//						$GLOBALS['CompanyCertificateAmountUsed'] = $certificate['cgcbalance'];
//						$GLOBALS['CompanyGiftCertificateRemaining'] = 0;
//					}
                    $GLOBALS['CompanyGiftCertificateRemaining'] = $cgcproductremain;
                    $GLOBALS['CompanyCertificateAmountUsed'] = $cgcproductused;
					// Subtract this amount from the adjusted total
					//$GLOBALS['AdjustedCartSubTotal'] -= $GLOBALS['CompanyGiftCertificateBalance'];
                    $GLOBALS['AdjustedCartSubTotal'] -= $cgcproductused;
					if ($GLOBALS['AdjustedCartSubTotal'] <= 0) {
						$GLOBALS['AdjustedCartSubTotal'] = 0;
					}
					$GLOBALS['CompanyGiftCertificateBalance'] = CurrencyConvertFormatPrice($GLOBALS['CompanyGiftCertificateBalance']);
					$GLOBALS['CompanyGiftCertificateRemaining'] = CurrencyConvertFormatPrice($GLOBALS['CompanyGiftCertificateRemaining']);
					$GLOBALS['CompanyCertificateAmountUsed'] = CurrencyConvertFormatPrice($GLOBALS['CompanyCertificateAmountUsed']);
					$GLOBALS['SNIPPETS']['CompanyGiftCertificates'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CartCompanyGiftCertificate");
				}
				if ($GLOBALS['SNIPPETS']['CompanyGiftCertificates']) {
					$GLOBALS['HideAdjustedTotal'] = '';
					if ($GLOBALS['AdjustedCartSubTotal'] == 0) {
						$GLOBALS['HidePanels'][] = "SideCompanyGiftCertificateCodeBox";
					}
				}
			}
			$GLOBALS['SNIPPETS']['GiftCertificates'] = '';

			// Has the customer chosen one or more gift certificates to apply to this order? We need to show them
			if (isset($_SESSION['CART']['GIFTCERTIFICATES']) && is_array($_SESSION['CART']['GIFTCERTIFICATES'])) {
				$certificates = $_SESSION['CART']['GIFTCERTIFICATES'];

				uasort($certificates, "GiftCertificateSort");

				foreach ($certificates as $certificate) {
					$GLOBALS['GiftCertificateCode'] = isc_html_escape($certificate['giftcertcode']);
					$GLOBALS['GiftCertificateId'] = $certificate['giftcertid'];
					$GLOBALS['GiftCertificateBalance'] = $certificate['giftcertbalance'];

					if ($GLOBALS['GiftCertificateBalance'] > $GLOBALS['AdjustedCartSubTotal']) {
						$GLOBALS['GiftCertificateRemaining'] = $certificate['giftcertbalance'] - $GLOBALS['AdjustedCartSubTotal'];
						$GLOBALS['CertificateAmountUsed'] = $certificate['giftcertbalance'] - $GLOBALS['GiftCertificateRemaining'];
					} else {
						$GLOBALS['CertificateAmountUsed'] = $certificate['giftcertbalance'];
						$GLOBALS['GiftCertificateRemaining'] = 0;
					}

					// Subtract this amount from the adjusted total
					$GLOBALS['AdjustedCartSubTotal'] -= $GLOBALS['GiftCertificateBalance'];
					if ($GLOBALS['AdjustedCartSubTotal'] <= 0) {
						$GLOBALS['AdjustedCartSubTotal'] = 0;
					}

					$GLOBALS['GiftCertificateBalance'] = CurrencyConvertFormatPrice($GLOBALS['GiftCertificateBalance']);
					$GLOBALS['GiftCertificateRemaining'] = CurrencyConvertFormatPrice($GLOBALS['GiftCertificateRemaining']);
					$GLOBALS['CertificateAmountUsed'] = CurrencyConvertFormatPrice($GLOBALS['CertificateAmountUsed']);

					$GLOBALS['SNIPPETS']['GiftCertificates'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CartGiftCertificate");
				}

				if ($GLOBALS['SNIPPETS']['GiftCertificates']) {
					$GLOBALS['HideAdjustedTotal'] = '';
					if ($GLOBALS['AdjustedCartSubTotal'] == 0) {
						$GLOBALS['HidePanels'][] = "SideGiftCertificateCodeBox";
					}
				}
			}

			if ($GLOBALS['AdjustedCartSubTotal'] != $GLOBALS['CartSubTotal']) {
				$GLOBALS['HideAdjustedTotal'] = "";

				$GLOBALS['AdjustedCartSubTotal'] = CurrencyConvertFormatPrice($GLOBALS['AdjustedCartSubTotal']);
			}
//            $GLOBALS['CartSubTotal'] = CurrencyConvertFormatPrice($GLOBALS['CartSubTotal']); 
            $GLOBALS['CartSubTotal'] = CurrencyConvertFormatPrice($GLOBALS['CartSubTotal'] + $comptotal); # To add the subtotal in the cart -- Baskaran

			$GLOBALS['HideCartSavedTotalText'] =  "display";
			$GLOBALS['CartSaveTotal'] = CurrencyConvertFormatPrice($_SESSION['you_save']);  //blessen
			if ($_SESSION['you_save'] <= 0 )
				 $GLOBALS['HideCartSavedTotalText'] =  "none";

			if (!gzte11(ISC_LARGEPRINT)) {
				$GLOBALS['HidePanels'][] = "SideGiftCertificateCodeBox";
				// Add by 20100826_Jack
				$GLOBALS['HidePanels'][] = "SideCompanyGiftCertificateCodeBox";
			}

			// Are there any products in the cart?
			if ($GLOBALS['ISC_CLASS_CART']->api->GetNumProductsInCart() == 0) {
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
