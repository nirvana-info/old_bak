<script type="text/javascript" src="../javascript/formfield.js"></script>

<form action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateFormYMM()" id="frmCustomerAddress" method="post">
  <input type="hidden" name="addressId" id="addressId" value="%%GLOBAL_AddressId%%">
  <input type="hidden" name="customerId" id="customerId" value="%%GLOBAL_CustomerId%%">
  <input type="hidden" name="newCustomer" id="newCustomer" value="%%GLOBAL_NewCustomer%%">
  <input type="hidden" name="customFieldsAddressFormId" id="customFieldsAddressFormId" value="%%GLOBAL_CustomFieldsAddressFormId%%">
  <input id="currentTab" name="currentTab" value="0" type="hidden">
  <div class="BodyContainer">
  <table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
    <tr>
      <td class="Heading1">%%GLOBAL_Title%%</td>
    </tr>
    <tr>
      <td class="Intro"><p>%%GLOBAL_Intro%%</p>
        %%GLOBAL_Message%%
        <p>
          <input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" name="SaveButton1" />
          <input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="SaveAddAnotherButton1" onclick="saveAndAddAnother();" class="FormButton Field150" />
          <input type="reset" value="%%LNG_Cancel%%" class="FormButton" name="CancelButton1" onclick="confirmCancel()" />
        </p></td>
    </tr>
    <tr>
      <td><ul id="tabnav">
          <li><a href="#" id="tab0" onclick="ShowTab(0)" class="active">%%LNG_CustomerYMMDetails%%</a></li>
        </ul></td>
    </tr>
    <tr>
      <td><div id="div0" style="padding-top: 10px;">
          <div style="padding-bottom:5px">%%LNG_CustomerYMMDetailsIntro%%</div>
          <table width="100%" class="Panel" border="0">
            <tr>
              <td class="Heading2" colspan="2">%%LNG_CustomerYMMDetails%%</td>
            </tr>
            <tr >
              <td colspan="2" align="left" style="padding-top:15px; padding-bottom:15px;"><table border="0">
                  <tr>
                    <td><font color="#FF0000">*</font>&nbsp;<strong>Year</strong> : </td>
                    <td><select name="searchyear" id="searchyear" onchange="getSearchOptions('year',0);getCabBedsize()">
                        %%GLOBAL_YearList%%
                      </select>
                    </td>
                    <td style="width:20px;"></td>
                    <td><font color="#FF0000">*</font>&nbsp;<strong>Make</strong> :</td>
                    <td><select name="searchmake" id="searchmake" onchange="getSearchOptions('make',0)">
                        %%GLOBAL_MakeList%%
                      </select></td>
                    <td style="width:20px;"></td>
                    <td><strong>Model</strong> :</td>
                    <td><select name="searchmodel" id="searchmodel" onchange="getSearchOptions('model',0);getCabBedsize()">
                        %%GLOBAL_ModelList%%
                      </select>
                    </td>
                    
                    
                    <td><strong>%%LNG_YMMBedSize%%</strong>:</td>
                    <td id="tdbed">
                        <select name="bedsize" id="bedsize" onclick=checkYMM()>
                        <option value="">--Select bed size--</option>
                        </option>
                    </td>
                    <td style="width:20px;"></td>
                    <td><strong>%%LNG_YMMCabSize%%</strong>:</td>
                    <td id="tdcab">
                        <select name="cabsize" id="cabsize" onclick=checkYMM()>
                        <option value="">--Select cab size--</option>
                        </option>
                    </td>
                  </tr>
                </table></td>
            </tr>
          </table>
        </div>
    </div>
    
    <table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain" id="SaveButtons">
      <tr>
        <td><input type="submit" value="%%LNG_SaveAndExit%%" name="SaveButton2" class="FormButton" />
          <input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="SaveAddAnotherButton2" onclick="saveAndAddAnother();" class="FormButton Field150" />
          <input type="reset" value="%%LNG_Cancel%%" name="CancelButton2" class="FormButton" onclick="confirmCancel()" />
        </td>
      </tr>
    </table>
    </td>
    
    </tr>
    
  </table>
  </div>
</form>
<script type="text/javascript"><!--

 function getSearchOptions(searchtype,catuniversal) 
    {

	var make = $('#searchmake').val();
	var model = $('#searchmodel').val();
	var year = $('#searchyear').val();
	var universal = catuniversal;

	var params = 'autopopulate=true&make='+make+'&model='+model+'&year='+year+'&universal='+universal+'&ymmtype='+searchtype;
	
	if(searchtype == 'make' && make == '')
	{
		$('#searchmodel').find('option').remove().end();
		$('#searchmodel').append('<option value=\'\'>--select model--</option>');
		return false;
	}

	$.ajax({
	type: "GET",
	url: "%%GLOBAL_ShopPath%%/redefine_filters.php",
	data: params,
	success: function(msg){
	
		var ymm_array=msg.split("~");
		if(searchtype == 'make')
		{
			$('#searchmodel').find('option').remove().end();
			$('#searchmodel').append(ymm_array[0]);
			if(year == '')
			{
				$('#searchyear').find('option').remove().end();
				$('#searchyear').append(ymm_array[1]);
			}
		}
		else if(searchtype == 'model')
		{
			if(year == '')
			{
				$('#searchyear').find('option').remove().end();
				$('#searchyear').append(ymm_array[0]);
			}
		}
		else if(searchtype == 'year')
		{
			if(make != '' && model == '')
			{
				$('#searchmodel').find('option').remove().end();
				$('#searchmodel').append(ymm_array[0]);
			}					
		}			   
	}
	});

}

function getCabBedsize() {
    var make = $('#searchmake').val();
    var model = $('#searchmodel').val();
    var year = $('#searchyear').val();
    var phpUrl = 'getcabbedsize.php';
    var params = 'make='+make+'&model='+model+'&year='+year;
    $.ajax({
    type: "GET",
    url: phpUrl,
    data: params,
    success: function(data)
        {   
            var cabbed = data.split('~');
            $('#tdbed').html(cabbed[0]);
            $('#tdcab').html(cabbed[1]);
        }
    }
    );
}

function checkYMM() {
    var make = document.getElementById('searchmake').value;
    var year = document.getElementById('searchyear').value;
    if(make == '' || year =='') {
        alert("Please select YMM");
    }
}

	function saveAndAddAnother() {
		MakeHidden('addanother', '1', 'frmCustomerAddress');
	}

	function confirmCancel() {
		if(confirm('%%GLOBAL_CancelMessage%%')) {
			if ("%%GLOBAL_CancelGoToManager%%" == "1") {
				document.getElementById('frmCustomerAddress').action = 'index.php?ToDo=viewCustomers';
			} else {
				document.getElementById('frmCustomerAddress').action = 'index.php?ToDo=editCustomer&customerId=%%GLOBAL_CustomerId%%';
				MakeHidden('currentTab', '2', 'frmCustomerAddress');
			}

			document.getElementById('frmCustomerAddress').submit();
			return false;
		} else {
			return false;
		}
	}

	function checkAddCustomerAddressForm()
	{
		var formfields = FormField.GetValues(%%GLOBAL_CustomFieldsAddressFormId%%);

		for (var i=0; i<formfields.length; i++) {
			var rtn = FormField.Validate(formfields[i].field);

			if (!rtn.status) {
				alert(rtn.msg);
				FormField.Focus(formfields[i].field);
				return false;
			}
		}

		return true;
	}
	function ValidateFormYMM() {
	
	if(document.getElementById('searchyear').value=='' || document.getElementById('searchmake').value=='') {
		alert('%%LNG_CustomerYMMYMError%%');
		return false;
		}
	return true;
	}


	%%GLOBAL_FormFieldEventData%%

//--></script>
