<?php
global $affiliseo_options;
get_header();
$sidebar_position = $affiliseo_options['layout_sidebar_category'];
$tax_position = $affiliseo_options['position_description_tax'];
$hide_headline = false;
if (!empty($affiliseo_options['hide_headline_page']) && trim($affiliseo_options['hide_headline_page']) === '1') {
    $hide_headline = true;
}
$headline_tag_page = 'h1';
if (!empty($affiliseo_options['headline_tag_page'])) {
    $headline_tag_page = $affiliseo_options['headline_tag_page'];
}
global $wp_query;
?>
<div class="custom-container-margin-top custom-container<?php if (trim($wp_query->queried_object->post_content) === '') : ?> cat<?php endif; ?>">
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
        <div class="col<?php echo $width; ?> <?php if ($sidebar_position == 'links') { ?> content-right<?php } if ($sidebar_position == 'rechts') { ?> content-left<?php } ?>"  >
            <div class="box posts">
                <?php
                if (get_field('hide_page_headline') === false || get_field('hide_page_headline')==null) :
                    if (!$hide_headline) :
                        ?>
                        <<?php echo $headline_tag_page; ?> class="pull-left"><?php wp_title(''); ?></<?php echo $headline_tag_page; ?>>
                        <?php
                    endif;
                endif;
                if ($affiliseo_options['hide_blog_feed'] !== '1') :
                    ?>
                    <a href="<?php bloginfo('rss2_url'); ?>" class="pull-right"><i class="fa fa-rss fa-2x"></i></a>
                <?php endif; ?>
                <div class="clearfix"></div>
                <hr>
                <?php if (trim($tax_position) === '' || trim($tax_position) === 'top') : ?>
                    <p><?php echo $wp_query->queried_object->post_content; ?></p>
                <?php endif; ?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <article <?php post_class(); ?>>
                            <?php
                            $post = get_post();
                            $thumbnailUrl = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
                            if (has_post_thumbnail() || strlen($thumbnailUrl) > 3) {
                                the_custom_post_thumbnail($post, 'img_by_url_image_w150', 'thumbnail', array('class' => 'img-thumbnail pull-left'));
                            }
                            ?>
                            <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?> weiterlesen"><?php the_title(); ?></a></h3>
                            <?php
                            if ($affiliseo_options['blog_show_time'] !== '1') {
                                get_template_part('blogmeta');
                                ?>
                                <br><br>
                                <?php
                            }
                            the_excerpt();
                            ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?> weiterlesen" class="pull-right">weiterlesen &rarr;</a>
                            <div class="clearfix"></div>
                        </article>
                        <hr>
                        <?php
                    endwhile;
                endif;
                ?>
                <div class="text-center">
                    <?php
                    affiliseo_pagination();
                    ?>
                </div>
                <?php
                wp_reset_query();
                if (trim($tax_position) === 'bottom') {
                    echo $wp_query->queried_object->post_content;
                }
                ?>
            </div>
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