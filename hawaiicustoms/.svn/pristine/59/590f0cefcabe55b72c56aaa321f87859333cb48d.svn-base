	<tr id="tr%%GLOBAL_cgcId%%" class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'">
		<td align="center" style="width:23px">
			<input type="checkbox" name="certificates[]" value="%%GLOBAL_cgcId%%" class="DeleteCheck">
		</td>
		<td align="center" style="width:15px">
			<a href="#" onclick="QuickCompanyGiftCertificateView('%%GLOBAL_cgcId%%'); return false;">
				<img id="expand%%GLOBAL_cgcId%%" src="images/plus.gif" class="ExpandLink" align="left" width="19" height="16" title="%%LNG_ExpandGiftCertificateQuickView%%" border="0">
			</a>
		</td>
		<td align="center" style="width:18px">
			<img src='images/giftcertificate.gif' height="16" width="16" />
		</td>
		<td class="%%GLOBAL_SortedFieldCodeClass%%">
			%%GLOBAL_cgcName%%
		</td>		
		<td class="%%GLOBAL_SortedFieldCodeClass%%">
			%%GLOBAL_cgcCode%%
		</td>
		<td class="%%GLOBAL_SortedFieldCodeClass%%">
			%%GLOBAL_cgcTos%%
		</td>
		<td class="%%GLOBAL_SortedFieldCertificateAmountClass%%">
			%%GLOBAL_cgcAmount%%
		</td>
		<td class="%%GLOBAL_SortedFieldPurchaseDateClass%%">
			%%GLOBAL_cgcPurchaseDate%%
		</td>
		<td class="%%GLOBAL_SortedFieldStatusClass%%">
			<select name="certificate_status_%%GLOBAL_cgcId%%" id="status_%%GLOBAL_cgcId%%" class="Field" onchange="UpdateGiftCertificateStatus(%%GLOBAL_cgcId%%, this.options[this.selectedIndex].value, this.options[this.selectedIndex].text, %%GLOBAL_cgcsendedval%%)">
				%%GLOBAL_cgcStatusOptions%%
			</select>
			&nbsp;
		</td>
        </td>
        <td class="%%GLOBAL_SortedFieldCustClass%%">
        	<span id="edit_cgc_%%GLOBAL_cgcId%%" ></span>&nbsp;&nbsp;
      		<a href="javascript:PreviewCompanyGiftCertificate(%%GLOBAL_cgcId%%);" >View</a> 
        </td>
	</tr>
	<tr id="trQ%%GLOBAL_cgcId%%" style="display: none;">
		<td colspan="3">&nbsp;</td>
		<td colspan="2" id="tdQ%%GLOBAL_cgcId%%" class="QuickView">
		</td>
		<td colspan="3">&nbsp;</td>
	</tr>
<script type="text/javascript">
   
function PreviewCompanyGiftCertificate(id) {
    
    var l = (screen.availWidth/2)-580;
    var t = (screen.availHeight/2)-220;
    var win = window.open('index.php?ToDo=viewCompanyGiftcertificatesPopup&id='+id+'&'+$('#frmGiftCertificate').serialize(), "imagePop", "toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=580,height=280,top="+t+",left="+l);
    win.focus();
}
</script>