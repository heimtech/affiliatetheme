<?php

class PriceComparison
{

    private $wpdb;

    private $priceComparisonTable;

    function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->priceComparisonTable = $this->wpdb->prefix . "product_price_comparison";
        
        $this->cratePriceComparisonTable();
    }

    public function cratePriceComparisonTable()
    {
        $query = " CREATE TABLE " . $this->priceComparisonTable . " (
		  `id` INT(9) NOT NULL AUTO_INCREMENT,
		  `product_id` INT(9) NOT NULL,
		  `ap_article_ids` longtext,
		  UNIQUE KEY id (id)
		);";
        
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($query);
    }

    public function getProductsWithEan()
    {
        $products = get_posts(array(
            'meta_query' => array(
                array(
                    'key' => 'ean',
                    'value' => array(
                        ''
                    ),
                    'compare' => 'NOT IN'
                )
            ),
            'numberposts' => - 1,
            'post_type' => 'produkt',
            'post_status' => 'publish'
        ));
        
        return $products;
    }

    public function getPriceComparisonEntryByPostId($productId)
    {
        return $this->wpdb->get_row('SELECT * FROM ' . $this->priceComparisonTable . '
            WHERE product_id = ' . (int) $productId, OBJECT);
    }

    public function hasPriceComparison($productId)
    {
        $res = array();
        
        if ($this->wpdb->get_var('SHOW TABLES LIKE "' . $this->priceComparisonTable . '"') == $this->priceComparisonTable) {
            
            $res = $this->wpdb->get_results(' SELECT * FROM ' . $this->priceComparisonTable . ' WHERE product_id = ' . $productId, OBJECT);
        }
        
        return $res;
    }

    public function deletePriceComparisonEntry($productId)
    {
        $this->wpdb->query($this->wpdb->prepare("
				DELETE FROM " . $this->priceComparisonTable . " WHERE product_id = %d
				", (int) $productId));
    }

    public function updateApArticleIds($productId, $apArticleIds, $mod = 'add')
    {
        if ($productId > 0) {
            $currentApArticleIds = array();
            $newApArticleIds = array();
            
            $priceComparisonEntry = $this->getPriceComparisonEntryByPostId($productId);
            
            if (isset($priceComparisonEntry->id) && $priceComparisonEntry->id > 0) {
                
                if (isset($priceComparisonEntry->ap_article_ids) && $priceComparisonEntry->ap_article_ids != "") {
                    
                    $currentApArticleIds = unserialize($priceComparisonEntry->ap_article_ids);
                }
            } else {
                
                $query = "INSERT INTO " . $this->priceComparisonTable . " (product_id) VALUES (%d) ";
                
                $this->wpdb->query($this->wpdb->prepare($query, (int) $productId));
            }
            
            if ($mod == 'add') {
                foreach ($apArticleIds as $apArticleId) {
                    array_push($currentApArticleIds, $apArticleId);
                }
                $newApArticleIds = $currentApArticleIds;
            } else {
                $elemKeyToDelete = $apArticleIds[0]['partner'] . '-' . $apArticleIds[0]['article_id'];
                foreach ($currentApArticleIds as $currentApArticleId) {
                    $elemKeyExists = $currentApArticleId['partner'] . '-' . $currentApArticleId['article_id'];
                    
                    if ($elemKeyToDelete != $elemKeyExists) {
                        array_push($newApArticleIds, $currentApArticleId);
                    }
                }
            }
            
            $uniqueApArticleIds = array();
            $uniqueKeys = array();
            foreach ($newApArticleIds as $newApArticleId) {
                $uniqueKey = $newApArticleId['partner'] . '-' . $newApArticleId['article_id'];
                if (! in_array($uniqueKey, $uniqueKeys)) {
                    array_push($uniqueKeys, $uniqueKey);
                    array_push($uniqueApArticleIds, $newApArticleId);
                }
            }
            
            $newApArticleIds = serialize($uniqueApArticleIds);
            
            $query = "UPDATE " . $this->priceComparisonTable . " SET ap_article_ids= %s WHERE product_id = %d";
            
            return $this->wpdb->query($this->wpdb->prepare($query, $newApArticleIds, (int) $productId));
        }
    }
}