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

			<img style="margin-top:5px" src="../modules/shipping/ups/images/%%GLOBAL_Image%%" />

		</td>

	</tr>

	<tr>

		<td style="padding-left:15px">

			<span class="Required">*</span> %%LNG_UPSDeliveryType%%:

		</td>

		<td>

			<select name="delivery_type" id="delivery_type" class="Field250">

				%%GLOBAL_DeliveryTypes%%

			</select>

		</td>

	</tr>

	<tr>

		<td style="padding-left:15px">

			<span class="Required">*</span> %%LNG_UPSDestinationCountry%%:

		</td>

		<td>

			<select name="delivery_country" id="delivery_country" class="Field250">

				%%GLOBAL_Countries%%

			</select>

		</td>

	</tr>

	<tr>

		<td style="padding-left:15px">

			<span class="Required">*</span> %%LNG_UPSDestinationType%%:

		</td>

		<td>

			<select name="delivery_destination" id="delivery_destination" class="Field250">

				<option value="RES">%%LNG_UPSResidential%%</option>

				<option value="COM">%%LNG_UPSCommercial%%</option>

			</select>

		</td>

	</tr>

	<tr>

		<td style="padding-left:15px">

			<span class="Required">*</span> %%LNG_UPSDestinationZip%%:

		</td>

		<td>

			<input name="delivery_zip" id="delivery_zip" class="Field50">

		</td>

	</tr>

	<tr>

		<td style="padding-left:15px">

			<span class="Required">*</span> %%LNG_UPSPackageWeight%%:

		</td>

		<td>

			<input name="delivery_weight" id="delivery_weight" class="Field50">%%GLOBAL_WeightUnit%%

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



<script type="text/javascript">



	function CheckQuoteForm() {

		var delivery_zip = document.getElementById("delivery_zip");

		var delivery_weight = document.getElementById("delivery_weight");



		if(delivery_zip.value == "") {

			alert("%%LNG_UPSEnterDestinationZip%%");

			delivery_zip.focus();

			return false;

		}



		if(isNaN(delivery_weight.value) || delivery_weight.value == "") {

			alert("%%LNG_UPSEnterValidWeight%%");

			delivery_weight.focus();

			delivery_weight.select();

			return false;

		}



		return true;

	}



</script>



