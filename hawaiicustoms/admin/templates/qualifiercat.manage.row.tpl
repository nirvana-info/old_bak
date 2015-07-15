				<li id="ele-%%GLOBAL_CatId%%" class="SortableRow">
					<table class="GridPanel" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
						<tr class="GridRow" onmouseover="this.className='GridRowOver'" onmouseout="this.className='GridRow'" onclick="listQualifiers('quals-%%GLOBAL_CatId%%', %%GLOBAL_CatId%%);">
							<td width="1"><img id="image-%%GLOBAL_CatId%%"  src="%%GLOBAL_ShopPath%%/templates/default/images/plusicon.gif" name="categories[%%GLOBAL_CatId%%]" value='%%GLOBAL_CatId%%' /></td> <!--onclick="listQualifiers('quals-%%GLOBAL_CatId%%', %%GLOBAL_CatId%%);"-->
							<td>%%GLOBAL_CatName%%</td> 
							<td width="100">          
								<!--%%GLOBAL_EditLink%%&nbsp;&nbsp;&nbsp;-->
								<!--%%GLOBAL_DeleteLink%%-->
							</td>
						</tr>
                        <tr>
                            <td>
                                
                            </td>
                            <td colspan="2">
                                <div id="quals-%%GLOBAL_CatId%%" style="width:90%;float:right;display:none;">    
                                </div>
                            </td>
                        </tr>
					</table>
					%%GLOBAL_SubCats%%
				</li>