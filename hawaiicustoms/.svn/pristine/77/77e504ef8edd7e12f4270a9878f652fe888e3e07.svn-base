/* Product Variations */
var baseProduct = {};

function updateSelectedVariation(parent, variation, id) {
	if(parent == undefined) {
		parent = $('body');
	}
	else {
		parent = $(parent);
	}

	if(typeof(baseProduct.price) == 'undefined') {
		if($('.AddCartButton', parent).css('display') == "none") {
			var cartVisible = false;
		}
		else {
			var cartVisible = true;
		}
		baseProduct = {
			saveAmount: $('.YouSaveAmount', parent).html(),
			price: $('.VariationProductPrice', parent).html(),
			sku: $('.VariationProductSKU', parent).html(),
			weight: $('.VariationProductWeight', parent).html(),
			thumb: $('.ProductThumb img', parent).attr('src'),
			thumbLink: $('.ProductThumb .ViewLarger', parent).html(),
			cartButton: cartVisible
		};
	}

	// Show the defaults again
	if(typeof(variation) == 'undefined') {
		if(baseProduct.saveAmount) {
			$('.YouSave', parent).show();
			$('.YouSaveAmount').html(baseProduct.saveAmount);
		} else {
			$('.YouSave', parent).hide();
		}
		$('.VariationProductPrice', parent).html(baseProduct.price);
		$('.VariationProductSKU', parent).html(baseProduct.sku);
		$('.VariationProductWeight', parent).html(baseProduct.weight);
		$('.CartVariationId', parent).val('');
		$('.ProductThumb img', parent).attr('src', baseProduct.thumb);
		$('.ProductThumb .ViewLarger', parent).html(baseProduct.thumbLink);
		$(parent).attr('currentVariation', '');
		$(parent).attr('currentVariationImage', '')
		$('.VariationOutOfStockMessage', parent).remove();
		if(baseProduct.sku == '') {
			$('.ProductSKU', parent).hide();
		}
		if(baseProduct.cartButton) {
			$('.AddCartButton', parent).show();
			if(typeof ShowAddToCartQtyBox != 'undefined' && ShowAddToCartQtyBox=='1') {
				$('.QuantityInput', parent).show();
			}
		}


		$('.InventoryLevel', parent).hide();
	}
	// Othersie, showing a specific variation
	else {
		$('.VariationProductPrice', parent).html(variation.price);
		if(variation.sku != '') {
			$('.VariationProductSKU', parent).html(variation.sku);
			$('.ProductSKU', parent).show();
		}
		else {
			$('.VariationProductSKU', parent).html(baseProduct.sku);
			if(baseProduct.sku) {
				$('.ProductSKU', parent).show();
			}
			else {
				$('.ProductSKU', parent).hide();
			}
		}
		$('.VariationProductWeight', parent).html(variation.weight);
		$('.CartVariationId', parent).val(id);
		if(variation.instock == true) {
			$('.AddCartButton', parent).show();
			if(typeof ShowAddToCartQtyBox != 'undefined' && ShowAddToCartQtyBox=='1') {
				$('.QuantityInput', parent).show();
			}
			$('.VariationOutOfStockMessage', parent).remove();
		}
		else {
			$('.AddCartButton, .QuantityInput', parent).hide();
			$('.VariationOutOfStockMessage', parent).remove();
			$('.AddCartButton', parent).before('<p class="VariationOutOfStockMessage">'+lang.VariationSoldOutMessage+'</p>');
		}
		if(variation.thumb != '') {
			$('.ProductThumb img', parent).attr('src', variation.thumb);
			$('.ProductThumb .ViewLarger', parent).html('See larger picture');
			$(parent).attr('currentVariation', id);
			$(parent).attr('currentVariationImage', variation.image)
		}
		else {
			$('.ProductThumb img', parent).attr('src', baseProduct.thumb);
			$('.ProductThumb .ViewLarger', parent).html(baseProduct.thumbLink);
			$(parent).attr('currentVariation', '');
			$(parent).attr('currentVariationImage', '')
		}
		if(variation.stock) {
			$('.InventoryLevel', parent).show();
			$('.VariationProductInventory', parent).html(variation.stock);
		}
		else {
			$('.InventoryLevel', parent).hide();
		}
		if(variation.saveAmount) {
			$('.YouSave', parent).show();
			$('.YouSaveAmount').html(variation.saveAmount);
		} else {
			$('.YouSave', parent).hide();
		}
	}
}

function initializeVariations(parent, VariationList)
{
	if(parent == undefined) {
		parent = $('body');
	}
	else {
		parent = $(parent);
	}

	// Select boxes are used if there is more than one variation type
	if($('.ProductOptionList select', parent).length > 0) {
		$('.ProductOptionList select', parent).each(function(index) {
			$(this).change(function() {
				if($(this).val()) {
					var next = $('.ProductOptionList select', parent).get(index+1);
					if(next) {
						$('.ProductOptionList select', parent).get(index+1).resetNext();
						$('.ProductOptionList select', parent).get(index+1).fill();
						$('.ProductOptionList select', parent).get(index+1).disabled = false;
					}
				}
				else {
					this.resetNext();
				}

				// Do we have a full match?
				ourCombination = this.getFullCombination();
				for(x in VariationList) {
					variation = VariationList[x];
					if(variation.combination == ourCombination) {
						updateSelectedVariation(parent, variation, x);
						return;
					}
				}
				// No match or incomplete selection
				updateSelectedVariation(parent);
			});

			this.getFullCombination = function() {
				var selected = new Array();
				$('.ProductOptionList select', parent).each(function() {
					selected[selected.length] = $(this).val();
				});
				return selected.join(',');
			}


			this.getCombination = function() {
				var selected = new Array();
				var thisSelect = this;
				$('.ProductOptionList select', parent).each(function() {
					if(thisSelect == this) {
						return false;
					}
					selected[selected.length] = $(this).val();
				});
				// Add the current item
				selected[selected.length] = $(this).val();
				return selected.join(',');
			}

			this.resetNext = function() {
				$(this).nextAll().each(function() {
					this.selectedIndex = 0;
					this.disabled = true;
				});
			};

			this.fill = function(selectedVal) {
				// Remove everything but the first option
				$(this).find('option:gt(0)').remove();

				var show = true;
				var previousSelection;

				// Get the values of the previous selects
				var previous = $('.ProductOptionList select', parent).get(index-1);
				if(previous) {
					previousSelection = previous.getCombination();
				}
				for(var i = 1; i < this.variationOptions.length; i++) {
					for(x in VariationList) {
						variation = VariationList[x];
						if(previousSelection) {
							var show = false;
							if((variation.combination+',').indexOf(previousSelection+','+this.variationOptions[i].value+',') == 0) {
								var show = true;
								break;
							}
							else {
							}
						}
					}
					if(show) {
						this.options[this.options.length] = new Option(this.variationOptions[i].text, this.variationOptions[i].value);
					}
				}
								if(selectedVal != undefined) {
					$(this).val(selectedVal);
				}
			};

			// Steal the options and store them away for later
			variationOptions = new Array();
			$(this).find('option').each(function() {
				if(typeof(this.text) == undefined) {
					this.text = this.innerHTML;
				}
				variationOptions[variationOptions.length] = {value: this.value, text: this.text };
			});
			selectedVal = $(this).val();
			this.variationOptions = variationOptions;
			if(index == 0) {
				this.fill(selectedVal);
			}
			else if(!selectedVal) {
				this.disabled = true;
			}
		});
	}
	// Otherwise, radio buttons which are very easy to deal with
	else {
		$('.ProductOptionList input[type=radio]', parent).click(function() {
			for(x in VariationList) {
				variation = VariationList[x];
				if(variation.combination == $(this).val()) {
					updateSelectedVariation(parent, variation, x);
					return;
				}
			}
			// No match or incomplete selection
			updateSelectedVariation(parent);
		});
		$('.ProductOptionList input[type=radio]:checked', parent).trigger('click');
	}
}

function GenerateProductTabs()
{
	var ActiveTab = 'Active';
	var ProductTab = '';
	var TabNames = new Array();
	var path = config.ShopPath + '/templates/default/images/small_pluscart.gif';
	var img = "<img src='"+path+"' id='tImage' />";
	var desc = $('.ProductDetailsGrid > dd > a').eq(0).text() +" "+ $('.VariationProductSKU').text();
	var compbrand = $('#hid_rdprod_0').val();
    if(compbrand == ' ') { // Created when first item is not a complementary -- Baskaran
        compbrand = "No Complementary";
    }
	TabNames['ProductReviews'] = lang.Reviews; //commented due to client request -- Baskaran  
 
	TabNames['ProductDescription'] = desc;
    TabNames['ApplicationChart'] = "Application Guide";
	TabNames['ProductWarranty'] = lang.Warranty;
	TabNames['ProductManufacturer'] = "Manufacturer";
	TabNames['ProductInstruction'] = "Instruction";
	TabNames['ProductArticle'] =  "Article";
	TabNames['ProductOtherDetails'] = lang.OtherDetails;
	TabNames['CompItem'] = img + compbrand; // Baskaran
	TabNames['SimilarProductsByTag'] = lang.ProductTags;

	$('#product-content .Moveable').each (

		function() {
			if(this.id != 'ProductBreadcrumb' &&  this.id != 'ProductDetails') {

				if (TabNames[this.id]) {

					TabName = TabNames[this.id];
					ProductTab += '<li id="'+this.id+'_Tab" class="'+ActiveTab+'"><a onclick="ActiveProductTab(\''+this.id+'_Tab\'); return false;" href="#">'+TabName+'</a></li>';

					if (ActiveTab == '')
					{
						$('#'+this.id).hide();
					}
					$('#'+this.id).removeClass('Moveable');
					ActiveTab = "";
				}
			}
		}
	);

	if (ProductTab != '')
	{
		$('#ProductTabs').html(ProductTab);
	}
}

function ActiveProductTab(TabId)
{
	var CurTabId = $('#ProductTabs .Active').attr('id');
	var CurTabContentId = CurTabId.replace('_Tab','');

	$('#ProductTabs .Active').removeClass('Active');

	$('#'+CurTabContentId).hide();

	$('#'+TabId).addClass('Active');

	var NewTabContentId = TabId.replace('_Tab','');
	$('#'+NewTabContentId).show();

}

function CheckEventDate() {

	var result = true;

	if(typeof(eventDateData) == 'undefined')
		return true;

	if ($('#EventDateDay').val() == -1 || $('#EventDateMonth').val() == -1 || $('#EventDateYear').val() == -1) {
		alert(eventDateData['invalidMessage']);
		return false;
	}

	if (eventDateData['type'] == 1) {

		if (new Date($('#EventDateYear').val()+'/'+$('#EventDateMonth').val()+'/'+$('#EventDateDay').val()) > new Date(eventDateData['compDateEnd'])
		 || new Date($('#EventDateYear').val()+'/'+$('#EventDateMonth').val()+'/'+$('#EventDateDay').val()) < new Date(eventDateData['compDate'])
		) {
			result = false;
		}

	} else if (eventDateData['type'] == 2) {
		if (new Date($('#EventDateYear').val()+'/'+$('#EventDateMonth').val()+'/'+$('#EventDateDay').val()) < new Date(eventDateData['compDate'])) {
			result = false;
		}

	} else if (eventDateData['type'] == 3) {
		if (new Date($('#EventDateYear').val()+'/'+$('#EventDateMonth').val()+'/'+$('#EventDateDay').val()) > new Date(eventDateData['compDate'])) {
			result = false;
		}
	} else {
		result = true;
	}

	if (!result) {
		alert(eventDateData['errorMessage']);
	}
	return result;
}

function togglechart(id) {
	var e = document.getElementById('t'+id);
	var f = document.getElementById('subs'+id);
	   if(e.style.display == 'none')  {
		  e.style.display = '';
		  f.style.display = 'none';
	   }
	   else {
		  e.style.display = 'none';
		  f.style.display = '';
	   }
}

function Check()
    {
        if($('#nothanks').attr('checked') == true) {
			$('[name="rdprod[]"]').each(function(index,item){
			$(this).attr('checked',false)
			var id = item.value;
			$('#compqty_'+id).hide();
			$('#pr_'+id).hide();
			});
        }
    }

function unCheck() {
	$('#nothanks').attr('checked',false);
}

function chksubmit() 
{ 
	var a = $("[name='rdprod[]']").val();
	var b = $('#hidselcomp').val();
	var fields = $("[name='rdprod[]']").serializeArray();
	var fields1 = $("#nothanks").serializeArray(); 

	if(typeof(a) != 'undefined') {
	  if (((fields.length == 0) && (fields1.length == 0)) || (fields.length == 0 && fields1.length == '')) { 
		alert('Please select at least one Complementary item.'); 
		return false;
	  }
	  else if(b == 1) {
//			if(fields.length == 0 ) { Kate replaced with the next line
	                if (((fields.length == 0) && (fields1.length == 0)) || (fields.length == 0 && fields1.length == '')) { 
				alert('Please select atleast one or more Complementary items.'); 
				return false;
			}
			else {
				return true
			}
		}
		else  {
			if((fields.length != 1) && (fields.length != 0)) {
				alert('Please select only one Complementary item.'); 
				return false;
			}
			else {
				return true
			}
		}
	}
}

$(document).ready(function() {
	if(typeof(HideProductTabs) != 'undefined' && HideProductTabs == 0) {
		GenerateProductTabs();
		if(typeof(ActiveReviewTab) != 'undefined' && ActiveReviewTab == 1) 
		{
			ActiveProductTab('ProductReviews_Tab');
		}
	}

	if(typeof VariationList == 'undefined') {
		return;
	}
	initializeVariations('body', VariationList);

});
