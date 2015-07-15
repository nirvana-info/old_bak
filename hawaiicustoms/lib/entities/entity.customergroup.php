<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'entity.base.php');

class ISC_ENTITY_CUSTOMERGROUP extends ISC_ENTITY_BASE
{
	protected $tableName;
	protected $primaryKeyName;
	protected $customKeyName;
	protected $searchFields;

	public function __construct()
	{
		parent::__construct();

		$this->tableName = 'customer_groups';
		$this->primaryKeyName = 'customergroupid';
		$this->customKeyName = '';
		$this->searchFields = array(
				'customergroupid',
				'groupname'
		);
	}

	/**
	 * Add a customer group
	 *
	 * Method will add a customer group to the database
	 *
	 * @access public
	 * @param array $input The customer group details
	 * @return int The customer group record ID on success, FALSE otherwise
	 */
	public function add($input)
	{
		$savedata = array(
			'groupname'				=> $input['name'],
			'discount'				=> $input['discount'],
			'discountmethod'		=> $input['discountmethod'],
			'isdefault'				=> $input['isdefault'],
			'categoryaccesstype'	=> $input['categoryaccesstype']
		);

		$id = $GLOBALS['ISC_CLASS_DB']->InsertQuery('customer_groups', $savedata);
		if (!isId($id)) {
			return false;
		}

		// add categories
		$this->addAccessCategories($id, $input['accesscategories']);

		/**
		 * Create the spool file
		 */
		$this->createServiceRequest('customergroup', 'add', $id, 'customer_create');

		if ($input['isdefault']) {
			$this->setDefaultCustomerGroup($id);
		}

		return $id;
	}

	/**
	 * Edit a customer group
	 *
	 * Method will edit a customer group's details
	 *
	 * @access public
	 * @param array $input The customer group's details
	 * @return bool TRUE if the customer group exists and the details were updated successfully, FALSE oterwise
	 */
	public function edit($input)
	{
		if (!array_key_exists('customergroupid', $input) || !isId($input['customergroupid'])) {
			return false;
		}

		/**
		 * We need to check to see if this is already the default customer group. If this is aready a default and we are also setting this as the
		 * default, then we can skip the setDefaultCustomerGroup method as that will just set thats that are already set
		 */
		$orig = $GLOBALS['ISC_CLASS_DB']->Fetch($GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]customer_groups WHERE customergroupid='" . (int)$input['customergroupid'] . "'"));

		$savedata = array(
			'groupname'				=> $input['name'],
			'discount'				=> $input['discount'],
			'discountmethod'		=> $input['discountmethod'],
			'isdefault'				=> $input['isdefault'],
			'categoryaccesstype'	=> $input['categoryaccesstype']
		);

		if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery('customer_groups', $savedata, "customergroupid='" . (int)$input['customergroupid'] . "'")) {
			// add categories
			$this->addAccessCategories($input['customergroupid'], $input['accesscategories'], true);

			/**
			 * Create the spool file
			 */
			$this->createServiceRequest('customergroup', 'edit', (int)$input['customergroupid'], 'customer_edit');

			if ($input['isdefault'] && $orig['isdefault'] == '0') {
				$this->setDefaultCustomerGroup($input['customergroupid']);
			}

			return true;
		}

		return false;
	}

	private function addAccessCategories($customergroupid, $categories, $delete_old = false)
	{
		if ($delete_old) {
			$query = "DELETE FROM [|PREFIX|]customer_group_categories WHERE customergroupid = " . $customergroupid;
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}

		if (count($categories)) {
			foreach ($categories as $category) {
				$insert = array(
					"customergroupid" => $customergroupid,
					"categoryid" => $category
				);

				$GLOBALS['ISC_CLASS_DB']->InsertQuery('customer_group_categories', $insert);
			}
		}
	}

	/**
	 * Delete a customer group
	 *
	 * Method will delete a customer group
	 *
	 * @access public
	 * @param int $customergroupid The customer group ID
	 * @return bool TRUE if the customer group was deleted successfully, FASLE otherwise
	 */
	public function delete($customergroupid)
	{
		if (!isId($customergroupid) || !($input = $this->get($customergroupid))) {
			return false;
		}

		if ($GLOBALS['ISC_CLASS_DB']->Query("DELETE FROM [|PREFIX|]customer_groups WHERE customergroupid='" . (int)$customergroupid . "'") !== false) {
			//delete access categories
			$query = "DELETE FROM [|PREFIX|]customer_group_categories WHERE customergroupid = '" . $customergroupid . "'";
			$GLOBALS['ISC_CLASS_DB']->Query($query);

			/**
			 * Create the spool file
			 */
			$input['isactive'] = 0;

			$this->createServiceRequest('customergroup', 'edit', $input, 'customer_edit');
			return true;
		}

		return false;
	}

	/**
	 * Delete multiple customer groups
	 *
	 * Method will delete multiple customer groups
	 *
	 * @access public
	 * @param array $customergroupids The array containing the IDs of the customer groups to delete
	 * @return bool TRUE if the customer groups were all deleted, FASLE otherwise
	 */
	public function multiDelete($customergroupids)
	{
		if (!is_array($customergroupids)) {
			return false;
		}

		$customergroupids = array_filter($customergroupids, 'isId');

		foreach ($customergroupids as $customergroupid) {
			self::delete($customergroupid);
		}

		return true;
	}

	/**
	 * Set the default group on all the customers
	 *
	 * Method will reset the default group on all the customers in the accounting world
	 *
	 * @access private
	 */
	private function setDefaultCustomerGroup($customergroupid)
	{
		if (!isId($customergroupid)) {
			return false;
		}

		/**
		 * Ok, now we have to set this customergroup on all the customers that have the default customer group
		 */
		$customer = new ISC_ENTITY_CUSTOMER();
		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]customers WHERE custgroupid='0'");
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$input = $customer->get($row['customerid']);
			$this->createServiceRequest('customer', 'edit', $input, 'customer_edit');
		}

		return true;
	}

	/**
	 * Does customer group exists?
	 *
	 * Method will return TRUE/FLSE depending if the customer group exists
	 *
	 * @access public
	 * @param int $customerGroupId The customer group ID
	 * @return bool TRUE if the customer group exists, FALASE otherwise
	 */
	public function exists($customerGroupId)
	{
		if (!isId($customerGroupId) || !CustomerGroupExists($customerGroupId)) {
			return false;
		}

		return true;
	}

	/**
	 * Get the customer group record
	 *
	 * Method will return the customer group record
	 *
	 * @access public
	 * @param int $customerGroupId The customer group ID
	 * @return array The customer group array on success, NULL if no record could be found, FALSE on error
	 */
	public function get($customerGroupId)
	{
		if (!isId($customerGroupId)) {
			return false;
		}

		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]customer_groups WHERE customergroupid=" . (int)$customerGroupId);
		if (!($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))) {
			return null;
		}

		return $row;
	}
}
?>
