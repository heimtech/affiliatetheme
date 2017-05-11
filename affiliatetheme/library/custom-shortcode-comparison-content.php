<?php
$ComparisonAttributes = new ComparisonAttributes();

$affiliseoOptions = getAffiliseoOptions();

$productTypes = $ComparisonAttributes->getProductTypes();
?>

<div class="icons-content">
	
	<div class="full-size">
		<div class="col12">
			<br />
			<h3>1. Welche Produkte sollen angezeigt werden?</h3>
		</div>
		<div class="clearfix"></div>
	</div>
	
	<?php
	
	foreach ($productTypes as $productType) {
	    
	    ?>
	    <div class="full-size">
	    	<div class="col12">
	    		<label style="display: block; margin: 5px; padding: 2px;"> <b>nur Produkte mit dem Produkttyp: <?php echo $productType->name; ?></b></label>
	    		
	    		
	    		<input
	    			class="check-all-products" 
	    			id="post-<?php echo $productType->slug; ?>"
	    			type="checkbox"
	    			name="comparison-products" 
	    			value="<?php echo $productType->slug; ?>" />
	    		
	    		<label for="post-<?php echo $productType->slug; ?>"> 
					alle Produkte dieser Gruppe</label>
				<br />
				
				<div class="choice-block">
					<?php
					$args = array(
					    'post_type' => 'produkt',
					    'produkt_typen' => $productType->slug,
					    'nopaging' => true
					);
					$query = new WP_Query($args);
					$posts = $query->get_posts();
					
					foreach ($posts as $post) {
					    $postSuffix = (strlen($post->post_name) >110)?'...':'';
					    ?>
					    
					    <input
					    	id="post-<?php echo $post->ID; ?>"
					    	type="checkbox"
					    	class="comparison-products <?php echo $productType->slug; ?>"
					    	name="comparison-products" 
					    	value="<?php echo $post->ID; ?>" />
					    	
					    <label for="post-<?php echo $post->ID; ?>">
					    	<?php echo substr($post->post_name,0,110) . $postSuffix; ?>
					    </label>
					    <br />
					    
					    <?php
					}
				    ?>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<?php
		}
		?>
		
		<div class="full-size">
			<div class="col12">
				<br /> 
				<label for="comparison-limit"> 
					Anzahl maximal angezeigter Produkte (Standard ist 6. Tragen Sie eine 0 ein, 
					um unendlich viele Produkte anzuzeigen.) <br>
				</label> 
				
				<input 
					type="text" 
					id="comparison-limit" 
					name="comparison-limit"
					placeholder="Limit" />
			</div>
			<div class="clearfix"></div>
		</div>
		
		<div class="full-size">
		<div class="col12">
			<br>
			<h3>2. Sortieren der Produkte?</h3>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="full-size">
		<div class="col12">
			<label for="comparison-orderby"> sortieren nach <br>
			</label> <select id="comparison-orderby" name="comparison-orderby">
				<option value="none">keine Sortierung</option>
				<?php
				if( !isset($affiliseoOptions['hide_star_rating']) || $affiliseoOptions['hide_star_rating']!=1 ){
				?>
				<option value="sterne_bewertung">Sterne-Bewertung</option>
				<?php
				}
				?>
				<option value="interne_bewertung">Interne Bewertung</option>
				<option value="price"><?php echo __('Price','affiliatetheme'); ?></option>
				<option value="title">Titel</option>
				<option value="date">Erstellungsdatum</option>
				<option value="modified">zuletzt geändert</option>
				<option value="rand">zufällig</option>
			</select>
		</div>
		<div class="clearfix"></div>
	</div>
	<br />
	<div class="full-size">
		<div class="col12">
			<label for="order"> In welcher Reihenfolge soll sortiert werden? <br>
			</label> <input type="radio" name="order" value="ASC" id="ASC"> <label
				for="ASC">ASC (aufsteigend)</label> <br> <input type="radio"
				name="order" value="DESC" id="DESC"> <label for="DESC">DESC
				(absteigend)</label>
		</div>
		<div class="clearfix"></div>
	</div>
	
	
	<div class="full-size">
		<div class="col12">
			<br>
			<h3>3. Vergleichsfunktion?</h3>
		</div>
		<div class="clearfix"></div>
	</div>
	
	<div class="full-size">
		<div class="col12">
			<input type="radio" name="compare" value="active" checked="checked" /> 
			<label>aktiviert</label> 
			
			<input type="radio" name="compare" value="inactive" /> 
			<label> deaktiviert </label>
		</div>
		<div class="clearfix"></div>
	</div>
	
	<div class="full-size">
		<div class="col12">
			<br>
			<h3>4. Tabellenkopfzeile</h3>
		</div>
		<div class="clearfix"></div>
	</div>
	
	<div class="full-size">
		<div class="col12">
		
			<input type="radio" name="header_position" value="scroll" checked="checked" /> 
			<label> scrollt mit </label>
			
			<input type="radio" name="header_position" value="fixed"  /> 
			<label>bleibt fixiert</label><br /> 
			<span style="color: red;">
				<b>Bei mehr als eine Tabelle in einer gleichen Seite ist das Scrollen nicht möglich! </b>
			</span>
		</div>
		<div class="clearfix"></div>
	</div>

	<br />

	<button id="sc-comparison-button"
		class="custom-shortcode-generate-button" type="button">Produkt-Shortcode
		generieren</button>
</div>
