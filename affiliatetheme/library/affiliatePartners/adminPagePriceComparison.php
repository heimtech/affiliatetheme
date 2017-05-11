<?php
add_action('admin_menu', 'affiliseo_menu_affilinet');

function affiliseo_menu_affilinet()
{
    add_menu_page("Preisvergleich", "Preisvergleich", 'manage_options', 'price-check', 'create_price_check');
}

function create_price_check()
{
    $priceComparison = new PriceComparison();
    $products = $priceComparison->getProductsWithEan();
    
    ?>


<style>
<!--
.compare-prices-box-header {
	background-color: #f1f1f1;
	border: 1px solid #dcdcdc;
	padding: 5px;
}

.get-compare-prices-box {
	width: 100%;
	max-height: 300px;
	overflow: auto;
	border: 1px solid #dcdcdc;
}

.ap-select-icon {
	padding-left: 10px;
	padding-right: 10px;
	margin-bottom: -1px;
}

.ap-select-checkbox, .ap-select-label {
	position: relative;
	bottom: 3px;
}

.ap-select-label {
	font-weight: bold;
	padding-right: 10px;
}

.get-compare-prices-box-header {
	border: 1px solid #dcdcdc;
}

.compare-prices-box-cols {
	float: left;
}

.compare-prices-box-col1 {
	width: 14%;
}

.compare-prices-box-col2 {
	width: 15%;
}

.compare-prices-box-col3, .compare-prices-box-col4 {
	width: 5%;
}

.compare-prices-box-col5 {
	width: 11%;
}

.compare-prices-box-col6 {
	width: 40%;
}

.compare-prices-box-col7 {
	width: 8%;
}

.get-compare-prices-box-row {
	padding: 5px 0px 5px 0px;
	border-top: 1px solid #cdcdcd;
	float: left;
	width: 100%;
}

.add-ap-article {
	background: #4BB448 none repeat scroll 0 0 !important;
	height: unset !important;
	line-height: unset !important;
	text-align: center;
}

.delete-ap-article {
	background: #D43E27 none repeat scroll 0 0 !important;
	height: unset !important;
	line-height: unset !important;
	text-align: center;
}

.selected-article {
	background-color: #dff0d8;
}

.aloader {
	background-image:
		url(../wp-content/themes/affiliatetheme/images/aloader.gif);
	background-repeat: no-repeat;
	visibility: visible;
}
-->
</style>
<div class="wrap">
	<h2>Preisvergleich erstellen</h2>
	<p>
		Wenn Sie Hilfe beim Erstellen eines Preisvergleichs benötigen, klicken
		Sie bitte auf den folgenden Link, um zu einer Anleitung auf
		AffiliSEO.de zu gelangen. <br /> <a
			href="http://affiliseo.de/preisvergleich-erstellen-ueber-affilinet/"
			target="_blank" class="link-affiliseo"> <i
			class="fa fa-youtube-play fa-2x fa-affiliseo"></i> zur Anleitung auf
			AffiliSEO.de
		</a>
	</p>
		<?php
    if (count($products) === 0) {
        ?>
			<p
		style="color: #a94442; background-color: #f2dede; border-color: #ebccd1; padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px;">
		Wenn Sie hier kein Produkt vorfinden können, müssen Sie eine EAN für
		jedes Ihrer Produkte angeben.</p>
			<?php
    } else {
        ?>
			<table class="widefat">
		<thead>
			<tr>
				<th>Produktname</th>
				<th>EAN</th>
				<th><?php echo __('Offers','affiliatetheme'); ?></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
					<?php
        foreach ($products as $product) {
            $ean = get_post_meta($product->ID, 'ean', true);
            
            if (strlen($ean) > 3) {
                $results = $priceComparison->getPriceComparisonEntryByPostId($product->ID);
                
                $eanCellStyles = ' word-break: break-all; ';
                $styles = '';
                if (count($results) > 0) {
                    $styles = ' style="background-color: #DFF0D8;"';
                    $eanCellStyles = ' background-color: #DFF0D8; ';
                }
                ?>
                							<tr class="compare-product-row">
				<td <?php echo $styles; ?>><a
					href="<?php echo admin_url() . '/post.php?post=' . $product->ID . '&action=edit' ?>"><?php echo $product->post_title; ?></a>
				</td>
				<td <?php echo $styles; ?> style="<?php echo $eanCellStyles; ?>">
                									<?php echo $ean; ?>
                								</td>
				<td <?php echo $styles; ?>>
                									<?php
                if (count($results) > 0) {
                    echo $results->shop_names;
                }
                ?>
                								</td>
				<td <?php echo $styles ?>><input
					id="open_price_check_<?php echo $product->ID; ?>" type="button"
					value="Produkt suchen"
					class="button-primary open_price_check box-closed"
					data-product-id="<?php echo $product->ID; ?>" /></td>
				<td <?php echo $styles ?>>
                									<?php if ( count( $results ) > 0 ) { ?>
                										<input type="button"
					data-id="<?php echo $product->ID; ?>"
					value="Preisvergleich entfernen"
					class="button-primary delete_price_check" style="" />
                										<?php
                }
                ?>
                								</td>
			</tr>

			<tr>
				<td colspan="5" style="display: none;">
					
					<div class="compare-prices-box-header">
						<span class="ap-select-label">Partnerprogramm:</span> <input
							type="checkbox" name="compare-prices-parners" value="amazon"
							class="ap-select-checkbox" /> <img
							src="../wp-content/themes/affiliatetheme/images/amazon_h18.png"
							alt="amazon" class="ap-select-icon" /> <input type="checkbox"
							name="compare-prices-parners" value="affilinet"
							class="ap-select-checkbox" /> <img
							src="../wp-content/themes/affiliatetheme/images/affilinet_h18.png"
							alt="affilinet" class="ap-select-icon" /> <input type="checkbox"
							name="compare-prices-parners" value="zanox"
							class="ap-select-checkbox" /> <img
							src="../wp-content/themes/affiliatetheme/images/zanox_h18.png"
							alt="zanox" class="ap-select-icon" />
                					
                					<?php
                $searchLabel = (count($results) > 0) ? 'Preise erneut suchen' : 'Preise suchen';
                ?>
                					
                					<span class="button-primary create_price_check"
							id="create_price_check_<?php echo $product->ID; ?>"
							data-product-id="<?php echo $product->ID; ?>"> 
                					
                					<?php echo $searchLabel; ?>
                					</span>

					</div>
					
					<div>
						<b>
							Bitte die Suchergebnisse genau überprüfen! 
							Unterschiedliche Produkte könnten beim Affiliatepartner unter der 
							gleichen EAN-Nummer hinterlegt sein
						</b>
					</div>
					
					<div class="get-compare-prices-box-header">
						<div class="compare-prices-box-col1 compare-prices-box-cols">Partnerprogramm</div>
						<div class="compare-prices-box-col2 compare-prices-box-cols">Shop</div>
						<div class="compare-prices-box-col3 compare-prices-box-cols"><?php echo __('Price','affiliatetheme'); ?></div>
						<div class="compare-prices-box-col4 compare-prices-box-cols">Versand</div>
						<div class="compare-prices-box-col5 compare-prices-box-cols">Artikelnummer</div>
						<div class="compare-prices-box-col6 compare-prices-box-cols"><?php echo __('Product','affiliatetheme'); ?></div>
						<div class="compare-prices-box-col7 compare-prices-box-cols">Preisvergleich</div>
					</div>
					<div class="get-compare-prices-box"
						id="box_create_price_check_<?php echo $product->ID; ?>"></div>
				</td>
			</tr>
                							<?php
            }
        }
        ?>
				</tbody>
	</table>
		<?php
    }
    ?>
		<a href="<?php echo site_url(); ?>" id="blogurl"
		style="display: none;"></a>
	<div id="data"></div>
	<div class="clearfix"></div>
	<p
		style="color: #8a6d3b; background-color: #fcf8e3; border-color: #faebcc; padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px;">
		<strong>Anmerkung des Entwicklers</strong><br /> Diese Software ist
		gem. § 69a Abs. 3 UrhG urheberrechtlich geschützt. Das Plagiieren und
		Verbreiten der Software oder von Codesegmenten stellt eine starfbare
		Handlung dar und kann eine Geld- oder Haftstrafe nach sich ziehen. Des
		Weiteren besteht seitens des Entwicklers ein Unterlassungsanspruch.
		Das Plagiieren und Verbreiten der Software oder von Codesegmenten kann
		kostenpflichtig abgemahnt werden. In diesem Fall behält sich der
		Entwickler die Beantragung einer einstweiligen Verfügung oder eine
		Unterlassungsklage vor.
	</p>
</div>
<script type="text/javascript">
		jQuery(document).ready(function ($) {

			var blogurl = $('#blogurl').attr('href');

			jQuery('.open_price_check').click(function () {
				var nextRow = jQuery(this).parents('tr').next('tr');
		        nextRow.children('td').toggle('slow');

		        if(jQuery(this).hasClass('box-closed')){

			        var productId = jQuery(this).attr('data-product-id');
			        var box = jQuery('#box_create_price_check_'+productId);

			        displayLoader(box);

			        jQuery.ajax({
						type: "POST",
						data: {
							product_id: productId						
						},
						dataType: "html",
						url: blogurl + '/wp-content/themes/affiliatetheme/library/affiliatePartners/getPriceCompareProducts.php',
						success: function (data) {
							
							box.html(data);
							
							
						},
					});
			        jQuery(this).removeClass('box-closed').addClass('box-opened');
		        } else {
		        	jQuery(this).addClass('box-closed').removeClass('box-opened');
		        }

		        
			});

			jQuery('.create_price_check').click(function () {

				var affiliatePartners = '';

				var createPriceCheckRow = jQuery(this).parent('div.compare-prices-box-header');

				createPriceCheckRow.find(".ap-select-checkbox").each(function(){
					if(this.checked){
						affiliatePartners += jQuery(this).val();
						affiliatePartners +=',';
					}
				});
								
				affiliatePartners = affiliatePartners.slice(0,-1);

				var productId = jQuery(this).attr('data-product-id');
				var elementId = jQuery(this).attr('id');

				var box = jQuery('#box_'+elementId);
				

				displayLoader(box);
				
				jQuery.ajax({
					type: "POST",
					data: {
						display_type: 'open_new',
						affiliatePartners: affiliatePartners,
						product_id: productId						
					},
					dataType: "html",
					url: blogurl + '/wp-content/themes/affiliatetheme/library/affiliatePartners/getPriceCompareProducts.php',
					success: function (data) {
						
						box.html(data);
						
						
					},
				});
				
			});
			
			$('.delete_price_check').click(function () {
				var product_id = $(this).attr('data-id');
				$.ajax({
					type: "POST",
					data: {
						product_id: product_id
					},
					dataType: "html",
					url: blogurl + '/wp-content/themes/affiliatetheme/library/affiliatePartners/deletePriceComparisonEntry.php',
					success: function (data) {
						$('#data').empty();
						$('#data').html(data);
						setTimeout(function () {
							location.reload();
						}, 2000);
					},
				});
			});
			
		});

		function updateComparisonSearchList(productId,articleIds,mod){

			
			
			jQuery.each( articleIds , function( index, value ) {
				
				var article = jQuery( '[data-article-id="'+value+'"]' );

				var comparePricesBoxRow = article.parents('.get-compare-prices-box-row');

				var articleCb = comparePricesBoxRow.find("input");
				
				if(mod=='add'){
					article.removeClass('add-ap-article').addClass('delete-ap-article');
					article.html('entfernen');
					article.attr('data-mod','delete');
					comparePricesBoxRow.addClass('selected-article');
					articleCb.attr("checked", true);
					articleCb.attr("disabled", true);
				} else {
					article.removeClass('delete-ap-article').addClass('add-ap-article');
					article.html('einbinden');
					article.attr('data-mod','add');
					comparePricesBoxRow.removeClass('selected-article');
					articleCb.attr("checked", false);
					articleCb.attr("disabled", false);
					
				}
				
			});
		}

		function displayLoader(box){
			box.empty();
	    	box.html('<strong style="padding-left:20px;">SUCHERGEBNISSE WERDEN GELADEN...</strong><p class="spinner aloader" style="display: block !important; float: left;"></p>');
	    }
	</script>
<?php
}