<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jan Sussujew
 * Date: 27.08.2014
 * Time: 14:13
 */
global $affiliseo_options;

$platzierung = $affiliseo_options['highscore_platzierung_ausblenden'];
$bild = $affiliseo_options['highscore_bild_ausblenden'];
$bewertung = $affiliseo_options['highscore_bewertung_ausblenden'];
$beschreibung = $affiliseo_options['highscore_beschreibung_ausblenden'];
$angebot = $affiliseo_options['highscore_angebot_ausblenden'];
?>
<div class="box">

	<table class="table table-striped">
		<thead>
			<tr>
				<?php if ( $platzierung == 1 ) : ?><th></th><?php endif; ?>
				<?php if ( $bild == 1 ) : ?><th><?php echo strtoupper(__('Image','affiliatetheme')); ?></th><?php endif; ?>
				<th><?php echo strtoupper(__('Product','affiliatetheme')); ?></th>
				<?php
				
				if ( $bewertung == 1 && (!isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating']!=1)) {
				?>
					<th><?php echo strtoupper(__('Review','affiliatetheme')); ?></th>
					<?php
                }
				 
				?>
				<?php if ( $beschreibung == 1 ) : ?><th><?php echo strtoupper(__('Description','affiliatetheme')); ?></th><?php endif; ?>
				<?php if ( $affiliseo_options['allg_preise_ausblenden'] != 1 ) : ?>
					<th><?php echo strtoupper(__('Price','affiliatetheme')); ?></th>
				<?php endif; ?>
					<?php if ( $angebot == 1 ) : ?><th><?php echo strtoupper(__('Offer','affiliatetheme')); ?></th><?php endif; ?>
			</tr>
		</thead>
		<tbody>