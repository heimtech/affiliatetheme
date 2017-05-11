<script type="text/javascript">

	jQuery("#add-products-draft,#add-products-published").click(function () {

		var buttonId = jQuery(this).attr('id');
		jQuery("input[name='ap_product_ids[]']").each( function () {
			if(this.checked){

				if(buttonId=='add-products-published'){
					var productPublic = 'true';
				} else{
					var productPublic = 'false';
				}

				var apUniqueProductId = jQuery(this).val();
				var requestData = getProductData(apUniqueProductId, productPublic);

				doRequest(requestData, apUniqueProductId);
			}
		});
		jQuery("input[name='ap_product_ids[]'],#cb_all_products").removeAttr('checked');
	});

	jQuery(".add-product").click(function () {

		var currentID = jQuery(this).attr('id');
		var apUniqueProductIdArr = currentID.toString().split('-');
		var apUniqueProductId = apUniqueProductIdArr[1];
		var productPublic;

		if (apUniqueProductIdArr[0] === 'submitdraft') {
			productPublic = 'false';
		} else {
			productPublic = 'true';
		}

		var requestData = getProductData(apUniqueProductId, productPublic);

		doRequest(requestData, apUniqueProductId);
	});

	function getValue(valueUppercase, apUniqueProductId, valueLowercase, type) {

		var importValue = jQuery('#import' + valueUppercase + '-' + apUniqueProductId).prop('checked');
		var valueString = '';

		if (importValue) {
			switch (type) {
				case 'text':
					valueString = jQuery('#' + valueLowercase + '-' + apUniqueProductId).text();
					break;
				case 'val':
					valueString = jQuery('#' + valueLowercase + '-' + apUniqueProductId).val();
					break;
				default:
					valueString = jQuery('#' + valueLowercase + '-' + apUniqueProductId).attr('src');
			}
		}
		return valueString;
	}

	function doRequest(requestData, apUniqueProductId){

		var blogurl = jQuery('#blogurl').attr('href');

		jQuery('#spinner-container-' + apUniqueProductId).css('display', 'block');
		
		jQuery.ajax({
			type: "GET",
			data: requestData,
			dataType: "html",
			url: blogurl + '/wp-content/themes/affiliatetheme/library/affiliatePartners/quickImportRequest.php',
			success: function (data) {
				jQuery('.spinner-container').css('display', 'none');
				jQuery('#submit-container-' + apUniqueProductId).removeClass('hidden');				
				jQuery('#submit-container-' + apUniqueProductId).append(data);
			},
		});
	}

	function getProductData(apUniqueProductId, productPublic){
		
		var productPriceType = '';
		var productPrice = '';
		var importPrice = jQuery('#importPrice' + '-' + apUniqueProductId).prop('checked');

		if (importPrice) {

			var radios = document.getElementsByName('choose_price_type-' + apUniqueProductId);

			for (var i = 0, length = radios.length; i < length; i++) {
				if (radios[i].checked) {
					productPriceType = radios[i].value;
					var productPriceTypeArr = productPriceType.split('-' + apUniqueProductId);
					productPriceType = productPriceTypeArr[0];
					break;
				}
			}

			if (productPriceType === '') {
				productPriceType = 'lowest_new';
			}

			productPrice = jQuery('#' + productPriceType + '_price-' + apUniqueProductId).text();
		}

		var uvpPrice = jQuery('#uvp-' + apUniqueProductId).text();

		if (uvpPrice) {
			var productUVP = uvpPrice;
		} else {
			var productUVP = jQuery('#list_price-' + apUniqueProductId).text();
		}	
		
		
		var productTitle = getValue('Title', apUniqueProductId, 'title', 'val');
		var productDesc = getValue('Desc', apUniqueProductId, 'desc', 'text');
		var productAffiliate = getValue('Affiliate', apUniqueProductId, 'affiliate', 'text');
		var productAffiliateCart = getValue('AffiliateCart', apUniqueProductId, 'affiliateCart', 'text');
		var productType = getValue('Type', apUniqueProductId, 'type', 'val');
		var productImg = getValue('Img', apUniqueProductId, 'img', 'img');
		var productImages = getValue('Img', apUniqueProductId, 'images', 'text');
		var productBrand = jQuery('#marken-' + apUniqueProductId).val();
		var productEAN = jQuery('#ean-' + apUniqueProductId).text();
		var affiliatePartner = jQuery('#affiliatePartner').text();
		var shopName = jQuery('#shop-' + apUniqueProductId).text();
		var starRating = jQuery('#star-rating-' + apUniqueProductId).text();

		var requestData = {
				title: productTitle,
				apUniqueProductId: apUniqueProductId,
				desc: productDesc,
				price: productPrice,
				prictetype: productPriceType,
				uvp: productUVP,
				brand: productBrand,
				type: productType,
				img: productImg,
				images: productImages,
				affiliate: productAffiliate,
				affiliatecart: productAffiliateCart,
				public: productPublic,
				ean: productEAN,
				affiliatePartner:affiliatePartner,
				shopName:shopName,
				starRating:starRating
			};

		return requestData;
	}

	jQuery(".detail-import").click(function () {
		  
		var apUniqueProductId = jQuery(this).attr('id');
		var affiliatePartner = jQuery('#affiliatePartner').text();

		var data_ = {
				'apUniqueProductId':apUniqueProductId,
				'partner':affiliatePartner
		};
		
		var url_ = jQuery('#blogurl').attr('href') + '/wp-content/themes/affiliatetheme/library/affiliatePartners/detailImport.php';				

		ajaxBox('POST',url_, 'Produkt Details bearbeiten', data_, 800, 'div.ui-dialog');
	});
		
</script>