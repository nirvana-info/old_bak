<?php
class ISC_ADMIN_CART_API extends ISC_CART_API
{
	/**
	 * Load all of the products from an order in to the cart session.
	 *
	 * @param int The ID of the order to pull the items from.
	 */
	public function LoadInOrderItems($orderId)
	{
        require_once ISC_BASE_PATH . '/lib/discountcalcs.php';
        
		$this->cartSession['NUM_ITEMS'] = 0;
		// Load any products in the order and set them up in the session
		$query = "
			SELECT a.*,b.*,c.prodsaleprice
			FROM [|PREFIX|]order_products a LEFT JOIN [|PREFIX|]user_ymm b ON a.orderymmid=b.id
			LEFT JOIN [|PREFIX|]products c ON a.ordprodid=c.productid 
			WHERE orderorderid='".(int)$orderId."'
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($product = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$cartItem = array(
				'product_id' => $product['ordprodid'],
				'variation_id' => $product['ordprodvariationid'],
				'options' => @unserialize($product['ordprodoptions']),
				'quantity' => $product['ordprodqty'],
				'original_quantity' => $product['ordprodqty'],
				'product_name' => $product['ordprodname'],
			    
			    //alandy_20110422 add discount price,resolve saleprice when the admin edit order calculate totalamount error!
			   	//'product_price' => $product['ordprodoriginalcost'],
			   	//'product_price' => ($product['prodsaleprice']<$product['ordprodoriginalcost'])&&($product['prodsaleprice']>0)?$product['prodsaleprice']:$product['ordprodoriginalcost'],
				'product_price' => ($product['ordprodcost']<$product['ordprodoriginalcost'])&&($product['ordprodcost']>0)?$product['ordprodcost']:$product['ordprodoriginalcost'],
				
				'original_price' => $product['ordoriginalprice'],
				'bulkdiscount_type' => '',
				'bulkdiscount' => '',
				'product_code' => $product['ordprodsku'],
				'type' => $product['ordprodtype'],
				'refunded_qty' => $product['ordprodrefunded'],
				'product_fields' => array(),
				'event_name' => $product['ordprodeventname'],
				'event_date' => $product['ordprodeventdate'],
				'existing_order_product' => $product['orderprodid'],
				'year' =>$product['year'],
				'make'=>$product['make'],
				'model' => $product['model']
			);
			switch ($product['ordprodtype']) {
				case "physical":
					$prodtype = PT_PHYSICAL;
					break;
				case "digital":
					$prodtype = PT_DIGITAL;
					break;
				case "giftcertificate":
					$prodtype = PT_GIFTCERTIFICATE;
					break;
			}
			$cartItem['data'] = array(
				'prodname' => $product['ordprodname'],
				'prodtype' => $prodtype,
				'prodcostprice' => $product['ordprodcostprice'],
				'prodvariationid' => $product['ordprodvariationid'],
				'prodistaxable' => $product['ordprodistaxable'],
				'prodfixedshippingcost' => $product['ordprodfixedshippingcost'],
				'prodwrapoptions' => 0,
				'prodinvtrack' => 0,
				'prodwidth' => 0,
				'prodheight' => 0,
				'proddepth' => 0,
				'prodweight' => 0
			);
			if($product['ordprodwrapname'] != '') {
				$cartItem['wrapping'] = array(
					'wrapid' => $product['ordprodwrapid'],
					'wrapname' => $product['ordprodwrapname'],
					'wrapprice' => $product['ordprodwrapcost'],
					'wrapmessage' => $product['ordprodwrapmessage']
				);
				$cartItem['data']['prodwrapoptions'] = $product['ordprodwrapid'];
			}

			// check if this product exists and apply other data
			$query = "SELECT * FROM [|PREFIX|]products WHERE productid = " . $cartItem['product_id'];
			$rescheck = $GLOBALS['ISC_CLASS_DB']->Query($query);
			if ($checkProduct = $GLOBALS['ISC_CLASS_DB']->Fetch($rescheck)) {
				$loadFields = array('prodinvtrack', 'prodcurrentinv', 'prodfreeshipping', 'prodwidth', 'prodheight', 'proddepth', 'prodweight');
				foreach ($loadFields as $field) {
					$cartItem['data'][$field] = $checkProduct[$field];
				}
			}

			$this->cartSession['ITEMS'][$product['orderprodid']] = $cartItem;
			$this->cartSession['NUM_ITEMS'] += $product['ordprodqty'];
		}

		// Load any configurable fields and apply them too
		$query = "
			SELECT *
			FROM [|PREFIX|]order_configurable_fields
			WHERE orderid='".(int)$orderId."'
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($configurableField = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			if(!isset($this->cartSession['ITEMS'][$configurableField['ordprodid']])) {
				continue;
			}

			if($configurableField['fieldtype'] == 'file') {
				$field = array(
					'fieldType' => $configurableField['fieldtype'],
					'fieldName' => $configurableField['fieldname'],
					'fileType' => $configurableField['filetype'],
					'fileOriginName' => $configurableField['originalfilename'],
					'fileName' => $configurableField['filename'],
					'fieldExisting' => true,
				);
			}
			else {
				$field = array(
					'fieldType' => $configurableField['fieldtype'],
					'fieldName' => $configurableField['fieldname'],
					'fieldValue' => $configurableField['textcontents']
				);
			}

			$this->cartSession['ITEMS'][$configurableField['ordprodid']]['product_fields'][$configurableField['fieldid']] = $field;
		}

		// load coupons
		$query = "
			SELECT *
			FROM [|PREFIX|]order_coupons
			WHERE ordcouporderid='".(int)$orderId."'
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($coupon = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$this->cartSession['ITEMS'][$coupon['ordcoupprodid']]['discount'] = $coupon['ordcouponamount'];
			$this->cartSession['ITEMS'][$coupon['ordcoupprodid']]['couponcode'] = $coupon['ordcouponcode'];
			$this->cartSession['ITEMS'][$coupon['ordcoupprodid']]['coupon'] = $coupon['ordcouponid'];
			$this->cartSession['ITEMS'][$coupon['ordcoupprodid']]['coupontype'] = $coupon['ordcoupontype'];
            $this->cartSession['ITEMS'][$coupon['ordcoupprodid']]['exists_order_coupon'] = true;            
		}
        
        // dada.wang 20120409 load cgc
        
        $orderClass = GetClass('ISC_ADMIN_ORDERS');
        $orderData = GetOrder($orderId);
        
        $this->cartSession['COMPANYGIFTCERTIFICATES'] = $orderClass->GetOrderCompanyGiftCertificatesUsed($orderData);
        $this->cartSession['GIFTCERTIFICATES'] = $orderClass->GetOrderGiftCertificatesUsed($orderData);
	}

	public function GetProductsInCart($hardRefresh=true)
	{
		// Just use the cached version if we've already been here before
		if(!empty($this->cartProducts) && $hardRefresh == false) {
			return $this->cartProducts;
		}

		if(!isset($this->cartSession['ITEMS'])) {
			return array();
		}

		$this->cartProducts = $this->cartSession['ITEMS'];

		foreach($this->cartProducts as $itemId => $item) {
			if (isset($item['type']) && $item['type'] == "giftcertificate") {
				continue;
			}

			$hasNormalProducts = true;
		}

		if(isset($hasNormalProducts)) {
			$this->onlyGiftCertificates = false;
		}
		else {
			$this->onlyGiftCertificates = true;
		}

		return $this->cartProducts;
	}

	public function AddItem($productId, $quantity=1, $variationDetails=null, $configurableOptions=array(), $cartItemId=null, $options=array())
	{
		$itemId = parent::AddItem($productId, $quantity, $variationDetails, $configurableOptions, $cartItemId, $options);

		if($itemId === false) {
			return false;
		}

		$item = &$this->cartSession['ITEMS'][$itemId];

		// load up product data for the new item
		$query = "
				SELECT p.productid, prodcurrentinv, prodinvtrack, prodweight, prodwidth, prodheight, prodvariationid,
					proddepth, prodname, prodprice, prodretailprice, prodsaleprice, prodcalculatedprice,
					prodavailability, prodtype, prodcostprice, prodfixedshippingcost, prodfreeshipping, prodoptionsrequired,
					imageisthumb, imagefile, prodistaxable, prodwrapoptions, prodvendorid, prodeventdaterequired, prodeventdatefieldname, ".GetProdCustomerGroupPriceSQL().",
					(SELECT group_concat(ca.categoryid SEPARATOR ',') FROM [|PREFIX|]categoryassociations ca WHERE p.productid=ca.productid) AS categoryids
				FROM [|PREFIX|]products p
				LEFT JOIN [|PREFIX|]product_images pi ON (p.productid=pi.imageprodid AND pi.imageisthumb=1)
				WHERE p.productid = " . $GLOBALS['ISC_CLASS_DB']->Quote($productId);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$item['data'] = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

		// If this item is a variation, load in the weight etc
		if ($variationDetails) {
			$query = "SELECT combinationid, vcproductid, vcthumb, vcweight, vcweightdiff, vcstock
					FROM [|PREFIX|]product_variation_combinations
					WHERE combinationid = " . $GLOBALS['ISC_CLASS_DB']->Quote($variationDetails);

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$variationInfo = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			// Override the thumbnail for this item with the variation thumbnail
			if($variationInfo['vcthumb']) {
				$item['data']['imagefile'] = $variationInfo['vcthumb'];
			}

			if($variationInfo['vcweight'] != 0) {
				$item['data']['prodweight'] = CalcProductVariationWeight($item['data']['prodweight'], $variationInfo['vcweightdiff'], $variationInfo['vcweight']);
			}

			// Store the # of this combination we have in stock
			if($item['data']['prodinvtrack'] == 2) {
				$item['data']['prodcurrentinv'] = $variationInfo['vcstock'];
			}
		}
        
		$this->cartProducts = array();

		return $itemId;
	}
    
    public function UpdateCartProduct($itemId, $product) {
        if(!isset($this->cartSession['ITEMS'][$itemId])) {
			return false;
		}

		$fields = array(
			'product_name' => 'prodname',
			'product_code' => 'prodcode',
//			'product_price' => 'prodprice',
//			'original_price' => 'prodprice'
		);

		$currentPrice = $this->cartSession['ITEMS'][$itemId]['product_price'];

		foreach($fields as $cartField => $productField) {
			if(!isset($product[$productField])) {
				continue;
			}

			$this->cartSession['ITEMS'][$itemId][$cartField] = $product[$productField];
		}

		if(isset($product['prodprice']) && $product['prodprice'] != $currentPrice) {
			$this->cartSession['ITEMS'][$itemId]['custom_price'] = true;
		}

		$this->cartProducts = $this->cartSession['ITEMS'];

		// Update the quantity too if it's present
		if(isset($product['quantity'])) {
			$quantityCheck = 0;
			// only check the difference between the original quantity
			if (isset($this->cartSession['ITEMS'][$itemId]['original_quantity'])) {
				$quantityCheck = $product['quantity'] - $this->cartSession['ITEMS'][$itemId]['original_quantity'];
				if ($quantityCheck < 0) {
					$quantityCheck = 0;
				}
			}

			$ret = $this->UpdateCartQuantity($itemId, $product['quantity'], $quantityCheck);
		}

		$this->cartProducts = array();
        return $ret;
    }
    
    public function GetCartSubTotal($shippableTotal=false, $vendorId=null, $includeDiscounts=true, $includeCertificates=true, $hardRefresh=false)
	{
		if (isset($this->cartSession['SUBTOTAL']) && !$hardRefresh) {
			//return $this->cartSession['SUBTOTAL'];
		}

		$subtotal = 0;
		$products = $this->GetProductsInCart();

		$comptotal = 0;   # Baskaran
		foreach($products as $k => $product) {     


			if(!isset($product['data'])) {
				continue;
			}

			if(!isset($product['data']['prodvendorid'])) {
				$product['data']['prodvendorid'] = 0;
			}

			// If we only want the total for a specific vendor and this product doesn't belong to the vendor, skip over it
			if(!is_null($vendorId) && $vendorId !== $product['data']['prodvendorid']) {
				continue;
			}

			if($shippableTotal == true && $product['data']['prodtype'] == PT_PHYSICAL && $product['data']['prodfixedshippingcost'] > 0) {
				continue;
			}

			if(!$includeCertificates && isset($product['type']) && $product['type'] == 'giftcertificate') {
				continue;
			}

            if(isset($product['discount_price']) && $product['discount_price'] > 0 && $includeDiscounts) {
				$price = $product['discount_price'];
			}elseif (isset($product['data']['prodsaleprice']) && $product['data']['prodsaleprice']>0 && $product['data']['prodsaleprice'] < $product['product_price']) {
                $price = $product['data']['prodsaleprice'];
            } else {
				$price = $product['product_price'];
			}

			$subtotal += ((int)$product['quantity'] * $price);

			if (isset($product['wrapping'])) {
				$subtotal += ((int)$product['quantity'] * $product['wrapping']['wrapprice']);
			}
			if($product['compitem'] == 1) {
                for($x=0; $x<count($product['complementary']); $x++)   {
                    $comptotal += ($product['complementary'][$x]['comp_original_price'] * $product['complementary'][$x]['quantity']); # Baskaran
                }
            }
		}

		$this->cartSession['SUBTOTAL'] = $subtotal + $comptotal;   # Baskaran;

		return $subtotal;
	}

    public function AddVirtualItem($productDetails, $itemId=null)
	{
		$itemId = parent::AddVirtualItem($productDetails, $itemId);

		$item = &$this->cartSession['ITEMS'][$itemId];

		// set default data for a virtual item
		$item['data'] = array(
			'prodtype' => PT_PHYSICAL,
			'prodcostprice' => 0,
			'prodvariationid' => 0,
			'prodistaxable' => 1,
			'prodfixedshippingcost' => 0,
			'prodwrapoptions' => 0
		);

		// Reapply any coupons so that the new product gets the discount
		$this->ReapplyCoupons();

		return $itemId;
	}
    
    public function ApplyCoupon($couponCode, $go=0) {
        // dada.wang 2012-03-19 remove coupon
        $this->RemoveCouponCode($couponCode);
        $ret = parent::ApplyCoupon($couponCode, $go);
        if ($ret) {
            foreach($this->GetProductsInCart() as $itemId => $item) {
                if (isset($item['type']) && $item['type'] == "giftcertificate") {
                    continue;
                }

                // Is there a coupon code applied to this product?
                if(isset($item['discount'])) {
                    /*
                    $price = isset($item['discount_price']) ? $item['discount_price'] : $item['product_price'];
                    $discountType = $item['coupontype'];
                    $discountAmount = $item['discount'];

                    // Now workout the discount amount
                    if ($discountType == 0) {
                        // It's a dollar discount
                        $newPrice = $price - $discountAmount;
                    }
                    else {
                        // It's a percentage discount
                        $discount = $price * ($discountAmount / 100);
                        if($discount == $price) {
                            $newPrice = 0;
                        }
                        else {
                            $newPrice = $price - $discount;
                        }
                    }

                    if ($newPrice < 0) {
                        $newPrice = 0;
                    }
                     * 
                     */

                    $this->SetItemValue($itemId, 'discount_price', $this->CalculateUseCouponAfterPrice($item));
                }
            }
            $this->cartProducts = array();
        }
        return $ret;
    }
    
    public function RemoveCouponCode($couponId) {
        foreach($this->GetProductsInCart() as $itemId => $product) {
			if(isset($product['coupon']) && $product['couponcode'] == $couponId) {
                $this->cartSession['ITEMS'][$itemId]['product_price'] = $this->CalculateBeforeCouponPrice($product);
				unset($this->cartSession['ITEMS'][$itemId]['discount_price']);
				unset($this->cartSession['ITEMS'][$itemId]['discount']);
				unset($this->cartSession['ITEMS'][$itemId]['coupontype']);
				unset($this->cartSession['ITEMS'][$itemId]['couponcode']);
				unset($this->cartSession['ITEMS'][$itemId]['coupon']);
				unset($this->cartSession['ITEMS'][$itemId]['googlecheckout']);
                unset($this->cartSession['ITEMS'][$itemId]['exists_order_coupon']);
				$this->cartSession['ITEMS'][$itemId]['couponauto'] = '0';
			}
		}
        $this->cartProducts = array();
        return true;
    }
    
    public function GetAppliedCouponCodes()
	{
		$couponCodes = array();
		$products = $this->GetProductsInCart();
        
		foreach($products as $product) {
			if(!isset($product['coupon'])) {
				continue;
			}
            
            $couponDiff = $this->CalculateUseCouponDiffPrice($product);

			if(isset($couponCodes[$product['coupon']])) {
				$couponCodes[$product['coupon']]['coupontotal'] +=  $couponDiff * $product['quantity'];
			}
			else {
				$couponCodes[$product['coupon']] = array(
					'couponid' => $product['coupon'],
					'couponcode' => $product['couponcode'],
					'coupontype' => $product['coupontype'],
					'discount' => $product['discount'],
					'coupontotal' => $couponDiff * $product['quantity']
				);
				/* -- added for google checkout remove issue -- */
				if(isset($product['googlecheckout']))
				{
					$couponCodes[$product['coupon']]['googlecheckout'] = $product['googlecheckout'];
				}
			}
		}

		return $couponCodes;
	}
    
    /**
     * calculate before use coupon
     * @param numeric $product 
     */
    private function CalculateBeforeCouponPrice($product) {
        if(!isset($product['coupon'])) {
            return $product['product_price'];
        }
        
        $price = isset($product['discount_price']) ? $product['discount_price'] : $product['product_price'];

        if ($product['coupontype'] == 0) {
                    // It's a dollar discount
            $productPrice = $price + $product['discount'];
        }
        else {
            // It's a percentage discount
            $productPrice = $price / (1- $product['discount'] / 100);
        }
        
        return $productPrice;
    }
    
    /**
     * calculate beore use coupon and after use coupon price diff
     * @param array $product
     * @return numeric 
     */
    private function CalculateUseCouponDiffPrice($product) {
        if(!isset($product['coupon'])) {
            return 0;
        }
        $productPrice = $this->CalculateBeforeCouponPrice($product);

        // Now workout the discount amount
        if ($product['coupontype'] == 0) {
            return $product['discount'];
        }
        else {
            // It's a percentage discount
            return $productPrice * ($product['discount'] / 100);
        }
    }
    
    /**
     * calculate product after use coupon new price
     * @param array $product
     * @param array $coupon 
     * @return double price
     */
    private function CalculateUseCouponAfterPrice(&$product) {
        $price = isset($product['discount_price']) ? $product['discount_price'] : $product['product_price'];
        if(isset($product['discount'])) {
            $discountType = $product['coupontype'];
            $discountAmount = $product['discount'];

            // Now workout the discount amount
            if ($discountType == 0) {
                // It's a dollar discount
                $newPrice = $price - $discountAmount;
            }
            else {
                // It's a percentage discount
                $discount = $price * ($discountAmount / 100);
                if($discount == $price) {
                    $newPrice = 0;
                }
                else {
                    $newPrice = $price - $discount;
                }
            }

            if ($newPrice < 0) {
                $newPrice = 0;
            }
        } else {
            return $price;
        }
        return $newPrice;
    }


    public function RemoveAppliedCompanyGiftCertificate($giftCertificateId) {
        parent::RemoveAppliedCompanyGiftCertificate($giftCertificateId);
        $this->SetArrayPush('RemoveCGC', $giftCertificateId);
    }
    
    public function RemoveAppliedGiftCertificate($giftCertificateId) {
        parent::RemoveAppliedGiftCertificate($giftCertificateId);
        $this->SetArrayPush('RemoveGC', $giftCertificateId);
    }
    
    public function UpdateCartInformation()
	{
		$this->cartSession['FREE_SHIPPING'] = false;
		$this->cartSession['DISCOUNT_MESSAGES'] = null;
        
		$cartProducts = $this->GetProductsInCart();
        
		/*foreach ($cartProducts as $key=>$product) {
			$this->SetItemValue($key, 'discount_price', $product['product_price']);
		}*/                        
        /* Original price + sales price + coupon, for this scenario we have fix it temporaryly -- Baskaran */
		foreach ($cartProducts as $key=>$product) {
            if( isset($product['data']['prodsaleprice']) && ((float)$product['data']['prodsaleprice'] > 0) && ($product['data']['prodsaleprice'] < $product['data']['prodprice']))
            {
                $this->SetItemValue($key, 'discount_price', $product['data']['prodsaleprice']);
            }
            elseif (!isset($product['discount_price']))
            { 
			    $this->SetItemValue($key, 'discount_price', $product['product_price']);
            }
                
		}

		require_once(ISC_BASE_PATH . "/lib/rule.php");
		$response = EvaluateRules('all', $this->GetCartSubTotal(false, null, false, false, true));
        
		$this->cartSession['SUBTOTAL_DISCOUNT'] = $response['subtotal'];
		$this->cartSession['RULE_USES'] = $response['ruleuses'];
	}
    
}
?>