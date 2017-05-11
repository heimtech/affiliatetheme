<?php

function belboon_api_options_page()
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
    <?php settings_fields('affiliseo_belboonapi_options'); ?>
    <?php do_settings_sections('affiliseo_balboonapi_options'); ?>
    
    <h1>Belboon-Schnittstelle » Einstellungen</h1>

		<p>
			Wenn Sie Hilfe bei der Einrichtung der Belboon-Schnittstelle
			benötigen, klicken Sie bitte auf den folgenden Link, um zu einer
			Anleitung auf AffiliSEO.de zu gelangen. <br /> <a
				href="http://affiliseo.de/dokumentation/einrichtung-der-belboon-schnittstelle/"
				target="_blank" class="link-affiliseo"> <i
				class="fa fa-youtube-play fa-2x fa-affiliseo"></i> zur Anleitung auf
				AffiliSEO.de
			</a> &nbsp;&nbsp;&nbsp;&nbsp; <a
				href="https://www.belboon.com/de/belboon-webservices.html"
				target="_blank" class="link-affiliseo"> <i
				class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Detaillierte
				API-Beschreibung bei Belboon
			</a>


		</p>

		<table class="widefat">

			<tbody>

				<tr>
					<td class="td-content" style="width: 450px;"><label
						for="belboon_username"> Username / Login</label> <br /> <small>Advertiser-Account-Benutzername</small>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="belboon_username"
						value="<?php echo esc_attr(get_option('belboon_username')); ?>" />
					</td>
				</tr>


				<tr>
					<td class="td-content"><label for="belboon_password">Passwort für
							Webservices</label> <br /> <small>WebService Passwort</small></td>
					<td class="td-content"><input type="text" class="widefat"
						name="belboon_password"
						value="<?php echo esc_attr(get_option('belboon_password')); ?>" />
						<br /> <small> <b>HINWEIS:</b> Das Ändern der Partner ID zieht
							eine Veränderung der Affiliate-Links mit sich und passt beim
							nächsten Preisabgleich alle links automatisch der neuen
							Partner-ID an.
					</small></td>
				</tr>

				<tr>
					<td class="td-content"><label for="belboon_wsdl"> WSDL für
							SmartFeed-Produktdaten - WebServices</label> <br />
					<small>Standardwert:
							http://smartfeeds.belboon.com/SmartFeedServices.php?wsdl</small>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="belboon_wsdl"
						value="<?php echo esc_attr(get_option('belboon_wsdl')); ?>" /></td>
				</tr>

				<tr>
					<td class="td-content"><label for="belboon_pdp_button">Affiliate-Button</label>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="belboon_pdp_button"
						value="<?php echo esc_attr(get_option('belboon_pdp_button')); ?>" />
						<br /> <small> z.B.: <b>Jetzt kaufen bei Belboon</b> oder <b>Jetzt
								bei {shop_name} kaufen</b><br /> Der Platzhalter <b>{shop_name}</b>
							wird ersetzt, wenn ein Shopname vorhanden ist
					</small></td>
				</tr>

				<tr>
					<td class="td-content"><label
						for="belboon_import_product_description">Produktbeschreibung
							importieren</label></td>
					<td class="td-content"><input
						name="belboon_import_product_description" type="checkbox"
						value="1"
						<?php checked( '1', get_option( 'belboon_import_product_description' ) ); ?> />
						Ja</td>
				</tr>
				
				<?php require_once dirname(__FILE__).'/../checkExtensions.php'; ?>
				
				<?php
    $partnerImageImportType = 'belboon_image_import_type';
    require_once dirname(__FILE__) . '/../partnerImageImportType.php';
    ?>
				
			</tbody>

			<tfoot>
				<tr>
					<th><input type="submit" name="submit" value="Speichern"
						class="button-primary" style="" /></th>
					<th><a class="button-primary"
						href="http://www1.belboon.de/adtracking/033c9e08c5660004eb00019f.html"
						target="_blank">Anmeldung Belboon*</a></th>
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

function belboon_api_register_settings()
{
    register_setting('affiliseo_belboonapi_options', 'belboon_username');
    register_setting('affiliseo_belboonapi_options', 'belboon_password');
    register_setting('affiliseo_belboonapi_options', 'belboon_wsdl');
    register_setting('affiliseo_belboonapi_options', 'belboon_pdp_button');
    register_setting('affiliseo_belboonapi_options', 'belboon_import_product_description');
    register_setting('affiliseo_belboonapi_options', 'belboon_image_import_type');
}

add_action('admin_init', 'belboon_api_register_settings');