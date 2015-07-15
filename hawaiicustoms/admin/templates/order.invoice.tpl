<link rel="stylesheet" href="Styles/invoicestyles.css" type="text/css">
<table class="MainTable" width="100%" cellspacing="5" cellpadding="5">
	<tr>
		<td colspan="2" class="InvoiceTitle">
			%%GLOBAL_StoreName%% %%GLOBAL_InvoiceTitle%%
		</td>
	</tr>
	<tr>
		<td colspan="2" class="Heading2">
			%%GLOBAL_StoreAddressFormatted%%
		</td>
	</tr>
	<tr>
		<td colspan="2"  class="Heading3">
			%%LNG_CustomerDetails%%
		</td>
	</tr>
	<tr>
		<td colspan="2">
			%%GLOBAL_CustomerDetails%%
		</td>
	</tr>
	<tr>
		<td width="50%" class="Heading3">
			%%LNG_BillTo%%
		</td>
		<td width="50%" class="Heading3">
			%%LNG_ShipTo%%
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top">
			%%GLOBAL_BillingAddress%%
		</td>
		<td width="50%" valign="top">
			%%GLOBAL_ShippingAddress%%
		</td>
	</tr>
	<tr>
		<td width="50%" valign="top">
			<table cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-bottom: 3px; padding-right: 10px; font-weight: bold;">%%LNG_Order%%:</td>
					<td style="padding-bottom: 3px;">#%%GLOBAL_OrderId%%</td>
				</tr>
			</table>
		</td>
		<td width="50%" valign="top">
			<table cellspacing="0" cellpadding="0">
				<tr>
					<td style="padding-bottom: 3px; padding-right: 10px; font-weight: bold;">%%LNG_OrderDate%%:</td>
					<td style="padding-bottom: 3px;">%%GLOBAL_OrderDate%%</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="Heading3">
			<hr size="1" noshade>%%LNG_OrderItems%%
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="95%" border="0" align="right">
				<tr>
					<td class="Heading2">%%LNG_Quantity%%</td>
					<td class="Heading2">%%LNG_Code%%</td>
					<td class="Heading2">%%LNG_ProdName%%</td>
					<td class="Heading2">%%LNG_Price%%</td>
				</tr>
				%%GLOBAL_ProductsTable%%
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="Heading3">
			<hr size="1" noshade>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="Heading3" align="right">
			<table width="300">
				<tr>
					<td align="right" style="padding-right:10px">%%LNG_InvoiceItems%%:</td>
					<td>%%GLOBAL_ItemCost%%</td>
				</tr>
				<tr style="%%GLOBAL_HideGiftWrappingTotal%%">
					<td align="right" style="padding-right:10px;">%%LNG_GiftWrapping%%:</td>
					<td>%%GLOBAL_GiftWrappingTotal%%</td>
				</tr>
				<tr>
					<td align="right" style="padding-right:10px">%%LNG_InvoiceShipping%%:</td>
					<td>%%GLOBAL_ShippingCost%%</td>
				</tr>
				<tr style="display:%%GLOBAL_HideHandlingCost%%">
					<td align="right" style="padding-right:10px">%%LNG_InvoiceHandling%%:</td>
					<td>%%GLOBAL_HandlingCost%%</td>
				</tr>
				<tr style="display:%%GLOBAL_HideSalesTax%%">
					<td align="right" style="padding-right:10px">%%GLOBAL_SalesTaxName%%:</td>
					<td>%%GLOBAL_SalesTax%%</td>
				</tr>
				<tr>
					<td align="right" style="padding-right:10px"><strong>%%LNG_InvoiceTotalCost%%:</strong></td>
					<td><strong>%%GLOBAL_TotalCost%%</strong></td>
				</tr>
				<tr style="display:%%GLOBAL_HideSalesTaxIncluded%%">
					<td align="right" style="padding-right:10px">%%GLOBAL_SalesTaxName%%:</td>
					<td>%%GLOBAL_SalesTax%%</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr style="%%GLOBAL_HideComments%%">
		<td colspan="2" class="Heading3">
			<hr size="1" noshade="noshade" />
			%%LNG_Comments%%
		</td>
	</tr>
	<tr style="%%GLOBAL_HideComments%%">
		<td colspan="2">
			<blockquote>%%GLOBAL_Comments%%</blockquote>
		</td>
	</tr>
</table>
