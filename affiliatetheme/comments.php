<?php
global $affiliseo_options;
global $post;
$comments_headline_product = trim( $affiliseo_options['comments_headline_product'] );
?>

<div id="kommentar_formular">

    <form action="<?php echo get_option( 'siteurl' ); ?>/wp-comments-post.php" method="post" id="commentform" class="full-size custom-comments">
		<?php if ( $post->post_type === 'produkt' ): ?>
			<?php if ( trim( $comments_headline_product ) === '' ): ?>
				<h3 id="respond">Kommentar schreiben</h3>
			<?php endif; ?>
			<h3 id="respond"><?php echo $comments_headline_product; ?></h3>
		<?php else: ?>
			<h3 id="respond">Kommentar schreiben</h3>
			<?php if ( $affiliseo_options['hide_comment_feed'] !== '1' ) : ?>
				<a href="<?php the_permalink(); ?>feed/" class="pull-right" title="Kommentar-Feed"><i class="fa fa-rss fa-2x "></i></a>
			<?php endif; ?>
			<div class="clearfix"></div>
		<?php endif; ?>

        <div class="col4 col4-first">
            <div><label for="author">Name</label></div>
            <input type="text" class="form-control" name="author" id="author" value="<?php echo $comment_author; ?>" placeholder="Name" />
        </div>

        <div class="col4">
            <div><label for="email">E-Mail <small>(wird nicht veröffentlicht)</small></label></div>
            <input type="email" class="form-control" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" placeholder="E-Mail" />
        </div>

        <div class="col4 col4-last">
            <div><label for="url">Webseite</label></div>
            <input type="url" class="form-control" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" placeholder="Webseite" />
        </div>
        <div class="clearfix"></div>
		<div class="p-tag"><label for="comment">Kommentar</label></div>
		<textarea class="form-control" name="comment" id="comment" style="width: 100%;" rows="10" tabindex="4" placeholder="Kommentar"></textarea>

        <p>
            <input name="submit" type="submit" id="submit" tabindex="5" value="Kommentar abschicken" class="btn btn-submit" />
            <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
        </p>

		<?php do_action( 'comment_form', $post->ID ); ?>

    </form>

</div>

<hr>

<div id="kommentare" class="custom-comments">
	<?php
	$output = '';
	switch ( count( $comments ) ) {
		case 0:
			$output = '<h4>Noch keine Kommentare</h4>';
			break;
		case 1:
			$output = '<h4>Ein Kommentar</h4>';
			break;
		default:
			$output = '<h4>' . count( $comments ) . ' Kommentare</h4>';
	}
	echo $output;
	foreach ( $comments as $comment ) :
		?>

		<div class="comment" id="comment-<?php comment_ID(); ?>">

			<small class="commentmetadata"><?php echo get_comment_author_link(); ?> am <?php comment_date( 'j. F Y' ) ?> um <?php comment_time( 'H:i' ) ?> Uhr</small>

			<?php comment_text() ?>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<strong>Achtung: Dein Kommentar muss erst noch freigegeben werden.</strong><br />
			<?php endif; ?>

		</div>
	<?php endforeach; ?>
</div>