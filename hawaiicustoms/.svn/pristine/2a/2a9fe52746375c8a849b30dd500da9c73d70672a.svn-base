<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'entity.base.php');

class ISC_ENTITY_CUSTOMER extends ISC_ENTITY_BASE
{
	private $shipping;
	private $group;

	protected $tableName;
	protected $primaryKeyName;
	protected $customKeyName;
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

		$this->shipping = new ISC_ENTITY_SHIPPING;
		$this->group = new ISC_ENTITY_CUSTOMERGROUP();

		$this->tableName = 'customers';
		$this->primaryKeyName = 'customerid';
		$this->customKeyName = 'custformsessionid';
		$this->searchFields = array(
				'customerid',
				'custgroupid',
				'custconfirstname',
				'custconlastname',
				'custconemail',
				'custconphone'
		);
	}

	/**
	 * Add a customer
	 *
	 * Method will add a customer to the database
	 *
	 * @access public
	 * @param array $input The customer details
	 * @return int The customer record ID on success, FALSE otherwise
	 */
	public function add($input)
	{
		$savedata = array(
			'custpassword'		=> md5($input['password']),
			'custconcompany'	=> $input['company'],
			'custconfirstname'	=> $input['firstname'],
			'custconlastname'	=> $input['lastname'],
			'custconemail'		=> $input['email'],
			'custconphone'		=> $input['phone'],
			'custdatejoined'	=> time()
		);
		
		if(isset($input['subscribed'])){
			$savedata['subscribed'] = $input['subscribed'];
		}
		// 20110613 johnny add
		if(isset($input['isguest'])){
			$savedata['isguest'] = $input['isguest'];
		}

		if(isset($input['storecredit'])) {
			$savedata['custstorecredit'] = $input['storecredit'];
		}

		if (array_key_exists('customergroupid', $input) && isId($input['customergroupid'])) {
			$savedata['custgroupid'] = $input['customergroupid'];
		} else {
			$input['customergroupid']	= 0;
			$savedata['custgroupid']	= 0;
		}

		if (!array_key_exists('is_import', $input) || !$input['is_import']) {
			$savedata['custregipaddress'] = GetIP();
		} else if (array_key_exists('token', $input)) {
			$savedata['customertoken'] = $input['token'];
		}

		if (array_key_exists('custformsessionid', $input)) {
			$savedata['custformsessionid'] = $input['custformsessionid'];
		}

		$customerid = $GLOBALS['ISC_CLASS_DB']->InsertQuery('customers', $savedata);
		$input['customerid'] = $customerid;
		if (!isId($customerid)) {
			return false;
		}

		if (array_key_exists('shipping_address', $input)) {
			$input['shipping_address']['customerid'] = $input['customerid'];
			$input['shipping_address']['shipcustomerid'] = $input['customerid'];
			$this->shipping->add($input['shipping_address']);
		}

		/**
		 * Create the spool file
		 */
		$this->createServiceRequest('customer', 'add', $input['customerid'], 'customer_create');

		return $customerid;
	}

	/**
	 * Edit a customer
	 *
	 * Method will edit a customer's details
	 *
	 * @access public
	 * @param array $input The customer's details
	 * @return bool TRUE if the customer exists and the details were updated successfully, FALSE oterwise
	 */
	public function edit($input)
	{
 		if (!array_key_exists('customerid', $input) || !isId($input['customerid'])) {
			return false;
		}

		$savedata = array(
			'custconcompany'	=> $input['company'],
			'custconfirstname'	=> $input['firstname'],
			'custconlastname'	=> $input['lastname'],
			'custconemail'		=> $input['email'],
			'custconphone'		=> $input['phone'],
			'status'		=> $input['status'],//zcs=
		);
		
		if(array_key_exists('subscribed', $input)){
			$savedata['subscribed'] = $input['subscribed'];
		}

		if (array_key_exists('token', $input)) {
			$savedata['customertoken'] = $input['token'];
		}

		if (array_key_exists('password', $input)) {
			$savedata['custpassword'] = md5($input['password']);
		}

		if (array_key_exists('storecredit', $input)) {
			$savedata['custstorecredit'] = $input['storecredit'];
		}

		if (array_key_exists('customergroupid', $input)) {
			$savedata['custgroupid'] = $input['customergroupid'];
		}

		if (array_key_exists('custformsessionid', $input)) {
			$savedata['custformsessionid'] = $input['custformsessionid'];
		}

		if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery('customers', $savedata, "customerid=" . (int)$input['customerid']) !== false) {
			if (array_key_exists('shipping_address', $input)) {
				$input['shipping_address']['customerid'] = $input['customerid'];
				$input['shipping_address']['shipcustomerid'] = $input['customerid'];
				$this->shipping->edit($input['shipping_address']);
			}

			/**
			 * Create the spool file
			 */
			$this->createServiceRequest('customer', 'edit', $input['customerid'], 'customer_edit');

			return true;
		}

		return false;
	}
	//zcs=>
	public function DecreaseImageNum($customerId){
		$GLOBALS['ISC_CLASS_DB']->Query("UPDATE [|PREFIX|]".$this->tableName." SET imagenum=imagenum-1 WHERE ".$this->primaryKeyName."=" . (int)$customerId . ' AND imagenum > 0');
	}
	public function IncreaseImageNum($customerId){
		$GLOBALS['ISC_CLASS_DB']->Query("UPDATE [|PREFIX|]".$this->tableName." SET imagenum=imagenum+1 WHERE ".$this->primaryKeyName."=" . (int)$customerId);
	}
	//<=zcs
	//zcs=>---Last upload image number----
	public function increaseImageLastUpload($customerId){
		$GLOBALS['ISC_CLASS_DB']->Query("UPDATE [|PREFIX|]".$this->tableName." SET image_last_upload=image_last_upload+1 WHERE ".$this->primaryKeyName."=" . (int)$customerId);
	}
	public function clearImageLastUpload($customerId){
		$GLOBALS['ISC_CLASS_DB']->Query("UPDATE [|PREFIX|]".$this->tableName." SET image_last_upload=0 WHERE ".$this->primaryKeyName."=" . (int)$customerId);
	}
	public function getImageLastUpload($customerId){
		
	}
	//<=zcs-------------------------------

	/**
	 * Edit the customer's group ID
	 *
	 * Method will only edit the customer's group ID
	 *
	 * @access public
	 * @param int $customerid The customer ID
	 * @param int $customergroupid The new customer group ID. Default is 0 (the default group)
	 * @return bool TRUE if the customer's group was successfully updated, FALSE otherwise
	 */
	public function editGroup($customerid, $customergroupid=0)
	{
		if (!isId($customerid) || !$this->exists($customerid) || $customergroupid == '') {
			return false;
		}

		if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery('customers', array('custgroupid' => $customergroupid), "customerid=" . (int)$customerid) === false) {
			return false;
		}

		$this->createServiceRequest('customer', 'edit', $customerid, 'customer_edit');

		return true;
	}

	/**
	 * Delete a customer
	 *
	 * Method will delete a customer
	 *
	 * @access public
	 * @param int $customerid The customer ID
	 * @return bool TRUE if the customer was deleted successfully, FASLE otherwise
	 */
	public function delete($customerid)
	{
		if (!isId($customerid)) {
			return false;
		}

		/**
		 * Make sure we have a record to delete. Also too, delete the formsession if we have one
		 */
		$customerData = self::get($customerid);

		if (!$customerData) {
			return false;
		}

		if ($GLOBALS['ISC_CLASS_DB']->DeleteQuery('customers', 'WHERE customerid = ' . (int)$customerid) !== false) {

			/**
			 * Delete all of the associated addresses
			 */
			$query = "SELECT shipid
						FROM [|PREFIX|]shipping_addresses
						WHERE shipcustomerid = " . (int)$customerid;

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$this->shipping->delete($row['shipid']);
			}

			/**
			 * Delete the form session if we can
			 */
			if (isId($customerData['custformsessionid'])) {
				$GLOBALS['ISC_CLASS_FORM']->deleteFormSession($customerData['custformsessionid']);
			}

			/**
			 * Create the spool file
			 */
			$customerData['isactive'] = 0;

			$this->createServiceRequest('customer', 'edit', $customerData, 'customer_delete');
			return true;
		}

		return false;
	}

	/**
	 * Delete multiple customers
	 *
	 * Method will delete multiple customers
	 *
	 * @access public
	 * @param array $customerids The array containing the IDs of the customers to delete
	 * @return bool TRUE if the customers were all deleted, FASLE otherwise
	 */
	public function multiDelete($customerids)
	{
		if (!is_array($customerids)) {
			return false;
		}

		$customerids = array_filter($customerids, 'isId');

		foreach ($customerids as $customerid) {
			self::delete($customerid);
		}

		return true;
	}

	/**
	 * Does customer exists?
	 *
	 * Method will return TRUE/FLSE depending if the customer exists
	 *
	 * @access public
	 * @param int $customerId The customer ID
	 * @return bool TRUE if the customer exists, FALASE otherwise
	 */
	public function exists($customerId)
	{
		if (!isId($customerId) || !CustomerExists($customerId)) {
			return false;
		}

		return true;
	}

	/**
	 * Get the customer record
	 *
	 * Method will return the customer record
	 *
	 * @access public
	 * @param int $customerId The customer ID
	 * @return array The customer array on success, NULL if no record could be found, FALSE on error
	 */
	public function get($customerId)
	{
		if (!isId($customerId)) {
			return false;
		}

		$entity = array();
		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]customers WHERE customerid=" . (int)$customerId);
		if (!($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))) {
			return null;
		}

		$entity = $row;

		/**
		 * Set the billing and shipping addresses
		 */
		$type	= '';
		$result	= $GLOBALS['ISC_CLASS_DB']->Query("SELECT shipid FROM [|PREFIX|]shipping_addresses WHERE shipcustomerid='" . (int)$customerId . "'");
		while ($addr = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			if ($type == '') {
				$type = 'billing_address';
			} else {
				$type = 'shipping_address';
			}

			$entity[$type] = $this->shipping->get($addr['shipid'], $customerId);
		}

		if (!isId($entity['custgroupid'])) {
			$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]customer_groups WHERE isdefault='1'");
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if ($row) {
				$entity['custgroupid'] = $row['customergroupid'];
			}
		}

		$entity['customergroup'] = null;
		if (isId($entity['custgroupid'])) {
			$entity['customergroup'] = $this->group->get($entity['custgroupid']);
		}

		return $entity;
	}
}

?>
