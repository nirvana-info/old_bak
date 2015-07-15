<div class="ModalTitle">
	%%LNG_CustomerNotesPopupHeading%%
</div>
<div class="ModalContent">
	<p class="MessageBox MessageBoxInfo">
		%%LNG_CustomerNotesPopupIntro%%
	</p>

	<form action="" id="notesForm">
		<input type="hidden" id="customerId" name="customerId" value="%%GLOBAL_CustomerId%%" />
		<textarea id="custnotes" name="custnotes" rows="8" style="width:100%;">%%GLOBAL_CustomerNotes%%</textarea>
	</form>
</div>
<div class="ModalButtonRow">
	<div class="FloatLeft">
		<img src="images/loading.gif" alt="" style="vertical-align: middle; display: none;" class="LoadingIndicator" />
		<input type="button" class="CloseButton FormButton" value="%%LNG_Cancel%%" onclick="$.modal.close();" />
	</div>
	<input type="button" class="Submit" value="%%LNG_Save%%" name="SaveNotesButton" onclick="Customers.SaveNotes()" />
</div>