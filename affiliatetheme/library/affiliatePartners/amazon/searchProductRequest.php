<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../../wp-load.php');
require_once '../AffiliatePartner.php';
require_once 'Amazon.php';

$AffiliatePartner = new AffiliatePartner();

$asinSearch = false;
$asinSearchList = array();

if (! isset($_GET['keyword']) && trim($_GET['keyword']) === '') {
    echo 'Keine Berechtigung';
    die();
}

$keyword = $_GET['keyword'];

require_once 'amazonMandatoryOptions.php';
if (isset($amazonSettingErrors) && strlen($amazonSettingErrors) > 10) {
    echo $amazonSettingErrors;
    exit();
}

// $public_key
$amazonApi = new Amazon($amazonPublicKey, $amazonPartnerId, $amazonSecretKey);

/**
 * bereits importierte produkte ermitteln
 */
$existingProducts = $AffiliatePartner->findImportedProducts('amazon_produkt_id');

$page = (isset($_GET['page']) && $_GET['page'] != "") ? $_GET['page'] : 1;
$page = ($page < 0) ? 1 : $page;
$items = 10;

$parameters = array(
    'Keywords' => $keyword,
    'ItemPage' => $page,
    'country' => $country
);

$asinSearchCountProducts = 0;
$asinSearchMaxProducts = 50;
$asinSearchProducts = array();
if (stristr($keyword, ',')) {
    $asinSearchList = explode(',', $keyword);
    
    $asinSearchList = array_unique($asinSearchList);
    
    if (count($asinSearchList) > 0) {
        foreach ($asinSearchList as $asinSearchItem) {
            $asinSearchItem = trim($asinSearchItem);
            if (strlen($asinSearchItem) > 3) {
                if ($asinSearchProduct = $AffiliatePartner->getApSingleProduct($asinSearchItem, 'amazon')) {
                    $asinSearchProducts[] = $asinSearchProduct;
                    $asinSearchCountProducts++;
                }
                usleep(1200000);
            }
            
            if($asinSearchCountProducts >= $asinSearchMaxProducts){
                break;
            }
        }
    }
}

$amazonSearchIndex = filter_input(INPUT_GET, 'amazon_search_index', FILTER_SANITIZE_STRING);
if (strlen($amazonSearchIndex) > 0) {
    $parameters['search_index'] = $amazonSearchIndex;
}

$amazonProductsXml = $amazonApi->searchProducts($parameters);

if ($amazonProductsXml->Error) {
    echo '<tr><td><strong style="color: #F00;">ERROR - ' . $amazonProductsXml->Error->Code . '</strong><br />';
    echo '<span style="color: #F00;">' . $amazonProductsXml->Error->Message . '</span></td><td></td></tr>';
    return;
}

$currentPage = $page;

$recordsTotal = (isset($amazonProductsXml->Items->TotalPages)) ? intval($amazonProductsXml->Items->TotalPages) : 1;
$allPages = ceil($recordsTotal / $items);
$allPages = ($allPages > 10) ? 10 : $allPages;

$navBar = $AffiliatePartner->navBar($allPages, $currentPage, '', 20);

$tbl = '<a href="' . site_url() . '" id="blogurl" style="display: none;"></a>
<span id="affiliatePartner" style="display: none;">amazon</span>';

$productManufacturers = $AffiliatePartner->getProductManufacturers(array(
    'hide_empty' => 0
));
$productTypes = $AffiliatePartner->getProductTypes(array(
    'hide_empty' => 0
));

if (count($amazonProductsXml->Items->Item) > 0 || count($asinSearchProducts) > 0) {
    
    $sameProductCount = 0;
    
    $tbl .= '<table width="100%" border="0" class="search-results">';
    
    $amazonSearchItems = $amazonProductsXml->Items->Item;
    if (count($asinSearchProducts) > 0) {
        $amazonSearchItems = $asinSearchProducts;
        $asinSearch = true;
    }
    
    foreach ($amazonSearchItems as $item) {
        
        if ($asinSearch) {
            $product = $item;
            $customerReviews = $product->getCustomerReviews();
        } else {
            $product = $AffiliatePartner->getProduct($item, 'amazon');
            $customerReviews = $item->CustomerReviews;
        }
        
        $iframeUrl = $customerReviews->IFrameURL->__toString();
        $amazonImportStarRating = get_option('amazon_import_star_rating');
        
        $starRating = '';
        if (intval($amazonImportStarRating) == 1) {
            $starRating = $amazonApi->getStarRatingFromIframeUrl($iframeUrl);
        }
        
        $product->setStarRating($starRating);
        
        $productImages = $product->getImages();
        $apPID = $product->getProductId();
        
        $trackingLinks = $product->getTrackingLinks();
        
        $affiliateLink = $trackingLinks->affiliateLink;
        $affiliateLinkCart = $trackingLinks->affiliateLinkCart;
        
        if (isset($productImages->firstImage)) {
            $imageUrl = $productImages->firstImage;
        }
        
        $imageListArray = array();
        if (isset($productImages->otherImages) && strlen($productImages->otherImages) > 10) {
            $imageListArray = explode('|', $productImages->otherImages);
        }
        
        $params = array(
            'affiliatePartner' => 'amazon',
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
        
        $tbl .= $AffiliatePartner->writeProductRow($params);
        
        if (! in_array($apPID, $existingProducts)) {
            $tbl .= $AffiliatePartner->writeImportButtons($apPID);
        } else {
            $tbl .= $AffiliatePartner->writeAllreadyImportedRow();
        }
    }
    $tbl .= '</table>';
    
    $tbl .= $AffiliatePartner->writeImportAllRow();
    
    if ($sameProductCount > 0) {
        $tbl .= $AffiliatePartner->writeHiddenProductsRow($sameProductCount);
    }
    
    if (! $asinSearch) {
        $tbl .= $navBar;
    }
}

if (! $asinSearch) {
    $tbl .= $AffiliatePartner->writeHanldePaginationKlick();
}

echo $tbl;

require_once dirname(__FILE__) . '/../quickImportJS.php';