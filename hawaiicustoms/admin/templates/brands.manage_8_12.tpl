
	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ViewBrands%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_BrandIntro%%</p>
			%%GLOBAL_Message%%
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			<td class="Intro" valign="top">
				<input type="button" name="IndexAddButton" value="%%LNG_AddBrand%%" id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addBrand'" /> &nbsp; <input type="button" name="SeriesAddButton" value="%%LNG_AddaSeries%%" id="SeriesCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addbrandseries'" /> &nbsp; <input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
			</td>
			<td class="SmallSearch" align="right">
				<table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
				<tr>
					<form action="index.php?ToDo=viewBrands%%GLOBAL_SortURL%%" method="get" onSubmit="return ValidateForm(CheckSearchForm)">
					<input type="hidden" name="ToDo" value="viewBrands">
					<td nowrap>
						<input name="searchQuery" id="searchQuery" type="text" value="%%GLOBAL_Query%%" id="SearchQuery" class="Button" size="20" />&nbsp;
						<input type="image" name="SearchButton" style="padding-left: 10px; vertical-align: top;" id="SearchButton" src="images/searchicon.gif" border="0" />
					</td>
					</form>
				</tr>
				<tr>
					<td align="right" style="padding-right:55pt">
						%%GLOBAL_ClearSearchLink%%
					</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				</table>
			</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmBrands" id="frmBrands" method="post" action="index.php?ToDo=deleteBrands">
				<div class="GridContainer">
					%%GLOBAL_BrandsDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>
	</div>

	<script type="text/javascript">

		function CheckSearchForm()
		{
			var query = document.getElementById("searchQuery");

			if(query.value == "")
			{
				alert("%%LNG_EnterSearchTerm%%");
				return false;
			}

			return true;
		}

		function ConfirmDeleteSelected()
		{
			var fp = document.getElementById("frmBrands").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteBrands%%"))
					document.getElementById("frmBrands").submit();
			}
			else
			{
				alert("%%LNG_ChooseBrands%%");
			}
		}

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmBrands").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}
        
/* To display and hide the series Baskaran */
        function display(id) {
            var e = document.getElementById(id); 
            var p = document.getElementById('p'+id);
            var m = document.getElementById('m'+id);
            if(e.style.display == 'none')  {
              e.style.display = '';
              p.style.display = 'none';
              m.style.display = '';
           }
           else {
              e.style.display = 'none';
              p.style.display = '';
              m.style.display = 'none';
           }
        }
	</script>
