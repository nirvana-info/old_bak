<?php
/******************************************
* Page Name         : class.clearance.php
* Containing Folder : classes
* Created By        : Baskaran B
* Created On        : 18th June, 2010
* Modified By       : Baskaran B
* Modified On       : 18th June, 2010
* Description       : Display only assigned category for clearance.
******************************************************************/
require_once(ISC_BASE_PATH . "/lib/discountcalcs.php"); 
	class ISC_CLEARANCE
	{
        
		/*public function __construct()
		{
			// Load the data for this product
			$this->_SetOfferData(); 
		}  */

        public function HandlePage()
        {
            $action = '';
            /*if ($GLOBALS['EnableSEOUrls'] == 1 and count($GLOBALS['PathInfo']) > 0 ){
                if (isset ($GLOBALS['PathInfo'][1])) {
                    $_REQUEST['action'] = $GLOBALS['PathInfo'][1];
                }
                else
                {
                    $_REQUEST['action'] = $GLOBALS['PathInfo'][0];
                }
            }*/
            if (count($GLOBALS['PathInfo']) > 0 ){
                if (isset ($GLOBALS['PathInfo'][1])) {
                    $_REQUEST['action'] = $GLOBALS['PathInfo'][1];
                }
                else
                {             
                    $_REQUEST['action'] = $GLOBALS['PathInfo'][0];
                }
            }

			$params = array();
			for($i=1;$i<count($GLOBALS['PathInfo']);$i+=2)
			{
				if($GLOBALS['PathInfo'][$i+1] != '')
					$params[$GLOBALS['PathInfo'][$i]] = MakeURLNormal($GLOBALS['PathInfo'][$i+1]);
			}

			$number_of_days = 730 ;
			$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days ;
			
			if(isset($params['make']))
			{	
				setcookie( "last_search_selection[make]", $params['make'], $date_of_expiry ,"/");  

				if(isset($params['model']))
				{
					setcookie( "last_search_selection[model]", $params['model'], $date_of_expiry ,"/");        
				}
			}
			if(isset($params['year']))
			{
				setcookie( "last_search_selection[year]", $params['year'], $date_of_expiry ,"/" );  
			}

            if (isset($_REQUEST['action'])) {
                $action = isc_strtolower($_REQUEST['action']);
            }
            
            switch ($action)
            {
                case "savesweepstakes": {
                    $this->SaveSweepstakes();
                    break;
                } 
                case "successsweepstakes": {
                    $this->successSweepstakes();
                    break;
                }
                default: {
                    $this->ClearanceList();
                }
            }
        }

		public function ClearanceList($MsgDesc = "", $MsgStatus = "")
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes();
            $GLOBALS['HideErrorMessage'] = 'none';
            if ($MsgDesc != "") {
                $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
            }
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("clearance");
                $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
        }
	}

?>