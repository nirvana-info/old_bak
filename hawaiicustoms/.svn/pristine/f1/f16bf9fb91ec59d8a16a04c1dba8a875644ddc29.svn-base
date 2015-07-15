<?php

class RULE_XAMOUNTOFFWHENXORMORE extends ISC_RULE
{
	private $amount;
	private $amount_off;

	public function __Construct()
	{
		parent::__construct();

		$this->setName('XAMOUNTOFFWHENXORMORE');
		$this->displayName = GetLang($this->getName().'displayName');

		$this->addJavascriptValidation('amount', 'int');
		$this->addJavascriptValidation('amount_off', 'int');

		$this->addActionType('orderdiscount');
		$this->ruleType = 'Order';
	}

	public function initialize($data)
	{

		parent::initialize($data);

		$tmp = unserialize($data['configdata']);

		$this->amount = $tmp['varn_amount'];
		$this->amount_off = $tmp['varn_amount_off'];
	}

	public function isTrue()
	{

		$GLOBALS['ISC_CLASS_CART'] = GetClass('ISC_CART');
		$total = $GLOBALS['ISC_CLASS_CART']->api->GetCartSubTotal(false, null, true, true);

		if ($total >= $this->amount) {
			$GLOBALS['ISC_CLASS_CART']->api->SetArrayPush('DISCOUNT_MESSAGES', sprintf(GetLang($this->getName().'DiscountMessage'), $this->amount_off, $this->amount));
			$this->subtotal = $this->amount_off;
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