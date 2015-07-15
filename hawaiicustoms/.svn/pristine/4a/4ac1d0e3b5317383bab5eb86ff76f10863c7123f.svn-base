<?php
/**
 * Settings of image uploader
 * @author wilson.zeng
*/
class ISC_ADMIN_SETTINGS_IMAGEUPLOADER
{

	public function HandleToDo($Do)
	{
		if (isset($_REQUEST['currentTab'])) {
			$GLOBALS['CurrentTab'] = (int)$_REQUEST['currentTab'];
		}
		else {
			$GLOBALS['CurrentTab'] = 0;
		}

		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('settings.imageuploader');

		if (!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings_ImageUploader)) {
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			return;
		}

		$GLOBALS['BreadcrumEntries'] = array (
			GetLang('Home') => "index.php",
			GetLang('ImageUploaderSettings') => "index.php?ToDo=viewImageUploaderSettings",
		);

		switch (isc_strtolower($Do))
		{
			case "saveimageuploadersettings":
			{
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->SaveImageUploaderSettings();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}
			default:
			{
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->ManageImageUploaderSettings();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
			}
		}
	}

	/**
	* List page
	*
	* @return Void
	*/
	private function ManageImageUploaderSettings($messages=array())
	{
		$GLOBALS['Message'] = GetFlashMessageBoxes();
		
		$GLOBALS['LimitCustomerUploadImageSize'] = GetConfig("LimitCustomerUploadImageSize");
		$GLOBALS['LimitCustomerUploadImageNum'] = GetConfig("LimitCustomerUploadImageNum");//zcs=the max uploading number of total
		$GLOBALS['LimitCustomerUploadImagePerNum'] = GetConfig("LimitCustomerUploadImagePerNum");//zcs the number of per uploading
		//zcs the type of file for uploading
		$GLOBALS['LimitCustomerUploadImageFileType'] = '';
		$map_filetypes = array(
			IMAGETYPE_GIF => 'Gif',
			IMAGETYPE_JPEG => 'Jpeg',
			IMAGETYPE_PNG => 'Png',
			IMAGETYPE_SWF => 'Swf',
			IMAGETYPE_BMP => 'Bmp',
		);
		$accept_filetypes = explode(',', GetConfig("LimitCustomerUploadImageFileType"));
		foreach($map_filetypes as $filetype => $description){
			$GLOBALS['LimitCustomerUploadImageFileType'] .= '<input type="checkbox" name="LimitCustomerUploadImageFileType[]" value="'.$filetype.'" '.(in_array($filetype, $accept_filetypes) ? 'checked="checked"' : '').' /> '.$description.' ';
		}
		$GLOBALS['ImageUploaderSettingsNotifyEmail'] = trim(GetConfig("ImageUploaderSettingsNotifyEmail"));
		//zcs=instructions
		$instructionsOptions = array(
			'id'		=> 'ImageUploaderSettingsInstructions',
			'width'		=> '',
			'height'	=> '350px',
			'value'		=> base64_decode(GetConfig("ImageUploaderSettingsInstructions")),
		);
		$GLOBALS['ImageUploaderSettingsInstructions'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($instructionsOptions);
		//zcs=copyright assignment
		$assignmentOptions = array(
			'id'		=> 'ImageUploaderSettingsAssignment',
			'width'		=> '60%',
			'height'	=> '350px',
			'value'		=> base64_decode(GetConfig("ImageUploaderSettingsAssignment")),
		);
		$GLOBALS['ImageUploaderSettingsAssignment'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($assignmentOptions);
		
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.imageuploader.manage");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
	* Save
	*
	* @return Void
	*/
	private function SaveImageUploaderSettings()
	{
		$messages = array();

		if ($_POST['dopost']) {
			
			$GLOBALS['ISC_NEW_CFG']['LimitCustomerUploadImageSize'] = intval($_POST['LimitCustomerUploadImageSize']);
			$GLOBALS['ISC_NEW_CFG']['LimitCustomerUploadImageNum'] = intval($_POST['LimitCustomerUploadImageNum']);
			$GLOBALS['ISC_NEW_CFG']['LimitCustomerUploadImagePerNum'] = intval($_POST['LimitCustomerUploadImagePerNum']);
			$GLOBALS['ISC_NEW_CFG']['LimitCustomerUploadImageFileType'] = implode(',', $_POST['LimitCustomerUploadImageFileType']);
			$GLOBALS['ISC_NEW_CFG']['ImageUploaderSettingsInstructions'] = base64_encode($_POST['ImageUploaderSettingsInstructions']);
			$GLOBALS['ISC_NEW_CFG']['ImageUploaderSettingsAssignment'] = base64_encode($_POST['ImageUploaderSettingsAssignment']);
			$GLOBALS['ISC_NEW_CFG']['ImageUploaderSettingsNotifyEmail'] = trim($_POST['ImageUploaderSettingsNotifyEmail']);
			if($GLOBALS['ISC_NEW_CFG']['ImageUploaderSettingsNotifyEmail'] == ''){
				$GLOBALS['ISC_NEW_CFG']['ImageUploaderSettingsNotifyEmail'] = GetConfig('AdminEmail');
			}
			
			$settings = GetClass('ISC_ADMIN_SETTINGS');
			
			if ($settings->CommitSettings($messages)) {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
				FlashMessage(GetLang('ImageUploaderSettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewImageUploaderSettings');
			}
			else {
				FlashMessage(sprintf(GetLang('ImageUploaderSettingsNotSaved'), $messages), MSG_ERROR, 'index.php?ToDo=viewImageUploaderSettings');
			}
		}
		else {
			$this->ManageImageUploaderSettings();
		}
	}
}