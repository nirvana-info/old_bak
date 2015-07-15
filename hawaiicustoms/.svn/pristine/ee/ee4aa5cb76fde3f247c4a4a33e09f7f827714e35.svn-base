<?php

/******************************************
* Page Name         : class.settings.order.cron.php
* Containing Folder : classes
* Created By        : Baskaran B
* Created On        : 8th September, 2010
* Modified By       : Baskaran B
* Modified On       : 8th September, 2010
* Description       : Send the review request to customer
***************************************************************/
class ISC_ADMIN_SETTINGS_ORDER_CRON extends ISC_ADMIN_REQUESTS {
    public function HandleToDo($Do) {
        switch (isc_strtolower($Do)) { 
                case "requested":
                    $this->Requested();
                    break;
                default:
                    $this->NoReview();
                    break;                
        }
    }
    
	/**
	* @desc Create orderid to send the review to customer
	*/
    public function NoReview() {
        $enable = "SELECT * FROM [|PREFIX|]order_review_config WHERE id = 1";
        $enablequery = $GLOBALS['ISC_CLASS_DB']->Query($enable);
        $rowenable = $GLOBALS['ISC_CLASS_DB']->Fetch($enablequery);
        if($rowenable['sendrequest'] == '1') { # To check the review request is enabled
            $curday = date('d');
            $curmonth = date('m');
            $curyear = date('Y');
            $requestafter = $rowenable['request'];
            $norequestafter = $rowenable['norequest'];
            $fromdate = strtotime(date('Y-m-d', mktime(0,0,0,$curmonth,$curday-$norequestafter,$curyear)));
            $todate = strtotime(date('Y-m-d H:i:s', mktime(23,59,59,$curmonth,$curday-$requestafter,$curyear)));
            $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT o.orderid as orderid FROM [|PREFIX|]orders o 
                                                        LEFT JOIN [|PREFIX|]requests r ON o.orderid = r.orderid 
                                                        WHERE r.requeststatus IS NULL
                                                        AND orddateshipped between $fromdate AND $todate ");
            $orderIds = array();                                                                               
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($query)) {
                $orderIds[] = $row['orderid'];
            }
            $_REQUEST['orderIds'] = join(',',$orderIds);
            $template = "SELECT id FROM [|PREFIX|]order_review_request WHERE is_default = 1";
            $templatequery = $GLOBALS['ISC_CLASS_DB']->Query($template);
            $rowtemplate = $GLOBALS['ISC_CLASS_DB']->Fetch($templatequery);
            
            $_GET['templateId'] = $rowtemplate['id'];
            if(count($orderIds) > 0) {
                GetClass('ISC_ADMIN_REQUESTS')->SendRequestMultyCron();
            }
        }
    }
    
	/**
	* @desc Create orderids to send request again using the interval
	*/
    public function Requested() {
        $enable = "SELECT * FROM [|PREFIX|]order_review_config WHERE id = 1";
        $enablequery = $GLOBALS['ISC_CLASS_DB']->Query($enable);
        $rowenable = $GLOBALS['ISC_CLASS_DB']->Fetch($enablequery);
        if($rowenable['sendrequest'] == '1') { # To check the review request is enabled
            $resendrequest = $rowenable['resend'];
            $emailcounter = $rowenable['repeat'];
            $curday = date('d');
            $curmonth = date('m');
            $curyear = date('Y');
            $fromdate = date('Y-m-d H:i:s', mktime(0,0,0,$curmonth,$curday-$resendrequest,$curyear));
            $todate = date('Y-m-d H:i:s', mktime(23,59,59,$curmonth,$curday,$curyear));
            $query = "SELECT orderid FROM [|PREFIX|]requests where requeststatus = '1' AND emailcounter < $emailcounter AND requestdate < '$fromdate' AND orderid = '103540' ";
            $exequery = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $orderIds = array();
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($exequery)) {
                $orderIds[] = $row['orderid'];
            }
            $_REQUEST['orderIds'] = join(',',$orderIds);
            $template = "SELECT id FROM [|PREFIX|]order_review_request WHERE is_default = 1";
            $templatequery = $GLOBALS['ISC_CLASS_DB']->Query($template);
            $rowtemplate = $GLOBALS['ISC_CLASS_DB']->Fetch($templatequery);
            
            $_GET['templateId'] = $rowtemplate['id'];
            $_REQUEST['resend'] = 1; 
            if(count($orderIds) > 0) {
                GetClass('ISC_ADMIN_REQUESTS')->SendRequestMultyCron();
            }
        }
    }
}

?>
