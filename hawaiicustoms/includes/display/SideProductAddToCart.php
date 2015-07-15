<?php

	CLASS ISC_SIDEPRODUCTADDTOCART_PANEL extends PANEL
	{
		public function SetPanelSettings()
		{
			// Are we allowed to purchase this product?
			if(!$GLOBALS['ISC_CLASS_PRODUCT']->IsPurchasingAllowed()) {
				$this->DontDisplay = true;
				return;
			}

			if(GetConfig('AddToCartButtonPosition') == 'middle') {
				$this->DontDisplay = true;
				return;
			}

			$GLOBALS['ProductPrice'] = '';
			$GLOBALS['ProductName'] = isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetProductName());
			$GLOBALS['ProductId'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductId();

			$GLOBALS['ProductCartQuantity'] = '';
			if(isset($GLOBALS['CartQuantity'.$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()])) {
				$GLOBALS['ProductCartQuantity'] = (int)$GLOBALS['CartQuantity'.$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()];
			}

			// Does this product have any bulk discount?
			if ($GLOBALS['ISC_CLASS_PRODUCT']->CanUseBulkDiscounts()) {
				$GLOBALS['HideBulkDiscountLink'] = '';
				$GLOBALS['BulkDiscountThickBoxTitle'] = sprintf(GetLang('BulkDiscountThickBoxTitle'), isc_html_escape($GLOBALS['ISC_CLASS_PRODUCT']->GetProductName()));
				$GLOBALS['BulkDiscountThickBoxRates'] = $this->GetProductBulkDiscounts();
				$GLOBALS['ProductBulkDiscountThickBox'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductBulkDiscountThickBox");
			} else {
				$GLOBALS['HideBulkDiscountLink'] = 'none';
			}

			$this->LoadAddToCartOptions();

		}

		/**
		 * Load and set the options used for the "Add to Cart" functionality.
		 *
		 * @param string The position of the add to cart feature (either middle or side)
		 */
		public function LoadAddToCartOptions($position='side')
		{
			$GLOBALS['ProductCartQuantity'] = '';
			if(isset($GLOBALS['CartQuantity'.$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()])) {
				$GLOBALS['ProductCartQuantity'] = (int)$GLOBALS['CartQuantity'.$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()];
			}

			if($GLOBALS['ISC_CLASS_PRODUCT']->IsPurchasingAllowed()) {
				$GLOBALS['ProductPrice'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetCalculatedPrice();
			}

			// If we're using a cart quantity drop down, load that
			if (GetConfig('TagCartQuantityBoxes') == 'dropdown') {
				$GLOBALS['Quantity1'] = "selected=\"selected\"";
				$GLOBALS['QtyOptionZero'] = "";
				$GLOBALS['AddToCartQty'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CartItemQtySelect");
			// Otherwise, load the textbox
			} else {
				$GLOBALS['ProductQuantity'] = 1;
				$GLOBALS['AddToCartQty'] = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CartItemQtyText");
			}
			$GLOBALS['UpdateCartQtyJs'] = '';

			// Are there any product variations?
			$prodVariations = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductVariations();

			$GLOBALS['VariationList'] = '';
			$GLOBALS['SNIPPETS']['VariationList'] = '';
			$GLOBALS['HideVariationList'] = '';
			$GLOBALS['ProductOptionRequired'] = "false";

			// Can we sell this product/option
			$saleable = IsProductSaleable($GLOBALS['ISC_CLASS_PRODUCT']->GetProduct());     
			if(!empty($prodVariations)) {
				// Is a product option required when adding the product to the cart?
				if($GLOBALS['ISC_CLASS_PRODUCT']->IsOptionRequired()) {
					$GLOBALS['ProductOptionRequired'] = "true";
				}

				if(count($prodVariations) == 1 && count(current($prodVariations)) <= 5) {
					$onlyOneVariation = true;
					$GLOBALS['OptionMessage'] = GetLang('ChooseAnOption');
				}
				else {
					$GLOBALS['OptionMessage'] = GetLang('ChooseOneOrMoreOptions');
					$onlyOneVariation = false;
				}
				$ProductInStock = true;
				$useSelect = false;
				$GLOBALS['VariationNumber'] = 0;

				foreach($prodVariations as $name => $options) {
					// If this is the only variation then instead of select boxes, just show radio buttons
					if($position == 'middle') {
						$GLOBALS['VariationChooseText'] = "";
					}
					else {
						$GLOBALS['VariationChooseText'] = GetLang('ChooseA')." ".isc_html_escape($name).":";
					}
					$GLOBALS['VariationNumber']++;
					$GLOBALS['SNIPPETS']['OptionList'] = '';

					if($onlyOneVariation && count($options) <= 8 && !$GLOBALS['ISC_CLASS_PRODUCT']->IsOptionRequired()) {
						$GLOBALS['OptionId'] = 0;
						$GLOBALS['OptionValue'] = GetLang('zNone');
						$GLOBALS['OptionChecked'] = "checked=\"checked\"";
						$GLOBALS['SNIPPETS']['OptionList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductVariationListSingleItem");
					}
					else if($onlyOneVariation && count($options) > 8) {
						$useSelect = true;
					}

					// Build the list of options
					$GLOBALS['OptionChecked'] = '';
					foreach($options as $option) {
						$GLOBALS['OptionId'] = (int) $option['voptionid'];
						$GLOBALS['OptionValue'] = isc_html_escape($option['vovalue']);
						if($onlyOneVariation && !$useSelect) {
							$GLOBALS['SNIPPETS']['OptionList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductVariationListSingleItem");
						}
						else {
							if($position == 'middle') {
								$GLOBALS['VariationChooseText'] = GetLang('ChooseA')." ".isc_html_escape($name).":";
							}
							$GLOBALS['SNIPPETS']['OptionList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductVariationListMultipleItem");
						}
					}

					$prefix = '';
					$suffix = '';
					if($position == 'middle') {
						$prefix = '<dt>'.isc_html_escape($name).':</dt><dd class="ProductOptionList">';
						$suffix = '</dd>';
					}

					if($onlyOneVariation == true && !$useSelect) {
						$output = $prefix.$GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductVariationListSingle").$suffix;
					}
					else {
						$GLOBALS['VariationChooseText'] = GetLang('ChooseA')." ".isc_html_escape($name).":";
						$output =$prefix.$GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductVariationListMultiple").$suffix;
					}
					$output = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output, $GLOBALS['SNIPPETS']);
					$GLOBALS['SNIPPETS']['VariationList'] .= $output;
				}

				if($position != 'middle' && ($onlyOneVariation == false || $useSelect == true)) {
					$output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("ProductVariationMultiple");
					$output = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output, $GLOBALS['SNIPPETS']);
					$GLOBALS['SNIPPETS']['VariationList'] = $output;
				}

				$GLOBALS['ProductVariationJavascript'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductVariationCombinationJavascript();
			}
			else {
				$GLOBALS['HideVariationList'] = 'display:none;';
				$ProductInStock = $saleable;
			}

			if($ProductInStock == true) {
				$GLOBALS['SNIPPETS']['SideAddItemSoldOut'] = '';
				$GLOBALS['DisplayAdd'] = "";
			}
			else {
				$output = $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideAddItemSoldOut");
				$output = $GLOBALS['ISC_CLASS_TEMPLATE']->ParseSnippets($output, $GLOBALS['SNIPPETS']);
				$GLOBALS['SNIPPETS']['SideAddItemSoldOut'] = $output;

				$GLOBALS['BuyBoxSoldOut'] = "ProductBuyBoxSoldOut";
				$GLOBALS['DisplayAdd'] = "none";
				$GLOBALS['ISC_LANG']['BuyThisItem'] = GetLang('ItemUnavailable');
			}

			if(GetConfig('ShowAddToCartQtyBox') == 1) {
				$GLOBALS['DisplayAddQty'] = $GLOBALS['DisplayAdd'];
			} else {
				$GLOBALS['DisplayAddQty'] = "none";
			}

			ISC_SIDEPRODUCTADDTOCART_PANEL::LoadEventDate($position);
			ISC_SIDEPRODUCTADDTOCART_PANEL::LoadProductFieldsLayout($position);

			$GLOBALS['ShowAddToCartQtyBox'] = GetConfig('ShowAddToCartQtyBox');
		}

		public function LoadEventDate($position = 'middle')
		{
			$output = '';
			$productId = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductId();
			$fields = ($GLOBALS['ISC_CLASS_PRODUCT']->GetEventDateFields());


			if (empty($fields['prodeventdaterequired'])) {
				return;
			}

			$GLOBALS['EventDateName'] = '<div class="FloatLeft Required"><span class="Required" style="margin-right : 4px;">*</span></div> '.$fields['prodeventdatefieldname'];

			$from_stamp = $fields['prodeventdatelimitedstartdate'];
			$to_stamp = $fields['prodeventdatelimitedenddate'];

			$to_day = isc_date("d", $to_stamp);
			$from_day = isc_date("d", $from_stamp);

			$to_month = isc_date("m", $to_stamp);
			$from_month = isc_date("m", $from_stamp);

			$to_year = isc_date("Y", $to_stamp);
			$from_year = isc_date("Y", $from_stamp);

			$to_date = isc_date('jS M Y',$to_stamp);
			$from_date = isc_date('jS M Y',$from_stamp);

			$eventDateInvalidMessage = sprintf(GetLang('EventDateInvalid'), strtolower($fields['prodeventdatefieldname']));

			$comp_date = '';
			$comp_date_end = '';
			$eventDateErrorMessage = '';

			$edlimited = $fields['prodeventdatelimited'];
			if (empty($edlimited)) {
				$from_year = isc_date('Y');
				$to_year = isc_date('Y',isc_gmmktime(0, 0, 0, 0,0,isc_date('Y')+5));
				$GLOBALS['EventDateLimitations'] = '';
			} else {
				if ($fields['prodeventdatelimitedtype'] == 1) {
					$GLOBALS['EventDateLimitations'] = sprintf(GetLang('EventDateLimitations1'),$from_date,$to_date);

					$comp_date = isc_date('Y/m/d', $from_stamp);
					$comp_date_end = isc_date('Y/m/d', $to_stamp);

					$eventDateErrorMessage = sprintf(GetLang('EventDateLimitationsLong1'), strtolower($fields['prodeventdatefieldname']),$from_date, $to_date);

				} else if ($fields['prodeventdatelimitedtype'] == 2) {
					$to_year = isc_date('Y', isc_gmmktime(0, 0, 0, isc_date('m',$from_stamp),isc_date('d',$from_stamp),isc_date('Y',$from_stamp)+5));
					$GLOBALS['EventDateLimitations'] = sprintf(GetLang('EventDateLimitations2'), $from_date);

					$comp_date = isc_date('Y/m/d', $from_stamp);

					$eventDateErrorMessage = sprintf(GetLang('EventDateLimitationsLong2'), strtolower($fields['prodeventdatefieldname']),$from_date);


				} else if ($fields['prodeventdatelimitedtype'] == 3) {
					$from_year = isc_date('Y', time());
					$GLOBALS['EventDateLimitations'] = sprintf(GetLang('EventDateLimitations3'),$to_date);

					$comp_date = isc_date('Y/m/d', $to_stamp);

					$eventDateErrorMessage = sprintf(GetLang('EventDateLimitationsLong3'), strtolower($fields['prodeventdatefieldname']),$to_date);
				}
			}


			$GLOBALS['OverviewToDays'] = ISC_SIDEPRODUCTADDTOCART_PANEL::_GetDayOptions();
			$GLOBALS['OverviewToMonths'] = ISC_SIDEPRODUCTADDTOCART_PANEL::_GetMonthOptions();
			$GLOBALS['OverviewToYears'] = ISC_SIDEPRODUCTADDTOCART_PANEL::_GetYearOptions($from_year,$to_year);

			if ($position != 'middle') {
				$GLOBALS['EventDateMonthStyle'] = ' width : 44px; font-size : 90%;';
				$GLOBALS['EventDateDayStyle'] = 'width : 40px; font-size : 90%;';
				$GLOBALS['EventDateYearStyle'] = 'width : 50px; font-size : 90%;';
			}

			$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('EventDate');
			$GLOBALS['SNIPPETS']['EventDate'] = $output;

			$GLOBALS['EventDateJavascript'] = sprintf("<script type=\"text/javascript\"> var eventDateData = {type:'%s',compDate:'%s',compDateEnd:'%s',invalidMessage:'%s',errorMessage:'%s'}; </script>",
				$fields['prodeventdatelimitedtype'],
				$comp_date,
				$comp_date_end,
				$eventDateInvalidMessage,
				$eventDateErrorMessage
			);
		}

		private function _GetDayOptions()
		{
			$output = "";

			$output .= '<option value=\'-1\'>---</option>';

			for($i = 1; $i <= 31; $i++) {
				$output .= sprintf("<option value='%d'>%s</option>", $i, $i);
			}

			return $output;
		}

		/**
			*	Return a list of months as option tags
			*/
		private function _GetMonthOptions()
		{
			$output = "";
			$output .= '<option value=\'-1\'>---</option>';

			for($i = 1; $i <= 12; $i++) {
				$stamp = isc_gmmktime(0, 0, 0, $i, 1, 2000);
				$month = isc_date("M", $stamp);
				$output .= sprintf("<option value='%d'>%s</option>", $i, $month);
			}

			return $output;
		}

		/**
			*	Return a list of years as option tags
			*/
		private function _GetYearOptions($from, $to)
		{
			$output = "";
			$output .= '<option value=\'-1\'>---</option>';

			for($i = $from; $i <= $to; $i++) {

				$output .= sprintf("<option value='%d'>%s</option>", $i, $i);
			}

			return $output;
		}

		public function LoadProductFieldsLayout($position = 'middle')
		{
			$output = '';
			$productId = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductId();
			$fields = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductFields($productId);
			if(!empty($fields)) {
				foreach($fields as $field) {
					$GLOBALS['ProductFieldType'] = isc_html_escape($field['type']);
					$GLOBALS['ItemId'] = 0;
					$GLOBALS['ProductFieldId'] = (int)$field['id'];
					$GLOBALS['ProductFieldName'] = isc_html_escape($field['name']);
					$GLOBALS['ProductFieldInputSize'] = '';
					$GLOBALS['ProductFieldRequired'] = '';
					$GLOBALS['FieldRequiredClass'] = '';
					$GLOBALS['CheckboxFieldNameLeft'] = '';
					$GLOBALS['CheckboxFieldNameRight'] = '';
					$GLOBALS['HideCartFileName'] = 'display:none';
					$GLOBALS['HideDeleteFileLink'] = 'display:none';
					$GLOBALS['HideFileHelp'] = "display:none";
					$snippetFile = 'ProductFieldInput';

					switch ($field['type']) {
						case 'textarea': {
							$snippetFile = 'ProductFieldTextarea';
							break;
						}
						case 'file': {

							$GLOBALS['HideFileHelp'] = "";
							$GLOBALS['FileSize'] = NiceSize($field['fileSize']*1024);
							$GLOBALS['FileTypes'] = $field['fileType'];
							if($position == 'side') {
								$GLOBALS['ProductFieldInputSize'] = 10;
							}
							break;
						}
						case 'checkbox': {
							if($position == 'side') {
								$GLOBALS['CheckboxFieldNameRight'] = isc_html_escape($field['name']);
							} else {
								$GLOBALS['CheckboxFieldNameLeft'] = isc_html_escape($field['name']);
							}
							$snippetFile = 'ProductFieldCheckbox';
							break;
						}
						default: break;
					}

					if($field['required']) {
						$GLOBALS['ProductFieldRequired'] = '<span class="Required">*</span>';
						$GLOBALS['FieldRequiredClass'] = 'FieldRequired';
					}
					$output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet($snippetFile);
				}
			}
			$GLOBALS['SNIPPETS']['ProductFieldsList'] = $output;
		}


		/**
		 * Get the bulk discount rates HTML
		 *
		 * Method will return the bulk discount rates HTML to be used in the bulk discount thickbok
		 *
		 * @access public
		 * @return string The bulk discount HTML list
		 */
		public function GetProductBulkDiscounts()
		{
			$rates = '';
			$prevMax = 0;
			$query = "SELECT *
						FROM [|PREFIX|]product_discounts
						WHERE discountprodid = " . (int)$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId() . "
						ORDER BY IF(discountquantitymax > 0, discountquantitymax, discountquantitymin) ASC";

			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

				$range = '';
				if ($row['discountquantitymin'] == 0) {
					$range = isc_html_escape(intval($prevMax+1) . ' - ' . (int)$row['discountquantitymax']);
				} else if ($row['discountquantitymax'] == 0) {
					$range = isc_html_escape(sprintf(GetLang('BulkDiscountThickBoxDiscountOrAbove'), (int)$row['discountquantitymin']));
				} else {
					$range = isc_html_escape((int)$row['discountquantitymin'] . ' - ' . (int)$row['discountquantitymax']);
				}

				$discount = '';
				switch (isc_strtolower(isc_html_escape($row['discounttype']))) {
					case 'price':
						$discount = sprintf(GetLang('BulkDiscountThickBoxDiscountPrice'), $range, CurrencyConvertFormatPrice(isc_html_escape($row['discountamount'])));
						break;

					case 'percent':
						$discount = sprintf(GetLang('BulkDiscountThickBoxDiscountPercent'), $range, (int)$row['discountamount'] . '%');
						break;

					case 'fixed';
						$price = CalculateCustGroupDiscount($GLOBALS['ISC_CLASS_PRODUCT']->GetProductId(),$row['discountamount']);
						$discount = sprintf(GetLang('BulkDiscountThickBoxDiscountFixed'), $range, CurrencyConvertFormatPrice(isc_html_escape($price)));
						break;
				}

				$rates .= '<li>' . isc_html_escape($discount) . '</li>';

				if ($row['discountquantitymax'] !== 0) {
					$prevMax = $row['discountquantitymax'];
				}
			}

			return $rates;
		}

	}

?>
