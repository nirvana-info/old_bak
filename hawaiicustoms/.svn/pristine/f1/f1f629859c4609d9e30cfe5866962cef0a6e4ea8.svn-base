<?php

	class API_PRODUCTS
	{

		/**
		* Store a reference to the XML object
		*/
		var $_xml;

		/**
		* DoIt
		* Handles the product related XML API requests
		*/
		function DoIt(&$XmlObject, $XmlRequest)
		{
			$this->_xml = $XmlObject;

			switch(strtolower($XmlRequest)) {
				case "getproducts": {
					return $this->GetProducts();
					break;
				}
				default: {
					return false;
				}
			}
		}

		/**
		* GetProducts
		* Gets a list of products that match the searchinfo parameters sent
		* with the request. These are identical to the options available
		* from the advanced product search in the control panel and that's the
		* exact system we tie into
		*/
		function GetProducts()
		{
			foreach($this->_xml->details as $field=>$val) {
				foreach($val as $k=>$v) {
					$_REQUEST[$k] = (string)$v;
				}
			}

			$products = GetClass('ISC_ADMIN_PRODUCT');
			$num_products = 0;
			$product_grid = $products->_GetProductList(0, "productid", "asc", $num_products, "", false);
			$product_array = array();

			if($num_products > 0) {
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($product_grid)) {
					array_push($product_array, $row);
				}
			}

			return $product_array;
		}
	}

?>