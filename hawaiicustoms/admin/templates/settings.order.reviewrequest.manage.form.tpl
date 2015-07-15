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
				<!--p>
					<input type="submit" value="%%LNG_Save%%" class="FormButton" />
					<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				</p-->
			</td>
		</tr>
		<tr>
			<td>
				<ul id="tabnav">
					<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_OrderReviewRequestSettings%%</a></li>
					<li style="display:none"><a href="#" id="tab1" onclick="ShowTab(1)"></a></li>
					%%GLOBAL_OrderTabs%%
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				<form action="index.php?ToDo=%%GLOBAL_FormAction%%" name="frmOrderReviewRequestSettings" id="frmOrderReviewRequestSettings" method="post" onsubmit="return checkform();">
				<input id="currentTab" name="currentTab" value="0" type="hidden">
				<div id="div0" style="padding-top: 10px;">
					<table width="100%" class="Panel">
						<tr class="" style="">     
                            <td nowrap="" class="FieldLabel">
                                <span class="Required">*</span> <label for="description">%%LNG_ReviewRequestDescription%%:</label>
                            </td>
                            <td class="">                                
                                <input type="text" id="description" name="description" class="Field250" value="%%GLOBAL_ReviewRequestDescription%%" maxlength="250"/>
                            </td>
                        </tr>
                        <tr class="" style="">     
                            <td nowrap="" class="FieldLabel">
                                <span class="Required">*</span> <label for="description">%%LNG_ReviewRequestEmailSubject%%:</label>
                            </td>
                            <td class="">                                
                                <input type="text" id="emailsubject" name="emailsubject" class="Field250" value="%%GLOBAL_ReviewRequestEmailSubject%%" maxlength="250"/>
                            </td>
                        </tr>
						<tr class="" style="">     
                            <td nowrap="" class="FieldLabel">
                                <span class="Required">*</span> <label for="request_script">%%LNG_OrderReviewRequestScript%%:</label>
                            </td>
                            <td class="" nobr>
                            	<table border=0 with="100%"> 
                            	<tr><td>%%GLOBAL_WYSIWYG%%</td>
                            	<td valign="top">   
                                 <img onmouseout="HideHelp('d48');" onmouseover="ShowHelp('d48', '%%LNG_OrderReviewRequestScript%%', '%%GLOBAL_RequestScriptTips%%')" src="images/help.gif" width="24" height="16" border="0">
                           			 <div style="display:none" id="d48">test</div>
                            </td></tr>  
                            </table>     
                            </td>
                        </tr>
                        <tr class="" style="">     
                            <td nowrap="" class="FieldLabel">
                               
                            </td>
                            <td class="">                                
                                                          
                            </td>
                        </tr>
                        <tr class="" style="">
                            <td nowrap="" class="FieldLabel">
                                <label for="coupon_code">%%LNG_CouponCode%%:</label>
                            </td>
                            <td class="">
                                <!-- input type="text" id="coupon_code" name="coupon_code" class="Field250" value="" maxlength="100"/-->
                                <select id="coupon_code" name="coupon_code" classs="field250">
                                %%GLOBAL_ReviewRequestCuponCode%%
                                </select>
                                <div id="d11390" style="display: none;"/>
                            </td>
                        </tr>
                         <tr class="" style="display:none;">
                            <td nowrap="" class="FieldLabel">
                                <label for="setdefault">Set Default:</label>
                            </td>
                            <td class="" align="left">
                                <input type="checkbox" id="setdefault" name="setdefault[]" class="Field20" value="%%GLOBAL_ReviewRequestSetDefault%%" onclick="setcheckbox(this);"/>
                                <div id="d11390" style="display: none;"/>
                                <br/>
                                <input type="hidden" id="requestid" name="requestid" value="%%GLOBAL_ReviewRequest_ID%%" />                            </td>
                        </tr>
					</table>
				</div>
				<div id="div1" style="padding-top: 10px;"> 
				</div>               
				<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain" id="BottomButtons">
					<tr>
						<td width="200" class="FieldLabel">
							&nbsp;
						</td>
						<td>
							<input class="FormButton" type="submit" value="%%LNG_Save%%">
							<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
		</table>
		</div>

	<script type="text/javascript">

		

	$(document).ready(function() { 
		if($('#setdefault').val() == "1")
		{
			$('#setdefault').attr("checked","true");
				
		}
		else
		{
			$('#setdefault').val(0);
			$('#setdefault').attr("checked","false")
		}
	});

		function setcheckbox(chk)
		{
			if(chk.checked)
			{
				chk.value = "1";
			}
			else
			{
				chk.value = "0";
			}
		}

		function ShowTab(T)
		{
			i = 0;
			while (document.getElementById("tab" + i) != null) {
				document.getElementById("div" + i).style.display = "none";
				document.getElementById("tab" + i).className = "";
				i++;
			}

			if (parseInt(T) !== 0) {
				$('#BottomButtons').hide();
			} else {
				$('#BottomButtons').show();
			}

			document.getElementById("div" + T).style.display = "";
			document.getElementById("tab" + T).className = "active";
			document.getElementById("currentTab").value = T;
		}

		function checkform()
		{
			var desc =$('#description').val();	
			var mywysiwyg = tinyMCE.get('wysiwyg').getContent();//$('#wysiwyg').val();
			//mywysiwyg = $('#wysiwyg').val();
			//alert(mywysiwyg);
			//return false;		
			if( $.trim(desc)== "")
			{
				alert('%%LNG_RequestDescription%%');
				return false;
			}
			if( $.trim($('#emailsubject').val())== "")
			{
				alert('%%LNG_RequestEmailSubject%%');
				return false;
			}
			if( $.trim(mywysiwyg)== "")
			{
				alert('%%LNG_RequestTemplate%%');
				return false;
			}
			return true;
		}

		function ConfirmCancel() {
			//alert("In confirmCancel function");
			if(confirm('%%LNG_CancelRequestMessage%%')) {
				document.location.href='index.php?ToDo=viewRequestScriptSettings';
			}
			else {
				return false;
			}
		}

		// Load the main shipping settings tab by default
		ShowTab(%%GLOBAL_CurrentTab%%);

		// Do onload stuff here
		$(document).ready(function () { %%GLOBAL_AccountExtraJS%% });

	</script>