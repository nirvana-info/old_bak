	<div class="BodyContainer">

	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">
				%%LNG_View%%: <a href="#" style="color:#005FA3" id="ViewsMenuButton" class="PopDownMenu">%%GLOBAL_ViewName%% <img width="8" height="5" src="images/arrow_blue.gif" border="0" /></a>
			</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_ManageReturnsIntro%%</p>
			<div id="ReturnsStatus">
				%%GLOBAL_Message%%
			</div>
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			<td class="Intro" valign="top">
				<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
			</td>
			<td class="SmallSearch" align="right">
				<table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
				<form name="frmReturns" id="frmReturns" action="index.php?ToDo=viewReturns%%GLOBAL_SortURL%%" method="get">
				<tr>
					<td class="text" nowrap align="right">
						<input name="searchQuer" id="searchQuery" type="text" value="%%GLOBAL_Query%%" id="SearchQuery" class="SearchBox" style="width:150px" />&nbsp;
						<select name="returnStatus" id="returnStatus">
							<option value="0">%%LNG_AllStatuses%%</option>
							%%GLOBAL_ReturnStatusList%%
						<input type="image" name="SearchButton" id="SearchButton" src="images/searchicon.gif" border="0" style="padding-left: 10px; vertical-align: top;" />
					</td>
				</tr>
				<tr>
					<td nowrap>
						<a href="index.php?ToDo=searchReturns">%%LNG_AdvancedSearch%%</a>
						<span style="display:%%GLOBAL_HideClearResults%%">| <a id="SearchClearButton" href="index.php?ToDo=viewReturns">%%LNG_ClearResults%%</a></span>
					</td>
				</tr>
				</form>
				</table>
			</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmReturns1" id="frmReturns1" method="post" action="index.php?ToDo=deleteReturns">
				<div class="GridContainer">
					%%GLOBAL_ReturnsDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>
	</div>
		<div id="ViewsMenu" class="DropDownMenu DropShadow" style="display: none; width:200px">
				<ul>
					%%GLOBAL_CustomSearchOptions%%
				</ul>
				<hr />
				<ul>
					<li><a href="index.php?ToDo=createReturnView" style="background-image:url('images/view_add.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_CreateANewView%%</a></li>
					<li style="display:%%GLOBAL_HideDeleteViewLink%%"><a onclick="$('#ViewsMenu').hide(); ConfirmDeleteCustomSearch('%%GLOBAL_CustomSearchId%%')" href="javascript:void(0)" style="background-image:url('images/view_del.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_DeleteThisView%%</a></li>
				</ul>
			</div>
		</div>
		</div>
		</div>
	</div>

	<script type="text/javascript">
		function ConfirmDeleteSelected()
		{
			if($('.DeleteCheck:checked').length == 0) {
				alert('%%LNG_ChooseReturnsToDelete%%');
			}
			else {
				if(confirm('%%LNG_ConfirmDeleteReturns%%')) {
					$('#frmReturns1').submit();
				}
			}
		}

		function UpdateReturnStatus(returnid, statusid, statustext, initialstatus) {
			if(confirm('%%LNG_ConfirmReturnStatusChange%%' + ' ' + statustext.toLowerCase() + "?")) {
				$('#ajax_status_'+returnid).show();
				$.ajax({
					url: 'remote.php?w=updateReturnStatus&returnId='+returnid+'&status='+statusid,
					success: function(response) {
						$('#ajax_status_'+returnid).hide();
						if(response == 0) {
							alert('%%LNG_FailedUpdateReturnStatus%%');
						}
					},
					error: function() {
						alert('%%LNG_FailedUpdateReturnStatus%%');
					}
				});
				$('#status_'+returnid).attr('lastStatus', statusid);
			}
			else {
				if($('#status_'+returnid).attr('lastStatus')) {
					$('#status_'+returnid).val($('#status_'+returnid).attr('lastStatus'));
				}
				else {
					$('#status_'+returnid).val(initialstatus);
				}
			}
		}

		function ConfirmDeleteCustomSearch(id) {
			if(confirm('%%LNG_ConfirmDeleteCustomSearch%%')) {
				document.location.href = "index.php?ToDo=deleteCustomReturnSearch&searchId="+id;
			}
		}

		function QuickReturnView(id) {
			var tr = document.getElementById("tr"+id);
			var trQ = document.getElementById("trQ"+id);
			var tdQ = document.getElementById("tdQ"+id);
			var img = document.getElementById("expand"+id);

			if(img.src.indexOf("plus.gif") > -1)
			{
				img.src = "images/minus.gif";

				for(i = 0; i < tr.childNodes.length; i++)
				{
					if(tr.childNodes[i].style != null)
						tr.childNodes[i].style.backgroundColor = "#dbf3d1";
				}

				trQ.style.display = "";
				$(trQ).find('.QuickView').load('remote.php?w=returnQuickView&returnId='+id, {}, function() {
					trQ.style.display = "";
				});
			}
			else
			{
				img.src = "images/plus.gif";

				for(i = 0; i < tr.childNodes.length; i++)
				{
					if(tr.childNodes[i].style != null)
						tr.childNodes[i].style.backgroundColor = "";
				}
				trQ.style.display = "none";
			}
		}

		function UpdateReturnNotes(id) {
			$('#ReturnNotes'+id).find('input[type=button]').val('%%LNG_UpdatingNotes%%');
			$('#ReturnNotes'+id).find('input[type=button]').attr('disabled', true);
			$.ajax({
				url: 'remote.php?w=updateReturnNotes',
				type: 'POST',
				data: $('#ReturnNotes'+id).serialize(),
				success: function(msg) {
					$('#ReturnNotes'+id).find('input[type=button]').val('%%LNG_UpdateNotes%%');
					$('#ReturnNotes'+id).find('input[type=button]').attr('disabled', false);
					if(msg == 1) {
						display_success('ReturnsStatus', '%%LNG_ReturnNotesUpdated%%');
					}
					else {
						alert('%%LNG_ReturnNotesUpdateError%%');
					}
				},
				error: function() {
					$('#ReturnNotes'+id).find('input[type=button]').val('%%LNG_UpdateNotes%%');
					$('#ReturnNotes'+id).find('input[type=button]').attr('disabled', false);
					display_error('ReturnsStatus', '%%LNG_ReturnNotesUpdateError%%');
				}
			});
		}

		function ConfirmIssueCredit(amount) {
			if(confirm('%%LNG_ConfirmReturnIssueCredit%%'.replace('%s', amount))) {
				return true;
			}
			return false;
		}
</script>
