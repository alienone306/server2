if (typeof SQ_DEBUG === 'undefined') var SQ_DEBUG = false;
//Blogs
(function ($) {

    $.sq_showSaved = function (message, time) {
        if (!$('.sq_blocksnippet').find('.sq_tabcontent').length) {
            $('.sq_blocksnippet').prepend('<div class="sq_tabcontent" ></div>');
        }
        $('.sq_blocksnippet').find('.sq_tabcontent').prepend('<div class="sq-alert sq-my-2 sq-alert-success sq-alert-absolute" >' + message + '</div>');

        if (typeof time !== 'undefined' && time > 0) {
            setTimeout(function () {
                jQuery('.sq-alert').hide();
            }, time);
        }
    };

    $.sq_showError = function (message, time) {
        if (!$('.sq_blocksnippet').find('.sq_tabcontent').length) {
            $('.sq_blocksnippet').prepend('<div class="sq_tabcontent" ></div>');
        }
        $('.sq_blocksnippet').find('.sq_tabcontent').prepend('<div class="sq-alert sq-my-2 sq-alert-danger sq-alert-absolute" >' + message + '</div>');

        if (typeof time !== 'undefined' && time > 0) {
            setTimeout(function () {
                jQuery('.sq-alert').hide();
            }, time);
        }
    };

    $.fn.sq_loadSnippet = function () {
        var $this = this;

        if (!$('input[name=sq_post_id]').length) {
            if ($('input[name=post_ID]').length > 0) {
                $this.prepend('<input type="hidden" name="sq_post_id" value="' + $('input[name=post_ID]').val() + '">');
            }
            if ($('input[name=post_type]').length > 0) {
                $this.prepend('<input type="hidden" name="sq_post_type" value="' + $('input[name=post_type]').val() + '">');
            }
            if ($('input[name=tag_ID]').length > 0) {
                $this.prepend('<input type="hidden" name="sq_term_id" value="' + $('input[name=tag_ID]').val() + '">');
            }
            if ($('input[name=taxonomy]').length > 0) {
                $this.prepend('<input type="hidden" name="sq_taxonomy" value="' + $('input[name=taxonomy]').val() + '">');
            }
        }

        $this.each(function () {
            $(this).sq_getSnippet(
                $(this).find('input[name=sq_post_id]').val(),
                $(this).find('input[name=sq_term_id]').val(),
                $(this).find('input[name=sq_taxonomy]').val(),
                $(this).find('input[name=sq_post_type]').val()
            );
        });

    };

    $.fn.sq_editSnippet = function (options) {
        var $this = this;

        /**
         * Set the fields in vars
         */
        var settings = $.extend({
            'called': 'normal',
            'sq_snippet_wrap': $this.find('.sq_snippet_wrap'),
            'editButton': $this.find('.sq_snippet_btn_edit'),
            'saveButton': $this.find('.sq_snippet_btn_save'),
            'cancelButton': $this.find('.sq_snippet_btn_cancel'),
            'refreshButton': $this.find('.sq_snippet_btn_refresh'),
            'last_tab': null,
            'closeButton': $this.find('.sq-close'),
            'sq_url': $this.find('input[name=sq_url]'),
            'sq_doseo': $this.find('input[name=sq_doseo].sq-switch'),
            'sq_toggle': $this.find('.sq-toggle'),
            /* ==== meta inputs ==== */
            'sq_title': $this.find('textarea[name=sq_title]'),
            'sq_description': $this.find('textarea[name=sq_description]'),
            'sq_keywords': $this.find('input[name=sq_keywords]'),
            'sq_noindex': $this.find('input[name=sq_noindex]'),
            'sq_nofollow': $this.find('input[name=sq_nofollow]'),
            'sq_nositemap': $this.find('input[name=sq_nositemap]'),
            'sq_canonical': $this.find('input[name=sq_canonical]'),
            /* ==== og inputs ==== */
            'sq_og_media': $this.find('input[name=sq_og_media]'),
            'sq_og_media_preview': $this.find('img.sq_og_media_preview'),
            'og_image_close': $this.find('.sq_og_image_close'),
            'sq_og_title': $this.find('textarea[name=sq_og_title]'),
            'sq_og_description': $this.find('textarea[name=sq_og_description]'),
            'sq_og_author': $this.find('input[name=sq_og_author]'),
            'sq_og_type': $this.find('select[name=sq_og_type]'),
            'sq_og_pixel': $this.find("#sq_og_pixel_id"),
            /* ==== tw inputs ==== */
            'sq_tw_media': $this.find('input[name=sq_tw_media]'),
            'sq_tw_media_preview': $this.find('img.sq_tw_media_preview'),
            'tw_image_close': $this.find('.sq_tw_image_close'),
            'sq_tw_title': $this.find('textarea[name=sq_tw_title]'),
            'sq_tw_description': $this.find('textarea[name=sq_tw_description]'),
            'sq_tw_type': $this.find('select[name=sq_tw_type]'),
            /* ==== json ld ====*/
            'sq_jsonld': $this.find('textarea[name=sq_jsonld]'),
            'sq_jsonld_code_type': $this.find('select.sq_jsonld_code_type'),
            'sq_jsonld_custom_code': $this.find('div.sq_jsonld_custom_code'),

            /* ==== json ld ====*/
            'sq_fpixel': $this.find('textarea[name=sq_fpixel]'),
            'sq_fpixel_code_type': $this.find('select.sq_fpixel_code_type'),
            'sq_fpixel_custom_code': $this.find('div.sq_fpixel_custom_code'),

            'sq_post_id': ($this.find('input[name=sq_post_id]').length > 0 ? $this.find('input[name=sq_post_id]').val() : 0),
            'sq_term_id': ($this.find('input[name=sq_term_id]').length > 0 ? $this.find('input[name=sq_term_id]').val() : 0),
            'sq_taxonomy': ($this.find('input[name=sq_taxonomy]').length > 0 ? $this.find('input[name=sq_taxonomy]').val() : ''),
            'sq_post_type': ($this.find('input[name=sq_post_type]').length > 0 ? $this.find('input[name=sq_post_type]').val() : ''),

            'previewTab': $this.find('.sq_tab_preview'),
            'editTab': $this.find('.sq_tab_edit'),

            'validKeyword': false,
            '__sq_save_message': (typeof __sq_save_message !== 'undefined' ? __sq_save_message : 'Saved!'),
            '__sq_error_message': (typeof __sq_error_message !== 'undefined' ? __sq_error_message : 'ERROR! Could not save the data. Please try again.'),
            '__sq_save_message_preview': (typeof __sq_save_message_preview !== 'undefined' ? __sq_save_message_preview : 'Saved! Reload to see the changes.')

        }, options);


        /**
         * Remove the Wordpress Events and Add the Qss events
         */
        $this.initNav = function () {
            var $topmenu = $this.parents('.menupop:last');
            if ($topmenu.length > 0 && $this.data('snippet') === 'topmenu') {

                //remove the hover event from Wordpress
                $topmenu.off("hover");
                //check the top menu from Wordpress
                $topmenu.find('.ab-item').on("click", function () {
                    $topmenu.addClass('open');
                });
                settings.closeButton.on("click", function () {
                    $topmenu.removeClass('open');
                    $topmenu.removeClass('hover');
                });

                $topmenu.find('.sq_snippet_wrap').show();
            } else {//remove the hover event from Wordpress
                $this.off("hover");

                settings.closeButton.on("click", function () {
                    $this.hide();
                });

            }
        };

        /**
         * Listen the DOSEO button and hide the snippet option when needed
         */
        $this.listenDoSeo = function () {
            //Listen the DoSeo button
            settings.sq_doseo.on('change', function () {
                $this.saveSEO();
            });

            //Check if the SEO is activated for the current page
            if (!settings.sq_doseo.prop("checked")) {
                settings.previewTab.hide();
                settings.editTab.hide();
                settings.cancelButton.hide();
            } else {
                settings.previewTab.show();
                settings.editTab.hide();
            }

        };

        $this.tabsListen = function () {
            /* =========== Tabs ============= */
            $this.find('#sq_tabs').find('li').on('click', function (event) {
                event.preventDefault();

                $li = $(this);
                $this.find('#sq_tabs').find('li').each(function () {
                    $(this).removeClass('active');
                });
                $this.find('.sq_tabcontent').each(function () {
                    $(this).hide();
                });

                //settings.is_preview = false;
                //settings.previewButton.val("PREVIEW");
                $this.find('#sq_tab_' + $li.find('a').text().toString().toLowerCase()).show();
                $li.addClass('active');
            });
        };

        /**
         * Save the SEO into database
         * Send Sanitize and ajax to SQ_Settings
         */
        $this.saveSEO = function () {
            $this.preventLeave(false);
            $this.addClass('sq_minloading');
            var $sq_hash = $this.find('#sq_hash');
            if ($sq_hash.val() !== '') {

                //Remove the emoji image
                if (settings.sq_title.find('.emoji').length > 0) {
                    settings.sq_title.find('.emoji').after(settings.sq_title.find('.emoji').attr('alt')).remove();
                }
                if (settings.sq_description.find('.emoji').length > 0) {
                    settings.sq_description.find('.emoji').after(settings.sq_description.find('.emoji').attr('alt')).remove();
                }
                if (settings.sq_tw_title.find('.emoji').length > 0) {
                    settings.sq_tw_title.find('.emoji').after(settings.sq_tw_title.find('.emoji').attr('alt')).remove();
                }
                if (settings.sq_tw_description.find('.emoji').length > 0) {
                    settings.sq_tw_description.find('.emoji').after(settings.sq_tw_description.find('.emoji').attr('alt')).remove();
                }
                if (settings.sq_og_title.find('.emoji').length > 0) {
                    settings.sq_og_title.find('.emoji').after(settings.sq_og_title.find('.emoji').attr('alt')).remove();
                }
                if (settings.sq_og_description.find('.emoji').length > 0) {
                    settings.sq_og_description.find('.emoji').after(settings.sq_og_description.find('.emoji').attr('alt')).remove();
                }

                $.post(sqQuery.ajaxurl,
                    {
                        action: "sq_saveseo",
                        sq_title: settings.sq_title.length > 0 ? $this.escapeHtml(settings.sq_title.val()) : '',
                        sq_description: settings.sq_description.length > 0 ? $this.escapeHtml(settings.sq_description.val()) : '',
                        sq_keywords: settings.sq_keywords.length > 0 ? $this.escapeHtml(settings.sq_keywords.val()) : '',
                        sq_canonical: settings.sq_canonical.length > 0 ? $this.escapeHtml(settings.sq_canonical.val()) : '',
                        //
                        sq_noindex: $this.find('input[name=sq_noindex]:checked').length > 0 ? parseInt($this.find('input[name=sq_noindex]:checked').val()) : 1,
                        sq_nofollow: $this.find('input[name=sq_nofollow]:checked').length > 0 ? parseInt($this.find('input[name=sq_nofollow]:checked').val()) : 1,
                        sq_nositemap: $this.find('input[name=sq_nositemap]:checked').length > 0 ? parseInt($this.find('input[name=sq_nositemap]:checked').val()) : 1,
                        //
                        sq_tw_title: settings.sq_tw_title.length > 0 ? $this.escapeHtml(settings.sq_tw_title.val()) : '',
                        sq_tw_description: settings.sq_tw_description.length > 0 ? $this.escapeHtml(settings.sq_tw_description.val()) : '',
                        sq_tw_media: settings.sq_tw_media.length > 0 ? settings.sq_tw_media.val() : '',
                        sq_tw_type: settings.sq_tw_type.length > 0 ? settings.sq_tw_type.find('option:selected').val() : '',
                        //
                        sq_og_title: settings.sq_og_title.length > 0 ? $this.escapeHtml(settings.sq_og_title.val()) : '',
                        sq_og_description: settings.sq_og_description.length > 0 ? $this.escapeHtml(settings.sq_og_description.val()) : '',
                        sq_og_type: settings.sq_og_type.length > 0 ? settings.sq_og_type.find('option:selected').val() : '',
                        sq_og_author: settings.sq_og_author.length > 0 ? $this.escapeHtml(settings.sq_og_author.val()) : '',
                        sq_og_media: settings.sq_og_media.length > 0 ? settings.sq_og_media.val() : '',


                        sq_jsonld_code_type: (settings.sq_jsonld_code_type.length > 0) ? settings.sq_jsonld_code_type.find('option:selected').val() : 'auto',
                        sq_jsonld: (settings.sq_jsonld.length > 0 && settings.sq_jsonld_code_type.find('option:selected').val() === 'custom') ? settings.sq_jsonld.val() : '',
                        sq_fpixel_code_type: (settings.sq_fpixel_code_type.length > 0) ? settings.sq_fpixel_code_type.find('option:selected').val() : 'auto',
                        sq_fpixel: (settings.sq_fpixel.length > 0 && settings.sq_fpixel_code_type.find('option:selected').val() === 'custom') ? settings.sq_fpixel.val() : '',

                        //
                        // "sq_page_tw_media": _sq_page_tw_media,
                        sq_url: settings.sq_url.length > 0 ? $this.escapeHtml(settings.sq_url.val()) : '',
                        sq_hash: $sq_hash.val(),
                        //
                        post_id: settings.sq_post_id,
                        term_id: settings.sq_term_id,
                        taxonomy: settings.sq_taxonomy,
                        post_type: settings.sq_post_type,

                        sq_doseo: $this.find('input[name=sq_doseo]:checked').length > 0 ? parseInt($this.find('input[name=sq_doseo]:checked').val()) : 0,
                        sq_nonce: sqQuery.nonce
                    }, function () {
                    }
                ).done(function (response) {
                    $this.removeClass('sq_minloading');

                    if (typeof response.saved !== 'undefined') {
                        if (typeof response.html !== 'undefined') {
                            var $ctab = $this.find('.sq-nav-item.active');
                            $this.html(response.html);
                            $this.sq_editSnippet({'called': 'ajax'});
                            $this.find($ctab).trigger('click');

                            //Snippet is loaded. Let SLA know
                            $this.trigger('sq_snippet_loaded');
                            $this.trigger('sq_snippet_saved');
                            SQ_DEBUG && console.log('sq_snippet_loaded');
                            SQ_DEBUG && console.log('sq_snippet_saved');
                        } else {
                            $.sq_showError("Couldn't load the page. Please refresh.", 0);
                        }

                        if (typeof response.error !== 'undefined') {
                            $.sq_showError(response.error, 2000);
                        } else {
                            $.sq_showSaved(settings.__sq_save_message, 2000);
                        }
                    } else {
                        $.sq_showError(settings.__sq_error_message, 2000);
                    }
                }).fail(function () {
                    $this.removeClass('sq_minloading');
                    $.sq_showError(settings.__sq_error_message, 2000);
                });
            }
        };


        /**
         * Populates all titles and descriptions
         */
        $this.populateInputs = function () {
            var $title = $(document).find("head title").text();
            if (!$title) $title = '';

            var $description = $this.find('meta[name="description"]').attr('content');
            if (!$description) $description = '';

            /* Meta Inputs */
            if ($this.find('.sq_title').length > 0) {
                $this.find('.sq_title').each(function () {
                    $(this).sq_checkMax();
                });
            }
            if ($this.find('.sq_description').length > 0) {
                $this.find('.sq_description').each(function () {
                    $(this).sq_checkMax();
                });
            }

            if ($this.find('.sq_tab_facebook').find('.sq_deactivated').length > 0) {
                $this.find('.sq_tab_facebook').find('.sq_snippet_title').text($this.find('.sq_tab_meta').find('.sq_snippet_title').text());
                $this.find('.sq_tab_facebook').find('.sq_snippet_description').text($this.find('.sq_tab_meta').find('.sq_snippet_description').text());
            }

            if ($this.find('.sq_tab_twitter').find('.sq_deactivated').length > 0) {
                $this.find('.sq_tab_twitter').find('.sq_snippet_title').text($this.find('.sq_tab_meta').find('.sq_snippet_title').text());
                $this.find('.sq_tab_twitter').find('.sq_snippet_description').text($this.find('.sq_tab_meta').find('.sq_snippet_description').text());
            }

            if (settings.sq_og_media_preview && settings.sq_og_media.val() !== '') {
                settings.sq_og_media_preview.attr('src', settings.sq_og_media.val());
                settings.og_image_close.show();
            }

            settings.og_image_close.on('click', function () {
                settings.sq_og_media_preview.attr('src', '');
                settings.sq_og_media.val('');
                $(this).hide();
            });

            if (settings.sq_tw_media_preview && settings.sq_tw_media.val() !== '') {
                settings.sq_tw_media_preview.attr('src', settings.sq_tw_media.val());
                settings.tw_image_close.show();
            }

            settings.tw_image_close.on('click', function () {
                settings.sq_tw_media_preview.attr('src', '');
                settings.sq_tw_media.val('');
                $(this).hide();
            });

            settings.refreshButton.on('click', function () {
                $this.sq_loadSnippet();
            });


            $this.keywordsListen();

            //Listen the Edit Button
            settings.editButton.on('click', function () {
                settings.previewTab.hide();
                settings.editTab.show();

                //Listen the Cancel Button
                settings.cancelButton.on('click', function () {
                    settings.previewTab.show();
                    settings.editTab.hide();

                });

                //Add the pattens in the right side of the input/textarea
                if ($.isFunction($.fn.sq_patterns)) {
                    //call the patterns after save
                    $this.find('.sq_pattern_field').each(function () {
                        $(this).sq_patterns().init();
                    });
                }
            });


        };

        /**
         * Listen the Image Media from Wordpress
         */
        $this.mediaListen = function () {
            $this.find('.sq_get_og_media, .sq_get_tw_media').click(function (e) {

                e.preventDefault();

                var og_media = $(this).parents('.sq-row:last').find('.sq_og_media_preview');
                var og_media_close = $(this).parents('.sq-row:last').find('.sq_og_image_close');
                var tw_media = $(this).parents('.sq-row:last').find('.sq_tw_media_preview');
                var tw_media_close = $(this).parents('.sq-row:last').find('.sq_tw_image_close');

                var image_frame;
                if (image_frame) {
                    image_frame.open();
                }
                // Define image_frame as wp.media object
                image_frame = wp.media({
                    title: 'Select Media',
                    multiple: false,
                    library: {
                        type: 'image'
                    }
                });
                image_frame.on('close', function () {
                    // On close, get selections and save to the hidden input
                    // plus other AJAX stuff to refresh the image preview
                    var selection = image_frame.state().get('selection');
                    var gallery_ids = null;
                    var my_index = 0;
                    selection.each(function (attachment) {
                        gallery_ids = attachment['attributes']['url'];
                        my_index++;
                    });
                    if (og_media.length > 0 && gallery_ids !== null) {
                        settings.sq_og_media.val(gallery_ids);
                        og_media.attr('src', gallery_ids);
                        og_media_close.show();
                    }
                    if (tw_media.length > 0 && gallery_ids !== null) {
                        settings.sq_tw_media.val(gallery_ids);
                        tw_media.attr('src', gallery_ids);
                        tw_media_close.show();
                    }
                });
                image_frame.on('open', function () {
                    // On open, get the id from the hidden input
                    // and select the appropiate images in the media manager
                    var selection = image_frame.state().get('selection');
                });

                image_frame.open();
            });
        };

        //Init
        $this.dropDownListen = function () {
            var actionDivSelected, actionDiv, dropdown, input, next;

            settings.sq_toggle.on('click', function () {
                input = $(this);

                //Set the input to initial height on toggle actions
                input.css('height', 'auto');

                //Show the actions div at the proper position
                dropdown = input.parents('.sq-input-group:last').find(".sq-actions");
                if (dropdown.data('position') == 'small') {
                    dropdown.css('top', '35px');
                    dropdown.css('height', '36px');
                } else {
                    var dropdown_top = (input.height() + 20);
                    dropdown.css('top', dropdown_top + 'px');
                }
                actionDiv = dropdown.find(".sq-action");
                dropdown.show();

                //On Click on keyup, se the value
                actionDiv.on('click', function () {
                    if (typeof actionDivSelected !== 'undefined') {
                        var actionValue = actionDivSelected.find('.sq-value');
                    } else {
                        var actionValue = $(this).find('.sq-value');
                    }

                    //Set the selected action value in the input
                    if (typeof actionValue !== "undefined" && actionValue !== "") {
                        //Set the Value
                        input.val(actionValue.data('value'));

                        //trigger change for patterns
                        input.trigger('change');

                        //Check the text size
                        input.sq_checkMax();
                    }

                });

                //When write on field, hide toggle
                input.on('keyup', function () {
                    $(this).parents('.sq-input-group:last').find(".sq-actions").hide();
                });

                //On focus out, hide the actions div
                input.sq_bodyClick("click", function () {
                    $(this).parents('.sq-input-group:last').find(".sq-actions").hide();
                });
            });

            //Show Custom JSON-LD in JSON-LD Tab
            settings.sq_jsonld_code_type.on('change', function () {
                if (settings.sq_jsonld_code_type.find('option:selected').val() === 'custom') {
                    settings.sq_jsonld_custom_code.show();
                } else {
                    settings.sq_jsonld_custom_code.hide();
                }
            });

            //Show Custom Facebook Pixel in Tracking Tab
            settings.sq_fpixel_code_type.on('change', function () {
                if (settings.sq_fpixel_code_type.find('option:selected').val() === 'custom') {
                    settings.sq_fpixel_custom_code.show();
                } else {
                    settings.sq_fpixel_custom_code.hide();
                }
            });
        };

        $this.keywordsListen = function () {
            settings.sq_keywords.sqtagsinput('items');
        };

        $this.escapeHtml = function (text) {
            var map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };

            return text.toString().replace(/[&<>"']/g, function (m) {
                return map[m];
            });
        };

        $this.preventLeave = function (on) {
            //Only if there is outside th eeditor
            if ($('form#post').length == 0) {
                if (on) {
                    $(window).on('beforeunload', function () {
                        return confirm('You have unsave changes in Squirrly Snippet. Are you sure you want to proceed?');
                    });
                } else {
                    $(window).off('beforeunload');
                }
            }
        };


        //Initiate the Nav events
        $this.initNav();
        $this.listenDoSeo();

        // Uploading files
        $this.mediaListen();
        $this.tabsListen();
        $this.populateInputs();
        $this.dropDownListen();

        $this.find('input[type="text"], textarea').on('keyup paste', function () {
            $this.preventLeave(true);
            $(this).sq_checkMax();
        });

        settings.saveButton.on('click', function (event) {
            event.preventDefault();
            SQ_DEBUG && console.log('save');

            $this.preventLeave(false);
            $this.saveSEO();
        });

        if (typeof $.sq_blockseo !== 'undefined') {
            $.sq_blockseo.on('sq_seo_refresh', function () {
                settings.refreshButton.trigger('click');
            });
        }

        //If WP autosave
        $(document).on('after-autosave.update-post-slug', function (e, data) {
            $this.preventLeave(false);
        });

        //listen the Ajax Calls input fields
        if ($this.find('.sq_save_ajax').length > 0) {
            $this.find('.sq_save_ajax').find('input').on('change', function () {
                $(this).sq_ajaxSnippetListen();
            });
            $this.find('.sq_save_ajax').find('button').on('click', function () {
                $(this).sq_ajaxSnippetListen();
            });
        }


        return $this;
    };

    $.fn.sq_checkMax = function () {
        var $element = $(this);
        var $divwrap = $element.parents('.sq-input-group:last');
        var length = 0, patternslength = 0, elementwords = 0, words = 0, maxvalue = 300;
        var finalvalue = '';

        if (!$element.length > 0) return;

        //Get the words depending on the field
        if ($element.is('input, textarea')) {
            elementwords = finalvalue = $element.val();
        } else {
            elementwords = finalvalue = $element.html();
        }

        //Get the words length
        length = elementwords.length;

        //If the maxvalue is set
        if ($divwrap.find('.sq_length').length) {
            maxvalue = parseInt($divwrap.find('.sq_length').data('maxlength'));
        }

        //If patterns are activated
        if ($divwrap.hasClass('sq_pattern_field')) {
            var $patterns = $divwrap.find('.sq_pattern_list');
            words = elementwords.split(' ');
            if (words.length > 0) {
                for (var i = 0; i < words.length; i++) {
                    if ($patterns.find('li[data-pattern="' + words[i].replace(new RegExp('"', "g"), '') + '"]').length) {
                        //clear the patterns
                        elementwords = elementwords.replace(words[i], '');
                        elementwords = elementwords.replace('  ', ' ');
                        elementwords = elementwords.trim();

                        //Get the patterns value length
                        if ($patterns.find('li[data-pattern="' + words[i].replace(new RegExp('"', "g"), '') + '"]').data('value')) {
                            patternslength += $patterns.find('li[data-pattern="' + words[i].replace(new RegExp('"', "g"), '') + '"]').data('value').length;
                        }

                        //Get the final value without patterns
                        finalvalue = finalvalue.replace(new RegExp(words[i], "g"), $patterns.find('li[data-pattern="' + words[i].replace(new RegExp('"', "g"), '') + '"]').data('value'));
                    }
                }
                //Set the final length with patterns values
                length = elementwords.length + patternslength;
            }
        }

        //Set the final value to the field title
        $element.attr('title', finalvalue);

        //add the current value vs maxvalue
        $divwrap.find('.sq_length').text(length + '/' + maxvalue);

        //if the text is not in the optimal range
        if (length === 0 || length > maxvalue) {
            $element.attr('style', 'border: solid 1px red !important');
        } else {
            $element.attr('style', 'border: none !important');
        }
    };

    $.fn.sq_bodyClick = function (ename, cb) {
        return this.each(function () {
            var $this = $(this),
                self = this;

            $(document).on(ename, function sqtempo(e) {
                if (e.target !== self && !$.contains(self, e.target)) {
                    cb.apply(self, [e]);
                    $(document).off(ename, sqtempo);
                }
            });

            $this.on('keydown blur', function sqtabpress(e) {
                if (e.which === 9) {
                    cb.apply(self, [e]);
                    $this.off('keydown', sqtabpress);
                }
            });
        });
    };

    $.fn.toggleSwitch = function (checked) {
        var element = $(this);

        if ((element.prop('checked') && checked == false) || (!element.prop('checked') && checked == true)) {
            element.trigger('click');
        }
    };

    /**
     * Get the Snippet For a Post Type
     * @param post_id
     * @param post_type
     */
    $.fn.sq_getSnippet = function (post_id, term_id, taxonomy, post_type) {
        var $this = this;

        $this.addClass('sq_minloading');

        $.post(
            sqQuery.ajaxurl,
            {
                action: 'sq_getsnippet',
                post_id: post_id,
                term_id: term_id,
                taxonomy: taxonomy,
                post_type: post_type,
                sq_nonce: sqQuery.nonce
            }
        ).done(function (response) {
            if (typeof response !== 'undefined') {
                if (typeof response.html !== 'undefined') {
                    //make sure to close the tooltips
                    $('div.tooltip').hide();

                    $this.html(response.html);
                    $this.sq_editSnippet();

                    //Snippet is loaded. Let SLA know
                    $this.trigger('sq_snippet_loaded');
                    SQ_DEBUG && console.log('sq_snippet_loaded');
                } else {
                    $('#sq_blocksnippet').trigger('error.refresh');
                }

                if (typeof response.error !== 'undefined') {
                    $.sq_showError(response.error, 10000);
                }
            } else {
                $('#sq_blocksnippet').trigger('error.refresh');
                SQ_DEBUG && console.log('no data received');
            }

            $this.removeClass('sq_minloading');
        }).fail(function () {
            SQ_DEBUG && console.log('no data received');
            $('#sq_blocksnippet').trigger('error.refresh');

            $this.removeClass('sq_minloading');
        }, "json");
    };

    //get the snippet in settings and post editor
    $.fn.sq_previewSnippet = function (url, show_url) {
        var $this = this;

        if (typeof url === 'undefined') {
            url = '';
        }
        if (typeof show_url === 'undefined') {
            show_url = '';
        }
        $this.find('.sq_snippet_ul').addClass('sq_minloading');

        $this.find('.sq_snippet_title').html('');
        $this.find('.sq_snippet_url').html('');
        $this.find('.sq_snippet_description').html('');
        $this.find('.sq_snippet_keywords').hide();
        $this.find('.sq_snippet').show();
        $this.find('.sq_snippet_update').hide();
        $this.find('.sq_snippet_customize').hide();
        $this.find('.ogimage_preview').hide();

        setTimeout(function () {
            $.post(
                sqQuery.ajaxurl,
                {
                    action: 'sq_previewsnippet',
                    url: url,
                    sq_nonce: sqQuery.nonce
                }
            ).done(function (response) {
                $this.find('.sq_snippet_ul').removeClass('sq_minloading');
                $this.find('.sq_snippet_update').show();
                $this.find('.sq_snippet_customize').show();
                $this.find('.sq_snippet_keywords').show();
                $this.find('.ogimage_preview').show();
                if (response) {
                    $this.find('.sq_snippet_title').html(response.title);
                    if (show_url !== '')
                        $this.find('.sq_snippet_url').html('<a href="' + url + '" target="_blank">' + show_url + '</a>');
                    else
                        $this.find('.sq_snippet_url').html(response.url);

                    $this.find('.sq_snippet_description').html(response.description);
                }
            }).fail(function () {
                $this.find('.sq_snippet_ul').removeClass('sq_minloading');
                $this.find('.sq_snippet_update').show();
            }, 'json');
        }, 500);
    };

    /**
     * Listen if the call is made as ajax
     * @param obj
     */
    $.fn.sq_ajaxSnippetListen = function () {
        var $this = this;

        //Set params
        var $input = $('#' + $this.data('input'));
        var $confirm = $this.data('confirm');
        var $action = $this.data('action');
        var $name = $this.data('name');
        var $value = 0;

        if (!$input.length) {
            $input = $this; //set the current object as input
        }
        if (typeof $confirm !== 'undefined') {
            if (!confirm($confirm)) return;
        }

        if ($input.is('checkbox') && $input.is(":checked")) {
            $value = $input.val();
        } else if ($input.is('select')) {
            $value = $input.find('option:selected').val();
        } else if ($input.is('input')) {
            $value = $input.val();
        }

        $this.addClass('sq_minloading');

        if ($action !== '' && $value !== '') {
            $.post(
                sqQuery.ajaxurl,
                {
                    action: $action,
                    input: $name,
                    value: $value,
                    sq_nonce: sqQuery.nonce
                }
            ).done(function (response) {
                if (typeof response.data !== 'undefined') {
                    if (response.data === '') {
                        $('#wpbody-content').prepend('Saved');
                    } else {
                        $('#wpbody-content').prepend(response.data);
                    }
                    setTimeout(function () {
                        $this.removeClass('sq_minloading');

                        var $parent = $this.closest('div.sq_save_ajax').parent('div');
                        if ($parent.length > 0) {
                            $parent.find('.sq_deactivated_label').remove();
                            $parent.find('.sq_deactivated').removeClass('sq_deactivated');
                        } else {
                            location.reload();
                        }
                    }, 1000);
                } else if (typeof response.error !== 'undefined') {
                    $('body').prepend(response.error);
                    $this.removeClass('sq_minloading');

                }

            }).fail(function () {
                $this.removeClass('sq_minloading');
                location.reload();
            }, 'json');
        }

    };

    if (!$.sq_isGutenberg) {
        /**
         * Check if Gutenberg is active
         * @param inp
         * @return {boolean}
         */
        $.sq_isGutenberg = function (inp) {
            return (
                typeof window.wp !== "undefined" &&
                typeof wp.data !== "undefined" &&
                typeof wp.data.select("core/editor") !== "undefined" &&
                $.isFunction(wp.data.select("core/editor").getEditedPostAttribute)
            );
        };
    }

    $(document).ready(function () {
        //li id from topbar
        var $adminbar = $('#wp-admin-bar-sq_bar_menu');
        var $blocksnippet = false;
        var sq_snippet_tab = 'metas';

        if ($adminbar.length > 0) {
            //if snippet is loaded in frontend
            if ($adminbar.find('#sq_blocksnippet[data-snippet="topmenu"]').length) {
                $blocksnippet = $adminbar.find('#sq_blocksnippet');
                $blocksnippet.sq_loadSnippet();
            } else {

                //Snippet is loaded in backend
                if ($('#sq_blocksnippet[data-snippet!="topmenu"]').length) {
                    $blocksnippet = $('#sq_blocksnippet');

                    $adminbar.find('#wp-admin-bar-sq_bar_submenu').remove();
                    $adminbar.find('.ab-item').on("click", function () {
                        //Check if Gutenberg box croll
                        if ($('.edit-post-layout__content').length > 0) {
                            $('.edit-post-layout__content').scrollTop($('.edit-post-layout__content').scrollTop() + $blocksnippet.offset().top - 100);
                        } else {
                            $('html,body').scrollTop($blocksnippet.offset().top - 50);
                        }
                    });

                    $blocksnippet.addClass('sq_blocksnippet').addClass('sq-shadow-sm').addClass('sq-border-bottom');
                    $blocksnippet.find('.inside').show().sq_loadSnippet();

                }
            }

            if ($blocksnippet) {
                $blocksnippet.on('sq_snippet_loaded', function () {
                    $snippet = $(this);

                    $snippet.find('.sq-nav-item.sq-nav-link').on('click', function () {
                        sq_snippet_tab = $(this).data('category');
                    });

                    //Show the snippet menu
                    $snippet.find('.sq-nav-item').removeClass('active');
                    $snippet.find('.sq-tab-pane').removeClass('active');

                    var $tab = $snippet.find('.sq_snippet_menu').find('#sq-nav-item_' + sq_snippet_tab);
                    $tab.addClass('active');
                    $snippet.find($tab.attr('href')).addClass('active');
                });

                $blocksnippet.on('error.refresh', function () {
                    $.sq_showError("Couldn't load the page. <span class='sq_snippet_refresh' style='color: #0F75BC; cursor:pointer;'>Please refresh</span>.", 0);

                    $('.sq_snippet_refresh').on('click', function () {
                        $blocksnippet.sq_loadSnippet();
                    });
                    //
                });
            }
        }
    });


})(jQuery);