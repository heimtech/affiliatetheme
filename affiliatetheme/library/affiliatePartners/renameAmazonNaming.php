<?php
global $wpdb;

$dbPrefix = $wpdb->prefix;

$query = ' SELECT id FROM ' . $dbPrefix . 'posts 
    WHERE post_name="acf_eigenschaften-fuer-dieses-produkt"';
$row = $wpdb->get_row($query);

if ($apProductSettingsId = $row->id) {
    
    // amazon-link
    $query = 'SELECT * FROM ' . $dbPrefix . 'postmeta WHERE meta_key="field_52ac9d1b7e2fc" AND post_id="' . $apProductSettingsId . '" ';
    $row = $wpdb->get_row($query);
    if ($apProductSettingsMetaId = $row->meta_id) {
        $query = ' DELETE FROM ' . $dbPrefix . 'postmeta WHERE meta_id="' . $apProductSettingsMetaId . '" LIMIT 1 ';
        $wpdb->query($query);
    }
    
    // amazon-produkt-id
    $query = ' SELECT * FROM ' . $dbPrefix . 'postmeta WHERE meta_key="field_52e782fee682f" AND post_id="' . $apProductSettingsId . '" ';
    $row = $wpdb->get_row($query);
    
    if ($apProductSettingsMetaId = $row->meta_id) {
        $query = ' DELETE FROM ' . $dbPrefix . 'postmeta WHERE meta_id="' . $apProductSettingsMetaId . '" LIMIT 1 ';
        $wpdb->query($query);
    }
}

$dbTables = array(
    'options' => array(
        'option_name',
        'option_value'
    ),
    'postmeta' => array(
        'meta_key',
        'meta_value'
    ),
    'posts' => array(
        'post_content'
    )
);

$apRenameElements = array(
    's:46:\"affiliseo_buttons_amazon_cart_text_color_hover\"' => 's:42:\"affiliseo_buttons_ap_cart_text_color_hover\"',
    's:45:\"affiliseo_buttons_amazon_cart_bg_image_repeat\"' => 's:41:\"affiliseo_buttons_ap_cart_bg_image_repeat\"',
    's:42:\"theme_buttons_amazon_cart_text_color_hover\"' => 's:38:\"theme_buttons_ap_cart_text_color_hover\"',
    's:41:\"theme_buttons_amazon_cart_bg_image_repeat\"' => 's:37:\"theme_buttons_ap_cart_bg_image_repeat\"',
    's:41:\"affiliseo_buttons_amazon_text_color_hover\"' => 's:37:\"affiliseo_buttons_ap_text_color_hover\"',
    's:40:\"affiliseo_buttons_amazon_bg_image_repeat\"' => 's:36:\"affiliseo_buttons_ap_bg_image_repeat\"',
    's:40:\"affiliseo_buttons_amazon_cart_text_color\"' => 's:36:\"affiliseo_buttons_ap_cart_text_color\"',
    's:34:\"In Kooperation mit dem Amazon Shop\"' => 's:39:\"In Kooperation mit dem Affiliatepartner\"',
    's:38:\"affiliseo_buttons_amazon_cart_bg_hover\"' => 's:34:\"affiliseo_buttons_ap_cart_bg_hover\"',
    's:38:\"affiliseo_buttons_amazon_cart_bg_image\"' => 's:34:\"affiliseo_buttons_ap_cart_bg_image\"',
    's:36:\"theme_buttons_amazon_bg_image_repeat\"' => 's:32:\"theme_buttons_ap_bg_image_repeat\"',
    's:36:\"affiliseo_amazon_cart_button_section\"' => 's:32:\"affiliseo_ap_cart_button_section\"',
    's:36:\"theme_buttons_amazon_cart_text_color\"' => 's:32:\"theme_buttons_ap_cart_text_color\"',
    's:35:\"affiliseo_buttons_amazon_text_color\"' => 's:31:\"affiliseo_buttons_ap_text_color\"',
    's:34:\"theme_buttons_amazon_cart_bg_hover\"' => 's:30:\"theme_buttons_ap_cart_bg_hover\"',
    's:34:\"theme_buttons_amazon_cart_bg_image\"' => 's:30:\"theme_buttons_ap_cart_bg_image\"',
    's:33:\"affiliseo_buttons_amazon_bg_hover\"' => 's:29:\"affiliseo_buttons_ap_bg_hover\"',
    's:33:\"affiliseo_buttons_amazon_bg_image\"' => 's:29:\"affiliseo_buttons_ap_bg_image\"',
    's:32:\"affiliseo_buttons_amazon_cart_bg\"' => 's:28:\"affiliseo_buttons_ap_cart_bg\"',
    's:31:\"affiliseo_amazon_button_section\"' => 's:27:\"affiliseo_ap_button_section\"',
    's:29:\"comparison_show_amazon_button\"' => 's:25:\"comparison_show_ap_button\"',
    's:29:\"theme_buttons_amazon_bg_image\"' => 's:25:\"theme_buttons_ap_bg_image\"',
    's:28:\"layout_amazon_button_produkt\"' => 's:24:\"layout_ap_button_produkt\"',
    's:28:\"theme_buttons_amazon_cart_bg\"' => 's:24:\"theme_buttons_ap_cart_bg\"',
    's:27:\"affiliseo_buttons_amazon_bg\"' => 's:23:\"affiliseo_buttons_ap_bg\"',
    's:24:\"amazon_cart_button_label\"' => 's:20:\"ap_cart_button_label\"',
    's:23:\"allg_produktbild_amazon\"' => 's:19:\"allg_produktbild_ap\"',
    's:23:\"show_amazon_cart_button\"' => 's:19:\"show_ap_cart_button\"',
    's:23:\"theme_buttons_amazon_bg\"' => 's:19:\"theme_buttons_ap_bg\"',
    's:21:\"shipping_costs_amazon\"' => 's:17:\"shipping_costs_ap\"',
    's:20:\"delivery_time_amazon\"' => 's:16:\"delivery_time_ap\"',
    's:19:\"amazon_button_where\"' => 's:15:\"ap_button_where\"',
    's:19:\"amazon_button_label\"' => 's:15:\"ap_button_label\"',
    'amazon_cart_link' => 'ap_cart_link',
    'amazon_no_price' => 'ap_no_price',
    'amazon_link' => 'ap_pdp_link'
);

$affectedRows = 0;

foreach ($dbTables as $table => $columns) {
    
    $tableName = $dbPrefix . $table;
    
    foreach ($columns as $key => $column) {
        
        foreach ($apRenameElements as $key => $value) {
            
            // REPLACE(str,from_str,to_str)
            $query = ' UPDATE ' . $tableName . ' SET ' . $column . ' = REPLACE(' . $column . ', "' . $key . '", "' . $value . '")
				WHERE ' . $column . ' LIKE "%' . $key . '%" ';
            
            $updateResult = $wpdb->query($query);
            
            $affectedRows += intval($updateResult);
        }
    }
}

echo '<b>Anzahl der geänderten Einträge: ' . $affectedRows . '</b>';
