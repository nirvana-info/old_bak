<?php
class ISC_ADMIN_EXPORTFILETYPE_ORDERS extends ISC_ADMIN_EXPORTFILETYPE
{
	private $product_fields;
	private $combined_fields;

	protected $type_name = "orders";
	protected $type_icon = "order.gif";
	protected $type_idfield = "orderid";
	protected $type_viewlink = "index.php?ToDo=viewOrders";

	protected $handleproducts = false;
	protected $handlebillformfields = false;
	protected $handleshipformfields = false;

	protected $glaccount = "";

	public function GetFields()
	{
		$fields = array(
			"orderID"			=> array("dbfield" => "orderid"),
			"orderStatus"		=> array("dbfield" => "s.statusdesc"),
			//alandy_2012-3-29 modify.reason mysql time zone don't consistent with php.
			"orderDate"			=> array("dbfield" => "from_unixtime(orddate)"),
			"orderSubtotal"		=> array("dbfield" => "ordsubtotal", "format" => "number"),
			"orderTaxtotal"		=> array("dbfield" => "ordtaxtotal", "format" => "number"),
			"orderTaxRate"		=> array("dbfield" => "ordtaxrate", "format" => "number"),
			"orderTaxName"		=> array("dbfield" => "ordtaxname"),
			"orderTotalIncTax"	=> array("dbfield" => "ordtotalincludestax", "format" => "bool"),
			"orderShipCost"		=> array("dbfield" => "ordshipcost", "format" => "number"),
			"orderHandlingCost"	=> array("dbfield" => "ordhandlingcost"),
			"orderTotalAmount"	=> array("dbfield" => "ordtotalamount", "format" => "number"),
			"orderCustomerID"	=> array("dbfield" => "ordcustid"),
			"orderShipMethod"	=> array("dbfield" => "ordshipmethod"),
			"orderPayMethod"	=> array("dbfield" => "orderpaymentmethod"),
			"orderTotalQty"		=> array("dbfield" => "ordtotalqty"),
			"orderTotalShipped"	=> array("dbfield" => "ordtotalshipped"),
			"orderDateShipped"	=> array("dbfield" => "orddateshipped", "format" => "date"),
			"orderTrackingNo"	=> array("dbfield" => "ordtrackingno"),
			"orderCurrency"		=> array("dbfield" => "c.currencycode"),
			"orderExchangeRate"	=> array("dbfield" => "ordcurrencyexchangerate"),
			"orderNotes"		=> array("dbfield" => "ordnotes"),
			"orderCustMessage"	=> array("dbfield" => "ordcustmessage"),
			"billName"			=> array("dbfield" => "CONCAT(ordbillfirstname, ' ', ordbilllastname)"),
			"billFirstName"		=> array("dbfield" => "ordbillfirstname"),
			"billLastName"		=> array("dbfield" => "ordbilllastname"),
			"billCompany"		=> array("dbfield" => "ordbillcompany"),
			"billStreet1"		=> array("dbfield" => "ordbillstreet1"),
			"billStreet2"		=> array("dbfield" => "ordbillstreet2"),
			"billSuburb"		=> array("dbfield" => "ordbillsuburb"),
			"billState"			=> array("dbfield" => "ordbillstate"),
			"billStateAbbrv"	=> array("dbfield" => "billstate.stateabbrv"),
			"billZip"			=> array("dbfield" => "ordbillzip"),
			"billCountry"		=> array("dbfield" => "ordbillcountry"),
			"billSSC"			=> array("dbfield" => "CONCAT(ordbillsuburb, '  ', billstate.stateabbrv, '  ', ordbillzip)"),
			"billPhone"			=> array("dbfield" => "ordbillphone"),
			"billEmail"			=> array("dbfield" => "ordbillemail"),
			"billFormFields"	=> array(),
			"shipName"			=> array("dbfield" => "CONCAT(ordshipfirstname, ' ', ordshiplastname)"),
			"shipFirstName"		=> array("dbfield" => "ordshipfirstname"),
			"shipLastName"		=> array("dbfield" => "ordshiplastname"),
			"shipCompany"		=> array("dbfield" => "ordshipcompany"),
			"shipStreet1"		=> array("dbfield" => "ordshipstreet1"),
			"shipStreet2"		=> array("dbfield" => "ordshipstreet2"),
			"shipSuburb"		=> array("dbfield" => "ordshipsuburb"),
			"shipState"			=> array("dbfield" => "ordshipstate"),
			"shipStateAbbrv"	=> array("dbfield" => "shipstate.stateabbrv"),
			"shipZip"			=> array("dbfield" => "ordshipzip"),
			"shipCountry"		=> array("dbfield" => "ordshipcountry"),
			"shipSSC"			=> array("dbfield" => "CONCAT(ordshipsuburb, '  ', shipstate.stateabbrv, '  ', ordshipzip)"),
			"shipPhone"			=> array("dbfield" => "ordshipphone"),
			"shipEmail"			=> array("dbfield" => "ordshipemail"),
			"shipFormFields"	=> array(),
			"orderProdDetails"	=> array(
										"help" => "This field displays either all the products from the order or the specified fields of an individiual product, depending on your chosen method above.",
										"fields" => array(
														"orderProdID"			=> array(),
														"orderProdQty"			=> array(),
														"orderProdSKU"			=> array(),
														"orderProdName"			=> array(),
														"orderProdPrice"		=> array("format" => "number"),
														"orderProdIndex"		=> array(),
														"orderProdTotalPrice"	=> array("format" => "number"),
														"orderGLAccount"		=> array(),
														"orderPTTaxType" 		=> array(),
														"DISCOUNTAMOUNT" 		=> array(),
														"MAKE" 		=> array(),
														"MODEL" 	=> array(),
														"YEAR" 		=> array(),
														"COUPONCODE" 			=> array()
														


												)
										),
			"orderProductCount" => array("dbfield" => "(SELECT COUNT(*) FROM [|PREFIX|]order_products WHERE orderorderid = o.orderid)"),
			"orderTodaysDate"	=> array("dbfield" => "UNIX_TIMESTAMP()", "format" => "date"),
			"orderAccountsReceivable"	=> array(),
			"orderOwner"	=> array("dbfield" => "orderOwner"),
		);

		//aditional fields added by blessen
		//$fields["COUPONCODE"] = array("dbfield" => " ordcouponcode ");
		//$fields["DISCOUNTAMOUNT"] = array("dbfield" => " (ordprodoriginalcost - ordprodcost) ");
		//$fields["MAKE"] = array("dbfield" => " ordmake ");
		//$fields["MODEL"] = array("dbfield" => " ordmodel ");
		//$fields["YEAR"] = array("dbfield" => " ordyear ");

		return $fields;
	}

	protected function PostFieldLoad()
	{
		$fields = $this->fields;

		if ($this->templateid) {
			$this->fields['orderAccountsReceivable']['dbfield'] = "'" . $GLOBALS['ISC_CLASS_DB']->Quote($this->template['peachtreereceivableaccount']) . "'";
			$this->glaccount = $this->template['peachtreeglaccount'];

			// determine if we need to do handling for products
			if ($fields['orderProdDetails']['used']) {
				$prodfieldsused = false;
				foreach ($fields['orderProdDetails']['fields'] as $id => $field) {
					if ($field['used']) {
						$prodfieldsused = true;
						break;
					}
				}

				$this->handleproducts = $prodfieldsused;
			}

			if ($fields['billFormFields']['used']) {
				// the export fields to insert
				$this->fields = $this->InsertFormFields(FORMFIELDS_FORM_BILLING, "billFormFields", $this->fields, GetLang("billFormFieldsFormat"));

				// check if form fields were inserted, if they were then customerFormFields won't exist anymore
				if (isset($this->fields['billFormFields'])) {
					// no form fields, disable the column
					$this->fields['billFormFields']['used'] = false;
				}
				else {
					$this->handlebillformfields = true;
				}
			}

			if ($fields['shipFormFields']['used']) {
				// the export fields to insert
				$this->fields = $this->InsertFormFields(FORMFIELDS_FORM_SHIPPING, "shipFormFields", $this->fields, GetLang("shipFormFieldsFormat"));

				// check if form fields were inserted, if they were then customerFormFields won't exist anymore
				if (isset($this->fields['shipFormFields'])) {
					// no form fields, disable the column
					$this->fields['shipFormFields']['used'] = false;
				}
				else {
					$this->handleshipformfields = true;
				}
			}
		}
	}

	protected function GetQuery($columns, $where, $vendorid)
	{
		if ($vendorid) {
			if ($where) {
				$where .= " AND ";
			}
			$where .= "o.ordvendorid = '" . $vendorid . "'";
		}

		if ($where) {
			$where = " WHERE " . $where;
		}

		 $query = "
			SELECT
				" . $columns . ",
				o.orderid AS ordid,
				o.ordformsessionid,
				CASE 
				WHEN o.orderOwner >0 then u.username
				ELSE 'System'
				End orderOwner
				
			FROM
				[|PREFIX|]orders o
				LEFT JOIN [|PREFIX|]order_status s ON s.statusid = o.ordstatus
				LEFT JOIN [|PREFIX|]currencies c ON c.currencyid = o.ordcurrencyid
				LEFT JOIN [|PREFIX|]customers cu ON o.ordcustid = cu.customerid
				LEFT JOIN [|PREFIX|]country_states billstate ON billstate.stateid = o.ordbillstateid
				LEFT JOIN [|PREFIX|]country_states shipstate ON shipstate.stateid = o.ordshipstateid
				LEFT JOIN [|PREFIX|]users u ON o.orderOwner = u.pk_userid
			" . $where;

		// only get orders for current vendor
		if($GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId()) {
			$query .= " AND ordvendorid = '" . (int)$GLOBALS['ISC_CLASS_ADMIN_AUTH']->GetVendorId() . "'";
		}



		return $query;
	}

	protected function HandleRow($row)
	{
		if ($this->handleproducts) {
			// get the products for the order
 $query = "
		SELECT
			ordprodid AS orderProdID,
			IF ( prodvendorprefix IS NULL,ordprodsku,CONCAT_WS(' ',prodvendorprefix,ordprodsku)) AS orderProdSKU,
			(ordprodoriginalcost - ordprodcost) AS DISCOUNTAMOUNT,
			ordmake AS MAKE,
			ordmodel AS MODEL,
			ordyear AS YEAR,
			ordprodname AS orderProdName,
			ordprodqty AS orderProdQty,
			ordprodcost AS orderProdPrice,
			(ordprodcost * ordprodqty) AS orderProdTotalPrice,
			'' AS orderProdIndex,
			p.prodpeachtreegl AS orderGLAccount,
			'1' AS orderPTTaxType
		FROM
			[|PREFIX|]order_products op
			LEFT JOIN [|PREFIX|]products p ON p.productid = op.ordprodid
			
		WHERE
			orderorderid = '" . $row['ordid'] . "'";


			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			$products = array();
			$x = 0;

		


			while ($product = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

				
				$prod_fields = array();
				foreach ($this->fields['orderProdDetails']['fields'] as $id => $field) {
					if ($field['used'] && isset($product[$id])) {
						$prod_fields[$id] = $product[$id];
					}
				}

				if ($this->fields['orderProdDetails']['fields']['orderProdIndex']['used']) {
					$prod_fields['orderProdIndex'] = ++$x;
				}

	if ($this->fields['orderProdDetails']['fields']['COUPONCODE']['used']) {

					
	$query2 = " select ordcouponcode FROM [|PREFIX|]order_coupons where  ordcouporderid =". $row['ordid'];
	$result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
	$row2 = $GLOBALS["ISC_CLASS_DB"]->Fetch($result2);
	$prod_fields['COUPONCODE'] =  $row2['ordcouponcode'];


	}

				if ($this->template['modifyforpeachtree'] && $this->fields['orderProdDetails']['fields']['orderProdTotalPrice']['used']) {
					$prod_fields['orderProdTotalPrice'] *= -1;
				}

				if ($this->fields['orderProdDetails']['fields']['orderGLAccount']['used']) {
					if (is_null($prod_fields['orderGLAccount'])) {
						$prod_fields['orderGLAccount'] = "";
					}

					if ($prod_fields['orderGLAccount'] == "") {
						$prod_fields['orderGLAccount'] = $this->glaccount;
					}

					
				}

				// apply any field formatting
				$this->FormatColumns($prod_fields, $this->fields['orderProdDetails']['fields']);

				//$new_row = $row;
				$products[] = $prod_fields;


			}


			


			// add a shipping line for peachtree
			if ($this->template['modifyforpeachtree']) {
				$query = "SELECT ordshipcost, ordshipmethod FROM [|PREFIX|]orders WHERE orderid = " . $row['ordid'];
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$shipping = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

				$shipping_row = array(
					"orderProdID"			=> "",
					"orderProdQty"			=> "0",
					"orderProdSKU"			=> "",
					"orderProdName"			=> "Freight Amount",
					"orderProdPrice"		=> "0",
					"orderProdIndex"		=> "0",
					"orderProdTotalPrice"	=> $shipping['ordshipcost'] * -1,
					"orderGLAccount"		=> $this->glaccount,
					"orderPTTaxType" 		=> "26"
				);

				$prod_fields = array();
				foreach ($this->fields['orderProdDetails']['fields'] as $id => $field) {
					if ($field['used'] && isset($shipping_row[$id])) {
						$prod_fields[$id] = $shipping_row[$id];
					}
				}

				$products[] = $prod_fields;

				if ($this->fields['orderProductCount']['used']) {
					$row['orderProductCount']++;
				}
			}

			$row['orderProdDetails'] = $products;
		}

		if ($this->handlebillformfields) {
			// get the form fields with data for this customer
			$this->LoadFormFieldData(FORMFIELDS_FORM_BILLING, "billFormFields", $row, $row['ordformsessionid']);
		}

		if ($this->handlebillformfields) {
			// get the form fields with data for this customer
			$this->LoadFormFieldData(FORMFIELDS_FORM_SHIPPING, "shipFormFields", $row, $row['ordformsessionid']);
		}

		return $row;
	}

	public function GetListColumns()
	{
		$columns = array(
			"ID",
			"Customer",
			"Date",
			"Status",
			"Tracking No.",
			"Total"
		);

		return $columns;
	}

	public function GetListSortLinks()
	{
		$sortLinks = array(
			"ID" => "orderid",
			"Customer" => "custname",
			"Date" => "orddate",
			"Status" => "ordstatustext",
			"Tracking" => "ordtrackingno",
			"Total" => "ordtotalamount"
		);

		return $sortLinks;
	}

	public function GetListQuery($where, $vendorid, $sortField, $sortOrder)
	{
		if (!$where) {
			// for all non-incomplete orders
			$where = "o.ordstatus != 0";
		}

		if ($vendorid) {
			if ($where) {
				$where .= " AND ";
			}
			$where .= "o.ordvendorid = '" . $vendorid . "'";
		}

		$query = "
				SELECT
					o.orderid,
					o.orddate,
					o.ordtotalamount,
					o.orddefaultcurrencyid,
					o.ordstatus,
					s.statusdesc AS ordstatustext,
					CONCAT(custconfirstname, ' ', custconlastname) AS custname,
					o.ordtrackingno
				FROM
					[|PREFIX|]orders o
					LEFT JOIN [|PREFIX|]customers c ON (o.ordcustid = c.customerid)
					LEFT JOIN [|PREFIX|]order_status s ON (s.statusid = o.ordstatus)
				WHERE
					" . $where . "
				ORDER BY "
					. $sortField . " " . $sortOrder;

		return $query;
	}

	public function GetListCountQuery($where, $vendorid)
	{
		if (!$where) {
			// for all non-incomplete orders
			$where = "o.ordstatus != 0";
		}

		if ($vendorid) {
			if ($where) {
				$where .= " AND ";
			}
			$where .= "o.ordvendorid = '" . $vendorid . "'";
		}

		$query = "
				SELECT
					COUNT(*) AS ListCount
				FROM
					[|PREFIX|]orders o
					LEFT JOIN [|PREFIX|]customers c ON (o.ordcustid = c.customerid)
					LEFT JOIN [|PREFIX|]order_status s ON (s.statusid = o.ordstatus)
				WHERE
					" . $where;

		return $query;
	}


	public function GetListRow($row)
	{
		$new_row['ID'] = $row['orderid'];
		$new_row['Customer'] = $row['custname'];

		$new_row['Date'] = isc_date(GetConfig('DisplayDateFormat'), $row['orddate']);

		if ($row['ordstatus'] == 0) {
			$new_row['Status'] = GetLang('Incomplete');
		}
		else {
			$new_row['Status'] = $row['ordstatustext'];
		}

		$new_row['Tracking No.'] = $row['ordtrackingno'];

		$new_row['Total'] = FormatPriceInCurrency($row['ordtotalamount'], $row['orddefaultcurrencyid'], null, true);

		return $new_row;
	}

	protected function BuildWhereFromFields($search_fields)
	{
		$class = GetClass('ISC_ADMIN_ORDERS');

		$res = $class->BuildWhereFromVars($search_fields);
		$where = $res['query'];
		// strip AND from beginning and end of statement
		$where = preg_replace("/^( ?AND )?|( AND ?)?$/i", "", $where);

		return $where;
	}

	public function HasPermission()
	{
		return $GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Export_Orders);
	}
}
?>