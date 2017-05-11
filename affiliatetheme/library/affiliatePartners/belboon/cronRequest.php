<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../../wp-load.php');

require_once '../AffiliatePartner.php';

$affiliatePartner = new AffiliatePartner();

if ($_GET['secret'] != md5(trim(get_option('belboon_username')))) {
    echo 'Keine Berechtigung';
    die();
}


$posttype = 'produkt';
$customfieldPid = 'belboon_product_id';
$customfieldPrice = 'preis';
$noPriceType = get_option('ap_no_price');

?>

<style>
table tr.success {
	background: #DFF0D8;
	color: #3C763D;
}

table tr.warning {
	background: #FCF8E3;
	color: #8A6D3B;
}

table tr.error {
	background: #F2DEDE;
	color: #A94442;
}

table tr.success td.preis_neu {
	font-weight: bold;
}

table tr.success td.preis_alt {
	font-weight: bold;
}
</style>

<table class="widefat">

	<thead>
		<tr>
			<th>Artikel</th>
			<th>Produkt ID</th>
			<th>Aktueller Preis</th>
			<th>Neuer Preis</th>
		</tr>
	</thead>

	<tbody>
	<?php
if ($posttype == "" || $customfieldPrice == "" || $customfieldPid == "" ) {
    echo 'FEHLER: Bitte überprüfen Sie Ihre Einstellungen.';
    die();
}

$args = array(
    'meta_key' => 'belboon_product_id',
    'post_type' => $posttype,
    'post_status' => 'any',
    'posts_per_page' => - 1
);

$postedProducts = get_posts($args);

if ($postedProducts) {
    
    foreach ($postedProducts as $postedProduct) {
        
        $productId = get_post_meta($postedProduct->ID, $customfieldPid, true);
        $priceCurrent = get_post_meta($postedProduct->ID, $customfieldPrice, true);
        
        if ($productId) {
            
            // produkt von belboon abholen
            if ($product = $affiliatePartner->getApSingleProduct($productId, 'belboon')) {
                $prices = $product->getProductPrices();
                $priceNew = $affiliatePartner->formatPrice($prices->price);
                $trackingLinks = $product->getTrackingLinks();
                
                echo $affiliatePartner->handlePriceUpdateOutput($priceCurrent, $priceNew, $postedProduct->ID, $productId, $noPriceType, $trackingLinks);
                $affiliatePartner->updateProductModified($postedProduct->ID);
            } else {
                echo '
                        <tr class="error">
                            <td>' . get_the_title($postedProduct->ID) . '</td>
			                <td colspan="3">
			                     FEHLER: Request failed. Belboon-Server überlastet oder Produkt kann nicht ermittelt werden.
			                     Wenn dieses Problem weiterhin besteht,
			                     wenden Sie sich bitte an den Support von Belboon.
			                </td>
			            </tr>';
            }
        } else {
            echo '<tr class="error">
	               <td>' . get_the_title($postedProduct->ID) . '</td>
	               <td colspan="3">FEHLER: keine Produkt ID vorhanden</td>
	            </tr>';
        }
        sleep(1);
    }
}
?>
	</tbody>
</table>