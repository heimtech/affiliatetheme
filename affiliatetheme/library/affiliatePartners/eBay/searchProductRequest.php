<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../../wp-load.php');
require_once 'Ebay.php';
require_once '../AffiliatePartner.php';

$affiliatePartner = new AffiliatePartner();

if (! isset($_GET['keyword']) && trim($_GET['keyword']) === '') {
    echo 'Keine Berechtigung';
    die();
}

$keyword = $_GET['keyword'];

require_once 'getOptions.php';

$eBayApi = new Ebay($publisherData);

/**
 * bereits importierte produkte ermitteln
 */
$existingProducts = $affiliatePartner->findImportedProducts('eBay_product_id');

$query = $keyword;
$page = (isset($_GET['page']) && $_GET['page'] != "") ? $_GET['page'] : 1;
$page = ($page < 0) ? 1 : $page;

$limit = (isset($_GET['products_per_page']) && $_GET['products_per_page'] > 0) ? $_GET['products_per_page'] : 10;

$searchParams = array(
    'entriesPerPage' => $limit,
    'pageNumber' => $page
);

$searchFilter = array(
    array(
        'name' => 'ListingType',
        'value' => array(
            'FixedPrice'
        ),
        'paramName' => '',
        'paramValue' => ''
    )
);

if (isset($_GET['eBay_min_price']) && $_GET['eBay_min_price'] >= 0) {
    array_push($searchFilter, array(
        'name' => 'MinPrice',
        'value' => $_GET['eBay_min_price']
    ));
}
if (isset($_GET['eBay_max_price']) && $_GET['eBay_max_price'] > 0) {
    array_push($searchFilter, array(
        'name' => 'MaxPrice',
        'value' => $_GET['eBay_max_price']
    ));
}

if (isset($_GET['eBay_category_id']) && $_GET['eBay_category_id'] >= 0) {
    $searchParams['categoryId'] = $_GET['eBay_category_id'];
}

// $eBayCategories = $eBayApi->getCategories();

$response = $eBayApi->findItemsAdvanced($query, $searchParams, $searchFilter);

$paginationOutput = $response->paginationOutput;
$totalEntries = (isset($paginationOutput->totalEntries) && $paginationOutput->totalEntries > 0) ? $paginationOutput->totalEntries : 1;

$currentPage = $page;
$allPages = ceil($totalEntries / $limit);

$navBar = $affiliatePartner->navBar($allPages, $currentPage, '', 20);

$tbl = '<a href="' . site_url(). '" id="blogurl" style="display: none;"></a>
<span id="affiliatePartner" style="display: none;">eBay</span>';

$productManufacturers = $affiliatePartner->getProductManufacturers(array('hide_empty' => 0));
$productTypes = $affiliatePartner->getProductTypes(array('hide_empty' => 0));

if (is_object($response) && $totalEntries > 0) {
    
    $productIds = array();
    $sameProductCount = 0;
    
    $tbl .= '<table width="100%" border="0" class="search-results">';
    foreach ($response->searchResult->item as $key => $value) {
        
        $product = $affiliatePartner->getProduct($value, 'eBay');
        $productImages = $product->getImages();
        $apPID = $product->getProductId();
        
        if (in_array($apPID, $productIds)) {
            // $sameProductCount ++;
            // continue;
        }
        $productIds[] = $apPID;
        
        $trackingLinks = $product->getTrackingLinks();
        
        //ProductUrl
        $affiliateLink = $trackingLinks->affiliateLink;        
        //BasketUrl
        $affiliateLinkCart = $trackingLinks->affiliateLinkCart;
        
        if (isset($productImages->large)) {
            $imageUrl = $productImages->large;
        }
        elseif (isset($productImages->medium)) {
            $imageUrl = $productImages->medium;
        }
        elseif (isset($productImages->small)) {
            $imageUrl = $productImages->small;
        }
        
        if (isset($productImages->firstImage)) {
            $imageUrl = $productImages->firstImage;
        }
        $imageListArray = array();
        if (isset($productImages->otherImages) && strlen($productImages->otherImages) > 10) {
            $imageListArray = explode('|', $productImages->otherImages);
        }
        
        $params = array(
            'affiliatePartner' => 'eBay',
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