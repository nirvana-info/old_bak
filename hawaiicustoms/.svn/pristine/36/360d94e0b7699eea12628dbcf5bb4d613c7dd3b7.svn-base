	<script type="text/javascript">
		ShowLoadingIndicator();
		window.onload = function() {
			HideLoadingIndicator();
		};

		function quickToggle(element)
        {
            var image = element.childNodes[0];
            if(image.src.indexOf('tick')==-1) {
                var confirmMessage = "%%LNG_QualifierVisibleConfirmation%%";
            } else {
                var confirmMessage = "%%LNG_QualifierInvisibleConfirmation%%";
            }
            if(confirm(confirmMessage)) {
                $.ajax({
                    url: element.href + '&ajax=1',
                    dataType: 'script',
                    success: function(response) {

                        if(status == 0) {
                            display_error('CategoriesStatus', '%%LNG_ErrQualifierVisibileNotChanged%%');
                        }
                        else {
                            display_success('CategoriesStatus', message);
                        }
                    }
                });
            }
        }

		function ToggleVisibilityIcon(elementID, what, visible)
		{
			var element = document.getElementById(elementID);
			if(element.childNodes.length == 1 && element.childNodes[0].tagName == "IMG") {
				var image = element.childNodes[0];

				// Element was ticked, now should not be
				if(visible == 0) {
					element.href = element.href.replace(what+'=0', what+'=1');
					image.src = image.src.replace('tick', 'cross');
				}
				else {
					element.href = element.href.replace(what+'=1', what+'=0');
					image.src = image.src.replace('cross', 'tick');
				}
			}
		}
        
        function listQualifiers(divid, catid)   
        {
             var curimg = document.getElementById('image-'+catid);   
             
             var qualifierdiv = document.getElementById(divid); 
             
             if(curimg.src.indexOf('plusicon')==-1)   {
                 curimg.src = '%%GLOBAL_ShopPath%%/templates/default/images/plusicon.gif'; 
                 qualifierdiv.style.display = "none";
             }
             else   {    
                 qualifierdiv.style.display = "block";
                 curimg.src = '%%GLOBAL_ShopPath%%/templates/default/images/minusicon.gif'; 
                 if ($.trim($('#'+divid).text()) == '') { 
                    if($('#'+divid).load("index.php?ToDo=listQualifiersQualifierAssociations&catid="+catid+"&ajax=1"))   {
                        //$('#'+divid).attr('style','display:visible;');                                       
                    }
                 }                                                                          
             } 
        }
        
        function listUpdatedQualifiers(divid, catid)   
        {
             var curimg = document.getElementById('image-'+catid); 
            /* if(curimg.src.indexOf('plusicon')==-1)   {
                 curimg.src = '%%GLOBAL_ShopPath%%/templates/default/images/plusicon.gif';
                 $('#'+divid).html('');
             }
             else   {  */
                if($('#'+divid).load("index.php?ToDo=listQualifiersQualifierAssociations&catid="+catid+"&ajax=1"))   {
                    //$('#'+divid).attr('style','display:visible;');
                    //curimg.src = '%%GLOBAL_ShopPath%%/templates/default/images/minusicon.gif';  
                }
             //}
        }
    
        function AssignNewQualifiers(catid)   {
            //      
            var w = window.open("assignqualifiers.php?catid="+catid, 'win'+catid, "width=400,height=150,left="+250+",top="+250); 
        }             
        
        function loadDeptCategory(deptid)     
        {                                  
            $('#FullCategoryGrid').load('index.php?ToDo=viewQualifierAssociations&ajax=1&deptid='+deptid, {}, 
                function() {
                    //CreateSortableList();             
                }
            );     
             //'/index.php?ToDo=viewCategories&ajax=1&deptid='+deptid
        }
        
        function ToggleVisibleIcon(elementID, what, visible)
        {
            var element = document.getElementById(elementID);
            if(element.childNodes.length == 1 && element.childNodes[0].tagName == "IMG") {
            var image = element.childNodes[0];
            // Element was ticked, now should not be
            if(visible == 0) {
                element.href = element.href.replace(what+'=0', what+'=1');
                image.src = image.src.replace('tick', 'cross');
            }
            else{
                element.href = element.href.replace(what+'=1', what+'=0');  
                image.src = image.src.replace('cross', 'tick');
                }
            }
        }
         
	</script>
    
	<div class="BodyContainer">
	<table class="OuterPanel">
	<tr>
        <td class="Heading1">%%LNG_ViewQualifierAssociations%%</td>
    </tr>
    <tr>
    <td class="Intro">
        <p>%%GLOBAL_QualifierAssociationIntro%%</p>
        %%GLOBAL_Message%%
        <table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
        <tr>
        <td class="Intro" valign="top">
            <!--<input type="button" name="IndexAddButton" value="%%LNG_AddQualifierAssociation%%" id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addQualifierAssociation'" />--> 
            &nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
            <td align='right' width='110'>
                Select Department
            </td>
            <td align='right' width='150'>
                <select id="dept" name="dept" onchange="loadDeptCategory(this.value);">
                %%GLOBAL_DeptFilterOptions%%
                </select>
            </td>
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
	<tr>
		<td style="padding-top: 10px;">
			<form name="frmQualifierAssociations" id="frmQualifierAssociations" method="post" action="index.php?ToDo=deleteQualifierAssociations"> 
				<table class="GridPanel SortablePanel" cellspacing="0" cellpadding="0" border="0" style="width:100%; display: %%GLOBAL_DisplayGrid%%">
					<tr class="Heading3">
						<td style="padding-left: 5px;" width="1"><!--<input type="checkbox" onclick="ToggleDeleteBoxes(this.checked)">--></td>
						<td>%%LNG_CategoryName%%</td>
                        <td width="200">
                            %%LNG_AssociationDisplayName%%
                        </td>
						<td width="70">
							%%LNG_Action%%
						</td>
					</tr>
				</table>
				<div id="FullCategoryGrid">                     
                    %%GLOBAL_FullCategoryGrid%%        
                </div>
			</form>
		</td>
	</tr>
	</table>
	</div>
	<script type="text/javascript" src="../javascript/jquery/plugins/interface.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/inestedsortable.js"></script>
	<script type="text/javascript">
        /*
		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmCategories").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}
         */
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

		var updatingSortables = false;
		var updateTimeout = null;
		function CreateSortableList() {
			$('#CategoryList').NestedSortable(
				{
					accept: 'SortableRow',
					noNestingClass: "no-nesting",
					opacity: .8,
					helperclass: 'SortableRowHelper',
					onChange: function(serialized) {
						updatingSortables = true;
						if(updateTimeout != null) window.clearTimeout(updateTimeout);
						$.ajax({
							url: 'remote.php?w=updateCategoryOrders',
							type: 'POST',
							dataType: 'xml',
							data: serialized[0].hash,
							success: function(response) {
								var status = $('status', response).text();
								var message = $('message', response).text();
								if(status == 0) {
									display_error('CategoriesStatus', message);
								}
								else {
									display_success('CategoriesStatus', message);
								}
								if(document.all) {
									// IE has problems here - it breaks on sortable lists so for now we just
									// refresh the current page
									window.location.reload();
								}
							}
						});

					},
					onStop: function() {
						if(document.all && updatingSortables == false) {
							// IE has problems here - it breaks on sortable lists so for now we just
							// refresh the current page
							updateTimeout = window.setTimeout(function() { window.location.reload(); }, 100);
						}
					},
					autoScroll: true,
					handle: '.sort-handle'
				}
			);
		}
		$(document).ready(function()
		{
			CreateSortableList();
		});
	</script>
