<?php

	class API_ORDERS
	{

		/**
		* Store a reference to the XML object
		*/
		var $_xml;

		/**
		* DoIt
		* Handles the order related XML API requests
		*/
		function DoIt(&$XmlObject, $XmlRequest)
		{
			$this->_xml = $XmlObject;

			switch(strtolower($XmlRequest)) {
				case "getorders": {
					return $this->GetOrders();
					break;
				}
				default: {
					return false;
				}
			}
		}

		/**
		* GetOrders
		* Gets a list of orders that match the searchinfo parameters sent
		* with the request. These are identical to the options available
		* from the advanced order search in the control panel and that's the
		* exact system we tie into
		*/
		function GetOrders()
		{
			foreach($this->_xml->details as $field=>$val) {
				foreach($val as $k=>$v) {
					$_REQUEST[$k] = (string)$v;
				}
			}

			$orders = GetClass('ISC_ADMIN_ORDERS');
			$order_grid = $orders->_GetOrderList(0, "orderid", "asc", $num_orders, false);
			$order_array = array();

			if($num_orders > 0) {
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($order_grid)) {
					array_push($order_array, $row);
				}
			}

			return $order_array;
		}
	}

?>