</div>
<!-- close div-compare-content-body -->

<?php
global $compareFunction, $headerPosition, $compareTableId;
?>

<div class="clearfix"></div>
<div class="comparison-footer">

	<div style="float: left; width: 25%;">
		<?php
if (isset($compareFunction) && $compareFunction == 'active') {
    ?>
		<span class="compare-send-button compare-send-button-inactive"
			id="compare-send-button-<?php echo $compareTableId; ?>">Jetzt
			vergleichen</span>
			<?php
}
?>
	</div>
	<div id="compare-elements-<?php echo $compareTableId; ?>"
		class="compare-elements" style="float: left; width: 75%;"></div>
		<div class="clearfix"></div>
</div>
<div class="clearfix"></div>


<script>
jQuery(document).ready(function() {

	scrollingAllowed = true;
	if(jQuery('.comparison-table').length > 1) {
		scrollingAllowed = false;
	}

	current_col_<?php echo $compareTableId; ?> = 1;

	lastCol = getLastCol(<?php echo $compareTableId; ?>);

	initScrollToRight(<?php echo $compareTableId; ?>, lastCol);

	initScrollToLeft(<?php echo $compareTableId; ?>, lastCol);

	handleAddToCompare(<?php echo $compareTableId; ?>);

	handleScrollButtonsVisibility(<?php echo $compareTableId; ?>);
	
	handleHighlightedEmptyColumn(<?php echo $compareTableId; ?>);

	drawScrollButtons(<?php echo $compareTableId; ?>, lastCol);
	
	<?php
    if (isset($headerPosition) && $headerPosition == 'scroll') {
    ?>
    	if(scrollingAllowed==true){
    		initCompareScrollHeader(<?php echo $compareTableId; ?>);
    	}
    
    <?php } ?>

	initNavButtonScroll(<?php echo $compareTableId; ?>);

	initTableScroll(<?php echo $compareTableId; ?>);

    highlightScrollButtons(<?php echo $compareTableId; ?>);

    highlightCols(<?php echo $compareTableId; ?>);

    highlightRows(<?php echo $compareTableId; ?>);

    handleCompareSend(<?php echo $compareTableId; ?>);

    initWindowResize(<?php echo $compareTableId; ?>, current_col_<?php echo $compareTableId; ?>, lastCol);

    adjustCellHeight(<?php echo $compareTableId; ?>);

});



</script>

<form action="<?php bloginfo('url'); ?>/comparison-selection/"
	method="POST" id="compareproducts-send-<?php echo $compareTableId; ?>">
	<input type="hidden"
		name="compareproducts"
		id="compareproducts-<?php echo $compareTableId; ?>" value="" />
</form>
