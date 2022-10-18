jQuery(document).ready(function ($) {

    $('.ireviews__item').matchHeight();

    $('.reviews-container').lightSlider({
        item: 2,
        pager: false,
        slideMargin: 50,
        controls: true,
        nextHtml: '<i class="fa fa-angle-right fa-2x" aria-hidden="true"></i>',
        prevHtml: '<i class="fa fa-angle-left fa-2x" aria-hidden="true"></i>',
        responsive: [
            {
                breakpoint: 767,
                    settings: {
                        item: 1
                    }
            }
        ]
    });


    $('.info-grid__single > div').matchHeight();

    $('.qa__section .qa__item').matchHeight();

    // Bootstrap menu magic
    $(window).resize(function() {
        if ($(window).width() < 768) {
            $(".dropdown-toggle").attr('data-toggle', 'dropdown');
        } else {
            $(".dropdown-toggle").removeAttr('data-toggle dropdown');
        }
    });

        $(window).resize(function() {
            if ($(window).width() < 1200) {
                $(".dropdown-toggle").attr('data-toggle', 'dropdown');
            } else {
                $(".dropdown-toggle").removeAttr('data-toggle dropdown');
            }
        });

    $(window).scroll(function(){
        if ($(window).scrollTop() >= 90) {
            $('.header').addClass('fixed-header');
        }
        else {
            $('.header').removeClass('fixed-header');
        }
    });
});