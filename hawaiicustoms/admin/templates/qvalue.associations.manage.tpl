
	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ViewQValueAssociations%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_QValueAssociationIntro%%</p>
			%%GLOBAL_Message%%
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
                <tr style="height:40px;">
                   <td colspan="2">  
                        <div style="float:left;">
                            <!--<select name="precategory" id="precategory" class="Field200" onchange="loadPreQualifiers(this.value);">
                                %%GLOBAL_PreCategoryOptions%%
                            </select>-->
                            <select size="1" name="precategory" id="precategory" class="Field200" style="height:115" onchange="loadPreQualifiers(this.value)">
                                %%GLOBAL_PreCategoryOptions%%
                            </select> 
                        </div> 
                        <div style="float:left;">
                            <div id="prequalifiers">                                                                        
                                 %%GLOBAL_QualifierOptions%%&nbsp;&nbsp;&nbsp;
                            <div> 
                        </div>
                   <td>
                </tr>
			        <tr>
			            <td class="Intro" valign="top">
				            <input type="button" name="IndexAddButton" value="%%LNG_AddQValueAssociation%%" id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addQValueAssociation'" /> 
                            &nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
			            </td>
			            <td class="SmallSearch" align="right">
				            <!--
                            <table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
				            <tr>
					            <form action="index.php?ToDo=viewQValueAssociations%%GLOBAL_SortURL%%" method="get" onSubmit="return ValidateForm(CheckSearchForm)">
					            <input type="hidden" name="ToDo" value="viewQValueAssociations">
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
                            -->
                            &nbsp;
			            </td>
			        </tr>
			    </table>
		    </td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmQValueAssociations" id="frmQValueAssociations" method="post" action="index.php?ToDo=deleteQValueAssociations">
				<div class="GridContainer">
					%%GLOBAL_QValueAssociationsDataGrid%%
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
			var fp = document.getElementById("frmQValueAssociations").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteQValueAssociations%%"))
					document.getElementById("frmQValueAssociations").submit();
			}
			else
			{
				alert("%%LNG_ChooseQValueAssociations%%");
			}
		}

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmQValueAssociations").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}

        function loadPreQualifiers(catid)   
        {
             $('#prequalifiers').load("index.php?ToDo=loadQualifiersQValueAssociations&catid="+catid);
        }
        function loadResults(qualifierid)
        {
             var catid = document.getElementById('precategory').value;  
             $('.GridContainer').load("index.php?ToDo=viewQValueAssociations&precategoryid="+catid+'&prequalifierid='+qualifierid+'&ajax=1', '', function() {
                BindAjaxGridSorting();
            }); 
        }
        */
	</script>
