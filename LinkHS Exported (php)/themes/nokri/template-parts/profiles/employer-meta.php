<?php

global $nokri;
$author_id = get_query_var('author');
$author = get_user_by('ID', $author_id);
$current_user_id = get_current_user_id();
$registered = $author->user_registered;
$author_id = get_query_var('author');

/* Checking if user is a member of an Employer and have permissions */
$member_id = get_user_meta($current_user_id, '_sb_is_member', true);
$emp_id = get_user_meta($author_id, 'account_owner', true);
if (isset($member_id) && $member_id != '') {
    $author_id = $emp_id;
} else {
    $author_id = $author_id;
}

$author = get_user_by('ID', $author_id);
global $wpdb;
$query = "SELECT count(umeta_id) FROM $wpdb->usermeta WHERE `meta_key` like '_cand_follow_company_%' AND `meta_value` = '" . $author_id . "'";
$followings = $wpdb->get_var($query);
$comp_followers = (count((array) $followings));
$comp_followers_txt = esc_html__('Follower', 'nokri');
if ($comp_followers > 1) {
    $comp_followers_txt = esc_html__('Followers', 'nokri');
}
$user_post_count = count_user_posts($author_id, 'job_post');
$user_id = get_query_var('author');
$ad_mapLocation = '';
$ad_mapLocation = get_user_meta($author_id, '_emp_map_location', true);
$headline = get_user_meta($author_id, '_user_headline', true);
$ad_map_lat = get_user_meta($author_id, '_emp_map_lat', true);
$ad_map_long = get_user_meta($author_id, '_emp_map_long', true);
$allowed = isset($nokri['firebase_switch']) ? $nokri['firebase_switch'] : false;
$verification = '';
if ($allowed) {
    $verification = nokri_firebase_verified_number($author_id);
}
/* Getting Profile Photo */
$image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
    $image_link = array($nokri['nokri_user_dp']['url']);
}
if (get_user_meta($user_id, '_sb_user_pic', true) != "") {
    $attach_id = get_user_meta($user_id, '_sb_user_pic', true);
    if (is_numeric($attach_id)) {
        $image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
    } else {
        $image_link[0] = $attach_id;
    }
}
if (empty($image_link[0])) {
    if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
        $image_link = array($nokri['nokri_user_dp']['url']);
    }
}
/* Getting Employer Skills  */
$emp_skills = get_user_meta($user_id, '_emp_skills', true);
$skill_tags = '';
$employer_search_page = $nokri['employer_search_page'];

if ((array) $emp_skills && $emp_skills > 0) {
    $taxonomies = get_terms('emp_specialization', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC', 'parent' => 0));
    if (count((array) $taxonomies) > 0) {
        foreach ($taxonomies as $taxonomy) {
            $link = get_the_permalink($employer_search_page) . "?emp_skills=" . $taxonomy->term_id;
            if (in_array($taxonomy->term_id, $emp_skills))
                $skill_tags .= '<a href="' . esc_url($link) . '" class="skills_tags" target="_blank">' . esc_html($taxonomy->name) . '</a>';
        }
    }
}

/* Getting Candidate Portfolio */
$portfolio_html = '';
if (get_user_meta($author_id, '_comp_gallery', true) != "") {
    $port = get_user_meta($author_id, '_comp_gallery', true);
    $portfolios = explode(',', $port);
    foreach ($portfolios as $portfolio) {
        $portfolio_image_sm = wp_get_attachment_image_src($portfolio, 'nokri_job_hundred');
        $portfolio_image_lg = wp_get_attachment_image_src($portfolio, 'nokri_cand_large');
        $portfolio_html .= '<li><a class="portfolio-gallery" data-fancybox="gallery" href="' . esc_url($portfolio_image_lg[0]) . '"><img src="' . esc_url($portfolio_image_sm[0]) . '" alt= "' . esc_attr__('portfolio image', 'nokri') . '"></a></li>';
    }
}

$emp_establish = '';
$emp_establish = get_user_meta($user_id, '_emp_est', true);
$emp_headline = get_user_meta($user_id, '_user_headline', true);
$emp_address = get_user_meta($user_id, '_emp_map_location', true);
$emp_fb = get_user_meta($user_id, '_emp_fb', true);
$emp_google = get_user_meta($user_id, '_emp_google', true);
$emp_twitter = get_user_meta($user_id, '_emp_twitter', true);
$emp_linkedin = get_user_meta($user_id, '_emp_linked', true);
$emp_cntct = get_user_meta($user_id, '_sb_contact', true);
$emp_web = get_user_meta($user_id, '_emp_web', true);
$emp_size = get_user_meta($user_id, '_emp_nos', true);
$emp_video = get_user_meta($user_id, '_emp_video', true);
$emp_profile_status = get_user_meta($author_id, '_user_profile_status', true);
$working_remote = get_user_meta($user_id, 'n_working_remotely', true);


$rtl_class = $bg_url = '';
$cover_pic = get_user_meta($user_id, '_sb_user_cover', true);
if ($cover_pic != "") {
    $bg_url = nokri_user_cover_bg_url($cover_pic);
} else {
    $bg_url = nokri_section_bg_url();
}
$follow_btn_switch = isset($nokri['emp_det_follow_btn']) ? $nokri['emp_det_follow_btn'] : false;

$map_location = isset($nokri['emp_map_switch']) ? $nokri['emp_map_switch'] : false;

if (!$map_location) {

    $emp_address = emp_get_custom_location($author_id);
}

$contact_recaptcha = isset($nokri['user_contact_form_recaptcha']) ? $nokri['user_contact_form_recaptcha'] : false;
/* email/phone hide/show */
$is_public = isset($nokri['user_phone_email']) && $nokri['user_phone_email'] == '1' ? true : false;


/* contact form hide/show */
$is_public_contact = isset($nokri['user_contact_form']) && $nokri['user_contact_form'] == '1' ? true : false;
if ($emp_profile_status == 'priv' & $author_id != $current_user_id) {
    $image_link[0] = get_template_directory_uri() . '/images/admin.jpg';
};
/* profile private txt */
$user_private_txt = isset($nokri['user_private_txt']) ? $nokri['user_private_txt'] : '';
/* Social links hide/show */
$social_links = isset($nokri['user_contact_social']) ? $nokri['user_contact_social'] : true;
/* Custom registration feilds for candidate */
$custom_feild_id = $registration_feilds = '';
$custom_feild_id = (isset($nokri['custom_registration_feilds'])) ? $nokri['custom_registration_feilds'] : '';
if (isset($custom_feild_id) && $custom_feild_id != '') {
    $registration_feilds = nokri_get_custom_feilds($author_id, 'Registration', $custom_feild_id, false, true);
}
/* Custom feilds for employer */
$custom_feilds_emp = '';
$custom_feild_emp = (isset($nokri['custom_employer_feilds'])) ? $nokri['custom_employer_feilds'] : '';
if (isset($custom_feild_emp) && $custom_feild_emp != '') {
    $custom_feilds_emp = nokri_get_custom_feilds($author_id, 'Employer', $custom_feild_emp, false, true);
}
$detail_sec = (isset($nokri['emp_spec_switch'])) ? $nokri['emp_spec_switch'] : false;
$soc_sec = (isset($nokri['emp_social_section_switch'])) ? $nokri['emp_social_section_switch'] : false;
$loc_sec = (isset($nokri['emp_loc_switch'])) ? $nokri['emp_loc_switch'] : false;
$cust_sec = (isset($nokri['emp_custom_switch'])) ? $nokri['emp_custom_switch'] : false;
$port_sec = (isset($nokri['emp_port_switch'])) ? $nokri['emp_port_switch'] : false;
$emp_spec_switch = (isset($nokri['emp_spec_switch'])) ? $nokri['emp_spec_switch'] : false;

/* Remotely Working */
$remote_data = get_user_meta($user_id, 'n_remotely_work', true);