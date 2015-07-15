<?php

	class ISC_PRODUCTAUDIO
	{
		var $_prodid = 0;
		var $_prodcurrentaudio = 0;
		var $_prodnumaudios = 0;
		var $_prodname = '';

		var $_variationid = 0;

		var $_prodaudios = array();       

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
            $this->_SetAudioData();
		}

		function _SetAudioData()
		{
			if(isset($_GET['product_id'])) {
				$this->_prodid = (int)$_GET['product_id'];

				// Load the product name
				$query = sprintf("select prodname from [|PREFIX|]products where productid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($this->GetProductId()));
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$this->_prodname = $GLOBALS['ISC_CLASS_DB']->FetchOne($result, "prodname");
                 
				$query = "SELECT audioid, audioprodid, audiofile, audiotype, isdownloaded, systemaudiofile FROM [|PREFIX|]audio_clips WHERE audioprodid='".$GLOBALS['ISC_CLASS_DB']->Quote($this->GetProductId())."' AND (audiofile LIKE '%.flv' || systemaudiofile LIKE '%.flv' || audiofile LIKE '%.swf' || systemaudiofile LIKE '%.swf') order by audiosort asc";
                                                                                                
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$this->_prodaudios[] = $row;
				}
                
				// How many audios are there?
				$this->_prodnumaudios = count($this->_prodaudios);

				// Which audio should we show?
				if(isset($_GET['current_audio'])) {
					$this->_prodcurrentaudio = (int)$_GET['current_audio'];
				}
                
                //Added for dynamic gallery
                
                $this->CreateAudioGallery();
                
                //Added for dynamic gallery ends   
                
			}
		}
        
        function CreateAudioGallery()
        {
            $AudioGallery = '';  
            
            for($z=0; $z<count($this->_prodaudios); $z++)   { 
                
                if($this->_prodaudios[$z]['audiotype']==1  && $this->_prodaudios[$z]['isdownloaded']==2)    {
                     $filename =  $this->_prodaudios[$z]['systemaudiofile'];
                }
                else    {
                     $filename =  $this->_prodaudios[$z]['audiofile'];
                }
                if(strpos($filename, 'http://')!==false)    {
                    $AudioLink = $filename;             
                } 
                else    {
                    $AudioLink = $GLOBALS['ShopPath'].'/'."audio_clips".'/'.$filename; 
                }
                $AudioGallery   .= '<tr>
                                        <td>
                                            <a style="color:#CCCCCC"  href="javascript:loadAudio(\''.$AudioLink.'\');" title="Audio '.($z+1).'">  
                                                Audio'.($z+1).'
                                            </a>
                                        </td>
                                    </tr>';
                if($z==0)    {
                    /*if(strpos($filename, 'http://')!==false)    {
                       $FirstAudio = $GLOBALS['ShopPath'].'/'."audio_clips".'/'.$filename;          
                    } 
                    else    {
                       $FirstAudio = $filename;   
                    }*/
                       $GLOBALS['FirstAudio'] = 'loadAudio(\''.$AudioLink.'\')';
                }
            }
            $GLOBALS['AudioGallery']  = $AudioGallery;
            //
        }

		function GetProductId()
		{
			return $this->_prodid;
		}

		function GetCurrentAudio()
		{
			return $this->_prodcurrentaudio;
		}

		function GetAudio()
		{
			// Return the audio to be displayed. Returns an array on success, false on failure.
			if(isset($this->_prodaudios[$this->GetCurrentAudio()])) {
				return $this->_prodaudios[$this->GetCurrentAudio()];
			}
			else {
				return false;
			}
		}

		function GetNumAudios()
		{
			return $this->_prodnumaudios;
		}

		function HandlePage()
		{
			$this->ShowAudio();
		}

		function ShowAudio()
		{
			if($audio = $this->GetAudio()) {

				// Set product name
				$GLOBALS['ProductName'] = isc_html_escape($this->_prodname);

				// Show we show the "Previous Audio" link?
				if($this->GetCurrentAudio() == 0) {
					$GLOBALS['HidePrevLink'] = "none";
				}
				else {
					$GLOBALS['PrevLink'] = sprintf("%s/productaudio.php?product_id=%d&current_audio=%d", $GLOBALS['ShopPath'], $this->GetProductId(), $this->GetCurrentAudio()-1);
				}

				// Should we show the "Next Audio" link?
				if($this->GetNumAudios()-1 == $this->GetCurrentAudio()) {
					$GLOBALS['HideNextLink'] = "none";
				}
				else {
					$GLOBALS['NextLink'] = sprintf("%s/productaudio.php?product_id=%d&current_audio=%d", $GLOBALS['ShopPath'], $this->GetProductId(), $this->GetCurrentAudio()+1);
				}

				//
				$GLOBALS['TotalAudios'] = $this->_prodnumaudios;
				//$GLOBALS['CurrentAudio'] = sprintf(GetLang('AudioXOfY'), $this->GetCurrentAudio()+1, $GLOBALS['TotalAudios']);

				$GLOBALS['AudioFile'] = $audio['audiofile'];
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("productaudio");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
		}    
	}

?>