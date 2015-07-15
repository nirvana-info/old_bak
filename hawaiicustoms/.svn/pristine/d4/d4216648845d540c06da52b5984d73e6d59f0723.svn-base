	<div class="BodyContainer">
		<script type="text/javascript">
			ShowLoadingIndicator();
			window.onload = function() {
				HideLoadingIndicator();
			};
		</script>
		<form name="frmPages" id="frmPages" method="post" action="index.php?ToDo=deleteabtesting">
		<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
			<tr>
				<td class="Heading1">%%LNG_ViewPages%%</td>
			</tr>
			<tr>
			<td class="Intro">
				<p>%%GLOBAL_PageIntro%%</p>
				<div id="PagesStatus">%%GLOBAL_Message%%</div>
				<p class="Intro">
					Page Type: 
					<select name='ptype' id='ptype'>
						<option value=''> -- Select page type -- </option>
						<option value='static'>Static page</option>
						<option value='category'>Category page</option>
						<option value='subcategory'>Sub-category page</option>
					</select>
					<input type="button" name="IndexAddButton" value="%%LNG_CreatePage%%..." id="IndexCreateButton" class="SmallButton" onclick="CreatePage()" /> &nbsp;
					<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
				</p>
			</td>
			</tr>
			<tr>
                <td style="display: %%GLOBAL_DisplayGrid%%">
                    <div class="GridContainer">
                        %%GLOBAL_TestingDataGrid%%
                    </div>
                </td>
            </tr>
		</table>
				</form>
	</div>
	<script type="text/javascript">
    
        function quickToggle(element)
        {
            var image = element.childNodes[0];
            if(image.src.indexOf('tick')==-1) {
                var confirmMessage = "%%LNG_PageVisibleConfirmation%%";
            } else {
                var confirmMessage = "%%LNG_PageInvisibleConfirmation%%";
            }
            if(confirm(confirmMessage)) {
                $.ajax({
                    url: element.href + '&ajax=1',
                    dataType: 'script',
                    success: function(response) {

                        if(status == 0) {
                            display_error('CategoriesStatus', '%%LNG_ErrPageVisibileNotChanged%%');
                        }
                        else {
                            display_success('CategoriesStatus', message);
                        }
                    }
                });
            }
        }
        
        function ToggleActiveIcon(elementID, what, active) {
            var element = document.getElementById(elementID);
            if(element.childNodes.length == 1 && element.childNodes[0].tagName == "IMG") {
            var image = element.childNodes[0];
            // Element was ticked, now should not be
            if(active == 0) {
                element.href = element.href.replace(what+'=0', what+'=1');
                image.src = image.src.replace('tick', 'cross');
                location.href = "%%GLOBAL_ShopPath%%/admin/index.php?ToDo=viewABTesting"; 
            }
            else{
                element.href = element.href.replace(what+'=1', what+'=0');  
                image.src = image.src.replace('cross', 'tick'); 
                location.href = "%%GLOBAL_ShopPath%%/admin/index.php?ToDo=viewABTesting";
                }
            }
        }
    
		function CreatePage()
		{
		  var ptype = $('#ptype option:selected').val();
		  if(ptype == '')
		  {
			alert('Please select page type');
			return false;
		  }
		  document.location.href='index.php?ToDo=createABTesting&pagetype='+ptype;
		}

		function ConfirmDeleteSelected()
		{
			var fp = document.getElementById("frmPages").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeletePages%%"))
					document.getElementById("frmPages").submit();
			}
			else
			{
				alert("%%LNG_ChoosePages%%");
			}
		}

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmPages").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}

		function PreviewPage(PageId)
		{         
			var l = screen.availWidth / 2 - 300;
			var t = screen.availHeight / 2 - 300;
			var win = window.open('index.php?ToDo=preABTesting&pageId='+PageId, 'pagePreview', 'width=600,height=600,left='+l+',top='+t+',scrollbars=1');
		}
	</script>