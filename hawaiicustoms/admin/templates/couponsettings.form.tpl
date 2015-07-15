<script type="text/javascript">


function ConfirmCancel()
        {
            if(confirm("%%LNG_ConfirmCancelCoupon%%"))
                document.location.href = "index.php";
        }

   function trim(str, chars) {
    return ltrim(rtrim(str, chars), chars);
}
 
function ltrim(str, chars) {
    chars = chars || "\\s";
    return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str, chars) {
    chars = chars || "\\s";
    return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}

    function Confirmsubmit() {
        var invalid_emailids='';
        var tmp_email;  
        var tmp_email2;
        var email_ids = document.getElementById("emailid").value;
        if(email_ids!='') {
            var validCharRegExp = /^\w(\.?[-\w])*@\w(\.?[-\w])*\.([a-z]{3}(\.[a-z]{2})?|[a-z]{2}(\.[a-z]{2})?)$/i;
            var email_ids_array=email_ids.split(",");

            for(i=0;i<email_ids_array.length;i++){
                tmpemail=trim(email_ids_array[i]);
            
                if(tmpemail != '' && !validCharRegExp.test(tmpemail)) {
                    invalid_emailids+=tmpemail+"<br>";  
                }
            }
            if(invalid_emailids!=''){
                alert("Please enter valid email address with comma separated");

                return false;
            }
        } else {
            alert("Please enter valid email address");      
            return false;
        }
        document.frmNews.submit();
    }

        
        

     Array.prototype.indexOf = function (obj, fromIndex)
      { 
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


    
    function ToggleUsedFor(Which) 
    {
            
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
    
    function ToggleUsedFor3(Which) 
    {
            
            var usedforcat = document.getElementById("usedforcat3");
            var radiobrand = document.getElementById("radiobrand3");
            var tempr1 = document.getElementById("r3");
            var tempr2 = document.getElementById("r4");

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
            //$("#dataTable3 tr[id=15]").fadeOut('slow');
    }    

    var dt;
    dt=$("#dataTable3");
    //alert(dt.find("tr[id=15]").html());

    function addRow3(tableID ,prodCat)
    {  

        //taking previously selected categories
        var selectedcat = new Array();
        var myString  = document.getElementById("catids3").value;
        selectedcat = myString.split(', '); 

        //taking previously selected brands
        var selectedbrand = new Array();
        myString1  = document.getElementById("brandids3").value;
        selectedbrand = myString1.split(', '); 

        var table = document.getElementById(tableID);  
        var w = prodCat.selectedIndex;
        var selected_text = prodCat.options[w].text;
        var subids = prodCat.options[w].value;
        var selected_name = prodCat.name;
        $(table).children('tbody').append('<tr></tr>');
        var row = $(table).children('tbody').children('tr:last')[0];
        row.setAttribute('id',subids); 

        if(subids==0) return;         
        //alert(selected_name);

        if ((selected_name != "productsubcat3") && (selected_name != "productseries3") )
        {

            //alert(111);
            // no need to create a new row for the existing categories in the form
            if (selected_name == "productcat3" && selectedcat.indexOf(subids) == -1)
            {
                selcatid = document.getElementById("productcat3").value;
                document.getElementById("catids3").value += selcatid + ", ";  
                var cell1 = row.insertCell(0);

                cell1.innerHTML = '<a href="javascript:deleteRow3('+selcatid+',\'dataTable3\')">Remove</a>' ;  
                var cell2 = row.insertCell(1);  
                cell2.innerHTML = selected_text;  
                var cell3 = row.insertCell(2);  
                cell3.innerHTML = "<div id='sub3_"+subids+"'>All Subcategories</div>"; 
                $(row).append('<td style="width:30%;"><textarea name="popupmessage[catids][' + subids + ']" style="width: 100%;"></textarea></td>');
                $(row).append('<td style="width:30%;"><textarea name="displayScript[catids][' + subids + ']" style="width: 100%;"></textarea></td>');
                selectedcat.push(subids);
            } 



            // no need to create a new row for the existing brands in the form    
            if (selected_name == "productbrand3" && selectedbrand.indexOf(subids) == -1)
            {
                selbrandid = document.getElementById("productbrand3").value;

                document.getElementById("brandids3").value += selbrandid + ", ";  
                var cell1 = row.insertCell(0);  
                cell1.innerHTML = '<a href="javascript:deletebrand3('+selbrandid+',\'dataTable3\')">Remove</a>' ;  
                var cell2 = row.insertCell(1);  
                cell2.innerHTML = selected_text;  
                var cell3 = row.insertCell(2);  
                cell3.innerHTML = "<div id='ser3_"+selbrandid+"'>All Series</div>"; 
                $(row).append('<td style="width:30%;"><textarea name="popupmessage[brandids][' + selbrandid + ']" style="width: 100%;"></textarea></td>');
                $(row).append('<td style="width:30%;"><textarea name="displayScript[brandids][' + selbrandid + ']" style="width: 100%;"></textarea></td>');
                selectedbrand.push(selbrandid);
            }
        }

        //append selected subcategories to the correponding category row.
        if (selected_name == "productsubcat3" )
        {
            //alert(222);
            selcatid = document.getElementById("productcat3").value;
            selsubid = document.getElementById("productsubcat3").value;
            temp = document.getElementById("sub3_"+selcatid).innerHTML;
            temp = temp.replace("All Subcategories", " ");
            if (selectedcat.indexOf(selcatid) != -1)
            {
                document.getElementById("sub3_"+selcatid).innerHTML = temp + " , " + selected_text; 
            }

            document.getElementById("subids3").value += selsubid + " , ";  
        }

        //append selected series to the correponding brand  row.
        if (selected_name == "productseries3" )
        {
            //alert(3333);
            selbrandid = document.getElementById("productbrand3").value;
            selseriesid = document.getElementById("productseries3").value;

            temp2 = document.getElementById("ser3_"+selbrandid).innerHTML;
            temp2 = temp2.replace("All Series", " ");
            if (selectedbrand.indexOf(selbrandid) != -1)
            {
                document.getElementById("ser3_"+selbrandid).innerHTML = temp2 + " , " + selected_text; 
            }

            document.getElementById("seriesids3").value += selseriesid + " , ";  
        }

    }  

    function deleteRow3(cat,tableID) 
       {  

           try {  
            var table = document.getElementById(tableID);  
            var rowCount = table.rows.length;  
            $("#dataTable3 tr[id="+cat+"]").fadeOut('slow', function() {
                $(this).remove();
            });
            removeid = cat+", ";
            temp1 = document.getElementById("catids3").value; 
            temp1 = temp1.replace(removeid, "");
            document.getElementById("catids3").value = temp1; 
               }catch(e) {  

              //alert(e);  

           }  

       }  

       function deletebrand3(brand,tableID) 
       {  

           try {  
            var table = document.getElementById(tableID);  
            var rowCount = table.rows.length;  
            $("#dataTable3 tr[id="+brand+"]").fadeOut('slow', function() {
                $(this).remove();
            });
            removeid2 = brand+", ";
            temp3 = document.getElementById("brandids3").value; 
            temp3 = temp3.replace(removeid2, "");
            document.getElementById("brandids3").value = temp3; 
              }catch(e) {  

            //  alert(e);  

           }  

       }  
    
    function addRow(tableID ,prodCat)
     {  
        
        //taking previously selected categories
    var selectedcat = new Array();
    myString  = document.getElementById("catids").value;
    selectedcat = myString.split(', '); 
    
    //taking previously selected brands
    var selectedbrand = new Array();
    myString1  = document.getElementById("brandids").value;
    selectedbrand = myString1.split(', '); 
    
         
           
          var table = document.getElementById(tableID);  
          var w = prodCat.selectedIndex;
          var selected_text = prodCat.options[w].text;
          var subids = prodCat.options[w].value;
          var selected_name = prodCat.name;
          var rowCount = table.rows.length;  
          var row = table.insertRow(rowCount);  
              row.setAttribute('id',subids); 
              
        if(subids==0) return;         
    
       if ((selected_name != "productsubcat") && (selected_name != "productseries") )
       {
       
       // no need to create a new row for the existing categories in the form
        if (selected_name == "productcat" && selectedcat.indexOf(subids) == -1)
        {
            selcatid = document.getElementById("productcat").value;
            document.getElementById("catids").value += selcatid + ", ";  
            var cell1 = row.insertCell(0);
           
            cell1.innerHTML = '<a href="javascript:deleteRow('+selcatid+',\'dataTable\')">Remove</a>' ;  
            var cell2 = row.insertCell(1);  
            cell2.innerHTML = selected_text;  
            var cell3 = row.insertCell(2);  
            cell3.innerHTML = "<div id='sub_"+subids+"'>All Subcategories</div>"; 
            selectedcat.push(subids);
            } 
             
             
              
          // no need to create a new row for the existing brands in the form    
            if (selected_name == "productbrand" && selectedbrand.indexOf(subids) == -1)
            {
            selbrandid = document.getElementById("productbrand").value;
             
            document.getElementById("brandids").value += selbrandid + ", ";  
            var cell1 = row.insertCell(0);  
            cell1.innerHTML = '<a href="javascript:deletebrand('+selbrandid+',\'dataTable\')">Remove</a>' ;  
            var cell2 = row.insertCell(1);  
            cell2.innerHTML = selected_text;  
            var cell3 = row.insertCell(2);  
            cell3.innerHTML = "<div id='ser_"+selbrandid+"'>All Series</div>"; 
            selectedbrand.push(selbrandid);
            } 
           
       }

       //append selected subcategories to the correponding category row.
       if (selected_name == "productsubcat" )
       {
            selcatid = document.getElementById("productcat").value;
            selsubid = document.getElementById("productsubcat").value;
            temp = document.getElementById("sub_"+selcatid).innerHTML;
            temp = temp.replace("All Subcategories", " ");
            if (selectedcat.indexOf(selcatid) != -1)
            {
            document.getElementById("sub_"+selcatid).innerHTML = temp + " , " + selected_text; 
            }
                   
            document.getElementById("subids").value += selsubid + " , ";  
         }
         
         //append selected series to the correponding brand  row.
       if (selected_name == "productseries" )
       {
            selbrandid = document.getElementById("productbrand").value;
            selseriesid = document.getElementById("productseries").value;
           
            temp2 = document.getElementById("ser_"+selbrandid).innerHTML;
            temp2 = temp2.replace("All Series", " ");
            if (selectedbrand.indexOf(selbrandid) != -1)
            {
            document.getElementById("ser_"+selbrandid).innerHTML = temp2 + " , " + selected_text; 
            }
                   
            document.getElementById("seriesids").value += selseriesid + " , ";  
         }
     
     }  

     function deleteRow(cat,tableID) 
        {  

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

        function deletebrand(brand,tableID) 
        {  

            try {  
             var table = document.getElementById(tableID);  
             var rowCount = table.rows.length;  
             $("#"+brand).fadeOut('slow');
             removeid2 = brand+", ";
             temp3 = document.getElementById("brandids").value; 
             temp3 = temp3.replace(removeid2, "");
             document.getElementById("brandids").value = temp3; 
               }catch(e) {  

             //  alert(e);  

            }  

        }  

        function setPopupMessagecharcount(){
            //alert($('#PopupMessage').val().length);
            var i=0;
            i=$("#PopupMessage").val().length;
        	$("#PopupMessagecharcount").html(i);
        }
        
    	function ShowTab(T)
    	{
    		i = 0;
    		while (document.getElementById("tab" + i) != null) {
    			$('#div'+i).hide();
    			$('#tab'+i).removeClass('active');
    			++i;
    		}

    		$('#div'+T).show();
    		$('#tab'+T).addClass('active');
    		$('#currentTab').val(T);
    		//OrderManager.ToggleOrderStatus($('#ordstatus').val());
    	}

    	$(document).ready(function() {
        	if($("#PopupMessage").val()==""){
            	a="Certain manufacturers do not allow us to advertise below a certain price. However, we are permitted to sell the item for less than the advertised price by phone. Call us, and we will work out a great deal for you!";
            	$("#PopupMessage").val(a);
				
            }
            if($("#currentTab").val()>0){
            	ShowTab($("#currentTab").val());
			}
    	});

    </SCRIPT>
<form enctype="multipart/form-data"
	action="index.php?ToDo=%%GLOBAL_FormAction%%" id="frmNews"
	name="frmNews" method="post"><input type="hidden" id="templateid"
	name="templateid" value="%%GLOBAL_templateid%%"> <input type="hidden"
	id="couponexpires" name="couponexpires" value=""> <input type="hidden"
	id="couponCode" name="couponcode" value="%%GLOBAL_CouponCode%%"> <input
	id="currentTab" name="currentTab" type="hidden"  value="%%GLOBAL_tab%%">
<div class="BodyContainer">
<table class="OuterPanel">
	<tr>
		<td class="Heading1" id="tdHeading">%%LNG_CouponsSettings%%</td>
	</tr>
	<tr>
		<td class="Intro">
		<p>%%GLOBAL_Intro%%</p>
		%%GLOBAL_Message%%
		<p><input type="submit" name="SubmitButton1" value="%%LNG_Save%%"
			class="FormButton">&nbsp; <input type="button" name="CancelButton1"
			value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding-top: 10px">
		<ul id="tabnav">
			<li><a href="#" id="tab0" onclick="ShowTab(0); return false;"
				class="active">Make Offer</a></li>
			<li><a href="#" id="tab1" onclick="ShowTab(1); return false;">Call
			for Best Deal</a></li>
		</ul>
		</td>
	</tr>
	<tr>
		<td>
		<div id="div0" style="padding-bottom: 5px">
		<table class="Panel">
			<tr>
				<td class="Heading2" colspan=2>%%LNG_SettingsforMakeanOffer%%</td>
			</tr>
			<tr>
				<td class="FieldLabel"><span class="Required">*</span>&nbsp;%%LNG_ChooseProductsBy%%:
				</td>
				<td style="padding-bottom: 3px;"><input onclick="ToggleUsedFor(0)"
					type="radio" id="usedforcat" name="usedfor"%%GLOBAL_UsedForCat%%> <label
					for="usedforcat">%%LNG_Category%%</label><br />
				<div id="r1">
				<div id="usedforcatdiv1" style="padding-left: 25px"><select
					name="productcat" id="productcat"
					onchange="addRow('dataTable',this);SelectSubCategory(this.value)">
					<option value="0">Select Category</option>
					%%GLOBAL_Category%%
				</select></div>
				<div id="usedforcatdiv" style="padding-left: 25px"><select
					name="productsubcat" id="productsubcat" disabled>
					<option value="0">Select Subcategory</option>

				</select></div>
				</div>


				<div style="clear: left;" />
				<input onclick="ToggleUsedFor(1)" type="radio" id="radiobrand"
					name="usedfor"> <label for="usedforprod">%%LNG_Brand%%</label><br />

				<div style="display: none" id="r2">
				<div id="usedforproddiv2" style="padding-left: 25px"><select
					name="productbrand" id="productbrand"
					onchange="addRow('dataTable',this); ProductSeries(this.value);">
					<option value="0">Select Brand</option>
					%%GLOBAL_BrandList%%
				</select></div>
				<div id="selectseries" style="padding-left: 25px"><select
					name="productseries" id="productseries" disabled>
					<option value="0">-- Choose an Existing Series --</option>

				</select></div>
				</div>
				</td>
			</tr>
			<tr>
				<td class="FieldLabel"></td>
				<td style="padding-bottom: 3px;"><INPUT TYPE="hidden" name="catids"
					id="catids" value="%%GLOBAL_catids%%"> <INPUT TYPE="hidden"
					name="subids" id="subids" value="%%GLOBAL_subids%%"> <br>
				<INPUT TYPE="hidden" name="brandids" id="brandids"
					value="%%GLOBAL_brandids%%"> <INPUT TYPE="hidden" name="seriesids"
					id="seriesids" value="%%GLOBAL_seriesids%%"></td>
			</tr>
			<tr>
				<td class="FieldLabel">%%LNG_SelectedProducts%%</td>
				<td style="padding-bottom: 3px;">

				<div style="border-color: #8080FF; border: solid 1px; width: 522px;"
					id="selprod">%%GLOBAL_div_content%%</div>
				</td>
			</tr>
			<tr>
				<td class="FieldLabel">%%LNG_PopupWindowTitle%%</td>
				<td style="padding-bottom: 3px;">%%GLOBAL_WYSIWYG%%</td>
			</tr>
			<tr>
				<td class="FieldLabel">%%LNG_PopupWindowHeader%%</td>
				<td style="padding-bottom: 3px;">%%GLOBAL_WYSIWYG1%%</td>
			</tr>
			<tr>
				<td class="FieldLabel">%%LNG_PopupWindowFooter%%</td>
				<td style="padding-bottom: 3px;">%%GLOBAL_WYSIWYG2%%</td>
			</tr>
			<tr>
				<td class="FieldLabel">%%LNG_EmailAddress%%</td>
				<td style="padding-bottom: 3px;"><TEXTAREA NAME="emailid"
					id="emailid" ROWS="5" COLS="80">%%GLOBAL_emailids%%</TEXTAREA></td>
			</tr>
			<tr>
				<td class="FieldLabel">%%LNG_TemplateofEmailtoadmin%%</td>
				<td style="padding-bottom: 3px;">%%GLOBAL_WYSIWYG3%%</td>
			</tr>
		</table>
		</div>
		<div id="div1" style="display: none">
		<table class="Panel">
			<tr>
				<td class="Heading2" colspan=2>Settings for Call for Best Deal</td>
			</tr>
            <tr>
                <td class="FieldLabel">Display For:</td>
                <td>
                	<input type="radio" id="displayfor1" name="displayfor" value="entireday" %%GLOBAL_entireday_Checked%%/>entire day
			        <input type="radio" id="displayfor2" name="displayfor" value="customerservice" %%GLOBAL_customerservicehours_Checked%%/>customer service hours only
                </td>
            </tr>
			<tr>
				<td class="FieldLabel">%%LNG_ChooseProductsBy%%:
				</td>
				<td style="padding-bottom: 3px;"><input onclick="ToggleUsedFor3(0)"
					type="radio" id="usedforcat3" name="usedfor3" %%GLOBAL_UsedForCat%%> <label
					for="usedforcat">%%LNG_Category%%</label><br />
				<div id="r3">
				<div id="usedforcatdiv4" style="padding-left: 25px"><select
					name="productcat3" id="productcat3"
					onchange="addRow3('dataTable3',this);SelectSubCategory3(this.value)">
					<option value="0">Select Category</option>
					%%GLOBAL_Category%%
				</select></div>
				<div id="usedforcatdiv3" style="padding-left: 25px"><select
					name="productsubcat3" id="productsubcat3" disabled>
					<option value="0">Select Subcategory</option>

				</select></div>
				</div>


				<div style="clear: left;" />
				<input onclick="ToggleUsedFor3(1)" type="radio" id="radiobrand3"
					name="usedfor3"> <label for="usedforprod">%%LNG_Brand%%</label><br />

				<div style="display: none" id="r4">
				<div id="usedforproddiv5" style="padding-left: 25px"><select
					name="productbrand3" id="productbrand3"
					onchange="addRow3('dataTable3',this); ProductSeries3(this.value);">
					<option value="0">Select Brand</option>
					%%GLOBAL_BrandList%%
				</select></div>
				<div id="selectseries3" style="padding-left: 25px"><select
					name="productseries3" id="productseries3" disabled>
					<option value="0">-- Choose an Existing Series --</option>

				</select></div>
				</div>
				</td>
			</tr>
			<tr>
				<td class="FieldLabel"></td>
				<td style="padding-bottom: 3px;"><INPUT TYPE="hidden" name="catids3"
					id="catids3" value="%%GLOBAL_catids3%%"> <INPUT TYPE="hidden"
					name="subids3" id="subids3" value="%%GLOBAL_subids3%%"> <br>
				<INPUT TYPE="hidden" name="brandids3" id="brandids3"
					value="%%GLOBAL_brandids3%%"> <INPUT TYPE="hidden" name="seriesids3"
					id="seriesids3" value="%%GLOBAL_seriesids3%%"></td>
			</tr>
            <tr>
                <td colspan="2" class="FieldLabel">%%LNG_SelectedProducts%%</td>
			</tr>
			<tr>
                <td colspan="2" style="padding: 6px 10px 0;">
                    <div id="selprod3">
                        <table class="tableContent" width="100%" border="0" id="dataTable3">
                            <thead>
                                <tr>
                                    <td>Action</td>
                                    <td>Brand/Category</td>
                                    <td>Series/Subcategory</td>
                                    <td>Popup Message</td>
                                    <td>Display Script</td>
                                </tr>
                            </thead>
                            <tbody>
                                %%GLOBAL_div_content3%%
                            </tbody>
                        </table>
                    </div>
				</td>
			</tr>
		</table>
		</div>
		</div>
		<table border="0" cellspacing="0" cellpadding="2" width="100%"
			class="PanelPlain">
			<tr>
				<td width="200" class="FieldLabel">&nbsp;</td>
				<td><input type="button" value="%%LNG_Save%%" class="FormButton"
					onclick="Confirmsubmit()" /> <input type="reset"
					value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				</td>
			</tr>
		</table>

		</td>
	</tr>
</table>

</div>
</form>

