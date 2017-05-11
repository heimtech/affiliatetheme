<?php
global $affiliseo_options;
get_header();
$sidebar_position = $affiliseo_options['layout_sidebar_blog'];
$hide_headline = false;
if (! empty($affiliseo_options['hide_headline_blog']) && trim($affiliseo_options['hide_headline_blog']) === '1') {
    $hide_headline = true;
}
$headline_tag_blog = 'h1';
if (! empty($affiliseo_options['headline_tag_blog'])) {
    $headline_tag_blog = $affiliseo_options['headline_tag_blog'];
}
?>
<div class="blog custom-container custom-container-margin-top">
	<div class="full-size">
        <?php
        if ($sidebar_position == 'links') {
            ?>
            <div class="col3 sidebar-left" id="sidebar">
                <?php get_sidebar(); ?>
            </div>
            <?php
        }
        if ($sidebar_position != 'links' && $sidebar_position != 'rechts') {
            $width = 12;
        } else {
            $width = 9;
        }
        ?>
        <div
			class="col<?php echo $width; ?> <?php if ($sidebar_position == 'links') { ?> content-right<?php } if ($sidebar_position == 'rechts') { ?> content-left<?php } ?>">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="clearfix"></div>
			<div class="box blog-article posts">
                        <?php
                    if (get_field('hide_article_headline') === false || get_field('hide_article_headline') == null) :
                        if (! $hide_headline) :
                            ?>
                                <<?php echo $headline_tag_blog; ?>><?php the_title(); ?></<?php echo $headline_tag_blog; ?>>
                                
                        <?php
                            endif;
                    
                        endif;
                    if ($affiliseo_options['blog_show_time'] !== '1') {
                        get_template_part('blogmeta');
                    }
                    ?>
                        <div class="clearfix"></div>
                        <?php
                        $post = get_post();
                        $thumbnailUrl = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
                    if (has_post_thumbnail() || strlen($thumbnailUrl) > 3) {
                        $imgSizeToClassMap = array(
                            'no_img' => 'img_by_url_image_w0',
                            'image_150_150' => 'img_by_url_image_blog_w150',
                            'image_300_300' => 'img_by_url_image_blog_w300',
                            'image_450_450' => 'img_by_url_image_blog_w450',
                            'image_600_600' => 'img_by_url_image_blog_w600',
                            'image_800_800' => 'img_by_url_image_blog_w800',
                            'full_size' => 'img_by_url_blog_full_size'
                        );
                        
                        if (isset($affiliseo_options['blog_image_size']) && $affiliseo_options['blog_image_size'] != "") {
                            if ($affiliseo_options['blog_image_size'] != "no_img") {
                                the_custom_post_thumbnail($post, $imgSizeToClassMap[$affiliseo_options['blog_image_size']], $affiliseo_options['blog_image_size'], array(
                                    'class' => ' img-thumbnail pull-left post-thumbnail'
                                ));
                            }
                        } else {
                            the_custom_post_thumbnail($post, 'img_by_url_full_size', 'full', array(
                                'class' => ' img-thumbnail pull-left post-thumbnail'
                            ));
                        }
                    }
                    the_content();
                    ?>
                        <div class="clearfix"></div>
				<div class="tags">
                            <?php the_tags('', ' ', ''); ?>
                        </div>
				<nav class="nav-blog-article full-size">
					<div class="col6">
                                <?php previous_post_link('&larr; %link'); ?> 
                            </div>
					<div class="col6 text-right">
                                <?php next_post_link('%link &rarr;'); ?> 
                            </div>
					<div class="clearfix"></div>
				</nav>
				<hr>
                        <?php
                    if (comments_open(get_the_ID())) {
                        comments_template();
                    } else {
                        echo 'Für diesen Beitrag sind die Kommentare geschlossen.';
                    }
                    ?>
                        <div class="clearfix"></div>
			</div>
                    <?php
                endwhile
                ;
            
            endif;
            ?>
        </div>
        <?php
        if ($sidebar_position == 'rechts') {
            ?>
            <div class="col3 sidebar-right" id="sidebar">
                <?php get_sidebar(); ?>
            </div>
            <?php
        }
        ?>
        <div class="clearfix"></div>
	</div>
</div>

<?php get_footer(); ?>

