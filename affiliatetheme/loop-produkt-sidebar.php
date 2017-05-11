<?php
global $affiliseo_options;
global $post;
$ap_button_label = getApButtonLabel($post);
if (trim(get_theme_mod('affiliseo_buttons_ap_bg_image', '')) !== '') {
    $ap_button_label = '';
}
$detail_button_label = get_theme_mod('affiliseo_buttons_detail_label', __('Product description', 'affiliatetheme') . ' &rsaquo;');
if (trim(get_theme_mod('affiliseo_buttons_detail_bg_image', '')) !== '') {
    $detail_button_label = '';
}
global $image_in_recommendation_widget;
global $no_price_string;
global $number_of_attributes;
?>
<div>
	<div class="thumbnail">
		<div class="caption">
			<h3>
				<span><a href="<?php echo get_permalink($post->ID); ?>"
					title="zum Produkt: <?php the_title(); ?>"><?php the_title(); ?></a></span>
			</h3>

            <?php
            if (trim($image_in_recommendation_widget) !== 'on') {
                ?>
                <div
				class="move-over-thumbnail-container-175 text-center">
                    <?php
                if ($affiliseo_options['allg_produktbild_ap'] == "1") {
                    ?>
                        <a
					href="<?php echo get_field('ap_pdp_link'); ?>"
					title="zum Produkt: <?php the_title(); ?>" target="_blank"
					rel="nofollow">
                            <?php
                    the_custom_post_thumbnail($post, 'img_by_url_product_small_w175', 'product_small', array(
                        'class' => 'mouse-over-thumbnail'
                    ));
                    ?>
                        </a>
                        <?php
                } else {
                    ?>
                        <a
					href="<?php echo get_permalink($post->ID); ?>"
					title="zum Produkt: <?php the_title(); ?>">
                               <?php
                    the_custom_post_thumbnail($post, 'img_by_url_product_small_w175', 'product_small', array(
                        'class' => 'mouse-over-thumbnail'
                    ));
                    ?>
                        </a>
                    <?php
                }
                ?>
                </div>
                <?php
            }
            ?>

            <?php $marken = get_the_terms($post->ID, 'produkt_marken'); ?>

            <?php
            if (! isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating'] != 1) {
                echo get_product_rating($post->ID, "div", "rating");
            }
            ?>
            
            <?php
            if ($affiliseo_options['allg_preise_ausblenden'] != 1) {
                if (get_field('preis') === $no_price_string) {
                    ?>
                    <div class="price" style="margin-bottom: 8px;"><?php echo get_field('preis'); ?></div>
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
            if ($affiliseo_options['show_additional_attributes'] == 1) {
                for ($a = 0; $a <= $number_of_attributes; $a ++) {
                    if (trim(get_field('attribute_' . $a . '_title')) != "" && trim(get_field('attribute_' . $a . '_content')) != "") {
                        ?>
                        <p class="mini">
				<strong><?php echo get_field('attribute_' . $a . '_title'); ?></strong>
				<br /><?php echo get_field('attribute_' . $a . '_content'); ?></p>
                        <?php
                    }
                }
            }
            ?>
            <a href="<?php the_permalink(); ?>"
				class="btn btn-md btn-detail btn-block"><?php echo $detail_button_label; ?></a>
            <?php
            $go = $affiliseo_options['activate_cloaking'];
            if ($go === '1') {
                ?>
                <form action="<?php bloginfo('url'); ?>/go/"
				method="post" target="_blank">
				<input type="hidden" value="<?php echo get_field('ap_pdp_link'); ?>"
					name="affiliate_link"> <input type="submit"
					value="<?php echo $ap_button_label; ?>" class="btn btn-ap btn-md">
			</form>
                <?php
            } else {
                ?>
                <a href="<?php echo get_field('ap_pdp_link'); ?>"
				class="btn btn-ap btn-block" target="_blank" rel="nofollow"><?php echo $ap_button_label; ?></a>
            <?php
            }
            if (get_field('third_link_text') != "" && get_field('third_link_url') != "") {
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
</div>