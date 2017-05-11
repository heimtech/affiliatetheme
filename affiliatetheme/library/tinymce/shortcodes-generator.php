<?php

function add_button() {
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
		add_filter( 'mce_external_plugins', 'add_plugin' );
		add_filter( 'mce_buttons_3', 'register_columns' );
		add_filter( 'mce_buttons_3', 'register_separators' );
		add_filter( 'mce_buttons_3', 'register_buttons' );
		add_filter( 'mce_buttons_3', 'register_alerts' );
		add_filter( 'mce_buttons_3', 'register_liststyles' );
		add_filter( 'mce_buttons_3', 'register_outbox' );
		add_filter( 'mce_buttons_3', 'register_elements' );
	}
}

function register_columns( $buttons ) {
	array_push( $buttons, "columns" );
	return $buttons;
}

function register_separators( $buttons ) {
	array_push( $buttons, "separators" );
	return $buttons;
}

function register_buttons( $buttons ) {
	array_push( $buttons, "buttons" );
	return $buttons;
}

function register_alerts( $buttons ) {
	array_push( $buttons, "alerts" );
	return $buttons;
}

function register_liststyles( $buttons ) {
	array_push( $buttons, "liststyles" );
	return $buttons;
}

function register_outbox( $buttons ) {
	array_push( $buttons, "outbox" );
	return $buttons;
}

function register_elements( $buttons ) {
	array_push( $buttons, "elements" );
	return $buttons;
}

function add_plugin( $plugin_array ) {
	$plugin_array['shortcodes'] = get_template_directory_uri() . '/library/tinymce/shortcodes.js';
	return $plugin_array;
}

add_action( 'init', 'add_button' );
