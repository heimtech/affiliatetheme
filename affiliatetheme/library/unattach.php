<?php

// Add Button to media library
function add_unattach_button($actions, $post) {
    if ($post->post_parent) {
        $url = admin_url('tools.php?page=unattach&noheader=true&id=' . $post->ID);
        $actions['unattach'] = '<a href="' . esc_url($url) . '">Verknüpfung löschen</a>';
    }
    return $actions;
}

// Function to set parent post to 0
function do_unattach() {
    global $wpdb;
    if (!empty($_REQUEST['id'])) {
        $wpdb->update($wpdb->posts, array('post_parent' => 0), array('id' => intval($_REQUEST['id']), 'post_type' => 'attachment'));
    }
    wp_redirect(admin_url('upload.php'));
    exit;
}

// Hook for unattach files
function load_unattach_module() {
    if (current_user_can('upload_files')) {
        add_filter('media_row_actions', 'add_unattach_button', 10, 2);
        add_submenu_page('tools.php', 'Unattach Media', 'Unattach', 'upload_files', 'unattach', 'do_unattach');
        remove_submenu_page('tools.php', 'unattach');
    }
}

// Add hook
add_action('admin_menu', 'load_unattach_module');