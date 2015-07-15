<?php

  class ISC_ADMIN_MMY
    {
        public function HandleToDo($Do)
        {
            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('mmy');
            switch (isc_strtolower($Do)) {
                case "viewmmy":
                {  
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ViewMMY') => "index.php?ToDo=viewMMY");
                        if(!isset($_GET['ajax']))    {     
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }
                        $this->manageMMY();
//                           ob_end_flush();

                        if(!isset($_GET['ajax']))    {     
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                    break;
                }
                case "addmmy":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ViewMMY') => "index.php?ToDo=viewMMY", GetLang('AddMMY') => "index.php?ToDo=addMmy");

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->AddMMY();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "savemmy":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->SaveMMY();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "deletemmy":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->DeleteMMY();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "editmmy":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ViewMMY') => "index.php?ToDo=viewMMY", GetLang('EditMMY') => "index.php?ToDo=editMMY");

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->EditMMY();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "saveeditedmmy":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->SaveEditedMMY();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "dloadfilemmy":
                { 
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->DownloadFile();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                
                /* Code for YMM,Engine type and liter*/
                 case "viewenginemmy":
                {  
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ViewEngineMMY') => "index.php?ToDo=viewEngineMMY");
                        if(!isset($_GET['ajax']))    {     
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }
                        $this->manageEngineMMY();
                        if(!isset($_GET['ajax']))    {     
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                    break;
                }
                case "addenginemmy":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ViewEngineMMY') => "index.php?ToDo=viewEngineMMY", GetLang('AddMMY') => "index.php?ToDo=addMmy");

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->AddEngineMMY();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "saveenginemmy":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->SaveEngineMMY();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "deleteenginemmy":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->DeleteEngineMMY();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "editenginemmy":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ViewEngineMMY') => "index.php?ToDo=viewEngineMMY", GetLang('EditEngineMMY') => "index.php?ToDo=editEngineMMY");

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->EditEngineMMY();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "saveeditedenginemmy":
                {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->SaveEditedEngineMMY();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "dloadfileenginemmy":
                { 
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->DownloadEngineFile();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                /* Code ends */
                 default:
                {   
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Series') => "index.php?ToDo=viewSeries");

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }

                        $this->manageMMY();

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                }
            }
        }
        
       public function manageMMY($MsgDesc = "", $MsgStatus = "")
        {
            // Fetch any results, place them in the data grid
            $GLOBALS['catuserid'] = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUserId(); 
            $user = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
            $userrole = $user['userrole'];
            
                $numMake = 0; 
                $GLOBALS['MMYDataGrid'] = $this->ManageMMYGrid($numMake);
                    
                // Was this an ajax based sort? Return the table now
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                    echo $GLOBALS['MMYDataGrid'];
                    return;
                }

                if ($MsgDesc != "") {
                    $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
                }


                $GLOBALS['MMYIntro'] = GetLang('ManageMMYIntro');

                if($userrole == 'admin') {
                    $GLOBALS['DisplayYMM'] = '';
                    $GLOBALS['DisplayDownload'] = 'none';
                }
                else {
                    $GLOBALS['DisplayYMM'] = 'none';
                    $GLOBALS['DisplayDownload'] = '';
                }

                // No results
                if($numMake == 0) {
                    $GLOBALS['DisplayGrid'] = "none";
                        $GLOBALS['Message'] = MessageBox(GetLang('NoMMY'), MSG_SUCCESS);
                }

                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("mmy.manage");
                $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
        
        public function AddMMY()
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes();  
            $GLOBALS['MMYTitle'] = GetLang('AddMMY');
            $GLOBALS['MMYIntro'] = GetLang('AddMMYIntro');
            $GLOBALS['CancelMessage'] = GetLang('CancelCreateMMY');
            $GLOBALS['FormAction'] = "SaveMmy";
            $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("mmy.add.form");
            $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
        public function SaveMMY() {
            if(isset($_POST['year'])) {

                // Save the brands to the database
                $year = trim($_POST['year']);
                $make = trim($_POST['make']);
                $model = trim($_POST['model']);
                $submodel = trim($_POST['submodel']);
                
                $cabsize = trim($_POST['cabsize']);
                $bedsize = trim($_POST['bedsize']);
                
                $total = '';
                if($submodel != '') {
                    $total = $year.', '.$make.', '.$model.', '.$submodel;
                }
                else {
                    $total = $year.', '.$make.', '.$model;
                }
                    $newMMY = array(
                        "year" => $year,
                        "make" => $make,
                        "model" => $model,
                        "submodel" => $submodel
                    );
                $sub_query = $GLOBALS["ISC_CLASS_DB"]->Query("insert into [|PREFIX|]product_mmy 
                                set year = '".$year."', 
                                    make = '".$make."', 
                                    model = '".$model."', 
                                    submodel = '".$submodel."'
                                ON DUPLICATE KEY UPDATE 
                                    submodel = '".$submodel."'");
                $insertid = mysql_insert_id();
                $cabbed = array(
                    "ymm_id" => $insertid,
                    "cabsize" => $cabsize,
                    "bedsize" => $bedsize
                );
                
                $cnt = mysql_affected_rows();
                
                // Check for an error message from the database
                if($cnt == 1) {
                    $GLOBALS['ISC_CLASS_DB']->InsertQuery("cabbed_table", $cabbed);
                    $this->manageMMY(GetLang('MMYAddedSuccessfully'), MSG_SUCCESS); 
                }
                else {
                    if($cnt == 0) {
                        FlashMessage(sprintf(GetLang('MMYAlreadyAdded'),$total), MSG_ERROR, 'index.php?ToDo=addMmy');
                    }
                    else {
                        $message = sprintf(GetLang('MMYAddError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
                        $this->manageMMY($message, MSG_ERROR);
                    }
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewMMY");
                die();
            }            
        }
        
        public function DeleteMMY()
        {
            $Id = $_GET['Id'];
            $GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_mmy', "WHERE id = '$Id'");
            $GLOBALS['ISC_CLASS_DB']->DeleteQuery('cabbed_table', "WHERE ymm_id = '$Id'");
            if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                $this->manageMMY(GetLang('MMYDeletedSuccessfully'), MSG_SUCCESS);
            }
            else {
                $message = sprintf(GetLang('MMYDeleteError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
                $this->manageMMY($message, MSG_ERROR);
            }                
        }
        
        
        public function ManageMMYGrid(&$numMake)
        {
            // Show a list of news in a table
            $page = 0;
            $start = 0;
            $numMake = 0;
            $numPages = 0;
            $GLOBALS['MMYGrid'] = "";
            $GLOBALS['Nav'] = "";
            $max = 0;
            $searchURL = '';

                                     
            if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
                $sortOrder = 'desc';
            } else {
                $sortOrder = "asc";
            }

            $sortLinks = array(
                "Make" => "p.make",
                "Model" => "p.model"
            );

            if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
                $sortField = $_GET['sortField'];
                SaveDefaultSortField("manageMMY", $_REQUEST['sortField'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("manageMMY", "p.make", $sortOrder);
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
                $start = ($page * ISC_MMY_PER_PAGE) - (ISC_MMY_PER_PAGE-1);
            }

            $start = $start-1;

            // Get the results for the query
            $mmyResult = $this->_GetMMYList($start, $sortField, $sortOrder, $numMake);
            $numPages = ceil($numMake / ISC_MMY_PER_PAGE);
            // Workout the paging navigation
            if($numMake > ISC_MMY_PER_PAGE) {
                $GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

                $GLOBALS['Nav'] .= BuildPagination($numMake, ISC_MMY_PER_PAGE, $page, sprintf("index.php?ToDo=viewMMY%s", $sortURL));
            }
            else {
                $GLOBALS['Nav'] = "";
            }

            $GLOBALS['SortField'] = $sortField;
            $GLOBALS['SortOrder'] = $sortOrder;

            BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewMMY&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);


            // Workout the maximum size of the array
            $max = $start + ISC_MMY_PER_PAGE;

            if ($max > count($mmyResult)) {
                $max = count($mmyResult);
            }
            
            $user = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
            $userrole = $user['userrole'];
            if($userrole == 'admin') {
                $GLOBALS['DisplayAction'] = '';
            }
            else {
                $GLOBALS['DisplayAction'] = 'none';
            }
//            echo $numMake;exit;
            if($numMake > 0) {
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($mmyResult)) {
                    $GLOBALS['Id'] = (int) $row['id'];
                    $GLOBALS['Cabid'] = $row['cid'];
                    $GLOBALS['Year'] = $row['year'];
                    $GLOBALS['Make'] = isc_html_escape($row['make']);
                    $GLOBALS['Model'] = isc_html_escape($row['model']);
                    $GLOBALS['SubModel'] = isc_html_escape($row['submodel']);
                    $GLOBALS['Cabsize'] = isc_html_escape($row['cabsize']);
                    $GLOBALS['Bedsize'] = isc_html_escape($row['bedsize']);
                    
                    $mid = $row['id'];
                    $cid = $row['cid'];
                    $mmyedit = GetLang('MMYEdit');
                    $edit = GetLang('Edit');

                    // Workout the edit link -- do they have permission to do so?
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['EditMMYLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editMMY&amp;Id=%d&amp;cid=%d'>%s</a>", GetLang('MMYEdit'), $row['id'],$row['cid'], GetLang('Edit'));
//                        $GLOBALS['EditMMYLink'] = "<a title=GetLang(\'MMYEdit\') class='Action' href='index.php?ToDo=editMMY&amp;Id=$mid&amp;cid=$cid&amp;eid=$eid'>$edit</a>";

                    } else {
                        $GLOBALS['EditMMYLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
                    }
                    
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Brands)) {
                         $GLOBALS['DeleteMMYLink'] = sprintf("<a title='%s' class='Action' href='#' onclick=deletemmyid(%d)>%s</a>", GetLang('MMYDelete'), $row['id'], GetLang('Delete'));
                    } else {
                        $GLOBALS['DeleteMMYLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Delete'));
                    }

                    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("mmy.manage.row");
                    $GLOBALS['MMYGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
                }
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("mmy.manage.grid");
                return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }
        }
        
        public function _GetMMYList($Start, $SortField, $SortOrder, &$NumResults)
        {

//            $query = "SELECT * FROM [|PREFIX|]product_mmy p";
            
             $query = "SELECT p.*,c.id as cid, c.cabsize,c.bedsize FROM [|PREFIX|]product_mmy p left join [|PREFIX|]cabbed_table c on p.id = c.ymm_id";// order by p.id desc limit 0,100"; 

//            $countQuery = "SELECT COUNT(*) FROM [|PREFIX|]product_mmy p";
            $countQuery = "SELECT count(*) FROM [|PREFIX|]product_mmy p left join [|PREFIX|]cabbed_table c on p.id = c.ymm_id";// order by p.id desc 0,100"; 

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
                $query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_MMY_PER_PAGE);
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                return $result;
                
            }
            else {
                return false;
            }
        }
        
        public function EditMMY($MsgDesc = "", $MsgStatus = "")
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes(); 
            if(isset($_GET['Id'])) {
                if ($MsgDesc != "") {
                    $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
                }

                $Id = (int)$_GET['Id'];
                $cid = $_GET['cid'];
                $where = "";
                $where .= "WHERE p.id = '$Id'";
                if ($cid != "" and $cid != "0") {
                    $where .= " AND c.id = '$cid'"; 
                }
                else {
                    $where .= "";
                }
                $query = "SELECT p . * , c.cabsize, c.bedsize,c.id AS cid FROM [|PREFIX|]product_mmy p LEFT JOIN [|PREFIX|]cabbed_table c ON p.id = c.ymm_id $where";
                
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

                if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                    $GLOBALS['Id'] = $row['id'];
                    $GLOBALS['Year'] = isc_html_escape($row['year']);
                    $GLOBALS['Make'] = isc_html_escape($row['make']);
                    $GLOBALS['Model'] = isc_html_escape($row['model']);
                    $GLOBALS['SubModel'] = isc_html_escape($row['submodel']);
                    
                    $GLOBALS['Cid'] = $_GET['cid'];
                    $GLOBALS['Cabsize'] = isc_html_escape($row['cabsize']);
                    $GLOBALS['Bedsize'] = isc_html_escape($row['bedsize']);
                    
                    $GLOBALS['MMYTitle'] = GetLang('EditMMY');
                    $GLOBALS['MMYIntro'] = GetLang('EditMMYIntro');
                    $GLOBALS['CancelMessage'] = GetLang('CancelEditMMY');
                    $GLOBALS['FormAction'] = "SaveEditedMMY";

                    $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("mmy.edit.form");
                    $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
                }
                else {
                    ob_end_clean();
                    header("Location: index.php?ToDo=viewMMY");
                    die();
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewMMY");
                die();
            }
        }
        
        public function SaveEditedMMY()
        {
            if(isset($_POST['year'])) {
                # Product MMY table
                $id = $_POST['Id'];
                $year = trim($_POST['year']);
                $make = trim($_POST['make']);
                $model = trim($_POST['model']);
                $submodel = trim($_POST['submodel']);

                # Cabbed table
                $cid = $_POST['cid'];
                $cabsize = $_POST['cabsize'];
                $bedsize = $_POST['bedsize'];
                $cabbed = array(
                    "cabsize" => $cabsize,
                    "bedsize" => $bedsize
                );
                $cabbed_new = array(
                    "ymm_id" => $id
                );
                $cabbed_merge = array_merge($cabbed_new,$cabbed);
                
                # To display the error
                $total = '';
                if($submodel != '') {
                    $total = $year.', '.$make.', '.$model.', '.$submodel;
                }
                else {
                    $total = $year.', '.$make.', '.$model;
                }
                
                if($cid != "0" and $cid != ""){
                    $GLOBALS['ISC_CLASS_DB']->UpdateQuery("cabbed_table", $cabbed, "id='".$GLOBALS['ISC_CLASS_DB']->Quote($cid)."'");                               
                }
                else {
                    $GLOBALS['ISC_CLASS_DB']->InsertQuery("cabbed_table", $cabbed_merge);           
                }
                
                $updatedMMY = array(
                    "id" => $id,
                    "year" => $year,
                    "make" => $make,
                    "model" => $model,
                    "submodel" => $submodel
                );
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_mmy", $updatedMMY, "id='".$GLOBALS['ISC_CLASS_DB']->Quote($id)."'");
                if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                    $this->manageMMY(GetLang('MMYUpdatedSuccessfully'), MSG_SUCCESS);
                }
                else {
                    $this->manageMMY(sprintf(GetLang('MMYAlreadyAdded'), $total), MSG_ERROR);
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewMMY");
                die();
            }
        }
        
        public function DownloadFile() {
            $filename = "YMMCab_Bed.csv";
            $fp = fopen($filename, "w");

            $res = mysql_query("SELECT p.year,p.make,p.model,p.submodel,c.cabsize,c.bedsize FROM isc_product_mmy p left join isc_cabbed_table c on p.id = c.ymm_id");

            // fetch a row and write the column names out to the file
            $row = mysql_fetch_assoc($res);
            $line = "";
            $comma = "";
            foreach($row as $name => $value) {
                $line .= $comma . '"' . str_replace('"', '""', ucfirst($name)) . '"';
                $comma = ",";
            }
            $line .= "\n";
            fputs($fp, $line);

            // remove the result pointer back to the start
            mysql_data_seek($res, 0);

            // and loop through the actual data
            while($row = mysql_fetch_assoc($res)) {
               
                $line = "";
                $comma = "";
                foreach($row as $value) {
                    $line .= $comma . '"' . str_replace('"', '""', $value) . '"';
                    $comma = ",";
                }
                $line .= "\n";
                fputs($fp, $line);
               
            }
            fclose($fp);
            chmod($filename, 0777);  
            ob_end_clean();
            header('Content-Type: application/csv');
            header('Content-disposition: attachment; filename='.$filename); 
            readfile($filename);
            exit;
            return true; 
        }
        
        /* Engine type functions are below */
       public function manageEngineMMY($MsgDesc = "", $MsgStatus = "")
        {
            // Fetch any results, place them in the data grid
            $GLOBALS['catuserid'] = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUserId(); 
            $user = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
            $userrole = $user['userrole'];
            
            $numMake = 0; 
            $GLOBALS['EngineMMYDataGrid'] = $this->ManageEngineMMYGrid($numMake);

            // Was this an ajax based sort? Return the table now
            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                echo $GLOBALS['EngineMMYDataGrid'];
                return;
            }

            if ($MsgDesc != "") {
                $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
            }


            $GLOBALS['EngineMMYIntro'] = GetLang('ManageEngineMMYIntro');
            
            if($userrole == 'admin') {
                $GLOBALS['DisplayYMM'] = '';
                $GLOBALS['DisplayDownload'] = 'none';
            }
            else {
                $GLOBALS['DisplayYMM'] = 'none';
                $GLOBALS['DisplayDownload'] = '';
            }

            // No results
            if($numMake == 0) {
                $GLOBALS['DisplayGrid'] = "none";
                    $GLOBALS['Message'] = MessageBox(GetLang('NoEngineMMY'), MSG_SUCCESS);
            }

            $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("mmy.engine.manage");
            $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
        
        public function AddEngineMMY()
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes();  
            $GLOBALS['EngineMMYTitle'] = GetLang('AddEngineMMY');
            $GLOBALS['EngineMMYIntro'] = GetLang('AddEngineMMYIntro');
            $GLOBALS['EngineCancelMessage'] = GetLang('CancelCreateEngineMMY');
            $GLOBALS['FormAction'] = "SaveEngineMmy";
            $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("mmy.engine.add.form");
            $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
        public function SaveEngineMMY() {
            if(isset($_POST['year'])) {

                // Save the brands to the database
                $year = trim($_POST['year']);
                $make = trim($_POST['make']);
                $model = trim($_POST['model']);
                $submodel = trim($_POST['submodel']);
                $enginetype = trim($_POST['enginetype']);
                $liter = trim($_POST['liter']);
                $total = '';
                if($submodel != '') {
                    $total = $year.', '.$make.', '.$model.', '.$submodel;
                }
                else {
                    $total = $year.', '.$make.', '.$model;
                }
                    $newMMY = array(
                        "year" => $year,
                        "make" => $make,
                        "model" => $model,
                        "submodel" => $submodel
                    );
                $sub_query = $GLOBALS["ISC_CLASS_DB"]->Query("insert into [|PREFIX|]product_mmy 
                                set year = '".$year."', 
                                    make = '".$make."', 
                                    model = '".$model."', 
                                    submodel = '".$submodel."'
                                ON DUPLICATE KEY UPDATE 
                                    submodel = '".$submodel."'");
                $insertid = mysql_insert_id();
                $engine = array(
                    "ymm_id" => $insertid,
                    "engtype" => $enginetype,
                    "liter" => $liter
                );
                $cnt = mysql_affected_rows();
                // Check for an error message from the database
                if($cnt == 1) {
                     $GLOBALS['ISC_CLASS_DB']->InsertQuery("engine_table", $engine); 
                    $this->manageEngineMMY(GetLang('EngineMMYAddedSuccessfully'), MSG_SUCCESS); 
                }
                else {
                    if($cnt == 0) {
                        FlashMessage(sprintf(GetLang('EngineMMYAlreadyAdded'),$total), MSG_ERROR, 'index.php?ToDo=addEngineMmy');
                    }
                    else {
                        $message = sprintf(GetLang('EngineMMYAddError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
                        $this->manageEngineMMY($message, MSG_ERROR);
                    }
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewEngineMMY");
                die();
            }            
        }
        
        public function DeleteEngineMMY()
        {
            $Id = $_GET['Id'];
            $GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_mmy', "WHERE id = '$Id'");
            $GLOBALS['ISC_CLASS_DB']->DeleteQuery('engine_table', "WHERE ymm_id = '$Id'");
            if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                $this->manageEngineMMY(GetLang('EngineMMYDeletedSuccessfully'), MSG_SUCCESS);
            }
            else {
                $message = sprintf(GetLang('EngineMMYDeleteError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
                $this->manageEngineMMY($message, MSG_ERROR);
            }                
        }
        
        
        public function ManageEngineMMYGrid(&$numMake)
        {
            // Show a list of news in a table
            $page = 0;
            $start = 0;
            $numMake = 0;
            $numPages = 0;
            $GLOBALS['EngineMMYGrid'] = "";
            $GLOBALS['Nav'] = "";
            $max = 0;
            $searchURL = '';

                                     
            if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
                $sortOrder = 'desc';
            } else {
                $sortOrder = "asc";
            }

            $sortLinks = array(
                "Make" => "p.make",
                "Model" => "p.model"
            );

            if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
                $sortField = $_GET['sortField'];
                SaveDefaultSortField("manageEngineMMY", $_REQUEST['sortField'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("manageEngineMMY", "p.make", $sortOrder);
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
                $start = ($page * ISC_MMY_PER_PAGE) - (ISC_MMY_PER_PAGE-1);
            }

            $start = $start-1;

            // Get the results for the query
            $mmyResult = $this->_GetEngineMMYList($start, $sortField, $sortOrder, $numMake);
            $numPages = ceil($numMake / ISC_MMY_PER_PAGE);
            // Workout the paging navigation
            if($numMake > ISC_MMY_PER_PAGE) {
                $GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

                $GLOBALS['Nav'] .= BuildPagination($numMake, ISC_MMY_PER_PAGE, $page, sprintf("index.php?ToDo=viewEngineMMY%s", $sortURL));
            }
            else {
                $GLOBALS['Nav'] = "";
            }

            $GLOBALS['SortField'] = $sortField;
            $GLOBALS['SortOrder'] = $sortOrder;

            BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewEngineMMY&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);


            // Workout the maximum size of the array
            $max = $start + ISC_MMY_PER_PAGE;

            if ($max > count($mmyResult)) {
                $max = count($mmyResult);
            }
            
            $user = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
            $userrole = $user['userrole'];
            if($userrole == 'admin') {
                $GLOBALS['DisplayAction'] = '';
            }
            else {
                $GLOBALS['DisplayAction'] = 'none';
            }
            
            if($numMake > 0) {
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($mmyResult)) {
                    $GLOBALS['Id'] = (int) $row['id'];
                    $GLOBALS['Engid'] = $row['eid'];
                    $GLOBALS['Year'] = $row['year'];
                    $GLOBALS['Make'] = isc_html_escape($row['make']);
                    $GLOBALS['Model'] = isc_html_escape($row['model']);
                    $GLOBALS['SubModel'] = isc_html_escape($row['submodel']);
                    $GLOBALS['EngineType'] = isc_html_escape($row['engtype']);
                    $GLOBALS['Liter'] = isc_html_escape($row['liter']);   
                    
                    $mid = $row['id'];
                    $eid = $row['eid'];
                    $mmyedit = GetLang('EngineMMYEdit');
                    $edit = GetLang('EngineEdit');

                    // Workout the edit link -- do they have permission to do so?
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['EditEngineMMYLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editEngineMMY&amp;Id=%d&amp;eid=%d'>%s</a>", GetLang('EngineMMYEdit'), $row['id'],$row['eid'], GetLang('EngineEdit'));

                    } else {
                        $GLOBALS['EditEngineMMYLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
                    }
                    
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Brands)) {
                         $GLOBALS['DeleteEngineMMYLink'] = sprintf("<a title='%s' class='Action' href='#' onclick=deleteenginemmyid(%d)>%s</a>", GetLang('MMYDelete'), $row['id'], GetLang('Delete'));
                    } else {
                        $GLOBALS['DeleteEngineMMYLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Delete'));
                    }

                    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("mmy.engine.manage.row");
                    $GLOBALS['EngineMMYGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
                }
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("mmy.engine.manage.grid");
                return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }
        }
        
        public function _GetEngineMMYList($Start, $SortField, $SortOrder, &$NumResults)
        {
            // Return an array containing details about brands.
            // Takes into account search too.

            // PostgreSQL is case sensitive for likes, so all matches are done in lower case
//            $Query = trim(isc_strtolower($Query));

//            $query = "SELECT * FROM [|PREFIX|]product_mmy p";
            
             $query = "SELECT p.*, e.id as eid, e.engtype, e.liter FROM [|PREFIX|]product_mmy p left join [|PREFIX|]engine_table e on p.id=e.ymm_id";// order by p.id desc limit 0,100"; 

//            $countQuery = "SELECT COUNT(*) FROM [|PREFIX|]product_mmy p";
            $countQuery = "SELECT count(*) FROM [|PREFIX|]product_mmy p left join [|PREFIX|]engine_table e on p.id=e.ymm_id";// order by p.id desc 0,100"; 


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
                $query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_MMY_PER_PAGE);
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                return $result;
                
            }
            else {
                return false;
            }
        }
        
        public function EditEngineMMY($MsgDesc = "", $MsgStatus = "")
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes(); 
            if(isset($_GET['Id'])) {
                if ($MsgDesc != "") {
                    $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
                }

                $Id = (int)$_GET['Id'];
                $eid = $_GET['eid'];
                $where = "";
                $where .= "WHERE p.id = '$Id'"; 
                if($eid != "" and $eid != 0) {
                    $where .= " AND e.id = '$eid'";
                }
                else {
                    $where .= "";
                }
                
                $query = "SELECT p . * , e.engtype, e.liter,e.id AS eid FROM [|PREFIX|]product_mmy p LEFT JOIN [|PREFIX|]engine_table e ON p.id = e.ymm_id $where";
                
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

                if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                    $GLOBALS['Id'] = $row['id'];
                    $GLOBALS['Year'] = isc_html_escape($row['year']);
                    $GLOBALS['Make'] = isc_html_escape($row['make']);
                    $GLOBALS['Model'] = isc_html_escape($row['model']);
                    $GLOBALS['SubModel'] = isc_html_escape($row['submodel']);
                    
                    $GLOBALS['Eid'] = $_GET['eid'];
                    $GLOBALS['EngineType'] = isc_html_escape($row['engtype']);
                    $GLOBALS['Liter'] = isc_html_escape($row['liter']); 

                    $GLOBALS['EngineMMYTitle'] = GetLang('EditEngineMMY');
                    $GLOBALS['EngineMMYIntro'] = GetLang('EditEngineMMYIntro');
                    $GLOBALS['EngineCancelMessage'] = GetLang('CancelEditEngineMMY');
                    $GLOBALS['FormAction'] = "SaveEditedEngineMMY";

                    $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("mmy.engine.edit.form");
                    $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
                }
                else {
                    ob_end_clean();
                    header("Location: index.php?ToDo=viewEngineMMY");
                    die();
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewEngineMMY");
                die();
            }
        }
        
        public function SaveEditedEngineMMY()
        {
            if(isset($_POST['year'])) {
                # Product MMY table
                $id = $_POST['Id'];
                $year = trim($_POST['year']);
                $make = trim($_POST['make']);
                $model = trim($_POST['model']);
                $submodel = trim($_POST['submodel']);

                # Engine table
                $eid = $_POST['eid'];
                $engtype = $_POST['enginetype'];
                $liter = $_POST['liter'];
                $engine = array(
                    "engtype" => $engtype,
                    "liter" => $liter
                );
                $engine_new = array(
                    "ymm_id" => $id
                );
                $engine_merge = array_merge($engine_new,$engine);
                
                # To display the error
                $total = '';
                if($submodel != '') {
                    $total = $year.', '.$make.', '.$model.', '.$submodel;
                }
                else {
                    $total = $year.', '.$make.', '.$model;
                }
                
                if($eid != "0" and $eid != ""){
                    $GLOBALS['ISC_CLASS_DB']->UpdateQuery("engine_table", $engine, "id='".$GLOBALS['ISC_CLASS_DB']->Quote($eid)."'");                               
                }
                else {
                    $GLOBALS['ISC_CLASS_DB']->InsertQuery("engine_table", $engine_merge);           
                } 
                $updatedMMY = array(
                    "id" => $id,
                    "year" => $year,
                    "make" => $make,
                    "model" => $model,
                    "submodel" => $submodel
                );
                $GLOBALS['ISC_CLASS_DB']->UpdateQuery("product_mmy", $updatedMMY, "id='".$GLOBALS['ISC_CLASS_DB']->Quote($id)."'");
                if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                    $this->manageEngineMMY(GetLang('EngineMMYUpdatedSuccessfully'), MSG_SUCCESS);
                }
                else {
                    $this->manageEngineMMY(sprintf(GetLang('EngineMMYAlreadyAdded'), $total), MSG_ERROR);
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewEngineMMY");
                die();
            }
        } 
        
        public function DownloadEngineFile() {
            $filename = "YMMEngine.csv";
            $fp = fopen($filename, "w");

            $res = mysql_query("SELECT p.year,p.make,p.model,p.submodel, e.engtype as EngineType, e.liter FROM isc_product_mmy p left join isc_engine_table e on p.id=e.ymm_id");   

            // fetch a row and write the column names out to the file
            $row = mysql_fetch_assoc($res);
            $line = "";
            $comma = "";
            foreach($row as $name => $value) {
                $line .= $comma . '"' . str_replace('"', '""', ucfirst($name)) . '"';
                $comma = ",";
            }
            $line .= "\n";
            fputs($fp, $line);

            // remove the result pointer back to the start
            mysql_data_seek($res, 0);

            // and loop through the actual data
            while($row = mysql_fetch_assoc($res)) {
               
                $line = "";
                $comma = "";
                foreach($row as $value) {
                    $line .= $comma . '"' . str_replace('"', '""', $value) . '"';
                    $comma = ",";
                }
                $line .= "\n";
                fputs($fp, $line);
               
            }
            fclose($fp);
            chmod($filename, 0777);  
            ob_end_clean();
            header('Content-Type: application/csv');
            header('Content-disposition: attachment; filename='.$filename); 
            readfile($filename);
            exit;
            return true; 
        }
        /* Ends here*/
    }
?>
