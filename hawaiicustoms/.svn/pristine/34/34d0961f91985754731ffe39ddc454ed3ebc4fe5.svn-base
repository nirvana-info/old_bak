
	<form action="index.php?ToDo=%%GLOBAL_FormAction%%" id="frmCustomerGroup" onsubmit="return ValidateForm(CheckCustomerGroupForm)" method="post">
	<input type="hidden" name="groupId" value="%%GLOBAL_GroupId%%">
	<input type="hidden" name="oldGroupName" value="%%GLOBAL_GroupName%%">
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%GLOBAL_Title%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_CustomerGroupsIntro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
		</td>
	  </tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_CustomerGroupDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_CustomerGroupName%%:
					</td>
					<td>
						<input type="text" id="groupname" name="groupname" class="Field400" value="%%GLOBAL_GroupName%%">
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_CustomerGroupName%%', '%%LNG_GroupNameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d1"></div>
						<div style="padding-top:5px; font-style:italic; color:gray">%%LNG_CustomerGroupNameSuggestion%%</div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_CustomerGroupAccess%%:
					</td>
					<td>
						<input type="checkbox" name="accesscategories" id="accesscategories" %%GLOBAL_AccessAllCategories%% /> <label for="accesscategories">%%LNG_CustomerGroupAllAccess%%</label>
						<span id="accesscatssel" style="display:%%GLOBAL_HideAccessCatLinks%%">(<a href="#" id="selectAllCats">%%LNG_SelectAll%%</a> / <a href="#" id="unselectAllCats">%%LNG_UnselectAll%%</a>)</span>
						<img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_CustomerGroupAccess%%', '%%LNG_CustomerGroupAccessHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d4"></div><br />
						<div style="padding-top:5px; display:%%GLOBAL_HideAccessCategories%%" id="accesscategorylist">
							<img src="images/nodejoin.gif" width="20" height="20" style="float:left; margin-right: 5px"/>
							<select size="5" id="accesscategorieslist" name="accesscategorieslist[]" class="Field400 ISSelectReplacement" multiple="multiple" style="height: 140px">
							%%GLOBAL_AccessCategoryOptions%%
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;
					</td>
					<td>
						<input type="checkbox" id="isdefault" name="isdefault" value="ON" %%GLOBAL_IsDefault%%> <label for="isdefault">%%LNG_YesMakeCustomerGroupDefault%%</label>
						<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_CustomerGroupDefault%%', '%%LNG_CustomerGroupDefaultHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d3"></div>
					</td>
				</tr>
			 </table>
			 <br />
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_CategoryLevelDiscounts%%</td>
				</tr>
				<tr>
					<td style="padding-left:10px">
						<div id="nocatrules" style="padding-top:5px; font-style:italic; color:gray">%%LNG_NoCategoryLevelDiscounts%% <a href="#" onclick="AddCatRule()">%%LNG_CreateOneNow%%</a></div>
						<div id="catrules" style="display:none; padding-top:3px"></div>
					</td>
				</tr>
			 </table>
			 <br />
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_ProductLevelDiscounts%%</td>
				</tr>
				<tr>
					<td style="padding-left:10px">
						<div id="noprodrules" style="padding-top:5px; font-style:italic; color:gray">%%LNG_NoProductLevelDiscounts%% <a href="#" onclick="AddProdRule()">%%LNG_CreateOneNow%%</a></div>
						<div id="prodRules" style="display:none; padding-top:3px"></div>
					</td>
				</tr>
			 </table>
			 <br />
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_StorewideDiscount%%</td>
				</tr>
				<tr>
					<td style="padding-left:10px">
						<div style="padding-top:5px">
							%%LNG_CustomerGroupsOtherProductsDiscount%%


							<span id="storeDiscountRulesAmountPrefix_">$</span>
							<input type="text" id="discount" name="discount" class="Field50" style="width:30px" value="%%GLOBAL_Discount%%">
							<span id="storeDiscountRulesAmountPostfix_"></span>

							<select id="storeDiscountMethod_" name="storeDiscountMethod" class="Field120" onchange="ToggleDiscountRateValueType('', 'store');">
								<option value="price" selected="selected">%%LNG_PriceDiscount%%</option>
								<option value="percent">%%LNG_PercentageDiscount%%</option>
								<option value="fixed">%%LNG_FixedPrice%%</option>
							</select>

							<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_StorewideDiscount%%', '%%LNG_StorewideDiscountHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d2"></div>
						</div>
					</td>
				</tr>
			 </table>
			</td>
		</tr>
	</table>
	<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
	</div>
	</form>

	<script type="text/javascript">
		//togle store discound method
		var StoreDiscountMethod = '%%GLOBAL_StoreDiscountMethod%%';
		$("#storeDiscountMethod_ option[@value='"+StoreDiscountMethod+"']").attr("selected","selected");;
		ToggleDiscountRateValueType('', 'store');

		var catList = "%%GLOBAL_CategoryOptions%%";
		var numCatRules = 0;
		var numProdRules = 0;

		function ConfirmCancel() {
			if(confirm("%%LNG_ConfirmCancelCustomerGroup%%"))
				document.location.href = "index.php?ToDo=viewCustomerGroups";
		}

		function CheckCustomerGroupForm() {

			if($('#groupname').val() == '') {
				alert('%%LNG_CustomerGroupEnterName%%');
				$('#groupname').select();
				return false;
			}

			// Validate all of the category-level rules --------------
			catIds = new Array();
			numCatIds = 0;
			err = false;

			// First check if a category has been associated with more than one discount
			$(document).find('.catRulesProductId').each(function() {
				if(parseInt($(this).val()) > 0) {
					// Is it already in the array?
					if(catIds.in_array($(this).val())) {
						// It's a duplicate category ID
						alert("%%LNG_CustomerGroupMultiCatDiscount%%");
						err = true;
						return false;
					}
					else {
						// Add the category to the stack so we can compare duplicate IDS
						catIds[numCatIds] = $(this).val();
						numCatIds++;
					}
				}
			});

			if(err) {
				return false;
			}

			// Now check to make sure a valid discount is entered for each one
			err = false;

			$(document).find('.catRulesDiscount').each(function() {
				field_id = (this).id.replace("catRuleDiscount", "");

				if(parseInt($('#catRuleCategory'+field_id).val()) > 0) {
					if(isNaN($(this).val()) || $(this).val() == "" || 
						( $('#catDiscountMethod_'+field_id).val() == 'percent' && (parseInt($(this).val()) < 0 || parseInt($(this).val()) > 100))) {
						alert("%%LNG_CustomerGroupEnterValidDiscount%%");
						$(this).focus();
						$(this).select();
						err = true;
						return false;
					}
				}
			});

			if(err) {
				return false;
			}

			// Validate all of the product-level rules --------------
			prodIds = new Array();
			numProdIds = 0;
			err = false;

			// First check if a product has been associated with more than one discount
			$(document).find('.prodRulesProductId').each(function() {
				if(parseInt($(this).val()) > 0) {
					// Is it already in the array?
					if(prodIds.in_array($(this).val())) {
						// It's a duplicate product ID
						alert("%%LNG_CustomerGroupMultiProdDiscount%%");
						err = true;
						return false;
					}
					else {
						// Add the product to the stack so we can compare duplicate IDS
						prodIds[numProdIds] = $(this).val();
						numProdIds++;
					}
				}
			});

			if(err) {
				return false;
			}

			// Now check to make sure a valid discount is entered for each one
			err = false;

			$(document).find('.prodRulesDiscount').each(function() {
				if(isNaN($(this).val()) || $(this).val() == "" || parseInt($(this).val()) < 0 || parseInt($(this).val()) > 100) {
					alert("%%LNG_CustomerGroupEnterValidDiscount%%");
					$(this).focus();
					$(this).select();
					err = true;
					return false;
				}
			});

			if(err) {
				return false;
			}

			// Validate the storewide discount
			if(isNaN(priceFormat($('#discount').val())) || $('#discount').val() == "" || parseInt($('#discount').val()) < 0 || parseInt($('#discount').val()) > 100) {
				alert('%%LNG_CustomerGroupEnterDiscount%%');
				$('#discount').focus();
				$('#discount').select();
				return false;
			}

			return true;
		}

		function ToggleDiscountRateValueType(id, ruleType)
		{
			if ($('#'+ruleType+'DiscountMethod_' + id).val() == 'percent') {
				$('#'+ruleType+'DiscountRulesAmountPrefix_' + id).html('');
				$('#'+ruleType+'DiscountRulesAmountPostfix_' + id).html('%');
			} else {
				$('#'+ruleType+'DiscountRulesAmountPrefix_' + id).html('$');
				$('#'+ruleType+'DiscountRulesAmountPostfix_' + id).html('');
			}

			if(ruleType=='cat') {
				if ($('#'+ruleType+'DiscountMethod_' + id).val() == 'fixed') {
					$('#'+ruleType+'DiscountRulesLineEnding_' + id).html(' for ');
				} else {
					$('#'+ruleType+'DiscountRulesLineEnding_' + id).html(' off ');
				}
			}
		}


		function AddCatRule(CategoryId, Discount, DiscountType, DiscountMethod) {
			$('#nocatrules').hide('slow');
			$('#catrules').show('slow');
			numCatRules++;

			catRuleHTML = '<div id="catRule'+numCatRules+'">';
			catRuleHTML = catRuleHTML + '%%LNG_ForProductsInThisCategory%% ';
			catRuleHTML = catRuleHTML + '<select class="catRulesProductId" onchange="$(\'#catRuleDiscount'+numCatRules+'\').focus();" name="catRules[category][]" id="catRuleCategory'+numCatRules+'"><option>-- Choose a Category --</option>'+catList+'</select> \n';
			catRuleHTML = catRuleHTML + '%%LNG_CustomersReceiveA%% \n';
			catRuleHTML = catRuleHTML + '<span id="catDiscountRulesAmountPrefix_'+numCatRules+'">$</span>\n';

			catRuleHTML = catRuleHTML + '<input class="catRulesDiscount Field50" name="catRules[discount][]" id="catRuleDiscount'+numCatRules+'" type="text" class="Field50" style="width:30px" />';
			catRuleHTML = catRuleHTML + '<span id="catDiscountRulesAmountPostfix_'+numCatRules+'"></span>\n';

			catRuleHTML = catRuleHTML + '<select id="catDiscountMethod_'+numCatRules+'" name="catRules[discountMethod][]" class="Field120" onchange="ToggleDiscountRateValueType('+numCatRules+', \'cat\');"> \n';
			catRuleHTML = catRuleHTML + '<option value="price" selected="selected">%%LNG_PriceDiscount%%</option> \n';
			catRuleHTML = catRuleHTML + '<option value="percent">%%LNG_PercentageDiscount%%</option> \n';
			catRuleHTML = catRuleHTML + '<option value="fixed">%%LNG_FixedPrice%%</option>\n';
			catRuleHTML = catRuleHTML + '</select>\n';

			catRuleHTML = catRuleHTML + '<span id="catDiscountRulesLineEnding_'+numCatRules+'"> for </span>\n';

			catRuleHTML = catRuleHTML + '<select name="catRules[discounttype][]" id="catRuleDiscountType'+numCatRules+'"><option value="CATEGORY_ONLY">%%LNG_ProductsInThisCategory%%</option><option value="CATEGORY_AND_SUBCATS">%%LNG_ProductsInThisCategory2%%</option></select> ';

			catRuleHTML = catRuleHTML + '<img title="%%LNG_AddAnotherCategoryDiscount%%" style="cursor:pointer" src="images/addicon.gif" width="16" height="16" onclick="AddCatRule()" /> ';
			catRuleHTML = catRuleHTML + '<img title="%%LNG_RemoveThisCategoryDiscount%%" style="cursor:pointer" src="images/delicon.gif" width="16" height="16" onclick="RemoveCatRule('+numCatRules+')" />';
			catRuleHTML = catRuleHTML + '</div>';

			$('#catrules').append(catRuleHTML);
			$('#catRuleCategory'+numCatRules).focus();

			// Pre-select the values if we're editing an existing customer group
			if(typeof(CategoryId) != 'undefined') {
				var cat_drop = g('catRuleCategory'+numCatRules);

				for(i = 0; i < cat_drop.options.length; i++) {
					if(cat_drop.options[i].value == CategoryId) {
						cat_drop.selectedIndex = i;
						break;
					}
				}

				// Fill in the discount text box
				g('catRuleDiscount'+numCatRules).value = Discount;

				// What kind of discount is it?
				var discount_type_drop = g('catRuleDiscountType'+numCatRules);

				if(DiscountType == 'CATEGORY_AND_SUBCATS') {
					discount_type_drop.selectedIndex = 1;
				}
				else {
					discount_type_drop.selectedIndex = 0;
				}

				$("#catDiscountMethod_"+numCatRules+" option[@value='"+DiscountMethod+"']").attr("selected","selected");;
				ToggleDiscountRateValueType(numCatRules, 'cat');
			}
		}

		function RemoveCatRule(RuleId) {
			$('#catRule'+RuleId).remove();
			numCatRules--;

			if(numCatRules == 0) {
				$('#nocatrules').show('slow');
			}
		}

		function AddProdRule(ProductId, ProductName, Discount, DiscountMethod) {
			$('#noprodrules').hide('slow');
			$('#prodRules').show('slow');
			numProdRules++;

			prodRuleHTML = '<div id="prodRule'+numProdRules+'">';
			prodRuleHTML = prodRuleHTML + '%%LNG_ForThisProduct1%% <a href="#" onclick="ShowProductSelector(\'prodRuleName'+numProdRules+'\', \'prodRuleValue'+numProdRules+'\', \'prodRuleDiscount'+numProdRules+'\')" id="prodRuleName'+numProdRules+'">%%LNG_ForThisProduct2%% (%%LNG_NoneSelected%%)</a> \n';
			prodRuleHTML = prodRuleHTML + '<input class="prodRulesProductId" type="hidden" name="prodRules[product][]" id="prodRuleValue'+numProdRules+'" value="" />\n';
			prodRuleHTML = prodRuleHTML + '%%LNG_CustomersReceiveA%% \n';

			prodRuleHTML = prodRuleHTML + '<span id="prodDiscountRulesAmountPrefix_'+numProdRules+'">$</span>\n';

			prodRuleHTML = prodRuleHTML + '<input class="prodRulesDiscount Field50" name="prodRules[discount][]" id="prodRuleDiscount'+numProdRules+'" type="text" class="Field50" style="width:30px" />';

			prodRuleHTML = prodRuleHTML + '<span id="prodDiscountRulesAmountPostfix_'+numProdRules+'"></span>\n';
			prodRuleHTML = prodRuleHTML + '<select id="prodDiscountMethod_'+numProdRules+'" name="prodRules[discountMethod][]" class="Field120" onchange="ToggleDiscountRateValueType('+numProdRules+', \'prod\');">\n';
			prodRuleHTML = prodRuleHTML + '<option value="price" selected="selected">%%LNG_PriceDiscount%%</option>\n';
			prodRuleHTML = prodRuleHTML + '<option value="percent">%%LNG_PercentageDiscount%%</option>\n';
			prodRuleHTML = prodRuleHTML + '<option value="fixed">%%LNG_FixedPrice%%</option>\n';
			prodRuleHTML = prodRuleHTML + '</select>\n';

			prodRuleHTML = prodRuleHTML + '<img title="%%LNG_AddAnotherProdDiscount%%" style="cursor:pointer" src="images/addicon.gif" width="16" height="16" onclick="AddProdRule()" /> \n';
			prodRuleHTML = prodRuleHTML + '<img title="%%LNG_RemoveThisProdDiscount%%" style="cursor:pointer" src="images/delicon.gif" width="16" height="16" onclick="RemoveProdRule('+numProdRules+')" />\n';
			prodRuleHTML = prodRuleHTML + '</div>';

			$('#prodRules').append(prodRuleHTML);

			// Pre-select the values if we're editing an existing customer group
			if(typeof(ProductId) != 'undefined') {
				g('prodRuleValue'+numProdRules).value = ProductId;
				g('prodRuleName'+numProdRules).innerHTML = ProductName;
				g('prodRuleDiscount'+numProdRules).value = Discount;

				$("#prodDiscountMethod_"+numProdRules+" option[@value='"+DiscountMethod+"']").attr("selected","selected");;
				ToggleDiscountRateValueType(numProdRules, 'prod');

			}
		}

		function RemoveProdRule(RuleId) {
			$('#prodRule'+RuleId).remove();
			numProdRules--;

			if(numProdRules == 0) {
				$('#noprodrules').show('slow');
			}
		}

		function ShowProductSelector(id, hiddenId, qtyInput) {
			openProductSelect('group', id, hiddenId, 1, qtyInput);
		}

		$(document).ready(function() {
			$('#groupname').focus();

			// Add the existing category level discount (if any)
			%%GLOBAL_ExistingCategoryDiscounts%%
		});

		// Show or hide the access categories list as required
		$('#accesscategories').click(function() {
			if((this).checked) {
				$('#accesscategorylist').hide();
				$('#accesscatssel').hide();
			}
			else {
				$('#accesscategorylist').show();
				$('#accesscatssel').show();
			}
		});

		// Select all access categories
		$('#selectAllCats').click(function() {
			if(g('accesscategorieslist_old')) {
				if(g('accesscategorieslist_old').disabled != true) {
					$('#accesscategorieslist input').attr('checked', false);
					$('#accesscategorieslist input').trigger('click');
				}
			}
			else {
				$('#accesscategorieslist option').attr('selected', true);
			}
			return false;
		});

		$('#unselectAllCats').click(function() {
			if(g('accesscategorieslist_old')) {
				if(g('accesscategorieslist_old').disabled != true) {
					$('#accesscategorieslist input').attr('checked', true);
					$('#accesscategorieslist input').trigger('click');
				}
			}
			else {
				$('#accesscategorieslist option').attr('selected', false);
			}
			return false;
		});

	</script>
