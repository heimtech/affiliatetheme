<?php
global $affiliseo_options, $post, $device;

$product_image_effect = $affiliseo_options['product_image_effect'];
$show_loupe = $affiliseo_options['show_loupe'];

if (trim($show_loupe) !== '1') {
    if ($device === 'desktop') {
        ?>
<div id="show-loupe"></div>
<?php
    }
}

function show_thumb($thumbId, $post, $productImageEffect)
{
    $externalThumbnailUrl = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
    
    if (strlen($externalThumbnailUrl) > 3) {
        $imgSrc = $externalThumbnailUrl;
        $imgAlt = get_the_title($post->ID);
        $thumbId = getPostMetaId($post->ID, $externalThumbnailUrl);
    } else {
        $image_attributes = wp_get_attachment_image_src($thumbId, 'full');
        $imgSrc = $image_attributes[0];
        $imgAlt = get_post_meta($thumbId, '_wp_attachment_image_alt', true);
    }
    
    if (strlen($imgSrc) > 3) {
        return '<img
        data-src="' . $imgSrc . '"
    class="img_by_url_full_size product-img-detail zoom_in big-slider-product-img ' . $productImageEffect . '"
        alt="' . $imgAlt . '" id="img_product_' . $thumbId . '"
        itemprop="image">';
    } else {
        return '';
    }
}
?>

<div id="img-product-container">
	<div class="text-center" id="spinner-slider">
		<i class="fa fa-spinner fa-3x"></i>
	</div>
	
	<?php

// first: get all external images
$externalImages = getExternalImages($post->ID);
$externalThumbnailSrc = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);

$showThumb = false;
if (strlen($externalThumbnailSrc) > 3) {
    echo show_thumb($thumb_id, $post, $product_image_effect);
    $showThumb = true;
}

if (count($externalImages) > 0) {
    foreach ($externalImages as $externalImage) {
        $externalImageSrc = $externalImage['src'];
        $externalImageTitle = $externalImage['title'];
        
        $externalImageId = getPostMetaId($post->ID, $externalImageSrc);
        
        $externalImageHide = 'hide';
        if ($externalThumbnailSrc == $externalImageSrc) {
            $externalImageHide = '';
        }
        ?>
			        
			        <img data-src="<?php echo $externalImageSrc; ?>"
		class="img_by_url_full_size product-img-detail zoom_in big-slider-product-img <?php echo $product_image_effect; ?> hidden"
		alt="<?php echo $externalImageTitle; ?>"
		id="img_product_<?php echo $externalImageId; ?>" itemprop="image" />
		
			        
			                    
			                    
			                    
			                    <?php
    }
}

$thumbnailUrl = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
$attachments = get_posts('post_type=attachment&post_parent=' . $post->ID . '&posts_per_page=-1&order=ASC');
$img_ids = array();
if (count($attachments) === 0 && (has_post_thumbnail($post->ID) || strlen($thumbnailUrl) > 3) && $showThumb == false) {
    $thumb_id = intval(get_post_thumbnail_id($post->ID));
    echo show_thumb($thumb_id, $post, $product_image_effect);
    $showThumb = true;
} elseif (count($attachments) !== 0) {
    
    $has_thumb = false;
    if ((has_post_thumbnail($post->ID) || strlen($thumbnailUrl) > 3) && $showThumb == false) {
        $has_thumb = true;
        $thumb_id = get_post_thumbnail_id($post->ID);
        array_push($img_ids, $thumb_id);
        echo show_thumb($thumb_id, $post, $product_image_effect);
        $showThumb = true;
    }
    
    for ($i = 0; $i < count($attachments); $i ++) {
        $id = $attachments[$i]->ID;
        if (in_array($id, $img_ids, true)) {
            continue;
        }
        array_push($img_ids, $id);
        $image_attributes = wp_get_attachment_image_src($id, 'full');
        $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
        if ($i === 0) {
            if ($has_thumb) {
                echo '<img data-src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" class="product-img-detail zoom_in big-slider-product-img hidden ' . $product_image_effect . '" alt="' . $alt . '" id="img_product_' . $id . '">';
            } else {
                echo '<img data-src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" class="product-img-detail zoom_in big-slider-product-img hidden ' . $product_image_effect . '" alt="' . $alt . '" id="img_product_' . $id . '" itemprop="image">';
            }
        } else {
            echo '<img data-src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" class="product-img-detail zoom_in big-slider-product-img hidden ' . $product_image_effect . '" alt="' . $alt . '" id="img_product_' . $id . '">';
        }
    }
}
?>
</div>


<?php
$bigSliderContent = '';
$countLiElems = 0;
?>


<div id="big-slider-container">
	<?php

$bigSliderContent .= '<ul class="big-slider">';

// first get all external images
$externalImages = getExternalImages($post->ID);
$externalThumbnailSrc = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);

if (count($externalImages) > 0) {
    foreach ($externalImages as $externalImage) {
        $externalImageSrc = $externalImage['src'];
        $externalImageTitle = $externalImage['title'];
        $imgSelected = '';
        if ($externalImageSrc == $externalThumbnailSrc) {
            $imgSelected = 'selected';
        }
        
        $externalImageId = getPostMetaId($post->ID, $externalImageSrc);
        
        $countLiElems ++;
        
        $bigSliderContent .= '<li><img width="50" height="50"
			data-src="' . $externalImageSrc . '"
			class="img_by_url_slider_small_w50 big-slider-product-view ' . $imgSelected . '"
			alt="' . $externalImageTitle . '"
			id="' . $externalImageId . '" /></li>';
    }
}

$attachments_thumbs = get_posts('post_type=attachment&post_parent=' . $post->ID . '&posts_per_page=-1&order=ASC&orderby=menu_order');
$thumb_ids = array();
if (count($attachments_thumbs) > 1) {
    $has_thumb = false;
    if (has_post_thumbnail($post->ID) || strlen($thumbnailUrl) > 3) {
        $has_thumb = true;
    }
    for ($i = 0; $i < count($attachments_thumbs); $i ++) {
        $id = $attachments_thumbs[$i]->ID;
        $image_attributes = wp_get_attachment_image_src($id, 'slider_small');
        if (in_array($image_attributes[0], $thumb_ids, true)) {
            continue;
        }
        array_push($thumb_ids, $image_attributes[0]);
        $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
        if ($i === 0) {
            if ($has_thumb) {
                $thumb_id = intval(get_post_thumbnail_id($post->ID));
                $image_attributes_thumb = wp_get_attachment_image_src($thumb_id, 'slider_small');
                array_push($thumb_ids, $image_attributes_thumb[0]);
                $alt_thumb = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
                
                $bigSliderContent .= '<li><img data-src="' . $image_attributes_thumb[0] . '" width="' . $image_attributes_thumb[1] . '" height="' . $image_attributes_thumb[2] . '" class="big-slider-product-view selected" alt="' . $alt_thumb . '" id="' . $thumb_id . '"></li>';
                $bigSliderContent .= '<li><img data-src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" class="big-slider-product-view" alt="' . $alt . '" id="' . $id . '"></li>';
                
                $countLiElems ++;
            } else {
                $bigSliderContent .= '<li><img data-src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" class="big-slider-product-view selected" alt="' . $alt . '" id="' . $id . '"></li>';
                $countLiElems ++;
            }
        } else {
            $bigSliderContent .= '<li><img data-src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" class="big-slider-product-view" alt="' . $alt . '" id="' . $id . '"></li>';
            $countLiElems ++;
        }
    }
}
$bigSliderContent .= '</ul>';

if ($countLiElems > 1) {
    echo $bigSliderContent;
}
?>
	
</div>