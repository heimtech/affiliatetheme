<?php

function tradedoubler_api_options_page()
{
    ob_start();
    ?>
<style type="text/css">
.alert-info {
	color: #31708F;
	background-color: #D9EDF7;
	border-color: #BCE8F1;
}

.alert {
	padding: 15px;
	margin-bottom: 20px;
	border: 1px solid rgba(0, 0, 0, 0);
	border-radius: 4px;
}

.td-content {
	padding: 25px;
	font-family: Verdana, Geneva, sans-serif;
	color: #666;
}
</style>

<form action="options.php" method="post">
	<div class="wrap">
    <?php settings_fields('affiliseo_tradedoublerapi_options'); ?>
    <?php do_settings_sections('affiliseo_tradedoublerapi_options'); ?>
    
    <h1>Tradedoubler-Schnittstelle » Einstellungen</h1>

		<p>
			Wenn Sie Hilfe bei der Einrichtung der Tradedoubler-Schnittstelle
			benötigen, klicken Sie bitte auf den folgenden Link, um zu einer
			Anleitung auf AffiliSEO.de zu gelangen. <br /> <a
				href="http://affiliseo.de/dokumentation/einrichtung-der-tradedoubler-schnittstelle/"
				target="_blank" class="link-affiliseo"> <i
				class="fa fa-youtube-play fa-2x fa-affiliseo"></i> zur Anleitung auf
				AffiliSEO.de
			</a> &nbsp;&nbsp;&nbsp;&nbsp; <a
				href="http://dev.tradedoubler.com/products/publisher/#Overview"
				target="_blank" class="link-affiliseo"> <i
				class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Detaillierte
				API-Beschreibung bei Tradedoubler
			</a>
		</p>

		<table class="widefat">

			<tbody>

				<tr>
					<td class="td-content" style="width: 450px;"><label
						for="tradedoubler_token"> Token</label> <br /> <small>Authentifizierungstoken
							für Schnitstelle</small></td>
					<td class="td-content"><input type="text" class="widefat"
						name="tradedoubler_token"
						value="<?php echo esc_attr(get_option('tradedoubler_token')); ?>" />
						<br /> <small> <b>HINWEIS:</b> Das Ändern der Partner ID zieht
							eine Veränderung der Affiliate-Links mit sich und passt beim
							nächsten Preisabgleich alle links automatisch der neuen
							Partner-ID an.
					</small></td>
				</tr>

				<tr>
					<td class="td-content"><label for="tradedoubler_api_url"> URL für
							Produkt-Schnitstelle</label> <br /> <small>Standardwert:
							https://api.tradedoubler.com/1.0/products.xml;</small></td>
					<td class="td-content"><input type="text" class="widefat"
						name="tradedoubler_api_url"
						value="<?php echo esc_attr(get_option('tradedoubler_api_url')); ?>" />
					</td>
				</tr>

				<tr>
					<td class="td-content"><label for="tradedoubler_search_region">Sprache
							/ Region</label></td>
					<td class="td-content"><select name="tradedoubler_search_region">
							<?php
    $regions = array(
        "de" => "Deutschland",
        "en" => "England",
        "fr" => "Frankreich",
        "es" => "Spanien",
        "nl" => "Niederlande",
        "at" => "&Ouml;sterreich",
        "ch" => "Schweiz"
    );
    foreach ($regions as $key => $region) {
        echo '<option value="' . $key . '" ' . setSelect($key, esc_attr(get_option('tradedoubler_search_region'))) . '>' . $region . '</option>';
    }
    ?>
						</select></td>
				</tr>

				<tr>
					<td class="td-content"><label for="tradedoubler_pdp_button">Affiliate-Button</label>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="tradedoubler_pdp_button"
						value="<?php echo esc_attr(get_option('tradedoubler_pdp_button')); ?>" />
						<br /> <small> z.B.: <b>Jetzt kaufen bei Tradedoubler</b> oder <b>Jetzt
								bei {shop_name} kaufen</b><br /> Der Platzhalter <b>{shop_name}</b>
							wird ersetzt, wenn ein Shopname vorhanden ist
					</small></td>
				</tr>

				<tr>
					<td class="td-content"><label
						for="tradedoubler_import_product_description">Produktbeschreibung
							importieren</label></td>
					<td class="td-content"><input
						name="tradedoubler_import_product_description" type="checkbox"
						value="1"
						<?php checked( '1', get_option( 'tradedoubler_import_product_description' ) ); ?> />
						Ja</td>
				</tr>
				
				<?php require_once dirname(__FILE__).'/../checkExtensions.php'; ?>
				
				<?php
    $partnerImageImportType = 'tradedoubler_image_import_type';
    require_once dirname(__FILE__) . '/../partnerImageImportType.php';
    ?>
    
    			</tbody>

			<tfoot>
				<tr>
					<th><input type="submit" name="submit" value="Speichern"
						class="button-primary" style="" /></th>
					<th><a class="button-primary"
						href="http://www.tradedoubler.com/de-de/" target="_blank">Anmeldung
							Tradedoubler*</a></th>
				</tr>
				<tr>
					<th colspan="2" style="text-align: right;">* = Partnerlink</th>
				</tr>
			</tfoot>

		</table>
	</div>
</form>

<p
	style="color: #8a6d3b; background-color: #fcf8e3; border-color: #faebcc; padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px;">

	<strong>Anmerkung des Entwicklers</strong><br /> Diese Software ist
	gem. § 69a Abs. 3 UrhG urheberrechtlich geschützt. Das Plagiieren und
	Verbreiten der Software oder von Codesegmenten stellt eine starfbare
	Handlung dar und kann eine Geld- oder Haftstrafe nach sich ziehen. Des
	Weiteren besteht seitens des Entwicklers ein Unterlassungsanspruch. Das
	Plagiieren und Verbreiten der Software oder von Codesegmenten kann
	kostenpflichtig abgemahnt werden. In diesem Fall behält sich der
	Entwickler die Beantragung einer einstweiligen Verfügung oder eine
	Unterlassungsklage vor.
</p>
<?php
    echo ob_get_clean();
}

function tradedoubler_api_register_settings()
{
    register_setting('affiliseo_tradedoublerapi_options', 'tradedoubler_token');
    register_setting('affiliseo_tradedoublerapi_options', 'tradedoubler_api_url');
    register_setting('affiliseo_tradedoublerapi_options', 'tradedoubler_pdp_button');
    register_setting('affiliseo_tradedoublerapi_options', 'tradedoubler_import_product_description');
    register_setting('affiliseo_tradedoublerapi_options', 'tradedoubler_search_region');
    register_setting('affiliseo_tradedoublerapi_options', 'tradedoubler_image_import_type');
}

add_action('admin_init', 'tradedoubler_api_register_settings');