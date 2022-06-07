<?php

/* ------------------------ */
/* App section */
/* ------------------------ */

function app_section_new() {
    vc_map(array(
        "name" => esc_html__("App section", 'nokri'),
        "base" => "app_section_new_base",
        "category" => esc_html__("Theme Shortcodes", 'nokri'),
        "params" => array(
            array(
                'group' => esc_html__('Shortcode Output', 'nokri'),
                'type' => 'custom_markup',
                'heading' => esc_html__('Shortcode Output', 'nokri'),
                'param_name' => 'order_field_key',
                'description' => nokri_VCImage('nokri_app_section.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
            ),
            array(
                "group" => esc_html__("Basic", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Section Heading", 'nokri'),
                "param_name" => "appsection_heading",
            ),
            array(
                "group" => esc_html__("Basic", "nokri"),
                "type" => "textarea",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Section Details", 'nokri'),
                "param_name" => "appsection_details",
            ),
            array(
                "group" => esc_html__("Image Settings", "nokri"),
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Back ground image", 'nokri'),
                "param_name" => "appsection_bg_img",
                "description" => esc_html__('767 x 467', 'nokri'),
            ),
            array(
                "group" => esc_html__("Image Settings", "nokri"),
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Section image", 'nokri'),
                "param_name" => "appsection_img",
                "description" => esc_html__('444 x 592', 'nokri'),
            ),
            array(
                "group" => esc_html__("Play Store", "nokri"),
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Image", 'nokri'),
                "param_name" => "play_store_img",
                "description" => esc_html__('150 x 50', 'nokri'),
            ),
            array(
                "group" => esc_html__("Play Store", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Play Store Link", 'nokri'),
                "param_name" => "play_store_link",
            ),
            array(
                "group" => esc_html__("App Store", "nokri"),
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Image", 'nokri'),
                "param_name" => "app_store_img",
                "description" => esc_html__('150 x 50', 'nokri'),
            ),
            array(
                "group" => esc_html__("App Store", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("App Store Link", 'nokri'),
                "param_name" => "app_store_link",
            ),
        ),
    ));
}

add_action('vc_before_init', 'app_section_new');

function app_section_new_base_func($atts, $content = '') {
    extract(shortcode_atts(array(
        'order_field_key' => '',
        'appsection_clr' => '',
        'appsection_heading' => '',
        'appsection_details' => '',
        'appsection_bg_img' => '',
        'appsection_img' => '',
        'play_store_img' => '',
        'play_store_link' => '',
        'app_store_img' => '',
        'app_store_link' => '',
                    ), $atts));


    /* Section Heading  */
    $section_heading = (isset($appsection_heading) && $appsection_heading != "") ? '<h2>' . $appsection_heading . '</h2>' : "";
    /* Section Details */
    $section_details = (isset($appsection_details) && $appsection_details != "") ? '<p>' . $appsection_details . '</p>' : "";
    /* Section Image */
    $appsection_img_html = '';
    if (isset($appsection_img)) {
        $img = wp_get_attachment_image_src($appsection_img, '');
        $img_thumb = isset($img[0]) ? $img[0] : '';
        $appsection_img_html = '<div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="mobile-app-new-img"><img src="' . esc_url($img_thumb) . '" class="img-responsive" alt="' . esc_attr__('image', 'nokri') . '"></div>
                    </div>';
    }

    /* Play Store Link */
    $play_store = (isset($play_store_link) && $play_store_link != "") ? $play_store_link : "#";
    /* Play Store Image */
    $play_store_imgURL = $play_store_imag = '';
    if ($play_store_img != "") {
        $play_store_imgURL = nokri_returnImgSrc($play_store_img);
        $play_store_imag = '<img src="' . $play_store_imgURL . '" alt="' . esc_attr__("playStore", "nokri") . '">';
    }

    /* App Store Link */
    $app_store = (isset($app_store_link) && $app_store_link != "") ? $app_store_link : "#";
    /* App Store Image */
    $app_store_imgURL = '';
    if ($app_store_img != "") {
        $app_store_imgURL = nokri_returnImgSrc($app_store_img);
        $app_store_img = '<img src="' . $app_store_imgURL . '"  alt="' . esc_attr__("AppStore", "nokri") . '">';
    }
    /* Section Image */
    $section_imgURL = '';
    if ($appsection_img != "") {
        $section_imgURL = nokri_returnImgSrc($appsection_img);
        $appsection_img = '<img src="' . $section_imgURL . '" class="img-responsive" alt="' . esc_attr__("Image", "nokri") . '">';
    }
    /* Section Color */
    $section_clr = (isset($appsection_clr) && $appsection_clr != "") ? $appsection_clr : "";
    /* Background Image */
    $bg_img = '';
    if ($appsection_bg_img != "") {
        $bgImageURL = nokri_returnImgSrc($appsection_bg_img);
        $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: rgba(0, 0, 0, 0.6) url(' . $bgImageURL . ') 0 0 no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
    }
    return '<section class="n-mobile-app-new" ' . str_replace('\\', "", $bg_img) . '>
         <div class="container">
            <div class="row">
               <div class="col-md-6 col-sm-12 col-xs-12 ">
                  <div class="n-mobile-app-text-area">
                      ' . $section_heading . '
					  ' . $section_details . '
                     <div>
                          <a href="' . $play_store . '" target="_blank">' . $play_store_imag . '</a>
                    	  <a href="' . $app_store . '" target="_blank">' . $app_store_img . '</a>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="n-mobile-app-new-img">' . $appsection_img . '</div>
               </div>
            </div>
         </div>
      </section>';
}

if (function_exists('nokri_add_code')) {
    nokri_add_code('app_section_new_base', 'app_section_new_base_func');
}