<?php
header('Content-Type: text/html; charset=utf-8');
define('WP_USE_THEMES', false);
require_once ('../../../../../wp-load.php');

$productId = trim(filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_STRING));
$apArticleIdsString = trim(filter_input(INPUT_POST, 'ap_article_ids', FILTER_SANITIZE_STRING));
$mod = trim(filter_input(INPUT_POST, 'mod', FILTER_SANITIZE_STRING));


$apArticleIdsArray = explode('#', $apArticleIdsString);

$apArticleIds = array();
$articleIds = array();
foreach ($apArticleIdsArray as $apArticleId) {
    
    $article = explode('_', $apArticleId);
    
    $apArticleIds[] = array(
        'partner' => $article[0],
        'article_id' => $article[1]
    );
    
    $articleIds[] = $apArticleId;
}

if (count($articleIds) > 0) {
    $PriceComparison = new PriceComparison();
    $PriceComparison->updateApArticleIds($productId, $apArticleIds, $mod);
    
    $script .= 'var articleIds=["' . implode('","', $articleIds) . '"];' . "\n";
    
    $script .= 'updateComparisonSearchList("'.$productId.'",articleIds,"' . $mod . '");' . "\n";
    
    echo $script;
}

