<?php
/*  Employer Dashboard */
get_header();
global $nokri;
$user_id = get_current_user_id();

/* Checking if Employer have Account Members with job posting permissions */
$emp_id = get_user_meta($user_id, 'account_owner', true);
$member_id = get_user_meta($user_id, '_sb_is_member', true);
if (isset($member_id) && $member_id != '') {
    $current_id = $emp_id;
} else {
    $current_id = $user_id;
}

$user_info = wp_get_current_user();
$user_check = get_user_meta($user_id, '_sb_reg_type', true);
/* Getting Company Published Jobs */
$args = array(
    'post_type' => 'job_post',
    'orderby' => 'date',
    'order' => 'DESC',
    'author' => $current_id,
    'post_status' => array('publish'),
);
$query = new WP_Query($args);
$job_html = '';

if ($query->have_posts()) {
    $job_id = array();
    while ($query->have_posts()) {
        $job_title = '';
        $query->the_post();
        $job_id[] = get_the_ID();
    }
    wp_reset_postdata();
    $job_ids = implode(",", $job_id);

    global $wpdb;
    $query = "SELECT * FROM $wpdb->postmeta WHERE post_id IN ($job_ids) AND meta_key like '_job_applied_resume_%' ORDER BY meta_id DESC LIMIT 3";
    $applier_resumes = $wpdb->get_results($query);
    $noti_html = '';
    if (isset($applier_resumes) && count($applier_resumes) > 0) {
        $notijobs = true;
        foreach ($applier_resumes as $resumes) {
            $user_name = '';
            $array_data = explode('|', $resumes->meta_value);
            $applier = $array_data[0];
            $user = get_user_by('id', $applier);
            $apply_date = get_post_meta($resumes->post_id, '_job_applied_date_' . $applier, true);
            $apply_date = date_i18n(get_option('date_format'), strtotime($apply_date));
            if ($user) {
                $user_name = $user->display_name;
            }
            $noti_html .= '<li>
				<div class="notif-single">
				<a href="' . get_author_posts_url($applier) . '">' . $user_name . '</a>' . " " . esc_html__('Applied To', 'nokri') . '<a href="' . get_the_permalink($resumes->post_id) . '" class="notif-job-title">' . " " . get_the_title($resumes->post_id) . '</a>
				</div>
				<span class="notif-timing"><i class="icon-clock"></i> ' . ($apply_date) . '</span>
			</li>';
        }
    }
} else {
    $notijobs = false;
    $noti_html = esc_html__('No Notifications', 'nokri');
}
/* Getting Profile Photo */
$image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
    $image_link = array($nokri['nokri_user_dp']['url']);
}
if (get_user_meta($user_id, '_sb_user_pic', true) != "") {
    $attach_id = get_user_meta($user_id, '_sb_user_pic', true);
    $image_link = wp_get_attachment_image_src($attach_id, '');
}
if (empty($image_link[0])) {
    $image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
}
$tab_data = '';
if (isset($_GET['tab-data']) && $_GET['tab-data'] != "") {
    $tab_data = $_GET['tab-data'];
}
/* Change Col Size */
$is_show_section = true;
if (isset($_GET['tab-data']) && ($_GET['tab-data'] == "active-jobs" || $_GET['tab-data'] == "pending-jobs" || $_GET['tab-data'] == "inactive-jobs" || $_GET['tab-data'] == "resumes-list")) {
    $dashboardclass = 'col-md-10 col-sm-12 col-xs-12';
    $is_show_section = false;
} else {
    $dashboardclass = 'col-lg-7 col-md-6 col-sm-12 col-xs-12 col-lg-pull-3 col-md-pull-3';
}
/* top bar class check */
$top_bar_class = 'no-topbar';
if ((isset($nokri['header_top_bar'])) && $nokri['header_top_bar'] == 1) {
    $top_bar_class = '';
}
/* Socail links */
$emp_fb = get_user_meta($user_id, '_emp_fb', true);
$emp_google = get_user_meta($user_id, '_emp_google', true);
$emp_twitter = get_user_meta($user_id, '_emp_twitter', true);
$emp_linkedin = get_user_meta($user_id, '_emp_linked', true);
/* Emp dashboard text */
$user_profile_dashboard_txt = ( isset($nokri['user_profile_dashboard_txt']) && $nokri['user_profile_dashboard_txt'] != "" ) ? $nokri['user_profile_dashboard_txt'] : "";

$is_allow_crop = isset($nokri['user_crop_dp_switch']) ? $nokri['user_crop_dp_switch'] : false;

$is_elementor_header = isset($nokri['is_elementor_header']) ? $nokri['is_elementor_header'] : false;
if ($is_elementor_header == true) {

    $emp_dashboard = 'custom_emp';
} else {
    $emp_dashboard = '';
}
/* Display Jobs Alert Subscribers List */
$jobs_alert = isset($nokri['nokri_admin_job_alerts']) ? $nokri['nokri_admin_job_alerts'] : false;
$noti_html_alert = '';
if ($jobs_alert) {
    if (current_user_can('editor') || current_user_can('administrator')) {

        /* Getting Candidate Jobs Alert subscribers */
        $cand_ids = nokri_get_candidate_alerts_list();
        if (!empty($cand_ids)) {
            foreach ($cand_ids as $key => $candidate_id) {
                $alert_cand_id = $candidate_id->ID;
                $user_exist = get_userdata($alert_cand_id);
                $job_alert = nokri_get_candidates_job_alerts($alert_cand_id);
                foreach ($job_alert as $key => $candidate_alert) {
                    if ($user_exist) {
                        $user_display_name = $user_exist->display_name;
                    } else {
                        $user_display_name = '';
                    }
                    // $user_name = isset($candidate_alert['alert_name']) ? $candidate_alert['alert_name'] : '';
                    $user_email = isset($candidate_alert['alert_email']) ? $candidate_alert['alert_email'] : '';
                    $user_alert_date = isset($candidate_alert['alert_start']) ? $candidate_alert['alert_start'] : '';
                    $user_alert_cat = isset($candidate_alert['alert_category']) ? $candidate_alert['alert_category'] : '';
                    $apply_datesss = date_i18n(get_option('date_format'), strtotime($user_alert_date));
                    $term_name = get_term($user_alert_cat)->name;
                    $noti_html_alert .= ' <li>
				<div class="notif-single">
				<a href="' . get_author_posts_url($user_id) . '">' . $user_display_name . '</a>' . " " . esc_html__('have activate Job Alerts on', 'nokri') . '<a href="' . get_the_permalink($user_alert_cat) . '" class="notif-job-title">' . " " . $term_name . '</a>
				</div>
				<span class="notif-timing"><i class="icon-clock"></i> ' . ($apply_datesss) . '</span>
			</li>';
                }
            }
        }
        $noti_html_alert = $noti_html_alert;
    }
} else {
    $noti_html_alert = '';
}
?> 
<section class="dashboard-new emp_dashboard <?php echo esc_attr($emp_dashboard); ?> <?php echo esc_attr($top_bar_class); ?>">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 nopadding">
                    <div class="profile-menu">
                        <div class="menu-avtr-box">
                            <div class="user-img">
                                <img src="<?php echo esc_url($image_link[0]); ?>" class="img-responsive" alt="<?php echo esc_html__('image', 'nokri'); ?>">
                            </div>
                            <div class="user-text">
                                <h4><?php echo esc_html($user_profile_dashboard_txt); ?></h4>
                                <p><?php echo esc_html__('Welcome back', 'nokri'); ?></p>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="menu-dashboard"> <i class="ti-menu-alt"></i></a>
                        <ul id="accordion" class="accordion">
                            <?php
                            $is_member = get_user_meta($user_id, '_sb_is_member', true);
                            if (isset($is_member) && $is_member != '') {
                                echo nokri_employer_member_menu_sorter($user_id);
                            } else {
                                echo nokri_employer_menu_sorter($user_id);
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <?php if ($is_show_section) { ?>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col-lg-push-7 col-md-push-6 nopadding" id="dashboard-bar-right">
                        <div class="theiaStickySidebar">
                            <div class="main-profile-card">
                                <div class="contact-box">
                                    <div class="contact-img">
                                        <img src="<?php echo esc_url($image_link[0]); ?>" id="emp_dp" class="img-responsive" alt="<?php echo esc_html__('image', 'nokri'); ?>">
                                    </div>
                                    <div class="contact-caption">
                                        <?php
                                        if ($is_allow_crop) {
                                            echo ' <a href="Javascript:void(0)"  id="edit-user-pic">' . esc_html__('Edit', 'nokri') . '</a>';
                                        }
                                        ?>
                                        <h4><?php echo the_author_meta('display_name', $user_id); ?></h4>
                                        <span><?php echo get_user_meta($user_id, '_user_headline', true); ?></span>
                                    </div>
                                    <ul class="social-links list-inline">
                                        <?php if ($emp_fb) { ?>
                                            <li> <a href="<?php echo esc_url($emp_fb); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/006-facebook.png" alt="<?php echo esc_html__('icon', 'nokri'); ?>"></a></li>
                                        <?php } if ($emp_google) { ?>
                                            <li> <a href="<?php echo esc_url($emp_google); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/003-google-plus.png" alt="<?php echo esc_html__('icon', 'nokri'); ?>"></a></li>
                                        <?php } if ($emp_twitter) { ?>
                                            <li> <a href="<?php echo esc_url($emp_twitter); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/004-twitter.png" alt="<?php echo esc_html__('icon', 'nokri'); ?>"></a></li>
                                        <?php } if ($emp_linkedin) { ?>
                                            <li> <a href="<?php echo esc_url($emp_linkedin); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/005-linkedin.png" alt="<?php echo esc_html__('icon', 'nokri'); ?>"></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="notification-area">
                                    <h4> <?php echo esc_html__('Recent Notifications', 'nokri'); ?></h4>
                                    <div class="notif-box">
                                        <ul>
                                            <?php
                                            /* Check if user is a member of an employer and have permissions */

                                            $permissions = get_user_meta($user_id, 'member_permissions', true);
                                            $member_id = get_user_meta($user_id, '_sb_is_member', true);
                                            if (isset($member_id) && $member_id != '') {
                                                if (isset($permissions['emp_dashboard']) && $permissions['emp_dashboard'] != '') {
                                                    echo '' . ($noti_html);
                                                }
                                            } else {
                                                echo '' . ($noti_html . '' . $noti_html_alert);
                                            }
                                            ?>
                                            <li>
                                                <?php
                                                if (isset($notijobs) && $notijobs) {
                                                    if (isset($member_id) && $member_id != '') {
                                                        
                                                    } else {
                                                        ?>
                                                        <div class="notif-single">
                                                            <a href="<?php echo get_the_permalink(); ?>?tab-data=resume-notification"><?php echo esc_html__('View all notifications', 'nokri'); ?> </a>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="<?php echo esc_attr($dashboardclass); ?>">
                    <?php
                    if ($tab_data != "") {
                        get_template_part('template-parts/employer/employer', $tab_data);
                    } else {
                        get_template_part('template-parts/employer/index', $tab_data);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="is_accordion" value="1">
</section>

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
                        <img  src="<?php echo esc_url($image_link[0]); ?>">
                    </div>                          
                    <button class="btn n-btn-flat"  id="image_rotator" data-deg="-90"><?php echo esc_html__('Rotate', 'nokri') ?></button>
                </div>                                                                                                           
                <div class="modal-footer">
                    <button type="submit" name="crop_image" class="btn n-btn-flat btn-mid btn-block" id="crop_image_submit">
                        <?php echo esc_html__('Crop', 'nokri') ?></button>
                </div>
            </div>
        </div>
    </div>             
</div>
