
	<script language=JavaScript>

		var checkLink = 0;

		function ConfirmCancel()
		{
			if(confirm('%%LNG_CancelEditReview%%'))
			{
				document.location.href='index.php?ToDo=viewReviews&currentTab=1';
			}
			else
			{
				return false;
			}
		}

		function CheckEditReviewForm()
		{
			// Make sure that all of the form variables, etc are valid
			var f = document.frmReview;

			if(f.revtitle.value.length == 0)
			{
				alert('%%LNG_ReviewEnterTitle%%');
				f.revtitle.focus();
				f.revtitle.select();
				return false;
			}

//			if(f.revtext.value.length == 0)
//			{
//				alert('%%LNG_ReviewEnter%%');
//				f.revtext.focus();
//				f.revtext.select();
//				return false;
//			}

			// Everything is OK, return true
			return true;
		}
		
		//lguan_20100617: Change the ratings selection to be star rating syle
		$(document).ready(function() {
			$('span.StarRatingSpan').stars({
				inputType: "select",
				cancelShow: true,
				cancelAfterStars: true,
				cancelSelectable: true,
				cancelInitialSelected: true,
				split:2,
				cancelClass:		'ui-crystal-cancel',
				starClass:			'ui-crystal-star',
				starOnClass:		'ui-crystal-star-on',
				starHoverClass:		'ui-crystal-star-hover',
				cancelHoverClass:	'ui-crystal-cancel-hover',
				cancelOnClass:		'ui-crystal-cancel-on'
			});
		});
	</script>

	<form action="index.php?ToDo=editReview2&currentTab=1" onsubmit="return ValidateForm(CheckEditReviewForm)" name="frmReview" method="post">
	<input type="hidden" name="reviewId" value="%%GLOBAL_ReviewId%%">
	<div class="BodyContainer">
	<table class="OuterPanel">
	  <tr>
		<td class="Heading1" id="tdHeading">%%LNG_EditReview%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%LNG_EditReviewIntro%%</p>
			<div><input type="submit" name="SaveButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></div>
		</td>
	  </tr>
		<tr>
			<td>
			  <table class="Panel">
				<tr>
				  <td class="Heading2" colspan=2>%%LNG_ReviewDetails%%</td>
				</tr>
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_ReviewTitle%%:
						</td>
						<td>
							<input type="text" name="revtitle" class="Field300" value="%%GLOBAL_Title%%">
							<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_ReviewTitle%%', '%%LNG_ReviewTitleHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d2"></div>
						</td>
					</tr>
					<!-- 
					<tr>
						<td class="FieldLabel">
							<span class="Required">*</span>&nbsp;%%LNG_Review%%:
						</td>
						<td>
							<textarea name="revtext" rows="5" class="Field300">%%GLOBAL_Review%%</textarea>
							<img onmouseout="HideHelp('d3');" onmouseover="ShowHelp('d3', '%%LNG_Review%%', '%%LNG_ReviewHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d3"></div>
						</td>
					</tr>
					 -->
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_ReviewAuthor%%:
						</td>
						<td>
							<input type="text" name="revfromname" class="Field300" value="%%GLOBAL_FromName%%">
							<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_ReviewAuthor%%', '%%LNG_ReviewAuthorHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d1"></div>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_ReviewStatus%%:
						</td>
						<td>
							<select name="revstatus" class="Field150">
								%%GLOBAL_StatusOptions%%
							</select>
							<img onmouseout="HideHelp('d4');" onmouseover="ShowHelp('d4', '%%LNG_ReviewStatus%%', '%%LNG_ReviewStatusHelp%%')" src="images/help.gif" width="24" height="16" border="0">
							<div style="display:none" id="d4"></div>
						</td>
					</tr>
					
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_ReviewRating%%:
						</td>
						<td>
							<span class="StarRatingSpan">
								<select name="revrating" class="Field150">
									%%GLOBAL_RatingOptions%%
								</select>
							</span>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_RateProductQuality%%:
						</td>
						<td>
							<span class="StarRatingSpan">
								<select name="qualityrating" class="Field150" id="qualityrating">
									%%GLOBAL_RatingQualityOptions%%
								</select>
							</span>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_RateEaseInstallation%%:
						</td>
						<td>
							<span class="StarRatingSpan">
								<select name="installrating" class="Field150">
									%%GLOBAL_RatingInstallOptions%%
								</select>
							</span>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_RateProductValue%%:
						</td>
						<td>
							<span class="StarRatingSpan">
								<select name="valuerating" class="Field150">
									%%GLOBAL_RatingValueOptions%%
								</select>
							</span>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_RateCustomerSupport%%:
						</td>
						<td>
							<span class="StarRatingSpan">
								<select name="supportrating" class="Field150">
									%%GLOBAL_RatingSupportOptions%%
								</select>
							</span>
						</td>
					</tr>
					<tr>
						<td class="FieldLabel">
							&nbsp;&nbsp;&nbsp;%%LNG_RateDeliveryTime%%:
						</td>
						<td>
							<span class="StarRatingSpan">
								<select name="deliveryrating" class="Field150">
									%%GLOBAL_RatingDeliveryOptions%%
								</select>
							</span>
						</td>
					</tr>
					
					<tr>
						<td class="Gap">&nbsp;</td>
						<td class="Gap"><div><input type="submit" name="SaveButton1" value="%%LNG_Save%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></div>
						</td>
					</tr>
					<tr><td class="Gap"></td></tr>
			 </table>
			</td>
		</tr>
	</table>
	</div>
	</form>
