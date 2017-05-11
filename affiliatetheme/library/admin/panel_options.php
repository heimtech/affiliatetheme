<?php
$options = array(
    array(
        "name" => "Theme aktivieren",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => "Lizenzcode",
        "desc" => "Bitte geben Sie hier Ihren Lizenzcode ein.",
        "id" => "activate_apikey",
        "type" => "text",
        "std" => ""
    ),
    array(
        "type" => "close"
    ),
    array(
        "name" => "Allgemeine Einstellungen",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => "Google Analytics Code",
        "desc" => "Bitte hier den Google Analytics Code angeben, mit Script-Tags.",
        "id" => "allg_google_analytics",
        "type" => "textarea",
        "std" => ""
    ),
    array(
        "name" => "Automatische Erstellung / Überprüfung der Produktfilter und Cloaking Seite deaktivieren?",
        "desc" => 'Soll die automatische Erstellung / Überprüfung der Produktfilter und Cloaking Seite deaktiviert werden?',
        "id" => "filter_cloaking_page",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "PageSpeed-Optimierung in .htaccess",
        "desc" => "Wenn Sie diese Option aktivieren, werden <strong style='color:#e74c3c;'>Änderungen in der .htaccess</strong> vorgenommen.",
        "id" => "activate_pagespeed",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "PageSpeed-Optimierung der Skripte und Styles",
        "desc" => "Optimiert die Ladegeschwindigkeit durch das spätere Laden der Skripte und Styles. Ist diese Option aktiviert, " . "wird erst ungestyltes HTML angezeigt " . "und erst nach dem Laden der gesamten Seite werden Skripte und Styles nachgeladen. " . "Dadurch ist die Bedienbarkeit auf mobilen Endgeräten und bei langsamen Internetverbindungen " . "gewährleistet.",
        "id" => "activate_pagespeed_scripts",
        "type" => "checkbox",
        "std" => "1"
    ),
    array(
        "name" => "Theme-internen Cronjob deaktivieren?",
        "desc" => 'Wenn Sie den Cronjob zur Aktualisierung Ihrer Preise nicht nutzen können oder wollen, steht Ihnen eine Alternative in Form ".
            "des theme-internen Cronjobs ' . 'zur Verfügung, der bei jedem Seitenaufruf ein Produkt aktualisiert. Wenn Sie diese Option aktivieren, ".
            "wird dieser theme-interne Cronjob nicht mehr ausgeführt.',
        "id" => "deactivate_cronjobfake",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "404-Weiterleitung",
        "desc" => 'Sollen die 404-Steiten (nicht gefundene Seiten) auf die Startseite weitergeleitet werden?',
        "id" => "redirect_404",
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        "type" => "close"
    ),
    
    array(
        'name' => 'Affiliatelinks verstecken (Cloaking)',
        'type' => 'title'
    ),
    array(
        'type' => 'open'
    ),
    array(
        'name' => 'Affiliatelinks verstecken?',
        'desc' => 'Affiliatelinks durch "Cloaking" verstecken? (Plugins, die Permalinks manipulieren, können beim Cloaking zu Problemen führen. ".
            "Sollte dies der Fall sein, kontaktieren ' . 'Sie den Entwickler des jeweiligen Plugins.)',
        'id' => 'activate_cloaking',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        'name' => 'Weiterleitung',
        'desc' => 'Wie lange soll es dauern, bis der Besucher weitergeleitet wird? (Standard sind 4 Sekunden.)',
        'id' => 'cloaking_duration',
        'type' => 'text',
        'std' => '4'
    ),
    array(
        'type' => 'close'
    ),
    
    array(
        "name" => "Layout Manager",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => "Suchformular ausblenden?",
        "desc" => "Soll das Suchformular ausgeblendet werden?",
        "id" => "allg_suchformular_ausblenden",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Suche in Navbar ausblenden?",
        "desc" => "Soll das Suchformular in der Navigation ausgeblendet werden?",
        "id" => "hide_navbar_search_field",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Suchformular oberes Menü ausblenden?",
        "desc" => "Soll das Suchformular im oberen Menü ausgeblendet werden?",
        "id" => "hide_searchform",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Sidebar: Suchergebnisse",
        "desc" => "Wo soll die Sidebar auf der Seite mit den Suchergebnissen angezeigt werden?",
        "id" => "layout_sidebar_search",
        "type" => "select",
        "options" => array(
            array(
                "value" => "none",
                "text" => "Nicht anzeigen"
            ),
            array(
                "value" => "links",
                "text" => "Links"
            ),
            array(
                "value" => "rechts",
                "text" => "Rechts"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Slider auf der Startseite anzeigen?",
        "desc" => "Soll der Slider auf der Startseite angezeigt werden? Die Slides kannst du im Menü unter \"Slideshow\" bearbeiten.",
        "id" => "allg_slider_einblenden",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Seitenrahmen anzeigen?",
        "desc" => "Soll um den 'Wrapper' Ihrer Seite ein Rahmen mit wählbaren Optionen gezogen werden?",
        "id" => "layout_wrapper_background",
        "type" => "checkbox",
        "std" => "1"
    ),
    array(
        'name' => 'Header inkl. unterem Menü auf gesamte Breite',
        'desc' => 'Die Option greift nur, wenn der Seitenrahmen nicht angezeigt wird.' . '<br /><a href="http://affiliseo.de/header-und-menue-auf-gesamte-breite/" target="_blank" class="link-affiliseo">' . '<i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Anleitung auf AffiliSEO.de</a>',
        'id' => 'full_size_header',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        "name" => "Boxenlayout?",
        "desc" => "Wie sollen die einzelnen Elemente umrahmt werden?",
        "id" => "layout_wrapper_boxes",
        "type" => "select",
        "options" => array(
            array(
                "value" => "bottom",
                "text" => "nur unten"
            ),
            array(
                "value" => "none",
                "text" => "keine Rahmen"
            ),
            array(
                "value" => "all",
                "text" => "komplett"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Überschrift Produktansicht",
        "desc" => "Soll ein Rahmen um die Produktansicht bei gesetzter Überschrift gezogen werden?",
        "id" => "layout_wrapper_headline",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        'name' => 'Menü fixieren ausschalten',
        'desc' => 'Fixiertes Menü beim Scrollen ausschalten?' . '<br /><a href="http://affiliseo.de/menue-fixieren/" target="_blank" class="link-affiliseo">' . '<i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Anleitung auf AffiliSEO.de</a>',
        'id' => 'fixed_menu',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        'name' => 'Überschrift auf Seiten ausblenden',
        'desc' => 'Sollen die Überschriften auf Seiten ausgeblendet werden?',
        'id' => 'hide_headline_page',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        'name' => 'Überschrift in Blogbeitrag ausblenden',
        'desc' => 'Sollen die Überschriften in Blogbeiträgen ausgeblendet werden?',
        'id' => 'hide_headline_blog',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        'name' => 'Überschrift in Produkten ausblenden',
        'desc' => 'Sollen die Überschriften in Produkten ausgeblendet werden?',
        'id' => 'hide_headline_product',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        "name" => "Welche Überschrift soll auf Seiten angezeigt werden?",
        "desc" => "",
        "id" => "headline_tag_page",
        "type" => "select",
        "options" => array(
            array(
                "value" => "h1",
                "text" => "h1"
            ),
            array(
                "value" => "h2",
                "text" => "h2"
            ),
            array(
                "value" => "h3",
                "text" => "h3"
            ),
            array(
                "value" => "h4",
                "text" => "h4"
            ),
            array(
                "value" => "h5",
                "text" => "h5"
            ),
            array(
                "value" => "h6",
                "text" => "h6"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Welche Überschrift soll in Blogbeiträgen angezeigt werden?",
        "desc" => "",
        "id" => "headline_tag_blog",
        "type" => "select",
        "options" => array(
            array(
                "value" => "h1",
                "text" => "h1"
            ),
            array(
                "value" => "h2",
                "text" => "h2"
            ),
            array(
                "value" => "h3",
                "text" => "h3"
            ),
            array(
                "value" => "h4",
                "text" => "h4"
            ),
            array(
                "value" => "h5",
                "text" => "h5"
            ),
            array(
                "value" => "h6",
                "text" => "h6"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Welche Überschrift soll in Produkten angezeigt werden?",
        "desc" => "",
        "id" => "headline_tag_product",
        "type" => "select",
        "options" => array(
            array(
                "value" => "h1",
                "text" => "h1"
            ),
            array(
                "value" => "h2",
                "text" => "h2"
            ),
            array(
                "value" => "h3",
                "text" => "h3"
            ),
            array(
                "value" => "h4",
                "text" => "h4"
            ),
            array(
                "value" => "h5",
                "text" => "h5"
            ),
            array(
                "value" => "h6",
                "text" => "h6"
            )
        ),
        "std" => ""
    ),
    array(
        'name' => 'Brotkrumennavigation ausblenden',
        'desc' => 'Soll die Brotkrumennavigation ausgeblendet werden?',
        'id' => 'hide_breadcrumb',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        "name" => "Eigenes CSS",
        "desc" => "Wenn Sie eigene Stylesheets verwenden wollen, tragen Sie diese bitte hier ein.",
        "id" => "custom_css",
        "type" => "textarea",
        "std" => ""
    ),
    array(
        "type" => "close"
    ),
    array(
        "name" => "Produktfilter-Ergebnisseite",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => "Sidebar: Produktfilter-Ergebnisseite",
        "desc" => "Wo soll sich die Sidebar auf der Ergebnisseite des Produktfilter-Widgets befinden?",
        "id" => "product_filter_sidebar",
        "type" => "select",
        "options" => array(
            array(
                "value" => "none",
                "text" => "keine Sidebar"
            ),
            array(
                "value" => "left",
                "text" => "links"
            ),
            array(
                "value" => "right",
                "text" => "rechts"
            )
        ),
        "std" => ""
    ),
    array(
        "type" => "close"
    ),
    array(
        "name" => "Produkte",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => "Preise ausblenden?",
        "desc" => "Sollen bei sämtlichen Darstellungen die Preise versteckt werden?",
        "id" => "allg_preise_ausblenden",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Währung",
        "desc" => "Wo soll die Währung stehen?",
        "id" => "pos_currency",
        "type" => "select",
        "options" => array(
            array(
                "value" => "before",
                "text" => "vor Preis"
            ),
            array(
                "value" => "after",
                "text" => "nach Preis"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Produktbild auf den Shop verlinken?",
        "desc" => "Sollen die Produktbilder in der Übersicht direkt auf den Shop verlinken?" . "<p style='color:#e74c3c;'><strong>HINWEIS</strong><br />Die direkte Verlinkung des Produktbildes " . "auf den Shop ist von Amazon nicht erwünscht!</p>",
        "id" => "allg_produktbild_ap",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Sidebar: Produktseite",
        "desc" => "Wie soll die Sidebar auf der Produktseite angezeigt werden?",
        "id" => "layout_sidebar_produkt",
        "type" => "select",
        "options" => array(
            array(
                "value" => "none",
                "text" => "Nicht anzeigen"
            ),
            array(
                "value" => "links",
                "text" => "Links"
            ),
            array(
                "value" => "rechts",
                "text" => "Rechts"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Sidebar: Produktkategorie",
        "desc" => "Wie soll die Sidebar in der Produktkategorie angezeigt werden?",
        "id" => "layout_sidebar_tax",
        "type" => "select",
        "options" => array(
            array(
                "value" => "none",
                "text" => "Nicht anzeigen"
            ),
            array(
                "value" => "links",
                "text" => "Links"
            ),
            array(
                "value" => "rechts",
                "text" => "Rechts"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Verkaufsbox",
        "desc" => "Wo soll die Verkaufsbox auf der Produktseite hin?",
        "id" => "layout_ap_button_produkt",
        "type" => "select",
        "options" => array(
            array(
                "value" => "none",
                "text" => "Nicht anzeigen"
            ),
            array(
                "value" => "oben",
                "text" => "Oben"
            ),
            array(
                "value" => "unten",
                "text" => "Unten"
            ),
            array(
                "value" => "beides",
                "text" => "Beides"
            )
        ),
        "std" => ""
    ),
    array(
        'name' => 'EAN ausblenden?',
        'desc' => 'Soll im Produkt die EAN ausgeblendet werden?',
        'id' => 'show_ean',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        "name" => "Zusatzattribute anzeigen?",
        "desc" => "Sollen die Zusatzattribute Ihrer Produkte in der Produktliste angezeigt werden?",
        "id" => "show_additional_attributes",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        'name' => 'Anzahl der Zusatzattribute',
        'desc' => 'Wie viele Zusatzattribute sollen pro Produkt definiert werden können? (Maximal 100)',
        'id' => 'number_of_attributes',
        'type' => 'text',
        'std' => '4'
    ),
    array(
        "name" => "Wo sollen die Zusatzattribute angezeigt werden?",
        "desc" => "Oben neben dem Bild, unten unter der Produktbeschreibung oder beides?",
        "id" => "show_additional_attributes_position",
        "type" => "select",
        "options" => array(
            array(
                "value" => "top",
                "text" => "Oben"
            ),
            array(
                "value" => "bottom",
                "text" => "Unten"
            ),
            array(
                "value" => "both",
                "text" => "Beides"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Breite Produktbild im Verhältnis zur Seitenbreite",
        "desc" => "Wie breit soll das Produktbild proportional zur Verkaufsbox sein?",
        "id" => "proportion_image",
        "type" => "select",
        "options" => array(
            array(
                "value" => "7x5",
                "text" => "60% Bild - 40% Verkaufsbox"
            ),
            array(
                "value" => "3x9",
                "text" => "25% Bild - 75% Verkaufsbox"
            ),
            array(
                "value" => "4x8",
                "text" => "33% Bild - 66% Verkaufsbox"
            ),
            array(
                "value" => "5x7",
                "text" => "40% Bild - 60% Verkaufsbox"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Effekt im Produkt-Slider",
        "desc" => "Welcher Überblend-Effekt soll im Slider verwendet werden?",
        "id" => "product_image_effect",
        "type" => "select",
        "options" => array(
            array(
                "value" => "slideUpDown",
                "text" => "Slide hoch-runter"
            ),
            array(
                "value" => "slideLeftRight",
                "text" => "Slide von rechts nach links"
            ),
            array(
                "value" => "blind",
                "text" => "Blind"
            ),
            array(
                "value" => "fold",
                "text" => "Fold"
            ),
            array(
                "value" => "drop",
                "text" => "Drop"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Lupe ausblenden?",
        "desc" => "Soll die Lupe über dem Bild in der Produktansicht ausgeblendet werden?",
        "id" => "show_loupe",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Position Beschreibung Taxonomie",
        "desc" => "Soll die Beschreibung der Taxonomien oben oder unten angezeigt werden?",
        "id" => "position_description_tax",
        "type" => "select",
        "options" => array(
            array(
                "value" => "top",
                "text" => "oben"
            ),
            array(
                "value" => "bottom",
                "text" => "unten"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Feed-Link ausblenden?",
        "desc" => "Soll der Link zum Produkt-Feed ausgeblendet werden?",
        "id" => "hide_product_feed",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Produktdarstellung in Taxonomie",
        "desc" => "Wie sollen die Produkte in den Taxonomien dargestellt werden?",
        "id" => "appearance_products_taxonomy",
        "type" => "select",
        "options" => array(
            array(
                "value" => "horizontal",
                "text" => "horizontal"
            ),
            array(
                "value" => "vertical_without",
                "text" => "vertikal ohne Hover-Effekt"
            ),
            array(
                "value" => "vertical_with",
                "text" => "vertikal mit Hover-Effekt"
            )
        ),
        "std" => "horizontal"
    ),
    array(
        "name" => "MouseOver-Effekt der Produktbilder ausschalten",
        "desc" => "Wird diese Option aktiviert, wird der MouseOver-Effekt der Produktbilder nicht mehr angezeigt.",
        "id" => "mouseover_product_pics",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Warenkorb Button ausblenden",
        "desc" => 'Wird diese Option aktiviert, wird das Warenkorb Button generell ausgeblendet' . '<br /><a href="http://affiliseo.de/produkte/warenkorb-button-ausblenden/" target="_blank" class="link-affiliseo">' . '<i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Anleitung auf AffiliSEO.de</a>',
        "id" => "hide_add_to_basket",
        "type" => "checkbox",
        "std" => ""
    ),
    
    array(
        "name" => "UVP einblenden",
        "desc" => "Wird diese Option aktiviert, wird der UVP durchgestrichen neben dem Preis angezeigt",
        "id" => "show_uvp",
        "type" => "checkbox",
        "std" => ""
    ),
    
    array(
        "name" => "Sternebewertung ausblenden?",
        "desc" => "Soll die Sternebewertung global ausgeblendet werden?",
        "id" => "hide_star_rating",
        "type" => "checkbox",
        "std" => ""
    ),
    
    array(
        "name" => "Produktbewertung (Reviews) ausblenden?",
        "desc" => "Soll die Produktbewertung global ausgeblendet werden?",
        "id" => "hide_product_review",
        "type" => "checkbox",
        "std" => ""
    ),
    
    array(
        "type" => "close"
    ),
    
    array(
        "name" => "Preisvergleich",
        "type" => "title"
    ),
    array(
        "name" => "Position Preisvergleich",
        "desc" => "Wo soll der Preisvergleic dargestellt werden?",
        "id" => "position_price_comparison",
        "type" => "select",
        "options" => array(
            array(
                "value" => "top",
                "text" => "Unter Produktbeschreibung"
            ),
            array(
                "value" => "bottom",
                "text" => "Über \"Weitere Produkte\""
            )
        ),
        "std" => "top"
    ),
    array(
        "type" => "close"
    ),
    
    array(
        "name" => "Texte",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => "Bezeichnung der Startseite in den Breadcrumbs",
        "desc" => 'Standard ist der Titel der Startseite.' . '<br /><a href="http://affiliseo.de/bezeichnung-der-startseite-in-den-breadcrumbs-aendern/" target="_blank" class="link-affiliseo">' . '<i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Anleitung auf AffiliSEO.de</a>',
        "id" => "text_home_link",
        "type" => "text",
        "std" => ""
    ),
    array(
        "name" => "Währung",
        "desc" => "Tragen Sie hier Ihre Währung ein.",
        "id" => "currency_string",
        "type" => "text",
        "std" => "€"
    ),
    array(
        "name" => "Text " . __('VAT included.', 'affiliatetheme'),
        "desc" => 'Tragen Sie hier Ihren Text unterhalb des Preises ein. Standard ist "' . __('VAT included.', 'affiliatetheme') . '".',
        "id" => "tax_string",
        "type" => "text",
        "std" => __('VAT included.', 'affiliatetheme')
    ),
    array(
        'name' => 'Label Affiliatepartner-Button',
        'desc' => 'Wie soll der Affiliatepartner-Button beschriftet werden?',
        'id' => 'ap_button_label',
        'type' => 'text',
        'std' => 'jetzt kaufen bei '
    ),
    array(
        'name' => 'Label "' . __('Add to cart', 'affiliatetheme') . '"-Button',
        'desc' => 'Wie soll der "' . __('Add to cart', 'affiliatetheme') . '"-Button beschriftet werden?',
        'id' => 'ap_cart_button_label',
        'type' => 'text',
        'std' => __('Add to cart', 'affiliatetheme')
    ),
    array(
        "name" => "Überschrift: Weitere Produkte",
        "desc" => "Wird auf der Produktseite oberhalb der ähnlichen Produkte angezeigt.",
        "id" => "text_headline_related",
        "type" => "text",
        "std" => "Weitere Produkte"
    ),
    array(
        "name" => "Hinweistext unterhalb des Buttons",
        "desc" => "Wird auf der Produktseite unterhalb des \"Kaufen\" Buttons angezeigt.",
        "id" => "text_produkt_hinweis",
        "type" => "text",
        "std" => "gewöhnlich Versandfertig in 1-2 Tagen"
    ),
    array(
        "name" => "Suchformular: Eingabefeld",
        "desc" => "Text für den Platzhalter im Suchformular (Header)",
        "id" => "text_suchformular_header_input",
        "type" => "text",
        "std" => "Hersteller, Modell, Typ eingeben"
    ),
    array(
        "name" => "Erster Text in Verkaufsbox",
        "desc" => "Wenn dieser Text leer bleibt, wird kein Text angezeigt.",
        "id" => "text_1_grey_box",
        "type" => "text",
        "std" => __('Carefree order', 'affiliatetheme')
    ),
    array(
        "name" => "Zweiter Text in Verkaufsbox",
        "desc" => "Wenn dieser Text leer bleibt, wird kein Text angezeigt.",
        "id" => "text_2_grey_box",
        "type" => "text",
        "std" => __('In cooperation with the affiliate partner', 'affiliatetheme')
    ),
    array(
        "name" => "Überschrift über Kommentaren",
        "desc" => "Was soll über den Kommentaren stehen?",
        "id" => "comments_headline_product",
        "type" => "text",
        "std" => "Kommentar schreiben"
    ),
    array(
        'name' => 'Überschrift über Preisvergleich',
        'desc' => 'Welche Überschrift soll über dem Preisvergleich stehen?',
        'id' => 'headline_price_comparison',
        'type' => 'text',
        'std' => 'Preisvergleich'
    ),
    array(
        'name' => 'Text im Button "zum Preisvergleich"',
        'desc' => 'Welcher Text soll in dem Button stehen?',
        'id' => 'button_price_comparison',
        'type' => 'text',
        'std' => 'zum Preisvergleich'
    ),
    array(
        'name' => 'Text "Informationen über die Versandkosten finden Sie auf Amazon" im Preisvergleich (Amazon)',
        'desc' => 'Welcher Text soll bezüglich der Versandkosten bei Amazon im Preisvergleich stehen?',
        'id' => 'shipping_costs_ap',
        'type' => 'text',
        'std' => 'Informationen über die Versandkosten finden Sie auf Amazon'
    ),
    array(
        'name' => 'Text "Informationen über die Lieferzeit finden Sie auf Amazon" im Preisvergleich (Amazon)',
        'desc' => 'Welcher Text soll bezüglich der Lieferzeit bei Amazon im Preisvergleich stehen?',
        'id' => 'delivery_time_ap',
        'type' => 'text',
        'std' => 'Informationen über die Lieferzeit finden Sie auf Amazon'
    ),
    array(
        'name' => 'Text "zum Shop" Affiliatelink im Preisvergleich',
        'desc' => 'Welcher Text soll im Affiliatelink stehen?',
        'id' => 'text_button_price_comparison',
        'type' => 'text',
        'std' => 'zum Shop'
    ),
    array(
        'name' => 'Text "Versandkosten" im Preisvergleich',
        'desc' => 'Welcher Text soll anstelle von "Versandkosten" stehen?',
        'id' => 'text_shipping_price_comparison',
        'type' => 'text',
        'std' => 'Versandkosten'
    ),
    array(
        'name' => 'Text "kostenfrei" im Preisvergleich',
        'desc' => 'Welcher Text soll anstelle von "kostenfrei" stehen?',
        'id' => 'free',
        'type' => 'text',
        'std' => 'kostenfrei'
    ),
    array(
        'name' => 'Text "unbekannte Lieferzeit" im Preisvergleich',
        'desc' => 'Welcher Text soll anstelle von "unbekannte Lieferzeit" stehen?',
        'id' => 'shipping_suffix',
        'type' => 'text',
        'std' => 'unbekannte Lieferzeit'
    ),
    array(
        'name' => 'Text "' . __('Product description', 'affiliatetheme') . '" im Produkt',
        'desc' => 'Welcher Text soll anstelle von "' . __('Product description', 'affiliatetheme') . '" stehen?',
        'id' => 'text_product_description',
        'type' => 'text',
        'std' => __('Product description', 'affiliatetheme')
    ),
    array(
        'name' => 'Linktext auf Weiterleitungsseite',
        'desc' => 'Tragen Sie hier den Text für den Link auf der Weiterleitungsseite ein. ' . '(Wird nur angezeigt, wenn das Verstecken der Affiliatelinks aktiviert ist.)',
        'id' => 'cloaking_link',
        'type' => 'text',
        'std' => 'hier &rarr;'
    ),
    array(
        'name' => 'Text "Gesamtbewertung" im Produkt',
        'desc' => 'Welcher Text soll als Überschrift angezeigt werden?',
        'id' => 'product_review_description',
        'type' => 'text',
        'std' => 'Gesamtbewertung'
    ),
    
    array(
        'name' => 'Text für "Gesamtbewertung" der Zusammenfassung',
        'desc' => 'Text für den %-Bereich 0% - 25%',
        'id' => 'product_review_rating1',
        'type' => 'text',
        'std' => 'SCHLECHT'
    ),
    
    array(
        'name' => 'Text für "Gesamtbewertung" der Zusammenfassung',
        'desc' => 'Text für den %-Bereich 25% - 50%',
        'id' => 'product_review_rating2',
        'type' => 'text',
        'std' => 'BEFRIEDIGEND'
    ),
    
    array(
        'name' => 'Text für "Gesamtbewertung" der Zusammenfassung',
        'desc' => 'Text für den %-Bereich 50% - 75%',
        'id' => 'product_review_rating3',
        'type' => 'text',
        'std' => 'GUT'
    ),
    
    array(
        'name' => 'Text für "Gesamtbewertung" der Zusammenfassung',
        'desc' => 'Text für den %-Bereich 75% - 100%',
        'id' => 'product_review_rating4',
        'type' => 'text',
        'std' => 'SEHR GUT'
    ),
    
    array(
        "type" => "close"
    ),
    array(
        "name" => "Werbebanner",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => "Header",
        "desc" => "Bitte hier den Code angeben, mit Script-Tags.",
        "id" => "ad_header",
        "type" => "textarea",
        "std" => ""
    ),
    array(
        "name" => "Seite: Überhalb der Überschrift",
        "desc" => "Bitte hier den Code angeben, mit Script-Tags.",
        "id" => "ad_page_top",
        "type" => "textarea",
        "std" => ""
    ),
    array(
        "name" => "Seite: Überhalb der Überschrift, mobile Endgeräte - maximal 300 Pixel Breite",
        "desc" => "Bitte hier den Code angeben, mit Script-Tags.",
        "id" => "ad_page_top_mobile",
        "type" => "textarea",
        "std" => ""
    ),
    array(
        "name" => "Produkt Shortcode: Unterhalb der Produkte",
        "desc" => "Bitte hier den Code angeben, mit Script-Tags.",
        "id" => "ad_produkt_shortcode_bottom",
        "type" => "textarea",
        "std" => ""
    ),
    array(
        "name" => "Produkt Shortcode: Unterhalb der Produkte, mobile Endgeräte - maximal 300 Pixel Breite",
        "desc" => "Bitte hier den Code angeben, mit Script-Tags.",
        "id" => "ad_produkt_shortcode_bottom_mobile",
        "type" => "textarea",
        "std" => ""
    ),
    array(
        "name" => "Produkt: Oben",
        "desc" => "Bitte hier den Code angeben, mit Script-Tags.",
        "id" => "ad_produkt_top",
        "type" => "textarea",
        "std" => ""
    ),
    array(
        "name" => "Produkt: Oben, mobile Endgeräte - maximal 300 Pixel Breite",
        "desc" => "Bitte hier den Code angeben, mit Script-Tags.",
        "id" => "ad_produkt_top_mobile",
        "type" => "textarea",
        "std" => ""
    ),
    array(
        "name" => "Produkt: Unten",
        "desc" => "Bitte hier den Code angeben, mit Script-Tags.",
        "id" => "ad_produkt_bottom",
        "type" => "textarea",
        "std" => ""
    ),
    array(
        "name" => "Produkt: Unten, mobile Endgeräte - maximal 300 Pixel Breite",
        "desc" => "Bitte hier den Code angeben, mit Script-Tags.",
        "id" => "ad_produkt_bottom_mobile",
        "type" => "textarea",
        "std" => ""
    ),
    array(
        "type" => "close"
    ),
    array(
        "name" => "Bestenliste",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => "Platzierung anzeigen?",
        "desc" => "Soll die Platzierung des Produkts angezeigt werden?",
        "id" => "highscore_platzierung_ausblenden",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Bild anzeigen?",
        "desc" => "Soll ein Bild des Produkts angezeigt werden?",
        "id" => "highscore_bild_ausblenden",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Bewertung anzeigen?",
        "desc" => "Soll die Bewertung des Produkts angezeigt werden?",
        "id" => "highscore_bewertung_ausblenden",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Beschreibung anzeigen?",
        "desc" => "Soll eine Beschreibung des Produkts angezeigt werden?",
        "id" => "highscore_beschreibung_ausblenden",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Angebot anzeigen?",
        "desc" => "Soll ein Angebot des Produkts angezeigt werden?",
        "id" => "highscore_angebot_ausblenden",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "type" => "close"
    ),
    array(
        "name" => "Social Media",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => "Wo sollen die Social Media Teilen-Buttons eingeblendet werden?",
        "desc" => "",
        "id" => "position_social_share",
        "type" => "select",
        "options" => array(
            array(
                "value" => "right",
                "text" => "rechts"
            ),
            array(
                "value" => "top",
                "text" => "oben"
            ),
            array(
                "value" => "none",
                "text" => "ausblenden"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Facebook ausblenden",
        "desc" => "Facebook Teilen-Button ausblenden",
        "id" => "show_fb",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Twitter ausblenden",
        "desc" => "Twitter Teilen-Button ausblenden",
        "id" => "show_twitter",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Google+ ausblenden",
        "desc" => "Google+ Teilen-Button ausblenden",
        "id" => "show_gplus",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "RSS-Feed-Icon ausblenden?",
        "desc" => "Soll das RSS-Feed-Icon unten rechts im Footer ausblenden werden?",
        "id" => "show_rss",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Haben Sie eine eigene Facebook-Seite?",
        "desc" => "Wenn Sie eine eigene Facebook-Seite haben, können Sie die URL Ihrer Facebook-Seite hier eintragen. " . "Wenn Sie eine URL eintragen, wird das Facebook-Icon mit einem Link zu Ihrer Facebook-Seite unten rechts im Footer angezeigt. " . "Bleibt das Feld leer, wird auch kein Facebook-Icon angezeigt.",
        "id" => "url_facebook",
        "type" => "text",
        "std" => ""
    ),
    array(
        "name" => "Haben Sie einen Twitter-Account?",
        "desc" => "Wenn Sie einen Twitter-Account haben, können Sie die URL Ihres Twitter-Accounts hier eintragen. " . "Wenn Sie eine URL eintragen, wird das Twitter-Icon mit einem Link zu Ihrem Twitter-Account unten rechts im Footer angezeigt. " . "Bleibt das Feld leer, wird auch kein Twitter-Icon angezeigt.",
        "id" => "url_twitter",
        "type" => "text",
        "std" => ""
    ),
    array(
        "name" => "Haben Sie eine eigene Google+-Seite?",
        "desc" => "Wenn Sie eine eigene Google+-Seite haben, können Sie die URL Ihrer Google+-Seite hier eintragen. " . "Wenn Sie eine URL eintragen, wird das Google+-Icon mit einem Link zu Ihrer Google+-Seite unten rechts im Footer angezeigt. " . "Bleibt das Feld leer, wird auch kein Google+-Icon angezeigt.",
        "id" => "url_gplus",
        "type" => "text",
        "std" => ""
    ),
    array(
        "name" => "Haben Sie einen Youtube-Channel?",
        "desc" => "Wenn Sie einen Youtube-Channel haben, können Sie die URL Ihrem Youtube-Channel hier eintragen. " . "Wenn Sie eine URL eintragen, wird das Youtube-Icon mit einem Link zu Ihrem Youtube-Channel unten rechts im Footer angezeigt. " . "Bleibt das Feld leer, wird auch kein Youtube-Icon angezeigt.",
        "id" => "url_youtube",
        "type" => "text",
        "std" => ""
    ),
    array(
        "name" => "Wo sollen die Social Media Icons eingeblendet werden?",
        "desc" => "Die Social Media Icons werden nur angezeigt, wenn Sie in den Einstellungen das RSS-Feed-Icon einblenden und/oder " . "URLs zu Ihrer Facebook-Seite, zu Ihrem Twitter-Account, zu Ihrer Google+-Seite oder zu Ihrem Youtube-Channel eingetragen haben. " . "Um die Social Media Icons oben einzublenden, benötigen Sie ein zweites Menü. (Design > Menüs > Position im Theme > Navigation oben)",
        "id" => "position_social_icons",
        "type" => "select",
        "options" => array(
            array(
                "value" => "both",
                "text" => "oben und unten"
            ),
            array(
                "value" => "bottom",
                "text" => "nur unten"
            ),
            array(
                "value" => "top",
                "text" => "nur oben"
            ),
            array(
                "value" => "none",
                "text" => "ausblenden"
            )
        ),
        "std" => ""
    ),
    array(
        "type" => "close"
    ),
    array(
        "name" => "Produktvergleich",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => "1. Attribut für Vergleichstabelle - Bezeichnung",
        "desc" => "Spaltenbezeichnung 1. Attribut",
        "id" => "comparison_first_attribute_name",
        "type" => "text",
        "std" => ""
    ),
    array(
        "name" => "1. Attribut für Vergleichstabelle als Ja/Nein-Attribut",
        "desc" => 'Wenn hier ein Häckchen gesetzt wird, wird in "Produkt editieren" anstelle eines Eingabefeldes ' . 'ein Checkbox für ein Ja/Nein-Attribut angezeigt.',
        "id" => "comparison_first_attribute_value",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "2. Attribut für Vergleichstabelle - Bezeichnung",
        "desc" => "Spaltenbezeichnung 2. Attribut",
        "id" => "comparison_second_attribute_name",
        "type" => "text",
        "std" => ""
    ),
    array(
        "name" => "2. Attribut für Vergleichstabelle als Ja/Nein-Attribut",
        "desc" => 'Wenn hier ein Häckchen gesetzt wird, wird in "Produkt editieren" anstelle eines Eingabefeldes ein Checkbox ".
            "für ein Ja/Nein-Attribut angezeigt.',
        "id" => "comparison_second_attribute_value",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "3. Attribut für Vergleichstabelle - Bezeichnung",
        "desc" => "Spaltenbezeichnung 3. Attribut",
        "id" => "comparison_third_attribute_name",
        "type" => "text",
        "std" => ""
    ),
    array(
        "name" => "3. Attribut für Vergleichstabelle als Ja/Nein-Attribut",
        "desc" => 'Wenn hier ein Häckchen gesetzt wird, wird in "Produkt editieren" anstelle eines Eingabefeldes ein Checkbox ' . 'für ein Ja/Nein-Attribut angezeigt.',
        "id" => "comparison_third_attribute_value",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "4. Attribut für Vergleichstabelle - Bezeichnung",
        "desc" => "Spaltenbezeichnung 4. Attribut",
        "id" => "comparison_fourth_attribute_name",
        "type" => "text",
        "std" => ""
    ),
    array(
        "name" => "4. Attribut für Vergleichstabelle als Ja/Nein-Attribut",
        "desc" => 'Wenn hier ein Häckchen gesetzt wird, wird in "Produkt editieren" anstelle eines Eingabefeldes ein Checkbox ' . 'für ein Ja/Nein-Attribut angezeigt.',
        "id" => "comparison_fourth_attribute_value",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "5. Attribut für Vergleichstabelle - Bezeichnung",
        "desc" => "Spaltenbezeichnung 5. Attribut",
        "id" => "comparison_fifth_attribute_name",
        "type" => "text",
        "std" => ""
    ),
    array(
        "name" => "5. Attribut für Vergleichstabelle als Ja/Nein-Attribut",
        "desc" => 'Wenn hier ein Häckchen gesetzt wird, wird in "Produkt editieren" anstelle eines Eingabefeldes ein Checkbox ' . 'für ein Ja/Nein-Attribut angezeigt.',
        "id" => "comparison_fifth_attribute_value",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Wie sollen Empfehlungen hervorgehoben werden?",
        "id" => "comparison_highlight",
        'type' => 'select',
        'options' => array(
            'ribbon' => __('Ribbon', 'cmb'),
            'border' => __('Rahmen', 'cmb'),
            'background' => __('Hintergrundfarbe', 'cmb')
        ),
        'default' => 'ribbon'
    ),
    array(
        "name" => "Zusätzlichen Button anzeigen?",
        "desc" => "",
        "id" => "comparison_show_third_button",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Amazon-Button anzeigen?",
        "desc" => "",
        "id" => "comparison_show_ap_button",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Button zum Produkt anzeigen?",
        "desc" => "",
        "id" => "comparison_show_product_button",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "type" => "close"
    ),
    array(
        "name" => "Popup & Anti-Bounce",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => 'jQuery Popup aktivieren?',
        "desc" => 'Aktiviert ein Popup, das Sie mit beliebigem Inhalt füllen können.' . '<br /><a href="http://affiliseo.de/popup/" target="_blank" class="link-affiliseo">
				<i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Anleitung auf AffiliSEO.de
			</a>',
        "id" => "activate_popup",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        'name' => 'Welche Seite soll in dem Popup angezeigt werden?',
        'desc' => '',
        'id' => 'choose_page_popup',
        'type' => 'select',
        'options' => $pages_popup,
        'std' => ''
    ),
    array(
        'name' => 'Text Schließen-Button',
        'desc' => 'Standard ist "Schließen".',
        'id' => 'text_close_popup',
        'type' => 'text',
        'std' => 'Schließen'
    ),
    array(
        'name' => 'Wie oft soll das Popup angezeigt werden? (in Tagen)',
        'desc' => 'Welcher zeitliche Abstand soll zwischen dem Einblenden des Popups vergehen? ' . '(Standard ist 1, was bedeutet, dass einmal täglich das Popup angezeigt wird. 2' . ' bedeutet, dass das Popup alle zwei Tage angezeigt wird. 3 bedeutet, dass das Popup jeden dritten Tag angezeigt wird usw. ' . 'Bei blockierten Cookies wird das Popup nicht angezeigt.)',
        'id' => 'difference_show_popup',
        'type' => 'text',
        'std' => '1'
    ),
    array(
        'name' => 'Wie viele Sekunden sollen vergehen, ehe das Popup angezeigt wird?',
        'desc' => 'Standard ist 60.',
        'id' => 'difference_show_popup_js',
        'type' => 'text',
        'std' => '60'
    ),
    array(
        'name' => 'Alternativ kann das Popup angezeigt werden, wenn der Benutzer das Browserfenster mit der Mouse verlässt.',
        'desc' => 'Ist diese Option aktiviert, das Popupfenster direkt beim Verlassen des Browserfensters angezeigt.',
        'id' => 'show_popup_leave',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        'name' => 'Anti-Bounce-URL',
        'desc' => 'Wenn ein Benutzer von Ihrer Seite abspringt (bounced), wird er auf diese URL geleitet. ' . 'Ist keine URL eingetragen, wird der Benutzer nicht weitergeleitet.' . '<br /><a href="http://affiliseo.de/anti-bounce/" target="_blank" class="link-affiliseo">' . '<i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Anleitung auf AffiliSEO.de</a>',
        'id' => 'anti_bounce_url',
        'type' => 'text',
        'std' => ''
    ),
    array(
        "type" => "close"
    ),
    array(
        "name" => "Blog",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => "Veröffentlichungsdatum, Kategorie und Autor ausblenden?",
        "desc" => 'Soll das Datum der Veröffentlichung und die Kategorie eines Blogartikels im Blog ausgeblendet werden?',
        "id" => "blog_show_time",
        "type" => "checkbox",
        "std" => ""
    ),
    
    array(
        "name" => "Blogbildgröße",
        "desc" => "In welcher Größe soll das Blogbild dargestellt werden?" . "<p style='color:#e74c3c;'><strong>HINWEIS</strong><br />keine Vergrößerung möglich, maximal Originalgröße des Bildes darstellbar</p>",
        "id" => "blog_image_size",
        "type" => "select",
        "options" => array(
            array(
                "value" => "no_img",
                "text" => "Kein Bild"
            ),
            array(
                "value" => "image_150_150",
                "text" => "150x150"
            ),
            array(
                "value" => "image_300_300",
                "text" => "300x300"
            ),
            array(
                "value" => "image_450_450",
                "text" => "450x450"
            ),
            array(
                "value" => "image_600_600",
                "text" => "600x600"
            ),
            array(
                "value" => "image_800_800",
                "text" => "800x800"
            ),
            array(
                "value" => "full_size",
                "text" => "full-size"
            )
        )
    ),
    
    array(
        "name" => "Sidebar: Blogkategorie",
        "desc" => "Wie soll die Sidebar auf in der Blogkategorie Seite angezeigt werden?",
        "id" => "layout_sidebar_category",
        "type" => "select",
        "options" => array(
            array(
                "value" => "none",
                "text" => "Nicht anzeigen"
            ),
            array(
                "value" => "links",
                "text" => "Links"
            ),
            array(
                "value" => "rechts",
                "text" => "Rechts"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Sidebar: Blog",
        "desc" => "Wie soll die Sidebar im Blog angezeigt werden?",
        "id" => "layout_sidebar_blog",
        "type" => "select",
        "options" => array(
            array(
                "value" => "none",
                "text" => "Nicht anzeigen"
            ),
            array(
                "value" => "links",
                "text" => "Links"
            ),
            array(
                "value" => "rechts",
                "text" => "Rechts"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Position Beschreibung Taxonomie",
        "desc" => "Soll die Beschreibung der Taxonomien oben oder unten angezeigt werden?",
        "id" => "position_description_tax_blog",
        "type" => "select",
        "options" => array(
            array(
                "value" => "top",
                "text" => "oben"
            ),
            array(
                "value" => "bottom",
                "text" => "unten"
            )
        ),
        "std" => ""
    ),
    array(
        "name" => "Feed-Link ausblenden?",
        "desc" => "Soll der Link zum Feed-Link ausgeblendet werden?",
        "id" => "hide_blog_feed",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Kommentar-Feed-Link ausblenden?",
        "desc" => "Soll der Link zum Kommentar-Feed-Link ausgeblendet werden?",
        "id" => "hide_comment_feed",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Kategorie-Feed-Link ausblenden?",
        "desc" => "Soll der Link zum Kategorie-Feed-Link ausgeblendet werden?",
        "id" => "hide_category_feed",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "name" => "Tag-Feed-Link ausblenden?",
        "desc" => "Soll der Link zum Tag-Feed-Link ausgeblendet werden?",
        "id" => "hide_tag_feed",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "type" => "close"
    ),
    
    // start CookiePolicy
    array(
        "name" => "Website Hinweis",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    
    array(
        "name" => __('Disable cookie policy functionality?', 'affiliatetheme'),
        "desc" => "",
        "id" => "disable_cookie_policy_function",
        "type" => "checkbox",
        "std" => ""
    ),
    
    array(
        "name" => __('Cookie policy message', 'affiliatetheme'),
        "desc" => __('Please enter a text, which should be displayed in the notification bar.', 'affiliatetheme'),
        "id" => "cookie_policy_message",
        "type" => "textarea",
        "std" => __('To make this site work properly, we place small data files called cookies on your device.', 'affiliatetheme')
    ),
    
    array(
        'name' => __('Button text', 'affiliatetheme'),
        'desc' => __('Standard is "Ok".', 'affiliatetheme'),
        'id' => 'cookie_policy_accept_button',
        'type' => 'text',
        'std' => __('Ok', 'affiliatetheme')
    ),
    
    array(
        "name" => __('Disable more information button?', 'affiliatetheme'),
        "desc" => __('Should the button be hidden for more information?', 'affiliatetheme'),
        "id" => "hide_cookie_policy_read_more_button",
        "type" => "checkbox",
        "std" => ""
    ),
    
    array(
        'name' => __('The text of the more info button.', 'affiliatetheme'),
        'desc' => __("Standard is 'more information'", 'affiliatetheme'),
        'id' => 'cookie_policy_read_more_button',
        'type' => 'text',
        'std' => __("more information", 'affiliatetheme')
    ),
    
    array(
        'name' => __('More info link', 'affiliatetheme'),
        'desc' => __('Enter the full URL starting with http://', 'affiliatetheme'),
        'id' => 'cookie_policy_read_more_link',
        'type' => 'text',
        'std' => ''
    ),
    
    array(
        "name" => __('Cookie expiry', 'affiliatetheme'),
        "desc" => __('The amount of time that cookie should be stored for.', 'affiliatetheme'),
        "id" => "cookie_policy_expire",
        "type" => "select",
        "options" => array(
            array(
                "value" => 60 * 60 * 24 * 1,
                "text" => __('1 day', 'affiliatetheme')
            ),
            array(
                "value" => 60 * 60 * 24 * 7,
                "text" => __('1 week', 'affiliatetheme')
            ),
            array(
                "value" => 60 * 60 * 24 * 31,
                "text" => __('1 month', 'affiliatetheme')
            ),
            array(
                "value" => 60 * 60 * 24 * 90,
                "text" => __('3 months', 'affiliatetheme')
            ),
            array(
                "value" => 60 * 60 * 24 * 180,
                "text" => __('6 months', 'affiliatetheme')
            ),
            array(
                "value" => 60 * 60 * 24 * 365,
                "text" => __('1 year', 'affiliatetheme')
            ),
            array(
                "value" => 2147483647,
                "text" => __('infinity', 'affiliatetheme')
            )
        ),
        "std" => ""
    ),
    
    array(
        "name" => __('Position', 'affiliatetheme'),
        "desc" => __('Select section for your cookie notice.', 'affiliatetheme'),
        "id" => "cookie_policy_message_position",
        "type" => "select",
        "options" => array(
            array(
                "value" => "bottom",
                "text" => __('Bottom', 'affiliatetheme')
            ),
            array(
                "value" => "top",
                "text" => __('Top', 'affiliatetheme')
            )
        ),
        "std" => ""
    ),
    
    array(
        "name" => __('Animation', 'affiliatetheme'),
        "desc" => __('Cookie notice acceptance animation.', 'affiliatetheme'),
        "id" => "cookie_policy_hide_effect",
        "type" => "select",
        "options" => array(
            array(
                "value" => "fade",
                "text" => __('Fade', 'affiliatetheme')
            ),
            array(
                "value" => "slide",
                "text" => __('Slide', 'affiliatetheme')
            )
        ),
        "std" => ""
    ),
    
    array(
        "type" => "close"
    ),
    // end CookiePolicy
    
    array(
        "name" => "Ausführliches Menü mit Infografiken",
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => 'Ausführliches Menü aktivieren?',
        "desc" => 'Wenn Sie das ausführliche Menü aktivieren, wird die dritte Ebene des Menüs anders dargestellt. ' . 'Probieren Sie es am Besten aus, um das Ergebnis zu sehen.' . '<br /><a href="http://affiliseo.de/ausfuehrliches-menue-mit-grafiken/" target="_blank" class="link-affiliseo">' . '<i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Anleitung auf AffiliSEO.de</a>',
        "id" => "use_mega_menu",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        'name' => 'Thumbnails der Tags anzeigen?',
        'desc' => 'Sollen neben den Menüpunkten der Blogkategorien Thumbnails angezeigt werden?',
        'id' => 'show_thumbnails_category_mega_menu',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        'name' => 'Thumbnails der Blogkategorien anzeigen?',
        'desc' => 'Sollen neben den Menüpunkten der Tags und Produkt-Tags Thumbnails angezeigt werden?',
        'id' => 'show_thumbnails_tags_mega_menu',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        'name' => 'Thumbnails der ' . $brand_plural . ' anzeigen?',
        'desc' => 'Sollen neben den Menüpunkten der ' . $brand_plural . ' Thumbnails angezeigt werden?',
        'id' => 'show_thumbnails_brands_mega_menu',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        'name' => 'Thumbnails der ' . $type_plural . ' anzeigen?',
        'desc' => 'Sollen neben den Menüpunkten der ' . $type_plural . ' Thumbnails angezeigt werden?',
        'id' => 'show_thumbnails_types_mega_menu',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        'name' => 'Thumbnails der Blogartikel anzeigen?',
        'desc' => 'Sollen neben den Menüpunkten der Blogartikel Thumbnails angezeigt werden?',
        'id' => 'show_thumbnails_posts_mega_menu',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        'name' => 'Thumbnails der Seiten anzeigen?',
        'desc' => 'Sollen neben den Menüpunkten der Seiten Thumbnails angezeigt werden?',
        'id' => 'show_thumbnails_pages_mega_menu',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        'name' => 'Thumbnails der Produkte anzeigen?',
        'desc' => 'Sollen neben den Menüpunkten der Produkte Thumbnails/das Produktbild angezeigt werden?',
        'id' => 'show_thumbnails_products_mega_menu',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        'name' => 'Sternebewertung unter Produkt',
        'desc' => 'Soll die Sternebewertung unter den Menüpunkten der Produkte angezeigt werden?',
        'id' => 'show_thumbnails_stars_mega_menu',
        'type' => 'checkbox',
        'std' => ''
    ),
    array(
        "name" => "Produktempfehlung anzeigen?",
        "desc" => 'Soll im Aufklappmenü eine Produktempfehlung angezeigt werden?',
        "id" => "show_product_mega_menu",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        'name' => 'Welches Produkt (Produktempfehlung) soll angezeigt werden?',
        'desc' => 'Wählen Sie ein Produkt aus, wenn ein bestimmtes Produkt angezeigt werden soll. ' . 'Wenn Sie kein Produkt auswählen, wird ein zufälliges Produkt angezeigt.',
        'id' => 'chosen_product_mega_menu',
        'type' => 'select',
        'options' => $products_mega_menu,
        'std' => ''
    ),
    array(
        'name' => 'Überschrift über der Produktempfehlung',
        'desc' => 'Wie soll die Überschrift über dem angezeigten Produkt lauten? Bleibt dieses Feld frei, ' . 'wird die Überschrift nicht angezeigt; bei ausgeblendetem Produkt ebenfalls.',
        'id' => 'headline_product_mega_menu',
        'type' => 'text',
        'std' => ''
    ),
    array(
        "type" => "close"
    ),
    array(
        "name" => 'Erweitere Einstellungen (nur für erfahrene Benutzer mit Vorkenntnissen in Bezug auf Wordpress-Taxonomien) - ' . 'Dient der Anpassung der Permalinks!' . '<br />' . '<a href="http://affiliseo.de/erweitere-einstellungen-fuer-taxonomien/" target="_blank" class="link-affiliseo" style="float: right;">' . '<i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Anleitung auf AffiliSEO.de</a><div style="clear: both;"></div>',
        "type" => "title"
    ),
    array(
        "type" => "open"
    ),
    array(
        "name" => "Bezeichnung Typ-Taxonomie der Produkte - Singular (erscheint im Permalink, auf Produktseiten und im Backend)",
        "desc" => 'Wie soll die Taxonomie der Produkte benannt werden? (Singular; Standard ist "' . __('Type', 'affiliatetheme') . '"; versuchen Sie, Umlaute zu vermeiden)',
        "id" => "products_type_singular",
        "type" => "text",
        "std" => __('Type', 'affiliatetheme')
    ),
    array(
        "name" => "Bezeichnung Typ-Taxonomie der Produkte - Plural (erscheint im Backend)",
        "desc" => 'Wie soll die Taxonomie der Produkte benannt werden? (Plural; Standard ist "' . __('Types', 'affiliatetheme') . '"; versuchen Sie, Umlaute zu vermeiden)',
        "id" => "products_type_plural",
        "type" => "text",
        "std" => __('Types', 'affiliatetheme')
    ),
    array(
        "name" => "Bezeichnung Marken-Taxonomie der Produkte - Singular (erscheint im Permalink, auf Produktseiten und im Backend)",
        "desc" => 'Wie soll die Taxonomie der Produkte benannt werden? (Singular; Standard ist "' . __('Brand', 'affiliatetheme') . '"; versuchen Sie, Umlaute zu vermeiden)',
        "id" => "products_brand_singular",
        "type" => "text",
        "std" => __('Brand', 'affiliatetheme')
    ),
    array(
        "name" => "Bezeichnung Marken-Taxonomie der Produkte - Plural (erscheint im Backend)",
        "desc" => 'Wie soll die Taxonomie der Produkte benannt werden? (Plural; Standard ist "' . __('Brands', 'affiliatetheme') . '"; versuchen Sie, Umlaute zu vermeiden)',
        "id" => "products_brand_plural",
        "type" => "text",
        "std" => __('Brands', 'affiliatetheme')
    ),
    array(
        "name" => "Permalinks anpassen?<br />(Wenn Sie diese Einstellung ändern, MÜSSEN Sie " . "zusätzlich noch mindestens einmal, NACH Änderung dieser Einstellung, unter Einstellungen > Permalinks auf 'Änderungen übernehmen' " . "klicken, da ansonsten die Links auf Ihrer Seite zu einem 404 führen!)",
        "desc" => 'Sollen die Permalinks der Produkte an Ihre Eingaben angepasst werden? ' . '(<strong>Ohne Anpassung</strong> lautet der Permalink eines Produktes ' . '<strong style="color:#e74c3c;">/produkt/markenname/produktname</strong>, der ' . 'Permalink der Marken lautet <strong style="color:#e74c3c;">/produkt/markenname</strong> und der Permalink der Typen lautet ' . '<strong style="color:#e74c3c;">/typen/typname</strong>. <strong>Nach der Anpassung</strong> lautet der Permalink eines Produkts ' . '<strong style="color:#e74c3c;">/ihr_gewaehlter_taxonomienname/ markenname/produktname</strong>, ' . 'der Permalink der Marken lautet <strong style="color:#e74c3c;">/ihr_gewaehlter_taxonomienname/ markenname</strong>, ' . 'der Permalink der Typen lautet ' . '<strong style="color:#e74c3c;">/ihr_gewaehlter_taxonomienname/ typname</strong>. Diese Änderung ermöglicht Ihren optimierte Permalinks. ' . 'Aber bitte bedenken Sie, dass eine Änderung der Permalinks eine vorübergehende Abstrafung ' . 'seitens Google nach sich ziehen kann, wenn Sie zuvor andere Permalinks verwendet haben.)',
        "id" => "use_custom_permalinks",
        "type" => "checkbox",
        "std" => ""
    ),
    array(
        "type" => "close"
    )
);