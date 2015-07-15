<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(CheckForm)" id="frmTemplate" method="post">
%%GLOBAL_hiddenFields%%
<input id="currentTab" name="currentTab" value="0" type="hidden">
<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
	<tr>
		<td class="Heading1">%%GLOBAL_TemplateTitle%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%GLOBAL_ExportIntro%%</p>
			%%GLOBAL_Message%%
			<p style="%%GLOBAL_HideForm%%">
				<input type="submit" value="%%LNG_Continue%%" class="FormButton" />
				<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
			</p>
		</td>
	</tr>
	<tr>
		<td>
			<ul id="tabnav" style="%%GLOBAL_HideForm%%"">
				<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_ExportDetails%%</a></li>
				<li><a href="#" id="tab1" onclick="ShowTab(1)">%%LNG_DataSummary%%</a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<!--Template Details-->
			<div id="div0" style="padding-top: 10px; %%GLOBAL_HideForm%%">
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_ExportFormatTitle%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_TemplateLabel%%:
						</td>
						<td>
							%%GLOBAL_TemplatesList%%
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_ExportFileFormat%%:
						</td>
						<td>
							<table border="0">
								%%GLOBAL_Methods%%
							</table>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<p>
								<input type="submit" value="%%LNG_Continue%%" class="FormButton" />
								<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
							</p>
						</td>
					</tr>
				</table>
			</div>

			<div id="div1" style="padding-top: 5px; display: none;">
				<div class="GridContainer" id="GridContainer">
					%%GLOBAL_DataGrid%%
				</div>
			</div>
		</td>
	</tr>
	</table>
</div>
</form>

<script type="text/javascript">
	function ConfirmCancel()
	{
		if(confirm('%%LNG_CancelMessage%%'))
		{
			document.location.href='%%GLOBAL_ViewLink%%';
		}
		else
		{
			return false;
		}
	}

	function CheckForm() {
		if ($("#template").val() == "") {
			alert("%%LNG_NoTemplateSelected%%");

			return false;
		}

		return true;
	}

	function ShowTab(T) {
		i = 0;
		while (document.getElementById("tab" + i) != null) {
			$('#div'+i).hide();
			$('#tab'+i).removeClass('active');
			++i;
		}

		$('#div'+T).show();
		$('#tab'+T).addClass('active');
	}
</script>