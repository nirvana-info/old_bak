<tr class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'">
    <td id="p%%GLOBAL_Brandidhide%%" onclick="display('b%%GLOBAL_BrandId%%');">
        <img src="%%GLOBAL_ShopPath%%/templates/default/images/plusicon.gif">
    </td>
    <td id="m%%GLOBAL_Brandidhide%%" style="display:none" onclick="display('b%%GLOBAL_BrandId%%');">
        <img src="%%GLOBAL_ShopPath%%/templates/default/images/minusicon.gif">
    </td>

    <td align="center">
        <input type="checkbox" name="brands[]" value="%%GLOBAL_BrandId%%">
    </td>
    <td align="center">
        <img src='images/brand.gif' width="15" height="15">
    </td>
    <td>
        %%GLOBAL_BrandName%%
    </td>
    <td>
        %%GLOBAL_Products%%
    </td>
    <td>
        %%GLOBAL_EditBrandLink%%
    </td>
</tr>
<tr>
    <td colspan="7">
        <div style="display:none" id="%%GLOBAL_Brandidhide%%">  
            <table class="GridPanel SortableGrid" cellspacing="0" cellpadding="0" border="0" id="IndexGrid"> 
                %%GLOBAL_SeriesGrid%%
            </table>
        </div>
    </td>
</tr>
