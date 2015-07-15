<div id="ajaxContainer">
<div>
	<div id="ModalTitle">
		%%LNG_PreviewRequest%% #%%GLOBAL_OrderId%% (%%GLOBAL_OrderDate%%)
	</div>
	<div id="ModalContent" style="min-height: 100px; max-height: 400px; overflow: auto;">
		<p class="MessageBox MessageBoxInfo">%%GLOBAL_RemindMessage%%</p>
		<br />
		<table class="GridPanel ShipmentTable" cellspacing="0" cellpadding="0">
			<tr class="Heading3">
				<td>%%LNG_RequestSent%%</td>
			</tr>
		</table>
		<br />
		<!-- strong style="color: #000">%%LNG_RequestDetail%%</strong-->
		<div style="min-height: 100px; max-height: 250px; overflow: auto;">
		%%GLOBAL_PreviewTemplate%%
		%%GLOBAL_bc258%%
		</div>
	</div>
	<div id="ModalButtonRow">
		<div class="FloatLeft"><input class="CloseButton" type="button" value="%%LNG_Close%%" onclick="$.modal.close();" /></div>
		<img src="images/loading.gif" alt="" style="display: none" class="LoadingIndicator" />
		<input type="button" id='BackBtn' class="Submit SubmitButton" value="%%LNG_Back%%" style="display:%%GLOBAL_ShowSendBtn%%"/>
		<input type="button" id='SendBtn' class="Submit SubmitButton" value="%%LNG_SendRequest%%" style="display:%%GLOBAL_ShowSendBtn%%"/>
	</div>
</div>
</div>
<script type="text/javascript">
$(function(){
	$('#BackBtn').click(function(){
		$.ajax({
				type	: "GET",
				url	    : "remote.php",
				data    : {
		        	'remoteSection': 'orders',
		        	'w': 'previewOrdRequest',
		        	'orderId': '%%GLOBAL_OrderId%%',
		        	'selectedId': '%%GLOBAL_TemplateId%%'
		        },
				success	: function(data){
					$('#ajaxContainer').html(data);
				}
		});
	});
	
	$('#SendBtn').click(function(){
		SetCookie('ReportDetail','',-1);
		SetCookie('ReportResult','',-1);
		var templateId=%%GLOBAL_TemplateId%%;
		$.ajax({
			type	: "GET",
			url	    : "index.php",
			data	: "ToDo=sendRewRequests&o=%%GLOBAL_OrderId%%&success=0&failed=0&resend=1" + "&templateId="+ templateId,
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
	});
});
</script>