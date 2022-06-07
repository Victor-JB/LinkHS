<?php
get_header();
/* Template Name: Home */
the_post();
$post = get_post();
if ($post && ( preg_match('/vc_row/', $post->post_content) )) {
    the_content();
} else if (nokri_check_is_elementor($post->ID)) {
    the_content();
} else {
    ?>
    <section class="blog-posts">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="entry-content">
                        <p><?php echo the_content(); ?></p>
                        <?php echo nokri_pagination_unit_test(); ?>
                        <?php if (comments_open() || get_comments_number()) { ?>
                            <div class="comments-container">
                                <?php comments_template(); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
get_footer();
