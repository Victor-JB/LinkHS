<?php
/* Employer Dashboard */
global $nokri;

$employer_id = nokri_account_member_id_as_employer();
/* Checking if Employer give access to member for Jobs Dashboard */
$crnt_userID = get_current_user_id();
$membersPermiss = get_user_meta($crnt_userID, 'member_permissions', true);
$member_id = get_user_meta($crnt_userID, '_sb_is_member', true);
if (isset($membersPermiss['emp_dashboard']) && $membersPermiss['emp_dashboard'] != '') {
    $user_id = $employer_id;
} else {
    $user_id = $crnt_userID;
}
$post_found = '';
$args = array(
    'post_type' => 'job_post',
    'orderby' => 'date',
    'order' => 'DESC',
    'author' => $user_id,
    'post_status' => array('publish'),
    'meta_query' => array(
        array(
            'key' => '_job_status',
            'value' => 'active',
            'compare' => '='
        )
    )
);
$args = nokri_wpml_show_all_posts_callback($args);
$query = new WP_Query($args);
$job_html = '';
if ($query->have_posts()) {
    $post_found = $query->found_posts;
    while ($query->have_posts()) {
        $query->the_post();
        $job_id = get_the_ID();
        $resume_counts = nokri_get_resume_count($job_id);
        $post_status = get_post_status($job_id);
        $class = 'warning';
        if ($post_status == 'publish') {
            $post_status = esc_html__('Publish', 'nokri');
            $class = 'success';
        }
        // check for plugin post-views-counter
        $job_views = '';
        if (class_exists('Post_Views_Counter')) {
            $job_views = pvc_post_views($post_id = $job_id, '');
        }
        $job_html .= '<tr>
			<td><a href="' . get_the_permalink() . '">' . get_the_title($job_id) . '</a></td>
			<td><span class="label label-' . esc_attr($class) . '">' . $post_status . '</span></td>
			<td>' . $resume_counts . '</td>
			<td>' . $job_views . '</td>
                    </tr>';
    }
    wp_reset_postdata();
}
?>
<div class="main-body dashbord-height-fix">
    <?php
    $memberID = get_user_meta($crnt_userID, '_sb_is_member', true);
    if (isset($memberID) && $memberID != '') {
        if (isset($membersPermiss['emp_dashboard']) && $membersPermiss['emp_dashboard'] != '') {
            if (isset($membersPermiss['manag_jobs']) && $membersPermiss['manag_jobs'] != '') {
                ?>
                <div class="dashboard-stats">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12">
                            <div class="stat-box parallex">
                                <div class="stat-box-meta">
                                    <div class="stat-box-meta-text">
                                        <h4><?php echo esc_html__('Published Jobs', 'nokri'); ?></h4>
                                        <h3><?php echo '' . $post_found != '' ? $post_found : 0; ?></h3>
                                    </div>
                                    <div class="stat-box-meta-icon">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/job1.png" class="img-responsive" alt="<?php echo esc_attr__('image', 'nokri'); ?>">
                                    </div>
                                </div>
                                <p><a href="<?php echo get_the_permalink(); ?>?tab-data=active-jobs"><?php echo esc_html__('View All Published Jobs', 'nokri'); ?></a></p>
                            </div>
                        </div>                   
                        <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12">
                            <div class="stat-box blue">
                                <div class="stat-box-meta">
                                    <div class="stat-box-meta-text">
                                        <h4><?php echo esc_html__('Pending Jobs', 'nokri'); ?></h4>
                                        <h3><?php echo nokri_get_jobs_count($user_id, 'pending'); ?></h3>
                                    </div>
                                    <div class="stat-box-meta-icon">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/warning.png" class="img-responsive" alt="published jobs">
                                    </div>
                                </div>
                                <p><a href="<?php echo get_the_permalink(); ?>?tab-data=pending-jobs"><?php echo esc_html__('View All Pending Jobs', 'nokri'); ?></a></p>
                            </div>
                        </div>
                    </div>      
                </div>
                <?php
            }
        }
    } else if (isset($membersPermiss['emp_dashboard']) && $membersPermiss['emp_dashboard'] == '') {
        ?>
        <div class="dashboard-stats">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12">
                    <div class="stat-box parallex">
                        <div class="stat-box-meta">
                            <div class="stat-box-meta-text">
                                <h4><?php echo esc_html__('Published Jobs', 'nokri'); ?></h4>
                                <h3><?php echo '' . $post_found != '' ? $post_found : 0; ?></h3>
                            </div>
                            <div class="stat-box-meta-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/icons/job1.png" class="img-responsive" alt="<?php echo esc_attr__('image', 'nokri'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12">
                    <div class="stat-box blue">
                        <div class="stat-box-meta">
                            <div class="stat-box-meta-text">
                                <h4><?php echo esc_html__('Pending Jobs', 'nokri'); ?></h4>
                                <h3><?php echo nokri_get_jobs_count($user_id, 'pending'); ?></h3>
                            </div>
                            <div class="stat-box-meta-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/icons/warning.png" class="img-responsive" alt="published jobs">
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
        </div>
        <?php
    } else {
        ?>
        <div class="dashboard-stats">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12">
                    <div class="stat-box parallex">
                        <div class="stat-box-meta">
                            <div class="stat-box-meta-text">
                                <h4><?php echo esc_html__('Published Jobs', 'nokri'); ?></h4>
                                <h3><?php echo '' . $post_found != '' ? $post_found : 0; ?></h3>
                            </div>
                            <div class="stat-box-meta-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/icons/job1.png" class="img-responsive" alt="<?php echo esc_attr__('image', 'nokri'); ?>">
                            </div>
                        </div>
                        <p><a href="<?php echo get_the_permalink(); ?>?tab-data=active-jobs"><?php echo esc_html__('View All Published Jobs', 'nokri'); ?></a></p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-6 col-xs-12">
                    <div class="stat-box blue">
                        <div class="stat-box-meta">
                            <div class="stat-box-meta-text">
                                <h4><?php echo esc_html__('Pending Jobs', 'nokri'); ?></h4>
                                <h3><?php echo nokri_get_jobs_count($user_id, 'pending'); ?></h3>
                            </div>
                            <div class="stat-box-meta-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/icons/warning.png" class="img-responsive" alt="published jobs">
                            </div>
                        </div>
                        <p><a href="<?php echo get_the_permalink(); ?>?tab-data=pending-jobs"><?php echo esc_html__('View All Pending Jobs', 'nokri'); ?></a></p>
                    </div>
                </div>
            </div>     
        </div>
        <!--Getting all Statistics Data-->
        <?php
        $user_post_count = count_user_posts($crnt_userID, 'job_post');
        $no_of_employers = get_user_meta($crnt_userID, '_emp_nos', true);
        $saved_resumes_count = nokri_get_total_saved_resume_count($crnt_userID);
        $emp_followers = nokri_count_emp_followers($crnt_userID);
        $inactive_jobs = nokri_inactive_jobs_count($crnt_userID);
        $pending_jobs = nokri_pending_jobs_count($crnt_userID);

        $is_mem_allowed = ( isset($nokri['emp_account_members']) && $nokri['emp_account_members'] != "" ) ? $nokri['emp_account_members'] : false;
        $acc_members = '';
        if ($is_mem_allowed) {
            $account_members = get_user_meta($crnt_userID, 'account_members', true);
            if (isset($account_members) && $account_members != '') {
                $acc_members = count($account_members);
            }
        }
        /* Job Post Statistics */
        global $wpdb;
        $query_jobs = "select concat(year(`post_date`), '-', month(`post_date`)) as `month`, count(1) as `cnt` 
               from `$wpdb->posts` where (post_type='job_post') and `post_author` = $user_id 
                group by `month` order by `post_date` desc LIMIT 12";  // change this to include more months. the default is 12 months in the past.
        $result = array_reverse($wpdb->get_results($query_jobs));

        // reverse the data to get a normal logic flow
        $labels = "";
        $data = "";
        $labels_1 = array();
        if (isset($result) && $result) {
            foreach ($result as $key => $month) {

                $labels .= '' . $month->month . ', ';
                $data .= $month->cnt . ',';
            }
        } else {
            for ($i = 6; $i >= 1; $i--) {
                $months[] = date("Y-m%", strtotime(date('Y-m-01') . " -$i months"));
                $labels .= '"' . date("Y-m", strtotime(date('Y-m-01') . " -$i months")) . '", ';
                $data .= 0 . ",";
            }
        }
        /* Jobs Graph access */
        $is_allowed = isset($nokri['nokri_jobs_graph_switch']) ? $nokri['nokri_jobs_graph_switch'] : true;
        if ($is_allowed) {
            ?>
            <input type="hidden" id="job_labels" value="<?php echo esc_attr($labels); ?>" />
            <input type="hidden" id="job_data" value="<?php echo esc_attr($data); ?>" />
            <div class="container" id="chartcontainer">
                <canvas id="myChart" style="position: relative; margin-bottom: 8%; height:50vh; width:60vw"></canvas>
            </div>
            <?php
        }
        /* Query For Getting All Resumes Against Job */
        $is_accessed = isset($nokri['nokri_resume_graph_switch']) ? $nokri['nokri_resume_graph_switch'] : false;
        if ($is_accessed) {
            $job_ids = nokri_admin_resume_counter($crnt_userID);
            $resume_query = "SELECT count(meta_id) as resume_count,post_id, meta_value as applied_date "
                    . "FROM $wpdb->postmeta WHERE post_id IN ($job_ids) AND meta_key like '_job_applied_date_%' "
                    . "GROUP BY meta_value ORDER BY meta_id DESC LIMIT 15";
            $applier_resumes = array_reverse($wpdb->get_results($resume_query));

            $resume_labels = array();
            $resume_data = "";
            $applied_date = array();
            if (isset($applier_resumes) && $applier_resumes != '') {
                foreach ($applier_resumes as $resume_details) {

                    $resume_labels[] .= '' . $resume_details->applied_date . ' ';
                    $resume_data .= $resume_details->resume_count . ',';
                }
            }
            $resume_labels_data = json_encode($resume_labels);
            /* Resume Graph access */
            ?>
            <input type="hidden" id="resume_labels" value="<?php echo esc_attr($resume_labels_data); ?>" />
            <input type="hidden" id="resume_data" value="<?php echo esc_attr($resume_data); ?>" />
            <div class="container" id="chartcontainer">
                <canvas id="myChartAdmin" style="position: relative; margin-bottom: 8%; height:50vh; width:60vw"></canvas>
            </div>
            <?php
        }
    }
    ?>
    <?php
    $is_allowed_counter = isset($nokri['emp_counter_switch_']) ? $nokri['emp_counter_switch_'] : false;
    if ($is_allowed_counter) {
        ?>
        <h4><?php echo esc_html__('Activities Data', 'nokri'); ?></h4>
        <!--Dashboard Counter for Total Values-->
        <div class="custom_counter table-responsive dashboard-job-stats-table">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="counter">
                    <i class="fa fa-bullhorn fa-2x"></i>
                    <h2 class="timer count-title count-number" data-to="<?php echo esc_attr($post_found != '' ? $post_found : 0); ?>" data-speed="1500"></h2>
                    <h5><p class="count-text "><a href="<?php echo get_the_permalink(); ?>?tab-data=active-jobs"><?php echo esc_html__('Published Jobs', 'nokri'); ?></a></p></h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="counter">
                    <i class="fa fa-exclamation-triangle fa-2x"></i>
                    <h2 class="timer count-title count-number" data-to="<?php echo esc_attr($pending_jobs != '' ? $pending_jobs : 0); ?>" data-speed="1500"></h2>
                    <h5><p class="count-text "><a href="<?php echo get_the_permalink(); ?>?tab-data=pending-jobs"><?php echo esc_html__('Pending Jobs', 'nokri'); ?></a></p></h5>              
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="counter">
                    <i class="fa fa-bookmark-o fa-2x"></i>
                    <h2 class="timer count-title count-number" data-to="<?php echo esc_attr($saved_resumes_count != '' ? $saved_resumes_count : 0); ?>" data-speed="1500"></h2>
                    <h5><p class="count-text "><a href="<?php echo get_the_permalink(); ?>?tab-data=saved-resumes"><?php echo esc_html__('Saved Resumes', 'nokri'); ?></a></p></h5>
                </div></div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="counter">
                    <i class="fa fa-bell-o fa-2x"></i>
                    <h2 class="timer count-title count-number" data-to="<?php echo esc_attr($emp_followers != '' ? $emp_followers : 0); ?>" data-speed="1500"></h2>
                    <h5><p class="count-text "><a href="<?php echo get_the_permalink(); ?>?tab-data=our-followers"><?php echo esc_html__('Followers', 'nokri'); ?></a></p></h5>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="dashboard-job-stats">
        <h4><?php echo esc_html__('Recent Jobs Overview', 'nokri'); ?></h4>
        <div class="table-responsive dashboard-job-stats-table">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Job Title', 'nokri'); ?></th>
                        <th scope="row"><?php echo esc_html__('Status', 'nokri'); ?></th>
                        <th scope="row"><?php echo esc_html__('Resume', 'nokri'); ?></th>
                        <th scope="row"><?php echo esc_html__('Views', 'nokri'); ?></th>
                    </tr>
                    <?php echo "" . $job_html; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>