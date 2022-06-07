<?php
/* Template Name: Employer Reviews */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package nokri
 */
?>
<?php
get_header();
global $nokri;
$author_id = $_GET["user_id"];
//$author_id = get_query_var( 'user_id' );
$author_detail = get_userdata($author_id);
$current_user_id = get_current_user_id();


if (isset($author_detail) && $author_detail != "") {
    $user_type = get_user_meta($author_id, '_sb_user_type', true);
    $author = get_user_by('ID', $author_id);
    $registered = $author->user_registered;
    $emp_address = get_user_meta($author_id, '_emp_map_location', true);
    $emp_size = get_user_meta($author_id, '_emp_nos', true);
    $is_public = isset($nokri['user_phone_email']) && $nokri['user_phone_email'] == '1' ? true : false;
    $emp_web = get_user_meta($author_id, '_emp_web', true);
    $emp_cntct = get_user_meta($author_id, '_sb_contact', true);
    $is_public_contact = isset($nokri['user_contact_form']) && $nokri['user_contact_form'] == '1' ? true : false;
    $contact_recaptcha = isset($nokri['user_contact_form_recaptcha'])  ? $nokri['user_contact_form_recaptcha'] :false;
    ?>
    <div class="main-content-area clearfix"> 
        <section class="section-padding pattern_dots"> 
            <!-- Main Container -->
            <div class="container"> 
                <!-- Row -->
                <div class="row"> 
                    <div class="col-md-12 col-lg-12 col-xs-12"> 
                        <!-- Row -->
                        <div class="row">
                            <div class="clearfix"></div>
                            <!-- Ads Archive -->
                            <div class="dealers-single-page">
                                <div class="col-md-8 col-xs-12 col-sm-8 col-lg-8">
                                    <div class="profile-title-box">
                                        <div class="profile-heading">
                                            <h2>
                                                <?php
                                                if (get_user_meta($author_id, '_sb_camp_name', true) != "") {
                                                    echo esc_html(get_user_meta($author_id, '_sb_camp_name', true));
                                                } else {
                                                    echo esc_html($author_detail->display_name);
                                                }
                                                ?> 
                                                <?php
                                                if (get_user_meta($author_id, '_sb_badge_text', true) != "" && get_user_meta($author_id, '_sb_badge_type', true) != "") {
                                                    ?>
                                                    <span class="label <?php echo esc_html(get_user_meta($author_id, '_sb_badge_type', true)); ?>">  <?php echo esc_html(get_user_meta($author_id, '_sb_badge_text', true)); ?></span>
                                                <?php } ?>
                                            </h2>
                                        </div>
                                        <div class="profile-meta">
                                            <ul>
                                                <li>
                                                    <i class="la la-certificate icon"></i>
                                                    <span class="profile-meta-title"><?php echo esc_html__('Ratings: ', 'nokri'); ?> </span>
                                                    <?php
                                                    if (isset($nokri['sb_enable_user_ratting']) && $nokri['sb_enable_user_ratting']) {
                                                        echo avg_user_rating($author_id) . ' (';
                                                        echo nokri_employer_review_count($author_id) . ')';
                                                    }
                                                    ?>
                                                </li>
                                                <li>
                                                    <i class="la la-calendar-o icon"></i>
                                                    <span class="profile-meta-title"><?php echo esc_html__('Member since: ', 'nokri'); ?> </span>
                                                    <?php echo date("F j, Y", strtotime($author_detail->user_registered)); ?>
                                                </li>
                                                <?php
                                                if ($user_type == 'dealer') {
                                                    ?>
                                                    <li>
                                                        <i class="la la-clock-o icon"></i>
                                                        <span class="profile-meta-title"><?php echo esc_html__('Working Hours: ', 'nokri'); ?> </span>
                                                        <?php echo esc_html(get_user_meta($author_id, '_sb_user_timings', true)); ?>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php get_template_part('template-parts/profiles/rating'); ?>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-4 col-lg-4">
                                    <div class="n-candidate-detail">
                                        <aside class="resume-3-sidebar">                                      
                                            <div class="n-candidate-info">
                                                <h4 class="widget-heading"><?php echo nokri_feilds_label('emp_det', esc_html__('Employer detail:', 'nokri')); ?></h4>
                                                <ul>
                                                    <li>
                                                        <i class="la la-calendar la-3x"></i>
                                                        <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('emp_mem_sinc', esc_html__('Member since:', 'nokri')); ?></small> <strong><?php echo date_i18n(get_option('date_format'), strtotime($registered)); ?></strong></div>
                                                    </li>
                                                    <?php if ($emp_address) { ?>
                                                        <li>
                                                            <i class="la la-map-marker la-3x "></i> 
                                                            <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('emp_loc_section_label', esc_html__('Location:', 'nokri')); ?></small> <strong><?php echo esc_html($emp_address); ?> </strong></div>
                                                        </li>
                                                    <?php } if ($emp_size) { ?>
                                                        <li>
                                                            <i class="la la-users la-3x"></i> 
                                                            <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('emp_no_emp_label', esc_html__('Employees:', 'nokri')); ?></small><strong><?php echo esc_html($emp_size); ?></strong></div>
                                                        </li>
                                                    <?php } if ($is_public || $author_id == $current_user_id) { ?>
                                                        <li>
                                                            <i class="la la-envelope la-3x"></i> 
                                                            <div class="resume-detail-meta"><a href="mailto:<?php echo esc_attr($author->user_email); ?>"><small><?php echo nokri_feilds_label('emp_email_label', esc_html__('Email Address:', 'nokri')); ?></small><strong><?php echo esc_html($author->user_email); ?></strong></a></div>
                                                        </li>
                                                    <?php } if ($emp_web) { ?>
                                                        <li>
                                                            <i class="la la-globe la-3x"></i> 
                                                            <div class="resume-detail-meta"><a href="<?php echo esc_url($emp_web); ?>" target="_blank"><small><?php echo nokri_feilds_label('emp_web_label', esc_html__('Website URL:', 'nokri')); ?></small><strong><?php echo esc_html($emp_web); ?></strong></a></div>
                                                        </li>
                                                    <?php } if ($is_public && $author_id == $current_user_id) { ?>
                                                        <li>
                                                            <i class="la la-mobile la-3x"></i>
                                                            <div class="resume-detail-meta"><a href="tel:<?php echo esc_attr($emp_cntct); ?>"> <small><?php echo nokri_feilds_label('emp_phone_label', esc_html__('Contact Number:', 'nokri')); ?></small><strong><?php echo esc_html($emp_cntct); ?></strong></a></div>
                                                        </li>
                                                        <?php
                                                    }
                                                    if (get_user_meta($current_user_id, '_sb_reg_type', true) == 0) {
                                                        $comp_follow = get_user_meta($current_user_id, '_cand_follow_company_' . $author_id, true);
                                                        if ($comp_follow) {
                                                            ?>
                                                            <li><a class="btn n-btn-flat btn-block"><?php echo esc_html__('Followed', 'nokri'); ?></a></li>
                                                        <?php } else { ?>
                                                            <li><a  data-value="<?php echo esc_attr($author_id); ?>"  class="btn n-btn-flat btn-block follow_company"><?php echo " " . esc_html__('Follow', 'nokri'); ?></a></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>

                                            </div>

                                            <?php if ($is_public_contact) { ?>
                                                <div class="widget">
                                                    <h4 class="widget-heading"><?php
                                                        echo nokri_feilds_label('emp_cont_lab', esc_html__('Contact ', 'nokri')) . " ";
                                                        echo the_author_meta('display_name', $author_id);
                                                        ?></h4>
                                                    <form id="contact_form_email" method="POST" enctype="multipart/form-data">
                                                        <div class="form-group">
                                                            <input type="text" name="contact_name" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__('Please enter name', 'nokri'); ?>" class="form-control" placeholder="<?php echo esc_html__('Full name', 'nokri'); ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="email" name="contact_email" class="form-control" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__('Please enter email', 'nokri'); ?>"  placeholder="<?php echo esc_html__('Email address', 'nokri'); ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__('Please enter subject', 'nokri'); ?>" name="contact_subject"   placeholder=" <?php echo esc_html__('Subject', 'nokri'); ?>">
                                                        </div>
                                                        <input type="hidden" name="receiver_id" value="<?php echo esc_attr($author_id); ?>" />
                                                        <div class="form-group">
                                                            <textarea name="contact_message" class="form-control"  rows="5"></textarea>
                                                        </div>
                                                        <?php if ($nokri['google_recaptcha_key'] != "" && $contact_recaptcha) { ?>

                                                            <div class="g-recaptcha form-group" name="contact-recaptcha" data-sitekey="<?php echo esc_attr($nokri['google_recaptcha_key']); ?>">
                                                            </div>             
                                                        <?php } ?>
                                                        <button type="submit" class="btn n-btn-flat btn-mid btn-block contact_me"><?php echo esc_html__('Message', 'nokri'); ?></button>
                                                    </form>
                                                </div>

                                            <?php } ?>
                                        </aside>
                                    </div>

                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
    <?php
    get_footer();
} else {
    wp_redirect(home_url());
}
?>