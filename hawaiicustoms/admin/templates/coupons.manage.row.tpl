	<tr class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'">
		<td align="center">
			<input type="checkbox" name="coupon[]" value="%%GLOBAL_CouponId%%">
		</td>
		<td align="center" style="width:18px;">
			<img src='images/coupon.gif'>
		</td>
		<td class="%%GLOBAL_SortedFieldNameClass%%">
			%%GLOBAL_Name%%
		</td>
		<td class="%%GLOBAL_SortedFieldCouponClass%%">
			<input type="text" value="%%GLOBAL_Coupon%%" class="Field100" readonly="ture" />
		</td>
		<td class="%%GLOBAL_SortedFieldDiscountClass%%">
			%%GLOBAL_Discount%%
		</td>
		<td class="%%GLOBAL_SortedFieldExpiryClass%%">
			%%GLOBAL_Date%%
		</td>
		<td class="%%GLOBAL_SortedFieldNumUsesClass%%">
			%%GLOBAL_NumUses%%
		</td>
		<td align="center" class="%%GLOBAL_SortedFieldEnabledClass%%">
			%%GLOBAL_Enabled%%
		</td>
		<td nowrap class="%%GLOBAL_SortedFieldEnabledClass%%">
			%%GLOBAL_Type%%
		</td>
		<td nowrap="nowrap">
			%%GLOBAL_EditCouponLink%%&nbsp;&nbsp;&nbsp;
			<a title='%%LNG_CopyCouponClip%%' href="javascript:CouponClipboard('%%GLOBAL_Coupon%%')">%%LNG_CopyToClipboard%%</a>
			%%GLOBAL_ViewOrdersLink%%
		</td>
	</tr>