<form action="index.php?ToDo=%%GLOBAL_FormAction%%" id="frmWrap" method="post" onsubmit="return ValidateForm(CheckWrapForm)" enctype="multipart/form-data">
	<input type="hidden" name="wrapId" id="wrapId" value="%%GLOBAL_WrapId%%" />
	<input type="hidden" name="currentTab" value="%%GLOBAL_CurrentTab%%" id="currentTab" />
<div class="BodyContainer">
	<table class="OuterPanel">
		<tr>
			<td class="Heading1">%%GLOBAL_Title%%</td>
		</tr>

		<tr>
			<td class="Intro">
				<p>%%GLOBAL_Intro%%</p>
				%%GLOBAL_Message%%
				<p>
					<input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton" />&nbsp;
					<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				</p>
			</td>
		</tr>

		<tr>
			<td>
				<div id="div0">
					<table width="100%" class="Panel">
						<tr>
							<td class="Heading2" colspan="2">%%LNG_GiftWrapSettings%%</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> %%LNG_WrapName%%:
							</td>
							<td>
								<input type="text" name="wrapname" id="wrapname" class="Field250" value="%%GLOBAL_WrapName%%" />
								<img onmouseout="HideHelp('wrapnamehelp');" onmouseover="ShowHelp('wrapnamehelp', '%%LNG_WrapName%%', '%%LNG_WrapNameHelp%%')" src="images/help.gif" alt="" border="0" />
								<div style="display:none" id="wrapnamehelp"></div>
							</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">&nbsp;</span> %%LNG_WrapImage%%:
							</td>
							<td>
								<input type="file" name="wrapimage" id="wrapimage" />
								<img onmouseout="HideHelp('wrapimagehelp');" onmouseover="ShowHelp('wrapimagehelp', '%%LNG_WrapImage%%', '%%LNG_WrapImageHelp%%')" src="images/help.gif" alt="" border="0" />
								<div style="display:none" id="wrapimagehelp"></div>
								<span style="%%GLOBAL_HideCurrentWrapImage%%">
									Currently <a href="../%%GLOBAL_ImageDirectory%%/%%GLOBAL_WrapImage%%" target="_blank">%%GLOBAL_WrapImage%%</a>
								</span>
							</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span> %%LNG_WrapPrice%%:
							</td>
							<td>
								%%GLOBAL_LeftCurrencyToken%%
								<input type="text" name="wrapprice" id="wrapprice" class="Field50" value="%%GLOBAL_GiftWrapPrice%%" />
								%%GLOBAL_RightCurrencyToken%%
								<img onmouseout="HideHelp('wrappricehelp');" onmouseover="ShowHelp('wrappricehelp', '%%LNG_WrapPrice%%', '%%LNG_WrapPriceHelp%%')" src="images/help.gif" alt="" border="0" />
								<div style="display:none" id="wrappricehelp"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp; <label for="wrapgiftmessage">%%LNG_WrapGiftMessage%%?</label>
							</td>
							<td>
								<label><input type="checkbox" name="wrapallowcomments" value="1" id="wrapgiftmessage" %%GLOBAL_GiftWrapAllowCommentsChecked%% /> %%LNG_YesAllowWrapGiftMessage%%</label>
								<img onmouseout="HideHelp('wrapallowcommentshelp');" onmouseover="ShowHelp('wrapallowcommentshelp', '%%LNG_WrapGiftMessage%%', '%%LNG_WrapGiftMessageHelp%%')" src="images/help.gif" alt="" border="0" />
								<div style="display:none" id="wrapallowcommentshelp"></div>
							</td>
						</tr>

						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp; <label for="wrapvisible">%%LNG_Visible%%?</label>
							</td>
							<td>
								<label><input type="checkbox" name="wrapvisible" value="1" id="wrapvisible" %%GLOBAL_GiftWrapVisibleChecked%% /> %%LNG_YesWrapVisible%%</label>
								<img onmouseout="HideHelp('wrapvisiblehelp');" onmouseover="ShowHelp('wrapvisiblehelp', '%%LNG_Visible%%', '%%LNG_WrapVisibleHelp%%')" src="images/help.gif" alt="" border="0" />
								<div style="display:none" id="wrapvisiblehelp"></div>
							</td>
						</tr>
					</table>
					<table border="0" cellspacing="0" cellpadding="2" width="100%" class="PanelPlain">
					<tr>
						<td width="200" class="FieldLabel">
							&nbsp;
						</td>
						<td>
							<input type="submit" name="SubmitButton1" value="%%LNG_Save%%" class="FormButton" />&nbsp;
							<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
	</table>
</div>
</form>
<script type="text/javascript">
	function CheckWrapForm() {
		if(!$('#wrapname').val()) {
			alert('%%LNG_EnterWrapName%%');
			$('#wrapname').focus();
			return false;
		}

		var price = $('#wrapprice');
		if(isNaN(priceFormat(price.val())) || price.val() == '') {
			alert('%%LNG_EnterWrapPrice%%');
			price.focus();
			price.select();
			return false;
		}

		return true;
	}
</script>