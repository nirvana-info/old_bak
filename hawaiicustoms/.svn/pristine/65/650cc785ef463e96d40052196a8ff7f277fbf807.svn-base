<?php

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'entity.base.php');

class ISC_ENTITY_SHIPPING extends ISC_ENTITY_BASE
{
	protected $tableName;
	protected $primaryKeyName;
	protected $customKeyName;
	protected $searchFields;

	public function __construct()
	{
		parent::__construct();

		$this->tableName = 'shipping_addresses';
		$this->primaryKeyName = 'shipid';
		$this->customKeyName = 'shipformsessionid';
		$this->searchFields = array(
				'shipid',
				'shipcustomerid',
				'shipfirstname',
				'shiplastname',
				'shipaddress1',
				'shipzip'
		);
	}

	/**
	 * Add a shipping address
	 *
	 * Method will add a shipping address to the database
	 *
	 * @access public
	 * @param array $input The shipping address details
	 * @return int The shipping address record ID on success, FALSE otherwise
	 */
	public function add($input)
	{
		if (!isset($input['shipdestination'])) {
			$input['shipdestination'] = 'residential';
		}

		if (!isset($input['shipcompany'])) {
			$input['shipcompany'] = '';
		}

		$savedata = array(
			'shipcustomerid'	=> $input['shipcustomerid'],
			'shipfirstname'		=> $input['shipfirstname'],
			'shiplastname'		=> $input['shiplastname'],
			'shipcompany'		=> $input['shipcompany'],
			"shipaddress1"		=> $input['shipaddress1'],
			"shipaddress2"		=> $input['shipaddress2'],
			"shipcity"			=> $input['shipcity'],
			"shipstate"			=> $input['shipstate'],
			"shipzip"			=> $input['shipzip'],
			"shipcountry"		=> $input['shipcountry'],
			"shipphone"			=> $input['shipphone'],
			"shipstateid"		=> (int)$input['shipstateid'],
			"shipcountryid"		=> (int)$input['shipcountryid'],
			"shipdestination"	=> $input['shipdestination'],
			"shiplastused"		=> time(),
		);

		if (array_key_exists('shipformsessionid', $input)) {
			$savedata['shipformsessionid'] = $input['shipformsessionid'];
		}

		return $GLOBALS['ISC_CLASS_DB']->InsertQuery("shipping_addresses", $savedata, 1);
	}

	/**
	 * Edit a shipping address
	 *
	 * Method will edit a customer's shipping address details
	 *
	 * @access public
	 * @param array $input The shipping address details
	 * @return bool TRUE if the shipping address exists and the details were updated successfully, FALSE oterwise
	 */
	public function edit($input)
	{
		if (!array_key_exists('shipid', $input)) {
			return false;
		}

		if (!isset($input['shipdestination'])) {
			$input['shipdestination'] = 'residential';
		}

		if (!isset($input['shipcompany'])) {
			$input['shipcompany'] = '';
		}

		$savedata = array(
			'shipcustomerid'	=> $input['shipcustomerid'],
			'shipfirstname'		=> $input['shipfirstname'],
			'shiplastname'		=> $input['shiplastname'],
			'shipcompany'		=> $input['shipcompany'],
			"shipaddress1"		=> $input['shipaddress1'],
			"shipaddress2"		=> $input['shipaddress2'],
			"shipcity"			=> $input['shipcity'],
			"shipstate"			=> $input['shipstate'],
			"shipzip"			=> $input['shipzip'],
			"shipcountry"		=> $input['shipcountry'],
			"shipphone"			=> $input['shipphone'],
			"shipstateid"		=> (int)$input['shipstateid'],
			"shipcountryid"		=> (int)$input['shipcountryid'],
			"shipdestination"	=> $input['shipdestination'],
		);

		if (array_key_exists('shipformsessionid', $input)) {
			$savedata['shipformsessionid'] = $input['shipformsessionid'];
		}

		$query = "shipid='".$GLOBALS['ISC_CLASS_DB']->Quote($input['shipid'])."'";
		if (array_key_exists('shipcustomerid', $input)) {
			$query .= " and shipcustomerid='".$GLOBALS['ISC_CLASS_DB']->Quote($input['shipcustomerid'])."'";
		}

		return $GLOBALS['ISC_CLASS_DB']->UpdateQuery("shipping_addresses", $savedata, $query, 1);
	}

	/**
	 * Delete a shipping address
	 *
	 * Method will delete a shipping address
	 *
	 * @access public
	 * @param int $addressid The shipping address ID
	 * @param int $customerid The optional customer ID
	 * @return bool TRUE if the shipping address was deleted successfully, FASLE otherwise
	 */
	public function delete($addressid, $customerid=null)
	{
		if (!isId($addressid)) {
			return false;
		}

		/**
		 * Make sure we have a record to delete. Also too, delete the formsession if we have one
		 */
		$shippingData = self::get($addressid, $customerid);

		if (!$shippingData) {
			return false;
		}

		if (isId($shippingData['shipformsessionid'])) {
				$GLOBALS['ISC_CLASS_FORM']->deleteFormSession($shippingData['shipformsessionid']);
			}

		$whereClause = "WHERE shipid = " . (int)$addressid;

		if (isId($customerid)) {
			$whereClause .= " AND shipcustomerid = " . (int)$customerid;
		}

		if ($GLOBALS['ISC_CLASS_DB']->DeleteQuery('shipping_addresses', $whereClause) !== false) {

			/**
			 * Delete the form session if we can
			 */
			if (isId($shippingData['shipformsessionid'])) {
				$GLOBALS['ISC_CLASS_FORM']->deleteFormSession($shippingData['shipformsessionid']);
			}

			return true;
		}

		return false;
	}

	/**
	 * Delete multiple addresses
	 *
	 * Method will delete multiple addresses
	 *
	 * @access public
	 * @param array $addressids The array containing the IDs of the addresses to delete
	 * @return bool TRUE if the addresses were all deleted, FASLE otherwise
	 */
	public function multiDelete($addressids)
	{
		if (!is_array($addressids)) {
			return false;
		}

		$addressids = array_filter($addressids, 'isId');

		foreach ($addressids as $addressids) {
			self::delete($addressids);
		}

		return true;
	}

	/**
	 * Get the shipping record
	 *
	 * Method will return the shipping record
	 *
	 * @access public
	 * @param int $shippingId The shipping ID
	 * @param int $customerid The optional customer ID
	 * @return array The shipping array on success, NULL if no record could be found, FALSE on error
	 */
	public function get($shippingId, $customerId=null)
	{
		if (!isId($shippingId)) {
			return false;
		}

		$query = "SELECT * FROM [|PREFIX|]shipping_addresses WHERE shipid=" . (int)$shippingId;

		if (isId($customerId)) {
			$query .= " AND shipcustomerid = " . (int)$customerId;
		}

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		if (!($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result))) {
			return null;
		}

		return $row;
	}

	/**
	 * Search for a matching address
	 *
	 * Method will do a predefined search for a matching address
	 *
	 * @access public
	 * @param array $address The address details array
	 * @return int The matching address ID if found, FALSE if no match
	 */
	public function basicSearch($address)
	{
		/**
		 * Clean our address array
		 */
		$address = array_map('trim', $address);
		$address = array_filter($address);

		if (!is_array($address) || !isset($address['shipcustomerid']) || !isset($address['shipfirstname']) || !isset($address['shiplastname']) || !isset($address['shipaddress1'])) {
			return false;
		}

		$searchFields = array();
		$searchFields['shipcustomerid'] = $address['shipcustomerid'];
		$searchFields['shipfirstname'] = array(
												'value' => $address['shipfirstname'],
												'func' => 'LOWER'
										);

		$searchFields['shiplastname'] = array(
												'value' => $address['shiplastname'],
												'func' => 'LOWER'
										);

		$searchFields['shipaddress1'] = array(
												'value' => $address['shipaddress1'],
												'func' => 'LOWER'
										);

		$formSessionId = 0;
		if (isset($address['shipformsessionid'])) {
			$formSessionId = $address['shipformsessionid'];
		}

		return parent::search($searchFields, array(), array(), $formSessionId);
	}
}

?>
