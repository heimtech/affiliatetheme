<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once('../../../../../../wp-load.php');

if ($_GET['secret'] != md5(trim(get_option('amazon_public_key')))) {
    echo 'Keine Berechtigung';
    die();
}

require_once 'Amazon.php';

$amazonPublicKey = get_option('amazon_public_key');
$amazonSecretKey = get_option('amazon_secret_key');
$amazonPartnerId = get_option('amazon_partner_id');
$currency = get_option('ap_currency');

$amazonApi = new Amazon($amazonPublicKey, $amazonPartnerId, $amazonSecretKey);

?>

<style>
    table tr.success{background:#DFF0D8;color:#3C763D;}
    table tr.warning{background:#FCF8E3;color:#8A6D3B;}
    table tr.error{background:#F2DEDE;color:#A94442;}
    table tr.success td.preis_neu{font-weight:bold;}
    table tr.success td.preis_alt{font-weight:bold;}
</style>

<table class="widefat">
    <thead>
        <tr>
            <th>Artikel</th>
            <th>Produkt ID</th>
            <th>Aktueller Preis</th>
            <th>Neuer Preis</th>
        </tr>
    </thead>
    <tbody>
        <?php
        

        $posttype = 'produkt';
        $customfield_pid = 'amazon_produkt_id';
        $customfield_preis = 'preis';
        $no_price_type = get_option('ap_no_price');

        if ($posttype == "" || $customfield_preis == "" || $customfield_pid == "" || !$currency) {
            echo 'FEHLER: Bitte überprüfen Sie Ihre Einstellungen.';
            die();
        }

        $args = array(
            'meta_key' =>'amazon_produkt_id',
            'post_type' => $posttype,
            'post_status' => 'any',
            'posts_per_page' => -1
        );

        $produkte = get_posts($args);
        if ($produkte) :
            foreach ($produkte as $produkt) :
                $produkt_id = get_post_meta($produkt->ID, $customfield_pid, true);
                $preis_alt = get_post_meta($produkt->ID, $customfield_preis, true);
                $price_type = get_post_meta($produkt->ID, 'price_type');

                if ($produkt_id) {
                    // start request
                    $request = $amazonApi->getProductById($currency, array(
                        'Operation' => 'ItemLookup',
                        'ItemId' => $produkt_id,
                        'ResponseGroup' => 'Large'));                    
                    

                    $response = @file_get_contents($request);
                    if ($response === FALSE) {
                        echo '
								<tr class="error">
									<td>' . get_the_title($produkt->ID) . '</td>
									<td colspan="3">FEHLER: Request failed. Amazon-Server überlastet. Wenn dieses Problem weiterhin besteht, wenden Sie sich bitte an den Support von Amazon.</td>
								</tr>
							';
                    } else {
                        // parse XML
                        $amazonProductsXml = simplexml_load_string($response);
                        if ($amazonProductsXml === FALSE) {
                            echo '
									<tr class="error">
										<td>' . get_the_title($produkt->ID) . '</td>
										<td colspan="3">FEHLER: Request Error</td>
									</tr>
								';
                        } else {
                            if (!isset($price_type[0]) || $price_type[0] === '') {
                                $price_type[0] = 'lowest_new';
                            }
                            $trackingLinks = new stdClass();
                            $trackingLinks->affiliateLink = "http://www.amazon.$currency/dp/$produkt_id/?tag=$amazonPartnerId";
                            $trackingLinks->affiliateLinkCart = "http://www.amazon.$currency/gp/aws/cart/add.html?AssociateTag=$amazonPartnerId&ASIN.1=$produkt_id&Quantity.1=1";
                            
                            $preis_neu = handlePriceType($price_type[0], $amazonProductsXml);
                            update_post_meta($produkt->ID, 'price_type', $price_type[0]);
                            echo handleOutput($preis_alt, $preis_neu, $produkt->ID, $produkt_id, $no_price_type, $trackingLinks);
                            update_product_modified($produkt->ID);
                        }
                    }
                } else {
                    echo '
							<tr class="error">
								<td>' . get_the_title($produkt->ID) . '</td>
								<td colspan="3">FEHLER: keine Produkt ID vorhanden</td>
							</tr>
						';
                }
                sleep(1);
            endforeach;
        endif;

        function handlePriceType($pricetype, $amazonProductsXml) {
            switch ($pricetype) {
                case 'lowest_used':
                    $price = number_format($amazonProductsXml->Items->Item->OfferSummary->LowestUsedPrice->Amount / 100, 2, ',', '');
                    break;
                case 'list':
                    $price = number_format($amazonProductsXml->Items->Item->ItemAttributes->ListPrice->Amount / 100, 2, ',', '');
                    break;
                case 'price':
                    $price = number_format($amazonProductsXml->Items->Item->Offers->Offer->OfferListing->Price->Amount / 100, 2, ',', '');
                    break;
                default:
                    $price = number_format($amazonProductsXml->Items->Item->OfferSummary->LowestNewPrice->Amount / 100, 2, ',', '');
            }
            return $price;
        }

        function handleOutput($preis_alt, $preis_neu, $id, $produkt_id, $no_price_type, $trackingLinks) {
            $output = '';
            
            if(isset($trackingLinks->affiliateLink) && $trackingLinks->affiliateLink!=""){
                update_post_meta($id, 'ap_pdp_link', $trackingLinks->affiliateLink);
            }
            
            if(isset($trackingLinks->affiliateLinkCart) && $trackingLinks->affiliateLinkCart!=""){
                update_post_meta($id, 'ap_cart_link', $trackingLinks->affiliateLinkCart);
            }
            
            if ($preis_alt != $preis_neu) {
                $class = 'success';
                update_post_meta($id, 'preis', $preis_neu);
            } else {
                $class = 'warning';
                update_post_meta($id, 'preis', $preis_neu);
            }
            if ($preis_neu === '0,00') {
                $class = 'error';
                $preis_neu = 'Es ist kein Preis verfügbar.';
                $to = get_bloginfo('admin_email');
                $subject = get_bloginfo('name') . ' Warnung: Kein Preis verfügbar.';
                $link = admin_url() . '/post.php?post=' . $id . '&action=edit';
                $message = 'Für das Produkt ' . get_the_title($id) . ' ist kein Preis verfügbar. Um dieses Problem zu lösen, können Sie im <a href="' . $link . '">Produkt</a> den Preistyp ändern, das Produkt erneut veröffentlichen und den Preis manuell aktualisieren. Wenn trotz dieser Maßnahmen das Problem weiterhin besteht, wenden Sie sich bitte an den Support von Amazon.';
                $headers = 'From: affiliseo <' . get_bloginfo('admin_email') . '>' . "\r\n";
                $link_backend = ' <a href="' . admin_url() . '/post.php?post=' . $id . '&action=edit">Produkt</a> ';
                global $no_price_string;
                switch ($no_price_type) {
                    case 'send_mail':
                        wp_mail($to, $subject, $message, $headers);
                        $preis_neu .= ' Eine E-Mail wurde an Sie versendet!';
                        break;
                    case 'deactivate':
                        $newpostdata['post_status'] = '';
                        $newpostdata['ID'] = $id;
                        wp_update_post($newpostdata);
                        $preis_neu .= ' Das' . $link_backend . 'wurde deaktiviert!';
                        break;
                    case 'send_mail_and_change':
                        wp_mail($to, $subject, $message, $headers);
                        $preis_neu = $no_price_string;
                        update_post_meta($id, 'preis', $preis_neu);
                        break;
                    case 'change':
                        $preis_neu = $no_price_string;
                        update_post_meta($id, 'preis', $preis_neu);
                        break;
                    default:
                        wp_mail($to, $subject, $message, $headers);
                        $newpostdata['post_status'] = '';
                        $newpostdata['ID'] = $id;
                        wp_update_post($newpostdata);
                        $preis_neu .= ' Das' . $link_backend . 'wurde deaktiviert und eine E-Mail an Sie versendet!';
                }
            }
            $output .= '
					<tr class="' . $class . '">
						<td>' . get_the_title($id) . '</td>
						<td>' . $produkt_id . '</td>
						<td class="preis_alt">' . $preis_alt . '</td>
						<td class="preis_neu">' . $preis_neu . '</td>		
					</tr>
				';
            return $output;
        }

        function update_product_modified($id) {
            global $wpdb;
            $wpdb->query(
                    $wpdb->prepare(
                            "
									UPDATE $wpdb->posts
									SET post_modified = %s,
									post_modified_gmt = %s
									WHERE ID = %s
								", current_time('mysql'), current_time('mysql', 1), (int) $id
                    )
            );
        }
        ?>
    </tbody>
</table>