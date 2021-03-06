/**
 * Table of contents
 *
 * 1. Header
 * 2. Core
 * 3. Sidebar
 * 4. Footer
 * 5. Elements
 * 6. Other
 * 7. Plugins
 */

(function ($) {
    "use strict";
    $(document).on('ready', function () {

        /* -----------------------------------------------------------------------------

            1. HEADER

        ----------------------------------------------------------------------------- */

        /* -------------------------------------------------------------------------
            HEADER MENU
        ------------------------------------------------------------------------- */

        // Desktop / large screens
        $('.header-menu__item--dropdown .header-menu__submenu, .header-menu__item--megamenu .header-menu__submenu--level-0').each(function () {

            var $submenu = $(this),
                $parent = $(this).parent(),
                $link = $parent.find('> .header-menu__item-link');

            // Hover
            $parent.hover(function () {
                if ($.fn.lsvrLoreGetMediaQueryBreakpoint() > 1199) {
                    $parent.addClass('header-menu__item--hover');
                    $submenu.show();
                }
            }, function () {
                if ($.fn.lsvrLoreGetMediaQueryBreakpoint() > 1199) {
                    $parent.removeClass('header-menu__item--hover');
                    $submenu.hide();
                }
            });

            // Click
            $link.on('click touchstart', function () {
                if ($.fn.lsvrLoreGetMediaQueryBreakpoint() > 1199) {
                    if (!$parent.hasClass('header-menu__item--hover')) {

                        // Hide opened submenus
                        if ($submenu.parents('.header-menu__submenu').length < 1) {
                            $('.header-menu__item--hover').each(function () {
                                $(this).removeClass('header-menu__item--hover');
                                $(this).find('> .header-menu__submenu').hide();
                            });
                        }

                        // Show subemnu
                        $parent.addClass('header-menu__item--hover');
                        $submenu.show();

                        // Hide on click outside
                        $('html').on('touchstart', function (e) {
                            $parent.removeClass('header-menu__item--hover');
                            $submenu.hide();
                        });

                        // Disable link
                        $parent.on('click touchstart', function (e) {
                            e.stopPropagation();
                        });
                        return false;

                    }
                }
            });

        });

        // Mobile
        $('.header-menu__submenu').each(function () {

            var $submenu = $(this),
                $parent = $(this).parent();

            // Create toggles
            $parent.append('<button type="button" class="header-menu__item-toggle"><i class="header-menu__item-toggle-icon"></i></button>');
            var $toggle = $parent.find('> .header-menu__item-toggle');

            // Toggle
            $toggle.on('click', function () {
                $submenu.slideToggle(150);
                $(this).toggleClass('header-menu__item-toggle--active');
            });

            // Remove inline styles on screen transition
            $(document).on('lsvrLoreScreenTransition', function () {
                $toggle.removeClass('header-menu__item-toggle--active');
                $submenu.removeAttr('style');
            });

        });

        /* -------------------------------------------------------------------------
            HEADER SEARCH
        ------------------------------------------------------------------------- */

        $('.header-search-form').each(function () {

            var $form = $(this),
                $input = $form.find('.header-search-form__input'),
                $panel = $form.find('.header-search-form__panel'),
                $keywords = $form.find('.header-search-form__keywords'),
                $filter = $form.find('.header-search-form__filter'),
                location = $form.parents('.header-search').length > 0 ? 'header' : 'navbar';

            // Ajax suggested keywords
            if ($form.hasClass('header-search-form--ajax')) {
                $keywords.find('a').each(function () {
                    $(this).on('click', function () {
                        $input.val($(this).data('search-keyword')).focus();
                        return false;
                    });
                });
            }

            // Toggle panel
            if ('header' === location) {

                // Show panel on focus
                $input.on('focus', function () {
                    $panel.slideDown(150);
                });

                // Hide panel on out
                $(document).on('click', function (e) {
                    if (!$(e.target).closest('.header-search-form').length) {
                        $panel.slideUp(150);
                    }
                });

            }

            // Search filter
            var refreshSearchFilter = function (checkbox) {

                if (true === checkbox.prop('checked') || 'checked' === checkbox.prop('checked')) {

                    checkbox.parent().addClass('header-search-form__filter-label--active');

                    // Filter all
                    if (checkbox.hasClass('header-search-form__filter-checkbox--any')) {
                        $filter.find('.header-search-form__filter-checkbox:not( .header-search-form__filter-checkbox--any )').prop('checked', false).change();
                    }

                    // Filter others
                    else {
                        $filter.find('.header-search-form__filter-checkbox--any').prop('checked', false).change();
                    }

                } else {

                    checkbox.parent().removeClass('header-search-form__filter-label--active');

                    // Filter All if there is not other filter active
                    if ($filter.find('.header-search-form__filter-checkbox:checked').length < 1) {
                        $filter.find('.header-search-form__filter-checkbox--any').prop('checked', true).change();
                    }

                }

            };
            $filter.find('.header-search-form__filter-checkbox').each(function () {
                refreshSearchFilter($(this));
                $(this).on('change', function () {
                    refreshSearchFilter($(this));
                });
            });

        });

        /* -------------------------------------------------------------------------
            HEADER NAVBAR SEARCH
        ------------------------------------------------------------------------- */

        $('.header-navbar-search').each(function () {

            var $this = $(this),
                $toggle = $this.find('.header-navbar-search__toggle'),
                $form = $this.find('.header-navbar-search__form'),
                $input = $this.find('.header-search-form__input');

            // Toggle
            $toggle.on('click', function () {
                $toggle.toggleClass('header-navbar-search__toggle--active');
                $form.slideToggle(200, function () {

                    if ($input.is(':visible')) {
                        $input.focus();
                        $(window).on('click', closeForm);
                    }

                });
            });

            // Hide on click outside
            var closeForm = function () {

                $toggle.removeClass('header-navbar-search__toggle--active');
                $form.slideUp(200);

                // Unbind closeList event
                $(window).unbind('click', closeForm);

            };
            $this.on('click', function (e) {
                e.stopPropagation();
            });

            // Set to default state on screen transition
            $(document).on('lsvrLoreScreenTransition', function () {
                $form.removeAttr('style');
                $toggle.removeClass('header-navbar-search__toggle--active');
            });

        });

        /* -------------------------------------------------------------------------
            STICKY NAVBAR
        ------------------------------------------------------------------------- */

        $('.header--sticky').each(function () {

            var $header = $(this),
                $navbar = $header.find('.header-navbar'),
                $placeholder = $header.find('.header-navbar__placeholder'),
                placeholderHeight = $placeholder.height(),
                navbarHeight = $navbar.height();

            // Set placeholder height
            if (Math.abs(placeholderHeight - navbarHeight) > 5) {
                $placeholder.css('height', $navbar.height());
            }

            // Initial state
            if ($(document).scrollTop() >= 5) {
                $navbar.addClass('header-navbar--scrolled');
            }

            // On scroll
            $(document).scroll(function () {
                if ($.fn.lsvrLoreGetMediaQueryBreakpoint() > 1199) {
                    $navbar.toggleClass('header-navbar--scrolled', $(document).scrollTop() >= 5);
                }
            });

        });

        /* -------------------------------------------------------------------------
            HEADER NAVBAR TOGGLE
        ------------------------------------------------------------------------- */

        $('.header-navbar').each(function () {

            var $this = $(this),
                $header = $('#header'),
                $navigation = $this.find('.header-navbar__navigation'),
                $search = $('.header-search'),
                $toggle = $this.find('.header-navbar__toggle');

            $toggle.on('click', function () {
                $toggle.toggleClass('header-navbar__toggle--active');
                $header.toggleClass('header--expanded');
                $navigation.slideToggle();
                $search.slideToggle();
            });

            // Set to default state on screen transition
            $(document).on('lsvrLoreScreenTransition', function () {
                $toggle.removeClass('header-navbar__toggle--active');
                $header.removeClass('header--expanded');
                $navigation.removeAttr('style');
                $search.removeAttr('style');
            });

        });


        /* -----------------------------------------------------------------------------

            2. CORE

        ----------------------------------------------------------------------------- */

        /* -------------------------------------------------------------------------
            KNOWLEDGE BASE
        ------------------------------------------------------------------------- */

        // Category view archive masonry
        if ($.fn.masonry && $.fn.imagesLoaded) {
            $('.lsvr_kba-post-archive .post-archive__list--masonry').each(function () {

                var $this = $(this),
                    isRTL = $('html').attr('dir') && 'rtl' === $('html').attr('dir') ? true : false;

                // Wait for images to load
                $this.imagesLoaded(function () {
                    $this.masonry({
                        isRTL: isRTL
                    });
                });

            });
        }

        /* -------------------------------------------------------------------------
            FAQ
        ------------------------------------------------------------------------- */

        // Expandable posts in archive
        $('.lsvr_faq-post-archive--is-expandable .post-archive__list > .post').each(function () {

            var $this = $(this),
                $parent = $this.parent(),
                $header = $this.find('.post__header'),
                $content = $this.find('.post__content-wrapper');

            // Toggle
            $header.on('click', function () {
                $content.slideToggle(200);
                $this.toggleClass('post--expanded');
            });

        });


        /* -----------------------------------------------------------------------------

            3. SIDEBAR

        ----------------------------------------------------------------------------- */

        /* -------------------------------------------------------------------------
            LSVR KB Tree
        ------------------------------------------------------------------------- */

        $('.lsvr_kba-tree-widget').each(function () {

            var $this = $(this),
                $list = $this.find('.lsvr_kba-tree-widget__list--level-0');

            // Load JS labels
            if ('undefined' !== typeof lsvr_lore_js_labels && lsvr_lore_js_labels.hasOwnProperty('expand') && lsvr_lore_js_labels.hasOwnProperty('collapse')) {
                var expandLabel = lsvr_lore_js_labels.expand;
                var collapseLabel = lsvr_lore_js_labels.collapse;
            } else {
                var expandLabel = 'Expand';
                var collapseLabel = 'Collapse';
            }

            // Set ancestor classes
            $this.find('.lsvr_kba-tree-widget__item--current').each(function () {
                $(this).parents('.lsvr_kba-tree-widget__item').addClass('lsvr_kba-tree-widget__item--current-ancestor');
            });

            // Set parents
            $this.find('.lsvr_kba-tree-widget__list').each(function () {
                $(this).parent('.lsvr_kba-tree-widget__item').addClass('lsvr_kba-tree-widget__item--has-children');
            });

            // Add toggle button
            $this.find('.lsvr_kba-tree-widget__item--has-children:not( .lsvr_kba-tree-widget__item--current-ancestor, .lsvr_kba-tree-widget__item--current )').each(function () {
                $(this).find('> .lsvr_kba-tree-widget__item-inner > .lsvr_kba-tree-widget__item-link-wrapper').append('<button type="button" class="lsvr_kba-tree-widget__item-toggle" aria-expanded="false" aria-label="' + expandLabel + '"><i class="lsvr_kba-tree-widget__item-toggle-icon"><i></button>');
            });

            // Toggle action
            $this.find('.lsvr_kba-tree-widget__item--has-children').each(function () {

                var $toggle = $(this).find('> .lsvr_kba-tree-widget__item-inner .lsvr_kba-tree-widget__item-toggle'),
                    $children = $(this).find('> .lsvr_kba-tree-widget__list');

                $toggle.on('click', function () {

                    $children.slideToggle(150);
                    $(this).toggleClass('lsvr_kba-tree-widget__item-toggle--active');

                    if ($(this).hasClass('lsvr_kba-tree-widget__item-toggle--active')) {
                        $(this).attr('aria-expanded', 'true');
                        $(this).attr('aria-label', collapseLabel);
                    } else {
                        $(this).attr('aria-expanded', 'false');
                        $(this).attr('aria-label', expandLabel);
                    }

                });

            });

        });


        /* -----------------------------------------------------------------------------

            4. FOOTER

        ----------------------------------------------------------------------------- */

        // Back to top
        $('.footer-scroll-top').on('click', function () {

            $('html, body').animate({
                'scrollTop': 0
            }, 200);

            return false;

        });


        /* -----------------------------------------------------------------------------

            5. ELEMENTS

        ----------------------------------------------------------------------------- */

        /* -------------------------------------------------------------------------
            FAQ
        ------------------------------------------------------------------------- */

        $('.lsvr-lore-faq .lsvr-lore-faq__post').each(function () {

            var $this = $(this),
                $header = $this.find('.lsvr-lore-faq__post-header'),
                $wrapper = $this.find('.lsvr-lore-faq__post-content-wrapper');

            // Toggle
            $header.on('click', function () {
                $wrapper.slideToggle(200);
                $this.toggleClass('lsvr-lore-faq__post--expanded');
            });

        });

        /* -------------------------------------------------------------------------
            KNOWLEDGE BASE
        ------------------------------------------------------------------------- */

        // Masonry
        if ($.fn.masonry && $.fn.imagesLoaded) {
            $('.lsvr-lore-knowledge-base--masonry .lsvr-lore-knowledge-base__list').each(function () {

                var $this = $(this),
                    isRTL = $('html').attr('dir') && 'rtl' === $('html').attr('dir') ? true : false;

                // Wait for images to load
                $this.imagesLoaded(function () {
                    $this.masonry({
                        isRTL: isRTL
                    });
                });

            });
        }

        /* -------------------------------------------------------------------------
            SIDEBAR
        ------------------------------------------------------------------------- */

        // Masonry
        if ($.fn.masonry && $.fn.imagesLoaded) {
            $('.lsvr-lore-sidebar--masonry .lsvr-lore-sidebar__list').each(function () {

                var $this = $(this),
                    isRTL = $('html').attr('dir') && 'rtl' === $('html').attr('dir') ? true : false;

                // Wait for images to load
                $this.imagesLoaded(function () {
                    $this.masonry({
                        isRTL: isRTL
                    });
                });

            });
        }

        /* -------------------------------------------------------------------------
            SITEMAP
        ------------------------------------------------------------------------- */

        // Masonry
        if ($.fn.masonry && $.fn.imagesLoaded) {
            $('.lsvr-lore-sitemap--masonry .lsvr-lore-sitemap__list').each(function () {

                var $this = $(this),
                    isRTL = $('html').attr('dir') && 'rtl' === $('html').attr('dir') ? true : false;

                // Wait for images to load
                $this.imagesLoaded(function () {
                    $this.masonry({
                        isRTL: isRTL
                    });
                });

            });
        }

        /* -------------------------------------------------------------------------
            TABLE OF CONTENTS
        ------------------------------------------------------------------------- */

        $('.lsvr-lore-toc').each(function () {

            var $this = $(this),
                $content = $this.find('.lsvr-lore-toc__content'),
                $spinner = $this.find('.lsvr-lore-toc__spinner'),
                $postContent = $this.parents('.post__content'),
                headings,
                list = '';

            // Get all headings
            headings = $postContent.find('h1[id], h2[id], h3[id], h4[id], h5[id], h6[id]');

            // Parse headings
            if (headings.length > 0) {

                headings.each(function () {
                    list += '<li class="lsvr-lore-toc__item lsvr-lore-toc__item--' + $(this).prop('tagName').toLowerCase() + '"><a href="#' + $(this).prop('id') + '" class="lsvr-lore-toc__item-link">' + $(this).text() + '</a></li>';
                });

                $content.removeClass('lsvr-lore-toc__content--loading');
                $content.html('<ul class="lsvr-lore-toc__list">' + list + '</ul>');

            }

            // No headings, hide the TOC
            else {

                $this.slideUp(200);

            }

        });


        /* -----------------------------------------------------------------------------

            6. OTHER

        ----------------------------------------------------------------------------- */

        /* -------------------------------------------------------------------------
            ANCHOR SCROLL ANIMATION
        ------------------------------------------------------------------------- */

        $('.lsvr-lore-toc__item-link, .header-menu__item-link[href^="#"], .footer-menu a[href^="#"]').each(function () {

            var $this = $(this),
                href = $(this).attr('href'),
                id = href.substr(href.indexOf('#'));

            if ($(id).length > 0) {

                $this.on('click', function (e) {

                    var offset = $.fn.lsvrLoreGetMediaQueryBreakpoint() > 991 && $('#header').hasClass('header--sticky') ? 100 : 0;

                    $('html, body').animate({
                        'scrollTop': $(id).offset().top - offset
                    }, 200);

                    return false;

                });

            }

        });

        /* -------------------------------------------------------------------------
            MAGNIFIC POPUP
        ------------------------------------------------------------------------- */

        if ($.fn.magnificPopup) {

            // Lightbox config
            if ('undefined' !== typeof lsvr_lore_js_labels && lsvr_lore_js_labels.hasOwnProperty('magnific_popup')) {

                var js_strings = lsvr_lore_js_labels.magnific_popup;
                $.extend(true, $.magnificPopup.defaults, {
                    tClose: js_strings.mp_tClose,
                    tLoading: js_strings.mp_tLoading,
                    gallery: {
                        tPrev: js_strings.mp_tPrev,
                        tNext: js_strings.mp_tNext,
                        tCounter: '%curr% / %total%'
                    },
                    image: {
                        tError: js_strings.mp_image_tError,
                    },
                    ajax: {
                        tError: js_strings.mp_ajax_tError,
                    }
                });

            }

            // Init lightbox
            $('.lsvr-open-in-lightbox, .gallery .gallery-item a, .wp-block-gallery .blocks-gallery-item a').magnificPopup({
                type: 'image',
                removalDelay: 300,
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true
                }
            });

        }


        /* -------------------------------------------------------------------------
        MEDIA QUERY BREAKPOINT
    ------------------------------------------------------------------------- */

        if (!$.fn.lsvrLoreGetMediaQueryBreakpoint) {
            $.fn.lsvrLoreGetMediaQueryBreakpoint = function () {

                if ($('#lsvr-media-query-breakpoint').length < 1) {
                    $('body').append('<span id="lsvr-media-query-breakpoint" style="display: none;"></span>');
                }
                var value = $('#lsvr-media-query-breakpoint').css('font-family');
                if (typeof value !== 'undefined') {
                    value = value.replace("\"", "").replace("\"", "").replace("\'", "").replace("\'", "");
                }
                if (isNaN(value)) {
                    return $(window).width();
                } else {
                    return parseInt(value);
                }

            };
        }

        var lsvrLoreMediaQueryBreakpoint;
        if ($.fn.lsvrLoreGetMediaQueryBreakpoint) {
            lsvrLoreMediaQueryBreakpoint = $.fn.lsvrLoreGetMediaQueryBreakpoint();
            $(window).resize(function () {
                if ($.fn.lsvrLoreGetMediaQueryBreakpoint() !== lsvrLoreMediaQueryBreakpoint) {
                    lsvrLoreMediaQueryBreakpoint = $.fn.lsvrLoreGetMediaQueryBreakpoint();
                    $.event.trigger({
                        type: 'lsvrLoreScreenTransition',
                        message: 'Screen transition completed.',
                        time: new Date()
                    });
                }
            });
        } else {
            lsvrLoreMediaQueryBreakpoint = $(document).width();
        }


        // Trigger search
        $('.header-search-form--ajax').each(function () {

            var $form = $(this),
                $input = $form.find('.header-search-form__input'),
                $filter = $form.find('.header-search-form__filter'),
                $submit = $form.find('.header-search-form__submit'),
                searchQuery = '',
                postType,
                postTypeArr = [];

            // Post type filter
            $filter.find('.header-search-form__filter-checkbox:checked').each(function () {
                postTypeArr.push($(this).val());
            });
            postType = postTypeArr.length < 1 ? 'any' : postTypeArr.join();
            postTypeArr = [];

            // Change, keyup & paste events
            $input.on('change keyup paste', function (e) {

                var newSearchQuery = $(this).val();
                if ((newSearchQuery !== searchQuery) && !(38 === e.which || 40 === e.which || 13 === e.which)) {
                    searchQuery = newSearchQuery.trim();
                    getResults($form, postType, searchQuery);
                }

            });

            $submit.on('click', function (e) {

                var newSearchQuery = $input.val();
                if ((newSearchQuery !== searchQuery)) {
                    searchQuery = newSearchQuery.trim();
                    getResults($form, postType, searchQuery);
                }

            });

            // Focus event
            $input.on('focus', function (e) {

                var newSearchQuery = $(this).val();

                // Show already existing but hidden search results
                if ((newSearchQuery === searchQuery) && $form.find('.header-search-form__results').length > 0) {
                    $form.find('.header-search-form__results').slideDown(300);
                }

                // If there are no results, send request
                else {
                    searchQuery = newSearchQuery.trim();
                    getResults($form, postType, searchQuery);
                }

            });

            // Change post type filter
            $filter.find('.header-search-form__filter-checkbox').on('change', function () {

                $filter.find('input:checked').each(function () {
                    postTypeArr.push($(this).val());
                });
                postType = postTypeArr.length < 1 ? 'any' : postTypeArr.join();
                postTypeArr = [];

                getResults($form, postType, searchQuery);

            });

            // Keyboard navigation
            $input.on('keydown', function (e) {

                var $searchResults = $form.find('.header-search-form__results'),
                    $active = $searchResults.find('.header-search-form__results-item--active');

                // Arrow down
                if (40 === e.which) {

                    if ($active.length < 1 || $active.filter(':last-child').length) {
                        $active.removeClass('header-search-form__results-item--active');
                        $searchResults.find('.header-search-form__results-item:first-child').addClass('header-search-form__results-item--active');
                    } else {
                        $active.removeClass('header-search-form__results-item--active');
                        $active.next().addClass('header-search-form__results-item--active');
                    }

                    e.preventDefault();
                    e.stopPropagation();

                }

                // Arrow up
                if (38 === e.which) {

                    if ($active.length < 1 || $active.filter(':first-child').length) {
                        $active.removeClass('header-search-form__results-item--active');
                        $searchResults.find('.header-search-form__results-item:last-child').addClass('header-search-form__results-item--active');
                    } else {
                        $active.removeClass('header-search-form__results-item--active');
                        $active.prev().addClass('header-search-form__results-item--active');
                    }

                    e.preventDefault();
                    e.stopPropagation();

                }

                // Enter
                if (13 === e.which) {

                    e.preventDefault();
                    e.stopPropagation();

                    var newSearchQuery = $input.val();
                    if ((newSearchQuery !== searchQuery)) {
                        searchQuery = newSearchQuery.trim();
                        getResults($form, postType, searchQuery);
                    }

                }

            });

        });

        // Get search results
        var ajaxRequest = null;

        function getResults($form, postType, searchQuery) {

            searchQuery = searchQuery.trim();

            // Check minimum search query length
            if (searchQuery.length > 1) {

                // Delay before sending request
                clearTimeout($form.data('ajax-search-timer'));
                $form.data('ajax-search-timer', setTimeout(function () {

                    $form.addClass('header-search-form--loading');
                    $form.find('.header-search-form__spinner').fadeIn(150);

                    // Ajax request
                    if (null !== ajaxRequest) {
                        ajaxRequest.abort();
                    }
                    ajaxRequest = $.post(
                        sqQuery.ajaxurl,
                        {
                            action: 'sq_ajax_search',
                            search_query: searchQuery,
                            sq_nonce: sqQuery.nonce

                        }
                    ).done(function (response) {

                        if ('' !== response) {

                            var responseJson = false;

                            // Parse JSON
                            try {
                                responseJson = JSON.parse(response);
                            }

                                // Invalid response
                            catch (e) {
                                console.log('Ajax Search Response: INVALID JSON');
                            }

                            // Show results
                            if (responseJson) {
                                showResults($form, responseJson);
                            }

                        } else {
                            console.log('Ajax Search Response: BLANK');
                        }

                        $form.removeClass('header-search-form--loading');
                        $form.find('.header-search-form__spinner').fadeOut(150);

                    }).fail(function () {
                        $form.removeClass('header-search-form--loading');
                        $form.find('.header-search-form__spinner').fadeOut(150);
                        console.log('Ajax Search Response: ERROR');
                    });

                }, 500));

            }

        }

        // Show search results
        function showResults($form, json) {
            if (json.hasOwnProperty('status')) {

                var status = json.status,
                    $input = $form.find('.header-search-form__input'),
                    output = '';

                // If has results
                if ('ok' === status && json.hasOwnProperty('results')) {

                    $.each(json.results, function () {

                        if (this.hasOwnProperty('post_title') && this.hasOwnProperty('permalink') &&
                            this.hasOwnProperty('post_type')) {

                            output += '<li class="header-search-form__results-item header-search-form__results-item--' + this.post_type + '">';
                            output += '<i class="fa ' + (this.post_type === 'lsvr_kba' ? 'fa-book' : (this.post_type === 'lsvr_faq' ? 'fa-question' : 'fa-file-o')) + ' float-left m-2"></i>';
                            output += '<a href="' + this.permalink + '" class="header-search-form__results-item-link" target="_blank">' + this.post_title + '</a>';

                            // Likes
                            if (json.hasOwnProperty('rating_type') && 'likes' === json.rating_type && this.hasOwnProperty('post_type')
                                && this.hasOwnProperty('rating_likes_abb')) {

                                output += '<span class="header-search-form__results-item-rating c-post-rating">';
                                output += '<span class="c-post-rating__likes"><i class="fa fa-thumbs-up"></i> ' + this.rating_likes_abb + '</span>';
                                output += '</span>';

                            }

                            // Dislikes
                            else if (json.hasOwnProperty('rating_type') && 'both' === json.rating_type
                                && this.hasOwnProperty('rating_likes_abb') && this.hasOwnProperty('rating_dislikes_abb')) {

                                output += '<span class="header-search-form__results-item-rating c-post-rating">';
                                output += '<span class="c-post-rating__likes">' + this.rating_likes_abb + '</span>';
                                output += '<span class="c-post-rating__dislikes">' + this.rating_dislikes_abb + '</span>';
                                output += '</span>';

                            }

                            // Sum
                            else if (json.hasOwnProperty('rating_type') && 'sum' === json.rating_type
                                && this.hasOwnProperty('rating_sum_abb') && this.hasOwnProperty('rating_sum')) {

                                output += '<span class="header-search-form__results-item-rating c-post-rating">';

                                if (parseInt(this.rating_sum) >= 0) {

                                    output += '<span class="c-post-rating__sum c-post-rating__sum--positive">' + this.rating_sum_abb + '</span>';

                                } else {

                                    output += '<span class="c-post-rating__sum c-post-rating__sum--negative">' + this.rating_sum_abb + '</span>';

                                }

                                output += '</span>';

                            }

                            output += '</li>';

                        }

                    });
                    output = '<ul class="header-search-form__results-list">' + output + '</ul>';

                    // More link
                    if (json.hasOwnProperty('more_label') && json.hasOwnProperty('more_link')) {
                        output += '<p class="header-search-form__results-more">';
                        output += '<a href="' + json.more_link + '" class="header-search-form__results-more-link"target="_blank">' + json.more_label + '</a></p>';
                    }

                }

                // No results
                else if ('noresults' === status) {
                    var message = json.hasOwnProperty('message') ? json.message : '';
                    if ('' !== message) {
                        output = '<p class="header-search-form__results-message">' + message + '</p>';
                    }
                }

                // Display results
                if ('' !== output) {

                    if ($form.find('.header-search-form__results').length > 0) {
                        $form.find('.header-search-form__results').first().html(output);
                    } else {
                        $form.find('.header-search-form__panel-inner').append('<div class="header-search-form__results">' + output + '</div>');
                    }
                    if ($form.find('.header-search-form__results').is(':hidden')) {
                        $form.find('.header-search-form__results').slideDown(300);
                    }

                }

            }
        }
    });
})(jQuery);