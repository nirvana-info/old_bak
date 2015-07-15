<style type="text/css">
    @import url("Styles/iselector.css");
</style>
<script type="text/javascript" src="../javascript/iselector.js"></script>
<script type="text/javascript">

var current_category = "0"; 

var ProductSelect = {
    selectedItems: new Array(),
    selectedItemsCSV: '',
    selectCallback: null,
    closeCallback: null,
    removeCallback: null,
    getSelectedCallback: null,
    resultSet: new Array(),

    OnClick: function(element) {
        if(element.selected == true) {
            ProductSelect.AddToSelect(element.value, element.firstChild.nodeValue);
        }
        else {
            ProductSelect.RemoveFromSelect(element.value);
        }
    },

    
    
    RemoveFromSelect: function(id) {
        if(ProductSelect.removeCallback === null) {
            alert('Callback not specified');
            return false;
        }

        ProductSelect.removeCallback('%%GLOBAL_ParentProductSelect%%', '%%GLOBAL_ParentProductList%%', id);
    },

    AddToSelect: function(id, name) {
        if(ProductSelect.selectCallback === null) {
            alert('Callback not specified');
            return false;
        }

        product = ProductSelect.resultSet[id];
        ProductSelect.selectCallback('%%GLOBAL_ParentProductSelect%%', '%%GLOBAL_ParentProductList%%', product, %%GLOBAL_ProductSelectSingle%%);
    },

    ButtonClose: function() {
        if(!window.opener) {
            self.parent.tb_remove();
        }
        else {
            window.opener.focus();
            if(ProductSelect.closeCallback) {
                ProductSelect.closeCallback('%%GLOBAL_ParentProductSelect%%');
            }
            else if('%%GLOBAL_FocusOnClose%%' != '') {
                window.opener.document.getElementById('%%GLOBAL_FocusOnClose%%').focus();
            }
            window.close();
        }
    },

    GetSelectedItems: function() {
        ProductSelect.selectedItems = new Array();
        ProductSelect.selectedItemsCSV = '';

        if(ProductSelect.getSelectedCallback === null) {
            return;
        }

        ProductSelect.selectedItemsCSV = ProductSelect.getSelectedCallback('%%GLOBAL_ParentProductSelect%%');
        ProductSelect.selectedItems = ProductSelect.selectedItemsCSV.split(',');
    },

    LoadLinks: function(id) {
        var searchParams = '';

        if($('#searchQuery').val() != '') {
            searchParams += '&searchQuery='+encodeURIComponent($('#searchQuery').val());
        }

        if(id) {
            searchParams += '&'+id;
        }

        $('#LoadingIndicator').show();
        // Fetch the results
        $.ajax({
            url: 'remote.php?w=popupProductSearch&'+searchParams,
            dataType: 'xml',
            success: ProductSelect.LinksLoaded,
            error: ProductSelect.LinksLoaded
        });
    },

      LoadLinksPname: function(type) {
        

        $('#LoadingIndicator').show();
        // Fetch the results
        $.ajax({
            url: 'remote.php?w=popupProductSort&type='+type,
            dataType: 'xml',
            success: ProductSelect.LinksLoaded,
            error: ProductSelect.LinksLoaded
        });
    },
    
    
    LoadProducts: function(id) {
        var searchParams = '';


        if(id) {
            searchParams += '&'+id;
        }

        $('#LoadingIndicator').show();
        // Fetch the results
        $.ajax({
            url: 'remote.php?w=popupProductList&'+searchParams,
            dataType: 'xml',
            success: ProductSelect.LinksLoaded,
            error: ProductSelect.LinksLoaded
        });
    },
    
    onSelectChange: function()
    {
        var element = document.getElementById('prodSelect').options[document.getElementById('prodSelect').selectedIndex];
        ProductSelect.OnClick(element);
    },

    LinksLoaded: function(xml) {
        var status = $('status', xml).text();
        ProductSelect.resultSet = new Array();
        if(status == 0) {
            var message = $('message', xml).text();
            $('#results').html('<div class="BigError">'+message+'</div>');
        }
        else {
            var results = $('results', xml).text();

            if(%%GLOBAL_ProductSelectSingle%% == 1) {
                $('#results').html('<select style="width: 100%;" size="11" name="products" id="prodSelect" onchange="ProductSelect.onSelectChange()"></select>');
            }
            else {
                $('#results').html('<select style="width: 770px;height: 280px;" multiple="multiple" name="products" id="prodSelect" class="ISSelectReplacement"></select>');
            }

            $('product', xml).each(function() {
                productId = $('productId', this).text();
                productName = $('productName', this).text();
                prodprice = $('productPrice',this).text();  
                partNumber =  $('productCode',this).text();    
                ProductSelect.resultSet[productId] = {
                    id: productId,
                    name: productName,
                    price: $('productPrice', this).text(),
                    type: $('productType', this).text(),
                    code: $('productCode', this).text(),
                    isConfigurable: $('productConfigurable', this).text()
                };
                $('<option>')
                    .val(productId)
                    .html(productName+" , $"+prodprice+" , "+partNumber)      
                    .click(function() {
                        ProductSelect.OnClick(this);
                    })
                    .attr('id', 'select_product_'+productId)
                    .appendTo('#prodSelect')
                ;
            });

            // Mark any selected items
            ProductSelect.GetSelectedItems();
            for(var i=0; i<ProductSelect.selectedItems.length;i++) {
                if($('#select_product_'+ProductSelect.selectedItems[i])) {
                    $('#select_product_'+ProductSelect.selectedItems[i]).attr('selected', true);
                }
            }
            if(%%GLOBAL_ProductSelectSingle%% == 0) {
                ISSelectReplacement.replace_select(g('prodSelect'));
            }
        }
        // Hide loading indicator
        $('#LoadingIndicator').hide();
    }
    
       
};
/* Added by baskaran */
function doSearch() {
    ProductSelect.LoadLinks("category=" + current_category);
}

$(document).ready(function() {
    var searchTimer = 0;

    $("#searchQuery").keyup(function() {
        if (searchTimer) {
            clearTimeout(searchTimer);
        }

        var value = $.trim($(this).val());
        if (value.length < 3) {
            return;
        }

        searchTimer = setTimeout("doSearch()",700);
    });
});
/* Ends here */
%%GLOBAL_Callbacks%%
</script>


<script type="text/javascript">  
   function select_all()
        { 
      
        var i=0;            
            $( "#prodSelect :checkbox").each(function(){
            
               // $(this).attr('checked', 'checked') ;
                
              liId = 'ISSelectproducts_'+$(this).val();
                liObj = document.getElementById(liId); 
                on_click_temp(liObj,i);
               i++;   
            
            
            }); 
          
            
            
        }
        
        
        function on_click_temp(element, id)
        {
            if(element.dblclicktimeout)
            {
                return false;
            }
            if(element.tagName == "INPUT")
            {
                var checkbox = element;
                if(checkbox.disabled) {
                    return false;
                }
                var element = element.parentNode;
            }
            else
            {
                var checkbox = element.getElementsByTagName('input')[0];
                if(checkbox.disabled) {
                    return false;
                }
                checkbox.checked = !checkbox.checked;
            }

            element.dblclicktimeout = setTimeout(function() { element.dblclicktimeout = ''; }, 250);

            var id = id;

            // Selected an option group child
            if(id.length == 2)
            {
                var replacement = element.parentNode.parentNode.parentNode.parentNode;
                var option = replacement.select.childNodes[id[0]].childNodes[id[1]];
            }
            else
            {
                var replacement = element.parentNode.parentNode;
                var option = replacement.select.childNodes[id];
            }

            option.selected = checkbox.checked;
            replacement.selectedIndex = replacement.select.selectedIndex;
            $(option).triggerHandler('click');
            if(checkbox.checked)
            {
                $(element).addClass('SelectedRow');
            }
            else
            {
                $(element).removeClass('SelectedRow');
            }
        }
</script>   
<form id="ProductSelect" style="margin: 0; padding: 0;">
    <!--<script type="text/javascript">var current_category = "0"; </script>-->
    <table class="OuterPanel" style="position: relative;">
      <tr>
        <td class="Heading1" id="tdHeading">%%LNG_SelectProducts%%</td>
      </tr>
      <tr>
        <td class="Intro">
            <div id="LoadingIndicator" style="display: none; font-size: 11px; padding-bottom:10px; position:absolute; right: 10px; top:15px; ">
                <img src="images/ajax-loader.gif" align="left" />&nbsp; <div style="display:inline; background-color:#FCF5AA; padding:5px">%%LNG_LoadingPleaseWait%%</div>
            </div>
            %%LNG_SelectProductsIntro%%
        </td>
      </tr>
      <tr>
        <td>
          <table cellpadding="0" cellspacing="0" border="0">
          <tr>         
            <td>       
                <input onclick="ToggleUsedFor(0)" type="radio" id="usedforcat" name="usedfor" checked="checked"> <label for="usedforcat">%%LNG_Category%%</label>
            </td>
            <td>
                <input onclick="ToggleUsedFor(1)" type="radio" id="radiobrand" name="usedfor"> <label for="usedforprod" >%%LNG_Brand%%</label>
            </td>
          </tr>
          </table>
        </td>
      </tr>      
      <tr>
        <td>
            <table class="Panel" id="categorylist">
              <tr>
                <td class="Heading2">&nbsp;&nbsp; %%LNG_ProductSelectByCategory%%</td>
              </tr>
                <tr>
                    <td>
                    <ul class='CategorySelect' id='CategorySelect'>
                        <li onclick='this.className="active"; var current_category = 0; if(this.parentNode.previousItem) { this.parentNode.previousItem.className = ""; } this.parentNode.previousItem = this; ProductSelect.LoadLinks("");'><img src='images/category.gif' alt='' style='vertical-align: middle' /> %%LNG_ProductSelectAllCategories%%</li>
                        %%GLOBAL_CategorySelect%%
                    </ul>
                    </td>
                </tr>
            </table>
            <table class="Panel" id="brandlist" style="display:none;">
              <tr>
                <td class="Heading2">&nbsp;&nbsp; %%LNG_ProductSelectByBrand%%</td>
              </tr>
                <tr>
                    <td>
                        <select name="productbrand" id="productbrand" onchange="SelectSeriesBrands(this.value);">
                            <option value="0">Select Brand</option>
                                %%GLOBAL_BrandSelect%%
                        </select>
                    </td>
                </tr>
                <tr>
                    <td id="selectseries">
                        <select name="productseries" id="productseries" class="Field200">
                            <option value="0">-- Choose an Existing Series --</option>
                        </select>
                    </td>
                </tr>
            </table>
            <table class="Panel" id="searchbox">
                <tr>
                    <td class='Heading2'>&nbsp;&nbsp;%%LNG_ProductSelectSearch%%</td>
                </tr>
                <tr>
<!--                    <td><input type='text' name='searchQuery' id='searchQuery' class='Field250' style='width: 100%' onkeyup='if(!this.oldValue || this.oldValue != this.value) { this.oldValue = value; ProductSelect.LoadLinks("category="+current_category); }' /></td>-->
                    <td><input type='text' name='searchQuery' id='searchQuery' class='Field250' style='width: 100%' /></td>
                </tr>
            </table>
                <table class="Panel">
                <tr>  <td class='Heading2' align="left">
         <a href='javascript:select_all();'>Check/Uncheck All </a> 
      </td>
                    <td class='Heading2'><a href='javascript:ProductSelect.LoadLinksPname("prodname");'>Product Name</a></td> <td class='Heading2'><a href='javascript:ProductSelect.LoadLinksPname("prodprice");'>Price</a></td>  <td class='Heading2'><a href='javascript:ProductSelect.LoadLinksPname("prodcode");'>Part number</a></td>      <td class='Heading2'><a href='javascript:ProductSelect.LoadLinksPname("catname");'>Category Name</a></td>        <td class='Heading2'><a href='javascript:ProductSelect.LoadLinksPname("seriesname");'>Series name</a></td>        
                </tr>
                
            </table>
            <input type='hidden' name='subCats' value='0' />
            <div id="results" class="ResultList">
            </div>
            <div id="ButtonRow" style="margin-top: 15px;">
            
       <input type="button" class="FormButton Field100" value="%%LNG_SelectAndClose%%"  onclick="ProductSelect.ButtonClose();" />   
    
                
            </div>
        </td>
    </tr>
    </table>
    <script type='text/javascript'>g('CategorySelect').previousItem = g('CategorySelect').firstChild; setTimeout(function() { ProductSelect.LoadLinks(); }, 10);</script>
</form>
<script>
function ToggleUsedFor(Which) 
    {
            
            var usedforcat = document.getElementById("usedforcat");
            var radiobrand = document.getElementById("radiobrand");
            var tempr1 = document.getElementById("categorylist");
            var tempr2 = document.getElementById("brandlist");
            var tempr3 = document.getElementById("searchbox");

            if(Which == 0) {
                usedforcat.checked = true;
                tempr2.style.display = "none";
                tempr1.style.display = '';
                tempr3.style.display = '';
                $('#prodSelect').empty();
                $('#productbrand').attr('selectedIndex',0);
                $('#productseries').attr('selectedIndex',0);
            }
            else {
                radiobrand.checked = true;
                tempr1.style.display = "none";
                tempr2.style.display = '';
                tempr3.style.display = "none";
                $('#prodSelect').empty();
                
            }
    }
</script>