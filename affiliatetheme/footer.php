<?php
global $affiliseo_options;
$show_rss = $affiliseo_options['show_rss'];
$url_facebook = $affiliseo_options['url_facebook'];
$url_twitter = $affiliseo_options['url_twitter'];
$url_gplus = $affiliseo_options['url_gplus'];
$url_youtube = $affiliseo_options['url_youtube'];

global $has_price_comparison;
global $posSocialIcons;

$full_size_header = $affiliseo_options['full_size_header'];

if (has_nav_menu('nav_top')) :
    if ($affiliseo_options['layout_wrapper_background'] !== '1') :
        ?>
        </div>
        <?php
    endif;
endif;
if (trim($affiliseo_options['layout_wrapper_background']) !== '1' && trim($full_size_header) === '1') :
    ?>
    </div>
    <?php
endif;
?>
<footer class="<?php
if (trim($affiliseo_options['layout_wrapper_background']) !== '1') {
    echo 'custom-container ';
}
?>full-size" id="footer">
        <?php
        if (has_nav_menu('nav_top') || trim($full_size_header) === '1') :
            ?>
        <div class="footer-wrapper">
            <?php
        endif;
        ?>
        <div class="col3">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_left')) : endif; ?>
        </div>
        <div class="col6">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_middle')) : endif; ?>
        </div>
        <div class="col3 service">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_right')) : endif; ?>
            <?php
            if ($show_rss !== '1' || trim($url_facebook) !== '' || trim($url_twitter) !== '' || trim($url_gplus) !== '') :
                ?>
                <ul class="social-footer">
                    <?php
                    if (trim($posSocialIcons) === 'both' || trim($posSocialIcons) === 'bottom'):
                        if (trim($url_facebook) !== '' && !filter_var(trim($url_facebook), FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) :
                            ?>
                            <li>
                                <a href="<?php echo trim($url_facebook); ?>" title="<?php bloginfo('name'); ?> auf Facebook">
                                    <img src="<?php echo get_template_directory_uri(); ?>/_/img/facebook.png" alt="Facebook" width="29" height="29">
                                </a>
                            </li>
                            <?php
                        endif;
                        if (trim($url_gplus) !== '' && !filter_var(trim($url_gplus), FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) :
                            ?>
                            <li>
                                <a href="<?php echo trim($url_gplus); ?>" title="<?php bloginfo('name'); ?> auf Google+">
                                    <img src="<?php echo get_template_directory_uri(); ?>/_/img/gplus.png" alt="Google+" width="29" height="29">
                                </a>
                            </li>
                            <?php
                        endif;
                        if (trim($url_twitter) !== '' && !filter_var(trim($url_twitter), FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) :
                            ?>
                            <li>
                                <a href="<?php echo trim($url_twitter); ?>" title="<?php bloginfo('name'); ?> auf Twitter">
                                    <img src="<?php echo get_template_directory_uri(); ?>/_/img/twitter.png" alt="Twitter" width="29" height="29">
                                </a>
                            </li>
                            <?php
                        endif;
                        if (trim($url_youtube) !== '' && !filter_var(trim($url_youtube), FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) :
                            ?>
                            <li>
                                <a href="<?php echo trim($url_youtube); ?>" title="<?php bloginfo('name'); ?> auf Youtube">
                                    <img src="<?php echo get_template_directory_uri(); ?>/_/img/youtube.png" alt="Youtube" width="29" height="29">
                                </a>
                            </li>
                            <?php
                        endif;
                        if ($show_rss !== '1') :
                            ?>
                            <li>
                                <a href="<?php bloginfo('rss2_url'); ?>?post_type=produkt" title="Produkt-Feed">
                                    <i class="fa fa-rss-square fa-2x rss"></i>
                                </a>
                            </li>
                            <?php
                        endif;
                    endif;
                    ?>
                </ul>
                <?php
            endif;
            ?>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="full-size copyright text-center">
            <p>&copy; <?php echo date('Y'); ?> - <?php bloginfo('name'); ?> - Diese Seite läuft mit dem Affiliate Theme von <a href="http://affiliseo.de">affiliseo.de</a></p>
        </div>
        <?php
        if (has_nav_menu('nav_top') || trim($full_size_header) === '1') :
            ?>
        </div>
        <?php
    endif;
    ?>
</footer>
<?php
if (!has_nav_menu('nav_top')) :
    ?>
    </div>
    <?php
endif;
?>
<a href="<?php echo site_url(); ?>" id="blogurl" style="display: none;"></a>
<div id="debug-request"></div>
<?php wp_footer(); ?>
<script src="<?php echo get_template_directory_uri(); ?>/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bootstrap/js/bootstrap.min.js"></script>	
<script src="<?php echo get_template_directory_uri(); ?>/_/js/jquery.elevateZoom-3.0.8.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/_/js/scripts.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/_/js/jquery.flexslider-min.min.js"></script>

<?php
if (trim($affiliseo_options['use_mega_menu']) === '1') :
    ?>
    <script src="<?php echo get_template_directory_uri(); ?>/_/js/mega-menu.min.js"></script>
<?php else : ?>
    <script src="<?php echo get_template_directory_uri(); ?>/_/js/main-menu.min.js"></script>
<?php
endif;

global $device;
if (trim($affiliseo_options['fixed_menu']) !== '1'  && has_nav_menu('nav_main')) :
    ?>
    <script src="<?php echo get_template_directory_uri(); ?>/_/js/fixed-menu.min.js"></script>
    
    <?php
endif;


if ($has_price_comparison === 'true') :
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#price_comparison_link').click(function () {
                var a = $('#price_comparison_a');
                $('html, body').animate({
                    scrollTop: a.offset().top
                }, 750);
            });
            $(function () {
                var blogurl = $('#blogurl').attr('href');
                var post_id = $('#post-id').attr('data-id');
                $.ajax({
                    type: "GET",
                    data: {
                        post_id: post_id
                    },
                    dataType: "html",
                    url: blogurl + '/wp-content/themes/affiliatetheme/getProductPriceComparison.php',
                    success: function (data) {
                        var container = $('#data-price-comparison');
                        container.fadeOut(function () {
                            container.html(data);
                            container.fadeIn();
                        });
                    }
                });
            });
        });
    </script>
    <?php
endif;
$activate_pagespeed_scripts = '0';
if ($affiliseo_options['activate_pagespeed_scripts']) {
    $activate_pagespeed_scripts = $affiliseo_options['activate_pagespeed_scripts'];
}
if (trim($activate_pagespeed_scripts) === '1') :
    font_family_loader();    
endif;

$affiliseoHideBackToTop = get_theme_mod( 'affiliseo_hide_back_to_top', '' );
if(empty($affiliseoHideBackToTop)){
    ?>
    <script>
    jQuery(document).ready(function($){
    	initBackTotop();
    	
    });
    </script>
    <a href="#" class="back-to-top back-to-top-is-visible back-to-top-fade-out"><i class="fa fa-2x fa-angle-double-up"></i></a>
    <?php
}

?>

<?php
if ( !isset($affiliseo_options['disable_cookie_policy_function']) || $affiliseo_options['disable_cookie_policy_function'] != "1" ) {
    
    $asCookiePolicy = new AsCookiePolicy();
?>
<script>
    jQuery(document).ready(function($){
    	cookiePolicyElem = jQuery('#as-cookie-policy-bar');
        <?php
        echo $asCookiePolicy->writeCookiePolicyJsVars();
        ?>
        
        jQuery(document).on( 'click', '.cookie-policy-accept-button', function (e) {
            e.preventDefault();
            setCookiePolicyCookie();
        });
        displayCookiePolicy();
    	
    });
    </script>
<?php
    echo $asCookiePolicy->writeCookiePolicyBar();

}
?>


</body>
</html>