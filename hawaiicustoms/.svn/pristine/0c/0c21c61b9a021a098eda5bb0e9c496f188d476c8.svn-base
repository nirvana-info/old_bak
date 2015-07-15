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
		<input id="ApplyBtn" type="button" class="Submit SubmitButton" value="%%LNG_Apply%%" style="display:%%GLOBAL_ShowSendBtn%%"/>
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
	
	$('#ApplyBtn').click(function(){
	    var templateId = $('input[name=templateId]:checked').val();
	    $.ajax({
				type	: "GET",
				url	    : "index.php",
				data    : {
		        	'ToDo': 'viewRewrequest',
		        	'templateId': templateId,
		        	'orderId': '%%GLOBAL_OrderId%%'
		        },
				success	: function(data){
					$('#ajaxContainer').html(data);
				}
			});
	});
});
</script>