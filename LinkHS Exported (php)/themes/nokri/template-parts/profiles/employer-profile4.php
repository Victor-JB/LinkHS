<?php require trailingslashit(get_template_directory()) . "/template-parts/profiles/employer-meta.php"; ?>

<section class="n-breadcrumb-big resume-3-brreadcrumb" <?php echo "" . ($bg_url); ?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            </div>
        </div>
    </div>
</section>
<section class="n-candidate-detail">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                        <div class="n-details-employers">
                            <div class="n-details-box-employers">
                                <div class="n-details-box-img">
                                    <a href="javascript:void(0)"><img src="<?php echo esc_url($image_link[0]); ?>" class="img-responsive"></a>
                                </div>
                                <div class="n-details-box-text">
                                    <?php if ($emp_profile_status == 'pub' || $author_id == $current_user_id) { ?>
                                        <?php if ($emp_profile_status == 'pub') { ?>                                   
                                            <a href="javascript:void(0)"><h3><?php echo the_author_meta('display_name', $user_id); ?></h3></a>
                                            <?php
                                            $last_login_status = isset($nokri['emp_last_login_status']) ? $nokri['emp_last_login_status'] : false;
                                            if ($last_login_status == true) {
                                                echo '<p>' . esc_html__('Last login:', 'nokri') . ' ' . get_last_login($user_id) . ' ' . esc_html__('ago', 'nokri') . '</p>';
                                            }
                                            ?>
                                        <?php } if ($emp_headline && nokri_feilds_operat('emp_heading_setting', 'show')) { ?>
                                            <p><?php echo esc_html($emp_headline); ?></p>
                                            <?php
                                        }
                                        ?> 
                                    </div>
                                </div>                          
                                <?php if ($soc_sec && $social_links || $author_id == $current_user_id) { ?>
                                    <ul class="n-details-groups n_socials n_custom iconss">
                                        <?php if ($emp_fb) { ?>
                                            <li> <a href="<?php echo esc_url($emp_fb); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/006-facebook.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"></a></li>
                                        <?php } if ($emp_google) { ?>
                                            <li> <a href="<?php echo esc_url($emp_google); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/003-google-plus.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>" target="_blank"></a></li>
                                        <?php } if ($emp_twitter) { ?>
                                            <li> <a href="<?php echo esc_url($emp_twitter); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/004-twitter.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"></a></li>
                                        <?php } if ($emp_linkedin) { ?>
                                            <li> <a href="<?php echo esc_url($emp_linkedin); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/005-linkedin.png" alt="<?php echo esc_attr('icon', 'nokri'); ?>"></a></li>
                                        <?php } ?>
                                    </ul>
                                <?php }
                                ?>
                                <?php if ($emp_profile_status == 'pub' || $author_id == $current_user_id) { ?>
                                    <div class="n-details-groups">
                                        <?php
                                        if (get_user_meta($current_user_id, '_sb_reg_type', true) == 0 && $follow_btn_switch) {

                                            $comp_follow = get_user_meta($current_user_id, '_cand_follow_company_' . $user_id, true);
                                            if ($comp_follow) {
                                                ?>
                                                <li><a class="btn n-btn-flat"><?php echo esc_html__('Followed', 'nokri'); ?></a></li>
                                            <?php } else { ?>

                                                <li><a  data-value="<?php echo esc_attr($author_id); ?>"  class="btn n-btn-flat btn-block follow_company"><?php echo esc_html__('Follow', 'nokri'); ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <div class="n-candidate-info">
                                        <?php if ($emp_profile_status == 'pub' || $author_id == $current_user_id) { ?>
                                            <h4 class="widget-heading"><?php echo nokri_feilds_label('emp_det', esc_html__('Employer detail:', 'nokri')); ?></h4>
                                            <ul>
                                                <li>
                                                    <i class="la la-calendar la-3x"></i>
                                                    <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('emp_mem_sinc', esc_html__('Member since:', 'nokri')); ?></small> <strong><?php echo date_i18n(get_option('date_format'), strtotime($registered)); ?></strong></div>
                                                </li>
                                                <?php if ($emp_address) { ?>
                                                    <li>
                                                        <i class="la la-map-marker la-3x "></i> 
                                                        <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('emp_loc_section_label', esc_html__('Location:', 'nokri')); ?></small> <strong><?php echo esc_html($emp_address); ?> </strong></div>
                                                    </li>
                                                <?php } if ($emp_size) { ?>
                                                    <li>
                                                        <i class="la la-users la-3x"></i> 
                                                        <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('emp_no_emp_label', esc_html__('Employees:', 'nokri')); ?></small><strong><?php echo esc_html($emp_size); ?></strong></div>
                                                    </li>
                                                <?php } if ($is_public || $author_id == $current_user_id) { ?>
                                                    <li>
                                                        <i class="la la-envelope la-3x"></i> 
                                                        <div class="resume-detail-meta"><a href="mailto:<?php echo esc_attr($author->user_email); ?>"><small><?php echo nokri_feilds_label('emp_email_label', esc_html__('Email Address:', 'nokri')); ?></small><strong><?php echo esc_html($author->user_email); ?></strong></a></div>
                                                    </li>
                                                <?php } if ($emp_web && nokri_feilds_operat('emp_web_setting', 'show')) { ?>
                                                    <li>
                                                        <i class="la la-globe la-3x"></i> 
                                                        <div class="resume-detail-meta"><a href="<?php echo esc_url($emp_web); ?>" target="_blank"><small><?php echo nokri_feilds_label('emp_web_label', esc_html__('Website URL:', 'nokri')); ?></small><strong><?php echo esc_html($emp_web); ?></strong></a></div>
                                                    </li>
                                                <?php } if ($is_public && $author_id == $current_user_id) { ?>
                                                    <li>
                                                        <i class="la la-mobile la-3x"></i>
                                                        <div class="resume-detail-meta"><a href="tel:<?php echo esc_attr($emp_cntct); ?>"> <small><?php echo nokri_feilds_label('emp_phone_label', esc_html__('Contact Number:', 'nokri')); ?></small><strong><?php echo esc_html($emp_cntct); ?></strong></a></div>
                                                        <div class="resume-detail-meta"><?php echo esc_attr($verification); ?></div>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                        </div>	
                                        <?php if (isset($registration_feilds) && $registration_feilds != '' || isset($custom_feilds_emp) && $custom_feilds_emp != '') { ?>
                                            <div class="n-candidate-info n-camp-custom-fields">
                                                <h4 class="widget-heading"><?php echo nokri_feilds_label('user_custom_feild_txt', esc_html__('Custom Fields', 'nokri')); ?></h4>
                                                <?php echo '<div class="n-single-meta"><div class="resume-detail-meta"><ul class="n-single-meta-detail">' . $registration_feilds . $custom_feilds_emp . '</ul></div></div>'; ?>
                                            </div>
                                        <?php } if ($skill_tags != "" && $emp_spec_switch) { ?>

                                            <div class="n-candidate-info n-camp-custom-fields">
                                                <h4 class="widget-heading"><?php echo nokri_feilds_label('emp_spec_label', esc_html__('Employer Specialization', 'nokri')); ?></h4>
                                                <?php echo '<div class="n-single-meta"><div class="resume-detail-meta"><ul class="n-single-meta-detail">' . $skill_tags . '</ul></div></div>'; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-8 col-sm-12">
                                        <div class="n-resume-box-details ">
                                            <div class=" resume-3-detail">
                                                <div class="n-4-resume resume-3-box">
                                                    <?php if (get_user_meta($user_id, '_emp_intro', true) != '' && nokri_feilds_operat('emp_about_setting', 'show')) { ?>
                                                        <div class="n-4-resume resume-3-box">
                                                            <h4><?php echo nokri_feilds_label('emp_about_label', esc_html__('About Company:', 'nokri')); ?></h4>
                                                            <?php
                                                            $intro = get_user_meta($user_id, '_emp_intro', true);
                                                            if (!preg_match('%(<p[^>]*>.*?</p>)%i', $intro, $regs)) {
                                                                echo '<p>' . get_user_meta($user_id, '_emp_intro', true) . '</p>';
                                                            } else {
                                                                echo get_user_meta($user_id, '_emp_intro', true);
                                                            }
                                                            ?>
                                                        </div>
                                                    <?php } ?>
                                                    <?php
                                                    $is_access = ( isset($nokri['emp_team_members']) && $nokri['emp_team_members'] != "" ) ? $nokri['emp_team_members'] : false;
                                                    if ($is_access) {
                                                        $team_memebers = get_user_meta($user_id, '_nokri_member_info', true);
                                                        $final_data = $team_memebers != "" ? $team_memebers : array();
                                                        if (is_array($final_data) && !empty($final_data)) {
                                                            ?>
                                                            <div class="n-4-resume resume-3-box">
                                                                <h4><?php echo esc_html__('Team Members', 'nokri'); ?> </h4>
                                                                <?php
                                                                foreach ($final_data as $key => $data) {
                                                                    $team_member_image = ( isset($data['team_member_image']) && $data['team_member_image'] != "" ) ? $data['team_member_image'] : '';
                                                                    $image_source_arr = $team_member_image != "" ? wp_get_attachment_image_src($team_member_image) : array();
                                                                    $image_source = isset($image_source_arr [0]) ? $image_source_arr[0] : "";
                                                                    $team_member_title = ( isset($data['team_member_title']) && $data['team_member_title'] != "" ) ? $data['team_member_title'] : '';
                                                                    $team_member_designation = ( isset($data['team_member_designation']) && $data['team_member_designation'] != "" ) ? $data['team_member_designation'] : '';
                                                                    $team_member_fburl = ( isset($data['team_member_fburl']) && $data['team_member_fburl'] != "" ) ? $data['team_member_fburl'] : '';
                                                                    $team_member_twiturl = ( isset($data['team_member_twiturl']) && $data['team_member_twiturl'] != "" ) ? $data['team_member_twiturl'] : '';
                                                                    $team_member_linkedin = ( isset($data['team_member_linkedin']) && $data['team_member_linkedin'] != "" ) ? $data['team_member_linkedin'] : '';
                                                                    ?>
                                                                    <div class="col-lg-3 <?php echo esc_attr($key); ?>">
                                                                        <figure class="team-grid">
                                                                            <div class="team-header">
                                                                                <div class="team-img">
                                                                                    <img class="rounded-circle " src="<?php echo esc_url($image_source); ?> " alt="Image Description"> 
                                                                                </div>
                                                                                <div class="team-body">
                                                                                    <h4 class=""><?php echo esc_html($team_member_title); ?></h4>
                                                                                    <div class="d-block">
                                                                                        <i class=""></i>
                                                                                        <span class=""><?php echo esc_html($team_member_designation); ?></span>
                                                                                    </div>
                                                                                    <ul class="_nokri-team-social-media">                                     
                                                                                        <li> <a href="<?php echo esc_url($team_member_fburl); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/006-facebook.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>" target="_blank"></a></li>
                                                                                        <li> <a href="<?php echo esc_url($team_member_twiturl); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/004-twitter.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"></a></li>
                                                                                        <li> <a href="<?php echo esc_url($team_member_linkedin); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/005-linkedin.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"></a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </figure>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>   
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?php
                                                $args = array(
                                                    'post_type' => 'job_post',
                                                    'orderby' => 'id',
                                                    'order' => 'DESC',
                                                    'author' => $author_id,
                                                    'post_status' => 'publish',
                                                    'meta_query' => array(array('key' => '_job_status', 'value' => 'active', 'compare' => '=',
                                                        ),
                                                    ),
                                                );
                                                $results = new WP_Query($args);
                                                ?>
                                                <div class="n-related-jobs">
                                                    <?php if ($results->have_posts()) { ?>
                                                        <div class="heading-title left">
                                                            <h4><?php echo nokri_feilds_label('emp_open_pos', esc_html__('Open positions:', 'nokri')); ?></h4>
                                                        </div>
                                                        <div class="n-search-listing n-featured-jobs">
                                                            <div class="n-featured-job-boxes">
                                                                <?php
                                                                while ($results->have_posts()) {
                                                                    $results->the_post();
                                                                    $rel_post_id = get_the_id();
                                                                    $rel_post_author_id = get_post_field('post_author', $rel_post_id);
                                                                    /* Getting Company  Profile Photo */
                                                                    $comp_img_html = '';
                                                                    $rel_image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                                                                    if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
                                                                        $rel_image_link = array($nokri['nokri_user_dp']['url']);
                                                                    }
                                                                    if (get_user_meta($rel_post_author_id, '_sb_user_pic', true) != "") {
                                                                        $attach_id = get_user_meta($rel_post_author_id, '_sb_user_pic', true);
                                                                        $rel_image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
                                                                    }

                                                                    if ($rel_image_link[0] != '') {
                                                                        $comp_img_html = '<div class="n-job-img"><img src="' . esc_url($rel_image_link[0]) . '" alt="' . esc_attr__('logo', 'nokri') . '" class="img-responsive img-circle"></div>';
                                                                    }

                                                                    $job_deadline_n = get_post_meta($rel_post_id, '_job_date', true);
                                                                    $job_deadline = date_i18n(get_option('date_format'), strtotime($job_deadline_n));
                                                                    $job_salary = wp_get_post_terms($rel_post_id, 'job_salary', array("fields" => "ids"));
                                                                    $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
                                                                    $job_salary_type = wp_get_post_terms($rel_post_id, 'job_salary_type', array("fields" => "ids"));
                                                                    $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
                                                                    $job_experience = wp_get_post_terms($rel_post_id, 'job_experience', array("fields" => "ids"));
                                                                    $job_experience = isset($job_experience[0]) ? $job_experience[0] : '';
                                                                    $job_currency = wp_get_post_terms($rel_post_id, 'job_currency', array("fields" => "ids"));
                                                                    $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
                                                                    $job_type = wp_get_post_terms($rel_post_id, 'job_type', array("fields" => "ids"));
                                                                    $job_type = isset($job_type[0]) ? $job_type[0] : '';
                                                                    /* Calling Funtion Job Class For Badges */
                                                                    $single_job_badges = nokri_job_class_badg($rel_post_id);
                                                                    $job_badge_text = '';
                                                                    if (count((array) $single_job_badges) > 0) {
                                                                        foreach ($single_job_badges as $job_badge => $val) {
                                                                            $term_vals = get_term_meta($val);
                                                                            $bg_color = get_term_meta($val, '_job_class_term_color_bg', true);
                                                                            $color = get_term_meta($val, '_job_class_term_color', true);

                                                                            $style_color = '';
                                                                            if ($color != "") {
                                                                                $style_color = 'style=" background-color: ' . $bg_color . ' !important; color: ' . $color . ' !important;"';
                                                                            }
                                                                            $job_badge_text .= '<li><a href="' . get_the_permalink($nokri['sb_search_page']) . '?job_class=' . $val . '" class="job-class-tags-anchor" ' . $style_color . '><span>' . esc_html(ucfirst($job_badge)) . '</span></a></li>';
                                                                        }
                                                                    }
                                                                    if (is_user_logged_in()) {
                                                                        $user_id = get_current_user_id();
                                                                    } else {
                                                                        $user_id = '';
                                                                    }
                                                                    $job_bookmark = get_post_meta($rel_post_id, '_job_saved_value_' . $user_id, true);
                                                                    if ($job_bookmark == '') {
                                                                        $save_job = '<a class="n-job-saved save_job" href="javascript:void(0)" data-value = "' . $rel_post_id . '"><i class="fa fa-heart-o"></i></a> ';
                                                                    } else {
                                                                        $save_job = '<a class="n-job-saved saved" href="javascript:void(0)"><i class="fa fa-heart"></i></a>';
                                                                    }
                                                                    $job_location = nokri_work_location_custom($rel_post_id);
                                                                    ?>
                                                                    <div class="n-job-single">
                                                                        <?php echo ''.($comp_img_html); ?>
                                                                        <div class="n-job-detail">
                                                                            <ul class="list-inline">
                                                                                <li class="n-job-title-box">
                                                                                    <h4><a href="<?php echo the_permalink($rel_post_id); ?>" class="job-title"><?php echo the_title(); ?></a></h4>
                                                                                    <p><i class="ti-location-pin"></i><?php echo " " . $job_location; ?></p>
                                                                                </li>
                                                                                <li class="n-job-short">
                                                                                    <span> <strong><?php echo esc_html__(' Type:', 'nokri'); ?></strong><?php echo nokri_job_post_single_taxonomies('job_type', $job_type); ?></span>
                                                                                    <span> <strong><?php echo esc_html__('Last Date:', 'nokri'); ?> </strong><?php echo " " . ($job_deadline); ?></span>
                                                                                </li>
                                                                                <li class="n-job-btns">
                                                                                    <a href="javascript:void(0)" class="btn n-btn-rounded apply_job" data-job-id="<?php echo esc_attr($rel_post_id); ?>" data-toggle="modal" data-target="#myModal"><?php echo esc_html__('Apply now', 'nokri'); ?></a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="heading-title left">
                                                            <h4><?php echo esc_html__('No open positions', 'nokri'); ?></h4>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                            <div class="resume-3-sidebar n_widget">
                                <div class="n-widget widget">
                                    <?php if ($is_public_contact) { ?>
                                        <h4 class="widget-heading"><?php
                                            echo nokri_feilds_label('emp_cont_lab', esc_html__('Contact ', 'nokri')) . " ";
                                            echo the_author_meta('display_name', $user_id);
                                            ?></h4>
                                        <form id="contact_form_email" method="POST" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <input type="text" name="contact_name" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__('Please enter name', 'nokri'); ?>" class="form-control" placeholder="<?php echo esc_html__('Full name', 'nokri'); ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="email" name="contact_email" class="form-control" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__('Please enter email', 'nokri'); ?>"  placeholder="<?php echo esc_html__('Email address', 'nokri'); ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__('Please enter subject', 'nokri'); ?>" name="contact_subject"   placeholder=" <?php echo esc_html__('Subject', 'nokri'); ?>">
                                            </div>
                                            <input type="hidden" name="receiver_id" value="<?php echo esc_attr($author_id); ?>" />
                                            <div class="form-group">
                                                <textarea name="contact_message" class="form-control"  rows="5"></textarea>
                                            </div>
                                            <?php if ($nokri['google_recaptcha_key'] != "" && $contact_recaptcha) { ?>

                                                <div class="g-recaptcha custom-recaptch-size form-group"  name="contact-recaptcha" data-sitekey="<?php echo esc_attr($nokri['google_recaptcha_key']); ?>">
                                                </div>             
                                                <?php
                                            }
                                            /* Function for Terms and Conditions */
                                            $termsCo = nokri_terms_and_conditions();
                                            echo ''.$termsCo;
                                            ?>
                                            <button type="submit" class="btn n-btn-flat btn-mid btn-block contact_me"><?php echo esc_html__('Message', 'nokri'); ?></button>
                                        </form>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if (!empty($emp_video)) { ?>
                                <h3 class="widget-heading"><?php echo nokri_feilds_label('emp_vid_lab', esc_html__('Employer Video:', 'nokri')); ?> </h3>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <?php
                                    $rx = '~
							  ^(?:https?://)?                           # Optional protocol
							   (?:www[.])?                              # Optional sub-domain
							   (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
							   ([^&]{11})                               # Video id of 11 characters as capture group 1
								~x';
                                    $valid = preg_match($rx, $emp_video, $matches);
                                    $emp_video = $matches[1];
                                    ?>
                                    <iframe width="320" height="300" src="https://www.youtube.com/embed/<?php echo "" . ($emp_video); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                </div>
                            <?php } if ($port_sec && $portfolio_html) { ?>

                                <h3 class="widget-heading"><?php echo nokri_feilds_label('emp_gall_lab', esc_html__('Employer Gallery:', 'nokri')); ?></h3>
                                <div class="n-candidate-info no_border">
                                    <ul class="emp-gallery"><?php echo ''.($portfolio_html); ?></ul>                                                       
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                    get_template_part('template-parts/profiles/rating');
                } else {
                    ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="locked-profile alert alert-danger fade in" role="alert">
                            <i class="la la-lock"></i><?php echo "" . ( $user_private_txt ); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>	
</section>