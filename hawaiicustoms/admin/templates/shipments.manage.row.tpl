<tr id="tr%%GLOBAL_ShipmentId%%" class="GridRow">
	<td style="text-align: center; width: 23px;">
		<input type="checkbox" name="shipments[]" value="%%GLOBAL_ShipmentId%%" />
	</td>
	<td style="text-align: center; width: 15px;">
		<a href="#" onclick="Shipments.Expand('%%GLOBAL_ShipmentId%%'); return false;">
			<img id="expand%%GLOBAL_ShipmentId%%" src="images/plus.gif" align="left" width="19" class="ExpandLink" height="16" title="%%LNG_ExpandQuickView%%" border="0" />
		</a>
	</td>
	<td style="text-align: center; width: 18px;">
		<img src="images/shipments.gif" alt="" />
	</td>
	<td class="%%GLOBAL_SortedFieldIdClass%%">
		%%GLOBAL_ShipmentId%%
	</td>
	<td class="%%GLOBAL_SortedFieldNameClass%%">
		%%GLOBAL_ShippedTo%%
	</td>
	<td class="%%GLOBAL_SortedFieldDateClass%%">
		%%GLOBAL_Date%%
	</td>
	<td class="%%GLOBAL_SortedFieldOrderIdClass%%">
		<a href="index.php?ToDo=viewOrders&amp;orderId=%%GLOBAL_OrderId%%" target="_blank">#%%GLOBAL_OrderId%%</a>
	</td>
	<td class="%%GLOBAL_SortedFieldOrderDateClass%%">
		%%GLOBAL_OrderDate%%
	</td>
	<td>
		<a title='%%LNG_PrintPackingSlipTitle%%' href="#" onclick="Shipments.PrintPackingSlip('%%GLOBAL_ShipmentId%%', '%%GLOBAL_OrderId%%'); return false;">%%LNG_PrintPackingSlip%%</a>
	</td>
</tr>
<tr id="trQ%%GLOBAL_ShipmentId%%" style="display: none">
	<td>&nbsp;</td>
	<td colspan="8" class="QuickView">&nbsp;</td>
</tr>