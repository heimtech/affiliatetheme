<?php
global $affiliseo_options;
if (isset($affiliseo_options['redirect_404']) && intval($affiliseo_options['redirect_404']) == 1 && is_404()) {
    header("Location: /", TRUE, 301);
    exit();
}

setlocale(LC_ALL, 'de_DE');

if ($affiliseo_options['activate_popup'] == '1') {
    if (! isset($_COOKIE["IP"])) {
        $ip = getenv("REMOTE_ADDR");
        $difference_show_popup = trim($affiliseo_options['difference_show_popup']) !== '' ? trim($affiliseo_options['difference_show_popup']) : '1';
        setcookie("IP", $ip, time() + (60 * 60 * 24 * intval($difference_show_popup)));
        $difference_show_popup_js = intval($affiliseo_options['difference_show_popup_js']) === 0 ? 60 : intval($affiliseo_options['difference_show_popup_js']);
        $popup_page_id = $affiliseo_options['choose_page_popup'];
        $close = trim($affiliseo_options['text_close_popup']) !== '' ? trim($affiliseo_options['text_close_popup']) : 'Schließen';
        $show_popup_leave = trim($affiliseo_options['show_popup_leave']) !== '' ? $affiliseo_options['show_popup_leave'] : '0';
        global $show_popup;
        $show_popup = true;
    }
}
?>
<!DOCTYPE html>
<?php

global $currency_string;
$currency_string = $affiliseo_options['currency_string'];
if (trim($currency_string) === '') {
    $currency_string = '€';
}

// Detect special conditions devices
$iPod = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
$iPhone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
$iPad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
if (stripos($_SERVER['HTTP_USER_AGENT'], "Android") && stripos($_SERVER['HTTP_USER_AGENT'], "mobile")) {
    $Android = true;
} else 
    if (stripos($_SERVER['HTTP_USER_AGENT'], "Android")) {
        $Android = false;
        $AndroidTablet = true;
    } else {
        $Android = false;
        $AndroidTablet = false;
    }
$webOS = stripos($_SERVER['HTTP_USER_AGENT'], "webOS");
$BlackBerry = stripos($_SERVER['HTTP_USER_AGENT'], "BlackBerry");
$RimTablet = stripos($_SERVER['HTTP_USER_AGENT'], "RIM Tablet");

global $device;

// do something with this information
if ($iPod || $iPhone) {
    $device = 'iPhone';
} elseif ($iPad) {
    $device = 'iPad';
} elseif ($Android) {
    $device = 'android';
} elseif ($AndroidTablet) {
    $device = 'androidTablet';
} elseif ($webOS) {
    $device = 'webOS';
} elseif ($BlackBerry) {
    $device = 'blackBerry';
} elseif ($RimTablet) {
    $device = 'rimTablet';
} else {
    $device = 'desktop';
}

global $posSocialShare;
$posSocialShare = $affiliseo_options['position_social_share'];
if (trim($posSocialShare) === '') {
    $posSocialShare = 'right';
}
global $show_fb;
$show_fb = $affiliseo_options['show_fb'];
global $show_twitter;
$show_twitter = $affiliseo_options['show_twitter'];
global $show_gplus;
$show_gplus = $affiliseo_options['show_gplus'];

global $posSocialIcons;
$posSocialIcons = $affiliseo_options['position_social_icons'];
if (trim($posSocialIcons) === '') {
    $posSocialIcons = 'both';
}

$show_rss = $affiliseo_options['show_rss'];
$url_facebook = $affiliseo_options['url_facebook'];
$url_twitter = $affiliseo_options['url_twitter'];
$url_gplus = $affiliseo_options['url_gplus'];
$url_youtube = $affiliseo_options['url_youtube'];

$full_size_header = $affiliseo_options['full_size_header'];
if (trim($affiliseo_options['layout_wrapper_background']) === '1') {
    $full_size_header = '0';
}
$activate_pagespeed = '0';
if ($affiliseo_options['activate_pagespeed']) {
    $activate_pagespeed = $affiliseo_options['activate_pagespeed'];
}
$activate_pagespeed_scripts = '0';
if ($affiliseo_options['activate_pagespeed_scripts']) {
    $activate_pagespeed_scripts = $affiliseo_options['activate_pagespeed_scripts'];
}
global $pos_currency;
$pos_currency = 'before';
if ($affiliseo_options['pos_currency']) {
    $pos_currency = $affiliseo_options['pos_currency'];
}
global $text_tax;
$text_tax = __('VAT included.','affiliatetheme');
if ($affiliseo_options['tax_string']) {
    $text_tax = $affiliseo_options['tax_string'];
}
?>
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title><?php
if (is_home()) {
    echo bloginfo("name");
    echo " | ";
    echo bloginfo("description");
} else {
    echo wp_title(" | ", false, 'right');
    echo bloginfo("name");
}
?></title>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<style type="text/css" media="screen">
.full-size {
	width: 100%;
	height: auto
}

.col1 {
	width: 8.333%
}

.col2 {
	width: 16.667%
}

.col3 {
	width: 25%
}

.col4 {
	width: 33.333%
}

.col5 {
	width: 41.667%
}

.col6 {
	width: 50%
}

.col7 {
	width: 58.333%
}

.col8 {
	width: 66.667%
}

.col9 {
	width: 75%
}

.col10 {
	width: 83.333%
}

.col11 {
	width: 91.667%
}

.col12 {
	width: 100%
}

.col1, .col2, .col3, .col4, .col5, .col6, .col7, .col8, .col9, .col10,
	.col11, .col12 {
	float: left;
	min-height: 1px
}

@media all and (max-width:767px) {
	.col1, .col2, .col3, .col4, .col5, .col6, .col7, .col8, .col9, .coll0,
		.col11, .col12 {
		float: none;
		width: 100%
	}
}

#wrapper {
	max-width: 1200px;
	margin: 0 auto;
}

header, #header {
	padding-top: 1em;
	padding-left: 1em;
	padding-right: 1em;
	padding-bottom: 1em
}

h1 {
	font-size: 1.5em
}

h2 {
	font-size: 1.4em
}

h3 {
	font-size: 1.3em
}

h4 {
	font-size: 1.2em
}

h5 {
	font-size: 1.1em
}

h6 {
	font-size: 1em
}
</style>

<link rel="stylesheet"
	href="<?php echo get_template_directory_uri(); ?>/css/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet"
	href="<?php echo get_template_directory_uri(); ?>/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet"
	href="<?php echo get_template_directory_uri(); ?>/theme.css">
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
<link rel="stylesheet"
	href="<?php echo get_template_directory_uri(); ?>/_/css/custom.php">
	      <?php
        if (trim($activate_pagespeed_scripts) !== '1') :
        font_family_loader();
        ?>
        
        <?php
        endif;
        ?>
<link rel="stylesheet"
	href="<?php echo get_template_directory_uri(); ?>/_/css/flexslider.min.css">

<link rel="alternate" type="application/rss+xml" title="RSS 2.0 feed"
	href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="Produkt Feed"
	href="<?php bloginfo('rss2_url'); ?>?post_type=produkt/" />
        <?php if (get_theme_mod('affiliseo_favicon')) { ?>
            <link rel="shortcut icon"
	href="<?php echo esc_url(get_theme_mod('affiliseo_favicon')); ?>"
	type="image/x-icon" />
<link rel="shortcut icon"
	href="<?php echo get_template_directory_uri(); ?>/favicon.ico"
	type="image/x-icon" />
        <?php } ?>
        <?php wp_head(); ?>
        <?php
        if (is_singular()) {
            wp_enqueue_script('comment-reply');
        }
        echo $affiliseo_options['allg_google_analytics'];
        
        ?>
        
        <script src="<?php echo get_template_directory_uri(); ?>/_/js/comparison-functions.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/_/js/jquery.actual.js"></script>
        
<!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <![endif]-->

<script type="text/javascript">
function getPriceComparisonData(blogUrl, postId, targetContainer, wrapperTag){
	$.ajax({
        type: "GET",
        data: {
            post_id: postId
        },
        dataType: "html",
        url: blogUrl + '/wp-content/themes/affiliatetheme/getProductPriceComparison.php',
        success: function (data) {
            var container = $('#'+targetContainer);
            container.fadeOut(function () {
                if(wrapperHtml =!""){
                    data = '<'+wrapperTag+'>'+data+'</'+wrapperTag+'>';
                }                
                container.html(data);
                container.fadeIn();
            });
        }
    });
}
</script>
</head>
<body <?php body_class(); ?>>

<?php
$teaserSlider = '';
if (have_posts()){
	while (have_posts()){
		the_post();
		$post = get_post();
	}
	
	if(isset($post->post_type) && in_array($post->post_type,array('post','page','produkt'))){
	    $TeaserSlider = new TeaserSlider();
	    
	    $teaserSlider = $TeaserSlider->printContentTeaserSlider($post->ID, $post->post_type);
		
	}
}
?>
        <?php
        if (trim($affiliseo_options['anti_bounce_url']) !== '') {
            ?>
            <span id="antibounce"
		data-url="<?php echo $affiliseo_options['anti_bounce_url']; ?>"></span>
            <?php
        }
        $mouseover_product_pics = '0';
        if ($affiliseo_options['mouseover_product_pics']) {
            $mouseover_product_pics = $affiliseo_options['mouseover_product_pics'];
        }
        if (trim($mouseover_product_pics) !== '1') {
            ?>
            <span id="mouseover_product_pics"></span>
            <?php
        }
        
        global $show_popup;
        if ($show_popup) {
            ?>
            <div class="modal fade" id="myModal"
		data-wait="<?php echo $difference_show_popup_js; ?>"
		data-leave="<?php echo $show_popup_leave; ?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">
                                <?php if (!isset($affiliseo_options['choose_page_popup'])) { ?>
                                    Das ist der Titel Ihres Popup. Sie müssen noch eine Seite auswählen!
                                    <?php
            } else {
                echo get_the_title($popup_page_id);
            }
            ?>
                            </h4>
				</div>
				<div class="modal-body">
                            <?php if (!isset($affiliseo_options['choose_page_popup'])) { ?>
                                Das ist der Inhalt Ihres Popup. Sie müssen noch eine Seite auswählen!
                                <?php
            } else {
                
                echo get_the_custom_post_thumbnail($popup_page_id, null, null, null);
                $content_post = get_post($popup_page_id);
                $content = $content_post->post_content;
                $content = apply_filters('the_content', $content);
                $content = str_replace(']]>', ']]&gt;', $content);
                echo $content;
            }
            ?>
                        </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-submit" data-dismiss="modal"><?php echo $close; ?></button>
				</div>
			</div>
		</div>
	</div>
            <?php
        }
        
        if (has_nav_menu('nav_top')) {
            if (trim($affiliseo_options['layout_wrapper_background']) === '1') {
                ?> 
                <div class="custom-wrapper" id="wrapper">
                    <?php
            }
            ?>
                <div class="full-size first-menu-container">
			<div class="footer-wrapper">
				<nav
					class="first-menu <?php if (trim($affiliseo_options['hide_searchform'] !== '1')) { ?>col8<?php }else { ?>col10<?php } ?>">
                            <?php
            wp_nav_menu(array(
                'menu' => 'nav_top', /* menu name */
                                        'menu_class' => '',
                'theme_location' => 'nav_top', /* where in the theme it's assigned */
                                        'container' => 'false', /* container class */
                                        'depth' => '1' /* suppress lower levels for now */
                                    ));
            ?>
                        </nav>
				<div class="col2 social_header">
					<div class="pull-right">
                                <?php
            if (trim($posSocialIcons) === 'both' || trim($posSocialIcons) === 'top') {
                if (trim($url_facebook) !== '' && ! filter_var(trim($url_facebook), FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) {
                    ?>
                                        <a
							href="<?php echo trim($url_facebook); ?>"
							title="<?php bloginfo('name'); ?> auf Facebook"> <i
							class="fa fa-facebook-square"></i>
						</a>
                                        <?php
                }
                if (trim($url_gplus) !== '' && ! filter_var(trim($url_gplus), FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) {
                    ?>
                                        <a
							href="<?php echo trim($url_gplus); ?>"
							title="<?php bloginfo('name'); ?> auf Google+"> <i
							class="fa fa-google-plus-square"></i>
						</a>
                                        <?php
                }
                if (trim($url_twitter) !== '' && ! filter_var(trim($url_twitter), FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) {
                    ?>
                                        <a
							href="<?php echo trim($url_twitter); ?>"
							title="<?php bloginfo('name'); ?> auf Twitter"> <i
							class="fa fa-twitter-square"></i>
						</a>
                                        <?php
                }
                if (trim($url_youtube) !== '' && ! filter_var(trim($url_youtube), FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) {
                    ?>
                                        <a
							href="<?php echo trim($url_youtube); ?>"
							title="<?php bloginfo('name'); ?> auf Youtube"> <i
							class="fa fa-youtube-square"></i>
						</a>
                                        <?php
                }
                if ($show_rss !== '1') {
                    ?>
                                        <a
							href="<?php bloginfo('rss2_url'); ?>?post_type=produkt"
							title="Produkt-Feed"> <i class="fa fa-rss-square"></i>
						</a>
                                        <?php
                }
            }
            ?>
                            </div>
				</div>
                        <?php if (trim($affiliseo_options['hide_searchform'] !== '1')) { ?>
                            <form role="search" method="get"
					id="searchform" class="searchform_header pull-right col2"
					action="<?php bloginfo('url'); ?>">
					<div class="input-group-custom full-size">
						<input type="text" class="form-control-custom col10"
							placeholder="<?php echo $affiliseo_options['text_suchformular_header_input']; ?>"
							name="s" id="s">
						<div class="col2">
							<button class="btn-search pull-right" type="submit"
								id="searchsubmit">
								<i class='fa fa-search'></i>
							</button>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</form>
                        <?php } ?>
                        <div class="clearfix"></div>
			</div>
		</div>
                <?php
        }
        ?> 
            <div
			<?php
if (! has_nav_menu('nav_top')) {
    if ($affiliseo_options['layout_wrapper_background'] == 1) {
        ?>
			class="custom-wrapper" id="wrapper"
			<?php
    }
}
if (trim($affiliseo_options['layout_wrapper_background']) !== '1' && trim($full_size_header) !== '1') {
    ?>
			id="wrapper" <?php
}
?>>
			<header
				class="full-size <?php
    if ($affiliseo_options['layout_wrapper_background'] != '1') {
        echo 'custom-container';
    }
    ?>"
				id="header">
                        <?php
                        if (trim($affiliseo_options['layout_wrapper_background']) !== '1' && trim($full_size_header) === '1') {
                            ?>
                        <div class="footer-wrapper">
                            <?php
                        }
                        ?>
                        <div class="col3 logo">
                            <?php
                            
                            if (get_theme_mod('affiliseo_logo')) {
                                ?>
                                <a href="<?php bloginfo('url'); ?>"
							title="zur Startseite" class="brand"> <img
							src='<?php echo esc_url(get_theme_mod('affiliseo_logo')); ?>'
							alt='<?php echo esc_attr(get_bloginfo('name', 'display')); ?>'>
						</a>
                            <?php }else{ ?>
                                <p class="h1">
							<a href="<?php bloginfo('url'); ?>" title="zur Startseite"
								class="brand"><?php bloginfo('name'); ?></a>
						</p>
						<p><?php bloginfo('description'); ?></p>
                            <?php } ?>
                        </div>
                            <div class="col3 categoryList">

                            <?php if ( is_active_sidebar( 'sidebar-custom-header' ) ) : ?>
                             <div id="sidebar-header">
                             <?php dynamic_sidebar( 'sidebar-custom-header' ); ?>
                             </div>
                             <?php endif; ?>

                        </div>

					<div class="col6">
						<div class="ad">
                                <?php if ($affiliseo_options['ad_header'] != "") { ?>
                                    <?php echo $affiliseo_options['ad_header']; ?>
                                <?php } else { ?>
                                    <div
								style="height: 60px; width: 200px"></div>
                                <?php } ?>
                            </div>
						<div id="search-header">
                                <?php if ($affiliseo_options['allg_suchformular_ausblenden'] != "1") { ?>
                                    <form role="search" method="get"
								id="searchform" class="searchform_header pull-right"
								action="<?php bloginfo('url'); ?>">
								<div class="input-group-custom full-size">
									<input type="text" class="form-control-custom col10"
										placeholder="<?php echo $affiliseo_options['text_suchformular_header_input'] ?>"
										name="s" id="s">
									<div class="col2">
										<button class="btn-search pull-right" type="submit"
											id="searchsubmit">
											<i class='fa fa-search'></i>
										</button>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="clearfix"></div>
							</form>
                                <?php } ?>
                            </div>
					</div>
					<div class="clearfix"></div>
                        <?php
                        if (trim($affiliseo_options['layout_wrapper_background']) !== '1' && trim($full_size_header) === '1') {
                            ?>
                        </div>
                        <?php
                        }
                        ?>
                </header>
                <?php
                if (has_nav_menu('nav_main')) {
                    $classinput = '';
                    if ($affiliseo_options['layout_wrapper_background'] != '1') {
                        $classinput = ' custom-container';
                    }
                    ?>
                    <nav class="<?php echo $classinput; ?> full-size"
				id="navigation">
				<div class="navbar navbar-default"
					data-menu="<?php echo trim($full_size_header); ?>">
                            <?php
                    if (trim($affiliseo_options['layout_wrapper_background']) !== '1' && trim($full_size_header) === '1') {
                        ?>
                                <div
						class="footer-wrapper footer-wrapper-nav">
                                    <?php
                    }
                    ?>
                                <button
							class="navbar-toggle custom-navbar-toggle"
							data-target=".bs-navbar-collapse" data-toggle="collapse"
							type="button">
							<span class="sr-only">Toggle navigation</span> <span
								class="pull-left custom-toggle"> <span class="icon-bar"></span>
								<span class="icon-bar"></span> <span class="icon-bar"></span>
							</span> <span class="pull-right"> <span class="pull-left">Navigation
							</span> &nbsp;<i class="fa fa-angle-down"></i>
							</span> <span class="clearfix"></span>
						</button>
						<div class="navbar-menu-wrapper">
                                <?php
                    wp_nav_menu(array(
                        'menu' => 'main_nav', /* menu name */
                                            'menu_class' => 'nav navbar-nav collapse navbar-collapse bs-navbar-collapse',
                        'theme_location' => 'nav_main', /* where in the theme it's assigned */
                                            'container' => 'false', /* container class */
                                            'depth' => '3', /* suppress lower levels for now */
                                            'walker' => new description_walker()
                    ));
                    ?>
                                <?php
                    if (trim($affiliseo_options['layout_wrapper_background']) !== '1' && trim($full_size_header) === '1') {
                        echo showNavbarSearchField($affiliseo_options);
                        ?>
                                </div>
                                <?php
                    } else {
                        echo showNavbarSearchField($affiliseo_options);
                    }
                    ?>
                        </div>
                        </div>
			</nav>
			<?php echo $teaserSlider; ?>
                    <?php
                }
                if (trim($affiliseo_options['layout_wrapper_background']) !== '1' && trim($full_size_header) === '1') {
                    ?>
                    <div id="wrapper">
                        <?php
                }
                ?>
                    <div class="custom-container">
                    
					<div class="full-size">
                            <?php
                            if (!isset($affiliseo_options['hide_breadcrumb']) || trim($affiliseo_options['hide_breadcrumb']) !== '1') {
                                nav_breadcrumb();
                            }
                            
                            ?>
                        </div>
				</div>

                    <?php
                    if (trim($posSocialShare) !== 'none') {
                        if ($show_fb !== '1' || $show_twitter !== '1' || $show_gplus !== '1') {
                            ?>

                            <div id="affix-right"
					class="<?php
                            if ($posSocialShare === 'right') {
                                echo 'social-buttons-right';
                            } else {
                                echo 'social-buttons-top';
                            }
                            ?>">
					<ul class="social pull-right">
                                    <?php if ($show_fb !== '1') { ?>
                                        <li class="social-fb"><a
							href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(the_permalink()); ?>"
							onclick="socialp(this, 'fb');
                                                                                     return false;"><?php echo __('Share','affiliatetheme'); ?></a></li>
                                            <?php
                            }
                            if ($show_twitter !== '1') {
                                ?>
                                        <li class="social-tw"><a
							href="https://twitter.com/share?url=<?php echo the_permalink(); ?>"
							onclick="socialp(this, 'twitter');
                                                                                     return false;">Tweet</a></li>
                                            <?php
                            }
                            if ($show_gplus !== '1') {
                                ?>
                                        <li class="social-gp"><a
							href="https://plus.google.com/share?url=<?php echo the_permalink(); ?>"
							onclick="socialp(this, 'gplus');
                                                                                     return false;"><?php echo __('Share','affiliatetheme'); ?></a></li>
                                        <?php } ?>
                                </ul>
				</div>

                            <?php
                        }
                    }