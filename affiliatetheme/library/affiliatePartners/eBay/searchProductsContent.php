<?php
require_once 'getOptions.php';
require_once 'Ebay.php';

$eBayApi = new Ebay($publisherData);
require_once 'Ebay.php';
require_once dirname(__FILE__).'/../styleDefinitions.php';

$eBayCategories = $eBayApi->getCategories();

$categoryArray = $eBayCategories->CategoryArray;

$categories = array();
foreach ($categoryArray as $key=>$values){
    if(is_object($values)){
        foreach ($values as $value){
            if($value->CategoryID > 0){
                $categories[$value->CategoryID->__toString()] = $value->CategoryName->__toString();                
            }
        }
    }    
}

?>
<div class="wrap">

    <h1>eBay-Schnittstelle » Produkte importieren</h1>
    <p>
        Finden Sie auf eBay Produkte und binden sie mit einem Klick in Ihre Seite ein.
    </p>
    
    <p>
        Wenn Sie Hilfe beim Importieren der Produkte benötigen, klicken Sie 
        bitte auf den folgenden Link, um zu einer Anleitung auf AffiliSEO.de 
        zu gelangen. 
        <br /> 
        <a
            href="http://affiliseo.de/dokumentation/eBay-produkte-importieren/"
            target="_blank" class="link-affiliseo"> 
            <i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> 
            zur Anleitung auf AffiliSEO.de
        </a>
    </p>
    
    <table class="widefat">
        <tr>
			<td>1. Ein Keyword für die Suche bei eBay eingeben.</td>
		</tr>

		<tr>
			<td>2. Resultate ansehen und das Produkt aussuchen, das Sie posten
				wollen.</td>
		</tr>
		<tr>
			<td>3. Auf "Produkt importieren" klicken, um das Produkt zu
				erstellen.</td>
		</tr>
		
		<tr>
			<td>
				<div style="width:195px; float:left;">Anzahl der Produkte pro Seite</div	>
				<select name="products_per_page" id="products_per_page">
					<?php
					for($i=5; $i<=50; $i +=5){
					    echo '<option>'.$i.'</option>';
					}
					?>
				</select> 
			</td>
		</tr>
		
		<tr>
			<td>
				<div style="width:195px; float:left;">eBay Kategorie ausw&auml;hlen</div>
				<select name="eBay_category_id" id="eBay_category_id" style="width: 250px;">
					<?php
					foreach ($categories as $key=>$value){
					    echo '<option value="'.$key.'">'.$value.'</option>';
					}					
					?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td>
				<div style="width:195px; float:left;"><?php echo __('Price','affiliatetheme'); ?> </div>
				
				von: <input 
					type="number" 
					style="width: 90px;"
					name="eBay_min_price" 
					id="eBay_min_price" 
					value="0" step="1" min="0" />
				bis:
				<input 
					type="number" 
					style="width: 90px;"
					name="eBay_max_price" 
					id="eBay_max_price" 
					value="0" step="1" min="0" />
			</td>
		</tr>
		
		<tr>
			<td><input type="text" name="keyword"
				value="<?php echo $keyword; ?>" style="width: 25%;"
				placeholder="Keyword für die Suche bei eBay" id="keyword" /> <input
				type="submit" name="submit" value="Suche auf eBay"
				class="button-primary" id="submit-keyword" /></td>
		</tr>
	</table>

	<table class="widefat" id="data">
		<tr>
			<td>                
                Ihre Ergebnisse erscheinen hier.
            </td>
		</tr>
	</table>
	<a href="<?php echo site_url(); ?>" id="blogurl"
		style="display: none;"></a>
	<p
		style="color: #8a6d3b; background-color: #fcf8e3; border-color: #faebcc; padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px;">
		<strong>Anmerkung des Entwicklers:</strong><br /> Diese Software ist
		gem. § 69a Abs. 3 UrhG urheberrechtlich geschützt. Das Plagiieren und
		Verbreiten der Software oder von Codesegmenten stellt eine starfbare
		Handlung dar und kann eine Geld- oder Haftstrafe nach sich ziehen. Des
		Weiteren besteht seitens des Entwicklers ein Unterlassungsanspruch.
		Das Plagiieren und Verbreiten der Software oder von Codesegmenten kann
		kostenpflichtig abgemahnt werden. In diesem Fall behält sich der
		Entwickler die Beantragung einer einstweiligen Verfügung oder eine
		Unterlassungsklage vor.
	</p>
</div>

<script type="text/javascript">

var requestUrl =  '/wp-content/themes/affiliatetheme/library/affiliatePartners/eBay/searchProductRequest.php';

jQuery("#submit-keyword").click(function ($) {
	var keyword = jQuery('#keyword').val();
	var products_per_page = jQuery('#products_per_page').val();
	var eBay_category_id = jQuery('#eBay_category_id').val();
	var eBay_min_price = jQuery('#eBay_min_price').val();
	var eBay_max_price = jQuery('#eBay_max_price').val();
	
	var requestData = {
		'keyword':keyword, 
		'products_per_page':products_per_page,
		'eBay_category_id':eBay_category_id,
		'eBay_min_price':eBay_min_price,
		'eBay_max_price':eBay_max_price		
	};
	loadResults(requestUrl, requestData);
});

jQuery("#keyword").keydown(function (e) {
	if (e.keyCode == 13) {
		var keyword = jQuery('#keyword').val();
		var products_per_page = jQuery('#products_per_page').val();
		var eBay_category_id = jQuery('#eBay_category_id').val();
		var eBay_min_price = jQuery('#eBay_min_price').val();
		var eBay_max_price = jQuery('#eBay_max_price').val();
		
		var requestData = {
			'keyword':keyword, 
			'products_per_page':products_per_page,
			'eBay_category_id':eBay_category_id,
			'eBay_min_price':eBay_min_price,
			'eBay_max_price':eBay_max_price			
		};
		loadResults(requestUrl, requestData);
	}
});

</script>