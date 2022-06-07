<?php
global $nokri;
$mapType = nokri_mapType();
if ($mapType == 'google_map') {
    wp_enqueue_script('google-map-callback', false);
}
$user_info = wp_get_current_user();
$user_crnt_id = $user_info->ID;
$is_candidate = $user_info->ID;
$ad_map_lat = '';
if ((isset($nokri['sb_default_lat'])) && $nokri['sb_default_lat'] != '') {
    $ad_map_lat = ($nokri['sb_default_lat']);
}
$ad_map_long = '';
if ((isset($nokri['sb_default_lat'])) && $nokri['sb_default_lat'] != '') {
    $ad_map_long = ($nokri['sb_default_long']);
}
if (get_user_meta($user_crnt_id, '_cand_map_lat', true) != '') {
    $ad_map_lat = get_user_meta($user_crnt_id, '_cand_map_lat', true);
}
if (get_user_meta($user_crnt_id, '_cand_map_long', true) != '') {
    $ad_map_long = get_user_meta($user_crnt_id, '_cand_map_long', true);
}
$ad_mapLocation = '';
$ad_mapLocation = get_user_meta($user_crnt_id, '_cand_address', true);
nokri_load_search_countries(1);
$cand_video = get_user_meta($user_crnt_id, '_cand_video', true);
$cand_qualification = get_user_meta($user_crnt_id, '_cand_qualification', true);
$cand_gender = get_user_meta($user_crnt_id, '_cand_gender', true);
$cand_profile = get_user_meta($user_crnt_id, '_user_profile_status', true);
$cand_type = get_user_meta($user_crnt_id, '_cand_type', true);
$cand_level = get_user_meta($user_crnt_id, '_cand_level', true);
$cand_experience = get_user_meta($user_crnt_id, '_cand_experience', true);
$cand_salary_type = get_user_meta($user_crnt_id, '_cand_salary_type', true);
$cand_salary_range = get_user_meta($user_crnt_id, '_cand_salary_range', true);
$cand_salary_curren = get_user_meta($user_crnt_id, '_cand_salary_curren', true);
$cand_custom_loc = array();
$cand_custom_loc = get_user_meta($user_crnt_id, '_cand_custom_location', true);


$levelz = count((array) $cand_custom_loc);
/* Getting Candidate Dp */
$image_dp_link[0] = '';
if (get_user_meta($user_crnt_id, '_cand_dp', true) != "") {

    $attach_dp_id = get_user_meta($user_crnt_id, '_cand_dp', true);
    $image_dp_link = wp_get_attachment_image_src($attach_dp_id, '');
}
//Countries
$ad_country = nokri_get_cats('ad_location', 0);
$country_html = '';
foreach ($ad_country as $ad_count) {
    $country_html .= '<option value="' . $ad_count->term_id . '">' . $ad_count->name . '</option>';
}
$cand_skills = $cand_skills_values = array();
$cand_skills_values = get_user_meta($user_crnt_id, '_cand_skills_values', true);
$cand_skills = get_user_meta($user_crnt_id, '_cand_skills', true);
/* Setting profile option */
$profile_setting_option = isset($nokri['user_profile_setting_option']) ? $nokri['user_profile_setting_option'] : false;
/* Is map show */
$allow_map = isset($nokri['nokri_allow_map']) ? $nokri['nokri_allow_map'] : true;

$is_lat_long = isset($nokri['cand_map_switch']) ? $nokri['cand_map_switch'] : false;
/* Is account del option */
$is_acount_del = isset($nokri['user_profile_delete_option']) ? $nokri['user_profile_delete_option'] : false;
/* For job Location level text */
$job_country_level_heading = ( isset($nokri['job_country_level_heading']) && $nokri['job_country_level_heading'] != "" ) ? $nokri['job_country_level_heading'] : '';
/* For Map  text */
$map_location_txt = ( isset($nokri['job_map_heading_txt']) && $nokri['job_map_heading_txt'] != "" ) ? $nokri['job_map_heading_txt'] : '';

$job_country_level_1 = ( isset($nokri['job_country_level_1']) && $nokri['job_country_level_1'] != "" ) ? $nokri['job_country_level_1'] : '';

$job_country_level_2 = ( isset($nokri['job_country_level_2']) && $nokri['job_country_level_2'] != "" ) ? $nokri['job_country_level_2'] : '';

$job_country_level_3 = ( isset($nokri['job_country_level_3']) && $nokri['job_country_level_3'] != "" ) ? $nokri['job_country_level_3'] : '';

$job_country_level_4 = ( isset($nokri['job_country_level_4']) && $nokri['job_country_level_4'] != "" ) ? $nokri['job_country_level_4'] : '';
/* Make location selected on update ad */
$ad_countries = nokri_get_cats('ad_location', 0);
$country_html = '';
foreach ($ad_countries as $ad_country) {
    $selected = '';
    if (isset($cand_custom_loc[0])) {
        if ($levelz > 0 && $ad_country->term_id == $cand_custom_loc[0]) {
            $selected = 'selected="selected"';
        }
    }
    $country_html .= '<option value="' . $ad_country->term_id . '" ' . $selected . '>' . $ad_country->name . '</option>';
}
$country_states = '';
if ($levelz >= 2) {
    $ad_states = nokri_get_cats('ad_location', $cand_custom_loc[0]);
    $country_states = '';
    foreach ($ad_states as $ad_state) {
        $selected = '';
        if ($levelz > 0 && $ad_state->term_id == $cand_custom_loc[1]) {
            $selected = 'selected="selected"';
        }
        $country_states .= '<option value="' . $ad_state->term_id . '" ' . $selected . '>' . $ad_state->name . '</option>';
    }
}
$country_cities = '';
if ($levelz >= 3) {
    $ad_country_cities = nokri_get_cats('ad_location', $cand_custom_loc[1]);
    $country_cities = '';
    foreach ($ad_country_cities as $ad_city) {
        $selected = '';
        if ($levelz > 0 && $ad_city->term_id == $cand_custom_loc[2]) {
            $selected = 'selected="selected"';
        }
        $country_cities .= '<option value="' . $ad_city->term_id . '" ' . $selected . '>' . $ad_city->name . '</option>';
    }
}
$country_towns = '';
if ($levelz >= 4) {
    $ad_country_town = nokri_get_cats('ad_location', $cand_custom_loc[2]);
    $country_towns = '';
    foreach ($ad_country_town as $ad_town) {
        $selected = '';
        if ($levelz > 0 && $ad_town->term_id == $cand_custom_loc[3]) {
            $selected = 'selected="selected"';
        }
        $country_towns .= '<option value="' . $ad_town->term_id . '" ' . $selected . '>' . $ad_town->name . '</option>';
    }
}
/* Section hide/show */
$res_sec = (isset($nokri['resume_section_switch'])) ? $nokri['resume_section_switch'] : false;
$skill_sec = (isset($nokri['skill_section_switch'])) ? $nokri['skill_section_switch'] : false;
$edu_sec = (isset($nokri['education_section_switch'])) ? $nokri['education_section_switch'] : false;
$prof_sec = (isset($nokri['profession_section_switch'])) ? $nokri['profession_section_switch'] : false;
$cert_sec = (isset($nokri['certification_section_switch'])) ? $nokri['certification_section_switch'] : false;
$port_sec = (isset($nokri['portfolio_section_switch'])) ? $nokri['portfolio_section_switch'] : false;
$soc_sec = (isset($nokri['social_section_switch'])) ? $nokri['social_section_switch'] : false;
$loc_sec = (isset($nokri['cand_loc_switch'])) ? $nokri['cand_loc_switch'] : false;
$cust_sec = (isset($nokri['cand_custom_switch'])) ? $nokri['cand_custom_switch'] : false;
$hours_sec = (isset($nokri['cand_hours_swicth'])) ? $nokri['cand_hours_swicth'] : false;


/* Custom feilds for registration */
$custom_feilds_html = $custom_feilds_cand = '';
$custom_feild_txt = (isset($nokri['user_custom_feild_txt'])) ? $nokri['user_custom_feild_txt'] : '';
$custom_feild_id = (isset($nokri['custom_registration_feilds'])) ? $nokri['custom_registration_feilds'] : '';

$is_access = (isset($nokri['cand_custom_fields_switch'])) ? $nokri['cand_custom_fields_switch'] : true;
if ($is_access) {
    if ($custom_feild_id != '') {
        $custom_feilds_html = nokri_get_custom_feilds($user_crnt_id, 'Registration', $custom_feild_id, true);
    }

    /* Custom feilds for Candidate */
    $custom_feild_cand = (isset($nokri['custom_candidate_feilds'])) ? $nokri['custom_candidate_feilds'] : '';
    if ($custom_feild_cand != '') {
        $custom_feilds_cand = nokri_get_custom_feilds($user_crnt_id, 'Candidate', $custom_feild_cand, true);
    }
}
/* required message */
$req_mess = esc_html__('This value is required', 'nokri');
$cand_video_resume_switch = isset($nokri['cand_video_resume_switch']) ? $nokri['cand_video_resume_switch'] : false;
$cand_video_covers_switch = isset($nokri['cand_video_covers_switch']) ? $nokri['cand_video_covers_switch'] : false;
?>
<form id="candidate-profile" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" id="country_level" name="country_level" value="<?php echo esc_attr($levelz); ?>" />
    <div class="cp-loader"></div>
    <!-- Candidate Personal Information -->
    <div class="main-body">
        <div class="dashboard-edit-profile">
            <h4 class="dashboard-heading"><?php echo nokri_feilds_label('cand_prof_sec_label', esc_html__('Personal Information', 'nokri')); ?> </h4>
            <div class="row">
                <div class="col-md-6 col-xs-12 col-sm-6">  
                    <div class="form-group">
                        <label class=""><?php echo nokri_feilds_label('cand_name_label', esc_html__('Your Full Name', 'nokri')); ?></label>
                        <input autocomplete="off" data-parsley-error-message="<?php echo esc_html__('Enter Your Name', 'nokri'); ?>" type="text"  required  class="form-control" value="<?php echo esc_attr($user_info->display_name); ?>" name="cand_name" placeholder="<?php echo esc_html__('Write Full Name', 'nokri'); ?>">
                    </div>
                </div>
                <?php if (nokri_feilds_operat('cand_profession_setting', 'show')) { ?>
                    <div class="col-md-6 col-xs-12 col-sm-6"> 
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_profession_label', esc_html__('Profession', 'nokri')); ?></label>
                            <input type="text"  value="<?php echo get_user_meta($user_crnt_id, '_user_headline', true); ?>" name="cand_headline" class="form-control" <?php echo nokri_feilds_operat('cand_profession_setting', 'required'); ?> placeholder="<?php echo nokri_feilds_label('cand_profession_plc', esc_html__('e.g. Web Developer', 'nokri')); ?>" data-parsley-error-message="<?php echo esc_html($req_mess); ?>">
                        </div>
                    </div>
                <?php }
                ?>
                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class=""><?php echo esc_html__('Email', 'nokri'); ?></label>
                        <input type="email" value="<?php echo '' . $user_info->user_email; ?>" name="cand_email" class="form-control" disabled placeholder="<?php echo esc_html__('candidate@example.com', 'nokri'); ?>">
                    </div>
                </div>
                <?php
                if (nokri_feilds_operat('cand_phone_setting', 'show')) {

                    /* Firebase Phone number Verification */
                    $numberVer = '';
                    $fbProjectID = isset($nokri['firebase_project_id']) ? $nokri['firebase_project_id'] : '';
                    $fbAppID = isset($nokri['firebase_app_id']) ? $nokri['firebase_app_id'] : '';
                    $fbSenderID = isset($nokri['firebase_sender_id']) ? $nokri['firebase_sender_id'] : '';
                    $fbApiKey = isset($nokri['firebase_api_key']) ? $nokri['firebase_api_key'] : '';
                    ?>
                    <input type="hidden" id="sb-fb-projectid" value="<?php echo esc_html($fbProjectID); ?>" />
                    <input type="hidden" id="sb-fb-appid" value="<?php echo esc_html($fbAppID); ?>" />
                    <input type="hidden" id="sb-fb-senderid" value="<?php echo esc_html($fbSenderID); ?>" />
                    <input type="hidden" id="sb-fb-apikey" value="<?php echo esc_html($fbApiKey); ?>" />
                    <input type="hidden" id="verification-notice" value="<?php echo esc_html__('Verification code has been sent successfully to', 'nokri'); ?>" />
                    <input type="hidden" id="verification-confirmation" value="<?php echo esc_html__('Your number has been verified successfully', 'nokri'); ?>" />

                    <!-- The core Firebase JS SDK is always required and must be listed first -->
                    <script type='text/javascript' src='https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js?ver=5.7.2' id='firebase-app-js'></script>
                    <script type='text/javascript' src='https://www.gstatic.com/firebasejs/8.3.2/firebase-analytics.js?ver=5.7.2' id='firebase-analytics-js'></script>
                    <script type='text/javascript' src='https://www.gstatic.com/firebasejs/8.3.2/firebase-auth.js?ver=5.7.2' id='firebase-auth-js'></script>
                    <?php
                    $verified_pho = get_user_meta($user_crnt_id, '_sb_verified_contact', true);
                    $phoneNo = get_user_meta($user_crnt_id, '_sb_contact', true);
                    if ($phoneNo == '') {

                        delete_user_meta($user_crnt_id, '_sb_verified_contact',);
                    }
                    $fbAllowed = isset($nokri['firebase_switch']) ? $nokri['firebase_switch'] : false;
                    if ($fbAllowed == true) {

                        if ($phoneNo == '' && $verified_pho == '') {
                            ?>                               
                            <div class="col-md-6 col-xs-12 col-sm-6 numberr_field">
                                <div class="form-group">
                                    <label class=""><?php echo esc_html__('Phone Number(+16505551234)', 'nokri'); ?> </label>

                                    <input type="text" name="user-otp-num" id="user-otp-num" data-parsley-error-message="<?php echo esc_html__('Please Verify your phone number eg +16505551234', 'nokri'); ?>"   placeholder="<?php echo nokri_feilds_label('emp_phone_plc', esc_html__('Verify your phone number with country code', 'nokri')); ?>" value="" class="form-control" <?php echo nokri_feilds_operat('emp_phone_setting', 'required'); ?>>                       
                                </div> 
                                <div id="firebase-recaptcha"></div>
                                <input type="button" id="sb-verify-phone-firebase" value="<?php echo esc_html__('Send Code', 'nokri'); ?>" class="btn n-btn-flat">

                            </div>
                            <div class="col-md-6 col-xs-12 col-sm-6 codee_field">
                                <div class="form-group">
                                    <label class=""><?php echo esc_html__('Verification Code*', 'nokri'); ?> </label>
                                    <input type="text" name="sb_reg_contact" id="sb_ph_number_code" data-parsley-error-message="<?php echo esc_html__('Please Verify your phone number with code', 'nokri'); ?>"   placeholder="<?php echo nokri_feilds_label('emp_phone_plc', esc_html__('Please Enter mobile verification code', 'nokri')); ?>" value="" class="form-control" <?php echo nokri_feilds_operat('emp_phone_setting', 'required'); ?>>
                                </div>
                                <input type="button" id="sb_verify_otp" value="<?php echo esc_html__('Verify Code', 'nokri'); ?>" class="btn n-btn-flat">
                            </div>
                        <?php } elseif ($verified_pho != $phoneNo) {
                            ?>
                            <div class="col-md-6 col-xs-12 col-sm-6 numberr_field">
                                <div class="form-group">
                                    <label class=""><?php echo esc_html__('Phone Number(+16505551234)', 'nokri'); ?> </label>

                                    <input type="text" name="user-otp-num" id="user-otp-num" data-parsley-error-message="<?php echo esc_html__('Please Verify your phone number eg +16505551234', 'nokri'); ?>"   placeholder="<?php echo nokri_feilds_label('emp_phone_plc', esc_html__('Verify your phone number with country code', 'nokri')); ?>" value="" class="form-control" <?php echo nokri_feilds_operat('emp_phone_setting', 'required'); ?>>                       
                                </div> 
                                <div id="firebase-recaptcha"></div>
                                <input type="button" id="sb-verify-phone-firebase" value="<?php echo esc_html__('Send Code', 'nokri'); ?>" class="btn n-btn-flat">

                            </div>
                            <div class="col-md-6 col-xs-12 col-sm-6 codee_field">
                                <div class="form-group">
                                    <label class=""><?php echo esc_html__('Verification Code*', 'nokri'); ?> </label>
                                    <input type="text" name="sb_reg_contact" id="sb_ph_number_code" data-parsley-error-message="<?php echo esc_html__('Please Verify your phone number with code', 'nokri'); ?>"   placeholder="<?php echo nokri_feilds_label('emp_phone_plc', esc_html__('Please Enter mobile verification code', 'nokri')); ?>" value="" class="form-control" <?php echo nokri_feilds_operat('emp_phone_setting', 'required'); ?>>
                                </div>
                                <input type="button" id="sb_verify_otp" value="<?php echo esc_html__('Verify Code', 'nokri'); ?>" class="btn n-btn-flat">
                            </div>

                            <?php
                        } else {
                            $numberVer = nokri_firebase_verified_number($user_crnt_id);
                        }
                    }
                    if ($fbAllowed == true && $numberVer != '') {
                        ?>
                        <div class="col-md-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label class=""><?php echo nokri_feilds_label('cand_phone_label', esc_html__('Phone', 'nokri')); ?></label>
                                <label class=""><?php echo esc_html($numberVer); ?></label>
                                <input type="text" data-parsley-error-message="<?php echo esc_html__('Should be in digits', 'nokri'); ?>" <?php echo nokri_feilds_operat('cand_phone_setting', 'required'); ?>    value="<?php echo get_user_meta($user_crnt_id, '_sb_contact', true); ?>"  name="cand_phone" class="form-control" placeholder="<?php echo nokri_feilds_label('cand_phone_plc', esc_html__('Contact number without space', 'nokri')); ?>">
                            </div>
                        </div>
                        <?php
                    } elseif ($fbAllowed == true && $numberVer == '') {
                        
                    } else {
                        ?>                 
                        <div class="col-md-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label class=""><?php echo nokri_feilds_label('cand_phone_label', esc_html__('Phone', 'nokri')); ?></label>
                                <input type="text" data-parsley-error-message="<?php echo esc_html__('Should be in digits', 'nokri'); ?>" <?php echo nokri_feilds_operat('cand_phone_setting', 'required'); ?>    value="<?php echo get_user_meta($user_crnt_id, '_sb_contact', true); ?>"  name="cand_phone" class="form-control" placeholder="<?php echo nokri_feilds_label('cand_phone_plc', esc_html__('Contact number without space', 'nokri')); ?>">
                            </div>
                        </div>
                        <?php
                    }
                } if (nokri_feilds_operat('cand_gend_setting', 'show')) {
                    ?>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_gend_label', esc_html__('Gender', 'nokri')); ?></label>
                            <select  class="select-generat form-control" name="cand_gender" <?php echo nokri_feilds_operat('cand_gend_setting', 'required'); ?>>
                                <option value="male" <?php
                                if ($cand_gender == 'male') {
                                    echo "selected";
                                };
                                ?>><?php echo esc_html__('Male', 'nokri'); ?></option>
                                <option value="female" <?php
                                if ($cand_gender == 'female') {
                                    echo "selected";
                                };
                                ?>><?php echo esc_html__('Female', 'nokri'); ?></option>
                                <option value="other" <?php
                                if ($cand_gender == 'other') {
                                    echo "selected";
                                };
                                ?>><?php echo esc_html__('Other', 'nokri'); ?></option>
                            </select>
                        </div>
                    </div>
                <?php } if (nokri_feilds_operat('cand_dob_setting', 'show')) { ?>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label><?php echo nokri_feilds_label('cand_dob_label', esc_html__('Date Of Birth', 'nokri')); ?></label>
                            <input type="text"   value="<?php echo nokri_candidate_user_meta('_cand_dob'); ?>" name="cand_dob" class="datepicker-cand-dob form-control" <?php echo nokri_feilds_operat('cand_dob_setting', 'required'); ?>  />
                        </div>
                    </div>
                <?php } if (nokri_feilds_operat('cand_dp_setting', 'show')) { ?>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_dp_label', esc_html__('Profile Image', 'nokri')); ?></label>
                            <input id="imgdp" name="candidate_dp[]" type="file" class="candidate_files-data file form-control" data-show-preview="false" data-allowed-file-extensions='["jpg", "png", "jpeg"]' data-show-upload="false" >
                        </div>
                    </div>
                <?php } if (nokri_feilds_operat('cand_cover_setting', 'show')) { ?>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_cover_label', esc_html__('Cover Image', 'nokri')); ?></label>
                            <input id="input-b1" name="my_cover_upload[]" type="file" class="file form-control sb_cover-data" data-show-preview="false" data-allowed-file-extensions='["jpg", "png", "jpeg"]' data-show-upload="false">
                        </div>
                    </div>
                <?php } if (nokri_feilds_operat('cand_exper_setting', 'show')) { ?>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_exper_label', esc_html__('Experience', 'nokri')); ?></label>
                            <select   class="select-generat form-control"  name="cand_experience" <?php echo nokri_feilds_operat('cand_exper_setting', 'required'); ?>>
                                <?php echo nokri_job_post_taxonomies('job_experience', $cand_experience); ?>
                            </select>
                        </div>
                    </div>
                <?php } if (nokri_feilds_operat('cand_level_setting', 'show')) { ?>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_level_label', esc_html__('Level', 'nokri')); ?></label>
                            <select   class="select-generat form-control"  name="cand_level" <?php echo nokri_feilds_operat('cand_level_setting', 'required'); ?>>
                                <?php echo nokri_job_post_taxonomies('job_level', $cand_level); ?>
                            </select>
                        </div>
                    </div>
                <?php } if (nokri_feilds_operat('cand_quali_setting', 'show')) { ?>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_quali_label2', esc_html__('Qualification', 'nokri')); ?></label>
                            <select   class="select-generat form-control"  name="cand_qualification" <?php echo nokri_feilds_operat('cand_quali_setting', 'required'); ?>>
                                <?php echo nokri_job_post_taxonomies('job_qualifications', $cand_qualification); ?>
                            </select>
                        </div>
                    </div>
                <?php } if (nokri_feilds_operat('cand_type_setting', 'show')) { ?>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_type_label', esc_html__('Type', 'nokri')); ?></label>
                            <select   class="select-generat form-control"  name="cand_type" <?php echo nokri_feilds_operat('cand_type_setting', 'required'); ?>>
                                <?php echo nokri_job_post_taxonomies('job_type', $cand_type); ?>
                            </select>
                        </div>
                    </div>
                <?php } if (nokri_feilds_operat('cand_salary_type_setting', 'show')) { ?>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_salary_type_label', esc_html__('Salary Type', 'nokri')); ?></label>
                            <select   class="select-generat form-control"  name="cand_salary_type" <?php echo nokri_feilds_operat('cand_salary_type_setting', 'required'); ?>>
                                <?php echo nokri_job_post_taxonomies('job_salary_type', $cand_salary_type); ?>
                            </select>
                        </div>
                    </div>
                <?php } if (nokri_feilds_operat('cand_salary_range_setting', 'show')) {
                    ?>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_salary_range_label', esc_html__('Salary Range', 'nokri')); ?></label>
                            <select   class="select-generat form-control"  name="cand_salary" <?php echo nokri_feilds_operat('cand_salary_range_setting', 'required'); ?>>
                                <?php echo nokri_job_post_taxonomies('job_salary', $cand_salary_range); ?>
                            </select>
                        </div>
                    </div>
                <?php } if (nokri_feilds_operat('cand_salary_curren_setting', 'show')) {
                    ?>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_salary_curren_label', esc_html__('Salary Currency', 'nokri')); ?></label>
                            <select   class="select-generat form-control"  name="cand_salary_currency" <?php echo nokri_feilds_operat('cand_salary_curren_setting', 'required'); ?>>
                                <?php echo nokri_job_post_taxonomies('job_currency', $cand_salary_curren); ?>
                            </select>
                        </div>
                    </div>
                <?php } if (nokri_feilds_operat('cand_prof_setting', 'show')) { ?> 
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_profile_label', esc_html__('Set your profile', 'nokri')); ?></label>
                            <select  class="select-generat form-control" name="cand_profile">
                                <option value="0"><?php echo esc_html__('Select an option', 'nokri'); ?></option>
                                <option value="pub" <?php
                                if ($cand_profile == 'pub') {
                                    echo "selected";
                                };
                                ?>><?php echo esc_html__('Public', 'nokri'); ?></option>
                                <option value="priv" <?php
                                if ($cand_profile == 'priv') {
                                    echo "selected";
                                };
                                ?>><?php echo esc_html__('Private', 'nokri'); ?></option>
                            </select>
                        </div>
                    </div>
                <?php } if (nokri_feilds_operat('cand_about_setting', 'show')) { ?>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('cand_about_label', esc_html__('About yourSelf', 'nokri')); ?></label>
                            <textarea  name="cand_intro" data-parsley-error-message="<?php echo esc_html__('Feild is required', 'nokri'); ?>" class="form-control rich_textarea" cols="30" rows="10" <?php echo nokri_feilds_operat('cand_about_setting', 'required'); ?>><?php echo nokri_candidate_user_meta('_cand_intro'); ?></textarea>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <input type="submit"  value="<?php echo nokri_feilds_label('cand_about_btn', esc_html__('Save Information', 'nokri')); ?>" class="btn n-btn-flat cand_person_save">
                    <input type="button" disabled  value="<?php echo esc_html__('Processing...', 'nokri'); ?>" class="btn n-btn-flat cand_person_pro"> 
                </div>
            </div>
        </div>
    </div>
    <!-- End Candidate Personal Information -->

    <!-- Candidate Skills-->
    <?php if ($skill_sec) { ?> 
        <div class="main-body">
            <div class="dashboard-edit-profile skills">
                <h4 class="dashboard-heading"><?php echo nokri_feilds_label('skill_section_label', esc_html__('Skills', 'nokri')); ?></h4>
                <div class="rows">
                    <div class="skills-gen content">
                        <?php
                        if (isset($cand_skills) && !empty($cand_skills) && count($cand_skills) > 0) {
                            foreach ($cand_skills as $key => $csv) {
                                $term = get_term_by('id', $csv, 'job_skills');
                                if ($term) {
                                    $skill_lavel = 10;
                                    if (isset($cand_skills_values) && is_array($cand_skills_values)) {
                                        if (array_key_exists($key, $cand_skills_values)) {
                                            $skill_lavel = $cand_skills_values[$key];
                                            ?>
                                            <div class="row group">
                                                <div class="col-md-5 col-sm-5 col-xs-12">
                                                    <div class="form-group">
                                                        <label class="">
                                                            <?php echo nokri_feilds_label('cand_skills_label', esc_html__('Select Your Skill', 'nokri')); ?>
                                                        </label>
                                                        <select class="candidate-skill-gener form-control" name="cand_skills_new[]" data-allow-clear="true" data-placeholder="<?php echo esc_html__('Select Your Skills', 'nokri'); ?>">
                                                            <option value=""><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                                            <?php echo nokri_job_post_taxonomies('job_skills', $csv); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-sm-5 col-xs-12">
                                                    <div class="form-group"> 
                                                        <label class=""><?php echo nokri_feilds_label('cand_skills_value_plc', esc_html__('Enter Your Skill Value', 'nokri')); ?></label>
                                                        <input class="form-control" type="text" name="cand_skills_val[]" data-parsley-type="number" max="100" data-parsley-error-message="<?php echo esc_html__('Digits allowed less than 100', 'nokri'); ?>" placeholder="<?php echo nokri_feilds_label('cand_skills_value_plc', esc_html__('Digits allowed less than 100', 'nokri')); ?>" value="<?php echo '' . ($skill_lavel); ?>">
                                                    </div></div>
                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <button type="button" class="btn btn-danger btnRemove">
                                                        <?php echo nokri_feilds_label('cand_skills_rem', esc_html__('Remove', 'nokri')); ?>
                                                    </button>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                        <div class="row group">
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label class="">
                                        <?php echo nokri_feilds_label('cand_skills_label', esc_html__('Select Your Skills', 'nokri')); ?>
                                    </label>
                                    <select class="candidate-skill-gener form-control" name="cand_skills_new[]">
                                        <option value="">
                                            <?php echo esc_html__('Select an option', 'nokri'); ?>
                                        </option>
                                        <?php echo nokri_candidate_skills('job_skills', ''); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label class=""><?php echo nokri_feilds_label('cand_skills_value_label', esc_html__('Select Your Skills', 'nokri')); ?></label>
                                    <input class="form-control" type="text" name="cand_skills_val[]" data-parsley-type="number" max="100" data-parsley-error-message="<?php echo esc_html__('Digits allowed less than 100', 'nokri'); ?>" placeholder="<?php echo nokri_feilds_label('cand_skills_value_plc', esc_html__('Digits allowed less than 100', 'nokri')); ?>">
                                </div></div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <button type="button" class="btn btn-danger btnRemove">
                                    <?php echo nokri_feilds_label('cand_skills_rem', esc_html__('Remove', 'nokri')); ?>
                                </button>
                            </div>
                        </div>
                        <div class="skills-btn-postion">
                            <div class="col-md-12">
                                <div class="row">
                                    <button type="button" id="btnAdd-2" class="btn btn-success">
                                        <?php echo nokri_feilds_label('cand_skills_add', esc_html__('Add Skills', 'nokri')); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12"> 
                        <input type="submit" value="<?php echo nokri_feilds_label('cand_skills_btn', esc_html__('Save Skills', 'nokri')); ?>" class="btn n-btn-flat">
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- Candidate Skills End --> 
    <?php if ($res_sec) { ?>                            
        <!-- Candidate Resume Uplaoad -->
        <div class="main-body">
            <div class="dashboard-edit-profile" id="add-resume">
                <h4 class="dashboard-heading"><?php echo nokri_feilds_label('resume_section_label', esc_html__('Add Resumes', 'nokri')); ?></h4>
                <div class="row">
                    <?php if (nokri_feilds_operat('cand_resumes_setting', 'show')) { ?> 
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="control-label">
                                    <?php echo nokri_feilds_label('cand_resume_label', esc_html__('Drag drop or click to upload resumes against you apply for jobs', 'nokri')); ?>
                                </label>
                                <div id="dropzone_resume" class="dropzone"></div> 
                            </div>
                        </div>
                    <?php } if ($cand_video_resume_switch) { ?>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class="control-label">
                                    <?php echo nokri_feilds_label('cand_resume_label', esc_html__('   Upload Reusmes Video', 'nokri')); ?>
                                </label>
                                <div id="ad_vidoe_dropzone" class="dropzone"></div> 
                                <input type="hidden"  id="video_logo_url" value="<?php echo trailingslashit(get_template_directory_uri()) . 'images/video-player.png'; ?>">
                            </div>
                        </div>
                    <?php } else if (nokri_feilds_operat('cand_video_resume_setting', 'show')) { ?>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label><?php echo nokri_feilds_label('cand_video_resume_label', esc_html__('Put your video resume link (only youtube)', 'nokri')); ?></label> 
                                <input type="text" placeholder="<?php echo nokri_feilds_label('cand_video_resume_plc', esc_html__('Put your video resume link (only youtube)', 'nokri')); ?>" value="<?php echo nokri_candidate_user_meta('_cand_intro_vid'); ?>" name="cand_intro_video" class="form-control youTubeUrl" >
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <input type="submit" value="<?php echo nokri_feilds_label('cand_resume_btn', esc_html__('Save Resume', 'nokri')); ?>" class="btn n-btn-flat cand_person_save">
                        <input type="button" disabled  value="<?php echo esc_html__('Processing...', 'nokri'); ?>" class="btn n-btn-flat cand_person_pro">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Candidate Resume Upload --> 
    <?php } if ($edu_sec) { ?>                        
        <!-- Candidate Education -->                           
        <div class="main-body">
            <div class="dashboard-edit-profile for-edus">
                <h4 class="dashboard-heading"><?php echo nokri_feilds_label('education_section_label', esc_html__('Educational Details', 'nokri')); ?></h4>
                <div class="row">
                    <?php
                    $cand_education = get_user_meta($user_crnt_id, '_cand_education', true);
                    $cand_education = ( $cand_education ) ? $cand_education : array('1');
                    $c = 1;
                    $counter = 0;
                    if ($cand_education) {
                        foreach ($cand_education as $edu) {

                            $removeBtn = '';
                            if ($c != 1) {
                                $removeBtn = '<div class="input-group-btn remove-btn"><button class="btn btn-danger" type="button" onclick="remove_education_fields(' . $c . ');"> <span class="ti-minus" aria-hidden="true"></span>' . esc_html__('Remove', 'nokri') . '</button></div>';
                            }
                            $removeClass = ( $c != 1 ) ? 'removeclass_edu' . $c : '';
                            $degree_name = (isset($edu['degree_name']) ) ? esc_html($edu['degree_name']) : '';
                            $degree_institute = (isset($edu['degree_institute']) ) ? esc_html($edu['degree_institute']) : '';
                            $degree_start = (isset($edu['degree_start']) ) ? esc_html($edu['degree_start']) : '';
                            $degree_end = (isset($edu['degree_end']) ) ? esc_html($edu['degree_end']) : '';
                            $degree_percent = (isset($edu['degree_percent']) ) ? esc_html($edu['degree_percent']) : '';
                            $degree_grade = (isset($edu['degree_grade']) ) ? esc_html($edu['degree_grade']) : '';
                            $degree_detail = (isset($edu['degree_detail']) ) ? ($edu['degree_detail']) : '';
                            ?>
                            <div class="ad-more-box-single <?php echo esc_attr($removeClass); ?>">
                                <?php if ($c > 1) { ?>
                                    <div class="col-md-12 col-sm-12" ><h4 class="dashboard-heading"><?php echo esc_html__('Education Additional Field', 'nokri') . " " . esc_html($counter); ?></h4></div>
                                <?php } ?>
                                <div class="col-md-6 col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            <?php echo nokri_feilds_label('cand_quali_label', esc_html__('Qualification Title', 'nokri')); ?><span class="required">*</span>
                                        </label>
                                        <input type="text" placeholder="<?php echo nokri_feilds_label('cand_quali_plc', esc_html__('Degree Title', 'nokri')); ?>"  name="cand_education['degree_name'][]" class="form-control" value="<?php echo esc_html($degree_name); ?>" <?php echo nokri_feilds_operat('cand_quali_title', 'required'); ?>>
                                    </div>
                                </div>
                                <?php if (nokri_feilds_operat('cand_quali_inst', 'show')) { ?>
                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label>
                                                <?php echo nokri_feilds_label('cand_inst_label', esc_html__('Institute Name', 'nokri')); ?>
                                            </label>
                                            <input type="text"  placeholder="<?php echo nokri_feilds_label('cand_inst_plc', esc_html__('Institute Name', 'nokri')); ?>" name="cand_education['degree_institute'][]" class="form-control" value="<?php echo esc_html($degree_institute); ?>" <?php echo nokri_feilds_operat('cand_quali_inst', 'required'); ?>>
                                        </div>
                                    </div>
                                <?php } if (nokri_feilds_operat('cand_quali_start', 'show')) { ?>
                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="">
                                                <?php echo nokri_feilds_label('cand_quali_start_label', esc_html__('Start Date', 'nokri')); ?>
                                            </label>
                                            <input type="text"  name="cand_education['degree_start'][]" <?php echo nokri_feilds_operat('cand_quali_start', 'required'); ?> value="<?php echo esc_html($degree_start); ?>" class="datepicker-here-canidate form-control date-start" data-date-input='start-date-<?php echo '' . $c; ?>'/>
                                        </div>
                                    </div>
                                <?php } if (nokri_feilds_operat('cand_quali_end', 'show')) { ?>
                                    <div class="col-md-6 col-xs-12 col-sm-6 last-end-date">
                                        <div class="form-group">
                                            <label class="">
                                                <?php echo nokri_feilds_label('cand_quali_end_label', esc_html__('End Date', 'nokri')); ?>
                                            </label>
                                            <input type="text"   value="<?php echo esc_html($degree_end); ?>" name="cand_education['degree_end'][]" <?php echo nokri_feilds_operat('cand_quali_end', 'required'); ?> class="datepicker-here-canidate1 form-control date-end " data-date-input='end-date-<?php echo '' . $c; ?>' />
                                        </div>
                                    </div>
                                <?php } if (nokri_feilds_operat('cand_quali_percent', 'show')) { ?>
                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label>
                                                <?php echo nokri_feilds_label('cand_quali_percent_label', esc_html__('Percentage', 'nokri')); ?>
                                            </label>
                                            <input type="text"  data-parsley-pattern="/([0-9]{1,}\.[0-9]{1,})/"  data-parsley-error-message="<?php echo esc_html__('Should Be In Decimals ', 'nokri'); ?>"  placeholder="<?php echo nokri_feilds_label('cand_quali_percent_plc', esc_html__('Only digits allowed without % sign e.g 80.0', 'nokri')); ?>" name="cand_education['degree_percent'][]" class="form-control" value="<?php echo esc_html($degree_percent); ?>" <?php echo nokri_feilds_operat('cand_quali_end', 'required'); ?>>
                                        </div>
                                    </div>
                                <?php } if (nokri_feilds_operat('cand_quali_grades', 'show')) { ?>
                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label>
                                                <?php echo nokri_feilds_label('cand_quali_grades_label', esc_html__('Grades', 'nokri')); ?>
                                            </label>
                                            <input type="text" placeholder="<?php echo nokri_feilds_label('cand_quali_grades_plc', esc_html__('Only Grade Letter e.g A+,B,C', 'nokri')); ?>" name="cand_education['degree_grade'][]" class="form-control" value="<?php echo esc_html($degree_grade); ?>" <?php echo nokri_feilds_operat('cand_quali_grades', 'required'); ?>>
                                        </div>
                                    </div>
                                <?php } if (nokri_feilds_operat('cand_quali_desc', 'show')) { ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>
                                                <?php echo nokri_feilds_label('cand_quali_desc_label', esc_html__('Description', 'nokri')); ?>
                                            </label>
                                            <textarea rows="6" class="form-control rich_textarea" name="cand_education['degree_detail'][]" <?php echo nokri_feilds_operat('cand_quali_desc', 'required'); ?> ><?php echo '' . ($degree_detail); ?></textarea>
                                        </div>
                                    </div>
                                <?php } echo "" . $removeBtn; ?>
                            </div>
                            <?php
                            $c++;
                            ++$counter;
                        }
                    }
                    ?>
                    <div class="clearfix"></div>
                    <div class="ad_more_box"> 
                        <div id="education_fields"></div>
                        <div class="input-group-btn ad-more-btn">
                            <button class="btn btn-success" type="button" onclick="return education_fields();"> <span class="ti-plus" aria-hidden="true"></span>
                                <?php echo nokri_feilds_label('cand_quali_add', esc_html__('Add More', 'nokri')); ?>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <input type="submit" value="<?php echo nokri_feilds_label('cand_quali_btn', esc_html__('Save Education', 'nokri')); ?>" class="btn n-btn-flat cand_person_save">
                        <input type="button" disabled  value="<?php echo esc_html__('Processing...', 'nokri'); ?>" class="btn n-btn-flat cand_person_pro">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Candidate  Education -->

        <!-- Candidate Certifications -->
    <?php } if ($cert_sec) { ?>

        <div class="main-body">
            <div class="dashboard-edit-profile for-cert">
                <h4 class="dashboard-heading"><?php echo nokri_feilds_label('certification_section_label', esc_html__('Certifications', 'nokri')); ?></h4>
                <div class="row">
                    <?php
                    $cand_certifications = get_user_meta($user_crnt_id, '_cand_certifications', true);
                    $cand_certifications = ( $cand_certifications ) ? $cand_certifications : array('1');
                    $cert = '1';
                    $counter = 0;
                    foreach ($cand_certifications as $certification) {
                        $removeBtn = '';
                        if ($cert != 1) {
                            $removeBtn = '<div class="input-group-btn remove-btn"><button class="btn btn-danger" type="button" onclick="remove_certification_fields(' . $cert . ');"> <span class="ti-minus" aria-hidden="true"></span>' . esc_html__('Remove', 'nokri') . '</button></div>';
                        }
                        $removeClass = ( $cert != 1 ) ? 'removeclass_cert' . $cert : '';
                        $certification_name = (isset($certification['certification_name']) ) ? esc_html($certification['certification_name']) : '';
                        $certification_start = (isset($certification['certification_start']) ) ? esc_html($certification['certification_start']) : '';
                        $certification_end = (isset($certification['certification_end']) ) ? esc_html($certification['certification_end']) : '';
                        $certification_duration = (isset($certification['certification_duration']) ) ? esc_html($certification['certification_duration']) : '';
                        $certification_institute = (isset($certification['certification_institute']) ) ? esc_html($certification['certification_institute']) : '';
                        $certification_desc = (isset($certification['certification_desc']) ) ? ($certification['certification_desc']) : '';
                        ?>
                        <div class="ad-more-box-single <?php echo esc_attr($removeClass); ?>">
                            <?php if ($cert > 1) { ?>
                                <div class="col-md-12 col-sm-12"><h4 class="dashboard-heading"><?php
                                        echo nokri_feilds_label('cand_exper_add_new', esc_html__('Certification Additional Field', 'nokri')) . " " . esc_html($counter);
                                        ;
                                        ?></h4></div>
                            <?php } ?>
                            <div class="col-md-12 col-sm-12 col-sm-12">
                                <div class="form-group ">
                                    <label><?php echo nokri_feilds_label('cand_certi_label', esc_html__('Certification Title', 'nokri')); ?><span class="required">*</span></label>
                                    <input type="text" placeholder="<?php echo nokri_feilds_label('cand_certi_plc', esc_html__('Certification Title', 'nokri')); ?>" name="cand_certifications['certification_name'][]" class="form-control" value="<?php echo esc_html($certification_name); ?>" <?php echo nokri_feilds_operat('cand_certi_start', 'required'); ?>>
                                </div>
                            </div>
                            <?php if (nokri_feilds_operat('cand_certi_start', 'show')) { ?>
                                <div class="col-md-6 col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label class=""><?php echo nokri_feilds_label('cand_certi_start_label', esc_html__('Certification Start Date', 'nokri')); ?></label>
                                        <input type="text" name="cand_certifications['certification_start'][]" value="<?php echo esc_html($certification_start); ?>" <?php echo nokri_feilds_operat('cand_certi_start', 'required'); ?> class="datepicker-here-canidate form-control date-start" data-date-input='start-date-<?php echo '' . $c; ?>'   />
                                    </div>
                                </div>
                            <?php } if (nokri_feilds_operat('cand_certi_end', 'show')) { ?>
                                <div class="col-md-6 col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label class=""><?php echo nokri_feilds_label('cand_certi_end_label', esc_html__('Certification End Date', 'nokri')); ?></label>
                                        <input type="text" value="<?php echo esc_html($certification_end); ?>" name="cand_certifications['certification_end'][]" <?php echo nokri_feilds_operat('cand_certi_end', 'required'); ?> class="datepicker-here-canidate form-control date-end" data-date-input='end-date-<?php echo '' . $c; ?>'   />
                                    </div>
                                </div>
                            <?php } if (nokri_feilds_operat('cand_certi_dur', 'show')) { ?>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('cand_certi_dur_label', esc_html__('Certification Duration', 'nokri')); ?></label>
                                        <input type="text" value="<?php echo esc_html($certification_duration); ?>"  placeholder="<?php echo nokri_feilds_label('cand_certi_dur_plc', esc_html__('Certification Duration', 'nokri')); ?>" name="cand_certifications['certification_duration'][]"  class="form-control" <?php echo nokri_feilds_operat('cand_certi_dur', 'required'); ?>>
                                    </div>
                                </div>
                            <?php } if (nokri_feilds_operat('cand_certi_inst', 'show')) { ?>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('cand_certi_inst_label', esc_html__('Certification Institute', 'nokri')); ?></label>
                                        <input type="text" value="<?php echo esc_html($certification_institute); ?>" placeholder="<?php echo nokri_feilds_label('cand_certi_inst_plc', esc_html__('Certification Institute', 'nokri')); ?>" name="cand_certifications['certification_institute'][]"  class="form-control" <?php echo nokri_feilds_operat('cand_certi_inst', 'required'); ?>>
                                    </div>
                                </div>
                            <?php } if (nokri_feilds_operat('cand_certi_desc', 'show')) { ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('cand_quali_certi_label', esc_html__('Description', 'nokri')); ?></label>
                                        <textarea rows="6" class="form-control rich_textarea"  name="cand_certifications['certification_desc'][]"  <?php echo nokri_feilds_operat('cand_certi_desc', 'required'); ?>><?php echo '' . ($certification_desc); ?></textarea>
                                    </div>
                                </div>
                            <?php } echo "" . $removeBtn; ?>
                        </div>
                        <?php
                        $cert++;
                        $counter++;
                    }
                    ?>
                    <div class="clearfix"></div>
                    <div class="ad_more_box">   
                        <div id="certification_fields"></div>
                        <div class="input-group-btn ad-more-btn">
                            <button class="btn btn-success" type="button"  onclick="return certification_fields();"> <span class="ti-plus" aria-hidden="true"></span><?php echo nokri_feilds_label('cand_exper_add', esc_html__('Add More', 'nokri')); ?></button>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <input type="submit" value="<?php echo nokri_feilds_label('cand_certi_btn', esc_html__('Save Certifications', 'nokri')); ?>" class="btn n-btn-flat cand_person_save">
                        <input type="button" disabled  value="<?php echo esc_html__('Processing...', 'nokri'); ?>" class="btn n-btn-flat cand_person_pro">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Candidate Certifications-->
    <?php } if ($prof_sec) { ?>

        <!-- Candidate Professions -->                           
        <div class="main-body">
            <div class="dashboard-edit-profile for-pros">
                <h4 class="dashboard-heading"><?php echo nokri_feilds_label('experience_section_label', esc_html__('Job experience', 'nokri')); ?></h4>
                <div class="row">
                    <?php
                    $cand_profession = get_user_meta($user_crnt_id, '_cand_profession', true);
                    $cand_profession = ( $cand_profession ) ? $cand_profession : array('1');
                    $c = 1;

                    if ($cand_profession) {
                        $counter = 0;
                        foreach ($cand_profession as $profession) {
                            $removeBtn = '';
                            if ($c != 1) {
                                $removeBtn = '<div class="input-group-btn remove-btn"><button class="btn btn-danger" type="button" onclick="remove_professional_fields(' . $c . ');"><span class="ti-minus" aria-hidden="true"></span>' . esc_html__('Remove', 'nokri') . '</button></div>';
                            }
                            $removeClass = ( $c != 1 ) ? 'removeclass_pro' . $c : '';
                            $project_name = (isset($profession['project_name']) ) ? esc_html($profession['project_name']) : '';

                            $project_start = (isset($profession['project_start']) ) ? esc_html($profession['project_start']) : '';
                            $project_end = (isset($profession['project_end']) && $profession['project_end'] != "" ) ? esc_html($profession['project_end']) : '';
                            $project_role = (isset($profession['project_role']) ) ? esc_html($profession['project_role']) : '';
                            $project_organization = (isset($profession['project_organization']) ) ? esc_html($profession['project_organization']) : '';
                            $project_detail = (isset($profession['project_desc']) ) ? ($profession['project_desc']) : '';

                            $hide_class = '';

                            $tweek_class = '';
                            if ($project_name == 1) {
                                $tweek_class = 'checked="checked"';
                            }
                            if ($project_end == '' && $project_name == 1) {
                                $hide_class = 'readonly="readonly"';
                            }
                            ?> 
                            <div class="ad-more-box-single <?php echo esc_attr($removeClass); ?>">
                                <?php if ($c > 1) { ?>
                                    <div class="col-md-12 col-sm-12"><h4 class="dashboard-heading"><?php echo nokri_feilds_label('cand_exper_add_new', esc_html__('Professional Additional Field', 'nokri')) . " " . esc_html($counter); ?></h4></div>
                                <?php } ?>
                                <div class="col-md-6 col-sm-6 col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('cand_org_label', esc_html__('Organization Name', 'nokri')); ?><span class="required">*</span></label>
                                        <input type="text"  value="<?php echo esc_html($project_organization); ?>" placeholder="<?php echo nokri_feilds_label('cand_org_plc', esc_html__('Organization Name', 'nokri')); ?>" name="cand_profession['project_organization'][]"  class="form-control" <?php echo nokri_feilds_operat('cand_quali_desc', 'required'); ?>>
                                    </div>
                                </div>
                                <?php if (nokri_feilds_operat('cand_exper_role', 'show')) { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label><?php echo nokri_feilds_label('cand_exper_role_label', esc_html__('Your Role', 'nokri')); ?></label>
                                            <input type="text" value="<?php echo esc_html($project_role); ?>"  placeholder="<?php echo nokri_feilds_label('cand_exper_role_plc', esc_html__('Software Engineer Etc', 'nokri')); ?>" name="cand_profession['project_role'][]"  class="form-control" <?php echo nokri_feilds_operat('cand_exper_role', 'required'); ?>>
                                        </div>
                                    </div>
                                <?php } if (nokri_feilds_operat('cand_exper_start', 'show')) { ?>
                                    <div class="col-md-6 col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class=""><?php echo nokri_feilds_label('cand_exper_start_label', esc_html__('Job start Date', 'nokri')); ?></label>
                                            <input  type="text"  name="cand_profession['project_start'][]" value="<?php echo esc_html($project_start); ?>" <?php echo nokri_feilds_operat('cand_exper_start', 'required'); ?> class="datepicker-here-canidate form-control date-start" data-date-input='start-date-<?php echo '' . $c; ?>'  />
                                        </div>
                                    </div>
                                <?php } if (nokri_feilds_operat('cand_exper_end', 'show')) { ?>
                                    <div class="col-md-6 col-xs-12 col-sm-6"> 
                                        <div class="form-group " >
                                            <label class="end-hide"><?php echo nokri_feilds_label('cand_exper_end_label', esc_html__('Job End Date', 'nokri')); ?></label>
                                            <input type="text"  value="<?php echo esc_html($project_end); ?>" name="cand_profession['project_end'][]" <?php echo nokri_feilds_operat('cand_exper_end', 'required'); ?>  class="datepicker-here-canidate form-control end-hide date-end"   <?php echo '' . ($hide_class); ?>  data-date-input='end-date-<?php echo '' . $c; ?>'  />

                                            <input type="hidden"  value="<?php echo esc_html($project_name); ?>" name="cand_profession['project_name'][]"  class="checked-input-hide"   <?php echo '' . ($hide_class); ?>  />

                                            <input type="checkbox" name="checked" <?php echo esc_attr($tweek_class); ?>  class="icheckbox_minimal form-control" >&nbsp; <?php echo nokri_feilds_label('cand_exper_current_label', esc_html__('Are You Currently Working There?', 'nokri')); ?>
                                        </div>
                                    </div>     
                                <?php } if (nokri_feilds_operat('cand_exper_desc', 'show')) { ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label><?php echo nokri_feilds_label('cand_exper_desc_label', esc_html__('Description', 'nokri')); ?></label>
                                            <textarea rows="6" <?php echo nokri_feilds_operat('cand_exper_desc', 'required'); ?> class="form-control rich_textarea"  name="cand_profession['project_desc'][]" ><?php echo '' . ($project_detail); ?></textarea>
                                        </div>
                                    </div>
                                <?php } echo "" . $removeBtn; ?>
                            </div>
                            <?php
                            $c++;
                            $counter++;
                        }
                    }
                    ?>
                    <div class="clearfix"></div>
                    <div class="ad_more_box"> 
                        <div id="professional_fields"></div>
                        <div class="input-group-btn ad-more-btn">
                            <button class="btn btn-success" type="button"  onclick="return professional_fields();"> <span class="ti-plus" aria-hidden="true"></span><?php echo nokri_feilds_label('cand_exper_add', esc_html__('Add More', 'nokri')); ?></button>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <input type="submit" value="<?php echo nokri_feilds_label('cand_exper_btn', esc_html__('Save experience', 'nokri')); ?>" class="btn n-btn-flat cand_person_save">
                        <input type="button" disabled  value="<?php echo esc_html__('Processing...', 'nokri'); ?>" class="btn n-btn-flat cand_person_pro">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Candidate Professions-->

    <?php } if ($port_sec) { ?>
        <!-- Candidate Portfolio -->
        <div class="main-body">
            <div class="dashboard-edit-profile">
                <h4 class="dashboard-heading"><?php echo nokri_feilds_label('portfolio_section_label', esc_html__('Add Portfolio', 'nokri')); ?></h4>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="row">
                            <?php if (nokri_feilds_operat('cand_portfolio_setting', 'show')) { ?>
                                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label"><?php echo nokri_feilds_label('portfolio_section_label', esc_html__('Photos for your Projects', 'nokri')); ?></small></label>
                                        <div id="dropzone" class="dropzone"></div>
                                    </div>
                                </div>
                            <?php } if (nokri_feilds_operat('cand_portfolio_video', 'show')) { ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('cand_portfolio_video_label', esc_html__('Video url (only youtube)', 'nokri')); ?></label>
                                        <input type="text" placeholder="<?php echo nokri_feilds_label('cand_portfolio_video_plc', esc_html__('Put youtube video link', 'nokri')); ?>" value="<?php echo nokri_candidate_user_meta('_cand_video'); ?>" name="cand_video" class="form-control" <?php echo nokri_feilds_operat('cand_portfolio_video', 'required'); ?>>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <input type="submit" value="<?php echo nokri_feilds_label('cand_portfolio_btn', esc_html__('Save Portfolio', 'nokri')); ?>" class="btn n-btn-flat">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Candidate Portfolio -->
    <?php } if ($custom_feilds_html != '' || $custom_feilds_cand != '') { ?>
        <!-- Candidate Custom Feilds -->
        <div class="main-body">
            <div class="dashboard-edit-profile">
                <h4 class="dashboard-heading"><?php echo esc_html($custom_feild_txt); ?></h4>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="row">
                            <?php echo '' . $custom_feilds_html . $custom_feilds_cand; ?> 

                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <input type="submit" value="<?php echo esc_html__('Save', 'nokri'); ?>" class="btn n-btn-flat">
                </div>
            </div>
        </div>
        <!-- End Candidate Custom Feilds -->
    <?php } if ($soc_sec) { ?>
        <!-- Candidate Social Links -->
        <div class="main-body">
            <div class="dashboard-edit-profile">
                <h4 class="dashboard-heading"><?php echo nokri_feilds_label('social_section_label', esc_html__('Social Links', 'nokri')); ?></h4>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="dashboard-social-links">
                            <?php if (nokri_feilds_operat('cand_fb_setting', 'show')) { ?> 
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('cand_fb_label', esc_html__('Facebook', 'nokri')); ?></label>
                                        <input type="text" value="<?php echo nokri_candidate_user_meta('_cand_fb'); ?>"  name="cand_fb" class="form-control" placeholder="<?php echo nokri_feilds_label('cand_fb_plc', esc_html__('Facebook', 'nokri')); ?>" <?php echo nokri_feilds_operat('cand_fb_setting', 'required'); ?>>
                                    </div>
                                </div>
                            <?php } if (nokri_feilds_operat('cand_twtr_setting', 'show')) { ?>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('cand_twtr_label', esc_html__('Twitter', 'nokri')); ?></label>
                                        <input type="text" value="<?php echo nokri_candidate_user_meta('_cand_twiter'); ?>" name="cand_twiter" class="form-control" placeholder="<?php echo nokri_feilds_label('cand_twtr_plc', esc_html__('Twitter', 'nokri')); ?>" <?php echo nokri_feilds_operat('cand_twtr_setting', 'required'); ?>>
                                    </div>
                                </div>
                            <?php } if (nokri_feilds_operat('cand_linked_setting', 'show')) { ?>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('cand_linked_label', esc_html__('LinkedIn', 'nokri')); ?></label>
                                        <input type="text" value="<?php echo nokri_candidate_user_meta('_cand_linked'); ?>"  name="cand_linked"  class="form-control" placeholder="<?php echo nokri_feilds_label('cand_linked_plc', esc_html__('LinkedIn', 'nokri')); ?>" <?php echo nokri_feilds_operat('cand_linked_setting', 'required'); ?>>
                                    </div>
                                </div>
                            <?php } if (nokri_feilds_operat('cand_insta_setting', 'show')) { ?>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('cand_insta_label', esc_html__('Instagram', 'nokri')); ?></label>
                                        <input type="text" value="<?php echo nokri_candidate_user_meta('_cand_google'); ?>" name="cand_google" class="form-control" placeholder="<?php echo nokri_feilds_label('cand_insta_plc', esc_html__('Instagram', 'nokri')); ?>" <?php echo nokri_feilds_operat('cand_insta_setting', 'required'); ?>>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <input type="submit" value="<?php echo nokri_feilds_label('cand_social_btn', esc_html__('Save Profiles Links', 'nokri')); ?>" class="btn n-btn-flat cand_person_save">
                        <input type="button" disabled  value="<?php echo esc_html__('Processing...', 'nokri'); ?>" class="btn n-btn-flat cand_person_pro">
                    </div>
                </div>
            </div>
        </div>
        <!-- End Candidate Social Links --> 
    <?php } if ($loc_sec) { ?>
        <!-- Candidate Location -->
        <div class="main-body">
            <div class="dashboard-edit-profile">
                <h4 class="dashboard-heading"><?php echo nokri_feilds_label('loc_section_label', esc_html__('Location And Address', 'nokri')); ?></h4>
                <?php if ($allow_map && $is_lat_long) { ?>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="row">
                                <!-- Candidate Location -->     
                                <input type="hidden" id="is_profile_edit" value="1" />
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group"> 
                                        <label class="control-label"><?php echo nokri_feilds_label('cand_address_label', esc_html__('Set your location', 'nokri')); ?></label>
                                        <input class="form-control" name="cand_address" id="sb_user_address" value="<?php echo esc_attr($ad_mapLocation); ?>">
                                        <?php if ($mapType == 'google_map') { ?>
                                            <a href="javascript:void(0);" id="your_current_location" title="<?php echo esc_html__('You Current Location', 'nokri'); ?>"><i class="fa fa-crosshairs"></i></a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group"> 
                                        <div id="dvMap" style="width:100%; height: 300px"></div>                                            
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group"> 
                                        <label class="control-label"><?php echo nokri_feilds_label('cand_lat_label', esc_html__('Latitude', 'nokri')); ?></label>
                                        <input class="form-control" type="text" name="cand_map_lat" id="ad_map_lat" value="<?php echo esc_attr($ad_map_lat); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group"> 
                                        <label class="control-label"><?php echo nokri_feilds_label('cand_long_label', esc_html__('Longitude', 'nokri')); ?></label>
                                        <input class="form-control" name="cand_map_long" id="ad_map_long" value="<?php echo esc_attr($ad_map_long); ?>" type="text">
                                    </div>
                                </div>
                                <!-- End Candidate Location -->
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="dashboard-edit-profile">
                <?php if ($cust_sec) { ?>
                    <h4 class="dashboard-heading"><?php echo esc_html($job_country_level_heading); ?></h4>
                    <div class="row">

                        <!--job country -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label><?php echo esc_html($job_country_level_1); ?></label>
                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_html__('Select Your Country', 'nokri'); ?>" id="ad_country" name="cand_country">
                                    <option value=""><?php echo esc_html__('Select an option', 'nokri'); ?> </option>
                                    <?php echo "" . ($country_html); ?>
                                </select>

                            </div>
                        </div>
                        <!--job state -->
                        <div class="col-md-6 col-sm-6 col-xs-12" id="ad_country_sub_div" <?php
                        if ($country_states == "") {
                            echo 'style="display: none;"';
                        }
                        ?>>
                            <div class="form-group" >
                                <label><?php echo esc_html($job_country_level_2); ?></label>
                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_html__('Select State', 'nokri'); ?>" id="ad_country_states" name="cand_country_states">

                                    <?php echo "" . ($country_states); ?>
                                </select>
                            </div></div>
                        <!--job city -->
                        <div class="col-md-6 col-sm-6 col-xs-12" id="ad_country_sub_sub_div" <?php
                        if ($country_cities == "") {
                            echo 'style="display: none;"';
                        }
                        ?>>
                            <div class="form-group">
                                <label><?php echo esc_html($job_country_level_3); ?></label>
                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_html__('Select City', 'nokri'); ?>" id="ad_country_cities" name="cand_country_cities">

                                    <?php echo "" . ($country_cities); ?>
                                </select>
                            </div>
                        </div>
                        <!--job town -->
                        <div class="col-md-6 col-sm-6 col-xs-12" id="ad_country_sub_sub_sub_div" <?php
                        if ($country_towns == "") {
                            echo 'style="display: none;"';
                        }
                        ?>>
                            <div class="form-group">
                                <label><?php echo esc_html($job_country_level_4); ?></label>
                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_html__('Select Town', 'nokri'); ?>" id="ad_country_towns" name="cand_country_towns">

                                    <?php echo "" . ($country_towns); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <input type="submit" value="<?php echo nokri_feilds_label('cand_social_btn', esc_html__('Save Location', 'nokri')); ?>" class="btn n-btn-flat cand_person_save">
                    <input type="button" disabled  value="<?php echo esc_html__('Processing...', 'nokri'); ?>" class="btn n-btn-flat cand_person_pro">
                </div>


            </div>
        </div>
        <!-- End Candidate Location -->
        <?php
    }

    if ($hours_sec) {
        $days = array();
        $selected_val = 2;
        $flip_it = "";
        if (is_rtl()) {
            $flip_it = 'flip';
        }
        $listing_id = 2;

        $my_class = $class_custom_fields = 'none';

        $listing_timezone = get_user_meta($user_crnt_id, 'nokri_user_timezone', true);
        $selected_val = get_user_meta($user_crnt_id, 'nokri_business_hours', true);
        $allow_hours = get_user_meta($user_crnt_id, 'nokri_is_hours_allow', true);



        if (!empty(nokri_fetch_business_hours($user_crnt_id))) {
            $days = nokri_fetch_business_hours($user_crnt_id);
        } else {
            $dayss = nokri_week_days();
            foreach ($dayss as $key => $val) {
                $days[] = array("day_name" => $val, "start_time" => '', "end_time" => '', "closed" => '');
            }
        }
        ?>
        <div class="main-body">
            <div class="dashboard-edit-profile">
                <h4 class="dashboard-heading"><?php echo nokri_feilds_label('cand_hours_label', esc_html__('Scheduled Hours', 'nokri')); ?></h4>
                <div class="submit-listing-section for-zone l_bhours_dddddform">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="form-group has-feedback">

                                <div class="pull-right <?php echo esc_attr($flip_it); ?>">
                                    <ul class="frontend_hours list-inline">
                                        <li>
                                            <input id="na" class="input-icheck-others"  name="type_hours"  value="0" <?php echo checked(0, $selected_val, false); ?>  type="radio">
                                            <label for="na"><?php echo esc_html__('N/A', 'nokri'); ?></label>
                                        </li>
                                        <li>
                                            <input id="open" class="input-icheck-others"  name="type_hours" value="1" <?php echo checked(1, $selected_val, false); ?>  type="radio">
                                            <label for="open"> <?php echo esc_html__('Available 24/7', 'nokri'); ?></label>
                                        </li>
                                        <li>
                                            <input id="selective" class="input-icheck-others"  name="type_hours" value="2" <?php echo checked(2, $selected_val, false); ?>  type="radio">
                                            <label for="selective"> <?php echo esc_html__('Selective Hours', 'nokri'); ?></label>
                                        </li>
                                        <input type="hidden" id="hours_type" name="hours_type" value="<?php echo esc_attr($selected_val); ?>">
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group <?php echo esc_attr($my_class); ?> my-zones" id="timezone">
                                <label class="control-label"><?php echo esc_html__('Select Time zone', 'nokri') ?></label>
                                <div class="typeahead__container">
                                    <div class="typeahead__field">
                                        <div class="typeahead__query">
                                            <input id="timezones" autocomplete="off" type="search" class="myzones-t form-control" value="<?php echo esc_attr($listing_timezone); ?>" name="listing_timezome">
                                            <input type="hidden" id="theme_path" value="<?php echo trailingslashit(get_template_directory_uri()); ?>" />
                                        </div>
                                    </div> 
                                </div>
                            </div>  
                            <div id="business-hours-fields" class="<?php echo esc_attr($my_class); ?>" >
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="panel with-nav-tabs panel-info">
                                            <div class="panel-heading">
                                                <ul class="nav nav-tabs">
                                                    <?php foreach ($days as $key => $day) { ?>
                                                        <li class="<?php echo '' . ( $key == 0 ) ? 'active' : ''; ?>">
                                                            <a href="#tab1<?php echo esc_attr($key); ?>" data-toggle="tab"><?php echo esc_attr($day['day_name']); ?></a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <div class="panel-body">
                                                <div class="tab-content">
                                                    <?php foreach ($days as $key => $day) { ?>
                                                        <div class="tab-pane fade <?php echo '' . ( $key == 0 ) ? 'in active' : ''; ?>" id="tab1<?php echo esc_attr($key); ?>">
                                                            <div class="row">
                                                                <div class="col-md-5 col-xs-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> <?php echo esc_html__('From', 'nokri'); ?> </label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="ti-time"></i></span>
                                                                            <input type="text" class="for_specific_page form-control timepicker" name="from[]" id="from-<?php echo esc_attr($key); ?>" placeholder="<?php echo esc_html__('Select your business hours', 'nokri'); ?>" value="<?php echo trim(date("g:i A", strtotime($day['start_time']))); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5 col-xs-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><?php echo esc_html__('To', 'nokri'); ?></label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="ti-time"></i></span>
                                                                            <input type="text" class="for_specific_page form-control timepicker" id="to-<?php echo esc_attr($key); ?>" name="to[]" placeholder="<?php echo esc_html__('Select your business hours', 'nokri'); ?>" value="<?php echo trim(date("g:i A", strtotime($day['end_time']))); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2 col-xs-12 col-sm-2">
                                                                    <div class="form-group mt45">
                                                                        <label class="control-label"> <?php echo esc_html__('Closed', 'nokri'); ?> </label>
                                                                        <input name="is_closed[]" id="is_closed-<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($key); ?>"  type="checkbox" <?php echo '' . ( $day['closed'] == 1 ) ? 'checked="checked"' : ''; ?> class="custom-checkbox is_closed"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>  
                        </div>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <input type="submit" value="<?php echo esc_attr__('Save Hours', 'nokri') ?>" class="btn n-btn-flat cand_person_save">
                            <input type="button" disabled="" value="<?php echo esc_attr__('Processing.....', 'nokri') ?>" class="btn n-btn-flat cand_person_pro" style="display: none;">
                        </div>
                    </div>
                </div>   

            </div>
        </div>

    <?php } ?>            

    <!-- Hidden Inputs For Candidate Portfolio -->
    <input type="hidden" id="dictFallbackMessage" value="<?php echo esc_html__('Your browser does not support drag\'n\'drop file uploads.', 'nokri'); ?>" />
    <input type="hidden" id="dictFallbackText" value="<?php echo esc_html__('Please use the fallback form below to upload your files like in the olden days.', 'nokri'); ?>" />
    <input type="hidden" id="dictFileTooBig" value="<?php echo esc_html__('File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.', 'nokri'); ?>" />
    <input type="hidden" id="dictInvalidFileType" value="<?php echo esc_html__('You can\'t upload files of this type.', 'nokri'); ?>" />
    <input type="hidden" id="dictResponseError" value="<?php echo esc_html__('Server responded with {{statusCode}} code.', 'nokri'); ?>" />
    <input type="hidden" id="dictCancelUpload" value="<?php echo esc_html__('Cancel upload', 'nokri'); ?>" />
    <input type="hidden" id="dictCancelUploadConfirmation" value="<?php echo esc_html__('Are you sure you want to cancel this upload?', 'nokri'); ?>" />
    <input type="hidden" id="dictRemoveFile" value="<?php echo esc_html__('Remove file', 'nokri'); ?>" />
    <input type="hidden" id="dictMaxFilesExceeded" value="<?php echo esc_html__('You can not upload any more files.', 'nokri'); ?>" />
    <input type="hidden" id="required_images" value="<?php echo esc_html__('Images are required.', 'nokri'); ?>" />
    <input type="hidden" id="is_candidate" name="is_update" value="<?php echo esc_attr($is_candidate); ?>" />        

</form>

<!-- update password-->  
<div class="main-body change-password">
    <div class="dashboard-edit-profile">
        <h4 class="dashboard-heading"><?php echo esc_html__('Change Password', 'nokri'); ?></h4>
        <form id="change_password" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="dashboard-location">

                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label><?php echo esc_html__('Old Password', 'nokri'); ?></label>
                                    <input type="password" class="form-control" name="old_password" placeholder="<?php echo esc_html__('Enter old password', 'nokri'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label><?php echo esc_html__('New Password', 'nokri'); ?></label>
                                    <input type="password" name="new_password" class="form-control" placeholder="<?php echo esc_html__('Enter new password', 'nokri'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <?php if ($is_acount_del) { ?>
                        <input type="button" value="<?php echo esc_html__('Delete account?', 'nokri'); ?>" class="btn btn-custom del_acount"><?php } ?>
                    <input type="submit" value="<?php echo esc_html__('Update password', 'nokri'); ?>" class="btn n-btn-flat change_password">
                    <input type="button" disabled  value="<?php echo esc_html__('Processing...', 'nokri'); ?>" class="btn n-btn-flat cand_pass_pro">
                </div>
            </div>
        </form>
    </div>
</div>

<?php
if ($mapType == 'leafletjs_map' && $is_lat_long) {
    echo '' . $lat_lon_script = '<script type="text/javascript">
	var mymap = L.map(\'dvMap\').setView([' . $ad_map_lat . ', ' . $ad_map_long . '], 13);
		L.tileLayer(\'https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png\', {
			maxZoom: 18,
			attribution: \'\'
		}).addTo(mymap);
		var markerz = L.marker([' . $ad_map_lat . ', ' . $ad_map_long . '],{draggable: true}).addTo(mymap);
		var searchControl 	=	new L.Control.Search({
			url: \'//nominatim.openstreetmap.org/search?format=json&q={s}\',
			jsonpParam: \'json_callback\',
			propertyName: \'display_name\',
			propertyLoc: [\'lat\',\'lon\'],
			marker: markerz,
			autoCollapse: true,
			autoType: true,
			minLength: 2,
		});
		searchControl.on(\'search:locationfound\', function(obj) {
			var lt	=	obj.latlng + \'\';
			var res = lt.split( "LatLng(" );
			res = res[1].split( ")" );
			res = res[0].split( "," );
			document.getElementById(\'ad_map_lat\').value = res[0];
			document.getElementById(\'ad_map_long\').value = res[1];
		});
		mymap.addControl( searchControl );
		markerz.on(\'dragend\', function (e) {
		  document.getElementById(\'ad_map_lat\').value = markerz.getLatLng().lat;
		  document.getElementById(\'ad_map_long\').value = markerz.getLatLng().lng;
		});
	</script>';
}
