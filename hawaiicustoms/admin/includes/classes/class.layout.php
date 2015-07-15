<?php
GetLib('class.remoteopener');
class ISC_ADMIN_LAYOUT
{
	/**
	 * @var boolean True if safe_mode is enabled on this server.
	 */
	private $safeMode = false;

	private $NoCurlFopen = false;

	/**
	 * The constructor.
	 */
	public function __construct()
	{
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('layout');
	}

	public function HandleToDo($Do)
	{
		$GLOBALS['BreadcrumEntries'] = array(
			GetLang('Home') => 'index.php',
			GetLang('Templates') => 'index.php?ToDo=viewTemplates'
		);

		if(!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Templates)) {
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			exit;
		}
		$GLOBALS['AutoDownload'] = '';

		// If safe mode is enabld, template downloading will not work correctly.
		if(ini_get('safe_mode') == 1 || strtolower(ini_get('safe_mode')) == 'on') {
			$this->safeMode = true;
		}

		switch(isc_strtolower($Do)) {
			case "templatedownload":
				$this->DownloadNewTemplates1();
				break;
			case "templateuploadlogo":
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->UploadLogo();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				exit;
			case "changetemplate":
				$this->ChangeTemplate();
				exit;
			default:
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->ManageLayouts();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
		}
	}


	/**
	 * Build a logo based on the specified parameters.
	 *
	 * @param string The name of the logo to use. Pass [template] to build a logo for the current store design.
	 * @param array Array of text for the logo.
	 */
	public function BuildLogo($logoName, $text=array())
	{
		GetLib('logomaker/class.logomaker');
		$logoName = basename($logoName);
		$originalLogoName = $logoName;

		$filePrefix = '';
		if($logoName == "[template]") {
			$logoPath = ISC_BASE_PATH."/templates/".GetConfig('template')."/logo/";
			$configFile = $logoPath.'config.php';
			$logoName = GetConfig('template');
		}
		else {
			$logoPath = ISC_BASE_PATH.'/templates/__logos/';
			$configFile = $logoPath.$logoName . '_config.php';
		}

		if(!file_exists($configFile)) {
			return false;
		}

		require $configFile;

		$className = $logoName .'_logo';
		$tmpClass = new $className;
		$logoImage = $logoName.'.'.$tmpClass->FileType;

		$s = GetClass('ISC_ADMIN_SETTINGS');
		$GLOBALS['ISC_NEW_CFG'] = array();

		if($text[0] == '') {
			$text[0] = GetConfig('StoreName');
		}

		$fields = array();
		foreach($text as $k => $textField) {
			$tmpClass->Text[$k] = $textField;
			$fields[] = $textField;
		}

		if(count($fields) > 0) {
			$GLOBALS['ISC_NEW_CFG']['LogoFields'] = $fields;
		}

		$logoData = $tmpClass->GenerateLogo();
		ClearTmpLogoImages();

		$imageFile = 'website_logo.'.$tmpClass->FileType;
		file_put_contents(ISC_BASE_PATH . '/'.GetConfig('ImageDirectory').'/'.$imageFile, $logoData);
		$GLOBALS['ISC_NEW_CFG']['StoreLogo'] = $imageFile;
		$GLOBALS['ISC_NEW_CFG']['UsingLogoEditor'] = 1;
		$GLOBALS['ISC_NEW_CFG']['LogoType'] = 'image';
		if($originalLogoName == "[template]") {
			$GLOBALS['ISC_NEW_CFG']['UsingTemplateLogo'] = 1;
		}
		else {
			$GLOBALS['ISC_NEW_CFG']['UsingTemplateLogo'] = 0;
		}
		$s->CommitSettings();

		return $imageFile;
	}

	private function ChangeTemplate()
	{
		GetLib('class.file');

		$settings = GetClass('ISC_ADMIN_SETTINGS');
		$GLOBALS['ISC_NEW_CFG']['template'] = AlphaNumOnly($_REQUEST['template']);

		$StylePath = ISC_BASE_PATH . "/templates/" .AlphaNumOnly($_REQUEST['template']) .'/Styles';
		$color = isc_strtolower(AlphaNumOnly($_REQUEST['color']));
		if(file_exists($StylePath."/".$color.".css")) {
			$GLOBALS['ISC_NEW_CFG']['SiteColor'] = $color;
		}

		if(file_exists(ISC_BASE_PATH . '/templates/'. AlphaNumOnly($_REQUEST['template'])  . '/config.php')) {
			include(ISC_BASE_PATH . '/templates/'.AlphaNumOnly($_REQUEST['template'])  . '/config.php');
		}

		if($color != '') {
			$GLOBALS['ISC_NEW_CFG']['SiteColor'] = $color;
		}

		$settings->CommitSettings();

		// If we're currently using a logo template, then we need to rebuild it
		if(GetConfig('UsingTemplateLogo') && GetConfig('UsingLogoEditor')) {
			if(!$this->BuildLogo('[template]', GetConfig('LogoFields'))) {
				$GLOBALS['ISC_NEW_CFG'] = array(
					'UsingTemplateLogo' => 0,
					'UsingLogoEditor' => 0,
					'LogoType' => 'text'
				);
				$settings->CommitSettings();
			}
		}


		if(isset($_REQUEST['page'])) {
			$pageNumber = (int)$_REQUEST['page'];
		}
		else {
			$pageNumber = 1;
		}

		// Log this action
		$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(GetConfig('template'), GetConfig('SiteColor'));

		FlashMessage(sprintf(GetLang('TemplateSelected'), ucfirst($_REQUEST['template'])), MSG_SUCCESS, 'index.php?ToDo=viewTemplates&page=' . $pageNumber);
	}

	public function LoadDownloadTemplates()
	{
		if((isset($_SESSION['ForceDownloadTemplates']) && $_SESSION['ForceDownloadTemplates'] == true) || (isset($_REQUEST['forceCheck']) && $_REQUEST['forceCheck'] == '1')) {
			$_SESSION['ForceDownloadTemplates'] = false;
			unset($_SESSION['ForceDownloadTemplates']);
			$GLOBALS['AutoDownload'] .= "\nwindow.setTimeout('CheckNewTemplates()', 200);";
		}
	}

	public function IsValidUploadedLogo($logo)
	{
		// If we've just uploaded an image, we need to perform a bit of additional validation
		// to ensure it's not someone uploading bogus images.
		$imageExtensions = array(
			'gif',
			'png',
			'jpg',
			'jpeg',
			'jpe',
		);
		$extension = GetFileExtension($logo['name']);
		if(!in_array($extension, $imageExtensions)) {
			return false;
		}

		// Check a list of known MIME types to establish the type of image we're uploading
		switch(isc_strtolower($logo['type'])) {
			case 'image/gif':
				$imageType = IMAGETYPE_GIF;
				break;
			case 'image/jpg':
			case 'image/x-jpeg':
			case 'image/x-jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
			case 'image/jpg':
				$imageType = IMAGETYPE_JPEG;
				break;
			case 'image/png':
			case 'image/x-png':
				$imageType = IMAGETYPE_PNG;
				break;
			case 'image/bmp':
				$imageType = IMAGETYPE_BMP;
				break;
			case 'image/tiff':
				$imageType = IMAGETYPE_TIFF_II;
				break;
			default:
				$imageType = 0;
		}

		$imageDimensions = getimagesize($logo['tmp_name']);
		if(!is_array($imageDimensions) || $imageDimensions[2] != $imageType) {
			return false;
		}
		return true;
	}

	private function UploadLogo()
	{
		if($_FILES['LogoFile']['error'] == 0 && $_FILES['LogoFile']['size'] > 0) {
			if(!$this->IsValidUploadedLogo($_FILES['LogoFile'])) {
				$this->ManageLayouts(GetLang('UploadedLogoNoValidImage2'), MSG_ERROR);
			}
			else {
				$_FILES['LogoFile']['name'] = basename($_FILES['LogoFile']['name']);

				// Upload and store the actual logo
				if(move_uploaded_file($_FILES['LogoFile']['tmp_name'], ISC_BASE_PATH . '/' . GetConfig('ImageDirectory') . '/' . basename($_FILES['LogoFile']['name']))) {
					// Save the updated logo in the configuration file
					$GLOBALS['ISC_NEW_CFG']['StoreLogo'] = $_FILES['LogoFile']['name'];
					$GLOBALS['ISC_NEW_CFG']['UsingTemplateLogo'] = 0;
					$GLOBALS['ISC_NEW_CFG']['LogoType'] = 'image';
					$GLOBALS['ISC_NEW_CFG']['UsingLogoEditor'] = 0;
					$settings = GetClass('ISC_ADMIN_SETTINGS');
					if($settings->CommitSettings()) {
						isc_chmod(ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/'.$GLOBALS['ISC_NEW_CFG']['StoreLogo'], ISC_WRITEABLE_FILE_PERM);
						FlashMessage(GetLang('LogoUploadSuccess'), MSG_SUCCESS, 'index.php?ToDo=viewTemplates');
					}
					else {
						FlashMessage(GetLang('UploadWorkedConfigError'), MSG_ERROR, 'index.php?ToDo=viewTemplates');
					}
				}
				else {
					FlashMessage(GetLang('UploadErrorPath'), MSG_ERROR, 'index.php?ToDo=viewTemplates');
				}
			}
		}
		else {
			FlashMessage(GetLang('LogoUploadNoValidImage'), MSG_ERROR, 'index.php?ToDo=viewTemplates');
			exit;
		}
	}

	/**
	 * Get a list of logos currently installed and return them as a sorted array.
	 *
	 * @return array Array of logos
	 */
	public function GetLogoList($forceType='')
	{
		$directories = array(
			'template' => ISC_BASE_PATH."/templates/".GetConfig('template')."/__logos"
		);

		$logos = array();

		foreach($directories as $type => $dir) {
			// If we only want logos of a particular type, then skip whar we don't want
			if($forceType != '' && $type != $forceType) {
				continue;
			}

			if(!is_dir($dir)) {
				continue;
			}

			$files = scandir($dir);
			foreach($files as $file) {
				if($file{0} == "." || $file{0} == "0" || $file == "CVS") {
					continue;
				}
				if(preg_match('#_config\.php$#', $file)) {
					$file = preg_replace('#_config\.php$#', "", $file);
					$id = strtolower($type."-".$file);
					$logos[$id] = array(
						'type' => $type,
						'name' => $file
					);
				}
			}
		}

		if(!empty($logos)) {
			// Now sort the actual logos
			uksort($logos, array($this, "CustomLogoSort"));
		}
		return $logos;
	}

	public function CustomLogoSort($a, $b)
	{
		return strcasecmp($a['name'], $b['name']);
	}

	public function LoadLogoList()
	{
		GetLib('logomaker/class.logomaker');

		$logoDirectory = ISC_BASE_PATH."/templates/".GetConfig('template')."/__logos";
		$logoURL = GetConfig('AppPath')."/templates/".GetConfig('template')."/__logos";

		if(!is_dir($logoDirectory)) {
			return '';
		}

		$logos = scandir($logoDirectory);
		$logoList = '';
		foreach($logos as $file) {
			if(!preg_match('#_config\.php$#', $file)) {
				continue;
			}
			$logo = str_replace('_config.php', '', $file);
			require $logoDirectory."/".$file;
			$className = $logo.'_logo';
			if(!class_exists($className)) {
				continue;
			}
			$logoClass = new $className;
			$logoImage = $logo.'.'.$logoClass->FileType;

			if(!file_exists(ISC_BASE_PATH."/cache/logos/".$logoImage)) {
				$logoData = $logoClass->GenerateLogo();
				file_put_contents(ISC_BASE_PATH."/cache/logos/".$logoImage, $logoData);
			}
			$logoList .= '<a href="javascript:SelectLogo(\''.$logo.'\', \''.$logoImage.'\', '.(int)$logoClass->TextFieldCount.')"><img src="../cache/logos/'.$logoImage.'" style="border:1px solid #EBEBEB; margin: 10px; "></a>';
		}
		return $logoList;
	}

	public function GetTemplateLogo($template="")
	{
		if($template == '') {
			$template = GetConfig('template');
		}
		$logoDirectory = ISC_BASE_PATH."/templates/".$template."/logo/";
		if(!is_dir($logoDirectory) || !file_exists($logoDirectory."config.php")) {
			return false;
		}
		$logo = $template;
		require $logoDirectory."config.php";
		$className = $logo.'_logo';
		if(!class_exists($className)) {
			return false;
		}
		$logoClass = new $className;
		$logoImage = $template.'.'.$logo.'.'.$logoClass->FileType;

		if(!file_exists(ISC_BASE_PATH."/cache/logos/".$logoImage)) {
			$logoData = $logoClass->GenerateLogo();
			file_put_contents(ISC_BASE_PATH."/cache/logos/".$logoImage, $logoData);
		}

		return array(
			"fields" => $logoClass->TextFieldCount,
			"preview" => $logoImage
		);
	}

	public function LoadLogoTab()
	{
		$GLOBALS['AlernateTitle'] = GetConfig('StoreName');

		$logoType = GetConfig('UsingLogoEditor');
		if($logoType == 1) {
			$usingEditor = 1;
		}
		else {
			$usingEditor = 0;
		}
		$forceWebsiteTitle = GetConfig('ForceWebsiteTitleText');

		$GLOBALS['SelectALogoHide'] = 'none';

		if($usingEditor && GetConfig('LogoType') != 'text') {
			if(GetConfig('UsingTemplateLogo')) {
				$GLOBALS['TemplateLogoChecked'] = "checked=\"checked\"";
				$GLOBALS['LogoTypeSelected'] = "template";
			}
			else {
				$GLOBALS['SelectALogoHide'] = '';
				$GLOBALS['CustomLogoChecked'] = "checked=\"checked\"";
				$GLOBALS['LogoTypeSelected'] = "generic";
			}
			$GLOBALS['LogoImageSelected'] = 'create';
		}
		else if(!$usingEditor && GetConfig('LogoType') != 'text') {
			$GLOBALS['LogoImageSelected'] = 'upload';
		}
		else {
			$altTitle = GetConfig('AlternateTitle');
			if(!empty($altTitle)) {
				$GLOBALS['AlternateChecked'] = 'checked="checked"';
				$GLOBALS['AlternateTitle'] = GetConfig('AlternateTitle');
			}
			else {
				$GLOBALS['AlternateNotChecked'] = 'checked="checked"';
			}
			$GLOBALS['LogoImageSelected'] = "none";
		}

		$GLOBALS['GenericLogos'] = $this->LoadLogoList('generic');
		if(!$GLOBALS['GenericLogos']) {
			$GLOBALS['HideGenericLogoList'] = 'none';
		}
		else {
			$GLOBALS['HideNoLogosMessage'] = 'none';
		}

		$GLOBALS['HideNoTTFError'] = 'none';
		if(!function_exists('imagettftext')) {
			$GLOBALS['HideNoTTFError'] = '';
			$GLOBALS['HideLogoOptionsNoFont'] = "none";
		}
		else {
			// Get the logo for this current template if we have one
			$templateLogo = $this->GetTemplateLogo();
			if(is_array($templateLogo)) {
				$GLOBALS['TemplateLogoFile'] = $templateLogo['preview'];
				$GLOBALS['TemplateLogoFileNumFields'] = $templateLogo['fields'];
			}
			else {
				$GLOBALS['DisableTemplateOption'] = 'disabled="disabled"';
				$GLOBALS['DisableTemplateOptionClass'] = "Disabled";
			}

			$text = GetConfig('LogoFields');

			if(is_array($text)) {
				foreach($text as $k => $v) {
					$text[$k] = addslashes($v);
				}
				$GLOBALS['TextArray'] = "'".implode("', '", $text). "'";
			}
			else {
				$GLOBALS['TextArray'] = "'".GetConfig('StoreName')."'";
			}
		}

		if($GLOBALS['LogoImageSelected'] != 'none' && GetConfig('StoreLogo')) {
			$GLOBALS['CurrentLogo'] = GetConfig('AppPath') . '/' . GetConfig('ImageDirectory'). '/'. GetConfig('StoreLogo');
			$GLOBALS['HideCurrentLogo'] = '';
		}
		else {
			$GLOBALS['CurrentLogo'] = GetConfig('AppPath') . '/admin/images/nologo.gif';
			$GLOBALS['HideCurrentLogo'] = '';
		}

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("layout.logo.form");
		$GLOBALS['LogoTab'] = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
	}

	public function DownloadNewTemplates1()
	{
		if(!isset($_REQUEST['template'])) {
			exit;
		}

		// Get the information about this template from the remote server
		$url = $this->BuildTemplateURL($GLOBALS['ISC_CFG']['TemplateInfoURL'], array(
			"template" => urlencode($_REQUEST['template'])
		));
		$response = PostToRemoteFileAndGetResponse($url);

		// A remote connection couldn't be established
		if($response === null) {
			exit;
		}

		$templateXML = @simplexml_load_string($response);
		if(!is_object($templateXML)) {
			exit;
		}

		if(isset($templateXML->error) && $templateXML->error == "invalid") {
			exit;
		}

		$templateName = strval($templateXML->name);
		$GLOBALS['DownloadPleaseWait'] = sprintf(GetLang('DownloadPleaseWait'), $templateName);

		// If this template has a price set, they need to either purchase it or enter the license key for it
		if(isset($templateXML->price) && $templateXML->price > 0) {
			// If this template has already been purchased (there is a valid license key in the config file), start the downloader
			$templateKeys = GetConfig('TemplateKeys');
			if(is_array($templateKeys) && isset($templateKeys[$templateId])) {
				$this->LoadTemplateDownloader($_REQUEST['template'], $templateName);
			}

			if(GetConfig('TemplateMarkup') < 1) {
				$GLOBALS['ISC_CFG']['TemplateMarkup'] = 1;
			}
			$GLOBALS['TemplateAmount'] = GetLang('Currency').round(($templateXML->price * GetConfig('TemplateMarkup')), 2) . ' '.GetLang('USD');

			$GLOBALS['PreviewImage'] = strval($templateXML->preview);
			$GLOBALS['TemplateName'] = $templateName;

			$GLOBALS['Message'] = sprintf(GetLang('MustPurchaseTemplate'), $GLOBALS['TemplateAmount']);
			$GLOBALS['TemplatePurchaseCode'] = 'TemplatePurchase("' . $templateName . '");';

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('downloadernew.buynow');
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			exit;
		}
		// This is a free template. Start the download process
		else {
			$this->LoadTemplateDownloader($_REQUEST['template'], $templateName);
		}
	}

	public function LoadTemplateDownloader($templateId, $templateName)
	{
		if($this->safeMode) {
			$urls = $this->GenerateTemplateDownloadURLs($templateId);
			echo "<script type='text/javascript'>";
			echo "tb_remove();";
			echo "window.location = '".$urls['streamUrl']."';";
			echo "</script>";
			exit;
		}
		$GLOBALS['TemplateId'] = $templateId;
		$GLOBALS['TemplateName'] = $templateName;
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('downloadernew.loading');
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		exit;
	}

	/**
	 * Generate the URLs to download a particular template.
	 *
	 * @param string The name of the template we wish to generate the download URLs for.
	 * @param string The license key if there is one.
	 * @return array An array containing the download URL and the verification URL.
	 */
	private function GenerateTemplateDownloadURLs($template, $key="")
	{
		$urlBits = array(
			'template' => urlencode($template)
		);
		$host = base64_encode($_SERVER['HTTP_HOST']);
		if(isset($key)) {
			$urlBits['key'] = urlencode($key);
			$urlBits['host'] = $host;
		}
		else {
			$templateKeys = GetConfig('TemplateKeys');
			if(is_array($templateKeys) && isset($templateKeys[$templateId])) {
				$key = $templateKeys[$templateId];
				$urlBits['key'] = urlencode($key);
				$urlBits['host'] = $host;
			}
		}

		$url = $this->BuildTemplateURL($GLOBALS['ISC_CFG']['TemplateVerifyURL'], $urlBits);
		$streamUrl = $this->BuildTemplateURL($GLOBALS['ISC_CFG']['TemplateStreamURL'], $urlBits);
		return array(
			'url'		=> $url,
			'streamUrl'	=> $streamUrl
		);
	}

	public function DownloadNewTemplates2()
	{
		if(!isset($_REQUEST['template'])) {
			exit;
		}

		// Include the File_Archive package
		GetLib('class.zip');

		GetLib('class.file');
		$FileClass = new FileClass();

		$key = '';
		if(isset($_REQUEST['key'])) {
			$key = $_REQUEST['key'];
		}

		$downloadUrls = $this->GenerateTemplateDownloadURLs($_REQUEST['template'], $key);
		$url = $downloadUrls['url'];
		$streamUrl = $downloadUrls['streamUrl'];

		// Get the information about this template from the remote server
		$response = PostToRemoteFileAndGetResponse($url);

		// A remote connection couldn't be established
		if($response === null) {
			exit;
		}

		$templateXML = @simplexml_load_string($response);
		if(!is_object($templateXML)) {
			exit;
		}

		if(isset($templateXML->error)) {
			switch(strval($templateXML->error)) {
				case "invalid":
					$GLOBALS['ErrorMessage'] = GetLang('InvalidKey');
					return false;
				case "invalid_domain":
					$GLOBALS['ErrorMessage'] = GetLang('InvalidKeyDomain');
					return false;
				case "invalid_tpl":
					$GLOBALS['ErrorMessage'] = GetLang('InvalidKeyTemplate');
					return false;
				case "invalid_tpl2":
					$GLOBALS['ErrorMessage'] = GetLang('InvalidKeyTemplate2');
					return false;
				default:
					$GLOBALS['ErrorMessage'] = GetLang('InvalidTemplate');
					return false;
			}
		}

		// If safemode is enabled, simply redirect to the stream URL to download the ZIP
		if($this->safeMode) {
			header("Location: ".$streamUrl);
			exit;
		}

		// Template is valid, so download the zip file
		$data = PostToRemoteFileAndGetResponse($streamUrl, '', false);
		if($data === null) {
			exit;
		}

		$tmp_dir = ISC_BASE_PATH . "/cache/";
		$filename = $this->_GenRandFileName();
		$tmpFile = $tmp_dir . $filename . ".zip";

		// If we can't write to the temporary directory, show a message
		if(!CheckDirWritable($tmp_dir)) {
			$GLOBALS['ErrorMessage'] = GetLang('TempDirWriteError');
			return false;
		}

		// Cannot write the temporary file
		if(!$fp = @fopen($tmpFile, "wb+")) {
			$GLOBALS['ErrorMessage'] = GetLang("TempDirWriteError");
			return false;
		}

		// Write the contents
		if(!@fwrite($fp, $data)) {
			$GLOBALS['ErrorMessage'] = GetLang("TempDirWriteError");
			return false;
		}

		@fclose($fp);

		$templateName = strval($templateXML->name);

		// If this is an update for the template, remove the old one first
		$templatePath = ISC_BASE_PATH."/templates/".basename($_REQUEST['template']);
		if(is_dir($templatePath)) {
			$FileClass->SetDir('');
			$deleted = $FileClass->DeleteDir($templatePath, true);
			// Couldn't remove old template first
			if(!$deleted) {
				$GLOBALS['ErrorMessage'] = sprintf(GetLang("TemplateUnlinkError"), $templateName);
				return false;
			}
		}

		// Extract the new template
		$archive = new PclZip($tmpFile);
		if($archive->extract(PCLZIP_OPT_PATH, ISC_BASE_PATH."/templates") === 0) {
			$GLOBALS['ErrorMessage'] = GetLang('TemplateDirWriteError');
			return false;
		}

		// Remove the temporary file
		@unlink($tmpFile);

		// Set the file permissions on the new template
		$file = new FileClass;
		$file->SetLoadDir(ISC_BASE_PATH."/templates");
		$file->ChangeMode(basename($templatePath), ISC_WRITEABLE_DIR_PERM, ISC_WRITEABLE_FILE_PERM, true);
		$file->CloseHandle();
	}

	/**
	 * Check for new templates to download.
	 */
	public function CheckDownloadTemplates()
	{
		$GLOBALS['TemplateGrid'] = '';
		$numNew = 0;
		$numExisting = 0;

		// Get the list of currently installed templates
		$existingTemplates = $this->_GetTemplateList();
		$numExisting = count($existingTemplates);

		// Fetch the list of available templates for this version
		$url = $this->BuildTemplateURL($GLOBALS['ISC_CFG']['TemplateURL'], array(
			"version" => PRODUCT_VERSION_CODE
		));

		// Send off a request to the remote server to get a list of available logos
		$response = PostToRemoteFileAndGetResponse($url);

		// A remote connection couldn't be established
		if($response === null || $response === false) {
			$GLOBALS['NewTemplateIntro'] = GetLang('NoNewTemplates');
			return false;
		}

		$templateXML = @simplexml_load_string($response);
		if(!is_object($templateXML)) {
			$GLOBALS['NewTemplateIntro'] = GetLang('NoNewTemplates');
			return false;
		}

		// Loop through the available templates
		foreach($templateXML->template as $template) {
			$templateId = strval($template->id);

			// Don't show this template if we already have it installed
			if(in_array($templateId, $existingTemplates)) {
				continue;
			}

			$templateName = strval($template->name);
			$GLOBALS['TemplateId'] = $templateId;
			$GLOBALS['Name'] = $templateName;

			if(GetConfig('AllowTemplatePurchase') == 1) {
				// Purchase support needs to go in here
			}

			if(isset($template->price) && strval($templae->price) > 0) {
				if(GetConfig('TemplateMarkup') < 1) {
					$GLOBALS['ISC_CFG']['TemplateMarkup'] = 1;
				}
				$GLOBALS['ButtonText'] = GetLang('DownloadTemplate') . ' ($' . round(($template->price * GetConfig('TemplateMarkup')), 2) .' USD)';
				$GLOBALS['PopupWidth'] = '300';
				$GLOBALS['PopupHeight'] = '250';
			}
			else {
				$GLOBALS['ButtonText'] = GetLang('DownloadTemplate') . ' (Free)';
				if(strpos('MSIE 6', $_SERVER['HTTP_USER_AGENT']) !== false) {
					//using ie6!
					$GLOBALS['PopupWidth'] = '290';
					$GLOBALS['PopupHeight'] = '75';
				}
				else {
					$GLOBALS['PopupWidth'] = '240';
					$GLOBALS['PopupHeight'] = '58';
				}
			}

			$GLOBALS['ColorList'] = '';
			$firstColor = null;
			foreach($template->colors->color as $color) {
				$colorHex = strval($color->hex);
				$colorName = strval($color->name);

				if($firstColor === null) {
					$GLOBALS['DefaultPreviewImageFull'] = strval($color->previewFull);
					$GLOBALS['DefaultPreviewImageSmall'] = strval($color->preview);
					$firstColor = $colorHex;
				}

				$GLOBALS['ColorList'] .= '
					<img src="images/blank.gif" width="12" height="12" style="cursor: pointer; background: '.$colorHex.'; margin-right: 2px; margin-top: 5px; border: 1px solid black;" title="'.$colorName.'" onclick="javascript: ChangeTemplateColor(this, \''.strval($color->preview).'\', \''.strval($color->previewFull).'\');" />
				';
			}
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('downloadernew.manage.row');
			$templateCode = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);

			$GLOBALS['TemplateGrid'] .= '<div class="TemplateBox" id="dl_'.$templateId.'">'.$templateCode.'</div>';
			++$numNew;
		}

		if($numNew > 0) {
			$GLOBALS['NumNew'] = $numNew;
			if($numNew == 1) {
				$GLOBALS['NewTemplateIntro'] = sprintf(GetLang('NewTemplateIntro1'), $numNew);
			}
			else {
				$GLOBALS['NewTemplateIntro'] = sprintf(GetLang('NewTemplateIntro2'), $numNew);
			}
		}
		else {
			$GLOBALS['NumNew'] = 0;
			$GLOBALS['DisplayGrid'] = 'none';
			$GLOBALS['NewTemplateIntro'] = GetLang('NoNewTemplates');
		}
	}

	public function LoadChooseTemplateTab()
	{
		$templatePath = ISC_BASE_PATH."/templates";
		GetLib('class.file');
		$templateCount = 0;

		$templates = scandir($templatePath);
		natcasesort($templates);

		foreach($templates as $k => $template) {
			if ($template == "." || $template == ".." || $template == "CVS" || $template == ".svn" || $template == 'blank.dat' || $template{0} == '_') {
				continue;
			}
			$previewPath = $templatePath . '/' . $template . '/Previews';
			if(!is_dir($previewPath)) {
				continue;
			}

			$previews = new FileClass;
			$previews->SetLoadDir($previewPath);

			$doneColors = array();
			while(($preview = $previews->NextFile()) !== false) {
				if(substr($preview,-4) != ".jpg" && substr($preview,-5) != ".jpeg" && substr($preview,-4) != ".gif") {
					continue;
				}
				$templateColor = ucfirst(str_replace(array(".jpg",".jpeg","gif","fixed_","stretched_"), "", strtolower($preview)));
				if(in_array($templateColor, $doneColors)) {
					continue;
				}
				$doneColors[] = $templateColor;

				$templateList[] = array(
					'template' => $template,
					'templateName' => ucfirst($template),
					'templateColor' => $templateColor,
					'preview' => $preview,
					'id' => uniqid(5)
				);
				++$templateCount;

				if(GetConfig('template') == $template && strtolower($templateColor) == GetConfig('SiteColor')) {
					$GLOBALS['CurrentTemplateImage'] = $preview;
				}
			}
		}


		if(isset($_REQUEST['page'])) {
			$pageNumber = (int)$_REQUEST['page'];
		}
		else {
			$pageNumber = 1;
		}

		$perPage = 20;
		if (isset($_REQUEST['perpage'])) {
			$perPage = (int)$_REQUEST['perpage'];
		}

		$startNumber = ($pageNumber * $perPage) - $perPage;
		$pageCount = ceil(count($templateList) / $perPage);

		$GLOBALS['PageNumber'] = $pageNumber;

		switch($perPage) {
			case 10:
				$GLOBALS['PerPage10Selected'] = 'selected="selected"';
			break;
			case 50:
				$GLOBALS['PerPage50Selected'] = 'selected="selected"';
			break;
			case 100:
				$GLOBALS['PerPage100Selected'] = 'selected="selected"';
			break;
			default:
				$GLOBALS['PerPage20Selected'] = 'selected="selected"';
			break;
		}

		$GLOBALS['Nav'] = '';
		if($pageCount > 1) {
			$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $pageNumber, $pageCount);
			$GLOBALS['Nav'] .= BuildPagination(count($templateList), $perPage, $pageNumber, "index.php?ToDo=viewTemplates");
		}

		$GLOBALS['TemplateListMap'] = '';

		for($i = $startNumber; $i < ($startNumber+$perPage); ++$i) {
			if(!isset($templateList[$i])) {
				continue;
			}
			$template = $templateList[$i];
			$GLOBALS['Template'] = $template['template'];
			$GLOBALS['TemplateName'] = $template['templateName'];
			$GLOBALS['TemplateColor'] = $template['templateColor'];
			$GLOBALS['TemplatePreview'] = $template['preview'];
			$GLOBALS['TemplateID'] = $template['id'];

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('layout.choosetemplate.row');
			$templateCode = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);

			if(strtolower($template['templateColor']) == strtolower(GetConfig('SiteColor')) && $template['template'] == GetConfig('template')) {
				$GLOBALS['TemplateListMap'] .= '<div class="TemplateBoxOn" id="'.$GLOBALS['TemplateID'] .'">'.$templateCode.'</div>';
			}
			else {
				$GLOBALS['TemplateListMap'] .= '<div class="TemplateBox"  id="'.$GLOBALS['TemplateID'] .'" onmouseover="this.className=\'TemplateBoxOver\'" onmouseout="this.className=\'TemplateBox\'">'.$templateCode.'</div>';
			}
		}
	}

	public function _GetTemplateList()
	{
		GetLib('class.file');

		// Get a list of templates and return them as a sorted array
		$dir = ISC_BASE_PATH . "/templates";
		$arrTemplates = array();

		if (is_dir($dir)) {
			$fileHandle = new FileClass;
			if ($fileHandle->SetLoadDir($dir)) {
				while (($file = $fileHandle->NextFolder()) !== false) {
					if ($file != "." && $file != ".." && $file != "CVS" && $file != ".svn" && $file != 'blank.dat' && $file{0} != '_') {
						// These are the template categories. We will create
						// an array for each of them
						$arrTemplates[] = $file;
						sort($arrTemplates);
					}
				}
				$fileHandle->CloseHandle();
			}

		}
		ksort($arrTemplates);
		return $arrTemplates;
	}

	public function ManageLayouts($MsgDesc = "", $MsgStatus = "", $template = "")
	{
		$output = '';

		if(isset($_REQUEST['ForceTab'])) {
			$GLOBALS['ForceTab'] = (int)$_REQUEST['ForceTab'];
		}

		if(isset($_REQUEST['forceTab'])) {
			$GLOBALS['ForceTab'] = (int)$_REQUEST['forceTab'];
		}

		$opener = new connect_remote();
		if ($opener->CanOpen()) {
			$GLOBALS['FopenSupport'] = true;
		} else {
			$GLOBALS['FopenSupport'] = false;
		}

		$GLOBALS['CurrentTemplateName']  = GetConfig('template');
		$GLOBALS['CurrentTemplateNameProper']  = ucfirst(GetConfig('template'));
		$GLOBALS['CurrentTemplateColor'] = GetConfig('SiteColor');
		$GLOBALS['StoreLogo'] = GetConfig('StoreLogo');
		$GLOBALS['siteName']  = GetConfig('StoreName');

		$this->LoadChooseTemplateTab();
		$this->LoadDownloadTemplates();
		$this->LoadLogoTab();

		if(file_exists(ISC_BASE_PATH . '/templates/'. GetConfig('template') . '/config.php')) {
			include(ISC_BASE_PATH . '/templates/'. GetConfig('template') . '/config.php');
			if(isset($GLOBALS['TPL_CFG']['GenerateLogo']) && $GLOBALS['TPL_CFG']['GenerateLogo'] === true) {
				$GLOBALS['CurrentTemplateHasLogoOption'] = 'true';
			}
			else {
				$GLOBALS['CurrentTemplateHasLogoOption'] = 'false';
			}
		}

		if(GetConfig('DisableTemplateDownloading')) {
			$GLOBALS['HideDownloadTab'] = 'none';
		}

		$GLOBALS['TemplateVersion'] = '1.0';
		if(isset($GLOBALS['TPL_CFG']['Version'])) {
			$GLOBALS['TemplateVersion'] = $GLOBALS['TPL_CFG']['Version'];
		}

		$GLOBALS['LayoutIntro'] = GetLang('TemplateIntro');

		if(GetConfig('TemplatesOrderCustomURL') == '') {
			$GLOBALS['HideOrderCustomTemplate'] = "none";
		}

		if(GetConfig('DesignMode')) {
			$GLOBALS['DesignModeChecked'] = "checked";
		}

		if ($MsgDesc != "") {
			$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
		}

		$flashMessages = GetFlashMessages();
		if(is_array($flashMessages)) {
			$GLOBALS['Message'] = '';
			foreach($flashMessages as $flashMessage) {
				$GLOBALS['Message'] .= MessageBox($flashMessage['message'], $flashMessage['type']);
			}
		}

		if(!function_exists("gzdeflate")) {
			// No zlib - they can't download templates automatically
			$GLOBALS['HideDownloadMessage'] = "none";
			$GLOBALS['NoZLibMessage'] = MessageBox(GetLang('NoZLibInstalled'), MSG_ERROR);
		}
		else {
			// They have zlib - hide the zlib error message
			$GLOBALS['HideNoZLib'] = "none";
		}

		if(!$this->safeMode) {
			$GLOBALS['HideSafeModeMessage'] = 'display: none';
		}

		// Load the email templates
		$GLOBALS['EmailTemplatesGrid'] = $this->_LoadEmailTemplates();

		$GLOBALS['TemplatesOrderCustomURL'] = GetConfig('TemplatesOrderCustomURL');

		// Load a temporary editor to use for editing email templates
		$wysiwygOptions = array(
			'id' => 'temp_email_editor',
			'delayLoad' => true
		);
		$GLOBALS['TemporaryEditor'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);

		$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("layout.manage");
		$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
	}

	private function _GenRandFileName()
	{
		$output = "";

		for ($i = 0; $i < rand(8, 15); $i++) {
			$output .= chr(rand(65, 90));
		}
		return $output;
	}

	private function _LoadEmailTemplates()
	{
		$output = "";
		$email_files = scandir(ISC_EMAIL_TEMPLATES_DIRECTORY);
		$count = 0;

		// Filter the email files so they all end with .html
		foreach($email_files as $k=>$email_file) {
			if(preg_match("/.html$/", $email_file)) {
				$GLOBALS['FileName'] = $email_file;
				$GLOBALS['FileSize'] = ceil((filesize(ISC_EMAIL_TEMPLATES_DIRECTORY . "/" . $email_file) / 1000));
				$GLOBALS['FileDate'] = date(GetConfig('ExtendedDisplayDateFormat'), filemtime(ISC_EMAIL_TEMPLATES_DIRECTORY . "/" . $email_file));
				$GLOBALS['ExpandId'] = $count++;
				$output .= $GLOBALS["ISC_CLASS_TEMPLATE"]->GetSnippet("EmailTemplate");
			}
		}

		return $output;
	}

	public function BuildTemplateURL($url, $replacements=array())
	{
		$replacements['version'] = PRODUCT_VERSION_CODE;
		if(empty($replacements)) {
			return $url;
		}
		foreach($replacements as $find => $replacement) {
			$url = str_replace("%%".strtoupper($find)."%%", $replacement, $url);
		}
		return $url;
	}
}
?>