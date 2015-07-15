<?php

class RULE_BUYXGETFREESHIPPING extends ISC_RULE
{
	private $amount;
	private $prodids;
	protected $vendorSupport = true;

	public function __Construct($amount=0, $prodids=array())
	{
		parent::__construct();

		$this->amount = $amount;
		$this->prodids = $prodids;

		$this->setName('BUYXGETFREESHIPPING');
		$this->displayName = GetLang($this->getName().'displayName');

		$this->addJavascriptValidation('amount', 'int');
		$this->addJavascriptValidation('ps', 'string');
		$this->addJavascriptValidation('prodids', 'string');

		$this->ruleType = 'Order';

	}

	public function initialize($data)
	{
		parent::initialize($data);

		$tmp = unserialize($data['configdata']);

		$this->amount = $tmp['var_amount'];
		$this->prodids = $tmp['var_prodids'];
	}

	public function initializeAdmin()
	{
		$quantity = 1;

		if (isset($GLOBAL['var_amount'])) {
			$quantity = $GLOBAL['var_amount'];
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
	}

	public function isTrue()
	{
		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
		$cartProducts = $GLOBALS['ISC_CLASS_CART']->api->GetProductsInCart();

		foreach ($cartProducts as $key=>$product) {
			if ($product['product_id'] == $this->prodids && $product['quantity'] >= $this->amount) {
				$GLOBALS['ISC_CLASS_CART']->api->set('FREE_SHIPPING', true);
				return true;
			}
		}

		return false;
	}

	public function haltReset()
	{
		return false;
	}

}


?>