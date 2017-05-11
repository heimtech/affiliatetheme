<?php
global $affiliseo_options;
global $post;
if (is_front_page()) {
    if ($affiliseo_options['allg_slider_einblenden'] == 1) {
        ?>
        <section id="slider">
            <div class="full-size">
                <div id="carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $i = 0;
                        query_posts('post_type=slideshow&posts_per_page=6&orderby=menu_order');
                        if (have_posts()) : while (have_posts()) : the_post();
                                ?>
                                <div class="item<?php if ($i == 0) echo ' active'; ?>">
                                    <?php if (get_field('slider_link') != "") : ?>
                                        <a class="slider-link" href="<?php echo get_field('slider_link'); ?>"<?php if (get_field('slider_externer_link') == "1") : ?>
                                               target="_blank"
                                               <?php
                                           endif;
                                           if (get_field('slider_nofollow') == "1") :
                                               ?>
                                               rel="nofollow"
                                           <?php endif; ?>
                                           > 
                                           <?php endif; ?>
                                           <?php 
                                           the_custom_post_thumbnail($post, 'img_by_url_start_slider_w1010', 'start_slider',null);
                                           
                                           if (trim(get_the_title()) !== '') :
                                               ?>
                                            <h4 class="slider-headline">
                                            <?php the_title(); ?>
                                            </h4>
                                            <?php
                                        endif;
                                        if (trim(get_field('slider_text')) !== '') :
                                            ?>
                                            <span class="silder-text">
                                            <?php echo get_field('slider_text'); ?>
                                            </span>
                                            <?php
                                        endif;
                                        if (get_field('slider_link') != "") :
                                            ?> 
                                        </a> 
                                <?php endif; ?>
                                </div>
                                <?php
                                $i++;
                            endwhile;
                        endif;
                        wp_reset_query();
                        ?>
                    </div>
                    <a class="left carousel-control" href="#carousel" data-slide="prev">
                        <i class="fa fa-angle-left fa-2x"></i>
                    </a>
                    <a class="right carousel-control" href="#carousel" data-slide="next">
                        <i class="fa fa-angle-right fa-2x"></i>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}
?>