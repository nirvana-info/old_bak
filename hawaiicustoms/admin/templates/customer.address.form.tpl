<script type="text/javascript" src="../javascript/formfield.js"></script>
<form action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(checkAddCustomerAddressForm)" id="frmCustomerAddress" method="post">
<input type="hidden" name="addressId" id="addressId" value="%%GLOBAL_AddressId%%">
<input type="hidden" name="customerId" id="customerId" value="%%GLOBAL_CustomerId%%">
<input type="hidden" name="newCustomer" id="newCustomer" value="%%GLOBAL_NewCustomer%%">
<input type="hidden" name="customFieldsAddressFormId" id="customFieldsAddressFormId" value="%%GLOBAL_CustomFieldsAddressFormId%%">
<input id="currentTab" name="currentTab" value="0" type="hidden">
<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
	<tr>
		<td class="Heading1">%%GLOBAL_Title%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%GLOBAL_Intro%%</p>
			%%GLOBAL_Message%%
			<p>
				<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" name="SaveButton1" />
				<input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="SaveAddAnotherButton1" onclick="saveAndAddAnother();" class="FormButton Field150" />
				<input type="reset" value="%%LNG_Cancel%%" class="FormButton" name="CancelButton1" onclick="confirmCancel()" />
			</p>
		</td>
	</tr>
	<tr>
		<td>
			<ul id="tabnav">
				<li><a href="#" id="tab0" onclick="ShowTab(0)" class="active">%%LNG_CustomerAddressDetails%%</a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<div id="div0" style="padding-top: 10px;">
				<div style="padding-bottom:5px">%%LNG_CustomerAddressDetailsIntro%%</div>
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_CustomerAddressDetails%%</td>
					</tr>
					<tr>
						<td>
							<table width="100%">
							<tr>
								<td style="width: 50%; vertical-align:top; padding-right:10px;">
									<dl class="FormFieldBackend">
										%%GLOBAL_AddressFields%%
									</dl>
								</td>
								<td style="width: 50%; vertical-align:top;">
									<dl class="FormFieldBackend" style="display: %%GLOBAL_HideCustomFields%%;">
										%%GLOBAL_CustomFields%%
									</dl>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				</table>
			</div>
		</div>
		<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain" id="SaveButtons">
			<tr>
				<td>
					<input type="submit" value="%%LNG_SaveAndExit%%" name="SaveButton2" class="FormButton" />
					<input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="SaveAddAnotherButton2" onclick="saveAndAddAnother();" class="FormButton Field150" />
					<input type="reset" value="%%LNG_Cancel%%" name="CancelButton2" class="FormButton" onclick="confirmCancel()" />
				</td>
			</tr>
		</table>
		</td>
	</tr>
	</table>
</div>
</form>

<script type="text/javascript"><!--

	function saveAndAddAnother() {
		MakeHidden('addanother', '1', 'frmCustomerAddress');
	}

	function confirmCancel() {
		if(confirm('%%GLOBAL_CancelMessage%%')) {
			if ("%%GLOBAL_CancelGoToManager%%" == "1") {
				document.getElementById('frmCustomerAddress').action = 'index.php?ToDo=viewCustomers';
			} else {
				document.getElementById('frmCustomerAddress').action = 'index.php?ToDo=editCustomer&customerId=%%GLOBAL_CustomerId%%';
				MakeHidden('currentTab', '1', 'frmCustomerAddress');
			}

			document.getElementById('frmCustomerAddress').submit();
			return false;
		} else {
			return false;
		}
	}

	function checkAddCustomerAddressForm()
	{
		var formfields = FormField.GetValues(%%GLOBAL_CustomFieldsAddressFormId%%);

		for (var i=0; i<formfields.length; i++) {
			var rtn = FormField.Validate(formfields[i].field);

			if (!rtn.status) {
				alert(rtn.msg);
				FormField.Focus(formfields[i].field);
				return false;
			}
		}

		return true;
	}

	%%GLOBAL_FormFieldEventData%%

//--></script>