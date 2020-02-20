jQuery(document).ready(function($) {

/*------------------------------------------------
            DECLARATIONS
------------------------------------------------*/

    var loader              = $('#loader');
    var loader_container    = $('#preloader');
    var scroll              = $(window).scrollTop();  
    var scrollup            = $('.backtotop');
    var menu_toggle         = $('.menu-toggle');
    var dropdown_toggle     = $('button.dropdown-toggle');
    var nav_menu            = $('.main-navigation');
    var featured_slider     = $('.featured-slider');
    var client_slider       = $('.client-slider');
    var video_slider        = $('.video-slider');

/*------------------------------------------------
            PRELOADER
------------------------------------------------*/

    loader_container.delay(1000).fadeOut();
    loader.delay(1000).fadeOut("slow");

/*------------------------------------------------
            BACK TO TOP
------------------------------------------------*/

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            scrollup.css({bottom:"25px"});
        } 
        else {
            scrollup.css({bottom:"-100px"});
        }
    });

    scrollup.click(function() {
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });

/*------------------------------------------------
            MAIN NAVIGATION
------------------------------------------------*/

    menu_toggle.click(function(){
        nav_menu.slideToggle();
        $(this).toggleClass('active');
        $('.menu-overlay').toggleClass('active');
        $('.main-navigation').toggleClass('menu-open');
    });

    dropdown_toggle.click(function() {
        $(this).toggleClass('active');
       $(this).parent().find('.sub-menu').first().slideToggle();
    });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            $('.menu-sticky #masthead').addClass('nav-shrink');
        }
        else {
            $('.menu-sticky #masthead').removeClass('nav-shrink');
        }
    });

    $(document).click(function (e) {
        var container = $("#masthead");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            nav_menu.slideUp();
            $('.menu-toggle').removeClass('active');
            $('.menu-overlay').removeClass('active');
            $('.main-navigation').removeClass('menu-open');
        }
    });

    if( $(window).width() < 1024 ) {
        $( '#primary-menu > li:last-child' ).bind( 'keydown', function(e) {
            if( e.which === 9 ) {
                e.preventDefault();
                $('#masthead').find('.menu-toggle').focus();
            }
        });
    }
    else {
        $( '#primary-menu > li:last-child' ).unbind('keydown');
    }

    $(window).resize(function() { 
        if( $(window).width() < 1024 ) {
            $( '#primary-menu > li:last-child' ).bind( 'keydown', function(e) {
                if( e.which === 9 ) {
                    e.preventDefault();
                    $('#masthead').find('.menu-toggle').focus();
                }
            });
        }
        else {
            $( '#primary-menu > li:last-child' ).unbind('keydown');
        }
    });

/*------------------------------------------------
            Sliders
------------------------------------------------*/

featured_slider.slick();

client_slider.slick({
    customPaging : function(slider, i) {
        var thumb       = $(slider.$slides[i]).data('thumb');
        var title       = $(slider.$slides[i]).data('title');
        var position    = $(slider.$slides[i]).data('position');
        return '<div class="header-wrapper"><div class="featured-image"><img src="'+thumb+'"></div><header class="entry-header"><h2 class="entry-title">'+title+'</h2><p class="designation">'+position+'</p></header></div>';
    },
    responsive: [
    {
        breakpoint: 1200,
        settings: {
            slidesToShow: 1,
            dots: false
        }
    }
    ]
});

video_slider.slick();

$('.video-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
       $('.slick-current iframe').attr('src', $('.slick-current iframe').attr('src'));
});



/*------------------------------------------------
            Match Height
------------------------------------------------*/

$('.archive-blog-wrapper .post-wrapper').matchHeight();

/*------------------------------------------------
            Tabs
------------------------------------------------*/

$('.albums-wrapper article').click(function(event) {
    event.preventDefault();

    var tab_id = $(this).attr('data-tab');

    $('.albums-wrapper article').removeClass('active');
    $('.tab-content').removeClass('active');
    $('.tab-content').hide();
    $(this).addClass('active');
    $("#"+tab_id).show();

    var sounds = $('audio');
    for(i=0; i<sounds.length; i++) sounds[i].pause();

    $('#' + tab_id).find('audio')[0].play(); 

});


/*------------------------------------------------
            POPUP VIDEO
------------------------------------------------*/

    $(".featured-slider .play").click(function (event) {
        event.preventDefault();
        $('.popup .widget_media_video').fadeIn();
        $('.video-overlay').addClass('active');
    });

    $(document).click(function (e) {
        var container = $(".play,.popup .widget_media_video");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $(".popup .mejs-controls .mejs-playpause-button.mejs-pause button").trigger("click");
            $('.popup .widget_media_video').fadeOut();
            $('.video-overlay').removeClass('active');            
        }
    });


/*------------------------------------------------
                END JQUERY
------------------------------------------------*/

});