<?php           
	class ISC_ADMIN_QVALUE_ASSOCIATIONS
	{
		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('qvalue.associations'); 
			switch (isc_strtolower($Do)) {
				case "saveeditedqvalueassociations":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Qualifier_Associations)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QualifierAssociations') => "index.php?ToDo=viewQualifierAssociations");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SaveEditedQValueAssociation();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "editqvalueassociations":
				{           
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_QValue_Associations)) {      
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QValueAssociations') => "index.php?ToDo=viewQValueAssociations", GetLang('EditQValueAssociation') => "index.php?ToDo=editQValueAssociations");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->EditQValueAssociation(); 
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();          
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "savenewqvalueassociations":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_QValue_Association)) {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->SaveNewQValueAssociations();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "addqvalueassociation":
				{
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_QValue_Association)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QValueAssociations') => "index.php?ToDo=viewQValueAssociations", GetLang('AddQValueAssociations') => "index.php?ToDo=addQValueAssociations");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddQValueAssociations();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}       
                case "loadqualifiersqvalueassociations":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_QValue_Associations)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QValueAssociations') => "index.php?ToDo=viewQValueAssociations", GetLang('AddQValueAssociations') => "index.php?ToDo=addQValueAssociations");
                        //$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->loadAjaxQualifiers();
                        //$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
                case "printqualifiersqvalueassociations":
                {    
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_QValue_Associations)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QValueAssociations') => "index.php?ToDo=viewQValueAssociations", GetLang('AddQValueAssociations') => "index.php?ToDo=addQValueAssociations");
                        $this->_PrintQualifiers();                           
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }    
                case "printqvaluesqvalueassociations":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_QValue_Associations)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QValueAssociations') => "index.php?ToDo=viewQValueAssociations", GetLang('AddQValueAssociations') => "index.php?ToDo=addQValueAssociations");
                        $this->_PrintQValues();                              
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
				case "deleteqvalueassociations":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_QValue_Associations)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QValueAssociations') => "index.php?ToDo=viewQValueAssociations");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeleteQValueAssociations();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
                case "listqualifiersqvalueassociations":
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
                case "listqvaluesqvalueassociations":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_QValue_Associations)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QValueAssociations') => "index.php?ToDo=viewQValueAssociations", GetLang('AddQValueAssociations') => "index.php?ToDo=addQValueAssociations");
                        //$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        $this->listQValues();
                        //$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        die();
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }

                    break;
                }
				default:
				{               
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_QValue_Associations)) {
						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('QValueAssociations') => "index.php?ToDo=viewQValueAssociations");

						if(!isset($_REQUEST['ajax'])) {
							$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						}

						//$this->ManageQValueAssociations();
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
                SELECT qa.associd, qa.categoryid, qa.qualifierid, qa.displayname, qa.comments, c.catname, mn.column_name 
                FROM [|PREFIX|]qualifier_associations qa 
                INNER JOIN [|PREFIX|]categories c ON qa.categoryid = c.categoryid
                INNER JOIN [|PREFIX|]qualifier_names mn ON qa.qualifierid = mn.qid 
            ";

            $countQuery = "
                            SELECT COUNT(associd) FROM [|PREFIX|]qualifier_associations qa
                            INNER JOIN [|PREFIX|]categories c ON qa.categoryid = c.categoryid
                            INNER JOIN [|PREFIX|]qualifier_names mn ON qa.qualifierid = mn.qid 
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
            }    
            
            $query .= $queryWhere;
            $countQuery .= $queryWhere;
           
            $result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
            $NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);

            if($NumResults > 0) {
                $query .= " ORDER BY c.catname, ".$SortField." ".$SortOrder;

                // Add the limit
                //$query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_BRANDS_PER_PAGE);    
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                return $result;
            }
            else {
                return false;
            }
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
                    $GLOBALS['QualifierAssociationId'] = (int) $row['associd'];
                    $GLOBALS['QualifierDisplayName'] = isc_html_escape($row['column_name']);
                    $GLOBALS['AssociationDisplayName'] = $row['displayname'];

                    // Workout the edit link -- do they have permission to do so?
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Qualifier_Associations)) {
                        $GLOBALS['EditQualifierAssociationLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editQualifierAssociations&amp;QualifierAssociationId=%d'>%s</a>", GetLang('QualifierAssociationEdit'), $row['associd'], GetLang('Edit'));
                    } else {
                        $GLOBALS['EditNewsLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
                    }

                    /*
                    if($tempcategoryid != $row['categoryid'])    {
                        $GLOBALS['QualifierAssociationGrid'] .= '<tr bgcolor="#eeeeee">
                                                                    <td align="left" style="height:27px;" colspan="5">
                                                                        &nbsp;&nbsp;<b>'.$row['catname'].'</b>
                                                                    </td>
                                                                </tr>';
                        $tempcategoryid = $row['categoryid'];
                    }
                    */
                    
                    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("qvalue.qualifier.manage.row");
                    $GLOBALS['QualifierAssociationGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true); 
                } 
                
            }
            //$GLOBALS['QualifierAssociationGrid'] .= "<tr><td>&nbsp;</td><td colspan='4'><a href='#' onclick='AssignNewQualifiers(".$_GET['catid'].")'>New Qualifier<a></td></tr>";      
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("qvalue.qualifier.manage.grid");
            return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
        }

		public function _GetQValueAssociationList(&$Query, $Start, $SortField, $SortOrder, &$NumResults)
		{
			// Return an array containing details about qualifierassociations.
			// Takes into account search too.
            $selcatid       = '';
            $selassocid     = '';
            $selqualifierid = '';
            /*
            if(!isset($_GET['ajax']))    {
                 
                $pquery = "
                SELECT qva.qvalueassocid, qva.categoryid, qva.associd, qa.qualifierid 
                FROM [|PREFIX|]qvalue_associations qva 
                INNER JOIN [|PREFIX|]categories c ON qva.categoryid = c.categoryid
                INNER JOIN [|PREFIX|]qualifier_associations qa ON qva.associd = qa.associd
                INNER JOIN [|PREFIX|]qualifier_names qn ON qn.qid = qa.qualifierid ORDER BY qva.qvalueassocid DESC LIMIT 1
            ";
                 $presult = $GLOBALS['ISC_CLASS_DB']->Query($pquery);
                 while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($presult)) { 
                    $selcatid       = $row['categoryid'];
                    $selassocid     = $row['associd'];
                    $selqualifierid = $row['qualifierid'];
                 }
                 
                               
            }
            else    {
                 $selcatid       = $_GET['precategoryid'];
                 $selqualifierid = $_GET['prequalifierid']; 
                 
                 //Get Association Id from catid and qualifierid
                $aquery = "SELECT associd FROM [|PREFIX|]qualifier_associations 
                                WHERE categoryid='".$selcatid."' AND qualifierid='".$selqualifierid."'"; 
                $aresult = $GLOBALS['ISC_CLASS_DB']->Query($aquery);
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($aresult)) { 
                      $QualifierAssociationId = $row['associd'];
                }  
                $selassocid     = $QualifierAssociationId;  
                   
            }
            */
            //echo $selcatid."<br />".$selassocid."<br />".$selqualifierid;
            
			// PostgreSQL is case sensitive for likes, so all matches are done in lower case
			$Query = trim(isc_strtolower($Query));
            
            $query = "
                SELECT qva.qvalueassocid, qva.categoryid, qva.associd, qa.qualifierid, qva.displayname, qva.comments, c.catname, qn.column_name, qva.qvalue 
                FROM [|PREFIX|]qvalue_associations qva 
                INNER JOIN [|PREFIX|]categories c ON qva.categoryid = c.categoryid
                INNER JOIN [|PREFIX|]qualifier_associations qa ON qva.associd = qa.associd
                INNER JOIN [|PREFIX|]qualifier_names qn ON qn.qid = qa.qualifierid 
            ";

			$countQuery = "
                            SELECT COUNT(qvalueassocid) 
                            FROM [|PREFIX|]qvalue_associations qva 
                            INNER JOIN [|PREFIX|]categories c ON qva.categoryid = c.categoryid
                            INNER JOIN [|PREFIX|]qualifier_associations qa ON qva.associd = qa.associd
                            INNER JOIN [|PREFIX|]qualifier_names qn ON qn.qid = qa.qualifierid 
                ";

			$queryWhere  = ' WHERE 1=1 ';
            /*if(isset($_GET['precategoryid']))    { 
                $selcatid       = $_GET['precategoryid'];
                $queryWhere .= " AND qva.categoryid='".$selcatid."'";   
            }
            if(isset($_GET['prequalifierid']))    {
                $selqualifierid = $_GET['prequalifierid'];    
                $queryWhere .= " AND qa.qualifierid='".$selqualifierid."'";
            }*/     
            if(isset($_GET['associd']))    {
                $associd = $_GET['associd'];    
                $queryWhere .= " AND qva.associd='".$associd."'";
            }    
			/*if ($Query != "") {
				$queryWhere .= " AND LOWER(b.qualifierassociationname) LIKE '%".$GLOBALS['ISC_CLASS_DB']->Quote($Query)."%'";
			} */
            
			$query .= $queryWhere;
			$countQuery .= $queryWhere;
           
			$result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
			$NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result); 
            
			if($NumResults > 0) {
				$query .= " ORDER BY qva.categoryid ASC, qa.qualifierid ASC, ".$SortField." ".$SortOrder;

				// Add the limit
				$query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_BRANDS_PER_PAGE);    
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
				return $result;
			}
			else {
				return false;
			}
		}
                         
		public function ManageQValueAssociationsGrid(&$numQValueAssociations)
		{
			// Show a list of news in a table
			$page = 0;
			$start = 0;
			$numQValueAssociations = 0;
			$numPages = 0;
			$GLOBALS['QValueAssociationGrid'] = "";
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
				"QValueName" => "qva.qvalue",
                "AssociationDisplayName" => "qva.displayname",
				"Comments" => "qa.comments"
			);
           
			if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
				$sortField = $_GET['sortField'];
				SaveDefaultSortField("ManageQValueAssociations", $_REQUEST['sortField'], $sortOrder);
			}
			else {
				list($sortField, $sortOrder) = GetDefaultSortField("QValueAssociationGrid", "qva.qvalueassocid", $sortOrder);
			}

			if (isset($_GET['page'])) {
				$page = (int)$_GET['page'];
			}
			else {
				$page = 1;
			}
            
            $sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
            
            $resultFilter = '';
            
            if(isset($_GET['precategoryid']) && isset($_GET['prequalifierid']))    { 
                 $resultFilter = sprintf("&precategoryid=%d&prequalifierid=%d", $_GET['precategoryid'], $_GET['prequalifierid']);
            }
            
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
			$qValueAssociationResult = $this->_GetQValueAssociationList($query, $start, $sortField, $sortOrder, $numQValueAssociations); 
            
			$numPages = ceil($numQValueAssociations / ISC_BRANDS_PER_PAGE);

			// Workout the paging navigation
			if($numQValueAssociations > ISC_BRANDS_PER_PAGE) {
				$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

				$GLOBALS['Nav'] .= BuildPagination($numQValueAssociations, ISC_BRANDS_PER_PAGE, $page, sprintf("index.php?ToDo=viewQValueAssociations%s%s", $sortURL, $resultFilter));
			}
			else {
				$GLOBALS['Nav'] = "";
			}

			$GLOBALS['SearchQuery'] = $query;
			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;
            //$GLOBALS['resultFilter'] = $resultFilter;

			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewQValueAssociations&amp;".$searchURL."&amp;page=".$page."&amp;page=".$page.$resultFilter, $sortField, $sortOrder);


			// Workout the maximum size of the array
			$max = $start + ISC_BRANDS_PER_PAGE;

			if ($max > count($qValueAssociationResult)) {
				$max = count($qValueAssociationResult);
			}
            
			if($numQValueAssociations > 0) {
                $tempcategoryid = 0;
                $tempqualifierid = 0;
				// Display the news
                
				while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($qValueAssociationResult)) {  
                    $GLOBALS['QValueAssociationId'] = (int) $row['qvalueassocid'];     
					$GLOBALS['QualifierAssociationId'] = (int) $row['associd'];
					$GLOBALS['QualifierDisplayName'] = isc_html_escape($row['column_name']);
                    $GLOBALS['QValueName'] = isc_html_escape($row['qvalue']); 
					$GLOBALS['AssociationDisplayName'] = $row['displayname'];

					// Workout the edit link -- do they have permission to do so?
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_QValue_Associations)) {
						$GLOBALS['EditQValueAssociationLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editQValueAssociations&amp;QValueAssociationId=%d'>%s</a>", GetLang('QValueAssociationEdit'), $row['qvalueassocid'], GetLang('Edit'));
					} else {
						$GLOBALS['EditNewsLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
					}
                    /*
                    if($tempcategoryid != $row['categoryid'])    {
                        $GLOBALS['QValueAssociationGrid'] .= '<tr bgcolor="#eeeeee">
                                                                    <td align="left" style="height:27px;" colspan="5">
                                                                        &nbsp;&nbsp;<b>'.$row['catname'].'</b>
                                                                    </td>
                                                                </tr>';
                        $tempcategoryid = $row['categoryid'];
                        $tempqualifierid = 0;               //Need to start new qualifiers for the category
                    }
                    
                    if($tempqualifierid != $row['qualifierid'])    {
                        $GLOBALS['QValueAssociationGrid'] .= '<tr bgcolor="#eeeeee">
                                                                    <td align="left" style="height:27px;" colspan="5">
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.$row['column_name'].'</b>
                                                                    </td>
                                                                </tr>';
                        $tempqualifierid = $row['qualifierid'];
                    }
                    */
					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("qvalue.associations.manage.row");
					$GLOBALS['QValueAssociationGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
                    
				}
			}      
            $GLOBALS['QValueAssociationGrid'] .= "<tr><td>&nbsp;</td><td colspan='4'><a href='#' onclick='AssignNewQValues(".$_GET['associd'].")'>New Qualifier Value<a></td></tr>";  
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("qvalue.associations.manage.grid");
            return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		public function ManageQValueAssociations($MsgDesc = "", $MsgStatus = "")
		{
			// Fetch any results, place them in the data grid
			$numQValueAssociations = 0;
			$GLOBALS['QValueAssociationsDataGrid'] = $this->ManageQValueAssociationsGrid($numQValueAssociations);

			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['QValueAssociationsDataGrid'];
				return;
			}                
            
			if ($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			if (isset($_GET['searchQuery'])) {
				$GLOBALS['ClearSearchLink'] = '<a id="SearchClearButton" href="index.php?ToDo=viewQValueAssociations">'.GetLang('ClearResults').'</a>';
			} else {
				$GLOBALS['ClearSearchLink'] = '';
			}

			$GLOBALS['QValueAssociationIntro'] = GetLang('ManageQValueAssociationsIntro');

			// Do we need to disable the delete button?
			if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_QValue_Associations) || $numQValueAssociations == 0) {
				$GLOBALS['DisableDelete'] = "DISABLED";
			}

			// No results
			if($numQValueAssociations == 0) {
				$GLOBALS['DisplayGrid'] = "none";
				if(count($_GET) > 1) {
					if ($MsgDesc == "") {
						$GLOBALS['Message'] = MessageBox(GetLang('NoQValueAssociationResults'), MSG_ERROR);
					}
				}
				else {
					$GLOBALS['DisplaySearch'] = "none";
					$GLOBALS['Message'] = MessageBox(GetLang('NoQValueAssociations'), MSG_SUCCESS);
				}
			}
            $GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');  
            //$GLOBALS['PreCategoryOptions']   = $this->GetAllCategoryOptions();
            $GLOBALS['PreCategoryOptions']      = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions(); 
            
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("qvalue.associations.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}

		public function DeleteQValueAssociations()
		{
			if (isset($_POST['qvalueassociations'])) {

				$qvalueassociationids = implode("','", $GLOBALS['ISC_CLASS_DB']->Quote($_POST['qvalueassociations']));

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['qvalueassociations']));

				// Delete the qualifierassociations
				$query = sprintf("delete from [|PREFIX|]qvalue_associations where qvalueassocid in ('%s')", $qvalueassociationids);
				$GLOBALS["ISC_CLASS_DB"]->Query($query);
                
				$err = $GLOBALS["ISC_CLASS_DB"]->Error();
				if ($err != "") {
					$this->ManageQValueAssociations($err, MSG_ERROR);
                    $this->ShowCategoryRows($err, MSG_ERROR); 
				} else {
					//$this->ManageQValueAssociations(GetLang('QValueAssociationsDeletedSuccessfully'), MSG_SUCCESS);
                    $this->ShowCategoryRows(GetLang('QValueAssociationsDeletedSuccessfully'), MSG_SUCCESS);   
				}
			} else {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_QValue_Associations)) {
					//$this->ManageQValueAssociations();
                    $this->ShowCategoryRows();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}
                        
		public function AddQValueAssociations()
		{
			$GLOBALS['QValueAssociationTitle'] = GetLang('AddQValueAssociations');
			$GLOBALS['QValueAssociationIntro'] = GetLang('AddQValueAssociationIntro');
			$GLOBALS['CancelMessage'] = GetLang('CancelCreateQValueAssociation');
			$GLOBALS['FormAction'] = "SaveNewQValueAssociations";
            
            //$GLOBALS['CategoryOptions']   = $this->GetAllCategoryOptions();

            $GLOBALS['ISC_CLASS_ADMIN_CATEGORY'] = GetClass('ISC_ADMIN_CATEGORY');      
            $GLOBALS['CategoryOptions']      = $GLOBALS["ISC_CLASS_ADMIN_CATEGORY"]->GetCategoryOptions(); 
            
            $GLOBALS['QualifierOptions']  = '<select name="qualifier" id="qualifier" class="Field400" onchange="loadQValues(this.value);">
            <option value="">--Choose a qualifier--</option>
            </select>';
            $GLOBALS['QValueOptions']  = '<select name="qvalue" id="qvalue" class="Field400">
            <option value="">--Choose a qualifier value--</option>
            </select>'; 
            
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("qvalue.associations.edit.form");
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

		public function SaveNewQValueAssociations()
		{
			$CategoryId             = $_POST['category'];
            $QualifierId            = $_POST['qualifier']; 
            $QValue                 = $_POST['qvalue']; 
            $AssociationDisplayName = $_POST['associationdisplayname'];
            $AssociationComments    = $_POST['associationcomments'];
            
            $aquery = "select associd FROM [|PREFIX|]qualifier_associations 
                            where categoryid='".$CategoryId."' AND qualifierid='".$QualifierId."'"; 
            $aresult = $GLOBALS['ISC_CLASS_DB']->Query($aquery);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($aresult)) { 
                  $QualifierAssociationId = $row['associd'];
            }  
            
            $query = " SELECT qvalueassocid
                            FROM [|PREFIX|]qvalue_associations
                            WHERE qvalue='".$QValue."' AND associd='".$QualifierAssociationId."'
                            "; 
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $count  = $GLOBALS['ISC_CLASS_DB']->CountResult($result);
            
            if($count==0)  {
                if($AssocImage = $this->SaveQValueAssociationImage())    {
                    $AssociationImage     = $AssocImage; 
                }
                else    {
                    $AssociationImage     = "";
                }
                $newQValueAssociation = array(
				    "associd" => $QualifierAssociationId,
				    "categoryid" => $CategoryId,
				    "displayname" => $AssociationDisplayName,
				    "hoverimage" => $AssociationImage,
                    "comments" => $AssociationComments,
                    "qvalue" => $QValue
			    );
			    $GLOBALS['ISC_CLASS_DB']->InsertQuery("qvalue_associations", $newQValueAssociation);
			    
                // Check for an error message from the database
			    if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {     
				    $message = GetLang('OneQValueAssociationAddedSuccessfully');
				    $this->ManageQValueAssociations($message, MSG_SUCCESS);
			    }
			    else {
				    // Something went wrong
				    $message = sprintf(GetLang('QValueAssociationAddError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
				    $this->ManageQValueAssociations($message, MSG_ERROR);
			    }
            }
            else    {
                 // Certain association already exits
                $message = sprintf(GetLang('QValueAssociationAlreadyExistsError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg());
                $this->ManageQValueAssociations($message, MSG_ERROR);
            }
		}

		public function EditQValueAssociation($MsgDesc = "", $MsgStatus = "")
		{
			
            if(isset($_GET['QValueAssociationId'])) {    
				if ($MsgDesc != "") {
					$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
				}

				$QValueAssociationId = (int)$_GET['QValueAssociationId'];
				/*$query = sprintf("SELECT qa.associd, qa.categoryid, qa.qualifierid, qa.displayname, qa.comments, c.catname, mn.column_name, qa.hoverimage
                FROM [|PREFIX|]qualifier_associations qa 
                INNER JOIN [|PREFIX|]categories c ON qa.categoryid = c.categoryid
                INNER JOIN [|PREFIX|]qualifier_names mn ON qa.qualifierid = mn.qid WHERE qa.associd='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($QualifierAssociationId));*/
                
                $query = sprintf("SELECT qva.qvalueassocid, qva.categoryid, qva.associd, qa.qualifierid, qva.displayname, qva.comments, c.catname, qn.column_name, qva.qvalue, qva.hoverimage, qva.comments  
                FROM [|PREFIX|]qvalue_associations qva 
                INNER JOIN [|PREFIX|]categories c ON qva.categoryid = c.categoryid
                INNER JOIN [|PREFIX|]qualifier_associations qa ON qva.associd = qa.associd
                INNER JOIN [|PREFIX|]qualifier_names qn ON qn.qid = qa.qualifierid
                WHERE qva.qvalueassocid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($QValueAssociationId));
                
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				if($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                    $GLOBALS['QValueAssociationId']     = $row['qvalueassocid'];
					$GLOBALS['QualifierAssociationId']  = $row['associd'];
                    $GLOBALS['CategoryId']              = $row['categoryid'];
                    $GLOBALS['QualifierId']             = $row['qualifierid'];
                    $GLOBALS['QValueName']              = $row['qvalue'];     
                    
                    $GLOBALS['CategoryOptions']         = $this->GetAllCategoryOptions($row['categoryid']);
                    $GLOBALS['QualifierOptions']        = $this->GetQualifierOptions($row['categoryid'], $row['qualifierid']); 
                    $GLOBALS['QValueOptions']           = $this->GetQValueOptions($row['qualifierid'], $row['qvalue']); 
                                        
					$GLOBALS['AssociationDisplayName']  = isc_html_escape($row['displayname']);
                    $GLOBALS['AssociationComments']     = isc_html_escape($row['comments']);
                    
                    /*
                    $GLOBALS['QualifierDisplayName']      = isc_html_escape($row['column_name']);
                    $GLOBALS['CategoryName']                = isc_html_escape($row['catname']);  
                    */
                     
					$GLOBALS['CancelMessage'] = GetLang('CancelEditQValueAssociation');
					$GLOBALS['FormAction'] = "SaveEditedQValueAssociations";
					$GLOBALS['QValueAssociationImageMessage'] = '';
					if ($row['hoverimage'] != '') {
						$image = '../' . GetConfig('ImageDirectory') . '/' . $row['hoverimage'];
						$GLOBALS['QValueAssociationImageMessage'] = sprintf(GetLang('QValueAssociationImageDesc'), $image, $row['hoverimage']);
					}

					$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("qvalue.associations.edit.form");
					$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
				}
				else {
					ob_end_clean();
					header("Location: index.php?ToDo=viewQValueAssociations");
					die();
				}
			}
			else {
				ob_end_clean();
				header("Location: index.php?ToDo=viewQValueAssociations");
				die();
			}
		}

		public function SaveEditedQValueAssociation()
		{
			if(isset($_POST['qvalueassociationid'])) {
                $QValueAssociationId    = (int)$_POST['qvalueassociationid'];
				//$QualifierAssociationId = (int)$_POST['qualifierassociationid'];
                $CategoryId             = $_POST['category'];
                $QualifierId            = $_POST['qualifier']; 
                $QValue                 = $_POST['qvalue']; 
                $AssociationDisplayName = $_POST['associationdisplayname'];
                $AssociationComments    = $_POST['associationcomments'];
				
                //Get Association Id from catid and qualifierid
                $aquery = "SELECT associd FROM [|PREFIX|]qualifier_associations 
                                WHERE categoryid='".$CategoryId."' AND qualifierid='".$QualifierId."'"; 
                $aresult = $GLOBALS['ISC_CLASS_DB']->Query($aquery);
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($aresult)) { 
                      $QualifierAssociationId = $row['associd'];
                }
                
				// No duplicates
				$updatedQValueAssociation = array(
					"associd" => $QualifierAssociationId,
                    "categoryid" => $CategoryId,
                    "displayname" => $AssociationDisplayName,
                    "comments" => $AssociationComments,
                    "qvalue" => $QValue
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("qvalue_associations", $updatedQValueAssociation, "qvalueassocid='".$GLOBALS['ISC_CLASS_DB']->Quote($QValueAssociationId)."'");
                
				if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
					if (array_key_exists('delassociationimage', $_POST) && $_POST['delassociationimage']) {
						$this->DelQValueAssociationImage($QValueAssociationId);
						$GLOBALS['ISC_CLASS_DB']->UpdateQuery('qvalue_associations', array('hoverimage' => ''), "qvalueassocid='" . (int)$QValueAssociationId . "'");
					} else if (array_key_exists('associationimage', $_FILES) && ($AssociationImage = $this->SaveQValueAssociationImage())) {
						$GLOBALS['ISC_CLASS_DB']->UpdateQuery('qvalue_associations', array('hoverimage' => $AssociationImage), "qvalueassocid='" . (int)$QValueAssociationId . "'");
					}
					//$this->ManageQValueAssociations(GetLang('QValueAssociationUpdatedSuccessfully'), MSG_SUCCESS);
                    $this->ShowCategoryRows(GetLang('QValueAssociationUpdatedSuccessfully'), MSG_SUCCESS);   
				}
				else {
					$this->EditQValueAssociation(sprintf(GetLang('UpdateQValueAssociationError'), $GLOBALS["ISC_CLASS_DB"]->GetErrorMsg()), MSG_ERROR);
				}
			}
			else {
				ob_end_clean();
				header("Location: index.php?ToDo=viewQValueAssociations");
				die();
			}
		}

		private function SaveQValueAssociationImage()
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
			$widthLimit = GetConfig('BrandImageWidth');
			$heightLimit = GetConfig('BrandImageHeight');

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

		private function DelQValueAssociationImage($file)
		{
			if (isId($file)) {
				if (!($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]qvalue_associations WHERE qvalueassocid='" . (int)$file . "'")))) {
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
         
        public function GetAllCategoryOptions($SelCatID='')
        {    
            $query = "SELECT * FROM [|PREFIX|]categories ORDER BY catsort ASC, catname ASC";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $CategoryOptions  = '';
            $CategoryOptions .= '<option value="">--Choose a Category--</option>'; 
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {   
                if($row['categoryid']==$SelCatID)    {
                     $CategoryOptions .= '<option value="'.$row['categoryid'].'" selected="selected">'.$row['catname'].'</option>'; 
                }
                else    {
                     $CategoryOptions .= '<option value="'.$row['categoryid'].'">'.$row['catname'].'</option>';           
                }
            }
            return $CategoryOptions;
        }
        
        public function GetQualifierOptions($catid, $selqualifierid)
        {    
            $query = "SELECT qa.associd, qa.qualifierid, qn.column_name  
                        FROM [|PREFIX|]qualifier_associations qa
                        INNER JOIN [|PREFIX|]qualifier_names qn ON qa.qualifierid = qn.qid
                        WHERE qa.categoryid='".$catid."'
                        ORDER BY qa.associd ASC";
            
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $QualifierOptions = '<select name="qualifier" id="qualifier" class="Field400" onchange="loadQValues(this.value);">';
            $QualifierOptions .= '<option value="">--Choose a qualifier--</option>';
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                if($row['qualifierid']==$selqualifierid)    {
                     $QualifierOptions .= '<option value="'.$row['qualifierid'].'" selected="selected">'.$row['column_name'].'</option>'; 
                }
                else    {
                     $QualifierOptions .= '<option value="'.$row['qualifierid'].'">'.$row['column_name'].'</option>';
                }
            }
            $QualifierOptions .='</select>';
            return $QualifierOptions;
        }
        
        
        public function loadAjaxQualifiers()  
        {
            //
            $catid          = $_GET['catid'];
            $selqualifierid = '';
            $query = "SELECT qa.associd, qa.qualifierid, qn.column_name  
                        FROM [|PREFIX|]qualifier_associations qa
                        INNER JOIN [|PREFIX|]qualifier_names qn ON qa.qualifierid = qn.qid
                        WHERE qa.categoryid='".$catid."'
                        ORDER BY qa.associd ASC";
            
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $QualifierOptions = '<select size="1" name="qualifier" id="qualifier" class="Field200" onchange="loadResults(this.value);">';
            $QualifierOptions .= '<option value="">--Choose a qualifier--</option>';
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                if($row['qualifierid']==$selqualifierid)    {
                     $QualifierOptions .= '<option value="'.$row['qualifierid'].'" selected="selected">'.$row['column_name'].'</option>'; 
                }
                else    {
                     $QualifierOptions .= '<option value="'.$row['qualifierid'].'">'.$row['column_name'].'</option>';
                }
            }
            $QualifierOptions .='</select>';
            echo $QualifierOptions;
            return;
        }
        
        public function GetQValueOptions($qualifierid, $selqvalue)
        {    
                       
            if($qualifierid!=0 && $qualifierid!=null)    {
                $query = " SELECT column_name  
                            FROM [|PREFIX|]qualifier_names
                            WHERE qid='".$qualifierid."'"; 
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                     $qualifiername = $row['column_name'];
                }
            }
            
            $query = "SELECT DISTINCT `".$qualifiername."`  
                        FROM [|PREFIX|]import_variations iv
                        WHERE `".$qualifiername."`!=''";

            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $QValueOptions = '<select name="qvalue" id="qvalue" class="Field400">';
            $QValueOptions .= '<option value="">--Choose a qualifier value--</option>';
            
            $array_qvalues = array();
            
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {  
                $qvalues = explode(";", $row[$qualifiername]);
                foreach ($qvalues as $val)  {           
                    $array_qvalues[] = $val;     
                }               
            }
            $array_qvalues = array_unique($array_qvalues); 
            
            foreach($array_qvalues as $val)   {
                if($val==$selqvalue)    {
                     $QValueOptions .= '<option value="'.$val.'" selected="selected">'.$val.'</option>'; 
                }
                else    {
                     $QValueOptions .= '<option value="'.$val.'">'.$val.'</option>';
                }    
            }
            
            $QValueOptions .='</select>';
            return $QValueOptions;
        }
        
        public function _PrintQualifiers()
        {    
            $selqualifierid = 0;
            $catid = $_GET['catid'];
            if(isset($_GET['selqualifierid']))    {
                $selqualifierid = $_GET['selqualifierid'];
            }
            $query = "SELECT qa.associd, qa.qualifierid, qn.column_name  
                        FROM [|PREFIX|]qualifier_associations qa
                        INNER JOIN [|PREFIX|]qualifier_names qn ON qa.qualifierid = qn.qid
                        WHERE qa.categoryid='".$catid."'
                        ORDER BY qa.associd ASC";
            
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $QualifierOptions = '<select name="qualifier" id="qualifier" class="Field400" onchange="loadQValues(this.value);">';
            $QualifierOptions .= '<option value="">--Choose a qualifier--</option>';
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                if($row['qualifierid']==$selqualifierid)    {
                     $QualifierOptions .= '<option value="'.$row['qualifierid'].'" selected="selected">'.$row['column_name'].'</option>'; 
                }
                else    {
                     $QualifierOptions .= '<option value="'.$row['qualifierid'].'">'.$row['column_name'].'</option>';
                }
            }       
            $QualifierOptions .='</select>';
            echo $QualifierOptions;
        } 
        
        public function _PrintQValues()
        {    
            $selqvalue = '';  
            $catid = $_GET['catid'];
            $qualifierid = $_GET['qualifierid'];
            
            if(isset($_GET['selqvalue']))    {
                $selqualifier = $_GET['selqvalue'];
            }
            
            if($qualifierid!=0 && $qualifierid!=null)    {
                $query = " SELECT column_name  
                            FROM [|PREFIX|]qualifier_names
                            WHERE qid='".$qualifierid."'"; 
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                     $qualifiername = $row['column_name'];
                }
            }
            
            $query = "SELECT DISTINCT `".$qualifiername."`  
                        FROM [|PREFIX|]import_variations iv
                        WHERE `".$qualifiername."`!=''";

            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $QValueOptions = '<select name="qvalue" id="qvalue" class="Field400">';
            $QValueOptions .= '<option value="">--Choose a qualifier value--</option>';
            /*while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                if($row[$qualifiername]==$selqvalue)    {
                     $QValueOptions .= '<option value="'.$row[$qualifiername].'" selected="selected">'.$row[$qualifiername].'</option>'; 
                }
                else    {
                     $QValueOptions .= '<option value="'.$row[$qualifiername].'">'.$row[$qualifiername].'</option>';
                }
            } */ 
            $array_qvalues = array();
            
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {  
                $qvalues = explode(";", $row[$qualifiername]);
                foreach ($qvalues as $val)  {
                    $array_qvalues[] = $val;
                }               
            }
            $array_qvalues = array_unique($array_qvalues); 
            
            foreach($array_qvalues as $val)   {
                if($val==$selqvalue)    {
                     $QValueOptions .= '<option value="'.$val.'" selected="selected">'.$val.'</option>'; 
                }
                else    {
                     $QValueOptions .= '<option value="'.$val.'">'.$val.'</option>';
                }    
            }
                
            $QValueOptions .='</select>';
            
            echo $QValueOptions;
            
        }    
        
        
        private function ShowCategoryRows($MsgDesc = "", $MsgStatus = "")     {
            
            if ($MsgDesc != "") {
                $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
            }

            $GLOBALS['ShopPath'] = GetConfig('ShopPath');
            $GLOBALS['CategoryGrid'] = $this->_BuildCategoryRows(0);  
            if (!empty($GLOBALS['CategoryGrid'])) {
                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("qvaluecat.manage");
                $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
            }
        } 
        
        private function _BuildCategoryRows($parentid=0)
        {
            static $categorycache, $product_counts;

            if(!is_array($categorycache)) {
                $query = "SELECT * FROM [|PREFIX|]categories ORDER BY catsort ASC, catname ASC";
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

                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("qvaluecat.manage.row");
                //$GLOBALS['CategoryGrid'] .= $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate(true);
                $categoryList .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }
            return $categoryList;
        }

        public function listQualifiers()  
        {
            //
            // Fetch any results, place them in the data grid
            $numQualifierAssociations = 0;
            $GLOBALS['QualifierAssociationsDataGrid'] = $this->ManageQualifierAssociationsGrid($numQualifierAssociations);

            // Was this an ajax based sort? Return the table now
            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                echo $GLOBALS['QualifierAssociationsDataGrid'];
                return;
            }  
            
        }
        
        public function listQValues()  
        {
            //
            // Fetch any results, place them in the data grid
            $numQValueAssociations = 0;
            $GLOBALS['QValueAssociationsDataGrid'] = $this->ManageQValueAssociationsGrid($numQValueAssociations);

            // Was this an ajax based sort? Return the table now
            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                echo $GLOBALS['QValueAssociationsDataGrid'];
                return;
            }  
            
        }
        
            
	}

?>
