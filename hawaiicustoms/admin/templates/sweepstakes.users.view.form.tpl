<form action="index.php?ToDo=%%GLOBAL_FormAction%%" onSubmit="return ValidateForm(CheckForm)" name="frmAddBrand" method="post" enctype="multipart/form-data">
<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1">%%GLOBAL_SweepstakesUsersTitle%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_SweepstakesUsersIntro%%</p>
			%%GLOBAL_Message%%

		</td>
	</tr>
    <tr>
        <td>
            <input type="button" value="%%LNG_UserBack%%" class="FormButton" onclick="ClickBack()">
        </td>
        <td>&nbsp;</td>
    </tr>
	<tr>
		<td>
			<table class="Panel">
				<tr>
					<td class="Heading2" colspan=2>%%LNG_SweepstakesUsersDetails%%</td>
				</tr>
                <tr>
                        <td class="FieldLabel">
                            &nbsp;&nbsp;&nbsp;%%LNG_Name%%:
                        </td>
                        <td>
                            %%GLOBAL_Name%%
                        </td>
                </tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_Email%%:
					</td>
					<td>
                        %%GLOBAL_Email%%
					</td>
				</tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_PhoneNumber%%:
                    </td>
                    <td>
                        %%GLOBAL_PhoneNumber%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_AddressLine1%%:
                    </td>
                    <td>
                        %%GLOBAL_AddressLine1%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_AddressLine2%%:
                    </td>
                    <td>
                        %%GLOBAL_AddressLine2%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_City%%:
                    </td>
                    <td>
                        %%GLOBAL_City%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_State%%:
                    </td>
                    <td>
                        %%GLOBAL_State%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Country%%:
                    </td>
                    <td>
                        %%GLOBAL_Country%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_ZipCode%%:
                    </td>
                    <td>
                        %%GLOBAL_ZipCode%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_ReceivingMail%%:
                    </td>
                    <td>
                        %%GLOBAL_ReceivingMail%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Year%%:
                    </td>
                    <td>
                        %%GLOBAL_Year%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Make%%:
                    </td>
                    <td>
                        %%GLOBAL_Make%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Model%%:
                    </td>
                    <td>
                        %%GLOBAL_Model%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_OrdersId%%:
                    </td>
                    <td>
                        %%GLOBAL_OrderId%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_Status%%:
                    </td>
                    <td>
                        %%GLOBAL_Status%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_AddedBy%%:
                    </td>
                    <td>
                        %%GLOBAL_Addedby%%
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_UrlReferrer%%:
                    </td>
                    <td>
                        <a href="%%GLOBAL_UrlReferrer%%" target="_blank">%%GLOBAL_UrlReferrer%%</a>
                    </td>
                </tr>
                <tr>
                    <td class="FieldLabel">
                        &nbsp;&nbsp;&nbsp;%%LNG_CreatedDate%%:
                    </td>
                    <td>
                        %%GLOBAL_CreatedDate%%
                    </td>
                </tr>
			</table>
		</td>
	</tr>
    <tr>
        <td>
            <input type="button" value="%%LNG_UserBack%%" class="FormButton" onclick="ClickBack()">
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
</div>
</form>

<script type="text/javascript">
    function ClickBack()
    {
        document.location.href='index.php?ToDo=viewerSweepstakes';
    }

</script>