<?php
require_once(dirname(__FILE__).'/class.module.php');

class ISC_RULE extends ISC_MODULE
{
	/**
	 * @var string The type of module this is.
	 */
	protected $type = 'rule';

	/**
	 * @var string The name of the module.
	 */
	protected $displayName = '';

	/**
	 * @var string The category of the rule (Order, Item, ect). Used for display purposes
	 */
	protected $ruleType = 'Default';

	/**
	 * @var int A unique id for the rule. Uses the id from the database
	 */
	protected $dbid = null;

	/**
	 * @var int The amount that the subtotal changed by
	 */
	protected $subtotal = 0;

	/**
	 * @var int The percentage that the subtotal changed by
	 */
	protected $subtotalpercent = 0;

	/**
	 * @var int The total amount the item was modified by
	 */
	protected $itemdiscount = 0;

	/**
	 * @var boolean The type of module this is.
	 */
	protected $halt = false;

	/**
	 * @var boolean The type of module this is.
	 */
	protected $enabled = false;

	/**
	 * @var int When the rule expires
	 */
	protected $expiry = 0;

    /**
     * @var int When the rule becomes active  
     * @author Simha
     * @desc 0 for no start time
     */
    protected $starttime = 0;

	/**
	 * @var int The amount of items that the rule applied to. Used to update the uses counter
	 */
	protected $uses = 0;

	/**
	 * @var int The maximum amount of uses available
	 */
	protected $maxuses = 0;

	/**
	 * @var boolean Does the rule support vendors?
	 */
	protected $vendorSupport = false;

	/**
	 * @var array A list of built in javascript validations that apply to the rule
	 */
	protected $javascriptValidations = array();

	public function getSubTotalChanges()
	{
		return $this->subtotal;
	}

	public function getSubTotalPercentChanges()
	{
		return $this->subtotalpercent;
	}

	public function getItemDiscounts()
	{
		return $this->itemdiscount;
	}

	public function getUses()
	{
		return $this->uses;
	}

	public function getDbId()
	{
		return $this->dbid;
	}

	public function checkHalt()
	{
		return $this->halt;
	}

	public function vendorSupport()
	{
		return $this->vendorSupport;
	}

	/**
	 * Enabled
	 *
	 * Checks the rule maxuses and expiry date to see if it's valid
	 *
	 * @access public
	 * @return bool enabled
	 */
	public function enabled()
	{

		if ($this->maxuses != 0 && $this->uses >= $this->maxuses) {
			return false;
		}
        /*echo date("Y-m-d H:i:s", time())."<br />";
        echo (time()-(5*60*60*1000))."<br />";
        echo $this->starttime."<br />";
        echo date("Y-m-d H:i:s",$this->starttime); 
        exit;*/
        $cdate = mktime(date("H")-5, date("i"), 0, date("m"), date("d"), date("Y"));
		// We add 86399 to the expiry because the expiry is stored as the start of the day
		// 86399 adds 23 hours and 59 minutes and 59 seconds to the expiry date
		if ($this->expiry != 0 && (int)$cdate > $this->expiry) { //time()       //+86399 to $this->expiry was removed by Simha since we are storing minutes as well now.                                                      
			return false;
		}
        
        if ($this->starttime != 0 && (int)$cdate < $this->starttime) { 
            return false;
        }

		return $this->enabled;
	}

	public function initializeAdmin()
	{

	}

	public function getRuleType()
	{
		return $this->ruleType;
	}

	public function addActionType($type)
	{
		$this->actionTypes[] = $type;
	}

	public function getDisplayName()
	{
		return $this->displayName;
	}

	public function initialize($data)
	{

		$this->dbid 	= $data['discountid'];
		$this->halt 	= $data['halts'];
		$this->enabled 	= $data['discountenabled'];
		$this->expiry 	= $data['discountexpiry'];
        $this->starttime= $data['discountstart'];
		$this->uses 	= $data['discountcurrentuses'];
		$this->maxuses 	= $data['discountmaxuses'];
	}

	/**
	 * Get Javascript Validation
	 *
	 * This gets the javascript validation code for all the rules available.
	 *
	 * @access public
	 * @return string A string of javascript content
	 */
	public function getJavascriptValidation()
	{

		$jsString = 'function ' . strtolower('rule_'.$this->getName()) . '() {';

		foreach ($this->javascriptValidations as $jV) {
			$jsString .= $jV;
		}

		return $jsString . 'return true; }

				';
	}

	/**
	 * Add Javascript Validation
	 *
	 * This creates the javascript code used to validate the modules on the admin section
	 *
	 * @access public
	 * @param string $id - The id of the rule
	 * @param string $type - The type of the rule
	 * @param int $min - The maximum value allowed in the field
	 * @param int $max - The minimum value allowed in the field
	 */
	public function addJavascriptValidation($id, $type, $min=0, $max=10000)
	{

		if ($type == 'int') {

			$this->javascriptValidations[] = '

					var '.$id.' = document.getElementById("'.$id.'");

					if (isNaN(parseInt('.$id.'.value))) {
						alert("'.sprintf(GetLang($this->GetName().'EnterDiscount'.$id), $min, $max).'");
						'.$id.'.focus();
						'.$id.'.select();
						return false;
					}
					if (parseInt('.$id.'.value) < '.$min.') {
						alert("'.sprintf(GetLang($this->GetName().'EnterMin'.$id), $min, $max).'");
						'.$id.'.focus();
						'.$id.'.select();
						return false;
					}
					if (parseInt('.$id.'.value) > '.$max.') {
						alert("'.sprintf(GetLang($this->GetName().'EnterMax'.$id), $min, $max).'");
						'.$id.'.focus();
						'.$id.'.select();
						return false;
					}';


		} else if ($type == 'string') {

			$this->javascriptValidations[] = '

					var '.$id.' = document.getElementById("'.$id.'");

					if ('.$id.'.value == "") {
						alert("'.GetLang($this->GetName().'EnterDiscount'.$id).'");
						'.$id.'.focus();
						'.$id.'.select();
						return false;
					}';
		} else if ($type == 'array') {

			$this->javascriptValidations[] = '

					var '.$id.' = document.getElementById("var_'.$id.'");

						if ('.$id.'.selectedIndex == -1) {
						alert("'.GetLang($this->GetName().'EnterDiscount'.$id).'");
						return false;
					}';
		}
	}
}

?>