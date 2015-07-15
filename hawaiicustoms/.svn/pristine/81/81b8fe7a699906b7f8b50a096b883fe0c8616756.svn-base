<?php

class ACCOUNTING_QUICKBOOKS_ENTITIES_INVENTORYLEVEL extends ACCOUNTING_QUICKBOOKS_ENTITIES_BASE
{
	protected function xml()
	{
		$this->xmlNode->startElement('AccountRef');
		$this->writeElementCData('FullName', GetLang('QuickBooksIncomeAccountName'));
		$this->xmlNode->endElement();

		foreach ($this->data->nodeData as $setup) {
			$this->xmlNode->startElement('InventoryAdjustmentLineAdd');
				$this->xmlNode->startElement('ItemRef');
				$this->xmlNode->writeElement('ListID', $setup['ListID']);
				$this->xmlNode->endElement();

				$this->xmlNode->startElement('QuantityAdjustment');
				$this->xmlNode->writeElement('QuantityDifference', (int)$setup['QuantityDifference']);
				$this->xmlNode->endElement();
			$this->xmlNode->endElement();
		}

		return $this->buildOutput();
	}

	/**
	 * No queries as they are broken in QuickBooks
	 */
	protected function xmlquery()
	{
	}
}