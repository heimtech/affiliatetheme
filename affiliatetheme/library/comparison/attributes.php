<?php
$ComparisonAttributes = new ComparisonAttributes();

$comparisonAttributeTypes = array(
    array(
        'type' => 'attributeGroup',
        'prefix' => 'comparison-attribute-group_'
    ),
    array(
        'type' => 'textarea',
        'prefix' => 'comparison-attribute-textarea_'
    ),
    array(
        'type' => 'number',
        'prefix' => 'comparison-attribute-number_'
    ),
    array(
        'type' => 'checkbox',
        'prefix' => 'comparison-attribute-checkbox_'
    ),
    array(
        'type' => 'date',
        'prefix' => 'comparison-attribute-date_'
    ),
    array(
        'type' => 'text',
        'prefix' => 'comparison-attribute-text_'
    ),
    array(
        'type' => 'negativeList',
        'prefix' => 'comparison-attribute-negative-list_'
    ),
    array(
        'type' => 'positiveList',
        'prefix' => 'comparison-attribute-positive-list_'
    ),
    array(
        'type' => 'productImage',
        'prefix' => 'comparison-attribute-product-image_'
    ),
    array(
        'type' => 'priceCompare',
        'prefix' => 'comparison-attribute-price-compare_'
    ),
    array(
        'type' => 'apButton',
        'prefix' => 'comparison-attribute-ap-button_'
    ),
    array(
        'type' => 'pdpButton',
        'prefix' => 'comparison-attribute-pdp-button_'
    ),
    array(
        'type' => 'productReview',
        'prefix' => 'comparison-attribute-product-review_'
    ),
    array(
        'type' => 'starRating',
        'prefix' => 'comparison-attribute-star-rating_'
    ),
    array(
        'type' => 'productPrice',
        'prefix' => 'comparison-attribute-product-price_'
    ),
    array(
        'type' => 'productUvpPrice',
        'prefix' => 'comparison-attribute-product-uvp-price_'
    )
);

// add attribute/attribute-group
if (isset($_POST['add-comparison-attribute-type']) && $_POST['add-comparison-attribute-type'] != "" && isset($_POST['add-comparison-attribute-belongs_to']) && $_POST['add-comparison-attribute-belongs_to'] != "") {
    $ComparisonAttributes->insertAttribute($_POST);
}

// delete attribute/attribute-group
if (isset($_POST['comparison-attribute-delete-id']) && intval($_POST['comparison-attribute-delete-id']) > 0) {
    $ComparisonAttributes->deleteAttribute(intval($_POST['comparison-attribute-delete-id']));
}

if ($_POST['action'] == 'save') {
    
    if (isset($_POST['groups-sort-order']) && $_POST['groups-sort-order'] != "") {
        $groupsSortOrderArray = explode('&', $_POST['groups-sort-order']);
        
        $groupsSortOrder = array();
        $sortOrderIndex = 0;
        foreach ($groupsSortOrderArray as $groupsSortOrderElem) {
            $groupsSortOrderElemArray = explode('=', $groupsSortOrderElem);
            $groupId = $groupsSortOrderElemArray[1];
            
            $groupsSortOrder[$groupId] = $sortOrderIndex;
            $sortOrderIndex ++;
        }
    }
    
    $comparisonAttributes = array();
    $attributesSortOrder = array();
    foreach ($_POST as $formFieldName => $formFieldValue) {
        
        if (substr($formFieldName, 0, 21) == 'attribute-sort-order_') {
            
            $formFieldNameParts = explode('_', $formFieldName);
            $groupId = $formFieldNameParts[1];
            
            if (strlen($formFieldValue) > 0 && $groupId > 0) {
                
                $formFieldValueParts = explode('&', $formFieldValue);
                
                $sortOrderIndex = 0;
                foreach ($formFieldValueParts as $formFieldValuePart) {
                    $attributesSortOrderEntryElemArray = explode('=', $formFieldValuePart);
                    $attributeId = $attributesSortOrderEntryElemArray[1];
                    
                    $attributesSortOrder[$groupId][$attributeId] = $sortOrderIndex;
                    $sortOrderIndex ++;
                }
            }
        }
        
        foreach ($comparisonAttributeTypes as $key => $comparisonAttributeType) {
            
            $attributeType = $comparisonAttributeType['type'];
            $attributePrefix = $comparisonAttributeType['prefix'];
            
            if (substr($formFieldName, 0, strlen($attributePrefix)) == $attributePrefix) {
                
                $formFieldNameParts = explode('_', $formFieldName);
                $attributeLabel = $formFieldValue;
                
                if ($attributeType == 'attributeGroup') {
                    $attributeId = $formFieldNameParts[1];
                    $taxonomySlug = $_POST['product-type_' . $attributeId];
                    $attributeSortOrder = $groupsSortOrder[$attributeId];
                } else {
                    $groupId = $formFieldNameParts[1];
                    $attributeId = $formFieldNameParts[2];
                    $taxonomySlug = - 1;
                    $attributeSortOrder = $attributesSortOrder[$groupId][$attributeId];
                }
                
                $comparisonAttributes[] = array(
                    'id' => $attributeId,
                    'label' => $attributeLabel,
                    'sort_order' => $attributeSortOrder,
                    'taxonomy_slug' => $taxonomySlug
                );
            }
        }
    }
    
    if (count($comparisonAttributes) > 0) {
        foreach ($comparisonAttributes as $comparisonAttribute) {
            $ComparisonAttributes->updateAttribute($comparisonAttribute);
        }
    }
}

$comparisonAttributeGroups = $ComparisonAttributes->getComparisonAttributeGroups();
?>
<style>
.attribute-delete {
	text-align: center;
	color: #D43E27
}

.form-element-selector {
    text-align: center;
    width: 28%;
    float: left;
    border: 1px solid #ddd;
    cursor: pointer;
    height: 75px;
    padding: 5px;
    box-shadow: 0 10px 6px -6px #777;
    background: #FFF;
    margin: 5px;
}

.form-element-selector:hover {
    background-color: #83C341;
	font-size: 130%;
	border-radius: 15px
}

.ui-widget-header {
	background: #0085ba none repeat scroll 0 0;
	border-color: #0073aa #006799 #006799;
	box-shadow: 0 1px 0 #006799;
}

.form-fieldset {
	width: 500px;
	border: solid 1px #cdcdcd;
	float: left;
	padding: 5px;
	box-shadow: 0 10px 6px -6px #777;
    background: #FFF;
    margin: 5px;
}

.form-fieldset label {
	
}

.form-fieldset legend {
	padding: 20px;
	text-align: center;
}

.form-fieldset label input {
	width: 400px;
}

.form-fieldset legend input {
	width: 300px;
}

.form-fieldset label i {
	width: 20px;
	text-align: center;
}

.form-fieldset ul li i {
	width: 30px;
}

.group-attributes-sortable {
	margin: 10px 0px;
}

.group-attributes-sortable li:hover, #attribute-groups-sortable li:hover
	{
	cursor: pointer;
}

.group-attributes-sortable li.ui-sortable-helper,
	#attribute-groups-sortable li.ui-sortable-helper {
	cursor: move;
}

.attribute-admin-productImage,
.attribute-admin-productPrice,
.attribute-admin-priceCompare,
.attribute-admin-starRating,
.attribute-admin-productReview,
.attribute-admin-pdpButton,
.attribute-admin-apButton,
.attribute-admin-productUvpPrice,
.attribute-admin-date,
.attribute-admin-number,
.attribute-admin-text,
.attribute-admin-textarea,
.attribute-admin-checkbox,
.attribute-admin-negativeList,
.attribute-admin-positiveList {
	box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.70), 0px 0px 40px rgba(0, 0, 0, 0.03) inset;
    padding: 5px;
    margin: 10px 5px;
}

.attribute-admin-productImage:hover,
.attribute-admin-productPrice:hover,
.attribute-admin-priceCompare:hover,
.attribute-admin-starRating:hover,
.attribute-admin-productReview:hover,
.attribute-admin-pdpButton:hover,
.attribute-admin-apButton:hover,
.attribute-admin-productUvpPrice:hover,
.attribute-admin-date:hover,
.attribute-admin-number:hover,
.attribute-admin-text:hover,
.attribute-admin-textarea:hover,
.attribute-admin-checkbox:hover,
.attribute-admin-negativeList:hover,
.attribute-admin-positiveList:hover {
	background-color: #83C341;
}

</style>

<h1>Übersicht der Vergleichsattribute</h1>

<span id="comparison-attributes-save" class="button-primary">Änderungen
	speichern</span>


<span onclick="addAttribute('attributeGroup',-1);"
	class="button-primary"> neue Attributgruppe hinzufügen <i
	class="fa fa-lg fa-plus-circle" title="neue Attributgruppe hinzufügen"></i>
</span>
<br />

<form id="comparison-attributes" name="comparison-attributes"
	method="POST">
	<input type="hidden" name="action" value="save" /> <input
		name="groups-sort-order" id="groups-sort-order" type="hidden" value="" />


	<ul id="attribute-groups-sortable">
<?php

foreach ($comparisonAttributeGroups as $comparisonAttributeGroup) {
    echo $ComparisonAttributes->getAttributesGroup($comparisonAttributeGroup);
}

?>
</ul>

</form>

<form id="add-comparison-attribute-form"
	name="add-comparison-attribute-form" method="POST">
	<input type="hidden" name="add-comparison-attribute-type"
		id="add-comparison-attribute-type" value="" /> <input type="hidden"
		name="add-comparison-attribute-belongs_to"
		id="add-comparison-attribute-belongs_to" value="" />
</form>

<form id="comparison-attribute-delete"
	name="comparison-attribute-delete" method="POST">
	<input type="hidden" name="comparison-attribute-delete-id"
		id="comparison-attribute-delete-id" value="-1" />
</form>

<script type="text/javascript">

jQuery(document).ready(function() {

	jQuery(".form-element-selector").live('click',function(){

		var elementId = jQuery(this).attr('id');
		var elementParts = elementId.split('_');

		attributeType = elementParts[0];
		belongsTo = elementParts[1];

		addAttribute(attributeType,belongsTo);
    });

	jQuery(".form-fieldset label i.fa.fa-lg.fa-minus-circle").live('click',function(){
		jQuery(this).parent('label').fadeOut('slow',function(){}).remove();
	});

	jQuery( ".group-attributes-sortable" ).sortable({
		update: function( event, ui ) {
	        var sortedAttributes = jQuery(this).sortable('serialize');
	        var elementId = jQuery(this).parent().attr('id');
			var elementParts = elementId.split('_');
			var groupId = elementParts[1];

	        jQuery('#attribute-sort-order_'+groupId).val(sortedAttributes);
	    }
	});

	jQuery( "#attribute-groups-sortable" ).sortable({
		update: function( event, ui ) {
	        var sortedGroups = jQuery(this).sortable('serialize');
	        
	        jQuery('#groups-sort-order').val(sortedGroups);
	    }
	});

	jQuery(".attribute-delete").click(function() {
		var elementId = jQuery(this).attr('id');
		deleteId = elementId.substring(20);
		formDelGo(deleteId, "Soll dieses und alle dazugehörende Elemente gelöscht werden?");
	});
	
	jQuery("#comparison-attributes-save").click(function() {

		var sortedGroups = jQuery('#attribute-groups-sortable').sortable('serialize');
		jQuery('#groups-sort-order').val(sortedGroups);

		jQuery('ul.group-attributes-sortable').each(function () {

        	var elementId = jQuery(this).parent().attr('id');
    		var elementParts = elementId.split('_');
    		var groupId = elementParts[1];

    		var sortedAttributes = jQuery(this).sortable('serialize');

    		jQuery('#attribute-sort-order_'+groupId).val(sortedAttributes);
            
        });
        
        jQuery('#comparison-attributes').submit();
	});
	
});

function writeFormElementMenu(parentElem){

	var dialogContent = '';

	dialogContent += writeDialogContentElem("textarea_"+parentElem,"Textbox","fa fa-2x fa-text-height");

	dialogContent += writeDialogContentElem("text_"+parentElem,"Textfeld","fa fa-2x fa-text-width");

	dialogContent += writeDialogContentElem("number_"+parentElem,"Nummer","fa fa-2x fa-unsorted");

	dialogContent += writeDialogContentElem("checkbox_"+parentElem,"Checkbox","fa fa-2x fa-check-square-o");

	dialogContent += writeDialogContentElem("date_"+parentElem,"Datum","fa fa-2x fa-calendar");

	dialogContent += writeDialogContentElem("productImage_"+parentElem,"Produktbild","fa fa-2x fa-camera");
	
	dialogContent += writeDialogContentElem("negativeList_"+parentElem,"Negativ-Liste","fa fa-2x fa-list-ul", "color:red;");

	dialogContent += writeDialogContentElem("positiveList_"+parentElem,"Positiv-Liste","fa fa-2x fa-list-ul", "color:green;");
	
	dialogContent += writeDialogContentElem("priceCompare_"+parentElem,"Preis-Vergleich","fa fa-2x fa-money");

	dialogContent += writeDialogContentElem("apButton_"+parentElem,"Partner-Button","fa fa-2x fa-shopping-cart");

	dialogContent += writeDialogContentElem("pdpButton_"+parentElem,"Details-Button","fa fa-2x fa-file-text-o");

	dialogContent += writeDialogContentElem("productReview_"+parentElem,"Produkt-Bewertung","fa fa-2x fa-bar-chart-o");

	dialogContent += writeDialogContentElem("starRating_"+parentElem,"Sterne-Bewertung","fa fa-2x fa-star-o");

	dialogContent += writeDialogContentElem("productPrice_"+parentElem,"Produkt-Preis","fa fa-2x fa-euro");

	dialogContent += writeDialogContentElem("productUvpPrice_"+parentElem,"Produkt-UVP-Preis","fa fa-2x fa-tags");

	var $dialog = jQuery('<div id="jqdialogbox"></div>')
		.html(dialogContent)
		.dialog({
			autoOpen: false,
			width:450,
			title: 'Neues Vergleichselement hinzufügen',
			close: function(event, ui)
			{
				jQuery(this).dialog("close");
				jQuery(this).remove();
			}
		});
	$dialog.dialog('open');
}

function writeDialogContentElem(elemId,elemTitle,iconClass, iconStyle){
	var out ='<div class="form-element-selector" id="'+elemId+'">';
	out +='<i class="'+iconClass+'" title="'+elemTitle+'" style="'+iconStyle+'"></i>';
	out +='<br /> '+elemTitle;
	out +='</div>';

	return out;
}

function addAttribute(attributeType,belongsTo){
	jQuery('#add-comparison-attribute-type').val(attributeType);
	jQuery('#add-comparison-attribute-belongs_to').val(belongsTo);
	jQuery('#add-comparison-attribute-form').submit();
}

function formDelGo(delete_id, confirm_msg) {

	del_go = confirmSubmit(confirm_msg);

	if(del_go == 1){
		jQuery('#comparison-attribute-delete-id').val(delete_id);
		jQuery('#comparison-attribute-delete').submit(); 
	}
}

function confirmSubmit(confirm_msg) {

	var agree=confirm(''+confirm_msg+'');
	if (agree)
		return 1 ;
	else
		return 0 ;
}

</script>