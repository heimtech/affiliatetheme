<?php

class Tradedoubler
{

    private $token = null;

    private $apiUrl = null;

    function __construct($token, $apiUrl)
    {
        $this->token = $token;
        $this->apiUrl = $apiUrl;
    }

    public function searchProducts($queryKeys)
    {
        $queryParams = '';
        foreach ($queryKeys as $key => $value) {
            $queryParams .= ';' . $key . '=' . urlencode($value);
        }
        
        $url = $this->apiUrl . '' . $queryParams . '?token=' . $this->token;
        
        $products = $this->loadXmlFromUrl($url);
        return $products;
    }

    public function getProductById($productId)
    {
        $queryParams = 'tdId=' . $productId;
        
        $url = $this->apiUrl . '' . $queryParams . '?token=' . $this->token;
        
        $product = $this->loadXmlFromUrl($url);
        return $product;
    }
    
    public function getFeeds()
    {
        $apiUrl = 'https://api.tradedoubler.com/1.0/productFeeds/?token=' . $this->token;
        return $this->loadJsonFromUrl($apiUrl);
    }

    private function loadXmlFromUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        $data = str_replace("ns2:", "", $data);
        curl_close($ch);
        $xml = simplexml_load_string($data);
        
        return $xml;
    }
    
    private function loadJsonFromUrl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        
        return $data;
    }
}
