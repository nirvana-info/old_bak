<form action="index.php?ToDo=testShippingProviderQuote" method="post" onsubmit="return ValidateForm(CheckQuoteForm)">
	<input type="hidden" name="methodId" value="%%GLOBAL_MethodId%%" />
	<fieldset style="margin:10px">
		<legend>%%LNG_UPSShippingQuote%%</legend>
		<table width="100%" style="background-color:#fff" class="Panel">
			<tr>
				<td style="padding-left:15px">
					&nbsp;
				</td>
				<td>
					<img style="margin-top:5px" src="%%GLOBAL_Image%%" />
				</td>
			</tr>
			<tr>
				<td style="padding-left:15px">
					<span class="Required">*</span> %%LNG_DestinationCountry%%:
				</td>
				<td>
					<select name="destinationCountry" id="destinationCountry" class="Field250" onchange="ToggleCountry($(this).val());" />
						%%GLOBAL_Countries%%
					</select>
				</td>
			</tr>
			<tr id="trstate" style="%%GLOBAL_HideStatesList%%">
				<td style="padding-left:15px">
					<span class="Required">*</span> %%LNG_DestinationState%%:
				</td>
				<td>
					<select name="destinationState%%GLOBAL_StateNameAppend%%" id="destinationState" class="Field250">
						%%GLOBAL_StateList%%
					</select>
				</td>
			</tr>
			<tr>
				<td style="padding-left:15px">
					<span class="Required">*</span> %%LNG_DestinationZip%%:
				</td>
				<td>
					<input name="destinationZip" id="destinationZip" class="Field50" />
				</td>
			</tr>
			<tr>
				<td style="padding-left:15px">
					<span class="Required">*</span> %%LNG_PackageWeight%%:
				</td>
				<td>
					<input name="weight" id="weight" class="Field50"> %%GLOBAL_WeightMeasurement%%
				</td>
			</tr>
			<tr>
				<td style="padding-left:15px">
					&nbsp;
				</td>
				<td class="PanelBottom">
					<input type="submit" class="FormButton" style="width:120px" value="%%LNG_GetShippingQuote%%">
				</td>
			</tr>
		</table>
	</legend>
</form>

<script type="text/javascript">
	function CheckQuoteForm() {
		if($('#trstate').css('display') != 'none' && !$('#destinationState').val()) {
			alert('%%LNG_SelectDestinationState%%');
			$('#destinationState').focus();
			return false;
		}

		if(!$('#destinationZip').val()) {
			alert("%%LNG_EnterDestinationZip%%");
			$('#destinationZip').focus();
			return false;
		}

		if(isNaN($('#weight').val()) || $('#weight').val() == "") {
			alert("%%LNG_EnterPackageWeight%%");
			$('#weight').focus();
			$('#weight').select();
			return false;
		}

		return true;
	}

	function ToggleCountry(countryId) {
		$.ajax({
			url: 'remote.php',
			type: 'post',
			data: 'w=countryStates&c='+countryId,
			success: function(data)
			{
				$('#destinationState option').remove();
				var states = data.split('~');
				var numStates = 0;
				for(var i =0; i < states.length; ++i) {
					vals = states[i].split('|');
					if(!vals[0]) {
						continue;
					}
					$('#destinationState').append('<option value="'+vals[1]+'">'+vals[0]+'</option>');
					++numStates;
				}

				if(numStates == 0) {
					$('#trstate').hide();
					$('#destinationState').attr('name', 'destinationState2');
				}
				else {
					$('#trstate').show();
					$('#destinationState').attr('name', 'destinationState');
				}
			}
		});
	}
</script>