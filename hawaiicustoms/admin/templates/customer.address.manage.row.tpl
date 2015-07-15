<tr class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'" id="CustomerAddress%%GLOBAL_AddressId%%">
	<td width="20" align="center">
		<input type="checkbox" name="addresses[]" value="%%GLOBAL_AddressId%%" /><input type="hidden" name="addressDisplayStatus[]" value="display" />
	</td>
	<td style="width:15%;">
		%%GLOBAL_FullName%%
	</td>
	<td style="width:10%;">
		%%GLOBAL_Phone%%
	</td>
	<td style="width:55%;">
		%%GLOBAL_StreetAddress%%<br />
		%%GLOBAL_City%%, %%GLOBAL_State%% %%GLOBAL_PostCode%%<br />
		%%GLOBAL_Country%% %%GLOBAL_CountryImg%%
	</td>
	<td>
		%%GLOBAL_EditCustomerLink%%
		%%GLOBAL_DeleteCustomerLink%%
	</td>
</tr>