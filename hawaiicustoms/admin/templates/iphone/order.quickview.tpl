<div class="toolbar">
	<h1 id="pageTitle">%%LNG_Order%% #%%GLOBAL_OrderId%%</h1>
        <a style="position:absolute; left:5px; top:8px; width:30px" class="button" href="javascript:history.go(-2)" type="submit">%%LNG_Back%%</a>
	<a style="width:59px" class="button" href="%%GLOBAL_ShopPath%%/admin/index.php?ToDo=viewOrders" type="submit">%%LNG_AllOrders%%</a>
</div>
<ul id="order" title="%%LNG_Order%% #%%GLOBAL_OrderId%%" selected="true">
	<li style="height:25px; display:%%GLOBAL_HideMessageItems%%" class="subMenu">
		<ul class="tab">
			<li id="od" onclick="SubMenu(this)" class="tabSelected">%%LNG_OrderDetails%%</li>
			<li id="om" onclick="SubMenu(this)">%%LNG_OrderMessages%% <div style="display:%%GLOBAL_HideMessages%%" class="newIcon newOrderIcon">%%GLOBAL_NumMessages%%</div></li>
		</ul>
	</li>
	<li class="group">%%LNG_OrderItems%%</li>
	<li>
		%%GLOBAL_ProductsTable%%
	</li>
	<li class="group">%%LNG_DateOrdered%%</li>
	<li>
		%%GLOBAL_OrderDate%%<br />
	</li>
	<li class="group">%%LNG_EmailAddress%%</li>
	<li>%%GLOBAL_BillingEmail%%</li>
	<li class="group">%%LNG_PhoneNumber%%</li>
	<li><a href="tel:%%GLOBAL_BillingPhone%%" type="submit">%%GLOBAL_BillingPhone%%</a></li>
	<li class="group">%%LNG_BillingDetails%%</li>
	<li>
		%%GLOBAL_BillingAddress%% (<span style="text-decoration:underline; color:#194FDB" onclick="document.location.href='http://maps.google.com/maps?q=%%GLOBAL_OneLineBillingAddress%%'">%%LNG_MapThis%%</span>)<hr />
		%%GLOBAL_PaymentMethod%%<hr />
		%%LNG_TransactionID%%: %%GLOBAL_TransactionId%%
	</li>
	<li class="group" style="display:%%GLOBAL_HideShippingPanel%%">%%LNG_ShippingDetails%%</li>
	<li style="display:%%GLOBAL_HideShippingPanel%%">
		%%GLOBAL_ShippingAddress%% (<span style="text-decoration:underline; color:#194FDB" onclick="document.location.href='http://maps.google.com/maps?q=%%GLOBAL_OneLineShippingAddress%%'">%%LNG_MapThis%%</span>)<hr />
		%%GLOBAL_ShippingMethod%% (%%GLOBAL_ShippingCost%%)<hr />
		%%LNG_ShippedOn%% %%GLOBAL_ShippingDate%%
	</li>
	<li class="group" style="%%GLOBAL_HideOrderComments%%">%%LNG_OrderComments%%</li>
	<li style="%%GLOBAL_HideOrderComments%%">
		%%GLOBAL_OrderComments%%
	</li>
	<li class="group">%%LNG_OrderStatus1%%</li>
	<li>
		<div id="statusMessage" style="width:94%; margin:-7px 0px 5px -10px; display:none; z-index: 10; background: url('images/info.gif') 5px 5px #FFF1AC; background-repeat:no-repeat; padding:5px 0px 5px 30px" onclick="this.style.display='none';">%%LNG_StatusUpdatedShort%%</div>
		<select id="orderStatus" style="width:98%; font-size:16px" onblur="UpdateOrderStatus(this.value)">
			%%GLOBAL_OrderStatusOptions%%
		</select>
		<img id="statusLoader" style="display:none" src="images/ajax-loader.gif" width="16" height="16" />
	</li>
	<li class="group" style="display:%%GLOBAL_HideShippingPanel%%">%%LNG_TrackingNumber1%%</li>
	<li style="display:%%GLOBAL_HideShippingPanel%%">
		<div id="trackingMessage" style="width:94%; margin:-7px 0px 5px -10px; display:none; z-index: 10; background: url('images/info.gif') 5px 5px #FFF1AC; background-repeat:no-repeat; padding:5px 0px 5px 30px" onclick="this.style.display='none';">%%LNG_TrackingUpdatedShort%%</div>
		<input id="trackingNo" type="text" value="%%GLOBAL_TrackingNo%%" style="width:55%; padding-left:3px" /> <input type="button" value="%%LNG_Update%%" style="width:30%" onclick="UpdateTrackingNo()" />
		<img id="trackingLoader" style="display:none; padding-left:5px" src="images/ajax-loader.gif" width="16" height="16" />

	</li>
	<li class="group">%%LNG_DeleteOrder%%</li>
	<li>
		<form id="frmDelete" method="post" action="index.php?ToDo=deleteOrders" onsubmit="return CheckDeleteOrder()">
			<input type="hidden" name="orders[]" value="%%GLOBAL_OrderId%%" />
			<input type="submit" value="%%LNG_DeleteThisOrder%%" style="width:98%" />
		</form>
	</li>
</ul>

<script type="text/javascript">

	var tok = "%%GLOBAL_AuthToken%%";

	function UpdateOrderStatus(Status) {
		var os = document.getElementById("orderStatus");
		var sl = document.getElementById("statusLoader");
		os.style.width = "90%";
		os.style.margin = "0px 5px 0px 0px";
		sl.style.display = "";

		$.ajax({
			type: "POST",
			url: "remote.php",
			data: "w=updateOrderStatus&o=%%GLOBAL_OrderId%%&s="+Status+"&t="+tok,
			success: function(msg){
				$('#statusMessage').css('display', 'block');
				os.style.width = "98%";
				sl.style.display = "none";
				window.setTimeout("$('#statusMessage').hide();", 3000);
			}
		});
	}

	function CheckDeleteOrder() {
		if(confirm("%%LNG_AreYouSureShort%%")) {
			return true;
		}
		else {
			return false;
		}
	}

	function UpdateTrackingNo() {
		var tn = escape(document.getElementById("trackingNo").value);
		$('#trackingLoader').show();

		$.ajax({
			type: "POST",
			url: "remote.php",
			data: "w=updateTrackingNo&o=%%GLOBAL_OrderId%%&tn="+tn+"&t="+tok,
			success: function(msg){
				$('#trackingMessage').css('display', 'block');
				$('#trackingLoader').hide();
				window.setTimeout("$('#trackingMessage').hide();", 3000);
			}
		});
	}

	function SubMenu(Tab) {
		switch(Tab.id) {
			case "od": {
				document.location.reload();
				break;
			}
			case "om": {
				document.location.href = "index.php?ToDo=viewOrderMessages&orderId=%%GLOBAL_OrderId%%";
				break;
			}
		}
	}

</script>