jQuery(document).ready(function ($) {
    var data = {
        'action': 'get_cronjob_information'
    };

    $.post(ajaxurl, data, function (response) {
    });
});