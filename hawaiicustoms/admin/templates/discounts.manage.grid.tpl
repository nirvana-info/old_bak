		<table class="GridPanel SortableGrid" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
				<tr align="right">
					<td colspan="10" style="padding:6px 0px 6px 0px" class="PagingNav">
						%%GLOBAL_Nav%%
						<br />
					</td>
				</tr>
			<tr class="Heading3">
				<td align="center" style="width:18px"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
				<td style="width:30px;"></td>
				<td>
					<span>%%LNG_DiscountName%%</span>
				</td>                                                                          
                <td width="90px">
                    <span>%%LNG_DiscountType%%</span>
                </td>
				<td nowrap style="width:100px">
					%%LNG_DiscountMaxUses%% &nbsp;
				</td>
				<td nowrap style="width:60px">
					<span onmouseover="ShowQuickHelp(this, '%%LNG_DiscountCurrentUses%%', '%%LNG_DiscountCurrentUsesHelp%%');" onmouseout="HideQuickHelp(this);" class="HelpText">%%LNG_DiscountCurrentUses%%</span>
				</td>
                <td nowrap style="width:100px">
                    <div style="display:none" id="invDiv" name="invDiv"></div>
                    %%LNG_DiscountStartDate%%
                </td>
				<td nowrap style="width:100px">
					<div style="display:none" id="invDiv" name="invDiv"></div>
					%%LNG_DiscountExpiryDate%%
				</td>  
				<td style="width:80px">
					%%LNG_Enabled%% &nbsp;
				</td>
				<td style="width:130px">
					<span onmouseover="ShowQuickHelp(this, '%%LNG_Halts%%', '%%LNG_HaltsHelp%%');" onmouseout="HideQuickHelp(this);" class="HelpText">%%LNG_Halts%%</span>
				</td>
				<td style="width:80px">
					%%LNG_Action%%
				</td>
			</tr>
		</table>
		<ul class="SortableList" id="DiscountList" style=" padding-top: 1px; padding-bottom: 1px; z-index:0">
					%%GLOBAL_DiscountGrid%%
		</ul>