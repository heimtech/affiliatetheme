<?php
global $affiliseo_options, $post, $ctHighscore, $no_price_string, $currency_string, $pos_currency, $text_tax;
$apButtonLabel = getApButtonLabel($post);
if (trim(get_theme_mod('affiliseo_buttons_ap_bg_image', '')) !== '') {
    $apButtonLabel = '';
}
$detailButtonLabel = get_theme_mod('affiliseo_buttons_detail_label', __('Product description', 'affiliatetheme') . ' &rsaquo;');
if (trim(get_theme_mod('affiliseo_buttons_detail_bg_image', '')) !== '') {
    $detailButtonLabel = '';
}

?>

<tr>
    <?php if (isOptionEnabled('highscore_platzierung_ausblenden')) { ?>
        <td><strong><?php echo $ctHighscore; ?></strong></td>
    <?php
    }
    
    if ( isOptionEnabled('highscore_bild_ausblenden')) {
        ?>
        <td class="table-image">
            <?php
        if (isOptionEnabled('allg_produktbild_ap')) {
            ?>
                <a href="<?php echo get_field('ap_pdp_link'); ?>"
		title="zum Produkt: <?php the_title(); ?>" target="_blank"
		rel="nofollow">
                       <?php
            the_custom_post_thumbnail($post, 'img_by_url_product_highscore_w60', 'product_highscore', null);
            ?>
                </a>
                <?php
        } else {
            ?>
                <a href="<?php echo get_permalink($post->ID); ?>"
		title="zum Produkt: <?php the_title(); ?>">
                       <?php
            the_custom_post_thumbnail($post, 'img_by_url_product_highscore_w60', 'product_highscore', null);
            ?>
                </a>
            <?php } ?>
        </td>
    <?php } ?>
    <td><span><a href="<?php echo get_permalink($post->ID); ?>"
			title="zum Produkt: <?php the_title(); ?>"><?php the_title(); ?></a></span>
	</td>
    <?php if (isOptionEnabled('highscore_bewertung_ausblenden')) { ?>
        <td class="table-rating">
        	<?php
        if (! isOptionEnabled('hide_star_rating', true)) {
            echo get_product_rating($post->ID, "div", "rating");
        }
        ?>
        </td>
    <?php
    }
    
    if ( isOptionEnabled('highscore_beschreibung_ausblenden')) {
        ?>
        <td class="table-btn"><a href="<?php the_permalink(); ?>"
		class="btn btn-detail btn-block"><?php echo $detailButtonLabel; ?></a>
	</td>
    <?php
    }
    
    if (! isOptionEnabled('allg_preise_ausblenden', true)) {
        ?>
        <td class="table-price">
            <?php if (get_field('preis') === $no_price_string) { ?>
                <strong><?php echo get_field('preis'); ?></strong>
                <?php
        } else {
            
            if (trim($pos_currency) === 'before') {
                $price = $currency_string . ' ' . get_field('preis');
            } else {
                $price = get_field('preis') . ' ' . $currency_string;
            }
            
            ?>
                <strong><?php echo $price; ?> *</strong>
                <?php echo getProductUvpPrice($post->ID, $affiliseo_options); ?>
                <span class="modified"> <small>
                		* <?php echo $text_tax; ?> | 
                		<?php printf(__('last updated on %s at %s.','affiliatetheme'), get_the_modified_date('j.m.Y'), get_the_modified_date('G:i')); ?>
                	</small>
	</span>
            <?php } ?>
        </td>
    <?php
    }
    
    if (isOptionEnabled('highscore_angebot_ausblenden')) {
        ?>	
        <td class="table-btn">
            <?php if (get_field('third_link_text') != "" && get_field('third_link_url') != ""){ ?>
                <div class="container-table">
			<a href="<?php echo get_field('third_link_url'); ?>"
				class="btn btn-block btn-default third-link" target="_blank"
				rel="nofollow">
                           <?php
            if (trim(get_theme_mod('affiliseo_buttons_third_bg_image', '')) === '') {
                echo get_field('third_link_text');
            }
            ?>
                    </a>
		</div>
                <?php
        }
        
        if (isOptionEnabled('activate_cloaking')) {
            ?>
                <form action="<?php bloginfo('url'); ?>/go/"
			method="post" target="_blank">
			<input type="hidden" value="<?php echo get_field('ap_pdp_link'); ?>"
				name="affiliate_link"> <input type="submit"
				value="<?php echo $apButtonLabel; ?>" class="btn btn-ap">
		</form>
                <?php
        } else {
            ?>
                <a href="<?php echo get_field('ap_pdp_link'); ?>"
		class="btn btn-block btn-ap" target="_blank" rel="nofollow">
                       <?php echo $apButtonLabel; ?>
                </a>
            <?php } ?>
        </td>
    <?php } ?>
</tr>



