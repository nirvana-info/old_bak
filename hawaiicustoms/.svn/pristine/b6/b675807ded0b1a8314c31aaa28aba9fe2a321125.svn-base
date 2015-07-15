<?php

  class ISC_ADMIN_DEFECT
    {
        public function HandleToDo($Do)
        {
            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('defect');
            switch (isc_strtolower($Do)) {
                case "deletedefect":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->DeleteDefect();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "editdefect":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ManageDefect') => "index.php?ToDo=manageDefect", GetLang('DefectEdit') => "index.php?ToDo=editDefect");

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->EditDefect();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "saveediteddefect":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->SaveEditedDefect();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                 default:
                {   
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ManageDefect') => "index.php?ToDo=manageDefect");

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }

                        $this->manageDefect();

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                }
            }
        }
        
       public function manageDefect($MsgDesc = "", $MsgStatus = "")
        {
            $numDefect = 0; 
            $GLOBALS['DefectDataGrid'] = $this->ManageDefectGrid($numDefect);

            // Was this an ajax based sort? Return the table now
            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                echo $GLOBALS['DefectDataGrid'];
                return;
            }

            if ($MsgDesc != "") {
                $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
            }


            $GLOBALS['DefectIntro'] = GetLang('DefectIntro');

            // No results
            if($numDefect == 0) {
                $GLOBALS['DisplayGrid'] = "none";
                    $GLOBALS['Message'] = MessageBox(GetLang('NoDefect'), MSG_SUCCESS);
            }

            $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("defect.manage");
            $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
        
        public function DeleteDefect()
        {
             $Id = $_GET['Id'];
            $GLOBALS['ISC_CLASS_DB']->DeleteQuery('defect_report', "WHERE id = '$Id'");
            if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                $this->manageDefect(GetLang('DefectDeletedSuccessfully'), MSG_SUCCESS);
            }
            else {
                $message = sprintf(GetLang('DefectDeleteError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
                $this->manageDefect($message, MSG_ERROR);
            }                
        }
        
        
        public function ManageDefectGrid(&$numDefect)
        {
            // Show a list of news in a table
            $page = 0;
            $start = 0;
            $numDefect = 0;
            $numPages = 0;
            $GLOBALS['DefectGrid'] = "";
            $GLOBALS['Nav'] = "";
            $max = 0;
            $searchURL = '';

                                     
            if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
                $sortOrder = 'asc';
            } else {
                $sortOrder = "desc";
            }

            $sortLinks = array(
                "SubmitTime" => "d.submittime",
                "Status" => "d.status"
            );

            if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
                $sortField = $_GET['sortField'];
                SaveDefaultSortField("manageDefect", $_REQUEST['sortField'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("manageDefect", "d.submittime", $sortOrder);
            }
            if (isset($_GET['page'])) {
                $page = (int)$_GET['page'];
            }
            else {
                $page = 1;
            }

            $sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
            $GLOBALS['SortURL'] = $sortURL;

            // Limit the number of Defect returned
            if ($page == 1) {
                $start = 1;
            }
            else {
                $start = ($page * ISC_DEFECT_PER_PAGE) - (ISC_DEFECT_PER_PAGE-1);
            }

            $start = $start-1;

            // Get the results for the query
            $defectResult = $this->_GetDefectList($start, $sortField, $sortOrder, $numDefect);
            $numPages = ceil($numDefect / ISC_DEFECT_PER_PAGE);

            // Workout the paging navigation
            if($numDefect > ISC_DEFECT_PER_PAGE) {
                $GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

                $GLOBALS['Nav'] .= BuildPagination($numDefect, ISC_DEFECT_PER_PAGE, $page, sprintf("index.php?ToDo=manageDefect%s", $sortURL));
            }
            else {
                $GLOBALS['Nav'] = "";
            }

            $GLOBALS['SortField'] = $sortField;
            $GLOBALS['SortOrder'] = $sortOrder;

            BuildAdminSortingLinks($sortLinks, "index.php?ToDo=manageDefect&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);


            // Workout the maximum size of the array
            $max = $start + ISC_DEFECT_PER_PAGE;

            if ($max > count($defectResult)) {
                $max = count($defectResult);
            }

            if($numDefect > 0) {
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($defectResult)) {
                    $GLOBALS['Id'] = (int) $row['id'];
                    if($row['userid'] != '' and $row['userid'] != 0) {
                        $GLOBALS['Userid'] = $this->GetCustomerName($row['userid']);
                    }
                    else {
                        $GLOBALS['Userid'] = "Guest";
                    }
                    $GLOBALS['Url'] = wordwrap(isc_html_escape($row['url']),35,'<br>',true);
                    $GLOBALS['Description'] = wordwrap(isc_html_escape($row['description']),40,'<br>',true);
                    $GLOBALS['Comment'] = isc_html_escape($row['comment']);
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
                    
                    $GLOBALS['Status'] = $status;
                    $GLOBALS['SubmitTime'] = isc_html_escape($row['submittime']);

                    // Workout the edit link -- do they have permission to do so?
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['EditDefectLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editDefect&amp;Id=%d'>%s</a>", GetLang('DefectEdit'), $row['id'], GetLang('Edit'));
                    } else {
                        $GLOBALS['EditDefectLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
                    }
                    
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Brands)) {
                         $GLOBALS['DeleteDefectLink'] = sprintf("<a title='%s' class='Action' href='#' onclick=deletedefectid(%d)>%s</a>", GetLang('DefectDelete'), $row['id'], GetLang('Delete'));
                    } else {
                        $GLOBALS['DeleteDefectLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Delete'));
                    }

                    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("defect.manage.row");
                    $GLOBALS['DefectGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
                }
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("defect.manage.grid");
                return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }
        }
        
        public function _GetDefectList($Start, $SortField, $SortOrder, &$NumResults)
        {
            $query = "SELECT * FROM [|PREFIX|]defect_report d";

            $countQuery = "SELECT COUNT(*) FROM [|PREFIX|]defect_report d";

            $queryWhere = ' WHERE 1=1 ';
            $query .= $queryWhere;
            $countQuery .= $queryWhere;

            $result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
            $NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
            if($NumResults > 0) {
                $query .= " ORDER BY ".$SortField." ".$SortOrder;

                // Add the limit
                $query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_DEFECT_PER_PAGE);
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                return $result;
                
            }
            else {
                return false;
            }
        }
        
        public function EditDefect($MsgDesc = "", $MsgStatus = "")
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes(); 
            if(isset($_GET['Id'])) {
                if ($MsgDesc != "") {
                    $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
                }

                $Id = (int)$_GET['Id'];
                $query = sprintf("select * from [|PREFIX|]defect_report where id='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($Id));
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

                if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                    $GLOBALS['Id'] = $row['id'];
                    if($row['userid'] != '' and $row['userid'] != 0) {
                        $GLOBALS['Userid'] = $this->GetCustomerName($row['userid']);
                    }
                    else {
                        $GLOBALS['Userid'] = "Guest";
                    }
                    $GLOBALS['Url'] = isc_html_escape($row['url']);
                    $GLOBALS['Description'] = isc_html_escape($row['description']);
                    $GLOBALS['Comment'] = isc_html_escape($row['comment']);
                    $GLOBALS['Status'] = $this->Status($row['status']);
                    $GLOBALS['SubmitTime'] = isc_html_escape($row['submittime']);
                    $GLOBALS['DefectTitle'] = GetLang('EditDefect');
                    $GLOBALS['DefectIntro'] = GetLang('EditDefectIntro');
                    $GLOBALS['CancelMessage'] = GetLang('CancelEditDefect');
                    $GLOBALS['FormAction'] = "SaveEditedDefect";

                    $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("defect.edit.form");
                    $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
                }
                else {
                    ob_end_clean();
                    header("Location: index.php?ToDo=manageDefect");
                    die();
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=manageDefect");
                die();
            }
        }
        
        public function SaveEditedDefect()
        {
            if(isset($_POST['status'])) {
                $id = $_POST['Id'];
                $status = $_POST['status'];
                $comment = trim($_POST['comment']);
                
                $updatedDefect = array(
                    "status" => $status,
                    "comment" => $comment
                );
//                print_r($updatedDefect);exit;
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("defect_report", $updatedDefect, "id='".$GLOBALS['ISC_CLASS_DB']->Quote($id)."'");
                if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                    $this->manageDefect(GetLang('DefectUpdatedSuccessfully'), MSG_SUCCESS);
                }
                else {
                    $this->manageDefect(sprintf(GetLang('DefectErrorUpdated'), $total), MSG_ERROR);
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=manageDefect");
                die();
            }
        }
        
        private function GetCustomerName($customer) 
        {
            $username = '';
            $query = "SELECT * FROM [|PREFIX|]customers where customerid = $customer";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) { 
                $username = $row['custconfirstname'].' '.$row['custconlastname'];
            }
            return $username;
        }
        
        private function Status($selectedStatus) 
        { 
            $options = ''; 
            $status = array('1' => 'Pending', '2' => 'Tobefixed', '3' => 'Fixed', '4' =>'Nottobefixed');
            foreach($status as $key => $value)
            {
                if($selectedStatus == $key) 
                $select = 'selected="selected"';
                else
                $select = '';
                $options.= '<option value="'.$key.'" '.$select.'>'.GetLang($value).'</option>';   
            }                                                         
            return $options;
        }   
    }
?>
