<?php

header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once('../../../../../../wp-load.php');

$publisherid = trim(filter_input(INPUT_GET, 'publisherID', FILTER_SANITIZE_STRING));
$publisherpw = trim(filter_input(INPUT_GET, 'publisherpw', FILTER_SANITIZE_STRING));
$productpw = trim(filter_input(INPUT_GET, 'productpw', FILTER_SANITIZE_STRING));

if ($publisherid === '') {
    echo '<tr><td><strong style="color: #F00;">Keine PublisherID angegeben!</strong></td></tr>';
    return;
}
if ($publisherpw === '') {
    echo '<tr><td><strong style="color: #F00;">Kein Publisher Passwort angegeben!</strong></td></tr>';
    return;
}
if ($productpw === '') {
    echo '<tr><td><strong style="color: #F00;">Kein Produkt Passwort angegeben!</strong></td></tr>';
    return;
}

update_option('affilinet_publisher_id', $publisherid);
update_option('affilinet_publisher_password', $publisherpw);
update_option('affilinet_product_password', $productpw);

define("WSDL_LOGON", "https://api.affili.net/V2.0/Logon.svc?wsdl");
define("WSDL", "https://api.affili.net/V2.0/AccountService.svc?wsdl");

try {
    $SOAP_LOGON = new SoapClient(WSDL_LOGON);
    $Token = $SOAP_LOGON->Logon(array(
        'Username' => $publisherid,
        'Password' => $publisherpw,
        'WebServiceType' => 'Publisher'
            ));

    $SOAP_REQUEST = new SoapClient(WSDL);
    $req = $SOAP_REQUEST->GetPublisherSummary($Token);

    echo '<div id="message" class="updated below-h2"><p>Erfolgreich Verbindung zu Affili.net hergestellt!</p></div>';
    if ($req->Partnerships->PartnershipsActive === 0) {
        echo '<div id="message" class="error"><p>Sie haben keine Partnerschaften auf Affili.net!</p></div>';
    } else {
        echo '<p>Sie haben ' . $req->Partnerships->PartnershipsActive . ' Partnerschaften auf Affili.net.</p>';
    }
} catch (SoapFault $e) {
    echo "Request:\n" . ($SOAP_LOGON->__getLastRequest()) . "\n";
    echo "Response:\n" . ($SOAP_LOGON->__getLastResponseHeaders()) . "\n";
    echo "Response:\n" . ($SOAP_LOGON->__getLastResponse()) . "\n";
    echo '<div id="message" class="error"><p><strong>Fehler!</strong> Login fehlgeschlagen. Übersprüfen Sie Ihre Einstellungen!</p></div>';
    echo($e->getMessage());
} catch (Exception $e) {
    echo $e->getMessage();
}
