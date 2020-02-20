if(typeof SQ_DEBUG === 'undefined') var SQ_DEBUG = false;
(function ($) {
    $.fn.sq_focusPages = function () {
        var $this = this;
        var lastScrollLeft = 0;
        var scrollLeft = 0;
        var maxScrollLeft = 0;

        $this.listenScrollbar = function () {
            $this.find('.sq_overflow').css('max-width', ($this.width() - 10)).show();

            $(window).resize(function () {
                $this.find('.sq_overflow').hide().css('max-width', ($this.width() - 10)).show();

                maxScrollLeft = ($this.find('.sq_overflow').prop("scrollWidth") - $this.find('.sq_overflow').width());
            });

            $this.find('.sq_overflow_arrow_right').show();
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
                    } else if (scrollLeft >= (maxScrollLeft - 20)) {
                        $('.sq_overflow_arrow_right').hide();
                        $('.sq_overflow_arrow_left').show();
                    }
                    lastScrollLeft = scrollLeft;
                }

            });
        };

        $this.listenScrollbar();


        //Created in SeoSettings.js
        //Called in SeoSettings.js
        var sq_Assistant = $.fn.sq_Assistant;
        $.fn.sq_Assistant = function (options) {
            var $this = this;
            var $modal = $('#sq_assistant_modal');

            var settings = $.extend({
                category: 'metas'
            }, options);

            $this.listenTableBullets = function () {
                //If the table bullet is pressed then show the snippet in BulkSeo
                //call the sq_loadSnippet from snippet.js
                $this.find('.sq_show_assistant').off('click').on('click', function () {
                    //Hide all assistant tasks and show only the current ones
                    $this.find('div.sq_assistant').find('ul').hide();
                    $this.find('ul#sq_assistant_tasks_' + $(this).data('category') + '_' + $(this).data('id')).show();

                });

                $this.find('.sq_show_assistant').tooltip({placement: 'left', trigger: 'hover'});
            };

            $this.listenTableBullets();

            $this.find('.sq_show_snippet').tooltip({placement: 'left', trigger: 'hover'});

            var args = Array.prototype.slice.call(arguments, 0);
            return sq_Assistant.apply($this, args);
        };
    };

    $(document).ready(function () {
        $('#sq_focuspages').sq_focusPages();
        $('#sq_wrap').sq_Assistant();
    });
})(jQuery);