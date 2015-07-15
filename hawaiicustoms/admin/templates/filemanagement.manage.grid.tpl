			<div id="div%%GLOBAL_DivIndex%%" style="padding-top: 10px;">
                <div class="GridContainer" style="display: %%GLOBAL_DisplayTabGrid%%">
                    <table class="GridPanel SortableGrid" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
				            <tr align="right">
					            <td colspan="9" class="PagingNav" style="padding:6px 0px 6px 0px">
						            %%GLOBAL_Nav%%
					            </td>
				            </tr>
			            <tr class="Heading3">
				            <td align="center"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked, '%%GLOBAL_FileType%%')"></td>
				            <td>&nbsp;</td>
				            <td>
					            %%LNG_FileName%% &nbsp;
					            <!--%%GLOBAL_SortLinksBrand%%-->
				            </td>
                            <td>
                                %%LNG_FileStatus%% &nbsp;
                                <!--%%GLOBAL_SortLinksProducts%%-->
                            </td>
				            <td>
					            %%LNG_ProductName%% &nbsp;
					            <!--%%GLOBAL_SortLinksProducts%%-->
				            </td>
				            <!--<td style="width:100px;">
					            %%LNG_Action%%
				            </td>-->
			            </tr>
			            %%GLOBAL_FilesGrid%%
			            <tr align="right">
				            <td colspan="9" class="PagingNav" style="padding:6px 0px 6px 0px">
					            %%GLOBAL_Nav%%
				            </td>
			            </tr>
		             </table>
                 </div>
                 <div>
                    %%GLOBAL_TabMessage%% 
                 </div> 
            </div>