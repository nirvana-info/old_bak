<?php
define("ITEMS_PER_PAGE", 15);

require_once(APP_ROOT . "/includes/exporter/class.exportfiletype.factory.php");
require_once(APP_ROOT . "/includes/exporter/class.exportmethod.factory.php");

class ISC_ADMIN_EXPORT
{
	private $templates;
	private $type;
	private $title;
	private $type_title;

	private $filetype;
	private $vendorid = 0;

	public function HandleToDo($do)
	{
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('export');
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('exporttemplates');

		$this->templates = GetClass('ISC_ADMIN_EXPORTTEMPLATES');
		$this->type = isc_strtolower($_GET['t']);

		// load the file type for this export
		if (!$this->filetype = ISC_ADMIN_EXPORTFILETYPE_FACTORY::GetExportFileType($this->type)) {
			FlashMessage(GetLang("InvalidType"), MSG_ERROR, 'index.php?ToDo=viewExportTemplates');
		}

		// does user have permission to export this type?
		if (!$this->filetype->HasPermission() || !gzte11(ISC_MEDIUMPRINT)) {
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
		}

		$details = $this->filetype->GetTypeDetails();
		$title = $details['title'];
		$this->type_title = $title;
		$this->title = sprintf(GetLang("ExportTitle"), $title);

		$this->vendorid = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();

		switch (isc_strtolower($do)) {
			case 'startexport':
				$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", $title => $details['viewlink'], GetLang('Export') => "");

				if (!isset($_REQUEST['ajax'])) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				}

				$this->StartExport();

				if (!isset($_REQUEST['ajax'])) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				}

				break;
			case 'runexport':
				$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Export') => "", $title => "");

				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->RunExport();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
		}
	}

	/**
	* Builds a select box for templates. Templates are grouped by, built in and vendor
	*
	* @param mixed $type
	* @param mixed $templateid
	*/
	private function BuildTemplatesSelect($type, $templateid = 0)
	{
		$has_templates = false;

		$html = "<select id=\"template\" name=\"template\" size=\"8\" class=\"Field200\" >
		";

		//<option value=\"\">" . GetLang("SelectTemplate") . "</option>

		$result = $this->templates->GetTemplates(false, true);
		if ($GLOBALS['ISC_CLASS_DB']->CountResult($result)) {
			$has_templates = true;

			$html .= "<optgroup label=\"" . GetLang("BuiltInTemplates") . "\">";
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				if (!in_array($type, explode(",", $row['usedtypes']))) {
					continue;
				}

				if ($row["exporttemplateid"] == $templateid) {
					$row_selected = " selected=\"selected\"";
				}
				else {
					$row_selected = "";
				}

				$html .= "<option value=\"" . $row["exporttemplateid"] . "\"" . $row_selected . ">" . $row["exporttemplatename"] . "</option>";
			}
			$html .= "</optgroup>";
		}

		$result = $this->templates->GetTemplates(true, false);
		if ($GLOBALS['ISC_CLASS_DB']->CountResult($result)) {
			$has_templates = true;

			$lastvendor = "";

			$has_mytemplates = false;
			$first_vendor = true;

			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				if (!in_array($type, explode(",", $row['usedtypes']))) {
					continue;
				}
				$has_mytemplates = true;

				if ($row['vendorid'] != $lastvendor) {
					if ($row['vendorid'] == 0 || $this->vendorid) {
						$vendorname = GetLang("MyTemplates");
					}
					else {
						$vendorname = $row['vendorname'];
					}

					if (!$first_vendor) {
						$html .= "</optgroup>";
					}

					$html .= "<optgroup label=\"" . $vendorname . "\">";

					$first_vendor = false;
				}

				if ($row["exporttemplateid"] == $templateid) {
					$row_selected = " selected=\"selected\"";
				}
				else {
					$row_selected = "";
				}

				$html .= "<option value=\"" . $row["exporttemplateid"] . "\"" . $row_selected . ">" . $row["exporttemplatename"] . "</option>";

				$lastvendor = $row['vendorid'];
			}

			if ($has_mytemplates) {
				$html .= "</optgroup>";
			}
		}

		if (!$has_templates) {
			throw new Exception(GetLang("NoExportTemplatesFound"));
		}

		return $html;
	}


	/**
	* Gets a grid of data for the current export
	*
	* @param string $where The WHERE statement to use to get the data
	*/
	private function GetGrid($where = "")
	{
		// get current page
		if (isset($_GET['page'])) {
			$page = (int)$_GET['page'];
		} else {
			$page = 1;
		}

		// Limit the number of orders returned
		if ($page == 1) {
			$start = 1;
		} else {
			$start = ($page * ITEMS_PER_PAGE) - (ITEMS_PER_PAGE - 1);
		}

		$start = $start - 1;

		// set sort order
		if(isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'asc') {
			$sortOrder = 'asc';
		}
		else {
			$sortOrder = "desc";
		}

		$sortLinks = $this->filetype->GetListSortLinks();

		// get the field to sort on
		if(isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
			$sortField = $_GET['sortField'];
			SaveDefaultSortField("Export" . $this->type, $_REQUEST['sortField'], $sortOrder);
		}
		else {
			list($sortField, $sortOrder) = GetDefaultSortField("Export" . $this->type, current($sortLinks), $sortOrder);
		}

		$sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
		$GLOBALS['SortURL'] = $sortURL;

		$GLOBALS['SortField'] = $sortField;
		$GLOBALS['SortOrder'] = $sortOrder;

		BuildAdminSortingLinks($sortLinks, "index.php?ToDo=startExport" . $this->GetSearchURL(true) . "&amp;page=" . $page, $sortField, $sortOrder);

		// get the icon to show for this type
		//$details = $this->filetype->GetTypeDetails();
		//$GLOBALS['TypeIcon'] = $details['icon'];

		// get number of records total
		$query = $this->filetype->GetListCountQuery($where, $this->vendorid);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		$total_items = $row['ListCount'];

		$GLOBALS['DataSummary'] = sprintf(GetLang("ExportSummary"), number_format($total_items), isc_strtolower($this->type_title));

		// generate navigation links
		$this->GetNav($page, $total_items);

		// get the query to list the data
		$query = $this->filetype->GetListQuery($where, $this->vendorid, $sortField, $sortOrder);
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, ITEMS_PER_PAGE);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		if (!$GLOBALS['ISC_CLASS_DB']->CountResult($result)) {
			throw new Exception(sprintf(GetLang("NoDataFound"), isc_strtolower($this->type_title)));
		}

		// get the columns to display in the grid
		$columns = $this->filetype->GetListColumns();

		$sortKeys = array_keys($sortLinks);

		// modify columns to include a sort link
		$new_columns = array();
		foreach ($columns as $x => $value) {
			$new_columns[] = $value . " &nbsp; %%GLOBAL_SortLinks" . $sortKeys[$x] . "%%";
		}

		$GLOBALS['ColSpan'] = count($columns) + 1;

		$gridData = "<tr class=\"Heading3\">\n" . $this->BuildTableRow($new_columns) . "\n</tr>";

		$gridData = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseGL($gridData);

		// Build the items for the grid
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			// get a formatted row
			$output = $this->filetype->GetListRow($row);

			$new_row = $output;
			foreach ($output as $id => $value) {
				if (!$value) {
					$new_row[$id] = "N/A";
				}
			}

			$GLOBALS['RowData'] = $this->BuildTableRow($new_row);

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("export.grid.row");
			$gridData .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		return $gridData;
	}

	/**
	* Builds a table row from an array of data
	*
	* @param mixed $row
	*/
	private function BuildTableRow($row)
	{
		$html = "";

		foreach ($row as $column => $value) {
			$html .= "\n<td style=\"height: 21px;\">" . $value . "</td>";
		}

		return $html;
	}

	private function GetSearchURL($remove_sort = false)
	{
		// Build the pagination URL
		$searchURL = '';
		foreach($_GET as $k => $v) {
			if ($k == "ToDo" || $k == "page" || !$v) {
				continue;
			}
			if ($remove_sort && ($k == "sortField" || $k == "sortOrder")) {
				continue;
			}
			$searchURL .= sprintf("&amp;%s=%s", $k, urlencode($v));
		}

		if (isset($_POST[$this->type])) {
			$searchURL .= "&amp;ids=" . urlencode(implode(",", $_POST[$this->type]));
		}

		return $searchURL;
	}


	/**
	* Builds the pagination and navigation links
	*
	* @param int $page The current page we're on
	* @param int $total_items The total number of items to be paginated
	*/
	private function GetNav($page, $total_items)
	{
		$searchURL = $this->GetSearchURL();

		$numPages = ceil($total_items / ITEMS_PER_PAGE);

		// Add the "(Page x of n)" label
		if($total_items > ITEMS_PER_PAGE) {
			$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

			$GLOBALS['Nav'] .= BuildPagination($total_items, ITEMS_PER_PAGE, $page, "index.php?ToDo=startExport" . $searchURL);
		}
		else {
			$GLOBALS['Nav'] = "";
		}

		$GLOBALS['Nav'] = rtrim($GLOBALS['Nav'], ' |');
	}

	private function StartExport()
	{
		$GLOBALS['ExportIntro'] = sprintf(GetLang("ExportIntro"), isc_strtolower($this->type_title));
		$GLOBALS['hiddenFields'] = sprintf("<input type='hidden' name='type' value='%s'>", $this->type);

		$templateid = 0;
		if (isset($_GET["tempId"])) {
			$templateid = (int)$_GET["tempId"];
		}

		$GLOBALS['TemplateTitle'] = $this->title;

		try {
			$GLOBALS['TemplatesList'] = $this->BuildTemplatesSelect($this->type, $templateid);

			$where = "";

			$details = $this->filetype->GetTypeDetails();

			// were specific records selected?
			if (isset($_POST[$this->type])) {
				$ids = $_POST[$this->type];
			}
			elseif (isset($_REQUEST["ids"])) {
				$ids = explode(",", urldecode($_REQUEST["ids"]));
			}

			if (isset($ids)) {
				// get the id field for this type
				$idfield = $details['idfield'];

				$where = $idfield . " IN (" . implode(', ', array_map(array($GLOBALS['ISC_CLASS_DB'], "Quote"), $ids)) . ")";

				$GLOBALS['hiddenFields'] .= sprintf("<input type='hidden' name='ids' value='%s'>", implode(",", $ids));
			}
			elseif (isset($_REQUEST['searchId']) && $_REQUEST['searchId']) { // was a custom view/search used?
				$searchId = $_REQUEST['searchId'];
				$GLOBALS['hiddenFields'] .= sprintf("<input type='hidden' name='searchId' value='%s'>", $_REQUEST['searchId']);

				// get the where statement for this search
				$ret = $this->filetype->GetWhereFromSearch($searchId);
				$where = $ret["where"];
				//$GLOBALS['TemplateTitle'] .= " - " . $ret['name'];
			}
			else {
				//$GLOBALS['TemplateTitle'] .= " - " . sprintf(GetLang("AllData"), ucfirst($this->type));
				$params = $this->GetParams();
				if (count($params)) {
					$GLOBALS['hiddenFields'] .= sprintf("<input type='hidden' name='params' value='%s'>", http_build_query($params));

					$where = $this->filetype->GetWhereFromParams($params);
				}
			}

			// Generate the grid
			$GLOBALS['GridData'] = $this->GetGrid($where);
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("export.grid");
			$GLOBALS['DataGrid'] = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);

			if (isset($_REQUEST['ajax'])) {
				echo $GLOBALS['DataGrid'];
				die;
			}

			// create a list of methods the user can choose from
			$methods = ISC_ADMIN_EXPORTMETHOD_FACTORY::GetExportMethodList();
			$method_list = "";

			$GLOBALS['MethodChecked'] = "checked=\"checked\"";

			foreach ($methods as $file => $method) {
				//$GLOBALS['MethodIcon'] = $method['icon'];
				$GLOBALS['MethodName'] = $method['name'];
				$GLOBALS['MethodTitle'] = $method['title'];
				$GLOBALS['MethodHelp'] = $method['help'];

				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("export.method");
				$method_list .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);

				$GLOBALS['MethodChecked'] = "";
			 }

			 $GLOBALS['Methods'] = $method_list;

			 $GLOBALS['ViewLink'] = $details['viewlink'];
		}
		catch (Exception $ex) {
			FlashMessage($ex->getMessage(), MSG_ERROR);

			$GLOBALS['HideForm'] = "display: none;";
		}

		$GLOBALS['Message'] = GetFlashMessageBoxes();
		$GLOBALS['FormAction'] = "runExport&t=" . $this->type;

		$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("export.step1");
		$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
	}

	private function RunExport()
	{
		try {
			// check for a selected template
			if (!isset($_POST["template"]) || !$_POST["template"]) {
				throw new Exception(GetLang("NoTemplateSelected"));
			}

			if (!isset($_POST['format'])) {
				throw new Exception(GetLang("NoMethodSelected"));
			}

			$templateid = $_POST["template"];

			// check template exists
			$template = $this->templates->GetTemplate($templateid);

			// check the file type is available for this template
			if (!in_array($this->type, explode(",", $template['usedtypes']))) {
				throw new Exception(sprintf(GetLang("TypeNotAvailable"), $this->type));
			}

			$where = "";

			// get the custom search fields
			if (isset($_POST['ids'])) {
				$ids = explode(',', $_POST['ids']);
				$ids = implode(', ', array_map(array($GLOBALS['ISC_CLASS_DB'], "Quote"), $ids));

				$details = $this->filetype->GetTypeDetails();
				$where = $details['idfield'] . " IN (" . $_POST["ids"] . ")";
			}
			elseif (isset($_POST['searchId'])) {
				// get the where statement for this search
				$ret = $this->filetype->GetWhereFromSearch($_POST['searchId']);
				$where = $ret['where'];
			}
			elseif (isset($_POST['params'])) {
				$params = $this->GetParams($_POST['params']);
				$where = $this->filetype->GetWhereFromParams($params);
			}

			// get the export method the user has chosen
			$method = ISC_ADMIN_EXPORTMETHOD_FACTORY::GetExportMethod($_POST['format']);
			$method_details = $method->GetMethodDetails();

			// Initialise the export
			$method->Init($this->filetype, $templateid, $where, $this->vendorid);

			$details = $this->filetype->GetTypeDetails();
			if ($_POST['format'] == "CSV" && $details['name'] == "customers" && $method->settings['AltCustomers']) {
				// hackery to use alternate customers class
				$this->filetype = ISC_ADMIN_EXPORTFILETYPE_FACTORY::GetExportFileType("customersalt");

				// reinitialise the method with alternate file type
				$method->Init($this->filetype, $templateid, $where, $this->vendorid);
			}

			// run the export
			$file = $method->Export();

			// log the export
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($this->type_title, $template['exporttemplatename'], $method_details['name']);

			// send the file to the user
			DownloadFile($file, $this->type . "-" . isc_date("Y-m-d") . "." . $method_details['extension']);

			exit;
		}
		catch (Exception $ex) {
			FlashMessage($ex->getMessage(), MSG_ERROR);
			$this->StartExport();
		}
	}

	private function GetParams($query_string = "")
	{
		if (!$query_string) {
			$query_string = $_SERVER['QUERY_STRING'];
		}

		$query_params = explode('&', $query_string);
		$params = array();
		$ignore = array("ToDo", "t", "tempId", "searchId");
		foreach ($query_params as $param) {
			$arr = explode("=", $param);
			if (!in_arrayi($arr[0], $ignore)) {
				$params[$arr[0]] = $arr[1];
			}
		}

		return $params;
	}
}
?>