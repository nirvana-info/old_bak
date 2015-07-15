	<form enctype="multipart/form-data" action="index.php?ToDo=importOrdertrackingnumbers&Step=3" id="frmImport" method="post" onsubmit="return ValidateForm(CheckImportOrdertrackingnumberForm)">
	<input type="hidden" name="ImportSession" value="%%GLOBAL_ImportSession%%" />
	<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_ImportOrdertrackingnumbersStep2%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_ImportOrdertrackingnumbersStep2Desc%%</p>
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
				  <td class="Heading2" colspan="2">%%LNG_ImportLinkFields%%</td>
				</tr>
				%%GLOBAL_ImportFieldList%%
			 </table>
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
		<script type="text/javascript">
		function ConfirmCancel()
		{
			if(confirm('%%LNG_ConfirmCancelImport%%'))
				window.location = 'index.php?ToDo=importOrdertrackingnumbers';
		}

		function CheckImportOrdertrackingnumberForm()
		{

			var o = document.getElementById('Matchordernumber');
			if(o.selectedIndex <= 0)
			{
				alert('%%LNG_NoMatchOrderNumber%%');
				o.focus();
				return false;
			}

			var t = document.getElementById('Matchordertrackingnumber');
			if(t.selectedIndex <= 0)
			{
				alert('%%LNG_NoMatchOrdertrackingnumber%%');
				t.focus();
				return false;
			}



			return true;
		}
		</script>
	</div>
</form>