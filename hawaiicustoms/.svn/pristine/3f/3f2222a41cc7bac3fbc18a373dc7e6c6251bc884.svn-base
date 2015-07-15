<?php

class ACCOUNTING_QUICKBOOKS_ENTITIES_PRODUCT extends ACCOUNTING_QUICKBOOKS_ENTITIES_BASE
{
	protected function xml()
	{
		$product =& $this->data->nodeData;

		if (!$product) {
			throw new Exception('Cannot load product with nodeId: ' . $this->data->nodeId);
		}

		if (isc_strtolower($this->data->service) == 'iteminventorymod') {
			$reference = $this->quickbooks->getAccountingReference($this->data->nodeId, 'product');
			if ($reference) {
				$this->xmlNode->writeElement('ListID', $reference['ListID']);
				$this->xmlNode->writeElement('EditSequence', $reference['EditSequence']);
			}
		}

		/**
		 * The product name cannot have a colon in it, QB uses it as a parent -> child relationship separator
		 */
		$prodname = str_replace(':', ';', $product['prodname']);
		$prodname = isc_substr($prodname, 0, 31);
		$this->writeElementCData('Name', $prodname);

		if (isset($product['isactive']) && $product['isactive'] !== '') {
			$this->xmlNode->writeElement('IsActive', (int)$product['isactive']);
		}

		if ($this->quickbooks->compareClientVersion('7.0') && isset($product['prodcode']) && $product['prodcode'] !== '') {
			$this->writeElementCData('ManufacturerPartNumber', $product['prodcode']);
		}

		if ($product['prodistaxable']) {
			$tax = GetLang('QuickBooksSalesTaxCodeTaxName');
		} else {
			$tax = GetLang('QuickBooksSalesTaxCodeNonTaxName');
		}

		/**
		 * OK, different tag names for different versions for different countries. Good times, good times
		 */
		if ($this->quickbooks->compareClientCountry('uk') || $this->quickbooks->compareClientCountry('ca')) {
			if ($this->quickbooks->compareClientVersion('3.0')) {
				$this->xmlNode->startElement('TaxCodeForSaleRef');
			} else {
				$this->xmlNode->startElement('TaxCodeRef');
			}
		} else {
			$this->xmlNode->startElement('SalesTaxCodeRef');
		}

		$this->writeElementCData('FullName', $tax);
		$this->xmlNode->endElement();

		$this->writeElementCData('SalesDesc', isc_substr($product['prodname'], 0, 4095));
		$this->xmlNode->writeElement('SalesPrice', number_format($product['prodprice'], 2, '.', ''));

		/**
		 * We can only set this for the add process as the mod process is only available in versions 7.0 and above
		 */
		if (isc_strtolower($this->data->service) !== 'iteminventorymod' || $this->quickbooks->compareClientVersion('7.0')) {
			$this->xmlNode->startElement('IncomeAccountRef');
			$this->writeElementCData('FullName', GetLang('QuickBooksIncomeAccountName'));
			$this->xmlNode->endElement();
		}

		if (isset($product['prodcostprice']) && $product['prodcostprice'] > 0) {
			$this->writeElementCData('PurchaseDesc', isc_substr($product['prodname'], 0, 4095));
			$this->xmlNode->writeElement('PurchaseCost', number_format($product['prodcostprice'], 2, '.', ''));
		}

		$this->xmlNode->startElement('COGSAccountRef');
		$this->writeElementCData('FullName', GetLang('QuickBooksCOGSAccountName'));
		$this->xmlNode->endElement();

		$this->xmlNode->startElement('AssetAccountRef');
		$this->writeElementCData('FullName', GetLang('QuickBooksAssetAccountName'));
		$this->xmlNode->endElement();

		if (isset($product['prodlowinv']) && isId($product['prodlowinv'])) {
			$this->xmlNode->writeElement('ReorderPoint', (int)$product['prodlowinv']);
		}

		/**
		 * Cannot use this in the iteminventorymod service
		 */
		if (isc_strtolower($this->data->service) !== 'iteminventorymod') {
			if (isset($product['prodcurrentinv']) && isId($product['prodcurrentinv'])) {
				$this->xmlNode->writeElement('QuantityOnHand', (int)$product['prodcurrentinv']);
			}
		}

		if ($this->quickbooks->compareClientCountry('uk') && $this->quickbooks->compareClientVersion('2.0')) {
			if (GetConfig('PricesIncludeTax')) {
				$this->xmlNode->writeElement('AmountIncludesVAT', '1');
			} else {
				$this->xmlNode->writeElement('AmountIncludesVAT', '0');
			}
		}

		return $this->buildOutput();
	}

	protected function xmlquery()
	{
		$product =& $this->data->nodeData;

		if (!$product) {
			throw new Exception('Cannot load product with nodeId: ' . $this->data->nodeId);
		}

		/**
		 * The product name cannot have a colon in it, QB uses it as a parent -> child relationship separator
		 */
		$prodname = str_replace(':', ';', $product['prodname']);
		$prodname = isc_substr($prodname, 0, 31);
		$this->writeElementCData('FullName', $prodname);

		return $this->buildOutput(true);
	}
}