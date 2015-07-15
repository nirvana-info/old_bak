<?php
if (!defined('ISC_BASE_PATH')) {
	die();
}

class ISC_ADMIN_REMOTE_DASHBOARD
{
	public function HandleToDo()
	{
		ConvertRequestInput();
		$what = isc_strtolower(@$_REQUEST['w']);
		switch($what) {
			case 'loadrecentorders':
				$this->LoadRecentOrders();
				break;
			case 'getperformanceindicators':
				$this->GetPerformanceIndicators();
				break;
		}
	}

	public function LoadRecentOrders()
	{
		echo GetClass('ISC_ADMIN_INDEX')->LoadRecentOrders();
	}

	public function GetPerformanceIndicators()
	{
		echo GetClass('ISC_ADMIN_INDEX')->GeneratePerformanceIndicatorsTable();
	}
}
?>