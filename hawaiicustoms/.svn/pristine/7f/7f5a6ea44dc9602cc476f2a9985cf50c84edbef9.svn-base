	<tr id="tr%%GLOBAL_OrderId%%" class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'">
		<td align="center" style="width:23px">
			<input type="checkbox" name="orders[]" value="%%GLOBAL_OrderId1%%" onclick="$(this).parent().parent().find('td').css('background', '');">
		</td>
		<td align="center" style="width:15px">
			<a href="#" onclick="QuickView('%%GLOBAL_OrderId%%'); return false;"><img id="expand%%GLOBAL_OrderId%%" src="images/plus.gif" align="left" width="19" class="ExpandLink" height="16" title="%%LNG_ExpandQuickView%%" border="0"></a>
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
			<select onclick="order_status_before_change=this.selectedIndex; status_box=this" id="status_%%GLOBAL_OrderId%%" name="status_%%GLOBAL_OrderId%%" class="Field" onchange="update_order_status('%%GLOBAL_OrderId%%', this.options[this.selectedIndex].value, this.options[this.selectedIndex].text)">
				%%GLOBAL_OrderStatusOptions%%
			</select>
			<img id="ajax_status_%%GLOBAL_OrderId%%" src="images/ajax-blank.gif" />
			<div class="%%GLOBAL_PaymentStatusColor%%" style="%%GLOBAL_HidePaymentStatus%%">
				%%GLOBAL_PaymentStatus%%
			</div>
		</td>
		<td style="text-align: center; display: %%GLOBAL_HideOrderMessages%%" class="%%GLOBAL_SortedFieldMessageClass%%">
			%%GLOBAL_MessageLink%%
		</td>
		<td style="text-align: center;" class="%%GLOBAL_SortedFieldTotalClass%%">
			%%GLOBAL_Total%%
		</td>
        <td style="text-align: center;" class="%%GLOBAL_SortedFieldTotalClass%%">
			%%GLOBAL_GatewayTotal%%
		</td>
		<td class="%%GLOBAL_SortedFieldReviewClass%%">
			%%GLOBAL_Review%%
		</td>
		<!--<td>
			<input id="trackingno_%%GLOBAL_OrderId%%" name="trackingno_%%GLOBAL_OrderId%%" type="text" class="Field50" style="width:70px" value="%%GLOBAL_TrackingNo%%" />
			<input type="button" value="%%LNG_TrackSave%%" onclick="update_tracking_no('%%GLOBAL_OrderId%%', document.getElementById('trackingno_%%GLOBAL_OrderId%%').value)" class="FormButton" style="width:40px" />&nbsp;
			<img id="ajax_trackingno_%%GLOBAL_OrderId%%" src="images/ajax-blank.gif" />
		</td>-->
		<td align="center" class="%%GLOBAL_FlagCellClass%%" style="width: 18px; display: %%GLOBAL_HideCountry%%">
			%%GLOBAL_OrderCountryFlag%%
		</td>
		<td>
			<select name="order_options_%%GLOBAL_OrderId%%" id="order_action_%%GLOBAL_OrderId%%" onchange="Order.HandleAction('%%GLOBAL_OrderId%%', $(this).val());">
				<option value="">-- %%LNG_Actions%% --</option>
				<option value="editOrder">%%LNG_EditOrder%%</option>
				<option value="printInvoice">%%LNG_PrintInvoice%%</option>
				<option value="printPackingSlip">%%LNG_PrintPackingSlip%%</option>
				<option value="orderNotes" class="%%GLOBAL_HasNotesClass%%">%%LNG_OrderNotesLink%%</option>

				<!-- this is a comment zfang_20100628-->
				<option value="previewRequest">%%LNG_PreviewRequest%%</option>
				<option value="viewReview">%%LNG_ViewReview%%</option>

				%%GLOBAL_ShipItemsLink%%
				%%GLOBAL_DelayedCaptureLink%%
				%%GLOBAL_VoidLink%%
				%%GLOBAL_RefundLink%%
			</select>
		</td>
	</tr>
	<tr id="trQ%%GLOBAL_OrderId%%" style="display:none">
		<td></td>
		<td colspan="12" id="tdQ%%GLOBAL_OrderId%%" class="QuickView"></td>
	</tr>