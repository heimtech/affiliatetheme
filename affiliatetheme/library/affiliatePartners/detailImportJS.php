<script type="text/javascript">

	jQuery("#di-add-products-draft,#di-add-products-published").click(function () {

		var buttonId = jQuery(this).attr('id');

		var productPublic = 'false';
		if(buttonId=='di-add-products-published'){
			productPublic = 'true';
		}

		var apUniqueProductId = jQuery('#apUniqueProductId').text();
		var requestData = getDiProductData(apUniqueProductId, productPublic);
		
		doDiRequest(requestData, apUniqueProductId);
		
		jQuery( ".ui-dialog-titlebar-close" ).click();
		
	});

	function getRadioValue(fieldName){
		
		var ret = '';
		var checkedRadio = jQuery('input:radio[name='+fieldName+']:checked').val();
	       
        if(checkedRadio!==undefined){
            ret = checkedRadio;
        }
        return ret;
    }	

	
	function getDiValue(importField, valueField, attr_) {

		var checked_ = jQuery('#' + importField).prop('checked');
		var valueString = '';

		if (checked_) {
			switch (attr_) {
				case 'text':
					valueString = jQuery('#' + valueField).text();
					break;
				case 'val':
					valueString = jQuery('#' + valueField).val();
					break;
				default:
					valueString = jQuery('#' + valueField).attr(attr_);
			}
		}
		return valueString;
	}

	function doDiRequest(requestData, apUniqueProductId){

		var blogurl = jQuery('#blogurl').attr('href');

		jQuery('#spinner-container-' + apUniqueProductId).css('display', 'block');
		
		jQuery.ajax({
			type: "POST",
			data: requestData,
			dataType: "html",
			url: blogurl + '/wp-content/themes/affiliatetheme/library/affiliatePartners/detailImportRequest.php',
			success: function (data) {
				jQuery('.spinner-container').css('display', 'none');
				jQuery('#submit-container-' + apUniqueProductId).removeClass('hidden');				
				jQuery('#submit-container-' + apUniqueProductId).append(data);
			},
		});
	}

	function getDiProductData(apUniqueProductId, productPublic){
		
		var priceChoose = jQuery('#di_price').val();
		var productPriceArr = priceChoose.split('#');
		var productPriceType = productPriceArr[0];
		var productPrice = productPriceArr[1];
		var productUVP = jQuery('#di_uvp').text();	
		var productTitle = jQuery('#di_title').val();
		var productDesc = getDiValue('di_importDesc', 'di_desc', 'val');
		var productAffiliate = getDiValue('di_import-affiliate', 'di_affiliate', 'href');		
		var productAffiliateCart = getDiValue('di_import-affiliateCart', 'di_affiliateCart', 'href');
		var productEAN = jQuery('#di_ean').val();
		var shopName = jQuery('#di_shop_name').val();
		var starRating = jQuery('#di_star_rating').val();
		var internalReview = jQuery('#di_internal_review').val();
		var affiliatePartner = jQuery('#affiliatePartner').text();

		var productTypeValue = getRadioValue('di_type');
		var productType = productTypeValue;
		if(productTypeValue == 'new-type'){
			var productType = jQuery('#new-type').val();
		}

		var productBrandValue = getRadioValue('di_brand');
		var productBrand = productBrandValue;
		if(productBrandValue == 'new-brand'){
			var productBrand = jQuery('#new-brand').val();
		}

		var customTaxonomies = '';
		jQuery( ".di_custom_taxonomy" ).each(function() {

			if(jQuery(this).prop('checked')){
				var radioId = jQuery( this ).attr( "id" );
				var radioValue = jQuery( this ).val();

				var taxonomyPrefix = radioValue.substring(0, 17);
				if(taxonomyPrefix == 'newcustomtaxonomy'){
					var newTaxonomyValue = jQuery('#'+radioValue).val();

					var newTaxonomyArr = radioValue.split('-');
					var newTaxonomySlug = newTaxonomyArr[1];
					
					customTaxonomies +='####'+newTaxonomySlug+'_#_'+newTaxonomyValue;
				} else {
					customTaxonomies +='####'+radioValue;
					
				}
			}		 

		});

		var productImages = '';
		jQuery( ".di_image_import" ).each(function() {
			if(jQuery(this).prop('checked')){
				var checkboxId = jQuery( this ).attr( "id" );
				var nameFieldId = checkboxId + '_name';
				var nameFieldValue = jQuery('#'+nameFieldId).val();
				
				var altFieldId = checkboxId + '_alt';
				var altFieldValue = jQuery('#'+altFieldId).val();
				
				var srcFieldId = checkboxId + '_src';
				var srcFieldValue = jQuery('#'+srcFieldId).attr('src');

				productImages += '####'+srcFieldValue+'_#_'+nameFieldValue+'_#_'+altFieldValue;
				
			}	
		});
		

		var requestData = {
				title: productTitle,
				apUniqueProductId: apUniqueProductId,
				desc: productDesc,
				price: productPrice,
				prictetype: productPriceType,
				uvp: productUVP,
				brand: productBrand,
				type: productType,
				images: productImages,
				affiliate: productAffiliate,
				affiliatecart: productAffiliateCart,
				public: productPublic,
				ean: productEAN,
				affiliatePartner:affiliatePartner,
				shopName:shopName,
				customTaxonomies:customTaxonomies,
				internalReview:internalReview,
				starRating:starRating
			};

		return requestData;
	}

	var checkedBrand = jQuery('input:radio[name=di_brand]:checked').val();
	if(checkedBrand==undefined){
		jQuery('#new-brand-radio').attr('checked','checked');
    }
		
</script>