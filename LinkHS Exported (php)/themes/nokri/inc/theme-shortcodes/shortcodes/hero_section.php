<?php
/* ------------------------------------------------ */
/* Hero section - Tabs */
/* ------------------------------------------------ */
if (!function_exists('hero_section')) {

    function hero_section() {
        vc_map(array(
            "name" => esc_html__("Hero Section", 'nokri'),
            "base" => "hero_section",
            "category" => esc_html__("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => esc_html__('Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('hero_section.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
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
                    "type" => "attach_image",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Arrow Image", 'nokri'),
                    "param_name" => "arrow_image",
                    "description" => esc_html__('64 x 64', 'nokri'),
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
                    "heading" => esc_html__("Section tagline", 'nokri'),
                    "param_name" => "section_details",
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
            ),
        ));
    }

}

add_action('vc_before_init', 'hero_section');

if (!function_exists('hero_section_short_base_func')) {

    function hero_section_short_base_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'cats' => '',
            'section_title' => '',
            'arrow_image' => '',
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
        if (isset($atts['cats']) && $atts['cats'] != '') {
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

                        $category_tax = array(
                            array(
                                'taxonomy' => 'job_category',
                                'field' => 'term_id',
                                'terms' => $cat->term_id,
                            ),
                        );
                        $args = array(
                            'tax_query' => array($category_tax),
                            'posts_per_page' => -1,
                            'post_type' => 'job_post',
                            'post_status' => 'publish',
                            'orderby' => 'date',
                            'meta_query' => array(
                                array(
                                    'key' => '_job_status',
                                    'value' => 'active',
                                    'compare' => '=',
                                ),
                            ),
                        );
                        $results = new WP_Query($args);

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
                                $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $results->found_posts . ')</option>';
                            }
                        } else {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $results->found_posts . ')</option>';
                        }
                    }
                }
            }
        }

        if (isset($atts['countries']) && $atts['countries'] != '') {
            // countries
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
        /* Section Title */
        $main_section_title = (isset($section_title) && $section_title != "") ? ' <h1>' . $section_title . '</h1>' : "";
        /* Section Descriptions */
        $main_section_deatils = (isset($section_details) && $section_details != "") ? ' <p>' . $section_details . '</p>' : "";
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
        $cats_title = (isset($cats_title) && $cats_title != "") ? '<label>' . $cats_title . '</label>' : "";
        /* cats_title */
        $locat_title = (isset($locat_title) && $locat_title != "") ? '<label>' . $locat_title . '</label>' : "";
        /* Arrow Image */
        $arrow_image1 = '';
        if (isset($arrow_image) && $arrow_image != "") {
            $img = wp_get_attachment_image_src($arrow_image, '');
            $img_thumb = isset($img[0]) ? $img[0] : "";
            $arrow_image1 = '<img class="img-responsive" src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri') . '">';
        }
        return '<section class="main-section-slider style-3" ' . str_replace('\\', "", $bg_img) . '>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
                	<div class="main-section-style-3-box">
                    	' . $main_section_title . '
                        ' . $main_section_deatils . '
                        ' . $arrow_image1 . '
                    </div>
                </div>
            </div>
        </div>
    </section>
  	<section class="serch-filter-overflow-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="search-filter-overflow-top-box">
                           <form class="form-inline"  method="get" action="' . get_the_permalink($nokri['sb_search_page']) . '">
						      ' . nokri_form_lang_field_callback(false) . '
                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                     ' . $keyword_title . '
                                  <input type="text" class="form-control" name="job-title" placeholder="' . esc_html__('Search here', 'nokri') . '">
                                  <i class="ti-search"></i> 
                                </div>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
								' . $cats_title . '
								<select class="js-example-basic-single form-control" data-allow-clear="true" data-placeholder="' . esc_html__('Select Category', 'nokri') . '"    name="cat-id">
								   <option label="' . esc_html__('Select Category', 'nokri') . '"></option>
									' . $cats_html . '
								</select>
							  </div>
                              </div>
                              <div class="col-md-3 col-sm-6 col-xs-12 ">
                                 <div class="form-group">
								  ' . $locat_title . '
								<select class="js-example-basic-single form-control" data-allow-clear="true" data-placeholder="' . esc_html__('Select Location', 'nokri') . '"  name="job-location">
								   <option value="">' . esc_html__('Select Location', 'nokri') . '</option>
									 ' . $countries_html . '
								</select>
							  </div>
                              </div>
                              <div class="col-md-2 col-sm-6 col-xs-12 nopadding">
                                <div class="form-group form-action">
								<button type="submit" class="btn n-btn-flat btn-search-submit">' . esc_html__('Search', 'nokri') . '<i class="fa fa-search"></i></button>
                                </div>
                              </div>
                            </form>
                        </div>
                        <div class="search-shadow"></div>
                </div>
            </div>
        </div>
    </section>';
    }

}
if (function_exists('nokri_add_code')) {
    nokri_add_code('hero_section', 'hero_section_short_base_func');
}