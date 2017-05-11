<?php
global $affiliseo_options;
get_header();

$the_tax = get_taxonomy( get_query_var( 'taxonomy' ) );
$the_term = $wp_query->queried_object;
global $query_string;
$sidebar_position = $affiliseo_options['layout_sidebar_search'];
$width = 9;
if ( $sidebar_position != 'links' && $sidebar_position != 'rechts' ) {
	$width = 12;
}
?>

<div class="custom-container custom-container-margin-top">
    <div class="full-size">
		<?php
		if ( $sidebar_position == 'links' ) :
			?>
			<div class="col3 sidebar-left" id="sidebar">
				<?php get_sidebar(); ?>
			</div>
			<?php
		endif;
		?>
        <div class="col<?php echo $width; ?> content <?php if ( $sidebar_position == 'links' ) : ?>content-right<?php endif; ?> <?php if ( $sidebar_position == 'rechts' ) : ?>content-left<?php endif; ?>">
            <h1>
            	<?php
            	printf(__('Your search for "%s" found <span>%s</span> results','affiliatetheme'), $s,$wp_query->found_posts);
            	?>
            </h1>

            <div class="produkte">
                <strong><?php echo __('Products','affiliatetheme'); ?></strong>
				<?php
				query_posts( $query_string . '&posts_per_page=-1' );
				if ( have_posts() ) : while ( have_posts() ) : the_post();
						?>
						<?php
						if ( $post->post_type === "produkt" ) {
							get_template_part( 'loop', 'produkt-horizontal' );
						}
						?>
						<?php
					endwhile;
				endif;
				wp_reset_query();
				?>
            </div>
            <div class="results">
                <div class="box">
                    <strong>Beiträge/Seiten</strong>
					<?php
					$posts = query_posts( $query_string . '&posts_per_page=-1' );
					$hasResult = false;
					foreach ( $posts as $post ) {
						if ( $post->post_type !== 'produkt' ) {
							$hasResult = true;
							break;
						}
					}
					if ( $hasResult ) {
						if ( have_posts() ) : while ( have_posts() ) : the_post();
								?>
								<?php
								if ( $post->post_type !== 'produkt' ) {
									?>
									<h3><a href="<?php echo get_permalink( $post->ID ); ?>"
										   title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
										<?php
									}
									?>

								<?php
							endwhile;
						endif;
					} else {
						echo '<p>'.__('No results found.','affiliatetheme').'</p>';
					}
					wp_reset_query();
					?>
                </div>
            </div>
        </div>
		<?php
		if ( $sidebar_position == 'rechts' ) :
			?>
			<div class="col3 sidebar-right" id="sidebar">
				<?php get_sidebar(); ?>
			</div>
			<?php
		endif;
		?>
        <div class="clearfix"></div>
    </div>
</div>

<?php get_footer(); ?>


