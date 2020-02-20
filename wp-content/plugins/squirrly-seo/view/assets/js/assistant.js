if (typeof SQ_DEBUG === 'undefined') var SQ_DEBUG = false;
(function ($) {
//Used on Bulk Seo and Focus Pages too
    $.fn.sq_Assistant = function () {
        var $this = this;
        var $modal = $('#sq_assistant_modal');

        //Listen the task click and open the task popup
        $this.listenTasks = function () {
            $this.find('.sq_assistant').find('.sq_task').off('click').on('click', function () {
                $modal.find('.modal-body').html(($(this).find('.message').html() !== '' ? '<div class="text-warning mb-4 text-lg-left">' + $(this).find('.message').html() : '') + '</div>' + $(this).find('.description').html());
                $modal.find('.sq_save_ajax').find('input').attr('data-input', 'sq_ignore_' + $(this).data('name'));
                $modal.find('.sq_save_ajax').find('input').attr('data-name', $(this).data('category') + '|' + $(this).data('name'));

                if ($(this).data('active')) {
                    $modal.find('.sq_save_ajax').find('input').prop('checked', true);
                } else {
                    $modal.find('.sq_save_ajax').find('input').prop('checked', false);
                }

                $modal.find('.sq_save_ajax').find('input').on('change', function () {
                    $(this).sq_ajaxCallListen();
                });

                $modal.modal('show');
            });
        };
        $this.find('.sq_assistant').find('i.fa').tooltip({placement: 'left', trigger: 'hover'});
        $this.listenTasks();

    };


    $(document).ready(function () {
        $('#sq_wrap').sq_Assistant();
    });

})(jQuery);