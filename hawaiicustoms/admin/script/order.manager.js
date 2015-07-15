var OrderManager = {
	customerAddresses: new Array(),
	selectedProduct: new Array(),
	sessionId: '',
	stopSubmit: false,
	contentChanged: false,

	Init: function()
	{
		OrderManager.sessionId = $('#orderSession').val();
		OrderManager.InitCustomerSearch();
		OrderManager.InitBillingShippingFields();
		OrderManager.InitPaymentMethodOptions();
		OrderManager.BindOrderNotesEvents();
		OrderManager.BindAddressSyncEvents();
		OrderManager.AddLastUpdateSync();
		OrderManager.AddOrderItemEvents($('#orderItemsTable'));
		OrderManager.ToggleOrderStatus($('#ordstatus').val());

		$('body').click(function() {
			$('.IconSearchBox').hide();
		});
	},

	CalculateShipping: function()
	{
		$.iModal({
			type: 'ajax',
			url: 'remote.php?remoteSection=orders&w=orderCalculateShipping&'+$.param(OrderManager.GetBaseOrderFields()),
			width: 530
		});
	},

	ToggleShippingMethod: function(value) {
		if(value == 'custom') {
			$('#shippingMethodCustom').show();
			$('#shippingMethodCustom input:first').focus();
		}
		else {
			$('#shippingMethodCustom').hide();
		}
	},
	//Ronnie add, product items cover off
	ToggleOrderStatus: function(value) {
		var ReadonlyAll=false;
		var ReadonlyItem=false;
		//when an order in the status of pending, PayPal pending, awaiting payment}, the entire page is editable.
		if(value==7 || value==1 || value==14){
			ReadonlyAll=false;
			ReadonlyItem=false;
		}
		//when an order in the status of {awaiting fulfillment, awaiting shipment, awaiting pickup}, the "Order Items" and "Payment Method" fields are read-only.
		if(value==11 || value==9 || value==8){
			ReadonlyItem=true;
		}
		//when an order in the status of {partially shipped, shipped, completed,cancelled, declined, refunded}, the entire page should be read-only, exceptthe "Staff Notes", "Order status". 
		if(value==3 || value==2 || value==10 || value==5 || value==6 || value==4){
			ReadonlyAll=true;
			ReadonlyItem=true;
		}
		//when an order in the status of {Return Pending, Returned}, the entire page should be read-only, except the "Staff Notes", "Order status".
		if(value==15 || value==16){
			ReadonlyAll=true;
			ReadonlyItem=true;
		}
		
		//alert(value+":"+ReadonlyItem+":"+ReadonlyAll);
		//IE
		//if(navigator.appName=="Microsoft Internet Explorer"){

			if(ReadonlyAll){
				$('#trOrder input').each(function(){
						$(this).attr("disabled","disabled");
				});
				$('#trOrder select').each(function(){
						$(this).attr("disabled","disabled");
				});
				
				setTimeout(function() {
					$('#trOrder select').each(function(){
						$(this).attr("disabled","disabled");
					});
					$("#ordstatus").removeAttr("disabled");
				},5000);
				$('#ordcustmessage').attr("readonly","readonly")
				$('#ordtrackingno').attr("readonly","readonly")
				$('#tab0').hide();
				$('#tab1').hide();
				$('#tab2').hide();
				$('#RemoveSelectedCustomer').hide();
				switch($('#customerType').val()) {
					case 'new':$('#tab0').show();
						break;
					default :$('#tab1').show();
						break;
				}
			}else{
			
				$('#trOrder input').each(function(){
						$(this).removeAttr("disabled");
				});
				$('#trOrder select').each(function(){
						$(this).removeAttr("disabled");
				});
				$('#disOrderItem').css({position:'Absolute',left:0,top:0,width:0,height:0});
				$('#disOrderItem2').css({position:'Absolute',left:0,top:0,width:0,height:0});
				
				$('#ordcustmessage').removeAttr("readonly");
				$('#ordtrackingno').removeAttr("readonly");
				
				$('#tab0').show();
				$('#tab1').show();
				$('#tab2').show();
				$('#RemoveSelectedCustomer').show();
			}
			//text and button
			$('.CartGrid input').each(function(){
				if(ReadonlyItem || ReadonlyAll){
					$(this).attr("disabled","disabled");
				}else{
					$(this).removeAttr("disabled");
				}
			});
			//hyperlink
			var a_list=$("#orderTable").find("a");
			for(i=0;i<a_list.length;i++){
				//alert(row);
				if(ReadonlyItem || ReadonlyAll){
					$(a_list[i]).hide();
				}else{
					$(a_list[i]).show();
				}
			}
			//Shipping Method
			$('.ShippingMethodList input').each(function(){
				if(ReadonlyItem || ReadonlyAll){
					$(this).attr("disabled","disabled");
				}else{
					$(this).removeAttr("disabled");
				}
			});
			$("#saveandpay").removeAttr("disabled");
			$("#saveandpay1").removeAttr("disabled");
			$("#addAnother").removeAttr("disabled");
			$("#addAnother1").removeAttr("disabled");
			$("#SaveAndExit").removeAttr("disabled");
			$("#SaveAndExit1").removeAttr("disabled");
			$("#ordstatus").removeAttr("disabled");
			$("#cancelbtn").removeAttr("disabled");
			$("#cancelbtn1").removeAttr("disabled");
			//alert($("#SaveAndExit").attr("disabled"));
			if($("#SaveAndExit").attr("disabled")){
				$("#SaveAndExit").removeAttr("disabled");
				$("#SaveAndExit1").removeAttr("disabled");
				$("#saveandpay").removeAttr("disabled");
				$("#saveandpay1").removeAttr("disabled");
			}
			//Payment Method
			$('.PaymentMethod input').each(function(){
				if(ReadonlyAll || ReadonlyItem){
					$(this).attr("disabled","disabled");
				}else{
					$(this).removeAttr("disabled");
				}
			});
			$('.PaymentMethodForm input').each(function(){
				if(ReadonlyAll || ReadonlyItem){
					$(this).attr("disabled","disabled");
				}else{
					$(this).removeAttr("disabled");
				}
			});
			
		/*}else{
			//not IE
			$('.ShippingMethodList input').each(function(){
				$(this).removeAttr("disabled");
			});
			$('#disOrderItem').css({position:'Absolute',left:0,top:0,width:0,height:0});	
			//if(value==9 || value==8 || value==11){
			if(!(value==7 || value==1)){
				var p=$('#orderTable').offset();
				var s=$('#orderTable');
				//alert(s.outerHeight()+":"+s.outerWidth()+":"+p.top);
				$('#disOrderItem').css({position:'Absolute',left:p.left,top:p.top-1,width:s.outerWidth(),height:s.outerHeight()+3});
				$('.ShippingMethodList input').each(function(){
					$(this).attr("disabled","disabled");
				});
			}
		}*/
		//alert($("input[name='orderpaymentmodule'][@checked]").val());
		//setpaypalpayment($("input[name='orderpaymentmodule'][@checked]").val());
	},
	
	ToggleReadonlyByOrderStatus: function(value) {
		/*if(!(value==7 || value==1 || value==11)){
			var p=$('.BodyContainer').offset();
			var s=$('.BodyContainer');
			//alert(s.outerHeight()+":"+s.outerWidth()+":"+p.top);
			$('#disOrderItem').css({position:'Absolute',left:p.left,top:p.top-1,width:s.outerWidth(),height:s.outerHeight()+3});
		}*/
		//When the order status is set to: partially shipped, shipped, completed, cancelled, declined, refunded, "Edit Order" action should be "View Order", all fields on the page should be read-only.
		if(value==3||value==2||value==10||value==4||value==5||value==6){
			$("#saveandpay").hide();
			$("#saveandpay1").hide();
			$("#SaveAndExit").hide();
			$("#SaveAndExit1").hide();
			$("#addAnother").hide();
			$("#addAnother1").hide();
			$("#ordstatus").attr("disabled","disabled");
		}
	},
	

	AddLastUpdateSync: function()
	{
		setTimeout(function() {
			$.ajax({
				url: 'remote.php?remoteSection=orders&w=updateOrderTimeout&orderSession='+OrderManager.sessionId,
				success: function() {
					OrderManager.AddLastUpdateSync();
				}
			})
		}, 900000); // 15 minutes
	},

	BindOrderNotesEvents: function() {
		function ShowOrderCommentsDefault()
		{
			$('#ordcustmessage')
				.val(lang.OrderCommentsDefault)
				.data('usingDefault', 1)
				.addClass('OrderDefaultField')
				.attr('name', 'ordcustmessage_default')
			;
		}

		function ShowOrderNotesDefault()
		{
			$('#ordnotes')
				.val(lang.OrderNotesDefault)
				.data('usingDefault', 1)
				.addClass('OrderDefaultField')
				.attr('name', 'ordnotes_default')
			;
		}

		if(!$('#ordcustmessage').val()) {
			ShowOrderCommentsDefault();
			$('#ordcustmessage')
				.focus(function() {
					if($(this).data('usingDefault') != 1) {
						return;
					}
					$(this)
						.val('')
						.attr('name', 'ordcustmessage')
						.removeClass('OrderDefaultField')
					;
				})
				.blur(function() {
					if(!$(this).val()) {
						ShowOrderCommentsDefault();
					}
					else {
						$(this)
							.data('usingDefault', 0)
						;
					}
				})
			;
		}

		if(!$('#ordnotes').val()) {
			ShowOrderNotesDefault();
			$('#ordnotes')
				.focus(function() {
					if($(this).data('usingDefault') != 1) {
						return;
					}
					$(this)
						.val('')
						.attr('name', 'ordnotes')
						.removeClass('OrderDefaultField')
					;
				})
				.blur(function() {
					if(!$(this).val()) {
						ShowOrderNotesDefault();
					}
					else {
						$(this)
							.data('usingDefault', 0)
						;
					}
				})
			;
		}
	},

	InitPaymentMethodOptions: function()
	{
		var selectedMethod = $('#PaymentMethodList .PaymentMethod input[type=radio]:checked').val();
		if(selectedMethod && selectedMethod != undefined) {
			paymentForm = $('#PaymentMethodList #PaymentMethodForm_'+selectedMethod);
			if($('dt', paymentForm).length > 0) {
				paymentForm.show();
			}
		}

		$('#PaymentMethodList select').trigger('change');

		$('#PaymentMethodList .PaymentMethod input[type=radio]').click(function() {
			setpaypalpaymentstatus($(this).val());
			$('#PaymentMethodList .PaymentMethodForm')
				.not('#PaymentMethodForm_'+$(this).val())
				.hide();
			paymentForm = $('#PaymentMethodForm_'+$(this).val());
			if($('dt', paymentForm).length > 0) {
				paymentForm.show();
			}
		});
	},

	CheckOrderForm: function()
	{
		if(OrderManager.stopSubmit) {
			OrderManager.stopSubmit = false;
			return false;
		}

		switch($('#customerType').val()) {
			case 'new':
				requiredFields = {
					'#custconemail': lang.CustomerEmailRequired,
					'#searchyear': 'Please select year.',
					'#searchmake':  'Please select make.'
				};
                /*'#custpassword': lang.CustomerPasswordRequired,
                '#custpassword2': lang.CustomerPasswordConfirmRequired,*/
				for(field in requiredFields) {
					message = requiredFields[field];
					if(!$(field).val()) {
						alert(message);
						$(field).select().focus();
						return false;
					}
				}

				if($('#custconemail').val().indexOf('@') == -1) {
					alert(lang.CustomerEmailInvalue);
					$('#custconemail').select().focus();
					return false;
				}

				/*if($('#custpassword').val() != $('#custpassword2').val()) {
					alert(lang.CustomerNewPasswordConfirmError);
					$('#custpassword2').select().focus();
					return false;
				}*/

				if($('#custstorecredit').val() && isNaN(priceFormat($('#custstorecredit').val()))) {
					alert(lang.EnterValidStoreCredit);
					$('#custstorecredit').select().focus();
					return false;
				}

				/**
				 * Validate any custom fields
				 */
				var formfields = FormField.GetValues(OrderCustomFormFieldsAccountFormId);

				for (var i=0; i<formfields.length; i++) {
					if (formfields[i].privateId !== '') {
						continue;
					}

					var rtn = FormField.Validate(formfields[i].field);

					if (!rtn.status) {
						alert(rtn.msg);
						FormField.Focus(formfields[i].field);
						return false;
					}
				}

				break;
			case 'existing':
				if($('#customerId').val() == 0 || $('#customerId').val() == -1) {
					alert(lang.ErrorSelectACustomer);
					$('#custSearchBox').focus();
					return false;
				}
				break;
		}

		var validateBilling, validateShipping, formfields = [];
		formfields = formfields.concat(FormField.GetValues(OrderCustomFormFieldsBillingFormId));
		formfields = formfields.concat(FormField.GetValues(OrderCustomFormFieldsShippingFormId));

		if($('#ordbillsaveAddress:checked').val()) {
			validateBilling = true;
		}

		if($('#ordshipsaveAddress:checked').val()) {
			validateShipping = true;
		}

		if (formfields.length > 0) {
			for (var i=0; i<formfields.length; i++) {

				if (!validateBilling && formfields[i].formId == OrderCustomFormFieldsBillingFormId && formfields[i].privateId !== '') {
					continue;
				}

				if (!validateShipping && formfields[i].formId == OrderCustomFormFieldsShippingFormId && formfields[i].privateId !== '') {
					continue;
				}

				var rtn = FormField.Validate(formfields[i].field);

				if (!rtn.status) {
					alert(rtn.msg);
					FormField.Focus(formfields[i].field);
					return false;
				}
			}
		}

		if($('#orderItemsTable').find('tr').length <= 1 || ($('#orderItemsTable').find('tr').length == 2 && !$('#orderItemsTable').find('tr:eq(0)').find('.ProductName').val())) {
			alert(lang.OrderMustContainOneProduct);
			return false;
		}

		if(OrderManager.contentChanged == true) {
			alert(lang.OrderNeedsRefreshing)
			$('#updateTotals').focus();
			return false;
		}

		if(!$('.PaymentMethod input[type=radio]:checked').val() || $('.PaymentMethod input[type=radio]:checked').val() == undefined) {
			alert(lang.InvalidPaymentModule);
			$('.PaymentMethod:first input[name=orderpaymentmodule]').focus();
			return false;
		}

		if($('#emailinvoice:checked').val() && $('#customerType').val() == 'anonymous' && !$('#anonymousemail').val()) {
			alert(lang.AnonymousEmailInvoiceMissingEmail);
			$('#anonymousemail').focus();
			return false;
		}
		//enabled to all
		$('#trOrder input').each(function(){
			$(this).removeAttr("disabled");
		});
		$('#trOrder select').each(function(){
			$(this).removeAttr("disabled");
		});

		return true;
	},

	OpenApplyCoupon: function()
	{
		/* -- Commented as need to show coupon codes -- */
		/*
		$.iModal({
			data: $('#applyCoupon').html(),
			width: 380
		});
		*/
		$('.ModalContent .couponcode').focus();
		$.iModal({
			type: 'ajax',
			url: 'remote.php?remoteSection=orders&w=orderCouponList&'+$.param(OrderManager.GetBaseOrderFields()),
			width: 600
		});
	},

	ApplyCoupon: function()
	{
		if(!$('#ModalContainer .ModalContent .couponcode').val()) {
			alert(lang.EnterCouponOrGiftCertificate);
			$('#ModalContainer .ModalContent .couponcode').focus();
			return false;
		}
		couponCode = $('#ModalContainer .ModalContent .couponcode').val();
		indicator = LoadingIndicator.Show({background: '#fff', parent: '#orderTable'});
		$.modal.close();
		$.ajax({
			url: 'remote.php?remoteSection=orders&w=orderApplyCouponCode',
			data: $.extend({
				couponCode: couponCode,
				orderSession: OrderManager.sessionId
			}, OrderManager.GetBaseOrderFields()),
			dataType: 'json',
			success: function(data)
			{
				if(data.error != undefined) {
					alert(data.error);
				}

				OrderManager.UpdateOrderTable(data);
				LoadingIndicator.Destroy(indicator);
			}
		});
	},

	ShowTab: function(T)
	{
		i = 0;
		while (document.getElementById("tab" + i) != null) {
			$('#div'+i).hide();
			$('#tab'+i).removeClass('active');
			++i;
		}

		$('#div'+T).show();
		$('#tab'+T).addClass('active');
		$('#currentTab').val(T);

		switch(T) {
			case 0: {
				OrderManager.ToggleExistingCustomer(0);
				$('#custFirstName').focus();
				$('#YMMDetailsList').hide();
				$('#YMMDetailsList').html('');
				break;
			}
			case 1: {
				$('#customerType').val('existing');
				try {
					$('#custSearchBox').focus();
				}
				catch(e) {};
				$('#YMMDetailsList').show();
				break;
			}
			case 2: {
				//$('#YMMDetailsList').hide();
				OrderManager.ToggleExistingCustomer(-1);
				$('#YMMDetailsList').html('');
			}
		}
	},

	BindAddressSyncEvents: function()
	{
		var type, formfields = [];
		formfields = formfields.concat(FormField.GetValues(OrderCustomFormFieldsBillingFormId));
		formfields = formfields.concat(FormField.GetValues(OrderCustomFormFieldsShippingFormId));

		for (var i=0; i<formfields.length; i++) {
			type = FormField.GetFieldType(formfields[i].field);

			if (type == 'singleselect' || type == 'selectortext' || type == 'checkboxselect' || type == 'radioselect') {
				FormField.UnBindEvent(formfields[i].field, 'change', OrderManager.BindAddressSyncEventsCallback);
				FormField.BindEvent(formfields[i].field, 'change', OrderManager.BindAddressSyncEventsCallback);

				if (type !== 'selectortext') {
					continue;
				}
			}

			FormField.UnBindEvent(formfields[i].field, 'keyup', OrderManager.BindAddressSyncEventsCallback);
			FormField.BindEvent(formfields[i].field, 'keyup', OrderManager.BindAddressSyncEventsCallback);
		}
	},

	BindAddressSyncEventsCallback: function(event)
	{
		if (typeof(event.data.fieldId) == 'undefined') {
			return;
		}

		var formfield = FormField.GetField(event.data.fieldId);

		if (!formfield) {
			return;
		}

		var newFormId, formId = FormField.GetFieldFormId(formfield);

		if (formId == OrderCustomFormFieldsBillingFormId) {
			var newFormId = OrderCustomFormFieldsShippingFormId;

			if(!$('#shippingUseBilling:checked').val()) {
				return;
			}
		} else {
			var newFormId = OrderCustomFormFieldsBillingFormId;

			if(!$('#billingUseShipping:checked').val()) {
				return;
			}
		}

		/**
		 * Find the matching formfields
		 */
		var matching = false;
		var privateId = FormField.GetFieldPrivateId(formfield);
		var label = FormField.GetLabel(formfield);

		if (privateId !== '') {
			matching = FormField.GetFieldByPrivateId(newFormId, privateId);
		} else if (label !== '') {
			matching = FormField.GetFieldByLabel(newFormId, label);
		}

		if (!matching) {
			return;
		}

		var value = FormField.GetValue(formfield);

		/**
		 * Special case for 'state' field
		 */
		if (privateId == 'State') {
			var options = {
				'options': FormField.GetOptions(formfield, true),
				'display': 'select'
			};

			if (options.options.length == 0) {
				options.display = 'option';
			}

			FormField.SetValue(matching, value, options);

		/**
		 * Else the rest
		 */
		} else {
			FormField.SetValue(matching, value);
		}
	},

	InitBillingShippingFields: function()
	{
		function SaveAddressToggle(type) {
			if(type == 'bill') {
				var parent = $('#ordbillDetails');
				var checkbox = $('#ordbillsaveAddress');
				var formfields = FormField.GetValues(OrderCustomFormFieldsBillingFormId);
			}
			else {
				var parent = $('#ordshipDetails');
				var checkbox = $('#ordshipsaveAddress');
				var formfields = FormField.GetValues(OrderCustomFormFieldsShippingFormId);
			}

			var required = ['FirstName','LastName','Phone','AddressLine1','City','Country','Zip'];

			if ($(checkbox).attr('checked')) {
				var requireFlag = true;
			} else {
				var requireFlag = false;
			}

			for (var i=0; i<formfields.length; i++) {
				var requireIt = false;

				for (var j=0; j<required.length; j++) {
					if (formfields[i].privateId == '') {
						continue;
					}

					if (formfields[i].privateId == required[j]) {
						requireIt = true;
					}
				}

				if (formfields[i].privateId == '') {
					continue;
				}

				if (requireIt) {
					FormField.SetRequired(formfields[i].field, requireFlag);
				} else {
					FormField.SetRequired(formfields[i].field, false);
				}
			}
		}
		SaveAddressToggle('bill');
		SaveAddressToggle('ship');

		$('#ordbillsaveAddress').click(function() {
			SaveAddressToggle('bill');
		});
		$('#ordshipsaveAddress').click(function() {
			SaveAddressToggle('ship');
		});
		function SyncShipping() {
			if($('#shippingUseBilling').attr('checked')) {
				OrderManager.SyncAddressFields('ordbill');
				var disabled = true;
			}
			else {
				var disabled = false;
			}

			var formfields = FormField.GetValues(OrderCustomFormFieldsShippingFormId);
			for (var i=0; i<formfields.length; i++) {
				FormField.SetDisabled(formfields[i].field, disabled);
			}
		}
		SyncShipping();
		$('#shippingUseBilling').click(SyncShipping);
		function SyncBilling() {
			if($('#billingUseShipping').attr('checked')) {
				OrderManager.SyncAddressFields('ordship');
				var disabled = true;
			}
			else {
				var disabled = false;
			}

			var formfields = FormField.GetValues(OrderCustomFormFieldsBillingFormId);
			for (var i=0; i<formfields.length; i++) {
				FormField.SetDisabled(formfields[i].field, disabled);
			}
		}
		SyncBilling();
		$('#billingUseShipping').click(SyncBilling);
	},

	InitCustomerSearch: function()
	{
		//$('#custSearchBox').keypress(function(event) {
		$('#custSearchBox').keydown(function(event) {
			function ScrollInToView(activeItem)
			{
				activeItem = activeItem.get(0);
				searchBox = $(activeItem).parents('#custSearchResults .SearchBoxRecord').get(0);
				if(activeItem.offsetTop+activeItem.offsetHeight > searchBox.scrollTop+searchBox.offsetHeight
					|| activeItem.offsetTop > (searchBox.scrollTop + searchBox.offsetHeight)) {
					searchBox.scrollTop = (activeItem.offsetTop+activeItem.offsetHeight) - searchBox.offsetHeight;
				}
				else if((activeItem.offsetTop+activeItem.offsetHeight) < searchBox.scrollTop || activeItem.offsetTop < searchBox.scrollTop) {
					searchBox.scrollTop = activeItem.offsetTop;
				}
			}

			if($('#custSearchResults').html()) {
				var searchBox = $('#custSearchResults');
				switch(event.keyCode) {
					case 27: // Escape
						searchBox.hide();
						searchBox.find('.SearchBoxRecordSelected').removeClass('SearchBoxRecordSelected');
						return;
					case 40: // Down
						event.preventDefault();
						if(searchBox.html() != '') {
							if(!searchBox.find('.SearchBoxRecordSelected').length) {
								searchBox.find('.SearchBoxRecord:first').addClass('SearchBoxRecordSelected');
							}
							else if(searchBox.find('.SearchBoxRecordSelected').next().length) {
								ScrollInToView(searchBox.find('.SearchBoxRecordSelected')
									.removeClass('SearchBoxRecordSelected')
									.next()
									.addClass('SearchBoxRecordSelected')
								);
							}
						}
						return;
					case 38: // Up
						event.preventDefault();
						if(searchBox.html() != '') {
							if(searchBox.find('.SearchBoxRecordSelected').prev().length) {
								ScrollInToView(searchBox.find('.SearchBoxRecordSelected')
									.removeClass('SearchBoxRecordSelected')
									.prev()
									.addClass('SearchBoxRecordSelected')
								);
							}
						}
						return;
					case 9: // Tab
					case 13: // Enter
						event.preventDefault();
						OrderManager.stopSubmit = true;
						searchBox.find('.SearchBoxRecordSelected').click();
						searchBox.find('.SearchBoxRecordSelected').removeClass('SearchBoxRecordSelected');
						return;
				}
			}

			if($(this).data('timeout')) {
				clearTimeout($(this).data('timeout'));
			}
			element = this;
			if(!$(this).data('hasEvents')) {
				$(this)
					.blur(function() {
						resultsBox = $('#custSearchResults');
						if(!resultsBox.data('mousedown')) {
							$(resultsBox).hide();
							resultsBox.find('.SearchBoxRecordSelected').removeClass('SearchBoxRecordSelected');
						}
					})
					.focus(function() {
						var itemRow = $(this).parents('.orderItem');
						if($('#custSearchResults').html() != '') {
							$('#custSearchResults')
								.css({
									width: $(element).width()+'px'
								})
								.show();
						}
					})
					.click(function(e) {
						resultsBox = $('#custSearchResults');
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
			$(this).data('timeout', setTimeout(function() {
				if($.trim($(element).val()).length < 3) {
					$('#custSearchResults').remove();
					return;
				}

				// Value hasn't changed so don't do anything
				if($(element).val() == $(element).data('lastValue')) {
					return;
				}

				$(element).data('lastValue', $(element).val());

				// Show the loading icon
				$('#custSearchIcon').show();
				$('#custSearchResults').remove();

				// Search for the products and load them up
				$.ajax({
					url: 'remote.php?w=orderSearchCustomers&remoteSection=orders',
					data: {
						searchQuery: $(element).val()
					},
					success: function(data) {
						// Hide the loading indicator
						$('#custSearchIcon').hide();

						// Build and position the results box
						$('<div>')
							.attr('id', 'custSearchResults')
							.addClass('IconSearchBox')
							.html('<ul>'+data+'</ul>')
							.css({
								position: 'absolute',
								top: $(element).offset().top+$(element).height()+6,
								left: $(element).offset().left+2,
								width: $(element).width()
							})
							.appendTo($('#custSearchBox').parent())
							.mousedown(function() {
								$(this).data('mousedown', true);
							})
							.mouseup(function() {
								$(this).data('mouseup', false);
							})
							.show()
						;

						// Event to fire when the "Order History" link is clicked
						$('.SearchResultOrderHistoryLink').click(function(e) {
							e.preventDefault();
							e.stopPropagation();
							window.open($(this).attr('href'));
						});

						// Event to fire when a selection is made
						//$('#custSearchResults .SearchBoxRecord')
						
						$('.SearchBoxRecord')
							.click(function() {
								customerId = $('.CustomerId', this).val();
								$('#custResultBox')
									.html('<ul><li class="SearchBoxRecord">'+$(this).html()+'</li></ul>')
									.show()
								;

								$('#custResultBox .History').hide();
								$('#custResultBox .ChangeCustomerLink').show();
								$('#custSearchBox').val('');
								$('#custSearchRow').hide();
								$('#custResultRow').show();
								$('#custSearchResults').html('');
								OrderManager.ToggleExistingCustomer(customerId);
							});

							$('.SearchBoxRecord')
							.hover(function() {
								$(this).siblings('.SearchBoxRecordSelected').removeClass('SearchBoxRecordSelected');
								$(this).addClass('SearchBoxRecordSelected');
							}, function() {
								$(this).removeClass('SearchBoxRecordSelected');
							});
					}
				});
			}, 300));
		});

		$('#custSearchBox').click(function(e) {
			e.preventDefault();
			e.stopPropagation();
			$('#custSearchRow .IconSearchBox').scrollTop = 0;

			if($('#custSearchResults').html() != '') {
				$('#custSearchRow .IconSearchBox').show();
			}
		});
	},

	RemoveSelectedCustomer: function()
	{
		$('#custResultRow').hide();
		$('#custSearchRow').show();
		$('#YMMDetailsList').html('');
		$('#YMMDetailsList').hide();
		$('#custSearchBox').focus()
		OrderManager.ToggleExistingCustomer(0);
	},

	//ProductSearch: function(element, event)  Original code Altered by Mayank Jaitly for SKU searching
	ProductSearch: function(element, event,type)
	{

		var itemRow = $(element).parents('.orderItem');

		function ScrollInToView(activeItem)
		{
			activeItem = activeItem.get(0);
			searchBox = $(activeItem).parents('.ProductSearchResults').get(0);
			if(activeItem.offsetTop+activeItem.offsetHeight > searchBox.scrollTop+searchBox.offsetHeight
				|| activeItem.offsetTop > (searchBox.scrollTop + searchBox.offsetHeight)) {
				searchBox.scrollTop = (activeItem.offsetTop+activeItem.offsetHeight) - searchBox.offsetHeight;
			}
			else if((activeItem.offsetTop+activeItem.offsetHeight) < searchBox.scrollTop || activeItem.offsetTop < searchBox.scrollTop) {
				searchBox.scrollTop = activeItem.offsetTop;
			}
		}

		if($('.ProductSearchResults').html()) {
			var searchBox = $('.ProductSearchResults', itemRow);
			switch(event.keyCode) {
				case 27: // Escape
					searchBox.hide();
					searchBox.find('.SearchBoxRecordSelected').removeClass('SearchBoxRecordSelected');
					return;
				case 40: // Down
					event.preventDefault();
					if(searchBox.html() != '') {
						if(!searchBox.find('.SearchBoxRecordSelected').length) {
							searchBox.find('.SearchBoxRecord:first').addClass('SearchBoxRecordSelected');
						}
						else if(searchBox.find('.SearchBoxRecordSelected').next().length) {
							ScrollInToView(searchBox.find('.SearchBoxRecordSelected')
								.removeClass('SearchBoxRecordSelected')
								.next()
								.addClass('SearchBoxRecordSelected')
							);
						}
					}
					return;
				case 38: // Up
					event.preventDefault();
					if(searchBox.html() != '') {
						if(searchBox.find('.SearchBoxRecordSelected').prev().length) {
							ScrollInToView(searchBox.find('.SearchBoxRecordSelected')
								.removeClass('SearchBoxRecordSelected')
								.prev()
								.addClass('SearchBoxRecordSelected')
							);
						}
					}
					return;
				case 9: // Tab
				case 13: // Enter
					event.preventDefault();
					OrderManager.stopSubmit = true;
					searchBox.find('.SearchBoxRecordSelected').click();
					searchBox.find('.SearchBoxRecordSelected').removeClass('SearchBoxRecordSelected');
					return;
			}
		}

		if($(element).data('timeout')) {
			clearTimeout($(element).data('timeout'));
		}

		if(!$(element).data('hasEvents')) {
			$(element)
				.blur(function() {
					var itemRow = $(this).parents('.orderItem');
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
					// 2011-08-23 johnny modify
					var itemRow = $(this).parent('div');
					if($('.ProductSearchResults', itemRow).html() != '') {
						$('.ProductSearchResults', itemRow)
							.css({
								width: $(element).width()+'px'
							})
							.show();
					}
				})
				.click(function(e) {
					// 2011-08-23 johnny modify
					var itemRow = $(this).parent('div');
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
			
			/*********************************************************************************
				Code altered by Mayank Jaitly on 15 July 2010
				Original code is within comment. remove next if else to revert back
				if($.trim($(element).val()).length < 4) {
					$('.ProductSearchResults', itemRow).remove();
					return;
				}
				
			**********************************************************************************/
			if(type==1) {
				if($.trim($(element).val()).length < 4) {
					$('.ProductSearchResults', itemRow).remove();
					return;
				}
			}
			if(type==2) {
				if($.trim($(element).val()).length < 2) {
					$('.ProductSearchResults', itemRow).remove();
					return;
				}
			}
			/// 	End of alteration
			// Value hasn't changed so don't do anything
			if($(element).val() == $(element).data('lastValue')) {
				return;
			}

			$(element).data('lastValue', $(element).val());

			// Show the loading icon
			$('.ProductNameLoading', itemRow).show();
			$('.ProductSearchResults').remove();
					
					if($('#WhichToPick').val()==1) {
					if($("input[name='ymmID']:checked").val()!=-1) {
						ymmyearval= 0;
						ymmmakeval= 0;
						ymmmodelval= 0;
						ymmIDval=$("input[name='ymmID']:checked").val();
						ymmbedsizeval = "";
						ymmcabsizeval = "";
						actionToperform='PickFromID';
						
						
					}
					else {
						ymmyearval= $('#searchyear').val();
						ymmmakeval= $('#searchmake').val();
						ymmmodelval= $('#searchmodel').val();
						ymmbedsizeval = $('#bedsize').val();
						ymmcabsizeval = $('#cabsize').val();
						ymmIDval=0;
						actionToperform='PickFromDD';
					}
			}
			else {
					ymmyearval= $('#searchyear').val();
					ymmmakeval= $('#searchmake').val();
					ymmmodelval= $('#searchmodel').val();
					ymmbedsizeval = $('#bedsize').val();
					ymmcabsizeval = $('#cabsize').val();
					ymmIDval=0;
					actionToperform='PickFromDD';
			}

			// Search for the products and load them up
			$.ajax({
				//url: 'remote.php?w=orderSearchProducts&remoteSection=orders', Original code Altered by Mayank Jaitly for SKU searching
				url: 'remote.php?ajaxsearchtype='+type+'&w=orderSearchProducts&remoteSection=orders',
				data: $.extend({
					searchQuery: $(element).val(),
					ymmyear: ymmyearval,
					ymmmake: ymmmakeval,
					ymmmodel: ymmmodelval,
					ymmbedsize: ymmbedsizeval,
					ymmcabsize: ymmcabsizeval,
					ymmID : ymmIDval
					
				}, OrderManager.GetBaseOrderFields()),
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
					//$('.SearchBoxRecord', itemRow)
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
							var itemRow = $(element).parents('.orderItem');
							OrderManager.AddItemToOrder($(itemRow).attr('id').replace('orderItem_', ''), product);
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
	},

	ToggleExistingCustomer: function(customerId)
	{
		if(customerId == -1) {
			$('#ordshipsaveAddress, #ordbillsaveAddress').attr('disabled', true);
		}
		else {
			$('#ordshipsaveAddress, #ordbillsaveAddress').attr('disabled', false);
		}

		$('#customerId').val(customerId);
		OrderManager.customerAddresses = new Array();
		if(customerId == 0 || customerId == -1) {
			$('#custResultRow').hide();
			$('#custSearchRow').show();
			$('.ShowIfHasAddresses').hide();
			if(customerId == -1) {
				$('#customerId').val(0);
				$('#customerType').val('anonymous');
			}
			else {
				$('#customerType').val('new');
			}
		}
		// Load in the addresses for this customer
		else {
			billingIndicator = LoadingIndicator.Show({background: '#fff', parent: '#ordbillDetails'});
			shippingIndicator = LoadingIndicator.Show({background: '#fff', parent: '#ordshipDetails'});

			$('#customerType').val('existing');

			$.ajax({
				url: 'remote.php?remoteSection=orders&w=orderLoadCustomerAddresses&customerId='+customerId,
				dataType: 'json',
				success: function(data) {
					LoadingIndicator.Destroy(billingIndicator);
					LoadingIndicator.Destroy(shippingIndicator);

					OrderManager.LoadInAddresses(data);
				}
			});
			
			/*******************************************
				Alter By Mayank Jaitly : 28 June
			/*******************************************/
				$.ajax({
				url: 'remote.php?remoteSection=orders&w=orderLoadCustomerYMM&customerId='+customerId,
				success: function(data) {
					OrderManager.LoadInYMM(data);
				}
			});
			/*******************************************/
			
			
		}
	},

	LoadInAddresses: function(data) {
		// Remove the existing options from the select
		$('#existingBillingAddress option:gt(0), #existingShippingAddress option:gt(0)').remove();

		if(data.length == 0) {
			$('.ShowIfHasAddresses').hide();
			return;
		}

		$(data).each(function() {
			OrderManager.customerAddresses[this.shipid] = this;
			addressOption = $('<option>')
				.val(this.shipid)
				.html(this.preview)
			;
			$('#existingBillingAddress').append(addressOption);
			$('#existingShippingAddress').append(addressOption.clone());
		});
		$('#existingBillingAddress, #existingShippingAddress').attr('disabled', false);
		$('.ShowIfHasAddresses').show();
	},
	
	LoadInYMM: function(data) {
		//alert('afasdfasd');
		document.getElementById('YMMDetailsList').innerHTML=data;
	},

	SyncAddressFields: function(fromField)
	{
		if (fromField == 'ordbill') {
			var formfields = FormField.GetValues(OrderCustomFormFieldsBillingFormId);
		} else {
			var formfields = FormField.GetValues(OrderCustomFormFieldsShippingFormId);
		}

		for (var i=0; i<formfields.length; i++) {
			var args = {
				'data': {
					'fieldId': formfields[i].fieldId
				}
			};

			OrderManager.BindAddressSyncEventsCallback(args);
		}

		OrderManager.BindAddressSyncEvents();
	},

	UseExistingAddress: function(type, addressId)
	{
		if(addressId > 0) {
			address = OrderManager.customerAddresses[addressId];
		}
		else {
			address = {};
		}
		OrderManager.FillExistingAddress(type, address);

		if((type == 'ordbill' && $('#shippingUseBilling:checked').val()) || (type == 'ordship' && $('#billingUseShipping:checked').val())) {
			OrderManager.SyncAddressFields(type);
		}
	},

	FillExistingAddress: function(type, addressFields)
	{
		var privateId, formId, formfields, state, stateFieldId, countryFieldId;

		if (addressFields['shipid'] == undefined) {
			return;
		}

		if (type == 'ordbill') {
			formId = OrderCustomFormFieldsBillingFormId;
		} else {
			formId = OrderCustomFormFieldsShippingFormId;
		}

		formfields = FormField.GetValues(formId);

		for (var i=0; i<formfields.length; i++) {

			/**
			 * Pick up the non-private formfields here
			 */
			if (formfields[i].privateId == '') {
				var fieldId = formfields[i].fieldId;

				if (addressFields.shipcustomfields !== undefined && addressFields.shipcustomfields[fieldId] !== undefined) {
					FormField.SetValue(formfields[i].field, addressFields.shipcustomfields[fieldId]);
				}

				continue;
			}

			/**
			 * Fix up the field names as some do not match
			 */
			privateId = formfields[i].privateId.toLowerCase();
			if (privateId == 'addressline1') {
				privateId = 'address1';
			} else if (privateId == 'addressline2') {
				privateId = 'address2';
			} else if (privateId == 'companyname') {
				privateId = 'company';
			}

			privateId = 'ship' + privateId;

			/**
			 * Special case for 'state'. We'll do it later as we need the country first
			 */
			if (privateId == 'shipstate') {
				stateFieldId = formfields[i].fieldId;
				state = addressFields[privateId];
				continue;
			} else if (addressFields[privateId] == undefined) {
				continue;
			}

			FormField.SetValue(formfields[i].field, addressFields[privateId]);

			/**
			 * Pick up the country if this is it
			 */
			if (privateId == 'shipcountry') {
				countryFieldId = formfields[i].fieldId;
			}
		}

		/**
		 * Now assign the states
		 */
		if (countryFieldId > 0 && stateFieldId > 0) {
			var args = {
				'data': {
					'countryId': countryFieldId,
					'stateId': stateFieldId,
					'selectedState': state
				}
			};

			FormFieldEvent.SingleSelectPopulateStates(args);
		}
	},

	RemoveItem: function(element) {
		if(!confirm(lang.ConfirmRemoveProductFromOrder)) {
			return false;
		}
		var itemRow = $(element).parents('.orderItem');
		rowId = itemRow.attr('id').replace('orderItem_', '');
		indicator = LoadingIndicator.Show({background: '#fff', parent: '#orderItemsTable'});
		$.ajax({
			url: 'remote.php?remoteSection=orders&w=orderRemoveProduct',
			data: $.extend({
				cartItemId: rowId,
				orderSession: OrderManager.sessionId
			}, OrderManager.GetBaseOrderFields()),
			dataType: 'json',
			success: function(data) {
				$(itemRow).remove();
				if($('.orderItem').length == 1) {
					OrderManager.AddNewItem(element);
				}
				OrderManager.UpdateOrderTable(data);
				LoadingIndicator.Destroy(indicator);
			}
		});
	},

	AddNewItem: function(element)
	{
		var itemRow = $('#orderItem_rowtemplate');
		var newRow = $(itemRow).clone(true);
		$(newRow).find('input,select').val('');
		$(newRow).find('input.ProductId, input.VariationId').val('0');
		$(newRow).find('input.Quantity').val(1);
		$(newRow).find('input.ItemPrice').val('0.00');
		$(newRow).find('.ItemTotal').html('0.00');
		$('.ConfigurableFields, .GiftWrappingOptions, .VariationList', newRow).html('').hide();
		$('.AddWrappingLink', newRow).show();
		$(newRow).appendTo($(itemRow).parents('#orderItemsTable'));
		rowId = $(newRow).get(0).rowIndex;
		$(newRow).attr('id', 'orderItem_new'+rowId);
		// Update the names of the input/select fields
		newName = 'cartItem[new'+rowId+']';
		$(newRow).find('input, select, textarea').each(function() {
			$(this).attr('name', $(this).attr('name').replace(/cartItem\[[a-zA-Z0-9\_-]+\]/g, newName));
		});
		$(newRow).find('.InsertTip').hide();
		$(newRow).show();
		OrderManager.AddOrderItemEvents(newRow);
		$(newRow).find('.ProductName').focus();
	},

	AddOrderItemEvents: function(parent) {
		$(parent).find('input.ProductCode, input.ProductName, input.Quantity, input.ItemPrice')
			.focus(function() {
				$(this).data('previousVal', $(this).val())
			})
			.blur(function() {
				if($(this).val() != $(this).data('previousVal')) {
					OrderManager.contentChanged = true;
				}
				$(this).data('previousVal', null);
			})
		;
	},

	ShowProductSelector: function(element) {
		itemRow = $(element).parents('.orderItem');

		var l = (screen.availWidth/2) - (700/2) + 50;
		var t = (screen.availHeight/2) - (490/2) + 50;
		var width = 700;

		windowLocation = 'index.php?ToDo=popupProductSelect';
		windowLocation += '&selectCallback=OrderManager.OrderProductSelectCallback';
		windowLocation += '&getSelectedCallback=OrderManager.OrderProductSelectGetSelected';
		windowLocation += '&closeCallback=OrderManager.OrderProductSelectCloseCallback';
		windowLocation += '&ProductList='+itemRow.attr('id').replace('orderItem_', '');
		windowLocation += '&ProductSelect='+itemRow.attr('id').replace('orderItem_', '');
		windowLocation += '&single=1';
		windowLocation += '&FocusOnClose=';
		var w = window.open(windowLocation, 'productSelect'+itemRow.attr('id').replace('orderItem_', '')+'typesingle', "width="+width+",height=490,left="+l+",top="+t);
		w.focus();
		return false;
	},

	OrderProductSelectCloseCallback: function(rowId)
	{
		if(OrderManager.selectedProduct[rowId] == undefined) {
			return;
		}

		selectedProduct = OrderManager.selectedProduct[rowId];
		OrderManager.AddItemToOrder(rowId, selectedProduct);
	},

	AddItemToOrder: function(rowId, product)
	{
		itemRow = $('#orderItem_'+rowId);
		quantity = $(itemRow).find('input.Quantity').val();
		if(product.id == $(itemRow).find('input.ProductId').val() && product.name == $(itemRow).find('.ProductName').val()) {
			return;
		}
		if(quantity < 1) {
			quantity = 1;
		}
		if(product.isConfigurable == 1) {
			$.iModal({
				type: 'ajax',
				url: 'remote.php?remoteSection=orders&w=orderConfigureProduct',
				urlData: $.extend({
					cartItemId: rowId,
					productId: product.id,
					orderSession: OrderManager.sessionId,
					quantity: quantity
				}, OrderManager.GetBaseOrderFields()),
				width: 600,
				height: 400
			});
		}
		else {
			/***************************************************************************
				Code altered by Mayank Jaitly on 05 July 2010
				The original code is with in comment..
				
				
				indicator = LoadingIndicator.Show({background: '#fff', parent: '#orderItemsTable'});
			$.ajax({
				url: 'remote.php?remoteSection=orders&w=orderAddNewProduct',
				data: $.extend({
					cartItemId: rowId,
					productId: product.id,
					orderSession: OrderManager.sessionId,
					quantity: quantity,
					ymmyear: $('#searchyear').val(),
					ymmmake: $('#searchmake').val(),
					ymmmodel: $('#searchmodel').val(),
					WhatToDo: 'AddProductAdmin'
				}, OrderManager.GetBaseOrderFields()),
			/*************************************************************************/
			
			
					if($('#WhichToPick').val()==1) {
					if($("input[name='ymmID']:checked").val()!=-1) {
						ymmyearval= 0;
						ymmmakeval= 0;
						ymmmodelval= 0;
						bedsizeval='';
						cabsizeval=0;
						ymmIDval=$("input[name='ymmID']:checked").val();
						actionToperform='PickFromID';
						
						
					}
					else {
						ymmyearval= $('#searchyear').val();
						ymmmakeval= $('#searchmake').val();
						ymmmodelval= $('#searchmodel').val();
						bedsizeval=$('#bedsize').val();
						cabsizeval=$('#cabsize').val();
						ymmIDval=0;
						actionToperform='PickFromDD';
					}
			}
			else {
					ymmyearval= $('#searchyear').val();
					ymmmakeval= $('#searchmake').val();
					ymmmodelval= $('#searchmodel').val();
					bedsizeval=$('#bedsize').val();
					cabsizeval=$('#cabsize').val();
					ymmIDval=0;
					actionToperform='PickFromDD';
			}
			
			
			
			indicator = LoadingIndicator.Show({background: '#fff', parent: '#orderItemsTable'});
			$.ajax({
				url: 'remote.php?remoteSection=orders&w=orderAddNewProduct',
				data: $.extend({
					cartItemId: rowId,
					productId: product.id,
					orderSession: OrderManager.sessionId,
					quantity: quantity,
					ymmyear: ymmyearval,
					ymmmake: ymmmakeval,
					ymmmodel: ymmmodelval,
					bedsizeint: bedsizeval,
					cabsize: cabsizeval,
					ymmID: ymmIDval,
					actionToperform : actionToperform,
					WhatToDo: 'AddProductAdmin'
				}, OrderManager.GetBaseOrderFields()),
				dataType: 'json',
				success: function(data) {
					if(data.error != undefined) {
						alert(data.error);
					}

					if(data.productRow) {
						$('#orderItem_'+data.productRowId).replaceWith(data.productRow);
						OrderManager.AddOrderItemEvents($('#orderItem_'+data.productRowId));
					}
					if(data.removeRow) {
						$('#orderItem_'+data.removeRow).remove();
					}

					OrderManager.UpdateOrderTable(data);
					LoadingIndicator.Destroy(indicator);
				}
			});
		}
	},

	SerializeObject: function(parentElement)
	{
		return $.param($(parentElement)
			.find('input, select, textarea')
			.filter(function(){
				return this.name && !this.disabled &&
					(this.checked || /select|textarea/i.test(this.nodeName) ||
						/text|hidden|password/i.test(this.type));
			})
			.map(function(i, elem){
				var val = $(this).val();
				return val == null ? null :
					val.constructor == Array ?
						jQuery.map( val, function(val, i){
							return {name: elem.name, value: val};
						}) :
						{name: elem.name, value: val};
			}).get()
		);
	},

	UpdateOrderTotals: function()
	{
		var orderData = OrderManager.SerializeObject('#orderTable');
		indicator = LoadingIndicator.Show({background: '#fff', parent: '#orderItemsTable'});
		$.ajax({
			url: 'remote.php?remoteSection=orders&w=orderUpdateTotals',
			data: orderData+'&'+$.param(OrderManager.GetBaseOrderFields()),
			type: 'post',
			dataType: 'json',
			success: function(data) {
				// 2011-08-22 johnny modify
				if(data.error != undefined) {
					alert(data.error);
				}else{
					OrderManager.UpdateOrderTable(data);
					OrderManager.contentChanged = false;
				}
				LoadingIndicator.Destroy(indicator);
			}
		});
	},

	UpdateOrderTable: function(data)
	{
		if(data.orderTable != undefined) {
			$('#orderItemsTable').html(data.orderTable);
			OrderManager.AddOrderItemEvents($('#orderItemsTable'));
		}

		$('.InsertTip:gt(0)').hide();

		if(data.orderSummary != undefined) {
			$('#orderSummaryTable').html(data.orderSummary);
		}

		if(data.paymentMethods != undefined) {
			$('#PaymentMethodList').html(data.paymentMethods);
		}
	},

	OrderProductSelectCallback: function(rowId, rowIdUnused, product)
	{
		OrderManager.selectedProduct[rowId] = product;
	},

	OrderProductSelectGetSelected: function(rowId)
	{
		return $('#orderItem_'+rowId).find('.ProductId').val();
	},

	ManageGiftWrapping: function(itemId)
	{
		$.iModal({
			type: 'ajax',
			url: 'remote.php?remoteSection=orders&w=orderSelectGiftWrap&itemId='+itemId+'&orderSession='+OrderManager.sessionId
		});
	},

	ApplyGiftWrapping: function()
	{
		indicator = LoadingIndicator.Show({background: '#fff', parent: '#orderTable'});
		var wrappingForm = $('#GiftWrappingForm').serialize();
		$.modal.close();
		$.ajax({
			url: 'remote.php?remoteSection=orders&w=orderSaveGiftWrap',
			type: 'post',
			dataType: 'json',
			data: wrappingForm+'&'+$.param(OrderManager.GetBaseOrderFields()),
			success: function(data) {
				if(data.error) {
					alert(data.error);
				}
				if(data.productRow) {
					$('#orderItem_'+data.productRowId).replaceWith(data.productRow);
					OrderManager.AddOrderItemEvents($('#orderItem_'+data.productRowId));
				}
				OrderManager.UpdateOrderTable(data);
				LoadingIndicator.Destroy(indicator);

			}
		});
	},

	ToggleGiftWrappingType: function(option)
	{
		if($(option).hasClass('HasPreview')) {
			$('.GiftWrappingPreviewLinks').hide();
			$('#GiftWrappingPreviewLink'+$(option).val()).show();
		}
		else {
			$('.GiftWrappingPreviewLinks').hide();
		}

		if($(option).hasClass('AllowComments')) {
			$(option).parents('.WrappingOption').find('.WrapComments').show();
		}
		else {
			$(option).parents('.WrappingOption').find('.WrapComments').hide();
		}
	},

	ToggleMultiWrapping: function(value)
	{
		if(value == 'same') {
			$('.WrappingOptionsSingle').show();
			$('.WrappingOptionsMultiple').hide();
		}
		else {
			$('.WrappingOptionsSingle').hide();
			$('.WrappingOptionsMultiple').show();
		}
	},

	RemoveGiftWrapping: function(itemId)
	{
		indicator = LoadingIndicator.Show({background: '#fff', parent: '#orderTable'});
		$.modal.close();
		$.ajax({
			url: 'remote.php?remoteSection=orders&w=orderRemoveGiftWrap',
			type: 'post',
			data: $.extend({
				itemId: itemId
			}, OrderManager.GetBaseOrderFields()),
			dataType: 'json',
			success: function(data) {
				if(data.productRow) {
					$('#orderItem_'+data.productRowId).replaceWith(data.productRow);
					OrderManager.AddOrderItemEvents($('#orderItem_'+data.productRowId));
				}
				OrderManager.UpdateOrderTable(data);
				LoadingIndicator.Destroy(indicator);
			}
		});
	},

	GetBaseOrderFields: function()
	{
		var formfields = [];
		var orderDetails = 	{
			orderSession: OrderManager.sessionId
		};

		formfields = formfields.concat(FormField.GetValues(OrderCustomFormFieldsBillingFormId));
		formfields = formfields.concat(FormField.GetValues(OrderCustomFormFieldsShippingFormId));

		for (var i=0; i<formfields.length; i++) {
			if (formfields[i].privateId == '') {
				continue;
			}

			var type = formfields[i].privateId.toLowerCase();
			var label = '';

			if (type !== 'zip' && type !== 'state' && type !== 'country') {
				continue;
			}

			if (formfields[i].formId == OrderCustomFormFieldsBillingFormId) {
				label = 'ordbill' + type;
			} else {
				label = 'ordship' + type;
			}

			orderDetails[label] = formfields[i].value;
		}

		if($('#customerId').val() == 0) {
			orderDetails.custgroupid = $('#custgroupid').val();
		}
		else {
			orderDetails.ordcustid = $('#customerId').val();
		}
		return orderDetails;
	},

	ConfigureProduct: function(itemId)
	{
		itemRow = $('#orderItem_'+itemId);
		quantity = $(itemRow).find('input.Quantity').val();
		$.iModal({
			type: 'ajax',
			url: 'remote.php?remoteSection=orders&w=orderConfigureProduct',
			urlData: $.extend({
				cartItemId: itemId,
				orderSession: OrderManager.sessionId,
				quantity: quantity
			}, OrderManager.GetBaseOrderFields()),
			width: 500
		});
	},

	RemoveGiftCertificate: function(giftCertificateId)
	{
		indicator = LoadingIndicator.Show({background: '#fff', parent: '#orderTable'});
		//$.modal.close();
		$.ajax({
			url: 'remote.php?remoteSection=orders&w=orderRemoveGiftCertificate',
			data: $.extend({
				giftCertificateId: giftCertificateId
			}, OrderManager.GetBaseOrderFields()),
			dataType: 'json',
			success: function(data)
			{
				OrderManager.UpdateOrderTable(data);
				LoadingIndicator.Destroy(indicator);
			}
		});
	},
    RemoveCompanyGiftCertificate: function(giftCertificateId)
	{
		indicator = LoadingIndicator.Show({background: '#fff', parent: '#orderTable'});
		//$.modal.close();
		$.ajax({
			url: 'remote.php?remoteSection=orders&w=orderRemoveCompanyGiftCertificate',
			data: $.extend({
				cgcId: giftCertificateId
			}, OrderManager.GetBaseOrderFields()),
			dataType: 'json',
			success: function(data)
			{
				OrderManager.UpdateOrderTable(data);
				LoadingIndicator.Destroy(indicator);
			}
		});
	},

	SaveProductConfiguration: function()
	{
		// If a variation is required, check that we have one
		if($('#ProductConfigurationWindow .ProductVariationRequired').val() == 1 && !$('#ProductConfigurationWindow .CartVariationId').val()) {
			alert(lang.ChooseVariationBeforeAdding);
			$('.ProductOptionList').find('select').focus();
			return false;
		}

		// Now check that any required product fields were also supplied
		valid = true;
		$('#ProductConfigurationWindow .ProductConfiguration .FieldRequired').each(function() {
			if($(this).is('[type=checkbox]') && !this.checked) {
				alert(lang.EnterProductRequiredFields);
				$(this).focus();
				valid = false;
				return false;
			}
			else if($(this).is('[type=file]') && !$(this).val() && (!$(this).is('.HasExistingValue') || $(this).parents('.ConfigurableField').find('.RemoveCheckbox:checked').val())) {
				alert(lang.EnterProductRequiredFields);
				$(this).focus();
				valid = false;
				return false;
			}
			else if(!$(this).val()) {
				alert(lang.EnterProductRequiredFields);
				$(this).focus();
				valid = false;
				return false;
			}
		});

		$('#ProductConfigurationWindow .ProductConfiguration input[type=file]').each(function() {
			if($(this).val()) {
				fileTypes = $(this).parents('.ConfigurableField').find('.FileTypes').html();
				ext = $(this).val().replace(/^.*\./, '').toLowerCase();
				if(fileTypes && fileTypes.toLowerCase().replace(' ', '').indexOf(ext) == -1) {
					alert(lang.ChooseValidProductFieldFile);
					$(this).focus();
					valid = false;
					return false;
				}
			}
		});

		if (!CheckEventDate()) {
			valid = false;
		}

		if(valid == false) {
			return false;
		}

		// Everything is valid on the client side so let's attempt to add this product to the cart.
		// This uses the jQuery Form Plugin as we need to potentially handle file uploads.
		if($('#ModalContainer .editingExisting').val() != 1) {
			remoteUrl = 'remote.php?remoteSection=orders&w=orderAddNewProduct';
			buttonLabel = lang.AddingProductToOrder;
		}
		else {
			remoteUrl = 'remote.php?remoteSection=orders&w=orderUpdateProductConfig';
			buttonLabel = lang.UpdatingProductInOrder;
		}

		remoteUrl += '&'+$.param(OrderManager.GetBaseOrderFields());

		$('#ModalContainer input.Submit')
			.data('oldVal', $('#ModalContainer input.Submit').val())
			.val(buttonLabel)
			.attr('disabled', true)
		;

		$('#ProductConfigurationWindow').ajaxSubmit({
			url: remoteUrl+'&ajaxFormUpload=1',
			type: 'post',
			iframe: true,
			dataType: 'json',
			success: function(data) {
				if(data.error) {
					alert(data.error);
					$('#ModalContainer input.Submit')
						.val($('#ModalContainer input.Submit').data('oldVal'))
						.attr('disabled', false)
					;
					return;
				}

				if(data.productRow) {
					$('#orderItem_'+data.productRowId).replaceWith(data.productRow);
					OrderManager.AddOrderItemEvents($('#orderItem_'+data.productRowId));
				}
				if(data.removeRow) {
					$('#orderItem_'+data.removeRow).remove();
				}

				OrderManager.UpdateOrderTable(data);

				$.modal.close();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				eval('var obj = ' + XMLHttpRequest.responseText);
				alert(obj);
			}

		});
	},

	SaveShippingMethod: function()
	{
		selectedMethod = $('#ShippingMethodForm input[name=shippingMethod]:checked').val();
		if(!selectedMethod || selectedMethod == undefined) {
			alert(lang.ErrorChooseShippingMethod);
			$('#ShippingMethodForm input[name=shippingMethod]:eq(0)').focus();
			return false;
		}

		if(selectedMethod == 'custom' && !$('#ShippingMethodForm input[name=customName]').val()) {
			alert(lang.ErrorEnterShippingMethodName);
			$('#ShippingMethodForm input[name=customName]').focus();
			return false;
		}

		if(selectedMethod == 'custom' && isNaN(priceFormat($('#ShippingMethodForm input[name=customPrice]').val()))) {
			alert(lang.ErrorEnterShippingMethodPrice);
			$('#ShippingMethodForm input[name=customPrice]').focus().select();
			return false;
		}

		data = $('#ShippingMethodForm').serialize()+'&'+$.param(OrderManager.GetBaseOrderFields());
		indicator = LoadingIndicator.Show({background: '#fff', parent: '#orderTable'});
		$.iModal.close();
		$.ajax({
			url: 'remote.php?remoteSection=orders&w=orderSaveShipping',
			type: 'post',
			data: data,
			dataType: 'json',
			success: function(data) {
				OrderManager.UpdateOrderTable(data);
				LoadingIndicator.Destroy(indicator);
			}
		});
	},

	ConfirmCancel: function()
	{
		if(confirm(lang.ConfirmCancel)) {
			window.location = 'index.php?ToDo=viewOrders';
		}
	},

	RemoveCouponCode: function(couponId)
	{
		indicator = LoadingIndicator.Show({background: '#fff', parent: '#orderTable'});
		$.ajax({
			url: 'remote.php?remoteSection=orders&w=orderRemoveCoupon',
			data: $.extend({
				couponCode: couponId,
				orderSession: OrderManager.sessionId
			}, OrderManager.GetBaseOrderFields()),
			dataType: 'json',
			success: function(data)
			{
				OrderManager.UpdateOrderTable(data);
				LoadingIndicator.Destroy(indicator);
			}
		});
	}
};