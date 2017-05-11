<?php
global $affiliseo_options;

$checklistAttrName1 = trim($affiliseo_options['comparison_first_attribute_name']);
$checklistAttrName2 = trim($affiliseo_options['comparison_second_attribute_name']);
$checklistAttrName3 = trim($affiliseo_options['comparison_third_attribute_name']);
$checklistAttrName4 = trim($affiliseo_options['comparison_fourth_attribute_name']);
$checklistAttrName5 = trim($affiliseo_options['comparison_fifth_attribute_name']);
?>

<div class="full-size">
	<div class="box">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th></th>
					<?php if ( $checklistAttrName1  != '' ) { ?><th><?php echo $checklistAttrName1; ?></th><?php } ?>
					<?php if ( $checklistAttrName2  != '' ) { ?><th><?php echo $checklistAttrName2; ?></th><?php } ?>
					<?php if ( $checklistAttrName3  != '' ) { ?><th><?php echo $checklistAttrName3; ?></th><?php } ?>
					<?php if ( $checklistAttrName4  != '' ) { ?><th><?php echo $checklistAttrName4; ?></th><?php } ?>
					<?php if ( $checklistAttrName5  != '' ) { ?><th><?php echo $checklistAttrName5; ?></th><?php } ?>
					<?php if ( $affiliseo_options['allg_preise_ausblenden'] != 1 ) : ?>
	                    <th><?php echo __('Price','affiliatetheme'); ?></th>
					<?php endif; ?>
					<?php if ( trim( $affiliseo_options['comparison_show_product_button'] ) != '' || trim( $affiliseo_options['comparison_show_ap_button'] ) != '' || trim( $affiliseo_options['comparison_show_third_button'] ) != '' ) : ?>
						<th><div class="text-center"><?php echo __('Product','affiliatetheme'); ?></div></th>
					<?php endif; ?>
            </tr>
			</thead>
			<tbody>