<?php
date_default_timezone_set('Asia/Calcutta');
class ISC_DEFECTREPORT
{

	public function __construct()
	{
		$GLOBALS['GiftCertificateMinimum'] = GetConfig('GiftCertificateMinimum');
		$GLOBALS['GiftCertificateMaximum'] = GetConfig('GiftCertificateMaximum');

	}

	public function HandlePage()
	{
		$action = "";

		if ($GLOBALS['EnableSEOUrls'] == 1 and count($GLOBALS['PathInfo']) > 0 ){
				if (isset ($GLOBALS['PathInfo'][1])) {
					$_REQUEST['action'] = $GLOBALS['PathInfo'][1];
				}
				else
				{
					$_REQUEST['action'] = $GLOBALS['PathInfo'][0];
				}
			}

		if(isset($_REQUEST['action'])) {
			$action = isc_strtolower($_REQUEST['action']);
		}

		// Don't allow any access to this file if gift certificates aren't enabled
		if(GetConfig('EnableGiftCertificates') == 0) {
			ob_end_clean();
			header("Location: " . $GLOBALS['ShopPath']);
			die();
		}

		if(!gzte11(ISC_LARGEPRINT)) {
			ob_end_clean();
			header("Location: " . $GLOBALS['ShopPath']);
			die();
		}

		switch($action) {
			case "saved": {
				$this->SaveDefectForm();
				break;
			}
			case "reports": {
                if (CustomerIsSignedIn()) {
                    $this->ListReports();
                    break;
                }
                else {
                // Naughty naughty, you need to sign in to be here
                $this_page = urlencode(sprintf("account.php?action=%s", $action));
                ob_end_clean();
                header(sprintf("Location: %s/login.php?from=%s", $GLOBALS['ShopPath'], $this_page));
                die();
                }
			}
            case "editdefect": {
                if (CustomerIsSignedIn()) {
                    $this->EditDefectForm();
                    break;
                }
                else {
                // Naughty naughty, you need to sign in to be here
                $this_page = urlencode(sprintf("account.php?action=%s", $action));
                ob_end_clean();
                header(sprintf("Location: %s/login.php?from=%s", $GLOBALS['ShopPath'], $this_page));
                die();
                }
            }
            case "editsave":
            {
                $this->SaveEditedDefect();
            }
            case "deletedefect":
            {
                $this->DeleteDefect();
            }
			default: {
				$this->DisplayReport();
			}
		}
	}

	// Check the remaining balance of a gift certificate
	private function DisplayReport($MsgDesc = "", $MsgStatus = "")   
	{
        $GLOBALS['HideErrorMessage'] = 'none';
        if ($MsgDesc != "") {
            $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
        }                                            
        $GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');                                            
        $GLOBALS['customerid'] = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId(); 
        
        if($GLOBALS['customerid'] != '') {
            $GLOBALS['DisplayList'] = '';
            $GLOBALS['DisplayLogin'] = 'none';
        }
        else {
            $GLOBALS['DisplayList'] = 'none';
            $GLOBALS['DisplayLogin'] = '';
        }

        $GLOBALS['DefectReportTitle'] = GetLang('ReportaDefect');
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s", GetConfig('StoreName'), GetLang('DefectReport')));
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("displayreport");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

	} 
    
    private function SaveDefectForm() 
    {
         if(isset($_POST['url'])) {  
             $url = trim($_POST['url']);
             $description = trim($_POST['description']);
             $submittime = date('Y-m-d H:i:s');
             $status = '1';
             $userid = $_POST['cid'];
             
             $newForm = array(
                "userid" => $userid,
                "url" => $url,
                "description" => $description,
                "submittime" => $submittime,
                "status" => $status
             );
            $GLOBALS['ISC_CLASS_DB']->InsertQuery("defect_report", $newForm);
            if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                if($userid != '' and $userid != 0) {
                    FlashMessage(GetLang('ReportsavedSuccessfully'), MSG_SUCCESS, 'defectreport.php?action=reports'); 
                }
                else {
                    $this->DisplayReport(GetLang('ReportsavedSuccessfully'), MSG_SUCCESS);
                }
            }
            else {
                 if($userid != '' and $userid != 0) {  
                     FlashMessage(GetLang('ReportError'), MSG_ERROR, 'defectreport.php?action=reports'); 
                 }
                 else {
                    $message = sprintf(GetLang('ReportError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
                    $this->DisplayReport($message, MSG_ERROR);
                 }
            }
        }
        else {
            ob_end_clean();
            header(sprintf("Location: %s/defectreport.php", $GLOBALS['ShopPath']));   
            die();
        }
    }
    
    private function ListReports()
    {
        $GLOBALS['Message'] = GetFlashMessageBoxes(); 
        $GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
        $userid = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
        
         $GLOBALS['DefectGrid'] = '';
         
//        if(CustomerIsSignedIn()) {
            $query = "SELECT * FROM [|PREFIX|]defect_report where userid = $userid ORDER BY submittime DESC";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $cnt = $GLOBALS['ISC_CLASS_DB']->CountResult($result);
            if($cnt > 0) {
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $GLOBALS['url'] = wordwrap(($row['url']),40,'<br>',true);   
                $GLOBALS['description'] = $row['description'];
                $GLOBALS['comment'] = $row['comment'];
                $status = '';
                /*
                * 1 - The report is posted and it is pending.
                * 2 - Will be fixed and admin enter comment.
                * 3 - Issue is fixed and admin add comment.
                * 4 - The issue can't be fixed.
                */
                if($row['status'] == '1') {
                    $status = "Pending";
                }
                else if($row['status'] == '2') {
                    $status = "To be fixed";
                }
                else if($row['status'] == '3') {
                    $status = "Fixed";
                }
                else if($row['status'] == '4'){
                    $status = "Not to be fixed";
                }
                else {
                    $status = "No Status";
                }
                
                $GLOBALS['status'] = $status;
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("defect.row");
                if($row['status'] == '1') {
                    $GLOBALS['displayaction'] = '';
                    $GLOBALS['displaynoaction'] = 'none';
                    $GLOBALS['EditDefectLink'] = sprintf("<a title='%s' class='Action' href='defectreport.php?action=editdefect&amp;Id=%d'>%s</a>", GetLang('DefectEdit'), $row['id'], GetLang('Edit')); 
                    $GLOBALS['DeleteDefectLink'] = sprintf("<a title='%s' class='Action' href='#' onclick=deletedefectid(%d)>%s</a>", GetLang('DefectDelete'), $row['id'], GetLang('Delete')); 
                }
                else {
                    $GLOBALS['displayaction'] = 'none';
                    $GLOBALS['displaynoaction'] = '';
                    $GLOBALS['noaction'] = GetLang('Noaction');
                }
                    $GLOBALS['displayrecord'] = '';
                    $GLOBALS['displaynorecord'] = 'none';
                $GLOBALS['DefectGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }
            }
            else {
                $GLOBALS['norecords'] = GetLang('NoRecords'); 
                $GLOBALS['displayrecord'] = 'none';
                $GLOBALS['displaynorecord'] = '';
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("defect.row"); 
                $GLOBALS['DefectGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }
                         
        $GLOBALS['DefectReportTitle'] = GetLang('ListofReports');
        $GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s", GetConfig('StoreName'), GetLang('DefectReport')));
        $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("defectlist");
        $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
            
        /*}
        else {
                            echo "else";
        }     */
        

    }
    
    private function EditDefectForm() {
         if(isset($_GET['Id'])) {
             
            $GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
            $userid = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();
            
            $Id = (int)$_GET['Id'];
            # Status 1 is used to check whether the report is in pending.
            $query = sprintf("select * from [|PREFIX|]defect_report where id='%d' and status ='1' and userid = $userid ", $GLOBALS['ISC_CLASS_DB']->Quote($Id));
            $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

            if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                $GLOBALS['url'] = $row['url'];
                $GLOBALS['description'] = $row['description'];
                $GLOBALS['DefectReportTitle'] = GetLang('EditDefectReport');
                $GLOBALS['Id'] = $Id;

                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("defectedit");
                $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
            }
            else 
            {
                ob_end_clean();
                header("Location: " . $GLOBALS['ShopPath']);
                die();
            }
         }
         else 
         {
            ob_end_clean();
            header("Location: " . $GLOBALS['ShopPath']);
            die();
         }
    }
    
    private function SaveEditedDefect() 
    {
         if(isset($_POST['url'])) {
            $id = $_POST['Id'];
            $url = trim($_POST['url']);
            $description = trim($_POST['description']);
            
            $updatedDefect = array(
                "url" => $url,
                "description" => $description
            );
//                print_r($updatedDefect);exit;
            $GLOBALS['ISC_CLASS_DB']->UpdateQuery("defect_report", $updatedDefect, "id='".$GLOBALS['ISC_CLASS_DB']->Quote($id)."'");
            if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
//                    $this->ListReports(GetLang('DefectUpdated'), MSG_SUCCESS);
                FlashMessage(GetLang('DefectUpdated'), MSG_SUCCESS, 'defectreport.php?action=reports');
            }
            else {
//                    $this->ListReports(GetLang('DefectErrorUpdated'), MSG_ERROR);
                FlashMessage(GetLang('DefectErrorUpdated'), MSG_ERROR, 'defectreport.php?action=reports');
            }
        }
        else {
            ob_end_clean();
            header(sprintf("Location: %s/defectreport.php?action=reports", $GLOBALS['ShopPath'])); 
            die();
        }
    }
    
    private function DeleteDefect() 
    {
        $Id = $_GET['Id'];
        $GLOBALS['ISC_CLASS_DB']->DeleteQuery('defect_report', "WHERE id = '$Id'");
        if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
            FlashMessage(GetLang('DefectDelete'), MSG_SUCCESS, 'defectreport.php?action=reports');
        }
        else {
            $message = sprintf(GetLang('DefectDeleteError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
            FlashMessage($message, MSG_ERROR, 'defectreport.php?action=reports');            
        } 
    }
}

?>
