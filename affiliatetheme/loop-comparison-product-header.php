<?php
global $compareTableId;
?>
<style>
small a.btn.btn-ap.btn-block, small a.btn.btn-detail.btn-block, small a.btn.btn-ap
	{
	white-space: normal;
}



.ui-widget-header {
	background: rgba(0, 0, 0, 0) none repeat scroll 0 0 !important;
	border: 0 none !important;
	color: unset !important;
	font-weight: bold !important;
}

.ui-dialog-titlebar-close {
	position: relative;
	background: 0;
	border: 0;
	float: right;
	z-index: 1;
}

.ui-dialog-titlebar-close:after {
	position: relative;
	top: 5;
	font-family: FontAwesome;
	font-size: 1.0em;
	content: "\f057";
	z-index: 2;
}

div.ui-dialog {
	margin: 0;
	padding: 0;
}


.compare-product-title-<?php echo $compareTableId; ?>,
.comparison_highlighted_column_<?php echo $compareTableId; ?>,
.highlighted_empty_column_<?php echo $compareTableId; ?>,
.compare-col-<?php echo $compareTableId; ?>,
.compare-cell-<?php echo $compareTableId; ?> {
	width: <?php echo get_theme_mod('affiliseo_comparison_cols_width', '150'); ?>px;
	
}

</style>