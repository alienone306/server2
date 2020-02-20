if (typeof SQ_DEBUG === 'undefined') var SQ_DEBUG = false;
(function ($) {

    $.fn.sq_SeoSettings = function () {
        var $this = this;

        ///////////////////// JSON LD
        $this.find('select[name=sq_jsonld_type]').on('change', function () {
            $('.tab-panel-Organization').hide();
            $('.tab-panel-Person').hide();
            $('.tab-panel-' + $(this).children("option:selected").val()).show();
        });

        //Upload image from library
        $this.find('.sq_imageselect').on('click', function (event) {
            var frame;
            var destination = $('#' + $(this).data('destination'));

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if (frame) {
                frame.open();
                return;
            }

            // Create a new media frame
            frame = wp.media({
                title: 'Select Or Upload Media You Want Search Engines to Display in Association with Your Brand/Site',
                button: {
                    text: 'Use this media'
                },
                multiple: false  // Set to true to allow multiple files to be selected
            });


            // When an image is selected in the media frame...
            frame.on('select', function () {

                // Get media attachment details from the frame state
                var attachment = frame.state().get('selection').first().toJSON();

                // Send the attachment URL to our custom image input field.
                destination.val(attachment.url);
            });

            // Finally, open the modal on click
            frame.open();
        });
        /////////////////////////////

    };



    $(document).ready(function () {

        /////////////////////////////////////////////////// Activate, deactivate feature
        $('.sq-switch.redgreen input[type=checkbox]').change(function () {
            if ($(this).is(':checked')) {
                $('#sq_seosettings.sq_deactivated').removeClass('sq_deactivated');
            } else {
                $('#sq_seosettings:not(.sq_deactivated)').addClass('sq_deactivated');
            }
        });

        $('#sq_seosettings.sq_deactivated').click(function () {
            $('.sq-switch.redgreen input[type=checkbox]').attr('checked', 'checked');
            $('.sq-switch.redgreen input[type=checkbox]').trigger('change');
        });

        ///////////////////////////////////////////////////// Save the Automation Tabs
        // store the currently selected tab in the hash value
        $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
            var id = $(e.target).attr("href").substr(1);
            $.sq_setHashParam('tab', id);
        });

        // on load of the page: switch to the currently selected tab
        var tab = $.sq_getHashParam('tab');
        if (tab !== '' && $('a[href="#' + tab + '"]').length > 0) {
            $('a[href="#' + tab + '"]').attr('aria-expanded', true).tab('show');
        }

        ///////////////////////////////////////////////////////
        $('#sq_seosettings').sq_SeoSettings();

        //////////////////////////////////////////////////// Prevent losing unsaved data
        var originalFormData = $('form:not(.ignore):first').find('input[type!=hidden]').serialize();
        $('button[type=submit]').on('click', function () {
            originalFormData = $('form:not(.ignore):first').find('input[type!=hidden]').serialize();
        });
        $('input[type=submit]').on('click', function () {
            originalFormData = $('form:not(.ignore):first').find('input[type!=hidden]').serialize();
        });

        window.onbeforeunload = function () {
            if (originalFormData !== '' && originalFormData !== $('form:not(.ignore):first').find('input[type!=hidden]').serialize()) {
                // console.log(originalFormData);
                // console.log($('form:not(.ignore):first').find('input[type!=hidden]').serialize());
                return "There are unchanged data. Are you sure you want to refresh?";
            }
        };

    });

})(jQuery);