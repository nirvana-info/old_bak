<script type="text/javascript" src="../javascript/formfield.js"></script>
<form action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(checkAddForm)" id="frmAddonProduct" method="post">
<input type="hidden" name="addonProductId" id="addonProductId" value="%%GLOBAL_AddonProductId%%">
<input id="currentTab" name="currentTab" value="0" type="hidden">
<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
	<tr>
		<td class="Heading1">%%GLOBAL_Title%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%GLOBAL_Intro%%</p>
			<div id="MessageTmpBlock">
				%%GLOBAL_Message%%
			</div>
			<div id="MessageBox" class="MessageBox MessageBoxError" style="display:none;">
				%%LNG_AddonProductDescriptionExceeded%%
			</div>
			<p>
				<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" name="SaveButton1" />
				<input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="SaveContinueButton1"  onclick="saveAndAddAnother();" class="FormButton Field150" />
				<input type="button" value="%%LNG_Cancel%%" class="FormButton" name="CancelButton1" onclick="confirmCancel()" />
			</p>
		</td>
	</tr>
	<tr>
		<td>
			<ul id="tabnav">
				<li><a href="#" id="tab0" onclick="ShowTab(0)" class="active">%%LNG_AddonProductDetails%%</a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<div id="div0" style="padding-top: 10px;">
				<div style="padding-bottom:5px">%%LNG_AddonProductDetailsIntro%%</div>
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_AddonProductDetails%%</td>
					</tr>
					<tr class="rowItem">
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_AddonProductProductId%%:
						</td>
						<td>
							<div style="position:relative;">
								<input type="hidden" name="addonProductProductId" id="addonProductProductId" class="Field250" value="%%GLOBAL_AddonProductProductId%%" />
								<input type="text" name="addonProductProductName" id="addonProductProductName" class="Field750" value="%%GLOBAL_AddonProductProductName%%" onkeypress="SingleProduct.ProductSearch(this)" autocomplete="off" />
								<a href="#" onclick="SingleProduct.ShowProductSelector(); return false;" tabindex="66000">
									<img src="images/find.gif" alt="" style="border: 0" />
								</a>
							</div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_AddonProductPrice%%:
						</td>
						<td>
							%%GLOBAL_CurrencyTokenLeft%% <input type="text" id="addonProductPrice" name="addonProductPrice" class="Field50" value="%%GLOBAL_AddonProductPrice%%" /> %%GLOBAL_CurrencyTokenRight%%
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_AddonProductDescription%%:
						</td>
						<td>
							<textarea id="addonProductDescription" name="addonProductDescription" cols="50" rows="5">%%GLOBAL_AddonProductDescription%%</textarea>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_AddonProductStatus%%:
						</td>
						<td>
							<select id="addonProductStatus" name="addonProductStatus" class="Field300">
								<option value="1" %%GLOBAL_AddonProductStatusEnabled%%>Enabled</option>
								<option value="0" %%GLOBAL_AddonProductStatusDisabled%%>Disabled</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
				</table>
			</div>
		</div>
		<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain" id="SaveButtons">
			<tr>
				<td>
					<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" name="SaveButton2" />
					<input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="SaveContinueButton2" onclick="saveAndAddAnother();" class="FormButton Field150" />
					<input type="button" value="%%LNG_Cancel%%" class="FormButton" name="CancelButton2" onclick="confirmCancel()" />
				</td>
			</tr>
		</table>
		</td>
	</tr>
	</table>
</div>
</form>

<script type="text/javascript"><!--
	$(document).ready(function() {
		ShowTab(%%GLOBAL_CurrentTab%%);
		//zcs=>Initialize SingleProduct
		SingleProduct.proSelectId = 'addonProductProductId';
		SingleProduct.proSelectName = 'addonProductProductName';
		SingleProduct.proSelectPrice = 'addonProductPrice';
		//<=zcs
		//zcs=>
		var desc = $('#addonProductDescription');
		var messageBox = $('#MessageBox');
		desc.keyup(function(){
			if(desc.val().length > 250){
				messageBox.show();
			}else{
				messageBox.hide();
			}
		});
		//<=zcs
	});

	function ShowTab(T)
	{
			i = 0;
			while (document.getElementById("tab" + i) != null) {
				document.getElementById("div" + i).style.display = "none";
				document.getElementById("tab" + i).className = "";
				i++;
			}

			if (T == 1 || T==2) {
				$('#SaveButtons').hide();
			} else {
				$('#SaveButtons').show();
			}

			document.getElementById("div" + T).style.display = "";
			document.getElementById("tab" + T).className = "active";
			document.getElementById("currentTab").value = T;
	}
	

	function saveAndAddAnother() {
		MakeHidden('addanother', '1', 'frmAddonProduct');
	}


	function confirmCancel() {
		if(confirm('%%GLOBAL_CancelMessage%%')) {
			document.location.href='index.php?ToDo=viewAddonProducts';
		} else {
			return false;
		}
	}

	function checkAddForm()
	{
		var productId = parseInt($('#addonProductProductId').val().split(',')[0]);//get the first one
		var objProductName = $('#addonProductProductName');
		if (isNaN(productId) || productId <= 0) {
			alert("%%LNG_AddonProductProductRequired%%");
			objProductName.focus();
			return false;
		}
		
		var objPrice = $('#addonProductPrice');
		var valPrice = priceFormat(objPrice.val());
		if(isNaN(parseInt(valPrice)) || valPrice < 0) {
			alert("%%LNG_AddonProductPriceInvalid%%");
			objPrice.focus();
			return false;
		}
		
		var objDescription = $('#addonProductDescription');
		if(objDescription.val().length > 250){
			alert("%%LNG_AddonProductDescriptionExceeded%%");
			objDescription.focus();
			return false;
		}
		
		var objStatus = $('#addonProductStatus');
		if (isNaN(parseInt(objStatus.val()))) {
			alert("%%LNG_AddonProductInvalidStatus%%");
			objStatus.focus();
			return false;
		}

		return true;
	}
//--></script>
<script language="javascript" src="script/singleproduct.js"></script>
