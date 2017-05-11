<?php
global $affiliseo_options;
get_header();
$sidebar_position = $affiliseo_options['layout_sidebar_category'];
$tax_position = $affiliseo_options['position_description_tax_blog'];

$curr_cat = single_cat_title( '', false );
$cat_id = get_cat_ID( $curr_cat );
$category_link = get_category_link( $cat_id );
$cat_slug = get_category( $cat_id )->slug;
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
        <div class="col<?php echo $width; ?> content<?php if ( $sidebar_position == 'links' ) { ?> content-right<?php } if ( $sidebar_position == 'rechts' ) { ?> content-left<?php } ?>"  >
            <div class="box posts">
				<h1 class="pull-left"><?php single_cat_title(); ?></h1>
				<?php if ( $affiliseo_options['hide_category_feed'] !== '1' ) : ?>
					<a href="<?php echo $category_link; ?>feed/" title="<?php single_tag_title(); ?>-Feed"><i class="fa fa-rss fa-2x pull-right"></i></a>
				<?php endif; ?>
				<div class="clearfix"></div>
				<?php
				if ( trim( affiliseo_taxonomy_images_taxonomy_image_url( $cat_id, 'full' ) ) !== '' ) : ?>
					<img src="<?php echo affiliseo_taxonomy_images_taxonomy_image_url( $cat_id, 'full' ); ?>" class="img-thumbnail pull-left post-thumbnail" alt="<?php echo $the_term->name; ?>">
					<?php
				endif;
				if ( trim( $tax_position ) === '' || trim( $tax_position ) === 'top' ) :
					if ( category_description() ) :
						?>
						<p>
							<?php echo category_description() ?>
						</p>
						<?php
					endif;
				endif;
				?>
				<div class="clearfix"></div>
				<hr>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<article <?php post_class(); ?>>
							<?php
							$post = get_post();
							$thumbnailUrl = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
							if ( has_post_thumbnail() || strlen($thumbnailUrl) > 3 ) {
								the_custom_post_thumbnail($post, 'img_by_url_image_w150', 'thumbnail', array( 'class' => 'img-thumbnail pull-left' ));
							}
							?>
							<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?> weiterlesen"><?php the_title(); ?></a></h3>
							<?php
							if ( $affiliseo_options['blog_show_time'] !== '1' ) {
								get_template_part( 'blogmeta' );
								echo '<br /><br />';
							}
							the_excerpt();
							?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?> weiterlesen" class="pull-right">weiterlesen &rarr;</a>
							<div class="clearfix"></div>
						</article>
						<hr>
						<?php
					endwhile;
				endif;
				?>
				<div class="text-center">
					<?php
					affiliseo_pagination();
					?>
				</div>
				<?php
				wp_reset_query();
				?>
				<?php
				if ( trim( $tax_position ) === 'bottom' ) :
					if ( category_description() ) :
						?>
						<p>
							<?php echo category_description(); ?>
						</p>
						<?php
					endif;
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