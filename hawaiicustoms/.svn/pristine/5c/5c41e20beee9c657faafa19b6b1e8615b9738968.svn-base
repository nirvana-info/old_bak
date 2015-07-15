<?php
	require_once(dirname(__FILE__).'/module.php');
	require_once(dirname(__FILE__) . "/../includes/classes/class.rule.php");

	/**
	 * Evaluate Rules
	 *
	 * Evalute a set of rules determined by their type. This method will run
	 * the execute method of all rules, and return their changes to the subtotal.
	 * It will run the method's haltReset function if it's disabled.
	 *
	 * @access public
	 * @param string $type - The type of the rules
	 * @param int $total - The current order total
	 * @return array Returns an array of changed values including subtotal and an array of rules executed
	 */
	function EvaluateRules($type='all', $total=0) {

		$rules = GetRuleModuleInfo();
		$newTotal = $total;
		$totalItemDiscounts = 0;
		$totalDiscount = 0;
		$rulesExecuted = array();
		$ruleUses = array();
		$halt = false;

		foreach ($rules as $rule) {

			$subtotal = 0;
			if (!$rule->enabled() || $halt) {
				$rule->haltReset();
				continue;
			}

			$true = $rule->isTrue();

			if ($true) {

				if ($rule->getSubTotalChanges() > 0) {
					$subtotal += $rule->getSubTotalChanges();
					$totalDiscount += $subtotal;
					$newTotal -= $subtotal;
				}

				if ($rule->getItemDiscounts() > 0) {
					$newTotal -= $rule->getItemDiscounts();
					$totalItemDiscounts += $rule->getItemDiscounts();
				}

				if ($rule->getSubTotalPercentChanges() > 0) {
					$totalDiscount += $newTotal * $rule->getSubTotalPercentChanges()/100;
					$newTotal -= $newTotal * $rule->getSubTotalPercentChanges()/100;
				}

				$ruleUses[$rule->getDbId()] = $rule->getUses();

				if ($rule->checkHalt()) {
					$halt = true;
				}
			}
		}

		if ($totalDiscount > $total-$totalItemDiscounts) {
			$totalDiscount = $total-$totalItemDiscounts;
		}

		return array('subtotal'=>$totalDiscount, 'ruleuses'=>$ruleUses);
	}

	/**
	 * Update Rule Uses
	 *
	 * This method will update the rules usage in the database.
	 *
	 * @access public
	 * @param array $ruleUses - An array of all the rules to be updated
	 */
	function UpdateRuleUses($ruleUses=array()) {

		if (!is_array($ruleUses)) {
			return;
		}

		foreach ($ruleUses as $rule=>$uses) {
			$query = sprintf('UPDATE [|PREFIX|]discounts SET discountcurrentuses=discountcurrentuses+1 WHERE %s', sprintf("discountid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($rule)));
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}
	}

	/**
	 * Get Rule Module Info
	 *
	 * Retrieves a list of discount rules enabled by the customer
	 *
	 * @access public
	 * @param string $type - The type of the rules
	 * @return array Returns an array of initialized rules
	 */
	function GetRuleModuleInfo($type='all')
	{
		static $cache = array();
		if(isset($cache[$type])) {
			return $cache[$type];
		}

		if ($type == 'all') {
			$query = "
				SELECT *
				FROM [|PREFIX|]discounts ORDER BY sortorder";
		}
		else {
			$query = "
				SELECT *
				FROM [|PREFIX|]discounts
				WHERE discountruletype='rule_".$type . "'
				ORDER BY sortorder";
		}

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		while($var = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

			GetModuleById('rule', $object, $var['discountruletype']);

			$object->initialize($var);

			$cache[$type][] = $object;
		}

		if (isset($cache[$type])) {
			return $cache[$type];
		} else {
			return array();
		}
	}

?>
