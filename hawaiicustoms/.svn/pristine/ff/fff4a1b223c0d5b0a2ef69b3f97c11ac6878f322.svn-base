$(document).ready(function() {
	$('#headerMenu ul li.dropdown > a').dblclick(function(e)
	{
		e.stopPropagation();
		window.location = this.href;
		return false;
	});
    
	$('#headerMenu ul li.dropdown > a').click(function(e)
	{
		var elem = this;        
       
		if($(elem).parent().is('.over'))
		{
			$(elem.parentNode).removeClass('over');
			$(elem).parent().find('ul').css('display', 'none');
			$('embed').css('visibility', 'visible');
			return false;
		}

		if(document.topCurrentMenu) {
			$(document.topCurrentMenu).hide();
			$(document.topCurrentButton).removeClass('ActiveButton');
			$('.ControlPanelSearchBar').show();
		}

		if(document.currentMenu) {
			$(document.currentMenu.parentNode).removeClass('over');
			$(document.currentMenu).parent().find('ul').css('display', 'none');
			$('embed').css('visibility', 'visible');
		}
		document.currentMenu = this;

		offsetTop = offsetLeft = 0;
		var element = elem;
		do
		{
			offsetTop += element.offsetTop || 0;
			offsetLeft += element.offsetLeft || 0;
			element = element.offsetParent;
		} while(element && $(element).css('position') != 'relative');


		$(elem).parent().find('ul').css('visibility', 'hidden');
		if(navigator.userAgent.indexOf('MSIE') != -1) {
			$(elem).parent().find('ul').css('display', 'block');
		}
		else {
			$(elem).parent().find('ul').css('display', 'table');
		}
		var menuWidth = elem.parentNode.getElementsByTagName('ul')[0].offsetWidth;
		$(elem).parent().find('ul').css('width', menuWidth-2+'px');
		if(offsetLeft + menuWidth > $(window).width()) {
			$(elem).parent().find('ul').css('position', 'absolute');
			$(elem).parent().find('ul').css('left',  (offsetLeft-menuWidth+elem.offsetWidth-3)+'px');
		}
		else if(offsetLeft - menuWidth < $(window).width()) {
			$(elem).parent().find('ul').css('position', 'absolute');
			//$(elem).parent().find('ul').css('left',  offsetLeft+'px');
          
		}
		$('embed').css('visibility', 'hidden');
		$('object').css('visibility', 'hidden');
		$(elem).parent().find('ul').css('visibility', 'visible');
		$(elem).parent().addClass('over');
		$(elem).blur(function(event) {
			if(elem.parentNode.overmenu != true)
			{
				$(elem.parentNode).removeClass('over');
				$(elem).parent().find('ul').css('display', 'none');
				$('embed').css('visibility', 'visible');
				$('object').css('visibility', 'visible');
			}
		});
		$(document).click(function(event) {
			if(elem.parentNode.overmenu != true)
			{
				$(elem.parentNode).removeClass('over');
				$(elem).parent().find('ul').css('display', 'none');
				$('embed').css('visibility', 'visible');
				$('object').css('visibility', 'visible');
			}
		});
         $(".submenu").css('display','none');   
		return false;
	});
	$('#headerMenu ul li ul li').mouseover(function() {
		this.parentNode.parentNode.overmenu = true;
       
        $(this).find('ul').css('display', 'block');   
		this.onmouseout = function(e) { this.parentNode.parentNode.overmenu = false;$(this).find('ul').css('display', 'none'); }   
	});
	$('#headerMenu ul li ul li').click(function() {
		$(this.parentNode).hide();
		this.parentNode.parentNode.className = 'dropdown'; 
	});
    //Simha Startes Ends   
    $('#headerMenu ul li ul li ul li').mouseover(function() {   $(this).find('ul').css('display', 'block');    
        this.parentNode.parentNode.parentNode.overmenu = true;
        this.onmouseout = function(e) { this.parentNode.parentNode.parentNode.overmenu = false;}   
    });
    $('#headerMenu ul li ul li ul li').click(function() {
        $(this.parentNode.parentNode).hide();
        
        this.parentNode.parentNode.parentNode.className = 'dropdown'; 
    });
    
    //Simha Ends
});


function closeMenu() {
	if(document.currentMenu) {
		$(document.currentMenu.parentNode).removeClass('over');
		$(document.currentMenu).parent().find('ul').css('display', 'none');
		$('embed').css('visibility', 'visible');
		$('object').css('visibility', 'visible');
	}
}