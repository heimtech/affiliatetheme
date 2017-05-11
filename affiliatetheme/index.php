<?php
global $affiliseo_options;
get_header();
$sidebar_position = $affiliseo_options['layout_sidebar_category'];
?>

<div class="custom-container cat">
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
				<h1 class="pull-left"><?php wp_title( '' ); ?></h1>
				<a href="<?php bloginfo( 'rss2_url' ); ?>"><i class="fa fa-rss fa-2x pull-right"></i></a>
				<div class="clearfix"></div>
				<hr>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<article <?php post_class(); ?>>
							<?php
							$post = get_post();
							$thumbnailUrl = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
							if ( has_post_thumbnail() || strlen($thumbnailUrl) > 3) {
								the_custom_post_thumbnail($post, 'img_by_url_image_w150', 'thumbnail', array('class' => 'img-thumbnail pull-left'));
							}
							?>
							<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?> weiterlesen"><?php the_title(); ?></a></h3>
							<?php
							if ( $affiliseo_options['blog_show_time'] !== '1' ) {
								get_template_part( 'blogmeta' );
								?>
								<br><br>
								<?php
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
				wp_reset_query();
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