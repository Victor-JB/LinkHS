<?php
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : "";
if ($user_id != "") {

    global $nokri;
    $author_id = $user_id;
    $author = get_user_by('ID', $author_id);
    $current_user_id = get_current_user_id();
    /* Candidate Resume */
    $cand_skills = $skill_tags = $portfolio_html = '';
    $user_crnt_id = $user_id;
    $registered = $author->user_registered;
    /* package Page */
    $package_page = isset($nokri['package_page']) ? $nokri['package_page'] : '';
    /* Getting Candidate Dp */
    $image_link = nokri_get_user_profile_pic($user_crnt_id, '_cand_dp');


    $attach_dp_id = get_user_meta($user_crnt_id, '_cand_dp', true);
    $image_dp_link = wp_get_attachment_image_src($attach_dp_id, '');
    $image_link = isset($image_dp_link[0]) ? $image_dp_link[0] : "";

    /* Getting Candidate Portfolio */
    $portfolio_html = nokri_candidate_portfolio($user_crnt_id);
    /* Getting Candidate user meta */
    $cand_dob = $remaining_searches = '';
    $cand_dob = get_user_meta($user_crnt_id, '_cand_dob', true);
    $cand_gender = get_user_meta($user_crnt_id, '_cand_gender', true);
    $cand_qualification = get_user_meta($user_crnt_id, '_cand_qualification', true);

    $cand_headline = get_user_meta($user_crnt_id, '_user_headline', true);
    $cand_address = get_user_meta($user_crnt_id, '_cand_address', true);
    $cand_fb = get_user_meta($user_crnt_id, '_cand_fb', true);
    $cand_twiter = get_user_meta($user_crnt_id, '_cand_twiter', true);
    $cand_google = get_user_meta($user_crnt_id, '_cand_google', true);
    $cand_linked = get_user_meta($user_crnt_id, '_cand_linked', true);
    $cand_phone = get_user_meta($user_crnt_id, '_sb_contact', true);
    $cand_intro_video = get_user_meta($user_crnt_id, '_cand_intro_vid', true);
    $cand_introd = get_user_meta($user_crnt_id, '_cand_intro', true);
    $cand_video = get_user_meta($user_crnt_id, '_cand_video', true);
    $salary_type = get_user_meta($user_crnt_id, '_cand_salary_type', true);
    $salary_range = get_user_meta($user_crnt_id, '_cand_salary_range', true);
    $salary_curren = get_user_meta($user_crnt_id, '_cand_salary_curren', true);
    $cand_profile_status = get_user_meta($user_crnt_id, '_user_profile_status', true);
    $cand_education = get_user_meta($user_crnt_id, '_cand_education', true);

    $expected_salary = "";
    if ($salary_range) {
        $expected_salary = nokri_job_post_single_taxonomies('job_salary', $salary_range) . " " . '/' . " " . nokri_job_post_single_taxonomies('job_salary_type', $salary_type);
    }
}