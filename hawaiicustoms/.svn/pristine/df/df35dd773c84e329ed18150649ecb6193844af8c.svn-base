    <div class="BodyContainer">
    <table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
        <tr>
            <td class="Heading1">%%LNG_ManageBedsize%%</td>
        </tr>
        <tr>
        <td class="Intro">
            <p>%%LNG_ManageBedsizeIntro%%</p>
            %%GLOBAL_Message%%
                <table class="GridPanel" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
                <tr>
                    <td colspan="7">
                        <input type="button" name="IndexAddButton" value="%%LNG_CreateBedsize%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=createBedsizesettings'" style="width:160px" /> &nbsp;
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="index.php?ToDo=viewCabsizeSettings">%%LNG_ManageCabsize%%</a>
                    </td>
                </tr>
            </table>
        </td>
        </tr>
        <tr>
        <td style="display: %%GLOBAL_DisplayGrid%%">
            <div class="GridContainer">
                %%GLOBAL_BedsizeDataGrid%%
            </div>
        </td></tr>
    </table>
    </div>
<script>
function deletebedid(id) {
     if(confirm("%%LNG_ConfirmCancelDeleteBedsize%%")) {
        document.location.href = "index.php?ToDo=deleteBedsizeSettings&bedId="+id;
    }
}
</script>
