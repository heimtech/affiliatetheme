<?php

global $affiliseo_options;

global $brand_singular;
$brand_singular = htmlentities($affiliseo_options['products_brand_singular']);
if (trim($brand_singular) === '') {
    $brand_singular = __('Brand','affiliatetheme');
}
global $brand_singular_slug;
$brand_singular_slug = generate_slug($brand_singular);

global $brand_plural;
$brand_plural = htmlentities($affiliseo_options['products_brand_plural']);
if (trim($brand_plural) === '') {
    $brand_plural = __('Brands','affiliatetheme');
}
global $brand_plural_slug;
$brand_plural_slug = generate_slug($brand_plural);

global $type_singular;
$type_singular = htmlentities($affiliseo_options['products_type_singular']);
if (trim($type_singular) === '') {
    $type_singular = __('Type','affiliatetheme');
}
global $type_singular_slug;
$type_singular_slug = generate_slug($type_singular);

global $type_plural;
$type_plural = htmlentities($affiliseo_options['products_type_plural']);
if (trim($type_plural) === '') {
    $type_plural = __('Types','affiliatetheme');
}
global $type_plural_slug;
$type_plural_slug = generate_slug($type_plural);

global $use_custom_permalinks;
$use_custom_permalinks = $affiliseo_options['use_custom_permalinks'];

function generate_slug($string) {
    $string_repl = trim(strtolower($string));
    $search = array("&auml;", "ä", "Ä", "&ouml;", "ö", "Ö", "&uuml;", "ü", "Ü", "&szlig;", "ß", "´", " ");
    $replace = array("ae", "ae", "ae", "oe", "oe", "oe", "ue", "ue", "ue", "ss", "ss", "", "_");
    return str_replace($search, $replace, $string_repl);
}

/*
 * In this File you can add/modify/delete Post-Types
 */

function wpa_show_permalinks($post_link, $id = 0) {
    $post = get_post($id);
    if (is_object($post) && $post->post_type == 'produkt') {
        $terms = wp_get_object_terms($post->ID, 'produkt_marken');
        if ($terms) {
            return str_replace('%produkt_marken%', $terms[0]->slug, $post_link);
        }
    }
    return $post_link;
}

add_filter('post_type_link', 'wpa_show_permalinks', 1, 2);

/* Post-Type: Produkte
 * Taxonomy(s): Marken, Typen
 */
add_action('init', 'produkt_register');

function produkt_register() {
    $labels = array(
        'name' => _x('Produkte', 'post type general name'),
        'singular_name' => _x('Produkt', 'post type singular name'),
        'add_new' => _x('Produkt erstellen', 'book'),
        'add_new_item' => __('Neues Produkt hinzuf&uuml;gen'),
        'edit_item' => __('Produkt editieren'),
        'new_item' => __('Neues Produkt'),
        'all_items' => __('Produkte'),
        'view_item' => __('Zeige Produkt'),
        'search_items' => __('Suche Produkt'),
        'not_found' => __('Keine Produkt gefunden'),
        'menu_name' => 'Produkte'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'hierarchical' => true,
        'menu_position' => null,
        'has_archive' => true,
        'supports' => array('comments', 'title', 'thumbnail', 'editor')
    );

    global $use_custom_permalinks;
    global $brand_singular_slug;
    if (trim($use_custom_permalinks) === '1') {
        $args['rewrite'] = array('slug' => $brand_singular_slug . '/%produkt_marken%');
    } else {
        $args['rewrite'] = array('slug' => '/produkt/%produkt_marken%');
    }

    add_filter('manage_edit-produkt_columns', 'produkt_edit_columns');

    function produkt_edit_columns($columns) {
        global $brand_singular;
        global $type_singular;
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'marke' => $brand_singular,
            'title' => 'Bezeichnung',
            'typ' => $type_singular,
            'preis' => __('Price','affiliatetheme'),
            'bewertung' => __('Review','affiliatetheme'),
            'interne_bewertung' => 'Interne Bewertung',
            'product_id' => 'ID'
        );

        return $columns;
    }

    add_action("manage_pages_custom_column", "produkt_custom_columns");

    function produkt_custom_columns($column) {
        $affiliseoOptions = getAffiliseoOptions();
        global $post;
        switch ($column) {
            case "marke":
                $marken = get_the_terms($post->ID, 'produkt_marken');
                if ($marken && !is_wp_error($marken)) {
                    foreach ($marken as $marke) {
                        echo $marke->name;
                    }
                }
                break;

            case "typ":
                $typen = get_the_terms($post->ID, 'produkt_typen');
                if ($typen && !is_wp_error($typen)) {
                    foreach ($typen as $typ) {
                        echo $typ->name;
                    }
                }
                break;

            case "preis":
                global $currency_string;
                global $pos_currency;
                $price = '';
                if (trim($pos_currency) === 'before') {
                    $price = $currency_string . ' ' . get_field('preis');
                } else {
                    $price = get_field('preis') . ' ' . $currency_string;
                }
                echo $price;
                break;

            case "bewertung":
                if( !isset($affiliseoOptions['hide_star_rating']) || $affiliseoOptions['hide_star_rating']!=1 ){
                    echo get_product_rating($post->ID, '', '');                    
                }
                
                break;
            case "interne_bewertung":
                echo get_intern_product_rating($post->ID);
                break;
            case "product_id":
                echo $post->ID;
                break;
        }
    }

    register_post_type('produkt', $args);

    add_action('init', 'add_taxonomy_objects_stadt');

    function add_taxonomy_objects_stadt() {
        register_taxonomy_for_object_type('post_tag', 'produkt_register');
    }

    /* Taxonomy: Marken */
    global $brand_singular;
    global $brand_plural;
    $labels = array(
        'name' => _x($brand_plural, 'post type general name'),
        'singular_name' => _x($brand_singular, 'post type singular name'),
        'add_new' => _x('Erstellen', 'book'),
        'add_new_item' => __('Neue/s/n ' . $brand_singular . ' hinzufügen'),
        'edit_item' => __($brand_singular . ' editieren'),
        'new_item' => __('Neue/s/r ' . $brand_singular),
        'all_items' => __($brand_plural),
        'view_item' => __('Zeige ' . $brand_singular),
        'search_items' => __('Suche ' . $brand_singular),
        'not_found' => __('Keine/n ' . $brand_singular . ' gefunden'),
        'menu_name' => $brand_plural
    );

    $args = array(
        'labels' => $labels,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'supports' => array('comments', 'title', 'editor', 'excerpt', 'thumbnail')
    );

    global $use_custom_permalinks;
    global $brand_singular_slug;
    if (trim($use_custom_permalinks) === '1') {
        $args['rewrite'] = array('slug' => $brand_singular_slug);
    } else {
        $args['rewrite'] = array('slug' => 'produkt');
    }

    register_taxonomy('produkt_marken', 'produkt', $args);

    /* Taxonomy: Typen */
    global $type_singular;
    global $type_plural;
    $labels = array(
        'name' => _x($type_plural, 'post type general name'),
        'singular_name' => _x($type_singular, 'post type singular name'),
        'add_new' => _x('Erstellen', 'book'),
        'add_new_item' => __('Neue/s/n ' . $type_singular . ' hinzufügen'),
        'edit_item' => __($type_singular . ' editieren'),
        'new_item' => __('Neue/s/r ' . $type_singular),
        'all_items' => __($type_plural),
        'view_item' => __('Zeige ' . $type_singular),
        'search_items' => __('Suche ' . $type_singular),
        'not_found' => __('Keine/n ' . $type_singular . ' gefunden'),
        'menu_name' => $type_plural
    );

    $args = array(
        'labels' => $labels,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'supports' => array('comments', 'title', 'editor', 'excerpt', 'thumbnail')
    );

    global $use_custom_permalinks;
    global $type_singular_slug;
    if (trim($use_custom_permalinks) === '1') {
        $args['rewrite'] = array('slug' => $type_singular_slug);
    } else {
        $args['rewrite'] = array('slug' => 'typen');
    }

    register_taxonomy('produkt_typen', 'produkt', $args);

    /* Taxonomy: Tags */
    $labels = array(
        'name' => _x('Tags', 'post type general name'),
        'singular_name' => _x('Tag', 'post type singular name'),
        'add_new' => _x('Erstellen', 'book'),
        'add_new_item' => __('Neuen Tag hinzufügen'),
        'edit_item' => __('Tag editieren'),
        'new_item' => __('Neuer Tag'),
        'all_items' => __('Tags'),
        'view_item' => __('Zeige Tag'),
        'search_items' => __('Suche Tag'),
        'not_found' => __('Keinen Tag gefunden'),
        'menu_name' => 'Tags'
    );

    $args = array(
        'labels' => $labels,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'supports' => array('comments', 'title', 'editor', 'excerpt', 'thumbnail')
    );

    $args['rewrite'] = array('slug' => 'tags');

    register_taxonomy('produkt_tags', 'produkt', $args);

    /* Taxonomy: Custom */
    global $wpdb;
    global $taxonomies_table;
    if ($wpdb->get_var('SHOW TABLES LIKE "' . $taxonomies_table . '"') == $taxonomies_table) {

        $res = $wpdb->get_results(
                'SELECT * FROM '
                . $taxonomies_table, OBJECT
        );

        if (count($res) > 0) {
            foreach ($res as $mytax) {
                #echo var_dump($mytax);
                $labels = array(
                    'name' => _x($mytax->taxonomy_plural, 'post type general name'),
                    'singular_name' => _x($mytax->taxonomy_singular, 'post type singular name'),
                    'add_new' => _x('Erstellen', 'book'),
                    'add_new_item' => __("Neuen $mytax->taxonomy_singular hinzufügen"),
                    'edit_item' => __("$mytax->taxonomy_singular editieren"),
                    'new_item' => __("Neuer $mytax->taxonomy_singular"),
                    'all_items' => __($mytax->taxonomy_plural),
                    'view_item' => __("Zeige $mytax->taxonomy_singular"),
                    'search_items' => __("Suche $mytax->taxonomy_singular"),
                    'not_found' => __("Keinen $mytax->taxonomy_singular gefunden"),
                    'menu_name' => $mytax->taxonomy_plural
                );

                $args = array(
                    'labels' => $labels,
                    'show_in_menu' => true,
                    'show_in_nav_menus' => true,
                    'hierarchical' => true,
                    'show_ui' => true,
                    'show_admin_column' => true,
                    'supports' => array('comments', 'title', 'editor', 'excerpt', 'thumbnail')
                );

                $args['rewrite'] = array('slug' => $mytax->taxonomy_slug);

                register_taxonomy("produkt_$mytax->taxonomy_slug", 'produkt', $args);
            }
        }
    }
}

add_post_type_support('produkt', array('comments'));

define('SECOND', 'licence');

/* Post-Type: Slideshow
 * Taxonomy(s): -
 */
add_action('init', 'slider_register');

function slider_register() {
    $labels = array(
        'name' => _x('Slideshow', 'post type general name'),
        'singular_name' => _x('Slider', 'post type singular name'),
        'add_new' => _x('Slider Erstellen', 'book'),
        'add_new_item' => __('Neuen Slider hinzuf&uuml;gen'),
        'edit_item' => __('Slider editieren'),
        'new_item' => __('Neuer Slider'),
        'all_items' => __('Slider'),
        'view_item' => __('Zeige Slider'),
        'search_items' => __('Suche Slider'),
        'not_found' => __('Kein Slider gefunden'),
        'menu_name' => 'Slideshow'
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'hierarchical' => true,
        'menu_position' => null,
        //'menu_icon' => get_bloginfo("template_url") .'/_/img/icons/video-16x16.png', 
        'supports' => array('title', 'thumbnail')
    );

    register_post_type('slideshow', $args);

    add_filter('manage_edit-slideshow_columns', 'slideshow_edit_columns');

    function slideshow_edit_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => 'Titel',
            'slideshow_thumbnail' => 'Vorschau',
        );

        return $columns;
    }

    add_action("manage_pages_custom_column", "slideshow_custom_columns");

    function slideshow_custom_columns($column) {
        global $post;
        
        switch ($column) {
            case "slideshow_thumbnail":
                the_custom_post_thumbnail($post, 'img_by_url_image_w400', null,array(400, 300));
                break;

            case "slideshow_description":
                the_excerpt();
                break;
        }
    }

    add_action('init', 'add_taxonomy_objects_slideshow');

    function add_taxonomy_objects_slideshow() {
        register_taxonomy_for_object_type('post_tag', 'slideshow_register');
    }

}

function show_taxonomies($postID, $use_custom_permalinks) {
    $marken = get_the_terms($postID, 'produkt_marken');
    $typen = get_the_terms($postID, 'produkt_typen');
    global $type_singular;
    global $type_singular_slug;
    global $brand_singular;
    global $brand_singular_slug;
    if (!empty($typen)) {
        ?>
        <tr>
            <td><?php echo $type_singular ?></td>
            <td>
                <?php
                $i = 0;
                $typeLinkList = array();
                foreach ($typen as $typ) {
                    if (trim($use_custom_permalinks) !== '1') {
                        $typeLinkList[] = '<a href="' . get_bloginfo('url') . '/typen/' . $typ->slug . '/"><span>' . $typ->name . '</span></a>';
                    } else {
                        $typeLinkList[] = '<a href="' . get_bloginfo('url') . '/' . $type_singular_slug . '/' . $typ->slug . '/"><span>' . $typ->name . '</span></a>';
                    }                    
                }
                if(count($typeLinkList) > 0){
                    echo implode(', ', $typeLinkList);
                }
                ?>
            </td>
        </tr>
        <?php
    }
    if (!empty($marken)) {
        ?>
        <tr>
            <td><?php echo $brand_singular; ?></td>
            <td>
                <?php
                $markeLinkList = array();
                $i = 0;
                foreach ($marken as $marke) {
                    if (trim($use_custom_permalinks) !== '1') {
                        $markeLinkList[] = '<a href="' . get_bloginfo('url') . '/produkt/' . $marke->slug . '/"><span itemprop="brand">' . $marke->name . '</span></a>';
                    } else {
                        $markeLinkList[] = '<a href="' . get_bloginfo('url') . '/' . $brand_singular_slug . '/' . $marke->slug . '/"><span itemprop="brand">' . $marke->name . '</span></a>';
                    }                    
                }
                if(count($markeLinkList) > 0){
                    echo implode(', ', $markeLinkList);
                }
                ?>
            </td>
        </tr>
        <?php
    }
    global $wpdb;
    global $taxonomies_table;
    $custom_taxs = array();
    $custom_taxs_objs = array();
    if ($wpdb->get_var('SHOW TABLES LIKE "' . $taxonomies_table . '"') == $taxonomies_table) {

        $res = $wpdb->get_results(
                'SELECT * FROM '
                . $taxonomies_table, OBJECT
        );

        $i = 0;
        foreach ($res as $custoum_tax) {
            if (get_the_terms($postID, "produkt_$custoum_tax->taxonomy_slug")) {
                $custom_taxs[] = get_the_terms($postID, "produkt_$custoum_tax->taxonomy_slug");
                $custom_taxs_objs[$i] = $custoum_tax;
                $i++;
            }
        }
    }
    if (!empty($custom_taxs)) {
        foreach ($custom_taxs as $key => $cus_tax) {
            ?>
            <tr>
                <td><?php echo $custom_taxs_objs[$key]->taxonomy_singular; ?></td>
                <td>
                    <?php
                    $i = 0;
                    foreach ($cus_tax as $my_tax) {
                        echo '<a href="' . get_bloginfo('url') . '/' . $custom_taxs_objs[$key]->taxonomy_slug . '/' . $my_tax->slug . '/"><span>' . $my_tax->name . '</span></a>';
                        if (++$i != count($custoum_tax)) {
                            echo ", ";
                        }
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
    }
}

