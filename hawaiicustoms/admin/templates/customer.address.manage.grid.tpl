			<table class="GridPanel SortableGrid AutoExpand" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
			<tr>
				<td colspan="9">
					<table class="LetterSort" cellspacing="2" cellpadding="0" border="0">
						<tr>
							%%GLOBAL_LetterSortGrid%%
						</tr>
					</table>
				</td>
			</tr>
			<tr align="right">
				<td colspan="9" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>
			<tr class="Heading3">
				<td>
					<input type="checkbox" onclick="toggleAddressBoxes(this.checked);" />
				</td>
				<td>
					%%LNG_CustomerAddressFullName%%
				</td>
				<td>
					%%LNG_CustomerAddressPhone%%
				</td>
				<td>
					%%LNG_CustomerAddressFullAddress%%
				</td>
				<td>
					%%LNG_Action%%
				</td>
			</tr>
			%%GLOBAL_AddressGrid%%
			<tr align="right">
				<td colspan="9" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>
		</table>