<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../wp-load.php');
require_once 'AffiliatePartner.php';

$AffiliatePartner = new AffiliatePartner();

global $user_ID;

$affiliatePartner = filter_input(INPUT_GET, 'affiliatePartner', FILTER_SANITIZE_STRING);

$title = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_STRING);

// ID of the product (assigned by amazon, zanox, belboon, affilinet, tradedoubler, eBay)
$apUniqueProductId = filter_input(INPUT_GET, 'apUniqueProductId', FILTER_SANITIZE_STRING);

$desc = $_GET['desc'];
if (trim($desc) !== '') {
    $desc = html_entity_decode(filter_input(INPUT_GET, 'desc', FILTER_SANITIZE_SPECIAL_CHARS));
}
$price = filter_input(INPUT_GET, 'price', FILTER_SANITIZE_STRING);
$pricetype = filter_input(INPUT_GET, 'prictetype', FILTER_SANITIZE_STRING);
$uvp = filter_input(INPUT_GET, 'uvp', FILTER_SANITIZE_STRING);
$brand = filter_input(INPUT_GET, 'brand', FILTER_SANITIZE_STRING);
$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
$img = filter_input(INPUT_GET, 'img', FILTER_VALIDATE_URL);
$img = urldecode($img);
$images = filter_input(INPUT_GET, 'images', FILTER_SANITIZE_STRING);
$imagesArray = explode('|', $images);
$affiliate = filter_input(INPUT_GET, 'affiliate', FILTER_SANITIZE_STRING);
$affiliateCart = filter_input(INPUT_GET, 'affiliatecart', FILTER_SANITIZE_STRING);
$public = filter_input(INPUT_GET, 'public', FILTER_SANITIZE_STRING);
$ean = filter_input(INPUT_GET, 'ean', FILTER_SANITIZE_STRING);
$shopName = filter_input(INPUT_GET, 'shopName', FILTER_SANITIZE_STRING);
$starRating = filter_input(INPUT_GET, 'starRating', FILTER_SANITIZE_STRING);
$starRating = ($starRating != "" && intval($starRating) > 0) ? $starRating : 0;

if ($public === 'true') {
    $public = 'publish';
} else {
    $public = 'draft';
}

$affiliatePartnerSettings = $AffiliatePartner->getAffiliatePartnerSettings($affiliatePartner);
$productIdKey = $affiliatePartnerSettings['productIdKey'];

$new_post = array(
    'post_title' => $title,
    'post_content' => $desc,
    'post_status' => $public,
    'post_date' => date('Y-m-d H:i:s'),
    'post_author' => $user_ID,
    'post_type' => 'produkt',
    'post_category' => array(
        0
    )
);
$post_id = wp_insert_post($new_post);

update_post_meta($post_id, $productIdKey, $apUniqueProductId);

if ($productIdKey == 'amazon_produkt_id') {
    update_post_meta($post_id, '_amazon_produkt_id', 'field_52e782fee682f');
    $apPdpButton = buildPdpButtonLabel('Amazon', 'amazon');
} else {
    update_post_meta($post_id, '_' . $productIdKey, $productIdKey);
    $apPdpButton = buildPdpButtonLabel($shopName, $affiliatePartner);
}

update_post_meta($post_id, 'ean', $ean);
update_post_meta($post_id, 'preis', $price);
update_post_meta($post_id, 'uvp', $uvp);
update_post_meta($post_id, 'ap_pdp_link', $affiliate);
update_post_meta($post_id, 'ap_cart_link', $affiliateCart);
update_post_meta($post_id, 'sterne_bewertung', $starRating);
update_post_meta($post_id, 'price_type', $pricetype);
update_post_meta($post_id, 'ap_pdp_button', $apPdpButton);

wp_set_object_terms($post_id, $brand, 'produkt_marken');
wp_set_object_terms($post_id, $type, 'produkt_typen');

$imageImportType = $affiliatePartnerSettings['imageImportType'];

if (! function_exists('media_sideload_image') && $imageImportType == 'download') {
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
}

update_post_meta($post_id, 'content', $desc);

$number = 0;
if (isset($img) && strlen($img) > 3) {
    if ($imageImportType == 'download') {
        $AffiliatePartner->addAttachImg('quick', $img, $post_id, $title);
    } else {
        if (preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $img)) {
            $image = array(
                'src' => esc_url($img),
                'title' => $title
            );
            
            update_post_meta($post_id, '_thumbnail_id', 'by_url');
            update_post_meta($post_id, '_external_thumbnail_url', esc_url($img));
            $AffiliatePartner->addPostMetaExternalImage($post_id, $number, $image);
            $number ++;
        }
    }
}

$i = 0;

if (is_array($imagesArray) && count($imagesArray) > 0) {
    foreach ($imagesArray as $imageProduct) {
        if ($imageProduct != $img ) {
            if ($imageImportType == 'download') {
                if(strlen($imageProduct) > 3){
                    $imageProduct = urldecode($imageProduct);
                    $AffiliatePartner->addAttachImg('quick', $imageProduct, $post_id, $title . $id);
                }                
            } else {
                
                if (preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $imageProduct)) {
                    $image = array(
                        'src' => esc_url($imageProduct),
                        'title' => $title . $id
                    );
                    $AffiliatePartner->addPostMetaExternalImage($post_id, $number, $image);
                    $number ++;
                }
            }
        }
        $i ++;
    }
    
    if ($number > 0) {
        $AffiliatePartner->addPostMetaExternalImageCount($post_id, $number);
    }
    
    $AffiliatePartner->createProductGallery($post_id);
}