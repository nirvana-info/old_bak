<?php
//zfang_20100628 Add a new class to handle order review request settings
class ISC_ADMIN_SETTINGS_ORDER_REVIEWREQUEST
{
	/**
	 * Handle the action for this section.
	 *
	 * @param string The name of the action to do.
	 */
	public function HandleToDo($Do)
	{
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('order_review_request');		
		//zfang for test
		//print_r("In class.settings.order.reviewrequest.php");
		//print_r($Do);

		if (isset($_REQUEST['currentTab'])) {
			$GLOBALS['CurrentTab'] = (int)$_REQUEST['currentTab'];
		}
		else {
			$GLOBALS['CurrentTab'] = 0;
		}

		$GLOBALS['BreadcrumEntries'] = array (
			GetLang('Home') => "index.php",
			GetLang('Settings') => "index.php?ToDo=viewSettings",

			//zfang_20100628 Change breadcurm to 'order review request settings'
			//GetLang('OrderSettings') => "index.php?ToDo=viewScriptSettings"
			GetLang('OrderReviewRequestSettings') => "index.php?ToDo=viewRequestScriptSettings"
			//todo: Change to GetLang
		);

		if (!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings) || !gzte11(ISC_MEDIUMPRINT)) {
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			return;
		}

		/**
		 * Load the language file
		 */
		$lang = 'en';

		if (strpos(GetConfig('Language'), '/') === false) {
			$lang = GetConfig('Language');
		}

		//zfang
		//print_r($Do);
		switch(isc_strtolower($Do))
		{
			
			/*case "viewrequestscriptsettings": {
				//print_r("Get it");
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				//print_r(" Header printed");
				$this->ManageOrderReviewRequestSettings();
				//print_r( "MMM");
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			}*/
			case "createrequestscriptsettings":
				{					
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->CreateRequestReviewSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
			case "createrequestscriptsettings2":
				{
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->CreateRequestReviewSettings2();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
			case "editrequestscriptsettings":
				{
					//echo "hello";
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->EditRequestReviewSettings();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
			case "editrequestscriptsettings2":
				{
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->EditRequestReviewSettings2();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
			case "deleterequestscriptsettings":
				{
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->DeleteRequestTemplate();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					break;
				}
			case "copyrequestscriptsettings": {    
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				$this->CopyOrderReviewRequestSettings();
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				break;
			} 
			case "setdefaultrequestscriptsettings": {  
				if(!isset($_REQUEST['ajax'])) {  
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				}
				$this->SetDefaultOrderReviewRequestSettings();
				if(!isset($_REQUEST['ajax'])) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				}
				break;
			} 
			default:
				if(!isset($_REQUEST['ajax'])) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
				}
				$this->ManageOrderReviewRequestSettings();
				if(!isset($_REQUEST['ajax'])) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				}
				break;
		}
	}
	
	private function ManageOrderReviewRequestGrid(&$numRequest)
	{		
		$page=0;
		$start = 0;	
		$numRequest =0;	
		$numPages = 0;
		$GLOBALS['OrderReviewRequestGrid'] = "";
		$GLOBALS['Nav'] ="";
		$max = 0;
		
		if(isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc')
		{
			$sortOrder = 'desc';
		}
		else
		{
			$sortOrder = 'asc';
		}
		
		$sortLinks = array(
			"Type" => "request_script_type",
			"Description" => "description",
			"Template" => "request_script_value",
			"Coupon_Code" => "coupon_code",
			"Default" => "is_default"
		);
		
		if(isset($_GET['sortField']) && in_array($_GET['sortField'],$sortLinks))
		{
			$sortField = $_GET['sortField'];
			SaveDefaultSortField("ManageOrderReviewRequests",$_REQUEST['sortField'],$sortOrder);
		}
		else
		{
			list($sortField, $sortOrder) = GetDefaultSortField("ManageOrderReviewRequests", "id", $sortOrder);
		}
		
		if(isset($_GET['page']))
		{
			$page = (int)$_GET['page'];
		}
		else
		{
			$page=1;
		}
		
		$sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
		$GLOBALS['SortURL'] = $sortURL;
		
		if($page == 1)
		{
			$start =1;
		}
		else {
			$start = ($page * ISC_Order_REVIEW_REQUEST_PER_PAGE) - (ISC_Order_REVIEW_REQUEST_PER_PAGE-1);
		}
		$start = $start -1;			
		
		// Get the results for the query
		$requestResult = $this->_GetOrderReviewRequestList($start, $sortField, $sortOrder, $numRequest);
		
		
		//echo "$numRequest<br/>";
		$numPages = ceil($numRequest / ISC_Order_REVIEW_REQUEST_PER_PAGE);
		//echo $numPages . " total<br>";
		// Add the "(Page x of n)" label
		if($numRequest > ISC_Order_REVIEW_REQUEST_PER_PAGE) {
			$GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);
			$GLOBALS['Nav'] .= BuildPagination($numRequest, ISC_Order_REVIEW_REQUEST_PER_PAGE, $page, sprintf("index.php?ToDo=viewrequestscriptsettings%s", $sortURL));
		}
		else {
			$GLOBALS['Nav'] = "";
		}
		
		$GLOBALS['Nav'] = rtrim($GLOBALS['Nav'], ' |');
		$GLOBALS['SortField'] = $sortField;
		$GLOBALS['SortOrder'] = $sortOrder;
		
		BuildAdminSortingLinks($sortLinks, "index.php?ToDo=viewrequestscriptsettings&amp;page=".$page, $sortField, $sortOrder);
		// Workout the maximum size of the array
		$max = $start + ISC_Order_REVIEW_REQUEST_PER_PAGE;

		if($max > count($requestResult)) {
			$max = count($requestResult);
		}
		
		if($numRequest > 0) {
			// Display the news
			//$row =$GLOBALS['ISC_CLASS_DB']->Fetch
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($requestResult)) {
				$GLOBALS['ReviewRequestID'] = (int) $row['id'];

				if($row['request_script_type']) {
					$GLOBALS['ReviewRequestType'] = "<a href='index.php?ToDo=editrequestscriptsettings&amp;id=".$row['id']."'>".isc_html_escape($row['request_script_type'])."</a>";
				}
				else {
					$GLOBALS['ReviewRequestType'] = GetLang('NA');
				}
				
				$GLOBALS['CheckDisabled'] = "";
				
				if($row['description'] == " ") {
					$GLOBALS['ReviewRequestDescription'] = GetLang('NA');
				} else {
					$GLOBALS['ReviewRequestDescription'] = isc_html_escape($row['description']);
				}

				if($row['request_script_value'] == " ") {
					$GLOBALS['ReviewRequestValue'] = GetLang('NA');
				} else {
					$GLOBALS['ReviewRequestValue'] = isc_html_escape($row['request_script_value']);
				}

				//$GLOBALS['Username'] = isc_html_escape($row['username']);

				//if(!$row['coupon_code']) {
				//	$GLOBALS['Coupon_Code'] = GetLang('NA');
				//}
				//else {
					$GLOBALS['Coupon_Code'] = isc_html_escape($row['coupon_code']);
				//}
				
				//if(!$row['is_default']) {
				//	$GLOBALS['Is_Default'] = GetLang('NA');
				//}
				//else {
				//	$temp = (int)$row['is_default'] == 1 ? GetLang('OrderReviewRequestTemplateAsDefault'):GetLang('OrderReviewRequestTemplateAsNotDefault');
				//	$GLOBALS['Is_Default'] = isc_html_escape($temp);
				//}				
				$GLOBALS['Is_Default'] = (int)$row['is_default'];
				// Can this account be edited?
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
					$GLOBALS['EditReviewRequestLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=editrequestscriptsettings&amp;id=%d'>%s</a>", GetLang('EditOrderReviewRequest'), $row['id'], GetLang('Edit'));
				}
				else {
					$GLOBALS['EditReviewRequestLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Edit'));
				}

				// Can this account be copied?
				if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
					$GLOBALS['CopyReviewRequestLink'] = sprintf("<a title='%s' class='Action' href='index.php?ToDo=copyrequestscriptsettings&amp;id=%d'>%s</a>", GetLang('DeleteOrderReviewRequest'), $row['id'], GetLang('Copy'));
				}
				else {
					$GLOBALS['CopyReviewRequestLink'] = sprintf("<a class='Action' disabled>%s</a>", GetLang('Copy'));
				}


				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.order.reviewrequest.manage.row");
				$GLOBALS['ReviewRequestGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
			}
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.order.reviewrequest.manage.grid");
			return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}
	}
	
	public function _GetOrderReviewRequestList($Start, $SortField, $SortOrder, &$NumResults)
	{
		$queryWhere = '';
		
		$queryNum = "SELECT count(*) as num FROM [|PREFIX|]order_review_request i ";		

		$queryClause = "WHERE 1=1 ".$queryWhere;
		$queryClause .= "ORDER BY ".$SortField." ".$SortOrder;
		$result = $GLOBALS['ISC_CLASS_DB']->Query($queryNum .$queryClause);
		//echo $GLOBALS['ISC_CLASS_DB']->_Error;
		$NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
		$query = "SELECT * FROM [|PREFIX|]order_review_request  ";
		$query = $query.$queryClause;
		// Add the limit
		$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($Start, ISC_Order_REVIEW_REQUEST_PER_PAGE);

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		
		try {
			$queryNum = "SELECT count(*) as num FROM [|PREFIX|]order_review_request i where `is_default`=1 ";
			$mynumber = $GLOBALS['ISC_CLASS_DB']->Query($queryNum);
			$Num = $GLOBALS['ISC_CLASS_DB']->FetchOne($mynumber);
			
			if($Num <= 0)
			{
				$queryNum = "SELECT id FROM [|PREFIX|]order_review_request  limit 0,1 ";
				$mynumber = $GLOBALS['ISC_CLASS_DB']->Query($queryNum);
				$Num = $GLOBALS['ISC_CLASS_DB']->FetchOne($mynumber);
				if(is_numeric($Num))
				{
					$query = "update [|PREFIX|]order_review_request set is_default=1 where id= ".$Num;
					echo $query;
					$GLOBALS['ISC_CLASS_DB']->Query($query);
				}			
			}
		}
		catch (Exception $e)
		{
			
		}
		return $result;
	}

	public function ManageOrderReviewRequestSettings($MsgDesc = "", $MsgStatus = "")
	{
		
			// Fetch any results, place them in the data grid
			$numRequest = 0;
			$GLOBALS['OrderReviewRequestDataGrid'] = $this->ManageOrderReviewRequestGrid($numRequest);
			//echo $numRequest;
			// Was this an ajax based sort? Return the table now
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
				echo $GLOBALS['OrderReviewRequestDataGrid'];
				return;
			}
			
			//$MsgDesc =$numRequest;

			if($MsgDesc != "") {
				$GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
			}

			 //Do we need to disable the delete button?
			if(!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings) || $numRequest == 0) {
				$GLOBALS['DisableDelete'] = "DISABLED";
			}
			//$GLOBALS['DisableDelete'] = "";
			

			$GLOBALS['ReviewReqeustIntro'] = GetLang('OrderReviewRequestSettingsIntro');

			if($numRequest == 0) {
				// There are no users in the database
				$GLOBALS['DisplayGrid'] = "none";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.order.reviewrequest.manage");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		
	}
    
	
	private function DeleteRequestTemplate()
	{
		
		if(isset($_POST['requestids'])) {
			//echo $_POST['requestids'] ." test<br>";
			$requestIds = implode(',',array_map("intval",$_POST['requestids']));
			//echo $requestIds. "<br>";
			//exit;
			$query =sprintf(" delete from [|PREFIX|]order_review_request where id in(%s)",$requestIds);
			
			$GLOBALS['ISC_CLASS_DB']->Query($query);
			$err = $GLOBALS['ISC_CLASS_DB']->_Error;

			if($err != "") {
				$this->ManageOrderReviewRequestSettings($err, MSG_ERROR);
			} else {

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['requestids']));

				$this->ManageOrderReviewRequestSettings(GetLang('ReviewRequestDeletedSuccessfully'), MSG_SUCCESS);
			}
		}
		else {
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
				$this->ManageOrderReviewRequestSettings();
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			}
		}
	}
	
/**
	*	If the editor is disabled then we'll see if we need to run
	*	nl2br on the text if it doesn't contain any HTML tags
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
	
	public function CopyOrderReviewRequestSettings()
	{
		/*if($message = str_strip($_REQUEST, '#')) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError(GetLang(B('UmVhY2hlZFVzZXJMaW1pdA==')), $message, MSG_ERROR);
				exit;
			}*/
		$requestId = $_GET['id'];
		$arrData = array();

		$this->_MyGetRequestData($requestId,$arrData);
		//echo "$requestId<br/>";
		if($this->RequestrExists($requestId))
		{
			
			$GLOBALS['FormAction'] = "createrequestscriptsettings2";
			$GLOBALS['Title'] = GetLang('CreateReviewRequestTemplate');	
			$GLOBALS['ReviewRequest_ID'] = "0";

			$wysiwygOptions = array(
					'id'		=> 'wysiwyg',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['request_script_value']
				);
			$GLOBALS['WYSIWYG'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
			//$GLOBALS['ReviewRequestCuponCode']=$arrData['coupon_code'];
			$GLOBALS['ReviewRequestSetDefault']=$arrData['is_default'];
			$GLOBALS['ReviewRequestDescription']=htmlspecialchars($arrData['description']);
			$GLOBALS['ReviewRequestCuponCode']=$this->_GetCouponCodeOptions($arrData['coupon_code']);
			$GLOBALS['RequestScriptTips']=htmlspecialchars(GetLang('RequestScriptTips'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.order.reviewrequest.manage.form");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			
		}
		else
		{
			
			// The news post doesn't exist
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
				$this->ManageOrderReviewRequestSettings(GetLang('RequestDoesntExist'), MSG_ERROR);
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			}
		}
	}
		
	public function CreateRequestReviewSettings()
	{
		/*if($message = str_strip($_REQUEST, '#')) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError(GetLang(B('UmVhY2hlZFVzZXJMaW1pdA==')), $message, MSG_ERROR);
				exit;
			}*/
			$defaultTpl = "<p>&lt;!--ORDER_DATE--&gt;</p><p>&lt;!--ORDER_DETAILS--&gt;</p><p>&lt;!--ORDER_REVIEW_LINK--&gt;</p><p>&lt;!--ORDER_COUPON_CODE--&gt;</p>";
			$GLOBALS['FormAction'] = "createrequestscriptsettings2";
			$GLOBALS['Title'] = GetLang('CreateReviewRequestTemplate');	
			$GLOBALS['ReviewRequest_ID'] = "0";
			$GLOBALS['ReviewRequestSetDefault']="0";
			$GLOBALS['ReviewRequestDescription']="";
			$wysiwygOptions = array(
					'id'		=> 'wysiwyg',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $defaultTpl
			);
			$GLOBALS['WYSIWYG'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
			$GLOBALS['ReviewRequestCuponCode']=$this->_GetCouponCodeOptions("");
			$GLOBALS['RequestScriptTips']=htmlspecialchars(GetLang('RequestScriptTips'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.order.reviewrequest.manage.form");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}
	
	public function CreateRequestReviewSettings2()
	{		/*
		if($message = str_strip($_REQUEST, '#')) {
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError(GetLang(B('UmVhY2hlZFVzZXJMaW1pdA==')), $message, MSG_ERROR);
			exit;
		}	*/	
		
		$arrData = array();
		$this->_MyGetRequestData(0,$arrData);	
		//echo $_POST['setdefault'] . " temp<br/>";	
		//print_r($arrData);
		//exit;
		if($this->_CommitRequest(0, $arrData,  $err)) {
			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
				$this->ManageOrderReviewRequestSettings(GetLang('RequestAddedSuccessfully'), MSG_SUCCESS);
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('RequestAddedSuccessfully'), MSG_SUCCESS);
			}
		}
		else {
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
				$this->ManageOrderReviewRequestSettings(sprintf(GetLang('ErrRequestNotAdded'), $err), MSG_ERROR);
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(sprintf(GetLang('ErrRequestNotAdded'), $err), MSG_ERROR);
			}
		}
	}
	
	public function EditRequestReviewSettings()
	{
		/*
		if($message = str_strip($_REQUEST, '#')) {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoError(GetLang(B('UmVhY2hlZFVzZXJMaW1pdA==')), $message, MSG_ERROR);
				exit;
			}*/
			
		$requestId = (int)$_GET['id'];		
		$arrData = array();

		$this->_MyGetRequestData($requestId,$arrData);
		//echo "$requestId<br/>";
		if($this->RequestrExists($requestId))
		{
			
			$GLOBALS['FormAction'] = "EditRequestScriptSettings2&id=".$requestId;
			$GLOBALS['Title'] = GetLang('EditReviewRequestTemplate');	
			$GLOBALS['ReviewRequest_ID'] = $requestId;

			$wysiwygOptions = array(
					'id'		=> 'wysiwyg',
					'width'		=> '60%',
					'height'	=> '350px',
					'value'		=> $arrData['request_script_value']
				);
			$GLOBALS['WYSIWYG'] =  GetClass('ISC_ADMIN_EDITOR')->GetWysiwygEditor($wysiwygOptions);
			//$GLOBALS['ReviewRequestCuponCode']=$arrData['coupon_code'];
			$GLOBALS['ReviewRequestSetDefault']=$arrData['is_default'];
			$GLOBALS['ReviewRequestDescription']=htmlspecialchars($arrData['description']);
			$GLOBALS['ReviewRequestCuponCode']=$this->_GetCouponCodeOptions($arrData['coupon_code']);
			$GLOBALS['RequestScriptTips']=htmlspecialchars(GetLang('RequestScriptTips'));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("settings.order.reviewrequest.manage.form");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			
		}
		else
		{			
			// The news post doesn't exist
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
				$this->ManageOrderReviewRequestSettings(GetLang('RequestDoesntExist'), MSG_ERROR);
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			}
		}
		
	}
	
	public function EditRequestReviewSettings2()
	{
		//echo "hello<br>";
		$requestID= $_GET['id'];
		$arrData = Array();
		//echo($requestID);
		//exit;
		$err = "";
		//$arrRequestData = Array();
		
		$this->_MyGetRequestData(0,$arrData);
		//print_r($arrData);
		//echo "hello";
		//exit;
		
		if($this->_CommitRequest($requestID, $arrData, $err)) {
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();

			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
				$this->ManageOrderReviewRequestSettings(GetLang('RequestUpdateSuccessfully'), MSG_SUCCESS);
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('RequestUpdateSuccessfully'), MSG_SUCCESS);
			}
		}
		else
		{
		// The news post doesn't exist
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Settings)) {
				$this->ManageOrderReviewRequestSettings(GetLang('RequestDoesntExist'), MSG_ERROR);
			} else {
				$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
			}
		}	
		
	}
	
	public function RequestrExists($requestId)
	{
		// Check if a record is found for a news post and return true/false
		$query = sprintf("select id from [|PREFIX|]order_review_request where id='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($requestId));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			return true;
		} else {
			return false;
		}
	}
	
	private function _MyGetRequestData($requestId, &$RefArray)
	{
		//echo "$requestId<br/>";
		// Get the data for the user and return it
		if ($requestId == 0) {
			
			// Get the details for the user from the form
			if (isset($_POST['requestid']) && is_numeric($_POST['requestid'])) {
				$RefArray['id'] = $_POST['requestid'];
			} else {
				$RefArray['id'] = 0;
			}
			
		if(isset($_POST['description']) && $_POST['description'] != '') {
				$RefArray['description'] = $_POST['description'];
			}
			else{
				$RefArray['description'] = '';
			}

			if (isset($_POST['wysiwyg'])) {
				$RefArray['request_script_value'] =  $this->FormatWYSIWYGHTML($_POST['wysiwyg']);
			}

			if(isset($_POST['coupon_code']) && $_POST['coupon_code'] != '') {
				$RefArray['coupon_code'] = $_POST['coupon_code'];
			}
			else{
				$RefArray['coupon_code'] = '';
			}
			//print_r($_POST['setdefault']); echo "<br/>";
			if(!empty($_POST['setdefault']) ) {
				$RefArray['is_default'] = $_POST['setdefault'][0];
			}
			else {
				$RefArray['is_default'] = 0;
			}
			
		}
		else {
			// Get the details from the database
			//echo "hello<br/>";
			$query = sprintf("select * from [|PREFIX|]order_review_request where id='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($requestId));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			//echo $GLOBALS['ISC_CLASS_DB']->_Error;
			if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$RefArray = $row;
			}
		}
	}
	
	private function _GetCouponCodeOptions($selectvalue)
	{		
		$result = "<option value=''>".GetLang("ChooseACouponCode")."</option>";
		$query = " select couponcode from [|PREFIX|]coupons where couponenabled=1 ";
		$resource = $GLOBALS['ISC_CLASS_DB']->Query($query);
		//echo $GLOBALS['ISC_CLASS_DB']->_Error;
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($resource))
		{
			//echo "ok";
			$couponcode = $row['couponcode'];
			if($couponcode == $selectvalue)
			{
				$result .= "<option value='".$couponcode."' selected>".isc_html_escape($couponcode)."</option>";
			}
			else
			{
				$result .= "<option value='".$couponcode."'>".isc_html_escape($couponcode)."</option>";
			}
		}
		return $result;
	}
	
	public function _CommitRequest($requestId, &$Data,  &$Err)
	{
		// Commit the details for the user account to the database
		$queries = array();
		$query = "";
		$err = null;
		if($requestId == 0) {
			// ----- Build the query for the user table -----			
			$newRequest = array(
				"description" => $Data['description'],
				"request_script_value" => $Data['request_script_value'],
				"coupon_code" => $Data['coupon_code'],
				"is_default" => $Data['is_default']				
			);

			
			if(is_numeric($Data['is_default']) &&  (int)$Data['is_default']== 1)
			{
				$query = "update [|PREFIX|]order_review_request set `is_default`=0 ";
				$GLOBALS['ISC_CLASS_DB']->Query($query);
				//echo $GLOBALS['ISC_CLASS_DB']->_Error."<br>";
		
			}

			$RequestId = $GLOBALS['ISC_CLASS_DB']->InsertQuery("order_review_request", $newRequest);
			//echo $GLOBALS['ISC_CLASS_DB']->_Error."<br>";
				
		}
		else {
			
			//$this->_MyGetRequestData($requestId, $existingUser);
			$updatedRequest = array(
				"description" => $Data['description'],
				"request_script_value" => $Data['request_script_value'],
				"coupon_code" => $Data['coupon_code'],
				"is_default" => $Data['is_default']	
			);
			
			if(is_numeric($Data['is_default']) &&  (int)$Data['is_default']== 1)
			{
				$query = "update [|PREFIX|]order_review_request set `is_default`=0 ";
				$GLOBALS['ISC_CLASS_DB']->Query($query);
			}
			
			
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("order_review_request", $updatedRequest, "id='".$GLOBALS['ISC_CLASS_DB']->Quote($requestId)."'");
					
		}

		$err = $GLOBALS['ISC_CLASS_DB']->_Error;
		$Err = $err;

		if(is_null($err) || $err == "") {
			return true;
		} else {
			return false;
		}
	}
	private function SetDefaultOrderReviewRequestSettings()
	{
		if(!isset($_REQUEST["requestId"]) || !is_numeric($_REQUEST["requestId"]))
		{
			echo "0";
			exit;
		}
		$requestId = (int)$_REQUEST["requestId"];
		if($requestId <= 0)
		{
			echo "0";
			exit;
		}
		$query = "update [|PREFIX|]order_review_request set `is_default`=0; ";
		$GLOBALS['ISC_CLASS_DB']->Query($query);
		$query = "update [|PREFIX|]order_review_request set `is_default`=1 where id=".$requestId;
		$GLOBALS['ISC_CLASS_DB']->Query($query);
		echo "1";
		exit;
	}
	
	/*
	public function SaveUpdatedOrderReviewRequestSettings()
	{		
		$newField = array(                       
                        "request_script_value" => $_POST['request_script']
                    );
		//die($newField);
		//die( $_POST['request_script']);
        	$GLOBALS['ISC_CLASS_DB']->UpdateQuery("order_review_request", $newField, "request_script_type='request_script'");   
        
	        //$newField1 = array(
        	 //               "scriptvalue" => $_POST['ordercompletemsg']
            //    	    );
	       // $GLOBALS['ISC_CLASS_DB']->UpdateQuery("order_scripts", $newField1, "scripttype='ordermsg'");       
              
        
		$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();
		FlashMessage(GetLang('OrderReviewRequestSettingsSavedSuccessfully'), MSG_SUCCESS, 'index.php?ToDo=viewRequestScriptSettings&currentTab='.((int) $_POST['currentTab']));
		        
	}   */              
}
?>