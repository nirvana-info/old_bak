<?php

	class API_CUSTOMERS
	{

		/**
		* Store a reference to the XML object
		*/
		var $_xml;

		/**
		* DoIt
		* Handles the customer related XML API requests
		*/
		function DoIt(&$XmlObject, $XmlRequest)
		{
			$this->_xml = $XmlObject;

			switch(strtolower($XmlRequest)) {
				case "getcustomers": {
					return $this->GetCustomers();
					break;
				}
				default: {
					return false;
				}
			}
		}

		/**
		* GetCustomers
		* Gets a list of customers that match the searchinfo parameters sent
		* with the request. These are identical to the options available
		* from the advanced customer search in the control panel and that's the
		* exact system we tie into
		*/
		function GetCustomers()
		{
			foreach($this->_xml->details as $field=>$val) {
				foreach($val as $k=>$v) {
					$_REQUEST[$k] = (string)$v;
				}
			}
			$customers = GetClass('ISC_ADMIN_CUSTOMERS');
			$customer_grid = $customers->_GetCustomerList(0, "customerid", "asc", $num_customers, false);
			$customer_array = array();

			if($num_customers > 0) {
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($customer_grid)) {
					array_push($customer_array, $row);
				}
			}

			return $customer_array;
		}
	}

?>