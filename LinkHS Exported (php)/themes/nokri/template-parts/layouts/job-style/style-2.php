<?php require trailingslashit(get_template_directory()) . "/template-parts/layouts/job-style/job-informations.php"; ?>
<section class="n-single-job n-single-job-transparent" <?php echo nokri_returnEcho($bg_url); ?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <?php echo nokri_returnEcho($job_badge_ul); ?>
                <div class="n-single-title">
                    <?php
                    $work_remotely = nokri_work_location_custom($job_id);
                    if ($work_remotely != "") {
                        $job_location = $work_remotely;
                    } else {
                        $job_location = $countries_last;
                    }
                    ?>
                    <h1><?php the_title(); ?></h1>
                    <ul>
                        <li> <i class="fa fa-folder-open"></i><?php echo '' . $project; ?></li>
                        <?php if (!empty($job_type)) { ?>
                            <li> <i class="fa fa-hand-o-right"></i><?php echo nokri_job_post_single_taxonomies('job_type', $job_type); ?></li>
                        <?php } ?>
                        <li> <i class="fa fa-clock-o"></i><?php echo nokri_time_ago(); ?></li>
                        <?php if (isset($nokri['allow_job_countries']) && $nokri['allow_job_countries'] != 'hide') { ?>
                            <li> <i class="fa fa-map-marker"></i><?php echo "" . $job_location; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <aside class="n-single-sidebar">
                    <?php
                    /* Author Check */
                    if ($user_id == $post_author_id || current_user_can('administrator')) {
                        $direction = 'pull-right';
                        if (is_rtl()) {
                            $direction = 'pull-left';
                        }
                        $edit_url = esc_url(nokri_set_url_param(get_the_permalink($nokri['sb_post_ad_page']), 'id', esc_attr($job_id)));
                        ?>
                        <a href="<?php echo '' . $edit_url; ?>" class="btn n-btn-flat btn-mid btn-clear for-author-only <?php echo esc_attr($direction); ?>"><?php echo esc_html__('Edit Job', 'nokri'); ?></a>
                        <?php
                    } else {
                        /* candidate Check */
                        if (get_user_meta($user_id, '_sb_reg_type', true) == '0') {
                            ?> 
                            <div class="apply-buttons">
                            </div>
                            <?php
                            if ($post_apply_status == 'active') {

                                $apply_status = nokri_job_apply_status($job_id);
                                $apply_now_text = esc_html__('Apply now', 'nokri');
                                if ($apply_status != "") {
                                    $apply_now_text = esc_html__('Applied', 'nokri');
                                }
                                ?>
                                <div class="apply-buttons">
                                    <?php if ($job_apply_with == 'exter') { ?>
                                        <a href="#" class="btn n-btn-flat btn-mid btn-clear external_apply" data-job-id="<?php echo esc_attr($job_id); ?>" data-job-exter="<?php echo esc_url($job_apply_url); ?>"><?php echo esc_html($apply_now_text); ?></a>
                                    <?php } else if ($job_apply_with == 'mail') { ?>
                                        <input type="hidden" class="external_mail_val" value="<?php echo esc_url($job_apply_mail) ?>"/>
                                        <a href="#" class="btn n-btn-flat btn-mid btn-clear email_apply" data-job-id="<?php echo esc_attr($job_id); ?>" data-job-exter="<?php echo '' . ( $job_apply_mail ); ?>"><?php echo esc_html($apply_now_text); ?></a> 
                                    <?php } else if ($job_apply_with == 'whatsapp') {
                                        ?>
                                        <input type="hidden" class="external_whatsapp_val" value="<?php echo '' . $job_apply_whatsapp ?>"/>
                                        <a href="https://api.whatsapp.com/send?phone=<?php echo '' . $job_apply_whatsapp ?>" class="btn n-btn-flat btn-mid btn-clear whatsapp_apply" data-job-id="<?php echo esc_attr($job_id); ?>" data-job-exter="<?php echo '' . ( $job_apply_whatsapp ); ?>"><?php echo esc_html($apply_now_text); ?></a> 
                                        <?php
                                    } else {
                                        ?>
                                        <a href="javascript:void(0)" class="btn n-btn-flat btn-mid btn-clear apply_job" data-job-id="<?php echo esc_attr($job_id); ?>" data-author-id="<?php echo esc_attr($post_author_id); ?>" data-toggle="modal" data-target="#myModal" id="applying_job"><?php echo esc_html($apply_now_text); ?></a>
                                        <?php
                                    }
                                    /* Enable/disable linkedin apply */
                                    if ((isset($nokri['cand_linkedin_apply'])) && $nokri['cand_linkedin_apply'] == 1) {
                                        /* Linkedin key */
                                        $linkedin_api_key = '';
                                        if ((isset($nokri['linkedin_api_key'])) && $nokri['linkedin_api_key'] != '' && (isset($nokri['linkedin_api_secret'])) && $nokri['linkedin_api_secret'] != '' && (isset($nokri['redirect_uri'])) && $nokri['redirect_uri'] != '') {
                                            $linkedin_api_key = ($nokri['linkedin_api_key']);
                                            $linkedin_secret_key = ($nokri['linkedin_api_secret']);
                                            $redirect_uri = ($nokri['redirect_uri']);
//                                            $state = 'not_logged_in-' . $job_id;
//                                            if (is_user_logged_in()) {
//                                                $state = 'logged_in-' . $job_id;
//                                            }
                                            $linkedin_url = 'https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=' . $linkedin_api_key . '&redirect_uri=' . $redirect_uri . '&state=popup&scope=r_liteprofile%20r_emailaddress';
                                            if (!is_user_logged_in()) {
                                                echo '<a href="' . $linkedin_url . '" class="btn-linkedIn btn-block"><i class="ti-linkedin"></i> <span>' . esc_html__('Apply With LinkedIn', 'nokri') . '</span></a>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            <?php } else { ?> <a href="javascript:void(0)" class="btn n-btn-flat btn-mid btn-clear"><?php echo esc_html__('Job Expired', 'nokri'); ?></a><?php
                            }
                        }
                    }
                    ?>
                </aside>
            </div>
        </div>
    </div>
</section>
<section class="n-single-job light-grey n-detail-transparent">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <?php if (get_post_status() == 'pending') { ?>
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><?php echo esc_html__('Information ! ', 'nokri'); ?></strong><?php echo esc_html__('Your job is awaiting for admin approval', 'nokri'); ?> 
                    </div>
                <?php } ?>
                <div class="n_advertise">
                    <?php echo '' . ($advert_up); ?></div>
                <div class="n-single-meta-2">
                    <h4><?php echo esc_html__('Job Information', 'nokri'); ?></h4>
                    <ul class="">
                        <?php if (!empty($job_salary)) { ?>
                            <li>
                                <div class="short-detail-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/icons/tick-icon.png" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                </div>
                                <div class="short-detail-meta">
                                    <small><?php echo esc_html__('Salary', 'nokri'); ?></small>
                                    <strong><?php echo nokri_job_post_single_taxonomies('job_currency', $job_currency) . " " . nokri_job_post_single_taxonomies('job_salary', $job_salary) . " " . '/' . " " . nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type); ?></strong>
                                </div>
                            </li>
                        <?php } ?>

                        <?php if (!empty($job_shift)) { ?>
                            <li>
                                <div class="short-detail-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/icons/tick-icon.png" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                </div>
                                <div class="short-detail-meta">
                                    <small><?php echo nokri_feilds_label('shift_txt', esc_html__('Shift', 'nokri')); ?></small>
                                    <strong><?php echo nokri_job_post_single_taxonomies('job_shift', $job_shift); ?></strong>
                                </div>
                            </li>
                        <?php } ?>
                        <?php if (!empty($job_vacancy)) { ?>
                            <li>
                                <div class="short-detail-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/icons/tick-icon.png" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                </div>
                                <div class="short-detail-meta">
                                    <small><?php echo nokri_feilds_label('vacancy_txt', esc_html__('No. of Openings', 'nokri')); ?></small>
                                    <strong><?php echo esc_html($job_vacancy) . " " . ($opening_text); ?></strong>
                                </div>
                            </li>
                        <?php } if (!empty($job_level)) { ?>
                            <li>
                                <div class="short-detail-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/icons/tick-icon.png" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                </div>
                                <div class="short-detail-meta">
                                    <small><?php echo nokri_feilds_label('level_txt', esc_html__('Job Level :', 'nokri')); ?></small>
                                    <strong><?php echo nokri_job_post_single_taxonomies('job_level', $job_level); ?></strong>
                                </div>
                            </li>
                        <?php } if (!empty($job_experience)) { ?>
                            <li>
                                <div class="short-detail-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/icons/tick-icon.png" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                </div>
                                <div class="short-detail-meta">
                                    <small><?php echo nokri_feilds_label('experience_txt', esc_html__('Job Experience :', 'nokri')); ?></small>
                                    <strong><?php echo nokri_job_post_single_taxonomies('job_experience', $job_experience); ?></strong>
                                </div>
                            </li>
                        <?php } if (!empty($job_qualifications)) { ?>
                            <li>
                                <div class="short-detail-icon">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/icons/tick-icon.png" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                </div>
                                <div class="short-detail-meta">
                                    <small><?php echo nokri_feilds_label('quali_txt', esc_html__('Job Qualifications', 'nokri')); ?></small>
                                    <strong><?php echo nokri_job_post_single_taxonomies('job_qualifications', $job_qualifications); ?></strong>
                                </div>
                            </li> 
                            <?php
                        }
                        /* Dynamic feilds */
                        if (function_exists('nokriCustomFieldsHTML')) {
                            echo nokriCustomFieldsHTML($job_id);
                        }
                        ?>
                    </ul>
                </div>

                <!--Counter of Total Applicants applied against Job-->
                <?php
                $total_applicants = isset($nokri['single_resume_counter']) ? $nokri['single_resume_counter'] : false;

                if ($total_applicants == true) {
                    echo '<div class="jobs-alert-box">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <span><h4>' . esc_html__('Total no of applicants applied: ', 'nokri') . '</h4></span>                            
                                </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <span><h3>' . esc_html(nokri_get_resume_count($job_id)) . '</h3></span> 
                            </div>
                          </div>';
                }
                ?>
                <div class="n-single-detail">                    

                    <h4><?php echo esc_html__('Job Description', 'nokri'); ?></h4>
                    <?php
                    $format_allow = isset($nokri['formated_text_allow_check']) ? $nokri['formated_text_allow_check'] : true;
                    if (!$format_allow) {
                        echo nokri_get_formated_description(get_the_content());
                    } else {
                        the_content();
                    }
                    ?>
                </div>
                <?php if ($job_alerts) { ?>
                    <div class="jobs-alert-box">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <span><?php echo esc_html($job_alerts_title); ?></span>
                            <p><?php echo esc_html($job_alerts_tagline); ?></p>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <a href="javascript:void(0)" class="btn n-btn-flat job_alert"><?php echo esc_html($job_alerts_btn); ?></a>
                        </div>
                    </div>
                <?php } if (!empty($skill_tags)) { ?>
                    <div class="n-skills">
                        <h5><i class="fa fa-tags"></i><?php echo nokri_feilds_label('skills_txt', esc_html__('Job skills', 'nokri')); ?></h5>
                        <div class="n-skills-tags">
                            <?php echo "" . ($skill_tags); ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="n_advertise">
                    <?php echo '' . ($advert_down); ?></div>
                <?php
                if (in_array('add-to-any/add-to-any.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                    echo do_shortcode('[addtoany]');
                }

                if (!empty($job_video)) {
                    $rx = '~
							  ^(?:https?://)?                           # Optional protocol
							   (?:www[.])?                              # Optional sub-domain
							   (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
							   ([^&]{11})                               # Video id of 11 characters as capture group 1
								~x';
                    $valid = preg_match($rx, $job_video, $matches);
                    $job_video = isset($matches[1]) ? $matches[1] : '';
                    ?>
                    <div class="resume-3-box resume-skills">
                        <h4><?php echo esc_html__('Attachment video', 'nokri'); ?> </h4>
                        <div class="portfolio-video">
                            <iframe width="840" height="380" src="https://www.youtube.com/embed/<?php echo "" . ($job_video); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>
                    </div>
                    <?php
                }
                if ((isset($nokri['relateds_jobs_switch'])) && $nokri['relateds_jobs_switch'] == '1') {
                    echo get_template_part('template-parts/layouts/job-style/related', 'jobs');
                }
                ?>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <aside class="n-single-sidebar">
                    <div class="app-deadline">
                        <div class="short-detail-icon">
                            <i class="ti-timer"></i>
                        </div>
                        <div class="short-detail-meta">
                            <small><?php echo esc_html__('Deadline', 'nokri'); ?></small>
                            <strong><?php echo esc_html($job_deadline); ?></strong>
                        </div>
                        <span class="ab-iocn"><i class="ti-alarm-clock"></i></span>
                    </div>
                    <div class="n-single-job-company">
                        <a class="btn btn-block n-btn-custom-two save_job" href="javascript:void(0)" data-value=<?php echo esc_attr($job_id); ?>><?php echo esc_html__('Save This Job', 'nokri'); ?> </a>
                    </div>
                    <?php if ($is_email_job) { ?>
                        <div class="n-single-job-company">
                            <a class="btn btn-block n-btn-custom email_this_job" href="javascript:void(0)" data-job-id=<?php echo esc_attr($job_id); ?>><?php echo esc_html__('Email This Job', 'nokri'); ?> </a>
                        </div>
                        <?php
                    }
                    if (current_user_can('manage_options') && $job_apply_with != "exter" && $job_apply_with != "email") {
                        ?>
                        <div class="n-single-job-company">
                            <a class="btn n-btn-custom btn-block download_admin_resumes" href="javascript:void(0)" data-job-id=<?php echo esc_attr($job_id); ?>><?php echo esc_html__('Download resumes', 'nokri'); ?> </a>
                        </div>
                    <?php } ?>                 
                    <?php if (!empty($job_attachments)) { ?>
                        <div class="n-single-job-attach">
                            <h4 class="widget-heading"><?php echo esc_html__('Job attachments', 'nokri'); ?></h4>
                            <ul class="job-attach"><?php echo "" . ($job_attachments); ?></ul>
                        </div>
                    <?php } ?>
                    <?php
                    /* Candidate Report against job to Admin */
                    if ((isset($nokri['_nokri_cand_report_job'])) ? $nokri['_nokri_cand_report_job'] : '') {
                        $user_type = get_user_meta($user_id, '_sb_reg_type', true) == '0';
                        if (is_user_logged_in() && $user_type) {
                            ?>
                            <div class="n-single-job-company">
                                <a class="btn btn-block n-btn-custom job-report" href="javascript:void(0)" data-user-id = <?php echo esc_attr($user_id); ?> data-job-id=<?php echo esc_attr($job_id); ?>><?php echo esc_html__('Report This Job', 'nokri'); ?> </a>
                            </div>
                            <?php
                        }
                        if (current_user_can('editor') || current_user_can('administrator')) {
                            $reports_counter = nokri_count_user_reports_against_job($job_id);
                            ?>
                            <!--Already reported counter-->
                            <div class="n-single-job-company">
                                <a class="btn btn-block n-btn-flat" href="javascript:void(0)"><h4><?php echo esc_html__('Job Reported', 'nokri'); ?></h4><h4><?php echo esc_attr($reports_counter); ?></h4></a>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="n-single-job-company">
                        <div class="dingle-job-company-meta">
                            <ul class="social-links">
                                <?php if ($emp_fb) { ?>
                                    <li> <a href="<?php echo esc_url($emp_fb); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/006-facebook.png" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"></a></li>
                                <?php } if ($emp_google) { ?>
                                    <li> <a href="<?php echo esc_url($emp_google); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/003-google-plus.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>" class="img-responsive"></a></li>
                                <?php } if ($emp_twitter) { ?>
                                    <li> <a href="<?php echo esc_url($emp_twitter); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/004-twitter.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>" class="img-responsive"></a></li>
                                <?php } if ($emp_linkedin) { ?>
                                    <li> <a href="<?php echo esc_url($emp_linkedin); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/005-linkedin.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>" class="img-responsive"></a></li>
                                <?php } ?>
                            </ul>
                            <div class="contact-img">
                                <img src="<?php echo esc_url($image_link[0]); ?>" class="img-responsive img-circle" alt="<?php echo esc_attr__('company profile image', 'nokri'); ?>">
                            </div>
                            <div class="contact-caption">
                                <h4><?php echo esc_html($company_name); ?></h4>
                                <a href="<?php echo esc_url($web); ?>" target="_blank" ><?php echo esc_html__('Visit Website', 'nokri'); ?></a>
                            </div>
                        </div>
                        <a class="view-profile" href="<?php echo esc_url(get_author_posts_url($post_author_id)); ?>"><?php echo esc_html__('View Profile', 'nokri'); ?> </a>
                    </div>

                    <!--Remotely Work Job Location-->
                    <?php
                    $remotely_work = job_nokri_remotely_work($job_id);
                    echo "" . $remotely_work;
                    ?>

                    <?php
                    if ($is_lat_long && $is_nearby) {
                        $lat_lng_meta_query = array();
                        $latitude = $ad_map_lat;
                        $longitude = $ad_map_long;
                        $distance = $nearby_distance;
                        $num_of_jobs = $nearby_jobs_number;
                        $unit = $distance_unit;
                        $data_array = array();

                        $li = "";

                        if (!empty($longitude) && !empty($longitude)) {
                            $data_array = array("latitude" => $latitude, "longitude" => $longitude, "distance" => $distance);
                        }
                        $type_lat = "'DECIMAL'";
                        $type_lon = "'DECIMAL'";
                        $lats_longs = nokri_radius_search_theme($data_array, false);

                        if (!empty($lats_longs) && count((array) $lats_longs) > 0) {
                            if ($latitude > 0) {
                                $lat_lng_meta_query[] = array(
                                    'key' => '_job_lat',
                                    'value' => array($lats_longs['lat']['min'], $lats_longs['lat']['max']),
                                    'compare' => 'BETWEEN',
                                );
                            } else {
                                $lat_lng_meta_query[] = array(
                                    'key' => '_job_lat',
                                    'value' => array($lats_longs['lat']['max'], $lats_longs['lat']['min']),
                                    'compare' => 'BETWEEN',
                                );
                            }
                            if ($longitude > 0) {
                                $lat_lng_meta_query[] = array(
                                    'key' => '_job_long',
                                    'value' => array($lats_longs['long']['min'], $lats_longs['long']['max']),
                                    'compare' => 'BETWEEN',
                                );
                            } else {
                                $lat_lng_meta_query[] = array(
                                    'key' => '_job_long',
                                    'value' => array($lats_longs['long']['max'], $lats_longs['long']['min']),
                                    'compare' => 'BETWEEN',
                                );
                            }
                            $args = array(
                                'posts_per_page' => $num_of_jobs,
                                'post_type' => 'job_post',
                                'post_status' => 'publish',
                                'order' => 'DESC',
                                'post__not_in' => array($job_id),
                                'orderby' => 'date',
                                'meta_query' => array(
                                    array(
                                        'key' => '_job_status',
                                        'value' => 'active',
                                        'compare' => '=',
                                    ),
                                    $lat_lng_meta_query,
                                ),
                            );
                            $args = nokri_wpml_show_all_posts_callback($args);
                            $results = new WP_Query($args);

                            if ($results->have_posts()) {
                                while ($results->have_posts()) {
                                    $results->the_post();
                                    $job_id = get_the_ID();

                                    $post_author_id = get_post_field('post_author', $job_id);
                                    $company_name = get_the_author_meta('display_name', $post_author_id);

                                    $image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';

                                    if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
                                        $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
                                        if (is_numeric($attach_id)) {
                                            $image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
                                        } else {
                                            $image_link[0] = $attach_id;
                                        }
                                    }
                                    $latitude1 = get_post_meta($job_id, '_job_lat', true);
                                    $longitude1 = get_post_meta($job_id, '_job_long', true);

                                    $calculated_distance = nokri_nearby_distance($latitude, $longitude, $latitude1, $longitude1, $unit);

                                    $final_distance = $calculated_distance . $distance_unit;
                                    if ($final_distance == '0km') {
                                        $final_distance_loc = esc_html__('Same Location', 'nokri');
                                    } else {
                                        $final_distance_loc = $final_distance;
                                    }
                                    $li .= '<li>
                                        <div class = "recently-added-img"><a href = "' . $image_link[0] . '"> <img class = "img-fluid" src = "' . $image_link[0] . '" alt = ""> </a> </div>
                                            <div class = "recently-added-desc">
   
                                               <h4><a href = "' . get_the_permalink() . '">' . esc_html(get_the_title()) . '</a></h4>
                                                <span class="distance_clr">' . esc_html($final_distance_loc) . '</span>
                                            <div class = "main-rate mb-1"><span class = "main-reg-pricing "> </span></div>
                                        </div>
                                     </li>';
                                }
                                wp_reset_postdata();
                            }
                            ?>
                            <div class="panel panel-default nearby_jobs">
                                <div class="panel-heading" role="tab">
                                    <a class="collapsed" role="button" data-toggle="collapse" href="#feature-candidate" aria-expanded="false">												
                                        <?php echo esc_html__('Near by jobs', 'nokri') ?>              </a>
                                </div>
                                <div class="panel-collapse" id="feature-candidate">
                                    <div class="panel-body">
                                        <ul class="widget-inner-container recently-added">
                                            <?php echo nokri_returnEcho($li); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }if ((isset($nokri['single_job_tags'])) && $nokri['single_job_tags'] == 1 && !empty($tags_html)) {
                        ?>
                        <div class="n-job-tags">
                            <h3><?php echo nokri_feilds_label('tags_txt', esc_html__('Job tags', 'nokri')); ?></h3>
                            <ul class="job-tag-list">
                                <?php echo "" . ($tags_html); ?>
                            </ul>
                        </div>
                    <?php } ?>
                </aside>
            </div>
        </div>
    </div>
</section>
<div class="modal fade resume-action-modal" id="myModal-linkedin_url">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" id="submit_linkedin_url" class="apply-job-modal-popup">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo esc_html__('Want to apply for this job', 'nokri'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label><?php echo esc_html__('Enter your linkedin profile url', 'nokri'); ?><span class="color-red">*</span></label>
                            <input placeholder="<?php echo esc_html__('Enter your linkedin profile url', 'nokri'); ?>" class="form-control" type="text" name="linkedin_url"  data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__('Enter your linkedin profile url', 'nokri'); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit"  class="btn n-btn-flat btn-mid btn-block submit_linkedin_url">
                            <?php echo esc_html__('Apply Now', 'nokri'); ?>
                        </button>
                    </div>
                </div>
                <input type="hidden" value="<?php echo esc_attr($job_id); ?>"  name="apply_job_id" />
            </form>
        </div>
    </div>
</div>
<?php
if (isset($_GET['src']) && $_GET['src'] == 'lkn') {
    echo "<script type='text/javascript'>
	jQuery(window).load(function(){
		jQuery('#myModal-linkedin_url').modal({backdrop: 'static', keyboard: false});
	jQuery('#myModal-linkedin_url').modal('show');
	});
	</script>";
}
if ($single_job_schema) {
    ?>
    <script type="application/ld+json">
        {
        "@context": "https://schema.org/",
        "@type": "JobPosting",
        "title": "<?php the_title(); ?>",
        "description": "<?php echo wp_strip_all_tags(get_the_content()); ?>",
        "hiringOrganization" : {
        "@type": "Organization",
        "name": "<?php echo esc_html($company_name); ?>",
        "sameAs": "<?php echo esc_url($web); ?>"
        },
        "employmentType": "<?php echo nokri_job_post_single_taxonomies('job_type', $job_type); ?>",
        "datePosted": "<?php echo get_the_date('Y-m-d'); ?>",
        "validThrough": "<?php echo esc_html($job_deadline); ?>",
        "jobLocation": {
        "@type": "Place",
        "address": {
        "@type": "PostalAddress",
        "addressCountry": "<?php echo '' . $countries_last; ?>"
        }
        },
        "baseSalary": {
        "@type": "MonetaryAmount",
        "currency": "<?php echo nokri_job_post_single_taxonomies('job_currency', $job_currency); ?>",
        "value": {
        "@type": "QuantitativeValue",
        "value": "<?php echo nokri_job_post_single_taxonomies('job_salary', $job_salary); ?>",
        "unitText": "<?php echo nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type); ?>"
        }
        },
        "qualifications": "<?php echo nokri_job_post_single_taxonomies('job_qualifications', $job_qualifications); ?>",
        "experienceRequirements": "<?php echo nokri_job_post_single_taxonomies('job_experience', $job_experience); ?>"
        }
    </script>
    <?php
}    