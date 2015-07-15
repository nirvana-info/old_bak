
	<form enctype="multipart/form-data" action="index.php" id="frmSearch" method="GET" onsubmit="return ValidateForm(CheckSearchForm)">
	<input type="hidden" name="ToDo" value="searchReviewsRedirect" />
	<input type="hidden" name="currentTab" value="1" />
	<input type="hidden" name="isAdvanced" value="1" />
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%LNG_SearchProductReviews%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_SearchProductsIntro%%</p>
			%%GLOBAL_Message%%
			<p><input type="submit" id="SubmitButton1" value="%%LNG_Search%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
		</td>
	  </tr>
	  <tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_AdvancedSearch%%</td>
				</tr>
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_SearchKeywords%%:
					</td>
					<td>
						<input type="text" id="searchQuery" name="searchQuery" class="Field250">
						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_SearchKeywords%%', '%%LNG_SearchKeywordsProductHelp%%')" src="images/help.gif" width="24" height="16" border="0">
						<div style="display:none" id="d1"></div>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_BrandName%%:
					</td>
					<td>
						<select name="brand" id="brand" class="Field250">
							<option value="" selected="selected">%%LNG_AllBrandNames%%</option>
							%%GLOBAL_BrandNameOptions%%
						</select>
					</td>
				</tr>

				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_Categories%%:
					</td>
					<td>
						<select size="5" id="category" name="category" class="Field250 ISSelectReplacement" style="height:115" multiple>
							<option value="0" selected="selected">%%LNG_AllCategories%%</option>
							%%GLOBAL_CategoryOptions%%
						</select>
						<br />
						<div style="clear: left;"><label><input type="checkbox" name="subCats" value="1" checked="checked" /> %%LNG_AutoSearchSubCategories%%</label></div>
					</td>
				</tr>
				
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_DateRange%%:
					</td>
					<td>
						<div id="dateBlock" style="" class="Text FloatLeft">
							<table border=0 cellspacing=0 cellpadding=0>
								<tr>
									<td style="" width="1" class="dateField">       
										<select name="Calendar[DateType]" id="Calendar" class="CalendarSelect" onchange="doCustomDate(this, 7)">
											%%GLOBAL_CalendarDateTypeOptions%%
										</select> 
									</td>
									<td style="" class="dateField">
										<span id="customDate7" style="display:none">&nbsp;
											%%GLOBAL_FromDatePicker%%
											<span class="body">%%LNG_To1%%</span>
											%%GLOBAL_ToDatePicker%%
										</span>
									</td>
								</tr>
							 </table>
						  </div>
					</td>
				</tr>
				
				<tr>
					<td class="FieldLabel">
						&nbsp;&nbsp;&nbsp;%%LNG_Status%%:
					</td>
					<td>
						<div style="clear: left;">
							<input type="radio" name="reviewStatus" value="0" />%%LNG_StatusPending%%
							<input type="radio" name="reviewStatus" value="1" />%%LNG_StatusApproved%%
						</div>
					</td>
				</tr>
				
				<tr><td class="Gap" colspan="2"></td></tr>
			 </table>
			</td>
		</tr>
		<tr>
			<td>
				<p><input type="submit" id="SubmitButton2" value="%%LNG_Search%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>
			</td>
		</tr>
	</table>
	</div>
	</form>

	<script type="text/javascript">
		function ConfirmCancel() {
			if(confirm("%%LNG_ConfirmCancelSearch%%")){
				document.location.href = "index.php?ToDo=viewReviews&currentTab=1";
			}
		}

		function CheckSearchForm() {
            //do some check if need
            
			return true;
		}
		
		//wiyin_20100624: add datepicker
		$(function(){
			$('input.datepicker').datepicker({
				changeMonth: true,
				changeYear: true,
				closeAtTop: false,
				mandatory: true
			});
			doCustomDate(document.getElementById('Calendar'), 7);
			
		});

	</script>
