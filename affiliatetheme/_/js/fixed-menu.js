jQuery(document).ready(function ($) {
    var nav = $('#navigation');
    var posNav = nav.offset().top;
    var widthNav = nav.outerWidth();

    $(window).bind('scroll', function () {
        if ($(window).scrollTop() > posNav) {
            nav.addClass('fixed');
            nav.outerWidth(widthNav);
            $('.navbar.navbar-default').first().css('width', $('#header').outerWidth());
        } else {
            nav.removeClass('fixed');
        }
    });
});