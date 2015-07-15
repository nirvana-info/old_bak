$(document).ready(function(){
    $('.contextualHelp').click(function(){
       $('.contextual_dialog').removeClass('hidden');
       $('.contextual_dialog').show();
       var $help_dialog = $('.contextual_dialog');
       var top_pos = $(this).position().top + 12;
       var left_pos = $(this).position().left - 20;
       $help_dialog.css({'top': top_pos, 'left': left_pos, 'width': '467px'});

       $help_dialog.fadeIn();
    });

    $('.contextual_dialog input').click(function(){
       var $help_dialog = $('.contextual_dialog');
       $help_dialog.fadeOut();
    });

    $('.adsAccountSpendCap .editLink').click(function(){
       var $parentDiv = $(this).parents('.adsAccountSpendCap');
       $parentDiv.find('.editData').removeClass('invisible_elem');
       $parentDiv.find('.viewData').addClass('invisible_elem');
       $parentDiv.find('.uiCloseButton').addClass('hidden_elem');
    });

     $('.adsAccountSpendCap .cancelButton').click(function(){
       var $parentDiv = $(this).parents('.adsAccountSpendCap');
       $parentDiv.find('.viewData').removeClass('invisible_elem');
       $parentDiv.find('.editData').addClass('invisible_elem');
     });

     $('.adsAccountSpendCap .saveButton').click(function(){
       var $parentDiv = $(this).parents('.adsAccountSpendCap');
       $parentDiv.find('.viewData').removeClass('invisible_elem');
       $parentDiv.find('.editData').addClass('invisible_elem');
     });
});