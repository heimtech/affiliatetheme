<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../../wp-load.php');
require_once '../AffiliatePartner.php';
require_once 'Zanox.php';

$affiliatePartner = new AffiliatePartner();

if (! isset($_GET['keyword']) && trim($_GET['keyword']) === '') {
    echo 'Keine Berechtigung';
    die();
}

$keyword = $_GET['keyword'];
$apAdspaceId = $_GET['ap_adspace_id'];

require_once 'zanoxMandatoryOptions.php';
if (isset($zanoxSettingErrors) && strlen($zanoxSettingErrors) > 10) {
    echo $zanoxSettingErrors;
    exit();
}

$zanoxApi = new Zanox($zanoxSecretKey, $zanoxConnectId, $zanoxSearchRegion);

/**
 * bereits importierte produkte ermitteln
 */
$existingProducts = $affiliatePartner->findImportedProducts('zanox_product_id');

$apProgramId = $_GET['ap_program_id'];
$apProgramId = (isset($apProgramId) && $apProgramId != "") ? $apProgramId : null;
$adspaceId = (isset($apAdspaceId) && $apAdspaceId != "") ? $apAdspaceId : null;

$page = (isset($_GET['page']) && $_GET['page'] != "") ? $_GET['page'] - 1 : 0;
$page = ($page < 0) ? 0 : $page;
$items = (isset($_GET['products_per_page']) && $_GET['products_per_page'] > 0) ? $_GET['products_per_page'] : 10;

$parameter = array(
    'q' => $keyword,
    'searchtype' => 'phrase',
    'region' => $zanoxSearchRegion,
    'hasimages' => 'true',
    'minprice' => 0,
    'page' => $page,
    'items' => $items
);



if ($apProgramId != null && $apProgramId > 0) {
    $parameter['programs'] = $apProgramId;
}
if ($adspaceId != null && $adspaceId > 0) {
    $parameter['adspace'] = $adspaceId;
}

$request = $zanoxApi->searchProducts($parameter);

$products = json_decode($request);

$currentPage = (isset($products->page)) ? intval($products->page) : 1;
$currentPage = ($currentPage == 0) ? 1 : $currentPage + 1;
$recordsTotal = (isset($products->total)) ? intval($products->total) : 1;

$allPages = ceil($recordsTotal / $items);

$navBar = $affiliatePartner->navBar($allPages, $currentPage, '', 20);

$tbl = '<a href="' . site_url() . '" id="blogurl" style="display: none;"></a>
<span id="affiliatePartner" style="display: none;">zanox</span>';

$productManufacturers = $affiliatePartner->getProductManufacturers(array(
    'hide_empty' => 0
));
$productTypes = $affiliatePartner->getProductTypes(array(
    'hide_empty' => 0
));

if (is_object($products->productItems) && count($products->productItems) > 0) {
    
    $productIds = array();
    $sameProductCount = 0;
    
    $tbl .= '<table width="100%" border="0" class="search-results">';
    foreach ($products->productItems->productItem as $key => $value) {
        
        $product = $affiliatePartner->getProduct($value, 'zanox');
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
        $affiliateLinkCart = '';
        
        if (isset($productImages->firstImage)) {
            $imageUrl = $productImages->firstImage;
        }
        $imageListArray = array();
        if (isset($productImages->otherImages) && strlen($productImages->otherImages) > 10) {
            $imageListArray = explode('|', $productImages->otherImages);
        }
        
        $params = array(
            'affiliatePartner' => 'zanox',
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