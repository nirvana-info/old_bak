	<tr id="tr%%GLOBAL_ReturnId%%" class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'">
		<td align="center" style="width:23px">
			<input type="checkbox" name="returns[]" value="%%GLOBAL_ReturnId%%" class="DeleteCheck">
		</td>
		<td align="center" style="width:15px">
			<a href="#" onclick="QuickReturnView('%%GLOBAL_ReturnId%%'); return false;">
				<img id="expand%%GLOBAL_ReturnId%%" src="images/plus.gif" class="ExpandLink" align="left" width="19" height="16" title="%%LNG_ExpandReturnQuickView%%" border="0">
			</a>
		</td>
		<td align="center" style="width:18px">
			<img src='images/return.gif' height="16" width="16" />
		</td>
		<td class="%%GLOBAL_SortedFieldIdClass%%">
			%%GLOBAL_ReturnId%%
		</td>
		<td class="%%GLOBAL_SortedFieldReturnItemClass%%">
			%%GLOBAL_ReturnQty%%<a href="%%GLOBAL_ProductLink%%" target="_blank">%%GLOBAL_ProdName%%</a>
			%%GLOBAL_ReturnedProductOptions%%
		</td>
		<td class="%%GLOBAL_SortedFieldOrderClass%%">
			<a href="index.php?ToDo=viewOrders&amp;searchQuery=%%GLOBAL_OrderId%%">%%LNG_OrderNo%%%%GLOBAL_OrderId%%</a>
		</td>
		<td class="%%GLOBAL_SortedFieldCustClass%%">
			<a href="index.php?ToDo=viewCustomers&amp;searchQuery=%%GLOBAL_CustomerId%%">%%GLOBAL_Customer%%</a>
		</td>
		<td nowrap="nowrap" class="%%GLOBAL_SortedFieldDateClass%%">
			%%GLOBAL_Date%%
		</td>
		<td class="%%GLOBAL_SortedFieldStatusClass%%">
			<select %%GLOBAL_ReturnStatusDisabled%% name="return_status_%%GLOBAL_ReturnId%%" id="status_%%GLOBAL_ReturnId%%" class="Field" onchange="UpdateReturnStatus(%%GLOBAL_ReturnId%%, this.options[this.selectedIndex].value, this.options[this.selectedIndex].text, %%GLOBAL_ReturnStatus%%)">
				%%GLOBAL_ReturnStatusOptions%%
			</select>
			<img id="ajax_status_%%GLOBAL_ReturnId%%" src="images/ajax-loader.gif" style="visibility: hidden;" />
		</td>
		<td>
			%%GLOBAL_IssueCreditLink%%
		</td>
	</tr>
	<tr id="trQ%%GLOBAL_ReturnId%%" style="display:none">
		<td colspan="3">
			&nbsp;
		</td>
		<td colspan="6" id="tdQ%%GLOBAL_ReturnId%%" class="QuickView">
		</td>
		<td colspan="1">&nbsp;</td>
	</tr>
