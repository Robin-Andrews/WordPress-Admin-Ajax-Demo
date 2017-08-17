jQuery(document).ready(function ($) {
    $('#raad-form').submit(function () {

        data = {
            action: 'raad_get_results'
        };

        $.post(ajaxurl, data, function (response) {
           $('#raad-results').html(response);
        });

        return false;
    });
});