jQuery(window).on('YoastSEO:ready', function () {	
	fieldData = "";
	addAcfFields();
});

function addAcfFields() {
	jQuery.ajax({
		url: ays_settings.url,
		type: 'POST',
		dataType: 'JSON',
		data: {
			postId : ays_settings.postId
		}
	}).done(function(data) {
		setFieldData(data);
	});
}

function setFieldData(data) {
	fieldData = data;
	regAcfappends();
}

function regAcfappends(data) {
	YoastSEO.app.registerPlugin('acf', {status: 'ready'});
	YoastSEO.app.registerModification( 'content', getAcfFieldsData, 'acf', 5 );	
}

function getAcfFieldsData(data){
	return data + ' ' + fieldData;
}
