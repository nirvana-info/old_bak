<?php
/******************************************
* Page Name         : class.abtesting.php
* Containing Folder : classes
* Created By        : Baskaran B
* Created On        : 23rd September, 2010
* Modified By       : Baskaran B
* Modified On       : 24th September, 2010
* Description       : Display, add, edit and delete testing page.
***************************************************************/

	class ISC_ADMIN_ABTESTING
	{
		//private $tree = null;
//		private $pagesCached = false;

		public function __construct()
		{
			$this->tree = new Tree();
		}

		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('abtesting');
			switch (isc_strtolower($Do))
			{
				case "editabtesting2":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Pages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ABPages') => "index.php?ToDo=viewABTesting");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditPageStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "editabtesting":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Pages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ABPages') => "index.php?ToDo=viewABTesting", GetLang('EditPage') => "index.php?ToDo=editPage");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditPageStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "createabtesting2":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Pages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ABPages') => "index.php?ToDo=viewABTesting");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddPageStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "createabtesting":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Pages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ABPages') => "index.php?ToDo=viewABTesting", GetLang('CreateAWebPage') => "index.php?ToDo=addPage");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddPageStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "deleteabtesting":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Pages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ABPages') => "index.php?ToDo=viewABTesting");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->DeletePages();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "editpagevisibility":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Pages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ABPages') => "index.php?ToDo=viewABTesting");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditVisibility();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						break;
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
				case "preabtesting":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Pages)) {
						$this->PreviewPage();
						break;
					} else {
						echo "<script type=\"text/javascript\">window.close();</script>";
					}
				}
                case "editactiveabtesting":
                {
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ABPages') => "index.php?ToDo=viewABTesting");

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }
                        $this->editActiveABTesting();
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
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Pages)) {

						/*if(isset($_GET['searchQuery'])) {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Pages') => "index.php?ToDo=viewABTesting", GetLang('SearchResults') => "index.php?ToDo=viewABTesting");
						}
						else {*/
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('ABPages') => "index.php?ToDo=viewABTesting");
//						}

//						$GLOBALS['InfoTip'] = GetLang('InfoTipManagePages');
                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }
                        $this->ManagePages();
                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        } 
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
			}
		}

		private function ManagePages($MsgDesc = "", $MsgStatus = "") # Baskaran
		{
			$numMake = 0; 
            $GLOBALS['TestingDataGrid'] = $this->ManageTestingGrid($numMake);
                
            // Was this an ajax based sort? Return the table now
            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                echo $GLOBALS['TestingDataGrid'];
                return;
            }

            if ($MsgDesc != "") {
                $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
            }


            // No results
            if($numMake == 0) {
                $GLOBALS['DisplayGrid'] = "none";
                $GLOBALS['DisableDelete'] = 'disabled="disabled"';
                    $GLOBALS['Message'] = MessageBox(GetLang('NoTestingPages'), MSG_SUCCESS);
            }
			$GLOBALS['PageIntro'] = GetLang('ManagePagesIntro');
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("abtesting.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}
        
        public function ManageTestingGrid(&$numMake) # Baskaran
        {
            // Show a list of news in a table
            $page = 0;
            $start = 0;
            $numMake = 0;
            $numPages = 0;
            $GLOBALS['TestingGrid'] = "";
            $GLOBALS['Nav'] = "";
            $max = 0;
            $searchURL = '';
            if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
                $sortOrder = 'desc';
            } else {
                $sortOrder = "asc";
            }

            $sortLinks = array(
                "PageTitle" => "p.pagetitle",
                "PageType" => "p.pagetype"
            );

            if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
                $sortField = $_GET['sortField'];
                SaveDefaultSortField("ManagePages", $_REQUEST['sortField'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("ManagePages", "p.pageid", $sortOrder);
            }
            if (isset($_GET['page'])) {
                $page = (int)$_GET['page'];
            }
            else {
                $page = 1;
            }

            $sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
            $GLOBALS['SortURL'] = $sortURL;

            if ($page == 1) {
                $start = 1;
            }
            else {
                $start = ($page * ISC_TESTING_PER_PAGE) - (ISC_TESTING_PER_PAGE-1);
            }

            $start = $start-1;

            // Get the results for the query
            $TestingResult = $this->_GetTestingList($start, $sortField, $sortOrder, $numMake); //, &$where
            
            $numPages = ceil($numMake / ISC_TESTING_PER_PAGE);
            // Workout the paging navigation
            if($numMake > ISC_TESTING_PER_PAGE) {
                $GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

                $GLOBALS['Nav'] .= BuildPagination($numMake, ISC_TESTING_PER_PAGE, $page, sprintf("index.php?ToDo=viewABTesting%s", $sortURL));
            }
            else {
                $GLOBALS['Nav'] = "";
            }

            $GLOBALS['SortField'] = $sortField;
            $GLOBALS['SortOrder'] = $sortOrder;

            BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewABTesting&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);


            // Workout the maximum size of the array
            $max = $start + ISC_TESTING_PER_PAGE;

            if ($max > count($TestingResult)) {
                $max = count($TestingResult);
            }
            
//            echo $numMake;exit;
            if($numMake > 0) {
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($TestingResult)) {
                    $GLOBALS['PageTitle'] = $row['pagetitle'];
                    $GLOBALS['PageId'] = (int)$row['pageid'];
                    $GLOBALS['Url'] = $GLOBALS['ShopPath']."/a-b-testing/".MakeURLSafe(strtolower($row['pagename']));
                    $type = '';
                    if($row['pagetype'] == '1') {
                        $type = "Static Page";
                    }
                    else if($row['pagetype'] == '2') {
                        $type = "Category Page";
                    }
                    else {
                        $type = "Sub Category Page";
                    }
                    $GLOBALS['PageType1'] = $type;
                    $pageid = $row['pageid'];
                     if($row['pagestatus'] == 1){
                        $GLOBALS['Status'] = "<a id='Active_".$pageid."' title='".GetLang('ClickToNotUniversal')."' href='index.php?ToDo=editactiveabtesting&amp;pid=".$pageid."&amp;active=0' onclick=\"quickToggle(this); return false;\"><img border='0' src='images/tick.gif' alt='Active'></a>";
                    }
                    else {
                        $GLOBALS['Status'] = "<a id='Active_".$pageid."' title='".GetLang('ClickToUniversal')."' href='index.php?ToDo=editactiveabtesting&amp;pid=".$pageid."&amp;active=1' onclick=\"quickToggle(this); return false;\"><img border='0' src='images/cross.gif' alt='InActive'></a>";
                    }
                    $GLOBALS['PreviewTestingLink'] = sprintf("<a title='%s' href='javascript:PreviewPage(%s)'>%s</a>", GetLang('PreviewPage'), $pageid, GetLang('Preview'));
                    $GLOBALS['EditTestingLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editabtesting&amp;pid=%d'>%s</a>", GetLang('SweepstakesEdit'), $pageid, GetLang('Edit'));

                    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("abtesting.manage.row");
                    $GLOBALS['TestingGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
                }
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("abtesting.manage.grid");
                return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }
        }
        
        public function _GetTestingList($Start, $SortField, $SortOrder, &$NumResults) # Baskaran
        {

            $query = "SELECT * FROM [|PREFIX|]abtesting_pages p";

            $countQuery = "SELECT count(*) FROM [|PREFIX|]abtesting_pages p ";
            
            $queryWhere = ' WHERE 1=1 ';
            $result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
            $NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
            if($NumResults > 0) {
                $query .= " ORDER BY ".$SortField." ".$SortOrder;

                // Add the limit
                $query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_TESTING_PER_PAGE);
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
                return $result;
                echo $query;
            }
            else {
                return false;
            }
        }

		private function _BuildPageParentList($pageid)
		{
			static $pagecache, $i;

			if(!$pagecache) {
				$query = "SELECT pageid, pageparentid FROM [|PREFIX|]pages";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$pagecache[$row['pageid']] = $row;
				}
			}

			$trail = '';

			if(isset($pagecache[$pageid])) {
				$page = $pagecache[$pageid];
				if(isset($pagecache[$page['pageparentid']])) {
					$trail = $this->_BuildPageParentList($page['pageparentid']) . $trail;
				}
				if($trail != '') {
					$trail .= ',';
				}
				$trail .= $page['pageid'];
			}
			return $trail;
		}

		private function _BuildPageList($parentid=0, $sortField='', $sortOrder='', $depth=0, $vendorId=0)
		{
			static $pagecache;

			if(!$sortField) {
				$sortField = "pagesort";
			}

			if(!is_array($pagecache) || $depth == 0) {
				$pagecache = array();
				$query = "
					SELECT p.*, v.vendorname
					FROM [|PREFIX|]pages p
					LEFT JOIN [|PREFIX|]vendors v ON (v.vendorid=p.pagevendorid)
				";
				if($vendorId == -1) {
					$query .= " WHERE pagevendorid != 0";
				}
				else {
					$query .= " WHERE pagevendorid='".(int)$vendorId."'";
				}
				$query .= " ORDER BY vendorname, ".$sortField;

				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$pagecache[$row['pageparentid']][] = $row;
				}
			}

			if(!isset($pagecache[$parentid])) {
				return '';
			}

			$pageList = '';

			foreach($pagecache[$parentid] as $p) {
				$GLOBALS['SubPages'] = $this->_BuildPageList($p['pageid'], '', '', ++$depth, $vendorId);
				if($GLOBALS['SubPages']) {
					$GLOBALS['SubPages'] = sprintf('<ul class="SortableList">%s</ul>', $GLOBALS['SubPages']);
				}

				// Output the main pages details
				$GLOBALS['PageId'] = (int) $p['pageid'];
				$GLOBALS['Title'] = isc_html_escape($p['pagetitle']);
				$GLOBALS['Type'] = GetLang("PageType" . $p['pagetype']);
				$GLOBALS['Order'] = (int) $p['pagesort'];

				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Pages)) {
					if ($p['pagestatus'] == 1) {
						$GLOBALS['Visible'] = sprintf("<a title='%s' href='index.php?ToDo=editPageVisibility&amp;pageId=%d&amp;visible=0'><img border='0' src='images/tick.gif'></a>", GetLang('ClickToHidePage'), $p['pageid']);
					} else {
						$GLOBALS['Visible'] = sprintf("<a title='%s' href='index.php?ToDo=editPageVisibility&amp;pageId=%d&amp;visible=1'><img border='0' src='images/cross.gif'></a>", GetLang('ClickToShowPage'), $p['pageid']);
					}
				} else {
					if ($p['pagestatus'] == 1) {
						$GLOBALS['Visible'] = "<img border='0' src='images/tick.gif'>";
					} else {
						$GLOBALS['Visible'] = "<img border='0' src='images/cross.gif'>";
					}
				}

				// Workout the edit link -- do they have permission to do so?
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Pages)) {
					$GLOBALS['EditPageLink'] = sprintf("<a title='%s' href='index.php?ToDo=editPage&amp;pageId=%d'>%s</a>", GetLang('PageEdit'), $p['pageid'], GetLang('Edit'));
				} else {
					$GLOBALS['EditPageLink'] = sprintf("<a disabled>%s</a>", GetLang('Edit'));
				}

				// Workout the preview link
				if ($p['pagetype'] == 0) {
					$GLOBALS['PreviewPageLink'] = sprintf("<a title='%s' href='javascript:PreviewPage(%s)'>%s</a>", GetLang('PreviewPage'), $p['pageid'], GetLang('Preview'));
				} else {
					$GLOBALS['PreviewPageLink'] = sprintf("<span title='%s' class='Disabled'>%s</span>", GetLang('CantPreviewPage'), GetLang('Preview'));
				}

				$GLOBALS['SortableClass'] = 'SortableRow';
				$GLOBALS['HideVendorColumn'] = 'display: none';
				$GLOBALS['SortableDragClass'] = 'DragMouseDown sort-handle';
				if($vendorId == -1) {
					$GLOBALS['HideVendorColumn'] = '';
					$GLOBALS['VendorName'] = $p['vendorname'];
					$GLOBALS['SortableClass'] = '';
					$GLOBALS['SortableDragClass'] = '';
				}

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("abtesting.manage.row");
				$pageList .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
			return $pageList;
		}

		private function PreviewPage()
		{
			if (isset($_GET['pageId'])) {
				$pageId = (int)$_GET['pageId'];
				$query = sprintf("select pagetitle, pagecontent,pagetype from [|PREFIX|]abtesting_pages where pageid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($pageId));
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
				if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                    if($row['pagetype'] != '2') {
					    $GLOBALS['PageTitle'] = $row['pagetitle'];
					    $GLOBALS['PageContent'] = $row['pagecontent'];

					    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("abtesting.preview");
					    $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
                    }
                    else {
                    	//2010-11-09 Ronnie add Preview has Display order
                    	//$catquery = sprintf("select description, itemtitle from [|PREFIX|]abtesting_custom_products where pageid='%d' ", $GLOBALS['ISC_CLASS_DB']->Quote($pageId));
                        $catquery = sprintf("select description, itemtitle from [|PREFIX|]abtesting_custom_products where pageid='%d' order by displayorder asc ", $GLOBALS['ISC_CLASS_DB']->Quote($pageId));
                        $catresult = $GLOBALS["ISC_CLASS_DB"]->Query($catquery);
                            while($catrow = $GLOBALS["ISC_CLASS_DB"]->Fetch($catresult)) {
                                $GLOBALS['PageTitle'] = $catrow['itemtitle'];
                                $GLOBALS['PageContent'] = $catrow['description'];

                                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("abtesting.preview");
                                $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
                            }
                        }
				} else {
					echo '<script type="text/javascript">window.close();</script>';
				}
			} else {
				echo '<script type="text/javascript">window.close();</script>';
			}
		}

		private function EditVisibility()
		{
			// Update the visibility of a page with a simple query
			$pageId = (int)$_GET['pageId'];
			$visible = (int)$_GET['visible'];

			$query = sprintf("SELECT pagetitle, pagevendorid FROM [|PREFIX|]pages WHERE pageid='%d'", $_GET['pageId']);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$page = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			// Does this user have permission to edit this page?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $arrData['pagevendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewABTesting');
			}

			$updatedPage = array(
				"pagestatus" => $visible
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("pages", $updatedPage, "pageid='".$GLOBALS['ISC_CLASS_DB']->Quote($pageId)."'");

			// Update the pages cache
			$GLOBALS['ISC_CLASS_DATA_STORE']->UpdatePages();

			if ($GLOBALS["ISC_CLASS_DB"]->Error() == "") {
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($pageId, $page['pagetitle']);

				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Pages)) {
					$this->ManagePages(GetLang('PageVisibleSuccessfully'), MSG_SUCCESS);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('PageVisibleSuccessfully'), MSG_SUCCESS);
				}
			} else {
				$err = '';
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Pages)) {
					$this->ManagePages(sprintf(GetLang('ErrPageVisibilityNotChanged'), $err), MSG_ERROR);
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrPageVisibilityNotChanged'), $err), MSG_ERROR);
				}
			}
		}

		private function DeletePages()
		{
			if (isset($_POST['page'])) {
				$pageids = implode("','", $GLOBALS['ISC_CLASS_DB']->Quote($_POST['page']));
				/*$vendorRestriction = '';
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$vendorRestriction = " AND pagevendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
				}*/
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('abtesting_pages', "WHERE pageid IN ('".$pageids."') ");
				$err = $GLOBALS["ISC_CLASS_DB"]->GetError();

				// Update the pages cache
//				$GLOBALS['ISC_CLASS_DATA_STORE']->UpdatePages();

				if ($err[0] != "") {
					FlashMessage($err[0], MSG_ERROR, 'index.php?ToDo=viewABTesting');
				} else {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['page']));

					FlashMessage(GetLang('PagesDeletedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewABTesting');
				}
			} else {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Pages)) {
					$this->ManagePages();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}

		private function AddPageStep1($MsgDesc = "", $MsgStatus = "", $IsError = false)
		{              
			$GLOBALS['Message'] = '';
			if($MsgDesc != "") {
				$GLOBALS['Message'] .= MessageBox($MsgDesc, $MsgStatus);
			}

			$GLOBALS['Message'] .= GetFlashMessageBoxes();


            if($_GET['pagetype'] == "static") {
                $GLOBALS['Title'] = GetLang('CreatePage');
                $GLOBALS['FormAction'] = "createabtesting2&pagetype=static";
                if(!isset($GLOBALS['WYSIWYG'])) {
                    $wysiwygOptions = array(
                        'id'        => 'wysiwyg',
                    );
                    $GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
                }
                $GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndAddAnother');

                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("abtesting.static.form");
                $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
            }
			else if($_GET['pagetype'] == "category")
			{
					$GLOBALS['Title'] = GetLang('CreatePage');

					$customItem = array(
						'contenttype' => 1,
						'description' => "custom products content for category#0"
					);
					$contentId = GetClass('ISC_ADMIN_ABTESTINGCUSTOMCONTENTS')->createCustomContens($customItem);

					$GLOBALS['FormAction'] = "createabtesting2&pagetype=category";
                    if(!isset($GLOBALS['WYSIWYG'])) {
                        $wysiwygOptions = array(
                            'id'        => 'wysiwyg',
                            'width'     => '60%',
                            'height'    => '350px'
                        );
                        $GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
                    }
                    if(!isset($GLOBALS['WYSIWYG1'])) {
					    $wysiwygOptions1 = array(
                            'id'        => 'wysiwyg1',
                            'width'     => '60%',
                            'height'    => '350px'
                        );
                        $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
                    }
                    if(!isset($GLOBALS['ContentOptions'])) {
					    $GLOBALS['ContentOptions'] = $this->_GetContentTypeOptions();
                    }
					
					$GLOBALS['CustomPageAction'] = 'abtestingcustom&customContentId='.$contentId.'&pid=0';
					$GLOBALS['hiddenFields'] = sprintf("<input type='hidden' name='customContentId' value='%d'>", $contentId);
					//$GLOBALS['CategoryOptions'] = $this->GetCategoryOptions($cat);
                    if(!isset($GLOBALS['CategoryOptions'])) {
					    $GLOBALS['CategoryOptions'] = "<option value='0'>-- No Parent Category --</option>";
					    $catqry = "Select categoryid, catname from [|PREFIX|]categories where catparentid = 0 order by catname ";
					    $catres = $GLOBALS['ISC_CLASS_DB']->Query($catqry);
					    while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($catres))
					    {
						    $GLOBALS['CategoryOptions'] .= "<option value='".$row['categoryid']."'>".$row['catname']."</option>";
					    }
                    }			                                                 
					$GLOBALS['CategorySelect'] = '<select name="catparentid" id="catparentid" class="Field550">';

                    $GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndAddAnother');

                    $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("abtesting.category.form");
                    $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
				
			}
            else if($_GET['pagetype'] == "subcategory") {
                $GLOBALS['Title'] = GetLang('CreatePage');
                $GLOBALS['FormAction'] = "createabtesting2&pagetype=subcategory";
                if(!isset($GLOBALS['Category'])) {
                    $GLOBALS['Category'] = $this->getCategory();
                }
                if(!isset($GLOBALS['WYSIWYG'])) {
                    $wysiwygOptions = array(
                        'id'        => 'wysiwyg',
                        'width'     => '60%',
                        'height'    => '350px'                    
                    );
                    $GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
                }
                if(!isset($GLOBALS['WYSIWYG1'])) {
                    $wysiwygOptions1 = array(
                        'id'        => 'wysiwyg1',
                        'width'     => '60%',
                        'height'    => '350px'                    
                    );
                    $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
                }
                if(!isset($GLOBALS['DisplayCategory'])) {
                    $GLOBALS['DisplayCategory'] = "display: ''";
                    $GLOBALS['DynamicCategory'] = "display: none";
                }
                else {
                    $GLOBALS['SubCategory'] = $GLOBALS['SubCategory'];
                    $GLOBALS['DisplayCategory'] = 'display: none';
                    $GLOBALS['DynamicCategory'] = "display: ''";
                }
                $GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndAddAnother');

                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("abtesting.subcategory.form");
                $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
            }
		}

		private function _GetContentTypeOptions($selectValue = 0) # added by vikas
		{
			$options = '';
			$optionArr = array('Dynamic'=>0, 'Custom'=>1);
			foreach($optionArr as $key=>$val){
				if($selectValue == $val)
					$options .= "<option value='$val' selected='selected'>$key</option>";
				else
					$options .= "<option value='$val'>$key</option>";
			}
			
			return $options;
		}

		/**
		* getPagesInfo
		* Get all the information for the pages and save them in the arrays
		* $this->pagesById to signify what each of them
		* is indexed by. All functions accessing pages should check to see
		* if one of these arrays already has values and if its empty, call this
		* function to populate it. This allows the arrays to serve as a cache
		* ensuring that the database isn't hit excessively for info on pages
		*
		* @return void
		*/
		private function getPagesInfo($vendorId=0)
		{
			if ($this->pagesCached) {
				return;
			}

			$query = "
				SELECT *
				FROM [|PREFIX|]pages
				WHERE pageid > 0
			";
			// Only fetch pages this user can see
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$query .= " AND pagevendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
			}
			else {
				$query .= " AND pagevendorid='".(int)$vendorId."'";
			}

			$query .= "ORDER BY pagesort ASC, pagetitle ASC";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$this->pagesById[$row['pageid']] = $row;
				$this->tree->nodesByPid[(int) $row['pageparentid']][] = (int) $row['pageid'];
			}

			$this->pagesCached = true;
		}

		/**
		* getPages
		* Returns an array of pages, each indented and prefixed depending
		* on it's position in the page structure. This function calls itself
		* recursively.
		*
		* @param string $stalk What to prefix a question with to signify it is
		* a descendant of its parent
		* @param int $parentid The page id to get descdendants of
		* @param string $prefix This string grows with whitespace depending on
		* the depth of the item in the tree
		*
		* @return array The formatted array of pages
		*/
		private function getPages($stalk = '`- ', $parentid=0, $prefix='', $vendorId=0)
		{
			$subs = array();
			$formatted = array();

			// If we don't have any data get it from the db
			$this->getPagesInfo($vendorId);
			if (empty($this->tree->nodesByPid)) {
				$parentid = 0;
			}

			if (!isset($this->tree->nodesByPid[$parentid])) {
				return $formatted;
			}

			// Create the formatted array
			foreach ($this->tree->nodesByPid[$parentid] as $k => $pageid) {
				$page = $this->pagesById[$pageid];
				if (!empty($prefix)) {
					$formatted[$page['pageid']] = $prefix.$stalk.$page['pagetitle'];
				} else {
					$formatted[$page['pageid']] = $prefix.$page['pagetitle'];
				}
				$subs = $this->getPages($stalk, $page['pageid'], $prefix.'&nbsp;&nbsp;&nbsp;&nbsp;');
				$formatted = $formatted + $subs;
			}
			return $formatted;
		}

		public function GetParentPageOptions($SelectedPage = 0, $DontDisplay = 0, $vendorId=0)
		{
			// Return a list of page option tags
			$sel = "";
			$output = "";

			// Get a formatted list of all of the pages in the system
			$pages = $this->getPages("- ", 0, '', $vendorId);

			foreach($pages as $pageid => $pagetitle) {
				if($pageid == $SelectedPage) {
					$sel = 'selected="selected"';
				}
				else {
					$sel = '';
				}

				if($pageid != $DontDisplay) {
					$output .= sprintf("<option %s value='%d'>%s</option>", $sel, $pageid, $pagetitle);
				}
			}

			return $output;
		}

		private function AddPageStep2()   # Baskaran
		{
			$err = "";
			$arrData = array();
            if($_GET['pagetype'] == "static") { # Static Page
                $arrData['pageid'] = 0;
                $arrData['pagetitle'] = $_POST['pagetitle'];
                $arrData['pagename'] = $_POST['pagename'];
                $arrData['pagecontent'] = $_POST["wysiwyg"];
                $arrData['pagecontrolscript'] = $_POST['controlscript']; 
                $arrData['pagetrackingscript'] = $_POST['trackingscript']; 
                $arrData['pagetype'] = 1;
			    if(!$this->_IsDuplicateName($arrData['pagename'], 0)){
				    // Commit the values to the database
				    if (($pageId = $this->_CommitPage(0, $arrData, $err))) {

					    // Log this action
					    $GLOBALS['ISC_CLASS_LOG']->LogAdminAction($pageId, $arrData['pagetitle']);

					    if(isset($_POST['addAnother'])) {
                            $_REQUEST['pagetype'] = "static";
                            $this->AddPageStep1(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS);
					    }
					    else {
                            $this->ManagePages(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS);
					    }
				    }
				    else {
                        if(isset($_POST['addAnother'])) {
                            $_REQUEST['pagetype'] = "static";
                            $this->AddPageStep1(GetLang('ErrPageNotAdded'), MSG_ERROR);
                        }
                        else {
                            $this->ManagePages(GetLang('ErrPageNotAdded'), MSG_ERROR);
                        }
				    }
			    }
			    else {
                    $GLOBALS['PageTitle'] = $_REQUEST['pagetitle'];
                    $GLOBALS['PageName'] = $_REQUEST['pagename'];
                    $GLOBALS['controlscript'] = $_REQUEST['controlscript'];
                    $GLOBALS['trackingscript'] = $_REQUEST['trackingscript'];
                    $wysiwygOptions = array(
                        'id'        => 'wysiwyg',
                        'value'     => $_POST["wysiwyg"]
                    );
                    $GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
				    $this->AddPageStep1(GetLang('DuplicatePageTitle'), MSG_ERROR, true);
			    }
            }
			else if($_GET['pagetype'] == "category")  # Category Page
			{	
				$arrData['pageid'] = 0;
                $arrData['pagetitle'] = $_POST['pagetitle'];
                $arrData['pagename'] = $_POST['pagename'];
                $arrData['pagecontent'] = $_POST["catpagecontent"];
				$arrData['pageheaderdesc'] = $_POST["wysiwyg"];
				$arrData['pagefooterdesc'] = $_POST["wysiwyg1"];
				$arrData['pagecategoryid'] = $_POST["catparentid"];
                $arrData['pagecontrolscript'] = $_POST['controlscript']; 
                $arrData['pagetrackingscript'] = $_POST['trackingscript']; 
                $arrData['pagetype'] = 2;
			    if(!$this->_IsDuplicateName($arrData['pagename'], 0)) {
				    // Commit the values to the database
				    if (($pageId = $this->_CommitPage(0, $arrData, $err))) {

					    // Log this action
					    $GLOBALS['ISC_CLASS_LOG']->LogAdminAction($pageId, $arrData['pagetitle']);

					    if(isset($_POST['AddAnother'])) {
						    $_REQUEST['pagetype'] = "category";
                            $this->AddPageStep1(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS);
					    }
					    else {
						    $this->ManagePages(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS);
					    }
				    }
				    else {
					    if(isset($_POST['AddAnother'])) {
						    $_REQUEST['pagetype'] = "category";
                            $this->AddPageStep1(GetLang('ErrPageNotAdded'), MSG_ERROR);
					    }
					    else {
						    $this->ManagePages(GetLang('ErrPageNotAdded'), MSG_ERROR);
					    }
				    }
			    }
			    else {
                    $GLOBALS['PageTitle'] = $_REQUEST['pagetitle'];
                    $GLOBALS['PageName'] = $_REQUEST['pagename'];
                    $GLOBALS['ControlScript'] = $_REQUEST['controlscript'];
                    $GLOBALS['TrackingScript'] = $_REQUEST['trackingscript'];

                    $wysiwygOptions = array(
                        'id'        => 'wysiwyg',
                        'width'     => '60%',
                        'height'    => '350px',
                        'value'        => $_POST["wysiwyg"]
                    );
                    $GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
                    $wysiwygOptions1 = array(
                        'id'        => 'wysiwyg1',
                        'width'     => '60%',
                        'height'    => '350px',
                        'value'        => $_POST["wysiwyg1"]
                    );
                    $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
                    $GLOBALS['CategoryOptions'] = "<option value='0'>-- Select Category --</option>";
                    $catqry = "Select categoryid, catname from [|PREFIX|]categories where catparentid = 0 order by catname ";
                    $catres = $GLOBALS['ISC_CLASS_DB']->Query($catqry);
                    while($arr = $GLOBALS['ISC_CLASS_DB']->Fetch($catres))
                    {
                        if( $arr['categoryid'] == $_POST['catparentid'])
                        {
                            $GLOBALS['CategoryOptions'] .= "<option value='".$arr['categoryid']."' selected='selected'>".$arr['catname']."</option>";
                        }
                        else
                        {
                            $GLOBALS['CategoryOptions'] .= "<option value='".$arr['categoryid']."'>".$arr['catname']."</option>";
                        }
                    }   
                    $GLOBALS['ContentOptions'] = $this->_GetContentTypeOptions($_POST["catpagecontent"]);
				    $this->AddPageStep1(GetLang('DuplicatePageTitle'), MSG_ERROR, true);
			    }
			}
            else if($_GET['pagetype'] == "subcategory") { # Sub category Page
                $arrData['pageid'] = 0;
                $arrData['pagetitle'] = $_POST['pagetitle'];
                $arrData['pagename'] = $_POST['pagename'];
                $arrData['pagecategoryid'] = $_POST['productsubcat'];
                $arrData['pageheaderdesc'] = $_POST["wysiwyg"];
                $arrData['pagefooterdesc'] = $_POST["wysiwyg1"];
                $arrData['pagecontrolscript'] = isc_html_escape($_POST['controlscript']); 
                $arrData['pagetrackingscript'] = isc_html_escape($_POST['trackingscript']); 
                $arrData['pagetype'] = 3;
                if(!$this->_IsDuplicateName($arrData['pagename'], $pageId)) {
                    // Commit the values to the database
                    if (($pageId = $this->_CommitPage(0, $arrData, $err))) {

                        // Log this action
                        $GLOBALS['ISC_CLASS_LOG']->LogAdminAction($pageId, $arrData['pagetitle']);

                        if(isset($_POST['addAnother'])) {
                            $_REQUEST['pagetype'] = "subcategory";
                            $this->AddPageStep1(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS);
                        }
                        else {
                            $this->ManagePages(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS);
                        }
                    }
                    else {
                        if(isset($_POST['addAnother'])) {
                            $_REQUEST['pagetype'] = "subcategory";
                            $this->AddPageStep1(GetLang('ErrPageNotAdded'), MSG_ERROR);
                        }
                        else {
                            $this->ManagePages(GetLang('ErrPageNotAdded'), MSG_ERROR);
                        }
                    }
                }
                else {
                    $GLOBALS['Category'] = $this->getCategory($_REQUEST['category']);
                    $GLOBALS['SubCategory'] = $this->getSubcategory($_REQUEST['category'],$_REQUEST['productsubcat']);
                    $GLOBALS['DisplayCategory'] = 'display: none';
                    $GLOBALS['DynamicCategory'] = "display: ''";
                    $GLOBALS['PageTitle'] = $_REQUEST['pagetitle'];
                    $GLOBALS['PageName'] = $_REQUEST['pagename'];
                    $GLOBALS['controlscript'] = $_REQUEST['controlscript'];
                    $GLOBALS['trackingscript'] = $_REQUEST['trackingscript'];

                    $wysiwygOptions = array(
                        'id'        => 'wysiwyg',
                        'width'     => '60%',
                        'height'    => '350px',
                        'value'        => $_POST["wysiwyg"]
                    );
                    $GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
                    $wysiwygOptions1 = array(
                        'id'        => 'wysiwyg1',
                        'width'     => '60%',
                        'height'    => '350px',
                        'value'        => $_POST["wysiwyg1"]
                    );
                    $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);
                    $this->AddPageStep1(GetLang('DuplicatePageTitle'), MSG_ERROR, true);
                }
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

		private function _GetPageData($PageId, &$RefArray)
		{
			if ($PageId == 0 && count($_POST) > 0) {
				$RefArray['pageid'] = 0;
				$RefArray['pagetitle'] = $_POST['pagetitle'];
				$RefArray['pagename'] = $_POST['pagename']; //blessen
				$RefArray['controlscript'] = $_POST['controlscript']; //blessen
				$RefArray['trackingscript'] = $_POST['trackingscript']; //blessen
				$RefArray['pagelink'] = $_POST['pagelink'];
				$RefArray['pagefeed'] = $_POST['pagefeed'];
				$RefArray['pageemail'] = $_POST['pageemail'];
				$RefArray['pagecontactfields'] = "";

				if(isset($_POST['contactfields'])) {
					$RefArray['pagecontactfields'] = implode(",", $_POST['contactfields']);
				}

				if(isset($_POST["wysiwyg_html"])) {
					$RefArray['pagecontent'] = @$_POST["wysiwyg_html"];
				}
				else {
					$RefArray['pagecontent'] = @$_POST['wysiwyg'];
				}

				if (isset($_POST['pagestatus'])) {
					$RefArray['pagestatus'] = 1;
				} else {
					$RefArray['pagestatus'] = 0;
				}

				if(isset($_POST['pageishomepage'])) {
					$RefArray['pageishomepage'] = 1;
				}
				else {
					$RefArray['pageishomepage'] = 0;
				}

				$RefArray['pageparentid'] = $_POST['pageparentid'];
				$RefArray['pagesort'] = (int)$_POST['pagesort'];
				$RefArray['pagelayoutfile'] = $_POST['pagelayoutfile'];
				$RefArray['pagekeywords'] = $_POST['pagekeywords'];
				$RefArray['pagedesc'] = $_POST['pagedesc'];
				$RefArray['pagetype'] = $_POST['pagetype'];

				if (isset($_POST['pagecustomersonly'])) {
					$RefArray['pagecustomersonly'] = 1;
				} else {
					$RefArray['pagecustomersonly'] = 0;
				}

				$RefArray['pagevendorid'] = 0;
				if(gzte11(ISC_HUGEPRINT)) {
					$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
					// User is assigned to a vendor so any pages they create must be too
					if(isset($vendorData['vendorid'])) {
						$RefArray['pagevendorid'] = $vendorData['vendorid'];
					}
					else if(isset($_POST['vendor'])) {
						$RefArray['pagevendorid'] = (int)$_POST['vendor'];
					}
				}
			} else {
				// Get the data for this news post from the database
				$query = sprintf("select * from [|PREFIX|]pages where pageid='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($PageId));
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
					$RefArray = $row;
				}
			}
		}

		private function _CommitPage($PageId, &$Data, &$err) # Baskaran
		{
			// Commit the details for the page to the database
			$query = "";
			$err = null;
			if ($PageId == 0) {
				$newPage = array(
                    "pagetype" => (int)$Data['pagetype'],
					"pagetitle" => $Data['pagetitle'],
					"pagename" => $Data['pagename'],
                    "pagecontent" => isset($Data['pagecontent']) ? $Data['pagecontent'] : '',
					"pageheaderdesc" => isset($Data['pageheaderdesc']) ? $Data['pageheaderdesc'] : '',
					"pagefooterdesc" => isset($Data['pagefooterdesc']) ? $Data['pagefooterdesc'] : '',
					"pagecategoryid" => isset($Data['pagecategoryid']) ? $Data['pagecategoryid'] : 0,
                    "pagecontrolscript" => $Data['pagecontrolscript'],
                    "pagetrackingscript" => $Data['pagetrackingscript'],
                    "pagestatus" => isset($Data['pagestatus']) ? $Data['pagestatus'] : 0
				);
				$PageId = $GLOBALS['ISC_CLASS_DB']->InsertQuery("abtesting_pages", $newPage);

				$err = $GLOBALS["ISC_CLASS_DB"]->GetError();

			} else {
				$query = "";

				// Update the existing pages details
				$updatedPage = array(
                    "pagetitle" => $Data['pagetitle'],
                    "pagename" => $Data['pagename'],
                    "pagecontent" => isset($Data['pagecontent']) ? $Data['pagecontent'] : '',
                    "pageheaderdesc" => isset($Data['pageheaderdesc']) ? $Data['pageheaderdesc'] : '',
                    "pagefooterdesc" => isset($Data['pagefooterdesc']) ? $Data['pagefooterdesc'] : '',
                    "pagecategoryid" => isset($Data['pagecategoryid']) ? $Data['pagecategoryid'] : 0,
                    "pagecontrolscript" => $Data['pagecontrolscript'],
                    "pagetrackingscript" => $Data['pagetrackingscript']
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("abtesting_pages", $updatedPage, "pageid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$PageId)."'");
				$err = $GLOBALS["ISC_CLASS_DB"]->GetError();
			}

			if($err[0] != "") {
				return false;
			}
			return true;
		}

		private function EditPageStep1($MsgDesc = "", $MsgStatus = "", $IsError = false) # Baskaran
		{
			$GLOBALS['Message'] = '';
			if($MsgDesc != "") {
				$GLOBALS['Message'] .= MessageBox($MsgDesc, $MsgStatus);
			}

			$GLOBALS['Message'] .= GetFlashMessageBoxes();

			$pageId = (int)$_REQUEST['pid'];
			if($this->PageExists($pageId)) {
                $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT ap.* , cp.contentid FROM [|PREFIX|]abtesting_pages ap left join [|PREFIX|]abtesting_custom_products cp on ap.pageid = cp.pageid WHERE ap.pageid = $pageId");
                $row = $GLOBALS['ISC_CLASS_DB']->Fetch($query);
				
				if($row['pagetype'] == 1) # Static
				{
					$GLOBALS['PageId'] = (int) $pageId;
					$GLOBALS['Title'] = GetLang('EditPage');
					$GLOBALS['FormAction'] = "editabtesting2&pagetype=static";
					$GLOBALS['PageTitle'] = isc_html_escape($row['pagetitle']);
					$GLOBALS['PageName'] = isc_html_escape($row['pagename']);
					$GLOBALS['controlscript'] = isc_html_escape($row['pagecontrolscript']);
					$GLOBALS['trackingscript'] = isc_html_escape($row['pagetrackingscript']);

					$wysiwygOptions = array(
						'id'		=> 'wysiwyg',
						'value'		=> $row['pagecontent']
					);
					$GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);


					$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndContinueEditing');

					$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("abtesting.static.form");
					$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
				}
				else if($row['pagetype'] == 2) # Category
				{
					if($row['contentid'] != 0)
					{
						$contentId = isc_html_escape($row['contentid']);
					}
					else
					{
						$customItem = array(
							'contenttype' => 1,
							'description' => "custom products content for category#".$row['pagecategoryid']
						);
						$contentId = GetClass('ISC_ADMIN_ABTESTINGCUSTOMCONTENTS')->createCustomContens($customItem);
					}
					setcookie("ABTestingCustomContentId", $contentId, time()+3600);

					$GLOBALS['PageId'] = (int) $pageId;
					$GLOBALS['Title'] = GetLang('EditPage');
					$GLOBALS['FormAction'] = "editabtesting2&pagetype=category";
					$GLOBALS['PageTitle'] = isc_html_escape($row['pagetitle']);
					$GLOBALS['PageName'] = isc_html_escape($row['pagename']);
					$GLOBALS['ControlScript'] = isc_html_escape($row['pagecontrolscript']);
					$GLOBALS['TrackingScript'] = isc_html_escape($row['pagetrackingscript']);

					$wysiwygOptions = array(
						'id'		=> 'wysiwyg',
                        'width'     => '60%',
                        'height'    => '350px',
						'value'		=> $row['pageheaderdesc']
					);
					$GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
					$wysiwygOptions1 = array(
                        'id'        => 'wysiwyg1',
                        'width'     => '60%',
                        'height'    => '350px',
						'value'		=> $row['pagefooterdesc']
                    );
                    $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);

					$GLOBALS['ContentOptions'] = $this->_GetContentTypeOptions($row['pagecontent']);

					$GLOBALS['customContentId'] = $contentId;

					$GLOBALS['CustomPageAction'] = 'abtestingcustom&customContentId='.$contentId."&catId=".$row['pagecategoryid']."&pid=".$pageId;

					$GLOBALS['CategoryOptions'] = "<option value='0'>-- Select Category --</option>";
					$catqry = "Select categoryid, catname from [|PREFIX|]categories where catparentid = 0 order by catname ";
					$catres = $GLOBALS['ISC_CLASS_DB']->Query($catqry);
					while($arr = $GLOBALS['ISC_CLASS_DB']->Fetch($catres))
					{
						if( $arr['categoryid'] == $row['pagecategoryid'])
						{
							$GLOBALS['CategoryOptions'] .= "<option value='".$arr['categoryid']."' selected='selected'>".$arr['catname']."</option>";
						}
						else
						{
							$GLOBALS['CategoryOptions'] .= "<option value='".$arr['categoryid']."'>".$arr['catname']."</option>";
						}
					}
			
					$GLOBALS['CategorySelect'] = '<select name="catparentid" id="catparentid" class="Field550">';


					$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndContinueEditing');

					$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("abtesting.category.form");
					$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
				}
                if($row['pagetype'] == 3) # Sub category
                {
                    $GLOBALS['PageId'] = (int) $pageId;
                    $GLOBALS['Title'] = GetLang('EditPage');
                    $GLOBALS['FormAction'] = "editabtesting2&pagetype=subcategory";
                    $catid = $row['pagecategoryid'];
                    $catquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT catparentid FROM [|PREFIX|]categories WHERE categoryid = '$catid'");
                    $catrow = $GLOBALS['ISC_CLASS_DB']->Fetch($catquery);
                    $GLOBALS['Category'] = $this->getCategory($catrow['catparentid']);
                    $GLOBALS['SubCategory'] = $this->getSubcategory($catrow['catparentid'],$catid);
                    $GLOBALS['DisplayCategory'] = 'display: none';
                    $GLOBALS['DynamicCategory'] = "display: ''";
                    $GLOBALS['PageTitle'] = isc_html_escape($row['pagetitle']);
                    $GLOBALS['PageName'] = isc_html_escape($row['pagename']);
                    $GLOBALS['controlscript'] = isc_html_escape($row['pagecontrolscript']);
                    $GLOBALS['trackingscript'] = isc_html_escape($row['pagetrackingscript']);

                    $wysiwygOptions = array(
                        'id'        => 'wysiwyg',
                        'width'     => '60%',
                        'height'    => '350px',
                        'value'        => $row['pageheaderdesc']
                    );
                    $GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
                    $wysiwygOptions1 = array(
                        'id'        => 'wysiwyg1',
                        'width'     => '60%',
                        'height'    => '350px',
                        'value'        => $row['pagefooterdesc']
                    );
                    $GLOBALS['WYSIWYG1'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor1($wysiwygOptions1);


                    $GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndContinueEditing');

                    $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("abtesting.subcategory.form");
                    $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
                }
			}
			else {
				// The news page doesn't exist
				FlashMessage(GetLang('PageDoesntExist'), MSG_ERROR, 'index.php?ToDo=viewABTesting');
			}
		}

		private function EditPageStep2() # Baskaran
		{
			// Get the information from the form and add it to the database
			$pageId = (int)$_POST['pageId'];
			$arrData = array();
			$err = "";

			if($_GET['pagetype'] == 'static')
			{
				$arrData['pageid'] = $pageId;
				$arrData['pagetitle'] = $_POST['pagetitle'];
				$arrData['pagename'] = $_POST['pagename'];
				$arrData['pagecontent'] = $_POST["wysiwyg"];
				$arrData['pagecontrolscript'] = $_POST['controlscript']; 
				$arrData['pagetrackingscript'] = $_POST['trackingscript']; 
				if(!$this->_IsDuplicateName($arrData['pagename'], $pageId)) {
					// Commit the values to the database
					if ($this->_CommitPage($pageId, $arrData, $err)) {

						// Log this action
						$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($pageId, $arrData['pagetitle']);

						if(isset($_POST['addAnother'])) {
                            $_REQUEST['pid'] = $pageId;
                            $this->EditPageStep1(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS);
                            exit;						
                        }
						else {
							$this->ManagePages(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS);
						}
					} else {
						if(isset($_POST['addAnother']) || isset($_POST['addAnother2'])) {
							$_REQUEST['pid'] = $pageId;
                            $this->EditPageStep1(GetLang('ErrPageNotUpdated'), MSG_ERROR);
                            exit;
						}
						else {
							$this->ManagePages(GetLang('ErrPageNotUpdated'), MSG_ERROR);
						}
					}
				}
				else {
					$this->EditPageStep1(GetLang('DuplicatePageTitle'), MSG_ERROR, true);
				}
			}
			else if($_GET['pagetype'] == 'category')
			{
				$arrData['pageid'] = $pageId;
				$arrData['pagetitle'] = $_POST['pagetitle'];
                $arrData['pagename'] = $_POST['pagename'];
                $arrData['pagecontent'] = $_POST["catpagecontent"];
				$arrData['pageheaderdesc'] = $_POST["wysiwyg"];
				$arrData['pagefooterdesc'] = $_POST["wysiwyg1"];
				$arrData['pagecategoryid'] = $_POST["catparentid"];
                $arrData['pagecontrolscript'] = $_POST['controlscript']; 
                $arrData['pagetrackingscript'] = $_POST['trackingscript'];
				if(!$this->_IsDuplicateName($arrData['pagename'], $pageId)) {
					// Commit the values to the database
					if ($this->_CommitPage($pageId, $arrData, $err)) {

						// Log this action
						$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($pageId, $arrData['pagetitle']);

						if(isset($_POST['AddAnother'])) {
                            $_REQUEST['pid'] = $pageId;
							$this->EditPageStep1(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS);
                            exit;
						}
						else {
							$this->ManagePages(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS);
						}
					} else {
						if(isset($_POST['AddAnother'])) {
                            $_REQUEST['pid'] = $pageId;
							$this->EditPageStep1(GetLang('ErrPageNotUpdated'), MSG_ERROR);
                            exit;
						}
						else {
							$this->ManagePages(GetLang('ErrPageNotUpdated'), MSG_ERROR);
						}
					}
				}
				else {
					$this->EditPageStep1(GetLang('DuplicatePageTitle'), MSG_ERROR, true);
				}
			}
            if($_GET['pagetype'] == 'subcategory') {
                $arrData['pageid'] = $pageId;
                $arrData['pagetitle'] = $_POST['pagetitle'];
                $arrData['pagename'] = $_POST['pagename'];
                $arrData['pagecategoryid'] = $_POST['productsubcat'];
                $arrData['pageheaderdesc'] = $_POST["wysiwyg"];
                $arrData['pagefooterdesc'] = $_POST["wysiwyg1"];
                $arrData['pagecontrolscript'] = isc_html_escape($_POST['controlscript']); 
                $arrData['pagetrackingscript'] = isc_html_escape($_POST['trackingscript']); 
                if(!$this->_IsDuplicateName($arrData['pagename'], $pageId)) {
                    // Commit the values to the database
                    if ($this->_CommitPage($pageId, $arrData, $err)) {

                        // Log this action
                        $GLOBALS['ISC_CLASS_LOG']->LogAdminAction($pageId, $arrData['pagetitle']);

                        if(isset($_POST['addAnother'])) {
                            $_REQUEST['pid'] = $pageId;
                            $this->EditPageStep1(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS);
                            exit;
                        }
                        else {
                            $this->ManagePages(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS);
                        }
                    } else {
                        if(isset($_POST['addAnother'])) {
                            $_REQUEST['pid'] = $pageId;
                            $this->EditPageStep1(GetLang('ErrPageNotUpdated'), MSG_ERROR);
                            exit;
                        }
                        else {
                            $this->ManagePages(GetLang('ErrPageNotUpdated'),MSG_ERROR);
                        }
                    }
                }
                else {
                    $this->EditPageStep1(GetLang('DuplicatePageTitle'), MSG_ERROR, true);
                }
            }
		}

		/**
		 * Check if a page title is already in use elsewhere.
		 *
		 * @param string The title of the page.
		 * @param int The ID of the current page being edited (if any) as to not match that.
		 * @param int The ID of the vendor that this page belongs to.
		 * @return boolean True if the page title is already in use, false if not.
		 */
		private function _IsDuplicateTitle($title, $existingId=0) # Baskaran
		{
			$query = "
				SELECT pageid
				FROM [|PREFIX|]abtesting_pages
				WHERE LOWER(pagetitle)='".$GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($title))."'
			";
			if($existingId > 0) {
				$query .= " AND pageid != '".(int)$existingId."'";
			}
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 1);

			if($GLOBALS['ISC_CLASS_DB']->FetchOne($query)) {
				return true;
			}
			else {
				return false;
			}
		}

		private function _IsDuplicateName($title, $existingId=0) # Baskaran
		{
			if ($title == "")  return false;

			$query = "
				SELECT pageid
				FROM [|PREFIX|]abtesting_pages
				WHERE LOWER(pagename)='".$GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($title))."'
			";
			if($existingId > 0) {
				$query .= " AND pageid != '".(int)$existingId."'";
			}
			
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 1);

			if($GLOBALS['ISC_CLASS_DB']->FetchOne($query)) {
				return true;
			}
			else {
				return false;
			}
		}
        
        private function editActiveABTesting() {  # Baskaran
            $pid = (int)$_GET['pid'];
            $active = (int)$_GET['active'];
            
            $queryPart = "pageid='".$GLOBALS['ISC_CLASS_DB']->Quote($pid)."'";
            $successMsg = sprintf(GetLang('VisibleSuccessfully1'), '');       
            
           /* $updatedinactive = array(
                "active" => "0"
            ); 
            $GLOBALS['ISC_CLASS_DB']->UpdateQuery("abtesting_pages", $updatedinactive); */
            
            $updatedactive = array(
                "pagestatus" => $active
            ); 
            $GLOBALS['ISC_CLASS_DB']->UpdateQuery("abtesting_pages", $updatedactive, $queryPart);

            unset($_REQUEST['active']);
            unset($_GET['active']);

            if ($GLOBALS["ISC_CLASS_DB"]->Error() == "") {
                if(isset($_REQUEST['ajax'])) {
                    //generate the javascript to update the visibility icon through ajax
                    $callBackJs = "";
                        $elementID = 'Active_'.$pid;
                        $callBackJs .= 'ToggleActiveIcon("'.$elementID.'", "active", '.$active.');';

                    header('Content-type: text/javascript');
                    echo $callBackJs;
                    echo "var status = 1; var message='".$successMsg."'";          
                    exit;
                }
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
                    $this->ManagePages('VisibleSuccessfully2', MSG_SUCCESS);
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('VisibleSuccessfully3'), MSG_SUCCESS);
                }                                
            } else { 
                if(isset($_REQUEST['ajax'])) {
                    header('Content-type: text/javascript');
                    echo "var status = 0;";
                    exit;
                }

                $err = ''; 
                if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Products)) {
                    $this->ManagePages(sprintf(ErrPageNotChanged, $err), MSG_ERROR);
                } else {
                    $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrPageNotChanged'), $err), MSG_ERROR);
                }
            }            
        }
        
        private function getCategory($catid = 0) { # Baskaran
            $options = '<option value="0">'.GetLang('SelectCategory').'</option>';
            $query = "SELECT categoryid,catname FROM [|PREFIX|]categories WHERE catparentid = '0' ORDER BY catname ASC";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $sel = '';
                if($catid == $row['categoryid']) {
                    $sel = 'selected="selected"';
                }
                $options .= '<option value='.(int)$row['categoryid'].' '.$sel.'>'.isc_html_escape($row['catname']).'</option>';
            }
            return $options;
        }
        
        private function getSubcategory($catid = 0, $subcatid = 0) {
            $query = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT catname,categoryid FROM [|PREFIX|]categories WHERE catparentid = $catid ORDER BY catname");
            $option = '<select name="productsubcat" id="productsubcat">';
            $option .= ' <option value="0">Select Subcategory</option>';
            while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($query)) {
                $sel = '';
                if($subcatid == $row['categoryid']) {
                    $sel = 'selected="selected"';
                }                  
                $option .= '<option value='.(int)$row['categoryid'].' '.$sel.'>'.isc_html_escape($row['catname']).'</option>';
            }
            $option.='</select>';
            return $option;
        }
        
		/**
		* GetContactPagesAsOptions
		* Return a list of <option> tags containing the id and names of all pages
		* that are of type "contact page"
		*
		* @param $SelectedPages Array An ID of page id's whose option tags should be selected
		* @return String
		*/
		public function GetContactPagesAsOptions($SelectedPages=null)
		{
			$query = "select pageid, pagetitle from [|PREFIX|]pages where pagetype='3' order by pagetitle asc";
			$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
			$output = "";

			while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
				if(is_array($SelectedPages) && in_array($row['pageid'], $SelectedPages)) {
					$sel = 'selected="selected"';
				}
				else {
					$sel = "";
				}

				$output .= sprintf("<option %s value='%d'>%s</option>", $sel, $row['pageid'], $row['pagetitle']);
			}

			return $output;
		}

		/**
		 * Build a list of vendors that can be chosen for a product.
		 *
		 * @param int The vendor ID to select, if any.
		 * @return string The HTML options for the select box of vendors.
		 */
		public function BuildVendorSelect($selectedVendor=0)
		{
			$options = '<option value="0">'.GetLang('NoVendor').'</option>';
			$query = "
				SELECT vendorid, vendorname
				FROM [|PREFIX|]vendors
				ORDER BY vendorname ASC
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($vendor = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$sel = '';
				if($selectedVendor == $vendor['vendorid']) {
					$sel = 'selected="selected"';
				}
				$options .= '<option value='.(int)$vendor['vendorid'].' '.$sel.'>'.isc_html_escape($vendor['vendorname']).'</option>';
			}
			return $options;
		}

		/**
		 * Gets a 1-dimensional array of pages available to the site or vendor. Structure is indicated by the 'depth' element
		 *
		 * @param int The parent page id to get pages from
		 * @param String The field to sort the pages on
		 * @param String The order in which to use the sort field. ASC or DESC
		 *
		 * @return Array Array of pages
		 */
		public function _getPagesArray($parentid = 0, $sortField = 'pagesort', $sortOrder = 'ASC', &$pages = array(), $depth = 0)
		{
			//construct sql
			$query = "
				SELECT
					p.pageid,
					p.pagetitle,
					p.pagelink,
					p.pagevendorid,
					p.pagetype,
					p.pagesort,
					p.pageparentid,
					v.vendorname
				FROM
					[|PREFIX|]pages p
					LEFT JOIN [|PREFIX|]vendors v ON (v.vendorid = p.pagevendorid)
				WHERE
					pageparentid = '" . $parentid . "'
				";


			// Only fetch pages which belong to the current vendor
			$vendorid = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
			if ($vendorid) {
				$query .= " AND pagevendorid = '" . $vendorid . "'";
			}

			$query .= " ORDER BY vendorname, " . $sortField . " " . $sortOrder;

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				//$pages[$parentid]][] = $row;
				$row['depth'] = $depth;
				$pages[] = $row;

				$this->_getPagesArray($row['pageid'], $sortField, $sortOrder, $pages, $depth + 1);
			}

			if ($depth == 0) {
				return $pages;
			}
		}

		function PageExists($PageId) # added by vikas
		{
			// Check if a record is found for a page and return true/false
			$query = sprintf("select pageid from [|PREFIX|]abtesting_pages where pageid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($PageId));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				return true;
			} else {
				return false;
			}
		}
	}

?>