	<form enctype="multipart/form-data" action="index.php?ToDo=%%GLOBAL_FormAction%%"  id="frmNews" method="post">
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
<input onclick="ToggleUsedFor(1)" type="radio" id="radiobrand" name="usedfor" disabled > <label for="usedforprod" >%%LNG_Brand%%</label><br />
	
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

<INPUT TYPE="hidden" name = "catids" id = "catids" value = "%%GLOBAL_catids%%" >
<INPUT TYPE="hidden" name = "subids" id = "subids" value = "%%GLOBAL_subids%%" >
<br>
<INPUT TYPE="hidden" name = "brandids" id = "brandids" >
<INPUT TYPE="hidden" name = "seriesids" id = "seriesids" >

   
					</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						%%LNG_SelectedProducts%%            
					</td>
					<td style="padding-bottom: 3px;">
                    
<div style="border-color:#8080FF;  border: solid 1px;width:522px;" id="selprod" >
	%%GLOBAL_div_content%%
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


function ConfirmCancel()
		{
			if(confirm("%%LNG_ConfirmCancelCoupon%%"))
				document.location.href = "index.php";
		}


	 Array.prototype.indexOf = function (obj, fromIndex) { 
				    if (fromIndex == null) { 
					fromIndex = 0; 
				    } else if (fromIndex < 0) { 
					fromIndex = Math.max(0, this.length + fromIndex); 
				    } 
				    for (var i = fromIndex, j = this.length; i < j; i++) { 
					if (this[i] === obj) 
					    return i; 
				    } 
				    return -1; 
				  }; 


	
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
var selectedcat = new Array();
myString  = document.getElementById("catids").value;
selectedcat = myString.split(', '); 
	
function addRow(tableID ,prodCat) {  
              
            var table = document.getElementById(tableID);  
            var w =prodCat.selectedIndex;
	    var selected_text = prodCat.options[w].text;
	    var subids = prodCat.options[w].value;
	    var selected_name = prodCat.name;

	 var rowCount = table.rows.length;  
	 var row = table.insertRow(rowCount);  
	
	
   if ((selected_name != "productsubcat") && (selected_name != "productseries") )
   {
	if (selected_name == "productcat" && selectedcat.indexOf(subids) == -1)
	{
		selcatid = document.getElementById("productcat").value;
		document.getElementById("catids").value += selcatid + ", ";  
		var cell1 = row.insertCell(0);  
		cell1.innerHTML = '<a href="javascript:deleteRow('+selcatid+',\'dataTable\')">Remove</a>' ;  


		
		var cell2 = row.insertCell(1);  
		cell2.innerHTML = selected_text;  
		var cell3 = row.insertCell(2);  
		cell3.innerHTML = "<div id='sub_"+subids+"'>All categories</div>"; 
		selectedcat.push(subids);
    	} 
 	  
   }

if (selected_name == "productsubcat" )
   {

	selcatid = document.getElementById("productcat").value;
	selsubid = document.getElementById("productsubcat").value;
	temp = document.getElementById("sub_"+selcatid).innerHTML;
	temp = temp.replace("All categories", " ");
	
	selcatid = document.getElementById("productcat").value;

	if (selectedcat.indexOf(selcatid) != -1)
	{
	document.getElementById("sub_"+selcatid).innerHTML = temp + " , " + selected_text; 
	}
	        
	document.getElementById("subids").value += selsubid + " , ";  

   }
     
       }  

function deleteRow(cat,tableID) {  

            try {  
             var table = document.getElementById(tableID);  

            var rowCount = table.rows.length;  

		$("#"+cat).fadeOut('slow');
                 
		       removeid = cat+", ";
		       temp1 = document.getElementById("catids").value; 
		       temp1 = temp1.replace(removeid, "");
		       document.getElementById("catids").value = temp1; 
	     
                

            }catch(e) {  

             //  alert(e);  

            }  

        }  

    




	</SCRIPT>