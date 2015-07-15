<?php

class ACCOUNTING_QUICKBOOKS_ENTITIES_CUSTOMERGROUP extends ACCOUNTING_QUICKBOOKS_ENTITIES_BASE
{
	protected function xml()
	{
		$group =& $this->data->nodeData;

		if (!$group) {
			throw new Exception('Cannot load customer group with nodeId: ' . $this->data->nodeId);
		}

		if (isc_strtolower($this->data->service) == 'pricelevelmod') {
			$reference = $this->quickbooks->getAccountingReference($this->data->nodeId, 'customergroup');
			if ($reference) {
				$this->xmlNode->writeElement('ListID', trim($reference['ListID']));
				$this->xmlNode->writeElement('EditSequence', trim($reference['EditSequence']));
			}
		}

		$this->writeElementCData('Name', $group['groupname']);

		if (isset($product['isactive']) && $product['isactive'] !== '') {
			$this->xmlNode->writeElement('IsActive', (int)$product['isactive']);
		}

		/**
		 * Must have this regardless if we have a percentage rate or not
		 */
		if (!isset($group['groupname']) || $group['groupname'] == '') {
			$group['groupname'] = 0;
		}

		$this->xmlNode->writeElement('PriceLevelFixedPercentage', (float)$group['discount']);

		return $this->buildOutput();
	}

	protected function xmlquery()
	{
		$group =& $this->data->nodeData;

		if (!$group) {
			throw new Exception('Cannot load customer group with nodeId: ' . $this->data->nodeId);
		}

		$this->writeElementCData('FullName', $group['groupname']);

		return $this->buildOutput(true);
	}
}