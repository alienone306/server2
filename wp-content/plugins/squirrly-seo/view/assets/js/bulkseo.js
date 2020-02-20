if (typeof SQ_DEBUG === 'undefined') var SQ_DEBUG = false;
(function ($) {
    $.fn.sq_bulkSeo = function () {
        var $this = this;
        var lastScrollLeft = 0;
        var scrollLeft = 0;
        var maxScrollLeft = 0;

        $this.find('.sq_overflow').css('max-width', ($this.width() - 20)).show();

        $(window).resize(function () {
            $this.find('.sq_overflow').hide().css('max-width', ($this.width() - 20)).show();
            $this.find('.sq_overflow').scrollLeft(0);
            maxScrollLeft = ($this.find('.sq_overflow').prop("scrollWidth") - $this.find('.sq_overflow').width());

            if (maxScrollLeft > 0) {
                $this.find('.sq_overflow_arrow_right').show();
            } else {
                $this.find('.sq_overflow_arrow_right').hide();
            }
        });

        $this.find('.sq_overflow_arrow_right').on('click', function () {
            $this.find('.sq_overflow').scrollLeft(scrollLeft + $this.find('.sq_overflow').width());
        });

        $this.find('.sq_overflow_arrow_left').on('click', function () {
            $this.find('.sq_overflow').scrollLeft(scrollLeft - $this.find('.sq_overflow').width());
        });

        $this.find('.sq_overflow').scroll(function () {
            scrollLeft = parseInt($this.find('.sq_overflow').scrollLeft());
            maxScrollLeft = ($this.find('.sq_overflow').prop("scrollWidth") - $this.find('.sq_overflow').width());
            if (lastScrollLeft !== scrollLeft) {
                if (scrollLeft === 0) {
                    $('.sq_overflow_arrow_right').show();
                    $('.sq_overflow_arrow_left').hide();
                } else if (scrollLeft >= (maxScrollLeft - 10)) {

                    $('.sq_overflow_arrow_right').hide();
                    $('.sq_overflow_arrow_left').show();
                }
                lastScrollLeft = scrollLeft;
            }

        });


    };

    //Created in SeoSettings.js
    //Called in SeoSettings.js
    var sq_Assistant = $.fn.sq_Assistant;
    $.fn.sq_Assistant = function (options) {
        var $this = this;
        var $modal = $('#sq_assistant_modal');

        var settings = $.extend({
            category: 'metas',
            post_hash: ''
        }, options);

        $this.listenTableBullets = function () {
            //If the table bullet is pressed then show the snippet in BulkSeo
            //call the sq_loadSnippet from snippet.js
            $this.find('.sq_show_snippet').off('click').on('click', function () {

                var $id = $(this).data('id');
                settings.category = $(this).data('category');

                if (!$this.find('#sq_edit_' + $id).length) {
                    $this.find('#sq_row_' + $id).after('<tr id="sq_edit_' + $id + '" class="sq_edit"><td colspan="5" class="p-0 m-0"></td></tr>');
                    $this.find('#sq_edit_' + $id).find('td').html($this.find('#sq_blocksnippet_' + $id));
                }

                //If the snippet is not yet loaded, load the snippet and show it
                $this.find('#sq_blocksnippet_' + $id).show().sq_loadSnippet();

                //Hide all assistant tasks and show only the current ones
                $this.find('div.sq_assistant').find('ul').hide();
                $this.find('ul#sq_assistant_tasks_' + $(this).data('category') + '_' + $(this).data('id')).show();


            });

            $this.find('.sq_show_snippet').tooltip({placement: 'left', trigger: 'hover'});
        };

        $this.listenSnippet = function () {
            //Foreach Snippet block listen the save button to refresh the data
            //The response will bring the data about the current table row and the assistant
            $this.find('.sq_blocksnippet').each(function () {
                $(this).off('sq_snippet_loaded sq_reloaded').on('sq_snippet_loaded sq_reloaded', function () {
                    $snippet = $(this);
                    $snippet.find('.sq-tab-content').addClass('sq_minloading');
                    return $.post(
                        sqQuery.ajaxurl,
                        {
                            action: 'sq_ajax_assistant_bulkseo',
                            post_id: $snippet.find('input[name=sq_post_id]').val(),
                            term_id: $snippet.find('input[name=sq_term_id]').val(),
                            taxonomy: $snippet.find('input[name=sq_taxonomy]').val(),
                            post_type: $snippet.find('input[name=sq_post_type]').val(),
                            sq_nonce: sqQuery.nonce
                        }
                    ).done(function (response) {
                        $snippet.find('.sq-tab-content').removeClass('sq_minloading');

                        if (typeof response.html !== 'undefined') {
                            if (response.html !== '' && response.html_dest) {
                                $this.find('.sq_show_snippet').tooltip('hide');

                                $(response.html_dest).html(response.html);

                                //Add the assistant in the right side
                                if (response.assistant !== '' && response.assistant_dest) {
                                    var show_tasks_id = $this.find('.sq_assistant').find('ul:visible').attr('id');
                                    $(response.assistant_dest).html(response.assistant);
                                    if (show_tasks_id) $this.find('#' + show_tasks_id).show();
                                }
                                $('#sq_wrap').sq_Assistant({'category': settings.category});

                                //Show the snippet menu
                                var $tab = $snippet.find('.sq_snippet_menu').find('#sq-nav-item_' + settings.category);
                                $tab.addClass('active');
                                $snippet.find($tab.attr('href')).addClass('active');
                            }

                        } else if (typeof response.error !== 'undefined') {
                            $.sq_showMessage(response.error);
                        } else {
                            location.reload();
                            SQ_DEBUG && console.log('no data received');
                        }
                    }).fail(function () {
                        location.reload();
                        SQ_DEBUG && console.log('no data received');
                    }, 'json');
                });
            });

            $this.find('.sq-nav-item.sq-nav-link').on('click', function () {
                settings.category = $(this).data('category');
                settings.post_hash = $snippet.find('input[name=sq_hash]').val();

                if ($('#sq_row_' + settings.post_hash).length > 0) {
                    //Hide all assistant tasks and show only the current ones
                    $this.find('div.sq_assistant').find('ul').hide();
                    $this.find('ul#sq_assistant_tasks_' + settings.category + '_' + settings.post_hash).show();
                }
            });
        };

        $this.listenTableBullets();
        $this.listenSnippet();


        var args = Array.prototype.slice.call(arguments, 0);
        return sq_Assistant.apply($this, args);
    };

    $(document).ready(function () {
        $('#sq_seosettings').sq_bulkSeo();

        //if post is selected by id, open the snippet for it
        if ($.sq_getParam('sid')) {
            $('#sq_wrap').find('.sq_show_snippet:first').trigger('click');
        }

    });
})(jQuery);