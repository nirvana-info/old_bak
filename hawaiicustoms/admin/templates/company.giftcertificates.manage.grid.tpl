<script type="text/javascript">
function ToggleDeleteBoxes(Status)
{
	var fp = document.getElementById("frmGiftCertificates1").elements;
	for(i = 0; i < fp.length; i++)
		fp[i].checked = Status;
}
</script>
			<table class="GridPanel SortableGrid AutoExpand" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
				<tr align="right">
					<td colspan="9" style="padding:6px 0px 6px 0px" class="PagingNav">
						%%GLOBAL_Nav%%
					</td>
				</tr>
			<tr class="Heading3">
				<td align="center"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td nowrap="nowrap">
					%%LNG_CompanyGiftCertificateNameGrid%% &nbsp;
					%%GLOBAL_SortLinksCertificateName%%
				</td>
				<td nowrap="nowrap">
					%%LNG_CompanyGiftCertificateCodeGrid%% &nbsp;
					%%GLOBAL_SortLinksCode%%
				</td>	
				<td nowrap="nowrap">
					%%LNG_CompanyGiftCertificateToGrid%% &nbsp;
					%%GLOBAL_SortLinksCertificateTo%%
				</td>			
				<td nowrap="nowrap">
					%%LNG_CompanyGiftCertificateAmountBalance%% &nbsp;
					%%GLOBAL_SortLinksCertificateAmount%%
				</td>
				<td nowrap="nowrap">
					%%LNG_CompanyGiftCertificatePurchaseDate%% &nbsp;
					%%GLOBAL_SortLinksPurchaseDate%%
				</td>
				<td nowrap="nowrap">
					%%LNG_Status%% &nbsp;
					%%GLOBAL_SortLinksStatus%%
				</td>
                <td nowrap="nowrap">
                   %%LNG_Action%% &nbsp;  
                </td>
			</tr>
			%%GLOBAL_cgcGrid%%
			<tr align="right">
				<td colspan="9" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>
		</table>

<script type="text/javascript">
    window.CurrentPageLink = "%%GLOBAL_CurrentPageLink%%";
</script>