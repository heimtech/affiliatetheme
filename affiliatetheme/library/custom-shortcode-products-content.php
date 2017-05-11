<?php
$affiliseoOptions = getAffiliseoOptions();
?>
<div class="icons-content">

	<div class="full-size">
		<div class="col12">
			<h3>1. Horizontal, vertikal, Bestenliste, Miniaturansicht oder
				Produktsvergleichstabelle</h3>

			<label for="alignment"> Ausrichtung auswählen <br>
			</label> <select id="alignment" name="alignment">
				<option value="horizontal">horizontal</option>
				<option value="3">3-Spaltenansicht</option>
				<option value="4">4-Spaltenansicht</option>
				<option value="6">6-Spaltenansicht</option>
				<option value="highscore">Bestenliste</option>
				<option value="checklist">Produktsvergleichstabelle</option>
				
			</select>
		</div>
		<div class="clearfix"></div>
	</div>
	
	<div class="full-size">
		<div class="col12">
			<input id="slider" type="checkbox" name="slider"> 
			<label for="slider"> Produkte in Slider anzeigen? </label>			
		</div>
	</div>

	<div class="full-size">

		<div class="col12">
			<br />
			<h3>2. Wenn die Produktansicht eine Überschrift haben soll, können
				Sie diese hier eintragen</h3>

			<label for="headline_title"> Überschrift über Produktansicht (nicht
				für Bestenliste und Produktsvergleichstabelle) <br>
			</label> <input id="headline_title" type="text"
				placeholder="Überschrift" name="headline_title" />
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="full-size">

		<div class="col12">
			<br />
			<h3>3. Welche Produkte sollen angezeigt werden?</h3>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="full-size">
		<div class="col12">
			<label> nur Produkte mit den folgenden Marken anzeigen <br />
			</label>

			<div class="choice-block">
	                   
	                   <?php
                    $taxonomies = get_terms('produkt_marken');
                    foreach ($taxonomies as $taxonomy => $value) :
                        ?>
	                       <input id="<?php echo $value->slug; ?>"
					type="checkbox" name="marken"> <label
					for="<?php echo $value->slug; ?>">
	                           <?php echo $value->name; ?>
	                       </label> <br />
	                       <?php
                    endforeach
                    ;
                    ?>
                    </div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="full-size">
		<div class="col12">
			<br /> <label> nur Produkte mit den folgenden Typen anzeigen <br />
			</label>
			<div class="choice-block">
	                   
	                   <?php
                    $taxonomies = get_terms('produkt_typen');
                    foreach ($taxonomies as $taxonomy => $value) :
                        ?>
	                       <input id="<?php echo $value->slug; ?>"
					type="checkbox" name="typen"> <label
					for="<?php echo $value->slug; ?>">
	                           <?php echo $value->name; ?>
	                       </label> <br />
	                       <?php
                    endforeach
                    ;
                    ?>
                    </div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="full-size">
		<div class="col12">
			
	                   
	                   <?php
                    global $wpdb;
                    $taxonomies_table = $wpdb->prefix . "taxonomies";
                    $res = $wpdb->get_results('SELECT * FROM ' . $taxonomies_table, OBJECT);
                    
                    if (count($res) > 0) {
                        foreach ($res as $mytax) {
                            
                            $taxonomySlug = 'produkt_'.$mytax->taxonomy_slug;
                            $taxonomyPlural = $mytax->taxonomy_plural;
                            
                            ?>
                            <br /> <label> nur Produkte mit der
				folgenden Produktkategorie <b><?php echo $taxonomyPlural;?></b>
				anzeigen <br />
			</label>
			<div class="choice-block">
			<?php
                            $taxonomies = get_terms($taxonomySlug);
                            foreach ($taxonomies as $taxonomy => $value) :
                                ?>
				                       <input id="<?php echo $taxonomySlug; ?>__<?php echo $value->slug; ?>"
					type="checkbox" name="custom_taxonomies"> <label
					for="<?php echo $value->slug; ?>">
				                           <?php echo $value->name; ?>
				                       </label> <br />
				                       <?php
                            endforeach
                            ;
                            ?>
			
			</div>
                            <?php
                        }
                    }                    
                    ?>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="full-size">
		<div class="col12">
			<br /> <label for="ids"> nur die folgenden Produkte anzeigen <br>
			</label>

			<div class="choice-block">
	                   <?php
                    $args = array(
                        'post_type' => 'produkt'
                    );
                    $pages = get_pages($args);
                    
                    foreach ($pages as $page) :
                        $title = $page->post_title;
                        $id = $page->ID;
                        
                        ?>
	                       <input id="<?php echo $id ?>" type="checkbox"
					name="ids"> <label for="<?php echo $id; ?>">
	                           <?php echo $title; ?>
	                       </label> <br />
	                       <?php
                    endforeach
                    ;
                    ?>
                    </div>

		</div>
		<div class="clearfix"></div>
	</div>

	<div class="full-size">
		<div class="col12">
			<br /> <label for="limit"> Anzahl maximal angezeigter Produkte
				(Standard ist 6. Tragen Sie eine 0 ein, um unendlich viele Produkte
				anzuzeigen.) <br>
			</label> <input type="text" id="limit" name="limit"
				placeholder="Limit">
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="full-size">
		<div class="col12">
			<br>
			<h3>4. Sortieren der Produkte?</h3>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="full-size">
		<div class="col12">
			<label for="orderby"> sortieren nach <br>
			</label> <select id="orderby" name="orderby">
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
			<h3>5. Zusätzliche Attribute</h3>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="full-size">
		<div class="col12">
			<input id="ad" type="checkbox" checked="checked" name="ad"> <label
				for="ad"> Werbung anzeigen </label> <br />
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="full-size">
		<div class="col12">
			<input id="mini" type="checkbox" checked="checked" name="mini"> <label
				for="mini"> Produktansicht mit Hover-Effekt (funktioniert nicht bei
				horizontal, Bestenliste und Vergleichstabelle) </label> <br />
		</div>
		<div class="clearfix"></div>
	</div>
	
	<div class="full-size">
		<div class="col12">
			<input id="add_clearfix" type="checkbox" checked="checked" name="add_clearfix"> <label
				for="add_clearfix"> Zeilenumbruch erzwingen? (Wird für den Page Builder benötigt.)</label> <br />
		</div>
		<div class="clearfix"></div>
	</div>

	<br />

	<button id="sc-products-button"
		class="custom-shortcode-generate-button" type="button">Produkt-Shortcode
		generieren</button>
</div>
