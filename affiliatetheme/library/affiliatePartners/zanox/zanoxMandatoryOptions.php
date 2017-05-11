<?php
$zanoxSettingErrors = '';
$zanoxConnectId = get_option('zanox_connect_id');
if (trim($zanoxConnectId) === '') {
    $zanoxSettingErrors .= '<strong style="color: #F00;">Kein zanox Connect ID vergeben!</strong><br />';
}

$zanoxSecretKey = get_option('zanox_secret_key');
if (trim($zanoxSecretKey) === '') {
    $zanoxSettingErrors .= '<strong style="color: #F00;">Kein zanox Secret key vergeben!</strong><br />';
}

$zanoxSearchRegion = get_option('zanox_search_region');
if (trim($zanoxSearchRegion) === '') {
    $zanoxSearchRegion = 'DE';
}
