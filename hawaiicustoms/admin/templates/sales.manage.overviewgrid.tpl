<a name="productsByNumSoldAnchor"></a>
<div style="text-align:right">
	<!--<div style="padding-bottom:10px">
		%%LNG_ProductsPerPage%%:
		<select onchange="ChangeProductsByNumSoldPerPage(this.options[this.selectedIndex].value)">
			<option %%GLOBAL_IsShowPerPage5%% value="5">5</option>
			<option %%GLOBAL_IsShowPerPage10%% value="10">10</option>
			<option %%GLOBAL_IsShowPerPage20%% value="20">20</option>
			<option %%GLOBAL_IsShowPerPage30%% value="30">30</option>
			<option %%GLOBAL_IsShowPerPage50%% value="50">50</option>
			<option %%GLOBAL_IsShowPerPage100%% value="100">100</option>
		</select>
	</div>-->
	<!--%%GLOBAL_Paging%%-->
</div>
<br />
<table width="100%" border=0 cellspacing=1 cellpadding=5 class="text">
	<tr class="Heading3">
		<td align="left">
			UserName &nbsp;
		</td>
		<td align="left">
			Completed &nbsp;
		</td>
		<td align="left">
			Cancelled &nbsp;
		</td>
		<td align="left">
			Pending &nbsp;
		</td>
		<td align="left">
			Returned &nbsp;
		</td>
		<td align="left">
			Total Revenue &nbsp;
		</td>
	</tr>
	%%GLOBAL_OrderGrid%%
</table>
%%GLOBAL_JumpToOrdersByItemsSoldGrid%%
