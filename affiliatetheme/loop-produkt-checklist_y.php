<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $affiliseo_options;

$first_attr_checklist_name = $affiliseo_options['comparison_first_attribute_name'];
$first_attr_checklist_content = get_field( 'field_first_attr_checklist' );

$second_attr_checklist_name = $affiliseo_options['comparison_second_attribute_name'];
$second_attr_checklist_content = get_field( 'field_second_attr_checklist' );

$third_attr_checklist_name = $affiliseo_options['comparison_third_attribute_name'];
$third_attr_checklist_content = get_field( 'field_third_attr_checklist' );

$fourth_attr_checklist_name = $affiliseo_options['comparison_fourth_attribute_name'];
$fourth_attr_checklist_content = get_field( 'field_fourth_attr_checklist' );

$fifth_attr_checklist_name = $affiliseo_options['comparison_fifth_attribute_name'];
$fifth_attr_checklist_content = get_field( 'field_fifth_attr_checklist' );

$attr_names = array( $first_attr_checklist_name, $second_attr_checklist_name, $third_attr_checklist_name, $fourth_attr_checklist_name, $fifth_attr_checklist_name );
$attr_contents = array( $first_attr_checklist_content, $second_attr_checklist_content, $third_attr_checklist_content, $fourth_attr_checklist_content, $fifth_attr_checklist_content );

$ap_button_label = getApButtonLabel($post);
$detail_button_label = get_theme_mod( 'affiliseo_buttons_detail_label', __('Product description','affiliatetheme').' &rsaquo;' );

$highlight = $affiliseo_options['comparison_highlight'];
if ( $highlight === 'Rahmen' ) {
	$tr_class = 'border-highlight';
} else {
	$tr_class = 'background-highlight';
}
$is_highlight = get_field( 'field_highlight' );
?>

<table class="table table-bordered table-hover">
	<tr>
		<th></th>
		<td class="text-center">
	<span>
		<a href="<?php echo get_permalink( $post->ID ); ?>"
		   title="zum Produkt: <?php the_title(); ?>">
			   <?php the_title(); ?>
		</a>
	</span>
	<br />
	<br />
	<?php if ( $affiliseo_options['allg_produktbild_ap'] == "1" ) { ?>
		<a href="<?php echo get_field( 'ap_pdp_link' ); ?>" title="zum Produkt: <?php the_title(); ?>" target="_blank"
		   rel="nofollow">
			   <?php 
			   the_custom_post_thumbnail($post, 'img_by_url_product_highscore_w60', null, array(60,60));
			   ?>
		</a>
	<?php } else { ?>
		<?php 
		the_custom_post_thumbnail($post, 'img_by_url_product_highscore_w60', null, array(60,60));
		?>
	<?php } ?>
</td>
	</tr>
	<?php for ( $i = 0; $i < count( $attr_names ); $i++ ) : ?>
	<?php if ( trim( $attr_names[$i] ) != '' ) : ?>
	<tr>
		<th><?php echo $first_attr_checklist_name; ?></th>
		<td class="text-center">
			<?php if ( $attr_contents[$i] == '1' ) : ?>
				<div class="text-center"><i class="fa icon-class fa-check fa-2x green"></i></div>
			<?php elseif ( trim( $attr_contents[$i] ) == '' ) : ?>
				<div class="text-center"><i class="fa icon-class fa-remove fa-2x red"></i></div>
			<?php else :
				?>
				<div class="text-left"> <?php echo $attr_contents[$i]; ?></div>
			<?php endif;
			?>
		</td>
	</tr>
	<?php endif; ?>
<?php endfor; ?>

</table>
