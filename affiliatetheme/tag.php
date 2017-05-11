<?php
global $affiliseo_options;
get_header();
$sidebar_position = $affiliseo_options['layout_sidebar_category'];
$term_slug = get_queried_object()->slug;
$tax_position = $affiliseo_options['position_description_tax_blog'];
?>

<div class="custom-container tag-content custom-container-margin-top">
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
            <div class="box tags-article posts">
				<h1 class="pull-left"><?php single_tag_title(); ?></h1>
				<div class="clearfix"></div>
				<?php if ( trim( affiliseo_taxonomy_images_taxonomy_image_url( get_query_var( 'tag_id' ), 'full' ) ) !== '' ) : ?>
					<img src="<?php echo affiliseo_taxonomy_images_taxonomy_image_url( get_query_var( 'tag_id' ), 'full' ); ?>" class="img-thumbnail pull-left post-thumbnail" alt="<?php echo $the_term->name; ?>">
					<?php
				endif;
				?>
				<div class="clearfix"></div>
				<?php
				if ( trim( $tax_position ) === '' || trim( $tax_position ) === 'top' ) :
					if ( tag_description() ) :
						?>
						<p>
							<?php echo tag_description(); ?>
						</p>
						<?php
					endif;
				endif;
				?>
				<hr>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<article <?php post_class(); ?>>
							<?php
							$post = get_post();
							$thumbnailUrl = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
							if ( has_post_thumbnail() || strlen($thumbnailUrl) > 3) {
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
				if ( trim( $tax_position ) === 'bottom' ) :
					if ( tag_description() ) :
						?>
						<p>
							<?php echo tag_description(); ?>
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