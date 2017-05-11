<?php

class AffiliateProduct
{

    /**
     *
     * @var String
     */
    private $name;

    /**
     *
     * @var String
     */
    private $productId;

    /**
     *
     * @var String
     */
    private $modified;

    /**
     *
     * @var String
     */
    private $program;

    /**
     *
     * @var String
     */
    private $currency;

    /**
     *
     * @var stdClass
     */
    private $trackingLinks;

    /**
     *
     * @var String
     */
    private $description;

    /**
     *
     * @var String
     */
    private $descriptionLong;

    /**
     *
     * @var String
     */
    private $manufacturer;

    /**
     *
     * @var String
     */
    private $ean;

    /**
     *
     * @var String
     */
    private $deliveryTime;

    /**
     *
     * @var String
     */
    private $terms;

    /**
     *
     * @var String
     */
    private $category;

    /**
     *
     * @var stdClass
     */
    private $images;

    /**
     *
     * @var String
     */
    private $shippingCosts;

    /**
     *
     * @var String
     */
    private $shipping;

    /**
     *
     * @var String
     */
    private $merchantCategory;

    /**
     *
     * @var String
     */
    private $merchantProductId;

    /**
     *
     * @var String
     */
    private $productShopName;

    /**
     *
     * @var String
     */
    private $productShopId;

    /**
     *
     * @var stdClass
     */
    private $productPrices;

    /**
     *
     * @var String
     */
    private $starRating;

    /**
     *
     * @var stdClass
     */
    private $customerReviews;

    public function __construct($product, $partner)
    {
        switch ($partner) {
            case 'zanox':
                $this->setZanoxProduct($product);
                break;
            case 'amazon':
                $this->setAmazonProduct($product);
                break;
            case 'belboon':
                $this->setBelboonProduct($product);
                break;
            case 'affilinet':
                $this->setAffilinetProduct($product);
                break;
            case 'tradedoubler':
                $this->setTradedoublerProduct($product);
                break;
            case 'eBay':
                $this->setEBayProduct($product);
                break;
            case 'eBaySingleItem':
                $this->setEBaySingleItem($product);
                break;
        }
    }

    private function setZanoxProduct($product)
    {
        $zupId = $product->{'@id'};
        
        $this->setProductId($zupId);
        $this->setName($product->name);
        $this->setModified($product->modified);
        $this->setCurrency($product->currency);
        
        $productProgram = $product->program;
        $programId = $productProgram->{'@id'};
        
        $this->setProgram($programId);
        
        $productPrices = new stdClass();
        $productPrices->price = (double) $product->price;
        $productPrices->uvp = (double) $product->priceOld;
        $this->setProductPrices($productPrices);
        
        $this->setDescription($product->description);
        $this->setDescriptionLong($product->descriptionLong);
        $this->setManufacturer($product->manufacturer);
        $this->setEan($product->ean);
        $this->setDeliveryTime($product->deliveryTime);
        $this->setTerms($product->terms);
        $this->setShippingCosts($product->shippingCosts);
        $this->setShipping($product->shipping);
        $this->setMerchantCategory($product->merchantCategory);
        $this->setMerchantProductId($product->merchantProductId);
        $this->setProductShopName($productProgram->{'$'});
        $this->setProductShopId($productProgram->{'@id'});
        
        $trackingLink = $product->trackingLinks->trackingLink;
        
        $trackingLinks = new stdClass();
        $trackingLinks->Link = '';
        $trackingLinks->affiliateLink = '';
        $trackingLinks->affiliateLinkCart = '';
        
        if (! empty($trackingLink[0]->ppc)) {
            $affiliateLink = preg_replace('/\[/', '%5B', $trackingLink[0]->ppc);
            $affiliateLink = preg_replace('/\]/', '%5D', $affiliateLink);
            $trackingLinks->affiliateLink = $affiliateLink;
        }
        
        $this->setTrackingLinks($trackingLinks);
        
        /**
         * set images
         */
        
        $images = new stdClass();
        $otherImages = array();
        $firstImage = '';
        
        if (! empty($product->image->small)) {
            $firstImage = $product->image->small;
            array_push($otherImages, $product->image->small);
        }
        
        if (! empty($product->image->medium)) {
            $firstImage = $product->image->medium;
            array_push($otherImages, $product->image->medium);
        }
        
        if (! empty($product->image->large)) {
            $firstImage = $product->image->large;
            array_push($otherImages, $product->image->large);
        }
        
        $images->firstImage = $firstImage;
        
        if (is_array($otherImages) && count($otherImages) > 0) {
            $otherImages = array_values(array_diff($otherImages, array(
                $firstImage
            )));
            if (is_array($otherImages) && count($otherImages) > 0) {
                $images->otherImages = implode('|', $otherImages);
            }
        }
        $this->setImages($images);
    }

    private function setBelboonProduct($product)
    {
        $this->setProductId($product['belboon_productnumber']);
        
        $productPrices = new stdClass();
        $productPrices->price = (double) $product['currentprice'];
        $productPrices->uvp = (double) $product['oldprice'];
        $this->setProductPrices($productPrices);
        
        $this->setName($product['productname']);
        $this->setModified($product['lastupdate']);
        $this->setCurrency($product['currency']);
        $this->setProgram($product['feed_id']);
        $this->setDescription($product['productdescriptionshort']);
        $this->setDescriptionLong($product['productdescriptionlong']);
        $this->setManufacturer($product['brandname']);
        $this->setEan($product['ean']);
        $this->setDeliveryTime($product['availability']);
        $this->setTerms('');
        $this->setShippingCosts($product['shipping']);
        $this->setShipping('');
        $this->setMerchantCategory($product['productcategory']);
        $this->setMerchantProductId($product['productnumber']);
        $this->setProductShopName('k.A.');
        $this->setProductShopId(0);
        
        $trackingLinks = new stdClass();
        
        $trackingLinks->Link = '';
        $trackingLinks->affiliateLink = '';
        $trackingLinks->affiliateLinkCart = '';
        
        if (! empty($product['deeplinkurl'])) {
            $affiliateLink = preg_replace('/\[/', '%5B', $product['deeplinkurl']);
            $affiliateLink = preg_replace('/\]/', '%5D', $affiliateLink);
            $trackingLinks->affiliateLink = $affiliateLink;
        }
        if (! empty($product['basketurl'])) {
            $affiliateLinkCart = preg_replace('/\[/', '%5B', $product['basketurl']);
            $affiliateLinkCart = preg_replace('/\]/', '%5D', $affiliateLinkCart);
            $trackingLinks->affiliateLinkCart = $affiliateLinkCart;
        }
        //
        $this->setTrackingLinks($trackingLinks);
        
        /**
         * set images
         */
        $images = new stdClass();
        $firstImage = '';
        
        if (! empty($product['imagesmallurl'])) {
            $firstImage = $product['imagesmallurl'];
        }
        
        if (! empty($product['imagebigurl'])) {
            $firstImage = $product['imagebigurl'];
        }
        
        $images->firstImage = $firstImage;
        $images->otherImages = '';
        
        $this->setImages($images);
    }

    private function setAffilinetProduct($product)
    {
        $priceInformation = $product->PriceInformation;
        $priceDetails = $priceInformation->PriceDetails;
        
        $shippingDetails = $priceInformation->ShippingDetails;
        
        $this->setProductId($product->ProductId);
        $this->setName($product->ProductName);
        $this->setModified($product->LastShopUpdate);
        
        $productPrices = new stdClass();
        $productPrices->price = (double) $priceInformation->DisplayPrice;
        $productPrices->uvp = (double) $priceDetails->PriceOld;
        $this->setProductPrices($productPrices);
        
        $this->setCurrency($priceInformation->Currency);
        $this->setProgram($product->ProgramId);
        $this->setDescription($product->DescriptionShort);
        $this->setDescriptionLong($product->Description);
        $this->setManufacturer($product->Manufacturer);
        $this->setEan($product->EAN);
        $this->setDeliveryTime($product->DeliveryTime);
        $this->setTerms('');
        $this->setShippingCosts($shippingDetails->Shipping);
        $this->setShipping($shippingDetails->ShippingSuffix);
        $this->setMerchantCategory($product->ShopCategoryPath);
        $this->setMerchantProductId('');
        $this->setProductShopName($product->ShopTitle);
        $this->setProductShopId($product->ShopId);
        
        $trackingLinks = new stdClass();
        $trackingLinks->Link = '';
        $trackingLinks->affiliateLink = '';
        $trackingLinks->affiliateLinkCart = '';
        if (! empty($product->Deeplink1)) {
            $affiliateLink = preg_replace('/\[/', '%5B', $product->Deeplink1);
            $affiliateLink = preg_replace('/\]/', '%5D', $affiliateLink);
            $trackingLinks->affiliateLink = $affiliateLink;
        }
        if (! empty($product->Deeplink2)) {
            $affiliateLinkCart = preg_replace('/\[/', '%5B', $product->Deeplink2);
            $affiliateLinkCart = preg_replace('/\]/', '%5D', $affiliateLinkCart);
            $trackingLinks->affiliateLinkCart = $affiliateLinkCart;
        }
        //
        $this->setTrackingLinks($trackingLinks);
        
        /**
         * set images
         */
        $images = new stdClass();
        $firstImage = '';
        
        if ($productImage = $product->Images->ImageCollection->Image) {
            if (count($productImage) > 0) {
                if (isset($productImage->ImageScale) && $productImage->ImageScale == 'OriginalImage') {
                    $firstImage = $productImage->URL;
                }
            }
        }
        
        $images->firstImage = $firstImage;
        $images->otherImages = '';
        
        $this->setImages($images);
    }

    private function setTradedoublerProduct($product)
    {
        $offers = $product->offers;
        $offer = $offers->offer;
        
        $id = $offer->attributes()->id;
        $sourceProductId = $offer->attributes()->sourceProductId;
        $modifiedDate = $offer->attributes()->modifiedDate->__toString();
        
        $this->setProductId($id);
        $this->setName($product->name);
        $this->setModified(date('d.m.Y H:i:s', $modifiedDate / 1000));
        
        $priceHistory = $offer->priceHistory;
        $prices = $priceHistory->price;
        
        $currency = $prices->attributes()->currency;
        if (count($prices) > 1) {
            $priceOld = $prices[1];
            $price = $prices[0];
        } else {
            $priceOld = $prices[0];
            $price = $prices[0];
        }
        
        $productPrices = new stdClass();
        $productPrices->price = (double) $price;
        $productPrices->uvp = (double) $priceOld;
        $this->setProductPrices($productPrices);
        
        $this->setCurrency($currency);
        $this->setProgram($product->programName);
        $this->setDescription($product->shortDescription);
        $this->setDescriptionLong($product->description);
        $this->setManufacturer($product->brand);
        $this->setEan($product->ean);
        $this->setDeliveryTime($offer->availability);
        $this->setTerms('');
        $this->setShippingCosts($offer->shippingCost);
        $this->setShipping('');
        $this->setMerchantCategory('');
        $this->setMerchantProductId($sourceProductId);
        $this->setProductShopName($offer->programName);
        $this->setProductShopId(0);
        
        $trackingLinks = new stdClass();
        $trackingLinks->Link = '';
        $trackingLinks->affiliateLink = '';
        $trackingLinks->affiliateLinkCart = '';
        if (! empty($offer->productUrl)) {
            $affiliateLink = preg_replace('/\[/', '%5B', $offer->productUrl);
            $affiliateLink = preg_replace('/\]/', '%5D', $affiliateLink);
            $trackingLinks->affiliateLink = $affiliateLink;
        }
        
        //
        $this->setTrackingLinks($trackingLinks);
        
        /**
         * set images
         */
        $images = new stdClass();
        $firstImage = '';
        
        if (! empty($product->productImage)) {
            $firstImage = $product->productImage;
        }
        
        $images->firstImage = $firstImage;
        $images->otherImages = '';
        
        $this->setImages($images);
    }

    private function setEBayProduct($product)
    {
        $this->setProductId($product->itemId);
        $this->setName($product->title);
        $this->setModified(date('d.m.Y H:i:s', time()));
        
        $uvp = 0.00;
        if (isset($product->discountPriceInfo->originalRetailPrice) && $product->discountPriceInfo->originalRetailPrice > 0) {
            $uvp = $product->discountPriceInfo->originalRetailPrice;
        }
        
        $productPrices = new stdClass();
        $productPrices->price = (double) $product->sellingStatus->convertedCurrentPrice;
        $productPrices->uvp = $uvp;
        $this->setProductPrices($productPrices);
        
        $this->setCurrency('EUR');
        $this->setProgram('');
        $this->setDescription('eBay-Schnittstelle liefert aktuell keine Beschreibungstexte!!!');
        $this->setDescriptionLong('');
        $this->setManufacturer('');
        $this->setEan('');
        $this->setDeliveryTime('');
        $this->setTerms('');
        
        $this->setShippingCosts($product->shippingInfo->shippingServiceCost);
        $this->setShipping($product->shippingInfo->shippingType);
        $this->setMerchantCategory($product->primaryCategory->categoryName);
        $this->setMerchantProductId('');
        $this->setProductShopName($product->storeInfo->storeName);
        $this->setProductShopId(0);
        
        $trackingLinks = new stdClass();
        $trackingLinks->Link = '';
        $trackingLinks->affiliateLink = '';
        $trackingLinks->affiliateLinkCart = '';
        if (! empty($product->viewItemURL)) {
            $affiliateLink = preg_replace('/\[/', '%5B', $product->viewItemURL);
            $affiliateLink = preg_replace('/\]/', '%5D', $affiliateLink);
            $trackingLinks->affiliateLink = $affiliateLink;
        }
        $this->setTrackingLinks($trackingLinks);
        
        /**
         * set images
         */
        $large = $product->pictureURLSuperSize->__toString();
        $medium = $product->PictureURLLarge->__toString();
        
        $images = new stdClass();
        $otherImages = array();
        $firstImage = '';
        
        if (! empty($product->galleryURL)) {
            $firstImage = $product->galleryURL->__toString();
            array_push($otherImages, $product->galleryURL->__toString());
        }
        
        if (! empty($medium)) {
            $firstImage = $medium;
            array_push($otherImages, $medium);
        }
        
        if (! empty($large)) {
            $firstImage = $large;
            array_push($otherImages, $large);
        }
        
        $images->firstImage = $firstImage;
        
        if (is_array($otherImages) && count($otherImages) > 0) {
            $otherImages = array_values(array_diff($otherImages, array(
                $firstImage
            )));
            if (is_array($otherImages) && count($otherImages) > 0) {
                $images->otherImages = implode('|', $otherImages);
            }
        }
        $this->setImages($images);
    }

    private function setEBaySingleItem($product)
    {
        $ean = (isset($product->ReturnPolicy->EAN)) ? $product->ReturnPolicy->EAN : '';
        $description = (isset($product->Description)) ? $product->Description : '';
        $this->setProductId($product->ItemID);
        $this->setName($product->Title);
        $this->setModified(date('d.m.Y H:i:s', time()));
        
        $uvp = 0.00;
        if (isset($product->DiscountPriceInfo->OriginalRetailPrice) && $product->DiscountPriceInfo->OriginalRetailPrice > 0) {
            $uvp = $product->DiscountPriceInfo->OriginalRetailPrice;
        }
        
        $productPrices = new stdClass();
        $productPrices->price = (double) $product->ConvertedCurrentPrice;
        $productPrices->uvp = $uvp;
        $this->setProductPrices($productPrices);
        
        $this->setCurrency('EUR');
        $this->setProgram('');
        $this->setDescription($description);
        $this->setDescriptionLong('');
        $this->setManufacturer('');
        $this->setEan($ean);
        $this->setDeliveryTime('');
        $this->setTerms('');
        $this->setShippingCosts($product->ShippingCostSummary->ShippingServiceCost);
        $this->setShipping($product->ShippingCostSummary->ShippingType);
        $this->setMerchantCategory($product->PrimaryCategoryName);
        $this->setMerchantProductId('');
        $this->setProductShopName($product->Storefront->StoreName);
        $this->setProductShopId(0);
        
        $trackingLinks = new stdClass();
        $trackingLinks->Link = '';
        $trackingLinks->affiliateLink = '';
        $trackingLinks->affiliateLinkCart = '';
        if (! empty($product->ViewItemURLForNaturalSearch)) {
            $affiliateLink = preg_replace('/\[/', '%5B', $product->ViewItemURLForNaturalSearch);
            $affiliateLink = preg_replace('/\]/', '%5D', $affiliateLink);
            $trackingLinks->affiliateLink = $affiliateLink;
        }
        
        //
        $this->setTrackingLinks($trackingLinks);
        
        /**
         * set images
         */
        $images = new stdClass();
        
        $images->firstImage = $product->PictureURL->__toString();
        $images->otherImages = '';
        
        $this->setImages($images);
    }

    private function setAmazonProduct($product)
    {
        $country = get_option('ap_currency');
        $associate_tag = get_option('amazon_partner_id');
        
        $desc = '';
        if (isset($product->EditorialReviews->EditorialReview->Content)) {
            $desc = (string) $product->EditorialReviews->EditorialReview->Content;
        }
        
        $eans = $product->ItemAttributes->EANList->EANListElement;
        $ean = '';
        for ($j = 0; $j < count($eans); $j ++) {
            if ($j === 0) {
                $ean .= $eans[$j];
            } else {
                $ean .= ',' . $eans[$j];
            }
        }
        
        $asin = $product->ASIN->__toString();
        
        $price = $product->Offers->Offer->OfferListing->Price->Amount / 100;
        $lowestUsedPrice = $product->OfferSummary->LowestUsedPrice->Amount / 100;
        $lowestNewPrice = $product->OfferSummary->LowestNewPrice->Amount / 100;
        
        $listPrice = $product->ItemAttributes->ListPrice->Amount / 100;
        
        $productPrices = new stdClass();
        $productPrices->price = $price;
        $productPrices->lowest_used = $lowestUsedPrice;
        $productPrices->lowest_new = $lowestNewPrice;
        $productPrices->uvp = $listPrice;
        $this->setProductPrices($productPrices);
        
        $this->setProductId($asin);
        $this->setName($product->ItemAttributes->Title->__toString());
        $this->setEan($ean);
        $this->setDescriptionLong($desc);
        $this->setDescription($desc);
        $this->setManufacturer($product->ItemAttributes->Brand);
        $this->setCurrency('EUR');
        $this->setProgram('');
        $this->setTerms('');
        $this->setProductShopName('Amazon');
        $this->setProductShopId(0);
        
        $this->setModified($product->LastShopUpdate);
        $this->setDeliveryTime('');
        $this->setShippingCosts('');
        $this->setShipping('');
        $this->setMerchantCategory('');
        $this->setMerchantProductId('');
        
        $trackingLinks = new stdClass();
        $trackingLinks->Link = $product->DetailPageURL->__toString();
        $trackingLinks->affiliateLink = "http://www.amazon.$country/dp/$asin/?tag=$associate_tag";
        $trackingLinks->affiliateLinkCart = "http://www.amazon.$country/gp/aws/cart/add.html?AssociateTag=$associate_tag&ASIN.1=$asin&Quantity.1=1";
        $this->setTrackingLinks($trackingLinks);
        
        /**
         * set images
         */
        
        if (isset($product->LargeImage->URL)) {
            $lgeimg = $product->LargeImage->URL->__toString();
        } else {
            $lgeimg = '';
        }
        
        $images = new stdClass();
        $images->firstImage = $lgeimg;
        
        $largeImages = array();
        if (isset($product->ImageSets) && count($product->ImageSets) > 0) {
            foreach ($product->ImageSets as $imageSet) {
                if (count($imageSet) > 0) {
                    foreach ($imageSet as $imageElem) {
                        $largeImg = $imageElem->LargeImage->URL->__toString();
                        if ($lgeimg != $largeImg) {
                            array_push($largeImages, $largeImg);
                        }
                    }
                }
            }
        }
        
        if (is_array($largeImages) && count($largeImages) > 0) {
            $images->otherImages = implode('|', $largeImages);
        }
        
        $this->setImages($images);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getModified()
    {
        return $this->modified;
    }

    public function getProgram()
    {
        return $this->program;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getTrackingLinks()
    {
        return $this->trackingLinks;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDescriptionLong()
    {
        return $this->descriptionLong;
    }

    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    public function getEan()
    {
        return $this->ean;
    }

    public function getDeliveryTime()
    {
        return $this->deliveryTime;
    }

    public function getTerms()
    {
        return $this->terms;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function getShippingCosts()
    {
        return $this->shippingCosts;
    }

    public function getShipping()
    {
        return $this->shipping;
    }

    public function getMerchantCategory()
    {
        return $this->merchantCategory;
    }

    public function getMerchantProductId()
    {
        return $this->merchantProductId;
    }

    public function getProductShopName()
    {
        return $this->productShopName;
    }

    public function getProductShopId()
    {
        return $this->productShopId;
    }

    public function getProductPrices()
    {
        return $this->productPrices;
    }

    public function getStarRating()
    {
        return $this->starRating;
    }
    
    public function getCustomerReviews()
    {
        return $this->customerReviews;
    }

    private function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    private function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    private function setModified($modified)
    {
        $this->modified = $modified;
        return $this;
    }

    private function setProgram($program)
    {
        $this->program = $program;
        return $this;
    }

    private function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    private function setTrackingLinks(stdClass $trackingLinks)
    {
        $this->trackingLinks = $trackingLinks;
        return $this;
    }

    private function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    private function setDescriptionLong($descriptionLong)
    {
        $this->descriptionLong = $descriptionLong;
        return $this;
    }

    private function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    private function setEan($ean)
    {
        $this->ean = ($ean != "") ? $ean : 0;
        return $this;
    }

    private function setDeliveryTime($deliveryTime)
    {
        $this->deliveryTime = $deliveryTime;
        return $this;
    }

    private function setTerms($terms)
    {
        $this->terms = $terms;
        return $this;
    }

    private function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    private function setImages(stdClass $images)
    {
        $this->images = $images;
        return $this;
    }

    private function setShippingCosts($shippingCosts)
    {
        $this->shippingCosts = $shippingCosts;
        return $this;
    }

    private function setShipping($shipping)
    {
        $this->shipping = $shipping;
        return $this;
    }

    private function setMerchantCategory($merchantCategory)
    {
        $this->merchantCategory = $merchantCategory;
        return $this;
    }

    private function setMerchantProductId($merchantProductId)
    {
        $this->merchantProductId = $merchantProductId;
        return $this;
    }

    public function setProductShopName($productShopName)
    {
        $this->productShopName = $productShopName;
        return $this;
    }

    public function setProductShopId($productShopId)
    {
        $this->productShopId = $productShopId;
        return $this;
    }

    private function setProductPrices(stdClass $productPrices)
    {
        $this->productPrices = $productPrices;
        return $this;
    }

    public function setStarRating($starRating)
    {
        $this->starRating = $starRating;
        return $this;
    }

    public function setCustomerReviews($customerReviews)
    {
        $this->customerReviews = $customerReviews;
        return $this;
    }
}