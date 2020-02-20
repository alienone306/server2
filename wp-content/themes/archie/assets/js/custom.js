jQuery(document).ready(function($) {

/*------------------------------------------------
            DECLARATIONS
------------------------------------------------*/

    var loader = $('#loader');
    var loader_container = $('#preloader');
    var scroll = $(window).scrollTop();  
    var scrollup = $('.backtotop');
    var menu_toggle = $('.menu-toggle');
    var dropdown_toggle = $('.main-navigation button.dropdown-toggle');
    var nav_menu = $('.main-navigation ul.nav-menu');
    var post_height = $('.posts-wrapper article');
    var project_slider = $('#latest-projects article');
    var services_article = $('#our-services article');
    var client_testimonial_article = $('#client-testimonial .slick-item .client-content-wrapper');

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
        nav_menu.fadeToggle();
       $('.main-navigation').toggleClass('menu-open');
       $('.menu-overlay').toggleClass('active');
    });

    dropdown_toggle.click(function() {
        $(this).toggleClass('active');
       $(this).parent().find('.sub-menu').first().slideToggle();
    });

    $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            $('.main-navigation ul li.search-menu a').removeClass('search-active');
            $('.main-navigation #search').fadeOut();
        }
    });

    $(document).click(function (e) {
        var container = $("#masthead");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('#site-navigation').removeClass('menu-open');
            $('#primary-menu').hide();
            $('.menu-overlay').removeClass('active');
            $('.main-navigation ul li.search-menu a').removeClass('search-active');
            $('.main-navigation #search').fadeOut();
        }
    });


    $(".classic-menu .icon-search").click(function () {
        $('.classic-menu .search-form').fadeToggle();
    });

    if ($(window).width() > 1025) {  
        $(document).keyup(function(e) {
            if (e.keyCode === 27) {;
                $('.classic-menu .main-navigation .search-form').fadeOut();
            }
        });

         $(document).click(function (e) {
            var container = $("#masthead");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $('.classic-menu .main-navigation .search-form').fadeOut();
            }
        });
    }

/*--------------------------------------------------------
                Keyboard Navigation
----------------------------------------------------------*/
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
            SLICK SLIDER
------------------------------------------------*/

    $('#main-slider .main-slider-wrapper').slick();

    
    $('.project-slider').slick({
        responsive: [{
            breakpoint: 992,
                settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: false,
            }
        },
        {
            breakpoint: 767,
                settings: {
                slidesToShow: 1,
                arrows: false,
                dots: false,         
            }
        },
        {
            breakpoint: 567,
                settings: {
                slidesToShow: 1,
                arrows: false,
                dots: false,
            }
        }]
    });

   $(".testimonial-slider").slick({
        responsive: [{
            breakpoint: 1200,
                settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode:true,
            }
        },
        {
            breakpoint: 767,
                settings: {
                slidesToShow: 1,
                arrows: false,
                dots: false,
                centerMode:false,         
            }
        },
        {
            breakpoint: 567,
                settings: {
                slidesToShow: 1,
                arrows: true,
                dots: false,
                centerMode:false,  
            }
        }]
    });

    $('.logo-slider').slick({
        responsive: [
            {
                breakpoint: 1200,
                    settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 992,
                    settings: {
                    slidesToShow: 3,      
                }
            },
            {
                breakpoint: 599,
                    settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 380,
                    settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });
    
var tab_id = $(".testimonial-slider .slick-item.slick-current").attr('data-current');
$("#"+tab_id).fadeIn();

$(".testimonial-slider").on("afterChange", function (){
    var tab_id = $(".testimonial-slider .slick-item.slick-current").attr('data-current');
    $('.slick-content').hide();
    $("#"+tab_id).fadeIn();
});

$('.testimonial-slider .slick-item').click(function() {
    var tab_id = $(this).attr('data-current');
    $('.slick-content').hide();
    $("#"+tab_id).fadeIn();
});


/*------------------------------------------------
            MATCH HEIGHT
------------------------------------------------*/

    post_height.matchHeight();
    $('.match-height').matchHeight();   
    services_article.matchHeight();
    client_testimonial_article.matchHeight();



/*------------------------------------------------
            POPUP VIDEO
------------------------------------------------*/

    $(".popup-video").click(function (event) {
        event.preventDefault();
        $('#latest-video').addClass('active');
        $('#latest-video .widget.widget_media_video').fadeIn();
    });

    $("#latest-video .overlay").click(function() {
        $(".mejs-controls .mejs-playpause-button.mejs-pause button").trigger("click");
        $('#latest-video').removeClass('active');
        $('#latest-video .widget.widget_media_video').fadeOut();
    });


/*------------------------------------------------
                END JQUERY
------------------------------------------------*/

});