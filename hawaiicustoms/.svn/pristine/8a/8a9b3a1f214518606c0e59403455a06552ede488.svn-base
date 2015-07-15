
	<div class="BodyContainer">
	<table id="Table13" cellSpacing="0" cellPadding="0" width="100%">
		<tr>
			<td class="Heading1">
				%%LNG_View%%: <a href="#" style="color:#005FA3" id="ViewsMenuButton" class="PopDownMenu">%%GLOBAL_ViewName%% <img width="8" height="5" src="images/arrow_blue.gif" border="0" /></a>
			</td>
		</tr>
		<tr>
		<td class="Intro">
			<p>%%GLOBAL_ProductIntro%%</p>
			<div id="ProductsStatus">%%GLOBAL_Message%%</div>
			<table id="IntroTable" cellspacing="0" cellpadding="0" width="100%">
			<tr>
			<td class="Intro" valign="top" style="padding-top:10px">
				<input type="button" name="IndexAddButton" value="%%LNG_AddProduct%%..." id="IndexCreateButton" class="SmallButton" onclick="document.location.href='index.php?ToDo=addProduct'" /> &nbsp;<input type="button" name="IndexDeleteButton" value="%%LNG_DeleteSelected%%" id="IndexDeleteButton" class="SmallButton" onclick="ConfirmDeleteSelected()" %%GLOBAL_DisableDelete%% />
				<input type="button" name="IndexBulkButton" value="%%LNG_BulkEditProducts%%" id="IndexBulkButton" class="SmallButton" onclick="BulkEditSelected()" %%GLOBAL_DisableBulkEdit%% style="display:%%GLOBAL_HideBulkExportButton%%" />
				<input type="button" name="IndexExportButton" value="%%LNG_ExportProducts%%" id="IndexExportButton" class="SmallButton" style="width:150px; display: %%GLOBAL_HideExport%%" onclick="ExportProducts()" %%GLOBAL_DisableExport%% /></a>
<input type="button" name="IndexExportButton1" value="%%LNG_ExportResults%%" id="IndexExportButton1" class="SmallButton" style="width:200px; display: %%GLOBAL_HideExportResults%%" onclick="ExportProductsResults()" %%GLOBAL_DisableExport%% /></a>
<input type="button" name="IndexDeleteButton1" value="%%LNG_DeleteResults%%" id="IndexExportButton1" class="SmallButton" style="display: %%GLOBAL_HideDeleteResults%%" onclick="DeleteProductsResults()" %%GLOBAL_DisableDelete%% /></a>

<input type="button" name="TestData" value="%%GLOBAL_ExportProductslan%%" id="TestData" class="SmallButton" style="width:200px; display: %%GLOBAL_HideTestData%%" onclick="ShowTestData()"  /></a>



			</td>

			<td class="SmallSearch" align="right">
				<table id="Table16" style="display:%%GLOBAL_DisplaySearch%%">
				<tr>

					<td nowrap>
						<form action="index.php?ToDo=viewProducts%%GLOBAL_SortURL%%" method="get" onsubmit="return ValidateForm(CheckSearchForm)" style="margin: 0; padding: 0">
							<input type="hidden" name="ToDo" value="viewProducts">
							<input name="searchQuery" id="searchQuery" type="text" value="%%GLOBAL_Query%%" class="Button" size="20" />&nbsp;
							<input type="image" name="SearchButton" style="padding-left: 10px; vertical-align: top;" id="SearchButton" src="images/searchicon.gif" border="0" />
						</form>
					</td>

				</tr>
				<tr>
					<td nowrap="nowrap">
						<a href="index.php?ToDo=searchProducts">%%LNG_AdvancedSearch%%</a>
						<span style="display:%%GLOBAL_HideClearResults%%">| <a id="SearchClearButton" href="index.php?ToDo=viewProducts">%%LNG_ClearResults%%</a></span>
					</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				</table>
			</td>
			</tr>
			</table>
		</td>
		</tr>
		<tr>
		<td style="display: %%GLOBAL_DisplayGrid%%">
			<form name="frmProducts" id="frmProducts" method="post" action="index.php?ToDo=deleteProducts">
				<div class="GridContainer">
					%%GLOBAL_ProductDataGrid%%
				</div>
			</form>
		</td></tr>
	</table>
	</div>

	<div id="ViewsMenu" class="DropShadow DropDownMenu" style="display: none; width:200px">
			<ul>
				%%GLOBAL_CustomSearchOptions%%
			</ul>
			<hr />
			<ul>
				<li><a href="index.php?ToDo=createProductView" style="background-image:url('images/view_add.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_CreateANewView%%</a></li>
				<li style="display:%%GLOBAL_HideDeleteViewLink%%"><a onclick="$('#ViewsMenu').hide(); confirm_delete_custom_search('%%GLOBAL_CustomSearchId%%')" href="javascript:void(0)" style="background-image:url('images/view_del.gif'); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px">%%LNG_DeleteThisView%%</a></li>
			</ul>
		</div>
	</div>

	<div id="invDiv" class="StockList" style="display:none"></div>

	<script type="text/javascript">

		var tok = "%%GLOBAL_AuthToken%%";
		var inventory_product_id = 0;
		var action = "";
		var total_stock_units = 0;

		function ExportProducts()
		{
			document.getElementById("frmProducts").action = "%%GLOBAL_ExportAction%%";
			document.getElementById("frmProducts").submit();
		}
        
        function DeleteProductsResults()
        {
            if(confirm("%%GLOBAL_ConfirmDeleteSearchResults%%"))
            {
                self.location = "index.php?ToDo=deleteProductSearchResults&DelIdentity=%%GLOBAL_DelIdentity%%&DelProductsCount=%%GLOBAL_DelProductsCount%%";
            }
        }
        
		function CheckSearchForm() {
			var query = document.getElementById("searchQuery");

			if(query.value == "") {
				alert("%%LNG_ChooseFilterOrEnterSearchTerm%%");
				return false;
			}

			return true;
		}


		function ExportProductsResults()
		{
			document.getElementById("frmProducts").action = "%%GLOBAL_ExportResults%%";
			document.getElementById("frmProducts").submit();
		}
		function ShowTestData()
		{
			document.getElementById("frmProducts").action = "%%GLOBAL_ShowtTestData%%";
			document.getElementById("frmProducts").submit();
		}


		function ConfirmDeleteSelected() {
			var fp = document.getElementById("frmProducts").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 0)
			{
				if(confirm("%%LNG_ConfirmDeleteProducts%%"))
					document.getElementById("frmProducts").submit();
			}
			else
			{
				alert("%%LNG_ChooseProduct%%");
			}
		}

		function ToggleDeleteBoxes(Status) {
			var fp = document.getElementById("frmProducts").elements;

			for(i = 0; i < fp.length; i++)
				fp[i].checked = Status;
		}

		function ShowStock(id, InventoryType, VariationId) {
			var tr = document.getElementById("tr"+id);
			var trQ = document.getElementById("trQ"+id);
			var tdQ = document.getElementById("tdQ"+id);
			var img = document.getElementById("expand"+id);

			if(img.src.indexOf("plus.gif") > -1)
			{
				img.src = "images/minus.gif";

				for(i = 0; i < tr.childNodes.length; i++)
				{
					if(tr.childNodes[i].style != null)
						tr.childNodes[i].style.backgroundColor = "#dbf3d1";
				}
				$(trQ).find('.QuickView').load('remote.php?w=inventoryLevels&p='+id+'&i='+InventoryType+'&v='+VariationId+'&t='+tok, {}, function() {
					trQ.style.display = "";
				});
			}
			else
			{
				img.src = "images/plus.gif";

				for(i = 0; i < tr.childNodes.length; i++)
				{
					if(tr.childNodes[i].style != null)
						tr.childNodes[i].style.backgroundColor = "";
				}
				trQ.style.display = "none";
			}
		}

		function UpdateStockLevel(ProductId, InventoryType) {

			var loading = document.getElementById("loading"+ProductId);
			inventory_product_id = ProductId;

			// Update the stock levels via AJAX
			if(InventoryType == 0)  {
				// Per-product stock levels
				var stock_level = document.getElementById("stock_level_"+ProductId);
				var stock_level_notify = document.getElementById("stock_level_notify_"+ProductId);

				if(isNaN(stock_level.value) || stock_level.value == "") {
					alert("%%LNG_EnterValidStockLevel%%");
					stock_level.focus();
					stock_level.select();
				}
				else if(isNaN(stock_level_notify.value) || stock_level_notify.value == "") {
					alert("%%LNG_EnterValidStockLevel%%");
					stock_level_notify.focus();
					stock_level_notify.select();
				}
				else {
					// Update the loading image
					loading.src = "images/ajax-loader.gif";

					// Valid stock level numbers, save them using AJAX
					total_stock_units = stock_level.value;
					action = "update_inventory_levels";
					DoCallback("w=updatePerProductInventoryLevels&p="+ProductId+"&c="+stock_level.value+"&l="+stock_level_notify.value+"&t="+tok);
				}
			}
			else if(InventoryType == 1) {
				// Per option stock levels
				var fp = document.getElementById("frmProducts").elements;
				var c = 0;
				var is_error = false;
				var update_data = "";

				total_stock_units = 0;

				for(i = 0; i < fp.length; i++) {
					if(fp[i].id.indexOf("stock_level_"+ProductId) > -1 || fp[i].id.indexOf("stock_level_notify_"+ProductId) > -1) {
						if(isNaN(fp[i].value) || fp[i].value == "") {
							alert("%%LNG_EnterValidStockLevel%%");
							fp[i].focus();
							fp[i].select();
							is_error = true;
							break;
						}
						else {
							// It's a valid inventory related value
							update_data = update_data + fp[i].id + "=" + fp[i].value + "&";

							// Add the number of current units in stock so we can update the "In Stock" field
							if(fp[i].id.indexOf("stock_level_notify") == -1)
								total_stock_units = total_stock_units + parseInt(fp[i].value);
						}
					}
				}

				// All inventory-related fields are valid, run the AJAX query
				if(!is_error) {
					// Update the loading image
					loading.src = "images/ajax-loader.gif";

					// Valid stock level numbers, save them using AJAX
					action = "update_inventory_levels";
					DoCallback("w=updatePerOptionInventoryLevels&i="+escape(update_data)+"&t="+tok);
				}
			}
		}

		function show_inventory_levels(result) {
			var inventory_info = document.getElementById("StockLevelInfo" + inventory_product_id);
			inventory_info.innerHTML = result;
		}

		function update_inventory_levels(result) {

			// Update the loading image
			var loading = document.getElementById("loading"+inventory_product_id);
			var instock_cell = document.getElementById("InStock"+inventory_product_id);
			loading.src = "images/ajax-blank.gif";

			if(result == "1") {
				//instock_cell.innerHTML = total_stock_units;
				display_success('ProductsStatus', "%%LNG_InventoryLevelsUpdated%%".replace("%d", inventory_product_id));
			}
			else {
				display_error('ProductsStatus', "%%LNG_InventoryLevelsUpdateFailed%%");
			}
		}

		function ProcessData(html) {

			ret = html;

			if(action == "get_inventory_levels") {
				show_inventory_levels(ret);
			}
			else if(action == "update_inventory_levels") {
				update_inventory_levels(ret);
			}
		}

		function confirm_delete_custom_search(search_id) {
			if(confirm("%%LNG_ConfirmDeleteCustomSearch%%"))
				document.location.href = "index.php?ToDo=deleteCustomProductSearch&searchId="+search_id;
		}

		// Hide the product thumbnail row if required
		$(document).ready(function() {
			if("%%GLOBAL_HideThumbnailField%%" == "1") {
				$("td.ImageField").css("display", "none");
			}
		});

		function quickToggle(element, what) {
			$.ajax({
				url: element.href + '&ajax=1',
				success: function(response) {
					if(response) {
						if(element.childNodes.length == 1 && element.childNodes[0].tagName == "IMG") {
							var image = element.childNodes[0];

							// Element was ticked, now should not be
							if(image.src.indexOf('tick') != -1) {
								element.href = element.href.replace(what+'=0', what+'=1');
								image.src = image.src.replace('tick', 'cross');
							}
							else {
								element.href = element.href.replace(what+'=1', what+'=0');
								image.src = image.src.replace('cross', 'tick');
							}
						}
					}
				}
			});
		}

		function BulkEditSelected() {
			var fp = document.getElementById("frmProducts").elements;
			var c = 0;

			for(i = 0; i < fp.length; i++)
			{
				if(fp[i].type == "checkbox" && fp[i].checked)
					c++;
			}

			if(c > 1)
			{
				document.getElementById("frmProducts").action = "index.php?ToDo=bulkEditProducts";
				document.getElementById("frmProducts").submit();
			}
			else
			{
				alert("%%LNG_ChooseProductToBulkEdit%%");
			}
		}

	</script>
