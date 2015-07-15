<?php

class ACCOUNTING_QUICKBOOKS_ENTITIES_CUSTOMER extends ACCOUNTING_QUICKBOOKS_ENTITIES_BASE
{
	protected function xml()
	{
		$customer =& $this->data->nodeData;

		if (!is_array($customer)) {
			throw new Exception('Cannot load customer with nodeId: ' . $this->data->nodeId);
		}

		if (isc_strtolower($this->data->service) == 'customermod') {
			$reference = $this->quickbooks->getAccountingReference($this->data->nodeId, 'customer');
			if ($reference) {
				$this->xmlNode->writeElement('ListID', trim($reference['ListID']));
				$this->xmlNode->writeElement('EditSequence', trim($reference['EditSequence']));
			}
		}

		/**
		 * If we have no name the use the email address as that is required through-out the site
		 */
		$name = trim($customer['custconfirstname'] . ' ' . $customer['custconlastname']);
		if ($name == '') {
			$name = $customer['custconemail'];
		}

		$this->writeElementCData('Name', $name);

		/**
		 * If modifying then it can only be used in versions 3.0 and up
		 */
		if (isc_strtolower($this->data->service) !== 'customermod' || $this->quickbooks->compareClientVersion('3.0')) {
			if (isset($customer['isactive']) && $customer['isactive'] !== '') {
				$this->xmlNode->writeElement('IsActive', (int)$customer['isactive']);
			}
		}

		$this->writeElementCData('CompanyName', isc_substr($customer['custconcompany'], 0, 41));

		/**
		 * Cannot be set if it is empty
		 */
		if ($customer['custconfirstname'] !== '') {
			$this->writeElementCData('FirstName', isc_substr($customer['custconfirstname'], 0, 25));
		}

		/**
		 * Same with this one
		 */
		if ($customer['custconlastname'] !== '') {
			$this->writeElementCData('LastName', isc_substr($customer['custconlastname'], 0, 25));
		}

		/**
		 * Assign the billing address if we don't have any
		 */
		if (!isset($customer['billing_address']) && isset($customer['shipping_address'])) {
			$customer['billing_address'] = $customer['shipping_address'];
		}

		/**
		 * Billing Address
		 */
		if (isset($customer['billing_address'])) {
			$this->xmlNode->startElement('BillAddress');

			$bill =& $customer['billing_address'];

			$this->writeElementCData('Addr1', isc_substr($bill['shipaddress1'], 0, 41));
			$this->writeElementCData('Addr2', isc_substr($bill['shipaddress2'], 0, 41));
			$this->writeElementCData('City', isc_substr($bill['shipcity'], 0, 31));

			if (!$this->quickbooks->compareClientCountry('uk')) {
				$this->writeElementCData('State', isc_substr($bill['shipstate'], 0, 21));
			} else {
				$this->writeElementCData('County', isc_substr($bill['shipstate'], 0, 21));
			}

			$this->writeElementCData('PostalCode', isc_substr($bill['shipzip'], 0, 13));
			$this->writeElementCData('Country', isc_substr($bill['shipcountry'], 0, 31));

			$this->xmlNode->endElement();
		}

		/**
		 * Shipping Address
		 */
		if (isset($customer['shipping_address'])) {
			$this->xmlNode->startElement('ShipAddress');

			$ship =& $customer['shipping_address'];

			$this->writeElementCData('Addr1', isc_substr($ship['shipaddress1'], 0, 41));
			$this->writeElementCData('Addr2', isc_substr($ship['shipaddress2'], 0, 41));
			$this->writeElementCData('City', isc_substr($ship['shipcity'], 0, 31));

			if (!$this->quickbooks->compareClientCountry('uk')) {
				$this->writeElementCData('State', isc_substr($ship['shipstate'], 0, 21));
			} else {
				$this->writeElementCData('County', isc_substr($ship['shipstate'], 0, 21));
			}

			$this->writeElementCData('PostalCode', isc_substr($ship['shipzip'], 0, 13));
			$this->writeElementCData('Country', isc_substr($ship['shipcountry'], 0, 31));

			$this->xmlNode->endElement();
		}

		$this->writeElementCData('Phone', $customer['custconphone']);
		$this->writeElementCData('Email', $customer['custconemail']);

		/**
		 * Add in the customer group reference if we can
		 */
		if ($this->quickbooks->compareClientVersion('4.0') && isset($customer['custgroupid']) && isId($customer['custgroupid'])) {
			$reference = $this->quickbooks->getAccountingReference($customer['custgroupid'], 'customergroup');

			if ($reference && is_object($priceref = $this->xmlNode->writeElement('PriceLevelRef'))) {
				$this->xmlNode->startElement('PriceLevelRef');
				$this->xmlNode->writeElement('ListID', $reference['ListID']);
				$this->xmlNode->endElement();
			}
		}

		return $this->buildOutput();
	}

	protected function xmlquery()
	{
		$customer =& $this->data->nodeData;

		if (!$customer) {
			throw new Exception('Cannot load customer with nodeId: ' . $this->data->nodeId);
		}

		/**
		 * If we have no name the use the email address as that is required through-out the site
		 */
		$name = trim($customer['custconfirstname'] . ' ' . $customer['custconlastname']);
		if ($name == '') {
			$name = $customer['custconemail'];
		}

		$this->writeElementCData('FullName', $name);

		return $this->buildOutput(true);
	}
}