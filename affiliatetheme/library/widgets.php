<?php
register_sidebar(array(
    'name' => 'Sidebar',
    'id' => 'standard',
    'description' => 'Allgemeine Sidebar',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
));

register_sidebar(array(
    'name' => 'Footer (Links)',
    'id' => 'footer_left',
    'description' => 'Sidebar im Footer (Links).',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
));

register_sidebar(array(
    'name' => 'Footer (Mitte)',
    'id' => 'footer_middle',
    'description' => 'Sidebar im Footer (Mitte).',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
));

register_sidebar(array(
    'name' => 'Footer (Rechts)',
    'id' => 'footer_right',
    'description' => 'Sidebar im Footer (Rechts).',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>',
));

/**
 * Widget: Produkte Filter Widget
 */
class Produkte_Widget extends WP_Widget {
    
    public function __construct(){
        global $brand_plural;
        global $type_plural;
        $widget_ops = array('classname' => 'widget_produkt_feed', 'description' => 'Dieses Widget zeigt Produkte für bestimmte Taxonomien an.');
        parent::__construct('produkt_feed', 'AffiliateTheme &raquo; Produktfilter', $widget_ops);
    }

    function widget($args, $instance) {
        $affiliseoOptions = getAffiliseoOptions();
        extract($args, EXTR_SKIP);
        global $post;

        echo $before_widget;

        if ($instance['title']) {
            ?><h4><?php echo $instance['title'] ?></h4><?php
        }

// VARS
        $posts_per_page = strip_tags($instance['posts_per_page']);
        $marke = strip_tags($instance['produkt_marke']);
        $typ = strip_tags($instance['produkt_typ']);

        $sort = $instance['sort'];
        $order = $instance['order'];

        $args = array(
            'post_type' => 'produkt',
            'posts_per_page' => $posts_per_page,
            'orderby' => $sort,
            'order' => $order
        );

        if ($marke != "")
            $args['produkt_marken'] = $marke;
        if ($typ != "")
            $args['produkt_typen'] = $typ;

        if ($sort == 'sterne_bewertung' || $sort == 'interne_bewertung') {
            $args['meta_key'] = $sort;
        }

        if ($sort == 'preis') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'preis';
        }

        $image = $instance['image'];

        $posts = get_posts($args);
        if ($posts) {
            ?>
            <ul class="items">
                <?php foreach ($posts as $post) { ?>
                    <li class="produkt full-size">
                        <?php if (trim($image) !== 'on'): ?>
                            <div class="col4 widget_product_box">
                                <a href="<?php echo get_permalink($post->ID); ?>">
                                    <?php 
                                    the_custom_post_thumbnail($post, 'img_by_url_slider_small_w50', 'slider_small', null);
                                    ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if (trim($image) !== 'on'): ?><div class="col8"><?php endif; ?>
                            <a href="<?php echo get_permalink($post->ID); ?>">
                                <?php echo get_the_title($post->ID); ?><br/>
                            </a>

                            <?php
                            if( !isset($affiliseoOptions['hide_star_rating']) || $affiliseoOptions['hide_star_rating']!=1 ){
                                echo get_product_rating($post->ID, "", "");
                            }
                            ?>
                            
                            <?php if (trim($image) !== 'on'): ?></div><?php endif; ?>
                        <div class="clearfix"></div>
                    </li>
                <?php } ?>
            </ul>
            <?php
        }

        wp_reset_query();

        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['posts_per_page'] = strip_tags($new_instance['posts_per_page']);
        $instance['produkt_marke'] = strip_tags($new_instance['produkt_marke']);
        $instance['produkt_typ'] = strip_tags($new_instance['produkt_typ']);
        $instance['sort'] = $new_instance['sort'];
        $instance['order'] = $new_instance['order'];
        $instance['image'] = $new_instance['image'];

        return $instance;
    }

    function form($instance) {
        $affiliseoOptions = getAffiliseoOptions();
        $instance = wp_parse_args((array) $instance, array('title' => '', 'posts_per_page' => '', 'produkt_marke' => '', 'produkt_typ' => ''));
        $title = strip_tags($instance['title']);
        $posts_per_page = strip_tags($instance['posts_per_page']);
        $produkt_marke = strip_tags($instance['produkt_marke']);
        $produkt_typ = strip_tags($instance['produkt_typ']);
        $image = $instance['image'];
        global $brand_singular;
        global $type_singular;

        $produkt_marken = get_terms('produkt_marken', 'orderby=count&hide_empty=1');
        $produkt_typen = get_terms('produkt_typen', 'orderby=count&hide_empty=1');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Titel: 
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>
        <p><label for="<?php echo $this->get_field_id('posts_per_page'); ?>">Anzahl an Produkten: <input class="widefat" id="<?php echo $this->get_field_id('posts_per_page'); ?>" name="<?php echo $this->get_field_name('posts_per_page'); ?>" type="text" value="<?php echo esc_attr($posts_per_page); ?>" /></label></p>
        <p>
            <label for="<?php echo $this->get_field_id('produkt_marke'); ?>"><?php echo $brand_singular; ?>: 
                <select class="widefat" id="<?php echo $this->get_field_id('produkt_marke'); ?>" name="<?php echo $this->get_field_name('produkt_marke'); ?>">
                    <option value="">alle</option>
                    <?php foreach ($produkt_marken as $marke) { ?>
                        <option value="<?php echo $marke->slug; ?>" <?php
                        if (esc_attr($produkt_marke == $marke->slug)) {
                            echo 'selected="selected"';
                        }
                        ?>><?php echo $marke->name; ?></option>
                            <?php } ?>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('produkt_typ'); ?>"><?php echo $type_singular ?>: 
                <select class="widefat" id="<?php echo $this->get_field_id('produkt_typ'); ?>" name="<?php echo $this->get_field_name('produkt_typ'); ?>">
                    <option value="">alle</option>
                    <?php foreach ($produkt_typen as $typ) { ?>
                        <option value="<?php echo $typ->slug; ?>" <?php
                        if (esc_attr($produkt_typ == $typ->slug)) {
                            echo 'selected="selected"';
                        }
                        ?>><?php echo $typ->name; ?></option>
                            <?php } ?>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('sort'); ?>">Sortieren nach: 
                <select id="<?php echo $this->get_field_id('sort'); ?>" name="<?php echo $this->get_field_name('sort'); ?>" class="widefat" style="width:100%;">
                    <option value="none" <?php if ('none' == $instance['sort']) echo 'selected="selected"'; ?>>keine Sortierung</option>
                    
                    <?php
                    if( !isset($affiliseoOptions['hide_star_rating']) || $affiliseoOptions['hide_star_rating']!=1 ){
                    ?>
                    <option value="sterne_bewertung" <?php if ('sterne_bewertung' == $instance['sort']) echo 'selected="selected"'; ?>>Sterne-Bewertung</option>
                    <?php
                    }
                    ?>
                    
                    <option value="interne_bewertung" <?php if ('interne_bewertung' == $instance['sort']) echo 'selected="selected"'; ?>>Interne Bewertung</option>
                    <option value="preis" <?php if ('preis' == $instance['sort']) echo 'selected="selected"'; ?>><?php echo __('Price','affiliatetheme'); ?></option>
                    <option value="post_title" <?php if ('post_title' == $instance['sort']) echo 'selected="selected"'; ?>>Titel</option>
                    <option value="date" <?php if ('date' == $instance['sort']) echo 'selected="selected"'; ?>>Erstellungsdatum</option>
                    <option value="modified" <?php if ('modified' == $instance['sort']) echo 'selected="selected"'; ?>>zuletzt geändert</option>
                    <option value="rand" <?php if ('rand' == $instance['sort']) echo 'selected="selected"'; ?>>zufällig</option>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('order'); ?>">Reihenfolge: 
                <select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" class="widefat" style="width:100%;">
                    <option value="asc" <?php if ('asc' == $instance['order']) echo 'selected="selected"'; ?>>aufsteigend</option>
                    <option value="desc" <?php if ('desc' == $instance['order']) echo 'selected="selected"'; ?>>absteigend</option>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('image'); ?>">Bilder ausblenden
                <input type="checkbox" class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" <?php if (trim($image) === 'on') : ?> checked="checked" <?php endif; ?>>
            </label>
        </p>
        <?php
    }

}

register_widget('Produkte_Widget');

function call_licence_api() {
    define('ARXW', 'BD9W');
    $licence_data = get_licence_data();
    if (!empty($licence_data)) {
        if ($licence_data['site_status'] != 'evaluation' && $licence_data['site_status'] != 'valid') {
            die('Diese Webseite wird derzeit gewartet. Bitte gedulden Sie sich.');
        }
    }
}

/**
 * Widget: Produkte Auswahl Widget
 */
class Produkte_Auswahl_Widget extends WP_Widget {
    
    public function __construct(){
        $widget_ops = array('classname' => 'widget_produkt_select_feed', 'description' => 'Dieses Widget ermöglicht es eine bestimmte Auswahl von Produkten im Widget anzuzeigen.');
        parent::__construct('produkt_select_feed', 'AffiliateTheme &raquo; Produktauswahl', $widget_ops);
        
    }
    
    function widget($args, $instance) {
        $affiliseoOptions = getAffiliseoOptions();
        extract($args, EXTR_SKIP);
        global $post;

        echo $before_widget;

        if ($instance['title']) {
            ?><h4><?php echo $instance['title'] ?></h4><?php
        }

// VARS
        $produkte = $instance['produkte'];
        $sort = $instance['sort'];
        $order = $instance['order'];

        $args = array(
            'post_type' => 'produkt',
            'posts_per_page' => $posts_per_page,
            'post__in' => $produkte,
            'orderby' => $sort,
            'order' => $order
        );

        if ($sort == 'sterne_bewertung' || $sort == 'interne_bewertung') {
            $args['meta_key'] = $sort;
        }

        if ($sort == 'preis') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'preis';
        }
        $image = $instance['image'];

        $posts = get_posts($args);
        if ($posts) {
            ?>
            <ul class="items">
                <?php foreach ($posts as $post) { ?>
                    <li class="produkt full-size">
                        <?php if (trim($image) !== 'on'): ?>
                            <div class="col4 widget_product_box">
                                <a href="<?php echo get_permalink($post->ID); ?>">
                                    <?php 
                                    the_custom_post_thumbnail($post, 'img_by_url_slider_small_w50', 'slider_small', null);
                                    ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if (trim($image) !== 'on'): ?><div class="col8"><?php endif; ?>
                            <a href="<?php echo get_permalink($post->ID); ?>">
                                <?php echo get_the_title($post->ID); ?><br/>
                            </a>

                            <?php
                            if( !isset($affiliseoOptions['hide_star_rating']) || $affiliseoOptions['hide_star_rating']!=1 ){
                                echo get_product_rating($post->ID, "", "");
                            }
                            ?>
                            <?php if (trim($image) !== 'on'): ?></div><?php endif; ?>
                        <div class="clearfix"></div>
                    </li>
                <?php } ?>
            </ul>
            <?php
        }

        wp_reset_query();

        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['produkte'] = $new_instance['produkte'];
        $instance['sort'] = $new_instance['sort'];
        $instance['order'] = $new_instance['order'];
        $instance['image'] = $new_instance['image'];

        return $instance;
    }

    function form($instance) {
        $affiliseoOptions = getAffiliseoOptions();
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('', 'text_domain');
        }
        $image = $instance['image'];
        if ($image === NULL) {
            $image = '';
        }
        $instance = wp_parse_args((array) $instance, array('title' => '', 'posts_per_page' => '', 'produkt_marke' => '', 'produkt_typ' => ''));
        $produkte = $instance['produkte'];
        if ($produkte === NULL) {
            $produkte = array();
        }
        $sort = $instance['sort'];
        $produkte_arr = get_posts('post_type=produkt&posts_per_page=-1');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Titel: 
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">	
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('produkte'); ?>">
                <?php echo __('Products','affiliatetheme'); ?>: 
                <select class="widefat" id="<?php echo $this->get_field_id('produkte'); ?>[]" name="<?php echo $this->get_field_name('produkte'); ?>[]" multiple style="height:220px">
                    <?php foreach ($produkte_arr as $item) { ?>
                        <option value="<?php echo $item->ID; ?>" <?php if (in_array($item->ID, $produkte)) echo 'selected'; ?>><?php echo $item->post_title; ?></option>
                    <?php } ?>
                </select>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sort'); ?>">Sortieren nach: 
                <select id="<?php echo $this->get_field_id('sort'); ?>" name="<?php echo $this->get_field_name('sort'); ?>" class="widefat" style="width:100%;">
                    <option value="none" <?php if ('none' == $instance['sort']) echo 'selected="selected"'; ?>>keine Sortierung</option>
                    
                    <?php
                    if( !isset($affiliseoOptions['hide_star_rating']) || $affiliseoOptions['hide_star_rating']!=1 ){
                    ?>                    
                    <option value="sterne_bewertung" <?php if ('sterne_bewertung' == $instance['sort']) echo 'selected="selected"'; ?>>Sterne-Bewertung</option>
                    <?php 
                    }
                    ?>
                    
                    <option value="interne_bewertung" <?php if ('interne_bewertung' == $instance['sort']) echo 'selected="selected"'; ?>>Interne Bewertung</option>
                    <option value="preis" <?php if ('preis' == $instance['sort']) echo 'selected="selected"'; ?>><?php echo __('Price','affiliatetheme'); ?></option>
                    <option value="post_title" <?php if ('post_title' == $instance['sort']) echo 'selected="selected"'; ?>>Titel</option>
                    <option value="date" <?php if ('date' == $instance['sort']) echo 'selected="selected"'; ?>>Erstellungsdatum</option>
                    <option value="modified" <?php if ('modified' == $instance['sort']) echo 'selected="selected"'; ?>>zuletzt geändert</option>
                    <option value="rand" <?php if ('rand' == $instance['sort']) echo 'selected="selected"'; ?>>zufällig</option>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('order'); ?>">Reihenfolge: 
                <select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" class="widefat" style="width:100%;">
                    <option value="asc" <?php if ('asc' == $instance['order']) echo 'selected="selected"'; ?>>aufsteigend</option>
                    <option value="desc" <?php if ('desc' == $instance['order']) echo 'selected="selected"'; ?>>absteigend</option>
                </select>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('image') ?>">Bilder ausblenden
                <input type="checkbox" class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" <?php if (trim($image) === 'on') : ?> checked="checked" <?php endif; ?>>
            </label>
        </p>
        <?php
    }

}

register_widget('Produkte_Auswahl_Widget');

/**
 * Widget: Produkte Empfehlung
 */
class Recommendation_Widget extends WP_Widget {
    
    public function __construct(){
        $widget_ops = array('classname' => 'widget_recommendation_feed', 'description' => 'Dieses Widget zeigt eine Produktempfehlung an.');
        parent::__construct('recommendation_feed', 'AffiliateTheme &raquo; Produktempfehlung', $widget_ops);        
    }
    
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        global $post;

        echo $before_widget;

        if ($instance['title']) :
            ?>
            <h4><?php echo $instance['title'] ?></h4>
            <?php
        endif;

        global $image_in_recommendation_widget;
        $image_in_recommendation_widget = $instance['image'];

        $produkt = $instance['produkt'];
        $produkte = array();
        array_push($produkte, $produkt);

        $args = array(
            'post_type' => 'produkt',
            'post__in' => $produkte
        );

        query_posts($args);
        global $wp_query;

        if (have_posts()) :
            while (have_posts()):
                the_post();
                ?>
                <div class="textwidget">
                    <div class="clearfix"></div><div class="full-size produkte product-cols">
                        <?php get_template_part('loop', 'produkt-sidebar'); ?>
                    </div>
                </div>
                <?php
            endwhile;
        endif;

        wp_reset_query();

        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['produkt'] = $new_instance['produkt'];
        $instance['image'] = $new_instance['image'];

        return $instance;
    }

    function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('', 'text_domain');
        }
        $produkt = $instance['produkt'];
        if (trim($produkt) === '') {
            $produkt = 16;
        }
        $image = $instance['image'];

        $produkte_arr = get_posts('post_type=produkt&posts_per_page=-1');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Titel: 
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">	
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('produkt'); ?>"><?php echo __('Products','affiliatetheme'); ?>: 
                <select id="<?php echo $this->get_field_id('produkt'); ?>" name="<?php echo $this->get_field_name('produkt'); ?>" class="widefat" style="width:100%;">
                    <?php foreach ($produkte_arr as $item) : ?>
                        <option value="<?php echo $item->ID; ?>" <?php if ($item->ID == $instance['produkt']) echo 'selected="selected"'; ?>><?php echo $item->post_title; ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('image'); ?>">Bild ausblenden
                <input type="checkbox" class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" <?php if (trim($image) === 'on') : ?> checked="checked" <?php endif; ?>>
            </label>
        </p>
        <?php
    }

}

register_widget('Recommendation_Widget');

/**
 * Widget: Custom Footer
 */
class Custom_Footer_Widget extends WP_Widget {
    
    public function __construct(){
        $widget_ops = array('classname' => 'widget_custom_footer_feed', 'description' => 'Dieses Widget zeigt optionalen Content im Footer an.');
        parent::__construct('custom_footer_feed', 'AffiliateTheme &raquo; Zusätzliche Informationen im Footer rechts', $widget_ops);
    }

    function widget($args, $instance) {
        echo $args['before_widget'];

        if (!empty($instance['title'])) :
            ?>
            <h4><?php echo $instance['title'] ?></h4>
            <?php
        endif;
        $content = '';
        if (!empty($instance['custom_content'])) {
            $content = $instance['custom_content'];
        }
        ?>

        <div class="textwidget">
            <div><?php echo $content ?></div>
        </div>

        <?php
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['custom_content'] = $new_instance['custom_content'];

        return $instance;
    }

    function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('', 'text_domain');
        }

        $content = '';
        if (!empty($instance['custom_content'])) {
            $content = $instance['custom_content'];
        }

        if (trim($content) === '') {
            $content = '
		<div class="icon full-size">
			<div class="col2">
				<img src="/wp-content/themes/affiliatetheme/_/img/lieferung.png" width="32" height="32" alt="Lieferung kostenfrei" class="media-object" />
			</div>
			<div class="col10">
				<strong>Lieferung kostenfrei</strong>
				<div>bereits ab 29 Euro</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="icon full-size">
			<div class="col2">
				<img src="/wp-content/themes/affiliatetheme/_/img/reviews.png" width="32" height="32" alt="Praxisnah getestet" class="media-object" />
			</div>
			<div class="col10">
				<strong>Praxisnah getestet</strong>
				<div>von Usern</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="icon full-size">
			<div class="col2">
				<img src="/wp-content/themes/affiliatetheme/_/img/amazon.png" width="32" height="32" alt="In Partnerschaft mit Amazon" class="media-object" />
			</div>
			<div class="col10">
				<strong>In Partnerschaft</strong>
				<div>mit dem Amazon-Shop</div>
			</div>
			<div class="clearfix"></div>
		</div>';
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Titel: 
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">	
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('custom_content'); ?>">
                Inhalt: 
                <textarea id="<?php echo $this->get_field_id('custom_content'); ?>" name="<?php echo $this->get_field_name('custom_content'); ?>" class="widefat" style="width:100%;height:20em;">
                    <?php echo $content; ?>	
                </textarea>
            </label>
        </p>
        <?php
    }

}

register_widget('Custom_Footer_Widget');

/**
 * Widget: Relevante Blogartikel
 */
class Related_Articles_Widget extends WP_Widget {
    public function __construct(){
        $widget_ops = array('classname' => 'widget_related_articles_feed', 'description' => 'Dieses Widget zeigt relevante Blogartikel an.');
        parent::__construct('related_articles_feed', 'AffiliateTheme &raquo; Relevante Blogartikel', $widget_ops);
        
    }

    function widget($args, $instance) {
        echo $args['before_widget'];

        if (!empty($instance['title'])) :
            ?>
            <h4><?php echo $instance['title'] ?></h4>
            <?php
        endif;

        $selected_posts = array();

        if ($instance['selected_posts'] !== NULL) {
            $selected_posts = $instance['selected_posts'];
        }

        if (isset($instance['selected_category']) && $instance['selected_category'] !== '') {
            $selected_category = $instance['selected_category'];
            if ($selected_category === 'none') {
                $selected_category = '';
            }
        } else {
            $selected_category = '';
        }
        if (isset($instance['selected_tag']) && $instance['selected_tag'] !== '') {
            $selected_tag = $instance['selected_tag'];
            if ($selected_tag === 'none') {
                $selected_tag = '';
            }
        } else {
            $selected_tag = '';
        }
        if (isset($instance['max_posts']) && trim($instance['max_posts'] !== '')) {
            $max_posts = $instance['max_posts'];
        } else {
            $max_posts = -1;
        }

        if (isset($instance['length']) && $instance['length'] !== '') {
            $length = (int) $instance['length'];
        } else {
            $length = 80;
        }

        if (isset($instance['show_thumbnail']) && $instance['show_thumbnail'] !== '') {
            $show_thumbnail = true;
        } else {
            $show_thumbnail = false;
        }

        $query_args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'orderby' => 'date',
            'cat' => $selected_category,
            'tag_id' => $selected_tag,
            'posts_per_page' => $max_posts,
            'post__in' => $selected_posts
        );

        $the_query = new WP_Query($query_args);

        if ($the_query->have_posts()) {
            echo '<ul class="related-articles">';
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $post = get_post();
                $thumbnailUrl = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
                echo '<li>';
                echo '<h5><a href="' . get_the_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h5>';
                if ($show_thumbnail) {
                    if (has_post_thumbnail() || strlen($thumbnailUrl) > 3) {
                        echo '<div class="pull-left">';
                        echo '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '">';
                        the_custom_post_thumbnail($post, 'img_by_url_slider_small_w50', 'slider_small', null);
                        echo '</a>';
                        echo '</div>';
                    }
                }
                if ($length !== 0) {
                    echo '<p class="small">';
                    $content =  get_the_related_posts_excerpt($length);
                    echo apply_filters('the_content', $content);
                    echo '... <a href="' . get_the_permalink() . '" title="' . get_the_title() . '">weiterlesen &rarr;</a>';
                    echo '</p>';
                }
                echo '<div class="clearfix"></div>';
                echo '</li>';
            }
            echo '</ul>';
        }

        wp_reset_postdata();

        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['selected_posts'] = $new_instance['selected_posts'];
        $instance['selected_category'] = $new_instance['selected_category'];
        $instance['selected_tag'] = $new_instance['selected_tag'];
        $instance['max_posts'] = $new_instance['max_posts'];
        $instance['length'] = $new_instance['length'];
        $instance['show_thumbnail'] = $new_instance['show_thumbnail'];

        return $instance;
    }

    function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('', 'text_domain');
        }
        $instance = wp_parse_args((array) $instance, array());
        $selected_posts = $instance['selected_posts'];
        if ($selected_posts === NULL) {
            $selected_posts = array();
        }

        $posts_arr = get_posts(array(
            'numberposts' => -1,
            'post_type' => 'post',
            'post_status' => 'publish'
        ));

        $selected_category = '';
        if (isset($instance['selected_category'])) {
            $selected_category = $instance['selected_category'];
        }
        $categories_arr = get_categories(array('type' => 'post'));

        $selected_tag = '';
        if (isset($instance['selected_tag'])) {
            $selected_tag = $instance['selected_tag'];
        }
        $tags_arr = get_tags(array('type' => 'post'));

        $max_posts = $instance['max_posts'];

        $length = $instance['length'];

        $show_thumbnail = $instance['show_thumbnail'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Titel: 
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">	
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('selected_posts'); ?>">
                Blogbeiträge: 
                <select class="widefat" id="<?php echo $this->get_field_id('selected_posts'); ?>[]" name="<?php echo $this->get_field_name('selected_posts'); ?>[]" multiple style="height:220px">
                    <?php foreach ($posts_arr as $item) { ?>
                        <option value="<?php echo $item->ID; ?>" <?php if (in_array($item->ID, $selected_posts)) echo 'selected="selected"'; ?>><?php echo $item->post_title; ?></option>
                    <?php } ?>
                </select>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('selected_category'); ?>">
                Blogbeiträge mit der folgenden Kategorie anzeigen: 
                <select class="widefat" id="<?php echo $this->get_field_id('selected_category'); ?>" name="<?php echo $this->get_field_name('selected_category'); ?>">
                    <option value="none" <?php if ($selected_category === 'none') echo 'selected="selected"'; ?>>keine Kategorie ausgewählt</option>
                    <?php foreach ($categories_arr as $item) { ?>
                        <option value="<?php echo $item->term_id; ?>" <?php if ($selected_category === $item->term_id) echo 'selected="selected"'; ?>><?php echo $item->name; ?></option>
                    <?php } ?>
                </select>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('selected_tag'); ?>">
                Blogbeiträge mit dem folgenden Tag anzeigen: 
                <select class="widefat" id="<?php echo $this->get_field_id('selected_tag'); ?>" name="<?php echo $this->get_field_name('selected_tag'); ?>">
                    <option value="none" <?php if ($selected_tag === 'none') echo 'selected="selected"'; ?>>kein Tag ausgewählt</option>
                    <?php foreach ($tags_arr as $item) { ?>
                        <option value="<?php echo $item->term_id; ?>" <?php if ($selected_tag === $item->term_id) echo 'selected="selected"'; ?>><?php echo $item->name; ?></option>
                    <?php } ?>
                </select>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('max_posts'); ?>">
                Wie viele Beiträge sollen angezeigt werden?
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('max_posts'); ?>" name="<?php echo $this->get_field_name('max_posts'); ?>" value="<?php echo esc_attr($max_posts); ?>" >
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('length'); ?>">
                Wie lang soll ein Beitrag sein? 
                <input type="text" class="widefat" id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" value="<?php echo esc_attr($length); ?>" >
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('show_thumbnail'); ?>">
                Thumbnail anzeigen? 
                <input type="checkbox" class="widefat" id="<?php echo $this->get_field_id('show_thumbnail'); ?>" name="<?php echo $this->get_field_name('show_thumbnail'); ?>"<?php if ($show_thumbnail === 'on') : ?> checked="checked" <?php endif; ?>>
            </label>
        </p>

        <?php
    }

}

register_widget('Related_Articles_Widget');

/**
 * Widget: Product Tags
 */
class Product_Tags_Widget extends WP_Widget {
    
    public function __construct(){
        $widget_ops = array('classname' => 'widget_product_tags_feed', 'description' => 'Dieses Widget zeigt alle Tags Ihrer Produkte an.');
        parent::__construct('product_tags_feed', 'AffiliateTheme &raquo; Produkt-Tags', $widget_ops);
    }


    function widget($args, $instance) {
        echo $args['before_widget'];

        if (!empty($instance['title'])) :
            ?>
            <h4><?php echo $instance['title'] ?></h4>
            <?php
        endif;
        ?>

        <div class="tagcloud">
            <ul>
                <?php
                wp_list_categories('taxonomy=produkt_tags&orderby=name&&title_li=');
                ?>
            </ul>
        </div>

        <?php
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }

    function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('', 'text_domain');
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Titel: 
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">	
            </label>
        </p>
        <?php
    }

}

register_widget('Product_Tags_Widget');

/**
 * Widget: Product Filter
 */
class Product_Filter_Widget extends WP_Widget {
    
    public function __construct(){
        $widget_ops = array('classname' => 'widget_product_filter_feed', 'description' => 'Dieses Widget zeigt einen interaktiven Filter für Produkte an.');
        parent::__construct('product_filter_feed', 'AffiliateTheme &raquo; Interaktiver Produktfilter', $widget_ops);
    }

    
    function widget($args, $instance) {
        global $affiliseo_options;
        
        echo $args['before_widget'];

        if (!empty($instance['title'])) :
            ?>
            <h4><?php echo $instance['title'] ?></h4>
            <?php
        endif;

        $argv = array(
            'post_type' => 'produkt',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        $products = get_posts($argv);
        $prices = array();
        foreach ($products as $product) {
            $prices[] = floatval(get_field('preis', $product->ID)) + 1;
        }
        rsort($prices, SORT_NUMERIC);
        global $brand_singular;
        global $type_singular;
        $brands = get_terms('produkt_marken');
        $types = get_terms('produkt_typen');
        $tags = get_terms('produkt_tags');
        $show_price = false;
        if (isset($instance['show_price']) && $instance['show_price'] !== '') {
            $show_price = true;
        }
        $show_brand = false;
        if (isset($instance['show_brand']) && $instance['show_brand'] !== '') {
            $show_brand = true;
        }
        $show_type = false;
        if (isset($instance['show_type']) && $instance['show_type'] !== '') {
            $show_type = true;
        }
        $show_tag = false;
        if (isset($instance['show_tag']) && $instance['show_tag'] !== '') {
            $show_tag = true;
        }
        $show_stars = false;
        if (isset($instance['show_stars']) && $instance['show_stars'] !== '') {
            if( !isset($affiliseo_options['hide_star_rating']) || $affiliseo_options['hide_star_rating']!=1 ){
                $show_stars = true;
            }
        }
        $tags_headline = 'Getaggt in';
        if (isset($instance['tags_headline'])) {
            $tags_headline = $instance['tags_headline'];
        }
        
        ?>
        <form class="filter-widget" action="<?php bloginfo('url'); ?>/produktfilter/" method="get">
            <?php if ($show_price) : ?>
                <div class="filter-widget-first-headline">
                    <?php echo __('Price from - to','affiliatetheme'); ?> : 
                    <span id="filter-widget-min">0</span> - 
                    <span id="filter-widget-max"><?php echo ceil($prices[0]); ?></span> 
                    <?php echo $affiliseo_options['currency_string']; ?>
                </div>
                <div class="full-size" id="slider-component-container">
                	<div style="float:left; width:10px;">&nbsp;</div>
                    <input name="min_price" id="min_price" type="hidden" value="0">
                    <div id="slider-component" style="position:right;">                    
                        <div id="slider-widget" data-placement="top" title="1 - <?php echo ceil($prices[0]); ?>"></div>
                    </div>
                    <input name="max_price" id="max_price" value="<?php echo ceil($prices[0]); ?>" type="hidden">
                    <div class="clearfix"></div>
                </div>
                <?php
            endif;
            if (count($brands) !== 0 && $show_brand) :
                ?>
                <div class="filter-widget-headline"><?php echo $brand_singular; ?></div>
                <select id="brand" name="brand" class="widefat filter-widget-select" style="width:100%;">
                    <option value="none"><?php printf(__('select %s','affiliatetheme'), $brand_singular); ?></option>
                    <?php
                    foreach ($brands as $brand) :
                        ?>
                        <option value="<?php echo $brand->slug; ?>"><?php echo $brand->name; ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
                <?php
            endif;
            
            if (count($types) !== 0 && $show_type) :
                ?>
                <div class="filter-widget-headline"><?php echo $type_singular; ?></div>
                <select id="type" name="type" class="widefat filter-widget-select" style="width:100%;">
                    <option value="none"><?php printf(__('select %s','affiliatetheme'), $type_singular); ?></option>
                    <?php
                    foreach ($types as $type) :
                        ?>
                        <option value="<?php echo $type->slug; ?>"><?php echo $type->name; ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
                <?php
            endif;
            
            
            global $wpdb;
            $taxonomies_table = $wpdb->prefix . "taxonomies";
            $res = $wpdb->get_results('SELECT * FROM ' . $taxonomies_table, OBJECT);
            
            if (count($res) > 0) {
                foreach ($res as $mytax) {
                    $taxonomySlug = 'produkt_'.$mytax->taxonomy_slug;
                    $taxonomyPlural = $mytax->taxonomy_plural;
                    $taxonomySingular = $mytax->taxonomy_singular;
                    
                    $fieldId = 'show_'.$taxonomySlug;
                    $fieldValue = (isset($instance[$fieldId]))?$instance[$fieldId]:'off';
                    
                    if($fieldValue==='off') {
                        continue;
                    }
                    
                    ?>
                    <?php echo $taxonomyPlural; ?>
                    <select 
                    	style="width:100%;" 
                    	class="widefat filter-widget-select" 
                    	name="dynamic__<?php echo $taxonomySlug; ?>" 
                    	id="dynamic__<?php echo $taxonomySlug; ?>">
                    		<option value="none"><?php printf(__('select %s','affiliatetheme'), $taxonomySingular); ?></option>
                    		
                    		<?php
                    		$taxonomies = get_terms($taxonomySlug);
                    		foreach ($taxonomies as $taxonomy => $value) {
                    		    echo '<option value="'.$value->slug.'">'.$value->name.'</option>';
                    		}
                    		?>
                    </select>
                    <?php
                }
            }
            
            if (count($tags) !== 0 && $show_tag) :
                ?>
                <div class="filter-widget-headline"><?php echo $tags_headline; ?></div>
                <select id="tag" name="tag" class="widefat filter-widget-select" style="width:100%;">
                    <option value="none"><?php printf(__('select %s','affiliatetheme'), 'Tag'); ?></option>
                    <?php
                    foreach ($tags as $tag) :
                        ?>
                        <option value="<?php echo $tag->slug ?>"><?php echo $tag->name; ?></option>
                        <?php
                    endforeach;
                    ?>
                </select>
                <?php
            endif;
            if ($show_stars) :
                ?>
                <div class="filter-widget-headline"><?php echo __('Review','affiliatetheme'); ?></div>
                <i class="fa fa-star-o stars stars-widget" id="star1"></i>
                <i class="fa fa-star-o stars stars-widget" id="star2"></i>
                <i class="fa fa-star-o stars stars-widget" id="star3"></i>
                <i class="fa fa-star-o stars stars-widget" id="star4"></i>
                <i class="fa fa-star-o stars stars-widget" id="star5"></i>
                & <?php echo __('more','affiliatetheme'); ?>
                <input type="hidden" name="stars" id="stars-product-filter-widget">
                <?php
            endif;
            ?>
            <div class="filter-widget-button">
                <input class="btn btn-submit" type="submit" value="<?php echo __('Display products','affiliatetheme'); ?>">
            </div>
        </form>

        <?php
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['show_price'] = $new_instance['show_price'];
        $instance['show_brand'] = $new_instance['show_brand'];
        $instance['show_type'] = $new_instance['show_type'];
        $instance['show_tag'] = $new_instance['show_tag'];        
        $instance['show_stars'] = $new_instance['show_stars'];
        $instance['tags_headline'] = (!empty($new_instance['tags_headline']) ) ? strip_tags($new_instance['tags_headline']) : '';
        
        $nonDynamicKeys = array('title','show_price','show_brand','show_type','show_tag','show_stars','tags_headline');
        
        // dynamic keys
        $instanceKeys = array_keys(array_merge($new_instance,$old_instance));
        foreach ($instanceKeys as $instanceKey){
            if(!in_array($instanceKey,$nonDynamicKeys)){
                if(isset($new_instance[$instanceKey])){
                    $instance[$instanceKey] = $new_instance[$instanceKey];
                } else {
                    unset($instance[$instanceKey]);
                }                                
            }
        }    
        
        return $instance;
    }

    function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('', 'text_domain');
        }
        $show_price = $instance['show_price'];
        $show_brand = $instance['show_brand'];
        $show_type = $instance['show_type'];
        $show_tag = $instance['show_tag'];
        $show_stars = $instance['show_stars'];        
        global $brand_plural;
        global $type_plural;
        if (isset($instance['tags_headline'])) {
            $tags_headline = $instance['tags_headline'];
        } else {
            $tags_headline = 'Getaggt in';
        }        
        ?>
        <p>
            <a href="http://affiliseo.de/interaktiver-produktfilter/" target="_blank" class="link-affiliseo">
                <i class="fa fa-youtube-play fa-2x fa-affiliseo"></i> Anleitung auf AffiliSEO.de
            </a>
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Titel: 
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">	
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('show_price'); ?>">
                Nach Preis filtern?
                <input type="checkbox" class="widefat" id="<?php echo $this->get_field_id('show_price'); ?>" name="<?php echo $this->get_field_name('show_price'); ?>"<?php if ($show_price === 'on') : ?> checked="checked" <?php endif; ?>>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('show_brand'); ?>">
                Nach <?php echo $brand_plural ?> filtern?
                <input type="checkbox" class="widefat" id="<?php echo $this->get_field_id('show_brand'); ?>" name="<?php echo $this->get_field_name('show_brand'); ?>"<?php if ($show_brand === 'on') : ?> checked="checked" <?php endif; ?>>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('show_type'); ?>">
                Nach <?php echo $type_plural; ?> filtern?
                <input type="checkbox" class="widefat" id="<?php echo $this->get_field_id('show_type'); ?>" name="<?php echo $this->get_field_name('show_type'); ?>"<?php if ($show_type === 'on') : ?> checked="checked" <?php endif; ?>>
            </label>
        </p>
        
        
        
        <?php
        global $wpdb;
        $taxonomies_table = $wpdb->prefix . "taxonomies";
        $res = $wpdb->get_results('SELECT * FROM ' . $taxonomies_table, OBJECT);
        
        if (count($res) > 0) {
            foreach ($res as $mytax) {
                $taxonomySlug = 'produkt_'.$mytax->taxonomy_slug;
                $taxonomyPlural = $mytax->taxonomy_plural;
                $fieldId = 'show_'.$taxonomySlug;
                $fieldValue = (isset($instance[$fieldId]))?$instance[$fieldId]:'off';
                ?>
                <p>
                	<label for="<?php echo $this->get_field_id($fieldId); ?>">
                		Nach  <?php echo $taxonomyPlural; ?> filtern? 
                		<input 
                			type="checkbox" 
                			class="widefat" 
                			id="<?php echo $this->get_field_id($fieldId); ?>" 
                			name="<?php echo $this->get_field_name($fieldId); ?>" 
                			<?php if ($fieldValue === 'on') : ?> checked="checked" <?php endif; ?> />
                	</label>
                </p>
                <?php
        
                
            }
        }
        ?>
        
        
        <p>
            <label for="<?php echo $this->get_field_id('show_tag'); ?>">
                Nach Tags filtern?
                <input type="checkbox" class="widefat" id="<?php echo $this->get_field_id('show_tag'); ?>" name="<?php echo $this->get_field_name('show_tag'); ?>"<?php if ($show_tag === 'on') : ?> checked="checked" <?php endif; ?>>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('show_stars'); ?>">
                Nach Bewertung filtern?
                <input type="checkbox" class="widefat" id="<?php echo $this->get_field_id('show_stars'); ?>" name="<?php echo $this->get_field_name('show_stars'); ?>"<?php if ($show_stars === 'on') : ?> checked="checked" <?php endif; ?>>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('tags_headline'); ?>">
                Text über Tags: 
                <input placeholder="<?php echo $tags_headline ?>" class="widefat" id="<?php echo $this->get_field_id('tags_headline'); ?>" name="<?php echo $this->get_field_name('tags_headline'); ?>" type="text" value="<?php echo esc_attr($tags_headline); ?>">	
            </label>
        </p>
        <?php
    }

}

register_widget('Product_Filter_Widget');
