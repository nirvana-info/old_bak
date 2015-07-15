<a name="ordersByDateAnchor"></a>
<div style="text-align:right">
	<div style="padding-bottom:10px">
		%%LNG_OrdersPerPage%%:
		<select onchange="ChangeOrdersByDatePerPage(this.options[this.selectedIndex].value)">
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
			%%LNG_OrderID%% &nbsp;
			%%GLOBAL_SortLinksId%%
		</td>

		<td nowrap align="left">
			%%LNG_Customer%% &nbsp;
			%%GLOBAL_SortLinksCust%%
		</td>
		<td nowrap align="left">
			%%LNG_Date%% &nbsp;
			%%GLOBAL_SortLinksDate%%
		</td>
		<td nowrap align="left">
			%%LNG_Total%% &nbsp;
			%%GLOBAL_SortLinksTotal%%
		</td>
		<td nowrap align="left">
			%%LNG_TrackingNo%%
		</td>
		<td nowrap align="left">
			%%LNG_Action%%
		</td>
	</tr>
	%%GLOBAL_OrderGrid%%
</table>
%%GLOBAL_JumpToOrdersByDateGrid%%
