if (typeof SQ_DEBUG === 'undefined') var SQ_DEBUG = false;
(function ($) {
    var sqs_script = 'kr';

    $(document).keypress(function (event) {
        var keycode = event.keyCode || event.which;
        if (keycode == 13) {
            $('.sqd-submit:visible').trigger('click');
        }
    });

    $.sq_steps = function (step) {
        if (step === 2 && $('input[name=sq_input_keyword]').val() === '') {
            $.sq_showMessage('Add a keyword first', 2000);
            return;
        }
        $('.sq_step').hide();
        $('.sq_step' + step).show();
    };

    $.fn.sq_getSuggested = function () {
        var $this = this;

        if ($('input[name=sq_input_keyword]').val() !== '') {
            $.sq_steps(3);
            $this.addClass('sq_loading');

            $.post(
                sqQuery.ajaxurl,
                {
                    action: 'sq_ajax_research_others',
                    keyword: $('input[name=sq_input_keyword]').val(),
                    country: $('select[name=sq_select_country] option:selected').val(),
                    lang: 'en',
                    sq_nonce: sqQuery.nonce

                }
            ).done(function (response) {
                $this.removeClass('sq_loading');

                $count = 0;
                if (typeof response.keywords !== 'undefined' && response.keywords !== null && response.keywords.length > 0) {
                    $this.find('.sq_suggested').each(function () {
                        if (typeof response.keywords[$count] !== 'undefined') {
                            $(this).html('<input type="checkbox" id="sq_input_keywords' + $count + '" name="sq_input_keywords[]" class="sq_input_keywords custom-control-input" value="' + response.keywords[$count] + '"><label class="custom-control-label" for="sq_input_keywords' + $count + '">' + response.keywords[$count] + '</label>');
                            $count++;
                        } else {
                            $(this).hide();
                        }
                    });
                } else if (typeof response.error !== 'undefined' && response.error === 'limit_exceeded') {
                    $this.find('.sq_limit_exceeded').show();
                } else {
                    $this.find('.sq_research_error').show();

                }
            }).fail(function () {
                $this.removeClass('sq_loading').show();
                $this.prepend('<div class="text-center text-warning">Squirrly Library loading error. Please contact us at support@squirrly.co</div>');
            });

        } else {
            $('.sq_step2').find('.sq_research_error').show();
        }
    };

    $.fn.sq_getResearch = function () {
        var $this = this;
        $.sq_steps(4);
        $this.find('.btn').hide();
        //find the loading div
        var $loadingdiv = $('div.sq_step4').find('.sq_loading_steps');
        //the keywords
        var $keywords = $('input[name=sq_input_keyword]').val();

        $('input.sq_input_keywords:checked').each(function () {
            $keywords += ',' + $(this).val();
        });

        var loadingAjax = true;
        $this.addClass('sq_loading');

        /////////////show loading
        var $loadingstep = 1;
        $loadingdiv.show();
        $loadingdiv.find('.sq_loading_step').hide();
        $loadingdiv.find('.sq_loading_step' + $loadingstep).show();

        var sq_loadingsteps_interval = setInterval(function(){
            $loadingstep++;
            if($loadingstep <= 9) {
                $loadingdiv.find('.sq_loading_step').hide();
                $loadingdiv.find('.sq_loading_step' + $loadingstep).show();
            }else{
                clearInterval(sq_loadingsteps_interval);
            }
        },5000);

        $.post(
            sqQuery.ajaxurl,
            {
                action: 'sq_ajax_research_process',
                keywords: $keywords,
                country: $('select[name=sq_select_country] option:selected').val(),
                lang: 'en',
                sq_nonce: sqQuery.nonce
            }
        ).done(function (response) {
            loadingAjax = false;
            $this.removeClass('sq_loading');
            $loadingdiv.hide();
            $this.find('.btn').show();

            var $table = $('div.sq_step4 table');

            if (typeof response.html !== 'undefined') {
                $table.find('tbody').html(response.html);
                $('.sq_research_success').show();
            }

            $table.show();

            //Set the new sort
            $.extend($.fn.dataTableExt.oSort, {
                "formatted-value-pre": function (a) {
                    return $('<div></div>').append(a).find('span').data('value');
                },

                "formatted-value-asc": function (a, b) {
                    return a - b;
                },

                "formatted-value-desc": function (a, b) {
                    return b - a;
                }
            });

            $table.DataTable(
                {
                    "columnDefs": [
                        {
                            "targets": [5, 6],
                            "sortable": false
                        },
                        {
                            "targets": [2, 3, 4],
                            "sortable": true,
                            "type": "formatted-value"
                        }
                    ],
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": true,
                    "iDisplayLength": 20
                }
            );


            $table.find('.sq_trend:visible').each(function () {
                $.sq_loadChart($(this));
            });

            $table.find('.sq_research_add_briefcase').each(function () {
                $(this).on('click', function () {
                    $(this).sq_addBriefcase();
                });
            });


            $table.find('.sq_research_selectit').on('click', function () {
                $(this).addClass('sq_minloading');
                var $keyword = $(this).data('keyword');
                $.sq_setCookie('sq_keyword', $keyword);

                location.href = $(this).data('post');
            });


        }).fail(function () {
            loadingAjax = false;
            $this.removeClass('sq_loading');
            $loadingdiv.hide();
            $this.find('.btn').show();

            $('.sq_research_timeout_error').show();
        }, 'json');


        setTimeout(function () {
            if (loadingAjax) {
                $this.find('.btn').show();

                $this.removeClass('sq_loading').show();
                $loadingdiv.hide();
                $this.prepend('<div class="text-center text-warning">Lost connection with the server. Please make sure you whitelisted the IP from https://api.squirrly.co</div>');
            }
        }, 300000);


        return $this;
    };

    $.fn.sq_getHistory = function () {
        var $this = this;
        var $id = $this.data('id');
        var $destination = $($this.data('destination'));

        if (!$destination.length) {
            if (!$('#history' + $id).length) {
                $destination = $('<tr id="history' + $id + '"></tr>');
                $this.parents('tr:last').after($destination);
                $destination.show();
            }
        } else {
            //a different way to toggle on button click
            $($destination).remove();
            return;
        }


        if ($($destination).is(':visible')) {
            $this.addClass('sq_minloading');

            $.post(
                sqQuery.ajaxurl,
                {
                    action: 'sq_ajax_research_history',
                    id: $this.data('id'),
                    sq_nonce: sqQuery.nonce
                }
            ).done(function (response) {
                $this.removeClass('sq_minloading');

                if (typeof response.html !== 'undefined') {
                    $destination.html(response.html);
                }

                $destination.find('.sq_research_add_briefcase').each(function () {
                    $(this).on('click', function () {
                        $(this).sq_addBriefcase();
                    });
                });

                $destination.find('.sq_research_selectit').on('click', function () {
                    $(this).addClass('sq_minloading');
                    var $keyword = $(this).data('keyword');
                    $.sq_setCookie('sq_keyword', $keyword);

                    location.href = $(this).data('post');
                });

            }).fail(function () {
                $this.removeClass('sq_minloading');
                $destination.html('<td colspan="4" class="col-sm-12 text-center my-3 text-danger">Could not find the records</td>');
            }, 'json');

        }
    };

    $(document).ready(function () {

        $('.sq_history_details').on('click', function () {
            $(this).sq_getHistory();
        });

        $('.sq_research_add_briefcase').each(function () {
            $(this).on('click', function () {
                $(this).sq_addBriefcase();
            });
        });

        //Load datatables for labels
        if ($('#sq_briefcaselabels').length) {
            $('#sq_briefcaselabels').find('table.table').DataTable(
                {
                    "columnDefs": [
                        {
                            "targets": [1],
                            "searchable": true,
                            "sortable": true
                        },
                        {
                            "targets": [0, 2, 3],
                            "sortable": false
                        }
                    ],
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "iDisplayLength": 10,
                    "aaSorting": [1, 'desc']
                }
            );
        }
    });
})(jQuery);