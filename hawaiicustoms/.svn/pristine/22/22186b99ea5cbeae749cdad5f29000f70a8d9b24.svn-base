	<div class="BodyContainer">
		<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ImportCustomersStep3%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_ImportCustomersStep3Desc%%
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" value="%%LNG_StartImport%%" id="StartImport" onclick="startImport(); return false;" class="FormButton" />
			</td>
		</tr>
		</table>
	</div>
	<script type="text/javascript">
		function ConfirmCancel()
		{
			if(confirm('%%LNG_ConfirmCancelImport%%'))
				window.location = 'index.php?ToDo=importCustomers';
		}

		function startImport()
		{
			tb_show('', 'index.php?ToDo=importCustomers&Step=ImportFrame&ImportSession=%%GLOBAL_ImportSession%%&keepThis=true&TB_iframe=tue&height=240&width=400&modal=true', '');
			document.getElementById('StartImport').disabled = true;
			document.getElementById('StartImport').value = '%%LNG_ImportRunning%%';
		}
	</script>