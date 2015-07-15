var path = tinyMCEPopup.getParam('shop_path');
var selectedItem = "";

function load_list(list, dataType, mdata) {
	if (jQuery.trim($("#" + list).html()) != "") return;

	$.ajax({
		type: 'GET',
		url: path + '/remote.php?w=linker&d=' + dataType,
		data: mdata,
		success: function(data) {
			var result_list = document.createElement('UL');
			$("#" + list).append(result_list);

			$(data).find('result').each(function(i){
				var newItem = document.createElement('li');
				newItem.index = i;
				newItem.onclick =  function(e) {
					select_item(this);
				}
				newItem.innerHTML = "<img src=\"" + path + "/admin/" + $(this).attr('icon') + "\" style=\"vertical-align: middle\" />&nbsp;" + $(this).attr('title');
				newItem.title = $(this).attr('title');
				if ($(this).attr('catid') != undefined) {
					newItem.id = list +  "_" + $(this).attr('catid');
				}
				newItem.insertable = $(this).text();
				result_list.appendChild(newItem);
				if ($(this).attr('padding') != undefined) {
					newItem.style.paddingLeft = $(this).attr('padding') + 'px';
				}
			});
		}
	});
}

function select_item(element) {
	$(element).siblings(".selected").removeClass("selected");
	$(element).addClass("selected");

	if ($(element).parents("div").attr("id") == "ProductByCategoryList") {
		var id = $(element).attr("id").substr(22);

		 $("#ProductByKeywordList").html("");
		 // load the products
		load_list('ProductByKeywordList', 'products', 'category=' + id);

	}
	else {
		selectedItem = {
			href: element.insertable,
			title: $(element).attr('title')
		};
	}
}

function insertLink() {
	if (selectedItem == "") {
		return;
	}

	var title = '';

	// is text selected?
	if (tinyMCE.activeEditor.selection.getContent()) {
		// delete the selection
		title = tinyMCE.activeEditor.selection.getContent();
		tinyMCE.activeEditor.selection.setContent('');
	}
	else {
		title = selectedItem.title;
	}

	// Insert the link to the editor
	tinyMCEPopup.editor.execCommand('mceInsertContent', false, '<a href="' + selectedItem.href + '">' + title + '</a>');

	tinyMCEPopup.close();
}

var t;

function setSearchTimeout() {
	if (t) {
		clearTimeout(t);
	}

	t = setTimeout("searchProducts()", 1000);
}

function searchProducts() {
	if ($("#productName").val() != "" && $("#productName").val().length > 2) {
		$("#ProductByKeywordList").html("");
		// load products by search term
		load_list('ProductByKeywordList', 'products', 'searchQuery=' + $("#productName").val());
	}
	else {
		$("#ProductByKeywordList").html("{#linker_dlg.enter_terms}");
	}
}

$(document).ready(function() {
	load_list("ProductByCategoryList", "categories", "");
});