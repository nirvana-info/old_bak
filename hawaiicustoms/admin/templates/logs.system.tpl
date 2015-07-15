	<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%">
	<tr>
		<td class="Heading1">%%LNG_StoreLogs%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>
				%%LNG_StoreLogsIntro%%
			</p>
			%%GLOBAL_Message%%
		</td>
	</tr>
	<tr>
		<td>
			<ul id="tabnav" style="display: %%GLOBAL_HideTabs%%">
				<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)" style="display: %%GLOBAL_HideSystemLog%%">%%LNG_SystemLog%%</a></li>
				<li><a href="#" id="tab1" onclick="ShowTab(1)" style="display: %%GLOBAL_HideAdminLog%%">%%LNG_AdministratorLog%%</a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<div id="div0" style="padding-top: 10px; display: %%GLOBAL_HideSystemLog%%">
				<table class="IntroTable">
					<tr>
						<td class="Intro" style="padding-bottom: 10px;">
							%%LNG_SystemLogIntro%%
						</td>
					</tr>
				</table>
				<div class="GridContainer" id="systemLogGrid">
					%%GLOBAL_SystemLog%%
				</div>
			</div>

			<div id="div1" style="padding-top: 10px; display: %%GLOBAL_HideAdminLog%%">
				<table class="IntroTable">
					<tr>
						<td class="Intro" style="padding-bottom: 10px;">
							%%LNG_AdminLogIntro%%
						</td>
					</tr>
				</table>
				<div class="GridContainer" id="administratorLogGrid">
					%%GLOBAL_AdministratorLog%%
				</div>
			</div>
		</td>
	</tr>
	</table>
	</div>

	<script type="text/javascript">
	function ShowLogInfo(id)
	{
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

			$(trQ).find('.QuickView').load('remote.php?w=logInfoQuickView&logid='+id, {}, function() {
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

	function ShowTab(T) {

		i = 0;

		while (document.getElementById("tab" + i) != null) {
			document.getElementById("div" + i).style.display = "none";
			document.getElementById("tab" + i).className = "";
			i++;
		}

		document.getElementById("div" + T).style.display = "";
		document.getElementById("tab" + T).className = "active";
		$('#CurrentTab1').val(T);
		$('#CurrentTab2').val(T);
	}

	$(document).ready(function() {
		if($('#div%%GLOBAL_CurrentTab%%').css('display') != "none") {
			ShowTab(%%GLOBAL_CurrentTab%%);
		}
	});

	function ConfirmDeleteSelectedAdmin() {
		if($('.DeleteCheck:checked').length == 0) {
			alert('%%LNG_ChooseLogEntry%%');
		}
		else {
			if(confirm('%%LNG_ConfirmDeleteLogEntries%%')) {
				g('AdminLogForm').action = g('LogForm').action.replace('systemLog', 'deleteAdminLogs');
				g('AdminLogForm').method = 'post';
				g('AdminLogForm').submit();
			}
		}
	}

	function ConfirmDeleteAllAdmin() {
		if(confirm('%%LNG_ConfirmDeleteAllAdminLogEntries%%')) {
			g('AdminLogForm').action = g('AdminLogForm').action.replace('systemLog', 'deleteAllAdminLogs');
			g('AdminLogForm').method = 'post';
			g('AdminLogForm').submit();
		}
	}

	function SearchAdminLog(f) {
		$(f).parents('.GridContainer').load($('#AdminSortURL').val()+'&'+$('#AdminLogForm').serialize(), '', function() {
			BindAjaxGridSorting();
		});
		return false;
	}

	function ClearAdminResults(f) {
		$(f).parents('.GridContainer').load($('#AdminSortURL').val(), '', function() {
			BindAjaxGridSorting();
		});
		return false;
	}

	function ConfirmDeleteSelected() {
		if($('.DeleteCheck:checked').length == 0) {
			alert('%%LNG_ChooseLogEntry%%');
		}
		else {
			if(confirm('%%LNG_ConfirmDeleteLogEntries%%')) {
				g('LogForm').action = g('LogForm').action.replace('systemLog', 'deleteSystemLogs');
				g('LogForm').method = 'post';
				g('LogForm').submit();
			}
		}
	}

	function ConfirmDeleteAll() {
		if(confirm('%%LNG_ConfirmDeleteAllSystemLogEntries%%')) {
			g('LogForm').action = g('LogForm').action.replace('systemLog', 'deleteAllSystemLogs');
			g('LogForm').method = 'post';
			g('LogForm').submit();
		}
	}

	function SearchSystemLog(f) {
		searchURL = '';
		if($('#logSeverity').val() > 0) {
			searchURL += '&logseverity='+$('#logSeverity').val();
		}

		if($('#logType').val() != "" && $('#logType').val() != -1) {
			searchURL += '&logtype='+$('#logType').val();
		}

		if($('#logSummary').val() != "") {
			searchURL += '&logsummary='+escape($('#logSummary').val());
		}

		$(f).parents('.GridContainer').load($('#SortURL').val()+searchURL, '', function() {
			BindAjaxGridSorting();
		});
		return false;
	}

	function ClearSystemResults(f) {
		$(f).parents('.GridContainer').load($('#SortURL').val(), '', function() {
			BindAjaxGridSorting();
		});
		return false;
	}

	function ClearAdminSearchResults(f) {
		$(f).parents('.GridContainer').load($('#AdminSortURL').val(), '', function() {
			BindAjaxGridSorting();
		});
		return false;
	}
	</script>