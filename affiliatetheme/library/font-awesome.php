<?php

/**
 * Created by IntelliJ IDEA.
 * User: Jan Sussujew
 * Date: 27.08.2014
 * Time: 11:48
 */
function add_shortcode_icons_button() {
	echo '<a href="#" id="shortcode_icons" class="shortcode_icons button"><i class="fa fa-flag"></i> Icons für Shortcodes</a>';
}

add_action( 'media_buttons', 'add_shortcode_icons_button' );

function add_enqueue( $hook ) {
	if ( 'post.php' != $hook && 'post-new.php' != $hook ) {
		return;
	}
	wp_enqueue_script( 'font_awesome_script', get_template_directory_uri() . '/library/admin/js/font-awesome.js' );
}

add_action( 'admin_enqueue_scripts', 'add_enqueue' );

function add_fontawesome_template() {
	global $pagenow;
	if ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) {
		ob_start();
		?>
		<div id="icons-container">
			<div id="icons-header">
				<h1>
					<i class="fa fa-flag"></i>
					Font Awesome Icons generieren
					<div class="pull-right">
						<i id="icons-close" class="fa fa-times"></i>
					</div>
				</h1>
			</div>
			<div class="icons-content">
				Hier können Sie Ihrem Text Font Awesome Icons hinzufügen. Klicken Sie dazu einfach auf eines der Icons.
				<br>
				<br>
				<strong>
					Größe des Icons:
					<br>
				</strong>
				<input type="radio" name="size" value="1" id="1">
				<label for="1">1 </label>
				<input type="radio" name="size" value="2" id="2">
				<label for="2">2 </label>
				<input type="radio" name="size" value="3" id="3">
				<label for="3">3 </label>
				<input type="radio" name="size" value="4" id="4">
				<label for="4">4 </label>
				<input type="radio" name="size" value="5" id="5">
				<label for="5">5 </label>
			</div>
			<div class="icons-content">
				<strong>Bitte beachten Sie:</strong>
				<br>
				Durch Klick auf ein Icon wird ein Shortcode für ein Icon innerhalb des Textes erzeugt. Wenn Sie ein Icon innerhalb des Titels eines Tabs oder eines Toggles einfügen wollen, dann setzen Sie ein Häckchen vor "Tabs mit Icons" oder "Toggles mit Icon". Nach dem Klick auf ein Icon wird der Shortcode für Tabs oder Toggles mit Icon generiert.
				<br>
				<br>
				<p>
					<input id="tabs" type="checkbox">
					<label for="tabs">Tabs mit Icons</label>
				</p>
				<p>
					<input id="toggles" type="checkbox">
					<label for="toggles">Toggles mit Icon</label>
				</p>
			</div>
			<div id="icons-content-icons" class="icons-content">
			</div>
		</div>
		<a href="<?php echo site_url(); ?>" id="blogurl" style="display: none;"></a>
		<?php
		echo ob_get_clean();
	}
}

add_action( 'in_admin_header', 'add_fontawesome_template' );
