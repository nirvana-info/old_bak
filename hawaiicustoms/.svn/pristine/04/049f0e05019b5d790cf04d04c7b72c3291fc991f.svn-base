	<div class="BodyContainer">
	<table class="OuterPanel">
	<tr>
		<td class="Heading1">%%LNG_ExportStoreWizard%%</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td class="Intro">
					<div>
					%%LNG_ExportWizardExportersIntro%%
					</div>
				</td>
			</tr>
			<tr>
				<td class="Intro" style="padding-bottom:10px">
					<input type="button" value="%%LNG_Cancel%%" class="FormButton" onclick="window.location='index.php?ToDo=Exporter';" />&nbsp;
					<input type="submit" value="%%LNG_Next%% &raquo;" class="FormButton" />
				</td>
			</tr>
			%%GLOBAL_Message%%
			</table>
		</td>
	</tr>
	<tr>
		<td>
		<form action="index.php?ToDo=exporter" onSubmit="return CheckForm(this)"  method="post">
		  <table class="Panel">
			<tr>
			  <td class="Heading2" colspan=2>%%LNG_ExportThirdPartySoftware%%</td>
			</tr>
			<tr>
				<td class="FieldLabel">
					<span class="Required">*</span>&nbsp;%%LNG_ExportStoreTo%%:
				</td>
				<td class="PanelBottom">
					<select name="exporter" id="ExportSoftware" size="5" onchange="changeExporter()" class="Field250">
						%%GLOBAL_ExporterList%%
					</select>
					<img onmouseout="HideHelp('exporterHelp')" onmouseover="ShowHelp('exporterHelp', '%%LNG_ExportStoreTo%%', '%%LNG_ExportStoreToHelp%%')" src="images/help.gif" width="24" height="16" border="0" style="vertical-align: top;">
					<div style="display:none" id="exporterHelp"></div>
				</td>
			</tr>
		  </table>
		  %%GLOBAL_ConfigurationList%%
			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
				<tr>
					<td class="FieldLabel">&nbsp;</td>
					<td>
						<input type="button" value="%%LNG_Cancel%%" class="FormButton" onclick="window.location='index.php?ToDo=Exporter';" />&nbsp;
						<input type="submit" value="%%LNG_Next%% &raquo;" class="FormButton" />
					</td>
				</tr>
		 </table>
		</form>
		</td>
	</tr>
	</table>
	</div>
	<script type="text/javascript">
	function changeExporter() {
		var f = document.getElementById('ExportSoftware');
		$('.ExporterConfiguration').hide();
		if(f.selectedIndex == -1) {
			return;
		}
		var selected = f.options[f.selectedIndex];
		$("#"+selected.value+"Configure").show();
	}

	changeExporter();

	function CheckForm() {
		var f = document.getElementById('ExportSoftware');
		if(f.selectedIndex == -1)
		{
			alert('%%LNG_ErrorInvalidExportStore%%');
			f.focus();
			return false;
		}
		var selected = f.options[f.selectedIndex].value;

		try
		{
			validator = selected+'CheckForm';
			func = eval(validator+'();');
			if(func == false) return false;
		}
		catch(e)
		{
		}
	}
	</script>

