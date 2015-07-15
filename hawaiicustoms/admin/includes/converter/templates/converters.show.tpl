	<div class="BodyContainer">
	<form action="index.php?ToDo=converter" onSubmit="return CheckForm(this)"  method="post">
	<table class="OuterPanel">
	<tr>
		<td class="Heading1">%%LNG_ImportStoreWizard%%</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td class="Intro">
					<div style="padding:5px 0px 5px 0px">
					%%LNG_ImportWizardImportersIntro%%
					</div>
				</td>
			</tr>
			<tr>
				<td class="Intro" style="padding-bottom:10px">
					<input type="button" value="%%LNG_Cancel%%" class="FormButton" onclick="window.location='index.php?ToDo=Converter';" />&nbsp;
					<input type="submit" value="%%LNG_Next%% &raquo;" class="FormButton" />
				</td>
			</tr>
			%%GLOBAL_Message%%
			</table>
		</td>
	</tr>
	<tr>
		<td>
		  <table class="Panel">
			<tr>
			  <td class="Heading2" colspan=2>%%LNG_ExistingStoreSoftware%%</td>
			</tr>
			<tr>
				<td class="FieldLabel">
					<span class="Required">*</span>&nbsp;%%LNG_CurrentStoreRunning%%:
				</td>
				<td class="PanelBottom">
					<select name="importer" id="ImportSoftware" size="5" onchange="changeImporter()" class="Field250">
						%%GLOBAL_ImporterList%%
					</select>
					<img onmouseout="HideHelp('importerhelp')" onmouseover="ShowHelp('importerhelp', '%%LNG_CurrentStoreRunning%%', '%%LNG_CurrentStoreRunningHelp%%')" src="images/help.gif" width="24" height="16" border="0" style="vertical-align: top;">
					<div style="display:none" id="importerhelp"></div>
					<br />
					<label><input type="checkbox" id="DeleteAll" name="DeleteAll" value="1" /> %%LNG_ConverterDeleteStoreMsg%%</label>
					<img onmouseout="HideHelp('importer2')" onmouseover="ShowHelp('importer2', '%%LNG_ConverterDeleteStoreMsg%%', '%%LNG_ConverterDeleteStoreHelp%%')" src="images/help.gif" width="24" height="16" border="0">
					<div style="display:none" id="importer2"></div>
				</td>
			</tr>
		  </table>
		  %%GLOBAL_ConfigurationList%%
			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
				<tr>
					<td class="FieldLabel">&nbsp;</td>
					<td>
						<input type="button" value="%%LNG_Cancel%%" class="FormButton" onclick="window.location='index.php?ToDo=Converter';" />&nbsp;
						<input type="submit" value="%%LNG_Next%% &raquo;" class="FormButton" />
					</td>
				</tr>
		 </table>
		</td>
	</tr>
	</table>
	</form>
	</div>
	<script type="text/javascript">
	function changeImporter() {
		var f = document.getElementById('ImportSoftware');
		$('.ImporterConfiguration').hide();
		if(f.selectedIndex == -1) {
			return;
		}
		var selected = f.options[f.selectedIndex];
		$("#"+selected.value+"Configure").show();
	}

	changeImporter();

	function CheckForm() {
		var f = document.getElementById('ImportSoftware');
		if(f.selectedIndex == -1)
		{
			alert('%%LNG_ErrorInvalidStore%%');
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

		if(g('DeleteAll').checked == true && !confirm('%%LNG_ConverterConfirmDeleteStore%%')) {
			return false;
		}

	}
	</script>

