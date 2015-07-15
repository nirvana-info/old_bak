<script type="text/javascript" src="../javascript/jquery/plugins/jquery.form.js"></script>
<script type="text/javascript" src="../javascript/formfield.js"></script>

<form action="index.php?ToDo=%%GLOBAL_FormAction%%" onsubmit="return ValidateForm(OrderManager.CheckOrderForm)" id="frmOrder" method="post">
  <input type="hidden" name="orderid" id="orderid" value="%%GLOBAL_OrderId%%">
  <input type="hidden" name="orderSession" id="orderSession" value="%%GLOBAL_OrderSession%%">
  <input type="hidden" name="ordcustid" id="customerId" value="%%GLOBAL_CustomerId%%" />
  <input type="hidden" name="customerType" id="customerType" value="%%GLOBAL_CustomerType%%" />
  <input id="currentTab" name="currentTab" value="0" type="hidden">
  <div class="BodyContainer OrderManager">
    <table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
      <tr>
        <td class="Heading1">%%GLOBAL_Title%%</td>
      </tr>
      <tr>
        <td class="Intro"><p>%%GLOBAL_Intro%%</p>
          <div id="MessageBox"> %%GLOBAL_Message%% </div>
          <p>
				<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" name="SaveAndExit" id="SaveAndExit" />
				<input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="addAnother" id="addAnother" class="FormButton Field120"  />
	        <span style ="display:%%GLOBAL_PayandSaveDisplay%%">
                <input type="submit" value="%%LNG_SaveAndPay%%" name="saveandpay" id="saveandpay" class="FormButton Field150" />
	        </span>
				<input id="cancelbtn" type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="OrderManager.ConfirmCancel()" />
			</p>
		</td>
      </tr>
	<tr id="trOrder">
		<td>
			<table width="100%" class="Panel">
            <tr>
              <td class="Heading2" colspan="2">%%LNG_CustomerDetails%%</td>
            </tr>
            <tr>
              <td colspan="2" style="padding-top:10px"><ul id="tabnav">
                  <li><a href="#" id="tab0" onclick="OrderManager.ShowTab(0); return false;" class="active">%%LNG_NewCustomer%%</a></li>
                  <li><a href="#" id="tab1" onclick="OrderManager.ShowTab(1); return false;">%%LNG_ExistingCustomer%%</a></li>
                  <li><a href="#" id="tab2" onclick="OrderManager.ShowTab(2); return false;">%%LNG_AnonymousCustomer%%</a></li>
                </ul></td>
            </tr>
            <tr>
              <td colspan="2"><div id="div0" style="padding-bottom:5px">
                  <div style="width: 50%; float: left">
                    <table class="Panel" width="100%" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="FieldLabel"><span class="Required">*</span>&nbsp;%%LNG_CustomerEmail%%: </td>
                        <td><input type="text" id="custconemail" name="custconemail" class="Field250" value="%%GLOBAL_CustomerEmail%%">
                        </td>
                      </tr>
                      <!--<tr>
                        <td class="FieldLabel"><span class="Required">*</span>&nbsp;%%LNG_CustomerPassword%%: </td>
                        <td><input type="password" id="custpassword" name="custpassword" class="Field250" value="%%GLOBAL_CustomerPassword%%">
                        </td>
                      </tr>
                      <tr>
                        <td class="FieldLabel"><span class="Required">*</span>&nbsp;%%LNG_CustomerPasswordConfirm%%: </td>
                        <td><input type="password" id="custpassword2" name="custpassword2" class="Field250" value="%%GLOBAL_CustomerPassword%%">
                        </td>
                      </tr>-->
                      <tr style="display: %%GLOBAL_HideCustomFieldsAccountLeftColumn%%;">
                        <td colspan="2"><dl class="FormFieldBackend">
                            %%GLOBAL_CustomFieldsAccountLeftColumn%%
                          </dl></td>
                      </tr>
                    </table>
                  </div>
                  <div style="float: right; width: 50%">
                    <table class="Panel" width="100%" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="FieldLabel">&nbsp;&nbsp; %%LNG_CustomerGroup%%: </td>
                        <td><select id="custgroupid" name="custgroupid" class="Field250">
                            <option value="0">%%LNG_CustomerGroupNotAssoc%%</option>
                            
												%%GLOBAL_CustomerGroupOptions%%
											
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="FieldLabel">&nbsp;&nbsp; %%LNG_CustomerStoreCredit%%: </td>
                        <td> %%GLOBAL_CurrencyTokenLeft%%
                          <input type="text" id="custstorecredit" name="custstorecredit" class="Field80" value="%%GLOBAL_CustomerStoreCredit%%" %%GLOBAL_StoreCreditDisable%%>
                          %%GLOBAL_CurrencyTokenRight%% </td>
                      </tr>
                      <tr style="display: %%GLOBAL_HideCustomFieldsAccountRightColumn%%;">
                        <td colspan="2"><dl class="FormFieldBackend">
                            %%GLOBAL_CustomFieldsAccountRightColumn%%
                          </dl></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div id="div1" style="display:none">
                  <table class="Panel" width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                      <tr id="custSearchRow" style="%%GLOBAL_HideCustomerSearch%%">
                        <td class="FieldLabel">&nbsp;&nbsp; %%LNG_SearchCustomers%%: </td>
                        <td><input type="text" id="custSearchBox" name="custSearchBox" class="Field400" autocomplete="off" value="">
                          <img src="images/loading.gif" id="custSearchIcon" style="display:none" /><br />
                        </td>
                      </tr>
                      <tr id="custResultRow" style="%%GLOBAL_HideSelectedCustomer%%">
                        <td class="FieldLabel">&nbsp;&nbsp; %%LNG_SelectedCustomer%%: </td>
                        <td><div class="Field400 ResultSearchBox" id="custResultBox">
                            <ul>
                              %%GLOBAL_SelectedCustomer%%
                            </ul>
                          </div></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div id="div2" style="padding-top:3px; display:none">
                  <p class="HelpInfo">%%LNG_AnonymousCustomerIntro%%</p>
                  <table class="Panel" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="FieldLabel"><span class="Required">&nbsp;</span>&nbsp;%%LNG_CustomerEmail%%: </td>
                      <td><input type="text" id="anonymousemail" name="anonymousemail" class="Field250" value="%%GLOBAL_AnonymousEmail%%">
                        <img onmouseout="HideHelp('anonymousemailhelp');" onmouseover="ShowHelp('anonymousemailhelp', '%%LNG_CustomerEmail%%', '%%LNG_AnonymousEmailHelp%%')" src="images/help.gif" width="24" height="16" border="0">
                        <div style="display:none" id="anonymousemailhelp"></div></td>
                    </tr>
                  </table>
                </div></td>
            </tr>
          </table>
          <div style="float: left; width: 49%" id="ordbillDetails">
            <table width="100%" class="Panel" style="padding-top: 5px;">
              <tr>
                <td class="Heading2" colspan="2">%%LNG_BillingDetails%%</td>
              </tr>
              <tr class="ShowIfHasAddresses" style="%%GLOBAL_HideAddressSelects%%">
                <td class="FieldLabel"><span class="RequiredClear">&nbsp;</span>&nbsp; <strong>%%LNG_UseExistingAddress%%:</strong> </td>
                <td><select id="existingBillingAddress" class="Field250" onchange="OrderManager.UseExistingAddress('ordbill', $(this).val())" %%GLOBAL_DisableAddressSelects%%>
                    <option value="0">%%LNG_EnterANewAddress%%</option>
                  </select>
                </td>
              </tr>
              <tr>
              
              <td class="FieldLabel"><span class="RequiredClear">&nbsp;</span>&nbsp;
                %%LNG_BillingUseShippingAddress%%: </td>
              <td>
              <label>
              <input type="checkbox" name="billingUseShipping" id="billingUseShipping" value="1" %%GLOBAL_BillingUseShippingChecked%% />
              %%LNG_YesBillingUseShippingAddress%%
              </td>
              
              </tr>
              
              <tr>
                <td colspan="2"><dl class="FormFieldBackend">
                    %%GLOBAL_CustomFieldsBillingColumn%%
                  </dl></td>
              </tr>
              <tr>
                <td class="FieldLabel"><span class="RequiredClear">&nbsp;</span>&nbsp;
                  %%LNG_SaveThisAddress%%: </td>
                <td><label>
                  <input type="checkbox" name="ordbillsaveAddress" id="ordbillsaveAddress" value="0" %%GLOBAL_OrderBillSaveAddress%% />
                  %%LNG_YesSaveThisAddress%%</label>
                </td>
              </tr>
            </table>
          </div>
          <div style="float: right; width: 49%" id="ordshipDetails">
            <table width="100%" class="Panel" style="padding-top: 5px;">
              <tr>
                <td class="Heading2" colspan="2">%%LNG_ShippingDetails%%</td>
              </tr>
              <tr class="ShowIfHasAddresses" style="%%GLOBAL_HideAddressSelects%%">
                <td class="FieldLabel"><span class="RequiredClear">&nbsp;</span>&nbsp; <strong>%%LNG_UseExistingAddress%%:</strong> </td>
                <td><select id="existingShippingAddress" class="Field250" onchange="OrderManager.UseExistingAddress('ordship', $(this).val())" %%GLOBAL_DisableAddressSelects%%>
                    <option value="0">%%LNG_EnterANewAddress%%</option>
                  </select>
                </td>
              </tr>
              <tr>
              
              <td class="FieldLabel"><span class="RequiredClear">&nbsp;</span>&nbsp;
                %%LNG_ShippingUseBillingAddress%%: </td>
              <td>
              <label>
              <input type="checkbox" name="shippingUseBilling" id="shippingUseBilling" value="1" %%GLOBAL_ShippingUseBillingChecked%% />
              %%LNG_YesShippingUseBillingAddress%%
              </td>
              
              </tr>
              
              <tr>
                <td colspan="2"><dl class="FormFieldBackend">
                    %%GLOBAL_CustomFieldsShippingColumn%%
                  </dl></td>
              </tr>
              <tr>
                <td class="FieldLabel"><span class="RequiredClear">&nbsp;</span>&nbsp;
                  %%LNG_SaveThisAddress%%: </td>
                <td><label>
                  <input type="checkbox" name="ordshipsaveAddress" id="ordshipsaveAddress" value="0" %%GLOBAL_OrderShipSaveAddress%% />
                  %%LNG_YesSaveThisAddress%%</label>
              </td>
            </tr>
          </table>
        </div>
        <br style="clear: both" />
        <table width="100%" class="Panel" style="padding-top: 5px;" >
          <tr>
            <td class="Heading2" colspan="2">YMM Details</td>
          </tr>
          <tr>
            <td class="10">
            <div id="YMMDetailsList">
              <input type="hidden" name="WhichToPick" id="WhichToPick" value="0" />
            </div>
            %%GLOBAL_ExistingYMM%%
            <div id="Ymmexisting">
              <Table width="100%" border="0">
                <tr>
                
                <td class="FieldLabel" style="width:30px;"><span class="Required">*</span>&nbsp;Year:</td>
                <td class="FieldLabel" style="width:30px;"><select name="searchyear" id="searchyear" onchange="getSearchOptions('year',0);getCabBedsize()">
                    
                          
                          
                        %%GLOBAL_YearList%%
                      
                        
                        
                  </select></td>
                <td class="FieldLabel" style="width:30px;"><span class="Required">*</span>&nbsp;Make:</td>
                <td class="FieldLabel" style="width:50px;"><select name="searchmake" id="searchmake" onchange="getSearchOptions('make',0)">
                    
                          
                          
                        %%GLOBAL_MakeList%%
                      
                        
                        
                  </select></td>
                <td class="FieldLabel" style="width:30px;"><span class="Required">&nbsp;</span>&nbsp;Model:</td>
                <td class="FieldLabel" style="width:50px;"><select name="searchmodel" id="searchmodel" onchange="getSearchOptions('model',0);getCabBedsize()">
                    
                          
                          
                        %%GLOBAL_ModelList%%
                      
                        
                        
                  </select></td>
                <td>%%LNG_YMMBedSize%%:</td>
                <td id="tdbed">
                
                <select name="bedsize" id="bedsize" onclick=checkYMM()>
                
                <option value="">--Select bed size--</option>
                </option>
                
                </td>
                
                <td style="width:20px;">
                </td>
                
                <td>
                <strong>
                %%LNG_YMMCabSize%%
                </strong>
                :
                </td>
                
                <td id="tdcab">
                
                <select name="cabsize" id="cabsize" onclick=checkYMM()>
                
                <option value="">--Select cab size--</option>
                </option>
                
                </td>
                
                </tr>
                
              </table>
            </div>
            </td>
          </tr>
        </table>
          <table width="100%" class="Panel" style="padding-top:5px" id="orderTable">
            <tr>
              <td class="Heading2">%%LNG_OrderItems%%</td>
            </tr>
            <tr>
              <td style="padding-top:10px"><table width="100%" cellspacing="0" cellpadding="0" class="CartGrid">
                  <thead>
                    <tr>
		      <td width="30" style="text-align: center;">&nbsp;</td>
                      <td width="10%">SKU</td>
                      <td colspan="2">%%LNG_Product%%</td>
                      <td width="100" style="text-align: center;">%%LNG_Qty%%</td>
                      <td width="70" style="text-align: center;">%%LNG_ItemPrice%%</td>
                      <td width="100" class="Right">%%LNG_ItemTotal%%</td>
                      <td width="50">&nbsp;</td>
                    </tr>
                  </thead>
                  <tbody id="orderItemsTable">
                  
                  %%GLOBAL_OrderItems%%
                  </tbody>
                  
                  <tbody id="orderSummaryTable">
                  
                  %%GLOBAL_OrderSummary%%
                  </tbody>
                  
                </table></td>
            </tr>
          </table>
          <table width="100%" class="Panel" style="padding-top: 5px;">
            <tr>
              <td class="Heading2" width="50%">%%LNG_OtherOrderDetails%%</td>
              <td class="Heading2" width="50%">%%LNG_PaymentMethod%%</td>
            </tr>
            <tr>
              <td style="vertical-align: top"><table class="Panel" width="100%">
                  <tr>
                    <td class="FieldLabel">%%LNG_OrderComments%%:</td>
                    <td><textarea name="ordcustmessage" id="ordcustmessage" style="width: 95%" rows="5">%%GLOBAL_OrderComments%%</textarea></td>
                  </tr>
                  <tr>
                    <td class="FieldLabel">%%LNG_StaffNotes%%:</td>
                    <td><textarea name="ordnotes" id="ordnotes" style="width: 95%;" rows="5">%%GLOBAL_OrderNotes%%</textarea></td>
                  </tr>
                  <tr>
                    <td class="FieldLabel">%%LNG_OrderStatus%%:</td>
								<td>
									<select name="ordstatus" id="ordstatus" class="Field250" onchange="OrderManager.ToggleOrderStatus(this.value)">
                        
										%%GLOBAL_OrderStatusOptions%%
									
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td class="FieldLabel">%%LNG_TrackingNo%%:</td>
                    <td><input type="text" name="ordtrackingno" value="%%GLOBAL_OrderTrackingNo%%" id="ordtrackingno" class="Field250" /></td>
                  </tr>
                  <tr style="%%GLOBAL_HideEmailInvoice%%">
                    <td class="FieldLabel">%%LNG_EmailCustomerInvoice%%:</td>
                    <td><label>
                      <input type="checkbox" id="emailinvoice" name="emailinvoice" value="1" %%GLOBAL_EmailInvoiceChecked%% />
                      %%LNG_YesEmailCustomerInvoice%%</label>
                    </td>
                  </tr>
                </table></td>
              <td id="PaymentMethodList" style="vertical-align: top"> %%GLOBAL_PaymentMethodsList%% </td>
            </tr>
          </table>
          <table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain" id="SaveButtons">
            <tr>
					<td>
						<input type="submit" value="%%LNG_SaveAndExit%%" class="FormButton" name="SaveAndExit1" id="SaveAndExit1" />
						<input type="submit" value="%%GLOBAL_SaveAndAddAnother%%" name="addAnother" id="addAnother1" class="FormButton Field150" />
		<span style ="display:%%GLOBAL_PayandSaveDisplay%%">
                <input type="submit" value="%%LNG_SaveAndPay%%" name="saveandpay" id="saveandpay1" class="FormButton Field150" />
		</span>
						<input id="cancelbtn1" type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="OrderManager.ConfirmCancel()" />
              </td>
            </tr>
          </table></td>
      </tr>
    </table>
  </div>
  <!-- Begin Apply Coupon Code Box -->
  <div id="applyCoupon" style="display: none">
    <div class="ModalTitle"> %%LNG_ApplyCouponGiftCertificate%% </div>
    <div class="ModalContent">
      <p>%%LNG_ApplyCouponGiftCertificateIntro%%</p>
      <table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
        <tr>
          <td class="FieldLabel"> %%LNG_GiftCertificateCode%%: </td>
          <td><input type="text" name="couponcode" class="couponcode Field250" value="" /></td>
        </tr>
      </table>
    </div>
    <div class="ModalButtonRow">
      <div class="FloatLeft">
        <input type="button" value="%%LNG_Cancel%%" onclick="$.modal.close()" />
      </div>
      <input type="button" class="Submit" value="%%LNG_Apply%%" onclick="OrderManager.ApplyCoupon()" />
    </div>
  </div>
  <!-- End Apply Coupon Code Box -->
  <input type="hidden" name="ordbillemail" value="%%GLOBAL_OrderBillEmail%%"/>
  <input type="hidden" name="ordshipemail" value="%%GLOBAL_OrderShipEmail%%"/>
</form>
<script type="text/javascript">

lang.OrderCustomerChange = '%%LNG_OrderCustomerChange%%';
lang.OrderCommentsDefault = '%%LNG_OrderCommentsDefault%%';
lang.OrderNotesDefault = '%%LNG_OrderNotesDefault%%';
lang.EnterCouponOrGiftCertificate = '%%LNG_EnterCouponOrGiftCertificate%%';
lang.ConfirmRemoveProductFromOrder = '%%LNG_ConfirmRemoveProductFromOrder%%';
lang.ChooseVariationBeforeAdding = '%%LNG_ChooseVariationBeforeAdding%%';
lang.EnterProductRequiredFields = '%%LNG_EnterProductRequiredFields%%';
lang.ChooseValidProductFieldFile = '%%LNG_ChooseValidProductFieldFile%%';
lang.AddingProductToOrder = '%%LNG_AddingProductToOrder%%';
lang.UpdatingProductInOrder = '%%LNG_UpdatingProductInOrder%%';
lang.CustomerEmailRequired = "%%LNG_CustomerEmailRequired%%";
lang.CustomerPasswordRequired = "%%LNG_CustomerPasswordRequired%%";
lang.CustomerPasswordConfirmRequired = "%%LNG_CustomerPasswordConfirmRequired%%";
lang.CustomerEmailInvalue = "%%LNG_CustomerEmailInvalue%%";
lang.CustomerNewPasswordConfirmError = "%%LNG_CustomerNewPasswordConfirmError%%";
lang.OrderMustContainOneProduct = "%%LNG_OrderMustContainOneProduct%%";
lang.InvalidPaymentModule = "%%LNG_InvalidPaymentModule%%";
lang.ErrorChooseShippingMethod = "%%LNG_ErrorChooseShippingMethod%%";
lang.ErrorEnterShippingMethodName = "%%LNG_ErrorEnterShippingMethodName%%";
lang.ErrorEnterShippingMethodPrice = "%%LNG_ErrorEnterShippingMethodPrice%%";
lang.ConfirmCancel = "%%LNG_ConfirmCancel%%";
lang.EnterValidStoreCredit = "%%LNG_EnterValidStoreCredit%%";
lang.OrderNeedsRefreshing = "%%LNG_OrderNeedsRefreshing%%";
lang.AnonymousEmailInvoiceMissingEmail = "%%LNG_AnonymousEmailInvoiceMissingEmail%%";
lang.ErrorSelectACustomer = '%%LNG_ErrorSelectACustomer%%';
lang.CustomerAddressFirstNameRequired = '%%LNG_CustomerAddressFirstNameRequired%%';
lang.CustomerAddressLastNameRequired = '%%LNG_CustomerAddressLastNameRequired%%';
lang.CustomerAddressAddressLine1Required = '%%LNG_CustomerAddressAddressLine1Required%%';
lang.CustomerAddressCityRequired = '%%LNG_CustomerAddressCityRequired%%';
lang.CustomerAddressCountryRequired = '%%LNG_CustomerAddressCountryRequired%%';
lang.CustomerAddressPostCodeRequired = '%%LNG_CustomerAddressPostCodeRequired%%';

lang.CustomFieldsValidationRequired = "%%LNG_CustomFieldsValidationRequired%%";
lang.CustomFieldsValidationNumbersOnly = "%%LNG_CustomFieldsValidationNumbersOnly%%";
lang.CustomFieldsValidationNumbersToLow = "%%LNG_CustomFieldsValidationNumbersToLow%%";
lang.CustomFieldsValidationNumbersToHigh = "%%LNG_CustomFieldsValidationNumbersToHigh%%";
lang.CustomFieldsValidationDateToLow = "%%LNG_CustomFieldsValidationDateToLow%%";
lang.CustomFieldsValidationDateToHigh = "%%LNG_CustomFieldsValidationDateToHigh%%";

var OrderCustomFormFieldsAccountFormId = %%GLOBAL_OrderCustomFormFieldsAccountFormId%%;
var OrderCustomFormFieldsBillingFormId = %%GLOBAL_OrderCustomFormFieldsBillingFormId%%;
var OrderCustomFormFieldsShippingFormId = %%GLOBAL_OrderCustomFormFieldsShippingFormId%%;

$(document).ready(function() {
	OrderManager.Init();
	OrderManager.ShowTab(%%GLOBAL_CurrentTab%%);
	%%GLOBAL_AddressJson%%
	if(!($('#ordstatus').val()==1||$('#ordstatus').val()==7||$('#ordstatus').val()==14)){
		$("#saveandpay").hide();
		$("#saveandpay1").hide();
		$("#SaveAndExit").show();
		$("#SaveAndExit1").show();
	}
	//OrderManager.ToggleReadonlyByOrderStatus($('#ordstatus').val());
});
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




function ShowHideYMM(val) {

	if(val==1) {
		document.getElementById('Ymmexisting').style.display='none';
	}
	else {
		document.getElementById('Ymmexisting').style.display='block';
		
	}
}
function setpaypalpaymentstatus(pval)
{
	if(pval == 'creditcard' || pval == 'checkout_authorizenet')
	{
		$("#saveandpay").show();
		$("#saveandpay1").show();
	}
	else
	{
		$("#saveandpay").hide();
		$("#saveandpay1").hide();
	}


	if(pval == 'paypal_admin')
	{
		$("#ordstatus option[value='14']").attr('selected', 'selected');
	}
	else
	{
		$("#ordstatus option[value='7']").attr('selected', 'selected');
	}
	OrderManager.ToggleOrderStatus($('#ordstatus').val());
	
}

function ResetPrice(obj){
	var $input = $(obj).parent().find('input[type=text]');
	if(obj.checked){
		$input.attr('readonly', false);
		if($input.hasClass('ReadonlyText'))
			$input.removeClass('ReadonlyText');
		obj.value = 1;
	}else{
		$input.attr('readonly', true);
		$input.addClass('ReadonlyText');
		obj.value = 0;
	}
}

// Baskaran starts
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
// Baskaran ends
function ConfirmCancel()
    {
        if(confirm(lang.ConfirmCancel)) {
            window.location = 'index.php?ToDo=viewOffers';
        }
    }
%%GLOBAL_FormFieldEventData%%
</script>
<script type="text/javascript" src="script/order.manager.js"></script>
<iframe id="disOrderItem" allowtransparency="true" scrolling="no" frameborder="0" border="0" width="1" height="1">
<body style="background-color:transparent">
</body> 
</iframe>
<iframe id="disOrderItem2" allowtransparency="true" scrolling="no" frameborder="0" border="0" width="1" height="1">
<body style="background-color:transparent">
</body> 
</iframe>
