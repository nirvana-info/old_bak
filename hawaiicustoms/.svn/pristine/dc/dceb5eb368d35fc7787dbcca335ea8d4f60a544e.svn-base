/* Common Javascript functions for use throughout Interspire Shopping Cart */

// Fetch the value of a cookie
function get_cookie(name) {
	name = name += "=";
	var cookie_start = document.cookie.indexOf(name);
	if(cookie_start > -1) {
		cookie_start = cookie_start+name.length;
		cookie_end = document.cookie.indexOf(';', cookie_start);
		if(cookie_end == -1) {
			cookie_end = document.cookie.length;
		}
		return unescape(document.cookie.substring(cookie_start, cookie_end));
	}
}

// Set a cookie
function set_cookie(name, value, expires)
{
	if(!expires) {
		expires = "; expires=Wed, 1 Jan 2020 00:00:00 GMT;"
	} else {
		expire = new Date();
		expire.setTime(expire.getTime()+(expires*1000));
		expires = "; expires="+expire.toGMTString();
	}
	document.cookie = name+"="+escape(value)+expires;
}

/* Javascript functions for the products page */
var num_products_to_compare = 0;
var product_option_value = "";

function showProductImage(filename, product_id) {
	var l = (screen.availWidth/2)-350;
	var t = (screen.availHeight/2)-300;
	var variationAdd = '';
	if($('body').attr('currentVariation') != '' && typeof($('body').attr('currentVariation')) != "undefined") {
		variationAdd = '&variation_id='+$('body').attr('currentVariation');
	}
	window.open(filename + "?product_id="+product_id+variationAdd, "imagePop", "toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=700,height=600,top="+t+",left="+l);
}

function showProductImageNew(filename, product_id, cur_no) {

    var l = ((screen.availWidth - 800)/2);
    var t = ((screen.availHeight - 650)/2);
    var variationAdd = '';
    if($('body').attr('currentVariation') != '' && typeof($('body').attr('currentVariation')) != "undefined") {
        variationAdd = '&variation_id='+$('body').attr('currentVariation');
    }      
    window.open(filename + ""+"#"+cur_no, "imagePop", "toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=650,top="+t+",left="+l);
   //window.open(filename + "?product_id="+product_id+variationAdd+"#"+cur_no, "imagePop", "toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=650,top="+t+",left="+l);
}

function showProductVideoNew(filename, product_id) {
    var l = ((screen.availWidth - 550)/2);
    var t = ((screen.availHeight - 400)/2);
    var variationAdd = '';
    if($('body').attr('currentVariation') != '' && typeof($('body').attr('currentVariation')) != "undefined") {
        variationAdd = '&variation_id='+$('body').attr('currentVariation');
    }
    //window.open(filename + "?product_id="+product_id+variationAdd, "videoPop", "toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=550,height=400,top="+t+",left="+l);
    window.open(filename, "videoPop", "toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=550,height=400,top="+t+",left="+l); 
}

function CheckProductConfigurableFields(form)
{
	var requiredFields = $('.FieldRequired');
	var valid = true;
	requiredFields.each(function() {
		var namePart = this.name.replace(/^.*\[/, '');
		var fieldId = namePart.replace(/\].*$/, '');

		if(this.type=='checkbox' ) {
			if(!this.checked) {
				valid = false;
				alert(lang.EnterRequiredField);
				this.focus();
				this.select();
				return false;
			}
		} else if(this.value == '') {
			if(this.type != 'file' || (this.type == 'file' && document.getElementById('CurrentProductFile_'+fieldId).value == '')) {
				valid = false;
				alert(lang.EnterRequiredField);
				this.focus();
				this.select();
				return false;
			}
		}
	});

	var fileFields = $(form).find('input[type=file]');
	fileFields.each(function() {
		if(this.value != '') {
			var namePart = this.name.replace(/^.*\[/, '');
			var fieldId = namePart.replace(/\].*$/, '');
			var fileTypes = document.getElementById('ProductFileType_'+fieldId).value;

			fileTypes = ','+fileTypes.replace(' ', '').toLowerCase()+','
			var ext = this.value.replace(/^.*\./, '').toLowerCase();

			if(fileTypes.indexOf(','+ext+',') == -1) {
				alert(lang.InvalidFileTypeJS);
				this.focus();
				this.select();
				valid = false;
			}

		}
	});

	return valid;
}

function check_add_to_cart(form, required) {
	var valid = true;
	var qtyInputs = $(form).find('input.qtyInput');
	qtyInputs.each(function() {
		if(isNaN($(this).val()) || $(this).val() <= 0) {
			alert(lang.InvalidQuantity);
			this.focus();
			this.select();
			valid = false;
			return false;
		}
	});
	if(valid == false) {
		return false;
	}

	if(!CheckProductConfigurableFields(form)) {
		return false;
	}

	if(required && !$(form).find('.CartVariationId').val()) {
		alert(lang.OptionMessage);
		var select = $(form).find('select').get(0);
		if(select) {
			select.focus();
		}
		var radio = $(form).find('input[type=radio]').get(0);
		if(radio) {
			radio.focus();
		}
		return false;
	}

	if (!CheckEventDate()) {
		return false;
	}

	return true;
}

function compareProducts(compare_path) {
	var pids = "";

	if($('form').find('input[name=compare_product_ids][checked]').size() >= 2) {
		var cpids = document.getElementsByName('compare_product_ids');

		for(i = 0; i < cpids.length; i++) {
			if(cpids[i].checked)
				pids = pids + cpids[i].value + "/";
		}

		pids = pids.replace(/\/$/, "");
		document.location.href = compare_path + pids;
		return false;
	}
	else {
		alert(lang.CompareSelectMessage);
		return false;
	}
}

function product_comparison_box_changed(state) {
	// Increment num_products_to_compare - needs to be > 0 to submit the product comparison form


	if(state)
		num_products_to_compare++;
	else
		if (num_products_to_compare != 0)
			num_products_to_compare--;
}

function remove_product_from_comparison(id) {
	if(num_compare_items > 2) {
		for(i = 1; i < 11; i++) {
			document.getElementById("compare_"+i+"_"+id).style.display = "none";
		}

		num_compare_items--;
	}
	else {
		alert(lang.CompareTwoProducts);
	}
}

function show_product_review_form() {
	document.getElementById("rating_box").style.display = "";
	document.location.href = "#write_review";
}

function jump_to_product_reviews() {
	document.location.href = "#reviews";
}

function g(id) {
	return document.getElementById(id);
}

function check_product_review_form() {
	var revrating = g("revrating");
	var revtitle = g("revtitle");
	var revtext = g("revtext");
	var revfromname = g("revfromname");
	var captcha = g("captcha");

	if(revrating.selectedIndex == 0) {
		alert(lang.ReviewNoRating);
		revrating.focus();
		return false;
	}

	if(revtitle.value == "") {
		alert(lang.ReviewNoTitle);
		revtitle.focus();
		return false;
	}

	if(revtext.value == "") {
		alert(lang.ReviewNoText);
		revtext.focus();
		return false;
	}

	if(captcha.value == "" && HideReviewCaptcha != "none") {
		alert(lang.ReviewNoCaptcha);
		captcha.focus();
		return false;
	}

	return true;
}
/*
function check_small_search_form() {
	var search_query = g("search_query");

	if(search_query.value == "") {
		alert(lang.EmptySmallSearch);
		search_query.focus();
		return false;
	}

	return true;
}
*/
function setCurrency(currencyId)
{
	var gotoURL = location.href;

	if (location.search !== '')
	{
		if (gotoURL.search(/[&|\?]setCurrencyId=[0-9]+/) > -1)
			gotoURL = gotoURL.replace(/([&|\?]setCurrencyId=)[0-9]+/, '$1' + currencyId);
		else
			gotoURL = gotoURL + '&setCurrencyId=' + currencyId;
	}
	else
		gotoURL = gotoURL + '?setCurrencyId=' + currencyId;

	location.href = gotoURL;
}


// Dummy sel_panel function for when design mode isn't enabled
function sel_panel(id) {}

function inline_add_to_cart(filename, product_id, quantity, returnTo) {
	if(typeof(quantity) == 'undefined') {
		var quantity = '1';
	}
	var html = '<form action="' + filename + '/cart.php" method="post" id="inlineCartAdd">';
	if(typeof(returnTo) != 'undefined' && returnTo == true) {
		var returnLocation = window.location;
		html += '<input type="hidden" name="returnUrl" value="'+escape(returnLocation)+'" />';
	}
	html += '<input type="hidden" name="action" value="add" />';
	html += '<input type="hidden" name="qty" value="'+quantity+'" />';
	html += '<input type="hidden" name="product_id" value="'+product_id+'" />';
	html += '<\/form>';
   $('body').append(html);
   $('#inlineCartAdd').submit();
}


// Dummy JS object to hold language strings.
var lang = {
};

// IE 6 doesn't support the :hover selector on elements other than links, so
// we use jQuery to work some magic to get our hover styles applied.
if(document.all) {
	var isIE7 = /*@cc_on@if(@_jscript_version>=5.7)!@end@*/false;
	if(isIE7 == false) {
		$(document).ready(function() {
			$('.ProductList li').hover(function() {
				$(this).addClass('Over');
			},
			function() {
				$(this).removeClass('Over');
			});
			$('.ComparisonTable tr').hover(function() {
				$(this).addClass('Over');
			},
			function() {
				$(this).removeClass('Over');
			});
		});
	}
	$('.ProductList li:last-child').addClass('LastChild');
}

$(document).ready(function() {
	$('.InitialFocus').focus();
	$('table.Stylize tr:first-child').addClass('First');
	$('table.Stylize tr:last-child').addClass('Last');
	$('table.Stylize tr td:odd').addClass('Odd');
	$('table.Stylize tr td:even').addClass('Even');
	$('table.Stylize tr:even').addClass('Odd');
	$('table.Stylize tr:even').addClass('Even');

	$('.TabContainer .TabNav li').click(function() {
		$(this).parent('.TabNav').find('li').removeClass('Active');
		$(this).parents('.TabContainer').find('.TabContent').hide();
		$(this).addClass('Active');
		$(this).parents('.TabContainer').find('#TabContent'+this.id).show();
		$(this).find('a').blur();
		return false;
	});

});

function tooltip(path,id) { 
    $('#'+id).tooltip({ 
    showURL: false, 
    bodyHandler: function() {
        return $("<img>").attr("src", path);
    } 
    });
    }

	function ShowCompDesc(sku,id) 
	{
		var item = $('#'+id);
	    if(item.attr('checked'))    {       
	        $('#compqty_'+item.val()).show();
			$('#pr_'+item.val()).show();
	    }
	    else    {            
	        $('#compqty_'+item.val()).hide();
	        $('#pr_'+item.val()).hide();			
	    }
		var path = config.ShopPath + '/templates/default/images/small_pluscart.gif'
		var img = "<img src='"+path+"' id='tImage' />"
		var hidVal = $('#hid_'+id).val()
		var tabval = img + hidVal
		$('#CompItem_Tab > a').html(tabval)

		var phpUrl = config.ShopPath + '/complementarydesc.php';
		$.ajax(
		{
			url: phpUrl,
			type: 'GET', 
			cache: false,
			dataType: 'text',
			data: { prodsku: sku},
			error: function(){
			},
			success: function(data)
			{   
				$('#CompItem').html(data);

			}
		}
		);
	}

var config = {};