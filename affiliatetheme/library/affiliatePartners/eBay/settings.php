<?php

function eBay_api_options_page()
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
    <?php settings_fields('affiliseo_eBayapi_options'); ?>
    <?php do_settings_sections('affiliseo_eBayapi_options'); ?>
    
    <h1>eBay-Schnittstelle » Einstellungen</h1>

		<p>
			Wenn Sie Hilfe bei der Einrichtung der eBay-Schnittstelle benötigen,
			klicken Sie bitte auf den folgenden Link, um zu einer Anleitung auf
			AffiliSEO.de zu gelangen. <br /> <a
				href="http://affiliseo.de/dokumentation/einrichtung-der-eBay-schnittstelle/"
				target="_blank" class="link-affiliseo"> <i
				class="fa fa-youtube-play fa-2x fa-affiliseo"></i> zur Anleitung auf
				AffiliSEO.de
			</a> &nbsp;&nbsp;&nbsp;&nbsp; <a
				href="http://developer.ebay.com/Devzone/finding/HowTo/index.html"
				target="_blank" class="link-affiliseo"> <i
				class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Detaillierte
				API-Beschreibung bei eBay
			</a>
		</p>

		<table class="widefat">

			<tbody>

				<tr>
					<td class="td-content" style="width: 450px;"><label
						for="eBay_service_endpoint"> eBay Webservice-URL</label> <br /> <small>Standardwert:
							https://svcs.ebay.com/services/search/FindingService/v1</small></td>
					<td class="td-content"><input type="text" class="widefat"
						name="eBay_service_endpoint"
						value="<?php echo esc_attr(get_option('eBay_service_endpoint')); ?>" />
					</td>
				</tr>

				<tr>
					<td class="td-content" style="width: 430px;"><label
						for="eBay_api_version"> eBay Webservice API-Version</label> <br />
						<small>Standardwert: 1.0.0</small></td>
					<td class="td-content"><input type="text" class="widefat"
						name="eBay_api_version"
						value="<?php echo esc_attr(get_option('eBay_api_version')); ?>" />
					</td>
				</tr>

				<tr>
					<td class="td-content" style="width: 430px;"><label
						for="eBay_global_id"> eBay Webservice Global ID</label> <br /> <small></small>
					</td>
					<td class="td-content"><select name="eBay_global_id">
							<?php
    $regions = array(
        "EBAY-DE" => "eBay Deutschland",
        "EBAY-GB" => "eBay England",
        "EBAY-FR" => "eBay Frankreich",
        "EBAY-ES" => "eBay Spanien",
        "EBAY-NL" => "eBay Niederlande",
        "EBAY-AT" => "eBay &Ouml;sterreich",
        "EBAY-CH" => "eBay Schweiz"
    );
    foreach ($regions as $key => $region) {
        echo '<option value="' . $key . '" ' . setSelect($key, esc_attr(get_option('eBay_global_id'))) . '>' . $region . '</option>';
    }
    ?>
						</select></td>
				</tr>


				<tr>
					<td class="td-content"><label for="eBay_app_id"> APP-ID für die
							eBay-Schnitstelle</label> <br /> <small></small></td>
					<td class="td-content"><input type="text" class="widefat"
						name="eBay_app_id"
						value="<?php echo esc_attr(get_option('eBay_app_id')); ?>" /></td>
				</tr>

				<tr>
					<td class="td-content"><label for="eBay_campaign_id"> Kampagnen-ID</label>
						<br /> <small>ID für die eBay Standardkampagne</small></td>
					<td class="td-content"><input type="text" class="widefat"
						name="eBay_campaign_id"
						value="<?php echo esc_attr(get_option('eBay_campaign_id')); ?>" />
					</td>
				</tr>

				<tr>
					<td class="td-content"><label for="eBay_custom_id">
							Benutzerdefinierte Affiliate-ID</label> <br /> <small>eine
							Benutzerdefinierte ID z.B. affiliseoebay</small></td>
					<td class="td-content"><input type="text" class="widefat"
						name="eBay_custom_id"
						value="<?php echo esc_attr(get_option('eBay_custom_id')); ?>" /> <br />
						<small> <b>HINWEIS:</b> Das Ändern der Partner ID zieht eine
							Veränderung der Affiliate-Links mit sich und passt beim nächsten
							Preisabgleich alle links automatisch der neuen Partner-ID an.
					</small></td>
				</tr>

				<tr>
					<td class="td-content"><label for="eBay_pdp_button">Affiliate-Button</label>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="eBay_pdp_button"
						value="<?php echo esc_attr(get_option('eBay_pdp_button')); ?>" />
						<br /> <small> z.B.: <b>Jetzt kaufen bei eBay</b> oder <b>Jetzt
								bei {shop_name} kaufen</b><br /> Der Platzhalter <b>{shop_name}</b>
							wird ersetzt, wenn ein Shopname vorhanden ist
					</small></td>
				</tr>

				<tr>
					<td class="td-content"><label for="eBay_import_product_description">Produktbeschreibung
							importieren</label></td>
					<td class="td-content"><input
						name="eBay_import_product_description" type="checkbox" value="1"
						<?php checked( '1', get_option( 'eBay_import_product_description' ) ); ?> />
						Ja</td>
				</tr>
				
				<?php require_once dirname(__FILE__).'/../checkExtensions.php'; ?>
				
				<?php
    $partnerImageImportType = 'eBay_image_import_type';
    require_once dirname(__FILE__) . '/../partnerImageImportType.php';
    ?>

			</tbody>

			<tfoot>
				<tr>
					<th><input type="submit" name="submit" value="Speichern"
						class="button-primary" style="" /></th>
					<th><a class="button-primary"
						href="https://publisher.ebaypartnernetwork.ebay.com/files/hub/de-DE/migrationHub.html"
						target="_blank">Anmeldung eBay*</a></th>
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

function eBay_api_register_settings()
{
    register_setting('affiliseo_eBayapi_options', 'eBay_service_endpoint');
    register_setting('affiliseo_eBayapi_options', 'eBay_app_id');
    register_setting('affiliseo_eBayapi_options', 'eBay_api_version');
    register_setting('affiliseo_eBayapi_options', 'eBay_global_id');
    register_setting('affiliseo_eBayapi_options', 'eBay_campaign_id');
    register_setting('affiliseo_eBayapi_options', 'eBay_custom_id');
    register_setting('affiliseo_eBayapi_options', 'eBay_pdp_button');
    register_setting('affiliseo_eBayapi_options', 'eBay_import_product_description');
    register_setting('affiliseo_eBayapi_options', 'eBay_image_import_type');
}

add_action('admin_init', 'eBay_api_register_settings');