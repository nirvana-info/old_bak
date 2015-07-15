<?php

	if (!defined('ISC_BASE_PATH')) {
		die();
	}

	require_once(ISC_BASE_PATH.'/lib/class.xml.php');

	class ISC_ADMIN_REMOTE_CHECKOUT extends ISC_XML_PARSER
	{
		public function __construct()
		{
			include_once(ISC_BASE_PATH . "/lib/form.php");
			$GLOBALS['ISC_CLASS_FORM'] = new ISC_FORM();

			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('settings.checkout');

			parent::__construct();
		}

		public function HandleToDo()
		{
			/**
			 * Convert the input character set from the hard coded UTF-8 to their
			 * selected character set
			 */
			convertRequestInput();

			$what = isc_strtolower(@$_REQUEST['w']);

			switch ($what) {
				case "getcheckoutfieldgrid":
					$this->getCheckoutFieldGrid();
					break;

				case 'resortcheckoutfieldgrid':
					$this->resortCheckoutFieldGrid();
					break;

				case 'getwidgetsetuppopup':
					$this->getWidgetSetupPopup();
					break;

				case 'addwidgetsetuppopup':
					$this->addWidgetSetupPopup();
					break;

				case 'deletewidget':
					$this->deleteWidget();
					break;

				case 'deletemultiwidget':
					$this->deleteMultiWidget();
					break;

				case 'savewidgetsetup':
					$this->saveWidgetSetup();
					break;
			}
		}

		private function getCheckoutFieldGrid()
		{
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseFrontendLangFile();

			if (!isset($_POST['section']) || trim($_POST['section']) == '') {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('grid', '', true);
				$tags[] = $this->MakeXMLTag('section', '', true);
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}

			$GLOBALS['ISC_ADMIN_SETTINGS_CHECKOUT'] = GetClass('ISC_ADMIN_SETTINGS_CHECKOUT');
			$grid = $GLOBALS['ISC_ADMIN_SETTINGS_CHECKOUT']->GetCheckoutFieldGrid($_POST['section']);
			$section = $GLOBALS['ISC_ADMIN_SETTINGS_CHECKOUT']->MapCheckoutFieldSection($_POST['section'], true);

			if ($grid == '') {
				$grid = '<li><div class="MessageBox MessageBoxInfo" style="margin:0;">' . GetLang('CheckoutSectionNoFields') . '</div></li>';
			}

			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('grid', $grid, true);
			$tags[] = $this->MakeXMLTag('button', sprintf(GetLang('CheckoutFieldsAddWidget'), $section), true);
			$tags[] = $this->MakeXMLTag('sectonName', $section, true);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		private function resortCheckoutFieldGrid()
		{
			if (!isset($_POST['section']) || trim($_POST['section']) == '' || !isset($_POST['sortorder'])) {
				exit;
			}

			$GLOBALS['ISC_ADMIN_SETTINGS_CHECKOUT'] = GetClass('ISC_ADMIN_SETTINGS_CHECKOUT');
			$formId = $GLOBALS['ISC_ADMIN_SETTINGS_CHECKOUT']->MapCheckoutFieldSection($_POST['section']);

			if (!isId($formId)) {
				exit;
			}

			$idx = explode(',', $_POST['sortorder']);
			$idx = array_filter($idx, 'isId');

			if (!is_array($idx) || empty($idx)) {
				exit;
			}

			$sort = 1;
			foreach ($idx as $widgetId) {
				$GLOBALS['ISC_CLASS_DB']->UpdateQuery('formwidgets', array('formwidgetsort' => $sort++), 'formwidgetid=' . (int)$widgetId . ' AND formwidgetformid=' . (int)$formId);
			}

			exit;
		}

		private function getWidgetSetupPopup()
		{
			if (!isset($_GET['widgetId']) || !isId($_GET['widgetId']) || !isset($_GET['formId']) || !isId($_GET['formId'])) {
				exit;
			}

			$widget = $GLOBALS['ISC_CLASS_FORM']->getFormWidget($_GET['formId'], $_GET['widgetId']);

			$GLOBALS['FormWidgetSetupPopupHeading'] = GetLang('CheckoutFieldSetupPopupHeadingEdit');

			print $widget->loadForBackend(true);
			exit;
		}

		private function addWidgetSetupPopup()
		{
			if (!isset($_GET['widgetType']) || trim($_GET['widgetType']) == '' || !isset($_GET['section']) || trim($_GET['section']) == '') {
				exit;
			}

			$GLOBALS['ISC_ADMIN_SETTINGS_CHECKOUT'] = GetClass('ISC_ADMIN_SETTINGS_CHECKOUT');
			$formId = $GLOBALS['ISC_ADMIN_SETTINGS_CHECKOUT']->MapCheckoutFieldSection($_GET['section']);

			if (!isId($formId)) {
				exit;
			}

			$widget = $GLOBALS['ISC_CLASS_FORM']->getFormWidget($formId, '', $_GET['widgetType']);

			$GLOBALS['FormWidgetSetupPopupHeading'] = GetLang('CheckoutFieldSetupPopupHeadingAdd');

			print $widget->loadForBackend(true);
			exit;
		}

		private function deleteWidget()
		{
			if (!isset($_POST['widgetId']) || !isId($_POST['widgetId']) || !isset($_POST['formId']) || !isId($_POST['formId'])) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('widgetId', @$_POST['widgetId']);
				$tags[] = $this->MakeXMLTag('msg', GetLang('CheckoutFieldDeleteInvalid'));
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}

			$widget = $GLOBALS['ISC_CLASS_FORM']->getFormWidget($_POST['formId'], $_POST['widgetId']);
			$name = $widget->name;

			if (!$GLOBALS['ISC_CLASS_FORM']->deleteFormWidget($_POST['formId'], $_POST['widgetId'])) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('msg', sprintf(GetLang('CheckoutFieldDeleteFailed'), $name));
			} else {
				$tags[] = $this->MakeXMLTag('status', 1);
				$tags[] = $this->MakeXMLTag('msg', sprintf(GetLang('CheckoutFieldDeleteSuccess'), $name));
			}

			$tags[] = $this->MakeXMLTag('widgetId', $_POST['widgetId']);
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		private function deleteMultiWidget()
		{
			if (!isset($_POST['widgetIdx']) || trim($_POST['widgetIdx']) == '' || !isset($_POST['section']) || trim($_POST['section']) == '') {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('msg', sprintf(GetLang('CheckoutFieldDeleteSelectedFailed'), ''));
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}

			$selectedIdx = explode(',', $_POST['widgetIdx']);
			$selectedIdx = array_filter($selectedIdx, 'isId');

			if (!is_array($selectedIdx) || empty($selectedIdx)) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('msg', sprintf(GetLang('CheckoutFieldDeleteSelectedFailed'), ''));
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}

			$GLOBALS['ISC_ADMIN_SETTINGS_CHECKOUT'] = GetClass('ISC_ADMIN_SETTINGS_CHECKOUT');
			$formId = $GLOBALS['ISC_ADMIN_SETTINGS_CHECKOUT']->MapCheckoutFieldSection($_POST['section']);

			if (!isId($formId)) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('msg', sprintf(GetLang('CheckoutFieldDeleteSelectedFailed'), ''));
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}

			foreach ($selectedIdx as $widgetId) {
				$GLOBALS['ISC_CLASS_FORM']->deleteFormWidget($formId, $widgetId);
			}

			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('msg', GetLang('CheckoutFieldDeleteSelectedSuccess'));
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}

		private function saveWidgetSetup()
		{
			/**
			 * If we have no widget ID then we are saving a new widget
			 */
			if (!isset($_POST['widgetId']) || !isId($_POST['widgetId'])) {
				$type = 'add';
				$failed = 'CheckoutFieldSetupAddedFailed';
				$success = 'CheckoutFieldSetupAddedSuccess';
			} else {
				$type = 'update';
				$failed = 'CheckoutFieldSetupUpdateFailed';
				$success = 'CheckoutFieldSetupUpdateSuccess';
			}

			if (!isset($_POST['formId']) || !isId($_POST['formId'])) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('msg', sprintf(GetLang($failed), ''));
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}

			if ($type == 'add') {

				/**
				 * Check for the widget type as we need that
				 */
				if (!isset($_POST['widgetType']) || trim($_POST['widgetType']) == '') {
					$tags[] = $this->MakeXMLTag('status', 0);
					$tags[] = $this->MakeXMLTag('msg', sprintf(GetLang($failed), ''));
					$this->SendXMLHeader();
					$this->SendXMLResponse($tags);
					exit;
				}

				$widgetId = '';
				$type = isc_html_escape($_POST['widgetType']);
			} else {
				$widgetId = $_POST['widgetId'];
				$type = '';
			}

			$widget = $GLOBALS['ISC_CLASS_FORM']->getFormWidget($_POST['formId'], $widgetId, $type);
			$rtn = $widget->saveForBackend($_POST, $msg);

			if (!$rtn) {
				$tags[] = $this->MakeXMLTag('status', 0);
				$tags[] = $this->MakeXMLTag('msg', sprintf(GetLang($failed), $msg));
				$this->SendXMLHeader();
				$this->SendXMLResponse($tags);
				exit;
			}

			/**
			 * OK, all is good
			 */
			$tags[] = $this->MakeXMLTag('status', 1);
			$tags[] = $this->MakeXMLTag('msg', GetLang($success));
			$this->SendXMLHeader();
			$this->SendXMLResponse($tags);
			exit;
		}
	}
?>