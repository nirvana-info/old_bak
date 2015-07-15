/*
 * Interspire Modal 1.0
 * (c) 2008 Interspire Pty. Ltd.
 *
 * Based on SimpleModal 1.1.1 - jQuery Plugin
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://plugins.jquery.com/project/SimpleModal
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2007 Eric Martin - http://ericmmartin.com
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * Revision: $Id$
 *
 */
(function ($) {
	$.iModal = function(options) {
		return $.iModal.modal.init(options);
	};

	$.modal = function() {
	};

	$.modal.close = function () {
		return $.iModal.modal.close(true);
	};

	$.iModal.close = function () {
		return $.iModal.modal.close(true);
	};

	$.fn.iModal = function (options) {
		options = $.extend({}, {
			type: 'inline',
			inline: $(this).html()
		}, options);
		return $.iModal.modal.init(options);
	};

	$.iModal.defaults = {
		overlay: 50,
		overlayCss: {},
		containerCss: {},
		close: true,
		closeTitle: 'Close',
		onOpen: null,
		onShow: null,
		onClose: null,
		onBeforeClose: null,
		type: 'string',
		width: '630',
		buttons: '',
		title: '',
		//zcs=>
		imgShow: null,
		closeCss: {}
		//<=zcs
	};

	$.iModal.modal = {
		options: null,
		init: function(options) {
			// Can\'t have more than one modal window open at a time
			if($('#ModalContentContainer').length > 0) {
				return this;
			}
			this.options = $.extend({}, $.iModal.defaults, options);

			if(this.options.type == 'inline') {
				this.options.data = $(this.options.inline).html();
				$(this.options.inline).html('');
			}

			this.generateModal();
			return this;
		},

		displayModal: function(data)
		{
			this.hideLoader();
			modalContent = '';
			//zcs=>
			var flagScroll = false;
			var winWidth = $(window).width();
			var winHeight = $(window).height();
			var modalContentStyle = '';
			if(this.options.imgShow){
				var fixedWidth = winWidth * 0.7;
				var fixedHeight = winHeight * 0.8;
				if(this.options.imgShow.imgWidth > fixedWidth){
					modalContentStyle += 'width:' + fixedWidth + 'px;';
					this.options.imgShow.imgWidth = fixedWidth;
					flagScroll = true;
				}
				if(this.options.imgShow.imgHeight > fixedHeight){
					modalContentStyle += 'height:' + fixedHeight + 'px;';
					this.options.imgShow.imgHeight = fixedHeight;
					flagScroll = true;
				}
				if(flagScroll){
					modalContentStyle += 'overflow:scroll;';
				}
			}
			//<=zcs
			if((!$.browser.msie || $.browser.version >= 7) && !flagScroll) {//zcs= add (when not scroll,then show shadow)
				modalContent = '<div id="ModalTopLeftCorner"></div><div id="ModalTopBorder"></div><div id="ModalTopRightCorner"></div><div id="ModalLeftBorder"></div><div id="ModalRightBorder"></div><div id="ModalBottomLeftCorner"></div><div id="ModalBottomRightCorner"></div><div id="ModalBottomBorder"></div>';
			}
			//zcs= add "this.options.imgShow ||"
			if(this.options.imgShow || (data.indexOf('ModalTitle')>0 && data.indexOf('ModalContent')>0)){
				modalContent += '<div id="ModalContentContainer" style="' + modalContentStyle + '">'+data+'</div>';
			}else{
				modalContent += '<div id="ModalContentContainer" style="' + modalContentStyle + '"><div class="ModalTitle">'+this.options.title+'</div><div class="ModalContent">'+data+ '</div><div class="ModalButtonRow">'+this.options.buttons+'</div></div>';
			}

			cssPosition = 'fixed';
			if($.browser.msie && $.browser.version < 7) {
				cssPosition = 'absolute';
			}
			//zcs=>
			var tmpCss = {
				position: cssPosition,
				zIndex: 3100
			};
			if(this.options.width != null){
				tmpCss.width = this.options.width + 'px';
			}
			if(this.options.imgShow){
				tmpCss.top = (winHeight - this.options.imgShow.imgHeight) /2 + 'px';
				tmpCss.left = (winWidth - this.options.imgShow.imgWidth) /2 + 'px';
			}else{
				tmpCss.marginLeft = '-'+(this.options.width/2)+'px';
			}
			//<=zcs
			$('<div/>')
				.attr('id', 'ModalContainer')
				.addClass('modalContainer')
				.css(tmpCss)//zcs=
				.hide()
				.appendTo('body')
				.html('<div class="modalData">'+modalContent+'</div>')
			;
			if($('#ModalContainer').find('.ModalButtonRow, #ModalButtonRow').length > 0) {
				$('#ModalContainer .ModalContent, #ModalContainer #ModalContent').addClass('ModalContentWithButtons');
			}
			if(this.options.close) {
				modal = this;
				$('<a/>')
					.addClass('modalClose')
					.css(this.options.closeCss)//zcs=add css
					.attr('title', this.options.closeTitle)
					.appendTo('#ModalContainer')
					.click(function(e) {
						e.preventDefault();
						modal.close();
					})
				;
				$(document).bind('keypress', function(e) {
					if(e.keyCode == 27) {
						$('#ModalContainer .modalClose').click();
					}
				});
			}

			if($.isFunction(this.options.onOpen)) {
				this.options.onOpen.apply(this)
			}
			else {
				$('#ModalContainer').show();
			}
		},

		showLoader: function()
		{
			$('<div/>')
				.attr('id', 'ModalLoadingIndicator')
				.appendTo('body');
			;
		},

		showOverlayLoader: function(){
			$('<div/>')
				.attr('id', 'ModalOverlay')
				.addClass('modalOverlay')
				.css({
					opacity: 50 / 100,
					height: '100%',
					width: '100%',
					position: 'fixed',
					left: 0,
					top: 0,
					zIndex: 3000
				})
				.appendTo('body')
			;

			$('<div/>')
				.attr('id', 'ModalLoadingIndicator')
				.appendTo('body');
			;
		},

		hideOverlayLoader: function(){
			$('#ModalLoadingIndicator').remove();
			$('.modalOverlay').remove();
		},

		hideLoader: function()
		{
			$('#ModalLoadingIndicator').remove();
		},

		generateModal: function()
		{
			$('<div/>')
				.attr('id', 'ModalOverlay')
				.addClass('modalOverlay')
				.css({
					opacity: this.options.overlay / 100,
					height: '100%',
					width: '100%',
					position: 'fixed',
					left: 0,
					top: 0,
					zIndex: 3000
				})
				.appendTo('body')
			;

			if($.browser.msie && $.browser.version < 7) {
				wHeight = $(document.body).height()+'px';
				wWidth = $(document.body).width()+'px';
				$('#ModalOverlay').css({
					position: 'absolute',
					height: wHeight,
					width: wWidth
				});
				$('<iframe/>')
					.attr('src', 'javascript:false;')
					.attr('id', 'ModalTempiFrame')
					.css({opacity: 0, position: 'absolute', width: wWidth, height: wHeight, zIndex: 1000, top: 0, left: 0})
					.appendTo('body')
				;
			}

			this.showLoader();
			if(this.options.type == 'ajax') {
				modal = this;
				data = {};
				if(this.options.urlData != undefined) {
					data = this.options.urlData;
				}
				$.ajax({
					url: this.options.url,
					success: function(data) {
						modal.displayModal(data);
					},
					data: data
				});
			}
			else {
				this.displayModal(this.options.data);
			}
		},

		close: function(external)
		{
			if($.isFunction(this.options.onBeforeClose)) {
				this.options.onBeforeClose.apply(this, []);
			}

			if(this.options.type == 'inline') {
				$(this.options.inline).html(this.options.data);
			}

			if($.isFunction(this.options.onClose) && !external) {
				this.options.onClose.apply(this);
			}
			else {
				$('#ModalContainer').remove();
			}

			$('#ModalLoadingIndicator').remove();
			$('#ModalOverlay').remove();
			$('#ModalTempiFrame').remove();
		}
	};
})(jQuery);


function ModalBox(title, content){
	var str = '<div class="ModalTitle">'+title+'</div><div class="ModalContent">'+content+ '</div><div class="ModalButtonRow"></div>';
	$.iModal({ data: str });
}

function ModalBoxInline(title, content, width, withCloseButton){
	if(typeof(width) == 'undefined'){
		var width = 800;
	}
	if(typeof(withCloseButton) == 'undefined'){
		var withCloseButton = false;
	}
	if(withCloseButton){
		var str = '<div class="ModalTitle">'+title+'</div><div class="ModalContent">'+$(content).html()+ '</div><div class="ModalButtonRow"></div>';
	}else{
		var str = '<div class="ModalTitle">'+title+'</div><div class="ModalContent">'+$(content).html()+ '</div><div class="ModalButtonRow"><input type="button" class="CloseButton FormButton" value="Close Window" onclick="$.iModal.close();" /></div>';
	}
	$.iModal({ 'data': str, 'width':width });
}