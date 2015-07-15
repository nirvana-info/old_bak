
	<form action="index.php?ToDo=saveUpdatedCheckoutSettings" name="frmCheckoutSettings" id="frmCheckoutSettings" method="post" onsubmit="return ValidateForm(CheckCheckoutSettingsForm)">
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_CheckoutSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_CheckoutSettingsIntro%%</p>
				<div id="CheckoutStatus">
					%%GLOBAL_Message%%
				</div>
				<p>
					<input type="submit" value="%%LNG_Save%%" class="FormButton" />
					<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<ul id="tabnav">
					<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_GeneralSettings%%</a></li>
					%%GLOBAL_CheckoutTabs%%
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<input id="currentTab" name="currentTab" value="0" type="hidden">
				<div id="div0" style="padding-top: 10px;">
					<table width="100%" class="Panel">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_CheckoutSettings%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<label for="storename">%%LNG_CheckoutMethods%%:</label>
							</td>
							<td>
								<select size="20" multiple="multiple" name="checkoutproviders[]" id="checkoutproviders" class="Field300 ISSelectReplacement">
									%%GLOBAL_CheckoutProviders%%
								</select>
								<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_CheckoutMethods%%', '%%LNG_CheckoutMethodsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d1"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">%%LNG_CheckoutType%%:</td>
							<td>
								<select name="CheckoutType" class="Field300">
									<option value="single" %%GLOBAL_CheckoutTypeSingleSelected%%>%%LNG_CheckoutTypeSingle%%</option>
									<option value="multipage" %%GLOBAL_CheckoutTypeMultiSelected%%>%%LNG_CheckoutTypeMulti%%</option>
								</select>
								<img onmouseout="HideHelp('chktype');" onmouseover="ShowHelp('chktype', '%%LNG_CheckoutType%%', '%%LNG_CheckoutTypeHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="chktype"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">%%LNG_EnableGuestCheckout%%?</td>
							<td>
								<label><input type="checkbox" name="GuestCheckoutEnabled" value="1" onclick="$('.GuestCheckoutEnabledToggle').toggle();" %%GLOBAL_GuestCheckoutChecked%% /> %%LNG_YesEnableGuestCheckout%%</label>
								<img onmouseout="HideHelp('guestcheckout');" onmouseover="ShowHelp('guestcheckout', '%%LNG_EnableGuestCheckout%%?', '%%LNG_EnableGuestCheckoutHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="guestcheckout"></div>
								<div style="%%GLOBAL_HideGuestCheckoutCreateAccounts%%" class="GuestCheckoutEnabledToggle">
									<img src="images/nodejoin.gif" alt="" />
									<label><input type="checkbox" name="GuestCheckoutCreateAccounts" value="1" %%GLOBAL_GuestCheckoutCreateAccountsCheck%% /> %%LNG_YesAutoCreateGuestAccounts%%</label>
									<img onmouseout="HideHelp('guestcheckout2');" onmouseover="ShowHelp('guestcheckout2', '%%LNG_AutoCreateGuestAccounts%%?', '%%LNG_AutoCreateGuestAccountsHelp%%')" src="images/help.gif" width="24" height="16" border="0">
									<div style="display:none" id="guestcheckout2"></div>
								</div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<label for="EnableOrderComments">%%LNG_EnableOrderComments%%?</label>
							</td>
							<td>
								<input type="checkbox" name="EnableOrderComments" id="EnableOrderComments" value="1" %%GLOBAL_IsEnableOrderComments%% /> <label for="EnableOrderComments">%%LNG_YesEnableOrderComments%%</label>
								<img onmouseout="HideHelp('OrderCommentsHelp');" onmouseover="ShowHelp('OrderCommentsHelp', '%%LNG_EnableOrderComments%%?', '%%LNG_EnableOrderCommentsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="OrderCommentsHelp"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<label for="EnableOrderComments">%%LNG_EnableOrderTermsAndConditions%%?</label>
							</td>
							<td>
								<input onclick="$('.OrderTermsAndConditions').toggle();" type="checkbox" name="EnableOrderTermsAndConditions" id="EnableOrderTermsAndConditions" value="1" %%GLOBAL_IsEnableOrderTermsAndConditions%% /> <label for="EnableOrderTermsAndConditions">%%LNG_YesEnableOrderTermsAndConditions%%</label>
								<img onmouseout="HideHelp('EnableOrderTermsAndConditionsHelp');" onmouseover="ShowHelp('EnableOrderTermsAndConditionsHelp', '%%LNG_EnableOrderTermsAndConditions%%?', '%%LNG_EnableOrderTermsAndConditionsHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="EnableOrderTermsAndConditionsHelp"></div>
								<div style="%%GLOBAL_HideOrderTermsAndConditions%%" class="OrderTermsAndConditions">
									<table>
										<tr>
											<td valign="top"><img src="images/nodejoin.gif" alt="" /></td>
											<td>


												<input onclick="ToggleTermsAndConditions('link');" type="radio" name="OrderTermsAndConditionsType" id="TNCLink" class="OrderTermsAndConditionsType" value="link"  %%GLOBAL_IsEnableOrderTermsAndConditionsLink%% />
												<label for="TNCLink">%%LNG_LinkToMyTermsAndConditions%%:</label>
												<img onmouseout="HideHelp('OrderTermsAndConditionsLinkHelp');" onmouseover="ShowHelp('OrderTermsAndConditionsLinkHelp', '%%LNG_OrderTermsAndConditionsLink%%?', '%%LNG_OrderTermsAndConditionsLinkHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
												<div style="display:none" id="OrderTermsAndConditionsLinkHelp"></div>
												<br />
												<input style="margin-left:25px; %%GLOBAL_HideOrderTermsAndConditionsLink%%" class="Field250 OrderTermsAndConditionsLink" name="OrderTermsAndConditionsLink" value="%%GLOBAL_OrderTermsAndConditionsLink%%">

											</td>
										</tr>
										<tr>
											<td valign="top"><img src="images/nodejoin.gif" alt="" /></td>
											<td>

												<input onclick="ToggleTermsAndConditions('textarea');" type="radio" name="OrderTermsAndConditionsType" id="TNCText" class="OrderTermsAndConditionsType" value="textarea"  %%GLOBAL_IsEnableOrderTermsAndConditionsTextarea%% />
												<label for="TNCText">%%LNG_LetMeTypeTermsAndConditions%%:</label>
												<img onmouseout="HideHelp('OrderTermsAndConditionsTextareaHelp');" onmouseover="ShowHelp('OrderTermsAndConditionsTextareaHelp', '%%LNG_OrderTermsAndConditionsText%%?', '%%LNG_OrderTermsAndConditionsTextareaHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
												<div style="display:none" id="OrderTermsAndConditionsTextareaHelp"></div>
												<br />
												<textarea  style="margin-left:25px; %%GLOBAL_HideOrderTermsAndConditionsTextarea%%"  class="Field250 OrderTermsAndConditionsTextarea"  name="OrderTermsAndConditionsTextarea" rows="5">%%GLOBAL_OrderTermsAndConditions%%</textarea>

											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
						<tr style="%%GLOBAL_HideMultiShipping%%">
							<td class="FieldLabel">
								<label for="MultipleShippingAddresses">%%LNG_EnableMultipleShippingAddresses%%:</label>
							</td>
							<td class="PanelBottom">
								<input type="checkbox" name="MultipleShippingAddresses" id="MultipleShippingAddresses" value="1" %%GLOBAL_IsMultipleShippingAddressesEnabled%% /> <label for="MultipleShippingAddresses">%%LNG_YesEnableMultipleShippingAddresses%%</label>
								<img onmouseout="HideHelp('MultipleShippingAddressesHelp');" onmouseover="ShowHelp('MultipleShippingAddressesHelp', '%%LNG_EnableMultipleShippingAddresses%%?', '%%LNG_EnableMultipleShippingAddressesHelp%%')" src="images/help.gif" width="24" height="16" border="0" />
								<div style="display:none" id="MultipleShippingAddressesHelp"></div>
							</td>
						</tr>
					</table>
					<table width="100%" class="Panel">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_OrderSettings%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<label for="updateinventory">%%LNG_UpdateProductInventoryWhen%%:</label>
							</td>
							<td class="PanelBottom">
								<select name="updateinventory" id="updateinventory" class="Field300">
									<option value="1" %%GLOBAL_UpdateInventorySuccessfulSelected%%>%%LNG_UpdateInventorySuccessfulOrder%%</option>
									<option value="2" %%GLOBAL_UpdateInventoryCompletedSelected%%>%%LNG_UpdateInventoryOrderCompleted%%</option>
								</select>
								<img onmouseout="HideHelp('ad1');" onmouseover="ShowHelp('ad1', '%%LNG_UpdateProductInventoryWhen%%', '%%LNG_UpdateProductInventoryWhenHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="ad1"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<label for="orderstatusemails">%%LNG_EmailOnOrderStatusChange%%:</label>
							</td>
							<td class="PanelBottom">
								<select name="orderstatusemails[]" id="orderstatusemails" class="Field300 ISSelectReplacement" size="11" multiple="multiple">
									%%GLOBAL_OrderStatusEmailList%%
								</select>
								<img onmouseout="HideHelp('ad2');" onmouseover="ShowHelp('ad2', '%%LNG_EmailOnOrderStatusChange%%', '%%LNG_EmailOnOrderStatusChangeHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="ad2"></div>
							</td>
						</tr>
					</table>
					<table width="100%" class="Panel">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_DigitalProductSettings%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<label for="orderstatusemails">%%LNG_EnableDigitalHandlingFee%%?</label>
							</td>
							<td class="PanelBottom">
								<label><input type="checkbox" onclick="$('.DigitalOrderHandling').toggle();" id="EnableDigitalOrderHandlingFee" name="EnableDigitalOrderHandlingFee" %%GLOBAL_DigitalOrderHandlingFeeChecked%% /> %%LNG_YesEnableDigitalHandlingFee%%</label>
								<img onmouseout="HideHelp('digitalhandling');" onmouseover="ShowHelp('digitalhandling', '%%LNG_EnableDigitalHandlingFee%%?', '%%LNG_EnableDigitalHandlingFeeHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display: none" id="digitalhandling"></div>
								<div style="%%GLOBAL_HideDigitalOrderHandlingFee%%" class="DigitalOrderHandling">
									<table>
										<tr>
											<td><img src="images/nodejoin.gif" alt="" /></td>
											<td>
												Handling Fee:
												%%GLOBAL_LeftCurrencyToken%%
												<input type="text" name="DigitalOrderHandlingFee" id="DigitalOrderHandlingFee" class="Field50" value="%%GLOBAL_DigitalOrderHandlingFee%%" />
												%%GLOBAL_RightCurrencyToken%%
											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
					</table>
				</div>
				%%GLOBAL_CheckoutDivs%%
				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain" id="BottomButtons">
					<tr>
						<td width="200" class="FieldLabel">
							&nbsp;
						</td>
						<td>
							<input class="FormButton" type="submit" value="%%LNG_Save%%">
							<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		</table>
		</div>
	</form>

	<div id="ViewsMenu" class="DropShadow DropDownMenu" style="display: none; width:200px">
		<ul>
			%%GLOBAL_CheckoutFieldsOptions%%
		</ul>
	</div>

	<script type="text/javascript">

		function ToggleTermsAndConditions(type)
		{
			if(type == 'link') {
				$('.OrderTermsAndConditionsLink').css({display: ''});
				$('.OrderTermsAndConditionsTextarea').css({display: 'none'});
			} else {
				$('.OrderTermsAndConditionsTextarea').css({display: ''});
				$('.OrderTermsAndConditionsLink').css({display: 'none'});
			}
		}

		function checkout_selected(checkout_id) {
			if(g('checkoutproviders_old')) {
				var cp = g('checkoutproviders_old');
			}
			else {
				var cp = document.getElementById("checkoutproviders");
			}
			for(i = 0; i < cp.options.length; i++) {
				if(cp.options[i].value == checkout_id && cp.options[i].selected)
					return true;
			}

			return false;
		}

		function ShowTab(T)
		{
			i = 0;
			while (document.getElementById("tab" + i) != null) {
				document.getElementById("div" + i).style.display = "none";
				document.getElementById("tab" + i).className = "";
				i++;
			}

			document.getElementById("div" + T).style.display = "";
			document.getElementById("tab" + T).className = "active";
			document.getElementById("currentTab").value = T;
		}

		function CheckCheckoutSettingsForm()
		{
			if($('#EnableDigitalOrderHandlingFee').attr('checked')) {
				if($('#DigitalOrderHandlingFee').val() == '' || isNaN(priceFormat($('#DigitalOrderHandlingFee').val()))) {
					alert('%%LNG_EnterDigitalOrderHandlingFee%%');
					$('#DigitalOrderHandlingFee').select();
					return false;
				}
			}

			if($('#EnableOrderTermsAndConditions').attr('checked')) {
				if($('.OrderTermsAndConditionsType:checked').val() == 'link') {
					if($('.OrderTermsAndConditionsLink').val() == '' || $('.OrderTermsAndConditionsLink').val() == 'http://') {
						alert("%%LNG_EnterTermsAndConditionsLink%%");
						return false;
					}
				} else if($('.OrderTermsAndConditionsType:checked').val() == 'textarea') {
					if($('.OrderTermsAndConditionsTextarea').val() == '') {
						alert("%%LNG_EnterTermsAndConditions%%");
						return false;
					}
				} else {
					alert("%%LNG_SelectTermsAndConditionsType%%");
					return false;
				}
			}

			%%GLOBAL_CheckoutJavaScript%%
		}

		function ConfirmCancel() {
			if(confirm('%%LNG_CancelCheckoutMessage%%')) {
				document.location.href='index.php?ToDo=viewCheckoutSettings';
			}
			else {
				return false;
			}
		}

		$(document).ready(
			function()
			{
				ShowTab(%%GLOBAL_CurrentTab%%);
			}
		);

	</script>



