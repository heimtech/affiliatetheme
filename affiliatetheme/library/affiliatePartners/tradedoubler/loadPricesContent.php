<?php
require_once dirname(__FILE__).'/../styleDefinitions.php';
?>

<h1>Tradedoubler-Schnittstelle » Preise für bereits erstellte Produkte direkt von Tradedoubler erhalten</h1>

<p>
	Wenn Sie Hilfe beim Aktualisieren der Preise benötigen, klicken Sie 
	bitte auf den folgenden Link, um zu einer Anleitung auf AffiliSEO.de zu 
	gelangen. <br /> 
	<a
		href="http://affiliseo.de/dokumentation/tradedoubler-preise-importieren/"
		target="_blank" class="link-affiliseo"> 
		<i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> 
		zur Anleitung auf AffiliSEO.de
	</a>
</p>

<div class="alert alert-info">
	
	Für den Cronjob bitte folgende URL benutzen: 
	<a
		href="<?php echo site_url(); ?>/wp-content/themes/affiliatetheme/library/affiliatePartners/tradedoubler/cronRequest.php?secret=<?php echo md5(trim(get_option('tradedoubler_api_url'))); ?>"
		target="_blank">
		<strong>
			<?php echo site_url(); ?>/wp-content/themes/affiliatetheme/library/affiliatePartners/tradedoubler/cronRequest.php?secret=<?php echo md5(trim(get_option('tradedoubler_api_url'))); ?>
		</strong>
	</a>
</div>

<p>
	<b>HINWEIS:</b> Das Ändern der Partner ID zieht eine Veränderung der Affiliate-Links mit sich und passt 
	beim nächsten Preisabgleich alle links automatisch der neuen Partner-ID an.
</p>

<h2>Tradedoubler-Schnittstelle manuell ausf&uuml;hren</h2>

<button type="button" name="start_request" id="start_request" class="button-primary" style="">Ausf&uuml;hren</button>

<br>
<br>

<div id="data"></div>

<div class="clearfix"></div>

<p class="legal-text">
	<strong>Anmerkung des Entwicklers:</strong>
	<br /> Diese Software ist gem. § 69a Abs. 3 UrhG urheberrechtlich geschützt. Das Plagiieren und
	Verbreiten der Software oder von Codesegmenten stellt eine starfbare
	Handlung dar und kann eine Geld- oder Haftstrafe nach sich ziehen. Des
	Weiteren besteht seitens des Entwicklers ein Unterlassungsanspruch. Das
	Plagiieren und Verbreiten der Software oder von Codesegmenten kann
	kostenpflichtig abgemahnt werden. In diesem Fall behält sich der
	Entwickler die Beantragung einer einstweiligen Verfügung oder eine
	Unterlassungsklage vor.
</p>

<script type="text/javascript">

jQuery(document).ready(function ($) {
	
	jQuery("#start_request").click(function () {

		var secretKey = "<?php echo md5(esc_attr(get_option('tradedoubler_api_url'))); ?>";
		var blogurl = "<?php echo site_url(); ?>";

		jQuery('#data').html('<div class="spinner" style="display: block !important; float: left;"></div> Request wurde gestartet.');

		jQuery.ajax({
			type: "GET",
			data: {secret: secretKey},
			dataType: "html",
			url: blogurl + '/wp-content/themes/affiliatetheme/library/affiliatePartners/tradedoubler/cronRequest.php',
			success: function (data) {
				jQuery('#data').html(data);
			},
		});
	});	
});
</script>