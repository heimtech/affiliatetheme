<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once('../../../../../wp-load.php');

$taxonomy_singular = trim(filter_input(INPUT_GET, 'taxonomy_singular', FILTER_SANITIZE_STRING));
$taxonomy_plural = trim(filter_input(INPUT_GET, 'taxonomy_plural', FILTER_SANITIZE_STRING));
$taxonomy_slug = generate_slug($taxonomy_plural);

global $wpdb;
global $taxonomies_table;

$query = "INSERT INTO $taxonomies_table (taxonomy_singular, taxonomy_plural, taxonomy_slug) VALUES (%s, %s, %s)";
$res = $wpdb->query($wpdb->prepare($query, $taxonomy_singular, $taxonomy_plural, $taxonomy_slug));

if ($res === false) :
    ?>
    <div id="message" class="error below-h2"><p>Fehler beim Speichern!</p></div>
<?php else : ?>
    <div id="message" class="updated below-h2"><p>Taxonomie erfolgreich gespeichert!</p></div>
<?php endif; ?>

