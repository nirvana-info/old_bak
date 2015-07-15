<?php
if (!defined('ISC_BASE_PATH')) {
	die();
}

/**
 * Interspire Order Review Management.
 */
class ISC_ADMIN_REQUESTS
{
	/**
	 * The constructor.
	 */
	public function __construct()
	{
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('requests');
	}

	/**
	 * Handle the incoming action we want to perform.
	 *
	 * @param string The name of the action to perform.
	 */
	public function HandleToDo($do)
	{
		if(!$GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Orders)) {
			exit;
		}

		// Initialise custom searches functionality
		//require_once(dirname(__FILE__).'/class.customsearch.php');
		//$GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH'] = new ISC_ADMIN_CUSTOMSEARCH('requests');

		// Set up some generic breadcrumb entries as these will be used on most pages
		$GLOBALS['BreadcrumEntries'] = array(
			GetLang('Home') => 'index.php',
			GetLang('Orders') => 'index.php?ToDo=viewOrders',
			GetLang('viewRequests') => 'index.php?ToDo=viewRequests'
		);

		switch(strtolower($do)) {
			case 'createrewrequests':
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
				$this->CreateRequest();
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pagefooter.popup");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
				break;
			case 'sendrewrequests':
				$this->SendRequest();
				break;
			case 'sendrewrequestsmulty':
				$this->SendRequestMulty();
				break;
			case 'deleterewrequests':
				$this->DeleteRequest();
				break;
			case 'customrewrequestsearch':
				$this->CustomSearch();
				break;
			case 'searchrewreuquestsredirect':
				$this->SearchRequestsRedirect();
				break;
			case 'searchrewrequests':
				$this->SearchRequests();
				break;
			case 'viewrewrequest':
				$this->PreviewRequest();
				break;
			case 'reportrewrequest':
				$this->ReportRequest();
				break;
			case 'tplrewrequest':
				if(isset($_GET['selectedId']))
					$selectedId = $_GET['selectedId'];
				else
					$selectedId = 0;
				$this->TemplateRequest($selectedId);
				break;
			default:
				$this->ManageShipments();
		}
	}
	
	public function TemplateRequest($selectId, $type=1){
		if(!isset($_REQUEST['orderId'])) {
			exit;
		}
		$GLOBALS['OrderId'] = $_REQUEST['orderId'];
		$GLOBALS['SelectedId'] = $selectId;
		
		$GLOBALS['RemindMessage'] = GetLang('ChooseTip');
		
		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]order_review_request where request_script_type = 'request_script'");
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$GLOBALS['TemplateId'] = $row['id'];
			$GLOBALS['Description'] = $row['description'];
			$GLOBALS['CouponCode'] = empty($row['coupon_code']) ? '<pre>None</pre>' : $row['coupon_code'];
			$GLOBALS['IsDefault'] = $row['is_default'];
			
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('request.templates.rows');
			$GLOBALS['TemplateList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}	
		
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('request.templates.choice');
		return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}
	
	public function TemplateRequestMulty($selectId, $type=1){
		if(!isset($_REQUEST['orderIds'])) {
			exit;
		}
		$orderids = explode(",",$_REQUEST['orderIds']);
		//$orderids = array_map("intval",$orderids);
		$orderids = array_map("intval",$orderids);
				
		$GLOBALS['OrderIds'] = implode(",",$orderids);
		
		$GLOBALS['SelectedId'] = $selectId;
		
		$GLOBALS['RemindMessage'] = GetLang('ChooseTip');
		
		$result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]order_review_request where request_script_type = 'request_script'");
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$GLOBALS['TemplateId'] = $row['id'];
			$GLOBALS['Description'] = $row['description'];
			$GLOBALS['CouponCode'] = empty($row['coupon_code']) ? '<pre>None</pre>' : $row['coupon_code'];
			$GLOBALS['IsDefault'] = $row['is_default'];
			
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('request.templates.rows');
			$GLOBALS['TemplateList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}	
		
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('request.templates.choice2');
		return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}
	
	public function ReportRequest()
	{
		$GLOBALS['ReportDetail'] = $_COOKIE["ReportDetail"];
		$GLOBALS['ReportResult'] = $_COOKIE["ReportResult"];
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('requests.report');
		return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}
	
	public function SendRequest()
	{
		$success = (int)@$_REQUEST['success'];
		$failed = (int)@$_REQUEST['failed'];

		$orderId = (int) $_REQUEST['o'];
		$this->GetOrderDetail($orderId);
		
		$query = "
			SELECT requeststatus
			FROM [|PREFIX|]requests
			WHERE orderid=".$orderId."
		";
		
		if(isset($_GET['templateId'])){
			$templateId = $_GET['templateId'];
		}else{
			$templateId = 0;
		}
		
		$isExistItem = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
		$canResend = true;
		
		if($isExistItem){
			if(isset($_REQUEST['resend']) && $_REQUEST['resend']==1)
				$canResend = true;
			else
				$canResend = false;
		}
		
		//echo "resend:".$canResend."<br/>";
		
		$this->RecordReviewRequest($orderId, $canResend,$templateId);
		
		if(!isset($GLOBALS['ReportDetail'])){
			$GLOBALS['ReportDetail'] = '';
		}
		
		if (isId(@$_REQUEST['o']) && $canResend && isset($GLOBALS['contactEmail']) && $this->SendRequestByEmail($GLOBALS['contactEmail'])) {
			echo '1';
			$success++;
			$GLOBALS['ReportDetail'] .= '<tr><td>'.$orderId.'</td><td>Send Request to ['.$orderId.']</td><td>Success</td><td><input type="button" value="Resend" onclick="ResendOrdViewRequest('.$orderId.','.$templateId.')"/></td></tr>';
		} else {
			echo '0';
			$failed++;
			
			if($canResend)
				$GLOBALS['ReportDetail'] .= '<tr><td>'.$orderId.'</td><td>Send Request to Order['.$orderId.']</td><td>Failed</td><td><input type="button" value="Resend" onclick="ResendOrdViewRequest('.$orderId.','.$templateId.')"/></td></tr>';
			else
				$GLOBALS['ReportDetail'] .= '<tr><td>'.$orderId.'</td><td>Duplicate Request to Order['.$orderId.']</td><td>Failed</td><td><input type="button" value="Resend" onclick="ResendOrdViewRequest('.$orderId.','.$templateId.')"/></td></tr>';
		}

		$message = sprintf(GetLang('OrderReviewRequestStatusReport'), $success);
		if ($failed) {
			$message .= sprintf(GetLang('OrderReviewRequestStatusReportFail'), $failed);
		}
		
		$GLOBALS['ReportResult'] = $message;
		
		if(isset($_COOKIE["ReportDetail"]) && isset($_COOKIE["ReportResult"])){
			setcookie("ReportDetail", $_COOKIE["ReportDetail"].$GLOBALS['ReportDetail'], time()+3600);
			setcookie("ReportResult", $GLOBALS['ReportResult'], time()+3600);
		}else{
			setcookie("ReportDetail", $GLOBALS['ReportDetail'], time()+3600);
			setcookie("ReportResult", $GLOBALS['ReportResult'], time()+3600);
		}
		
		$message .= '<a href="javascript:void(0)" onclick="ShowReportDetail()">Detail</a>';
		echo MessageBox($message, MSG_SUCCESS);
		//echo "<br/>templateId:".$templateId;
		exit;
	}
	
	public function SendRequestMulty()
	{		
		$success = (int)@$_REQUEST['success'];
		$failed = (int)@$_REQUEST['failed'];
		if(!isset($_REQUEST['orderIds'])) {
			exit;
		}
		//echo $_REQUEST['orderIds'];
		$orderids = explode(",",$_REQUEST['orderIds']);
		$orderids = array_map("intval",$orderids);
		/*if(is_array($orderids))
		{
			
			echo "array";
		}
		else
		{
			echo "not array";
		}*/
		//print_r($orderids);
		//exit;
		if(isset($_GET['templateId'])){
			$templateId = $_GET['templateId'];
		}else{
			$templateId = 0;
		}
		foreach($orderids as $orderId)
		{
		
			//$orderId = (int) $_REQUEST['o'];
			$this->GetOrderDetail($orderId);
			
			$query = "
				SELECT requeststatus
				FROM [|PREFIX|]requests
				WHERE orderid=".$orderId."
			";
			$isExistItem = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			$canResend = true;
			
			if($isExistItem){
				if(isset($_REQUEST['resend']) && $_REQUEST['resend']==1)
					$canResend = true;
				else
					$canResend = false;
			}
			
			$this->RecordReviewRequest($orderId, $canResend,$templateId);
			
			if(!isset($GLOBALS['ReportDetail'])){
				$GLOBALS['ReportDetail'] = '';
			}
			
			if (isId($orderId) && $canResend && isset($GLOBALS['contactEmail']) && $this->SendRequestByEmail($GLOBALS['contactEmail'])) {
				//echo '1';
				$success++;
				$GLOBALS['ReportDetail'] .= '<tr><td>'.$orderId.'</td><td>Send Request to ['.$orderId.']</td><td>Success</td><td><input type="button" value="Resend" onclick="ResendOrdViewRequest('.$orderId.','.$templateId.')"/></td></tr>';
			} else {
				//echo '0';
				$failed++;
				
				if($canResend)
					$GLOBALS['ReportDetail'] .= '<tr><td>'.$orderId.'</td><td>Send Request to Order['.$orderId.']</td><td>Failed</td><td><input type="button" value="Resend" onclick="ResendOrdViewRequest('.$orderId.','.$templateId.')"/></td></tr>';
				else
					$GLOBALS['ReportDetail'] .= '<tr><td>'.$orderId.'</td><td>Duplicate Request to Order['.$orderId.']</td><td>Failed</td><td><input type="button" value="Resend" onclick="ResendOrdViewRequest('.$orderId.','.$templateId.')"/></td></tr>';
			}
	
			$message = sprintf(GetLang('OrderReviewRequestStatusReport'), $success);
			if ($failed) {
				$message .= sprintf(GetLang('OrderReviewRequestStatusReportFail'), $failed);
			}
			
			$GLOBALS['ReportResult'] = $message;
			
			if(isset($_COOKIE["ReportDetail"]) && isset($_COOKIE["ReportResult"])){
				setcookie("ReportDetail", $_COOKIE["ReportDetail"].$GLOBALS['ReportDetail'], time()+3600);
				setcookie("ReportResult", $GLOBALS['ReportResult'], time()+3600);
			}else{
				setcookie("ReportDetail", $GLOBALS['ReportDetail'], time()+3600);
				setcookie("ReportResult", $GLOBALS['ReportResult'], time()+3600);
			}
			
			$message .= '<a href="javascript:void(0)" onclick="ShowReportDetail()">Detail</a>';
		}
		echo MessageBox($message, MSG_SUCCESS);
		
		exit;
	}
	
	public function RecordReviewRequest($orderId, $canResend,$templateId,$addlog=true)
	{
		$query = "
			SELECT requestid, requeststatus
			FROM [|PREFIX|]requests
			WHERE orderid=".$orderId."
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$adminUser = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetUser();
		$curAdmin = isc_html_escape($adminUser['username']);
		$requestResult = '';
		//echo "canResend:".$canResend."<br>";
		if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)){
			//echo "in update process.0.".$canResend."<br/>";
			if($canResend){
				$this->UpdateReviewRequestStatus($orderId, 1,$templateId);
				$requestResult = 'Success';
			}else{
				$requestResult = 'Failed';
			}
			
			$requestId = $row['requestid'];
			$logDesc = '['.$curAdmin.'] resend a order review request to Order['.$orderId.']['.$requestResult.']';
			$logType = 1; //duplicate request
		}else{
			$req = array(
					'orderid' => $orderId,
					'requeststatus' => 1,
					'requestdate' => date('Y-m-d H:i:s',time()),
					'requestowner' => $curAdmin,
					'templateid' => $templateId
				);
			$requestId = $this->AddReviewRequestStatus($req);
			
			$logDesc = '['.$curAdmin.'] send a new order review request to Order['.$orderId.'][Success]';
			$logType = 0; //new request
		}
		
		if($addlog)
		{
			$this->LogReviewRequest($requestId, $logDesc, $logType);
		}	
	}
	
	public function AddReviewRequestStatus($req)
	{
		//echo "in insert process.";
		return $GLOBALS['ISC_CLASS_DB']->InsertQuery('requests', $req);
	}
	
	public function LogReviewRequest($requestId, $logDesc, $logType){
		$logData = array(
					'requestid' => $requestId,
					'logdate' => date('Y-m-d H:i:s',time()),
					'logdesc' => $logDesc,
					'logtype' => $logType
				);
	    $GLOBALS['ISC_CLASS_DB']->InsertQuery('request_log', $logData);
	}

	public function UpdateReviewRequestStatus($orderIds, $status,$templateId)
	{
		//echo "templateid:".$templateId."<br/>";
		//echo "in update process.0.";
		if(!is_array($orderIds)) {
			$orderIds = array($orderIds);
		}
	//echo "in update process.1.";
		foreach($orderIds as $orderId) {
			$order = GetOrder($orderId, false);
	
			if (!$order['orderid']) {
				return false;
			}
	//echo "in update process.2.";
			// Start transaction
			$GLOBALS['ISC_CLASS_DB']->Query("START TRANSACTION");
	
			$updatedStatus = array(
				'requestdate' => date('Y-m-d H:i:s',time()),
				"requeststatus" => (int)$status,
				'templateid' => $templateId
			);
			
	//echo "in update process.3.";
			// Update the status for this order review request
			if ($GLOBALS['ISC_CLASS_DB']->UpdateQuery("requests", $updatedStatus, "orderid='".$GLOBALS['ISC_CLASS_DB']->Quote($orderId)."'")) {
				// Log this action if we are in the control panel
				//echo "in update process.3.";
				if (defined('ISC_ADMIN_CP')) {
					//$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($orderId, $statusName);
				}
			}
			// Was there an error? If not, commit
			if ($GLOBALS['ISC_CLASS_DB']->Error() == "") {
				$GLOBALS['ISC_CLASS_DB']->Query("COMMIT");
				return true;
			}
			else {
				//echo $GLOBALS['ISC_CLASS_DB']->Error();
				return false;
			}
		}
	
		return false;
	}
	
	// Get the details for this order from the database
	public function GetOrderDetail($orderId,$type="review")
	{
		$GLOBALS['RequestLogs'] = "";
		/*if($type == "review")
		{
			$GLOBALS['RequestLogs'] = "yes";
		}*/
		$GLOBALS['HideRequestLogs'] = "display: none";
		$logQuery = "
			SELECT * 
		    FROM [|PREFIX|]request_log rl
		  	LEFT JOIN [|PREFIX|]requests r ON (r.requestid=rl.requestid)
		    WHERE r.orderid='".$orderId."' 
		  	ORDER BY logdate ASC
		";
		$logResult = $GLOBALS['ISC_CLASS_DB']->Query($logQuery);

		while($log = $GLOBALS['ISC_CLASS_DB']->Fetch($logResult)) {
			$GLOBALS['RequestLogs'] .= "<p>At [".$log['logdate']."]: ".$log['logdesc']."</p>";
		}
		
		// should hide request logs
		/*if($GLOBALS['RequestLogs']!=""){
			$GLOBALS['HideRequestLogs'] = "";
		}*/
		
		$GLOBALS['OrderReviewLink'] = GetConfig('ShopPath')."/order/review/".$orderId;
		$query = "
			SELECT o.*, CONCAT(custconfirstname, ' ', custconlastname) AS custname, custconemail, custconphone, s.zonename AS shippingzonename,
			(SELECT COUNT(messageid) FROM [|PREFIX|]order_messages WHERE messageorderid=orderid AND messagestatus='unread') AS numunreadmessages
			FROM [|PREFIX|]orders o
			LEFT JOIN [|PREFIX|]customers c ON (c.customerid=o.ordcustid)
			LEFT JOIN [|PREFIX|]shipping_zones s ON (s.zoneid=o.ordshippingzoneid)
			WHERE o.orderid='".$GLOBALS['ISC_CLASS_DB']->Quote($orderId)."'
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			// If this user is a vendor, do they have permission to acess this order?
			if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() && $row['ordvendorid'] != $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
				exit;
			}

			$GLOBALS['OrderDate'] = isc_date("d M Y H:i:s",$row['orddate']);
			$GLOBALS['ISC_CLASS_ADMIN_ORDERS'] = GetClass('ISC_ADMIN_ORDERS');
			$GLOBALS['OrderStatusOptions'] = $GLOBALS['ISC_CLASS_ADMIN_ORDERS']->GetOrderStatusOptions($row['ordstatus']);
			$GLOBALS['TrackingNo'] = $row['ordtrackingno'];
			$GLOBALS['NumMessages'] = $row['numunreadmessages'];
			$GLOBALS['contactEmail'] =  $row['custconemail'];

			if($row["numunreadmessages"] == 0) {
				$GLOBALS["HideMessages"] = "none";
			}

			if(!gzte11(ISC_LARGEPRINT)) {
				$GLOBALS["HideMessageItems"] = "none";
			}

			$row['custname'] = isc_html_escape(trim($row['custname']));
			$GLOBALS['CustomerName'] = $row['custname'];

			$GLOBALS['CouponsUsed'] = '';
			$GLOBALS['HideCouponsUsed'] = 'display: none';

			// Get the products in the order
			$query = "SELECT o.*
				FROM [|PREFIX|]order_coupons o
				WHERE ordcouporderid='" . $orderId . "'";

			$coupons = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $allcoupons = array();
            $couponcode = '';
            $GLOBALS['CouponsUsedDetails'] = '';
			while($coupon = $GLOBALS['ISC_CLASS_DB']->Fetch($coupons)) {
                $allcoupons[] = $coupon;
                if($couponcode != $coupon['ordcouponcode'])    {  
                    $couponcode = $coupon['ordcouponcode'];
				    $GLOBALS['CouponsUsed'] .= $coupon['ordcouponcode'] . ',';
				    $GLOBALS['HideCouponsUsed'] = '';
                    $CoupDetails  = "Coupon Code : ".$coupon['ordcouponcode']."<br />";
                    if($coupon['ordcoupontype']==0)    {
                        $CoupDetails  .= "Coupon Amount : ".FormatPriceInCurrency($coupon['ordcouponamount'], $row['orddefaultcurrencyid'])."<br />"; 
                    }
                    else    {
                        $CoupDetails  .= "Coupon Amount : ".$coupon['ordcouponamount']."%<br />";
                    }
                    //$CoupDetails .= "Coupon Name : ".$coupon['ordcouponcode'];
                    $GLOBALS['CouponsUsedDetails']   .= $CoupDetails;
                }
			}

			$prodFieldsArray=$GLOBALS['ISC_CLASS_ADMIN_ORDERS']->GetOrderProductFieldsData($orderId);

			// Get the products in the order
			$query = "
				SELECT o.*, p.prodname
				FROM [|PREFIX|]order_products o
				LEFT JOIN [|PREFIX|]products p ON (p.productid=o.ordprodid)
				WHERE orderorderid='" . $orderId . "'
				ORDER BY ordprodname";

			$pResult = $GLOBALS['ISC_CLASS_DB']->Query($query);

			$GLOBALS['ProductsTable'] = "<table width=\"95%\" align=\"center\" border=\"0\" cellspacing=0 cellpadding=0>";

			// Add a notice about the order containing only digitally downloadable products
			if($row['ordisdigital'] == 1) {
				$GLOBALS['ProductsTable'] .= sprintf("

					<tr>
						<td style=\"padding:5px; background-color:lightyellow\" width=\"100%%\" class=\"text\" colspan=\"2\">
							%s
						</td>
					</tr>
					<tr>
						<td colspan=\"2\">&nbsp;</td>
					</tr>
				", GetLang('DigitalOrderNotice'));
			}
			$wrappingTotal = 0;
			$originaltotal = 0; //blessen
			$originaltotal_temp = 0;
			while($pRow = $GLOBALS['ISC_CLASS_DB']->Fetch($pResult)) {
				$sku = "";

				if($pRow['ordprodsku'] != "") {
					$sku = "<br /><em>" . isc_html_escape($pRow['ordprodsku']) . "</em>";
				}

				$sStart = $sEnd = '';
				$refunded = '';
				$shippedLabel = '';
				if($pRow['ordprodqtyshipped'] > 0) {
					$shippedLabel = '<div class="Shipped">'.sprintf(GetLang('OrderProductsShippedX'), $pRow['ordprodqtyshipped']).'</div>';
				}

				if($pRow['ordprodrefunded'] > 0) {
					if($pRow['ordprodrefunded'] == $pRow['ordprodqty']) {
						$sStart = "<del>";
						$sEnd = "</del>";
						$refunded = '<div class="Refunded">'.GetLang('OrderProductRefunded').'</span>';
					}
					else {
						$refunded = '<div class="Refunded">'.sprintf(GetLang('OrderProductsRefundedX'), $pRow['ordprodrefunded']).'</div>';
					}
					$cost = $pRow['ordprodcost'] * ($pRow['ordprodqty'] - $pRow['ordprodrefunded']);
				}
				else {
					$cost = $pRow['ordprodcost'] * $pRow['ordprodqty'];
				}

				if($pRow['prodname']) {
					$pRow['ordprodname'] = "<a href='".ProdLink($pRow['prodname'])."' target='_blank'>".isc_html_escape($pRow['ordprodname'])."</a>";
				}

				$pOptions = '';
				if($pRow['ordprodoptions'] != '') {
					$options = @unserialize($pRow['ordprodoptions']);
					if(!empty($options)) {
						$pOptions = "<blockquote style=\"padding-left: 10px; margin: 0;\">";
						$comma = '';
						foreach($options as $name => $value) {
							$pOptions .= $comma.isc_html_escape($name).": ".isc_html_escape($value);
							$comma = '<br />';
						}
						$pOptions .= "</blockquote>";
					}
				}
                
                $prodYMMInfo = '';
                
                if($pRow['ordyear'] != '' || $pRow['ordmake'] != '' || $pRow['ordmodel'] != '')    {
                    $prodYMMInfo = "<blockquote style=\"padding-left: 0px; margin: 0;\">";
                    $prodYMMInfo .= $pRow['ordyear']."&nbsp;".$pRow['ordmake']."&nbsp;".$pRow['ordmodel'];
                    $prodYMMInfo .= "</blockquote>"; 
                }
				$origPrice = $pRow['ordprodcost'] * $pRow['ordprodqty']; // initializing to zero
                if(count($allcoupons))    {                       //$pRow['ordoriginalprice'] < $pRow['ordprodcost'] 
                    if($pRow['ordoriginalprice'] > $pRow['ordprodcost'])    { 
                        $prodYMMInfo .= "<blockquote style=\"padding-left: 0px; margin: 0;\">";
                        $origPrice    = $pRow['ordoriginalprice'] * $pRow['ordprodqty'];                          
                        $prodYMMInfo .= '<u>Original Price : '. FormatPriceInCurrency($origPrice, $row['orddefaultcurrencyid'])."<br />";
                        $DiscountAmt = number_format($pRow['ordoriginalprice'] - $pRow['ordprodcost'], 2);  
                        $prodYMMInfo .= 'Discount : '.FormatPriceInCurrency($DiscountAmt, $row['orddefaultcurrencyid'])."</u>";  
                        $prodYMMInfo .= "</blockquote>"; 
                    }       
                }

				if($pRow['ordprodwrapcost'] > 0) {
					$wrappingTotal += $pRow['ordprodwrapcost'] * $pRow['ordprodqty'];
				}

				$giftOptions = '';
				if($pRow['ordprodwrapname']) {
					$giftOptions .= "<tr><td height='18' class='QuickGiftWrapping text' colspan='2'><div>";
					$giftOptions .= GetLang('GiftWrapping').": ".isc_html_escape($pRow['ordprodwrapname']);
					$giftOptions .= " [<a href='#' onclick=\"\$.iModal({type: 'ajax', url: 'remote.php?remoteSection=orders&w=viewGiftWrappingDetails&orderprodid=".$pRow['orderprodid']."'}); return false;\">".GetLang('ViewDetails')."</a>]";
					$giftOptions .= "</div></td></tr>";
				}

				$prodFields= '';
				if(isset($prodFieldsArray[$pRow['orderprodid']])) {
					$prodFields = $this->GetOrderProductsFieldsRow($prodFieldsArray[$pRow['orderprodid']]);
				}

				$eventDate='';
				if ($pRow['ordprodeventdate'] != null) {
					$eventDate = '<tr><td style="padding:5px 0px 5px 15px;">'.$pRow['ordprodeventname'] . ': ' . isc_date('jS M Y', $pRow['ordprodeventdate']) . '</tr>';
				}

				$itemDetails = '';
				if($shippedLabel || $refunded) {
					$itemDetails = "<tr><td class='text' colspan='2' style='padding-left: 20px;'>";
					$itemDetails .= $shippedLabel.$refunded;
					$itemDetails .= '</td></tr>';
				}

				$GLOBALS['ProductsTable'] .= "
					<tr>
						<td style=\"padding-left:12px; padding-top:5px\" width=\"70%\" class=\"text\">".$sStart.$pRow['ordprodqty']." x ".$pRow['ordprodname'].$sEnd.$sku.$pOptions.$prodYMMInfo."</td>
						<td class=\"text\" width=\"30%%\" align=\"right\">".FormatPriceInCurrency($cost, $row['orddefaultcurrencyid'])."</td>
					</tr>
					".$giftOptions.$eventDate.$prodFields.$itemDetails."
				";

				$originaltotal = $originaltotal + $origPrice;
				$originaltotal_temp = $originaltotal_temp + $cost;
			}


			if ($originaltotal == 0)   $originaltotal = $originaltotal_temp;


			$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", 'Original Total', FormatPriceInCurrency($originaltotal, $row['orddefaultcurrencyid']));

			$GLOBALS['ProductsTable'] .= "<tr><td colspan='2'><hr noshade size='1'></td></tr>";

			$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", GetLang('SubTotal'), FormatPriceInCurrency($row['ordsubtotal'], $row['orddefaultcurrencyid']));

			if($wrappingTotal > 0) {
				$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", GetLang('GiftWrapping'), FormatPriceInCurrency($wrappingTotal, $row['orddefaultcurrencyid']));
			}

			// Do we need to show a shipping cost?
			if($row['ordshipmethod'] != "" && $row['ordshipcost'] > 0) {
				$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", GetLang('Shipping'), FormatPriceInCurrency($row['ordshipcost'], $row['orddefaultcurrencyid']));
			}

			// Do we need to show a handling fee?
			if($row['ordhandlingcost'] > 0) {
				$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", GetLang('Handling'), FormatPriceInCurrency($row['ordhandlingcost'], $row['orddefaultcurrencyid']));
			}

			if ($row['orddateshipped'] > 0) {
				$GLOBALS['ShippingDate'] = isc_date(GetConfig('DisplayDateFormat'), $row['orddateshipped']);
			} else {
				$GLOBALS['ShippingDate'] = GetLang('NA');
			}

			// Do we need to show sales tax?
			if($row['ordtaxtotal'] > 0 && $row['ordtotalincludestax'] == 0) {
				if($row['ordtaxname']) {
					$taxName = isc_html_escape($row['ordtaxname']);
				}
				else {
					$taxName = GetLang('SalesTax');
				}
				$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", $taxName, FormatPriceInCurrency($row['ordtaxtotal'], $row['orddefaultcurrencyid']));
			}

			$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='QuickTotal text' align='right'>%s:</td><td class='QuickTotal text' align='right'>%s</td></tr>", GetLang('Total'), FormatPriceInCurrency($row['ordtotalamount'], $row['orddefaultcurrencyid']));

			// Do we need to show sales tax that was already included in the totals? We show it after the order total
			if($row['ordtaxtotal'] > 0 && $row['ordtotalincludestax'] == 1) {
				if($row['ordtaxname']) {
					$taxName = isc_html_escape($row['ordtaxname']);
				}
				else {
					$taxName = GetLang('SalesTax');
				}
				$taxName .= ' '.GetLang('IncludedInTotal');
				$GLOBALS['ProductsTable'] .= sprintf("<tr><td height='18' class='text' align='right'>%s:</td><td class='text' align='right'>%s</td></tr>", $taxName, FormatPrice($row['ordtaxtotal']));
			}

			if (isset($row['ordpaymentstatus'])) {
				if ($row['ordpaymentstatus'] == 'refunded' || $row['ordpaymentstatus'] == 'partially refunded') {
					$GLOBALS['ProductsTable'] .= '<tr><td class="text" align="right" height="18">'.GetLang('Refunded').':</td><td class="text" align="right">'.FormatPriceInCurrency($row['ordrefundedamount'], $row['orddefaultcurrencyid']).'</td></tr>';
				}
			}

			$GLOBALS['ProductsTable'] .= "</table>";

			$GLOBALS['OrderComments'] = '';
			if (trim($row['ordcustmessage']) != '') {
				$GLOBALS['OrderComments'] = nl2br(isc_html_escape($row['ordcustmessage']));
			}
			else {
				$GLOBALS['HideOrderComments'] = 'display: none';
			}
			
			$GLOBALS['OrderDetails'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("OrderDetail");						
		} else {
			//echo GetLang('OrderDetailsNotFound');
		}
	}
	
	public function paserRequestTemplate($templateId, $type='preview'){
		if($type == 'email'){
			$this->GetOrderDetail($_REQUEST['o'],"eamil");
		}else{
			$this->GetOrderDetail($_REQUEST['orderId'],"review");
		}
		
		$showContent = '';
		$requestTemplate = '';
		$query = "select request_script_value,coupon_code from [|PREFIX|]order_review_request where id='".$templateId."'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		
		if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			
			$coupon_code_hint ="";
			if(!empty($row['coupon_code']))
			{
				$coupon_code_hint = GetLang('CouponCodeHint').$row['coupon_code'];
			}
			//coupon code should not be included in the email
			/*if($type == 'email'){
				$coupon_code_hint = "";
			}*/
			$coupon_code_hint = "";
			$order_reviewlink = sprintf("<a href='%s' target='_blank'>%s</a>",$GLOBALS['OrderReviewLink'],GetLang('OrderReviewLinkTitle'));
			$replaceArr = array(
				'<!--ORDER_DATE-->' => $GLOBALS['OrderDate'],
				'<!--ORDER DATE-->' => $GLOBALS['OrderDate'],
				'<!--ORDER_DETAILS-->' => $GLOBALS['OrderDetails'],
				'<!--ORDER_REVIEW_LINK-->' => $order_reviewlink,
			'<!--ORDER_COUPON_CODE-->' => $coupon_code_hint
			);
			
			$requestTemplate = $row['request_script_value'];
			$requestTemplate = str_ireplace("/admin/","",$requestTemplate);
			$requestTemplate = htmlspecialchars_decode($requestTemplate);
			foreach($replaceArr as $replaceReg => $replaceText){
				$requestTemplate = str_replace($replaceReg, $replaceText, $requestTemplate);
				
			}
		}
		
		if($type == 'preview'){
			$showContent = $requestTemplate;
		}else if($type == 'email'){
			$GLOBALS['RequestDetail'] = $requestTemplate;
			$emailTemplate = FetchEmailTemplateParser();
			$emailTemplate->SetTemplate("order_reviewrequest_email");
			$showContent = $emailTemplate->ParseTemplate(true);
		}
		
		return $showContent;
	}
	
	private function SendRequestByEmail($email)
	{
		//load the template for email, e.g. $email = "wirror.yin@nirvana-info.com";
		$templateId=1;
		if(isset($_GET['templateId']) && is_numeric($_GET['templateId']))
		{
			$templateId= (int)$_GET['templateId'];
		}
		$message = $this->paserRequestTemplate($templateId, 'email');

	    // Create a new email API object to send the email
		$store_name = GetConfig('StoreName');
		$subject = sprintf(GetLang('ReviewRequestEmailSubject'), $store_name);
		require_once(ISC_BASE_PATH . "/lib/email.php");
		$obj_email = GetEmailClass();
		$obj_email->Set('CharSet', GetConfig('CharacterSet'));
		$obj_email->From(GetConfig('OrderEmail'), $store_name);
		$obj_email->Set('Subject', $subject);
		$obj_email->AddBody("html", $message);
		$obj_email->AddRecipient($email, "", "h");
		//$obj_email->AddAttachmentData($data, $name);
		$email_result = $obj_email->Send();
		return true;
	}
	
	/**
	 * Generate the 'Quick View' for a particular request.
	 *
	 * @param int The request ID.
	 * @return string The generated quick view for the request.
	 */
	public function PreviewRequest()
	{
		if(!isset($_REQUEST['orderId'])) {
			exit;
		}

		$order = GetOrder($_REQUEST['orderId'], true);
		/*
		if(!isset($order['orderid']) || $order['ordisdigital'] == 1 || ($order['ordtotalqty']-$order['ordtotalshipped']) <= 0) {
			exit;
		}
		*/
		$GLOBALS['OrderId'] = $order['orderid'];
		$GLOBALS['OrderDate'] = CDate($order['orddate']);
		
		if(isset($_GET['templateId'])){
			$templateId = $_GET['templateId'];
		}else{
			$templateId = 1;
		}
		$GLOBALS['TemplateId'] = $templateId;
		$GLOBALS['PreviewTemplate'] = $this->paserRequestTemplate($templateId);
		
		$GLOBALS['RemindMessage'] = GetLang('PreviewReviewIntro');
		$GLOBALS['ShowSendBtn'] = '';
		$query = "
			SELECT *
			FROM [|PREFIX|]requests
			WHERE orderid=".$GLOBALS['OrderId']."
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		
		if($row = $GLOBALS['ISC_CLASS_DB']->fetch($result)){
			if($row['requeststatus'] == 2){
				$GLOBALS['ShowSendBtn'] = 'none';
				$GLOBALS['RemindMessage'] = GetLang('NoResendWarning');
			}else{
				$GLOBALS['RemindMessage'] = sprintf(GetLang('ResendWarning'), $row['requestdate'], $row['requestowner']);
				//$this->RecordReviewRequest($order['orderid'], true,$templateId,false);				
			}			
		}
		else
		{
			//$this->RecordReviewRequest($order['orderid'], true,$templateId,false);
		}
		
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('requests.preview');
		return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	/**
	 * Show the form to create a new request from one or more items in an order.
	 */
	public function CreateRequest()
	{
		if (array_key_exists('orders', $_REQUEST)) {
			if(isset($_GET['templateId'])){
				$templateId = $_GET['templateId'];
			}else{
				$templateId = 0;
			}
			$GLOBALS['TemplateId'] = $templateId;
			$GLOBALS['JavaScriptOrderIds'] = $_REQUEST['orders'];
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("orders.sendrequest.popup");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
		}
	}

	/**
	 * Delete one or more selected shipments from the database.
	 */
	private function DeleteRequest()
	{
		$queries = array();

		if(!isset($_POST['requests']) || !is_array($_POST['requests'])) {
			ob_end_clean();
			header('Location: index.php?ToDo=viewRequests');
			exit;
		}

		$GLOBALS['ISC_CLASS_DB']->StartTransaction();

		// Make sure the user actually has permission to delete these requests
		$shipmentIds = implode(',', array_map('intval', $_POST['requests']));
		$vendorId = $GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId();
		if($vendorId > 0) {
			$query = "
				SELECT equestid
				FROM [|PREFIX|]requests
				WHERE equestid IN (".$requestIds.") AND shipvendorid='".(int)$vendorId."'
			";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$requestIds = array(0);
			while($request = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$requestIds[] = $request['requestid'];
			}
			$requestIds = implode(',', $requestIds);
		}

		$updatedOrders = array();
		$query = "
			SELECT s.itemordprodid, s.itemqty, p.ordprodqtyshipped, p.orderorderid, p.orderprodid
			FROM [|PREFIX|]request_items s
			INNER JOIN [|PREFIX|]order_products p ON (p.orderprodid=s.itemordprodid)
			WHERE s.shipid IN (".$requestIds.")
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($shippedItem = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$shippedQty = $shippedItem['ordprodqtyshipped'] - $shippedItem['itemqty'];
			if(!isset($updatedOrders[$shippedItem['orderorderid']])) {
				$updatedOrders[$shippedItem['orderorderid']] = $shippedItem['itemqty'];
			}
			else {
				$updatedOrders[$shippedItem['orderorderid']] += $shippedItem['itemqty'];
			}
			if($shippedQty < 0) {
				$shippedQty = 0;
			}
			$updatedProduct = array(
				'ordprodqtyshipped' => $shippedQty
			);
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery('order_products', $updatedProduct, "orderprodid='".$shippedItem['orderprodid']."'");
		}

		foreach($updatedOrders as $orderId => $adjustment) {
			$query = "
				UPDATE [|PREFIX|]orders
				SET ordtotalshipped=IF(ordtotalshipped-".$adjustment." > 0, ordtotalshipped-".$adjustment.", 0)
				WHERE orderid='".$orderId."'
			";
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}

		// Now it's safe to delete the requests
		$GLOBALS['ISC_CLASS_DB']->DeleteQuery('requests', "WHERE requestid IN (".$requestIds.")");
		$GLOBALS['ISC_CLASS_DB']->DeleteQuery('request_items', "WHERE shipid IN (".$requestIds.")");

		if(!$GLOBALS['ISC_CLASS_DB']->GetErrorMsg()) {
			$GLOBALS['ISC_CLASS_DB']->CommitTransaction();
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['requests']));
			FlashMessage('The selected requests have been deleted successfully.', MSG_SUCCESS, 'index.php?ToDo=viewRequests');
		}
		// If there was an error, redirect and show the error
		else {
			$GLOBALS['ISC_CLASS_DB']->RollbackTransaction();
			FlashMessage($GLOBALS['ISC_CLASS_DB']->GetErrorMsg(), MSG_ERROR, 'index.php?ToDo=viewRequests');
		}
	}

	/**
	 * Create a new view for requests.
	 */
	private function CreateView()
	{
		$GLOBALS['BreadcrumEntries'][GetLang('CreateShipmentView')] = '';
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('requests.view');
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
	}

	/**
	 * Delete a custom view for requests.
	 */
	private function DeleteCustomSearch()
	{
		// Deleting the view failed, show an error
		if(!$GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->DeleteSearch($_GET['searchId'])) {
			FlashMessage(GetLang('DeleteCustomSearchFailed'), MSG_ERROR, 'index.php?ToDo=viewRequests');
		}
		// View was deleted successfully, redirect
		else {
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($_GET['searchId']);
			FlashMessage(GetLang('DeleteCustomSearchSuccess'), MSG_SUCCESS, 'index.php?ToDo=viewRequests');
		}
	}

	/**
	 * Perform a custom view search for requests.
	 */
	private function CustomSearch()
	{
		if(!isset($_REQUEST['searchId'])) {
			ob_end_clean();
			header('Location: index.php?ToDo=viewRequests');
			exit;
		}

		SetSession('requestsearch', (int)$_GET['searchId']);
		$this->customSearch = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->LoadSearch($_GET['searchId']);
		$_REQUEST = array_merge($_REQUEST, $this->customSearch['searchvars']);

		$GLOBALS['BreadcrumEntries'][GetLang('CustomView')] = '';
		$this->ManageRequests();
	}

	/**
	 * Redirect from the search page to the listing of request search results.
	 */
	private function SearchRequestsRedirect()
	{
		// Are we saving this as a view?
		if(isset($_GET['viewName']) && $_GET['viewName'] != '') {
			$searchId = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->SaveSearch($_GET['viewName'], $_GET);

			if($searchId > 0) {
				// Log the action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($searchId, $_GET['viewName']);

				// Redirect to the actual search
				FlashMessage(GetLang('CustomSearchSaved'), MSG_SUCCESS, 'index.php?ToDo=customShipmentSearch&searchId='.$searchId.'&new=true');
			}
			else {
				$message = sprintf(GetLang('ViewAlreadyExists'), isc_html_escape($_GET['viewName']));
				FlashMessage($message, MSG_ERROR, 'index.php?ToDo=viewRequests');
			}
		}

		// Otherwise, just a normal search
		$GLOBALS['BreadcrumEntries'][GetLang('SearchResults')] = '';
		$this->ManageRequests();
	}

	/**
	 * Show the form to search requests.
	 */
	private function SearchRequests()
	{
		$GLOBALS['BreadcrumEntries'][GetLang('SearchRequests')] = '';
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('requests.search');
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
	}

	/**
	 * Show the 'View Requests' page.
	 */
	private function ManageRequests()
	{
		$numViews = 0;

		// Fetch any requests and place them in the data grid
		$GLOBALS['ShipmentDataGrid'] = $this->ManageRequestsGrid();

		// Was this an ajax based sort? Return the table now
		if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
			echo $GLOBALS['ShipmentDataGrid'];
			return;
		}

		$GLOBALS['HideClearResults'] = 'display: none';
		if(isset($_REQUEST['searchQuery']) || isset($_GET['searchId'])) {
			$GLOBALS['HideClearResults'] = "";
		}

		if(isset($this->customSearch['searchname'])) {
			$GLOBALS['ViewName'] = isc_html_escape($this->customSearch['searchname']);
		}
		else {
			$GLOBALS['ViewName'] = GetLang('AllRequests');
			$GLOBALS['HideDeleteViewLink'] = 'display: none';
		}

		$GLOBALS['Message'] = GetFlashMessageBoxes();

		// Do we need to disable the delete button?
		if(!$GLOBALS['ShipmentDataGrid']) {
			$GLOBALS['DisableDelete'] = 'disabled="disabled"';
			$GLOBALS['DisableExport'] = 'disabled="disabled"';
		}
		// Otherwise, we have one or more results
		else {
			if(!$GLOBALS['Message'] && count($_GET) > 1) {
				if($this->numShipmentResults = 1) {
					$message = GetLang('ShipmentSearchResultsBelow1');
				}
				else {
					$message = sprintf(GetLang('ShipmentSearchResultsBelowX'), $this->numShipmentResults);
				}
				$GLOBALS['Message'] = MessageBox($message, MSG_SUCCESS);
			}
		}

		// Grab the custom views in a list
		if(!isset($_REQUEST['searchId'])) {
			$selectedSearch = 0;
			$GLOBALS['HideDeleteCustomView'] = 'display: none';
		}
		else {
			$selectedSearch = $_REQUEST['searchId'];
			$GLOBALS['HideDeleteCustomView'] = '';
			$GLOBALS['CustomViewId'] = (int)$_REQUEST['searchId'];
		}
		$GLOBALS['CustomViews'] = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->GetSearchesAsOptions($selectedSearch, $numViews, 'AllRequests', 'viewRequests', 'customShipmentSearch');

		// If we have nothing to show, show.. nothing?
		if(!$GLOBALS['ShipmentDataGrid']) {
			$GLOBALS['DisplayGrid'] = 'display: none';

			if(count($_GET) > 1) {
				$GLOBALS['Message'] = MessageBox(GetLang('NoShipmentResults'), MSG_ERROR);
			}
			else {
				$GLOBALS['Message'] = MessageBox(GetLang('NoRequests'), MSG_SUCCESS);
				$GLOBALS['DisplaySearch'] = 'display: none';
			}
		}

		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('requests.manage');
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
	}

	/**
	 * Generate the grid that shows the request results in it.
	 *
	 * @return string The generated grid of requests for the current page.
	 */
	private function ManageRequestsGrid()
	{
		$page = 0;
		$start = 0;
		$numPages = 0;

		$requestGrid = '';
		$GLOBALS['Nav'] = '';

		// Is this a custom view?
		if(isset($_GET['searchId'])) {
			$this->customSearch = $GLOBALS['ISC_CLASS_ADMIN_CUSTOMSEARCH']->LoadSearch($_GET['searchId']);
			$_REQUEST = array_merge($_REQUEST, (array)$this->customSearch['searchvars']);

			// Override the sort fields of the view
			if(isset($_GET['sortField'])) {
				$_REQUEST['sortField'] = $_GET['sortField'];
			}

			if(isset($_GET['sortOrder'])) {
				$_REQUEST['sortOrder'] = $_GET['sortOrder'];
			}
		}
		else if(isset($_REQUEST['searchQuery'])) {
			$GLOBALS['Query'] = isc_html_escape($_GET['searchQuery']);
		}

		// Validate the sort order
		if(isset($_REQUEST['sortOrder']) && $_REQUEST['sortOrder'] == 'asc') {
			$sortOrder = 'asc';
		}
		else {
			$sortOrder = 'desc';
		}

		// Which fields can we sort by?
		$validSortFields = array(
			'requestid',
			'shipdate',
			'shiporderid',
			'shiporderdate',
			'shipfullname',
		);
		if(isset($_REQUEST['sortField']) && in_array($_REQUEST['sortField'], $validSortFields)) {
			$sortField = $_REQUEST['sortField'];
			SaveDefaultSortField('ManageRequests', $_REQUEST['sortField'], $sortOrder);
		}
		else {
			list($sortField, $sortOrder) = GetDefaultSortField('ManageRequests', 'requestid', $sortOrder);
		}

		if (isset($_GET['page'])) {
			$page = (int)$_GET['page'];
		} else {
			$page = 1;
		}

		// Build the pagination and sort URL
		$searchURL = '';
		foreach($_GET as $k => $v) {
			if($k == "sortField" || $k == "sortOrder" || $k == "page" || $k == "new" || $k == "ToDo" || !$v) {
				continue;
			}
			$searchURL .= '&'.$k.'='.urlencode($v);
		}
		$sortURL = $searchURL.'&sortField='.$sortField.'&sortOrder='.$sortOrder;
		$GLOBALS['SortURL'] = $sortURL;

		// Limit the number of requests returned
		if($page == 1) {
			$start = 0;
		}
		else {
			$start = ($page-1) * ISC_SHIPMENTS_PER_PAGE;
		}

		// Grab the queries we'll be executing
		$requestQueries = $this->BuildShipmentSearchQuery($start, $sortField, $sortOrder);

		// How many results do we have?
		$numRequests = $GLOBALS['ISC_CLASS_DB']->FetchOne($requestQueries['countQuery']);
		$numPages = ceil($numRequests / ISC_SHIPMENTS_PER_PAGE);

		// Add the "(Page x of y)" label
		if($numRequests > ISC_SHIPMENTS_PER_PAGE) {
			$GLOBALS['Nav'] = '('.GetLang('Page').' '.$page.' '.GetLang('Of').' '.$numPages.')&nbsp;&nbsp;&nbsp;';
			$GLOBALS['Nav'] .= BuildPagination($numRequests, ISC_SHIPMENTS_PER_PAGE, $page, 'index.php?ToDo=viewRequests'.$sortURL);
		}
		else {
			$GLOBALS['Nav'] = '';
		}

		$GLOBALS['SortField'] = $sortField;
		$GLOBALS['SortOrder'] = $sortOrder;
		$sortLinks = array(
			'Id' => 'requestid',
			'Date' => 'shipdate',
			'OrderId' => 'shiporderid',
			'OrderDate' => 'shiporderdate',
			'Name' => 'shipfullname'
		);
		BuildAdminSortingLinks($sortLinks, 'index.php?ToDo=viewRequests&amp;'.$searchURL.'&amp;page='.$page, $sortField, $sortOrder);

		$result = $GLOBALS['ISC_CLASS_DB']->Query($requestQueries['query']);

		// Display the requests
		while($request = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$GLOBALS['ShipmentId'] = $request['requestid'];
			$GLOBALS['OrderId'] = $request['shiporderid'];

			$GLOBALS['Date'] = isc_date(GetConfig('DisplayDateFormat'), $request['shipdate']);
			$GLOBALS['OrderDate'] = isc_date(GetConfig('DisplayDateFormat'), $request['shiporderdate']);

			// If the customer still exists, link to the customer page
			$GLOBALS['ShippedTo'] = isc_html_escape($request['shipshipfirstname'].' '.$request['shipshiplastname']);

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('requests.manage.row');
			$requestGrid .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		if(!$requestGrid) {
			return '';
		}

		$GLOBALS['ShipmentGrid'] = $requestGrid;
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate('requests.manage.grid');
		return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
	}
}
?>