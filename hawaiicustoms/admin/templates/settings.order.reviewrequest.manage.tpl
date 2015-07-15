<!--p>I am settings.order.reviewrequest.manage.tpl</p-->
<input id="currentTab" name="currentTab" value="0" type="hidden">	
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
        <tr>
            <td>
                <ul id="tabnav">
                    <li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_OrderReviewRequestSettings%%</a></li>
                    <li><a href="#" id="tab1" onclick="ShowTab(1)">Config</a></li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
            <div id="div0" class="text">
                <table width="100%">
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
            </td> 
        </tr>
        <tr>
            <td>
            <div id="div1" style="display:none;" class="text">
                <div id="ajaxContainer1"></div>
                <table>
                <tr>            
                    <td class="Heading1">Config</td>
                </tr>
                <tr>
                    <td>
                         Send requests automatically: <input type="radio" id="sendrequest" name="sendrequest" onclick="setrequestenable(1)" %%GLOBAL_Enable%%>Enable<input type="radio" id="sendrequest" name="sendrequest" onclick="setrequestenable(0)" %%GLOBAL_Disable%%>Disable
                    </td>
                </tr>
                <tr>
                    <td>
                         Request after: number of days, by default <select id="requestafter" onchange="requestafter()">%%GLOBAL_RequestDays%%</select> days
                    </td>
                </tr>
                <tr>
                    <td>
                         No request after: number of days, by default <select id="norequest" onchange="norequest()">%%GLOBAL_NoRequestDays%%</select> days.
                    </td>
                </tr>
                <tr>
                    <td>
                         Re-send Request after: number of days, by default <select id="resend" onchange="resend()">%%GLOBAL_ResendDays%%</select> days.
                    </td>
                </tr>
                <tr>
                    <td>
                         Repeat request: maximum number of requests, by default <select id="repeatrequest" onchange="repeatrequest()">%%GLOBAL_RepeatDays%%</select> days.
                    </td>
                </tr>
                </table>
            </div> 
            </td>
        </tr>
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
        
        function ShowTab(T) {
        i = 0;

            while (document.getElementById("tab" + i) != null) {
                document.getElementById("div" + i).style.display = "none";
                document.getElementById("tab" + i).className = "";
                i++;
            }
            document.getElementById("div" + T).style.display = "";
            document.getElementById("tab" + T).className = "active";
            document.getElementById("currentTab").value = T;

            // What should the intro text be?
        }
        
        function setrequestenable(enable)
        {
            //alert(requestId);
            $.ajax({
                type    : "GET",
                url        : "index.php",
                data    : {
                    'ToDo': 'setenablerequestscriptsettings',
                    'enable': enable,
                    'ajax':'1'
                },
                success    : function(data){
                    if(data == "1")
                    {
                        $('#ajaxContainer1').html('Send request is Enabled');
                    }
                    else
                    {
                        $('#ajaxContainer1').html('Send request is Disabled');
                    }
                }
            });
        }
        
        function requestafter() {
            i = $('#requestafter').val();
            $.ajax({
                type    : "GET",
                url        : "index.php",
                data    : {
                    'ToDo': 'setrequestafterrequestscriptsettings',
                    'requestafter': i,
                    'ajax':'1'
                },
                success    : function(data){
                    if(data == "1")
                    {
                        $('#ajaxContainer1').html('Request after date updated');
                    }
                    else
                    {
                        $('#ajaxContainer1').html('Disable');
                    }
                }
            });
        }
        
        function norequest() {
            i = $('#norequest').val();
            $.ajax({
                type    : "GET",
                url        : "index.php",
                data    : {
                    'ToDo': 'setnorequestrequestscriptsettings',
                    'norequest': i,
                    'ajax':'1'
                },
                success    : function(data){
                    if(data == "1")
                    {
                        $('#ajaxContainer1').html('No Request date updated');
                    }
                }
            });
        }
        
        function resend() {
            i = $('#resend').val();
            $.ajax({
                type    : "GET",
                url        : "index.php",
                data    : {
                    'ToDo': 'setresendrequestscriptsettings',
                    'resend': i,
                    'ajax':'1'
                },
                success    : function(data){
                    if(data == "1")
                    {
                        $('#ajaxContainer1').html('Resend date updated');
                    }
                }
            });
        }
        
        function repeatrequest() {
            i = $('#repeatrequest').val();
            $.ajax({
                type    : "GET",
                url        : "index.php",
                data    : {
                    'ToDo': 'setrepeatrequestscriptsettings',
                    'repeatrequest': i,
                    'ajax':'1'
                },
                success    : function(data){
                    if(data == "1")
                    {
                        $('#ajaxContainer1').html('Repeat request date updated');
                    }
                }
            });
        }

	</script>



