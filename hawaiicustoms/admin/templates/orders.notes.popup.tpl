<div class="ModalTitle">
	%%LNG_OrderNotesPopupHeading%%
</div>
<div class="ModalContent">
	<p class="MessageBox MessageBoxInfo">
		%%LNG_OrderNotesPopupIntro%%
	</p>

	<form action="" id="notesForm">
		<input type="hidden" id="orderId" name="orderId" value="%%GLOBAL_OrderID%%" />
		<textarea id="ordnotes" name="ordnotes" rows="8" style="width:100%;">%%GLOBAL_OrderNotes%%</textarea>
	</form>
</div>
<div class="ModalButtonRow">
	<div class="FloatLeft">
		<img src="images/loading.gif" alt="" style="vertical-align: middle; display: none;" class="LoadingIndicator" />
		<input type="button" class="CloseButton FormButton" value="%%LNG_Cancel%%" onclick="$.modal.close();" />
	</div>
	<input type="button" name="SaveNotesButton" class="Submit" value="%%LNG_Save%%" onclick="Order.SaveNotes('%%GLOBAL_ThankYouID%%')" />
</div>