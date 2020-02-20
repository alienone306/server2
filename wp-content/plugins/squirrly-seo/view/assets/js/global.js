if (typeof SQ_DEBUG === 'undefined') var SQ_DEBUG = false;
(function ($) {

    /**
     * Set the Cookie
     *
     * @param name string cookie name
     * @param value string cookie value
     * @return void
     */
    $.sq_setCookie = function (name, value) {
        value = $.sq_utf8Encode(value);
        value = value.replace(new RegExp("\\\\", "g"), "");

        document.cookie = name + "=" + value + "; expires=" + (60 * 24) + "; path=/";
    };

    /**
     * Encode utl8 for cookie
     *
     * @param {string} input
     * @returns {String}
     */
    $.sq_utf8Encode = function (input) {
        var output = [];
        // We need to allocate at least one byte per character.
        var bytes = $.str2utf8ba(input);
        var byteslen = bytes.length;
        for (var i = 0; i < byteslen; i++) {
            output.push(String.fromCharCode(bytes[i]));
        }

        return output.join('');
    };

    /**
     * Get the Cookie
     *
     * @param name string cookie name
     * @return void
     */
    $.sq_getCookie = function (name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    };

    $.sq_getHashParam = function (key) {
        var urlparts = location.href.split('#');

        if (urlparts.length >= 2) {
            urlparts.shift();
            var queryString = urlparts.join("#"); //join it back up
            var results = new RegExp('[\\?&#]*' + key + '=([^&#]*)').exec(queryString);
            if (results) {
                return results[1] || 0;
            }
        }

        return false;
    };

    $.sq_setHashParam = function (key, val) {
        var urlparts = location.href.split('#');

        if (urlparts.length >= 2) {
            var add = true;
            var urlBase = urlparts.shift(); //get first part, and remove from array
            var queryString = urlparts.join("#"); //join it back up

            var prefix = encodeURIComponent(key) + '=';
            var pars = queryString.split(/[&;]/g);
            for (var i = pars.length; i-- > 0;) {//reverse iteration as may be destructive
                if (pars[i].lastIndexOf(prefix, 0) !== -1 || pars[i] === '') {
                    pars[i] = pars[i].replace(pars[i], prefix + val);
                    add = false;
                    break;
                }
            }

            add && pars.push(prefix + val);

            location.href = urlBase + '#' + pars.join('&');
        } else {
            location.href += '#' + key + '=' + val;
        }
    };

    $.sq_getParam = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }

        return false;
    };

    /**
     * Load google chart
     * @param div
     */
    $.sq_loadChart = function (div) {
        new Chart(div, {
            type: 'bar',
            data: {
                labels: ['', '', '', '', '', '', ''],
                datasets: [{
                    data: div.data('values').split(','),
                    borderWidth: 0
                }]
            },
            options: {
                tooltips: {enabled: false},
                legend: {display: false},
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                title: {display: false},
                scales: {
                    yAxes: [{
                        display: false,
                        ticks: {
                            beginAtZero: true,
                            min: 0,
                            max: 1
                        }
                    }],
                    xAxes: [{
                        display: false,
                        ticks: {beginAtZero: true}
                    }]
                }
            }
        });
    };

    $.sq_showMessage = function (text, time) {
        $(".sq_alert").remove();
        if (text.indexOf('<div>') == -1) {
            text = $('<div class="sq_alert position-fixed fixed-top text-center text-white bg-success m-0 p-4 border border-white sq-position-fixed sq-fixed-top sq-text-center sq-text-white sq-bg-success sq-m-0 sq-p-4 sq-border sq-border-white" style="top: 33px !important;">' + text + '</div>');
        }
        $("body").prepend(text);

        if (typeof time === 'undefined') {
            time = 2000;
        }

        setTimeout(function () {
            text.remove();
        }, time);

        return text;
    };

    /**
     * Add keyword to briefcase
     * @param keyword
     */
    $.fn.sq_addBriefcase = function () {
        var $this = this;

        $this.addClass('sq_minloading');
        $.post(
            sqQuery.ajaxurl,
            {
                action: 'sq_briefcase_addkeyword',
                keyword: $this.data('keyword'),
                doserp: parseInt($this.data('doserp')),
                hidden: parseInt($this.data('hidden')),
                sq_nonce: sqQuery.nonce
            }
        ).done(function (response) {

            $this.removeClass('sq_minloading');
            if (typeof response.message !== 'undefined') {
                $.sq_showMessage(response.message).addClass('sq_success');

                $this.closest('tr').addClass('bg-briefcase');
            } else if (typeof response.error !== 'undefined') {

                $.sq_showMessage(response.error);
                $this.removeClass('sq_minloading');

            } else {
                $this.removeClass('sq_minloading');
                location.reload();
            }

        }).fail(function () {
            $this.removeClass('sq_minloading');
        });
    };

    /**
     * Listen if the call is made as ajax
     * @param obj
     */
    $.fn.sq_ajaxCallListen = function () {
        var $this = this;

        //Set params
        var $input = $('#' + $this.data('input'));
        var $confirm = $this.data('confirm');
        var $action = $this.data('action');
        var $redirect = $this.data('redirect');
        var $name = $this.data('name');
        var $value = 0;

        //if the input doesn't exist
        if (!$input.length) {
            $input = $this; //set the current object as input
        }
        if (typeof $confirm !== 'undefined') {
            if (!confirm($confirm)) return;
        }

        if ($input.is('input') && $input.attr('type') === "checkbox") {
            if ($input.is(":checked")) {
                $value = $input.val();
            }
        } else {
            if ($input.is('select')) {
                $value = $input.find('option:selected').val();
            } else {
                if ($input.is('input') && $input.val() !== '') {
                    $value = $input.val();
                }
            }
        }

        $this.addClass('sq_minloading');

        if ($action !== '' && $value !== '') {
            $.post(
                sqQuery.ajaxurl,
                {
                    action: $action,
                    input: $name,
                    value: $value,
                    referal: location.href,
                    sq_nonce: sqQuery.nonce
                }
            ).done(function (response) {
                if (typeof response.data !== 'undefined') {
                    if (response.data === '') {
                        $('#wpbody-content').prepend('Saved');
                    } else {
                        $('#wpbody-content').prepend(response.data);
                    }

                    //Add the assistant in the right side
                    if (response.assistant !== '' && response.assistant_dest) {
                        var show_url = $('.sq_assistant').find('ul:visible').attr('id');
                        $(response.assistant_dest).html(response.assistant);
                        if (show_url) $('#' + show_url).show();
                    }


                    setTimeout(function () {
                        $this.removeClass('sq_minloading');
                        if (typeof $redirect !== 'undefined') {
                            window.open($redirect, "_blank");
                        } else {
                            location.reload();
                        }
                    }, 1000);
                } else if (typeof response.error !== 'undefined') {
                    $.sq_showMessage(response.error);
                    $this.removeClass('sq_minloading');

                } else {
                    $this.removeClass('sq_minloading');
                    location.reload();
                }
            }).fail(function () {
                $this.removeClass('sq_minloading');
            }, 'json');
        }

    };


    $(document).ready(function () {
        clearTimeout(sq_loading_timeout);
        SQ_DEBUG && console.log('sq_GlobalInit');

        $('#sq_preloader').remove();

        $('.sq_trend:visible').each(function () {
            $.sq_loadChart($(this));
        });

        //if the stats are poped up
        $('.sq_kr_research').on('show.bs.modal', function () {
            $.sq_loadChart($(this).find('.sq_trend'));
        });

        //listen the Ajax Calls input fields
        if ($('.sq_save_ajax').length > 0) {
            $('.sq_save_ajax').find('input').on('change', function () {
                $(this).sq_ajaxCallListen();
            });
            $('.sq_save_ajax').find('button').on('click', function () {
                $(this).sq_ajaxCallListen();
            });
        }

        //listen the hide show advanced options button
        $('button.show_advanced').on('click', function () {
            $(this).hide();
            $('.sq_advanced').show();
            $('button.hide_advanced').show();
        });
        $('button.hide_advanced').on('click', function () {
            $(this).hide();
            $('.sq_advanced').hide();
            $('button.show_advanced').show();
        });

        $("button[type=submit]").not('.noloading').on("click", function () {
            $(this).addClass("sq_minloading");
        });

        $(document).on('keyup', function (event) {
            var keycode = event.keyCode || event.which;
            if (keycode == 27) {
                if (!$('.modal').hasClass('show')) {
                    if (confirm('Leave Squirrly Settings?')) {
                        location.href = $('#sq_btn_toolbar_close').find('a').attr('href');
                    }
                } else {
                    $('.modal').modal('hide');
                }
            }
        });


    });

    var sq_loading_timeout = setTimeout(function () {
        alert('A javascript error stops Squirrly from loading. Please check the browser console for errors.');
    }, 10000);


})(jQuery);
