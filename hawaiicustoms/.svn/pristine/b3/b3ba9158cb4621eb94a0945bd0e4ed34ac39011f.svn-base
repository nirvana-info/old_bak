<?php
class ISC_ADMIN_SALES extends ISC_ADMIN_STATISTICS 
{
    /**
    *    Show statistics for products
    */
    public function SalesStats()
    {
        //zfang_20100623: Fetching calendar options, use $calendarInfo instead of $_POST['Calendar']        
        if(isset($_POST['Calendar'])) {
            $calendarInfo = NULL;
            if (isset($_POST['Calendar']['DateType'])) {
                $GLOBALS['CurrentDate'] = $_POST['Calendar']['DateType'];
                $calendarInfo['DateType'] = $GLOBALS['CurrentDate'];
                if(isset($_POST['Calendar']['From'])) {
                    $datestamp = strtotime($_POST['Calendar']['From']);
                    $calendarInfo['From']['Yr'] = gmdate('Y', $datestamp);
                    $calendarInfo['From']['Mth'] = gmdate('m', $datestamp);
                    $calendarInfo['From']['Day'] = gmdate('d', $datestamp);
                }
                if(isset($_POST['Calendar']['To'])){
                    $datestamp = strtotime($_POST['Calendar']['To']);
                    $calendarInfo['To']['Yr'] = gmdate('Y', $datestamp);
                    $calendarInfo['To']['Mth'] = gmdate('m', $datestamp);
                    $calendarInfo['To']['Day'] = gmdate('d', $datestamp);
                }
            else {
                
                $GLOBALS['CurrentDate'] = "Last24Hours";
                $calendarInfo['DateType'] = $GLOBALS['CurrentDate'];
            }
            }
            $cal = $this->CalculateCalendarRestrictions($calendarInfo);
            $GLOBALS['CurrentDate'] = $_POST['Calendar']['DateType'];
        }
        else {
            $cal = $this->CalculateCalendarRestrictions();
            $GLOBALS['CurrentDate'] = "Last24Hours";
        }

        $GLOBALS['CalendarDateTypeOptions'] = $this->_GetCalendarDateTypesAsOptions($GLOBALS['CurrentDate']);

        if(isset($_POST['currentTab'])) {
            $GLOBALS['CurrentTab'] = (int)$_POST['currentTab'];
        }
        else {
            $GLOBALS['CurrentTab'] = 0;
        }
        
        // Set the global variables for the select boxes
        $from_stamp = $cal['start'];
        $to_stamp = $cal['end'];

        $from_day = isc_date("d", $from_stamp);
        $from_month = isc_date("m", $from_stamp);
        $from_year = isc_date("Y", $from_stamp);

        $to_day = isc_date("d", $to_stamp);
        $to_month = isc_date("m", $to_stamp);
        $to_year = isc_date("Y", $to_stamp);

        $GLOBALS['OverviewFromDays'] = $this->_GetDayOptions($from_day);
        $GLOBALS['OverviewFromMonths'] = $this->_GetMonthOptions($from_month);
        $GLOBALS['OverviewFromYears'] = $this->_GetYearOptions($from_year);

        $GLOBALS['OverviewToDays'] = $this->_GetDayOptions($to_day);
        $GLOBALS['OverviewToMonths'] = $this->_GetMonthOptions($to_month);
        $GLOBALS['OverviewToYears'] = $this->_GetYearOptions($to_year);

                
        $GLOBALS['FromStamp'] = $from_stamp;
        $GLOBALS['ToStamp'] = $to_stamp;

        $vendorRestriction = $this->GetVendorRestriction();
        if($vendorRestriction !== false) {
            $GLOBALS['VendorId'] = (int)$vendorRestriction;
        }
        else {
            $GLOBALS['VendorId'] = '';
        }

        // If we can, get a list of the available vendors
        $GLOBALS['HideVendorList'] = 'display: none';
        if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() == 0 && gzte11(ISC_HUGEPRINT)) {
            $GLOBALS['VendorSelect'] = '';
            // All vendors option
            $sel = '';
            if (!isset($_REQUEST['vendorId']) || $_REQUEST['vendorId'] == "") {
                $sel = 'selected="selected"';
            }
            $GLOBALS['VendorSelect'] .= "<option value='' ".$sel.">".GetLang('AllVendors')."</option>";

            // No vendor option
            $sel = '';
            if(isset($_REQUEST['vendorId']) && $_REQUEST['vendorId'] == "0") {
                $sel = 'selected="selected"';
            }
            $GLOBALS['VendorList'] = $this->GenerateVendorList($VendorID);
            $GLOBALS['CurrentVendor'] = $this->GenerateVendorName($VendorID);
            
            $GLOBALS['VendorSelect'] .= "<option value='0' ".$sel.">".GetLang('NoSelVendor')."</option>";
            $query = "
                SELECT vendorid, vendorname
                FROM [|PREFIX|]vendors
                ORDER BY vendorname ASC
            ";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $hasVendors = false;
            while($vendor = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $hasVendors = true;
                $sel = '';
                if(isset($_REQUEST['vendorId']) && $_REQUEST['vendorId'] == $vendor['vendorid']) {
                    $sel = 'selected="selected"';
                }
                $GLOBALS['VendorSelect'] .= "<option value='".$vendor['vendorid']."' ".$sel.">".isc_html_escape($vendor['vendorname'])."</option>";
            }
            if($hasVendors) {
                $GLOBALS['HideVendorList'] = '';
            }
        }

        /**
         * Hide the inventory screen if we are starter
         */
        /*if (!gzte11(ISC_MEDIUMPRINT)) {
            $GLOBALS['HideInventoryTab'] = 'none';
            $GLOBALS['ShowInventoryGrid'] = '0';
        } else {
            $GLOBALS['HideInventoryTab'] = '';
            $GLOBALS['ShowInventoryGrid'] = '1';
        } */

        //zfang_20100623: Showing date range seletion
        $GLOBALS['FromDatePicker'] = $this->getDatePickerHtml("fromPicker", "Calendar[From]", isc_date('m/d/Y', $from_stamp));
        $GLOBALS['ToDatePicker'] = $this->getDatePickerHtml("toPicker", "Calendar[To]", isc_date('m/d/Y', $to_stamp));

        $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sales.manage");
        $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
    }

    public function OverviewGrid()
    {

        $GLOBALS['OrderGrid'] = "";

        if(isset($_GET['From']) && isset($_GET['To'])) {
            $from_stamp = (int)$_GET['From'];
            $to_stamp = (int)$_GET['To'];

            // How many records per page?
            if(isset($_GET['Show'])) {
                $per_page = (int)$_GET['Show'];
            }
            else {
                $per_page = 20;
            }

            $GLOBALS['ProductsPerPage'] = $per_page;
            $GLOBALS["IsShowPerPage" . $per_page] = 'selected="selected"';

            // Should we limit the records returned?
            if(isset($_GET['Page'])) {
                $page = (int)$_GET['Page'];
            }
            else {
                $page = 1;
            }

            $GLOBALS['ProductsByNumSoldCurrentPage'] = $page;

            // Workout the start and end records
            $start = ($per_page * $page) - $per_page;
            $end = $start + ($per_page - 1);

            // Only fetch products this user can actually see
            /*$vendorRestriction = $this->GetVendorRestriction();
            $vendorSql = '';
            if($vendorRestriction !== false) {
                $vendorSql = " AND prodvendorid='" . $GLOBALS['ISC_CLASS_DB']->Quote($vendorRestriction) . "'";
            }*/

            // How many products are there in total?

            $query = "
                SELECT 
                    COUNT(*) AS num
                FROM  [|PREFIX|]users us
                    LEFT JOIN [|PREFIX|]orders od ON us.`pk_userid` = od.orderowner
                    LEFT JOIN [|PREFIX|]order_status os ON os.statusid = od.ordstatus
                WHERE 
                    od.orddate >= '" . $from_stamp . "'
                    AND od.orddate <= '" . $to_stamp . "'";

            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);

            $row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
            $total_products = $row['num'];

            if ($total_products > 0) {
                // Workout the paging
                $num_pages = ceil($total_products / $per_page);
                $paging = sprintf(GetLang('PageXOfX'), $page, $num_pages);
                $paging .= "&nbsp;&nbsp;&nbsp;&nbsp;";

                // Is there more than one page? If so show the &laquo; to jump back to page 1
                if($num_pages > 1) {
                    $paging .= "<a href='javascript:void(0)' onclick='ChangeSalesByUserPage(1)'>&laquo;</a> | ";
                }
                else {
                    $paging .= "&laquo; | ";
                }

                // Are we on page 2 or above?
                if($page > 1) {
                    $paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeSalesByUserPage(%d)'>%s</a> | ", $page-1, GetLang('Prev'));
                }
                else {
                    $paging .= sprintf("%s | ", GetLang('Prev'));
                }

                for($i = 1; $i <= $num_pages; $i++) {
                    // Only output paging -5 and +5 pages from the page we're on
                    if($i >= $page-6 && $i <= $page+5) {
                        if($page == $i) {
                            $paging .= sprintf("<strong>%d</strong> | ", $i);
                        }
                        else {
                            $paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeSalesByUserPage(%d)'>%d</a> | ", $i, $i);
                        }
                    }
                }

                // Are we on page 2 or above?
                if($page < $num_pages) {
                    $paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeSalesByUserPage(%d)'>%s</a> | ", $page+1, GetLang('Next'));
                }
                else {
                    $paging .= sprintf("%s | ", GetLang('Next'));
                }

                // Is there more than one page? If so show the &raquo; to go to the last page
                if($num_pages > 1) {
                    $paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeSalesByUserPage(%d)'>&raquo;</a> | ", $num_pages);
                }
                else {
                    $paging .= "&raquo; | ";
                }

                $paging = rtrim($paging, ' |');
                $GLOBALS['Paging'] = $paging;

                // Should we set focus to the grid?
                if(isset($_GET['FromLink']) && $_GET['FromLink'] == "true") {
                    $GLOBALS['JumpToOrdersByItemsSoldGrid'] = "<script type=\"text/javascript\">document.location.href='#ordersByItemsSoldAnchor';</script>";
                }

                if(isset($_GET['SortOrder']) && $_GET['SortOrder'] == "asc") {
                    $sortOrder = 'asc';
                }
                else {
                    $sortOrder = 'desc';
                }

                $sortFields = array('ordprodid','ordprodsku','ordprodname','revenue','numitemssold', 'totalprofit');
                if(isset($_GET['SortBy']) && in_array($_GET['SortBy'], $sortFields)) {
                    $sortField = $_GET['SortBy'];
                    SaveDefaultSortField("ProductStatsBySold", $_REQUEST['SortBy'], $sortOrder);
                }
                else {
                    list($sortField, $sortOrder) = GetDefaultSortField("ProductStatsBySold", "us.username", $sortOrder);
                }

                $sortLinks = array(
                    "ProductId" => "ordprodid",
                    "Code" => "ordprodsku",
                    "Name" => "ordprodname",
                    "UnitsSold" => "numitemssold",
                    "Revenue" => "revenue",
                    "Profit" => "totalprofit"
                );
                BuildAdminSortingLinks($sortLinks, "javascript:SortProductsByNumSold('%%SORTFIELD%%', '%%SORTORDER%%');", $sortField, $sortOrder);

                // Fetch the orders for this page
                $query = "
                    SELECT us.username, os.statusid, os.statusdesc,od.ordtotalamount
                    FROM  [|PREFIX|]users us
                        LEFT JOIN [|PREFIX|]orders od ON us.`pk_userid` = od.orderowner
                        LEFT JOIN [|PREFIX|]order_status os ON os.statusid = od.ordstatus
                    WHERE 
                        od.orddate >= '" . $from_stamp . "'
                        AND od.orddate <= '" . $to_stamp . "'
                    ORDER BY " .
                         $sortField . " " . $sortOrder;

                // Add the Limit
                //$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, $per_page);
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
                    $orders=array();
                    while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                        
                        if(!isset($orders[$row['username']]))
                        {
                            $orders[$row['username']]['Completed'] = 0;
                            $orders[$row['username']]['Cancelled'] = 0;
                            $orders[$row['username']]['Returned'] = 0;
                            $orders[$row['username']]['Pending'] = 0; 
                              $orders[$row['username']]['TotalRevenue'] = 0;                          
                        }


                        $orders[$row['username']]['dump']='';
                        if($row['statusid']=='10') { # Completed
                            $orders[$row['username']]['Completed']++;
                            $orders[$row['username']]['TotalRevenue']+=$row['ordtotalamount'];
                        }
                        else  {
                        
                            if($row['statusid']=='5') { # Cancelled
                                $orders[$row['username']]['Cancelled']++;
                            }
                            else {
                                if($row['statusid']=='6' || $row['statusid']=='4' || $row['statusid']=='15' || $row['statusid']=='16') {  # Returned
                                    $orders[$row['username']]['Returned']++;
                                }
                                else {
                                    if($row['statusid']=='1' || $row['statusid']=='2' || $row['statusid']=='3' || $row['statusid']=='7' || $row['statusid']=='8' || $row['statusid']=='9' || $row['statusid']=='11') { #Pending
                                        $orders[$row['username']]['Pending']++;
                                    }
                                }
                            }
                        }
                    }
                    //echo "<pre>";
                    //print_r($orders);
                    $Query="SELECT username FROM isc_users order by username";
                    $userResult=$GLOBALS['ISC_CLASS_DB']->Query($Query);
                    $GLOBALS['OrderGrid'] = "";
                    $UserName= array();
                    $Completed = array();
                    $Cancelled = array();
                    $Pending = array();
                    $Returned = array();
                    $i = 0;
                    while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($userResult)) {
                        
                        $GLOBALS["UserName"] = $row['username'];
                        $GLOBALS['Completed'] = (isset($orders[$row['username']]['Completed'])?$orders[$row['username']]['Completed']:0);
                        $GLOBALS['Cancelled'] = (isset($orders[$row['username']]['Cancelled'])?$orders[$row['username']]['Cancelled']:0);
                        $GLOBALS['Pending'] =  (isset($orders[$row['username']]['Pending'])?$orders[$row['username']]['Pending']:0);
                        $GLOBALS['Returned'] = (isset($orders[$row['username']]['Returned'])?$orders[$row['username']]['Returned']:0);
                        $GLOBALS['TotalRevenue'] = (isset($orders[$row['username']]['TotalRevenue'])?$orders[$row['username']]['TotalRevenue']:0);
                       $i++; 
                       $count=$GLOBALS['Completed']+$GLOBALS['Cancelled']+$GLOBALS['Pending']+$GLOBALS['Returned'];
                       $GLOBALS['TotalRevenue']=number_format($GLOBALS['TotalRevenue'],2);
                       if($count>0){
	                       $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sales.manage.overview.row");
	                       $GLOBALS['OrderGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
                       }
                    }
                }
            }
            else {
                $GLOBALS['OrderGrid'] .= sprintf("
                    <tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
                        <td nowrap height=\"22\" colspan=\"7\">
                            <em>%s</em>
                        </td>
                    </tr>
                ", GetLang('StatsNoOrdersForDate')
                );
            }

            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sales.manage.overviewgrid");
            $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
            //$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
        }
    }

    /**
    *    Show how many times each product has been viewed
    */
    public function SalesStatsByNumViewsGrid()
    {
        $GLOBALS['OrderGrid'] = ""; 
        if(isset($_GET['From']) && isset($_GET['To'])) {
            $from_stamp = (int)$_GET['From'];
            $to_stamp = (int)$_GET['To'];
        // How many records per page?
        if(isset($_GET['Show'])) {
            $per_page = (int)$_GET['Show'];
        }
        else {
            $per_page = 20;
        }
        
        $cursortfield = '';
        if(isset($_GET['vendorId']) && $_GET['vendorId'] != '-1') {
            $cursortfield = " AND (orderowner='".$_GET['vendorId']."')";
        }

        $GLOBALS['ProductsPerPage'] = $per_page;
        $GLOBALS["IsShowPerPage" . $per_page] = 'selected="selected"';

        // Should we limit the records returned?
        if(isset($_GET['Page'])) {
            $page = (int)$_GET['Page'];
        }
        else {
            $page = 1;
        }

        $GLOBALS['salesByNumViewsCurrentPage'] = $page;

        // Workout the start and end records
        $start = ($per_page * $page) - $per_page;
        $end = $start + ($per_page - 1);

        // How many products are there in total?
        $CountQuery = "
        SELECT 
            count(*) AS num
                FROM [|PREFIX|]orders o
                    LEFT JOIN [|PREFIX|]customers c ON (o.ordcustid=c.customerid)
                    LEFT JOIN [|PREFIX|]order_status s ON (s.statusid=o.ordstatus)
                WHERE
                    o.ordstatus > 0 
                    AND o.orddate >= '" . $from_stamp . "'
                    AND o.orddate <= '" . $to_stamp . "'". $cursortfield ;
        $result = $GLOBALS['ISC_CLASS_DB']->Query($CountQuery);

        $row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
        $total_products = $row['num'];
        if ($total_products > 0) {
            //Sorting code goes by Simha
            if(isset($_GET['SortOrder']) && $_GET['SortOrder'] == "asc") {
                $sortOrder = 'asc';
            }
            else {
                $sortOrder = 'desc';
            }
            
            //changed field name and commented
            $sortFields = array('orderid','custname','orddate','ordstatus','ordtotalamount');//changed field name
            if(isset($_GET['SortBy']) && in_array($_GET['SortBy'], $sortFields)) {
                $sortField = $_GET['SortBy'];
                SaveDefaultSortField("ProductStatsByViews", $_REQUEST['SortBy'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("ProductStatsByViews", "o.orderid", $sortOrder);
            }
            
            $sortLinks = array(        
                "OrderId" => "orderid",
                "Cusname" => "custname",
                "OrdDate" => "orddate",
                "Status" => "ordstatus",
                "Total" => "ordtotalamount"
            );
            
            //Above comment and new addition belowby Simha 
            //$sortLinks = array();
            
            $numSoldCounter = '921124412848294';
            BuildAdminSortingLinks($sortLinks, "javascript:SortSalesByNumViews('%%SORTFIELD%%', '%%SORTORDER%%');", $sortField, $sortOrder);
            //Sorting code goes ends by Simha
            
            // Workout the paging
            $num_pages = ceil($total_products / $per_page);
            // Should we limit the records returned?
            if(isset($_GET['Page']) && (int)$_GET['Page']<=$num_pages) {
                $page = (int)$_GET['Page'];
            }
            else {
                $page = 1;
            }

            // Workout the start and end records
            $start = ($per_page * $page) - $per_page;
            $end = $start + ($per_page - 1);

            $paging = sprintf(GetLang('PageXOfX'), $page, $num_pages);
            $paging .= "&nbsp;&nbsp;&nbsp;&nbsp;";

            // Is there more than one page? If so show the &laquo; to jump back to page 1
            if($num_pages > 1) {
                $paging .= "<a href='javascript:void(0)' onclick='ChangeSalesViewsPage(1)'>&laquo;</a> | ";
            }
            else {
                $paging .= "&laquo; | ";
            }

            // Are we on page 2 or above?
            if($page > 1) {
                $paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeSalesViewsPage(%d)'>%s</a> | ", $page-1, GetLang('Prev'));
            }
            else {
                $paging .= sprintf("%s | ", GetLang('Prev'));
            }

            for($i = 1; $i <= $num_pages; $i++) {
                // Only output paging -5 and +5 pages from the page we're on
                if($i >= $page-6 && $i <= $page+5) {
                    if($page == $i) {
                        $paging .= sprintf("<strong>%d</strong> | ", $i);
                    }
                    else {
                        $paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeSalesViewsPage(%d)'>%d</a> | ", $i, $i);
                    }
                }
            }

            // Are we on page 2 or above?
            if($page < $num_pages) {
                $paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeSalesViewsPage(%d)'>%s</a> | ", $page+1, GetLang('Next'));
            }
            else {
                $paging .= sprintf("%s | ", GetLang('Next'));
            }

            // Is there more than one page? If so show the &raquo; to go to the last page
            if($num_pages > 1) {
                $paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeSalesViewsPage(%d)'>&raquo;</a> | ", $num_pages);
            }
            else {
                $paging .= "&raquo; | ";
            }

            $paging = rtrim($paging, ' |');
            $GLOBALS['Paging'] = $paging;

            // Should we set focus to the grid?
            if(isset($_GET['FromLink']) && $_GET['FromLink'] == "true") {
                $GLOBALS['JumpToOrdersByItemsSoldGrid'] = "<script type=\"text/javascript\">document.location.href='#ordersByItemsSoldAnchor';</script>";
            }
            //Sorting code moved to the topof this loop
            
            //Code here has been moved to the fucntion GetQueries 
            
            // Add the Limit
            $mainQuery = "SELECT o.*, c.*,us.username, s.statusdesc AS ordstatustext, CONCAT(custconfirstname, ' ', custconlastname) AS custname
                    
                FROM [|PREFIX|]orders o
                    LEFT JOIN [|PREFIX|]customers c ON (o.ordcustid=c.customerid)
                    LEFT JOIN [|PREFIX|]order_status s ON (s.statusid=o.ordstatus)
                    LEFT JOIN [|PREFIX|]users us ON us.`pk_userid` = o.orderowner 
                WHERE
                    o.ordstatus > 0 
                    AND o.orddate >= '" . $from_stamp . "'
                    AND o.orddate <= '" . $to_stamp . "' $cursortfield   
                ORDER BY " .
                         $sortField . " " . $sortOrder;

            $mainQuery .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, $per_page);      
            $result = $GLOBALS['ISC_CLASS_DB']->Query($mainQuery);

            if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                    $GLOBALS['OrderId'] = $row['orderid'];
                    $GLOBALS['CustomerId'] = $row['ordcustid'];
                    $GLOBALS['OrderId1'] = $row['orderid'];
                    $GLOBALS['Customer'] = isc_html_escape($row['custname']);

                    $GLOBALS['Date'] = isc_date(GetConfig('DisplayDateFormat'), $row['orddate']);
                    $GLOBALS['OrderStatusOptions'] = $this->GetOrderStatusOptions($row['ordstatus']);

                    $GLOBALS['Total'] = FormatPriceInCurrency($row['ordtotalamount'], $row['orddefaultcurrencyid'], null, true);
                    $GLOBALS['TrackingNo'] = isc_html_escape($row['ordtrackingno']);
                    $GLOBALS['username'] = isc_html_escape($row['username']);
                    
                    switch($row['requeststatus']){
                        case 0:
                            $orderreview = GetLang('OviewRequestNo');
                            break;
                        case 1:
                            $orderreview = GetLang('OviewRequestYes');
                            break;
                        case 2:
                            $orderreview = GetLang('OviewRequestSure');
                            break;
                        default:
                            $orderreview = GetLang('OviewRequestNo');
                            break;
                        
                    }
                    $GLOBALS['Review'] = $orderreview;
                    //Show payment status blow order status
                    $GLOBALS['PaymentStatus'] = '';
                    $GLOBALS['HidePaymentStatus'] = 'display:none;';
                    $GLOBALS['PaymentStatusColor'] = '';
                    if($row['ordpaymentstatus'] != '') {
                        $GLOBALS['HidePaymentStatus'] = '';
                        $GLOBALS['PaymentStatusColor'] = '';
                        switch($row['ordpaymentstatus']) {
                            case 'authorized':
                                $GLOBALS['PaymentStatusColor'] = 'PaymentAuthorized';
                                break;
                            case 'captured':
                                $GLOBALS['PaymentStatus'] = GetLang('Payment')." ".ucfirst($row['ordpaymentstatus']);
                                $GLOBALS['PaymentStatusColor'] = 'PaymentCaptured';
                                break;
                            case 'refunded':
                            case 'partially refunded':
                            case 'voided':
                                $GLOBALS['PaymentStatus'] = GetLang('Payment')." ".ucwords($row['ordpaymentstatus']);
                                $GLOBALS['PaymentStatusColor'] = 'PaymentRefunded';
                                break;
                        }
                    }
                    // If the allow payment delayed capture, show the link to Delayed capture
                    $GLOBALS['DelayedCaptureLink'] = '';
                    $GLOBALS['VoidLink'] = '';
                    $GLOBALS['RefundLink'] ='';
                    $transactionId = trim($row['ordpayproviderid']);

                    //if orginal transaction id exist and payment provider is currently enabled
                    if($transactionId != '' && GetModuleById('checkout', $provider, $row['orderpaymentmodule']) && $provider->IsEnabled() && !gzte11(ISC_HUGEPRINT)) {
                        //if the payment module allow delayed capture and the current payment status is authorized
                        //display delay capture option
                        if(method_exists($provider, "DelayedCapture") && $row['ordpaymentstatus'] == 'authorized') {
                            $GLOBALS['DelayedCaptureLink'] = '<option value="delayedCapture">'.GetLang('CaptureFunds').'</option>';

                            $GLOBALS['PaymentStatus'] .= '<a onclick="Order.DelayedCapture('.$row['orderid'].'); return false;" href="#">'.GetLang('CaptureFunds').'</a>';
                        }

                        //if the payment module allow void transaction and the current payment status is authorized
                        //display void option
                        if(method_exists($provider, "DoVoid") && $row['ordpaymentstatus'] == 'authorized') {
                            $GLOBALS['VoidLink'] = '<option value="voidTransaction">'.GetLang('VoidTransaction').'</option>';
                        }

                        //if the payment module allow refund and the current payment status is authorized
                        //display refund option
                        if(method_exists($provider, "DoRefund") && ($row['ordpaymentstatus'] == 'captured' || $row['ordpaymentstatus'] == 'partially refunded')) {
                            $GLOBALS['RefundLink'] = '<option value="refundOrder">'.GetLang('Refund').'</option>';
                        }
                    }
                    $GLOBALS["OrderStatusText"] = GetOrderStatusById($row['ordstatus']);
                    $GLOBALS['OrderStatusId'] = $row['ordstatus'];
                    $CustomerLink = '';
                    $CustomerId = $row['ordcustid'];
                    $custname = isc_html_escape($row['custname']);
                    if(trim($row['ordcustid']) != '0') {
                        $GLOBALS['CustomerLink'] = "<a href='index.php?ToDo=viewCustomers&amp;idFrom=$CustomerId&idTo=$CustomerId' target='_blank'>".$custname."</a>";
                    }
                    else {
                        $GLOBALS['CustomerLink'] = $row['ordbillfirstname'].' '.$row['ordbilllastname'];
                    }
                    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sales.manage.row");
                    $GLOBALS['OrderGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
                        $GLOBALS['Quickview'] ="
                        <tr id=\"trQ$OrderId\" style=\"display:none\">
                            <td></td>
                            <td colspan=\"12\" id=\"tdQ$OrderId\" class=\"QuickView\"></td>
                        </tr> ";
                }
            }
        }
        else {
            $GLOBALS['OrderGrid'] .= sprintf("
                <tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
                    <td nowrap height=\"22\" colspan=\"5\">
                        <em>%s</em>
                    </td>
                </tr>
            ", GetLang('StatsNoProducts')
            );
        }

        $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sales.manage.grid");
        $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
    }
    }
    
    public function GetOrderStatusOptions($SelectedStatus = null)
        {
            // Get all order status options from the database
            static $statuses = null;
            $output = "";

            // Only do the database query the first time
            if ($statuses === null) {
                $statuses = array();
                if($SelectedStatus === 0 || $SelectedStatus === '0') {
                    $statuses[] = array(
                        "statusid" => 0,
                        "statusdesc" => GetLang('Incomplete')
                    );
                }
                $query = "select statusid, statusdesc from [|PREFIX|]order_status order by statusorder asc";
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                    $statuses[] = $row;
                }
            }

            foreach ($statuses as $row) {
                // Only show the 0 status if it's our current status
                if($row['statusid'] == 0 && $SelectedStatus != 0) {
                    continue;
                }
                if ($row['statusid'] == $SelectedStatus) {
                    return $row['statusdesc'];
                } 

            }
        }
        
        function GenerateVendorList($VendorID) {
            
            //$query="SELECT * FROM [|PREFIX|]users";
            $query="SELECT us.pk_userid ,us.username
                    FROM  [|PREFIX|]users us
                        LEFT JOIN isc_orders od ON us.pk_userid = od.orderowner
                    WHERE not od.ordstatus  is null
                    AND od.orddate >= '" . $GLOBALS['FromStamp'] . "'
                    AND od.orddate <= '" . $GLOBALS['ToStamp'] . "'
                    group by us.pk_userid ,us.username";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            
            if($VendorID==0)
                $ret_str='<option value="-1" selected="selected">All Users</option>';
            else
                $ret_str='<option value="-1">All Users</option>';
            
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                if($VendorID==$row['pk_userid'])
                    $ret_str.='<option value="'.$row['pk_userid'].'" selected="selected">'.$row['username'].'</option>';
                else
                    $ret_str.='<option value="'.$row['pk_userid'].'">'.$row['username'].'</option>';
                    
            }
            return $ret_str;
        }#GenerateVendorList
        
        /*
            function to fetch the name of selected user in the drop down.
        */                
        function GenerateVendorName($VendorID) {
            
            if($VendorID=='-1') {
                return 'All';
            } 
            else {
                $query="SELECT * FROM [|PREFIX|]users WHERE pk_userid='".$VendorID."'";
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                $row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
                return $row['username'];
            }
            
                
            return $ret_str;
        }#GenerateVendorName
   
//zfang_20100623 Render the Datepicker widget
/**
         * Generate HTML snippets for date picker
         * @param unknown_type $elementId
         * @param unknown_type $currentValue
         */
        private function getDatePickerHtml($elementId, $elementName, $currentValue) {
            return "<input type='text' id='$elementId' name='$elementName' readonly='true' class='datepicker' value='$currentValue'>";
        }
    
}
?>

