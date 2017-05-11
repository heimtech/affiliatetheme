<?php
global $affiliseo_options, $currency_string, $pos_currency, $text_tax, $no_price_string;

$attr_names = array(
    $affiliseo_options['comparison_first_attribute_name'],
    $affiliseo_options['comparison_second_attribute_name'],
    $affiliseo_options['comparison_third_attribute_name'],
    $affiliseo_options['comparison_fourth_attribute_name'],
    $affiliseo_options['comparison_fifth_attribute_name']
);

$attr_contents = array(
    get_field('field_first_attr_checklist'),
    get_field('field_second_attr_checklist'),
    get_field('field_third_attr_checklist'),
    get_field('field_fourth_attr_checklist'),
    get_field('field_fifth_attr_checklist')
);

$apButtonLabel = getApButtonLabel($post);
if (trim(get_theme_mod('affiliseo_buttons_ap_bg_image', '')) !== '') {
    $apButtonLabel = '';
}

$detailButtonLabel = get_theme_mod('affiliseo_buttons_detail_label', __('Product description', 'affiliatetheme') . ' &rsaquo;');
if (trim(get_theme_mod('affiliseo_buttons_detail_bg_image', '')) !== '') {
    $detailButtonLabel = '';
}

$ribbon = '';
switch ($affiliseo_options['comparison_highlight']) {
    case 'Rahmen':
        $trClass = 'border-highlight';
        break;
    case 'Hintergrundfarbe':
        $trClass = 'background-highlight';
        break;
    default:
        $trClass = '';
        $ribbon = 'true';
}
$isHighlight = get_field('field_highlight');

if ($isHighlight == '1') {
    $trClass .= ' is-highlight';
} else {
    $trClass = '';
}

echo '<tr class="' . $trClass . '">';

echo '<td class="text-center checklist-pic">';

if ($isHighlight == '1' && $ribbon === 'true') {
    
    echo '<div class="ribbon-wrapper-green"><div class="ribbon-green">TIPP</div></div>';
}

echo '<span> ';
echo '<a href="' . get_permalink($post->ID) . '" title="zum Produkt: ' . get_the_title() . '">';
echo get_the_title();
echo '</a>';
echo '</span>';

echo '<br class="no-wpautop" />';

if (isOptionEnabled('allg_produktbild_ap')) {
    
    if (isOptionEnabled('activate_cloaking')) {
        
        echo '<form action="' . bloginfo('url') . '/go/" method="post" target="_blank">';
        echo '<input type="hidden" value="' . get_field('ap_pdp_link') . '" name="affiliate_link">';
        echo '<input type="submit" value="' . $apButtonLabel . '" class="btn btn-ap">';
        echo '</form>';
    } else {
        
        echo '<a href="' . get_field('ap_pdp_link') . '" title="zum Produkt: ' . get_the_title() . '" target="_blank" rel="nofollow">';
        
        the_custom_post_thumbnail($post, 'img_by_url_product_highscore_w60', 'product_highscore', null);
        
        echo '</a>';
    }
} else {
    echo '<a href="' . get_permalink($post->ID) . '" title="zum Produkt: ' . get_the_title() . '">';
    
    the_custom_post_thumbnail($post, 'img_by_url_product_highscore_w60', 'product_highscore', null);
    
    echo '</a>';
}

echo '</td>';

for ($i = 0; $i < count($attr_names); $i ++) {
    
    if (trim($attr_names[$i]) !== '') {
        
        echo '<td class="text-center">';
        echo '<strong class="show-checklist-headline">' . $attr_names[$i] . '</strong>';
        
        if (trim($attr_contents[$i]) === '1') {
            
            echo '<div class="text-center"><i class="fa icon-class fa-check fa-2x green"></i></div>';
        } elseif (trim($attr_contents[$i]) === '') {
            
            echo '<div class="text-center"><i class="fa icon-class fa-remove fa-2x red"></i></div>';
        } else {
            
            echo '<div class="text-left"> ' . $attr_contents[$i] . '</div>';
        }
        
        echo '</td>';
    }
}
if (! isOptionEnabled('allg_preise_ausblenden', true)) {
    
    echo '<td class="table-price">';
    
    if (get_field('preis') === $no_price_string) {
        
        echo '<strong>' . get_field('preis') . '</strong>';
    } else {
        
        if (trim($pos_currency) === 'before') {
            $price = $currency_string . ' ' . get_field('preis');
        } else {
            $price = get_field('preis') . ' ' . $currency_string;
        }
        
        echo '<strong>' . $price . '*</strong>';
        
        echo getProductUvpPrice($post->ID, $affiliseo_options);
        
        echo '<span class="modified"> <small>';
        
        echo '* ' . $text_tax . ' |';
        
        printf(__('last updated on %s at %s.', 'affiliatetheme'), get_the_modified_date('j.m.Y'), get_the_modified_date('G:i'));
        
        echo '</small>';
        echo '</span>';
    }
    
    echo '</td>';
}
if (isOptionEnabled('comparison_show_product_button') || isOptionEnabled('comparison_show_ap_button') || isOptionEnabled('comparison_show_third_button')) {
    
    echo '<td class="text-center buttons-checklist">';
    echo '<div class="buttons ">';
    
    if (trim(get_field('third_link_text')) != "" && trim(get_field('third_link_url')) != "" && isOptionEnabled('comparison_show_third_button')) {
        
        echo '<a href="' . get_field('third_link_url') . '" class="btn btn-block btn-default third-link" target="_blank" rel="nofollow">';
        
        if (trim(get_theme_mod('affiliseo_buttons_third_bg_image', '')) === '') {
            echo get_field('third_link_text');
        }
        
        echo '</a>';
    }
    
    if (isOptionEnabled('comparison_show_ap_button')) {
        
        if (isOptionEnabled('activate_cloaking')) {
            
            echo '<form action="' . bloginfo('url') . '/go/" method="post" target="_blank">';
            echo '<input type="hidden" value="' . get_field('ap_pdp_link') . '" name="affiliate_link">';
            echo '<input type="submit" value="' . $apButtonLabel . '" class="btn btn-ap btn-block">';
            echo '</form>';
        } else {
            echo '<a href="' . get_field('ap_pdp_link') . '" class="btn btn-ap btn-block" target="_blank" rel="nofollow">' . $apButtonLabel . '</a>';
        }
    }
    if (isOptionEnabled('comparison_show_product_button')) {
        echo '<a href="' . get_the_permalink() . '" class="btn btn-checklist btn-detail btn-block">' . $detailButtonLabel . '</a>';
    }
    echo '</div>';
    echo '</td>';
}

echo '</tr>';
    