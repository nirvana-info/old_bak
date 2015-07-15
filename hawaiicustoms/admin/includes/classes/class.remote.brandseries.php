<?php

	if (!defined('ISC_BASE_PATH')) {
		die();
	}

	require_once(ISC_BASE_PATH.'/lib/class.xml.php');

	class ISC_ADMIN_REMOTE_BRANDSERIES extends ISC_XML_PARSER
	{
		public function __construct()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('brands');
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('products');//zcs=
			parent::__construct();
		}

		public function HandleToDo()
		{
			/**
			 * Convert the input character set from the hard coded UTF-8 to their
			 * selected character set
			 */
			convertRequestInput();

			$what = isc_strtolower(@$_REQUEST['w']);

			switch ($what) {
				case "getallbrands":
					$this->GetAllBrands();
					break;
				case "getseries":
					$this->GetSeries();
					break;
				//zcs=>
				case "getseriesoption":
					$this->GetSeriesOption();
					break;
				case "getsubcategoryoption":
					$this->GetSubCategoryOption();
					break;
				//<=zcs
				case "getbrandseries":
					$this->GetBrandSeries();
					break;
				default:
					break;
			}
		}
		
		/**
		 * GetBrandSeries
		 * wirror_20110130: ajax call for all brand series
		 * 
		 */
		private function GetBrandSeries(){
			$query = "SELECT b.brandid, b.brandname, bs.seriesid, bs.seriesname
			          FROM [|PREFIX|]brands b
				  LEFT JOIN [|PREFIX|]brand_series bs ON (b.brandid = bs.brandid)
				  WHERE bs.brandid!='0' and b.brandid=7
				  ORDER BY brandname asc";
			//echo $query;
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			$brands = array();
			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)){
				if(isset($brands[$row['brandid']])){
					$brands[$row['brandid']]['series'][] = array('id'=>$row['seriesid'], 'name'=>isc_html_escape($row['seriesname']));
				}else{
					$brands[$row['brandid']] = array('id'=>$row['brandid'], 'name'=>isc_html_escape($row['brandname']), 'series'=>array());
				}
			}
			var_dump($brands);
			//echo isc_json_encode(array_values($brands));
			exit;
		}
		
		/**
		 * GetAllBrands
		 * wirror_20110130: ajax call for all brands
		 * 
		 */
		private function GetAllBrands(){
			$query = "SELECT * FROM [|PREFIX|]brands ORDER BY brandname asc";
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			$brands = array();
			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)){
				$brands[] = array('id'=>$row['brandid'], 'name'=>isc_html_escape($row['brandname']));
			}
			
			echo isc_json_encode($brands);
			exit;
		}
		
		/**
		 * GetAllBrands
		 * wirror_20110130: ajax call for series
		 * 
		 */
		private function GetSeries(){
			$series = array();
			$squery = "SELECT * FROM [|PREFIX|]brand_series WHERE brandid!='0' ";
			if(isset($_REQUEST['bid']) && $_REQUEST['bid']>0)    {
			    $squery .= " AND brandid = $_REQUEST[bid] ";
			}
			$squery .= "ORDER BY seriesname ASC";
			$sresult = $GLOBALS["ISC_CLASS_DB"]->Query($squery);

			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($sresult)) { 
			    $series[] = array('id'=>$row['seriesid'], 'name'=>isc_html_escape($row['seriesname']));
			}
			
			echo isc_json_encode($series);
			exit;
		}
		
		//zcs=>just build options
		public function GetSeriesOption(){
			$series = array();
			$squery = "SELECT * FROM [|PREFIX|]brand_series WHERE 1 ";
			if(isset($_REQUEST['bid']) && $_REQUEST['bid']>0)    {
			    $squery .= " AND brandid = ".$_REQUEST['bid'];
			}
			$squery .= " ORDER BY seriesname ASC";
			$sresult = $GLOBALS["ISC_CLASS_DB"]->Query($squery);

			$output = '<option value="">'.GetLang('AllSeriesNames').'</option>';
			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($sresult)) {
				$output .= sprintf('<option value="%d">%s</option>', $row['seriesid'], $row['seriesname']);
			}
			echo $output;
		}
		public function GetSubCategoryOption(){
			$query = "SELECT * FROM [|PREFIX|]categories WHERE 1";
			if(isset($_REQUEST['cid']) && $_REQUEST['cid'] > 0){
			    $query .= " AND catparentid = ".$_REQUEST['cid'];
			}
			$query .= " ORDER BY catname ASC";
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			
			$output = '<option value="">'.GetLang('AllSubCategoryNames').'</option>';
			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)){
				$output .= sprintf("<option value='%d'>%s</option>", $row['categoryid'], $row['catname']);
			}
	
			echo $output;
		}
		//<=zcs
	}
?>
