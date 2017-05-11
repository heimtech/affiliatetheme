<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../wp-load.php');
require_once 'AffiliatePartner.php';
global $user_ID, $wpdb;

$starRatings = array(
    0 => 'keine Bewertung',
    '0.5' => '0,5 Sterne',
    1 => '1 Stern',
    '1.5' => '1,5 Sterne',
    2 => '2 Sterne',
    '2.5' => '2,5 Sterne',
    3 => '3 Sterne',
    '3.5' => '3,5 Sterne',
    4 => '4 Sterne',
    '4.5' => '4,5 Sterne',
    5 => '5 Sterne'
);

$apPID = (isset($_POST['apUniqueProductId']) && $_POST['apUniqueProductId'] != "") ? $_POST['apUniqueProductId'] : '';
$partner = (isset($_POST['partner']) && $_POST['partner'] != "") ? $_POST['partner'] : '';

if ($apPID == '') {
    echo 'Produkt konnte nicht gefunden werden!';
    exit();
}

$AffiliatePartner = new AffiliatePartner();

$affiliatePartnerSettings = $AffiliatePartner->getAffiliatePartnerSettings($partner);

$imageImportType = $affiliatePartnerSettings['imageImportType'];

$imgFileNameReadOnly = ($imageImportType == 'download') ? '' : ' readonly ';

$product = $AffiliatePartner->getApSingleProduct($apPID, $partner);

$importProductDescription = '';
$productDescription = '';
if (isset($affiliatePartnerSettings['importProductDescription']) && $affiliatePartnerSettings['importProductDescription'] == 1) {
    $importProductDescription = 'checked="checked"';
    $productDescription = (strlen($product->getDescription()) > 0) ? $product->getDescription() : $product->getDescriptionLong();
}

$productManufacturers = $AffiliatePartner->getProductManufacturers(array(
    'hide_empty' => 0
));
$productTypes = $AffiliatePartner->getProductTypes(array(
    'hide_empty' => 0
));

$images = $product->getImages();
$title = $product->getName();

$ean = $product->getEan();

$prices = $product->getProductPrices();

$trackingLinks = $product->getTrackingLinks();

$shopName = $product->getProductShopName();

$starRating_ = $product->getStarRating();

?>
<style>
.choice-block {
	height: 80px;
	max-height: 80px;
	border: 1px solid #ddd;
	overflow: auto;
	float: left;
	width: 100%;
	padding-bottom: 5px;
	padding-top: 5px;
	font-size: small;
}

.labels {
	float: left;
	width: 100%;
	font-size: small;
}

.div_boxes {
	float: left;
	margin: 4px;
	font-size: small;
}

.div48 {
	width: 48%;
	font-size: small;
}

.div32 {
	width: 32%;
	font-size: small;
}

.div100 {
	width: 100%;
	border-bottom: 1px solid #ddd;
	float: left;
}
</style>

<form id="di_form">
	<span id="affiliatePartner" style="display: none;"><?php echo $partner; ?></span>

	<div class="div100">
		<div class="div_boxes div48">
			<span class="labels">Titel:</span><br /> <input name="di_title"
				id="di_title" style="width: 99%;" type="text"
				value="<?php echo $title; ?>" />
		</div>

		<div class="div_boxes div48">
			<span class="labels">Shop-Name:</span><br /> <input
				name="di_shop_name" id="di_shop_name" style="width: 99%;"
				type="text" value="<?php echo $shopName; ?>" />
		</div>
	</div>


	<div class="div100">
		<div class="div_boxes div32">
			<span class="labels">ProduktId:</span> <span id="apUniqueProductId"><?php echo $apPID; ?></span>
		</div>

		<div class="div_boxes div32">
			<span class="labels">EAN's:</span> <input type="text" name="di_ean"
				id="di_ean" value="<?php echo $ean; ?>" style="width: 200px;" />

		</div>
		<div class="div_boxes div32">
			<span class="labels">Sterne Bewertung:</span> <select
				name="di_star_rating" id="di_star_rating">
			<?php
foreach ($starRatings as $key => $starRating) {
    $selected = '';
    if ((double) $key == (double) $starRating_) {
        $selected = 'selected="selected"';
    }
    echo '<option ' . $selected . ' value="' . $key . '">' . $starRating . '</option>';
}
?>
		</select>
		</div>
	</div>

	<div class="div100">
		<div class="div_boxes div32">
			<span class="labels">Interne Bewertung:</span> <select
				name="di_internal_review" id="di_internal_review">
				<option value="20">20 - sehr gut</option>
				<option value="19">19</option>
				<option value="18">18</option>
				<option value="17">17</option>
				<option value="16">16</option>
				<option value="15">15</option>
				<option value="14">14</option>
				<option value="13">13</option>
				<option value="12">12</option>
				<option value="11">11</option>
				<option value="10">10</option>
				<option value="9">9</option>
				<option value="8">8</option>
				<option value="7">7</option>
				<option value="6">6</option>
				<option value="5">5</option>
				<option value="4">4</option>
				<option value="3">3</option>
				<option value="2">2</option>
				<option value="1">1 - sehr schlecht</option>
				<option selected="selected" value="keine Bewertung">keine Bewertung</option>
			</select>
		</div>
		<div class="div_boxes div32">
			<span class="labels">UVP:</span> <span id="di_uvp"><?php echo $AffiliatePartner->formatPrice($prices->uvp); ?></span>
		</div>
		<div class="div_boxes div32">
			<span class="labels"><?php echo __('Price','affiliatetheme'); ?>:</span> <select name="di_price"
				id="di_price">
			<?php
if (isset($prices->price) && $prices->price > 0) {
    echo '<option value="price#' . $prices->price . '"> ' . $AffiliatePartner->formatPrice($prices->price) . ' (Preisempfehlung)</option>';
}
if (isset($prices->lowest_used) && $prices->lowest_used > 0) {
    echo '<option value="lowest_used#' . $prices->lowest_used . '"> ' . $AffiliatePartner->formatPrice($prices->lowest_used) . ' (Niedrigster Preis - gebraucht)</option>';
}
if (isset($prices->lowest_new) && $prices->lowest_new > 0) {
    echo '<option value="lowest_new#' . $prices->lowest_new . '"> ' . $AffiliatePartner->formatPrice($prices->lowest_new) . ' (Niedrigster Preis)</option>';
}
?>
		</select>
		</div>
	</div>

	<div class="div100">

		<div class="div_boxes div48">

			<span class="labels"><?php echo __('Brand','affiliatetheme'); ?>:</span>
			<div class="choice-block">
				<input type="radio" name="di_brand" value="new-brand"
					id="new-brand-radio" /> <input
					value="<?php echo $product->getManufacturer(); ?>" name="new-brand"
					id="new-brand" placeholder="Neuen Term in 'Hersteller' anlegen"
					type="text" style="width: 90%;" />
			<?php
$i = 1;
foreach ($productManufacturers as $key => $manufacturer) {
    $checked = '';
    $autofocus = '';
    
    if (strtolower($manufacturer->name) == strtolower($product->getManufacturer())) {
        $checked = ' checked="checked"';
        $autofocus = 'autofocus = "autofocus" ';
    }
    
    ?>
			    <input value="<?php echo $manufacturer->slug; ?>" type="radio"
					name="di_brand" <?php echo $checked; ?> <?php echo $autofocus; ?> />
				<label for="<?php echo $manufacturer->slug; ?>"> <?php echo $manufacturer->name; ?></label>
				<br />
			    <?php
    $i ++;
}
?>
		</div>
		</div>

		<div class="div_boxes div48">
			<span class="labels"><?php echo __('Type','affiliatetheme'); ?>:</span>
			<div class="choice-block">
				<input type="radio" name="di_type" value="new-type" /> <input
					name="new-type" id="new-type"
					placeholder="Neuen Term in 'Typen' anlegen" type="text"
					style="width: 90%;" />
			<?php
$i = 1;
foreach ($productTypes as $taxonomy => $productType) {
    ?>
			    <input value="<?php echo $productType->slug; ?>" type="radio"
					name="di_type" /> <label for="<?php echo $productType->slug; ?>"> <?php echo $productType->name; ?></label>
				<br />
			    <?php
    $i ++;
}
?>
		</div>
		</div>
	</div>

	<div class="div100">
	
	<?php
$taxonomies_table = $wpdb->prefix . "taxonomies";
$res = $wpdb->get_results('SELECT * FROM ' . $taxonomies_table, OBJECT);

if (count($res) > 0) {
    $i = 0;
    $j = 1;
    foreach ($res as $mytax) {
        $taxonomySlug = 'produkt_' . $mytax->taxonomy_slug;
        $taxonomyPlural = $mytax->taxonomy_plural;
        
        ?>
	        <div class="div_boxes div48">

			<span class="labels">Produktkategorie <b><?php echo $taxonomyPlural;?></b></span>
			<div class="choice-block">

				<input class="di_custom_taxonomy" type="radio"
					name="di_custom_taxonomy-<?php echo $j; ?>"
					value="newcustomtaxonomy-<?php echo $taxonomySlug; ?>" /> <input
					name="newcustomtaxonomy-<?php echo $taxonomySlug; ?>"
					placeholder="Neuen Term in '<?php echo $taxonomyPlural;?>' anlegen"
					id="newcustomtaxonomy-<?php echo $taxonomySlug; ?>" type="text"
					style="width: 90%;" />
					
					<?php
        $taxonomies = get_terms($taxonomySlug, array(
            'hide_empty' => 0
        ));
        
        foreach ($taxonomies as $taxonomy => $value) {
            ?>
				    
				    	<input class="di_custom_taxonomy" type="radio"
					name="di_custom_taxonomy-<?php echo $j; ?>"
					value="<?php echo $taxonomySlug; ?>_#_<?php echo $value->slug; ?>" />

				<label for="<?php echo $value->slug; ?>"> <?php echo $value->name; ?></label>
				<br />
				    	<?php
        }
        ?>
				</div>
		</div>
			<?php
        if ($i % 2) {
            echo '<div class="clearfix"></div>';
        }
        $i ++;
        $j ++;
    }
}
?>
</div>

	<div class="div100" id="product-image-boxes">
	<?php echo $AffiliatePartner->writeProductImageBoxes($images, $title, $imgFileNameReadOnly); ?>
</div>

	<div class="div100">
		<b><?php echo __('Description','affiliatetheme'); ?>:</b><br />

		<textarea rows="8" cols="50" style="width: 100%;" name="di_desc"
			id="di_desc"><?php echo $productDescription; ?></textarea>
		<input name="di_importDesc" id="di_importDesc" type="checkbox"
			value="1" <?php echo $importProductDescription; ?> /> Beschreibung
		importieren
	</div>

	<div class="div100">
		<div class="div_boxes div32">
			<span
				style="width: 100%; word-wrap: break-word; display: inline-block;">
				<a href="<?php echo $trackingLinks->affiliateLink; ?>"
				target="_blank" title="<?php echo $trackingLinks->affiliateLink; ?>"
				id="di_affiliate"> AFFILIATELINK </a>
			</span> <input type="checkbox" checked="checked"
				name="di_import-affiliate" id="di_import-affiliate" /> Affiliatelink
			Importieren
		</div>
		<div class="div_boxes div32">
		<?php
if (isset($trackingLinks->affiliateLinkCart) && $trackingLinks->affiliateLinkCart != "") {
    ?>
		    <span
				style="width: 100%; word-wrap: break-word; display: inline-block;">
				<a href="<?php echo $trackingLinks->affiliateLinkCart; ?>"
				target="_blank"
				title="<?php echo $trackingLinks->affiliateLinkCart; ?>"
				id="di_affiliateCart"> AFFILIATELINK '<?php echo strtoupper(__('Add to cart','affiliatetheme')); ?>' </a>
			</span> <input type="checkbox" name="di_import-affiliateCart"
				checked="checked" id="di_import-affiliateCart"> Affiliatelink ('<?php echo __('Add to cart','affiliatetheme'); ?>') Importieren
		    <?php
} else {
    ?>
		    <input type="checkbox" name="di_import-affiliateCart"
				id="di_import-affiliateCart" style="display: none;" />
		    <?php
}
?>
		 		

	</div>
		<div class="div_boxes div32">
		<?php
if (isset($trackingLinks->Link) && $trackingLinks->Link != "") {
    ?>
		    <span
				style="width: 100%; word-wrap: break-word; display: inline-block;">
				<a href="<?php echo $trackingLinks->Link; ?>" target="_blank"
				title="<?php echo $trackingLinks->Link; ?>">LINK</a>
			</span>
		    <?php
}
?>		
	</div>
	</div>

	<div class="div100" style="text-align: center;">
		<div class="div_boxes div48">
			<span class="button-primary" id="di-add-products-published"
				style="width: 260px;">Produkt importieren (veröffentlichen)</span>
		</div>
		<div class="div_boxes div48">
			<span class="button-primary" id="di-add-products-draft"
				style="width: 260px;">Produkt importieren (als Entwurf)</span>
		</div>
	</div>

</form>

<?php

include_once 'detailImportJS.php';