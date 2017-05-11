<div class="icons-content">

	<div class="full-size">
		<div class="col12">
			<h3>1. Blogbeitrag Ansicht auswählen</h3>

			<div>

				<div class="posts-templates">
					<div>
						<input type="radio" value="1" name="selected_template"
							checked="checked"> Template 1<br> <img
							src="../wp-content/themes/affiliatetheme/library/admin/images/posts_template1.png"
							alt="">
					</div>
					<div class="clearfix"></div>

					<div>
						<input type="radio" value="2" name="selected_template"> Template 2<br>
						<img
							src="../wp-content/themes/affiliatetheme/library/admin/images/posts_template2.png"
							alt="">
					</div>

				</div>
				<div class="posts-templates">
					<div>
						<input type="radio" value="3" name="selected_template"> Template 3<br>
						<img
							src="../wp-content/themes/affiliatetheme/library/admin/images/posts_template3.png"
							alt="">
					</div>
				</div>
				
				<div class="posts-templates">
				    <div>
						<input type="radio" value="4" name="selected_template"> Template 4<br>
						<img
							src="../wp-content/themes/affiliatetheme/library/admin/images/posts_template4.png"
							alt="">
					</div>
					<div class="clearfix"></div>
					<div>
						<input type="radio" value="5" name="selected_template"> Template 5<br>
						<img
							src="../wp-content/themes/affiliatetheme/library/admin/images/posts_template5.png"
							alt="">
					</div>
				</div>

			</div>

			<div class="clearfix"></div>

			<div style="border-top: 1px solid #ddd;">
				<input type="number" min="0" max="140" step="1" value="70"
					id="tpl_headline_length" name="tpl_headline_length"
					style="width: 60px;" /> max. Zeichen für Überschrift <br /> 
					
					<input
					type="number" id="tpl_short_text_length" name="tpl_short_text_length" min="0"
					max="500" step="1" value="300" style="width: 60px;" /> max.
				Zeichen für Beitragsinhalte in <strong>kleinen</strong> Beitragsboxen z.B. in Template 1, Template 2 oder Template 4<br />
				
				<input
					type="number" id="tpl_long_text_length" name="tpl_long_text_length" min="0"
					max="1000" step="1" value="500" style="width: 60px;" /> max.
				Zeichen für Beitragsinhalte in <strong>gro&szlig;en</strong> Beitragsboxen z.B. in Template 2, Template 3, Template 4 oder Template 5
			</div>

		</div>


		<div class="clearfix"></div>
	</div>

	<div class="full-size">
		<div class="col12">
			<h3>2. Welche Beiträge sollen angezeigt werden?</h3>

			<div class="choice-block">
			
			 <?php
    $args = array(
        'post_type' => 'post',
        'numberposts' => - 1,
        'post_status' => 'publish'
    );
    
    $posts = get_posts($args);
    foreach ($posts as $key => $value) :
        
        ?>
			     <input id="selected_posts_<?php echo $value->ID; ?>"
					type="checkbox" name="selected_posts"
					value="<?php echo $value->ID; ?>" /> <label
					for="post_<?php echo $value->ID; ?>">
			         <?php echo $value->post_title; ?>
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
			<h3>3. Nur die Folgende Kategorie anzeigen</h3>

			<div class="choice-block">

				<input id="-1" type="radio" name="selected_category" value="-1"
					checked="checked" /> <label for="-1"> <b>keine Beschränkung
						(Beiträge aus allen Kategorien)</b>
				</label> <br />
	           
	       <?php
        $taxonomies = get_terms('category');
        foreach ($taxonomies as $taxonomy => $value) :
            ?>
	           
	           
	           
	           <input id="<?php echo $value->slug; ?>" type="radio"
					name="selected_category" value="<?php echo $value->slug; ?>" /> <label
					for="<?php echo $value->slug; ?>">
	               <?php echo $value->name; ?>
	           </label> <br />
	           
	           
	           <?php
        endforeach;
        ?>
	       </div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="full-size">
		<div class="col12">
			<br /> <label for="limit"> Anzahl maximal anzuzeigende Beiträge
				(Standard ist 6. Tragen Sie eine 0 ein, um unendlich viele Beiträge
				anzuzeigen.) <br>
			</label> <input type="text" id="max_posts" name="max_posts"
				placeholder="Limit" value="6" />
		</div>
		<div class="clearfix"></div>
	</div>
	<br />

	<button id="sc-posts-button" class="custom-shortcode-generate-button"
		type="button">Beitrag-Shortcode generieren</button>
</div>