<?php
/*
 * THIS CLASS ADDS MENU MODS FOR BOOTSTRAP FRAMEWORK
 */

class description_walker extends Walker_Nav_Menu {

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $affiliseo_options;

        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

        $class_names = $value = '';

        // If the item has children, add the dropdown class for bootstrap
        if ($args->has_children && $depth == 0) {
            $class_names = "dropdown ";
        }

        $classes = empty($item->classes) ? array() : (array) $item->classes;

        $use_mega_menu = $affiliseo_options['use_mega_menu'];
        $show_thumbnails_category_mega_menu = $affiliseo_options['show_thumbnails_category_mega_menu'];
        $show_thumbnails_tags_mega_menu = $affiliseo_options['show_thumbnails_tags_mega_menu'];
        $show_thumbnails_brands_mega_menu = $affiliseo_options['show_thumbnails_brands_mega_menu'];
        $show_thumbnails_types_mega_menu = $affiliseo_options['show_thumbnails_types_mega_menu'];
        $show_thumbnails_posts_mega_menu = $affiliseo_options['show_thumbnails_posts_mega_menu'];
        $show_thumbnails_pages_mega_menu = $affiliseo_options['show_thumbnails_pages_mega_menu'];
        $show_thumbnails_products_mega_menu = $affiliseo_options['show_thumbnails_products_mega_menu'];
        $show_thumbnails_stars_mega_menu = $affiliseo_options['show_thumbnails_stars_mega_menu'];

        $product_has_img = false;

        $object_id = $item->object_id;

        $class_names .= join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
        if (trim($depth) === '1' && $args->has_children) {
            $class_names .= ' dropdown-mega-menu dropleft-li';
            if (trim($use_mega_menu) === '1') {
                $class_names .= '';
            }
        } elseif (trim($depth) === '1' && !$args->has_children) {
            $class_names .= ' dropdown-mega-menu';
        }
        $class_names = ' class="' . esc_attr($class_names) . '"';

        if (apply_filters('the_title', $item->title, $item->ID) != "divider") {
            $output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';
            if (trim($use_mega_menu) === '1' && $depth != 0) {
                
                $thumbnailUrl = get_post_meta($item->ID, '_external_thumbnail_url', TRUE);
                
                $images = get_children(array('post_parent' => $item->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image'));
                $attachments = array();
                switch ($item->object) {
                    case 'category':
                        if (trim($show_thumbnails_category_mega_menu) === '1') {
                            if (trim(affiliseo_taxonomy_images_taxonomy_image_url($object_id, 'menu_small')) !== '') {
                                $output .= '<img src="' . affiliseo_taxonomy_images_taxonomy_image_url($object_id, 'menu_small') . '" width="30" height="30" class="img-div" alt="' . $item->attr_title . '">';
                            }
                        }
                        break;
                    case 'post_tag':
                        if (trim($show_thumbnails_tags_mega_menu) === '1') {
                            if (trim(affiliseo_taxonomy_images_taxonomy_image_url($object_id, 'menu_small')) !== '') {
                                $output .= '<img src="' . affiliseo_taxonomy_images_taxonomy_image_url($object_id, 'menu_small') . '" width="30" height="30" class="img-div" alt="' . $item->attr_title . '">';
                            }
                        }
                        break;
                    case 'produkt_marken':
                        if (trim($show_thumbnails_brands_mega_menu) === '1') {
                            if (trim(affiliseo_taxonomy_images_taxonomy_image_url($object_id, 'menu_small')) !== '') {
                                $output .= '<img src="' . affiliseo_taxonomy_images_taxonomy_image_url($object_id, 'menu_small') . '" width="30" height="30" class="img-div" alt="' . $item->attr_title . '">';
                            }
                        }
                        break;
                    case 'produkt_typen':
                        if (trim($show_thumbnails_types_mega_menu) === '1') {
                            if (trim(affiliseo_taxonomy_images_taxonomy_image_url($object_id, 'menu_small')) !== '') {
                                $output .= '<img src="' . affiliseo_taxonomy_images_taxonomy_image_url($object_id, 'menu_small') . '" width="30" height="30" class="img-div" alt="' . $item->attr_title . '">';
                            }
                        }
                        break;
                    case 'produkt_tags':
                        if (trim($show_thumbnails_tags_mega_menu) === '1') {
                            if (trim(affiliseo_taxonomy_images_taxonomy_image_url($object_id, 'menu_small')) !== '') {
                                $output .= '<img src="' . affiliseo_taxonomy_images_taxonomy_image_url($object_id, 'menu_small') . '" width="30" height="30" class="img-div" alt="' . $item->attr_title . '">';
                            }
                        }
                        break;
                    case 'post':
                        if (trim($show_thumbnails_posts_mega_menu) === '1') {
                            if (has_post_thumbnail($object_id) || strlen($thumbnailUrl) > 3) {
                                $output .= get_the_custom_post_thumbnail($object_id, 'img_by_url_menu_small_w30','menu_small', array('class' => ' img-div'));
                            }
                        }
                        break;
                    case 'page':
                        if (trim($show_thumbnails_pages_mega_menu) === '1') {
                            if (has_post_thumbnail($object_id) || strlen($thumbnailUrl) > 3) {
                                $output .= get_the_custom_post_thumbnail($object_id, 'img_by_url_menu_small_w30','menu_small', array('class' => ' img-div'));
                            }
                        }
                        break;
                    case 'produkt':
                        if (trim($show_thumbnails_products_mega_menu) === '1') {
                            if (has_post_thumbnail($object_id) || strlen($thumbnailUrl) > 3) {
                                $output .= get_the_custom_post_thumbnail($object_id, 'img_by_url_menu_small_w30','menu_small', array('class' => ' img-div'));
                                $product_has_img = true;
                            }
                        }
                        break;
                    default:
                        $attachments = get_posts('post_type=attachment&post_parent=' . $object_id . '&posts_per_page=-1&order=ASC');
                }
                if (trim($item->object) !== 'produkt_marken' && trim($item->object) !== 'produkt_typen') {
                    if (count($attachments !== 0)) {
                        for ($i = 0; $i < count($attachments); $i++) {
                            $id = $attachments[$i]->ID;
                            $image_attributes = wp_get_attachment_image_src($id, 'menu_small');
                            $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
                            if ($i === 0) {
                                $w = intval($image_attributes[1]);
                                $h = intval($image_attributes[2]);
                                $output .= '<img src="' . $image_attributes[0] . '" width="' . $w . '" height="' . $h . '" class="img-div" alt="' . $alt . '">';
                            }
                        }
                    }
                }
            }
        }

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        // if the item has children add these two attributes to the anchor tag
        if ($args->has_children) {
            //$attributes .= ' class="dropdown-toggle"';
            // remove data-toggle="dropdown" after class="" ...
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . ' class="dropdown-toggle ';
        if (trim($depth) === '1' && $args->has_children) {
            $item_output .= 'dropleft-a';
        }
        $item_output .= '">';
        if ($depth == 2) {
            $slug = apply_filters('the_title', $item->title, $item->ID);
            $slug = str_replace('ö', 'oe', $slug);
            $slug = str_replace('ä', 'ae', $slug);
            $slug = str_replace('ü', 'ue', $slug);
            $slug = strtolower($slug);
            $item_output .= '<i class="icon icon-' . $slug . '"></i>';
        }
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID);
        $item_output .= $args->link_after;
        // if the item has children add the caret just before closing the anchor tag
        if ($args->has_children) {
            if (trim($depth) === '1' && trim($use_mega_menu) !== '1') {
                $item_output .= ' <i class="fa fa-angle-right"></i></a> <span class="menu-caret" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-plus"></i></span>';
            } else {
                $item_output .= ' <i class="fa fa-angle-down"></i></a> <span class="menu-caret" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-plus"></i></span>';
            }
        } else {
            $item_output .= '</a>';
        }
        $item_output .= $args->after;
        if (trim($show_thumbnails_stars_mega_menu) === '1' && trim($item->object) === 'produkt' && trim($use_mega_menu) === '1') {
            if ($product_has_img) {
                if( !isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating']!=1 ){
                    $item_output .= get_product_rating($object_id,'div', 'rating-menu');
                }                
            } else {
                if( !isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating']!=1 ){
                    $item_output .= get_product_rating($object_id, '', '');
                }                
            }
        }
        $item_output .= '<div class="clearfix"></div>';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function start_lvl(&$output, $depth = 0, $args = array()) {
        global $affiliseo_options;
        $use_mega_menu = $affiliseo_options['use_mega_menu'];
        $show_product = $affiliseo_options['show_product_mega_menu'];
        $indent = str_repeat("\t", $depth);
        if ($depth < 1) {
            if (trim($use_mega_menu) === '1') {
                $output .= "\n$indent<ul class=\"dropdown-menu mega-menu depth-$depth\">\n";
                if (trim($show_product) === '1') {
                    $chosen_product_mega_menu = $affiliseo_options['chosen_product_mega_menu'];
                    if (trim($chosen_product_mega_menu) === 'random') {
                        query_posts(
                                array(
                                    'orderby' => 'rand',
                                    'post_type' => 'produkt',
                                    'showposts' => 1,
                                    'post_status' => 'publish'
                        ));
                    } else {
                        query_posts(
                                array(
                                    'post_type' => 'produkt',
                                    'post__in' => array(intval($chosen_product_mega_menu))
                        ));
                    }
                    ob_start();
                    if (have_posts()) {
                        while (have_posts()) {
                            the_post();
                            global $post;
                            global $no_price_string;
                            $ap_button_label = getApButtonLabel($post);
                            if (trim(get_theme_mod('affiliseo_buttons_ap_bg_image', '')) !== '') {
                                $ap_button_label = '';
                            }

                            $ap_cart_button_label = $affiliseo_options['ap_cart_button_label'];
                            if (!isset($affiliseo_options['ap_cart_button_label'])) {
                                $ap_cart_button_label = __('Add to cart','affiliatetheme');
                            }
                            $show_ap_cart_button = false;
                            if (trim(get_field('ap_cart_link')) !== '') {
                                $show_ap_cart_button = true;
                            }

                            $detail_button_label = get_theme_mod('affiliseo_buttons_detail_label', __('Product description','affiliatetheme').' &rsaquo;');
                            if (trim(get_theme_mod('affiliseo_buttons_detail_bg_image', '')) !== '') {
                                $detail_button_label = '';
                            }
                            $headline_product_mega_menu = $affiliseo_options['headline_product_mega_menu'];
                            ?>
                            <div class="pull-right"> 
                                <?php if (trim($headline_product_mega_menu) !== '') : ?>
                                    <div class="text-center headline-product-mega-menu">
                                        <strong><?php echo $headline_product_mega_menu; ?></strong>
                                    </div>
                                <?php endif; ?>
                                <div class="rand-product-menu text-center">
                                    <h3>
                                        <span>
                                            <a href="<?php echo get_permalink($post->ID); ?>" title="zum Produkt: <?php the_title(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </span>
                                    </h3>
                                    <a href="<?php the_permalink(); ?>" title="zum Produkt: <?php the_title(); ?>" class="related-link">
                                        <?php 
                                        the_custom_post_thumbnail($post, 'img_by_url_image_w400', 'product_small', null);
                                        ?>
                                    </a>
                                    
                                    <?php
                                    if( !isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating']!=1 ){
                                        echo get_product_rating($post->ID, "div", "rating");
                                    }
                                    ?>
                                    
                                    <?php
                                    if ($affiliseo_options['allg_preise_ausblenden'] != 1) :
                                        if (trim(get_field('preis')) === trim($no_price_string)) :
                                            ?>
                                            <p class="price"><?php echo get_field('preis'); ?></p>
                                            <?php
                                        else :
                                            global $currency_string;
                                            global $pos_currency;
                                            $price = '';
                                            if (trim($pos_currency) === 'before') {
                                                $price = $currency_string . ' ' . get_field('preis');
                                            } else {
                                                $price = get_field('preis') . ' ' . $currency_string;
                                            }
                                            global $text_tax;
                                            ?>
                                            <p class="price"><?php echo $price; ?> *<span class="mwst"><?php echo $text_tax; ?></span></p>
                                        <?php
                                        endif;
                                    endif;
                                    ?>

                                    <a href="<?php the_permalink(); ?>" class="btn btn-md btn-detail btn-block"><?php echo $detail_button_label; ?></a>
                                    <?php
                                    $go = $affiliseo_options['activate_cloaking'];
                                    if ($go === '1') :
                                        ?>
                                        <form action="<?php bloginfo('url'); ?>/go/" method="post" target="_blank">
                                            <input type="hidden" value="<?php echo get_field('ap_pdp_link'); ?>" name="affiliate_link">
                                            <input type="submit" value="<?php echo $ap_button_label; ?>" class="btn btn-p btn-md">
                                        </form>
                                        <?php
                                    else :
                                        ?>
                                        <a href="<?php echo get_field('ap_pdp_link'); ?>" class="btn btn-ap btn-block" target="_blank" rel="nofollow">
                                            <?php echo $ap_button_label ?>
                                        </a>
                                    <?php
                                    endif;
                                    if (get_field('third_link_text') != "" && get_field('third_link_url') != "") :
                                        ?>
                                        <a href="<?php echo get_field('third_link_url'); ?>" class="btn btn-block btn-default third-link" target="_blank" rel="nofollow">
                                            <?php
                                            if (trim(get_theme_mod('affiliseo_buttons_third_bg_image', '')) === '') :
                                                echo get_field('third_link_text');
                                            endif;
                                            ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php
                                    if ($affiliseo_options['allg_preise_ausblenden'] != 1) :
                                        ?>
                                        <p class="modified">
                                        	<small>
                                        		*<?php printf(__('last updated on %s at %s.','affiliatetheme'), get_the_modified_date('j.m.Y'), get_the_modified_date('G:i')); ?>
                                        	</small>
                                        </p>                                        
                                        <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    wp_reset_query();
                    $output .= ob_get_clean();
                }
            } else {
                $output .= "\n$indent<ul class=\"dropdown-menu no-mega-menu\">\n";
            }
        } else {
            $output .= "\n$indent<ul class=\"dropleft depth-$depth\">\n";
        }
    }

    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
        $id_field = $this->db_fields['id'];
        if (is_object($args[0])) {
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);
        }
        return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

}
?>