<?php

class Amazon
{

    private $AWSAccessKeyId = null;

    private $AssociateTag = null;

    private $amazonSecretKey = null;

    function __construct($AWSAccessKeyId, $AssociateTag, $amazonSecretKey)
    {
        $this->AWSAccessKeyId = $AWSAccessKeyId;
        
        $this->AssociateTag = $AssociateTag;
        $this->amazonSecretKey = $amazonSecretKey;
    }

    public function searchProducts($parameters)
    {
        $time = gmdate("Y-m-d\TH:i:s\Z");
        
        $uri = 'Operation=ItemSearch&Version=2011-08-01&Keywords=' . urlencode($parameters['Keywords']) . '&ItemPage=' . $parameters['ItemPage'];
        if (isset($parameters['search_index']) && strlen($parameters['search_index']) > 0) {
            $uri .= "&SearchIndex=" . $parameters['search_index'];
        } else {
            $uri .= '&SearchIndex=All';
        }
        $uri .= "&ResponseGroup=Large";
        $uri .= "&MerchantId=All";
        $uri .= "&AWSAccessKeyId=" . $this->AWSAccessKeyId;
        $uri .= "&AssociateTag=" . $this->AssociateTag;
        $uri .= "&Timestamp=" . $time;
        $uri .= "&Service=AWSECommerceService";
        $uri = str_replace(',', '%2C', $uri);
        $uri = str_replace(':', '%3A', $uri);
        $uri = str_replace('*', '%2A', $uri);
        $uri = str_replace('~', '%7E', $uri);
        $uri = str_replace('+', '%20', $uri);
        $sign = explode('&', $uri);
        sort($sign);
        $host = implode("&", $sign);
        $host = "GET\nwebservices.amazon." . $parameters['country'] . "\n/onca/xml\n" . $host;
        $signed = urlencode(base64_encode(hash_hmac("sha256", $host, $this->amazonSecretKey, True)));
        $uri .= "&Signature=$signed";
        $uri = "http://webservices.amazon." . $parameters['country'] . "/onca/xml?" . $uri;
        
        return $this->loadContentFromUrl($uri);
    }

    public function getProductById($region, $params)
    {
        $host = 'webservices.amazon.' . $region;
        $uri = '/onca/xml';
        
        $params['Service'] = 'AWSECommerceService';
        $params['AWSAccessKeyId'] = $this->AWSAccessKeyId;
        $params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
        $params['Version'] = '2011-08-01';
        $params['AssociateTag'] = $this->AssociateTag;
        
        ksort($params);
        
        $canonicalized_query = array();
        foreach ($params as $param => $value) {
            $param = str_replace('%7E', '~', rawurlencode($param));
            $value = str_replace('%7E', '~', rawurlencode($value));
            $canonicalized_query[] = $param . '=' . $value;
        }
        $canonicalized_query = implode('&', $canonicalized_query);
        
        $string_to_sign = "GET\n" . $host . "\n" . $uri . "\n" . $canonicalized_query;
        $signature = base64_encode(hash_hmac('sha256', $string_to_sign, $this->amazonSecretKey, TRUE));
        $signature = str_replace('%7E', '~', rawurlencode($signature));
        
        $request = 'http://' . $host . $uri . '?' . $canonicalized_query . '&Signature=' . $signature;
        
        return $request;
    }

    public function getProductsByEan($region, $ean)
    {
        $host = 'webservices.amazon.' . $region;
        $uri = '/onca/xml';
        
        $params['Operation'] = 'ItemLookup';
        $params['ItemId'] = $ean;
        $params['IdType'] = 'EAN';
        $params['SearchIndex'] = 'All';
        $params['ResponseGroup'] = 'Large';
        
        $params['Service'] = 'AWSECommerceService';
        $params['AWSAccessKeyId'] = $this->AWSAccessKeyId;
        $params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
        $params['Version'] = '2011-08-01';
        $params['AssociateTag'] = $this->AssociateTag;
        
        ksort($params);
        
        $canonicalized_query = array();
        foreach ($params as $param => $value) {
            $param = str_replace('%7E', '~', rawurlencode($param));
            $value = str_replace('%7E', '~', rawurlencode($value));
            $canonicalized_query[] = $param . '=' . $value;
        }
        $canonicalized_query = implode('&', $canonicalized_query);
        
        $string_to_sign = "GET\n" . $host . "\n" . $uri . "\n" . $canonicalized_query;
        $signature = base64_encode(hash_hmac('sha256', $string_to_sign, $this->amazonSecretKey, TRUE));
        $signature = str_replace('%7E', '~', rawurlencode($signature));
        
        $uri = 'http://' . $host . $uri . '?' . $canonicalized_query . '&Signature=' . $signature;
        
        return $this->loadContentFromUrl($uri);
    }

    public function getStarRating($asin, $region)
    {
        $starRating = '';
        $url = 'http://www.amazon.' . $region . '/gp/customer-reviews/widgets/average-customer-review/popover/ref=dpx_acr_pop_?contextId=dpx&asin=' . $asin;
        
        $CustomerReviews = $this->loadContentFromUrl($url, 'plain');
        
        preg_match("'<span class=\"a-size-base a-color-secondary\">(.*?)</span>'si", $CustomerReviews, $match);
        if (is_array($match) && count($match) > 0) {
            $grepResult = $match[1];
            $grepSplit = explode('von', $grepResult);
            $starRating = trim($grepSplit[0]);
        }
        
        return $starRating;
    }

    public function getStarRatingFromIframeUrl($iframeUrl)
    {
        $CustomerReviews = $this->loadContentFromUrl($iframeUrl, 'plain', true);
        
        preg_match("'alt=\"(.*?)(von|out of) 5 (Sternen|stars)\"'i", $CustomerReviews, $match);
        
        $starRating = trim($match[1]);
        $starRating = ceil(($starRating * 2)) / 2;
        
        return $starRating;
    }

    public function grabAsinsFromUrl($url)
    {
        $subject = $this->loadContentFromUrl($url, 'plain', true);
        
        $pattern = "/a[\s]+[^>]*?href[\s]?=[\s\"\']+" . "(.*?)[\"\']+.*?>" . "([^<]+|.*?)?<\/a>/";
        
        preg_match_all($pattern, $subject, $matches, PREG_PATTERN_ORDER);
        
        $asinArray = array();
        
        $count = 0;
        
        if (isset($matches[1]) && is_array($matches[1]) && count($matches[1]) > 0) {
            
            foreach ($matches[1] as $productUrl) {
                
                if ($count == 50) {
                    break;
                }
                
                $pathElements = explode("/", $productUrl);
                
                if (count($pathElements) >= 5) {
                    
                    if ($pathElements[4] == 'dp') {
                        $asinArray[] = $pathElements[5];
                        $count ++;
                    }
                }
            }
        }
        
        if (count($asinArray) > 0) {
            $asinArray = array_unique($asinArray);
        }
        
        return implode(',', $asinArray);
    }

    private function loadContentFromUrl($url, $returnFormat = 'xml', $header = false)
    {
        $result = $this->curlExec($url, $header);
        
        if ($returnFormat == 'xml') {
            return simplexml_load_string($result);
        } else {
            return $result;
        }
    }

    private function curlExec($url, $header = false)
    {
        $newUrl = $url;
        $maxRedirection = 20;
        do {
            if ($maxRedirection < 1) {
                die('Error: max. redirection reached!');
            }
            
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_HEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            
            if (! empty($newUrl)) {
                curl_setopt($ch, CURLOPT_URL, $newUrl);
            }
            
            $curlResult = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if ($code == 301 || $code == 302 || $code == 303 || $code == 307) {
                preg_match('/Location:(.*?)\n/', $curlResult, $matches);
                $newUrl = trim(array_pop($matches));
                curl_close($ch);
                
                $maxRedirection --;
                continue;
            } else {
                $code = 0;
                curl_close($ch);
            }
        } while ($code);
        return $curlResult;
    }
}