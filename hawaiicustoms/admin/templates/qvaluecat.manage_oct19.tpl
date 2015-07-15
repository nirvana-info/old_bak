	    <script type="text/javascript">
       
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
                    if($('#'+divid).load("index.php?ToDo=listQualifiersQValueAssociations&catid="+catid+"&ajax=1"))   {
                        //$('#'+divid).attr('style','display:visible;');                                       
                    }
                 }
                 qualifierdiv.style.display = "block";
                 curimg.src = '%%GLOBAL_ShopPath%%/templates/default/images/minusicon.gif'; 
             } 
        }
        
        function listQValues(divid, associd)   
        {
             var curimg = document.getElementById('qimage-'+associd);   
             
             var qualifierdiv = document.getElementById(divid); 
             
             if(curimg.src.indexOf('plusicon')==-1)   {
                 curimg.src = '%%GLOBAL_ShopPath%%/templates/default/images/plusicon.gif'; 
                 qualifierdiv.style.display = "none";
             }
             else   { 
                 if ($.trim($('#'+divid).text()) == '') {
                    if($('#'+divid).load("index.php?ToDo=listQValuesQValueAssociations&associd="+associd+"&ajax=1"))   {
                        //$('#'+divid).attr('style','display:visible;');                                       
                    }
                 }
                 qualifierdiv.style.display = "block";
                 curimg.src = '%%GLOBAL_ShopPath%%/templates/default/images/minusicon.gif'; 
             } 
        }
        
        function listUpdatedQValues(divid, associd)   
        {
             var curimg = document.getElementById('qimage-'+associd);                                                 
            /* if(curimg.src.indexOf('plusicon')==-1)   {
                 curimg.src = '%%GLOBAL_ShopPath%%/templates/default/images/plusicon.gif';
                 $('#'+divid).html('');
             }
             else   {  */
                if($('#'+divid).load("index.php?ToDo=listQValuesQValueAssociations&associd="+associd+"&ajax=1"))   {
                    //$('#'+divid).attr('style','display:visible;');
                    //curimg.src = '%%GLOBAL_ShopPath%%/templates/default/images/minusicon.gif';  
                }
             //}
        }
    
        function AssignNewQValues(associd)   {
            //
            var w = window.open("assignqvalues.php?associd="+associd, 'win'+associd, "width=400,height=150,left="+250+",top="+250); 
        }
    
        </script>
    
    
    <div class="BodyContainer">
	<table class="OuterPanel">
	<tr>
        <td class="Heading1">%%LNG_ViewQValueAssociations%%</td>
    </tr>
    <tr>
        <td class="Intro">
            <p>%%GLOBAL_QValueAssociationIntro%%</p>
            %%GLOBAL_Message%%
            <table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
                <!--<tr style="height:40px;">
                   <td colspan="2">  
                        <div style="float:left;">
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
                </tr>-->
                    <tr>
                        <td class="Intro" valign="top">
                            <!--
                            <input type="button" name="IndexAddButton" value="%%LNG_AddQValueAssociation%%" id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addQValueAssociation'" />
                            --> 
                            &nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
                        </td>
                        <td class="SmallSearch" align="right">
                            &nbsp;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
	<tr>
		<td style="padding-top: 10px;">
			<form name="frmQValueAssociations" id="frmQValueAssociations" method="post" action="index.php?ToDo=deleteQValueAssociations"> 
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
				<ul class="SortableList" id="CategoryList">
					%%GLOBAL_CategoryGrid%%
				</ul>
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
        
	</script>
