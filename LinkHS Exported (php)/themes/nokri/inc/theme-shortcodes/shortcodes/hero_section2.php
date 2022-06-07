<?php

/* ------------------------------------------------ */
/* Hero section - Tabs */
/* ------------------------------------------------ */
if (!function_exists('hero_section2')) {

    function hero_section2() {
        vc_map(array(
            "name" => esc_html__("Hero Section 2", 'nokri'),
            "base" => "hero_section2",
            "category" => esc_html__("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => esc_html__('Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('hero_section2.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "attach_image",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'nokri'),
                    "param_name" => "search_section_img",
                    "description" => esc_html__('1263 x 147', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Heading", 'nokri'),
                    "param_name" => "section_title",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Keyword title", 'nokri'),
                    "param_name" => "keyword_title",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Category title", 'nokri'),
                    "param_name" => "cats_title",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Location title", 'nokri'),
                    "param_name" => "locat_title",
                ),
                array
                    (
                    "group" => esc_html__("Categories", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select categories ( All or Selective )', 'nokri'),
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
                    )
                ),
                array(
                    "group" => esc_html__("Categories", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Do you want to show Sub Categories", 'nokri'),
                    "param_name" => "want_to_show",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('yes', 'nokri') => 'yes',
                        esc_html__('no', 'nokri') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                ),
                array
                    (
                    "group" => esc_html__("Location", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Countries ( All or Selective )', 'nokri'),
                    'param_name' => 'countries',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Select Country", 'nokri'),
                            "param_name" => "country",
                            "admin_label" => true,
                            "value" => nokri_get_all('ad_location', 'yes'),
                        ),
                    )
                ),
                array(
                    "group" => esc_html__("Location", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Do you want to show Sub Locations", 'nokri'),
                    "param_name" => "want_to_show_loc",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('yes', 'nokri') => 'yes',
                        esc_html__('no', 'nokri') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                ),
                array(
                    "group" => esc_html__("Side Button", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Tagline", 'nokri'),
                    "param_name" => "side_tagline",
                ),
                array(
                    "group" => esc_html__("Side Button", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Heading", 'nokri'),
                    "param_name" => "side_title",
                ),
                array(
                    'group' => esc_html__('Candidates Button', 'nokri'),
                    "type" => "textfield",
                    "heading" => esc_html__("Resume button text", 'nokri'),
                    "param_name" => "resume_btn_txt",
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'hero_section2');
if (!function_exists('hero_section2_short_base_func')) {

    function hero_section2_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'cats' => '',
            'section_title' => '',
            'section_tagline' => '',
            'section_details' => '',
            'stories' => '',
            'countries' => '',
            'want_to_show' => '',
            'search_section_img' => '',
            'sidebar_title' => '',
            'keyword_title' => '',
            'cats_title' => '',
            'locat_title' => '',
            'side_tagline' => '',
            'side_title' => '',
            'resume_btn_txt' => '',
            'want_to_show_loc'=>'',
                        ), $atts));
        global $nokri;
        if (isset($want_to_show) && $want_to_show == "yes") {
            
        }
        // For Job Category
        if (isset($atts['cats']) && !empty($atts['cats']) != '') {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $cats = false;
            $cats_html = '';
            if (count($rows) > 0) {
                $cats_html .= '';
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        if ($row['cat'] == 'all') {
                            $cats = true;
                            $cats_html = '';
                            break;
                        }
                        $category = get_term_by('slug', $row['cat'], 'job_category');
                        if (count((array)$category) == 0)
                            continue;

                        if (isset($want_to_show) && $want_to_show == "yes") {

                            $ad_cats_sub = nokri_get_cats('job_category', $category->term_id);
                            if (count($ad_cats_sub) > 0) {
                                $cats_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                                foreach ($ad_cats_sub as $ad_cats_subz) {
                                    $cats_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                                }
                                $cats_html .= '</option>';
                            } else {
                                $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                            }
                        } else {
                            $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    }
                }

                if ($cats) {
                    $ad_cats = nokri_get_cats('job_category', 0);
                    foreach ($ad_cats as $cat) {
                        if (isset($want_to_show) && $want_to_show == "yes") {
                            //sub cat
                            $ad_sub_cats = nokri_get_cats('job_category', $cat->term_id);
                            if (count($ad_sub_cats) > 0) {
                                $cats_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                                foreach ($ad_sub_cats as $sub_cat) {
                                    $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                    //sub sub cat
                                    $ad_sub_sub_cats = nokri_get_cats('job_category', $sub_cat->term_id);
                                    if (count($ad_sub_sub_cats) > 0) {
                                        foreach ($ad_sub_sub_cats as $sub_cat_sub) {
                                            $cats_html .= '<option value="' . $sub_cat_sub->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;' . $sub_cat_sub->name . '  (' . $sub_cat_sub->count . ') </option>';
                                            //sub sub sub cat
                                            $ad_sub_sub_sub_cats = nokri_get_cats('job_category', $sub_cat_sub->term_id);
                                            if (count($ad_sub_sub_sub_cats) > 0) {
                                                foreach ($ad_sub_sub_sub_cats as $sub_cat) {
                                                    $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;- &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                                }
                                            }
                                        }
                                    }
                                }
                                $cats_html .= '</option>';
                            } else {
                                $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                            }
                        } else {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    }
                }
            }
        }
        // countries
        if (isset($atts['countries']) && !empty($atts['countries']) != '') {
            $rows = vc_param_group_parse_atts($atts['countries']);
            $cats = false;
            $countries_html = '';
            if (count($rows) > 0) {
                $countries_html .= '';
                foreach ($rows as $row) {
                    if (isset($row['country'])) {
                        if ($row['country'] == 'all') {
                            $cats = true;
                            $countries_html = '';
                            break;
                        }
                        $category = get_term_by('slug', $row['country'], 'ad_location');
                        if (count((array)$category) == 0)
                            continue;
                        if (isset($want_to_show_loc) && $want_to_show_loc == "yes") {

                            $ad_cats_sub = nokri_get_cats('ad_location', $category->term_id);
                            if (count($ad_cats_sub) > 0) {
                                $countries_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                                foreach ($ad_cats_sub as $ad_cats_subz) {
                                    $countries_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                                }
                                $countries_html .= '</option>';
                            } else {
                                $countries_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                            }
                        } else {
                            $countries_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    }
                }

                if ($cats) {
                    $ad_cats = nokri_get_cats('ad_location', 0);
                    foreach ($ad_cats as $cat) {
                        if (isset($want_to_show_loc) && $want_to_show_loc == "yes") {
                            //sub cat
                            $ad_sub_cats = nokri_get_cats('ad_location', $cat->term_id);
                            if (count($ad_sub_cats) > 0) {
                                $countries_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                                foreach ($ad_sub_cats as $sub_cat) {
                                    $countries_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                    //sub sub cat
                                    $ad_sub_sub_cats = nokri_get_cats('ad_location', $sub_cat->term_id);
                                    if (count($ad_sub_sub_cats) > 0) {
                                        foreach ($ad_sub_sub_cats as $sub_cat_sub) {
                                            $countries_html .= '<option value="' . $sub_cat_sub->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;' . $sub_cat_sub->name . '  (' . $sub_cat_sub->count . ') </option>';
                                            //sub sub sub cat
                                            $ad_sub_sub_sub_cats = nokri_get_cats('ad_location', $sub_cat_sub->term_id);
                                            if (count($ad_sub_sub_sub_cats) > 0) {
                                                foreach ($ad_sub_sub_sub_cats as $sub_cat) {
                                                    $countries_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;- &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                                }
                                            }
                                        }
                                    }
                                }
                                $countries_html .= '</option>';
                            } else {
                                $countries_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                            }
                        } else {
                            $countries_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    }
                }
            }
        }
        /* Section Title */
        $main_section_title = (isset($section_title) && $section_title != "") ? ' <div class="n-hero7-container"><h1>' . $section_title . '</h1></div>' : "";
        /* Background Image */
        $bg_img = '';
        if ($search_section_img != "") {
            $bgImageURL = nokri_returnImgSrc($search_section_img);
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $bgImageURL . ') no-repeat scroll center center / cover;"' : "";
        }
        /* Keyword Title */
        $keyword_titles = (isset($keyword_title) && $keyword_title != "") ? '<label>' . $keyword_title . '</label>' : "";
        /* Cat Title */
        $cats_titles = (isset($cats_title) && $cats_title != "") ? '<label>' . $cats_title . '</label>' : "";
        /* Loc Title */
        $locat_titles = (isset($locat_title) && $locat_title != "") ? '<label>' . $locat_title . '</label>' : "";

        /* side  tagline */
        $side_taglines = (isset($side_tagline) && $side_tagline != "") ? '<span>' . $side_tagline . '</span>' : "";
        /* side  heading */
        $side_titles = (isset($side_title) && $side_title != "") ? '<p class="h-style">' . $side_title . '</p>' : "";
        /* side button link */
        $side_btn_link = '';
        if (isset($resume_btn_txt)) {
            $side_btn_link = '<input type="button"  class="btn btn-default" value="' . esc_attr($resume_btn_txt) . '" name="upload_cand_resume" id="upload_cand_resume">';
        }
        $user_id = get_current_user_id();
        $signin_page = '';
        if ((isset($nokri['sb_sign_in_page'])) && $nokri['sb_sign_in_page'] != '') {
            $signin_page = get_page_link($nokri['sb_sign_in_page']);
        }
        return '<section class="n-hero-7" ' . str_replace('\\', "", $bg_img) . '>
				<div class="container">
					<div class="row">
					<div class="col-lg-9 col-xs-12 col-sm-12 col-md-9">
						<div class="n-hero7-products">
						' . $main_section_title . '
						<div class="n-hero7-fields">
						<form   method="get" action="' . get_the_permalink($nokri['sb_search_page']) . '">
						' . nokri_form_lang_field_callback(false) . '
							<ul>
								<li>
								<div class="form-group">
									' . $keyword_titles . '
									<input type="text" class="form-control" name="job-title" placeholder="' . esc_html__('Search here', 'nokri') . '">
								</div>
								</li>
								<li>
								<div class="form-group">
								' . $cats_titles . '
									<select class="js-example-basic-single form-control" data-allow-clear="true" data-placeholder="' . esc_html__('Select Category', 'nokri') . '"    name="cat-id">
								   <option label="' . esc_html__('Select Category', 'nokri') . '"></option>
									' . $cats_html . '
								</select>
								</div>
								</li>
								<li>
								<div class="form-group">
								' . $locat_titles . '
									<select class="js-example-basic-single form-control" data-allow-clear="true" data-placeholder="' . esc_html__('Select Location', 'nokri') . '"  name="job-location">
										<option value="">' . esc_html__('Select Location', 'nokri') . '</option>
									' . $countries_html . '
									</select>
								</div>
								</li>
							</ul>
							<button type="submit" class="hero-submit-form"><i class="fa fa-search"></i></button>
							</form>
						</div>
						</div>
					</div>
					<div class="col-lg-3 col-xs-12 col-sm-6 col-md-3">
						<div class="n-hero7-resume">
						' . $side_taglines . '
						' . $side_titles . '
						' . $side_btn_link . '
                                                     <input id="my_cv_upload_custom" name="my_cv_upload[]"  class="upload_resume_tab" type="file"  hidden/>
                                     <input type="hidden"  value="' . $user_id . '"  id="check_user_login" data-redirect_url="' . $signin_page . '"/>
					</div>
					</div>
				</div>
				</section>';
    }

}
if (function_exists('nokri_add_code')) {
    nokri_add_code('hero_section2', 'hero_section2_short_base_func');
}