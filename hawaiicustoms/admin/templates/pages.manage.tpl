	<div class="BodyContainer">
		<script type="text/javascript">
			ShowLoadingIndicator();
			window.onload = function() {
				HideLoadingIndicator();
			};
		</script>
		<form name="frmPages" id="frmPages" method="post" action="index.php?ToDo=deletePages">
		<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
			<tr>
				<td class="Heading1">%%LNG_ViewPages%%</td>
			</tr>
			<tr>
			<td class="Intro">
				<p>%%GLOBAL_PageIntro%%</p>
				<div id="PagesStatus">%%GLOBAL_Message%%</div>
				<p class="Intro">
					<input type="button" name="IndexAddButton" value="%%LNG_CreatePage%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=createPage'" /> &nbsp;
					<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
				</p>
			</td>
			</tr>
			<tr style="%%GLOBAL_HideTabs%%">
				<td>
					<ul id="tabnav">
						<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_StorePages%%</a></li>
						<li><a href="#" id="tab1" onclick="ShowTab(1)">%%LNG_VendorPages%%</a></li>
					</ul>
				</td>
			</tr>
			<tr>
			<td>
				<div id="div0" style="display: %%GLOBAL_DisplayGrid%%">
					%%GLOBAL_NoPagesMessage%%
					<table class="GridPanel SortablePanel" cellspacing="0" cellpadding="0" border="0" style="width:100%; margin-top:10px">
						<tr class="Heading3">
							<td width="1" style="padding-left: 5px;">
								<input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)" style="vertical-align: middle;" />
							</td>
							<td>
								%%LNG_PageTitle%% &nbsp;
							</td>
							<td width="120">
								%%LNG_PageTypeHeading%% &nbsp;
							</td>
							<td width="80" align="center">
								%%LNG_Visible%% &nbsp;
							</td>
							<td width="80">
								%%LNG_Action%%
							</td>
						</tr>
					</table>
					<ul class="SortableList" id="PageList">
						%%GLOBAL_PageGrid%%
					</ul>
				</div>
				<div id="div1" style="display: none;">
					%%GLOBAL_NoVendorPagesMessage%%
					<table class="GridPanel SortablePanel" cellspacing="0" cellpadding="0" border="0" style="width:100%; margin-top:10px">
						<tr class="Heading3">
							<td width="1" style="padding-left: 5px;">
								<input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)" style="vertical-align: middle;" />
							</td>
							<td width="150">
								%%LNG_Vendor%% &nbsp;
							</td>
							<td>
								%%LNG_PageTitle%% &nbsp;
							</td>
							<td width="120">
								%%LNG_PageTypeHeading%% &nbsp;
							</td>
							<td width="80" align="center">
								%%LNG_Visible%% &nbsp;
							</td>
							<td width="80">
								%%LNG_Action%%
							</td>
						</tr>
					</table>
					<ul class="SortableList" id="VendorPageList">
						%%GLOBAL_VendorPagesGrid%%
					</ul>
				</div>
			</tr>
			</td>
		</table>
		<input type="hidden" name="currentTab" id="currentTab" value="%%GLOBAL_CurrentTab%%" />
				</form>
	</div>
	<script type="text/javascript" src="../javascript/jquery/plugins/interface.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/inestedsortable.js"></script>
	<script type="text/javascript">

		function CheckSearchForm()
		{
			var filter = document.getElementById("filterCategory");
			var query = document.getElementById("searchQuery");

			if(filter.value == "" && query.value == "")
			{
				alert("%%LNG_ChooseFilterOrEnterSearchTerm%%");
				return false;
			}

			return true;
		}

		function ConfirmDeleteSelected()
		{
			var fp = document.getElementById("frmPages").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeletePages%%"))
					document.getElementById("frmPages").submit();
			}
			else
			{
				alert("%%LNG_ChoosePages%%");
			}
		}

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmPages").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}

		function PreviewPage(PageId)
		{
			var l = screen.availWidth / 2 - 300;
			var t = screen.availHeight / 2 - 300;
			var win = window.open('index.php?ToDo=previewPage&pageId='+PageId, 'pagePreview', 'width=600,height=600,left='+l+',top='+t+',scrollbars=1');
		}

		var updatingSortables = false;
		var updateTimeout = null;
		function CreateSortableList() {
			$('#PageList').NestedSortable(
				{
					accept: 'SortableRow',
					noNestingClass: "no-nesting",
					opacity: .8,
					helperclass: 'SortableRowHelper',
					onChange: function(serialized) {
						updatingSortables = true;
						if(updateTimeout != null) window.clearTimeout(updateTimeout);
						$.ajax({
							url: 'remote.php?w=updatePageOrders',
							type: 'POST',
							dataType: 'xml',
							data: serialized[0].hash,
							success: function(response) {
								var status = $('status', response).text();
								var message = $('message', response).text();
								if(status == 0) {
									display_error('PagesStatus', message);
								}
								else {
									display_success('PagesStatus', message);
								}
								if(document.all) {
									// IE has problems here - it breaks on sortable lists so for now we just
									// refresh the current page
									window.location.reload();
								}
							}
						});
					},
					onStop: function() {
						if(document.all && updatingSortables == false) {
							// IE has problems here - it breaks on sortable lists so for now we just
							// refresh the current page
							updateTimeout = window.setTimeout(function() { window.location.reload(); }, 100);
						}
					},
					autoScroll: true,
					handle: '.sort-handle'
				}
			);
		}

		$(document).ready(function()
		{
			CreateSortableList();
		});

		function ShowTab(T)
		{
			i = 0;
			while (document.getElementById("tab" + i) != null) {
				document.getElementById("div" + i).style.display = "none";
				document.getElementById("tab" + i).className = "";
				i++;
			}

			document.getElementById("div" + T).style.display = "";
			document.getElementById("tab" + T).className = "active";
			document.getElementById("currentTab").value = T;
		}
	</script>

<style type="text/css">
</style>