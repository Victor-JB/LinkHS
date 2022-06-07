<?php require trailingslashit(get_template_directory()) . "/template-parts/profiles/candidate-meta.php"; ?>
<section class="n-breadcrumb-big" <?php echo '' . $bg_url; ?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcrumb-text">
                    <h2><?php echo esc_html($author->display_name); ?></h2>
                    <ul>
                        <li><?php echo esc_html__('Home', 'nokri'); ?></li>
                        <li><?php echo nokri_breadcrumb(); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="n-candidate-detail">
    <div class="container">
        <div class="row">
            <?php
            if ($cand_profile_status == 'pub' || $author_id == $current_user_id || current_user_can('administrator') || $is_search) {
                $resumes_viewed = get_user_meta($current_user_id, '_sb_cand_viewed_resumes', true);
                if (isset($nokri['cand_search_mode']) && $nokri['cand_search_mode'] == "2") {
                    $remaining_searches = get_user_meta($current_user_id, '_sb_cand_search_value', true);
                    $unlimited_searches = false;
                    if ($remaining_searches == '-1') {
                        $unlimited_searches = true;
                    }
                    if (!$is_applied && !$unlimited_searches && !current_user_can('administrator') && $author_id != $current_user_id) {
                        $resumes_viewed_array = (explode(",", $resumes_viewed));
                        if (!in_array($author_id, $resumes_viewed_array)) {
                            $author_id = $author_id;
                            if ($resumes_viewed != '') {
                                $author_id = $resumes_viewed . ',' . $author_id;
                            }
                            update_user_meta($current_user_id, '_sb_cand_viewed_resumes', $author_id);
                            if ($remaining_searches != '0') {
                                update_user_meta($current_user_id, '_sb_cand_search_value', (int) $remaining_searches - 1);
                            }
                        }
                    }
                }
                ?>
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 col-lg-push-9 col-md-push-8">
                    <aside class="n-single-sidebar">
                        <div class="n-single-job-company">
                            <div class="dingle-job-company-meta">
                                <?php if ($soc_sec && $social_links || $author_id == $current_user_id && $cand_profile_status == 'pub') { ?>
                                    <ul class="social-links">
                                        <?php if ($cand_fb) { ?>
                                            <li><a href="<?php echo esc_url($cand_fb); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/006-facebook.png" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"></a></li>
                                        <?php } if ($cand_google) { ?>
                                            <li>
                                                <a href="<?php echo esc_url($cand_google); ?>">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/icons/003-google-plus.png" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                                </a>
                                            </li>
                                        <?php } if ($cand_twiter) { ?>
                                            <li>
                                                <a href="<?php echo esc_url($cand_twiter); ?>">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/icons/004-twitter.png" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                                </a>
                                            </li>
                                        <?php } if ($cand_linked) { ?>
                                            <li>
                                                <a href="<?php echo esc_url($cand_linked); ?>">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/icons/005-linkedin.png" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                                <div class="contact-img">
                                    <img src="<?php echo esc_url($image_link); ?>" class="img-responsive" alt="<?php echo esc_attr__('image', 'nokri'); ?>">
                                </div>
                                <div class="contact-caption">
                                    <h4><?php echo esc_html($author->display_name); ?></h4>
                                    <?php
                                    $last_login_status = isset($nokri['cand_last_login_status']) ? $nokri['cand_last_login_status'] : false;
                                    if ($last_login_status == true) {
                                        echo '<p>' . esc_html__('Last login:', 'nokri') . ' ' . get_last_login($author_id) . ' ' . esc_html__('ago', 'nokri') . '</p>';
                                    }
                                    ?>
                                    <?php if ($cand_headline) { ?>
                                        <p><?php echo esc_html($cand_headline); ?></p>
                                    <?php } ?>
                                </div>
                                <?php if ($cand_save_setting) { ?>
                                    <button type="submit" class="btn n-btn-custom btn-block saving_resume" data-cand-id= <?php echo esc_attr($author_id); ?>><i class="fa fa-heart"></i><?php echo nokri_feilds_label('cand_save_resume', esc_html__('Save Resume', 'nokri')); ?></button> 
                                <?php } if ($cand_resume_down && $cand_resume_setting) echo '' . $resume_id; ?>
                                <?php if ($cand_resume_gen && $cand_generate_setting) { ?>

                                    <a href="#" class="btn n-btn-custom btn-block"  data-toggle="modal" data-target="#template_modal"><i class="fa fa-download"></i><?php echo nokri_feilds_label('cand_generate_resume', esc_html__('Generate Resume', 'nokri')); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="n-candidate-info">
                            <h4><?php echo nokri_feilds_label('cand_det', esc_html__('Candidate detail', 'nokri')); ?></h4>
                            <ul>
                                <?php if ($cand_dob && nokri_feilds_operat('cand_dob_setting', 'show') && $cand_dob_setting) { ?>
                                    <li>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/resume-detail-icons/017-birthday.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"> 
                                        <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('cand_dob_label', esc_html__('Date of birth:', 'nokri')); ?></small> <strong><?php echo date_i18n(get_option('date_format'), strtotime($cand_dob)); ?></strong></div>
                                    </li>
                                <?php } if ($registered) { ?>
                                    <li>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/resume-detail-icons/011-calendar.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"> 
                                        <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('cand_mem', esc_html__('Member Since', 'nokri')); ?></small> <strong><?php echo date_i18n(get_option('date_format'), strtotime($registered)); ?></strong></div>
                                    </li>
                                <?php } if (($cand_phone != "" && $is_public && $cand_phone_setting) || $author_id == $current_user_id) { ?>
                                    <li>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/resume-detail-icons/009-phone-receiver.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"> 
                                        <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('cand_phone_label', esc_html__('Cell No:', 'nokri')); ?></small><strong><?php echo esc_html($cand_phone); ?></strong></div>
                                        <div class="resume-detail-meta"><?php echo esc_attr($verification); ?></div>
                                    </li>
                                <?php } if (( $is_public && $cand_email_setting ) || $author_id == $current_user_id) { ?>
                                    <li>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/resume-detail-icons/008-email.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"> 
                                        <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('cand_email_label', esc_html__('Email address', 'nokri')); ?></small><strong><?php echo esc_html($author->user_email); ?></strong></div>
                                    </li>
                                <?php } if ($cand_address && $cand_adress_setting) { ?>
                                    <li>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/resume-detail-icons/007-placeholder.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                        <div class="resume-detail-meta"> <small><?php echo esc_html__('Address:', 'nokri'); ?></small><strong><?php echo esc_html($cand_address); ?></strong></div>   
                                    </li>
                                <?php } if ($salary_range) { ?>
                                    <li>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/resume-detail-icons/coins.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                        <div class="resume-detail-meta"> <small><?php echo esc_html__('Salary:', 'nokri'); ?></small><strong>
                                                <?php echo nokri_job_post_single_taxonomies('job_currency', $salary_curren) . " " . nokri_job_post_single_taxonomies('job_salary', $salary_range) . " " . '/' . " " . nokri_job_post_single_taxonomies('job_salary_type', $salary_type); ?>
                                            </strong></div>   
                                    </li>
                                <?php } if ($cand_gender && nokri_feilds_operat('cand_gend_setting', 'show')) { ?>
                                    <li>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/resume-detail-icons/gender.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                        <div class="resume-detail-meta"> <small><?php echo nokri_feilds_label('cand_gend', esc_html__('Gender', 'nokri')); ?></small><strong>
                                                <?php echo ucfirst($cand_gender); ?>
                                            </strong></div>   
                                    </li>
                                <?php } if ($cand_qualification && nokri_feilds_operat('cand_quali_setting', 'show')) { ?>
                                    <li>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/resume-detail-icons/graduated.png" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                        <div class="resume-detail-meta"> <small><?php echo nokri_feilds_label('cand_quali_label2', esc_html__('Qualifications', 'nokri')); ?></small><strong>
                                                <?php echo nokri_job_post_single_taxonomies('job_qualifications', $cand_qualification); ?>
                                            </strong></div>   
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php if ($hours_sec) { ?>
                            <div class="n-candidate-info2">
                                <h4>
                                    <?php echo nokri_feilds_label('cand_hours_label', esc_html__('Scheduled Hours', 'nokri')) ?>
                                </h4>
                                <?php
                                if (get_user_meta($user_crnt_id, 'nokri_is_hours_allow', true) == '1') {
                                    //now check if its 24/7 or selective timimgz
                                    if (get_user_meta($user_crnt_id, 'nokri_business_hours', true) == '1') {
                                        ?>
                                        <?php echo esc_html__('Always Available', 'nokri'); ?>
                                        <?php
                                    } else {
                                        $get_hours = nokri_show_business_hours($user_crnt_id);
                                        $status_type = nokri_business_hours_status($user_crnt_id);
                                        if ($status_type == 0) {
                                            $business_hours_status = esc_html__('Closed', 'nokri');
                                        } else {
                                            $business_hours_status = esc_html__('Open Now', 'nokri');
                                        }
                                        $class = '';
                                        if (is_rtl()) {
                                            $class = 'flip';
                                        }
                                        ?>
                                        <div class="opening-hours-title tool-tip" title="<?php echo esc_html__('Business Hours', 'nokri'); ?>"> <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri()) . 'images/clock.png'); ?>" alt="<?php echo esc_html__('not found', 'nokri'); ?>"><span><?php echo esc_html($business_hours_status); ?></span> 
                                        </div> 
                                        <?php
                                        if (get_user_meta($user_crnt_id, 'nokri_user_timezone', true) != "") {
                                            echo '<div class="s-timezone">' . esc_html__("Timezone:", "nokri") . '<strong>' . get_user_meta($user_crnt_id, 'nokri_user_timezone', true) . '</strong></div>';
                                        }
                                        ?>
                                        <ul class="days_list">
                                            <?php
                                            if (is_array($get_hours) && count($get_hours) > 0) {
                                                foreach ($get_hours as $key => $val) {
                                                    $class = '';
                                                    if ($val['current_day'] != "") {
                                                        $class = "current_day";
                                                    }
                                                    if ($val['closed'] == 1) {
                                                        $class = "closed";
                                                        echo '' . $htm_return = '<li class="' . esc_html($class) . '"> <span class="day-name"> ' . $val['day_name'] . ':</span> <span class="day-timing"> ' . esc_html__('Closed', 'nokri') . ' </span> </li>';
                                                    } else {
                                                        echo '' . $htm_return = ' <li class="' . esc_html($class) . '"> <span class="day-name"> ' . $val['day_name'] . ':</span> <span class="day-timing"> ' . esc_attr($val['start_time']) . ' - ' . esc_attr($val['end_time']) . ' </span> </li>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </ul>      
                                        <?php
                                    }
                                } else {
                                    echo "<strong> N/A </strong>";
                                } echo "</div>";
                            }
                            if ($is_public_contact) {
                                ?>
                                <div class="n-candidate-contact-form">
                                    <h4><?php echo nokri_feilds_label('cand_cont_lab', esc_html__('Contact', 'nokri')); ?></h4>
                                    <form id="contact_form_email" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="text" name="contact_name" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__('Please enter name', 'nokri'); ?>" class="form-control" placeholder="<?php echo esc_html__('Full Name', 'nokri'); ?>">
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
                                            <div class="form-group custom-recaptch-size g-recaptcha" name="contact-recaptcha" data-sitekey="<?php echo esc_attr($nokri['google_recaptcha_key']); ?>">
                                            </div>                    
                                            <?php
                                        }
                                        /* Function for Terms and Conditions */
                                        $termsCo = nokri_terms_and_conditions();
                                        echo'' . $termsCo;
                                        ?>
                                        <button type="submit" class="btn n-btn-flat btn-mid btn-block contact_me"><?php echo esc_html__('Message', 'nokri'); ?></button>
                                    </form>
                                </div>
                            <?php } ?>
                            <?php if (isset($cand_advertisment) && $cand_advertisment != '') { ?>
                                <div class="n-candidate-info">
                                    <h4 class="widget-heading"><?php echo esc_html__('Advertisement', 'nokri'); ?></h4>
                                    <?php echo '' . ($cand_advertisment); ?>
                                </div>
                            <?php } ?>
                    </aside>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 col-lg-pull-3 col-md-pull-4">
                    <div class="n-candidate-meta">
                        <h4><?php echo esc_html__('Candidate Detail', 'nokri'); ?></h4>
                        <?php if ($cand_introd != '' && nokri_feilds_operat('cand_about_setting', 'show')) { ?>
                            <p><?php echo '' . ($cand_introd); ?></p>
                        <?php } if (isset($registration_feilds) && $registration_feilds != '' || isset($custom_feilds_cand) && $custom_feilds_cand != '') { ?>
                            <div class="custom-field-box">
                                <h4><?php echo nokri_feilds_label('user_custom_feild_txt', esc_html__('Custom Fields', 'nokri')); ?></h4>
                                <div class="n-can-custom-meta">
                                    <ul class="n-can-custom-meta-detail">
                                        <?php echo '' . $registration_feilds . $custom_feilds_cand; ?>
                                    </ul>
                                </div>
                            </div>		 
                        <?php } if ($skill_sec && !empty($skills_bar)) { ?>
                            <div class="n-skills resume-3-detail">
                                <h4><?php echo nokri_feilds_label('cand_skills_label', esc_html__('Skills and tools', 'nokri')); ?></h4> 
                                <div class="n-skills-tags resume-3-box">
                                    <?php echo '' . ($skills_bar); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php
                        $cand_education = get_user_meta($user_crnt_id, '_cand_education', true);
                        if ($edu_sec && $cand_education && $cand_education[0]['degree_name'] != '') {
                            ?>
                            <div class="timeline-box">
                                <h4><?php echo nokri_feilds_label('cand_edu_lab', esc_html__('Education', 'nokri')); ?></h4>
                                <ul class="education">
                                    <?php
                                    foreach ($cand_education as $edu) {
                                        $degre_name = (isset($edu['degree_name'])) ? '<div class="lead">' . esc_html($edu['degree_name']) . '</div>' : '';
                                        $degre_strt = (isset($edu['degree_start'])) ? $edu['degree_start'] : '';
                                        $degre_insti = (isset($edu['degree_institute'])) ? '<div class="type ">' . ($edu['degree_institute']) . '</div>' : '';
                                        $degre_details = (isset($edu['degree_detail'])) ? '<div class="info">' . wp_kses_post($edu['degree_detail']) . '</div>' : '';
                                        ?>
                                        <li><span></span>
                                            <div>
                                                <div class="date"><?php
                                                    echo '' . ($degre_strt) . " ";
                                                    if ($edu['degree_end'] != '') {
                                                        echo '-' . " " . ($edu['degree_end']);
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
                        if ($prof_sec && $cand_profession && $cand_profession[0]['project_organization'] != '') {
                            ?>
                            <div class="timeline-box">
                                <h4><?php echo nokri_feilds_label('cand_prof_lab', esc_html__('Work Experience', 'nokri')); ?></h4>
                                <ul class="education">
                                    <?php
                                    foreach ($cand_profession as $profession) {
                                        $project_end = $profession['project_end'];
                                        if ($profession['project_end'] == '') {
                                            $project_end = esc_html__('Currently Working', 'nokri');
                                        }
                                        $project_role = (isset($profession['project_role'])) ? '<div class="lead">' . esc_html($profession['project_role']) . '</div>' : '';
                                        $project_org = (isset($profession['project_organization'])) ? '<div class="type ">' . $profession['project_organization'] . '</div>' : '';
                                        $project_strt = (isset($profession['project_start'])) ? esc_html($profession['project_start']) : '';
                                        $project_detail = (isset($profession['project_desc'])) ? '<div class="info">' . wp_kses_post($profession['project_desc']) . '</div>' : '';
                                        ?>
                                        <li><span></span>
                                            <div>
                                                <div class="date"><?php
                                                    echo esc_html($project_strt) . " ";
                                                    if ($project_end != '') {
                                                        echo '-' . " " . ($project_end);
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
                        if ($cert_sec && $cand_certifications && $cand_certifications[0]['certification_name'] != '') {
                            ?>
                            <div class="timeline-box cetificates">
                                <h4><?php echo nokri_feilds_label('cand_certi_lab', esc_html__('Awards and Certificates  :', 'nokri')); ?></h4>
                                <ul class="education">
                                    <?php
                                    foreach ($cand_certifications as $certification) {
                                        if ($certification['certification_name'] != '') {
                                            $certi_name = (isset($certification['certification_name'])) ? '<div class="lead">' . esc_html($certification['certification_name']) . '</div>' : '';
                                            $certi_durat = (isset($certification['certification_duration'])) ? '<span>' . esc_html($certification['certification_duration']) . '</span>' : '';
                                            $certi_inst = (isset($certification['certification_institute'])) ? '<div class="type ">' . $certification['certification_institute'] . "  " . $certi_durat . '</div>' : '';
                                            $certi_strt = (isset($certification['certification_start'])) ? esc_html($certification['certification_start']) : '';
                                            $certi_detail = (isset($certification['certification_desc'])) ? '<div class="info">' . wp_kses_post($certification['certification_desc']) . '</div>' : '';
                                            ?>
                                            <li><span></span>
                                                <div>
                                                    <div class="date"><?php
                                                        echo '' . ($certi_strt) . " ";
                                                        if ($certification['certification_end'] != '') {
                                                            echo '-' . " " . esc_html($certification['certification_end']);
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
                                <h4><?php echo nokri_feilds_label('cand_portfolio_label', esc_html__('Portfolio', 'nokri')); ?></h4>
                                <div class="n-my-portfolio">
                                    <ul>
                                        <?php echo "" . $portfolio_html; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                        } if (!empty($cand_video)) {
                            $rx = '~
							  ^(?:https?://)?                           # Optional protocol
							   (?:www[.])?                              # Optional sub-domain
							   (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
							   ([^&]{11})                               # Video id of 11 characters as capture group 1
								~x';
                            $valid = preg_match($rx, $cand_video, $matches);
                            $cand_video = $matches[1];
                            ?>
                            <div class="timeline-box n-video-portfolio">
                                <h4><?php echo nokri_feilds_label('cand_vid_lab', esc_html__('Portfolio video', 'nokri')); ?></h4>
                                <div class="n-my-portfolio ">
                                    <iframe width="750" height="380" src="https://www.youtube.com/embed/<?php echo "" . ($cand_video); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                        if (!empty($cand_intro_video) && !$cand_video_resume_switch) {
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
                            <?php
                        }
                        if ($cand_video_resume_switch && $cand_video_resumes != "") {
                            $video_url = wp_get_attachment_url($cand_video_resumes);
                            $media_type = wp_get_attachment_metadata(($cand_video_resumes));
                            ?>
                            <div class="resume-3-box">
                                <h4><?php echo nokri_feilds_label('cand_vid_lab', esc_html__('Resume Video', 'nokri')); ?></h4>
                                <div class="portfolio-video">
                                    <video width="710" height="380" controls>
                                        <source src="<?php echo '' . $video_url; ?>" type="<?php echo '' . $media_type['mime_type']; ?>">
                                    </video>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php get_template_part('template-parts/profiles/cand-rating'); ?>
                </div>              
            <?php } else { ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="locked-profile alert alert-danger fade in" role="alert">
                        <i class="la la-lock"></i><?php echo "" . ( $user_private_txt ); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>