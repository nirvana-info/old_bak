<div id="ajaxContainer">
<div>
	<div id="ModalTitle">
		%%LNG_PreviewSitemap%% (%%GLOBAL_SitemapType%%)
	</div>
	<div id="ModalContent" style="min-height: 100px; max-height: 400px; overflow: auto;">
		<p class="MessageBox MessageBoxInfo">%%GLOBAL_RemindMessage%%</p>
		<div style="min-height: 100px; max-height: 250px; overflow: auto;">
		%%GLOBAL_PreviewTemplate%%
		</div>
	</div>
	<div id="ModalButtonRow">
		<div class="FloatLeft"><input class="CloseButton" type="button" value="%%LNG_Cancel%%" onclick="$.modal.close();" /></div>
		<img src="images/loading.gif" alt="" style="display: none" class="LoadingIndicator" />
		<input type="button" id='GenerateBtn' class="Submit SubmitButton" value="%%LNG_Generate%%"/>
	</div>
</div>
</div>
<script type="text/javascript">
$(function(){
	$('#GenerateBtn').click(function(){
		if(confirm('%%LNG_GenerateWarning%%')){
			parent.window.ShowLoadingIndicator();
			window.parent.submitSitemapForm('%%GLOBAL_GenerateUrl%%');
		}
	});
});
</script>