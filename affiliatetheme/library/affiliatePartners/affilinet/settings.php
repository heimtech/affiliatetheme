<?php

function affilinet_api_options_page()
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
    <?php settings_fields('affiliseo_affilinetapi_options'); ?>
    <?php do_settings_sections('affiliseo_affilinetapi_options'); ?>
    
    <h1>Affilinet-Schnittstelle » Einstellungen</h1>

		<p>
			Wenn Sie Hilfe bei der Einrichtung der Affilinet-Schnittstelle
			benötigen, klicken Sie bitte auf den folgenden Link, um zu einer
			Anleitung auf AffiliSEO.de zu gelangen. <br /> <a
				href="http://affiliseo.de/dokumentation/einrichtung-der-affilinet-schnittstelle/"
				target="_blank" class="link-affiliseo"> <i
				class="fa fa-youtube-play fa-2x fa-affiliseo"></i> zur Anleitung auf
				AffiliSEO.de
			</a> &nbsp;&nbsp;&nbsp;&nbsp; <a
				href="https://www.affili.net/de/knowledge-zone/developer-portal"
				target="_blank" class="link-affiliseo"> <i
				class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Detaillierte
				API-Beschreibung bei Affilnet
			</a>

		</p>

		<table class="widefat">

			<tbody>

				<tr>
					<td class="td-content" style="width: 450px;"><label
						for="affilinet_publisher_id"> PublisherID</label></td>
					<td class="td-content"><input type="text" class="widefat"
						name="affilinet_publisher_id"
						value="<?php echo esc_attr(get_option('affilinet_publisher_id')); ?>" />
					</td>
				</tr>


				<tr>
					<td class="td-content"><label for="affilinet_publisher_password">
							Publisher Webservice-Passwort</label></td>
					<td class="td-content"><input type="text" class="widefat"
						name="affilinet_publisher_password"
						value="<?php echo esc_attr(get_option('affilinet_publisher_password')); ?>" />
					</td>
				</tr>


				<tr>
					<td class="td-content"><label for="affilinet_product_password">
							Produkt Webservice-Passwort</label></td>
					<td class="td-content"><input type="text" class="widefat"
						name="affilinet_product_password"
						value="<?php echo esc_attr(get_option('affilinet_product_password')); ?>" />
						<br /> <small> <b>HINWEIS:</b> Das Ändern der Partner ID zieht
							eine Veränderung der Affiliate-Links mit sich und passt beim
							nächsten Preisabgleich alle links automatisch der neuen
							Partner-ID an.
					</small></td>
				</tr>

				<tr>
					<td class="td-content"><label for="affilinet_logon_wsdl"> WSDL für
							Product Authentication Webservice </label> <br /> <small>Standardwert:
							http://product-api.affili.net/Authentication/Logon.svc?wsdl</small>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="affilinet_logon_wsdl"
						value="<?php echo esc_attr(get_option('affilinet_logon_wsdl')); ?>" />
					</td>
				</tr>

				<tr>
					<td class="td-content"><label for="affilinet_products_wsdl"> WSDL
							für Produkservice</label> <br /> <small>Standardwert:
							https://product-api.affili.net/V3/WSDLFactory/Product_ProductData.wsdl</small>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="affilinet_products_wsdl"
						value="<?php echo esc_attr(get_option('affilinet_products_wsdl')); ?>" />
					</td>
				</tr>

				<tr>
					<td class="td-content"><label for="affilinet_pdp_button">Affiliate-Button</label>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="affilinet_pdp_button"
						value="<?php echo esc_attr(get_option('affilinet_pdp_button')); ?>" />
						<br /> <small> z.B.: <b>Jetzt kaufen bei Affilinet</b> oder <b>Jetzt
								bei {shop_name} kaufen</b><br /> Der Platzhalter <b>{shop_name}</b>
							wird ersetzt, wenn ein Shopname vorhanden ist
					</small></td>
				</tr>

				<tr>
					<td class="td-content"><label
						for="affilinet_import_product_description">Produktbeschreibung
							importieren</label></td>
					<td class="td-content"><input
						name="affilinet_import_product_description" type="checkbox"
						value="1"
						<?php checked( '1', get_option( 'affilinet_import_product_description' ) ); ?> />
						Ja</td>
				</tr>
				
				<?php require_once dirname(__FILE__).'/../checkExtensions.php'; ?>
				
				<?php
    $partnerImageImportType = 'affilinet_image_import_type';
    require_once dirname(__FILE__) . '/../partnerImageImportType.php';
    ?>				

			</tbody>

			<tfoot>
				<tr>
					<th><input type="submit" name="submit" value="Speichern"
						class="button-primary" style="" /></th>
					<th><a class="button-primary" href="http://www.affili.net/de/home"
						target="_blank">Anmeldung Affilinet*</a></th>
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

function affilinet_api_register_settings()
{
    register_setting('affiliseo_affilinetapi_options', 'affilinet_publisher_id');
    register_setting('affiliseo_affilinetapi_options', 'affilinet_publisher_password');
    register_setting('affiliseo_affilinetapi_options', 'affilinet_product_password');
    
    register_setting('affiliseo_affilinetapi_options', 'affilinet_logon_wsdl');
    register_setting('affiliseo_affilinetapi_options', 'affilinet_products_wsdl');
    register_setting('affiliseo_affilinetapi_options', 'affilinet_pdp_button');
    register_setting('affiliseo_affilinetapi_options', 'affilinet_import_product_description');
    register_setting('affiliseo_affilinetapi_options', 'affilinet_image_import_type');
}

add_action('admin_init', 'affilinet_api_register_settings');