<?php
require_once dirname(__FILE__) . '/../AffiliatePartner.php';
$affiliatePartner = new AffiliatePartner();

require_once 'Zanox.php';
require_once dirname(__FILE__) . '/../styleDefinitions.php';

require_once 'zanoxMandatoryOptions.php';
if (isset($zanoxSettingErrors) && strlen($zanoxSettingErrors) > 10) {
    echo $zanoxSettingErrors;
    exit();
}

$zanoxApi = new Zanox($zanoxSecretKey, $zanoxConnectId, $zanoxSearchRegion);

$adspaces = $zanoxApi->getAdspaces();
$adspaces = json_decode($adspaces);
$adspaceItems = $adspaces->adspaceItems;

$programs = $zanoxApi->getPrograms(1, 0);
$programs = json_decode($programs);

$items = 50;
$total = $programs->total;

$apProgramItems = array();

if (intval($total) > 0 && $total < 1500) {
    
    $k = 0;
    for ($i = 0; $i <= $total; $i += $items) {
        
        $programs = $zanoxApi->getPrograms($items, $k);
        $programs = json_decode($programs);
        
        foreach ($programs->programItems->programItem as $programItem) {
            
            $programId = $programItem->{'@id'};
            $programName = $programItem->name;
            $apProgramItems[$programId] = $programName;
        }
        
        $k ++;
    }
}
asort($apProgramItems, SORT_NATURAL | SORT_FLAG_CASE);

?>
<div class="wrap">

	<h1>Zanox-Schnittstelle » Produkte importieren</h1>
	<p>Finden Sie auf Zanox Produkte und binden sie mit einem Klick in Ihre
		Seite ein.</p>

	<p>
		Wenn Sie Hilfe beim Importieren der Produkte benötigen, klicken Sie
		bitte auf den folgenden Link, um zu einer Anleitung auf AffiliSEO.de
		zu gelangen. <br /> <a
			href="http://affiliseo.de/dokumentation/zanox-produkte-importieren/"
			target="_blank" class="link-affiliseo"> <i
			class="fa fa-youtube-play fa-2x fa-affiliseo"></i> zur Anleitung auf
			AffiliSEO.de
		</a>
	</p>

	<table class="widefat">
		<tr>
			<td>1. Ein Keyword für die Suche bei Zanox eingeben.</td>
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
			<td><select name="ap_adspace_id" id="ap_adspace_id">
					<option value="">keine Werbefl&auml;che</option>
					<?php
    
    if (is_object($adspaceItems)) {
        
        foreach ($adspaceItems as $adspaceItem) {
            foreach ($adspaceItem as $adspace) {
                echo '<option value="' . $adspace->{'@id'} . '">' . $adspace->name . '</option>';
            }
        }
    }
    
    ?>
				</select> Werbefl&auml;che ausw&auml;hlen</td>
		</tr>

		<tr>
			<td><select name="products_per_page" id="products_per_page">
					<?php
    for ($i = 5; $i <= 50; $i += 5) {
        echo '<option>' . $i . '</option>';
    }
    ?>
				</select> Anzahl der Produkte pro Seite</td>
		</tr>
		
		<?php
if (is_array($apProgramItems) && count($apProgramItems) > 0) {
    ?>
		    <tr>
			<td><select name="ap_program_id" id="ap_program_id">
					<option value="">keine Shopauswahl</option>
		    			<?php
    foreach ($apProgramItems as $key => $value) {
        echo '<option value="' . $key . '">' . $value . '</option>';
    }
    ?>
		    		</select></td>
		</tr>
		    <?php
}
?>

		<tr>
			<td><input type="text" name="keyword" value="<?php echo $keyword; ?>"
				style="width: 25%;" placeholder="Keyword für die Suche bei Zanox"
				id="keyword" /> <input type="submit" name="submit"
				value="Suche auf Zanox" class="button-primary" id="submit-keyword" /></td>
		</tr>
	</table>

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

var requestUrl =  '/wp-content/themes/affiliatetheme/library/affiliatePartners/zanox/searchProductRequest.php';

jQuery("#submit-keyword").click(function ($) {
	var keyword = jQuery('#keyword').val();
	var ap_adspace_id = jQuery("#ap_adspace_id" ).val();
	var products_per_page = jQuery('#products_per_page').val();
	var ap_program_id = jQuery("#ap_program_id" ).val();

	var requestData = {
		'keyword':keyword, 
		'ap_adspace_id':ap_adspace_id,
		'products_per_page':products_per_page,
		'ap_program_id':ap_program_id
	};
	loadResults(requestUrl, requestData);
});

jQuery("#keyword").keydown(function (e) {
	if (e.keyCode == 13) {
		var keyword = jQuery('#keyword').val();
		var ap_adspace_id = jQuery("#ap_adspace_id" ).val();
		var products_per_page = jQuery('#products_per_page').val();
		var ap_program_id = jQuery("#ap_program_id" ).val();

		var requestData = {
			'keyword':keyword,
			'ap_adspace_id':ap_adspace_id,
			'products_per_page':products_per_page,
			'ap_program_id':ap_program_id
		};
		loadResults(requestUrl, requestData);
	}
});

</script>