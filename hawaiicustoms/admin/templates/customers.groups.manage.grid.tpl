
			<tr class="Heading3" style="display: %%GLOBAL_DisplayGrid%%">
				<td align="center" style="width:18px"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
				<td>&nbsp;</td>
				<td>
					%%LNG_CustomerGroupName%% &nbsp;
					%%GLOBAL_SortLinksGroupName%%
				</td>
				<td>
					%%LNG_Discount%% &nbsp;
					%%GLOBAL_SortLinksDiscount%%
				</td>
				<td>
					<span class="HelpText" onmouseout="HideQuickHelp(this);" onmouseover="ShowQuickHelp(this, '%%LNG_DiscountRules%%', '%%LNG_DiscountRulesHelp%%');">%%LNG_DiscountRules%%</span> &nbsp;
					%%GLOBAL_SortLinksDiscountRules%%
				</td>
				<td>
					%%LNG_CustomersInGroup%% &nbsp;
					%%GLOBAL_SortLinksCustomersInGroup%%
				</td>
				<td style="width:120px;">
					%%LNG_Action%%
				</td>
			</tr>
			%%GLOBAL_CustomerGroupsGrid%%
			<tr align="right">
				<td colspan="11" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>
