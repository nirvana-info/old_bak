<?php
class ISC_CSVIMPORT_PARSER
{
	public $File;
	public $ChunkSize = 100;
	public $FileFP = null;
	public $LastRecord = 0;
	public $TotalRecords = 0;

	public $FieldSeparator = ",";
	public $FieldEnclosure = "\"";

	public $AutoDetectLineEndings = "";

//add by alandy.
public function GetCSVFile($file)
	{
		
	    $new_record = array();
	    $recordarray = array();
		// Save our original setup
		$this->AutoDetectLineEndings = ini_get("auto_detect_line_endings");

		// Apply the auto detecting line endings so we can split each line correctly
		ini_set("auto_detect_line_endings", "1");

		if(!is_file($file)) {
			trigger_error("Invalid file", E_USER_ERROR);
		}
		$this->FileFP = fopen($file, "r");
		
		
		while (($record = @fgetcsv($this->FileFP, 100000, $this->FieldSeparator, $this->FieldEnclosure)) !== false) {
		
		if(is_array($record) && isset($this->FieldList)) {
			
			foreach($this->FieldList as $field => $index) {

				/**
				 * Custom field check
				 */
				if ($field == 'custom' && is_array($index)) {
					foreach ($index as $fieldId => $fieldIndex) {
						if (array_key_exists($fieldIndex, $record)) {
							if (!array_key_exists('custom', $new_record) || !is_array($new_record['custom'])) {
								$new_record['custom'] = array();
							}

							$new_record['custom'][$fieldId] = trim($record[$fieldIndex]);
						}
					}

				/**
				 * Else normal field
				 */
				} else {
					if (!array_key_exists($index, $record)) {
						continue;
					}

					$new_record[$field] = trim($record[$index]);
				}
			}
			$recordarray[]=$new_record;
		}
	}	

		// Reached the end of the file
		if(@feof($this->FileFP) || $record === false) {
			@fclose($this->FileFP);
		}
        array_shift($recordarray);
		
		return $recordarray;

 		
	}
	/**
	 * Open a CSV file for parsing
	 *
	 * @param string The file to open for parsing
	 * @return resource
	 */
	public function OpenCSVFile($file, $startPosition=0)
	{
		// Save our original setup
		$this->AutoDetectLineEndings = ini_get("auto_detect_line_endings");

		// Apply the auto detecting line endings so we can split each line correctly
		ini_set("auto_detect_line_endings", "1");

		if(!is_file($file)) {
			trigger_error("Invalid file", E_USER_ERROR);
		}
		$this->FileFP = fopen($file, "r");

		// Seeking to a certain part of the file
		if($startPosition > 0) {
			fseek($this->FileFP, $startPosition);
		}
	}

	/**
	 * Return the current position that we're at in the file we have open.
	 *
	 * @return int The current position we're at in the file.
	 */
	public function GetCurrentPosition()
	{
		return @ftell($this->FileFP);
	}

	/**
	 * Get the number of records we've parsed in this file so far.
	 *
	 * @return int The number of records parsed.
	 */
	public function GetRecordNum()
	{
		return $this->LastRecord;
	}

	/**
	 * Splits a CSV file in to several chunks making it easy to parse
	 * in multiple interations.
	 *
	 * @param string The file to split up
	 * @param string The directory to place the created chunks in
	 * @return array An array of split chunks
	 */
	public function BuildChunks($file, $directory)
	{
		if(!is_file($file)) {
			trigger_error("Invalid file", E_USER_ERROR);
		}
		if(!is_dir($directory)) {
			trigger_error("Invalid directory", E_USER_ERROR);
		}

		$fp = fopen($file, "r");

		$count = 0;
		$total_count = 0;

		while(!@feof($fp)) {
			// Reached
			if($count == $this->ChunkSize || !isset($chunk_fp)) {
				if($total_count > 0) {
					@fclose($chunk_fp);
				}
				// Make sure the chunk file doesn't exist
				do
				{
					$chunk_file = $directory."/".basename($file).".".md5(uniqid(rand(), true));
				}
				while(file_exists($chunk_file));
				$chunk_files[] = $chunk_file;
				$chunk_fp = true;
				$chunk_fp = @fopen($chunk_file, "w");

				$count = 0;
				$records = array();
			}
			$buffer = @fgets($fp, 4096);
			if(!$buffer) {
				continue;
			}
			++$count;
			++$total_count;
			@fwrite($chunk_fp, $buffer);
		}

		@fclose($chunk_fp);
		@fclose($fp);

		return array(
			"records" => $total_count,
			"chunks" => $chunk_files
		);
	}

	//alandy add. fetch the first head record.
	public function FetchHeaderRecord()	{
	// Reached the end of the file
	$newrecord=array();
		if(!$this->FileFP) {
			return false;
		}
	$record = @fgetcsv($this->FileFP, 100000, $this->FieldSeparator, $this->FieldEnclosure);
	if(is_array($record)){
		foreach($record as $val){
			$val=ltrim($val);
			$val=rtrim($val);
			
			if(substr($val,0,2)!='PQ' && substr($val,0,2)!='VQ'){
			  $val=str_replace(" ","_",$val);
			  $val=strtolower($val);
			}
			$newrecord[]=$val;
					
		}
		
	}
	return $newrecord;
		
	}
	/**
	 * Fetch the next record from the open CSV file
	 */
	public function FetchNextRecord($add_original=false)
	{
		// Reached the end of the file
		if(!$this->FileFP) {
			return false;
		}

		// We've reached the max iterations we'll be doing per page
		if($this->LastRecord == $this->ChunkSize) {
			return false;
		}

		$record = @fgetcsv($this->FileFP, 100000, $this->FieldSeparator, $this->FieldEnclosure);
		$new_record = $record;
		if(is_array($record) && isset($this->FieldList)) {
			$new_record = array();
			foreach($this->FieldList as $field => $index) {

				/**
				 * Custom field check
				 */
				if ($field == 'custom' && is_array($index)) {
					foreach ($index as $fieldId => $fieldIndex) {
						if (array_key_exists($fieldIndex, $record)) {
							if (!array_key_exists('custom', $new_record) || !is_array($new_record['custom'])) {
								$new_record['custom'] = array();
							}

							$new_record['custom'][$fieldId] = trim($record[$fieldIndex]);
						}
					}

				/**
				 * Else normal field
				 */
				} else {
					if (!array_key_exists($index, $record)) {
						continue;
					}

					$new_record[$field] = trim($record[$index]);
				}
			}
		}
		if(is_array($new_record) && isset($add_original) && $add_original == true) {
			$new_record['original_record'] = $record;
		}

		// Reached the end of the file
		if(@feof($this->FileFP) || $record === false) {
			@fclose($this->FileFP);
		}

		++$this->LastRecord;

		return $new_record;
	}

	/**
	 * Sets the list of field names, used by FetchNextRecord to return a pretty array in the format we want.
	 *
	 * @param array Numerical-indexed array of records.
	 */
	public function SetRecordFields($fields=array())
	{
		$this->FieldList = $fields;
	}

	public function CloseCSVFile()
	{
		fclose($this->FileFP);

		//revert our ini set changes
		ini_set("auto_detect_line_endings", $this->AutoDetectLineEndings);
	}
}

if(!function_exists("array_combine")) {
	function array_combine($keys, $values)
	{
		$out = array();
		foreach($keys as $key1 => $value1) {
			$out[$value1] = $values[$key1];
		}
		return $out;
	}
}
?>