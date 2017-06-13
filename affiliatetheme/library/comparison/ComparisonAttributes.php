<?php

class ComparisonAttributes
{

    private $wpdb;

    private $tableName;

    private $affiliseoOptions = array();

    function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->tableName = $this->wpdb->prefix . 'comparison_attributes';
        $this->createComparisonAttributesTable();
        $this->affiliseoOptions = getAffiliseoOptions();
    }

    public function getComparisonAttributeGroups($taxonomySlug = 'all')
    {
        if ($taxonomySlug == 'all') {
            $criteriaSlug = '';
        } elseif ($taxonomySlug != null) {
            $criteriaSlug = ' AND (taxonomy_slug=-1 OR taxonomy_slug="' . $taxonomySlug . '" ) ';
        } else {
            $criteriaSlug = ' AND taxonomy_slug=-1 ';
        }
        
        $ret = array();
        $res = $this->wpdb->get_results('SELECT * FROM ' . $this->tableName . ' 
            WHERE type="attributeGroup"
            ' . $criteriaSlug . '
            AND belongs_to="-1"
            ORDER BY sort_order,label ', OBJECT);
        if (count($res) > 0) {
            foreach ($res as $val) {
                $ret[] = $val;
            }
        }
        
        return $ret;
    }

    public function getComparisonAttributes($belongsTo)
    {
        $comparisonAttributes = array();
        $res = $this->wpdb->get_results('SELECT * FROM ' . $this->tableName . ' 
            WHERE type !="attributeGroup" 
            AND belongs_to="' . $belongsTo . '" 
            ORDER BY sort_order,label ', OBJECT);
        if (count($res) > 0) {
            foreach ($res as $val) {
                $comparisonAttributes[] = $val;
            }
        }
        
        return $comparisonAttributes;
    }

    public function getAttribute($attributeId)
    {
        $res = $this->wpdb->get_results('SELECT * FROM ' . $this->tableName . '
            WHERE id="' . $attributeId . '" ', OBJECT);
        return $res[0];
    }

    public function getAttributeValue($attributeId, $postId)
    {
        $attribute = $this->getAttribute($attributeId);
        
        $metaKey = 'comparisonAttributes_0_attribute-' . $attributeId;
        if ($field = get_field($metaKey, $postId, false)) {} else {
            $field = '';
        }
        
        if (! is_array($field)) {
            $field = str_replace(array(
                "<p>",
                "</p>",
                "<br>",
                "</br>",
                "<br />"
            ), array(
                "",
                "",
                "",
                "",
                ""
            ), $field);
            $field = nl2br($field);
        }
        
        switch ($attribute->type) {
            case 'priceCompare':
                $field = $this->getPriceCompareValue($postId);
                break;
            case 'starRating':
                $field = $this->getStarRatingValue($postId);
                break;
            case 'pdpButton':
                $field = $this->getPdpButtonValue($postId);
                break;
            case 'apButton':
                $field = $this->getApButtonValue($postId);
                break;
            case 'productImage':
                $field = $this->getProductImageValue($postId);
                break;
            case 'productTitle':
                $field = $this->getproductTitleValue($postId);
                break;
            case 'productReview':
                $field = $this->getProductReviewValue($postId);
                break;
            case 'productPrice':
                $field = $this->getProductPriceValue($postId);
                break;
            case 'productUvpPrice':
                $field = $this->getProductUvpPriceValue($postId);
                break;
            case 'date':
                if ($field != "") {
                    $field = date('d.m.Y', strtotime($field));
                } else {
                    $field = '';
                }
                
                break;
            case 'checkbox':
                $field = $this->getCheckboxValue($field);
                break;
            case 'negativeList':
            case 'positiveList':
                
                $listValues = array();
                if (is_array($field) && count($field) > 0) {
                    foreach ($field as $repeaterElemArray) {
                        
                        $repeaterElem = array_values($repeaterElemArray);
                        $listValues[] = $repeaterElem[0];
                    }
                }
                
                $field = $this->getListValues($listValues, $attribute->type);
                break;
            default:
        }
        
        return $field;
    }

    public function getListValues($listValues, $attributeType)
    {
        $ret = '';
        $listIconClass = ($attributeType == 'negativeList') ? 'fa-minus-circle list-elem-negative' : 'fa-plus-circle list-elem-positive';
        foreach ($listValues as $listValue) {
            $ret .= '<small><i class="fa ' . $listIconClass . '"></i> ' . $listValue . '</small><br class="list-elements-br" />';
        }
        return $ret;
    }

    public function getCheckboxValue($value)
    {
        $ret = '';
        
        if (is_string($value)) {
            
            $checkboxClass = ($value == 1) ? 'fa-check-circle checkbox-positive' : 'fa-times-circle checkbox-negative';
            $ret .= '<i style="text-align:center; width:100%;" class="fa ' . $checkboxClass . '"></i>';
        }
        
        return $ret;
    }

    public function getProductPriceValue($postId, $displayTax = true)
    {
        $ret = '';
        
        if ($this->affiliseoOptions['allg_preise_ausblenden'] != 1) {
            global $pos_currency, $currency_string, $text_tax;
            
            $price = get_field('preis', $postId);
            
            $ret .= '<span class="price">';
            
            if (trim($pos_currency) === 'before') {
                $ret .= $currency_string . ' <span>' . $price . '</span> ';
            } else {
                $ret .= '<span>' . $price . '</span> ' . $currency_string . ' ';
            }
            $ret .= '</span>';
            if (strToFloat(get_field('preis', $postId)) > 0 && $displayTax == true) {
                $ret .= '<br class="nowpautop" /><span class="mwst">' . $text_tax . '</span>';
            }
        } else {
            $ret .= '<p>&nbsp;</p>';
        }
        
        return $ret;
    }

    public function getProductUvpPriceValue($postId)
    {
        global $pos_currency, $currency_string, $text_tax;
        
        $uvpPrice = '';
        
        if (! empty($this->affiliseoOptions['show_uvp'])) {
            
            $uvp = get_field('uvp', $postId);
            
            $showUvp = $this->affiliseoOptions['show_uvp'];
            
            if (strToFloat(get_field('preis', $postId)) > 0 && ! empty($uvp) && $showUvp == '1' && strToFloat($uvp) > strToFloat(get_field('preis', $postId))) {
                
                $currencyBefore = ($pos_currency == 'before') ? $currency_string . ' ' : '';
                $currencyAfter = ($pos_currency == 'after') ? ' ' . $currency_string : '';
                
                $uvpPrice .= '<span class="uvp-line-through">';
                $uvpPrice .= '<span class="uvp-text-color">';
                $uvpPrice .= $currencyBefore;
                $uvpPrice .= get_field('uvp', $postId);
                $uvpPrice .= $currencyAfter;
                
                $uvpPrice .= '</span>';
                $uvpPrice .= '</span>';
            }
        }
        
        if (strlen($uvpPrice) > 5) {
            $ret = $this->getProductPriceValue($postId, false);
            $ret .= $uvpPrice;
            if (strToFloat(get_field('preis', $postId)) > 0) {
                $ret .= '<br class="nowpautop" /><span class="mwst">' . $text_tax . '</span>';
            }
        } else {
            $ret = $this->getProductPriceValue($postId, true);
        }
        
        return $ret;
    }

    public function getPriceCompareValue($postId)
    {
        $ret = '';
        $hasPriceComparison = false;
        $priceComparisonTable = $this->wpdb->prefix . "product_price_comparison";
        if ($this->wpdb->get_var('SHOW TABLES LIKE "' . $priceComparisonTable . '"') == $priceComparisonTable) {
            $res = $this->wpdb->get_results('SELECT * FROM ' . $priceComparisonTable . ' WHERE product_id = ' . (int) $postId, OBJECT);
            if (count($res) > 0) {
                $hasPriceComparison = true;
            }
        }
        
        if ($hasPriceComparison) {
            $permaLink = get_permalink($postId);
            $buttonPriceComparison = $this->affiliseoOptions['button_price_comparison'];
            if (trim($buttonPriceComparison) === '') {
                $buttonPriceComparison = 'zum Preisvergleich';
            }
            
            $ret = '<small id="compare_button_' . $postId . '">' . '<a class="btn btn-detail btn-block" href="javascript:;" onclick="openPriceCompareBox(\'' . get_home_url() . '\', \'' . $postId . '\');"><i class="fa fa-tags"></i> ' . $buttonPriceComparison . '</small>';
        }
        
        return $ret;
    }

    public function getStarRatingValue($postId)
    {
        $ret = '';
        if (! isset($this->affiliseoOptions['hide_star_rating']) || $this->affiliseoOptions['hide_star_rating'] != 1) {
            $ret = '<span style="width:100%; text-align:center;">' . get_product_rating($postId, "", "") . '</span>';
        }
        
        return $ret;
    }

    public function getPdpButtonValue($postId)
    {
        $pdpButtonLabel = get_theme_mod('affiliseo_buttons_detail_label', __('Product description', 'affiliatetheme') . ' &rsaquo;');
        
        $permaLink = get_permalink($postId);
        $ret = '<small> ' . '<a class="btn btn-detail btn-block" href="' . $permaLink . '" target="_blank"> ' . $pdpButtonLabel . '</a></small>';
        return $ret;
    }

    public function getApButtonValue($postId)
    {
        $apPdpButton = get_field('ap_pdp_button', $postId);
        
        if ($apPdpButton == "") {
            $apPdpButton = $this->affiliseoOptions['ap_button_label'];
        }
        
        $apPdpLink = get_field('ap_pdp_link', $postId);
        $ret = '<small> ' . '<a rel="nofollow" target="_blank" class="btn btn-ap btn-block" href="' . $apPdpLink . '"> ' . $apPdpButton . '</a></small>';
        return $ret;
    }

    public function getProductImageValue($postId)
    {
        $attachments = get_posts('post_type=attachment&post_parent=' . $postId . '&posts_per_page=-1&order=ASC');
        $ret = '';
        $postThumbnailUrl = get_the_custom_post_thumbnail_url($postId);
        if ($attachments && count($attachments) > 0 || strlen($postThumbnailUrl) > 3) {
            
            $ret .= '<img class="img_by_url_image_table_w150" src="' . $postThumbnailUrl . '"   alt="" id="product-image-' . $postId . '">';
        }
        if ($ret == '') {
            $ret .= '<img src="images/empty.png" alt="" />';
        }
        
        $pdp = get_permalink($postId);
        if (isset($this->affiliseoOptions['allg_produktbild_ap']) && $this->affiliseoOptions['allg_produktbild_ap'] == "1") {
            $apPdpLink = get_field('ap_pdp_link', $postId);
            if ($apPdpLink != "") {
                $pdp = $apPdpLink;
            }
        }
        
        return '<a rel="nofollow" href="' . $pdp . '" target="_blank">' . $ret . '</a>';
    }

    public function getproductTitleValue($postId, $length = 55)
    {
        $ret = get_the_title($postId);
        $suffix = (strlen($ret) > $length) ? '...' : '';
        
        return '<span id="product-title-' . $postId . '">' . substr($ret, 0, $length) . $suffix . '</span>';
    }

    public function getProductReviewValue($postId)
    {
        if (isset($this->affiliseoOptions['hide_product_review']) && $this->affiliseoOptions['hide_product_review'] == 1) {
            return 'Hide product review';
        }
        
        $productReviewSummary = get_field('ProductReviewSummary', $postId);
        $ret = '';
        
        if ($productReviewSummary == true) {
            
            $ProductReviews = new ProductReviews(false);
            
            $percentageAverage = $ProductReviews->getPercentageAverage($postId);
            
            if ($percentageAverage <= 25) {
                $reviewRating = (isset($this->affiliseoOptions['product_review_rating1'])) ? $this->affiliseoOptions['product_review_rating1'] : 'SCHLECHT';
            } elseif ($percentageAverage > 25 && $percentageAverage <= 50) {
                $reviewRating = (isset($this->affiliseoOptions['product_review_rating2'])) ? $this->affiliseoOptions['product_review_rating2'] : 'BEFRIEDIGEND';
            } elseif ($percentageAverage > 50 && $percentageAverage <= 75) {
                $reviewRating = (isset($this->affiliseoOptions['product_review_rating3'])) ? $this->affiliseoOptions['product_review_rating3'] : 'GUT';
            } elseif ($percentageAverage >= 75) {
                $reviewRating = (isset($this->affiliseoOptions['product_review_rating4'])) ? $this->affiliseoOptions['product_review_rating4'] : 'SEHR GUT';
            }
            
            $ret .= '<div>';
            $ret .= '<div class="product-reviews-summary-top">';
            $ret .= '<strong class="product-reviews-summary-percent">' . number_format($percentageAverage, 2, ',', '') . '%</strong>';
            $ret .= '</div>';
            $ret .= '<div class="product-reviews-summary-bottom"> ' . $reviewRating . ' </div>';
            $ret .= '</div>';
        }
        
        return $ret;
    }

    public function insertAttribute($params)
    {
        $query = ' INSERT INTO ' . $this->tableName . ' (type,belongs_to)
            VALUES ("' . $params['add-comparison-attribute-type'] . '","' . $params['add-comparison-attribute-belongs_to'] . '") ';
        $this->wpdb->query($query);
    }

    public function updateAttribute($params)
    {
        $query = ' UPDATE ' . $this->tableName . ' SET
            label="' . $params['label'] . '",
            sort_order="' . $params['sort_order'] . '",
            taxonomy_slug="' . $params['taxonomy_slug'] . '"
            WHERE id="' . $params['id'] . '" ';
        $this->wpdb->query($query);
    }

    public function deleteAttribute($attributeId)
    {
        $attribute = $this->getAttribute($attributeId);
        
        $query = ' DELETE FROM ' . $this->tableName . ' WHERE id="' . $attributeId . '" ';
        $this->wpdb->query($query);
        
        // delete children if the attribute is a attribute group
        if ($attribute->type == 'attributeGroup') {
            $query = ' DELETE FROM ' . $this->tableName . ' WHERE belongs_to="' . $attributeId . '"';
            $this->wpdb->query($query);
        }
    }

    public function getAttributesGroup($group)
    {
        $attributes = $this->getComparisonAttributes($group->id);
        
        $out = '<li id="sortable-group_' . $group->id . '"><fieldset id="fieldset_' . $group->id . '" class="form-fieldset">';
        $out .= '<legend>Attributgruppe <input type="text" name="comparison-attribute-group_' . $group->id . '" value="' . $group->label . '" />';
        $out .= '<i class="fa fa-lg fa-minus-circle attribute-delete" title="Element entfernen" id="attribute-delete-id_' . $group->id . '"></i></legend>';
        $out .= '<b>Produkttyp: </b><select name="product-type_' . $group->id . '">';
        $out .= '<option value="-1">alle Produkttypen</option>';
        
        $productTypes = $this->getProductTypes();
        foreach ($productTypes as $key => $value) {
            $selected = ($value->slug == $group->taxonomy_slug) ? 'selected="selected"' : '';
            $out .= '<option value="' . $value->slug . '" ' . $selected . '>' . $value->name . '</option>';
        }
        $out .= '</select>';
        
        $out .= '<div class="clearfix"></div>';
        $out .= '<input type="hidden" id="attribute-sort-order_' . $group->id . '" name="attribute-sort-order_' . $group->id . '" value="" />';
        $out .= '<ul class="group-attributes-sortable">';
        foreach ($attributes as $attribute) {
            $out .= $this->getFormElement($group->id, $attribute);
        }
        
        $out .= '</ul>';
        
        $out .= '<span onclick="writeFormElementMenu(\'' . $group->id . '\');"  class="button-primary" >';
        $out .= 'neues Element <i class="fa fa-lg fa-plus-circle" title="neues Element  hinzufügen"></i>';
        $out .= '</span><br />';
        $out .= '</fieldset>';
        $out .= '<div class="clearfix"></div></li>';
        
        return $out;
    }

    public function getFormElement($groupId, $attribute)
    {
        $attributeType = $attribute->type;
        $attributeValue = $attribute->label;
        
        $attributeIds = $groupId . '_' . $attribute->id;
        
        $out = '<li class="attribute-admin-' . $attribute->type . '" id="sortable-attribute_' . $attribute->id . '">';
        
        switch ($attributeType) {
            
            case 'text':
                $out .= "<i class='fa fa-lg fa-text-width' title='Text'></i>";
                $out .= "<input type='text' name='comparison-attribute-text_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'checkbox':
                $out .= "<i class='fa fa-lg fa-check-square-o' title='Checkbox'></i>";
                $out .= "<input type='text' name='comparison-attribute-checkbox_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'textarea':
                $out .= "<i class='fa fa-lg fa-text-height' title='Textarea'></i>";
                $out .= "<input type='text' name='comparison-attribute-textarea_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'date':
                $out .= "<i class='fa fa-lg fa-calendar' title='Datum'></i>";
                $out .= "<input type='text' name='comparison-attribute-date_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'number':
                $out .= "<i class='fa fa-lg fa-unsorted' title='Nummer'></i>";
                $out .= "<input type='text' name='comparison-attribute-number_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'negativeList':
                $out .= "<i class='fa fa-lg fa-list-ul' title='Negativ-Liste' style='color:red;'></i>";
                $out .= "<input type='text' name='comparison-attribute-negative-list_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'positiveList':
                $out .= "<i class='fa fa-lg fa-list-ul' title='Positiv-Liste' style='color:green;'></i>";
                $out .= "<input type='text' name='comparison-attribute-positive-list_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'productImage':
                $out .= "<i class='fa fa-lg fa-camera' title='Produktbild'></i>";
                $out .= "<input type='text' name='comparison-attribute-product-image_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'priceCompare':
                $out .= "<i class='fa fa-lg fa-money' title='Preisvergleich'></i>";
                $out .= "<input type='text' name='comparison-attribute-price-compare_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'apButton':
                $out .= "<i class='fa fa-lg fa-shopping-cart' title='Affiliate-Partner-Button'></i>";
                $out .= "<input type='text' name='comparison-attribute-ap-button_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'pdpButton':
                $out .= "<i class='fa fa-lg fa-file-text-o' title='Produkt-Details-Button'></i>";
                $out .= "<input type='text' name='comparison-attribute-pdp-button_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'productReview':
                $out .= "<i class='fa fa-lg fa-bar-chart-o' title='Produktbewertung'></i>";
                $out .= "<input type='text' name='comparison-attribute-product-review_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'starRating':
                $out .= "<i class='fa fa-lg fa-star-o' title='Sternebewertung'></i>";
                $out .= "<input type='text' name='comparison-attribute-star-rating_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'productPrice':
                $out .= "<i class='fa fa-lg fa-euro' title='Produktpreis'></i>";
                $out .= "<input type='text' name='comparison-attribute-product-price_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
            
            case 'productUvpPrice':
                $out .= "<i class='fa fa-lg fa-tags' title='Produkt-Uvp-Preis'></i>";
                $out .= "<input type='text' name='comparison-attribute-product-uvp-price_" . $attributeIds . "' value='" . $attributeValue . "' />";
                break;
        }
        
        $out .= "<i class='fa fa-lg fa-minus-circle attribute-delete' title='Element entfernen' id='attribute-delete-id_" . $attribute->id . "'></i>";
        $out .= "<div class='clearfix'></div></li>";
        
        return $out;
    }

    public function getProductTypes($termGroup = 'produkt_typen')
    {
        $terms = get_terms(array(
            'parent' => 0,
            'hide_empty' => false,
            'hierarchical' => false,
            'taxonomy' => $termGroup
        ));
        return $terms;
    }

    public function createAcfField($attribute)
    {
        $attributeId = $attribute->id;
        $attributeType = $attribute->type;
        $fieldLabel = $attribute->label;
        
        $fieldName = 'attribute-' . $attributeId;
        
        $acfField = array();
        
        switch ($attributeType) {
            case 'text':
                $acfField = $this->createTextField($fieldName, $fieldLabel);
                break;
            
            case 'checkbox':
                $acfField = $this->createCheckboxField($fieldName, $fieldLabel);
                break;
            
            case 'textarea':
                $acfField = $this->createTextareaField($fieldName, $fieldLabel);
                break;
            
            case 'date':
                $acfField = $this->createDateField($fieldName, $fieldLabel);
                break;
            
            case 'number':
                $acfField = $this->createNumberField($fieldName, $fieldLabel);
                break;
            
            case 'negativeList':
            case 'positiveList':
                $acfField = $this->createListField($fieldName, $fieldLabel);
                break;
            
            default:
                $acfField = $this->createTextField($fieldName, $fieldLabel);
        }
        
        return $acfField;
    }

    public function getPostTermSlug($postId)
    {
        $tablePrefix = $this->wpdb->prefix;
        $slug = null;
        $query = <<<SQL
        SELECT t.* FROM {$tablePrefix}term_relationships tr
        LEFT JOIN {$tablePrefix}term_taxonomy tt
            ON (tr.term_taxonomy_id=tt.term_taxonomy_id AND tt.taxonomy='produkt_typen')
        LEFT JOIN {$tablePrefix}terms t ON tt.term_id=t.term_id
        WHERE tr.object_id={$postId}
        AND tt.term_id IS NOT NULL
        LIMIT 1
SQL;
        
        $terms = $this->wpdb->get_results($query, OBJECT);
        if (isset($terms[0]->slug)) {
            $slug = $terms[0]->slug;
        }
        
        return $slug;
    }

    public function writeHighlightedColumnHeadline($productId, $compareTableId)
    {
        $ret = '';
        
        $highlightedColumn = get_field('comparisonHighlightedColumn', $productId);
        
        if (intval($highlightedColumn) == 1) {
            
            $highlightedColumnHeadline = get_field('comparisonHighlightedColumnHeadline', $productId);
            $highlightedColumnColor = get_field('comparisonHighlightedColumnColor', $productId);
            $bgColor = get_field('comparisonHighlightedColumnBgColor', $productId);
            
            $ret .= '<td class="comparison_highlighted_column comparison_highlighted_column_' . $compareTableId . '" style=" background-color:' . $bgColor . '; color:' . $highlightedColumnColor . '; ' . $this->writeHighlightedColumnStyle($productId) . ' ">' . $highlightedColumnHeadline . '</td>';
        }
        
        return $ret;
    }

    public function writeHighlightedColumnStyle($productId)
    {
        $ret = '';
        
        $highlightedColumn = get_field('comparisonHighlightedColumn', $productId);
        
        if (intval($highlightedColumn) == 1) {
            
            $highlightedColumnBgColor = get_field('comparisonHighlightedColumnBgColor', $productId);
            $ret .= ' border-left: 2px solid ' . $highlightedColumnBgColor . '; border-right: 2px solid ' . $highlightedColumnBgColor . '; ';
        }
        
        return $ret;
    }

    public function writeHighlightedColumnBackgroundColor($productId)
    {
        $ret = '';
        
        $highlightedColumn = get_field('comparisonHighlightedColumn', $productId);
        
        if (intval($highlightedColumn) == 1) {
            
            $bgOpacity = get_theme_mod('affiliseo_comparison_highlighted_column_bg_opacity', '50%');
            
            $bgColor = get_field('comparisonHighlightedColumnBgColor', $productId);
            $ret .= ' background-color: rgba(' . hexdec(substr($bgColor, 1, 2)) . ', ' . hexdec(substr($bgColor, 3, 2)) . ', ' . hexdec(substr($bgColor, 5, 2)) . ', ' . number_format(($bgOpacity / 100), 2, '.', '') . '); ';
        }
        
        return $ret;
    }
    
    //
    
    /**
     * functions for creating acf-fields
     */
    private function createTextField($fieldName, $fieldLabel)
    {
        $ret = array(
            'key' => $fieldName,
            'name' => $fieldName,
            'label' => $fieldLabel,
            'type' => 'text'
        );
        return $ret;
    }

    private function createCheckboxField($fieldName, $fieldLabel)
    {
        $ret = array(
            'key' => $fieldName,
            'name' => $fieldName,
            'label' => $fieldLabel,
            'type' => 'true_false',
            'default_value' => 0
        );
        return $ret;
    }

    private function createDateField($fieldName, $fieldLabel)
    {
        $ret = array(
            'key' => $fieldName,
            'name' => $fieldName,
            'label' => $fieldLabel,
            'type' => 'date_picker',
            'required' => 0,
            'class' => 'date_picker',
            'conditional_logic' => array(
                'status' => 0,
                'allorany' => 'all',
                'rules' => 0
            ),
            'column_width' => '15',
            'date_format' => 'mmddyy',
            'display_format' => 'dd.mm.yy'
        );
        
        return $ret;
    }

    private function createNumberField($fieldName, $fieldLabel)
    {
        $ret = array(
            'key' => $fieldName,
            'name' => $fieldName,
            'label' => $fieldLabel,
            'type' => 'number',
            'prepend' => '',
            'append' => '',
            'min' => '0',
            'max' => '',
            'step' => 1
        );
        
        return $ret;
    }

    private function createTextareaField($fieldName, $fieldLabel)
    {
        $ret = array(
            'key' => $fieldName,
            'name' => $fieldName,
            'label' => $fieldLabel,
            'type' => 'wysiwyg',
            'default_value' => '',
            'toolbar' => 'basic',
            'media_upload' => 'no'
        );
        
        return $ret;
    }

    private function createListField($fieldName, $fieldLabel)
    {
        $ret = array(
            'key' => $fieldName,
            'name' => $fieldName,
            'label' => $fieldLabel,
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => 'Eintrag hinzufügen',
            'sub_fields' => array(
                
                array(
                    'key' => $fieldName . '_elem',
                    'name' => $fieldName . '_elem',
                    'label' => '',
                    'type' => 'text'
                )
            )
        );
        return $ret;
    }

    private function createComparisonAttributesTable()
    {
        $query = ' CREATE TABLE ' . $this->tableName . ' (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `label` varchar(128) NOT NULL,
        `type` enum("text","checkbox","textarea","date","number","negativeList","positiveList","productImage","priceCompare","apButton","pdpButton","productReview","starRating","productPrice","productUvpPrice", "attributeGroup") NOT NULL DEFAULT "text",
        `sort_order` int(11) NOT NULL,
        `belongs_to` int(11) NOT NULL DEFAULT -1,
        `taxonomy_slug` varchar(128) NOT NULL DEFAULT -1,    
        UNIQUE KEY id (id)
        );';
        
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($query);
    }
}