			<style type="text/css">
				.GridRow td, .GridRowOver td{
					word-break:break-all;
					word-wrap:break-word;
				}
			</style>
			<table class="GridPanel SortableGrid AutoExpand" style="table-layout:fixed;" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
				<tr align="right">
					<td colspan="12" style="padding:6px 0px 6px 0px" class="PagingNav">
						%%GLOBAL_Nav%%
					</td>
				</tr>
			<tr class="Heading3">
				<td align="center"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
				<td>
					Preview &nbsp;
				</td>
				<td colspan="1">
					Description &nbsp;
				</td>
				<td>
					Customer &nbsp;
					%%GLOBAL_SortLinksName%%
				</td>
				<td>
					Uploader Name &nbsp;
				</td>
				<td>
					Address &nbsp;
				</td>
				<td colspan="2">
					Upload Time &nbsp;
					%%GLOBAL_SortLinksDate%%
				</td>
				<td colspan="2">
					Comments &nbsp;
				</td>
				<td>
					Available ? &nbsp;
					%%GLOBAL_SortLinksDeleted%%
				</td>
				<td colspan="2">
					%%LNG_Action%%
				</td>
			</tr>
			%%GLOBAL_PhotoGrid%%
			<tr align="right">
				<td colspan="12" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>
		</table>
		<script language="javascript">
			$(document).ready(function(){
				//init:adjust all images
				$('.adjust-image').load(function(){
					//remove all width & height attributes
					$(this).removeAttr('width');
					$(this).removeAttr('height');
					
					$(this).adjustImage(48, 48);
				});
				
				//ie should init after load binding,so,we did all browsers here
				$('.adjust-image').each(function(){
					$(this).attr('src', $(this).attr('data'));
				});
			});
		</script>