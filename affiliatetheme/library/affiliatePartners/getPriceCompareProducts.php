<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../wp-load.php');
require_once 'AffiliatePartner.php';

require_once 'affilinet/affilinetMandatoryOptions.php';
require_once 'affilinet/Affilinet.php';
$Affilinet = new Affilinet($affilinetPublisherId, $affilinetPublisherPassword, $affilinetProductPassword, $affilinetLogonWsdl, $affilinetProductsWsdl);

require_once 'zanox/zanoxMandatoryOptions.php';
require_once 'zanox/Zanox.php';
$Zanox = new Zanox($zanoxSecretKey, $zanoxConnectId, $zanoxSearchRegion);

require_once 'amazon/amazonMandatoryOptions.php';
require_once 'amazon/Amazon.php';
$Amazon = new Amazon($amazonPublicKey, $amazonPartnerId, $amazonSecretKey);

$AffiliatePartner = new AffiliatePartner();

$PriceComparison = new PriceComparison();

$productId = trim(filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_STRING));

$priceComparisonArticles = array();
$priceComparisonEntry = $PriceComparison->getPriceComparisonEntryByPostId($productId);
if (isset($priceComparisonEntry->id) && $priceComparisonEntry->id > 0) {
    if (isset($priceComparisonEntry->ap_article_ids) && $priceComparisonEntry->ap_article_ids != "") {
        $priceComparisonArticles = unserialize($priceComparisonEntry->ap_article_ids);
    }
}

$priceComparisonArticleKeys = array();
foreach ($priceComparisonArticles as $priceComparisonArticle) {
    $priceComparisonArticleKeys[] = $priceComparisonArticle['partner'] . '_' . $priceComparisonArticle['article_id'];
}

$post = get_post($productId);

$productEAN = trim(get_post_meta($productId, 'ean', true));
$productEANs = explode(',', $productEAN);
$productTitle = $post->post_title;

$affiliatePartners = trim(filter_input(INPUT_POST, 'affiliatePartners', FILTER_SANITIZE_STRING));

if ($affiliatePartners != "") {
    $affiliatePartners = explode(',', $affiliatePartners);
} else {
    $affiliatePartners = array();
}

$affiliatePartnerProducts = array();

foreach ($priceComparisonArticles as $priceComparisonArticle) {
    $affiliatePartner = $priceComparisonArticle['partner'];
    $affiliateArticle = $priceComparisonArticle['article_id'];
    
    if ($affiliatePartnerProduct = $AffiliatePartner->getApSingleProduct($affiliateArticle, $affiliatePartner)) {
        
        $affiliatePartnerProducts[] = array(
            'partner' => $affiliatePartner,
            'product' => $affiliatePartnerProduct
        );
    }
}

foreach ($affiliatePartners as $affiliatePartner) {
    
    if ($affiliatePartner == 'affilinet') {
        
        if (isset($affilinetSettingErrors) && strlen($affilinetSettingErrors) > 10) {
            echo $affilinetSettingErrors;
        } else {
            
            if (is_array($productEANs) && count($productEANs) > 0) {
                foreach ($productEANs as $productEAN) {
                    $ean = trim($productEAN);
                    
                    $searchProductsRequest = $Affilinet->searchProducts(array(
                        'Query' => $productTitle,
                        'fq' => 'EAN:' . $ean
                    ));
                    
                    if (is_object($searchProductsRequest) && isset($searchProductsRequest->Products) && count($searchProductsRequest->Products) > 0) {
                        $affilinetProductSet = $searchProductsRequest->Products->Product;
                        
                        if (is_array($affilinetProductSet) && count($affilinetProductSet) > 0) {
                            
                            foreach ($affilinetProductSet as $key => $value) {
                                $affiliatePartnerProduct = $AffiliatePartner->getProduct($value, 'affilinet');
                                $affiliatePartnerProductEan = $affiliatePartnerProduct->getEan();
                                
                                if ($ean = $affiliatePartnerProductEan) {
                                    $affiliatePartnerProducts[] = array(
                                        'partner' => 'affilinet',
                                        'product' => $affiliatePartnerProduct
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    if ($affiliatePartner == 'zanox') {
        
        if (isset($zanoxSettingErrors) && strlen($zanoxSettingErrors) > 10) {
            echo $zanoxSettingErrors;
        } else {
            
            if (is_array($productEANs) && count($productEANs) > 0) {
                foreach ($productEANs as $productEAN) {
                    $ean = trim($productEAN);
                    
                    $zanoxRequest = $Zanox->searchProducts(array(
                        'ean' => $ean,
                        'region' => $zanoxSearchRegion,
                        'items' => 10
                    ));
                    
                    $zanoxProducts = json_decode($zanoxRequest);
                    
                    if (is_object($zanoxProducts->productItems) && count($zanoxProducts->productItems) > 0) {
                        
                        foreach ($zanoxProducts->productItems->productItem as $key => $value) {
                            
                            $affiliatePartnerProduct = $AffiliatePartner->getProduct($value, 'zanox');
                            $affiliatePartnerProductEan = $affiliatePartnerProduct->getEan();
                            
                            if ($ean = $affiliatePartnerProductEan) {
                                $affiliatePartnerProducts[] = array(
                                    'partner' => 'zanox',
                                    'product' => $affiliatePartnerProduct
                                );
                            }
                        }
                    }
                }
            }
        }
    }
    
    if ($affiliatePartner == 'amazon') {
        
        if (isset($amazonSettingErrors) && strlen($amazonSettingErrors) > 10) {
            echo $amazonSettingErrors;
        } else {
            
            if (is_array($productEANs) && count($productEANs) > 0) {
                foreach ($productEANs as $productEAN) {
                    $ean = trim($productEAN);
                    
                    $amazonProductsXml = $Amazon->getProductsByEan($country, $ean);
                    
                    if (! $amazonProductsXml->Error) {
                        
                        if (count($amazonProductsXml->Items->Item) > 0) {
                            
                            foreach ($amazonProductsXml->Items->Item as $item) {
                                $affiliatePartnerProduct = $AffiliatePartner->getProduct($item, 'amazon');
                                $affiliatePartnerProductEan = $affiliatePartnerProduct->getEan();
                                
                                if ($ean = $affiliatePartnerProductEan) {
                                    $affiliatePartnerProducts[] = array(
                                        'partner' => 'amazon',
                                        'product' => $affiliatePartnerProduct
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

$priceCompareProducts = array();

foreach ($affiliatePartnerProducts as $key => $value) {
    
    $partner = $value['partner'];
    $product = $value['product'];
    
    if (doubleval($product->getProductPrices()->price) > 0) {
        $priceCompareProducts[] = array(
            'affiliate_partner' => $partner,
            'shop' => $product->getProductShopName(),
            'price' => doubleval($product->getProductPrices()->price),
            'shipping' => doubleval($product->getShippingCosts()),
            'article_number' => $product->getProductId(),
            'product_name' => $product->getName(),
            'deeplink' => $product->getTrackingLinks()->affiliateLink
        );
    }
}

function getUniqueProducts($array)
{
    $result = array_map("unserialize", array_unique(array_map("serialize", $array)));
    
    foreach ($result as $key => $value) {
        if (is_array($value)) {
            $result[$key] = getUniqueProducts($value);
        }
    }
    
    return $result;
}

$priceCompareProducts = getUniqueProducts($priceCompareProducts);

function sortByProductTotalPrice($a, $b)
{
    return ($a['price'] + $a['shipping']) > ($b['price'] + $b['shipping']);
}

uasort($priceCompareProducts, 'sortByProductTotalPrice');

$result = 0;

if (count($priceCompareProducts) > 0) {
    
    foreach ($priceCompareProducts as $product) {
        
        $apArticle = $product['affiliate_partner'] . '_' . $product['article_number'];
        
        $mod = 'add';
        $buttonLabel = 'einbinden';
        $buttonClass = 'add-ap-article';
        $comparePricesBoxRowClass = '';
        
        if (in_array($apArticle, $priceComparisonArticleKeys)) {
            $mod = 'delete';
            $buttonLabel = 'entfernen';
            $buttonClass = 'delete-ap-article';
            $comparePricesBoxRowClass = 'selected-article';
        }
        
        ?>

<div
	class="get-compare-prices-box-row <?php echo $comparePricesBoxRowClass; ?>"
	id="compare-prices-box-row-<?php echo $productId; ?>">
	<div class="compare-prices-box-col1 compare-prices-box-cols">
		<input type="checkbox" name="affiliate_partners"
			class="compare-prices-cb-<?php echo $productId; ?>"
			value="<?php echo $apArticle; ?>" /> <img
			src="../wp-content/themes/affiliatetheme/images/<?php echo $product['affiliate_partner']; ?>_h18.png"
			alt="<?php echo $product['affiliate_partner']; ?>"
			class="ap-select-icon" />
	</div>

	<div class="compare-prices-box-col2 compare-prices-box-cols">
						<?php echo $product['shop']; ?>
					</div>

	<div class="compare-prices-box-col3 compare-prices-box-cols">
						<?php echo $AffiliatePartner->formatPrice($product['price']); ?>
					</div>

	<div class="compare-prices-box-col4 compare-prices-box-cols">&nbsp;
						<?php echo $AffiliatePartner->formatPrice($product['shipping']); ?>
					</div>

	<div class="compare-prices-box-col5 compare-prices-box-cols">
						<?php echo $product['article_number']; ?>
					</div>

	<div class="compare-prices-box-col6 compare-prices-box-cols">
		<a href="<?php echo $product['deeplink']; ?>" target="_blank"><?php echo $product['product_name']?></a>
	</div>

	<div
		class="compare-prices-box-col7 compare-prices-box-cols handle_ap_article button-primary <?php echo $buttonClass; ?>"
		data-mod="<?php echo $mod; ?>"
		data-product-id="<?php echo $productId; ?>"
		data-article-id="<?php echo $apArticle; ?>"><?php echo $buttonLabel; ?></div>
</div>
<div class="clearfix"></div>

<?php } ?>


<span data-mod="add" data-product-id="<?php echo $productId; ?>"
	class="button-primary handle_ap_multiple_article">Preisvergleich
	speichern</span>

<a href="<?php echo site_url(); ?>" id="blogurl" style="display: none;"></a>
<div id="save_data"></div>
<?php
} else {
    ?>
<div id="message" class="error">
	<p>
		<strong>Keine Ergebnisse!</strong> Leider konnten keine passenden
		Produkte gefunden werden.
	</p>
</div>
<?php
}

?>

<script type="text/javascript">

	jQuery(document).ready(function ($) {

		jQuery('.handle_ap_article').click(function () {
			var mod = jQuery(this).attr('data-mod');
			var product_id = jQuery(this).attr('data-product-id');
			var article_id = jQuery(this).attr('data-article-id');

			executeUpadteRequest(mod, product_id, article_id);
			
		});

		jQuery('.handle_ap_multiple_article').click(function () {
			var mod = jQuery(this).attr('data-mod');
			var product_id = jQuery(this).attr('data-product-id');
			var article_id = jQuery(this).attr('data-article-id');

			var article_ids = '';

			jQuery('.compare-prices-cb-'+product_id).each(function(){
				if(this.checked){
					article_ids += jQuery(this).val();
					article_ids +='#';
				}
			});

			executeUpadteRequest(mod, product_id, article_ids);
			
		});
	});

	function executeUpadteRequest(mod, product_id, article_ids){
		jQuery.ajax({
			type: "POST",
			data: {
				mod: mod,
				product_id: product_id,
				ap_article_ids: article_ids
			},
			dataType: "script",
			url: '<?php echo site_url(); ?>/wp-content/themes/affiliatetheme/library/affiliatePartners/updatePriceComparisonEntry.php',
			success: function (data) {
			},
		});
	}
</script>