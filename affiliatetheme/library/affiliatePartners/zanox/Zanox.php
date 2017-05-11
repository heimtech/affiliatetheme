<?php

class Zanox
{

    private $connectid = null;

    private $apiUrl = null;

    private $region = null;

    private $secretkey = null;

    function __construct($secretkey, $connectid, $region)
    {
        $this->connectid = $connectid;
        $this->apiUrl = 'https://api.zanox.com/json/2011-03-01';
        $this->region = $region;
        $this->secretkey = $secretkey;
    }

    public function searchProducts($parameter)
    {
        $parameter['connectid'] = $this->connectid;
        
        $parameterQuery = http_build_query($parameter);
        $apiCallUrl = $this->apiUrl . '/products?' . $parameterQuery;
        
        return $this->loadJsonFromUrl($apiCallUrl);
    }

    public function getProductById($productId)
    {
        $nonce = $this->createNonce();
        $ts = gmdate('D, d M Y H:i:s T');
        $sign = $this->createSignature('GET', '/adspaces', $nonce, $ts);
        
        $parameter = array(
            'connectid' => $this->connectid,
            'date' => $ts,
            'nonce' => $nonce,
            'signature' => $sign
        );
        
        $parameterQuery = http_build_query($parameter);
        $apiCallUrl = $this->apiUrl . '/products/product/' . $productId . '?' . $parameterQuery;
        
        return $this->loadJsonFromUrl($apiCallUrl);
    }

    public function getPrograms($items, $page)
    {
        $apiCallUrl = $this->apiUrl . '/programs?hasproducts=true' . '&region=' . $this->region . '&partnership=DIRECT' . '&items=' . $items . '&page=' . $page . '&connectid=' . $this->connectid;
        
        return $this->loadJsonFromUrl($apiCallUrl);
    }

    public function getProgramByProgramId($programId)
    {
        $apiCallUrl = $this->apiUrl . '/programs/program/' . $programId . '?connectid=' . $this->connectid;
        return $this->loadJsonFromUrl($apiCallUrl);
    }

    public function getAdspaces()
    {
        $nonce = $this->createNonce();
        $ts = gmdate('D, d M Y H:i:s T');
        $sign = $this->createSignature('GET', '/adspaces', $nonce, $ts);
        
        $parameter = array(
            'connectid' => $this->connectid,
            'date' => $ts,
            'nonce' => $nonce,
            'signature' => $sign,
            'items' => 50
        );
        
        $parameterQuery = http_build_query($parameter);
        $apiCallUrl = $this->apiUrl . '/adspaces?' . $parameterQuery;
        
        return $this->loadJsonFromUrl($apiCallUrl);
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

    private function createNonce()
    {
        return md5(microtime() . mt_rand());
    }

    private function createSignature($service, $method, $nonce, $ts)
    {
        $sign = $service . strtolower($method) . $ts . $nonce;
        $hmac = $this->createHmac($sign);
        return ($hmac) ? $hmac : false;
    }

    private function createHmac($params)
    {
        $hmac = hash_hmac('sha1', utf8_encode($params), $this->secretkey);
        return $this->encodeHmac($hmac);
    }

    private function encodeHmac($str)
    {
        $encode = '';
        for ($i = 0; $i < strlen($str); $i += 2) {
            $encode .= chr(hexdec(substr($str, $i, 2)));
        }
        return base64_encode($encode);
    }
}