$(document).ready(function(){

    $('#ads_create_submit').click(function(){
       if($('#ad_targeting').is(':hidden')){
           $('#ad_targeting').removeClass('hidden_elem');
           $('#ad_targeting').hide();
           $('#ad_targeting').fadeIn();
           $(document).scrollTop($('#ad_targeting').position().top);
       }else if($('#ad_delivery').is(':hidden')){
           $('#ad_delivery').removeClass('hidden_elem');
           $('#ad_delivery').hide();
           $('#ad_delivery').fadeIn();
           $(this).find('input').attr('value', 'Ad Review');
           $('#new_advertiser_help_link').removeClass('hidden');
           $(document).scrollTop($('#ad_delivery').position().top);
       }else{
           if(confirm('Are you sure?')){

           }else{

           }
       }
    });

    $('#budget_type').change(function(){
        if($('.dateTimeCombo').hasClass('hidden_elem')){
            $('.dateTimeCombo').removeClass('hidden_elem');
        }

        if('daily' == $(this).val()){
            $('#continuous_check').attr('disabled', false);
        }else{
            $('#continuous_check').attr('disabled', true);
        }
    });

    $('#schedule_start_date').datepicker();
    $('#schedule_end_date').datepicker();

    $('#continuous_check').click(function(){
       if($(this).is(':checked')){
         $('.dateTimeCombo').addClass('hidden_elem');
       }else{
         $('.dateTimeCombo').removeClass('hidden_elem');
       }
    });

    $('.sx_e5c0f8').click(function(){
        $(this).parent().addClass('hidden');
        $('.sx_fca934').parent().removeClass('hidden');
        $('.UIAdTargetingSimpleB_AdvancedOptions').removeClass('hidden');
    });

     $('.sx_fca934').click(function(){
        $(this).parent().addClass('hidden');
        $('.sx_e5c0f8').parent().removeClass('hidden');
        $('.UIAdTargetingSimpleB_AdvancedOptions').addClass('hidden');
    });

    $(document).scroll(function(){
        var $target = $('.UIAdTargeting_ReachBlockWrapper > .UIAdTargeting_ReachBlock');
        if($(this).scrollTop() < $('#ad_targeting').position().top){
            if($target.hasClass('UITargeting_reachBlockFloat')){
                $target.removeClass('UITargeting_reachBlockFloat');
            }
        }else{
            if(!$target.hasClass('UITargeting_reachBlockFloat')){
                $target.addClass('UITargeting_reachBlockFloat');
            }
        }
    });

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
});