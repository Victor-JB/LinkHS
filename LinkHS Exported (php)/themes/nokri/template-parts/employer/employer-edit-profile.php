<?php
global $nokri;
$user_info = wp_get_current_user();
$user_crnt_id = $user_info->ID;
$mapType = nokri_mapType();
if ($mapType == 'google_map') {
    wp_enqueue_script('google-map-callback', false);
}
$ad_mapLocation = '';
$ad_mapLocation = get_user_meta($user_crnt_id, '_emp_map_location', true);
$headline = get_user_meta($user_crnt_id, '_user_headline', true);
$ad_map_lat = get_user_meta($user_crnt_id, '_emp_map_lat', true);
$ad_map_long = get_user_meta($user_crnt_id, '_emp_map_long', true);
$emp_profile = get_user_meta($user_crnt_id, '_user_profile_status', true);
if (get_user_meta($user_crnt_id, '_emp_map_lat', true) == '') {
    $ad_map_lat = $nokri['sb_default_lat'];
}
if (get_user_meta($user_crnt_id, '_emp_map_long', true) == '') {
    $ad_map_long = $nokri['sb_default_long'];
}
nokri_load_search_countries(1);
/* Getting All Jobs */
$terms = get_terms(array('taxonomy' => 'job_category', 'hide_empty' => false, 'parent' => 0,));
/* Getting Company Search Selected radio Btn */
$comp_search = get_user_meta($user_crnt_id, '_emp_search', true);
/* Is map show */
$allow_map = isset($nokri['nokri_allow_map']) ? $nokri['nokri_allow_map'] : true;
$is_lat_long = isset($nokri['emp_map_switch']) ? $nokri['emp_map_switch'] : false;


/* Is account del option */
$is_acount_del = isset($nokri['user_profile_delete_option']) ? $nokri['user_profile_delete_option'] : false;
/* For job Location level text */
$job_country_level_heading = ( isset($nokri['job_country_level_heading']) && $nokri['job_country_level_heading'] != "" ) ? $nokri['job_country_level_heading'] : '';

$job_country_level_1 = ( isset($nokri['job_country_level_1']) && $nokri['job_country_level_1'] != "" ) ? $nokri['job_country_level_1'] : '';

$job_country_level_2 = ( isset($nokri['job_country_level_2']) && $nokri['job_country_level_2'] != "" ) ? $nokri['job_country_level_2'] : '';

$job_country_level_3 = ( isset($nokri['job_country_level_3']) && $nokri['job_country_level_3'] != "" ) ? $nokri['job_country_level_3'] : '';

$job_country_level_4 = ( isset($nokri['job_country_level_4']) && $nokri['job_country_level_4'] != "" ) ? $nokri['job_country_level_4'] : '';
/* Make location selected on update ad */
$cand_custom_loc = get_user_meta($user_crnt_id, '_emp_custom_location', true);
$levelz = count((array) $cand_custom_loc);
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
/* Hide/show section */
$detail_sec = (isset($nokri['emp_spec_switch'])) ? $nokri['emp_spec_switch'] : false;
$soc_sec = (isset($nokri['emp_social_section_switch'])) ? $nokri['emp_social_section_switch'] : false;
$loc_sec = (isset($nokri['emp_loc_switch'])) ? $nokri['emp_loc_switch'] : false;
$cust_sec = (isset($nokri['emp_custom_switch'])) ? $nokri['emp_custom_switch'] : false;
$port_sec = (isset($nokri['emp_port_switch'])) ? $nokri['emp_port_switch'] : false;
/* Custom feilds for registration */
$custom_feilds_html = $custom_feilds_emp = $custom_feild_cand = '';
$custom_feild_txt = (isset($nokri['user_custom_feild_txt'])) ? $nokri['user_custom_feild_txt'] : '';
$custom_feild_id = (isset($nokri['custom_registration_feilds'])) ? $nokri['custom_registration_feilds'] : '';
if ($custom_feild_id != '') {
    $custom_feilds_html = nokri_get_custom_feilds($user_crnt_id, 'Registration', $custom_feild_id, true);
}
/* Custom feilds for employer */
$custom_feild_emp = (isset($nokri['custom_employer_feilds'])) ? $nokri['custom_employer_feilds'] : '';
if ($custom_feild_emp != '') {
    $custom_feilds_emp = nokri_get_custom_feilds($user_crnt_id, 'Employer', $custom_feild_emp, true);
}
/* required message */
$req_mess = esc_html__('This value is required', 'nokri');

/* Checking if is account Member Employee */
$is_member = get_user_meta($user_crnt_id, '_sb_is_member', true);
if (isset($is_member) && $is_member != '') {
    if ($is_member == 1) {
        ?>
        <form id="sb-emp-profile" method="post">
            <div class="main-body">
                <div class="dashboard-edit-profile">
                    <h4 class="dashboard-heading">
                        <?php echo nokri_feilds_label('emp_section_label', esc_html__('Basic Information', 'nokri')); ?> 
                    </h4>
                    <div class="cp-loader"></div>
                    <!-- Basic Information -->
                    <div class="dashboard-social-links">
                        <div class="col-md-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label class=""><?php echo nokri_feilds_label('emp_name_label', esc_html__('Company Name', 'nokri')); ?></label>
                                <input type="text" value="<?php echo esc_attr($user_info->display_name); ?>" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__('This field is required.', 'nokri'); ?>" name="emp_name" class="form-control">
                            </div>
                        </div>
                        <?php if (nokri_feilds_operat('emp_heading_setting', 'show')) { ?>
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class=""><?php echo nokri_feilds_label('emp_heading_label', esc_html__('Headline', 'nokri')); ?></label>
                                    <input type="text" value="<?php echo get_user_meta($user_crnt_id, '_user_headline', true); ?>" name="emp_headline" class="form-control" placeholder="<?php echo nokri_feilds_label('emp_heading_plc', esc_html__('Headline', 'nokri')); ?>" <?php echo nokri_feilds_operat('emp_heading_setting', 'required'); ?> data-parsley-error-message="<?php echo esc_html__('This field is required.', 'nokri'); ?>">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label class=""><?php echo nokri_feilds_label('emp_email_label', esc_html__('Email*', 'nokri')); ?></label>
                                <input type="text" disabled placeholder="<?php echo '' . $user_info->user_email; ?>"  name="emp_email" class="form-control">
                            </div> 
                        </div>
                        <?php if (nokri_feilds_operat('emp_phone_setting', 'show')) { ?>
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class=""><?php echo nokri_feilds_label('emp_phone_label', esc_html__('Phone', 'nokri')); ?> </label>
                                    <input type="text" name="sb_reg_contact" data-parsley-error-message="<?php echo esc_html__('Should be in digits with out space', 'nokri'); ?>"   placeholder="<?php echo nokri_feilds_label('emp_phone_plc', esc_html__('Company Phone', 'nokri')); ?>" value="<?php echo get_user_meta($user_crnt_id, '_sb_contact', true); ?>" class="form-control" <?php echo nokri_feilds_operat('emp_phone_setting', 'required'); ?>>
                                </div>
                            </div>
                        <?php } if (nokri_feilds_operat('emp_web_setting', 'show')) { ?>
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class=""><?php echo nokri_feilds_label('emp_web_label', esc_html__('Website', 'nokri')); ?></label>
                                    <input type="text" data-parsley-error-message="<?php echo esc_html__('Should be in url', 'nokri'); ?>" data-parsley-type="url"   placeholder="<?php echo nokri_feilds_label('emp_web_plc', esc_html__('Company Web Url', 'nokri')); ?>" value="<?php echo get_user_meta($user_crnt_id, '_emp_web', true); ?>" name="emp_web" class="form-control" <?php echo nokri_feilds_operat('emp_web_setting', 'required'); ?>>
                                </div>
                            </div>
                        <?php } if (nokri_feilds_operat('emp_dp_setting', 'show')) { ?>
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class=""><?php echo nokri_feilds_label('emp_dp_label', esc_html__('Profile Image', 'nokri')); ?></label>
                                    <input id="input-b1" name="my_file_upload[]" type="file" class="file form-control sb_files-data" data-show-preview="false" data-allowed-file-extensions='["jpg", "png", "jpeg"]' data-show-upload="false">
                                </div>
                            </div>
                            <?php
                        }
                        if (nokri_feilds_operat('emp_cover_setting', 'show')) {
                            ?>
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class=""><?php echo nokri_feilds_label('emp_cover_label', esc_html__('Cover Image', 'nokri')); ?></label>
                                    <input id="input-b1" name="my_cover_upload[]" type="file" class="file form-control sb_cover-data  input-b2" data-show-preview="false" data-allowed-file-extensions='["jpg", "png", "jpeg"]' data-show-upload="false">
                                </div>
                            </div>
                            <?php
                        }
                        if (nokri_feilds_operat('emp_prof_setting', 'show')) {
                            ?>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label class=""><?php echo nokri_feilds_label('emp_prof_label', esc_html__('Set your profile', 'nokri')); ?></label>
                                    <select  class="select-generat form-control" name="emp_profile">
                                        <option value="pub" <?php
                                        if ($emp_profile == 'pub') {
                                            echo "selected";
                                        };
                                        ?>><?php echo esc_html__('Public', 'nokri'); ?></option>
                                        <option value="priv" <?php
                                        if ($emp_profile == 'priv') {
                                            echo "selected";
                                        };
                                        ?>><?php echo esc_html__('Private', 'nokri'); ?></option>
                                    </select>
                                </div>
                            </div>
                        <?php } if (nokri_feilds_operat('emp_about_setting', 'show')) { ?>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label class=""><?php echo nokri_feilds_label('emp_about_label', esc_html__('About yourself', 'nokri')); ?></label>
                                    <textarea  name="emp_intro" class="form-control rich_textarea" id=""  cols="30" rows="10"><?php echo nokri_candidate_user_meta('_emp_intro'); ?></textarea>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- End Basic Information --> 
                    <?php if ($loc_sec) { ?>
                        <!-- Company Locations-->
                        <input type="hidden" id="is_profile_edit" value="1" />
                        <?php
                        if ($allow_map && $is_lat_long) {
                            ;
                            ?>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="row">
                                    <div class="dashboard-location">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <h4 class="dashboard-heading"><?php echo nokri_feilds_label('emp_loc_section_label', esc_html__('Set your location', 'nokri')); ?></h4>
                                        </div>
                                        <?php if ($is_lat_long) { ?>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo nokri_feilds_label('emp_address_label', esc_html__('Set your location', 'nokri')); ?></label>
                                                    <input class="form-control" name="sb_user_address" id="sb_user_address" value="<?php echo esc_attr($ad_mapLocation); ?>">
                                                    <?php if ($mapType == 'google_map') { ?>
                                                        <a href="javascript:void(0);" id="your_current_location" title="<?php echo esc_html__('You Current Location', 'nokri'); ?>"><i class="fa fa-crosshairs"></i></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <div id="dvMap" style="width:100%; height: 300px"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo nokri_feilds_label('emp_lat_label', esc_html__('Latitude', 'nokri')); ?></label>
                                                    <input class="form-control" type="text" name="ad_map_lat" id="ad_map_lat" value="<?php echo esc_attr($ad_map_lat); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo nokri_feilds_label('emp_long_label', esc_html__('Longitude', 'nokri')); ?></label>
                                                    <input class="form-control" name="ad_map_long" id="ad_map_long" value="<?php echo esc_attr($ad_map_long); ?>" type="text">
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>                    
                        <?php if ($cust_sec) { ?>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="row">
                                    <div class="dashboard-location">
                                        <!--job country -->
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label><?php echo esc_html($job_country_level_1); ?></label>
                                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_html__('Select Your Country', 'nokri'); ?>" id="ad_country" name="cand_country">

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
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?> 
                    <!-- Company Locations-->
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <input type="submit" id="emp_save" value="<?php echo esc_html__('Save Profile', 'nokri'); ?>" class="btn n-btn-flat">
                        <button class="btn n-btn-flat" type="button" id="emp_proc" disabled><?php echo esc_html__('Processing...', 'nokri'); ?></button>
                        <button class="btn n-btn-flat" type="button" id="emp_redir" disabled><?php echo esc_html__('Redirecting...', 'nokri'); ?></button>
                    </div>
                </div>
            </div>
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
                                <input type="button" value="<?php echo esc_html__('Delete account?', 'nokri'); ?>" class="btn btn-custom del_acount">
                            <?php } ?>
                            <input type="submit" value="<?php echo esc_html__('Processing...', 'nokri'); ?>" class="btn n-btn-flat cand_pass_pro">
                            <input type="submit" value="<?php echo esc_html__('Update password', 'nokri'); ?>" class="btn n-btn-flat change_password">
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
    }
} else {
    ?>
    <form id="sb-emp-profile" method="post">
        <div class="main-body">
            <div class="dashboard-edit-profile">
                <h4 class="dashboard-heading">
    <?php echo nokri_feilds_label('emp_section_label', esc_html__('Basic Information', 'nokri')); ?> 
                </h4>
                <div class="cp-loader"></div>
                <!-- Basic Information -->
                <div class="dashboard-social-links">
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('emp_name_label', esc_html__('Company Name', 'nokri')); ?></label>
                            <input type="text" value="<?php echo esc_attr($user_info->display_name); ?>" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__('This field is required.', 'nokri'); ?>" name="emp_name" class="form-control">
                        </div>
                    </div>
    <?php if (nokri_feilds_operat('emp_heading_setting', 'show')) { ?>
                        <div class="col-md-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label class=""><?php echo nokri_feilds_label('emp_heading_label', esc_html__('Headline', 'nokri')); ?></label>
                                <input type="text" value="<?php echo get_user_meta($user_crnt_id, '_user_headline', true); ?>" name="emp_headline" class="form-control" placeholder="<?php echo nokri_feilds_label('emp_heading_plc', esc_html__('Headline', 'nokri')); ?>" <?php echo nokri_feilds_operat('emp_heading_setting', 'required'); ?> data-parsley-error-message="<?php echo esc_html__('This field is required.', 'nokri'); ?>">
                            </div>
                        </div>
    <?php } ?>

                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo nokri_feilds_label('emp_email_label', esc_html__('Email*', 'nokri')); ?></label>
                            <input type="text" disabled placeholder="<?php echo '' . $user_info->user_email; ?>"  name="emp_email" class="form-control">
                        </div> 
                    </div>
                    <?php
                    if (nokri_feilds_operat('emp_phone_setting', 'show')) {

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
                        /* Checking if number is verified */
                        $verified_pho = get_user_meta($user_crnt_id, '_sb_verified_contact', true);
                        $phoneNo = get_user_meta($user_crnt_id, '_sb_contact', true);

                        if ($phoneNo == '') {
                            delete_user_meta($user_crnt_id, '_sb_verified_contact',);
                            //update_user_meta($user_crnt_id, '_sb_verified_contact',$phoneNo);
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
                    }
                    ?>
                    <?php
                    if (nokri_feilds_operat('emp_phone_setting', 'show')) {
                        if ($fbAllowed == true && $numberVer != '') {
                            ?>
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class=""><?php echo nokri_feilds_label('emp_phone_label', esc_html__('Phone', 'nokri')); ?> </label>
                                    <label class=""><?php echo esc_html($numberVer); ?></label>
                                    <input type="text" name="sb_reg_contact" data-parsley-error-message="<?php echo esc_html__('Should be in digits with out space', 'nokri'); ?>"   placeholder="<?php echo nokri_feilds_label('emp_phone_plc', esc_html__('Company Phone', 'nokri')); ?>" value="<?php echo get_user_meta($user_crnt_id, '_sb_contact', true); ?>" class="form-control" <?php echo nokri_feilds_operat('emp_phone_setting', 'required'); ?>>
                                </div>
                            </div>
                            <?php
                        } elseif ($fbAllowed == true && $numberVer == '') {
                            
                        } else {
                            ?> 
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class=""><?php echo nokri_feilds_label('emp_phone_label', esc_html__('Phone', 'nokri')); ?> </label>
                                    <input type="text" name="sb_reg_contact" data-parsley-error-message="<?php echo esc_html__('Should be in digits with out space', 'nokri'); ?>"   placeholder="<?php echo nokri_feilds_label('emp_phone_plc', esc_html__('Company Phone', 'nokri')); ?>" value="<?php echo get_user_meta($user_crnt_id, '_sb_contact', true); ?>" class="form-control" <?php echo nokri_feilds_operat('emp_phone_setting', 'required'); ?>>
                                </div>
                            </div>

                            <?php
                        }
                    } if (nokri_feilds_operat('emp_web_setting', 'show')) {
                        ?>
                        <div class="col-md-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label class=""><?php echo nokri_feilds_label('emp_web_label', esc_html__('Website', 'nokri')); ?></label>
                                <input type="text" data-parsley-error-message="<?php echo esc_html__('Should be in url', 'nokri'); ?>" data-parsley-type="url"   placeholder="<?php echo nokri_feilds_label('emp_web_plc', esc_html__('Company Web Url', 'nokri')); ?>" value="<?php echo get_user_meta($user_crnt_id, '_emp_web', true); ?>" name="emp_web" class="form-control" <?php echo nokri_feilds_operat('emp_web_setting', 'required'); ?>>
                            </div>
                        </div>
    <?php } if (nokri_feilds_operat('emp_dp_setting', 'show')) { ?>
                        <div class="col-md-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label class=""><?php echo nokri_feilds_label('emp_dp_label', esc_html__('Profile Image', 'nokri')); ?></label>
                                <input id="input-b1" name="my_file_upload[]" type="file" class="file form-control sb_files-data" data-show-preview="false" data-allowed-file-extensions='["jpg", "png", "jpeg"]' data-show-upload="false">
                            </div>
                        </div>
                        <?php
                    }
                    if (nokri_feilds_operat('emp_cover_setting', 'show')) {
                        ?>
                        <div class="col-md-6 col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label class=""><?php echo nokri_feilds_label('emp_cover_label', esc_html__('Cover Image', 'nokri')); ?></label>
                                <input id="input-b1" name="my_cover_upload[]" type="file" class="file form-control sb_cover-data  input-b2" data-show-preview="false" data-allowed-file-extensions='["jpg", "png", "jpeg"]' data-show-upload="false">
                            </div>
                        </div>
                        <?php
                    }
                    if (nokri_feilds_operat('emp_prof_setting', 'show')) {
                        ?>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class=""><?php echo nokri_feilds_label('emp_prof_label', esc_html__('Set your profile', 'nokri')); ?></label>
                                <select  class="select-generat form-control" name="emp_profile">
                                    <option value="pub" <?php
                                    if ($emp_profile == 'pub') {
                                        echo "selected";
                                    };
                                    ?>><?php echo esc_html__('Public', 'nokri'); ?></option>
                                    <option value="priv" <?php
                                    if ($emp_profile == 'priv') {
                                        echo "selected";
                                    };
                                    ?>><?php echo esc_html__('Private', 'nokri'); ?></option>
                                </select>
                            </div>
                        </div>
    <?php } if (nokri_feilds_operat('emp_about_setting', 'show')) { ?>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="form-group">
                                <label class=""><?php echo nokri_feilds_label('emp_about_label', esc_html__('About yourself', 'nokri')); ?></label>
                                <textarea  name="emp_intro" class="form-control rich_textarea" id=""  cols="30" rows="10"><?php echo nokri_candidate_user_meta('_emp_intro'); ?></textarea>
                            </div>
                        </div>
    <?php } ?>
                </div>
                <!-- End Basic Information --> 
                <?php if ($detail_sec) {
                    ?>
                    <!-- Company Specialization -->
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <h4 class="dashboard-heading"><?php echo nokri_feilds_label('emp_detail_label', esc_html__('Company Details', 'nokri')); ?></h4>
                        </div>
        <?php if (nokri_feilds_operat('emp_spec_setting', 'show')) { ?>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label class=""><?php echo nokri_feilds_label('emp_spec_label', esc_html__('Company Specialization', 'nokri')); ?></label>
                                    <select class="select-generat form-control" name="emp_cat[]" id="change_term" multiple="multiple">
            <?php echo nokri_candidate_skills('emp_specialization', '_emp_skills'); ?>
                                    </select>
                                </div>
                            </div>
        <?php } if (nokri_feilds_operat('emp_no_emp_setting', 'show')) { ?>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label><?php echo nokri_feilds_label('emp_no_emp_label', esc_html__('No. of Employees', 'nokri')); ?></label>
                                    <input type="text" placeholder="<?php echo nokri_feilds_label('emp_no_emp_plc', esc_html__('Enter number of employes', 'nokri')); ?>" value="<?php echo get_user_meta($user_crnt_id, '_emp_nos', true); ?>"  name="emp_nos" class="form-control" <?php echo nokri_feilds_operat('emp_no_emp_setting', 'required'); ?> data-parsley-error-message="<?php echo esc_html($req_mess); ?>">
                                </div>
                            </div>
        <?php } if (nokri_feilds_operat('emp_est_setting', 'show')) { ?>
                            <div class="col-md-6 col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class=""><?php echo nokri_feilds_label('emp_est_label', esc_html__('Established Date', 'nokri')); ?></label>
                                    <input type="text" value="<?php echo get_user_meta($user_crnt_id, '_emp_est', true); ?>" name="emp_est" class="datepicker-here-canidate form-control" <?php echo nokri_feilds_operat('emp_est_setting', 'required'); ?> />
                                </div>
                            </div>
                            <!--End Company Specialization --> 
                    <?php } ?>
                    </div>       
                    <?php
                }
                $is_access = isset($nokri['reg_custom_fields_switch']) ? $nokri['reg_custom_fields_switch'] : true;
                if ($is_access) {
                    if ($custom_feilds_html != '' || $custom_feilds_emp != '') {
                        ?>
                        <!-- Custom feilds -->
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="dashboard-social-links">
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <h4 class="dashboard-heading"><?php echo '' . $custom_feild_txt; ?></h4>
                                </div>
            <?php echo '' . $custom_feilds_html . $custom_feilds_emp; ?>
                            </div>
                        </div>
                        <?php
                    }
                } if ($soc_sec) {
                    ?>
                    <!-- Company Soical Links -->
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="dashboard-social-links">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <h4 class="dashboard-heading"><?php echo nokri_feilds_label('emp_social_section_label', esc_html__('Company Social Links', 'nokri')); ?></h4>
                            </div>
        <?php if (nokri_feilds_operat('emp_fb_setting', 'show')) { ?>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('emp_fb_label', esc_html__('Facebook', 'nokri')); ?></label>
                                        <input type="text" placeholder="<?php echo nokri_feilds_label('emp_fb_plc', esc_html__('Profile URL', 'nokri')); ?>" value="<?php echo get_user_meta($user_crnt_id, '_emp_fb', true); ?>" name="emp_fb" class="form-control" <?php echo nokri_feilds_operat('emp_fb_setting', 'required'); ?> data-parsley-error-message="<?php echo esc_html($req_mess); ?>">
                                    </div>
                                </div>
        <?php } if (nokri_feilds_operat('emp_twtr_setting', 'show')) { ?>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('emp_twtr_label', esc_html__('Twitter', 'nokri')); ?></label>
                                        <input type="text" placeholder="<?php echo nokri_feilds_label('emp_twtr_plc', esc_html__('Profile URL', 'nokri')); ?>" value="<?php echo get_user_meta($user_crnt_id, '_emp_twitter', true); ?>" name="emp_twitter" class="form-control" <?php echo nokri_feilds_operat('emp_twtr_setting', 'required'); ?> data-parsley-error-message="<?php echo esc_html($req_mess); ?>">
                                    </div>
                                </div>
        <?php } if (nokri_feilds_operat('emp_linked_setting', 'show')) { ?>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('emp_linked_label', esc_html__('LinkedIn', 'nokri')); ?></label>
                                        <input type="text" placeholder="<?php echo nokri_feilds_label('emp_linked_plc', esc_html__('Profile URL', 'nokri')); ?>" value="<?php echo get_user_meta($user_crnt_id, '_emp_linked', true); ?>" name="emp_linked" class="form-control" <?php echo nokri_feilds_operat('emp_linked_setting', 'required'); ?> data-parsley-error-message="<?php echo esc_html($req_mess); ?>">
                                    </div>
                                </div>
        <?php } if (nokri_feilds_operat('emp_insta_setting', 'show')) { ?>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('emp_insta_label', esc_html__('Instagram', 'nokri')); ?></label>
                                        <input type="text" placeholder="<?php echo nokri_feilds_label('emp_insta_plc', esc_html__('Profile URL', 'nokri')); ?>" value="<?php echo get_user_meta($user_crnt_id, '_emp_google', true); ?>" name="emp_google" class="form-control" <?php echo nokri_feilds_operat('emp_insta_setting', 'required'); ?> data-parsley-error-message="<?php echo esc_html($req_mess); ?>">
                                    </div>
                                </div>
        <?php } ?>
                        </div>
                    </div>
                    <!--End Company Social Links --> 
    <?php } if ($loc_sec) { ?>
                    <!-- Company Locations-->
                    <input type="hidden" id="is_profile_edit" value="1" />
                    <?php
                    if ($is_lat_long) {
                        ;
                        ?>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="row">
                                <div class="dashboard-location">
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <h4 class="dashboard-heading"><?php echo nokri_feilds_label('emp_loc_section_label', esc_html__('Set your location', 'nokri')); ?></h4>
                                    </div>
            <?php if ($is_lat_long) { ?>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo nokri_feilds_label('emp_address_label', esc_html__('Set your location', 'nokri')); ?></label>
                                                <input class="form-control" name="sb_user_address" id="sb_user_address" value="<?php echo esc_attr($ad_mapLocation); ?>">
                                                <?php if ($mapType == 'google_map') { ?>
                                                    <a href="javascript:void(0);" id="your_current_location" title="<?php echo esc_html__('You Current Location', 'nokri'); ?>"><i class="fa fa-crosshairs"></i></a>
                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <div id="dvMap" style="width:100%; height: 300px"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo nokri_feilds_label('emp_lat_label', esc_html__('Latitude', 'nokri')); ?></label>
                                                <input class="form-control" type="text" name="ad_map_lat" id="ad_map_lat" value="<?php echo esc_attr($ad_map_lat); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo nokri_feilds_label('emp_long_label', esc_html__('Longitude', 'nokri')); ?></label>
                                                <input class="form-control" name="ad_map_long" id="ad_map_long" value="<?php echo esc_attr($ad_map_long); ?>" type="text">
                                            </div>
                                        </div>
            <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
        <?php if ($cust_sec) { ?>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="row">
                                <div class="dashboard-location">
                                    <!--job country -->
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label><?php echo esc_html($job_country_level_1); ?></label>
                                            <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_html__('Select Your Country', 'nokri'); ?>" id="ad_country" name="cand_country">

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
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                <!-- Company Locations-->
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <input type="submit" id="emp_save" value="<?php echo esc_html__('Save Profile', 'nokri'); ?>" class="btn n-btn-flat">
                    <button class="btn n-btn-flat" type="button" id="emp_proc" disabled><?php echo esc_html__('Processing...', 'nokri'); ?></button>
                    <button class="btn n-btn-flat" type="button" id="emp_redir" disabled><?php echo esc_html__('Redirecting...', 'nokri'); ?></button>
                </div>
            </div>
        </div>
        <!-- Team Members -->
        <?php
        $team_memebers = get_user_meta($user_crnt_id, '_nokri_member_info', true);
        $final_data = $team_memebers != "" ? $team_memebers : array();
        ?>
        <div  id="member_model_container"></div>
        <?php
        $is_permiss = ( isset($nokri['emp_team_members']) && $nokri['emp_team_members'] != "" ) ? $nokri['emp_team_members'] : false;
        if ($is_permiss) {
            ?>
            <div class="main-body change-password">
                <div class="dashboard-edit-profile">
                    <h4 class="dashboard-heading"><?php echo esc_html__('Team Members Details', 'nokri'); ?> </h4>
                    <div class="row">
                        <div class="team-member-grids">
                            <?php
                            if (is_array($final_data) && !empty($final_data)) {

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
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 <?php echo esc_attr($key); ?>">
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
                                            <div class="team-footer">
                                                <span class="list">
                                                    <a class="edit_team_member" href="javascript:void(0);" data-memeber_id= "<?php echo esc_attr($key); ?>">
                                                        <span class="btn btn-default"><?php echo esc_html__('Edit', 'nokri'); ?></span>
                                                    </a>
                                                </span>
                                                <span class="list">
                                                    <a class="delete_member_btn" data-memeber-delete-id= "<?php echo esc_attr($key); ?>">
                                                        <span class="btn btn-danger"><?php echo esc_html__('Delete', 'nokri'); ?></span>
                                                    </a>
                                                </span>
                                            </div>

                                        </figure>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <button type="button" class="btn n-btn-flat get_team_members" ><span class="fa fa-plus"></span><?php echo esc_html__('Add Team Member', 'nokri'); ?></button>
                </div>
            </div>
    <?php } ?>
        <!--Account Members-->
        <div  id="account_member_model"></div>
        <?php
        $is_allowed = ( isset($nokri['emp_account_members']) && $nokri['emp_account_members'] != "" ) ? $nokri['emp_account_members'] : false;
        if ($is_allowed) {
            ?>
            <div class="main-body change-password">
                <div class="dashboard-edit-profile">
                    <h4 class="dashboard-heading"><?php echo esc_html__('Account Members Details', 'nokri'); ?> </h4>
                    <div class="row">
                        <div class="team-member-grids">
                            <?php
                            $membersData = get_user_meta($user_crnt_id, 'account_members', true);

                            if (is_array($membersData) && count($membersData) > 0) {
                                foreach ($membersData as $key => $memberInfo) {

                                    $firstName = ( isset($memberInfo['firstName']) && $memberInfo['firstName'] != "") ? $memberInfo['firstName'] : '';
                                    $lastName = ( isset($memberInfo['lastName']) && $memberInfo['lastName'] != "" ) ? $memberInfo['lastName'] : '';
                                    $userName = ( isset($memberInfo['userName']) && $memberInfo['userName'] != "" ) ? $memberInfo['userName'] : '';
                                    $userEmail = ( isset($memberInfo['userEmail']) && $memberInfo['userEmail'] != "" ) ? $memberInfo['userEmail'] : '';
                                    $userid = ( isset($memberInfo['id']) && $memberInfo['id'] != "" ) ? $memberInfo['id'] : '';
                                    ?>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 <?php echo esc_attr($key); ?>">
                                        <figure class="team-grid">
                                            <div class="team-header">
                                                <div class="team-body">
                                                    <h4 class=""><?php echo esc_html($firstName . ' ' . $lastName); ?></h4> 
                                                    <div class="d-block">
                                                        <i class=""></i>
                                                        <span class=""><?php echo esc_html($userEmail); ?></span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="team-footer">
                                                <span class="list">
                                                    <a class="edit_acc_member" href="javascript:void(0);" data-member_id= "<?php echo esc_attr($key); ?>">
                                                        <span class="btn btn-default"><?php echo esc_html__('Edit', 'nokri'); ?></span>
                                                    </a>
                                                </span>
                                                <span class="list">
                                                    <a class="delete_acc_member" data-memeber-delete-id= "<?php echo esc_attr($key); ?>">
                                                        <span class="btn btn-danger"><?php echo esc_html__('Delete', 'nokri'); ?></span>
                                                    </a>
                                                </span>
                                            </div>
                                        </figure>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <button type="button" class="btn n-btn-flat add_account_members" ><span class="fa fa-plus"> </span><?php echo esc_html__('Add Account Member', 'nokri'); ?></button>
                </div>
            </div>
    <?php } if ($port_sec) { ?>
            <div class="main-body change-password">
                <div class="dashboard-edit-profile">
                    <h4 class="dashboard-heading"><?php echo nokri_feilds_label('emp_port_section_heading', esc_html__('Company Portfolio', 'nokri')); ?></h4>
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="row">
        <?php if (nokri_feilds_operat('emp_port_setting', 'show')) { ?>
                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo nokri_feilds_label('emp_port_section_label', esc_html__('Drag drop or click to upload your company image', 'nokri')); ?></label>
                                            <div id="company-dropzone" class="dropzone"></div>
                                        </div>
                                    </div>
        <?php } if (nokri_feilds_operat('emp_port_vid_setting', 'show')) { ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label><?php echo nokri_feilds_label('emp_port_vid_label', esc_html__('Video url (only youtube)', 'nokri')); ?></label>
                                            <input type="text" placeholder="<?php echo nokri_feilds_label('emp_port_vid_plc', esc_html__('Put youtube video link', 'nokri')); ?>" value="<?php echo nokri_candidate_user_meta('_emp_video'); ?>" name="emp_video" class="form-control" data-parsley-pattern="^(http(s)?:\/\/)?((w){3}.)?youtu(be|.be)?(\.com)?\/.+" <?php echo nokri_feilds_operat('emp_port_vid_setting', 'required'); ?> >
                                        </div>
                                    </div>
        <?php } ?>
                            </div>
                        </div>
                    </div>
                    <input type="submit"  value="<?php echo esc_html__('Save Profile', 'nokri'); ?>" class="btn n-btn-flat">
                </div>
            </div>
    <?php } ?>
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
                            <input type="button" value="<?php echo esc_html__('Delete account?', 'nokri'); ?>" class="btn btn-custom del_acount">
    <?php } ?>
                        <input type="submit" value="<?php echo esc_html__('Processing...', 'nokri'); ?>" class="btn n-btn-flat cand_pass_pro">
                        <input type="submit" value="<?php echo esc_html__('Update password', 'nokri'); ?>" class="btn n-btn-flat change_password">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="member_model_container_members"></div>
    <div id="edit_model_container_members"></div>

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
}