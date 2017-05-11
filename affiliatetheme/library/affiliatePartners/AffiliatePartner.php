<?php
require_once 'AffiliateProduct.php';

class AffiliatePartner
{

    private $wpdb;

    function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    public function checkAffiliateService($wsdl)
    {
        try {
            $client = new SoapClient($wsdl, array(
                'trace' => true,
                'exceptions' => true
            ));
            
            $client->__getFunctions();
            
            $out = '<i class="fa fa-check fa-2x green"></i>';
        } catch (SoapFault $fault) {
            $out = "SOAP-Fehler: (Fehlernummer: {$fault->faultcode}, " . "Fehlermeldung: {$fault->faultstring})";
        }
        
        return $out;
    }

    public function getProduct($product, $partner)
    {
        return new AffiliateProduct($product, $partner);
    }

    public function getAdspaces($api, $partner = 'zanox')
    {
        $adspaces = array();
        
        if ($partner == 'zanox') {
            $xml = $api->getAdspaces(null, 50);
            $result = simplexml_load_string($xml);
            
            if ($adspaceItems = $result->adspaceItems) {
                
                foreach ($adspaceItems->adspaceItem as $key => $value) {
                    $adspaceId = $value->attributes()->id;
                    $adspaces[] = array(
                        'adspaceId' => $adspaceId->__toString(),
                        'adspaceName' => $value->name->__toString()
                    );
                }
            }
        }
        
        if ($partner == 'belboon') {
            $response = $api->getPlatforms();
            if ($adspaceItems = $response->Records) {
                foreach ($adspaceItems as $key => $value) {
                    $adspaces[] = array(
                        'adspaceId' => $value['id'],
                        'adspaceName' => $value['name']
                    );
                }
            }
        }
        
        if ($partner == 'affilinet') {
            $params = array(
                'CurrentPage' => 1,
                'PageSize' => 10
            );
            return $response = $api->getShopList($params);
        }
        
        return $adspaces;
    }

    public function getProductManufacturers($args = array())
    {
        return get_terms('produkt_marken', $args);
    }

    public function getProductTypes($args = array())
    {
        return get_terms('produkt_typen', $args);
    }

    public function formatPrice($price)
    {
        return number_format($price, 2, ',', '');
    }

    public function navBar($allPages, $currentPage, $params, $navBar = 15)
    {
        $navCeil = floor($navBar / 2);
        
        $out = '<div class="tablenav top"><div class="tablenav-pages" align="right"><span class="pagination-links">';
        $out .= 'Seite: ' . $currentPage . ' / ' . $allPages . '&nbsp;&nbsp;&nbsp;&nbsp;';
        
        if ($currentPage > 1) {
            $out .= '<a class="nav-button tablenav-pages-navspan" id="page_1' . $params . '">&laquo;</a>&nbsp;&nbsp;';
            $out .= '<a class="nav-button prev-page" id="page_' . ($currentPage - 1) . $params . '">&lsaquo;</a>&nbsp;&nbsp;';
        }
        
        for ($x = $currentPage - $navCeil; $x <= $currentPage + $navCeil; $x ++) {
            
            if (($x > 0 && $x < $currentPage) || ($x > $currentPage && $x <= $allPages))
                $out .= '<span class="nav-button current-page" id="page_' . $x . $params . '">' . $x . '</span>&nbsp;&nbsp;';
            
            if ($x == $currentPage)
                $out .= $x . '&nbsp;&nbsp;';
        }
        
        if ($currentPage < $allPages) {
            $out .= '<a class="nav-button next-page" id="page_' . ($currentPage + 1) . $params . '">&rsaquo;</a>&nbsp;&nbsp;';
            $out .= '<a class="nav-button tablenav-pages-navspan" id="page_' . $allPages . $params . '">&raquo;</a>&nbsp;&nbsp;';
        }
        
        $out .= '</span></div></div>';
        
        return $out;
    }

    public function handlePriceUpdateOutput($priceCurrent, $priceNew, $id, $productId, $noPriceType, $trackingLinks)
    {
        if (isset($trackingLinks->affiliateLink) && $trackingLinks->affiliateLink != "") {
            update_post_meta($id, 'ap_pdp_link', $trackingLinks->affiliateLink);
        }
        
        if (isset($trackingLinks->affiliateLinkCart) && $trackingLinks->affiliateLinkCart != "") {
            update_post_meta($id, 'ap_cart_link', $trackingLinks->affiliateLinkCart);
        }
        
        if ($priceCurrent != $priceNew) {
            $class = 'success';
            update_post_meta($id, 'preis', $priceNew);
        } else {
            $class = 'warning';
            update_post_meta($id, 'preis', $priceNew);
        }
        
        if ($priceNew === '0,00') {
            
            $class = 'error';
            $priceNew = 'Es ist kein Preis verfügbar.';
            $to = get_bloginfo('admin_email');
            $subject = get_bloginfo('name') . ' Warnung: Kein Preis verfügbar.';
            $headers = 'From: affiliseo <' . get_bloginfo('admin_email') . '>' . "\r\n";
            
            $link = admin_url . '/post.php?post=' . $id . '&action=edit';
            $message = 'Für das Produkt ' . get_the_title($id) . ' ist kein Preis verfügbar. Um dieses Problem zu lösen, können ' . 'Sie im <a href="' . $link . '">Produkt</a> den Preistyp ändern, ' . 'das Produkt erneut veröffentlichen und den Preis manuell aktualisieren. ' . 'Wenn trotz dieser Maßnahmen das Problem weiterhin besteht, ' . 'wenden Sie sich bitte an den Support des Affiliatepartners.';
            
            $backendLink = ' <a href="' . admin_url() . '/post.php?post=' . $id . '&action=edit">Produkt</a> ';
            
            global $no_price_string;
            
            $newpostdata = array();
            
            switch ($noPriceType) {
                
                case 'send_mail':
                    wp_mail($to, $subject, $message, $headers);
                    $priceNew .= ' Eine E-Mail wurde an Sie versendet!';
                    break;
                
                case 'deactivate':
                    $newpostdata['post_status'] = '';
                    $newpostdata['ID'] = $id;
                    wp_update_post($newpostdata);
                    $priceNew .= ' Das' . $backendLink . 'wurde deaktiviert!';
                    break;
                
                case 'send_mail_and_change':
                    wp_mail($to, $subject, $message, $headers);
                    $priceNew = $no_price_string;
                    update_post_meta($id, 'preis', $priceNew);
                    break;
                
                case 'change':
                    $priceNew = $no_price_string;
                    update_post_meta($id, 'preis', $priceNew);
                    break;
                
                default:
                    wp_mail($to, $subject, $message, $headers);
                    $newpostdata['post_status'] = '';
                    $newpostdata['ID'] = $id;
                    wp_update_post($newpostdata);
                    $priceNew .= ' Das' . $backendLink . 'wurde deaktiviert und eine E-Mail an Sie versendet!';
            }
        }
        
        $output = '
		<tr class="' . $class . '">
			<td>' . get_the_title($id) . '</td>
			<td>' . $productId . '</td>
			<td class="preis_alt">' . $priceCurrent . '</td>
			<td class="preis_neu">' . $priceNew . '</td>
		</tr>';
        
        return $output;
    }

    public function updateProductModified($id)
    {
        global $wpdb;
        
        $wpdb->query($wpdb->prepare("
            UPDATE $wpdb->posts
            SET post_modified = %s,
            post_modified_gmt = %s
            WHERE ID = %s
            ", current_time('mysql'), current_time('mysql', 1), (int) $id));
    }

    public function writeImportAllRow()
    {
        $out = <<<HTML
        <div>
            <input type="checkbox" id="cb_all_products" name="cb_all_products" value="0" />
            
            <span
                id="select_all_products"
                style="cursor: pointer;">
                <small>alle ausw&auml;hlen</small>
            </span>
            <input 
                type="submit" 
                style="margin-left:10px; width:260px;" 
                value="Produkte importieren (ver&ouml;ffentlichen)" 
                id="add-products-published" 
                class="button-primary">
            
            <input 
                type="submit" 
                style="margin-left:30px; width:260px;" 
                value="Produkte importieren (als Entwurf)" 
                id="add-products-draft" 
                class="button-primary">
            </div>
HTML;
        
        return $out;
    }

    public function writeHanldePaginationKlick()
    {
        $out = <<<SCRIPT
        <script type="text/javascript">
            jQuery(".nav-button").click(function ($) {
                var keyword = jQuery("#keyword").val();
                var page = jQuery(this).attr("id").substring(5);
                var products_per_page = jQuery("#products_per_page").val();
                var ap_adspace_id = jQuery("#ap_adspace_id").val();
                var ap_program_id = jQuery("#ap_program_id").val();
                var amazon_search_index = jQuery("#amazon_search_index").val();
                
                var requestData = {
                    "keyword":keyword, 
                    "page":page, 
                    "products_per_page":products_per_page,
                    "ap_adspace_id":ap_adspace_id,
                    "ap_program_id":ap_program_id,
                    "amazon_search_index":amazon_search_index
                };
            
                loadResults(requestUrl, requestData);
            });
            
            jQuery("#select_all_products").click(function() {
                jQuery("#cb_all_products").click();
            });
            
            jQuery("#cb_all_products").click(function() {
                var checked_status = this.checked;
                jQuery('input[name *= ap_product_ids]').each(function() {
                    this.checked = checked_status;
                });
            });
            
        </script>
SCRIPT;
        return $out;
    }

    public function writeAllreadyImportedRow()
    {
        $out = <<<HTML
        <tr>
            <td>
                <p 
                style="color: #31708F;background-color: #D9EDF7;border-color: #BCE8F1;padding: 15px;margin-bottom: 20px;border: 1px solid rgba(0, 0, 0, 0);border-radius: 4px;"
                class="alert alert-info">
                    Das Produkt wurde bereits importiert.
                </p>
            </td>
        </tr>
        <tr><td></td></tr>
HTML;
        
        return $out;
    }

    public function writeImportButtons($apPID)
    {
        $out = <<<HTML
        <tr>
            <td class="products-row-right" style="text-align:center;">
            
                <span style="width:245px;" class="button-primary detail-import" id="{$apPID}">Produkt importieren</span>
            </td>
        </tr>
HTML;
        return $out;
    }

    public function writeProductRow($params)
    {
        $imageListArray = $params['imageListArray'];
        $imageUrl = $params['imageUrl'];
        $apPID = $params['apPID'];
        $product = $params['product'];
        $existingProducts = $params['existingProducts'];
        $affiliateLink = $params['affiliateLink'];
        $affiliateLinkCart = $params['affiliateLinkCart'];
        $productManufacturers = $params['productManufacturers'];
        $productTypes = $params['productTypes'];
        
        $prices = $product->getProductPrices();
        
        $starRating = $product->getStarRating();
        
        $imageList = implode('|', $imageListArray);
        
        $productImage = '';
        if ($imageUrl) {
            $productImage = "<img id='img-" . $apPID . "' src='" . $imageUrl . "' width='110' />";
        }
        
        $productManufacturer = $product->getManufacturer();
        
        $affiliatePartnerSettings = $this->getAffiliatePartnerSettings($params['affiliatePartner']);
        
        if (isset($affiliatePartnerSettings['importProductDescription']) && $affiliatePartnerSettings['importProductDescription'] == 1) {
            $productDescription = (strlen($product->getDescription()) > 0) ? $product->getDescription() : $product->getDescriptionLong();
        } else {
            $productDescription = '';
        }
        
        $priceTypePrefix = 'list';
        $priceChoosePrefix = 'list';
        if ($params['affiliatePartner'] == 'amazon') {
            $priceTypePrefix = 'lowest_new';
            $priceChoosePrefix = 'lowest_new';
        }
        
        $out = '<tr id="tr_' . $apPID . '">
            <td rowspan="3" class="products-import-cell">';
        
        if (! in_array($apPID, $existingProducts)) {
            $out .= '<input type="checkbox" name="ap_product_ids[]" id="ap_product_' . $apPID . '" value="' . $apPID . '" />';
        }
        $out .= '</td>
            <td rowspan="3" class="products-image-cell">' . $productImage . '
        
                <div style="overflow: hidden; display: none;" id="spinner-container-' . $apPID . '" class="spinner-container">
                    <div class="spinner" style="float: left; display: block;"></div>
                    Das Produkt wird gespeichert.
                </div>
            </td>
            <td class="products-row-right products-name-cell" rowspan="3">
        
                <input type="text" value="' . $product->getName() . '" style="width: 100%;" id="title-' . $apPID . '" /><br />
                '.__('Price','affiliatetheme').': <span id="' . $priceTypePrefix . '_price-' . $apPID . '">' . $this->formatPrice($prices->price) . '</span> ' . $product->getCurrency() . '<br />
                Preis-UVP: <span id="uvp-' . $apPID . '">' . $this->formatPrice($prices->uvp) . '</span> ' . $product->getCurrency() . '<br />
                ean: <span style="width:200px; word-wrap:break-word; display:inline-block;" id="ean-' . $apPID . '">' . $product->getEan() . '</span><br />';
        
        if ($product->getProductShopName() != "") {
            $out .= 'Shop: <span id="shop-' . $apPID . '">' . $product->getProductShopName() . '</span><br />';
        }
        
        $out .= '<small>letzte Änderung: ' . $product->getModified() . '</small>
        
                <div style="display: none;" id="hidden-fields">
                    <input type="checkbox" checked="checked" id="importTitle-' . $apPID . '" />
                    <input type="checkbox" checked="checked" id="importDesc-' . $apPID . '" />
                    <input type="checkbox" checked="checked" id="importPrice-' . $apPID . '" />
                    <input type="checkbox" checked="checked" id="importImg-' . $apPID . '" />
                    <input type="checkbox" checked="checked" id="importAffiliate-' . $apPID . '" />
                    <input type="checkbox" checked="checked" id="importAffiliateCart-' . $apPID . '" />
                    <input type="checkbox" checked="checked" id="importType-' . $apPID . '" />
        
                    <input type="radio" checked="checked" name="choose_price_type-' . $apPID . '" value="' . $priceChoosePrefix . '-' . $apPID . '" id="' . $priceChoosePrefix . '-' . $apPID . '" />
        
                    <a id="affiliate-' . $apPID . '" href="' . $affiliateLink . '" target="_blank">' . $affiliateLink . '</a></small>
                    <a id="affiliateCart-' . $apPID . '" href="' . $affiliateLinkCart . '" target="_blank">' . $affiliateLinkCart . '</a>
        
                    <span id="images-' . $apPID . '" >' . $imageList . '</span>
                    <span id="star-rating-' . $apPID . '" >' . $starRating . '</span>
                </div>
        
            </td>
        
            <td rowspan="3" class="products-row-right products-description-cell">
                <div id="desc-' . $apPID . '" style="height:180px; overflow:auto;">' . $productDescription . '</div>
                <div id="submit-container-' . $apPID . '" class="alert alert-info hidden"
				style="color: #31708F; background-color: #D9EDF7; border-color: #BCE8F1; padding: 15px; margin-bottom: 20px; border: 1px solid rgba(0, 0, 0, 0); border-radius: 4px;">
                    Produkt wurde erfolgreich gespeichert! <br />
                    Wurde die Produktbeschreibung nicht importiert, enthält sie wahrscheinlich ein
                    unbekanntes Script und wurde aus Sicherheitsgründen entfernt.
                    Die Formatierung wurde ebenfalls aus Sicherheitsgründen entfernt.<br />
                    Die Beschreibung kann nächträglich im Produkt eingefügt werden.
                </div>
            </td>
        
            <td  class="products-row-right products-button-cell" style="padding-right:5px;">
        
                <strong>'.strtoupper(__('Brand','affiliatetheme')).'</strong>:<br /> <select id="marken-' . $apPID . '" name="marken" style="width:200px;">';
        
        if (trim($productManufacturer) !== '') {
            $out .= '<option value="' . $productManufacturer . '">' . $productManufacturer . '</option>';
        }
        foreach ($productManufacturers as $key => $manufacturer) {
            $out .= '<option value="' . $manufacturer->slug . '">' . $manufacturer->name . '</option>';
        }
        $out .= '</select>
             </td>
        </tr>
        
        <tr>
            <td class=" products-row-right" style="padding-right:5px;">
            <strong>TYP</strong>:<br /> <select id="type-' . $apPID . '" name="type" style="width:200px;">';
        
        foreach ($productTypes as $key => $productType) {
            $out .= '<option value="' . $productType->slug . '">' . $productType->name . '</option>';
        }
        $out .= '</select>
            </td>
        </tr>';
        
        return $out;
    }

    public function writeHiddenProductsRow($count)
    {
        $productText = ($count > 1) ? 'Produkte wurden' : 'Produkt wurde';
        $out = <<<HTML
        <div style="color:red; font-weight:bold; margin:7px;"> {$count} {$productText} ausgeblendet, da sie sich nur in EAN-Nummern unterscheiden
        </div>
HTML;
        
        return $out;
    }

    public function findImportedProducts($affiliatePartner)
    {
        $existingProducts = array();
        
        $products = get_posts(array(
            'post_type' => 'produkt',
            'post_status' => 'publish',
            'posts_per_page' => - 1
        ));
        
        foreach ($products as $product) {
            if (trim(get_field($affiliatePartner, $product->ID))) {
                $existingProducts[] = trim(get_field($affiliatePartner, $product->ID));
            }
        }
        
        return $existingProducts;
    }

    public function writePartnerBlock($index, $partnerData)
    {
        $partner = $partnerData['partner'];
        $partnerLabel = $partnerData['partnerLabel'];
        $partnerLink = $partnerData['partnerLink'];
        
        $out = <<<HTML
		
		<div class="theme" tabindex="{$index}">
			<div class="theme-screenshot">
				<img src="../wp-content/themes/affiliatetheme/images/{$partner}.png" alt="" />
			</div>
			<h3 class="theme-name">$partnerLabel</h3>
			<div class="ap-actions">
				<div class="theme-actions">
					<a href="../wp-admin/admin.php?page={$partner}-api-settings" class="button">Einstellungen bearbeiten</a>
				</div>
				<div class="theme-actions">
					<a href="../wp-admin/admin.php?page=products-from-{$partner}-search" class="button">Produkte importieren</a>
				</div>
				<div class="theme-actions">
					<a href="../wp-admin/admin.php?page=prices-from-{$partner}-search" class="button">Preise importieren</a>
				</div>
				<div class="theme-actions">
					<a href="{$partnerLink}" target="_blank" class="button">Anmeldung bei $partnerLabel*</a>
				</div>
			</div>
		</div>
HTML;
        return $out;
    }

    public function getAffiliatePartnerSettings($partner)
    {
        $partnerSettings = array();
        
        switch ($partner) {
            case 'zanox':
                $partnerSettings = array(
                    'productIdKey' => 'zanox_product_id',
                    'apPdpButton' => get_option('zanox_pdp_button'),
                    'importProductDescription' => get_option('zanox_import_product_description'),
                    'zanoxSearchRegion' => get_option('zanox_search_region'),
                    'zanoxConnectId' => get_option('zanox_connect_id'),
                    'zanoxSecretKey' => get_option('zanox_secret_key'),
                    'imageImportType' => get_option('zanox_image_import_type', 'download')
                );
                break;
            case 'amazon':
                $partnerSettings = array(
                    'productIdKey' => 'amazon_produkt_id',
                    'apPdpButton' => get_option('amazon_pdp_button'),
                    'importProductDescription' => get_option('amazon_import_product_description'),
                    'amazonPartnerId' => get_option('amazon_partner_id'),
                    'amazonPublicKey' => get_option('amazon_public_key'),
                    'amazonSecretKey' => get_option('amazon_secret_key'),
                    'apCurrency' => get_option('ap_currency'),
                    'imageImportType' => get_option('amazon_image_import_type', 'download')
                );
                break;
            case 'belboon':
                $partnerSettings = array(
                    'productIdKey' => 'belboon_product_id',
                    'apPdpButton' => get_option('belboon_pdp_button'),
                    'importProductDescription' => get_option('belboon_import_product_description'),
                    'belboonUsername' => get_option('belboon_username'),
                    'belboonWsdl' => get_option('belboon_wsdl'),
                    'belboonPassword' => get_option('belboon_password'),
                    'imageImportType' => get_option('belboon_image_import_type', 'download')
                );
                break;
            case 'affilinet':
                $partnerSettings = array(
                    'productIdKey' => 'affilinet_product_id',
                    'apPdpButton' => get_option('affilinet_pdp_button'),
                    'importProductDescription' => get_option('affilinet_import_product_description'),
                    'affilinetPublisherId' => get_option('affilinet_publisher_id'),
                    'affilinetPublisherPassword' => get_option('affilinet_publisher_password'),
                    'affilinetProductPassword' => get_option('affilinet_product_password'),
                    'affilinetLogonWsdl' => get_option('affilinet_logon_wsdl'),
                    'affilinetProductsWsdl' => get_option('affilinet_products_wsdl'),
                    'imageImportType' => get_option('affilinet_image_import_type', 'download')
                );
                break;
            case 'tradedoubler':
                $partnerSettings = array(
                    'productIdKey' => 'tradedoubler_product_id',
                    'apPdpButton' => get_option('tradedoubler_pdp_button'),
                    'importProductDescription' => get_option('tradedoubler_import_product_description'),
                    'tradedoublerToken' => get_option('tradedoubler_token'),
                    'tradedoublerApiUrl' => get_option('tradedoubler_api_url'),
                    'imageImportType' => get_option('tradedoubler_image_import_type', 'download')
                );
                break;
            case 'eBay':
                $partnerSettings = array(
                    'productIdKey' => 'eBay_product_id',
                    'apPdpButton' => get_option('eBay_pdp_button'),
                    'importProductDescription' => get_option('eBay_import_product_description'),
                    'eBayServiceEndpoint' => get_option('eBay_service_endpoint'),
                    'eBayApiVersion' => get_option('eBay_api_version'),
                    'eBayGlobalId' => get_option('eBay_global_id'),
                    'eBayCampaignId' => get_option('eBay_campaign_id'),
                    'eBayCustomId' => get_option('eBay_custom_id'),
                    'eBayAppId' => get_option('eBay_app_id'),
                    'imageImportType' => get_option('eBay_image_import_type', 'download')
                );
                break;
        }
        return $partnerSettings;
    }

    public function getApSingleProduct($productId, $partner)
    {
        $ap = $this->getAffiliatePartnerSettings($partner);
        $product = null;
        
        switch ($partner) {
            case 'affilinet':
                require_once 'affilinet/Affilinet.php';
                $apApi = new Affilinet($ap['affilinetPublisherId'], $ap['affilinetPublisherPassword'], $ap['affilinetProductPassword'], $ap['affilinetLogonWsdl'], $ap['affilinetProductsWsdl']);
                $params = array(
                    'ProductIds' => array(
                        $productId
                    )
                );
                $response = $apApi->getProductsByIds($params);
                if (is_object($response) && isset($response->Products) && count($response->Products) > 0) {
                    $product = $this->getProduct($response->Products->Product, 'affilinet');
                }
                break;
            case 'amazon':
                require_once 'amazon/Amazon.php';
                $apApi = new Amazon($ap['amazonPublicKey'], $ap['amazonPartnerId'], $ap['amazonSecretKey']);
                
                $request = $apApi->getProductById($ap['apCurrency'], array(
                    'Operation' => 'ItemLookup',
                    'ItemId' => $productId,
                    'ResponseGroup' => 'Large'
                ));
                
                $response = @file_get_contents($request);
                $amazonProductsXml = simplexml_load_string($response);
                if (count($amazonProductsXml->Items->Item) > 0) {
                    
                    $iframeUrl = $amazonProductsXml->Items->Item->CustomerReviews->IFrameURL->__toString();
                    $amazonImportStarRating = get_option( 'amazon_import_star_rating' );
                    $starRating = '';
                    if(intval($amazonImportStarRating)==1){
                        $starRating = $apApi->getStarRatingFromIframeUrl($iframeUrl);
                    }
                    
                    $product = $this->getProduct($amazonProductsXml->Items->Item[0], 'amazon');
                    
                    $product->setStarRating($starRating);
                    
                    $product->setCustomerReviews($amazonProductsXml->Items->Item->CustomerReviews);
                }
                
                break;
            case 'belboon':
                require_once 'belboon/Belboon.php';
                $apApi = new Belboon($ap['belboonUsername'], $ap['belboonPassword'], $ap['belboonWsdl']);
                $response = $apApi->getProductById($productId);
                
                if (isset($response->Records) && count($response->Records) > 0) {
                    
                    $productItem = $response->Records[0];
                    $product = $this->getProduct($productItem, 'belboon');
                    
                    $feeds = array();
                    $getFeeds = $apApi->getFeeds();
                    if ($feedItems = $getFeeds->Records) {
                        if (is_array($feedItems)) {
                            foreach ($feedItems as $key => $feedItem) {
                                $feeds[$feedItem['id']] = $feedItem['program_name'];
                            }
                        }
                    }
                    
                    $shopName = '';
                    $programId = $product->getProgram();
                    if (isset($feeds[$programId]) && $feeds[$programId] != "") {
                        $shopName = $feeds[$programId];
                    }
                    $product->setProductShopName($shopName);
                }
                break;
            case 'eBay':
                require_once 'eBay/Ebay.php';
                $publisherData = array(
                    'eBayAppId' => $ap['eBayAppId'],
                    'eBayServiceEndpoint' => $ap['eBayServiceEndpoint'],
                    'eBayGlobalId' => $ap['eBayGlobalId'],
                    'eBayApiVersion' => $ap['eBayApiVersion'],
                    'affiliateTrackingId' => $ap['eBayCampaignId'],
                    'affiliateNetworkId' => 9,
                    'affiliateCustomId' => $ap['eBayCustomId']
                );
                $apApi = new Ebay($publisherData);
                
                $response = $apApi->getProductById($productId);
                
                if (is_object($response->Item)) {
                    $product = $this->getProduct($response->Item, 'eBaySingleItem');
                }
                break;
            case 'tradedoubler':
                require_once 'tradedoubler/Tradedoubler.php';
                $apApi = new Tradedoubler($ap['tradedoublerToken'], $ap['tradedoublerApiUrl']);
                
                $response = $apApi->getProductById($productId);
                
                if (isset($response->productHeader->totalHits) && count($response->productHeader->totalHits) > 0) {
                    
                    $productItem = $response->products->product[0];
                    
                    $product = $this->getProduct($productItem, 'tradedoubler');
                }
                break;
            case 'zanox':
                require_once 'zanox/Zanox.php';
                $apApi = new Zanox($ap['zanoxSecretKey'], $ap['zanoxConnectId'], $ap['zanoxSearchRegion']);
                
                $request = $apApi->getProductById($productId);
                $products = json_decode($request);
                if (is_array($products->productItem)) {
                    $product = $this->getProduct($products->productItem[0], 'zanox');
                }
                
                break;
        }
        
        return $product;
    }

    function getImageFileNameFromUrl($url)
    {
        $urlParsed = parse_url($url);
        $path = $urlParsed['path'];
        $pathElements = explode('/', $path);
        return array_pop($pathElements);
    }

    function writeImageImportBox($imgSrc, $title, $i, $imgFileNameReadOnly)
    {
        $html = '<div class="div_boxes div48">';
        $html .= '<div style="width:125px; float:left; margin-right:5px; max-height:120px; overflow: auto;">';
        $html .= '<img id="di_image' . $i . '_src" src="' . $imgSrc . '" width="110"  />';
        $html .= '</div>';
        $html .= '<div style="float:left;">Bildname<br/>';
        $html .= '<input ' . $imgFileNameReadOnly . ' type="text" id="di_image' . $i . '_name" name="di_image' . $i . '_name" style="width:236px;" value="' . $this->getImageFileNameFromUrl($imgSrc) . '" /><br/>';
        $html .= 'Alt-Tag<br/>';
        $html .= '<input type="text" id="di_image' . $i . '_alt" name="di_image' . $i . '_alt" style="width:236px;" value="' . $title . '" /><br/>';
        $html .= '<input type="checkbox" id="di_image' . $i . '" name="di_image' . $i . '" class="di_image_import" checked="checked" /> Bild importieren';
        $html .= '</div></div>';
        
        return $html;
    }

    function writeProductImageBoxes($images, $title, $imgFileNameReadOnly)
    {
        $imageUrls = array(
            $images->firstImage
        );
        
        if (isset($images->otherImages) && strlen($images->otherImages) > 10) {
            $otherImages = explode('|', $images->otherImages);
            foreach ($otherImages as $otherImage) {
                array_push($imageUrls, $otherImage);
            }
        }
        
        $k = 0;
        $i = 1;
        $html = '';
        foreach ($imageUrls as $imageUrl) {
            if ($imageUrl != "") {
                $title_ = $title . ' - ' . $i;
                $html .= $this->writeImageImportBox($imageUrl, $title_, $i, $imgFileNameReadOnly);
                
                if ($k % 2) {
                    $html .= '<div class="clearfix"></div>';
                }
                $k ++;
                $i ++;
            }
        }
        
        return $html;
    }

    function tidyTxt($val)
    {
        $new = html_entity_decode("$val");
        $new = preg_replace('=(\s+)=', '_', $new);
        $func = 'html_entity_decode';
        
        $map = array(
            '' . $func('&auml;') . '' => 'ae',
            '' . $func('&Auml;') . '' => 'AE',
            '' . $func('&szlig;') . '' => 'ss',
            '' . $func('&yuml;') . '' => 'y',
            '' . $func('&ouml;') . '' => 'oe',
            '' . $func('&Ouml;') . '' => 'OE',
            '' . $func('&uuml;') . '' => 'ue',
            '' . $func('&Uuml;') . '' => 'UE',
            '' . $func('&Agrave;') . '' => 'AE',
            '' . $func('&egrave;') . '' => 'e',
            '' . $func('&Aacute;') . '' => 'A',
            '' . $func('&aacute;') . '' => 'a',
            '' . $func('&Acirc;') . '' => 'A',
            '' . $func('&acirc;') . '' => 'a',
            '' . $func('&Atilde;') . '' => 'A',
            '' . $func('&atilde;') . '' => 'a',
            '' . $func('&Aring;') . '' => 'A',
            '' . $func('&aring;') . '' => 'a',
            '' . $func('&AElig;') . '' => 'AE',
            '' . $func('&aelig;') . '' => 'ae',
            '' . $func('&Ccedil;') . '' => 'C',
            '' . $func('&ccedil;') . '' => 'c',
            '' . $func('&Egrave;') . '' => 'E',
            '' . $func('&egrave;') . '' => 'e',
            '' . $func('&Eacute;') . '' => 'E',
            '' . $func('&eacute;') . '' => 'e',
            '' . $func('&Ecirc;') . '' => 'E',
            '' . $func('&ecirc;') . '' => 'e',
            '' . $func('&Euml;') . '' => 'E',
            '' . $func('&euml;') . '' => 'e',
            '' . $func('&Igrave;') . '' => 'I',
            '' . $func('&igrave;') . '' => 'i',
            '' . $func('&Iacute;') . '' => 'I',
            '' . $func('&iacute;') . '' => 'i',
            '' . $func('&Icirc;') . '' => 'I',
            '' . $func('&icirc;') . '' => 'i',
            '' . $func('&Iuml;') . '' => 'I',
            '' . $func('&iuml;') . '' => 'i',
            '' . $func('&ETH;') . '' => 'ETH',
            '' . $func('&eth;') . '' => 'eth',
            '' . $func('&Ntilde;') . '' => 'N',
            '' . $func('&ntilde;') . '' => 'n',
            '' . $func('&Ograve;') . '' => 'O',
            '' . $func('&ograve;') . '' => 'o',
            '' . $func('&Oacute;') . '' => 'O',
            '' . $func('&oacute;') . '' => 'o',
            '' . $func('&Ocirc;') . '' => 'O',
            '' . $func('&ocirc;') . '' => 'o',
            '' . $func('&Otilde;') . '' => 'O',
            '' . $func('&otilde;') . '' => 'o',
            '' . $func('&Oslash;') . '' => 'O',
            '' . $func('&oslash;') . '' => 'o',
            '' . $func('&THORN;') . '' => 'TH',
            '' . $func('&thorn;') . '' => 'th',
            '' . $func('&Ugrave;') . '' => 'U',
            '' . $func('&ugrave;') . '' => 'u',
            '' . $func('&Uacute;') . '' => 'U',
            '' . $func('&uacute;') . '' => 'u',
            '' . $func('&Ucirc;') . '' => 'U',
            '' . $func('&ucirc;') . '' => 'u',
            '' . $func('&Yacute;') . '' => 'Y',
            '' . $func('&yacute;') . '' => 'y'
        );
        
        $new = str_replace(array_keys($map), array_values($map), $new);
        $new = strtolower($new);
        $new = preg_replace('#[^a-z0-9_.-]#', '', $new);
        return $new;
    }

    public function createProductGallery($postId)
    {
        $postImages = get_children(array(
            'post_parent' => $postId,
            'post_type' => 'attachment',
            'post_mime_type' => 'image'
        ));
        
        if (is_array($postImages)) {
            
            $firstImageId = get_field('_thumbnail_id', $postId);
            
            $postImageIds = array_keys($postImages);
            
            if ($key = array_search($firstImageId, $postImageIds)) {
                unset($postImageIds[$key]);
            }
            
            array_unshift($postImageIds, $firstImageId);
            $postImageIds = array_unique($postImageIds);
            
            $attachedImages = serialize($postImageIds);
            
            update_post_meta($postId, 'product_gallery', $attachedImages);
            update_post_meta($postId, '_product_gallery', 'field_ang6ca8oosh8ee');
            
            $i = 0;
            foreach ($postImageIds as $postImageId) {
                delete_post_meta($postId, '_thumbnail_id', $postImageId);
                
                wp_update_post(array(
                    'ID' => $postImageId,
                    'post_parent' => $postId,
                    'menu_order' => $i
                ));
                
                $i ++;
            }
            
            add_post_meta($postId, '_thumbnail_id', $firstImageId);
        }
    }

    public function addAttachImg($importType, $img, $postId, $imgTitle)
    {
        $homeUrl = get_home_url();
        
        if ($importType == 'detail') {
            $imgTitle = $img['title'];
            $imageData = $this->fileGetContentsCurl($img['src']);
            $fileName = $img['name'];
            $img = $img['src'];
        } else {
            
            $tmpFileName = '';
            
            if ( preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $img)) {
                
                $imageExtension = $this->gdExtension($img);
                $imageData = $this->fileGetContentsCurl($img);
                $fileName = uniqid(rand(), true) . $imageExtension;
            }
        }
        
        $replacement = media_sideload_image($img, $postId, $imgTitle);
        
        $img = $homeUrl . '/wp-content/themes/affiliatetheme/library/affiliatePartners/tmp/' . $fileName;
        
        $tmpFileName = dirname(__FILE__) . '/tmp/' . $fileName;
        file_put_contents($tmpFileName, $imageData);
        
        $image = preg_replace("/.*(?<=src=[\"'])([^\"']*)(?=[\"']).*/", '$1', $replacement);
        $attachmentId = $this->tsf_get_attachment_id_from_src($image);
        $file = realpath(str_replace(get_bloginfo('url'), '.', $image));
        wp_generate_attachment_metadata($attachmentId, $file);
        add_post_meta($postId, '_thumbnail_id', $attachmentId);
        
        if ($tmpFileName != "") {
            unlink($tmpFileName);
        }
    }

    public function addPostMetaExternalImageCount($postId, $count){
        add_post_meta($postId, 'external_images', $count);
        add_post_meta($postId, '_external_images', 'acfp_iengahm3ohheed');
    }
    
    public function addPostMetaExternalImage($postId, $number, $image){
    
        add_post_meta($postId, 'external_images_'.$number.'_image_title', $image['title']);
        add_post_meta($postId, '_external_images_'.$number.'_image_title', 'acfp_aerieyeiphee2s');
    
        add_post_meta($postId, 'external_images_'.$number.'_image_url', $image['src']);
        add_post_meta($postId, '_external_images_'.$number.'_image_url', 'acfp_jahsiegiach5ch');
    }

    private function tsf_get_attachment_id_from_src($image_src)
    {
        global $wpdb;
        $query = "SELECT ID FROM {$this->wpdb->posts} WHERE guid='$image_src'";
        $id = $wpdb->get_var($query);
        return $id;
    }

    public function gdExtension($full_path_to_image = '')
    {
        $extension = 'null';
        if ($image_type = exif_imagetype($full_path_to_image)) {
            $extension = image_type_to_extension($image_type, false);
        }
        $known_replacements = array(
            'jpeg' => 'jpg',
            'tiff' => 'tif'
        );
        $extension = '.' . str_replace(array_keys($known_replacements), array_values($known_replacements), $extension);
        
        return $extension;
    }

    private function fileGetContentsCurl($url)
    {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}