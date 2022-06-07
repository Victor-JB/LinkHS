<?php

/* ------------------------------------------------ */
/*    		 Premium Jobs                   */
/* ------------------------------------------------ */
if (!function_exists('premium_jobs')) {

    function premium_jobs() {
        vc_map(array(
            "name" => esc_html__("Premium Jobs", 'nokri'),
            "base" => "premium_jobs",
            "category" => esc_html__("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('nokri_premium_jobs.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'nokri'),
                    "param_name" => "section_title",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Details", 'nokri'),
                    "param_name" => "section_description",
                ),
                array(
                    "group" => esc_html__("Settings", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Number fo Jobs", 'nokri'),
                    "param_name" => "job_class_no",
                    "admin_label" => true,
                    "value" => range(1, 50),
                ),
                array(
                    "group" => esc_html__("Settings", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Order By", 'nokri'),
                    "param_name" => "job_order",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Job order', 'nokri') => '',
                        esc_html__('ASC', 'nokri') => 'asc',
                        esc_html__('DESC', 'nokri') => 'desc',
                    ),
                ),
                array
                    (
                    "group" => esc_html__("Job Class", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Job Class', 'nokri'),
                    'param_name' => 'job_classes',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "group" => esc_html__("Job Class", "nokri"),
                            "type" => "dropdown",
                            "heading" => esc_html__("Select Your Desired ones", 'nokri'),
                            "param_name" => "job_class",
                            "admin_label" => true,
                            "value" => nokri_job_class('job_class'),
                        ),
                    )
                ),
                array(
                    'group' => esc_html__('Link', 'nokri'),
                    "type" => "vc_link",
                    "heading" => esc_html__("All Link", 'nokri'),
                    "param_name" => "link",
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'premium_jobs');

if (!function_exists('premium_jobs_short_base_func')) {

    function premium_jobs_short_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(array(
            'job_order' => '',
            'section_clr' => '',
            'section_title' => '',
            'section_description' => '',
            'job_classes' => '',
            'job_class_no' => '',
            'link' => '',
                        ), $atts));
        global $nokri;
        $job_class_array = array();

        if (isset($atts['job_classes']) && !empty($atts['job_classes']) != '') {
            $rows = vc_param_group_parse_atts($atts['job_classes']);

            if ((array) count($rows) > 0) {
                foreach ($rows as $row) {
                    $job_class = nokri_show_taxonomy_all($row['job_class'], 'job_class');
                    if ($job_class != '') {

                        $job_class_array[] = $job_class;
                    }
                }
            }
        }
        $args = array(
            'post_type' => 'job_post',
            'order' => 'date',
            'orderby' => $job_order,
            'posts_per_page' => $job_class_no,
            'post_status' => array('publish'),
            'tax_query' => array(
                array(
                    'taxonomy' => 'job_class',
                    'field' => 'term_id',
                    'terms' => $job_class_array,
                )
            ),
            'meta_query' => array(
                array(
                    'key' => '_job_status',
                    'value' => 'active',
                    'compare' => '='
                )
            )
        );

        global $nokri;
        $args = nokri_wpml_show_all_posts_callback($args);
        $job_class_query = new WP_Query($args);
        $job_class_html = '';
        if ($job_class_query->have_posts()) {
            while ($job_class_query->have_posts()) {
                $job_class_query->the_post();
                $job_id = get_the_ID();
                $post_author_id = get_post_field('post_author', $job_id);
                $job_type = wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
                $job_type = isset($job_type[0]) ? $job_type[0] : '';
                $job_salary = wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
                $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
                $job_currency = wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
                $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
                $job_salary_type = wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
                $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';

                /* Getting Profile Photo */
                $rel_image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
                    $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
                    $rel_image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
                }
                if (empty($rel_image_link[0])) {
                    $rel_image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                }
                /* save job */
                if (is_user_logged_in()) {
                    $user_id = get_current_user_id();
                } else {
                    $user_id = '';
                }
                $job_bookmark = get_post_meta($job_id, '_job_saved_value_' . $user_id, true);
                if ($job_bookmark == '') {
                    $save_job = '<a href="javascript:void(0)" class="n-job-saved save_job" data-value = "' . $job_id . '"><i class="fa fa-heart-o"></i></a>';
                } else {
                    $save_job = '<a href="javascript:void(0)" class="n-job-saved saved"><i class="fa fa-heart"></i></a>';
                }

                /* Calling Funtion Job Class For Badges */
                $job_badge_text = nokri_premium_job_class_badges($job_id);
                if ($job_badge_text != '') {
                    $featured_html = '<div class="features-star-2"><i class="fa fa-star"></i></div>';
                }
                /* Getting Last Child Value */
                $job_categories = array();
                $project = '';
                $job_categories = wp_get_object_terms($job_id, array('job_category'), array('orderby' => 'term_group'));
                if (!empty($job_categories)) {
                    $last_cat = '';
                    foreach ($job_categories as $c) {
                        $search_url = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'cat-id', $c->term_id);
                        $project = '<a href="' . esc_url(nokri_page_lang_url_callback($search_url)) . '">' . $c->name . '</a>';
                    }
                }
                /* Getting Last country value */
                $job_locations = array();
                $last_location = '';
                $job_locations = wp_get_object_terms($job_id, array('ad_location'), array('orderby' => 'term_group'));
                if (!empty($job_locations)) {
                    foreach ($job_locations as $location) {
                        $search_url = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job-location', $location->term_id);
                        $last_location = '<a href="' . esc_url(nokri_page_lang_url_callback($search_url)) . '">' . $location->name . '</a>';
                    }
                }

                /* Job Location Remotely work/Custom Location */
                $job_country_location = nokri_work_location_custom($job_id);
                if ($job_country_location != '') {

                    $job_working_location = $job_country_location;
                } else {
                    $job_working_location = $last_location;
                }

                /* Jobs aplly with */

                $exter_apply_btn = nokri_apply_with_external_source($job_id);
                $post_author_id = get_post_field('post_author', $job_id);
                $company_name = get_the_author_meta('display_name', $post_author_id);
                $company_url = get_author_posts_url($post_author_id);
                $company_name = '<a href="' . esc_url($company_url) . '" class="" >' . $company_name . '</a>';
                $job_class_html .= '<div class="n-job-single">
                    <div class="n-job-img">
                        <img src="' . esc_url($rel_image_link[0]) . '" alt="' . esc_attr__('logo', 'nokri') . '" class="img-responsive">
                    </div>
                    <div class="n-job-detail">
					' . $featured_html . '
                        <ul class="list-inline">
                            <li class="n-job-title-box">
                            	<h4> <a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>
                                    <p class="company-name">' . $company_name . '</p>
                                <p><span><i class="ti-location-pin"></i>' . " " . $job_working_location . '</span>
								   <span><i class="ti-tag"></i>' . " " . $project . '</span></p>
								 ' . $job_badge_text . '
                            </li>
                            <li class="n-job-short">
                            	<span> <strong>' . esc_html__('Type', 'nokri') . '</strong>' . nokri_job_post_single_taxonomies('job_type', $job_type) . '</span>
                                <span> <strong>' . esc_html__('Time:', 'nokri') . '</strong>' . nokri_time_ago() . '</span>
                            </li>
                            <li class="n-job-btns">
							' . $exter_apply_btn . '
                             ' . "" . ($save_job) . '
                            </li>
                        </ul>
                    </div>
                </div>';
            }
        }
        /* View  Link */
        $read_more = '';
        if (isset($link)) {
            $read_more = nokri_ThemeBtn($link, 'btn n-btn-flat btn-mid btn-clear', false);
        }
        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? '<h2>' . $section_title . '</h2>' : "";
        /* Section description */
        $section_description = (isset($section_description) && $section_description != "") ? '<p>' . $section_description . '<p>' : "";
        return '<section class="n-featured-jobs">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <div class="heading-title black">
              ' . $section_title . '
			  ' . $section_description . '
            </div>
          </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	<div class="n-featured-job-boxes">
                ' . $job_class_html . '
            </div>
            <div class="n-extra-btn-section">
            	' . $read_more . '
            </div>
        </div>
      </div>
    </div>
  </section>';
    }

}

if (function_exists('nokri_add_code')) {
    nokri_add_code('premium_jobs', 'premium_jobs_short_base_func');
}