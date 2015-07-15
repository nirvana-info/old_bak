<?php
require_once(ISC_BASE_PATH.'/lib/form.php');

/**
* Abstract class that represents a file/data type that can be exported
*
* @author Ray Ward <ray.ward@interspire.com>
*/
abstract class ISC_ADMIN_EXPORTFILETYPE
{
	protected $exporttemplates; // the export templates class

	public $template; 			// the export template used for this export
	protected $templateid;		// the template id

	protected $fields; 			// the array of fields that define the data in this type

	protected $dateformat;		// the format for date fields
	protected $boolformat;		// the format for boolean fields
	protected $blankforfalse;	// should false values be changed to a blank/empty string?

	protected $exportmethod; 	// the export method object that's exporting this file type

	private $result;			// stored data query result for the export

	protected $type_name;		// the name of this file type
	protected $type_icon;		// an icon to display for the type
	protected $type_idfield;	// the database id field for a record of this data type
	protected $type_title;		// the title of the type
	protected $type_viewlink;	// a link back to the 'view/list' page for the type

	public $ignore = false;

	public $where;


	public function __construct()
	{ 
		
		// common language
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('export.filetype');
		// load language for this type
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('export.filetype.' . strtolower($this->type_name));

		$this->type_title = GetLang("TypeTitle");
	}

	/**
	* Initialises this file type for exporting. Queries for the data and stores the result.
	*
	* @param ISC_ADMIN_EXPORTMETHOD The export method exporting this type
	* @param int The template to use in conjunction with this type
	* @param string A WHERE clause to filter the data being exported
	* @param int The vendor to restrict queried data for
	*/
	public function Init(ISC_ADMIN_EXPORTMETHOD $exportmethod, $templateid, $where, $vendorid)
	{


		$this->exportmethod = $exportmethod;
		$this->templateid = $templateid;
		$this->where  = $where;
		SetupCurrency();

		// load the export template
		$this->exporttemplates = GetClass("ISC_ADMIN_EXPORTTEMPLATES");
		$this->template = $this->exporttemplates->GetTemplate($templateid);

		$formats = $this->exporttemplates->GetDateFormats();
		$this->dateformat = $formats[$this->template['dateformat']]["format"];
		$this->boolformat = $this->template['boolformat'];
		$this->blankforfalse = (bool)$this->template['blankforfalse'];

		$this->fields = $this->LoadFields($this->templateid);

		// perform any custom work on the fields
		$this->PostFieldLoad();

		// execute the query


		 

	
	}
	/**
	* Gets an array of details identifying this export file type
	*
	* @return array The array of details about this type
	*/
	public function GetTypeDetails()
	{
		$details = array(
			"name" 		=> $this->type_name,
			"icon" 		=> $this->type_icon,
			"idfield" 	=> $this->type_idfield,
			"title" 	=> $this->type_title,
			"viewlink"	=> $this->type_viewlink
		);

		return $details;
	}

	/**
	* Builds a string list of the fields to be queried
	*
	* @return string Comma delimited list of database fields
	*/
	public function ConstructFieldList()
	{
		$list = "";
		foreach ($this->fields as $id => $field) {
			if (isset($field['dbfield']) && $field['used']) {
				if ($list) {
					$list .= ",\n";
				}
				$list .= $field['dbfield'] . " AS " . $id;
			}
		}

		return $list;
	}

	/**
	* Iterates through the rows in the result and exports them.
	* Performs any formatting as defined in the fields and then does custom handling that might be required by each type.
	*
	*/
public function ExportRows_Orders_Customer()
	{

			$where = $this->where;
			$vendorid = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();



		$dummy = $this->CreateDummyRow($this->fields);


		$query = $this->GetQuery($this->ConstructFieldList(), $where, $vendorid);
		$this->result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($this->result)) {
			// map the data from the db row to the dummy row
			$new_row = $this->MapRow($row, $dummy);

			// perform any custom work on the row and write it the export method
			$new_row = $this->HandleRow($new_row);

			$new_row = $this->RemoveExtraFields($new_row);

			// format the data
			$this->FormatColumns($new_row);

			// write the row using the export method
			$this->exportmethod->WriteRow($new_row);
		}
	}



	public function ExportRows()
	{


$where = $this->where;


$allvendor = array();
$query1 ="select vendorid , vendorname from [|PREFIX|]vendors  ";
$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
 while ($row1 = $GLOBALS['ISC_CLASS_DB']->Fetch($result1)) {
				$allvendor[$row1['vendorid']] = $row1['vendorname'];
			}

$allseries = array();
$query1 ="select seriesid , seriesname from [|PREFIX|]brand_series   ";
$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
 while ($row1 = $GLOBALS['ISC_CLASS_DB']->Fetch($result1)) {
				$allseries[$row1['seriesid']] = $row1['seriesname'];
			}

		$dummy = $this->CreateDummyRow($this->fields);
		$vendorid = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
		//$where = $_SESSION['mywhere'];

		$query = $this->GetQuery($this->ConstructFieldList(), $where, $vendorid);


		if ($vendorid) {
			if ($where) {
				$where .= " AND ";
			}
			$where .= "p.prodvendorid = '" . $vendorid . "'";
		}

		if ($where) {
			$where = " WHERE " . $where;
		}




$query2 = "SELECT count(*) as count FROM [|PREFIX|]products  p LEFT JOIN [|PREFIX|]import_variations iv ON p.productid = iv.productid ".$_SESSION['searchjoin']."	".$where;
$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2);
$count = $row['count'];

	if ($count < 5000) 
	{

			$pages = 0;
			$increment = 0;
			$last =  $count;

	}
	else
	{
			$increment = 5000;
			$last = $count %  $increment;
			$pages = 	intval($count /  $increment);

	}

for ($i = 0; $i <= $pages; $i++) {
$SL = $i * $increment;
if ($i == $pages) $increment = $last;


 $new_query = $query. ' LIMIT '.$SL.' , '.$increment.'';

					$this->result = $GLOBALS['ISC_CLASS_DB']->Query($new_query);

					while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($this->result)) {


					// map the data from the db row to the dummy row
					$new_row = $this->MapRow($row, $dummy);



					// perform any custom work on the row and write it the export method
					$new_row = $this->HandleRow($new_row);

					
					
					if ($new_row['instruction_file'] != "")
					{
					$pos1 = stripos($new_row['instruction_file'], "http://");
					if ($pos1 === false) {
						 $new_row['instruction_file'] = "http://".$_SERVER["HTTP_HOST"]."/store/instruction_file/".$new_row['instruction_file'];
						} 
					}

					if ($new_row['article_file'] != "")
					{
					$pos2 = stripos($new_row['article_file'], "http://");
					if ($pos2 === false) {
						 $new_row['article_file'] =  "http://".$_SERVER["HTTP_HOST"]."/store/article_file/".$new_row['article_file'];
						 } 
					}


					$new_row = $this->RemoveExtraFields($new_row);


					//blessen

					$subCat = $this->HandleCategories($new_row['productCategories']);

					$strArr = array();
					foreach($subCat as $val) {
					array_push($strArr,$val);
					}


		if (isset($new_row['SeriesName'])) {
		$new_row['SeriesName'] = $allseries[$new_row['SeriesName']];
		if ($new_row['SeriesName'] == "0" ) $new_row['SeriesName'] = "";
		}

		if (isset($new_row['Vendor'])) {
		$new_row['Vendor'] = $allvendor[$new_row['Vendor']];
		}

		$filename_temp = "";

		if (isset($new_row['ProductImages'])) {

		$query1 = "SELECT imagefile  FROM [|PREFIX|]product_images   WHERE imageisthumb = 0 and imageprodid  = ".$new_row['ProductImages'];
		$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
		 while ($row1 = $GLOBALS['ISC_CLASS_DB']->Fetch($result1)) {
				$filename_temp .= "http://".$_SERVER["HTTP_HOST"]."/store/product_images/".$row1['imagefile'].";";		
				}
		$new_row['ProductImages'] = rtrim($filename_temp,";");
		}

		$filename_temp = "";
		if (isset($new_row['InstallVideos'])) {

				$query1 = "SELECT videofile  ,isdownloaded FROM [|PREFIX|]install_videos    WHERE  videoprodid  = ".$new_row['InstallVideos'];
				$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
				 while ($row1 = $GLOBALS['ISC_CLASS_DB']->Fetch($result1)) {
						if ($row1['isdownloaded'] == 1)
						$filename_temp .= "http://".$_SERVER["HTTP_HOST"]."/store/install_videos/".$row1['videofile'].";";	
						else
						$filename_temp .= $row1['videofile'].";";			
							}
				$new_row['InstallVideos'] = rtrim($filename_temp,";");
		}

		$filename_temp = "";
		if (isset($new_row['ProductVideos'])) {

				$query1 = "SELECT videofile  ,isdownloaded FROM [|PREFIX|]product_videos   WHERE  videoprodid  = ".$new_row['ProductVideos'];
				$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
				 while ($row1 = $GLOBALS['ISC_CLASS_DB']->Fetch($result1)) {
						if ($row1['isdownloaded'] == 1)
						$filename_temp .= "http://".$_SERVER["HTTP_HOST"]."/store/product_videos/".$row1['videofile'].";";	
						else
						$filename_temp .= $row1['videofile'].";";			
							}
				$new_row['ProductVideos'] = rtrim($filename_temp,";");
		}

		$filename_temp = "";
		if (isset($new_row['AudioClips'])) {

				$query1 = "SELECT audiofile  ,isdownloaded FROM [|PREFIX|]audio_clips    WHERE  audioprodid  = ".$new_row['AudioClips'];
				$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
				 while ($row1 = $GLOBALS['ISC_CLASS_DB']->Fetch($result1)) {
						if ($row1['isdownloaded'] == 1)
						$filename_temp .= "http://".$_SERVER["HTTP_HOST"]."/store/audio_clips/".$row1['audiofile'].";";	
						else
						$filename_temp .= $row1['audiofile'].";";			
							}
				$new_row['AudioClips'] = rtrim($filename_temp,";");
		}


		$filename_temp = "";
		if (isset($new_row['InstallImages'])) {

		$query1 = "SELECT imagefile  FROM [|PREFIX|]install_images    WHERE imageisthumb = 0 and imageprodid  = ".$new_row['InstallImages'];
		$result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);
		 while ($row1 = $GLOBALS['ISC_CLASS_DB']->Fetch($result1)) {
				$filename_temp .= "http://".$_SERVER["HTTP_HOST"]."/store/install_images/".$row1['imagefile'].";";		
				}
		$new_row['InstallImages'] = rtrim($filename_temp,";");
		}
					
				
					

					$new_row['subcategory'] = $strArr[0]['productCategoryPath'];
					$new_row['category'] = $strArr[0]['productCategoryName'];
					unset($new_row['productCategories']);



					// format the data
					$this->FormatColumns($new_row);

					// write the row using the export method
					$this->exportmethod->WriteRow($new_row);
					}
					mysql_free_result($this->result);
	}
	}

	/**
	* Creates an array of all the fields that are expected in the output
	*
	*/
	protected function CreateDummyRow($fields)
	{
		$dummy = array();
		foreach ($fields as $id => $field) {
			if ($field['used']) {
				$dummy[$id] = "";
			}
		}

		return $dummy;
	}

	/**
	* Maps data from the database row to the dummy row
	*
	* @param array $row The database row
	* @param array $dummy The dummy record
	* @return array Row with mapped data and any extra columns at the end of the row
	*/
	protected function MapRow($row, $dummy)
	{

		$extra_cols = array();
		foreach ($row as $column => $value) {
			if (isset($dummy[$column])) {
				$dummy[$column] = $value;
			}
			else {
				$extra_cols[$column] = $value;
			}
		}

		// do we have any extra columns in our row? add them to the end of the dummy row
		if (count($extra_cols)) {
			$dummy += $extra_cols;
		}

		return $dummy;
	}


	/**
	* Performs any custom handling on the row needed by the file type
	*
	* @param array The row to export
	*/
	protected function HandleRow($row)
	{
		return $row;
	}

	/**
	* Removes any data from the row that isnt a field
	*
	* @param array $row
	*/
	protected function RemoveExtraFields($row)
	{
		$new_row = $row;
		foreach ($row as $id => $value) {
			if (!in_array($id, array_keys($this->fields))) {

				// blesen
				if ($id !="vendor") unset($new_row[$id]);
			}
		}

		return $new_row;
	}


	/**
	* Applies formatting to values such as price, date and text formats
	*
	* @param array The row of data to format
	* @param array Optional subset of fields to use when performing formatting. Defaults to the entire loaded field array.
	*/
	protected function FormatColumns(&$row, $fields = array())
	{
		if (!count($fields)) {
			$fields = $this->fields;
		}

		foreach ($row as $column => $value) {
			if (!isset($fields[$column])) {
				continue;
			}

			$field = $fields[$column];

			// format the value if required
			if (isset($field['format'])) {
				$format = $field['format'];

				if ($format == "number") {
					if ($this->template['priceformat'] == "formatted") {
						$row[$column] = FormatPriceInCurrency($value);
					}
					else {
						$row[$column] = FormatPrice($value, false, false, true);
					}
				}
				elseif ($format == "date") {
					if ($value != '0') {
						$row[$column] = date($this->dateformat, $value);
					}
					else {
						$value = '';
					}
				}
				elseif ($format == "text") {
					// remove html tags and decode entities
					//$decoded = html_entity_decode(strip_tags($value));
					$decoded = $value;
					// remove excess white space
					$excess = preg_replace("/^(\s+)/m", "", $decoded);
					// replace new lines with spaces
					$row[$column] = preg_replace("/([\\r\\n]+)/m", " ", $excess);
				}
				elseif ($format == "bool") {
					$value = (bool)$value;
					if ($this->blankforfalse && !$value) {
						$row[$column] = "";
					}
					else {
						switch ($this->boolformat) {
							case "onezero":
								if ($value) {
									$row[$column] = "1";
								}
								else {
									$row[$column] = "0";
								}
								break;
							case "truefalse":
								if ($value) {
									$row[$column] = GetLang("TrueLabel");
								}
								else {
									$row[$column] = GetLang("FalseLabel");
								}
								break;
							case "yesno":
								if ($value) {
									$row[$column] = GetLang("YesLabel");
								}
								else {
									$row[$column] = GetLang("NoLabel");
								}
								break;
						}
					}
				}
			}
		}
	}

	/**
	* Gets an array containing the column header names
	*
	* @return array The column headers
	*/
	public function GetHeaders($flatten = false, $remove_parent = true)
	{
		$fields = $this->fields;
		if ($flatten) {
			$fields = $this->FlattenFields($fields, $remove_parent);
		}

		$header = array();
		foreach ($fields as $id => $field) {
			if ($field['used']) {
				$header[$id] = $field['header'];
			}
		}
		unset($header['productCategories']);

		if ($_GET['t'] == "products")
		{
			$header["category"] = "Category";
			$header["subcategory"] = "Sub Category";
		}

		return $header;
	}

	/**
	* Method to return the array of fields that defines this file type
	*
	* @example type_fields.inc An example array defining fields for a type	*
	*
	*
	* @return array The array of fields
	*/
	abstract public function GetFields();

	/**
	* Loads the fields, optionally using a template to load data
	*
	* @param int Optional. The template to load field settings from.
	*/
	public function LoadFields($templateid = 0)
	{
		$fields = $this->GetFields();

		// load labels for the fields
		$fields = $this->LoadFieldLabels($fields);

		if ($templateid) {
			// load field data from template
			$fields = $this->LoadFieldData($fields, $templateid);
		}

		return $fields;
	}

	/**
	* Returns a loaded field using a given field id
	*
	* @param mixed $fieldid
	* @param array $fields
	*/
	public function GetField($fieldid, $fields = array())
	{
		if (empty($fields)) {
			$fields = $this->fields;
		}

		foreach ($fields as $id => $field) {
			if ($id == $fieldid) {
				return $field;
			}
			elseif (isset($field['fields'])) {
				$retfield = $this->GetField($fieldid, $field['fields']);

				if ($retfield !== false) {
					return $retfield;
				}
			}
		}

		return false;
	}

	/**
	* Performs any extra work needed to be done on the fields
	*
	* @param array The fields array
	* @param int The template
	*/
	protected function PostFieldLoad()
	{

	}

	/**
	* Loads the labels from the language file for the fields
	*
	* @param array The fields to load labels for
	*
	* @return array A new array of fields containing the labels
	*/
	public function LoadFieldLabels($fields)
	{
		$new_fields = $fields;
//print_r($new_fields);




		foreach ($fields as $id => $field) {
			// set label for the field
			$new_fields[$id]['label'] = GetLang($id);
if ($new_fields[$id]['label'] == "") $new_fields[$id]['label'] = $id;
			// does this field have sub-fields?
			if (isset($field['fields'])) {
				$new_fields[$id]['fields'] = $this->LoadFieldLabels($field['fields']);
			}
		}
		
		return $new_fields;
	}

	/**
	* Abstract method that returns the SQL query used to get the data for exporting
	*
	* @param string Comma delimited list of database fields to query
	* @param string The WHERE clause to filter the data by
	* @param int The vendor used to restrict the data
	*/
	abstract protected function GetQuery($columns, $where, $vendorid);


	/**
	* Loads data from the database into the fields
	*
	* @param int The template to load field settings for
	* @param array The fields to load the settings into
	*
	* @return array A new array of the fields modified by the template
	*/
	protected function LoadFieldData($fields, $templateid)
	{
		$new_fields = $fields;

		$fields = $this->FlattenFields($fields);

		// load field data for this type
		$query = "SELECT * FROM [|PREFIX|]export_template_fields WHERE exporttemplateid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($templateid) . "' AND fieldtype = '" . $this->type_name . "'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		// cache the rows
		$row_data = array();
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$row_data[$row['fieldid']] = $row;
		}

		$max_sort = count($fields);

		foreach ($fields as $fieldid => $field) {
			// does this field exist in our data?
			if (isset($row_data[$fieldid])) {
				$row = $row_data[$fieldid];

				$data = array(
					'header' 	=> $row['fieldname'],
					'used' 		=> $row['includeinexport'],
					'sortorder'	=> $row['sortorder']
				);
			}
			else {
				// set defaults if field doesnt exist in db
				$data = array(
					'header' 	=> $field['label'],
					'used' 		=> false,
					'sortorder'	=> $max_sort++
				);
			}


			if ($row['sortorder'] > $max_sort) {
				$max_sort = $row['sortorder'];
			}

			$this->SetFieldData($new_fields, $fieldid, $data);
		}

		// check if db data contains fields that no longer exist
		foreach ($row_data as $id => $row) {
			if (!isset($fields[$id])) {
				// delete the field to keep the db clean
				$query = "DELETE FROM [|PREFIX|]export_template_fields WHERE exporttemplatefieldid = " . $row['exporttemplatefieldid'];
				$GLOBALS['ISC_CLASS_DB']->Query($query);
			}
		}

		// sort the field array by the sort order
		uasort($new_fields, array(&$this, "compare_fields"));

		// sort subfields
		foreach ($new_fields as $id => &$field) {
			if (isset($field['fields'])) {
				uasort($field['fields'], array(&$this, "compare_fields"));
			}
		}

		return $new_fields;
	}

	/**
	* Compare function to sort fields by their "sortorder" element
	*
	* @param array A field being compared
	* @param array The field compared to the first field
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

	/**
	* Locates a field within the array of fields and sets the template data for it
	*
	* @param array The fields to search in
	* @param string The field to set the data for
	* @param array The data to set for the field
	*/
	private function SetFieldData(&$fields, $fieldid, $data)
	{
		foreach ($fields as $id => &$field) {
			if ($id == $fieldid) {
				foreach ($data as $col => $value) {
					$field[$col] = $value;
				}
			}
			elseif (isset($field["fields"])) {
				$this->SetFieldData($field["fields"], $fieldid, $data);
			}
		}
	}

	/**
	* Flattens the fields. Subfields will be moved down into the root of the array.
	*
	* @param array The fields to flatten
	* @param bool Should the parent element that contains subfields be removed?
	*
	* @return array A new array of flattened fields
	*/
	public function FlattenFields($fields = array(), $remove_parent = false)
	{
		if (empty($fields)) {
			$fields = $this->fields;
		}

		$new_fields = array();
		foreach ($fields as $id => $field) {
			$new_fields[$id] = $field;

			if (isset($field['fields'])) {
				foreach ($field['fields'] as $subid => $subfield) {
					$new_fields[$subid] = $subfield;
				}

				unset($new_fields[$id]['fields']);

				if ($remove_parent) {
					unset($new_fields[$id]);
				}
			}
		}

		return $new_fields;
	}

	/**
	* Gets an array of column names to use in the grid view
	*
	*/
	abstract public function GetListColumns();

	/**
	* Gets an array of sort links for the list columns
	*
	*/
	abstract public function GetListSortLinks();

	/**
	* Gets an SQL query to list the data for this file type
	*
	* @param string $where A WHERE clause
	*/
	abstract public function GetListQuery($where, $vendorid, $sortField, $sortOrder);

	/**
	* Gets a simplified SQL query to count the rows for the file type.
	* Query must contain a single column named ListCount.
	*
	* @param string $where A WHERE clause
	*/
	abstract public function GetListCountQuery($where, $vendorid);

	/**
	* Gets a formatted row for use in the grid
	*
	* @param array $row Row from the database
	* @return array The formatted row
	*/
	abstract public function GetListRow($row);

	/**
	* Gets the WHERE statement when a custom search (views for orders, products, customers) is used for the export. ie. "Featured Products", "Incomplete Orders".
	*
	* @param int The custom search
	* @return array Details about the custom search: where => "where statement", name => "name of the custom search"
	*/
	public function GetWhereFromSearch($searchid)
	{
		$search = new ISC_ADMIN_CUSTOMSEARCH($this->type_name);
		if (!$search_row = $search->LoadSearch($searchid)) {
			throw new Exception(GetLang("SearchNotFound"));
		}

		$search_fields = $search_row['searchvars'];
		if (isset($search_fields['viewName'])) {
			unset($search_fields['viewName']);
		}
		$where = $this->BuildWhereFromFields($search_fields);
		return array("where" => $where, "name" => $search_row['searchname']);
	}


	/**
	* Builds a WHERE statement using any passed in query string parameters
	*
	* @param mixed $params
	* @return $where string The WHERE clause
	*/
	public function GetWhereFromParams($params)
	{
		$where = $this->BuildWhereFromFields($params);

		return $where;
	}

	/**
	* Abstract function to build the where statement using the fields defined in the custom search
	*
	* @param array The fields for the custom search
	*/
	abstract protected function BuildWhereFromFields($search_fields);

	/**
	* Abstract function to check whether the user has permission to export this file type
	*
	*/
	abstract public function HasPermission();


	/**
	* Gets the position of a field
	*
	* @param mixed $key
	* @param array $fields
	* @param mixed $excludeUsed
	*/
	protected function GetFieldPosition($key, $fields = array(), $excludeUsed = true)
	{
		if (empty($fields)) {
			$fields = $this->fields;
		}

		$index = 0;

		foreach ($fields as $id => $field) {
			if ($id == $key) {
				return $index;
			}
			if ($field['used'] || !$excludeUsed) {
				$index++;
			}
		}

		return -1;
	}

	/**
	* Gets form fields of a specific type then inserts them into the array of export type fields in their correct position
	*
	* @param mixed $formFieldType The type of form fields to get
	*/
	protected function InsertFormFields($formFieldType, $field, $fields, $labelFormat = "%s")
	{
		$new_fields = $fields;

		$formfieldfields = array();

		$form = new ISC_FORM();
		$formfields = $form->getFormFields($formFieldType);

		foreach ($formfields as $formfieldid => $formfield) {
			// only get use defined fields
			if (!$formfield->record['formfieldprivateid']) {
				$new_field = array(
					'used'		=> true,
					'label' 	=> sprintf($labelFormat, $formfield->record['formfieldlabel']),
					'header'	=> sprintf($labelFormat, $formfield->record['formfieldlabel'])
				);

				// set date fields to be formatted
				if ($formfield instanceof ISC_FORMFIELD_DATECHOOSER) {
					$new_field['format'] = "date";
				}

				$formfieldfields[$field . "_" . $formfieldid] = $new_field;
			}
		}

		if (count($formfieldfields)) {
			// position of form fields
			$position = $this->GetFieldPosition($field, $fields, false);

			$keys = array_keys($fields);
			$field_keys = array_keys($formfieldfields);

			// insert the form fields into correct position
			array_splice($new_fields, $position, 1, $formfieldfields);
			// recreate the field keys
			array_splice($keys, $position, 1, $field_keys);
			$new_fields = array_combine($keys, $new_fields);
		}

		return $new_fields;
	}

	/**
	* Loads the session data for specified form fields into the export fields
	*
	* @param mixed $formFieldType
	* @param mixed $field
	* @param mixed $fields
	* @param mixed $sessionid
	*/
	protected function LoadFormFieldData($formFieldType, $field, &$fields, $sessionid)
	{
		// get the form fields with data
		$form = new ISC_FORM();
		$formfields = $form->getSavedSessionData($sessionid, array(), $formFieldType, true);

		foreach ($formfields as $formfieldid => $formfield) {
			// only get use defined fields
			if (isset($fields[$field . "_" . $formfieldid])) {
				$value = $formfield['value'];

				if (is_array($value)) {
					$value = implode(", ", $value);
				}
				elseif ($formfield['type'] == "datechooser" && $value) {
					// convert a date to a timestamp
					list($year, $month, $day) = explode("-", $value);
					$value = mktime(0, 0, 0, $month, $day, $year);
				}

				$fields[$field . "_" . $formfieldid] = $value;
			}
		}
	}
}
?>