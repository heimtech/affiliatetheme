<?php
$eBayAppId = get_option('eBay_app_id');
if (trim($eBayAppId) === '') {
    echo '<tr><td><strong style="color: #F00;">Keine AppID vergeben!</strong></td></tr>';
    return;
}

$eBayServiceEndpoint = get_option('eBay_service_endpoint');
if (trim($eBayServiceEndpoint) === '') {
    echo '<tr><td><strong style="color: #F00;">Kein URL für Webservices vergeben!</strong></td></tr>';
    return;
}

$eBayGlobalId = get_option('eBay_global_id');
if (trim($eBayGlobalId) === '') {
    echo '<tr><td><strong style="color: #F00;">Keine Global ID vergeben!</strong></td></tr>';
    return;
}

$eBayApiVersion = get_option('eBay_api_version');
if (trim($eBayApiVersion) === '') {
    echo '<tr><td><strong style="color: #F00;">Kein Api-Version vergeben!</strong></td></tr>';
    return;
}

$affiliateTrackingId = get_option('eBay_campaign_id');
if (trim($affiliateTrackingId) === '') {
    echo '<tr><td><strong style="color: #F00;">Keine Kampagnen-ID vergeben!</strong></td></tr>';
    return;
}

$affiliateCustomId = get_option('eBay_custom_id');
if (trim($affiliateCustomId) === '') {
    echo '<tr><td><strong style="color: #F00;">Keine Benutzerdefinierte Affiliate-ID vergeben!</strong></td></tr>';
    return;
}

$publisherData = array(
    'eBayAppId' => $eBayAppId,
    'eBayServiceEndpoint' => $eBayServiceEndpoint,
    'eBayGlobalId' => $eBayGlobalId,
    'eBayApiVersion' => $eBayApiVersion,
    'affiliateTrackingId' => $affiliateTrackingId,
    'affiliateNetworkId' => 9,
    'affiliateCustomId' => $affiliateCustomId
);