<?php

function zanox_api_options_page()
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
    <?php settings_fields('affiliseo_zanoxapi_options'); ?>
    <?php do_settings_sections('affiliseo_zanoxapi_options'); ?>
    
    <h1>Zanox-Schnittstelle » Einstellungen</h1>

		<p>
			Wenn Sie Hilfe bei der Einrichtung der Zanox-Schnittstelle benötigen,
			klicken Sie bitte auf den folgenden Link, um zu einer Anleitung auf
			AffiliSEO.de zu gelangen. <br /> <a
				href="http://affiliseo.de/dokumentation/einrichtung-der-zanox-schnittstelle/"
				target="_blank" class="link-affiliseo"> <i
				class="fa fa-youtube-play fa-2x fa-affiliseo"></i> zur Anleitung auf
				AffiliSEO.de
			</a>
		</p>

		<table class="widefat">

			<tbody>

				<tr>
					<td style="width: 450px;" class="td-content"><label
						for="zanox_connect_id"> Connect ID</label></td>
					<td class="td-content"><input type="text" class="widefat"
						name="zanox_connect_id"
						value="<?php echo esc_attr(get_option('zanox_connect_id')); ?>" />
					</td>
				</tr>


				<tr>
					<td class="td-content"><label for="zanox_secret_key">Secret Key</label>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="zanox_secret_key"
						value="<?php echo esc_attr(get_option('zanox_secret_key')); ?>" />
						<br /> <small> <b>HINWEIS:</b> Das Ändern der Partner ID zieht
							eine Veränderung der Affiliate-Links mit sich und passt beim
							nächsten Preisabgleich alle links automatisch der neuen
							Partner-ID an.
					</small></td>
				</tr>

				<tr>
					<td class="td-content"><label for="zanox_search_region">Region</label>
					</td>
					<td class="td-content"><select name="zanox_search_region">
							<?php
    $regions = array(
        "DE" => "Deutschland",
        "GB" => "England",
        "FR" => "Frankreich",
        "ES" => "Spanien",
        "NL" => "Niederlande",
        "AT" => "&Ouml;sterreich",
        "CH" => "Schweiz"
    );
    foreach ($regions as $key => $region) {
        echo '<option value="' . $key . '" ' . setSelect($key, esc_attr(get_option('zanox_search_region'))) . '>' . $region . '</option>';
    }
    ?>
						</select></td>
				</tr>

				<tr>
					<td class="td-content"><label for="zanox_pdp_button">Affiliate-Button</label>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="zanox_pdp_button"
						value="<?php echo esc_attr(get_option('zanox_pdp_button')); ?>" />
						<br /> <small> z.B.: <b>Jetzt kaufen bei Zanox</b> oder <b>Jetzt
								bei {shop_name} kaufen</b><br /> Der Platzhalter <b>{shop_name}</b>
							wird ersetzt, wenn ein Shopname vorhanden ist
					</small></td>
				</tr>

				<tr>
					<td class="td-content"><label
						for="zanox_import_product_description">Produktbeschreibung
							importieren</label></td>
					<td class="td-content"><input
						name="zanox_import_product_description" type="checkbox" value="1"
						<?php checked( '1', get_option( 'zanox_import_product_description' ) ); ?> />
						Ja</td>
				</tr>
				
				<?php require_once dirname(__FILE__).'/../checkExtensions.php'; ?>
				
				<?php
    $partnerImageImportType = 'zanox_image_import_type';
    require_once dirname(__FILE__) . '/../partnerImageImportType.php';
    ?>

			</tbody>

			<tfoot>
				<tr>
					<th><input type="submit" name="submit" value="Speichern"
						class="button-primary" style="" /></th>
					<th><a class="button-primary" href="http://zanox.com/de/"
						target="_blank">Anmeldung Zanox*</a></th>
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

function zanox_api_register_settings()
{
    register_setting('affiliseo_zanoxapi_options', 'zanox_secret_key');
    register_setting('affiliseo_zanoxapi_options', 'zanox_connect_id');
    register_setting('affiliseo_zanoxapi_options', 'zanox_search_region');
    register_setting('affiliseo_zanoxapi_options', 'zanox_pdp_button');
    register_setting('affiliseo_zanoxapi_options', 'zanox_import_product_description');
    register_setting('affiliseo_zanoxapi_options', 'zanox_image_import_type');
}

add_action('admin_init', 'zanox_api_register_settings');