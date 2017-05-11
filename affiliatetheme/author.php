<?php
global $affiliseo_options;
$sidebar_position = $affiliseo_options['layout_sidebar_category'];
get_header();
?>
<div class="custom-container custom-container-margin-top">
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
				<?php
				$curauth = (isset( $_GET['author_name'] )) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );
				?>
				<h1>Über <?php echo $curauth->nickname; ?></h1>
				<dl>
					<?php if ( trim( $curauth->user_url ) !== '' ): ?>
						<dt>
						Webseite
						</dt>
						<dd>
							<a href="<?php echo $curauth->user_url; ?>" title="zur Webseite von <?php echo $curauth->nickname; ?>"><?php echo $curauth->user_url; ?></a>
						</dd>
						<?php
					endif;
					if ( trim( $curauth->user_description ) !== '' ):
						?>
						<dt>
						Mehr über <?php echo $curauth->nickname ?>
						</dt>
						<dd>
							<?php echo $curauth->user_description; ?>
						</dd>
					<?php endif; ?>
				</dl>
				<hr>
				<h2>Beiträge von <?php echo $curauth->nickname; ?></h2>
				<?php if ( $affiliseo_options['hide_blog_feed'] !== '1' ) : ?>
					<a href="<?php bloginfo( 'rss2_url' ); ?>"><i class="fa fa-rss fa-2x pull-right"></i></a>
				<?php endif; ?>
				<div class="clearfix"></div>
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
				?>
				<div class="text-center">
					<?php
					affiliseo_pagination();
					?>
				</div>
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