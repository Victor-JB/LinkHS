<?php

/**
 * About us one html
 */
if (!function_exists('nokri_elementor_hero_section_one')) {
    function nokri_elementor_hero_section_one($params)
    {
        $section_title = $section_tag_line = $section_description = $img_left = $img_right = $bg_img  = $feature_html = '';
        if (!empty($params['section_title'])) {
            $section_title = '<h2>' . $params['section_title'] . '</h2>';
        }
        if (!empty($params['section_tag_line'])) {
            $section_tag_line = '<p class="large-paragraph">' . $params['section_tag_line'] . '</p>';
        }
        if (!empty($params['section_description'])) {
            $section_description =  $params['section_description'];
        }
        if (!empty($params['bg_img'])) {
            $bg_img = '<img src="' . esc_url($params['bg_img']) . '" class="wow center-block img-responsive" alt="' . __('No Image', 'dwt-elementor') . '">';
        }
       
        
      print_r($section_title);

        /*feature repeater*/
      


        return '<section class="about-us">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
							' . $img_left . '
						<div class="col-md-7 col-sm-12 col-xs-12">
                            ' . $section_title . '
							' . $section_tag_line  . '
							' . $section_description . '
							<div class="row">
								<div class="services">
									' . $feature_html . '
								</div>
							</div>
						</div>
							' . "sjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj" . '
					</div>
				</div>
			</div>
		</section>';
    }
}

/**
 * About Us New
 */
if (!function_exists('dwt_elementor_about_us_new')) {
    function dwt_elementor_about_us_new($params)
    {
        $section_title = $section_tag_line = $section_description = $img_left = $img_right = $feature_html = $grid_imgs_html = $view_all_btn = '';
        if (!empty($params['section_title'])) {
            $section_title = '<h3>' . $params['section_title'] . '</h3>';
        }
        if (!empty($params['section_tag_line'])) {
            $section_tag_line = '<h2>' . $params['section_tag_line'] . '</h2>';
        }
        if (!empty($params['section_description'])) {
            $section_description =  $params['section_description'];
        }


        /* features repeater */
        if ($params['about_new_features']) {
            foreach ($params['about_new_features'] as $item) {
                $feature_html .= '<li>';
                $feature_html .= '<div class="choose-box">';
                $feature_html .=  '<span class="iconbox"><img src="' . $item['features_img']['url'] . '" class="img-responsive" alt="' . esc_html__('Image Not Found', 'dwt-listing') . '"></span>';
                $feature_html .= '<div class="choose-box-content">';
                $feature_html .= '<h4>' . $item['features_title'] . '</h4>';
                $feature_html .= '<p>' . $item['features_desc'] . '</p>';
                $feature_html .= '</div>';
                $feature_html .= '</div>';
                $feature_html .= '</li>';
            }
        }
        /* grid images repeater */
        if ($params['grid_imgs']) {
            foreach ($params['grid_imgs'] as $item) {
                $grid_imgs_html .= '<li>';
                $grid_imgs_html .= '<img src="' .  $item['about_new_grid_img']['url']  . '" class="img-responsive" alt="' . esc_attr__('Image Not Found', 'dwt-listing') . '">';
                $grid_imgs_html .= '</li>';
            }
        }

        /* grid image button */
        if (!empty($params['main_btn_title'])) {
            $view_all_btn .=  '<a href="' . $params['main_btn_link']['url'] . '">' . $params['main_btn_title'] . '</a>';
        }


        if ($params['img_postion'] == 'left') {

            $img_left .= '<div class="col-md-6 col-lg-6 col-xs-12 hidden-sm hidden-xs">';
            $img_left .= '<div class="p-about-us">';
            $img_left .= '<ul class="p-call-action">';
            $img_left .= $grid_imgs_html;
            $img_left .= '</ul>';
            $img_left .= '<div class="p-absolute-menu">';
            $img_left .= $view_all_btn;
            $img_left .= '</div>';
            $img_left .= '</div>';
            $img_left .= '</div>';
        } else {
            $img_right .= '<div class="col-md-6 col-lg-6 col-xs-12 hidden-sm hidden-xs">';
            $img_right .= '<div class="p-about-us">';
            $img_right .= ' <ul class="p-call-action">';
            $img_right .= $grid_imgs_html;
            $img_right .= ' </ul>';
            $img_right .= '<div class="p-absolute-menu">';
            $img_right .= '' . $view_all_btn;
            $img_right .= '</div>';
            $img_right .= '</div>';
            $img_right .= '</div>';
        }

        return '<section class="">
            <div class="container">
                <div class="row">
                    ' . $img_left . '
                    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                        <div class="choose-title">
                            ' . $section_title . '
                            ' . $section_tag_line . '
                            <p>' . $section_description . '</p>
                        </div>
                        <div class="choose-services">
                            <ul class="choose-list">
                                ' . $feature_html . '
                            </ul>
                        </div>
                    </div>
                    ' . $img_right . '
                </div>
            </div>
        </section>';
    }
}
