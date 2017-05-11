<?php
@ini_set('pcre.backtrack_limit', 5000000);

function affiliseo_run_shortcode($content)
{
    global $shortcode_tags;
    
    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
    $shortcode_tags = array();
    add_shortcode('produkte', 'produkte_shortcode');
    add_shortcode('row', 'affiliseo_row_shortcode');
    add_shortcode('col', 'affiliseo_column_shortcode');
    add_shortcode('hr', 'affiliseo_divider_shortcode');
    add_shortcode('clear', 'affiliseo_clear_shortcode');
    add_shortcode('alert', 'affiliseo_alert_shortcode');
    add_shortcode('list', 'affiliseo_list_shortcode');
    add_shortcode('list_item', 'affiliseo_list_item_shortcode');
    add_shortcode('button', 'affiliseo_button_shortcode');
    add_shortcode('well', 'affiliseo_well_shortcode');
    add_shortcode('tooltip', 'affiliseo_tooltip_shortcode');
    add_shortcode('thumbnails', 'affiliseo_thumbnails_shortcode');
    add_shortcode('thumbnail', 'affiliseo_thumbnail_shortcode');
    add_shortcode('tabs', 'tabs_shortcode');
    add_shortcode('tab', 'affiliseo_tab_shortcode');
    add_shortcode('toggle_group', 'affiliseo_toggle_group_shortcode');
    add_shortcode('toggle', 'toggle_shortcode');
    add_shortcode('testimonial', 'affiliseo_testimonial_shortcode');
    add_shortcode('pvideo', 'affiliseo_video_shortcode');
    add_shortcode('icon', 'icon_shortcode');
    add_shortcode('posts', 'posts_shortcode');
    add_shortcode('cmselements', 'cms_elements_shortcode');
    add_shortcode('comparison', 'comparison_shortcode');
    
    // Creates a space between two consecutive shortcodes (otherwise causes unexpected bugs in shortcode parsing)
    $content = preg_replace('/\]\[/im', "] [", $content);
    
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode($content);
    
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
    
    return $content;
}

add_filter('the_content', 'affiliseo_run_shortcode', 7);
add_filter('widget_text', 'affiliseo_run_shortcode', 7);

define('FIRST', 'call_');

function affiliseo_add_attach($actions, $post, $detached)
{
    if (current_user_can('edit_post', $post->ID)) {
        $actions['attach'] = '<a href="#the-list" onclick="findPosts.open( \'media[]\',\'' . $post->ID . '\' );return false;" class="hide-if-no-js">' . __('Attach') . '</a>';
    }
    return $actions;
}

add_filter('media_row_actions', 'affiliseo_add_attach', 10, 3);

/**
 * Produkte Shortcode
 */
function produkte_shortcode($atts, $content = null)
{
    global $affiliseo_options, $device, $headline_title_global, $show_mini, $has_sidebar, $psUniqueId, $colClass, $colCount, $sameColCount;
    
    $psUniqueId = mt_rand();
    
    $a = shortcode_atts(array(
        "limit" => "6",
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
    
    if ($highscore === 'false' && $checklist === 'false' && $slider === 'false') {
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
                    handle_headers($headline_title, $checklist);
                    echo '<div class="row produkte">';
                }
                if ($sidebar == "true") {
                    get_template_part('loop', 'produkt-sidebar');
                    $output .= ob_get_clean();
                    break;
                } else {
                    if ($horizontal == "true") {
                        get_template_part('loop', 'produkt-horizontal');
                    } else {
                        
                        if ($j > $colCount) {
                            
                            $sameColCount ++;
                            
                            $j = 1;
                        }
                        $j ++;
                        get_template_part('loop', 'product');
                    }
                }
                
                $i ++;
                
                $output .= ob_get_clean();
            }
            
            $output = handle_ad($ad, $break_out, $device, $affiliseo_options, $output, false, $addClearfix);
            
            $output = $output . '</div>';
        }
        wp_reset_query();
    } elseif ($checklist === 'true') {
        query_posts($args);
        global $wp_query;
        $length = $wp_query->post_count;
        $ctChecklist = 1;
        if (have_posts()) {
            
            while (have_posts()) {
                the_post();
                ob_start();
                if ($ctChecklist === 1) {
                    handle_headers($headline_title, $checklist);
                    get_template_part('loop', 'product-checklist');
                    if ($ctChecklist === intval($length)) {
                        get_template_part('loop', 'product-checklist-close');
                    }
                } elseif ($ctChecklist === intval($length)) {
                    get_template_part('loop', 'product-checklist');
                    get_template_part('loop', 'product-checklist-close');
                } else {
                    get_template_part('loop', 'produkt-checklist');
                }
                $ctChecklist ++;
                $output .= ob_get_clean();
            }
            
            $output = handle_ad($ad, $break_out, $device, $affiliseo_options, $output, true, $addClearfix);
        }
        wp_reset_query();
    } elseif ($slider === 'true') {
        
        $output = '';
        
        $sameColCount = 1;
        $carouselId = mt_rand();
        
        query_posts($args);
        global $wp_query;
        $length = $wp_query->post_count;
        
        ob_start();        
        handle_headers($headline_title, $checklist);
        $output .= ob_get_clean();
        
        $output .= '<div style="height:auto;" id="carousel-' . $carouselId . '" class="carousel slide" data-ride="carousel">';
        $output .= '<div class="controls pull-right hidden-xs">';
        $output .= '<a class="left fa fa-chevron-left btn btn-link" href="#carousel-' . $carouselId . '" data-slide="prev"></a>';
        $output .= '<a class="right fa fa-chevron-right btn btn-link" href="#carousel-' . $carouselId . '" data-slide="next"></a>';
        $output .= '</div>';
        $output .= '<div class="carousel-inner">';
        $output .= '<div class="item active">';
        $output .= '<div class="row produkte">';
        
        if (have_posts()) {
            $j = 0;
            while (have_posts()) {
                the_post();
                ob_start();
                
                if ($j % $colCount == 0 && $j != 0) {
                    $sameColCount ++;
                    echo '</div></div><div class="item"><div class="row produkte">';
                }
                
                get_template_part('loop', 'product');
                
                $j ++;
                
                $output .= ob_get_clean();                
                
            }
            
            $output .= '</div>
				</div>
                <br class="noautowp" />&nbsp;<br class="noautowp" />&nbsp;<br class="noautowp" />&nbsp;<br class="noautowp" />&nbsp;
                <div class="clearfix"></div>
					</div>
				</div>';
        }
        wp_reset_query();
    } else {
        
        $args = array(
            'post_type' => 'produkt',
            'orderby' => $orderby,
            'order' => $order,
            'produkt_marken' => $marken,
            'produkt_typen' => $typen,
            'meta_key' => ''
        );
        
        if (empty($ids)) {
            $args['posts_per_page'] = $limit;
        } else {
            $args['post__in'] = $ids;
        }
        
        if (trim($orderby) === 'preis') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'preis';
        } elseif (trim($orderby) === 'interne_bewertung') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'interne_bewertung';
        } elseif (trim($orderby) === 'sterne_bewertung') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'sterne_bewertung';
        }
        
        query_posts($args);
        global $ctHighscore;
        global $wp_query;
        $length = $wp_query->post_count;
        $ctHighscore = 1;
        
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                ob_start();
                if ($ctHighscore === 1) {
                    handle_headers($headline_title, $checklist);
                    get_template_part('table', 'product-header');
                }
                get_template_part('loop', 'product-highscore');
                if ($ctHighscore === intval($length)) {
                    get_template_part('table', 'product-footer');
                }
                $output .= ob_get_clean();
                $ctHighscore ++;
            }
            
            $output = handle_ad($ad, $break_out, $device, $affiliseo_options, $output, true, $addClearfix);
        }
        wp_reset_query();
    }
    
    if (trim($headline_title) !== '') {
        $output .='</div>';
        
    }
    
    $output = removeEditorNewLines($output);
    
    return $output;
}

function handleClearfix($addClearfix)
{
    return '';
    $out = ($addClearfix == 'true') ? '<div class="clearfix"></div>' : '';
    return $out;
}

function handle_headers($headline_title, $checklist)
{
    if (trim($headline_title) !== '') {
        echo '<h4><span class="h4-product custom-headline">' . $headline_title . '</span></h4>';
        echo '<div class="headline-product headline-product-line">';
    }
    if ($checklist === 'true') {
        get_template_part('loop', 'produkt-checklist-open');
    }
}

function handle_ad($ad, $break_out, $device, $affiliseo_options, $output, $is_highscore, $addClearfix)
{
    if ($ad == "true") {
        $highscore_ad_class = $is_highscore ? ' ad-highscore' : '';
        if ($break_out == "true") {
            // ToDo handle break out after ad in shortcode
            if ($device === 'desktop') {
                if (trim($affiliseo_options["ad_produkt_shortcode_bottom"] != '') && isset($affiliseo_options["ad_produkt_shortcode_bottom"])) {
                    $output .= handleClearfix($addClearfix) . '</div><div class="ad text-center' . $highscore_ad_class . '">' . $affiliseo_options["ad_produkt_shortcode_bottom"] . '</div>' . handleClearfix($addClearfix) . '<div class="box content after-product"></div>';
                }
            } else {
                if (trim($affiliseo_options["ad_produkt_shortcode_bottom_mobile"] != '') && isset($affiliseo_options["ad_produkt_shortcode_bottom_mobile"])) {
                    $output .= handleClearfix($addClearfix) . '</div><div class="ad-mobile text-center' . $highscore_ad_class . '">' . $affiliseo_options["ad_produkt_shortcode_bottom_mobile"] . '</div>' . handleClearfix($addClearfix) . '<div class="box content after-product"></div>';
                }
            }
        } else {
            // $output .= handleClearfix($addClearfix) . '</div>';
        }
    } else {
        // ToDo handle break out after shortcode
        if ($break_out == "true") {
            $output .= handleClearfix($addClearfix) . '</div><div class="box content after-product"></div>';
        } else {
            // $output .= handleClearfix($addClearfix) . '</div>';
        }
    }
    
    $output = removeEditorNewLines($output);
    
    return $output;
}


    /*
 * ROW
 */
function affiliseo_row_shortcode($atts, $content = null)
{
    $output = '<div class="full-size">' . do_shortcode($content) . '<div class="clearfix"></div></div>';
    
    return removeEditorNewLines($output);
}

/*
 * COLUMN
 */
function affiliseo_column_shortcode($atts, $content = null)
{
    $arr = shortcode_atts(array(
        "sm" => ""
    ), $atts);
    $sm = $arr['sm'];
    
    $output = '<div class="col' . $sm . '">' . do_shortcode($content) . '</div>';
    
    return removeEditorNewLines($output);
}

/*
 * DIVIDER
 */
function affiliseo_divider_shortcode($atts, $content = null)
{
    return '<hr/>';
}

/*
 * CLEAR
 */
function affiliseo_clear_shortcode($atts, $content = null)
{
    return '<div class="clearfix"></div>';
}

/*
 * BUTTON
 */
function affiliseo_button_shortcode($atts, $content = null)
{
    $arr = shortcode_atts(array(
        "size" => "",
        "style" => "",
        "icon" => ""
    ), $atts);
    $size = $arr['size'];
    $style = $arr['style'];
    $icon = $arr['icon'];
    
    if ($size != "") {
        $size_class = "btn-" . $size;
    }
    if (trim($icon) !== '') {
        $icon = '<i class="fa fa-' . $icon . '"></i> ';
    }
    
    $output = '<button type="button" class="btn ' . $size_class . ' btn-' . $style . '"> ' . $icon . do_shortcode($content) . '</button>';
    
    return removeEditorNewLines($output);
}

/*
 * ALERT
 */
function affiliseo_alert_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
        "type" => "",
        "icon" => ""
    ), $atts));
    
    if (trim($icon) !== '') {
        $icon = '<i class="fa fa-' . $icon . '"></i> ';
    }
    
    $output = '<div class="alert alert-' . $type . '">' . $icon . do_shortcode($content) . '</div>';
    
    return $output;
}

/*
 * LIST
 */
function affiliseo_list_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
        "style" => ""
    ), $atts));
    
    $output = '<ul class="falist ' . $style . '">' . do_shortcode($content) . '</ul>';
    
    return removeEditorNewLines($output);
}

function affiliseo_list_item_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
        "icon" => ""
    ), $atts));
    
    if (trim($icon) !== '') {
        $icon = '<i class="fa fa-' . $icon . '"></i> ';
    }
    
    $output = '<li>' . $icon . do_shortcode($content) . '</li>';
    
    return removeEditorNewLines($output);
}

/*
 * WELL
 */
function affiliseo_well_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
        "size" => "",
        "icon" => ""
    ), $atts));
    
    if (trim($icon) !== '') {
        $icon = '<i class="fa fa-' . $icon . '"></i> ';
    }
    
    $output = '<div class="well ' . $size . '">' . $icon . do_shortcode($content) . '</div>';
    
    return removeEditorNewLines($output);
}

/*
 * Tooltip
 */
function affiliseo_tooltip_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
        "position" => "",
        "text" => ""
    ), $atts));
    
    $output = '<a href="#" data-toggle="tooltip" data-placement="' . $position . '" title="' . $text . '">' . do_shortcode($content) . '</a>';
    
    return removeEditorNewLines($output);
}

/**
 * Thumbnail (Box) Shortcode
 */
function affiliseo_thumbnail_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
        "title" => "",
        "img" => "",
        "link" => ""
    ), $atts));
    
    $output .= '<li class="span4">';
    $output .= '<div class="thumbnail">';
    $output .= '<h3>' . $title . '</h3>';
    $output .= '<img alt="" style="width: 300px; height: 220px;" src="' . $img . '">';
    $output .= '<div class="caption">';
    $output .= '<div>' . do_shortcode($content) . '</div>';
    $output .= '<a href="' . $link . '" class="blue-arrow">' . __('more', 'affiliatetheme') . '</a>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</li>';
    
    $output = removeEditorNewLines($output);
    
    return $output;
}

function affiliseo_thumbnails_shortcode($atts, $content = null)
{
    $output = '<ul class="thumbnails">' . do_shortcode($content) . '</ul>';
    
    return removeEditorNewLines($output);
}

/**
 * Tab Shortcode
 */
function tabs_shortcode($atts, $content = null)
{
    $arr = shortcode_atts(array(
        "titles" => "",
        "id" => "",
        "icons" => ""
    ), $atts);
    
    $titles = $arr['titles'];
    $id = $arr['id'];
    $icons = $arr['icons'];
    
    $content = preg_replace('/\[\/tab\](.*?)\[tab\]/im', "[/tab]\n[tab]", $content);
    
    $tabs = explode(",", $titles);
    if (trim($icons) !== '') {
        $icons = explode(",", $icons);
    }
    $tab_number = 1;
    
    $output = '<ul class="nav nav-tabs Tab' . $id . '" id="Tabs">';
    foreach ($tabs as $tab) {
        $icon = '';
        if (count($icons) > 0 && isset($icons)) {
            if (isset($icons[$tab_number - 1])) {
                $icon = $icons[$tab_number - 1];
                if ($icon !== '') {
                    $icon = '<i class="fa fa-' . $icons[$tab_number - 1] . '"></i> ';
                }
            }
        }
        $output .= '<li class="rounded-top"><a href="#tab' . $tab_number . '">' . $icon . trim($tab) . '</a></li>';
        $tab_number ++;
    }
    $output .= '</ul>';
    
    $output .= '<div class="tab-content">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= '<div class="clearfix"></div>';
    
    $output .= "<script type='text/javascript'>jQuery(document).ready(function() { jQuery('.Tab" . $id . " a:first').tab('show'); jQuery('.Tab" . $id . " a').click(function (e) { e.preventDefault();  jQuery(this).tab('show'); }) });</script>";
    
    // $output .='<script> $( function() { $( "#Tabs" ).tabs(); } ); </script>';
    
    $output = removeEditorNewLines($output);
    
    return $output;
}

function affiliseo_tab_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
        "id" => "",
        "tabid" => ""
    ), $atts));
    
    $output = '<div class="tab-pane" id="tab' . $id . '">' . do_shortcode($content) . '</div>';
    
    return removeEditorNewLines($output);
}

/*
 * Toogle
 */
function toggle_shortcode($atts, $content = null)
{
    $arr = shortcode_atts(array(
        "title" => "",
        "group" => "",
        "active" => "",
        "icon" => ""
    ), $atts);
    
    $id = rand(1, 9999);
    
    $content_preg = preg_replace('/\[\/toggle\](.*?)\[toggle\]/im', "[/toggle]\n[toggle]", $content);
    
    $title = $arr['title'];
    $group = $arr['group'];
    $active = $arr['active'];
    $icon = $arr['icon'];
    
    if (trim($icon) !== '') {
        $icon = '<i class="fa fa-' . $icon . '"></i> ';
    }
    
    if ($active == "true") {
        $active_item = " in";
        $collapsed = "";
        $symbol = "<i class='fa fa-minus-circle'></i>";
    } else {
        $active_item = "";
        $collapsed = 'class="collapsed"';
        $symbol = "<i class='fa fa-plus-circle'></i>";
    }
    
    $output = '<div class="panel panel-default">';
    $output .= '<a href="#collapse' . $id . '" data-toggle="collapse" data-parent="#accordion' . $group . '" ' . $collapsed . '>';
    $output .= '<div class="panel-heading">';
    $output .= $icon . ' ' . $title;
    $output .= '<span style="float: right;">' . $symbol . '</span>';
    $output .= '<div class="clearfix"></div>';
    $output .= '</div>';
    $output .= '</a>';
    $output .= '<div class="accordion-body collapse' . $active_item . '" id="collapse' . $id . '">';
    $output .= '<div class="panel-body"><hr>' . do_shortcode($content_preg) . '</div>';
    $output .= '</div>';
    $output .= '</div>';
    
    $output = removeEditorNewLines($output);
    
    return $output;
}

function affiliseo_toggle_group_shortcode($atts, $content = null)
{
    $arr = shortcode_atts(array(
        "id" => ""
    ), $atts);
    $id = $arr['id'];
    
    $output = '<div class="panel-group" id="accordion' . $id . '">' . do_shortcode($content) . '</div>';
    
    return removeEditorNewLines($output);
}

/*
 * Testimonials
 */
function affiliseo_testimonial_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
        "right" => "",
        "img" => "",
        "text" => "",
        "name" => "",
        "company" => ""
    ), $atts));
    
    if ($right == 0 || $right == "") {
        $output = '<blockquote><img class="pull-left" src="' . $img . '" style="max-width:120px;margin-right:15px"><span>' . $text . '</span><small>' . $name . ', <cite>' . $company . '</cite></small><div class="clearfix"></div></blockquote>';
    } else {
        $output = '<blockquote class="pull-right"><img class="pull-right" src="' . $img . '"><span>' . $text . '</span><small>' . $name . ', <cite>' . $company . '</cite></small></blockquote><div class="clearfix"></div>';
    }
    
    return removeEditorNewLines($output);
}

/*
 * Videos
 */
function affiliseo_video_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
        "type" => "",
        "id" => ""
    ), $atts));
    
    switch ($type) {
        case 'youtube':
            $output = '<div class="elastic-video"><iframe width="725" height="450" src="//www.youtube.com/embed/' . $id . '?wmode=transparent" frameborder="0" allowfullscreen></iframe></div>';
            break;
        case 'vimeo':
            $output = '<div class="elastic-video"><iframe src="//player.vimeo.com/video/' . $id . '?badge=0" width="725" height="450" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
    }
    
    $output = removeEditorNewLines($output);
    
    return $output;
}

/*
 * Icons
 */
function icon_shortcode($atts, $content = null)
{
    $arr = shortcode_atts(array(
        'type' => '',
        'size' => ''
    ), $atts);
    $type = $arr['type'];
    $size = $arr['size'];
    if ($size === '') {
        $size = '1';
    }
    $output = '<i class="fa icon-class fa-' . $type . ' fa-' . $size . 'x"></i>';
    
    $output = removeEditorNewLines($output);
    
    return $output;
}

/**
 *
 * @param unknown $atts            
 * @param string $content            
 * @return string
 */
function cms_elements_shortcode($atts, $content = null)
{
    $arr = shortcode_atts(array(
        "product_id" => "",
        "cms_element" => ""
    ), $atts);
    
    $productId = $arr['product_id'];
    $cmsElement = $arr['cms_element'];
    $permaLink = get_permalink($productId);
    
    global $affiliseo_options;
    $affiliseo_options = getAffiliseoOptions();
    
    $button_price_comparison = $affiliseo_options['button_price_comparison'];
    if (trim($button_price_comparison) === '') {
        $button_price_comparison = 'zum Preisvergleich';
    }
    $headline_price_comparison = $affiliseo_options['headline_price_comparison'];
    
    switch ($cmsElement) {
        
        case 'price_compare':
            $output = '<div class="buttons" style="width:315px;">' . '<span><a href="' . $permaLink . '#price_comparison" class="btn btn-ap" id="price_comparison_link">' . '<i class="fa fa-tags"></i> ' . $button_price_comparison . '</a></span></div>';
            break;
        
        case 'price_compare_box':
            $output = '<div class="box">' . '<h3 class="price-comparison-headline"><i class="fa fa-tags"></i> ' . $headline_price_comparison . '</h3>' . '<div id="price_compare_box"><div class="text-center"><i class="fa fa-spinner"></i> Daten werden geladen...</div></div>' . '</div>' . '<script>jQuery(document).ready(function() {getPriceComparisonData("' . get_home_url() . '","' . $productId . '", "price_compare_box","div");});</script>';
            break;
        
        case 'price_box':
            $output = '<div style="width:315px;">';
            
            if ($affiliseo_options['allg_preise_ausblenden'] != 1) {
                global $pos_currency, $text_tax, $currency_string;
                
                $price = get_field('preis', $productId);
                
                if ($price === $no_price_string) {
                    $output .= '<p class="no-price">' . $price . '</p>';
                } else {
                    
                    $output .= '<p class="price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">';
                    
                    if (trim($pos_currency) === 'before') {
                        $output .= $currency_string . ' <span itemprop="price" content="' . strToFloat($price) . '">' . $price . '</span> ';
                    } else {
                        $output .= '<span itemprop="price" content="' . strToFloat($price) . '">' . $price . '</span> ' . $currency_string . ' ';
                    }
                    $output .= '<meta itemprop="priceCurrency" content="EUR" />' . '<span class="mwst">' . $text_tax . '</span></p>';
                }
            } else {
                $output .= '<span>&nbsp;</span>';
            }
            $output .= '</div>';
            
            break;
        
        case 'product_image':
            $output = '';
            
            $productImages = array();
            
            // first get all external images
            $externalImages = getExternalImages($post->ID);
            $externalThumbnailSrc = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
            
            if (count($externalImages) > 0) {
                foreach ($externalImages as $externalImage) {
                    $externalImageSrc = $externalImage['src'];
                    $externalImageTitle = $externalImage['title'];
                    
                    if (! in_array($externalImageSrc, $productImages)) {
                        $output .= '<img class="img_by_url_image_w150" src="' . $externalImageSrc . '"   alt="">';
                        array_push($productImages, $externalImageSrc);
                    }
                }
            }
            
            $attachments = get_posts('post_type=attachment&post_parent=' . $productId . '&posts_per_page=-1&order=ASC');
            
            if ($attachments && count($attachments) > 0) {
                $attachment = $attachments[0];
                $id = $attachment->ID;
                $image_attributes = wp_get_attachment_image_src($id, 'thumbnail');
                
                if (! in_array($image_attributes[0], $productImages)) {
                    $output .= '<img class="img_by_url_image_w150" src="' . $image_attributes[0] . '"   alt="">';
                    array_push($productImages, $image_attributes[0]);
                }
            }
            break;
        
        case 'add_to_cart_button':
            $apPdpLink = get_field('ap_pdp_link', $productId);
            $output = '<div class="buttons" style="width:315px;"> ' . '<a rel="nofollow" target="_blank" class="btn btn-ap btn-block" href="' . $apPdpLink . '"> zum Shop</a></div>';
            break;
        
        case 'product_detail_page_button':
            
            $output = '<div class="buttons" style="width:315px;"> ' . '<a class="btn btn-detail btn-block" href="' . $permaLink . '"> ' . __('Description', 'affiliatetheme') . '</a></div>';
            break;
        
        case 'product_rating':
            if (! isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating'] != 1) {
                $output = '<div style="float:left; width:95px;">' . get_product_rating($productId, "", "") . '</div>';
            }
            break;
        
        default:
            $output = '';
    }
    
    $output = removeEditorNewLines($output);
    
    return $output;
}

function posts_shortcode($atts, $content = null)
{
    $arr = shortcode_atts(array(
        'selected_posts' => '',
        'selected_category' => '',
        'selected_tag' => '',
        'max_posts' => '',
        'length' => '',
        'show_thumbnail' => '',
        'selected_template' => '',
        'tpl_headline_length' => '',
        'tpl_short_text_length' => '',
        'tpl_long_text_length' => ''
    ), $atts);
    
    $templateDefinitions = array(
        1 => array(
            'different_first_row' => false,
            'img_width' => 180,
            'post_title_length' => (isset($arr['tpl_headline_length'])) ? intval($arr['tpl_headline_length']) : 0,
            'post_text_length' => (isset($arr['tpl_short_text_length'])) ? intval($arr['tpl_short_text_length']) : 0,
            'box_width' => '48%',
            'box_height' => '200px'
        ),
        
        2 => array(
            'different_first_row' => true,
            'img_width' => 180,
            'post_title_length' => (isset($arr['tpl_headline_length'])) ? intval($arr['tpl_headline_length']) : 0,
            'post_text_length' => (isset($arr['tpl_short_text_length'])) ? intval($arr['tpl_short_text_length']) : 0,
            'box_width' => '48%',
            'box_height' => '200px',
            'different_box' => array(
                'img_width' => 300,
                'post_title_length' => (isset($arr['tpl_headline_length'])) ? intval($arr['tpl_headline_length']) : 0,
                'post_text_length' => (isset($arr['tpl_long_text_length'])) ? intval($arr['tpl_long_text_length']) : 0,
                'box_width' => '97.2%',
                'box_height' => 'auto'
            )
        ),
        
        3 => array(
            'different_first_row' => false,
            'img_width' => 520,
            'post_title_length' => (isset($arr['tpl_headline_length'])) ? intval($arr['tpl_headline_length']) : 0,
            'post_text_length' => (isset($arr['tpl_long_text_length'])) ? intval($arr['tpl_long_text_length']) : 0,
            'box_width' => '48%',
            'box_height' => 'auto'
        ),
        
        4 => array(
            'different_first_row' => false,
            
            'img_width' => 150,
            'box_width' => '38%',
            'post_title_length' => (isset($arr['tpl_headline_length'])) ? intval($arr['tpl_headline_length']) : 0,
            'post_text_length' => (isset($arr['tpl_short_text_length'])) ? intval($arr['tpl_short_text_length']) : 0,
            'box_height' => '200px',
            
            'different_box' => array(
                'img_width' => 300,
                'box_width' => '58%',
                'post_title_length' => (isset($arr['tpl_headline_length'])) ? intval($arr['tpl_headline_length']) : 0,
                'post_text_length' => (isset($arr['tpl_long_text_length'])) ? intval($arr['tpl_long_text_length']) : 0,
                'box_height' => '400px'
            )
        ),
        
        5 => array(
            'different_first_row' => false,
            'img_width' => 300,
            'post_title_length' => (isset($arr['tpl_headline_length'])) ? intval($arr['tpl_headline_length']) : 0,
            'post_text_length' => (isset($arr['tpl_long_text_length'])) ? intval($arr['tpl_long_text_length']) : 0,
            'box_width' => '100%',
            'box_height' => 'auto'
        )
    );
    
    $selected_posts = array();
    
    if ($arr['selected_posts'] !== '') {
        $selected_posts = explode(",", $arr['selected_posts']);
        $selected_posts = array_map('trim', $selected_posts);
    }
    
    if (isset($arr['selected_category']) && $arr['selected_category'] !== '' && $arr['selected_category'] != - 1) {
        $selected_category = $arr['selected_category'];
        if ($selected_category === 'none') {
            $selected_category = '';
        }
    } else {
        $selected_category = '';
    }
    if (isset($arr['selected_tag']) && $arr['selected_tag'] !== '') {
        $selected_tag = $arr['selected_tag'];
        if ($selected_tag === 'none') {
            $selected_tag = '';
        }
    } else {
        $selected_tag = '';
    }
    if (isset($arr['max_posts']) && trim($arr['max_posts'] !== '')) {
        $max_posts = $arr['max_posts'];
    } else {
        $max_posts = - 1;
    }
    
    if (isset($arr['length']) && trim($arr['length']) !== '') {
        $length = (int) $arr['length'];
    } else {
        $length = 80;
    }
    
    if ($arr['show_thumbnail'] !== 'false') {
        $show_thumbnail = true;
    } else {
        $show_thumbnail = false;
    }
    
    $query_args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'orderby' => 'date',
        'posts_per_page' => $max_posts
    );
    if ($selected_category !== '') {
        $query_args['category_name'] = $selected_category;
    }
    if ($selected_tag !== '') {
        $query_args['tag_id'] = $selected_tag;
    }
    if (count($selected_posts) !== 0) {
        $query_args['post__in'] = $selected_posts;
    }
    
    $the_query = new WP_Query($query_args);
    
    $output = '';
    
    if ($the_query->have_posts()) {
        $i = 0;
        
        $output = '<style>
@media screen and (max-width: 700px) {
	.blog-preview-outer-box, .blog-preview-inner-box {
		float: none !important;
		width: auto !important;
		height: auto !important;
		margin-right: 0;
        overflow: auto;
	}
	.blog-preview-inner-box {
		overflow: visible;
	}
}
</style>';
        
        
        
        // $output .= '<div class="clearfix"></div>';
        
        $output .= '<div class="box content after-product" style="width: 100%; float: none;">';
        
        $tplDefinition = $templateDefinitions[$arr['selected_template']];
        
        $posts = $the_query->get_posts();
        
        $count = 1;
        $postCount = 1;
        
        foreach ($posts as $post) {
            
            $output .= writePostTemplate($post, $tplDefinition, $tplDefinition["different_first_row"], $arr['selected_template'], $postCount);
            
            if ($tplDefinition["different_first_row"] == true) {
                $tplDefinition["different_first_row"] = false;
                $count = 0;
            }
            if ($count == 2 && $arr['selected_template'] != 4) {
                $output .= '<div class="clearfix"></div>';
                $count = 0;
            }
            
            if ($count == 3 && $arr['selected_template'] == 4) {
                $output .= '<div class="clearfix"></div>';
                $count = 0;
            }
            
            $count ++;
            $postCount ++;
        }
        
        $output .= '<div class="clearfix"></div>';
        $output .= '</div>';
        
        $output .= '<div class="clearfix"></div>';
        // $output .= '<div class="box content after-product">';
    }
    
    wp_reset_postdata();
    
    $output = removeEditorNewLines($output);
    
    return $output;
}

function writePostTemplate($post, $tplDefinition, $differentFirstRow, $selectedTemplate, $postCount)
{
    $imageSizes = array(
        150 => 'image_150_150',
        180 => 'product_small',
        300 => 'blog_thumbnail',
        520 => 'slider_big'
    );
    
    if ($differentFirstRow == true || ($selectedTemplate == 4 && ($postCount % 3) == 1)) {
        
        $tplDefinition['img_width'] = $tplDefinition['different_box']['img_width'];
        $tplDefinition['box_height'] = $tplDefinition['different_box']['box_height'];
        $tplDefinition['box_width'] = $tplDefinition['different_box']['box_width'];
        $tplDefinition['post_text_length'] = $tplDefinition['different_box']['post_text_length'];
        $tplDefinition['post_title_length'] = $tplDefinition['different_box']['post_title_length'];
    }
    
    $postContent = $post->post_content;
    $postContent = preg_replace('/\[posts(.*)\]/', '', $postContent);
    $postContent = preg_replace('/\[produkte(.*)\]/', '', $postContent);
    $postContent = preg_replace('/\[cmselements(.*)\]/', '', $postContent);
    $postContent = strip_tags($postContent);
    
    $postContent = substr($postContent, 0, $tplDefinition['post_text_length'] + (strlen($postContent) - strlen(strip_tags($postContent)))) . '...';
    
    $permaLink = get_the_permalink($post->ID);
    $postTitle = '<a href="' . $permaLink . '">' . substr($post->post_title, 0, $tplDefinition['post_title_length']) . '</a>';
    
    $outerBoxStyle = ' float:left;  margin:6px; ' . ' width:' . $tplDefinition['box_width'] . '; ' . ' height:' . $tplDefinition['box_height'] . '; ';
    
    $innerBoxStyle = ' height:' . ($tplDefinition['box_height'] - 40) . 'px; ' . ' overflow: hidden; ' . ' text-overflow:ellipsis;';
    
    $innerBoxStyleTpl3 = ' margin:6px; ' . ' height:' . ($tplDefinition['box_height']) . '; ' . ' overflow: hidden; ' . ' text-overflow:ellipsis;';
    
    $h3Style = '';
    
    $thumbnailSize = 'thumbnail';
    if(isset($tplDefinition['img_width']) && isset($imageSizes[$tplDefinition['img_width']])) {
        $thumbnailSize = $imageSizes[$tplDefinition['img_width']];        
    } 
    
    $externalThumbnailUrl = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
    $attachmentImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $thumbnailSize);
    
    if (strlen($externalThumbnailUrl) > 3) {
        $imageSrc = $externalThumbnailUrl;
    } elseif (isset($attachmentImage[0]) && strlen($attachmentImage[0]) > 3) {
        $imageSrc = $attachmentImage[0];
    } else {
        /**
         * wenn kein beitragsbild existiert, dann soll ein
         * transparentes 1px grosses bild anzegeigt werden
         */
        $imageSrc = get_template_directory_uri() . '/images/empty.png';
        $tplDefinition['img_width'] = 1;
        $innerBoxStyle .= ' margin-left:8px;';
        $h3Style = 'position:relative; left:-15px;';
    }
    
    if ($selectedTemplate == 3) {
        $out = '<div class="blog-preview-outer-box" style="' . $outerBoxStyle . '">' . '<div class="blog-preview-inner-box" style="' . $innerBoxStyleTpl3 . '">' . '<a href="' . $permaLink . '">' . '<img style="margin:5px;" src="' . $imageSrc . '" width="' . $tplDefinition['img_width'] . '" />' . '</a>' . '<br /><h3>' . $postTitle . '</h3>' . '' . $postContent . '</div>' . ' <div style="text-align:right; position:relative; right:8px; bottom:3px; float:right; "><a href="' . $permaLink . '">weiterlesen...</a></div>' . '</div>';
    } else {
        $out = '<div class="blog-preview-outer-box" style="' . $outerBoxStyle . '">' . '<div class="blog-preview-inner-box" style="' . $innerBoxStyle . '">' . '<a href="' . $permaLink . '">' . '<img style="float:left; margin: 4px 10px 12px 4px;" src="' . $imageSrc . '" width="' . $tplDefinition['img_width'] . '" />' . '</a><h3 style="' . $h3Style . '">' . $postTitle . '</h3>' . '' . $postContent . '</div>' . ' <div style="text-align:right; position:relative; right:8px; bottom:3px; "><a href="' . $permaLink . '">weiterlesen...</a></div>' . '</div>';
    }
    
    return do_shortcode($out);
}

function comparison_shortcode($atts, $content = null)
{
    $a = shortcode_atts(array(
        "limit" => "6",
        "orderby" => "date",
        "compare" => "active",
        "header_position" => "scroll",
        "order" => "ASC",
        "comparison_products" => ""
    ), $atts);
    
    $limit = $a['limit'];
    $orderby = $a['orderby'];
    $order = $a['order'];
    $comparisonProducts = $a['comparison_products'];
    
    $args = array(
        'post_type' => 'produkt',
        'orderby' => $orderby,
        'order' => $order
    );
    
    if (intval($limit) > 0) {
        $args['posts_per_page'] = $limit;
    } else {
        $args['posts_per_page'] = - 1;
    }
    
    $comparisonProductsArray = explode(",", $comparisonProducts);
    
    if (count($comparisonProductsArray) > 0) {
        if (intval($comparisonProductsArray[0]) > 1) {
            $args['post__in'] = array_map('trim', $comparisonProductsArray);
        } else {
            $args['produkt_typen'] = $comparisonProductsArray[0];
        }
    } else {
        $args['post__in'] = array_map('trim', array(
            0
        ));
    }
    
    if (in_array(trim($orderby), array(
        'preis',
        'sterne_bewertung',
        'interne_bewertung'
    ))) {
        $args['orderby'] = 'meta_value_num';
    }
    
    if (trim($orderby) === 'preis') {
        $args['meta_key'] = 'preis';
    } elseif ($orderby == 'sterne_bewertung') {
        $args['meta_key'] = 'sterne_bewertung';
    } elseif (trim($orderby) === 'interne_bewertung') {
        $args['meta_key'] = 'interne_bewertung';
    }
    
    $args['order'] = $order;
    
    $output = '';
    
    global $comparisonProducts, $firstComparisonProduct, $compareFunction, $headerPosition, $compareTableId;
    $comparisonProducts = get_posts($args);
    $firstComparisonProduct = $comparisonProducts[0];
    $compareFunction = $a['compare'];
    $headerPosition = $a['header_position'];
    $compareTableId = mt_rand();
    
    ob_start();
    get_template_part('loop', 'comparison-product-header');
    $output .= ob_get_clean();
    
    ob_start();
    get_template_part('loop', 'comparison-product');
    $output .= ob_get_clean();
    
    ob_start();
    get_template_part('loop', 'comparison-product-footer');
    
    $output .= ob_get_clean();
    
    $output = removeEditorNewLines($output);
    
    return $output;
}

function removeEditorNewLines($output)
{
    $output = str_replace(array(
        "\r\n",
        "\r",
        "\n"
        
    ), array(
        "",
        "",
        ""
    ), $output);
    
    return $output;
}
