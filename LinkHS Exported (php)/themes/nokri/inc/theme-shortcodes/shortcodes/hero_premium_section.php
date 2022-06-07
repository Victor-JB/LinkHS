<?php

/* ------------------------------------------------ */
/*    		 Premium Jobs                   */
/* ------------------------------------------------ */
if (!function_exists('hero_premium_section')) {

    function hero_premium_section() {
        vc_map(array(
            "name" => esc_html__("Hero Premium Section", 'nokri'),
            "base" => "hero_premium_section",
            "category" => esc_html__("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('hero_premium_section.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "attach_image",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Select background image", 'nokri'),
                    "param_name" => "section_img",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Heading", 'nokri'),
                    "param_name" => "section_heading",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Tagline", 'nokri'),
                    "param_name" => "section_tagline",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Hide/show tabs and slider", 'nokri'),
                    "param_name" => "tabs_slider_switch",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select an option', 'nokri') => '',
                        esc_html__('Show', 'nokri') => '1',
                        esc_html__('Hide', 'nokri') => '0',
                    ),
                ),
                array(
                    "group" => esc_html__("Categories", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Hide/Show Categories Slider", 'nokri'),
                    "param_name" => "slider_cat_switch",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select an option', 'nokri') => '',
                        esc_html__('Show', 'nokri') => '1',
                        esc_html__('Hide', 'nokri') => '0',
                    ),
                ),
                array
                    (
                    "group" => esc_html__("Categories", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Categories', 'nokri'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'nokri'),
                            "param_name" => "cat",
                            "admin_label" => true,
                            "value" => nokri_get_parests('job_category', 'yes'),
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Category Image", 'nokri'),
                            "param_name" => "cat_img",
                            "description" => esc_html__('64x64', 'nokri'),
                        ),
                    )
                ),
                array(
                    "group" => esc_html__("Tabs", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Animation", 'nokri'),
                    "param_name" => "tab_animation",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select your desired', 'nokri') => '',
                        esc_html__('Down', 'nokri') => 'fadeInDown',
                        esc_html__('Left', 'nokri') => 'fadeInLeft',
                        esc_html__('Right', 'nokri') => 'fadeInRight',
                    ),
                ),
                array(
                    "group" => esc_html__("Tabs", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Number fo Jobs", 'nokri'),
                    "param_name" => "job_class_no",
                    "admin_label" => true,
                    "value" => range(1, 50),
                ),
                array(
                    "group" => esc_html__("Tabs", "nokri"),
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
                    "group" => esc_html__("Tabs", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Job Class', 'nokri'),
                    'param_name' => 'job_classes',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "group" => esc_html__("Tabs", "nokri"),
                            "type" => "dropdown",
                            "heading" => esc_html__("Select your desired ones", 'nokri'),
                            "param_name" => "job_class",
                            "admin_label" => true,
                            "value" => nokri_job_class('job_class'),
                        ),
                    )
                ),
                array(
                    "group" => esc_html__("Slider", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Hide/Show Slider", 'nokri'),
                    "param_name" => "slider_switch",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select an option', 'nokri') => '',
                        esc_html__('Show', 'nokri') => '1',
                        esc_html__('Hide', 'nokri') => '0',
                    ),
                ),
                array(
                    "group" => esc_html__("Slider", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Heading", 'nokri'),
                    "param_name" => "slider_title",
                ),
                array
                    (
                    "group" => esc_html__("Slider", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Job Class', 'nokri'),
                    'param_name' => 'slider_jobs_class',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "group" => esc_html__("Slider", "nokri"),
                            "type" => "dropdown",
                            "heading" => esc_html__("Select your desired ones", 'nokri'),
                            "param_name" => "slider_job_class",
                            "admin_label" => true,
                            "value" => nokri_job_class('job_class'),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'hero_premium_section');
if (!function_exists('hero_premium_section_short_base_func')) {

    function hero_premium_section_short_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(array(
            'section_img' => '',
            'job_order' => '',
            'section_clr' => '',
            'section_heading' => '',
            'section_tagline' => '',
            'job_classes' => '',
            'job_class_no' => '',
            'link' => '',
            'slider_title' => '',
            'slider_jobs_class' => '',
            'tab_animation' => '',
            'slider_switch' => '',
            'slider_cat_switch' => '',
            'tabs_slider_switch' => '',
                        ), $atts));
        $job_class_array = array();
        if (isset($atts['slider_jobs_class']) && $atts['slider_jobs_class'] != '') {
            $rows_class = vc_param_group_parse_atts($atts['slider_jobs_class']);
            if ((array) count($rows_class) > 0) {
                foreach ($rows_class as $row) {
                    $job_class_array[] = (isset($row['slider_job_class']) && $row['slider_job_class'] != "") ? $row['slider_job_class'] : array();
                }
            }
        }
        $args1 = array(
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
        $args1 = nokri_wpml_show_all_posts_callback($args1);
        $job_class_slider = new WP_Query($args1);
        $slider_html = '';
        $count = 1;
        if ($job_class_slider->have_posts()) {
            $count = 1;
            while ($job_class_slider->have_posts()) {
                $job_class_slider->the_post();
                $job_id = get_the_ID() . '<br>';
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
                    $rel_image_link[0] = get_template_directory_uri() . '/images/default-job.png';
                }
                /* Calling Funtion Job Class For Badges */
                $job_badge_text = nokri_premium_job_class_badges($job_id);
                if ($job_badge_text != '') {
                    $featured_html = '<div class="features-star"><i class="fa fa-star"></i></div>';
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
                if ($count % 2 == 1) {
                    $slider_html .= '<div class="item">';
                }
                $slider_html .= '<div class="featured-image-box">
                              <div class="img-box"><img src="' . esc_url($rel_image_link[0]) . '" class="img-responsive center-block" alt="' . esc_attr__('logo', 'nokri') . '"></div>
                              <div class="content-area">
                                <div class="">
                                  <h4><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>                                  
                                  <p>' . " " . $last_location . '</p>
                                </div>
                                <div class="feature-post-meta"> <a href=""> <i class="fa fa-clock-o"></i> ' . " " . nokri_time_ago() . '</a>' . nokri_job_search_taxonomy($job_id) . '</div>
                                <div class="feature-post-meta-bottom"> <span> ' . nokri_job_post_single_taxonomies('job_currency', $job_currency) . " " . nokri_job_post_single_taxonomies('job_salary', $job_salary) . " " . '/' . " " . nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type) . '</span>  </div>
                              </div>
                            </div>';
                if ($count % 2 == 0) {
                    $slider_html .= '</div>';
                }
                $count++;
            }
        }

        if ($count % 2 != 1)
            $slider_html .= '</div>';
// For Category Slider Start
        if (isset($atts['cats']) && $atts['cats'] != '') {
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
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($category->term_id, 'job_category');
                        if (count((array) $category) == 0)
                            continue;
                        /* Category Image */
                        $cat_img = '';
                        if (isset($row['cat_img'])) {
                            $img = wp_get_attachment_image_src($row['cat_img'], '');
                            $img_thumb = $img[0];
                            $cat_img = '<img src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri') . '">';
                        }
                        $cats_html .= '<div class="item">
									<a href="' . nokri_cat_link_page($category->term_id) . '">
										' . $cat_img . '
										<h4>' . $category->name . '</h4>
									</a>
								  </div>';
                    }
                }
                if ($cats) {
                    $ad_cats = nokri_get_cats('job_category', 0);
                    /* Category Image */
                    $cat_img = '';
                    if (isset($row['cat_img'])) {
                        $img = wp_get_attachment_image_src($row['cat_img'], '');
                        $img_thumb = $img[0];
                        $cat_img = '<img src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri') . '">';
                    }
                    foreach ($ad_cats as $cat) {

                        $cats_html .= '<div class="item">
									<a href="' . nokri_cat_link_page($cat->term_id) . '">
										' . $cat_img . '
										<h4>' . $cat->name . '</h4>
									</a>
								  </div>';
                    }
                }
            }
        }
// For Category Slider End
        /* Tab animation */
        $tab_animation = (isset($tab_animation) && $tab_animation != "") ? $tab_animation : "fadeInDown";
        /* Job class tabs query starts */
        $rows = vc_param_group_parse_atts($atts['job_classes']);


        if ((array) count($rows) > 0) {
            $tabs_html = $tabs_content = '';
            $count = 1;
            foreach ($rows as $row) {
                $active = '';
                if ($count == 1) {
                    $active = 'active';
                }
                $job_class_array[] = (isset($row['job_class']) && $row['job_class'] != "") ? $row['job_class'] : array();
                $term = get_term($row['job_class'], 'job_class');
                if (count((array) $term)) {
                    $tabs_html .= '<li class="' . esc_attr($active) . '"> <a href="#tab' . $row['job_class'] . '" data-toggle="tab"><span>' . $term->name . '</span></a> </li>';
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
                $tabs_content .= '<div class="tab-pane ' . esc_attr($active) . ' animated ' . $tab_animation . '" id="tab' . $row['job_class'] . '">
                              <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                                <div class="n-search-listing n-featured-jobs">
                              <div class="n-featured-job-boxes">';
                global $nokri;
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
                            $apply_button = '<a href="' . $href . '" class="btn n-btn-rounded  ' . $exter_app . '" data-job-id="' . esc_attr($job_id) . '"  data-job-exter="' . ( $job_apply_url ) . '">' . esc_html($apply_now_text) . '</a>';
                        } else if ($job_apply_with == 'mail') {
                            $apply_button = '<a href="' . $href . '" class="btn n-btn-rounded  ' . $email_app . '" data-job-id="' . esc_attr($job_id) . '" data-job-exter="' . ( $job_apply_mail ) . '">' . esc_html($apply_now_text) . '</a>';
                        } else if ($job_apply_with == 'whatsapp') {
                            $apply_button = '<a href="' . $href_whatsapp . '" class="btn n-btn-rounded  ' . $whatspp_app . '" data-job-id="' . esc_attr($job_id) . '" data-job-exter="' . ( $job_apply_whatsapp ) . '">' . esc_html($apply_now_text) . '</a>';
                        } else {
                            $apply_button = '<a href="' . $href . '" class="btn n-btn-rounded  ' . $simple_app . '" data-toggle="modal" data-target="' . $modal_target . '"  data-job-id=' . esc_attr($job_id) . '>' . esc_html($apply_now_text) . ' </a>';
                        }
                        /* Getting Profile Photo */
                        $rel_image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                        if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
                            $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
                            $rel_image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
                        }
                        if (empty($rel_image_link[0])) {
                            $rel_image_link[0] = get_template_directory_uri() . '/images/default-job.png';
                        }
                        /* Calling Funtion Job Class For Badges */
                        $job_badge_text = nokri_premium_job_class_badges($job_id);
                        if ($job_badge_text != '') {
                            $featured_html = '<div class="features-star"><i class="fa fa-star"></i></div>';
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
                        $tabs_content .= '<div class="n-job-single">
                                    <div class="n-job-img">
                                       <img src="' . esc_url($rel_image_link[0]) . '" alt="' . esc_attr__('logo', 'nokri') . '" class="img-responsive">
                                    </div>
                                    <div class="n-job-detail">
                                       <ul class="list-inline">
                                          <li class="n-job-title-box">
                                                                                     
                                            <h4><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h4>
                                                
                                             <p>' . " " . $last_location . '</p>
                                                  <p>' . $job_badge_text . '</p>  
                                          </li>
                                          <li class="n-job-short">
                                             <span> <strong>' . esc_html__(' Type :', 'nokri') . '</strong>' . nokri_job_post_single_taxonomies('job_type', $job_type) . '</span>
                                             <span> <strong> ' . esc_html__('Date :', 'nokri') . '</strong>' . " " . nokri_time_ago() . '</span>
                                          </li>
                                          <li class="n-job-btns">
                                            ' . $apply_button . '
                                             ' . $save_job . '
                                          </li>
                                       </ul>
                                    </div>
                                 </div>';
                    }
                }
                $tabs_content .= '</div></div> </div></div>';
                $count++;
            }
        }
        /* Job class tabs query End */
        /* Section title */
        $section_heading = (isset($section_heading) && $section_heading != "") ? '<h1>' . $section_heading . '</h1>' : "";
        /* slider title */
        $slider_title = (isset($slider_title) && $slider_title != "") ? '<h4 class="featured-job-sidebar-heading-title">' . $slider_title . '</h4>' : "";
        /* Section description */
        $section_tagline = (isset($section_tagline) && $section_tagline != "") ? '<p>' . $section_tagline . '<p>' : "";
        /* Background Image */
        $bg_img = '';
        if ($section_img != "") {
            $bgImageURL = nokri_returnImgSrc($section_img);
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $bgImageURL . ') no-repeat scroll center center / cover;"' : "";
        }
        /* Slider Switch */
        $slider_final_html = '';
        $tabs_col = 12;
        $slider_switch = (isset($slider_switch) && $slider_switch != "") ? $slider_switch : "1";
        if ($slider_switch) {
            $tabs_col = 8;
            $slider_final_html = '<div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="featured-job-slider-sidebar">
                        ' . $slider_title . '
                        <div class="featured-job-slider owl-carousel owl-theme">
                         ' . $slider_html . '
                        </div>
                    </div>
                </div>';
        }
        /* Slider Cat Switch */
        $slider_cat_html = '';
        $slider_cat_switch = (isset($slider_cat_switch) && $slider_cat_switch != "") ? $slider_cat_switch : "1";
        if ($slider_cat_switch) {
            $slider_cat_html = '<div class="categories-icons">
                        	<div class="featured-cat owl-carousel owl-theme">
                              ' . $cats_html . '
                            </div>
                        </div>';
        }
        /* Tabs slider Switch */
        $tabs_slider_html = '';
        $tabs_slider_switch = (isset($tabs_slider_switch) && $tabs_slider_switch != "") ? $tabs_slider_switch : "1";
        if ($tabs_slider_switch) {
            $tabs_slider_html = '<section class="cat-tabs bg-white">
            <div class="container">
              <div class="row">
                <div class="col-md-' . esc_attr($tabs_col) . ' col-sm-12 col-xs-12">
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-primary">
                          <div class="panel-heading"> 
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                              ' . $tabs_html . '
                            </ul>
                          </div>
                        </div>
                        <div class="panel-body">
                          <div class="tab-content">
                            ' . $tabs_content . '
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                ' . $slider_final_html . '
              </div>
            </div>
          </section>';
        }
        return '<section class="main-section-category" ' . str_replace('\\', "", $bg_img) . '> 
            <div class="container">
              <div class="row">
                <div class="col-md-6 col-sm-8 col-xs-12 ">
                	<div class="main-cat-detail-box">
                    	' . $section_heading . '
                        <hr>
                        <div class="clearfix"></div>
                        ' . $section_tagline . '
                    	<form method="get" action="' . get_the_permalink($nokri['sb_search_page']) . '">
						' . nokri_form_lang_field_callback(false) . '
                          <div class="form-group">
							  <input type="text" class="form-control" name="job-title" placeholder="' . esc_html__('Search here', 'nokri') . '">
                              <button type="submit"><i class="ti-search"></i> </button>
                            </div>
                        </form>
                        ' . $slider_cat_html . '
                    </div>
                </div>
              </div>
            </div>
          </section>
         ' . $tabs_slider_html . '';
    }

}

if (function_exists('nokri_add_code')) {
    nokri_add_code('hero_premium_section', 'hero_premium_section_short_base_func');
}