
	<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(CheckCouponForm)" id="frmNews" method="post">
	<input type="hidden" id="templateid" name="templateid" value="%%GLOBAL_templateid%%">
	<input type="hidden" id="couponexpires" name="couponexpires" value="">
	<input type="hidden" id="couponCode" name="couponcode" value="%%GLOBAL_CouponCode%%">
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%GLOBAL_Title%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_Intro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
		</td>
	  </tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				   <td class="Heading2" colspan=2>%%LNG_SettingsforMakeanOffer%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						<span class="Required">*</span>&nbsp;%%LNG_ChooseProductsBy%%:
					</td>
					<td style="padding-bottom: 3px;">

<input onclick="ToggleUsedFor(0)" type="radio" id="usedforcat" name="usedfor"  %%GLOBAL_UsedForCat%%> <label for="usedforcat">%%LNG_Category%%</label><br />
<div  id="r1">
	<div id="usedforcatdiv1" style="padding-left:25px">
	<select name="productcat" id="productcat" onchange="addRow('dataTable',this);SelectSubCategory(this.value)">
                <option value="0">Select Category</option>
		%%GLOBAL_Category%%
		</select>
		<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_ChooseCategories%%', '%%LNG_ChooseCategoriesHelp%%')" src="images/help.gif" width="24" height="16" border="0">
		</div>
	<div id="usedforcatdiv" style="padding-left:25px">
	<select name="productsubcat" id="productsubcat" disabled >
                <option value="0">Select Subcategory</option>
		
		</select>
	</div>
</div>


<div style="clear: left;" />
<input onclick="ToggleUsedFor(1)" type="radio" id="radiobrand" name="usedfor" > <label for="usedforprod">%%LNG_Brand%%</label><br />
	
<div style="display:none" id="r2">
			<div id="usedforproddiv2" style="padding-left:25px">
			<select name="productbrand" id="productbrand" onchange="addRow('dataTable',this); SelectSeries(this.value);">
                <option value="0">Select Brand</option>
		%%GLOBAL_BrandList%%
		</select>
		<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_ChooseCategories%%', '%%LNG_ChooseCategoriesHelp%%')" src="images/help.gif" width="24" height="16" border="0">
		
	</div>
	<div id="selectseries" style="padding-left:25px">
	<select name="productseries" id="productseries" disabled>
                <option value="0">-- Choose an Existing Series --</option>
		
		</select>
	</div>
</div>
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						
					</td>
					<td style="padding-bottom: 3px;">
<INPUT type="button" id = "del" name = "del" value="Remove Selected" onclick="deleteRow('dataTable')" style="display:none"  /> 
<INPUT TYPE="hidden" name = "lastcat" id = "lastcat" >
<INPUT TYPE="hidden" name = "selectedids" id = "selectedids" >

   
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						%%LNG_SelectedProducts%%            
					</td>
					<td style="padding-bottom: 3px;">
                    
<div style="border-color:#8080FF;  border: solid 1px;width:500px;display:none" id="selprod"   >
	<TABLE id="dataTable" width="500px" border="0">  
         <TR  visibility: hidden>  
            <TD><INPUT type="checkbox" name="chk" style="display:none" /></TD>  
	    <TD> </TD>  
            <TD>  </TD>  
            
         </TR>  
    </TABLE>  	
</div>					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						%%LNG_PopupWindowTitle%%
					</td>
					<td style="padding-bottom: 3px;">
						%%GLOBAL_WYSIWYG%%
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						%%LNG_PopupWindowHeader%%
					</td>
					<td style="padding-bottom: 3px;">
						%%GLOBAL_WYSIWYG1%%
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						%%LNG_PopupWindowFooter%%
					</td>
					<td style="padding-bottom: 3px;">
						%%GLOBAL_WYSIWYG2%%
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						%%LNG_EmailAddress%%
					</td>
					<td style="padding-bottom: 3px;">
					<TEXTAREA NAME="emailid" ROWS="2" COLS="80">%%GLOBAL_emailids%%</TEXTAREA>
						
						
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						%%LNG_TemplateofEmailtoadmin%%
					</td>
					<td style="padding-bottom: 3px;">
						%%GLOBAL_WYSIWYG3%%
					</td>
				</tr>
			</table>

			<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
				<tr>
					<td width="200" class="FieldLabel">
						&nbsp;
					</td>
					<td>
						<input type="submit" value="%%LNG_Save%%" class="FormButton" />
						<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
					</td>
				</tr>
			</table>

			</td>
		</tr>
	</table>

	</div>
	</form>

	<SCRIPT LANGUAGE="JavaScript">
	
	function ToggleUsedFor(Which) {
			
			var usedforcat = document.getElementById("usedforcat");
			var radiobrand = document.getElementById("radiobrand");
			var tempr1 = document.getElementById("r1");
			var tempr2 = document.getElementById("r2");

			if(Which == 0) {
				usedforcat.checked = true;
				tempr2.style.display = "none";
				tempr1.style.display = '';
			}
			else {
				radiobrand.checked = true;
				tempr1.style.display = "none";
				tempr2.style.display = '';
				
			}
		}
	
function addRow(tableID ,prodCat) {  

    var temp3 = document.getElementById("del");
        temp3.style.display = '';
        var temp3 = document.getElementById("selprod");
        temp3.style.display = 'block';
       
            var table = document.getElementById(tableID);  
            var w =prodCat.selectedIndex;
	    var selected_text = prodCat.options[w].text;
	    var selected_id = prodCat.options[w].value;
	    var selected_name = prodCat.name;

	 var rowCount = table.rows.length;  
	 var row = table.insertRow(rowCount);  
		
   if ((selected_name != "productsubcat") && (selected_name != "productseries") )
   {
	document.getElementById("lastcat").value = selected_id ;  
	var cell1 = row.insertCell(0);  
        var element1 = document.createElement("input");  
        element1.type = "checkbox";  
        cell1.appendChild(element1);  
        var cell2 = row.insertCell(1);  
        cell2.innerHTML = selected_text;  
	var cell3 = row.insertCell(2);  

if (selected_name == "productcat")
   {
        cell3.innerHTML = "<div id='sub_"+selected_id+"'>All categories</div>"; 
	
   }
   else
   {
	cell3.innerHTML = "<div id='sub_"+selected_id+"'>All Brands</div>"; 
	
   }

 	  
   }

if (selected_name == "productsubcat" )
   {
	
	
	lastcategory = document.getElementById("lastcat").value;
	temp = document.getElementById("sub_"+lastcategory).innerHTML;
	temp = temp.replace("All categories", " ");
	if (temp == " ")
	{
	document.getElementById("sub_"+lastcategory).innerHTML = temp + selected_text; 
	}
	else
	{
	document.getElementById("sub_"+lastcategory).innerHTML = temp + " , " + selected_text; 
	}
        
	document.getElementById("selectedids").value += "CAT_"+selected_id+" ";  

   }
           
    if ( selected_name == "productseries")
	 {
	
	
		lastcategory = document.getElementById("lastcat").value;
		temp = document.getElementById("sub_"+lastcategory).innerHTML;
		temp = temp.replace("All Brands", " ");
		if (temp == " ")
		{
		document.getElementById("sub_"+lastcategory).innerHTML = temp + selected_text; 
		}
		else
		{
		document.getElementById("sub_"+lastcategory).innerHTML = temp + " , " + selected_text; 
		}
		
		document.getElementById("selectedids").value += "SER_"+selected_id+" ";  	

	}

            

           

  

       }  

function deleteRow(tableID) {  

            try {  
             var table = document.getElementById(tableID);  

            var rowCount = table.rows.length;  

    

             for(var i=0; i<rowCount; i++) {  

                var row = table.rows[i];  

                 var chkbox = row.cells[0].childNodes[0];  

                 if(null != chkbox && true == chkbox.checked) {  

                    table.deleteRow(i);  

                     rowCount--;  

                     i--;  

                 }  

   

             }  

            }catch(e) {  

               alert(e);  

            }  

        }  

    




	</SCRIPT>