<?php
$amazonSettingErrors = '';
$amazonPublicKey = get_option('amazon_public_key');
if (trim($amazonPublicKey) === '') {
    $amazonSettingErrors .= '<strong style="color: #F00;">Kein amazon Public Key vergeben!</strong><br />';
}

$amazonSecretKey = get_option('amazon_secret_key');
if (trim($amazonSecretKey) === '') {
    $amazonSettingErrors .= '<strong style="color: #F00;">Kein amazon Secret Key vergeben!</strong><br />';
}

$amazonPartnerId = get_option('amazon_partner_id');
if (trim($amazonPartnerId) === '') {
    $amazonSettingErrors .= '<strong style="color: #F00;">Keine amazon Partner ID vergeben!</strong><br />';
}

$country = get_option('ap_currency');
if (trim($country) === '') {
    $amazonSettingErrors .= '<strong style="color: #F00;">Keine amazon Währung angegeben!</strong><br />';
}
