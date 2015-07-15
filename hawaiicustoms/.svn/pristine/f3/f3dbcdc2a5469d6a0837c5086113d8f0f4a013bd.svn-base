<?php
/******************************************
* Page Name         : class.sweepstakes.php
* Containing Folder : classes
* Created By        : Baskaran B
* Created On        : 23rd March, 2010
* Modified By       : Baskaran B
* Modified On       : 24th March, 2010
* Description       : Display, add, edit and delete sweepstakes.
***************************************************************/

  class ISC_ADMIN_SWEEPSTAKES
    {

        public function HandleToDo($Do)
        {
            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('sweepstakes');

            switch (isc_strtolower($Do)) {
                case "addsweepstakes":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ViewSweepstakes') => "index.php?ToDo=viewSweepstakes", GetLang('AddSweepstakes') => "index.php?ToDo=addSweepstakes");

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->AddSweepstakes();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "savesweepstakes":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->SaveSweepstakes();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "deletesweepstakes":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->DeleteSweepstakes();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "editsweepstakes":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ViewSweepstakes') => "index.php?ToDo=viewSweepstakes", GetLang('EditSweepstakes') => "index.php?ToDo=editSweepstakes");

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->EditSweepstakes();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "saveeditedsweepstakes":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->SaveEditedSweepstakes();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                /* Starts for view users */
                case "viewersweepstakes":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ViewUsersSweepstakes') => "index.php?ToDo=viewerSweepstakes");

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        } 
                        $this->manageUsersSweepstakes();

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        } 
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                break;
                }
                case "addviewersweepstakes":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ViewUsersSweepstakes') => "index.php?ToDo=viewerSweepstakes", GetLang('AddSweepstakesUsers') => "index.php?ToDo=addViewerSweepstakes");

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->AddUsersSweepstakes();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                    break;
                }
                case "saveviewersweepstakes":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->SaveUsersSweepstakes();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "deleteviewsweepstakes":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->DeleteUsersSweepstakes();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "viewviewersweepstakes":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ViewUsersSweepstakes') => "index.php?ToDo=viewerSweepstakes", GetLang('SweepstakesViewUsersDetails') => "index.php?ToDo=viewViewerSweepstakes");

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->ViewUsersSweepstakes();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "editactivesweepstakes":   
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Sweepstakes') => "index.php?ToDo=viewSweepstakes", GetLang('SweepstakesViewUsersDetails') => "index.php?ToDo=viewSweepstakes");

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }
                        $this->editActiveSweepstakes();
                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                                
                 default:
                {   
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Sweepstakes') => "index.php?ToDo=viewSweepstakes");

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }

                        $this->manageSweepstakes();

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                }
            }
        }
        
       public function manageSweepstakes($MsgDesc = "", $MsgStatus = "")
        {
            
                $numMake = 0; 
                $GLOBALS['SweepstakesDataGrid'] = $this->ManageSweepstakesGrid($numMake);
                    
                // Was this an ajax based sort? Return the table now
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                    echo $GLOBALS['SweepstakesDataGrid'];
                    return;
                }
                $_SESSION['SweepstakesId'] = '';
                if ($MsgDesc != "") {
                    $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
                }


                $GLOBALS['SweepstakesIntro'] = GetLang('ManageSweepstakesIntro');

                // No results
                if($numMake == 0) {
                    $GLOBALS['DisplayGrid'] = "none";
                        $GLOBALS['Message'] = MessageBox(GetLang('NoSweepstakes'), MSG_SUCCESS);
                }

				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("sweepstakes.manage");
                $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
        
        public function AddSweepstakes()
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes();  
            $GLOBALS['SweepstakesTitle'] = GetLang('AddSweepstakes');
            $GLOBALS['SweepstakesIntro'] = GetLang('AddSweepstakesIntro');
            $image = '';
            for($i=1; $i<=5; $i++){
                $image .= "<tr><td>&nbsp;</td><td><input type=file name='images[]' class='Field200'></td></tr>";
            }
            $GLOBALS['ImageUpload'] = $image;
            $GLOBALS['CancelMessage'] = GetLang('CancelCreateSweepstakes');
            
            $wysiwygOptions = array(
                    'id'        => 'wysiwyg',
                    'width'     => '60%',
                    'height'    => '350px',
                    'value'     => ''
                );
            $wysiwygOptions1 = array(
                    'id'        => 'wysiwyg1',
                    'width'     => '60%',
                    'height'    => '350px',
                    'value'     => ''
                );                
            $GLOBALS['WYSIWYG'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions); 
            $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1); 
                            
            $GLOBALS['FormAction'] = "SaveSweepstakes";
            $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("sweepstakes.add.form");
            $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
        public function SaveSweepstakes() {
            if(isset($_POST['name'])) {

                // Save the sweepstakes details to the database
                $name = isc_html_escape(trim($_POST['name']));
                $title = isc_html_escape(trim($_POST['title']));
                $browsertitle = isc_html_escape($_POST['browsertitle']);
                $successmessage = $this->FormatWYSIWYGHTML($_POST['wysiwyg1']);
                $description = $this->FormatWYSIWYGHTML($_POST['wysiwyg']);
                $sdate = explode("/", $_POST['startdate']);
                $edate = explode("/", $_POST['enddate']);
                $startdate = $sdate[2]."-".$sdate[0]."-".$sdate[1];
                $enddate = $edate[2]."-".$edate[0]."-".$edate[1];
                $comments = trim($_POST['comments']);
                /*$images = $_POST['images'];
                $videos = $_POST['videos'];*/
                $createddate = date("Y-m-d H:i:s");

                        /*"images" => $images,
                        "videos" => $videos,*/
                                        
                    $newSweepstakes = array(
                        "name" => $name,
                        "title" => $title,
                        "browsertitle" => $browsertitle,
                        "successmessage" => $successmessage,
                        "description" => $description,
                        "startdate" => $startdate,
                        "enddate" => $enddate,
                        "comments" => $comments,
                        "createddate" => $createddate
                    );
                $GLOBALS['ISC_CLASS_DB']->InsertQuery("sweepstakes_master", $newSweepstakes);
                
                /*while(list($key,$value) = each($_FILES[images][name]))
                {
                    if(!empty($value)){   // this will check if any blank field is entered
                    $filename = $value;    // filename stores the value

                    $filename=str_replace(" ","_",$filename);// Add _ inplace of blank space in file name, you can remove this line

                    $add = "upimg/$filename";   // upload directory path is set
                    //echo $_FILES[images][type][$key];     // uncomment this line if you want to display the file type
                    // echo "<br>";                             // Display a line break
                    copy($_FILES[images][tmp_name][$key], $add);     //  upload the file to the server
                    chmod("$add",0777);                 // set permission to the file.
                    }
                }*/

                // Check for an error message from the database
                if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                    $this->manageSweepstakes(GetLang('SweepstakesAddedSuccessfully'), MSG_SUCCESS); 
                }
                else {
                    $this->manageSweepstakes(GetLang('SweepstakesAddedError'), MSG_ERROR);
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewSweepstakes");
                die();
            }            
        }
        
        public function DeleteSweepstakes()
        {
            $sid = $_GET['sid'];

            $GLOBALS['ISC_CLASS_DB']->DeleteQuery('sweepstakes_master', "WHERE sweepstakesid = '$sid'");

            if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                $this->manageSweepstakes(GetLang('SweepstakesDeletedSuccessfully'), MSG_SUCCESS);
            }
            else {
                $message = sprintf(GetLang('SweepstakesDeleteError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
                $this->manageSweepstakes($message, MSG_ERROR);
            }                
        }
        
        public function ManageSweepstakesGrid(&$numMake)
        {
            // Show a list of news in a table
            $page = 0;
            $start = 0;
            $numMake = 0;
            $numPages = 0;
            $GLOBALS['SweepstakesGrid'] = "";
            $GLOBALS['Nav'] = "";
            $max = 0;
            $searchURL = '';
		
            if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
                $sortOrder = 'desc';
            } else {
                $sortOrder = "asc";
            }

            $sortLinks = array(
                "Name" => "s.name"
            );

            if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
                $sortField = $_GET['sortField'];
                SaveDefaultSortField("manageSweepstakes", $_REQUEST['sortField'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("manageSweepstakes", "s.name", $sortOrder);
            }
            if (isset($_GET['page'])) {
                $page = (int)$_GET['page'];
            }
            else {
                $page = 1;
            }

            $sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
            $GLOBALS['SortURL'] = $sortURL;

            // Limit the number of MMY returned
            if ($page == 1) {
                $start = 1;
            }
            else {
                $start = ($page * ISC_SWEEPSTAKES_PER_PAGE) - (ISC_SWEEPSTAKES_PER_PAGE-1);
            }

            $start = $start-1;

            // Get the results for the query
            $SweepstakesResult = $this->_GetSweepstakesList($start, $sortField, $sortOrder, $numMake); //, &$where
			
            $numPages = ceil($numMake / ISC_SWEEPSTAKES_PER_PAGE);
            // Workout the paging navigation
            if($numMake > ISC_SWEEPSTAKES_PER_PAGE) {
                $GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

                $GLOBALS['Nav'] .= BuildPagination($numMake, ISC_SWEEPSTAKES_PER_PAGE, $page, sprintf("index.php?ToDo=viewSweepstakes%s".$con, $sortURL));
            }
            else {
                $GLOBALS['Nav'] = "";
            }

            $GLOBALS['SortField'] = $sortField;
            $GLOBALS['SortOrder'] = $sortOrder;

            BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewSweepstakes&amp;".$searchURL."&amp;page=".$page.$con, $sortField, $sortOrder);


            // Workout the maximum size of the array
            $max = $start + ISC_SWEEPSTAKES_PER_PAGE;

            if ($max > count($SweepstakesResult)) {
                $max = count($SweepstakesResult);
            }
            
//            echo $numMake;exit;
            if($numMake > 0) {
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($SweepstakesResult)) {
                    $GLOBALS['Name'] = $row['name'];
                    $GLOBALS['Title'] = $row['title'];
                    $sdate = explode("-", $row['startdate']);
                    $GLOBALS['StartDate'] = $sdate[1]."-".$sdate[2]."-".$sdate[0];
                    $edate = explode("-", $row['enddate']);
                    $GLOBALS['EndDate'] = $edate[1]."-".$edate[2]."-".$edate[0];
                    
                    $sweepid = $row['sweepstakesid'];
                     if($row['active'] == 1){
                        $GLOBALS['Active'] = "<a id='Active_".$sweepid."' title='".GetLang('ClickToNotUniversal')."' href='index.php?ToDo=editactivesweepstakes&amp;sid=".$sweepid."&amp;active=0' onclick=\"quickToggle(this); return false;\"><img border='0' src='images/tick.gif' alt='Active'></a>";
                    }
                    else {
                        $GLOBALS['Active'] = "<a id='Active_".$sweepid."' title='".GetLang('ClickToUniversal')."' href='index.php?ToDo=editactivesweepstakes&amp;sid=".$sweepid."&amp;active=1' onclick=\"quickToggle(this); return false;\"><img border='0' src='images/cross.gif' alt='InActive'></a>";
                    }
                    $mmyedit = GetLang('SweepstakesEdit');
                    $edit = GetLang('Edit');

                    $GLOBALS['EditSweepstakesLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editSweepstakes&amp;sid=%d'>%s</a>", GetLang('SweepstakesEdit'), $row['sweepstakesid'], GetLang('Edit'));
                    
                    $GLOBALS['DeleteSweepstakesLink'] = "<a title='".GetLang('SweepstakesDelete')."' class='Action' href='#' onclick=\"deleteSweepstakesid(".$row['sweepstakesid'].")\">".GetLang('Delete')."</a>";

                    $GLOBALS['ViewUsersSweepstakesLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=viewerSweepstakes&amp;sid=%d'>%s</a>", GetLang('SweepstakesViewUsers'), $row['sweepstakesid'], GetLang('SweepstakesViewUsers')); 
                    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sweepstakes.manage.row");
                    $GLOBALS['SweepstakesGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
                }
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sweepstakes.manage.grid");
                return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }

				
        }
        
        public function _GetSweepstakesList($Start, $SortField, $SortOrder, &$NumResults)
        {

            $query = "SELECT sweepstakesid, name, title, startdate, enddate, active FROM [|PREFIX|]sweepstakes_master s";

            $countQuery = "SELECT count(*) FROM [|PREFIX|]sweepstakes_master s ";
			
            $queryWhere = ' WHERE 1=1 ';
//            if ($Query != "") {
//                $queryWhere .= " AND LOWER(b.brandname) LIKE '%".$GLOBALS['ISC_CLASS_DB']->Quote($Query)."%'";
//            }

           /* $query .= $queryWhere;
            $countQuery .= $queryWhere;  */

            $result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
            $NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
            if($NumResults > 0) {
                $query .= " ORDER BY ".$SortField." ".$SortOrder;

                // Add the limit
                $query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_SWEEPSTAKES_PER_PAGE);
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                return $result;
                
            }
            else {
                return false;
            }
        }
        
        private function editActiveSweepstakes() {
            $sid = (int)$_GET['sid'];
            $active = (int)$_GET['active'];
            
            $queryPart = "sweepstakesid='".$GLOBALS['ISC_CLASS_DB']->Quote($sid)."'";
            $successMsg = sprintf(GetLang('QualifierSuccessfully'), '');       
            
            $updatedinactive = array(
                "active" => "0"
            ); 
            $GLOBALS['ISC_CLASS_DB']->UpdateQuery("sweepstakes_master", $updatedinactive);
            
            $updatedactive = array(
                "active" => $active
            ); 
            $GLOBALS['ISC_CLASS_DB']->UpdateQuery("sweepstakes_master", $updatedactive, $queryPart);

            unset($_REQUEST['active']);
            unset($_GET['active']);

            if ($GLOBALS["ISC_CLASS_DB"]->Error() == "") {
                if(isset($_REQUEST['ajax'])) {
                    //generate the javascript to update the visibility icon through ajax
                    $callBackJs = "";
                        $elementID = 'Active_'.$sid;
                        $callBackJs .= 'ToggleActiveIcon("'.$elementID.'", "active", '.$active.');';

                    header('Content-type: text/javascript');
                    echo $callBackJs;
                    echo "var status = 1; var message='".$successMsg."'";
                    exit;
                }
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
                    $this->manageSweepstakes('QualifierSuccessfully', MSG_SUCCESS);
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('QualifierSuccessfully'), MSG_SUCCESS);
                }                                
            } else { 
                if(isset($_REQUEST['ajax'])) {
                    header('Content-type: text/javascript');
                    echo "var status = 0;";
                    exit;
                }

                $err = '';
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
                    $this->manageSweepstakes(sprintf(ErrQualifierNotChanged, $err), MSG_ERROR);
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrQualifierNotChanged'), $err), MSG_ERROR);
                }
            }            
        }
                
        public function EditSweepstakes($MsgDesc = "", $MsgStatus = "")
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes(); 
            if(isset($_GET['sid'])) {
                if ($MsgDesc != "") {
                    $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
                }

                $sid = (int)$_GET['sid'];

                $query = "SELECT * FROM [|PREFIX|]sweepstakes_master where sweepstakesid = $sid";
                
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

                if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                    $GLOBALS['sid'] = $row['sweepstakesid'];
                    $GLOBALS['Name'] = $row['name'];
                    $GLOBALS['Title'] = $row['title'];
                    $GLOBALS['BrowserTitle'] = $row['browsertitle'];
                    $GLOBALS['SuccessMessage'] = $row['successmessage']; 
                    $GLOBALS['Comments'] = $row['comments'];
                    $sdate = explode("-", $row['startdate']);
                    $GLOBALS['StartDate'] = $sdate[1]."/".$sdate[2]."/".$sdate[0];
                    $edate = explode("-", $row['enddate']);
                    $GLOBALS['EndDate'] = $edate[1]."/".$edate[2]."/".$edate[0];
                    $wysiwygOptions = array(
                    'id'        => 'wysiwyg',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $row['description']
                    );
                    $wysiwygOptions1 = array(
                    'id'        => 'wysiwyg1',
                    'width'     => '60%',
                    'height'    => '350px',
                    'value'     => $row['successmessage']
                    );

                    $GLOBALS['WYSIWYG'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
                    $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
// need to get image                    
                    $GLOBALS['SweepstakesTitle'] = GetLang('EditSweepstakes');
                    $GLOBALS['SweepstakesIntro'] = GetLang('EditSweepstakesIntro');
                    $GLOBALS['CancelMessage'] = GetLang('CancelEditSweepstakes');
                    $GLOBALS['FormAction'] = "SaveEditedSweepstakes";

                    $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("sweepstakes.edit.form");
                    $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
                }
                else {
                    ob_end_clean();
                    header("Location: index.php?ToDo=viewSweepstakes");
                    die();
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewSweepstakes");
                die();
            }
        }
        
        public function SaveEditedSweepstakes()
        {
            if(isset($_POST['name'])) {

                $sid = $_POST['sid'];
                $name = isc_html_escape(trim($_POST['name']));
                $title = isc_html_escape(trim($_POST['title']));
                $browsertitle = isc_html_escape($_POST['browsertitle']);
                $successmessage = $this->FormatWYSIWYGHTML($_POST['wysiwyg1']); 
                $description = $this->FormatWYSIWYGHTML($_POST['wysiwyg']);
                $sdate = explode("/", $_POST['startdate']);
                $edate = explode("/", $_POST['enddate']);
                $startdate = $sdate[2]."-".$sdate[0]."-".$sdate[1];
                $enddate = $edate[2]."-".$edate[0]."-".$edate[1];
                $comments = isc_html_escape($_POST['comments']);

                $modifiedSweepstakes = array(
                    "name" => $name,
                    "title" => $title,
                    "browsertitle" => $browsertitle,
                    "successmessage" => $successmessage,
                    "description" => $description,
                    "startdate" => $startdate,
                    "enddate" => $enddate,
                    "comments" => $comments
                );
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("sweepstakes_master", $modifiedSweepstakes, "sweepstakesid='".$sid."'");
                if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                    $this->manageSweepstakes(GetLang('SweepstakesUpdatedSuccessfully'), MSG_SUCCESS);
                }
                else {
                    $this->manageSweepstakes(GetLang('SweepstakesUpdatedError'), MSG_ERROR);
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewSweepstakes");
                die();
            }
        }
        
        /**
        *    If the editor is disabled then we'll see if we need to run
        *    nl2br on the text if it doesn't contain any HTML tags
        */
        public function FormatWYSIWYGHTML($HTML)
        {

            if(GetConfig('UseWYSIWYG')) {
                return $HTML;
            }
            else {
                // We need to sanitise all the line feeds first to 'nl'
                $HTML = SanatiseStringToUnix($HTML);

                // Now we can use nl2br()
                $HTML = nl2br($HTML);

                // But we still need to strip out the new lines as nl2br doesn't really 'replace' the new lines, it just inserts <br />before it
                $HTML = str_replace("\n", "", $HTML);

                // Fix up new lines and block level elements.
                $HTML = preg_replace("#(</?(?:html|head|body|div|p|form|table|thead|tbody|tfoot|tr|td|th|ul|ol|li|div|p|blockquote|cite|hr)[^>]*>)\s*<br />#i", "$1", $HTML);
                $HTML = preg_replace("#(&nbsp;)+(</?(?:html|head|body|div|p|form|table|thead|tbody|tfoot|tr|td|th|ul|ol|li|div|p|blockquote|cite|hr)[^>]*>)#i", "$2", $HTML);
                return $HTML;
            }
        }
        
        public function manageUsersSweepstakes($MsgDesc = "", $MsgStatus = "")
        {       
                if($_SESSION['SweepstakesId'] == '') {
                    $_SESSION['SweepstakesId'] = $_GET['sid'];
                }

                $numMake = 0; 
                $GLOBALS['SweepstakesUsersDataGrid'] = $this->ManageUsersSweepstakesGrid($numMake);
                
                // Was this an ajax based sort? Return the table now
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                    echo $GLOBALS['SweepstakesUsersDataGrid'];
                    return;
                }

                if ($MsgDesc != "") {
                    $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
                }


                $GLOBALS['SweepstakesUsersIntro'] = GetLang('ManageSweepstakesUsersIntro');

                // No results
                if($numMake == 0) {
                    $GLOBALS['DisplayGrid'] = "none";
                        $GLOBALS['Message'] = MessageBox(GetLang('NoUsersSweepstakes'), MSG_SUCCESS);
                }

                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("sweepstakes.users.manage");
                $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
        
        public function AddUsersSweepstakes()
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes();  
            $GLOBALS['SweepstakesUsersTitle'] = GetLang('AddSweepstakesUsers');
            $GLOBALS['SweepstakesUsersIntro'] = GetLang('AddSweepstakesUsersIntro');
            
            $GLOBALS['UniversalCat'] = isset($params['catuniversal']) ? $params['catuniversal'] : 0;
            $GLOBALS['YearList']     = $this->getYMMOptions($params,'year');
            $GLOBALS['MakeList']     = $this->getYMMOptions($params,'make');
            $GLOBALS['ModelList']    = $this->getYMMOptions($params,'model');
            
            $GLOBALS['FormAction'] = "SaveViewerSweepstakes";
            $GLOBALS['CancelMessageUsers'] = GetLang('CancelAddUsersSweepstakes');
            
            $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("sweepstakes.users.add.form");
            $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
        public function SaveUsersSweepstakes() {
            if(isset($_POST['email'])) {

                // Save the sweepstakes details to the database
                $email = trim($_POST['email']);
                $newsletter = $_POST['receivingmail'];
                $firstname = trim($_POST['firstname']);
                $lastname = trim($_POST['lastname']);
                $phonenumber = trim($_POST['phonenumber']);
                $addressline1 = trim($_POST['addressline1']);
                $addressline2 = trim($_POST['addressline2']);
                $city = trim($_POST['city']);
                $state = $_POST['states'];
                $country = "United States";
                $zipcode = trim($_POST['zipcode']);
                $searchyear = $_POST['searchyear']; 
                $searchmake = $_POST['searchmake'];
                $searchmodel = $_POST['searchmodel'];
                $sweepstakesid = $_SESSION['SweepstakesId'];
                $addedby = "Admin Account";
                $createddate = date("Y-m-d H:i:s"); 
                $urlreferrer = $_POST['urlreferrer'];                   

                $userDetails = array(
                        'email' => $email,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'phonenumber' => $phonenumber,
                        'addressline1' => $addressline1,
                        'addressline2' => $addressline2,
                        'city' => $city,
                        'state' => $state,
                        'country' => $country,
                        'zipcode' => $zipcode,
                        'receivingmail' => $newsletter,
                        'year' => $searchyear,
                        'make' => $searchmake,
                        'model' => $searchmodel,
                        'sweepstakesid' => $sweepstakesid,
                        'addedby' => $addedby,
                        'createddate' => $createddate,
                		'urlreferrer'=>$urlreferrer
                    );
                    
                $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT email FROM [|PREFIX|]sweepstakes_users where email = '".$email."' and sweepstakesid = '$sweepstakesid'");
                $cnt = $GLOBALS['ISC_CLASS_DB']->CountResult($query);
                # Checking for whether a user can enter 5 enteries for a sweepstakes for one email id -- Baskaran
                if($cnt >= 5) {
                	$msg =sprintf(GetLang('Sweepstakes5Exists'),$email);
                    $this->manageUsersSweepstakes($msg, MSG_ERROR);
                }
                else {
                    $GLOBALS['ISC_CLASS_DB']->InsertQuery("sweepstakes_users", $userDetails);
                
                    if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                        $this->manageUsersSweepstakes(GetLang('SweepstakesUsersAddedSuccessfully'), MSG_SUCCESS);                        
                    }
                    else {
                        $this->manageUsersSweepstakes(GetLang('SweepstakesUsersAddedError'), MSG_ERROR);
                    }
                }    
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewerSweepstakes");
                die();
            }            
        }
        
        public function DeleteUsersSweepstakes()
        {
            $sid = $_GET['sid'];

            $GLOBALS['ISC_CLASS_DB']->UpdateQuery("sweepstakes_users",array('status'=> 0), "sweepsuserid = $sid");

            if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                $this->manageUsersSweepstakes(GetLang('SweepstakesUsersUpdatedSuccessfully'), MSG_SUCCESS);
            }
            else {
                $message = sprintf(GetLang('SweepstakesUsersUpdatedError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
                $this->manageUsersSweepstakes($message, MSG_ERROR);
            }                
        }
        
        public function ManageUsersSweepstakesGrid(&$numMake)
        {
            // Show a list of news in a table
            $page = 0;
            $start = 0;
            $numMake = 0;
            $numPages = 0;
            $GLOBALS['SweepstakesUsersGrid'] = "";
            $GLOBALS['Nav'] = "";
            $max = 0;
            $searchURL = '';
        
            if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
                $sortOrder = 'desc';
            } else {
                $sortOrder = "asc";
            }

            $sortLinks = array(
                "Createddate" => "s.createddate",
                "Name" => "s.firstname",
                "EmailId" => "s.email",
                "AddedBy" => "s.addedby",
                "ReceivingMail" => "s.receivingmail",
            	"Referrer" => "s.urlreferrer"
            );

            if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
                $sortField = $_GET['sortField'];
                SaveDefaultSortField("manageUsersSweepstakes", $_REQUEST['sortField'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("manageUsersSweepstakes", "s.createddate", $sortOrder);
            }
            if (isset($_GET['page'])) {
                $page = (int)$_GET['page'];
            }
            else {
                $page = 1;
            }

            $sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
            $GLOBALS['SortURL'] = $sortURL;

            // Limit the number of MMY returned
            if ($page == 1) {
                $start = 1;
            }
            else {
                $start = ($page * ISC_SWEEPSTAKES_USERS_PER_PAGE) - (ISC_SWEEPSTAKES_USERS_PER_PAGE-1);
            }

            $start = $start-1;

            // Get the results for the query
            $SweepstakesUsersResult = $this->_GetSweepstakesUsersList($start, $sortField, $sortOrder, $numMake); //, &$where
            
            $numPages = ceil($numMake / ISC_SWEEPSTAKES_USERS_PER_PAGE);
            // Workout the paging navigation
            if($numMake > ISC_SWEEPSTAKES_USERS_PER_PAGE) {
                $GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

                $GLOBALS['Nav'] .= BuildPagination($numMake, ISC_SWEEPSTAKES_USERS_PER_PAGE, $page, sprintf("index.php?ToDo=viewerSweepstakes%s".$con, $sortURL));
            }
            else {
                $GLOBALS['Nav'] = "";
            }

            $GLOBALS['SortField'] = $sortField;
            $GLOBALS['SortOrder'] = $sortOrder;

            BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewerSweepstakes&amp;".$searchURL."&amp;page=".$page.$con, $sortField, $sortOrder);


            // Workout the maximum size of the array
            $max = $start + ISC_SWEEPSTAKES_USERS_PER_PAGE;

            if ($max > count($SweepstakesUsersResult)) {
                $max = count($SweepstakesUsersResult);
            }
            
//            echo $numMake;exit;
            if($numMake > 0) {
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($SweepstakesUsersResult)) {
                    $GLOBALS['Email'] = $row['email'];
                    $GLOBALS['Name'] = $row['firstname']." ".$row['lastname'];
                    $GLOBALS['CreatedDate'] = date("m-d-Y",strtotime($row['createddate']));
                    $GLOBALS['AddedBy'] = $row['addedby'];
                    if($row['receivingmail'] == '1') 
                        $GLOBALS['ReceivingMail'] = "Yes";
                    else
                        $GLOBALS['ReceivingMail'] = "No";
                    
                    $GLOBALS['URLReferrer'] = $row['urlreferrer'];
                    
                    $status = $row['status'];
                    if($status == '1') {
                        $GLOBALS['Status'] = "Registered";
                    }
                    else {
                        $GLOBALS['Status'] = "Deleted";
                    }
                    $userid = $row['sweepsuserid'];

                    $GLOBALS['ViewSweepstakesUsersLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=viewViewerSweepstakes&amp;sid=%d'>%s</a>", GetLang('ViewUsers'), $userid, GetLang('ViewUsers'));
                    
                    $GLOBALS['DeleteSweepstakesUsersLink'] = "<a title='".GetLang('Delete')."' class='Action' href='#' onclick=\"deleteSweepstakesUsersid(".$row['sweepsuserid'].")\">".GetLang('Delete')."</a>";

                    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sweepstakes.users.manage.row");
                    $GLOBALS['SweepstakesUsersGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
                }
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sweepstakes.users.manage.grid");
                return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }
        }
        
        public function _GetSweepstakesUsersList($Start, $SortField, $SortOrder, &$NumResults)
        {
            $sweepstakesid = $_SESSION['SweepstakesId']; # This id should be passed as dynamic by selecting that sweepstakes.
            $squery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT startdate, enddate FROM [|PREFIX|]sweepstakes_master where sweepstakesid = '$sweepstakesid'");
            $row = $GLOBALS['ISC_CLASS_DB']->Fetch($squery);
            $stardate = $row['startdate'];
            $enddate = $row['enddate'];
            
            $query = "SELECT * FROM [|PREFIX|]sweepstakes_users s ";

            $countQuery = "SELECT count(*) FROM [|PREFIX|]sweepstakes_users s ";
            
            $queryWhere = " WHERE sweepstakesid = '$sweepstakesid' ";
//            if ($Query != "") {
//                $queryWhere .= " AND createddate BETWEEN '$stardate' AND  '$enddate' ORDER BY createddate desc";
//            }
            $query .= $queryWhere;
            $countQuery .= $queryWhere;
            
            $result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
            $NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
            
            if($NumResults > 0) {
                $query .= " ORDER BY ".$SortField." ".$SortOrder; //-- For column sort we need to un comment this -- Baskaran

                // Add the limit
                $query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_SWEEPSTAKES_USERS_PER_PAGE);
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                return $result;
            }
            else {
                return false;
            }
        }
        
        public function ViewUsersSweepstakes($MsgDesc = "", $MsgStatus = "")
        {
            if(isset($_GET['sid'])) {

                $sid = (int)$_GET['sid'];

                $query = "SELECT * FROM [|PREFIX|]sweepstakes_users where sweepsuserid = $sid";
                
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

                if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                    $GLOBALS['sid'] = $row['sweepstakesid'];
                    $GLOBALS['Email'] = $row['email'];
                    $GLOBALS['Name'] = $row['firstname']." ".$row['lastname'];
                    $GLOBALS['PhoneNumber'] = $row['phonenumber'];
                    $GLOBALS['AddressLine1'] = $row['addressline1'];
                    $GLOBALS['AddressLine2'] = $row['addressline2'];
                    $GLOBALS['City'] = $row['city'];
                    $GLOBALS['State'] = $row['state'];
                    $GLOBALS['Country'] = $row['country'];
                    $GLOBALS['ZipCode'] = $row['zipcode'];
                    $rmail = $row['receivingmail'];
                    if($rmail == 0) {
                        $GLOBALS['ReceivingMail'] = "No";
                    }
                    else {
                        $GLOBALS['ReceivingMail'] = "Yes";
                    }
                    $GLOBALS['Year'] = $row['year'];
                    $GLOBALS['Make'] = $row['make'];
                    $GLOBALS['Model'] = $row['model'];
                    $GLOBALS['OrderId'] = $row['orderid'];
                    $GLOBALS['UrlReferrer'] =$row['urlreferrer'];
                    $status = $row['status'];
                    if($status == '1')
                        $GLOBALS['Status'] = "Registered";
                    else
                        $GLOBALS['Status'] = "Deleted";
                    $GLOBALS['Addedby'] = $row['addedby'];
                    $cdate = $row['createddate'];
                    $GLOBALS['CreatedDate'] = isc_date('Y-m-d H:i:s', strtotime($cdate));
                    $GLOBALS['SweepstakesUsersTitle'] = GetLang('ViewUsersSweepstakesTitle');
                    $GLOBALS['SweepstakesUsersIntro'] = GetLang('ViewUsersSweepstakesIntro');
                    
                    $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("sweepstakes.users.view.form");
                    $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
                }
                else {
                    ob_end_clean();
                    header("Location: index.php?ToDo=viewerSweepstakes");
                    die();
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewerSweepstakes");
                die();
            }
        }
        
        public function SaveEditedUsersSweepstakes()
        {
            if(isset($_POST['name'])) {

                $sid = $_POST['sid'];
                $name = trim($_POST['name']);
                $title = trim($_POST['title']);
                $description = $this->FormatWYSIWYGHTML($_POST['wysiwyg']);
                $sdate = explode("/", $_POST['startdate']);
                $edate = explode("/", $_POST['enddate']);
                $startdate = $sdate[2]."-".$sdate[0]."-".$sdate[1];
                $enddate = $edate[2]."-".$edate[0]."-".$edate[1];
                $comments = trim($_POST['comments']);

                $modifiedSweepstakes = array(
                    "name" => $name,
                    "title" => $title,
                    "description" => $description,
                    "startdate" => $startdate,
                    "enddate" => $enddate,
                    "comments" => $comments
                );
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("sweepstakes_master", $modifiedSweepstakes, "sweepstakesid='".$sid."'");
                if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                    $this->manageSweepstakes(GetLang('SweepstakesUpdatedSuccessfully'), MSG_SUCCESS);
                }
                else {
                    $this->manageSweepstakes(GetLang('SweepstakesUpdatedError'), MSG_ERROR);
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewSweepstakes");
                die();
            }
        }
        
        function getYMMOptions($params,$ymm_type)
        {
            switch($ymm_type)
            {
                case 'year'        :     
                                    $options = "<option value=''>--select year--</option>";
                                    $filter_array = array();
                                    $ymm_qry = "select group_concat(v.prodstartyear separator '~') as prodstartyear , group_concat(v.prodendyear separator '~') as prodendyear from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
                                    if( isset($params['make']) && $GLOBALS['UniversalCat'] == 0 )
                                        $ymm_qry .= " and prodmake = '".$params['make']."' ";
                                    if( isset($params['model']) && (!isset($params['model_flag']) || $params['model_flag'] == 1) && $GLOBALS['UniversalCat'] == 0 )
                                        $ymm_qry .= " and prodmodel = '".$params['model']."' ";

                                    $ymm_qry .= " group by p.productid ";    
                                    $ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
                                    while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
                                    {
                                        $grp_startyear = explode("~",$ymm_row['prodstartyear']); 
                                        $grp_endyear = explode("~",$ymm_row['prodendyear']);
                                        for($g=0;$g<count($grp_startyear);$g++)
                                        {
                                            $prod_start_year = $grp_startyear[$g];
                                            $prod_end_year = $grp_endyear[$g]; 

                                            if(is_numeric($prod_start_year) && is_numeric($prod_end_year)) 
                                            {
                                                $prod_year_diff = $prod_end_year - $prod_start_year;
                                                for($i=0;$i<=$prod_year_diff;$i++)
                                                {
                                                    $actual_year = $prod_start_year + $i;
                                                    if(in_array($actual_year,$filter_array)) {
                                                       $count_filter_array[$actual_year]++;        
                                                    }  else {
                                                        $filter_array[] = $actual_year;
                                                        $count_filter_array[$actual_year] = 1;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    rsort($filter_array);
                                    foreach($filter_array as $key => $value)
                                    {
                                        $selected = "";
                                        if ( isset($params['year']) && strcasecmp($params['year'], $value) == 0 )
                                            $selected = " selected";

                                        $options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>";
                                    }
                                    break;
                case 'make'        : 
                                    $options = "<option value=''>--select make--</option>";
                                    $filter_array = array();
                                    $ymm_qry = "select group_concat(DISTINCT v.prodmake separator '~') as prodmake from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
                                    $ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
                                    while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
                                    {
                                        $filters = explode('~',$ymm_row['prodmake']);
                                        for($j=0;$j<count($filters);$j++) 
                                        {
                                            $filter_value = $filters[$j]; 
                                            if(strtoupper($filter_value) != "NON-SPEC VEHICLE" && strtolower($filter_value) != "all")
                                            {
                                                if(in_array($filter_value,$filter_array))   {
                                                    $count_filter_array[$filter_value]++;
                                                } else {
                                                    $filter_array[] = $filter_value;
                                                    $count_filter_array[$filter_value] = 1;
                                                }
                                            }
                                        }
                                    }
                                    sort($filter_array);
                                    $all_makes = array('CHEVROLET', 'GMC', 'FORD', 'DODGE', 'TOYOTA', 'NISSAN', 'HONDA', 'JEEP', 'HYUNDAI','CHRYSLER', 'INFINITI', 'LEXUS');
                                    $temp_arr =  array_diff($filter_array,$all_makes);

                                    foreach($all_makes as $key => $value) 
                                    {
                                        $selected = "";
                                        if ( isset($params['make']) && strcasecmp($params['make'], $value) == 0 )
                                            $selected = " selected";        
                                        
                                        $options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>"; 
                                    }

                                    foreach($temp_arr as $key => $value ) 
                                    {
                                        $selected = "";
                                        if ( isset($params['make']) && strcasecmp($params['make'], $value) == 0 )
                                            $selected = " selected";        

                                        $options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>";
                                    }
                                    break;
                case 'model'    : 
                                    $options = "<option value=''>--select model--</option>";
                                    if(isset($params['make']))
                                    {    
                                        $filter_array = array();
                                        $ymm_qry = "select distinct prodmodel from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
                                        if( isset($params['make']) )
                                            $ymm_qry .= " and prodmake = '".$params['make']."' ";
                                        if( isset($params['year']) && $GLOBALS['UniversalCat'] == 0 )
                                            $ymm_qry .= " and ".$params['year']." between prodstartyear and prodendyear ";

                                        //$ymm_qry .= " group by p.productid ";    
                                        $ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
                                        while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
                                        {
                                            if(!empty($ymm_row['prodmodel']) && $ymm_row['prodmodel'] != '~') {
                                               $filters = explode('~',$ymm_row['prodmodel']);
                                               for($j=0;$j<count($filters);$j++) 
                                               {
                                                    $filter_value = ucwords(strtolower($filters[$j]));
                                                    if(strtolower($filter_value) != "all")
                                                    {
                                                        if(in_array($filter_value,$filter_array))   {
                                                        } else {
                                                            $filter_array[] = $filter_value;
                                                        }
                                                    }
                                               }
                                            }
                                        }
                                        sort($filter_array);
                                        foreach($filter_array as $key => $value)
                                        {
                                            $selected = "";
                                            if ( isset($params['model']) && strcasecmp($params['model'], $value) == 0 )
                                                $selected = " selected";

                                            $options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>";
                                        }
                                    }
                                    break;
            }
            return $options;
        }
    }
?>
