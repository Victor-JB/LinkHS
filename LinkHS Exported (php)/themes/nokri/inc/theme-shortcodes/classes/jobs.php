<?php

if (!class_exists('jobs')) {

    class jobs {

        var $obj;

        public function __construct() {
            
        }

        /* Search Lay Out 1 */

        function nokri_search_layout_list_1($pid, $col = '', $sm = 6, $holder = '') {
            global $nokri;
            $rtl_class = '';
            if (is_rtl()) {
                $rtl_class = "flip";
            }
            $post_author_id = get_post_field('post_author', $pid);
            $company_name = get_the_author_meta('display_name', $post_author_id);
            /* Getting Company  Profile Photo */
            $comp_img_html = '';
            $rel_image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
            if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
                $rel_image_link = array($nokri['nokri_user_dp']['url']);
            }
            if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
                $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
                $rel_image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
            }
            if ($rel_image_link[0] != '') {
                $comp_img_html = '<div class="n-featured-singel-img">
                                                <a href="javascript:void(0)"><img src="' . esc_url($rel_image_link[0]) . '" class="img-responsive" alt="' . esc_attr__('logo', 'nokri') . '"></a>
                                             </div>';
            }
            $job_deadline_n = get_post_meta($pid, '_job_date', true);
            $job_deadline = date_i18n(get_option('date_format'), strtotime($job_deadline_n));
            $job_salary = wp_get_post_terms($pid, 'job_salary', array("fields" => "ids"));
            $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
            $job_salary_type = wp_get_post_terms($pid, 'job_salary_type', array("fields" => "ids"));
            $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
            $job_experience = wp_get_post_terms($pid, 'job_experience', array("fields" => "ids"));
            $job_experience = isset($job_experience[0]) ? $job_experience[0] : '';
            $job_currency = wp_get_post_terms($pid, 'job_currency', array("fields" => "ids"));
            $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
            $job_type = wp_get_post_terms($pid, 'job_type', array("fields" => "ids"));
            $job_type = isset($job_type[0]) ? $job_type[0] : '';
            /* Jobs aplly with */
            $job_apply_with = get_post_meta($pid, '_job_apply_with', true);
            $job_apply_url = get_post_meta($pid, '_job_apply_url', true);
            $job_apply_mail = get_post_meta($pid, '_job_apply_mail', true);
            /* Calling Funtion Job Class For Badges */
            $job_badge_ul = nokri_premium_job_class_badges($pid);
            $featured_html = '';
            if ($job_badge_ul != '') {
                $featured_html = '<div class="features-star-2"><i class="fa fa-star"></i></div>';
            }
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
            } else {
                $user_id = '';
            }
            $job_bookmark = get_post_meta($pid, '_job_saved_value_' . $user_id, true);
            if ($job_bookmark == '') {
                $save_job = '<a href="javascript:void(0)" class="n-fav-icon save_job" data-value = "' . $pid . '"> <i class="fa fa-heart-o"></i></a>';
            } else {
                $save_job = '<a href="javascript:void(0)" class="n-fav-icon saved" > <i class="fa fa-heart"></i></a>';
            }
            $company_url = get_author_posts_url($post_author_id);
            $company_name = get_the_author_meta('display_name', $post_author_id) . "    ";
            $company_name = '<a href="' . esc_url($company_url) . '" class="" >' . $company_name . '</a>';
            return $my_ads = '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                       <div class="n-featured-single">
                                          <div class="n-featured-single-top">
                                             ' . $comp_img_html . '
                                             <div class="n-featured-singel-meta">
                                                <h4><a href="' . get_the_permalink($pid) . '">' . get_the_title($pid) . '</a></h4>
                                                <div class="n-cat">' . nokri_job_categories_with_chlid($pid) . '</div>
                                                <p><i class="fa fa-user"></i>' . $company_name . '<i class="fa fa-map-marker"></i>' . nokri_job_country($pid, '') . '</p>
												' . $job_badge_ul . '
                                             </div>											 ' . $featured_html . '
                                          </div>
                                          <div class="n-featured-single-bottom">
                                             <ul class="">
                                                <li> <i class="fa fa-clock-o"></i>' . " " . nokri_time_ago() . '</li>
                                                <li>' . nokri_job_post_single_taxonomies('job_currency', $job_currency) . " " . nokri_job_post_single_taxonomies('job_salary', $job_salary) . "/" . nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type) . '</li>
                                                <li> <i class="fa fa-hand-o-right"></i>' . nokri_job_post_single_taxonomies('job_type', $job_type) . '</li>
                                               
                                             </ul>
                                          </div>
                                       </div>
                                    </div>';
        }

        /* Premium jobs */

        function nokri_search_layout_list_2($pid, $col = '', $sm = 6, $holder = '') {

            $jobs_title_limit = '';
            global $nokri;
            $rtl_class = '';
            if (is_rtl()) {
                $rtl_class = "flip";
            }
            $post_author_id = get_post_field('post_author', $pid);
            $company_url = get_author_posts_url($post_author_id);
            $company_name = get_the_author_meta('display_name', $post_author_id);
            $job_type = wp_get_post_terms($pid, 'job_type', array("fields" => "ids"));
            $job_type = isset($job_type[0]) ? $job_type[0] : '';
            $job_salary = wp_get_post_terms($pid, 'job_salary', array("fields" => "ids"));
            $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
            $job_currency = wp_get_post_terms($pid, 'job_currency', array("fields" => "ids"));
            $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
            $job_salary_type = wp_get_post_terms($pid, 'job_salary_type', array("fields" => "ids"));
            $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
            /* Jobs aplly with */
            $job_apply_with = get_post_meta($pid, '_job_apply_with', true);
            $job_apply_url = get_post_meta($pid, '_job_apply_url', true);
            $job_apply_mail = get_post_meta($pid, '_job_apply_mail', true);
            /* Calling Funtion Job Class For Badges */
            $single_job_badges = nokri_job_class_badg($pid);
            $job_badge_text = '';
            if (count((array) $single_job_badges) > 0) {
                foreach ($single_job_badges as $job_badge => $val) {
                    $term_vals = get_term_meta($val);
                    $bg_color = get_term_meta($val, '_job_class_term_color_bg', true);
                    $color = get_term_meta($val, '_job_class_term_color', true);

                    $style_li = $style_anch = '';
                    if ($color != "") {
                        $style_li = 'style=" background-color: ' . $bg_color . ' !important;"';
                        $style_anch = 'style="color: ' . $color . ' !important;"';
                    }
                    $job_badge_text .= '<li ' . $style_li . '><a href="' . get_the_permalink($nokri['sb_search_page']) . '?job_class=' . $val . '" class="job-class-tags-anchor" ' . $style_anch . '>' . esc_html(ucfirst($job_badge)) . '</a></li>';
                }
            }
            /* Getting Profile Photo */
            $rel_image_link[0] = get_template_directory_uri() . '/images/company-logo.jpg';
            if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
                $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
                $rel_image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
            }
            if ($rel_image_link[0] != '') {
                $comp_img_html = '<a href="javascript:void(0)"><img src="' . esc_url($rel_image_link[0]) . '" class="img-responsive" alt="' . esc_attr__('logo', 'nokri') . '"></a>';
            }
            /* Post Title Limit */
            $jobs_title_limit = '12';

            return $my_ads = '<li>
                                    <div class="vertical-single-job ">
                                       <a href="' . get_the_permalink($nokri['sb_search_page']) . '?job_type=' . $job_type . '" class="label">' . nokri_job_post_single_taxonomies('job_type', $job_type) . '</a>
                                       <h4><a href="' . get_the_permalink($pid) . '">' . get_the_title($pid) . '</a></h4>                                              
                                       <p><i class="fa fa-user"></i><a href="' . esc_url($company_url) . '">' . " " . $company_name . '</a></p>
                                       <p><i class="fa fa-map-marker"></i>' . " " . nokri_job_country($pid, '') . '</p>
                                       <p><i class="fa fa-clock-o"></i>' . " " . nokri_time_ago() . '</p>
                                       <span> <i class="fa fa-money"></i>' . nokri_job_post_single_taxonomies('job_currency', $job_currency) . " " . nokri_job_post_single_taxonomies('job_salary', $job_salary) . "/" . nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type) . '</span>
                                    </div>
                                 </li>';
        }

        /* full job style */

        function nokri_search_layout_list_3($pid, $col = '', $sm = 6, $holder = '') {
            $jobs_title_limit = $premium_class = '';
            global $nokri;
            $rtl_class = '';
            if (is_rtl()) {
                $rtl_class = "flip";
            }
            $post_author_id = get_post_field('post_author', $pid);
            $company_name = get_the_author_meta('display_name', $post_author_id);
            $company_url = get_author_posts_url($post_author_id);
            $company_name = '<a href="' . esc_url($company_url) . '" class="" >' . $company_name . '</a>';
            $job_type = wp_get_post_terms($pid, 'job_type', array("fields" => "ids"));
            $job_type = isset($job_type[0]) ? $job_type[0] : '';
            $job_salary = wp_get_post_terms($pid, 'job_salary', array("fields" => "ids"));
            $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
            $job_currency = wp_get_post_terms($pid, 'job_currency', array("fields" => "ids"));
            $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
            $job_salary_type = wp_get_post_terms($pid, 'job_salary_type', array("fields" => "ids"));
            $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
            /* Jobs aplly with */
            $job_apply_with = get_post_meta($pid, '_job_apply_with', true);
            $job_apply_url = get_post_meta($pid, '_job_apply_url', true);
            $job_apply_mail = get_post_meta($pid, '_job_apply_mail', true);

            /* Calling Funtion Job Class For Badges */
            $job_badge_ul = nokri_premium_job_class_badges($pid);

            $featured_html = $job_badge_text = '';
            if ($job_badge_ul != '') {
                $featured_html = '<div class="features-star-2"><i class="fa fa-star"></i></div>';
                $job_badge_text = nokri_premium_job_class_badges($pid);
                $premium_class = 'featured-box';
            }
            /* Getting Profile Photo */
            $rel_image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
            if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
                $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
                $rel_image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
            }
            if ($rel_image_link[0] != '') {
                $comp_img_html = '<div class="n-job-img"><img src="' . esc_url($rel_image_link[0]) . '" alt="' . esc_attr__("image", "nokri") . '" class="img-responsive"></div>';
            }
            /* save job */
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
            } else {
                $user_id = '';
            }
            $job_bookmark = get_post_meta($pid, '_job_saved_value_' . $user_id, true);
            if ($job_bookmark == '') {
                $save_job = '<a href="javascript:void(0)" class="n-job-saved save_job" data-value = "' . $pid . '"><i class="fa fa-heart-o"></i></a>';
            } else {
                $save_job = '<a href="javascript:void(0)" class="n-job-saved saved"><i class="fa fa-heart"></i></a>';
            }

            /* Getting Last Child Value */
            $job_categories = array();
            $project = '';
            $job_categories = wp_get_object_terms($pid, array('job_category'), array('orderby' => 'term_group'));
            if (!empty($job_categories)) {
                $last_cat = '';
                foreach ($job_categories as $c) {
                    $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'cat-id', esc_attr($c->term_id));
                    $final_url = esc_url(nokri_page_lang_url_callback($link));
                    $project = '<a href="' . $final_url . '">' . $c->name . '</a>';
                }
            }

            /* Getting Last country value */
//            $job_locations = array();
//            $last_location = '';
//            $job_locations = wp_get_object_terms($pid, array('ad_location'), array('orderby' => 'term_group'));
//            if (!empty($job_locations)) {
//                foreach ($job_locations as $location) {
//                    $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job-location', esc_attr($location->term_id));
//                    $final_url = esc_url(nokri_page_lang_url_callback($link));
//                    $last_location = '<a href="' . $final_url . '">' . $location->name . '</a>';
//                }
//            }

            /* Getting Last country value */

            $last_location = nokri_job_country($pid);

            //indeed job format location
            $format_location = get_post_meta($pid, 'job_format_location', true);

            if ($last_location == '') {

                $last_location = '<a href="">' . $format_location . '</a>';
            }
            /* Job Location Remotely work/Custom Location */
            $job_country_location = nokri_work_location_custom($pid);
            if ($job_country_location != '') {

                $job_working_location = $job_country_location;
            } else {
                $job_working_location = $last_location;
            }
            /* Jobs aplly with */
            $exter_apply_btn = nokri_apply_with_external_source($pid);
            $report_btn = esc_html__('Report job', 'nokri');
            return $my_ads = '<div class="n-job-single ' . esc_attr($premium_class) . '">
                                    ' . $comp_img_html . '
                                    <div class="n-job-detail">
									' . $featured_html . '
                                       <ul class="list-inline">
                                          <li class="n-job-title-box">
                                             <h4><a href="' . get_the_permalink($pid) . '">' . get_the_title($pid) . '</a></h4>
                                                 <p class="company-name">' . $company_name . '</p>
                                             <p>
											 <span><i class="ti-location-pin"></i>' . " " . $job_working_location . '</span><span><i class="ti-tag"></i>' . " " . $project . '</span>
											 </p>
											 ' . ($job_badge_text) . '
                                          </li>
                                          <li class="n-job-short">
                                             <span> <strong>' . nokri_feilds_label('type_txt', esc_html__('Job type', 'nokri')) . '</strong>' . nokri_job_post_single_taxonomies('job_type', $job_type) . '</span>
                                             <span> <strong>' . esc_html__("Posted:", "nokri") . '</strong>' . " " . nokri_time_ago() . '</span>
                                          </li>
                                          <li class="n-job-btns">
                                            ' . $exter_apply_btn . '
                                          </li>                             
                                       </ul>
                                    </div>
                                    
                                 </div>';
        }

        /* map search style */

        function nokri_search_layout_list_4($pid, $col = '', $sm = 6, $holder = '') {
            $jobs_title_limit = '';
            global $nokri;
            $rtl_class = '';
            if (is_rtl()) {
                $rtl_class = "flip";
            }
            $post_author_id = get_post_field('post_author', $pid);
            $job_type = wp_get_post_terms($pid, 'job_type', array("fields" => "ids"));
            $job_type = isset($job_type[0]) ? $job_type[0] : '';
            $job_salary = wp_get_post_terms($pid, 'job_salary', array("fields" => "ids"));
            $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
            $job_currency = wp_get_post_terms($pid, 'job_currency', array("fields" => "ids"));
            $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
            $job_salary_type = wp_get_post_terms($pid, 'job_salary_type', array("fields" => "ids"));
            $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
            $job_address = get_post_meta($pid, '_job_address', true);
            /* Jobs aplly with */
            $exter_apply_btn = nokri_apply_with_external_source($pid);
            /* Calling Funtion Job Class For Badges */
            $single_job_badges = nokri_job_class_badg($pid);
            $featured_html = $premium_val = $premium_class = $job_badge_text = '';
            if (count((array) $single_job_badges) > 0) {
                $premium_class = 'featured-box';
                foreach ($single_job_badges as $job_badge => $val) {
                    $term_vals = get_term_meta($val);
                    $bg_color = get_term_meta($val, '_job_class_term_color_bg', true);
                    $color = get_term_meta($val, '_job_class_term_color', true);
                    $style_li = $style_anch = '';
                    if ($color != "") {
                        $style_li = 'style=" background-color: ' . $bg_color . ' !important;"';
                        $style_anch = 'style="color: ' . $color . ' !important;"';
                    }

                    $premium_val = get_post_meta($pid, 'package_job_class_' . $val, true);
                    $featured_html = ' <div class="features-star-2"><i class="fa fa-star"></i></div>';
                    $job_badge_text .= '<li ' . $style_li . '><a href="' . get_the_permalink($nokri['sb_search_page']) . '?job_class=' . $val . '" class="job-class-tags-anchor" ' . $style_anch . '>' . esc_html(ucfirst($job_badge)) . '</a></li>';
                }
            }
            /* Getting Profile Photo */
            $rel_image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
            if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
                $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
                $rel_image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
            }
            if ($rel_image_link[0] != '') {
                $comp_img_html = '<div class="n-job-img"><img src="' . esc_url($rel_image_link[0]) . '" alt="' . esc_attr__("image", "nokri") . '" class="img-responsive"></div>';
            }
            /* save job */
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
            } else {
                $user_id = '';
            }
            $job_bookmark = get_post_meta($pid, '_job_saved_value_' . $user_id, true);
            if ($job_bookmark == '') {
                $save_job = '<a href="javascript:void(0)" class="n-job-saved save_job" data-value = "' . $pid . '"><i class="fa fa-heart-o"></i></a>';
            } else {
                $save_job = '<a href="javascript:void(0)" class="n-job-saved saved"><i class="fa fa-heart"></i></a>';
            }
            /* Getting Last Child Value */
            $job_categories = array();
            $project = '';
            $job_categories = wp_get_object_terms($pid, array('job_category'), array('orderby' => 'term_group'));
            if (!empty($job_categories)) {
                $last_cat = '';
                foreach ($job_categories as $c) {
                    $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'cat-id', esc_attr($c->term_id));
                    $final_url = esc_url(nokri_page_lang_url_callback($link));
                    $project = '<a href="' . $final_url . '">' . $c->name . '</a>';
                }
            }

            /* Getting Last country value */
            $job_locations = array();
            $last_location = '';
            $job_locations = wp_get_object_terms($pid, array('ad_location'), array('orderby' => 'term_group'));
            if (!empty($job_locations)) {
                foreach ($job_locations as $location) {
                    $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job-location', esc_attr($location->term_id));
                    $final_url = esc_url(nokri_page_lang_url_callback($link));
                    $last_location = '<a href="' . $final_url . '">' . $location->name . '</a>';
                }
            }

            /* Job Location Remotely work/Custom Location */
            $job_country_location = nokri_work_location_custom($pid);
            if ($job_country_location != '') {

                $job_working_location = $job_country_location;
            } else {
                $job_working_location = $last_location;
            }
            return $my_ads = '<div class="n-job-single">
                                        <div class="n-job-detail">
                                           <ul class="list-inline">
                                              <li class="n-job-title-box">
                                                <h4><a href="' . get_the_permalink($pid) . '">' . get_the_title($pid) . '</a></h4>
                                                 <p><i class="ti-location-pin"></i> <a href="javascript:void(0)">' . " " . $job_working_location . '</a></p>
                                              </li>
                                              <li class="n-job-short">
                                             <span> <strong>' . esc_html__("Type:", "nokri") . '</strong>' . nokri_job_post_single_taxonomies('job_type', $job_type) . '</span>
                                             <span> <strong>' . esc_html__("Posted:", "nokri") . '</strong>' . " " . nokri_time_ago() . '</span>
                                          </li>
                                              <li class="n-job-btns">
                                                 ' . $exter_apply_btn . '
                                              </li>
                                           </ul>
                                        </div>
                                     </div>';
        }

        //class end
    }

}