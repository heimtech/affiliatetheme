<?php

class Affilinet
{

    private $sessionToken;

    private $soapClient;

    private $soapLogonClient;

    private $publisherId;

    function __construct($publisherId, $publisherPassword, $productPassword, $logonWsdl, $productsWsdl)
    {
        $this->soapLogonClient = new SoapClient($logonWsdl);
        $this->sessionToken = $this->soapLogonClient->Logon(array(
            'Username' => $publisherId,
            'Password' => $productPassword,
            'WebServiceType' => 'Product'
        ));
        
        $this->publisherId = $publisherId;
        
        $this->soapClient = new SoapClient($productsWsdl);
    }

    public function getShopList($params = array())
    {
        $params['CredentialToken'] = $this->sessionToken;
        $params['PublisherId'] = $this->publisherId;
        
        return $this->soapClient->GetShopList($params);
    }

    public function getProductData()
    {}

    public function searchProducts($params)
    {
        try {
            $params['CredentialToken'] = $this->sessionToken;
            $params['PublisherId'] = $this->publisherId;
            
            return $this->soapClient->SearchProducts($params);
        } catch (SoapFault $e) {
            $ret = "Request:\n" . ($this->soapClient->__getLastRequest()) . "\n";
            $ret .= "Response:\n" . ($this->soapClient->__getLastResponseHeaders()) . "\n";
            $ret .= "Response:\n" . ($this->soapClient->__getLastResponse()) . "\n";
            $ret .= '<div id="message" class="error"><p><strong>Fehler!</strong> Login fehlgeschlagen. Übersprüfen Sie Ihre Einstellungen!</p></div>';
            
            return $ret;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getProductsByIds($params)
    {
        $params['CredentialToken'] = $this->sessionToken;
        $params['PublisherId'] = $this->publisherId;
        $params['ImageScales'] = array(
            'OriginalImage'
        );
        
        return $this->soapClient->GetProducts($params);
    }

    public function searchProductsByEan()
    {}
}
