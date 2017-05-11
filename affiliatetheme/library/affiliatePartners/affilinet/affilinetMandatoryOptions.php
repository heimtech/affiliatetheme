<?php
$affilinetSettingErrors = '';
$affilinetPublisherId = get_option('affilinet_publisher_id');
if (trim($affilinetPublisherId) === '') {
    $affilinetSettingErrors .= '<strong style="color: #F00;">Kein affilinet PublisherID vergeben!</strong><br />';
}
$affilinetPublisherPassword = get_option('affilinet_publisher_password');
if (trim($affilinetPublisherPassword) === '') {
    $affilinetSettingErrors .= '<strong style="color: #F00;">Kein affilinet Publisher Webservice-Passwort vergeben!</strong><br />';
}

$affilinetProductPassword = get_option('affilinet_product_password');
if (trim($affilinetProductPassword) === '') {
    $affilinetSettingErrors .= '<strong style="color: #F00;">Kein affilinet Produkt Webservice-Passwort vergeben!</strong><br />';
}

$affilinetLogonWsdl = get_option('affilinet_logon_wsdl');
if (trim($affilinetLogonWsdl) === '') {
    $affilinetSettingErrors .= '<strong style="color: #F00;">Kein affilinet WSDL für Loginservice vergeben!</strong><br />';
}

$affilinetProductsWsdl = get_option('affilinet_products_wsdl');
if (trim($affilinetProductsWsdl) === '') {
    $affilinetSettingErrors .= '<strong style="color: #F00;">Kein affilinet WSDL für Produktservice vergeben!</strong><br />';
}