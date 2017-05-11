<?php

if (get_magic_quotes_gpc()) {
    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
    $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}

$args = array(
    'post_type' => 'produkt',
    'post_status' => 'publish',
    'posts_per_page' => -1
);
$products = get_posts($args);


$products_mega_menu = array();
array_push($products_mega_menu, array("value" => "random", "text" => "Zufälliges Produkt"));

global $brand_plural;
global $type_plural;

foreach ($products as $product) {
    array_push($products_mega_menu, array("value" => $product->ID, "text" => get_the_title($product->ID)));
}

$args = array(
    'post_type' => 'page',
    'post_status' => 'publish',
    'posts_per_page' => -1
);
$pages = get_posts($args);

$pages_popup = array();

foreach ($pages as $page) {
    array_push($pages_popup, array("value" => $page->ID, "text" => get_the_title($page->ID)));
}

include_once 'panel_options.php';

if ('save' == $_REQUEST['action']) {

    foreach ($options as $value) {
        if ($_REQUEST[$value['id']] == '') {
            affiliseo_update_option($value['id'], ' ');
        } else {
            if (is_array($_REQUEST[$value['id']])) {
                $cats = "-1";
                foreach ($_REQUEST[$value['id']] as $cat) {
                    $cats .= "," . $cat;
                }
                affiliseo_update_option($value['id'], str_replace("-1,", "", $cats));
            } else {
                affiliseo_update_option($value['id'], stripslashes($_REQUEST[$value['id']]));
            }
        }
    }
} else if ('reset' == $_REQUEST['action']) {

    foreach ($options as $value) {
        delete_option($value['id']);
    }
}

$i = 0;

if ($_REQUEST['action'] == 'save')
    echo '<div id="message" class="updated fade"><p><strong>' . AFFILISEO_THEMENAME . ' Einstellungen gespeichert.</strong></p></div>';
?>
<style>
    .green {
        color: #2ecc71;
    }
    .red {
        color: #e74c3c;
    }
</style>
<div class="wrap rm_wrap">

    <div id="icon-options-general" class="icon32"></div>
    <h2><?php echo AFFILISEO_THEMENAME ?> Settings</h2>
    <p>
        Damit Sie alle Funktionen des AffiliateThemes nutzen können, müssen die folgenden Module aktiviert sein. 
        Bei Problemen bei der Aktivierung dieser Module wenden Sie sich bitte an Ihren Provider.
    </p>
    <table class="widefat">
        <tr>
            <td>
                PHP-Version
            </td>
            <td>
                <?php
                echo phpversion();
                ?>
            </td>
        </tr>
        <tr>
            <td>
                cURL
            </td>
            <td>
                <?php
                $curl_version = function_exists('curl_version');
                if ($curl_version) :
                    ?>
                    <i class="fa fa-check fa-2x green"></i>
                    <?php
                else :
                    ?>
                    <i class="fa fa-times fa-2x red"></i>
                <?php
                endif;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                allow_url_fopen
            </td>
            <td>
                <?php
                $allow_url_fopen = ini_get('allow_url_fopen');
                if ($allow_url_fopen === '1') :
                    ?>
                    <i class="fa fa-check fa-2x green"></i>
                    <?php
                else :
                    ?>
                    <i class="fa fa-times fa-2x red"></i>
                <?php
                endif;
                ?>
            </td>
        </tr>
        
        <tr>
        	<td>Amazonbezeichnungen umbenennen</td>
        	<td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=af&amazon_update=true">Updates durchführen</a></td>
        </tr>
        <?php
        if($_GET['amazon_update'] == 'true'){
            echo '<tr><td colspan="2">';
            require_once dirname(__FILE__).'/../affiliatePartners/renameAmazonNaming.php';
            echo '</td></tr>';
        }
        ?>
        
        <tr>
        	<td>Alte Bildverknüpfungen in die Produkt-Bilder-Gallerie überführen</td>
        	<td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?page=af&attachments_update=true">Updates durchführen</a></td>
        </tr>
        <?php
        if($_GET['attachments_update'] == 'true'){
            echo '<tr><td colspan="2">';
            require_once dirname(__FILE__).'/../affiliatePartners/attachmentsUpdate.php';
            echo '</td></tr>';
        }
        ?>
        
    </table>
    <?php
    $licence_data = get_licence_data();
    if ($licence_data['licence_status'] == 'invalid') {
        ?>
        <p>Ihr angegebener Lizenzcode ist nicht gültig. Bitte überprüfen Sie dies.</p>
        <?php
    } elseif ($licence_data['licence_status'] == 'exhausted') {
        ?>
        <p>Ihre Lizenz ist erschöpft. Um weitere Webseiten hinzuzufügen, buchen Sie bitte eine größere/weitere Lizenz.</p>
        <?php
    }
    if ($licence_data['site_status'] == 'evaluation') {
        ?>
        <p>Sie befinden sich derzeit in der <strong>Testphase</strong>. Bitte geben Sie einen Lizenzcode ein und aktivieren Sie das Theme. Die Testphase läuft in <?php echo $licence_data['days_left']; ?> Tag(en) ab!</p>
        <?php
    } elseif ($licence_data['site_status'] == 'invalid') {
        ?>
        <p>Ihre Testphase ist <strong>abgelaufen</strong>! Ihre Webseite ist deshalb nicht mehr erreichbar. Bitte geben Sie einen gültigen Lizenzcode ein und aktivieren Sie das Theme oder installieren und aktivieren Sie ein anderes</p>
        <?php
    }
    ?>

    <div class="rm_opts"> 

        <form method="post">

            <?php
            foreach ($options as $value) {

                switch ($value['type']) {

                    case "open":
                        ?>

                        <?php
                        break;

                    case "close":
                        ?>

                </div></div><br />

            <?php
            break;

        case "title":

            $i++;
            ?>

            <div class="rm_section">  
                <div class="rm_title">
                    <h3><img src="<?php echo AFFILISEO_ADMIN_IMAGES . '/trans.png' ?>" class="inactive" alt=""><?php echo $value['name']; ?></h3>
                    <span class="submit"><input name="save<?php echo $i; ?>" type="submit" value="Speichern" /></span><div class="clearfix"></div>
                </div>
                <div class="rm_options">

                    <?php
                    break;

                case 'text':
                    ?>

                    <div class="rm_input rm_text">
                        <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php
            if (affiliseo_get_option($value['id']) != "") {
                echo htmlentities(stripslashes(affiliseo_get_option($value['id'])));
            } else {
                echo $value['std'];
            }
                    ?>" />
                        <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
                    </div>

                    <?php
                    break;

                case 'textarea':
                    ?>

                    <div class="rm_input rm_textarea">
                        <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                        <textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php
            if (affiliseo_get_option($value['id']) != "") {
                echo stripslashes(affiliseo_get_option($value['id']));
            } else {
                echo $value['std'];
            }
                    ?></textarea>
                        <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>  
                    </div>

                    <?php
                    break;

                case 'select':
                    ?>

                    <div class="rm_input rm_select">
                        <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>  
                        <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                            <?php
                            foreach ($value['options'] as $option) {
                                if (is_array($option)) {
                                    ?>
                                    <option <?php
                    if (affiliseo_get_option($value['id']) == $option['value']) {
                        echo 'selected="selected"';
                    }
                                    ?> value='<?php echo $option['value']; ?>'><?php echo $option['text']; ?></option>
                                    <?php } else { ?>
                                    <option <?php
                    if (affiliseo_get_option($value['id']) == $option) {
                        echo 'selected="selected"';
                    }
                                        ?>><?php echo $option; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                        </select>
                        <small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
                    </div>

                    <?php
                    break;

                case 'background':
                    ?>

                    <div class="rm_input rm_select">
                        <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                        <input type="radio" name="<?php echo $value['id']; ?>" value="disable" <?php
            if (affiliseo_get_option($value['id']) == 'disable') {
                echo 'checked="checked"';
            }
                    ?>>&nbsp;Disable Background
                        <div class="backgrounds">                	
                            <?php foreach ($value['options'] as $option) : ?>
                                <div class="background-wrapper">
                                    <div class="background" style="background-image: url('<?php echo AFFILISEO_IMAGES . '/backgrounds/' . $option ?>');"></div>
                                    <input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $option; ?>" <?php
                                if (affiliseo_get_option($value['id']) == $option) {
                                    echo 'checked="checked"';
                                }
                                ?>>
                                </div>
                            <?php endforeach; ?>
                        </div>
			<small><?php echo $value['desc']; ?></small>
			<div class="clearfix"></div>
		</div>

                    <?php
                    break;

                case "checkbox":
                    $checkboxOption = affiliseo_get_option($value['id']);
                    
                    $checkboxValue = '';
                    
                    if ($checkboxOption != "") {
                        $checkboxValue = $checkboxOption;
                    } else {
                        if(isset($value['std']) && $value['std'] !="") {
                            $checkboxValue = $value['std'];
                        }
                    }
                    $checked = ($checkboxOption == '1' || $checkboxValue == '1') ? "checked=\"checked\"" : '';
                    ?>

                    <div class="rm_input rm_checkbox">
			<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                        
                        <input type="checkbox"
				name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"
				value="1" <?php echo $checked; ?> /> <small><?php echo $value['desc']; ?></small>
			<div class="clearfix"></div>
		</div>

                    <?php
                    break;

                case "cat":

                    $selected_cats = explode(",", affiliseo_get_option($value['id']));
                    ?>

                    <div class="rm_input rm_multi_checkbox">
			<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			<ul id="<?php echo $value['id']; ?>" class="sort-children">

                            <?php
                            // If building the portfolio categories list, bring the already selected and ordered cats to the top					
                            if ($value['id'] == 'portfolio_cats') {
                                foreach ($selected_cats as $selected_cat) {
                                    if ($selected_cat != ' ' && $selected_cat != '') {
                                        ?>

                                        <li class="sortable"><input
					type="checkbox" name="<?php echo $value['id']; ?>[]"
					value="<?php echo $selected_cat; ?>" checked="checked" />&nbsp;<?php echo get_cat_name($selected_cat); ?></li>

                                        <?php
                                    }
                                }
                                $portfolio_unselected_cats = get_categories('orderby=name&use_desc_for_title=1&hierarchical=1&style=0&hide_empty=0&exclude=' . affiliseo_get_option($value['id']));
                                foreach ($portfolio_unselected_cats as $portfolio_unselected_cat) {
                                    ?>

                                    <li class="sortable"><input
					type="checkbox" name="<?php echo $value['id']; ?>[]"
					value="<?php echo $portfolio_unselected_cat->cat_ID; ?>" />&nbsp;<?php echo $portfolio_unselected_cat->cat_name; ?></li>

                                    <?php
                                }
                            } else { // build the normal categories list 
                                $cats = get_categories('orderby=name&use_desc_for_title=1&hierarchical=1&style=0&hide_empty=0');

                                foreach ($cats as $cat) {

                                    foreach ($selected_cats as $selected_cat) {
                                        if ($selected_cat == $cat->cat_ID) {
                                            $checked = "checked=\"checked\"";
                                            break;
                                        } else {
                                            $checked = "";
                                        }
                                    }
                                    ?>

                                    <li><input type="checkbox"
					name="<?php echo $value['id']; ?>[]"
					value="<?php echo $cat->cat_ID; ?>" <?php echo $checked; ?> />&nbsp;<?php echo $cat->cat_name; ?></li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
			<small><?php echo $value['desc']; ?></small>
			<div class="clearfix"></div>
		</div>

                    <?php
                    break;

                case "pag":

                    $pags = get_pages('orderby=name&use_desc_for_title=1&hierarchical=1&style=0&hide_empty=0');

                    $selected_pags = explode(",", affiliseo_get_option($value['id']));
                    ?>
                    <div class="rm_input rm_multi_checkbox">
			<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			<ul>
                            <?php
                            foreach ($pags as $pag) {

                                foreach ($selected_pags as $selected_pag) {
                                    if ($selected_pag == $pag->ID) {
                                        $checked = "checked=\"checked\"";
                                        break;
                                    } else {
                                        $checked = "";
                                    }
                                }
                                ?>

                                <li><input type="checkbox"
					name="<?php echo $value['id']; ?>[]"
					value="<?php echo $pag->ID; ?>" <?php echo $checked; ?> />&nbsp;<?php echo $pag->post_title; ?></li>
                            <?php } ?>		
                        </ul>
			<small><?php echo $value['desc']; ?></small>
			<div class="clearfix"></div>
		</div>

                    <?php
                    break;
            }
        }
        ?>

        <input type="hidden" name="action" value="save" />
		</form>
	</div>
</div>

<?php

/**
 * Returns the value of an option from the db if it exists.
 */
function affiliseo_get_option($name)
{
    $options = getAffiliseoOptions();
    if (isset($options[$name])) {
        return $options[$name];
    } else {
        return false;
    }
}

/**
 * Updates/Adds an option to the options db.
 */
function affiliseo_update_option($name, $value)
{
    $options = getAffiliseoOptions();
    
    $value = htmlentities($value);
    
    if ($options and ! isset($options[$name])) { // Adds new value...
        $options[$name] = $value;
        return update_option(AFFILISEO_THEMEOPTIONS, $options);
    } else {
        if ($value != $options[$name]) { // ...or updates it
            $options[$name] = $value;
            return update_option(AFFILISEO_THEMEOPTIONS, $options);
        } else {
            return false;
        }
    }
}