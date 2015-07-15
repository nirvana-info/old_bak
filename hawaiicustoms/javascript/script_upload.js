/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	getEleId: script_upload.js 13226 2009-08-24 02:39:06Z zhengqingpeng getEle
*/

var attachexts = new Array();
var attachwh = new Array();

var userAgent = navigator.userAgent.toLowerCase();
var insertType = 1;
var no_insert = 1;
var thumbwidth = parseInt(60);
var thumbheight = parseInt(60);
var extensions = 'jpg,jpeg,gif,png,tiff,bmp';
var forms;
var nowUid = 0;
var albumid = 0;
var uploadStat = 0;
var picid = 0;
var aid = 0;
var bid = 0;
var topicid = 0;
var mainForm;
var successState = false;
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3) && (userAgent.indexOf('firefox') != -1);
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);
var is_safari = (userAgent.indexOf('webkit') != -1 || userAgent.indexOf('safari') != -1);
var ieVersion = userAgent.substr(userAgent.indexOf('msie') + 5, 3);

var error_msg = '';
var description = '';
var imagenum = 0;
//var errorNum = 0;
var errorNum_imgnum = 0;
var errorNum_type = 0;
var errorNum_size = 0;
var errorNum_surpass = 0;
var errorNum_desc = 0;

function getEle(obj){
	return document.getElementById(obj);
}

function showErrorMessage(){
	getEle('errormsg').innerHTML = error_msg;
}

function delAttach(id) {
	getEle('attachbody').removeChild(getEle('attach_' + id).parentNode.parentNode.parentNode);
	if(getEle('attachbody').innerHTML == '') {
		addAttach();
	}
	getEle('localimgpreview_' + id + '_menu') ? document.body.removeChild(getEle('localimgpreview_' + id + '_menu')) : null;
	imagenum--;
	if(imagenum <= imageUploadPerMax){
		forms = getEle('attachbody').getElementsByTagName("FORM");
		forms[forms.length-1].style.display = '';
	}
}

function addAttach() {

	newnode = getEle('attachbodyhidden').rows[0].cloneNode(true);
	var id = bid;
	var tags;
	tags = newnode.getElementsByTagName('form');
	for(i in tags) {
		if(tags[i].id == 'upload') {
			tags[i].id = 'upload_' + id;
		}
	}
	tags = newnode.getElementsByTagName('input');
	for(i in tags) {
		if(tags[i].name == 'attach') {
			tags[i].id = 'attach_' + id;
			tags[i].name = 'attach';
			tags[i].onchange = function() {insertAttach(id)};
			tags[i].unselectable = 'on';
		}
	}
	tags = newnode.getElementsByTagName('span');
	for(i in tags) {
		if(tags[i].id == 'localfile') {
			tags[i].id = 'localfile_' + id;
		}
	}
	bid++;

	getEle('attachbody').appendChild(newnode);
	
	if(imagenum == imageUploadPerMax){
		forms = getEle('attachbody').getElementsByTagName("FORM");
		forms[forms.length-1].style.display = 'none';			
	}
	
	imagenum++;
	
}

addAttach();

function getExt(path) {
	return path.lastIndexOf('.') == -1 ? '' : path.substr(path.lastIndexOf('.') + 1, path.length).toLowerCase();
}

function insertAttach(id) {
	var localimgpreview = '';
	var path = getEle('attach_' + id).value;
	var ext = getExt(path);
	var re = new RegExp("(^|\\s|,)" + ext + "($|\\s|,)", "ig");
	var localfile = getEle('attach_' + id).value.substr(getEle('attach_' + id).value.replace(/\\/g, '/').lastIndexOf('/') + 1);

	if(path == '') {
		return;
	}
	if(extensions != '' && (re.exec(extensions) == null || ext == '')) {
		alert('Sorry, invalid type of file');
		return;
	}
	attachexts[id] = inArray(ext, ['gif', 'jpg', 'jpeg', 'png', 'bmp', 'tiff']) ? 2 : 1;

	var inhtml = '<div class="borderbox"><table cellspacing="0" cellpadding="0" border="0"><tr>';
	if(1) {
		var picPath = getPath(getEle('attach_' + id));
		var imgCache = new Image();
		imgCache.src = picPath;
		inhtml += '<td><img src="' + picPath +'" width="60" height="80">&nbsp;</td>';
	}
	if(is_ie && typeof no_insert=='undefined' || insertType==0) {
		localfile += '&nbsp;<a href="javascript:;" title="click here to insert" onclick="insertAttachimgTag(' + id + ');return false;">[insert]</a>';
	}
	localfile += '&nbsp;<a href="javascript:;" onclick="delAttach(' + id + ')">[Delete]</a>';
	inhtml += '<td><span id="showmsg' + id + '"></span><br/>' + localfile + '<br/>';
	//inhtml += '<td>' + localfile + '<br/>';
	inhtml += '<span class="Required">*</span> <span>Please enter description for uploaded file, limited to 1000 characters.</span><br/><textarea name="pic_desc" cols="40" rows="2"></textarea>';
	inhtml += '<input type="hidden" value="" name="uploadFirstName" id="firstName' + id + '" />';
	inhtml += '<input type="hidden" value="" name="uploadLastName" id="lastName' + id + '" />';
	inhtml += '<input type="hidden" value="" name="address1" id="address1' + id + '" />';
	inhtml += '<input type="hidden" value="" name="address2" id="address2' + id + '" />';
	inhtml += '</td></tr></table></div>';
	
	getEle('localfile_' + id).innerHTML = inhtml;
	getEle('attach_' + id).style.display = 'none';

	addAttach();
}

function getPath(obj){
	if (obj) {
		if (is_ie) {
			obj.select();
			// IE
			return document.selection.createRange().text;
			
		} else if(is_moz) {
			if (obj.files) {
				// Firefox
				return obj.files.item(0).getAsDataURL();
			}
			return obj.value;
		} else{
			return '/images/nopreview.jpg';
		}
		return obj.value;
	}
}
function inArray(needle, haystack) {
	if(typeof needle == 'string') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}

function insertAttachimgTag(id) {
	if(insertType == 0) {
		insertImage(id);
	} else if(is_ie) {
		var picPath = getPath(getEle('attach_' + id));
		var imgCache = new Image();
		imgCache.src = picPath;
		edit_insert('<img id="_uchome_localimg_' + id + '" src="' + picPath + '">');
	} else {
		alert('Sorry，please use IE Browser');
	}
}

function uploadSubmit(obj) {
	obj.disabled = true;
	mainForm = obj.form;
	forms = getEle('attachbody').getElementsByTagName("FORM");
	albumid = getEle('uploadalbum').value;
	upload();
}

function sendEmail(){
	$.ajax({
            url: config.ShopPath + '/account.php?action=sendimageuploaderemail',
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

//上传页面
function start_upload() {
	//getEle('btnupload').disabled = true;
	forms = getEle('attachbody').getElementsByTagName("FORM");
	nowUid = 0; // be care, start_upload only use one time
	//errorNum = 0
	errorNum_imgnum = 0;
	errorNum_type = 0;
	errorNum_size = 0;
	errorNum_surpass = 0;
	errorNum_desc = 0;
	upload();
}

function upload() {
	if(typeof(forms[nowUid]) == 'undefined') return false;
	$("body").css("cursor", "wait");
	showErrorMessage();
	
	var nid = forms[nowUid].id.split('_');
	nid = nid[1];
	
	var lastFormId_tmp = forms[forms.length - 1].id.split('_');
	var lastFormId = lastFormId_tmp[1];
	if(nid != lastFormId){
		getEle('firstName'+nid).value = $('#uploaderFirstName').val();
		getEle('lastName'+nid).value = $('#uploaderLastName').val();
		getEle('address1'+nid).value = $('#address1').val();
		getEle('address2'+nid).value = $('#address2').val();
	}
	
	if(nowUid>0) {
		var upobj = getEle('showmsg'+aid);
		if(uploadStat==1) {
			upobj.style.color = "green";
			upobj.innerHTML = 'upload successful';
			successState = true;
			$("#upload_" + aid).parent().parent().remove("tr");
			nowUid--;
			forms = getEle('attachbody').getElementsByTagName("FORM");
		} else {
			upobj.style.color = "#f00";
			//upobj.innerHTML = uploadStat + 'upload fail ';
			//upobj.innerHTML = 'upload fail ';
			if(uploadStat == -1){
				errorNum_imgnum++;
			}else if(uploadStat == -2){
				errorNum_type++;
			}else if(uploadStat == -3){
				errorNum_size++;
			}else if(uploadStat == -4){
				errorNum_surpass++;
			}else if(uploadStat == -5){
				errorNum_desc++;
			}
			//errorNum++;
		}
	}
	if(getEle('showmsg'+nid) != null) {
		//getEle('showmsg'+nid).innerHTML = 'uploading，please wait';
		forms[nowUid].submit();
	} else if(nowUid+1 == forms.length) {
		if(!successState && forms.length == 1){
			error_msg = 'You have not selected any image!';
			showErrorMessage();
			$("body").css("cursor", "default");
			return false;
		}
		
		// send email
		sendEmail();
		
		if(errorNum_desc || errorNum_surpass || errorNum_imgnum || errorNum_type || errorNum_size){
			if(errorNum_desc){
				error_msg = 'Fail to upload '+errorNum_desc+' image(s): You must enter a description for each image submitted!';
			}
			if(errorNum_surpass){
				error_msg += '<br/>' + 'Fail to upload ' +errorNum_surpass+' image(s): Description should not surpass 1000 characters!'
			}
			if(errorNum_imgnum){
				error_msg += '<br/>' + 'Fail to upload ' +errorNum_imgnum+' image(s): You cannot upload more than ' + imageUploader_maxNum + ' images.'//zcs=max number configure
			}
			if(errorNum_type){
				error_msg += '<br/>' + 'Fail to upload ' +errorNum_type+' image(s): Invalid type of file!'
			}
			if(errorNum_size){
				error_msg += '<br/>' + 'Fail to upload ' +errorNum_size+' image(s): File is larger than '+ imageUploadMaxSize +' MB!'
			}
			
			showErrorMessage();
			//$("#uploadBtnContainer").html("<a href='/account/uploadimage'>I want to upload again</a>");
			$("body").css("cursor", "default");
			return false;
		}else {
			window.location = '/account/showimage';	
		}	
	}
	
	aid = nid;
	nowUid++;
	uploadStat = 0;

}
