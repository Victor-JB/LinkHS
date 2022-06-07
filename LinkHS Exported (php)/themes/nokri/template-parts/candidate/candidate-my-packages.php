<?php
global $nokri;
$user_id = get_current_user_id();
/* Package Page */
$package_page = '';
if ((isset($nokri['cand_package_page'])) && $nokri['cand_package_page'] != '') {
    $package_page = ($nokri['cand_package_page']);
}
/* Getting expire package informations */
$is_pkg_exired = nokri_candidate_package_expire_notify();
if ($is_pkg_exired == 're') {
    $pkg_message = esc_html__('Your number of jobs has been expired', 'nokri');
} else if ($is_pkg_exired == 'pe') {
    $pkg_message = esc_html__('Your package has been expired. Please renew package', 'nokri');
} else {
    $pkg_message = esc_html__('No packages purchased yet', 'nokri');
}
?>
<div class="main-body">
    <div class="dashboard-job-stats my-package-detail">
        <h4><?php echo esc_html__('Package detail', 'nokri'); ?></h4>
        <div class="dashboard-posted-jobs">
            <?php
            $no_of_jobs = get_user_meta($user_id, '_candidate_applied_jobs', true);

            if ($no_of_jobs == '-1') {
                $no_of_jobs = __("Unlimited", 'nokri');
            }
            /* Employer Purchase Any Package */
            if ($is_pkg_exired != 're' && $is_pkg_exired != 'pe' && $is_pkg_exired != 'np') {
                /* Displaying Remaining  Days Of Package */
                $days = __(" Days", 'nokri');
                $package_date = get_user_meta($user_id, '_sb_expire_ads', true);
                if ($package_date == '-1') {
                    $package_date = __(" Unlimited", 'nokri');
                } else {
                    $package_date = date_i18n(get_option('date_format'), strtotime($package_date));
                }
                $featured_prof = get_user_meta($user_id, '_candidate_feature_profile', true);
                if ($featured_prof == '-1') {
                    $featured_prof = __(" Unlimited", 'nokri');
                } else {
                    $featured_prof = date_i18n(get_option('date_format'), strtotime($featured_prof));
                }
                ?>
                <div class="posted-job-list header-title">
                    <ul class="list-inline">
                        <li class="package-title"><?php echo esc_html__('Title', 'nokri'); ?></li>
                        <li class="package-action"><?php echo esc_html__('Description', 'nokri'); ?></li>
                    </ul>
                </div>
                <div class="posted-job-list">
                    <ul class="list-inline">
                        <li class="package-title"><?php echo esc_html__('Package Expiry', 'nokri'); ?></li>
                        <li class="package-action"><?php echo '' . $package_date; ?></li>
                    </ul>
                </div>
                <div class="posted-job-list">
                    <ul class="list-inline">
                        <li class="package-title"><?php echo esc_html__('Featured Profile Expiry', 'nokri'); ?></li>
                        <li class="package-action"><?php echo '' . $featured_prof; ?></li>
                    </ul>
                </div>
                <div class="posted-job-list">
                    <ul class="list-inline">
                        <li class="package-title"><?php echo esc_html__('Jobs To Apply', 'nokri'); ?></li>
                        <li class="package-action"><?php echo esc_html($no_of_jobs); ?></li>
                    </ul>
                </div>
            <?php } else { ?>
                <div class="dashboard-posted-jobs">
                    <div class="notification-box">
                        <div class="notification-box-icon"><span class="ti-info-alt"></span></div>
                        <h3><?php echo esc_html($pkg_message); ?></h3>
                        <a href="<?php echo get_the_permalink($package_page); ?>" class="btn n-btn-flat"><?php echo esc_html__('Purchase now', 'nokri'); ?> </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>