<?php
/*  Candidate Dashboard */
global $nokri;
$user_info = wp_get_current_user();
$user_crnt_id = $is_candidate = $user_info->ID;
$ad_mapLocation = '';
$ad_mapLocation = get_user_meta($user_crnt_id, '_cand_address', true);
$ad_map_lat = get_user_meta($user_crnt_id, '_cand_map_lat', true);
$ad_map_long = get_user_meta($user_crnt_id, '_cand_map_long', true);
$cand_video = get_user_meta($user_crnt_id, '_cand_video', true);
$job_qualifications = get_user_meta($user_crnt_id, '_cand_last_edu', true);
nokri_load_search_countries(1);
/* Getting Candidate Dp */
/* Updating Profile Percentage */
$top_bar_class = 'no-topbar';
if ((isset($nokri['header_top_bar'])) && $nokri['header_top_bar'] == 1) {
    $top_bar_class = '';
}
echo nokri_updating_candidate_profile_percent();
$image_dp_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
    $image_dp_link = array($nokri['nokri_user_dp']['url']);
}
if (get_user_meta($user_crnt_id, '_cand_dp', true) != "") {
    $attach_dp_id = get_user_meta($user_crnt_id, '_cand_dp', true);
    $image_dp_link = wp_get_attachment_image_src($attach_dp_id, 'nokri_job_hundred');
}
$candidate_page = '';
if (isset($_GET['candidate-page']) && $_GET['candidate-page'] != "") {
    $candidate_page = $_GET['candidate-page'];
} else {
    
}

/* Candidate Job Notifiactions */
$cand_job_notif_en = ( isset($nokri['cand_job_notif']) && $nokri['cand_job_notif'] != "" ) ? $nokri['cand_job_notif'] : '1';
$cand_job_notif = ( isset($nokri['cand_job_notif']) && $nokri['cand_job_notif'] != "" ) ? $nokri['cand_job_notif'] : false;
$get_companies = nokri_following_company_ids($user_crnt_id);



if (!empty($get_companies) && $cand_job_notif == '2') {
    $authors = $get_companies;
    $noti_message = esc_html__('Follow companies for job notifications', 'nokri');
} else if ($cand_job_notif == '1') {
    $authors = 0;
    $noti_message = esc_html__('Set your skills for job notifications', 'nokri');
} else {
    $authors = 98780;
    $noti_message = esc_html__('Follow companies for job notifications', 'nokri');
}
$query = array(
    'post_type' => 'job_post',
    'post_status' => 'publish',
    'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
    'author__in' => $authors,
    'meta_query' => array(
        array(
            'key' => '_job_status',
            'value' => 'active',
            'compare' => '=',
        ),
    ),
);
$args = nokri_wpml_show_all_posts_callback($query);
$loop = new WP_Query($query);
$notification = '';
while ($loop->have_posts()) {


    $loop->the_post();
    $job_id = get_the_ID();
    $post_author_id = get_post_field('post_author', $job_id);
    $company_name = get_the_author_meta('display_name', $post_author_id);
    $job_skills = wp_get_post_terms($job_id, 'job_skills', array("fields" => "ids"));
    $cand_skills = get_user_meta($user_crnt_id, '_cand_skills', true);
    if (is_array($job_skills) && is_array($cand_skills)) {
        $final_array = array_intersect($job_skills, $cand_skills);
        if (count($final_array) > 0) {
            $notification .= '<li>
								<div class="notif-single">
									<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html($company_name) . " " . '</a>' . esc_html__('Posted', 'nokri') . '<a href="' . get_the_permalink($job_id) . '" class="notif-job-title">' . " " . get_the_title() . '</a>
								</div>
								<span class="notif-timing"><i class="icon-clock"></i>' . nokri_time_ago() . '</span>
							</li>';
        }
    }
}
wp_reset_postdata();
/* Candidate Job Notifiactions End */
if (isset($_GET['candidate-page']) && $_GET['candidate-page'] == "my-profile") {
    $dashboardclass = 'candidate-resume-page';
    $conatainerclass = '';
} else {
    $dashboardclass = 'dashboard-new candidate-dashboard';
    $conatainerclass = '-fluid';
}
/* Transparent header dashboard class */
$transparent_header_class = '';
$stick_right_bar = 'id="dashboard-bar-right"';
if ((isset($nokri['main_header_style'])) && $nokri['main_header_style'] == '2' || $nokri['main_header_style'] == '4') {
    $transparent_header_class = 'dashboard-transparent-header';
    $stick_right_bar = '';
}
/* Cand basic info */
$dob = get_user_meta($user_crnt_id, '_cand_dob', true);
$phone = get_user_meta($user_crnt_id, '_sb_contact', true);
$email = $user_info->user_email;
$address = get_user_meta($user_crnt_id, '_cand_address', true);
/* Cand dashboard text */
$user_profile_dashboard_txt = ( isset($nokri['user_profile_dashboard_txt']) && $nokri['user_profile_dashboard_txt'] != "" ) ? $nokri['user_profile_dashboard_txt'] : "";
/* Low profile txt */
$user_low_profile_txt_btn = ( isset($nokri['user_low_profile_txt_btn']) && $nokri['user_low_profile_txt_btn'] != "" ) ? $nokri['user_low_profile_txt_btn'] : false;
$profile_percent = get_user_meta($user_crnt_id, '_cand_profile_percent', true);
$user_low_profile_txt = ( isset($nokri['user_low_profile_txt']) && $nokri['user_low_profile_txt'] != "" ) ? $nokri['user_low_profile_txt'] : "";
/* Is applying job package base */
$is_apply_pkg_base = ( isset($nokri['job_apply_package_base']) && $nokri['job_apply_package_base'] != "" ) ? $nokri['job_apply_package_base'] : false;

$percaentage_switch = isset($nokri['cand_per_switch']) ? $nokri['cand_per_switch'] : false;

$is_allow_crop = isset($nokri['user_crop_dp_switch']) ? $nokri['user_crop_dp_switch'] : false;
$is_elementor_header = isset($nokri['is_elementor_header']) ? $nokri['is_elementor_header'] : false;
if ($is_elementor_header == true) {

    $emp_dashboard = 'custom_emp';
} else {
    $emp_dashboard = '';
}
?>
<section class="dashboard-new candidate-dashboard <?php echo esc_attr($emp_dashboard); ?> <?php echo esc_attr($top_bar_class); ?>">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                <?php
                if (isset($_GET['candidate-page']) && $_GET['candidate-page'] == "my-profile") {
                    get_template_part('template-parts/candidate/candidate', $candidate_page);
                } else {
                    ?>
                    <div class="col-lg-2 col-md-3 col-sm-2 col-xs-12 nopadding">
                        <div class="profile-menu">
                            <div class="menu-avtr-box">
                                <div class="user-img">
                                    <img src="<?php echo esc_url($image_dp_link[0]); ?>" id="candidate_dp" class="img-responsive"   alt="<?php echo esc_html__('candidate profile image', 'nokri'); ?>"> 
                                </div>
                                <div class="user-text">
                                    <h4><?php echo esc_html($user_profile_dashboard_txt); ?></h4>
                                    <p><?php echo esc_html__('Welcome back', 'nokri'); ?></p>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="menu-dashboard"> <i class="ti-menu-alt"></i></a>
                            <ul id="accordion" class="accordion">
                                <?php echo nokri_candidate_menu_sorter($user_crnt_id); ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-9 col-sm-12 col-xs-12 col-lg-push-7 nopadding ">
                        <div class="theiaStickySidebar">
                            <div class="main-profile-card">
                                <div class="contact-box">
                                    <div class="contact-img">

                                        <img src="<?php print_r($image_dp_link[0]);?>" id="candidate_dp" class="img-responsive img-circle" alt="<?php echo esc_html__('candidate profile image', 'nokri'); ?>">
                                    </div>
                                    <div class="contact-caption">
                                        <?php
                                        if ($is_allow_crop) {
                                            echo ' <a href="Javascript:void(0)"  id="edit-user-pic">' . esc_html__('Edit', 'nokri') . '</a>';
                                        }
                                        ?>

                                        <h4><?php echo esc_html($user_info->display_name); ?></h4>
                                        <span><?php echo get_user_meta($user_crnt_id, '_user_headline', true); ?></span>
                                    </div>
                                    <ul class="social-links list-inline">
                                        <?php if (get_user_meta($user_crnt_id, '_cand_fb', true) != '') { ?>
                                            <li> <a href="<?php echo nokri_candidate_user_meta('_cand_fb'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/resume-detail-icons/006-facebook.png" alt="<?php echo esc_html__('icon', 'nokri'); ?>"></a></li>
                                        <?php } if (get_user_meta($user_crnt_id, '_cand_twiter', true) != '') { ?>
                                            <li> <a href="<?php echo nokri_candidate_user_meta('_cand_twiter'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/resume-detail-icons/004-twitter.png" alt="<?php echo esc_html__('icon', 'nokri'); ?>"></a></li>
                                        <?php } if (get_user_meta($user_crnt_id, '_cand_google', true) != '') { ?>
                                            <li> <a href="<?php echo nokri_candidate_user_meta('_cand_google'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/resume-detail-icons/003-google-plus.png" alt="<?php echo esc_html__('icon', 'nokri'); ?>"></a></li>
                                        <?php } if (get_user_meta($user_crnt_id, '_cand_linked', true) != '') { ?>
                                            <li> <a href="<?php echo nokri_candidate_user_meta('_cand_linked'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/resume-detail-icons/005-linkedin.png" alt="<?php echo esc_html__('icon', 'nokri'); ?>"></a></li>
                                        <?php } ?>
                                    </ul>

                                    <?php if ($percaentage_switch) { ?>
                                        <div class="progress-bar-section">
                                            <div class="progress">
                                                <div class="progress-bar"> <span data-percent="<?php echo esc_attr($profile_percent); ?>" class="profile<?php echo esc_attr($profile_percent); ?>"></span> </div>
                                            </div>
                                            <div class="progress-bar-title">
                                                <h5><?php echo esc_html__('Profile Percent', 'nokri'); ?></h5>
                                                <span class="progress-percentage"><?php echo esc_attr($profile_percent); ?>%</span>
                                            </div>
                                            <?php if ($profile_percent < 40 && $user_low_profile_txt_btn) { ?>                  
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <strong><?php echo esc_html__('Alert ! ', 'nokri'); ?></strong><?php echo esc_html($user_low_profile_txt); ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="resume-detail">
                                    <ul>
                                        <?php if ($dob) { ?>
                                            <li> <i class="ti-calendar"></i><?php echo esc_html__('Date of Birth: ', 'nokri'); ?><strong><?php echo date_i18n(get_option('date_format'), strtotime($dob)); ?></strong></li>
                                        <?php } if ($phone) { ?>
                                            <li> <i class="ti-mobile"></i><?php echo esc_html($phone); ?></li>
                                        <?php } if ($email) { ?>
                                            <li> <i class="ti-email"></i> <?php echo esc_html($email); ?></li>
                                        <?php } if ($address) { ?>
                                            <li> <i class="ti-location-arrow"></i><?php echo esc_html($address); ?></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <?php if (isset($cand_job_notif_en) && $cand_job_notif_en != '3') { ?>
                                    <div class="notification-area">
                                        <?php if ($notification) { ?>
                                            <h4><?php echo nokri_feilds_label('cand_job_notif_txt', esc_html__('These jobs match your skills', 'nokri')); ?></h4> 
                                        <?php } ?>
                                        <div class="notif-box">
                                            <ul>
                                                <?php echo "" . $notification; ?>
                                                <li>
                                                    <?php if ($notification) { ?>
                                                        <div class="notif-single">
                                                            <a href="<?php echo get_the_permalink(); ?>?candidate-page=jobs-notification"><?php echo esc_html__('View all notifications', 'nokri'); ?></a>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="notif-single">
                                                            <h4><?php echo esc_html($noti_message); ?></h4>
                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>


                                <?php } ?>
                            </div>
                            <?php if (isset($nokri['cand_resume_gen_dashboard']) && $nokri['cand_resume_gen_dashboard']) { ?>
                                <a class="btn n-btn-flat btn-block" href="#" data-toggle="modal" data-target="#template_modal" > <?php echo esc_html__('Generate Resume', 'nokri') ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-9 col-sm-12 col-xs-12 col-lg-pull-3 col-lg-offset-0 col-md-offset-3">
                        <?php
                        if ($candidate_page != "") {
                            get_template_part('template-parts/candidate/candidate', $candidate_page);
                        } else {
                            get_template_part('template-parts/candidate/index', $candidate_page);
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <input type="hidden" id="is_accordion" value="1">
</section>

<!------ Resumes template model's ---------->
<div class="container text-center">
    <div class="modal fade" tabindex="-1"  aria-hidden="true" id="template_modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div id="template-crousel" class="carousel slide" data-ride="carousel">
                    <!-- Carousel Container -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <a href="javascript:void(0)" data-id="1" class="generate_resume"  data-cand-id="<?php echo esc_attr($user_crnt_id) ?>"> <img src="<?php echo get_template_directory_uri() . '/template-parts/cv-templates/images/cv-1.png'; ?>" class="" ></a>    
                        </div>
                        <div class="item">
                            <a href="javascript:void(0)" data-id="2" class="generate_resume"  data-cand-id="<?php echo esc_attr($user_crnt_id) ?>">  <img src="<?php echo get_template_directory_uri() . '/template-parts/cv-templates/images/cv-2.png'; ?>" class="" ></a>     
                        </div>
                        <div class="item">
                            <a href="javascript:void(0)" data-id="3" class="generate_resume" data-cand-id="<?php echo esc_attr($user_crnt_id) ?>"> <img src="<?php echo get_template_directory_uri() . '/template-parts/cv-templates/images/cv-3.png'; ?>" class="" ></a>
                        </div>
                        <div class="item">
                            <a href="javascript:void(0)" data-id="4" class="generate_resume" data-cand-id="<?php echo esc_attr($user_crnt_id) ?>"> <img src="<?php echo get_template_directory_uri() . '/template-parts/cv-templates/images/cv-4.png'; ?>" class="" ></a>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#template-crousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#template-crousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade resume-action-modal" id="edit-profile-modal">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">         
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title"><?php echo esc_html__('Crop Profile Image', 'nokri') ?></h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">

                        <label class=""><?php echo nokri_feilds_label('cand_dp_label', esc_html__('Profile Image', 'nokri')); ?></label>
                        <input id="browse-cand-dp" name="candidate_dp[]" type="file" class="file form-control" data-show-preview="false" data-allowed-file-extensions='["jpg", "png", "jpeg"]' data-show-upload="false" >

                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="cropper-img">                                                              
                        <img  src="<?php echo esc_url($image_dp_link[0]); ?>">
                    </div>                          
                    <button class="btn n-btn-flat"  id="image_rotator" data-deg="-90"><?php echo esc_html__('Rotate', 'nokri') ?></button>
                </div>                                                                                                           
                <div class="modal-footer">
                    <button type="submit" name="crop_image" class="btn n-btn-flat btn-mid btn-block" id="crop_image_submit">
                        <?php echo esc_html__('Crop', 'nokri') ?>                  </button>
                </div>
            </div>
        </div>
    </div>             
</div>
