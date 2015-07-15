<div style="margin-left: 30px;">  
<select name="var_discountpolicy" id="var_discountpolicy" class="LargeFieldLabel">
    <option value="0" %%GLOBAL_SelectedSalePrice%%>Sale Price</option>
    <option value="1" %%GLOBAL_SelectedCartPrice%%>Price in Cart</option>
</select> 
<br />     
<input name="var_minprice" class="discountFirst Field20" id="minprice" size="3" maxlength="3" value="%%GLOBAL_var_minprice%%"></input>
%%LNG_PERCENTOFFITEMSINCATMinPrice%% 
<br />
%%LNG_PERCENTOFFITEMSINCATget%%
<input name="var_amount" class="discountFirst Field20" id="amount" size="3" maxlength="3" value="%%GLOBAL_var_amount%%"></input>
%%LNG_PERCENTOFFITEMSINCAToff%%
</div> 

%%LNG_PERCENTOFFITEMSINCATincart%%

<div id="usedforcatdiv" style="padding-left:25px">
	<select multiple="multiple" size="12" name="var_catids[]" id="var_catids" class="Field250 ISSelectReplacement">
		%%GLOBAL_CategoryList%%
	</select>
</div>
<div style="clear : both;"></div>
<div style="padding-left:30px; margin-top:3px;">(<a onclick="SelectAll(true)" href="javascript:void(0)">Select All</a> / <a onclick="SelectAll(false)" href="javascript:void(0)">Unselect All</a>)</div>

<script type="text/javascript">

		var select = document.getElementById('var_catids');
		ISSelectReplacement.replace_select(select);

		function SelectAll(Status)
		{
			$('#var_catids input').attr('checked', !Status);
			$('#var_catids input').trigger('click');
			$('#var_catids option').attr('selected', Status);
		}

</script>