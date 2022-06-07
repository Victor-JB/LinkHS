<?php
global $nokri;
$user_id = get_current_user_id();
/* Package Page */
$package_page = '';
if ((isset($nokri['package_page'])) && $nokri['package_page'] != '') {
    $package_page = ($nokri['package_page']);
}


/* Getting expire package informations */
$is_pkg_exired = nokri_employer_package_expire_notify();



if ($is_pkg_exired == 're') {
    $pkg_message = esc_html__('Your regular jobs has been expired.', 'nokri');
} else if ($is_pkg_exired == 'pe') {
    $pkg_message = esc_html__('Your package has been expired.', 'nokri');
} else {
    $pkg_message = esc_html__('No package purchased yet', 'nokri');
}
?>

<div class="main-body">
    <div class="dashboard-job-stats my-package-detail">
        <h4><?php echo esc_html__('Package detail', 'nokri'); ?></h4>
        <div class="dashboard-posted-jobs">
            <div class="posted-job-list header-title">
                <ul class="list-inline">
                    <li class="package-id"><?php echo esc_html__('#', 'nokri'); ?></li>
                    <li class="package-title"><?php echo esc_html__('Title', 'nokri'); ?> </li>
                    <li class="package-action"><?php echo esc_html__('Package Details', 'nokri'); ?> </li>
                </ul>
            </div>
            <?php
            /* Employer Purchase Any Package */
            if ($is_pkg_exired != 're' && $is_pkg_exired != 'pe' && $is_pkg_exired != 'np') {
                /* Getting Employer Packages Details */
                $class_terms = get_terms('job_class', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
                if (count($class_terms) > 0) {
                    $class = $package_html = '';
                    $jobs = __(" Jobs", 'nokri');
                    $count = '1';
                    foreach ($class_terms as $class_term) {
                        $meta_name = 'package_job_class_' . $class_term->term_id;
                        $class = get_user_meta($user_id, $meta_name, true);
                        if ($class == '') {
                            $class = __("N/A", 'nokri');
                        }
                        if ($class == '-1') {
                            $class = esc_html__('Unlimited', 'nokri');
                        }
                        $package_html .= '<div class="posted-job-list">
									<ul class="list-inline">
										<li class="package-id">' . esc_attr($count) . '</li>
										<li class="package-title">' . esc_html(ucfirst($class_term->name)) . esc_attr($jobs) . '</li>
										<li class="package-action">' . esc_attr($class) . '</li>
									</ul>
								</div>';
                        $count++;
                    }
                }
                /* Displaying Remaining  Days Of Package */
                $days = __(" Days", 'nokri');
                $package_date = get_user_meta($user_id, '_sb_expire_ads', true);
                if ($package_date == '-1') {
                    $package_date = esc_html__('Unlimited', 'nokri');
                } else {
                    $package_date = date_i18n(get_option('date_format'), strtotime($package_date));
                }
                /* Displaying Remaining  Days Of Bump up adds */
                if ((isset($nokri['allow_bump_jobs'])) && $nokri['allow_bump_jobs']) {

                    $bump_ads_limit = get_user_meta($user_id, 'bump_ads_limit', true);
                    if ($bump_ads_limit == '-1') {
                        $bump_ads_limit = esc_html__('Unlimited', 'nokri');
                    }
                }

                $emp_feature_profile = get_user_meta($user_id, '_emp_feature_profile', true);

                if ($emp_feature_profile == '-1') {
                    $emp_feature_profile = esc_html__('Unlimited', 'nokri');
                } else if ($emp_feature_profile != "") {

                    $emp_feature_profile = date_i18n(get_option('date_format'), strtotime($emp_feature_profile));
                }
                ?>
                <div class="posted-job-list">
                    <ul class="list-inline">
                        <li class="package-title"><?php echo esc_html__('Package Expiry', 'nokri'); ?></li>
                        <li class="package-action"><?php echo '' . $package_date; ?></li>
                    </ul>
                    <?php if ((isset($nokri['allow_bump_jobs'])) && $nokri['allow_bump_jobs']) { ?>
                        <ul class="list-inline cand-resumes-access">
                            <li class="package-title"><?php echo esc_html__('Bump up Jobs', 'nokri'); ?></li>
                            <li class="package-action"><?php echo esc_html($bump_ads_limit); ?></li>
                        </ul>                    
                    <?php } ?>
                    <ul class="list-inline cand-resumes-access">
                        <li class="package-title"><?php echo esc_html__('Featured profile', 'nokri'); ?></li>
                        <li class="package-action"><?php echo esc_html($emp_feature_profile); ?></li>
                    </ul> 
                    <?php
                    if (get_user_meta($user_id, '_sb_cand_search_value', true) != '') {
                        $rem_searches = get_user_meta($user_id, '_sb_cand_search_value', true);
                        if (get_user_meta($user_id, '_sb_cand_search_value', true) == '-1') {
                            $rem_searches = esc_html__('Unlimited', 'nokri');
                        }
                        ?>
                        <ul class="list-inline cand-resumes-access">
                            <li class="package-title"><?php echo esc_html__('Candidate Profile views', 'nokri'); ?></li>
                            <li class="package-action"><?php echo '' . ($rem_searches) . " " . esc_html__('Remainings', 'nokri'); ?></li>
                        </ul>
                    <?php } ?>
                </div>
                <?php
                echo '' . ($package_html);
            } else if ($is_pkg_exired = 're' && get_user_meta($user_id, '_sb_cand_search_value', true) != '') {

                $class_terms = get_terms('job_class', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
                if (count($class_terms) > 0) {
                    $class = $package_html = '';
                    $jobs = __(" Jobs", 'nokri');
                    $count = '1';
                    foreach ($class_terms as $class_term) {
                        $meta_name = 'package_job_class_' . $class_term->term_id;
                        $class = get_user_meta($user_id, $meta_name, true);
                        if ($class == '') {
                            $class = __("N/A", 'nokri');
                        }
                        if ($class == '-1') {
                            $class = esc_html__('Unlimited', 'nokri');
                        }

                        $package_html .= '<div class="posted-job-list">
									<ul class="list-inline">
										<li class="package-id">' . esc_attr($count) . '</li>
										<li class="package-title">' . esc_html(ucfirst($class_term->name)) . esc_attr($jobs) . '</li>
										<li class="package-action">' . esc_attr($class) . '</li>
									</ul>
								</div>';
                        $count++;
                    }
                }
                /* Displaying Remaining  Days Of Package */
                $days = __(" Days", 'nokri');
                $package_date = get_user_meta($user_id, '_sb_expire_ads', true);
                if ($package_date == '-1') {
                    $package_date = esc_html__('Unlimited', 'nokri');
                } else {
                    $package_date = date_i18n(get_option('date_format'), strtotime($package_date));
                }
                ?>
                <div class="posted-job-list">
                    <ul class="list-inline">
                        <li class="package-title"><?php echo esc_html__('Package Expiry', 'nokri'); ?></li>
                        <li class="package-action"><?php echo '' . $package_date; ?></li>
                    </ul>
                    <?php
                    if (get_user_meta($user_id, '_sb_cand_search_value', true) != '') {
                        $rem_searches = get_user_meta($user_id, '_sb_cand_search_value', true);
                        if (get_user_meta($user_id, '_sb_cand_search_value', true) == '-1') {
                            $rem_searches = esc_html__('Unlimited', 'nokri');
                        }
                        ?>
                        <ul class="list-inline cand-resumes-access">
                            <li class="package-title"><?php echo esc_html__('Resume Views', 'nokri'); ?></li>
                            <li class="package-action"><?php echo '' . ($rem_searches) . " " . esc_html__('Remainings', 'nokri'); ?></li>
                        </ul>
                    <?php } ?>
                </div>
                <?php
                echo '' . ($package_html);
            } else {
                ?>
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