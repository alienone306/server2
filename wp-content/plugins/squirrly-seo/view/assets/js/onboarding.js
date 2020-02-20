(function ($) {

    $(document).ready(function () {

        /////////////////////////////////////////////////// Activate, deactivate feature
        $('.sq-switch.redgreen input[type=checkbox]').change(function () {
            if ($(this).is(':checked')) {
                $('#sq_onboarding.sq_deactivated').removeClass('sq_deactivated');
            } else {
                $('#sq_onboarding:not(.sq_deactivated)').addClass('sq_deactivated');
            }
        });

        var feature_interval = setInterval(function () {
            var found = false;
            $('.checkbox').each(function () {
                console.log('checkbox');
                if (!$(this).find('input').is(':checked')) {
                    $(this).find('input').prop("checked", true);
                    found = true;
                    return false;
                }

            });

            if(!found) {
                clearInterval(feature_interval);
                $('.fields').each(function () {
                    $(this).show();
                });
                console.log('done');
            }
        }, 500);



    });

})(jQuery);