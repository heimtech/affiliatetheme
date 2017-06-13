<?php
add_action( "wp_enqueue_scripts", "theme_enqueue_styles" );



function theme_enqueue_styles() {
	wp_enqueue_style( "parent-style", get_template_directory_uri() . "/style.css" );
	wp_enqueue_style( "child-style", get_stylesheet_uri(), array( "parent-style" ) );

    wp_enqueue_script( 'theme_js', get_stylesheet_directory_uri() . '/js/js.js', array( 'jquery' ), '1.0', true );

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

    $response = '<div class="input-group-custom full-size"><select class="form-control-custom col12"><option value="select">Produktkategorien</option>';



    for($i = 0 ; $i < count($result); $i++) {

        $singleCategory = $result[$i];

        $response = $response . '<option value="'.$singleCategory-> slug.'">'.$singleCategory->name .'</option>';


    }




    $response = $response . '</select></div>';

    return $response;


}



function yourthemename_widgets_init() {

    register_sidebar( array(

        'name'          => __( 'Custom Widget Area Header', 'yourthemename' ),

        'id'            => 'sidebar-custom-header',

        'description'   => __( 'Custom widget area for the header of my theme', 'yourthemename' ),

        'before_widget' => '<div id="%1$s" class="widget %2$s">',

        'after_widget'  => '</div>',

        'before_title'  => '<h3 class="widget-title">',

        'after_title'   => '</h3>',

    ) );

}

add_action( 'widgets_init', 'yourthemename_widgets_init' );

add_shortcode('produkte_tiny', 'produkte_tiny_shortcode');



function produkte_tiny_shortcode($atts, $content = null)
{
    global $affiliseo_options, $device, $headline_title_global, $show_mini, $has_sidebar, $psUniqueId, $colClass, $colCount, $sameColCount;

    $psUniqueId = mt_rand();

    $a = shortcode_atts(array(
        "limit" => "1",
        "marken" => "",
        "typen" => "",
        "orderby" => "date",
        "order" => "ASC",
        "break_out" => "false",
        "ad" => "true",
        "ids" => "",
        "horizontal" => "false",
        "sidebar" => "false",
        "highscore" => "false",
        "columns" => 3,
        "slider" => "false",
        "headline_title" => "",
        "mini_view" => "false",
        "mini" => "true",
        "checklist" => "false",
        "custom_taxonomies" => "",
        "add_clearfix" => "true"
    ), $atts);

    $limit = $a['limit'];
    $marken = $a['marken'];
    $typen = $a['typen'];
    $orderby = $a['orderby'];
    $order = $a['order'];
    $break_out = $a['break_out'];
    $ad = $a['ad'];
    $ids = $a['ids'];
    $horizontal = $a['horizontal'];
    $sidebar = $a['sidebar'];
    $highscore = $a['highscore'];
    $slider = $a['slider'];
    $columns = $a['columns'];
    $headline_title = $a['headline_title'];
    $mini_view = $a['mini_view'];
    $mini = $a['mini'];
    $checklist = $a['checklist'];
    $customTaxonomies = explode(',', $a['custom_taxonomies']);

    if ($columns == 6 || $mini_view === 'true') {
        $cols = 6;
    } elseif ($columns == 4) {
        $cols = 4;
    } else {
        $cols = 3;
    }

    if (! isset($a['add_clearfix'])) {
        $a['add_clearfix'] = 'true';
    }

    $addClearfix = $a['add_clearfix'];

    $headline_title_global = $headline_title;

    if ($mini === "true") {
        $show_mini = "true";
    } else {
        $show_mini = "false";
    }

    if (! empty($ids)) {
        $ids = explode(",", $ids);
        $ids = array_map('trim', $ids);
    } else {
        $ids = '';
    }

    if (trim($limit) === '0') {
        $ps = get_posts(array(
            'post_type' => 'produkt',
            'post_status' => 'publish',
            'posts_per_page' => - 1
        ));
        $limit = 2 * count($ps);
    }

    $args = array(
        'post_type' => 'produkt',
        'orderby' => $orderby,
        'order' => $order,
        'posts_per_page' => $limit
    );
    if (empty($ids)) {

        echo ("ID was empty");

        $args['produkt_marken'] = $marken;
        $args['produkt_typen'] = $typen;

        $taxonomyArgs = array();
        if (is_array($customTaxonomies) && count($customTaxonomies) > 0) {
            foreach ($customTaxonomies as $customTaxonomy) {
                $customTaxonomyParts = explode('__', $customTaxonomy);
                if (isset($customTaxonomyParts[0]) && $customTaxonomyParts[0] != "" && isset($customTaxonomyParts[1]) && $customTaxonomyParts[1] != "") {

                    $taxonomyArgs[$customTaxonomyParts[0]][] = $customTaxonomyParts[1];
                }
            }
        }

        if (count($taxonomyArgs) > 0) {
            foreach ($taxonomyArgs as $taxonomyArgKey => $taxonomyArgvalue) {
                $args[$taxonomyArgKey] = implode(',', $taxonomyArgvalue);
            }
        }

        if ($orderby == 'sterne_bewertung') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'sterne_bewertung';
        } elseif (trim($orderby) === 'interne_bewertung') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'interne_bewertung';
        }
    } else {
        $args['post__in'] = $ids;
    }

    if (trim($orderby) === 'preis') {
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = 'preis';
    }

    if ($cols == 3) {
        $colClass = 'col-xs-6 col-md-6 col-lg-4';
        $colCount = 3;
    } elseif ($cols == 4) {
        $colClass = 'col-xs-6 col-md-4 col-lg-3';
        $colCount = 4;
    } elseif ($cols == 6) {
        $colClass = 'col-xs-6 col-md-3 col-lg-2';
        $colCount = 6;
    } else {
        $colClass = 'col-xs-6 col-md-6 col-lg-4';
        $colCount = 3;
    }

    $output = '';




        query_posts($args);
        global $wp_query;
        $length = $wp_query->post_count;
        if (have_posts()) {
            $i = 1;
            $sameColCount = 1;
            $j = 1;
            while (have_posts()) {
                the_post();
                ob_start();
                if ($i === 1) {
                    echo '<div class="row produkte">';
                }
                if ($sidebar == "true") {
                    get_template_part('loop', 'produkt-sidebar');
                    $output .= ob_get_clean();
                    break;
                } else {
                    if ($horizontal == "true") {
                        if (trim($headline_title) !== '') {
                            echo '<h4><span class="h4-product h4-product-tiny custom-headline">' . $headline_title . '</span></h4>';
                        }
                        get_template_part('loop', 'produkt-tiny');
                    } else {

                        if ($j > $colCount) {

                            $sameColCount ++;

                            $j = 1;
                        }
                        $j ++;

                        if (trim($headline_title) !== '') {
                            echo '<h4><span class="h4-product h4-product-tiny custom-headline">' . $headline_title . '</span></h4>';
                        }
                        get_template_part('loop', 'produkt-tiny');
                    }
                }

                $i ++;

                $output .= ob_get_clean();
            }

            $output = handle_ad($ad, $break_out, $device, $affiliseo_options, $output, false, $addClearfix);

            $output = $output . '</div>';
        }
        wp_reset_query();




    $output = removeEditorNewLines($output);

    return $output;
}



wp_register_script( 'js', get_stylesheet_directory_uri() . '/js/js.js');
wp_enqueue_script( 'js' );