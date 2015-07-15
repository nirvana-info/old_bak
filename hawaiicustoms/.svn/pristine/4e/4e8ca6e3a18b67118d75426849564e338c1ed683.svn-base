<?php
    
	class ISC_ADMIN_QUALIFIER_ASSOCIATIONS
	{
        
        public $firstdept = 0;
        
		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('qualifierassociations');
			switch (isc_strtolower($Do)) {
				case "saveeditedqualifierassociations":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Qualifier_Associations)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QualifierAssociations') => "index.php?ToDo=viewQualifierAssociations");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SaveEditedQualifierAssociation();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "editqualifierassociations":
				{   
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Qualifier_Associations)) {      
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QualifierAssociations') => "index.php?ToDo=viewQualifierAssociations", GetLang('EditQualifierAssociation') => "index.php?ToDo=editQualifierAssociations");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();  
						$this->EditQualifierAssociation(); 
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "savenewqualifierassociations":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Qualifier_Associations)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SaveNewQualifierAssociations();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "addqualifierassociation":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Qualifier_Associations)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QualifierAssociations') => "index.php?ToDo=viewQualifierAssociations", GetLang('AddQualifierAssociations') => "index.php?ToDo=addQualifierAssociations");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddQualifierAssociations();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "deletequalifierassociations":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Qualifier_Associations)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QualifierAssociations') => "index.php?ToDo=viewQualifierAssociations");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteQualifierAssociations();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
                case "listqualifiersqualifierassociations":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_QValue_Associations)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QValueAssociations') => "index.php?ToDo=viewQValueAssociations", GetLang('AddQValueAssociations') => "index.php?ToDo=addQValueAssociations");
                        //$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->listQualifiers();
                        //$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                /* To toggle tick/cross marks -- Baskaran */
                 case "editvisiblequalifierassociations":
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Qualifier_Associations)) {

                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QualifierAssociations') => "index.php?ToDo=viewQualifierAssociations");

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }
                        $this->editVisibleQualifierAssociations();

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }

                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                    break;
                /* Code Ends*/
				default:
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Qualifier_Associations)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QualifierAssociations') => "index.php?ToDo=viewQualifierAssociations");

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						//$this->ManageQualifierAssociations();
                        $this->ShowCategoryRows();
                        
						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						}
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
			}
		}

		public function _GetQualifierAssociationList(&$Query, $Start, $SortField, $SortOrder, &$NumResults)
		{
			// Return an array containing details about qualifierassociations.
			// Takes into account search too.

			// PostgreSQL is case sensitive for likes, so all matches are done in lower case
			$Query = trim(isc_strtolower($Query));

			$query = "
				SELECT qa.associd, qa.categoryid, qa.qualifierid, qa.displayname, qa.qualifier_visible, mn.column_name 
                FROM [|PREFIX|]qualifier_associations qa 
                LEFT JOIN [|PREFIX|]categories c ON qa.categoryid = c.categoryid
                LEFT JOIN [|PREFIX|]qualifier_names mn ON qa.qualifierid = mn.qid 
			";                                                                         //qa.comments, c.catname, 

			$countQuery = "
                            SELECT COUNT(associd) FROM [|PREFIX|]qualifier_associations qa
                            LEFT JOIN [|PREFIX|]categories c ON qa.categoryid = c.categoryid
                            LEFT JOIN [|PREFIX|]qualifier_names mn ON qa.qualifierid = mn.qid 
                ";

			$queryWhere = ' WHERE 1=1 ';
			/*if ($Query != "") {
				$queryWhere .= " AND LOWER(b.qualifierassociationname) LIKE '%".$GLOBALS['ISC_CLASS_DB']->Quote($Query)."%'";
			} */
            
            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) { 
                if(isset($_GET['catid']))    {
                    $catid = $_GET['catid'];
                }
                $queryWhere .=  " AND qa.categoryid='".$catid."'";
                $queryWhere .=  " AND (c.catuniversal != '1' OR mn.column_name REGEXP '^pq') ";
            }    
            
			$query .= $queryWhere;
			$countQuery .= $queryWhere;
            /*
			$result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
			$NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
            if($NumResults > 0) {
            */
				$query .= " ORDER BY c.catname, ".$SortField." ".$SortOrder;

				// Add the limit
				//$query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_BRANDS_PER_PAGE);    
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                $NumResults = $GLOBALS["ISC_CLASS_DB"]->CountResult($result);  
				return $result;
			/*}
			else {
				return false;
			}*/
            
            //return $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);  
            
		}

		public function ManageQualifierAssociationsGrid(&$numQualifierAssociations)
		{
			// Show a list of news in a table
			$page = 0;
			$start = 0;     
			$numQualifierAssociations = 0;
			$numPages = 0;     
			$GLOBALS['QualifierAssociationGrid'] = "";
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
				"QualifierDisplayName" => "mn.column_name",
                "AssociationDisplayName" => "qa.displayname",
				"Comments" => "qa.comments",
			);

			if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
				$sortField = $_GET['sortField'];
				SaveDefaultSortField("ManageQualifierAssociations", $_REQUEST['sortField'], $sortOrder);
			}
			else {
				list($sortField, $sortOrder) = GetDefaultSortField("QualifierAssociationGrid", "qa.associd", $sortOrder);
			}

			if (isset($_GET['page'])) {
				$page = (int)$_GET['page'];
			}
			else {
				$page = 1;
			}

			$sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
			$GLOBALS['SortURL'] = $sortURL;

			// Limit the number of qualifierassociations returned
			if ($page == 1) {
				$start = 1;
			}
			else {
				$start = ($page * ISC_BRANDS_PER_PAGE) - (ISC_BRANDS_PER_PAGE-1);
			}

			$start = $start-1;
            
			// Get the results for the query
			$qualifierAssociationResult = $this->_GetQualifierAssociationList($query, $start, $sortField, $sortOrder, $numQualifierAssociations); 
            
			$numPages = ceil($numQualifierAssociations / ISC_BRANDS_PER_PAGE);
            
			// Workout the paging navigation
			if($numQualifierAssociations > ISC_BRANDS_PER_PAGE) {
				$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

				$GLOBALS['Nav'] .= BuildPagination($numQualifierAssociations, ISC_BRANDS_PER_PAGE, $page, sprintf("index.php?ToDo=viewQualifierAssociations%s", $sortURL));
			}
			else {
				$GLOBALS['Nav'] = "";
			}

			$GLOBALS['SearchQuery'] = $query;
			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;

			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewQualifierAssociations&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);


			// Workout the maximum size of the array
			$max = $start + ISC_BRANDS_PER_PAGE;

			if ($max > count($qualifierAssociationResult)) {
				$max = count($qualifierAssociationResult);
			}
            
			if($numQualifierAssociations > 0) {
                $tempcategoryid = 0;
				// Display the news
				while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($qualifierAssociationResult)) {       
					$GLOBALS['QualifierAssociationId']      = (int) $row['associd'];
					$GLOBALS['QualifierDisplayName']        = isc_html_escape($row['column_name']);
					$GLOBALS['AssociationDisplayName']      = $row['displayname'];
                    $qualifiervisible = $row['qualifier_visible'];
					// Workout the edit link -- do they have permission to do so?
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Qualifier_Associations)) {
						$GLOBALS['EditQualifierAssociationLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editQualifierAssociations&amp;QualifierAssociationId=%d'>%s</a>", GetLang('QualifierAssociationEdit'), $row['associd'], GetLang('Edit'));
                        if($qualifiervisible == 1) {
//                            $GLOBALS['VisibleQualifierAssociationLink'] = "| <img border='0' src='images/tick.gif' alt='Visible' title='Visible'>";
                            $GLOBALS['VisibleQualifierAssociationLink'] = "| <a id='Visible_".$row['associd']."' title='".GetLang('ClickToNotQualifier')."' href='index.php?ToDo=editvisiblequalifierassociations&amp;quaId=".$row['associd']."&amp;visible=0' onclick=\"quickToggle(this); return false;\"><img border='0' src='images/tick.gif' alt='Visible'></a>";
                        }    
                        else {
                            $GLOBALS['VisibleQualifierAssociationLink'] = "| <a id='Visible_".$row['associd']."' title='".GetLang('ClickToQualifier')."' href='index.php?ToDo=editvisiblequalifierassociations&amp;quaId=".$row['associd']."&amp;visible=1' onclick=\"quickToggle(this); return false;\"><img border='0' src='images/cross.gif' alt='Not Visible'></a>";
                        }
                    } else {
                        $GLOBALS['EditNewsLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
                        if($qualifiervisible == 1){
                            $GLOBALS['VisibleQualifierAssociationLink'] = '<img border="0" src="images/tick.gif" alt="Visible">';
                        }
                        else {
                            $GLOBALS['VisibleQualifierAssociationLink'] = '<img border="0" src="images/cross.gif" alt="Not Visible">';
                        }
                    }

                    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("qualifier.associations.manage.row");
					$GLOBALS['QualifierAssociationGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true); 
				} 
                
			}
            $GLOBALS['QualifierAssociationGrid'] .= "<tr><td>&nbsp;</td><td colspan='4'><a href='#' onclick='AssignNewQualifiers(".$_GET['catid'].")'>New Qualifier<a></td></tr>";      
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("qualifier.associations.manage.grid");
            return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

        /* To send qualifier id for visible -- Baskaran */
        private function editVisibleQualifierAssociations()
        {    
            $quaId = (int)$_GET['quaId'];
            $visible = (int)$_GET['visible'];
                       
            $queryPart = "associd='".$GLOBALS['ISC_CLASS_DB']->Quote($quaId)."'";
            $successMsg = sprintf(GetLang('QualifierSuccessfully'), '');       

            $updatedQualifier = array(
                "qualifier_visible" => $visible
            ); 
            $GLOBALS['ISC_CLASS_DB']->UpdateQuery("qualifier_associations", $updatedQualifier, $queryPart);

            unset($_REQUEST['visible']);
            unset($_GET['visible']);

            if ($GLOBALS["ISC_CLASS_DB"]->Error() == "") {

                if(isset($_REQUEST['ajax'])) {

                    //generate the javascript to update the visibility icon through ajax
                    $callBackJs = "";
                        $elementID = 'Visible_'.$quaId;
                        $callBackJs .= 'ToggleVisibleIcon("'.$elementID.'", "visible", '.$visible.');';

                    header('Content-type: text/javascript');
                    echo $callBackJs;
                    echo "var status = 1; var message='".$successMsg."'";
                    exit;
                }
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Qualifier_Associations)) {
                    $this->ManageQualifierAssociationsGrid(GetLang('QualifierSuccessfully'), MSG_SUCCESS);
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
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Qualifier_Associations)) {
                    $this->ManageQualifierAssociationsGrid(sprintf(GetLang('ErrQualifierNotChanged'), $err), MSG_ERROR);
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrQualifierNotChanged'), $err), MSG_ERROR);
                }
            }
        }
        /* Code ends */
		public function ManageQualifierAssociations($MsgDesc = "", $MsgStatus = "")
		{
			// Fetch any results, place them in the data grid
			$numQualifierAssociations = 0;
			$GLOBALS['QualifierAssociationsDataGrid'] = $this->ManageQualifierAssociationsGrid($numQualifierAssociations);

			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['QualifierAssociationsDataGrid'];
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

			$GLOBALS['QualifierAssociationIntro'] = GetLang('ManageQualifierAssociationsIntro');

			// Do we need to disable the delete button?
			if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Qualifier_Associations) || $numQualifierAssociations == 0) {
				$GLOBALS['DisableDelete'] = "DISABLED";
			}

			// No results
			if($numQualifierAssociations == 0) {
				$GLOBALS['DisplayGrid'] = "none";
				if(count($_GET) > 1) {
					if ($MsgDesc == "") {
						$GLOBALS['Message'] = MessageBox(GetLang('NoQualifierAssociationResults'), MSG_ERROR);
					}
				}
				else {
					$GLOBALS['DisplaySearch'] = "none";
					$GLOBALS['Message'] = MessageBox(GetLang('NoQualifierAssociations'), MSG_SUCCESS);
				}
			}

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("qualifier.associations.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		public function DeleteQualifierAssociations()
		{   
            if (isset($_POST['qualifierassociations'])) {

				$qualifierassociationids = implode("','", $GLOBALS['ISC_CLASS_DB']->Quote($_POST['qualifierassociations']));

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['qualifierassociations']));

				// Delete the qualifierassociations
				$query = sprintf("delete from [|PREFIX|]qualifier_associations where associd in ('%s')", $qualifierassociationids);
				$GLOBALS["ISC_CLASS_DB"]->Query($query);
                
				$err = $GLOBALS["ISC_CLASS_DB"]->Error();
				if ($err != "") {
					$this->ManageQualifierAssociations($err, MSG_ERROR);
				} else {
					//$this->ManageQualifierAssociations(GetLang('QualifierAssociationsDeletedSuccessfully'), MSG_SUCCESS);
                    $this->ShowCategoryRows(GetLang('QualifierAssociationsDeletedSuccessfully'), MSG_SUCCESS);  
				}
			} else {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_QualifierAssociations)) {
					$this->ShowCategoryRows();  
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

		public function AddQualifierAssociations()
		{
			$GLOBALS['QualifierAssociationTitle'] = GetLang('AddQualifierAssociations');
			$GLOBALS['QualifierAssociationIntro'] = GetLang('AddQualifierAssociationIntro');
			$GLOBALS['CancelMessage'] = GetLang('CancelCreateQualifierAssociation');
			$GLOBALS['FormAction'] = "SaveNewQualifierAssociations";

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("qualifierassociation.form");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		public function GetQualifierAssociationsAsOptions($SelectedQualifierAssociationId = 0)
		{
			// Return a list of qualifierassociations as options for a select box.
			$output = "";
			$sel = "";
			$query = "SELECT * FROM [|PREFIX|]qualifierassociations ORDER BY qualifierassociationname asc";
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				if($row['qualifierassociationid'] == $SelectedQualifierAssociationId) {
					$sel = "selected=\"selected\"";
				}
				else {
					$sel = "";
				}

				$output .= sprintf("<option value='%d' %s>%s</option>", $row['qualifierassociationid'], $sel, $row['qualifierassociationname']);
			}

			return $output;
		}

		public function GetQualifierAssociationsAsArray(&$RefArray)
		{
			/*
				Return a list of qualifierassociations as an array. This will be used to check
				if a qualifierassociation already exists. It's more efficient to do one query
				rather than one query per qualifierassociation check.

				$RefArray - An array passed in by reference only
			*/

			$query = "select qualifierassociationname from [|PREFIX|]qualifierassociations";
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result))
				$RefArray[] = isc_strtolower($row['qualifierassociationname']);
		}

		public function SaveNewQualifierAssociations()
		{
			$qualifierassociations_added = 0;
			$message = "";
			$current_qualifierassociations = array();
			$this->GetQualifierAssociationsAsArray($current_qualifierassociations);

			if(isset($_POST['qualifierassociations'])) {
				$qualifierassociations = $_POST['qualifierassociations'];
				$qualifierassociation_list = explode("\n", $qualifierassociations);

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($qualifierassociation_list);

				// Save the qualifierassociations to the database
				foreach($qualifierassociation_list as $qualifierassociation) {
					$qualifierassociation = trim($qualifierassociation);
					if(!in_array(isc_strtolower($qualifierassociation), $current_qualifierassociations) && trim($qualifierassociation) != "") {
						$newQualifierAssociation = array(
							"qualifierassociationname" => $qualifierassociation,
							"qualifierassociationpagetitle" => "",
							"qualifierassociationmetakeywords" => "",
							"qualifierassociationmetadesc" => ""
						);
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("qualifierassociations", $newQualifierAssociation);
						++$qualifierassociations_added;
					}
				}

				// Check for an error message from the database
				if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
					// No error
					if($qualifierassociations_added == 1) {
						$message = GetLang('OneQualifierAssociationAddedSuccessfully');
					}
					else {
						$message = sprintf(GetLang('MultiQualifierAssociationsAddedSuccessfully'), $qualifierassociations_added);
					}

					$this->ManageQualifierAssociations($message, MSG_SUCCESS);
				}
				else {
					// Something went wrong
					$message = sprintf(GetLang('QualifierAssociationAddError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
					$this->ManageQualifierAssociations($message, MSG_ERROR);
				}
			}
			else {
				ob_end_clean();
				header("Location: index.php?ToDo=viewQualifierAssociations");
				die();
			}
		}

		public function EditQualifierAssociation($MsgDesc = "", $MsgStatus = "")
		{
			if(isset($_GET['QualifierAssociationId'])) {    
				if ($MsgDesc != "") {
					$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
				}

				$QualifierAssociationId = (int)$_GET['QualifierAssociationId'];
				$query = sprintf("SELECT qa.associd, qa.categoryid, qa.qualifierid, qa.displayname, qa.comments, qa.qualifier_visible, c.catname, mn.column_name, qa.hoverimage 
                FROM [|PREFIX|]qualifier_associations qa 
                INNER JOIN [|PREFIX|]categories c ON qa.categoryid = c.categoryid
                INNER JOIN [|PREFIX|]qualifier_names mn ON qa.qualifierid = mn.qid WHERE qa.associd='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($QualifierAssociationId));
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
					$GLOBALS['QualifierAssociationId'] = $row['associd'];
					$GLOBALS['AssociationDisplayName'] = isc_html_escape($row['displayname']);
                    $GLOBALS['QualifierDisplayName'] = isc_html_escape($row['column_name']);
                    $GLOBALS['CategoryName'] = isc_html_escape($row['catname']);
                    $GLOBALS['AssociationComments'] = isc_html_escape($row['comments']);
                    $qualifiervisible = $row['qualifier_visible']; # Visible to selected -- Baskaran
                    if($qualifiervisible == 1){  
                        $GLOBALS['TrueVisible'] = "selected = 'selected'";
                    }
                    else {
                        $GLOBALS['FalseVisible'] = "selected = 'selected'";
                    }

					/*
                    $GLOBALS['QualifierAssociationPageTitle'] = isc_html_escape($row['qualifierassociationpagetitle']);
					$GLOBALS['QualifierAssociationMetaKeywords'] = isc_html_escape($row['qualifierassociationmetakeywords']);
					$GLOBALS['QualifierAssociationMetaDesc'] = isc_html_escape($row['qualifierassociationmetadesc']);
					$GLOBALS['QualifierAssociationTitle'] = GetLang('EditQualifierAssociation');
					$GLOBALS['QualifierAssociationIntro'] = GetLang('EditQualifierAssociationIntro');
                    */
					$GLOBALS['CancelMessage'] = GetLang('CancelEditQualifierAssociation');
					$GLOBALS['FormAction'] = "SaveEditedQualifierAssociations";
					$GLOBALS['QualifierAssociationImageMessage'] = '';
					if ($row['hoverimage'] != '') {
						$image = '../' . GetConfig('ImageDirectory') . '/' . $row['hoverimage'];
						$GLOBALS['QualifierAssociationImageMessage'] = sprintf(GetLang('QualifierAssociationImageDesc'), $image, $row['hoverimage']);
					}

					$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("qualifier.associations.edit.form");
					$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
				}
				else {
					ob_end_clean();
					header("Location: index.php?ToDo=viewQualifierAssociations");
					die();
				}
			}
			else {
				ob_end_clean();
				header("Location: index.php?ToDo=viewQualifierAssociations");
				die();
			}
		}

		public function SaveEditedQualifierAssociation()
		{
			if(isset($_POST['qualifierassociationid'])) {
				$QualifierAssociationId = (int)$_POST['qualifierassociationid'];     
				$AssociationDisplayName = $_POST['associationdisplayname'];
				$AssociationComments    = $_POST['associationcomments'];
                $QualifierVisible = $_POST['qualifier_visible'];
				
				// No duplicates
				$updatedQualifierAssociation = array(
					"displayname" => $AssociationDisplayName,
					"comments" => $AssociationComments,
                    "qualifier_visible" => $QualifierVisible
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("qualifier_associations", $updatedQualifierAssociation, "associd='".$GLOBALS['ISC_CLASS_DB']->Quote($QualifierAssociationId)."'");
                
				if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {  
					if (array_key_exists('delassociationimage', $_POST) && $_POST['delassociationimage']) {
						$this->DelQualifierAssociationImage($QualifierAssociationId);
						$GLOBALS['ISC_CLASS_DB']->UpdateQuery('qualifier_associations', array('hoverimage' => ''), "associd='" . (int)$QualifierAssociationId . "'");
					} else if (array_key_exists('associationimage', $_FILES) && ($AssociationImage = $this->SaveQualifierAssociationImage())) {
						$GLOBALS['ISC_CLASS_DB']->UpdateQuery('qualifier_associations', array('hoverimage' => $AssociationImage), "associd='" . (int)$QualifierAssociationId . "'");
					}

					//$this->ManageQualifierAssociations(GetLang('QualifierAssociationUpdatedSuccessfully'), MSG_SUCCESS);
                    $this->ShowCategoryRows(GetLang('QualifierAssociationUpdatedSuccessfully'), MSG_SUCCESS);
				}
				else {
					$this->EditQualifierAssociation(sprintf(GetLang('UpdateQualifierAssociationError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR);
				}
			}
			else {
				ob_end_clean();
				header("Location: index.php?ToDo=viewQualifierAssociations");
				die();
			}
		}

		private function SaveQualifierAssociationImage()
		{
			if (!array_key_exists('associationimage', $_FILES) || $_FILES['associationimage']['error'] !== 0 || strtolower(substr($_FILES['associationimage']['type'], 0, 6)) !== 'image/') {
				return false;
			}

			// Attempt to set the memory limit
			setImageFileMemLimit($_FILES['associationimage']['tmp_name']);

			// Generate the destination path
			$randomDir = strtolower(chr(rand(65, 90)));
			$destPath = realpath(ISC_BASE_PATH.'/'.GetConfig('ImageDirectory'));

			if (!is_dir($destPath . '/' . $randomDir)) {
				if (!@mkdir($destPath . '/' . $randomDir, 0777)) {
					$randomDir = '';
				}
			}

			$destFile = GenRandFileName($_FILES['associationimage']['name'], 'category');
			$destPath = $destPath . '/' . $randomDir . '/' . $destFile;
			$returnPath = $randomDir . '/' . $destFile;

			$tmp = explode('.', $_FILES['associationimage']['name']);
			$ext = strtolower($tmp[count($tmp)-1]);

			if ($ext == 'jpg') {
				$srcImg = imagecreatefromjpeg($_FILES['associationimage']['tmp_name']);
			} else if($ext == 'gif') {
				$srcImg = imagecreatefromgif($_FILES['associationimage']['tmp_name']);
				if(!function_exists('imagegif')) {
					$gifHack = 1;
				}
			} else {
				$srcImg = imagecreatefrompng($_FILES['associationimage']['tmp_name']);
			}

			$srcWidth = imagesx($srcImg);
			$srcHeight = imagesy($srcImg);
			$widthLimit = GetConfig('PQVQImageWidth');
			$heightLimit = GetConfig('PQVQImageHeight');

			// If the image is small enough, simply move it and leave it as is
			if($srcWidth <= $widthLimit && $srcHeight <= $heightLimit) {
				imagedestroy($srcImg);
				move_uploaded_file($_FILES['associationimage']['tmp_name'], $destPath);
				return $returnPath;
			}

			// Otherwise, the image needs to be resized
			$attribs = getimagesize($_FILES['associationimage']['tmp_name']);
			$width = $attribs[0];
			$height = $attribs[1];

			if($width > $widthLimit) {
				$height = ceil(($widthLimit/$width)*$height);
				$width = $widthLimit;
			}

			if($height > $heightLimit) {
				$width = ceil(($heightLimit/$height)*$width);
				$height = $heightLimit;
			}

			$dstImg = imagecreatetruecolor($width, $height);
			if($ext == "gif" && !isset($gifHack)) {
				$colorTransparent = imagecolortransparent($srcImg);
				imagepalettecopy($srcImg, $dstImg);
				imagecolortransparent($dstImg, $colorTransparent);
				imagetruecolortopalette($dstImg, true, 256);
			}
			else if($ext == "png") {
				ImageColorTransparent($dstImg, ImageColorAllocate($dstImg, 0, 0, 0));
				ImageAlphaBlending($dstImg, false);
			}

			imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);

			if ($ext == "jpg") {
				imagejpeg($dstImg, $destPath, 100);
			} else if($ext == "gif") {
				if(isset($gifHack) && $gifHack == true) {
					$thumbFile = isc_substr($destPath, 0, -3)."jpg";
					imagejpeg($dstImg, $destPath, 100);
				}
				else {
					imagegif($dstImg, $destPath);
				}
			} else {
				imagepng($dstImg, $destPath);
			}

			@imagedestroy($dstImg);
			@imagedestroy($srcImg);
			@unlink($_FILES['associationimage']['tmp_name']);

			// Change the permissions on the thumbnail file
			isc_chmod($returnPath, ISC_WRITEABLE_FILE_PERM);
            
			return $returnPath;
		}

		private function DelQualifierAssociationImage($file)
		{
			if (isId($file)) {
				if (!($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]qualifier_associations WHERE QualifierAssociationId='" . (int)$file . "'")))) {
					return false;
				}

				if ($row['hoverimage'] == '') {
					return true;
				} else {
					$file = $row['hoverimage'];
				}
			}

			$file = realpath(ISC_BASE_PATH.'/' . GetConfig('ImageDirectory') . '/' . $file);

			if ($file == '') {
				return false;
			}

			if (file_exists($file)) {
				@unlink($file);
				clearstatcache();
			}

			return !file_exists($file);
		}        
        
        private function ShowCategoryRows($MsgDesc = "", $MsgStatus = "")     {
            
            if ($MsgDesc != "") {
                $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
            }

            //For Department Options Added by Simha   
            $GLOBALS['DeptFilterOptions'] = $this->getDepartmentList();
            if(!isset($_REQUEST['deptid']))    {
                $_REQUEST['deptid'] = $this->firstdept;
            }
            //For Department Options  Ends Added by Simha
            
            $GLOBALS['ShopPath'] = GetConfig('ShopPath');
            $GLOBALS['CategoryGrid'] = $this->_BuildCategoryRows(0);  
            if (!empty($GLOBALS['CategoryGrid'])) {
                /*$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("qualifiercat.manage");
                $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(); */
                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("qualifiercat.manage.grid");
                $GLOBALS['FullCategoryGrid'] = $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);     
                // Was this an ajax based sort? Return the table now
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                    echo $GLOBALS['FullCategoryGrid'];
                    return;
                }      
                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("qualifiercat.manage");
                $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
            }
        } 
        
        private function _BuildCategoryRows($parentid=0)
        {
            static $categorycache, $product_counts;

            if(!isset($_REQUEST['deptid']))    {
                $resdeptid = 0;
            }
            else    {
                $resdeptid = $_REQUEST['deptid'];  
            }
            
            if(!is_array($categorycache)) {
                
                $query = "SELECT * FROM [|PREFIX|]categories  WHERE 1=1 ";   
                
                if($resdeptid != 0)    {
                     $query .= " AND catdeptid=".$resdeptid;
                }
                
                $query .= " ORDER BY catdeptid ASC , catsort ASC , catname ASC";
                
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                    $categorycache[$row['catparentid']][] = $row;
                }

                $query = "select categoryid, count(productid) as total from [|PREFIX|]categoryassociations group by categoryid";
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);

                while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                    $product_counts[$row['categoryid']] = $row['total'];
                }

            }

            if(!isset($categorycache[$parentid])) {
                return '';
            }

            $categoryList = '';

            foreach($categorycache[$parentid] as $category) {
                $GLOBALS['SubCats'] = $this->_BuildCategoryRows($category['categoryid']);
                if($GLOBALS['SubCats']) {
                    $GLOBALS['SubCats'] = sprintf('<ul class="SortableList">%s</ul>', $GLOBALS['SubCats']);
                }

                $GLOBALS['CatId'] = (int) $category['categoryid'];
                $GLOBALS['CatName'] = isc_html_escape($category['catname']);


                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
                    if ($category['catvisible'] == 1) {
                        $GLOBALS['CatVisible'] = "<a id='CatVisible_".$category['categoryid']."' title='".GetLang('ClickToHideCategory')."' href='index.php?ToDo=editCategoryVisibility&amp;catId=".$category['categoryid']."&amp;visible=0' onclick=\"quickToggle(this); return false;\"><img border='0' src='images/tick.gif' alt='Visible'></a>";
                    } else {
                        $GLOBALS['CatVisible'] = "<a id='CatVisible_".$category['categoryid']."' title='".GetLang('ClickToShowCategory')."' href='index.php?ToDo=editCategoryVisibility&amp;catId=".$category['categoryid']."&amp;visible=1' onclick=\"quickToggle(this); return false;\"><img border='0' src='images/cross.gif' alt='Invisible'></a>";
                    }
                } else {
                    if ($category['catvisible'] == 1) {
                        $GLOBALS['CatVisible'] = '<img border="0" src="images/tick.gif" alt="Visible">';
                    } else {                                               
                        $GLOBALS['CatVisible'] = '<img border="0" src="images/cross.gif" alt="Invisible">';
                    }
                }

                if (isset($product_counts[$category['categoryid']])) {
                    $GLOBALS['Products'] = (int) $product_counts[$category['categoryid']];
                } else {
                    $GLOBALS['Products'] = 0;
                }

                $GLOBALS['ViewLink'] = sprintf("<a title='%s' href=\"%s\" class=\"bodylink\" target='_blank'>%s</a>", GetLang('ViewCategory'), CatLink($category['categoryid'], $category['catname']), GetLang('View'));

                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Create_Category)) {
                    $GLOBALS['NewLink'] = sprintf("<a title='%s' href=\"index.php?ToDo=createCategory&amp;parentId=%s\" class=\"bodylink\">%s</a>", GetLang('NewCategory'), $category['categoryid'], GetLang('New'));
                } else {
                    $GLOBALS['NewLink'] = sprintf("<a disabled class=\"bodylink\">%s</a>", GetLang('New'));
                }

                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Categories)) {
                    $GLOBALS['EditLink'] = sprintf("<a title='%s' href=\"index.php?ToDo=editCategory&amp;catId=%s\" class=\"bodylink\">%s</a>", GetLang('EditCategory'), $category['categoryid'], GetLang('Edit'));
                } else {
                    $GLOBALS['EditLink'] = sprintf("<a disabled class=\"bodylink\">%s</a>", GetLang('Edit'));
                }

                if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Categories)) {
                    $GLOBALS['DisableDelete'] = "DISABLED";
                }

                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("qualifiercat.manage.row");
                //$GLOBALS['CategoryGrid'] .= $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
                $categoryList .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }
            return $categoryList;
        }

        public function listQualifiers()  
        {     
            $CatID = $_GET['catid'];
            
            /* 
            $uQuery = "SELECT catuniversal FROM [|PREFIX|]categories WHERE categoryid='".$CatID."'";
            $uResult = $GLOBALS['ISC_CLASS_DB']->Query($uQuery);
            $isUniversal = $GLOBALS['ISC_CLASS_DB']->FetchOne($uResult);
            if(isset($_REQUEST['ajax']) && $isUniversal)    {
                  echo "<I>Universal categories will not have Qualifier Associations<I>";
                  return;
            }
            */
            // Fetch any results, place them in the data grid
            $numQualifierAssociations = 0;
            $GLOBALS['QualifierAssociationsDataGrid'] = $this->ManageQualifierAssociationsGrid($numQualifierAssociations);

            // Was this an ajax based sort? Return the table now
            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                echo $GLOBALS['QualifierAssociationsDataGrid'];
                return;
            }  
            
        }  
        
        private function getDepartmentList($deptid = 0) {
            $options = '';
            $query = "select * from [|PREFIX|]department ORDER BY deptname ASC";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $sel = '';
                if($deptid == $row['deptid']) {
                    $sel = 'selected="selected"';
                }
                if($this->firstdept==0) 
                {
                    $this->firstdept = (int)$row['deptid'];
                }
                $options .= '<option value='.(int)$row['deptid'].' '.$sel.'>'.isc_html_escape($row['deptname']).'</option>';
            }
            $options .= '<option value="all">All Departments</option>'; 
            return $options;
        }   
        
	}

?>
