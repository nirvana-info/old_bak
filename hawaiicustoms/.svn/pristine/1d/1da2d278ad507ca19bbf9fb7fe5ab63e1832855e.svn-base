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
		$this->cartSession['NUM_ITEMS'] = 0;
		// Load any products in the order and set them up in the session
		$query = "
			SELECT *
			FROM [|PREFIX|]order_products
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
				'product_price' => $product['ordprodoriginalcost'],
				'original_price' => $product['ordoriginalprice'],
				'bulkdiscount_type' => '',
				'bulkdiscount' => '',
				'product_code' => $product['ordprodsku'],
				'type' => $product['ordprodtype'],
				'refunded_qty' => $product['ordprodrefunded'],
				'product_fields' => array(),
				'event_name' => $product['ordprodeventname'],
				'event_date' => $product['ordprodeventdate'],
				'existing_order_product' => $product['orderprodid']
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


			$prodPrice = $this->cartSession['ITEMS'][$coupon['ordcoupprodid']]['product_price'];

			if ($coupon['ordcoupontype'] == 0) {
				// It's a dollar discount
				$newPrice = $prodPrice - $coupon['ordcouponamount'];
			}
			else {
				// It's a percentage discount
				$discount = ($prodPrice/100)*$coupon['ordcouponamount'];
				if($discount == $prodPrice) {
					$newPrice = 0;
				}
				else {
					$newPrice = $prodPrice - $discount;
				}
			}

			if ($newPrice < 0) {
				$newPrice = 0;
			}

			$this->cartSession['ITEMS'][$coupon['ordcoupprodid']]['discount_price'] = $newPrice;
		}

		// load gift certificates
		$query = "
			SELECT
				g.giftcertcode,
				h.histgiftcertid,
				h.histbalanceused
			FROM
				[|PREFIX|]gift_certificate_history h
				LEFT JOIN [|PREFIX|]gift_certificates g ON g.giftcertid	= h.histgiftcertid
			WHERE
				h.historderid = '".(int)$orderId."'";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($certificate = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$this->cartSession['GIFTCERTIFICATES'][$certificate['histgiftcertid']] = array(
				"giftcertcode" => $certificate['giftcertcode'],
				"giftcertid" => $certificate['histgiftcertid'],
				"giftcertamount" => $certificate['histbalanceused'],
				"giftcertbalance" => $certificate['histbalanceused'],
				"giftcertexpirydate" => ""
			);
		}
	}

	public function GetProductsInCart($hardRefresh=false)
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

			// Is there a coupon code applied to this product?
			if(isset($item['discount'])) {
				// Apply the discount which is stored in the form
				// of [discount][type], such as 10$ or 20%
				//$discountType = isc_substr($item['discount'], isc_strlen($item['discount'])-1, 1);
				//$discountAmount = isc_substr($item['discount'], 0, isc_strlen($item['discount'])-1);
				$discountType = $item['coupontype'];
				$discountAmount = $item['discount'];

				// Now workout the discount amount
				if ($discountType == 0) {
					// It's a dollar discount
					$newPrice = $item['product_price'] - $discountAmount;
				}
				else {
					// It's a percentage discount
					$discount = ($item['product_price']/100)*$discountAmount;
					if($discount == $item['product_price']) {
						$newPrice = 0;
					}
					else {
						$newPrice = $item['product_price'] - $discount;
					}
				}

				if ($newPrice < 0) {
					$newPrice = 0;
				}

				$this->cartProducts[$itemId]['discount_price'] = $newPrice;
			}
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
}
?>