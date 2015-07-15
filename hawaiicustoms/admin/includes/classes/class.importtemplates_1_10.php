<?php
require_once APP_ROOT . "/includes/importer/class.importfiletype.factory.php";
require_once APP_ROOT . "/includes/importer/class.importmethod.factory.php";

/**
* Manages CSV templates for exporting of order, product and customer data
*
* @author Ray Ward
// Import template is  used to give the sample csv to the vendor which they should import. This module is the duplication of the export  module files and only made the nessecary modifications on the files. Added by blessen
*/
class ISC_ADMIN_IMPORTTEMPLATES
{
	/**
	* Handles the incoming action/page request
	*
	* @param string $do The action or page requested
	*/
	public function HandleToDo($do)
	{
		
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('exporttemplates');

		 $do = isc_strtolower($do);

		if (($do != "viewimporttemplates" && !$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_ExportTemplates)) || !gzte11(ISC_MEDIUMPRINT)) {
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
		}

		switch ($do) {
			case 'createimporttemplate':
				$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ExportTemplates') => "index.php?ToDo=viewimporttemplates", GetLang('AddImportTemplate') => "index.php?ToDo=createExportTemplate");

				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->CreateTemplate();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();

				break;
			case "saveimporttemplate":
				$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ExportTemplates') => "index.php?ToDo=viewimporttemplates");

				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->SaveTemplate();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();

				break;
			case 'editimporttemplate':
				$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ExportTemplates') => "index.php?ToDo=viewimporttemplates", GetLang('EditExportTemplate') => "index.php?ToDo=editExportTemplate");

				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->EditTemplate();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();

				break;

				case 'dloadimporttemplate':
				$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ExportTemplates') => "index.php?ToDo=viewimporttemplates", GetLang('EditExportTemplate') => "index.php?ToDo=editExportTemplate");

				
				$templateid = $_GET["tempId"];
				
				// find the template name
				$query = "SELECT  importtemplatename , myobincomeaccount FROM [|PREFIX|]import_templates  WHERE importtemplateid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($templateid) . "' ";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
				$importtemplatename = $row['importtemplatename'];
				$catids = $row['myobincomeaccount'];
				
				$filename = "../cache/".$importtemplatename.".csv";

				//delete it if it is exist.
				if (file_exists($filename)) {
										@unlink($filename);
											}


				// Read  all the selected fields
				$fieldname  = "";
				$query = "SELECT fieldname  FROM [|PREFIX|]import_template_fields WHERE importtemplateid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($templateid) . "' AND includeinexport  = 1";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
							$fieldname.= $row['fieldname'].",";

				}

				if ($catids != "")
				{
					$query = "SELECT distinct mn.column_name FROM isc_qualifier_associations qa  INNER JOIN isc_qualifier_names mn ON qa.qualifierid = mn.qid and qa.categoryid  in (".$catids.")"; 
					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
								$fieldname.= $row['column_name'].",";

					}

				}			
				

				// write in to a file				
				
				if (!$handle = fopen($filename, 'a')) {
					 echo "Cannot open file ($filename)";
				 
				}

				if (fwrite($handle, $fieldname) === FALSE) {
					echo "Cannot write to file ($filename)";
					
				}
				fclose($handle);
	


				// Download it
				$fsize = filesize($filename); 

				$fileContents = file_get_contents($filename);

				header("Content-length:".$fsize);
				header("Content-type: text/csv");
				header("Content-Disposition: attachment; filename=".$importtemplatename.".csv");
				echo $fileContents;

				die();

				

				break;
			case "updateimporttemplate":
				$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ExportTemplates') => "index.php?ToDo=viewimporttemplates");

				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->UpdateTemplate();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			case 'deleteimporttemplate':
				$this->DeleteTemplate();
				break;
			
		                   
			default:
				$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ImportTemplates') => "index.php?ToDo=viewimporttemplates");

				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->ManageTemplates();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
		}
	}

	/**
	* Allows management of templates in the store by listing existing templates and providing add/edit/delete functions
	*
	*/
	private function ManageTemplates()
	{
		$GLOBALS['TemplatesGrid'] = $this->BuildTemplatesGrid();

		$GLOBALS['Message'] = GetFlashMessageBoxes();

		if (empty($GLOBALS['TemplatesGrid'])) {
			// There aren't any templates, show a message so they can create one
			$GLOBALS['Message'] = MessageBox(GetLang('NoExportTemplates'), MSG_SUCCESS);

			$GLOBALS['DisableDelete'] = "DISABLED";

			$GLOBALS['Title'] = GetLang('ManageExportTemplates');
			$GLOBALS['ManageExportTemplatesIntro'] = GetLang('ManageExportTemplatesIntro');
		}

		$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("importtemplates.manage");
		$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
	}

	/**
	* Gets a list of templates available to the user
	*
	*/
	public function GetTemplates($show_mine = true, $show_builtin = false, $sortField = "", $sortOrder = "")
	{
		$where = "";
		if ($show_mine) {
			if(gzte11(ISC_HUGEPRINT)) {
				$GLOBALS['VendorLabel'] = GetLang("VendorLabel");

				$vendorid = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
				if($vendorid) {
					$where = "et.vendorid = '" .  $vendorid . "'";
				}
			}
		}

		if ($show_builtin) {
			if ($show_mine && $where) {
				$where .= " OR ";
			}

			if (!$show_mine || ($show_mine && $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId())) {
				$where .= "builtin = 1";
			}
		}
		else {
			if ($show_mine && $where) {
				$where .= " AND ";
			}

			$where .= "builtin = 0";
		}

		if ($where) {
			$where = " WHERE " . $where;
		}

		if ($sortField) {
			$order = $sortField . " " . $sortOrder;

			if ($sortField != "importtemplatename") {
				$order .= ", importtemplatename";
			}
		}
		else {
			$order ="
					vendorname,
				";
		}

		// Get the list of templates
		$query = "
			SELECT
				et.*,
				v.vendorname
			FROM
				[|PREFIX|]import_templates et
				LEFT JOIN [|PREFIX|]vendors v ON (v.vendorid = et.vendorid)
			" . $where . "
			ORDER BY
				" . $order;

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		return $result;
	}

	/**
	* Generates a grid that lists the templates
	*
	*/
	private function BuildTemplatesGrid()
	{
		// set sort order
		if(isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'asc') {
			$sortOrder = 'asc';
		}
		else {
			$sortOrder = "desc";
		}

		// define our sortable fields
		$sortLinks = array(
			"Title" => "importtemplatename",
			"Vendor" => "vendorname"
		);

		// get the field to sort on
		if(isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
			$sortField = $_GET['sortField'];
			SaveDefaultSortField("ManageImportTemplates", $_REQUEST['sortField'], $sortOrder);
		}
		else {
			list($sortField, $sortOrder) = GetDefaultSortField("ManageImportTemplates", "builtin", $sortOrder);
		}

		$sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
		$GLOBALS['SortURL'] = $sortURL;

		$GLOBALS['SortField'] = $sortField;
		$GLOBALS['SortOrder'] = $sortOrder;

		// get templates
		$result = $this->GetTemplates(true, true, $sortField, $sortOrder);

		if (!$GLOBALS['ISC_CLASS_DB']->CountResult($result)) {
			return "";
		}


		BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewimporttemplates", $sortField, $sortOrder);

		if(gzte11(ISC_HUGEPRINT) && !$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {	//&& !$show_builtin
			$showvendor = true;
			$GLOBALS['VendorLabel'] = GetLang('VendorLabel');
			$GLOBALS['HideVendorColumn'] = "";
		}
		else {
			$showvendor = false;
			$GLOBALS['VendorLabel'] = "";
			$GLOBALS['HideVendorColumn'] = 'style="display: none;"';
		}

		// Build the items for the grid
		$templateGridData = "";
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$id = $row['importtemplateid'];
			$GLOBALS['importtemplateid'] = $row['importtemplateid'];
			$GLOBALS['ExportTemplateName'] = $row['importtemplatename'];


			$GLOBALS['CheckTemplate'] = "<input type=\"checkbox\" name=\"exporttemplates[" . $row['importtemplateid'] . "]\" value=\"1\" >";

			if ($showvendor) {
				if ($row['vendorname']) {
					$vendorname = $row['vendorname'];
				}
				else {
					$vendorname = "N/A";
				}
				$GLOBALS['VendorName'] = $vendorname;
			}
			else {
				$GLOBALS['VendorName'] = "";
			}

			// generate actions for this template
			$types = explode(",", $row['usedtypes']);
			$options = "";

			// does user have permission to manage templates
			if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_ExportTemplates)) {
				// show copy option for built in templates
				
					$options .=  '<A HREF="index.php?ToDo=editImportTemplate&tempId='.$id.'">'.GetLang("EditThisTemplate").'</A>';
					
					$options .=  '&nbsp;&nbsp;&nbsp;<A HREF="index.php?ToDo=dloadImportTemplate&tempId='.$id.'">Download Template</A>';
				
			}
		
			$GLOBALS['TemplateActions'] = $options;

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("importtemplates.manage.grid.row");
			$templateGridData .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		$GLOBALS['ExportTemplateGridData'] = $templateGridData;

		// Generate and return the grid
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("importtemplates.manage.grid");
		return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
	}

	/**
	* Generates a html select box containing vendors
	*
	* @param int $selectedVendor Optional vendor to select by default
	*/
	private function BuildVendorSelect($selectedVendor = 0)
	{

		$options = '<select name="vendor" id="vendor" class="Field200">
		<option value="0">'.GetLang('NoVendor').'</option>';
		$query = "
			SELECT vendorid, vendorname
			FROM [|PREFIX|]vendors
			ORDER BY vendorname ASC
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($vendor = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$sel = '';
			if($selectedVendor == $vendor['vendorid']) {
				$sel = 'selected="selected"';
			}
			$options .= '<option value='.(int)$vendor['vendorid'].' '.$sel.'>'.isc_html_escape($vendor['vendorname']).'</option>';
		}

		$options .= "</select>";

		return $options;
	}

	/**
	* Displays the Create Template page
	*
	*/
	private function CreateTemplate($loadFromPost = false)
	{
		$GLOBALS['Message'] = GetFlashMessageBoxes();

		$GLOBALS['TemplateId'] = 0;
		unset($_SESSION['TemplateId']);

		$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndAddAnother');
		$GLOBALS['FormAction'] = "saveImportTemplate";
		$GLOBALS['CancelMessage'] = GetLang("CancelCreateTemplate");
		$GLOBALS['TemplateTitle'] = GetLang("AddImportTemplate");
		$GLOBALS['Vendor'] = 0;

		if ($loadFromPost) {
			// reload posted data
			$this->SetGlobalsFromPost();
		}
		else {
			

			// build tabs and grids for each type
			$types = $this->SetTypeData();

			
		}

		$GLOBALS['HideVendorRow'] = 'style="display: none;"';

		$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("importtemplates.form");
		$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
	}

	private function GetMethodSettings($templateid = 0)
	{
		$settings = array();
		//$html = "";

		// get a list of each method
		$methods = ISC_ADMIN_EXPORTMETHOD_FACTORY::GetExportMethodList();
		foreach ($methods as $file => $details) {
			$method = ISC_ADMIN_EXPORTMETHOD_FACTORY::GetExportMethod($details['name']);

			if ($method->HasSettings()) {
				$settings[$details['name']] = $method->GetSettings($templateid);
			}
		}

		return $settings;
	}

	/**
	* Sets the global variables for methods based on the setting type
	*
	* @param mixed $settings
	/*
	private function BuildSettings($settings)
	{
		$js = "";
		$html = "";

		foreach ($settings as $method => $method_settings) {

			foreach ($method_settings as $id => $setting) {
				$value = $setting['value'];

				switch ($setting['type']) {
					case "text":
						$value = isc_html_escape($value);
						break;
					case "checkbox":
						if ($value) {
							$value = "checked=\"checked\"";
						}
						break;
					case "select":
						if (in_array($value, $setting['options'])) {
							$id = $value . "Selected";
							$value = "selected=\"selected\"";
						}
						break;
				}

				$GLOBALS['Setting' . $id] = $value;
			}

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("exporttemplates.settings." . strtolower($method));
			$html .= $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);

			$js .= "
			if (!Validate" . $method . "()) {
				return false;
			}";
		}

		return array("html" => $html, "js" => $js);
	}

	/**
	* Loads data into the settings from post
	*
	*/ /*
	private function LoadSettingsFromPost()
	{
		$settings = $this->GetMethodSettings();


		$new_settings = $settings;

		foreach ($settings as $method => $method_settings) {
			foreach ($method_settings as $id => $setting) {

				switch ($setting['type']) {
					case "checkbox":
						$value = isset($_POST[$method][$id]);
						break;
					default:
						$value = $_POST[$method][$id];
						break;
				}

				$new_settings[$method][$id]['value'] = $value;
			}
		}
	
		return $new_settings;
	}

	/**
	* Saves posted setting data for the template
	*
	* @param mixed $templateid
	*/
	private function ProcessSettings($templateid)
	{
		$settings = $this->GetMethodSettings();

		
		
	}

	/**
	* Displays the Edit Template form
	*
	*/
	private function EditTemplate($loadFromPost = false, $templateid = 0)
	{

		
		 try {
			// no template supplied, 404
			if (!$templateid) {
				if (!isset($_GET["tempId"])) {
					throw new Exception(GetLang("NoTemplateId"));
				}

				$templateid = $_GET["tempId"];
				$_SESSION['TemplateId'] = $templateid;
			}

			$template = $this->GetTemplate($templateid);
		}
		catch (Exception $ex) {
			FlashMessage($ex->getMessage(), MSG_ERROR, 'index.php?ToDo=viewimporttemplates');
		}

		$GLOBALS['TemplateId'] = $templateid;
		$GLOBALS['FormAction'] = "updateImportTemplate";
		$GLOBALS['TemplateTitle'] = GetLang("EditImTemplateTitle");
		$GLOBALS['CancelMessage'] = GetLang("CancelEditTemplate");
		$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndContinueEditing');
		$GLOBALS['hiddenFields'] = sprintf("<input type='hidden' name='tempId' value='%d'>", $templateid);

		$GLOBALS['Vendor'] = $template['vendorid'];

		if (isset($_GET["tab"])) {
			$GLOBALS['ShowTabScript'] = "ShowTab(" . (int)$_GET["tab"] . ");";
		}

		if ($loadFromPost) {
			// reload posted data
			$this->SetGlobalsFromPost();
		}
		else {
			// load template settings
			$GLOBALS['ExportTemplateName'] = isc_html_escape($template['importtemplatename']);

			if ($template['blankforfalse']) {
				$GLOBALS['BlankForFalseChecked'] = "checked=\"checked\"";
			}


			$GLOBALS['ExportTemplateDesc'] = $template['description'];
			$GLOBALS['ExportTemplateCreationTime'] = $template['creation_time'];
			$GLOBALS['ExportTemplateModifiedTime'] = $template['mod_time'];

			$usedTypes = explode(",", $template['usedtypes']);

			// grid fields
			$types = $this->SetTypeData($templateid, $usedTypes);

			// method settings
			//$ret = $this->BuildSettings($this->GetMethodSettings($templateid));
			//$GLOBALS['Settings'] = $ret['html'];
			//$GLOBALS['VerifyJS'] .= $ret['js'];

			
		}

		if(gzte11(ISC_HUGEPRINT) && !$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $GLOBALS['Vendor']) {
			$GLOBALS['VendorLabel'] = GetLang("VendorLabel");

			$query = "SELECT * FROM [|PREFIX|]vendors WHERE vendorid = '" . $GLOBALS['Vendor'] . "'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$vendorData = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if(isset($vendorData['vendorid'])) {
				$GLOBALS['VendorData'] = isc_html_escape($vendorData['vendorname']);
			}
		}
		else {
			$GLOBALS['HideVendorRow'] = 'style="display: none;"';
		}




		$GLOBALS['Message'] = GetFlashMessageBoxes();

		$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("importtemplates.form");
		$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
	}

	/**
	* Retrieves a template record from the database
	*
	* @param int $templateid The template to get
	* @return array The template record
	*/
	public function GetTemplate($templateid)
	{
		$where = "";
		if(gzte11(ISC_HUGEPRINT)) {
			$GLOBALS['VendorLabel'] = GetLang("VendorLabel");

			$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
			if(isset($vendorData['vendorid'])) {
				$where = "AND (et.vendorid = '" . $vendorData['vendorid'] . "' OR builtin = 1)";
			}
		}

		// retrieve the template
		$query = "
			SELECT
				et.*
			FROM
				[|PREFIX|]import_templates et
			WHERE
				importtemplateid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($templateid) . "'";

		$query .= $where;

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		if (!$template = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			// template not found
			throw new Exception(GetLang("TemplateNotFound"));
		}

		return $template;
	}

	/**
	* Assigns the GLOBAL variables for use in design template using the POST data.
	* ie. for when the form is displayed after a save action and an error is generated
	*
	*/
	private function SetGlobalsFromPost()
	{
		$GLOBALS['ShowTabScript'] = "ShowTab(" . (int)$_POST["currentTab"] . ");";

		$GLOBALS['ExportTemplateName'] = isc_html_escape($_POST['templateName']);

		if (isset($_POST['blankForFalse'])) {
			$GLOBALS['BlankForFalseChecked'] = "checked=\"checked\"";
		}

		// grid fields
		$usedTypes = array();
		if (isset($_POST['includeType'])) {
			$usedTypes = array_keys($_POST['includeType']);
		}
		 $types = $this->SetTypeData(0, $usedTypes, true);

		
	}

	/**
	* Validates the posted form data
	*
	* @param int $templateid The template used when checking for existing template name
	*/
	private function ValidateInput($templateid = 0)
	{
		// check for template name
		if (!isset($_POST["templateName"]) || !trim($_POST["templateName"])) {
			throw new Exception(GetLang("NoTemplateName"));
		}
		else {
			$templatename = trim($_POST["templateName"]);

			// check for existing template
			$query = "SELECT * FROM [|PREFIX|]import_templates WHERE  UCASE(importtemplatename) = '" . $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtoupper($templatename)) . "'";
			if ($templateid) {
				$query .= " AND importtemplateid != '" . $GLOBALS['ISC_CLASS_DB']->Quote($templateid) . "'";
			}

			$vendorid = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();

			$query .= " AND vendorid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($vendorid) . "'";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			if ($GLOBALS['ISC_CLASS_DB']->CountResult($result)) {
				throw new Exception(sprintf(GetLang("TemplateAlreadyExists"), $templatename));
			}
		}

	}

	/**
	* Saves a new template and either returns to the view templates list or shows the create form again
	*
	*/
	private function SaveTemplate()
	{

		
		$transaction_started = false;

		try {
			// validate input
			$this->ValidateInput();

			$useHeaders = false;
			if (isset($_POST['includeHeaders'])) {
				$useHeaders = true;
			}

			// begin template creation transaction
			$GLOBALS['ISC_CLASS_DB']->StartTransaction();
			$transaction_started = true;

			// create our template
			$templateid = $this->CommitTemplate();

			// save the fields
			$this->ProcessFields($templateid, $useHeaders);

			// save method settings
			$this->ProcessSettings($templateid);

			// commit transaction
			$GLOBALS['ISC_CLASS_DB']->CommitTransaction();
		}
		catch (Exception $ex) {
			// rollback transaction
			if ($transaction_started) {
				$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
			}

			// show error
			FlashMessage($ex->getMessage(), MSG_ERROR); //, 'index.php?ToDo=createExportTemplate');
			$this->CreateTemplate(true);

			return;
		}

		if(isset($_POST['AddAnother'])) {
			$location = 'index.php?ToDo=createImportTemplate';
		}
		else {
			$location= 'index.php?ToDo=viewimporttemplates';
		}

		// Log this action
		$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($templateid, $_POST['templateName']);

		FlashMessage(sprintf(GetLang('TemplateSavedSuccessfully'), isc_html_escape($_POST['templateName'])), MSG_SUCCESS, $location);
	}

	/**
	* Updates an existing template
	*
	*/
	private function UpdateTemplate()
	{
		$templateid = 0;
		$transaction_started = false;

		try {
			if (!isset($_POST["tempId"])) {
				throw new Exception(GetLang("NoTemplateId"));
			}

			$templateid = $_POST["tempId"];

			$template = $this->GetTemplate($templateid);

			

			$useHeaders = false;
			if (isset($_POST['includeHeaders'])) {
				$useHeaders = true;
			}

			// validate input
			$this->ValidateInput($templateid);

			// begin template creation transaction
			$GLOBALS['ISC_CLASS_DB']->StartTransaction();

			$transaction_started = true;

			// commit the template
			$this->CommitTemplate($templateid);

			 // add fields for Order, Product and Customer
			$this->ProcessFields($templateid, $useHeaders);

			// save method settings
			$this->ProcessSettings($templateid);

			// commit transaction
			$GLOBALS['ISC_CLASS_DB']->CommitTransaction();
		}
		catch (Exception $ex) {
			// rollback transaction
			if ($transaction_started) {
				$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
			}

			// show error
			FlashMessage($ex->getMessage(), MSG_ERROR);
			$this->EditTemplate(true, $templateid);

			return;
		}

		if(isset($_POST['AddAnother'])) {
			$location = 'index.php?ToDo=editImportTemplate&tempId=' . $templateid . "&tab=" . $_POST["currentTab"];
		}
		else {
			$location= 'index.php?ToDo=viewimporttemplates';
		}

		// Log this action
		$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($templateid, $_POST['templateName']);

		FlashMessage(sprintf(GetLang('TemplateUpdatedSuccessfully'), isc_html_escape($_POST['templateName'])), MSG_SUCCESS, $location);
	}

	/**
	* Deletes selected templates then redirects back to manage templates page
	*
	*/
	private function DeleteTemplate()
	{
		
		$delcount = 0;

		try {
			// delete single template
			if (isset($_GET['tempId'])) {
				$tempId = (int)$_GET['tempId'];
				$template = $this->GetTemplate($tempId);
				

				$this->DeleteThisTemplate($tempId);

				$delcount = 1;
			}
			else { // delete multiple templates



				if (!isset($_POST["exporttemplates"]) || !is_array($_POST["exporttemplates"])) {
					throw new Exception(GetLang("NoTemplateId"));
				}

				foreach ($_POST["exporttemplates"] as $templateid => $val) {
					$template = $this->GetTemplate($templateid);
					// check if this template is built-in
					

					$templateid = $GLOBALS['ISC_CLASS_DB']->Quote($templateid);

					$this->DeleteThisTemplate($templateid);

					$delcount++;
				}
			}
		}
		catch (Exception $ex) {
			// log the error

			// show error
			FlashMessage($ex->getMessage(), MSG_ERROR, 'index.php?ToDo=viewimporttemplates');
			return;
		}

		if ($delcount) {
			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($delcount);

			FlashMessage(GetLang("TemplateDeletedSuccessfully"), MSG_SUCCESS, 'index.php?ToDo=viewimporttemplates');
		}
		else {
			$this->HandleToDo("viewimporttemplates");
		}
	}

	public function DeleteThisTemplate($templateid)
	{
		// delete the template
		$query = "DELETE FROM [|PREFIX|]import_templates WHERE importtemplateid = '" . $templateid . "'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		if (!$GLOBALS['ISC_CLASS_DB']->NumAffected()) {
			throw new Exception("Template was not deleted");
		}

		// delete the template fields
		$query = "DELETE FROM [|PREFIX|]import_template_fields WHERE importtemplateid = '" . $templateid . "'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		// delete method settings
		//$query = "DELETE FROM [|PREFIX|]import_method_settings WHERE importtemplateid = '" . $templateid . "'";
		//$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
	}

	private function ProcessFields($templateid, $useHeaders)
	{
		$filetypes = ISC_ADMIN_IMPORTFILETYPE_FACTORY::GetImportFileTypeList();

		
		foreach ($filetypes as $file => $details) {
			$this->ProcessFieldsForType($details['name'], $templateid, $useHeaders);
		}
	}

	/**
	* Processes the posted fields for a field type  and inserts or updates DB records
	*
	* @param string $fieldType The type of fields being processed - order, product or customer
	* @param int $templateid The template of the fields
	* @param bool $useHeaders Whether the Use Header Line option was ticked. Checks for missing header data in selected fields
	*/
	private function ProcessFieldsForType($fieldType, $templateid, $useHeaders)
	{
		$type = ISC_ADMIN_IMPORTFILETYPE_FACTORY::GetImportFileType($fieldType);
		$fields = $type->FlattenFields($type->LoadFields());

		$keys = array_keys($_POST[$fieldType . "Header"]);

		// ensure posted field array is valid
	//	if (!isset($_POST[$fieldType . "Field"]) || !is_array($_POST[$fieldType . "Field"])) {
		//	throw new Exception(sprintf(GetLang("FieldsNotPosted"), $fieldtype));
		//}

		// process the fields
		foreach ($fields as $id => $field) {
			$header = "";
			$used = isset($_POST[$fieldType . "Field"][$id]);



			$header = $_POST[$fieldType . 'Header'][$id];

			$field_array = array(
				"importtemplateid"	=> $templateid,
				"fieldid"			=> $id,
				"fieldtype"			=> $fieldType,
				"fieldname"			=> $header,
				"includeinexport"	=> (int)$used,
				"sortorder"			=> array_search($id, $keys)
			);

			// check if field exists
			$query = "SELECT * FROM [|PREFIX|]import_template_fields WHERE importtemplateid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($templateid) . "' AND fieldid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($id) . "'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($GLOBALS['ISC_CLASS_DB']->CountResult($result)) {
				// field exists, update the existing one
				$result = $GLOBALS['ISC_CLASS_DB']->UpdateQuery('import_template_fields', $field_array, "importtemplateid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($templateid) . "' AND fieldid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($id) . "'");
				if (!$result) {
					throw new Exception(sprintf(GetLang("FailedToUpdateField"), $field['label']));
				}
			}
			else {
				// insert new field


				$impotempfieldid = $GLOBALS['ISC_CLASS_DB']->InsertQuery('import_template_fields', $field_array);
				if (!isId($impotempfieldid)) {
					throw new Exception(sprintf(GetLang("FailedToAddField"), $field['label']));
				}
			}
		}



		foreach ($_POST['qualifierassociations'] as $id => $field) {

			$field_array = array(
				"importtemplateid"	=> $templateid,
				"fieldid"			=> $id,
				"fieldtype"			=> $fieldType,
				"fieldname"			=> $id,
				"includeinexport"	=> 1,
				"sortorder"			=> array_search($id, $keys)
			);




				$impotempfieldid = $GLOBALS['ISC_CLASS_DB']->InsertQuery('import_template_fields', $field_array);
				if (!isId($impotempfieldid)) {
					throw new Exception(sprintf(GetLang("FailedToAddField"), $field['label']));
				}

		}






	}

	/**
	* Creates or updates a template from posted data
	*
	* @return int $id The ID of the new template
	*/
	private function CommitTemplate($templateid = 0)
	{

		
		$vendorid = 0;

		$vendorid = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();

		// which file types the user has selected
		$usedTypes = array("products");
		
                
		$mod_time = date("Y-m-d g:i:s");  

		$array = array(
			"importtemplatename"			=> $_POST["templateName"],
			"description"					=> $_POST["description"],
			"usedtypes"						=> "products",
			"vendorid"						=> $vendorid,
			"mod_time"						=> $mod_time,
			"myobincomeaccount"             => $comma_separated = implode(",", $_POST['pre_category'])


			
		);

		if ($templateid) {
			// update template
			$result = $GLOBALS['ISC_CLASS_DB']->UpdateQuery("import_templates", $array, "importtemplateid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($templateid) . "'");
			if (!$result) {
				throw new Exception(sprintf(GetLang('TemplateNotUpdated'), isc_html_escape($_POST['templateName'])));
			}
		}
		else {
			// new template
			$templateid = $GLOBALS['ISC_CLASS_DB']->InsertQuery("import_templates", $array);

			if (!isId($templateid)) {
				throw new Exception(sprintf(GetLang('TemplateNotCreated'), isc_html_escape($_POST['templateName'])));
			}
		}

		return $templateid;
	}


	/**
	* Sets the template globals to create a file type (tab, grid, used check box, javascript)
	*
	* @param mixed $templateid
	* @param mixed $usedTypes
	* @param mixed $load_from_post
	*/
	private function SetTypeData($templateid = 0, $usedTypes = array(), $load_from_post = false)
	{
		// get a list of available file types
		 $filetypes = ISC_ADMIN_IMPORTFILETYPE_FACTORY::GetImportFileTypeList();
		

		$x = 2;
		$gridData = "";
		$tabData = "";
		$listJS = "";
		$includeData = "";
		$includeJS = "";
		$verifyJS = "";

		if ($templateid == 0 && !$load_from_post) {
			$use_defaults = true;
		}
		else {
			$use_defaults = false;
		}

		foreach ($filetypes as $file => $details) {
			// get the fields for this type
			$type = ISC_ADMIN_IMPORTFILETYPE_FACTORY::GetImportFileType($details['name']);
			
			$use_id = $templateid;
			if ($load_from_post) {
				$use_id = 0;
			}
			$fields = $type->LoadFields($use_id);


			if ($load_from_post) {
				$fields = $this->LoadFieldsFromPost($fields, $details['name']);
			}

			$GLOBALS['FileIndex'] = $x;

			if ($use_defaults || in_array($details['name'], $usedTypes)) {
				$GLOBALS['IncludeChecked'] = "checked=\"checked\"";
				$GLOBALS['TabDisplay'] = "";
			}
			else {
				$GLOBALS['IncludeChecked'] = "";
				$GLOBALS['TabDisplay'] = "style=\"display: none;\"";
			}

			// create a tab for the type
			$GLOBALS['TypeTitle'] = $details['title'];
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("importtemplates.form.tab");
			$tabData .= "\n" . $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);


			// get the grid data
			$ret = $this->GetFieldGrid($details['name'], $fields, $use_defaults);
			$GLOBALS['GridData'] = $ret["gridData"];
			$GLOBALS['TypeName'] = $details['name'];
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("importtemplates.form.grid");
			$GLOBALS['FieldGrid'] = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			$GLOBALS['FileIndex'] = $x;
			$GLOBALS['TypeDisplay'] = "display: none;";
			$GLOBALS['TypeWidth'] = "";
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("importtemplates.form.type");
			$gridData .= "\n\n" . $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);

			$listJS .= $ret["listJS"];

			// generate a check box for this file type
			$GLOBALS['IncludeTypeLabel'] = sprintf(GetLang("AllowType"), $details['title']);
			$GLOBALS['IncludeType'] = $details['name'];
			$GLOBALS['YesIncludeType'] = sprintf(GetLang("YesAllowType"), isc_strtolower($details['title']));
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("exporttemplates.form.includetype");
			$includeData .= "\n" . $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);

			// javascript for the checkbox to hide the tab
			$includeJS .= "
			 $(\"#include" . $details['name'] . "\").change(function() {
				if (this.checked)
					$(\"#tab" . $x . "\").animate({ opacity: \"show\", color: \"green\" }, \"slow\").animate({color: \"#666\"}, \"medium\");
				else
					$(\"#tab" . $x . "\").fadeOut(\"fast\");
			});\n";


			// type verification js
			$verifyJS .= "
			if (!VerifyList('" . $details['name'] . "', " . $x . ")) {
				return false;
			}
			";

			$x++;
		}

		$GLOBALS['TypeTabs'] = $tabData;
		 $GLOBALS['TypeGrids'] = $gridData;

$query = "SELECT myobincomeaccount  FROM [|PREFIX|]import_templates WHERE  importtemplateid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($templateid) . "'";
$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
$catids = $row['myobincomeaccount'];
$cats = explode(",", $catids);


	$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
        $GLOBALS['CategoryOptions'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions($cats, "<option %s value='%d'>%s</option>", "selected=\"selected\"", "", false);



		$GLOBALS['CreateLists'] = $listJS;
		$GLOBALS['IncludeTypes'] = $includeData;
		$GLOBALS['IncludeJS'] = $includeJS;
		$GLOBALS['VerifyJS'] = $verifyJS;
	}

	/**
	* Generates a grid for entering CSV header and data format values
	*
	* @param string $fieldType The type of fields being built - order, product or customer
	* @param array $fields An array of fields to be used when generating the grid
	* @param bool $use_defaults Use default values for rows or use values in the array loaded from a template
	* @return string A html snippet containing the grid of fields
	*/
	private function GetFieldGrid($fieldType, $fields, $use_defaults = false, $setType = true, $depth = 0)
	{
		$gridData = "";


		// javascript snippet to create the sortable list
		$listJS = "\nCreateSortableList('" . $fieldType . "');";

		if ($setType) {
			$GLOBALS['FieldType'] = $fieldType;
		}

		$GLOBALS['TypeName'] = $fieldType;

		foreach ($fields as $id => $field) {
			// does this field have sub-fields?
			if (isset($field['fields'])) {
				// create a grid for the sub-fields
				$typeName = $id . "_" . $fieldType;
				$ret = $this->GetFieldGrid($typeName, $field['fields'], $use_defaults, false, $depth + 1);
				$GLOBALS['GridData'] = $ret["gridData"];
				$listJS .= $ret["listJS"];

				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("importtemplates.form.grid");
				$GLOBALS['SubFields'] = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				$GLOBALS['CheckAlign'] = "vertical-align: top;";
			}
			else {
				$GLOBALS['SubFields'] = "";
				$GLOBALS['CheckAlign'] = "";
			}

			if ($depth) {
				$GLOBALS['CheckColWidth'] = 45;
				$GLOBALS['NodeJoin'] = '<img src="images/nodejoin.gif" alt="" style="vertical-align: middle;"/>';
			}
			else {
				$GLOBALS['CheckColWidth'] = 25;
				$GLOBALS['NodeJoin'] = "";
			}

			$GLOBALS['TypeName'] = $fieldType;
			$GLOBALS['FieldID'] = $id;
			$GLOBALS['FieldLabel'] = $field['label'];
			$GLOBALS['FieldChecked'] = "";
			$GLOBALS['FieldReadOnly'] = "";
			$GLOBALS['FieldHelp'] = "";

			// set default header to the column label for a new template
			if ($use_defaults) {
				$GLOBALS['FieldHeader'] = $field['label'];
				$GLOBALS['FieldChecked'] = "checked=\"checked\"";
				$GLOBALS['FieldClass'] = "";
			}
			else {
				$GLOBALS['FieldHeader'] = $field['header'];
				if ($field['used']) {
					$GLOBALS['FieldClass'] = "";
					$GLOBALS['FieldLabelClass'] = "";
					$GLOBALS['FieldChecked'] = "checked=\"checked\"";
				}
				else {
					$GLOBALS['FieldClass'] = "FieldDisabled";
					$GLOBALS['FieldLabelClass'] = "FieldLabelDisabled";
					$GLOBALS['FieldReadOnly'] = "readonly=\"readonly\"";
				}
			}

			// does this field have a help tip?
			if (isset($field["help"])) {
				$help = "<img onmouseout=\"HideHelp('help" . $id . "');\" onmouseover=\"ShowHelp('help" . $id . "', '" . $field['label'] . "', '" . $field['help'] . "');\" src=\"images/help.gif\" width=\"24\" height=\"16\" border=\"0\">";
				$help .= "\n<div style=\"display:none\" id=\"help" . $id . "\"></div>";
				$GLOBALS['FieldHelp'] = $help;
			}

			// render the row
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("importtemplates.form.grid.row");
			$gridData .= "\n" . $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		return array("gridData" => $gridData, "listJS" => $listJS);
	}

	private function LoadFieldsFromPost($fields, $type)
	{
		$keys = array_keys($_POST[$type . "Header"]);

		$new_fields = $fields;

		foreach ($keys as $fieldid) {
			$data = array(
				'header' 	=> $_POST[$type . "Header"][$fieldid],
				'used' 		=> isset($_POST[$type . "Field"][$fieldid]),
				'sortorder'	=> array_search($fieldid, $keys)
			);

			$this->SetFieldData($new_fields, $fieldid, $data);
		}

		// sort the field array by the sort order
		uasort($new_fields, array(&$this, "compare_fields"));

		return $new_fields;
	}

	private function SetFieldData(&$fields, $fieldid, $data)
	{
		if (isset($fields[$fieldid])) {
			foreach ($data as $col => $value) {
				$fields[$fieldid][$col] = $value;
			}
		}
		else {
			foreach ($fields as $id => &$field) {
				if (isset($field['fields'])) {
					$this->SetFieldData($field['fields'], $fieldid, $data);
				}
			}
		}
	}

	/**
	* Compares two fields sort order to determine their position in the list of fields
	*
	* @param array $field1
	* @param array $field2
	*/
	private function compare_fields($field1, $field2)
	{
		if ($field1["sortorder"] < $field2["sortorder"]) {
			return -1;
		}
		else {
			return 1;
		}
	}


	public function GetDateFormats()
	{
		$formats = array(
			"mdy-slash"			=> array("example"	=> "05/19/2008", "format"	=> "m/d/Y"),
			"mdy-slash-short"	=> array("example"	=> "05/19/08", "format"	=> "m/d/y"),
			"mdy-dash"			=> array("example"	=> "05-19-2008", "format"	=> "m-d-Y"),
			"mdy-dash-short"	=> array("example"	=> "05-19-08", "format"	=> "m-d-y"),
			"dmy-slash"			=> array("example"	=> "19/05/2008", "format"	=> "d/m/Y"),
			"dmy-slash-short"	=> array("example"	=> "19/05/08", "format"	=> "d/m/y"),
			"dmy-dash"			=> array("example"	=> "19-05-2008", "format"	=> "d-m-Y"),
			"dmy-dash-short"	=> array("example"	=> "19-05-08", "format"	=> "d-m-y"),
		);

		return $formats;
	}

	public function GetBoolFormats()
	{
		$formats = array(
			"onezero"	=> array("example" => GetLang("OneOrZero")),
			"truefalse"	=> array("example" => GetLang("TrueOrFalse")),
			"yesno"		=> array("example" => GetLang("YesOrNo")),
			"yn"		=> array("example" => GetLang("YOrN"))
		);

		return $formats;
	}

	private function GetPriceFormats()
	{
		 SetupCurrency();

		$currency = GetDefaultCurrency();

		$price = number_format(1543.987, $currency['currencydecimalplace'], $currency['currencydecimalstring'], '');

		$formats = array(
				"number" => $price,
				"formatted" => FormatPriceInCurrency(1543.987)
		);

		return $formats;
	}

	/**
	* Gets an HTML set of <option>'s using an array of formats
	*
	* @param array $formats An array of valid formats in the form (type => format)
	* @param string $select Optional format type to select by default
	* @return string A string of <option> tags of the formats
	*/
	private function FormatArray($formats, $select = "")
	{
		$format_str = "";

		foreach ($formats as $type => $format) {
			if (is_array($format)) {
				$label = $format["example"];
			}
			else {
				$label = $format;
			}

			if ($type == $select) {
				$item_select = " selected=\"selected\"";
			}
			else {
				$item_select = "";
			}

			$format_str .= "<option value=\"$type\"" . $item_select . ">" . $label . "</option>";
		}

		return $format_str;
	}



}		
?>