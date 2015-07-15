/* Demo Note:  This demo uses a FileProgress class that handles the UI for displaying the file name and percent complete.
The FileProgress class is not part of SWFUpload.
*/


/* **********************
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks.  These aren't part of the SWFUpload
   package.  They are part of my application.  Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */
var errorNum_type = 0;
var errorNum_surpass = 0;
var errorNum_desc = 0;
var errorNum_imgnum = 0;

function fileQueued(file) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		//progress.setStatus("Waiting for upload");
		progress.toggleCancel(true, this);

	} catch (ex) {
		this.debug(ex);
	}

}

function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit." : (message >= 1 ? "You may select up to " + message + " files." : " ")));
			return;
		}

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			progress.setStatus("File is too big.");
			this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			progress.setStatus("Cannot upload Zero Byte files.");
			this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			progress.setStatus("Invalid File Type.");
			this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		default:
			if (file !== null) {
				progress.setStatus("Unhandled Error");
			}
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if (numFilesSelected > 0) {
			document.getElementById(this.customSettings.cancelButtonId).disabled = false;
		}
		
		/* I want auto start the upload and I can do that here */
		//this.startUpload();
	} catch (ex)  {
        this.debug(ex);
	}
}

function uploadStart(file) {
	try {
		/* I don't want to do any file validation or anything,  I'll just update the UI and
		return true to indicate that the upload should start.
		It's important to update the UI here because in Linux no uploadProgress events are called. The best
		we can do is say we are uploading.
		 */
		
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("Uploading...");
		progress.toggleCancel(true, this);
		this.addFileParam(file.id, "imageDesc", $("#"+file.id+" textarea").val());
		this.addFileParam(file.id, "uploaderFirstName", $("#uploaderFirstName").val());
		this.addFileParam(file.id, "uploaderLastName", $("#uploaderLastName").val());
		this.addFileParam(file.id, "address1", $("#address1").val());
		this.addFileParam(file.id, "address2", $("#address2").val());
		this.addFileParam(file.id, "swfUpload", true);
	}
	catch (ex) {}
	
	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setProgress(percent);
		progress.setStatus("Uploading...");
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess(file, serverData) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		var json = eval('(' + serverData + ')');
		if(json.status != 1){
			//progress.setStatus(json.message);
			var id = file.id;
			if(json.errorCode == -1){
				errorNum_type++;
			}else if(json.errorCode == -2){
				errorNum_surpass++;
			}else if(json.errorCode == -3){
				errorNum_desc++;
			}else if(json.errorCode == -4){
				errorNum_imgnum++;
			}
			$("#"+id+" .progressCancel").bind("click", function(){
				progress.setError();
				//$("#"+id).css({"opcity":"0", "height":"0px", "display":"none"});
			});
			$("#"+id).children().addClass("red");
			progress.toggleCancel(true, this);
		}else{
			progress.setComplete();
			progress.setStatus(json.message);
			progress.toggleCancel(false, this);
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadError(file, errorCode, message) {
	//console.log(message);
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);
		
		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			progress.setStatus("Upload Error: " + message);
			this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			progress.setStatus("Upload Failed.");
			this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			progress.setStatus("Server (IO) Error");
			this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			progress.setStatus("Security Error");
			this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			progress.setStatus("Upload limit exceeded.");
			this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			progress.setStatus("Failed Validation.  Upload skipped.");
			this.debug("Error Code: File Validation Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			// If there aren't any files left (they were all cancelled) disable the cancel button
			if (this.getStats().files_queued === 0) {
				document.getElementById(this.customSettings.cancelButtonId).disabled = true;
			}
			progress.setStatus("Cancelled");
			progress.setCancelled();
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			progress.setStatus("Stopped");
			break;
		default:
			progress.setStatus("Unhandled Error: " + errorCode);
			this.debug("Error Code: " + errorCode + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function uploadComplete(file) {
	if (this.getStats().files_queued === 0) {
		document.getElementById(this.customSettings.cancelButtonId).disabled = true;
	}
	
}

function sendEmail(){
	$.ajax({
            url: '/account.php?action=sendimageuploaderemail',
            type: 'POST', 
            cache: false,
            dataType: 'text',
            data: {'sendEmail': true},
            error: function(){
            },
            success: function(data){
            }
        });
}

// This event comes from the Queue Plugin
function queueComplete(numFilesUploaded) {
	var failNum = errorNum_desc + errorNum_surpass + errorNum_type;
	var status = document.getElementById("divStatus");
	numFilesUploaded = numFilesUploaded - failNum;
	status.innerHTML = numFilesUploaded + " file uploaded.";
	
	// send email
	if(numFilesUploaded != 0){
		sendEmail();
	}
	
	if(errorNum_desc || errorNum_surpass || errorNum_type || errorNum_imgnum){
		if(errorNum_desc){
			error_msg = 'Fail to upload '+errorNum_desc+' image(s): You must enter a description for each image submitted!';
		}
		if(errorNum_surpass){
			error_msg += '<br/>' + 'Fail to upload ' +errorNum_surpass+' image(s): Description should not surpass 1000 characters!'
		}
		if(errorNum_type){
			error_msg += '<br/>' + 'Fail to upload ' +errorNum_type+' image(s): Invalid type of file!'
		}
		if(errorNum_imgnum){
			error_msg += '<br/>' + 'Fail to upload ' +errorNum_imgnum+' image(s): You cannot upload more than ' + imageUploader_maxNum + ' images!'
		}
		errorNum_desc = 0;
		errorNum_surpass = 0;
		errorNum_type = 0;
		errorNum_imgnum = 0;
		$("#errormsg").html(error_msg);
	}else{
		// all of upload success
		window.location = '/account/showimage';	
	}
}
