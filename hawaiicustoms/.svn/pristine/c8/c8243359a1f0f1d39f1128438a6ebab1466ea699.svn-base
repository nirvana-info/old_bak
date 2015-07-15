<?php
/**
* Abstract class that represents an export method. An export method reads data from an ISC_ADMIN_EXPORTFILETYPE object and writes it to a file.*
*
* @author Ray Ward <ray.ward@interspire.com>
*/
abstract class ISC_ADMIN_EXPORTMETHOD
{
	protected $handle; 	// handle of the file
	protected $file;	// file path

	protected $filetype; // the file type being exported by this method

	protected $method_name; 		// the name of this particular export method
	protected $method_icon;			// the icon shown next to the method name
	protected $method_help; 		// tool tip displayed when exported
	protected $method_extension; 	// the file extension to use
	protected $method_title = "";

	protected $type_name;

	public $settings = array();

	protected $has_settings = false;

	public function __construct()
	{
		// load language for this method
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('export.method.' . strtolower($this->method_name));

		$this->method_help = GetLang("MethodHelp");
		$this->method_title = GetLang("MethodTitle");
	}

	/**
	* Initialises this method for exporting
	*
	* @param ISC_ADMIN_EXPORTFILETYPE The file to export data from
	* @param int The template to be used when exporting data
	* @param string A WHERE clause to query data for export
	* @param int The vendor to restrict data to
	*/
	public function Init(ISC_ADMIN_EXPORTFILETYPE $filetype, $templateid, $where, $vendorid)
	{
		// initialise the file type
		$filetype->Init($this, $templateid, $where, $vendorid);

		// set the type name
		$details = $filetype->GetTypeDetails();
		$name = $details['name'];
		if (substr($name, -1, 1) == "s") {
			$name = substr($name, 0, -1);
		}
		$this->type_name = $name;

		$this->filetype = $filetype;

		// load settings for this method
		$settings = $this->GetSettings($templateid);
		foreach ($settings as $var => $setting) {
			$this->settings[$var] = $setting['value'];
		}
	}

	/**
	* Gets an array of details about the export method
	*
	* @return array Method Details
	*/
	public function GetMethodDetails()
	{
		$details = array(
			"name" 		=> $this->method_name,
			"icon" 		=> $this->method_icon,
			"help" 		=> $this->method_help,
			"extension"	=> $this->method_extension,
			"title"		=> $this->method_title
		);

		return $details;
	}

	/**
	* Creates a file and exports the data from the file type
	*
	* @return string The name of the file.
	*/
	public function Export()
	{
		// create a temporary file
		$output = "";
		$this->file = tempnam(sys_get_temp_dir(), "export_");
		$this->handle = fopen($this->file, "wb");

		// write any header data if necessary
		$this->WriteHeader();

		// Export the rows
		$this->filetype->ExportRows();

		// write any footer/closing data
		$this->WriteFooter();

		// close the file
		fclose($this->handle);

		return $this->GetFile();
	}

	/**
	* Gets the path of the file created for the export.
	*
	* @return string The exported file
	*/
	public function GetFile()
	{
		return $this->file;
	}

	/**
	* Abstract method to write any header data at the beginning of the file, such as CSV headers
	*
	*/
	abstract protected function WriteHeader();

	/**
	* Abstract method to write the row of data to the file
	*
	* @param array The row of data to write
	*/
	abstract public function WriteRow($row);

	/**
	* Abstract method to write any footer data at the end of the file
	*
	*/
	abstract protected function WriteFooter();

	/**
	* Abstract method that returns an array that defines the setting this method uses.
	*
	* @example method_settings.inc An example to define the settings
	*
	* @param int The template to load data into the settings from.
	*/
	abstract public function GetSettings($templateid);

	/**
	* Loads data for a template's settings
	*
	* @param array The array of settings
	* @param int The template to load the setting data from
	*/
	protected function LoadSettingData(&$settings, $templateid)
	{
		$query = "SELECT * FROM [|PREFIX|]export_method_settings WHERE exporttemplateid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($templateid) . "'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$varname = $row['variablename'];
			$settings[$varname]['value'] = $row['variablevalue'];
		}
	}

	public function HasSettings()
	{
		return $this->has_settings;
	}
}
?>
