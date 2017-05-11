<?php
global $affiliseo_options;

$first_attr_checklist_name = $affiliseo_options['comparison_first_attribute_name'];
$first_attr_checklist_content = get_field('field_first_attr_checklist');

$second_attr_checklist_name = $affiliseo_options['comparison_second_attribute_name'];
$second_attr_checklist_content = get_field('field_second_attr_checklist');

$third_attr_checklist_name = $affiliseo_options['comparison_third_attribute_name'];
$third_attr_checklist_content = get_field('field_third_attr_checklist');

$fourth_attr_checklist_name = $affiliseo_options['comparison_fourth_attribute_name'];
$fourth_attr_checklist_content = get_field('field_fourth_attr_checklist');

$fifth_attr_checklist_name = $affiliseo_options['comparison_fifth_attribute_name'];
$fifth_attr_checklist_content = get_field('field_fifth_attr_checklist');

$attr_names = array($first_attr_checklist_name, $second_attr_checklist_name, $third_attr_checklist_name, $fourth_attr_checklist_name, $fifth_attr_checklist_name);
$attr_contents = array($first_attr_checklist_content, $second_attr_checklist_content, $third_attr_checklist_content, $fourth_attr_checklist_content, $fifth_attr_checklist_content);

$ap_button_label = getApButtonLabel($post);
if (trim(get_theme_mod('affiliseo_buttons_ap_bg_image', '')) !== '') {
    $ap_button_label = '';
}
$detail_button_label = get_theme_mod('affiliseo_buttons_detail_label', __('Product description','affiliatetheme').' &rsaquo;');
if (trim(get_theme_mod('affiliseo_buttons_detail_bg_image', '')) !== '') {
    $detail_button_label = '';
}

$highlight = $affiliseo_options['comparison_highlight'];
$ribbon = '';
switch ($highlight) {
    case 'Rahmen':
        $tr_class = 'border-highlight';
        break;
    case 'Hintergrundfarbe':
        $tr_class = 'background-highlight';
        break;
    default:
        $ribbon = 'true';
}
$is_highlight = get_field('field_highlight');

global $no_price_string;
?>

<?php
if ($is_highlight == '1') {
    echo '<tr class="' . $tr_class . ' is-highlight">';
} else {
    echo '<tr>';
}
?>
<td class="text-center checklist-pic">
    <?php if ($is_highlight == '1' && $ribbon === 'true') : ?>
        <div class="ribbon-wrapper-green"><div class="ribbon-green">TIPP</div></div>
    <?php endif; ?>
    <span>
        <a href="<?php echo get_permalink($post->ID); ?>"
           title="zum Produkt: <?php the_title(); ?>">
               <?php the_title(); ?>
        </a>
    </span>
    <br class="no-wpautop" />
    <?php
    if ($affiliseo_options['allg_produktbild_ap'] == "1") {
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
            <a href="<?php echo get_field('ap_pdp_link'); ?>" title="zum Produkt: <?php the_title(); ?>" target="_blank"
               rel="nofollow">
                   <?php 
                   the_custom_post_thumbnail($post, 'img_by_url_product_highscore_w60', 'product_highscore', null);
                   ?>
            </a>
        <?php
        endif;
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

<?php for ($i = 0; $i < count($attr_names); $i++) : ?>
    <?php if (trim($attr_names[$i]) !== '') : ?>
        <td class="text-center">
            <strong class="show-checklist-headline"><?php echo $attr_names[$i]; ?></strong>
            <?php if (trim($attr_contents[$i]) === '1') : ?>
                <div class="text-center"><i class="fa icon-class fa-check fa-2x green"></i></div>
            <?php elseif (trim($attr_contents[$i]) === '') : ?>
                <div class="text-center"><i class="fa icon-class fa-remove fa-2x red"></i></div>
            <?php else :
                ?>
                <div class="text-left"> <?php echo $attr_contents[$i]; ?></div>
            <?php endif;
            ?>
        </td>
    <?php endif; ?>
<?php endfor; ?>
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
<?php if (trim($affiliseo_options['comparison_show_product_button']) != '' || trim($affiliseo_options['comparison_show_ap_button']) != '' || trim($affiliseo_options['comparison_show_third_button']) != '') : ?>
    <td class="text-center buttons-checklist">
        <div class="buttons ">
            <?php if (trim(get_field('third_link_text')) != "" && trim(get_field('third_link_url')) != "" && trim($affiliseo_options['comparison_show_third_button']) == '1') : ?>
                <a href="<?php echo get_field('third_link_url'); ?>" class="btn btn-block btn-default third-link" target="_blank" rel="nofollow">
                    <?php
                    if (trim(get_theme_mod('affiliseo_buttons_third_bg_image', '')) === '') :
                        echo get_field('third_link_text');
                    endif;
                    ?>
                </a>
            <?php endif; ?>
            <?php
            if (trim($affiliseo_options['comparison_show_ap_button']) == '1') :
                $go = $affiliseo_options['activate_cloaking'];
                if ($go === '1') :
                    ?>
                    <form action="<?php bloginfo('url'); ?>/go/" method="post" target="_blank">
                        <input type="hidden" value="<?php echo get_field('ap_pdp_link'); ?>" name="affiliate_link">
                        <input type="submit" value="<?php echo $ap_button_label; ?>" class="btn btn-ap btn-block">
                    </form>
                    <?php
                else :
                    ?>
                    <a href="<?php echo get_field('ap_pdp_link'); ?>" class="btn btn-ap btn-block" target="_blank" rel="nofollow"><?php echo $ap_button_label; ?></a>
                <?php
                endif;
            endif;
            ?>
            <?php if (trim($affiliseo_options['comparison_show_product_button']) == '1') : ?>
                <a href="<?php the_permalink(); ?>" class="btn btn-checklist btn-detail btn-block"><?php echo $detail_button_label; ?></a>
            <?php endif; ?>
        </div>
    </td>
<?php endif; ?>
</tr>