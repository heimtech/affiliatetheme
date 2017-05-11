<?php
add_action( "wp_enqueue_scripts", "theme_enqueue_styles" );

function theme_enqueue_styles() {
	wp_enqueue_style( "parent-style", get_template_directory_uri() . "/style.css" );
	wp_enqueue_style( "child-style", get_stylesheet_uri(), array( "parent-style" ) );

	/* fix Library issue / Lässt sich nicht erneut einbinden? 
	wp_enqueue_style("jquery_custom", get_template_directory_uri() . "/_/js/jquery-1.11.3.min.js", false, "1.0", "all");
    wp_enqueue_style("font_awesome_admin", get_template_directory_uri() . "/css/font-awesome.css", false, "1.0", "all"); // CSS
    wp_enqueue_style("taxonomies_images", get_template_directory_uri() . "/library/admin/css/taxonomies-images.css", false, "1.0", "all");
	*/
}

wp_register_script( 'js', get_stylesheet_directory_uri() . '/js/js.js');
wp_enqueue_script( 'js' );