<?php
define('WP_USE_THEMES', false);
require_once ('../../../../wp-load.php');

$postId = filter_input(INPUT_POST, 'postId', FILTER_SANITIZE_STRING);

$fieldsData = get_field_data(get_fields($postId));

wp_send_json($fieldsData);

function get_field_data($fields)
{
    $data = '';
    if (is_array($fields) && count($fields) > 0) {
        
        foreach ($fields as $key => $field) {
            
            switch (gettype($field)) {
                case 'string':
                    $data = $data . ' ' . $field;
                    break;
                case 'array':
                    if (isset($field['sizes']['thumbnail'])) {
                        $alt = '';
                        if (isset($field['alt'])) {
                            $alt = $field['alt'];
                        }
                        $title = '';
                        if (isset($field['title'])) {
                            $title = $field['title'];
                        }
                        $data = $data . ' <img src="' . $field['sizes']['thumbnail'] . '" alt="' . $alt . '" title="' . $title . '"/>';
                    } else {
                        $data = $data . ' ' . get_field_data($field);
                    }
                    break;
            }
        }
    }
    
    return $data;
}


        
