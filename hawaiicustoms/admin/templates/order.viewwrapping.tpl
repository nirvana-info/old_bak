<div id="ModalTitle">
	%%LNG_GiftWrappingFor%% %%GLOBAL_ProductQuantity%% x %%GLOBAL_ProductName%%
</div>
<div id="ModalContent" style="min-height: 100px; max-height: 400px; overflow: auto;">
	<table cellspacing="5" cellpadding="0" border="0" width="100%">
		<tr>
			<td class="FieldLabel">%%LNG_GiftWrapping%%:</td>
			<td style="padding: 4px;">%%GLOBAL_WrapName%% (%%GLOBAL_WrapPrice%%)</td>
		</tr>
		<tr style="%%GLOBAL_HideWrapMessage%%">
			<td class="FieldLabel">%%LNG_GiftMessage%%:</td>
			<td style="padding: 4px;">%%GLOBAL_WrapMessage%%</td>
		</tr>
	</table>
</div>
<div id="ModalButtonRow">
		<input type="button" class="Submit" value="%%LNG_Close%%" onclick="$.modal.close();" />
</div>