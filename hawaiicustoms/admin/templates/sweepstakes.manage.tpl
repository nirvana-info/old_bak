
	<div class="BodyContainer">
    <table id="Table13" cellSpacing="0" cellPadding="0" width="100%">  
        <tr>
            <td class="Heading1">%%LNG_Sweepstakes%%</td>
        </tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_SweepstakesIntro%%</p>
			%%GLOBAL_Message%%<BR>
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			    <td class="Intro" valign="top">
				    <input type="button" name="IndexAddButton" value="%%LNG_AddSweepstakes%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addSweepstakes'" /> 
			    </td>
			</tr>
			</table>
		</td>
		</tr>
<td>
</td>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<div class="GridContainer">
				%%GLOBAL_SweepstakesDataGrid%%
			</div>
		</td></tr>
	</table>
	</div>           
    <script>
function deleteSweepstakesid(id) {
     if(confirm("%%LNG_ConfirmDeleteSweepstakes%%")) {
        document.location.href = "index.php?ToDo=deleteSweepstakes&sid="+id;
    }
}  
ShowLoadingIndicator();
        window.onload = function() {
            HideLoadingIndicator();
        };

        function quickToggle(element)
        {
            var image = element.childNodes[0];
            if(image.src.indexOf('tick')==-1) {
                var confirmMessage = "%%LNG_SweepstakesVisibleConfirmation%%";
            } else {
                var confirmMessage = "%%LNG_SweepstakesInvisibleConfirmation%%";
            }
            if(confirm(confirmMessage)) {
                $.ajax({
                    url: element.href + '&ajax=1',
                    dataType: 'script',
                    success: function(response) {

                        if(status == 0) {
                            display_error('CategoriesStatus', '%%LNG_ErrQualifierVisibileNotChanged%%');
                        }
                        else {
                            display_success('CategoriesStatus', message);
                        }
                    }
                });
            }
        }    
 function ToggleActiveIcon(elementID, what, active)
    {
        var element = document.getElementById(elementID);
        if(element.childNodes.length == 1 && element.childNodes[0].tagName == "IMG") {
        var image = element.childNodes[0];
        // Element was ticked, now should not be
        if(active == 0) {
            element.href = element.href.replace(what+'=0', what+'=1');
            image.src = image.src.replace('tick', 'cross');
            location.href = "http://www.truckchamp.com/admin/index.php?ToDo=viewSweepstakes"; 
        }
        else{
            element.href = element.href.replace(what+'=1', what+'=0');  
            image.src = image.src.replace('cross', 'tick'); 
            location.href = "http://www.truckchamp.com/admin/index.php?ToDo=viewSweepstakes"; 
            }
        }
    }

</script>