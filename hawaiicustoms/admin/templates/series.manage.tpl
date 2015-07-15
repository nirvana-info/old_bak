
	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ViewSeries%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_SeriesIntro%%</p>
			%%GLOBAL_Message%%
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			<td class="Intro" valign="top">
				<input type="button" name="IndexAddButton" value="%%LNG_AddSeries%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addSeries'" /> &nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
			</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmSeries" id="frmSeries" method="post" action="index.php?ToDo=deleteSeries">
				<div class="GridContainer">
					%%GLOBAL_SeriesDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>
	</div>

	<script type="text/javascript">

		//function CheckSearchForm()
//		{
//			var query = document.getElementById("searchQuery");

//			if(query.value == "")
//			{
//				alert("%%LNG_EnterSearchTerm%%");
//				return false;
//			}

//			return true;
//		}

		function ConfirmDeleteSelected()
		{
			var fp = document.getElementById("frmSeries").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteSeries%%"))
					document.getElementById("frmSeries").submit();
			}
			else
			{
				alert("%%LNG_ChooseSeries%%");
			}
		}

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmSeries").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}

	</script>
