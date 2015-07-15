<div class="ModalTitle">
	%%LNG_ProductVariationPopupHeading%%
</div>
<div class="ModalContent">
	<p class="MessageBox MessageBoxInfo">
		%%GLOBAL_ProductVariationPopupIntro%%
	</p>

	<div id="VariationAffectedProductList">
		<dl>
			%%GLOBAL_AffectedProducts%%
		</dl>
	</div>
</div>
<div class="ModalButtonRow">
	<div class="FloatLeft">
		<img src="images/loading.gif" alt="" style="vertical-align: middle; display: none;" class="LoadingIndicator" />
		<input type="button" class="CloseButton FormButton" value="%%LNG_Cancel%%" onclick="$.modal.close();" />
	</div>
	<input type="button" class="Submit" value="%%LNG_Save%%" onclick="SaveVariation()" />
</div>
<script type="text/javascript"><!--

	function SaveVariation()
	{
		$.modal.close();
		window.parent.variationForm.submit();
	}

//-->
</script>