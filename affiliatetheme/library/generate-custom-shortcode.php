<?php

function add_custom_shortcode_button()
{
    echo '<a href="#" class="custom-shortcode-button button">[ ] Shortcode für Produkte / Beiträge generieren</a>';
}

add_action('media_buttons', 'add_custom_shortcode_button');

function add_custom_shortcode_enqueue($hook)
{
    if ('post.php' != $hook && 'post-new.php' != $hook) {
        return;
    }
    wp_enqueue_script(
        'custom_shortcode_script',
        get_template_directory_uri() . '/library/admin/js/custom-shortcode.js'
    );
}


add_action('admin_enqueue_scripts', 'add_custom_shortcode_enqueue');

function add_template()
{
    global $pagenow;
    if ($pagenow == 'post.php' || $pagenow == 'post-new.php') {
        
        ob_start();
        ?>

<style>
#custom-shortcode-posts, #custom-shortcode-cms-elements, #custom-shortcode-comparison{
	display: none;
}

#custom-shortcode-container {
	display: none;
	background-color: #fff;
	left: 10%;
	overflow-y: auto;
	position: absolute;
	right: 10%;
	top: 1em;
	z-index: 20000;
}

.custom-shortcode-generate-button {
	background-color: #fff;
	border: 2px solid #dd4632;
	color: #dd4632;
	padding: 0.5em 1em;
	text-transform: uppercase;
	cursor:pointer;
}

div#custom-shortcode-container div#products-header {
	color: #fff;
	padding: 1em 2em;
	background-color: #dd4632;
}

.shortcut-typ-tabs {
	border: 1px solid #777;
	font-size: 16px;
	font-weight: bold;
	height: 40px;
    line-height: 40px;
    background-color:#dcdcdc;	
	text-align: center;
}

.custom-shortcode-products, .custom-shortcode-posts, .custom-shortcode-cms-elements, .custom-shortcode-comparison{
	width: 150px;
	float: left;
	cursor: pointer;
}
.posts-templates{
    float:left;
    width:33%;
}

.choice-block {
    max-height:150px;
    border:1px solid #ddd;
    overflow:auto;
}

</style>

<div id="alert-background"></div>

<div id="custom-shortcode-container">


	<div id="products-header">
		<h1>
			Generieren und Einbinden von Shortcodes für Produkte und Beiträge
			<div class="pull-right">
				<i id="custom-shortcode-container-close" class="fa fa-times"></i>
			</div>
		</h1>
	</div>

	<div>
		<div class="shortcut-typ-tabs">
			<div class="custom-shortcode-products"><?php echo __('Products','affiliatetheme'); ?></div>
			<div class="custom-shortcode-posts">Blogbeiträge</div>
			<div class="custom-shortcode-cms-elements">Produktelement</div>
			<div class="custom-shortcode-comparison">Vergleichstabelle</div>
		</div>


		<div id="custom-shortcode-products">
	       <?php include 'custom-shortcode-products-content.php';?>
	    </div>

		<div id="custom-shortcode-posts">
	       <?php include 'custom-shortcode-posts-content.php';?>
	   </div>
	   
	   <div id="custom-shortcode-cms-elements">
	       <?php include 'custom-shortcode-cms-elements-content.php';?>
	   </div>
	   
	   <div id="custom-shortcode-comparison">
	       <?php include 'custom-shortcode-comparison-content.php';?>
	    </div>
	   
	</div>
</div>

<?php
        echo ob_get_clean();
    }
}

add_action('in_admin_header', 'add_template');