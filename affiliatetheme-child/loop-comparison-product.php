<?php
global $firstComparisonProduct, $comparisonProducts, $compareFunction,$compareTableId;

$affiliseoOptions = getAffiliseoOptions();

$ComparisonAttributes = new ComparisonAttributes();

$postTermSlug = $ComparisonAttributes->getPostTermSlug($firstComparisonProduct->ID);

$comparisonAttributeGroups = $ComparisonAttributes->getComparisonAttributeGroups($postTermSlug);

$tableHeader = '<tr id="attribute-value-row-0-'.$compareTableId.'">';

$highlightedColumnsRow = '';

$tableRows = '';
$tableFooter = '<tr id="attribute-value-row-00-'.$compareTableId.'">';
$tableFooter .= '<td class="compare-table-labels compare-table-labels-'.$compareTableId.'">Vergleichen (max. 3)</td>';

$tableFooterEmpty = '<tr id="attribute-value-row-empty-'.$compareTableId.'">';
$tableFooterEmpty .= '<td class="compare-table-labels compare-table-labels-'.$compareTableId.'"></td>';

$comparisonAttributeList = array();
foreach ($comparisonAttributeGroups as $comparisonAttributeGroup) {
    $belongsTo = $comparisonAttributeGroup->id;
    $comparisonAttributes = $ComparisonAttributes->getComparisonAttributes($belongsTo);
    
    foreach ($comparisonAttributes as $comparisonAttribute) {
        
        if ($comparisonAttribute->type == 'starRating' && isset($affiliseoOptions['hide_star_rating']) && $affiliseoOptions['hide_star_rating'] == 1) {
            continue;
        }
        
        if ($comparisonAttribute->type == 'productReview' && isset($affiliseoOptions['hide_product_review']) && $affiliseoOptions['hide_product_review'] == 1) {
            continue;
        }
        
        if (($comparisonAttribute->type == 'productUvpPrice' || $comparisonAttribute->type == 'productPrice') && isset($affiliseoOptions['allg_preise_ausblenden']) && $affiliseoOptions['allg_preise_ausblenden'] == 1) {
            continue;
        }
        
        $comparisonAttributeList[] = $comparisonAttribute;
    }
}

$i = 0;

$highlightedColumnProduct = array();
$highlightedColumnCount = 0;

foreach ($comparisonAttributeList as $key => $comparisonAttribute) {
    
    $tableRows .= '<tr class="compare-row compare-row-'.$compareTableId.'" id="attribute-value-row_' . $comparisonAttribute->id . '_'.$compareTableId.'">';
    $tableRows .= '<td class="compare-table-labels compare-table-labels-'.$compareTableId.'">' . $comparisonAttribute->label . '</td>';
    
    foreach ($comparisonProducts as $comparisonProduct) {
        $attributeValue = $ComparisonAttributes->getAttributeValue($comparisonAttribute->id, $comparisonProduct->ID);
        
        $attributeValue = ($attributeValue != "") ? $attributeValue : '&nbsp;';
        
        $highlightedColumnStyle = '';
        
        if ($i == 0) {
            $productTitle = $ComparisonAttributes->getproductTitleValue($comparisonProduct->ID);
            
            $highlightedColumnHeadline = $ComparisonAttributes->writeHighlightedColumnHeadline($comparisonProduct->ID, $compareTableId);
            
            if ($highlightedColumnHeadline != "") {
                $highlightedColumnStyle = ' style="' . $ComparisonAttributes->writeHighlightedColumnStyle($comparisonProduct->ID) . '" ';
                
                $highlightedColumnProduct[$comparisonProduct->ID] = $ComparisonAttributes->writeHighlightedColumnStyle($comparisonProduct->ID);
                
                $highlightedColumnsRow .= $highlightedColumnHeadline;
                $highlightedColumnCount ++;
            } else {
                $highlightedColumnsRow .= '<td class="highlighted_empty_column highlighted_empty_column_'.$compareTableId.'">&nbsp;</td>';
            }
            
            $tableHeader .= '<td ' . $highlightedColumnStyle . ' class="compare-product-title compare-product-title-'.$compareTableId.'" id="col-' . $comparisonProduct->ID . '-'.$compareTableId.'"><a href="' .  get_field('ap_pdp_link', $comparisonProduct->ID ) . '">' . $productTitle . '</a></td>';
            
            $tableFooter .= '<td ' . $highlightedColumnStyle . ' class="compare-choose-cell">';
            $tableFooter .= '<input class="compare-choose-product compare-choose-product-'.$compareTableId.'" type="checkbox" id="compare-product_' . $comparisonProduct->ID . '_'.$compareTableId.'" name="compare-product_' . $comparisonProduct->ID . '" value="' . $comparisonProduct->ID . '" />';
            $tableFooter .= '</td>';
            
            $tableFooterEmpty .= '<td class="compare-cell compare-cell-'.$compareTableId.'" style="height:1px; padding: 0;"></td>';
        }
        
        if (isset($highlightedColumnProduct[$comparisonProduct->ID])) {
            $highlightedColumnStyle = ' style=" ' . $ComparisonAttributes->writeHighlightedColumnBackgroundColor($comparisonProduct->ID) . ' ' . $highlightedColumnProduct[$comparisonProduct->ID] . ' " ';
        }
        
        $tableRows .= '<td ' . $highlightedColumnStyle . ' class="compare-cell compare-cell-'.$compareTableId.' compare-' . $comparisonAttribute->type . ' col-' . $comparisonProduct->ID . '-'.$compareTableId.' ">' . $attributeValue . '</td>';
    }
    $tableRows .= '</tr>';
    
    $i ++;
}

$tableFooter .= '</tr>';
$tableFooterEmpty .= '</tr>';
$tableHeader .= '</tr>';

$headerTable = '<div class="compare-content-header" id="compare-content-header-'.$compareTableId.'">';

$headerTable .= '<table class="non-responsive comparison-table-header" id="comparison-table-header-'.$compareTableId.'" style="table-layout:fixed; overflow: hidden;">';

if (strlen($highlightedColumnsRow) > 10 && $highlightedColumnCount > 0) {
    $headerTable .= '<tr>' . $highlightedColumnsRow . '</tr>';
}

$headerTable .= $tableHeader;
$headerTable .= '</table>';
$headerTable .= '</div>';

$table = '<div class="compare-content-body" id="compare-content-body-'.$compareTableId.'">';
$table .= '<div id="scroll_btn_prev_'.$compareTableId.'" class="scroll_btn scroll_btn_prev prev_off" title="zurück"></div>';
$table .= '<div id="scroll_btn_next_'.$compareTableId.'" class="scroll_btn scroll_btn_next" title="weitere Produkte"></div>';

$table .= '<table class="non-responsive comparison-table" id="comparison-table-'.$compareTableId.'" style="table-layout:fixed;">';

$table .= $tableRows;

if (isset($compareFunction) && $compareFunction == 'active') {
    $table .= $tableFooter;
} else {
    $table .= $tableFooterEmpty;
}

$table .= '</table>';

$output = $headerTable;

$output .= $table;

echo $output;