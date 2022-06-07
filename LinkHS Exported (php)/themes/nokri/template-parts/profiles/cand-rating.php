<?php
global $nokri;
$author_id = get_query_var('author');
if ($author_id == "" ) {
    $author_id = $_GET["user_id"];
}
if (isset($nokri['sb_enable_cand_ratting']) && $nokri['sb_enable_cand_ratting']) {
    ?>
    <div class="col-md-12 col-xs-12 col-sm-12 no-padding">
        <div class="dealers-review-section">
            <h3 class="profile-heading">
                <?php
                if (isset($nokri['sb_cand_reviews_title']) && $nokri['sb_cand_reviews_title']) {
                    echo esc_html($nokri['sb_cand_reviews_title']);
                }
                ?>
            </h3>

            <?php get_template_part('template-parts/profiles/cand-all-rating'); ?>
        </div>
        <?php
        if (is_user_logged_in()) {
            ?>
            <div class="review-form">
                <h3 class="profile-heading">
                    <?php
                    if (isset($nokri['cand_write_reviews_title']) && $nokri['cand_write_reviews_title']) {
                        echo esc_html($nokri['cand_write_reviews_title']);
                    }
                    ?>
                </h3>
                <form action="" id="cand_ratting_form" data-parsley-validate="" method="post">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                            <ul class="review-star-box">
                                <li>
                                    <div class="form-group">
                                        <label class="control-label">
                                            <?php
                                            if (isset($nokri['cand_first_rating_stars_title']) && $nokri['cand_first_rating_stars_title']) {
                                                echo esc_html($nokri['cand_first_rating_stars_title']);
                                            }
                                            ?>
                                        </label>
                                        <div dir="lrt">
                                            <input name="rating_service" value="0" autocomplete="off" type="text"  data-show-clear="false" class="rating" data-min="0" data-max="5" min="0" data-step="1" data-size="xs" required <?php if (is_rtl()) { ?> dir="rtl"<?php } ?>>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <label class="control-label">
                                            <?php
                                            if (isset($nokri['cand_second_rating_stars_title']) && $nokri['cand_second_rating_stars_title']) {
                                                echo esc_html($nokri['cand_second_rating_stars_title']);
                                            }
                                            ?>
                                        </label>
                                        <input name="rating_process" autocomplete="off" value="0" type="text"  data-show-clear="false" class="rating" data-min="0" data-max="5" min="0" data-step="1" data-size="xs" required <?php if (is_rtl()) { ?> dir="rtl"<?php } ?>>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <label class="control-label">
                                            <?php
                                            if (isset($nokri['cand_third_rating_stars_title']) && $nokri['cand_third_rating_stars_title']) {
                                                echo esc_html($nokri['cand_third_rating_stars_title']);
                                            }
                                            ?>
                                        </label>
                                        <input name="rating_selection" value="0" autocomplete="off" type="text"  data-show-clear="false" class="rating" data-min="0" data-max="5" min="0" data-step="1" data-size="xs" required <?php if (is_rtl()) { ?> dir="rtl"<?php } ?>>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo esc_html__('Review Title', 'nokri') ?></label>
                                <input class="form-control" type="text" name="review_title" required data-parsley-error-message="<?php echo esc_html__('Provide title', 'nokri') ?>"/>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="control-label protip"><?php echo esc_html__('Your Review', 'nokri') ?></label>
                                <textarea name="review_message" class="form-control" cols="30" rows="10" required data-parsley-error-message="<?php echo esc_html__('write you review here', 'nokri') ?>"></textarea>
                            </div>
                        </div>


                        <?php if ($nokri['google_recaptcha_key'] != "") { ?>
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <div class="g-recaptcha" name="cand_review_captcha" data-sitekey="<?php echo esc_attr($nokri['google_recaptcha_key']); ?>"></div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <input class="btn n-btn-flat <?php if (is_rtl()) { ?> pull-left <?php } else { ?> pull-right <?php } ?>" type="submit" value="<?php echo esc_html__('Submit Rating', 'nokri') ?>" />
                                <input type="hidden" name="emp_id" value="<?php echo esc_attr($author_id); ?>" />
                                <input type="hidden" id="rating_nonce" value="<?php echo wp_create_nonce('nokri_rating_secure') ?>"  />
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <?php
        } else {
            ?>
            <div class="alert custom-alert custom-alert-warning" role="alert">
                <div class="custom-alert_top-side">
                    <span class="alert-icon custom-alert_icon la la-info-circle"></span>
                    <div class="custom-alert_body">
                        <h6 class="custom-alert_heading">
                            <?php echo esc_html__('Login To Write A Review. ', 'nokri'); ?>
                        </h6>
                        <div class="custom-alert_content">
                            <?php echo esc_html__('Sorry, only login users are eligibale to post a review.. ', 'nokri'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
<?php }
?>