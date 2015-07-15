<?php
include_once(ISC_BASE_PATH."/lib/compress/pclzip.lib.php");
/**
 * Export template for Customer Photo
 * @author wilson.zeng
*/
class ISC_ADMIN_EXPORTFILETYPE_PHOTOS extends ISC_ADMIN_EXPORTFILETYPE
{
	protected $type_name = "photos";
	protected $type_icon = "customer.gif";
	protected $type_idfield = "picid";
	protected $type_viewlink = "index.php?ToDo=viewCustomerPhotos";

	protected $handleaddresses = false;
	protected $handleaddressformfields = false;
	protected $handleformfields = false;
	
	public $zip_file = '';//zcs=the zip file path
	public $zip_handle = null;//zcs=

	public function GetFields()
	{
		 $fields = array(
			"picid"			=> array("dbfield" => "picid"),
			"description"		=> array("dbfield" => "description"),
			"customerFullName"	=> array("dbfield" => "CONCAT(c.custconfirstname, ' ', c.custconlastname)"),
			"uploaderName"		=> array("dbfield" => "CONCAT(uploaderLastName, ',', uploaderFirstName)"),
			"address"		=> array("dbfield" => 'CONCAT(address1, "\n", address2)'),
			"adminnote"		=> array("dbfield" => "adminnote"),
			"deleted"		=> array("dbfield" => "deleted", "format" => "boolean"),
			"dateline"		=> array("dbfield" => "dateline", "format" => "date"),
			"filename"		=> array("dbfield" => "filename"),
			"path"			=> array("dbfield" => "path"),
		);

		return $fields;
	}

	protected function PostFieldLoad()
	{
	}

	protected function GetQuery($columns, $where, $venderid)
	{
		if ($where) {
			$where = " WHERE " . $where;
		}

		$query = "
			SELECT
				DISTINCT
				" . $columns . ",
				picid
			FROM
				[|PREFIX|]pic p
				LEFT JOIN [|PREFIX|]customers c ON c.customerid = p.customerid
			" . $where;

		return $query;
	}

	protected function HandleRow($row)
	{
		//zcs=actually, we surppose to perform the deleted field as a "Available ?" column
		$row['deleted'] = (1 - $row['deleted']) ? 'yes' : 'no';
		return $row;
	}

	public function GetListColumns()
	{
		$columns = array(
			"ID",
			"Description",
			"Customer Name",
			"Uploader Name",
			"Address",
			"Upload Time",
			"Comments",
			"Is Available ?",
		);

		return $columns;
	}

	public function GetListSortLinks()
	{
		//zcs=it related to columns above by the Number-Index in array
		$sortLinks = array(
			"ID" => "picid",
			"Description" => 'description',
			"Customer" => "customerFullName",
			"Uploader" => "uploaderLastName",
			"Address" => 'address',
			"UploadTime" => "dateline",
			"Comments" => 'adminnote',
			"Available" => "deleted",
		);
		
		return $sortLinks;
	}

	public function GetListQuery($where, $vendorid, $sortField, $sortOrder)
	{
		if ($where) {
			$where = "WHERE " . $where;
		}

		$query = '
				SELECT
					DISTINCT picid,
					description,
					CONCAT(c.custconfirstname, " ", c.custconlastname) AS customerfullname,
					CONCAT(p.address1, "\n", p.address2) AS address,
					uploaderLastName,
					uploaderFirstName,
					dateline,
					adminnote,
					deleted
				FROM
					[|PREFIX|]pic p
					LEFT JOIN [|PREFIX|]customers c ON c.customerid = p.customerid
				' . $where . "
				ORDER BY "
					. $sortField . " " . $sortOrder;

		return $query;
	}

	public function GetListCountQuery($where, $vendorid)
	{
		if ($where) {
			$where = "WHERE " . $where;
		}

		$query = "
				SELECT
					COUNT(DISTINCT p.picid) AS ListCount
				FROM
					[|PREFIX|]pic p
					LEFT JOIN [|PREFIX|]customers c ON c.customerid = p.customerid
				" . $where;
		return $query;
	}

	public function GetListRow($row)
	{
		$new_row['ID'] = $row['picid'];
		$new_row['Description'] = $row['description'];
		$new_row['Customer Name'] = $row['customerfullname'];
		$new_row['Uploader Name'] = $row['uploaderLastName'].', '.$row['uploaderFirstName'];
		$new_row['Address'] = $row['address'];
		$new_row['Upload Time'] = date("jS M Y @ g:i A", $row['dateline']);
		$new_row['Comments'] = $row['adminnote'];
		$new_row['Available ?'] = (1 - $row['deleted']) ? 'yes' : 'no';

		return $new_row;
	}
	
	public function GetWhereFromParams($params){
		return $this->BuildWhereFromFields($params);
	}

	protected function BuildWhereFromFields($params)
	{
		$queryWhere = "";
			
		if (isset($params['searchQuery']) && $params['searchQuery'] != "") {
			// PostgreSQL is case sensitive for likes, so all matches are done in lower case
			$search_query = $GLOBALS['ISC_CLASS_DB']->Quote(trim(isc_strtolower($params['searchQuery'])));
			$queryWhere .= "
				AND (
					description LIKE '%" . trim($params['searchQuery']) . "%' OR
					LOWER(custconfirstname) LIKE '%" . $search_query . "%' OR
					LOWER(custconlastname) LIKE '%" . $search_query . "%' OR
					LOWER(CONCAT(custconfirstname, ' ', custconlastname)) LIKE '%" . $search_query . "%'
				)";
		}
		// strip AND from beginning and end of statement
		$queryWhere = preg_replace("/^(\s+AND )?|( AND\s+)?$/i", "", $queryWhere);

		return $queryWhere;
	}

	public function HasPermission()
	{
		return $GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Export_Customers);
	}
	
	/**
	 * zcs= Override
	*/
	public function ExportRows()
	{
		/*--old
		//zcs=create a zip file
		$this->zip_file = tempnam(sys_get_temp_dir(), 'exportzip_');
		$zip_handle = new ZipArchive;
		if ($zip_handle->open($this->zip_file, ZIPARCHIVE::CREATE) !== TRUE) {
			throw new Exception(sprintf(GetLang("CreateZipError"), $this->zip_file));
		}
		
		$err_zip_file = array();//zcs=log the file that not join in the zip
		*/
		
		$image_files = array();

		$where = $this->where;

		$dummy = $this->CreateDummyRow($this->fields);

		$query = $this->GetQuery($this->ConstructFieldList(), $where);
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
			
			//zcs=>
			$filepath = ISC_BASE_PATH.$new_row['path'];
			if(is_file($filepath)){
				$image_files[] = $filepath;
			}
			//<=zcs
			
			/*--old
			//zcs=>For photos, export extra image files,then pack then together as a zip.
			$filepath = ISC_BASE_PATH.$new_row['path'];
			if(is_file($filepath)){
				$zip_handle->addFile($filepath, $new_row['filename']);
			}else{
				$err_zip_file[] = $new_row['filename'];
			}
			//<=zcs
			*/
		}
		return $image_files;
		/*--old
		if(!empty($err_zip_file)){
			$zip_handle->addFromString('Notes.txt',
			"[Notes]\n".
			"It seems that some image file are not packed in since these file is not exists, please check below:\n".
			implode("\n", $err_zip_file));
		}
		$zip_handle->close();
		*/
	}
}