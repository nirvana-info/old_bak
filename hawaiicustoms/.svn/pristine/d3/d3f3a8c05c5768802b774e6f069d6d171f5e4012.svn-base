//zcs=>
var Photos = {
	
	ViewPhoto: function(photoId){
		var img = $('#img_' + photoId);
		$.iModal({
			data: img.html(),
			width: null,
			imgShow:{
				imgWidth: img.width(),
				imgHeight: img.height()
			},
			closeCss: {
				right: '-20px',
				top: '-15px'
			}
		});
	},
	
	ViewNotes: function(photoId)
	{
		$.iModal({
			type: 'ajax',
			url: 'remote.php?remoteSection=customers&w=viewPhotoNotes&photoId='+photoId,
			width: 600
		});
	},

	SaveNotes: function()
	{
		var notesForm = $('#notesForm');
		$('.ModalButtonRow .CloseButton').hide();
		$('.ModalButtonRow .LoadingIndicator').show();
		$('.ModalButtonRow .Submit')
			.data('oldValue', $('.ModalButtonRow .Submit').val())
			.attr('disabled', true)
			.val(lang.SavingNotes)
		;
		$.ajax({
			type: 'post',
			url: 'remote.php?remoteSection=customers&w=savePhotoNotes',
			data: notesForm.serialize(),
			dataType: 'xml',
			success: function(xml)
			{
				var messageType = '';
				var status = parseInt($('status', xml).text());
				if(status == 0){
					messageType = 'Error';
				}else{
					Photos.reloadNotes(notesForm.find('#photoId').val());
				}
				$.modal.close();
				if($('message', xml).text()) {
					display_message('PhotoStatus', $('message', xml).text(), 0, messageType);
				}
			},
			error: function()
			{
				$('.ModalButtonRow .CloseButton').show();
				$('.ModalButtonRow .LoadingIndicator').hide();
				$('.ModalButtonRow .Submit')
					.attr('disabled', false)
					.val($('.ModalButtonRow .Submit').val())
				;
			}
		})
	},
	
	reloadNotes: function(photoId){
		$.ajax({
			type: 'get',
			url: 'remote.php?remoteSection=customers&w=getPhotoNotes',
			data: {'photoId':photoId},
			dataType: 'xml',
			success: function(xml)
			{
				var status = parseInt($('status', xml).text());
				var notes = $('notes', xml).text();
				var photoId = $('photoid', xml).text();
				if(status == 1){
					$('#notes_' + photoId).html(notes);
				}
			}
		})
	}
}
//<=zcs