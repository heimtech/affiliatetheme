<?php
require_once dirname(__FILE__).'/../styleDefinitions.php';
?>

<h1>Amazon-Schnittstelle » Preise für bereits erstellte Produkte direkt
	von Amazon erhalten</h1>
<p>
	Wenn Sie Hilfe beim Aktualisieren der Preise benötigen, klicken Sie
	bitte auf den folgenden Link, um zu einer Anleitung auf AffiliSEO.de zu
	gelangen. <br /> <a
		href="http://affiliseo.de/dokumentation/amazon-preise-importieren/"
		target="_blank" class="link-affiliseo"> <i
		class="fa fa-youtube-play fa-2x fa-affiliseo"></i> zur Anleitung auf
		AffiliSEO.de
	</a>
</p>
<div class="alert alert-info">
	Für den Cronjob bitte folgende URL benutzen: <a
		href="<?php echo site_url(); ?>/wp-content/themes/affiliatetheme/library/affiliatePartners/amazon/cronRequest.php?secret=<?php echo md5(trim(get_option('amazon_public_key'))); ?>"
		target="_blank"><strong><?php echo site_url(); ?>/wp-content/themes/affiliatetheme/library/affiliatePartners/amazon/cronRequest.php?secret=<?php echo md5(trim(get_option('amazon_public_key'))); ?></strong>
	</a> <a href="<?php echo site_url(); ?>" id="blogurl"
		style="display: none;"></a>
</div>

<p>
	<b>HINWEIS:</b> Das Ändern der Partner ID zieht eine Veränderung der Affiliate-Links mit sich und passt 
	beim nächsten Preisabgleich alle links automatisch der neuen Partner-ID an.
</p>

<h2>Amazon-Schnittstelle manuell ausf&uuml;hren</h2>
<button type="button" name="start_request" id="start_request"
	class="button-primary" style="">Ausf&uuml;hren</button>
<br>
<br>

<div style="display: none;" id="public_key"><?php echo md5(esc_attr(get_option('amazon_public_key'))); ?></div>
<div id="data"></div>
<div class="clearfix"></div>
<p
	style="color: #8a6d3b; background-color: #fcf8e3; border-color: #faebcc; padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px;">
	<strong>Anmerkung des Entwicklers:</strong><br /> Diese Software ist
	gem. § 69a Abs. 3 UrhG urheberrechtlich geschützt. Das Plagiieren und
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
	$("#start_request").click(function () {
		var blogurl = $('#blogurl').attr('href');
		var secretKey = $('#public_key').text();

		$('#data').html('<div class="spinner" style="display: block !important; float: left;"></div> Request wurde gestartet.');

		$.ajax({
			type: "GET",
			data: {secret: secretKey},
			dataType: "html",
			url: blogurl + '/wp-content/themes/affiliatetheme/library/affiliatePartners/amazon/cronRequest.php',
			success: function (data) {
				$('#data').html(data);
			},
		});
	});
});
</script>