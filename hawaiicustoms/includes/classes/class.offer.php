<?php

	class ISC_OFFER
	{
        public $_prodid = 0;
        public $_prodprice = 0;
        public $_prodbrand = 0;
        public $_partnumber = '';
        public $_prodtitle = '';
        public $_product = 0;
        public $_emailids = '';
        public $_message = '';
        
        
		public function __construct()
		{
			//zcs=>must sign in
			if(!CustomerIsSignedIn()){
				$this_page = '';

				if ($GLOBALS['EnableSEOUrls'] == 1) {
					$this_page = sprintf("%s/%s/%s", GetConfig('ShopPathNormal'), "login","account");
				} else {
					$this_page = sprintf("%s/login.php", $GLOBALS['ShopPath']);
				}
				echo "<script language=\"javascript\">alert('Sorry, you need to sign in!'); window.opener.location='$this_page'; window.close();</script>";
				exit;
			}
			//<=zcs
			
		}

        public function HandlePage()
        {
            $action = "";
            if (isset($_REQUEST['product'])) {
                $action = isc_strtolower($_REQUEST['product']);
            }
            switch ($action)
            {
                case "sendmail": {
                    $this->SendMail();
                    break;
                }
                case "mailsend": {
                    $this->MailSend();
                    break;
                }
                default: {
                    $this->ShowOffer();
                }
            }
        }

		public function _SetOfferData()
		{
            $productid = $_GET['product'];
            if ($productid == 0) {
                if (isset($_REQUEST['product'])) {
                    $product = $_REQUEST['product'];
                }
                else if(isset($GLOBALS['PathInfo'][1])) {
                    $product = preg_replace('#\.html$#i', '', $GLOBALS['PathInfo'][1]);
                }
                else {
                    $product = '';
                }
                $product = $GLOBALS['ISC_CLASS_DB']->Quote(MakeURLNormal($product));
                $productSQL = sprintf("prodname='%s'", $product);
            }
            else {
                $productSQL = sprintf("productid='%s'", (int)$productid);
            }
//            $query = "SELECT * FROM [|PREFIX|]products where $productSQL";
            $query = "SELECT p.*, b.brandname FROM [|PREFIX|]products p LEFT JOIN [|PREFIX|]brands b ON ( b.brandid = p.prodbrandid ) WHERE $productSQL";
//            echo "SELECT * FROM [|PREFIX|]products where $productSQL";exit;
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $this->_product = $row;
                $this->_prodid = $row['productid'];
                $this->_prodbrand = $row['brandname'];
                $this->_partnumber = $row['prodcode'];
                $this->_prodtitle = $row['prodname'];
//                $this->_prodprice = $GLOBALS['ISC_CLASS_OFFER']->GetCalculatedPrice();
            }
            $tplquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]coupon_settings where templateid = 1");
            if($tplrow = $GLOBALS['ISC_CLASS_DB']->Fetch($tplquery)){
                $GLOBALS['OfferTitle'] = $tplrow['title_msg'];
                $GLOBALS['OfferHeader'] = $tplrow['header_msg'];
                $GLOBALS['OfferFooter'] = $tplrow['footer_msg'];
                $this->_emailids = $tplrow['emailids'];
                $this->_message = $tplrow['email_template'];
            }
            $GLOBALS['productid'] = $this->_prodid;
            $GLOBALS['prodbrand'] = $this->_prodbrand."/".$this->_partnumber;
            $GLOBALS['prodtitle'] = $this->_prodtitle;
            $GLOBALS['prodprice'] = $this->GetCalculatedPrice();
            $GLOBALS['formatprice'] = strip_tags($this->GetCalculatedPrice());
            $GLOBALS['states'] = $this->states();
		}
        
        public function states()
        {
            $countryid = "226"; # US state id is 226 in isc_countries table -- Baskaran
            $result = $GLOBALS['ISC_CLASS_DB']->Query("SELECT statename FROM [|PREFIX|]country_states WHERE statecountry = '$countryid' ORDER BY statename");
            $options = '<option value="0">'.GetLang('SelectState').'</option>';
             while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
                $options .= sprintf("<option value='%s'>%s</option>", $row['statename'], $row['statename']); 
            }
            return $options;
        }
        
		public function ShowOffer()
		{
			// Load the data for this product
			$this->_SetOfferData(); 
			//zcs=>add captcha
			$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
			$GLOBALS['ISC_CLASS_CAPTCHA']->CreateSecret();
			$GLOBALS['CaptchaImage'] = $GLOBALS['ISC_CLASS_CAPTCHA']->ShowCaptcha();
			$GLOBALS['product'] = $this->GetProductId();
			//<=zcs
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("makeoffer");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}
        
        public function GetProductId()
        {
            return $this->_prodid;
        }
        public function GetCalculatedPrice()
        {
            return CalculateProductPrice($this->_product, true, true, false);
        }
        
        private function SendMail() 
        {
		$_GET['product'] = $_REQUEST['product'] = $_POST['productid'];
		// Load the data for this product
		$this->_SetOfferData(); 
	    //zcs=>
		$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
		$captcha = trim($_REQUEST['captcha']);
		if(isc_strtolower($captcha) != isc_strtolower($GLOBALS['ISC_CLASS_CAPTCHA']->LoadSecret())) {
			// Captcha validation failed	
			echo "<script language=\"javascript\">alert('Invalid captcha!'); history.back();</script>";
			exit;
		}
		if(!$this->GetProductId()){
			echo "<script language=\"javascript\">alert('Invalid product!'); history.back();</script>";
			exit;
		}
	    //<=zcs
	    
            $subject = "Make an Offer";
            $email = trim($_REQUEST['email']);
            $offer = "$".trim($_REQUEST['offer']);
            $producttitle = $_REQUEST['prodtitle'];
            $price = $_REQUEST['price'];
            $state = $_REQUEST['state'];
            if($state != '0')
            $statename = $state;
            else
            $statename = "State not selected";
            $zipcode = $_REQUEST['zipcode'];
            $comment = $_REQUEST['comments'];
            $content = $this->_message;
            $prodtitle = "&lt;!--PRODUCT-TITLE--&gt;";
            $listedprice = "&lt;!--LISTED-PRICE--&gt;";
            $offeredprice = "&lt;!--OFFERED-PRICE--&gt;";
            $cusemail = "&lt;!--CUSTOMER-EMAIL--&gt;";
            $statetag = "&lt;!--STATE--&gt;";
            $zipcodetag = "&lt;!--ZIPCODE--&gt;";
            $commenttag = "&lt;!--COMMENT--&gt;";
            $title = str_replace($prodtitle,$producttitle,$content);
            $lisprice = str_replace($listedprice,$price,$title);
            $offprice = str_replace($offeredprice,$offer,$lisprice);
            $emailreplace = str_replace($cusemail,$email,$offprice);
            $statereplace = str_replace($statetag,$statename,$emailreplace);
            $zip = str_replace($zipcodetag,$zipcode,$statereplace);
            $message = str_replace($commenttag,$comment,$zip);
 
            $to = $this->_emailids;
            
            require_once(ISC_BASE_PATH . "/lib/email.php");
                $obj_email = GetEmailClass();
                $obj_email->Set('CharSet', GetConfig('CharacterSet'));
                $obj_email->From(GetConfig('OrderEmail'), $email);
				$obj_email->Set('ReplyTo', $email);
                $obj_email->Set("Subject", $subject);
                $obj_email->AddBody("html", $message);
                $obj_email->AddRecipient($to, "", "h");
                $email_result = $obj_email->Send();
                if($email_result)
                {
                    header("Location: " . $GLOBALS['ShopPath'] . "/offer.php?product=MailSend");
                }
        }
        
        private function MailSend()
        {
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("makeoffermail");
            $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
        }
	}

?>