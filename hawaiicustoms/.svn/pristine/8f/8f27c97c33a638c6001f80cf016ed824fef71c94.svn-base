	<form enctype="multipart/form-data" action="index.php?ToDo=importProducts&Step=2" onsubmit="return ValidateForm(CheckImportProductForm)" id="frmImport" method="post">
	<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_ImportProductsStep1%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_ImportProductsStep1Desc%%</p>
				%%GLOBAL_Message%%
			</td>
		</tr>
		<tr>
			<td>
				<div>
					<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
					<input type="submit" value="%%LNG_Next%% &raquo;" class="FormButton" />
				</div>
				<br />
			</td>
		</tr>

		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_ImportDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ImportProductsCategory%%:
					</td>
					<td>
						<div>
							<label><input type="checkbox" name="AutoCategory" value="1" onclick="ToggleCategory();" id="AutoCategoryCheck" %%GLOBAL_AutoCategoryChecked%% /> %%LNG_AutoDetectCategories%%</label>
						</div>
						<div id="ManualCategory" style="display:none; padding-top: 5px; padding-left: 25px;">
							<div style="display:%%GLOBAL_HideCategorySelect%%">
								<select name="CategoryId" id="CategoryId" class="Field250">
									<option value="">%%LNG_ChooseACategory%%</option>
									%%GLOBAL_CategoryOptions%%
								</select>
								<img onmouseout="HideHelp('a1');" onmouseover="ShowHelp('a1', '%%LNG_ImportProductsCategory%%', '%%LNG_ImportProductsCategoryDesc%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display: none;" id="a1"></div>
							</div>

							<div style="display:%%GLOBAL_HideCategoryTextbox%%" id="HideCategoryBox">
								<input type="text" name="CategoryName" id="CategoryName" class="Field250" />
								<img onmouseout="HideHelp('b1');" onmouseover="ShowHelp('b1', '%%LNG_ImportProductsCategory%%', '%%LNG_ImportProductsCategoryCreateDesc%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display: none;" id="b1"></div>
							</div>
						</div>
					</td>
				</tr>

<tr>
<td class="FieldLabel">
	<span class="Required">&nbsp;</span>%%LNG_ImportOverride%%
</td>
<td>
	<label><input type="checkbox" name="OverrideDuplicates" value="1" onclick="if(this.checked){$('#OOV_1').attr('disabled', false);$('#OOV_2').attr('disabled', false);}else{$('#OOV_1').attr('disabled', true);$('#OOV_2').attr('disabled', true);}" /> %%LNG_YesImportOverride%%</label>
	<img onmouseout="HideHelp('a2');" onmouseover="ShowHelp('a2', '%%LNG_ImportOverride%%', '%%LNG_ImportOverrideDesc%%')" src="images/help.gif" width="24" height="16" border="0">
	<div style="display:none" id="a2"></div><br />

%%GLOBAL_UpdateExistDataOptions%%

</td>
</tr>

<tr>
		<td class="FieldLabel">
			%%LNG_RestrictCategory%%:
		</td>
		<td>
			<div>
				<label><input type="checkbox" name="PreCategory" value="1" onclick="ToggleCategory2();" id="ResCategoryCheck"  /> %%LNG_RestrictCategories%%</label>
			</div>
			<div id="ResCategory" style="display:none; padding-top: 5px; padding-left: 25px;">
				
							<select size="5" id="category" name="pre_category[]" class="Field400 ISSelectReplacement" multiple="multiple" style="height: 140px;">
							%%GLOBAL_CategoryOptions%%
							</select>
							<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_Categories%%', '%%LNG_ProductCategoriesHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d3"></div>
						
			</div>
		</td>
	</tr>


<tr>
<td class="FieldLabel">
	<span class="Required">&nbsp;</span>%%LNG_Importastest%%
</td>
<td>
	<label><input type="checkbox" name="Importastest" value="1" /> %%LNG_YesImportastest%%</label>
	<img onmouseout="HideHelp('a5');" onmouseover="ShowHelp('a5', '%%LNG_Importastest%%', '%%LNG_ImportastestDesc%%')" src="images/help.gif" width="24" height="16" border="0">
	<div style="display:none" id="a5"></div>
</td>
</tr>
			</table>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_ImportFileDetails%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ImportFile%%:
					</td>
					<td>
						<div>
							<label><input id="ProductImportUseUpload" type="radio" name="useserver" value="0" checked="checked" onclick="ToggleSource();" /> %%LNG_ImportFileUpload%% %%LNG_ImportMaxSize%%</label>
							<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_ImportFileUpload%%', '%%LNG_ImportFileUploadDesc%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display: none;" id="d1"></div>
						</div>
						<div id="ProductImportUploadField" style="margin-left: 25px;">
							<input type="file" name="importfile" id="ImportFile" class="Field250" />
						</div>

						<div>
							<label><input id="ProductImportUseServer" type="radio" name="useserver" value="1" onclick="ToggleSource();" /> %%LNG_ImportFileServer%%</label>
							<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_ImportFileServer%%', '%%LNG_ImportFileServerDesc%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display: none;" id="d2"></div>
						</div>
						<div id="ProductImportServerField" style="margin-left: 25px; display: none;">
							<select name="serverfile" id="ServerFile" class="Field250">
								<option value="">%%LNG_ImportChooseFile%%</option>
								%%GLOBAL_ServerFiles%%
							</select>
						</div>
						<div id="ProductImportServerNoList" style="margin: 5px 0 0 25px; display: none; font-style: italic;" class="Field250">
							%%LNG_FieldNoServerFiles%%
						</div>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ImportContainsHeaders%%
					</td>
					<td>
						<label><input type="checkbox" name="Headers" value="1" checked /> %%LNG_YesImportContainsHeaders%%</label>
						<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_ImportContainsHeaders%%', '%%LNG_ImportContainsHeadersDesc%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d3"></div>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ImportFieldSeparator%%:
					</td>
					<td>
						<input type="text" name="FieldSeparator" id="FieldSeparator" class="Field250" value="%%GLOBAL_FieldSeparator%%" />
						<img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_ImportFieldSeparator%%', '%%LNG_ImportFieldSeparatorDesc%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d4"></div>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ImportFieldEnclosure%%:
					</td>
					<td>
						<input type="text" name="FieldEnclosure" id="FieldEnclosure" class="Field250" value='%%GLOBAL_FieldEnclosure%%' />
						<img onmouseout="HideHelp('d5');" onmouseover="ShowHelp('d5', '%%LNG_ImportFieldEnclosure%%', '%%LNG_ImportFieldEnclosureDesc%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d5"></div>
					</td>
				</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
				<tr>
					<td width="200" class="FieldLabel">
						&nbsp;
					</td>
					<td>
						<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
						<input type="submit" value="%%LNG_Next%% &raquo;" class="FormButton" />
					</td>
				</tr>
			</table>
			</td>
		</tr>
		</table>
	</div>
	</form>

	<script type="text/javascript">
	function ConfirmCancel()
	{
		if(confirm('%%LNG_ConfirmCancelImport%%'))
			window.location = 'index.php?ToDo=manageProducts';
	}

	function ToggleCategory()
	{
		var e = document.getElementById('AutoCategoryCheck');
		if(e.checked == true)
		{
			document.getElementById('ManualCategory').style.display = 'none';
		}
		else
		{
			document.getElementById('ManualCategory').style.display = '';
		}
	}
	ToggleCategory();

	function ToggleCategory2()
	{
		var e = document.getElementById('ResCategoryCheck');
		if(e.checked == false)
		{
			document.getElementById('ResCategory').style.display = 'none';
		}
		else
		{
			document.getElementById('ResCategory').style.display = '';
		}
	}


	function CheckImportProductForm()
	{

		var f= document.getElementById('AutoCategoryCheck');
		if(f.checked != true)
		{
			if(document.getElementById('HideCategoryBox').style.display == "none")
			{
				var f = document.getElementById('CategoryId');
				if(f.selectedIndex < 1)
				{
					alert('%%LNG_NoSelectedCategoryName%%');
					f.focus();
					return false;
				}
			}
			else
			{
				var f = document.getElementById('CategoryName');
				if(f.value == '')
				{
					alert('%%LNG_NoCategoryName%%');
					f.focus();
					return false;
				}
			}
		}
		var f = document.getElementById('ProductImportUseUpload');
		if(f.checked == true)
		{
			var f = document.getElementById('ImportFile');
			if(f.value == '')
			{
				alert('%%LNG_NoImportFile%%');
				f.focus();
				return false;
			}
		}
		else
		{
			var f = document.getElementById('ServerFile');
			if(f.value < 1)
			{
				alert('%%LNG_NoImportFile%%');
				f.focus();
				return false;
			}
		}

		var f = document.getElementById('FieldSeparator');
		if(f.value == '')
		{
			alert('%%LNG_NoImportFieldSeparator%%');
			f.focus();
			return false;
		}

		var f = document.getElementById('FieldEnclosure');
		if(f.value == '')
		{
			alert('%%LNG_NoImportFieldEnclosure%%');
			f.focus();
			return false;
		}
		return true;
	}

	function ToggleSource()
	{
		var file = document.getElementById('ProductImportUseUpload');
		if(file.checked == true)
		{
			document.getElementById('ProductImportUploadField').style.display = '';
			document.getElementById('ProductImportServerField').style.display = 'none';
			document.getElementById('ProductImportServerNoList').style.display = 'none';
		}
		else
		{
			document.getElementById('ProductImportUploadField').style.display = 'none';
			if(document.getElementById('ProductImportServerField').getElementsByTagName('SELECT')[0].options.length == 1)
			{
				document.getElementById('ProductImportServerNoList').style.display = '';
			}
			else
			{
				document.getElementById('ProductImportServerField').style.display = '';
			}
		}
	}
	</script>