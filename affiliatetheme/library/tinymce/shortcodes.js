(function () {
    "use strict";
    tinymce.create('tinymce.plugins.shortcodes', {
        init: function (ed, url) {
            ed.addButton('columns', {
                type: 'listbox',
                text: 'Grid',
                icon: false,
                onselect: function (e) {
                },
                values: [
                    {text: '[row]', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[row][/row]');
                        }},
                    {text: 'Col 2', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[col sm="2"][/col]');
                        }},
                    {text: 'Col 3', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[col sm="3"][/col]');
                        }},
                    {text: 'Col 4', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[col sm="4"][/col]');
                        }},
                    {text: 'Col 5', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[col sm="5"][/col]');
                        }},
                    {text: 'Col 6', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[col sm="6"][/col]');
                        }},
                    {text: 'Col 7', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[col sm="7"][/col]');
                        }},
                    {text: 'Col 8', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[col sm="8"][/col]');
                        }},
                    {text: 'Col 9', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[col sm="9"][/col]');
                        }},
                    {text: 'Col 10', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[col sm="10"][/col]');
                        }},
                    {text: 'Col 11', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[col sm="11"][/col]');
                        }},
                    {text: 'Col 12', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[col sm="12"][/col]');
                        }},
                ]

            });
            ed.addButton('separators', {
                type: 'listbox',
                text: 'Separators',
                icon: false,
                onselect: function (e) {
                },
                values: [
                    {text: 'Clear', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[clear]');
                        }},
                    {text: 'Divider', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[hr]');
                        }},
                ]

            });
            ed.addButton('buttons', {
                type: 'listbox',
                text: 'Buttons',
                icon: false,
                onselect: function (e) {
                },
                values: [
                    {text: 'Default', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[button style="default"]Lorem ipsum[/button]');
                        }},
                    {text: 'Primary', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[button style="primary"]Lorem ipsum[/button]');
                        }},
                    {text: 'Success', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[button style="success"]Lorem ipsum[/button]');
                        }},
                    {text: 'Info', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[button style="info"]Lorem ipsum[/button]');
                        }},
                    {text: 'Warning', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[button style="warning"]Lorem ipsum[/button]');
                        }},
                    {text: 'Danger', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[button style="danger"]Lorem ipsum[/button]');
                        }},
                    {text: 'Link', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[button style="link"]Lorem ipsum[/button]');
                        }},
                ]

            });
            ed.addButton('alerts', {
                type: 'listbox',
                text: 'Alerts',
                icon: false,
                onselect: function (e) {
                },
                values: [
                    {text: 'Alert Success', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[alert type="success"]Lorem ipsum dolor akismet[/alert]');
                        }},
                    {text: 'Alert Info', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[alert type="info"]Lorem ipsum dolor akismet[/alert]');
                        }},
                    {text: 'Alert Warning', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[alert type="warning"]Lorem ipsum dolor akismet[/alert]');
                        }},
                    {text: 'Alert Danger', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[alert type="danger"]Lorem ipsum dolor akismet[/alert]');
                        }},
                ]

            });
            ed.addButton('liststyles', {
                type: 'listbox',
                text: 'Lists',
                icon: false,
                onselect: function (e) {
                },
                values: [
                    {text: 'List Check', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[list style="check-green"][list_item]Lorem ipsum[/list_item][list_item]Dolor Akismet[/list_item][/list]');
                        }},
                    {text: 'List Plus', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[list style="plus-green"][list_item]Lorem ipsum[/list_item][list_item]Dolor Akismet[/list_item][/list]');
                        }},
                    {text: 'List Minus', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[list style="minus-red"][list_item]Lorem ipsum[/list_item][list_item]Dolor Akismet[/list_item][/list]');
                        }},
                    {text: 'List Cross', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[list style="cross-red"][list_item]Lorem ipsum[/list_item][list_item]Dolor Akismet[/list_item][/list]');
                        }},
                    {text: 'List Star', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[list style="star-orange"][list_item]Lorem ipsum[/list_item][list_item]Dolor Akismet[/list_item][/list]');
                        }},
                ]
            });
            ed.addButton('elements', {
                type: 'listbox',
                text: 'Stuff',
                icon: false,
                onselect: function (e) {
                },
                values: [
                    {text: 'Toggle', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[toggle_group id="1"][toggle title="your title here" group="1" active="true"]your content here[/toggle][toggle title="your second title here" group="1" active=""]your content here[/toggle][/toggle_group]');
                        }},
                    {text: 'Tabs', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[tabs id="1" titles="Titel 1, Titel 2"][tab id="1" tabid="1"]your content here[/tab][tab id="2" tabid="1"]your second content here[/tab][/tabs]');
                        }},
                    {text: 'Well', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[well size=""]Look, I\'m in a well![/well]');
                        }},
                    {text: 'Well Large', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[well size="well-lg"]Look, I\'m in a large well![/well]');
                        }},
                    {text: 'Well Small', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[well size="well-sm"]Look, I\'m in a small well![/well]');
                        }},
                    {text: 'Tooltip Left', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[tooltip position="left" text="Ich bin ein Tooltip"]Tooltip on left[/tooltip]');
                        }},
                    {text: 'Tooltip Top', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[tooltip position="top" text="Ich bin ein Tooltip"]Tooltip on top[/tooltip]');
                        }},
                    {text: 'Tooltip Bottom', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[tooltip position="bottom" text="Ich bin ein Tooltip"]Tooltip on bottom[/tooltip]');
                        }},
                    {text: 'Tooltip Right', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[tooltip position="right" text="Ich bin ein Tooltip"]Tooltip on right[/tooltip]');
                        }},
                    {text: 'Testimonial', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[testimonial img="http://placehold.it/120x120?text=BILD" text="At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. " name="Max Mustermann" company="Max Mustermann GbR"/]');
                        }},
                    {text: 'YouTube Video', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[pvideo type="youtube" id="YOUTUBEID"/]');
                        }},
                    {text: 'Vimeo Video', onclick: function () {
                            tinymce.execCommand('mceInsertContent', false, '[pvideo type="vimeo" id="VIMEOID"/]');
                        }},
                ]
            });
        },
    });
    tinymce.PluginManager.add('shortcodes', tinymce.plugins.shortcodes);
})();