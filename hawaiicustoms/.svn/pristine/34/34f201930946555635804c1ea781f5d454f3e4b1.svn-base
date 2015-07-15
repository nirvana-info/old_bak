
	<form action="index.php" id="frmSearch" method="get" onsubmit="return ValidateForm(CheckViewForm)">
	<input type="hidden" name="ToDo" value="searchProductsRedirect" />
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%LNG_CreateNewProductView%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_ProductViewIntro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
		</td>
	  </tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_ViewDetails%%</td>
				</tr>
				<tr><td class="Gap"></td></tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_NameThisView%%:
					</td>
					<td>
						<input type="text" id="viewName" name="viewName" class="Field250">
						<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_NameThisView%%', '%%LNG_NameThisProductViewHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d2"></div>
					</td>
				</tr>
				<tr><td class="Gap" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_AdvancedSearch%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_SearchKeywords%%:
					</td>
					<td>
						<input type="text" id="searchQuery" name="searchQuery" class="Field250">
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_SearchKeywords%%', '%%LNG_SearchKeywordsProductHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d1"></div>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_BrandName%%:
					</td>
					<td>
						<select name="brand" id="brand" class="Field250">
							<option value="" selected="selected">%%LNG_AllBrandNames%%</option>
							%%GLOBAL_BrandNameOptions%%
						</select>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_Categories%%:
					</td>
					<td>
						<select size="5" id="category" name="category[]" class="Field250 ISSelectReplacement" style="height:115" multiple>
							<option value="0" selected="selected">%%LNG_AllCategories%%</option>
							%%GLOBAL_CategoryOptions%%
						</select>
						<br />
						<div style="clear: left;"><label><input type="checkbox" name="subCats" value="1" checked="checked" /> %%LNG_AutoSearchSubCategories%%</label></div>
					</td>
				</tr>

				<tr><td class="Gap" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_SearchByRange%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_PriceRange%%:
					</td>
					<td>
						%%LNG_SearchFrom%% %%GLOBAL_CurrencyTokenLeft%%<input type="text" id="priceFrom" name="priceFrom" class="Field50"> %%GLOBAL_CurrencyTokenRight%% %%LNG_SearchTo%%
						%%GLOBAL_CurrencyTokenLeft%%<input type="text" id="priceTo" name="priceTo" class="Field50"> %%GLOBAL_CurrencyTokenRight%%
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_ProductSoldCount%%:
					</td>
					<td>
						%%LNG_SearchFrom%% &nbsp;&nbsp;<input type="text" id="soldFrom" name="soldFrom" class="Field50"> %%LNG_SearchTo%%
						&nbsp;&nbsp;<input type="text" id="soldTo" name="soldTo" class="Field50">
					</td>
				</tr>
				<tr style="display: %%GLOBAL_HideInventoryOptions%%">
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_InventoryLevel%%:
					</td>
					<td>
						%%LNG_SearchFrom%% &nbsp;&nbsp;<input type="text" id="inventoryFrom" name="inventoryFrom" class="Field50"> %%LNG_SearchTo%%
						&nbsp;&nbsp;<input type="text" id="inventoryTo" name="inventoryTo" class="Field50">
						<br />
						<label><input type="checkbox" name="inventoryLow" value="1" /> %%LNG_SearchLowInventory%%</label>
					</td>
				</tr>
				<tr><td class="Gap" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_SearchBySetting%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_ProductVisibility%%:
					</td>
					<td>
						<select name="visibility" id="visibility" class="Field250">
							<option value="">%%LNG_NoPreference%%</option>
							<option value="1">%%LNG_VisibleOnly%%</option>
							<option value="0">%%LNG_InvisibleOnly%%</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_FeaturedProduct%%:
					</td>
					<td>
						<select name="featured" id="featured" class="Field250">
							<option value="">%%LNG_NoPreference%%</option>
							<option value="1">%%LNG_FeaturedOnly%%</option>
							<option value="0">%%LNG_NotFeaturedOnly%%</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_FreeShipping%%:
					</td>
					<td>
						<select name="freeShipping" id="freeShipping" class="Field250">
							<option value="">%%LNG_NoPreference%%</option>
							<option value="1">%%LNG_FreeShippingOnly%%</option>
							<option value="0">%%LNG_NonFreeShippingOnly%%</option>
						</select>
					</td>
				</tr>
				<tr><td class="Gap" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_SortOrder%%</td>
				</tr>
				<tr><td class="Gap"></td></tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_SortOrder%%:
					</td>
					<td>
						<select name="sortField" class="Field120">
							<option value="productid">%%LNG_ProductID%%</option>
							<option value="prodcode">%%LNG_ProductSKU%%</option>
							<option value="prodcurrentinv">%%LNG_ProductInStock%%</option>
							<option value="prodname">%%LNG_ProductName%%</option>
							<option value="prodcalculatedprice">%%LNG_ProductPrice%%</option>
							<option value="prodvisble">%%LNG_ProductVisible%%</option>
						</select>
						in&nbsp;
						<select name="sortOrder" class="Field110">
						<option value="asc">%%LNG_AscendingOrder%%</option>
						<option value="desc">%%LNG_DescendingOrder%%</option>
					</td>
				</tr>
				<tr>
					<td class="Gap">&nbsp;</td>
					<td class="Gap"><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
					</td>
				</tr>
				<tr><td class="Gap" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
	</table>
	</div>
	</form>

	<script type="text/javascript">
		function ConfirmCancel() {
			if(confirm("%%LNG_ConfirmCancelSearch%%"))
				document.location.href = "index.php?ToDo=viewProducts";
		}

		function CheckViewForm() {
			var viewName = g("viewName");
			var priceFrom = g("priceFrom");
			var priceTo = g("priceTo");
			var inventoryFrom = g("inventoryFrom");
			var inventoryTo = g("inventoryTo");
			var soldFrom = g("soldFrom");
			var soldTo = g("soldTo");

			if(viewName.value == "") {
				alert("%%LNG_EnterViewName%%");
				viewName.focus();
				return false;
			}

			if(priceFrom.value != "" && isNaN(priceFormat(priceFrom.value))) {
				alert("%%LNG_SearchEnterValidPrice%%");
				priceFrom.focus();
				priceFrom.select();
				return false;
			}

			if(priceTo.value != "" && isNaN(priceFormat(priceTo.value))) {
				alert("%%LNG_SearchEnterValidPrice%%");
				priceTo.focus();
				priceTo.select();
				return false;
			}

			if(inventoryFrom.value != "" && isNaN(inventoryFrom.value)) {
				alert("%%LNG_SearchEnterValidInventory%%");
				inventoryFrom.focus();
				inventoryFrom.select();
				return false;
			}

			if(inventoryTo.value != "" && isNaN(inventoryTo.value)) {
				alert("%%LNG_SearchEnterValidInventoryLvl%%");
				inventoryTo.focus();
				inventoryTo.select();
				return false;
			}

			if(soldFrom.value != "" && isNaN(soldFrom.value)) {
				alert("%%LNG_SearchEnterValidSold%%");
				soldFrom.focus();
				soldFrom.select();
				return false;
			}

			if(soldTo.value != "" && isNaN(soldTo.value)) {
				alert("%%LNG_SearchEnterValidQtySold%%");
				soldTo.focus();
				soldTo.select();
				return false;
			}

			return true;
		}

	</script>
