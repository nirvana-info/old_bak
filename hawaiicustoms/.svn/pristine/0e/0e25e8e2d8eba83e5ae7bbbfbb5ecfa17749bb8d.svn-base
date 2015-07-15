


	<form action="index.php?ToDo=exportCustomers2" onsubmit="return ValidateForm(CheckExportForm)" id="frmExport" method="post">


	<input type="hidden" id="startdate" name="startdate" value="">


	<input type="hidden" id="enddate" name="enddate" value="">


	<div class="BodyContainer">


	<table class="OuterPanel">


	  <tr>


		<td class="Heading1" id="tdHeading">%%LNG_ExportCustomers%%</td>


		</tr>


		<tr>


		<td class="Intro">


			<p>%%LNG_ExportIntro%%</p>
			%%GLOBAL_Message%%

			<p><input type="submit" name="SubmitButton1" value="%%LNG_Export%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()"></p>


		</td>


		  </tr>


		<tr>


			<td>


			  <table class="Panel">


				<tr>


				  <td class="Heading2" colspan=2>%%LNG_ExportDetails%%</td>


				</tr>


				<tr>


					<td class="FieldLabel">


						<span class="Required">*</span>&nbsp;%%LNG_ExportFields%%:


					</td>


					<td>


						<select id="exportfields" name="exportfields[]" class="Field250" multiple="multiple" size="10" style="width:255px">


							%%GLOBAL_ExportFields%%


						</select>


						<img onmouseout="HideHelp('d1');" onmouseover="ShowHelp('d1', '%%LNG_ExportFields%%', '%%LNG_ExportCustomerFieldsHelp%%')" src="images/help.gif" width="24" height="16" border="0">


						<div style="display:none" id="d1"></div><br />


					</td>


				</tr>


				<tr>


					<td class="FieldLabel">


						<span class="Required">*</span>&nbsp;%%LNG_FileFormat%%:


					</td>


					<td>


						<select id="filetype" name="filetype" class="Field250" style="width:255px">


							<option value="-1">%%LNG_ChooseFileFormat%%</option>


							<option value="0">%%LNG_ExportAsCSVComma%%</option>


							<option value="1">%%LNG_ExportAsCSVTab%%</option>


						</select>


					</td>


				</tr>


				<tr>


					<td class="FieldLabel">


						&nbsp;&nbsp;&nbsp;%%LNG_DateRange%%:


					</td>


					<td>


						%%LNG_From%%: <input class="plain" id="dc1" value="%%GLOBAL_StartDate%%" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fStartPop(document.getElementById('dc1'),document.getElementById('dc2'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>





						%%LNG_To%%: <input class="plain" id="dc2" value="%%GLOBAL_EndDate%%" size="12" onfocus="this.blur()" readonly><a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fEndPop(document.getElementById('dc1'),document.getElementById('dc2'));return false;" HIDEFOCUS><img name="popcal" align="absmiddle" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a>





						&nbsp;<img onmouseout="HideHelp('d2');" onmouseover="ShowHelp('d2', '%%LNG_DateRange%%', '%%LNG_DateRangeCustomerHelp%%')" src="images/help.gif" width="24" height="16" border="0">


						<div style="display:none" id="d2"></div><br />


					</td>


				</tr>


				<tr>


					<td class="Gap">&nbsp;</td>


					<td class="Gap"><input type="submit" name="SubmitButton1" value="%%LNG_Export%%" class="FormButton">&nbsp; <input type="button" name="CancelButton1" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()">


					</td>


				</tr>


				<tr><td class="Gap"></td></tr>


				<tr><td class="Sep" colspan="2"></td></tr>





			 </table>


			</td>


		</tr>


	</table>


	</div>


	</form>





	<iframe width=132 height=142 name="gToday:contrast:agenda.js" id="gToday:contrast:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;"></iframe>





	<script type="text/javascript">





		function ConfirmCancel()


		{


			if(confirm("%%LNG_ConfirmCancelExport%%"))


				document.location.href = "index.php?ToDo=viewCustomers";


		}





		function CheckExportForm()


		{


			var ef = document.getElementById("exportfields");


			var ft = document.getElementById("filetype");


			var fd = document.getElementById("dc1");


			var td = document.getElementById("dc2");


			var sd = document.getElementById("startdate");


			var ed = document.getElementById("enddate");





			if(ef.selectedIndex == -1)


			{


				alert("%%LNG_ExportChooseFields%%");


				ef.focus();


				return false;


			}





			if(ft.selectedIndex == 0)


			{


				alert("%%LNG_ExportChooseFileType%%");


				ft.focus();


				return false;


			}





			// If either the from or end dates are selected,


			// make sure both are selected


			if(fd.value != "" && td.value == "")


			{


				alert("%%LNG_ExportChooseFromTo%%");


				td.focus();


				return false;


			}





			if(fd.value == "" && td.value != "")


			{


				alert("%%LNG_ExportChooseFromTo%%");


				fd.focus();


				return false;


			}





			sd.value = fd.value;


			ed.value = td.value;





			return true;


		}





	</script>





