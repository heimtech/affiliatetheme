<?php

function comparisonMenuPage() {
    add_menu_page(
        "Vergleichstabelle", 
        "Vergleichstabelle", 
        'manage_options', 
        'comparisonAttributes', 
        'loadComparisonAttributesOverview'
    );
}

add_action('admin_menu', 'comparisonMenuPage');

function loadComparisonAttributesOverview() {
    ob_start();
    include_once(AFFILISEO_LIBRARY  . '/comparison/attributes.php');
    echo ob_get_clean();
}