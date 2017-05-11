<?php
global $amazonProductsXml;

function affiliseo_menu_page() {
    add_menu_page(
        "Partnerübersicht", 
        "Affiliate Partners", 
        'manage_options', 
        'affiliatePartners', 
        'loadAffiliatePartnersOverview'
    );
    
    // amazon
    add_submenu_page(
        null,
        'Amazon-Schnittstelle',
        'Amazon-Schnittstelle',
        'manage_options',
        'amazon-api-settings',
        'loadAffiliatePartnerSettings'
    );
    add_submenu_page(
        null, 
        'Produkte von Amazon importieren', 
        'Produkte von Amazon importieren', 
        'manage_options', 
        'products-from-amazon-search', 
        'loadAffiliatePartnerSearchProducts'
    );
    
    
    add_submenu_page(
        null, 
        'Preise von Amazon importieren', 
        'Preise von Amazon importieren', 
        'manage_options', 
        'prices-from-amazon-search', 
        'loadAffiliatePartnerPrices');
    
    // zanox
    add_submenu_page(
        null,
        'Zanox-Schnittstelle',
        'Zanox-Schnittstelle',
        'manage_options',
        'zanox-api-settings',
        'loadAffiliatePartnerSettings'
    );
    add_submenu_page(
        null,
        'Produkte von Zanox importieren',
        'Produkte von Zanox importieren',
        'manage_options',
        'products-from-zanox-search',
        'loadAffiliatePartnerSearchProducts'        
    );
    add_submenu_page(
        null,
        'Preise von Zanox importieren',
        'Preise von Zanox importieren',
        'manage_options',
        'prices-from-zanox-search',
        'loadAffiliatePartnerPrices');
    
    
    // belboon
    add_submenu_page(
        null,
        'Belboon-Schnittstelle',
        'Belboon-Schnittstelle',
        'manage_options',
        'belboon-api-settings',
        'loadAffiliatePartnerSettings'
        );
    add_submenu_page(
        null,
        'Produkte von Belboon importieren',
        'Produkte von Belboon importieren',
        'manage_options',
        'products-from-belboon-search',
        'loadAffiliatePartnerSearchProducts'
        );
    add_submenu_page(
        null,
        'Preise von Belboon importieren',
        'Preise von Belboon importieren',
        'manage_options',
        'prices-from-belboon-search',
        'loadAffiliatePartnerPrices');
    
    // affilinet
    add_submenu_page(
        null,
        'Affilinet-Schnittstelle',
        'Affilinet-Schnittstelle',
        'manage_options',
        'affilinet-api-settings',
        'loadAffiliatePartnerSettings'
        );
    add_submenu_page(
        null,
        'Produkte von Affilinet importieren',
        'Produkte von Affilinet importieren',
        'manage_options',
        'products-from-affilinet-search',
        'loadAffiliatePartnerSearchProducts'
        );
    add_submenu_page(
        null,
        'Preise von Affilinet importieren',
        'Preise von Affilinet importieren',
        'manage_options',
        'prices-from-affilinet-search',
        'loadAffiliatePartnerPrices');
    
     // tradedoubler
     add_submenu_page(
         null,
         'Tradedoubler-Schnittstelle',
         'Tradedoubler-Schnittstelle',
         'manage_options',
         'tradedoubler-api-settings',
         'loadAffiliatePartnerSettings'
     );
     add_submenu_page(
         null,
         'Produkte von Tradedoubler importieren',
         'Produkte von Tradedoubler importieren',
         'manage_options',
         'products-from-tradedoubler-search',
         'loadAffiliatePartnerSearchProducts'
     );
     add_submenu_page(
         null,
         'Preise von Tradedoubler importieren',
         'Preise von Tradedoubler importieren',
         'manage_options',
         'prices-from-tradedoubler-search',
         'loadAffiliatePartnerPrices'
     );
     
     // eBay
     add_submenu_page(
         null,
         'eBay-Schnittstelle',
         'eBay-Schnittstelle',
         'manage_options',
         'eBay-api-settings',
         'loadAffiliatePartnerSettings'
         );
     add_submenu_page(
         null,
         'Produkte von eBay importieren',
         'Produkte von eBay importieren',
         'manage_options',
         'products-from-eBay-search',
         'loadAffiliatePartnerSearchProducts'
         );
     add_submenu_page(
         null,
         'Preise von eBay importieren',
         'Preise von eBay importieren',
         'manage_options',
         'prices-from-eBay-search',
         'loadAffiliatePartnerPrices'
         );
}

add_action('admin_menu', 'affiliseo_menu_page');

function loadAffiliatePartnersOverview() {
    ob_start();
    include_once(AFFILISEO_LIBRARY  . '/affiliatePartners/partners.php');
    echo ob_get_clean();
}

function loadAffiliatePartnerSettings() {
    $affiliatePartner = getAffiliatePartner();
    $options_function = $affiliatePartner."_api_options_page";
    
    ob_start();
    include_once(AFFILISEO_LIBRARY  . '/affiliatePartners/'.$affiliatePartner.'/settings.php');
    $options_function();
    echo ob_get_clean();
}

function loadAffiliatePartnerPrices() {
    $affiliatePartner = getAffiliatePartner();
    ob_start();
    include_once(AFFILISEO_LIBRARY  . '/affiliatePartners/'.$affiliatePartner.'/loadPricesContent.php');
    echo ob_get_clean();
}

function loadAffiliatePartnerSearchProducts() {
    
    $affiliatePartner = getAffiliatePartner();
    $searchFunction = "send_to_".$affiliatePartner;
    
    $keyword = '';

    if (isset($_POST['keyword']) && trim($_POST['keyword']) !== '') {
        $keyword = $_POST['keyword'];
        $searchFunction($keyword);
    }
    
    include_once(AFFILISEO_LIBRARY  . '/affiliatePartners/'.$affiliatePartner.'/searchProductsContent.php');
}

function send_to_amazon($keyword) {
    $public_key = get_option('amazon_public_key');
    $private_key = get_option('amazon_secret_key');
    $associate_tag = get_option('amazon_partner_id');
    $country = 'de';

    $time = gmdate("Y-m-d\TH:i:s\Z");

    $uri = 'Operation=ItemSearch&Version=2011-08-01&Keywords=' . urlencode($keyword) . '&SearchIndex=All&ItemPage=5';
    $uri .= "&ResponseGroup=Large";
    $uri .= "&MerchantId=All";
    $uri .= "&AWSAccessKeyId=$public_key";
    $uri .= "&AssociateTag=$associate_tag";
    $uri .= "&Timestamp=$time";
    $uri .= "&Service=AWSECommerceService";
    $uri = str_replace(',', '%2C', $uri);
    $uri = str_replace(':', '%3A', $uri);
    $uri = str_replace('*', '%2A', $uri);
    $uri = str_replace('~', '%7E', $uri);
    $uri = str_replace('+', '%20', $uri);
    $sign = explode('&', $uri);
    sort($sign);
    $host = implode("&", $sign);
    $host = "GET\nwebservices.amazon." . $country . "\n/onca/xml\n" . $host;
    $signed = urlencode(base64_encode(hash_hmac("sha256", $host, $private_key, True)));
    $uri .= "&Signature=$signed";
    $uri = "http://webservices.amazon." . $country . "/onca/xml?" . $uri;

    $ch = curl_init($uri);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $xml = curl_exec($ch);
    curl_close($ch);

    $amazonProductsXml = simplexml_load_string($xml);

    if (isset($amazonProductsXml->Error)) {
        $result = '<strong>' . $amazonProductsXml->Error->Code . ':</strong> ' . $amazonProductsXml->Error->Message;
        echo $result;
        die();
    }
}

function getAffiliatePartner(){
    $requestPage = (isset($_REQUEST['page']) && $_REQUEST['page'] !="") ? $_REQUEST['page']:'';
    
    switch ($requestPage){
        case 'products-from-amazon-search':
        case 'amazon-api-settings':
        case 'prices-from-amazon-search':    
            $affiliatePartner = 'amazon';
            break;
            
        case 'products-from-zanox-search':
        case 'zanox-api-settings':
        case 'prices-from-zanox-search':
            $affiliatePartner = 'zanox';
            break;
            
        case 'products-from-belboon-search':
        case 'belboon-api-settings':
        case 'prices-from-belboon-search':
            $affiliatePartner = 'belboon';
            break;
            
        case 'products-from-affilinet-search':
        case 'affilinet-api-settings':
        case 'prices-from-affilinet-search':
            $affiliatePartner = 'affilinet';
            break;
            
        case 'products-from-tradedoubler-search':
        case 'tradedoubler-api-settings':
        case 'prices-from-tradedoubler-search':
            $affiliatePartner = 'tradedoubler';
            break;
            
        case 'products-from-eBay-search':
        case 'eBay-api-settings':
        case 'prices-from-eBay-search':
            $affiliatePartner = 'eBay';
            break;
            
        default:
            $affiliatePartner = 'amazon';    
        
    }
    
    return $affiliatePartner;
}