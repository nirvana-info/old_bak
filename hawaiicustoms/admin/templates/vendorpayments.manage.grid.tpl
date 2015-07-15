<table class="GridPanel SortableGrid AutoExpand" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
	<tr style="text-align: right">
		<td colspan="9" style="padding:6px 0px 6px 0px" class="PagingNav">
			%%GLOBAL_Nav%%
		</td>
	</tr>
	<tr class="Heading3">
		<td align="center"><input type="checkbox" onclick="$(this.parentForm).find('input:checkbox').not(':disabled').attr('checked', this.checked);" /></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td nowrap="nowrap" style="width: 120px;">
			%%LNG_PaymentId%% &nbsp;
			%%GLOBAL_SortLinksId%%
		</td>
		<td>
			%%LNG_Vendor%% &nbsp;
			%%GLOBAL_SortLinksVendor%%
		</td>
		<td nowrap="nowrap">
			%%LNG_SalesPeriod%% &nbsp;
			%%GLOBAL_SortLinksDate%%
		</td>
		<td nowrap="nowrap" style="width: 150px;">
			%%LNG_PaymentAmount%% &nbsp;
			%%GLOBAL_SortLinksAmount%%
		</td>
		<td nowrap="nowrap" style="width: 120px;">
			%%LNG_DatePaid%% &nbsp;
			%%GLOBAL_SortLinksPaymentDate%%
		</td>
		<td nowrap="nowrap">
			%%LNG_PaymentMethod%% &nbsp;
			%%GLOBAL_SortLinksMethod%%
		</td>
	</tr>
	%%GLOBAL_PaymentGrid%%
	<tr style="text-align: right">
		<td colspan="9" style="padding:6px 0px 6px 0px" class="PagingNav">
			%%GLOBAL_Nav%%
		</td>
	</tr>
</table>