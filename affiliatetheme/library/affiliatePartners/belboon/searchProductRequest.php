<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../../wp-load.php');
require_once 'Belboon.php';
require_once '../AffiliatePartner.php';

$affiliatePartner = new AffiliatePartner();

if (! isset($_GET['keyword']) && trim($_GET['keyword']) === '') {
    echo 'Keine Berechtigung';
    die();
}

$apAdspaceId = $_GET['ap_adspace_id'];
$apProgramId = $_GET['ap_program_id'];

$keyword = $_GET['keyword'];
$belboonUsername = $_GET['belboon_username'];

$belboonUsername = get_option('belboon_username');
if (trim($belboonUsername) === '') {
    echo '<tr><td><strong style="color: #F00;">Kein Connect ID vergeben!</strong></td></tr>';
    return;
}
$belboonPassword = get_option('belboon_password');
if (trim($belboonPassword) === '') {
    echo '<tr><td><strong style="color: #F00;">Kein Secret key vergeben!</strong></td></tr>';
    return;
}

$belboonWsdl = get_option('belboon_wsdl');
if (trim($belboonWsdl) === '') {
    echo '<tr><td><strong style="color: #F00;">WSDL für Webservices vergeben!</strong></td></tr>';
    return;
}

$belboonApi = new Belboon($belboonUsername, $belboonPassword, $belboonWsdl);

$feeds = array();
$getFeeds = $belboonApi->getFeeds();
if ($feedItems = $getFeeds->Records) {
    if (is_array($feedItems)) {
        foreach ($feedItems as $key => $feedItem) {
            $feeds[$feedItem['id']] = $feedItem['program_name'];
        }
    }
}

/**
 * bereits importierte produkte ermitteln
 */
$existingProducts = $affiliatePartner->findImportedProducts('belboon_product_id');

$query = $keyword;
$adspaceId = (isset($apAdspaceId) && $apAdspaceId != "") ? $apAdspaceId : null;
$programId = (isset($apProgramId) && $apProgramId != "") ? $apProgramId : null;
$page = (isset($_GET['page']) && $_GET['page'] != "") ? $_GET['page'] : 1;
$page = ($page < 0) ? 1 : $page;

$limit = (isset($_GET['products_per_page']) && $_GET['products_per_page'] > 0) ? $_GET['products_per_page'] : 10;
$offset = ($page == 0) ? 1 : ($page + $limit);

$belboonSearchOptions = array();

$belboonSearchOptions['limit'] = $limit;
$belboonSearchOptions['offset'] = $offset;

if ($adspaceId != null) {
    $belboonSearchOptions['platforms'] = array(
        $adspaceId
    );
}

if ($programId != null) {
    $belboonSearchOptions['feeds'] = array(
        $programId
    );
}

$response = $belboonApi->searchProducts($query, $belboonSearchOptions);

if ($response->HasError && $response->ErrorMsg != "") {
    echo '<b style="color:red">' . $response->ErrorMsg . '!</b>';
}

$recordsTotal = (isset($response->NumRecordsTotal) && $response->NumRecordsTotal > 0) ? $response->NumRecordsTotal : 1;

$currentPage = $page;
$allPages = ceil($recordsTotal / $limit);

$navBar = $affiliatePartner->navBar($allPages, $currentPage, '', 20);

$tbl = '<a href="' . site_url(). '" id="blogurl" style="display: none;"></a>
<span id="affiliatePartner" style="display: none;">belboon</span>';

$productManufacturers = $affiliatePartner->getProductManufacturers(array(
    'hide_empty' => 0
));
$productTypes = $affiliatePartner->getProductTypes(array(
    'hide_empty' => 0
));

if (is_object($response) && isset($response->Records) && count($response->Records) > 0) {
    
    $productIds = array();
    $sameProductCount = 0;
    
    $tbl .= '<table width="100%" border="0" class="search-results">';
    foreach ($response->Records as $key => $value) {
        
        $product = $affiliatePartner->getProduct($value, 'belboon');
        
        $shopName = '';
        $programId = $product->getProgram();        
        if(isset($feeds[$programId]) && $feeds[$programId] !=""){
            $shopName = $feeds[$programId];            
        }        
        $product->setProductShopName($shopName);
        
        $productImages = $product->getImages();
        $apPID = $product->getProductId();
        
        if (in_array($apPID, $productIds)) {
            // $sameProductCount ++;
            // continue;
        }
        $productIds[] = $apPID;
        
        $trackingLinks = $product->getTrackingLinks();
        
        // ProductUrl
        $affiliateLink = $trackingLinks->affiliateLink;
        // BasketUrl
        $affiliateLinkCart = $trackingLinks->affiliateLinkCart;
        
        if (isset($productImages->firstImage)) {
            $imageUrl = $productImages->firstImage;
        }
        $imageListArray = array();
        if (isset($productImages->otherImages) && strlen($productImages->otherImages) > 10) {
            $imageListArray = explode('|', $productImages->otherImages);
        }
        
        $params = array(
            'affiliatePartner' => 'belboon',
            'imageListArray' => $imageListArray,
            'imageUrl' => $imageUrl,
            'apPID' => $apPID,
            'product' => $product,
            'existingProducts' => $existingProducts,
            'affiliateLink' => $affiliateLink,
            'affiliateLinkCart' => $affiliateLinkCart,
            'productManufacturers' => $productManufacturers,
            'productTypes' => $productTypes
        );
        $tbl .= $affiliatePartner->writeProductRow($params);
        
        if (! in_array($apPID, $existingProducts)) {
            $tbl .= $affiliatePartner->writeImportButtons($apPID);
        } else {
            $tbl .= $affiliatePartner->writeAllreadyImportedRow();
        }
    }
    $tbl .= '</table>';
    
    $tbl .= $affiliatePartner->writeImportAllRow();
    
    if ($sameProductCount > 0) {
        $tbl .= $affiliatePartner->writeHiddenProductsRow($sameProductCount);
    }
    
    $tbl .= $navBar;
}

$tbl .= $affiliatePartner->writeHanldePaginationKlick();

echo $tbl;

require_once dirname(__FILE__) . '/../quickImportJS.php';