<?php
    
	class ISC_ADMIN_FILE_MANAGEMENT
	{
		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('filemanagement');
			switch (isc_strtolower($Do)) {
				case "telechargerfilesfilemanagement":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_File_Management)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('viewFileManagement') => "index.php?ToDo=viewFileManagement");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DownloadFiles();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				default:
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_File_Management)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('FileManagement') => "index.php?ToDo=viewFileManagement");

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						$this->ManageFiles();

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
			}
		}

		public function _GetFilesList(&$Query, $TableName, $QueryFields, $Start, $SortField, $SortOrder, &$NumResults)
		{
			// Return an array containing details about qualifierassociations.
			// Takes into account search too.

			// PostgreSQL is case sensitive for likes, so all matches are done in lower case
			$Query = trim(isc_strtolower($Query));
            
			$query = "
				SELECT fl.".$QueryFields['FileId']." fileid, fl.".$QueryFields['FileURL']." fileurl, fl.".$QueryFields['FileProdId'].", fl.isdownloaded, p.prodname 
                FROM [|PREFIX|]".$TableName." fl 
                INNER JOIN [|PREFIX|]products p ON fl.".$QueryFields['FileProdId']." = p.productid    
			";

			$countQuery = "                           
                            SELECT COUNT(fl.".$QueryFields['FileId'].") 
                            FROM [|PREFIX|]".$TableName." fl 
                            INNER JOIN [|PREFIX|]products p ON fl.".$QueryFields['FileProdId']." = p.productid
                ";

			$queryWhere = ' WHERE fl.isdownloaded != "2" ';
            /*if ($TableName == "install_videos" || $TableName == "product_videos") {
                $queryWhere .= " AND fl.videotype = '1' ";
            }
            
            if ($TableName == "audio_clips") {
                $queryWhere .= " AND fl.audiotype = '1' ";
            } */
            
            $queryWhere .= " AND fl.".$QueryFields['DownloadFileType']." = '1' ";
            
			/*if ($Query != "") {
				$queryWhere .= " AND LOWER(b.qualifierassociationname) LIKE '%".$GLOBALS['ISC_CLASS_DB']->Quote($Query)."%'";
			} */
            
			$query      .= $queryWhere;
			$countQuery .= $queryWhere;
           
			$result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
			$NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

			if($NumResults > 0) {
				$query .= " ORDER BY fl.".$QueryFields['FileId'].", ".$SortField." ".$SortOrder;
                /*
				//Add the limit
				$query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_BRANDS_PER_PAGE);  
                */  
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
				return $result;
			}
			else {
				return false;
			}
		}

		public function ManageFilesGrid(&$numFiles)
		{
			
            $AllFiles                   = array("product_videos", "install_videos", "audio_clips", "instruction_files", "article_files");   
            $AllFileTitles              = array("Product Videos", "Install Videos", "Audio Clips", "Instruction Files", "Article Files");  
            $FileStatus                 = array("Pending", 
                                                "Download in progress", 
                                                "Downloaded successful", 
                                                "Download failed or partially downloaded", 
                                                "Invalid or unknown URL"
                                                );

            $FilesMainGrid              = "";
            $GLOBALS['TabTitle']        = "";
            $GLOBALS['AllFileTypes']    = "";
            
            foreach($AllFiles as $FileT)    {     
                $GLOBALS['AllFileTypes']    .= "'".$FileT."',";
            }
            
            $GLOBALS['AllFileTypes']        = trim($GLOBALS['AllFileTypes'], ",");
            //$GLOBALS['AllFileTypes']      = implode(",", $AllFiles); 
            
            $index = 0;
            
            foreach($AllFiles as $FileType)   {        
                
               $GLOBALS['FileType']   = $FileType; 
               $tableName = $FileType; 
                
               $queryFields = $this->GetQueryFields($FileType);                                                                                                                                              
                // Show a list of news in a table
                $page = 0;
                $start = 0;
                $numFiles = 0;
                $numPages = 0;
                $GLOBALS['FilesGrid'] = "";
                $GLOBALS['Nav'] = "";
                $max = 0;
                $searchURL = '';

                if (isset($_GET['searchQuery'])) {
                    $query = $_GET['searchQuery'];
                    $GLOBALS['Query'] = $query;
                    $searchURL .'searchQuery='.urlencode($query);
                } else {
                    $query = "";
                    $GLOBALS['Query'] = "";
                }

                if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
                    $sortOrder = 'desc';
                } else {
                    $sortOrder = "asc";
                }

                $sortLinks = array(           
                    "FileId" => "fl.".$queryFields['FileId'],
                    "FileURL" => "fl.".$queryFields['FileURL'],  
                );

                if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
                    $sortField = $_GET['sortField'];
                    SaveDefaultSortField("ManageQualifierAssociations", $_REQUEST['sortField'], $sortOrder);
                }
                else {
                    list($sortField, $sortOrder) = GetDefaultSortField("FilesGrid", "fl.".$queryFields['FileId'], $sortOrder);
                }
                /*
                if (isset($_GET['page'])) {
                    $page = (int)$_GET['page'];
                }
                else {
                    $page = 1;
                }
                */
                $sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
                $GLOBALS['SortURL'] = $sortURL;
                /*
                // Limit the number of files returned
                if ($page == 1) {
                    $start = 1;
                }
                else {
                    $start = ($page * ISC_BRANDS_PER_PAGE) - (ISC_BRANDS_PER_PAGE-1);
                }

                $start = $start-1;
                */  
			    // Get the results for the query
			    $filesResult = $this->_GetFilesList($query, $tableName, $queryFields, $start, $sortField, $sortOrder, $numFiles); 
                            
			    $numPages = ceil($numFiles / ISC_BRANDS_PER_PAGE);   
                /*
			    // Workout the paging navigation
			    if($numFiles > ISC_BRANDS_PER_PAGE) {
				    $GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

				    $GLOBALS['Nav'] .= BuildPagination($numFiles, ISC_BRANDS_PER_PAGE, $page, sprintf("index.php?ToDo=viewFileMangement%s", $sortURL));
			    }
			    else {
				    $GLOBALS['Nav'] = "";
			    }
                */
			    $GLOBALS['SearchQuery'] = $query;
			    $GLOBALS['SortField'] = $sortField;
			    $GLOBALS['SortOrder'] = $sortOrder;

			    BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewFileMangement&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);                    
                
			    // Workout the maximum size of the array
			    $max = $start + ISC_BRANDS_PER_PAGE;

			    if ($max > count($filesResult)) {
				    $max = count($filesResult);
			    }
                $GLOBALS['DivIndex']     = $index; 
                
                $GLOBALS['TabTitle'] .= '<li><a href="#" id="tab'.$index.'" onclick="ShowTab('.$index.')">'.$AllFileTitles[$index].'</a></li>' ;
                
			    if($numFiles > 0) { 
                    $GLOBALS['DisplayTabGrid'] = "block"; 
                    $GLOBALS['TabMessage']     = "";    
				    // Display the news
				    while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($filesResult)) {
					    $GLOBALS['FileId']      = (int) $row['fileid'];
					    $GLOBALS['FileURL']     = $row['fileurl'];
					    $GLOBALS['ProductName'] = $row['prodname'];
                        $GLOBALS['FileStatus']  = $FileStatus[$row['isdownloaded']];
                        
					    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("filemanagement.manage.row");
					    $GLOBALS['FilesGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
				    }       
			    }
                else    {
                    $GLOBALS['DisplayTabGrid'] = "none"; 
                    $GLOBALS['TabMessage']     = "No Pending Files Found!";
                }      
                
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("filemanagement.manage.grid");
                $FilesMainGrid .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true); 
                
                $index++;     
                 
            }    
            
            return $FilesMainGrid;        
                    
		}
        
        public function GetQueryFields($FileType)
        {
            switch($FileType)    
            {
                case "product_videos":
                    $queryFields = array(
                        "FileId" => "videoid",
                        "FileURL" => "videofile",
                        "FileProdId" => "videoprodid",
                        "FileUpdatedTime" => "videoupdatedtime", 
                        "SystemFile" => "systemvideofile", 
                        "FileType" => "product_videos", 
                        "DownloadFileType" => "videotype",                             
                    );                      
                    break;
                    
                case "install_videos":
                    $queryFields = array(           
                        "FileId" => "videoid",
                        "FileURL" => "videofile",
                        "FileProdId" => "videoprodid",
                        "FileUpdatedTime" => "videoupdatedtime", 
                        "SystemFile" => "systemvideofile", 
                        "FileType" => "install_videos", 
                        "DownloadFileType" => "videotype",  
                    );                        
                    break;  
                    
                case "audio_clips":
                    $queryFields = array(
                        "FileId" => "audioid",
                        "FileURL" => "audiofile",
                        "FileProdId" => "audioprodid",
                        "FileUpdatedTime" => "audioupdatedtime", 
                        "SystemFile" => "systemaudiofile", 
                        "FileType" => "audio_clips", 
                        "DownloadFileType" => "audiotype",  
                    );                        
                    break;       
                    
                case "instruction_files":
                    $queryFields = array(
                        "FileId" => "instructionid",
                        "FileURL" => "instructionfile",
                        "FileProdId" => "instructionprodid",
                        "FileUpdatedTime" => "instructionupdatedtime", 
                        "SystemFile" => "systeminstructionfile", 
                        "FileType" => "instruction_files", 
                        "DownloadFileType" => "instructiontype",  
                    );                        
                    break;             
                
                case "article_files":
                    $queryFields = array(
                        "FileId" => "articleid",
                        "FileURL" => "articlefile",
                        "FileProdId" => "articleprodid",
                        "FileUpdatedTime" => "articleupdatedtime", 
                        "SystemFile" => "systemarticlefile", 
                        "FileType" => "article_files", 
                        "DownloadFileType" => "articletype",  
                    );                        
                    break;  
                        
                default:
                    //
                    break;
            }
            return $queryFields;
        }
        
		public function ManageFiles($MsgDesc = "", $MsgStatus = "")
		{
			
            // Fetch any results, place them in the data grid
			$numFiles = 0;
			$GLOBALS['FilesDataGrid'] = $this->ManageFilesGrid($numFiles);

			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['FilesDataGrid'];
				return;
			}                
            
			if ($MsgDesc != "") {  
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			if (isset($_GET['searchQuery'])) {
				$GLOBALS['ClearSearchLink'] = '<a id="SearchClearButton" href="index.php?ToDo=viewQualifierAssociations">'.GetLang('ClearResults').'</a>';
			} else {
				$GLOBALS['ClearSearchLink'] = '';
			}

			$GLOBALS['FileManagementIntro'] = GetLang('FileManagementIntro');

			// Do we need to disable the delete button?
			if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Qualifier_Associations) || $numFiles == 0) {
				$GLOBALS['DisableDelete'] = "DISABLED";
			}
            
			// No results
			/*
            if($numFiles == 0) {
				$GLOBALS['DisplayGrid'] = "none";
				if(count($_GET) > 1) {
					if ($MsgDesc == "") {
						$GLOBALS['Message'] = MessageBox(GetLang('NoFileResults'), MSG_ERROR);
					}
				}
				else {
					$GLOBALS['DisplaySearch'] = "none";
					$GLOBALS['Message'] = MessageBox(GetLang('NoFiles'), MSG_SUCCESS);
				}
			}
            */
             
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("filemanagement.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		public function DownloadFiles()
		{
			
            if (isset($_POST['currentFileType'])) { 
                 $Files = $_POST['currentFileType']."_files";
                 $table_name = $_POST['currentFileType'];
                 $queryFields = $this->GetQueryFields($_POST['currentFileType']);
            }
                        
            if (isset($_POST[$Files])) { 
                
                $fileids = $_POST[$Files];
                
                foreach($fileids as $fileid)   {
                    
                    $cur_cquery = "SELECT ". $queryFields['FileId']. ", ". $queryFields['FileURL']. " FROM [|PREFIX|]".$table_name." ";
                    
                    $queryWhere = " WHERE ". $queryFields['FileId']. " = '".$fileid."' ";
                    
                    $queryWhere .= " AND isdownloaded != '2' AND isdownloaded != '1'";
                    /*
                    if ($table_name == "install_videos" || $table_name == "product_videos") {
                        $queryWhere .= " AND videotype = '1' "; 
                    }
                       
                    if ($table_name == "audio_clips") {
                        $queryWhere .= " AND audiotype = '1' "; 
                    }  
                    */
                    
                    $queryWhere .= " AND ".$queryFields['DownloadFileType']." = '1' "; 
                    
                    $cur_cquery    .= $queryWhere; 
                    
                    $cur_cresult    = $GLOBALS['ISC_CLASS_DB']->Query($cur_cquery);
                    $NumRows        = $GLOBALS['ISC_CLASS_DB']->CountResult($cur_cresult); 
                    
                    if($NumRows > 0)   { 
                        $row            = $GLOBALS['ISC_CLASS_DB']->Fetch($cur_cresult);     
                        $ismagnaflow    = strrpos($row[$queryFields['FileURL']], "magnaflow");    
                        $isswf          = strrpos($row[$queryFields['FileURL']], ".swf");    
                        
                        if($table_name == "install_videos" || $table_name == "product_videos")    {
                            if($ismagnaflow !== false && $isswf !== false)    {
                                $NewLink = "magnaflow";
                            }                                                                              
                            else    {
                                $NewLink = $this->FormatLink($row[$queryFields['FileURL']], 1);
                            }
                        }
                        else {                  //if($table_name == "audio_clips" || $table_name == "instruction_files")   for else if 
                            $isinvalidfile  = strrpos($row[$queryFields['FileURL']], ".htm"); 
                            if($isinvalidfile === false)    {
                                $NewLink = "magnaflow";
                            }
                            else    {
                                $NewLink = "invalid";
                            }
                        }
                        
                        if($NewLink != "invalid")    {
                            $query = sprintf("UPDATE [|PREFIX|]".$table_name." SET isdownloaded = '1', ".$queryFields['FileUpdatedTime']."=NOW() WHERE ".$queryFields['FileId']." = ".$fileid.""); 
                            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                            if($NewLink != "magnaflow")    {
                                $SystemVideoPath = $this->DownloadLiveVideo($NewLink, $table_name);
                            }
                            else    {
                                $SystemVideoPath = $this->DownloadMagnaflow($row[$queryFields['FileURL']], $table_name); 
                            }
                            if($SystemVideoPath!='failed')    {
                                 $query_u = sprintf("UPDATE [|PREFIX|]".$table_name." SET isdownloaded = '2', ".$queryFields['SystemFile']."='".$SystemVideoPath."', ".$queryFields['FileUpdatedTime']."=NOW() WHERE ".$queryFields['FileId']." = ".$fileid."");          
                                 $result = $GLOBALS['ISC_CLASS_DB']->Query($query_u);   
                            }
                            else    {
                                 $query = sprintf("UPDATE [|PREFIX|]".$table_name." SET isdownloaded = '3', ".$queryFields['SystemFile']."='', ".$queryFields['FileUpdatedTime']."=NOW() WHERE ".$queryFields['FileId']." = ".$fileid."");                                                                                                    
                            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                            }
                        }
                        else    {
                            //update as invalid youtube url                                              
                            $query = sprintf("UPDATE [|PREFIX|]".$table_name." SET isdownloaded = '4', ".$queryFields['SystemFile']."='', ".$queryFields['FileUpdatedTime']."=NOW() WHERE ".$queryFields['FileId']." = ".$fileid."");                                                                                                    
                            $result = $GLOBALS['ISC_CLASS_DB']->Query($query); 
                        }
                    }
                }
				$err = $GLOBALS["ISC_CLASS_DB"]->Error();
				if ($err != "") {
					$this->ManageFiles($err, MSG_ERROR);
				} else {
					$this->ManageFiles(GetLang('FilesDownloadedSuccessfully'), MSG_SUCCESS);
				}
			} else {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_File_Management)) {
					$this->ManageFiles();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}
        
        //Get Youtube URL in desired format
        public function FormatLink($link, $format='0') {       
            $isyoutube = strrpos($link, "youtube");    
            if($isyoutube === false)    {
                 return $status = "invalid";
            }
            else    {
                $str_pos = strrpos($link, "/v/");
                if($str_pos !==false)    {
                      $you_code = substr($link, $str_pos+3, 11);
                }
                else    {
                    $str_pos  = strrpos($link, "?v=");
                    $you_code = substr($link, $str_pos+3, 11);
                } 
                if(strlen($you_code)==11)    {
                    if($format=='0')    {                                        
                        $you_link = 'http://www.youtube.com/v/'.$you_code;
                    }
                    else    {
                        $you_link = 'http://www.youtube.com/watch?v='.$you_code;
                    }
                    return $you_link;
                }
                else    {
                    return $status = "invalid";
                }
            } 
        }
        
        private function CheckVideoInSystem($pattern, $FileType)    {
                       
            if ($FileType == "product_videos") {
                 $table_name = "product_videos";
                 $dir = GetConfig('VideoDirectory');         
            }
            else if ($FileType == "install_videos") { 
                $table_name = "install_videos";     
                $dir = GetConfig('InstallVideoDirectory');                        
            }
            /*else if ($FileType == "audio_clips") {     
                $dir = "audio_clips";                        
            }*/
            
            $query = "SELECT systemvideofile FROM [|PREFIX|]".$table_name." WHERE videotype='1' AND isdownloaded = '2' AND CAST(systemvideofile AS BINARY) LIKE '%$pattern%' LIMIT 1 ";

            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $SysFile = '';
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                 $SysFile = $row['systemvideofile'];
            }
            
            $SysFileFullPath = realpath(ISC_BASE_PATH . "/" . $dir . "/" . $SysFile);
             
            if(file_exists($SysFileFullPath) && filesize($SysFileFullPath)>10*1024)   {
                return $SysFile;
            }
            else    {
                return false;
            }
            
        }
        
        /**
        * @desc : Used only for youtube videos
        * @url : Youtube URL
        * @FileType : video table name
        */
        private function DownloadLiveVideo($url, $FileType){
            
            include(ISC_BASE_PATH . "/livevideos/phptube.php");
            include(ISC_BASE_PATH . "/livevideos/functions.php");
            
            @clearstatcache();
            @ini_set('output_buffering','off'); // output buffer fix
            @ini_set('max_execution_time',0); // time limit fix 
            @ini_set('memory_limit', '1024M'); // memory problem fix
            @ignore_user_abort(1);
            @set_time_limit(0);
            //@ob_end_clean();
            //@ob_implicit_flush(TRUE); 
             
            $pattern = getPatternFromUrl($url);
                       
            if ($FileType == "product_videos") {
                $dir = GetConfig('VideoDirectory');         
            }
            else if ($FileType == "install_videos") {    
                $dir = GetConfig('InstallVideoDirectory');                        
            }
            
            $SysVideo = $this->CheckVideoInSystem($pattern, $FileType);
            
            if($SysVideo != false)    {
                return $SysVideo;
            } 
                
            $patternName = $pattern.".flv"; 
            
            $randomFileName = GenRandFileNameCS($patternName);
                                                                                
            if (is_dir(sprintf(ISC_BASE_PATH."/" ."%s", $dir))) {
                // Images and downloads will be stored within a directory randomly chosen from a-z. 
                $randomDir = strtolower(chr(rand(65, 90))); 
                if(!is_dir(ISC_BASE_PATH."/" .$dir."/".$randomDir)) {          
                    if(!@mkdir(ISC_BASE_PATH."/" .$dir."/".$randomDir, 0777)) {   
                        $randomDir = '';
                    }
                }
            }
            $fileName = $randomDir . "/" . $randomFileName;
            
            $dest = realpath(ISC_BASE_PATH."/" . $dir);    
            while(file_exists($dest."/".$fileName)) {
                $fileName = basename($randomFileName);
                $fileName = substr_replace($randomFileName, "-".rand(0, 10000000000), strrpos($randomFileName, "."), 0);
                $fileName = $randomDir . "/" . $fileName;
            }   
        
            
            $dest .= "/".$fileName;  
            
            $tube = new PHPTube ();
            $flv_http_path = $tube->download($pattern);   
            $data = file_get_contents($flv_http_path);   
            
            file_put_contents($dest, $data);  
            
            if(filesize($dest)>10*1024)    {
                return $fileName;
            }
            else    {
                return "failed";
            }
        }                                       
        
        private function DownloadMagnaflow($url, $FileType){
            
            @clearstatcache();
            @ini_set('output_buffering','off'); // output buffer fix
            @ini_set('max_execution_time',0); // time limit fix 
            @ini_set('memory_limit', '1024M'); // memory problem fix
            error_reporting(1);
            @ignore_user_abort(1);
            @set_time_limit(0);
            //@ob_end_clean();
            //@ob_implicit_flush(TRUE); 
                       
            if ($FileType == "product_videos") {
                $dir = GetConfig('VideoDirectory');         
            }
            else if ($FileType == "install_videos") {     
                $dir = GetConfig('InstallVideoDirectory');                        
            }
            else if ($FileType == "audio_clips") {     
                $dir = "audio_clips";                        
            }
            else if ($FileType == "instruction_files") {     
                $dir = "instruction_file";                        
            }
            else if ($FileType == "article_files") {
                $dir = "article_file";
            }
            
            /*$SysVideo = $this->CheckVideoInSystem($pattern, $FileType);
            
            if($SysVideo != false)    {
                return $SysVideo;
            }*/       
            $patternName = substr($url, strrpos($url, "/")+1);
            
            $randomFileName = GenRandFileName($patternName);
              
            if($FileType == "product_videos" || $FileType == "install_videos") {
                if (is_dir(sprintf(ISC_BASE_PATH."/" ."%s", $dir))) {
                    // Images and downloads will be stored within a directory randomly chosen from a-z. 
                    $randomDir = strtolower(chr(rand(65, 90))); 
                    if(!is_dir(ISC_BASE_PATH."/" .$dir."/".$randomDir)) {          
                        if(!@mkdir(ISC_BASE_PATH."/" .$dir."/".$randomDir, 0777)) {   
                            $randomDir = '';
                        }
                    }
                }
                $fileName = $randomDir . "/" . $randomFileName;
                
                $dest = realpath(ISC_BASE_PATH."/" . $dir);
                while(file_exists($dest."/".$fileName)) {
                    $fileName = basename($randomFileName);
                    $fileName = substr_replace($randomFileName, "-".rand(0, 10000000000), strrpos($randomFileName, "."), 0);
                    $fileName = $randomDir . "/" . $fileName;
                }
                   
            } 
            else    {                                     //if($FileType == "audio_clips" || $FileType == "instruction_files")    for else if
                $fileName = $randomFileName;

                $dest = realpath(ISC_BASE_PATH."/" . $dir);
                while(file_exists($dest."/".$fileName)) {
                    $fileName = basename($randomFileName);
                    $fileName = substr_replace($randomFileName, "-".rand(0, 10000000000), strrpos($randomFileName, "."), 0);
                    $fileName = $fileName;
                }
                
            }
             
            
            $dest .= "/".$fileName;
            
            $flv_http_path = $url;   
            $data = file_get_contents($flv_http_path);   
            
            file_put_contents($dest, $data);  
            
            if(filesize($dest)>10*1024)    {
                return $fileName;
            }
            else    {
                return "failed";
            }
        }
	}

?>
