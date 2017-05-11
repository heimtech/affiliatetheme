<?php
add_action('customize_register', 'affiliseo_customize_register');

function affiliseo_customize_register($wp_customize)
{
    $fontFamilyList = array(
        'Open Sans' => 'Open Sans',
        'Roboto' => 'Roboto',
        'Lato' => 'Lato',
        'Oswald' => 'Oswald',
        'Lobster' => 'Lobster',
        'Vollkorn' => 'Vollkorn',
        'Lora' => 'Lora',
        'Ubuntu' => 'Ubuntu',
        'Ubuntu Condensed' => 'Ubuntu Condensed',
        'Arial' => 'Arial',
        'Helvetica' => 'Helvetica',
        'Georgia' => 'Georgia',
        'Sansita One' => 'Sansita One',
        'Walter Turncoat' => 'Walter Turncoat',
        'Rock Salt' => 'Rock Salt',
        'Coda' => 'Coda',
        'Special Elite' => 'Special Elite'
    );
    
    $repeatTypeList = array(
        'no-repeat' => 'nicht wiederholen',
        'repeat-x' => 'horizontal wiederholen',
        'repeat-y' => 'vertikal wiederholen',
        'repeat' => 'immer wiederholen',
        'cover' => 'strecken'
    );
    
    /*
     * SETTINGS
     */
    $wp_customize->add_setting('affiliseo_favicon', '');
    $wp_customize->add_setting('affiliseo_logo', '');
    $wp_customize->add_setting('affiliseo_header_img', '');
    $wp_customize->add_setting('affiliseo_header_img_repeat', array(
        'default' => 'no-repeat',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_header_bg_color', array(
        'default' => '#d4d6d5',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_text_color', array(
        'default' => '#333',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_link_color_default', array(
        'default' => '#428bca',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_link_color_hover', array(
        'default' => '#2a6496',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_box_shadow_color', array(
        'default' => '#c1c1c1',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_box_shadow_spread', array(
        'default' => '15px',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('header_background_opacity', array(
        'default' => '100',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_font_size', array(
        'default' => '14px',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_font_color', array(
        'default' => '#333',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_font_family_headlines', array(
        'default' => 'Open Sans',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_font_family_text', array(
        'default' => 'Open Sans',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_bg_image', '');
    $wp_customize->add_setting('affiliseo_bg_image_repeat', array(
        'default' => 'no-repeat',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_bg_image_fixate', array(
        'default' => '1',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_bg_color', array(
        'default' => '#F1F0F0',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_content_bg_color', array(
        'default' => '#FFFFFF',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_content_product_border_color', array(
        'default' => '#DDD',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_bg_color', array(
        'default' => '#FFFFFF',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_content_bg_opacity', array(
        'default' => '100%',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_back_to_top_bg_color', array(
        'default' => '#009bc2',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_back_to_top_arrow_color', array(
        'default' => '#ffffff',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_back_to_top_bg_opacity', array(
        'default' => '80%',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_hide_back_to_top', array(
        'default' => '',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_product_hover_bg_color', array(
        'default' => '#FFFFFF',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_stars_color', array(
        'default' => '#FF9900',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_sidebar_border_color', array(
        'default' => '#666666',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_sidebar_headline_bg_color', array(
        'default' => '#666666',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_sidebar_headline_img', '');
    $wp_customize->add_setting('affiliseo_sidebar_img_repeat', array(
        'default' => 'no-repeat',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_sidebar_headline_color', array(
        'default' => '#ffffff',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_h3_text_color', array(
        'default' => '#444444',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_sidebar_text_color', array(
        'default' => '#060000',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_sidebar_text_hover_color', array(
        'default' => '#ff6600',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_sidebar_bg_opacity', array(
        'default' => '100%',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_sidebar_bg_color', array(
        'default' => '#ffffff',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_sidebar_bg_linear_gradient_from', array(
        'default' => '',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_sidebar_bg_linear_gradient_to', array(
        'default' => '',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_footer_bg_color', array(
        'default' => '#ACACA8',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_footer_text_color', array(
        'default' => '#fff',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_footer_bg_opacity', array(
        'default' => '100%',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_footer_img', '');
    $wp_customize->add_setting('affiliseo_footer_img_repeat', array(
        'default' => 'no-repeat',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_border_radius', array(
        'default' => '4px',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_submit_button_bg', array(
        'default' => '#ff6600',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_submit_button_bg_hover', array(
        'default' => '#ED9C28',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_submit_button_text_color', array(
        'default' => '#fff',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_submit_button_text_color_hover', array(
        'default' => '#fff',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('product_headline_text_color', array(
        'default' => '#fff',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('product_headline_background_color', array(
        'default' => '#999',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_price_color', array(
        'default' => '#F60',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_grey_box', array(
        'default' => '#F1F1F1',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_grey_box_color', array(
        'default' => '#444',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_navigation_bg_color', array(
        'default' => '#D4D6D5',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_navigation_bg_hover_color', array(
        'default' => '#EEE',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_navigation_text_color', array(
        'default' => '#FFF',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_navigation_text_hover_color', array(
        'default' => '#FFF',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_navigation_border_color', array(
        'default' => '#e7e7e7',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_navigation_margin_top', array(
        'default' => '0px',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_navigation_font_family', array(
        'default' => 'Open Sans',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_navigation_font_size', array(
        'default' => '14px',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_navigation_bg_linear_gradient_from', array(
        'default' => '',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_navigation_bg_linear_gradient_to', array(
        'default' => '',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_navigation_hide_lateral_line', array(
        'default' => '',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_navigation_lateral_line_color', array(
        'default' => '#000',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_navigation_lateral_line_thickness', array(
        'default' => '1px',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_navigation_lateral_padding', array(
        'default' => '10px',
        'transport' => 'postMessage'
    ));
    
    // end navigation
    
    $wp_customize->add_setting('affiliseo_buttons_ap_bg', array(
        'default' => '#F0AD4E',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_ap_bg_hover', array(
        'default' => '#ED9C28',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_ap_bg_image', '');
    $wp_customize->add_setting('affiliseo_buttons_ap_bg_image_repeat', array(
        'default' => 'no-repeat',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_ap_text_color', array(
        'default' => '#FFF',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_ap_text_color_hover', array(
        'default' => '#FFF',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_buttons_ap_cart_bg', array(
        'default' => '#F0AD4E',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_ap_cart_bg_hover', array(
        'default' => '#ED9C28',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_ap_cart_bg_image', '');
    $wp_customize->add_setting('affiliseo_buttons_ap_cart_bg_image_repeat', array(
        'default' => 'no-repeat',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_ap_cart_text_color', array(
        'default' => '#FFF',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_ap_cart_text_color_hover', array(
        'default' => '#FFF',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_buttons_detail_label', array(
        'default' => __('Product description', 'affiliatetheme') . ' &rsaquo;',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_detail_bg', array(
        'default' => '#666',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_detail_bg_image', '');
    $wp_customize->add_setting('affiliseo_buttons_detail_bg_image_repeat', array(
        'default' => 'no-repeat',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_detail_bg_hover', array(
        'default' => '#888',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_detail_text_color', array(
        'default' => '#FFF',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_detail_text_color_hover', array(
        'default' => '#FFF',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_buttons_third_bg', array(
        'default' => '#666',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_third_bg_image', '');
    $wp_customize->add_setting('affiliseo_buttons_third_bg_image_repeat', array(
        'default' => 'no-repeat',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_third_bg_hover', array(
        'default' => '#888',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_third_text_color', array(
        'default' => '#FFF',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_buttons_third_text_color_hover', array(
        'default' => '#FFF',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_wrapper_border_width', array(
        'default' => '3px',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_wrapper_border_color', array(
        'default' => '#FFFFFF',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_wrapper_bg_color', array(
        'default' => '#FFFFFF',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_wrapper_bg_opacity', array(
        'default' => '50%',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_wrapper_headerfooter_margin', array(
        'default' => '0px',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_wrapper_content_margin', array(
        'default' => '15px',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('custom_wrapper_margin_top', array(
        'default' => '0',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_checklist_highlight_color', array(
        'default' => '#e74c3c',
        'transport' => 'postMessage'
    ));
    
    /**
     * PRODUCT-REVIEW-SETTINGS
     */
    
    $wp_customize->add_setting('affiliseo_product_reviews_header_bg_color', array(
        'default' => '#4bb448',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_header_bg_opacity', array(
        'default' => '100%',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_header_font_color', array(
        'default' => '#000',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_header_font_size', array(
        'default' => '12px',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_product_reviews_footer_bg_color', array(
        'default' => '#4bb448',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_footer_bg_opacity', array(
        'default' => '100%',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_summary_top_bg_linear_gradient_from', array(
        'default' => '#f15a3a',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_summary_top_bg_linear_gradient_to', array(
        'default' => '#d43e27',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_summary_top_font_color', array(
        'default' => '#000',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_summary_top_font_size', array(
        'default' => '12px',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_product_reviews_summary_bottom_bg_linear_gradient_from', array(
        'default' => '#e2e2e2',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_summary_bottom_bg_linear_gradient_to', array(
        'default' => '#fff',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_summary_bottom_font_color', array(
        'default' => '#000',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_summary_bottom_font_size', array(
        'default' => '12px',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_product_reviews_summary_percent_font_color', array(
        'default' => '#fff',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_summary_percent_font_size', array(
        'default' => '12px',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_product_reviews_progress_bar_danger', array(
        'default' => '#d9534f',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_progress_bar_warning', array(
        'default' => '#f0ad4e',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_progress_bar_info', array(
        'default' => '#5bc0de',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_product_reviews_progress_bar_success', array(
        'default' => '#5cb85c',
        'transport' => 'postMessage'
    ));
    
    /**
     * COMPARISON-SETTINGS
     */
    $wp_customize->add_setting('affiliseo_comparison_table_font_size', array(
        'default' => '13px',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_header_font_color', array(
        'default' => '#fff',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_header_bg_linear_gradient_from', array(
        'default' => '#919395',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_header_bg_linear_gradient_to', array(
        'default' => '#5f656b',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_header_font_size', array(
        'default' => '13px',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_cols_width', array(
        'default' => '150',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_cols_hover', array(
        'default' => '#ADD8E6',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_rows_hover', array(
        'default' => '#90EE90',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_rows_border_size', array(
        'default' => '1px',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_rows_border_color', array(
        'default' => '#dcdcdc',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_cols_border_size', array(
        'default' => '1px',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_cols_border_color', array(
        'default' => '#dcdcdc',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_button_bg_color_disabled', array(
        'default' => '#cdcdcd',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_button_bg_color', array(
        'default' => '#0085ba',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_button_bg_color_hover', array(
        'default' => '#00FFFF',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_button_text_color', array(
        'default' => '#fff',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_button_text_color_hover', array(
        'default' => '#E6E6FA',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_comparison_highlighted_column_bg_opacity', array(
        'default' => '50%',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_price_comparison_box_bg_color', array(
        'default' => '#eee',
        'transport' => 'postMessage'
    ));
    
    /**
     * UVP-SETTINGS
     */
    $wp_customize->add_setting('affiliseo_uvp_text_color', array(
        'default' => '#a2a1a1',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_uvp_font_size', array(
        'default' => '12',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_uvp_deleted_text_color', array(
        'default' => '#a2a1a1',
        'transport' => 'postMessage'
    ));
    
    /**
     * BLOG-BOX-SETTINGS
     */
    $wp_customize->add_setting('affiliseo_blog_box_border_color', array(
        'default' => '#dddddd',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_blog_box_border_radius', array(
        'default' => '8px',
        'transport' => 'postMessage'
    ));
    
    /**
     * START - COOKIE-POLICY-SETTINGS
     */
    $wp_customize->add_setting('affiliseo_cookie_policy_message_font_size', array(
        'default' => '12px',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_cookie_policy_accept_button_font_size', array(
        'default' => '12px',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_cookie_policy_read_more_button_font_size', array(
        'default' => '12px',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_cookie_policy_bg_opacity', array(
        'default' => '80%',
        'transport' => 'postMessage'
    ));
    
    $wp_customize->add_setting('affiliseo_cookie_policy_message_font_color', array(
        'default' => '#000',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_cookie_policy_message_bg_color', array(
        'default' => '#c1c1c1',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_cookie_policy_accept_button_font_color', array(
        'default' => '#000',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_cookie_policy_accept_button_bg_color', array(
        'default' => '#8dd659',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_cookie_policy_read_more_button_font_color', array(
        'default' => '#000',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_setting('affiliseo_cookie_policy_read_more_button_bg_color', array(
        'default' => '#45b1ef',
        'transport' => 'postMessage'
    ));
    /**
     * END - COOKIE-POLICY-SETTINGS
     */
    
    /*
     * SECTIONS
     */
    $wp_customize->add_section('affiliseo_all_section', array(
        'title' => __('Allgemein', 'affiliseo'),
        'priority' => 9
    ));
    $wp_customize->add_section('affiliseo_wrapper_section', array(
        'title' => __('Seitenrahmen', 'affiliseo'),
        'priority' => 10
    ));
    $wp_customize->add_section('affiliseo_header_section', array(
        'title' => __('Kopfbereich', 'affiliseo'),
        'priority' => 11
    ));
    $wp_customize->add_section('affiliseo_content_section', array(
        'title' => __('Inhalt', 'affiliseo'),
        'priority' => 12
    ));
    $wp_customize->add_section('affiliseo_product_section', array(
        'title' => __('Product', 'affiliatetheme'),
        'priority' => 13
    ));
    $wp_customize->add_section('affiliseo_sidebar_section', array(
        'title' => __('Sidebar', 'affiliseo'),
        'priority' => 14
    ));
    $wp_customize->add_section('affiliseo_footer_section', array(
        'title' => __('Fußbereich', 'affiliseo'),
        'priority' => 15
    ));
    $wp_customize->add_section('affiliseo_stuff_section', array(
        'title' => __('Sonstiges', 'affiliseo'),
        'priority' => 16
    ));
    $wp_customize->add_section('affiliseo_ap_buttons_section', array(
        'title' => __('Affiliate Partner Buttons', 'affiliseo'),
        'priority' => 17
    ));
    
    $wp_customize->add_section('affiliseo_detail_button_section', array(
        'title' => __('Details Button', 'affiliseo'),
        'priority' => 18
    ));
    $wp_customize->add_section('affiliseo_third_button_section', array(
        'title' => __('Weiterer Button', 'affiliseo'),
        'priority' => 19
    ));
    $wp_customize->add_section('affiliseo_checklist_section', array(
        'title' => __('Produktvergleich', 'affiliseo'),
        'priority' => 20
    ));
    $wp_customize->add_section('affiliseo_product_reviews_section', array(
        'title' => __('Produktbewertungen', 'affiliseo'),
        'priority' => 21
    ));
    // COMPARISON-SECTION
    $wp_customize->add_section('affiliseo_comparison_section', array(
        'title' => __('Vergleichstabelle', 'affiliseo'),
        'priority' => 22
    ));
    
    // NAVIGATION-SECTION
    $wp_customize->add_section('affiliseo_nav', array(
        'title' => __('Navigation', 'affiliseo'),
        'priority' => 23
    ));
    
    // UVP-SECTION
    $wp_customize->add_section('affiliseo_uvp_section', array(
        'title' => __('UVP', 'affiliseo'),
        'priority' => 24
    ));
    
    // BLOG-BOX-SECTION
    $wp_customize->add_section('affiliseo_blog_box_section', array(
        'title' => __('Blogvorschau', 'affiliseo'),
        'priority' => 25
    ));
    
    // COOKIE-POLICY-SECTION
    $wp_customize->add_section('affiliseo_cookie_policy_section', array(
        'title' => __('Cookie policy', 'affiliatetheme'),
        'priority' => 26
    ));
    
    // Navigation-PANEL
    $wp_customize->add_panel('navigationjan', array(
        'priority' => 5000,
        'title' => __('Navigationjan', 'affiliseo')
    ));
    
    $wp_customize->add_section('navigation_bar', array(
        'title' => __('Leiste', 'affiliseo'),
        'panel' => 'navigationjan',
        'priority' => 5100
    ));
    
    $wp_customize->add_section('navigation_dropdown', array(
        'title' => __('Dropdown', 'affiliseo'),
        'panel' => 'navigationjan',
        'priority' => 5200
    ));
    
    /*
     * CONTROLS
     */
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_bg_image', array(
        'label' => 'Hintergrundbild',
        'section' => 'affiliseo_all_section',
        'settings' => 'affiliseo_bg_image',
        'priority' => 0
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_bg_image_repeat', array(
        'label' => __('Bilddarstellung', 'affiliseo'),
        'section' => 'affiliseo_all_section',
        'settings' => 'affiliseo_bg_image_repeat',
        'type' => 'select',
        'choices' => 

        $repeatTypeList,
        
        'priority' => 1
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_bg_image_fixate', array(
        'label' => __('Hintergrundbild fixieren', 'affiliseo'),
        'section' => 'affiliseo_all_section',
        'settings' => 'affiliseo_bg_image_fixate',
        'type' => 'checkbox',
        'priority' => 2
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_bg_color', array(
        'label' => __('Hintergrundfarbe', 'affiliseo'),
        'section' => 'affiliseo_all_section',
        'settings' => 'affiliseo_bg_color',
        'priority' => 3
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_font_size', array(
        'label' => __('Schriftgröße', 'affiliseo'),
        'section' => 'affiliseo_all_section',
        'settings' => 'affiliseo_font_size',
        'priority' => 4
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_font_color', array(
        'label' => __('Schriftfarbe', 'affiliseo'),
        'section' => 'affiliseo_all_section',
        'settings' => 'affiliseo_font_color',
        'priority' => 5
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_font_family_headlines', array(
        'label' => __('Schriftart (Headlines)', 'affiliseo'),
        'section' => 'affiliseo_all_section',
        'settings' => 'affiliseo_font_family_headlines',
        'type' => 'select',
        'choices' => $fontFamilyList,
        'priority' => 6
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_font_family_text', array(
        'label' => __('Schriftart (Laufschrift)', 'affiliseo'),
        'section' => 'affiliseo_all_section',
        'settings' => 'affiliseo_font_family_text',
        'type' => 'select',
        'choices' => $fontFamilyList,
        'priority' => 7
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_link_color_default', array(
        'label' => __('Linkfarbe (Standard)', 'affiliseo'),
        'section' => 'affiliseo_all_section',
        'settings' => 'affiliseo_link_color_default',
        'priority' => 8
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_link_color_hover', array(
        'label' => __('Linkfarbe (Hover)', 'affiliseo'),
        'section' => 'affiliseo_all_section',
        'settings' => 'affiliseo_link_color_hover',
        'priority' => 9
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_box_shadow_color', array(
        'label' => __('Box shadow color', 'affiliatetheme'),
        'section' => 'affiliseo_all_section',
        'settings' => 'affiliseo_box_shadow_color',
        'priority' => 10
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_box_shadow_spread', array(
        'label' => __('Box shadow spread', 'affiliatetheme'),
        'section' => 'affiliseo_all_section',
        'settings' => 'affiliseo_box_shadow_spread',
        'priority' => 11
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_wrapper_border_width', array(
        'label' => __('Randstärke', 'affiliseo'),
        'section' => 'affiliseo_wrapper_section',
        'settings' => 'affiliseo_wrapper_border_width',
        'priority' => 0
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_wrapper_border_color', array(
        'label' => __('Randfarbe', 'affiliseo'),
        'section' => 'affiliseo_wrapper_section',
        'settings' => 'affiliseo_wrapper_border_color',
        'priority' => 1
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_wrapper_bg_color', array(
        'label' => __('Hintergrundfarbe', 'affiliseo'),
        'section' => 'affiliseo_wrapper_section',
        'settings' => 'affiliseo_wrapper_bg_color',
        'priority' => 2
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_wrapper_bg_opacity', array(
        'label' => __('Hintergrund-Deckkraft (%)', 'affiliseo'),
        'section' => 'affiliseo_wrapper_section',
        'settings' => 'affiliseo_wrapper_bg_opacity',
        'priority' => 3
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_wrapper_headerfooter_margin', array(
        'label' => __('Abstand zum Seitenrahmen', 'affiliseo'),
        'section' => 'affiliseo_wrapper_section',
        'settings' => 'affiliseo_wrapper_headerfooter_margin',
        'priority' => 4
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_wrapper_content_padding', array(
        'label' => __('Zusätzlicher Abstand zum Inhaltsbereich', 'affiliseo'),
        'section' => 'affiliseo_wrapper_section',
        'settings' => 'affiliseo_wrapper_content_margin',
        'priority' => 5
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_wrapper_content_margin', array(
        'label' => __('Abstand über Header und unter Footer', 'affiliseo'),
        'section' => 'affiliseo_wrapper_section',
        'settings' => 'custom_wrapper_margin_top',
        'priority' => 6
    )));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_favicon', array(
        'label' => 'Favicon',
        'section' => 'affiliseo_header_section',
        'settings' => 'affiliseo_favicon',
        'priority' => 0
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_logo', array(
        'label' => 'Logo',
        'section' => 'affiliseo_header_section',
        'settings' => 'affiliseo_logo',
        'priority' => 1
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_header_img', array(
        'label' => 'Header-Bild',
        'section' => 'affiliseo_header_section',
        'settings' => 'affiliseo_header_img',
        'priority' => 2
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_header_img_repeat', array(
        'label' => __('Bilddarstellung', 'affiliseo'),
        'section' => 'affiliseo_header_section',
        'settings' => 'affiliseo_header_img_repeat',
        'type' => 'select',
        'choices' => $repeatTypeList,
        'priority' => 3
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_header_bg_color_gradient_bottom', array(
        'label' => __('Hintergrundfarbe', 'affiliseo'),
        'section' => 'affiliseo_header_section',
        'settings' => 'affiliseo_header_bg_color',
        'priority' => 5
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_text_color', array(
        'label' => __('Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_header_section',
        'settings' => 'affiliseo_text_color',
        'priority' => 6
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_header_background_opacity', array(
        'label' => __('Deckkraft der Hintergrundfarbe des Headers (in %)', 'affiliseo'),
        'section' => 'affiliseo_header_section',
        'settings' => 'header_background_opacity',
        'priority' => 7
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_content_bg_color', array(
        'label' => __('Hintergrundfarbe (Content-Boxen)', 'affiliseo'),
        'section' => 'affiliseo_content_section',
        'settings' => 'affiliseo_content_bg_color',
        'priority' => 0
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_content_product_border_color', array(
        'label' => __('Rahmenfarbe (Content-Boxen und Produktansicht)', 'affiliseo'),
        'section' => 'affiliseo_content_section',
        'settings' => 'affiliseo_content_product_border_color',
        'priority' => 1
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_content_bg_opacity', array(
        'label' => __('Hintergrund-Deckkraft (%)', 'affiliseo'),
        'section' => 'affiliseo_content_section',
        'settings' => 'affiliseo_content_bg_opacity',
        'priority' => 2
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_back_to_top_bg_color', array(
        'label' => __('HG-Farbe BackToTop', 'affiliseo'),
        'section' => 'affiliseo_content_section',
        'settings' => 'affiliseo_back_to_top_bg_color',
        'priority' => 3
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_back_to_top_arrow_color', array(
        'label' => __('Pfeil-Farbe BackToTop', 'affiliseo'),
        'section' => 'affiliseo_content_section',
        'settings' => 'affiliseo_back_to_top_arrow_color',
        'priority' => 4
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_back_to_top_bg_opacity', array(
        'label' => __('BackToTop HG-Deckkraft (%)', 'affiliseo'),
        'section' => 'affiliseo_content_section',
        'settings' => 'affiliseo_back_to_top_bg_opacity',
        'priority' => 5
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_hide_back_to_top', array(
        'label' => __('BackToTop ausblenden', 'affiliseo'),
        'section' => 'affiliseo_content_section',
        'settings' => 'affiliseo_hide_back_to_top',
        'type' => 'checkbox',
        'priority' => 6
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_bg_color', array(
        'label' => __('Hintergrundfarbe (Produktansicht)', 'affiliseo'),
        'section' => 'affiliseo_product_section',
        'settings' => 'affiliseo_product_bg_color',
        'priority' => 0
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_hover_bg_color', array(
        'label' => __('Hintergrundfarbe (Produktansicht Hovereffekt)', 'affiliseo'),
        'section' => 'affiliseo_product_section',
        'settings' => 'affiliseo_product_hover_bg_color',
        'priority' => 0
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_stars_color', array(
        'label' => __('Farbe Sterne', 'affiliseo'),
        'section' => 'affiliseo_product_section',
        'settings' => 'affiliseo_product_stars_color',
        'priority' => 0
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_sidebar_border_colorr', array(
        'label' => __('Randfarbe', 'affiliseo'),
        'section' => 'affiliseo_sidebar_section',
        'settings' => 'affiliseo_sidebar_border_color',
        'priority' => 1
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_sidebar_bg_linear_gradient_from', array(
        'label' => __('HG-Farbverlauf von oben', 'affiliseo'),
        'section' => 'affiliseo_sidebar_section',
        'settings' => 'affiliseo_sidebar_bg_linear_gradient_from',
        'priority' => 2
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_sidebar_bg_linear_gradient_to', array(
        'label' => __('HG-Farbverlauf bis unten', 'affiliseo'),
        'section' => 'affiliseo_sidebar_section',
        'settings' => 'affiliseo_sidebar_bg_linear_gradient_to',
        'priority' => 3
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_sidebar_headline_bg_color', array(
        'label' => __('Überschrift Hintergrund', 'affiliseo'),
        'section' => 'affiliseo_sidebar_section',
        'settings' => 'affiliseo_sidebar_headline_bg_color',
        'priority' => 4
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_sidebar_headline_img', array(
        'label' => __('Überschrift Hintergrundbild', 'affiliseo'),
        'section' => 'affiliseo_sidebar_section',
        'settings' => 'affiliseo_sidebar_headline_img',
        'priority' => 5
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_sidebar_img_repeat', array(
        'label' => __('Bilddarstellung', 'affiliseo'),
        'section' => 'affiliseo_sidebar_section',
        'settings' => 'affiliseo_sidebar_img_repeat',
        'type' => 'select',
        'choices' => $repeatTypeList,
        'priority' => 6
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_sidebar_headline_color', array(
        'label' => __('Überschrift Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_sidebar_section',
        'settings' => 'affiliseo_sidebar_headline_color',
        'priority' => 7
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_sidebar_text_color', array(
        'label' => __('Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_sidebar_section',
        'settings' => 'affiliseo_sidebar_text_color',
        'priority' => 8
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_sidebar_text_hover_color', array(
        'label' => __('Textfarbe (Hover)', 'affiliseo'),
        'section' => 'affiliseo_sidebar_section',
        'settings' => 'affiliseo_sidebar_text_hover_color',
        'priority' => 9
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_sidebar_bg_color', array(
        'label' => __('Hintergrundfarbe', 'affiliseo'),
        'section' => 'affiliseo_sidebar_section',
        'settings' => 'affiliseo_sidebar_bg_color',
        'priority' => 10
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_sidebar_bg_opacity', array(
        'label' => __('Hintergrund-Deckkraft (%)', 'affiliseo'),
        'section' => 'affiliseo_sidebar_section',
        'settings' => 'affiliseo_sidebar_bg_opacity',
        'priority' => 11
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_footer_bg_color', array(
        'label' => __('Hintergrundfarbe', 'affiliseo'),
        'section' => 'affiliseo_footer_section',
        'settings' => 'affiliseo_footer_bg_color',
        'priority' => 4
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_footer_text_color', array(
        'label' => __('Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_footer_section',
        'settings' => 'affiliseo_footer_text_color',
        'priority' => 5
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_footer_bg_opacity', array(
        'label' => __('Hintergrund-Deckkraft (%)', 'affiliseo'),
        'section' => 'affiliseo_footer_section',
        'settings' => 'affiliseo_footer_bg_opacity',
        'priority' => 7
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_footer_img', array(
        'label' => 'Footer-Bild',
        'section' => 'affiliseo_footer_section',
        'settings' => 'affiliseo_footer_img',
        'priority' => 8
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_footer_img_repeat', array(
        'label' => __('Bilddarstellung', 'affiliseo'),
        'section' => 'affiliseo_footer_section',
        'settings' => 'affiliseo_footer_img_repeat',
        'type' => 'select',
        'choices' => $repeatTypeList,
        'priority' => 9
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_border_radius', array(
        'label' => __('Runde Ecken', 'affiliseo'),
        'section' => 'affiliseo_stuff_section',
        'settings' => 'affiliseo_border_radius',
        'priority' => 1
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_submit_button_bg', array(
        'label' => __('Button Hintergrundfarbe', 'affiliseo'),
        'section' => 'affiliseo_stuff_section',
        'settings' => 'affiliseo_submit_button_bg',
        'priority' => 2
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_submit_button_bg_hover', array(
        'label' => __('Button Hintergrundfarbe (Hover)', 'affiliseo'),
        'section' => 'affiliseo_stuff_section',
        'settings' => 'affiliseo_submit_button_bg_hover',
        'priority' => 3
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_submit_button_text_color', array(
        'label' => __('Button Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_stuff_section',
        'settings' => 'affiliseo_submit_button_text_color',
        'priority' => 4
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_submit_button_text_color_hover', array(
        'label' => __('Button Textfarbe (Hover)', 'affiliseo'),
        'section' => 'affiliseo_stuff_section',
        'settings' => 'affiliseo_submit_button_text_color_hover',
        'priority' => 4
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_headline_text_color', array(
        'label' => __('Überschrift über Produkt - Textfarbe (Headline im Shortcode)', 'affiliseo'),
        'section' => 'affiliseo_product_section',
        'settings' => 'product_headline_text_color',
        'priority' => 5
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_headline_background_color', array(
        'label' => __('Überschrift über Produkt - Hintergrundfarbe (Headline im Shortcode)', 'affiliseo'),
        'section' => 'affiliseo_product_section',
        'settings' => 'product_headline_background_color',
        'priority' => 6
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_h3_text_color', array(
        'label' => __('Überschrift der Produkte', 'affiliseo'),
        'section' => 'affiliseo_product_section',
        'settings' => 'affiliseo_product_h3_text_color',
        'priority' => 7
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_price_color', array(
        'label' => __('Farbe des Preises', 'affiliseo'),
        'section' => 'affiliseo_product_section',
        'settings' => 'affiliseo_product_price_color',
        'priority' => 8
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_grey_box', array(
        'label' => __('Hintergrundfarbe Box um Preis und Kommentare', 'affiliseo'),
        'section' => 'affiliseo_product_section',
        'settings' => 'affiliseo_product_grey_box',
        'priority' => 9
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_grey_box_color', array(
        'label' => __('Textfarbe Box um Preis und Kommentare', 'affiliseo'),
        'section' => 'affiliseo_product_section',
        'settings' => 'affiliseo_product_grey_box_color',
        'priority' => 10
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_navigation_bg_color', array(
        'label' => __('Hintergrundfarbe', 'affiliseo'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_bg_color',
        'priority' => 12
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_navigation_bg_linear_gradient_from', array(
        'label' => __('HG-Farbverlauf von oben', 'affiliseo'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_bg_linear_gradient_from',
        'priority' => 13
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_navigation_bg_linear_gradient_to', array(
        'label' => __('HG-Farbverlauf bis unten', 'affiliseo'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_bg_linear_gradient_to',
        'priority' => 14
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_navigation_bg_hover_color', array(
        'label' => __('Hintergrundfarbe (Hover)', 'affiliseo'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_bg_hover_color',
        'priority' => 15
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_navigation_text_color', array(
        'label' => __('Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_text_color',
        'priority' => 16
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_navigation_text_hover_color', array(
        'label' => __('Textfarbe (Hover)', 'affiliseo'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_text_hover_color',
        'priority' => 17
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_navigation_font_family', array(
        'label' => __('Schriftart', 'affiliseo'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_font_family',
        'type' => 'select',
        'choices' => 

        $fontFamilyList,
        
        'priority' => 18
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_navigation_font_size', array(
        'label' => __('Schriftgröße', 'affiliseo'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_font_size',
        'priority' => 19
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_navigation_margin_top', array(
        'label' => __('Abstand Header zu Navigation', 'affiliseo'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_margin_top',
        'priority' => 20
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_navigation_border_color', array(
        'label' => __('Randfarbe', 'affiliseo'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_border_color',
        'priority' => 21
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_navigation_lateral_line_color', array(
        'label' => __('Lateral line color in navigation', 'affiliatetheme'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_lateral_line_color',
        'priority' => 22
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_navigation_lateral_line_thickness', array(
        'label' => __('Lateral line thickness', 'affiliatetheme'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_lateral_line_thickness',
        'priority' => 23
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_navigation_hide_lateral_line', array(
        'label' => __('Hide lateral line', 'affiliatetheme'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_hide_lateral_line',
        'type' => 'checkbox',
        'priority' => 24
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_navigation_lateral_padding', array(
        'label' => __('Lateral distance of navigation', 'affiliatetheme'),
        'section' => 'affiliseo_nav',
        'settings' => 'affiliseo_navigation_lateral_padding',
        'priority' => 25
    )));
    
    // end affiliseo_nav
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_ap_bg', array(
        'label' => __('Hintergrundfarbe', 'affiliseo'),
        'section' => 'affiliseo_ap_buttons_section',
        'settings' => 'affiliseo_buttons_ap_bg',
        'priority' => 8
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_buttons_ap_bg_image', array(
        'label' => 'Hintergrundbild',
        'section' => 'affiliseo_ap_buttons_section',
        'settings' => 'affiliseo_buttons_ap_bg_image',
        'priority' => 9
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_buttons_ap_bg_image_repeat', array(
        'label' => __('Bilddarstellung', 'affiliseo'),
        'section' => 'affiliseo_ap_buttons_section',
        'settings' => 'affiliseo_buttons_ap_bg_image_repeat',
        'type' => 'select',
        'choices' => $repeatTypeList,
        'priority' => 10
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_ap_bg_hover', array(
        'label' => __('Hintergrundfarbe (Hover)', 'affiliseo'),
        'section' => 'affiliseo_ap_buttons_section',
        'settings' => 'affiliseo_buttons_ap_bg_hover',
        'priority' => 11
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_ap_text_color', array(
        'label' => __('Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_ap_buttons_section',
        'settings' => 'affiliseo_buttons_ap_text_color',
        'priority' => 12
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_ap_text_color_hover', array(
        'label' => __('Textfarbe (Hover)', 'affiliseo'),
        'section' => 'affiliseo_ap_buttons_section',
        'settings' => 'affiliseo_buttons_ap_text_color_hover',
        'priority' => 13
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_ap_cart_bg', array(
        'label' => __('Hintergrundfarbe (Warenkorb-Button)', 'affiliseo'),
        'section' => 'affiliseo_ap_buttons_section',
        'settings' => 'affiliseo_buttons_ap_cart_bg',
        'priority' => 14
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_buttons_ap_cart_bg_image', array(
        'label' => 'Hintergrundbild (Warenkorb-Button)',
        'section' => 'affiliseo_ap_buttons_section',
        'settings' => 'affiliseo_buttons_ap_cart_bg_image',
        'priority' => 15
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_buttons_ap_cart_bg_image_repeat', array(
        'label' => __('Bilddarstellung (Warenkorb-Button)', 'affiliseo'),
        'section' => 'affiliseo_ap_buttons_section',
        'settings' => 'affiliseo_buttons_ap_cart_bg_image_repeat',
        'type' => 'select',
        'choices' => $repeatTypeList,
        'priority' => 16
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_ap_cart_bg_hover', array(
        'label' => __('Hintergrundfarbe (Hover) (Warenkorb-Button)', 'affiliseo'),
        'section' => 'affiliseo_ap_buttons_section',
        'settings' => 'affiliseo_buttons_ap_cart_bg_hover',
        'priority' => 17
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_ap_cart_text_color', array(
        'label' => __('Textfarbe', 'affiliseo') . ' (Warenkorb-Button)',
        'section' => 'affiliseo_ap_buttons_section',
        'settings' => 'affiliseo_buttons_ap_cart_text_color',
        'priority' => 18
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_ap_cart_text_color_hover', array(
        'label' => __('Textfarbe (Hover)', 'affiliseo') . ' (Warenkorb-Button)',
        'section' => 'affiliseo_ap_buttons_section',
        'settings' => 'affiliseo_buttons_ap_cart_text_color_hover',
        'priority' => 19
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_buttons_detail_label', array(
        'label' => __('Label', 'affiliseo'),
        'section' => 'affiliseo_detail_button_section',
        'settings' => 'affiliseo_buttons_detail_label',
        'priority' => 9
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_detail_bg', array(
        'label' => __('Hintergrundfarbe', 'affiliseo'),
        'section' => 'affiliseo_detail_button_section',
        'settings' => 'affiliseo_buttons_detail_bg',
        'priority' => 10
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_buttons_detail_bg_image', array(
        'label' => 'Hintergrundbild',
        'section' => 'affiliseo_detail_button_section',
        'settings' => 'affiliseo_buttons_detail_bg_image',
        'priority' => 11
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_buttons_detail_bg_image_repeat', array(
        'label' => __('Bilddarstellung', 'affiliseo'),
        'section' => 'affiliseo_detail_button_section',
        'settings' => 'affiliseo_buttons_detail_bg_image_repeat',
        'type' => 'select',
        'choices' => $repeatTypeList,
        'priority' => 12
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_detail_bg_hover', array(
        'label' => __('Hintergrundfarbe (Hover)', 'affiliseo'),
        'section' => 'affiliseo_detail_button_section',
        'settings' => 'affiliseo_buttons_detail_bg_hover',
        'priority' => 13
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_detail_text_color', array(
        'label' => __('Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_detail_button_section',
        'settings' => 'affiliseo_buttons_detail_text_color',
        'priority' => 14
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_detail_text_color_hover', array(
        'label' => __('Textfarbe (Hover)', 'affiliseo'),
        'section' => 'affiliseo_detail_button_section',
        'settings' => 'affiliseo_buttons_detail_text_color_hover',
        'priority' => 15
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_third_bg', array(
        'label' => __('Hintergrundfarbe', 'affiliseo'),
        'section' => 'affiliseo_third_button_section',
        'settings' => 'affiliseo_buttons_third_bg',
        'priority' => 10
    )));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_buttons_third_bg_image', array(
        'label' => 'Hintergrundbild',
        'section' => 'affiliseo_third_button_section',
        'settings' => 'affiliseo_buttons_third_bg_image',
        'priority' => 11
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_buttons_third_bg_image_repeat', array(
        'label' => __('Bilddarstellung', 'affiliseo'),
        'section' => 'affiliseo_third_button_section',
        'settings' => 'affiliseo_buttons_third_bg_image_repeat',
        'type' => 'select',
        'choices' => $repeatTypeList,
        'priority' => 12
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_third_bg_hover', array(
        'label' => __('Hintergrundfarbe (Hover)', 'affiliseo'),
        'section' => 'affiliseo_third_button_section',
        'settings' => 'affiliseo_buttons_third_bg_hover',
        'priority' => 13
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_third_text_color', array(
        'label' => __('Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_third_button_section',
        'settings' => 'affiliseo_buttons_third_text_color',
        'priority' => 14
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_buttons_third_text_color_hover', array(
        'label' => __('Textfarbe (Hover)', 'affiliseo'),
        'section' => 'affiliseo_third_button_section',
        'settings' => 'affiliseo_buttons_third_text_color_hover',
        'priority' => 15
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_checklist_highlight_color', array(
        'label' => __('Hintergrund- oder Rahmenfarbe der Produktempfehlung', 'affiliseo'),
        'section' => 'affiliseo_checklist_section',
        'settings' => 'affiliseo_checklist_highlight_color',
        'priority' => 8
    )));
    
    // PRODUCT-REVIEWS-CONTROLS
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_header_bg_color', array(
        'label' => __('Header-Hintergrundfarbe', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_header_bg_color',
        'priority' => 1
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_product_reviews_header_bg_opacity', array(
        'label' => __('Hintergrund-Deckkraft (%)', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_header_bg_opacity',
        'priority' => 2
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_header_font_color', array(
        'label' => __('Header-Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_header_font_color',
        'priority' => 3
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_product_reviews_header_font_size', array(
        'label' => __('Header-Schriftgröße (z.B. 12px)', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_header_font_size',
        'priority' => 4
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_footer_bg_color', array(
        'label' => __('Footer-Hintergrundfarbe', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_footer_bg_color',
        'priority' => 5
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_product_reviews_footer_bg_opacity', array(
        'label' => __('Hintergrund-Deckkraft (%)', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_footer_bg_opacity',
        'priority' => 6
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_summary_top_bg_linear_gradient_from', array(
        'label' => __('Zusammenfassung (oben) HG-Farbverlauf-Anfang', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_summary_top_bg_linear_gradient_from',
        'priority' => 7
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_summary_top_bg_linear_gradient_to', array(
        'label' => __('Zusammenfassung (oben) HG-Farbverlauf-Ende', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_summary_top_bg_linear_gradient_to',
        'priority' => 8
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_summary_top_font_color', array(
        'label' => __('Zusammenfassung (oben) - Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_summary_top_font_color',
        'priority' => 9
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_product_reviews_summary_top_font_size', array(
        'label' => __('Zusammenfassung (oben) - Schriftgröße (z.B. 12px)', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_summary_top_font_size',
        'priority' => 10
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_summary_bottom_bg_linear_gradient_from', array(
        'label' => __('Zusammenfassung (unten) HG-Farbverlauf-Anfang', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_summary_bottom_bg_linear_gradient_from',
        'priority' => 11
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_summary_bottom_bg_linear_gradient_to', array(
        'label' => __('Zusammenfassung (unten) HG-Farbverlauf-Ende', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_summary_bottom_bg_linear_gradient_to',
        'priority' => 12
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_summary_bottom_font_color', array(
        'label' => __('Zusammenfassung (unten) - Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_summary_bottom_font_color',
        'priority' => 13
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_product_reviews_summary_bottom_font_size', array(
        'label' => __('Zusammenfassung (unten) - Schriftgröße (z.B. 12px)', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_summary_bottom_font_size',
        'priority' => 14
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_summary_percent_font_color', array(
        'label' => __('Textfarbe für %-Angabe', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_summary_percent_font_color',
        'priority' => 15
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_product_reviews_summary_percent_font_size', array(
        'label' => __('Schriftgröße für %-Angabe (z.B. 12px)', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_summary_percent_font_size',
        'priority' => 16
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_progress_bar_danger', array(
        'label' => __('Balkenfarbe für kleiner als 40%', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_progress_bar_danger',
        'priority' => 17
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_progress_bar_warning', array(
        'label' => __('Balkenfarbe für zwischen 40% und 50%', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_progress_bar_warning',
        'priority' => 18
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_progress_bar_info', array(
        'label' => __('Balkenfarbe für zwischen 50% und 70%', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_progress_bar_info',
        'priority' => 19
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_product_reviews_progress_bar_success', array(
        'label' => __('Balkenfarbe für größer als 70%', 'affiliseo'),
        'section' => 'affiliseo_product_reviews_section',
        'settings' => 'affiliseo_product_reviews_progress_bar_success',
        'priority' => 20
    )));
    
    // COMPARISON-CONTROLS
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_comparison_table_font_size', array(
        'label' => __('Schriftgröße - Tabelle (z.B. 13px)', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_table_font_size',
        'priority' => 1
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_comparison_header_font_color', array(
        'label' => __('Kopfzeile - Textfarbe', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_header_font_color',
        'priority' => 2
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_comparison_header_bg_linear_gradient_from', array(
        'label' => __('Kopfzeile HG-Farbverlauf-Anfang', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_header_bg_linear_gradient_from',
        'priority' => 3
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_comparison_header_bg_linear_gradient_to', array(
        'label' => __('Kopfzeile HG-Farbverlauf-Ende', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_header_bg_linear_gradient_to',
        'priority' => 4
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_comparison_header_font_size', array(
        'label' => __('Schriftgröße Kopfzeile (z.B. 12px)', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_header_font_size',
        'priority' => 5
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_comparison_cols_width', array(
        'label' => __('Spaltenbreite (z.B. 150)', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_cols_width',
        'type' => 'number',
        'input_attrs' => array(
            'min'   => 150
        ), 
        'priority' => 6
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_comparison_cols_hover', array(
        'label' => __('Hoverfarbe - horizontal', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_cols_hover',
        'priority' => 7
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_comparison_rows_hover', array(
        'label' => __('Hoverfarbe - vertikal', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_rows_hover',
        'priority' => 8
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_comparison_rows_border_size', array(
        'label' => __('Rahmenstärke - horizontal (z.B. 1px)', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_rows_border_size',
        'priority' => 9
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_comparison_rows_border_color', array(
        'label' => __('Rahmenfarbe - horizontal', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_rows_border_color',
        'priority' => 10
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_comparison_cols_border_size', array(
        'label' => __('Rahmenstärke - vertikal (z.B. 1px)', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_cols_border_size',
        'priority' => 11
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_comparison_cols_border_color', array(
        'label' => __('Rahmenfarbe - vertikal', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_cols_border_color',
        'priority' => 12
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_comparison_button_bg_color_disabled', array(
        'label' => __('HG-Farbe - Vergleichbutton(deaktiviert)', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_button_bg_color_disabled',
        'priority' => 13
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_comparison_button_bg_color', array(
        'label' => __('HG-Farbe - Vergleichbutton', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_button_bg_color',
        'priority' => 14
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_comparison_button_bg_color_hover', array(
        'label' => __('HG-Farbe - Vergleichbutton(hover)', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_button_bg_color_hover',
        'priority' => 15
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_comparison_button_text_color', array(
        'label' => __('Schriftfarbe - Vergleichbutton', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_button_text_color',
        'priority' => 16
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_comparison_button_text_color_hover', array(
        'label' => __('Schriftfarbe (Hover) - Vergleichbutton', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_button_text_color_hover',
        'priority' => 17
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_comparison_highlighted_column_bg_opacity', array(
        'label' => __('Hervorgehobene Spalten Hintergrund-Deckkraft (%)', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_comparison_highlighted_column_bg_opacity',
        'priority' => 18
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_affiliseo_price_comparison_box_bg_color', array(
        'label' => __('HG-Farbe - Preisvergleichsbox', 'affiliseo'),
        'section' => 'affiliseo_comparison_section',
        'settings' => 'affiliseo_price_comparison_box_bg_color',
        'priority' => 19
    )));
    
    /**
     * UVP-CONTROL
     */
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_uvp_text_color', array(
        'label' => __('UVP Schriftfarbe', 'affiliseo'),
        'section' => 'affiliseo_uvp_section',
        'settings' => 'affiliseo_uvp_text_color',
        'priority' => 1
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_uvp_deleted_text_color', array(
        'label' => __('UVP Strichfarbe', 'affiliseo'),
        'section' => 'affiliseo_uvp_section',
        'settings' => 'affiliseo_uvp_deleted_text_color',
        'priority' => 2
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_uvp_font_size', array(
        'label' => __('UVP Schriftgröße (z.B. 12px)', 'affiliseo'),
        'section' => 'affiliseo_uvp_section',
        'settings' => 'affiliseo_uvp_font_size',
        'priority' => 3
    )));
    
    /**
     * BLOG-BOX-CONTROL
     */
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_blog_box_border_color', array(
        'label' => __('Randfarbe', 'affiliseo'),
        'section' => 'affiliseo_blog_box_section',
        'settings' => 'affiliseo_blog_box_border_color',
        'priority' => 1
    )));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_blog_box_border_radius', array(
        'label' => __('Randradius', 'affiliseo'),
        'section' => 'affiliseo_blog_box_section',
        'settings' => 'affiliseo_blog_box_border_radius',
        'priority' => 2
    )));
    
    /**
     * START - COOKIE-POLICY-CONTROLS
     */
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_cookie_policy_message_font_size', array(
        'label' => __('Message font size', 'affiliatetheme'),
        'section' => 'affiliseo_cookie_policy_section',
        'settings' => 'affiliseo_cookie_policy_message_font_size',
        'priority' => 1
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_cookie_policy_accept_button_font_size', array(
        'label' => __('Accept button font size', 'affiliatetheme'),
        'section' => 'affiliseo_cookie_policy_section',
        'settings' => 'affiliseo_cookie_policy_accept_button_font_size',
        'priority' => 2
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_cookie_policy_read_more_button_font_size', array(
        'label' => __('Read more button font size', 'affiliatetheme'),
        'section' => 'affiliseo_cookie_policy_section',
        'settings' => 'affiliseo_cookie_policy_read_more_button_font_size',
        'priority' => 3
    )));
    
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_cookie_policy_bg_opacity', array(
        'label' => __('Cookie policy background opacitiy (%)', 'affiliatetheme'),
        'section' => 'affiliseo_cookie_policy_section',
        'settings' => 'affiliseo_cookie_policy_bg_opacity',
        'priority' => 4
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_cookie_policy_message_font_color', array(
        'label' => __('Message font color', 'affiliatetheme'),
        'section' => 'affiliseo_cookie_policy_section',
        'settings' => 'affiliseo_cookie_policy_message_font_color',
        'priority' => 5
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_cookie_policy_message_bg_color', array(
        'label' => __('Message background color', 'affiliatetheme'),
        'section' => 'affiliseo_cookie_policy_section',
        'settings' => 'affiliseo_cookie_policy_message_bg_color',
        'priority' => 6
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_cookie_policy_accept_button_font_color', array(
        'label' => __('Accept button font color', 'affiliatetheme'),
        'section' => 'affiliseo_cookie_policy_section',
        'settings' => 'affiliseo_cookie_policy_accept_button_font_color',
        'priority' => 7
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_cookie_policy_accept_button_bg_color', array(
        'label' => __('Accept button bg color', 'affiliatetheme'),
        'section' => 'affiliseo_cookie_policy_section',
        'settings' => 'affiliseo_cookie_policy_accept_button_bg_color',
        'priority' => 8
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_cookie_policy_read_more_button_font_color', array(
        'label' => __('Read more button font color', 'affiliatetheme'),
        'section' => 'affiliseo_cookie_policy_section',
        'settings' => 'affiliseo_cookie_policy_read_more_button_font_color',
        'priority' => 9
    )));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_cookie_policy_read_more_button_bg_color', array(
        'label' => __('Read more button background color', 'affiliatetheme'),
        'section' => 'affiliseo_cookie_policy_section',
        'settings' => 'affiliseo_cookie_policy_read_more_button_bg_color',
        'priority' => 10
    )));
    
    /**
     * END - COOKIE-POLICY-CONTROLS
     */
    
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    
    /*
     * LIVE PREVIEW
     */
    if ($wp_customize->is_preview() && ! is_admin())
        add_action('wp_footer', 'affiliseo_customize_preview', 21);

    function affiliseo_customize_preview()
    {
        ?>
<script type="text/javascript">	
            WebFontConfig = {
                google: {families: ['Rock+Salt::latin', 'Sansita+One::latin', 'Special+Elite::latin', 'Walter+Turncoat::latin', 'Coda::latin']}
            };
            (function () {
                var wf = document.createElement('script');
                wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                        '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                wf.type = 'text/javascript';
                wf.async = 'true';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(wf, s);
            })();

            (function ($) {
                // ALLGEMEIN
                wp.customize('affiliseo_header_bg_color', function (value) {
                    value.bind(function (to) {
                        $('header').css('background-color', to);
                        //$('header').attr('style', 'background: -moz-linear-gradient(top, ' + wp.customize._value.affiliseo_header_bg_color() + ' 0%, ' + to + ' 50px); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,' + wp.customize._value.affiliseo_header_bg_color() + '), color-stop(50px,' + to + ')); background: -webkit-linear-gradient(top, ' + wp.customize._value.affiliseo_header_bg_color() + ' 0%,' + to + ' 50px); background: -o-linear-gradient(top, ' + wp.customize._value.affiliseo_header_bg_color() + ' 0%,' + to + ' 50px); background: -ms-linear-gradient(top, ' + wp.customize._value.affiliseo_header_bg_color() + ' 0%,' + to + ' 50px); background: linear-gradient(to bottom, ' + wp.customize._value.affiliseo_header_bg_color() + ' 0%,' + to + ' 50px); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="' + wp.customize._value.affiliseo_header_bg_color() + '", endColorstr="' + to + '",GradientType=0 );');
                        //$('.site_title').attr('style', 'background: -moz-linear-gradient(top, ' + wp.customize._value.affiliseo_header_bg_color() + ' 0%, ' + to + ' 50px); background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,' + wp.customize._value.affiliseo_header_bg_color() + '), color-stop(50px,' + to + ')); background: -webkit-linear-gradient(top, ' + wp.customize._value.affiliseo_header_bg_color() + ' 0%,' + to + ' 50px); background: -o-linear-gradient(top, ' + wp.customize._value.affiliseo_header_bg_color() + ' 0%,' + to + ' 50px); background: -ms-linear-gradient(top, ' + wp.customize._value.affiliseo_header_bg_color() + ' 0%,' + to + ' 50px); background: linear-gradient(to bottom, ' + wp.customize._value.affiliseo_header_bg_color() + ' 0%,' + to + ' 50px); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="' + wp.customize._value.affiliseo_header_bg_color() + '", endColorstr="' + to + '",GradientType=0 );');
                    });
                });
                wp.customize('affiliseo_header_img', function (value) {
                    value.bind(function (to) {
                        $('header').css('background-image', 'url(' + to + ')');
                    });
                });
                wp.customize('header_background_opacity', function (value) {
                    value.bind(function (to) {
                        $('header').css('opacity', to / 100);
                    });
                });
                wp.customize('affiliseo_text_color', function (value) {
                    value.bind(function (to) {
                        $('header').css('color', to);
                        $('.site_title').css('color', to);
                    });
                });
                wp.customize('affiliseo_font_color', function (value) {
                    value.bind(function (to) {
                        $('body').css('color', to);
                    });
                });
                wp.customize('affiliseo_link_color_default', function (value) {
                    value.bind(function (to) {
                        $('a').css('color', to);
                    })
                });
                wp.customize('affiliseo_link_color_hover', function (value) {
                    value.bind(function (to) {
                        $('a').hover(function () {
                            $(this).css('color', to);
                        });
                    });
                });

                // SEITENRAHMEN
                wp.customize('affiliseo_wrapper_headerfooter_margin', function (value) {
                    value.bind(function (to) {
                        $('.custom-wrapper').css('padding-left', to);
                        $('.custom-wrapper').css('padding-right', to);
                    });
                });

                // INHALT
                wp.customize('affiliseo_content_bg_color', function (value) {
                    value.bind(function (to) {
                        $('#content-wrapper .box').css('background', to);
                        $('.content .box').css('background', to);
                    });
                });

                // PRODUKTANSICHT
                wp.customize('affiliseo_product_bg_color', function (value) {
                    value.bind(function (to) {
                        $('thumbnail').css('background', to);
                    });
                });

                wp.customize('affiliseo_product_h3_text_color', function (value) {
                    value.bind(function (to) {
                        $('.produkte .thumbnail h3').css('color', to);
                        $('.produkte .thumbnail h3 a').css('color', to);
                        $('#h1-product').css('color', to);
                    });
                });

                // ALLGEMEIN
                wp.customize('affiliseo_font_size', function (value) {
                    value.bind(function (to) {
                        $('body').css('font-size', to);
                    });
                });
                wp.customize('affiliseo_bg_color', function (value) {
                    value.bind(function (to) {
                        $('body').css('background', to);
                    });
                });
                wp.customize('affiliseo_font_family_headlines', function (value) {
                    value.bind(function (to) {
                        $('h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .nav').css('font-family', to);
                    });
                });
                wp.customize('affiliseo_font_family_text', function (value) {
                    value.bind(function (to) {
                        $('body').css('font-family', to);
                    });
                });

                // SIDEBAR
                wp.customize('affiliseo_sidebar_border_color', function (value) {
                    value.bind(function (to) {
                        $('#sidebar .widget').css('border', '1px solid ' + to);
                    });
                });
                wp.customize('affiliseo_sidebar_headline_bg_color', function (value) {
                    value.bind(function (to) {
                        $('#sidebar .widget .h1').css('background', to);
                    });
                });
                wp.customize('affiliseo_sidebar_headline_color', function (value) {
                    value.bind(function (to) {
                        $('#sidebar .widget .h1').css('color', to);
                    });
                });
                wp.customize('affiliseo_sidebar_text_color', function (value) {
                    value.bind(function (to) {
                        $('#sidebar .widget ul li a').css('color', to);
                        $('#sidebar .widget .produkt a').css('color', to);
                    });
                });
                wp.customize('affiliseo_sidebar_text_hover_color', function (value) {
                    value.bind(function (to) {
                        $('#sidebar .widget ul li.current-menu-item a').css('color', to);
                        $('#sidebar .widget ul li a:hover').css('color', to);
                    });
                });

                // FOOTER
                wp.customize('affiliseo_footer_bg_color', function (value) {
                    value.bind(function (to) {
                        $('footer').css('background-color', to);
                    });
                });
                wp.customize('affiliseo_footer_text_color', function (value) {
                    value.bind(function (to) {
                        $('footer').css('color', to);
                        $('footer a').css('color', to);
                    });
                });

                // SONSTIGES
                wp.customize('affiliseo_border_radius', function (value) {
                    value.bind(function (to) {
                        $('.btn').css('border-radius', to);
                        $('.btn').css('-moz-border-radius', to);
                        $('.btn').css('-webkit-border-radius', to);
                        $('#sidebar .widget').css('border-radius', to);
                        $('#sidebar .widget').css('-moz-border-radius', to);
                        $('#sidebar .widget').css('-webkit-border-radius', to);
                        $('.form-control').css('border-radius', to);
                        $('.form-control').css('-moz-border-radius', to);
                        $('.form-control').css('-webkit-border-radius', to);
                        $('.form-control').css('-webkit-border-radius', to);
                        $('#navigation ul.navbar-default').css('border-radius', to);
                        $('#navigation ul.navbar-default').css('-moz-border-radius', to);
                        $('#navigation ul.navbar-default').css('-webkit-border-radius', to);
                        $('#navigation ul.navbar-default').css('-webkit-border-radius', to);
                        $('#sidebar .widget .h1').css('border-top-left-radius', to);
                        $('#sidebar .widget .h1').css('-moz-border-top-left-radius', to);
                        $('#sidebar .widget .h1').css('-webkit-border-top-left-radius', to);
                        $('#sidebar .widget .h1').css('-o-border-top-left-radius', to);
                        $('#sidebar .widget .h1').css('border-top-right-radius', to);
                        $('#sidebar .widget .h1').css('-moz-border-top-right-radius', to);
                        $('#sidebar .widget .h1').css('-webkit-border-top-right-radius', to);
                        $('#sidebar .widget .h1').css('-o-border-top-right-radius', to);
                    });
                });
                wp.customize('affiliseo_submit_button_bg', function (value) {
                    value.bind(function (to) {
                        $('form [type="submit"]').css('background', to);
                    });
                });
                wp.customize('affiliseo_submit_button_text_color', function (value) {
                    value.bind(function (to) {
                        $('form [type="submit"]').css('color', to);
                    });
                });
                wp.customize('product_headline_text_color', function (value) {
                    value.bind(function (to) {
                        $('form [type="submit"]').css('color', to);
                    });
                });
                wp.customize('product_headline_background_color', function (value) {
                    value.bind(function (to) {
                        $('form [type="submit"]').css('color', to);
                    });
                });

                // NAVIGATION
                wp.customize('affiliseo_navigation_bg_color', function (value) {
                	value.bind(function (to) {                        
                        $('.navbar-default').css('background', to);
                    });
                });

                wp.customize('affiliseo_navigation_text_color', function (value) {
                    value.bind(function (to) {
                        $('.navbar-default .navbar-nav > li > a').css('color', to);
                    });
                });

                // AFFILIATE-PARTNET-BUTTONS
                wp.customize('affiliseo_buttons_ap_bg', function (value) {
                    value.bind(function (to) {
                        $('.btn-ap').css('background-color', to);
                        $('.btn-ap').css('border-color', to);
                    });
                });
                wp.customize('affiliseo_buttons_ap_text_color', function (value) {
                    value.bind(function (to) {
                        $('.btn-ap').css('color', to);
                    });
                });

                // DETAILS BUTTONS
                wp.customize('affiliseo_buttons_detail_bg', function (value) {
                    value.bind(function (to) {
                        $('.btn-detail').css('background-color', to);
                        $('.btn-detail').css('border-color', to);
                    });
                });
                wp.customize('affiliseo_buttons_detail_text_color', function (value) {
                    value.bind(function (to) {
                        $('.btn-detail').css('color', to);
                    });
                });
            })(jQuery)
        </script>

<?php
    }
}