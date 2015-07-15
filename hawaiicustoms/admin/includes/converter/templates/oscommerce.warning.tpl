	<div class="BodyContainer">
	<form action="index.php?ToDo=converter"  method="post">
	<table class="OuterPanel">
	<tr>
		<td class="Heading1">%%LNG_OsCommerceImportTitle%%</td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td class="Intro">
					<div style="padding:5px 0px 5px 0px">
					%%LNG_OsCommerceWarningIntro%%
					</div>
				</td>
			</tr>
			<tr>
				<td class="Intro" style="padding-bottom:10px">
					<input type="button" value="%%LNG_Cancel%%" class="FormButton" onclick="window.location='index.php?ToDo=cancelConverter';" />&nbsp;
					<input type="submit" value="%%LNG_Next%% &raquo;" class="NextButton FormButton" disabled="disabled" />
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
			  <td class="Heading2">%%LNG_OsCommerceWarningTitle%%</td>
			</tr>
			<tr>
				<td class="FieldLabel"><label><input type="checkbox" style="vertical-align: middle" />&nbsp;&nbsp;%%LNG_OsCommerceWarning1%%</label></td>
			</tr>
			<tr>
				<td class="FieldLabel PanelBottom"><label><input type="checkbox" style="vertical-align: middle" />&nbsp;&nbsp;%%LNG_OsCommerceWarning2%%</label></td>
			</tr>
			<table class="PanelPlain">
				<tr>
					<td class="FieldLabel" style="width: 40px; padding: 0 0 0 6px;">&nbsp;</td>
					<td>
						<input type="button" value="%%LNG_Cancel%%" class="FormButton" onclick="window.location='index.php?ToDo=cancelConverter';" />&nbsp;
						<input type="submit" value="%%LNG_Next%% &raquo;" class="NextButton FormButton" disabled="disabled" />
						<input type="hidden" name="WarningAccept" value="1" />
					</td>
				</tr>
				<tr><td class="Gap"></td></tr>
		 </table>
		</td>
	</tr>
	</table>
	</form>
	</div>
	<script type="text/javascript">
	$(document).ready(function() {
		$('input[type=checkbox]').click(function() {
			if($('input[type=checkbox]').length == $('input[type=checkbox]:checked').length) {
				$('.NextButton').attr('disabled', false);
			}
			else {
				$('.NextButton').attr('disabled', true);
			}
		});
	});
	</script>

