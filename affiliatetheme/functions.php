<?php
/**
 * AFFILISEO Framework Functions
 */
define('AFFILISEO_THEMENAME', 'AffiliateTheme');
define('AFFILISEO_THEMESHORTNAME', 'af');
define('AFFILISEO_THEMEOPTIONS', 'af');
define('THIRD', '_api');
define('APIURL', 'http://affiliseo.de/themelicensing');

// Folder shortcuts
define('AFFILISEO_LIBRARY', TEMPLATEPATH . '/library');
define('AFFILISEO_ADMIN', AFFILISEO_LIBRARY . '/admin');

// URI shortcuts
define('AFFILISEO_ADMIN_CSS', get_template_directory_uri() . '/library/admin/css', true);
define('AFFILISEO_ADMIN_IMAGES', get_template_directory_uri() . '/library/admin/images', true);
define('AFFILISEO_ADMIN_JS', get_template_directory_uri() . '/library/admin/js', true);

global $no_price_string;
$no_price_string = 'Preis nicht verfügbar';

function affiliatetheme_setup(){
    load_theme_textdomain( 'affiliatetheme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'affiliatetheme_setup' );

function useCustomJquery() {
    
    wp_deregister_script( 'jquery' );
    wp_deregister_script( 'jquery-migrate' );
    
    wp_register_script( 'jquery', get_template_directory_uri().'/_/js/jquery-3.1.1.min.js', array(), '3.1.1', false);
    wp_enqueue_script( 'jquery', false, array(), false, false );
    
    wp_register_script( 'jquery-migrate', get_template_directory_uri().'/_/js/jquery-migrate-3.0.0.min.js', array("jquery"), "3.0.0");
    wp_enqueue_script( 'jquery-migrate' );
}
add_action('wp_enqueue_scripts', 'useCustomJquery',1);




// Include required function files
require_once (AFFILISEO_ADMIN . '/start.php');
require_once (AFFILISEO_LIBRARY . '/stuff.php');
require_once (AFFILISEO_LIBRARY . '/unattach.php');
require_once (AFFILISEO_LIBRARY . '/nav-walker.php');
require_once (AFFILISEO_LIBRARY . '/customize.php');
require_once (AFFILISEO_LIBRARY . '/custom-fields.php');
require_once (AFFILISEO_LIBRARY . '/shortcodes.php');
require_once (AFFILISEO_LIBRARY . '/widgets.php');
require_once (AFFILISEO_LIBRARY . '/post-types.php');
require_once (AFFILISEO_LIBRARY . '/tinymce/shortcodes-generator.php');

require_once (AFFILISEO_LIBRARY . '/comparison/ComparisonAttributes.php');
require_once (AFFILISEO_LIBRARY . '/affiliatePartners/PriceComparison.php');
require_once (AFFILISEO_LIBRARY . '/TeaserSlider.php');
require_once (AFFILISEO_LIBRARY . '/AsCookiePolicy.php');

add_filter('acf/settings/path', 'my_acf_settings_path');

function my_acf_settings_path($path)
{
    $path = AFFILISEO_LIBRARY . '/acf/';
    return $path;
}

add_filter('acf/settings/dir', 'my_acf_settings_dir');

function my_acf_settings_dir($dir)
{
    $dir = get_template_directory_uri() . '/library/acf/';
    return $dir;
}

add_filter('acf/settings/show_admin', '__return_false');

include_once (AFFILISEO_LIBRARY . '/acf/acf.php');

require_once (AFFILISEO_LIBRARY . '/acf-fields.php');
require_once (AFFILISEO_LIBRARY . '/acf-pro-fields.php');
require_once (AFFILISEO_LIBRARY . '/acf-pro-output.php');
require_once (AFFILISEO_LIBRARY . '/product-reviews-output.php');
require_once (AFFILISEO_LIBRARY . '/font-awesome.php');
require_once (AFFILISEO_LIBRARY . '/generate-custom-shortcode.php');
require_once (AFFILISEO_LIBRARY . '/affiliatePartners/eBay/settings.php');
require_once (AFFILISEO_LIBRARY . '/affiliatePartners/tradedoubler/settings.php');
require_once (AFFILISEO_LIBRARY . '/affiliatePartners/zanox/settings.php');
require_once (AFFILISEO_LIBRARY . '/affiliatePartners/affilinet/settings.php');
require_once (AFFILISEO_LIBRARY . '/affiliatePartners/belboon/settings.php');
require_once (AFFILISEO_LIBRARY . '/affiliatePartners/amazon/settings.php');
require_once (AFFILISEO_LIBRARY . '/affiliatePartners/overview.php');
require_once (AFFILISEO_LIBRARY . '/theme_updates/theme-update-checker.php');
require_once (AFFILISEO_LIBRARY . '/theme_updates/updates.php');
require_once (AFFILISEO_LIBRARY . '/affiliatePartners/adminPagePriceComparison.php');
require_once (AFFILISEO_LIBRARY . '/taxonomies-images/taxonomies-images.php');
require_once (AFFILISEO_LIBRARY . '/manage_taxonomies/manage_taxonomies.php');
require_once (AFFILISEO_LIBRARY . '/comparison/adminMenu.php');

add_filter('term_description', 'shortcode_unautop');
add_filter('term_description', 'do_shortcode');

add_filter('admin_post_thumbnail_html', 'createUrlThumbnailHtml');

add_action('save_post', 'saveUrlThumbnailField', 10, 2);

add_filter('post_thumbnail_html', 'replaceUrlThumbnailHtml', 10, PHP_INT_MAX);

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
//add_filter( 'the_content', 'nl2br' );
//add_filter( 'the_excerpt', 'nl2br' );
remove_filter('the_content', 'wpautop', 1);
add_filter('the_content', 'wpautop' , 2);

// This line might not be present
add_filter( 'the_content', 'shortcode_unautop', 100 );
add_filter( 'the_excerpt', 'shortcode_unautop', 100 );
