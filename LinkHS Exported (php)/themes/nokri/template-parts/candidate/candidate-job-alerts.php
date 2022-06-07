<?php
global $nokri;
$current_id = get_current_user_id();
?>
<div class="main-body">
    <div class="dashboard-job-stats followers">
        <h4><?php echo esc_html__('My Job Alerts', 'nokri'); ?></h4>
        <div class="dashboard-posted-jobs">
            <div class="posted-job-list resume-on-jobs header-title">
                <ul class="list-inline">
                    <li class="resume-id"><?php echo esc_html__('#', 'nokri'); ?></li>
                    <li class="posted-job-title"><?php echo esc_html__('Alert Name', 'nokri'); ?></li>
                    <li class="posted-job-expiration"><?php echo esc_html__('Category', 'nokri'); ?></li>
                    <li class="posted-job-action"><?php echo esc_html__('Action', 'nokri'); ?></li>
                </ul>
            </div>
            <div class="cp-loader"></div>
            <?php
            $job_alert = nokri_get_candidates_job_alerts($current_id);
            if (isset($job_alert) && !empty($job_alert)) {
                $count = 1;
                $is_paid = isset($nokri['job_alert_paid_switch']) ? $nokri['job_alert_paid_switch'] : false;
                $expire_class = "";
                foreach ($job_alert as $key => $val) {

                    if ($is_paid) {
                        $current_date = strtotime(date('Y/m/d'));
                        $end_date = strtotime($val['alert_end']);
                        $expire_class = $current_date > $end_date ? 'expire_alert' : "";
                    }
                    $terms = get_term_by('id', $val['alert_category'], 'job_category');
                    $term_name = $terms->name;
                    $freq = isset($val['alert_frequency']) ? $val['alert_frequency'] : "";
                    ?>
                    <div class="posted-job-list resume-on-jobs" id="alert-box-<?php echo esc_attr($key); ?>">
                        <ul class="list-inline">
                            <li class="resume-id"><?php echo esc_attr($count); ?></li>
                            <li class="posted-job-title">
                                <div class="posted-job-title-meta    <?php echo esc_attr($expire_class) ?>">
                                    <?php echo esc_html($val['alert_name']); ?>
                                    <p><?php
                                        if ($freq != "") {
                                            echo esc_html(nokri_get_candidates_job_alerts_freq($freq));
                                        }
                                        ?></p>
                                </div>
                            </li>
                            <li class="posted-job-expiration"><?php echo esc_html($term_name); ?></li>
                            <li class="posted-job-action"> 
                                <a  data-value="<?php echo esc_attr($key); ?>" class="btn btn-custom del_save_alert" ><?php echo esc_html__('Delete', 'nokri'); ?></a>
                            </li>
                        </ul>
                    </div>
                    <?php
                    $count++;
                }
                ?>
            </div>
        </div>
    </div>
    <?php
} else {
    $job_alerts = ( isset($nokri['job_alerts_switch']) && $nokri['job_alerts_switch'] != "" ) ? $nokri['job_alerts_switch'] : false;
    if ($job_alerts) {
        ?>
        <div class="dashboard-posted-jobs">
            <div class="notification-box">
                <div class="notification-box-icon"><span class="ti-info-alt"></span></div>             
                <a href="javascript:void(0)" class="btn n-btn-flat job_alert"><?php echo esc_html__('Subscribe Now', 'nokri'); ?> </a>
            </div>
        </div>
        <?php
    }
}
?>
