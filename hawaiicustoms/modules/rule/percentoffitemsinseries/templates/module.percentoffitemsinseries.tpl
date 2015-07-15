<div style="margin-left: 30px;">
<select name="var_discountpolicy" id="var_discountpolicy" class=" LargeFieldLabel">
    <option %%GLOBAL_SelectedSalePrice%% value="0">Sale Price</option>
    <option %%GLOBAL_SelectedCartPrice%% value="1">Price in Cart</option>
</select> 
<br /> 
<input name="var_minprice" class="discountFirst Field20" id="minprice" size="3" maxlength="3" value="%%GLOBAL_var_minprice%%"></input>
%%LNG_PERCENTOFFITEMSINSERIESMinPrice%% 
<br />                     
%%LNG_PERCENTOFFITEMSINSERIESget%%
<input name="var_amount" class="discountFirst Field20" id="amount" size="3" maxlength="3" value="%%GLOBAL_var_amount%%"></input>        
%%LNG_PERCENTOFFITEMSINSERIESoff%%    
</div>  

%%LNG_PERCENTOFFITEMSINSERIESincart%%

<div id="usedforbranddiv" style="padding-left:25px">       
    <select multiple="multiple" size="6" name="var_brandids[]" onchange="filterSeries(this.value);" id="var_brandids" class="Field250 ISSelectReplacement">
        %%GLOBAL_BrandsList%%
    </select>     
</div>
<div style="clear : both;"></div>
<div style="padding-left:30px; margin-top:3px;">(<a onclick="SelectBrandAll(true)" href="javascript:void(0)">Select All</a> / <a onclick="SelectBrandAll(false)" href="javascript:void(0)">Unselect All</a>)</div>
<div style="clear : both;"></div>   

<div id="usedforseriesdiv" style="padding-left:25px">     
	<select multiple="multiple" size="12" name="var_seriesids[]" id="var_seriesids" class="Field250 ISSelectReplacement">
		%%GLOBAL_SeriesList%%
	</select>
</div>
<div style="clear : both;"></div>
<div style="padding-left:30px; margin-top:3px;">(<a onclick="SelectAll(true)" href="javascript:void(0)">Select All</a> / <a onclick="SelectAll(false)" href="javascript:void(0)">Unselect All</a>)</div>

<script type="text/javascript">
        
		var select = document.getElementById('var_seriesids');
		ISSelectReplacement.replace_select(select);
        
		function SelectAll(Status)
		{
			$('#var_seriesids input').attr('checked', !Status);
			$('#var_seriesids input').trigger('click');
			$('#var_seriesids option').attr('selected', Status);
		}
        
        var select = document.getElementById('var_brandids');
        ISSelectReplacement.replace_select(select);
        
        function SelectBrandAll(Status)
        {
            $('#var_brandids input').attr('checked', !Status);
            $('#var_brandids input').trigger('click');
            $('#var_brandids option').attr('selected', Status);
        }
        
        function filterSeries(val)
        {           
            var foo = [];   
            
            if($('#var_brandids_old_old').length)    { 
                $('#var_brandids_old_old :selected').each(function(i, selected){   
                    foo[i] = $(selected).val();     
                });
            }
            else    {          
                $('#var_brandids_old :selected').each(function(i, selected){   
                    foo[i] = $(selected).val();  
                });       
            }
            
            $('#usedforseriesdiv').load('index.php?ToDo=filterSeriesDiscounts&brandids='+foo+'&ajax=1', {}, remake);
            
        }
        
        function remake(msg) { 
            var select = document.getElementById('var_seriesids');
            ISSelectReplacement.replace_select(select);            
        }

</script>