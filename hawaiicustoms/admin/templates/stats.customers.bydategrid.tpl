<a name="customersByDateAnchor"></a>
<div style="text-align:right">
	<div style="padding-bottom:10px">
		%%LNG_CustomersPerPage%%:
		<select onchange="ChangeCustomersByDatePerPage(this.options[this.selectedIndex].value)">
			<option %%GLOBAL_IsShowPerPage5%% value="5">5</option>
			<option %%GLOBAL_IsShowPerPage10%% value="10">10</option>
			<option %%GLOBAL_IsShowPerPage20%% value="20">20</option>
			<option %%GLOBAL_IsShowPerPage30%% value="30">30</option>
			<option %%GLOBAL_IsShowPerPage50%% value="50">50</option>
			<option %%GLOBAL_IsShowPerPage100%% value="100">100</option>
			<option %%GLOBAL_IsShowPerPage200%% value="200">200</option>
		</select>
	</div>
	%%GLOBAL_Paging%%
</div>
<br />
<table width="100%" border=0 cellspacing=1 cellpadding=5 class="text">
	<tr class="Heading3">
			<td nowrap align="left">
			%%LNG_CustomerID%% &nbsp;
			%%GLOBAL_SortLinksCustId%%
		</td>
		<td align="left">
			%%LNG_StatsCustomerName%% &nbsp;
			%%GLOBAL_SortLinksCust%%
		</td>
		<td align="left">
			%%LNG_StatsEmail%% &nbsp;
			%%GLOBAL_SortLinksEmail%%
		</td>
		<td align="left">
			%%LNG_StatsDateJoined%% &nbsp;
			%%GLOBAL_SortLinksDate%%
		</td>
		<td align="right">
			<span onmouseover="ShowQuickHelp(this, '%%LNG_StatsOrders%%', '%%LNG_RevenuePerCustomerOrdersHelp%%');" onmouseout="HideQuickHelp(this);" class="HelpText">%%LNG_StatsOrders%%</span> &nbsp;
			%%GLOBAL_SortLinksNumOrders%%
		</td>
		<td align="right">
			<span onmouseover="ShowQuickHelp(this, '%%LNG_StatsAmountSpent%%', '%%LNG_RevenuePerCustomerAmountSpentHelp%%');" onmouseout="HideQuickHelp(this);" class="HelpText">%%LNG_StatsAmountSpent%%</span> &nbsp;
			%%GLOBAL_SortLinksAmountSpent%%
		</td>
		<td nowrap align="left">
			%%LNG_Action%%
		</td>
	</tr>
	%%GLOBAL_CustomerGrid%%
</table>
%%GLOBAL_JumpToCustomersByDateGrid%%
