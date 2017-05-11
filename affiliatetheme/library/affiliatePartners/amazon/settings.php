<?php

function amazon_api_options_page()
{
    ob_start();
    ?>
<div class="wrap">

	<style>
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

        <?php screen_icon(); ?>

        <form action="options.php" method="post">
            <?php settings_fields('affiliseo_amazonapi_options'); ?>
            <?php do_settings_sections('affiliseo_amazonapi_options'); ?>
            <h1>Amazon-Schnittstelle » Einstellungen</h1>
		<p>
			Wenn Sie Hilfe bei der Einrichtung der Amazon-Schnittstelle
			benötigen, klicken Sie bitte auf den folgenden Link, um zu einer
			Anleitung auf AffiliSEO.de zu gelangen. <br /> <a
				href="http://affiliseo.de/dokumentation/einrichtung-der-amazon-schnittstelle/"
				target="_blank" class="link-affiliseo"> <i
				class="fa fa-youtube-play fa-2x fa-affiliseo"></i> zur Anleitung auf
				AffiliSEO.de
			</a>
		</p>
		<table class="widefat">
			<tfoot>
				<tr>
					<th><input type="submit" name="submit" value="Speichern"
						class="button-primary" style="" /></th>
					<th><a class="button-primary" href="https://partnernet.amazon.de/"
						target="_blank">Anmeldung Amazon*</a></th>
				</tr>
				<tr>
					<th colspan="2" style="text-align: right;">* = Partnerlink</th>
				</tr>

			</tfoot>
			<tbody>
				<tr>
					<td class="td-content" style="width: 450px;"><label
						for="amazon_public_key">Public Key</label></td>
					<td class="td-content"><input type="text" class="widefat"
						name="amazon_public_key"
						value="<?php echo esc_attr(get_option('amazon_public_key')); ?>" />
					</td>
				</tr>

				<tr>
					<td class="td-content"><label for="amazon_secret_key">Secret Key</label>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="amazon_secret_key"
						value="<?php echo esc_attr(get_option('amazon_secret_key')); ?>" />
					</td>
				</tr>

				<tr>
					<td class="td-content"><label for="amazon_partner_id">Partner ID</label>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="amazon_partner_id"
						value="<?php echo esc_attr(get_option('amazon_partner_id')); ?>" />
						<br /> <small> <b>HINWEIS:</b> Das Ändern der Partner ID zieht
							eine Veränderung der Affiliate-Links mit sich und passt beim
							nächsten Preisabgleich alle links automatisch der neuen
							Partner-ID an.
					</small></td>
				</tr>

				<tr>
					<td class="td-content"><label for="ap_no_price">Fehlender Preis</label>
					</td>
					<td class="td-content">
                            <?php
    $no_price_type = get_option('ap_no_price');
    global $no_price_string;
    ?>
                            <select name="ap_no_price" id="ap_no_price"
						class="widefat">
							<option
								<?php if ($no_price_type === 'send_mail_and_deactivate') : ?>
								selected="selected" <?php endif; ?>
								value="send_mail_and_deactivate">E-Mail senden und Produkt
								deaktivieren</option>
							<option <?php if ($no_price_type === 'send_mail') : ?>
								selected="selected" <?php endif; ?> value="send_mail">E-Mail
								senden</option>
							<option <?php if ($no_price_type === 'deactivate') : ?>
								selected="selected" <?php endif; ?> value="deactivate">Produkt
								deaktivieren</option>
							<option <?php if ($no_price_type === 'send_mail_and_change') : ?>
								selected="selected" <?php endif; ?> value="send_mail_and_change">E-Mail senden und Preis durch "<?php echo $no_price_string; ?>" ersetzen</option>
							<option <?php if ($no_price_type === 'change') : ?>
								selected="selected" <?php endif; ?> value="change">Preis durch "<?php echo $no_price_string; ?>" ersetzen</option>
					</select> <br>
						<p style="color: #999">Bitte auswählen, was bei einem fehlenden
							Preis geschehen soll.</p>
					</td>
				</tr>

				<tr>
					<td class="td-content"><label for="ap_currency">Land</label></td>
					<td class="td-content">
                            <?php
    $ap_currency = get_option('ap_currency');
    ?>
                            <select name="ap_currency" id="ap_currency"
						class="widefat">
							<option <?php if ($ap_currency === 'de') : ?> selected="selected"
								<?php endif; ?> value="de">Deutschland</option>
							<option <?php if ($ap_currency === 'com.br') : ?>
								selected="selected" <?php endif; ?> value="com.br">Brazil</option>
							<option <?php if ($ap_currency === 'ca') : ?> selected="selected"
								<?php endif; ?> value="ca">Canada</option>
							<option <?php if ($ap_currency === 'cn') : ?> selected="selected"
								<?php endif; ?> value="cn">China</option>
							<option <?php if ($ap_currency === 'fr') : ?> selected="selected"
								<?php endif; ?> value="fr">France</option>
							<option <?php if ($ap_currency === 'in') : ?> selected="selected"
								<?php endif; ?> value="in">India</option>
							<option <?php if ($ap_currency === 'it') : ?> selected="selected"
								<?php endif; ?> value="it">Italy</option>
							<option <?php if ($ap_currency === 'co.jp') : ?>
								selected="selected" <?php endif; ?> value="co.jp">Japan</option>
							<option <?php if ($ap_currency === 'com.mx') : ?>
								selected="selected" <?php endif; ?> value="com.mx">Mexico</option>
							<option <?php if ($ap_currency === 'es') : ?> selected="selected"
								<?php endif; ?> value="es">Spain</option>
							<option <?php if ($ap_currency === 'co.uk') : ?>
								selected="selected" <?php endif; ?> value="co.uk">United Kingdom</option>
							<option <?php if ($ap_currency === 'com') : ?>
								selected="selected" <?php endif; ?> value="com">United States</option>
					</select>
					</td>
				</tr>

				<tr>
					<td class="td-content"><label for="amazon_pdp_button">Affiliate-Button</label>
					</td>
					<td class="td-content"><input type="text" class="widefat"
						name="amazon_pdp_button"
						value="<?php echo esc_attr(get_option('amazon_pdp_button')); ?>" />
						<br /> <small> z.B.: <b>Jetzt bei Amazon kaufen</b>
					</small></td>
				</tr>

				<tr>
					<td class="td-content"><label
						for="amazon_import_product_description">Produktbeschreibung
							importieren</label></td>
					<td class="td-content"><input
						name="amazon_import_product_description" type="checkbox" value="1"
						<?php checked( '1', get_option( 'amazon_import_product_description' ) ); ?> />
						Ja</td>
				</tr>
				
				<tr>
					<td class="td-content"><label
						for="amazon_import_star_rating">Sterne-Bewertung
							importieren</label></td>
					<td class="td-content">
					<?php
					$amazonImportStarRating = get_option( 'amazon_import_star_rating' );
					$amazonImportStarRatingChecked = ($amazonImportStarRating==1)?' checked="checked" ':'';
					?>
					<input
						name="amazon_import_star_rating" type="checkbox" value="1"
						<?php  echo $amazonImportStarRatingChecked; ?> />
						Ja&nbsp;&nbsp;
						
						<span style="color:red;">Wir weisen ausdrücklich darauf hin, dass der Sterne-Import seitens Amazon <b>NICHT</b> erwünscht ist.</span>
						
						</td>
				</tr>
					
					<?php
    
    require_once dirname(__FILE__) . '/../checkExtensions.php';
    
    $partnerImageImportType = 'amazon_image_import_type';
    require_once dirname(__FILE__) . '/../partnerImageImportType.php';
    ?>				

                </tbody>
		</table>
	</form>
</div>
<p
	style="color: #a94442; background-color: #f2dede; border-color: #ebccd1; padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px;">
	<strong>ACHTUNG!</strong> <br /> Wir haben in letzter Zeit häufiger
	feststellen müssen, dass Amazon falsche Preisangaben (z.B. 0,00 € oder
	1,00 €) zurückliefert. Sie können diesem Problem entgegenwirken, indem
	Sie den Preistyp des Produktes ändern. Sie haben hierbei die
	Möglichkeit zwischen dem niedrigsten Preis, dem niedrigsten Preis
	gebraucht, dem Listenpreis und der unverbindlichen Preisempfehlung zu
	wählen.<br /> Wenn Sie den Preistyp nicht ändern wollen, können Sie
	entscheiden, was bei einem fehlenden/falschen Preis geschehen soll.
	Ändern Sie hierzu die Einstellung unter "Fehlender Preis" in dem Feld
	über dem Text.<br /> <br /> Wenn Sie vermehrt falsche oder fehlende
	Preise von Amazon erhalten, wenden Sie sich bitte an den Support von
	Amazon.
</p>
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

function amazon_api_register_settings()
{
    register_setting('affiliseo_amazonapi_options', 'amazon_public_key');
    register_setting('affiliseo_amazonapi_options', 'amazon_secret_key');
    register_setting('affiliseo_amazonapi_options', 'amazon_partner_id');
    register_setting('affiliseo_amazonapi_options', 'amazon_produkte_posttype');
    register_setting('affiliseo_amazonapi_options', 'amazon_pid_customfield');
    register_setting('affiliseo_amazonapi_options', 'amazon_preis_customfield');
    register_setting('affiliseo_amazonapi_options', 'amazon_pricetype');
    register_setting('affiliseo_amazonapi_options', 'ap_no_price');
    register_setting('affiliseo_amazonapi_options', 'ap_currency');
    register_setting('affiliseo_amazonapi_options', 'amazon_pdp_button');
    register_setting('affiliseo_amazonapi_options', 'amazon_import_product_description');
    register_setting('affiliseo_amazonapi_options', 'amazon_import_star_rating');
    register_setting('affiliseo_amazonapi_options', 'amazon_image_import_type');
}

add_action('admin_init', 'amazon_api_register_settings');




