<?php
/*
  Template Name: Template Cloaking
 */

global $affiliseo_options;
$duration = '4';
if (isset($affiliseo_options['cloaking_duration'])) {
    $duration = intval($affiliseo_options['cloaking_duration']);
}

get_header();

$affiliate_link = '#';
if (isset($_POST['affiliate_link']) && trim($_POST['affiliate_link']) !== '') {
    $affiliate_link = $_POST['affiliate_link'];
}
$hide_headline = false;
if (!empty($affiliseo_options['hide_headline_page']) && trim($affiliseo_options['hide_headline_page']) === '1') {
    $hide_headline = true;
}
$headline_tag_page = 'h1';
if (!empty($affiliseo_options['headline_tag_page'])) {
    $headline_tag_page = $affiliseo_options['headline_tag_page'];
}
if (have_posts()) : while (have_posts()) : the_post();
        ?>
        <div class="box content" style="padding: 10em;">
            <?php
            if (get_field('hide_page_headline') === false || get_field('hide_page_headline')==null) :
                if (!$hide_headline) :
                    ?>
                    <<?php echo $headline_tag_page; ?>><?php the_title(); ?></<?php echo $headline_tag_page; ?>>
                    <?php
                endif;
            endif;
            ?>
            <div id="wait"><div></div></div>
            <span id="cloaking-duration" data-duration="<?php echo $duration; ?>"></span>
            <small>
                <?php echo get_the_content(); ?>
                <a id="redirectlink" href="<?php echo $affiliate_link; ?>"><?php echo $affiliseo_options['cloaking_link']; ?></a>
            </small>
        </div>
        <?php
    endwhile;
endif;

get_footer();
?>