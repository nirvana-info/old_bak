	<tr id="tr%%GLOBAL_GiftCertificateId%%" class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'">
		<td align="center" style="width:23px">
			<input type="checkbox" name="certificates[]" value="%%GLOBAL_GiftCertificateId%%" class="DeleteCheck">
		</td>
		<td align="center" style="width:15px">
			<a href="#" onclick="QuickGiftCertificateView('%%GLOBAL_GiftCertificateId%%'); return false;">
				<img id="expand%%GLOBAL_GiftCertificateId%%" src="images/plus.gif" class="ExpandLink" align="left" width="19" height="16" title="%%LNG_ExpandGiftCertificateQuickView%%" border="0">
			</a>
		</td>
		<td align="center" style="width:18px">
			<img src='images/giftcertificate.gif' height="16" width="16" />
		</td>
		<td class="%%GLOBAL_SortedFieldCodeClass%%">
			%%GLOBAL_GiftCertificateCode%%
		</td>
		<td class="%%GLOBAL_SortedFieldCustClass%%">
			<a href="index.php?ToDo=viewCustomers&amp;searchQuery=%%GLOBAL_GiftCertificateCustomerId%%" target="_blak">%%GLOBAL_GiftCertificateCustomerName%%</a>
		</td>
		<td class="%%GLOBAL_SortedFieldCertificateAmountClass%%">
			%%GLOBAL_GiftCertificateAmount%%
		</td>
		<td class="%%GLOBAL_SortedFieldCertificateBalanceClass%%">
			%%GLOBAL_GiftCertificateBalance%%
		</td>
		<td class="%%GLOBAL_SortedFieldPurchaseDateClass%%">
			%%GLOBAL_GiftCertificatePurchaseDate%%
		</td>
		<td class="%%GLOBAL_SortedFieldStatusClass%%">
			<select name="certificate_status_%%GLOBAL_GiftCertificateId%%" id="status_%%GLOBAL_GiftCertificateId%%" class="Field" onchange="UpdateGiftCertificateStatus(%%GLOBAL_GiftCertificateId%%, this.options[this.selectedIndex].value, this.options[this.selectedIndex].text)">
				%%GLOBAL_GiftCertificateStatusOptions%%
			</select>
			&nbsp;
		</td>
	</tr>
	<tr id="trQ%%GLOBAL_GiftCertificateId%%" style="display: none;">
		<td colspan="3">&nbsp;</td>
		<td colspan="2" id="tdQ%%GLOBAL_GiftCertificateId%%" class="QuickView">
		</td>
		<td colspan="3">&nbsp;</td>
	</tr>
