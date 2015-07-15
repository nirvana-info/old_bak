			<table class="GridPanel SortableGrid AutoExpand" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
				<tr align="right">
					<td colspan="9" style="padding:6px 0px 6px 0px" class="PagingNav">
						%%GLOBAL_Nav%%
					</td>
				</tr>
			<tr class="Heading3">
				<td align="center"><input type="checkbox" onclick="$(this).parents('form').find('input[type=checkbox]').attr(checked, this.checked);"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td nowrap="nowrap">
					%%LNG_GiftCertificateCode%% &nbsp;
					%%GLOBAL_SortLinksCode%%
				</td>
				<td nowrap="nowrap">
					%%LNG_GiftCertificatePurchasedBy%% &nbsp;
					%%GLOBAL_SortLinksCust%%
				</td>
				<td nowrap="nowrap">
					%%LNG_GiftCertificateAmount%% &nbsp;
					%%GLOBAL_SortLinksCertificateAmount%%
				</td>
				<td nowrap="nowrap">
					%%LNG_GiftCertificateBalance%% &nbsp;
					%%GLOBAL_SortLinksCertificateBalance%%
				</td>
				<td nowrap="nowrap">
					%%LNG_GiftCertificatePurchaseDate%% &nbsp;
					%%GLOBAL_SortLinksPurchaseDate%%
				</td>
				<td nowrap="nowrap">
					%%LNG_Status%% &nbsp;
					%%GLOBAL_SortLinksStatus%%
				</td>
			</tr>
			%%GLOBAL_GiftCertificatesGrid%%
			<tr align="right">
				<td colspan="9" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>
		</table>