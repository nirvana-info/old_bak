<script type="text/javascript" src="script/select.js"></script>
<form enctype="multipart/form-data" action="index.php?ToDo=saveBulkEditProducts" onsubmit="return ValidateForm(CheckBulkEditProductForm)" id="frmProduct" method="post">
<input type="hidden" name="product_ids" value="%%GLOBAL_ProductIds%%" />
<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
	<tr>
		<td class="Heading1">%%LNG_BulkEditProducts1%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%LNG_BulkEditIntro%%</div>
			%%GLOBAL_Message%%
			<p>
				<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" />
				<input type="submit" value="%%LNG_SaveAndContinueEditing%%" onclick="SaveAndKeepEditing()" class="FormButton" style="width:130px" />
				<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
			</p>
		</td>
	</tr>
	<tr>
		<td>
			<table class="GridPanel SortableGrid AutoExpand" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
				<tr class="Heading3">
					<td>&nbsp;</td>
					<td style="width:20%"><span class="Required">*</span> %%LNG_ProductName%%</td>
					<td style="width:80px"><span class="Required">*</span> %%LNG_Price%%</td>
					<td style="width:210px"><span class="Required">*</span> %%LNG_Categories%%</td>
					<td style="width:80px">%%LNG_Brand%%</td>
					<td style="width:80px">%%LNG_Visible%%</td>
					<td style="width:80px">%%LNG_Featured%%</td>
					<td style="width:80px">%%LNG_FreeShipping%%</td>
				</tr>
				<tr class="GridRow">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><a href="#" onclick="ChangeAllPrices(); return false;">%%LNG_ChangeAll%%</a></td>
					<td><a href="#" onclick="ExpandAllCategories(); return false;">%%LNG_ExpandAllCategories%%</a></td>
					<td><a href="#" onclick="ChangeAllBrands(); return false;">%%LNG_ChangeAll%%</a></td>
					<td><input type="checkbox" id="change_all_visible" /></td>
					<td><input type="checkbox" id="change_all_featured" /></td>
					<td><input type="checkbox" id="change_all_freeshipping" /></td>
				</tr>
				%%GLOBAL_ProductList%%
			</table>
			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
				<tr>
					<td>
						<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" />
						<input type="submit" value="%%LNG_SaveAndContinueEditing%%" onclick="SaveAndKeepEditing();" class="FormButton" style="width:130px" />
						<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
</div>
</form>

<script type="text/javascript">

	function ExpandAllCategories() {
		var f = g("frmProduct").elements;
		for(i = 0; i < f.length; i++) {
			if(f[i].id.indexOf("category_") == 0) {
				cid = f[i].id;
				cid = cid.replace("category_", "");
				cid = cid.replace("_old", "");
				ExpandCategories(cid);
			}
		}
	}

	function ExpandCategories(ProductId, Img) {
		if($('#catdrop_'+ProductId).attr('src').indexOf('drop') > -1) {
			$('#category_'+ProductId).css('height', '250px');
			g('catdrop_'+ProductId).src = 'images/collapsearrow.gif';
		}
		else {
			$('#category_'+ProductId).css('height', '23px');
			g('catdrop_'+ProductId).src = 'images/droparrow.gif';
		}
	}

	function ForceExpandCategories(ProductId, Img) {
		$('#category_'+ProductId).css('height', '250px');
		g('catdrop_'+ProductId).src = 'images/collapsearrow.gif';
	}

	function ConfirmCancel() {
		if(confirm("%%LNG_ConfirmCancelBulkEditProduct%%"))
			document.location.href = "index.php?ToDo=viewProducts";
	}

	function SaveAndKeepEditing() {
		var f = g('frmProduct');
		var d = document.createElement('input');
		d.type = 'hidden';
		d.name = 'keepediting';
		d.value = '1';
		f.appendChild(d);
	}

	function CheckBulkEditProductForm() {
		// Make sure all required fields are completed
		var f = g("frmProduct").elements;
		for(i = 0; i < f.length; i++) {
			if(f[i].id.indexOf("prodname_") == 0 && f[i].value == "") {
				alert("%%LNG_BulkEditEnterProductName%%");
				f[i].focus();
				return false;
			}

			if(f[i].id.indexOf("prodprice_") == 0 && (isNaN(priceFormat(f[i].value)) || f[i].value == "")) {
				alert("%%LNG_BulkEditEnterProductPrice%%");
				f[i].focus();
				f[i].select();
				return false;
			}

			if(f[i].id.indexOf("category_") == 0 && f[i].selectedIndex == -1) {
				alert("%%LNG_BulkEditNoCats%%");
				cid = f[i].id;
				cid = cid.replace("category_", "");
				cid = cid.replace("_old", "");
				ForceExpandCategories(cid, g("catdrop_"+cid));
				return false;
			}
		}

		return true;
	}

	function ChangeAllPrices() {
		var f = g("frmProduct").elements;
		var price = prompt("%%LNG_BulkEditNewPrice%%:");

		if(price != null) {
			if(isNaN(priceFormat(price)) || price == "") {
				alert("%%LNG_BulkEditEnterProductPrice%%");
				ChangeAllPrices();
			}
			else {
				for(i = 0; i < f.length; i++) {
					if(f[i].id.indexOf("prodprice_") == 0) {
						f[i].value = price;
					}
				}
			}
		}
	}

	function ChangeAllBrands() {
		var f = g("frmProduct").elements;
		var brand = prompt("%%LNG_BulkEditNewBrand%%:");

		if(brand != null) {
			for(i = 0; i < f.length; i++) {
				if(f[i].id.indexOf("prodbrand_") == 0) {
					f[i].value = brand;
				}
			}
		}
	}

	$('#change_all_visible').click(function() {
		var f = g("frmProduct").elements;
		var visible = $(this).attr('checked');

		for(i = 0; i < f.length; i++) {
			if(f[i].id.indexOf("prodvisible_") == 0) {
				f[i].checked = visible;
			}
		}
	});

	$('#change_all_featured').click(function() {
		var f = g("frmProduct").elements;
		var featured = $(this).attr('checked');

		for(i = 0; i < f.length; i++) {
			if(f[i].id.indexOf("prodfeatured_") == 0) {
				f[i].checked = featured;
			}
		}
	});

	$('#change_all_freeshipping').click(function() {
		var f = g("frmProduct").elements;
		var freeshipping = $(this).attr('checked');

		for(i = 0; i < f.length; i++) {
			if(f[i].id.indexOf("prodfreeshipping_") == 0) {
				f[i].checked = freeshipping;
			}
		}
	});

</script>
