	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ViewCoupons%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_CouponIntro%%</p>
			%%GLOBAL_Message%%
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td class="Intro" valign="top">
						<input type="button" name="IndexAddButton" value="%%LNG_CreateCoupon%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=createCoupon'" /> &nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
					</td>
					<td class="SmallSearch" nowrap align="right">
						<form name="frmsearchCoupons" id="frmsearchCoupons" action="index.php?ToDo=viewCoupons%%GLOBAL_SortURL%%" method="get">
						<table>
							<tr>
								<input type="hidden" name="ToDo" value="viewCoupons">
								<td class="text" nowrap align="right">
									<input name="searchQuery" id="searchQuery" type="text" value="%%GLOBAL_Query%%" id="searchQuery" class="SearchBox" style="width:150px" />&nbsp;
									<input type="image" name="SearchButton" id="SearchButton" src="images/searchicon.gif" border="0"  style="padding-left: 10px; vertical-align: top;" />
								</td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
				<tr>
					<td> 
						&nbsp;&nbsp;%%GLOBAL_CouponGeType%%
					</td>		
				</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmCoupons" id="frmCoupons" method="post" action="index.php?ToDo=deleteCoupons">
				<div class="GridContainer">
					%%GLOBAL_CouponsDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>
	</div>

	<script type="text/javascript">

		function ConfirmDeleteSelected()
		{
			var fp = document.getElementsByTagName("input");
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteCoupons%%"))
					document.getElementById("frmCoupons").submit();
			}
			else
			{
				alert("%%LNG_ChooseCoupons%%");
			}
		}

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementsByTagName("input");

			for(i = 0; i < fp.length; i++)
				if(fp[i].type == "checkbox") fp[i].checked = Status;
		}

		function CouponClipboard(Data)
		{
			if (window.clipboardData)
			{
				window.clipboardData.setData("Text", Data);
				alert("%%LNG_CopiedClipboard%%");
			}
			else
			{
				alert("%%LNG_FeatureOnlyInIE%%");
			}
		}

	</script>