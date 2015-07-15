	<script type="text/javascript">
		ShowLoadingIndicator();
		window.onload = function() {
			HideLoadingIndicator();
		};

		function quickToggle(element)
		{
			var image = element.childNodes[0];
			if(image.src.indexOf('tick')==-1) {
				var confirmMessage = "%%LNG_CategoryVisibleConfirmation%%";
			} else {
				var confirmMessage = "%%LNG_CategoryInvisibleConfirmation%%";
			}
			if(confirm(confirmMessage)) {
				$.ajax({
					url: element.href + '&ajax=1',
					dataType: 'script',
					success: function(response) {

						if(status == 0) {
							display_error('CategoriesStatus', '%%LNG_ErrCategoryVisibilityNotChanged%%');
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
                 if ($.trim($('#'+divid).text()) == '') {
                    if($('#'+divid).load("index.php?ToDo=listQualifiersImportTemplate&catid="+catid+"&ajax=1"))   {
                        //$('#'+divid).attr('style','display:visible;');                                       
                    }
                 }
                 qualifierdiv.style.display = "block";
                 curimg.src = '%%GLOBAL_ShopPath%%/templates/default/images/minusicon.gif'; 
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
         
	</script>
    


<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(CheckForm)" id="frmTemplate" method="post">
%%GLOBAL_hiddenFields%%
<input id="currentTab" name="currentTab" value="0" type="hidden">
<div class="BodyContainer">
	<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px;">
	<tr>
		<td class="Heading1">%%GLOBAL_TemplateTitle%%</td>
	</tr>
	<tr>
		<td class="Intro">
			<p>%%LNG_ManageImportTemplatesIntro%%</p>
			%%GLOBAL_Message%%
			<div id="FieldStatus" style="margin-bottom: 10px;"></div>
			<p>
				<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" />
				<input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="AddAnother" class="FormButton" style="width:130px" />
				<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
			</p>
		</td>
	</tr>
	<tr>
		<td>
			<ul id="tabnav">
				<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_ExportTemplateDetails%%</a></li>
				%%GLOBAL_TypeTabs%%
				
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<!--Template Details-->
			<div id="div0" style="padding-top: 10px;">
				<table width="100%" class="Panel">
					<tr>
						<td class="Heading2" colspan="2">%%LNG_ExportTemplateDetails%%</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_ExportTemplateName%%:
						</td>
						<td>
							<input type="text" id="templateName" name="templateName" class="Field200" style="margin-bottom: 4px;" value="%%GLOBAL_ExportTemplateName%%" maxlength="100"/>
						</td>
					</tr>
					<tr %%GLOBAL_HideVendorRow%%>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%GLOBAL_VendorLabel%%:
						</td>
						<td>
							%%GLOBAL_VendorData%%
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;%%LNG_ExportTemplateDesc%%:
						</td>
						<td>
							<textarea name="description" cols="5" rows="4" class="Field300">%%GLOBAL_ExportTemplateDesc%%</textarea>

						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;%%LNG_ExportTemplateCreationTime%%:
						</td>
						<td>
							%%GLOBAL_ExportTemplateCreationTime%%
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;%%LNG_ExportTemplateModifiedTime%%:
						</td>
						<td>
							%%GLOBAL_ExportTemplateModifiedTime%%
						</td>
					</tr>
					
					
					
					
				</table>
			</div>

			<!--Template Details-->
			<div id="div1" style="padding-top: 10px; display: none;">
				
			</div>

		   %%GLOBAL_TypeGrids%%
             <div id="divcat" style="padding-top: 10px; display: none; ">
<table class="GridPanel SortablePanel" cellspacing="0" cellpadding="0" border="0" style="width:100%; margin-top:10px">
		<tr class="Heading3">
			<td>&nbsp;</td>
			<td style="width: 350px;">Select your categories and subcategories</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
		   <select size="5" id="category" name="pre_category[]" class="Field400 ISSelectReplacement" multiple="multiple" style="height: 240px;">
			%%GLOBAL_CategoryOptions%%
			</select>
               </div>   
			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain" id="SaveButtons">
				<tr>
					<td>
						<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" />
						<input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="AddAnother" class="FormButton" style="width:130px" />
						<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
</div>
</form>

<script type="text/javascript" src="../javascript/jquery/plugins/interface.js"></script>
<script type="text/javascript" src="../javascript/jquery/plugins/jquery.color.js"></script>
<script type="text/javascript">
	function ConfirmCancel()
	{
		if(confirm('%%GLOBAL_CancelMessage%%'))
		{
			document.location.href='index.php?ToDo=viewImportTemplates';
		}
		else
		{
			return false;
		}
	}

	function ShowTab(T)
	{
	
if (T == 2) 
       {
i = 0;
$('#divcat').show();       
       }
else
{
     i = 2;
     $('#divcat').hide();     
}

$('#div'+T).show();
$('#tab'+T).addClass('active');
$('#currentTab').val(T);
document.getElementById("currentTab").value = T;

$('#div'+i).hide();
$('#tab'+i).removeClass('active');
			

		
	}

		var updatingSortables = false;
		var updateTimeout = null;

		function GenerateHash(list, hash) {
			$("ul[id$='_" + list + "']").each(function() {
				// get the lists parent list item
				var parent_item = $(this).parents("li");
				var parent_item_id = parent_item.attr("id")

				// get the parent items list
				var parent_list = parent_item.parent();

				//serialize this list
				var serial = $.SortSerialize(this.id);
				// replace the hash with id of the parent list
				var replace = new RegExp(this.id, 'g');
				var sublist_hash = serial.hash.replace(replace, parent_list.attr("id"));

				// merge the serialized data from both lists
				// find position of parent item in hash
				var pos = hash.indexOf(parent_item_id);
				var start_hash = hash.substr(0, pos + parent_item_id.length);
				var end_hash = hash.substr(pos + parent_item_id.length);
				hash = start_hash + '&' + sublist_hash + end_hash;
			});

			return hash;
		}

		function CreateSortableList(list) {
			$('#' + list + 'FieldList').Sortable(
				{
					accept: 'SortableRow' + list,
					opacity: .8,
					helperclass: 'SortableRowHelper',
					onChange: function(serialized) {
						if (%%GLOBAL_TemplateId%% == 0) return;

						var hash = serialized[0].hash;

						// find if this list has any child lists
						hash = GenerateHash(list + "FieldList", hash);

						// does this list have a parent list?
						if ($("#" + list + "FieldList").parents("li").length == 1) {
							// the parent list
							var parent_id = $("#" + list + "FieldList").parents("li").parent().attr("id");
							var parent_hash = $.SortSerialize(parent_id).hash;

							hash = GenerateHash(parent_id, parent_hash);
							list = parent_id.substr(0, parent_id.length - 9);
						}

						updatingSortables = true;
						if(updateTimeout != null) window.clearTimeout(updateTimeout);

						$.ajax({
							url: 'remote.php?w=updateTemplateFields&l=' + list + '&tempId=%%GLOBAL_TemplateId%%',
							type: 'POST',
							dataType: 'xml',
							data: hash,
							success: function(response) {
								var status = $('status', response).text();
								var message = $('message', response).text();

								if(status == 0) {
									display_error('FieldStatus', message);
								}
								else {
									display_success('FieldStatus', message);
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

			addCheckHandlers(list + 'FieldList');
		}

		function addCheckHandlers(list) {
			$("#" + list + " :checkbox").change(function() {
				disableInputs(this.id, this.checked);
			});
		}

		// disables/enables the column header input for a particular row
		function disableInputs(id, checked) {
		   if (checked) {
				$("#label_" + id).fadeTo("fast", 1);
				$("#headercol_" + id + " td[id^='label_']").fadeTo("fast", 1);
				$("#headercol_" + id + " :text").removeAttr("readonly").css("color", "black");
				$("#headercol_" + id + " :checkbox").removeAttr("disabled").css("color", "grey");

				$("#headercol_" + id + " :checkbox").change();
			}
			else {
				$("#label_" + id + ",").fadeTo("fast", 0.5);
				$("#headercol_" + id + " td[id^='label_']").fadeTo("fast", 0.5);
				$("#headercol_" + id + " :text").attr("readonly","readonly").css("color", "grey");
				$("#headercol_" + id + " :checkbox").attr("disabled","disabled").css("color", "grey");
			}
		}

		function toggleFieldCheck(list, checked) {

	
			if (checked)
				$("#" + list + "FieldList :checkbox").attr("checked", "checked");
			else
				$("#" + list + "FieldList :checkbox").removeAttr("checked");

			$("#" + list + "FieldList :checkbox").each(function() {
				disableInputs(this.id, checked);
			});
		}

		function CheckForm() {
			// check template name
			if (jQuery.trim($("#templateName").val()) == "") {
				alert("%%LNG_NoTemplateName%%");

				ShowTab(0);
				$("#templateName").focus();

				return false;
			}

			

			%%GLOBAL_VerifyJS%%

			return true;
		}

		function CreateTypeData(type, tabindex) {
			// create a sortable list for the type
			CreateSortableList(type);

			if (tabindex > 0) {
				// function to hide types tab
				("#include" + type).change(function() {
					if (this.checked)
						$("#tab" + tabindex).animate({ opacity: "show", color: "green" }, "slow").animate({color: "#666"}, "medium");
					else
						$("#tab" + tabindex).fadeOut("fast");
				});
			}
		}

		function VerifyList(list, tabindex) {
			var ret = true;

			// use customer file is ticked
			if ($("#include" + list).attr("checked")) {
				// make sure at least one field is checked
				if ($("#" + list + "FieldList :checkbox:checked").length == 0) {
					var nofields = "%%LNG_NoFields%%";
					nofields = nofields.replace(/\%s/, list);
					alert(nofields);

					ShowTab(tabindex);

					return false;
				}

				// check that checked fields have a header column
			   $("#" + list + "FieldList :checkbox:checked").each(function() {
					if (jQuery.trim($("#header_" + this.id).val()) == "") {
						var label = $("#label_" + this.id).text();

						alert("%%LNG_FieldNoHeader%%\n\n" + label.substr(0, label.length - 1));

						ShowTab(tabindex);
						$("#header_" + this.id).focus();

						ret = false;
						return false;
					}
			   });
			}

			return ret;
		}

		 $(document).ready(function()
		{
			%%GLOBAL_IncludeJS%%

			%%GLOBAL_CreateLists%%

			%%GLOBAL_ShowTabScript%%
		});
</script>