<?php
global $affiliseo_options;
global $post;
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
global $countCols;
global $no_price_string;
?>
<div class="col3 related-col3 col-nr-<?php echo $countCols; ?> auto-height">
    <div class="thumbnail" id="thumb-<?php echo $post->ID; ?>" data-type="related">
        <div class="caption">
            <?php $marken = get_the_terms($post->ID, 'produkt_marken'); ?>
            <h3>
                <span>
                    <a href="<?php echo get_permalink($post->ID); ?>" title="zum Produkt: <?php the_title(); ?>">
                        <?php the_title(); ?>
                    </a>
                </span>
            </h3>

            <div class="move-over-thumbnail-container-175 text-center">
                <a href="<?php the_permalink(); ?>" title="zum Produkt: <?php the_title(); ?>" class="related-link">
                    <?php 
                    the_custom_post_thumbnail($post, 'img_by_url_product_small_w175', 'product_small', array('class' => 'mouse-over-thumbnail'));
                    ?>
                </a>
            </div>
            
            <?php
            if( !isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating']!=1 ){
                echo get_product_rating($post->ID, "div", "rating");
            }
            ?>

            <?php
            if ($affiliseo_options['allg_preise_ausblenden'] != 1) {
                if (trim(get_field('preis')) === trim($no_price_string)) :
                    ?>
                    <div class="price"><?php echo get_field('preis'); ?><span class="mwst">&nbsp;</span></div>
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
                    <div class="price">
                    	<?php echo $price; ?> *
                    	<?php echo getProductUvpPrice($post->ID, $affiliseo_options); ?>
                    	<span class="mwst"><?php echo $text_tax; ?></span>
                    </div>
                <?php
                endif;
            } else {
                ?>
            <?php } ?>

        </div>

        <a href="<?php the_permalink(); ?>" class="btn btn-md btn-detail btn-block"><?php echo $detail_button_label; ?></a>
        <?php
        $go = $affiliseo_options['activate_cloaking'];
        if ($go === '1') :
            ?>
            <form action="<?php bloginfo('url'); ?>/go/" method="post" target="_blank">
                <input type="hidden" value="<?php echo get_field('ap_pdp_link'); ?>" name="affiliate_link">
                <input type="submit" value="<?php echo $ap_button_label; ?>" class="btn btn-ap btn-md btn-input btn-block">
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
            <span class="modified">
            	<small>
            		* <?php printf(__('last updated on %s at %s.','affiliatetheme'), get_the_modified_date('j.m.Y'), get_the_modified_date('G:i')); ?>
            	</small>
            </span>
            <?php
        endif;
        ?>
    </div>
</div>