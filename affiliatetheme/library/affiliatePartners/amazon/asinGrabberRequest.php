<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../../wp-load.php');

require_once 'amazonMandatoryOptions.php';
if (isset($amazonSettingErrors) && strlen($amazonSettingErrors) > 10) {
    echo $amazonSettingErrors;
    exit();
}

$amazonProductsPage = trim(filter_input(INPUT_POST, 'amazon_products_page', FILTER_SANITIZE_STRING));

if (strlen($amazonProductsPage) > 10) {
    
    require_once 'Amazon.php';
    
    $currency = get_option('ap_currency');
    
    $amazonApi = new Amazon($amazonPublicKey, $amazonPartnerId, $amazonSecretKey);
    
    $asinList = $amazonApi->grabAsinsFromUrl($amazonProductsPage);
}

if (count($asinList) > 0) {
    
    echo 'setAsinList("' . $asinList . '");' . "\n";
}