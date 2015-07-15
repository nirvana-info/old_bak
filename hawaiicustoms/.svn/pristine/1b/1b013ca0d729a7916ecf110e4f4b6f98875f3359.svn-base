<?php

class ACCOUNTING_QUICKBOOKS_ENTITIES_ACCOUNT extends ACCOUNTING_QUICKBOOKS_ENTITIES_BASE
{
	protected function xml()
	{
		if (isc_strtolower($this->data->service) == 'accountmod') {
			if (isset($this->data->nodeData['ListID'])) {
				$this->xmlNode->writeElement('ListID', $this->data->nodeData['ListID']);
				$this->xmlNode->writeElement('EditSequence', $this->data->nodeData['EditSequence']);
			}
		}

		$this->writeElementCData('Name', $this->data->nodeData['Name']);

		if (isset($this->data->nodeData['IsActive'])) {
			$this->xmlNode->writeElement('IsActive', (int)$this->data->nodeData['IsActive']);
		}

		$this->writeElementCData('AccountType', $this->data->nodeData['AccountType']);

		if (isset($this->data->nodeData['Desc'])) {
			$this->writeElementCData('Desc', $this->data->nodeData['Desc']);
		}

		return $this->buildOutput();
	}

	protected function xmlquery()
	{
		$this->writeElementCData('FullName', $this->data->nodeData['Name']);

		return $this->buildOutput(true);
	}
}