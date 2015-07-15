<?php
//zcs=>
/**
 * Add-on Product Module ORM
 * @author wilson
 *
 */

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'entity.base.php');

class ISC_ENTITY_ADDONPRODUCT extends ISC_ENTITY_BASE
{
	protected $tableName;
	protected $primaryKeyName;
	protected $searchFields;

	/**
	 * Constructor
	 *
	 * Base constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->tableName = 'addon_products';
		$this->primaryKeyName = 'id';
		$this->searchFields = array(
				'id',
				'price',
				'description',
		);
	}
	
	public function add($input)
	{
		if (!isId($id = $GLOBALS['ISC_CLASS_DB']->InsertQuery($this->tableName, $input))) {
			return false;
		}

		return $id;
	}
	
	public function edit($input)
	{
		if (!array_key_exists($this->primaryKeyName, $input) || !isId($input[$this->primaryKeyName])) {
			return false;
		}

		if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery($this->tableName, $input, $this->primaryKeyName."='" . (int)$input[$this->primaryKeyName] . "'") === false) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Delete a Add-on Product
	 *
	 * Method will delete a Add-on Product
	 *
	 * @access public
	 * @param int $addonProductid The Add-on Product ID
	 * @return bool TRUE if the Add-on Product was deleted successfully, FASLE otherwise
	 */
	public function delete($addonProductid)
	{
		if (!isId($addonProductid)) {
			return false;
		}

		/**
		 * Make sure we have a record to delete. Also too, delete the formsession if we have one
		 */
		$addonProductData = self::get($addonProductid);

		if (!$addonProductData) {
			return false;
		}

		if ($GLOBALS['ISC_CLASS_DB']->DeleteQuery($this->tableName, 'WHERE '.$this->primaryKeyName.' = ' . (int)$addonProductid) !== false) {
			return true;
		}

		return false;
	}

	/**
	 * Delete multiple Add-on Products
	 *
	 * Method will delete multiple Add-on Products
	 *
	 * @access public
	 * @param array $addonProductids The array containing the IDs of the Add-on Products to delete
	 * @return bool TRUE if the Add-on Products were all deleted, FASLE otherwise
	 */
	public function multiDelete($addonProductids)
	{
		$deleted = array();
		$return = false;
		if (!is_array($addonProductids)) {
			return $return;
		}

		$addonProductids = array_filter($addonProductids, 'isId');

		foreach ($addonProductids as $addonProductid) {
			if(self::delete($addonProductid)){
				$deleted[] = $addonProductid;
				$return = true;
			}else{
				$return = false;
			}
		}

		return array($return, $deleted);
	}

	/**
	 * Get the Add-on Product record
	 *
	 * Method will return the Add-on Product record
	 *
	 * @access public
	 * @param int $addonProductId The Add-on Product ID
	 * @return array The Add-on Product array on success, NULL if no record could be found, FALSE on error
	 */
	public function get($addonProductId)
	{
		if (!isId($addonProductId)) {
			return false;
		}

		$entity = array();
		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]".$this->tableName." WHERE ".$this->primaryKeyName."=" . (int)$addonProductId);
		if (!($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))) {
			return null;
		}

		return $row;
	}
}
//<=zcs
?>
