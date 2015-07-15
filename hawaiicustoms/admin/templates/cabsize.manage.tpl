    <div class="BodyContainer">
    <table id="Table13" cellSpacing="0" cellPadding="0" width="100%">        
        <tr>
            <td class="Heading1">%%LNG_ManageCabsize%%</td>
        </tr>
        <tr>
        <td class="Intro">
            <p>%%LNG_ManageCabsizeIntro%%</p>
            %%GLOBAL_Message%%
                <table class="GridPanel" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
                <tr>
                    <td colspan="7">
                        <input type="button" name="IndexCabButton" value="%%LNG_CreateCabsize%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=createCabsizesettings'" style="width:160px" /> &nbsp;
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <a href="index.php?ToDo=viewBedsizeSettings">%%LNG_ManageBedsize%%</a>
                    </td>
                </tr>
            </table>
        </td>
        </tr>
        <tr>
        <td style="display: %%GLOBAL_DisplayGrid%%">
            <div class="GridContainer">
                %%GLOBAL_CabsizeDataGrid%%
            </div>
        </td></tr>
    </table>
    </div>
<script>
function deleteCabid(id) {
     if(confirm("%%LNG_ConfirmCancelDeleteCabsize%%")) {
        document.location.href = "index.php?ToDo=deleteCabsizeSettings&cabId="+id;
    }
}
</script>
