$(document).ready(function(){
     $('#ad_search_box').focusin(function(){
        $(this).val('');
        var top_postion = $(this).position().top + 20;
        var left_postion = $(this).position().left;
        $('#input_message').css({'top': top_postion, 'left': left_postion});
        $('#input_message').show();
     });

     $('#ad_search_box').focusout(function(){
        $(this).val('Search your ads');
        $('#input_message').hide();
     });

});

var StatusIcons = {'active' : '/assets/images/running.gif',
                     'paused' : '/assets/images/paused.gif',
                     'deleted' : '/assets/images/deleted.gif'};

var UIAdmgrGraphsUtil = {
    ONE_DAY:1,
    THREE_DAYS:3,
    SEVEN_DAYS:7,
    getTimeTicks:function(data_src,interval){
        interval = interval || UIAdmgrGraphsUtil.ONE_DAY;
        var ticks = [];
        var index = interval;
        for(;index < data_src.length-1; index += interval) ticks.push(data_src[index]);
        return ticks;
    },
    tooltipFormatter:function(data, obj){
        var index = obj.dataIndex;
        var date = data[index][1];
        var count = obj.datapoint[1];
        count = Math.round(count*1000)/1000;
        return date +': ' + count;
    }};
function hasArrayNature(a) {
    return ( !! a && (typeof a == 'object' || typeof a == 'function') && ('length' in a) && !('setInterval' in a) && (Object.prototype.toString.call(a) === "[object Array]" || ('callee' in a) || ('item' in a)));
}