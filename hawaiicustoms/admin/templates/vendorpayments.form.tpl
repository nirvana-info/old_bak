<form action="index.php?ToDo=saveNewVendorPayment" id="paymentForm" method="post" onsubmit="return ValidateForm(CheckPaymentForm)">
	<div class="BodyContainer">
		<table class="OuterPanel">
	        <tr>
	        	<td class="Heading1">%%LNG_AddVendorPayment%%</td>
	        </tr>

	        <tr>
	        	<td class="Intro">
	        		<p>%%LNG_AddVendorPaymentIntro%%</p>
	        		%%GLOBAL_Message%%
	        		<p>
	        			<input type="submit" name="SaveButton1" value="%%LNG_Save%%" class="FormButton" />&nbsp;
	        			<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
	        		</p>
	        	</td>
	        </tr>

	        <tr>
	        	<td>
	        		<div id="div0">
	        			<table width="100%" class="Panel">
	        				<tr>
	        					<td class="Heading2" colspan="2">%%LNG_VendorDetails%%</td>
	        				</tr>

	        				<tr>
	        					<td class="FieldLabel">
	        						<span class="Required">*</span> %%LNG_Vendor%%:
	        					</td>
	        					<td>
	        						<select name="paymentvendorid" id="paymentvendorid" class="Field300" onchange="ToggleVendor($(this).val())">
	        							<option value="">%%LNG_ChooseAVendor%%</option>
	        							%%GLOBAL_VendorList%%
	        						</select>
									<img onmouseout="HideHelp('vendorhelp');" onmouseover="ShowHelp('vendorhelp', '%%LNG_Vendor%%', '%%LNG_VendorPaymentHelp%%')" src="images/help.gif" border="0" />
									<div style="display:none" id="vendorhelp"></div>
	        					</td>
	        				</tr>

	        				<tr class="HideWhenNoVendor" style="display: none">
	        					<td class="FieldLabel">
	        						<span class="Required">&nbsp;</span> %%LNG_DateRange%%:
	        					</td>
	        					<td>
									<span id="VendorDateRange"></span>
									<img onmouseout="HideHelp('daterangehelp');" onmouseover="ShowHelp('daterangehelp', '%%LNG_DateRange%%', '%%LNG_DateRangeHelp%%')" src="images/help.gif" border="0" />
									<div style="display:none" id="daterangehelp"></div>
	        					</td>
	        				</tr>

	        				<tr class="HideWhenNoVendor" style="display: none">
	        					<td class="FieldLabel">
	        						<span class="Required">&nbsp;</span> %%LNG_OutstandingBalance%%:
	        					</td>
	        					<td>
	        						<table cellpadding="5">
	        							<tr>
	        								<td style="text-align: right;">%%LNG_BalanceCarriedForward%%:</td>
	        								<td style="text-align: right;" id="BalanceForward"></td>
											<td>
												<img onmouseout="HideHelp('outstandinghelp');" onmouseover="ShowHelp('outstandinghelp', '%%LNG_OutstandingBalance%%', '%%LNG_OutstandingBalanceHelp%%')" src="images/help.gif" border="0" style="vertical-align: top;" />
												<div style="display:none" id="outstandinghelp"></div>
											</td>
	        							</tr>
	        							<tr>
	        								<td style="text-align: right;">%%LNG_NewOrders%%:</td>
	        								<td style="text-align: right;" id="NewOrders"></td>
											<td>&nbsp;</td>
	        							</tr>
	        							<tr id="ProfitMarginField">
	        								<td style="text-align: right;"><em>%%LNG_LessVendorProfitMargin%% (<span id="ProfitMarginPercentage"></span>%):</em></td>
	        								<td style="text-align: right; color: maroon; font-style: italic;" id="ProfitMargin"></td>
											<td>&nbsp;</td>
	        							</tr>
										<tr>
											<td style="text-align: right;"><strong>%%LNG_TotalOutstandingBalance%%:</strong></td>
											<td style="border-top: 1px solid #4E4F4F; border-bottom: 3px double #4E4F4F; text-align: right; font-weight: bold;" class="OutstandingBalance"></td>
											<td>&nbsp;</td>
										</tr>
	        						</table>
	        					</td>
	        				</tr>
	        			</table>
	        			<br />
	        			<table width="100%" class="Panel HideWhenNoVendor" style="display: none">
	        				<tr>
	        					<td class="Heading2" colspan="2">%%LNG_PaymentDetails%%</td>
	        				</tr>

	        				<tr>
	        					<td class="FieldLabel">
	        						<span class="Required">*</span> %%LNG_PaymentAmount%%:
	        					</td>
	        					<td>
	        						%%GLOBAL_LeftCurrencyToken%% <input type="text" name="paymentamount" class="Field50" id="paymentamount" /> %%GLOBAL_RightCurrencyToken%%
									<img onmouseout="HideHelp('paymentamounthelp');" onmouseover="ShowHelp('paymentamounthelp', '%%LNG_PaymentAmount%%', '%%LNG_PaymentAmountHelp%%')" src="images/help.gif" border="0" />
									<div style="display:none" id="paymentamounthelp"></div>
	        					</td>
	        				</tr>

	        				<tr>
	        					<td class="FieldLabel">
	        						<span class="Required">*</span> %%LNG_PaymentMethod%%:
	        					</td>
	        					<td>
	        						<input type="text" name="paymentmethod" class="Field300" id="paymentmethod" />
									<img onmouseout="HideHelp('paymentmethodhelp');" onmouseover="ShowHelp('paymentmethodhelp', '%%LNG_PaymentMethod%%', '%%LNG_PaymentMethodHelp%%')" src="images/help.gif" border="0" />
									<div style="display:none" id="paymentmethodhelp"></div>
	        					</td>
	        				</tr>

							<tr>
								<td class="FieldLabel">
									<span class="Required">&nbsp;</span> %%LNG_PaymentComments%%:
								</td>
								<td>
									<textarea name="paymentcomments" id="paymentcomments" class="Field300" rows="4"></textarea>
									<img onmouseout="HideHelp('paymentcommentshelp');" onmouseover="ShowHelp('paymentcommentshelp', '%%LNG_PaymentComments%%', '%%LNG_PaymentCommentsHelp%%')" src="images/help.gif" border="0" style="vertical-align: top" />
									<div style="display:none" id="paymentcommentshelp"></div>

	        				<tr>
	        					<td class="FieldLabel">
	        						<span class="Required">&nbsp;</span> %%LNG_DeductFromBalance%%:
	        					</td>
	        					<td>
	        						<label><input type="checkbox" name="paymentdeducted" id="paymentdeducted" value="1" checked="checked" /> %%LNG_YesDeductFromBalance%% (<span class="OutstandingBalance"></span>)</label>
									<img onmouseout="HideHelp('deducthelp');" onmouseover="ShowHelp('deducthelp', '%%LNG_DeductFromBalance%%', '%%LNG_DeductFromBalanceHelp%%')" src="images/help.gif" border="0" />
									<div style="display:none" id="deducthelp"></div>
	        					</td>
	        				</tr>

	        				<tr>
	        					<td class="FieldLabel">
	        						<span class="Required">&nbsp;</span> %%LNG_NotifyVendor%%:
	        					</td>
	        					<td>
	        						<label><input type="checkbox" name="notifyvendor" id="notifyvendor" value="1" checked="checked" /> %%LNG_YesNotifyVendor%%</label>
									<img onmouseout="HideHelp('notifyhelp');" onmouseover="ShowHelp('notifyhelp', '%%LNG_NotifyVendor%%', '%%LNG_NotifyVendorHelp%%')" src="images/help.gif" border="0" />
									<div style="display:none" id="notifyhelp"></div>
	        					</td>
	        				</tr>
	        			</table>
	        			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
	        			<tr>
	        				<td width="200" class="FieldLabel">
	        					&nbsp;
	        				</td>
	        				<td>
	        					<input type="submit" name="SaveButton2" value="%%LNG_Save%%" class="FormButton" />&nbsp;
	        					<input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
	        				</td>
	        			</tr>
	        		</table>
	        	</div>
	        </td>
		</tr>
		</table>
	</div>
</form>
<script type="text/javascript" src="../javascript/jquery/plugins/autocomplete/jquery.autocomplete.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#paymentmethod').autocomplete([%%GLOBAL_PaymentMethodList%%]);
});
function CheckPaymentForm()
{
	if(!$('#paymentvendorid').val()) {
		alert('%%LNG_SelectPaymentVendor%%');
		$('#paymentvendorid').focus();
		return false;
	}

	if(!$('#paymentamount').val() || isNaN(priceFormat($('#paymentamount').val()))) {
		alert('%%LNG_EnterPaymentAmount%%');
		$('#paymentamount').focus();
		return false;
	}

	if(!$('#paymentmethod').val()) {
		alert('%%LNG_EnterPaymentMethod%%');
		$('#paymentmethod').focus();
		return false;
	}

	return true;
}

function ConfirmCancel()
{
	if(confirm("%%LNG_ConfirmCancel%%")) {
		window.location = 'index.php?ToDo=viewVendorPayments';
	}
}

function ToggleVendor(vendorId)
{
	if(!vendorId) {
		$('.HideWhenNoVendor').hide();
		return false;
	}

	$.ajax({
		url: 'remote.php',
		data: 'remoteSection=vendors&w=getVendorPaymentDetails&vendorId='+vendorId,
		type: 'post',
		dataType: 'xml',
		success: function(xml) {
			$('#VendorDateRange').html($('fromDate', xml).text()+' - '+$('toDate', xml).text());
			$('.OutstandingBalance').html($('outstandingBalance', xml).text());
			$('#BalanceForward').html($('balanceForward', xml).text());
			$('#NewOrders').html($('totalOrders', xml).text());
			if(parseFloat($('profitMarginPercentage', xml).text()) > 0) {
				$('#ProfitMarginPercentage').html($('profitMarginPercentage', xml).text());
				$('#ProfitMargin').html('-'+$('profitMargin', xml).text());
			} else {
				$('#ProfitMarginField').hide();
			}
			$('.HideWhenNoVendor').show();
		}
	});
}
</script>