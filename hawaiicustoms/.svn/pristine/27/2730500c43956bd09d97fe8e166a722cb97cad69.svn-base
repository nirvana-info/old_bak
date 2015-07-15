<?php
require_once("customers.php");

class ISC_ADMIN_EXPORTFILETYPE_CUSTOMERSALT extends ISC_ADMIN_EXPORTFILETYPE_CUSTOMERS {
	public $ignore = true;

	private $maxaddr = 0;

	private $addr_cache;

	private $headers;

	public function Init(ISC_ADMIN_EXPORTMETHOD $exportmethod, $templateid, $where, $vendorid)
	{
		parent::Init($exportmethod, $templateid, $where, $vendorid);

		if ($this->fields['customerAddresses']['used']) {
			for ($x = 0; $x < $this->maxaddr; $x++) {
				foreach ($this->fields['customerAddresses']['fields'] as $id => $field) {
					if ($field['used']) {
						$this->addr_cache[$x][$id . $x] = "";
					}
				}
			}
		}

		$this->headers = $this->GetHeaders(true);
	}

	protected function GetQuery($columns, $where, $vendorid)
	{
		$altwhere = "";
		if ($where) {
			$altwhere = " WHERE " . $where;
		}

		$query = "
			SELECT
				MAX(addrcount) AS maxaddr
			FROM
				(
				SELECT
					COUNT(shipid) AS addrcount
				FROM
					[|PREFIX|]customers c
					LEFT JOIN [|PREFIX|]customer_groups cg ON c.custgroupid = cg.customergroupid
					LEFT JOIN [|PREFIX|]shipping_addresses sa ON sa.shipcustomerid = c.customerid
				" . $altwhere . "
				GROUP BY
					c.customerid
				) AS addrquery
			";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);

		$this->maxaddr = $row['maxaddr'];

		return parent::GetQuery($columns, $where, $vendorid);
	}

	protected function RemoveExtraFields($row)
	{
		$new_row = $row;
		foreach ($row as $id => $value) {
			if (!in_array($id, array_keys($this->headers))) {
				unset($new_row[$id]);
			}
		}

		return $new_row;
	}

	public function GetHeaders($flatten = false, $remove_parent = true)
	{
		$header = array();

		$fields = $this->fields;

		foreach ($fields as $id => $field) {
			if ($field['used']) {
				if ($id == "customerAddresses") {
					for ($x = 0; $x < $this->maxaddr; $x++) {
						foreach ($fields['customerAddresses']['fields'] as $aid => $afield) {
							if ($afield['used']) {
								$header[$aid . $x] = $afield['header'] . " - " . ($x + 1);
							}
						}
					}
				}
				else {
					$header[$id] = $field['header'];
				}
			}
		}

		return $header;
	}

	protected function HandleRow($row)
	{
		if (!($this->handleaddresses || $this->handleformfields)) {
			return $row;
		}

		$row = parent::HandleRow($row);

		if ($this->handleaddresses) {
			$addresses = array();
			if (count($row['customerAddresses'])) {
				$x = 0;
				foreach ($row['customerAddresses'] as $address) {
					$addresses[] = array_combine(array_keys($this->addr_cache[$x]), array_values($address));
					$x++;
				}
			}

			// create empty addresses to fill up the array
			if (count($addresses) < $this->maxaddr) {
				$diff = $this->maxaddr - count($addresses);

				$start = $this->maxaddr - $diff;

				for ($x = $start; $x < $diff; $x++) {
					$addresses[] = $this->addr_cache[$x];
				}
			}

			$merged = array();
			foreach ($addresses as $address) {
				$merged = array_merge($merged, $address);
			}

			// position of the addresses in the row
			$position = $this->GetFieldPosition("customerAddresses");

			// generate the keys
			$keys = array_keys($row);
			$addr_keys = array_keys($merged);
			array_splice($keys, $position, 1, $addr_keys);

			// insert the addresses into row
			array_splice($row, $position, 1, $merged);

			$row = array_combine($keys, $row);
		}

		return $row;
	}
}
?>
