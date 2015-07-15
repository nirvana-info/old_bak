
	<form action="index.php?ToDo=runAddon&addon=addon_YSM&func=ExportCSV" onSubmit="return ValidateForm(CheckForm);" name="frmYSM" method="post">
	<div class="BodyContainer">
	<table class="OuterPanel">
		  <tr>
			<td class="Heading1">%%LNG_YSMGenerator%%</td>
			</tr>
			<tr>
			<td class="Intro">
				<p>%%LNG_YSMFormIntro%%</p>
				%%GLOBAL_Message%%
			</td>
		  </tr>

		  <tr>
			    <td>
					<div>
						<input type="submit" name="SubmitButton1" value="%%LNG_Export%%" class="FormButton">
						<input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"><br /><img src="images/blank.gif" width="1" height="10" /></div>
				</td>
			  </tr>
				<tr>
					<td>
					  <table class="Panel">
						<tr>
						  <td class="Heading2" colspan=2>%%LNG_YSMAdFormatOptions%%</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_YSMCreateAdsFor%%:
							</td>
							<td>
								<table border="0">
									<tr>
										<td valign="top">
											<select size="5" id="category" name="category[]" class="Field300 ISSelectReplacement" multiple="multiple" style="height: 140px;">
												<option value="0" SELECTED>%%LNG_YSMAllProducts%%</option>
												%%GLOBAL_CategoryOptions%%
											</select>
										</td>
										<td valign="top">
											<div style="position:relative; top:200px; left:10px">
												%%LNG_YSMExampleAd%%:<br />
												<div style="border:1px solid rgb(180, 208, 220); width:252px; font-size:14px; font-family:arial; padding:4px 3px 3px 5px; line-height:1.2; margin-top:5px">
													<a href="#" style="font-size:14px; font-family:arial; color:#0000CC"><span id="ad_title">iPod Touch 8GB</span></a>
													<div style="font-size:12px; color:black">
														<span id="ad_desc">Buy the iPod Touch 8GB online from SampleStore. Only %%GLOBAL_SamplePrice%%.</span><br />
														<span id="ad_link" style="color:#008000">%%GLOBAL_HTTPHost%%</span>
													</div>
												</div>
											</div>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<p class="InfoTip" style="margin-left:0px; width:260px"><a href="#" onclick="LaunchHelp(708)">%%LNG_YSMPlaceholdersHelp%%</a></p>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_YSMHeadline%%:
							</td>
							<td>
								<input type="text" id="title" name="title" class="Field300" value="{PRODNAME}" maxlength="40">
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_YSMDesc1%%:
							</td>
							<td>
								<input type="text" id="desc1" name="desc1" class="Field300" value="Buy the {PRODNAME} online from {STORENAME}. Only {PRODPRICE}." maxlength="70">
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_YSMDesc2%%:
							</td>
							<td>
								<input type="text" id="desc2" name="desc2" class="Field300" value="{PRODSUMMARY} Buy {PRODNAME} online from {STORENAME}. Only {PRODPRICE}." maxlength="190">
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_YSMDisplayURL%%:
							</td>
							<td>
								http:// <input type="text" id="displayurl" name="displayurl" class="Field300" style="width:265px" value="%%GLOBAL_HTTPHost%%" maxlength="35">
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_YSMDestinationURL%%:
							</td>
							<td>
								http:// <input type="text" id="destinationurl" name="destinationurl" class="Field300" style="width:265px" value="{PRODLINK}" maxlength="1024">
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								<span class="Required">*</span>&nbsp;%%LNG_YSMMaxCPC%%:
							</td>
							<td>
								$ <input type="text" id="maxcpc" name="maxcpc" class="Field100" style="width:50px" value="0.1" maxlength="4">USD
								<img onMouseOut="HideHelp('dmaxcpc');" onMouseOver="ShowHelp('dmaxcpc', '%%LNG_YSMMaxCPC%%', '%%LNG_YSMMaxCPCHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="dmaxcpc"></div>
							</td>
						</tr>
						<tr>
							<td class="FieldLabel">
								&nbsp;&nbsp;&nbsp;%%LNG_YSMContentMatch%%
							</td>
							<td>
								<input type="checkbox" id="contentmatch" name="contentmatch" value="ON"> <label for="contentmatch">%%LNG_YSMYesContentMatch%%</label>
								<img onMouseOut="HideHelp('dcontentmatch');" onMouseOver="ShowHelp('dcontentmatch', '%%LNG_YSMContentMatch%%', '%%LNG_YSMContentMatchHelp%%')" src="images/help.gif" width="24" height="16" border="0">
								<div style="display:none" id="dcontentmatch"></div>
								<div style="padding-left:25px"><a style="color:gray" href="http://searchmarketing.yahoo.com/srch/contentmatch.php" target="_blank">%%LNG_YSMLearnContentMatch%%</a></div>
							</td>
						</tr>
					</table>
				<table class="Panel">
					<tr>
						<td class="FieldLabel">&nbsp;</td>
						<td>
							<br /><input type="submit" name="SubmitButton2" value="%%LNG_Export%%" class="FormButton">
							<input type="button" name="CancelButton2" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">
						</td>
					</tr>
					<tr><td class="Gap"></td></tr>
			 </table>
			</td>
		</tr>
	</table>
	</div>
	</form>

	<script type="text/javascript">

		// Details for the example ad
		var PRODNAME = 'iPod Touch 8GB';
		var PRODBRAND = 'Apple';
		var PRODSUMMARY = 'The sleek new iPod from Apple.';
		var PRODPRICE = '%%GLOBAL_SamplePrice%%';
		var PRODSKU = 'SKU12345';
		var PRODCAT = 'MP3 Players';
		var STORENAME = 'SampleStore';

		function CheckForm() {
			if(g('category_old').selectedIndex == -1) {
				alert('%%LNG_YSMChooseCategory%%');
				return false;
			}

			if(g('title').value == '') {
				alert('%%LNG_YSMEnterTitle%%');
				g('title').focus();
				return false;
			}

			if(g('desc1').value == '') {
				alert('%%LNG_YSMEnterDesc%%');
				g('desc1').focus();
				return false;
			}

			if(g('desc2').value == '') {
				alert('%%LNG_YSMEnterDesc%%');
				g('desc2').focus();
				return false;
			}

			if(g('displayurl').value == '') {
				alert('%%LNG_YSMEnterDisplayURL%%');
				g('displayurl').focus();
				return false;
			}

			if(g('destinationurl').value == '') {
				alert('%%LNG_YSMEnterDestinationURL%%');
				g('destinationurl').focus();
				return false;
			}

			if(isNaN(g('maxcpc').value) || g('maxcpc').value == '') {
				alert('%%LNG_YSMEnterMaxCPC%%');
				g('maxcpc').focus();
				g('maxcpc').select();
				return false;
			}

			return true;
		}

		function ConfirmCancel()
		{
			if(confirm('%%LNG_YSMCancelMessage%%'))
				document.location.href='index.php?ToDo=';
			else
				return false;
		}

		function YSMReplaceTokens(Val) {
			changed = Val.replace('{PRODNAME}', PRODNAME);
			changed = changed.replace('{PRODBRAND}', PRODBRAND);
			changed = changed.replace('{PRODSUMMARY}', PRODSUMMARY);
			changed = changed.replace('{PRODPRICE}', PRODPRICE);
			changed = changed.replace('{PRODSKU}', PRODSKU);
			changed = changed.replace('{PRODCAT}', PRODCAT);
			changed = changed.replace('{STORENAME}', STORENAME);
			return changed;
		}

		$('input:text').keyup(function(event) {
			// Update the example ad when a key is released in any of the fields
			$('#ad_title').html(YSMReplaceTokens($('#title').val()));
			$('#ad_desc').html(YSMReplaceTokens($('#desc1').val()));
			$('#ad_link').html(YSMReplaceTokens($('#displayurl').val()));
		});

	</script>
