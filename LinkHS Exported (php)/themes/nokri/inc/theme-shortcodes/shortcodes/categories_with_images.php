<?php

/* ------------------------------------------------ */
/* Category - With Images */
/* ------------------------------------------------ */
if (!function_exists('categories_section')) {

    function categories_section() {
        vc_map(array(
            "name" => esc_html__("Categories With Images", 'nokri'),
            "base" => "categories_section",
            "category" => esc_html__("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('nokri_cats_with_images.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Select BG Color", 'nokri'),
                    "param_name" => "cats_section_clr",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Option', 'nokri') => '',
                        esc_html__('Sky BLue', 'nokri') => 'light-grey',
                        esc_html__('White', 'nokri') => '',
                    ),
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
                    'group' => esc_html__('Basic', 'nokri'),
                    "type" => "vc_link",
                    "heading" => esc_html__("Link", 'nokri'),
                    "param_name" => "link",
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
            ),
        ));
    }

}
add_action('vc_before_init', 'categories_section');
if (!function_exists('categories_section_short_base_func')) {

    function categories_section_short_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(array(
            'cats' => '',
            'section_title' => '',
            'cats_section_clr' => '',
            'link' => '',
                        ), $atts));       
        // For Job Category
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
                        if (count((array) $category) == 0)
                            continue;
                        /* Category Image */
                        $cat_img = '';
                        if (isset($row['cat_img'])) {
                            $img = wp_get_attachment_image_src($row['cat_img'], '');
                            $img_thumb = $img[0];
                            $cat_img = '<span class="images-icon"><img src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri') . '"></span>';
                        }
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($category->term_id, 'job_category');
                        $count_cat = esc_html__('Opening', 'nokri');
                        if ($category->count > 1) {
                            $count_cat = esc_html__('Openings', 'nokri');
                        }
                        $cats_html .= '<div class="col-md-4 col-lg-3 col-sm-6 col-xs-12">
							   <div class="new-category-box">
								  <a href="' . nokri_cat_link_page($category->term_id) . '">
									 <h3>' . $category->name . '</h3>
									 <p>(' . $custom_count . " " . $count_cat . ')</p>
									 ' . $cat_img . '
								  </a>
							   </div>
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
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($cat->term_id, 'job_category');
                        $count_cat = esc_html__('Opening', 'nokri');
                        if ($cat->count > 1) {
                            $count_cat = esc_html__('Openings', 'nokri');
                        }
                        $cats_html .= '<div class="col-md-4 col-lg-3 col-sm-6 col-xs-12">
							   <div class="new-category-box">
								  <a href="' . nokri_cat_link_page($cat->term_id) . '">
									 <h3>' . $cat->name . '</h3>
									 <p>(' . $custom_count . " " . $count_cat . ')</p>
									 ' . $cat_img . '
								  </a>
							   </div>
							</div>';
                    }
                }
            }
        }
        /* Section Color */
        $section_clr = (isset($cats_section_clr) && $cats_section_clr != "") ? $cats_section_clr : "";
        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? '<h2>' . $section_title . '</h2>' : "";

        /* Link 1 */
        $btn = '';
        if (isset($link)) {
            $btn = nokri_ThemeBtn($link, 'btn n-btn-rounded', false);
        }

        return '<section class="n-featured-cat" id="scroll_cats" ' . $section_clr . '>
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="heading-title left">
                    ' . $section_title . '
                     <span class="view-more">' . $btn . '</span>
                  </div>
               </div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="row">
                     <div class="n-cat-boxes">
					 ' . $cats_html . '
					 </div>
                  </div>
               </div>
            </div>
         </div>
      </section>';
    }

}
if (function_exists('nokri_add_code')) {
    nokri_add_code('categories_section', 'categories_section_short_base_func');
}