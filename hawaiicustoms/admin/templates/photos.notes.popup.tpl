<div class="ModalTitle">
	Photo Notes
</div>
<div class="ModalContent">
	<p class="MessageBox MessageBoxInfo">
		Use the text box below to make notes on this photo. (Please limit your characters to 250 !!!)
	</p>
	<p id="popup_warning" class="MessageBox MessageBoxError" style="display:none;">
		Your characters exceeded 250 !!!
	</p>

	<form action="" id="notesForm">
		<input type="hidden" id="photoId" name="photoId" value="%%GLOBAL_PhotoId%%" />
		<textarea id="photonotes" name="photonotes" rows="8" style="width:100%;">%%GLOBAL_PhotoNotes%%</textarea>
	</form>
</div>
<div class="ModalButtonRow">
	<div class="FloatLeft">
		<img src="images/loading.gif" alt="" style="vertical-align: middle; display: none;" class="LoadingIndicator" />
		<input type="button" class="CloseButton FormButton" value="%%LNG_Cancel%%" onclick="$.modal.close();" />
	</div>
	<input type="button" class="Submit" value="%%LNG_Save%%" name="SaveNotesButton" onclick="Photos.SaveNotes()" />
</div>
<script language="javascript">
$(document).ready(function(){
	var photonotes = $('#photonotes');
	var popup_warning = $('#popup_warning');
	photonotes.keyup(function(){
		if(photonotes.val().length > 250){
			popup_warning.show();
		}else{
			popup_warning.hide();
		}
	});
});
</script>