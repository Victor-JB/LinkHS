<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Premium_Jobs_Tabs extends Widget_Base {

    public function get_name() {
        return 'preminum-jobs_tabs';
    }

    public function get_title() {
        return __('Premium Jobs Tabs', 'nokri-elementor');
    }

    public function get_icon() {
        return 'eicon-posts-group';
    }

    public function get_categories() {
        return ['nokritheme'];
    }

    public function get_script_depends() {
        return [''];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls() {
        /* for About Us tab */
        $this->start_controls_section(
                'category_section',
                [
                    'label' => __('Category', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );


        $this->add_control(
                'cat_switch',
                [
                    'label' => __('Hide/Show Tabs', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select an option', 'nokri-elementor') => '',
                        esc_html__('Show', 'nokri-elementor') => '1',
                        esc_html__('Hide', 'nokri-elementor') => '0',
                            )),
                    'default' => '0',
                ]
        );
        $this->add_control(
                'cat_title',
                [
                    'label' => __('Section Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'condition' => [
                        'cat_switch' => ['1'],
                    ],
                ]
        );
        $this->add_control(
                'cat_description',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'condition' => [
                        'cat_switch' => ['1'],
                    ],
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cat',
                [
                    'label' => __('Select categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_get_parests_elementor('job_category', 'yes'),
                ]
        );

        $this->add_control(
                'cats',
                [
                    'label' => __('Select categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'condition' => [
                        'cat_switch' => ['1'],
                    ],
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'job_class_section',
                [
                    'label' => __('Job Tab', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'jobs_switch',
                [
                    'label' => __('Hide/Show Tabs', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select an option', 'nokri-elementor') => '',
                        esc_html__('Show', 'nokri-elementor') => '1',
                        esc_html__('Hide', 'nokri-elementor') => '0',
                            )),
                ]
        );

        $this->add_control(
                'jobs_heading',
                [
                    'label' => __('Section Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'condition' => [
                        'jobs_switch' => ['1'],
                    ],
                ]
        );
        $this->add_control(
                'jobs_description',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'condition' => [
                        'jobs_switch' => ['1'],
                    ],
                ]
        );
        $this->add_control(
                'job_class_no',
                [
                    'label' => __('Number fo Jobs', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => range(1, 50),
                    'condition' => [
                        'jobs_switch' => ['1'],
                    ],
                ]
        );
        $this->add_control(
                'job_order',
                [
                    'label' => __('Job Order', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        '' => esc_html__('Select Job order', 'nokri-elementor'),
                        'asc' => esc_html__('ASC', 'nokri-elementor'),
                        'desc' => esc_html__('DESC', 'nokri-elementor'),
                    ),
                    'condition' => [
                        'jobs_switch' => ['1'],
                    ],
                ]
        );
        $this->add_control(
                'btn_txt',
                [
                    'label' => __('Button text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'condition' => [
                        'jobs_switch' => ['1'],
                    ],
                ]
        );
        $this->add_control(
                'link',
                [
                    'label' => __('Link', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __('https://your-link.com', 'nokri-elementor'),
                    'show_external' => true,
                    'default' => [
                        'url' => '#',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                    'condition' => [
                        'jobs_switch' => ['1'],
                    ],
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'job_class',
                [
                    'label' => __('Select Job Class', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_job_class_elementor('job_class'),
                ]
        );
        $this->add_control(
                'job_classes',
                [
                    'label' => __('Select Your Desired ones', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'condition' => [
                        'jobs_switch' => ['1'],
                    ],
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();
        global $nokri;
        //For countries

        $atts = $settings;

        extract($settings);


        global $nokri;
        /* Categories Section  Title */
        $cat_titles = (isset($cat_title) && $cat_title != "") ? '<h3>' . $cat_title . '</h3>' : '';
        /* Categories Section Description  */
        $cat_descriptions = (isset($cat_description) && $cat_description != "") ? '<p>' . $cat_description . '</p>' : '';
        /* View  Link */
        $read_more = '';
        if (isset($btn_txt)) {
            $read_more = '<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12"><div class="n-jobs-featured">' . elementor_ThemeBtn($link, 'btn n-btn-flat', false,'','',$btn_txt) . '</div></div>';
        }
        // For Job Category
        if (isset($atts['cats']) && !empty($atts['cats']) != '') {
            $rows = $atts['cats'];
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
            $rows = $atts['job_classes'];
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
                        'order' => $job_order,
                        'orderby' => 'date' ,
                        'posts_per_page' => $job_class_no + 1,
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
                    $job_class_query = new \WP_Query($args);
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
														 <img src="' . $img . '" alt="' . esc_attr__('image', 'nokri-elementor') . '" class="img-responsive">
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
        echo '<section class="n-keywords">
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

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _content_template() {
        
    }

}
