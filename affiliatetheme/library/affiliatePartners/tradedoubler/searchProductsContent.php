<?php
require_once dirname(__FILE__).'/../AffiliatePartner.php';
$affiliatePartner = new AffiliatePartner();
require_once 'Tradedoubler.php';

require_once dirname(__FILE__).'/../styleDefinitions.php';

$tradedoublerToken = get_option('tradedoubler_token');
if (trim($tradedoublerToken) === '') {
    echo '<tr><td><strong style="color: #F00;">Kein Token vergeben!</strong></td></tr>';
    return;
}

$tradedoublerApiUrl = get_option('tradedoubler_api_url');
if (trim($tradedoublerApiUrl) === '') {
    echo '<tr><td><strong style="color: #F00;">Kein URL für Webservices vergeben!</strong></td></tr>';
    return;
}

$tradedoublerApi = new Tradedoubler($tradedoublerToken,$tradedoublerApiUrl);

$apProgramItems = array();
$tradedoublerFeeds = json_decode($tradedoublerApi->getFeeds());

if (isset($tradedoublerFeeds->feeds)) {
    
    foreach ($tradedoublerFeeds->feeds as $tradedoublerFeed) {
        $apProgramItems[$tradedoublerFeed->feedId] = $tradedoublerFeed->name;
    }
}


?>
<div class="wrap">

    <h1>Tradedoubler-Schnittstelle » Produkte importieren</h1>
    <p>
        Finden Sie auf Tradedoubler Produkte und binden sie mit einem Klick in Ihre Seite ein.
    </p>
    
    <p>
        Wenn Sie Hilfe beim Importieren der Produkte benötigen, klicken Sie 
        bitte auf den folgenden Link, um zu einer Anleitung auf AffiliSEO.de 
        zu gelangen. 
        <br /> 
        <a
            href="http://affiliseo.de/dokumentation/tradedoubler-produkte-importieren/"
            target="_blank" class="link-affiliseo"> 
            <i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> 
            zur Anleitung auf AffiliSEO.de
        </a>
    </p>
    
    <table class="widefat">
        <tr>
			<td>1. Ein Keyword für die Suche bei Tradedoubler eingeben.</td>
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
				<select name="products_per_page" id="products_per_page">
					<?php
					for($i=5; $i<=50; $i +=5){
					    echo '<option>'.$i.'</option>';
					}
					?>
				</select> Anzahl der Produkte pro Seite
			</td>
		</tr>
		
		<?php
		if (is_array($apProgramItems) && count($apProgramItems) > 0) {
		    ?>
		    <tr>
		    	<td>
		    		<select name="ap_program_id" id="ap_program_id">
		    			<option value="">keine Programmauswahl</option>
		    			<?php
		    			foreach ($apProgramItems as $key => $value) {
		    			    echo '<option value="' . $key . '">' . $value . ' ('.$key.')</option>';
		    			}
		    			?>
		    		</select>
		    	</td>
		    </tr>
		    <?php
		}
		?>
		
		<tr>
			<td><input type="text" name="keyword"
				value="<?php echo $keyword; ?>" style="width: 25%;"
				placeholder="Keyword für die Suche bei Tradedoubler" id="keyword" /> <input
				type="submit" name="submit" value="Suche auf Tradedoubler"
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

var requestUrl =  '/wp-content/themes/affiliatetheme/library/affiliatePartners/tradedoubler/searchProductRequest.php';

jQuery("#submit-keyword").click(function ($) {
	var keyword = jQuery('#keyword').val();
	var products_per_page = jQuery('#products_per_page').val();
	var ap_program_id = jQuery("#ap_program_id" ).val();

	var requestData = {
		'keyword':keyword, 
		'products_per_page':products_per_page,
		'ap_program_id':ap_program_id
	};
	loadResults(requestUrl, requestData);
});

jQuery("#keyword").keydown(function (e) {
	if (e.keyCode == 13) {
		var keyword = jQuery('#keyword').val();
		var products_per_page = jQuery('#products_per_page').val();
		var ap_program_id = jQuery("#ap_program_id" ).val();

		var requestData = {
			'keyword':keyword, 
			'products_per_page':products_per_page,
			'ap_program_id':ap_program_id
		};
		loadResults(requestUrl, requestData);
	}
});

</script>