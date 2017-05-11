<?php
global $affiliseo_options;
global $post;
$ap_button_label = getApButtonLabel($post);
if (trim(get_theme_mod('affiliseo_buttons_ap_bg_image', '')) !== '') {
    $ap_button_label = '';
}

$ap_cart_button_label = $affiliseo_options['ap_cart_button_label'];
if (! isset($affiliseo_options['ap_cart_button_label'])) {
    $ap_cart_button_label = __('Add to cart','affiliatetheme');
}

if (trim(get_theme_mod('affiliseo_buttons_ap_cart_bg_image', '')) !== '') {
    $ap_cart_button_label = '';
}

$show_ap_cart_button = '0';
if (get_field('ap_cart_link')) {
    $show_ap_cart_button = '1';
}

$ap_button_where = $affiliseo_options['layout_ap_button_produkt'];
$proportion_image = $affiliseo_options['proportion_image'];
$text_1_grey_box = trim($affiliseo_options['text_1_grey_box']);
$text_2_grey_box = trim($affiliseo_options['text_2_grey_box']);
$product_image_effect = $affiliseo_options['product_image_effect'];
if (trim($product_image_effect) === '') {
    $product_image_effect = 'slideUpDown';
}

$colimg = '';
$colcontent = '';
switch ($proportion_image) {
    case '3x9':
        $colimg = 'col3';
        $colcontent = 'col9';
        break;
    case '4x8':
        $colimg = 'col4';
        $colcontent = 'col8';
        break;
    case '2x10':
        $colimg = 'col2';
        $colcontent = 'col10';
        break;
    case '5x7':
        $colimg = 'col5';
        $colcontent = 'col7';
        break;
    default:
        $colimg = 'col7';
        $colcontent = 'col5';
        break;
}
$hidden_grey_box = 'false';
if (trim($ap_button_where) === 'unten' || trim($ap_button_where) === 'none') {
    $hidden_grey_box = 'true';
    $colimg = '';
}

global $device;
get_header();
$marken = get_the_terms($post->ID, 'produkt_marken');
$typen = get_the_terms($post->ID, 'produkt_tpyen');

$sidebar_position = $affiliseo_options['layout_sidebar_produkt'];

global $no_price_string, $has_price_comparison;
$has_price_comparison = 'false';
$position_price_comparison = '';

$priceComparison = new PriceComparison();
$res = $priceComparison->hasPriceComparison((int)get_the_ID());

if (count($res) > 0) {
    $has_price_comparison = 'true';
    $position_price_comparison = $affiliseo_options['position_price_comparison'];
}

$use_custom_permalinks = $affiliseo_options['use_custom_permalinks'];

$headline_price_comparison = $affiliseo_options['headline_price_comparison'];
if (trim($headline_price_comparison) === '') {
    $headline_price_comparison = 'Preisvergleich';
}

$button_price_comparison = $affiliseo_options['button_price_comparison'];
if (trim($button_price_comparison) === '') {
    $button_price_comparison = 'zum Preisvergleich';
}

global $number_of_attributes;

$hide_headline = false;
if (! empty($affiliseo_options['hide_headline_product']) && trim($affiliseo_options['hide_headline_product']) === '1') {
    $hide_headline = true;
}

$headline_tag_product = 'h1';
if (! empty($affiliseo_options['headline_tag_product'])) {
    $headline_tag_product = $affiliseo_options['headline_tag_product'];
}

$show_uvp = '';
if (! empty($affiliseo_options['show_uvp'])) {
    $show_uvp = $affiliseo_options['show_uvp'];
}
?>
<div class="custom-container custom-container-margin-top">
    <?php
    if ($device === 'desktop') {
        if (trim($affiliseo_options['ad_produkt_top']) != "" && isset($affiliseo_options['ad_produkt_top'])) {
            ?>
            <div class="ad text-center"><?php echo $affiliseo_options['ad_produkt_top']; ?></div>
            <?php
        }
    } else {
        if (trim($affiliseo_options['ad_produkt_top_mobile']) != "" && isset($affiliseo_options['ad_produkt_top_mobile'])) {
            ?>
            <div class="mobile-ad text-center"><?php echo $affiliseo_options['ad_produkt_top_mobile']; ?></div>
            <?php
        }
    }
    ?>
    <div class="clearfix"></div>
</div>

<div class="product custom-container">
	<div id="post-id" data-id="<?php echo get_the_ID(); ?>"></div>
	<div class="full-size">
	<?php
	if ($sidebar_position == 'links') {
		?>
		<div class="col3 sidebar-left" id="sidebar"><?php get_sidebar(); ?></div>
		<?php
		$colwidth = 9;
	} elseif ($sidebar_position == 'rechts') {
		$colwidth = 9;
	} else {
		$colwidth = 12;
	}
	
	if (have_posts()) {
		
		while (have_posts()) {
			
			the_post();
			?>
			<div
			class="col<?php echo $colwidth; ?> <?php if ($sidebar_position == 'links') { ?> content-right<?php } if ($sidebar_position == 'rechts') { ?> content-left<?php } ?>"
			id="single" itemscope itemtype="http://schema.org/Product">

			<div class="box">
					<?php
					if (get_field('hide_product_headline') === false || get_field('hide_product_headline') ==null) {
						
						if (!$hide_headline) {
							?>
							<<?php echo $headline_tag_product; ?> 
								itemprop="name" 
								id="h1-product"><?php the_title(); ?>
							</<?php echo $headline_tag_product; ?>>
							<?php
						}
					}
					?>
					
					<div
					class="<?php echo $colimg; ?> <?php if ($hidden_grey_box === 'false'){ ?> single-product-col-left <?php } ?> ">
						<?php get_template_part('slider'); ?>
					</div>
					
					<?php
					if ($ap_button_where == 'oben' || $ap_button_where == 'beides') {
						?>
						<div class="<?php echo $colcontent ?> left-details">

					<div class="produkt-details box-grey">
								
								<?php
								if ($affiliseo_options['allg_preise_ausblenden'] != 1) {
									if (get_field('preis') === $no_price_string) {
										?>
										<p class="no-price"><?php echo get_field('preis'); ?></p>
										<?php
									} else {
										global $currency_string;
										$uvp = get_field('uvp');
										
										if (!empty($uvp) && $show_uvp == '1' && strToFloat($uvp) > strToFloat(get_field('preis'))) {
                        ?>
											<div class="uvp-line-through">
							<div class="uvp-text-color">
													<?php
                        echo $pos_currency == 'before' ? $currency_string . ' ' : '';
                        echo get_field('uvp');
                        echo $pos_currency == 'after' ? ' ' . $currency_string : '';
                        ?>
												</div>
						</div>
											<?php
                    }
                    ?>
										
										<p class="price" itemprop="offers" itemscope
							itemtype="http://schema.org/Offer">
											<?php
											global $pos_currency;
											$price = '';
											
											if (trim($pos_currency) === 'before') {
												?>
												<?php echo $currency_string; ?> 
												<span itemprop="price"
								content="<?php echo strToFloat(get_field('preis')); ?>">
													<?php echo get_field('preis') ; ?>
												</span> *
												<?php 
											} else {
												
												?>
												<span itemprop="price"
								content="<?php echo strToFloat(get_field('preis')); ?>">
													<?php echo get_field('preis'); ?>
												</span> 
												<?php echo $currency_string; ?> *
												<?php
											}
											?>
											<meta itemprop="priceCurrency" content="EUR" />
						</p>
										<?php global $text_tax; ?>
										<p>
							<span class="mwst"><?php echo $text_tax; ?></span>
						</p>
										
										<?php
									}
									
								} else {
									
									?>
									<p>&nbsp;</p>
									<?php
								}
								
								$go = $affiliseo_options['activate_cloaking'];
								
								if ($go === '1') {
								    
								    echo writePdpButton(get_field('ap_pdp_link'), $ap_button_label,'','btn btn-ap');
								} else {								    
								    echo writePdpLink(get_field('ap_pdp_link'), $ap_button_label, 'btn btn-ap');
								}
								
								if ($go === '1' && $show_ap_cart_button === '1') {
								    ?>
								    <div class="clearfix"></div>
								    <?php
								    echo writeAddToBasketButton($affiliseo_options, get_field('ap_cart_link'), $ap_cart_button_label,'','btn btn-cart-ap');
								} else {
								    
								    if ($show_ap_cart_button === '1') {
								        ?>
								        <div class="clearfix"></div>
								        <?php
								        echo writeAddToBasketLink($affiliseo_options, get_field('ap_cart_link'), $ap_cart_button_label, 'btn btn-cart-ap');
								    }
								}
								
								if ($affiliseo_options['text_produkt_hinweis'] != "") {
									
									?>
									<span class="hint"><?php echo $affiliseo_options['text_produkt_hinweis']; ?></span>
									<?php
								}
								
								?>
								<?php
								if( !isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating']!=1 ){
								    echo get_product_rating($post->ID, "p", "");
								}
								?>
								
								<?php
								if( !isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating']!=1 ){
								?>
								<div itemprop="aggregateRating" itemscope
							itemtype="http://schema.org/AggregateRating">
							<span itemprop="worstRating" content="0"></span> <span
								itemprop="bestRating" content="5"></span> <span
								itemprop="ratingValue"
								content="<?php echo get_field('sterne_bewertung'); ?>"></span> <span
								itemprop="reviewCount" content="1"></span>
						</div>
						<?php 
								}?>
								
								<?php
								if (get_field('third_link_text') != "" && get_field('third_link_url') != "") {
									
									?>
									<a href="<?php echo get_field('third_link_url'); ?>"
							class="btn btn-default third-link" target="_blank" rel="nofollow">
										
										<?php
										if (trim(get_theme_mod('affiliseo_buttons_third_bg_image', '')) === '') {
											echo get_field('third_link_text');
										}
										?>
									</a>
									<?php
								}
								
								if ($has_price_comparison === 'true') {
									
									?>
									<p>
							<a href="<?php the_permalink(); ?>#price_comparison"
								class="btn btn-ap" id="price_comparison_link"> <i
								class="fa fa-tags"></i> <?php echo $button_price_comparison ?>
										</a>
						</p>
									<?php
								}
								
								if ($text_1_grey_box !== '' || $text_2_grey_box !== ''){
									
									?>
									<ul>
										<?php
										if ($text_1_grey_box !== '') {
											?>
											<li><?php echo $text_1_grey_box; ?></li>
											<?php
										}
										
										if ($text_2_grey_box !== '') {
											?>
											<li><?php echo $text_2_grey_box; ?></li>
											<?php
										}
										?>
									</ul>
									<?php
								}
								?>
							</div>
							
							<?php
							
							if ($affiliseo_options['allg_preise_ausblenden'] != 1) {
								
								?>
								<p class="text-right modified">
									<small>
										* <?php printf(__('last updated on %s at %s.','affiliatetheme'), get_the_modified_date('j. F Y'), get_the_modified_date('G:i')); ?>
									</small>
								</p>
								<?php
							}
							?>
							
							<br />
					<table class="table table-striped">
						<tbody>
								<?php
								if ($affiliseo_options['show_additional_attributes_position'] === 'top' || $affiliseo_options['show_additional_attributes_position'] === 'both') {
									
									show_taxonomies($post->ID, $use_custom_permalinks);
									
									if (trim($affiliseo_options['show_ean']) !== '1' && trim(get_field('ean') !== '0')){
										?>
										<tr>
								<td>EAN(s)</td>
								<td><span itemprop="productID">
													<?php
													$ean_field = trim(get_field('ean'));
													$eans = explode(',', $ean_field);
													
													foreach ($eans as $ean) {
														echo trim($ean) . '<br />';
													}
													?>
												</span></td>
							</tr>
										<?php
									}
									
									for ($a = 0; $a <= $number_of_attributes; $a++) {
										
										if (trim(get_field('attribute_' . $a . '_title')) != "" && trim(get_field('attribute_' . $a . '_content')) != "") {
											?>
											<tr>
								<td><?php echo get_field('attribute_' . $a . '_title'); ?></td>
								<td><?php echo get_field('attribute_' . $a . '_content'); ?></td>
							</tr>
											<?php
										}
									}
								}
								?>
								</tbody>
					</table>					
				</div>
				<div class="clearfix"></div>
				<?php
				$post = get_post();
				$ProductReviews = new ProductReviews(false);
				$reviewContentsHTML = $ProductReviews->getReviewContentsHTML($post->ID);
				echo $reviewContentsHTML;
				?>
				<div class="clearfix"></div>
						
						<?php
					}
					?>
					<div class="clearfix"></div>
				<div class="beschreibung">
					<h3><?php echo $affiliseo_options['text_product_description'] ?></h3>
					<div itemprop="description"><?php the_content(); ?></div>
					<div class="clearfix"></div>
				</div>
			</div>
				
				<?php
				if (trim($position_price_comparison) === 'top') {
					
					?>
					<a name="price_comparison" id="price_comparison_a"></a>
			<div class="box">
				<h3 class="price-comparison-headline">
					<i class="fa fa-tags"></i> <?php echo $headline_price_comparison; ?>
						</h3>
				<div id="data-price-comparison">
					<div class="text-center">
						<i class="fa fa-spinner"></i> Daten werden geladen...
					</div>
				</div>
			</div>
					<?php
				}
				
				if ($affiliseo_options['show_additional_attributes_position'] === 'bottom' || $affiliseo_options['show_additional_attributes_position'] === 'both') {
					
					?>
					<div class="box">
				<br />
				<table class="table table-striped">
					<tbody>
							
							<?php
							show_taxonomies($post->ID, $use_custom_permalinks);
							
							if (trim($affiliseo_options['show_ean']) !== '1' && trim(get_field('ean') !== '0')){
								
								?>
								<tr>
							<td>EAN(s)</td>
							<td><span itemprop="productID">
											<?php
											$ean_field = trim(get_field('ean'));
											$eans = explode(',', $ean_field);
											
											foreach ($eans as $ean) {
												echo trim($ean) . '<br />';
											}
											?>
										</span></td>
						</tr>
								<?php
							}
							
							for ($a = 0; $a <= $number_of_attributes; $a++) {
								
								if (trim(get_field('attribute_' . $a . '_title')) != "" && trim(get_field('attribute_' . $a . '_content')) != "") {
									
									?>
                                            <tr>
							<td><?php echo get_field('attribute_' . $a . '_title'); ?></td>
							<td><?php echo get_field('attribute_' . $a . '_content'); ?></td>
						</tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
				</table>				
			</div>
                    <?php }
                    ?>
                    <div id="second">
                        <?php if ($device === 'desktop') { ?>
                            <?php if (trim($affiliseo_options['ad_produkt_bottom']) != "" && isset($affiliseo_options['ad_produkt_bottom'])) { ?>
                                <div class="ad text-center"><?php echo $affiliseo_options['ad_produkt_bottom']; ?></div>
                            <?php }  }else{  if (trim($affiliseo_options['ad_produkt_bottom_mobile']) != "" && isset($affiliseo_options['ad_produkt_bottom_mobile'])) { ?>
                                <div class="mobile-ad text-center"><?php echo $affiliseo_options['ad_produkt_bottom_mobile']; ?></div>
                            <?php } 
                        }
                        if ((trim(get_field('testbericht')) !== '') || $ap_button_where == 'unten' || $ap_button_where == 'beides') {
                            ?>
                            <div class="box">
                            <?php }  if (trim(get_field('testbericht')) !== '') { ?>
                                <div class="testbericht"
						itemprop="review" itemscope itemtype="http://schema.org/Review">
                                    <?php
                                    $fielddata = get_field('testbericht', $post->ID, false);
                                    $fielddata = apply_filters('the_content', $fielddata);
                                    ?>
                                    <div itemprop="reviewBody"><?php echo $fielddata; ?></div>
						<small class="pull-right">Autor: <span itemprop="author"><?php echo get_the_author(); ?></span></small>
						<div class="clearfix"></div>
					</div>
                            <?php } 
                            if ($ap_button_where == 'unten' || $ap_button_where == 'beides') {
                                ?>
                                <div class="goto box-grey full-size">
						<div class="col1">
                                        <?php 
                                        the_custom_post_thumbnail($post, 'img_by_url_image_w100', null, array(100,100));
                                        ?>
                                    </div>
						<div class="goto-body col3">
							
							<?php
							if( !isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating']!=1 ){
							    echo get_product_rating($post->ID, "p", "");
							}
							?>
							
							<?php
                                        if ($affiliseo_options['allg_preise_ausblenden'] != 1) {

                                            if (get_field('preis') === $no_price_string) {
                                                ?>
                                                <p class="no-price"><?php echo get_field('preis'); ?></p>
                                                <?php
                                            }else{
                                                global $currency_string;
                                                global $pos_currency;
                                                $price = '';
                                                if (trim($pos_currency) === 'before') {
                                                    $price = $currency_string . ' ' . get_field('preis');
                                                } else {
                                                    $price = get_field('preis') . ' ' . $currency_string;
                                                }
                                                ?>									
                                                <p class="price">
                                                    <?php echo $price; ?> *
                                                    <?php echo getProductUvpPrice($post->ID, $affiliseo_options); ?>
                                                </p>
                                                <?php
                                                global $text_tax;
                                                ?>
                                                <p>
								<span class="mwst"><?php echo $text_tax; ?></span>
							</p>
                                            <?php } 
                                        } else {
                                            ?>
                                            <p>&nbsp;</p>
                                            <?php
                                        }
                                        ?>
                                    </div>
						<div class="goto-button col7">
                                        <?php
                                        $go = $affiliseo_options['activate_cloaking'];
                                        if ($go === '1')  {
                                            ?>
                                            <form
								action="<?php bloginfo('url'); ?>/go/" method="post"
								target="_blank">
								<input type="hidden"
									value="<?php echo get_field('ap_pdp_link'); ?>"
									name="affiliate_link"> <input type="submit"
									value="<?php echo $ap_button_label; ?>"
									class="btn btn-ap">
							</form>
                                            <?php
                                       } else {
                                            ?>
                                            <a
								href="<?php echo get_field('ap_pdp_link'); ?>"
								class="btn btn-ap" target="_blank" rel="nofollow">
                                                <?php echo $ap_button_label; ?>
                                            </a>
                                        <?php
                                        }
                                        if ($affiliseo_options['text_produkt_hinweis'] != "") {
                                            ?>
                                            <div class="hint p-tag"><?php echo $affiliseo_options['text_produkt_hinweis']; ?></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
						<div class="clearfix"></div>
					</div>
                                <?php
                                if ($affiliseo_options['allg_preise_ausblenden'] != 1) {
                                    ?>
                                    <p class="text-right modified">
                                    	<small>
                                    		* <?php printf(__('The price was last updated on %s at %s.','affiliatetheme'), get_the_modified_date('j. F Y'), get_the_modified_date('G:i')); ?>
                                    	</small>
                                    </p>
                                    <?php
                                }
                            }
                            if ((trim(get_field('testbericht')) !== '') || $ap_button_where == 'unten' || $ap_button_where == 'beides') {
                                ?>
                            </div>
                            <?php
                        }
                    }
                }
                wp_reset_query();
                if (trim($position_price_comparison) === 'bottom') {
                    ?>
                    <a name="price_comparison" id="price_comparison_a"></a>
				<div class="box">
					<h3 class="price-comparison-headline">
						<i class="fa fa-tags"></i> <?php echo $headline_price_comparison; ?></h3>
					<div id="data-price-comparison">
						<div class="text-center">
							<i class="fa fa-spinner"></i> Daten werden geladen...
						</div>
					</div>
				</div>
                    <?php
                }
                $tags = get_the_terms($post->ID, 'produkt_tags');
                if ($tags) {
                    ?>
                    <div class="box">
					<div class="tags">
                            <?php
                            foreach ($tags as $tag) {
                                ?>
                                <a
							href="<?php echo get_bloginfo('url') ?>/tags/<?php echo trim($tag->slug); ?>/"
							rel="tag" class="product-tags"> <?php echo $tag->name; ?> </a>
                                <?php
                            }
                            ?>
                        </div>
				</div>
                    <?php
                }
                ?>

                <div class="related produkte">
					<h3><?php echo $affiliseo_options['text_headline_related']; ?></h3>
					<div class="full-size related-cols">
                        <?php
                        $args = array('post_type' => 'produkt', 'posts_per_page' => 4, 'orderby' => 'rand', 'post__not_in' => array($post->ID));
                        $countCols = 0;
                        query_posts($args);
                        if (have_posts()) {
                            while (have_posts()) {
                                the_post();
                                get_template_part('loop', 'related');
                                $countCols++;
                            }
                        }
                        wp_reset_query();
                        ?>
                        <div class="clearfix"></div>
					</div>
				</div>
			</div>
            <?php
            if (get_field('field_comments')) {
                $wpdb->query(
                        $wpdb->prepare(
                                " UPDATE $wpdb->posts
								SET `comment_status` = %s
								WHERE `ID` = %d
								", 'open', $post->ID
                        )
                );
                ?>
                <div class="box">
                    <?php
                    comments_template('', true);
                    ?>
                </div>
                <?php
            }else {
                $wpdb->query(
                        $wpdb->prepare(
                                " UPDATE $wpdb->posts
								SET `comment_status` = %s
								WHERE `ID` = %d
								", 'closed', $post->ID
                        )
                );
            }
            ?>
        </div>
        <?php
        if ($sidebar_position == 'rechts') {
            ?>
            <div class="col3 sidebar-right" id="sidebar">
                <?php get_sidebar(); ?>
            </div>
            <?php
        }
        ?>
        <div class="clearfix"></div>
	</div>
	<div class="full-size">

		<div class="clearfix"></div>
	</div>
</div>

<?php
get_footer();

