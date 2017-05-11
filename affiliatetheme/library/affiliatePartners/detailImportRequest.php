<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../wp-load.php');
require_once 'AffiliatePartner.php';

$AffiliatePartner = new AffiliatePartner();

global $user_ID;

// ID of the product (assigned by amazon, zanox, belboon, affilinet, tradedoubler, eBay)
$apUniqueProductId = filter_input(INPUT_POST, 'apUniqueProductId', FILTER_SANITIZE_STRING);

$public = filter_input(INPUT_POST, 'public', FILTER_SANITIZE_STRING);
$public = ($public === 'true') ? 'publish' : 'draft';

$shopName = filter_input(INPUT_POST, 'shopName', FILTER_SANITIZE_STRING);
$affiliate = filter_input(INPUT_POST, 'affiliate', FILTER_SANITIZE_STRING);
$affiliateCart = filter_input(INPUT_POST, 'affiliatecart', FILTER_SANITIZE_STRING);
$ean = filter_input(INPUT_POST, 'ean', FILTER_SANITIZE_STRING);
$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING);
$pricetype = filter_input(INPUT_POST, 'prictetype', FILTER_SANITIZE_STRING);
$uvp = filter_input(INPUT_POST, 'uvp', FILTER_SANITIZE_STRING);
$affiliatePartner = filter_input(INPUT_POST, 'affiliatePartner', FILTER_SANITIZE_STRING);
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$starRating = filter_input(INPUT_POST, 'starRating', FILTER_SANITIZE_STRING);
$internalReview = filter_input(INPUT_POST, 'internalReview', FILTER_SANITIZE_STRING);

$desc = $_POST['desc'];
if (trim($desc) !== '') {
    $desc = html_entity_decode(filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_SPECIAL_CHARS));
}

$brand = filter_input(INPUT_POST, 'brand', FILTER_SANITIZE_STRING);
$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);

$images = filter_input(INPUT_POST, 'images', FILTER_SANITIZE_STRING);

$imagesArray = array();
if (strlen($images) > 10) {
    $imageItems = explode('####', $images);
    if (count($imageItems) > 0) {
        $i = 1;
        $imgNames = array();
        foreach ($imageItems as $imageItem) {
            $imageItemArray = explode('_#_', $imageItem);
            if (is_array($imageItemArray) && count($imageItemArray) == 3) {
                
                $imgSrc = $imageItemArray[0];
                $imgTitle = ($imageItemArray[2] != "") ? $imageItemArray[2] : $title;
                
                $imgNewName = $imageItemArray[1];
                $imgOrigName = $AffiliatePartner->getImageFileNameFromUrl($imgSrc);
                
                $imgName = $imgOrigName;
                
                if (preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $imgNewName)) {
                    $imgName = $AffiliatePartner->tidyTxt($imgNewName);
                } else {
                    if (! preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $imgSrc)) {
                        $imageExtension = $AffiliatePartner->gdExtension($imgSrc);
                        $imgName = $imgName . '.' . $imageExtension;
                    }
                }
                
                if (in_array($imgName, $imgNames)) {
                    $imgName = $i . '-' . $imgName;
                }
                
                array_push($imgNames, $imgName);
                
                $imagesArray[] = array(
                    'src' => $imgSrc,
                    'name' => $imgName,
                    'title' => $imgTitle
                );
                
                $i ++;
            }
        }
    }
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

update_post_meta($post_id, 'interne_bewertung', $internalReview);
update_post_meta($post_id, '_interne_bewertung', 'field_internal_review_value');

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

$customTaxonomies = filter_input(INPUT_POST, 'customTaxonomies', FILTER_SANITIZE_STRING);
if (strlen($customTaxonomies) > 10) {
    $customTaxonomiesArray = explode('####', $customTaxonomies);
    if (count($customTaxonomiesArray) > 0) {
        foreach ($customTaxonomiesArray as $customTaxonomyItem) {
            $customTaxonomyItemArray = explode('_#_', $customTaxonomyItem);
            if (is_array($customTaxonomyItemArray) && count($customTaxonomyItemArray) == 2) {
                $taxonomyParent = $customTaxonomyItemArray[0];
                $taxonomyChild = $customTaxonomyItemArray[1];
                wp_set_object_terms($post_id, $taxonomyChild, $taxonomyParent);
            }
        }
    }
}

$imageImportType = $affiliatePartnerSettings['imageImportType'];

if (! function_exists('media_sideload_image') && $imageImportType == 'download') {
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
}

update_post_meta($post_id, 'content', $desc);

if (is_array($imagesArray) && count($imagesArray) > 0) {
    $number = 0;
    foreach ($imagesArray as $img) {
        
        if ($imageImportType == 'download') {
            $AffiliatePartner->addAttachImg('detail', $img, $post_id, '');
        } else {
            if ($number == 0) {
                update_post_meta($post_id, '_thumbnail_id', 'by_url');
                update_post_meta($post_id, '_external_thumbnail_url', esc_url($img['src']));
            }
            $AffiliatePartner->addPostMetaExternalImage($post_id, $number, $img);
            $number ++;
        }
    }
    if ($number > 0) {
        $AffiliatePartner->addPostMetaExternalImageCount($post_id, $number);
    }
    
    $AffiliatePartner->createProductGallery($post_id);
}







