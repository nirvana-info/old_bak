<div id="ModalTitle">
	%%LNG_RequestReport%%
</div>
<div id="ModalContent" style="min-height: 100px; max-height: 400px; overflow: auto;">
	<p class="MessageBox MessageBoxInfo">%%GLOBAL_ReportResult%%</p>
	<br />
	<table class="GridPanel ShipmentTable" cellspacing="0" cellpadding="0">
		<tr class="Heading3">
			<td>%%LNG_RequestReportDetail%%</td>
		</tr>
	</table>
	<br />
	<strong style="color: #000">%%LNG_RequestDetail%%</strong>
	<table cellspacing="5" cellpadding="0" border="0" width="100%">
		<tr>
			<td>%%LNG_OrderID%%</td>
			<td>%%LNG_SendStatus%%</td>
			<td>%%LNG_SendResult%%</td>
			<td>%%LNG_ExtraAction%%</td>
		</tr>
        %%GLOBAL_ReportDetail%%
	</table>
</div>
<div id="ModalButtonRow">
	<div class="FloatLeft"><input class="CloseButton" type="button" value="%%LNG_Close%%" onclick="$.modal.close();" /></div>
</div>
<script type="text/javascript">
function ResendOrdViewRequest(orderId,templateId){
	SetCookie('ReportDetail','',-1);
	SetCookie('ReportResult','',-1);
	$.ajax({
		type	: "GET",
		url	    : "index.php",
		data	: "ToDo=sendRewRequests&o=" + orderId + "&success=0&failed=0&resend=1&templateId="+ templateId,
		success	: function(data){
			var report = data.substring(1);
			var page = window.parent.document.getElementById('CurrentPage').value;
			var url = window.parent.location.href + '&page=' + page + '&ajax=1';
	
			$.ajax({
				type	: "GET",
				url	    : url,
				async   : false,
				success	: function(data){
					window.parent.document.getElementById('GridContainer').innerHTML = data;
					window.parent.BindAjaxGridSorting();
					$.modal.close();
				}
			});
	
			window.parent.document.getElementById('OrdersStatus').innerHTML = report;
		}
	});
}
</script>