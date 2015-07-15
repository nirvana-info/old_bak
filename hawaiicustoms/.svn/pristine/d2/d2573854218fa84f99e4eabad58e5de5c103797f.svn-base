<?php
class ISC_ADMIN_SETTINGS_ORDER
{
	/**
	 * Handle the action for this section.
	 *
	 * @param string The name of the action to do.
	 */
	public function HandleToDo($Do)
	{
		if (isset($_REQUEST['currentTab'])) {
			$GLOBALS['CurrentTab'] = (int)$_REQUEST['currentTab'];
		}
		else {
			$GLOBALS['CurrentTab'] = 0;
		}

		$GLOBALS['BreadcrumEntries'] = array (
			GetLang('Home') => "index.php",
			GetLang('Settings') => "index.php?ToDo=viewSettings",
			GetLang('OrderSettings') => "index.php?ToDo=viewScriptSettings"
		);

		if (!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings) || !gzte11(ISC_MEDIUMPRINT)) {
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			return;
		}

		/**
		 * Load the language file
		 */
		$lang = 'en';

		if (strpos(GetConfig('Language'), '/') === false) {
			$lang = GetConfig('Language');
		}

		switch(isc_strtolower($Do))
		{
			case "viewscriptsettings": {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->ManageOrderSettings();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			case "saveupdatedscriptsettings": {    
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->SaveUpdatedOrderSettings();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			} 
			default:
				if(!isset($_REQUEST['ajax'])) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				}
				$this->ManageOrderSettings();
				if(!isset($_REQUEST['ajax'])) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				}
				break;
		}
	}


	public function ManageOrderSettings($messages=array())
	{
		$GLOBALS['Message'] = GetFlashMessageBoxes();
        
        //get current field ids from data base
        $result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]order_scripts");
                                     
        while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
            if($row['scripttype']=='orderscript')    {
                $GLOBALS['CampaignCode'] = $row['scriptvalue'];
            }
            elseif($row['scripttype']=='ordermsg')    {
                $GLOBALS['OrderCompleteMsg'] = $row['scriptvalue'];
            }
        }
        
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.order.manage");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}
    
	public function SaveUpdatedOrderSettings()
	{
		$newField = array(                       
                        "scriptvalue" => $_POST['campaigncode']
                    );
        $GLOBALS['ISC_CLASS_DB']->UpdateQuery("order_scripts", $newField, "scripttype='orderscript'");   
        
        $newField1 = array(
                        "scriptvalue" => $_POST['ordercompletemsg']
                    );
        $GLOBALS['ISC_CLASS_DB']->UpdateQuery("order_scripts", $newField1, "scripttype='ordermsg'");       
              
        /*if ($settings->CommitSettings($messages)) {*/
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
			FlashMessage(GetLang('OrderSettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewScriptSettings&currentTab='.((int) $_POST['currentTab']));
		/*}
		else {
			FlashMessage(GetLang('OrderSettingsNotSaved'), MSG_ERROR, 'index.php?ToDo=viewScriptSettings&currentTab='.((int) $_POST['currentTab']));
		}*/ 
        
	}                    
}
?>