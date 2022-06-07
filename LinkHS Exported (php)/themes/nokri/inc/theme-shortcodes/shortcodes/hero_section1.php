<?php

/* ------------------------------------------------ */
/* Hero section 1 */
/* ------------------------------------------------ */
if (!function_exists('hero_section1')) {

    function hero_section1() {
        vc_map(array(
            "name" => esc_html__("Hero Section1", 'nokri'),
            "base" => "hero_section1",
            "category" => esc_html__("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => esc_html__('Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('hero_section1.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
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
                    "heading" => esc_html__("Section tagline", 'nokri'),
                    "param_name" => "section_tagline",
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
                    "group" => esc_html__("Hot Cats", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'nokri'),
                    "param_name" => "hot_title",
                ),
                array
                    (
                    "group" => esc_html__("Hot Cats", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select hot categories', 'nokri'),
                    'param_name' => 'hot_cats',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'nokri'),
                            "param_name" => "hot_cat",
                            "admin_label" => true,
                            "value" => nokri_get_parests('job_category', 'no'),
                        ),
                    )
                ),
                array(
                    "group" => esc_html__("Candidates Button", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Do you want to show", 'nokri'),
                    "param_name" => "is_show",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('yes', 'nokri') => 'yes',
                        esc_html__('no', 'nokri') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                ),
                array(
                    "group" => esc_html__("Candidates Button", "nokri"),
                    "type" => "attach_image",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Image", 'nokri'),
                    "param_name" => "cand_image",
                    "description" => esc_html__('64 x 64', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Candidates Button", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Title", 'nokri'),
                    "param_name" => "cand_title",
                ),
                array(
                    "group" => esc_html__("Candidates Button", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Tagline", 'nokri'),
                    "param_name" => "cand_tagline",
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
add_action('vc_before_init', 'hero_section1');

if (!function_exists('hero_section1_short_base_func')) {

    function hero_section1_short_base_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'cats' => '',
            'section_title' => '',
            'section_tagline' => '',
            'want_to_show' => '',
            'want_to_show_loc' => '',
            'hot_cats' => '',
            'hot_title' => '',
            'search_section_img' => '',
            'cand_image' => '',
            'cand_title' => '',
            'cand_tagline' => '',
            'resume_btn_txt' => '',
            'is_show' => '',
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
                        if (count($category) == 0)
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
                        if (count(array($category)) == 0)
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
        // For hot categories
        $hot_cats_html = '';
        if (!empty($atts['hot_cats'])) {
            $rows_hot_cats = vc_param_group_parse_atts($atts['hot_cats']);
            $year_countries = false;
            $hot_cats_html = '';
            $get_year = '';
            if (count($rows_hot_cats) > 0) {
                foreach ($rows_hot_cats as $rows_hot_cat) {
                    if (isset($rows_hot_cat['hot_cat'])) {
                        if ($rows_hot_cat['hot_cat'] == 'all') {
                            $year_countries = true;
                            $countries_html = '';
                            break;
                        }
                        $get_hot_cat = get_term_by('slug', $rows_hot_cat['hot_cat'], 'job_category');
                        if (count((array) $get_hot_cat) == 0)
                            continue;
                        $hot_cats_html .= '<li><a href="' . nokri_cat_link_page($get_hot_cat->term_id) . '">' . $get_hot_cat->name . '</a></li>';
                    }
                }
            }
        }
        /* Section Title */
        $main_section_title = (isset($section_title) && $section_title != "") ? ' <h1>' . $section_title . '</h1>' : "";
        /* Section tagline */
        $main_section_tagline = (isset($section_tagline) && $section_tagline != "") ? '<span class="h6-style">' . $section_tagline . '</span>' : "";
        /* hot Title */
        $hot_section_title = (isset($hot_title) && $hot_title != "") ? '<li class="style-flex"><a href="#">' . $hot_title . '</a></li>' : "";
        /* Background Image */
        $bg_img = '';
        if ($search_section_img != "") {
            $bgImageURL = nokri_returnImgSrc($search_section_img);
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $bgImageURL . ') no-repeat scroll center center / cover;"' : "";
        }

        /* Section Title */
        $can_section_title = (isset($cand_title) && $cand_title != "") ? '<div class="h6-product">' . $cand_title . '</div>' : "";
        /* Section tagline */
        $can_section_tagline1 = (isset($cand_tagline) && $cand_tagline != "") ? ' <p>' . $cand_tagline . '</p>' : "";
        /* Link */
        $cand_btn_txt = '';
        if (isset($resume_btn_txt)) {
            $cand_btn_txt = '<div class="col-lg-6 col-md-6 col-sm-6"><div class="n-profile-btn"><input type="button"  class="btn n-btn-flat" value="' . esc_attr($resume_btn_txt) . '" name="upload_cand_resume" id="upload_cand_resume"></div></div>';
        }
        /* cand Image */
        $cand_image1 = '';
        if (isset($cand_image)) {


            $img = wp_get_attachment_image_src($cand_image, '');
            $img_thumb = isset($img[0]) ? $img[0] : "";
            $cand_image1 = '<img class="img-responsive" src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri') . '">';
        }
        /* Section show */
        $can_show = (isset($is_show) && $is_show != "") ? $is_show : "yes";
        $can_show = '';
        $user_id = get_current_user_id();
        $signin_page = '';
        if ((isset($nokri['sb_sign_in_page'])) && $nokri['sb_sign_in_page'] != '') {
            $signin_page = get_page_link($nokri['sb_sign_in_page']);
        }
        $height_section = 'n-option';
        if ($is_show == 'yes') {
            $height_section = '';
            $can_show = '<div class="n-h6-profile">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6">
						<div class="n-jobs-h6">
							' . $cand_image1 . '
							' . $can_section_title . '
							' . $can_section_tagline1 . '
						</div>
					</div>
					' . $cand_btn_txt . '
                                     <input id="my_cv_upload_custom" name="my_cv_upload[]"  class="upload_resume_tab" type="file"  hidden/>
                                     <input type="hidden"  value="' . $user_id . '"  id="check_user_login" data-redirect_url="' . $signin_page . '"/>
				</div>
			</div>
		</div>';
        }

        return '<section class="n-hero-6" ' . str_replace('\\', "", $bg_img) . '>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
				<div class="n-h6-content" ' . esc_attr($height_section) . '>' . $main_section_tagline . ' ' . $main_section_title . '
					<form  method="get" action="' . get_the_permalink($nokri['sb_search_page']) . '">
					    ' . nokri_form_lang_field_callback(false) . '
						<div class="n-h6-form">
							<ul>
								<li>
									<div class="form-group">
                                     <input type="text" class="form-control" name="job-title" placeholder="' . esc_html__('Search here', 'nokri') . '">
									</div>
								</li>
								<li>
									<div class="form-group">
										<select class="js-example-basic-single form-control" data-allow-clear="true" data-placeholder="' . esc_html__('Select Category', 'nokri') . '" name="cat-id">
											<option label="' . esc_html__('Select Category', 'nokri') . '"></option>' . $cats_html . '</select>
									</div>
								</li>
								<li>
									<div class="form-group">
										<select class="js-example-basic-single form-control" data-allow-clear="true" data-placeholder="' . esc_html__('Select Location', 'nokri') . '"  name="job-location">
								   <option value="">' . esc_html__('Select Location', 'nokri') . '</option>
									 ' . $countries_html . '
										</select>
									</div>
								</li>
								<li>	
									<button type="submit" class="btn n-btn-flat">' . esc_html__('Search', 'nokri') . '<i class="fa fa-search"></i></button>
								</li>
							</ul>
						</div>
					</form>
					<div class="n-hero-list">
						<ul>
							' . $hot_section_title . '
							' . $hot_cats_html . '
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	' . $can_show . '
</section>';
    }

}
if (function_exists('nokri_add_code')) {
    nokri_add_code('hero_section1', 'hero_section1_short_base_func');
}