<?php
/*
  Template Name: Archiv
 */
get_header();
global $affiliseo_options;
$sidebar_position = $affiliseo_options['layout_sidebar_category'];

global $type_plural;
global $brand_plural;
global $type_singular;
global $type_singular_slug;
global $brand_singular;
global $brand_singular_slug;

$use_custom_permalinks = $affiliseo_options['use_custom_permalinks'];
?>

<div class="custom-container cat custom-container-margin-top">
    <div class="full-size">
		<?php
		if ( $sidebar_position == 'links' ) {
			?>
			<div class="col3 sidebar-left" id="sidebar">
				<?php get_sidebar(); ?>
			</div>
			<?php
		}
		if ( $sidebar_position != 'links' && $sidebar_position != 'rechts' ) {
			$width = 12;
		} else {
			$width = 9;
		}
		?>
        <div class="col<?php echo $width; ?> <?php if ( $sidebar_position == 'links' ) { ?> content-right<?php } if ( $sidebar_position == 'rechts' ) { ?> content-left<?php } ?>"  >
			<div class="box posts">
				<?php the_post(); ?>
				<h1 class="pull-left"><?php the_title(); ?></h1>
				<?php if ( $affiliseo_options['hide_blog_feed'] !== '1' ) : ?>
					<a href="<?php bloginfo( 'rss2_url' ); ?>" class="pull-right"><i class="fa fa-rss fa-2x"></i></a>
				<?php endif; ?>
				<div class="clearfix"></div>
				<hr>
				<h2>Alle Produkte nach <?php echo $brand_plural; ?></h2>
				<?php
				$terms = get_terms( 'produkt_marken' );
				if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
					echo '<ul>';
					foreach ( $terms as $term ) {
						if ( trim( $use_custom_permalinks ) !== '1' ) {
							echo '<li><a href="' . get_bloginfo( 'url' ) . '/produkt/' . $term->slug . '/">' . $term->name . '</a></li>';
						} else {
							echo '<li><a href="' . get_bloginfo( 'url' ) . '/' . $brand_singular_slug . '/' . $term->slug . '/">' . $term->name . '</a></li>';
						}
					}
					echo '</ul>';
				}
				?>
				<hr>
				<h2>Alle Produkte nach <?php echo $type_plural; ?></h2>
				<?php
				$terms = get_terms( 'produkt_typen' );
				if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
					echo '<ul>';
					foreach ( $terms as $term ) {
						if ( trim( $use_custom_permalinks ) !== '1' ) {
							echo '<li><a href="' . get_bloginfo( 'url' ) . '/typen/' . $term->slug . '/">' . $term->name . '</a></li>';
						} else {
							echo '<li><a href="' . get_bloginfo( 'url' ) . '/' . $type_singular_slug . '/' . $term->slug . '/">' . $term->name . '</a></li>';
						}
					}
					echo '</ul>';
				}
				?>
				<hr>
				<h2>Alle Produkte nach Tags</h2>
				<?php
				$terms = get_terms( 'produkt_tags' );
				if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
					echo '<ul class="tags tags-archive tags-pro">';
					foreach ( $terms as $term ) {
						echo '<li><a href="' . get_bloginfo( 'url' ) . '/tags/' . $term->slug . '/">' . $term->name . '</a></li>';
					}
					echo '</ul>';
				}
				?>
				<hr>
				<h2>Alle Artikel sortiert nach Monaten</h2>
				<ul>
					<?php wp_get_archives( 'type=monthly' ); ?>
				</ul>
				<hr>
				<h2>Alle Artikel sortiert nach Kategorien</h2>
				<ul>
					<?php wp_list_categories(); ?>
				</ul>
				<hr>
				<h2>Alle Artikel sortiert nach Tags</h2>
				<?php
				$tags = get_tags();
				if ( $tags ) :
					?>
					<ul class="tags tags-archive">
						<?php
						foreach ( $tags as $tag ) :
							?>
							<li><a href="<?php echo get_tag_link( $tag->term_id ); ?>"><?php echo $tag->name; ?></a></li>
							<?php
						endforeach;
						?>
					</ul>
					<?php
				endif;
				?>
			</div>
		</div>
		<?php
		if ( $sidebar_position == 'rechts' ) {
			?>
			<div class="col3 sidebar-right" id="sidebar">
				<?php get_sidebar(); ?>
			</div>
			<?php
		}
		?>
		<div class="clearfix"></div>

	</div>
</div>

<?php get_footer(); ?>