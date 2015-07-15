<?php

	class ISC_ADMIN_QUICKSEARCH
	{
		var $_query = "";

		function __construct()
		{
			if(isset($_REQUEST['query'])) {
				$this->_query = $GLOBALS['ISC_CLASS_DB']->Quote($_REQUEST['query']);
			}
			else {
				header("Location:index.php");
			}
		}

		function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
			$this->QuickSearch();
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
		}

		/**
		*	Perform a search for all orders, products and customers that match the specified
		*	search query and show them in a list with a link to view all results for each
		*/
		function QuickSearch()
		{
			require_once(dirname(__FILE__) . "/class.orders.php");
			require_once(dirname(__FILE__) . "/class.customers.php");
			require_once(dirname(__FILE__) . "/class.product.php");

			$orders = GetClass('ISC_ADMIN_ORDERS');
			$customers = GetClass('ISC_ADMIN_CUSTOMERS');
			$products = GetClass('ISC_ADMIN_PRODUCT');

			$num_orders = $num_customers = $num_products = 0;

			// Get the number of orders
			$_REQUEST['searchQuery'] = $this->_query;
			$orders->_GetOrderList(0, "orderid", "asc", $num_orders);

			// Get the number of customers
			$_REQUEST['searchQuery'] = $this->_query;
			$customers->_GetCustomerList(0, "customerid", "asc", $num_customers);

			// Get the number of products
			$_REQUEST['searchQuery'] = $this->_query;
			$products->_GetProductList(0, "productid", "asc", $num_products);

			$num_results = $num_orders + $num_customers + $num_products;

			if($num_results == 1) {
				$msg = GetLang('QuickSearchResults1');
			}
			else {
				$msg = sprintf(GetLang('QuickSearchResultsX'), $num_results);
			}

			$this->_query = isc_html_escape($this->_query);

			if($num_orders == 1) {
				$GLOBALS['OrdersLink'] = sprintf(GetLang('QuickSearchOrders1'), $this->_query);
			}
			else {
				$GLOBALS['OrdersLink'] = sprintf(GetLang('QuickSearchOrdersX'), $num_orders, $this->_query);
			}

			if($num_customers == 1) {
				$GLOBALS['CustomersLink'] = sprintf(GetLang('QuickSearchCustomers1'), $this->_query);
			}
			else {
				$GLOBALS['CustomersLink'] = sprintf(GetLang('QuickSearchCustomersX'), $num_customers, $this->_query);
			}

			if($num_products == 1) {
				$GLOBALS['ProductsLink'] = sprintf(GetLang('QuickSearchProducts1'), $this->_query);
			}
			else {
				$GLOBALS['ProductsLink'] = sprintf(GetLang('QuickSearchProductsX'), $num_products, $this->_query);
			}

			$GLOBALS['Message'] = MessageBox($msg, MSG_INFO);
			$GLOBALS['Query'] = $this->_query;

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("quicksearch");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}
	}

?>
