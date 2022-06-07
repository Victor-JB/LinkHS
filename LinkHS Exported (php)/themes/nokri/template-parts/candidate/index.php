<?php
/* Template Name: Candidate Resume */
global $nokri;
$cand_skills = $skill_tags = $portfolio_html = '';
$user_crnt_id = get_current_user_id();
/* Getting Candidate Portfolio */
if (get_user_meta($user_crnt_id, '_cand_portfolio', true) != "") {
    $port = get_user_meta($user_crnt_id, '_cand_portfolio', true);
    $portfolios = explode(',', $port);
    if ((array) $portfolios && count($portfolios) > 0) {
        foreach ($portfolios as $portfolio) {
            $portfolio_image_sm = wp_get_attachment_image_src($portfolio, 'nokri_job_hundred');
            $portfolio_image_lg = wp_get_attachment_image_src($portfolio, 'nokri_cand_large');

            $portfolio_html .= '<li><a class="portfolio-gallery" data-fancybox="gallery" href="' . esc_url($portfolio_image_lg[0]) . '"><img src="' . esc_url($portfolio_image_sm[0]) . '"></a></li>';
        }
    }
}
/* Getting Count Apllied Jobs */
$args = array(
    'post_type' => 'job_post',
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => array('publish'),
    'meta_query' => array(
        'relation' => 'AND',
        array('key' => '_job_applied_resume_' . $user_crnt_id),
        array(
            'key' => '_job_status',
            'value' => 'active',
            'compare' => '='
        ),
    ),
);
$query = new WP_Query($args);
$applied_jobs = $query->found_posts;
/* Getting Followed Companies Count  */
$get_result = nokri_following_company_ids($user_crnt_id);
$follow_comp = count((array) $get_result);
/* Getting User Skills Tags */
$cand_skills = get_user_meta($user_crnt_id, '_cand_skills', true);
if ($cand_skills != '') {
    $taxonomies = get_terms('job_skills', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC', 'parent' => 0));
    if (count($taxonomies) > 0) {
        foreach ($taxonomies as $taxonomy) {
            if (in_array($taxonomy->term_id, $cand_skills))
                $skill_tags .= '<a href="javascript:void(0)">' . esc_html($taxonomy->name) . '</a>';
        }
    }
}
$intro = get_user_meta($user_crnt_id, '_cand_intro', true);
$cand_video = get_user_meta($user_crnt_id, '_cand_video', true);
/* Low profile txt */
$profile_percent = get_user_meta($user_crnt_id, '_cand_profile_percent', true);
$user_low_profile_txt = ( isset($nokri['user_low_profile_txt']) && $nokri['user_low_profile_txt'] != "" ) ? $nokri['user_low_profile_txt'] : "";
?>
<div class="main-body n-candidate-detail">
    <div class="dashboard-stats">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="stat-box parallex">
                    <div class="stat-box-meta">
                        <div class="stat-box-meta-text">
                            <h4><?php echo esc_html__('Applied jobs', 'nokri'); ?></h4>
                            <h3><?php echo esc_html($applied_jobs); ?></h3>
                        </div>
                        <div class="stat-box-meta-icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/icons/applied-jobs.png" class="img-responsive" alt="<?php echo esc_html__('applied jobs', 'nokri'); ?>">
                        </div>
                    </div>
                    <p><a href="<?php echo get_the_permalink(); ?>?candidate-page=jobs-applied"><?php echo esc_html__('View all applied jobs', 'nokri'); ?></a></p>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="stat-box blue">
                    <div class="stat-box-meta">
                        <div class="stat-box-meta-text">
                            <h4><?php echo esc_html__('Followed companies', 'nokri'); ?></h4>
                            <h3><?php echo esc_html($follow_comp); ?></h3>
                        </div>
                        <div class="stat-box-meta-icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/icons/followers.png" class="img-responsive" alt="<?php echo esc_html__('followed companies', 'nokri'); ?>">
                        </div>
                    </div>
                    <p><a href="<?php echo get_the_permalink(); ?>?candidate-page=followed-companies"><?php echo esc_html__('View all followed companies', 'nokri'); ?></a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Getting User Data -->
    <?php
    //getting User Saved Resumes
    $is_allowed = isset($nokri['cand_graph_chart_btn']) ? $nokri['cand_graph_chart_btn'] : false;

    $user_resume = get_user_meta($user_crnt_id, '_cand_resume', true);
    if ($user_resume != "") {
        $all_resumes = explode(',', $user_resume);
        $no_of_save_resume = count($all_resumes);
    }
    $saved_jobs = nokri_get_cand_save_jobs_count($user_crnt_id);
    //getting User Saved Resumes
    $jobs_query = nokri_cand_jobs_stats($user_crnt_id);
    $post_ids = wp_list_pluck($jobs_query->posts, 'ID');
    $post_ids_string = implode(',', $post_ids);

    if ($post_ids_string == '') {
        $post_ids_string = 0;
    }
    global $wpdb;
    $meta_key = '_job_applied_date_' . $user_crnt_id;
    $current_date = date('F j, Y', time());
    $last_date = date('F j, Y', strtotime("-15 day"));

    $resume_query = "SELECT count(meta_id) as resume_count,post_id, meta_value as applied_date
                    FROM $wpdb->postmeta WHERE post_id IN ($post_ids_string)
                    AND meta_key like '$meta_key' GROUP BY meta_value ORDER BY meta_id DESC LIMIT 15";
    $applier_resumes = array_reverse($wpdb->get_results($resume_query));

    $resume_labels = "";
    $resume_data = "";

    if (isset($applier_resumes) && $applier_resumes != '') {
        foreach ($applier_resumes as $resume_details) {

            $resume_labels .= '"' . $resume_details->applied_date . '", ';
            $resume_data .= $resume_details->resume_count . ',';
        }
    }
    /* Resume Graph access */
    if ($is_allowed) {
        ?>
        <div class="container" id="chartcontainer">
            <canvas id="myChartCand" style="position: relative; margin-bottom: 8%; height:50vh; width:60vw"></canvas>
        </div>
    <?php } ?>
    <script language="Javascript">
        window.onload = function () {
<?php
/* Employer Dashboard Activity Graph */
if ($is_allowed) {
    ?>
                /*Resume Data Stats*/

                var ctx22 = document.getElementById('myChartCand').getContext("2d");
                window.myChart = new Chart(ctx22, {
                    type: 'bar',
                    data: {
                        labels: [<?php echo nokri_returnEcho($resume_labels); ?>],
                        datasets: [{
                                label: get_strings.cand_applied_jobs,
                                data: [<?php echo nokri_returnEcho($resume_data); ?>],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.4)',
                                    'rgba(54, 162, 235, 0.4)',
                                    'rgba(255, 206, 86, 0.4)',
                                    'rgba(75, 192, 192, 0.4)',
                                    'rgba(153, 102, 255, 0.4)',
                                    'rgba(255, 159, 64, 0.4)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                    },
                    options: {
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: get_strings.cand_applied_date,
                                    color: '#000',
                                    font: {
                                        family: 'Times',
                                        size: 20,
                                        weight: 'bold',
                                        lineHeight: 1.2
                                    },
                                    padding: {top: 20, left: 0, right: 0, bottom: 0}
                                }
                            },
                            y: {
                                display: true,
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: get_strings.cand_job_applied,
                                    color: '#000',
                                    font: {
                                        family: 'Times',
                                        size: 20,
                                        weight: 'bold',
                                        style: 'normal',
                                        lineHeight: 1.2
                                    },
                                    padding: {top: 30, left: 0, right: 0, bottom: 0}
                                }
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: get_strings.cand_res_details,
                                color: '#000',
                                font: {
                                    family: 'Times',
                                    size: 20,
                                    weight: 'bold',
                                    style: 'normal',
                                    lineHeight: 2.0
                                },
                                padding: {top: 10, left: 0, right: 0, bottom: 30}
                            },
                            legend: {
                                display: false,
                                labels: {
                                    color: 'rgb(255, 99, 132)'
                                }
                            }

                        }
                    }
                });
<?php } ?>
        };
    </script>
    <?php
    $is_allowed_counter = isset($nokri['cand_counter_data']) ? $nokri['cand_counter_data'] : false;
    if ($is_allowed_counter) {
        ?>
        <h4><?php echo esc_html__('Activities Counter', 'nokri'); ?></h4>
        <!--Dashboard Counter for Total Values-->
        <div class="custom_counter table-responsive dashboard-job-stats-table">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="counter">
                    <i class="fa fa-bullhorn fa-2x"></i>
                    <h2 class="timer count-title count-number" data-to="<?php echo esc_attr($applied_jobs != '' ? $applied_jobs : 0); ?>" data-speed="1500"></h2>
                    <h5><p class="count-text "><a href="<?php echo get_the_permalink(); ?>?tab-data=active-jobs"><?php echo esc_html__('Jobs Applied', 'nokri'); ?></a></p></h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="counter">
                    <i class="fa fa-exclamation-triangle fa-2x"></i>
                    <h2 class="timer count-title count-number" data-to="<?php echo esc_attr($saved_jobs != '' ? $saved_jobs : 0); ?>" data-speed="1500"></h2>
                    <h5><p class="count-text "><a href="<?php echo get_the_permalink(); ?>?tab-data=pending-jobs"><?php echo esc_html__('Saved Jobs', 'nokri'); ?></a></p></h5>              
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="counter">
                    <i class="fa fa-bookmark-o fa-2x"></i>
                    <h2 class="timer count-title count-number" data-to="<?php echo esc_attr($no_of_save_resume != '' ? $no_of_save_resume : 0); ?>" data-speed="1500"></h2>
                    <h5><p class="count-text "><a href="<?php echo get_the_permalink(); ?>?tab-data=saved-resumes"><?php echo esc_html__('Uploaded Resumes', 'nokri'); ?></a></p></h5>
                </div></div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="counter">
                    <i class="fa fa-bell-o fa-2x"></i>
                    <h2 class="timer count-title count-number" data-to="<?php echo esc_attr($follow_comp != '' ? $follow_comp : 0); ?>" data-speed="1500"></h2>
                    <h5><p class="count-text "><a href="<?php echo get_the_permalink(); ?>?tab-data=our-followers"><?php echo esc_html__('Followed Companies', 'nokri'); ?></a></p></h5>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="n-candidate-meta">
        <h4><?php echo esc_html__('My profile', 'nokri'); ?></h4>
        <?php if ($intro) { ?>
            <p><?php echo '' . ($intro); ?></p>
        <?php } if (!empty($skill_tags)) { ?> 
            <div class="n-skills">
                <h4><?php echo esc_html__('Skills:', 'nokri'); ?></h4>
                <div class="n-skills-tags">
                    <?php echo "" . ($skill_tags); ?>
                </div>
            </div>
            <?php
        }
        $cand_education = get_user_meta($user_crnt_id, '_cand_education', true);
        if ($cand_education && $cand_education[0]['degree_name'] != '') {
            ?>
            <div class="timeline-box">
                <h4><?php echo esc_html__('Education:', 'nokri'); ?> </h4>
                <ul class="education">
                    <?php
                    foreach ($cand_education as $edu) {
                        $degre_name = (isset($edu['degree_name'])) ? '<div class="lead">' . esc_html($edu['degree_name']) . '<div>' : '';
                        $degre_strt = (isset($edu['degree_start'])) ? $edu['degree_start'] : '';
                        $degre_insti = (isset($edu['degree_institute'])) ? '<div class="type ">' . esc_html($edu['degree_institute']) . '</div>' : '';
                        $degre_details = (isset($edu['degree_detail'])) ? '<p class="info">' . $edu['degree_detail'] . '</p>' : '';
                        ?>
                        <li><span></span>
                            <div>
                                <div class="date"><?php
                                    echo esc_html($degre_strt) . " ";
                                    if ($edu['degree_end'] != '') {
                                        echo '-' . esc_html($edu['degree_end']);
                                    }
                                    ?></div>
                                <?php echo "" . ($degre_name) . ($degre_insti) . ($degre_details); ?>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php
        }
        $cand_profession = get_user_meta($user_crnt_id, '_cand_profession', true);
        if ($cand_profession && $cand_profession[0]['project_organization'] != '') {
            ?>
            <div class="timeline-box">
                <h4><?php echo esc_html__('Work Experience:', 'nokri'); ?> </h4>
                <ul class="education">
                    <?php
                    foreach ($cand_profession as $profession) {
                        $project_end = $profession['project_end'];
                        if ($profession['project_end'] == '') {
                            $project_end = esc_html__('Currently Working', 'nokri');
                        }
                        $project_role = (isset($profession['project_role'])) ? '<div class="lead">' . esc_html($profession['project_role']) . '<div>' : '';
                        $project_org = (isset($profession['project_organization'])) ? '<div class="type ">' . $profession['project_organization'] . '<div>' : '';
                        $project_strt = (isset($profession['project_start'])) ? esc_html($profession['project_start']) : '';
                        $project_detail = (isset($profession['project_desc'])) ? '<div class="info">' . $profession['project_desc'] . '</div>' : '';
                        ?>
                        <li><span></span>
                            <div>
                                <div class="date"><?php
                                    echo esc_html($project_strt) . " ";
                                    if ($project_end != '') {
                                        echo '-' . ($project_end);
                                    }
                                    ?></div>
                                <?php echo "" . ($project_role) . ($project_org) . ($project_detail); ?>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php
        }
        $cand_certifications = get_user_meta($user_crnt_id, '_cand_certifications', true);
        if ($cand_certifications && $cand_certifications[0]['certification_name'] != '') {
            ?>
            <div class="timeline-box cetificates">
                <h4><?php echo esc_html__('Awards and certificates:', 'nokri'); ?></h4>
                <ul class="education">
                    <?php
                    foreach ($cand_certifications as $certification) {
                        if ($certification['certification_name'] != '') {

                            $certi_name = (isset($certification['certification_name'])) ? '<div class="lead">' . esc_html($certification['certification_name']) . '<div>' : '';
                            $certi_durat = (isset($certification['certification_duration'])) ? '<span>' . esc_html($certification['certification_duration']) . '</span>' : '';
                            $certi_inst = (isset($certification['certification_institute'])) ? '<div class="type ">' . $certification['certification_institute'] . $certi_durat . '<div>' : '';
                            $certi_strt = (isset($certification['certification_start'])) ? esc_html($certification['certification_start']) : '';
                            $certi_detail = (isset($certification['certification_desc'])) ? '<div class="info">' . $certification['certification_desc'] . '</div>' : '';
                            ?>
                            <li><span></span>
                                <div>
                                    <div class="date"><?php
                                        echo '' . ($certi_strt) . " ";
                                        if ($certification['certification_end'] != '') {
                                            echo '-' . esc_html($certification['certification_end']);
                                        }
                                        ?></div>
                                    <?php echo "" . ($certi_name) . ($certi_inst) . ($certi_detail); ?> 
                                </div>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        <?php } if ($portfolio_html) { ?>
            <div class="timeline-box">
                <h4><?php echo esc_html__('Portfolio:', 'nokri'); ?>  </h4>
                <div class="n-my-portfolio">
                    <ul>
                        <?php echo "" . $portfolio_html; ?>
                    </ul>
                </div>
            </div>
            <?php
        }
        if (!empty($cand_video)) {
            $rx = '~
			  ^(?:https?://)?                           # Optional protocol
			   (?:www[.])?                              # Optional sub-domain
			   (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
			   ([^&]{11})                               # Video id of 11 characters as capture group 1
				~x';
            $valid = preg_match($rx, $cand_video, $matches);
            $cand_video = $matches[1];
            ?>
            <div class="timeline-box">
                <h4><?php echo esc_html__('Portfolio video:', 'nokri'); ?>  </h4>
                <div class="n-my-portfolio">
                    <iframe width="830" height="380" src="https://www.youtube.com/embed/<?php echo "" . ($cand_video); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            </div>
            <?php
        }
        if (!empty($cand_intro_video)) {
            $rx = '~
							  ^(?:https?://)?                           # Optional protocol
							   (?:www[.])?                              # Optional sub-domain
							   (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
							   ([^&]{11})                               # Video id of 11 characters as capture group 1
								~x';
            $valid = preg_match($rx, $cand_intro_video, $matches);
            $cand_intro_video = $matches[1];
            ?>
            <div class="resume-3-box">
                <h4><?php echo nokri_feilds_label('cand_vid_lab', esc_html__('Resume Video', 'nokri')); ?></h4>
                <div class="portfolio-video">
                    <iframe width="750" height="380" src="https://www.youtube.com/embed/<?php echo "" . ($cand_intro_video); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            </div>
        <?php }
        ?>
    </div>
</div>