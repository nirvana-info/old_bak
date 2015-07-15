<?php

	class ISC_SWEEPSTAKES
	{
        
		/*public function __construct()
		{
			// Load the data for this product
			$this->_SetOfferData(); 
		}  */

        public function HandlePage()
        {
            $action = '';
            /*if ($GLOBALS['EnableSEOUrls'] == 1 and count($GLOBALS['PathInfo']) > 0 ){
                if (isset ($GLOBALS['PathInfo'][1])) {
                    $_REQUEST['action'] = $GLOBALS['PathInfo'][1];
                }
                else
                {
                    $_REQUEST['action'] = $GLOBALS['PathInfo'][0];
                }
            }*/
            if (count($GLOBALS['PathInfo']) > 0 ){
                if (isset ($GLOBALS['PathInfo'][1])) {
                    $_REQUEST['action'] = $GLOBALS['PathInfo'][1];
                }
                else
                {             
                    $_REQUEST['action'] = $GLOBALS['PathInfo'][0];
                }
            }

            if (isset($_REQUEST['action'])) {
                $action = isc_strtolower($_REQUEST['action']);
            }
            
            switch ($action)
            {
                case "savesweepstakes": {
                    $this->SaveSweepstakes();
                    break;
                } 
                case "successsweepstakes": {
                    $this->successSweepstakes();
                    break;
                }
                case "getdefaultpagesweepstakes":
                	              	
                	$this->GetDefaultPageSweepStakes();
                	break;
                default: {
                    $this->SweepstakesForm();
                }
            }
        }
        
        function GetDefaultPageSweepStakes()
        {
        		$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle('');
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sweepstakes_home");
                $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
        }

		public function SweepstakesForm($MsgDesc = "", $MsgStatus = "")
        {
        	if(isset($_POST['sweepstakes_email']) && !empty($_POST['sweepstakes_email']))
        	{
        		$_POST['email'] = $_POST['sweepstakes_email'];
        	}
        	$GLOBALS['urlreferrer'] = '';
        	if(isset($_POST['sweepstakes_refurl']) && !empty($_POST['sweepstakes_refurl']))
        	{
        		$GLOBALS['urlreferrer'] = $_POST['sweepstakes_refurl'];
        		setcookie('tc_my_urlreferrer',$_POST['sweepstakes_refurl'],time()+3600*24,'/');
        	}
        	else 
        	{
        		
        		if(isset($_COOKIE['tc_my_urlreferrer']) && !empty($_COOKIE['tc_my_urlreferrer']))
        		{
        			$GLOBALS['urlreferrer'] = $_COOKIE['tc_my_urlreferrer'];
        		}
        		
        	}
        	
            $GLOBALS['Message'] = GetFlashMessageBoxes();
            $GLOBALS['HideErrorMessage'] = 'none';
            if ($MsgDesc != "") {
                $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
            }
            $cdate = date('Y-m-d');
            $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]sweepstakes_master WHERE active = '1' AND startdate <= '$cdate' AND enddate >= '$cdate' LIMIT 0 , 1 ");
            $row = $GLOBALS['ISC_CLASS_DB']->Fetch($query);
            $sweepstakesId = $row['sweepstakesid'];
            $_SESSION['SweepstakesId'] = '';
            if($sweepstakesId != '') {
                $_SESSION['SweepstakesId'] = $sweepstakesId;
//            $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]sweepstakes_master where sweepstakesid = '$sweepstakesId'");  
                $params = array();
                $title = $row['title'];
                $browsertitle = $row['browsertitle'];
                $GLOBALS['Description'] = $row['description'];
                $GLOBALS['MotorcycleSweepstakes'] = $title;                                       
                $GLOBALS['UniversalCat'] = isset($params['catuniversal']) ? $params['catuniversal'] : 0;
                $GLOBALS['YearList']     = $this->getYMMOptions($params,'year');
                $GLOBALS['MakeList']     = $this->getYMMOptions($params,'make');
                $GLOBALS['ModelList']    = $this->getYMMOptions($params,'model');
                if($GLOBALS['EnableSEOUrls'] == 1) {
                    $GLOBALS['FormAction']   = $GLOBALS['ShopPath']."/sweepstakes/savesweepstakes";
                }
                else {
                    $GLOBALS['FormAction']   = $GLOBALS['ShopPath']."/sweepstakes.php?action=savesweepstakes";
                } 
    //            $GLOBALS['YMMTable']     = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("YMMOptions");
                
                if(isset($_POST['email'])) {
                    $GLOBALS['Email'] = $_POST['email'];
                    $GLOBALS['Firstname'] = $_POST['firstname'];
                    $GLOBALS['Lastname'] = $_POST['lastname'];
                    $GLOBALS['PhoneNumber'] = $_POST['phone'];
                    $GLOBALS['AddressLine1'] = $_POST['address1'];
                    $GLOBALS['AddressLine2'] = $_POST['address2'];
                    $GLOBALS['City'] = $_POST['city'];
                    $GLOBALS['State'] = $_POST['states'];
                    $GLOBALS['ZipCode'] = $_POST['zipcode'];
                }
                
                // Generate the captcha image
                $GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
                $GLOBALS['ISC_CLASS_CAPTCHA']->CreateSecret();
                $GLOBALS['CaptchaImage'] = $GLOBALS['ISC_CLASS_CAPTCHA']->ShowCaptcha();
                
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($browsertitle);
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sweepstakes");
                $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
            }
            else {
                ob_end_clean();
                header(sprintf("Location: %s", $GLOBALS['ShopPath']));   
                die();
            }
        }
        
        private function SaveSweepstakes() 
        { 
            if(isset($_POST['email'])) {
            	$url_referrer = $_POST['urlreferrer'];
            	
            	/*if(stripos($GLOBALS['ShopPath'], $url_referrer))
            	{
            		$url_referrer = '';
            	}*/
            	
                $email = trim($_POST['email']);
                $newsletter = isset($_POST['newsletter']) ? trim($_POST['newsletter']) : 0;
                $firstname = trim($_POST['firstname']);
                $lastname = trim($_POST['lastname']);
                $phone = trim($_POST['phone']);
                $address1 = trim($_POST['address1']);
                $address2 = trim($_POST['address2']);
                $city = trim($_POST['city']);
                $states = trim($_POST['states']);
                $country = "United States";
                $zipcode = trim($_POST['zipcode']);
                $searchyear = trim($_POST['searchyear']); 
                $searchmake = trim(MakeURLNormal($_POST['searchmake']));
                $searchmodel = trim(MakeURLNormal($_POST['searchmodel']));
                $sweepstakesid = $_SESSION['SweepstakesId'];
                $addedby = "Customer";
                $createddate = date("Y-m-d H:i:s");
                
                $captcha = '';
                if(isset($_POST['captcha'])) {
                    $captcha = $_POST['captcha'];
                }
                $captcha_check = true;
                
                // Do we need to check captcha?
                if(GetConfig('CaptchaEnabled')) {
                    $GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
                    if(isc_strtolower($captcha) == isc_strtolower($GLOBALS['ISC_CLASS_CAPTCHA']->LoadSecret())) {
                        // Captcha validation succeeded
                        $captcha_check = true;
                    }
                    else {
                        // Captcha validation failed
                        $captcha_check = false;
                    }
                }

                if($captcha_check) {
                    $userDetails = array(
                        'email' => $email,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'phonenumber' => $phone,
                        'addressline1' => $address1,
                        'addressline2' => $address2,
                        'city' => $city,
                        'state' => $states,
                        'country' => $country,
                        'zipcode' => $zipcode,
                        'receivingmail' => $newsletter,
                        'year' => $searchyear,
                        'make' => $searchmake,
                        'model' => $searchmodel,
                        'sweepstakesid' => $sweepstakesid,
                        'addedby' => $addedby,
                        'createddate' => $createddate,
                    	'urlreferrer' => $url_referrer
                    );
                    $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT email FROM [|PREFIX|]sweepstakes_users where email = '".$email."' and sweepstakesid = '$sweepstakesid'");
                    $cnt = $GLOBALS['ISC_CLASS_DB']->CountResult($query);
                    # Checking for whether a user can enter 5 enteries for a sweepstakes for one email id -- Baskaran
                    if($cnt >= 5) {
                    	$msg = sprintf(GetLang('Sweepstakes5Exists'),$email);
                            FlashMessage($msg, MSG_ERROR, 'sweepstakes');
                    }
                    else {
                            $GLOBALS['ISC_CLASS_DB']->InsertQuery("sweepstakes_users", $userDetails);
                            $_SESSION['SweepsEmailId'] = '';
                            $_SESSION['SweepstakesId'] = '';                        
                            $_SESSION['SweepsEmailId'] = $email;
                            $_SESSION['SweepstakesId'] = $sweepstakesid;
                            $total = 0;
                            $remaining = 0;
                            if($cnt >= 5) {
                                $total = 5;
                                $remaining = 0;
                            }
                            else {
                                $total = $cnt + 1;
                                $remaining = 5 - $total;
                            }
                            if($GLOBALS["ISC_CLASS_DB"]->GetErrorMsg() == "") {
                                if($GLOBALS['EnableSEOUrls'] == 1) {
                                    header(sprintf("Location: %s/sweepstakes/successsweepstakes", $GLOBALS['ShopPath'])); 
                                }
                                else {
                                    header(sprintf("Location: %s/sweepstakes.php?action=successsweepstakes", $GLOBALS['ShopPath'])); 
                                }
                                  
    //                                FlashMessage(sprintf(GetLang('SweepstakessavedSuccessfully'),$total,$remaining), MSG_SUCCESS, 'sweepstakes.php');            
                            }
                            else {
                                $this->SweepstakesForm(GetLang('SweepstakesError'), MSG_ERROR);
                            }
                    }
                }
                else {
                    $this->SweepstakesForm(GetLang('CaptchaError'), MSG_ERROR);
                }
            }
            else {
                ob_end_clean();
                header(sprintf("Location: %s/sweepstakes", $GLOBALS['ShopPath']));   
                die();
            }
        }
        
        function successSweepstakes() {
            $email = $_SESSION['SweepsEmailId'];
            $sweepstakesid = $_SESSION['SweepstakesId'] ;
            $GLOBALS['Total'] = 0;
            $query = $GLOBALS['ISC_CLASS_DB']->Query("SELECT count(email) as email FROM [|PREFIX|]sweepstakes_users where email = '".$email."' and sweepstakesid = '$sweepstakesid'");
            while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($query)) {
            $GLOBALS['Total'] = $row['email'];
            $GLOBALS['Remaining'] = 5 - $GLOBALS['Total'];
            }
            
            if($GLOBALS['Total'] == 1)
            {
            	$GLOBALS["RemainingMessage"] = sprintf(GetLang("OneSweepstakeWasAdded"),$GLOBALS['Total']);
            }
            else 
            {
            	$GLOBALS["RemainingMessage"] = sprintf(GetLang("MoreThanOneSweepstakeWasAdded"),$GLOBALS['Total']);
            }
            
            $_SESSION['SweepsEmailId'] = '';
            $_SESSION['SweepstakesId'] = '';
            if($GLOBALS['Remaining'] == '0') {
                $GLOBALS['DisplayTotal'] = "none";
                $GLOBALS['DisplayRemaining'] = '';
            }
            else {
                $GLOBALS['DisplayTotal'] = '';
                $GLOBALS['DisplayRemaining'] = "none";
            }
            
            if($GLOBALS['EnableSEOUrls'] == 1) {
                $GLOBALS['SweepsTakesLink']   = $GLOBALS['ShopPath']."/sweepstakes";
            }
            else {
                $GLOBALS['SweepsTakesLink']   = $GLOBALS['ShopPath']."/sweepstakes.php";
            }
            
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("SweepstakesSave");
            $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
        }
        function getYMMOptions($params,$ymm_type)
        {
            switch($ymm_type)
            {
                case 'year'        :     
                                    $options = "<option value=''>--select year--</option>";
                                    $filter_array = array();
                                    $ymm_qry = "select group_concat(v.prodstartyear separator '~') as prodstartyear , group_concat(v.prodendyear separator '~') as prodendyear from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
                                    if( isset($params['make']) && $GLOBALS['UniversalCat'] == 0 )
                                        $ymm_qry .= " and prodmake = '".$params['make']."' ";
                                    if( isset($params['model']) && (!isset($params['model_flag']) || $params['model_flag'] == 1) && $GLOBALS['UniversalCat'] == 0 )
                                        $ymm_qry .= " and prodmodel = '".$params['model']."' ";

                                    $ymm_qry .= " group by p.productid ";    
                                    $ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
                                    while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
                                    {
                                        $grp_startyear = explode("~",$ymm_row['prodstartyear']); 
                                        $grp_endyear = explode("~",$ymm_row['prodendyear']);
                                        for($g=0;$g<count($grp_startyear);$g++)
                                        {
                                            $prod_start_year = $grp_startyear[$g];
                                            $prod_end_year = $grp_endyear[$g]; 

                                            if(is_numeric($prod_start_year) && is_numeric($prod_end_year)) 
                                            {
                                                $prod_year_diff = $prod_end_year - $prod_start_year;
                                                for($i=0;$i<=$prod_year_diff;$i++)
                                                {
                                                    $actual_year = $prod_start_year + $i;
                                                    if(in_array($actual_year,$filter_array)) {
                                                       $count_filter_array[$actual_year]++;        
                                                    }  else {
                                                        $filter_array[] = $actual_year;
                                                        $count_filter_array[$actual_year] = 1;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    rsort($filter_array);
                                    foreach($filter_array as $key => $value)
                                    {
                                        $selected = "";
                                        if ( isset($params['year']) && strcasecmp($params['year'], $value) == 0 )
                                            $selected = " selected";

                                        $options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>";
                                    }
                                    break;
                case 'make'        : 
                                    $options = "<option value=''>--select make--</option>";
                                    $filter_array = array();
                                    $ymm_qry = "select group_concat(DISTINCT v.prodmake separator '~') as prodmake from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
                                    $ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
                                    while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
                                    {
                                        $filters = explode('~',$ymm_row['prodmake']);
                                        for($j=0;$j<count($filters);$j++) 
                                        {
                                            $filter_value = $filters[$j]; 
                                            if(strtoupper($filter_value) != "NON-SPEC VEHICLE" && strtolower($filter_value) != "all")
                                            {
                                                if(in_array($filter_value,$filter_array))   {
                                                    $count_filter_array[$filter_value]++;
                                                } else {
                                                    $filter_array[] = $filter_value;
                                                    $count_filter_array[$filter_value] = 1;
                                                }
                                            }
                                        }
                                    }
                                    sort($filter_array);
                                    $all_makes = array('CHEVROLET', 'GMC', 'FORD', 'DODGE', 'TOYOTA', 'NISSAN', 'HONDA', 'JEEP', 'HYUNDAI','CHRYSLER', 'INFINITI', 'LEXUS');
                                    $temp_arr =  array_diff($filter_array,$all_makes);

                                    foreach($all_makes as $key => $value) 
                                    {
                                        $selected = "";
                                        if ( isset($params['make']) && strcasecmp($params['make'], $value) == 0 )
                                            $selected = " selected";        
                                        
                                        $options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>"; 
                                    }

                                    foreach($temp_arr as $key => $value ) 
                                    {
                                        $selected = "";
                                        if ( isset($params['make']) && strcasecmp($params['make'], $value) == 0 )
                                            $selected = " selected";        

                                        $options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>";
                                    }
                                    break;
                case 'model'    : 
                                    $options = "<option value=''>--select model--</option>";
                                    if(isset($params['make']))
                                    {    
                                        $filter_array = array();
                                        $ymm_qry = "select distinct prodmodel from [|PREFIX|]products p LEFT JOIN [|PREFIX|]import_variations AS v ON v.productid = p.productid where p.prodvisible='1' ";
                                        if( isset($params['make']) )
                                            $ymm_qry .= " and prodmake = '".$params['make']."' ";
                                        if( isset($params['year']) && $GLOBALS['UniversalCat'] == 0 )
                                            $ymm_qry .= " and ".$params['year']." between prodstartyear and prodendyear ";

                                        //$ymm_qry .= " group by p.productid ";    
                                        $ymm_res = $GLOBALS['ISC_CLASS_DB']->Query($ymm_qry);
                                        while($ymm_row = $GLOBALS['ISC_CLASS_DB']->Fetch($ymm_res))
                                        {
                                            if(!empty($ymm_row['prodmodel']) && $ymm_row['prodmodel'] != '~') {
                                               $filters = explode('~',$ymm_row['prodmodel']);
                                               for($j=0;$j<count($filters);$j++) 
                                               {
                                                    $filter_value = ucwords(strtolower($filters[$j]));
                                                    if(strtolower($filter_value) != "all")
                                                    {
                                                        if(in_array($filter_value,$filter_array))   {
                                                        } else {
                                                            $filter_array[] = $filter_value;
                                                        }
                                                    }
                                               }
                                            }
                                        }
                                        sort($filter_array);
                                        foreach($filter_array as $key => $value)
                                        {
                                            $selected = "";
                                            if ( isset($params['model']) && strcasecmp($params['model'], $value) == 0 )
                                                $selected = " selected";

                                            $options .= "<option value='".MakeURLSafe(strtolower($value))."'$selected>$value</option>";
                                        }
                                    }
                                    break;
            }

            return $options;

        }
        
	}

?>