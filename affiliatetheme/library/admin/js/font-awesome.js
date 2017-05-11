/**
 * Created by Nadine Wudtke on 27.08.2014.
 */

jQuery(document).ready(function ($) {
    function insertIconsFromJson() {
        $('#icons-content-icons').empty();
        var blogurl = jQuery('#blogurl').attr('href');
        var jsonFile = blogurl + "/wp-content/themes/affiliatetheme/ajax/font-awesome-classes.json";
        $.getJSON(jsonFile, function( data ) {
            $.each( data, function( key, val ) {
                var divElement = document.createElement('div');
                divElement.setAttribute('class', 'col1');
                var iconElement = document.createElement('i');
                iconElement.setAttribute('class', 'fa fa-2x fa-' + val);
                iconElement.setAttribute('id', val);
                iconElement.setAttribute('title', val);
                divElement.appendChild(iconElement)
                $('#icons-content-icons').append(divElement);
                iconElement.addEventListener('click', function(e) {
                    close();
                    var radios = document.getElementsByName('size');
                    var id = e.currentTarget.id;
                    var size = '';
                    for (var i = 0, length = radios.length; i < length; i++) {
                        if (radios[i].checked) {
                            size = radios[i].value;
                            break;
                        }
                    }
                    var tabs = document.getElementById('tabs').checked;
                    var toggles = document.getElementById('toggles').checked;
                    if(tabs || toggles) {
                        if(tabs) {
                            wp.media.editor.insert('[tabs titles="Titel 1 eintragen,Titel 2 eintragen" icons="' + id + ',' + id + '" id="x"][tab id="1" tabid="x"]Inhalt Tab 1[/tab][tab id="2" tabid="x"]Inhalt Tab 2[/tab][/tabs]');
                        }
                        if(toggles) {
                            wp.media.editor.insert('[toggle_group id="y"][toggle title="Titel 1 eintragen" group="y" active="" icon="' + id + '"]Inhalt Toggle 1[/toggle][toggle title="Titel 2 eintragen" group="y" active="" icon="' + id + '"]Inhalt Toggle 2[/toggle][/toggle_group]');
                        }
                    } else {
                        wp.media.editor.insert('[icon type="' + id + '" size="' + size + '"]');
                    }
                });
            });
        });
        $('#icons-content-icons').append('<div class="clearfix"></div>');
    }
    
    function close() {
        $('#alert-background').fadeOut();
        $('#icons-container').fadeOut();
        $('body').css('overflow', 'auto');
    }
    
    $('a.shortcode_icons.button').live('click',function(){
    	insertIconsFromJson();
        $('#alert-background').fadeIn();
        $('#icons-container').fadeIn();
        $('#icons-container').css('height', parseInt($(window).height()) - 50);
        $('body').css('overflow', 'hidden');
        
        bringElIntoView($('#icons-container'));
    });

    $('#icons-close').click(function () {
        close();
    });
    
    $('#alert-background').click(function() {
        close();
    });
});