jQuery(document).ready(function($) {
    $('#shortcode_products').click(function() {
        $('#alert-background').fadeIn();
        $('#products-container').fadeIn();
        $('#products-container').css('height', parseInt($(window).height()) - 50);
        $('body').css('overflow', 'hidden');
    });

    $('#products-close').click(function() {
        close();
    });

    $('#generate-button').click(function() {
        var shortcode = '[produkte ';
        shortcode += trimResult('limit');
        shortcode += checkResult('ad');
        shortcode += checkResult('mini');
        shortcode += checkRadio('order');
        shortcode += checkResult('slider');
        shortcode += trimResult('headline_title', shortcode);
        shortcode += checkCheckbox('typen');
        shortcode += checkCheckbox('marken');
        shortcode += checkCheckbox('ids');
        shortcode += checkSelect('alignment');
        shortcode += checkSelectOrderby();
        shortcode += checkResult('add_clearfix');
        shortcode += ']';
        wp.media.editor.insert(shortcode);
        close();
    });
    
    function checkSelectOrderby() {
        var shortcode = '';
        var orderby = $('#orderby').val();
        switch(orderby) {
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
        var alignment = $('#' + value).val();
        switch(alignment) {
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
            default:
                shortcode += ' columns="'+alignment+'" ';                
        }
        return shortcode;
    }
    
    function checkCheckbox(value) {
        var types = $('input[name="' + value + '"]');
        var shortcode = '';
        var hasTypes = false;
        $.each(types, function(i, val) {
            if(val.checked) {
                if(!hasTypes) {
                    hasTypes = true;
                    shortcode += ' ' + value + '="' + val.id;
                } else {
                    shortcode += ',' + val.id;
                }
            }
        });
        if(hasTypes) {
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
        var valueStr = $('#' + value).val();
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

    $('#alert-background').click(function() {
        close();
    });
    
    function close() {
        $('#alert-background').fadeOut();
        $('#products-container').fadeOut();
        $('body').css('overflow', 'auto');
    }
});