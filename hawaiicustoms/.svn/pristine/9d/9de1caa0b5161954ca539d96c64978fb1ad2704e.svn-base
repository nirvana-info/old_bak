<?php

	class ISC_ADMIN_IMPORTLOG
	{
		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('common');
			switch (isc_strtolower($Do)) {
				
				case "downloadfileimportlog":
				{

				
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Import_Products)) {
						
						$filename = $_GET['f'];
						$user = $_GET['u'];
						$vendor = $_GET['v'];
												
						$fname = $filename."_".$vendor."_".$user.".csv";
						$file_path="rejected_data/".$fname;

						$nename =  date("F_j_Y_g_i_a",$filename);                 

						// file size in bytes
						$fsize = filesize($file_path); 

						$fileContents = file_get_contents($file_path);

						header("Content-length:".$fsize);
						header("Content-type: text/csv");
						header("Content-Disposition: attachment; filename=".$nename.".csv");
						echo $fileContents;
					
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				
				
				case "deleteimportlogfile":
				{

					
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Import_Products)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ImportLog') => "index.php?ToDo=viewBrands");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();

						$brandids =$GLOBALS['ISC_CLASS_DB']->Quote($_POST['brands']);

	
						foreach ($brandids as $value) {
						 $file = "rejected_data/".$value;


									if (file_exists($file)) {
										@unlink($file);
										clearstatcache();
									}

						}


						$this->ManageBrands(" File Deleted Successfully", MSG_SUCCESS);

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				default:
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Import_Products)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ImportLog') => "index.php?ToDo=viewBrands");

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						$this->ManageBrands();

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
			}
		}

		

		public function ManageBrandsGrid(&$numBrands)
		{
			// Show a list of news in a table
			
			$numBrands = 0;
			$numPages = 0;
			$indexCount =0;
			$GLOBALS['BrandGrid'] = "";
			

			$myDirectory = opendir("rejected_data");

			// get each entry
			while($entryName = readdir($myDirectory)) {
				$dirArray[] = $entryName;
			}

			// close directory
			closedir($myDirectory);

			//	count elements in array
			$indexCount	= count($dirArray);
			
		
			// sort 'em
			rsort($dirArray);
            $indexCount_temp = $indexCount;

			if ($indexCount_temp > 100) $indexCount_temp = 100;
			$index=0;
			// loop through the array of files and print them all
			while($index < $indexCount_temp ) {
				
				
					if (substr("$dirArray[$index]", 0, 1) != "."){ // don't list hidden files

						$GLOBALS['BrandId'] = $dirArray[$index];
						list($date, $vendorId, $userid) = split("_",substr($dirArray[$index], 0,-4) );
							
						if ($userid == $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUserId() || $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUserId() == 1)
						{

						$numBrands++;
						if (($indexCount_temp + $numBrands) < $indexCount)
						$indexCount_temp = $indexCount_temp + $numBrands;

						$filesize = $this->formatBytes(filesize("rejected_data/".$dirArray[$index]));
						$GLOBALS['BrandName'] = date("F j, Y, g:i a",$date);
						

						$query = "SELECT vendorname FROM [|PREFIX|]vendors WHERE vendorid='".$vendorId."'";
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
						$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
						$vendorname = $row['vendorname'];

						$query2 = "SELECT username  FROM [|PREFIX|]users where pk_userid = ".intval($userid);
						$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
						$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2);
						$GLOBALS['Products']  = ucwords($row['username']). " (".ucwords($vendorname).")";
							

						$GLOBALS['EditBrandLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=downloadfileimportlog&amp;u=".$userid."&amp;f=".$date."&amp;v=".$vendorId."'>%s</a>", GetLang('BrandEdit'), 'Download', GetLang('Download'))." (".$filesize.")" ;
								
						$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("importlog.manage.row");
						$GLOBALS['BrandGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
						}
							}
				$index++;			

				}


				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("importlog.manage.grid");
				return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);

				
			
		}

		public function ManageBrands($MsgDesc = "", $MsgStatus = "")
		{
			// Fetch any results, place them in the data grid
			$numBrands = 0;
			$GLOBALS['BrandsDataGrid'] = $this->ManageBrandsGrid($numBrands);

			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['BrandsDataGrid'];
				return;
			}

			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			

			$GLOBALS['BrandIntro'] = GetLang('ManageBrandsIntro');

			// Do we need to disable the delete button?
			if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Import_Products) || $numBrands == 0) {
				$GLOBALS['DisableDelete'] = "DISABLED";
			}

			// No results
			if($numBrands == 0) {
				$GLOBALS['DisplayGrid'] = "none";
				
					$GLOBALS['DisplaySearch'] = "none";
					$GLOBALS['Message'] = MessageBox('No files found', MSG_SUCCESS);
				
			}

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("importlog.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		
		
	public	function formatBytes($bytes, $precision = 2) 
		{ 
			$units = array('B', 'KB', 'MB', 'GB', 'TB'); 
		   
			$bytes = max($bytes, 0); 
			$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
			$pow = min($pow, count($units) - 1); 
		   
			$bytes /= pow(1024, $pow); 
		   
			return round($bytes, $precision) . ' ' . $units[$pow]; 
		} 
		
		
		

		

		
	}

?>
