<?php
$user_id = get_current_user_id();
/* Getting Company Published Jobs */
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'job_post',
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => $paged,
    'author' => $user_id,
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
}
global $wpdb;
$query1 = "SELECT * FROM $wpdb->postmeta WHERE post_id IN ($job_ids) AND meta_key like '_job_applied_resume_%' ORDER BY meta_id DESC";
$applier_resumes = $wpdb->get_results($query1);
$noti_html = '';
if (isset($applier_resumes) && count($applier_resumes) > 0) {
    foreach ($applier_resumes as $resumes) {
        $array_data = explode('|', $resumes->meta_value);
        $applier = $array_data[0];
        $user = get_user_by('id', $applier);
        $apply_date = get_post_meta($resumes->post_id, '_job_applied_date_' . $applier, true);
        $apply_date = date_i18n(get_option('date_format'), strtotime($apply_date));
        /* Is user exist */
        $user_exist = get_userdata($applier);
        if ($user_exist) {
            $user_display_name = $user->display_name;
        } else {
            $user_display_name = '';
        }

        $noti_html .= ' <li>
                    <div class="notif-single">
                    <a href="' . get_author_posts_url($applier) . '">' . $user_display_name . '</a>' . " " . esc_html__('Applied To', 'nokri') . ' <a href="' . get_the_permalink($resumes->post_id) . '" class="notif-job-title">' . " " . get_the_title($resumes->post_id) . '</a>
		</div>
		<span class="notif-timing"><i class="icon-clock"></i> ' . $apply_date . '</span>
		</li>';
    }
}

/* Display Jobs Alert Subscribers List */
if (current_user_can('editor') || current_user_can('administrator')) {

    /* Getting Candidate Jobs Alert subscribers */
    $cand_ids = nokri_get_candidate_alerts_list();
    if (!empty($cand_ids)) {
        foreach ($cand_ids as $key => $candidate_id) {
            $user_id = $candidate_id->ID;
            $job_alert = nokri_get_candidates_job_alerts($user_id);
            $user_exist = get_userdata($user_id);
            $noti_html_alert = '';
            foreach ($job_alert as $key => $candidate_alert) {
                if ($user_exist) {
                    $user_display_name = $user_exist->display_name;
                } else {
                    $user_display_name = '';
                }
                //$user_name = isset($candidate_alert['alert_name']) ? $candidate_alert['alert_name'] : '';
                $user_email = isset($candidate_alert['alert_email']) ? $candidate_alert['alert_email'] : '';
                $user_alert_date = isset($candidate_alert['alert_start']) ? $candidate_alert['alert_start'] : '';
                $user_alert_cat = isset($candidate_alert['alert_category']) ? $candidate_alert['alert_category'] : '';
                $job_alert_date = date_i18n(get_option('date_format'), strtotime($user_alert_date));
                $term_name = get_term($user_alert_cat)->name;
                $noti_html_alert .= ' <li>
                    <div class="notif-single">
                    <a href="' . get_author_posts_url($user_id) . '">' . $user_display_name . '</a>' . " " . esc_html__('have activate Job Alerts on', 'nokri') . ' <a href="' . get_the_permalink($user_alert_cat) . '" class="notif-job-title">' . " " . $term_name . '</a>
		</div>
		<span class="notif-timing"><i class="icon-clock"></i> ' . $job_alert_date . '</span>
		</li>';
            }
        }
    }
    $noti_html_alert = $noti_html_alert;
} else {
    $noti_html_alert = '';
}
?>
<div class="cp-loader"></div>
<div class="main-body">
    <?php if (isset($applier_resumes) && count($applier_resumes) > 0) { ?>
        <div class="notification-area">
            <h4> <?php echo esc_html__('All Notifications', 'nokri'); ?></h4>
            <div class="notif-box">
                <ul>
                    <?php echo '' . ($noti_html) . '' . ($noti_html_alert); ?>
                    <li>
                    </li>
                </ul>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-info alert-dismissable alert-style-1">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="ti-info-alt"></i><?php echo esc_html__('No Notifications', 'nokri'); ?>
        </div>
    <?php } ?>
    <div class="pagination-box clearfix">
        <?php echo nokri_job_pagination($query); ?>
    </div>
</div>