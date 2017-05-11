function socialp(a, social) {
    if (social == 'twitter') {
        var desc = "";
        if (document.getElementsByName("twitter:description").length) {
            desc = document.getElementsByName("twitter:description")[0].content
        } else {
            var el, els = document.getElementsByTagName("meta");
            var i = els.length;
            while (i--) {
                el = els[i];
                if (el.getAttribute("property") == "og:title") {
                    desc = el.content;
                    break
                }
            }
            if (desc == "") {
                if (document.getElementsByName("description").length) {
                    desc = document.getElementsByName("description")[0].content
                }
            }
        }
        var creator = "";
        if (document.getElementsByName("twitter:creator").length) {
            creator = document.getElementsByName("twitter:creator")[0].content
        }
        creator = creator.replace('@', '');
        a.href += "&text=" + desc + "&via=" + creator + "&related=" + creator
    }
    a = window.open(a.href, "Teile diese Seite", "width=600,height=500,resizable=yes");
    a.moveTo(screen.width / 2 - 300, screen.height / 2 - 450);
    a.focus()
}

jQuery(document).ready(function ($) {
    jQuery('[data-toggle="tooltip"]').tooltip();
    var backgroundTemp = '';
    var backgroundHover = $('.affiliseo-carousel').css('background');
    var borderWidth = '';
    var borderColor = '';
    var borderBottom = '';
    var borderRadius = '';
    var duration = 300;
    var src;
    $('.accordion-body').on('shown.bs.collapse', function () {
        $(this).parent().find('span').first().html("<i class='fa fa-minus-circle'></i>");
    });
    $('.accordion-body').on('hidden.bs.collapse', function () {
        $(this).parent().find('span').first().html("<i class='fa fa-plus-circle'></i>");
    });
    $('.hover-content').mouseenter(function () {
        var idArr = $(this).attr('id').toString().split('-');
        backgroundTemp = $(this).css('background');
        borderWidth = $(this).css('border-top-width');
        borderColor = $(this).css('border-bottom-color');
        borderBottom = $(this).css('border-bottom');
        var id = idArr[1];
        var hover = '#hover-' + id.toString();
        var carousel = '#carousel-' + id.toString();
        backgroundHover = $(carousel).css('background-color').toString();
        var box = this;
        borderRadius = $(box).attr('data-radius');
        placeHover(hover, carousel, box);
        setBorderRadius($(box), '0px');
        if (!($(hover).parents('.headline-product').length)) {
            $(hover).css('border-color', $(box).css('border-color'));
        }
        var apBtn = $('.btn-ap');
        var borderColorHover = apBtn.css('background-color');
        $(hover).css('border-color', borderColorHover);
        $(this).css('border-top-color', borderColorHover);
        $(this).css('border-top-style', 'solid');
        $(this).css('border-top-width', '1px');
        $(this).css('border-right-color', borderColorHover);
        $(this).css('border-right-style', 'solid');
        $(this).css('border-right-width', '1px');
        //$(hover).css('border-bottom-left-radius', borderTemp);
        //$(hover).css('border-bottom-right-radius', borderTemp);
        $(carousel).css('border-color', borderColorHover);
        //$(carousel).css('border-top-left-radius', borderTemp);
        $(box).css('border-color', borderColorHover);
        showHover($(hover), $(carousel), box, borderColorHover);
        $(hover).mouseenter(function () {
            showHover($(this), $(carousel), box, borderColorHover);
            setBackground(hover, carousel, box, backgroundHover);
        });
        $(hover).mouseleave(function () {
            hideHover($(this), $(carousel));
            setBackground(hover, carousel, box, backgroundTemp);
        });
        $(carousel).mouseenter(function () {
            showHover($(hover), $(this), box, borderColorHover);
            setBackground(hover, carousel, box, backgroundHover);
        });
        $(carousel).mouseleave(function () {
            hideHover($(hover), $(this));
            setBackground(hover, carousel, box, backgroundTemp);
        });
        setBackground(hover, carousel, box, backgroundHover);
    });
    function showHover(hover, carousel, box, borderColorHover) {
        $(carousel).removeClass('hidden');
        $(hover).removeClass('hidden');
        $(box).css('border-top-color', borderColorHover);
        $(box).css('border-top-style', 'solid');
        $(box).css('border-top-width', '1px');
        $(box).css('border-right-color', borderColorHover);
        $(box).css('border-right-style', 'solid');
        $(box).css('border-right-width', '1px');
        setBorderRadius($(box), '0px');
    }

    function placeHover(hover, carousel, box) {
        $(hover).outerWidth($(box).first().outerWidth());
        $(hover).removeClass('hidden');
        
        var leftBox = $(box).actual('offset').left;
        var leftBox_ = $(box).actual('position').left;
        
        
        var topBox = $(box).offset().top;
        var topBox_ = $(box).position().top;
        
        var carouselWidth = parseInt($(carousel).actual('outerWidth'));
        var boxWidth = parseInt($(box).actual('outerWidth'));
        
        $(box).offset({top: topBox, left: leftBox});
        $(box).outerHeight($(box).outerHeight());
        $(box).css('width', boxWidth);
        
        $(carousel).removeClass('hidden');
        $(carousel).css('height', $(box).outerHeight());
        $(carousel).css('left', leftBox - carouselWidth - leftBox + leftBox_ + 5);
        $(carousel).css('width', carouselWidth);
        
        $(hover).css('top', topBox_ + $(box).outerHeight() - 10);
        $(hover).css('left', $(box).actual('offset').left - carouselWidth - leftBox + 5);
        $(hover).css('width', (carouselWidth + boxWidth - 5));
        
    }

    function hideHover(hover, carousel) {
        carousel.addClass('hidden');
        hover.addClass('hidden');
        $('.thumbnail').css('border-width', borderWidth);
        $('.thumbnail').css('border-color', borderColor);
        $('.thumbnail').css('border-bottom', borderBottom);
        setBorderRadius($('.thumbnail'), borderRadius);
    }

    function setBackground(hover, carousel, box, background) {
        $(box).css('background', background);
    }

    function setBorderRadius(box, pxl) {
        $(box).css('border-bottom-right-radius', pxl);
        $(box).css('-moz-border-bottom-right-radius', pxl);
        $(box).css('-webkit-border-bottom-right-radius', pxl);
        $(box).css('-o-border-bottom-right-radius', pxl);
        $(box).css('border-top-left-radius', pxl);
        $(box).css('-moz-border-top-left-radius', pxl);
        $(box).css('-webkit-border-top-left-radius', pxl);
        $(box).css('-o-border-top-left-radius', pxl);
    }

    $('.hover-content').mouseleave(function () {
        setBackground('', '', this, backgroundTemp);
        hideHover($('.hover-container'), $('.affiliseo-carousel'));
        setBorderRadius($(this), borderRadius);
    });
    var imgsBigLoaded = $('.big-slider-product-img');
    $.each(imgsBigLoaded, function (key, value) {
        var v = $(value);
        v.attr('src', $(value).attr('data-src'));
        if (!v.hasClass('hidden')) {
            v.css('display', 'none');
            v.load(function () {
                $('#spinner-slider').fadeOut(function () {
                    v.fadeIn();
                    if ($('#show-loupe').length) {
                        var zoomContainer = $('.zoomContainer');
                        $.each(zoomContainer, function (key, value) {
                            $(value).remove();
                        });
                        v.elevateZoom({
                            zoomType: "lens",
                            lensShape: "round",
                            lensSize: 300
                        });
                    }
                });
            });
        }
    });
    var sources = [];
    var imgsViewLoaded = $('.big-slider-product-view');
    $.each(imgsViewLoaded, function (key, value) {
        var v = $(value);
        v.attr('src', $(value).attr('data-src'));
        v.css('display', 'none');
        if (!$.inArray(v.attr('src'), sources)) {
            v.parent().remove();
        } else {
            sources.push(v.attr('src'));
            v.load(function () {
                v.fadeIn();
            });
        }
    });
    $('.small-slider-product-view').click(function () {
        var arr = $(this).attr('class').split(' ');
        var secondClass = arr[1];
        var idArr = secondClass.toString().split('_');
        var id = idArr[1];
        src = $(this).attr('src');
        $('#id_' + id.toString()).fadeOut(duration, function () {
            $(this).attr('src', src.toString());
            $(this).fadeIn(duration);
        });
        $.each($('.small-slider-product-view'), function (key, value) {
            $(value).removeClass('selected');
        });
        $(this).addClass('selected');
    });
    var emptyDivs = $('.after-product');
    $.each(emptyDivs, function (key, value) {
    	
    	if(jQuery(value).text().length < 85 ){
    		$(value).remove();
    	}
        
    });
    if ($('.ribbon-wrapper-green').length) {
        setInterval(function () {
            placeRibbon();
        }, 250);
    }

    function placeRibbon() {
        $('.ribbon-wrapper-green').css('display', 'block');
        $('.ribbon-wrapper-green').css('left', $('.is-highlight').offset().left + $('.is-highlight').outerWidth() - $('.ribbon-wrapper-green').outerWidth() + 4);
        $('.ribbon-wrapper-green').css('top', $('.is-highlight').offset().top - 4);
    }

    var imgs = $('.big-slider-product-view');
    var imgsBig = $('.big-slider-product-img');
    if ($('#show-loupe').length) {
        imgsBig.first().elevateZoom({
            zoomType: "lens",
            lensShape: "round",
            lensSize: 300
        });
    }
    var effect;
    var dirHide;
    var dirShow;
    if (imgsBig.first().hasClass('slideUpDown')) {
        effect = 'slide';
        dirHide = 'down';
        dirShow = dirHide;
    } else if (imgsBig.first().hasClass('slideLeftRight')) {
        effect = 'slide';
        dirHide = 'left';
        dirShow = 'right';
    } else if (imgsBig.first().hasClass('blind')) {
        effect = 'blind';
        dirHide = 'up';
        dirShow = 'up';
    } else if (imgsBig.first().hasClass('fold')) {
        effect = 'fold';
        dirHide = 'up';
        dirShow = 'up';
    } else if (imgsBig.first().hasClass('drop')) {
        effect = 'drop';
        dirHide = 'left';
        dirShow = 'right';
    } else {
        effect = 'slide';
        dirHide = 'down';
        dirShow = dirHide;
    }
    var currentID;
    if (imgs.length) {
        imgs.click(function () {
            if ($(this).hasClass('selected')) {
                return;
            }
            $.each(imgs, function (key, value) {
                $(value).removeClass('selected');
            });
            $(this).addClass('selected');
            currentID = $(this).attr('id');
            $.each(imgsBig, function (key, value) {
                if (!$(value).hasClass('hidden')) {
                    $(value).hide(effect, {direction: dirHide}, duration, function () {
                        $(value).addClass('hidden');
                        $('#img_product_' + currentID).removeClass('hidden');
                        $('#img_product_' + currentID).css('display', 'none');
                        $('#img_product_' + currentID).show(effect, {direction: dirShow}, duration, function () {
                            if ($('#show-loupe').length) {
                                var zoomContainer = $('.zoomContainer');
                                $.each(zoomContainer, function (key, value) {
                                    $(value).remove();
                                });
                                $('#img_product_' + currentID).elevateZoom({
                                    zoomType: "lens",
                                    lensShape: "round",
                                    lensSize: 300
                                });
                            }
                        });
                    });
                }
            });
        });
    }

    setSidebarToBottom();
    if ($('.sidebar-left').length) {
        $(window).resize(function () {
            setSidebarToBottom();
        });
    }

    function setSidebarToBottom() {
        if ($(window).width() < 768) {
            $('.content-right').first().insertBefore('.sidebar-left');
        } else {
            $('.sidebar-left').first().insertBefore('.content-right');
        }
    }


    if ($("#slider-widget").length) {
        $('[data-toggle="tooltip"]').tooltip();
        $("#slider-widget").slider({
            min: 0,
            max: $('#filter-widget-max').text(),
            step: 1,
            values: [0, $('#filter-widget-max').text()],
            slide: function (event, ui) {
                var start = (ui.values[0] < ui.values[1]) ? ui.values[0] : ui.values[1];
                var end = (ui.values[0] < ui.values[1]) ? ui.values[1] : ui.values[0];
                $('#filter-widget-min').text(start);
                $('#min_price').val(start);
                $('#min_price').attr('value', start);
                $('#filter-widget-max').text(end);
                $('#max_price').val(end);
                $('#slider-widget').tooltip('hide')
                        .attr('data-original-title', start + ' - ' + end)
                        .tooltip('fixTitle')
                        .tooltip('show');
            }
        });
        var wFirst = $('#filter-widget-min').outerWidth() * 2.5;
        var wLast = $('#filter-widget-max').outerWidth() * 1.5;
        $('#slider-first').css('width', wFirst);
        $('#slider-last').css('width', wLast);
        $('#slider-component').css('width', $('#slider-component-container').outerWidth() - 10).tooltip('hide');
    }
    var clicked = false;
    $('.stars-widget').mouseenter(function () {
        if (!clicked) {
            var split = $(this).attr('id').split('star');
            for (var i = 1; i <= split[1]; i++) {
                $('#star' + i).removeClass('fa-star-o');
                $('#star' + i).addClass('fa-star');
            }
        }
    });
    $('.stars-widget').mouseleave(function () {
        if (!clicked) {
            var split = $(this).attr('id').split('star');
            disableStars(split[1]);
        }
    });
    $('.stars-widget').click(function () {
        disableStars(5);
        var split = $(this).attr('id').split('star');
        for (var i = 1; i <= split[1]; i++) {
            $('#star' + i).removeClass('fa-star-o');
            $('#star' + i).addClass('fa-star');
        }
        clicked = true;
        $('#stars-product-filter-widget').attr('value', split[1]);
    });
    function disableStars(max) {
        for (var i = 1; i <= max; i++) {
            $('#star' + i).removeClass('fa-star');
            $('#star' + i).addClass('fa-star-o');
        }
    }

    function createCookie(name, value, days) {
        var expires;
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        }
        else
            expires = "";
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0)
                return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        createCookie(name, "", -1);
    }

    function areCookiesEnabled() {
        var r = false;
        createCookie("testing", "Hello", 1);
        if (readCookie("testing") != null) {
            r = true;
            eraseCookie("testing");
        }
        return r;
    }

    var timer;
    if (areCookiesEnabled()) {
        if ($('#myModal').length) {
            var wait = $('#myModal').attr('data-wait');
            var leave = $('#myModal').attr('data-leave');
            if (leave === '0') {
                timer = setInterval(function () {
                    placeModal();
                }, parseInt(wait * 1000));
            } else {
                var shown = false;
                function addEvent(obj, evt, fn) {
                    if (obj.addEventListener) {
                        obj.addEventListener(evt, fn, false);
                    }
                    else if (obj.attachEvent) {
                        obj.attachEvent("on" + evt, fn);
                    }
                }
                addEvent(window, "load", function (e) {
                    addEvent(document, "mouseout", function (e) {
                        e = e ? e : window.event;
                        var from = e.relatedTarget || e.toElement;
                        if (!from || from.nodeName == "HTML") {
                            if (!shown) {
                                placeModal();
                                shown = true;
                            }
                        }
                    });
                });
            }
            $('#myModal').on('shown.bs.modal', function () {
                $('html').css('overflow', 'hidden');
                $('body').css('overflow', 'hidden');
            });
            $('#myModal').on('hide.bs.modal', function (e) {
                $('html').css('overflow', 'auto');
                $('body').css('overflow', 'auto');
            });
            function placeModal() {
                $('#myModal').modal('show');
                clearTimeout(timer)
            }
        }
    }

    if ($('#antibounce').length) {

        function addBounceHook(redirectRules) {
            var matchedKey = redirectRules;
            var redirectHash = '#redirect';
            var bounceOnlyOnce = sessionStorage.getItem('bounced');
            if (bounceOnlyOnce == null) {
                history.replaceState(null, null, location.pathname + redirectHash);
                history.pushState(null, null, location.pathname);
                sessionStorage.setItem('bounced', true);
            }

            window.addEventListener("popstate", function () {
                if (location.hash == redirectHash && matchedKey != null) {
                    history.replaceState(null, null, location.pathname);
                    setTimeout(function () {
                        sessionStorage.clear();
                        location.replace(matchedKey);
                    }, 0);
                }
            });
        }

        addBounceHook($('#antibounce').attr('data-url'));
    }
    if ($('#mouseover_product_pics').length) {
        var val = 10;
        if ($('.mouse-over-thumbnail').length) {
            $('.mouse-over-thumbnail').mouseenter(function () {
                $(this).animate({
                    width: "+=" + val,
                    height: "+=" + val,
                    top: "-=" + val / 2
                }, 150);
            });
            $('.mouse-over-thumbnail').mouseout(function () {
                $(this).animate({
                    width: "-=" + val,
                    height: "-=" + val,
                    top: "+=" + val / 2
                }, 150);
            });
        }
    }

    if ($('#wait').length) {
        var duration = parseInt($('#cloaking-duration').attr('data-duration')) * 1000;
        $("#wait div").animate({
            width: '100%'
        }, duration, function () {
            location.replace($('#redirectlink').attr('href'));
        });
    }
    
    var captionH3height = -1;
	if(jQuery('.related-cols').length) {
		
		jQuery('.related-cols').each(function() {
			
			if(jQuery(this).find('div.thumbnail.horizontal').length == 0){		
				
				jQuery('.caption h3', this).each(function() {
					
					var elementHeight = jQuery(this).height();
					if(captionH3height > elementHeight) {
						captionH3height = captionH3height;
					} else {
						captionH3height = elementHeight;
					}
				});
				
				jQuery('.caption h3', this).each(function() {
					jQuery(this).height(captionH3height);
				});
				captionH3height = -1;
			}
		});
	}
	
	if(jQuery('.product-headers').length) {
		
		var selectorH3_ = 'dummy'; 
	
		jQuery('.product-headers').each(function() {
			
			var selectorH3 = $(this).data("headers");
			
			if(selectorH3 != selectorH3_){
				equal_cols(selectorH3);
				selectorH3_ = selectorH3;				
			}
		});
	}
	
	if(jQuery('.product-captions').length) {
		
		var selectorCaptions_ = 'dummy'; 
	
		jQuery('.product-captions').each(function() {
			
			var selectorCaptions = $(this).data("captions");
			
			if(selectorCaptions != selectorCaptions_){
				
				if(jQuery('.'+selectorCaptions).find('span.uvp-line-through').length > 0) {
					
					jQuery('.'+selectorCaptions).find('div.price').each(function() {
						
						if(jQuery(this).children('span.uvp-line-through').length == 0) {
							jQuery(this).find('br.nowpautop').after('<span class="uvp-line-through" style="top:0; text-decoration:none;"><span class="uvp-text-color"><sup>&nbsp;</sup></span></span>');
							
						}
					});
				}
				selectorCaptions_ = selectorCaptions;				
			}
		});
	}

	
	if(jQuery('.product-thumbs').length) {
		
		var selectorThumb_ = 'dummy'; 
	
		jQuery('.product-thumbs').each(function() {
			
			var selectorThumb = $(this).data("thumbs");
			
			if(selectorThumb != selectorThumb_){
				equal_cols(selectorThumb);
				selectorThumb_ = selectorThumb;				
			}
		});
	}
	
	if(jQuery('div.full-size.related-cols').length) {
		jQuery('div.full-size.related-cols').each(function() {
			var rowBoxMaxheight = 0;
			jQuery(this).find('.related-col3').each(function() {
				if(jQuery(this).hasClass('auto-height') == true){
					var elemHeight = jQuery(this).find('div.thumbnail').height();
					if(elemHeight > rowBoxMaxheight){
						rowBoxMaxheight = elemHeight;
					}					
				}
			});
			
			jQuery(this).find('.related-col3').each(function() {
				if(jQuery(this).hasClass('auto-height') == true){
					jQuery(this).find('div.thumbnail').height(rowBoxMaxheight);
					
				}
			});
		});
	}
	
	jQuery('.product-cols, .related-cols').find('img').each(function() {
		jQuery(this).attr('data-alt',jQuery(this).attr('alt') ).removeAttr('alt');
	});
	
	jQuery('.product-cols, .related-cols').find('img').each(function() {
		jQuery(this).attr('alt',jQuery(this).attr('data-alt')).removeAttr('data-alt');
	});
	
	if ($(window).width() < 767) {		
		
		jQuery('.menu-item-has-children a i.fa.fa-angle-down').hide();
		jQuery('.menu-item-has-children a i.fa-angle-right').hide();
		
		jQuery(".menu-caret" ).click(function() {
			
			var caretIcon = jQuery(this).find('i.fa');
			
			if( $(this).attr("aria-expanded") === 'true') {
				
				caretIcon.removeClass('fa-minus').addClass('fa-plus');

				$(this).siblings('.dropleft-li ul.dropleft').hide();				
				$(this).siblings('ul.dropdown-menu.no-mega-menu').hide();
				
			} else {
				caretIcon.removeClass('fa-plus').addClass('fa-minus');
				
				$(this).siblings('.dropleft-li ul.dropleft').show();
				$(this).siblings('ul.dropdown-menu.no-mega-menu').show();
				
				
				
			}
			
			
			
		});
	}
	
});

function contentIsLoading(elem) {
    function blink() {
        elem.fadeOut(450, function () {
            elem.fadeIn(450);
        });
    }
    setInterval(blink, 450);
}

function openPriceCompareBox(homeUrl, postId){

	jQuery('.ui-dialog-content').fadeOut(1500);
	jQuery(".ui-dialog-content").dialog("close");

	var dialogDiv = document.createElement('div');
	jQuery(dialogDiv).attr('id','pricecomparebox');
	
	var $dialog = jQuery(dialogDiv)
		.html('')
		.dialog({
			autoOpen: false,
			width:700,
			title: 'Preisvergleich',
			close: function(event, ui) {
				jQuery(this).dialog("close");
				jQuery(this).remove();
			},
			show: {effect: 'fade', duration: 1500}
		}
	);
	$dialog.dialog('open');
	$dialog.dialog( "option", "position", { my: "left top", at: "left bottom", of: jQuery('#compare_button_'+postId) } );
	jQuery(dialogDiv).html('<small id="comparecontentloading">Preisverleich wird geladen. Bitte warten...</small>');
	contentIsLoading(jQuery("#comparecontentloading"));
	getPriceComparisonData(homeUrl, postId, 'pricecomparebox','small');
	jQuery(dialogDiv).addClass('price-compare-box');
}

function initBackTotop(){
	
	var backToTop = jQuery('.back-to-top');
	backToTop.addClass('back-to-top-is-hidden');
	
	jQuery(window).scroll(function(){
		
		if(jQuery(this).scrollTop() > 240) {
			backToTop.addClass('back-to-top-is-visible').removeClass('back-to-top-is-hidden');
		} else {
			backToTop.removeClass('back-to-top-is-visible back-to-top-fade-out').addClass('back-to-top-is-hidden');
		}
			
			
		if( jQuery(this).scrollTop() > 1200 ) {
			backToTop.addClass('back-to-top-fade-out');
		}
	});
	
	backToTop.on('click', function(event){
		event.preventDefault();
		jQuery('body,html').animate(
			{ scrollTop: 0 },
			800,function() {
				backToTop.addClass('back-to-top-fade-out').addClass('back-to-top-is-hidden');
			  }
		);
		
	});
}

function displayCookiePolicy(){
    
    if (document.cookie.indexOf( 'ast_cookie_policy' ) === -1 ) {
        
        if (cookiePolicyHideEffect === 'fade' ) {
            cookiePolicyElem.fadeIn( 'slow' );
        } else if (cookiePolicyHideEffect === 'slide' ) {
            cookiePolicyElem.slideDown( 'slow' );
        } else {
            cookiePolicyElem.show();
        }
    	} else {
    	    cookiePolicyElem.remove();
    	}
}    


function hideCookiePolicy(){
    if ( cookiePolicyHideEffect == 'fade' ) {
        cookiePolicyElem.fadeOut( 'slow');
    } else {
        cookiePolicyElem.slideUp( 'slow');
    }
	cookiePolicyElem.remove();
}

function setCookiePolicyCookie() {
    
    var d = new Date();
    d.setTime(d.getTime() + (cookiePolicyExpireTime*1000) );
    
    document.cookie = 'ast_cookie_policy=accepted'
        + ';expires=' + d.toUTCString() ;
    
    hideCookiePolicy();
}

function equal_cols(elClass)
{
	var el = jQuery('.'+elClass);
    var h = 0;
    
    el.each(function(){
    	$(this).css({'height':'auto'});
    });
    
    el.each(function(){
    	
    	
        var elHeight = $(this).actual( 'height' );
        
        if(elHeight > h)
        {
            h = elHeight;
        }
    });
    el.each(function(){    	
    		$(this).css({'height':h});
    });
}