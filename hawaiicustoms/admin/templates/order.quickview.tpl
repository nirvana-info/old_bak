<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top" width="33%" class="QuickViewPanel">
			<h5>%%LNG_BillingDetails%%</h5>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="text" width="120" valign="top">%%LNG_CustomerDetails%%:</td>
					<td class="text">
						%%GLOBAL_BillingAddress%%
					</td>
				</tr>
				<tr>
					<td class="text" valign="top">%%LNG_Email%%:</td>
					<td class="text">%%GLOBAL_BillingEmail%%</td>
				</tr>
				<tr>
					<td class="text" valign="top">%%LNG_PhoneNumber%%:</td>
					<td class="text">%%GLOBAL_BillingPhone%%</td>
				</tr>
				<tr>
					<td class="text" valign="top">%%LNG_OrderDate1%%:</td>
					<td class="text">%%GLOBAL_OrderDate%%</td>
				</tr>
				<tr>
					<td class="text" valign="top">%%LNG_IPAddress%%:</td>
					<td class="text"><a href="http://ws.arin.net/cgi-bin/whois.pl?queryinput=%%GLOBAL_IPAddress%%" target="_blank">%%GLOBAL_IPAddress%%</a></td>
				</tr>
				<tr style="%%GLOBAL_HideVendor%%">
					<td class="text" valign="top">%%LNG_Vendor%%:</td>
					<td class="text">%%GLOBAL_VendorName%%</td>
				</tr>
				<tr>
					<td class="text" valign="top">%%LNG_PaymentMethod%%:</td>
					<td class="text">%%GLOBAL_PaymentMethod%%</td>
				</tr>
				<tr style="%%GLOBAL_HideTransactionId%%">
					<td class="text" valign="top">%%LNG_TransactionId%%:</td>
					<td class="text">%%GLOBAL_TransactionId%%</td>
				</tr>
				<tr style="%%GLOBAL_HidePaymentStatus%%">
					<td class="text" valign="top">%%LNG_PaymentStatus%%:</td>
					<td class="text">%%GLOBAL_PaymentStatus%%</td>
				</tr>
			</table>
			%%GLOBAL_ExtraInfo%%

			<div style="display:%%GLOBAL_HideBillingFormFields%%; margin-top:10px;">
				<h5>%%LNG_BillingDetailsQuickView%%</h5>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					%%GLOBAL_BillingFormFields%%
				</table>
			</div>
            <br /><br />
            <div><strong>%%LNG_OrderAddedBy%%</strong>%%GLOBAL_AddedBy%%</div>
		</td>
		<td valign="top" width="33%" class="QuickViewPanel" style="display:%%GLOBAL_HideShippingPanel%%; padding-left:15px">
			<h5>%%LNG_ShippingDetails%%</h5>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="text" valign="top">%%LNG_CustomerDetails%%:</td>
					<td class="text">
						%%GLOBAL_ShippingAddress%%
					</td>
				</tr>
				<tr style="%%GLOBAL_HideShippingZone%%">
					<td class="text" valign="top">%%LNG_ShippingZone%%:</td>
					<td class="text">%%GLOBAL_ShippingZone%%</td>
				</tr>
				<tr>
					<td class="text" valign="top">%%LNG_Email%%:</td>
					<td class="text">%%GLOBAL_ShippingEmail%%</td>
				</tr>
				<tr>
					<td class="text" valign="top">%%LNG_PhoneNumber%%:</td>
					<td class="text">%%GLOBAL_ShippingPhone%%</td>
				</tr>
				<tr>
					<td class="text" valign="top">%%LNG_ShippingMethod%%:</td>
					<td class="text">%%GLOBAL_ShippingMethod%%</td>
				</tr>
				<tr>
					<td class="text" valign="top">%%LNG_ShippingCost%%:</td>
					<td class="text">%%GLOBAL_ShippingCost%%</td>
				</tr>
				<tr>
					<td class="text" valign="top">%%LNG_ShippingDate%%:</td>
					<td class="text">%%GLOBAL_ShippingDate%%</td>
				</tr>
				<tr>
					<td colspan='2'>&nbsp;</td>
				</tr>
				<tr>
				    <td class="text" valign="top"><strong>%%LNG_StaffNotes%%:</strong></td>
				    <td class="text">%%GLOBAL_StaffNotes%%</td>
				</tr>
			</table>

			<div style="display:%%GLOBAL_HideShippingFormFields%%; margin-top:10px;">
				<h5>%%LNG_ShippingDetailsQuickView%%</h5>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					%%GLOBAL_ShippingFormFields%%
				</table>
			</div>
		</td>
		<td valign="top" width="33%" style="padding-left:10px">
			<h5>%%LNG_OrderDetails%%</h5>
			%%GLOBAL_ProductsTable%%
            <div style="%%GLOBAL_HideCouponsUsed%%">
                <h5 style="margin-top: 10px;">%%LNG_CouponsUsed%%</h5>
                <div style="margin-left: 20px;">
                    %%GLOBAL_CouponsUsedDetails%%
                </div>
            </div>
            <div style="%%GLOBAL_HideCompanyGiftCertificatesUsed%%">
                <h5 style="margin-top: 10px;">%%LNG_CompanyGiftCertificatesUsed%%</h5>
                <div style="margin-left: 20px;">
                    %%GLOBAL_CompanyGiftCertificatesUsed%%
                </div>
            </div>
            <div style="%%GLOBAL_HideGiftCertificatesUsed%%">
                <h5 style="margin-top: 10px;">%%LNG_GiftCertificatesUsed%%</h5>
                <div style="margin-left: 20px;">
                    %%GLOBAL_GiftCertificatesUsed%%
                </div>
            </div>
			<div style="%%GLOBAL_HideOrderComments%%">
				<h5 style="margin-top: 10px;">%%LNG_OrderComments%%</h5>
				<div style="margin-left: 20px;">
					%%GLOBAL_OrderComments%%
				</div>
			</div>
		</td>
	</tr>
</table>
