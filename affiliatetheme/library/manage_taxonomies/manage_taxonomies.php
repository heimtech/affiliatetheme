<?php
global $taxonomies_table;
$taxonomies_table = $wpdb->prefix . "taxonomies";

function affiliseo_menu_create_taxonomies() {
    add_submenu_page('edit.php?post_type=produkt', 'Taxonomien verwalten', 'Taxonomien verwalten', 'manage_options', 'create-taxonomy', 'create_taxonomy');
}

add_action('admin_menu', 'affiliseo_menu_create_taxonomies');

function create_taxonomy() {
    global $wpdb;
    global $taxonomies_table;

    if ($wpdb->get_var('SHOW TABLES LIKE "' . $taxonomies_table . '"') != $taxonomies_table) {
        $sql = "CREATE TABLE " . $taxonomies_table . " (
		`id` INT(9) NOT NULL AUTO_INCREMENT,
		`taxonomy_singular` VARCHAR(255) NOT NULL,
                `taxonomy_plural` VARCHAR(255) NOT NULL,
                `taxonomy_slug` VARCHAR(255) NOT NULL,
		UNIQUE KEY id (id)
		);";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    $taxonomy_singular = '';
    if (isset($_POST['taxonomy_singular']) && trim($_POST['taxonomy_singular']) !== '') {
        $taxonomy_singular = trim($_POST['taxonomy_singular']);
    }
    $taxonomy_plural = '';
    $taxonomy_slug = '';
    if (isset($_POST['taxonomy_plural']) && trim($_POST['taxonomy_plural']) !== '') {
        $taxonomy_plural = trim($_POST['taxonomy_plural']);
        $taxonomy_slug = generate_slug($taxonomy_plural);
    }
    ?>
    <link href="<?php echo get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css'; ?>" type="text/css" rel="stylesheet">
    <style type="text/css">
        .modal-dialog {
            margin-top: 5em;
            background-color: white;
        }
    </style>
    <div class="wrap">
        <h2>Taxonomien verwalten</h2>
        <form action="" method="post">
            <table class="widefat">
                <tfoot>
                    <tr>
                        <th colspan="2">
                            <input id="create_taxonomy" type="submit" name="submit" value="Taxonomie erstellen" class="button-primary" style="" />
                        </th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td style="padding:25px;font-family:Verdana, Geneva, sans-serif;color:#666;">
                            <label for="taxonomy_singular">Singular Taxonomie</label>
                        </td>      
                        <td style="padding:25px;font-family:Verdana, Geneva, sans-serif;color:#666;">
                            <input id="taxonomy_singular" type="text" class="widefat" name="taxonomy_singular" value="" placeholder="Singular Taxonomie" />
                        </td>     
                    </tr>
                    <tr>
                        <td style="padding:25px;font-family:Verdana, Geneva, sans-serif;color:#666;">
                            <label for="taxonomy_plural">Plural Taxonomie</label>
                        </td>      
                        <td style="padding:25px;font-family:Verdana, Geneva, sans-serif;color:#666;">
                            <input id="taxonomy_plural" type="text" class="widefat" name="taxonomy_plural" value="" placeholder="Plural Taxonomie" />
                        </td>     
                    </tr>
                </tbody>
            </table>
        </form>

        <?php
        if ($taxonomy_singular !== '' && $taxonomy_plural !== '' && $taxonomy_slug !== '') {
            $query = "INSERT INTO $taxonomies_table (taxonomy_singular, taxonomy_plural, taxonomy_slug) VALUES (%s, %s, %s)";
            $res = $wpdb->query($wpdb->prepare($query, $taxonomy_singular, $taxonomy_plural, $taxonomy_slug));

            if ($res === false) :
                ?>
                <div id="message" class="error below-h2"><p>Fehler beim Speichern!</p></div>
            <?php else : ?>
                <div id="message" class="updated below-h2"><p>Taxonomie erfolgreich gespeichert!</p></div>
            <?php
            endif;
        }
        ?>

        <a href="<?php echo site_url(); ?>" id="blogurl" style="display: none;"></a>
        <div id="data"></div>
        <?php
        if ($wpdb->get_var('SHOW TABLES LIKE "' . $taxonomies_table . '"') == $taxonomies_table) {
            global $wpdb;

            $res = $wpdb->get_results(
                    'SELECT * FROM '
                    . $taxonomies_table, OBJECT
            );

            if (count($res) > 0) {
                foreach ($res as $mytax) {
                    $taxonomy_singular_edit = '';
                    if (isset($_POST["taxonomy_singular_edit_$mytax->id"]) && trim($_POST["taxonomy_singular_edit_$mytax->id"]) !== '') {
                        $taxonomy_singular_edit = trim($_POST["taxonomy_singular_edit_$mytax->id"]);
                    }
                    $taxonomy_plural_edit = '';
                    if (isset($_POST["taxonomy_plural_edit_$mytax->id"]) && trim($_POST["taxonomy_plural_edit_$mytax->id"]) !== '') {
                        $taxonomy_plural_edit = trim($_POST["taxonomy_plural_edit_$mytax->id"]);
                    }
                    $taxonomy_slug_edit = '';
                    if (isset($_POST["taxonomy_slug_edit_$mytax->id"]) && trim($_POST["taxonomy_slug_edit_$mytax->id"]) !== '') {
                        $taxonomy_slug_edit = trim($_POST["taxonomy_slug_edit_$mytax->id"]);
                        $taxonomy_slug_edit = generate_slug($taxonomy_slug_edit);
                    }
                    if (isset($_POST["taxonomy_singular_edit_$mytax->id"]) && trim($_POST["taxonomy_singular_edit_$mytax->id"]) !== '' &&
                            isset($_POST["taxonomy_plural_edit_$mytax->id"]) && trim($_POST["taxonomy_plural_edit_$mytax->id"]) !== '' &&
                            isset($_POST["taxonomy_slug_edit_$mytax->id"]) && trim($_POST["taxonomy_slug_edit_$mytax->id"]) !== '') {
                        $wpdb->query(
                                $wpdb->prepare(
                                        "UPDATE $taxonomies_table
						SET taxonomy_singular = %s,
						taxonomy_plural = %s,
                                                taxonomy_slug = %s
						WHERE ID = %d
						", $taxonomy_singular_edit, $taxonomy_plural_edit, $taxonomy_slug_edit, (int) $mytax->id
                                )
                        );
                    }
                    if (isset($_POST["taxonomy_id_delete_$mytax->id"]) && trim($_POST["taxonomy_id_delete_$mytax->id"]) === '1') {
                        $wpdb->delete($taxonomies_table, array('ID' => 1), array((int) $mytax->id));
                    }
                }
            }

            $res2 = $wpdb->get_results(
                    'SELECT * FROM '
                    . $taxonomies_table, OBJECT
            );

            if (count($res2) > 0) :
                ?>
                <h2>Taxonomien bearbeiten und löschen</h2>
                <div class="container-fluid widefat-div">
                    <div class="row widefat-head">
                        <div class="col-sm-3">
                            <strong>Singular</strong>
                        </div>
                        <div class="col-sm-3">
                            <strong>Plural</strong>
                        </div>
                        <div class="col-sm-3">
                            <strong>Slug</strong>
                        </div>
                        <div class="col-sm-3">
                            <strong>bearbeiten / löschen</strong>
                        </div>
                    </div>
                    <?php foreach ($res2 as $mytax) : ?>
                        <div class="row widefat-content">
                            <div class="col-sm-3">
                                <?php echo $mytax->taxonomy_singular; ?> 
                            </div>
                            <div class="col-sm-3">
                                <?php echo $mytax->taxonomy_plural; ?>
                            </div>
                            <div class="col-sm-3">
                                <?php echo $mytax->taxonomy_slug; ?>
                            </div>
                            <div class="col-sm-3">
                                <a 
                                    class="button-primary open-edit-taxonomy" data-id="<?php echo $mytax->id; ?>">
                                    bearbeiten
                                </a>
                                <a 
                                    class="button-primary open-delete-taxonomy" data-id="<?php echo $mytax->id; ?>">
                                    löschen
                                </a>
                            </div>
                        </div>
                        <div class="modal fade" id="edit-modal-<?php echo $mytax->id; ?>">
                            <div class="modal-dialog">
                                <div id="edit-tax-<?php echo $mytax->id; ?>" class=""modal-content">
                                     <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Taxonomie bearbeiten</h4>
                                    </div>
                                    <form action="" method="post" class="modal-body">
                                        <div class="row widefat-content widefat-content">
                                            <div class="col-sm-6">
                                                <label for="taxonomy_singular_edit_<?php echo $mytax->id; ?>">Singular</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input id="taxonomy_singular_edit_<?php echo $mytax->id; ?>" type="text" class="widefat" 
                                                       name="taxonomy_singular_edit_<?php echo $mytax->id; ?>" 
                                                       value="<?php echo $mytax->taxonomy_singular; ?>" placeholder="Singular" />
                                            </div>
                                        </div>
                                        <div class="row widefat-content widefat-content">
                                            <div class="col-sm-6">
                                                <label for="taxonomy_plural_edit_<?php echo $mytax->id; ?>">Plural</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input id="taxonomy_plural_edit_<?php echo $mytax->id; ?>" type="text" class="widefat" 
                                                       name="taxonomy_plural_edit_<?php echo $mytax->id; ?>" 
                                                       value="<?php echo $mytax->taxonomy_plural; ?>" placeholder="Plural" />
                                            </div>
                                        </div>
                                        <div class="row widefat-content widefat-content">
                                            <div class="col-sm-6">
                                                <label for="taxonomy_slug_edit_<?php echo $mytax->id; ?>">Slug</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input id="taxonomy_slug_edit_<?php echo $mytax->id; ?>" type="text" class="widefat" 
                                                       name="taxonomy_slug_edit_<?php echo $mytax->id; ?>" 
                                                       value="<?php echo $mytax->taxonomy_slug; ?>" placeholder="Slug" />
                                            </div>
                                        </div>
                                        <div class="row widefat-content widefat-content">
                                            <div class="col-sm-12">
                                                <input id="save_taxonomy_<?php echo $mytax->id; ?>" type="submit" name="submit" value="speichern" class="button-primary" style="" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php #add_thickbox(); ?>
                        <div class="modal fade" id="delete-modal-<?php echo $mytax->id; ?>">
                            <div class="modal-dialog">
                                <div id="delete-tax-<?php echo $mytax->id; ?>" class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Taxonomie löschen</h4>
                                    </div>
                                    <form action="" method="post" class="modal-body">
                                        <input type="hidden" id="taxonomy_id_delete_<?php echo $mytax->id; ?>"
                                               name="taxonomy_id_delete_<?php echo $mytax->id; ?>" value="1">
                                        <div class="row widefat-content widefat-content">
                                            <div class="col-sm-12 text-center">
                                                <strong>Wirklich löschen?</strong>
                                            </div>
                                        </div>
                                        <div class="row widefat-content widefat-content">
                                            <div class="col-sm-6 text-center">
                                                <input id="delete_taxonomy_<?php echo $mytax->id; ?>" type="submit" name="submit" 
                                                       value="OK" class="button-primary" style="" />
                                            </div>
                                            <div class="col-sm-6 text-center">
                                                <a class="close_delete button-primary" data-id="<?php echo $mytax->id; ?>">
                                                    Abbrechen
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                    endforeach;
                endif;
            }
            ?>
        </div>
    </div>
    <script src="<?php echo get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js'; ?>" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            checkData();
            setInterval(function () {
                checkData();
            }, 100);
            $('.open-edit-taxonomy').click(function () {
                $('#edit-modal-' + $(this).attr('data-id')).modal('show');
            });
            $('.open-delete-taxonomy').click(function () {
                $('#delete-modal-' + $(this).attr('data-id')).modal('show');
            });
            $('.close_delete').click(function () {
                $('#delete-modal-' + $(this).attr('data-id')).modal('hide');
            });
            function checkData() {
                var taxonomy_singular = $.trim($('#taxonomy_singular').val());
                var taxonomy_plural = $.trim($('#taxonomy_plural').val());
                if (taxonomy_singular === '' || taxonomy_plural === '') {
                    $("#create_taxonomy").prop('disabled', true);
                } else {
                    $("#create_taxonomy").prop('disabled', false);
                }
            }
        });
    </script>
    <?php
}
