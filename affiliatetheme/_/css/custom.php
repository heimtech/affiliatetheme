<?php
define( 'WP_USE_THEMES', false );
require_once('../../../../../wp-load.php');
header( 'Content-Type: text/css; charset=utf-8' );

$iPod = stripos( $_SERVER['HTTP_USER_AGENT'], "iPod" );
$iPhone = stripos( $_SERVER['HTTP_USER_AGENT'], "iPhone" );
$iPad = stripos( $_SERVER['HTTP_USER_AGENT'], "iPad" );
if ( stripos( $_SERVER['HTTP_USER_AGENT'], "Android" ) && stripos( $_SERVER['HTTP_USER_AGENT'], "mobile" ) ) {
	$Android = true;
} else if ( stripos( $_SERVER['HTTP_USER_AGENT'], "Android" ) ) {
	$Android = false;
	$AndroidTablet = true;
} else {
	$Android = false;
	$AndroidTablet = false;
}
$webOS = stripos( $_SERVER['HTTP_USER_AGENT'], "webOS" );
$BlackBerry = stripos( $_SERVER['HTTP_USER_AGENT'], "BlackBerry" );
$RimTablet = stripos( $_SERVER['HTTP_USER_AGENT'], "RIM Tablet" );

$device = '';

//do something with this information
if ( $iPod || $iPhone ) {
	$device = 'iPhone';
} else if ( $iPad ) {
	$device = 'iPad';
} else if ( $Android ) {
	$device = 'android';
} else if ( $AndroidTablet ) {
	$device = 'androidTablet';
} else if ( $webOS ) {
	$device = 'webOS';
} else if ( $BlackBerry ) {
	$device = 'blackBerry';
} else if ( $RimTablet ) {
	$device = 'rimTablet';
} else {
	$device = 'desktop';
}

global $affiliseo_options;

// HEADER
$affiliseo_header_bg_color = get_theme_mod( 'affiliseo_header_bg_color', '#d4d6d5' );
$affiliseo_text_color = get_theme_mod( 'affiliseo_text_color', '#333' );
$affiliseo_header_img = get_theme_mod( 'affiliseo_header_img', '' );
$affiliseo_header_img_repeat = get_theme_mod( 'affiliseo_header_img_repeat', 'no-repeat' );
$affiliseo_header_background_opacity = get_theme_mod( 'header_background_opacity', '100%' );

// WRAPPER
$affiliseo_wrapper_border_width = get_theme_mod( 'affiliseo_wrapper_border_width', '3px' );
$affiliseo_wrapper_border_color = get_theme_mod( 'affiliseo_wrapper_border_color', '#FFFFFF' );
$affiliseo_wrapper_bg_color = get_theme_mod( 'affiliseo_wrapper_bg_color', '#FFFFFF' );
$affiliseo_wrapper_bg_opacity = get_theme_mod( 'affiliseo_wrapper_bg_opacity', '50%' );
$affiliseo_wrapper_headerfooter_margin = get_theme_mod( 'affiliseo_wrapper_headerfooter_margin', '0px' );
$affiliseo_wrapper_content_margin = get_theme_mod( 'affiliseo_wrapper_content_margin', '15px' );
$custom_wrapper_margin_top = get_theme_mod( 'custom_wrapper_margin_top', '0' );

$affiliseoBoxShadowColor = get_theme_mod( 'affiliseo_box_shadow_color', '#c1c1c1' );
$affiliseoBoxShadowSpread = get_theme_mod( 'affiliseo_box_shadow_spread', '15px' );

// ALL
$affiliseo_font_color = get_theme_mod( 'affiliseo_font_color', '#333' );
$affiliseo_font_size = get_theme_mod( 'affiliseo_font_size', '14px' );
$affiliseo_bg_image = get_theme_mod( 'affiliseo_bg_image', '' );
$affiliseo_bg_image_repeat = get_theme_mod( 'affiliseo_bg_image_repeat', 'no-repeat' );
$affiliseo_bg_image_fixate = get_theme_mod( 'affiliseo_bg_image_fixate', '1' );
$affiliseo_bg_color = get_theme_mod( 'affiliseo_bg_color', '#F1F0F0' );
$affiliseo_font_family_headlines = get_theme_mod( 'affiliseo_font_family_headlines', 'Open Sans' );
$affiliseo_font_family_text = get_theme_mod( 'affiliseo_font_family_text', 'Open Sans' );
$affiliseo_link_color_default = get_theme_mod( 'affiliseo_link_color_default', '#428bca' );
$affiliseo_link_color_hover = get_theme_mod( 'affiliseo_link_color_hover', '#2a6496' );

// CONTENT
$affiliseo_content_bg_color = get_theme_mod( 'affiliseo_content_bg_color', '#FFFFFF' );
$affiliseo_content_product_border_color = get_theme_mod( 'affiliseo_content_product_border_color', '#DDD' );
$affiliseo_product_bg_color = get_theme_mod( 'affiliseo_product_bg_color', '#FFFFFF' );
$affiliseo_content_bg_opacity = get_theme_mod( 'affiliseo_content_bg_opacity', '100' );
$affiliseo_product_hover_bg_color = get_theme_mod( 'affiliseo_product_hover_bg_color', '#FFFFFF' );
$affiliseo_product_stars_color = get_theme_mod( 'affiliseo_product_stars_color', '#FF9900' );
$affiliseoBackToTopBgColor = get_theme_mod( 'affiliseo_back_to_top_bg_color', '#009bc2' );
$affiliseoBackToTopArrowColor = get_theme_mod( 'affiliseo_back_to_top_arrow_color', '#FFFFFF' );
$affiliseoBackToTopBgOpacity = get_theme_mod( 'affiliseo_back_to_top_bg_opacity', '80' );

// SIDEBAR
$affiliseo_sidebar_border_color = get_theme_mod( 'affiliseo_sidebar_border_color', '#666666' );
$affiliseo_sidebar_headline_bg_color = get_theme_mod( 'affiliseo_sidebar_headline_bg_color', '#666666' );
$affiliseo_sidebar_headline_img = get_theme_mod( 'affiliseo_sidebar_headline_img', '' );
$affiliseo_sidebar_img_repeat = get_theme_mod( 'affiliseo_sidebar_img_repeat', 'no-repeat' );
$affiliseo_sidebar_headline_color = get_theme_mod( 'affiliseo_sidebar_headline_color', '#FFF' );
$affiliseo_sidebar_text_color = get_theme_mod( 'affiliseo_sidebar_text_color', '#060000' );
$affiliseo_sidebar_text_hover_color = get_theme_mod( 'affiliseo_sidebar_text_hover_color', '#ff6600' );
$affiliseo_sidebar_bg_color = get_theme_mod( 'affiliseo_sidebar_bg_color', '#ffffff' );
$affiliseo_sidebar_bg_opacity = get_theme_mod( 'affiliseo_sidebar_bg_opacity', '100%' );
$affiliseo_sidebar_bg_linear_gradient_from = get_theme_mod( 'affiliseo_sidebar_bg_linear_gradient_from', '' );
$affiliseo_sidebar_bg_linear_gradient_to = get_theme_mod( 'affiliseo_sidebar_bg_linear_gradient_to', '' );

// FOOTER
$affiliseo_footer_bg_color = get_theme_mod( 'affiliseo_footer_bg_color', '#ACACA8' );
$affiliseo_footer_bg_opacity = get_theme_mod( 'affiliseo_footer_bg_opacity', '100%' );
$affiliseo_footer_text_color = get_theme_mod( 'affiliseo_footer_text_color', '#fff' );
$affiliseo_footer_img = get_theme_mod( 'affiliseo_footer_img', '' );
$affiliseo_footer_img_repeat = get_theme_mod( 'affiliseo_footer_img_repeat', 'no-repeat' );

// SONSTIGES
$affiliseo_border_radius = get_theme_mod( 'affiliseo_border_radius', '4px' );
$affiliseo_submit_button_bg = get_theme_mod( 'affiliseo_submit_button_bg', '#ff6600' );
$affiliseo_submit_button_bg_hover = get_theme_mod( 'affiliseo_submit_button_bg_hover', '#ED9C28' );
$affiliseo_submit_button_text_color = get_theme_mod( 'affiliseo_submit_button_text_color', '#fff' );
$affiliseo_submit_button_text_color_hover = get_theme_mod( 'affiliseo_submit_button_text_color_hover', '#fff' );
$product_headline_text_color = get_theme_mod( 'product_headline_text_color', '#fff' );
$product_headline_background_color = get_theme_mod( 'product_headline_background_color', '#999' );
$affiliseo_product_price_color = get_theme_mod( 'affiliseo_product_price_color', '#F60' );
$affiliseo_product_grey_box = get_theme_mod( 'affiliseo_product_grey_box', '#F1F1F1' );
$affiliseo_product_grey_box_color = get_theme_mod( 'affiliseo_product_grey_box_color', '#444' );
$affiliseo_product_h3_text_color = get_theme_mod( 'affiliseo_product_h3_text_color', '#444' );

// NAVIGATION
$affiliseo_navigation_bg_color = get_theme_mod( 'affiliseo_navigation_bg_color', '#D4D6D5' );
$affiliseo_navigation_bg_hover_color = get_theme_mod( 'affiliseo_navigation_bg_hover_color', '#EEE' );
$affiliseo_navigation_text_color = get_theme_mod( 'affiliseo_navigation_text_color', '#FFF' );
$affiliseo_navigation_text_hover_color = get_theme_mod( 'affiliseo_navigation_text_hover_color', '#FFF' );
$affiliseo_navigation_border_color = get_theme_mod( 'affiliseo_navigation_border_color', '#e7e7e7' );
$affiliseo_navigation_margin_top = get_theme_mod( 'affiliseo_navigation_margin_top', '0' );
$affiliseo_navigation_font_family = get_theme_mod( 'affiliseo_navigation_font_family', 'Open Sans' );
$affiliseo_navigation_font_size = get_theme_mod( 'affiliseo_navigation_font_size', '14px' );
$affiliseo_navigation_bg_linear_gradient_from = get_theme_mod( 'affiliseo_navigation_bg_linear_gradient_from', '' );
$affiliseo_navigation_bg_linear_gradient_to = get_theme_mod( 'affiliseo_navigation_bg_linear_gradient_to', '' );

// AFFILIATE-PARTNER-BUTTONS
$affiliseo_buttons_ap_bg = get_theme_mod( 'affiliseo_buttons_ap_bg', '#F0AD4E' );
$affiliseo_buttons_ap_img = get_theme_mod( 'affiliseo_buttons_ap_bg_image', '' );
$affiliseo_buttons_ap_img_repeat = get_theme_mod( 'affiliseo_buttons_ap_bg_image_repeat', 'no-repeat' );
$affiliseo_buttons_ap_bg_hover = get_theme_mod( 'affiliseo_buttons_ap_bg_hover', '#ED9C28' );
$affiliseo_buttons_ap_text_color = get_theme_mod( 'affiliseo_buttons_ap_text_color', '#FFF' );
$affiliseo_buttons_ap_text_color_hover = get_theme_mod( 'affiliseo_buttons_ap_text_color_hover', '#FFF' );

// AFFILIATE-PARTNER-CART-BUTTONS
$affiliseo_buttons_ap_cart_bg = get_theme_mod( 'affiliseo_buttons_ap_cart_bg', '#F0AD4E' );
$affiliseo_buttons_ap_cart_img = get_theme_mod( 'affiliseo_buttons_ap_cart_bg_image', '' );
$affiliseo_buttons_ap_cart_img_repeat = get_theme_mod( 'affiliseo_buttons_ap_cart_bg_image_repeat', 'no-repeat' );
$affiliseo_buttons_ap_cart_bg_hover = get_theme_mod( 'affiliseo_buttons_ap_cart_bg_hover', '#ED9C28' );
$affiliseo_buttons_ap_cart_text_color = get_theme_mod( 'affiliseo_buttons_ap_cart_text_color', '#FFF' );
$affiliseo_buttons_ap_cart_text_color_hover = get_theme_mod( 'affiliseo_buttons_ap_cart_text_color_hover', '#FFF' );

// DETAIL BUTTON
$affiliseo_buttons_detail_bg = get_theme_mod( 'affiliseo_buttons_detail_bg', '#666' );
$affiliseo_buttons_detail_img = get_theme_mod( 'affiliseo_buttons_detail_bg_image', '' );
$affiliseo_buttons_detail_img_repeat = get_theme_mod( 'affiliseo_buttons_detail_bg_image_repeat', 'no-repeat' );
$affiliseo_buttons_detail_bg_hover = get_theme_mod( 'affiliseo_buttons_detail_bg_hover', '#888' );
$affiliseo_buttons_detail_text_color = get_theme_mod( 'affiliseo_buttons_detail_text_color', '#FFF' );
$affiliseo_buttons_detail_text_color_hover = get_theme_mod( 'affiliseo_buttons_detail_text_color_hover', '#FFF' );

// THIRD BUTTON
$affiliseo_buttons_third_bg = get_theme_mod( 'affiliseo_buttons_third_bg', '#666' );
$affiliseo_buttons_third_img = get_theme_mod( 'affiliseo_buttons_third_bg_image', '' );
$affiliseo_buttons_third_img_repeat = get_theme_mod( 'affiliseo_buttons_third_bg_image_repeat', 'no-repeat' );
$affiliseo_buttons_third_bg_hover = get_theme_mod( 'affiliseo_buttons_third_bg_hover', '#888' );
$affiliseo_buttons_third_text_color = get_theme_mod( 'affiliseo_buttons_third_text_color', '#FFF' );
$affiliseo_buttons_third_text_color_hover = get_theme_mod( 'affiliseo_buttons_third_text_color_hover', '#FFF' );

// CHECKLIST
$affiliseo_checklist_highlight_color = get_theme_mod( 'affiliseo_checklist_highlight_color', '#e74c3c' );

// UVP
$affiliseo_uvp_text_color = get_theme_mod( 'affiliseo_uvp_text_color', '#a2a1a1' );
$affiliseo_uvp_font_size = get_theme_mod( 'affiliseo_uvp_font_size', 12 );
$affiliseo_uvp_deleted_text_color = get_theme_mod( 'affiliseo_uvp_deleted_text_color', '#a2a1a1' );

// BLOG-BOX
$affiliseo_blog_box_border_color = get_theme_mod( 'affiliseo_blog_box_border_color', '#ddd' );
$affiliseo_blog_box_border_radius = get_theme_mod( 'affiliseo_blog_box_border_radius', '8px' );


// PRODUCT-REVIEWS
$affiliseoProductReviewsHeaderBgColor = get_theme_mod('affiliseo_product_reviews_header_bg_color', '#ddd' );
$affiliseoProductReviewsHeaderBgOpacity = get_theme_mod('affiliseo_product_reviews_header_bg_opacity', '100%');
$affiliseoProductReviewsHeaderFontColor = get_theme_mod('affiliseo_product_reviews_header_font_color', '#000' );
$affiliseoProductReviewsHeaderFontSize = get_theme_mod('affiliseo_product_reviews_header_font_size', '12px' );

$affiliseoProductReviewsFooterBgColor = get_theme_mod('affiliseo_product_reviews_footer_bg_color', '#ddd' );
$affiliseoProductReviewsFooterBgOpacity = get_theme_mod('affiliseo_product_reviews_footer_bg_opacity', '100%');
$affiliseoProductReviewsSummaryTopBgLinearGradientFrom = get_theme_mod('affiliseo_product_reviews_summary_top_bg_linear_gradient_from', '' );
$affiliseoProductReviewsSummaryTopBgLinearGradientTo = get_theme_mod('affiliseo_product_reviews_summary_top_bg_linear_gradient_to', '' );
$affiliseoProductReviewsSummaryBottomBgLinearGradientFrom = get_theme_mod('affiliseo_product_reviews_summary_bottom_bg_linear_gradient_from', '' );
$affiliseoProductReviewsSummaryBottomBgLinearGradientTo = get_theme_mod('affiliseo_product_reviews_summary_bottom_bg_linear_gradient_to', '' );

$affiliseoProductReviewsSummaryTopFontColor = get_theme_mod('affiliseo_product_reviews_summary_top_font_color', '#000' );
$affiliseoProductReviewsSummaryTopFontSize = get_theme_mod('affiliseo_product_reviews_summary_top_font_size', '12px' );
$affiliseoProductReviewsSummaryPercentFontColor = get_theme_mod('affiliseo_product_reviews_summary_percent_font_color', '#000' );
$affiliseoProductReviewsSummaryPercentFontSize = get_theme_mod('affiliseo_product_reviews_summary_percent_font_size', '12px' );

$affiliseoProductReviewsSummaryBottomFontColor = get_theme_mod('affiliseo_product_reviews_summary_bottom_font_color', '#000' );
$affiliseoProductReviewsSummaryBottomFontSize = get_theme_mod('affiliseo_product_reviews_summary_bottom_font_size', '12px' );

$affiliseoProductReviewsProgressBarDanger = get_theme_mod('affiliseo_product_reviews_progress_bar_danger', '#d9534f' );
$affiliseoProductReviewsProgressBarWarning = get_theme_mod('affiliseo_product_reviews_progress_bar_warning', '#f0ad4e' );
$affiliseoProductReviewsProgressBarInfo = get_theme_mod('affiliseo_product_reviews_progress_bar_info', '#5bc0de' );
$affiliseoProductReviewsProgressBarSuccess = get_theme_mod('affiliseo_product_reviews_progress_bar_success', '#5cb85c' );


// COMPARISON
$affiliseoComparisonTableFontSize = get_theme_mod('affiliseo_comparison_table_font_size', '13px' );
$affiliseoComparisonHeaderFontColor = get_theme_mod('affiliseo_comparison_header_font_color', '#fff' );
$affiliseoComparisonHeaderBgLinearGradientFrom = get_theme_mod('affiliseo_comparison_header_bg_linear_gradient_from', '#919395' );
$affiliseoComparisonHeaderBgLinearGradientTo = get_theme_mod('affiliseo_comparison_header_bg_linear_gradient_to', '#5f656b' );
$affiliseoComparisonHeaderFontSize = get_theme_mod('affiliseo_comparison_header_font_size', '13px' );
$affiliseoComparisonColsHover = get_theme_mod('affiliseo_comparison_cols_hover', '#ADD8E6' );
$affiliseoComparisonRowsHover = get_theme_mod('affiliseo_comparison_rows_hover', '#90EE90' );
$affiliseoComparisonRowsBorderSize = get_theme_mod('affiliseo_comparison_rows_border_size', '1px' );
$affiliseoComparisonRowsBorderColor = get_theme_mod('affiliseo_comparison_rows_border_color', '#dcdcdc' );
$affiliseoComparisonColsBorderSize = get_theme_mod('affiliseo_comparison_cols_border_size', '1px' );
$affiliseoComparisonColsBorderColor = get_theme_mod('affiliseo_comparison_cols_border_color', '#dcdcdc' );
$affiliseoComparisonButtonBgColorDisabled = get_theme_mod('affiliseo_comparison_button_bg_color_disabled', '#cdcdcd' );
$affiliseoComparisonButtonBgColor = get_theme_mod('affiliseo_comparison_button_bg_color', '#0085ba' );
$affiliseoComparisonButtonBgColorHover = get_theme_mod('affiliseo_comparison_button_bg_color_hover', '#00FFFF' );
$affiliseoComparisonButtonTextColor = get_theme_mod('affiliseo_comparison_button_text_color', '#fff' );
$affiliseoComparisonButtonTextColorHover = get_theme_mod('affiliseo_comparison_button_text_color_hover', '#E6E6FA' );
$affiliseoPriceComparisonBoxBgColor = get_theme_mod('affiliseo_price_comparison_box_bg_color', '#eee' );


// COOKIE-POLICY
$affiliseoCookiePolicyMessageFontSize = get_theme_mod('affiliseo_cookie_policy_message_font_size','12px');
$affiliseoCookiePolicyAcceptButtonFontSize = get_theme_mod('affiliseo_cookie_policy_accept_button_font_size','12px');
$affiliseoCookiePolicyReadMoreButtonFontSize = get_theme_mod('affiliseo_cookie_policy_read_more_button_font_size','12px');
$affiliseoCookiePolicyBgOpacity = get_theme_mod('affiliseo_cookie_policy_bg_opacity','80%');
$affiliseoCookiePolicyMessageFontColor = get_theme_mod('affiliseo_cookie_policy_message_font_color','#000');
$affiliseoCookiePolicyMessageBgColor = get_theme_mod('affiliseo_cookie_policy_message_bg_color','#c1c1c1');
$affiliseoCookiePolicyAcceptButtonFontColor = get_theme_mod('affiliseo_cookie_policy_accept_button_font_color','#000');
$affiliseoCookiePolicyAcceptButtonBgColor = get_theme_mod('affiliseo_cookie_policy_accept_button_bg_color','#8dd659');
$affiliseoCookiePolicyReadMoreButtonFontColor = get_theme_mod('affiliseo_cookie_policy_read_more_button_font_color','#000');
$affiliseoCookiePolicyReadMoreButtonBgColor = get_theme_mod('affiliseo_cookie_policy_read_more_button_bg_color','#45b1ef');


// BOXES
$affiliseo_box_border = $affiliseo_options['layout_wrapper_boxes'];

//HEADLINE
$affiliseo_box_headline = $affiliseo_options['layout_wrapper_headline'];


$affiliseo_custom_css = $affiliseo_options['custom_css'];

$full_size_header = $affiliseo_options['full_size_header'];

ob_start();
?>
h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .nav {
font-family: '<?php echo $affiliseo_font_family_headlines; ?>', sans-serif;
}
<?php if ( $affiliseo_font_family_headlines == 'Oswald' || $affiliseo_font_family_headlines == 'Ubuntu Condensed' ) : ?>
	h1,.nav {
	text-transform: uppercase;
	}
<?php endif; ?>
<?php if ( $affiliseo_bg_image ) { ?>
	body {
	font-family: '<?php echo $affiliseo_font_family_text; ?>', sans-serif;
	font-size: <?php echo $affiliseo_font_size; ?>;
	background-color: <?php echo $affiliseo_bg_color; ?>;
	<?php if ( $device !== 'android' && $device !== 'androidTablet' ): ?>
		background-image: url('<?php echo $affiliseo_bg_image; ?>');
		<?php
		if ( $affiliseo_bg_image_repeat == 'cover' ) {
			?>
			background-size: cover;
			<?php
		} else {
			?>
			background-repeat: <?php echo $affiliseo_bg_image_repeat; ?>;
			<?php
		}
		if ( $affiliseo_bg_image_fixate == '1' ) {
			?>
			background-attachment: fixed;
			<?php
		}
	endif;
	?>
	}
<?php } else { ?>
	body { 
	font-family: '<?php echo $affiliseo_font_family_text; ?>', sans-serif; 
	font-size: <?php echo $affiliseo_font_size; ?>; 
	background-color: <?php echo $affiliseo_bg_color; ?>; 
	}
<?php } ?>
body {
color: <?php echo $affiliseo_font_color; ?>;
}

#search-header .input-group-custom,
.widget_search .input-group-custom {
<?php if ( $affiliseo_box_border === 'all' ) : ?>
	border: 1px solid <?php echo $affiliseo_content_product_border_color; ?>;
<?php endif; ?>
}

.btn, .form-control, 
#sidebar .widget, 
#navigation .navbar, 
.box, 
.blog .content, 
#breadcrumb, 
.box-grey, 
.comment, 
.panel-default,
.carousel-inner,
.input-group-custom,
.form-control-custom,
.price-comparison-headline,
.big-slider-product-img,
.big-slider-product-view,
.attachment-product_small,
.wp-post-image,
.small-slider-product-view,
.slider-headline,
.silder-text,
.product-reviews-header,
.progress,
.product-reviews-footer,
.acfpb_section {
border-radius: <?php echo $affiliseo_border_radius; ?> !important;
-moz-border-radius: <?php echo $affiliseo_border_radius; ?> !important;
-webkit-border-radius: <?php echo $affiliseo_border_radius; ?> !important;
-o-border-radius: <?php echo $affiliseo_border_radius; ?> !important;
}
.produkte .thumbnail,
.rand-product-menu {
border-radius: <?php echo $affiliseo_border_radius; ?>;
-moz-border-radius: <?php echo $affiliseo_border_radius; ?>;
-webkit-border-radius: <?php echo $affiliseo_border_radius; ?>;
-o-border-radius: <?php echo $affiliseo_border_radius; ?>;
}
.carousel-control.left {
border-top-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
-moz-border-top-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
-webkit-border-top-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
-o-border-top-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
border-bottom-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
-moz-border-bottom-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
-webkit-border-bottom-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
-o-border-bottom-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
}
.carousel-control.right {
border-top-right-radius: <?php echo $affiliseo_border_radius; ?> !important;
-moz-border-top-right-radius: <?php echo $affiliseo_border_radius; ?> !important;
-webkit-border-top-right-radius: <?php echo $affiliseo_border_radius; ?> !important;
-o-border-top-right-radius: <?php echo $affiliseo_border_radius; ?> !important;
border-bottom-right-radius: <?php echo $affiliseo_border_radius; ?> !important;
-moz-border-bottom-right-radius: <?php echo $affiliseo_border_radius; ?> !important;
-webkit-border-bottom-right-radius: <?php echo $affiliseo_border_radius; ?> !important;
-o-border-bottom-right-radius: <?php echo $affiliseo_border_radius; ?> !important;
}
.headline-product-line,
.dropdown-menu {
border-radius: <?php echo $affiliseo_border_radius; ?> !important;
-moz-radius: <?php echo $affiliseo_border_radius; ?> !important;
-webkit-radius: <?php echo $affiliseo_border_radius; ?> !important;
-o-border-radius: <?php echo $affiliseo_border_radius; ?> !important;
}
.btn-ap { 
background: <?php echo $affiliseo_buttons_ap_bg; ?>; 
border-color: <?php echo $affiliseo_buttons_ap_bg; ?>; 
color: <?php echo $affiliseo_buttons_ap_text_color; ?> !important; 
<?php
if ( !empty( $affiliseo_buttons_ap_img ) ) :
	?>
        border: none;
	background-image: url(<?php echo $affiliseo_buttons_ap_img; ?>);
	<?php
	if ( $affiliseo_buttons_ap_img_repeat == 'cover' ) :
		?>
		background-size: cover;
		<?php
	else :
		?>
		background-repeat: <?php echo $affiliseo_buttons_ap_img_repeat; ?>;
	<?php
	endif;
endif;
?>
}
.btn-ap:hover, 
.btn-ap:focus { 
background: <?php echo $affiliseo_buttons_ap_bg_hover; ?>; 
border-color: <?php echo $affiliseo_buttons_ap_bg_hover; ?>; 
color: <?php echo $affiliseo_buttons_ap_text_color_hover; ?> !important; 
<?php
if ( !empty( $affiliseo_buttons_ap_img ) ) :
	?>
	background-image: url(<?php echo $affiliseo_buttons_ap_img; ?>);
	<?php
	if ( $affiliseo_buttons_ap_img_repeat == 'cover' ) :
		?>
		background-size: cover;
		<?php
	else :
		?>
		background-repeat: <?php echo $affiliseo_buttons_ap_img_repeat; ?>;
	<?php
	endif;
endif;
?>
}
.price-comparison-headline { 
background: <?php echo $affiliseo_buttons_ap_bg_hover; ?>; 
color: <?php echo $affiliseo_buttons_ap_text_color_hover; ?> !important; 
}
.btn-cart-ap { 
background: <?php echo $affiliseo_buttons_ap_cart_bg; ?>; 
border-color: <?php echo $affiliseo_buttons_ap_cart_bg; ?>; 
color: <?php echo $affiliseo_buttons_ap_cart_text_color; ?> !important; 
<?php
if ( !empty( $affiliseo_buttons_ap_cart_img ) ) :
	?>
        border: none;
	background-image: url(<?php echo $affiliseo_buttons_ap_cart_img; ?>);
	<?php
	if ( $affiliseo_buttons_ap_cart_img_repeat == 'cover' ) :
		?>
		background-size: cover;
		<?php
	else :
		?>
		background-repeat: <?php echo $affiliseo_buttons_ap_cart_img_repeat; ?>;
	<?php
	endif;
endif;
?>
}
.btn-cart-ap:hover, 
.btn-cart-ap:focus { 
background: <?php echo $affiliseo_buttons_ap_cart_bg_hover; ?>; 
border-color: <?php echo $affiliseo_buttons_ap_cart_bg_hover; ?>; 
color: <?php echo $affiliseo_buttons_ap_cart_text_color_hover; ?> !important; 
<?php
if ( !empty( $affiliseo_buttons_ap_cart_img ) ) :
	?>
	background-image: url(<?php echo $affiliseo_buttons_ap_cart_img; ?>);
	<?php
	if ( $affiliseo_buttons_ap_cart_img_repeat == 'cover' ) :
		?>
		background-size: cover;
		<?php
	else :
		?>
		background-repeat: <?php echo $affiliseo_buttons_ap_cart_img_repeat; ?>;
	<?php
	endif;
endif;
?>
}
.btn-detail { 
background: <?php echo $affiliseo_buttons_detail_bg; ?>; 
border-color: <?php echo $affiliseo_buttons_detail_bg; ?>; 
color: <?php echo $affiliseo_buttons_detail_text_color; ?> !important; 
<?php
if ( !empty( $affiliseo_buttons_detail_img ) ) :
	?>
        border: none;
	background-image: url(<?php echo $affiliseo_buttons_detail_img; ?>);
	<?php
	if ( $affiliseo_buttons_detail_img_repeat == 'cover' ) :
		?>
		background-size: cover;
		<?php
	else :
		?>
		background-repeat: <?php echo $affiliseo_buttons_detail_img_repeat; ?>;
	<?php
	endif;
endif;
?>
}
.btn-detail:hover, 
.btn-detail:focus { 
background: <?php echo $affiliseo_buttons_detail_bg_hover; ?>; 
border-color: <?php echo $affiliseo_buttons_detail_bg_hover; ?>; 
color: <?php echo $affiliseo_buttons_detail_text_color_hover; ?> !important;
<?php
if ( !empty( $affiliseo_buttons_detail_img ) ) :
	?>
        border: none;
	background-image: url(<?php echo $affiliseo_buttons_detail_img; ?>);
	<?php
	if ( $affiliseo_buttons_detail_img_repeat == 'cover' ) :
		?>
		background-size: cover;
		<?php
	else :
		?>
		background-repeat: <?php echo $affiliseo_buttons_detail_img_repeat; ?>;
	<?php
	endif;
endif;
?>
}
.third-link { 
background: <?php echo $affiliseo_buttons_third_bg; ?>; 
border-color: <?php echo $affiliseo_buttons_third_bg; ?>; 
color: <?php echo $affiliseo_buttons_third_text_color; ?>;
<?php
if ( !empty( $affiliseo_buttons_third_img ) ) :
	?>
        border: none;
	background-image: url(<?php echo $affiliseo_buttons_third_img; ?>);
	<?php
	if ( $affiliseo_buttons_third_img_repeat == 'cover' ) :
		?>
		background-size: cover;
		<?php
	else :
		?>
		background-repeat: <?php echo $affiliseo_buttons_third_img_repeat; ?>;
	<?php
	endif;
endif;
?>
}
.third-link:hover, 
.third-link:focus { 
background: <?php echo $affiliseo_buttons_third_bg_hover; ?>; 
border-color: <?php echo $affiliseo_buttons_third_bg_hover; ?>; 
color: <?php echo $affiliseo_buttons_third_text_color_hover; ?>; 
<?php
if ( !empty( $affiliseo_buttons_third_img ) ) :
	?>
        border: none;
	background-image: url(<?php echo $affiliseo_buttons_third_img; ?>);
	<?php
	if ( $affiliseo_buttons_third_img_repeat == 'cover' ) :
		?>
		background-size: cover;
		<?php
	else :
		?>
		background-repeat: <?php echo $affiliseo_buttons_third_img_repeat; ?>;
	<?php
	endif;
endif;
?>
}

.btn-submit {
background-color: <?php echo $affiliseo_submit_button_bg; ?>;
color: <?php echo $affiliseo_submit_button_text_color; ?>;
}

.btn-submit:hover,
.btn-submit:focus {
background-color: <?php echo $affiliseo_submit_button_bg_hover; ?>;
color: <?php echo $affiliseo_submit_button_text_color_hover; ?>;
}

.hover-container {
border-bottom-left-radius: <?php echo $affiliseo_border_radius; ?>;
-moz-border-bottom-left-radius: <?php echo $affiliseo_border_radius; ?>;
-webkit-border-bottom-left-radius: <?php echo $affiliseo_border_radius; ?>;
-o-border-bottom-left-radius: <?php echo $affiliseo_border_radius; ?>;
border-bottom-right-radius: <?php echo $affiliseo_border_radius; ?>;
-moz-border-bottom-right-radius: <?php echo $affiliseo_border_radius; ?>;
-webkit-border-bottom-right-radius: <?php echo $affiliseo_border_radius; ?>;
-o-border-bottom-right-radius: <?php echo $affiliseo_border_radius; ?>;
}

.affiliseo-carousel {
border-top-left-radius: <?php echo $affiliseo_border_radius; ?>;
-moz-border-top-left-radius: <?php echo $affiliseo_border_radius; ?>;
-webkit-border-top-left-radius: <?php echo $affiliseo_border_radius; ?>;
-o-border-top-left-radius: <?php echo $affiliseo_border_radius; ?>;
}

#sidebar .widget .h1 {

}

p.mini {
font-size: <?php echo intval( $affiliseo_font_size * 80 / 100 ); ?>px;
line-height: <?php echo intval( $affiliseo_font_size + intval( $affiliseo_font_size * 20 / 100 ) ); ?>px;
margin-bottom: <?php echo intval( $affiliseo_font_size / 2 ); ?>px;
}
header,
#header {
color: <?php echo $affiliseo_text_color; ?>;
<?php
//if ( has_nav_menu( 'nav_top' ) ) :
?>
/*padding-left: 0;
padding-right: 0;*/
<?php
//endif;
//if ( !has_nav_menu( 'nav_top' ) ) :
?>
background-color: rgba(<?php echo hexdec( substr( $affiliseo_header_bg_color, 1, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_header_bg_color, 3, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_header_bg_color, 5, 2 ) ); ?>, <?php echo $affiliseo_header_background_opacity / 100; ?>);
<?php
//endif;
if ( $custom_wrapper_margin_top != '0' && $custom_wrapper_margin_top != '0px' ) :
	?>
	border-top-left-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	-moz-border-top-left-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	-webkit-border-top-left-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	-o-border-top-left-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	border-top-right-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	-moz-border-top-right-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	-webkit-border-top-right-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	-o-border-top-right-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
<?php endif; ?>
}
<?php
if ( !empty( $affiliseo_header_img ) ) :
	?>
	header,
	#header {
	background-image: url(<?php echo $affiliseo_header_img; ?>);
	<?php
	if ( $affiliseo_header_img_repeat == 'cover' ) :
		?>
		background-size: cover;
		<?php
	else :
		?>
		background-repeat: <?php echo $affiliseo_header_img_repeat; ?>;
	<?php
	endif;
	?>
	}
	<?php
endif;
?>
.site_title { 
color: <?php echo $affiliseo_text_color; ?>; 
}

.navbar-default,
.dropdown-menu,
.depth-1 {
	background-color: <?php echo $affiliseo_navigation_bg_color; ?>;
	background: linear-gradient(to bottom, <?php echo $affiliseo_navigation_bg_linear_gradient_from; ?>, <?php echo $affiliseo_navigation_bg_linear_gradient_to; ?>);
	border-color: <?php echo $affiliseo_navigation_border_color; ?>;
}

.navbar-default .navbar-nav > li > a { 
color: <?php echo $affiliseo_navigation_text_color; ?>;
}
.navbar-default .navbar-toggle .icon-bar {
background-color: <?php echo $affiliseo_navigation_text_color; ?>;
}
.navbar-default .navbar-nav > .dropdown > a .caret { 
border-top-color: <?php echo $affiliseo_navigation_text_color; ?>; 
border-bottom-color: <?php echo $affiliseo_navigation_text_color; ?>; 
}
.navbar-default .navbar-nav > .dropdown > a:hover .caret { 
border-top-color: <?php echo $affiliseo_navigation_text_color; ?>; 
border-bottom-color: <?php echo $affiliseo_navigation_text_color; ?>; 
}
.navbar-default .navbar-nav > .dropdown > a:focus .caret { 
border-top-color: <?php echo $affiliseo_navigation_text_color; ?>;
border-bottom-color: <?php echo $affiliseo_navigation_text_color; ?>; 
}
.navbar-default .navbar-nav > li > a:hover, 
.navbar-default .navbar-nav > li > a:focus { 
color: <?php echo $affiliseo_navigation_text_hover_color; ?>; 
}
.nav>li>a:hover, 
.nav>li>a:focus {
background-color: <?php echo $affiliseo_navigation_bg_hover_color; ?> !important;
}
.navbar-nav .dropdown-menu ul li a,
.menu-caret {
color: <?php echo $affiliseo_navigation_text_color; ?>;
}
.navbar-nav .dropdown-menu ul li:hover, 
.navbar-nav .dropdown-menu ul li:focus {
background-color: <?php echo $affiliseo_navigation_bg_hover_color ?>;
}

.current-menu-ancestor,
.current-menu-parent,
.current_page_parent,
.current-menu-item {
background-color: <?php echo $affiliseo_navigation_bg_hover_color; ?>;
}

.current-menu-item a {
color: <?php echo $affiliseo_navigation_text_hover_color ?>;
}

.current-menu-ancestor > a,
.current-menu-parent > a,
.current_page_parent > a,
.current_page_item > a,
.current-menu-item > a {
	color: <?php echo $affiliseo_navigation_text_hover_color ?> !important;
}

.current-menu-item li a {
color: <?php echo $affiliseo_navigation_text_color; ?>;
}
.dropdown-menu { background-color: <?php echo $affiliseo_navigation_bg_color; ?>;}
.dropdown-menu > li > a { color: <?php echo $affiliseo_navigation_text_color; ?>; }
.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus { color: <?php echo $affiliseo_navigation_text_hover_color; ?>; background-color: <?php echo $affiliseo_navigation_bg_hover_color; ?>!important;}
#sidebar .widget { 
<?php if ( $affiliseo_box_border === 'all' ) : ?>
	border: 1px solid <?php echo $affiliseo_sidebar_border_color; ?> 
<?php elseif ( $affiliseo_box_border === 'bottom' ) : ?>
	border-bottom: 1px solid <?php echo $affiliseo_sidebar_border_color; ?> 
<?php else : ?>
	border: none;
<?php endif; ?>
}

.headline-product-mega-menu {
color: <?php echo $affiliseo_navigation_text_color; ?>;
}
.rand-product-menu {
background-color: <?php echo $affiliseo_navigation_bg_hover_color; ?>;
color: <?php echo $affiliseo_navigation_text_color; ?>;
}
.rand-product-menu a {
color: <?php echo $affiliseo_navigation_text_color ?>;
}
.rand-product-menu a:hover,
.rand-product-menu a:focus,
.menu-caret:hover,
.menu-caret:focus  {
color: <?php echo $affiliseo_navigation_text_hover_color; ?>;
}
.rand-product-menu .price {
color: <?php echo $affiliseo_navigation_text_color ?>;
}
#sidebar .widget h4 { 
background: <?php echo $affiliseo_sidebar_headline_bg_color; ?>;
background: linear-gradient(to bottom, <?php echo $affiliseo_sidebar_bg_linear_gradient_from; ?>, <?php echo $affiliseo_sidebar_bg_linear_gradient_to; ?>); 
color: <?php echo $affiliseo_sidebar_headline_color; ?>; 
<?php if ( !empty( $affiliseo_sidebar_headline_img ) ) : ?>
	background-image: url("<?php echo $affiliseo_sidebar_headline_img; ?>");
	<?php
	if ( trim( $affiliseo_sidebar_img_repeat ) === 'cover' ) :
		?>
		background-size: cover;
		<?php
	else :
		?>
		background-repeat: <?php echo $affiliseo_sidebar_img_repeat ?>;
	<?php
	endif;
	?>
<?php endif; ?>
}
#sidebar .widget ul li a { color: <?php echo $affiliseo_sidebar_text_color; ?> }
#sidebar .widget .produkt a { color: <?php echo $affiliseo_sidebar_text_color; ?> }
#sidebar .widget ul li a:hover,
#sidebar .widget ul li a:focus,
#sidebar .widget ul li.current-menu-item a,
#sidebar .widget .produkt a:hover,
#sidebar .widget .produkt a:focus{ color: <?php echo $affiliseo_sidebar_text_hover_color; ?>;}

footer,
#footer {
background-color: rgba(<?php echo hexdec( substr( $affiliseo_footer_bg_color, 1, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_footer_bg_color, 3, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_footer_bg_color, 5, 2 ) ); ?>, <?php echo $affiliseo_footer_bg_opacity / 100; ?>);
color: <?php echo $affiliseo_footer_text_color; ?>;
background-image: url(<?php echo $affiliseo_footer_img; ?>);
<?php
if ( trim( $affiliseo_footer_img_repeat ) === 'cover' ) :
	?>
	background-size: cover;
	<?php
else :
	?>
	background-repeat: <?php echo $affiliseo_footer_img_repeat; ?>;
<?php
endif;
?>
<?php if ( $custom_wrapper_margin_top != '0' && $custom_wrapper_margin_top != '0px' ) : ?>
	border-bottom-left-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	-moz-border-bottom-left-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	-webkit-border-bottom-left-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	-o-border-bottom-left-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	border-bottom-right-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	-moz-border-bottom-right-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	-webkit-border-bottom-right-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
	-o-border-bottom-right-radius: <?php echo intval( $affiliseo_border_radius ) - intval( $affiliseo_wrapper_border_width ) / 1.25; ?>px !important;
<?php endif; ?>
}
footer a { color: <?php echo $affiliseo_footer_text_color; ?>; }
footer ul li a, footer ul li a:hover{ color: <?php echo $affiliseo_footer_text_color; ?>!important; }

#content-wrapper .box, 
#content .box, 
#single .box, 
.cat .box, 
.tag-content .box,
.blog .content, 
.blog .box, 
#second .box, 
.headline-product-line,
.related-posts-background {
background-color: rgba(<?php echo hexdec( substr( $affiliseo_content_bg_color, 1, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_content_bg_color, 3, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_content_bg_color, 5, 2 ) ); ?>, <?php echo $affiliseo_content_bg_opacity / 100; ?>);
}

.thumbnail {
background-color: rgba(<?php echo hexdec( substr( $affiliseo_product_bg_color, 1, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_product_bg_color, 3, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_product_bg_color, 5, 2 ) ); ?>, <?php echo $affiliseo_content_bg_opacity / 100; ?>);
}

.back-to-top {
	background-color: rgba(<?php echo hexdec( substr( $affiliseoBackToTopBgColor, 1, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseoBackToTopBgColor, 3, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseoBackToTopBgColor, 5, 2 ) ); ?>, <?php echo $affiliseoBackToTopBgOpacity / 100; ?>);
}

.back-to-top:hover{
	opacity: .5;
}

a.back-to-top:link,
a.back-to-top:active,
a.back-to-top:hover{
	color: <?php echo $affiliseoBackToTopArrowColor; ?>;
}

a, .blog .content a {
color: <?php echo $affiliseo_link_color_default; ?>;
}
a:hover, .blog .content a:hover {
color: <?php echo $affiliseo_link_color_hover; ?>;
}

.custom-wrapper {
<?php
//if ( !has_nav_menu( 'nav_top' ) ) :
?>
margin-top: <?php echo intval( $custom_wrapper_margin_top ); ?>px !important;
margin-bottom: <?php echo intval( $custom_wrapper_margin_top ); ?>px !important;
<?php
//endif;
?>
padding-left: <?php echo intval( $affiliseo_wrapper_headerfooter_margin ); ?>px;
padding-right: <?php echo intval( $affiliseo_wrapper_headerfooter_margin ); ?>px;
<?php
//if ( !has_nav_menu( 'nav_top' ) ) :
?>
border-left: <?php echo $affiliseo_wrapper_border_width; ?> solid <?php echo $affiliseo_wrapper_border_color; ?>;
border-right: <?php echo $affiliseo_wrapper_border_width; ?> solid <?php echo $affiliseo_wrapper_border_color; ?>;
<?php
//endif;
if ( $custom_wrapper_margin_top != '0' && $custom_wrapper_margin_top != '0px' ) :
	?>
	border-top: <?php echo $affiliseo_wrapper_border_width; ?> solid <?php echo $affiliseo_wrapper_border_color; ?>;
	border-bottom: <?php echo $affiliseo_wrapper_border_width; ?> solid <?php echo $affiliseo_wrapper_border_color; ?>;
	border-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
	-moz-border-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
	-webkit-border-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
	-o-border-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
<?php endif; ?>
background-color: rgba(<?php echo hexdec( substr( $affiliseo_wrapper_bg_color, 1, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_wrapper_bg_color, 3, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_wrapper_bg_color, 5, 2 ) ); ?>, <?php echo $affiliseo_wrapper_bg_opacity / 100; ?>);
}

#sidebar .widget {
	background-color: rgba(<?php echo hexdec( substr( $affiliseo_sidebar_bg_color, 1, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_sidebar_bg_color, 3, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_sidebar_bg_color, 5, 2 ) ); ?>, <?php echo $affiliseo_sidebar_bg_opacity / 100; ?>);
	overflow: hidden;
}

#sidebar .textwidget .thumbnail {
background: none;
}

#breadcrumb {
background-color: rgba(<?php echo hexdec( substr( $affiliseo_sidebar_bg_color, 1, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_sidebar_bg_color, 3, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_sidebar_bg_color, 5, 2 ) ); ?>, <?php echo $affiliseo_sidebar_bg_opacity / 100; ?>);;
}


.custom-navbar-toggle {
border: none !important;
background-color: <?php echo $affiliseo_navigation_bg_color; ?> !important;
float: none !important;
}
.custom-navbar-toggle span {
color: <?php echo $affiliseo_navigation_text_color; ?>;
text-transform: uppercase;
}
.custom-navbar-toggle span b {
border-top-color: <?php echo $affiliseo_navigation_text_color; ?>;
border-bottom-color: <?php echo $affiliseo_navigation_text_color; ?>;
margin-top: .6em;
margin-left: .5em;
}
.custom-navbar-toggle:hover,
.custom-navbar-toggle:focus {
background-color: <?php echo $affiliseo_navigation_bg_hover_color; ?>!important;
color: <?php echo $affiliseo_navigation_text_hover_color; ?>;
}
.custom-toggle {
margin-top: .2em;
margin-right: .5em;
}
.panel-heading span {
color: <?php echo $affiliseo_link_color_default; ?>;
}
.first-menu-container {
color: <?php echo $affiliseo_navigation_text_color; ?>;
background-color: <?php echo $affiliseo_navigation_bg_color; ?>;
border-bottom-color: <?php echo $affiliseo_navigation_bg_hover_color; ?>;
}
.first-menu-container .first-menu ul .current-menu-item a {                
color: <?php echo $affiliseo_navigation_bg_hover_color; ?>;
}
.first-menu-container .first-menu ul li a,
.social_header a {
color: <?php echo $affiliseo_navigation_text_color; ?>;
}
.first-menu-container .first-menu ul li a:hover,
.first-menu-container .first-menu ul li a:focus,
.social_header .fa:hover,
.social_header .fa:focus {
color: <?php echo $affiliseo_navigation_bg_hover_color ?>;
}
.first-menu-container .input-group-custom {
border-color: <?php echo $affiliseo_navigation_text_color; ?>;
<?php if ( $affiliseo_box_border === 'all' ) : ?>
	border: 1px solid <?php echo $affiliseo_navigation_text_color; ?>;
<?php endif; ?>
border-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-moz-border-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-webkit-border-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-o-border-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
}
<?php if ( $affiliseo_options['layout_wrapper_background'] == '1' ) { ?>
	.custom-container {
	padding-left: <?php echo intval( $affiliseo_wrapper_content_margin ); ?>px;
	padding-right: <?php echo intval( $affiliseo_wrapper_content_margin ); ?>px;
	}

	<?php $margin = intval( $affiliseo_wrapper_content_margin ); ?>

	#header {
	   margin-bottom: <?php echo $affiliseo_navigation_margin_top; ?>;
	}
	
	.navbar-default,
	.dropdown-menu {
	border-color: <?php echo $affiliseo_navigation_border_color; ?>;
	<?php if ( $affiliseo_box_border === 'all' ) : ?>
		border: 1px solid <?php echo $affiliseo_navigation_border_color ?>;
	<?php endif; ?>
	}

<?php } else { ?>
	#header {
	margin-bottom: <?php echo $affiliseo_navigation_margin_top; ?>;
	}
	#navigation {
	padding: 0;
	}
<?php } ?>

	.navbar-default .navbar-nav > li > a {
	   font-family: '<?php echo $affiliseo_navigation_font_family; ?>';
	   font-size: <?php echo $affiliseo_navigation_font_size; ?>;	
	}
	
	.menu-item-object-produkt_typen.menu-item-has-children a i.fa{
	   line-height:0;
	}
	



.mega-menu.dropdown-menu li {
border-right: 1px solid rgba(<?php echo hexdec( substr( $affiliseo_navigation_text_color, 1, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_navigation_text_color, 3, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseo_navigation_text_color, 5, 2 ) ) ?>, .2);
}

.mega-menu.dropdown-menu li a:hover, 
.mega-menu.dropdown-menu li a:focus {
color: <?php echo $affiliseo_navigation_text_hover_color; ?>;
background: none !important;
}

.dropdown-menu.no-mega-menu .dropleft {
background-color: <?php echo $affiliseo_navigation_bg_color; ?>;
border-radius: <?php echo intval( $affiliseo_border_radius ); ?>px;
-moz-border-radius: <?php echo intval( $affiliseo_border_radius ); ?>px;
-webkit-border-radius: <?php echo intval( $affiliseo_border_radius ); ?>px;
-o-border-radius: <?php echo intval( $affiliseo_border_radius ); ?>px;
}

.mega-menu.dropdown-menu .current-menu-item ul li a {
color: <?php echo $affiliseo_navigation_text_color ?> !important;           
}

.mega-menu.dropdown-menu .current-menu-item ul li a:hover,
.mega-menu.dropdown-menu .current-menu-item ul li a:focus {
color: <?php echo $affiliseo_navigation_text_hover_color; ?> !important;           
}

.headline-product-line {
border-color: <?php echo $product_headline_background_color; ?>;
<?php
if ( $affiliseo_box_headline === '1' ) :
	?>
	border-bottom-width: .3em;
	border-left-width: .1em;
	border-right-width: .1em;
	<?php
endif;
?>
}

.h4-product {
color: <?php echo $product_headline_text_color; ?>;
background-color: <?php echo $product_headline_background_color; ?>;
border-top-left-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-moz-border-top-left-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-webkit-border-top-left-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-o-border-top-left-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
border-top-right-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-moz-border-top-right-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-webkit-border-top-right-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-o-border-top-right-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
}

.border-highlight {
border: 3px solid <?php echo $affiliseo_checklist_highlight_color; ?>;
}

.background-highlight {
background-color: <?php echo $affiliseo_checklist_highlight_color; ?>;
}

.affiliseo-carousel,
.hover-container {
background-color: <?php echo $affiliseo_product_hover_bg_color; ?>;
}

.price {
color: <?php echo $affiliseo_product_price_color ?>;
}

.box {
<?php if ( $affiliseo_box_border === 'bottom' ) : ?>
	border-bottom: 5px solid <?php echo $affiliseo_content_product_border_color; ?>;
<?php elseif ( $affiliseo_box_border === 'all' ) : ?>
	border: 1px solid <?php echo $affiliseo_content_product_border_color; ?>;
<?php else: ?>
	border: none;
<?php endif; ?>
}

.thumbnail {
<?php if ( $affiliseo_box_border === 'bottom' ) : ?>
	border: none;
	border-bottom: 3px solid <?php echo $affiliseo_content_product_border_color; ?>;
<?php elseif ( $affiliseo_box_border === 'all' ) : ?>
	border: 1px solid <?php echo $affiliseo_content_product_border_color; ?>;
<?php else: ?>
	border: none;
<?php endif; ?>
}

.box-grey, 
.comment {
background-color: <?php echo $affiliseo_product_grey_box; ?>;
color: <?php echo $affiliseo_product_grey_box_color; ?>;
}

#single .produkt-details ul, #second .produkt-details ul{margin:0;padding:0;}
#single .produkt-details ul li, 
#second .produkt-details ul li {
border-top-color: <?php echo '#' . dechex( hexdec( $affiliseo_product_grey_box_color ) + hexdec( '333333' ) ) ?>;
}


.tags a,
.tagcloud a,
.tagcloud ul li a {
background-color: <?php echo $affiliseo_link_color_default; ?>;
border-radius: <?php echo $affiliseo_border_radius; ?> !important;
-moz-border-radius: <?php echo $affiliseo_border_radius; ?> !important;
-webkit-border-radius: <?php echo $affiliseo_border_radius; ?> !important;
-o-border-radius: <?php echo $affiliseo_border_radius; ?> !important;
color: #FFF !important;
}
.tags a:hover,
.tags a:focus,
.tagcloud a:hover,
.tagcloud a:focus,
.tagcloud ul li a:hover,
.tagcloud ul li a:focus {
background-color: <?php echo $affiliseo_link_color_hover ?>;
color: #FFF;
text-decoration: none; 
}

.stars {
color: <?php echo $affiliseo_product_stars_color; ?>;
}

.btn-search:hover,
.btn-search:focus {
color: <?php echo $affiliseo_link_color_hover ?>;
}

header .btn-search {
color: <?php echo $affiliseo_font_color; ?>;
font-size: 1em;
height: 1.5em !important;
}

.custom-comments p {
color: <?php echo $affiliseo_font_color ?>;
margin-top: .5em;
}
.nav > li:first-child.current-menu-item,
.nav > li:first-child.current-menu-item > a, 
.nav > li:first-child > a:hover, 
.nav > li:first-child > a:focus {
border-top-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
-moz-border-top-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
-webkit-border-top-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
-o-border-top-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
border-bottom-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
-moz-border-bottom-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
-webkit-border-bottom-left-radius:<?php echo $affiliseo_border_radius; ?> !important;
-o-border-bottom-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
}

.affiliseo-pagination .inactive {
background-color: <?php echo $affiliseo_link_color_default; ?>;
}

.affiliseo-pagination .inactive:hover,
.affiliseo-pagination .inactive:focus {
background-color: <?php echo $affiliseo_link_color_hover; ?>;
}

.affiliseo-pagination .inactive,
.affiliseo-pagination .current {
border-radius: <?php echo $affiliseo_border_radius; ?>;
-moz-border-radius: <?php echo $affiliseo_border_radius; ?>;
-webkit-border-radius: <?php echo $affiliseo_border_radius; ?>;
-o-border-radius: <?php echo $affiliseo_border_radius; ?>;
}

.related-posts-background {
border-bottom-left-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-moz-border-bottom-left-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-webkit-border-bottom-left-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-o-border-bottom-left-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
border-bottom-right-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-moz-border-bottom-right-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-webkit-border-bottom-right-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-o-border-bottom-right-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
}

.related-articles-border-top {
border-top-left-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-moz-border-top-left-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-webkit-border-top-left-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-o-border-top-left-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
border-top-right-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-moz-border-top-right-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-webkit-border-top-right-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
-o-border-top-right-radius: <?php echo intval( $affiliseo_border_radius ); ?>px !important;
}

#spinner-slider {
color: <?php echo $affiliseo_link_color_default ?>;
}

.produkte .thumbnail h3, 
.produkte .thumbnail h3 a,
#h1-product {
color: <?php echo $affiliseo_product_h3_text_color; ?>;
}

<?php
if ( trim( $full_size_header ) === '1' ) :
	?>
	#navigation .navbar,
	.nav > li:first-child.current-menu-item, 
	.nav > li:first-child.current-menu-item > a, 
	.nav > li:first-child > a:hover, 
	.nav > li:first-child > a:focus {
	border-radius: 0px !important;
	-moz-border-radius: 0px !important;
	-webkit-border-radius: 0px !important;
	-o-border-radius: 0px !important;
	}
	<?php
endif;
?>

#wait {
    border: 1px solid <?php echo $affiliseo_text_color; ?>;
}
#wait div {
    background-color: <?php echo $affiliseo_link_color_default; ?>;
}

.uvp-line-through{
    font-size: <?php echo $affiliseo_uvp_font_size; ?>;
	text-decoration: line-through;
	color: <?php echo $affiliseo_uvp_deleted_text_color; ?>;
	position:relative;
	top:25px;
}

.uvp-text-color{
	color: <?php echo $affiliseo_uvp_text_color; ?>;
}

.blog-preview-outer-box{
    border: 1px solid <?php echo $affiliseo_blog_box_border_color; ?>;
    border-radius: <?php echo $affiliseo_blog_box_border_radius; ?>;
}

.flex-control-thumbs img,
.flex-control-thumbs li {
    width: auto !important;
}

.col-sm-20percent{
	width:20%;
}

.product-reviews-header{
	background-color: rgba(<?php echo hexdec( substr( $affiliseoProductReviewsHeaderBgColor, 1, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseoProductReviewsHeaderBgColor, 3, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseoProductReviewsHeaderBgColor, 5, 2 ) ); ?>, <?php echo $affiliseoProductReviewsHeaderBgOpacity / 100; ?>);
	font-size: <?php echo $affiliseoProductReviewsHeaderFontSize; ?>;
	color: <?php echo $affiliseoProductReviewsHeaderFontColor; ?>;
}
.product-reviews-footer{
	background-color: rgba(<?php echo hexdec( substr( $affiliseoProductReviewsFooterBgColor, 1, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseoProductReviewsFooterBgColor, 3, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseoProductReviewsFooterBgColor, 5, 2 ) ); ?>, <?php echo $affiliseoProductReviewsFooterBgOpacity / 100; ?>);
}
.product-reviews-summary-top{
	text-align:center;
	background:linear-gradient(135deg, <?php echo $affiliseoProductReviewsSummaryTopBgLinearGradientFrom; ?> 30%, <?php echo $affiliseoProductReviewsSummaryTopBgLinearGradientTo; ?> 100%);
	font-size: <?php echo $affiliseoProductReviewsSummaryTopFontSize; ?>;
	color: <?php echo $affiliseoProductReviewsSummaryTopFontColor; ?>;
	border-top-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
	border-top-right-radius: <?php echo $affiliseo_border_radius; ?> !important;
}
.product-reviews-summary-bottom{
	text-align:center;
	background:linear-gradient(135deg, <?php echo $affiliseoProductReviewsSummaryBottomBgLinearGradientFrom; ?> 5%, <?php echo $affiliseoProductReviewsSummaryBottomBgLinearGradientTo; ?> 55%, <?php echo $affiliseoProductReviewsSummaryBottomBgLinearGradientFrom; ?> 100%);
	font-size: <?php echo $affiliseoProductReviewsSummaryBottomFontSize; ?>;
	color: <?php echo $affiliseoProductReviewsSummaryBottomFontColor; ?>;
	border-bottom-right-radius: <?php echo $affiliseo_border_radius; ?> !important;
	border-bottom-left-radius: <?php echo $affiliseo_border_radius; ?> !important;
}
.product-reviews-summary-percent{
	font-size: <?php echo $affiliseoProductReviewsSummaryPercentFontSize; ?>;
	color: <?php echo $affiliseoProductReviewsSummaryPercentFontColor; ?>;
}

.progress-bar-danger {
	background-color: <?php echo $affiliseoProductReviewsProgressBarDanger; ?> !important;
}
.progress-bar-warning {
	background-color: <?php echo $affiliseoProductReviewsProgressBarWarning; ?> !important;
}
.progress-bar-info {
	background-color: <?php echo $affiliseoProductReviewsProgressBarInfo; ?> !important;
}
.progress-bar-success {
	background-color: <?php echo $affiliseoProductReviewsProgressBarSuccess; ?> !important;
}


.comparison-table,
#comparison-selection-table {
	font-size: <?php echo $affiliseoComparisonTableFontSize; ?>;
}

.compare-product-title,
.compare-col {
	background: rgba(0, 0, 0, 0) linear-gradient(to bottom, <?php echo $affiliseoComparisonHeaderBgLinearGradientFrom; ?> 0%, <?php echo $affiliseoComparisonHeaderBgLinearGradientTo; ?> 100%) repeat scroll 0 0;
    color: <?php echo $affiliseoComparisonHeaderFontColor; ?>;
    font-size: <?php echo $affiliseoComparisonHeaderFontSize; ?>;
    border-top: <?php echo $affiliseoComparisonRowsBorderSize; ?> solid <?php echo $affiliseoComparisonRowsBorderColor; ?>;
	border-bottom: <?php echo $affiliseoComparisonRowsBorderSize; ?> solid <?php echo $affiliseoComparisonRowsBorderColor; ?>;
	border-right: <?php echo $affiliseoComparisonColsBorderSize; ?> solid <?php echo $affiliseoComparisonColsBorderColor; ?>;
}

#comparison-table-header{
	border-left: <?php echo $affiliseoComparisonColsBorderSize; ?> solid transparent;
	border-right: <?php echo $affiliseoComparisonColsBorderSize; ?> solid transparent;
}

.hover-row {
	background: <?php echo $affiliseoComparisonRowsHover; ?>;
}

.hover-col {
	background: <?php echo $affiliseoComparisonColsHover; ?>;
}

.compare-send-button {
	color: <?php echo $affiliseoComparisonButtonTextColor; ?>;	
}

.compare-send-button:hover {
	color: <?php echo $affiliseoComparisonButtonTextColorHover; ?>;
	background-color: <?php echo $affiliseoComparisonButtonBgColorHover; ?>;		
}

.compare-send-button-active {
	background-color: <?php echo $affiliseoComparisonButtonBgColor; ?>;
}

.compare-send-button-inactive {
	background-color: <?php echo $affiliseoComparisonButtonBgColorDisabled; ?>;
}

.compare-cell,
.compare-selection-cell {
    border-right: <?php echo $affiliseoComparisonColsBorderSize; ?> solid <?php echo $affiliseoComparisonColsBorderColor; ?>;
    border-top: <?php echo $affiliseoComparisonRowsBorderSize; ?> solid <?php echo $affiliseoComparisonRowsBorderColor; ?>;
}

.compare-selection-cell {
    border-right: <?php echo $affiliseoComparisonColsBorderSize; ?> solid <?php echo $affiliseoComparisonColsBorderColor; ?>;
    border-bottom: <?php echo $affiliseoComparisonRowsBorderSize; ?> solid <?php echo $affiliseoComparisonRowsBorderColor; ?>;
}

.compare-table-labels,
.compare-selection-label {
    border-top: <?php echo $affiliseoComparisonRowsBorderSize; ?> solid <?php echo $affiliseoComparisonRowsBorderColor; ?>;
}

.compare-selection-label {
	border-left: <?php echo $affiliseoComparisonColsBorderSize; ?> solid <?php echo $affiliseoComparisonColsBorderColor; ?>;
	border-right: <?php echo $affiliseoComparisonColsBorderSize; ?> solid <?php echo $affiliseoComparisonColsBorderColor; ?>;
    border-bottom: <?php echo $affiliseoComparisonRowsBorderSize; ?> solid <?php echo $affiliseoComparisonRowsBorderColor; ?>;
}

.compare-choose-cell {
	border-right: <?php echo $affiliseoComparisonColsBorderSize; ?> solid <?php echo $affiliseoComparisonColsBorderColor; ?>;
    border-top: <?php echo $affiliseoComparisonRowsBorderSize; ?> solid <?php echo $affiliseoComparisonRowsBorderColor; ?>;
	border-bottom: <?php echo $affiliseoComparisonRowsBorderSize; ?> solid <?php echo $affiliseoComparisonRowsBorderColor; ?>;
}

.compare-content-body {
	border-left: <?php echo $affiliseoComparisonColsBorderSize; ?> solid <?php echo $affiliseoComparisonColsBorderColor; ?>;
	border-right: <?php echo $affiliseoComparisonColsBorderSize; ?> solid <?php echo $affiliseoComparisonColsBorderColor; ?>;	
}

.price-compare-box {
	background-color: <?php echo $affiliseoPriceComparisonBoxBgColor; ?> !important;
}

.scroll_btn {
	background: url(<?php echo get_template_directory_uri(); ?>/images/scroll_buttons.png) no-repeat transparent;	
}

.ui-corner-all{
	border-radius: <?php echo $affiliseo_border_radius; ?> !important;
}

#wrapper{
	box-shadow: 0 0 <?php echo $affiliseoBoxShadowSpread; ?> <?php echo $affiliseoBoxShadowColor; ?>;
}

<?php
$affiliseoNavigationLateralLineColor = get_theme_mod( 'affiliseo_navigation_lateral_line_color', '#000' );
$affiliseoNavigationLateralLineThickness = get_theme_mod( 'affiliseo_navigation_lateral_line_thickness', '1px' );
$affiliseoNavigationLateralPadding = get_theme_mod( 'affiliseo_navigation_lateral_padding', '10px' );
$affiliseoNavigationHideLateralLine = get_theme_mod( 'affiliseo_navigation_hide_lateral_line', '' );
if(!empty($affiliseoNavigationHideLateralLine)){
    $affiliseoNavigationLateralLineThickness = 0;
}
?>

.navbar-nav > li {
	border-left: <?php echo $affiliseoNavigationLateralLineThickness; ?> solid <?php echo $affiliseoNavigationLateralLineColor; ?>;
}

.navbar-nav > li:last-child {
	border-right: <?php echo $affiliseoNavigationLateralLineThickness; ?> solid <?php echo $affiliseoNavigationLateralLineColor; ?>;
}

.navbar {
	padding-right: <?php echo $affiliseoNavigationLateralPadding; ?>;
	padding-left: <?php echo $affiliseoNavigationLateralPadding; ?>;
}

<?php
if ( !isset($affiliseo_options['disable_cookie_policy_function']) || $affiliseo_options['disable_cookie_policy_function'] != "1" ) {
    ?>
    
.cookie-policy-bar {
	background-color: rgba(<?php echo hexdec( substr( $affiliseoCookiePolicyMessageBgColor, 1, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseoCookiePolicyMessageBgColor, 3, 2 ) ); ?>, <?php echo hexdec( substr( $affiliseoCookiePolicyMessageBgColor, 5, 2 ) ); ?>, <?php echo $affiliseoCookiePolicyBgOpacity / 100; ?>);
}    

.cookie-policy-message {
	color:<?php echo $affiliseoCookiePolicyMessageFontColor; ?>;
	font-size:<?php echo $affiliseoCookiePolicyMessageFontSize; ?>;
}

.cookie-policy-accept-button {
	color:<?php echo $affiliseoCookiePolicyAcceptButtonFontColor; ?>;
	font-size:<?php echo $affiliseoCookiePolicyAcceptButtonFontSize; ?>;
	background-color:<?php echo $affiliseoCookiePolicyAcceptButtonBgColor; ?>;
}

.cookie-policy-read-more-button {
	color:<?php echo $affiliseoCookiePolicyReadMoreButtonFontColor; ?>;
	font-size:<?php echo $affiliseoCookiePolicyReadMoreButtonFontSize; ?>;
	background-color:<?php echo $affiliseoCookiePolicyReadMoreButtonBgColor; ?>;
}
    <?php
}
?>





    

<?php echo $affiliseo_custom_css; ?>

<?php
/*$css_content = ob_get_contents();
ob_end_clean();
$css_file = fopen(__DIR__ . "/custom.css", "w") or die("Unable to open file!");
fwrite($css_file, $css_content);
fclose($css_file);*/
?>