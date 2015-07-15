<form action="index.php?ToDo=%%GLOBAL_FormAction%%&oid=%%GLOBAL_OrderNo%%" onSubmit="return ValidateForm()" name="frmPayment" method="post" enctype="multipart/form-data">
<div class="BodyContainer">
    <table class="OuterPanel">
        <tr>
            <td class="Heading1">%%GLOBAL_OrderTitle%%</td>
        </tr>
        <tr>
        <td class="Intro">
            <p>%%GLOBAL_OrderIntro%%</p>
            %%GLOBAL_Message%%

        </td>
    </tr>

    <tr>
        <td>
            <div>
                <input type="submit" name="SubmitButton1" value="%%LNG_PayforOrder%%" class="FormButton">
                <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"><br /><img src="images/blank.gif" width="1" height="10" />
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <table class="Panel">
                <tr>
                    <td class="Heading2" colspan=2>%%LNG_PayOrder%%</td>
                </tr>
                <tr>
                        <td class="FieldLabel">
                            <span class="Required">*</span>&nbsp;%%LNG_CardHoldersName%%:
                        </td>
                        <td>
                            <input type="text" name="name" id="name" class="Field200" value="%%GLOBAL_Name%%">
                        </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        <span class="Required">*</span>&nbsp;%%LNG_CreditCardNo%%:
                    </td>
                    <td>
                        <input type="text" name="ccno" id="ccno" class="Field200" value="%%GLOBAL_Num%%">
                    </td>
                </tr>
                 <tr>
                        <td class="FieldLabel">
                            <span class="Required">*</span>&nbsp;%%LNG_CreditCardCCV2%%:
                        </td>
                        <td>
                            <input type="text" class="Field50" name="cc_cvv2" id="cc_cvv2" value="%%GLOBAL_CCV2%%" size="4" />
                        </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        <span class="Required">*</span>&nbsp;%%LNG_ExpirationDate%%:
                    </td>
                    <td>
                        <select name="ccexpm" id="ccexpm">
                            <option value=""></option>
                            %%GLOBAL_OrderMonths%%
                        </select>
                        <select name="ccexpy" id="ccexpy">
                            <option value=""></option>
                            %%GLOBAL_OrderYears%%
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Amount%%:
                    </td>
                    <td>
                       <strong>%%GLOBAL_amount%%</strong>
                    </td>
                </tr> 
            </table>
        </td>
    </tr>
    <tr><td class="Gap" colspan="2"></td></tr> 
    <tr>
        <td>
            <input type="submit" name="SubmitButton2" value="%%LNG_PayforOrder%%" class="FormButton">
            <input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
        </td>
    </tr>   
</table>
</div>
</form>
<script>
function ConfirmCancel()
    {
        if(confirm("%%LNG_CancelPayment%%")) {
            window.location = 'index.php?ToDo=viewOrders';
        }
    }

function ValidateForm() {    
    if($('#name').val() == "") {
            alert("%%LNG_EnterName%%");
            $('#name').focus();
            return false;
    }

    if(isNaN($('#ccno').val()) || $('#ccno').val() == "") {
        alert("%%LNG_EnterCardNumber%%");
        $('#ccno').focus();
        $('#ccno').select();
        return false;
    }

    if($('#cc_cvv2').val() == '' || isNaN($('#cc_cvv2').val()) || $('#cc_cvv2').val().length > 4) {
        alert('%%LNG_EnterCVV2Number%%');
        $('#cc_cvv2').focus();
        $('#cc_cvv2').select();
        return false;
    }

    if($('#ccexpm').attr("selectedIndex") == 0) {
        alert("%%LNG_EnterCreditCardMonth%%");
        $('#ccexpm').focus();
        return false;
    }

    if($('#ccexpy').attr("selectedIndex") == 0) {
        alert("%%LNG_EnterCreditCardYear%%");
        $('#ccexpy').focus();
        return false;
    }
}
</script>