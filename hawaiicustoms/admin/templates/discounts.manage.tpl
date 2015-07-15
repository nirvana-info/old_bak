	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">%%LNG_ViewDiscounts%%</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_DiscountIntro%%</p>
			<div id="DiscountStatus">
				%%GLOBAL_Message%%
			</div>
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			<td class="Intro" valign="top">
				<input type="button" name="IndexAddButton" value="%%LNG_CreateDiscount%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=createDiscount'" /> &nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
			</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmDiscounts" id="frmDiscounts" method="post" action="index.php?ToDo=deleteDiscounts">
				<div class="GridContainer">
					%%GLOBAL_DiscountsDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>
	</div>

	<script type="text/javascript" src="../javascript/jquery/plugins/interface.js"></script>
	<script type="text/javascript" src="../javascript/jquery/plugins/inestedsortable.js"></script>
	<script type="text/javascript">

		function ConfirmDeleteSelected()
		{
			var fp = document.getElementById("frmDiscounts").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteDiscounts%%"))
					document.getElementById("frmDiscounts").submit();
			}
			else
			{
				alert("%%LNG_ChooseDiscounts%%");
			}
		}

		function ToggleDeleteBoxes(Status)
		{
			var fp = document.getElementById("frmDiscounts").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}

		function DiscountClipboard(Data)
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

		var updatingSortables = false;
		var updateTimeout = null;
		
		function CreateSortableList() {
		
			$('#DiscountList').sortable(
			{
				'accept': 'SortableRow',
				'containment': '#DiscountList',
				'handle': '.sort-handle',
				'opacity': .8,
				'autoScroll': true,
				'helperclass': 'SortableRowHelper',
				'stop': function() {
					$(this).find('.GridRow').removeClass('RowDown');
					
					var idx = [];

					$('input.DiscountsIdx').each(
						function()
						{
							idx[idx.length] = $(this).val();
						}
					);

					$.ajax({
						url: 'remote.php',
						type: 'post',
						dataType: 'xml',
						data: {
								'w': 'updateDiscountOrder',
								'sortorder': idx.join(',')
							},
						success: function(response) { 
						
							var status = $('status', response).text();
							var message = $('message', response).text();
							if(status == 0) {
								display_error('DiscountStatus', message);
							}
							else {
								display_success('DiscountStatus', message);
							}
						}
					});
					
				}
			});
		}
		$(document).ready(function()
		{
			CreateSortableList();
		});

	</script>