<?php

	class ISC_SUBSCRIBE
	{

		public function HandlePage()
		{
			$action = "";
			if(isset($_REQUEST['action'])) {
				$action = isc_strtolower($_REQUEST['action']);
			}

			switch($action) {
				case "subscribe": {
					$this->Subscribe();
					break;
				}
				case "unsubscribe": {
					$this->Unsubscribe();
					break;
				}
				default: {
					ob_end_clean();
					header(sprintf("Location:%s", $GLOBALS['ShopPath']));
					die();
				}
			}
		}
		/**
		 * Unsubscribe
		 * 
		 * @return void
		 */
		public function Unsubscribe(){
			$subscribeId = base64_decode($_REQUEST['I']);
			$emailToken = $_REQUEST['T'];
			$query = "SELECT subemail AS email, listid
				  FROM [|PREFIX|]subscribers
				  WHERE subscriberid=$subscribeId";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			list($email, $listId) = array($row['email'],$row['listid']);
			//var_dump(md5($email));
			if($emailToken == md5($email)) {
				$this->UnsubscribeEmail('', $email, $subscribeId, $listId, true);
				$GLOBALS['SubscriptionHeading'] = GetLang('ThanksForUnsubscribing');
				$GLOBALS['Class'] = "";
				$GLOBALS['SubscriptionMessage'] = GetLang('UnsubscribeSuccess') . sprintf(" <a href='%s'>%s.</a>", $GLOBALS['ShopPath'], GetLang('Continue'));
			}else{
				$GLOBALS['SubscriptionHeading'] = GetLang('Oops');
				$GLOBALS['Class'] = "ErrorMessage";
				$GLOBALS['SubscriptionMessage'] = 'Something goes wrong!';
			}
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("unsubscribe");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}
		/**
		 * UnsubscribeEmail
		 * @param String $first_name,$email
		 * 
		 * @return Array $result
		 */
		public function UnsubscribeEmail($FirstName, $Email, $SubscribeId=0, $ListId=0, $SynWithEM=false){
			if(0 == $SubscribeId){
				$where = "WHERE subemail='$Email' AND subfirstname='$FirstName'";
			}else{
				$where = "WHERE subscriberid=$SubscribeId";
			}
			$GLOBALS['ISC_CLASS_DB']->DeleteQuery("subscribers", $where);
			//wirror20110316
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("customers", array('subscribed'=>0), "custconemail='$Email' AND subscribed=1");
			if($GLOBALS['ISC_CLASS_DB']->Error() == "") {
				// The subscriber was saved
				$result = array('status' => 'success',
						'message' => 'Unsubscribed Successfully'
				);
				if($SynWithEM){
					if(GetConfig('MailXMLAPIValid') && GetConfig('UseMailerForNewsletter') && GetConfig('MailNewsletterList') > 0) {
						// Delete them from the Interspire Email Marketer list
						$GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO'] = GetClass('ISC_ADMIN_SENDSTUDIO');
						if(0 == $ListId){
							$ListId = GetConfig('MailNewsletterList');
						}
						$result = $GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO']->UnsubscribeSubscriber($Email, $ListId);
					}
				}
			}
			else {
				// Something went wrong with the database
				$result = array('status' => 'fail',
						'message' => 'Unsubscribed Error'
				);
			}
			return $result;
		}

		/*
		*	Add the visitor to either the bult-in mailing list or to Interspire Email Marketer
		*/
		public function Subscribe()
		{
			if(!isset($_POST['check'])) {
				$GLOBALS['SubscriptionHeading'] = GetLang('Oops');
				$GLOBALS['Class'] = "ErrorMessage";
				$GLOBALS['SubscriptionMessage'] = GetLang('NewsletterSpammerVerification');
			}
			else if(isset($_POST['nl_first_name']) && isset($_POST['nl_email'])) {

				$first_name = $_POST['nl_first_name'];
				$email = $_POST['nl_email'];

				$subscriberFlag = 0; // this variable is used for checking email marketer is checked or not.
				// Is Interspire Email Marketer integrated or should we just use the built-in list?
				if(GetConfig('MailXMLAPIValid') && GetConfig('UseMailerForNewsletter') && GetConfig('MailNewsletterList') > 0) {
					// Add them to the Interspire Email Marketer list
					$GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO'] = GetClass('ISC_ADMIN_SENDSTUDIO');
					$result = $GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO']->AddSubscriberToNewsletter($first_name, $email);
				}
				else {
					$subscriberFlag = 1;
					// commented this line as need to insert it into subscriober table everytime.
					// $result = $this->AddSubscriberToNewsletter($first_name, $email);
				}

				/*
					This below condition is added to check if email marketer is not integrated, then need to pass the values back in 
					variable $result . Always need to insert it into subscriber table. - starts.
				*/
				if($subscriberFlag == 1) // if email marketer is not integrated
				{
					$result = $this->AddSubscriberToNewsletter($first_name, $email);
				}
				else
				{
					$result_new = $this->AddSubscriberToNewsletter($first_name, $email);
				}
				/* -- ends -- */

				if($result['status'] == "success") {
					$GLOBALS['SubscriptionHeading'] = GetLang('NewsletterThanksForSubscribing');
					$GLOBALS['Class'] = "";
					$GLOBALS['SubscriptionMessage'] = $result['message'] . sprintf(" <a href='%s'>%s.</a>", $GLOBALS['ShopPath'], GetLang('Continue'));
				}
				else {
					$GLOBALS['SubscriptionHeading'] = GetLang('Oops');
					$GLOBALS['Class'] = "ErrorMessage";
					$GLOBALS['SubscriptionMessage'] = $result['message'];
				}
			}
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s", GetConfig('StoreName'), GetLang('NewsletterSubscription')));
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("newsletter_subscribe");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
		}

		/**
		*	Add a subscriber to the mailing list for the newsletter. Returns an array contaning
		*	status (success/fail) and an optional return message
		*/
		public function AddSubscriberToNewsletter($FirstName, $Email, $SynWithEM=false)
		{
			// Is this email address valid?
			if (!is_email_address($Email)) {
				$result = array("status" => "fail",
								"message" => sprintf(GetLang('NewsletterInvalidEmail'), isc_html_escape($Email))
				);

			// Is this person already in the subscribers table?
			} else if ($this->SubscriberExists($Email)) {
				$result = array("status" => "fail",
								"message" => sprintf(GetLang('NewsletterAlreadySubscribed'), isc_html_escape($Email))
				);

			// Else add the subscriber
			} else {
				$NewSubscriber = array(
					"subemail" => $Email,
					"subfirstname" => $FirstName
				);
				$GLOBALS['ISC_CLASS_DB']->InsertQuery("subscribers", $NewSubscriber);
				//wirror20110316
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery("customers", array('subscribed'=>1), "custconemail='$Email' AND subscribed=0");

				if($GLOBALS['ISC_CLASS_DB']->Error() == "") {
					// The subscriber was saved
					$result = array("status" => "success",
									"message" => GetLang('NewsletterSubscribedSuccessfully')
					);
					if($SynWithEM){
						if(GetConfig('MailXMLAPIValid') && GetConfig('UseMailerForNewsletter') && GetConfig('MailNewsletterList') > 0) {
							// Add them to the Interspire Email Marketer list
							$GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO'] = GetClass('ISC_ADMIN_SENDSTUDIO');
							$result = $GLOBALS['ISC_CLASS_ADMIN_SENDSTUDIO']->AddSubscriberToNewsletter($FirstName, $Email);
						}
					}
				}
				else {
					// Something went wrong with the database
					$result = array("status" => "fail",
									"message" => GetLang('NewsletterSubscribeError')
					);
				}
			}

			return $result;
		}

		/**
		*	Is an email address already in the subscribers table?
		*/
		public function SubscriberExists($Email)
		{
			$query = sprintf("select count(subemail) as subexists from [|PREFIX|]subscribers where lower(subemail)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($Email)));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

			if($row['subexists'] > 0) {
				return true;
			}
			else {
				return false;
			}
		}
	}

?>