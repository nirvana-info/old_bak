
	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ViewQualifierAssociations%%</td>
		</tr>
        <tr><td><div id="CategoriesStatus" style="margin-bottom: 10px;"></div></td></tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_QualifierAssociationIntro%%</p>
			%%GLOBAL_Message%%
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			<td class="Intro" valign="top">
				<!--<input type="button" name="IndexAddButton" value="%%LNG_AddQualifierAssociation%%" id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addQualifierAssociation'" />--> 
                &nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
			</td>
			<td class="SmallSearch" align="right">
				<!--<table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
				<tr>
					<form action="index.php?ToDo=viewQualifierAssociations%%GLOBAL_SortURL%%" method="get" onSubmit="return ValidateForm(CheckSearchForm)">
					<input type="hidden" name="ToDo" value="viewQualifierAssociations">
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
				</table>-->
                &nbsp;
			</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmQualifierAssociations" id="frmQualifierAssociations" method="post" action="index.php?ToDo=deleteQualifierAssociations">
				<div class="GridContainer">
					<!--%%GLOBAL_QualifierAssociationsDataGrid%%-->
                    %%GLOBAL_CategoryGrid%%   
				</div>
			</form>
		</td></tr>
	</table>
	</div>

	<script type="text/javascript">
         /*
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
			var fp = document.getElementById("frmQualifierAssociations").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteQualifierAssociations%%"))
					document.getElementById("frmQualifierAssociations").submit();
			}
			else
			{
				alert("%%LNG_ChooseQualifierAssociations%%");
			}
		}

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmQualifierAssociations").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}
        */
	</script>
