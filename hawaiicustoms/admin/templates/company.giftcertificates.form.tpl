
	<STYLE TYPE="text/css" MEDIA=screen>
	<!--
		.returnname {
			position: absolute; 
			//top: 630px; 
			//left: 355px; 
			width: 450px;
			background-color: white;
			visibility: hidden;
			boder: 1px solid black;
			//*left: 350px;
			//*top: 590px;
		}
	-->
	</STYLE>

	<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(CheckCouponForm)" id="frmNews" method="post" >
	<input type="hidden" id="cgcId" name="cgcId" value="%%GLOBAL_cgcId%%">
	<input type="hidden" id="cgcexpires" name="cgcexpires" value="">
	<input type="hidden" id="cgcCode" name="cgcCode" value="%%GLOBAL_cgcCode%%">
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%GLOBAL_Title%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_Intro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
		</td>
	  </tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_NewCompanyGiftCertificateDetail%%</td>
				</tr>
				<tr>
					<td class="FieldLabel" style="width:240px;" width="240px" >
						<span class="Required">*</span>&nbsp;%%LNG_CompanyGiftCertificateCode%%:
					</td>
					<td>
						<input type="text" id="cgccode" name="cgccode" class="Field250" value="%%GLOBAL_cgcCode%%" readonly/>
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_CompanyGiftCertificateCode%%', '%%LNG_CompanyGiftCertificateCodeHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d1"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_CompanyGiftCertificateName%%:
					</td>
					<td>
						<input type="text" id="cgcname" name="cgcname" class="Field250" value="%%GLOBAL_cgcName%%">
						<img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_CompanyGiftCertificateName%%', '%%LNG_CompanyGiftCertificateNameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d6"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_CompanyGiftCertificateAmount%%:
					</td>
					<td>
						<input type="text" id="cgcamount" name="cgcamount" class="Field50" value="%%GLOBAL_Amount%%">
						<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_CompanyGiftCertificateAmount%%', '%%LNG_CompanyGiftCertificateAmountHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						(Value must be between $%%GLOBAL_GiftCertificateMinimum%% and $%%GLOBAL_GiftCertificateMaximum%%)
						<div style="display:none" id="d2"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_CompanyGiftCertificateBalance%%:
					</td>
					<td>
						<input type="text" id="cgcbalance" name="cgcbalance" class="Field50" value="%%GLOBAL_Balance%%" >
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_CompanyGiftCertificateExpiryDate%%:%%GLOBAL_ExpiryDate%%
					</td>
					<td>
						<input class="plain" id="dc1" value="%%GLOBAL_ExpiryDate%%" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fStartPop(document.getElementById('dc1'),document.getElementById('dc2'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>
						&nbsp;<img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_CompanyGiftCertificateExpiryDate%%', '%%LNG_CompanyGiftCertificateExpiryDateHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d4"></div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_CompanyGiftCertificateMinimumPurchase%%:
					</td>
					<td>
						%%GLOBAL_CurrencyTokenLeft%% <input type="text" id="cgcminpurchase" name="cgcminpurchase" class="Field50" value="%%GLOBAL_MinPurchase%%"> %%GLOBAL_CurrencyTokenRight%%
						<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_CompanyGiftCertificateMinimumPurchase%%', '%%LNG_CompanyGiftCertificateMinimumPurchaseHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d3"></div>
					</td>
				</tr>
                <!-- comment by NI_20100901_Jack, cgcenable flag is duplicated with cgcstatus
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_Enabled%%:
					</td>
					<td>
						<input type="checkbox" id="cgcenabled" name="cgcenabled" value="ON" %%GLOBAL_Enabled%%> <label for="cgcenabled">%%LNG_CompanyGiftCertificateEnabled%%</label>
					</td>
				</tr>
                -->
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_CompanyGiftCertificateMessage%%:<div >&nbsp;&nbsp;&nbsp;(Optional)</div>
					</td>
					<td>
						<textarea class="Field350" cols="60" rows="3" id="message" name="message" onKeyDown="limitText(message);" onKeyUp="limitText(message);" >%%GLOBAL_CompanyGiftCertificateMessage%%</textarea><br />
						<small>(<span id="remaining">10</span> characters remaining)</small>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_CompanyGiftCertificateTheme%%:
					</td>
					<td>
						%%GLOBAL_GiftCertificateThemes%%
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_CompanyGiftCertificateRecipientName%%:
						<input type="button" value="Add one more" onclick= "addMoreRecipient()" /><input type="hidden" value="%%GLOBAL_recipientcount%%" id="recipientcount" name="recipientcount" />
					</td>
					<td><div id="recipient">
						<p id=recipient_1>
						Name:<input type="text" class="Textbox Field200" value="%%GLOBAL_to_name_1%%" id="to_name_1" name="to_name_1" onkeyup="getCustomerNameandEmail('to_name_result_1', 1, this.value)" >&nbsp;&nbsp;Email:<input type="text" class="Textbox Field200" value="%%GLOBAL_to_email_1%%" id="to_email_1" name="to_email_1"><a href="#" onclick="$('#to_name_1').val('');$('#to_email_1').val('');return false;">clear</a>
						<div id="to_name_result_1" name="to_name_result_1" class="ProductSearchResults  returnname" ></div>
						%%GLOBAL_recipient_other%%
                        </p>
					</div></td>
				</tr>
			</table>
			<table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_CompanyGiftCertificateAppliesTo%%</td>
				</tr>
				<tr>
					<td class="FieldLabel" style="width:240px;">
						<span class="Required">*</span>&nbsp;%%LNG_CompanyGiftCertificateAppliesTo%%:
					</td>
					<td style="padding-bottom: 3px;">
						<input onclick="ToggleUsedFor(0)" type="radio" id="usedforcat" name="usedfor" value="categories" %%GLOBAL_UsedForCat%%> <label for="usedforcat">%%LNG_CompanyGiftCertificateAppliesToCategories%%</label><br />
						<div id="usedforcatdiv" style="padding-left:25px">
							<select multiple="multiple" size="12" name="catids[]" id="catids" class="Field750 ISSelectReplacement">
								<option value="0" %%GLOBAL_AllCategoriesSelected%%>%%LNG_CompanyGiftCertificateAppliesToAllCategories%%</option>
								%%GLOBAL_CategoryList%%
							</select>
							<img onmouseout="HideHelp('d10');" onmouseover="ShowHelp('d10', '%%LNG_CompanyGiftCertificateChooseCategories%%', '%%LNG_CompanyGiftCertificateChooseCategoriesHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d10"></div>
						</div>
													<div style="clear: left;" />
						<input onclick="ToggleUsedFor(1)" type="radio" id="usedforprod" name="usedfor" value="products" %%GLOBAL_UsedForProd%%> <label for="usedforprod">%%LNG_CompanyGiftCertificateAppliesToProducts%%</label><br />
						<div id="usedforproddiv" style="padding-left:25px">
							<select size="12" name="products" id="ProductSelect" class="Field750" onchange="$('#ProductRemoveButton').attr('disabled', false);">
								%%GLOBAL_SelectedProducts%%
							</select>
							<div class="Field250" style="text-align: left;">
								<div style="float: right;">
									<input type="button" value="%%LNG_CompanyGiftCertificateRemoveSelected%%" id="ProductRemoveButton" disabled="disabled" class="FormButton" style="width: 125px;" onclick="removeFromProductSelect('ProductSelect', 'prodids');" />
								</div>
								<input type="button" value="%%LNG_CompanyGiftCertificateAddProduct%%" class="FormButton" style="width: 125px;" onclick="openProductSelect('coupon', 'ProductSelect', 'prodids');" />
							<input type="hidden" name="prodids" id="prodids" class="Field250" value="%%GLOBAL_ProductIds%%" />
						</div>
					</td>
				</tr>
			</table>


			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
				<tr>
					<td class="FieldLabel" style="width:240px;">
						&nbsp;
					</td>
					<td>
						<input type="submit" value="%%LNG_Save%%" class="FormButton" />
						<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
					</td>
				</tr>
			</table>

			</td>
		</tr>
	</table>

	</div>
	</form>

	<iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;"></iframe>
	<input type="text" id="dc2" name="dc2" style="display:none">

	<script type="text/javascript">

		function ConfirmCancel()
		{
			if(confirm("%%LNG_ConfirmCancelCompanyGiftCertificates%%"))
				document.location.href = "index.php?ToDo=viewCompanyGiftCertificates";
		}
		
		function hidediv()
		{	
			var rcount = document.getElementById("recipientcount").value;
			for(var i = 1; i <= rcount; i++)
			{
                if(document.getElementById("to_name_result_"+i))
				document.getElementById("to_name_result_"+i).style.visibility = "hidden";
			}
		}
		
		function CustomNameClick(index, name, email)
		{
			document.getElementById("to_name_"+index).value = name;
			document.getElementById("to_email_"+index).value = email;
		}
		
		function getCustomerNameandEmail(id, index, name)
		{	
			$.ajax({
				type: "GET",
				url: "%%GLOBAL_ShopPath%%/admin/remote.php?w=GetCustomerNameandEmail&name="+name+"&index="+index,
				success: function(msg){
					if( msg != '' )
					{
						document.getElementById(id).innerHTML = "<ul>"+msg+"</ul>";
						document.getElementById(id).style.visibility = "visible";
					}
					else
					{
						document.getElementById(id).innerHTML = "";
						document.getElementById(id).style.visibility = "hidden";
					}			
				}
			});
		}
		
		function addMoreRecipient()
		{
			var recipient = document.getElementById("recipient");
			var rcount = document.getElementById("recipientcount");
			var str ="";
			for(var i = 0; i < parseInt(rcount.value); i++ )
			{
				if( str != '' )
					str += '<br />';
                if(document.getElementById("to_email_" + (i+1))){
                    tmpstr = document.getElementById("to_email_" + (i+1)).value;
                }else{
                    tmpstr = "";
                }
                if(document.getElementById("to_name_" + (i+1))){
                    tmpstr2 = document.getElementById("to_name_" + (i+1)).value;
                }else{
                    tmpstr2 = "";
                }
				str += "<p id=\"recipient_" + (i+1) +"\">Name:<input type=\"text\" class=\"Textbox Field200\" value=\""+ tmpstr2 +"\" id=\"to_name_"+(i+1)+"\" name=\"to_name_"+(i+1)+"\" onkeyup=\"getCustomerNameandEmail('to_name_result_"+(i+1)+"', "+ (i+1) +", this.value)\" >&nbsp;&nbsp;Email:<input type=\"text\" class=\"Textbox Field200\" value=\""+ tmpstr +"\" id=\"to_email_"+(i+1)+"\" name=\"to_email_"+(i+1)+"\">";
                if(i != 0){
                    str += '<a href="#" onclick="deleteRecipient(' + (i+1) + ');return false;">delete</a>';
                }else{
                    str += '<a href="#" onclick="$('+"'"+'#to_name_1'+"'"+').val('+"''"+');$('+"'"+'#to_email_1'+"'"+').val('+"''"+');return false;">clear</a>';
                }
				str += "<div id=\"to_name_result_" + (i+1) +"\" name=\"to_name_result_1" + (i+1) +"\" class=\"ProductSearchResults  returnname\" ></div></p>";
			}
			
			rcount.value = parseInt(rcount.value) + 1;
            // Modified by NI_20100901_Jack
            recipient.innerHTML += "<p id=\"recipient_" + rcount.value +"\">Name:<input type=\"text\" class=\"Textbox Field200\" value=\"\" id=\"to_name_"+rcount.value+"\" name=\"to_name_"+rcount.value+"\" onkeyup=\"getCustomerNameandEmail('to_name_result_"+(rcount.value)+"', "+ (rcount.value) +", this.value)\" >&nbsp;&nbsp;Email:<input type=\"text\" class=\"Textbox Field200\" value=\"\" id=\"to_email_"+rcount.value+"\" name=\"to_email_"+rcount.value+"\">"
                                    + '<a href="#" onclick="deleteRecipient(' + rcount.value +');return false;">delete</a>'
									+"<div id=\"to_name_result_"+rcount.value+"\" name=\"to_name_result_"+rcount.value+"\" class=\"ProductSearchResults  returnname\" ></div></p>";
//			recipient.innerHTML = str+"<br /><p id=\"recipient_" + rcount.value +"\">Name:<input type=\"text\" class=\"Textbox Field200\" value=\"\" id=\"to_name_"+rcount.value+"\" name=\"to_name_"+rcount.value+"\" onkeyup=\"getCustomerNameandEmail('to_name_result_"+(rcount.value)+"', "+ (rcount.value) +", this.value)\" >&nbsp;&nbsp;Email:<input type=\"text\" class=\"Textbox Field200\" value=\"\" id=\"to_email_"+rcount.value+"\" name=\"to_email_"+rcount.value+"\">"
//                                    + '<a href="#" onclick="deleteRecipient(' + rcount.value +');return false;">delete</a>'
//									+"<div id=\"to_name_result_"+rcount.value+"\" name=\"to_name_result_"+rcount.value+"\" class=\"ProductSearchResults  returnname\" ></div></p>";
		}
        function deleteRecipient(id){
            $("#recipient_" + id).remove();
            var rcount = document.getElementById("recipientcount");
            rcount.value = parseInt(rcount.value) - 1;
        }
		function CheckCouponForm()
		{
			var cgcname = document.getElementById("cgcname");
			var usedforcatdiv = document.getElementById("usedforcatdiv");
			var usedforproddiv = document.getElementById("usedforproddiv");
			var catids = document.getElementById("catids");
			var prodids = document.getElementById("prodids");
			var da = document.getElementById("cgcamount");
			var ba = document.getElementById("cgcbalance");
			var mp = document.getElementById("cgcminpurchase");
			var dc1 = document.getElementById("dc1");
			var ce = document.getElementById("cgcexpires");
			

			ce.value = dc1.value;

			if($('#cgccode').val() == '') {
				alert('%%LNG_EnterCompanyGiftCertificatesCode%%');
				$('#cgccode').focus();
				return false;
			}

			if(cgcname.value.match(/^\s*$/) != null) {
				alert("%%LNG_EnterCompanyGiftCertificatesName%%");
                cgcname.value = "";
				cgcname.focus();
				return false;
			}

            var daint = da.value.replace(',','');
			if(isNaN(parseInt(daint)) || parseInt(daint) < %%GLOBAL_GiftCertificateMinimum%% || parseInt(daint) > %%GLOBAL_GiftCertificateMaximum%%)
			{
				alert("%%LNG_EnterCompanyGiftCertificatesValidAmount%%");
				da.focus();
				da.select();
				return false;
			}
			if(isNaN(parseInt(ba.value)) || parseInt(ba.value) < 0 || parseInt(ba.value) > parseInt(daint))
			{
				alert("%%LNG_EnterCompanyGiftCertificatesValidBalance%%");
				ba.focus();
				ba.select();
				return false;
			}

			if(usedforcatdiv.style.display == "") {
				if(catids.selectedIndex == -1) {
					alert("%%LNG_ChooseCompanyGiftCertificatesCategory%%");
					catids.focus();
					return false;
				}
			}

			if(usedforproddiv.style.display == "") {
				if(prodids.value == "") {
					alert("%%LNG_EnterCompanyGiftCertificatesProductId%%");
					prodids.focus();
					return false;
				}
			}

			m = mp.value.replace("%%GLOBAL_CurrencyToken%%", "");

			if(isNaN(m) && m != "")
			{
				alert("%%LNG_EnterCompanyGiftCertificatesValidMinPrice%%");
				mp.focus();
				mp.select();
				return false;
			}
			// Add by NI_20100901_Jack
            if($(".themeCheck:radio:checked").length ==0){
                alert("%%LNG_EnterCompanyGiftCertificatesValidThemeCheck%%");
				return false;
			}

			// Everything is OK
			return true;
		}

		function ToggleUsedFor(Which) {
			var usedforcatdiv = document.getElementById("usedforcatdiv");
			var usedforproddiv = document.getElementById("usedforproddiv");
			var usedforcat = document.getElementById("usedforcat");
			var usedforprod = document.getElementById("usedforprod");

			if(Which == 0) {
				usedforcat.checked = true;
				usedforcatdiv.style.display = "";
				usedforproddiv.style.display = "none";
			}
			else {
				usedforprod.checkled = true;
				usedforcatdiv.style.display = "none";
				usedforproddiv.style.display = "";
			}
		}

		function UpdateMessageRemaining(event) { 
			var remaining = 200 - $('#message').val().length; 
			if(remaining >= 0) { 
				$('#remaining').html(remaining); 
			} 
			else { 
				remaining = 0;
				$('#remaining').html(remaining); 
				if(typeof(event) != "undefined") { 
					if(event.keyCode != 8) { 
						event.preventDefault(); 
						return false; 
					} 
				} 
			} 
		}

		function limitText(limitField) {
			fldValue = limitField.value;
			var limitNum = 200;
			var chars = limitNum - fldValue.length;
			//alert (chars); // delete after testing
			if (chars <= 0) {
				UpdateMessageRemaining();
				alert ("You are trying to enter more than the limit of " + limitNum + " characters! ");
				fldValue = fldValue.substring(0,limitNum-1)
				document.myform.limitedtextarea.value = fldValue;
			}

			UpdateMessageRemaining();
		}

		window.onload=function(){
			UpdateMessageRemaining();
			document.onclick = hidediv;
		}
					
		%%GLOBAL_ToggleUsedFor%%

	</script>
