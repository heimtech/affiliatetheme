<?php
require_once dirname(__FILE__) . '/../styleDefinitions.php';

require_once 'amazonCategories.php';
$country = get_option('ap_currency');

$amazonCategoryList = array();
if (isset($country) && strlen($country) == 2 && isset($amazonCategories) && is_array($amazonCategories) && isset($amazonCategories[$country])) {
    $amazonCategoryList = $amazonCategories[$country];
    
    asort($amazonCategoryList);
}

?>
<div class="wrap">
	<h1>Amazon-Schnittstelle » Produkte importieren</h1>

	<p>Finden Sie auf Amazon Produkte und binden sie mit einem Klick in
		Ihre Seite ein.</p>

	<p>
		Wenn Sie Hilfe beim Importieren der Produkte benötigen, klicken Sie
		bitte auf den folgenden Link, um zu einer Anleitung auf AffiliSEO.de
		zu gelangen. <br /> <a
			href="http://affiliseo.de/dokumentation/amazon-produkte-importieren/"
			target="_blank" class="link-affiliseo"> <i
			class="fa fa-youtube-play fa-2x fa-affiliseo"></i> zur Anleitung auf
			AffiliSEO.de
		</a>
	</p>

	<table class="widefat">
		<tr>
			<td>1. Ein Keyword für die Suche bei Amazon eingeben.</td>
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
				
				<textarea rows="1" name="keyword" value="<?php echo $keyword; ?>"
				style="float:left; line-height: 1.1; font-size: 12px; margin-right: 8px; width: 25%;" placeholder="Keyword für die Suche bei Amazon"
				id="keyword"></textarea>
				
				<input type="submit" name="submit"
				value="Suche auf Amazon" class="button-primary" id="submit-keyword" />
			</td>
		</tr>
		
		
		<tr>
			<td>
				Für ASIN-Suche einfach komma-getrennte ASIN's angeben 
				(max <b style="color:red;">50</b> Stück). z.B: B0186FESVC,B00KAKPZYG<br />
				Oder aus einer amazon-Seite die ASIN's automatisch ermitteln. 
				Dafür einfach den Link zu der amazon-Seite unten eingeben.
			</td>
		</tr>
		
		<tr>
			<td>
				<input style="width:25%;" type="text" name="amazon_products_page" id="amazon_products_page" />
				<input type="submit" name="submit" value="ASINs ermitteln" class="button-primary" id="grab-asin-from-url" />
			</td>
		</tr>
		
		
		<?php
		if(count($amazonCategoryList)>0){
		    echo '<tr><td>Hauptkategorie für das Produkt: <select name="amazon_search_index" id="amazon_search_index">';
		    echo '<option value="">'.$amazonCategoryAll[$country].'</option>';
		    foreach ($amazonCategoryList as $amazonCategory){
		        echo '<option value="'.$amazonCategory['search_index'].'">'.$amazonCategory['category'].'</option>';
		        
		    }
		    echo '</select></td></tr>';
		    
		}
		?>
		
	</table>
	<p
		style="color: #a94442; background-color: #f2dede; border-color: #ebccd1; padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px;">
		Wir haben in letzter Zeit häufiger feststellen müssen, dass Amazon
		falsche Preisangaben (z.B. 0,00 € oder 1,00 €) zurückliefert. Sie
		können diesem Problem entgegenwirken, indem Sie den Preistyp des
		Produktes ändern. Sie haben hierbei die Möglichkeit zwischen dem
		niedrigsten Preis, dem niedrigsten Preis gebraucht, dem Listenpreis
		und der unverbindlichen Preisempfehlung zu wählen.<br /> Wenn Sie den
		Preistyp nicht ändern wollen, können Sie entscheiden, was bei einem
		fehlenden/falschen Preis geschehen soll. Ändern Sie hierzu die
		Einstellung unter "Fehlender Preis" in den Einstellungen der
		Amazon-Schnittstelle.<br /> <br /> Wenn Sie vermehrt falsche oder
		fehlende Preise von Amazon erhalten, wenden Sie sich bitte an den
		Support von Amazon.
	</p>

	<table class="widefat" id="data">
		<tr>
			<td>Ihre Ergebnisse erscheinen hier.</td>
		</tr>
	</table>
	<a href="<?php echo site_url(); ?>" id="blogurl" style="display: none;"></a>
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

var requestUrl = '/wp-content/themes/affiliatetheme/library/affiliatePartners/amazon/searchProductRequest.php';                 

jQuery("#submit-keyword").click(function ($) {
	var keyword = jQuery('#keyword').val();
	var amazon_search_index = jQuery('#amazon_search_index').val();
	
	var requestData = {
		'keyword':keyword, 
		'products_per_page':10,
		'amazon_search_index':amazon_search_index
	};
	loadResults(requestUrl, requestData);
});

jQuery("#keyword").keydown(function (e) {
	if (e.keyCode == 13) {
		var keyword = jQuery('#keyword').val();

		var amazon_search_index = jQuery('#amazon_search_index').val();
		
		var requestData = {
			'keyword':keyword,
			'products_per_page':10,
			'amazon_search_index':amazon_search_index
		};
		loadResults(requestUrl, requestData);
	}
});

jQuery("#grab-asin-from-url").click(function () {
	var amazonProductsPage = jQuery('#amazon_products_page').val();

	jQuery.ajax({
		type: "POST",
		data: {
			amazon_products_page: amazonProductsPage
		},
		dataType: "script",
		url: '<?php echo site_url(); ?>/wp-content/themes/affiliatetheme/library/affiliatePartners/amazon/asinGrabberRequest.php',
		success: function (data) {
		},
	});
});

function setAsinList(asinList) {
	jQuery('#keyword').val(asinList);
}

</script>