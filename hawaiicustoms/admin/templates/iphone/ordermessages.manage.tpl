<div class="toolbar">
	<h1 id="pageTitle">%%LNG_Order%% #%%GLOBAL_OrderId%%</h1>
        <a style="position:absolute; left:5px; top:8px; width:30px" class="button" href="javascript:history.go(-2)" type="submit">Back</a>
	<a style="width:59px" class="button" href="%%GLOBAL_ShopPath%%/admin/index.php?ToDo=viewOrders" type="submit">%%LNG_AllOrders%%</a>
</div>
<ul id="order" title="%%LNG_Order%% #%%GLOBAL_OrderId%%" selected="true">
	<li style="height:25px" class="subMenu">
		<ul class="tab">
			<li id="od" onclick="SubMenu(this)">%%LNG_OrderDetails%%</li>
			<li id="om" onclick="SubMenu(this)" class="tabSelected">%%LNG_OrderMessages%%</li>
		</ul>
	</li>
	%%GLOBAL_MessageGrid%%
	<li class="group">%%LNG_PostNewMessage%%</li>
	<li style="border-bottom:solid 1px transparent">
		<form enctype="multipart/form-data" action="index.php?ToDo=saveNewOrderMessage" onsubmit="return CheckMessageForm()" method="post">
			<input type="hidden" name="orderId" value="%%GLOBAL_OrderId%%">
			<input type="hidden" name="messageId" value="%%GLOBAL_MessageId%%">
			<input type="hidden" name="subject" value="%%GLOBAL_MessageSubject%%">
			<textarea id="message" name="message" style="width:93%; height:50px; font-size:15px; color:#CACACA" onclick="SetupTextbox()">%%LNG_TapToTypeMessage%%</textarea>
			<input type="submit" value="Send Message to Customer" style="width:98%" />
		</form>
	</li>
</ul>

<script type="text/javascript">

	function SubMenu(Tab) {
		switch(Tab.id) {
			case "od": {
				document.location.href = "index.php?ToDo=viewSingleOrder&o=%%GLOBAL_OrderId%%";
				break;
			}
			case "om": {
				document.location.reload();
				break;
			}
		}
	}

	function SetupTextbox() {
		var m = document.getElementById("message");
		m.style.color = "#000";
		m.value = "";
	}

	function CheckMessageForm() {
		var m = document.getElementById("message");

		if(m.value == "" || m.value == "%%LNG_TapToTypeMessage%%") {
			alert("%%LNG_EnterMessageShort%%");
			return false;
		}

		return true;
	}

</script>