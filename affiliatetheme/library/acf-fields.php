<?php
global $affiliseo_options, $wpdb;

load_theme_textdomain('affiliatetheme', get_template_directory() . '/languages');

$ComparisonAttributes = new ComparisonAttributes();
$comparisonAttributeGroups = $ComparisonAttributes->getComparisonAttributeGroups('all');

$postTermSlug = null;
$comparisonProductId = (isset($_GET['post'])) ? $_GET['post'] : null;

if ($comparisonProductId > 0) {
    
    $postTermSlug = $ComparisonAttributes->getPostTermSlug(intval($comparisonProductId));
    $comparisonAttributeGroups = $ComparisonAttributes->getComparisonAttributeGroups($postTermSlug);
}

$acfComparisonAttributes = array();

$nonAcfFileds = array(
    "productImage",
    "priceCompare",
    "apButton",
    "pdpButton",
    "productReview",
    "starRating",
    "productPrice",
    "productUvpPrice"
);

foreach ($comparisonAttributeGroups as $comparisonAttributeGroup) {
    $belongsTo = $comparisonAttributeGroup->id;
    
    $comparisonAttributes = $ComparisonAttributes->getComparisonAttributes($belongsTo);
    foreach ($comparisonAttributes as $comparisonAttribute) {
        if (in_array($comparisonAttribute->type, $nonAcfFileds)) {
            continue;
        }
        $acfField = $ComparisonAttributes->createAcfField($comparisonAttribute);
        array_push($acfComparisonAttributes, $acfField);
    }
}

$productPostId = 0;
$post = null;

// default partner
$apProductIdField = array(
    'key' => 'intern_product_id',
    'label' => 'Produkt ID',
    'name' => 'intern_product_id'
);
$apProductIdFieldPartners = array(
    
    'intern_product_id' => array(
        'label' => 'Interne Produkt ID',
        'name' => 'intern_product_id'
    ),
    
    'field_52e782fee682f' => array(
        'label' => 'Amazon Produkt ID',
        'name' => 'amazon_produkt_id'
    ),
    'affilinet_product_id' => array(
        'label' => 'Affilinet Produkt ID',
        'name' => 'affilinet_product_id'
    ),
    'belboon_product_id' => array(
        'label' => 'Belboon Produkt ID',
        'name' => 'belboon_product_id'
    ),
    'zanox_product_id' => array(
        'label' => 'Zanox Produkt ID',
        'name' => 'zanox_product_id'
    ),
    'tradedoubler_product_id' => array(
        'label' => 'Tradedoubler Produkt ID',
        'name' => 'tradedoubler_product_id'
    ),
    'eBay_product_id' => array(
        'label' => 'eBay Produkt ID',
        'name' => 'eBay_product_id'
    )
);

$apSelectList = array();
$apSelectList['null'] = 'keine &Auml;nderung';
foreach ($apProductIdFieldPartners as $key => $val) {
    $apSelectList[$key] = $val['label'];
}

if (isset($_GET['post'])) {
    
    $productPostId = $_GET['post'];
    
    $post = get_post($productPostId);
    
    $getFieldObject = get_field_object('new_ap_product_id_name');
    
    $query = ' DELETE FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key="new_ap_product_id_name" AND post_id="' . $productPostId . '" LIMIT 1 ';
    $wpdb->query($query);
    $query = ' DELETE FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key="_new_ap_product_id_name" AND post_id="' . $productPostId . '" LIMIT 1 ';
    $wpdb->query($query);
    $query = ' DELETE FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key="_" AND post_id="' . $productPostId . '" LIMIT 1 ';
    $wpdb->query($query);
    
    $post = get_post($productPostId);
    
    if (isset($getFieldObject['value']) && $getFieldObject['value'] != "null" && $getFieldObject['value'] != "" && isset($getFieldObject['key']) && $getFieldObject['key'] == 'field_new_ap_product_id_name') {
        
        // default affiliate partner
        $currentMetaValue = 'intern_product_id';
        
        $postMetaValues = array();
        
        $res = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->prefix . 'postmeta WHERE post_id="' . $post->ID . '" ', OBJECT);
        if (count($res) > 0) {
            foreach ($res as $val) {
                $postMetaValues[] = $val->meta_value;
            }
        }
        
        $apProductIdNames = array_keys($apProductIdFieldPartners);
        
        foreach ($apProductIdNames as $apProductIdName) {
            
            if (in_array($apProductIdName, $postMetaValues)) {
                $currentMetaValue = $apProductIdName;
                break;
            }
        }
        
        $newMetaValue = $getFieldObject['value'];
        
        if ($newMetaValue != $currentMetaValue) {
            
            if (isset($apProductIdFieldPartners[$newMetaValue])) {
                
                $newMetaKey = $apProductIdFieldPartners[$newMetaValue]['name'];
                
                $currentMetaKey = $apProductIdFieldPartners[$currentMetaValue]['name'];
                
                $query = " UPDATE " . $wpdb->prefix . "postmeta SET
                    meta_key='_" . $newMetaKey . "',
                    meta_value='" . $newMetaValue . "' 
                        WHERE post_id='" . $post->ID . "' 
                        AND meta_key='_" . $currentMetaKey . "' 
                        AND meta_value='" . $currentMetaValue . "'";
                $wpdb->query($query);
                
                $query = "UPDATE " . $wpdb->prefix . "postmeta SET	
                    meta_key='" . $newMetaKey . "'
                    WHERE post_id='" . $post->ID . "' AND meta_key='" . $currentMetaKey . "'";
                $wpdb->query($query);
                
                // post neu lesen
                $post = get_post($productPostId);
            }
        }
    }
}

$postMetaValues = array();
$postMetaKeys = array();

if ($post != null) {
    
    $res = $wpdb->get_results('SELECT meta_key,meta_value FROM ' . $wpdb->prefix . 'postmeta WHERE post_id="' . $post->ID . '" ', OBJECT);
    if (count($res) > 0) {
        foreach ($res as $val) {
            $postMetaValues[] = $val->meta_value;
            $postMetaKeys[] = $val->meta_key;
        }
    }
    
    foreach ($apProductIdFieldPartners as $apProductIdFieldKey => $apProductIdFieldValues) {
        
        if (in_array($apProductIdFieldKey, $postMetaValues)) {
            
            $apProductIdField = array(
                'key' => $apProductIdFieldKey,
                'label' => $apProductIdFieldValues['label'],
                'name' => $apProductIdFieldValues['name']
            );
            break;
        }
    }
}

if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != null) {
    $parsedUrl = parse_url($_SERVER['HTTP_REFERER']);
    if (isset($parsedUrl['query']) && $parsedUrl['query'] != "") {
        $query = $parsedUrl['query'];
        if (strstr($query, 'action=edit')) {
            
            $newMetaKeyArray = array();
            foreach ($acfComparisonAttributes as $acfComparisonAttribute) {
                
                $metaKey = 'comparisonAttributes_0_' . $acfComparisonAttribute['name'];
                $metaKey_ = '_comparisonAttributes_0_' . $acfComparisonAttribute['name'];
                
                $newMetaKeyArray[] = $metaKey;
                $newMetaKeyArray[] = $metaKey_;
                
                foreach ($postMetaKeys as $postMetaKey) {
                    if (stristr($postMetaKey, $metaKey) || stristr($postMetaKey, $metaKey_)) {
                        $newMetaKeyArray[] = $postMetaKey;
                    }
                }
            }
            $newMetaKeyArray = array_unique($newMetaKeyArray);
            $newMetaKeys = "'_comparisonAttributes','comparisonAttributes','";
            $newMetaKeys .= implode("','", $newMetaKeyArray);
            $newMetaKeys .= "'";
            
            if (strlen($newMetaKeys) > 4) {
                
                $query = ' DELETE FROM ' . $wpdb->prefix . 'postmeta WHERE
                    meta_key LIKE "%comparisonAttributes%" AND post_id="' . $post->ID . '"
                        AND meta_key NOT IN (' . $newMetaKeys . ') ';
                $wpdb->query($query);
            }
        }
    }
}
if (isset($acfProductImages) && count($acfProductImages) > 0) {
    //
}

add_action('acf/save_post', 'save_acf_gallery_images', 20);

function save_acf_gallery_images($post_id)
{
    $postImages = get_children(array(
        'post_parent' => $post_id,
        'post_type' => 'attachment',
        'post_mime_type' => 'image'
    ));
    
    $galleryImages = get_field('product_gallery', $post_id);
    
    $acfImageIds = array();
    
    if (is_array($galleryImages) && count($galleryImages) > 0) {
        
        $menuOrder = 0;
        
        foreach ($galleryImages as $galleryImage) {
            $acfImageId = $galleryImage['ID'];
            
            if ($acfImageId > 0) {
                
                if ($menuOrder == 0) {
                    if (get_post_meta($postId, '_thumbnail_id', TRUE) != 'by_url' && get_post_meta($postId, '_external_thumbnail_url', TRUE) == '') {
                        update_post_meta($post_id, '_thumbnail_id', $acfImageId);
                    }
                }
                
                wp_update_post(array(
                    'ID' => $acfImageId,
                    'post_parent' => $post_id,
                    'menu_order' => $menuOrder
                ));
                
                $menuOrder ++;
                
                array_push($acfImageIds, $acfImageId);
            }
        }
    }
    
    $unattachedImages = array_diff(array_keys($postImages), $acfImageIds);
    
    if (is_array($unattachedImages) && count($unattachedImages) > 0) {
        foreach ($unattachedImages as $unattachedImage) {
            
            wp_update_post(array(
                'ID' => $unattachedImage,
                'post_parent' => 0,
                'menu_order' => 0
            ));
            
            delete_post_meta($post_id, '_thumbnail_id', $unattachedImage);
        }
    }
}

if ($post != null && isset($post->ID) && $post->ID != "") {
    
    $activePlugins = get_option('active_plugins');
    if (is_array($activePlugins) && count($activePlugins) > 0) {
        foreach ($activePlugins as $key => $value) {
            $activePlugin = explode('/', $value);
            
            if (isset($activePlugin[0]) && $activePlugin[0] == 'wordpress-seo') {
                
                wp_enqueue_script('acf_yoast_script', get_template_directory_uri() . '/library/admin/js/yoast_acf.js');
                
                wp_localize_script('acf_yoast_script', 'ays_settings', array(
                    'url' => get_template_directory_uri() . '/library/yoastGetAcfFieldsData.php',
                    'postId' => $post->ID
                ));
                
                break;
            }
        }
    }
}

$first_attr_checklist_name = $affiliseo_options['comparison_first_attribute_name'];
$first_attr_checklist_value = $affiliseo_options['comparison_first_attribute_value'];
$first_attr_checklist_arr = comparison_array($first_attr_checklist_value, 'Vergleichstabelle 1. Attribut (Bei einem Ja/Nein-Attribut bedeutet ein Häkchen "JA" und kein Häkchen "NEIN". Bei einem Textfeld wird der Text ausgegeben.):<br />' . $first_attr_checklist_name, 'field_first_attr_checklist', 'first_attr_checklist_content');

$second_attr_checklist_name = $affiliseo_options['comparison_second_attribute_name'];
$second_attr_checklist_value = $affiliseo_options['comparison_second_attribute_value'];
$second_attr_checklist_arr = comparison_array($second_attr_checklist_value, 'Vergleichstabelle 2. Attribut (Bei einem Ja/Nein-Attribut bedeutet ein Häkchen "JA" und kein Häkchen "NEIN". Bei einem Textfeld wird der Text ausgegeben.):<br />' . $second_attr_checklist_name, 'field_second_attr_checklist', 'second_attr_checklist_content');

$third_attr_checklist_name = $affiliseo_options['comparison_third_attribute_name'];
$third_attr_checklist_value = $affiliseo_options['comparison_third_attribute_value'];
$third_attr_checklist_arr = comparison_array($third_attr_checklist_value, 'Vergleichstabelle 3. Attribut (Bei einem Ja/Nein-Attribut bedeutet ein Häkchen "JA" und kein Häkchen "NEIN". Bei einem Textfeld wird der Text ausgegeben.):<br />' . $third_attr_checklist_name, 'field_third_attr_checklist', 'third_attr_checklist_content');

$fourth_attr_checklist_name = $affiliseo_options['comparison_fourth_attribute_name'];
$fourth_attr_checklist_value = $affiliseo_options['comparison_fourth_attribute_value'];
$fourth_attr_checklist_arr = comparison_array($fourth_attr_checklist_value, 'Vergleichstabelle 4. Attribut (Bei einem Ja/Nein-Attribut bedeutet ein Häkchen "JA" und kein Häkchen "NEIN". Bei einem Textfeld wird der Text ausgegeben.):<br />' . $fourth_attr_checklist_name, 'field_fourth_attr_checklist', 'fourth_attr_checklist_content');

$fifth_attr_checklist_name = $affiliseo_options['comparison_fifth_attribute_name'];
$fifth_attr_checklist_value = $affiliseo_options['comparison_fifth_attribute_value'];
$fifth_attr_checklist_arr = comparison_array($fifth_attr_checklist_value, 'Vergleichstabelle 5. Attribut (Bei einem Ja/Nein-Attribut bedeutet ein Häkchen "JA" und kein Häkchen "NEIN". Bei einem Textfeld wird der Text ausgegeben.):<br />' . $fifth_attr_checklist_name, 'field_fifth_attr_checklist', 'fifth_attr_checklist_content');

global $number_of_attributes;
$number_of_attributes = 4;
if (isset($affiliseo_options['number_of_attributes'])) {
    $number_of_attributes = intval($affiliseo_options['number_of_attributes']);
    if ($number_of_attributes <= 0 || $number_of_attributes >= 100) {
        $number_of_attributes = 4;
    }
}

$attribute_arrays = array();
$m = 0;
for ($n = 0; $n < (intval($number_of_attributes) * 2); $n ++) {
    $attribute_array = array();
    if ($n % 2 == 0) {
        $attribute_array = array(
            'key' => 'field_aaeaeeaa' . $m . 'a',
            'label' => ($m + 1) . '. Zusatzattribut - Titel',
            'name' => 'attribute_' . $m . '_title',
            'type' => 'text',
            'instructions' => 'Möchten Sie ein zusätzliches Attribut für diesen Artikel? Wenn ja, wie soll es heißen?',
            'required' => 0,
            'default_value' => '',
            'placeholder' => 'Attributsbezeichnung',
            'prepend' => '',
            'append' => '',
            'formatting' => 'html',
            'maxlength' => ''
        );
    } else {
        $attribute_array = array(
            'key' => 'field_aaeaeeaa' . $m . 'b',
            'label' => ($m + 1) . '. Zusatzattribut - Wert',
            'name' => 'attribute_' . $m . '_content',
            'type' => 'text',
            'instructions' => 'Wie lautet der Wert des Attributs?',
            'required' => 0,
            'default_value' => '',
            'placeholder' => 'Attributswert',
            'prepend' => '',
            'append' => '',
            'formatting' => 'html',
            'maxlength' => ''
        );
        $m ++;
    }
    array_push($attribute_arrays, $attribute_array);
}

function comparison_array($attr_checklist_value, $attr_checklist_name, $key_name, $attr_name)
{
    $attr_checklist_arr = array();
    $attr_checklist_type = 'text';
    if ($attr_checklist_value == '1') {
        $attr_checklist_type = 'true_false';
    }
    if (trim($attr_checklist_name) != '') {
        $attr_checklist_arr = array(
            'key' => $key_name,
            'label' => $attr_checklist_name,
            'name' => $attr_name,
            'type' => $attr_checklist_type
        );
    }
    return $attr_checklist_arr;
}

if (function_exists("register_field_group")) {
    
    global $apProductIdField;
    
    $fields_array = array(
        array(
            'key' => 'field_layout',
            'label' => 'Layout',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'placement' => 'top'
        ),
        array(
            'key' => 'field_hide_headline',
            'label' => 'Überschrift ausblenden',
            'name' => 'hide_product_headline',
            'type' => 'true_false',
            'message' => 'Überschrift ausblenden? Diese Einstellung überschreibt die Einstellungen unter "AffiliateTheme - Layout Manager".',
            'default_value' => 0
        ),
        array(
            'key' => 'field_comments',
            'label' => 'Kommentare einblenden (Kommentare können nicht unter "Diskussion" aktiviert werden!)',
            'name' => 'commtents_product',
            'type' => 'true_false'
        ),
        
        array(
            'key' => 'field_product_gallery',
            'label' => 'Produktbilder',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'placement' => 'top'
        ),
        
        array(
            'key' => 'field_ang6ca8oosh8ee',
            'label' => 'Produktbilder verwalten',
            'name' => 'product_gallery',
            'type' => 'gallery',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'min' => '',
            'max' => '',
            'preview_size' => 'thumbnail',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => ''
        ),
        
        array(
            'key' => 'acfp_iengahm3ohheed',
            'label' => 'Externe Bilder',
            'name' => 'external_images',
            'type' => 'repeater',
            'required' => 0,
            'conditional_logic' => 0,
            'min' => 1,
            'max' => 100,
            'layout' => 'row',
            'button_label' => 'Bild hinzufügen',
            'wrapper' => array(
                'data-append' => 'wrapper'
            ),
            'sub_fields' => array(
                array(
                    'key' => 'acfp_jahsiegiach5ch',
                    'label' => 'Link',
                    'name' => 'image_url',
                    'type' => 'text',
                    'message' => '',
                    'required' => 0
                ),
                array(
                    'key' => 'acfp_aerieyeiphee2s',
                    'label' => 'Titel',
                    'name' => 'image_title',
                    'type' => 'text',
                    'message' => '',
                    'required' => 0
                )
            )
        ),
        
        array(
            'key' => 'field_product_features',
            'label' => 'Produkteigenschaften',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'placement' => 'top'
        ),
        
        array(
            'key' => 'new_ap_product_id_name',
            'label' => 'Affiliatepartner &auml;ndern',
            'name' => 'new_ap_product_id_name',
            'type' => 'select',
            'required' => 0,
            'choices' => $apSelectList,
            'default_value' => '',
            'allow_null' => 0,
            'multiple' => 0
        ),
        
        array(
            'key' => $apProductIdField['key'],
            'label' => $apProductIdField['label'],
            'name' => $apProductIdField['name'],
            'type' => 'text',
            'required' => 0,
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'html',
            'maxlength' => ''
        ),
        
        array(
            'key' => 'field_ean',
            'label' => 'EAN',
            'name' => 'ean',
            'type' => 'text',
            'instructions' => 'Eine EAN muss für jedes Produkt angegeben werden. Wenn Sie keine EAN zur Verfügung haben, tragen Sie bitte eine 0 ein. ' . 'Wenn Sie mehrere EANs zur Verfügung haben, trennen Sie diese bitte mit einem Komma.',
            'required' => 1
        ),
        array(
            'key' => 'field_52ac95ff06264',
            'label' => 'Sterne Bewertung',
            'name' => 'sterne_bewertung',
            'type' => 'select',
            'required' => 1,
            'choices' => array(
                0 => 'keine Bewertung',
                '0.5' => '0,5 Sterne',
                1 => '1 Stern',
                '1.5' => '1,5 Sterne',
                2 => '2 Sterne',
                '2.5' => '2,5 Sterne',
                3 => '3 Sterne',
                '3.5' => '3,5 Sterne',
                4 => '4 Sterne',
                '4.5' => '4,5 Sterne',
                5 => '5 Sterne'
            ),
            'default_value' => '',
            'allow_null' => 0,
            'multiple' => 0
        ),
        array(
            'key' => 'field_internal_review_value',
            'label' => 'Interne Bewertung',
            'name' => 'interne_bewertung',
            'type' => 'select',
            'required' => 1,
            'choices' => array(
                20 => '20 - sehr gut',
                19 => '19',
                18 => '18',
                17 => '17',
                16 => '16',
                15 => '15',
                14 => '14',
                13 => '13',
                12 => '12',
                11 => '11',
                10 => '10',
                9 => '9',
                8 => '8',
                7 => '7',
                6 => '6',
                5 => '5',
                4 => '4',
                3 => '3',
                2 => '2',
                1 => '1 - sehr schlecht',
                'keine Bewertung' => 'keine Bewertung'
            ),
            'default_value' => 'keine Bewertung',
            'allow_null' => 0,
            'multiple' => 0
        ),
        array(
            'key' => 'field_price',
            'label' => __('Price', 'affiliatetheme'),
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'placement' => 'top'
        ),
        array(
            'key' => 'field_52ac963f06265',
            'label' => __('Price', 'affiliatetheme'),
            'name' => 'preis',
            'type' => 'text',
            'required' => 0,
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'min' => 0,
            'max' => '',
            'step' => ''
        ),
        array(
            'key' => 'field_uvp',
            'label' => 'UVP',
            'name' => 'uvp',
            'type' => 'text',
            'required' => 0,
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'min' => 0,
            'max' => '',
            'step' => ''
        ),
        array(
            'key' => 'field_price_type',
            'label' => 'Preistyp (hat nur Relevanz bei von Amazon importieren Produkten)',
            'name' => 'price_type',
            'type' => 'select',
            'required' => 0,
            'choices' => array(
                '' => 'kein Preistyp ausgewählt',
                'lowest_new' => 'Niedrigster Preis',
                'lowest_used' => 'Niedrigster Preis, gebraucht',
                'list' => 'Listenpreis',
                'price' => 'Unverbindliche Preisempfehlung'
            ),
            'instructions' => 'Der Preistyp legt fest, welcher Preis von Amazon importiert werden soll. Dies ist wichtig, wenn zB bei einem oder mehreren der vier Preistypen 0,00 € von Amazon übergeben werden.',
            'allow_null' => 0,
            'multiple' => 0
        ),
        
        array(
            'key' => 'field_affiliate',
            'label' => 'Affiliate-Link',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            )
        ),
        
        array(
            'key' => 'ap_pdp_button',
            'label' => 'Affiliate - Button',
            'name' => 'ap_pdp_button',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'html',
            'maxlength' => ''
        ),
        
        array(
            'key' => 'field_52ac9d1b7e2fc',
            'label' => 'Affiliate - Link',
            'name' => 'ap_pdp_link',
            'type' => 'text',
            'instructions' => 'Die URL bitte immer mit http:// angeben.',
            'required' => 1,
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'html',
            'maxlength' => ''
        ),
        array(
            'key' => 'field_5cart',
            'label' => 'Affiliate "' . __('Add to cart', 'affiliatetheme') . '" - Link',
            'name' => 'ap_cart_link',
            'type' => 'text',
            'instructions' => 'Die URL bitte immer mit http:// angeben.',
            'required' => 0,
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'html',
            'maxlength' => ''
        ),
        array(
            'key' => 'field_52a13das1de2fc',
            'label' => 'Weiterer Button in der Übersicht (Text)',
            'name' => 'third_link_text',
            'type' => 'text',
            'instructions' => 'Wie soll der Button beschriftet werden?',
            'required' => 0,
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'html',
            'maxlength' => ''
        ),
        array(
            'key' => 'field_52ac9131de2fc',
            'label' => 'Link des Buttons',
            'name' => 'third_link_url',
            'type' => 'text',
            'instructions' => 'Die URL bitte immer mit http:// angeben.',
            'required' => 0,
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'html',
            'maxlength' => ''
        ),
        array(
            'key' => 'field_review',
            'label' => 'Testbericht',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'placement' => 'top'
        ),
        array(
            'key' => 'field_52adc416f1b0b',
            'label' => 'Testbericht',
            'name' => 'testbericht',
            'type' => 'wysiwyg',
            'default_value' => '',
            'toolbar' => 'full',
            'media_upload' => 'yes'
        ),
        array(
            'key' => 'field_excerpt',
            'label' => 'Auszug',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'placement' => 'top'
        ),
        array(
            'key' => 'field_6excerpt',
            'label' => 'Auszug',
            'name' => 'excerpt_product',
            'type' => 'textarea',
            'instructions' => 'Soll in der Produktvorschau ein Auszug angezeigt werden?',
            'required' => 0,
            'default_value' => '',
            'prepend' => '',
            'append' => '',
            'formatting' => 'html'
        ),
        array(
            'key' => 'product_review',
            'label' => 'Reviews',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'placement' => 'top'
        ),
        
        // START - PRODUCT REVIEWS
        array(
            'key' => 'product_review_ratings',
            'label' => 'Bewertungen',
            'name' => 'ProductReviewRatings',
            'type' => 'repeater',
            'instructions' => '<a href="http://affiliseo.de/produkte/review-produktbewertung/" target="_blank" class="link-affiliseo">' . '<i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Anleitung auf AffiliSEO.de</a>',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'min' => '',
            'max' => '',
            'layout' => 'table',
            'button_label' => 'Eintrag hinzufügen',
            'sub_fields' => array(
                array(
                    'key' => 'product_review_property',
                    'label' => 'Eigenschaft',
                    'name' => 'product_review_property',
                    'type' => 'text',
                    'instructions' => 'z.B.: Akkulaufzeit',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => ''
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                    'readonly' => 0,
                    'disabled' => 0
                ),
                array(
                    'key' => 'product_review_percentage',
                    'label' => 'Wert in %',
                    'name' => 'product_review_percentage',
                    'type' => 'number',
                    'instructions' => 'von 1 bis 100',
                    'required' => 1,
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => 0,
                    'max' => 100,
                    'step' => '1.0',
                    'readonly' => 0,
                    'disabled' => 0
                ),
                array(
                    'key' => 'product_review_hint',
                    'label' => 'Zusaetzlicher Hinweis',
                    'name' => 'product_review_hint',
                    'type' => 'text',
                    'instructions' => 'z.B.: sehr gut',
                    'required' => 0,
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                    'readonly' => 0,
                    'disabled' => 0
                )
            )
        ),
        array(
            'key' => 'product_review_summary',
            'label' => 'Zusammenfassung',
            'name' => 'ProductReviewSummary',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'message' => 'Soll eine Zusammenfassung platziert werden?',
            'default_value' => 0
        ),
        
        array(
            'key' => 'product_review_text',
            'label' => 'Zusammenfassung:',
            'name' => 'ProductReviewText',
            'type' => 'textarea',
            'instructions' => 'z.B: Sehr gutes Produkt im Test 2016',
            'required' => 0,
            'conditional_logic' => array(
                
                array(
                    
                    array(
                        'field' => 'product_review_summary',
                        'operator' => '==',
                        'value' => '1'
                    )
                )
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'default_value' => '',
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 0
        ),
        array(
            'key' => 'product_review_text_area',
            'label' => 'Abschlusstext',
            'name' => 'ProductReviewTextArea',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'message' => 'Soll eine Abschlusstext platziert werden?',
            'default_value' => 0
        ),
        
        array(
            'key' => 'product_review_wysiwyg',
            'label' => 'Abschlusstext',
            'name' => 'ProductReviewWysiwyg',
            'type' => 'wysiwyg',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => array(
                
                array(
                    
                    array(
                        'field' => 'product_review_text_area',
                        'operator' => '==',
                        'value' => '1'
                    )
                )
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'default_value' => '',
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 'yes'
        ),
        
        // END - PRODUCT REVIEWS
        
        array(
            'key' => 'field_comparison_chart',
            'label' => 'Vergleichstabelle',
            'name' => '',
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => ''
            ),
            'placement' => 'top'
        )
    );
    
    if (isset($post->ID) && intval($post->ID) == 0) {
        foreach ($apProductIdFieldPartners as $partnerKey => $parnerValue) {
            $afPartner = array(
                'key' => $partnerKey,
                'label' => '',
                'name' => $parnerValue['name'],
                'type' => 'text'
            );
            array_push($fields_array, $afPartner);
        }
    }
    
    array_push($fields_array, $first_attr_checklist_arr);
    array_push($fields_array, $second_attr_checklist_arr);
    array_push($fields_array, $third_attr_checklist_arr);
    array_push($fields_array, $fourth_attr_checklist_arr);
    array_push($fields_array, $fifth_attr_checklist_arr);
    
    array_push($fields_array, array(
        'key' => 'field_highlight',
        'label' => 'Vergleichstabelle:<br />Produkt als Empfehlung',
        'name' => 'highlight_product',
        'type' => 'true_false'
    ));
    
    array_push($fields_array, array(
        'key' => 'comparison_attributes_tab',
        'label' => 'Vergleichstabelle(Neu)',
        'name' => '',
        'type' => 'tab',
        'required' => 0,
        'conditional_logic' => 0,
        'placement' => 'top'
    ), array(
        'key' => 'comparison_highlighted_column',
        'label' => 'Produkthervorhebung',
        'name' => 'comparisonHighlightedColumn',
        'type' => 'true_false',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'message' => 'Soll das Produkt hervorgehoben werden?',
        'default_value' => 0
    ), 

    array(
        'key' => 'comparison_highlighted_column_headline',
        'label' => 'Überschrift',
        'name' => 'comparisonHighlightedColumnHeadline',
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => array(
            array(
                array(
                    'field' => 'comparison_highlighted_column',
                    'operator' => '==',
                    'value' => '1'
                )
            )
        )
    ), 

    array(
        'key' => 'comparison_highlighted_column_color',
        'label' => 'Textfarbe',
        'name' => 'comparisonHighlightedColumnColor',
        'type' => 'color_picker',
        'instructions' => '',
        'required' => 0,
        'default_value' => '#000000',
        'conditional_logic' => array(
            array(
                array(
                    'field' => 'comparison_highlighted_column',
                    'operator' => '==',
                    'value' => '1'
                )
            )
        )
    ), 

    array(
        'key' => 'comparison_highlighted_column_bg_color',
        'label' => 'Hintergrundfarbe',
        'name' => 'comparisonHighlightedColumnBgColor',
        'type' => 'color_picker',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => array(
            array(
                array(
                    'field' => 'comparison_highlighted_column',
                    'operator' => '==',
                    'value' => '1'
                )
            )
        )
    ));
    
    if (is_array($acfComparisonAttributes) && count($acfComparisonAttributes) > 0) {
        array_push($fields_array, array(
            'key' => 'comparison_attributes',
            'label' => 'Vergleichsattribute',
            'name' => 'comparisonAttributes',
            'type' => 'repeater',
            'placement' => 'top',
            'sub_fields' => $acfComparisonAttributes,
            'min' => 1,
            'max' => 1,
            'layout' => 'row'
        ));
    }
    
    array_push($fields_array, array(
        'key' => 'field_additional_attribute',
        'label' => 'Zusatzattribute',
        'name' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => ''
        ),
        'placement' => 'top'
    ));
    
    foreach ($attribute_arrays as $attribute_array) {
        array_push($fields_array, $attribute_array);
    }
    
    register_field_group(teaserSliderFields('produkt'));
    
    register_field_group(array(
        'id' => 'acf_eigenschaften-fuer-dieses-produkt',
        'title' => 'Eigenschaften für dieses Produkt',
        'fields' => $fields_array,
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'produkt',
                    'order_no' => 0,
                    'group_no' => 0
                )
            )
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array()
        ),
        'menu_order' => 0
    ));
    
    register_field_group(teaserSliderFields('page'));
    
    $fields_array_page = array(
        array(
            'key' => 'field_hide_headline_page',
            'label' => 'Überschrift ausblenden',
            'name' => 'hide_page_headline',
            'type' => 'true_false',
            'message' => 'Überschrift ausblenden? Diese Einstellung überschreibt die Einstellungen unter "AffiliateTheme - Layout Manager".',
            'default_value' => 0
        )
    );
    
    register_field_group(array(
        'id' => 'acf_eigenschaften-fuer-diese-seite',
        'title' => 'Eigenschaften für diese Seite',
        'fields' => $fields_array_page,
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                    'order_no' => 0,
                    'group_no' => 0
                )
            )
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array()
        ),
        'menu_order' => 0
    ));
    
    register_field_group(teaserSliderFields('post'));
    
    $fields_array_article = array(
        array(
            'key' => 'field_hide_headline_article',
            'label' => 'Überschrift ausblenden',
            'name' => 'hide_article_headline',
            'type' => 'true_false',
            'message' => 'Überschrift ausblenden? Diese Einstellung überschreibt die Einstellungen unter "AffiliateTheme - Layout Manager".',
            'default_value' => 0
        )
    );
    
    register_field_group(array(
        'id' => 'acf_eigenschaften-fuer-diesen-beitrag',
        'title' => 'Eigenschaften für diesen Beitrag',
        'fields' => $fields_array_article,
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                    'order_no' => 0,
                    'group_no' => 0
                )
            )
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array()
        ),
        'menu_order' => 0
    ));
}
// Diesen Aufruf zu entfernen ist rechtswidrig. Dies wird sofort zur Anzeige gebracht!
add_action('wp_head', 'sendamail');
if (function_exists("register_field_group")) {
    register_field_group(array(
        'id' => 'acf_slider',
        'title' => 'Slider',
        'fields' => array(
            array(
                'key' => 'field_slidertext',
                'label' => 'Text',
                'name' => 'slider_text',
                'type' => 'textarea',
                'instructions' => 'Soll dieser Slider einen Text beinhalten? (Maximal 100 Zeichen)',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '100'
            ),
            array(
                'key' => 'field_5386029cbf9a2',
                'label' => 'Link',
                'name' => 'slider_link',
                'type' => 'text',
                'instructions' => 'Soll dieser Slider auf eine bestimmte Seite/URL verlinken? Bitte mit "http://" angeben.',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => ''
            ),
            array(
                'key' => 'field_53860371bc4a7',
                'label' => 'Externer Link',
                'name' => 'slider_externer_link',
                'type' => 'true_false',
                'instructions' => 'Handelt es sich hierbei um einen externen Link? Falls ja, kann dieser durch diese Option in einem neuen Fenster geöffnet weren.',
                'message' => 'Im neuen Fenster öffnen',
                'default_value' => 0
            ),
            array(
                'key' => 'field_538dbd9e82f05',
                'label' => 'Nofollow',
                'name' => 'slider_nofollow',
                'type' => 'true_false',
                'instructions' => 'Soll dieser Link mit "nofollow" markiert werden?',
                'message' => 'nofollow hinzufügen',
                'default_value' => 0
            )
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'slideshow',
                    'order_no' => 0,
                    'group_no' => 0
                )
            )
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array()
        ),
        'menu_order' => 0
    ));
}

function teaserSliderFields($postType)
{
    $keyPrefix = 'ts_' . $postType . '_';
    
    return array(
        'id' => 'group_' . $keyPrefix . 'teaser_slider',
        'title' => __('Teaser-Slider', 'affiliatetheme'),
        'fields' => array(
            array(
                'key' => $keyPrefix . 'tohng9ohng5cae',
                'label' => __('Carousel-Indicator', 'affiliatetheme'),
                'name' => $keyPrefix . 'carousel_indicator',
                'type' => 'true_false',
                'message' => __('fade in', 'affiliatetheme') . '.<br />' . __('Should the carousel indicator buttons be displayed?', 'affiliatetheme'),
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => 25,
                    'class' => '',
                    'id' => ''
                ),
                'default_value' => 0,
                'layout' => 'table'
            ),
            array(
                'key' => $keyPrefix . 'ivouboofaeloo9',
                'label' => __('Carousel-Control', 'affiliatetheme'),
                'name' => $keyPrefix . 'carousel_control',
                'type' => 'true_false',
                'message' => __('fade in', 'affiliatetheme') . '.<br />' . __('Should the carousel control buttons be displayed?', 'affiliatetheme'),
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => 25,
                    'class' => '',
                    'id' => ''
                ),
                'default_value' => 0,
                'layout' => 'table'
            ),
            array(
                'key' => $keyPrefix . 'mewafahheihae5',
                'label' => __('Slide-Effect', 'affiliatetheme'),
                'name' => $keyPrefix . 'slide_effect',
                'type' => 'select',
                'required' => 0,
                'choices' => array(
                    'slideLeftRight' => __('Slide right to left', 'affiliatetheme'),
                    'slideFade' => __('Slide fade out', 'affiliatetheme')
                )
                ,
                'wrapper' => array(
                    'width' => 25,
                    'class' => '',
                    'id' => ''
                ),
                'default_value' => 'slideLeftRight',
                'multiple' => 0,
                'layout' => 'table'
            ),
            
            array(
                'key' => $keyPrefix . 'rie3sahchaicho',
                'label' => __('Data interval', 'affiliatetheme'),
                'name' => $keyPrefix . 'data_interval',
                'type' => 'number',
                'instructions' => __('Waiting time in milliseconds for the automatic cycle.', 'affiliatetheme'),
                'required' => 1,
                'wrapper' => array(
                    'width' => 25,
                    'class' => '',
                    'id' => ''
                ),
                'default_value' => 5000,
                'min' => 100,
                'max' => 20000,
                'step' => 1,
                'readonly' => 0,
                'disabled' => 0
            ),
            
            array(
                'key' => $keyPrefix . 'equeivoucee3ru',
                'label' => __('Images', 'affiliatetheme'),
                'name' => $keyPrefix . 'slideshow_images',
                'type' => 'repeater',
                'conditional_logic' => 0,
                'min' => 1,
                'max' => 100,
                'layout' => 'row',
                'button_label' => __('Add image', 'affiliatetheme'),
                'required' => 0,
                'sub_fields' => array(
                    
                    array(
                        'key' => $keyPrefix . 'jush8ul8Sheeg9',
                        'label' => __('Background color', 'affiliatetheme'),
                        'name' => $keyPrefix . 'image_bgc',
                        'type' => 'color_picker',
                        'instructions' => '',
                        'conditional_logic' => 0,
                        'default_value' => ''
                    ),
                    array(
                        'key' => $keyPrefix . 'beikoot4ahqu4t',
                        'label' => __('Image', 'affiliatetheme'),
                        'name' => $keyPrefix . 'slideshow_image',
                        'type' => 'image',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'return_format' => 'array',
                        'preview_size' => 'thumbnail',
                        'library' => 'all'
                    ),
                    array(
                        'key' => $keyPrefix . 'ieBichahbahv9a',
                        'label' => __('Text', 'affiliatetheme'),
                        'name' => $keyPrefix . 'text_on_image',
                        'type' => 'wysiwyg',
                        'instructions' => __('Should this slider contain a text?', 'affiliatetheme'),
                        'tabs' => 'all',
                        'toolbar' => 'full',
                        'media_upload' => 0
                    ),
                    array(
                        'key' => $keyPrefix . 'ing6saov7eiqu1',
                        'label' => __('Link', 'affiliatetheme'),
                        'name' => $keyPrefix . 'slideshow_link',
                        'type' => 'text',
                        'placeholder' => sprintf(__('Should this slider be linked to a specific page/URL? Please specify %s', 'affiliatetheme'), 'https://')
                    ),
                    array(
                        'key' => $keyPrefix . 'hi8ich7jaithee',
                        'label' => __('External Link', 'affiliatetheme'),
                        'name' => $keyPrefix . 'is_extern_link',
                        'type' => 'true_false',
                        'message' => __('Open in a new window.', 'affiliatetheme') . '<br />' . __('Is this an external link?', 'affiliatetheme') . ' ' . __('If so, this option can be opened in a new window.', 'affiliatetheme'),
                        'conditional_logic' => 0,
                        'default_value' => 0
                    ),
                    array(
                        'key' => $keyPrefix . 'oi1ad3ahgowaes',
                        'label' => __('Nofollow', 'affiliatetheme'),
                        'name' => $keyPrefix . 'use_nofollow',
                        'type' => 'true_false',
                        'message' => __('add nofollow.', 'affiliatetheme') . '<br />' . __("Should this link be marked with \"nofollow\"?", 'affiliatetheme'),
                        'conditional_logic' => 0,
                        'default_value' => 0
                    )
                )
            )
        ),
        
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => $postType
                )
            )
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            'group_' . $keyPrefix . 'teaser_slider'
        )
    );
}
