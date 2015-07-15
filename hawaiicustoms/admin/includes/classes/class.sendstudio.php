<?php

	/**
	*	This class handles everything to do with Interspire Email Marketer integration into Interspire Shopping Cart
	*
	*	@author Mitchell Harper
	*	@date November 1st 2007
	*	@copyright Interspire Pty. Ltd.
	*/
	class ISC_ADMIN_SENDSTUDIO
	{

		/**
		*	Get a list of all mailing lists available for the Interspire Email Marketer user and return them as <option> tags
		*/
		public function GetAvailableMailingListsAsoptions($Selected="", &$NumLists = 0)
		{
			// Get a list of available mailing lists from Interspire Email Marketer
			$output = "";
			$list_xml = "<xmlrequest>
						<username>" . GetConfig('MailUsername') . "</username>
						<usertoken>" . GetConfig('MailXMLToken') . "</usertoken>
						<requesttype>user</requesttype>
						<requestmethod>GetLists</requestmethod>
						<details>
						</details>
					</xmlrequest>";

			$list_xml = urlencode($list_xml);
			$result = PostToRemoteFileAndGetResponse(GetConfig('MailXMLPath'), "xml=" . $list_xml);
			$xml = @simplexml_load_string($result);

			if ($xml) {
				foreach($xml->data->item as $item) {
					$output .= sprintf("<option value='%d'>%s</option>", urlencode($item->listid), $item->name);
					++$NumLists;
				}
			}

			return $output;
		}

		/**
		*	Get a list of all mailing lists available for the Interspire Email Marketer user
		*/
		public function GetAvailableMailingLists()
		{
			// Get a list of available mailing lists from Interspire Email Marketer
			$lists = array();
			$list_xml = "<xmlrequest>
						<username>" . GetConfig('MailUsername') . "</username>
						<usertoken>" . GetConfig('MailXMLToken') . "</usertoken>
						<requesttype>user</requesttype>
						<requestmethod>GetLists</requestmethod>
						<details>
						</details>
					</xmlrequest>";

			$list_xml = urlencode($list_xml);
			$result = PostToRemoteFileAndGetResponse(GetConfig('MailXMLPath'), "xml=" . $list_xml);
			$xml = @simplexml_load_string($result);

			if ($xml && isset($xml->data->item) && is_array($xml->data->item)) {
				foreach($xml->data->item as $item) {
					array_push($lists, array("id" => $item->listid, "name" => $item->name));
				}
			}

			return $lists;
		}

		/**
		*	Get a list of custom fields available for the list with id=$ListId
		*/
		public function GetAvailableCustomFieldsForList($ListId, $FieldType="")
		{
			// Get a list of available custom fields for a mailing list
			$output = "";
			$num_fields = 0;
			$cf_xml = "<xmlrequest>
						<username>" . GetConfig('MailUsername') . "</username>
						<usertoken>" . GetConfig('MailXMLToken') . "</usertoken>
						<requesttype>lists</requesttype>
						<requestmethod>GetCustomFields</requestmethod>
						<details>
							<listids>
								" . $ListId . "
							</listids>
						</details>
					</xmlrequest>";

			$cf_xml = urlencode($cf_xml);
			$result = PostToRemoteFileAndGetResponse(GetConfig('MailXMLPath'), "xml=" . $cf_xml);
			$xml = @simplexml_load_string($result);

			if ($xml) {
				foreach($xml->data->item as $item) {
					// We only want to show "text" custom fields
					if($item->fieldtype == $FieldType || $FieldType == "") {
						$output .= sprintf("<option value='%d'>%s</option>", urlencode($item->fieldid), $item->name);
						++$num_fields;
					}
				}
			}

			if($num_fields > 0) {
				printf("<option value='0' selected=\"selected\">-- %s --</option>", GetLang('ChooseACustomField'));
				echo $output;
			}
		}
		/**
		*	Add a subscriber to the mailing list for the newsletter. Returns an array contaning
		*	status (success/fail) and an optional return message
		*/
		public function AddSubscriberToNewsletter($FirstName, $Email)
		{
			// Is this email address valid?
			if (!is_email_address($Email)) {
				$result = array("status" => "fail",
								"message" => sprintf(GetLang('NewsletterInvalidEmail'), isc_html_escape($Email))
				);

			// Is this person already in the subscribers table?
			} else if($this->SubscriberExists(GetConfig('MailNewsletterList'), $Email)) {
				$result = array("status" => "fail",
								"message" => sprintf(GetLang('NewsletterAlreadySubscribed'), isc_html_escape($Email))
				);

			// Add the subscriber
			} else {
				$add_xml = "<xmlrequest>
							<username>" . GetConfig('MailUsername') . "</username>
							<usertoken>" . GetConfig('MailXMLToken') . "</usertoken>
							<requesttype>subscribers</requesttype>
							<requestmethod>AddSubscriberToList</requestmethod>
							<details>
								<emailaddress>" . $Email . "</emailaddress>
								<mailinglist>" . GetConfig('MailNewsletterList') . "</mailinglist>
								<confirmed>yes</confirmed>";

				// Do we need to add the first name custom field?
				if(GetConfig('MailNewsletterCustomField') > 0) {
					$add_xml .= "<customfields>
									<fieldid>" . GetConfig('MailNewsletterCustomField') . "</fieldid>
									<value>" . $FirstName . "</value>
								</customfields>";
				}

				$add_xml .= "
							</details>
						</xmlrequest>";

				$add_xml = urlencode($add_xml);
				$result = PostToRemoteFileAndGetResponse(GetConfig('MailXMLPath'), "xml=" . $add_xml);
				$xml = @simplexml_load_string($result);

				$response = '';
				if ($xml && isset($xml->status)) {
					$response = $xml->status;
				}

				if($response == "SUCCESS") {
					$result = array("status" => "success",
									"message" => GetLang('NewsletterSubscribedSuccessfully')
					);
				}
				else {
					$result = array("status" => "fail",
									"message" => sprintf(GetLang('NewsletterSubscribeErrorIEM'), $xml->errormessage)
					);
				}
			}

			return $result;
		}

		/**
		*	Is an email address address already subscribe to the list with id=$ListId
		*/
		public function SubscriberExists($ListId, $Email)
		{
			$sub_xml = "<xmlrequest>
						<username>" . GetConfig('MailUsername') . "</username>
						<usertoken>" . GetConfig('MailXMLToken') . "</usertoken>
						<requesttype>subscribers</requesttype>
						<requestmethod>IsSubscriberOnList</requestmethod>
						<details>
							<Email>" . $Email . "</Email>
							<List>" . $ListId . "</List>
						</details>
					</xmlrequest>";

			$sub_xml = urlencode($sub_xml);
			$result = PostToRemoteFileAndGetResponse(GetConfig('MailXMLPath'), "xml=" . $sub_xml);
			$xml = @simplexml_load_string($result);

			$response = null;
			if ($xml && isset($xml->data)) {
				$response = $xml->data;
			}

			if(is_numeric(trim($response))) {
				return true;
			}
			else {
				return false;
			}
		}

		/**
		*	Add the customer to the orders mailing list, complete with any order parameters.
		*	$OrderRow is a reference to an object that contains all details about their order.
		*/
		public function AddSubscriberToOrderList($orders)
		{
			foreach($orders as $order) {
				// Is this person already in the subscribers table?
				if(!$this->SubscriberExists(GetConfig('MailOrderList'), $order['ordbillemail'])) {
					// Add the subscriber
					$add_xml = "<xmlrequest>
								<username>" . GetConfig('MailUsername') . "</username>
								<usertoken>" . GetConfig('MailXMLToken') . "</usertoken>
								<requesttype>subscribers</requesttype>
								<requestmethod>AddSubscriberToList</requestmethod>
								<details>
									<emailaddress>" . $order['ordbillemail'] . "</emailaddress>
									<mailinglist>" . GetConfig('MailOrderList') . "</mailinglist>
									<confirmed>yes</confirmed>
									<customfields>";

					// Do we need to add the customer's first name to the mailing list as a custom field?
					if(GetConfig('MailOrderFirstName') > 0) {
						$add_xml .= "<item>
										<fieldid>" . GetConfig('MailOrderFirstName') . "</fieldid>
										<value>" . $order['ordbillfirstname'] . "</value>
									</item>";
					}

					// Do we need to add the customer's last name to the mailing list as a custom field?
					if(GetConfig('MailOrderLastName') > 0) {
						$add_xml .= "<item>
										<fieldid>" . GetConfig('MailOrderLastName') . "</fieldid>
										<value>" . $order['ordbilllastname'] . "</value>
									</item>";
					}

					// Do we need to add the customer's full name to the mailing list as a custom field?
					if(GetConfig('MailOrderFullName') > 0) {
						$add_xml .= "<item>
										<fieldid>" . GetConfig('MailOrderFullName') . "</fieldid>
										<value>" . $order['ordbillfirstname'] . " " . $order['ordbilllastname'] . "</value>
									</item>";
					}

					// Do we need to add the customer's zip/postcode to the mailing list as a custom field?
					if(GetConfig('MailOrderZip') > 0) {
						$add_xml .= "<item>
										<fieldid>" . GetConfig('MailOrderZip') . "</fieldid>
										<value>" . $order['ordbillzip'] . "</value>
									</item>";
					}

					// Do we need to add the customer's country to the mailing list as a custom field?
					if(GetConfig('MailOrderCountry') > 0) {
						$add_xml .= "<item>
										<fieldid>" . GetConfig('MailOrderCountry') . "</fieldid>
										<value>" . GetCountryISO3ById($order['ordbillcountryid']) . "</value>
									</item>";
					}

					// Do we need to add the customer's order total to the mailing list as a custom field?
					if(GetConfig('MailOrderTotal') > 0) {
						$add_xml .= "<item>
										<fieldid>" . GetConfig('MailOrderTotal') . "</fieldid>
										<value>" . $order['ordtotalamount'] . "</value>
									</item>";
					}

					// Do we need to add the customer's payment method to the mailing list as a custom field?
					if(GetConfig('MailOrderPaymentMethod') > 0) {
						$add_xml .= "<item>
										<fieldid>" . GetConfig('MailOrderPaymentMethod') . "</fieldid>
										<value>" . $order['orderpaymentmethod'] . "</value>
									</item>";
					}

					// Do we need to add the customer's shipping method to the mailing list as a custom field?
					if(GetConfig('MailOrderShippingMethod') > 0) {
						$add_xml .= "<item>
										<fieldid>" . GetConfig('MailOrderShippingMethod') . "</fieldid>
										<value>" . $order['ordshipmethod'] . "</value>
									</item>";
					}

					$add_xml .= "
								</customfields>
								</details>
							</xmlrequest>";

					$add_xml = urlencode($add_xml);
					$result = PostToRemoteFileAndGetResponse(GetConfig('MailXMLPath'), "xml=" . $add_xml);
					$xml = @simplexml_load_string($result);

					$response = '';
					if ($xml && isset($xml->status)) {
						$response = $xml->status;
					}

					if($response == "SUCCESS") {
						$result = array("status" => "success",
										"message" => GetLang('NewsletterSubscribedSuccessfully')
						);
					}
					else {
						$result = array("status" => "fail",
										"message" => sprintf(GetLang('NewsletterSubscribeErrorIEM'), $xml->errormessage)
						);
					}
				}
				else {
					$result = array("status" => "success",
									"message" => sprintf(GetLang('NewsletterAlreadySubscribed'), $order['ordbillemail'])
					);
				}
			}
			return $result;
		}

		/**
		*	Add a subscriber to the specified mailing list for the newsletter. Returns an array contaning
		*	status (success/fail) and an optional return message
		*/
		public function AddSubscriberToList($Email, $ListId)
		{
			$response = "FAILED";

			// Is this person already in the subscribers table?
			if(!$this->SubscriberExists($ListId, $Email)) {
				// Add the subscriber
				$add_xml = "<xmlrequest>
							<username>" . GetConfig('MailUsername') . "</username>
							<usertoken>" . GetConfig('MailXMLToken') . "</usertoken>
							<requesttype>subscribers</requesttype>
							<requestmethod>AddSubscriberToList</requestmethod>
							<details>
								<confirmed>yes</confirmed>
								<emailaddress>" . $Email . "</emailaddress>
								<mailinglist>" . $ListId . "</mailinglist>
							</details>
						</xmlrequest>";

				$add_xml = urlencode($add_xml);
				$result = PostToRemoteFileAndGetResponse(GetConfig('MailXMLPath'), "xml=" . $add_xml);
				$xml = @simplexml_load_string($result);

				if ($xml && isset($xml->status)) {
					$response = $xml->status;
				}
			}

			return $response;
		}

		/**
		 * Update a subscribers ip address after signing them up to a mailing list. This is required because
		 * Google Checkout sends us the ip in a different notification to the one that gives permission to
		 * subscribe them to a mailing list
		 *
		 * @param string The email address of the customer
		 * @param string The ip address
		 *
		 * @return string
		 **/
		public function UpdateSubscribersIp($Email, $ListId, $ip)
		{
			$response = "FAILED";

			// Is this person already in the subscribers table?
			if($this->SubscriberExists($ListId, $Email)) {
				$raw_xml = 	"<xmlrequest>
						<username>" . GetConfig('MailUsername') . "</username>
						<usertoken>" . GetConfig('MailXMLToken') . "</usertoken>
						<requesttype>subscribers</requesttype>
						<requestmethod>UpdateSubscriberIP</requestmethod>
						<details>
							<emailaddress>".$Email."</emailaddress>
							<mailinglist>".$ListId."</mailinglist>
							<ipaddress>".$ip."</ipaddress>
						</details>
					</xmlrequest>";

				$raw_xml = urlencode($raw_xml);
				$result = PostToRemoteFileAndGetResponse(GetConfig('MailXMLPath'), "xml=" . $raw_xml);
				$xml = @simplexml_load_string($result);

				if ($xml && isset($xml->message)) {
					$response = $xml->message;
				}
			}

			return $response;
		}
	}

?>