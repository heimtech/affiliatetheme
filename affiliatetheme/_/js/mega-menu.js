jQuery(document).ready(function ($) {
    if ($(window).width() > 767) {
        $('.menu-item-has-children').mouseenter(function () {
            var dropdown = $(this).find('.dropdown-menu.mega-menu');
            var navbar = $('.navbar.navbar-default').first();
            if (navbar.attr('data-menu') === '1') {
                navbar = $('.footer-wrapper.footer-wrapper-nav').first();
            }

            var leftNavbar = navbar.offset().left + 1;
            leftNavbar = parseInt(leftNavbar);
            dropdown.offset({left: leftNavbar});
            navbar.css('width', $('#header').outerWidth());
            var widthNavbar = navbar.outerWidth();
            dropdown.css('width', widthNavbar);

            var children = $(this).find('ul li.dropdown-mega-menu');
            var heights = new Array();
            $.each(children, function (key, value) {
                heights.push(parseInt($(value).css('height')));
            });
            function descending(a, b) {
                return b - a;
            }
            heights.sort(descending);
            $.each(children, function (key, value) {
                $(value).css('height', heights[0]);
            });
        });
    }
});

