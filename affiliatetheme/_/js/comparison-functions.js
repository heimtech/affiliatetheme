function setCurrentCol(n, compareTableId, lastCol) {

	if (typeof (window["current_col_" + compareTableId]) == "undefined") {
		window["current_col_" + compareTableId] = 1;
	}

	window["current_col_" + compareTableId] += n;
	drawScrollButtons(compareTableId, lastCol);
}

function displayNavButtons(compareTableId) {

	var compareBody = jQuery('#compare-content-body-' + compareTableId);
	var compareHeader = jQuery('#compare-content-header-' + compareTableId);
	var scrollBtnPrev = jQuery("#scroll_btn_prev_" + compareTableId);
	var scrollBtnNext = jQuery("#scroll_btn_next_" + compareTableId);

	if (scrollBtnPrev.length) {

		var scrollBtn = scrollBtnPrev;

		var scrollBtnOffset = scrollBtn.actual('offset');
		var compareBodyOffset = compareBody.actual('offset');
		var compareHeaderOffset = compareHeader.actual('offset');

		var compareBodyBottom = parseInt(compareBodyOffset.top
				+ compareBody.actual('outerHeight'), 10);
		var scrollBtnHeight = parseInt(scrollBtn.actual('height'), 10);
		var scrollBtnTop = scrollBtnOffset.top;
		var scrollBtnBottom = parseInt(scrollBtnTop + scrollBtnHeight, 10);

		scrollBtnPrev.css({
			top : compareHeaderOffset.top + 150,
			position : 'absolute'
		});
		scrollBtnNext.css({
			top : compareHeaderOffset.top + 150,
			position : 'absolute'
		});

		if (compareBodyBottom < scrollBtnBottom) {
			scrollBtnPrev.hide();
			scrollBtnNext.hide();
		} else {
			scrollBtnPrev.show();
			scrollBtnNext.show();
		}
	}
}

function highlightCols(compareTableId) {
	jQuery("#comparison-table-header-" + compareTableId).delegate(
			'.compare-product-title-' + compareTableId, 'mouseover mouseleave',
			function(e) {
				var colId = jQuery(this).attr('id');
				if (e.type == 'mouseover') {
					jQuery(this).addClass("hover-col");
					jQuery('td.' + colId).addClass("hover-col");
				} else {
					jQuery(this).removeClass("hover-col");
					jQuery('td.' + colId).removeClass("hover-col");
				}
			});
}

function highlightRows(compareTableId) {

	jQuery("#comparison-table-" + compareTableId).delegate(
			'.compare-cell',
			'mouseover mouseleave',
			function(e) {
				var parentElementId = jQuery(this).parent('tr').attr('id');
				var elementIdParts = parentElementId.split('_');
				var attributeLabel = jQuery('#attribute-label-row_'
						+ elementIdParts[1]);

				if (e.type == 'mouseover') {
					jQuery(this).addClass("hover-row");
					attributeLabel.addClass("hover-row");
					jQuery(this).siblings().addClass("hover-row");
				} else {
					attributeLabel.removeClass("hover-row");
					jQuery(this).removeClass("hover-row");
					jQuery(this).siblings().removeClass("hover-row");
				}
			});
}

function highlightScrollButtons(compareTableId) {

	var scrollBtnPrev = jQuery("#scroll_btn_prev_" + compareTableId);
	var scrollBtnNext = jQuery("#scroll_btn_next_" + compareTableId);

	scrollBtnPrev.hover(function() {
		scrollBtnPrev.removeClass("prev_off").addClass("prev_on");
	}, function() {
		scrollBtnPrev.removeClass("prev_on").addClass("prev_off");
	});

	scrollBtnNext.hover(function() {
		scrollBtnNext.removeClass("next_off").addClass("next_on");
	}, function() {
		scrollBtnNext.removeClass("next_on").addClass("next_off");
	});
}

function adjustCellHeight(compareTableId) {

	jQuery('.compare-row-' + compareTableId).each(
			function() {

				var compareCell = jQuery(this).find('td.compare-cell');
				var compareCellHeight = compareCell.actual('height');

				var labelCell = jQuery(this).find('td.compare-table-labels');
				var labelCellHeight = labelCell.height();
				var labelCellOuterHeight = labelCell.actual('outerHeight');
				var labelCellInnerHeight = labelCell.actual('innerHeight');

				if (parseInt(labelCellHeight) > parseInt(compareCellHeight)) {
					compareCell.css({
						height : labelCellHeight
					});
				} else {

					labelCell.css({
						height : jQuery(this).actual('outerHeight')
					});

					labelCell.css({
						height : labelCell.actual('outerHeight')
								+ (labelCellOuterHeight - labelCellInnerHeight)
					});
					compareCell.css({
						height : labelCell.actual('outerHeight')

					});
				}

			});
}

function initWindowResize(compareTableId, currentCol, lastCol) {

	jQuery(window).resize(function() {
		drawScrollButtons(compareTableId, lastCol);
	});
}

function initCompareScrollHeader(compareTableId) {
	jQuery(window).scroll(function() {
		scrollCompareHeader(compareTableId);
	});
}

function initNavButtonScroll(compareTableId) {

	jQuery(window).scroll(function() {
		displayNavButtons(compareTableId);
	});
}

function initTableScroll(compareTableId, lastCol) {

	jQuery('div#compare-content-body-' + compareTableId).scroll(
			function() {
				jQuery('div#compare-content-header-' + compareTableId)
						.scrollLeft(jQuery(this).scrollLeft());
			});
}

function initScrollToRight(compareTableId) {
	jQuery('#scroll_btn_next_' + compareTableId)
			.click(
					function(event) {

						var compareCellWidth = jQuery(
								'.compare-cell-' + compareTableId).actual(
								'outerWidth');

						jQuery(
								'div#compare-content-body-' + compareTableId
										+ ', div#compare-content-header-'
										+ compareTableId).animate({
							scrollLeft : '+=' + compareCellWidth
						}, 'slow');
						setCurrentCol(1, lastCol);
					});
}

function initScrollToLeft(compareTableId, lastCol) {
	jQuery('#scroll_btn_prev_' + compareTableId)
			.click(
					function(event) {

						var compareCellWidth = jQuery(
								'.compare-cell-' + compareTableId).actual(
								'outerWidth');

						jQuery(
								'div#compare-content-body-' + compareTableId
										+ ', div#compare-content-header-'
										+ compareTableId).animate({
							scrollLeft : '-=' + compareCellWidth
						}, 'slow');
						setCurrentCol(-1, lastCol);
					});
}

function addToComparison(element, newParent, compareTableId) {
	element = jQuery(element);
	elementId = element.val();
	var oldOffset = element.actual('offset');

	newParent = jQuery(newParent);

	var compareProduct = document.createElement('div');

	var productImageSrc = jQuery('#product-image-' + elementId).attr('src');
	var productTitle = jQuery('#product-title-' + elementId).html();

	jQuery(compareProduct)
			.html(
					'<i class="fa fa-times-circle-o remove-from-comparison-'
							+ compareTableId
							+ '" id="remove-from-comparison_'
							+ elementId
							+ '_'
							+ compareTableId
							+ '" title="vom Vergleich entfernen"></i><span class="compareProductWrapper"><img class="compareProducts" src="'
							+ productImageSrc + '" /></span>' + productTitle);

	elementX = jQuery(compareProduct);

	var newOffset = elementX.actual('offset');

	var temp = elementX.appendTo(newParent);

	temp.css({
		'position' : 'absolute',
		'left' : oldOffset.left,
		'z-index' : 1000,
		'width' : 140,
		'height' : 230
	});

	temp.attr('id', 'compare-product-' + elementId + '-' + compareTableId);

	var leftPos = jQuery('#compare-send-button-' + compareTableId).actual(
			'offset').left;

	var tmpHeight = temp.actual('outerHeight');
	var parentHeight = newParent.actual('height');

	if (tmpHeight > parentHeight) {
		newParent.height(temp.actual('outerHeight'));
	}

	temp.animate({
		'left' : leftPos
	}, 'slow', function() {
		elementX.show();
	});

	reorderCompareProducts(compareTableId);
}

function reorderCompareProducts(compareTableId) {
	var newLeftPos = jQuery('#compare-send-button-' + compareTableId).actual(
			'offset').left;

	jQuery('#compare-elements-' + compareTableId).children('div').each(
			function() {
				newLeftPos += 170;
				jQuery(this).animate({
					'left' : newLeftPos
				}, 'slow', function() {
				});
			});
}

function drawScrollButtons(compareTableId, lastCol) {

	var scrollBtnPrev = jQuery("#scroll_btn_prev_" + compareTableId);
	var scrollBtnNext = jQuery("#scroll_btn_next_" + compareTableId);
	var compareTableLabels = jQuery(".compare-table-labels-" + compareTableId);

	var compareContentBox = jQuery('#compare-content-body-' + compareTableId)
			.parent('div');

	var boxContentOffset = compareContentBox.actual('offset');
	var boxContentOffsetLeft = boxContentOffset.left;
	var posRightBorder = boxContentOffsetLeft
			+ compareContentBox.actual('outerWidth');

	var boxContentPadding = compareContentBox.actual('outerWidth')
			- compareContentBox.actual('width');

	compareTableLabels.css({
		left : boxContentOffsetLeft + (boxContentPadding / 2)
	});

	scrollBtnPrev.css({
		left : boxContentOffsetLeft + compareTableLabels.actual('outerWidth')
				+ (boxContentPadding / 2)
	});

	scrollBtnNext.css({
		left : posRightBorder - 70 - (boxContentPadding / 2)
	});

	if (window['current_col_' + compareTableId] >= lastCol) {
		scrollBtnNext.hide();
		window['current_col_' + compareTableId] = lastCol;
	} else {
		scrollBtnNext.show();
	}

	if (window['current_col_' + compareTableId] <= 1) {
		scrollBtnPrev.hide();
		window['current_col_' + compareTableId] = 1;
	} else {
		scrollBtnPrev.show();
	}
}

function scrollCompareHeader(compareTableId) {
	var windowScrollTop = jQuery(window).scrollTop();
	var compareBody = jQuery('#compare-content-body-' + compareTableId);
	var compareHeader = jQuery('#compare-content-header-' + compareTableId);
	var compareHeaderWidth = jQuery('#compare-content-body-' + compareTableId)
			.actual('outerWidth');

	var fixedElement = jQuery('#navigation');
	var fixedElementOffset = jQuery('#navigation').actual('offset');
	var fixedElementBottom = fixedElementOffset.top
			+ fixedElement.actual('height');

	var currentHeight = windowScrollTop + fixedElement.actual('outerHeight');

	currentHeight -= 10;

	if (jQuery(fixedElement).css("position") !== "fixed") {
		currentHeight -= fixedElement.actual('outerHeight');
	}

	currentHeight = parseInt(currentHeight, 10);
	var compareHeaderTop = parseInt(compareHeader.actual('offset').top, 10);

	if (currentHeight > compareHeaderTop) {
		compareHeader.css({
			top : currentHeight,
			position : 'absolute',
			width : compareHeaderWidth
		});
	} else {

		if (currentHeight < compareBody.actual('offset').top) {
			compareHeader.css({
				top : 0,
				position : 'unset'
			});
		} else {
			compareHeader.css({
				top : currentHeight,
				position : 'absolute'
			});
		}
	}

	var compareBodyBottom = compareBody.actual('offset').top
			+ compareBody.actual('outerHeight');

	compareBodyBottom = parseInt(compareBodyBottom, 10);

	var compareHeaderHeight = parseInt(compareHeader.actual('outerHeight'), 10);

	if (compareHeaderTop > (compareBodyBottom - compareHeaderHeight)) {
		compareHeader.hide();
	} else {
		compareHeader.show();
	}
}

function handleCompareSend(compareTableId) {

	jQuery('#compare-send-button-' + compareTableId)
			.click(
					function() {

						var compareChooseProductList = '';

						if (jQuery(this).hasClass('compare-send-button-active')) {

							var compareChooseProducts = jQuery(".compare-choose-product-"
									+ compareTableId);

							if (compareChooseProducts.filter(":checked").length > 1) {
								compareChooseProducts.filter(":checked").each(
										function() {
											compareChooseProductList += jQuery(
													this).val()
													+ ',';
										});
							}
						}
						if (compareChooseProductList != "") {
							jQuery('#compareproducts-' + compareTableId).val(
									compareChooseProductList);
							jQuery('#compareproducts-send-' + compareTableId)
									.submit();
						}
					});
}

function getLastCol(compareTableId) {
	var comparisonCell = jQuery('div#compare-content-body-' + compareTableId
			+ ' table#comparison-table-' + compareTableId + ' tbody td');
	var colWidth = comparisonCell.actual('outerWidth');

	var compareContentBox = jQuery('#compare-content-body-' + compareTableId)
			.parent('div');
	var boxContentWidth = compareContentBox.actual('width');

	var slidingWindowWidth = boxContentWidth - 150
			+ (parseInt(compareContentBox.css('padding-left')) * 2);
	var compareContentBodyWidth = jQuery(
			'div#compare-content-body-' + compareTableId).actual('width');

	slidingWindowWidth = slidingWindowWidth
			- (slidingWindowWidth - compareContentBodyWidth);

	var visibleCols = Math.ceil(slidingWindowWidth / colWidth);
	var totalCols = jQuery('tr#attribute-value-row-0-' + compareTableId + ' td').length;

	return totalCols - visibleCols + 1;
}

function handleHighlightedEmptyColumn(compareTableId) {
	var compareContentBox = jQuery('#compare-content-body-' + compareTableId)
			.parent('div');
	jQuery('.highlighted_empty_column_' + compareTableId).css(
			'background-color', compareContentBox.css('backgroundColor'));
}

function handleScrollButtonsVisibility(compareTableId) {

	var compareContentBodyWidth = jQuery(
			'div#compare-content-body-' + compareTableId).actual('width');

	var compareContentBox = jQuery('#compare-content-body-' + compareTableId)
			.parent('div');
	var boxContentWidth = compareContentBox.actual('width');

	var slidingWindowWidth = boxContentWidth - 150
			+ (parseInt(compareContentBox.css('padding-left')) * 2);

	slidingWindowWidth = slidingWindowWidth
			- (slidingWindowWidth - compareContentBodyWidth);

	var comparisonCell = jQuery('div#compare-content-body-' + compareTableId
			+ ' table#comparison-table-' + compareTableId + ' tbody td');
	var colWidth = comparisonCell.actual('outerWidth');

	var visibleCols = Math.ceil(slidingWindowWidth / colWidth);

	var totalCols = jQuery('tr#attribute-value-row-0-' + compareTableId + ' td').length;

	if (totalCols < visibleCols) {

		jQuery(
				'.compare-cell-' + compareTableId
						+ ', .highlighted_empty_column_' + compareTableId
						+ ', .comparison_highlighted_column_' + compareTableId
						+ ', .compare-product-title-' + compareTableId + '')
				.css({
					width : (slidingWindowWidth / totalCols)
				});

		jQuery(
				'#scroll_btn_prev_' + compareTableId + ', #scroll_btn_next_'
						+ compareTableId).remove();
	}
}

function handleAddToCompare(compareTableId) {

	jQuery(".compare-choose-product-" + compareTableId).click(
			function() {

				var compareChooseProducts = jQuery(".compare-choose-product-"
						+ compareTableId);

				var compareSendButton = jQuery('#compare-send-button-'
						+ compareTableId);

				if (compareChooseProducts.filter(":checked").length > 3) {
					jQuery(this).removeAttr("checked");
				} else {
					if (this.checked) {
						addToComparison(this, '#compare-elements-'
								+ compareTableId, compareTableId);
					} else {
						jQuery(
								'#compare-product-' + jQuery(this).val() + '-'
										+ compareTableId).fadeOut(500,
								function() {
									jQuery(this).remove();
									reorderCompareProducts(compareTableId);
								});
					}
				}

				if (compareChooseProducts.filter(":checked").length > 1) {
					compareSendButton.removeClass(
							'compare-send-button-inactive').addClass(
							'compare-send-button-active');
				} else {
					compareSendButton.removeClass('compare-send-button-active')
							.addClass('compare-send-button-inactive');
				}
			});

	jQuery(document).on(
			"click",
			".fa.fa-times-circle-o.remove-from-comparison-" + compareTableId
					+ "",
			function() {
				var elementId = jQuery(this).attr('id');
				var elementIdParts = elementId.split('_');
				jQuery(
						'#compare-product_' + elementIdParts[1] + '_'
								+ compareTableId).click();
			});

}
