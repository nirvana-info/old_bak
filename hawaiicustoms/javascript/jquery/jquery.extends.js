/*
 * jQuery Extends that used for our own project
 * @requires jQuery v1.2.2 or later
 *
 * @author Wilson Zeng
 */
(function($){
    //extend jq of adjust image
    $.fn.adjustImage = function(w, h){
        //if has attribute -- original_selector,it will use the selector's width&height to do judgement
        var original_id = $(this).attr('original_selector') || this;
        var original_w = $(original_id).width();
        var original_h = $(original_id).height();
        //resize which bigger
        (original_w > original_h) ? $(this).width(Math.min(w, original_w)) : $(this).height(Math.min(h, original_h));
    };
})(jQuery);