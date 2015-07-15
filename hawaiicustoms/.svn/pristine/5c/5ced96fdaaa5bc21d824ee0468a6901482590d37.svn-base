<?php

    ini_set('display_errors', 1);
    
	class ISC_LIVEVIDEO
	{
		
        var $_prodvideos = array(); 
        
        function __construct()
		{
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
              //windows, can't do thread detection
              $threads = 1;    
            }else{        
              //check for PHP PID and abort
              $pids = preg_split('/\s+/', `ps -o pid --no-heading -C php`);
              $threads = 0;
              foreach($pids as $pid) {
                if(is_numeric($pid)) {
                  $threads++;
                  echo "Process " . $pid." found\r\n";
                }
              } 
            }
            
            if($threads <= 1)    {  
                $this->_GetPendingFiles("product_videos");
                $this->_GetPendingFiles("install_videos");
                $this->_GetPendingFiles("audio_clips");
                $this->_GetPendingFiles("instruction_files");
                $this->_GetPendingFiles("article_files");
            }
             
		}
        
        public function _GetPendingFiles($FileType)
        {
            if($FileType=="product_videos")  {
                 $table_name = "product_videos";
            }
            else if($FileType=="install_videos")   {
                 $table_name = "install_videos";
            }
            else if($FileType=="audio_clips") {     
                 $table_name = "audio_clips";                        
            }
            else if($FileType=="instruction_files") {     
                 $table_name = "instruction_files";                        
            }
            else if($FileType=="article_files") {     
                 $table_name = "article_files";                        
            }
            
            $QueryFields = $this->GetQueryFields($FileType); 
            
            if($FileType=="product_videos" || $FileType=="install_videos")    {
                $query = sprintf("SELECT videoid, videoprodid, videofile, systemvideofile FROM [|PREFIX|]".$table_name." WHERE videotype='1' AND isdownloaded = '0' order by videoid asc");  // 
            }  
            else    {                              //if($FileType=="audio_clips" || $FileType=="instruction_files")  for else if
                $query = sprintf("SELECT ".$QueryFields['FileId'].", ".$QueryFields['FileProdId'].", ".$QueryFields['FileURL'].", ".$QueryFields['SystemFile']." FROM [|PREFIX|]".$table_name." WHERE ".$QueryFields['DownloadFileType']."='1' AND isdownloaded = '0' order by ".$QueryFields['FileId']." asc");  // LIMIT 1
            }                                                                                      
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);

            $this->_prodvideos = array();
                        
            ##Values of isdownloaded  are 
            #0 -> Pending, 
            #1 -> Download in progress, 
            #2 -> Downloaded successful, 
            #3 -> Download failed or partially download, 
            #4 -> Invalid youtube URL 
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $this->_prodvideos[] = $row;
            }
            
            for ($z=0; $z<count($this->_prodvideos); $z++)  { 
                if($FileType=="product_videos" || $FileType=="install_videos")    {
                    $cur_cquery = "SELECT ".$QueryFields['FileId'].", ". $QueryFields['FileURL']. " from [|PREFIX|]".$table_name." WHERE videotype='1' AND isdownloaded = '0' AND ".$QueryFields['FileId']."=".$this->_prodvideos[$z][$QueryFields['FileId']]." ";
                }
                else    {                         //if($FileType=="audio_clips" || $FileType=="instruction_files")   for else if
                    $cur_cquery = "SELECT ".$QueryFields['FileId'].", ". $QueryFields['FileURL']. " from [|PREFIX|]".$table_name." WHERE ".$QueryFields['DownloadFileType']."='1' AND isdownloaded = '0' AND ".$QueryFields['FileId']."=".$this->_prodvideos[$z][$QueryFields['FileId']]." ";
                }
                $cur_cresult    = $GLOBALS['ISC_CLASS_DB']->Query($cur_cquery);
                $NumRows        = $GLOBALS['ISC_CLASS_DB']->CountResult($cur_cresult); 
                
                if($NumRows>0)   {
                 
                    $row            = $GLOBALS['ISC_CLASS_DB']->Fetch($cur_cresult);     
                    $ismagnaflow    = strrpos($row[$QueryFields['FileURL']], "magnaflow");
                    $isswf          = strrpos($row[$QueryFields['FileURL']], ".swf");   
                    $isflv          = strrpos($row[$QueryFields['FileURL']], ".flv");      
                    
                    if($table_name == "install_videos" || $table_name == "product_videos")    {  
                        if(($ismagnaflow !== false && $isswf !== false) || $isflv!==false)    {
                            $NewLink = "magnaflow";
                        }                                                                              
                        else    {
                            $NewLink = $this->FormatLink($this->_prodvideos[$z][$QueryFields['FileURL']], 1);
                        }
                    }
                    else {                           //if($table_name == "audio_clips" || $table_name == "instruction_files")    for else if   
                        $isinvalidfile  = strrpos($row[$QueryFields['FileURL']], ".htm"); 
                        if($isinvalidfile === false)    {
                            $NewLink = "magnaflow";
                        }
                        else    {
                            $NewLink = "invalid";
                        }
                    }
                    
                    if($NewLink != "invalid")    {                                                          
                        $query = sprintf("UPDATE [|PREFIX|]".$table_name." SET isdownloaded = '1', ".$QueryFields['FileUpdatedTime']."=NOW() WHERE ".$QueryFields['FileId']." = ".$this->_prodvideos[$z][$QueryFields['FileId']].""); 
                        $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                        if($NewLink != "magnaflow")    {
                            $SystemVideoPath = $this->DownloadLiveVideo($NewLink, $FileType);
                        }
                        else    {       
                            $SystemVideoPath = $this->DownloadMagnaflow($this->_prodvideos[$z][$QueryFields['FileURL']], $FileType); 
                        }
                        if($SystemVideoPath!='failed')    {
                             $query_u = sprintf("UPDATE [|PREFIX|]".$table_name." SET isdownloaded = '2', ".$QueryFields['SystemFile']."='".$SystemVideoPath."', ".$QueryFields['FileUpdatedTime']."=NOW() WHERE ".$QueryFields['FileId']." = ".$this->_prodvideos[$z][$QueryFields['FileId']]."");
                             $result = $GLOBALS['ISC_CLASS_DB']->Query($query_u);   
                        }
                        else    {
                             $query = sprintf("UPDATE [|PREFIX|]".$table_name." SET isdownloaded = '3', ".$QueryFields['SystemFile']."='', ".$QueryFields['FileUpdatedTime']."=NOW() WHERE ".$QueryFields['FileId']." = ".$this->_prodvideos[$z][$QueryFields['FileId']]."");                                                                                                    
                        $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                        }     
                    }
                    else    {
                        //update as invalid youtube url
                        $query = sprintf("UPDATE [|PREFIX|]".$table_name." SET isdownloaded = '4', ".$QueryFields['SystemFile']."='', ".$QueryFields['FileUpdatedTime']."=NOW() WHERE ".$QueryFields['FileId']." = ".$this->_prodvideos[$z][$QueryFields['FileId']]."");                                                                                                    
                        $result = $GLOBALS['ISC_CLASS_DB']->Query($query); 
                    }
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
        
        /**
        * @desc : Used only for youtube videos
        * @pattern : Youtube pattern
        * @FileType : video table name
        */
        private function CheckVideoInSystem($pattern, $FileType="product_videos")    {
            
            if($FileType=="product_videos")  {
                 $table_name = "product_videos";
                 $dir = GetConfig('VideoDirectory');
            }
            else if($FileType=="install_videos")    {
                 $table_name = "install_videos";
                 $dir = GetConfig('InstallVideoDirectory');
            }
            /*else if($FileType=="audio_clips")    {
                 $table_name = "audio_clips";
                 $dir = "audio_clips";
            }*/
            $QueryFields = $this->GetQueryFields($FileType); 
            $query = "SELECT systemvideofile FROM [|PREFIX|]".$table_name." WHERE videotype='1' AND isdownloaded = '2' AND CAST(systemvideofile AS BINARY) LIKE '%$pattern%' LIMIT 1 ";    

            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            
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
            
            @clearstatcache();
            @ini_set('output_buffering','off'); // output buffer fix
            @ini_set('max_execution_time',0); // time limit fix 
            @ini_set('memory_limit', '1024M'); // memory problem fix
            error_reporting(1);
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
            
            if(filesize($dest)>1*1024)    {
                return $fileName;
            }
            else    {
                return "failed";
            }
        }  
        
        /**
        * @desc : Used for Magnaflow videos and other files also
        * @url : File URL
        * @FileType : table name of the file
        */
        private function DownloadMagnaflow($url, $FileType="product_videos"){
            
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
            
            //$patternName = "magnaflow.swf"; 
            $patternName = substr($url, strrpos($url, "/")+1);  
            
            $randomFileName = GenRandFileName($patternName);
              
              
            if ($FileType == "product_videos" || $FileType == "install_videos") {
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
            else  {                                      //if($FileType == "audio_clips" || $FileType == "instruction_files")   for else if
                
                $fileName = $randomFileName;
                
                $dest = realpath(ISC_BASE_PATH."/" . $dir);
                while(file_exists($dest."/".$fileName)) {
                    $fileName = basename($randomFileName);
                    $fileName = substr_replace($randomFileName, "-".rand(0, 10000000000), strrpos($randomFileName, "."), 0);
                    $fileName = $fileName;
                }
                
            }
            
            $dest .= "/".$fileName;  
            ini_set("display_errors", 1);
            $flv_http_path = $url;   
            $data = file_get_contents($flv_http_path);   
            
            file_put_contents($dest, $data);  
            
            if(filesize($dest)>1*1024)    {
                return $fileName;
            }
            else    {
                return "failed";
            }
        }   
        
        public function GetQueryFields($FileType)
        {
            switch($FileType)    
            {
                case "product_videos":
                    $QueryFields = array(
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
                    $QueryFields = array(           
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
                    $QueryFields = array(
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
                    $QueryFields = array(
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
                    $QueryFields = array(
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
            return $QueryFields;
        }
        
            
	}

?>
