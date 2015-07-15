<?php
	require_once(dirname(__FILE__).'/class.module.php');
	/**
	* The Interspire Shopping Cart notification base class, used by all notification modules
	*/
	class ISC_NOTIFICATION extends ISC_MODULE
	{
		/*
			Should we show a "Test Notification Method" link? Defaults to yes
		*/
		protected $_showtestlink = true;

		/**
		* @var string $type The type of module this is
		*/
		protected $type = 'notification';

		/*
			The height of the popup window to get a shipping quote
		*/
		protected $_height = 150;

		/*
			The id of the order that was just placed
		*/
		protected $_orderid = 0;

		/*
			The total of the order that was just placed
		*/
		protected $_ordertotal = 0;

		/*
			The number of items in the order that was just placed
		*/
		protected $_ordernumitems = 0;

		/*
			Return the height for the popup quote generator window
		*/
		public function GetHeight()
		{
			return $this->_height;
		}

		protected function CheckEnabled()
		{
			$notification_methods = explode(",", GetConfig('NotificationMethods'));
			if(in_array($this->GetId(), $notification_methods)) {
				return true;
			}
			else {
				return false;
			}
		}

		/*
			Return a HTML-formatted list of properties for this notification module
		*/
		public function GetPropertiesSheet($tab_id)
		{

			$this->tabId = $tab_id;

			$GLOBALS['NotificationJavaScript'] = "";
			$GLOBALS['HelpText'] = $this->gethelptext();
			$GLOBALS['HelpIcon'] = "success";
			$GLOBALS['Properties'] = "";
			$GLOBALS['ShipperId'] = $this->GetName();

			// Build the JavaScript to check the fields if required
			$GLOBALS['NotificationJavaScript'] .= sprintf("
				if(notification_selected('%s')) {
			", $this->GetId());

			// Add the logo
			$image = $this->GetImage();
			if ($image != "") {
				$GLOBALS['HelpTip'] = "";
				$GLOBALS['PropertyBox'] = sprintf("<img style='margin-top:5px' src='%s' />", $this->GetImage());
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.property");
				$GLOBALS['Properties'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}

			foreach($this->GetCustomVars() as $id=>$var) {
				$GLOBALS['PropertyBox'] = "";
				$GLOBALS['PropertyName'] = $var['name'] . ":";
				$GLOBALS['HelpTip'] = "";

				$GLOBALS['FieldId'] = $this->GetId().'_'.$id;

				if($var['type'] == 'dropdown' && isset($var['multiselect']) && $var['multiselect'] == true) {
					$GLOBALS['HideSelectAllLinks'] = '';
				}
				else {
					$GLOBALS['HideSelectAllLinks'] = 'display: none';
				}

				$GLOBALS['PropertyBox'] = $this->_buildformitem($id, $var);
				$help_id = rand(1000,100000);

				if($var['help'] != "") {
					$GLOBALS['HelpTip'] = sprintf("<img onmouseout=\"HideHelp('d%d')\" onmouseover=\"ShowHelp('d%d', '%s', '%s')\" src=\"images/help.gif\" width=\"24\" height=\"16\" border=\"0\" /><div style=\"display:none\" id=\"d%d\"></div>", $help_id, $help_id, $var['name'], $var['help'], $help_id);
				}

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.property");
				$GLOBALS['Properties'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}

			$GLOBALS['NotificationJavaScript'] .= $GLOBALS['ValidationJavascript'];
			$GLOBALS['NotificationJavaScript'] .= "}";

			// First check if the shipping provider is configured.
			// If it is, there wil be an entry in the module_vars table
			// with the variable name 'is_setup'

			$query = sprintf("select count(variableid) as is_setup from [|PREFIX|]module_vars where modulename='%s' and variablename='is_setup' and variableval='1'", $GLOBALS['ISC_CLASS_DB']->Quote($this->GetId()));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			// Add the test notification link
			if($this->_showtestlink) {
				if($row['is_setup'] > 0) {
					$GLOBALS['PropertyBox'] = sprintf("<a href='javascript:void(0)' onclick='openwin(\"index.php?ToDo=testNotificationMethodSettings&module=%s\", \"%s\", 500, %s)'>%s</a>", $this->GetId(), $this->GetId(), $this->getheight(), GetLang('TestNotificationMethod'));
				}
				else {
					$GLOBALS['PropertyBox'] = sprintf("<a href='javascript:void(0)' onclick='alert(\"%s\")'>%s</a>", GetLang('NotificationProviderNotSetup'), GetLang('TestNotificationMethod'));
				}

				$help_id = rand(1000,100000);
				$GLOBALS['PropertyName'] = "";
				$GLOBALS['Required'] = "";
				$GLOBALS['PanelBottom'] = "PanelBottom";
				$GLOBALS['HelpTip'] = sprintf("<img onmouseout=\"HideHelp('d%d')\" onmouseover=\"ShowHelp('d%d', '%s', '%s')\" src=\"images/help.gif\" width=\"24\" height=\"16\" border=\"0\"><div style=\"display:none\" id=\"d%d\"></div>", $help_id, $help_id, GetLang('TestNotificationMethod'), GetLang('TestNotificationProviderHelp'), $help_id);

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.property");
				$GLOBALS['Properties'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}

			if(count($this->GetCustomVars()) == 0) {
				// Hide the heading of the property sheet if there aren't any properties
				$GLOBALS['HidePropSheet'] = "none";
			}
			else {
				$GLOBALS['HidePropSheet'] = "";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.propertysheet");
			$sheet = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			return $sheet;
		}

		public function SetOrderId($orderid)
		{
			$this->_orderid = $orderid;
		}

		protected function GetOrderId()
		{
			return $this->_orderid;
		}

		public function SetOrderTotal($total)
		{
			$this->_ordertotal = $total;
		}

		protected function GetOrderTotal()
		{
			return $this->_ordertotal;
		}

		public function SetOrderNumItems($numitems)
		{
			$this->_ordernumitems = $numitems;
		}

		protected function GetOrderNumItems()
		{
			return $this->_ordernumitems;
		}

		public function SetOrderPaymentMethod($method)
		{
			$this->_orderpaymentmethod = $method;
		}

		protected function GetOrderPaymentMethod()
		{
			return $this->_orderpaymentmethod;
		}
	}

?>