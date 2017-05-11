<?php
global $affiliseo_options;
global $post;
$ap_button_label = getApButtonLabel($post);
if (trim(get_theme_mod('affiliseo_buttons_ap_bg_image', '')) !== '') {
    $ap_button_label = '';
}
$ap_cart_button_label = $affiliseo_options['ap_cart_button_label'];
if (! isset($affiliseo_options['ap_cart_button_label'])) {
    $ap_cart_button_label = __('Add to cart', 'affiliatetheme');
}
$show_ap_cart_button = false;

if (trim(get_field('ap_cart_link')) !== '') {
    $show_ap_cart_button = true;
}
$detail_button_label = get_theme_mod('affiliseo_buttons_detail_label', __('Product description', 'affiliatetheme') . ' &rsaquo;');
if (trim(get_theme_mod('affiliseo_buttons_detail_bg_image', '')) !== '') {
    $detail_button_label = '';
}
global $show_mini;
$mini_class = '';
$container_thumb = 'move-over-thumbnail-container-150';
$thumb_class = 'mouse-over-thumbnail';
$affiliseo_border_radius = get_theme_mod('affiliseo_border_radius', '4px');
global $device;
if ($device === 'desktop') {
    if ($show_mini === "true") {
        $mini_class = 'hover-content';
        $container_thumb = '';
        $thumb_class = '';
    }
}
global $set_mini_view;
$col_width = '';
global $has_sidebar;
if ($set_mini_view === "true") {
    if ($has_sidebar === "true") {
        $col_width = 'col3';
    } else {
        $col_width = 'col2';
    }
} else {
    $col_width = 'col4';
}
global $no_price_string;

global $number_of_attributes;
?>
<div class="<?php echo $col_width; ?> products-col auto-height">

	<div class="affiliseo-carousel hidden"
		id="carousel-<?php echo $post->ID; ?>">
		<ul>
            <?php
            // first get all external images
            $externalImages = getExternalImages($post->ID);
            $externalThumbnailSrc = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
            
            if (count($externalImages) > 0) {
                foreach ($externalImages as $externalImage) {
                    $externalImageSrc = $externalImage['src'];
                    $imgSelected = '';
                    if ($externalImageSrc == $externalThumbnailSrc) {
                        $imgSelected = 'selected';
                    }
                    ?>
                    <li><img src="<?php echo $externalImageSrc; ?>"
				width="75"
				class="small-slider-product-view thumb_<?php echo $post->ID; ?> <?php echo $imgSelected; ?>"
				alt=""></li>
                    <?php
                }
            }
            
            $attachments = get_posts('post_type=attachment&post_parent=' . $post->ID . '&posts_per_page=-1&order=ASC');
            if ($attachments && count($attachments) > 1) {
                foreach ($attachments as $attachment) {
                    
                    $id = $attachment->ID;
                    $image_attributes = wp_get_attachment_image_src($id, 'thumbnail');
                    $imgThumbnailSrc = $image_attributes[0];
                    $image_attributes_compare = wp_get_attachment_image_src($id, 'full');
                    $imgFullSrc = $image_attributes_compare[0];
                    
                    $imgSelected = '';
                    if ($imgFullSrc === wp_get_attachment_url(get_post_thumbnail_id($post->ID))) {
                        $imgSelected = 'selected';
                    }
                    ?>
                                            <li><img
				src="<?php echo $imgThumbnailSrc; ?>" width="75"
				class="small-slider-product-view thumb_<?php echo $post->ID; ?> <?php echo $imgSelected; ?>"
				alt=""></li>
                                            <?php
                }
            }
            ?>
        </ul>
	</div>

	<div class="thumbnail <?php echo $mini_class; ?>"
		id="thumb-<?php echo $post->ID; ?>"
		data-radius="<?php echo $affiliseo_border_radius; ?>">
		<div class="caption">
			<h3>
				<a href="<?php echo get_permalink($post->ID); ?>"
					title="zum Produkt: <?php the_title(); ?>">
                    <?php the_title(); ?>
                </a>
			</h3>

			<div class="<?php echo $container_thumb; ?> text-center">
                <?php
                if ($affiliseo_options['allg_produktbild_ap'] == "1") {
                    ?>
                    <a href="<?php echo get_field('ap_pdp_link'); ?>"
					title="zum Produkt: <?php the_title(); ?>" target="_blank"
					rel="nofollow" class="related-link">
                        <?php
                    the_custom_post_thumbnail($post, 'img_by_url_image_w150', 'thumbnail', array(
                        'id' => 'id_' . $post->ID,
                        'class' => $thumb_class
                    ));
                    ?>
                    </a>
                    <?php
                } else {
                    ?>
                    <div class="related-link">
					<a href="<?php echo get_permalink($post->ID); ?>"
						title="zum Produkt: <?php the_title(); ?>">
                               <?php
                    the_custom_post_thumbnail($post, 'img_by_url_image_w150', 'thumbnail', array(
                        'id' => 'id_' . $post->ID,
                        'class' => $thumb_class
                    ));
                    ?>
                        </a>
				</div>
                <?php
                }
                $marken = get_the_terms($post->ID, 'produkt_marken');
                ?>
            </div>
            
            <?php
            if (! isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating'] != 1) {
                echo get_product_rating($post->ID, "div", "rating");
            }
            ?>
            
            <?php
            if ($affiliseo_options['allg_preise_ausblenden'] != 1) {
                if (get_field('preis') === $no_price_string) {
                    ?>
                    <div class="price" style="margin-bottom: 8px;">
                        <?php echo get_field('preis'); ?><br />&nbsp;
			</div>
                    <?php
                } else {
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
                    <div class="price" style="margin-bottom: 8px;">
                    	<?php echo $price; ?> *
                    	<?php echo getProductUvpPrice($post->ID, $affiliseo_options); ?>
                    	<span class="mwst"><?php echo $text_tax; ?></span>
			</div>
                <?php
                }
            } else {
                ?>
                <span style="margin-bottom: 8px;">&nbsp;</span>
                <?php
            }
            
            if ($show_mini === "false") {
                
                if ($affiliseo_options['show_additional_attributes'] == 1) {
                    ?>
                    <div class="text-center">
                        <?php
                    for ($a = 0; $a <= $number_of_attributes; $a ++) {
                        if (trim(get_field('attribute_' . $a . '_title')) != "" && trim(get_field('attribute_' . $a . '_content')) != "") {
                            ?>
                                <strong><?php echo get_field('attribute_' . $a . '_title') ?></strong><br />
                                <?php echo get_field('attribute_' . $a . '_content'); ?><br />
				<br />
                                <?php
                        }
                    }
                    ?>
                    </div>
                <?php } ?>
                <div class="buttons">
				<a href="<?php the_permalink(); ?>"
					class="btn btn-md btn-detail btn-block">
                        <?php echo $detail_button_label; ?>
                    </a>
                    <?php
                $go = $affiliseo_options['activate_cloaking'];
                if ($go === '1') {
                    ?>
                        <form action="<?php bloginfo('url'); ?>/go/"
					method="post" target="_blank">
					<input type="hidden"
						value="<?php echo get_field('ap_pdp_link'); ?>"
						name="affiliate_link"> <input type="submit"
						value="<?php echo $ap_button_label; ?>"
						class="btn btn-ap btn-md btn-block">
				</form>
                        <?php
                } else {
                    ?>
                        <a
					href="<?php echo get_field('ap_pdp_link'); ?>"
					class="btn btn-ap btn-block" target="_blank" rel="nofollow">
                            <?php echo $ap_button_label; ?>
                        </a>
                    <?php
                }
                if (trim(get_field('third_link_text')) != "" && trim(get_field('third_link_url')) != "") {
                    ?>
                        <a
					href="<?php echo get_field('third_link_url'); ?>"
					class="btn btn-block btn-default third-link" target="_blank"
					rel="nofollow">
                            <?php
                    if (trim(get_theme_mod('affiliseo_buttons_third_bg_image', '')) === '') {
                        echo get_field('third_link_text');
                    }
                    ?>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <?php
        if ($affiliseo_options['allg_preise_ausblenden'] != 1) {
            ?>
            <span class="modified"> <small>
            		* <?php printf(__('last updated on %s at %s.','affiliatetheme'), get_the_modified_date('j.m.Y'), get_the_modified_date('G:i')); ?>
                </small>
		</span>
            <?php
        }
        ?>
    </div>
    <?php if ($show_mini === "true") { ?>
        <div class="hover-container hidden"
		id="hover-<?php echo $post->ID ?>">
            <?php if (trim(get_field('excerpt_product')) !== '') { ?>
                <div class="text-center margin-bottom">
                    <?php echo do_shortcode(get_field('excerpt_product')); ?>
                </div>
            <?php } ?>
            <div class="buttons">
			<a href="<?php the_permalink(); ?>" class="btn btn-detail btn-block">
                    <?php echo $detail_button_label; ?>
                </a>
                <?php
        $go = $affiliseo_options['activate_cloaking'];
        if ($go === '1') {
            ?>
                    <form action="<?php bloginfo('url'); ?>/go/"
				method="post" target="_blank" class="text-center">
				<input type="hidden" value="<?php echo get_field('ap_pdp_link'); ?>"
					name="affiliate_link"> <input type="submit"
					value="<?php echo $ap_button_label; ?>"
					class="btn btn-ap btn-md btn-block">
			</form>
                    <?php
        } else {
            ?>
                    <a href="<?php echo get_field('ap_pdp_link'); ?>"
				class="btn btn-ap btn-block" target="_blank" rel="nofollow">
                        <?php echo $ap_button_label; ?>
                    </a>
                <?php
        }
        if (trim(get_field('third_link_text')) != "" && trim(get_field('third_link_url')) != "") {
            ?>
                    <a href="<?php echo get_field('third_link_url'); ?>"
				class="btn btn-block btn-default third-link" target="_blank"
				rel="nofollow">
                        <?php
            if (trim(get_theme_mod('affiliseo_buttons_third_bg_image', '')) === '') {
                echo get_field('third_link_text');
            }
            ?>
                    </a>
                <?php } ?>
            </div>
	</div>
    <?php } ?>
</div>