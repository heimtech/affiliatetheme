<?php
global $affiliseo_options;
get_header();

$the_tax = get_taxonomy(get_query_var('taxonomy'));
$the_term = $wp_query->queried_object;
global $query_string;
$sidebar_position = $affiliseo_options['layout_sidebar_tax'];
$tax_position = $affiliseo_options['position_description_tax'];
$appearance_products_taxonomy = '';
if ($affiliseo_options['appearance_products_taxonomy']) {
    $appearance_products_taxonomy = $affiliseo_options['appearance_products_taxonomy'];
}
$paged = 1;

echo '<div class="custom-container custom-container-margin-top">';
echo '<div class="full-size">';

if ($sidebar_position == 'links') {
    echo '<div class="col3 sidebar-left" id="sidebar">';
    get_sidebar();
    echo '</div>';
}
if ($sidebar_position != 'links' && $sidebar_position != 'rechts') {
    $width = 12;
} else {
    $width = 9;
}
echo '';

$contentLeftClass = '';
if ($sidebar_position == 'links') {
    $contentLeftClass = 'content-right';
}
$contentRightClass = '';
if ($sidebar_position == 'rechts') {
    $contentRightClass = 'content-left';
}
echo '<div class="col' . $width . ' content  ' . $contentLeftClass . ' ' . $contentRightClass . '">';
echo '<div class="box seo-text">';
echo '<h1 class="category-h1">' . $the_term->name . '</h1>';

if (trim(affiliseo_taxonomy_images_taxonomy_image_url($the_term->term_id, 'full')) !== '') {
    echo '<img src="' . affiliseo_taxonomy_images_taxonomy_image_url($the_term->term_id, 'full') . '" class="img-thumbnail pull-left post-thumbnail" alt="' . $the_term->name . '">';
}
if ((trim($tax_position) === '' || trim($tax_position) === 'top') && isset($the_term->description)) {
    echo $the_term->description;
}
echo '<div class="clearfix"></div>';
echo '</div>';

echo '<div class="row produkte">';

if (get_query_var('paged')) {
    $paged = get_query_var('paged');
}
if (get_query_var('page')) {
    $paged = get_query_var('page');
}
$posts_per_page = get_option('posts_per_page');
query_posts($query_string . '&posts_per_page=' . $posts_per_page . '&paged=' . $paged);
global $show_mini,$sameColCount,$colClass,$colCount,$psUniqueId;
$psUniqueId = mt_rand();
$horizontal = false;
$colClass = 'col-xs-6 col-md-6 col-lg-4';
$colCount = 3;
switch ($appearance_products_taxonomy) {
    case 'vertical_without':
        $show_mini = "false";
        break;
    case 'vertical_with':
        $show_mini = "true";
        break;
    default:
        $horizontal = true;
        break;
}

$sameColCount = 1;
$j = 1;
while (have_posts()) {
    the_post();

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

echo '</div>';

echo '<div class="text-center">';

$is_brand = 'true';
if ($the_term->taxonomy === 'produkt_typen') {
    $is_brand = 'false';
}
$is_custom = true;
if ($the_term->taxonomy === 'produkt_typen' || $the_term->taxonomy === 'produkt_marken') {
    $is_custom = false;
}
if ($is_custom) {
    affiliseo_product_pagination($paged, $is_brand, $the_tax);
} else {
    affiliseo_product_pagination($paged, $is_brand);
}

echo '</div>';

wp_reset_query();

echo '</div>';

if (trim($tax_position) === 'bottom' && isset($the_term->description)) {
    echo '<div class="box seo-text">' . $the_term->description . '</div>';
}

echo '</div>';

if ($sidebar_position == 'rechts') {
    echo '<div class="col3 sidebar-right" id="sidebar">';
    get_sidebar();
    echo '</div>';
}

echo '<div class="clearfix"></div>';
echo '</div>';
echo '</div>';
get_footer();