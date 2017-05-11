jQuery(document).ready(
		function($) {
			
			$('a.custom-shortcode-button.button').live('click',function(){
				jQuery('#alert-background').fadeIn();
				jQuery('#custom-shortcode-container').fadeIn();
				jQuery('#custom-shortcode-container').css('height',parseInt(jQuery(window).height()) - 50);
				
				toggleDiv('custom-shortcode-products');
				
				jQuery('.custom-shortcode-posts, .custom-shortcode-cms-elements, .custom-shortcode-comparison').css('background-color','#dcdcdc');
				
				decorateActiveTab('custom-shortcode-products');
				decorateInactiveTab('custom-shortcode-posts');
				decorateInactiveTab('custom-shortcode-cms-elements');
				decorateInactiveTab('custom-shortcode-comparison');
				
				jQuery('body').css('overflow', 'hidden');
				
				bringElIntoView(jQuery('#custom-shortcode-container'));
			    
			});
			

			jQuery('#custom-shortcode-container-close').click(function() {
				close();
			});
			
			jQuery('.custom-shortcode-products,.custom-shortcode-posts,.custom-shortcode-cms-elements,.custom-shortcode-comparison').click(function() {
				toggleDiv(jQuery(this).attr('class'));
			});
			
			jQuery('#sc-products-button,#sc-posts-button,#sc-cms-elements-button,#sc-comparison-button').click(function() {			
				
				
				var buttonId = jQuery(this).attr('id');
				
				if(buttonId=='sc-posts-button'){
					var shortcode = '[posts ';
					shortcode += ' selected_category='+jQuery('input[name=selected_category]:radio:checked').val();
					shortcode += ' selected_template='+jQuery('input[name=selected_template]:radio:checked').val();
					shortcode += checkCheckbox('selected_posts', true);
					shortcode += ' max_posts='+jQuery('#max_posts').val();
					shortcode += ' tpl_headline_length='+jQuery('#tpl_headline_length').val();
					shortcode += ' tpl_short_text_length='+jQuery('#tpl_short_text_length').val();
					shortcode += ' tpl_long_text_length='+jQuery('#tpl_long_text_length').val();
					shortcode += ']';
				}
				else if(buttonId=='sc-cms-elements-button'){
					var shortcode = '[cmselements ';
					shortcode += ' product_id='+jQuery('input[name=product_id]:radio:checked').val();
					shortcode += ' cms_element='+jQuery('input[name=cms_element]:radio:checked').val();
					shortcode += ']';
					
				}
				else if(buttonId=='sc-comparison-button'){
					var shortcode = '[comparison ';
					
					shortcode += getComparisonProducts();
					
					shortcode += checkRadio('order');
					shortcode += ' compare="'+jQuery("input[name='compare']:checked").val()+'" ';
					shortcode += ' header_position="'+jQuery("input[name='header_position']:checked").val()+'" ';
					shortcode += ' orderby="'+jQuery('#comparison-orderby').val()+'" ';
					shortcode += ' limit="'+jQuery('#comparison-limit').val()+'" ';
					shortcode += ']';
				}	
				else {
					var shortcode = '[produkte ';
					shortcode += trimResult('limit');
					shortcode += checkResult('ad');
					shortcode += checkResult('mini');
					shortcode += checkRadio('order');
					shortcode += checkResult('slider');
					shortcode += trimResult('headline_title', shortcode);
					shortcode += checkCheckbox('typen', false);
					shortcode += checkCheckbox('marken', false);
					shortcode += checkCheckbox('ids', false);
					shortcode += checkCheckbox('custom_taxonomies', false);
					shortcode += checkSelect('alignment');
					shortcode += checkSelectOrderby();
					shortcode += checkResult('add_clearfix');
					shortcode += ']';
					
				}
				
				wp.media.editor.insert(shortcode);
				close();
			});
			
			jQuery('.check-all-products').live('click',function(){
				var currentCheckbox =  this;
				jQuery('.check-all-products').each(function(){
					if(this != currentCheckbox){
						jQuery(this).attr('checked', false); 
					}
				});
				
				if (currentCheckbox.checked) {
					jQuery(".comparison-products").attr("disabled", true);
				} else {
					jQuery(".comparison-products").removeAttr("disabled");
				}
				
			});
			
			jQuery('.comparison-products').live('click',function(){
				var currentCheckboxClass =  jQuery(this).attr('class');
				jQuery('.comparison-products').each(function(){
					if(jQuery(this).attr('class') != currentCheckboxClass){
						jQuery(this).attr('checked', false); 
					}
				});
				
			});
			
			function getComparisonProducts(){
				
				var out = ' comparison_products="';
				
				var allProductsValue = jQuery(".check-all-products").val();
				
				var groupChecked = false;
				var groupValue = '';
				jQuery('.check-all-products').each(function(){
					if(this.checked){
						groupChecked = true;
						groupValue = jQuery(this).val();
						return false;
					}
				});
				
				if(groupChecked){
					out += groupValue;
					
				} else {
					
					jQuery('.comparison-products').each(function(){
						if(this.checked){
							out += jQuery(this).val();
							out +=',';
						}
					});
					
					out = out.slice(0,-1);
					
				}
				
				out +='"';				
				
				
				return out;
				
			}

			function checkSelectOrderby() {
				var shortcode = '';
				var orderby = jQuery('#orderby').val();
				switch (orderby) {
				case 'sterne_bewertung':
					shortcode += ' orderby="sterne_bewertung" ';
					break;
				case 'interne_bewertung':
					shortcode += ' orderby="interne_bewertung" ';
					break;
				case 'title':
					shortcode += ' orderby="title" ';
					break;
				case 'date':
					shortcode += ' orderby="date" ';
					break;
				case 'modified':
					shortcode += ' orderby="modified" ';
					break;
				case 'rand':
					shortcode += ' orderby="rand" ';
					break;
				case 'price':
					shortcode += ' orderby="preis" ';
					break;
				default:
					shortcode += '';
				}
				return shortcode;
			}

			function checkSelect(value) {
				var shortcode = '';
				var alignment = jQuery('#' + value).val();
				switch (alignment) {
				case 'horizontal':
					shortcode += ' horizontal="true" ';
					break;
				case 'highscore':
					shortcode += ' highscore="true" ';
					break;
				case 'sidebar':
					shortcode += ' sidebar="true" ';
					break;
				case 'checklist':
					shortcode += ' checklist="true" ';
					break;
				case 'checklist_y':
					shortcode += ' checklist_y="true" ';
					break;
				default:
					shortcode += ' columns="'+alignment+'" ';
				}
				return shortcode;
			}

			function checkCheckbox(value,onlyValue) {
				var types = jQuery('input[name="' + value + '"]');
				var shortcode = '';
				var hasTypes = false;
				$.each(types, function(i, val) {
					if (val.checked) {
						if(onlyValue==true){
							inputValue = val.value;
						} else {
							inputValue = val.id;							
						}
							
						if (!hasTypes) {
							hasTypes = true;
							shortcode += ' ' + value + '="' + inputValue;
						} else {
							shortcode += ',' + inputValue;
						}
					}
				});
				if (hasTypes) {
					shortcode += '" ';
				}
				return shortcode;
			}			
			

			function checkRadio(value) {
				var radios = document.getElementsByName(value);
				var shortcode = '';
				for (var i = 0, length = radios.length; i < length; i++) {
					if (radios[i].checked) {
						shortcode = ' order="' + radios[i].value + '" ';
						break;
					}
				}
				return shortcode;
			}

			function trimResult(value) {
				var valueStr = jQuery('#' + value).val();
				var shortcode = '';
				if (valueStr.trim() !== '') {
					shortcode = ' ' + value + '="' + valueStr.trim() + '" ';
				}
				return shortcode;
			}

			function checkResult(value) {
				var valueBool = document.getElementById(value).checked;
				var shortcode = '';
				if (valueBool) {
					shortcode = ' ' + value + '="true" ';
				} else {
					shortcode = ' ' + value + '="false" ';
				}
				return shortcode;
			}

			jQuery('#alert-background').click(function() {
				close();
			});

			function close() {
				jQuery('#alert-background').fadeOut();
				jQuery('#custom-shortcode-container').fadeOut();
				jQuery('body').css('overflow', 'auto');
			}
			
			function toggleDiv(divId) {
				
				jQuery('#custom-shortcode-products').fadeOut();
				decorateInactiveTab('custom-shortcode-products');
				
				jQuery('#custom-shortcode-posts').fadeOut();
				decorateInactiveTab('custom-shortcode-posts');
				
				jQuery('#custom-shortcode-cms-elements').fadeOut();
				decorateInactiveTab('custom-shortcode-cms-elements');
				
				jQuery('#custom-shortcode-comparison').fadeOut();
				decorateInactiveTab('custom-shortcode-comparison');
				
				if(divId=="custom-shortcode-products"){
					jQuery('#custom-shortcode-products').fadeIn();
					decorateActiveTab('custom-shortcode-products');
				} else {
					jQuery('#'+divId).fadeIn();
					decorateActiveTab(divId);
				}
				
				jQuery('body').css('overflow', 'auto');
			}
			
			function decorateActiveTab(tab) {
				jQuery('.' + tab).css({
					"background-color" : "#0073aa",
					"border-top-right-radius" : "10px",
					"color" : "#fff"
				});
			}
			
			function decorateInactiveTab(tab) {
				jQuery('.' + tab).css({
					"background-color" : "#dcdcdc",
					"color" : "#000"
				});
			}
		});

