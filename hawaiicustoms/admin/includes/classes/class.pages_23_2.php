<?php

	class ISC_ADMIN_PAGES
	{
		private $tree = null;
		private $pagesCached = false;

		public function __construct()
		{
			$this->tree = new Tree();
		}

		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('pages');
			switch (isc_strtolower($Do))
			{
				case "editpage2":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Pages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Pages') => "index.php?ToDo=viewPages");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditPageStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "editpage":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Pages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Pages') => "index.php?ToDo=viewPages", GetLang('EditPage') => "index.php?ToDo=editPage");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditPageStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "createpage2":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Pages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Pages') => "index.php?ToDo=viewPages");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddPageStep2();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "createpage":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Add_Pages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Pages') => "index.php?ToDo=viewPages", GetLang('CreateAWebPage') => "index.php?ToDo=addPage");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->AddPageStep1();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						die();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}

					break;
				}
				case "deletepages":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Pages)) {

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Pages') => "index.php?ToDo=viewPages");

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

						$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Pages') => "index.php?ToDo=viewPages");

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->EditVisibility();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
						break;
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
				case "previewpage":
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Pages)) {
						$this->PreviewPage();
						break;
					} else {
						echo "<script type=\"text/javascript\">window.close();</script>";
					}
				}
				default:
				{
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Pages)) {

						if(isset($_GET['searchQuery'])) {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Pages') => "index.php?ToDo=viewPages", GetLang('SearchResults') => "index.php?ToDo=viewPages");
						}
						else {
							$GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Pages') => "index.php?ToDo=viewPages");
						}

						$GLOBALS['InfoTip'] = GetLang('InfoTipManagePages');

						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
						$this->ManagePages();
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
				}
			}
		}

		private function ManagePages($MsgDesc = "", $MsgStatus = "")
		{
			// Show a list of pages in a table
			$GLOBALS['PageGrid'] = "";
			$GLOBALS['Nav'] = "";
			$numSubPages = 0;
			$searchURL = '';

			if (isset($_GET['searchQuery'])) {
				$query = $_GET['searchQuery'];
				$GLOBALS['Query'] = $query;
				$searchURL .= '&amp;searchQuery='.urlencode($query);
			} else {
				$query = "";
				$GLOBALS['Query'] = "";
			}

			if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
				$sortOrder = 'desc';
			} else {
				$sortOrder = "";
			}

			$sortLinks = array(
				"Title" => "p.pagetitle",
				"Type" => "p.pagetype",
				"Visible" => "p.pagestatus"
			);

			if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
				$sortField = $_GET['sortField'];
				SaveDefaultSortField("ManagePages", $_REQUEST['sortField'], $sortOrder);
			}
			else {
				$sortField = "n.newsdate";
				list($sortField, $sortOrder) = GetDefaultSortField("ManagePages", "p.pagesort asc, p.pagetitle asc", "");
			}

			if (isset($_GET['page'])) {
				$page = (int)$_GET['page'];
			} else {
				$page = 1;
			}

			$sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
			$GLOBALS['SortURL'] = $sortURL;

			// Get the results for the query
			$GLOBALS['Message'] = '';
			if($MsgDesc != "") {
				$GLOBALS['Message'] .= MessageBox($MsgDesc, $MsgStatus);
			}

			$GLOBALS['Message'] .= GetFlashMessageBoxes();

			$GLOBALS['SearchQuery'] = $query;
			$GLOBALS['SortField'] = $sortField;
			$GLOBALS['SortOrder'] = $sortOrder;

			BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewPages&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				$vendorId = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
			}
			else {
				$vendorId = 0;
			}
			$GLOBALS['PageGrid'] = $this->_BuildPageList(0, $sortField, $sortOrder, 0, $vendorId);

			$GLOBALS['VendorPagesGrid'] = '';
			$GLOBALS['HideTabs'] = 'display: none';
			if(gzte11(ISC_HUGEPRINT) && $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() == 0) {
				// Get all pages that belong to vendors
				$GLOBALS['VendorPagesGrid'] = $this->_BuildPageList(0, $sortField, $sortOrder, 0, -1);
				if($GLOBALS['VendorPagesGrid']) {
					$GLOBALS['HideTabs'] = '';
				}
			}

			// Do we need to disable the delete button?
			if (!$GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Delete_Pages) || !$GLOBALS['PageGrid']) {
				$GLOBALS['DisableDelete'] = "disabled='disabled'";
			}

			if(!$GLOBALS['PageGrid'] && !$GLOBALS['VendorPagesGrid']) {
				// There are no news posts in the database
				$GLOBALS['DisplayGrid'] = "none";
				$GLOBALS['Message'] = MessageBox(GetLang('NoPages'), MSG_SUCCESS);
			}
			else if(!$GLOBALS['PageGrid']) {
				$GLOBALS['NoPagesMessage'] = MessageBox(GetLang('NoPages'), MSG_SUCCESS);
			}
			else if(!$GLOBALS['VendorPagesGrid']) {
				$GLOBALS['NoVendorPagesMessage'] = MessageBox(GetLang('NoVendorPages'), MSG_SUCCESS);
			}

			$GLOBALS['PageIntro'] = GetLang('ManagePagesIntro');
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("pages.manage");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
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

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("page.manage.row");
				$pageList .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
			return $pageList;
		}

		private function PreviewPage()
		{
			if (isset($_GET['pageId'])) {
				$pageId = (int)$_GET['pageId'];
				$query = sprintf("select pagetitle, pagecontent from [|PREFIX|]pages where pageid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($pageId));
				$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

				if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
					$GLOBALS['PageTitle'] = $row['pagetitle'];
					$GLOBALS['PageContent'] = $row['pagecontent'];

					$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("page.preview");
					$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
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
				FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewPages');
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
				$vendorRestriction = '';
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					$vendorRestriction = " AND pagevendorid='".(int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()."'";
				}
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('pages', "WHERE pageid IN ('".$pageids."') OR pageparentid IN ('".$pageids."')".$vendorRestriction);
				$err = $GLOBALS["ISC_CLASS_DB"]->GetError();

				// Update the pages cache
				$GLOBALS['ISC_CLASS_DATA_STORE']->UpdatePages();

				if ($err[0] != "") {
					FlashMessage($err[0], MSG_ERROR, 'index.php?ToDo=viewPages');
				} else {
					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['page']));

					FlashMessage(GetLang('PagesDeletedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewPages');
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

			$GLOBALS['Title'] = GetLang('CreatePage');
			$GLOBALS['FormAction'] = "createPage2";

			$arrData = array();

			$this->_GetPageData(0, $arrData);

			// Was the page submitted with a duplicate page name?
			if($IsError) {
				if($_POST['pagetype'] == 0) {
					$GLOBALS['SelType0'] = 'checked="checked"';
					$GLOBALS['SetupType'] = "SwitchType(0);";
				}
				else if($_POST['pagetype'] == 1) {
					$GLOBALS['SelType1'] = 'checked="checked"';
					$GLOBALS['SetupType'] = "SwitchType(1);";
				}
				else if($_POST['pagetype'] == 2) {
					$GLOBALS['SelType2'] = 'checked="checked"';
					$GLOBALS['SetupType'] = "SwitchType(2);";
				}
				else if($_POST['pagetype'] == 3) {
					$GLOBALS['SelType2'] = 'checked="checked"';
					$GLOBALS['SetupType'] = "SwitchType(3);";
				}

				$GLOBALS['PageTitle'] = $arrData['pagetitle'];
				$GLOBALS['PageName'] = $arrData['pagename'];  //blessen

				$wysiwygOptions = array(
					'id'		=> 'wysiwyg',
					'value'		=> $arrData['pagecontent']
				);
				$GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);

				$GLOBALS['PageLink'] = $arrData['pagelink'];
				$GLOBALS['PageFeed'] = $arrData['pagefeed'];
				$GLOBALS['Visible'] = '';
				if($arrData['pagestatus'] == 1) {
					$GLOBALS['Visible'] = 'checked="checked"';
				}
				$GLOBALS['ParentPageOptions'] = $this->GetParentPageOptions($arrData['pageparentid'], 0, $arrData['pagevendorid']);
				$GLOBALS['PageKeywords'] = $arrData['pagekeywords'];
				$GLOBALS['PageDesc'] = $arrData['pagedesc'];
				$GLOBALS['PageSort'] = $arrData['pagesort'];
				$GLOBALS['PageEmail'] = $arrData['pageemail'];

				if(isset($_POST['contactfields']['fullname'])) {
					$GLOBALS['IsContactFullName'] = 'checked="checked"';
				}

				if(isset($_POST['contactfields']['companyname'])) {
					$GLOBALS['IsContactCompanyName'] = 'checked="checked"';
				}

				if(isset($_POST['contactfields']['phone'])) {
					$GLOBALS['IsContactPhone'] = 'checked="checked"';
				}

				if(isset($_POST['contactfields']['orderno'])) {
					$GLOBALS['IsContactOrderNo'] = 'checked="checked"';
				}

				if(isset($_POST['contactfields']['rma'])) {
					$GLOBALS['IsContactRMA'] = 'checked="checked"';
				}

				if(isset($_POST['pagecustomersonly'])) {
					$GLOBALS['IsCustomersOnly'] = "checked=\"checked\"";
				}

				$selectedVendor = $_POST['pagevendorid'];
			}
			else {
				// Nope, use the default values
				$GLOBALS['Visible'] = 'checked="checked"';
				$GLOBALS['SelType0'] = 'checked="checked"';

				$wysiwygOptions = array(
					'id'		=> 'wysiwyg',
				);
				$GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);

				$GLOBALS['PageLink'] = "http://";
				$GLOBALS['PageFeed'] = "http://";
				$GLOBALS['SetupType'] = "SwitchType(0);";
				$GLOBALS['ParentPageOptions'] = $this->GetParentPageOptions(0, 0, $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId());
				$GLOBALS['PageEmail'] = GetConfig('AdminEmail');
				$selectedVendor = '0';
			}

			if(!gzte11(ISC_HUGEPRINT)) {
				$GLOBALS['HideVendorOption'] = 'display: none';
			}
			else {
				$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
				if(isset($vendorData['vendorid'])) {
					$GLOBALS['HideVendorSelect'] = 'display: none';
					$GLOBALS['CurrentVendor'] = isc_html_escape($vendorData['vendorname']);
				}
				else {
					$GLOBALS['HideVendorLabel'] = 'display: none';
					$GLOBALS['VendorList'] = $this->BuildVendorSelect($selectedVendor);
				}
			}

			$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndAddAnother');

			// Get a list of all layout files
			$GLOBALS['LayoutFiles'] = GetCustomLayoutFilesAsOptions("page.html");

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("page.form");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
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

		private function AddPageStep2()
		{
			$err = "";
			$arrData = array();
			$this->_GetPageData(0, $arrData);

			if(!$this->_IsDuplicateTitle($arrData['pagetitle'], 0, $arrData['pagevendorid'])  and !$this->_IsDuplicateName($arrData['pagename'], 0, 0)) {
				// Commit the values to the database
				if (($pageId = $this->_CommitPage(0, $arrData, $err))) {

					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($pageId, $arrData['pagetitle']);

					if(isset($_POST['addAnother']) || isset($_POST['addAnother2'])) {
						$url = 'index.php?ToDo=createPage';
					}
					else {
						$url = 'index.php?ToDo=viewPages';
					}
					FlashMessage(GetLang('PageAddedSuccessfully'), MSG_SUCCESS, $url);
				}
				else {
					if(isset($_POST['addAnother']) || isset($_POST['addAnother2'])) {
						$url = 'index.php?ToDo=addPage';
					}
					else {
						$url = 'index.php?ToDo=viewPages';
					}
					FlashMessage(sprintf(GetLang('ErrPageNotAdded', $err)), MSG_ERROR, $url);
				}
			}
			else {
				$this->AddPageStep1(GetLang('DuplicatePageTitle'), MSG_ERROR, true);
			}
		}

		private function _GetPageData($PageId, &$RefArray)
		{
			if ($PageId == 0 && count($_POST) > 0) {
				$RefArray['pageid'] = 0;
				$RefArray['pagetitle'] = $_POST['pagetitle'];
				$RefArray['pagename'] = $_POST['pagename']; //blessen
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

		private function _CommitPage($PageId, &$Data, &$err)
		{
			// Commit the details for the page to the database
			$query = "";
			$err = null;

			// Update other pages if this page is set as the home page
			if($Data['pageishomepage'] == 1) {
				$updatedPage = array(
					"pageishomepage" => 0
				);
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("pages", $updatedPage);
			}

			if ($PageId == 0) {
				// ----- Build the query for the news table -----

				// Linked pages can't be the home page
				if ((int) $Data['pagetype'] == 1) {
					$Data['pageishomepage'] = 0;
				}
//blessen
				$newPage = array(
					"pagetitle" => $Data['pagetitle'],
					"pagename" => $Data['pagename'],
					"pagelink" => $Data['pagelink'],
					"pagefeed" => $Data['pagefeed'],
					"pageemail" => $Data['pageemail'],
					"pagecontent" => $Data['pagecontent'],
					"pagestatus" => (int)$Data['pagestatus'],
					"pageparentid" => (int)$Data['pageparentid'],
					"pagesort" => $Data['pagesort'],
					"pagekeywords" => $Data['pagekeywords'],
					"pagedesc" => $Data['pagedesc'],
					"pagetype" => (int)$Data['pagetype'],
					"pagecontactfields" => $Data['pagecontactfields'],
					"pageishomepage" => (int)$Data['pageishomepage'],
					"pagelayoutfile" => $Data['pagelayoutfile'],
					"pagecustomersonly" => $Data['pagecustomersonly'],
					"pageparentlist" => "",
					'pagevendorid' => (int)$Data['pagevendorid'],
				);

				$PageId = $GLOBALS['ISC_CLASS_DB']->InsertQuery("pages", $newPage);

				if($PageId) {
					// Now we need to store the page parent list
					$parentList = $this->_BuildPageParentList($PageId);
					$updatedPage = array(
						"pageparentlist" => $parentList
					);
					$GLOBALS['ISC_CLASS_DB']->UpdateQuery("pages", $updatedPage, "pageid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$PageId)."'");
				}

				$err = $GLOBALS["ISC_CLASS_DB"]->GetError();

			} else {
				$query = "";

				// Only a normal page can be a home page
				if ((int) $Data['pagetype'] == 1) {
					$Data['pageishomepage'] = 0;
				}

				// Update the existing pages details
				//blessen
				$updatedPage = array(
					"pagetitle" => $Data['pagetitle'],
					"pagename" => $Data['pagename'],
					"pagelink" => $Data['pagelink'],
					"pagefeed" => $Data['pagefeed'],
					"pageemail" => $Data['pageemail'],
					"pagecontent" => $Data['pagecontent'],
					"pagestatus" => (int)$Data['pagestatus'],
					"pageparentid" => (int)$Data['pageparentid'],
					"pagesort" => $Data['pagesort'],
					"pagekeywords" => $Data['pagekeywords'],
					"pagedesc" => $Data['pagedesc'],
					"pagetype" => (int)$Data['pagetype'],
					"pagecontactfields" => $Data['pagecontactfields'],
					"pageishomepage" => (int)$Data['pageishomepage'],
					"pagelayoutfile" => $Data['pagelayoutfile'],
					"pagecustomersonly" => $Data['pagecustomersonly'],
					'pagevendorid' => (int)$Data['pagevendorid']
				);

				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("pages", $updatedPage, "pageid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$PageId)."'");
				$err = $GLOBALS["ISC_CLASS_DB"]->GetError();
			}

			// Update the pages cache
			$GLOBALS['ISC_CLASS_DATA_STORE']->UpdatePages();

			if($err[0] != "") {
				return false;
			}
			return true;
		}

		private function EditPageStep1($MsgDesc = "", $MsgStatus = "", $IsError = false)
		{
			$GLOBALS['Message'] = '';
			if($MsgDesc != "") {
				$GLOBALS['Message'] .= MessageBox($MsgDesc, $MsgStatus);
			}

			$GLOBALS['Message'] .= GetFlashMessageBoxes();

			$pageId = (int)$_REQUEST['pageId'];
			$arrData = array();

			if(PageExists($pageId)) {

				// Was the page submitted with a duplicate page name?
				if($IsError) {
					$this->_GetPageData(0, $arrData);
				}
				else {
					$this->_GetPageData($pageId, $arrData);
				}

				// Does this user have permission to edit this product?
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $arrData['pagevendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
					FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewPages');
				}

				$GLOBALS['PageId'] = (int) $pageId;
				$GLOBALS['SetupType'] = sprintf("SwitchType(%d);", $arrData['pagetype']);
				$GLOBALS['Title'] = GetLang('EditPage');
				$GLOBALS['FormAction'] = "editPage2";
				$GLOBALS['PageTitle'] = isc_html_escape($arrData['pagetitle']);
				$GLOBALS['PageName'] = isc_html_escape($arrData['pagename']);

				$wysiwygOptions = array(
					'id'		=> 'wysiwyg',
					'value'		=> $arrData['pagecontent']
				);
				$GLOBALS['WYSIWYG'] = GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);

				$GLOBALS['PageLink'] = isc_html_escape($arrData['pagelink']);
				$GLOBALS['PageFeed'] = isc_html_escape($arrData['pagefeed']);
				$GLOBALS['PageEmail'] = isc_html_escape($arrData['pageemail']);
				$GLOBALS['ParentPageOptions'] = $this->GetParentPageOptions($arrData['pageparentid'], $pageId, $arrData['pagevendorid']);
				$GLOBALS['PageKeywords'] = isc_html_escape($arrData['pagekeywords']);
				$GLOBALS['PageDesc'] = isc_html_escape($arrData['pagedesc']);
				$GLOBALS['PageSort'] = (int) $arrData['pagesort'];

				if($arrData['pagestatus'] == 1) {
					$GLOBALS['Visible'] = 'checked="checked"';
				}

				if($arrData['pagecustomersonly'] == 1) {
					$GLOBALS['IsCustomersOnly'] = "checked=\"checked\"";
				}

				if(is_numeric(isc_strpos($arrData['pagecontactfields'], "fullname"))) {
					$GLOBALS['IsContactFullName'] = 'checked="checked"';
				}

				if(is_numeric(isc_strpos($arrData['pagecontactfields'], "companyname"))) {
					$GLOBALS['IsContactCompanyName'] = 'checked="checked"';
				}

				if(is_numeric(isc_strpos($arrData['pagecontactfields'], "phone"))) {
					$GLOBALS['IsContactPhone'] = 'checked="checked"';
				}

				if(is_numeric(isc_strpos($arrData['pagecontactfields'], "orderno"))) {
					$GLOBALS['IsContactOrderNo'] = 'checked="checked"';
				}

				if(is_numeric(isc_strpos($arrData['pagecontactfields'], "rma"))) {
					$GLOBALS['IsContactRMA'] = 'checked="checked"';
				}

				// Is this page the default home page?
				if($arrData['pageishomepage'] == 1) {
					$GLOBALS['IsHomePage'] = 'checked="checked"';
				}

				if(!gzte11(ISC_HUGEPRINT)) {
					$GLOBALS['HideVendorOption'] = 'display: none';
				}
				else {
					$vendorData = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendor();
					if(isset($vendorData['vendorid'])) {
						$GLOBALS['HideVendorSelect'] = 'display: none';
						$GLOBALS['CurrentVendor'] = isc_html_escape($vendorData['vendorname']);
					}
					else {
						$GLOBALS['HideVendorLabel'] = 'display: none';
						$GLOBALS['VendorList'] = $this->BuildVendorSelect($arrData['pagevendorid']);
					}
				}

				// Get a list of all layout files
				$layoutFile = 'page.html';
				if($arrData['pagelayoutfile'] != '') {
					$layoutFile = $arrData['pagelayoutfile'];
				}
				$GLOBALS['LayoutFiles'] = GetCustomLayoutFilesAsOptions("page.html", $layoutFile);

				$GLOBALS['SaveAndAddAnother'] = GetLang('SaveAndContinueEditing');

				$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("page.form");
				$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
			}
			else {
				// The news page doesn't exist
				FlashMessage(GetLang('PageDoesntExist'), MSG_ERROR, 'index.php?ToDo=viewPages');
			}
		}

		private function EditPageStep2()
		{
			// Get the information from the form and add it to the database
			$pageId = (int)$_POST['pageId'];
			$arrData = array();
			$err = "";

			$existingPage = array();
			$this->_GetPageData($pageId, $existingPage);

			// Does this user have permission to edit this product?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $existingPage['pagevendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				FlashMessage(GetLang('Unauthorized'), MSG_ERROR, 'index.php?ToDo=viewPages');
			}

			$this->_GetPageData(0, $arrData);
			$arrData['pageid'] = $pageId;

			if(!$this->_IsDuplicateTitle($arrData['pagetitle'], $pageId, $arrData['pagevendorid'])  and !$this->_IsDuplicateName($arrData['pagename'], $pageId, 0)) {
				// Commit the values to the database
				if ($this->_CommitPage($pageId, $arrData, $err)) {

					if($existingPage['pageparentid'] != $arrData['pageparentid']) {
						// Rebuild the parent list
						$parentList = $this->_BuildPageParentList($pageId);

						$updatedPage = array(
							"pageparentlist" => $parentList
						);
						$GLOBALS['ISC_CLASS_DB']->UpdateQuery("pages", $updatedPage, "pageid='".$GLOBALS['ISC_CLASS_DB']->Quote((int)$pageId)."'");

						// Now we also need to update the parent list of all child pages for this page
						$query = sprintf("SELECT pageid FROM [|PREFIX|]pages WHERE CONCAT(',', pageparentlist, ',') LIKE '%%,%s,%%'", $pageId);
						$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
						while($child = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
							$parentList = $this->_BuildPageParentList($child['pageid']);
							// Update the parent list for this child
							$updatedPage = array(
								"pageparentlist" => $parentList
							);
							$GLOBALS['ISC_CLASS_DB']->UpdateQuery("pages", $updatedPage, "pageid='".$GLOBALS['ISC_CLASS_DB']->Quote($child['pageid'])."'");
						}
					}

					// Log this action
					$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($pageId, $arrData['pagetitle']);

					if(isset($_POST['addAnother']) || isset($_POST['addAnother2'])) {
						$url = 'index.php?ToDo=editPage&pageId='.$pageId;
					}
					else {
						$url = 'index.php?ToDo=viewPages';
					}
					FlashMessage(GetLang('PageUpdatedSuccessfully'), MSG_SUCCESS, $url);
				} else {
					if(isset($_POST['addAnother']) || isset($_POST['addAnother2'])) {
						$url = 'index.php?ToDo=editPage&pageId='.$pageId;
					}
					else {
						$url = 'index.php?ToDo=viewPages';
					}
					FlashMessage(sprintf(GetLang('ErrPageNotUpdated'), $err), MSG_ERROR, $url);
				}
			}
			else {
				$this->EditPageStep1(GetLang('DuplicatePageTitle'), MSG_ERROR, true);
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
		private function _IsDuplicateTitle($title, $existingId=0, $vendorId=0)
		{
			$query = "
				SELECT pageid
				FROM [|PREFIX|]pages
				WHERE LOWER(pagetitle)='".$GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($title))."'
			";
			if($existingId > 0) {
				$query .= " AND pageid != '".(int)$existingId."'";
			}
			if($vendorId > 0) {
				$query .= " AND pagevendorid ='".(int)$vendorId."'";
			}
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit(0, 1);

			if($GLOBALS['ISC_CLASS_DB']->FetchOne($query)) {
				return true;
			}
			else {
				return false;
			}
		}

		private function _IsDuplicateName($title, $existingId=0, $vendorId=0)
		{
			if ($title == "")  return false;

			$query = "
				SELECT pageid
				FROM [|PREFIX|]pages
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
	}

?>