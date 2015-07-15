<?php

class RULE_BUYXGETY extends ISC_RULE
{
	private $amount;
	private $prodids;
	private $ps;
	private $amount_free;
	private $prodidsfree;
	private $ps_free;
	protected $vendorSupport = true;

	public function __Construct()
	{
		parent::__construct();

		$this->setName('BUYXGETY');
		$this->displayName = GetLang($this->getName().'displayName');

		$this->addJavascriptValidation('amount', 'int');
		$this->addJavascriptValidation('amount_free', 'int');
		$this->addJavascriptValidation('ps', 'string');
		$this->addJavascriptValidation('prodids', 'string');
		$this->addJavascriptValidation('ps_free', 'string');
		$this->addJavascriptValidation('prodidsfree', 'string');

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
		$this->ps_free = $tmp['var_ps_free'];
		$this->prodidsfree = $tmp['var_prodidsfree'];
	}

	public function isTrue()
	{
		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
		$products = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart(true);

		$true = false;

		foreach ($products as $key=>$product) {

			if (isset($product['parent_id'])) {
				continue;
			}

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

			// Check to see if the free item already exists in the cart
			foreach ($products as $k=>$p) {
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

			// If the free item doesn't exist, then we need to add it
			if ($freeitems > 0) {

				if (!$GLOBALS['ISC_CLASS_CART']->api->addItem($this->prodidsfree, $freeitems, null, array(), null, array('priceOverride'=>0, 'updateQtyIfExists'=>false), $this->dbid.$key)) {
					$true = false;
				} else {

					$newProducts = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart();

					// Finds the name of the recently added item.
					// Maybe there is a better way of getting this
					$name = '';
					foreach ($newProducts as $k=>$p) {
						if ($this->prodidsfree == $p['product_id']) {
							$name = $p['product_name'];
							break;
						}
					}

					// Update the parent item with a list of its children.
					if (isset($products[$key]['Children'])) {
						$children = $products[$key]['Children'];
					} else {
						$children = array();
					}

					$children[] = $this->dbid.$key;
					$children = array_unique($children);


					$GLOBALS['ISC_CLASS_CART']->api->SetItemValue($key, 'Children', $children);
					$GLOBALS['ISC_CLASS_CART']->api->SetArrayPush('DISCOUNT_MESSAGES', sprintf(GetLang($this->getName().'DiscountMessage'), $freeitems, $name));

					$true = true;
				}
			}
		}

		return $true;
	}

	public function haltReset()
	{
		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
		$products = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart();

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