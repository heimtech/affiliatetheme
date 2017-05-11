<?php
/*
 * Template Name: Vergleich - Auswahl
 */
global $affiliseo_options;
get_header();

the_post();
?>

<div class="custom-container custom-container-margin-top">
	<div class="full-size">
		<div id="content-wrapper" class="page">
			<div class="box content" style="overflow-x: auto;" >
				<?php

    the_content();
    
    if (isset($_POST['compareproducts']) && $_POST['compareproducts'] != "") {
        
        require_once 'loop-comparison-product-header.php';
        
        $comparisonProducts = explode(',', $_POST['compareproducts']);
        
        array_pop($comparisonProducts);
        
        $firstComparisonProductId = $comparisonProducts[0];
        
        $ComparisonAttributes = new ComparisonAttributes();
        
        $postTermSlug = $ComparisonAttributes->getPostTermSlug($firstComparisonProductId);
        
        $comparisonAttributeGroups = $ComparisonAttributes->getComparisonAttributeGroups($postTermSlug);
        
        $comparisonAttributeList = array();
        foreach ($comparisonAttributeGroups as $comparisonAttributeGroup) {
            $belongsTo = $comparisonAttributeGroup->id;
            $comparisonAttributes = $ComparisonAttributes->getComparisonAttributes($belongsTo);
            
            foreach ($comparisonAttributes as $comparisonAttribute) {
                
                $comparisonAttributeList[] = $comparisonAttribute;
            }
        }
        
        $tableHeader = '<tr>';
        $tableRows = '';
        
        $i = 0;
        foreach ($comparisonAttributeList as $key => $comparisonAttribute) {
            
            $tableRows .= '<tr class="compare-row">';
            if ($i == 0) {
                $tableHeader .= '<td class="compare-selection-label">Titel</td>';
            }
            $tableRows .= '<td class="compare-selection-label">' . $comparisonAttribute->label . '</td>';
            
            foreach ($comparisonProducts as $comparisonProduct) {
                $attributeValue = $ComparisonAttributes->getAttributeValue($comparisonAttribute->id, $comparisonProduct);
                
                $attributeValue = ($attributeValue != "") ? $attributeValue : '&nbsp;';
                
                if ($i == 0) {
                    $productTitle = $ComparisonAttributes->getproductTitleValue($comparisonProduct, 300);
                    
                    $tableHeader .= '<td class="compare-selection-cell compare-col">' . $productTitle . '</td>';
                }
                
                $tableRows .= '<td class="compare-selection-cell compare-' . $comparisonAttribute->type . '">' . $attributeValue . '</td>';
            }
            $tableRows .= '</tr>';
            
            $i ++;
        }
        
        $tableHeader .= '</tr>';
        
        $table = '<table id="comparison-selection-table" class="non-responsive">';
        
        $table .= $tableHeader;
        
        $table .= $tableRows;
        
        $table .= '</table>';
        
        $output = $table;
        
        echo $output;
    }
    ?>
				
			</div>
		</div>
	</div>
</div>

<?php

get_footer();