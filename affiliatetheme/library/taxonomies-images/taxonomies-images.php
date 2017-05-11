<?php
define('AFFILISEO_IMAGE_PLACEHOLDER', get_template_directory_uri() . '/library/taxonomies-images/images/placeholder.png');

function affiliseo_taxonomy_images_init() {
    $taxonomies = get_taxonomies();
    if (is_array($taxonomies)) {
        foreach ($taxonomies as $taxonomy) {
            add_action($taxonomy . '_add_form_fields', 'affiliseo_taxonomy_images_add_taxonomy_field');
            add_action($taxonomy . '_edit_form_fields', 'affiliseo_taxonomy_images_edit_taxonomy_field');
            add_filter('manage_edit-' . $taxonomy . '_columns', 'affiliseo_taxonomy_images_taxonomy_columns');
            add_filter('manage_' . $taxonomy . '_custom_column', 'affiliseo_taxonomy_images_taxonomy_column', 10, 3);
        }
    }
}

add_action('admin_init', 'affiliseo_taxonomy_images_init');

function affiliseo_taxonomy_images_add_taxonomy_field() {
    if (get_bloginfo('version') >= 3.5) {
        wp_enqueue_media();
    } else {
        wp_enqueue_style('thickbox');
        wp_enqueue_script('thickbox');
    }

    ob_start();
    ?>

    <div class="form-field">
        <label for="taxonomy_image">Thumbnail</label>
        <input type="text" name="taxonomy_image" id="taxonomy_image" value="" />
        <br/>
        <button class="affiliseo_taxonomy_images_upload_image_button button">Bild hochladen / Bild hinzufügen</button>
    </div>

    <?php
    echo ob_get_clean();
    echo affiliseo_taxonomy_images_script();
}

function affiliseo_taxonomy_images_edit_taxonomy_field($taxonomy) {
    if (get_bloginfo('version') >= 3.5) {
        wp_enqueue_media();
    } else {
        wp_enqueue_style('thickbox');
        wp_enqueue_script('thickbox');
    }

    if (affiliseo_taxonomy_images_taxonomy_image_url($taxonomy->term_id, NULL, TRUE) == AFFILISEO_IMAGE_PLACEHOLDER)
        $image_text = "";
    else
        $image_text = affiliseo_taxonomy_images_taxonomy_image_url($taxonomy->term_id, NULL, TRUE);
    ob_start();
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="taxonomy_image">Thumbnail</label></th>
        <td>
            <img class="taxonomy-image" id="taxonomy_img" src="<?php echo affiliseo_taxonomy_images_taxonomy_image_url($taxonomy->term_id, NULL, TRUE); ?>"/><br/>
            <input type="text" name="taxonomy_image" id="taxonomy_image" value="<?php echo $image_text; ?>" /><br />
            <button class="affiliseo_taxonomy_images_upload_image_button button">Bild hochladen / Bild hinzufügen</button>
            <button class="affiliseo_taxonomy_images_remove_image_button button">Bild entfernen</button>
        </td>
    </tr>
    <?php
    echo ob_get_clean();
    echo affiliseo_taxonomy_images_script();
}

function affiliseo_taxonomy_images_script() {
    return '<script type="text/javascript">
	    jQuery(document).ready(function($) {
			var wordpress_ver = "' . get_bloginfo("version") . '", upload_button;
			$(".affiliseo_taxonomy_images_upload_image_button").click(function(event) {
				upload_button = $(this);
				var frame;
				if (wordpress_ver >= "3.5") {
					event.preventDefault();
					if (frame) {
						frame.open();
						return;
					}
					frame = wp.media();
					frame.on( "select", function() {
						// Grab the selected attachment.
						var attachment = frame.state().get("selection").first();
						frame.close();
						if (upload_button.parent().prev().children().hasClass("tax_list")) {
							upload_button.parent().prev().children().val(attachment.attributes.url);
							upload_button.parent().prev().prev().children().attr("src", attachment.attributes.url);
						}
						else {
							$("#taxonomy_image").val(attachment.attributes.url);
							$("#taxonomy_img").attr("src", attachment.attributes.url);
						}
					});
					frame.open();
				}
				else {
					tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
					return false;
				}
			});
			
			$(".affiliseo_taxonomy_images_remove_image_button").click(function() {
				$("#taxonomy_image").val("");
				$(this).parent().siblings(".title").children("img").attr("src","' . AFFILISEO_IMAGE_PLACEHOLDER . '");
				$(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
				return false;
			});
			
			if (wordpress_ver < "3.5") {
				window.send_to_editor = function(html) {
					imgurl = $("img",html).attr("src");
					if (upload_button.parent().prev().children().hasClass("tax_list")) {
						upload_button.parent().prev().children().val(imgurl);
						upload_button.parent().prev().prev().children().attr("src", imgurl);
					}
					else
						$("#taxonomy_image").val(imgurl);
					tb_remove();
				}
			}
			
			$(".editinline").live("click", function(){  
			    var tax_id = $(this).parents("tr").attr("id").substr(4);
			    var thumb = $("#tag-"+tax_id+" .thumb img").attr("src");
				if (thumb != "' . AFFILISEO_IMAGE_PLACEHOLDER . '") {
					$(".inline-edit-col :input[name=\'taxonomy_image\']").val(thumb);
				} else {
					$(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
				}
				$(".inline-edit-col .title img").attr("src",thumb);
			    return false;  
			});  
	    });
	</script>';
}

add_action('edit_term', 'affiliseo_taxonomy_images_save_taxonomy_image');
add_action('create_term', 'affiliseo_taxonomy_images_save_taxonomy_image');

function affiliseo_taxonomy_images_save_taxonomy_image($term_id) {
    if (isset($_POST['taxonomy_image']))
        update_option('affiliseo_taxonomy_images_taxonomy_image' . $term_id, $_POST['taxonomy_image']);
}

function affiliseo_taxonomy_images_get_attachment_id_by_url($image_src) {
    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid = '$image_src'";
    $id = $wpdb->get_var($query);
    return (!empty($id)) ? $id : NULL;
}

function affiliseo_taxonomy_images_taxonomy_image_url($term_id = NULL, $size = NULL, $return_placeholder = FALSE) {
    if (!$term_id) {
        if (is_category()) {
            $term_id = get_query_var('cat');
        } elseif (is_tax()) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $term_id = $current_term->term_id;
        }
    }

    $taxonomy_image_url = get_option('affiliseo_taxonomy_images_taxonomy_image' . $term_id);
    if (!empty($taxonomy_image_url)) {
        $attachment_id = affiliseo_taxonomy_images_get_attachment_id_by_url($taxonomy_image_url);
        if (!empty($attachment_id)) {
            if (empty($size))
                $size = 'full';
            $taxonomy_image_url = wp_get_attachment_image_src($attachment_id, $size);
            $taxonomy_image_url = $taxonomy_image_url[0];
        }
    }

    if ($return_placeholder)
        return ($taxonomy_image_url != '') ? $taxonomy_image_url : AFFILISEO_IMAGE_PLACEHOLDER;
    else
        return $taxonomy_image_url;
}

function affiliseo_taxonomy_images_quick_edit_custom_box($column_name, $screen, $name) {
    if ($column_name == 'thumb')
        echo '<fieldset>
		<div class="thumb inline-edit-col">
			<label>
				<span class="title"><img src="" alt="Thumbnail"/></span>
				<span class="input-text-wrap"><input type="text" name="taxonomy_image" value="" class="tax_list" /></span>
				<span class="input-text-wrap">
					<button class="affiliseo_taxonomy_images_upload_image_button button">Bild hochladen / Bild hinzufügen</button>
					<button class="affiliseo_taxonomy_images_remove_image_button button">Bild entfernen</button>
				</span>
			</label>
		</div>
	</fieldset>';
}

function affiliseo_taxonomy_images_taxonomy_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['thumb'] = __('Image','affiliatetheme');

    unset($columns['cb']);

    return array_merge($new_columns, $columns);
}

function affiliseo_taxonomy_images_taxonomy_column($columns, $column, $id) {
    if ($column == 'thumb')
        $columns = '<span><img src="' . affiliseo_taxonomy_images_taxonomy_image_url($id, NULL, TRUE) . '" alt="' . __('Thumbnail', 'zci') . '" class="wp-post-image" /></span>';

    return $columns;
}

// change 'insert into post' to 'use this image'
function affiliseo_taxonomy_images_change_insert_button_text($safe_text, $text) {
    return str_replace("Insert into Post", "Use this image", $text);
}

// style the image in category list
if (strpos($_SERVER['SCRIPT_NAME'], 'edit-tags.php') > 0) {
    add_action('quick_edit_custom_box', 'affiliseo_taxonomy_images_quick_edit_custom_box', 10, 3);
    add_filter("attribute_escape", "affiliseo_taxonomy_images_change_insert_button_text", 10, 2);
}

