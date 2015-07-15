<?php

class ISC_ACCOUNTING_GATEWAY
{
	public function HandlePage()
	{
		$action = "";
		if (isset($_REQUEST['action'])) {
			$action = isc_strtolower($_REQUEST['action']);
		}

		switch($action) {
			case "showsupport": {
				$this->HandleSupport();
			}
			default: {
				$this->HandleGateway();
			}
		}
	}

	private function HandleGateway()
	{
		$accounting = null;

		/**
		 * If we stuff up then just exit here as we don't know what the provider was and so we can't return the error
		 */
		if (!array_key_exists('accounting', $_REQUEST) || !GetModuleById('accounting', $accounting, $_REQUEST['accounting'])) {
			exit;
		}

		return $accounting->handleGateway();
	}

	private function HandleSupport()
	{
		$accounting = null;

		if (!array_key_exists('accounting', $_REQUEST) || !GetModuleById('accounting', $accounting, $_REQUEST['accounting'])) {
			exit;
		}

		header('Location: ' . $accounting->_supporturl);
		exit;
	}
}

?>
