$(document).ready(function(){
    $('#report_type').change(function(){
        $('.adreport_help_message').hide();
        $('#' + this.value + '_help').show();
    });

    $('#summarize_by').change(function(){
        set_filter_by_summary();
    });

    $('#agg_time').change(function(){
        set_date_by_agg();
    });

    $('#filter').change(function(){
        $('.filter_multiselect').hide();
        if('ad' == $('#filter').val()){
            $('#adgroup_filter_select').show();
        }else  if('campaign' == $('#filter').val()){
            $('#campaign_filter_select').show();
        }
    });

    $('.dateBox .textField').datepicker();

    function set_filter_by_summary(){
        if('account' == $('#summarize_by').val()){
            $('#row_report_filter').hide();
        }else{
            $('#row_report_filter').show();
        }
    }
    set_filter_by_summary();

    function set_date_by_agg(){
        $('.range_selector').hide();
        if('monthly' == $('#agg_time').val()){
            $('#month_range').show();
        }else  if('weekly' == $('#agg_time').val()){
            $('#week_range').show();
        }else{
            $('#day_range').show();
        }
    }
    set_date_by_agg();
});