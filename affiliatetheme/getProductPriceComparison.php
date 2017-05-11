<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../wp-load.php');
require_once (TEMPLATEPATH . '/library/affiliatePartners/AffiliatePartner.php');
require_once (TEMPLATEPATH . '/library/affiliatePartners/zanox/Zanox.php');
require_once (TEMPLATEPATH . '/library/affiliatePartners/zanox/zanoxMandatoryOptions.php');
$AffiliatePartner = new AffiliatePartner();
$PriceComparison = new PriceComparison();

global $wpdb, $affiliseo_options;

$apShippingCosts = (isset($affiliseo_options['shipping_costs_ap'])) ? $affiliseo_options['shipping_costs_ap'] : 'Informationen über die Versandkosten finden Sie auf der Seite des Affilatepartners';
$apDeliveryTime = (isset($affiliseo_options['delivery_time_ap'])) ? $affiliseo_options['delivery_time_ap'] : 'Informationen über die Lieferzeit finden Sie auf der Seite des Affilatepartners';

$text_button_price_comparison = (isset($affiliseo_options['text_button_price_comparison'])) ? $affiliseo_options['text_button_price_comparison'] : 'zum Shop';

$free = (isset($affiliseo_options['free'])) ? $affiliseo_options['free'] . ' ' : 'kostenfrei';



$pos_currency = 'before';
if ($affiliseo_options['pos_currency']) {
    $pos_currency = $affiliseo_options['pos_currency'];
}

$post_id = filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_STRING);

$postProduct = get_post($post_id);

$priceComparisonArticles = array();
$priceComparisonEntry = $PriceComparison->getPriceComparisonEntryByPostId($post_id);
if (isset($priceComparisonEntry->id) && $priceComparisonEntry->id > 0) {
    if (isset($priceComparisonEntry->ap_article_ids) && $priceComparisonEntry->ap_article_ids != "") {
        $priceComparisonArticles = unserialize($priceComparisonEntry->ap_article_ids);
    }
}

$products_array = array();
foreach ($priceComparisonArticles as $priceComparisonArticle) {
    $affiliatePartner = $priceComparisonArticle['partner'];
    $affiliateArticle = $priceComparisonArticle['article_id'];
    
    if ($affiliatePartnerProduct = $AffiliatePartner->getApSingleProduct($affiliateArticle, $affiliatePartner)) {
        
        $shipping = 'Versandkosten ';
        if (isset($affiliseo_options['text_shipping_price_comparison'])) {
            $shipping = $affiliseo_options['text_shipping_price_comparison'] . ' ';
        }
        
        if ($affiliatePartner == 'amazon') {
            $apLogo = 'http://library.corporate-ir.net/library/17/176/176060/mediaitems/106/a.de_logo_RGB_th.jpg';
        } elseif ($affiliatePartner == 'affilinet') {
            $apLogo = 'http://logos.affili.net/120/' . $affiliatePartnerProduct->getProductShopId() . '.gif';
        } elseif ($affiliatePartner == 'zanox') {
            
            $Zanox = new Zanox($zanoxSecretKey, $zanoxConnectId, $zanoxSearchRegion);
            
            $programId = $affiliatePartnerProduct->getProductShopId();
            
            $program = json_decode($Zanox->getProgramByProgramId($programId));
            
            $apLogo = $program->programItem[0]->image;
        } else {
            $apLogo = '';
        }
        
        if ($affiliatePartnerProduct->getShippingCosts() == '0.00') {
            $shipping .= "<strong>$free</strong><br />";
        } else {
            if (trim($pos_currency) === 'before') {
                $shipping .= $affiliatePartnerProduct->getCurrency() . ' ' . number_format(doubleval($affiliatePartnerProduct->getShippingCosts()), 2) . '<br />';
            } else {
                $shipping .= number_format(doubleval($affiliatePartnerProduct->getShippingCosts()), 2) . ' ' . $affiliatePartnerProduct->getCurrency() . '<br />';
            }
        }
        $shipping_suffix = 'unbekannte Lieferzeit';
        $productShipping = $affiliatePartnerProduct->getShipping();
        if (empty($productShipping)) {
            if (isset($affiliseo_options['shipping_suffix'])) {
                $shipping_suffix = $affiliseo_options['shipping_suffix'] . ' ';
            }
        } else {
            $shipping_suffix = $productShipping;
        }
        
        if ($affiliatePartnerProduct->getName() != "") {
            array_push($products_array, new Product($apLogo, $affiliatePartnerProduct->getProductShopName(), $shipping, $shipping_suffix, $affiliatePartnerProduct->getProductPrices()->price, $affiliatePartnerProduct->getCurrency(), $affiliatePartnerProduct->getTrackingLinks()->affiliateLink));
        }
    }
}

if (count($products_array) > 0) {
    
    sort_on_field($products_array, 'price', 'ASC');
    ?>

<table class="table table-striped price-comparison">
    <?php
    foreach ($products_array as $product) {
        if(doubleval($product->price)==0.00){
            continue;
        }
        
        ?>
        <tr>
		<td><img src="<?php echo $product->logo; ?>"
			alt="<?php echo $product->shop_title; ?>"></td>
		<td>
				<?php echo $product->shipping; ?> <i class="fa fa-truck"></i> <?php echo $product->shipping_suffix; ?>
			</td>

		<td class="text-center">
			<div class="price">
					<?php
        
        if (trim($pos_currency) === 'before') {
            echo $product->currency . ' ' . number_format($product->price, 2);
        } else {
            echo number_format($product->price, 2) . ' ' . $product->currency;
        }
        ?> *
        	</div>
		</td>

		<td class="text-center">
			<?php
        $go = $affiliseo_options['activate_cloaking'];
        if ($go === '1') {
            ?>
			    <form action="<?php bloginfo('url'); ?>/go/" method="post"
				target="_blank">
				<input type="hidden" value="<?php echo $product->deeplink; ?>"
					name="affiliate_link"> <input type="submit"
					value="<?php echo $text_button_price_comparison; ?>"
					class="btn btn-ap">
			</form>
			    <?php
        } else {
            ?>
                <a href="<?php echo $product->deeplink; ?>"
			class="btn btn-ap" target="_blank" rel="nofollow">
                	<?php echo $text_button_price_comparison; ?> <i
				class="fa fa-chevron-circle-right"></i>
		</a>
                <?php
        }
        ?>
        </td>
	</tr>
	<?php
    }
    ?>
</table>

<?php
    date_default_timezone_set('Europe/Berlin');
    $text_tax = __('VAT included.','affiliatetheme');
    if ($affiliseo_options['tax_string']) {
        $text_tax = $affiliseo_options['tax_string'];
    }
    ?>
<p class="text-right">
	<small>* <?php echo $text_tax; ?> | aktualisiert am <?php echo date('d.m.Y') ?> um <?php echo date('G:i'); ?> Uhr</small>
</p>
<?php
}

class Product
{

    public $logo;

    public $shop_title;

    public $shipping;

    public $shipping_suffix;

    public $price;

    public $currency;

    public $deeplink;

    function __construct($logo, $shop_title, $shipping, $shipping_suffix, $price, $currency, $deeplink)
    {
        $this->logo = $logo;
        $this->shop_title = $shop_title;
        $this->shipping = $shipping;
        $this->shipping_suffix = $shipping_suffix;
        $this->price = (float) $price;
        $this->currency = $currency;
        $this->deeplink = $deeplink;
    }
}

function sort_on_field(&$objects, $on, $order = 'ASC')
{
    $comparer = ($order === 'DESC') ? "return -strnatcmp(\$a->{$on},\$b->{$on});" : "return strnatcmp(\$a->{$on},\$b->{$on});";
    usort($objects, create_function('$a,$b', $comparer));
}