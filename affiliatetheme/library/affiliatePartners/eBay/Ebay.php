<?php

class Ebay
{

    private $eBayAppId = null;

    private $eBayServiceEndpoint = null;

    private $eBayGlobalId = null;

    private $eBayApiVersion = null;

    private $affiliateTrackingId = null;

    private $affiliateNetworkId = null;

    private $affiliateCustomId = null;

    function __construct($publisherData)
    {
        $this->eBayAppId = $publisherData['eBayAppId'];
        $this->eBayServiceEndpoint = $publisherData['eBayServiceEndpoint'];
        $this->eBayGlobalId = $publisherData['eBayGlobalId'];
        $this->eBayApiVersion = $publisherData['eBayApiVersion'];
        
        $this->affiliateTrackingId = $publisherData['affiliateTrackingId'];
        $this->affiliateNetworkId = $publisherData['affiliateNetworkId'];
        $this->affiliateCustomId = $publisherData['affiliateCustomId'];
    }

    public function findItemsAdvanced($keywords, $searchParams, $searchFilter)
    {
        $apiCall = $this->eBayServiceEndpoint . "?";
        $apiCall .= "OPERATION-NAME=findItemsAdvanced";
        $apiCall .= "&SERVICE-VERSION=" . $this->eBayApiVersion;
        $apiCall .= "&SECURITY-APPNAME=" . $this->eBayAppId;
        $apiCall .= "&GLOBAL-ID=" . $this->eBayGlobalId;
        $apiCall .= "&RESPONSE-DATA-FORMAT=XML";
        $apiCall .= "&affiliate.networkId=" . $this->affiliateNetworkId;
        $apiCall .= "&affiliate.customId=" . $this->affiliateCustomId;
        $apiCall .= "&affiliate.trackingId=" . $this->affiliateTrackingId;
        
        if (isset($searchParams['categoryId']) && $searchParams['categoryId'] > 0) {
            $apiCall .= "&categoryId=" . $searchParams['categoryId'];
        }
        
        $apiCall .= "&keywords=" . urlencode($keywords);
        $apiCall .= "&paginationInput.entriesPerPage=" . $searchParams['entriesPerPage'];
        $apiCall .= "&paginationInput.pageNumber=" . $searchParams['pageNumber'];
        $apiCall .= "&outputSelector(0)=SellerInfo";
        $apiCall .= "&outputSelector(1)=StoreInfo";
        $apiCall .= "&outputSelector(2)=PictureURLLarge";
        $apiCall .= "&outputSelector(3)=PictureURLSuperSize";
        
        // $apiCall .= "&outputSelector(2)= AspectHistogram";
        // $apiCall .= "&outputSelector(3)= CategoryHistogram";
        
        $apiCall .= $this->createSearchFilter($searchFilter);
        
        return simplexml_load_file($apiCall);
    }

    public function getProductById($itemId)
    {
        $apiCall = 'http://open.api.ebay.com/Shopping';
        $apiCall .= '?callname=GetSingleItem';
        $apiCall .= '&responseencoding=XML';
        $apiCall .= '&appid=' . $this->eBayAppId;
        $apiCall .= '&siteid=' . $this->getSiteId();
        $apiCall .= "&trackingpartnercode=" . $this->affiliateNetworkId;
        $apiCall .= "&affiliateuserid=" . $this->affiliateCustomId;
        $apiCall .= "&trackingid=" . $this->affiliateTrackingId;
        $apiCall .= '&version=515';
        $apiCall .= '&ItemID=' . $itemId;
        
        return simplexml_load_file($apiCall);
    }

    public function getCategories()
    {
        $apiCall = 'http://open.api.ebay.com/Shopping';
        $apiCall .= '?callname=GetCategoryInfo';
        $apiCall .= '&responseencoding=XML';
        $apiCall .= '&appid=' . $this->eBayAppId;
        $apiCall .= '&siteid=' . $this->getSiteId();
        $apiCall .= '&CategoryID=-1';
        $apiCall .= '&version=729';
        $apiCall .= '&IncludeSelector=ChildCategories';
        
        return simplexml_load_file($apiCall);
    }

    private function createSearchFilter($filterElements)
    {
        $i = 0;
        $searchFilter = '';
        foreach ($filterElements as $filterElement) {
            foreach ($filterElement as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $j => $content) {
                        $searchFilter .= "&itemFilter($i).$key($j)=$content";
                    }
                } else {
                    if ($value != "") {
                        $searchFilter .= "&itemFilter($i).$key=$value";
                    }
                }
            }
            $i ++;
        }
        return $searchFilter;
    }

    private function getSiteId()
    {
        $siteIds = array(
            "EBAY-DE" => 77,
            "EBAY-GB" => 3,
            "EBAY-FR" => 71,
            "EBAY-ES" => 186,
            "EBAY-NL" => 146,
            "EBAY-AT" => 16,
            "EBAY-CH" => 193
        );
        
        return $siteIds[$this->eBayGlobalId];
    }
}
