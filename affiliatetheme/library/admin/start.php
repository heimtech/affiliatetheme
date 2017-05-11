<?php

/**
 * Adds the custom admin panel to the admin area
 */
function affiliseo_admin() {
    include( AFFILISEO_ADMIN . '/panel.php');
}

function affiliseo_admin_init() {
    
    wp_register_script('jquery_ui_js', get_template_directory_uri() . "/jquery-ui/jquery-ui.min.js", false, "1.11.2");
    
    //wp_enqueue_style("jquery_custom", get_template_directory_uri() . "/_/js/jquery-1.11.3.min.js", false, "1.0", "all");
    
    #wp_enqueue_style("bootstrap", get_stylesheet_directory_uri() . "/bootstrap/css/bootstrap.min.css", false, "1.0", "all");
    #wp_enqueue_style("bootstrap_js", get_stylesheet_directory_uri() . "/bootstrap/js/bootstrap.min.js", false, "1.0", "all");
    wp_enqueue_style("admin_css", AFFILISEO_ADMIN_CSS . "/admin.css", false, "1.0", "all"); // CSS
    wp_enqueue_style("font_awesome_admin", get_template_directory_uri() . "/css/font-awesome-4.7.0/css/font-awesome.min.css", false, "1.0", "all"); // CSS
    wp_enqueue_style("taxonomies_images", get_template_directory_uri() . "/library/admin/css/taxonomies-images.css", false, "1.0", "all");
    wp_enqueue_script(array("jquery", "jquery-ui-core", "interface", "jquery-ui-sortable", "wp-lists", "jquery-ui-sortable", "jquery_ui_js")); // jQuery UI Sortable

    /* Register our script. This is loaded only in the Theme admin panel */
    wp_register_script('admin_js', AFFILISEO_ADMIN_JS . '/admin.js', false, "1.0");
    wp_register_script('font_awesome', AFFILISEO_ADMIN_JS . '/font-awesome.js', false, "1.0");
    
    
    wp_enqueue_style("jquery_ui_css", get_template_directory_uri() . "/jquery-ui/jquery-ui.min.css", false, "1.10.2", "all");
    
    
}

// Adds the Theme Option Menu to the Wordpress admin area
function affiliseo_admin_menu() {
    $page = add_menu_page(AFFILISEO_THEMENAME, AFFILISEO_THEMENAME, 'administrator', AFFILISEO_THEMESHORTNAME, "affiliseo_admin");
    add_action('admin_print_scripts-' . $page, 'affiliseo_admin_scripts');
}

function affiliseo_admin_scripts() {
    wp_enqueue_script('admin_js');
}

add_action('admin_init', 'affiliseo_admin_init');
add_action('admin_menu', 'affiliseo_admin_menu');
