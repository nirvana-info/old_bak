<?php
// NI cloud 2010-06-08 export search statistic to csv file

class ISC_ADMIN_EXPORT_SEARCH_STATISTIC
{
	private $from_date;
	private $to_date;
	private $stype;
	private $clickwhere;
	
	function __construct()
	{
		if( isset($_GET['FromDate']) )
		{
			$this->from_date = (int)$_GET['FromDate'];
		}
		else
		{
			$this->from_date = isc_gmmktime(0, 0, 0, isc_date("m"), isc_date("d")-30, isc_date("Y"));
		}
		
		if( isset($_GET['ToDate']) )
		{
			$this->to_date = (int)$_GET['ToDate'];
		}
		else
		{
			$this->to_date = time();
		}
		
		if( isset($_GET['Search_Type']) )
		{
			$this->stype = strtolower($_GET['Search_Type']);
			if( strtolower($_GET['Search_Type']) === strtolower('SearchStatsBestPerformanceGrid') )
			{
				$this->clickwhere = 1;
			}
			if( strtolower($_GET['Search_Type']) === strtolower('SearchStatsWorstPerformanceGrid') )
			{
				$this->clickwhere = 0;
			}
		}
		else
		{
			$this->stype = strtolower('KeywordWithResults');
		}
	}
	
	function HandleToDo()
	{
		switch($this->stype)
		{
			case 'keywordwithresults':
			{
				$this->SearchStatsWithResultsExport();
				break;
			}
			case 'keywordwithoutresults':
			{
				$this->SearchStatsWithoutResultsExport();
				break;
			}
			case 'searchstatsbestperformancegrid':
			case 'searchstatsworstperformancegrid':
				$this->SearchStatsPerformanceGrid();
				break;
			default:
				$this->SearchStatsWithResultsExport();
		}
	}
	
	function SearchStatsWithResultsExport()
	{
		$query = sprintf("select distinct(searchtext), searchurl, UPPER(ifnull( prodmaker , '' )) AS maker, ifnull( prodyear , '' ) AS year, UPPER(ifnull( prodmodel , '' )) AS model, max(numresults) as numresults, count(searchid) as numsearches, max(searchdate) as lastperformed
								from [|PREFIX|]searches_extended
								where numresults > 0
								and searchdate >= '%d' and searchdate <= '%d'
								group by searchtext, searchurl, maker, year, model 
								order by numsearches desc",
								$this->from_date,
								$this->to_date
			);
			
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		
		header("Content-Type: text/csv");  
		header("Content-Disposition: attachment; filename=SearchStatsKeywordWithResults.csv");  
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');  
		header('Expires:0');  
		header('Pragma:public');  
		
		echo 'Search statistics for keywords with results';	
		echo "\n\n";
		if( isset($this->from_date) && $this->from_date != 0 )
		{
			echo 'Start Date:,'.date("Y-m-d H:i:s",$this->from_date).', ,';
		}
		if( isset($this->to_date) && $this->to_date != 0 )
		{
			echo 'End Date:,'.date("Y-m-d H:i:s",$this->to_date)."\n\n";
		}
		
		if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) 
		{
			echo "Search Terms,Search Text,Year,Make,Model,Number of Searches,Number of Results,Search Last Performed \n";
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) 
			{		
				echo ((isset($row['searchurl']) && $row['searchurl'] !== '') ? $GLOBALS["ShopPath"].$row['searchurl'] : $GLOBALS["ShopPath"]."/search/".MakeURLSafe($row['searchtext']).( isset($row['year']) && $row['year'] != "" ? "/year/".$row['year'] : '').( isset($row['maker']) && $row['maker'] != "" ? "/make/".MakeURLSafe($row['maker']) : '').( isset($row['model'] ) && $row['model'] != "" ? "/model/".MakeURLSafe($row['model']) : '')).','.
				     isc_html_escape($row['searchtext']).','.
					 $row['year'].','.$row['maker'].','.$row['model'].','.
					 number_format($row['numsearches'],0,'','').','.
					 number_format($row['numresults'],0,'','').','.
					 isc_date(GetConfig('DisplayDateFormat'), $row['lastperformed']);
				echo "\n";
			}
			
			echo "\nTotal Results: ".$GLOBALS['ISC_CLASS_DB']->CountResult($result);
		}
		else
		{
			echo "Total Results: 0";
		}
  
	}
	
	function SearchStatsWithoutResultsExport()
	{
		$query = sprintf("select distinct(searchtext), searchurl, UPPER(ifnull( prodmaker , '' )) AS maker, ifnull( prodyear , '' ) AS year, UPPER(ifnull( prodmodel , '' )) AS model, count(searchid) as numsearches, max(searchdate) as lastperformed
								from [|PREFIX|]searches_extended
								where numresults = 0
								and searchdate >= '%d' and searchdate <= '%d'
								group by searchtext, searchurl, maker, year, model 
								order by numsearches desc",
								$this->from_date,
								$this->to_date
			);
			
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		
		header("Content-Type: text/csv");  
		header("Content-Disposition: attachment; filename=SearchStatsKeywordWithoutResults.csv");  
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');  
		header('Expires:0');  
		header('Pragma:public');  
		
		echo 'Search statistics for keywords without results';	
		echo "\n\n";
		if( isset($this->from_date) && $this->from_date != 0 )
		{
			echo 'Start Date:,'.date("Y-m-d H:i:s",$this->from_date).', ,';
		}
		if( isset($this->to_date) && $this->to_date != 0 )
		{
			echo 'End Date:,'.date("Y-m-d H:i:s",$this->to_date)."\n\n";
		}
		
		if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) 
		{
			echo "Search Terms,Search Text,Year,Make,Model,Number of Searches,Number of Results,Search Last Performed \n";
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) 
			{
				echo ((isset($row['searchurl']) && $row['searchurl'] !== '') ? $GLOBALS["ShopPath"].$row['searchurl'] : $GLOBALS["ShopPath"]."/search/".MakeURLSafe($row['searchtext']).( isset($row['year']) && $row['year'] != "" ? "/year/".$row['year'] : '').( isset($row['maker']) && $row['maker'] != "" ? "/make/".MakeURLSafe($row['maker']) : '').( isset($row['model'] ) && $row['model'] != "" ? "/model/".MakeURLSafe($row['model']) : '')).','.
				     isc_html_escape($row['searchtext']).','.
				     $row['year'].','.$row['maker'].','.$row['model'].','.
					 number_format($row['numsearches'],0,'','').','.
					 number_format($row['numresults'],0,'','').','.
					 isc_date(GetConfig('DisplayDateFormat'), $row['lastperformed']);
				echo "\n";
			}
			
			echo "\nTotal Results: ".$GLOBALS['ISC_CLASS_DB']->CountResult($result);
		}
		else
		{
			echo "Total Results: 0";
		}
  
	}
	
	function SearchStatsPerformanceGrid()
	{
		$query = sprintf("select distinct(searchtext), searchurl, UPPER(ifnull( prodmaker , '' )) AS maker, ifnull( prodyear , '' ) AS year, UPPER(ifnull( prodmodel , '' )) AS model, max(numresults) as numresults, count(searchid) as numsearches, max(searchdate) as lastperformed
								from [|PREFIX|]searches_extended
								where numresults > 0
								and clickthru='%d'
								and searchdate >= '%d' and searchdate <= '%d'
								group by searchtext, searchurl, maker, year, model
								order by numsearches desc",
								$this->clickwhere,
								$this->from_date,
								$this->to_date
			);
			
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		
		header("Content-Type: text/csv");  
		if( $this->clickwhere == 1 )
		{
			header("Content-Disposition: attachment; filename=SearchStatsBestPerformingKeywords.csv");
		}
		else
		{
			header("Content-Disposition: attachment; filename=SearchStatsWorstPerformingKeywords.csv");
		}  
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');  
		header('Expires:0');  
		header('Pragma:public');  
		
		if( $this->clickwhere == 1 )
		{
			echo 'Search statistics for best performing keywords';	
		}
		else
		{
			echo 'Search statistics for worst performing keywords';	
		}
		echo "\n\n";
		if( isset($this->from_date) && $this->from_date != 0 )
		{
			echo 'Start Date:,'.date("Y-m-d H:i:s",$this->from_date).', ,';
		}
		if( isset($this->to_date) && $this->to_date != 0 )
		{
			echo 'End Date:,'.date("Y-m-d H:i:s",$this->to_date)."\n\n";
		}
		
		if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) 
		{
			echo "Search Terms,Search Text,Year,Make,Model,Number of Searches,Number of Results,Search Last Performed \n";
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) 
			{
				echo ((isset($row['searchurl']) && $row['searchurl'] !== '') ? $GLOBALS["ShopPath"].$row['searchurl'] : $GLOBALS["ShopPath"]."/search/".MakeURLSafe($row['searchtext']).( isset($row['year']) && $row['year'] != "" ? "/year/".$row['year'] : '').( isset($row['maker']) && $row['maker'] != "" ? "/make/".MakeURLSafe($row['maker']) : '').( isset($row['model'] ) && $row['model'] != "" ? "/model/".MakeURLSafe($row['model']) : '')).','.
				     isc_html_escape($row['searchtext']).','.
				     $row['year'].','.$row['maker'].','.$row['model'].','.
                     number_format($row['numsearches'],0,'','').','.
                     number_format($row['numresults'],0,'','').','.
					 isc_date(GetConfig('DisplayDateFormat'), $row['lastperformed']);
				echo "\n";
			}
			
			echo "\nTotal Results: ".$GLOBALS['ISC_CLASS_DB']->CountResult($result);
		}
		else
		{
			echo "Total Results: 0";
		}
  
	}
}

?>