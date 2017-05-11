<?php
require_once 'AffiliatePartner.php';

$affiliatePartner = new AffiliatePartner();

$partnerList = array(
    1 => array (
        'partner' => 'amazon',
        'partnerLabel' => 'Amazon',
        'partnerLink' => 'https://partnernet.amazon.de/'        
    ),    
    2 => array (
        'partner' => 'zanox',
        'partnerLabel' => 'Zanox',
        'partnerLink' => 'http://zanox.com/de/'
    ),    
    3 => array (
        'partner' => 'belboon',
        'partnerLabel' => 'Belboon',
        'partnerLink' => 'http://www1.belboon.de/adtracking/033c9e08c5660004eb00019f.html'
    ),    
    4 => array (
        'partner' => 'affilinet',
        'partnerLabel' => 'Affilinet',
        'partnerLink' => 'http://www.affili.net/de/home'
    ),    
    5 => array (
        'partner' => 'tradedoubler',
        'partnerLabel' => 'Tradedoubler',
        'partnerLink' => 'http://clkde.tradedoubler.com/click?p(82)a(2789262)g(11705314)url(http://www.tradedoubler.com/de-de/)'
    ),    
    6 => array (
        'partner' => 'eBay',
        'partnerLabel' => 'eBay',
        'partnerLink' => 'https://publisher.ebaypartnernetwork.ebay.com/files/hub/de-DE/migrationHub.html'
    )
);
?>
<style>
<!--
.theme-actions {
	position: relative !important;
	height: 2px;
}

.ap-actions {
	display: none;
}

div.theme-actions a.button {
	width: 200px;
}

div.theme {
	float: left !important;
	margin: 10px !important;
}
-->
</style>
<div class="wrap">

	<h1>Übersicht der aktuellen Affiliate Partners</h1>

	<div class="theme-browser rendered">

		<div class="themes">
			
			<?php
			$i=1;
			foreach ($partnerList as $key=>$value){
			    
			    echo $affiliatePartner->writePartnerBlock($key, $value);
			    
			    if ($i % 3 === 0) {
			        echo '<div class="clearfix"></div>';
			        
			    }
			    
			    $i ++;
			    
			}
			?>
		</div>
		<p style="text-align: right;">* = Partnerlink</p>
	</div>

</div>

<script type="text/javascript">
<!--
jQuery(".theme").mouseenter(function() {
	jQuery(this).children(".ap-actions").toggle();
}).mouseleave(function () {
	jQuery(this).children(".ap-actions").toggle();
});
//-->
</script>