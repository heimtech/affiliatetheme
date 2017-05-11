<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../../wp-load.php');
require_once 'Affilinet.php';
require_once '../AffiliatePartner.php';

$affiliatePartner = new AffiliatePartner();

if (! isset($_GET['keyword']) && trim($_GET['keyword']) === '') {
    echo 'Keine Berechtigung';
    die();
}

require_once 'affilinetMandatoryOptions.php';
if (isset($affilinetSettingErrors) && strlen($affilinetSettingErrors) > 10) {
    echo $affilinetSettingErrors;
    exit();
}

$affilinetApi = new Affilinet($affilinetPublisherId, $affilinetPublisherPassword, $affilinetProductPassword, $affilinetLogonWsdl, $affilinetProductsWsdl);

/**
 * bereits importierte produkte ermitteln
 */
$existingProducts = $affiliatePartner->findImportedProducts('affilinet_product_id');

$page = (isset($_GET['page']) && $_GET['page'] != "") ? $_GET['page'] : 1;
$page = ($page < 0) ? 1 : $page;

$limit = (isset($_GET['products_per_page']) && $_GET['products_per_page'] > 0) ? $_GET['products_per_page'] : 10;

// pagination
$pagination = array(
    'CurrentPage' => $page,
    'PageSize' => $limit
);

$query = $_GET['keyword'];
;

$shopId = $_GET['ap_program_id'];
$shopId = (isset($shopId) && $shopId != "") ? $shopId : null;

// search parameters
$params = array(
    
    'Query' => $query,
    'WithImageOnly' => true,
    'MinimumPrice' => 0,
    'MaximumPrice' => 0,
    'PageSettings' => $pagination,
    'SortBy' => 'Score',
    'SortOrder' => 'descending',
    'ImageScales' => array(
        'OriginalImage'
    )
);

if ($shopId != null) {
    $params['ShopIds'] = array(
        $shopId
    );
}

$response = $affilinetApi->searchProducts($params);

$productsSummary = $response->ProductsSummary;

$currentPage = $productsSummary->CurrentPage;
$allPages = $productsSummary->TotalPages;

$navBar = $affiliatePartner->navBar($allPages, $currentPage, '', 20);

$tbl = '<a href="' . site_url() . '" id="blogurl" style="display: none;"></a>
<span id="affiliatePartner" style="display: none;">affilinet</span>';

$productManufacturers = $affiliatePartner->getProductManufacturers(array(
    'hide_empty' => 0
));
$productTypes = $affiliatePartner->getProductTypes(array(
    'hide_empty' => 0
));

if (is_object($response) && isset($response->Products) && count($response->Products) > 0) {
    
    $productIds = array();
    $sameProductCount = 0;
    
    $productSet = $response->Products->Product;
    
    $tbl .= '<table width="100%" border="0" class="search-results">';
    foreach ($productSet as $key => $value) {
        
        $product = $affiliatePartner->getProduct($value, 'affilinet');
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
        
        $params = array(
            'affiliatePartner' => 'affilinet',
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