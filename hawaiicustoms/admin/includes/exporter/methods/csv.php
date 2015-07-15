<?php
class ISC_ADMIN_EXPORTMETHOD_CSV extends ISC_ADMIN_EXPORTMETHOD
{
	private $separator;
	private $enclosure;

	protected $method_name = "CSV"; // the name of this particular export method
	protected $method_icon = "exportCsv.gif";	// the icon shown next to the method name
	protected $method_extension = "csv";

	private $fields;

	private $lineEnding;

	protected $has_settings = true;

	public function __construct()
	{
		parent::__construct();
	}

	public function Init($type, $templateid, $where, $vendorid)
	{
		parent::Init($type, $templateid, $where, $vendorid);


		if (strtoupper($this->settings['FieldSeparator']) == "TAB") {
			$this->settings['FieldSeparator'] = "\t";
		}

		if ($this->settings['LineEnding'] == "Windows") {
			$this->lineEnding = "\r\n";
		}
		else {
			$this->lineEnding = "\n";
		}

		$this->fields = $this->filetype->FlattenFields();
	}

	// write the header
	protected function WriteHeader()
	{
		if ($this->settings['IncludeHeader']) {
			$this->writecsv($this->handle, $this->filetype->GetHeaders(!$this->settings['SubItems']), $this->settings['FieldSeparator'], $this->settings['FieldEnclosure'], $this->lineEnding);
		}
	}

	public function WriteRow($row)
	{
		$fields = $this->fields;

		// scan row for any columns that have an array (eg array of products)
		$has_array = false;
		$repeat_rows = array();

		$position_offset = 0;

		$positions = array();
		$y = 0;
		$copy_row = $row;

		foreach ($row as $column => $value) {
			if (is_array($value)) {
				// combine the items into a single field ?
				if ($this->settings['SubItems']) {
					$field = $fields[$column];

					$val = "";
					// get each sub record
					foreach ($value as $subitem) {
						if ($val) {
							$val .= $this->settings['SubItemSeparator'];
						}

						$this_val = "";
						// join each column in the sub record to the string
						foreach ($subitem as $subcol => $subval) {
							if (!isset($fields[$subcol])) {
								continue;
							}
							if ($this_val) {
								$this_val .= $this->settings['FieldSeparator'] . " ";
							}
							$this_val .= $fields[$subcol]['label'] . ": " . $subval;
						}

						$val .= $this_val;
					}

					$copy_row[$column] = $val;
				}
				else {
					// not combining, need to create more rows for each repitition

					$positions[$column] = $position_offset + $y;

					$has_array = true;

					// do we already have some subitems from another field recorded?
					if (count($repeat_rows)) {
						// loop through each of those rows and create more rows with this columns subitems
						foreach ($repeat_rows as $x => $repeat_row) {
							foreach ($value as $subitem) {
								$new_row = $repeat_row;

								$sub_count = count($subitem);

								foreach ($subitem as $subcol => $subval) {
									if (!isset($fields[$subcol])) {
										$sub_count--;
										continue;
									}

									$new_row[$column][$subcol] = $subval;
								}

								$new_rows[] = $new_row;
							}
						}

						$repeat_rows = $new_rows;
					}
					else {
						// no repeated rows yet, make initial ones from this column
						$x = 0;
						foreach ($value as $subitem) {
							$sub_count = count($subitem);
							foreach ($subitem as $subcol => $subval) {
								if (!isset($fields[$subcol])) {
									$sub_count--;
									continue;
								}

								$repeat_rows[$x][$column][$subcol] = $subval;
							}
							$x++;
						}
					}

					$position_offset += $sub_count - 1;
				}
			}
			$y++;
		}

		if ($has_array) {
			foreach ($repeat_rows as $repeat_row) {
				$out = $copy_row;

				//@todo sub item fields are in wrong order!

				// find the correct position the repeated row columns need to go into the actual row
				foreach ($repeat_row as $column => $items) {
					// replace items into our new row
					array_splice($out, $positions[$column], 1, $items);

					// recombine the keys
					$keys = array_keys($out);
					array_splice($keys, $positions[$column], count($items), array_keys($items));
					$out = array_combine($keys, $out);
				}

				// write each row
				$this->writecsv($this->handle, $out, $this->settings['FieldSeparator'], $this->settings['FieldEnclosure'], $this->lineEnding);
			}

			// blank line between sets of items
			if ($this->settings['BlankLine']) {
				$this->writecsv($this->handle, array(), $this->settings['FieldSeparator'], $this->settings['FieldEnclosure'], $this->lineEnding);
			}

			return;
		}

		// output the single row
		$this->writecsv($this->handle, $copy_row, $this->settings['FieldSeparator'], $this->settings['FieldEnclosure'], $this->lineEnding);

		if ($this->settings['BlankLine']) {
			$this->writecsv($this->handle, array(), $this->settings['FieldSeparator'], $this->settings['FieldEnclosure'], $this->lineEnding);
		}
	}

	private function writecsv(&$handle, $fields = array(), $delimiter = ',', $enclosure = '"', $line_ending = "\n")
	{
		// Sanity Check
		if (!is_resource($handle)) {
			trigger_error('fputcsv() expects parameter 1 to be resource, ' .
				gettype($handle) . ' given', E_USER_WARNING);
			return false;
		}

		if ($delimiter!=null) {
			if( strlen($delimiter) < 1 ) {
				trigger_error('delimiter must be a character', E_USER_WARNING);
				return false;
			}elseif( strlen($delimiter) > 1 ) {
				trigger_error('delimiter must be a single character', E_USER_NOTICE);
			}

			/* use first character from string */
			$delimiter = $delimiter[0];
		}

		if( $enclosure!=null ) {
			 if( strlen($enclosure) < 1 ) {
				trigger_error('enclosure must be a character', E_USER_WARNING);
				return false;
			}elseif( strlen($enclosure) > 1 ) {
				trigger_error('enclosure must be a single character', E_USER_NOTICE);
			}

			/* use first character from string */
			$enclosure = $enclosure[0];
	   }

		$i = 0;
		$csvline = '';
		$escape_char = '\\';
		$field_cnt = count($fields);
		$enc_is_quote = in_array($enclosure, array('"',"'"));
		reset($fields);

		foreach( $fields AS $field ) {

			/* enclose a field that contains a delimiter, an enclosure character, or a newline */
			if( is_string($field) && (
				strpos($field, $delimiter)!==false ||
				strpos($field, $enclosure)!==false ||
				strpos($field, $escape_char)!==false ||
				strpos($field, "\n")!==false ||
				strpos($field, "\r")!==false ||
				strpos($field, "\t")!==false ||
				strpos($field, ' ')!==false ) ) {

				$field_len = strlen($field);
				$escaped = 0;

				$csvline .= $enclosure;
				for( $ch = 0; $ch < $field_len; $ch++ ) {
					if( $field[$ch] == $escape_char && $field[$ch+1] == $enclosure && $enc_is_quote ) {
						continue;
					}elseif( $field[$ch] == $escape_char ) {
						$escaped = 1;
					}elseif( !$escaped && $field[$ch] == $enclosure ) {
						$csvline .= $enclosure;
					}else {
						$escaped = 0;
					}
					$csvline .= $field[$ch];
				}
				$csvline .= $enclosure;
			} else {
				$csvline .= $field;
			}



			if( ++$i != $field_cnt ) {
				$csvline .= $delimiter;
			}
		}

		$csvline .= $line_ending;

		return fwrite($handle, $csvline);
	}

	// nothing required to end a CSV ..
	protected function WriteFooter()
	{

	}


	public function GetSettings($templateid)
	{
		$settings['FieldSeparator'] = array(
										"value" => ",",
										"type" => "text",
										"required" => true
									);
		$settings['FieldEnclosure'] = array(
										"value" => "\"",
										"type" => "text"
									);
		$settings['IncludeHeader'] = array(
										"value" => true,
										"type" => "checkbox"
									);
		$settings['BlankLine'] = array(
									"value" => false,
									"type" => "checkbox"
								);
		$settings['SubItems'] = array(
										"value" => true,
										"type" => "checkbox"
									);
		$settings['SubItemSeparator'] = array(
											"value" => "|",
											"type" => "text"
										);
		$settings['LineEnding'] = array(
									"value" => "Windows",
									"type" => "select",
									"options" => array("Windows", "Unix")
								);
		$settings['AltCustomers'] = array(
									"value" => true,
									"type" => "checkbox"
								);

		if ($templateid) {
			$this->LoadSettingData($settings, $templateid);
		}

		return $settings;
	}
}
?>