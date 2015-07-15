<?php

class ISC_COMPANYGIFTCERTIFICATES
{

	public function __construct()
	{

	}




	public function HandlePage()
	{
		$action = "";

		if ($GLOBALS['EnableSEOUrls'] == 1 and count($GLOBALS['PathInfo']) > 0 ){
				if (isset ($GLOBALS['PathInfo'][1])) {
					$_REQUEST['action'] = $GLOBALS['PathInfo'][1];
				}
				else
				{
					$_REQUEST['action'] = $GLOBALS['PathInfo'][0];
				}
			}
		if(isset($_REQUEST['action'])) {
			$action = isc_strtolower($_REQUEST['action']);
		}

		// Don't allow any access to this file if gift certificates aren't enabled
		if(GetConfig('EnableGiftCertificates') == 0) {
			ob_end_clean();
			header("Location: " . $GLOBALS['ShopPath']);
			die();
		}

		switch($action) {
			case "redeem": {
				$this->RedeemGiftCertificate();
				break;
			}
		}
	}




	private function RedeemGiftCertificate()
	{
		// Show the gift certificates main page
		$GLOBALS['ISC_LANG']['RedeemCompanyGiftCertificateIntro'] = sprintf(GetLang('RedeemCompanyGiftCertificateIntro'), $GLOBALS['StoreName']);
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle(sprintf("%s - %s", GetConfig('StoreName'), GetLang('CompanyGiftCertificates')));
		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("companygiftcertificates_redeem");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}












    /**
	 * Applies one or more gift certificates from an order to the actual order.
	 * This function subtracts the balances from the gift certificates as well as
	 * logs a record in the gift certificates table. It is called once an order is successfully
	 * placed.
	 *
	 * @param float The total of the order.
	 * @param array Array of gift certificates that are being applied to the order. This is the array from the checkout session.
	 * @param float The remaining balance of the order if there is one, passed back by reference
	 * @param array An array passed back by reference containing details for all the bad gift certificates that can't applied to the order.
	 *
	 */
	public function CompanyGiftCertificatesApplicableToOrder($orderTotal, $giftCertificates, &$remainingBalance, &$badGiftCertificates)
	{
		// If no gift certificates were used in this order, we don't need to do anything
		if(!is_array($giftCertificates) || count($giftCertificates) == 0) {
			return;
		}

		$remainingBalance = $orderTotal;
		$certificates = array();

		// Load the gift certificates from the database. This will use up the smallest amounts on gift certificates
		// first before using larger amounts - so you don't end up with 10 x 20c gift certificates for example.
		$giftCertificateIds = implode(",", array_keys($giftCertificates));
		$query = sprintf("SELECT * FROM [|PREFIX|]company_gift_certificates WHERE cgcid IN (%s) ORDER BY cgcbalance ASC", $giftCertificateIds);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($certificate = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$certificates[$certificate['cgcid']] = $certificate;
		}

		foreach($giftCertificates as $id => $cert) {
			if(!isset($certificates[$id])) {
				$badGiftCertificates[$cert['cgccode']] = "invalid";
				continue;
			}
			else {
				$certificate = $certificates[$id];

				// There is no remaining balance on this gift certificate - how did they even use it?
				if($certificate['cgcbalance'] == 0) {
					$badGiftCertificates[$certificate['cgccode']] = "balance";
					continue;
				}
				else if($certificate['cgcstatus'] != 2 && $certificate['cgcstatus'] != 4) {
					$badGiftCertificates[$cert['cgccode']] = "invalid";
					continue;
				}
				else if($certificate['cgcexpirydate'] != 0 && $certificate['cgcexpirydate'] < time()) {
					if($certificate['cgcstatus'] != 4) {
						$updatedCert = array(
							"cgcstatus" => 4
						);
						$GLOBALS['ISC_CLASS_DB']->UpdateQuery("company_gift_certificates", $updatedCert, "cgcid='".$GLOBALS['ISC_CLASS_DB']->Quote($certificate['cgcid'])."'");
					}
					$badGiftCertificates[$cert['cgccode']] = array("expired", $certificate['cgcexpirydate']);
					continue;
				}
				else {
					// Using all of this gift certificate
					if($remainingBalance >= $certificate['cgcbalance']) {
						$remainingBalance -= $certificate['cgcbalance'];
						$balanceUsed = $certificate['cgcbalance'];
						$newCertificateBalance =  0;
					}
					// Using part of this balance
					else {
						$newCertificateBalance = $certificate['cgcbalance'] - $remainingBalance;
						$balanceUsed = $certificate['cgcbalance'] - $newCertificateBalance;
						$remainingBalance = 0;
					}
				}
			}
		}
		if(count($badGiftCertificates) > 0) {
			return false;
		}
		return true;
	}

	

	public function ApplyCompanyGiftCertificatesToOrder($orderId, $orderTotal, $giftCertificates, &$usedCertificates)
	{
		$remainingBalance = $orderTotal;
//d($remainingBalance);
		// If no gift certificates were used in this order, we don't need to do anything
		if(!is_array($giftCertificates) || count($giftCertificates) == 0) {
			return;
		}
//d($giftCertificates);
		$remainingBalance = $orderTotal;
		$GLOBALS['ISC_CLASS_CUSTOMER'] = GetClass('ISC_CUSTOMER');
        $GLOBALS['ISC_CLASS_CHECKOUT'] = GetClass('ISC_CHECKOUT');
        $orderSummary = $GLOBALS['ISC_CLASS_CHECKOUT']->CalculateOrderSummary();
        
        $hash_cgc_calculated = array();
        foreach($orderSummary["companyGiftCertificates"] as $cgcitem){
            $hash_cgc_calculated[$cgcitem["cgcid"]] = $cgcitem;
        }
        
        
        
        
		$customerId = $GLOBALS['ISC_CLASS_CUSTOMER']->GetCustomerId();

		$giftCertificateIds = implode(",", array_keys($giftCertificates));
//d($giftCertificates);
		$query = sprintf("SELECT * FROM [|PREFIX|]company_gift_certificates WHERE cgcid IN (%s) ORDER BY cgcbalance ASC", $giftCertificateIds);
//d($query);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($certificate = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$certid = $certificate['cgcid'];
			$balance = $certificate['cgcbalance'];
//d($certificate);
			// has this certificate already been saved for this order?
			$query = "SELECT * FROM [|PREFIX|]company_gift_certificate_history WHERE histcgcid = " . $certid . " and historderid = ". $orderId;
//d($query);
			$certresult = $GLOBALS['ISC_CLASS_DB']->Query($query);
			if ($hist = $GLOBALS['ISC_CLASS_DB']->Fetch($certresult)) {
				// temporarily recredit the balance
				$balance += $hist['histbalanceused'];

				// remove this record
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('company_gift_certificate_history', 'WHERE historyid = ' . $hist['historyid']);
			}

			// Using all of this gift certificate
			if($remainingBalance >= $balance) {
				$remainingBalance -= $balance;
				$newCertificateBalance =  0;
                $newCertificateUsed = $balance;
			}
			// Using part of this balance
			else {
				$newCertificateBalance = $balance - $remainingBalance;
                $newCertificateUsed = $remainingBalance;
			}
            
            $newCertificateBalance = empty($hash_cgc_calculated) ? $newCertificateBalance : $hash_cgc_calculated[$certid]["balanceremaining"];
            $newCertificateUsed = empty($hash_cgc_calculated) ? $newCertificateUsed : $hash_cgc_calculated[$certid]["amountused"];

			// Update the balance of this gift certificate
			$updatedCertificate = array(
				"cgcbalance" => $newCertificateBalance
			);
			if($newCertificateBalance == 0) {
				$updatedCertificate['cgcstatus'] = 4;
			}
			$GLOBALS['ISC_CLASS_DB']->UpdateQuery("company_gift_certificates", $updatedCertificate, "cgcid='" . $GLOBALS['ISC_CLASS_DB']->Quote($certid) . "'");

			// Log the balance change in the history table
			$newHistoryEntry = array(
				"histcgcid" => $certid,
				"historderid" => $orderId,
				"histcustomerid" => $customerId,
				//"histbalanceused" => $balance - $newCertificateBalance, // Jack Modify 20100831
                "histbalanceused" => $newCertificateUsed,
				"histbalanceremaining" => $newCertificateBalance,
				"historddate" => time()
			);

			$GLOBALS['ISC_CLASS_DB']->InsertQuery("company_gift_certificate_history", $newHistoryEntry);

			// Send back this gift certificate so we can tell the customer it was used
			$usedCertificates[] = array(
				"cgccode" => $certificate['cgccode'],
				"cgcbalance" => $newCertificateBalance,
				"cgcexpiry" => $certificate['cgcexpirydate']
			);
		}

		// check for any gift certificates in an order that have been removed and recredit them
		$query = sprintf("SELECT * FROM [|PREFIX|]company_gift_certificate_history WHERE historderid = %s AND histcgcid NOT IN (%s)", $orderId, $giftCertificateIds);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			// recredit and activate the certificate
			$query = "UPDATE [|PREFIX|]company_gift_certificates SET cgcbalance = cgcbalance + " . $row['histbalanceused'] . ", cgcstatus = 2 WHERE cgctid = " . $row['histcgctid'];
			$GLOBALS['ISC_CLASS_DB']->Query($query);
		}

		// delete the removed certificates
		$query = sprintf("DELETE FROM [|PREFIX|]company_gift_certificate_history WHERE historderid = %s  AND histcgcid NOT IN (%s)", $orderId, $giftCertificateIds);
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
	}

	

	

}

?>
