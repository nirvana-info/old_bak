$(document).ready(function(){
    // click dropdown-like menu on the top
    $('.UIActionMenu').click(function(){
        remove_pops();
        if($(this).hasClass('openToggler')){
          $(this).removeClass('openToggler');
          $(this).find('.UIActionMenu_Menu').css('visibility', 'hidden');
        }else{
          $(this).addClass('openToggler');
          $(this).find('.UIActionMenu_Menu').css('visibility', 'visible');
        }

        return false;
    });
    $('.UIActionMenu .UISelectList_Item').click(function(){
        $(this).parents('.UIActionMenu').find('a').removeClass('UISelectList_radio_Checked');
        var $selected_item = $(this).find('a');
        $selected_item.addClass('UISelectList_radio_Checked');
        $(this).parents('.UIActionMenu').find('.UIActionMenu_Text').html($selected_item.text());
        remove_pops();

        return false;
    });

    // show the dropdown-like menu in row
    $('.uiSelector').click(function(){
         remove_pops();
         if($(this).find('.wrap').hasClass('openToggler')){
           $(this).find('.wrap').removeClass('openToggler');
           $(this).find('.uiSelectorButton').removeClass('selected');
         }else{
           $(this).find('.wrap').addClass('openToggler');
           $(this).find('.uiSelectorButton').addClass('selected');
         }

         return false;
    });

    $('li.uiMenuItem').mouseover(function(){
        $(this).parent().find('li.uiMenuItem').removeClass('selected');
        $(this).addClass('selected');
    });

    $('li.uiMenuItem').click(function(){
        $(this).parent().find('li').removeClass('checked');
        $(this).addClass('checked');

        //$(this).parent().parent().parent().prev().find('img').attr('src', $(this).find('img').attr('src'));
        $(this).parents('div.wrap').find('.uiSelectorButton img').attr('src', $(this).find('img').attr('src'));

        $('.uiSelector').find('.wrap').removeClass('openToggler');
        $('.uiSelector').find('.uiSelectorButton').removeClass('selected');

        return false;
    });

    $(document).click(function(){
       remove_pops();
    });

    function remove_pops(){
        if($('.UIActionMenu').hasClass('openToggler')){
            $('.UIActionMenu').removeClass('openToggler');
            $('.UIActionMenu').find('.UIActionMenu_Menu').css('visibility', 'hidden');
        }

        if($('.uiSelector .wrap').hasClass('openToggler')){
            $('.uiSelector').find('.wrap').removeClass('openToggler');
            $('.uiSelector').find('.uiSelectorButton').removeClass('selected');
        }
    }

    // click the edit link in rows
    $('.edit_link').click(function(){
        $(this).parent().addClass('edit_mode edit_mode_with_buttons');
    });

    // click budgetntype edit link
    $('#budgetntype_string .edit_link').click(function(){
       $('div.pop_dialog[role=alertdialog]').show();
    });

    // click budgetntype edit link
    $('#campaign_duration .edit_link').click(function(){
       $('div.pop_dialog[role=alertdialog]').show();
    });

    $('input[type=button]', '.generic_dialog_popup').click(function(){
       $(this).parents('div.pop_dialog[role=alertdialog]').hide();
    });

     // click the float save button on ad's page
    $('label.save_button', '#campaign_ui_status').click(function(){
        var $parentNode = $(this).parents('.edit_mode_with_buttons');
        var status = $parentNode.find('option:selected').text();
        $parentNode.find('.icon_container img').attr('src', StatusIcons[status.toLowerCase()]);
        $parentNode.find('.text_container a').text( status);

        $parentNode.removeClass('edit_mode edit_mode_with_buttons');
    });

    $('label.save_button', '#campaign_name').click(function(){
        saveEditText(this);
    });

    // click the float save button
    $('label.save_button', '.UIAdmgrPage_UITable').click(function(){
        // need a ajax request
        saveEditText(this);
    });

    function saveEditText(obj){
        var $target = $(obj).parent().parent();
        if($target .find('input.inputtext').size() > 0){
            var new_val = $target .find('input.inputtext').val();
            $target.parent().find('a.text').html(new_val);
            $target.parent().removeClass('edit_mode edit_mode_with_buttons');
        }
    }

    // click the float cancel button
    $('label.cancel_button').click(function(){
        $(this).parents('.edit_mode_with_buttons').removeClass('edit_mode edit_mode_with_buttons');
    });

    // click checkbox in the table
    $('.UITable input[type=checkbox]').click(function(){
       var $target = $('#actionbar_top > :nth-child(3)');
       if($(this).is(':checked')){
          $target.removeClass('uiButtonDisabled');
          $target.find('span').text('Edit 1 row');
       }else{
          $target.addClass('uiButtonDisabled');
          $target.find('span').text('Select rows to edit');
       }
    });

    // click checkbox on the top of the heard
    $('#toggle_checkboxes').click(function(){
       var checked = $(this).is(':checked');
       $('.UITable input[type=checkbox]').attr('checked', checked);
    });

    // click table header column
    $('th.clickable').click(function(){
        $('th.clickable .dir_arrow').remove();

        if($(this).find('.fbGlossaryTip').size() > 0){
            $(this).find('.fbGlossaryTip').append('<span class="dir_arrow"></span>');
        }else{
            $(this).find('.hdr_text').append('<span class="dir_arrow"></span>');
        }

        if($(this).hasClass('desc')){
            $(this).removeClass('desc');
            $(this).addClass('asc');
        }else{
            $(this).removeClass('asc');
            $(this).addClass('desc');
        }
    });

    // click edit button
    $('#actionbar_top > :nth-child(3)').click(function(){
       if(!$(this).hasClass('uiButtonDisabled')){
          $(this).addClass('hidden_elem');
          $('#actionbar_top > :nth-child(4)').removeClass('hidden_elem');
          $('#actionbar_top > :nth-child(5)').removeClass('hidden_elem');
          $('.UITable input[type=checkbox]').attr('disabled', true);
          $('td input[type=checkbox]:checked').parent().parent().find('div[bindpoint=wrapper]').addClass('edit_mode edit_mode_without_buttons');
       }
    });

    // click save button
    $('#actionbar_top > :nth-child(4)').click(function(){
       // need a ajax request
       var editors = $('.UIEditableElement .editor');
       $.each(editors, function(){
          var new_val = $(this) .find('input.inputtext').val();
          $(this).parent().find('a.text').html(new_val);
       });

       $(this).addClass('hidden_elem');
       $('#actionbar_top > :nth-child(3)').removeClass('hidden_elem');
       $('#actionbar_top > :nth-child(5)').addClass('hidden_elem');
       $('.UITable input[type=checkbox]').attr('disabled', false);
       $('td input[type=checkbox]:checked').parent().parent().find('div[bindpoint=wrapper]').removeClass('edit_mode edit_mode_without_buttons');
    });

    // click cancel button
    $('#actionbar_top > :nth-child(5)').click(function(){
       $(this).addClass('hidden_elem');
       $('#actionbar_top > :nth-child(3)').removeClass('hidden_elem');
       $('#actionbar_top > :nth-child(4)').addClass('hidden_elem');
       $('.UITable input[type=checkbox]').attr('disabled', false);
       $('td input[type=checkbox]:checked').parent().parent().find('div[bindpoint=wrapper]').removeClass('edit_mode edit_mode_without_buttons');
    });

    // click ads' name
    $('a[bindpoint=textElement]', '.UIEditableText').click(function(){
       var $target = $(this).parents('tr.clickable').next();
       var $wrapper = $target.find('.inline_edit_wrapper');
       if($target.is(':hidden')){
          $target.removeClass('hidden');
          $wrapper.css({'height': 'auto'});
          $wrapper.slideDown('slow');
          $(document).scrollTop($(document).scrollTop() + $wrapper.height() - 110);
       }else{
          $target.addClass('hidden');
          $wrapper.css({'height': '0px'});
          $wrapper.slideUp('slow');
       }
    });

    // close ads' inline editor
    $('input[type=submit]', '.close_button').click(function(){
       var $target = $(this).parents('tr.inline_edit');
       var $wrapper = $target.find('.inline_edit_wrapper');

       $target.addClass('hidden');
       $wrapper.css({'height': '0px'});
       $wrapper.slideUp();
    });

    var audience_data =
        [
            {"label":"Targeted\u003ca class=\"fbGlossaryTip admgrGlossaryTip fbGlossaryTipFixedWidth fbGlossaryTipQ\" href=\"#\">\u003csup>?\u003c\/sup>\u003cspan class=\"tip right\">\u003cspan class=\"tipTitle\">Targeted\u003c\/span>\u003cspan class=\"tipBody\">The approximate number of people your Sponsored Stories or ads can reach based on the targeting you&#039;ve selected.\u003c\/span>\u003cspan class=\"tipArrow\">\u003c\/span>\u003c\/span>\u003c\/a>","series_name":"Targeted","data":300,"label_format":"300 people"},
            {"label":"Reach\u003ca class=\"fbGlossaryTip admgrGlossaryTip fbGlossaryTipFixedWidth fbGlossaryTipQ\" href=\"#\">\u003csup>?\u003c\/sup>\u003cspan class=\"tip right\">\u003cspan class=\"tipTitle\">Reach\u003c\/span>\u003cspan class=\"tipBody\">The number of individual people who saw your Sponsored Stories or ads. This is different than impressions, which includes people seeing them multiple times.\u003c\/span>\u003cspan class=\"tipArrow\">\u003c\/span>\u003c\/span>\u003c\/a>","series_name":"Reach","data":64,"label_format":"64 people"},
            {"label":"Social Reach\u003ca class=\"fbGlossaryTip admgrGlossaryTip fbGlossaryTipFixedWidth fbGlossaryTipQ\" href=\"#\">\u003csup>?\u003c\/sup>\u003cspan class=\"tip right\">\u003cspan class=\"tipTitle\">Social Reach\u003c\/span>\u003cspan class=\"tipBody\">People who saw your campaign&#039;s Sponsored Stories or ads with the names of their friends who liked your Page, RSVPed to your event, or used your app. If you&#039;re not using Sponsored Stories or advertising a Page, event, or app, you won&#039;t have social reach.\u003c\/span>\u003cspan class=\"tipArrow\">\u003c\/span>\u003c\/span>\u003c\/a>","series_name":"Social Reach","data":0,"label_format":"0 people"}
        ];
    var response_data =
        [
            {"label":"Clicks","data":[[1309244400000,0],[1309330800000,0],[1309417200000,0],[1309503600000,0],[1309590000000,0],[1309676400000,0],[1309762800000,0],[1309849200000,0],[1309935600000,0],[1310022000000,0],[1310108400000,0],[1310194800000,0],[1310281200000,0],[1310367600000,0],[1310454000000,0],[1310540400000,0],[1310626800000,0],[1310713200000,0],[1310799600000,0],[1310886000000,0],[1310972400000,0],[1311058800000,0],[1311145200000,0],[1311231600000,"0"],[1311318000000,"0"],[1311404400000,"0"],[1311490800000,"0"],[1311577200000,0]]},
            {"label":"Connections","data":[[1309244400000,0],[1309330800000,0],[1309417200000,0],[1309503600000,0],[1309590000000,0],[1309676400000,0],[1309762800000,0],[1309849200000,0],[1309935600000,0],[1310022000000,0],[1310108400000,0],[1310194800000,0],[1310281200000,0],[1310367600000,0],[1310454000000,0],[1310540400000,0],[1310626800000,0],[1310713200000,0],[1310799600000,0],[1310886000000,0],[1310972400000,0],[1311058800000,0],[1311145200000,0],[1311231600000,0],[1311318000000,0],[1311404400000,0],[1311490800000,0],[1311577200000,0]]}
        ];
    var time_to_date = [[1309244400000,"06\/28"],[1309330800000,"06\/29"],[1309417200000,"06\/30"],[1309503600000,"07\/01"],[1309590000000,"07\/02"],[1309676400000,"07\/03"],[1309762800000,"07\/04"],[1309849200000,"07\/05"],[1309935600000,"07\/06"],[1310022000000,"07\/07"],[1310108400000,"07\/08"],[1310194800000,"07\/09"],[1310281200000,"07\/10"],[1310367600000,"07\/11"],[1310454000000,"07\/12"],[1310540400000,"07\/13"],[1310626800000,"07\/14"],[1310713200000,"07\/15"],[1310799600000,"07\/16"],[1310886000000,"07\/17"],[1310972400000,"07\/18"],[1311058800000,"07\/19"],[1311145200000,"07\/20"],[1311231600000,"07\/21"],[1311318000000,"07\/22"],[1311404400000,"07\/23"],[1311490800000,"07\/24"],[1311577200000,"07\/25"]];
    $.plot($("#admgrJSAudienceGraph .admgrJSGraphCanvas"), audience_data,
    {
        colors: ['#e9eef4', '#d0e4a3', '#eaae2e'],
        series: {
            //pie:    {
            circles: {
                show: true
            },
            shadowSize:0
        },
        grid: {
            borderWidth:1,
            borderColor:'#999999',
            hoverable: true,
            autoHighlight:false,
            mouseActiveRadius:5
        }
    });

    $('#budget_type').change(function(){
        if($('.dateTimeCombo').hasClass('hidden_elem')){
            $('.dateTimeCombo').removeClass('hidden_elem');
        }

        if('daily' == $(this).val()){
            $(this).parent().find('.lifetimeSubText').addClass('hidden');
            $(this).parent().find('.dailySubText').removeClass('hidden');
            $('#continuous_check').attr('disabled', false);
        }else{
            $(this).parent().find('.dailySubText').addClass('hidden');
            $(this).parent().find('.lifetimeSubText').removeClass('hidden');
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

    $.plot($("#admgrJSResponseGraph .admgrJSGraphCanvas"), response_data,
    {
        colors: ['#3c64b9', '#a6c475', '#3cc4b9', '#5d9d90', '#92785c'],
        legend: {
            show: true,
            noColumns: 2,
            container: $("#admgrJSResponseGraph .admgrJSGraphLegend").get(0)
        },
        series: {
            shadowSize:0
        },
        xaxis: {
            mode:'time',
            tickLength:7,
            ticks: UIAdmgrGraphsUtil.getTimeTicks(time_to_date, UIAdmgrGraphsUtil.THREE_DAYS)
        },
        yaxis: {
            ticks: 2,
            min: 0
        },
        grid: {
            halfframe: true,
            borderWidth:1,
            borderColor:'#999999',
            hoverable:true,
            autoHighlight:false,
            mouseActiveRadius:5
        }
    });

    $.each($(".admgrMinigraphsWrapper .admgrJSMiniGraph"), function(){
        $.plot($(this), response_data,
        {
            colors: ['#3c64b9', '#a6c475', '#3cc4b9', '#5d9d90', '#92785c'],
            legend: {
                show: false
            },
            series: {
                shadowSize:0
            },
            xaxis: {
                mode:'time',
                tickLength:7,
                ticks: UIAdmgrGraphsUtil.getTimeTicks(time_to_date, UIAdmgrGraphsUtil.SEVEN_DAYS)
            },
            yaxis: {
                ticks: 2,
                min: 0,
                max: 1
            },
            grid: {
                halfframe: true,
                borderWidth:1,
                borderColor:'#999999',
                hoverable:false,
                autoHighlight:false,
                mouseActiveRadius:5
            }
        });
    });


    $("#admgrJSAudienceGraph .admgrJSGraphCanvas").bind("plothover", function(event, pos, obj){
        if (!obj) return;
        showGraphTip(this, 'Reach<br>' + audience_data[obj.seriesIndex].label_format, pos.pageY - $(this).height() - 60, pos.pageX - $(this).width() + 60);
    });
    $("#admgrJSResponseGraph .admgrJSGraphCanvas").bind("plothover", function(event, pos, obj){
        if (!obj) return;
        showGraphTip(this, UIAdmgrGraphsUtil.tooltipFormatter(time_to_date, obj), pos.pageY - $(this).height() - 75, pos.pageX - $(this).width() + 60);
    });

    $("#admgrJSAudienceGraph .admgrJSGraphCanvas").bind("mouseout", function(){hideGraphTip(this)});
    $("#admgrJSResponseGraph .admgrJSGraphCanvas").bind("mouseout", function(){hideGraphTip(this)});
    function hideGraphTip(div){
        if($(div).find('.fbInsightsTooltip').size() > 0){
           $(div).find('.fbInsightsTooltip').addClass('hidden_elem');
        }
    }

    function showGraphTip(div, message, top, left){
        if($(div).find('.fbInsightsTooltip').size() == 0){
            var $tipHtml = $('<div class="fbInsightsTooltip"></div>');
            $(div).append($tipHtml);
        }else{
            var $tipHtml =  $(div).find('.fbInsightsTooltip');
        }

        $tipHtml.removeClass('hidden_elem');
        $tipHtml.css({'position': 'absolute', 'top': top, 'left': left});
        $tipHtml.html('<span class="fbInsightsTooltipText">' + message + '</span>');
    }
});