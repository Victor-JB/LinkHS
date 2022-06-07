<?php

/* ------------------------------------------------ */
/* Premium Jobs with tabs            */
/* ------------------------------------------------ */
if (!function_exists('premium_jobs_with_tabs')) {

    function premium_jobs_with_tabs() {
        vc_map(array(
            "name" => esc_html__("Premium Jobs With Tabs", 'nokri'),
            "base" => "premium_jobs_with_tabs",
            "category" => esc_html__("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => esc_html__('Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('premium_jobs_with_tabs.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
                ),
                /* Trending Categories starts */
                array(
                    "group" => esc_html__("Categories", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Hide/Show Categories", 'nokri'),
                    "param_name" => "cat_switch",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select an option', 'nokri') => '',
                        esc_html__('Show', 'nokri') => '1',
                        esc_html__('Hide', 'nokri') => '0',
                    ),
                ),
                array(
                    "group" => esc_html__("Categories", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Heading", 'nokri'),
                    "param_name" => "cat_title",
                    'dependency' => array('element' => 'cat_switch', 'value' => array('1')),
                ),
                array(
                    "group" => esc_html__("Categories", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'nokri'),
                    "param_name" => "cat_description",
                    'dependency' => array('element' => 'cat_switch', 'value' => array('1')),
                ),
                array
                    (
                    "group" => esc_html__("Categories", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Categories', 'nokri'),
                    'param_name' => 'cats',
                    'value' => '',
                    'dependency' => array('element' => 'cat_switch', 'value' => array('1')),
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'nokri'),
                            "param_name" => "cat",
                            "admin_label" => true,
                            "value" => nokri_get_parests('job_category', 'yes'),
                        ),
                    )
                ),
                /* Jobs Tab Start */
                array(
                    "group" => esc_html__("Job Tabs", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Hide/Show Tabs", 'nokri'),
                    "param_name" => "jobs_switch",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select an option', 'nokri') => '',
                        esc_html__('Show', 'nokri') => '1',
                        esc_html__('Hide', 'nokri') => '0',
                    ),
                ),
                array(
                    "group" => esc_html__("Job Tabs", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Heading", 'nokri'),
                    "param_name" => "jobs_heading",
                ),
                array(
                    "group" => esc_html__("Job Tabs", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'nokri'),
                    "param_name" => "jobs_description",
                ),
                array(
                    "group" => esc_html__("Job Tabs", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Number Of Jobs", 'nokri'),
                    "param_name" => "job_class_no",
                    "admin_label" => true,
                    "value" => range(1, 50),
                ),
                array(
                    "group" => esc_html__("Job Tabs", "nokri"),
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
                array(
                    "group" => esc_html__("Job Tabs", "nokri"),
                    "type" => "vc_link",
                    "heading" => esc_html__("All Jobs", 'nokri'),
                    "param_name" => "link",
                ),
                array
                    (
                    "group" => esc_html__("Job Tabs", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Job Class', 'nokri'),
                    'param_name' => 'job_classes',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Select your desired ones", 'nokri'),
                            "param_name" => "job_class",
                            "admin_label" => true,
                            "value" => nokri_job_class('job_class'),
                        ),
                    )
                ),
            /* Jobs Tab End */
            ),
        ));
    }

}

add_action('vc_before_init', 'premium_jobs_with_tabs');
if (!function_exists('premium_jobs_with_tabs_short_base_func')) {

    function premium_jobs_with_tabs_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'cat_switch' => '',
            'cat_title' => '',
            'cat_description' => '',
            'cats' => '',
            'cat' => '',
            'jobs_switch' => '',
            'jobs_heading' => '',
            'jobs_description' => '',
            'job_class_no' => '',
            'job_order' => '',
            'job_classes' => '',
            'job_class' => '',
            'link' => '',
                        ), $atts));
        global $nokri;
        /* Categories Section  Title */
        $cat_titles = (isset($cat_title) && $cat_title != "") ? '<h3>' . $cat_title . '</h3>' : '';
        /* Categories Section Description  */
        $cat_descriptions = (isset($cat_description) && $cat_description != "") ? '<p>' . $cat_description . '</p>' : '';
        /* View  Link */
        $read_more = '';
        if (isset($link)) {
            $read_more = '<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12"><div class="n-jobs-featured">' . nokri_ThemeBtn($link, 'btn n-btn-flat', false) . '</div></div>';
        }
        // For Job Category
        if (isset($atts['cats']) && !empty($atts['cats']) != '') {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $cats = false;
            $cats_html = '';
            if (count((array) $rows) > 0) {
                $cats_html = '';
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        if ($row['cat'] == 'all') {
                            $cats = true;
                            break;
                        }
                        $category = get_term_by('slug', $row['cat'], 'job_category');
                        if (count((array) $category) == 0)
                            continue;
                        $cats_html .= '<a href="' . nokri_cat_link_page($category->term_id) . '">' . $category->name . '</a>';
                    }
                }
            }
        }
        if ($cats) {
            $ad_cats = nokri_get_cats('job_category', 0);
            foreach ($ad_cats as $cat) {
                $cats_html .= '<a href="' . nokri_cat_link_page($cat->term_id) . '">' . $cat->name . '</a>';
            }
        }
        $cat_section = '';
        if (isset($cat_switch) && $cat_switch == "1") {
            $cat_section = '<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
							<div class="heading-penel">
								' . $cat_titles . '
								' . $cat_descriptions . '
							</div>
						</div>
						<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
							<div class="n-grid-style"> 
							' . $cats_html . '
							</div>
						</div>';
        }
        /* Categories Section End  */
        /* Job class tabs query starts */
        if (isset($atts['job_classes']) && !empty($atts['job_classes']) != '') {
            $rows = vc_param_group_parse_atts($atts['job_classes']);
            if ((array) count($rows) > 0) {
                $tabs_html = $tabs_content = '';
                $count = 1;
                foreach ($rows as $row) {
                    $active = $active_in = '';
                    if ($count == 1) {
                        $active = 'active';
                        $active_in = 'active in';
                    }
                    $job_class_array[] = (isset($row['job_class']) && $row['job_class'] != "") ? $row['job_class'] : array();
                    $term = get_term($row['job_class'], 'job_class');
                    $tabs_html .= '<li class="' . esc_attr($active) . '"> <a href="#tab' . $row['job_class'] . '" data-toggle="tab"><span>' . $term->name . '</span></a> </li>';
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
                                'terms' => $row['job_class'],
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
                    $tabs_content .= '<div id="tab' . $row['job_class'] . '" class="tab-pane fade ' . esc_attr($active_in) . '">
								  <div class="row">';
                    $job_class_query = new WP_Query($args);
                    $job_class_html = '';
                    if ($job_class_query->have_posts()) {
                        while ($job_class_query->have_posts()) {
                            $job_class_query->the_post();
                            $job_id = get_the_ID();
                            $author_id = get_post_field('post_author', $job_id);
                            /* Getting Profile Photo */
                            $img = nokri_get_user_profile_pic($author_id, '_sb_user_pic');
                            $job_type = wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
                            $job_type = isset($job_type[0]) ? $job_type[0] : '';
                            $job_salary = wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
                            $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
                            $job_currency = wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
                            $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
                            $job_salary_type = wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
                            $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
                            $location = nokri_job_country($job_id, '');
                            /* save job */
                            $user_id = '';
                            if (is_user_logged_in()) {
                                $user_id = get_current_user_id();
                            }
                            $job_bookmark = get_post_meta($job_id, '_job_saved_value_' . $user_id, true);
                            if ($job_bookmark == '') {
                                $save_job = '<a href="javascript:void(0)" class="n-jobs-rating save_job" data-value = "' . $job_id . '"><i class="fa fa-heart-o"></i></a>';
                            } else {
                                $save_job = '<a href="javascript:void(0)" class="n-jobs-rating saved"><i class="fa fa-heart-o"></i></a>';
                            }
                            /* Getting Catgories */
                            $categories = nokri_job_categories_with_chlid($job_id, 'job_category');
                            /* Jobs aplly with */
                            $apply_button = '';
                            $job_apply_with = get_post_meta($job_id, '_job_apply_with', true);
                            $job_apply_url = get_post_meta($job_id, '_job_apply_url', true);
                            $job_apply_mail = get_post_meta($job_id, '_job_apply_mail', true);
                            $job_apply_whatsapp = get_post_meta($job_id, '_job_apply_whatsapp', true);

                            $apply_status = nokri_job_apply_status($job_id);
                            $apply_now_text = esc_html__('Apply now', 'nokri');
                            if ($apply_status != "") {
                                $apply_now_text = esc_html__('Applied', 'nokri');
                            }


                            $href = "javascript:void(0)";
                            $exter_app = "external_apply";
                            $email_app = "email_apply";
                            $whatspp_app = "whatsapp_apply";
                            $simple_app = "apply_job";
                            $modal_target = "#myModal";
                          $href_whatsapp = "https://api.whatsapp.com/send?phone=$job_apply_whatsapp";

                            if (isset($nokri['job_apply_on_detail']) && $nokri['job_apply_on_detail']) {

                                $href = get_the_permalink($job_id);
                                $exter_app = "";
                                $email_app = "";
                                $whatspp_app = "";
                                $simple_app = "";
                                $modal_target = "";
                                $href_whatsapp = get_the_permalink($job_id);
                            }

                            if ($job_apply_with == 'exter') {
                                $apply_button = '<a href="'.$href.'" class="'.$exter_app.'" data-job-id="' . esc_attr($job_id) . '"  data-job-exter="' . ( $job_apply_url ) . '">' . esc_html($apply_now_text) . '</a>';
                            } else if ($job_apply_with == 'mail') {
                                $apply_button = '<a href="'.$href.'" class="'.$email_app.'" data-job-id="' . esc_attr($job_id) . '" data-job-exter="' . ( $job_apply_mail ) . '">' . esc_html($apply_now_text). '</a>';
                            }
                             else if ($job_apply_with == 'whatsapp') {
                                $apply_button = '<a href="'.$href_whatsapp.'" class="'.$whatspp_app.'" data-job-id="' . esc_attr($job_id) . '" data-job-exter="' . ( $job_apply_whatsapp ) . '">' . esc_html($apply_now_text). '</a>';
                            }                            
                            else {
                                $apply_button = '<a href="'.$href.'" class="'.$simple_app.'" data-toggle="modal" data-target="'.$modal_target.'"  data-job-id=' . esc_attr($job_id) . '>' . esc_html($apply_now_text). ' </a>';
                            }
                            $tabs_content .= '<div class="col-lg-6 col-xs-12 col-sm-12 col-md-6">
												<div class="n-categories-content">
												  <div class="n-keywords-jobs-category">
												   ' . $save_job . '
													<div class="n-keywords-jobs">
														 <img src="' . $img . '" alt="' . esc_attr__('image', 'nokri') . '" class="img-responsive">
													</div>
													<div class="n-keword-jobs-details">
													 <span>' . $categories . '</span> 
													 <a href="' . get_the_permalink() . '">
													  <div class="n-jobs-title">' . get_the_title() . '</div>
													  </a>
														 <p><i class="fa fa-map-marker"></i>' . $location . '</p>
													</div>
												  </div>
												  <div class="n-apply-jobs">
													<ul>
													  <li><i class="fa fa-clock-o"></i>' . " " . nokri_time_ago() . '</li>
													  <li>' . nokri_job_post_single_taxonomies('job_currency', $job_currency) . " " . nokri_job_post_single_taxonomies('job_salary', $job_salary) . " " . '/' . " " . nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type) . '</li>
													  <li class="style-right">
														' . $apply_button . '
													  </li>
													</ul>
												  </div>
												</div>
											  </div>';
                        }
                        $tabs_content .= $read_more;
                    }
                    $tabs_content .= '</div></div>';
                    $count++;
                }
            }
        }
        /* Section title */
        $section_title = (isset($jobs_heading) && $jobs_heading != "") ? '<h2>' . $jobs_heading . '</h2>' : "";
        /* Section description */
        $section_description = (isset($jobs_description) && $jobs_description != "") ? '<p>' . $jobs_description . '<p>' : "";
        return '<section class="n-keywords">
					<div class="container">
					  <div class="row">
						' . $cat_section . '
						<div class="clearfix"></div>
						<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
						  <div class="n-listing-text">
							' . $section_title . '
							' . $section_description . '
						  </div>
						  <div class="">
							<ul class="nav nav-tabs">
							' . $tabs_html . '
							</ul>
							<div class="tab-content">
							' . $tabs_content . '
							</div>
						  </div>
						</div>
					  </div>
					</div>
				  </section>';
    }

}
if (function_exists('nokri_add_code')) {
    nokri_add_code('premium_jobs_with_tabs', 'premium_jobs_with_tabs_short_base_func');
}