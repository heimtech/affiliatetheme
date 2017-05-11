<?php
global $affiliseo_options, $post, $show_mini, $device, $has_sidebar, $no_price_string, $number_of_attributes, $currency_string, $pos_currency, $text_tax, $psUniqueId, $colClass, $colCount, $sameColCount;

$headerDataAttr = 'header-' . $psUniqueId . '-' . $colCount . '-' . $sameColCount;
$thumbDataAttr = 'thumb-' . $psUniqueId . '-' . $colCount . '-' . $sameColCount;
$captionDataAttr = 'caption-' . $psUniqueId . '-' . $colCount . '-' . $sameColCount;

// sleep(1);
$apButtonLabel = getApButtonLabel($post);
if (trim(get_theme_mod('affiliseo_buttons_ap_bg_image', '')) !== '') {
    $apButtonLabel = '';
}
$apCartButtonLabel = $affiliseo_options['ap_cart_button_label'];
if (! isset($affiliseo_options['ap_cart_button_label'])) {
    $apCartButtonLabel = __('Add to cart', 'affiliatetheme');
}
$showApCartButton = false;

if (trim(get_field('ap_cart_link')) !== '') {
    $showApCartButton = true;
}
$detailButtonLabel = get_theme_mod('affiliseo_buttons_detail_label', __('Product description', 'affiliatetheme') . ' &rsaquo;');
if (trim(get_theme_mod('affiliseo_buttons_detail_bg_image', '')) !== '') {
    $detailButtonLabel = '';
}

$mini_class = '';
$containerThumb = 'move-over-thumbnail-container-150';
$thumbClass = 'mouse-over-thumbnail';
$affiliseoBorderRadius = get_theme_mod('affiliseo_border_radius', '4px');

if ($device === 'desktop') {
    if ($show_mini === "true") {
        $mini_class = 'hover-content';
        $containerThumb = '';
        $thumbClass = '';
    }
}

echo '<div class="  ' . $colClass . ' products-col">';

$liElems = '';
// first get all external images
$externalImages = getExternalImages($post->ID);
$externalThumbnailSrc = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);

$imagesCount = 0;

if (count($externalImages) > 0) {
    foreach ($externalImages as $externalImage) {
        $imagesCount ++;
        $externalImageSrc = $externalImage['src'];
        $imgSelected = '';
        if ($externalImageSrc == $externalThumbnailSrc) {
            $imgSelected = 'selected';
        }
        
        $liElems .= '<li><img src="' . $externalImageSrc . '" width="75"
				class="small-slider-product-view thumb_' . $post->ID . $psUniqueId . ' ' . $imgSelected . '" /></li>';
    }
}

$attachments = get_posts('post_type=attachment&post_parent=' . $post->ID . '&posts_per_page=-1&order=ASC');
if ($attachments && count($attachments) > 1) {
    foreach ($attachments as $attachment) {
        $imagesCount ++;
        
        $id = $attachment->ID;
        $image_attributes = wp_get_attachment_image_src($id, 'thumbnail');
        $imgThumbnailSrc = $image_attributes[0];
        $image_attributes_compare = wp_get_attachment_image_src($id, 'full');
        $imgFullSrc = $image_attributes_compare[0];
        
        $imgSelected = '';
        if ($imgFullSrc === wp_get_attachment_url(get_post_thumbnail_id($post->ID))) {
            $imgSelected = 'selected';
        }
        
        $liElems .= '<li><img src="' . $imgThumbnailSrc . '" width="75"
				class="small-slider-product-view thumb_' . $post->ID . $psUniqueId . ' ' . $imgSelected . '" /></li>';
    }
}

// start - carousel
echo '<div class="affiliseo-carousel hidden" id="carousel-' . $post->ID . $psUniqueId . '">';
if (strlen($liElems) > 10 && $imagesCount > 1) {
    
    echo '<ul>' . $liElems . '</ul>';
} else {
    echo '<ul></ul>';
}
echo '</div>';
// end - carousel

echo '<div class="thumbnail ' . $mini_class . ' product-thumbs ' . $thumbDataAttr . '"  data-thumbs="' . $thumbDataAttr . '" id="thumb-' . $post->ID . $psUniqueId . '" data-radius="' . $affiliseoBorderRadius . '">';
echo '<div class="caption product-captions ' . $captionDataAttr . '"  data-captions="' . $captionDataAttr . '" id="caption-' . $post->ID . $psUniqueId . '"">';

echo '<h3 class="product-headers ' . $headerDataAttr . '" data-headers="' . $headerDataAttr . '"><a href="' . get_permalink($post->ID) . '" title="zum Produkt: ' . get_the_title() . '">' . get_the_title() . '</a></h3>';

// start - thumb container
echo '<div class="' . $containerThumb . ' text-center">';

if (isOptionEnabled('allg_produktbild_ap')) {
    
    echo '<a href="' . get_field('ap_pdp_link') . '"' . ' title="zum Produkt: ' . get_the_title() . '"' . ' target="_blank"' . ' rel="nofollow" ' . ' class="related-link">';
    
    the_custom_post_thumbnail($post, 'img_by_url_image_w150', 'thumbnail', array(
        'id' => 'id_' . $post->ID . $psUniqueId,
        'class' => $thumbClass
    ));
    
    echo '</a>';
} else {
    
    echo '<div class="related-link">';
    echo '<a href="' . get_permalink($post->ID) . '" title="zum Produkt: ' . get_the_title() . '">';
    the_custom_post_thumbnail($post, 'img_by_url_image_w150', 'thumbnail', array(
        'id' => 'id_' . $post->ID . $psUniqueId,
        'class' => $thumbClass
    ));
    
    echo '</a>';
    echo '</div>';
}

echo '</div>';
// end - thumb container

if (! isOptionEnabled('hide_star_rating', true)) {
    echo get_product_rating($post->ID, "div", "rating");
}

if (! isOptionEnabled('allg_preise_ausblenden', true)) {
    if (get_field('preis') === $no_price_string) {
        
        echo '<div class="price" style="margin-bottom: 8px;">' . get_field('preis') . '<br /><span class="mwst">&nbsp;</span></div>';
    } else {
        
        $price = '';
        if (trim($pos_currency) === 'before') {
            $price = $currency_string . ' ' . get_field('preis');
        } else {
            $price = get_field('preis') . ' ' . $currency_string;
        }
        
        echo '<div class="price" style="margin-bottom: 8px;">';
        echo $price . '*';
        
        if (isOptionEnabled('show_uvp') && $colCount == 6) {
            echo '<br class="nowpautop" />';
        }
        
        echo getProductUvpPrice($post->ID, $affiliseo_options);
        
        echo '<span class="mwst">'.$text_tax.'</span>';
        echo '</div>';
    }
} else {
    
    echo '<span style="margin-bottom: 8px;">&nbsp;</span>';
}

if ($show_mini === "false") {
    
    if (isOptionEnabled('show_additional_attributes')) {
        
        echo '<div class="text-center">';
        
        for ($a = 0; $a <= $number_of_attributes; $a ++) {
            if (trim(get_field('attribute_' . $a . '_title')) != "" && trim(get_field('attribute_' . $a . '_content')) != "") {
                
                echo '<strong>' . get_field('attribute_' . $a . '_title') . '</strong>';
                
                echo '<br class="nowpautop" />';
                
                echo get_field('attribute_' . $a . '_content');
                echo '<br class="nowpautop" />';
                echo '<br class="nowpautop" />';
            }
        }
        
        echo '</div>';
    }
    
    // start - buttons
    echo '<div class="buttons">';
    
    echo '<a href="' . get_the_permalink() . '" class="btn btn-md btn-detail btn-block">' . $detailButtonLabel . '</a>';
    
    if (isOptionEnabled('activate_cloaking')) {
        
        echo '<form action="' . get_bloginfo('url') . '/go/" method="post" target="_blank">';
        echo '<input type="hidden" value="' . get_field('ap_pdp_link') . '" name="affiliate_link" />';
        echo '<input type="submit" value="' . $apButtonLabel . '" class="btn btn-ap btn-md btn-block" />';
        echo '</form>';
    } else {
        
        echo '<a href="' . get_field('ap_pdp_link') . '" class="btn btn-ap btn-block" target="_blank" rel="nofollow">' . $apButtonLabel . '</a>';
    }
    
    if (trim(get_field('third_link_text')) != "" && trim(get_field('third_link_url')) != "") {
        
        echo '<a href="' . get_field('third_link_url') . '" class="btn btn-block btn-default third-link" target="_blank" rel="nofollow">';
        
        if (trim(get_theme_mod('affiliseo_buttons_third_bg_image', '')) === '') {
            echo get_field('third_link_text');
        }
        
        echo '</a>';
    }
    
    echo '</div>';
    // end - buttons
}

if (! isOptionEnabled('allg_preise_ausblenden', true)) {
    
    echo '<span class="modified">';
    echo '<small> *';
    
    printf(__('last updated on %s at %s.', 'affiliatetheme'), get_the_modified_date('j.m.Y'), get_the_modified_date('G:i'));
    
    echo '</small>';
    echo '</span>';
}

if ($show_mini === "true") {
    
    // start -hidden container
    echo '<div class="hover-container hidden" id="hover-' . $post->ID . $psUniqueId . '">';
    
    if (trim(get_field('excerpt_product')) !== '') {
        
        echo '<div class="text-center margin-bottom">' . do_shortcode(get_field('excerpt_product')) . '</div>';
    }
    
    // start - buttons
    echo '<div class="buttons">';
    echo '<a href="' . get_the_permalink() . '" class="btn btn-detail btn-block">' . $detailButtonLabel . '</a>';
    
    if (isOptionEnabled('activate_cloaking')) {
        
        echo '<form action="' . get_bloginfo('url') . '/go/" method="post" target="_blank">';
        echo '<input type="hidden" value="' . get_field('ap_pdp_link') . '" name="affiliate_link" />';
        echo '<input type="submit" value="' . $apButtonLabel . '" class="btn btn-ap btn-md btn-block" />';
        echo '</form>';
    } else {
        
        echo '<a href="' . get_field('ap_pdp_link') . '" class="btn btn-ap btn-block" target="_blank" rel="nofollow">';
        echo $apButtonLabel;
        echo '</a>';
    }
    
    if (trim(get_field('third_link_text')) != "" && trim(get_field('third_link_url')) != "") {
        
        echo '<a href="' . get_field('third_link_url') . '" class="btn btn-block btn-default third-link" target="_blank" rel="nofollow">';
        
        if (trim(get_theme_mod('affiliseo_buttons_third_bg_image', '')) === '') {
            echo get_field('third_link_text');
        }
        echo '</a>';
    }
    echo '</div><div class="clearfix"></div>';
    // end - buttons
    
    echo '</div>';
    // end -hidden container
}
echo '</div>';
echo '</div>';

echo '</div>';
