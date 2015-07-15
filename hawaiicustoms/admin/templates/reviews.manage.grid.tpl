<script>
function ShowOrderList(id){
    var expandObj = document.getElementById('expand' + id);
    var contentObj = document.getElementById('content' + id);
    if($('#expand'+id).attr('src') == 'images/plus.gif'){
        $('#expand'+id).attr('src', 'images/minus.gif');
    }else{
        $('#expand'+id).attr('src', 'images/plus.gif');
    }
    $('#content' + id).toggle();
}
</script>
			
			<table class="GridPanel SortableGrid" cellspacing="0" cellpadding="0" border="0" id="IndexGrid" style="width:100%;">
				<tr align="right">
					<td colspan="9" style="padding:6px 0px 6px 0px" class="PagingNav">
						%%GLOBAL_Nav%%
					</td>
				</tr>
			<tr class="Heading3">
				<td align="center" style="width:18px"><input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)"></td>
				<td style="width:14px">&nbsp;</td>
				<td>
					%%LNG_Product%% &nbsp;
					%%GLOBAL_SortLinksName%%
				</td>
				<td>
					%%LNG_RateOverall%% &nbsp;
					%%GLOBAL_SortLinksRating%%
				</td>
				<td>
					%%LNG_RateProductQuality%% &nbsp;
					%%GLOBAL_SortLinksRatingQuality%%
				</td>
				<td>
					%%LNG_RateEaseInstallation%% &nbsp;
					%%GLOBAL_SortLinksRatingInstall%%
				</td>
				<td>
					%%LNG_RateProductValue%% &nbsp;
					%%GLOBAL_SortLinksRatingValue%%
				</td>
				<td>
					%%LNG_RateCustomerSupport%% &nbsp;
					%%GLOBAL_SortLinksRatingSupport%%
				</td>
				<td>
					%%LNG_RateDeliveryTime%% &nbsp;
					%%GLOBAL_SortLinksRatingDelivery%%
				</td>
				<td>
					%%LNG_PostedBy%% &nbsp;
					%%GLOBAL_SortLinksBy%%
				</td>
				<td>
					%%LNG_Date%% &nbsp;
					%%GLOBAL_SortLinksDate%%
				</td>
				<td style="width:70px">
					%%LNG_Status%% &nbsp;
					%%GLOBAL_SortLinksStatus%%
				</td>
				<td>
				%%LNG_OrderId%% &nbsp;
				%%GLOBAL_SortLinksOrderId%%
				</td>
				
				<td style="width:80px">
					%%LNG_Action%%
				</td>
			</tr>
			%%GLOBAL_ReviewGrid%%
			<tr align="right">
				<td colspan="9" style="padding:6px 0px 6px 0px" class="PagingNav">
					%%GLOBAL_Nav%%
				</td>
			</tr>
		</table>
		<a href="?searchQuery=%%GLOBAL_Query%%&amp;page=%%GLOBAL_Page%%%%GLOBAL_SortURL%%" id="ReviewSortURL"></a>