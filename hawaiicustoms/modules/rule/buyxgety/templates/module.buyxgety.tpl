%%LNG_BUYXGETYamount%%
%%GLOBAL_Qty0%%
%%LNG_BUYXGETYOf%%
<a href="#" id="ps" onclick="DiscountOpenProductSelect('discount', 'ps', 'prodids', 1, 'ps');">%%GLOBAL_var_ps%%</a>
%%LNG_BUYXGETYThen%%
%%GLOBAL_Qty1%%
%%LNG_BUYXGETYOf%%
<a href="#" id="ps_free" onclick="DiscountOpenProductSelect('discount', 'ps_free', 'prodidsfree', 1, 'ps_free');" >%%GLOBAL_var_ps_free%%</a>
%%LNG_BUYXGETYFree%%


<input type="hidden" name="var_prodids" id="prodids" value="%%GLOBAL_var_prodids%%" />
<input type="hidden" name="var_prodidsfree" id="prodidsfree" value="%%GLOBAL_var_prodids%%" />
<input type="hidden" name="var_ps" id="ps_name" value="%%GLOBAL_var_ps%%" />
<input type="hidden" name="var_ps_free" id="ps_free_name" value="%%GLOBAL_var_ps_free%%" />
<br />
<script type="text/javascript">

$('#amount').val(%%GLOBAL_var_amount%%);
$('#amount_free').val(%%GLOBAL_var_amount_free%%);


function DiscountOpenProductSelect(type, select, idlist, single, closeFocus) {
	var l = (screen.availWidth/2) - (400/2) + 50;
	var t = (screen.availHeight/2) - (480/2) + 50;
	var width = 400;

	windowLocation = 'index.php?ToDo=popupProductSelect';
	windowLocation += '&selectCallback=DiscountProductSelectCallback';
	windowLocation += '&removeCallback=ProductSelectRemoveCallback';
	windowLocation += '&getSelectedCallback=ProductSelectGetSelected';
	windowLocation += '&ProductList='+idlist;
	windowLocation += '&ProductSelect='+select;
	windowLocation += '&single='+single;
	windowLocation += '&FocusOnClose='+closeFocus;
	var w = window.open(windowLocation, 'ProductSelect'+select+'type'+type, "width="+width+",height=480,left="+l+",top="+t);
	w.focus();
	return false;
}

function DiscountProductSelectCallback(selectBox, listField, product, single)
{
	if(single == 1) {
		$('#'+selectBox).html(product.name);
		$('#'+selectBox+'_name').val(product.name);
		$('#'+listField).val(product.id);
	}
}

</script>