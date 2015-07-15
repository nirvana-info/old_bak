<div id="ajaxContainer">
<div>
	<div id="ModalTitle">
		%%LNG_ChooseTemplateForRequest%%
	</div>
	<div id="ModalContent" style="min-height: 100px; max-height: 350px; overflow: auto;">
		<p class="MessageBox MessageBoxInfo">%%GLOBAL_RemindMessage%%</p>
		<br />
		<div style="height: 260px; overflow: auto;">
		<table cellspacing="5" cellpadding="0" border="0" width="100%">
			<tr>
				<th align="right">
					&nbsp;
			    </th>
				<th align="left">
					%%LNG_Description%%
				</th>
				<th align="left">
					%%LNG_CouponCode%%
				</th>
			</tr>
			%%GLOBAL_TemplateList%%
		</table>
		</div>
	</div>
	<div id="ModalButtonRow">
		<div class="FloatLeft"><input class="CloseButton" type="button" value="%%LNG_Close%%" onclick="$.modal.close();" /></div>
		<img src="images/loading.gif" alt="" style="display: none" class="LoadingIndicator" />
		<input id="SendBtn" type="button" class="Submit SubmitButton" value="%%LNG_SendRequest%%" style="display:%%GLOBAL_ShowSendBtn%%"/>
	</div>
</div>
</div>
<script type="text/javascript">
$(function(){
	if(%%GLOBAL_SelectedId%% == 0){
		$('input[name=templateId]').each(function(){
			if($(this).next().val() == true){
				$(this).attr('checked', 'checked');
			}
		});
	}
	else
	{
		$('input[name=templateId]').each(function(){
			if(this.value == %%GLOBAL_SelectedId%%){
				this.checked = 'checked';
			}
		});
	}
	
	$('#SendBtn').click(function(){
		//alert("ok");
		SetCookie('ReportDetail','',-1);
		SetCookie('ReportResult','',-1);
	    var templateId = $('input[name=templateId]:checked').val();
	    $.modal.close();
		var url = 'index.php?ToDo=createRewRequests&templateId='+templateId+'&orders=%%GLOBAL_OrderIds%%&TB_iframe=true&height=150&width=400&modal=true&random='+new Date().getTime();
	    tb_show('', url, '');
	   
	    
	    /*$.ajax({
				type	: "GET",
				url	    : "index.php",
				data    : {
		        	'ToDo': 'sendRewrequestsMulty',
		        	'templateId': templateId,
		        	'orderIds': '%%GLOBAL_OrderIds%%'
		        },
				success	: function(data){
					//$('#ajaxContainer').html(data);
		        	var report = data;//data.substring(1);
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
			});*/
		
	});
});
</script>