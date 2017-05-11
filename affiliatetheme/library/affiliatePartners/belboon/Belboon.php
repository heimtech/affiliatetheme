<?php

class Belboon
{

    private $oSmartFeed = null;

    /**
     *
     * @var String Session Hash, der als Identifikation für weitere Aufrufe der Sessions
     *      in den nachfolgenden Aufrufen verwendet wird
     */
    private $oSessionHash = null;

    private $sSessionHash = null;

    function __construct($username, $password, $belboonWsdl)
    {
        $this->oSmartFeed = new SoapClient($belboonWsdl);
        
        $this->login($username, $password);
    }

    /**
     *
     * Liefert einen Session Hash Wert [String()]zurück, der 30Minuten gültig ist,
     * wobei der Ablauf der 30 Minuten mit jeder neuen Aktion / Abfrage neu beginnt.
     * Bei den einzelnen Abfragen ist dieser Session Hash als Authentifizierung mitzuliefern.
     *
     * @param String $username
     *            Username / Login
     * @param String $password
     *            Passwort für Webservices
     */
    private function login($username, $password)
    {
        $this->oSessionHash = $this->oSmartFeed->login($username, $password);
        if (! $this->oSessionHash->HasError) {
            $this->sSessionHash = $this->oSessionHash->Records['sessionHash'];
        }
    }

    /**
     *
     * getFeeds (SessionHash, [config])
     * Liefert eine Liste (Array) aller Produktdatenwerbemittel der Programme,
     * mit denen eine Partnerschaft besteht, ggf. eingeschränkt durch Filter.
     *
     * @param Array $config
     *            Config Array, optional
     *            
     *            key: offset type: Integer default: 0
     *            Listet Suchergebnisse erst ab diesem Wert
     *            
     *            key: limit type: Integer default: Null
     *            Begrenzt die Anzahl der Ergebnisse auf diesen max-Wert
     *            
     *            key: platforms type: Integer[] default: (Array)
     *            Begrenzt die Auswahl der Feeds auf die Programme,
     *            die mit der angegebenen Plattform eine Partnerschaft haben
     *            
     *            key: sort type: String[] default: (Array) array(„belboon_productnumber" => „ASC")
     *            Sortiert die Rückgabe von Produktdaten (bei Produktsuche oder Rückgabe eines Feeds)
     *            nach dem übergebenen Spaltennamen mit gewünschter Orientierung (ASC = aufsteigend, DESC= absteigend)
     *            
     *            
     *            ### Response-Parameter ###
     *            
     *            id # Integer # Werbemittel-ID des Produktdatenfeeds
     *            name # String # Name des Werbemittels
     *            product_count # Integer # Anzahl der Produkte
     *            last_update # String (YYYY-MM-DD HH:mm:ss) # Letzte Aktualisierung
     *            program_name # String # Name des Partnerprogramms
     *            url # String # Shop URL
     *            logo_url # String # URL zum Shoplogo
     */
    public function getFeeds($config = array())
    {
        if (! $this->oSessionHash->HasError) {
            
            return $this->oSmartFeed->getFeeds($this->sSessionHash, $config);
        }
    }

    /**
     *
     * getFeedUpdate (SessionHash, FeedId)
     * Liefert den Zeitpunkt des letzten Updates eines Feeds durch den Merchant.
     *
     * @param Integer $FeedId
     *            FeedId des Datensatzes, dessen letztes Update geliefert werden soll.
     *            
     * @return Date last_update # Date # Letztes Update durch den Merchant
     */
    public function getFeedUpdate($FeedId)
    {
        if (! $this->oSessionHash->HasError) {
            
            return $this->oSmartFeed->getFeedUpdateDate($this->sSessionHash, $FeedId);
        }
    }

    /**
     *
     * getPlatforms (SessionHash)
     * Liefert eine Liste (Array) aller Werbeplattformen des eigenen Accounts.
     *
     * @return Array id # Integer # Werbeplattform-ID
     *         name # String # Name der Werbeplattform
     */
    public function getPlatforms()
    {
        if (! $this->oSessionHash->HasError) {
            
            return $this->oSmartFeed->getPlatforms($this->sSessionHash);
        }
    }

    /**
     * getProductData (SessionHash, [config])
     * Liefert eine Liste (Array) aller Produktdaten, ggf.
     * eingeschränkt durch Filter.
     *
     * @param Array $config
     *            Config Array, optional
     *            ### Config-Array ###
     *            platforms # Integer[] (Array) # Null
     *            Schränkt Ergebnisse auf Partnerschaften dieser Werbeplattform-IDs ein
     *            
     *            feeds # Integer[] (Array) # Null
     *            Schränkt Ergebnisse auf Produkte der Feeds mit diesen Ids ein
     *            
     *            offset # Integer # 0
     *            Listet Suchergebnisse erst ab diesem Wert
     *            
     *            limit # Integer # Null
     *            Begrenzt Suchergebnisse auf max-Wert
     *            
     *            updated_after # Date # 1970-0-0
     *            Liefert Datensätze, die nach dem angegeben Datum aktualisiert wurden
     *            
     *            sort # String[] # (Array) array(„belboon_productnumber" => „ASC")
     *            Sortiert die Rückgabe von Produktdaten (bei Produktsuche oder Rückgabe eines Feeds) nach dem
     *            übergebenen Spaltennamen mit gewünschter Orientierung (ASC = aufsteigend, DESC= absteigend)
     *            
     *            categories # Integer[] (Array) # Null
     *            Schränkt die Ergebnisse auf Kategorien mit den übergebenen Kategorie-IDs ein. *nicht alle
     *            vorhandenen Produktdaten sind einer belboon-Kategorie zugeordnet
     *            
     *            with_subcategories # Boolean # True
     *            Berücksichtigt beim Kategorie-Filter auch die Unterkategorien. Standardmäßig aktiviert (=TRUE).
     *            
     * @return Array productData
     *        
     *         ### Response-Parameter ###
     *         feed_id # Integer # ID des Produktdaten-Feeds
     *         belboon_productnumber # String # belboon Produkt-ID
     *         belboon_programid # String # Programm-ID
     *         productnumber # String # Produktnummer des Merchants
     *         ean # String # EAN-Code
     *         productname # String # Name des Produkts
     *         manufacturername # String # Hersteller des Produkts
     *         brandname # String # Marke des Produkts
     *         currentprice # String # Preis
     *         oldprice # String # Alter Preis
     *         currency # String # Währung
     *         validfrom # String # Beginn der Gültigkeit des Angebotes
     *         validuntil # String # Ende der Gültigkeit des Angebotes
     *         deeplinkurl # String # URL zum Produkt
     *         basketurl # String # URL zum Ablegen des Produkts im Warenkorb
     *         imagesmallurl # String # URL zum "kleinen" Produktbild
     *         imagesmallheight # Integer # Höhe des "kleinen" Produktbildes
     *         imagesmallwidth # Integer # Breite des "kleinen" Produktbildes
     *         imagebigurl # String # URL zum "großen" Produktbild
     *         imagebigheight # Integer # Höhe des "großen" Produktbildes
     *         imagebigwidth # Integer # Breite des "großen" Produktbildes
     *         productcategory # String # Produktkategorie des Merchants
     *         belboonproductcategory # String # belboon- Produktkategorie
     *         productkeywords # String # Keywords
     *         productdescriptionshort # String # Kurzbeschreibung des Produkts
     *         productdescriptionlong # String # ausführliche Beschreibung des Produkts
     *         Lastupdate # String # Letztes Update des Produkts (durch Merchant angegeben)
     *         shipping # String # Versandkosten des Produkts
     *         availability # String # Verfügbarkeit des Produkts
     *         option1 # String # Optionales Feld / Zusatzinformationen
     *         option2 # String # Optionales Feld / Zusatzinformationen
     *         option3 # String # Optionales Feld / Zusatzinformationen
     *         option4 # String # Optionales Feld / Zusatzinformationen
     *         option5 # String # Optionales Feld / Zusatzinformationen
     */
    public function getProductData($config = array('limit'=>10, 'offset'=>0))
    {
        if (! $this->oSessionHash->HasError) {
            
            return $this->oSmartFeed->getProductData($this->sSessionHash, $config);
        }
    }

    /**
     *
     * searchProducts (SessionHash, Query, [config])
     * Liefert eine Liste (Array) von Produktdaten, die auf den Suchbegriff und den config Filter zutreffen
     *
     * @param String $query
     *            Suchbegriff
     * @param Array $config
     *            Config Array, optional
     *            
     *            ### Config-Array ###
     *            platforms # Integer[] (Array) # Null
     *            Schränkt Ergebnisse auf Partnerschaften dieser Werbeplattform-ID ein
     *            
     *            feeds # Integer[] (Array) # Null
     *            Schränkt Ergebnisse auf Produkte der Feeds mit diesen Ids ein
     *            
     *            offset # Integer # 0
     *            Listet Suchergebnisse erst ab diesem Wert
     *            
     *            limit # Integer # Null
     *            Begrenzt Suchergebnisse auf max-Wert
     *            
     *            updated_after # Date # 1970-0-0
     *            Liefert Datensätze, die nach dem angegeben Datum aktualisiert wurden
     *            
     *            sort # String[] # (Array) array(„belboon_productnumber" => „ASC")
     *            Sortiert die Rückgabe von Produktdaten (bei Produktsuche oder Rückgabe eines Feeds) nach dem
     *            übergebenen Spaltennamen mit gewünschter Orientierung (ASC = aufsteigend, DESC= absteigend)
     *            
     *            price_min # float # 0.00
     *            untere Preisgrenze
     *            
     *            price_max # float # 999999.99
     *            obere Preisgrenze
     *            
     *            categories # Integer[] (Array) # Null
     *            Schränkt die Ergebnisse auf Kategorien mit den übergebenen Kategorie-IDs ein. *nicht alle vorhandenen
     *            Produktdaten sind einer belboon-Kategorie zugeordnet
     *            
     *            with_subcategories # Boolean # True
     *            Berücksichtigt beim Kategorie-Filter auch die Unterkategorien. Standardmäßig aktiviert (=TRUE).
     *            
     *            
     * @return Array productData
     *        
     *         ### Response-Parameter ###
     *         feed_id # Integer # ID des Produktdaten-Feeds
     *         belboon_productnumber # String # belboon Produkt-ID
     *         belboon_programid # String # Programm-ID
     *         productnumber # String # Produktnummer des Merchants
     *         ean # String # EAN-Code
     *         productname # String # Name des Produkts
     *         manufacturername # String # Hersteller des Produkts
     *         brandname # String # Marke des Produkts
     *         currentprice # String # Preis
     *         oldprice # String # Alter Preis
     *         currency # String # Währung
     *         validfrom # String # Beginn der Gültigkeit des Angebotes
     *         validuntil # String # Ende der Gültigkeit des Angebotes
     *         deeplinkurl # String # URL zum Produkt
     *         basketurl # String # URL zum Ablegen des Produkts im Warenkorb
     *         imagesmallurl # String # URL zum "kleinen" Produktbild
     *         imagesmallheight # Integer # Höhe des "kleinen" Produktbildes
     *         imagesmallwidth # Integer # Breite des "kleinen" Produktbildes
     *         imagebigurl # String # URL zum "großen" Produktbild
     *         imagebigheighti # Integer # Höhe des "großen" Produktbildes
     *         imagebigwidth # Integer # Breite des "großen" Produktbildes
     *         productcategory # String # Produktkategorie des Merchants
     *         belboonproductcategory # String # belboon-Kategorie
     *         productkeywords # String # Keywords
     *         productdescriptionshort # String # Kurzbeschreibung des Produkts
     *         productdescriptionlong # String # ausführliche Beschreibung des Produkts
     *         lastupdate # String # Letztes Update des Produkts (durch Merchant angegeben)
     *         shipping # String # Versandkosten des Produkts
     *         availability # String # Verfügbarkeit des Produkts
     *         option1 # String # Optionales Feld / Zusatzinformationen
     *         option2 # String # Optionales Feld / Zusatzinformationen
     *         option3 # String # Optionales Feld / Zusatzinformationen
     *         option4 # String # Optionales Feld / Zusatzinformationen
     *         option5 # String # Optionales Feld / Zusatzinformationen
     *        
     */
    public function searchProducts($query, $config = array())
    {
        if (! $this->oSessionHash->HasError) {
            
            return $this->oSmartFeed->searchProducts($this->sSessionHash, urlencode($query), $config);
        }
    }

    /**
     * getProductById (SessionHash,productId)
     * Liefert eine die Daten eines Produkts mit der Abgefragten belboon-Produkt-ID zuück.
     *
     * @param String $productId
     *            belboon-Produktnummer
     *            
     * @return Array productData
     *        
     *         ### Response-Parameter ###
     *         feed_id # Integer # ID des Produktdaten-Feeds
     *         belboon_productnumber # String # belboon Produkt-ID
     *         belboon_programid # String # Programm-ID
     *         productnumber # String # Produktnummer des Merchants
     *         ean # String # EAN-Code
     *         productname # String # Name des Produkts
     *         manufacturername # String # Hersteller des Produkts
     *         brandname # String # Marke des Produkts
     *         currentprice # String # Preis
     *         oldprice # String # Alter Preis
     *         currency # String # Währung
     *         validfrom # String # Beginn der Gültigkeit des Angebotes
     *         validuntil # String # Ende der Gültigkeit des Angebotes
     *         deeplinkurl # String # URL zum Produkt
     *         basketurl # String # URL zum Ablegen des Produkts im Warenkorb
     *         imagesmallurl # String # URL zum "kleinen" Produktbild
     *         imagesmallheight # Integer # Höhe des "kleinen" Produktbildes
     *         imagesmallwidth # Integer # Breite des "kleinen" Produktbildes
     *         imagebigurl # String # URL zum "großen" Produktbild
     *         imagebigheighti # Integer # Höhe des "großen" Produktbildes
     *         imagebigwidth # Integer # Breite des "großen" Produktbildes
     *         productcategory # String # Produktkategorie des Merchants
     *         belboonproductcategory # String # belboon-Kategorie
     *         productkeywords # String # Keywords
     *         productdescriptionshort # String # Kurzbeschreibung des Produkts
     *         productdescriptionlong # String # ausführliche Beschreibung des Produkts
     *         lastupdate # String # Letztes Update des Produkts (durch Merchant angegeben)
     *         shipping # String # Versandkosten des Produkts
     *         availability # String # Verfügbarkeit des Produkts
     *         option1 # String # Optionales Feld / Zusatzinformationen
     *         option2 # String # Optionales Feld / Zusatzinformationen
     *         option3 # String # Optionales Feld / Zusatzinformationen
     *         option4 # String # Optionales Feld / Zusatzinformationen
     *         option5 # String # Optionales Feld / Zusatzinformationen
     *        
     */
    public function getProductById($productId)
    {
        if (! $this->oSessionHash->HasError) {
            
            return $this->oSmartFeed->getProductById($this->sSessionHash, $productId);
        }
    }

    /**
     *
     * searchProductsByEan (SessionHash, EAN, [config])
     * Liefert eine Liste (Array) von Produktdaten, die auf die übergebene EAN
     * und den config Filter zutreffen. Request- und Result-Objekt entsprechen
     * denen von searchProducts().
     *
     * @param String $ean
     *            EAN-Nummer (nicht immer in den Produktdaten vorhanden)
     *            
     * @param array $config
     *            Config Array, optional
     *            
     * @return array products
     *         Config-Array und Response-Parameter analog zu
     *         searchProducts (SessionHash, Query, [config]).
     */
    public function searchProductsByEan($ean, $config = array())
    {
        if (! $this->oSessionHash->HasError) {
            
            return $this->oSmartFeed->searchProductsByEan($this->sSessionHash, $ean, $config);
        }
    }

    /**
     *
     * getCategory($sSessionHash, $iCategoryId)
     * Liefert anhand einer ID eine Produktdaten-Kategorie als Array.
     *
     * @param Integer $categoryId
     *            Kategorie-ID
     *            
     * @return array categoryData
     *        
     *         id # Integer # Kategorie-ID
     *         parent_id # Integer # ID der Eltern-Kategorie
     *         name # String # Name der Kategorie
     *        
     */
    public function getCategory($categoryId)
    {
        if (! $this->oSessionHash->HasError) {
            
            return $this->oSmartFeed->getCategory($this->sSessionHash, $categoryId);
        }
    }

    /**
     *
     * getCategories($sSessionHash, $aConfig)
     * Liefert ein Array mit den Kategorien der Produktdaten, die auf die Einschränkungen des Config-Arrays zutreffen.
     *
     * @param array $config
     *            Config Array, optional
     *            
     *            offset # Integer # 0 # Listet Suchergebnisse erst ab diesem Wert
     *            limit # Integer # Null # Begrenzt Suchergebnisse auf max-Wert
     *            parent_id # Integer # Null # Liefert nur die Kategorien mit der übergebenen parent_id
     *            
     * @return array categoryData
     *        
     *         id # Integer # Kategorie-ID
     *         parent_id # Integer # ID der Eltern-Kategorie
     *         name # String # Name der Kategorie
     *        
     */
    public function getCategories($config = array())
    {
        if (! $this->oSessionHash->HasError) {
            
            return $this->oSmartFeed->getCategories($this->sSessionHash, $config);
        }
    }

    /**
     * Beendet die aktuelle Session.
     */
    public function logout()
    {
        if (! $this->oSessionHash->HasError) {
            
            $this->oSmartFeed->logout($this->sSessionHash);
        }
    }
}
