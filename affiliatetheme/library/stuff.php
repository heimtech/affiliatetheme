<?php
/*
 * Show Adminbar only for Admins
 * *********************************
 */
// add_filter('show_admin_bar', '__return_false');

/*
 * Add Thumbnail Support
 * **********************************
 */
add_theme_support('post-thumbnails');
add_image_size('product_small', 175, 175); // Thumbnails
add_image_size('product_highscore', 60, 60); // Thumbnails
add_image_size('slider_small', 50, 50); // Thumbnails
add_image_size('menu_small', 30, 30); // Thumbnails
add_image_size('slider_big', 620, 510); // Thumbnails
add_image_size('start_slider', 1010, 400); // Thumbnails
add_image_size('blog_thumbnail', 300, 150); // Thumbnails
add_image_size('thumbnail', 150, 150); // Thumbnails

add_image_size('full_size', "", "", false);

add_image_size('image_150_150', 150, 150);
add_image_size('image_300_300', 300, 300);
add_image_size('image_450_450', 450, 450);
add_image_size('image_600_600', 600, 600);
add_image_size('image_800_800', 800, 800);

add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');

// breadcrumb
function nav_breadcrumb()
{
    global $wp_query;
    global $affiliseo_options;
    
    $delimiter = '&raquo;';
    $frontpage_id = get_option('page_on_front');
    $frontpage = get_page($frontpage_id);
    $frontpage_title = $frontpage->post_title;
    $home = $affiliseo_options['text_home_link'];
    if (trim($frontpage_title) !== '' && trim($home) === '') {
        $home = $frontpage_title;
    }
    $homeLink = get_bloginfo('url');
    $before = '';
    $after = '';
    
    if (get_post_type() == 'produkt') {
        global $post;
        $use_custom_permalinks = $affiliseo_options['use_custom_permalinks'];
        global $type_singular;
        global $type_singular_slug;
        global $brand_singular;
        global $brand_singular_slug;
        ?>
<div id="breadcrumb" prefix="v: http://rdf.data-vocabulary.org/#">
	<span typeof="v:Breadcrumb"> <a href="<?php echo $homeLink; ?>"
		rel="v:url" property="v:title">
                    <?php echo $home; ?>
                </a>
	</span>
            <?php echo $delimiter; ?>
            <?php
        $tax = get_taxonomy(get_query_var('taxonomy'));
        $brands = get_the_terms($post->ID, 'produkt_marken');
        $term = $wp_query->queried_object;
        if (! empty($tax)) {
            // echo $tax->labels->singular_name . ': ';
            echo $before . $term->name . $after;
        } else {
            foreach ($brands as $brand) {
                if (trim($use_custom_permalinks) !== '1') {
                    echo '<span typeof="v:Breadcrumb"><a href="' . get_bloginfo('url') . '/produkt/' . $brand->slug . '/" rel="v:url" property="v:title">' . $brand->name . '</a></span> &raquo; ';
                } else {
                    echo '<span typeof="v:Breadcrumb"><a href="' . get_bloginfo('url') . '/' . $brand_singular_slug . '/' . $brand->slug . '/" rel="v:url" property="v:title">' . $brand->name . '</a></span> &raquo; ';
                }
            }
            echo $before . get_the_title() . $after;
        }
        
        if ($affiliseo_options['hide_product_feed'] !== '1') :
            ?>
                <a
		href="<?php bloginfo('rss2_url'); ?>?post_type=produkt"
		title="Produkt-Feed"><i class="fa fa-rss pull-right"></i></a>
                
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <?php
            endif;
        ?>
            <div class="clearfix"></div>
</div>
<?php
        return;
    }
    
    if (! is_home() && ! is_front_page() || is_paged()) :
        ?>
<div id="breadcrumb" prefix="v: http://rdf.data-vocabulary.org/#">
            <?php
        global $post;
        echo '<span typeof="v:Breadcrumb"><a href="' . $homeLink . '" rel="v:url" property="v:title">' . $home . '</a></span> ' . $delimiter . ' ';
        
        if (is_category()) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0)
                echo (get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
            echo $before . single_cat_title('', false) . $after;
        } elseif (is_day()) {
            echo get_the_time('Y') . ' ' . $delimiter . ' ';
            echo get_the_time('F') . ' ' . $delimiter . ' ';
            echo $before . get_the_time('d') . $after;
        } elseif (is_month()) {
            echo get_the_time('Y') . ' ' . $delimiter . ' ';
            echo $before . get_the_time('F') . $after;
        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;
        } elseif (is_single() && ! is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo $post_type->labels->singular_name . ' ' . $delimiter . ' ';
                echo $before . get_the_title() . $after;
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                echo $before . get_the_title() . $after;
            }
        } elseif (! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;
        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            
            echo is_wp_error($cat_parents = get_category_parents($cat, TRUE, '' . $delimiter . '')) ? '' : $cat_parents;
            
            echo $parent->post_title . ' ' . $delimiter . ' ';
            echo $before . get_the_title() . $after;
        } elseif (is_page() && ! $post->post_parent) {
            echo $before . get_the_title() . $after;
        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbLinks = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $parent_id = $page->post_parent;
                $breadcrumbLinks[] = array(
                    'page_title' => get_the_title($page->ID),
                    'page_url' => get_permalink($page->ID)
                );
            }
            $breadcrumbLinks = array_reverse($breadcrumbLinks);
            
            foreach ($breadcrumbLinks as $breadcrumbLink) {
                echo '<a href="' . $breadcrumbLink['page_url'] . '">' . $breadcrumbLink['page_title'] . '</a> ' . $delimiter . ' ';
            }
            
            echo $before . get_the_title() . $after;
        } elseif (is_search()) {
            echo $before . 'Ergebnisse für Ihre Suche nach "' . get_search_query() . '"' . $after;
        } elseif (is_tag()) {
            echo $before . 'Beiträge mit dem Tag "' . single_tag_title('', false) . '"' . $after;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . 'Beiträge veröffentlicht von ' . $userdata->display_name . $after;
        } elseif (is_404()) {
            echo $before . 'Fehler 404' . $after;
        }
        
        echo '</div>';
     else :
        if (! is_front_page()) :
            ?>
                <div id="breadcrumb"
		prefix="v: http://rdf.data-vocabulary.org/#">
		<span typeof="v:Breadcrumb"> <a href="<?php echo $homeLink; ?>"
			rel="v:url" property="v:title"><?php echo $home; ?></a>
		</span>
                    <?php echo $delimiter; ?>
                    <?php echo $before; ?>
                    <?php wp_title(''); ?>
                    <?php echo $after; ?>
                </div>
                
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <?php
            endif;
    endif;
}

function font_family_loader()
{
    $affiliseo_font_family_headlines = get_theme_mod('affiliseo_font_family_headlines', 'Open Sans');
    $affiliseo_font_family_text = get_theme_mod('affiliseo_font_family_text', 'Open Sans');
    echo output_font_family($affiliseo_font_family_text);
    if ($affiliseo_font_family_headlines !== $affiliseo_font_family_text) {
        echo output_font_family($affiliseo_font_family_headlines);
    }
}

function output_font_family($font_family)
{
    $output = '';
    switch ($font_family) {
        case 'Open Sans':
            $output = '<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700">';
            break;
        
        case 'Walter Turncoat':
            $output = '<link href="http://fonts.googleapis.com/css?family=Walter+Turncoat" rel="stylesheet" type="text/css">';
            break;
        
        case 'Rock Salt':
            $output = '<link href="http://fonts.googleapis.com/css?family=Rock+Salt" rel="stylesheet" type="text/css">';
            break;
        
        case 'Coda':
            $output = '<link href="http://fonts.googleapis.com/css?family=Coda" rel="stylesheet" type="text/css">';
            break;
        
        case 'Special Elite':
            $output = '<link href="http://fonts.googleapis.com/css?family=Special+Elite" rel="stylesheet" type="text/css">';
            break;
        
        case 'Oswald':
            $output = '<link href="http://fonts.googleapis.com/css?family=Oswald:400,700,300" rel="stylesheet" type="text/css">';
            break;
        
        case 'Lobster':
            $output = '<link href="http://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">';
            break;
        
        case 'Roboto':
            $output = '<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,600,700,800,300" rel="stylesheet" type="text/css">';
            break;
        
        case 'Lato':
            $output = '<link href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" rel="stylesheet" type="text/css">';
            break;
        
        case 'Vollkorn':
            $output = "<link href='http://fonts.googleapis.com/css?family=Vollkorn:400italic,700italic,400,700' rel='stylesheet' type='text/css'>";
            break;
        
        case 'Lora':
            $output = "<link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>";
            break;
        
        case 'Ubuntu':
            $output = "<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel='stylesheet' type='text/css'>";
            break;
        
        case 'Ubuntu Condensed':
            $output = "<link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>";
            break;
    }
    return $output;
}

function atom_search_where($where)
{
    global $wpdb;
    if (is_search())
        $where .= "OR (t.name LIKE '%" . get_search_query() . "%' AND {$wpdb->posts}.post_status = 'publish' AND {$wpdb->posts}.post_type = 'produkt')";
    return $where;
}

function sendamail()
{
    if (! defined('ARXW') || ARXW !== "BD9W") {
        $headers = 'From: affiliseo <info@affiliseo.de>' . "\r\n";
        wp_mail('info@affiliseo.de', 'Betrugsversuch!', 'Folgende Webseite hat den Lizenzierungsschutz entfernt: ' . home_url(), $headers);
    }
}

function atom_search_join($join)
{
    global $wpdb;
    if (is_search())
        $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
    return $join;
}

function atom_search_groupby($groupby)
{
    global $wpdb;
    
    // we need to group on post ID
    $groupby_id = "{$wpdb->posts}.ID";
    if (! is_search() || strpos($groupby, $groupby_id) !== false)
        return $groupby;
        
        // groupby was empty, use ours
    if (! strlen(trim($groupby)))
        return $groupby_id;
        
        // wasn't empty, append ours
    return $groupby . ", " . $groupby_id;
}

add_filter('posts_where', 'atom_search_where');
add_filter('posts_join', 'atom_search_join');
add_filter('posts_groupby', 'atom_search_groupby');

function get_licence_data()
{
    $location = home_url();
    $apikey = "";
    $options = getAffiliseoOptions();
    if (! empty($options['activate_apikey'])) {
        $apikey = "&apikey=" . trim($options['activate_apikey']);
    }
    $json_answer = wp_remote_get(APIURL . "/api.php?location=" . $location . $apikey);
    if (! is_wp_error($json_answer) && $json_answer['response']['code'] === 200) {
        return json_decode($json_answer['body'], true);
    }
    return NULL;
}

/*
 * Get Product Rating
 * *********************************************
 */
function get_product_rating($post_id, $enclosingTag, $cssClass)
{
    switch ($enclosingTag) {
        case 'div':
            $enclosingTagStart = '<div class="' . $cssClass . '" style="height:36px;">';
            $enclosingTagEnd = '</div>';
            break;
        case 'p':
            $enclosingTagStart = '<p class="' . $cssClass . '">';
            $enclosingTagEnd = '</p>';
            break;
        default:
            $enclosingTagStart = '';
            $enclosingTagEnd = '';
    }
    
    $out = '';
    $ratingContent = '';
    if (get_field('sterne_bewertung', $post_id) == "0.5") {
        $ratingContent = '<i class="fa fa-star-half-o stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i>';
    } else 
        if (get_field('sterne_bewertung', $post_id) == "1") {
            $ratingContent = '<i class="fa fa-star stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i>';
        } else 
            if (get_field('sterne_bewertung', $post_id) == "1.5") {
                $ratingContent = '<i class="fa fa-star stars"></i><i class="fa fa-star-half-o stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i>';
            } else 
                if (get_field('sterne_bewertung', $post_id) == "2") {
                    $ratingContent = '<i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i>';
                } else 
                    if (get_field('sterne_bewertung', $post_id) == "2.5") {
                        $ratingContent = '<i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star-half-o stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i>';
                    } else 
                        if (get_field('sterne_bewertung', $post_id) == "3") {
                            $ratingContent = '<i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i>';
                        } else 
                            if (get_field('sterne_bewertung', $post_id) == "3.5") {
                                $ratingContent = '<i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star-half-o stars"></i><i class="fa fa-star-o stars"></i>';
                            } else 
                                if (get_field('sterne_bewertung', $post_id) == "4") {
                                    $ratingContent = '<i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star-o stars"></i>';
                                } else 
                                    if (get_field('sterne_bewertung', $post_id) == "4.5") {
                                        $ratingContent = '<i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star-half-o stars"></i>';
                                    } else 
                                        if (get_field('sterne_bewertung', $post_id) == "5") {
                                            $ratingContent = '<i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star stars"></i><i class="fa fa-star stars"></i>';
                                        } else {
                                            // $ratingContent = '<i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i><i class="fa fa-star-o stars"></i>';
                                        }
    $out .= $enclosingTagStart;
    if ($ratingContent != "") {
        $out .= $ratingContent;
    }
    $out .= $enclosingTagEnd;
    
    return $out;
}

function get_intern_product_rating($post_id)
{
    return get_field('interne_bewertung', $post_id);
}

/*
 * Load Template Part into Var
 * ******************************************
 */
function load_template_part($template_name, $part_name = null)
{
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

/*
 * Load CDN jQuery
 * ********************************
 */
if (! is_admin()) {
    // wp_deregister_script( 'jquery' );
    // wp_register_script( 'jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ), false, '1.9.1' );
    // wp_enqueue_script( 'jquery' );
}

function get_gravatar_url($email, $size)
{
    $hash = md5(strtolower(trim($email)));
    return 'http://gravatar.com/avatar/' . $hash . '?s=' . $size . '';
}

/*
 * Get Theme Options (Admin Panel Settings)
 * ******************************************
 */
global $affiliseo_options;
$affiliseo_options = getAffiliseoOptions();

/*
 * Register the Navigation(s)
 * ****************************
 */
function register_my_menus()
{
    register_nav_menus(array(
        'nav_main' => __('Hauptnavigation'),
        'nav_top' => __('Navigation oben')
    ));
}

add_action('init', 'register_my_menus');

/*
 * Function to get Blog Categories
 * **********************************
 */
function user_the_categories()
{
    // get all categories for this post
    global $cats;
    $cats = get_the_category();
    $cat_link = get_category_link($cats[0]->cat_ID);
    // echo the first category
    ?><a href="<?php echo esc_url($cat_link); ?>"
		title="Kategorie &rsaquo; <?php echo $cats[0]->cat_name; ?>"><?php echo $cats[0]->cat_name; ?></a><?php
    // echo the remaining categories, appending separator
    for ($i = 1; $i < count($cats); $i ++) {
        $cat_link_i = get_category_link($cats[$i]->cat_ID);
        ?>
            , <a href="<?php echo esc_url($cat_link_i); ?>"
		title="Kategorie &rsaquo; <?php echo $cats[$i]->cat_name; ?>"><?php echo $cats[$i]->cat_name; ?></a><?php
    }
}

/*
 * Function to get Blog Categories
 * **********************************
 */
function list_the_categories()
{
    // get all categories for this post
    $cats = get_categories(array(
        'number' => '',
        'hierarchical' => 0,
        'hide_empty' => 1
    ));
    
    for ($i = 0; $i < count($cats); $i ++) {
        $cat_link = get_category_link($cats[$i]->cat_ID);
        ?><li><a href="<?php echo esc_url($cat_link); ?>"><?php echo $cats[$i]->cat_name; ?></a></li><?php
    }
}

/*
 * Function to get Taxonomy
 * **********************************
 */
function list_terms($tax)
{
    $term_list = get_terms($tax);
    if ($term_list) {
        foreach ($term_list as $term) {
            $term_link = get_term_link($term, $tax);
            echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
        }
    }
}

/*
 * Count Comments
 * ************************
 */
add_filter('get_comments_number', 'comment_count', 0);

function comment_count($count)
{
    if (! is_admin()) {
        global $id;
        $comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}

/*
 * Excerpt Function with variable Length
 * ****************************************
 */
function excerpt($limit)
{
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt) . '...';
    } else {
        $excerpt = implode(" ", $excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
    return $excerpt;
}

/*
 * Add a Twitter Bootstrap-friendly class to the "Contact Form 7" form
 * ************************************************************************
 */
add_filter('wpcf7_form_class_attr', 'wildli_custom_form_class_attr');

function wildli_custom_form_class_attr($class)
{
    global $post;
    if ($post->ID != "2481") {
        $class .= ' form-horizontal';
    } else {
        $class .= ' well';
    }
    return $class;
}

add_filter("wpcf7_mail_tag_replaced", "suppress_wpcf7_filter");

function suppress_wpcf7_filter($value, $sub = "")
{
    $out = ! empty($sub) ? $sub : $value;
    $out = strip_tags($out);
    $out = wptexturize($out);
    return $out;
}

/*
 * Remove URL Field in Comments
 * *********************************************************
 */
add_filter('comment_form_default_fields', 'url_filtered');

function url_filtered($fields)
{
    if (isset($fields['url']))
        unset($fields['url']);
    return $fields;
}

/*
 * Modify Post Mime Types - Add PDF Filter
 * *********************************************************
 */
function modify_post_mime_types($post_mime_types)
{
    $post_mime_types['application/pdf'] = array(
        __('PDFs'),
        __('PDFs Verwalten'),
        _n_noop('PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>')
    );
    return $post_mime_types;
}

add_filter('post_mime_types', 'modify_post_mime_types');

/*
 * Wrap Category Count into span
 * ***************************
 */
add_filter('wp_list_categories', 'cat_count_span');

function cat_count_span($links)
{
    $links = str_replace('</a> (', '</a> <span>(', $links);
    $links = str_replace(')', ')</span>', $links);
    return $links;
}

function reset_permalinks()
{
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules();
}

add_action('init', 'reset_permalinks');

function sortable_columns()
{
    return array(
        'typ' => 'typ',
        'marke' => 'marke',
        'title' => 'title',
        'preis' => 'preis',
        'product_id' => 'product_id'
    );
}

add_filter("manage_edit-produkt_sortable_columns", "sortable_columns");

add_theme_support('automatic-feed-links');

// Custom Post Type
/* inject cpt archives meta box */
add_action('admin_head-nav-menus.php', 'inject_cpt_archives_menu_meta_box_brands');

function inject_cpt_archives_menu_meta_box_brands()
{
    global $brand_plural;
    add_meta_box('add-cpt-brands', __($brand_plural, 'default'), 'wp_nav_menu_cpt_archives_meta_box_brands', 'nav-menus', 'side', 'default');
}

// add_action( 'admin_head-nav-menus.php', 'inject_cpt_archives_menu_meta_box_types' );

/* render custom post type archives meta box */
function wp_nav_menu_cpt_archives_meta_box_brands()
{
    $walker = new Walker_Nav_Menu_Checklist(array());
    
    $taxonomies = get_terms('produkt_marken');
    ?>
        <div id="cpt-archive" class="posttypediv">
		<div id="tabs-panel-cpt-archive" class="tabs-panel tabs-panel-active">
			<ul id="ctp-archive-checklist"
				class="categorychecklist form-no-clear">
                    <?php
    echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $taxonomies), 0, (object) array(
        'walker' => $walker
    ));
    ?>
                </ul>
		</div>
		<!-- /.tabs-panel -->
	</div>
	<p class="button-controls">
		<span class="add-to-menu"> <input type="submit"
			<?php disabled($nav_menu_selected_id, 0); ?>
			class="button-secondary submit-add-to-menu"
			value="<?php esc_attr_e('Add to Menu'); ?>"
			name="add-ctp-archive-menu-item" id="submit-cpt-archive" />
		</span>
	</p>
        <?php
}

/* take care of the urls */
add_filter('wp_get_nav_menu_items', 'cpt_archive_menu_filter', 10, 3);

function cpt_archive_menu_filter($items, $menu, $args)
{
    /* alter the URL for cpt-archive objects */
    foreach ($items as &$item) {
        if ($item->object != 'cpt-archive')
            continue;
        $item->url = get_post_type_archive_link($item->type);
        
        /* set current */
        if (get_query_var('post_type') == $item->type) {
            $item->classes[] = 'current-menu-item';
            $item->current = true;
        }
    }
    
    return $items;
}

if (! session_id())
    session_start();

function completion_validator($pid, $post)
{
    // don't do on autosave or when new posts are first created
    if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || $post->post_status == 'auto-draft')
        return $pid;
        // abort if not my custom type
    if ($post->post_type != 'produkt')
        return $pid;
        
        // init completion marker (add more as needed)
    $meta_missing = false;
    
    // retrieve meta to be validated
    $mymeta = get_the_terms($pid, 'produkt_marken');
    // just checking it's not empty - you could do other tests...
    if (empty($mymeta)) {
        $meta_missing = true;
    }
    
    // on attempting to publish - check for completion and intervene if necessary
    if ((isset($_POST['publish']) || isset($_POST['save'])) && $_POST['post_status'] == 'publish') {
        // don't allow publishing while any of these are incomplete
        if ($meta_missing) {
            global $wpdb;
            $wpdb->update($wpdb->posts, array(
                'post_status' => 'draft'
            ), array(
                'ID' => $pid
            ));
            // filter the query URL to change the published message
            add_filter('redirect_post_location', create_function('$location', 'return add_query_arg("message", "99", $location);'));
        }
    }
}

add_action('save_post', 'completion_validator', 20, 2);

function product_saved_messages_filter($messages)
{
    $messages['post'][99] = 'Ihr Produkt wurde gespeichert, konnte aber nicht veröffentlicht werden. Zum Veröffentlichen muss <strong style="color:red;">mindestens eine Marke</strong> angegeben werden.';
    return $messages;
}

add_filter('post_updated_messages', 'product_saved_messages_filter');

function default_comments_on($data)
{
    if ($data['post_type'] == 'produkt') {
        $data['comment_status'] = 1;
    }
    
    return $data;
}

add_filter('wp_insert_post_data', 'default_comments_on');

/*
 * Pagination
 * ***************************
 */
function affiliseo_pagination($post_type = 'post', $pages = '', $range = 2)
{
    $showitems = ($range * 2) + 1;
    
    global $paged;
    if (empty($paged)) {
        $paged = 1;
    }
    
    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (! $pages) {
            $pages = 1;
        }
    }
    
    if (1 != $pages) {
        echo "<div class='affiliseo-pagination'>";
        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
            echo "<a class='inactive' href='" . get_pagenum_link(1) . "'><i class='fa fa-angle-double-left'></i></a>";
        if ($paged > 1 && $showitems < $pages)
            echo "<a class='inactive' href='" . get_pagenum_link($paged - 1) . "'><i class='fa fa-angle-left'></i></a>";
        
        for ($i = 1; $i <= $pages; $i ++) {
            if (1 != $pages && (! ($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                echo ($paged == $i) ? "<span class='current'>" . $i . "</span>" : "<a href='" . get_pagenum_link($i) . "' class='inactive' >" . $i . "</a>";
            }
        }
        
        if ($paged < $pages && $showitems < $pages)
            echo "<a class='inactive' href='" . get_pagenum_link($paged + 1) . "'><i class='fa fa-angle-right'></i></a>";
        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
            echo "<a class='inactive' href='" . get_pagenum_link($pages) . "'><i class='fa fa-angle-double-right'></i></a>";
        echo "</div>\n";
    }
}

/*
 * Pagination Products
 * ***************************
 */
function affiliseo_product_pagination($paged, $is_brand, $custom_tax = '')
{
    $range = 2;
    $showitems = ($range * 2) + 1;
    global $wp_query;
    $pages = $wp_query->max_num_pages;
    global $query_string;
    $url = '';
    if ($custom_tax === '') {
        global $affiliseo_options;
        $use_custom_permalinks = $affiliseo_options['use_custom_permalinks'];
        global $type_singular;
        global $type_singular_slug;
        global $brand_singular;
        global $brand_singular_slug;
        global $post;
        if ($is_brand === 'true') {
            $brands = get_the_terms($post->ID, 'produkt_marken');
            if (trim($use_custom_permalinks) === '1') {
                $url = $brand_singular_slug . '/';
            } else {
                $url = 'produkt/';
            }
        } else {
            $brands = get_the_terms($post->ID, 'produkt_typen');
            if (trim($use_custom_permalinks) === '1') {
                $url = $type_singular_slug . '/';
            } else {
                $url = 'typen/';
            }
        }
        /**
         * $i = 0;
         * foreach ($brands as $brand) {
         * if ($i === 0) {
         * $url .= $brand->slug;
         * }
         * $i++;
         * }
         */
        $url .= get_queried_object()->slug;
    } else {
        global $post;
        $taxes = get_the_terms($post->ID, $custom_tax->query_var);
        $url = $custom_tax->rewrite['slug'] . '/';
        
        $i = 0;
        foreach ($taxes as $tax) {
            if ($i === 0) {
                $url .= $tax->slug;
            }
            $i ++;
        }
    }
    
    if (1 != $pages) {
        echo "<div class='affiliseo-pagination'>";
        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
            echo "<a class='inactive' href='" . get_bloginfo('url') . '/' . $url . '/?page=1' . "'><i class='fa fa-angle-double-left'></i></a>";
        if ($paged > 1 && $showitems < $pages)
            echo "<a class='inactive' href='" . get_bloginfo('url') . '/' . $url . '/?page=' . ($paged - 1) . "'><i class='fa fa-angle-left'></i></a>";
        
        for ($i = 1; $i <= $pages; $i ++) {
            if (1 != $pages && (! ($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                echo ($paged == $i) ? "<span class='current'>" . $i . "</span>" : "<a href='" . get_bloginfo('url') . '/' . $url . '/?page=' . ($i) . "' class='inactive' >" . $i . "</a>";
            }
        }
        
        if ($paged < $pages && $showitems < $pages)
            echo "<a class='inactive' href='" . get_bloginfo('url') . '/' . $url . '/?page=' . ($paged + 1) . "'><i class='fa fa-angle-right'></i></a>";
        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
            echo "<a class='inactive' href='" . get_bloginfo('url') . '/' . $url . '/?page=' . $pages . "'><i class='fa fa-angle-double-right'></i></a>";
        echo "</div>\n";
    }
}

/*
 * Pagination Filter
 * ***************************
 */
function affiliseo_filter_pagination($paged, $min_price, $max_price, $brand, $type, $tag, $stars, $dynamicParams)
{
    $range = 2;
    $showitems = ($range * 2) + 1;
    global $wp_query;
    $pages = $wp_query->max_num_pages;
    if (! $pages) {
        $pages = 1;
    }
    
    $urlDynamicParams = '';
    if (is_array($dynamicParams) && count($dynamicParams) > 0) {
        foreach ($dynamicParams as $key => $value) {
            $elemKey = array_keys($value);
            $elemValue = array_values($value);
            $urlDynamicParams .= '&' . $elemKey[0] . '=' . $elemValue[0];
        }
    }
    
    $url = 'produktfilter';
    
    if (1 != $pages) {
        echo "<div class='affiliseo-pagination'>";
        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
            echo "<a class='inactive' href='" . get_bloginfo('url') . '/' . $url . '/page/1/?min_price=' . $min_price . '&max_price=' . $max_price . '&brand=' . $brand . '&type=' . $type . '&tag=' . $tag . '&stars=' . $stars . $urlDynamicParams . "'><i class='fa fa-angle-double-left'></i></a>";
        if ($paged > 1 && $showitems < $pages)
            echo "<a class='inactive' href='" . get_bloginfo('url') . '/' . $url . '/page/' . ($paged - 1) . '/?min_price=' . $min_price . '&max_price=' . $max_price . '&brand=' . $brand . '&type=' . $type . '&tag=' . $tag . '&stars=' . $stars . $urlDynamicParams . "'><i class='fa fa-angle-left'></i></a>";
        
        for ($i = 1; $i <= $pages; $i ++) {
            if (1 != $pages && (! ($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                echo ($paged == $i) ? "<span class='current'>" . $i . "</span>" : "<a href='" . get_bloginfo('url') . '/' . $url . '/page/' . ($i) . '/?min_price=' . $min_price . '&max_price=' . $max_price . '&brand=' . $brand . '&type=' . $type . '&tag=' . $tag . '&stars=' . $stars . $urlDynamicParams . "' class='inactive' >" . $i . "</a>";
            }
        }
        
        if ($paged < $pages && $showitems < $pages)
            echo "<a class='inactive' href='" . get_bloginfo('url') . '/' . $url . '/page/' . ($paged + 1) . '/?min_price=' . $min_price . '&max_price=' . $max_price . '&brand=' . $brand . '&type=' . $type . '&tag=' . $tag . '&stars=' . $stars . $urlDynamicParams . "'><i class='fa fa-angle-right'></i></a>";
        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
            echo "<a class='inactive' href='" . get_bloginfo('url') . '/' . $url . '/page/' . $pages . '/?min_price=' . $min_price . '&max_price=' . $max_price . '&brand=' . $brand . '&type=' . $type . '&tag=' . $tag . '&stars=' . $stars . $urlDynamicParams . "'><i class='fa fa-angle-double-right'></i></a>";
        echo "</div>\n";
    }
}

/*
 * Related Posts Excerpt
 * ***************************
 */
function get_the_related_posts_excerpt($length = 80)
{
    $excerpt = get_the_content();
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $the_str = substr($excerpt, 0, $length);
    return $the_str;
}

function my_acf_format_value_for_api($value, $post_id, $field)
{
    return str_replace(']]>', ']]>', apply_filters('the_content', $value));
}

function my_on_init()
{
    if (! is_admin()) {
        add_filter('acf/format_value_for_api/type=wysiwyg', 'my_acf_format_value_for_api', 10, 3);
    }
}

add_action('init', 'my_on_init');

/*
 * Asynchronous cronjob
 * ***************************
 */

if ($affiliseo_options['allg_preise_ausblenden'] != 1 && trim($affiliseo_options['deactivate_cronjobfake']) !== '1') {
    add_action('wp_enqueue_scripts', 'add_cronjob_ajax_javascript_file');
}

function add_cronjob_ajax_javascript_file()
{
    wp_localize_script('cronjob-ajax', 'cronjobajax', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
    wp_enqueue_script('ajax_custom_script', get_template_directory_uri() . '/_/js/cronjob-javascript.min.js', array(
        'jquery'
    ));
}

add_action('wp_ajax_get_cronjob_information', 'get_cronjob_information');
add_action('wp_ajax_nopriv_get_cronjob_information', 'get_cronjob_information');

function get_cronjob_information()
{
    execute_price_request();
    
    die();
}

add_action('wp_head', 'add_ajax_library');

function add_ajax_library()
{
    $html = '<script type="text/javascript">';
    $html .= 'var ajaxurl = "' . admin_url('admin-ajax.php') . '"';
    $html .= '</script>';
    
    echo $html;
}

function execute_price_request()
{
    $public_key = get_option('amazon_public_key');
    $private_key = get_option('amazon_secret_key');
    $associate_tag = get_option('amazon_partner_id');
    
    $customfield_pid = 'amazon_produkt_id';
    $customfield_preis = 'preis';
    $no_price_type = get_option('ap_no_price');
    
    $args = array(
        'post_type' => 'produkt',
        'post_status' => 'publish',
        'posts_per_page' => - 1
    );
    
    $produkte = get_posts($args);
    $i = 0;
    if ($produkte) :
        foreach ($produkte as $produkt) :
            $timestamp = strtotime($produkt->post_modified);
            $current = time();
            $diff = $current - $timestamp;
            if ($diff > 3600) {
                $produkt_id = get_post_meta($produkt->ID, 'amazon_produkt_id', true);
                if ($produkt_id) {
                    do_request($produkt, $customfield_pid, $customfield_preis, $public_key, $private_key, $associate_tag, $no_price_type);
                    return;
                }
            }
            $i ++;
        endforeach
        ;
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        endif;
}

function do_request($produkt, $customfield_pid, $customfield_preis, $public_key, $private_key, $associate_tag, $no_price_type)
{
    $produkt_id = get_post_meta($produkt->ID, $customfield_pid, true);
    $preis_alt = get_post_meta($produkt->ID, $customfield_preis, true);
    $price_type = get_post_meta($produkt->ID, 'price_type');
    
    if ($produkt_id) {
        // start request
        
        include (TEMPLATEPATH . '/library/affiliatePartners/amazon/Amazon.php');
        $amazonApi = new Amazon($public_key, $associate_tag, $private_key);
        
        $request = $amazonApi->getProductById('de', array(
            'Operation' => 'ItemLookup',
            'ItemId' => $produkt_id,
            'ResponseGroup' => 'Large'
        ));
        
        $response = @file_get_contents($request);
        if ($response === FALSE) {} else {
            // parse XML
            $amazonProductsXml = simplexml_load_string($response);
            if ($amazonProductsXml === FALSE) {} else {
                if (! isset($price_type[0]) || $price_type[0] === '') {
                    $price_type[0] = 'lowest_new';
                }
                $preis_neu = handlePriceType_cron($price_type[0], $amazonProductsXml);
                update_post_meta($produkt->ID, 'price_type', $price_type[0]);
                handleOutput_cron($preis_alt, $preis_neu, $produkt->ID, $produkt_id, $no_price_type);
                update_product_modified_cron($produkt->ID);
            }
        }
    } else {}
}

function handlePriceType_cron($pricetype, $amazonProductsXml)
{
    switch ($pricetype) {
        case 'lowest_used':
            $price = number_format($amazonProductsXml->Items->Item->OfferSummary->LowestUsedPrice->Amount / 100, 2, ',', '');
            break;
        case 'list':
            $price = number_format($amazonProductsXml->Items->Item->ItemAttributes->ListPrice->Amount / 100, 2, ',', '');
            break;
        case 'price':
            $price = number_format($amazonProductsXml->Items->Item->Offers->Offer->OfferListing->Price->Amount / 100, 2, ',', '');
            break;
        default:
            $price = number_format($amazonProductsXml->Items->Item->OfferSummary->LowestNewPrice->Amount / 100, 2, ',', '');
    }
    return $price;
}

function handleOutput_cron($preis_alt, $preis_neu, $id, $produkt_id, $no_price_type)
{
    if ($preis_alt != $preis_neu) {
        update_post_meta($id, 'preis', $preis_neu);
    } else {
        update_post_meta($id, 'preis', $preis_neu);
    }
    if ($preis_neu === '0,00') {
        $preis_neu = 'Es ist kein Preis verfügbar.';
        $to = get_bloginfo('admin_email');
        $subject = get_bloginfo('name') . ' Warnung: Kein Preis verfügbar.';
        $link = wp_admin() . '/post.php?post=' . $id . '&action=edit';
        $message = 'Für das Produkt ' . get_the_title($id) . ' ist kein Preis verfügbar. Um dieses Problem zu lösen, können Sie im <a href="' . $link . '">Produkt</a> den Preistyp ändern, das Produkt erneut veröffentlichen und den Preis manuell aktualisieren. Wenn trotz dieser Maßnahmen das Problem weiterhin besteht, wenden Sie sich bitte an den Support von Amazon.';
        $headers = 'From: affiliseo <' . get_bloginfo('admin_email') . '>' . "\r\n";
        $link_backend = ' <a href="' . wp_admin() . '/post.php?post=' . $id . '&action=edit">' . __('Product', 'affiliatetheme') . '</a> ';
        global $no_price_string;
        switch ($no_price_type) {
            case 'send_mail':
                wp_mail($to, $subject, $message, $headers);
                $preis_neu .= ' Eine E-Mail wurde an Sie versendet!';
                break;
            case 'deactivate':
                $newpostdata['post_status'] = '';
                $newpostdata['ID'] = $id;
                wp_update_post($newpostdata);
                $preis_neu .= ' Das' . $link_backend . 'wurde deaktiviert!';
                break;
            case 'send_mail_and_change':
                wp_mail($to, $subject, $message, $headers);
                $preis_neu = $no_price_string;
                update_post_meta($id, 'preis', $preis_neu);
                break;
            case 'change':
                $preis_neu = $no_price_string;
                update_post_meta($id, 'preis', $preis_neu);
                break;
            default:
                wp_mail($to, $subject, $message, $headers);
                $newpostdata['post_status'] = '';
                $newpostdata['ID'] = $id;
                wp_update_post($newpostdata);
                $preis_neu .= ' Das' . $link_backend . 'wurde deaktiviert und eine E-Mail an Sie versendet!';
        }
    }
}

function update_product_modified_cron($id)
{
    global $wpdb;
    $wpdb->query($wpdb->prepare("
									UPDATE $wpdb->posts
									SET post_modified = %s,
									post_modified_gmt = %s
									WHERE ID = %s
								", current_time('mysql'), current_time('mysql', 1), (int) $id));
}

if ($affiliseo_options['filter_cloaking_page'] !== '1') {

    function initPages($page_slug, $page_title, $page_content, $page_template)
    {
        global $user_ID;
        
        if (get_page_by_path($page_slug, 'OBJECT', 'page') == NULL) {
            $new_post = array(
                'post_title' => $page_title,
                'post_content' => $page_content,
                'post_name' => $page_slug,
                'post_status' => 'publish',
                'post_author' => $user_ID,
                'post_type' => 'page',
                'page_template ' => $page_template
            );
            $post_id = wp_insert_post($new_post, true);
            update_post_meta($post_id, '_wp_page_template', $page_template);
        } else {
            $filter_post = get_page_by_path($page_slug, 'OBJECT', 'page');
            $filter_post_array = array();
            $filter_post_array['ID'] = $filter_post->ID;
            $filter_post_array['post_status'] = 'publish';
            wp_update_post($filter_post_array);
        }
    }
    
    initPages('produktfilter', 'Produktfilter - Ergebnisse', 'Sehen Sie hier Ihre Suchergebnisse.', 'page-product-filter.php');
    initPages('go', 'Sie verlassen ' . get_bloginfo('name'), 'Wenn Sie nicht automatisch weitergeleitet werden, klicken Sie ', 'page-outgoing.php');
    initPages('comparison-selection', 'Vergleich - Auswahl', '', 'page-comparison-selection.php');
}

if (! is_admin()) {
    /**
     * auskommentiert, da jquery im head-bereich eingebungen werden muss,
     * damit es für die von jquery abhaengigen externen plugins auch funktionieren
     */
    /**
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9, 0);
    remove_action('wp_head', 'wp_enqueue_scripts', 1, 0);
    add_action('wp_footer', 'wp_print_scripts');
    add_action('wp_footer', 'wp_print_head_scripts', 9, 0);
    add_action('wp_footer', 'wp_enqueue_scripts', 1, 0);
    */
} else {
    $activate_pagespeed = $affiliseo_options['activate_pagespeed'];
    require_once (ABSPATH . 'wp-admin/includes/file.php');
    require_once (ABSPATH . 'wp-admin/includes/misc.php');
    $home_path = get_home_path();
    $htaccess_file = $home_path . '.htaccess';
    if (trim($activate_pagespeed) === '1') {
        $lines = array(
            '<IfModule mod_deflate.c>',
            'AddOutputFilterByType DEFLATE text/plain',
            'AddOutputFilterByType DEFLATE text/html',
            'AddOutputFilterByType DEFLATE text/xml',
            'AddOutputFilterByType DEFLATE text/css',
            'AddOutputFilterByType DEFLATE text/javascript',
            'AddOutputFilterByType DEFLATE application/xml',
            'AddOutputFilterByType DEFLATE application/xhtml+xml',
            'AddOutputFilterByType DEFLATE application/rss+xml',
            'AddOutputFilterByType DEFLATE application/atom_xml',
            'AddOutputFilterByType DEFLATE application/javascript',
            'AddOutputFilterByType DEFLATE application/x-javascript',
            'AddOutputFilterByType DEFLATE application/x-shockwave-flash',
            '</IfModule>',
            '<IfModule mod_expires.c>',
            'ExpiresActive On',
            'ExpiresByType text/css "access plus 1 month"',
            'ExpiresByType text/javascript "access plus 1 month"',
            'ExpiresByType text/html "access plus 1 month"',
            'ExpiresByType application/javascript "access plus 1 month"',
            'ExpiresByType image/gif "access plus 1 month"',
            'ExpiresByType image/jpeg "access plus 1 month"',
            'ExpiresByType image/png "access plus 1 month"',
            'ExpiresByType image/x-icon "access plus 1 month"',
            '</IfModule>',
            '<IfModule mod_headers.c>',
            '<filesmatch "\\.(ico|jpeg|png|gif|swf|js)$">',
            'Header set Cache-Control "max-age=2592000, public"',
            '</filesmatch>',
            '<filesmatch "\\.(css)$">',
            'Header set Cache-Control "max-age=604800, public"',
            '</filesmatch>',
            '<filesmatch "\\.(js)$">',
            'Header set Cache-Control "max-age=216000, private"',
            '</filesmatch>',
            '</IfModule>'
        );
        
        insert_with_markers($htaccess_file, "AffiliateTheme PageSpeed", $lines);
        
        /**
         * jezt nachdem die htaccess geschrieben ist wieder
         * activate_pagespeed deaktivieren, damit sie nicht immer wieder
         * neu geschireben wird
         */
        global $wpdb;
        $renameOptionElements = array(
            's:18:\"activate_pagespeed\";s:1:\"1\"' => 's:18:\"activate_pagespeed\";s:1:\"0\"'
        );
        foreach ($renameOptionElements as $key => $value) {
            $query = ' UPDATE ' . $wpdb->prefix . 'options SET option_value = REPLACE(option_value, "' . $key . '", "' . $value . '")
                WHERE option_value LIKE "%' . $key . '%" ';
            $wpdb->query($query);
        }
    }
}

function strToFloat($str)
{
    setlocale(LC_NUMERIC, 'en_US');
    
    if (preg_match("/([0-9\.,-]+)/", $str, $match)) {
        $value = $match[0];
        if (preg_match("/(\.\d{1,2})$/", $value, $dot_delim)) {
            $value = (float) str_replace(',', '', $value);
        } else 
            if (preg_match("/(,\d{1,2})$/", $value, $comma_delim)) {
                $value = str_replace('.', '', $value);
                $value = (float) str_replace(',', '.', $value);
            } else {
                $value = (int) $value;
            }
    } else {
        $value = 0;
    }
    return $value;
}

function setSelect($val, $ref_val)
{
    if ("$val" == "$ref_val")
        return " selected='selected' ";
    else
        return "";
}

function getApButtonLabel($post)
{
    global $affiliseo_options;
    
    $apPdpButton = get_field('ap_pdp_button', $post->ID);
    
    if ($apPdpButton != "") {
        return $apPdpButton;
    } else {
        return $affiliseo_options['ap_button_label'];
    }
}

function findAffiliateParnerByPostId($postId)
{
    $affilatePartners = array(
        'affilinet_product_id' => 'affilinet',
        'amazon_produkt_id' => 'amazon',
        'belboon_product_id' => 'belboon',
        'eBay_product_id' => 'eBay',
        'tradedoubler_product_id' => 'tradedoubler',
        'zanox_product_id' => 'zanox'
    );
    
    $affilatePartnerKeys = array_keys($affilatePartners);
    
    $postMetaEntries = get_post_meta($postId);
    
    foreach ($postMetaEntries as $key => $val) {
        if (in_array($key, $affilatePartnerKeys)) {
            return $affilatePartners[$key];
        }
    }
}

function buildPdpButtonLabel($shopName, $affiliatePartner)
{
    $affiliatePartnerSettingName = $affiliatePartner . '_pdp_button';
    $affiliatePartnerSettingValue = get_option($affiliatePartnerSettingName);
    
    $apPdpButtonShopName = $affiliatePartnerSettingValue;
    
    if (isset($shopName) && $shopName != "") {
        
        if (strlen($affiliatePartnerSettingValue) > 12 && preg_match("/{shop_name}/", $affiliatePartnerSettingValue)) {
            $apPdpButtonShopName = str_replace('{shop_name}', $shopName, $affiliatePartnerSettingValue);
        }
    }
    
    return $apPdpButtonShopName;
}

function disable_srcset($sources)
{
    return false;
}
add_filter('wp_calculate_image_srcset', 'disable_srcset');

function writeAddToBasketButton($affileseoOptions = array(), $apCartLink, $apButtonLabel, $formClass, $buttonClass)
{
    $out_ = '<form action="' . get_bloginfo('url') . '/go/" method="post" target="_blank" class="' . $formClass . '">';
    $out_ .= '<input type="hidden" value="' . $apCartLink . '" name="affiliate_link">';
    $out_ .= '<input type="submit" value="' . $apButtonLabel . '" class="' . $buttonClass . '">';
    $out_ .= '</form>';
    
    $out = '';
    if (isset($affileseoOptions['hide_add_to_basket'])) {
        if ($affileseoOptions['hide_add_to_basket'] == 1) {} else {
            $out .= $out_;
        }
    } else {
        $out .= $out_;
    }
    
    return $out;
}

function writeAddToBasketLink($affileseoOptions, $cartLink, $linkLabel, $linkClass)
{
    $out_ = '<a href="' . $cartLink . '" class="' . $linkClass . '" target="_blank" rel="nofollow">' . $linkLabel . '</a>';
    $out = '';
    if (isset($affileseoOptions['hide_add_to_basket'])) {
        if ($affileseoOptions['hide_add_to_basket'] == 1) {} else {
            $out .= $out_;
        }
    } else {
        $out .= $out_;
    }
    
    return $out;
}

function writePdpButton($apCartLink, $apButtonLabel, $formClass, $buttonClass)
{
    $out = '<form action="' . get_bloginfo('url') . '/go/" method="post" target="_blank" class="' . $formClass . '">';
    $out .= '<input type="hidden" value="' . $apCartLink . '" name="affiliate_link">';
    $out .= '<input type="submit" value="' . $apButtonLabel . '" class="' . $buttonClass . '">';
    $out .= '</form>';
    
    return $out;
}

function writePdpLink($cartLink, $linkLabel, $linkClass)
{
    return '<a href="' . $cartLink . '" class="' . $linkClass . '" target="_blank" rel="nofollow">' . $linkLabel . '</a>';
}

function checkImageExtension($imageUrl)
{
    if (! filter_var($imageUrl, FILTER_VALIDATE_URL)) {
        return FALSE;
    }
    
    $imageTypes = array(
        'jpeg',
        'jpg',
        'gif',
        'png'
    );
    $fileInfo = (array) pathinfo(parse_url($imageUrl, PHP_URL_PATH));
    
    return isset($fileInfo['extension']) && in_array(strtolower($fileInfo['extension']), $imageTypes, TRUE);
}

function createUrlThumbnailHtml($html)
{
    global $post;
    $value = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
    $nonce = wp_create_nonce('external_thumbnail_url_' . $post->ID . get_current_blog_id());
    
    $html .= '<input type="hidden" name="external_thumbnail_url_nonce" value="' . esc_attr($nonce) . '">' . '<div><p>oder</p>' . '<p>Geben Sie die URL für ein externes Bild ein</p>' . '<p><input type="url" name="external_thumbnail_url" value="' . $value . '"></p>';
    
    if (! empty($value) && checkImageExtension($value)) {
        $html .= '<p><img style="max-width:150px;height:auto;" src="' . esc_url($value) . '"></p>' . '<p>Zum Entfernen bitte die URL leer lassen.</p>';
    }
    $html .= '</div>';
    
    return $html;
}

function saveUrlThumbnailField($postId, $post)
{
    $cap = $post->post_type === 'page' ? 'edit_page' : 'edit_post';
    
    if (! current_user_can($cap, $postId) || ! post_type_supports($post->post_type, 'thumbnail') || defined('DOING_AUTOSAVE')) {
        return;
    }
    
    $action = 'external_thumbnail_url_' . $postId . get_current_blog_id();
    $nonce = filter_input(INPUT_POST, 'external_thumbnail_url_nonce', FILTER_SANITIZE_STRING);
    $imageUrl = filter_input(INPUT_POST, 'external_thumbnail_url', FILTER_VALIDATE_URL);
    
    if (empty($nonce) || ! wp_verify_nonce($nonce, $action) || (! empty($imageUrl) && ! checkImageExtension($imageUrl))) {
        return;
    }
    
    if (! empty($imageUrl)) {
        update_post_meta($postId, '_external_thumbnail_url', esc_url($imageUrl));
        if (! get_post_meta($postId, '_thumbnail_id', TRUE)) {
            update_post_meta($postId, '_thumbnail_id', 'by_url');
        }
    } elseif (get_post_meta($postId, '_external_thumbnail_url', TRUE)) {
        
        delete_post_meta($postId, '_external_thumbnail_url');
        
        if (get_post_meta($postId, '_thumbnail_id', TRUE) === 'by_url') {
            delete_post_meta($postId, '_thumbnail_id');
        }
    }
    
    $thumbnailId = get_post_meta($postId, '_thumbnail_id', TRUE);
    if (! empty($imageUrl) && intval($thumbnailId) > 0) {
        
        $attachmentId = array_keys(get_children(array(
            'post_parent' => $postId,
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'menu_order' => 0
        )));
        if (intval($attachmentId) > 0) {
            wp_update_post(array(
                'ID' => $attachmentId,
                'post_parent' => 0
            ));
        }
        delete_post_meta($postId, '_thumbnail_id', $thumbnailId);
        delete_post_meta($postId, '_thumbnail_id', $attachmentId);
    }
}

function replaceUrlThumbnailHtml($html, $postId)
{
    $imageUrl = get_post_meta($postId, '_external_thumbnail_url', TRUE);
    
    if (empty($imageUrl) || ! checkImageExtension($imageUrl)) {
        return $html;
    }
    
    $alt = get_post_field('post_title', $postId) . ' ' . __('thumbnail', 'txtdomain');
    $attr = array(
        'alt' => $alt
    );
    $attr = apply_filters('wp_get_attachment_image_attributes', $attr, NULL);
    $attr = array_map('esc_attr', $attr);
    $html = sprintf('<img src="%s"', esc_url($imageUrl));
    
    foreach ($attr as $name => $value) {
        $html .= " $name=" . '"' . $value . '"';
    }
    
    $html .= ' />';
    
    return $html;
}

function the_custom_post_thumbnail($post, $thumbnailClass, $thumbnailSize = null, $thumbnailAttributes = null)
{
    $postId = $post->ID;
    $thumbnailUrl = get_post_meta($postId, '_external_thumbnail_url', TRUE);
    
    if (strlen($thumbnailUrl) > 3) {
        $thumbnailAlt = get_the_title($postId);
        
        $thumbnailClasses = $thumbnailClass;
        
        if ($thumbnailAttributes != null && isset($thumbnailAttributes['class']) && $thumbnailAttributes['class'] != "") {
            $thumbnailClasses .= ' ' . $thumbnailAttributes['class'];
        }
        
        $idAttr = '';
        
        if ($thumbnailAttributes != null && isset($thumbnailAttributes['id']) && $thumbnailAttributes['id'] != "") {
            $idAttr .= ' id="' . $thumbnailAttributes['id'] . '" ';
        }
        
        $imgHtml = sprintf('<img src="%s"', esc_url($thumbnailUrl));
        
        $imgHtml .= ' class="' . $thumbnailClasses . '" ';
        
        $imgHtml .= ' alt="#' . $thumbnailAlt . '#" ';
        
        $imgHtml .= $idAttr;
        
        $imgHtml .= ' />';
        
        echo $imgHtml;
    } else {
        if ($thumbnailSize != null && $thumbnailAttributes != null) {
            the_post_thumbnail($thumbnailSize, $thumbnailAttributes);
        } elseif ($thumbnailSize != null) {
            the_post_thumbnail($thumbnailSize);
        } elseif ($thumbnailAttributes != null) {
            the_post_thumbnail($thumbnailAttributes);
        }
    }
}

function get_the_custom_post_thumbnail($postId, $thumbnailClass, $thumbnailSize, $thumbnailAttributes)
{
    $imgHtml = '';
    $thumbnailUrl = get_post_meta($postId, '_external_thumbnail_url', TRUE);
    if (strlen($thumbnailUrl) > 3) {
        
        $thumbnailAlt = get_the_title($postId);
        
        $thumbnailClasses = $thumbnailClass;
        
        if ($thumbnailAttributes != null && isset($thumbnailAttributes['class']) && $thumbnailAttributes['class'] != "") {
            $thumbnailClasses .= ' ' . $thumbnailAttributes['class'];
        }
        
        $imgHtml = sprintf('<img src="%s"', esc_url($thumbnailUrl));
        
        $imgHtml .= ' class="' . $thumbnailClasses . '" ';
        
        $imgHtml .= ' alt="*' . $thumbnailAlt . '*" ';
        
        $imgHtml .= $idAttr;
        
        $imgHtml .= ' />';
    } else {
        
        if ($thumbnailSize == null && $thumbnailAttributes == null) {
            $imgHtml .= get_the_post_thumbnail($postId);
        } elseif ($thumbnailAttributes != null) {
            $imgHtml = get_the_post_thumbnail($postId, $thumbnailSize, $thumbnailAttributes);
        } elseif ($thumbnailSize != null) {
            $imgHtml = get_the_post_thumbnail($postId, $thumbnailSize);
        }
    }
    
    return $imgHtml;
}

function getExternalImages($postId)
{
    $arrayExternalImages = array();
    $countExternalImages = get_post_meta($postId, 'external_images', TRUE);
    if (intval($countExternalImages) > 0) {
        for ($i = 0; $i < $countExternalImages; $i ++) {
            
            $imageTitle = get_post_meta($postId, 'external_images_' . $i . '_image_title', TRUE);
            $imageUrl = get_post_meta($postId, 'external_images_' . $i . '_image_url', TRUE);
            
            if (isset($imageUrl) && $imageUrl != "") {
                array_push($arrayExternalImages, array(
                    'title' => $imageTitle,
                    'src' => $imageUrl
                ));
            }
        }
    }
    
    return $arrayExternalImages;
}

function getPostMetaId($postId, $metaValue)
{
    global $wpdb;
    $metaId = $wpdb->get_var($wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta
        WHERE post_id = %d AND meta_value = %s", $postId, $metaValue));
    if ($metaId != '') {
        return (int) $metaId;
    } else {
        return 0;
    }
}

function get_the_custom_post_thumbnail_url($postId)
{
    if (get_post_meta($postId, '_external_thumbnail_url', TRUE) != '') {
        return get_post_meta($postId, '_external_thumbnail_url', TRUE);
    } else {
        return get_the_post_thumbnail_url($postId, 'thumbnail');
    }
}

function showNavbarSearchField($affiliseoOptions)
{
    $out = '';
    
    if (! isset($affiliseoOptions['hide_navbar_search_field']) || (isset($affiliseoOptions['hide_navbar_search_field']) && $affiliseoOptions['hide_navbar_search_field'] != "1")) {
        $out .= '<form role="search" method="get" id="navbarsearchform" class="searchform_header pull-right" action="' . get_bloginfo('url') . '">';
        $out .= '<div class="navbar_search">';
        $out .= '<div class="input-group-custom full-size">';
        $out .= '<input type="text" class="form-control-custom col10" placeholder="' . $affiliseoOptions['text_suchformular_header_input'] . '" name="s" id="s">';
        $out .= '<button class="btn-search pull-right" type="submit" id="navbarsearchsubmit">';
        $out .= '<i class="fa fa-search"></i>';
        $out .= '</button>';
        $out .= '</div>';
        $out .= '</div>';
        $out .= '</form>';
    }
    
    return $out;
}

function getProductUvpPrice($postId, $affiliseoOptions)
{
    global $pos_currency, $currency_string;
    $ret = '';
    
    if (isset($affiliseoOptions['show_uvp']) && $affiliseoOptions['show_uvp'] == 1) {
        
        $uvp = get_field('uvp', $postId);
        
        if (! empty($uvp) && strToFloat($uvp) > strToFloat(get_field('preis', $postId))) {
            $currencyBefore = ($pos_currency == 'before') ? $currency_string . ' ' : '';
            $currencyAfter = ($pos_currency == 'after') ? ' ' . $currency_string : '';
            
            $ret .= '<span class="uvp-line-through" style="top:0;">';
            $ret .= '<span class="uvp-text-color">';
            $ret .= '<sup>';
            $ret .= $currencyBefore;
            $ret .= get_field('uvp', $postId);
            $ret .= $currencyAfter;
            $ret .= '</sup>';
            $ret .= '</span>';
            $ret .= '</span>';
        }
    }
    return $ret;
}

/**
 * liefert alle optionen, die unter affiliatetheme->einstellungen verwaltet werden
 * 
 * @return string[]
 */
function getAffiliseoOptions()
{
    $options = array();
    $asOptions = get_option(AFFILISEO_THEMEOPTIONS);
    
    if (is_array($asOptions)) {
        foreach ($asOptions as $key => $value) {
            
            $options[$key] = html_entity_decode($value);
        }
    }
    
    return $options;
}

/**
 * prueft den wert der toggle-option, ob er an- oder abgeschaltet ist
 *  
 * @param string $optionKey
 * @param boolean $invert --> fuer einen negativen fall z.b. hide_xxx oder disable_xxx
 * 
 * @return boolean
 */
function isOptionEnabled($optionKey, $invert=false){
    $options = getAffiliseoOptions();
    
    if($invert){
        return (!isset($options[$optionKey]) || $options[$optionKey] != 1)? false:true;
        
    } else {
        return (isset($options[$optionKey]) && $options[$optionKey] == 1) ? true:false;        
    }

    
}