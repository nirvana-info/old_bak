<?php
  class ISC_ADMIN_SERIES
    {
        public function HandleToDo($Do)
        {
            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('series');
            switch (isc_strtolower($Do)) {
                case "viewseries":
                {  
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Series') => "index.php?ToDo=viewSeries");
                        if(!isset($_GET['ajax']))    {     
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }
                        $this->manageSeries();
                        if(!isset($_GET['ajax']))    {     
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "editseries":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        if(isset($_POST['keepedit']) == 'keepedit') {
                            $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Series') => "index.php?ToDo=viewSeries", GetLang('EditSeries') => "index.php?ToDo=editBrand");
                        }
                        else {
                            $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Series') => "index.php?ToDo=viewSeries", GetLang('EditSeries') => "index.php?ToDo=editBrand");
                        }
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->EditSeries();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "saveseries":
                {
                        if(isset($_POST['addanother']) == 'addanother') {
                            $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Series') => "index.php?ToDo=viewSeries", GetLang('AddSeries') => "index.php?ToDo=addSeries");
                        }
                        else {
                            $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Series') => "index.php?ToDo=viewSeries", GetLang('AddSeries') => "index.php?ToDo=addSeries");
                        }
                    
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->SaveNewSeries();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "saveeditedseries":
                {
                        if(isset($_POST['keepedit']) == 'keepedit') {
                            $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Series') => "index.php?ToDo=viewSeries", GetLang('EditSeries') => "index.php?ToDo=editBrand");
                        }
                        else {
                            $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Series') => "index.php?ToDo=viewSeries", GetLang('EditSeries') => "index.php?ToDo=editBrand");
                        }
                    
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->SaveEditedSeries();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    break;
                }
                case "addseries":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Series') => "index.php?ToDo=viewSeries", GetLang('AddSeries') => "index.php?ToDo=addSeries");

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->AddSeries();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "deleteseries":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Brands') => "index.php?ToDo=viewBrands");

                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->DeleteSeries();
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                default:
                {   
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Series') => "index.php?ToDo=viewSeries");

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }

                        $this->manageSeries();

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                }
            }
        }
        
       public function manageSeries($MsgDesc = "", $MsgStatus = "")
        {
        # Baskaran
            $_SESSION['congoseries'] = '';
            $_SESSION['congobrand'] = '';

            // Fetch any results, place them in the data grid
            $numSeries = 0;
            $GLOBALS['SeriesDataGrid'] = $this->ManageSeriesGrid($numSeries);

            // Was this an ajax based sort? Return the table now
            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                echo $GLOBALS['SeriesDataGrid'];
                return;
            }

            if ($MsgDesc != "") {
                $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
            }


            $GLOBALS['BrandIntro'] = GetLang('ManageBrandsIntro');

            // Do we need to disable the delete button?
            if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Brands) || $numSeries == 0) {
                $GLOBALS['DisableDelete'] = "DISABLED";
            }

            // No results
            if($numSeries == 0) {
                $GLOBALS['DisplayGrid'] = "none";
                    $GLOBALS['Message'] = MessageBox(GetLang('NoSeries'), MSG_SUCCESS);
            }

            $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("series.manage");
            $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        public function AddSeries()
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes();  
            $GLOBALS['SeriesTitle'] = GetLang('AddSeries');
            $GLOBALS['SeriesIntro'] = GetLang('AddSeriesIntro');
            $GLOBALS['CancelMessage'] = GetLang('CancelCreateSeries');
            $GLOBALS['FormAction'] = "SaveSeries";
            $brandid = 0;
            $GLOBALS['BrandName'] = $this->BrandName($brandid);
            $wysiwygOptions = array(
                    'id'        => 'wysiwyg',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => ''
                );                                                                                 
            $GLOBALS['WYSIWYG'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
            $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("series.form");
            $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }
        
         public function SaveNewSeries() {

        # Used to clear the HTML Editor image upload folder name Baskaran
            $_SESSION['congobrand'] = '';
            $_SESSION['congoseries'] = '';
            
            if(isset($_POST['seriesname'])) {
                $seriesname = $_POST['seriesname'];

                $proddesc = ''; 
                if(isset($_POST["wysiwyg_html"])) {
                    $proddesc = $this->FormatWYSIWYGHTML(trim($_POST["wysiwyg_html"]));
                }
                else {
                    $proddesc = $this->FormatWYSIWYGHTML(trim($_POST['wysiwyg']));
                }
                
                // Save the brands to the database
                    $seriesname = trim($seriesname);
                    $brandid = $_POST['vendor'];
                    $seriesphoto = $this->_StoreFileAndReturnId('seriesimagefile');
                    $seriescontent = trim($_POST['contents']);
                    $featurepoints1 = trim($_POST['featurepoints1']);
                    $featurepoints2 = trim($_POST['featurepoints2']);
                    $featurepoints3 = trim($_POST['featurepoints3']);
                    $featurepoints4 = trim($_POST['featurepoints4']);
                    $seriesaltkeyword = trim($_POST['seriesaltkeyword']);
                        $newSeries = array(
                            "seriesname" => $seriesname,
                            "brandid" => $brandid,
                            "seriesphoto" => $seriesphoto,
                            "seriescontent" => $seriescontent,
                            "feature_points1" => $featurepoints1,
                            "feature_points2" => $featurepoints2,
                            "feature_points3" => $featurepoints3,
                            "feature_points4" => $featurepoints4,
                            "proddesc" => $proddesc,
                            "seriesaltkeyword" => $seriesaltkeyword
                        );
                    $query = "select * from [|PREFIX|]brand_series where seriesname = '".$seriesname."'";
                    $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                    $cnt = $GLOBALS["ISC_CLASS_DB"]->CountResult($result); 
                    if($cnt != 1) {
                        $GLOBALS['ISC_CLASS_DB']->InsertQuery("brand_series", $newSeries);
                    }
                    else {
                        FlashMessage(sprintf(GetLang('SeriesAlreadyAdded'),$seriesname), MSG_ERROR, 'index.php?ToDo=addSeries');
                    }
                    
                    if($_POST['addanother'] == 'addanother') {
                        FlashMessage(GetLang('SeriesAddedSuccessfully'), MSG_SUCCESS);
                        header("Location: index.php?ToDo=addSeries");
                        exit;
                    }
                // Check for an error message from the database
                if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                    // No error                    
                    $this->manageSeries(GetLang('SeriesAddedSuccessfully'), MSG_SUCCESS);
                }
                else {
                    // Something went wrong
                    $message = sprintf(GetLang('SeriesAddError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
                    $this->manageSeries($message, MSG_ERROR);
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewSeries");
                die();
            }            
        }
        
        public function DeleteSeries()
        {
            if (isset($_POST['series'])) {

                $seriesids = implode("','", $GLOBALS['ISC_CLASS_DB']->Quote($_POST['series']));

                // Log this action
                $GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['series']));

                $query = sprintf("delete from [|PREFIX|]brand_series where seriesid in ('%s')", $seriesids);
                $GLOBALS["ISC_CLASS_DB"]->Query($query);

                $err = $GLOBALS["ISC_CLASS_DB"]->Error();
                if ($err != "") {
                    $this->manageSeries($err, MSG_ERROR);
                } else {
                    $this->manageSeries(GetLang('SeriesDeletedSuccessfully'), MSG_SUCCESS);
                }
            } else {
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Series)) {
                    $this->manageSeries();
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                }
            }
        }
        
        public function ManageSeriesGrid(&$numSeries)
        {
            // Show a list of news in a table
            $page = 0;
            $start = 0;
            $numSeries = 0;
            $numPages = 0;
            $GLOBALS['SeriesGrid'] = "";
            $GLOBALS['Nav'] = "";
            $max = 0;
            $searchURL = '';

           /* if (isset($_GET['searchQuery'])) {
                $query = $_GET['searchQuery'];
                $GLOBALS['Query'] = $query;
                $searchURL .'searchQuery='.urlencode($query);
            } else {
                $query = "";
                $GLOBALS['Query'] = "";
            } */
                                        
            if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
                $sortOrder = 'desc';
            } else {
                $sortOrder = "asc";
            }

            $sortLinks = array(
                "Series" => "b.seriesname"
            );

            if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
                $sortField = $_GET['sortField'];
                SaveDefaultSortField("ManageSeries", $_REQUEST['sortField'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("ManageSeries", "b.seriesname", $sortOrder);
            }
            if (isset($_GET['page'])) {
                $page = (int)$_GET['page'];
            }
            else {
                $page = 1;
            }

            $sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
            $GLOBALS['SortURL'] = $sortURL;

            // Limit the number of series returned
            if ($page == 1) {
                $start = 1;
            }
            else {
                $start = ($page * ISC_SERIES_PER_PAGE) - (ISC_SERIES_PER_PAGE-1);
            }

            $start = $start-1;

            // Get the results for the query
            $seriesResult = $this->_GetSeriesList($start, $sortField, $sortOrder, $numSeries);
            $numPages = ceil($numSeries / ISC_SERIES_PER_PAGE);

            // Workout the paging navigation
            if($numSeries > ISC_SERIES_PER_PAGE) {
                $GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

                $GLOBALS['Nav'] .= BuildPagination($numSeries, ISC_SERIES_PER_PAGE, $page, sprintf("index.php?ToDo=viewSeries%s", $sortURL));
            }
            else {
                $GLOBALS['Nav'] = "";
            }



//            $GLOBALS['SearchQuery'] = $query;
            $GLOBALS['SortField'] = $sortField;
            $GLOBALS['SortOrder'] = $sortOrder;

            BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewSeries&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);


            // Workout the maximum size of the array
            $max = $start + ISC_SERIES_PER_PAGE;

            if ($max > count($seriesResult)) {
                $max = count($seriesResult);
            }

            if($numSeries > 0) {
                // Display the news
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($seriesResult)) {
                    $GLOBALS['SeriesId'] = (int) $row['seriesid'];
                    $GLOBALS['SeriesName'] = wordwrap(isc_html_escape($row['seriesname']),90,'<br>',true);
                    $GLOBALS['Brandname'] = $this->BrandNameId($row['brandid']);
                    $GLOBALS['FileName'] = isc_html_escape($row['seriesphoto']);

                    // Workout the edit link -- do they have permission to do so?
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['EditSeriesLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editSeries&amp;seriesId=%d'>%s</a>", GetLang('SeriesEdit'), $row['seriesid'], GetLang('Edit'));
                    } else {
                        $GLOBALS['EditNewsLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
                    }

                    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("series.manage.row");
                    $GLOBALS['SeriesGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
                }
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("series.manage.grid");
                return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }
        }
        
        public function _GetSeriesList($Start, $SortField, $SortOrder, &$NumResults)
        {
            // Return an array containing details about brands.
            // Takes into account search too.

            // PostgreSQL is case sensitive for likes, so all matches are done in lower case
//            $Query = trim(isc_strtolower($Query));

            $query = "SELECT * FROM [|PREFIX|]brand_series b";

            $countQuery = "SELECT COUNT(*) FROM [|PREFIX|]brand_series b";

            $queryWhere = ' WHERE 1=1 and seriesid != 0';
//            if ($Query != "") {
//                $queryWhere .= " AND LOWER(b.brandname) LIKE '%".$GLOBALS['ISC_CLASS_DB']->Quote($Query)."%'";
//            }

            $query .= $queryWhere;
            $countQuery .= $queryWhere;

            $result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
            $NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

            if($NumResults > 0) {
                $query .= " ORDER BY ".$SortField." ".$SortOrder;

                // Add the limit
                $query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_SERIES_PER_PAGE);
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                return $result;
            }
            else {
                return false;
            }
        }
        
        public function EditSeries($MsgDesc = "", $MsgStatus = "")
        {
            $GLOBALS['Message'] = GetFlashMessageBoxes(); 
            if(isset($_GET['seriesId'])) {
                if ($MsgDesc != "") {
                    $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
                }

                $seriesId = (int)$_GET['seriesId'];
                $query = sprintf("select * from [|PREFIX|]brand_series where seriesid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($seriesId));
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

                if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                    $GLOBALS['SeriesId'] = $row['seriesid'];
                    $_SESSION['congoseries'] = '';
                    $_SESSION['congobrand'] = '';
                    $_SESSION['congoseries'] = $row['brandid'];
                    $GLOBALS['BrandName'] = $this->BrandName($row['brandid']);
                    $GLOBALS['SeriesName'] = isc_html_escape($row['seriesname']);
                    $GLOBALS['Contents'] = isc_html_escape($row['seriescontent']);
                    $GLOBALS['FeaturePoints1'] = isc_html_escape($row['feature_points1']);
                    $GLOBALS['FeaturePoints2'] = isc_html_escape($row['feature_points2']);
                    $GLOBALS['FeaturePoints3'] = isc_html_escape($row['feature_points3']);
                    $GLOBALS['FeaturePoints4'] = isc_html_escape($row['feature_points4']);
                    $GLOBALS['Seriesaltkeyword'] = isc_html_escape($row['seriesaltkeyword']);
                    $GLOBALS['SeriesTitle'] = GetLang('EditSeries');
                    $GLOBALS['SeriesIntro'] = GetLang('EditSeriesIntro');
                    $GLOBALS['CancelMessage'] = GetLang('CancelEditSeries');
                    $GLOBALS['FormAction'] = "SaveEditedSeries";
                    $GLOBALS['SeriesImageMessage'] = '';
                    if ($row['seriesphoto'] != '') {
                        $image = '../' . 'series_images' . '/' . $row['seriesphoto'];
                        $GLOBALS['SeriesImageMessage'] = sprintf(GetLang('SeriesImageDesc'), $image, $row['seriesphoto']);
                    }

                     $wysiwygOptions = array(
                    'id'        => 'wysiwyg',
                    'width'        => '60%',
                    'height'    => '350px',
                    'value'        => $row['proddesc']
                );

                $GLOBALS['WYSIWYG'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("series.edit.form");
                $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
                }
                else {
                    ob_end_clean();
                    header("Location: index.php?ToDo=viewSeries");
                    die();
                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewSeries");
                die();
            }
        }
        
        private function BrandName($selectedBrand) {
            $options = '<option value="0">'.GetLang('SelectBrand').'</option>';
            $query = "SELECT * from [|PREFIX|]brands ORDER BY brandname";
            $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
            while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                $sel = '';
                if($selectedBrand == $row['brandid']) {
                    $sel = 'selected="selected"';
                }
                $options .= '<option value='.(int)$row['brandid'].' '.$sel.'>'.$row['brandname'].'</option>';
            }
            return $options;
        }
        
        private function BrandNameId($id) {
            $query = "SELECT * from [|PREFIX|]brands where brandid = '$id'";
//            echo $query;exit;
            $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
            $row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);
            $brandname = $row['brandname'];
            return $brandname;
        }
        public function _StoreFileAndReturnId($FileName)
        {
            // This function takes a file name as its arguement and stores
            // this file in the /downloads or /images directory depending
            // on the $FileType enumeration value

            $dir = "series_images";
            
            if (is_array($_FILES[$FileName]) && $_FILES[$FileName]['name'] != "") {
                // If it's an image, make sure it's a valid image type
                if (isc_strtolower(isc_substr($_FILES[$FileName]['type'], 0, 5)) != "image") {
                    return "";
                }

                if (is_dir(sprintf("../%s", $dir))) {               
                                           
                    // Clean up the incoming file name a bit
                    $_FILES[$FileName]['name'] = preg_replace("#[^\w.]#i", "_", $_FILES[$FileName]['name']);
                    $_FILES[$FileName]['name'] = preg_replace("#_{1,}#i", "_", $_FILES[$FileName]['name']);

                    $randomFileName = GenRandFileName($_FILES[$FileName]['name']);
                    $fileName = $randomFileName;
                    $dest = realpath(ISC_BASE_PATH."/" . $dir);
                    while(file_exists($dest."/".$fileName)) {
                        $fileName = basename($randomFileName);
                        $fileName = substr_replace($randomFileName, "-".rand(0, 10000000000), strrpos($randomFileName, "."), 0);
                        $fileName = $randomDir . "/" . $fileName;
                    }
                    $dest .= "/".$fileName;

                    if(move_uploaded_file($_FILES[$FileName]["tmp_name"], $dest)) {
                        isc_chmod($dest, ISC_WRITEABLE_FILE_PERM);
                        // The file was moved successfully
                        return $fileName;
                    }
                    else {
                        // Couldn't move the file, maybe the directory isn't writable?
                        return "";
                    }
                } else {
                    // The directory doesn't exist
                    return "";
                }
            } else {
                // The file doesn't exist in the $_FILES array
                return "";
            }
        }
        
        public function SaveEditedSeries()
        {
        # Used to clear the HTML Editor image upload folder name Baskaran
            $_SESSION['congobrand'] = '';
            $_SESSION['congoseries'] = '';

            if(isset($_POST['seriesName'])) {
                
                 $proddesc = ''; 
                if(isset($_POST["wysiwyg_html"])) {
                    $proddesc = $this->FormatWYSIWYGHTML(trim($_POST["wysiwyg_html"]));
                }
                else {
                    $proddesc = $this->FormatWYSIWYGHTML(trim($_POST['wysiwyg']));
                }
                                
                $brandid = $_POST['vendor'];
                $seriesname = trim($_POST['seriesName']);
                $seriesId = (int)$_POST['seriesId'];
                $content = trim($_POST['contents']);
                $featurepoints1 = trim($_POST['featurepoints1']);
                $featurepoints2 = trim($_POST['featurepoints2']);
                $featurepoints3 = trim($_POST['featurepoints3']);
                $featurepoints4 = trim($_POST['featurepoints4']);
                $seriesaltkeyword = trim($_POST['seriesaltkeyword']);
               
               /* if($_POST['hidvalue'] == 1) {
                    $GLOBALS['ISC_CLASS_DB']->UpdateQuery("brand_series", $updateDesc, "seriesid='".$GLOBALS['ISC_CLASS_DB']->Quote($seriesId)."'"); 
                    $GLOBALS['ISC_CLASS_DB']->UpdateQuery("products", $updateDesc, "brandseriesid='".$GLOBALS['ISC_CLASS_DB']->Quote($seriesId)."'");
                    if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") { 
                        $_GET['seriesId'] = $seriesId;
                        $this->EditSeries(GetLang('ProductDescUpdatedSuccessfully'), MSG_SUCCESS); 
                    }
                    else {
                        $this->manageSeries(GetLang('ProductDescUpdatedError'), MSG_ERROR); 
                    }
                }
                else {     */
                    $updatedSeries = array(
                        "brandid" => $brandid,
                        "seriesname" => $seriesname,
                        "seriescontent" => $content,
                        "feature_points1" => $featurepoints1,
                        "feature_points2" => $featurepoints2,
                        "feature_points3" => $featurepoints3,
                        "feature_points4" => $featurepoints4,                                                                        
                        "proddesc" => $proddesc,
                        "seriesaltkeyword" => $seriesaltkeyword
                    );
                    $query = "select * from [|PREFIX|]brand_series where seriesname = '".$seriesname."' and seriesid != '$seriesId'";
                    $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                    $cnt = $GLOBALS["ISC_CLASS_DB"]->CountResult($result);  
                    if($cnt != 0) {
                        $this->manageSeries(sprintf(GetLang('SeriesAlreadyAdded'), $seriesname), MSG_ERROR);
                    }
                    else {    
                        $GLOBALS['ISC_CLASS_DB']->UpdateQuery("brand_series", $updatedSeries, "seriesid='".$GLOBALS['ISC_CLASS_DB']->Quote($seriesId)."'");
                        if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {

                            if (array_key_exists('delseriesimagefile', $_POST) && $_POST['delseriesimagefile']) {
                                $this->DelSeriesImage($seriesId);
                                $GLOBALS['ISC_CLASS_DB']->UpdateQuery('brand_series', array('seriesphoto' => ''), "seriesid='" . (int)$seriesId . "'");
                            } else if (array_key_exists('seriesimagefile', $_FILES) && ($seriesimagefile = $this->_StoreFileAndReturnId('seriesimagefile'))) {
                                $GLOBALS['ISC_CLASS_DB']->UpdateQuery('brand_series', array('seriesphoto' => $seriesimagefile), "seriesid='" . (int)$seriesId . "'");
                            }
                            if($_POST['keepedit'] == 'keepedit') {
                                $_GET['seriesId'] = $seriesId;
                                $this->EditSeries(GetLang('SeriesUpdatedSuccessfully'), MSG_SUCCESS);
                                exit;
                            }

                            $this->manageSeries(GetLang('SeriesUpdatedSuccessfully'), MSG_SUCCESS);
                        }
                        else {
                            $this->EditSeries(sprintf(GetLang('UpdateSeriesError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR);
                        }
                    }
//                }
            }
            else {
                ob_end_clean();
                header("Location: index.php?ToDo=viewSeries");
                die();
            }
        }
        
        private function DelSeriesImage($file)
        {
            if (isId($file)) {
                if (!($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]brand_series WHERE seriesid='" . (int)$file . "'")))) {
                    return false;
                }

                if ($row['seriesphoto'] == '') {
                    return true;
                } else {
                    $file = $row['seriesphoto'];
                }
            }

            $file = realpath(ISC_BASE_PATH.'/' . 'series_images' . '/' . $file);

            if ($file == '') {
                return false;
            }

            if (file_exists($file)) {
                @unlink($file);
                clearstatcache();
            }

            return !file_exists($file);
        }
        
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
    }
?>
