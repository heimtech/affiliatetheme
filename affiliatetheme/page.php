<?php
global $affiliseo_options;
global $device;
$hide_headline = false;
if (!empty($affiliseo_options['hide_headline_page']) && trim($affiliseo_options['hide_headline_page']) === '1') {
    $hide_headline = true;
}
$headline_tag_page = 'h1';
if (!empty($affiliseo_options['headline_tag_page'])) {
    $headline_tag_page = $affiliseo_options['headline_tag_page'];
}
get_header();
if (have_posts()) : while (have_posts()) : the_post();
        ?>

        <div class="custom-container custom-container-margin-top">
            <div class="full-size">
                <div class="page" id="content-wrapper" >
                    <?php if ($device === 'desktop') : ?>
                        <?php if (trim($affiliseo_options['ad_page_top']) != "" && isset($affiliseo_options['ad_page_top'])) : ?>
                            <div class="ad text-center">
                                <?php echo $affiliseo_options['ad_page_top']; ?>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if (trim($affiliseo_options['ad_page_top_mobile']) != "" && isset($affiliseo_options['ad_page_top_mobile'])) : ?>
                            <div class="mobile-ad text-center">
                                <?php echo $affiliseo_options['ad_page_top_mobile']; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="clearfix"></div>
                    <div class="box content">
                        <?php
                        
                        get_template_part('frontpageslider');
                        if (get_field('hide_page_headline') === false || get_field('hide_page_headline') ==null) :
                            if (!$hide_headline) :
                                ?>
                                <<?php echo $headline_tag_page; ?>><?php the_title(); ?></<?php echo $headline_tag_page; ?>>
                                <?php
                            endif;
                        endif;
                        $post = get_post();
                        $thumbnailUrl = get_post_meta($post->ID, '_external_thumbnail_url', TRUE);
                        if (has_post_thumbnail() || strlen($thumbnailUrl) > 3) {
                            the_custom_post_thumbnail($post, 'img_by_url_full_size', 'full', array('class' => ' img-thumbnail pull-left post-thumbnail'));
                        }
                        ?>
                        <p><?php the_content(); ?></p>
                    
                    	<div class="clearfix"></div>
                    	<?php
                            
                            $ACFP_PageBuilder = new ACFP_PageBuilder(false);
                            $flexibleContentHTML = $ACFP_PageBuilder->getFlexibleContentHTML('acf_page_builder', $post->ID);
                            echo $flexibleContentHTML;
                        ?>
                	</div>
                </div>
            </div>
        </div>
        <?php
    endwhile;
endif;
get_footer();
?>