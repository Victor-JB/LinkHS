<?php
global $nokri;
$job_id = get_the_ID();
$user_id = get_current_user_id();

/* Checking if Employer have Account Members with job posting permissions */
$emp_id = get_user_meta($user_id, 'account_owner', true);
if (isset($emp_id) && $emp_id != '') {
    $user_id = $emp_id;
} else {
    $user_id = $user_id;
}
$job_type = wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
$job_type = isset($job_type[0]) ? $job_type[0] : '';
$job_salary = wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
$job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
$job_salary_type = wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
$job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
$job_currency = wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
$job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
$company_name = get_user_meta($user_id, '_emp_name', true);
$job_expiry = get_post_meta($job_id, '_job_date', true);
$job_status = get_post_meta($job_id, '_job_status', true);
if ($job_status == 'inactive') {
    $job_status = esc_html__('inactive', 'nokri');
}
/* Expiry Date */
$package_date = get_user_meta($user_id, '_sb_expire_ads', true);
$today = date("Y-m-d");
$take_action = true;
$expiry_date_string = strtotime($package_date);
$today_string = strtotime($today);
if ($today_string > $expiry_date_string) {
    $take_action = false;
}
$is_show_bump_up = false;
$bump_ads_limit = get_user_meta($user_id, 'bump_ads_limit', true);
if ((isset($nokri['allow_bump_jobs'])) && $nokri['allow_bump_jobs'] != "" && $bump_ads_limit != "" && $today_string < $expiry_date_string) {
    $is_show_bump_up = true;
}
$emp_single_job_stats = isset($nokri['emp_single_jobs_stats_']) ? $nokri['emp_single_jobs_stats_'] : false;

$job_ap_status = $job_status;
$staus_clr = 'warning';
if ($job_status == 'active') {
    $job_ap_status = esc_html__('active', 'nokri');
    $staus_clr = 'success';
}
$resume_counts = nokri_get_resume_count($job_id);
/* Getting Company  Profile Photo */
if (get_user_meta($user_id, '_sb_user_pic', true) != "") {
    $attach_id = get_user_meta($user_id, '_sb_user_pic', true);
    $image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
}
/* Calling Funtion Job Class For Badges */
$single_job_badges = nokri_job_class_badg($job_id);
$job_badge_text = '';
if (count($single_job_badges) > 0) {
    foreach ($single_job_badges as $job_badge => $val) {
        $job_badge_text .= '<a href="#">' . esc_html(ucfirst($job_badge)) . '</a>';
    }
}
/* Dashboard Page */
$dashboard_id = '';
if ((isset($nokri['sb_dashboard_page'])) && $nokri['sb_dashboard_page'] != '') {
    $dashboard_id = ($nokri['sb_dashboard_page']);
}
/* Getting Employer Members Info who posted Job */
$member_id = get_post_meta($job_id, 'job_post_member_id', true);
$post_author = nokri_get_display_name($member_id);
if ($post_author) {
    $html = '<p><strong>' . esc_html__('Posted by', 'nokri') . ': </strong>' . esc_html($post_author) . '</p>';
} else {
    $html = '';
}
?>
<div class="cp-loader"></div>
<div class="posted-job-list" id="all-jobs-list-box2-<?php echo esc_attr($job_id); ?>">
    <ul class="list-inline">
        <li class="posted-job-title"> 
            <a href="<?php echo get_the_permalink($job_id); ?>"><?php the_title(); ?></a>
            <p><strong><?php echo esc_html__('Posted Date', 'nokri'); ?>: </strong><?php echo get_the_date(); ?></p>
            <?php echo nokri_returnEcho($html); ?>
            <div class="job-class"> 
                <?php echo "" . $job_badge_text ?>
            </div>
        </li>
        <li class="posted-job-status"><span class="label label-<?php echo esc_attr($staus_clr); ?>"><?php echo esc_html($job_ap_status); ?></span></li>
        <li class="posted-job-applicants"><?php echo esc_attr($resume_counts); ?></li>
        <li class="posted-job-expiration"><?php echo date_i18n(get_option('date_format'), strtotime($job_expiry)); ?></li>
        <li class="posted-job-action"> 
            <ul class="list-inline">
                <?php
                $myurl = get_the_permalink($dashboard_id);
                $final_url = esc_url(nokri_set_url_params_multi($myurl, 'tab-data', 'resumes-list', 'id', $job_id));
                ?>
                <li class="tool-tip" title="<?php echo esc_html__('View Applications', 'nokri'); ?>"> <a href="<?php echo '' . $final_url; ?>" class="label label-success"> <i class="ti-files"></i></a></li>
                <?php
                if ($job_status == 'active') {
                    $link = nokri_set_url_param(get_the_permalink($nokri['sb_post_ad_page']), 'id', esc_attr($job_id));
                    $final_url = esc_url(nokri_page_lang_url_callback($link));
                    ?>
                    <li class="tool-tip" title="<?php echo esc_html__('Edit Job', 'nokri'); ?>"> <a href="<?php echo '' . $final_url; ?>" class="label label-info"> <i class="ti-pencil-alt"></i></a></li>
                <?php } ?>
                <li class="tool-tip" title="<?php echo esc_html__('Delete Job', 'nokri'); ?>"><a data-value="<?php echo esc_attr($job_id); ?>" class="label label-danger del_my_job"> <i class="ti-trash"></i></a></li>
                <?php if ($job_status == 'active' && $take_action == true) { ?>
                    <li class="tool-tip" title="<?php echo esc_html__('Make inactive', 'nokri'); ?>"><a  id="inactive"  class="label label-warning inactive_job" data-value="<?php echo esc_attr($job_id); ?>"> <i class="ti-alert"></i></a></li>
                <?php } else if ($take_action == true) { ?>
                    <li class="tool-tip" title="<?php echo esc_html__('Make active', 'nokri'); ?>"><a  id="active"  class="label label-success inactive_job" data-value="<?php echo esc_attr($job_id); ?>"> <i class="ti-alert"></i></a></li>
                    <?php
                }
                if ($is_show_bump_up && $job_status == 'active') {
                    $emp_single_job_stats
                    ?>
                    <li class="tool-tip" title="<?php echo esc_html__('Bump Up', 'nokri'); ?>"><a  id="bump_this_job"  class="label label-success bump_this_job" data-value="<?php echo esc_attr($job_id); ?>"> <i class="ti-arrow-up"></i></a></li>
                    <?php
                }
                if ($emp_single_job_stats && $job_status == 'active') {

                    /* Function to get appliers count for graphs Data against single avtive job */
                    $resume_count = nokri_single_active_job_applier_count($job_id);

                    /* Function to get applied Dates for graphs Data against a single active job */
                    $applied_date = nokri_active_jobs_appliers_date($job_id);

                    $received_resume = esc_html__('Resume Receiving Date', 'nokri');
                    $total_resume = esc_html__('Total Resume', 'nokri');
                    $post_title = get_the_title($job_id);
                    ?>
                    <li class="tool-tip" title="<?php echo esc_html__('Statistics', 'nokri'); ?>">
                        <a data-toggle="modal" data-class= "track-resume" data-value="<?php echo esc_attr($post_title); ?>" 
                           data-resume-count="<?php echo esc_attr($resume_count); ?>"
                           data-resume-date='<?php echo esc_attr($applied_date); ?>'
                           data-resume-date-string="<?php echo esc_attr($received_resume); ?>"
                           data-resume-total-string="<?php echo esc_attr($total_resume); ?>"
                           class="label label-danger emp_stats_job"> <i class="ti-bar-chart"></i></a></li>
                        <?php } ?>
            </ul>
        </li>
    </ul>
</div>