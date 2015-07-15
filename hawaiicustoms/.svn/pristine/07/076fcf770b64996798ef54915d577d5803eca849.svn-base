
	<form action="index.php?ToDo=saveupdatedmappingsettings" name="frmmappingsettings" id="frmmappingsettings" method="post" onsubmit="return ValidateForm(CheckMappingForm)">
		<div class="BodyContainer">
		<table cellSpacing="0" cellPadding="0" width="100%" style="margin-left: 4px; margin-top: 8px;">
		<tr>
			<td class="Heading1">%%LNG_MappingSettings%%</td>
		</tr>
		<tr>
			<td class="Intro">
				<p>%%LNG_MappingSettingsIntro%%</p>
				%%GLOBAL_Message%%
				<p>
					<input type="submit" value="%%LNG_Save%%" class="FormButton" />
					<input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<ul id="tabnav">
					<li><a href="#" class="active" id="tab0" onclick="ShowTab(0)">%%LNG_MappingSettings%%</a></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>
				
			<div id="div0" style="padding-top: 10px;">
		        <table width="100%" class="Panel">
                      %%GLOBAL_mapping_data%%
                      <tr>
                          <td>
                                <div id="i_qualifiercontainer"/>
                          </td>
                          <td>
                                <div id="i_qualifiervalue"/>
                          </td>
                      </tr>             
                        <tr>
                            <td>                                                                 
                                &nbsp;
                            </td>
                            <td>
                                <a onclick="add_qualifier(); return false;" href="#" class="ExpandLink">
                                Add qualifier</a> 
                            </td>
                        </tr>
                        <tr>
                            <td>                                                                 
                                &nbsp;
                            </td>
                            <td>
                                &nbsp;
                            </td>
                        </tr> 
			            <tr>
				            <td width="200" class="FieldLabel">
					             <input class="FormButton" type="submit" value="%%LNG_Save%%">
                                 <input type="reset" value="%%LNG_Cancel%%" class="FormButton" onclick="ConfirmCancel()" />                                     
				            </td>
				            <td>
					             &nbsp;
                            </td>
			            </tr>
	            </table>
			</td>
		</tr>
		</table>
		</div>
	</form>

	<script type="text/javascript">

		function ConfirmCancel() {
			if(confirm("%%LNG_ConfirmCancelAffiliateSettings%%")) {
				document.location.href = "index.php?viewMappingSettings";
			}
		}

		
	</script>
