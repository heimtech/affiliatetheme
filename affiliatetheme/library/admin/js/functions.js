function loadResults(requestUrl, requestData) {

	var blogurl = jQuery('#blogurl').attr('href');
	jQuery('#data').empty();
	jQuery('#data').html('<tr><td><div class="spinner aloader" style="display: block !important; float: left;"></div><strong>DATEN WERDEN GELADEN!</strong></td></tr>');
	
	jQuery.ajax({
		type: "GET",
		data: requestData,
		dataType: "html",
		url: blogurl + requestUrl,
		success: function (data) {
			jQuery('#data').empty();
			jQuery('#data').html(data);
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			alert("Status: " + textStatus);
			alert("Error: " + errorThrown);
		}
	});
}

function ajaxBox(method_, url_, title_, data_, width_, box) {
	
	jQuery.ajax({
		type: method_,
		async: false,
		cache: false,
		url: url_,
		data: data_,
		success: function(data){
			dialog_content=data;
		}
	});
	
	if(dialog_content != "") {
		
		
		
		var $dialog = jQuery('<div id="jqdialogbox"></div>')
			.html(dialog_content)
			.dialog({
				autoOpen: false,
				width:width_,
				position: ['center','50%'],
				title: title_,
				close: function(event, ui)
		        {
		            jQuery(this).dialog("close");
		            jQuery(this).remove();
		        }
			}
			);
		$dialog.dialog('open');
		
		$dialog.dialog( "option", "position", { my: "top+15", at: "center", of: jQuery('div#wpcontent div#wpadminbar') } );
		
		
	}
}

function bringElIntoView(el) {
	var elOffset = el.offset();
	var $window = jQuery(window);
	var windowScrollBottom = $window.scrollTop() + $window.height();
	var scrollToPos = -1;
	if (elOffset.top < $window.scrollTop())
		scrollToPos = elOffset.top;
	else if (elOffset.top + el.height() > windowScrollBottom)
		scrollToPos = $window.scrollTop() + (elOffset.top + el.height() - windowScrollBottom);
	if (scrollToPos !== -1)
		jQuery('html, body').animate({ scrollTop: scrollToPos-45 });
	
	
}

jQuery(document).ready(function () {
	jQuery('*[data-key="field_product_gallery"]').click(function() {
		jQuery("input[name*='acfp_jahsiegiach5ch']" ).each(function(){
			var imageUrl = jQuery(this).val();
			var parentTd = jQuery(this).parents('tr').find("td:first");
			if(imageUrl!="") {
				parentTd.css("background", "transparent url('"+imageUrl+"') no-repeat scroll 0 center / contain");
				parentTd.css("width", "80px");
			}
		});
	});
});