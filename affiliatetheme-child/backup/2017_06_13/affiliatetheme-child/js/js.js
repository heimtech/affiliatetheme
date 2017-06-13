jQuery(document).ready(function($) {

    var lAllImageCTO =  jQuery(".imageCTO");


    jQuery.each(lAllImageCTO, function(key, value) {

         var lURL = jQuery(this).find(".vc_btn3").attr('href');

        jQuery(this).click(function() {
            window.location.href = lURL;


        });
    });


	
});
