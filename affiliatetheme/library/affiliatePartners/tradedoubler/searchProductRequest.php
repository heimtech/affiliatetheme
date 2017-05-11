<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../../wp-load.php');
require_once 'Tradedoubler.php';
require_once '../AffiliatePartner.php';

$affiliatePartner = new AffiliatePartner();

if (! isset($_GET['keyword']) && trim($_GET['keyword']) === '') {
    echo 'Keine Berechtigung';
    die();
}

$keyword = $_GET['keyword'];

$tradedoublerToken = get_option('tradedoubler_token');
if (trim($tradedoublerToken) === '') {
    echo '<tr><td><strong style="color: #F00;">Kein Token vergeben!</strong></td></tr>';
    return;
}

$tradedoublerApiUrl = get_option('tradedoubler_api_url');
if (trim($tradedoublerApiUrl) === '') {
    echo '<tr><td><strong style="color: #F00;">Kein URL für Webservices vergeben!</strong></td></tr>';
    return;
}

$language = get_option('tradedoubler_search_region');

$tradedoublerApi = new Tradedoubler($tradedoublerToken, $tradedoublerApiUrl);

/**
 * bereits importierte produkte ermitteln
 */
$existingProducts = $affiliatePartner->findImportedProducts('tradedoubler_product_id');

$query = $keyword;
$page = (isset($_GET['page']) && $_GET['page']!="") ? $_GET['page']:1;
$page = ( $page < 0 ) ? 1 : $page;

$productsPerPage = (isset($_GET['products_per_page']) && $_GET['products_per_page'] > 0) ? $_GET['products_per_page']:10;
$offset = ( $page == 0 ) ? 1 : ($page + $productsPerPage);
$limit = $productsPerPage*$page+$productsPerPage;
$queryKeys = array(
    'q' => $query,
    'page' => $page, // Which page of result to return, given limit and pageSize is set.
   'pageSize' => $productsPerPage, // The maximum number of items to return.
   'language' => $language,
    'limit' => $limit
);

$apProgramId = $_GET['ap_program_id'];
$programId = (isset($apProgramId) && $apProgramId !="" ) ? $apProgramId:null;

if($programId!=null){
    $queryKeys['fid'] = $programId;
}

$response = $tradedoublerApi->searchProducts($queryKeys);

$recordsTotal = (isset($response->productHeader->totalHits) && $response->productHeader->totalHits > 0)?$response->productHeader->totalHits:1;

$currentPage = $page;
$allPages = ceil($recordsTotal / $productsPerPage);

$navBar = $affiliatePartner->navBar($allPages, $currentPage, '', 20);

$tbl = '<a href="'.site_url().'" id="blogurl" style="display: none;"></a>
<span id="affiliatePartner" style="display: none;">tradedoubler</span>';

$productManufacturers = $affiliatePartner->getProductManufacturers(array('hide_empty' => 0));
$productTypes = $affiliatePartner->getProductTypes(array('hide_empty' => 0));

if (is_object($response) && $recordsTotal > 0) {
    
    $productIds = array();
    $sameProductCount = 0;
    
    $tbl .= '<table width="100%" border="0" class="search-results">';
    foreach ($response->products->product as $key => $value) {
        
        $product = $affiliatePartner->getProduct($value, 'tradedoubler');
        $productImages = $product->getImages();
        $apPID = $product->getProductId();
        
        if(in_array($apPID,$productIds)){
            //$sameProductCount ++;
            //continue;            
        }
        $productIds[] = $apPID;
        
        $trackingLinks = $product->getTrackingLinks();
        
        //ProductUrl
        $affiliateLink = $trackingLinks->affiliateLink;        
        //BasketUrl
        $affiliateLinkCart = $trackingLinks->affiliateLinkCart;
        
        if (isset($productImages->firstImage)) {
	       $imageUrl = $productImages->firstImage;
        }
        $imageListArray = array();
        if (isset($productImages->otherImages) && strlen($productImages->otherImages) > 10) {
	       $imageListArray = explode('|', $productImages->otherImages);
        }
        
        $params = array(
            'affiliatePartner' => 'tradedoubler',
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
        
        if(!in_array($apPID,$existingProducts)){
            $tbl .= $affiliatePartner->writeImportButtons($apPID);            
        } else {
            $tbl .= $affiliatePartner->writeAllreadyImportedRow();
        }
    }
    $tbl .= '</table>';
    
    $tbl .= $affiliatePartner->writeImportAllRow();
    
    if($sameProductCount > 0){
        $tbl .= $affiliatePartner->writeHiddenProductsRow($sameProductCount);
    }
    
    $tbl .= $navBar;
}

$tbl .= $affiliatePartner->writeHanldePaginationKlick();

echo $tbl;

require_once dirname(__FILE__).'/../quickImportJS.php';