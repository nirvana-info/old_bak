
	<form action="index.php?ToDo=saveUpdatedMailSettings" name="frmMailSettings" id="frmMailSettings" method="post">
	<input id="currentTab" name="currentTab" value="0" type="hidden">
	<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_MailSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<div class="IntroItem">%%GLOBAL_MailSettingsIntro%%</div>
				%%GLOBAL_Message%%
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" value="%%LNG_Save%%" class="FormButton" />
				<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				<br /><br />
			</td>
		</tr>
		<tr>
			<td>
				<ul id="tabnav">
					<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_MailSettings%%</a></li>
					<li><a href="#" id="tab1" onclick="ShowTab(1)">%%LNG_MailIntegration%%</a></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<div id="div0" style="padding-top: 10px;">
					<table class="Panel">
						<tr>
						  <td class="Heading2" colspan=2>%%LNG_APIDetails%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">&nbsp;</td>
							<td><img src="%%GLOBAL_MailLogo%%" alt="" /></td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_MailXMLPath%%:
							</td>
							<td>
								<input type="text" name="MailXMLPath" id="MailXMLPath" class="Field200" value="%%GLOBAL_MailXMLPath%%">
								<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_MailXMLPath%%', '%%LNG_MailXMLPathHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d1"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_MailUsername%%:
							</td>
							<td>
								<input type="text" name="MailUsername" id="MailUsername" class="Field200" value="%%GLOBAL_MailUsername%%">
								<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_MailUsername%%', '%%LNG_MailUsernameHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d3"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_MailXMLToken%%:
							</td>
							<td>
								<input type="text" name="MailXMLToken" id="MailXMLToken" class="Field200" value="%%GLOBAL_MailXMLToken%%">
								<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_MailXMLToken%%', '%%LNG_MailXMLTokenHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d2"></div>
							</td>
						</tr>
					</table>
				</div>
				<div id="div1" style="padding-top: 10px; display:none">
					<table class="Panel">
						<tr>
						  <td class="Heading2" colspan=2>%%LNG_NewsletterOptions%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_CaptureNewsletterSubscribers%%?
							</td>
							<td>
								<input type="checkbox" name="UseMailAPIForNewsletters" id="UseMailAPIForNewsletters" value="ON"> <label for="UseMailAPIForNewsletters">%%LNG_YesCaptureNewsletterSubscribers%%</label>
								<img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_CaptureNewsletterSubscribers%%?', '%%LNG_CaptureNewsletterSubscribersHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d4"></div>
								<table id="sectionNewsletter" style="display:block; padding-top:5px" border="0" cellspacing="0" cellpadding="2" class="panel">

									<tr>
										<td width="20" valign="top"><img src="images/nodejoin.gif" width="20" height="20"></td>
										<td>
											<div style="padding:10px 0px 3px 0px"><span class="Required">*</span>&nbsp;%%LNG_AddToMailingList%%:</div>
											&nbsp;&nbsp;
											<select name="MailNewsletterList" id="MailNewsletterList" class="Field250">
												<option value="">-- %%LNG_ChooseAMailingList%% --</option>
												%%GLOBAL_NewsletterMailingLists%%
											</select>
											<div style="display:none; padding:0px 0px 10px 10px; color:gray" id="NoMailingList1"><em>%%LNG_CreateMailingListFirst%%</em></div>
										</td>
									</tr>
									<tr id="FirstNameCustomField">

										<td width="20">&nbsp;</td>
										<td>
											<div style="padding:10px 0px 3px 0px">&nbsp;&nbsp;&nbsp;%%LNG_MailCustomField%%:</div>
											<select style="margin: 0px 10px 10px" name="MailNewsletterCustomField" id="MailNewsletterCustomField" class="field250">
											</select>
											<div style="display:none; padding:0px 0px 10px 10px; color:gray" id="NoCustomFields1"><em>%%LNG_NoMailingListCustomFields%%</em></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table class="Panel">
						<tr>
						  <td class="Heading2" colspan=2>%%LNG_NewsletterOrderOptions%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_CaptureNewsletterOrders%%?
							</td>
							<td>
								<input type="checkbox" name="UseMailAPIForOrders" id="UseMailAPIForOrders" value="ON"> <label for="UseMailAPIForOrders">%%LNG_YesCaptureNewCustomers%%</label>
								<img onmouseout="HideHelp('d5');" onmouseover="ShowHelp('d5', '%%LNG_CaptureNewsletterOrders%%?', '%%LNG_CaptureNewsletterOrdersHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="d5"></div>
								<table id="sectionOrder" style="display:block" border="0" cellspacing="0" cellpadding="2" class="panel">

									<tr>
										<td width="20" valign="top"><img src="images/nodejoin.gif" width="20" height="20"></td>
										<td>
											<div style="padding:10px 0px 3px 0px"><span class="Required">*</span>&nbsp;%%LNG_AddCustomersToMailingList%%:</div>
											&nbsp;&nbsp;
											<select name="MailOrderList" id="MailOrderList" class="Field250">
												<option value="">-- %%LNG_ChooseAMailingList%% --</option>
												%%GLOBAL_NewsletterMailingLists%%
											</select>
											<div style="display:none; padding:0px 0px 10px 10px; color:gray" id="NoMailingList2"><em>%%LNG_CreateMailingListFirst%%</em></div>
											<div style="padding:10px 0px 3px 0px">
												<label><input %%GLOBAL_MailOrderListAutoSubscribeChecked%% type="checkbox" name="MailOrderListAutoSubscribe" id="MailOrderListAutoSubscribe"  value="1" /> %%LNG_YesAutoSubscribeOrdersList%%</label>
												<img onmouseout="HideHelp('choicehelp');" onmouseover="ShowHelp('choicehelp', '%%LNG_AutoSubscribeOrdersList%%', '%%LNG_AutoSubscribeOrdersListHelp%%')" src="images/help.gif" width="24" height="16" border="0">
												<div style="display:none" id="choicehelp"></div>
											</div>
											<div style="display:none; padding:10px; color:gray" id="NoCustomFields2"><em>%%LNG_NoMailingListCustomFields1%%</em></div>
										</td>
									</tr>
									<tr class="Hide">
										<td width="20">&nbsp;</td>
										<td>
											<table border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="320">
														&nbsp;&nbsp;&nbsp; %%LNG_OrderCustomFieldFirstName%%:
													</td>
													<td>
														<select style="margin: 0px 10px 0px" name="MailOrderFirstName" id="MailOrderFirstName" class="Field250">
														</select>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr class="Hide">
										<td width="20">&nbsp;</td>
										<td>
											<table border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="320">
														&nbsp;&nbsp;&nbsp; %%LNG_OrderCustomFieldLastName%%:
													</td>
													<td>
														<select style="margin: 0px 10px 0px" name="MailOrderLastName" id="MailOrderLastName" class="Field250">
														</select>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr class="Hide">
										<td width="20">&nbsp;</td>
										<td>
											<table border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="320">
														&nbsp;&nbsp;&nbsp; %%LNG_OrderCustomFieldFullName%%:
													</td>
													<td>
														<select style="margin: 0px 10px 0px" name="MailOrderFullName" id="MailOrderFullName" class="Field250">
														</select>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr class="Hide">
										<td width="20">&nbsp;</td>
										<td>
											<table border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="320">
														&nbsp;&nbsp;&nbsp; %%LNG_OrderCustomFieldZip%%:
													</td>
													<td>
														<select style="margin: 0px 10px 0px" name="MailOrderZip" id="MailOrderZip" class="Field250">
														</select>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr class="Hide">
										<td width="20">&nbsp;</td>
										<td>
											<table border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="320">
														&nbsp;&nbsp;&nbsp; %%LNG_OrderCustomFieldCountry%%:
													</td>
													<td>
														<select style="margin: 0px 10px 0px" name="MailOrderCountry" id="MailOrderCountry" class="Field250">
														</select>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr class="Hide">
										<td width="20">&nbsp;</td>
										<td>
											<table border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="320">
														&nbsp;&nbsp;&nbsp; %%LNG_OrderCustomFieldTotal%%:
													</td>
													<td>
														<select style="margin: 0px 10px 0px" name="MailOrderTotal" id="MailOrderTotal" class="Field250">
														</select>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr class="Hide">
										<td width="20">&nbsp;</td>
										<td>
											<table border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="320">
														&nbsp;&nbsp;&nbsp; %%LNG_OrderCustomFieldPaymentMethod%%:
													</td>
													<td>
														<select style="margin: 0px 10px 0px" name="MailOrderPaymentMethod" id="MailOrderPaymentMethod" class="Field250">
														</select>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr class="Hide">
										<td width="20">&nbsp;</td>
										<td>
											<table border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="320">
														&nbsp;&nbsp;&nbsp; %%LNG_OrderCustomFieldShippingMethod%%:
													</td>
													<td>
														<select style="margin: 0px 10px 0px" name="MailOrderShippingMethod" id="MailOrderShippingMethod" class="Field250">
														</select>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table class="Panel">
						<tr>
						  <td class="Heading2" colspan=2>%%LNG_NewsletterProductUpdateOptions%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_ShowProductUpdateOptions%%?
							</td>
							<td>
								<input type="checkbox" name="UseMailAPIForUpdates" id="UseMailAPIForUpdates" value="ON"> <label for="UseMailAPIForUpdates">%%LNG_YesShowProductUpdateOptions%%</label>
								<img onmouseout="HideHelp('dprodupdates');" onmouseover="ShowHelp('dprodupdates', '%%LNG_ShowProductUpdateOptions%%?', '%%LNG_ShowProductUpdateOptionssHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="dprodupdates"></div>
								<table id="sectionUpdates" style="display:block" border="0" cellspacing="0" cellpadding="2" class="panel">

									<tr>
										<td width="20" valign="top"><img src="images/nodejoin.gif" width="20" height="20"></td>
										<td>
											<div style="padding:10px 0px 3px 0px"><span class="Required">*</span>&nbsp;%%LNG_AddCustomersToAMailingListBasedOn%%:</div>
											&nbsp;&nbsp;<input type="radio" name="MailProductUpdatesListType" id="MailProductUpdatesListType1" value="PRODUCT_NAME" %%GLOBAL_ProductUpdatesByName%% /> <label for="MailProductUpdatesListType1">%%LNG_TheNameOfTheProduct%%</label>
											<img onmouseout="HideHelp('dprodupdatesbyname');" onmouseover="ShowHelp('dprodupdatesbyname', '%%LNG_TheNameOfTheProduct%%', '%%LNG_TheNameOfTheProductHelp%%')" src="images/help.gif" width="24" height="16" border="0">
											<div style="display:none" id="dprodupdatesbyname"></div>
											<br />
											&nbsp;&nbsp;<input type="radio" name="MailProductUpdatesListType" id="MailProductUpdatesListType2" value="PRODUCT_CATEGORY" %%GLOBAL_ProductUpdatesByCategory%% /> <label for="MailProductUpdatesListType2">%%LNG_TheCategoryOfTheProduct%%</label>
											<img onmouseout="HideHelp('dprodupdatesbycat');" onmouseover="ShowHelp('dprodupdatesbycat', '%%LNG_TheCategoryOfTheProduct%%', '%%LNG_TheCategoryOfTheProductHelp%%')" src="images/help.gif" width="24" height="16" border="0">
											<div style="display:none" id="dprodupdatesbycat"></div>
											<br />
											&nbsp;&nbsp;<input type="radio" name="MailProductUpdatesListType" id="MailProductUpdatesListType3" value="PRODUCT_BRAND" %%GLOBAL_ProductUpdatesByBrand%% /> <label for="MailProductUpdatesListType3">%%LNG_TheBrandOfTheProduct%%</label>
											<img onmouseout="HideHelp('dprodupdatesbybrand');" onmouseover="ShowHelp('dprodupdatesbybrand', '%%LNG_TheBrandOfTheProduct%%', '%%LNG_TheBrandOfTheProductHelp%%')" src="images/help.gif" width="24" height="16" border="0">
											<div style="display:none" id="dprodupdatesbybrand"></div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
				<table class="Panel">
					<tr>
						<td class="FieldLabel">&nbsp;</td>
						<td>
							<input type="submit" name="SubmitButton2" value="%%LNG_Save%%" class="FormButton">
							<input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
						</td>
					</tr>
					<tr><td class="Gap"></td></tr>
				 </table>
			</td>
		</tr>
	</table>
	</div>
</form>

<script type="text/javascript">

	function ConfirmCancel() {
		if(confirm('%%LNG_CancelMailMessage%%')) {
			document.location.href='index.php?ToDo=viewMailSettings';
		}
		else {
			return false;
		}
	}

	function ShowTab(T) {
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

	$('#UseMailAPIForNewsletters').click(function() {
		is_checked = $(this).attr('checked');

		if(is_checked) {
			$('#sectionNewsletter').show();
		}
		else {
			$('#sectionNewsletter').hide();
		}
	});

	$('#UseMailAPIForOrders').click(function() {
		is_checked = $(this).attr('checked');

		if(is_checked) {
			$('#sectionOrder').show();
		}
		else {
			$('#sectionOrder').hide();
		}
	});

	$('#UseMailAPIForUpdates').click(function() {
		is_checked = $(this).attr('checked');

		if(is_checked) {
			$('#sectionUpdates').show();
		}
		else {
			$('#sectionUpdates').hide();
		}
	});

	$(document).ready(function() {

		// Hide the custom fields list until they choose a mailing list
		$('#FirstNameCustomField').hide();

		// Hide the integration tab if the mailer isn't configured
		if("%%GLOBAL_ShowIntegrationTab%%" != "1") {
			$('#tab1').hide();
		}

		// Is the mailer being used for newsletters?
		if("%%GLOBAL_UseMailerForNewsletter%%" == "1") {
			$('#UseMailAPIForNewsletters').attr('checked', true);

			// Select the mailing list for newsletters
			for(i = 0; i < g('MailNewsletterList').options.length; i++) {
				if(g('MailNewsletterList').options[i].value == '%%GLOBAL_MailNewsletterList%%') {
					g('MailNewsletterList').selectedIndex = i;
					break;
				}
			}

			// Load the list of custom fields for this list
		$('#MailNewsletterCustomField').load('remote.php?w=textcustomfieldsformailinglist&list=%%GLOBAL_MailNewsletterList%%',
								null,
								function() {
									$('#FirstNameCustomField').show();

									if(g('MailNewsletterCustomField').options.length > 0) {
										$('#MailNewsletterCustomField').show();

										if('%%GLOBAL_MailNewsletterCustomField%%' != '0') {
											for(i = 0; i < g('MailNewsletterCustomField').options.length; i++) {
												if(g('MailNewsletterCustomField').options[i].value == '%%GLOBAL_MailNewsletterCustomField%%') {
													g('MailNewsletterCustomField').selectedIndex = i;
													break;
												}
											}
										}
										else {
											g('MailNewsletterCustomField').selectedIndex = 0;
										}
									}
									else {
										$('#MailNewsletterCustomField').hide();
										$('#NoCustomFields1').show();
									}
								}
			);
		}
		else {
			$('#sectionNewsletter').hide();
		}

		// Is the mailer being used for orders?
		if("%%GLOBAL_UseMailerForOrders%%" == "1") {
			$('#UseMailAPIForOrders').attr('checked', true);

			// Select the mailing list for orders
			if('%%GLOBAL_MailOrderList%%' > 0) {
				for(i = 0; i < g('MailOrderList').options.length; i++) {
					if(g('MailOrderList').options[i].value == '%%GLOBAL_MailOrderList%%') {
						g('MailOrderList').selectedIndex = i;
						break;
					}
				}

				jQuery.ajax({
					url: 'remote.php',
					type: 'POST',
					data: 'w=customfieldsformailinglist&list=%%GLOBAL_MailOrderList%%',
					success: function (data) {

						if(data != '') {
							$('#sectionOrder .Hide select').html(data);
							$('#sectionOrder .Hide').show();

							// Match

						}
						else {
							$('#sectionOrder .Hide select').html('');
							$('#sectionOrder .Hide').hide();
							$('#NoCustomFields2').show();
						}

						// Match the order attributes to the custom fields in the list
						if('%%GLOBAL_MailOrderFirstName%%' != '0') {
							for(i = 0; i < g('MailOrderFirstName').options.length; i++) {
								if(g('MailOrderFirstName').options[i].value == '%%GLOBAL_MailOrderFirstName%%') {
									g('MailOrderFirstName').selectedIndex = i;
									break;
								}
							}
						}

						if('%%GLOBAL_MailOrderLastName%%' != '0') {
							for(i = 0; i < g('MailOrderLastName').options.length; i++) {
								if(g('MailOrderLastName').options[i].value == '%%GLOBAL_MailOrderLastName%%') {
									g('MailOrderLastName').selectedIndex = i;
									break;
								}
							}
						}

						if('%%GLOBAL_MailOrderFullName%%' != '0') {
							for(i = 0; i < g('MailOrderFullName').options.length; i++) {
								if(g('MailOrderFullName').options[i].value == '%%GLOBAL_MailOrderFullName%%') {
									g('MailOrderFullName').selectedIndex = i;
									break;
								}
							}
						}

						if('%%GLOBAL_MailOrderZip%%' != '0') {
							for(i = 0; i < g('MailOrderZip').options.length; i++) {
								if(g('MailOrderZip').options[i].value == '%%GLOBAL_MailOrderZip%%') {
									g('MailOrderZip').selectedIndex = i;
									break;
								}
							}
						}

						if('%%GLOBAL_MailOrderCountry%%' != '0') {
							for(i = 0; i < g('MailOrderCountry').options.length; i++) {
								if(g('MailOrderCountry').options[i].value == '%%GLOBAL_MailOrderCountry%%') {
									g('MailOrderCountry').selectedIndex = i;
									break;
								}
							}
						}

						if('%%GLOBAL_MailOrderTotal%%' != '0') {
							for(i = 0; i < g('MailOrderTotal').options.length; i++) {
								if(g('MailOrderTotal').options[i].value == '%%GLOBAL_MailOrderTotal%%') {
									g('MailOrderTotal').selectedIndex = i;
									break;
								}
							}
						}

						if('%%GLOBAL_MailOrderPaymentMethod%%' != '0') {
							for(i = 0; i < g('MailOrderPaymentMethod').options.length; i++) {
								if(g('MailOrderPaymentMethod').options[i].value == '%%GLOBAL_MailOrderPaymentMethod%%') {
									g('MailOrderPaymentMethod').selectedIndex = i;
									break;
								}
							}
						}

						if('%%GLOBAL_MailOrderShippingMethod%%' != '0') {
							for(i = 0; i < g('MailOrderShippingMethod').options.length; i++) {
								if(g('MailOrderShippingMethod').options[i].value == '%%GLOBAL_MailOrderShippingMethod%%') {
									g('MailOrderShippingMethod').selectedIndex = i;
									break;
								}
							}
						}
					}
				});
			}

		}
		else {
			$('#sectionOrder').hide();
		}

		// If there aren't any mailing lists then we'll hide the dropdowns
		if("%%GLOBAL_HideLists%%" == "1") {
			$('#MailNewsletterList').hide();
			$('#MailOrderList').hide();
			$('#NoMailingList1').show();
			$('#NoMailingList2').show();
		}

		// Hide the custom field list for order preferences
		$('#sectionOrder .Hide').hide();

		// Is the mailer being used for product updates?
		if("%%GLOBAL_UseMailAPIForUpdates%%" == "1") {
			$('#UseMailAPIForUpdates').attr('checked', true);
		}
		else {
			$('#sectionUpdates').hide();
		}

		ShowTab(%%GLOBAL_CurrentTab%%);
	});

	$('#frmMailSettings').submit(function() {
		if($('#MailXMLPath').val() == '' && ($('#MailXMLToken').val() != '' || $('#MailUsername').val() != '')) {
			ShowTab(0);
			alert('%%LNG_EnterMailXMLPath%%');
			$('#MailXMLPath').focus();
			return false;
		}

		if($('#MailXMLToken').val() == '' && ($('#MailXMLPath').val() != '' || $('#MailUsername').val() != '')) {
			ShowTab(0);
			alert('%%LNG_EnterMailXMLToken%%');
			$('#MailXMLToken').focus();
			return false;
		}

		if($('#MailUsername').val() == '' && ($('#MailXMLPath').val() != '' || $('#MailXMLToken').val() != '')) {
			ShowTab(0);
			alert('%%LNG_EnterMailUsername%%');
			$('#MailUsername').focus();
			return false;
		}

		if("%%GLOBAL_ShowIntegrationTab%%" != "1") {
			return true;
		}

		if(g('UseMailAPIForNewsletters').checked && g('MailNewsletterList').selectedIndex == 0) {
			ShowTab(1);
			alert('%%LNG_MailChooseNewsletterList%%');
			g('MailNewsletterList').focus();
			return false;
		}

		if(g('UseMailAPIForOrders').checked && g('MailOrderList').selectedIndex == 0) {
			ShowTab(1);
			alert('%%LNG_MailChooseOrderList%%');
			g('MailOrderList').focus();
			return false;
		}

		if(g('MailOrderFirstName').options.length > 0) {
			// Make sure they aren't mapping multiple order attributes to a single custom field
			var order_fields = new Array('MailOrderFirstName', 'MailOrderLastName', 'MailOrderFullName', 'MailOrderZip', 'MailOrderCountry', 'MailOrderTotal', 'MailOrderPaymentMethod', 'MailOrderShippingMethod');

			for(i = 0; i < order_fields.length; i++) {
				val = g(order_fields[i]).selectedIndex;

				if(val > 0) {
					// They have mapped the order attribute to a custom field
					for(j = 0; j < order_fields.length; j++) {
						comp_val = g(order_fields[j]).selectedIndex;

						if(comp_val > 0 && j != i && val == comp_val) {
							alert('%%LNG_MailingListOrderAssign%%');
							g(order_fields[j]).focus();
							return false;
						}
					}
				}
			}

			return true;
		}

		return true;
	});

	$('#MailNewsletterList').change(function() {
		$('#NoCustomFields1').hide();

		if(this.selectedIndex > 0) {
			$('#MailNewsletterCustomField').load('remote.php?w=textcustomfieldsformailinglist&list='+this.options[this.selectedIndex].value,
								null,
								function() {
									$('#FirstNameCustomField').show();

									if(g('MailNewsletterCustomField').options.length > 0) {
										$('#MailNewsletterCustomField').show();
										g('MailNewsletterCustomField').selectedIndex = 0;
								}
									else {
										$('#MailNewsletterCustomField').hide();
										$('#NoCustomFields1').show();
									}
								}
			);
		}
		else {
			// Hide the custom field list
			$('#FirstNameCustomField').hide();
		}
	});

	$('#MailOrderList').change(function() {
		$('#NoCustomFields2').hide();

		if(this.selectedIndex > 0) {
			jQuery.ajax({
				url: 'remote.php',
				type: 'POST',
				data: 'w=customfieldsformailinglist&list='+this.options[this.selectedIndex].value,
				success: function (data) {
					if(data != '') {
						$('#sectionOrder .Hide select').html(data);
						$('#sectionOrder .Hide').show();
					}
					else {
						$('#sectionOrder .Hide select').html('');
						$('#sectionOrder .Hide').hide();
						$('#NoCustomFields2').show();
					}
				}
			});
		}
		else {
			// Hide the custom field list for order preferences
			$('#sectionOrder .Hide').hide();
		}
	});
</script>
