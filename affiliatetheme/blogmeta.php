<small class="blog-meta">veröffentlicht am <?php the_time( 'j. F Y' ); ?>
	<?php
	$categories = get_the_category();
	$separator = ', ';
	$output = ' in ';
	if ( $categories ) {
		foreach ( $categories as $category ) {
			$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "Alle Beiträge in %s anzeigen" ), $category->name ) ) . '">' . $category->cat_name . '</a>' . $separator;
		}
		echo trim( $output, $separator );
	}
	?>
	von
	<?php the_author_posts_link(); ?>
</small>