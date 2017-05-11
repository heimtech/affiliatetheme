<?php
/*
 * Template Name: Produktvergleichstabelle
 */
global $affiliseo_options;
get_header();

the_post();
?>

<div class="custom-container custom-container-margin-top">
	<div class="full-size">
		<div id="content-wrapper" class="page">
			<div class="box content">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</div>

<?php

get_footer();