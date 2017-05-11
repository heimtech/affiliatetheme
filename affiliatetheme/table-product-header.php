<div class="box">
	<table class="table table-striped">
		<thead>
			<tr>
				<?php
    if (isOptionEnabled('highscore_platzierung_ausblenden')) {
        echo '<th></th>';
    }
    
    if (isOptionEnabled('highscore_bild_ausblenden')) {
        
        echo '<th>' . strtoupper(__('Image', 'affiliatetheme')) . '</th>';
    }
    
    echo '<th>' . strtoupper(__('Product', 'affiliatetheme')) . '</th>';
    
    if (isOptionEnabled('highscore_bewertung_ausblenden') && !isOptionEnabled('hide_star_rating', true)) {
        
        echo '<th>' . strtoupper(__('Review', 'affiliatetheme')) . '</th>';
    }
    
    if (isOptionEnabled('highscore_beschreibung_ausblenden')) {
        
        echo '<th>' . strtoupper(__('Description', 'affiliatetheme')) . '</th>';
    }
    
    if (!isOptionEnabled('allg_preise_ausblenden')) {
        
        echo '<th>' . strtoupper(__('Price', 'affiliatetheme')) . '</th>';
    }
    
    if (isOptionEnabled('highscore_angebot_ausblenden')) {
        
        echo '<th>' . strtoupper(__('Offer', 'affiliatetheme')) . '</th>';
    }
    ?>
			</tr>
		</thead>
		<tbody>