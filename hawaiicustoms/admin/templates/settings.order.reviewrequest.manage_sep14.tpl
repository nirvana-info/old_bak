<!--p>I am settings.order.reviewrequest.manage.tpl</p-->
	
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>			
			<td class="Heading1">%%LNG_OrderReviewRequestSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_OrderReviewRequestSettingsIntro%%</p>
				%%GLOBAL_Message%%
				<div id="ajaxContainer"></div>
				<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td class="Intro" valign="top">
							<input type="button" name="IndexCreateButton" value="%%LNG_CreateReviewRequestTemplate%%..." id="IndexCreateButton" class="Button" onclick="document.location.href='index.php?ToDo=createrequestscriptsettings'" /> &nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
						</td>
						<td class="SmallSearch" align="right">
							&nbsp;
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
		<td>
			<form name="frmRequest" id="frmRequest" action="index.php?ToDo=deleterequestscriptsettings" method="post">
				<div class="GridContainer">
					%%GLOBAL_OrderReviewRequestDataGrid%%
				</div>
			</form>
		</td></tr>
		</table>
		</div>


		<script type="text/javascript">
		
		$(document).ready(function() { 
			//alert("ok");
			//var rdoarary = $("input[@type=checkbox]");
			//alert(rdoarary.length);
			$("input[@type=radio]").each(function(){
				//alert("ok2");
				if($(this).val() == "1")
				{
					$(this).attr("checked",true);
				}
				});
			 
			
		});
			
		
		function setdefaulttemplate(requestId)
		{
			//alert(requestId);
			
			$.ajax({
				type	: "GET",
				url	    : "index.php",
				data    : {
		        	'ToDo': 'setdefaultrequestscriptsettings',
		        	'requestId': requestId,
		        	'ajax':'1'
		        },
				success	: function(data){
					if(data == "1")
					{
						$('#ajaxContainer').html('%%LNG_DefaultTemplateSetSuccessfully%%');
					}
					else
					{
						$('#ajaxContainer').html('%%LNG_DefaultTemplateSetFailed%%');
					}
				}
			});
		}

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmRequest").elements;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].value != 1)
					fp[i].checked = Status;
			}
		}

		function ConfirmDeleteSelected()
		{
			var fp = document.getElementById("frmRequest").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteReviewRequest%%"))
					document.getElementById("frmRequest").submit();
			}
			else
			{
				alert("%%LNG_ChooseReviewRequest%%");
			}
		}

	</script>



