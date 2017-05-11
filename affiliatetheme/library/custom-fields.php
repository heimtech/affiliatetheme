<?php

/**
 * Post/Page Custom Fields Meta Boxes
 */
global $new_meta_boxes;

$new_meta_boxes = array(
    "_post_sticky_headline" => array(
        "name" => "_post_sticky_headline",
        "std" => "",
        "title" => "Alternative Überschrift für Sticky-Beiträge",
        "description" => "",
        "type" => "text",
        "location" => "Post"),
);

function new_meta_boxes_post() {
    new_meta_boxes('Post');
}

function new_meta_boxes_page() {
    new_meta_boxes('Page');
}

function new_meta_boxes($type) {
    global $post, $new_meta_boxes;

    // Use nonce for verification
    echo '<input type="hidden" name="affiliseo_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<div class="form-wrap">';

    foreach ($new_meta_boxes as $meta_box) {
        if ($meta_box['location'] == $type) {

            if ($meta_box['type'] == 'title') {
                echo '<p style="font-size: 18px; font-weight: bold; font-style: normal; color: #e5e5e5; text-shadow: 0 1px 0 #111; line-height: 40px; background-color: #464646; border: 1px solid #111; padding: 0 10px; -moz-border-radius: 6px;">' . $meta_box['title'] . '</p>';
            } else {
                $meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);

                if ($meta_box_value == "")
                    $meta_box_value = $meta_box['std'];



                switch ($meta_box['type']) {
                    case 'headline':
                        echo '<h2 style="margin:0;padding:0;">' . $meta_box['title'] . '</h2>';
                        break;

                    case 'text_one_third':
                        echo '<div class="form-field form-required" style="width:300px;margin-right:10px;float:left;">';
                        echo '<label for="' . $meta_box['name'] . '"><strong>' . $meta_box['title'] . '</strong></label>';
                        echo '<input type="text" name="' . $meta_box['name'] . '" value="' . htmlspecialchars($meta_box_value) . '" style="border-color: #ccc;" />';
                        echo '<p>' . $meta_box['description'] . '</p>';
                        echo '</div>';
                        break;

                    case 'text_one_third_last':
                        echo '<div class="form-field form-required" style="width:300px;float:left;">';
                        echo '<label for="' . $meta_box['name'] . '"><strong>' . $meta_box['title'] . '</strong></label>';
                        echo '<input type="text" name="' . $meta_box['name'] . '" value="' . htmlspecialchars($meta_box_value) . '" style="border-color: #ccc;" />';
                        echo '<p>' . $meta_box['description'] . '</p>';
                        echo '</div><div class="clearfix"></div>';
                        break;

                    case 'text':
                        echo '<div class="form-field form-required">';
                        echo '<label for="' . $meta_box['name'] . '"><strong>' . $meta_box['title'] . '</strong></label>';
                        echo '<input type="text" name="' . $meta_box['name'] . '" value="' . htmlspecialchars($meta_box_value) . '" style="border-color: #ccc;" />';
                        echo '<p>' . $meta_box['description'] . '</p>';
                        echo '</div>';
                        break;

                    case 'textarea':
                        echo '<div class="form-field form-required">';
                        echo '<label for="' . $meta_box['name'] . '"><strong>' . $meta_box['title'] . '</strong></label>';
                        echo '<textarea name="' . $meta_box['name'] . '" style="border-color: #ccc;" rows="10">' . htmlspecialchars($meta_box_value) . '</textarea>';
                        echo '<p>' . $meta_box['description'] . '</p>';
                        echo '</div>';
                        break;

                    case 'checkbox':
                        echo '<div class="form-field form-required">';
                        if ($meta_box_value == '1') {
                            $checked = "checked=\"checked\"";
                        } else {
                            $checked = "";
                        }
                        echo '<label for="' . $meta_box['name'] . '"><strong>' . $meta_box['title'] . '</strong>&nbsp;<input style="width: 20px;" type="checkbox" name="' . $meta_box['name'] . '" value="1" ' . $checked . ' /></label>';
                        echo '<p>' . $meta_box['description'] . '</p>';
                        echo '</div>';
                        break;

                    case 'checkbox_small':
                        echo '<div class="form-field form-required" style="width:120px;margin-right:10px;float:left;">';
                        if ($meta_box_value == '1') {
                            $checked = "checked=\"checked\"";
                        } else {
                            $checked = "";
                        }
                        echo '<label for="' . $meta_box['name'] . '"><strong>' . $meta_box['title'] . '</strong>&nbsp;<input style="width: 20px;" type="checkbox" name="' . $meta_box['name'] . '" value="1" ' . $checked . ' /></label>';
                        echo '<p>' . $meta_box['description'] . '</p>';
                        echo '</div>';
                        break;

                    case 'checkbox_small_last':
                        echo '<div class="form-field form-required" style="width:120px;float:left;">';
                        if ($meta_box_value == '1') {
                            $checked = "checked=\"checked\"";
                        } else {
                            $checked = "";
                        }
                        echo '<label for="' . $meta_box['name'] . '"><strong>' . $meta_box['title'] . '</strong>&nbsp;<input style="width: 20px;" type="checkbox" name="' . $meta_box['name'] . '" value="1" ' . $checked . ' /></label>';
                        echo '<p>' . $meta_box['description'] . '</p>';
                        echo '</div><div class="clearfix"></div>';
                        break;

                    case 'select':
                        echo '<div class="form-field form-required">';
                        echo '<label for="' . $meta_box['name'] . '"><strong>' . $meta_box['title'] . '</strong></label>';

                        echo '<select name="' . $meta_box['name'] . '">';

                        // Loop through each option in the array
                        foreach ($meta_box['options'] as $option) {
                            if (is_array($option)) {
                                echo '<option ' . ( $meta_box_value == $option['value'] ? 'selected="selected"' : '' ) . ' value="' . $option['value'] . '">' . $option['text'] . '</option>';
                            } else {
                                echo '<option ' . ( $meta_box_value == $option ? 'selected="selected"' : '' ) . ' value="' . $option['value'] . '">' . $option['text'] . '</option>';
                            }
                        }

                        echo '</select>';
                        echo '<p>' . $meta_box['description'] . '</p>';
                        echo '</div>';
                        break;

                    case 'firmen_category':
                        echo '<div class="form-field form-required">';
                        echo '<label for="' . $meta_box['name'] . '"><strong>' . $meta_box['title'] . '</strong></label>';

                        echo '<ul style="margin-top: 5px;" class="sort-children">';

                        // If building the portfolio categories list, bring the already selected and ordered cats to the top					
                        $selected_cats = explode(",", $meta_box_value);
                        foreach ($selected_cats as $selected_cat) {
                            if ($selected_cat != ' ' && $selected_cat != '') {
                                $tax_term = get_term($selected_cat, 'firmen_category');
                                echo '<li class="sortable" style="margin-bottom: 0;"><input style="width: 20px;" type="checkbox" name="' . $meta_box['name'] . '[]" value="' . $selected_cat . '" checked="checked" />&nbsp;' . $tax_term->name . '</li>';
                            }
                        }

                        $unselected_args = array('taxonomy' => 'firmen_category', 'hide_empty' => '0', 'exclude' => $selected_cats);
                        $unselected_cats = get_categories($unselected_args);
                        foreach ($unselected_cats as $unselected_cat) {
                            echo '<li class="sortable" style="margin-bottom: 0;"><input style="width: 20px;" type="checkbox" name="' . $meta_box['name'] . '[]" value="' . $unselected_cat->cat_ID . '" />&nbsp;' . $unselected_cat->name . '</li>';
                        }

                        echo '</ul>';
                        echo '<p>' . $meta_box['description'] . '</p>';
                        echo '</div>';
                        break;

                    case 'image':
                        echo '<div class="form-field form-required">';
                        echo '<label for="' . $meta_box['name'] . '"><strong>' . $meta_box['title'] . '</strong></label>';
                        echo '<input type="text" name="' . $meta_box['name'] . '" id="' . $meta_box['name'] . '" value="' . htmlspecialchars($meta_box_value) . '" style="width: 400px; border-color: #ccc;" />';
                        echo '<input type="button" id="button' . $meta_box['name'] . '" value="Browse" style="width: 60px;" class="button button-affiliseo-upload" rel="' . $post->ID . '" />';
                        echo '&nbsp;<a href="#" style="color: red;" class="remove-affiliseo-upload">remove</a>';
                        echo '<p>' . $meta_box['description'] . '</p>';
                        echo '</div>';
                        break;
                }
            }
        }
    }

    echo '</div>';
}

function create_meta_box() {
    global $theme_name;
    if (function_exists('add_meta_box')) {
        add_meta_box('new_meta_boxes_post', AFFILISEO_THEMENAME . '  - Allgemeine Einstellungen f&uuml;r diesen Artikel', 'new_meta_boxes_post', 'post', 'normal', 'high');
        //add_meta_box( 'new_meta_boxes_page', AFFILISEO_THEMENAME . '  - Weitere Informationen f&uuml;r diese Seite', 'new_meta_boxes_page', 'page', 'normal', 'high' );	
    }
}

function save_postdata($post_id) {

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if (isset($_POST['affiliseo_meta_box_nonce']) && !wp_verify_nonce($_POST['affiliseo_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    if (wp_is_post_revision($post_id) or wp_is_post_autosave($post_id))
        return $post_id;

    global $post, $new_meta_boxes;

    foreach ($new_meta_boxes as $meta_box) {

        if ($meta_box['type'] != 'title)') {

            if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
                if (!current_user_can('edit_page', $post_id))
                    return $post_id;
            } else {
                if (!current_user_can('edit_post', $post_id))
                    return $post_id;
            }

            if (isset($_POST[$meta_box['name']]) && is_array($_POST[$meta_box['name']])) {

                foreach ($_POST[$meta_box['name']] as $cat) {
                    $cats .= $cat . ",";
                }
                $data = substr($cats, 0, -1);
            } else {
                $data = $_POST[$meta_box['name']];
            }

            if (get_post_meta($post_id, $meta_box['name']) == "")
                add_post_meta($post_id, $meta_box['name'], $data, true);
            elseif ($data != get_post_meta($post_id, $meta_box['name'], true))
                update_post_meta($post_id, $meta_box['name'], $data);
            elseif ($data == "")
                delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
        }
    }
}

//add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');

function my_admin_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('upload-js', AFFILISEO_ADMIN_JS . '/upload.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_script('upload-js');
    wp_enqueue_script('admin_js', AFFILISEO_ADMIN_JS . '/admin.js', array('jquery'));
    wp_enqueue_script('functions_js', AFFILISEO_ADMIN_JS . '/functions.js', array('jquery'));    
}

function my_admin_styles() {
    wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');
?>