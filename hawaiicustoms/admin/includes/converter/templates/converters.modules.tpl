	<div class="BodyContainer">
	<table class="OuterPanel">
	<tr>
		<td class="Heading1">%%GLOBAL_ImportTitle%%</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td class="Intro">
					<div>
					%%LNG_ImportWizardModulesIntro%%
					</div>
				</td>
			</tr>
			%%GLOBAL_Message%%
			<tr>
				<td class="Intro" style="padding: 0px">
					<input type="button" onclick="ConfirmCancel();" value="%%LNG_CancelImport%%" class="Button" style="display: %%GLOBAL_HideCancelButton%%; width: 110px;" />
					<input type="button" onclick="ConfirmRollback();" value="%%LNG_RollbackImport%%" class="Button" style="display: %%GLOBAL_HideRollbackButton%%" />
					<input type="button" onclick="ImporterCleanup();" value="%%LNG_IveFinishedImporting%%" class="Button" style="display: %%GLOBAL_HideRollbackButton%%" />
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table class="Panel">
				  <table class="Panel" style="display: %%GLOBAL_HideImportOptions%%">
					<tr>
					  <td class="Heading2" colspan=2>%%LNG_ImportOptions%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_ImportWhat%%?
						</td>
						<td>
							<label><input type="radio" name="import" id="ImportEntire" onclick="$('#ImportModules').hide(); $('#RunAllButton').show();" %%GLOBAL_ImportAllChecked%% /> %%LNG_ImportEntireStore%%</label>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">&nbsp;</td>
						<td>
							<label><input type="radio" name="import" onclick="$('#ImportModules').show(); $('#RunAllButton').hide();"  %%GLOBAL_ImportPartChecked%%/> %%LNG_ImportCertainParts%%</label>
						</td>
					</tr>
				</table>

				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain" id="RunAllButton" style="display: %%GLOBAL_HideRunAll%%">
					<tr>
						<td class="FieldLabel">&nbsp;</td>
						<td>
							<input type="button" value="%%LNG_Next%% &raquo;" class="FormButton" onclick="RunAllModules();" />
						</td>
					</tr>
				</table>
				<div id="ImportModules" style="display: none;">
				<br style="display: %%GLOBAL_HideImportOptions%%" />
						<div id="MessageBox" style="display: %%GLOBAL_HideImportOptions%%">
							<table border="0" cellspacing="0" cellpadding="0">
								<tr>
								<td class="Message" width="20">
									<img src="images/info.gif" width="18" height="18" hspace="10" vspace="5" alt="">
								</td>
								<td class="Message" width="100%">
									%%LNG_ImportCertainPartsIntro%%
								</td>

								</tr>
							</table>
						</div>
							<table class="GridPanel" cellspacing="1" cellpadding="2" border="0">
							<tr class="Heading2">
								<td style="width: 20px;">
									&nbsp;
								</td>
								<td>
									%%GLOBAL_ModuleHeader%%
								</td>
								<td style="width: 150px;">
									%%LNG_DateRun%%
								</td>
								<td align="center">
									%%LNG_Status%%
								</td>
								<td style="width:150px">
									%%LNG_Action%%
								</td>
							</tr>
							%%GLOBAL_ModuleList%%
							</table>
		</td>
	</tr>
	</table>
	</div>
	<script type="text/javascript">
		function ToggleType() {
			if(g('ImportEntire').checked == true) {
				$('#ImportModules').hide();
				$('#RunAllButton').show();
			}
			else {
				$('#ImportModules').show();
				$('#RunAllButton').hide();
			}
		}
		ToggleType();

		function RunAllModules() {
			if(confirm('%%LNG_ConfirmRunAllModules%%')) {
				tb_show('', 'index.php?ToDo=showConverterFrame&module=all&keepThis=true&TB_iframe=tue&height=230&width=400&modal=true&random='+new Date().getTime(), '');
			}
		}

		function RunImportModule(module) {
			tb_show('', 'index.php?ToDo=showConverterFrame&module='+module+'&keepThis=true&TB_iframe=tue&height=230&width=400&modal=true&random='+new Date().getTime(), '');
		}

		function ImporterCleanup() {
			if(confirm('%%LNG_ConfirmIveFinishedImporting%%')) {
				window.location = 'index.php?ToDo=converterCleanup&random='+new Date().getTime();
			}
		}

		function ConfirmRollback()
		{
			if(confirm('%%LNG_ConfirmRollbackImporter%%')) {
				window.location = 'index.php?ToDo=cancelConverter&random='+new Date().getTime();
			}
		}

		function ConfirmCancel()
		{
			if(confirm('%%LNG_ConfirmCancelImporter%%')) {
				window.location = 'index.php?ToDo=cancelConverter&random='+new Date().getTime();
			}
		}

		function ShowReport(module) {
			tb_show('', 'index.php?ToDo=showConverterReport&module='+module+'&keepThis=true&TB_iframe=tue&height=230&width=470&modal=true&random='+new Date().getTime(), '');
		}
	</script>