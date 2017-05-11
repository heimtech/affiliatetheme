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


add_shortcode('list_producttype', 'list_producttypes');



function list_producttypes($atts, $content = null)
{



    global $wpdb;
    $query_product_categories = 'SELECT * FROM ' . $wpdb->prefix . 'terms WHERE ' . $wpdb->prefix . 'terms.term_id IN (SELECT term_id FROM ' . $wpdb->prefix . 'term_taxonomy WHERE taxonomy = "produkt_typen")';
    $result = $wpdb->get_results($query_product_categories);

    $response = '<select>';

    for($i = 0 ; count($result); $i++) {

        $singleCategory = $result[$i];

        $response = $response . '<option value="'.$singleCategory["slug"].'">'.$singleCategory.'</option>';


    }
    echo var_dump($result);


    $response = $response . '</select';
    return $response;
}



function yourthemename_widgets_init() {

    register_sidebar( array(

        'name'          => __( 'Custom Widget Area Header', 'yourthemename' ),

        'id'            => 'sidebar-custom-header',

        'description'   => __( 'Custom widget area for the header of my theme', 'yourthemename' ),

        'before_widget' => '<aside id="%1$s" class="widget %2$s">',

        'after_widget'  => '</aside>',

        'before_title'  => '<h3 class="widget-title">',

        'after_title'   => '</h3>',

    ) );

}

add_action( 'widgets_init', 'yourthemename_widgets_init' );


wp_register_script( 'js', get_stylesheet_directory_uri() . '/js/js.js');
wp_enqueue_script( 'js' );