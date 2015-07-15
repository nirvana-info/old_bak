		<table class="GridPanel SortableGrid" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
				<tr align="right">
					<td colspan="10" style="padding:6px 0px 6px 0px" class="PagingNav">
						%%GLOBAL_Nav%%
						<br />
					</td>
				</tr>
			<tr class="Heading3">
				<td align="center" style="width:18px"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
				<td>&nbsp;</td>
				<td>
					%%LNG_CouponName%% &nbsp;
					%%GLOBAL_SortLinksName%%
				</td>
				<td nowrap>
					%%LNG_CouponCode%% &nbsp;
					%%GLOBAL_SortLinksCoupon%%
				</td>
				<td nowrap>
					%%LNG_Discount%% &nbsp;
					%%GLOBAL_SortLinksDiscount%%
				</td>
				<td nowrap>
					<div style="display:none" id="invDiv" name="invDiv"></div>
					%%LNG_ExpiryDate%%
					%%GLOBAL_SortLinksExpiry%%
				</td>
				<td nowrap>
					%%LNG_NumUses%%
					%%GLOBAL_SortLinksNumUses%%
				</td>
				<td style="width:80px">
					%%LNG_Enabled%% &nbsp;
					%%GLOBAL_SortLinksEnabled%%
				</td>
				<td nowrap>
					%%LNG_Type%%
					%%GLOBAL_SortLinksType%%
				</td>
				<td style="width:130px">
					%%LNG_Action%%
				</td>
			</tr>
			%%GLOBAL_CouponGrid%%
			<tr align="right">
				<td colspan="10" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>
		</table>