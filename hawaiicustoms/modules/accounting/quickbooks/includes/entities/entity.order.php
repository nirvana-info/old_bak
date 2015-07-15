<?php

class ACCOUNTING_QUICKBOOKS_ENTITIES_ORDER extends ACCOUNTING_QUICKBOOKS_ENTITIES_BASE
{
	protected function xml()
	{
		$order =& $this->data->nodeData;

		if (!$order) {
			throw new Exception('Cannot load product with nodeId: ' . $this->data->nodeId);
		}

		if (isc_strtolower($this->data->service) == 'salesordermod') {
			$reference = $this->quickbooks->getAccountingReference($this->data->nodeId, 'order');

			/**
			 * Yes, TnxID, don't ask, just do
			 */
			if (isset($reference['TnxID'])) {
				$this->xmlNode->writeElement('TxnID', $reference['TnxID']);
				$this->xmlNode->writeElement('EditSequence', $reference['EditSequence']);
			}
		}

		$customerRef = $this->quickbooks->getAccountingReference($order['customer']['customerid'], 'customer');

		$this->xmlNode->startElement('CustomerRef');
		$this->xmlNode->writeElement('ListID', $customerRef['ListID']);
		$this->xmlNode->endElement();

		if (isset($order['orddate'])) {
			$this->xmlNode->writeElement('TxnDate', date("Y-m-d", $order['orddate']));
		}

		if (isset($order['orderid'])) {
			$this->xmlNode->writeElement('RefNumber', 'CART:' . str_pad($order['orderid'], 6, '0', STR_PAD_LEFT));
		}

		if (isset($order['customer']) && is_array($order['customer'])) {

			if (!isset($order['customer']['billing_address']) && isset($order['customer']['shipping_address'])) {
				$order['customer']['billing_address'] = $order['customer']['shipping_address'];
			}

			/**
			 * Billing Address
			 */
			if (isset($order['customer']['billing_address'])) {
				$bill =& $order['customer']['billing_address'];

				$this->xmlNode->startElement('BillAddress');

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

			if (isset($order['customer']['shipping_address'])) {
				$ship =& $order['customer']['shipping_address'];

				$this->xmlNode->startElement('ShipAddress');

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
		}

		/**
		 * Now to recursively add the products
		 */
		if (isset($order['products']) && is_array($order['products'])) {
			foreach ($order['products'] as $product) {

				$productRef = $this->quickbooks->getAccountingReference($product['productid'], 'product');

				if (isc_strtolower($this->data->service) == 'salesordermod') {
					$this->xmlNode->startElement('SalesOrderLineMod');

					/**
					 * Add in the TxnLineID if item was in the previous order
					 */
					$prevProdData = array(
						'TnxID'			=> $reference['TnxID'],
						'EditSequence'	=> $reference['EditSequence'],
						'ProductID'		=> $product['productid']
					);

					$prevProdRef = $this->quickbooks->getAccountingReference($prevProdData, 'orderlineitem');

					if ($prevProdRef) {
						$this->xmlNode->writeElement('TxnLineID', $prevProdRef['TxnLineID']);
					} else {
						$this->xmlNode->writeElement('TxnLineID', '-1');
					}
				} else {
					$this->xmlNode->startElement('SalesOrderLineAdd');
				}

				$this->xmlNode->startElement('ItemRef');
				$this->xmlNode->writeElement('ListID', $productRef['ListID']);
				$this->xmlNode->endElement();

				$this->writeElementCData('Desc', isc_substr(trim($product['prodname']), 0, 31));
				$this->xmlNode->writeElement('Quantity', (int)$product['prodorderquantity']);
				$this->xmlNode->writeElement('Amount', number_format($product['prodorderamount'], 2, '.', ''));

				$this->xmlNode->endElement();
			}
		}

		return $this->buildOutput();
	}
}