
	<tr id="tr%%GLOBAL_OrderId%%" class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'">
		<td align="center" style="width:23px">
			<input type="checkbox" name="orders[]" value="%%GLOBAL_OrderId1%%">
		</td>
		<td align="center" style="width:15px">
			<a href="#" onclick="OfferQuickView('%%GLOBAL_OrderId%%'); return false;"><img id="expand%%GLOBAL_OrderId%%" src="images/plus.gif" align="left" width="19" class="ExpandLink" height="16" title="%%LNG_ExpandQuickView%%" border="0"></a>
		</td>
		<td align="center" style="width:18px">
			<img src="images/order.gif" width="16" height="16" />
		</td>
		<td class="%%GLOBAL_SortedFieldIdClass%%">
			%%GLOBAL_OrderId%%
		</td>
		<td colspan="%%GLOBAL_CustomerNameSpan%%" class="%%GLOBAL_SortedFieldCustClass%%">
			%%GLOBAL_CustomerLink%%
		</td>
		<td class="%%GLOBAL_SortedFieldDateClass%%">
			%%GLOBAL_Date%%
		</td>
		<td id="order_status_column_%%GLOBAL_OrderId%%" style="border-left-style: solid; border-left-width: 10px; width:150px;" class="%%GLOBAL_SortedFieldStatusClass%% OrderStatus OrderStatus%%GLOBAL_OrderStatusId%%">
        


			     %%GLOBAL_OrderStatusOptions%%   
                  

				
		</td>
		<td style="text-align: center; display: %%GLOBAL_HideOrderMessages%%" class="%%GLOBAL_SortedFieldMessageClass%%">
			%%GLOBAL_MessageLink%%
		</td>
		<td style="text-align: right;" class="%%GLOBAL_SortedFieldTotalClass%%">
			%%GLOBAL_Total%%
		</td>
		
		<td align="center" class="%%GLOBAL_FlagCellClass%%" style="width: 18px; display: %%GLOBAL_HideCountry%%">
			%%GLOBAL_OrderCountryFlag%%
		</td>
		<td>
			<select name="order_options_%%GLOBAL_OrderId%%" id="order_action_%%GLOBAL_OrderId%%" onchange="editOrder('%%GLOBAL_OrderId%%' , $(this).val());" %%GLOBAL_ActionDisable%%>
				<option value="">-- %%LNG_Actions%% --</option>
				<option value="approveOrder">Approve</option> 
				<option value="rejectOrder">Reject</option> 
			</select>
		</td>
	</tr>
	<tr id="trQ%%GLOBAL_OrderId%%" style="display:none">
		<td></td>
		<td colspan="12" id="tdQ%%GLOBAL_OrderId%%" class="QuickView"></td>
	</tr>