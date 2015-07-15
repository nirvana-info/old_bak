<?php

class RULE_XOFFFORREPEATCUSTOMERS extends ISC_RULE
{
	private $orders;
	private $amount;

	public function __Construct()
	{
		parent::__construct();

		$this->setName('XOFFFORREPEATCUSTOMERS');
		$this->displayName = GetLang($this->getName().'displayName');

		$this->addJavascriptValidation('orders', 'int');
		$this->addJavascriptValidation('amount', 'int');

		$this->addActionType('orderdiscount');
		$this->ruleType = 'Order';
	}

	public function initialize($data)
	{

		parent::initialize($data);

		$tmp = unserialize($data['configdata']);

		$this->amount = $tmp['varn_amount'];
		$this->amount_off = $tmp['var_orders'];
	}

	public function initializeAdmin()
	{
		$quantity = 1;

		if (isset($GLOBAL['var_orders'])) {
			$quantity = $GLOBAL['var_orders'];
		}

		// If we're using a cart quantity drop down, load that
		if (GetConfig('TagCartQuantityBoxes') == 'dropdown') {
			$GLOBALS['SelectId'] = "orders";
			$GLOBALS['Qty0'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("DiscountItemQtySelect");
		// Otherwise, load the textbox
		} else {
			$GLOBALS['SelectId'] = "orders";
			$GLOBALS['Qty0'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("DiscountItemQtyText");
		}

		if (!isset($GLOBALS['var_ps'])) {
			$GLOBALS['var_ps'] = GetLang('ChooseAProduct');
		}

	}

	public function isTrue()
	{

		if (!CustomerIsSignedIn()) {
			return null;
		}

		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');

		$custID = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();

		$query = "SELECT count(*)
				FROM [|PREFIX|]orders
				WHERE ordcustid = '$custID'
		";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		$count = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

		if ($count['count(*)'] > $this->orders) {
			$GLOBALS['ISC_CLASS_CART']->api->SetArrayPush('DISCOUNT_MESSAGES', sprintf(GetLang($this->getName().'DiscountMessage'), $this->amount));
			$this->subtotal = $this->amount;
			return true;
		}

		return false;
	}

	public function haltReset()
	{
		return false;
	}

}


?>