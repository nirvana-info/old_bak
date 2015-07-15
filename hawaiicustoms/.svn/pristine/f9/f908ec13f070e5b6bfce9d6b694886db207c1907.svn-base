<?php

class RULE_BUYXGETX extends ISC_RULE
{
	private $amount;
	private $prodids;
	private $ps;
	private $amount_free;
	protected $vendorSupport = true;

	public function __Construct()
	{
		parent::__construct();

		$this->setName('BUYXGETX');
		$this->displayName = GetLang($this->getName().'displayName');

		$this->addJavascriptValidation('amount', 'int');
		$this->addJavascriptValidation('amount_free', 'int');
		$this->addJavascriptValidation('ps', 'string');
		$this->addJavascriptValidation('prodids', 'string');

		$this->addActionType('freeitem');
		$this->ruleType = 'Product';
	}

	public function initializeAdmin()
	{
		$quantity = 1;
		$quantity_free = 1;

		if (isset($GLOBAL['var_amount'])) {
			$quantity = $GLOBAL['var_amount'];
		}
		if (isset($GLOBAL['var_amount_free'])) {
			$quantity_free = $GLOBAL['var_amount_free'];
		}

		// If we're using a cart quantity drop down, load that
		if (GetConfig('TagCartQuantityBoxes') == 'dropdown') {
			$GLOBALS['SelectId'] = "amount";
			$GLOBALS['Qty0'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("DiscountItemQtySelect");
		// Otherwise, load the textbox
		} else {
			$GLOBALS['SelectId'] = "amount";
			$GLOBALS['Qty0'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("DiscountItemQtyText");
		}

		if (!isset($GLOBALS['var_ps'])) {
			$GLOBALS['var_ps'] = GetLang('ChooseAProduct');
		}

		// If we're using a cart quantity drop down, load that
		if (GetConfig('TagCartQuantityBoxes') == 'dropdown') {
			$GLOBALS['SelectId'] = "amount_free";
			$GLOBALS['Qty1'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("DiscountItemQtySelect");
		// Otherwise, load the textbox
		} else {
			$GLOBALS['SelectId'] = "amount_free";
			$GLOBALS['Qty1'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("DiscountItemQtyText");
		}

		if (!isset($GLOBALS['var_ps_free'])) {
			$GLOBALS['var_ps_free'] = GetLang('ChooseAProduct');
		}
	}

	public function initialize($data)
	{
		parent::initialize($data);

		$tmp = unserialize($data['configdata']);

		$this->amount = $tmp['var_amount'];
		$this->prodids = $tmp['var_prodids'];
		$this->ps = $tmp['var_ps'];
		$this->amount_free = $tmp['var_amount_free'];
	}

	public function isTrue()
	{
		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
		$products = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart(true);

		$true = false;

		foreach ($products as $key=>$product) {

			// If the parent id is set, then the product is a free item. Skip it
			if (isset($product['parent_id'])) {
				continue;
			}

			// Check if the product is the right type
			if ($this->prodids != $product['product_id']) {
				continue;
			}

			$amount = $this->amount;

			$quantity = $product['quantity'];
			$freeitems = 0;

			while ($quantity >= $amount) {
				$quantity = $quantity - $amount;
				$freeitems += $this->amount_free;
			}

			foreach ($products as $k=>$p) {
				// If the product already exists in the cart, then we can update it instead
				if (isset($p['parent_id']) && $p['parent_id'] == $this->dbid.$key) {
					if ($freeitems == 0) {
						$GLOBALS['ISC_CLASS_CART']->api->RemoveItem($k);
					} else {
						if (!$GLOBALS['ISC_CLASS_CART']->api->UpdateCartQuantity($k, $freeitems)) {
							$GLOBALS['ISC_CLASS_CART']->api->RemoveItem($k);
							$freeitems = 0;
							continue;
						}

						$GLOBALS['ISC_CLASS_CART']->api->SetArrayPush('DISCOUNT_MESSAGES', sprintf(GetLang($this->getName().'DiscountMessage'), $freeitems, $p['product_name']));
						$freeitems = 0;
						$true = true;
					}
				}
			}

			// There isn't a free item already
			if ($freeitems > 0) {
				// Try to insert the product
				if (!$GLOBALS['ISC_CLASS_CART']->api->AddItem($products[$key]['product_id'], $freeitems, $products[$key]['variation_id'], array(), null, array('priceOverride'=>0, 'updateQtyIfExists'=>false), $this->dbid.$key)) {
					$true = false;
				} else {

					$GLOBALS['ISC_CLASS_CART']->api->SetArrayPush('DISCOUNT_MESSAGES', sprintf(GetLang($this->getName().'DiscountMessage'), $freeitems, $product['product_name']));

					if (isset($products[$key]['Children'])) {
						$children = $products[$key]['Children'];
					} else {
						$children = array();
					}

					$children[] = $this->dbid.$key;
					$children = array_unique($children);
					$GLOBALS['ISC_CLASS_CART']->api->SetItemValue($key, 'Children', $children);
					$true = true;
				}
			}
		}

		return $true;
	}

	public function haltReset()
	{
		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
		$products = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart(true);

		foreach ($products as $key=>$product) {

			if (isset($product['parent_id'])) {
				continue;
			}

			if ($this->prodids != $product['product_id']) {
				continue;
			}

			foreach ($products as $k=>$p) {

				if (isset($p['parent_id']) && $p['parent_id'] == $this->dbid.$key) {
					$GLOBALS['ISC_CLASS_CART']->api->RemoveItem($k);
				}
			}
		}
	}

}

?>