<div class="toolbar">
	<h1 id="pageTitle">%%LNG_Orders%%</h1>
	<a style="position:absolute; left:5px; top:8px; width:59px" class="button" href="%%GLOBAL_ShopPath%%/admin/index.php?ToDo=viewOrders" type="submit">%%LNG_AllOrders%%</a>
	<a class="button" href="#searchForm">%%LNG_Search%%</a>
</div>
<ul selected="true">
	%%GLOBAL_Message%%
	%%GLOBAL_OrderGrid%%
	<li style="text-align:center">%%GLOBAL_SmallNav%%&nbsp;</li>
</ul>
<form id="searchForm" class="dialog" action="index.php?ToDo=searchOrdersRedirect" method="get" onsubmit="alert(5)">
	<input type="hidden" name="paymentMethod" value="" />
	<input type="hidden" name="shippingMethod" value="" />
	<input type="hidden" name="couponCode" value="" />
	<input type="hidden" name="orderFrom" value="" />
	<input type="hidden" name="orderTo" value="" />
	<input type="hidden" name="totalFrom" value="" />
	<input type="hidden" name="totalTo" value="" />
	<input type="hidden" name="dateRange" value="" />
	<input type="hidden" name="fromDate" value="" />
	<input type="hidden" name="toDate" value="" />
	<input type="hidden" name="sortField" value="orderid" />
	<input type="hidden" name="sortOrder" value="asc" />
	<fieldset>
	    <h1>%%LNG_OrderSearch%%</h1>
	    <a class="button leftButton" type="cancel">%%LNG_Cancel%%</a>
	    <input type="text" id="searchQuery" value="%%LNG_SearchOrdersPlaceholder%%" onclick="if(this.value=='%%LNG_SearchOrdersPlaceholder%%') { this.value=''; this.style.color='#000'; }" style="color:#CACACA; padding-left:3px; font-size:15px" />
	    <select id="orderStatus" style="font-size:16px; width:100%">
		<option value="">%%LNG_AllOrderStatuses%%</option>
		%%GLOBAL_OrderStatusOptions%%
	    </select>
	    <input type="button" value="%%LNG_Search%%" onclick="searchRedir()" />
	</fieldset>
</form>

<script type="text/javascript">

	function searchRedir() {
		var q = document.getElementById("searchQuery").value;
		var s = document.getElementById("orderStatus").value;

		if(q == "%%LNG_SearchOrdersPlaceholder%%") {
			q = "";
		}

		document.location.href = "%%GLOBAL_ShopPath%%/admin/index.php?ToDo=searchOrdersRedirect&SubmitButton1=Search&searchQuery="+q+"&orderStatus="+s+"&paymentMethod=&shippingMethod=&couponCode=&orderFrom=&orderTo=&totalFrom=&totalTo=&dateRange=&fromDate=&toDate=&sortField=orderid&sortOrder=desc";
		return false;
	}

</script>