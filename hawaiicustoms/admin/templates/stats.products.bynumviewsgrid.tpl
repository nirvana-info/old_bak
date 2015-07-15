<a name="productsByNumViews"></a>
<div style="width:100%;clear:both;">
<div style="float:left;width:40%; height:40px;">%%LNG_TotalRevenue%%:%%GLOBAL_TotalRevenue%%</div>
<div style="float:right;width:50%;height:40px;text-align:right">
	<div style="padding-bottom:10px">
		%%LNG_ProductsPerPage%%:
		<select onchange="ChangeProductsByNumViewsPerPage(this.options[this.selectedIndex].value)">
			<option %%GLOBAL_IsShowPerPage5%% value="5">5</option>
			<option %%GLOBAL_IsShowPerPage10%% value="10">10</option>
			<option %%GLOBAL_IsShowPerPage20%% value="20">20</option>
			<option %%GLOBAL_IsShowPerPage30%% value="30">30</option>
			<option %%GLOBAL_IsShowPerPage50%% value="50">50</option>
			<option %%GLOBAL_IsShowPerPage100%% value="100">100</option>
		</select>
	</div>
	%%GLOBAL_Paging%%
</div>
</div>
<br />
<table width="100%" border=0 cellspacing=1 cellpadding=5 class="text">
	<tr class="Heading3">
		<!--<td align="left">
			%%LNG_ProductID%% &nbsp;
			%%GLOBAL_SortLinksProductId%%
		</td>
		<td align="left">
			%%LNG_ProductSKU%% &nbsp;
			%%GLOBAL_SortLinksCode%%
		</td>-->  <!--Commented by Simha-->
		<td align="left">
			%%LNG_Item%% &nbsp;
			%%GLOBAL_SortLinksName%%
		</td>
		%%GLOBAL_extracol%%
		<td align="left">
			<span onmouseover="ShowQuickHelp(this, '%%LNG_StatsViews%%', '%%LNG_ProductsByNumViewsHelp%%');" onmouseout="HideQuickHelp(this);" class="HelpText">%%LNG_StatsViews%%</span> &nbsp;
			%%GLOBAL_SortLinksViews%%
		</td>
        <td align="left">
            <span>%%LNG_UnitsSold%%</span> &nbsp;
            %%GLOBAL_SortLinksUnitsSold%%
        </td>
        <td align="left">
            <span>Units Sold/Views</span> &nbsp;
            %%GLOBAL_SortLinksUnitsSoldPercent%% 
        </td>
		<td align="left">
			%%LNG_AverageRating%% &nbsp;
			%%GLOBAL_SortLinksAverageRating%%
		</td>
	</tr>
	%%GLOBAL_OrderGrid%%
</table>
%%GLOBAL_JumpToOrdersByItemsViewsGrid%%
