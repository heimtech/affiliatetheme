<?php
register_field_group(
    array(
        'key' => 'group_quu2waquoe4kee',
        'title' => 'Page Builder',
        'fields' => array(
            
            array(
                'key' => 'acfp_mahyaiph9loo3h',
                'label' => 'Flexibler Inhalt',
                'name' => 'acf_page_builder',
                'type' => 'flexible_content',
                'instructions' => '<a href="http://affiliseo.de/page-builder/" target="_blank" class="link-affiliseo">' . '<i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Anleitung auf AffiliSEO.de</a>',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => ''
                ),
                'button_label' => 'Bereich hinzufügen',
                'min' => '',
                'max' => '',
                'layouts' => array(
                    
                    array(
                        'key' => 'okam0moo2quie1',
                        'name' => 'Banner',
                        'label' => 'Banner Bild',
                        'display' => 'block',
                        'sub_fields' => array(
                            
                            array(
                                'key' => 'acfp_56c0e712ec56e',
                                'label' => 'Hintergrundfarbe',
                                'name' => 'bg',
                                'type' => 'color_picker',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    
                                    array(
                                        
                                        array(
                                            'field' => 'acfp_ias6kequuo3oos',
                                            'operator' => '==',
                                            'value' => '1'
                                        )
                                    )
                                ),
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'default_value' => ''
                            ),
                            
                            array(
                                'key' => 'acfp_56c0e723ec56f',
                                'label' => 'Wrapper-Klasse',
                                'name' => 'wrapper_class',
                                'type' => 'text',
                                'instructions' => 'z.B. col-sm-4 col-sm-offset-4',
                                'required' => 0,
                                'conditional_logic' => array(
                                    
                                    array(
                                        
                                        array(
                                            'field' => 'acfp_ias6kequuo3oos',
                                            'operator' => '==',
                                            'value' => '1'
                                        )
                                    )
                                ),
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                                'readonly' => 0,
                                'disabled' => 0
                            ),
                            
                            array(
                                'key' => 'acfp_coh7zo2rim5awu',
                                'label' => __('Image','affiliatetheme'),
                                'name' => 'image',
                                'type' => 'image',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'return_format' => 'url',
                                'preview_size' => 'medium',
                                'library' => 'all',
                                'min_width' => '',
                                'min_height' => '',
                                'min_size' => '',
                                'max_width' => '',
                                'max_height' => '',
                                'max_size' => '',
                                'mime_types' => ''
                            ),
                            
                            array(
                                'key' => 'acfp_oeroogee7iexuu',
                                'label' => 'Text',
                                'name' => 'use_text',
                                'type' => 'true_false',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'message' => 'Text über dem Bild platzieren?',
                                'default_value' => 0
                            ),
                            
                            array(
                                'key' => 'acfp_ua8phoo4iech4m',
                                'label' => 'Text auf dem Bild',
                                'name' => 'text_on_image',
                                'type' => 'wysiwyg',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    
                                    array(
                                        
                                        array(
                                            'field' => 'acfp_oeroogee7iexuu',
                                            'operator' => '==',
                                            'value' => '1'
                                        )
                                    )
                                ),
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'default_value' => '',
                                'tabs' => 'all',
                                'toolbar' => 'full',
                                'media_upload' => 0
                            )
                        ),
                        'min' => '',
                        'max' => ''
                    ),
                    /**
                     * array(
                     * 'key' => 'chielie1veezai',
                     * 'name' => 'Button',
                     * 'label' => 'Button',
                     * 'display' => 'row',
                     * 'sub_fields' => array(
                     *
                     * array(
                     * 'key' => 'acfp_saesh0ko2eedoo',
                     * 'label' => 'Hintergrundfarbe',
                     * 'name' => 'bg',
                     * 'type' => 'color_picker',
                     * 'instructions' => '',
                     * 'required' => 0,
                     * 'conditional_logic' => 0,
                     * 'wrapper' => array(
                     * 'width' => '',
                     * 'class' => '',
                     * 'id' => ''
                     * ),
                     * 'default_value' => ''
                     * ),
                     *
                     * array(
                     * 'key' => 'acfp_rien8aehaemeec',
                     * 'label' => 'Breite',
                     * 'name' => 'width',
                     * 'type' => 'number',
                     * 'instructions' => '',
                     * 'required' => 1,
                     * 'conditional_logic' => 0,
                     * 'wrapper' => array(
                     * 'width' => 15,
                     * 'class' => '',
                     * 'id' => ''
                     * ),
                     * 'default_value' => 3,
                     * 'placeholder' => '',
                     * 'prepend' => 'col-sm-',
                     * 'append' => '',
                     * 'min' => 1,
                     * 'max' => 12,
                     * 'step' => 1,
                     * 'readonly' => 0,
                     * 'disabled' => 0
                     * ),
                     *
                     * array(
                     * 'key' => 'acfp_chievooch9ap8a',
                     * 'label' => 'Button-Klasse',
                     * 'name' => 'button_class',
                     * 'type' => 'text',
                     * 'instructions' => 'z.B. btn btn-primary btn-block',
                     * 'required' => 0,
                     * 'conditional_logic' => 0,
                     * 'wrapper' => array(
                     * 'width' => '',
                     * 'class' => '',
                     * 'id' => ''
                     * ),
                     * 'default_value' => '',
                     * 'placeholder' => '',
                     * 'prepend' => '',
                     * 'append' => '',
                     * 'maxlength' => '',
                     * 'readonly' => 0,
                     * 'disabled' => 0
                     * ),
                     *
                     * array(
                     * 'key' => 'acfp_peenuh0mo2yi5y',
                     * 'label' => 'Button Text',
                     * 'name' => 'button_text',
                     * 'type' => 'text',
                     * 'instructions' => '',
                     * 'required' => 0,
                     * 'conditional_logic' => 0,
                     * 'wrapper' => array(
                     * 'width' => '',
                     * 'class' => '',
                     * 'id' => ''
                     * ),
                     * 'default_value' => '',
                     * 'placeholder' => '',
                     * 'prepend' => '',
                     * 'append' => '',
                     * 'maxlength' => '',
                     * 'readonly' => 0,
                     * 'disabled' => 0
                     * ),
                     *
                     * array(
                     * 'key' => 'acfp_daiqu6oqueich3',
                     * 'label' => 'Link zur Seite',
                     * 'name' => 'link_to_page',
                     * 'type' => 'select',
                     * 'instructions' => '',
                     * 'required' => 0,
                     * 'conditional_logic' => 0,
                     * 'wrapper' => array(
                     * 'width' => '',
                     * 'class' => '',
                     * 'id' => ''
                     * ),
                     * 'choices' => array(
                     * 'anchor' => 'ID Anker',
                     * 'external' => 'Exterer Link',
                     * 'internal' => 'Interner Link'
                     * ),
                     * 'default_value' => array(),
                     * 'allow_null' => 0,
                     * 'multiple' => 0,
                     * 'ui' => 0,
                     * 'ajax' => 0,
                     * 'placeholder' => '',
                     * 'disabled' => 0,
                     * 'readonly' => 0
                     * ),
                     *
                     * array(
                     * 'key' => 'acfp_cho9ohkogeinie',
                     * 'label' => 'Anker',
                     * 'name' => 'button_anchor',
                     * 'type' => 'text',
                     * 'instructions' => '',
                     * 'required' => 1,
                     * 'conditional_logic' => array(
                     *
                     * array(
                     *
                     * array(
                     * 'field' => 'acfp_daiqu6oqueich3',
                     * 'operator' => '==',
                     * 'value' => 'anchor'
                     * )
                     * )
                     * ),
                     * 'wrapper' => array(
                     * 'width' => '',
                     * 'class' => '',
                     * 'id' => ''
                     * ),
                     * 'default_value' => '',
                     * 'placeholder' => '',
                     * 'prepend' => '#',
                     * 'append' => '',
                     * 'maxlength' => '',
                     * 'readonly' => 0,
                     * 'disabled' => 0
                     * ),
                     *
                     * array(
                     * 'key' => 'acfp_di7atheet7cei1',
                     * 'label' => 'Externer Link',
                     * 'name' => 'external_link',
                     * 'type' => 'text',
                     * 'instructions' => '',
                     * 'required' => 1,
                     * 'conditional_logic' => array(
                     *
                     * array(
                     *
                     * array(
                     * 'field' => 'acfp_daiqu6oqueich3',
                     * 'operator' => '==',
                     * 'value' => 'external'
                     * )
                     * )
                     * ),
                     * 'wrapper' => array(
                     * 'width' => '',
                     * 'class' => '',
                     * 'id' => ''
                     * ),
                     * 'default_value' => '',
                     * 'placeholder' => '',
                     * 'prepend' => '',
                     * 'append' => '',
                     * 'maxlength' => '',
                     * 'readonly' => 0,
                     * 'disabled' => 0
                     * ),
                     *
                     * array(
                     * 'key' => 'acfp_cee9oithait6vo',
                     * 'label' => 'Interner Link',
                     * 'name' => 'internal_link',
                     * 'type' => 'page_link',
                     * 'instructions' => '',
                     * 'required' => 1,
                     * 'conditional_logic' => array(
                     *
                     * array(
                     *
                     * array(
                     * 'field' => 'acfp_daiqu6oqueich3',
                     * 'operator' => '==',
                     * 'value' => 'internal'
                     * )
                     * )
                     * ),
                     * 'wrapper' => array(
                     * 'width' => '',
                     * 'class' => '',
                     * 'id' => ''
                     * ),
                     * 'post_type' => array(),
                     * 'taxonomy' => array(),
                     * 'allow_null' => 0,
                     * 'multiple' => 0
                     * )
                     * ),
                     * 'min' => '',
                     * 'max' => ''
                     * ),
                     */
                    
                    array(
                        'key' => 'uu9vuveutaijuu',
                        'name' => 'ContentGrid',
                        'label' => 'Content in Spalten aufteilen',
                        'display' => 'block',
                        'sub_fields' => array(
                            
                            array(
                                'key' => 'acfp_kai6aeweixieph',
                                'label' => 'ACHTUNG: Maximalbreite sind 12 col, beim Einbinden von Produkten folgendes beachen: Miniaturansicht = 2 col; vertikale Produktansicht = 4 col und Produkt-Spalten können nicht mit Überschriften versehen werden.',
                                'name' => '',
                                'type' => 'message',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'new_lines' => 'wpautop',
                                'esc_html' => 0
                            ),
                            
                            array(
                                'key' => 'acfp_tahgohx3iefor7',
                                'label' => 'Hintergrundfarbe',
                                'name' => 'bg',
                                'type' => 'color_picker',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'default_value' => ''
                            ),
                            
                            array(
                                'key' => 'acfp_ceiwoori4loh7c',
                                'label' => 'Content-Spalten',
                                'name' => 'content_columns',
                                'type' => 'repeater',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'collapsed' => '',
                                'min' => 1,
                                'max' => 4,
                                'layout' => 'table',
                                'button_label' => 'Spalten hinzufügen',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'acfp_aenilohgoo3euk',
                                        'label' => 'Content',
                                        'name' => 'content',
                                        'type' => 'wysiwyg',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => 70,
                                            'class' => '',
                                            'id' => ''
                                        ),
                                        'default_value' => '',
                                        'tabs' => 'all',
                                        'toolbar' => 'full',
                                        'media_upload' => 1
                                    ),
                                    
                                    array(
                                        'key' => 'acfp_aiveedoo9sohj5',
                                        'label' => 'Breite',
                                        'name' => 'width',
                                        'type' => 'number',
                                        'instructions' => '',
                                        'required' => 1,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => 15,
                                            'class' => '',
                                            'id' => ''
                                        ),
                                        'default_value' => 3,
                                        'placeholder' => '',
                                        'prepend' => 'col-sm-',
                                        'append' => '',
                                        'min' => 1,
                                        'max' => 12,
                                        'step' => 1,
                                        'readonly' => 0,
                                        'disabled' => 0
                                    ),
                                    
                                    array(
                                        'key' => 'acfp_aethohj9gae6pe',
                                        'label' => 'Abstand zwischen Spalten',
                                        'name' => 'offset',
                                        'type' => 'number',
                                        'instructions' => '',
                                        'required' => 1,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => 15,
                                            'class' => '',
                                            'id' => ''
                                        ),
                                        'default_value' => 1,
                                        'placeholder' => '',
                                        'prepend' => 'col-sm-offset-',
                                        'append' => '',
                                        'min' => 0,
                                        'max' => 12,
                                        'step' => 1,
                                        'readonly' => 0,
                                        'disabled' => 0
                                    )
                                )
                            )
                        ),
                        'min' => '',
                        'max' => ''
                    ),
                    
                    array(
                        'key' => 'eiv3ailohgh1ah',
                        'name' => 'Gallery',
                        'label' => 'Galerie',
                        'display' => 'row',
                        'sub_fields' => array(
                            
                            array(
                                'key' => 'acfp_xohnoozeeyae0g',
                                'label' => 'Hintergrundfarbe',
                                'name' => 'bg',
                                'type' => 'color_picker',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'default_value' => ''
                            ),
                            
                            array(
                                'key' => 'acfp_iecahzees2aing',
                                'label' => 'Bilder pro Zeile',
                                'name' => 'images_per_row',
                                'type' => 'number',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'default_value' => 4,
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'min' => 2,
                                'max' => 6,
                                'step' => '',
                                'readonly' => 0,
                                'disabled' => 0
                            ),
                            
                            array(
                                'key' => 'acfp_fieregoh1hai2f',
                                'label' => __('Images','affiliatetheme'),
                                'name' => 'images',
                                'type' => 'repeater',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'collapsed' => '',
                                'min' => 1,
                                'max' => 8,
                                'layout' => 'table',
                                'button_label' => 'Bild hinzufügen',
                                'sub_fields' => array(
                                    
                                    array(
                                        'key' => 'acfp_aehei2eeng2eiv',
                                        'label' => __('Image','affiliatetheme'),
                                        'name' => 'image',
                                        'type' => 'image',
                                        'instructions' => '',
                                        'required' => 1,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => ''
                                        ),
                                        'return_format' => 'url',
                                        'preview_size' => 'thumbnail',
                                        'library' => 'all',
                                        'min_width' => '',
                                        'min_height' => '',
                                        'min_size' => '',
                                        'max_width' => '',
                                        'max_height' => '',
                                        'max_size' => '',
                                        'mime_types' => ''
                                    ),
                                    
                                    array(
                                        'key' => 'acfp_thuchahxee3goh',
                                        'label' => 'Titel',
                                        'name' => 'title',
                                        'type' => 'text',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => ''
                                        ),
                                        'default_value' => '',
                                        'placeholder' => '',
                                        'prepend' => '',
                                        'append' => '',
                                        'maxlength' => '',
                                        'readonly' => 0,
                                        'disabled' => 0
                                    ),
                                    
                                    array(
                                        'key' => 'acfp_zeexohbarohp1h',
                                        'label' => 'Bildunterschrift',
                                        'name' => 'caption',
                                        'type' => 'text',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => ''
                                        ),
                                        'default_value' => '',
                                        'placeholder' => '',
                                        'prepend' => '',
                                        'append' => '',
                                        'maxlength' => '',
                                        'readonly' => 0,
                                        'disabled' => 0
                                    )
                                )
                            )
                        ),
                        'min' => '',
                        'max' => ''
                    ),
                    
                    array(
                        'key' => 'oosh0iequ7ob4j',
                        'name' => 'SlideShow',
                        'label' => 'Slideshow',
                        'display' => 'row',
                        'sub_fields' => array(
                            array(
                                'key' => 'acfp_rie3sahchaicho',
                                'label' => 'Zwischenzeit / Pause',
                                'name' => 'data_interval',
                                'type' => 'number',
                                'instructions' => 'Die Höhe der Wartezeit in Millisekunden für automatischen Zyklus.',
                                'required' => 1,
                                'default_value' => 5000,
                                'min' => 100,
                                'max' => 20000,
                                'step' => 1,
                                'readonly' => 0,
                                'disabled' => 0
                            ),
                            array(
                                'key' => 'acfp_equeivoucee3ru',
                                'label' => __('Images','affiliatetheme'),
                                'name' => 'slideshow_images',
                                'type' => 'repeater',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'min' => 1,
                                'max' => 100,
                                'layout' => 'row',
                                'button_label' => 'Bild hinzufügen',
                                'sub_fields' => array(
                                    array(
                                        'key' => 'acfp_beikoot4ahqu4t',
                                        'label' => __('Image','affiliatetheme'),
                                        'name' => 'slideshow_image',
                                        'type' => 'image',
                                        'required' => 1,
                                        'conditional_logic' => 0,
                                        'return_format' => 'array',
                                        'preview_size' => 'thumbnail',
                                        'library' => 'all',
                                    ),
                                    array(
                                        'key' => 'acfp_ieBichahbahv9a',
                                        'label' => 'Text',
                                        'name' => 'text_on_image',
                                        'type' => 'wysiwyg',
                                        'instructions' => 'Soll dieser Slider einen Text beinhalten?',
                                        'required' => 0,
                                        'tabs' => 'all',
                                        'toolbar' => 'full',
                                        'media_upload' => 0
                                    ),
                                    
                                    array(
                                        'key' => 'acfp_ing6saov7eiqu1',
                                        'label' => 'Link',
                                        'name' => 'slideshow_link',
                                        'type' => 'text',
                                        'message' => 'Soll dieser Slider auf eine bestimmte Seite/URL verlinken? Bitte mit "http://" angeben.',
                                        'required' => 0
                                    ),
                                    
                                    array(
                                        'key' => 'acfp_hi8ich7jaithee',
                                        'label' => 'Externer Link',
                                        'name' => 'is_extern_link',
                                        'type' => 'true_false',
                                        'message' => 'Im neuen Fenster öffnen.<br />Handelt es sich hierbei um einen externen Link? Falls ja, kann dieser durch diese Option in einem neuen Fenster geöffnet weren.',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'default_value' => 0
                                    ),
                                    
                                    array(
                                        'key' => 'acfp_oi1ad3ahgowaes',
                                        'label' => 'Nofollow',
                                        'name' => 'use_nofollow',
                                        'type' => 'true_false',
                                        'message' => 'nofollow hinzufügen.<br />Soll dieser Link mit "nofollow" markiert werden?',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'default_value' => 0
                                    )
                                )
                            )
                        )
                    ),
                    
                    array(
                        'key' => 'ohsh2ahb0ko6ah',
                        'name' => 'RawHtml',
                        'label' => 'HTML-Code',
                        'display' => 'row',
                        'sub_fields' => array(
                            
                            array(
                                'key' => 'acfp_ahmeiwa0caepha',
                                'label' => 'Hintergrundfarbe',
                                'name' => 'bg',
                                'type' => 'color_picker',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'default_value' => ''
                            ),
                            
                            array(
                                'key' => 'acfp_thee0thah2beey',
                                'label' => 'Wrapper-Klasse',
                                'name' => 'wrapper_class',
                                'type' => 'text',
                                'instructions' => 'z.B. col-sm-4 col-sm-offset-4',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'prepend' => '',
                                'append' => '',
                                'maxlength' => '',
                                'readonly' => 0,
                                'disabled' => 0
                            ),
                            
                            array(
                                'key' => 'acfp_ahpaij9ong3ash',
                                'label' => 'HTML',
                                'name' => 'html',
                                'type' => 'textarea',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => ''
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'maxlength' => '',
                                'rows' => '',
                                'new_lines' => '',
                                'readonly' => 0,
                                'disabled' => 0
                            )
                        ),
                        'min' => '',
                        'max' => ''
                    ),
                       
                    
                    array(
                        'key' => 'acfp_tez3aizae4aivo',
                        'name' => 'Wysiwyg',
                        'label' => 'Text-Block',
                        'display' => 'block',
                        
                        'sub_fields' => array(
                        
                            array(
                                'key' => 'acfp_ooxe1ikeifoi2z',
                                'name' => 'wysiwyg_content',
                                'type' => 'wysiwyg',
                                'instructions' => '',
                                'required' => 0,
                                'default_value' => '',
                                'tabs' => 'all',
                                'toolbar' => 'full',
                                'media_upload' => 1,
                                'readonly' => 0,
                                'disabled' => 0
                            )
                        ),
                        
                    ),
                    
                    array(
                        'key' => 'oomal2ievia8ph',
                        'name' => 'acfp_hr',
                        'label' => 'Trennlinie',
                        'display' => 'block'
                    )
                )
            )
        ),
        'location' => array(
            
            array(
                
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page'
                )
            ),
            
            array(
                
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-templates/full-width.php'
                )
            )
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            'the_content'
        ),
        'active' => 1,
        'description' => ''
    ));
