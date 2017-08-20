jQuery(document).ready(function ($) {
    $('#raad-form').submit(function () {
        $('#raad_loading').show();
        $('#raad_submit').attr('disabled', true);

        data = {
            action: 'raad_get_results',
            raad_nonce: raad_vars.raad_nonce
        };

        $.post(ajaxurl, data, function (response) {
           $('#raad-results').html(response);
           $('#raad_loading').hide();
           $('#raad_submit').attr('disabled', false);
        });

        return false;
    });
});