<?php

	if (!defined('ISC_BASE_PATH')) {
		die();
	}

	require_once(ISC_BASE_PATH.'/lib/class.xml.php');

	class ISC_ADMIN_REMOTE_PRODUCTS extends ISC_XML_PARSER
	{
		public function __construct()
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('products');
			//$this->xml();
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
				case "addcustomfield":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Create_Product) || $GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Edit_Products)) {
						$this->addCustomField();
					}
					exit;
					break;
				case "addproductfield":
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Products)) {
						$this->addProductField();
					}
					exit;
					break;
				case 'viewaffectedvariations':
					if ($GLOBALS['ISC_CLASS_ADMIN_AUTH']->HasPermission(AUTH_Manage_Products)) {
						$this->viewAffectedVariations();
					}
					exit;
					break;
			}
		}

		private function addCustomField()
		{
			if (!array_key_exists('nextId', $_REQUEST)) {
				print '';
				exit;
			}

			$GLOBALS['ISC_ADMIN_CLASS_PRODUCT'] = GetClass('ISC_ADMIN_PRODUCT');
			$GLOBALS['CustomFieldKey'] = $_REQUEST['nextId'];
			$GLOBALS['CustomFieldName'] = '';
			$GLOBALS['CustomFieldValue'] = '';
			$GLOBALS['CustomFieldLabel'] = $GLOBALS['ISC_ADMIN_CLASS_PRODUCT']->GetFieldLabel($_REQUEST['nextId']+1, GetLang('CustomField'));

			print $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('CustomFields');
			exit;
		}

		private function addProductField()
		{
			if (!isset($_REQUEST['nextId'])) {
				print '';
				exit;
			}

			$GLOBALS['ISC_ADMIN_CLASS_DB'] = GetClass('ISC_ADMIN_PRODUCT');
			$GLOBALS['ProductFieldName'] = GetLang('FieldName');
			$GLOBALS['FieldNameClass'] = 'FieldHelp';

			$GLOBALS['ProductFieldType'] = 'text';
			$GLOBALS['ProductFieldFileType'] = GetLang('FieldFileType');
			$GLOBALS['FileTypeClass'] = 'FieldHelp';
			$GLOBALS['ProductFieldFileSize'] = GetLang('FieldFileSize');
			$GLOBALS['FileSizeClass'] = 'FieldHelp';
			$GLOBALS['HideFieldFileType'] = 'display:none;';

			$GLOBALS['ProductFieldRequired'] = 0;
			$GLOBALS['ProductFieldKey'] =(int)$_REQUEST['nextId'];
			$GLOBALS['ProductFieldLabelNumber'] = $GLOBALS['ProductFieldKey'] +1;

			print $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('ProductFields');
			exit;
		}

		private function viewAffectedVariations()
		{
			/**
			 * Make sure we have our variation
			 */
			$variatonIdx = array();
			if (isset($_REQUEST['variationIdx'])) {
				$variatonIdx = explode(',', $_REQUEST['variationIdx']);
				$variatonIdx = array_filter($variatonIdx, 'isId');
			}

			if (empty($variatonIdx)) {
				print '';
				exit;
			}

			/**
			 * Also make sure that we were given a type (either 'edit' or 'delete') because without this then we do not
			 * know what is being removed
			 */
			$type = '';
			if (isset($_REQUEST['actionType'])) {
				$type = strtolower($_REQUEST['actionType']);
			}

			/**
			 * See if we were passed any option value Ids to cross check with
			 */
			$valueIdx = array();
			if (isset($_REQUEST['optionValueIdx'])) {
				$valueIdx = explode(',', $_REQUEST['optionValueIdx']);
				$valueIdx = array_filter($valueIdx, 'isId');
			}

			$affected = "";
			if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Edit_Products)) {
				$canEdit = true;
			} else {
				$canEdit = false;
			}

			switch (strtolower($type)) {
				case 'delete':
				case 'add':

					/**
					 * If we are deleting or adding then just work on the $variatonIdx. 'Add' goes in here aswell because if a value is added then ALL existing combintaions
					 * for that variation are invalid
					 */
					$tmpVarId = null;
					$tmpVarName = '';
					$products = array();

					$query = "SELECT v.variationid, v.vname, p.productid, p.prodname
								FROM [|PREFIX|]product_variations v
								JOIN [|PREFIX|]products p ON v.variationid = p.prodvariationid
								WHERE v.variationid IN(" . implode(',', $variatonIdx) . ")
								ORDER BY v.variationid";

					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						if (is_null($tmpVarId) || $tmpVarId !== $row['variationid']) {
							if (isId($tmpVarId)) {
								$GLOBALS['ProductName'] = $tmpVarName;
								$GLOBALS['ProductVariationList'] = '<li>' . implode('</li><li>', $products) . '</li>';
								$affected .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('VariationAffectedProducts');
							}

							$tmpVarId = $row['variationid'];
							$tmpVarName = $row['vname'];
							$products = array();
						}

						if ($canEdit) {
							$products[] = '<a class="Action" target="_blank" href="index.php?ToDo=editProduct&amp;productId=' . (int)$row['productid'] . '" title="' . isc_html_escape($row['prodname']) . '">' . isc_html_escape($row['prodname']) . '</a>';
						} else {
							$products[] = isc_html_escape($row['prodname']);
						}
					}

					/**
					 * Get the last one
					 */
					if (!empty($products)) {
						$GLOBALS['ProductName'] = $tmpVarName;
						$GLOBALS['ProductVariationList'] = '<li>' . implode('</li><li>', $products) . '</li>';
						$affected .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('VariationAffectedProducts');
					}

					break;

				case 'edit':

					/**
					 * If we're editing then use the $valueIdx aswell and ONLY use the first element in $variatonIdx as you can only edit one at a time
					 */
					$productId = null;
					$productName = '';
					$variations = array();
					$extraselect = '';

					if (!empty($valueIdx)) {
						$extraselect = " AND o.voptionid NOT IN(" . implode(',', $valueIdx) . ")";
					}

					$query = "SELECT p.productid, p.prodname, c.vcoptionids, GROUP_CONCAT(o.voptionid) AS valueidx
								FROM [|PREFIX|]products p
								JOIN [|PREFIX|]product_variation_options o ON p.prodvariationid = o.vovariationid
								JOIN [|PREFIX|]product_variation_combinations c ON o.vovariationid = c.vcvariationid AND p.productid = c.vcproductid
								WHERE p.prodvariationid = " . (int)$variatonIdx[0] . $extraselect . "
								GROUP BY c.combinationid";

					$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
					while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

						if ($row['valueidx'] == '') {
							continue;
						}

						/**
						 * Explode on the $row['vcoptionids'] and $row['valueidx'] and see if any of the $row['vcoptionids'] exist in $row['valueidx']
						 */
						$selectedValues = explode(',', $row['vcoptionids']);
						$deletedValues = explode(',', $row['valueidx']);
						$selected = false;
						foreach ($selectedValues as $idx) {
							if (in_array($idx, $deletedValues)) {
								$selected = true;
								break;
							}
						}

						/**
						 * Have we been affected by this edit?
						 */
						if ($selected) {
							if (is_null($productId) || $productId !== $row['productid']) {
								if (isId($productId)) {
									if ($canEdit) {
										$GLOBALS['ProductName'] = '<a class="Action" target="_blank" href="index.php?ToDo=editProduct&amp;productId=' . (int)$productId . '" title="' . isc_html_escape($productName) . '">' . isc_html_escape($productName) . '</a>';
									} else {
										$GLOBALS['ProductName'] = isc_html_escape($productName);
									}

									$GLOBALS['ProductVariationList'] = '<li>' . implode('</li><li>', $variations) . '</li>';
									$affected .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('VariationAffectedProducts');
								}

								$productId = $row['productid'];
								$productName = $row['prodname'];
								$variations = array();
							}

							$option = array();
							$sResult = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM [|PREFIX|]product_variation_options o WHERE voptionid IN(" . $row['vcoptionids'] . ")");
							while ($sRow = $GLOBALS['ISC_CLASS_DB']->Fetch($sResult)) {
								$option[] = isc_html_escape($sRow['voname'] . ': ' . $sRow['vovalue']);
							}

							$variations[] = implode(', ', $option);
						}
					}

					/**
					 * Get the last one
					 */
					if (!empty($variations)) {
						if ($canEdit) {
							$GLOBALS['ProductName'] = '<a class="Action" target="_blank" href="index.php?ToDo=editProduct&amp;productId=' . (int)$productId . '" title="' . isc_html_escape($productName) . '">' . isc_html_escape($productName) . '</a>';
						} else {
							$GLOBALS['ProductName'] = isc_html_escape($productName);
						}

						$GLOBALS['ProductVariationList'] = '<li>' . implode('</li><li>', $variations) . '</li>';
						$affected .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('VariationAffectedProducts');
					}

					break;
			}

			$GLOBALS['AffectedProducts'] = $affected;
			$GLOBALS['ProductVariationPopupIntro'] = GetLang('ProductVariationPopup' . ucfirst(strtolower($type)) . 'Intro');
			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("products.variation.affected.popup");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
			exit;
		}
	}
?>