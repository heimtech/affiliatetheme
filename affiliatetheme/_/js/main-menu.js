jQuery(document).ready(function ($) {
    if ($(window).width() > 767) {
        var dropLeft;

        $('.dropleft-li').mouseenter(function () {
            dropLeft = $(this);
            var dropdown = $(this).find('.dropleft').first();
            dropdown.css('display', 'block');
            var topDropdown = $(this).offset().top;
            topDropdown = parseInt(topDropdown);
            var dropdownLink = $(this).find('a').first();
            var widthDropdownLink = dropdownLink.outerWidth();
            widthDropdownLink = parseInt(widthDropdownLink);
            var leftDropdown = $(this).offset().left;
            leftDropdown = parseInt(leftDropdown);
            leftDropdown += widthDropdownLink;
            var rightDropdown = leftDropdown + dropdown.outerWidth();
            if (rightDropdown > $(window).width()) {
                leftDropdown -= widthDropdownLink;
                leftDropdown -= dropdown.outerWidth();
                dropdown.offset({top: topDropdown - 9, left: leftDropdown});
            } else {
                dropdown.offset({top: topDropdown - 9, left: leftDropdown});
            }
            var parent = dropdown.parent().parent();
            parent.mouseleave(function () {
                mouseLeave();
            });
        });
        $('.dropleft-li').mouseleave(function () {
            dropLeft = $(this);
            mouseLeave();
        });
        function mouseLeave() {
            var dropdown = dropLeft.find('.dropleft').first();
            dropdown.css('display', 'none');
        }
    }
});