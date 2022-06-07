<?php

/* ------------------------------------------------ */
/* Advance Search - Tabs */
/* ------------------------------------------------ */
if (!function_exists('search_tabs_sidebar')) {

    function search_tabs_sidebar() {
        vc_map(array(
            "name" => esc_html__("Paralex with side search", 'nokri'),
            "base" => "search_tabs_sidebar",
            "category" => esc_html__("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => esc_html__('Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('nokri_paralex_sidebar.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "attach_image",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Image", 'nokri'),
                    "param_name" => "search_section_img",
                    "description" => esc_html__('1263 x 147', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section tagline", 'nokri'),
                    "param_name" => "section_tagline",
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
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Details", 'nokri'),
                    "param_name" => "section_details",
                ),
                array
                    (
                    "group" => esc_html__("Add Stories", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select', 'nokri'),
                    'param_name' => 'stories',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Story number", 'nokri'),
                            "param_name" => "story_number",
                        ),
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Story title", 'nokri'),
                            "param_name" => "story_title",
                        ),
                    )
                ),
                array(
                    "group" => esc_html__("Sidebar", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("sidebar title", 'nokri'),
                    "param_name" => "sidebar_title",
                ),
                array(
                    "group" => esc_html__("Sidebar", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Keyword title", 'nokri'),
                    "param_name" => "keyword_title",
                ),
                array(
                    "group" => esc_html__("Sidebar", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Category title", 'nokri'),
                    "param_name" => "cats_title",
                ),
                array(
                    "group" => esc_html__("Sidebar", "nokri"),
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
                    "group" => esc_html__("Countries", "nokri"),
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
            ),
        ));
    }

}

add_action('vc_before_init', 'search_tabs_sidebar');

if (!function_exists('search_tabs_sidebar_short_base_func')) {

    function search_tabs_sidebar_short_base_func($atts, $content = '') {

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
        //For countries
        if (isset($atts['countries']) && !empty($atts['countries']) != '') {
            $rows_countries = vc_param_group_parse_atts($atts['countries']);
            $year_countries = false;
            $countries_html = '';
            $get_year = '';
            if (count($rows_countries) > 0) {
                $countries_html .= '';
                foreach ($rows_countries as $rows_country) {
                    if (isset($rows_country['country'])) {
                        if ($rows_country['country'] == 'all') {
                            $year_countries = true;
                            $countries_html = '';
                            break;
                        }
                        $get_country = get_term_by('slug', $rows_country['country'], 'ad_location');
                        if (count(array($get_country)) == 0)
                            continue;
                        $countries_html .= '<option value="' . $get_country->term_id . '">' . $get_country->name . '</option>';
                    }
                }

                if ($year_countries) {

                    $all_countries = nokri_get_cats('ad_location', 0);
                    foreach ($all_countries as $all_year) {
                        $countries_html .= '<option value="' . $all_year->term_id . '">' . $all_year->name . '</option>';
                    }
                }
            }
        }
        if (isset($atts['stories']) && !empty($atts['stories']) != '') {
            $rows_story = vc_param_group_parse_atts($atts['stories']);
            $stories_html = '';
            if ((array) count($rows_story) > 0) {
                foreach ($rows_story as $row_story) {
                    /* Story Title */
                    $astory_title = (isset($row_story['story_title']) && $row_story['story_title'] != "") ? ' <h3 class="count-title">' . $row_story['story_title'] . '</h3>' : "";
                    /* Story Description */
                    $astory_no = (isset($row_story['story_number']) && $row_story['story_number'] != "") ? '<h5 class="counter-stats">' . $row_story['story_number'] . '</h5>' : "";

                    /* Story Html */
                    $stories_html .= '<div class="counter-seprator">
					<div class="counter-box">
					   ' . $astory_no . '
					   ' . $astory_title . '
					</div>
				 </div>';
                }
            }
        }
        /* Section Tagline */
        $main_section_tagline = (isset($section_tagline) && $section_tagline != "") ? '<h3 class="hero-title">' . $section_tagline . '</h3>' : "";
        /* Section Title */
        $main_section_title = (isset($section_title) && $section_title != "") ? ' <h2>' . $section_title . '</h2>' : "";
        /* Section Descriptions */
        $main_section_deatils = (isset($section_details) && $section_details != "") ? ' <p>' . $section_details . '</p>' : "";
        /* Background Image */
        $bg_img = '';
        if ($search_section_img != "") {
            $bgImageURL = nokri_returnImgSrc($search_section_img);
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $bgImageURL . ') no-repeat scroll center center / cover;"' : "";
        }
        /* sidebar_title */
        $sidebar_title = (isset($sidebar_title) && $sidebar_title != "") ? '<h4>' . $sidebar_title . '</h4>' : "";
        /* keyword_title */
        $keyword_title = (isset($keyword_title) && $keyword_title != "") ? '<label>' . $keyword_title . '</label>' : "";
        /* cats_title */
        $cats_title = (isset($cats_title) && $cats_title != "") ? '<label>' . $cats_title . '<label>' : "";
        /* cats_title */
        $locat_title = (isset($locat_title) && $locat_title != "") ? '<label>' . $locat_title . '<label>' : "";
        return '<section id="intro-hero"  ' . str_replace('\\', "", $bg_img) . ' >
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
        <div class="hero-text-box">
         ' . $main_section_tagline . '
          ' . $main_section_title . '
          ' . $main_section_deatils . '
        </div>
        <div class="conter-grid">
             ' . $stories_html . '
          </div>
      </div>
      <div class="col-lg-4 col-md-5 col-sm-8 col-xs-12 col-md-offset-0 col-sm-offset-2 col-lg-offset-1">
		<form class="form-join"  method="get" action="' . get_the_permalink($nokri['sb_search_page']) . '">
		' . nokri_form_lang_field_callback(false) . '
          ' . $sidebar_title . '
          <div class="form-group">
            ' . $keyword_title . '
			 <input type="text" class="form-control" name="job-title" placeholder="' . esc_html__('Search Keyword', 'nokri') . '">
          </div>
          <div class="form-group">
          	' . $cats_title . '
            <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="' . esc_html__('Select Category', 'nokri') . '" style="width: 100%"   name="cat-id">
               <option label="' . esc_html__('Select Category', 'nokri') . '"></option>
                ' . $cats_html . '
            </select>
          </div>
          <div class="form-group">
              ' . $locat_title . '
          	<select class="js-example-basic-single" data-allow-clear="true" data-placeholder="' . esc_html__('Select Location', 'nokri') . '" style="width: 100%" name="job-location">
               <option value="">' . esc_html__('Select Location', 'nokri') . '</option>
                 ' . $countries_html . '
            </select>
          </div>
		  <button type="submit" class="btn n-btn-flat btn-block">' . esc_html__('Search', 'nokri') . '<i class="fa fa-search"></i></button>
        </form>
      </div>
    </div>
  </div>
</section>';
    }

}
if (function_exists('nokri_add_code')) {
    nokri_add_code('search_tabs_sidebar', 'search_tabs_sidebar_short_base_func');
}