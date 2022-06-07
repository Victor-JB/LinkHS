<?php
global $nokri;
$job_deadline = $job_type = $job_level = $job_shift = $job_experience = $job_skills = $job_salary = $job_qualifications = $job_currency = $ad_mapLocation = $ad_map_lat = $post_apply_status = $ad_map_long = $job_phone = $cats = $project = $web = $company_name = $single_job_badges = $box_class = '';
$job_skills = array();
$job_id = get_the_ID();
nokri_display_adLocation($job_id);
$current_user = wp_get_current_user();
$user_id = get_current_user_id();
$post_author_id = get_post_field('post_author', $job_id);
$company_name = get_the_author_meta('display_name', $post_author_id);
$resume_exist = get_post_meta($job_id, '_job_applied_status_' . $user_id, true);
$job_categories = wp_get_object_terms($job_id, array('job_category'), array('orderby' => 'term_group'));
/* Getting Job Details */
$job_type = wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
$job_type = isset($job_type[0]) ? $job_type[0] : '';
$job_qualifications = wp_get_post_terms($job_id, 'job_qualifications', array("fields" => "ids"));
$job_qualifications = isset($job_qualifications[0]) ? $job_qualifications[0] : '';
$job_level = wp_get_post_terms($job_id, 'job_level', array("fields" => "ids"));
$job_level = isset($job_level[0]) ? $job_level[0] : '';
$job_salary = wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
$job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
$job_salary_type = wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
$job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
$job_experience = wp_get_post_terms($job_id, 'job_experience', array("fields" => "ids"));
$job_experience = isset($job_experience[0]) ? $job_experience[0] : '';
$job_currency = wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
$job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
$job_shift = wp_get_post_terms($job_id, 'job_shift', array("fields" => "ids"));
$job_shift = isset($job_shift[0]) ? $job_shift[0] : '';
$job_skills = wp_get_post_terms($job_id, 'job_skills', array("fields" => "ids"));
$ad_mapLocation = get_post_meta($job_id, '_job_address', true);
$ad_map_lat = get_post_meta($job_id, '_job_lat', true);
$ad_map_long = get_post_meta($job_id, '_job_long', true);
$job_phone = get_post_meta($job_id, '_job_phone', true);
$job_vacancy = get_post_meta($job_id, '_job_posts', true);
$job_video = get_post_meta($job_id, '_job_video', true);
$cats = nokri_get_ad_cats($job_id, 'ID');
$post_date = get_the_date(' M j ,Y');
/* Jobs aplly with */
$job_apply_with = get_post_meta($job_id, '_job_apply_with', true);
$job_apply_url = get_post_meta($job_id, '_job_apply_url', true);
$job_apply_mail = get_post_meta($job_id, '_job_apply_mail', true);
$job_apply_whatsapp = get_post_meta($job_id, '_job_apply_whatsapp', true);

/* Jobs tags */
$tags_html = '';
$jobs_tags = get_the_terms($job_id, 'job_tags');
if (!empty($jobs_tags) && count((array) $jobs_tags) > 0) {
    foreach ($jobs_tags as $tag) {
        $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job_tags', esc_attr($tag->term_id));
        $final_url = esc_url(nokri_page_lang_url_callback($link));
        $tags_html .= '<a href="' . $final_url . '">#' . esc_attr($tag->name) . '</a>';
    }
}
/* Calling Funtion Job Class For Badges */
$single_job_badges = nokri_job_class_badg($job_id);
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
        $search_url = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job_class', $val);
        $job_badge_text .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($search_url)) . '" class="job-class-tags-anchor" ' . $style_color . '><span>' . esc_html(ucfirst($job_badge)) . '</span></a></li>';
    }
}
/* Setting job Expiration */
$job_deadline_n = get_post_meta($job_id, '_job_date', true);
$job_deadline = date_i18n(get_option('date_format'), strtotime($job_deadline_n));
$today = date("m/d/Y");
$expiry_date_string = strtotime($job_deadline_n);
$today_string = strtotime($today);
if ($today_string > $expiry_date_string) {
    update_post_meta($job_id, '_job_status', 'inactive');
    $post_to_change = array('ID' => $job_id, 'post_status' => 'Draft');
    wp_update_post($post_to_change);
}
/* Getting job Aplly Expiration Status */
$post_apply_status = get_post_meta($job_id, '_job_status', true);
/* Getting Catgories */
$project = nokri_job_categories_with_chlid_no_href($job_id, 'job_category');

/* Getting Location */
$countries_last = nokri_job_categories_with_chlid_no_href($job_id, 'ad_location');
//indeed job format location
$format_location = get_post_meta($job_id, 'job_format_location', true);
if ($countries_last == '') {

    $countries_last = $format_location;
}
/* Getting Job Skills  */
$skill_tags = '';
if (is_array($job_skills)) {
    $taxonomies = get_terms('job_skills', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC', 'parent' => 0));
    if (count($taxonomies) > 0) {
        foreach ($taxonomies as $taxonomy) {
            if (in_array($taxonomy->term_id, $job_skills)) {
                $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job_skills', esc_attr($taxonomy->term_id));
                $final_url = esc_url(nokri_page_lang_url_callback($link));
                $skill_tags .= '<a href="' . $final_url . '">' . " " . esc_html($taxonomy->name) . " " . '</a>';
            }
        }
    }
}
/* Getting Job attachments */
$job_attachments = '';
if (get_post_meta($job_id, '_job_attachment', true) != "") {
    $port = get_post_meta($job_id, '_job_attachment', true);
    $portfolios = explode(',', $port);
    foreach ($portfolios as $portfolio) {
        $file_url = wp_get_attachment_url($portfolio);
        $filetype = wp_check_filetype($file_url);
        if ($filetype['ext'] == 'jpg' || $filetype['ext'] == 'png' || $filetype['ext'] == 'jpeg' || $filetype['ext'] == 'gif') {
            $portfolio_image_sm = wp_get_attachment_image_src($portfolio, 'nokri_job_hundred');
            $portfolio_image_lg = wp_get_attachment_image_src($portfolio, 'nokri_cand_large');
            $job_attachments .= '<li><a class="portfolio-gallery" data-fancybox="gallery" href="' . esc_url($portfolio_image_lg[0]) . '"><img src="' . esc_url($portfolio_image_sm[0]) . '" alt= "' . esc_attr__('portfolio image', 'nokri') . '"></a></li>';
        } else {
            if ($filetype['ext'] == 'docx') {
                $file_icon = 'docx';
            } else if ($filetype['ext'] == 'doc') {
                $file_icon = 'doc';
            } else {
                $file_icon = 'pdf';
            }
            $job_attachments .= '<li><a href="' . esc_url(wp_get_attachment_url($portfolio)) . '"  target="_blank"><img src="' . get_template_directory_uri() . '/images/icons/' . $file_icon . '.png" alt="' . esc_attr__('portfolio image', 'nokri') . '"></a></li>';
        }
    }
}
/* Opening */
$opening_text = esc_html__('opening', 'nokri');
if ($job_vacancy > 1) {
    $opening_text = esc_html__('openings', 'nokri');
}
/* Getting Profile Photo */
$image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
    $image_link = array($nokri['nokri_user_dp']['url']);
}
if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
    $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
    if (is_numeric($attach_id)) {
        $image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
    } else {
        $image_link[0] = $attach_id;
    }
}
$emp_postal_code = get_user_meta($post_author_id, '_emp_postal_address', true);
$emp_fb = get_user_meta($post_author_id, '_emp_fb', true);
$emp_google = get_user_meta($post_author_id, '_emp_google', true);
$emp_twitter = get_user_meta($post_author_id, '_emp_twitter', true);
$emp_linkedin = get_user_meta($post_author_id, '_emp_linked', true);
$web = get_user_meta($post_author_id, '_emp_web', true);
/* section bg */
$bg_url = '';
if (isset($nokri['section_bg_img'])) {
    $bg_url = nokri_getBGStyle('section_bg_img');
}
/* Calling Funtion Job Class For Badges */
$job_badge_ul = nokri_premium_job_class_badges($job_id);
/* Advertisement Module */
$advert_up = $advert_down = '';
if (isset($nokri['single_job_advert_switch']) && $nokri['single_job_advert_switch'] == "1") {
    /* Above job desc */
    $advert_html = '';
    if (isset($nokri['single_job_advert_up']) && $nokri['single_job_advert_up'] != "") {
        $advert_up = $nokri['single_job_advert_up'];
    }
    /* Below job desc */
    if (isset($nokri['single_job_advert_down']) && $nokri['single_job_advert_down'] != "") {
        $advert_down = $nokri['single_job_advert_down'];
    }
}
/* Check author profile status */
$emp_profile_status = get_user_meta($post_author_id, '_user_profile_status', true);
$is_public = false;
if ($emp_profile_status == 'pub' || $user_id == $post_author_id) {
    $is_public = true;
}
/* Is map show */
$allow_map = isset($nokri['nokri_allow_map']) ? $nokri['nokri_allow_map'] : true;

$is_lat_long = isset($nokri['allow_lat_lon']) ? $nokri['allow_lat_lon'] : false;
/* Updating Linkedin profile url */
if (isset($_GET['src'])) {
    echo("<script>
		jQuery(window).load(function() {
			 jQuery('#myModal-linkedin').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                });
			});
	</script>");
}
/* Is email job */
$is_email_job = isset($nokri['email_job_anyone_switch']) ? $nokri['email_job_anyone_switch'] : false;
/* Is job alerts */
$job_alerts = ( isset($nokri['job_alerts_switch']) && $nokri['job_alerts_switch'] != "" ) ? $nokri['job_alerts_switch'] : false;
/* Job alert title */
$job_alerts_title = ( isset($nokri['job_alerts_title']) && $nokri['job_alerts_title'] != "" ) ? $nokri['job_alerts_title'] : '';
/* Job alert tagline */
$job_alerts_tagline = ( isset($nokri['job_alerts_tagline']) && $nokri['job_alerts_tagline'] != "" ) ? $nokri['job_alerts_tagline'] : '';
/* Job alert btn */
$job_alerts_btn = ( isset($nokri['job_alerts_btn']) && $nokri['job_alerts_btn'] != "" ) ? $nokri['job_alerts_btn'] : '';
/* Job schema */
$single_job_schema = ( isset($nokri['single_job_schema']) && $nokri['single_job_schema'] != "" ) ? $nokri['single_job_schema'] : '';

$is_nearby = ( isset($nokri['nearby_job_switch']) && $nokri['nearby_job_switch'] != "" ) ? $nokri['nearby_job_switch'] : '';
$nearby_distance = ( isset($nokri['nearby_jobs_distance']) && $nokri['nearby_jobs_distance'] != "" ) ? $nokri['nearby_jobs_distance'] : 10;
$nearby_jobs_number = ( isset($nokri['nearby_jobs_numbers']) && $nokri['nearby_jobs_numbers'] != "" ) ? $nokri['nearby_jobs_numbers'] : 5;
$distance_unit = ( isset($nokri['nearby_jobs_unit']) && $nokri['nearby_jobs_unit'] != "" ) ? $nokri['nearby_jobs_unit'] : 'km';