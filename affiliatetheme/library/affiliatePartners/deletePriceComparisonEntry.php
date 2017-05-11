<?php

header( 'Content-Type: text/html; charset=utf-8' );
define( 'WP_USE_THEMES', false );
require_once('../../../../../wp-load.php');

$productId = trim( filter_input( INPUT_POST, 'product_id', FILTER_SANITIZE_STRING ) );

$productComparison = new PriceComparison();

$productComparison->deletePriceComparisonEntry($productId);

echo '<div id="message" class="updated below-h2"><p>Preisvergleich erfolgreich gelöscht!</p></div>';