<?php
/*
  Template Name: Produktfilter Ergebnisseite
 */
global $affiliseo_options;
global $device;
get_header();
$sidebar_position = $affiliseo_options['product_filter_sidebar'];
$colwidth = 12;

$min_price = 0;
if (isset($_GET['min_price']) && trim($_GET['min_price']) !== '') {
    $min_price = intval($_GET['min_price']);
}
$argv = array(
    'post_type' => 'produkt',
    'orderby' => 'meta_value_num',
    'meta_key' => 'preis'
);
$products = get_posts($argv);
$max_price = ceil(get_field('preis', $products[0]->ID) + 1);
if (isset($_GET['max_price']) && trim($_GET['max_price']) !== '') {
    $max_price = intval($_GET['max_price']);
}
$brand = '';
if (isset($_GET['brand']) && trim($_GET['brand']) !== '') {
    $brand = $_GET['brand'];
}
$type = '';
if (isset($_GET['type']) && trim($_GET['type']) !== '') {
    $type = $_GET['type'];
}
$tag = '';
if (isset($_GET['tag']) && trim($_GET['tag']) !== '') {
    $tag = $_GET['tag'];
}
$stars = '0';
if (isset($_GET['stars']) && trim($_GET['stars']) !== '') {
    $stars = $_GET['stars'];
}

global $brand_singular;
global $type_singular;

$paged = 1;
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
}
if (get_query_var('page')) {
    $paged = get_query_var('page');
}
$hide_headline = false;
if (!empty($affiliseo_options['hide_headline_page']) && trim($affiliseo_options['hide_headline_page']) === '1') {
    $hide_headline = true;
}
$headline_tag_page = 'h1';
if (!empty($affiliseo_options['headline_tag_page'])) {
    $headline_tag_page = $affiliseo_options['headline_tag_page'];
}
if (have_posts()) : while (have_posts()) : the_post();
        ?>
        <div class="custom-container custom-container-margin-top">
            <div class="full-size">
                <?php
                if (trim($sidebar_position) === 'left') {
                    ?>
                    <div class="col3 sidebar-left" id="sidebar"><?php get_sidebar(); ?></div>
                    <?php
                    $colwidth = 9;
                } else if (trim($sidebar_position) === 'right') {
                    $colwidth = 9;
                }
                ?>

                <div class="page col<?php echo $colwidth ?>" id="content-wrapper" >
                    <?php if ($device === 'desktop') : ?>
                        <?php if (trim($affiliseo_options['ad_page_top']) != "" && isset($affiliseo_options['ad_page_top'])) : ?>
                            <div class="ad text-center">
                                <?php echo $affiliseo_options['ad_page_top']; ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if (trim($affiliseo_options['ad_page_top_mobile']) != "" && isset($affiliseo_options['ad_page_top_mobile'])) : ?>
                            <div class="mobile-ad text-center">
                                <?php echo $affiliseo_options['ad_page_top_mobile']; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="clearfix"></div>
                    <div class="box content">
                        <?php
                        get_template_part('frontpageslider');
                        if (get_field('hide_page_headline') === false || get_field('hide_page_headline')==null) :
                            if (!$hide_headline) :
                                ?>
                                <<?php echo $headline_tag_page; ?>><?php the_title(); ?></<?php echo $headline_tag_page; ?>>
                                <?php
                            endif;
                        endif;
                        $post = get_post();
                        $thumbnailUrl = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
                        if (has_post_thumbnail() || strlen($thumbnailUrl) > 3) {
                            the_custom_post_thumbnail($post, 'img_by_url_full_size', 'full', array('class' => ' img-thumbnail pull-left post-thumbnail'));
                        }
                        the_content();
                        ?>
                        <div class="full-size">
                            <?php if (trim($affiliseo_options['allg_preise_ausblenden']) !== '1') : ?>
                                <div class="col2">								
                                    <h4><?php echo __('Price','affiliatetheme'); ?></h4>
                                    <p>EUR <?php echo $min_price; ?> - EUR <?php echo $max_price; ?></p>
                                </div>
                                <?php
                            endif;
                            if ($brand != '' && $brand != 'none'):
                                $term = get_term_by('slug', $brand, 'produkt_marken');
                                $name = $term->name;
                                ?>
                                <div class="col2">								
                                    <h4><?php echo $brand_singular; ?></h4>
                                    <p><?php echo $name; ?></p>
                                </div>
                                <?php
                            endif;
                            ?>
                            <?php
                            if ($type != '' && $type != 'none'):
                                $term = get_term_by('slug', $type, 'produkt_typen');
                                $name = $term->name;
                                ?>
                                <div class="col2">								
                                    <h4><?php echo $type_singular; ?></h4>
                                    <p><?php echo $name; ?></p>
                                </div>
                                <?php
                            endif;
                            ?>
                            <?php
                            if ($tag != '' && $tag != 'none'):
                                $term = get_term_by('slug', $tag, 'produkt_tags');
                                $name = $term->name;
                                ?>
                                <div class="col2">								
                                    <h4>Tag</h4>
                                    <p><?php echo $name; ?></p>
                                </div>
                                <?php
                            endif;
                            ?>
                            <div class="col2">
                            	<?php
                            	if( !isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating']!=1 ){                           	
                            	?>
                                <h4><?php echo __('Review','affiliatetheme'); ?></h4>
                                <p>
                                    <?php
                                    for ($i = 0; $i < 5; $i++) :
                                        if (intval($stars) > $i) :
                                            ?>
                                            <i class="fa fa-star stars"></i>
                                            <?php
                                        else :
                                            ?>
                                            <i class="fa fa-star-o stars"></i>
                                        <?php
                                        endif;
                                    endfor;
                                    ?>
                                    <br />& <?php echo __('more','affiliatetheme'); ?>
                                </p>
                                <?php 
                            	}
                            	?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <?php ob_start(); ?>
                    <div class="produkte">
                        <?php
                        $args = array(
                            'post_type' => 'produkt',
                            'post_status' => 'publish',
                            'orderby' => 'meta_value_num',
                            'order' => 'ASC',
                            'meta_key' => 'preis',
                            'posts_per_page' => -1
                        );
                        if (trim($brand) !== '' && trim($brand) !== 'none') {
                            $args['produkt_marken'] = $brand;
                        }
                        if (trim($type) !== '' && trim($type) !== 'none') {
                            $args['produkt_typen'] = $type;
                        }
                        if (trim($tag) !== '' && trim($tag) !== 'none') {
                            $args['produkt_tags'] = $tag;
                        }
                        
                        // dynamische taxonomy-parameter abfragen
                        $getParamKeys = array_keys($_GET);
                        $dynamicParams = array();
                        foreach ($getParamKeys as $getParamKey){
                            
                            $getParamPrefix = substr($getParamKey, 0, 9);
                            $getParamSuffix = substr($getParamKey, 9);
                            
                            if($getParamPrefix=='dynamic__'){
                                $getParamValue = $_GET[$getParamKey];
                                if($getParamValue!="" && $getParamValue!="none"){
                                    $args[$getParamSuffix] = array($getParamValue);
                                }
                                
                                $dynamicParams[] = array($getParamKey=>$getParamValue);
                            }                            
                        }
                        
                        query_posts($args);
                        global $wp_query;
                        $results = 0;
                        $ids = array(0);

                        if (have_posts()) {
                            
                            while (have_posts()) {
                                the_post();
                                $price = strToFloat(get_field('preis'));
                                if (intval($price) >= intval($min_price) && intval($price) <= intval($max_price)) {
                                    if (intval(get_field('sterne_bewertung')) >= intval($stars)) {
                                        $results++;
                                        array_push($ids, get_the_ID());
                                    }
                                }
                            }
                        }

                        wp_reset_query();
                        
                        $posts_per_page = get_option('posts_per_page');
                        $args = array(
                            'post_type' => 'produkt',
                            'post_status' => 'publish',
                            'orderby' => 'meta_value_num',
                            'order' => 'ASC',
                            'meta_key' => 'preis',
                            'post__in' => $ids,
                            'posts_per_page' => $posts_per_page,
                            'paged' => $paged
                        );
                        if (trim($brand) !== '' && trim($brand) !== 'none') {
                            $args['produkt_marken'] = $brand;
                        }
                        if (trim($type) !== '' && trim($type) !== 'none') {
                            $args['produkt_typen'] = $type;
                        }
                        if (trim($tag) !== '' && trim($tag) !== 'none') {
                            $args['produkt_tags'] = $tag;
                        }
                        
                        query_posts($args);
                        global $wp_query;

                        if (have_posts()) :
                            while (have_posts()) : the_post();
                                get_template_part('loop', 'produkt-horizontal');
                            endwhile;
                        endif;
                        ?>
                        <div class="text-center">
                            <?php
                            affiliseo_filter_pagination($paged, $min_price, $max_price, $brand, $type, $tag, $stars,$dynamicParams);
                            ?>
                        </div>
                        <?php
                        wp_reset_query();
                        ?>
                    </div>
                    <?php
                    $echo_results = ob_get_clean();
                    ?>
                    <div class="box content">
                        <?php
                        switch ($results) {
                            case 0:
                                ?>
                                <p><?php echo __('Sorry, no products found.','affiliatetheme'); ?></p>
                                <?php
                                break;
                            case 1:
                                ?>
                                <p><?php echo __('One product found.','affiliatetheme'); ?></p>
                                <?php
                                break;
                            default:
                                ?>
                                <p><?php printf(__('%s products found.','affiliatetheme'), $results); ?></p>
                                <?php
                                break;
                        }
                        ?>
                    </div>
                    <?php echo $echo_results; ?>
                </div>
                <?php
                if (trim($sidebar_position) === 'right') :
                    ?>
                    <div class="col3 sidebar-right" id="sidebar"><?php get_sidebar(); ?></div>
                    <?php
                endif;
                ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php
    endwhile;
endif;
get_footer();
?>