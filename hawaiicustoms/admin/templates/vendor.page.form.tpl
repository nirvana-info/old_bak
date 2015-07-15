<form action="index.php?ToDo=%%GLOBAL_FormAction%%" id="frmPage" method="post" onsubmit="return ValidateForm(CheckPageForm)">
	<input type="hidden" name="vendorId" id="vendorId" value="%%GLOBAL_VendorId%%" />
	<input type="hidden" name="pageId" id="pageId" value="%%GLOBAL_PageId%%" />
<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1">%%GLOBAL_Title%%</td>
		</tr>

		<tr>
			<td class="Intro">
				<p>%%GLOBAL_Intro%%</p>
				%%GLOBAL_Message%%
				<p>
					<input type="submit" name="SaveButton1" value="%%LNG_Save%%" class="FormButton" />&nbsp;
					<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				</p>
			</td>
		</tr>

		<tr>
			<td>
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_PageSettings%%</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span> %%LNG_PageTitle%%:
						</td>
						<td>
							<input type="text" name="pagetitle" id="pagetitle" class="Field250" value="%%GLOBAL_PageTitle%%" />
							<img onmouseout="HideHelp('pagetitlehelp');" onmouseover="ShowHelp('pagetitlehelp', '%%LNG_PageTitle%%', '%%LNG_PageTitleHelp%%')" src="images/help.gif" alt="" border="0" />
							<div style="display:none" id="pagetitlehelp"></div>
						</td>
					</tr>

					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_NavigationMenu%%:
						</td>
						<td>
							<input type="checkbox" id="pagevisible" name="pagevisible" value="1" %%GLOBAL_Visible%%> <label for="pagevisible">%%LNG_YesPageVisible%%</label>
							<img onmouseout="HideHelp('d6');" onmouseover="ShowHelp('d6', '%%LNG_NavigationMenu%%', '%%LNG_PageNavigationMenuHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d6"></div><br />
						</td>
					</tr>
				</table>
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_PageContent%%</td>
					</tr>
					<tr>
						<td colspan="2">%%GLOBAL_WYSIWYG%%</td>
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
				<tr>
					<td>
						<input type="submit" name="SaveButton2" value="%%LNG_Save%%" class="FormButton" />&nbsp;
						<input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
</div>
</form>
<script type="text/javascript">
	function ChecPageForm()
	{
		if(!$('#pagetitle').val()) {
			alert('%%LNG_EnterPageTitle%%');
			$('#pagetitle').focus();
			return false;
		}

		if(g('wysiwyg')) {
			var content = g('wysiwyg').value;
		}
		else if(g('wysiwyg_html')) {
			var content = g('wysiwyg_html').value;
		}

		if(IsWysiwygEditorEmpty(content)) {
			alert("%%LNG_EnterPageContent%%");
			return false;
		}
		return true;
	}


	function ConfirmCancel()
	{
		if(confirm('%%LNG_ConfirmCancel%%')) {
			window.location = 'index.php?ToDo=editVendor&vendorId=%%GLOBAL_VendorId%%&currentTab=1';
		}

		return false;
	}
</script>