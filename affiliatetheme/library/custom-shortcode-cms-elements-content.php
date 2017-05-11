<div class="icons-content">
    
    <div class="full-size">
        <div class="col12">
            <br />
            <h3>Welches Produktelement soll angezeigt werden?</h3>
            
            <input type="radio" name="cms_element" value="price_compare_box" /> Preisvergleichsbox <br />
            <input type="radio" name="cms_element" value="price_compare" /> Preisvergleichsbutton <br />
            <input type="radio" name="cms_element" value="price_box" /> <?php echo __('Price','affiliatetheme'); ?> <br />
            <input type="radio" name="cms_element" value="product_image" /> <?php echo __('Image','affiliatetheme'); ?> <br />
            <input type="radio" name="cms_element" value="add_to_cart_button" /> Kaufbutton <br />
            <input type="radio" name="cms_element" value="product_detail_page_button" /> Detailbutton <br />
            <input type="radio" name="cms_element" value="product_rating" /> Sternebewertung <br />
        </div>
		<div class="clearfix"></div>
	</div>
	
	<div class="full-size">

		<div class="col12">

			<br />
			<h3>2. Für welches Produkt?</h3>

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
                    <input 
                        id="<?php echo $id ?>" 
                        value="<?php echo $id ?>" 
                        type="radio" 
                        name="product_id" /> 
                        <label for="<?php echo $id; ?>"> <?php echo $title; ?> </label>
				<br />
                    
                    <?php
                endforeach;
                ?>
            </div>
		</div>
		<div class="clearfix"></div>
	</div>

	

	<br />

	<button id="sc-cms-elements-button"
		class="custom-shortcode-generate-button" type="button">Produktelement-Shortcode
		generieren</button>
</div>
