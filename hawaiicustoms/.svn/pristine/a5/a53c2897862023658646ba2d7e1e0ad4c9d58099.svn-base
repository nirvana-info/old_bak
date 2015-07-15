<?php
// If Shopping Cart is not loaded, then get the hell out of here
if(!defined('ISC_BASE_PATH')) {
	exit;
}

/**
 * The Interspire Shopping Cart live chat services integration base class.
 * This class is used by all live chat services that integrate with Interspire
 * Shopping Cart.
 *
 * Each live chat service extends upon this base class.
 */
class ISC_LIVECHAT extends ISC_MODULE
{
	/**
	 * @var string The type of module this is.
	 */
	public $type = 'livechat';

	/**
	 * Check if this particular module is enabled or not.
	 *
	 * @return boolean True if the module is enabled, false if not.
	 */
	public function CheckEnabled()
	{
		$liveChatServices = explode(',', GetConfig('LiveChatModules'));
		if(in_array($this->GetId(), $liveChatServices)) {
			return true;
		}

		return false;
	}

	/**
	 * Return the properties/settings sheet for this live chat module.
	 *
	 * @param int The identifier of the tab for this live chat module.
	 * @return string The properties sheet contents.
	 */
	public function GetPropertiesSheet($tabId)
	{
		$this->tabId = $tabId;

		$vars = $this->GetCustomVars();

		$GLOBALS['JavaScript'] = "";
		$GLOBALS['HelpText'] = $this->GetHelpText();
		if($this->GetHelpTextType() == 'info' && $GLOBALS['HelpText']) {
			$GLOBALS['HelpText'] = "<div class='HelpInfo'>".$GLOBALS['HelpText']."</div>";
		}
		$GLOBALS['HelpIcon'] = "success";
		$GLOBALS['Properties'] = "";
		$GLOBALS['PackageId'] = $this->GetName();
		$GLOBALS['PropertyClass'] = "properties_".$this->GetId();

		$moduleDirectory = str_replace($this->type.'_', '', $this->GetId());

		$GLOBALS['HideSelectAllLinks'] = 'display: none';

		// Add the logo
		$image = $this->GetImage();
		if ($image != "") {
			$GLOBALS['HelpTip'] = "";
			$GLOBALS['PropertyBox'] = sprintf("<img style='margin-top:5px' src='%s' />", $this->GetImage());
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.property");
			$GLOBALS['Properties'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		// Build the JavaScript to check the fields if required
		$GLOBALS['LiveChatJavascript'] .= sprintf("
			if(package_selected('%s')) {
		", $this->GetId());

		foreach($vars as $id => $var) {
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

			$GLOBALS['PropertyBox'] = $this->_BuildFormItem($id, $var);
			$helpId = rand(1000,100000);

			if(isset($var['help']) && $var['help'] != "") {
				$GLOBALS['HelpTip'] = sprintf("<img onmouseout=\"HideHelp('d%d')\" onmouseover=\"ShowHelp('d%d', '%s', '%s')\" src=\"images/help.gif\" width=\"24\" height=\"16\" border=\"0\"><div style=\"display:none\" id=\"d%d\"></div>", $helpId, $helpId, $var['name'], $var['help'], $helpId);
			}

			if(isset($var['visible']) && $var['visible'] == false) {
				$GLOBALS['HideProperty'] = 'display: none';
			}
			else {
				$GLOBALS['HideProperty'] = '';
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.property");
			$GLOBALS['Properties'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		$GLOBALS['LiveChatJavascript'] .= $GLOBALS['ValidationJavascript'];
		$GLOBALS['LiveChatJavascript'] .= "}";

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("module.propertysheet");
		$sheet = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		return $sheet;
	}

	/**
	 * Return a list of the enabled live chat modules.
	 *
	 * @return array An array containing the enabled live chat modules.
	 */
	public function GetEnabledModules()
	{
		return GetAvailableModules('livechat', true);
	}

	/**
	 * Get the live chat tracking code for this module for the specified page position.
	 *
	 * @param string The position (header or panel) to fetch the tracking code for. If not the position that's
	 *				 enabled for this module, then this method should return an empty string.
	 * @return string String containing the live chat code.
	 */
	public function GetLiveChatCode($position)
	{
		return '';
	}

	/**
	 * Get the live chat service tracking code for the enabled live chat services for
	 * a specific location (header or panel)
	 */
	public function GetPageTrackingCode($position)
	{
		$enabledModules = $this->GetEnabledModules();
		if(empty($enabledModules)) {
			return '';
		}

		$chatCode = '';
		foreach($enabledModules as $module) {
			$chatCode .= $module['object']->GetLiveChatCode($position);
		}

		$chatCode = str_replace('%%IMG_DIRECTORY%%', GetConfig('ShopPathSSL').'/templates/'.GetConfig('template').'/images/'.GetConfig('SiteColor'), $chatCode);

		return $chatCode;
	}
}

?>
