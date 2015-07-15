
	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_FileManagement%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_FileManagementIntro%%</p>
			%%GLOBAL_Message%%
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			    <td class="Intro" valign="top">
				    <input type="button" name="IndexDownloadButton" value="%%LNG_Download%%" id="IndexDownloadButton" class="SmallButton" onclick="ConfirmDownloadSelected()" %%GLOBAL_DownloadFile%% />
			    </td>
			    <td class="SmallSearch" align="right">
				    <!--<table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
				    <tr>
					    <form action="index.php?ToDo=viewFileManagements%%GLOBAL_SortURL%%" method="get" onSubmit="return ValidateForm(CheckSearchForm)">
					    <input type="hidden" name="ToDo" value="viewFiles">
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
            <td>
                <ul id="tabnav">
                    <!--<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_ProductDetails%%</a></li>-->
                    %%GLOBAL_TabTitle%%
                </ul>
            </td>
        </tr>
		<tr>
		    <td style="display: %%GLOBAL_DisplayGrid%%">
			    <form name="frmFiles" id="frmFiles" method="post" action="index.php?ToDo=telechargerFilesFilemanagement">
                    <input id="currentTab" name="currentTab" value="0" type="hidden">
                    <input id="currentFileType" name="currentFileType" value="product_videos" type="hidden">  
				    <div class="GridContainer">
					    %%GLOBAL_FilesDataGrid%%
				    </div>
			    </form>
		    </td>
        </tr>
        <!-- Above Commented code is for model -->   
         
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

        function ShowTab(T)
        {
                AllFileTypes = new Array(%%GLOBAL_AllFileTypes%%);
                i = 0;
                while (document.getElementById("tab" + i) != null) {
                    $('#div'+i).hide();     
                    $('#tab'+i).removeClass('active');            
                    ++i;
                }
                
                $('#div'+T).show();
                $('#tab'+T).addClass('active');
                $('#currentTab').val(T);
                document.getElementById("currentTab").value = T;
                document.getElementById("currentFileType").value = AllFileTypes[T];  
        }

		function ConfirmDownloadSelected()
		{
			//var fp = document.getElementById("frmFiles").elements;
			var c = 0;

			/*for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}*/
            
            var FileType = document.getElementById("currentFileType").value;
            
            var form_object =  document.getElementById('frmFiles'); 
            
            if(form_object[FileType+'_files[]'].length != undefined)    {
                
                for(var i=0; i<form_object[FileType+'_files[]'].length; i++)
                {
                     if(form_object[FileType+'_files[]'][i].checked)    {
                        c++;
                     }
                }
                
            }
            else    {
                  if(form_object[FileType+'_files[]'].checked)
                  {
                      c++;   
                  } 
            }
                        
			if(c > 0)
			{
				//if(confirm("%%LNG_ConfirmDeleteFiles%%"))
				document.getElementById("frmFiles").submit();
			}
			else
			{
				alert("%%LNG_ChooseFiles%%");
			}
		}

		function ToggleDeleteBoxes(Status, FileType)
		{
			
            
            var form_object =  document.getElementById('frmFiles');
            
            if(form_object[FileType+'_files[]'].length != undefined)    {
                
                for(var i=0; i<form_object[FileType+'_files[]'].length; i++)
                {
                     form_object[FileType+'_files[]'][i].checked = Status;
                }
                
            }
            else    {
                  form_object[FileType+'_files[]'].checked = Status; 
            }

			/*
            var fp = document.getElementById("frmFiles").elements;
            for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
            */
		}
        
        ShowTab(0);
        
	</script>
