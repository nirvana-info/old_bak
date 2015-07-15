$(document).ready(function(){
    // click edit button
    $('.editButton').click(function(){
        $('.pop_dialog[role=alertdialog]').show();
    });

    // pop-dialog events
    $('.pop_dialog input[name=save]').click(function(){
        $(this).parents('.pop_dialog').hide();
    });
    $('.pop_dialog input[name=Submit]').click(function(){
        $(this).parents('.pop_dialog').hide();
    });
    $('.pop_dialog input[name=cancel]').click(function(){
        $(this).parents('.pop_dialog').hide();
    });

    // dropdown events
    $('.uiSelectorButton').click(function(){
        var wrap =  $(this).parents('.wrap');
        if(wrap.hasClass('openToggler')){
            $(this).parents('.wrap').removeClass('openToggler');
        }else{
            $(this).parents('.wrap').addClass('openToggler');
        }
        // stop propagation
        return false;
    });
    $('.uiSelectorOption').click(function(event){
        $('.uiSelectorOption').removeClass('checked selected');
        $(this).addClass('checked selected');

        var selected_text = $(this).find('.itemLabel').text();
        $(this).parents('.wrap').find('.uiSelectorButton .uiButtonText').html(selected_text);
        $(this).parents('.wrap').removeClass('openToggler');

        // another way to stop propagation
        event.stopPropagation();
    });
    $(document).click(function(){
        $('.wrap').removeClass('openToggler');
    });

    // focus in search-box
    $('.uiSearchInput .inputtext').focusin(function(){
        $(this).val('');
    });
    $('.uiSearchInput .inputtext').focusout(function(){
        $(this).val('Search by keyword');
    });

    // help dialog events
    $('.contextual_help').click(function(){
       $('.ad_create_help_dialog').removeClass('hidden');
       $('.ad_create_help_dialog').show();
       var $help_dialog = $('.ad_create_help_dialog .generic_dialog_popup');
       var top_pos = $(this).position().top + 12;
       var left_pos = $(this).position().left - 20;
       $help_dialog.css({'top': top_pos, 'left': left_pos, 'width': '467px'});

       $help_dialog.fadeIn();
    });
    $('.ad_create_help_dialog input').click(function(){
       var $help_dialog = $('.ad_create_help_dialog');
       $help_dialog.fadeOut();
    });

    // show select creative dialog
    $('.selectCreativeButton').click(function(){
        $('.profileBrowserDialog[role=alertdialog]').show();
    });
    $('.fbProfileBrowserListContainer input[type=checkbox]').click(function(){
        var $target = $('#u511297_10');
        var count_selected = $('.fbProfileBrowserListContainer input[type=checkbox]:checked').size();
        var $reached = $target.find('span:first');
        var maxCount = parseInt($target.find('span:last').text());
        $reached.html(count_selected);

        if(count_selected == maxCount){
            $target.removeClass('limitNotReached');
        }else{
            if(!$target.hasClass('limitNotReached'))$target.addClass('limitNotReached');
        }
    });
});