<?php
get_header();
the_post();
$post = get_post();
if ($post && ( preg_match('/vc_row/', $post->post_content) )) {
    the_content();
} else if (nokri_check_is_elementor($post->ID)) {
    the_content();
} else {
    ?>
    <section class="blog-detail-page">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="blog-post">
                        <div class="blog-single entry-content">
                            <h4 class="blog-main-title"><?php echo the_title(); ?></h4>
                            <p><?php echo the_content(); ?></p>
                            <div class="clearfix"></div>
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
        </div>
    </section>
    <?php
}
get_footer();
