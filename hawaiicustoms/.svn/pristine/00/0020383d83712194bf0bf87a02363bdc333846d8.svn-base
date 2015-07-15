<?php
//zcs=>
/**
 * Picture Module ORM
 * @author wilson
 *
 */

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'entity.base.php');

class ISC_ENTITY_PICTURE extends ISC_ENTITY_BASE
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

		$this->customer = new ISC_ENTITY_CUSTOMER;
		
		$this->tableName = 'pic';
		$this->primaryKeyName = 'picid';
		$this->searchFields = array(
				'picid',
				'filename',
				'description',
		);
	}
	
	/**
	 * Delete a photo
	 *
	 * Method will delete a photo
	 *
	 * @access public
	 * @param int $photoid The photo ID
	 * @return bool TRUE if the photo was deleted successfully, FASLE otherwise
	 */
	public function delete($photoid)
	{
		if (!isId($photoid)) {
			return false;
		}

		/**
		 * Make sure we have a record to delete. Also too, delete the formsession if we have one
		 */
		$photoData = self::get($photoid);

		if (!$photoData) {
			return false;
		}

		if (unlink(ISC_BASE_PATH.DIRECTORY_SEPARATOR.$photoData['path']) && $GLOBALS['ISC_CLASS_DB']->DeleteQuery($this->tableName, 'WHERE '.$this->primaryKeyName.' = ' . (int)$photoid) !== false) {
			if(!$photoData['deleted']){
				$this->customer->DecreaseImageNum($photoData['customerid']);
			}
			return true;
		}

		return false;
	}

	/**
	 * Delete multiple photos
	 *
	 * Method will delete multiple photos
	 *
	 * @access public
	 * @param array $photoids The array containing the IDs of the photos to delete
	 * @return bool TRUE if the photos were all deleted, FASLE otherwise
	 */
	public function multiDelete($photoids)
	{
		$deleted = array();
		$return = false;
		if (!is_array($photoids)) {
			return $return;
		}

		$photoids = array_filter($photoids, 'isId');

		foreach ($photoids as $photoid) {
			if(self::delete($photoid)){
				$deleted[] = $photoid;
				$return = true;
			}else{
				$return = false;
			}
		}

		return array($return, $deleted);
	}

	/**
	 * Get the photo record
	 *
	 * Method will return the photo record
	 *
	 * @access public
	 * @param int $photoId The photo ID
	 * @return array The photo array on success, NULL if no record could be found, FALSE on error
	 */
	public function get($photoId)
	{
		if (!isId($photoId)) {
			return false;
		}

		$entity = array();
		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]".$this->tableName." WHERE ".$this->primaryKeyName."=" . (int)$photoId);
		if (!($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))) {
			return null;
		}

		return $row;
	}
}
//<=zcs
?>
