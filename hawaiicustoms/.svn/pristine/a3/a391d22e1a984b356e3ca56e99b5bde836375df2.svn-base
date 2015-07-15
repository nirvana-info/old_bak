<?php
/**
 * A generic Interspire Shopping Cart batch (CSV) import class.
 *
 * Extended by methods for importing specific types of data.
 *
 * @author Chris Boulton <cboulton@interspire.com>
 * @id $Id$
 */
class ISC_BACTH_IMPORTER_BASE
{

	/**
	 * @var array The array containing all of the import session data
	 */
	public $ImportSession = array();

	/**
	 * @var string The directory containing a list of importable files
	 */
	public $ServerImportDirectory;

	/**
	 * @var array The array containing the custom fields
	 */
	protected $customFields;

	/**
	 * Runs the import actions
	 */

	public function __construct($customFields=array())
	{
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('batch.importer');

		//alandy modify import path.
		define("ISC_TMP_IMPORT_DIRECTORY", ISC_CACHE_DIRECTORY."import");
		//define("ISC_TMP_IMPORT_DIRECTORY", dirname(__FILE__)."/../../localimport");

		// Set the import session

		if(!isset($_REQUEST['ImportSession'])) {
			$_REQUEST['ImportSession'] = md5(uniqid(rand(), true).time());
		} else {
			require_once ISC_TMP_IMPORT_DIRECTORY . "/session-" . $_REQUEST['ImportSession'];
			if (isset($ImportSession)) {
				$this->ImportSession = $ImportSession;
			}
		}

		$this->ServerImportDirectory = dirname(__FILE__)."/../../import";

		/**
		 * Set the custom fields
		 */
		if (!is_array($customFields)) {
			$customFields = array();
		}

		$this->customFields = $customFields;

		if (!is_dir(ISC_TMP_IMPORT_DIRECTORY)) {
			mkdir(ISC_TMP_IMPORT_DIRECTORY);
			//alandy chomd dir.
			@chmod(ISC_TMP_IMPORT_DIRECTORY,0775);
		}

		$GLOBALS['ToDo'] = $_REQUEST['ToDo'];

		if(!isset($_REQUEST['Step'])) {
			$_REQUEST['Step'] = 1;
		}
		switch($_REQUEST['Step'])
		{
			case 2:
				$this->_ImportStep2();
				break;
			case 3:
				$this->_ImportStep3();
				break;
			case 4:
				//alandy modify.
				//this is orignal import function.
				$this->_Import();
				
				//this is new import function,also need change import.products.step3 url.
				//$this->_ImportStep4();
				break;
		  // case "ProcessImg":
				//@exec("/usr/bin/php ../importimglog.php > imglogs1 &#038;");
				//break;
			case 5:
				// calling the background process to update the price of the products under the discount
				@exec("/usr/bin/php ../updatefinalprice.php > logs1 &#038;");
				$this->_GenerateImportSummary();
				// calling the background process to img,VDO,ADO,ETC.!
				//@exec("/usr/bin/php ../importimglog.php > /var/log/import_log 2>&1 &");
				@exec("/usr/bin/php ../importimglog.php 185fe8da917cfbdce647e4e70e00f61e > /dev/null &");
				
				break;
			case 'ImportFrame':
				$this->_ImportStatusFrame();
				break;
			case "ViewReport":
				$this->_GenerateReport($_REQUEST['ReportType']);
			default:
				$this->_ImportStep1();
		}
	}

	/**
	 * Clean up the cache import directory, remove any old files
	 */





	private function _CleanupDirectory()
	{
		$dh = @opendir(ISC_TMP_IMPORT_DIRECTORY);
		$dh = opendir($this->ServerImportDirectory);
		if ($dh === false) {
			return '';
		}

		$html = '';
		while (($file = readdir($dh)) !== false) {
			if (is_file(ISC_TMP_IMPORT_DIRECTORY . "/" . $file) && filemtime(ISC_TMP_IMPORT_DIRECTORY . "/" . $file) < time()-7200) {
				@unlink(ISC_TMP_IMPORT_DIRECTORY . "/" . $file);
			}
		}

		// Try to remove directory (will only succeed if the directory is empty)
		@unlink(ISC_TMP_IMPORT_DIRECTORY);
	}

	/**
	 * Generic first step of the importer. Sets standard fields, builds list of importable files and shows step 1 page.
	 */
	protected function _ImportStep1()
	{
		$this->_CleanupDirectory();

		$GLOBALS['FieldEnclosure'] = EXPORT_FIELD_ENCLOSURE;
		$GLOBALS['FieldSeparator'] = EXPORT_FIELD_SEPARATOR;

		if($_SERVER['REQUEST_METHOD'] == "POST") {
			if(isset($_POST['FieldEnclosure'])) {
				$GLOBALS['FieldEnclosure'] = $_POST['FieldEnclosure'];
			}

			if(isset($_POST['FieldSeparator'])) {
				$GLOBALS['FieldSeparator'] = $_POST['FieldSeparator'];
			}
		}

		// PHP >= 4.3.0 supports the enclosure field, only show it if we have that PHP ver.
		$GLOBALS['ShowEnclosureField'] = '';
		if (version_compare(phpversion(), '4.3.0') < 0) {
			$GLOBALS['ShowEnclosureField'] = 'none';
		}

		$GLOBALS['ServerFiles'] = $this->_GetImportFiles();

		$MaxSize = $this->_GetMaxUploadSize();

		$GLOBALS['ISC_LANG']['ImportMaxSize'] = sprintf(GetLang('ImportMaxSize'), $MaxSize);

		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("import.{$this->type}.step1");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
	}

	protected function _GetMaxUploadSize()
	{
		$sizes = array(
			"upload_max_filesize" => ini_get("upload_max_filesize"),
			"post_max_size" => ini_get("post_max_size")
		);
		$max_size = -1;
		foreach($sizes as $size) {
			if (!$size) {
				continue;
			}
			$unit = isc_substr($size, -1);
			$size = isc_substr($size, 0, -1);
			switch(isc_strtolower($unit)) {
				case "g":
					$size *= 1024;
				case "m":
					$size *= 1024;
				case "k":
					$size *= 1024;
			}
			if($max_size == -1 || $size > $max_size) {
				$max_size = $size;
			}
		}
		if($max_size >= 1048576) {
			$max_size = floor($max_size/1048576)."MB";
		} else {
			$max_size = floor($max_size/1024)."KB";
		}
		return $max_size;
	}

	/**
	 * Generic second step of the importer. Handles uploaded files, parses out first row and shows field matching page.
	 */
	protected function _ImportStep2()
	{
		require dirname(__FILE__)."/class.csvimport.php";
		$importer = new ISC_CSVIMPORT_PARSER;

		//ini_set("max_execution_time",0);

		// Haven't been to this step before, need to parse CSV file
		if (!isset($this->ImportSession['FieldSeparator'])) {
			if (isset($_POST['Headers'])) {
				$this->ImportSession['Headers'] = $_POST['Headers'];
			}

			if (isset($_POST['OverrideDuplicates'])) {
				$this->ImportSession['OverrideDuplicates'] = $_POST['OverrideDuplicates'];
			}

			if (isset($_POST['Importastest'])) {
				$this->ImportSession['Importastest'] = $_POST['Importastest'];
			}
			else
			$this->ImportSession['Importastest'] = 0;


			// Using a file off the server
			if (isset($_POST['serverfile']) && $_POST['serverfile'] != "") {
				$_POST['serverfile'] = basename($_POST['serverfile']);
				if (!is_file($this->ServerImportDirectory . "/".  $_POST['serverfile'])) {
					$this->_ImportStep1(GetLang('ImportInvalidServerFile'), MSG_ERROR);
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					exit;
				}
				
				$newfilename = $this->ServerImportDirectory . '/' . $_POST['serverfile'];
				
			} else {
				if (!isset($_FILES['importfile'])) {
					$this->_ImportStep1($this->_GetUploadError(0), MSG_ERROR);
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					exit;
				}
				if (!is_uploaded_file($_FILES['importfile']['tmp_name']) || $_FILES['importfile']['error']) {
					$this->_ImportStep1($this->_GetUploadError($_FILES['importfile']['error']), MSG_ERROR);
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					exit;
				}

				// Move the uploaded file to the cache directory temporarily with a new unique name
				while(true) {
					$newfilename = ISC_TMP_IMPORT_DIRECTORY . '/' . $this->type . '-import-' . md5(uniqid(rand(), true));
                   //alandy give the path 777.
					@chmod($newfilename, 0775);
					if (!is_file($newfilename)) {
						break;
					}
				}
               //alandy modify.
			    if(move_uploaded_file($_FILES['importfile']['tmp_name'], $newfilename)){
					@chmod($newfilename, 0775);
				}else{
					$this->_ImportStep1(GetLang('ImportUploadMoveFailed'), MSG_ERROR);
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					exit;
				}
				/*
				if (!move_uploaded_file($_FILES['importfile']['tmp_name'], $newfilename)) {
					$this->_ImportStep1(GetLang('ImportUploadMoveFailed'), MSG_ERROR);
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					exit;
				}
				*/
			}



			$this->ImportSession['FieldEnclosure'] = html_entity_decode($_POST['FieldEnclosure']);
			$this->ImportSession['FieldSeparator'] = html_entity_decode($_POST['FieldSeparator']);

			if (isset($this->ImportSession['FieldSeparator']) && $this->ImportSession['FieldSeparator'] != "") {
				$importer->FieldSeparator = $this->ImportSession['FieldSeparator'];
			}

			if (isset($this->ImportSession['FieldEnclosure']) && $this->ImportSession['FieldEnclosure'] != "") {
				$importer->FieldEnclosure = $this->ImportSession['FieldEnclosure'];
			}

			$this->ImportSession['ImportFile'] = $newfilename;

			$importer->OpenCSVFile($newfilename);
			$header = $importer->FetchNextRecord();
			$importer->CloseCSVFile();
			


			$this->ImportSession['TotalFileSize'] = filesize($newfilename);
			$this->ImportSession['LastPosition'] = 0;
			$this->ImportSession['PageSize'] = 3000;

			if (!$header) {
				$this->_ImportStep1('Invalid file', MSG_ERROR);
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				exit;
			}

			if (isset($_POST['Headers']) && $_POST['Headers'] == 1) {
				$this->ImportSession['Header'] = $header;
			}
		}
		// Already been past this step once, no need to reparse CSV file
		else {
			$importer->OpenCSVFile($this->ImportSession['ImportFile']);
			$header = $importer->FetchNextRecord();
			$importer->CloseCSVFile();
		}






		$_SESSION['qualifiers'] = array();
		$_SESSION['qualifiers_name'] = array();
		$vqpq = array();
		$_SESSION['assocvqpq'] = array();
		$_SESSION['t'] = time();
		$fields = array();
		$rejecteddata = "";
		$vendorId = 0;
		$_SESSION['rejecteddata'] = "";
		$strings = array();


		// Storing categories and its associated qualifiers in a session to use this in the import process

		$query2 = " SELECT `categoryid` , GROUP_CONCAT( `qualifierid` ) AS qualifiers FROM [|PREFIX|]qualifier_associations 			GROUP BY `categoryid` 	  ";
		$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
		while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2))
		{
			$_SESSION['assocvqpq'][$row['categoryid']] = explode(',',$row['qualifiers']);

		}


		// fetching qualifier names and qualifier id.
		$query2 = "SELECT qid,column_name  FROM [|PREFIX|]qualifier_names   ";
		$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
		while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2))
		{
			if (substr($row['column_name'],0,2) == "VQ" || substr($row['column_name'],0,2) == "PQ")
			{
				$vqpq[$row['qid']] = substr($row['column_name'],0,2).strtolower(substr($row['column_name'],2));

			}
		}


		foreach ($_SESSION['assocvqpq'] as $key => $value) {
			foreach ($_SESSION['assocvqpq'][$key] as $k => $v) {
				if (isset($vqpq[$v]))
				$_SESSION['assocvqpq'][$key][$k] = $vqpq[$v];

			}


		}


		//finding existiong fields in import variation table.
		$query = "SELECT * FROM [|PREFIX|]import_variations";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$columns = mysql_num_fields($result);
		for($i = 8; $i < $columns; $i++) {
			$temp = mysql_field_name($result,$i);
			array_push($fields,$temp);
		}



		$query2 = "SELECT max(id) as maxrowid FROM [|PREFIX|]import_variations  ";
		$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
		$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2);
		$_SESSION['row_no'] = $row['maxrowid']+1;


		// create new fields in the database.

		for($i = 0; $i < count($header); $i++) {

			$_SESSION['rejecteddata'].= $header[$i].",";

			if (substr($header[$i],0,2) == "VQ" || substr($header[$i],0,2) == "PQ")
			{

				$newfields = str_replace(" ", "", $header[$i]);
				$string_temp =  substr($newfields,2);
				$newfields =  substr($newfields,0,2).strtolower($string_temp);

				array_push($_SESSION['qualifiers'], $newfields);

				if (!in_array($newfields,$fields))
				{
					$sql2 = "ALTER TABLE `isc_import_variations` ADD ".$newfields." VARCHAR(200) NULL";
					mysql_query($sql2);

					// this is only for make search fast.

					// this is create display name

					$space_separated = preg_replace ('/([A-Z])/',' $1', $string_temp) ;

					// this is create display name


					$sql2= "INSERT INTO `isc_qualifier_names` (`column_name`,`display_names`) VALUES ('".$newfields."','".$space_separated."')";
					mysql_query($sql2);


					// this is only for search fast purpose


				}

					

			}

		}


		$tmpArr1 = array();
		for($i = 0; $i < count($_SESSION['qualifiers']); $i++) {
			$tmpArr1[$_SESSION['qualifiers'][$i]] = $_SESSION['qualifiers'][$i];
		}

		//array_push($_SESSION['qualifiers'], "make" , "model","submodel","startyear","endyear");
		array_push($_SESSION['qualifiers'], "prodmake" , "prodmodel","prodsubmodel","prodstartyear","prodendyear");



		for($i = 0; $i < count($_SESSION['qualifiers']); $i++)
		{
			$tempval = $_SESSION['qualifiers'][$i];
			$query2 = "SELECT qid FROM [|PREFIX|]qualifier_names  WHERE `column_name` = '".$tempval."'  ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
			$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2);
			$_SESSION['qualifiers_name'][$tempval] =  $row['qid'];

		}



		$this->_ImportFields = array_merge($this->_ImportFields,$tmpArr1);


		//task 1 end




		$fieldlist = '';
		$k=0;



		foreach($this->_ImportFields as $column => $field) {
			$fieldlist .= $this->_buildMatchField($column, $field, $header);

		}




		$GLOBALS['ImportFieldList'] = $fieldlist;

		$GLOBALS['ImportSession'] = $_REQUEST['ImportSession'];
		$this->SaveImportSession();


		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("import.{$this->type}.step2");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();


	}

	private function _buildMatchField($column, $field, $header)
	{
		if ($column == "category2" || $column == "category3") {
			return '';
		} else if (is_scalar($column) && $column == 'custom') {
			$html = '';
			foreach ($field as $fieldId => $label) {
				$newColumn = array('custom', $fieldId);
				$html .= $this->_buildMatchField($newColumn, $label, $header);
					
			}

			return $html;
		}

		$GLOBALS['Extra'] = '';
		if($column == "prodimagefile") {
			$GLOBALS['Extra'] = '<br /><a href="#" onclick="LaunchHelp(\'718\'); return false;" style="color: gray;">'.GetLang('LearnMoreAboutImportingImages').'</a>';
		}
		else if($column == "prodfile") {
			$GLOBALS['Extra'] = '<br /><a href="#" onclick="LaunchHelp(\'728\'); return false;" style="color: gray;">'.GetLang('LearnMoreAboutImportingFiles').'</a>';
		}

		$columnName = $column;
		$columnId = $column;
		if (is_array($column)) {
			$columnName = implode('][', $column);
			$columnId = implode('_', $column);
		}

		$GLOBALS['FieldName'] = sprintf(GetLang('ImportMatchOption'), $field);
		$GLOBALS['OptionName'] = 'LinkField[' . $columnName . ']';
		$GLOBALS['FieldId'] = "Match" . $columnId;
		$GLOBALS['HelpId'] = "Help" . $columnId;
		$GLOBALS['FieldNameHelpTitle'] = str_replace("'", "\\'", sprintf(GetLang('ImportMatchOption'), $field));

		if (is_array($column) && isset($this->customFields[$column[1]]) && strtolower($this->customFields[$column[1]]->record['formfieldtype']) == 'datechooser') {
			$GLOBALS['FieldNameHelp'] = str_replace("'", "\\'", sprintf(GetLang('ImportMatchOptionDateHelp'), $field));
		} else {
			$GLOBALS['FieldNameHelp'] = str_replace("'", "\\'", sprintf(GetLang('ImportMatchOptionHelp'), $field));
		}

		$GLOBALS['Required'] = "&nbsp;";

		if(is_array($this->_RequiredFields) && is_scalar($column) && in_array($column, $this->_RequiredFields)) {
			$GLOBALS['Required'] = "*";
		}

		$optionlist = '';
		$AlreadyMatched = array();
		foreach($header as $k => $value) {

			// forcing to match vendor by default.blessen
			if ($columnId == "prodvendorid" && strtolower($value) == "vendor" )
			{
				$AlreadyMatched['prodvendorid'] = 1;
				$optionlist .= "<option value='{$k}' selected='selected'>{$value}</option>";
			}


			if(isset($_POST['Headers']) && preg_match("#".preg_quote($field, "#")."#i", $value) && !isset($AlreadyMatched[$columnId])) {
				$AlreadyMatched[$columnId] = 1;
				$optionlist .= "<option value='{$k}' selected='selected'>{$value}</option>";
			}
			else {
				$optionlist .= "<option value='{$k}'>{$value}</option>";
			}
		}
		$GLOBALS['OptionList'] = $optionlist;

		if ($column == "category") {

			//temp adj to make csubcat match by default
			$GLOBALS['OptionList2'] = str_ireplace(">SUBCATEGORY</option>"," selected='selected' >SUBCATEGORY</option>",$optionlist);


			return $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ImportMatchOptionCategory");
		}
		else {
			return $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ImportMatchOption");
		}
	}

	/**
	 * Generic third step of the importer. Saves matched fields, prepares to run import process (shows "Start Import" page)
	 */
	protected function _ImportStep3()
	{
		// Save the matched pairs of fields
		if(!isset($_POST['LinkField'])) {
			exit;
		}

		if(isset($_POST['categoryType'])) {
			if($_POST['categoryType'] == 'single') {
				unset($_POST['LinkField']['category1']);
				unset($_POST['LinkField']['category2']);
				unset($_POST['LinkField']['category3']);
			}
		}

		$this->ImportSession['FieldList'] = array();

		foreach($_POST['LinkField'] as $column => $index) {
			if ($column == 'custom') {
				$newIndex = array();

				foreach ($index as $fieldId => $val) {
					if ((int)$val == -1 || $val === null) {
						continue;
					} else {
						$newIndex[$fieldId] = $val;
					}
				}

				if (empty($newIndex)) {
					continue;
				} else {
					$index = $newIndex;
				}
			}

			if ((int)$index == -1 || $index === null) {
				continue;
			}
			$this->ImportSession['FieldList'][$column] = $index;
		}

		if(isset($this->_RequiredFields)) {
			foreach($this->_RequiredFields as $field) {
				if(!in_array($field, array_keys($this->ImportSession['FieldList']))) {
					$GLOBALS['ISC_LANG']['ImportNoRequiredField'] = sprintf(GetLang('ImportNoRequiredField'), $this->_ImportFields[$field]);
					$this->_ImportStep2(GetLang('ImportNoRequiredField'), MSG_ERROR);
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					exit;
				}
			}
		}

		// Ready some variables used later on
		$this->ImportSession['Results'] = array(
			"SuccessCount" => '0',
			"Imported" => '0',
			"Failures" => array(),
			"Duplicates" => array(),
			"Updates" => array(),
			"Warnings" => array()
		);

		$GLOBALS['ImportSession'] = $_REQUEST['ImportSession'];
		$this->SaveImportSession();

		// Show the 'Are you ready to import?' screen
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("import.{$this->type}.step3");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
	}

	/**
	 * Generate a listing of importable files in the import directory.
	 *
	 * @return string A list of options of importable files for use within a <select>
	 */
	private function _GetImportFiles()
	{
		if(!is_dir($this->ServerImportDirectory)) {
			return '';
		}
		$dh = opendir($this->ServerImportDirectory);
		if($dh === false) {
			return '';
		}

		$html = '';
		while(($file = readdir($dh)) !== false) {
			if($file != "index.php") {
				if(is_file($this->ServerImportDirectory . "/" . $file) && is_readable($this->ServerImportDirectory . "/" . $file)) {
					$html .= '<option value="'.$file.'">'.$file.'</option>';
				}
			}
		}
		closedir($dh);
		return $html;
	}

	/**
	 * Fetch a friendly error message as to why the file upload failed.
	 *
	 * @param int The error ID (from $_FILE)
	 * @return string Friendly error message
	 */
	private function _GetUploadError($error)
	{
		switch($error)
		{
			case 0:
				return sprintf(GetLang('ImportUploadError'), $this->_GetMaxUploadSize());
			case UPLOAD_ERR_INI_SIZE:
				return GetLang('ImportUploadErrorIniSize');
			case UPLOAD_ERR_FORM_SIZE:
				return GetLang('ImportUploadErrorFormSize');
			case UPLOAD_ERR_PARTIAL:
				return GetLang('ImportUploadErrorPartial');
			case UPLOAD_ERR_NO_FILE:
				return GetLang('ImportUploadErrorNoFile');
			case UPLOAD_ERR_NO_TMP_DIR:
				return GetLang('ImportUploadErrorNoTmp');
			case UPLOAD_ERR_CANT_WRITE:
				return GetLang('ImportUploadErrorCantWrite');
			case UPLOAD_ERR_CANT_WRITE:
				return GetLang('ImportUploadErrorExtension');
		}
	}

	protected function StringToYesNoInt($string)
	{
		switch(isc_strtolower($string)) {
			case "yes":
			case "true":
			case 1:
			case "y":
			case "on":
				return 1;
				break;
			default:
				return 0;
		}
	}

	/**
	 * Show the iframe containing the import status.
	 */
	private function _ImportStatusFrame()
	{
		//alandy change the template.
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

		$GLOBALS['ImportSession'] = $_REQUEST['ImportSession'];
		$GLOBALS['Report'] = $this->_FetchInlineReport();

		$GLOBALS['Type'] = ucfirst($this->type);

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("import.importpopup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

		unset($_SESSION['OverRidedInThisImport']);

	}

	/**
	 * Alandy_2011-5-111 add.
	 * Create temporary table from open.csv & process batching!
	 */
	
	private function _ImportStep4(){
	    $_SESSION['commintproductcount']=0;
	    $_SESSION['commintproductfailecount']=0;
		$csvfile=array();
		$TypeLang = "Import".ucfirst($this->type);

		if(!isset($this->ImportSession['DoneCount'])) {
			$this->ImportSession['DoneCount'] = 0;
		}
	
			
		require dirname(__FILE__)."/class.csvimport.php";
		$importer = new ISC_CSVIMPORT_PARSER;

		if(isset($this->ImportSession['FieldSeparator']) && $this->ImportSession['FieldSeparator'] != "") {
			$importer->FieldSeparator = $this->ImportSession['FieldSeparator'];
		}

		if(isset($this->ImportSession['FieldEnclosure']) && $this->ImportSession['FieldEnclosure'] != "") {
			$importer->FieldEnclosure = $this->ImportSession['FieldEnclosure'];
		}

		$importer->SetRecordFields($this->ImportSession['FieldList']);
		$importer->OpenCSVFile($this->ImportSession['ImportFile'], $this->ImportSession['LastPosition']);

		
		
		//alandy . Fetch the CSV Header by step2 importsession

		
		$header=$importer->FetchHeaderRecord();
		$headercolumn=implode(",",$header);
				
		if(isset($this->ImportSession['Headers']) && $this->ImportSession['Headers'] == 1 && !isset($this->ImportSession['InImport'])) {
				
			//create temporary table isc_import_product,auto calculate int,char,longtext column.

			$textColumn=array("description","complementary_items");
			$intColumn=array("price","jobber_price","map_price","retail_price","sale_price","package_length","package_width","package_height","package_weight","our_cost","future_price","future_jobber_price","future_map_price","future_retail_price");
			$longcharColumn=array("product_article","feature_points","product_images");

			foreach($header as $key=>$column){
				//format PQ/VQ
				if(substr($column,0,2)=='PQ' || substr($column,0,2)=='VQ'){
					$column=substr($column,0,2).strtolower(substr($column,2));
			   }
			   
				
				if(substr($column,0,2)=='PQ' || substr($column,0,2)=='VQ'){
					$sql.="`".$column."`"." varchar(100)  default '',";
				}elseif(in_array($column,$textColumn)){
					$sql.="`".$column."`"." text,";
				}elseif(in_array($column,$intColumn)){
					$sql.="`".$column."`"." decimal(20,4) NOT NULL DEFAULT '0.0000',";
				}elseif(in_array($column,$longcharColumn)){
					$sql.="`".$column."`"." varchar(500)  DEFAULT '0',";
				}else{
					$sql.="`".$column."`"." varchar(50) not null default '',";
				}
					
			}

			$sql.="`tempid` int(11) not null auto_increment,";
			$sql.="`vendorid` int(11) NOT NULL DEFAULT '0',";
			$sql.="`categoryid` int(11) NOT NULL DEFAULT '0',";
			$sql.="`subcategoryid` int(11) NOT NULL DEFAULT '0',";
			$sql.="`brandid` int(11) NOT NULL DEFAULT '0',";
			$sql.="`catuniversal` int(11) NOT NULL DEFAULT '0',";
			$sql.="`pcatparentid` int(11) NOT NULL DEFAULT '0',";
			$sql.="`catparentid` int(11) NOT NULL DEFAULT '0',";
			$sql.="catcombine varchar(100) NOT NULL DEFAULT '',";
			$sql.="`productname` varchar(100) NOT NULL DEFAULT '',";
			$sql.="`flag` int(4) NOT NULL DEFAULT '0',";
			//$sql.="`rejectreason` int(4) NOT NULL DEFAULT '0',";

			$dropsql="DROP TABLE IF EXISTS isc_import_products";

			$GLOBALS['ISC_CLASS_DB']->Query($dropsql);
			//TEMPORARY

			$createsql="CREATE  TABLE IF NOT EXISTS isc_import_products ( ".$sql." PRIMARY KEY (`tempid`) )  DEFAULT CHARSET=utf8";

			$GLOBALS['ISC_CLASS_DB']->Query($createsql);
			       
		
		}
		
		$this->ImportSession['InImport'] = 1;
			

		$loadsql="LOAD DATA INFILE '".$this->ImportSession['ImportFile']."' INTO TABLE isc_import_products  FIELDS TERMINATED BY '".$this->ImportSession['FieldSeparator']."' ENCLOSED BY '".$this->ImportSession['FieldEnclosure']."' IGNORE 1 LINES";
		 
		$GLOBALS['ISC_CLASS_DB']->Query($loadsql);
		
		echo "<script type='text/javascript'>\n";
					echo sprintf("self.parent.UpdateImportStatusReport('%s');", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), $report));
					$GLOBALS['ISC_LANG']['ImportInProgressDesc'] = sprintf(GetLang('ImportInProgressDesc'), 0);
					echo sprintf("self.parent.UpdateImportStatus('%s', %d);", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), GetLang('ImportInProgressDesc')), 1);
					echo "</script>\n";
					print str_repeat(" ", 4096);
					ob_flush();
					flush();
		// we need vendor id from join table vendor.name
			
		$updateVendoridSql="update [|PREFIX|]import_products p
			                     left join [|PREFIX|]vendors v on p.vendor=v.vendorname
			                     set p.vendorid=v.vendorid";
		$GLOBALS['ISC_CLASS_DB']->Query($updateVendoridSql);
			
		echo "<script type='text/javascript'>\n";
					echo sprintf("self.parent.UpdateImportStatusReport('%s');", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), $report));
					$GLOBALS['ISC_LANG']['ImportInProgressDesc'] = sprintf(GetLang('ImportInProgressDesc'), 0);
					echo sprintf("self.parent.UpdateImportStatus('%s', %d);", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), GetLang('ImportInProgressDesc')), 3);
					echo "</script>\n";
					print str_repeat(" ", 4096);
					ob_flush();
					flush();
			
		// Automatically fetching categories based on CSV field
		if(isset($this->ImportSession['AutoCategory'])) {
			$updateCatgory="update [|PREFIX|]import_products p
			                     left join [|PREFIX|]categories c on trim(LOWER(p.category))=trim(LOWER(c.catname))
                                 and c.catparentid=0
			                     set p.categoryid = c.categoryid,
			                         p.pcatparentid=c.catparentid,
			                         p.catuniversal=c.catuniversal,
			                         p.catcombine=c.catcombine,
			                         p.productname=c.productname";
			$GLOBALS['ISC_CLASS_DB']->Query($updateCatgory);
		  
			echo "<script type='text/javascript'>\n";
					echo sprintf("self.parent.UpdateImportStatusReport('%s');", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), $report));
					$GLOBALS['ISC_LANG']['ImportInProgressDesc'] = sprintf(GetLang('ImportInProgressDesc'), 0);
					echo sprintf("self.parent.UpdateImportStatus('%s', %d);", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), GetLang('ImportInProgressDesc')), 6);
					echo "</script>\n";
					print str_repeat(" ", 4096);
					ob_flush();
					flush();

				$updateSubcatgory="update [|PREFIX|]import_products p
			                       left join [|PREFIX|]categories c on trim(LOWER(p.subcategory))=trim(LOWER(c.catname))
			                       and p.categoryid=c.catparentid
                                   set p.subcategoryid = c.categoryid,
                                       p.catparentid = c.catparentid,
                                       p.catuniversal=c.catuniversal,
                                       p.catcombine=c.catcombine,
			                           p.productname=c.productname
                                      ";
				$GLOBALS['ISC_CLASS_DB']->Query($updateSubcatgory);

			echo "<script type='text/javascript'>\n";
					echo sprintf("self.parent.UpdateImportStatusReport('%s');", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), $report));
					$GLOBALS['ISC_LANG']['ImportInProgressDesc'] = sprintf(GetLang('ImportInProgressDesc'), 0);
					echo sprintf("self.parent.UpdateImportStatus('%s', %d);", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), GetLang('ImportInProgressDesc')), 8);
					echo "</script>\n";
					print str_repeat(" ", 4096);
					ob_flush();
					flush();
		  

		}else {
			$cats = array($this->ImportSession['CategoryId']);
			
		}
		 
		
		// Does the brand already exist?
		//update the exist brand
		$updateBrand="update [|PREFIX|]import_products p
			                       left join [|PREFIX|]brands b on trim(LOWER(p.brand))=trim(LOWER(b.brandname))
                                   set p.brandid = b.brandid";
		$GLOBALS['ISC_CLASS_DB']->Query($updateBrand);
		
		echo "<script type='text/javascript'>\n";
					echo sprintf("self.parent.UpdateImportStatusReport('%s');", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), $report));
					$GLOBALS['ISC_LANG']['ImportInProgressDesc'] = sprintf(GetLang('ImportInProgressDesc'), 0);
					echo sprintf("self.parent.UpdateImportStatus('%s', %d);", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), GetLang('ImportInProgressDesc')), 10);
					echo "</script>\n";
					print str_repeat(" ", 4096);
					ob_flush();
					flush();
		 //prepare do examine for direct insert into root category,give reject reason 3;Products cannot store directly to the root category!
		 //need to complete.
		$totalSql="select count(tempid) as total from [|PREFIX|]import_products"; 
		$query=$GLOBALS['ISC_CLASS_DB']->Query($totalSql);
		while($rs=$GLOBALS['ISC_CLASS_DB']->Fetch($query)){
			$this->ImportSession['TotalCount']=$rs['total'];
		}
				
		$sql="select * from [|PREFIX|]import_products order by tempid asc";
		$query=$GLOBALS['ISC_CLASS_DB']->Query($sql);
		
         while($record=$GLOBALS['ISC_CLASS_DB']->Fetch($query)){

			    //prepare everyrecord into product and PQ/VQ table.
			   
			    //$this->_prepareImport($record);
			    
			    $this->_prepareImport2($record,$this->ImportSession['FieldList']);
			  
				$currentPosition = (int)$record['tempid'];
				//attention,this sub processbar width only 90
				$newpercent = ceil(($record['tempid']/$this->ImportSession['TotalCount'])*100*0.9)+10;
				
				if($newpercent>$percent ){
					$percent=$newpercent;
							    
				    $report = $this->_FetchInlineReport();

				    
					echo "<script type='text/javascript'>\n";
					echo sprintf("self.parent.UpdateImportStatusReport('%s');", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), $report));
					$GLOBALS['ISC_LANG']['ImportInProgressDesc'] = sprintf(GetLang('ImportInProgressDesc'), $currentPosition);
					echo sprintf("self.parent.UpdateImportStatus('%s', %d);", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), GetLang('ImportInProgressDesc')), $percent);
					echo "</script>\n";
					print str_repeat(" ", 4096);
					ob_flush();
					flush();
															
				}
				
		 }
		
		$GLOBALS['ImportSession'] = $_REQUEST['ImportSession'];
		$this->SaveImportSession();
		
	      // Nothing left to import, redirect to the finish page
			$locationUrl = "index.php?ToDo=Import".ucfirst($this->type)."&Step=5&ImportSession=".urlencode($GLOBALS['ImportSession']);
			
		 ?>
			
           <script type="text/javascript">
				window.onload = function()
				{					
					self.parent.parent.location= '<?php echo $locationUrl; ?>';
					
				}
			</script>
			<?php
			exit;
	}
	/**
	 * Performs the actual import - imports the current chunk from the data file.
	 */
	private function _Import()
	{
		
		$TypeLang = "Import".ucfirst($this->type);

		//$current_file = @array_shift($this->ImportSession['ChunkList']);

		if(!isset($this->ImportSession['DoneCount'])) {
			$this->ImportSession['DoneCount'] = 0;
		}

		$done = 0;
		$percent = 0;
		if (isset($this->ImportSession['DoneCount'])) {
			$done = $this->ImportSession['DoneCount'];
			//$percent = ceil(($done/$this->ImportSession['TotalItems']) * 100);
			$percent = ceil(($this->ImportSession['LastPosition']/$this->ImportSession['TotalFileSize'])*100);
		}

		require dirname(__FILE__)."/class.csvimport.php";
		$importer = new ISC_CSVIMPORT_PARSER;

		if(isset($this->ImportSession['FieldSeparator']) && $this->ImportSession['FieldSeparator'] != "") {
			$importer->FieldSeparator = $this->ImportSession['FieldSeparator'];
		}

		if(isset($this->ImportSession['FieldEnclosure']) && $this->ImportSession['FieldEnclosure'] != "") {
			$importer->FieldEnclosure = $this->ImportSession['FieldEnclosure'];
		}

		$importer->SetRecordFields($this->ImportSession['FieldList']);
		$importer->OpenCSVFile($this->ImportSession['ImportFile'], $this->ImportSession['LastPosition']);

		if ($this->ImportSession['LastPosition'] < $this->ImportSession['TotalFileSize']) {
			// This is our first iteration of the import, headers are enabled so skip past the first row
			if(isset($this->ImportSession['Headers']) && $this->ImportSession['Headers'] == 1 && !isset($this->ImportSession['InImport'])) {
				$importer->FetchNextRecord();
			}
				
			$this->ImportSession['InImport'] = 1;

			while(($record = $importer->FetchNextRecord(true)) !== false) {
				// Call the function to handle the record
				//alandy
				$this->_ImportRecord($record);
				


				$currentPosition = $importer->GetCurrentPosition();
				//$newPercent = ceil(($done/$this->ImportSession['TotalItems']* 100));
				$newPercent = ceil(($currentPosition/$this->ImportSession['TotalFileSize'])*100);
				if($newPercent > $percent) {
					$percent = $newPercent;
					$report = $this->_FetchInlineReport();

					// Update the status
					echo "<script type='text/javascript'>\n";
					echo sprintf("self.parent.UpdateImportStatusReport('%s');", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), $report));
					$GLOBALS['ISC_LANG']['ImportInProgressDesc'] = sprintf(GetLang('ImportInProgressDesc'), $this->ImportSession['DoneCount']+$importer->GetRecordNum());
					echo sprintf("self.parent.UpdateImportStatus('%s', %d);", str_replace(array("\n", "\r", "'"), array(" ", "", "\\'"), GetLang('ImportInProgressDesc')), $percent);
					echo "</script>\n";
					flush();

				}
			}

			$this->ImportSession['LastPosition'] = $importer->GetCurrentPosition();
			$this->ImportSession['DoneCount'] += $importer->GetRecordNum();
		}

		$GLOBALS['ImportSession'] = $_REQUEST['ImportSession'];
		$this->SaveImportSession();

		// Nothing left to import, redirect to the finish page
		if($this->ImportSession['LastPosition'] === false || $this->ImportSession['LastPosition'] >= $this->ImportSession['TotalFileSize']) {

			$locationUrl = "index.php?ToDo=Import".ucfirst($this->type)."&Step=5&ImportSession=".urlencode($GLOBALS['ImportSession']);
			?>
<script type="text/javascript">
				window.onload = function()
				{
					//alandy
					self.parent.parent.location= '<?php echo $locationUrl; ?>';
				}
			</script>
			<?php
			exit;
		}
		// Still importing, jump to next page
		else {
			$locationUrl = "index.php?ToDo=Import".ucfirst($this->type)."&Step=4&x=".rand(1, 50)."&ImportSession=".$GLOBALS['ImportSession'];
			?>
<script type="text/javascript">
				window.onload = function()
				{
					setTimeout('window.location="<?php echo $locationUrl; ?>"', 10);
				}
			</script>
			<?php
			exit;
		}
	}

	private function _FetchInlineReport()
	{
		$TypeLang = "Import".ucfirst($this->type);

		$report = '';
		foreach(array('SuccessCount', 'Failures', 'Duplicates', 'Updates', 'Warnings') as $type) {
			if($type == 'SuccessCount') {
				$amount = $this->ImportSession['Results'][$type];
			}
			else {
				$amount = count($this->ImportSession['Results'][$type]);
			}
			if($amount == 1) {
				$report .= GetLang($TypeLang . 'Progress_' . $type . '_One');
			}
			else {
				$amount = number_format($amount);
				$report .= sprintf(GetLang($TypeLang . 'Progress_' . $type . '_Many'), $amount);
			}
			$report .= '<br />';
		}
		return $report;
	}

	/**
	 * An import has just finished, this page generates the import summary.
	 */
	private function _GenerateImportSummary()
	{
		$TypeLang = "Import".ucfirst($this->type);

		$report = '<ul>';
		foreach(array('SuccessCount','Imported','Updates') as $type) {
			if($type == 'SuccessCount') {
				$amount = $this->ImportSession['Results'][$type];
			}
			else if($type == 'Imported') {
				$amount = $this->ImportSession['Results'][$type];
			}
			else
			{
				$amount = count($this->ImportSession['Results'][$type]);
			}
			$report .= "<li>\n";
			if($amount == 1) {
				$report .= GetLang($TypeLang . $type . '_One');
			}
			else {
				$amount = number_format($amount);
				$report .= sprintf(GetLang($TypeLang . $type . '_Many'), $amount);
			}
		}

		foreach(array('Duplicates', 'Failures', 'Warnings') as $type) {
			$amount = count($this->ImportSession['Results'][$type]);
			$report .= "<li>";

			if($amount > 0) {
				if($amount == 1) {
					$report .= sprintf(GetLang($TypeLang . $type . '_One_Link'), '"'.$type.'"');
				}
				else {
					$amount = number_format($amount);
					$report .= sprintf(GetLang($TypeLang . $type . '_Many_Link'), $amount, '"'.$type.'"');
				}
			}
			else {
				$report .= sprintf(GetLang($TypeLang . $type . '_Many'), $amount, '"'.$type.'"');
			}
		}
		$report .= "</ul>";

		$GLOBALS['Message'] = MessageBox(GetLang($TypeLang . 'Successful'), MSG_SUCCESS);
		$GLOBALS['Report'] = $report;

		// Cleanup any remaining files
		if(isset($this->ImportSession['ImportFile']) && is_file($this->ImportSession['ImportFile'])) {
			//alandy.caution here.
			//unlink($this->ImportSession['ImportFile']);
		}
		$GLOBALS['ImportSession'] = $_REQUEST['ImportSession'];
		$this->SaveImportSession();

		$this->_CleanupDirectory();

		// Log this action
		$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($this->ImportSession['Results']['SuccessCount']);

		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("import.{$this->type}.step5");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
	}

	/**
	 * Generate a specific report for the current import session.
	 *
	 * @param string The report type (Duplicates, Failures)
	 */
	private function _GenerateReport($ReportType)
	{

		unset($_SESSION['OverRidedInThisImport']);

		switch($ReportType) {
			case "Duplicates":
				$GLOBALS['Heading'] = GetLang('ImportReportDuplicates');
				$GLOBALS['Intro'] = GetLang('ImportReportDuplicatesIntro');

				$duplicates = '';
				foreach($this->ImportSession['Results']['Duplicates'] as $duplicate) {
					$duplicates .= isc_html_escape(trim($duplicate))."\n";
				}
				$GLOBALS['Results'] = $duplicates;
				break;
			case "Warnings":
				$GLOBALS['Heading'] = GetLang('ImportReportWarnings');
				$GLOBALS['Intro'] = GetLang('ImportReportWarningsIntro');

				$warnings = '';
				foreach($this->ImportSession['Results']['Warnings'] as $warning) {
					$warnings .= isc_html_escape(trim($warning))."\n";
				}
				$GLOBALS['Results'] = $warnings;
				break;
			default:
				$GLOBALS['Heading'] = GetLang('ImportReportFailures');
				$GLOBALS['Intro'] = GetLang('ImportReportFailuresIntro');

				$records = '';
				foreach($this->ImportSession['Results']['Failures'] as $record) {
					//$records .= isc_html_escape(trim($record))."\n";
					$records .= trim($record)."\n";
				}
				$GLOBALS['Results'] = $records;
				break;
		}
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("import.resultspopup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pagefooter.popup");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

		exit;
	}

	private function SaveImportSession()
	{
		$ImportSession = var_export($this->ImportSession, true);
		$fp = fopen(ISC_TMP_IMPORT_DIRECTORY."/session-{$_REQUEST['ImportSession']}", "w");
		fwrite($fp,	"<"."?php\n\$ImportSession = $ImportSession;\n\n?".">");
		fclose($fp);
	}

	/**
	 * Import any custom fields
	 *
	 * Method will import the custom fields. Will also handle existing formsessions
	 *
	 * @access private
	 * @param int $type The type of form (the form ID in isc_formfields)
	 * @param array $fields The array of form field session data
	 * @param int $existingSessionId The optional existing form session Id. Default is 0 (new)
	 * @return mixed The form session Id on successful creation, TRUE of successful update if
	 *               $existingSessionId was given, FALSE on error
	 */
	protected function _importCustomFormfields($type, $fields, $existingSessionId=0)
	{
		if (!isId($type) || !is_array($fields) || empty($fields)) {
			return false;
		}

		$formSessData = array();

		foreach (array_keys($this->customFields) as $fieldId) {
			if (!array_key_exists($fieldId, $fields) || (int)$this->customFields[$fieldId]->record['formfieldformid'] !== (int)$type) {
				continue;
			}

			$type = strtolower($this->customFields[$fieldId]->record['formfieldtype']);

			/**
			 * Explode the value if this is a checkbox field
			 */
			$recordValue = $fields[$fieldId];
			if ($type == 'checkboxselect') {
				$recordValue = explode(',', $recordValue);
				$recordValue = array_map('trim', $recordValue);
			}

			/**
			 * We'll also need to run the validation. If we fail then just skip it. Unset the
			 * required flag aswell as we can't ask them to fill it in
			 */
			$this->customFields[$fieldId]->setRequired(false);
			$this->customFields[$fieldId]->setValue($recordValue, false, true);
			$errmsg = '';

			if (!$this->customFields[$fieldId]->runValidation($errmsg)) {
				continue;
			}

			$formSessData[$fieldId] = $this->customFields[$fieldId]->getValue();
		}

		if (!empty($formSessData)) {
			return $GLOBALS['ISC_CLASS_FORM']->saveFormSessionManual($formSessData, $existingSessionId);
		}

		return false;
	}
}

class ISC_BATCH_IMPORTER_PRODUCTS extends ISC_BACTH_IMPORTER_BASE
{
	/**
	 * @var string The type of content we're importing. Should be lower case and correspond with template and language variable names.
	 */
	protected $type = "products";

	protected $_RequiredFields = array();

	public function __construct()
	{
		/*if(isset($_SESSION['OverRidedInThisImport']))
		 {
			unset($_SESSION['OverRidedInThisImport']);
			}*/
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('batch.importer');

		/**
		 * @var array Array of importable fields and their friendly names.
		 */
		$this->_ImportFields = array(
			"prodname" => GetLang('ProductName'),
			"category" => GetLang('ImportProductsCategory'),
			"category2" => "SUBCATEGORY",
			"category3" => "Ignore",
			"brandname" => GetLang('BrandName'),
			"prodcode" => "PARTNUMBER",
			"proddesc" => "DESCRIPTION",
			"prodmake" => GetLang('prodmake'),
			"prodmodel" => GetLang('prodmodel'),
            "prodsubmodel" => "SUBMODEL",
			"prodstartyear" => GetLang('prodstartyear'),
            "prodendyear" => GetLang('prodendyear'),
			"prodavailability" => GetLang('Availability'),
			"prodprice" => GetLang('Price'),
			"prodcostprice" => GetLang('CostPrice'),
			"prodsaleprice" => GetLang('SalePrice'),
			"prodretailprice" => GetLang('RetailPrice'),
			"prodcurrentinv" => GetLang('CurrentStockLevel'),
			"prodistaxable" => GetLang('ProdIsTaxable'),
			"prodlowinv" => GetLang('LowStockLevel'),
			"prodwarranty" => GetLang('ProductWarranty'),
			"prodfixedshippingcost" => GetLang('FixedShippingCost'),
			"prodfreeshipping" => GetLang('FreeShipping'),
			"prodweight" => GetLang('ProductWeight'),
			"prodwidth" => GetLang('ProductWidth'),
			"prodheight" => GetLang('ProductHeight'),
			"proddepth" => GetLang('ProductDepth'),
			"prodpagetitle" => GetLang('PageTitle'),
			"prodsearchkeywords" => GetLang('SearchKeywords'),
			"prodmetakeywords" => GetLang('MetaKeywords'),
			"prodmetadesc" => GetLang('MetaDescription'),
			"prodimagefile" => "PRODUCT IMAGES",
			"prodinstallimagefile" => "INSTALL IMAGES",
			"prodinstallvideo" => "INSTALL VIDEO",
			"prodvideo" => "PRODUCT VIDEO",
			"prodfile" => GetLang('ProductFile'),
			"prodvendorprefix" => "VENDORPREFIX",
			"proddescfeature" => "FEATURE POINTS",
			"prodmfg" => GetLang('prodmfg'),
			"jobberprice" => GetLang('jobberprice'),
			"mapprice" => GetLang('mapprice'),
		   	"alternativecategory" => GetLang('alternativecategory'),
			"complementaryitems" => 'COMPLEMENTARY ITEMS',
			"complementaryupcharge" => 'COMPLEMENTARY UPCHARGE',
            "comp_type" => 'COMPLEMENTARY SELECTION TYPE',
			"ourcost" => 'Our Cost',
            "package_length" => 'Package Length',
			"package_height" => 'Package Height',
			"package_weight" => 'Package Weight',
			"package_width" => 'Package Width',
			"product_series" => 'Series',
            "future_retail_price" => 'Future Retail Price',
			"future_jobber_price" => 'Future Jobber Price',
			"prod_instruction" => 'INSTRUCTION',
			"instruction_file" => 'Instruction File',
            "prod_article" => 'Product Article',
			"article_file" => 'Article File',
			"audio_clip" => 'AUDIO CLIP',
			"install_time" => 'INSTALL TIME',
			"skubarcode" => 'SKUBARCODE'
			);


			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() == 0 && gzte11(ISC_HUGEPRINT)) {
				$this->_ImportFields['prodvendorid'] = GetLang('Vendor');
			}

			parent::__construct();
	}

	/**
	 * Custom step 1 code specific to product importing. Calls the parent ImportStep1 funciton.
	 */
	protected function _ImportStep1($MsgDesc="", $MsgStatus="")
	{
		/*if($message = strtokenize($_REQUEST, '#')) {
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError("", $message, MSG_ERROR);
			exit;
			}*/

		if ($MsgDesc != "" && !isset($GLOBALS['Message'])) {
			$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
		}

		if(isset($_POST['AutoCategory']) || $_SERVER['REQUEST_METHOD'] != "POST") {
			$GLOBALS['AutoCategoryChecked'] = "checked=\"checked\"";
		}

		$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');

		$GLOBALS['CategoryOptions'] = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions(array(), "<option %s value='%d'>%s</option>", "selected=\"selected\"", "", false);
		if($GLOBALS['CategoryOptions'] == '') {
			$GLOBALS['ISC_LANG']['ImportProductsCategory'] = GetLang('ImportCreateCategory');
			$GLOBALS['HideCategorySelect'] = "none";
			$GLOBALS['HideCategoryTextbox'] = '';
		}
		else {
			$GLOBALS['HideCategoryTextbox'] = 'none';
		}

		$GLOBALS['UpdateExistDataOptions'] = '<input type="radio" name="OverrideOptionValue" id="OOV_1" value="APP_RECORD" disabled /><label for="OOV_1">Update application records</label><br /><input type="radio" name="OverrideOptionValue" id="OOV_2" value="OTHER_DETAIL" checked="checked" disabled/><label for="OOV_2">Update other details</label>';

		// Set up generic import options
		parent::_ImportStep1();
	}

	/**
	 * Custom step 2 code specific to product importing. Calls the parent ImportStep2 funciton.
	 */
	protected function _ImportStep2($MsgDesc="", $MsgStatus="")
	{
		// Haven't been to this step before, need to parse CSV file
		if(isset($_POST) && !empty($_POST)) {
			if(!isset($this->ImportSession['CategoryId']) && !isset($this->ImportSession['AutoCategory'])) {
				if(isset($_POST['AutoCategory'])) {
					$this->ImportSession['AutoCategory'] = 1;
					$this->_RequiredFields[] = "category";
					$GLOBALS['CategoryRequired'] = 1;
				}
				else {
					if(!isset($_POST['CategoryId']) && !isset($_POST['CategoryName'])) {
						$this->_ImportStep1(GetLang('ImportInvalidCategory'), MSG_ERROR);
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						exit;
					}

					// Creating a new category
					else if(isset($_POST['CategoryName']) && $_POST['CategoryName'] != "") {
						// Pass on to category creation function
						$_POST['catname'] = $_POST['CategoryName'];
						$_POST['catdesc'] = '';
						$_POST['catpagetitle'] = '';
						$_POST['catmetakeywords'] = '';
						$_POST['catmetadesc'] = '';
						$_POST['catlayoutfile'] = '';
						$_POST['catsort'] = 0;
						$_POST['catparentid'] = 0;
						$GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');
						$error = $GLOBALS['ISC_CLASS_ADMIN_CATEGORY']->_CommitCategory(0);
						if($error) {
							$this->_ImportStep1($error, MSG_ERROR);
						}
						$_POST['CategoryId'] = $GLOBALS['ISC_CLASS_DB']->LastId();
					}
					// Missing selection
					else if(empty($_POST['CategoryId'])) {
						$this->_ImportStep1(GetLang('ImportInvalidCategory'), MSG_ERROR);
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						exit;
					}
					$this->ImportSession['CategoryId'] = $_POST['CategoryId'];
				}

			}



			if(isset($_POST['PreCategory'])) {
				$this->ImportSession['PreCategory'] = $_POST['pre_category'];
				// $GLOBALS['PreCategorySET'] = $_POST['pre_category'];

			}



			if (isset($_POST['OverrideDuplicates'])) {
				$this->ImportSession['OverrideOptionValue'] = $_POST['OverrideOptionValue'];
			}

		}

		// Set up generic import options

		if ($MsgDesc != "") {
			$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
		}

		parent::_ImportStep2();
	}

	/**
	 * Imports an actual product record in to the database.
	 *
	 * @param array Array of record data
	 */

	function writetheheader($vendorId,$loggedid)
	{

		if ($_SESSION['rejecteddata'] != "")
		{
			$rejecteddata = $_SESSION['rejecteddata']."Reason for rejection";
			$rejecteddata.= "\n";
			$_SESSION['rejecteddata'] = "";

			$filename = $_SESSION['t']."_".$vendorId."_".$loggedid.".csv";
			$filename = "rejected_data/".$filename;

			if (!$handle = fopen($filename, 'a')) {
				// echo "Cannot open file ($filename)";

			}

			if (fwrite($handle, $rejecteddata) === FALSE) {
				//echo "Cannot write to file ($filename)";

			}
			fclose($handle);
		}
		return;
	}

	function writetherejected($data,$msg,$vendorId,$loggedid)
	{
		$this->writetheheader($vendorId,$loggedid);
		$this->ImportSession['Results']['Failures'][] = implode(",", $data)." ".$msg;
		 
		$rejecteddata = implode(";#@::;", $data); // i am just using a rare string to implode it.
		$rejecteddata = str_replace(",", "-", $rejecteddata);
		$rejecteddata = str_replace(";#@::;", ",", $rejecteddata);
		$rejecteddata = nl2br($rejecteddata);
		$rejecteddata = str_ireplace("<br>", " ", $rejecteddata);
		$rejecteddata = $rejecteddata.",".$msg;
		$rejecteddata.= "\n";

		$filename = $_SESSION['t']."_".$vendorId."_".$loggedid.".csv";
		$filename = "rejected_data/".$filename;

		if (!$handle = fopen($filename, 'a')) {
			// echo "Cannot open file ($filename)";

		}

		if (fwrite($handle, $rejecteddata) === FALSE) {
			//echo "Cannot write to file ($filename)";

		}
		fclose($handle);

		return;
	}


	protected function _ImportRecord($record)
	{
		$loggedid = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUserId();


		static $categoryCache;

		if(!is_array($categoryCache)) {
			$categoryCache = array();
		}


		if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
			$vendorId = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
		}
		else {
			$vendorId = (int)@$record['prodvendorid'];
		}

		if(isset($record['comp_type']) and $record['comp_type']!=='' and !preg_match("/^\s*[01]\s*$/",$record['comp_type'])) {
			$this->writetherejected($record['original_record'], ' <-- Wrong data for COMPLEMENTARY SELECTION TYPE', $vendorId, $loggedid);
			return;
		}


		// we need vendor id from vendor name
		if (!is_int($record['prodvendorid']))
		{
			$query = "SELECT vendorid FROM [|PREFIX|]vendors WHERE vendorname='".$record['prodvendorid']."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$vendorId = $row['vendorid'];
			}
		}

		/*
		 $record['category1'] = str_replace("/", "SlaSH", $record['category1']);
		 $record['category2'] = str_replace("/", "SlaSH", $record['category2']);
		 $record['category3'] = str_replace("/", "SlaSH", $record['category3']);
		 */

		// Automatically fetching categories based on CSV field
		if(isset($this->ImportSession['AutoCategory'])) {
			// We specified more than one level for the category back in the configuration
			if(isset($record['category1'])) {
				$record['category'] = array($record['category1']);
				if(isset($record['category2']) && $record['category2'] != '') {
					$record['category'][] = $record['category2'];
				}
				//if(isset($record['category3']) && $record['category3'] != '') {
				//$record['category'][] = $record['category3'];
				//}
				$record['category'] = implode("/#/", $record['category']);
			}
			

			if(!$record['category']) {
				$this->ImportSession['Results']['Failures'][] = implode(",", $record['original_record'])." ".GetLang('ImportProductsMissingCategory');
				return;
			}

			// Import the categories for the products too
			$categoryList = explode(";", $record['category']);

			$cats = array();
			foreach($categoryList as $importCategory) {
				$categories = explode("/#/", $importCategory);

				$parentId = 0;
				$lastCategoryId = 0;

				if(!isset($categoryCache[$importCategory])) {
					foreach($categories as $category) {
						$category = trim($category);
						if($category == '') {
							continue;
						}

						//$category = str_replace("SlaSH", "/", $category);

						$query = "SELECT categoryid, catparentlist FROM [|PREFIX|]categories WHERE LOWER(catname)='".$GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($category))."' AND catparentid='".$parentId."'";
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
						$existingCategory = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
						if(!$existingCategory['categoryid']) {


							// Create the category .But no need to create any category while import since all possiple categories are added to the db. blessen

							$lastCategoryId = -2;

						}
						else {
							$lastCategoryId = $existingCategory['categoryid'];

						}
						$parentId = $lastCategoryId;

					}
					if($lastCategoryId) {
						$categoryCache[$importCategory] = $lastCategoryId;
						$cats[] = $lastCategoryId;
					}
				}
				else {
					$cats[] = $categoryCache[$importCategory];
				}
			}
				
		}
		// Manually set a category
		else {
			$cats = array($this->ImportSession['CategoryId']);
		}

		$cat_condition = false;

		if (isset($this->ImportSession['PreCategory']))
		{

			$cat_condition = (($cats[0] == -2) || (!in_array($cats[0], $this->ImportSession['PreCategory'])))?true:false;
			// checking for  invalid category and selected category
		}

		else
		{

			$cat_condition = ($cats[0] == -2 )?true:false;

		}

		if($cat_condition) {

			$this->writetherejected($record['original_record'],'Un defined Category',$vendorId,$loggedid);
			return;
		}



		// Does the brand already exist?
		$brandId = 0;
		if(isset($record['brandname']) && $record['brandname'] != '') {
			$query = sprintf("select brandid from [|PREFIX|]brands where lower(brandname)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($record['brandname'])));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$brandId = $row['brandid'];
			}
			// no need to Create new brand as per the new rule 16_11_2009
			else {
				$this->writetherejected($record['original_record'],'Brand Does not exist',$vendorId,$loggedid);
				return;
			}
		}


		//reject if vendor prefix is not present
		$prodvendorprefix = strtolower($record['prodvendorprefix']);

		$prodmake = $record['prodmake'];
		$prodsubmodel = $record['prodsubmodel'];
		$prodmodel = $record['prodmodel'];
		$prodstartyear = $record['prodstartyear'];
		$prodendyear = $record['prodendyear'];

		//$catuniversal = $existingCategory['catuniversal'];

		$query4 = "SELECT catuniversal , catcombine, catparentid, Productname  FROM [|PREFIX|]categories WHERE categoryid = '".$cats[0]."' ";
		$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
		$eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
		$catuniversal = $eng_row['catuniversal'];
		$catparentid  = $eng_row['catparentid'];
		$Productname_elements  = explode(",",$eng_row['Productname']);
        
        // get associated qualifies to this category to filter prodname
        $query = " SELECT mn.qid, mn.column_name
                        FROM [|PREFIX|]qualifier_associations qa
                        INNER JOIN [|PREFIX|]qualifier_names mn ON qa.qualifierid = mn.qid 
                        WHERE (mn.column_name LIKE 'PQ%' OR mn.column_name LIKE 'VQ%') AND qa.categoryid='".$cats[0]."' ORDER BY column_name"; 
        $result = $GLOBALS['ISC_CLASS_DB']->Query($query); 
        $category_qualifiers = array();
        while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {   
            $category_qualifiers[$row['column_name']]   =  $row;
        }

		if (in_array(0, $Productname_elements) and in_array(1, $Productname_elements))
		$catcombine = $eng_row['catcombine'];
		else
		$catcombine = "";

		// no need to store products under root category if any subcategory exist.
		if ($catparentid == 0)
		{

			//check for subcategories
			$query4 = "SELECT count(catparentid) as subcnt  FROM [|PREFIX|]categories WHERE catparentid = '".$cats[0]."' ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
			$eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
			$subcnt = $eng_row['subcnt'];
			if ($subcnt > 0)
			{
				//if any subcategory exist, Reject it.
				$this->writetherejected($record['original_record'],'Products cannot store directly to the root category ',$vendorId,$loggedid);
				return;

			}


		}



		//Reject data if invalid Year make Model and submodel except for universal categories.
		if ($catuniversal == 0)
		{
			// no need Universal Products with non-universal category
			/* -- commented below code as requirements have changed for universal products --
			 if (strtolower($prodstartyear) == "all" || strtolower($prodendyear) == "all" || strtolower($prodmodel) == "all" || strtolower($prodmake) == "non-spec vehicle"  )
			 {

				$this->writetherejected($record['original_record'],'Universal Products with non-universal category',$vendorId,$loggedid);
				return;
				}
				*/

			if (strtolower($prodstartyear) != "all" || strtolower($prodendyear) != "all" || strtolower($prodmodel) != "all" || strtolower($prodmake) != "non-spec vehicle"  )
			{
				//2011-5-10 alandy stop ymm checking.
				// MMY validation
				/*
				 $query2 = "SELECT id FROM [|PREFIX|]product_mmy  WHERE (year  = '".$prodstartyear."' or year  = '".$prodendyear."' ) and model   = '".$prodmodel."' and submodel = '".$prodsubmodel."' and make   = '".$prodmake."' limit 0,1 ";
				 $result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
				 if ($GLOBALS['ISC_CLASS_DB']->CountResult($result2) == 0)
				 {

					$this->writetherejected($record['original_record'],'Invalid MMY and Submodel List',$vendorId,$loggedid);

					return;
					}
					else
					{
					$row_ymm_id = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2);
					$ymm_id = $row_ymm_id['id'];
					}
					*/
				//2011-5-10 alandy modify.if doesn't exist MMY then add it to db.
				$prodstartyear=(int)$prodstartyear;
				$prodendyear=(int)$prodendyear;

				if($prodstartyear>1949 && $prodendyear>1949 && $prodstartyear<2051 && $prodendyear<2051  && ($prodendyear-$prodstartyear)>=0){
						
				 for($i=$prodstartyear;$i<=$prodendyear;$i++){
				 	 
				 	$query2 = "SELECT id FROM [|PREFIX|]product_mmy  WHERE year  = '".$i."' and model   = '".$prodmodel."' and submodel = '".$prodsubmodel."' and make   = '".$prodmake."' limit 0,1 ";
				 	$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
				 		
				 	if ($GLOBALS['ISC_CLASS_DB']->CountResult($result2) == 0){
				 		$sql="insert into [|PREFIX|]product_mmy(year,make,model,submodel) values('".$i."','".$prodmake."','".$prodmodel."','".$prodsubmodel."')";
				 		$GLOBALS['ISC_CLASS_DB']->Query("insert into [|PREFIX|]product_mmy(year,make,model,submodel) values('".$i."','".$prodmake."','".$prodmodel."','".$prodsubmodel."')");
				 	}else{
				 		$row_ymm_id = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2);
				 		$ymm_id = $row_ymm_id['id'];
				 	}
				 }
				 	
				}else{
					$this->writetherejected($record['original_record'],'Invalid prodstartyear or prodendyear ',$vendorId,$loggedid);

					return;
				}

			}
		}
		else if($catuniversal == 1)
		{
			if (strtolower($prodstartyear) != "all" || strtolower($prodendyear) != "all" || strtolower($prodmodel) != "all" || strtolower($prodmake) != "non-spec vehicle"  )
			{

				$this->writetherejected($record['original_record'],'non-universal products will not be imported into universal subcategory',$vendorId,$loggedid);
				return;
			}
		}

		$productId = 0;
		$hasThumb = false;
		$productFiles = array();
		$productImages = array();
		$existing = null;
		$generalize_bedvalue = "";
		$generalize_cabvalue = "";

		// genarating prod name added by blessen

		$subcat  = strtolower($record['category2']);
		$cat  = strtolower($record['category1']);
		$partnumber = $record['prodcode'];

		$product_series = strtolower($record['product_series']);
		$brand = $record['brandname'];


		// No need to enter all the PQ/VQ to the import variation table , only category associated
		$selected = array_values(array_intersect($_SESSION['assocvqpq'][$cats[0]] , $_SESSION['qualifiers']));
		//$selected = $_SESSION['assocvqpq'][$cats[0]];
		
		if (!isset($selected)) $selected = array();



		if (in_array('VQliter', $selected)  and  $catuniversal == 0 and $record['VQliter'] != "")
		{
			$query4 = "SELECT liter FROM [|PREFIX|]engine_table WHERE ymm_id = '".$ymm_id."'  limit 0,1 ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
			$eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
			$liter = $eng_row['liter'];
		}

		if (in_array('VQenginetype', $selected)  and  $catuniversal == 0 and $record['VQenginetype'] != "")
		{
			$query4 = "SELECT engtype FROM [|PREFIX|]engine_table WHERE ymm_id = '".$ymm_id."'  limit 0,1 ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
			$eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
			$engtype = $eng_row['engtype'];
		}


		//blocked by NI_Mike 20101027 for the feature Cap sise duplicate issue,
		// cancel the translation steps

		/*
		 // this is for cabsize traslation
		 if (in_array('VQcabsize', $selected) and $record['VQcabsize'] != "" )
		 {

		 $cabsize_pieces = preg_split("/[;,]/", $record['VQcabsize']);
		 $end = end($cabsize_pieces);
		 if(empty($end)) array_pop($cabsize_pieces);

		 foreach ($cabsize_pieces as $key => $value)
		 {
		 $query4 = "SELECT id,generalize_value FROM [|PREFIX|]cabsize_translation WHERE prodstartyear = '".$prodstartyear."' and prodendyear = '".$prodendyear."'  and prodmake  = '".$prodmake."' and prodmodel  = '".$prodmodel."' and irregular_value = '".$value."'  limit 0,1 ";
		 $result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
		 $cab_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
		 $generalize_cabvalue.= $cab_row['generalize_value'].";";

		 }

		 $generalize_cabvalue = trim($generalize_cabvalue,";");


		 }*/
		// this is for bedsize traslation
		//2010-11-15 Ronnie modify ,block
		/*if (in_array('VQbedsize', $selected)  and $record['VQbedsize'] != "")
		 {

		 $bedsize_pieces = preg_split("/[;,]/", $record['VQbedsize']);
		 $end = end($bedsize_pieces);
		 if(empty($end)) array_pop($bedsize_pieces);

		 foreach ($bedsize_pieces as $key => $value)
		 {
			$query3 = "SELECT id,generalize_value FROM [|PREFIX|]bedsize_translation WHERE irregular_value = '".$value."'  limit 0,1 ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query3);
			$bed_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
			$generalize_bedvalue.= $bed_row['generalize_value'].";";

			}
			$generalize_bedvalue = trim($generalize_bedvalue,";");
			// and checking for repeated values is not done

			}
			*/

		/*
		 if (in_array('VQcabsize', $selected) and $generalize_cabvalue == ""  and $catuniversal == 0 and  $record['VQcabsize'] != "")
		 {
		 $query4 = "SELECT cabsize  FROM [|PREFIX|]cabbed_table  WHERE ymm_id = '".$ymm_id."'  limit 0,1 ";
		 $result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
		 $eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
		 if ($eng_row['cabsize'] != "") $generalize_cabvalue = $eng_row['cabsize'];
		 }
		 */

		//2010-11-15 Ronnie modify ,block
		/*if ($generalize_bedvalue == "" and in_array('VQbedsize', $selected)   and $catuniversal == 0 and $record['VQbedsize'] != "")
		 {

		 $query4 = "SELECT bedsize  FROM [|PREFIX|]cabbed_table  WHERE ymm_id = '".$ymm_id."'  limit 0,1 ";
		 $result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
		 $eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
		 if ($eng_row['bedsize'] != "") $generalize_bedvalue = $eng_row['bedsize'];

		 }
		 */
		//	$query4 = "SELECT bedsize  FROM [|PREFIX|]cabbed_table  WHERE ymm_id = '6546'  limit 0,1 ";
		//$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
		//$eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
		//$generalize_bedvalue = $eng_row['bedsize'];
		// $Productname_elements
		// $pnamearray = array('Category Name', 'Sub Category Name', 'Brand Name','Series Name', 'Part Number', 'Product Code','Product color', 'Product Material', 'Product Style');
		//key = 0,1,2,3,4,5,6,7,8



		// this is for cat-subcat combined name, joing category to subcategory and removed dupliacates
		if ($catcombine == "" and in_array(0, $Productname_elements) and in_array(1, $Productname_elements))
		{

			//$sc = str_word_count($subcat, 1);
			$sc = explode(" ", $subcat);
			foreach ($sc as $value) {
				$cat = str_ireplace($value, " ", $cat );
					
			}

			$c = str_word_count($cat, 1,"1234567890'-_");
			foreach ($c as $value) {
				$subcat = str_ireplace($value."s", " ", $subcat );
				$subcat = str_ireplace($value."es", " ", $subcat );
			}

			if (trim($cat) == "s" || trim($cat) == "S") $cat = "";

			$catcombine = $subcat." ".$cat;
		}

		if (in_array(0, $Productname_elements) and !in_array(1, $Productname_elements)) {
			$catcombine = $cat;
		}
		else if (!in_array(0, $Productname_elements) and in_array(1, $Productname_elements)){
			$catcombine = $subcat;
		}

		if (in_array(3, $Productname_elements) and in_array(0, $Productname_elements) and in_array(1, $Productname_elements))
		{
			$product_series = str_word_count($product_series, 1,"1234567890'-_");
			$subcatcomp = str_word_count($catcombine, 1,"1234567890'-_");
			$product_series = array_diff($product_series, $subcatcomp);
			$product_series = implode(" ", $product_series);
		}
		else
		if (!in_array(3, $Productname_elements))
		$product_series = "";


		// process 3
		//alandy_2012-1-17 modify.fix product name don't have pq value.
		/*
		if (isset($record['PQcolor']) and in_array(6, $Productname_elements) ) $prodcolor =  rtrim(strtolower($record['PQcolor']),";");
		else
		$prodcolor = "";

		if (isset($record['PQmaterial']) and in_array(7, $Productname_elements)) $prodmaterial =  rtrim(strtolower($record['PQmaterial']),";");
		else
		$prodmaterial = "";

		if (isset($record['PQstyle']) and in_array(8, $Productname_elements)) $prodstyle =  rtrim(strtolower($record['PQstyle']),";");
		else
		$prodstyle = "";
		*/
	
		if (isset($record['PQcolor']) && !empty($record['PQcolor']) && in_array(6, $Productname_elements) && isset($category_qualifiers['PQcolor']) ){
			$prodcolor =  rtrim(strtolower($record['PQcolor']),";");
		}
		else{
			$prodcolor = "";
		}

		if (isset($record['PQmaterial']) && !empty($record['PQmaterial']) &&  in_array(7, $Productname_elements) && isset($category_qualifiers['PQmaterial'])){
			$prodmaterial =  rtrim(strtolower($record['PQmaterial']),";");
		}
		else{
			$prodmaterial = "";
		}
		

		if (isset($record['PQstyle']) && in_array(8, $Productname_elements) && isset($category_qualifiers['PQstyle'])){
			$prodstyle =  rtrim(strtolower($record['PQstyle']),";");
		}
		else{
			$prodstyle = "";
		}
		



		if (in_array(4, $Productname_elements) and in_array(5, $Productname_elements)) $PartNumberTXT =  " Part Number ";
		else
		$PartNumberTXT =  " ";

		if (!in_array(5, $Productname_elements)) $partnumber =  "";
		if (!in_array(2, $Productname_elements)) $brand =  "";

		//joing product name
		$prodname = $catcombine." ".$brand." ".$product_series.$PartNumberTXT.$partnumber." ".$prodcolor." ".$prodmaterial." ".$prodstyle;

		$prodname = str_replace("/", " ", $prodname);
		$prodname = preg_replace('/(\s+)/',' ',$prodname);
		$newprodname = trim($prodname);
		$newprodname = ucwords($newprodname);

		array_push($selected, "prodmake" , "prodmodel","prodsubmodel","prodstartyear","prodendyear");


		if(!isset($_SESSION['OverRidedInThisImport']))
		{
			$_SESSION['OverRidedInThisImport'] = array();
			//++$this->ImportSession['Results']['SuccessCount'];
		}




		// Is there an existing product with the same name?
		$query = sprintf("SELECT * FROM [|PREFIX|]products WHERE prodcode='%s' and LOWER(prodvendorprefix) = '".$prodvendorprefix."'  ", $GLOBALS['ISC_CLASS_DB']->Quote($record['prodcode']));
		$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
		if($existing = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
			// NI-20101104-Start
			// Issue : Enhancement for importing application records

			/* Updating product name as per client request - 19-8-10 - vikas */
			if( isset($record['prodname']) && $record['prodname'] != "" )
			{
				$prodnameexistqry = "select prodname from [|PREFIX|]products where prodname = '".$GLOBALS['ISC_CLASS_DB']->Quote($record['prodname'])."' and productid != ".$existing['productid'];
				$prodnameexistresult = $GLOBALS['ISC_CLASS_DB']->Query($prodnameexistqry);

				if ($GLOBALS['ISC_CLASS_DB']->CountResult($prodnameexistresult) > 0)
				{
					$this->writetherejected($record['original_record'],'Product Name already exist',$vendorId,$loggedid);
					return;
				}
				else
				{
					$newprodname = ucwords($record['prodname']);
				}
			}else{
				//alandy 2011-7-28.if not set prodname from CSV,THEN use the orignal prodname.otherwise use newprodname.
				
				if(!empty($existing['prodname'])){
					$newprodname=$existing['prodname'];
				}
			}
			
			/* -- ends-- */

			//		// year  range mamagement start
			//
			//		//add a section of code to manage this type of year range problem. As per the  given example,  delete the first row and  the second row completely to the data base.
			//		$query_year = "SELECT id FROM [|PREFIX|]import_variations  WHERE prodstartyear = '".$prodstartyear."' and prodendyear < '".$prodendyear."' and prodmodel  = '".$prodmodel."' and prodsubmodel  = '".$prodsubmodel."' and prodmake  = '".$prodmake."' and prodcode  = '".$record['prodcode']."' limit 0,1 ";
			//		$result_year = $GLOBALS['ISC_CLASS_DB']->Query($query_year);
			//		if ($GLOBALS['ISC_CLASS_DB']->CountResult($result_year) > 0)
			//			{
			//				$result_year_row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result_year);
			//				$result_year_row_id = $result_year_row['id'];
			//				$GLOBALS['ISC_CLASS_DB']->Query("delete from [|PREFIX|]import_variations WHERE id='".(int)$result_year_row_id."'");
			//			}
			//
			//
			//		// year  range mamagement end

			//		$query2 = "SELECT id FROM [|PREFIX|]import_variations  WHERE prodstartyear = '".$prodstartyear."' and prodendyear = '".$prodendyear."' and prodmodel  = '".$prodmodel."' and prodsubmodel  = '".$prodsubmodel."' and prodmake  = '".$prodmake."' and prodcode  = '".$record['prodcode']."' limit 0,1 ";
			$query2 = "SELECT id FROM [|PREFIX|]import_variations  WHERE productid = '".$existing['productid']."' limit 0,1 ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);

			//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid']);


			if(isset($this->ImportSession['OverrideDuplicates']) && $this->ImportSession['OverrideDuplicates'] == 1
			&& isset($this->ImportSession['OverrideOptionValue']) && $this->ImportSession['OverrideOptionValue'] == 'APP_RECORD') {
					
				if(!$_SESSION['OverRidedInThisImport'][$existing['productid']] && $GLOBALS['ISC_CLASS_DB']->CountResult($result2) != 0){

					//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  first time in");
					//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  delete all");
					mysql_query("DELETE FROM isc_import_variations  WHERE productid = ".$existing['productid'].";");
					mysql_query("DELETE FROM isc_qualifier_value  WHERE pid = ".$existing['productid'].";");
					mysql_query("DELETE FROM isc_application_data  WHERE productid = ".$existing['productid'].";");

				}
				$_SESSION['OverRidedInThisImport'][$existing['productid']] = 1;
			}



			if ($_SESSION['OverRidedInThisImport'][$existing['productid']])
			{
				//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  insert this record");
				$sqlinsert2 = "INSERT INTO `isc_import_variations` ( `productid`, `prodcode` , ";
				$values = ") VALUES (".$existing['productid'].", '".$record['prodcode']."' ,";
				for($i = 0; $i < count($selected); $i++) {


					$fieldname = $selected[$i];
					$thevalue = rtrim($record[$fieldname],";");

					$sqlinsert2.= "`".$fieldname."` ,";
					$values.= "'".$thevalue."',";

					// VQenginetype validation checking
					if ($fieldname == "VQenginetype"  and  $thevalue != "")	$thevalue = $engtype;

					// VQliter validation checking
					if ($fieldname == "VQliter"  and  $thevalue != "")	$thevalue = $liter;


					// this table is only for to make search fast

					if ($thevalue != "")
					{
						$sql = "INSERT INTO `isc_qualifier_value` (`pid`, `qid`, `q_value` , `row_no`) VALUES ('".$existing['productid']."', '".$_SESSION['qualifiers_name'][$fieldname]."', '".$thevalue."' ,  '".$_SESSION['row_no']."')";
						mysql_query($sql);
							
					}
					// only for search fast end




				}
				$_SESSION['row_no']++;

					

				$sqlinsert2.= "`bedsize_generalname` , `cabsize_generalname` ";
				$values.= "'".$generalize_bedvalue."', '".$generalize_cabvalue."'";

				$joinedsql = $sqlinsert2.$values." ) ";
				mysql_query($joinedsql);

				//complementary items  ;
				$record['complementaryitems'] = str_replace('�','"',$record['complementaryitems']);
				$record['complementaryitems'] = str_replace('�','"',$record['complementaryitems']);
				$comData = array(
						"complementaryitems" => $record['complementaryitems'],
						"variationid" => mysql_insert_id(),
						"productid" => $existing['productid']
				);
				$GLOBALS['ISC_CLASS_DB']->InsertQuery("application_data", $comData);

			}

			// Overriding existing products, set the product id
			if(isset($this->ImportSession['OverrideDuplicates']) && $this->ImportSession['OverrideDuplicates'] == 1
			&& isset($this->ImportSession['OverrideOptionValue']) && $this->ImportSession['OverrideOptionValue'] == 'OTHER_DETAIL') {
				//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  update other");
				$productId = $existing['productid'];
				//$cats = null;  // blessen
				//$cats = "";   let the category change in re-import blessen 22-10 as per client req.

				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() != $existing['prodvendorid']) {
					$this->ImportSession['Results']['Failures'][] = implode(",", $record)." ".GetLang('ImportProductInvalidVendor');
					return;
				}

				$this->ImportSession['Results']['Updates'][] = $record['prodcode'];

				$ShoudOnlyUpdateOtherDetail = true;

			}
			else {
				//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  do not update other");
				//$this->ImportSession['Results']['Duplicates'][] = $record['prodcode'];
				
				//alandy 2011-7-28 modify.
				
				$this->ImportSession['Results']['Duplicates'][] = $record['prodcode']." ------>  Product Name already exist!";
				++$this->ImportSession['Results']['Imported'];

				return;
			}
			// NI-20101104-End
			// Issue : Enhancement for importing application records


		}
		else // for new products
		{
			/* Updating product name as per client request - 19-8-10 - vikas */
			
			if( isset($record['prodname']) && $record['prodname'] != "" )
			{
				$prodnameexistqry = "select prodname from [|PREFIX|]products where prodname = '".$GLOBALS['ISC_CLASS_DB']->Quote($record['prodname'])."' ";
				$prodnameexistresult = $GLOBALS['ISC_CLASS_DB']->Query($prodnameexistqry);

				if ($GLOBALS['ISC_CLASS_DB']->CountResult($prodnameexistresult) > 0)
				{
					$this->writetherejected($record,'Product Name already exist',$vendorId,$loggedid);
					return;
				}
				else
				{
					$newprodname = ucwords($record['prodname']);
				}
			}
			
			/* -- ends-- */
		}



		// Do we have a product file? We need to deal with it now damn it!
		if(isset($record['prodfile']) && $record['prodfile'] != '') {
			// Is this a remote file?
			$downloadDirectory = ISC_BASE_PATH."/".GetConfig('DownloadDirectory');
			if(isc_substr(isc_strtolower($record['prodfile']), 0, 7) == "http://") {
				// Need to fetch the remote file
				$file = PostToRemoteFileAndGetResponse($record['prodfile']);
				if($file) {
					// Place it in our downloads directory
					$randomDir = strtolower(chr(rand(65, 90)));
					if(!is_dir($downloadDirectory.$randomDir)) {
						if(!@mkdir($downloadDirectory."/".$randomDir, 0777)) {
							$randomDir = '';
						}
					}

					// Generate a random filename
					$fileName = $randomDir . "/" . GenRandFileName(basename($record['prodfile']));
					if(!@file_put_contents($downloadDirectory."/".$fileName, $file)) {
						$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductFileUnableToMove');
					}
					else {
						$productFiles[] = array(
							"prodhash" => "",
							"downfile" => $fileName,
							"downdateadded" => time(),
							"downmaxdownloads" => 0,
							"downexpiresafter" => 0,
							"downfilesize" => filesize($downloadDirectory."/".$fileName),
							"downname" => basename($record['prodfile']),
							"downdescription" => ""
							);
					}
				}
				else {
					$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductFileDoesntExist');
				}
			}
			// Treating the file as a local file, in the product_fules/import directory
			else {
				// This file exists, can be imported
				if(file_exists($downloadDirectory."/import/".$record['prodfile'])) {

					// Move it to our images directory
					$randomDir = strtolower(chr(rand(65, 90)));
					if(!is_dir("../".$downloadDirectory."/".$randomDir)) {
						if(!@mkdir($downloadDirectory."/".$randomDir, 0777)) {
							$randomDir = '';
						}
					}

					// Generate a random filename
					$fileName = $randomDir . "/" . GenRandFileName($record['prodfile']);
					if(!@copy($downloadDirectory."/import/".$record['prodfile'], $downloadDirectory."/".$fileName)) {
						$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductFileUnableToMove');
					}
					else {
						$productFiles[] = array(
							"prodhash" => "",
							"downfile" => $fileName,
							"downdateadded" => time(),
							"downmaxdownloads" => 0,
							"downexpiresafter" => 0,
							"downfilesize" => filesize($downloadDirectory."/".$fileName),
							"downname" => basename($record['prodfile']),
							"downdescription" => ""
							);
					}
				}
				else {
					$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductFileDoesntExist');
				}
			}
		}

		// Do we have an image? We need to deal with it before we do anything else
		$productImages = array();
		if(isset($record['prodimagefile']) && $record['prodimagefile'] != '') {
			// Is this a remote file?

			$imageDirectory = ISC_BASE_PATH."/".GetConfig('ImageDirectory');
			if(isc_substr(isc_strtolower($record['prodimagefile']), 0, 7) == "http://") {
				// Need to fetch the remote file

				$image_pieces = preg_split("/[;,]/", $record['prodimagefile']);
				$end = end($image_pieces);
				if(empty($end)) array_pop($image_pieces);

				foreach ($image_pieces as $key => $value)
				{
					$temp_key = $key+1;
					$image = PostToRemoteFileAndGetResponse($value);
					if($image) {
						// Place it in our images directory
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir($imageDirectory."/".$randomDir)) {
							if(!@mkdir($imageDirectory."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}

						// Generate a random filename
						$fileName = $randomDir . "/" . GenRandFileName(basename($value));
						if(!@file_put_contents($imageDirectory."/".$fileName, $image)) {
							$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageUnableToMove');
						}
						// Check to see if it is an image
						else if (!is_array(@getimagesize($imageDirectory."/".$fileName))) {
							@unlink($imageDirectory."/".$fileName);
							$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageInvalidFile');
						}
						else {

							$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName,"large");
							$productImages[] = array(
							"imagefile" => $thumbName,
							"imageisthumb" => 0,
							"imagesort" =>  $temp_key
							);




							if($hasThumb == false) {
									

								if ($key == 0)
								{

									$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName);
									if($thumbName) {
										$productImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" => 0
										);
									}
									else {
										$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageCorrupt');
									}


									$tinyName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName, "tiny");
									if($tinyName) {
										$productImages[] = array(
									"imagefile" => $tinyName,
									"imageisthumb" => 2,
									"imagesort" => 0
										);
									}
									else {
										$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageCorrupt');
									}
								}
								$mediumName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName, "medium");
								if($mediumName) {
									$productImages[] = array(
									"imagefile" => $mediumName,
									"imageisthumb" => 3,
									"imagesort" => $temp_key
									);
								}
								else {
									$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageCorrupt');
								}

							}
						}
					}
					else {
						$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageDoesntExist');
					}


				}

			}
			// Treating the file as a local file, in the product_images/import directory
			else {
				// This file exists, can be imported

				$image_pieces = preg_split("/[;,]/", $record['prodimagefile']);
				$end = end($image_pieces);
				if(empty($end)) array_pop($image_pieces);

				foreach ($image_pieces as $key => $value)
				{
					$temp_key = $key+1;


					if(file_exists($imageDirectory."/import/".$value)) {

						// Move it to our images directory
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir($imageDirectory."/".$randomDir)) {
							if(!@mkdir($imageDirectory."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}

						// Generate a random filename
						$baseFileName = basename($value);
						if($baseFileName != $value) {
							$localDirectory = dirname($value)."/";
						}
						else {
							$localDirectory = '';
						}
						$fileName = $randomDir . "/" . GenRandFileName($baseFileName);
						if(!@copy($imageDirectory."/import/".$value, $imageDirectory."/".$fileName)) {
							$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageUnableToMove');
						}
						else {
							$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName,"large");

							$productImages[] = array(
							"imagefile" => $thumbName,
							"imageisthumb" => 0,
							"imagesort" => $temp_key
							);

							// Does a thumbnail file exist?
							$thumbFile = "thumb_".$baseFileName;
							if ($key == 0)
							{
								if(file_exists($imageDirectory."/import/".$localDirectory.$thumbFile)) {
									$thumbName = $randomDir . "/" . GenRandFileName($thumbFile);
									if(@copy($imageDirectory."/import/".$localDirectory.$thumbFile, $imageDirectory."/".$thumbName)) {
										$productImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" =>  0
										);
									}
								}
								// Otherwise, generate the thumb
								else {


									$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName);
									if($thumbName) {
										$productImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" => 0
										);
									}


									// Still need to generate "tiny" thumbnail
									$tinyName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName, "tiny");
									if($tinyName) {
										$productImages[] = array(
								"imagefile" => $tinyName,
								"imageisthumb" => 2,
								"imagesort" => 0
										);
									}
								}
							}
							$mediumName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName, "medium");
							if($mediumName) {
								$productImages[] = array(
								"imagefile" => $mediumName,
								"imageisthumb" => 3,
								"imagesort" => $temp_key
								);
							}

						}
					}
					else {
						$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageDoesntExist');
					}

				}

			}
		}

		// Do we have an install image? We need to deal with it after product images added by blessen
		$productInstallImages = array();
		if(isset($record['prodinstallimagefile']) && $record['prodinstallimagefile'] != '') {
			// Is this a remote file?

			$InstallDirectory = ISC_BASE_PATH."/install_images";
			if(isc_substr(isc_strtolower($record['prodinstallimagefile']), 0, 7) == "http://") {
				// Need to fetch the remote file

				$image_pieces = preg_split("/[;,]/", $record['prodinstallimagefile']);
				$end = end($image_pieces);
				if(empty($end)) array_pop($image_pieces);

				foreach ($image_pieces as $key => $value)
				{
					$temp_key = $key+1;
					$image = PostToRemoteFileAndGetResponse($value);
					if($image) {
						// Place it in our images directory
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir($InstallDirectory."/".$randomDir)) {
							if(!@mkdir($InstallDirectory."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}

						// Generate a random filename
						$fileName = $randomDir . "/" . GenRandFileName(basename($value));
						if(!@file_put_contents($InstallDirectory."/".$fileName, $image)) {
							$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageUnableToMove');
						}
						// Check to see if it is an image
						else if (!is_array(@getimagesize($InstallDirectory."/".$fileName))) {
							@unlink($InstallDirectory."/".$fileName);
							$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageInvalidFile');
						}
						else {

							$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName,"large");
							$productInstallImages[] = array(
							"imagefile" => $thumbName,
							"imageisthumb" => 0,
							"imagesort" =>  $temp_key
							);




							if($hasThumb == false) {
									

								if ($key == 0)
								{

									$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName);
									if($thumbName) {
										$productInstallImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" => 0
										);
									}
									else {
										$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageCorrupt');
									}


									$tinyName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName, "tiny");
									if($tinyName) {
										$productInstallImages[] = array(
									"imagefile" => $tinyName,
									"imageisthumb" => 2,
									"imagesort" => 0
										);
									}
									else {
										$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageCorrupt');
									}
								}
								$mediumName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName, "medium");
								if($mediumName) {
									$productInstallImages[] = array(
									"imagefile" => $mediumName,
									"imageisthumb" => 3,
									"imagesort" => $temp_key
									);
								}
								else {
									$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageCorrupt');
								}

							}
						}
					}
					else {
						$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageDoesntExist');
					}


				}




			}
			// Treating the file as a local file, in the product_images/import directory
			else {
				// This file exists, can be imported

				$image_pieces = preg_split("/[;,]/", $record['prodinstallimagefile']);
				$end = end($image_pieces);
				if(empty($end)) array_pop($image_pieces);

				foreach ($image_pieces as $key => $value)
				{
					$temp_key = $key+1;


					if(file_exists($InstallDirectory."/import/".$value)) {

						// Move it to our images directory
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir($InstallDirectory."/".$randomDir)) {
							if(!@mkdir($InstallDirectory."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}

						// Generate a random filename
						$baseFileName = basename($value);
						if($baseFileName != $value) {
							$localDirectory = dirname($value)."/";
						}
						else {
							$localDirectory = '';
						}
						$fileName = $randomDir . "/" . GenRandFileName($baseFileName);
						if(!@copy($InstallDirectory."/import/".$value, $InstallDirectory."/".$fileName)) {
							$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageUnableToMove');
						}
						else {
							$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName,"large");

							$productInstallImages[] = array(
							"imagefile" => $thumbName,
							"imageisthumb" => 0,
							"imagesort" => $temp_key
							);

							// Does a thumbnail file exist?
							$thumbFile = "thumb_".$baseFileName;
							if ($key == 0)
							{
								if(file_exists($InstallDirectory."/import/".$localDirectory.$thumbFile)) {
									$thumbName = $randomDir . "/" . GenRandFileName($thumbFile);
									if(@copy($InstallDirectory."/import/".$localDirectory.$thumbFile, $InstallDirectory."/".$thumbName)) {
										$productInstallImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" =>  0
										);
									}
								}
								// Otherwise, generate the thumb
								else {


									$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName);
									if($thumbName) {
										$productInstallImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" => 0
										);
									}


									// Still need to generate "tiny" thumbnail
									$tinyName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName, "tiny");
									if($tinyName) {
										$productInstallImages[] = array(
								"imagefile" => $tinyName,
								"imageisthumb" => 2,
								"imagesort" => 0
										);
									}
								}
							}
							$mediumName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName, "medium");
							if($mediumName) {
								$productInstallImages[] = array(
								"imagefile" => $mediumName,
								"imageisthumb" => 3,
								"imagesort" => $temp_key
								);
							}

						}
					}
					else {
						$this->ImportSession['Results']['Warnings'][] = $record['prodcode'].GetLang('ImportProductImageDoesntExist');
					}

				}




			}




		}


		// If this is an update then we have to merge in the existing information that is NOT in the CSV file
		if (is_array($existing)) {
			$record = $record + $existing;
		}

		// Apply any default data
		$defaults = array(
			'prodistaxable' => 1,
			'prodprice' => 0,
			'prodcostprice' => 0,
			'prodretailprice' => 0,
			'prodsaleprice' => 0,
			'prodsearchkeywords' => '',
			'prodsortorder' => 0,
			'prodvisible' => 1,
			'prodfeatured' => 0,
			'prodrelatedproducts' => '',
			'prodoptionsrequired' => 0,
			'prodfreeshipping' => 0,
			'prodlayoutfile' => '',
			'prodtags' => '',
			'prodmyobasset' => '',
			'prodmyobincome' => '',
			'prodmyobexpense' => '',
			'prodpeachtreegl' => '',
			'price_log' => '',
			'SKU_last_update_time' => '',
			'price_update_time' => '',
			'unilateralprice' => '',
			'testdata' => 'No',
			'prodalternates' => '',
			'skubarcode' => ''
	
			);


			$record += $defaults;



			// Does the series already exist? //blessen
			$seriesId = 0;
			if(isset($record['product_series']) && $record['product_series'] != '') {
				$query = sprintf("select seriesid from [|PREFIX|]brand_series where lower(seriesname)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($record['product_series'])));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$seriesId = $row['seriesid'];
				}
				// Create new series
				else {
					$newSeries = array(
						"brandid" => $brandId,
						"seriesname" => $record['product_series']
					);
					$seriesId = $GLOBALS['ISC_CLASS_DB']->InsertQuery("brand_series", $newSeries);
					$seriesId = $GLOBALS['ISC_CLASS_DB']->LastId();
				}
			}



			if(!isset($record['prodinvtrack'])) {
				$record['prodinvtrack'] = 0;
			}

			if (isset($record['prodfile']) && $record['prodfile'] != '') {
				$productType = 2;
			} else if (isset($existing['prodtype']) && isId($existing['prodtype'])) {
				$productType = (int)$existing['prodtype'];
			} else {
				$productType = 1;
			}

			if(isset($record['prodistaxable'])) {
				$record['prodistaxable'] = $this->StringToYesNoInt($record['prodistaxable']);
			}


			$record['proddesc']  = str_replace("�", "&reg;", $record['proddesc']);


			// This is our product
			$productData = array(
			//"prodname" => $GLOBALS['ISC_CLASS_DB']->Quote($newprodname),
			//wirror_20101029: comments for "Double quote escaped unnecessarily"
			"prodname" => $newprodname,
			"prodcode" => @$record['prodcode'],
			"proddesc" => @$record['proddesc'],
			"prodsearchkeywords" => @$record['prodsearchkeywords'],
			"prodtype" => $productType,
			"prodprice" => DefaultPriceFormat($record['prodprice']),
			"prodcostprice" => DefaultPriceFormat($record['prodcostprice']),
			"prodretailprice" => DefaultPriceFormat($record['prodretailprice']),
			"prodsaleprice" => DefaultPriceFormat($record['prodsaleprice']),
			"prodavailability" => @$record['prodavailability'],
			"prodsortorder" => $record['prodsortorder'],
			"prodvisible" => $record['prodvisible'],
			"prodfeatured" => $record['prodfeatured'],
			"prodrelatedproducts" => $record['prodrelatedproducts'],
			"prodinvtrack" => (int)@$record['prodinvtrack'],
			"prodcurrentinv" => (int)@$record['prodcurrentinv'],
			"prodlowinv" => (int)@$record['prodlowinv'],
			"prodoptionsrequired" => $record['prodoptionsrequired'],
			"prodwarranty" => @$record['prodwarranty'],
			"prodheight" => (float)@$record['prodheight'],
			"prodweight" => (float)@$record['prodweight'],
			"prodwidth" => (float)@$record['prodwidth'],
			"proddepth" => (float)@$record['proddepth'],
			"prodfreeshipping" => $record['prodfreeshipping'],
			"prodfixedshippingcost" => DefaultPriceFormat(@$record['prodfixedshippingcost']),
			"prodbrandid" => (int)$brandId,
			"prodcats" => $cats,
			"prodpagetitle" => @$record['prodpagetitle'],
			"prodmetakeywords" => @$record['prodmetakeywords'],
			"prodmetadesc" => @$record['prodmetadesc'],
			"prodlayoutfile" => $record['prodlayoutfile'],
			"prodistaxable" => $record['prodistaxable'],
			'prodvendorid' => $vendorId,
			'prodtags' => $record['prodtags'],
			"prodvendorprefix" => $record['prodvendorprefix'],
			"proddescfeature" => $record['proddescfeature'],
			"prodmfg" => $record['prodmfg'],
			"jobberprice" => $record['jobberprice'],
			"mapprice" => $record['mapprice'],
           	"alternativecategory" => $record['alternativecategory'],
			"complementaryupcharge" => $record['complementaryupcharge'],
			"ourcost" => $record['ourcost'],
            "package_length" => $record['package_length'],
			"package_height" => $record['package_height'],
			"package_weight" => $record['package_weight'],
			"package_width" => $record['package_width'],
			"brandseriesid" => $seriesId,
            "future_retail_price" => $record['future_retail_price'],
			"future_jobber_price" => $record['future_jobber_price'],
			"prod_instruction" => $record['prod_instruction'],
			"prod_article" => $record['prod_article'],
			"skubarcode" => $record['skubarcode'],
            "install_time" => $record['install_time']			

			);

			/**
			 * The variation is part of the product record, so it will have to be attached to the record if this is an
			 * update AND the existing product already has a variation
			 */
			if (is_array($existing) && isId($existing['prodvariationid'])) {
				$productData['prodvariationid'] = $existing['prodvariationid'];
			}

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$productData['prodvendorid'] = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
			}

			$empty = array();

			// Save it
			$err = '';

			if(isset($this->ImportSession['OverrideDuplicates']) && $this->ImportSession['OverrideDuplicates'] == 1) {
				foreach ($productData as $key => $value) {
					if ($value == "" and isset($existing[$key])) $productData[$key] =  $existing[$key];
					if ($value == "<BLANK>" ) $productData[$key] =  "";
				}

				$pricelog = $existing['price_log'];
				$pricelogtime = $existing['price_update_time'];
				$splitprice = split(',',$pricelog);
				$oldprice = end($splitprice);

				if($oldprice != $productData['prodprice']) {
					$productData['price_log'] =  $pricelog.",".$productData['prodprice'];
					$productData['price_update_time'] = date('Y-m-d H:i:s');
				}
				else {
					$productData['price_log'] =  $pricelog;
					$productData['price_update_time'] = $pricelogtime;
				}
				//fixed values in re-import
				$productData['SKU_last_update_time'] = date('Y-m-d H:i:s');
				if ($existing['prodcode'] != "") $productData['prodcode'] = $existing['prodcode'];
				if ($existing['prodvendorid'] != "") $productData['prodvendorid'] = $existing['prodvendorid'];
				if ($existing['prodbrandid'] != "") $productData['prodbrandid'] = $existing['prodbrandid'];

			}


			// temp declaraton to avoid entering in to system log.

			$productData += $defaults;
			foreach ($productData as $key => $value) {
				if (!isset($productData[$key]))  $productData[$key] = "";
			}




			if($this->ImportSession['Importastest'] == 1) {

				$productData['testdata'] = "Yes";
				$productData['prodvisible'] = 0;
			}

			if(isset($record['comp_type']) and $record['comp_type'] !== ''){
				$productData['comp_type'] = (int)@$record['comp_type'];
			}


			//error_log("XXXXXXXXXXXXXXXXXXXXX   ". $record['comp_type']);

			$added_or_not = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_CommitImportProduct($productId, $productData, $empty, $empty, $empty, $empty, $err, $empty, true);

			// Is there an existing product with the same SUK + Vendor Prefix? if so, will update the name of the products in products_statistics - Mingxing
			$query = sprintf("SELECT * FROM [|PREFIX|]products_statistics WHERE LOWER(prodcode)='%s' and LOWER(prodvendorprefix) = '".$prodvendorprefix."'  ", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($record['prodcode'])));
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				if (isset($GLOBALS['NewProductId']) and   $GLOBALS['NewProductId'] != "")
				$productid = $GLOBALS['NewProductId'];
				else
				$productid = $row['productid'];
				$query = sprintf("update [|PREFIX|]products_statistics set prodname='%s', productid='".$productid."', enable=1 where LOWER(prodcode)='%s' and LOWER(prodvendorprefix) = '".$prodvendorprefix."'  ", $newprodname, $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($record['prodcode'])));
				$GLOBALS['ISC_CLASS_DB']->Query($query);
				$query = sprintf("update [|PREFIX|]products set prodnumviews='".$row['prodnumviews']."', prodnumsold='".$row['prodnumsold']."', prodratingtotal='".$row['prodratingtotal']."', prodnumratings='".$row['prodnumratings']."'   where  productid='".$productid."'");
				$GLOBALS['ISC_CLASS_DB']->Query($query);
			}
			//end by Mingxing

			if ($added_or_not == 1)
			{
				// there is a problem , if multiple category present



				if (isset($GLOBALS['NewProductId']) and   $GLOBALS['NewProductId'] != "" and !$ShoudOnlyUpdateOtherDetail)
				{
					$sqlinsert2 = "INSERT INTO `isc_import_variations` ( `productid`, `prodcode` , ";
					$values = ") VALUES (".$GLOBALS['NewProductId'].", '".$record['prodcode']."' ,";
					for($i = 0; $i < count($selected); $i++) {


						$fieldname = $selected[$i];
						$thevalue = rtrim($record[$fieldname],";");

						$sqlinsert2.= "`".$fieldname."` ,";
						$values.= "'".$thevalue."',";



						// VQenginetype validation checking
						if ($fieldname == "VQenginetype"  and  $thevalue != "")	$thevalue = $engtype;

						// VQliter validation checking
						if ($fieldname == "VQliter"  and  $thevalue != "")	$thevalue = $liter;


						// only for make search fast
						if ($thevalue != "")
						{

							$sql = "INSERT INTO `isc_qualifier_value` (`pid`, `qid`, `q_value` , `row_no`) VALUES ('".$GLOBALS['NewProductId']."', '".$_SESSION['qualifiers_name'][$fieldname]."', '".$thevalue."' , '".$_SESSION['row_no']."')";
							mysql_query($sql);

						}

						// only for made search fast end

					}

				 $_SESSION['row_no']++;


					$sqlinsert2.= "`bedsize_generalname` , `cabsize_generalname` ";
					$values.= "'".$generalize_bedvalue."', '".$generalize_cabvalue."'";

					$joinedsql = $sqlinsert2.$values." ) ";
					mysql_query($joinedsql);

					//complementary items  ;
					$record['complementaryitems'] = str_replace('�','"',$record['complementaryitems']);
					$record['complementaryitems'] = str_replace('�','"',$record['complementaryitems']);
					$comData = array(
						"complementaryitems" => $record['complementaryitems'],
						"variationid" => mysql_insert_id(),
						"productid" => $GLOBALS['NewProductId']
					);
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("application_data", $comData);

					$_SESSION['OverRidedInThisImport'][$GLOBALS['NewProductId']] = 1;
					unset($ShoudOnlyUpdateOtherDetail);
				}


			}

			if($productId == 0) {
				$productId = $GLOBALS['NewProductId'];
			}

			// Are there any images?
			if(count($productImages) > 0) {
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_images', "WHERE imageprodid='".$productId."'");
				foreach($productImages as $image) {
					$image['imageprodid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $image);
				}
			}
			// Are there any Install images? blessen
			if(count($productInstallImages) > 0) {
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('install_images', "WHERE imageprodid='".$productId."'");
				foreach($productInstallImages as $image) {
					$image['imageprodid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("install_images", $image);
				}
			}

			// Are there any Install videos ? blessen

			if ($record['prodinstallvideo'] != "")
			{
				$productInstallVideos = array();
				$video_pieces = preg_split("/[;,]/", $record['prodinstallvideo']);
				$end = end($video_pieces);
				if(empty($end)) array_pop($video_pieces);

				foreach ($video_pieces as $key => $values)
				{
					$productInstallVideos[] = array(
					"videofile" => $values,
					"videotype" => 1,
					"videoprodid" => $productId
					);

				}

				if(count($productInstallVideos) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('install_videos', "WHERE videoprodid='".$productId."'");
					foreach($productInstallVideos as $video) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("install_videos", $video);
					}
				}
			}


			// Are there any product videos ? blessen audio_clip
			if ($record['prodvideo'] != "")
			{
				$productVideos = array();
				$video_pieces = preg_split("/[;,]/", $record['prodvideo']);
				$end = end($video_pieces);
				if(empty($end)) array_pop($video_pieces);

				foreach ($video_pieces as $key => $values)
				{
					$productVideos[] = array(
					"videofile" => $values,
					"videotype" => 1,
					"videoprodid" => $productId
					);

				}

				if(count($productVideos) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_videos', "WHERE videoprodid='".$productId."'");
					foreach($productVideos as $video) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_videos", $video);
					}
				}
			}
			// Are there any product audio_clip ? blessen
			if ($record['audio_clip'] != "")
			{
				$product_audio_clip = array();
				$audio_pieces = preg_split("/[;,]/", $record['audio_clip']);
				$end = end($audio_pieces);
				if(empty($end)) array_pop($audio_pieces);

				foreach ($audio_pieces as $key => $values)
				{
					$product_audio_clip[] = array(
					"audiofile" => $values,
					"audiotype" => 1,
					"audioprodid" => $productId
					);

				}

				if(count($product_audio_clip) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('audio_clips', "WHERE audioprodid='".$productId."'");
					foreach($product_audio_clip as $audio) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("audio_clips", $audio);
					}
				}
			}

			// Are there any product article file ? blessen
			if ($record['article_file'] != "")
			{
				$product_article = array();
				$article_pieces = preg_split("/[;,]/", $record['article_file']);
				$end = end($article_pieces);
				if(empty($end)) array_pop($article_pieces);

				foreach ($article_pieces as $key => $values)
				{
					$product_article[] = array(
					"articlefile" => $values,
					"articletype" => 1,
					"articleprodid" => $productId
					);

				}

				if(count($product_article) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('article_files', "WHERE articleprodid='".$productId."'");
					foreach($product_article as $article) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("article_files", $article);
					}
				}
			}

			// Are there any product instruction_file  ? blessen
			if ($record['instruction_file'] != "")
			{
				$product_instruction = array();
				$instruction_pieces = preg_split("/[;,]/", $record['instruction_file']);
				$end = end($instruction_pieces);
				if(empty($end)) array_pop($instruction_pieces);

				foreach ($instruction_pieces as $key => $values)
				{
					$product_instruction[] = array(
					"instructionfile" => $values,
					"instructiontype" => 1,
					"instructionprodid" => $productId
					);

				}

				if(count($product_instruction) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('instruction_files', "WHERE instructionprodid='".$productId."'");
					foreach($product_instruction as $instruction) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("instruction_files", $instruction);
					}
				}

			}


			// Are there any product files?
			if(count($productFiles) > 0) {
				foreach($productFiles as $file) {
					$file['productid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_downloads", $file);
				}
			}

			++$this->ImportSession['Results']['Imported'];
			++$this->ImportSession['Results']['SuccessCount'];
	}
	
	
      //alandy single step process import product function.
       protected function _prepareImport($record){
       		
		$loggedid = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUserId();
		$vendorId = $record['vendorid'];
		
		if(isset($record['complementary_selection_type']) and $record['complementary_selection_type']!=='' and !preg_match("/^\s*[01]\s*$/",$record['complementary_selection_type'])) {
			$this->writetherejected($record, ' <-- Wrong data for COMPLEMENTARY SELECTION TYPE', $vendorId, $loggedid);
			return;
		}

	
		// Automatically fetching categories based on CSV field
		if(isset($this->ImportSession['AutoCategory'])) {
			
			if(!$record['category']) {
				$this->ImportSession['Results']['Failures'][] = implode(",", $record)." ".GetLang('ImportProductsMissingCategory');
				return;
			}

			// Import the categories for the products too
			//alandy .fetch the catparentid
			$cats = array();
			$cats[]=$record['subcategoryid'];					
									
		}
		// Manually set a category
		else {
			//alandy.need to check!
			$cats = array($this->ImportSession['CategoryId']);
		}

		$cat_condition = false;

		if (isset($this->ImportSession['PreCategory'])){

			$cat_condition = (($cats[0] == 0) || (!in_array($cats[0], $this->ImportSession['PreCategory'])))?true:false;
			// checking for  invalid category and selected category
		}else{

			$cat_condition = ($cats[0] == 0 )?true:false;

		}

		if($cat_condition) {

			$this->writetherejected($record,'Un defined Category',$vendorId,$loggedid);
			return;
		}


		// Does the brand already exist?
		
		if(isset($record['brand']) && $record['brand'] != '') {
			
			if($record['brandid']>0) {
				$brandId = $record['brandid'];
			}
			//else no  brand exist.
			else {
				$this->writetherejected($record,'Brand Does not exist',$vendorId,$loggedid);
				return;
			}
		}


		//reject if vendor prefix is not present
		$prodvendorprefix = strtolower($record['vendorprefix']);

		
		$prodmake = $record['make'];
		$prodsubmodel = $record['submodel'];
		$prodmodel = $record['model'];
		$prodstartyear = $record['startyear'];
		$prodendyear = $record['endyear'];
		
		$catuniversal=$record['catuniversal'];
		$catparentid=$record['catparentid'];
        $catcombine=$record['catcombine'];
        $Productname_elements  = explode(",",$record['product_name']);
       
		
      		
		// no need to store products under root category if any subcategory exist.
		//alandy. need to confirm this function.
		/*
        if ($record['pcatparentid'] ==0)
		{

			//check for subcategories
			$query4 = "SELECT count(catparentid) as subcnt  FROM [|PREFIX|]categories WHERE catparentid = '".$record['categoryid']."' ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
			$eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
			$subcnt = $eng_row['subcnt'];
			if ($subcnt > 0)
			{
				//if any subcategory exist, Reject it.
				$this->writetherejected($record,'Products cannot store directly to the root category ',$vendorId,$loggedid);
				return;

			}


		}
     */
       
       		//Reject data if invalid Year make Model and submodel except for universal categories.
		if ($catuniversal == 0)
		{
			// no need Universal Products with non-universal category
			
			if (strtolower($prodstartyear) != "all" || strtolower($prodendyear) != "all" || strtolower($prodmodel) != "all" || strtolower($prodmake) != "non-spec vehicle"  )
			{
				//2011-5-10 alandy modify.if doesn't exist MMY then add it to db.
				// MMY validation
				
				$prodstartyear=(int)$prodstartyear;
				$prodendyear=(int)$prodendyear;
				
				if($prodstartyear>1949 && $prodendyear>1949 && $prodstartyear<2051 && $prodendyear<2051  && ($prodendyear-$prodstartyear)>=0){

				
				 for($i=$prodstartyear;$i<=$prodendyear;$i++){
				 	 
				 	$query2 = "SELECT id FROM [|PREFIX|]product_mmy  WHERE year  = '".$i."' and model   = '".$prodmodel."' and submodel = '".$prodsubmodel."' and make   = '".$prodmake."' limit 0,1 ";
				 	$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
				 		
				 	if ($GLOBALS['ISC_CLASS_DB']->CountResult($result2) == 0){
				 		$sql="insert into [|PREFIX|]product_mmy(year,make,model,submodel) values('".$i."','".$prodmake."','".$prodmodel."','".$prodsubmodel."')";
				 		$GLOBALS['ISC_CLASS_DB']->Query("insert into [|PREFIX|]product_mmy(year,make,model,submodel) values('".$i."','".$prodmake."','".$prodmodel."','".$prodsubmodel."')");
				 		}else{
				 		$row_ymm_id = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2);
				 		$ymm_id = $row_ymm_id['id'];
				 		}
				  }
				 	
					/*
					$query="insert into [|PREFIX|]product_mmy (year,make,model,submodel) SELECT $prodstartyear+id-1, '$prodmake', '$prodmodel', '$prodsubmodel' FROM   sequence s WHERE  id <= ($prodendyear - $prodstartyear+1)
					and not exists ( SELECT 1 FROM [|PREFIX|]product_mmy m where  $prodstartyear+s.id = m.year and '$prodmake' = m.make and '$prodmodel' = m.model and '$prodsubmodel' = m.submodel 
					)";
					
					
					$GLOBALS['ISC_CLASS_DB']->Query($query);
										
					$query2 = "SELECT id FROM [|PREFIX|]product_mmy  WHERE (year  = '".$prodstartyear."' or year  = '".$prodendyear."' ) and model   = '".$prodmodel."' and submodel = '".$prodsubmodel."' and make   = '".$prodmake."' limit 0,1 ";
				    $result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
				    if ($GLOBALS['ISC_CLASS_DB']->CountResult($result2) > 0){
				    	$row_ymm_id = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2);
				 		$ymm_id = $row_ymm_id['id'];
				    }
				    */				
					
				 	
				}else{
					$this->writetherejected($record,'Invalid startyear or endyear ',$vendorId,$loggedid);

					return;
				}

			}
		}
		else if($catuniversal == 1)
		{
			if (strtolower($prodstartyear) != "all" || strtolower($prodendyear) != "all" || strtolower($prodmodel) != "all" || strtolower($prodmake) != "non-spec vehicle"  )
			{

				$this->writetherejected($record,'non-universal products will not be imported into universal subcategory',$vendorId,$loggedid);
				return;
			}
		}
				

		$productId = 0;
		$hasThumb = false;
		$productFiles = array();
		$productImages = array();
		$existing = null;
		$generalize_bedvalue = "";
		$generalize_cabvalue = "";

		// genarating prod name

		$subcat  = strtolower($record['subcategory']);
		$cat  = strtolower($record['category']);
		$partnumber = $record['partnumber'];

		$product_series = strtolower($record['series']);
		$brand = $record['brand'];


		// No need to enter all the PQ/VQ to the import variation table , only category associated
		$selected = array_values(array_intersect($_SESSION['assocvqpq'][$cats[0]] , $_SESSION['qualifiers']));
		//$selected = $_SESSION['assocvqpq'][$cats[0]];
		
		if (!isset($selected)) $selected = array();



		if (in_array('VQliter', $selected)  and  $catuniversal == 0 and $record['VQliter'] != "")
		{
			$query4 = "SELECT liter FROM [|PREFIX|]engine_table WHERE ymm_id = '".$ymm_id."'  limit 0,1 ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
			$eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
			$liter = $eng_row['liter'];
		}

		if (in_array('VQenginetype', $selected)  and  $catuniversal == 0 and $record['VQenginetype'] != "")
		{
			$query4 = "SELECT engtype FROM [|PREFIX|]engine_table WHERE ymm_id = '".$ymm_id."'  limit 0,1 ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
			$eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
			$engtype = $eng_row['engtype'];
		}


		// this is for cat-subcat combined name, joing category to subcategory and removed dupliacates
		if ($catcombine == "" and in_array(0, $Productname_elements) and in_array(1, $Productname_elements))
		{

			//$sc = str_word_count($subcat, 1);
			$sc = explode(" ", $subcat);
			foreach ($sc as $value) {
				$cat = str_ireplace($value, " ", $cat );
					
			}

			$c = str_word_count($cat, 1,"1234567890'-_");
			foreach ($c as $value) {
				$subcat = str_ireplace($value."s", " ", $subcat );
				$subcat = str_ireplace($value."es", " ", $subcat );
			}

			if (trim($cat) == "s" || trim($cat) == "S") $cat = "";

			$catcombine = $subcat." ".$cat;
		}

		if (in_array(0, $Productname_elements) and !in_array(1, $Productname_elements)) {
			$catcombine = $cat;
		}
		else if (!in_array(0, $Productname_elements) and in_array(1, $Productname_elements)){
			$catcombine = $subcat;
		}

		if (in_array(3, $Productname_elements) and in_array(0, $Productname_elements) and in_array(1, $Productname_elements))
		{
			$product_series = str_word_count($product_series, 1,"1234567890'-_");
			$subcatcomp = str_word_count($catcombine, 1,"1234567890'-_");
			$product_series = array_diff($product_series, $subcatcomp);
			$product_series = implode(" ", $product_series);
		}
		else
		if (!in_array(3, $Productname_elements))
		$product_series = "";


		// process 3


		if (isset($record['PQcolor']) and in_array(6, $Productname_elements) ) $prodcolor =  rtrim(strtolower($record['PQcolor']),";");
		else
		$prodcolor = "";

		if (isset($record['PQmaterial']) and in_array(7, $Productname_elements)) $prodmaterial =  rtrim(strtolower($record['PQmaterial']),";");
		else
		$prodmaterial = "";

		if (isset($record['PQstyle']) and in_array(8, $Productname_elements)) $prodstyle =  rtrim(strtolower($record['PQstyle']),";");
		else
		$prodstyle = "";




		if (in_array(4, $Productname_elements) and in_array(5, $Productname_elements)) $PartNumberTXT =  " Part Number ";
		else
		$PartNumberTXT =  " ";

		if (!in_array(5, $Productname_elements)) $partnumber =  "";
		if (!in_array(2, $Productname_elements)) $brand =  "";

		//joing product name
		$prodname = $catcombine." ".$brand." ".$product_series.$PartNumberTXT.$partnumber." ".$prodcolor." ".$prodmaterial." ".$prodstyle;

		
		$prodname = str_replace("/", " ", $prodname);
		$prodname = preg_replace('/(\s+)/',' ',$prodname);
		$newprodname = trim($prodname);
		$newprodname = ucwords($newprodname);

		array_push($selected, "prodmake" , "prodmodel","prodsubmodel","prodstartyear","prodendyear");


		if(!isset($_SESSION['OverRidedInThisImport']))
		{
			$_SESSION['OverRidedInThisImport'] = array();
			//++$this->ImportSession['Results']['SuccessCount'];
		}




		// Is there an existing product with the same name?
		$query = sprintf("SELECT * FROM [|PREFIX|]products WHERE prodcode='%s' and prodvendorprefix = '".$prodvendorprefix."'  ", $GLOBALS['ISC_CLASS_DB']->Quote($record['partnumber']));
		$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
		
		if($existing = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
			// NI-20101104-Start
			// Issue : Enhancement for importing application records

			/*
			if( isset($record['product_name']) && $record['product_name'] != "" )
			{
				$prodnameexistqry = "select prodname from [|PREFIX|]products where prodname = '".$GLOBALS['ISC_CLASS_DB']->Quote($record['product_name'])."' and productid != ".$existing['productid'];
				$prodnameexistresult = $GLOBALS['ISC_CLASS_DB']->Query($prodnameexistqry);
		        if ($GLOBALS['ISC_CLASS_DB']->CountResult($prodnameexistresult) > 0)
				{
					$this->writetherejected($record,'Product Name already exist',$vendorId,$loggedid);
					return;
				}
				else
				{
					$newprodname = ucwords($record['product_name']);
				}
			}
			*/
			$newprodname = ucwords($record['product_name']);
	
			$query2 = "SELECT id FROM [|PREFIX|]import_variations  WHERE productid = '".$existing['productid']."' limit 0,1 ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);

			//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid']);


			if(isset($this->ImportSession['OverrideDuplicates']) && $this->ImportSession['OverrideDuplicates'] == 1
			&& isset($this->ImportSession['OverrideOptionValue']) && $this->ImportSession['OverrideOptionValue'] == 'APP_RECORD') {
					
				if(!$_SESSION['OverRidedInThisImport'][$existing['productid']] && $GLOBALS['ISC_CLASS_DB']->CountResult($result2) != 0){

					//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  first time in");
					//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  delete all");
					$GLOBALS['ISC_CLASS_DB']->Query("DELETE FROM isc_import_variations  WHERE productid = ".$existing['productid'].";");
					$GLOBALS['ISC_CLASS_DB']->Query("DELETE FROM isc_qualifier_value  WHERE pid = ".$existing['productid'].";");
					$GLOBALS['ISC_CLASS_DB']->Query("DELETE FROM isc_application_data  WHERE productid = ".$existing['productid'].";");

				}
				$_SESSION['OverRidedInThisImport'][$existing['productid']] = 1;
			}



			if ($_SESSION['OverRidedInThisImport'][$existing['productid']])
			{
				//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  insert this record");
				$sqlinsert2 = "INSERT INTO `isc_import_variations` ( `productid`, `prodcode` ,";
				$values = ") VALUES (".$existing['productid'].", '".$record['partnumber']."' ,";
				for($i = 0; $i < count($selected); $i++) {


					$fieldname = $selected[$i];
					$thevalue = rtrim($record[$fieldname],";");

					$sqlinsert2.= "`".$fieldname."` ,";
					$values.= "'".$thevalue."',";

					// VQenginetype validation checking
					if ($fieldname == "VQenginetype"  and  $thevalue != "")	$thevalue = $engtype;

					// VQliter validation checking
					if ($fieldname == "VQliter"  and  $thevalue != "")	$thevalue = $liter;


					// this table is only for to make search fast

					if ($thevalue != "")
					{
						$sql = "INSERT INTO `isc_qualifier_value` (`pid`, `qid`, `q_value` , `row_no`) VALUES ('".$existing['productid']."', '".$_SESSION['qualifiers_name'][$fieldname]."', '".$thevalue."' ,  '".$_SESSION['row_no']."')";
						$GLOBALS['ISC_CLASS_DB']->Query($sql);
							
					}
					// only for search fast end




				}
				$_SESSION['row_no']++;

					

				$sqlinsert2.= "`bedsize_generalname` , `cabsize_generalname` ";
				$values.= "'".$generalize_bedvalue."', '".$generalize_cabvalue."'";

				$joinedsql = $sqlinsert2.$values." ) ";
				$GLOBALS['ISC_CLASS_DB']->Query($joinedsql);

				//complementary items  ;
				$record['complementary_items'] = str_replace('�','"',$record['complementary_items']);
				$record['complementary_items'] = str_replace('�','"',$record['complementary_items']);
				$comData = array(
						"complementaryitems" => $record['complementary_items'],
						"variationid" => mysql_insert_id(),
						"productid" => $existing['productid']
				);
				$GLOBALS['ISC_CLASS_DB']->InsertQuery("application_data", $comData);

			}

			// Overriding existing products, set the product id
			if(isset($this->ImportSession['OverrideDuplicates']) && $this->ImportSession['OverrideDuplicates'] == 1
			&& isset($this->ImportSession['OverrideOptionValue']) && $this->ImportSession['OverrideOptionValue'] == 'OTHER_DETAIL') {
				//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  update other");
				$productId = $existing['productid'];
				//$cats = null;  // blessen
				//$cats = "";   let the category change in re-import blessen 22-10 as per client req.

				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() != $existing['prodvendorid']) {
					$this->ImportSession['Results']['Failures'][] = implode(",", $record)." ".GetLang('ImportProductInvalidVendor');
					return;
				}

				$this->ImportSession['Results']['Updates'][] = $record['partnumber'];

				$ShoudOnlyUpdateOtherDetail = true;

			}
			else {
				//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  do not update other");
				//$this->ImportSession['Results']['Duplicates'][] = $record['prodcode'];
				//++$this->ImportSession['Results']['Imported'];
               
				//return;
			}
			// NI-20101104-End
			// Issue : Enhancement for importing application records


		}
		else // for new products
		{ 
			/* Updating product name as per client request - 19-8-10 - vikas */
			if( isset($record['product_name']) && $record['product_name'] != "" )
			{
				$prodnameexistqry = "select prodname from [|PREFIX|]products where prodname = '".$GLOBALS['ISC_CLASS_DB']->Quote($record['product_name'])."' ";
				$prodnameexistresult = $GLOBALS['ISC_CLASS_DB']->Query($prodnameexistqry);

				if ($GLOBALS['ISC_CLASS_DB']->CountResult($prodnameexistresult) > 0)
				{
					$this->writetherejected($record,'Product Name already exist',$vendorId,$loggedid);
					return;
				}
				else
				{
					$newprodname = ucwords($record['product_name']);
				}
			}
			
		}


		// If this is an update then we have to merge in the existing information that is NOT in the CSV file
		if (is_array($existing)) {
			$record = $record + $existing;
		}

		// Apply any default data
		$defaults = array(
			
			'taxable_product' => 1,
			'price' => 0,
			'cost_price' => 0,
			'retail_price' => 0,
			'sale_price' => 0,
			'search_keywords' => '',
			'product_sortorder' => 0,
			'product_visible' => 1,
			'product_featured' => 0,
			'product_relatedproducts' => '',
			'product_optionsrequired' => 0,
			'free_shipping' => 0,
			'layout_file' => '',
			'product_tags' => '',
			'prodmyobasset' => '',
			'prodmyobincome' => '',
			'prodmyobexpense' => '',
			'prodpeachtreegl' => '',
			'price_log' => '',
			'SKU_last_update_time' => '',
			'price_update_time' => '',
			'unilateralprice' => '',
			'testdata' => 'No',
			'prodalternates' => '',
			'skubarcode' => ''
	
			);


			$record += $defaults;



			// Does the series already exist? //blessen
			$seriesId = 0;
			if(isset($record['series']) && $record['series'] != '') {
				$query = sprintf("select seriesid from [|PREFIX|]brand_series where lower(seriesname)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($record['series'])));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$seriesId = $row['seriesid'];
				}
				// Create new series
				else {
					$newSeries = array(
						"brandid" => $brandId,
						"seriesname" => $record['series']
					);
					$seriesId = $GLOBALS['ISC_CLASS_DB']->InsertQuery("brand_series", $newSeries);
					$seriesId = $GLOBALS['ISC_CLASS_DB']->LastId();
				}
			}



			if(!isset($record['product_invtrack'])) {
				$record['product_invtrack'] = 0;
			}

			if (isset($record['product_file']) && $record['product_file'] != '') {
				$productType = 2;
			} else if (isset($existing['product_type']) && isId($existing['product_type'])) {
				$productType = (int)$existing['product_type'];
			} else {
				$productType = 1;
			}

			if(isset($record['taxable_product'])) {
				$record['taxable_product'] = $this->StringToYesNoInt($record['taxable_product']);
			}


			$record['description']  = str_replace("�", "&reg;", $record['description']);


			// This is our product
			$productData = array(
			"prodname" => $newprodname,
			"prodcode" => @$record['partnumber'],
			"proddesc" => @$record['description'],
			"prodsearchkeywords" => @$record['search_keywords'],
			"prodtype" => $productType,
			"prodprice" => DefaultPriceFormat($record['price']),
			"prodcostprice" => DefaultPriceFormat($record['cost_price']),
			"prodretailprice" => DefaultPriceFormat($record['retail_price']),
			"prodsaleprice" => DefaultPriceFormat($record['sale_price']),
			"prodavailability" => @$record['product_availability'],
			"prodsortorder" => $record['product_sortorder'],
			"prodvisible" => $record['product_visible'],
			"prodfeatured" => $record['product_featured'],
			"prodrelatedproducts" => $record['product_relatedproducts'],
			"prodinvtrack" => (int)@$record['product_invtrack'],
			"prodcurrentinv" => (int)@$record['current_stock_level'],
			"prodlowinv" => (int)@$record['low_stock_level'],
			"prodoptionsrequired" => $record['product_optionsrequired'],
			"prodwarranty" => @$record['warranty'],
			"prodheight" => (float)@$record['product_height'],
			"prodweight" => (float)@$record['product_weight'],
			"prodwidth" => (float)@$record['product_width'],
			"proddepth" => (float)@$record['product_depth'],
			"prodfreeshipping" => $record['free_shipping'],
			"prodfixedshippingcost" => DefaultPriceFormat(@$record['fixed_shipping_cost']),
			"prodbrandid" => (int)$brandId,
			"prodcats" => $cats,
			"prodpagetitle" => @$record['page_title'],
			"prodmetakeywords" => @$record['meta_keywords'],
			"prodmetadesc" => @$record['meta_description'],
			"prodlayoutfile" => $record['layout_file'],
			"prodistaxable" => $record['taxable_product'],
			'prodvendorid' => $vendorId,
			'prodtags' => $record['product_tags'],
			"prodvendorprefix" => $record['vendorprefix'],
			"proddescfeature" => $record['feature_points'],
			"prodmfg" => $record['manufacture_info'],
			"jobberprice" => $record['jobber_price'],
			"mapprice" => $record['map_price'],
           	"alternativecategory" => $record['alternative_category'],
			"complementaryupcharge" => $record['complementary_upcharge'],
			"ourcost" => $record['our_cost'],
            "package_length" => $record['package_length'],
			"package_height" => $record['package_height'],
			"package_weight" => $record['package_weight'],
			"package_width" => $record['package_width'],
			"brandseriesid" => $seriesId,
            "future_retail_price" => $record['future_retail_price'],
			"future_jobber_price" => $record['future_jobber_price'],
			"prod_instruction" => $record['instruction'],
			"prod_article" => $record['product_article'],
			"skubarcode" => $record['skubarcode'],
            "install_time" => $record['install_time']			

			);

			/**
			 * The variation is part of the product record, so it will have to be attached to the record if this is an
			 * update AND the existing product already has a variation
			 */
			if (is_array($existing) && isId($existing['prodvariationid'])) {
				$productData['prodvariationid'] = $existing['prodvariationid'];
			}

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$productData['prodvendorid'] = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
			}

			$empty = array();

			// Save it
			$err = '';

			if(isset($this->ImportSession['OverrideDuplicates']) && $this->ImportSession['OverrideDuplicates'] == 1) {
				foreach ($productData as $key => $value) {
					if ($value == "" and isset($existing[$key])) $productData[$key] =  $existing[$key];
					if ($value == "<BLANK>" ) $productData[$key] =  "";
				}

				$pricelog = $existing['price_log'];
				$pricelogtime = $existing['price_update_time'];
				$splitprice = split(',',$pricelog);
				$oldprice = end($splitprice);

				if($oldprice != $productData['prodprice']) {
					$productData['price_log'] =  $pricelog.",".$productData['prodprice'];
					$productData['price_update_time'] = date('Y-m-d H:i:s');
				}
				else {
					$productData['price_log'] =  $pricelog;
					$productData['price_update_time'] = $pricelogtime;
				}
				//fixed values in re-import
				$productData['SKU_last_update_time'] = date('Y-m-d H:i:s');
				if ($existing['prodcode'] != "") $productData['prodcode'] = $existing['prodcode'];
				if ($existing['prodvendorid'] != "") $productData['prodvendorid'] = $existing['prodvendorid'];
				if ($existing['prodbrandid'] != "") $productData['prodbrandid'] = $existing['prodbrandid'];

			}


			// temp declaraton to avoid entering in to system log.

			$productData += $defaults;
			foreach ($productData as $key => $value) {
				if (!isset($productData[$key]))  $productData[$key] = "";
			}


			if($this->ImportSession['Importastest'] == 1) {

				$productData['testdata'] = "Yes";
				$productData['prodvisible'] = 0;
			}

			if(isset($record['complementary_selection_type']) and $record['complementary_selection_type'] !== ''){
				$productData['complementary_selection_type'] = (int)@$record['complementary_selection_type'];
			}


			//error_log("XXXXXXXXXXXXXXXXXXXXX   ". $record['comp_type']);

			$added_or_not = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_CommitImportProduct($productId, $productData, $empty, $empty, $empty, $empty, $err, $empty, true);

			//alandy_20110602.modify the success count.
			if($added_or_not){
				++$this->ImportSession['Results']['SuccessCount'];
			}else{
				++$this->ImportSession['Results']['Imported'];
				return;
			}
			// Is there an existing product with the same SUK + Vendor Prefix? if so, will update the name of the products in products_statistics - Mingxing
			$query = sprintf("SELECT * FROM [|PREFIX|]products_statistics WHERE prodcode='%s' and prodvendorprefix = '".$prodvendorprefix."'  ", $GLOBALS['ISC_CLASS_DB']->Quote($record['partnumber']));
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				if (isset($GLOBALS['NewProductId']) and   $GLOBALS['NewProductId'] != "")
				$productid = $GLOBALS['NewProductId'];
				else
				$productid = $row['productid'];
				$query = sprintf("update [|PREFIX|]products_statistics set prodname='%s', productid='".$productid."', enable=1 where prodcode='%s' and prodvendorprefix = '".$prodvendorprefix."'  ", $newprodname, $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($record['partnumber'])));
				$GLOBALS['ISC_CLASS_DB']->Query($query);
				$query = sprintf("update [|PREFIX|]products set prodnumviews='".$row['prodnumviews']."', prodnumsold='".$row['prodnumsold']."', prodratingtotal='".$row['prodratingtotal']."', prodnumratings='".$row['prodnumratings']."'   where  productid='".$productid."'");
				$GLOBALS['ISC_CLASS_DB']->Query($query);
			}
			//end by Mingxing

			if ($added_or_not == 1)
			{
				// there is a problem , if multiple category present


				if (isset($GLOBALS['NewProductId']) and   $GLOBALS['NewProductId'] != "" and !$ShoudOnlyUpdateOtherDetail)
				{
					$sqlinsert2 = "INSERT INTO `isc_import_variations` ( `productid`, `prodcode` , ";
					$values = ") VALUES (".$GLOBALS['NewProductId'].", '".$record['partnumber']."' ,";
										
					for($i = 0; $i < count($selected); $i++) {


						$fieldname = $selected[$i];
						$thevalue = rtrim($record[$fieldname],";");

						$sqlinsert2.= "`".$fieldname."` ,";
						$values.= "'".$thevalue."',";



						// VQenginetype validation checking
						if ($fieldname == "VQenginetype"  and  $thevalue != "")	$thevalue = $engtype;

						// VQliter validation checking
						if ($fieldname == "VQliter"  and  $thevalue != "")	$thevalue = $liter;


						// only for make search fast
						if ($thevalue != "")
						{

							$sql = "INSERT INTO `isc_qualifier_value` (`pid`, `qid`, `q_value` , `row_no`) VALUES ('".$GLOBALS['NewProductId']."', '".$_SESSION['qualifiers_name'][$fieldname]."', '".$thevalue."' , '".$_SESSION['row_no']."')";
							mysql_query($sql);

						}

						// only for made search fast end

					}

				 $_SESSION['row_no']++;


					$sqlinsert2.= "`bedsize_generalname` , `cabsize_generalname` ";
					$values.= "'".$generalize_bedvalue."', '".$generalize_cabvalue."'";

					$joinedsql = $sqlinsert2.$values." ) ";
					
					mysql_query($joinedsql);

					//complementary items  ;
					$record['complementary_items'] = str_replace('�','"',$record['complementary_items']);
					$record['complementary_items'] = str_replace('�','"',$record['complementary_items']);
					$comData = array(
						"complementaryitems" => $record['complementary_items'],
						"variationid" => mysql_insert_id(),
						"productid" => $GLOBALS['NewProductId']
					);
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("application_data", $comData);

					$_SESSION['OverRidedInThisImport'][$GLOBALS['NewProductId']] = 1;
					unset($ShoudOnlyUpdateOtherDetail);
				}


			}

			if($productId == 0) {
				$productId = $GLOBALS['NewProductId'];
			}

			// Are there any images?
			if(count($productImages) > 0) {
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_images', "WHERE imageprodid='".$productId."'");
				foreach($productImages as $image) {
					$image['imageprodid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $image);
				}
			}
			// Are there any Install images? blessen
			if(count($productInstallImages) > 0) {
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('install_images', "WHERE imageprodid='".$productId."'");
				foreach($productInstallImages as $image) {
					$image['imageprodid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("install_images", $image);
				}
			}

			// Are there any Install videos ? blessen

			if ($record['install_video'] != "")
			{
				$productInstallVideos = array();
				$video_pieces = preg_split("/[;,]/", $record['install_video']);
				$end = end($video_pieces);
				if(empty($end)) array_pop($video_pieces);

				foreach ($video_pieces as $key => $values)
				{
					$productInstallVideos[] = array(
					"videofile" => $values,
					"videotype" => 1,
					"videoprodid" => $productId
					);

				}

				if(count($productInstallVideos) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('install_videos', "WHERE videoprodid='".$productId."'");
					foreach($productInstallVideos as $video) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("install_videos", $video);
					}
				}
			}


			// Are there any product videos ? blessen audio_clip
			if ($record['product_video'] != "")
			{
				$productVideos = array();
				$video_pieces = preg_split("/[;,]/", $record['product_video']);
				$end = end($video_pieces);
				if(empty($end)) array_pop($video_pieces);

				foreach ($video_pieces as $key => $values)
				{
					$productVideos[] = array(
					"videofile" => $values,
					"videotype" => 1,
					"videoprodid" => $productId
					);

				}

				if(count($productVideos) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_videos', "WHERE videoprodid='".$productId."'");
					foreach($productVideos as $video) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_videos", $video);
					}
				}
			}
			// Are there any product audio_clip ? blessen
			if ($record['audio_clip'] != "")
			{
				$product_audio_clip = array();
				$audio_pieces = preg_split("/[;,]/", $record['audio_clip']);
				$end = end($audio_pieces);
				if(empty($end)) array_pop($audio_pieces);

				foreach ($audio_pieces as $key => $values)
				{
					$product_audio_clip[] = array(
					"audiofile" => $values,
					"audiotype" => 1,
					"audioprodid" => $productId
					);

				}

				if(count($product_audio_clip) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('audio_clips', "WHERE audioprodid='".$productId."'");
					foreach($product_audio_clip as $audio) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("audio_clips", $audio);
					}
				}
			}

			// Are there any product article file ? blessen
			if ($record['article_file'] != "")
			{
				$product_article = array();
				$article_pieces = preg_split("/[;,]/", $record['article_file']);
				$end = end($article_pieces);
				if(empty($end)) array_pop($article_pieces);

				foreach ($article_pieces as $key => $values)
				{
					$product_article[] = array(
					"articlefile" => $values,
					"articletype" => 1,
					"articleprodid" => $productId
					);

				}

				if(count($product_article) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('article_files', "WHERE articleprodid='".$productId."'");
					foreach($product_article as $article) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("article_files", $article);
					}
				}
			}

			// Are there any product instruction_file  ? blessen
			if ($record['instruction_file'] != "")
			{
				$product_instruction = array();
				$instruction_pieces = preg_split("/[;,]/", $record['instruction_file']);
				$end = end($instruction_pieces);
				if(empty($end)) array_pop($instruction_pieces);

				foreach ($instruction_pieces as $key => $values)
				{
					$product_instruction[] = array(
					"instructionfile" => $values,
					"instructiontype" => 1,
					"instructionprodid" => $productId
					);

				}

				if(count($product_instruction) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('instruction_files', "WHERE instructionprodid='".$productId."'");
					foreach($product_instruction as $instruction) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("instruction_files", $instruction);
					}
				}

			}


			// Are there any product files?
			if(count($productFiles) > 0) {
				foreach($productFiles as $file) {
					$file['productid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_downloads", $file);
				}
			}

			++$this->ImportSession['Results']['Imported'];
			//alandy_20110612.
			//++$this->ImportSession['Results']['SuccessCount'];
			
	}
	
	
 //alandy auto match the CSV FILE HEAD.
       protected function _prepareImport2($record,$head){
       	//init the record array to num key.
       	$recordval=array_values($record);
       
		$loggedid = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUserId();
		$vendorId = $record['vendorid'];
		
		if(isset($record['comp_type']) and $record['comp_type']!=='' and !preg_match("/^\s*[01]\s*$/",$record['comp_type'])) {
			$this->writetherejected($record, ' <-- Wrong data for COMPLEMENTARY SELECTION TYPE', $vendorId, $loggedid);
			return;
		}

	
		// Automatically fetching categories based on CSV field
		if(isset($this->ImportSession['AutoCategory'])) {
			
			if(!$recordval[$head['category']]) {
				$this->ImportSession['Results']['Failures'][] = implode(",", $record)." ".GetLang('ImportProductsMissingCategory');
				return;
			}

			// Import the categories for the products too
			//alandy .fetch the catparentid
			$cats = array();
			$cats[]=$record['subcategoryid'];					
									
		}
		// Manually set a category
		else {
			//alandy.need to check!
			$cats = array($this->ImportSession['CategoryId']);
		}

		$cat_condition = false;

		if (isset($this->ImportSession['PreCategory'])){

			$cat_condition = (($cats[0] == 0) || (!in_array($cats[0], $this->ImportSession['PreCategory'])))?true:false;
			// checking for  invalid category and selected category
		}else{

			$cat_condition = ($cats[0] == 0 )?true:false;

		}

		if($cat_condition) {

			$this->writetherejected($record,'Un defined Category',$vendorId,$loggedid);
			return;
		}


		// Does the brand already exist?
		
		if(isset($recordval[$head['brandname']]) && $recordval[$head['brandname']] != '') {
			
			if($record['brandid']>0) {
				$brandId = $record['brandid'];
			}
			//else no  brand exist.
			else {
				$this->writetherejected($record,'Brand Does not exist',$vendorId,$loggedid);
				return;
			}
		}


		//reject if vendor prefix is not present
		$prodvendorprefix = strtolower($recordval[$head['prodvendorprefix']]);

		
		$prodmake = $recordval[$head['prodmake']];
		$prodsubmodel = $recordval[$head['prodsubmodel']];
		$prodmodel = $recordval[$head['prodmodel']];
		$prodstartyear = $recordval[$head['prodstartyear']];
		$prodendyear = $recordval[$head['prodendyear']];
		
		$catuniversal=$record['catuniversal'];
		$catparentid=$record['catparentid'];
        $catcombine=$record['catcombine'];
        $Productname_elements  = explode(",",$recordval[$head['prodname']]);
       
		
      		
		// no need to store products under root category if any subcategory exist.
		//alandy. need to confirm this function.
		/*
        if ($record['pcatparentid'] ==0)
		{

			//check for subcategories
			$query4 = "SELECT count(catparentid) as subcnt  FROM [|PREFIX|]categories WHERE catparentid = '".$record['categoryid']."' ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
			$eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
			$subcnt = $eng_row['subcnt'];
			if ($subcnt > 0)
			{
				//if any subcategory exist, Reject it.
				$this->writetherejected($record,'Products cannot store directly to the root category ',$vendorId,$loggedid);
				return;

			}


		}
     */
       
       		//Reject data if invalid Year make Model and submodel except for universal categories.
		if ($catuniversal == 0)
		{
			// no need Universal Products with non-universal category
			
			if (strtolower($prodstartyear) != "all" || strtolower($prodendyear) != "all" || strtolower($prodmodel) != "all" || strtolower($prodmake) != "non-spec vehicle"  )
			{
				//2011-5-10 alandy modify.if doesn't exist MMY then add it to db.
				// MMY validation
				
				$prodstartyear=(int)$prodstartyear;
				$prodendyear=(int)$prodendyear;
				
				if($prodstartyear>1949 && $prodendyear>1949 && $prodstartyear<2051 && $prodendyear<2051  && ($prodendyear-$prodstartyear)>=0){

				
				 for($i=$prodstartyear;$i<=$prodendyear;$i++){
				 	 
				 	$query2 = "SELECT id FROM [|PREFIX|]product_mmy  WHERE year  = '".$i."' and model   = '".$prodmodel."' and submodel = '".$prodsubmodel."' and make   = '".$prodmake."' limit 0,1 ";
				 	$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
				 		
				 	if ($GLOBALS['ISC_CLASS_DB']->CountResult($result2) == 0){
				 		$sql="insert into [|PREFIX|]product_mmy(year,make,model,submodel) values('".$i."','".$prodmake."','".$prodmodel."','".$prodsubmodel."')";
				 		$GLOBALS['ISC_CLASS_DB']->Query("insert into [|PREFIX|]product_mmy(year,make,model,submodel) values('".$i."','".$prodmake."','".$prodmodel."','".$prodsubmodel."')");
				 		}else{
				 		$row_ymm_id = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2);
				 		$ymm_id = $row_ymm_id['id'];
				 		}
				  }
				 	
					/*
					$query="insert into [|PREFIX|]product_mmy (year,make,model,submodel) SELECT $prodstartyear+id-1, '$prodmake', '$prodmodel', '$prodsubmodel' FROM   sequence s WHERE  id <= ($prodendyear - $prodstartyear+1)
					and not exists ( SELECT 1 FROM [|PREFIX|]product_mmy m where  $prodstartyear+s.id = m.year and '$prodmake' = m.make and '$prodmodel' = m.model and '$prodsubmodel' = m.submodel 
					)";
					
					
					$GLOBALS['ISC_CLASS_DB']->Query($query);
										
					$query2 = "SELECT id FROM [|PREFIX|]product_mmy  WHERE (year  = '".$prodstartyear."' or year  = '".$prodendyear."' ) and model   = '".$prodmodel."' and submodel = '".$prodsubmodel."' and make   = '".$prodmake."' limit 0,1 ";
				    $result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
				    if ($GLOBALS['ISC_CLASS_DB']->CountResult($result2) > 0){
				    	$row_ymm_id = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2);
				 		$ymm_id = $row_ymm_id['id'];
				    }
				    */				
					
				 	
				}else{
					$this->writetherejected($record,'Invalid startyear or endyear ',$vendorId,$loggedid);

					return;
				}

			}
		}
		else if($catuniversal == 1)
		{
			if (strtolower($prodstartyear) != "all" || strtolower($prodendyear) != "all" || strtolower($prodmodel) != "all" || strtolower($prodmake) != "non-spec vehicle"  )
			{

				$this->writetherejected($record,'non-universal products will not be imported into universal subcategory',$vendorId,$loggedid);
				return;
			}
		}
				

		$productId = 0;
		$hasThumb = false;
		$productFiles = array();
		$productImages = array();
		$existing = null;
		$generalize_bedvalue = "";
		$generalize_cabvalue = "";

		// genarating prod name

		$subcat  = strtolower($recordval[$head['category2']]);
		$cat  = strtolower($recordval[$head['category']]);
		$partnumber = $recordval[$head['prodcode']];

		$product_series = strtolower($recordval[$head['product_series']]);
		$brand = $recordval[$head['brandname']];


		// No need to enter all the PQ/VQ to the import variation table , only category associated
		$selected = array_values(array_intersect($_SESSION['assocvqpq'][$cats[0]] , $_SESSION['qualifiers']));
		//$selected = $_SESSION['assocvqpq'][$cats[0]];
		
		if (!isset($selected)) $selected = array();



		if (in_array('VQliter', $selected)  and  $catuniversal == 0 and $record['VQliter'] != "")
		{
			$query4 = "SELECT liter FROM [|PREFIX|]engine_table WHERE ymm_id = '".$ymm_id."'  limit 0,1 ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
			$eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
			$liter = $eng_row['liter'];
		}

		if (in_array('VQenginetype', $selected)  and  $catuniversal == 0 and $record['VQenginetype'] != "")
		{
			$query4 = "SELECT engtype FROM [|PREFIX|]engine_table WHERE ymm_id = '".$ymm_id."'  limit 0,1 ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query4);
			$eng_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result2);
			$engtype = $eng_row['engtype'];
		}


		// this is for cat-subcat combined name, joing category to subcategory and removed dupliacates
		if ($catcombine == "" and in_array(0, $Productname_elements) and in_array(1, $Productname_elements))
		{

			//$sc = str_word_count($subcat, 1);
			$sc = explode(" ", $subcat);
			foreach ($sc as $value) {
				$cat = str_ireplace($value, " ", $cat );
					
			}

			$c = str_word_count($cat, 1,"1234567890'-_");
			foreach ($c as $value) {
				$subcat = str_ireplace($value."s", " ", $subcat );
				$subcat = str_ireplace($value."es", " ", $subcat );
			}

			if (trim($cat) == "s" || trim($cat) == "S") $cat = "";

			$catcombine = $subcat." ".$cat;
		}

		if (in_array(0, $Productname_elements) and !in_array(1, $Productname_elements)) {
			$catcombine = $cat;
		}
		else if (!in_array(0, $Productname_elements) and in_array(1, $Productname_elements)){
			$catcombine = $subcat;
		}

		if (in_array(3, $Productname_elements) and in_array(0, $Productname_elements) and in_array(1, $Productname_elements))
		{
			$product_series = str_word_count($product_series, 1,"1234567890'-_");
			$subcatcomp = str_word_count($catcombine, 1,"1234567890'-_");
			$product_series = array_diff($product_series, $subcatcomp);
			$product_series = implode(" ", $product_series);
		}
		else
		if (!in_array(3, $Productname_elements))
		$product_series = "";


		// process 3


		if (isset($record['PQcolor']) and in_array(6, $Productname_elements) ) $prodcolor =  rtrim(strtolower($record['PQcolor']),";");
		else
		$prodcolor = "";

		if (isset($record['PQmaterial']) and in_array(7, $Productname_elements)) $prodmaterial =  rtrim(strtolower($record['PQmaterial']),";");
		else
		$prodmaterial = "";

		if (isset($record['PQstyle']) and in_array(8, $Productname_elements)) $prodstyle =  rtrim(strtolower($record['PQstyle']),";");
		else
		$prodstyle = "";




		if (in_array(4, $Productname_elements) and in_array(5, $Productname_elements)) $PartNumberTXT =  " Part Number ";
		else
		$PartNumberTXT =  " ";

		if (!in_array(5, $Productname_elements)) $partnumber =  "";
		if (!in_array(2, $Productname_elements)) $brand =  "";

		//joing product name
		$prodname = $catcombine." ".$brand." ".$product_series.$PartNumberTXT.$partnumber." ".$prodcolor." ".$prodmaterial." ".$prodstyle;

		
		$prodname = str_replace("/", " ", $prodname);
		$prodname = preg_replace('/(\s+)/',' ',$prodname);
		$newprodname = trim($prodname);
		$newprodname = ucwords($newprodname);

		array_push($selected, "prodmake" , "prodmodel","prodsubmodel","prodstartyear","prodendyear");


		if(!isset($_SESSION['OverRidedInThisImport']))
		{
			$_SESSION['OverRidedInThisImport'] = array();
			//++$this->ImportSession['Results']['SuccessCount'];
		}




		// Is there an existing product with the same name?
		$query = sprintf("SELECT * FROM [|PREFIX|]products WHERE prodcode='%s' and prodvendorprefix = '".$prodvendorprefix."'  ", $GLOBALS['ISC_CLASS_DB']->Quote($recordval[$head['prodcode']]));
		$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
		
		if($existing = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
			// NI-20101104-Start
			// Issue : Enhancement for importing application records

			/*
			if( isset($record['product_name']) && $record['product_name'] != "" )
			{
				$prodnameexistqry = "select prodname from [|PREFIX|]products where prodname = '".$GLOBALS['ISC_CLASS_DB']->Quote($record['product_name'])."' and productid != ".$existing['productid'];
				$prodnameexistresult = $GLOBALS['ISC_CLASS_DB']->Query($prodnameexistqry);
		        if ($GLOBALS['ISC_CLASS_DB']->CountResult($prodnameexistresult) > 0)
				{
					$this->writetherejected($record,'Product Name already exist',$vendorId,$loggedid);
					return;
				}
				else
				{
					$newprodname = ucwords($record['product_name']);
				}
			}
			*/
			$newprodname = ucwords($recordval[$head['prodname']]);
	
			$query2 = "SELECT id FROM [|PREFIX|]import_variations  WHERE productid = '".$existing['productid']."' limit 0,1 ";
			$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);

			//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid']);


			if(isset($this->ImportSession['OverrideDuplicates']) && $this->ImportSession['OverrideDuplicates'] == 1
			&& isset($this->ImportSession['OverrideOptionValue']) && $this->ImportSession['OverrideOptionValue'] == 'APP_RECORD') {
					
				if(!$_SESSION['OverRidedInThisImport'][$existing['productid']] && $GLOBALS['ISC_CLASS_DB']->CountResult($result2) != 0){

					//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  first time in");
					//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  delete all");
					$GLOBALS['ISC_CLASS_DB']->Query("DELETE FROM isc_import_variations  WHERE productid = ".$existing['productid'].";");
					$GLOBALS['ISC_CLASS_DB']->Query("DELETE FROM isc_qualifier_value  WHERE pid = ".$existing['productid'].";");
					$GLOBALS['ISC_CLASS_DB']->Query("DELETE FROM isc_application_data  WHERE productid = ".$existing['productid'].";");

				}
				$_SESSION['OverRidedInThisImport'][$existing['productid']] = 1;
			}



			if ($_SESSION['OverRidedInThisImport'][$existing['productid']])
			{
				//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  insert this record");
				$sqlinsert2 = "INSERT INTO `isc_import_variations` ( `productid`, `prodcode` ,";
				$values = ") VALUES (".$existing['productid'].", '".$recordval[$head['prodcode']]."' ,";
				for($i = 0; $i < count($selected); $i++) {


					$fieldname = $selected[$i];
					$thevalue = rtrim($record[$fieldname],";");

					$sqlinsert2.= "`".$fieldname."` ,";
					$values.= "'".$thevalue."',";

					// VQenginetype validation checking
					if ($fieldname == "VQenginetype"  and  $thevalue != "")	$thevalue = $engtype;

					// VQliter validation checking
					if ($fieldname == "VQliter"  and  $thevalue != "")	$thevalue = $liter;


					// this table is only for to make search fast

					if ($thevalue != "")
					{
						$sql = "INSERT INTO `isc_qualifier_value` (`pid`, `qid`, `q_value` , `row_no`) VALUES ('".$existing['productid']."', '".$_SESSION['qualifiers_name'][$fieldname]."', '".$thevalue."' ,  '".$_SESSION['row_no']."')";
						$GLOBALS['ISC_CLASS_DB']->Query($sql);
							
					}
					// only for search fast end




				}
				$_SESSION['row_no']++;

					

				$sqlinsert2.= "`bedsize_generalname` , `cabsize_generalname` ";
				$values.= "'".$generalize_bedvalue."', '".$generalize_cabvalue."'";

				$joinedsql = $sqlinsert2.$values." ) ";
				$GLOBALS['ISC_CLASS_DB']->Query($joinedsql);

				//complementary items  ;
				$recordval[$head['complementaryitems']] = str_replace('�','"',$recordval[$head['complementaryitems']]);
				$recordval[$head['complementaryitems']] = str_replace('�','"',$recordval[$head['complementaryitems']]);
				$comData = array(
						"complementaryitems" => $recordval[$head['complementaryitems']],
						"variationid" => mysql_insert_id(),
						"productid" => $existing['productid']
				);
				$GLOBALS['ISC_CLASS_DB']->InsertQuery("application_data", $comData);

			}

			// Overriding existing products, set the product id
			if(isset($this->ImportSession['OverrideDuplicates']) && $this->ImportSession['OverrideDuplicates'] == 1
			&& isset($this->ImportSession['OverrideOptionValue']) && $this->ImportSession['OverrideOptionValue'] == 'OTHER_DETAIL') {
				//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  update other");
				$productId = $existing['productid'];
				//$cats = null;  // blessen
				//$cats = "";   let the category change in re-import blessen 22-10 as per client req.

				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() != $existing['prodvendorid']) {
					$this->ImportSession['Results']['Failures'][] = implode(",", $record)." ".GetLang('ImportProductInvalidVendor');
					return;
				}

				$this->ImportSession['Results']['Updates'][] = $recordval[$head['prodcode']];

				$ShoudOnlyUpdateOtherDetail = true;

			}
			else {
				//error_log("XXXXXXXXXXXXX  prodid " . $existing['productid'] ."  do not update other");
				//$this->ImportSession['Results']['Duplicates'][] = $record['prodcode'];
				//++$this->ImportSession['Results']['Imported'];
               
				//return;
			}
			// NI-20101104-End
			// Issue : Enhancement for importing application records


		}
		else // for new products
		{ 
			/* Updating product name as per client request - 19-8-10 - vikas */
			if( isset($recordval[$head['prodname']]) && $recordval[$head['prodname']] != "" )
			{
				$prodnameexistqry = "select prodname from [|PREFIX|]products where prodname = '".$GLOBALS['ISC_CLASS_DB']->Quote($recordval[$head['prodname']])."' ";
				$prodnameexistresult = $GLOBALS['ISC_CLASS_DB']->Query($prodnameexistqry);

				if ($GLOBALS['ISC_CLASS_DB']->CountResult($prodnameexistresult) > 0)
				{
					$this->writetherejected($record,'Product Name already exist',$vendorId,$loggedid);
					return;
				}
				else
				{
					$newprodname = ucwords($recordval[$head['prodname']]);
				}
			}
			
		}


		// If this is an update then we have to merge in the existing information that is NOT in the CSV file
		if (is_array($existing)) {
			$record = $record + $existing;
		}

		// Apply any default data
		$defaults = array(
			
			'taxable_product' => 1,
			'price' => 0,
			'cost_price' => 0,
			'retail_price' => 0,
			'sale_price' => 0,
			'search_keywords' => '',
			'product_sortorder' => 0,
			'product_visible' => 1,
			'product_featured' => 0,
			'product_relatedproducts' => '',
			'product_optionsrequired' => 0,
			'free_shipping' => 0,
			'layout_file' => '',
			'product_tags' => '',
			'prodmyobasset' => '',
			'prodmyobincome' => '',
			'prodmyobexpense' => '',
			'prodpeachtreegl' => '',
			'price_log' => '',
			'SKU_last_update_time' => '',
			'price_update_time' => '',
			'unilateralprice' => '',
			'testdata' => 'No',
			'prodalternates' => '',
			'skubarcode' => ''
	
			);


			$record += $defaults;



			// Does the series already exist? //blessen
			$seriesId = 0;
			if(isset($recordval[$head['product_series']]) && $recordval[$head['product_series']] != '') {
				$query = sprintf("select seriesid from [|PREFIX|]brand_series where lower(seriesname)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($recordval[$head['product_series']])));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$seriesId = $row['seriesid'];
				}
				// Create new series
				else {
					$newSeries = array(
						"brandid" => $brandId,
						"seriesname" => $recordval[$head['product_series']]
					);
					$seriesId = $GLOBALS['ISC_CLASS_DB']->InsertQuery("brand_series", $newSeries);
					$seriesId = $GLOBALS['ISC_CLASS_DB']->LastId();
				}
			}



			if(!isset($recordval[$head['prodinvtrack']])) {
				$recordval[$head['prodinvtrack']] = 0;
			}

			if (isset($recordval[$head['prodfile']]) && $recordval[$head['prodfile']] != '') {
				$productType = 2;
			} else if (isset($existing['product_type']) && isId($existing['product_type'])) {
				$productType = (int)$existing['product_type'];
			} else {
				$productType = 1;
			}

			if(isset($recordval[$head['prodistaxable']])) {
				$recordval[$head['prodistaxable']] = $this->StringToYesNoInt($recordval[$head['prodistaxable']]);
			}


			$recordval[$head['proddesc']]  = str_replace("�", "&reg;", $recordval[$head['proddesc']]);

			// This is our product
			$productData = array(
			"prodname" => $newprodname,
			"prodcode" => @$recordval[$head['prodcode']],
			"proddesc" => @$recordval[$head['proddesc']],
			"prodsearchkeywords" => @$recordval[$head['prodsearchkeywords']],
			"prodtype" => $productType,
			"prodprice" => DefaultPriceFormat($recordval[$head['prodprice']]),
			"prodcostprice" => DefaultPriceFormat($recordval[$head['prodcostprice']]),
			"prodretailprice" => DefaultPriceFormat($recordval[$head['prodretailprice']]),
			"prodsaleprice" => DefaultPriceFormat($recordval[$head['prodsaleprice']]),
			"prodavailability" => @$recordval[$head['prodavailability']],
			"prodsortorder" => $recordval[$head['prodsortorder']],
			"prodvisible" => $recordval[$head['prodvisible']],
			"prodfeatured" => $recordval[$head['prodfeatured']],
			"prodrelatedproducts" => $recordval[$head['prodrelatedproducts']],
			"prodinvtrack" => (int)@$recordval[$head['prodinvtrack']],
			"prodcurrentinv" => (int)@$recordval[$head['prodcurrentinv']],
			"prodlowinv" => (int)@$recordval[$head['prodlowinv']],
			"prodoptionsrequired" => $recordval[$head['prodoptionsrequired']],
			"prodwarranty" => @$recordval[$head['prodwarranty']],
			"prodheight" => (float)@$recordval[$head['prodheight']],
			"prodweight" => (float)@$recordval[$head['prodweight']],
			"prodwidth" => (float)@$recordval[$head['prodwidth']],
			"proddepth" => (float)@$recordval[$head['proddepth']],
			"prodfreeshipping" => $recordval[$head['prodfreeshipping']],
			"prodfixedshippingcost" => DefaultPriceFormat(@$recordval[$head['prodfixedshippingcost']]),
			"prodbrandid" => (int)$brandId,
			"prodcats" => $cats,
			"prodpagetitle" => @$recordval[$head['prodpagetitle']],
			"prodmetakeywords" => @$recordval[$head['prodmetakeywords']],
			"prodmetadesc" => @$recordval[$head['prodmetadesc']],
			"prodlayoutfile" => $recordval[$head['prodlayoutfile']],
			"prodistaxable" => $recordval[$head['prodistaxable']],
			'prodvendorid' => $vendorId,
			'prodtags' => $recordval[$head['prodtags']],
			"prodvendorprefix" => $recordval[$head['prodvendorprefix']],
			"proddescfeature" => $recordval[$head['proddescfeature']],
			"prodmfg" => $recordval[$head['prodmfg']],
			"jobberprice" => $recordval[$head['jobberprice']],
			"mapprice" => $recordval[$head['mapprice']],
           	"alternativecategory" => $recordval[$head['alternativecategory']],
			"complementaryupcharge" => $recordval[$head['complementaryupcharge']],
			"ourcost" => $recordval[$head['ourcost']],
            "package_length" => $recordval[$head['package_length']],
			"package_height" => $recordval[$head['package_height']],
			"package_weight" => $recordval[$head['package_weight']],
			"package_width" => $recordval[$head['package_width']],
			"brandseriesid" => $seriesId,
            "future_retail_price" => $recordval[$head['future_retail_price']],
			"future_jobber_price" => $recordval[$head['future_jobber_price']],
			"prod_instruction" => $recordval[$head['prod_instruction']],
			"prod_article" => $recordval[$head['prod_article']],
			"skubarcode" => $recordval[$head['skubarcode']],
            "install_time" => $recordval[$head['install_time']]			

			);

			/**
			 * The variation is part of the product record, so it will have to be attached to the record if this is an
			 * update AND the existing product already has a variation
			 */
			if (is_array($existing) && isId($existing['prodvariationid'])) {
				$productData['prodvariationid'] = $existing['prodvariationid'];
			}

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$productData['prodvendorid'] = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
			}

			$empty = array();

			// Save it
			$err = '';

			if(isset($this->ImportSession['OverrideDuplicates']) && $this->ImportSession['OverrideDuplicates'] == 1) {
				foreach ($productData as $key => $value) {
					if ($value == "" and isset($existing[$key])) $productData[$key] =  $existing[$key];
					if ($value == "<BLANK>" ) $productData[$key] =  "";
				}

				$pricelog = $existing['price_log'];
				$pricelogtime = $existing['price_update_time'];
				$splitprice = split(',',$pricelog);
				$oldprice = end($splitprice);

				if($oldprice != $productData['prodprice']) {
					$productData['price_log'] =  $pricelog.",".$productData['prodprice'];
					$productData['price_update_time'] = date('Y-m-d H:i:s');
				}
				else {
					$productData['price_log'] =  $pricelog;
					$productData['price_update_time'] = $pricelogtime;
				}
				//fixed values in re-import
				$productData['SKU_last_update_time'] = date('Y-m-d H:i:s');
				if ($existing['prodcode'] != "") $productData['prodcode'] = $existing['prodcode'];
				if ($existing['prodvendorid'] != "") $productData['prodvendorid'] = $existing['prodvendorid'];
				if ($existing['prodbrandid'] != "") $productData['prodbrandid'] = $existing['prodbrandid'];

			}


			// temp declaraton to avoid entering in to system log.

			$productData += $defaults;
			foreach ($productData as $key => $value) {
				if (!isset($productData[$key]))  $productData[$key] = "";
			}


			if($this->ImportSession['Importastest'] == 1) {

				$productData['testdata'] = "Yes";
				$productData['prodvisible'] = 0;
			}

			if(isset($recordval[$head['comp_type']]) and $recordval[$head['comp_type']] !== ''){
				$productData['complementary_selection_type'] = (int)@$recordval[$head['comp_type']];
			}


			//error_log("XXXXXXXXXXXXXXXXXXXXX   ". $record['comp_type']);

			$added_or_not = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_CommitImportProduct($productId, $productData, $empty, $empty, $empty, $empty, $err, $empty, true);

			//alandy_20110602.modify the success count.
			if($added_or_not){
				++$this->ImportSession['Results']['SuccessCount'];
			}else{
				++$this->ImportSession['Results']['Imported'];
				return;
			}
			// Is there an existing product with the same SUK + Vendor Prefix? if so, will update the name of the products in products_statistics - Mingxing
			$query = sprintf("SELECT * FROM [|PREFIX|]products_statistics WHERE prodcode='%s' and prodvendorprefix = '".$prodvendorprefix."'  ", $GLOBALS['ISC_CLASS_DB']->Quote($recordval[$head['prodcode']]));
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				if (isset($GLOBALS['NewProductId']) and   $GLOBALS['NewProductId'] != "")
				$productid = $GLOBALS['NewProductId'];
				else
				$productid = $row['productid'];
				$query = sprintf("update [|PREFIX|]products_statistics set prodname='%s', productid='".$productid."', enable=1 where prodcode='%s' and prodvendorprefix = '".$prodvendorprefix."'  ", $newprodname, $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($recordval[$head['prodcode']])));
				$GLOBALS['ISC_CLASS_DB']->Query($query);
				$query = sprintf("update [|PREFIX|]products set prodnumviews='".$row['prodnumviews']."', prodnumsold='".$row['prodnumsold']."', prodratingtotal='".$row['prodratingtotal']."', prodnumratings='".$row['prodnumratings']."'   where  productid='".$productid."'");
				$GLOBALS['ISC_CLASS_DB']->Query($query);
			}
			//end by Mingxing

			if ($added_or_not == 1)
			{
				// there is a problem , if multiple category present


				if (isset($GLOBALS['NewProductId']) and   $GLOBALS['NewProductId'] != "" and !$ShoudOnlyUpdateOtherDetail)
				{
					$sqlinsert2 = "INSERT INTO `isc_import_variations` ( `productid`, `prodcode` , ";
					$values = ") VALUES (".$GLOBALS['NewProductId'].", '".$recordval[$head['prodcode']]."' ,";
										
					for($i = 0; $i < count($selected); $i++) {


						$fieldname = $selected[$i];
						$thevalue = rtrim($record[$fieldname],";");

						$sqlinsert2.= "`".$fieldname."` ,";
						$values.= "'".$thevalue."',";



						// VQenginetype validation checking
						if ($fieldname == "VQenginetype"  and  $thevalue != "")	$thevalue = $engtype;

						// VQliter validation checking
						if ($fieldname == "VQliter"  and  $thevalue != "")	$thevalue = $liter;


						// only for make search fast
						if ($thevalue != "")
						{

							$sql = "INSERT INTO `isc_qualifier_value` (`pid`, `qid`, `q_value` , `row_no`) VALUES ('".$GLOBALS['NewProductId']."', '".$_SESSION['qualifiers_name'][$fieldname]."', '".$thevalue."' , '".$_SESSION['row_no']."')";
							mysql_query($sql);

						}

						// only for made search fast end

					}

				 $_SESSION['row_no']++;


					$sqlinsert2.= "`bedsize_generalname` , `cabsize_generalname` ";
					$values.= "'".$generalize_bedvalue."', '".$generalize_cabvalue."'";

					$joinedsql = $sqlinsert2.$values." ) ";
					
					mysql_query($joinedsql);

					//complementary items  ;
					$recordval[$head['complementaryitems']] = str_replace('�','"',$recordval[$head['complementaryitems']]);
					$recordval[$head['complementaryitems']] = str_replace('�','"',$recordval[$head['complementaryitems']]);
					$comData = array(
						"complementaryitems" => $recordval[$head['complementaryitems']],
						"variationid" => mysql_insert_id(),
						"productid" => $GLOBALS['NewProductId']
					);
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("application_data", $comData);

					$_SESSION['OverRidedInThisImport'][$GLOBALS['NewProductId']] = 1;
					unset($ShoudOnlyUpdateOtherDetail);
				}


			}

			if($productId == 0) {
				$productId = $GLOBALS['NewProductId'];
			}

			// Are there any images?
			if(count($productImages) > 0) {
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_images', "WHERE imageprodid='".$productId."'");
				foreach($productImages as $image) {
					$image['imageprodid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $image);
				}
			}
			// Are there any Install images? blessen
			if(count($productInstallImages) > 0) {
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('install_images', "WHERE imageprodid='".$productId."'");
				foreach($productInstallImages as $image) {
					$image['imageprodid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("install_images", $image);
				}
			}

			// Are there any Install videos ? blessen

			if ($recordval[$head['prodinstallvideo']] != "")
			{
				$productInstallVideos = array();
				$video_pieces = preg_split("/[;,]/", $recordval[$head['prodinstallvideo']]);
				$end = end($video_pieces);
				if(empty($end)) array_pop($video_pieces);

				foreach ($video_pieces as $key => $values)
				{
					$productInstallVideos[] = array(
					"videofile" => $values,
					"videotype" => 1,
					"videoprodid" => $productId
					);

				}

				if(count($productInstallVideos) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('install_videos', "WHERE videoprodid='".$productId."'");
					foreach($productInstallVideos as $video) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("install_videos", $video);
					}
				}
			}


			// Are there any product videos ? blessen audio_clip
			if ($recordval[$head['prodvideo']] != "")
			{
				$productVideos = array();
				$video_pieces = preg_split("/[;,]/", $recordval[$head['prodvideo']]);
				$end = end($video_pieces);
				if(empty($end)) array_pop($video_pieces);

				foreach ($video_pieces as $key => $values)
				{
					$productVideos[] = array(
					"videofile" => $values,
					"videotype" => 1,
					"videoprodid" => $productId
					);

				}

				if(count($productVideos) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_videos', "WHERE videoprodid='".$productId."'");
					foreach($productVideos as $video) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_videos", $video);
					}
				}
			}
			// Are there any product audio_clip ? blessen
			if ($recordval[$head['audio_clip']] != "")
			{
				$product_audio_clip = array();
				$audio_pieces = preg_split("/[;,]/", $recordval[$head['audio_clip']]);
				$end = end($audio_pieces);
				if(empty($end)) array_pop($audio_pieces);

				foreach ($audio_pieces as $key => $values)
				{
					$product_audio_clip[] = array(
					"audiofile" => $values,
					"audiotype" => 1,
					"audioprodid" => $productId
					);

				}

				if(count($product_audio_clip) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('audio_clips', "WHERE audioprodid='".$productId."'");
					foreach($product_audio_clip as $audio) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("audio_clips", $audio);
					}
				}
			}

			// Are there any product article file ? blessen
			if ($record['article_file'] != "")
			{
				$product_article = array();
				$article_pieces = preg_split("/[;,]/", $record['article_file']);
				$end = end($article_pieces);
				if(empty($end)) array_pop($article_pieces);

				foreach ($article_pieces as $key => $values)
				{
					$product_article[] = array(
					"articlefile" => $values,
					"articletype" => 1,
					"articleprodid" => $productId
					);

				}

				if(count($product_article) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('article_files', "WHERE articleprodid='".$productId."'");
					foreach($product_article as $article) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("article_files", $article);
					}
				}
			}

			// Are there any product instruction_file  ? blessen
			if ($record['instruction_file'] != "")
			{
				$product_instruction = array();
				$instruction_pieces = preg_split("/[;,]/", $record['instruction_file']);
				$end = end($instruction_pieces);
				if(empty($end)) array_pop($instruction_pieces);

				foreach ($instruction_pieces as $key => $values)
				{
					$product_instruction[] = array(
					"instructionfile" => $values,
					"instructiontype" => 1,
					"instructionprodid" => $productId
					);

				}

				if(count($product_instruction) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('instruction_files', "WHERE instructionprodid='".$productId."'");
					foreach($product_instruction as $instruction) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("instruction_files", $instruction);
					}
				}

			}


			// Are there any product files?
			if(count($productFiles) > 0) {
				foreach($productFiles as $file) {
					$file['productid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_downloads", $file);
				}
			}

			++$this->ImportSession['Results']['Imported'];
			//alandy_20110612.
			//++$this->ImportSession['Results']['SuccessCount'];
			
	}
	
 protected function ProcessImg(){
	
		$sql="select * from [|PREFIX|]import_products where flag=0 order by tempid asc";
		$query=$GLOBALS['ISC_CLASS_DB']->Query($sql);
		
			
	 while($record=$GLOBALS['ISC_CLASS_DB']->Fetch($query)){
		
	// Do we have a product file? We need to deal with it now damn it!
		if(isset($record['product_file']) && $record['product_file'] != '') {
			// Is this a remote file?
			$downloadDirectory = ISC_BASE_PATH."/".GetConfig('DownloadDirectory');
			if(isc_substr(isc_strtolower($record['product_file']), 0, 7) == "http://") {
				// Need to fetch the remote file
				$file = PostToRemoteFileAndGetResponse($record['product_file']);
				if($file) {
					// Place it in our downloads directory
					$randomDir = strtolower(chr(rand(65, 90)));
					if(!is_dir($downloadDirectory.$randomDir)) {
						if(!@mkdir($downloadDirectory."/".$randomDir, 0777)) {
							$randomDir = '';
						}
					}

					// Generate a random filename
					$fileName = $randomDir . "/" . GenRandFileName(basename($record['product_file']));
					if(!@file_put_contents($downloadDirectory."/".$fileName, $file)) {
						$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductFileUnableToMove');
					}
					else {
						$productFiles[] = array(
							"prodhash" => "",
							"downfile" => $fileName,
							"downdateadded" => time(),
							"downmaxdownloads" => 0,
							"downexpiresafter" => 0,
							"downfilesize" => filesize($downloadDirectory."/".$fileName),
							"downname" => basename($record['product_file']),
							"downdescription" => ""
							);
					}
				}
				else {
					$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductFileDoesntExist');
				}
			}
			// Treating the file as a local file, in the product_fules/import directory
			else {
				// This file exists, can be imported
				if(file_exists($downloadDirectory."/import/".$record['product_file'])) {

					// Move it to our images directory
					$randomDir = strtolower(chr(rand(65, 90)));
					if(!is_dir("../".$downloadDirectory."/".$randomDir)) {
						if(!@mkdir($downloadDirectory."/".$randomDir, 0777)) {
							$randomDir = '';
						}
					}

					// Generate a random filename
					$fileName = $randomDir . "/" . GenRandFileName($record['product_file']);
					if(!@copy($downloadDirectory."/import/".$record['product_file'], $downloadDirectory."/".$fileName)) {
						$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductFileUnableToMove');
					}
					else {
						$productFiles[] = array(
							"prodhash" => "",
							"downfile" => $fileName,
							"downdateadded" => time(),
							"downmaxdownloads" => 0,
							"downexpiresafter" => 0,
							"downfilesize" => filesize($downloadDirectory."/".$fileName),
							"downname" => basename($record['product_file']),
							"downdescription" => ""
							);
					}
				}
				else {
					$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductFileDoesntExist');
				}
			}
		}

		
		// Do we have an image? We need to deal with it before we do anything else
		$productImages = array();
		if(isset($record['product_images']) && $record['product_images'] != '') {
			// Is this a remote file?

			$imageDirectory = ISC_BASE_PATH."/".GetConfig('ImageDirectory');
					
			if(isc_substr(isc_strtolower($record['product_images']), 0, 7) == "http://") {
				// Need to fetch the remote file

				$image_pieces = preg_split("/[;,]/", $record['product_images']);
				$end = end($image_pieces);
						
				if(empty($end)) array_pop($image_pieces);
				
				foreach ($image_pieces as $key => $value)
				{
					$temp_key = $key+1;
					$image = PostToRemoteFileAndGetResponse($value);
									
					if($image) {
						// Place it in our images directory
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir($imageDirectory."/".$randomDir)) {
							if(!@mkdir($imageDirectory."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}

						// Generate a random filename
						$fileName = $randomDir . "/" . GenRandFileName(basename($value));
						
						if(!@file_put_contents($imageDirectory."/".$fileName, $image)) {
							$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageUnableToMove');
						}
						// Check to see if it is an image
						else if (!is_array(@getimagesize($imageDirectory."/".$fileName))) {
							@unlink($imageDirectory."/".$fileName);
							$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageInvalidFile');
						}
						else {

							$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName,"large");
							$productImages[] = array(
							"imagefile" => $thumbName,
							"imageisthumb" => 0,
							"imagesort" =>  $temp_key
							);




							if($hasThumb == false) {
									

								if ($key == 0)
								{

									$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName);
									if($thumbName) {
										$productImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" => 0
										);
									}
									else {
										$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageCorrupt');
									}


									$tinyName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName, "tiny");
									if($tinyName) {
										$productImages[] = array(
									"imagefile" => $tinyName,
									"imageisthumb" => 2,
									"imagesort" => 0
										);
									}
									else {
										$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageCorrupt');
									}
								}
								$mediumName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName, "medium");
								if($mediumName) {
									$productImages[] = array(
									"imagefile" => $mediumName,
									"imageisthumb" => 3,
									"imagesort" => $temp_key
									);
								}
								else {
									$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageCorrupt');
								}

							}
						}
					}
					else {
						$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageDoesntExist');
					}


				}

			}
			// Treating the file as a local file, in the product_images/import directory
			else {
				// This file exists, can be imported

				$image_pieces = preg_split("/[;,]/", $record['product_images']);
				$end = end($image_pieces);
				if(empty($end)) array_pop($image_pieces);

				foreach ($image_pieces as $key => $value)
				{
					$temp_key = $key+1;


					if(file_exists($imageDirectory."/import/".$value)) {

						// Move it to our images directory
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir($imageDirectory."/".$randomDir)) {
							if(!@mkdir($imageDirectory."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}

						// Generate a random filename
						$baseFileName = basename($value);
						if($baseFileName != $value) {
							$localDirectory = dirname($value)."/";
						}
						else {
							$localDirectory = '';
						}
						$fileName = $randomDir . "/" . GenRandFileName($baseFileName);
						if(!@copy($imageDirectory."/import/".$value, $imageDirectory."/".$fileName)) {
							$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageUnableToMove');
						}
						else {
							$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName,"large");

							$productImages[] = array(
							"imagefile" => $thumbName,
							"imageisthumb" => 0,
							"imagesort" => $temp_key
							);

							// Does a thumbnail file exist?
							$thumbFile = "thumb_".$baseFileName;
							if ($key == 0)
							{
								if(file_exists($imageDirectory."/import/".$localDirectory.$thumbFile)) {
									$thumbName = $randomDir . "/" . GenRandFileName($thumbFile);
									if(@copy($imageDirectory."/import/".$localDirectory.$thumbFile, $imageDirectory."/".$thumbName)) {
										$productImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" =>  0
										);
									}
								}
								// Otherwise, generate the thumb
								else {


									$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName);
									if($thumbName) {
										$productImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" => 0
										);
									}


									// Still need to generate "tiny" thumbnail
									$tinyName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName, "tiny");
									if($tinyName) {
										$productImages[] = array(
								"imagefile" => $tinyName,
								"imageisthumb" => 2,
								"imagesort" => 0
										);
									}
								}
							}
							$mediumName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName, "medium");
							if($mediumName) {
								$productImages[] = array(
								"imagefile" => $mediumName,
								"imageisthumb" => 3,
								"imagesort" => $temp_key
								);
							}

						}
					}
					else {
						$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageDoesntExist');
					}

				}

			}
		}

		// Do we have an install image? We need to deal with it after product images added by blessen
		$productInstallImages = array();
		if(isset($record['install_images']) && $record['install_images'] != '') {
			// Is this a remote file?

			$InstallDirectory = ISC_BASE_PATH."/install_images";
			if(isc_substr(isc_strtolower($record['install_images']), 0, 7) == "http://") {
				// Need to fetch the remote file

				$image_pieces = preg_split("/[;,]/", $record['install_images']);
				$end = end($image_pieces);
				if(empty($end)) array_pop($image_pieces);

				foreach ($image_pieces as $key => $value)
				{
					$temp_key = $key+1;
					$image = PostToRemoteFileAndGetResponse($value);
					if($image) {
						// Place it in our images directory
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir($InstallDirectory."/".$randomDir)) {
							if(!@mkdir($InstallDirectory."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}

						// Generate a random filename
						$fileName = $randomDir . "/" . GenRandFileName(basename($value));
						if(!@file_put_contents($InstallDirectory."/".$fileName, $image)) {
							$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageUnableToMove');
						}
						// Check to see if it is an image
						else if (!is_array(@getimagesize($InstallDirectory."/".$fileName))) {
							@unlink($InstallDirectory."/".$fileName);
							$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageInvalidFile');
						}
						else {

							$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName,"large");
							$productInstallImages[] = array(
							"imagefile" => $thumbName,
							"imageisthumb" => 0,
							"imagesort" =>  $temp_key
							);




							if($hasThumb == false) {
									

								if ($key == 0)
								{

									$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName);
									if($thumbName) {
										$productInstallImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" => 0
										);
									}
									else {
										$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageCorrupt');
									}


									$tinyName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName, "tiny");
									if($tinyName) {
										$productInstallImages[] = array(
									"imagefile" => $tinyName,
									"imageisthumb" => 2,
									"imagesort" => 0
										);
									}
									else {
										$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageCorrupt');
									}
								}
								$mediumName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName, "medium");
								if($mediumName) {
									$productInstallImages[] = array(
									"imagefile" => $mediumName,
									"imageisthumb" => 3,
									"imagesort" => $temp_key
									);
								}
								else {
									$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageCorrupt');
								}

							}
						}
					}
					else {
						$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageDoesntExist');
					}


				}




			}
			// Treating the file as a local file, in the product_images/import directory
			else {
				// This file exists, can be imported

				$image_pieces = preg_split("/[;,]/", $record['install_images']);
				$end = end($image_pieces);
				if(empty($end)) array_pop($image_pieces);

				foreach ($image_pieces as $key => $value)
				{
					$temp_key = $key+1;


					if(file_exists($InstallDirectory."/import/".$value)) {

						// Move it to our images directory
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir($InstallDirectory."/".$randomDir)) {
							if(!@mkdir($InstallDirectory."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}

						// Generate a random filename
						$baseFileName = basename($value);
						if($baseFileName != $value) {
							$localDirectory = dirname($value)."/";
						}
						else {
							$localDirectory = '';
						}
						$fileName = $randomDir . "/" . GenRandFileName($baseFileName);
						if(!@copy($InstallDirectory."/import/".$value, $InstallDirectory."/".$fileName)) {
							$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageUnableToMove');
						}
						else {
							$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName,"large");

							$productInstallImages[] = array(
							"imagefile" => $thumbName,
							"imageisthumb" => 0,
							"imagesort" => $temp_key
							);

							// Does a thumbnail file exist?
							$thumbFile = "thumb_".$baseFileName;
							if ($key == 0)
							{
								if(file_exists($InstallDirectory."/import/".$localDirectory.$thumbFile)) {
									$thumbName = $randomDir . "/" . GenRandFileName($thumbFile);
									if(@copy($InstallDirectory."/import/".$localDirectory.$thumbFile, $InstallDirectory."/".$thumbName)) {
										$productInstallImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" =>  0
										);
									}
								}
								// Otherwise, generate the thumb
								else {


									$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName);
									if($thumbName) {
										$productInstallImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" => 0
										);
									}


									// Still need to generate "tiny" thumbnail
									$tinyName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName, "tiny");
									if($tinyName) {
										$productInstallImages[] = array(
								"imagefile" => $tinyName,
								"imageisthumb" => 2,
								"imagesort" => 0
										);
									}
								}
							}
							$mediumName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName, "medium");
							if($mediumName) {
								$productInstallImages[] = array(
								"imagefile" => $mediumName,
								"imageisthumb" => 3,
								"imagesort" => $temp_key
								);
							}

						}
					}
					else {
						$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageDoesntExist');
					}

				}




			}

		}
		
		//fetch the new insert product id.
	   $query ="SELECT productid,prodcode,prodvendorprefix FROM [|PREFIX|]products_statistics WHERE prodcode='".$GLOBALS['ISC_CLASS_DB']->Quote($record['partnumber'])."' and prodvendorprefix = '".$record['vendorprefix']."'";
		
		$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
		
		 while($rs=$GLOBALS['ISC_CLASS_DB']->Fetch($result)){
		 	$productId=$rs['productid'];
		 }
		 
		 if(empty($productId) || $productId==""){
		 	$productid=0;
		 }
		
	 // Are there any images?
			if(count($productImages) > 0) {
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_images', "WHERE imageprodid='".$productId."'");
				foreach($productImages as $image) {
					$image['imageprodid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $image);
				}
			}
			// Are there any Install images? blessen
			if(count($productInstallImages) > 0) {
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('install_images', "WHERE imageprodid='".$productId."'");
				foreach($productInstallImages as $image) {
					$image['imageprodid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("install_images", $image);
				}
			}

			// Are there any Install videos ? blessen

			if ($record['install_video'] != "")
			{
				$productInstallVideos = array();
				$video_pieces = preg_split("/[;,]/", $record['install_video']);
				$end = end($video_pieces);
				if(empty($end)) array_pop($video_pieces);

				foreach ($video_pieces as $key => $values)
				{
					$productInstallVideos[] = array(
					"videofile" => $values,
					"videotype" => 1,
					"videoprodid" => $productId
					);

				}

				if(count($productInstallVideos) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('install_videos', "WHERE videoprodid='".$productId."'");
					foreach($productInstallVideos as $video) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("install_videos", $video);
					}
				}
			}


			// Are there any product videos ? blessen audio_clip
			if ($record['product_video'] != "")
			{
				$productVideos = array();
				$video_pieces = preg_split("/[;,]/", $record['product_video']);
				$end = end($video_pieces);
				if(empty($end)) array_pop($video_pieces);

				foreach ($video_pieces as $key => $values)
				{
					$productVideos[] = array(
					"videofile" => $values,
					"videotype" => 1,
					"videoprodid" => $productId
					);

				}

				if(count($productVideos) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_videos', "WHERE videoprodid='".$productId."'");
					foreach($productVideos as $video) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_videos", $video);
					}
				}
			}
			// Are there any product audio_clip ? blessen
			if ($record['audio_clip'] != "")
			{
				$product_audio_clip = array();
				$audio_pieces = preg_split("/[;,]/", $record['audio_clip']);
				$end = end($audio_pieces);
				if(empty($end)) array_pop($audio_pieces);

				foreach ($audio_pieces as $key => $values)
				{
					$product_audio_clip[] = array(
					"audiofile" => $values,
					"audiotype" => 1,
					"audioprodid" => $productId
					);

				}

				if(count($product_audio_clip) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('audio_clips', "WHERE audioprodid='".$productId."'");
					foreach($product_audio_clip as $audio) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("audio_clips", $audio);
					}
				}
			}

			// Are there any product article file ? blessen
			if ($recordval[$head['article_file']] != "")
			{
				$product_article = array();
				$article_pieces = preg_split("/[;,]/", $recordval[$head['article_file']]);
				$end = end($article_pieces);
				if(empty($end)) array_pop($article_pieces);

				foreach ($article_pieces as $key => $values)
				{
					$product_article[] = array(
					"articlefile" => $values,
					"articletype" => 1,
					"articleprodid" => $productId
					);

				}

				if(count($product_article) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('article_files', "WHERE articleprodid='".$productId."'");
					foreach($product_article as $article) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("article_files", $article);
					}
				}
			}

			// Are there any product instruction_file  ? blessen
			if ($recordval[$head['instruction_file']] != "")
			{
				$product_instruction = array();
				$instruction_pieces = preg_split("/[;,]/", $recordval[$head['instruction_file']]);
				$end = end($instruction_pieces);
				if(empty($end)) array_pop($instruction_pieces);

				foreach ($instruction_pieces as $key => $values)
				{
					$product_instruction[] = array(
					"instructionfile" => $values,
					"instructiontype" => 1,
					"instructionprodid" => $productId
					);

				}

				if(count($product_instruction) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('instruction_files', "WHERE instructionprodid='".$productId."'");
					foreach($product_instruction as $instruction) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("instruction_files", $instruction);
					}
				}

			}


			// Are there any product files?
			if(count($productFiles) > 0) {
				foreach($productFiles as $file) {
					$file['productid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_downloads", $file);
				}
			}
			
		 //when finish image,prodfile,etc. processed,then update the import_products flag=1;
		 $updatesql="update [|PREFIX|]import_products set flag=1 where tempid=".$record['tempid'];
		  $GLOBALS['ISC_CLASS_DB']->Query($updatesql);

	   }
		//this record process over!
	}
	//this function end.
}


class ISC_BATCH_IMPORTER_CUSTOMERS extends ISC_BACTH_IMPORTER_BASE
{
	/**
	 * @var string The type of content we're importing. Should be lower case and correspond with template and language variable names.
	 */
	protected $type = "customers";

	protected $_RequiredFields = array(
		"custconemail"
		);

		public function __construct()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('batch.importer');

			/**
			 * @var array Array of importable fields and their friendly names.
			 */
			$this->_ImportFields = array(
			"custconemail" => GetLang('CustEmail'),
			"custpassword" => GetLang('CustPassword'),
			"custconfirstname" => GetLang('CustFirstName'),
			"custconlastname" => GetLang('CustLastName'),
			"custconcompany" => GetLang('CustCompany'),
			"custconphone" => GetLang('CustPhone'),
			"shipfullname" => GetLang('CustShippingName'),
			"shipfirstname" => GetLang('CustShippingFirstName'),
			"shiplastname" => GetLang('CustShippingLastName'),
			"shipaddress1" => GetLang('CustShippingAddress1'),
			"shipaddress2" => GetLang('CustShippingAddress2'),
			"shipcity" => GetLang('CustShippingCity'),
			"shipzip" => GetLang('CustShippingZip'),
			"shipstate" => GetLang('CustShippingState'),
			"shipcountry" => GetLang('CustShippingCountry'),
			"shipphone" => GetLang('CustShippingPhone'),
			'custstorecredit' => GetLang('StoreCredit'),
			'custgroup' => GetLang('CustomerGroup'),
			);

			/**
			 * Tag on the customer and address custom fields
			 */
			$fields = array();
			$fields += $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ACCOUNT);
			$fields += $GLOBALS['ISC_CLASS_FORM']->getFormFields(FORMFIELDS_FORM_ADDRESS);

			if (is_array($fields) && !empty($fields)) {
				$this->_ImportFields['custom'] = array();

				foreach (array_keys($fields) as $fieldId) {
					if ($fields[$fieldId]->record['formfieldprivateid'] !== '') {
						continue;
					}

					$this->_ImportFields['custom'][$fieldId] = htmlentities($fields[$fieldId]->record['formfieldlabel']);
				}
			}

			parent::__construct($fields);
		}

		/**
		 * Custom step 1 code specific to product importing. Calls the parent ImportStep1 funciton.
		 */
		protected function _ImportStep1($MsgDesc="", $MsgStatus="")
		{
			if ($MsgDesc != "" && !isset($GLOBALS['Message'])) {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			// Set up generic import options
			parent::_ImportStep1();
		}

		/**
		 * Custom step 2 code specific to product importing. Calls the parent ImportStep2 funciton.
		 */
		protected function _ImportStep2($MsgDesc="", $MsgStatus="")
		{
			// Set up generic import options

			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			parent::_ImportStep2();
		}

		/**
		 * Imports an actual product record in to the database.
		 *
		 * @param array Array of record data
		 */
		protected function _ImportRecord($record)
		{
			if(!$record['custconemail']) {
				$this->ImportSession['Results']['Failures'][] = implode(",", $record['original_record'])." ".GetLang('ImportCustomersMissingEmail');
				return;
			}

			if(!is_email_address($record['custconemail'])) {
				$this->ImportSession['Results']['Failures'][] = implode(",", $record['original_record'])." ".GetLang('ImportCustomersInvalidEmail');
				return;
			}

			$fillin = array('custconcompany', 'custconfirstname', 'custconlastname', 'custconphone');
			foreach ($fillin as $fillkey) {
				if (!isset($record[$fillkey])) {
					$record[$fillkey] = '';
				}
			}

			// Is there an existing customer with the same email?
			$customerId = 0;
			$existingFormSessionId = 0;
			$query = sprintf("select customerid from [|PREFIX|]customers where lower(custconemail)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($record['custconemail'])));
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				// Overriding existing products, set the product id
				if(isset($this->ImportSession['OverrideDuplicates']) && $this->ImportSession['OverrideDuplicates'] == 1) {
					$customerId = $row['customerid'];
					$this->ImportSession['Results']['Updates'][] = $record['custconfirstname']." ".$record['custconlastname']." (".$record['custconemail'].")";
				}
				else {
					$this->ImportSession['Results']['Duplicates'][] = $record['custconfirstname']." ".$record['custconlastname']." (".$record['custconemail'].")";
					return;
				}

				if (isId($row['custformsessionid'])) {
					$existingFormSessionId = $row['custformsessionid'];
				}
			}

			$customerData = array(
			'company' => $record['custconcompany'],
			'firstname' => $record['custconfirstname'],
			'lastname' => $record['custconlastname'],
			'email' => $record['custconemail'],
			'phone' => $record['custconphone']
			);

			if (isset($record['custpassword']) && $record['custpassword'] !== '') {
				$customerData['password'] = $record['custpassword'];
			}

			if(isset($record['custstorecredit'])) {
				$customerData['storecredit'] = DefaultPriceFormat($record['custstorecredit']);
			}

			if (isId($customerId)) {
				$customerData['customerid'] = $customerId;
			}

			// Are we placing the customer in a customer group?
			$groupId = 0;
			if(!empty($record['custgroup'])) {
				static $customerGroups;
				$groupName = strtolower($record['custgroup']);
				if(isset($customerGroups[$groupName])) {
					$groupId = $customerGroups[$groupName];
				}
				else {
					$query = "
					SELECT customergroupid
					FROM [|PREFIX|]customer_groups
					WHERE LOWER(groupname)='".$GLOBALS['ISC_CLASS_DB']->Quote($groupName)."'
				";
					$groupId = $GLOBALS['ISC_CLASS_DB']->FetchOne($query, 'customergroupid');
					// Customer group doesn't exist, create it
					if(!$groupId) {

						$newGroup = array(
						'name' => $record['custgroup'],
						'discount' => 0,
						'isdefault' => 0,
						'categoryaccesstype' => 'all'
						);
						$entity = new ISC_ENTITY_CUSTOMERGROUP();
						$groupId = $entity->add($newGroup);
					}

					if($groupId) {
						$customerGroups[$groupName] = $groupId;
					}
				}
			}
			$customerData['customergroupid'] = $groupId;

			// Do we have a shipping address?
			$shippingData = array();

			if(isset($record['shipfullname']) || isset($record['shipfirstname']) || isset($record['shipaddress1']) || isset($record['shipaddress2']) || isset($record['shipcity']) || isset($record['shipstate']) || isset($record['shipzip']) || isset($record['shipcountry'])) {

				$fillin = array('shipaddress1', 'shipaddress2', 'shipcity', 'shipstate', 'shipzip', 'shipcountry');
				foreach ($fillin as $fillkey) {
					if (!isset($record[$fillkey])) {
						$record[$fillkey] = '';
					}
				}

				$shippingData['shipfirstname'] = '';
				$shippingData['shiplastname'] = '';
				$shippingData['shipaddress1'] = $record['shipaddress1'];
				$shippingData['shipaddress2'] = $record['shipaddress2'];
				$shippingData['shipcity'] = $record['shipcity'];
				$shippingData['shipstate'] = $record['shipstate'];
				$shippingData['shipzip'] = $record['shipzip'];
				$shippingData['shipcountry'] = $record['shipcountry'];
				$shippingData['shipstateid'] = 0;
				$shippingData['shipcountryid'] = 0;
				$shippingData['shipdestination'] = '';

				// Find the country and state
				$shippingData['shipcountryid'] = (int)GetCountryByName($record['shipcountry']);
				if(!$shippingData['shipcountryid']) {
					$shippingData['shipcountryid'] = (int)GetCountryIdByISO2($record['shipcountry']);
				}

				// Still nothing? 0 for the shipping country ID
				if(!$shippingData['shipcountryid']) {
					$shippingData['shipcountryid'] = 0;
				}

				if(isset($record['shipstate'])) {
					$shippingData['shipstateid'] = GetStateByName($record['shipstate'], $shippingData['shipcountryid']);
				}

				// Still nothing? 0 for the shipping state ID
				if(!$shippingData['shipstateid']) {
					$shippingData['shipstateid'] = 0;
				}

				if(!isset($record['shipfullname']) || $record['shipfullname'] == "") {
					if(isset($record['shipfirstname']) && $record['shipfirstname'] != '') {
						$shippingData['shipfirstname'] = $record['shipfirstname'];
					}
					else {
						$shippingData['shipfirstname'] = $customerData['firstname'];

					}

					if(isset($record['shiplastname']) && $record['shiplastname'] != '') {
						$shippingData['shiplastname'] = $record['shiplastname'];
					}
					else {
						$shippingData['shiplastname'] = $customerData['lastname'];
					}
				}

				if(!isset($record['shipphone']) && isset($record['custconphone'])) {
					$shippingData['shipphone'] = $record['custconphone'];
				}
				else {
					$shippingData['shipphone'] = $record['shipphone'];
				}

				/**
				 * Handle any of the address custom fields that we might have
				 */
				if (!empty($this->customFields) && array_key_exists('custom', $record)) {
					$shippingData['shipformsessionid'] = $this->_importCustomFormfields(FORMFIELDS_FORM_ADDRESS, $record['custom']);

					if (!isId($shippingData['shipformsessionid'])) {
						unset($shippingData['shipformsessionid']);
					}
				}
			}

			/**
			 * Handle any of the customer custom fields that we might have
			 */
			if (!empty($this->customFields) && array_key_exists('custom', $record)) {
				$formSessionId = $this->_importCustomFormfields(FORMFIELDS_FORM_ACCOUNT, $record['custom'], $existingFormSessionId);

				if (isId($formSessionId)) {
					$customerData['custformsessionid'] = $formSessionId;
				}
			}

			$customerData['is_import'] = true;

			$customerEntity = new ISC_ENTITY_CUSTOMER();

			// New customer, insert in to DB
			if($customerId == 0) {
				// Set a temporary password, retrievable later via lost password function
				if(!isset($customerData['password']) || $customerData['password'] == '') {
					$customerData['password'] = isc_substr(uniqid(rand(), true), 0, 10);
				}

				$customerData['token'] = GenerateCustomerToken();
				$customerData['shipping_address'] = $shippingData;

				$rtn = $customerEntity->add($customerData);
				++$this->ImportSession['Results']['SuccessCount'];
			}
			// Updating an existing customer
			else {
				if(count($shippingData) > 0) {
					$query = sprintf("select shipid from [|PREFIX|]shipping_addresses where shipcustomerid='%d' and lower(shipaddress1)='%s' and lower(shipaddress2)='%s' and lower(shipcity)='%s' and lower(shipstate)='%s' and lower(shipcountry)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($customerId), $GLOBALS['ISC_CLASS_DB']->Quote($shippingData['shipaddress1']), $GLOBALS['ISC_CLASS_DB']->Quote($shippingData['shipaddress2']), $GLOBALS['ISC_CLASS_DB']->Quote($shippingData['shipcity']), $GLOBALS['ISC_CLASS_DB']->Quote($shippingData['shipstate']), $GLOBALS['ISC_CLASS_DB']->Quote($shippingData['shipcountry']));
					$Result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					$row = $GLOBALS['ISC_CLASS_DB']->Fetch($Result);

					// Address doesn't exist, we insert it
					if(!$row['shipid']) {
						$customerData['shipping_address'] = $shippingData;
					}
				}

				$rtn = $customerEntity->edit($customerData);
			}
		}
}



class ISC_BATCH_IMPORTER_TRACKING_NUMBERS extends ISC_BACTH_IMPORTER_BASE
{
	/**
	 * @var string The type of content we're importing. Should be lower case and correspond with template and language variable names.
	 */
	protected $type = "ordertrackingnumbers";

	protected $_RequiredFields = array(
		"ordernumber",
		"ordertrackingnumber"
		);

		public function __construct()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('batch.importer');

			/**
			 * @var array Array of importable fields and their friendly names.
			 */
			$this->_ImportFields = array(
			"ordernumber" => GetLang('OrderNumber'),
			"ordertrackingnumber" => GetLang('OrdTrackingNo'),
            "orddateshipped" => "Shipping Date"
            );

            parent::__construct();
		}

		/**
		 * Custom step 1 code specific to tracking number importing. Calls the parent ImportStep1 funciton.
		 */
		protected function _ImportStep1($MsgDesc="", $MsgStatus="")
		{
			if ($MsgDesc != "" && !isset($GLOBALS['Message'])) {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}
			// Set up generic import options
			parent::_ImportStep1();
		}

		/**
		 * Custom step 2 code specific to product importing. Calls the parent ImportStep2 funciton.
		 */
		protected function _ImportStep2($MsgDesc="", $MsgStatus="")
		{
			// Set up generic import options
			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}
			$this->ImportSession['updateOrderStatus'] = $_POST['updateOrderStatus'];
			parent::_ImportStep2();
		}

		/**
		 * Imports an tracking numbers in to the database.
		 *
		 * @param array Array of record data
		 */
		protected function _ImportRecord($record)
		{
			if(trim($record['ordernumber']) == "") {
				$this->ImportSession['Results']['Failures'][] = implode(",", $record['original_record'])." ".GetLang('ImportMissingOrderNumber');
				return;
			}

			$record['ordertrackingnumber'] = trim($record['ordertrackingnumber']);
			if($record['ordertrackingnumber'] == "") {
				$this->ImportSession['Results']['Failures'][] = implode(",", $record['original_record'])." ".GetLang('ImportMissingTrackingNumber');
				return;
			}

			if(isc_strlen($record['ordertrackingnumber']) > 100) {
				$this->ImportSession['Results']['Failures'][] = implode(",", $record['original_record'])." ".GetLang('ImportTrackingNumberTooLong');
				return;
			}

			// Does the order number exist in the database?
			$query = "SELECT orderid, ordtrackingno, ordvendorid FROM [|PREFIX|]orders WHERE orderid='".(int)$record['ordernumber']."'";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$order = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if(!$order['orderid']) {
				$this->ImportSession['Results']['Failures'][] = implode(",", $record['original_record'])." ".GetLang('ImportInvalidOrderNumber');
				return;
			}

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() != $order['ordvendorid']) {
				$this->ImportSession['Results']['Failures'][] = implode(",", $record['original_record'])." ".GetLang('ImportInvalidOrderNumber');
				return;
			}

			// Does this order already have a tracking number?
			if($order['ordtrackingno']) {
				// Overriding existing tracking number
				if(isset($this->ImportSession['OverrideDuplicates']) && $this->ImportSession['OverrideDuplicates'] == 1) {
					$this->ImportSession['Results']['Updates'][] = $record['ordernumber']." ".$record['ordertrackingnumber'];
				}
				else {
					$this->ImportSession['Results']['Duplicates'][] = $record['ordernumber']." ".$record['ordertrackingnumber'];
					return;
				}
			}

			$orderData = array(
			"ordtrackingno" => $record['ordertrackingnumber'],
			);

			/* Added for to import ship date to db -- Baskaran */
			$record['orddateshipped'] = strtotime($record['orddateshipped']);
			if($record['orddateshipped'] == "") {
				$this->ImportSession['Results']['Failures'][] = implode(",", $record['original_record'])." ".GetLang('ImportMissingShipdate');
				return;
			}

			$orderData['orddateshipped'] = $record['orddateshipped'];
			/* Code Ends*/
			if (isset($this->ImportSession['updateOrderStatus']) && $this->ImportSession['updateOrderStatus']!=0) {
				$orderData['ordstatus'] = (int) $this->ImportSession['updateOrderStatus'];
			}
			if ($record['ordernumber'] > 0) {
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("orders", $orderData, "orderid='".$order['orderid']."'");
				++$this->ImportSession['Results']['SuccessCount'];
			} else {
				$this->ImportSession['Results']['Failures'][] = implode(",", $record['original_record'])." ".GetLang('ImportInvalidOrderNumber');
				return;
			}
		}

		/*
			The below function updates the price of the product through background process.
			param1 : discount	(	This string is used to to know the type	)
			param2 : discountid (	This is used to update the products under that discount id	)
			*/


}



?>