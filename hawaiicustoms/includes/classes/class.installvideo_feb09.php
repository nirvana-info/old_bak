<?php

	class ISC_INSTALLVIDEO
	{
		var $_prodid = 0;
		var $_prodcurrentvideo = 0;
		var $_prodnumvideos = 0;
		var $_prodname = '';

		var $_variationid = 0;

		var $_prodvideos = array();       

		function __construct()
		{
			if (isset($_REQUEST['product_id'])) {
                $_GET['product_id'] = $_REQUEST['product_id'];
            }
            else if(isset($GLOBALS['PathInfo'][1])) {
                $_GET['product_id'] = preg_replace('#\.html$#i', '', $GLOBALS['PathInfo'][1]);
            }
            else {
                $_GET['product_id'] = '';
            }
            
            $this->_SetVideoData();
		}

		function _SetVideoData()
		{
			if(isset($_GET['product_id'])) {
				$this->_prodid = (int)$_GET['product_id'];

				// Load the product name
				$query = sprintf("select prodname from [|PREFIX|]products where productid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($this->GetProductId()));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$this->_prodname = $GLOBALS['ISC_CLASS_DB']->FetchOne($result, "prodname");
                 
				$query = "SELECT videoid, videoprodid, videofile, videotype, systemvideofile FROM [|PREFIX|]install_videos WHERE videoprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($this->GetProductId())."' AND (videofile LIKE '%.flv' || systemvideofile LIKE '%.flv' || videofile LIKE '%.swf' || systemvideofile LIKE '%.swf') order by videosort asc";
                                                                                                
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$this->_prodvideos[] = $row;
				}
                
				// How many videos are there?
				$this->_prodnumvideos = count($this->_prodvideos);

				// Which video should we show?
				if(isset($_GET['current_video'])) {
					$this->_prodcurrentvideo = (int)$_GET['current_video'];
				}
                
                //Added for dynamic gallery
                
                $this->CreateVideoGallery();
                
                //Added for dynamic gallery ends   
                
			}
		}
        
        function CreateVideoGallery()
        {
            $InsVideoGallery = '';  
            
            for($z=0; $z<count($this->_prodvideos); $z++)   { 
                
                if($this->_prodvideos[$z]['videotype']==1)    {
                     $filename =  $this->_prodvideos[$z]['systemvideofile'];
                }
                else    {
                     $filename =  $this->_prodvideos[$z]['videofile'];
                }
                
                $InsVideoGallery   .= '<tr>
                                        <td>
                                            <a style="color:#CCCCCC"  href="javascript:loadInsVideo(\''.$GLOBALS['ShopPath'].'/'.GetConfig('InstallVideoDirectory').'/'.$filename.'\');" title="Video '.($z+1).'">  
                                                Video'.($z+1).'
                                            </a>
                                        </td>
                                    </tr>';  
                if($z==0)    {
                       $FirstInsVideo = $GLOBALS['ShopPath'].'/'.GetConfig('InstallVideoDirectory').'/'.$filename;           
                       $GLOBALS['FirstInsVideo'] = 'loadInsVideo(\''.$FirstInsVideo.'\')';
                }
            }
            $GLOBALS['InsVideoGallery']  = $InsVideoGallery;
            //
        }

		function GetProductId()
		{
			return $this->_prodid;
		}

		function GetCurrentVideo()
		{
			return $this->_prodcurrentvideo;
		}

		function GetVideo()
		{
			// Return the video to be displayed. Returns an array on success, false on failure.
			if(isset($this->_prodvideos[$this->GetCurrentVideo()])) {
				return $this->_prodvideos[$this->GetCurrentVideo()];
			}
			else {
				return false;
			}
		}

		function GetNumVideos()
		{
			return $this->_prodnumvideos;
		}

		function HandlePage()
		{
			$this->ShowVideo();
		}

		function ShowVideo()
		{
			if($video = $this->GetVideo()) {

				// Set product name
				$GLOBALS['ProductName'] = isc_html_escape($this->_prodname);

				// Show we show the "Previous Video" link?
				if($this->GetCurrentVideo() == 0) {
					$GLOBALS['HidePrevLink'] = "none";
				}
				else {
					$GLOBALS['PrevLink'] = sprintf("%s/installvideo.php?product_id=%d&current_video=%d", $GLOBALS['ShopPath'], $this->GetProductId(), $this->GetCurrentVideo()-1);
				}

				// Should we show the "Next Video" link?
				if($this->GetNumVideos()-1 == $this->GetCurrentVideo()) {
					$GLOBALS['HideNextLink'] = "none";
				}
				else {
					$GLOBALS['NextLink'] = sprintf("%s/installvideo.php?product_id=%d&current_video=%d", $GLOBALS['ShopPath'], $this->GetProductId(), $this->GetCurrentVideo()+1);
				}

				//
				$GLOBALS['TotalVideos'] = $this->_prodnumvideos;
				$GLOBALS['CurrentVideo'] = sprintf(GetLang('VideoXOfY'), $this->GetCurrentVideo()+1, $GLOBALS['TotalVideos']);

				$GLOBALS['VideoFile'] = $video['videofile'];
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("installvideo");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
		}
	}

?>