<?php
require_once 'AffiliatePartner.php';

$AffiliatePartner = new AffiliatePartner();

$args = array(
    'post_type' => 'produkt',
    'posts_per_page' => - 1,
    'post_status' => 'any'
);
$products = get_posts($args);

$affectedRows = 0;

if ($products) {
    foreach ($products as $product) {
        // pruefen ob das produkt bereits product gallery hat
        $productGallery = get_field('product_gallery', $product->ID);
        if (isset($productGallery) && $productGallery != "") {
            // ist bereits ueberfueht
        } else {
            $AffiliatePartner->createProductGallery($product->ID);
            
            $affectedRows ++;
        }
    }
}

echo '<b>Anzahl der erstellten Produktgalerien ' . $affectedRows . '</b>';