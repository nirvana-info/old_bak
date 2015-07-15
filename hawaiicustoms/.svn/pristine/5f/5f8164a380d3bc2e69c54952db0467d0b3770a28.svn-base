//zcs=>
/**
 * Single select product by popup window & autocomplete
 * @author wilson.zeng
 **/
var SingleProduct = {
	proSelectId: '',
	proSelectName: '',
	proSelectPrice: '',
	
	ShowProductSelector: function() {

		var width = 700;
		var height = 680;
		var l = (screen.availWidth/2) - (width/2);
		var t = (screen.availHeight/2) - (height/2);
		
		windowLocation = 'index.php?ToDo=popupProductSelect';
		windowLocation += '&selectCallback=SingleProduct.ProductSelectCallback';
		windowLocation += '&getSelectedCallback=SingleProduct.ProductSelectGetSelected';
		windowLocation += '&closeCallback=SingleProduct.ProductSelectCloseCallback';
		windowLocation += '&ProductList='+SingleProduct.proSelectName;
		windowLocation += '&ProductSelect='+SingleProduct.proSelectId;
		windowLocation += '&single=1';
		windowLocation += '&FocusOnClose=';
		var w = window.open(windowLocation, 'productSelect', "width="+width+",height=" + height + ",left="+l+",top="+t);
		w.focus();
		return false;
	},
	//1.when choose category on popup window, this will be forked
	//--must return a string of current selected product id
	ProductSelectGetSelected: function(proSelectId){
		return $('#' + SingleProduct.proSelectId).val();
	},
	//2.when click to select one product on popup window || select by autocomplete searchbox, this will be forked
	ProductSelectCallback: function(proSelectId, proSelectName, objProduct){
		$('#' + SingleProduct.proSelectId).val(objProduct['id']);
		$('#' + SingleProduct.proSelectName).val(objProduct['name']);
		$('#' + SingleProduct.proSelectPrice).val(objProduct['price']);
	},
	//3.when click on the "Select" button on the popup window, this will be forked
	ProductSelectCloseCallback: function(proSelectId){
		return true;
	},
	
	/**
	 * auto-complete search box
	 * @author wilson.zeng
	 * @description altered from order.manager.js
	*/
	ProductSearch: function(element){
		
		var itemRow = $(element).parents('.rowItem');
		
		if($(element).data('timeout')) {
			clearTimeout($(element).data('timeout'));
		}

		if(!$(element).data('hasEvents')) {
			$(element)
				.blur(function() {
					var itemRow = $(this).parents('.rowItem');
					resultsBox = $('.ProductSearchResults', itemRow);
					if($(element).data('timeout')) {
						clearTimeout($(element).data('timeout'));
					}
					if(!resultsBox.data('mousedown')) {
						$(resultsBox).hide();
						resultsBox.find('.SearchBoxRecordSelected').removeClass('SearchBoxRecordSelected');
					}
				})
				.focus(function() {
					var itemRow = $(this).parents('.rowItem');
					if($('.ProductSearchResults', itemRow).html() != '') {
						$('.ProductSearchResults', itemRow)
							.css({
								width: $(element).width()+'px'
							})
							.show();
					}
				})
				.click(function(e) {
					var itemRow = $(this).parents('.rowItem');
					resultsBox = $('.ProductSearchResults', itemRow);
					e.preventDefault();
					e.stopPropagation();
					$(resultsBox).scrollTop = 0;
					if($(resultsBox).html() != '') {
						$(resultsBox).show();
					}
				})
				.data('hasEvents', true)
			;
		}

		$(element).data('timeout', setTimeout(function() {
			
			// Value hasn't changed so don't do anything
			if($(element).val() == $(element).data('lastValue')) {
				return;
			}

			$(element).data('lastValue', $(element).val());

			// Show the loading icon
			$('.ProductNameLoading', itemRow).show();
			$('.ProductSearchResults').remove();

			// Search for the products and load them up
			$.ajax({
				url: 'remote.php?w=orderSearchProducts&remoteSection=orders',
				data: {
					searchQuery: $(element).val()
				},
				success: function(data) {
					
					$('.ProductSearchResults').remove();

					// Hide the loading indicator
					$('.ProductNameLoading', itemRow).hide();

					// Build and position the results box
					$('<div>')
						.addClass('ProductSearchResults')
						.addClass('IconSearchBox')
						.html('<ul>'+data+'</ul>')
						.css({
							position: 'absolute',
							top: $(element).height()+8,
							left: '2px',
							width: $(element).width()
						})
						.appendTo($(element).parent('div'))
						.show()
						.mousedown(function() {
							$(this).data('mousedown', true);
						})
						.mouseup(function() {
							$(this).data('mouseup', false);
						})
					;

					// Event to fire when the "View Product" link is clicked
					$('.ProductSearchResults .History', itemRow).click(function(e) {
						e.preventDefault();
						e.stopPropagation();
						window.open($(this).find('a').attr('href'));
					});

					// Event to fire when a particular product is selected
					$('.ProductSearchResults .SearchBoxRecord', itemRow)
						.click(function() {
							var recordBox = $(this);
							resultsBox = recordBox.parents('.ProductSearchResults').hide();
							var product = {
								id: $('.SearchResultProductId', recordBox).val(),
								name: $('.SearchResultProductName', recordBox).val(),
								code: $('.SearchResultProductCode', recordBox).val(),
								isConfigurable: $('.SearchResultProductConfigurable', recordBox).val(),
								price: $('.SearchResultProductPrice', recordBox).val()
							};
							SingleProduct.ProductSelectCallback(SingleProduct.proSelectId, SingleProduct.proSelectName, product);
							$('.ProductSearchResults', itemRow).html('');
						});
						$('.SearchBoxRecord')
						.hover(function() {
							$(this).siblings('.SearchBoxRecordSelected').removeClass('SearchBoxRecordSelected');
							$(this).addClass('SearchBoxRecordSelected');
						}, function() {
							$(this).removeClass('SearchBoxRecordSelected');
						})
					;
				}
			});
		}, 300));
	}
}
//<=zcs