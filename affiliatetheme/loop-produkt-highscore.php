<?php
/**
 * Created by IntelliJ IDEA.
 * Date: 27.08.2014
 * Time: 13:21
 */
global $affiliseo_options;
global $post;
global $ctHighscore;
$ap_button_label = getApButtonLabel($post);
if (trim(get_theme_mod('affiliseo_buttons_ap_bg_image', '')) !== '') {
    $ap_button_label = '';
}
$detail_button_label = get_theme_mod('affiliseo_buttons_detail_label', __('Product description','affiliatetheme').' &rsaquo;');
if (trim(get_theme_mod('affiliseo_buttons_detail_bg_image', '')) !== '') {
    $detail_button_label = '';
}

$platzierung = $affiliseo_options['highscore_platzierung_ausblenden'];
$bild = $affiliseo_options['highscore_bild_ausblenden'];
$bewertung = $affiliseo_options['highscore_bewertung_ausblenden'];
$beschreibung = $affiliseo_options['highscore_beschreibung_ausblenden'];
$angebot = $affiliseo_options['highscore_angebot_ausblenden'];

global $no_price_string;
?>

<tr>
    <?php if ($platzierung == 1) : ?>
        <td>
            <strong><?php echo $ctHighscore; ?></strong>
        </td>
    <?php endif; ?>
    <?php if ($bild == 1) : ?>
        <td class="table-image">
            <?php
            if ($affiliseo_options['allg_produktbild_ap'] == "1") {
                ?>
                <a href="<?php echo get_field('ap_pdp_link'); ?>" title="zum Produkt: <?php the_title(); ?>" target="_blank"
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
    <?php endif; ?>
    <td>
        <span><a href="<?php echo get_permalink($post->ID); ?>"
                 title="zum Produkt: <?php the_title(); ?>"><?php the_title(); ?></a></span>
    </td>
    <?php if ($bewertung == 1) : ?>
        <td class="table-rating">
        	<?php
        	if( !isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating']!=1 ){
        	    echo get_product_rating($post->ID, "div", "rating");
        	}
        	?>
        </td>
    <?php endif; ?>
    <?php if ($beschreibung == 1) : ?>
        <td class="table-btn">
            <a href="<?php the_permalink(); ?>" class="btn btn-detail btn-block"><?php echo $detail_button_label; ?></a>
        </td>
    <?php endif; ?>
    <?php if ($affiliseo_options['allg_preise_ausblenden'] != 1) : ?>
        <td class="table-price">
            <?php if (get_field('preis') === $no_price_string) : ?>
                <strong><?php echo get_field('preis'); ?></strong>
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
                <strong><?php echo $price; ?> *</strong>
                <?php echo getProductUvpPrice($post->ID, $affiliseo_options); ?>
                <?php
                global $text_tax;
                ?>
                <span class="modified">
                	<small>
                		* <?php echo $text_tax; ?> | 
                		<?php printf(__('last updated on %s at %s.','affiliatetheme'), get_the_modified_date('j.m.Y'), get_the_modified_date('G:i')); ?>
                	</small>
                </span>
            <?php endif; ?>
        </td>
    <?php endif; ?>
    <?php if ($angebot == 1) : ?>	
        <td class="table-btn">
            <?php if (get_field('third_link_text') != "" && get_field('third_link_url') != ""): ?>
                <div class="container-table">
                    <a href="<?php echo get_field('third_link_url'); ?>" class="btn btn-block btn-default third-link"
                       target="_blank" rel="nofollow">
                           <?php
                           if (trim(get_theme_mod('affiliseo_buttons_third_bg_image', '')) === '') :
                               echo get_field('third_link_text');
                           endif;
                           ?>
                    </a>
                </div>
                <?php
            endif;
            $go = $affiliseo_options['activate_cloaking'];
            if ($go === '1') :
                ?>
                <form action="<?php bloginfo('url'); ?>/go/" method="post" target="_blank">
                    <input type="hidden" value="<?php echo get_field('ap_pdp_link'); ?>" name="affiliate_link">
                    <input type="submit" value="<?php echo $ap_button_label; ?>" class="btn btn-ap">
                </form>
                <?php
            else :
                ?>
                <a href="<?php echo get_field('ap_pdp_link'); ?>" class="btn btn-block btn-ap" target="_blank"
                   rel="nofollow">
                       <?php echo $ap_button_label; ?>
                </a>
            <?php endif; ?>
        </td>
    <?php endif; ?>
</tr>



