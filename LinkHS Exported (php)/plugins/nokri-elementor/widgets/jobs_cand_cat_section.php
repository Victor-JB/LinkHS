<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Job_Cand_Cat extends Widget_Base {

    public function get_name() {
        return 'jobs_cand_cat';
    }

    public function get_title() {
        return __('Jobs,Candidates And Categories', 'nokri-elementor');
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
                'basic_section',
                [
                    'label' => __('Basic', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'section_bg_img',
                [
                    'label' => __('Background Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                   
                    "description" => esc_html__('263x394', 'nokri-elementor'),
                ]
        );

        $this->add_control(
                'section_heading',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_tagline',
                [
                    'label' => __('Section tagline', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'latest_job_tab',
                [
                    'label' => __('Latest Job Tab Name', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'latest_no_job',
                [
                    'label' => __('Latest Job number', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => range(1, 50),
                ]
        );
        $this->add_control(
                'latest_job_ord',
                [
                    'label' => __('Order By', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Job order', 'nokri-elementor') => '',
                        esc_html__('ASC', 'nokri-elementor') => 'asc',
                        esc_html__('DESC', 'nokri-elementor') => 'desc',
                            )),
                ]
        );
        
        $this->end_controls_section();
        $this->start_controls_section(
                'premium_job_section',
                [
                    'label' => __('Premium jobs', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'premium_job_tab',
                [
                    'label' => __('Premium Job Tab Name', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'job_class_no',
                [
                    'label' => __('Premium job Number', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => range(1, 50),
                ]
        );
        $this->add_control(
                'job_order',
                [
                    'label' => __('Order By', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Job order', 'nokri-elementor') => '',
                        esc_html__('ASC', 'nokri-elementor') => 'asc',
                        esc_html__('DESC', 'nokri-elementor') => 'desc',
                            )),
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'job_class',
                [
                    'label' => __('Select job Class', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_job_class_elementor('job_class'),
                ]
        );
        $this->add_control(
                'job_classes',
                [
                    'label' => __('Select Job Class', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
                'candidate_section',
                [
                    'label' => __('Candidate slider', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'slider_switch',
                [
                    'label' => __('Hide/Show Slider', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select an option', 'nokri-elementor') => '',
                        esc_html__('Show', 'nokri-elementor') => '1',
                        esc_html__('Hide', 'nokri-elementor') => '0',
                    )),
                ]
        );
        $this->add_control(
                'slider_title',
                [
                    'label' => __('Slider Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'condition' => [
                        'slider_switch' => ['1'],
                    ],
                ]
        );
        $this->add_control(
                'candidate_type',
                [
                    'label' => __('Select Candidates Type', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select an option', 'nokri-elementor') => '',
                        esc_html__('Simple', 'nokri-elementor') => '0',
                        esc_html__('Featured', 'nokri-elementor') => '1',
                    )),
                    'condition' => [
                        'slider_switch' => ['1'],
                    ],
                ]
        );
                            $this->end_controls_section();
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
                    'label' => __('Hide/Show Categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select an option', 'nokri-elementor') => '',
                        esc_html__('Show', 'nokri-elementor') => '1',
                        esc_html__('Hide', 'nokri-elementor') => '0',
                            )),
                ]
        );
        $this->add_control(
                'cat_title',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
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
        $repeater->add_control(
                'cat_img',
                [
                    'label' => __('Category Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('64x64', 'nokri-elementor'),
                ]
        );

        $this->add_control(
                'cats',
                [
                    'label' => __('Select categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'Qoute_section',
                [
                    'label' => __('Qoute', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'qoute_switch',
                [
                    'label' => __('Hide/Show Qoute', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select an option', 'nokri-elementor') => '',
                        esc_html__('Show', 'nokri-elementor') => '1',
                        esc_html__('Hide', 'nokri-elementor') => '0',
                            )),
                ]
        );
        $this->add_control(
                'qoute_title',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'condition' => [
                        'qoute_switch' => ['1'],
                    ],
                ]
        );
        $this->add_control(
                'qoute_desc',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                    'condition' => [
                        'qoute_switch' => ['1'],
                    ],
                ]
        );
        $this->add_control(
                'qoute_img',
                [
                    'label' => __('Background Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'condition' => [
                        'qoute_switch' => ['1'],
                    ],
                ]
        );
        $this->add_control(
                'section_img',
                [
                    'label' => __('Section Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'condition' => [
                        'qoute_switch' => ['1'],
                    ],
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'Sorter_section',
                [
                    'label' => __('Sorter', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'sorter',
                [
                    'label' => __('Sort it', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array(
                        'slider' => esc_html__('Slider', 'nokri-elementor'),
                        'categories' => esc_html__("Categories", "nokri-elementor"),
                        'qoute' => esc_html__("Qoute", "nokri-elementor")),
                ]
        );
        $this->add_control(
                'sortings',
                [
                    'label' => __('Sorter', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
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

        
        $job_class_array   = array();
        if (isset($atts['job_classes']) && !empty($atts['job_classes']) != '') {
            $rows_class = $atts['job_classes'];
            if ((array) count($rows_class) > 0) {
                foreach ($rows_class as $row) {
                    $job_class_array[] = (isset($row['job_class']) && $row['job_class'] != "") ? $row['job_class'] : array();
                }
            }
        }
        $job_class_no = (isset($job_class_no) && $job_class_no != "") ? $job_class_no +1 : 5;
        $premium_args = array(
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
        $premium_args = nokri_wpml_show_all_posts_callback($premium_args);
        $job_class_slider = new \WP_Query($premium_args);
        $slider_html = $project = '';
        if ($job_class_slider->have_posts()) {
            $count = 1;
            while ($job_class_slider->have_posts()) {
                $job_class_slider->the_post();
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
                /* Getting Categories */
                $project = nokri_job_categories_with_chlid($job_id, 'job_category');
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
                        $last_location = '<li><a href="' . esc_url(nokri_page_lang_url_callback($search_url)) . '"><i class="fa fa-map-marker" aria-hidden="true"></i>' . $location->name . '</a></li>';
                    }
                }
                $job_bookmark = get_post_meta($job_id, '_job_saved_value_' . get_current_user_id(), true);
                if ($job_bookmark == '') {
                    $save_job = '<a href="javascript:void(0)" class="n-fav-icon save_job" data-value = "' . $job_id . '"> <i class="fa fa-heart-o"></i></a>';
                } else {
                    $save_job = '<a href="javascript:void(0)" class="n-fav-icon saved" > <i class="fa fa-heart-o"></i></a>';
                }
                $slider_html .= '<div class="n-listing-content">
							<div class="n-listing-product">
								<a href="#">
									<div class="n-listing-img">
										<img src="' . esc_url($rel_image_link[0]) . '" alt="' . esc_attr__('logo', 'nokri-elementor') . '" class="img-responsive">
									</div>
								</a>
								<div class="n-listing-user-detail">
									<ul class="list-inline">
										<li>' . esc_html__('Type:', 'nokri-elementor') . '</li>
										<li>' . nokri_job_post_single_taxonomies('job_type', $job_type) . '
										</li>
										<li>' . esc_html__('Time:', 'nokri-elementor') . '</li>
										<li><a href="javascript:void(0)">' . nokri_time_ago() . '</a>
										</li>
									</ul>	<a href="' . get_the_permalink() . '" class="list-h6-style">' . get_the_title() . '</a>
									<p>' . nokri_job_post_single_taxonomies('job_currency', $job_currency) . " " . nokri_job_post_single_taxonomies('job_salary', $job_salary) . " " . '/' . " " . nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type) . '</p>
								</div>
							</div>
							<div class="n-listing-usr-information">
								<ul>
									' . nokri_job_country($job_id, 'yes') . '
									<li><a href="#"><i class="fa fa-dot-circle-o" aria-hidden="true"></i>' . $project . '</a>
									</li>
								</ul>	
								<a href="javascript:void(0)" class=" absolute-position btn n-btn-flat apply_job" data-toggle="modal" data-target="#myModal"  data-job-id =' . esc_attr($job_id) . '>' . esc_html__('Apply Now', 'nokri-elementor') . ' </a>
							</div>
							<div class="n-listing-wp">
							' . $save_job . '
							</div>
						</div>';
            }
        }

        $latest_no_job = (isset($latest_no_job) && $latest_no_job != "") ? $latest_no_job +1 : 5;
        $latest_job_ordr = (isset($latest_job_ord) && $latest_job_ord != "") ? $latest_job_ord : 'DESC';
        $recent_job = '';
        $recent_job = array(
            'post_type' => 'job_post',
            'posts_per_page' => $latest_no_job,
            'order' => $latest_job_ordr,
            'orderby' => 'date',
            'post_status' => array('publish'),
            'meta_query' => array(
                array(
                    'key' => '_job_status',
                    'value' => 'active',
                    'compare' => '=',
                ),
            )
        );
        $recent_job = nokri_wpml_show_all_posts_callback($recent_job);
        $recent_job_query = new \WP_Query($recent_job);
        $recent_job_html = $project = '';
        if ($recent_job_query->have_posts()) {
            while ($recent_job_query->have_posts()) {
                $recent_job_query->the_post();
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
                /* Getting Categories */
                $project = nokri_job_categories_with_chlid($job_id, 'job_category');
                /* Getting Profile Photo */
                $rel_image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
                    $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
                    $rel_image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
                }
                /* Calling Funtion Job Class For Badges */
                $single_job_badges = nokri_job_class_badg($job_id);
                $job_badge_text = $featured_html = '';
                if (count((array) $single_job_badges) > 0) {
                    foreach ($single_job_badges as $job_badge => $val) {
                        $term_vals = get_term_meta($val);
                        $bg_color = get_term_meta($val, '_job_class_term_color_bg', true);
                        $color = get_term_meta($val, '_job_class_term_color', true);
                        $style_color = $li_bg_color = $an_color = '';
                        if ($color != "") {
                            $an_color = 'style="color: ' . $color . ' !important;"';
                        }
                        if ($bg_color != "") {
                            $li_bg_color = 'style=" background-color: ' . $bg_color . ' !important;"';
                        }
                        $search_url = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job_class', $val);
                        $job_badge_text .= '<li ' . $li_bg_color . '> <a href="' . esc_url(nokri_page_lang_url_callback($search_url)) . '" ' . $an_color . '>' . esc_html(ucfirst($job_badge)) . '</a></li>';
                    }
                    $featured_html = ' <div class="features-star"><i class="fa fa-star"></i></div>';
                    $job_badge_text = '<ul class="featured-badge-list">' . $job_badge_text . '</ul>';
                }
                $job_bookmark = get_post_meta($job_id, '_job_saved_value_' . get_current_user_id(), true);
                if ($job_bookmark == '') {
                    $save_job = '<a href="javascript:void(0)" class="n-fav-icon save_job" data-value = "' . $job_id . '"> <i class="fa fa-heart-o"></i></a>';
                } else {
                    $save_job = '<a href="javascript:void(0)" class="n-fav-icon saved" > <i class="fa fa-heart-o"></i></a>';
                }
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
                    $apply_button = '<a href="'.$href.'" class="absolute-position btn n-btn-flat '.$exter_app.'" data-job-id="' . esc_attr($job_id) . '"  data-job-exter="' . ( $job_apply_url ) . '">' . esc_html($apply_now_text) . '</a>';
                } else if ($job_apply_with == 'mail') {
                    $apply_button = '<a href="'.$href.'" class="absolute-position btn n-btn-flat '.$email_app.'" data-job-id="' . esc_attr($job_id) . '" data-job-exter="' . ( $job_apply_mail ) . '">' . esc_html($apply_now_text) . '</a>';
                } else if ($job_apply_with == 'whatsapp') {
                    $apply_button = '<a href="'.$href_whatsapp.'" class="absolute-position btn n-btn-flat '.$whatspp_app.'" data-job-id="' . esc_attr($job_id) . '" data-job-exter="' . ( $job_apply_whatsapp ) . '">' .esc_html($apply_now_text) . '</a>';
                } else                           
                {
                    $apply_button = '<a href="'.$href.'" class="absolute-position btn n-btn-flat '.$simple_app.'" data-toggle="modal" data-target="'.$modal_target.'"  data-job-id=' . esc_attr($job_id) . '>' . esc_html($apply_now_text) . ' </a>';
                }
                $recent_job_html .= '<div class="n-listing-content">
							<div class="n-listing-product">
								<a href="#">
									<div class="n-listing-img">
										<img src="' . esc_url($rel_image_link[0]) . '" alt="' . esc_attr__('logo', 'nokri-elementor') . '" class="img-responsive">
									</div>
								</a>
								<div class="n-listing-user-detail">
									<ul class="list-inline">
										<li>' . esc_html__('Type:', 'nokri-elementor') . '</li>
										<li>' . nokri_job_post_single_taxonomies('job_type', $job_type) . '
										</li>
										<li>' . esc_html__('Time:', 'nokri-elementor') . '</li>
										<li><a href="#">' . nokri_time_ago() . '</a>
										</li>
									</ul>	<a href="' . get_the_permalink() . '" class="list-h6-style">' . get_the_title() . '</a>
									<p>' . nokri_job_post_single_taxonomies('job_currency', $job_currency) . " " . nokri_job_post_single_taxonomies('job_salary', $job_salary) . " " . '/' . " " . nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type) . '</p>
								</div>
							</div>
							<div class="n-listing-usr-information">
								<ul>
									' . nokri_job_country($job_id, 'yes') . '
									<li><a href="#"><i class="fa fa-dot-circle-o" aria-hidden="true"></i>' . $project . '</a>
									</li>
								</ul>	
								' . $apply_button . '
							</div>
							<div class="n-listing-wp">
							' . $save_job . '
							</div>
						</div>';
            }
        }
        /* Tabs Data */
        $premium_job_tab = (isset($premium_job_tab) && $premium_job_tab != "") ? $premium_job_tab : '';
        $latest_job_tab = (isset($latest_job_tab) && $latest_job_tab != "") ? $latest_job_tab : '';

        $tab_html = '';
        $tab_html = '<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#latest">' . $latest_job_tab . '</a>
					</li>
					<li><a data-toggle="tab" href="#premium">' . $premium_job_tab . '</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="latest" class="tab-pane fade in active">
						' . $recent_job_html . '
					</div>
					<div id="premium" class="tab-pane fade">
						' . $slider_html . '
					</div>
				</div>';
        /* Candidate Slider */
        $featured_cand = '';
        if (isset($candidate_type) && $candidate_type == "1") {
            $featured_cand = array(
                'key' => '_is_candidate_featured',
                'value' => '1',
                'compare' => '='
            );
        }
        $args = array(
            'order' => 'DESC',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_sb_reg_type',
                    'value' => '0',
                    'compare' => '='
                ),
                $featured_cand,
            ),
        );
        $user_query = new \WP_User_Query($args);
        $authors = $user_query->get_results();
        $required_user_html = $featured = '';
        if (!empty($authors)) {
            foreach ($authors as $author) {
                $cand_address = '';
                $user_id = $author->ID;
                $user_name = $author->display_name;
                $cand_add = get_user_meta($user_id, '_cand_address', true);
                $cand_head = get_user_meta($user_id, '_user_headline', true);
                $featured_date = get_user_meta($user_id, '_candidate_feature_profile', true);
                $today = date("Y-m-d");
                $expiry_date_string = strtotime($featured_date);
                $today_string = strtotime($today);
                if ($today_string > $expiry_date_string) {
                    delete_user_meta($user_id, '_candidate_feature_profile');
                    delete_user_meta($user_id, '_is_candidate_featured');
                }
                if ($cand_head != '') {
                    $cand_head = '<p>' . $cand_head . '</p>';
                }
                if ($cand_add != '') {
                    $cand_address = '<div class="n-candidate-lcation"><a href="javascript:void(0)"><i class="fa fa-map-marker"></i>' . $cand_add . '</a></div>';
                }
                /* Getting Star */
                if (isset($candidate_type) && $candidate_type == "1") {
                    $featured = '<div class="features-star"><i class="fa fa-star"></i></div>';
                };
                /* Getting Candidates Skills  */
                $skill_tags = nokri_get_candidates_skills($user_id, 'ul');
                $cand_address = get_user_meta($user_id, '_cand_address', true);
                $required_user_html .= '<div class="item">
									<div class="n-candidates-details">
										' . $featured . '	
										<a href="' . esc_url(get_author_posts_url($user_id)) . '"><span>' . $user_name . '</span></a>
										' . $cand_head . '
										<a href="' . esc_url(get_author_posts_url($user_id)) . '">
											<img src="' . nokri_get_user_profile_pic($user_id, '_cand_dp') . '" alt="' . esc_attr__('Profile picture', 'nokri-elementor') . '" class="img-responsive">
										</a>
										<a href="javascript:void(0)" class="saving_resume" data-cand-id=' . esc_attr($user_id) . '><span class="style-utf"><i class="fa fa-heart-o"></i></span></a>
									</div>
									<div class="n-candidate-lcation">	<a href="#"><i class="fa fa-map-marker"></i>'.$cand_address.'</a>
									</div>
									<div class="n-candidates-list">
										<ul>
											' . $skill_tags . '
										</ul>
									</div>
									<div class="n-candidates-btn">
										<a href="' . esc_url(get_author_posts_url($user_id)) . '">' . esc_html__('View Profile', 'nokri-elementor') . '</a>
									</div>
								</div>';
            }
        }

        /* Candidate Slider Section  */
        $cand_slider_title = (isset($slider_title) && $slider_title != "") ? '<div class="n-candidates-content"><h2>' . $slider_title . '</h2></div>' : '';
        $cand_slider_html = '';
        
      
        
        if (isset($slider_switch) && $slider_switch == "1") {
            $cand_slider_html = '<div class="n-listing-candidates">
								' . $cand_slider_title . '
								<div class="job-cat-cand-slider owl-carousel owl-theme">
									' . $required_user_html . '
								</div>
							 </div>';
        }
        
       
        /* Candidate Slider Section End  */
        /* Categories Section  */
        $cat_titles = (isset($cat_title) && $cat_title != "") ? '<li class="hd-style"><h2>' . $cat_title . '</h2></li>' : '';
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
                        /* Category Image */
                        $cat_img = '';
                        if (isset($row['cat_img']['url'])) {
                            
                            $img_thumb = $row['cat_img']['url'];
                            $cat_img = '<img src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '" class="img-responsive">';
                        }
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($category->term_id, 'job_category');
                        $count_cat = esc_html__('Openings', 'nokri-elementor');
                        if ($category->count > 1) {
                            $count_cat = esc_html__('Openings', 'nokri-elementor');
                        }
                        $cats_html .= '<li>
								<div class="n-listing-cat">
									<a href="' . nokri_cat_link_page($category->term_id) . '">
										 ' . $cat_img . '<span>' . $category->name . '</span>
									</a>
								</div>
								<div class="n-listing-top">	<span>' . $custom_count . " " . $count_cat . '</span>
								</div>
							</li>';
                    }
                }
                if ($cats) {
                    $ad_cats = nokri_get_cats('job_category', 0);
                    /* Category Image */
                    $cat_img = '';
                    if (isset($row['cat_img']['url'])) {
                    
                        $img_thumb = $row['cat_img']['url'];
                        $cat_img = '<img src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '" class="img-responsive">';
                    }
                    foreach ($ad_cats as $cat) {
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($cat->term_id, 'job_category');
                        $count_cat = esc_html__('Opening', 'nokri-elementor');
                        if ($cat->count > 1) {
                            $count_cat = esc_html__('Openings', 'nokri-elementor');
                        }
                        $cats_html .= '<li>
								<div class="n-listing-cat">
									<a href="' . nokri_cat_link_page($cat->term_id) . '">
										 ' . $cat_img . '
										 <span>' . $cat->name . '</span>
									</a>
								</div>
								<div class="n-listing-top">	<span>' . $custom_count . " " . $count_cat . '</span>
								</div>
							</li>';
                    }
                }
            }
        }
        $cat_section = '';
        if (isset($cat_switch) && $cat_switch == "1") {
            $cat_section = '<div class="n-listing-categories">
					<ul>
						' . $cat_titles . '
						' . $cats_html . '
					</ul>
				</div>';
        }
        /* Categories Section End  */
        /* Qoute Section */
        if (isset($qoute_switch) && $qoute_switch == "1") {
            $qoute_titles = (isset($qoute_title) && $qoute_title != "") ? '<span>' . $qoute_title . '</span>' : '';
            $qoute_descs = (isset($qoute_desc) && $qoute_desc != "") ? '<p>' . $qoute_desc . '</p>' : '';
            /* Qoute Image */
            $section_img1 = '';
            if (isset($section_img['url'])) {
               
                $img_thumb = $section_img['url'];
                $section_img1 = '<img src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '" class="img-responsive">';
            }
            /* Qoute Background Image */
            if (isset($qoute_img['url'])) {
                $bgImageURL = $qoute_img['url'];
                $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: url(' . $bgImageURL . ') center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
            }
            $qa_html = '<div class="nth-listing-qa" ' . str_replace('\\', "", $bg_img) . '>
						<div class="nth-listing-content">
							' . $section_img1 . '
							' . $qoute_titles . '
							' . $qoute_descs . '
						</div>
					</div>';
        }
        /* Section title  */
        $section_heading = (isset($section_heading) && $section_heading != "") ? '<h2>' . $section_heading . '</h2>' : '';
        /* Section tagline  */
        $section_tagline = (isset($section_tagline) && $section_tagline != "") ? '<p>' . $section_tagline . '</p>' : '';
        /* Sider bar widgets */
        $side_bar_widgets = '';
        $wrap_class = 'col-lg-12 col-xs-12 col-sm-8 col-md-8';
        if ($slider_switch == '1' || $cat_switch == '1' || $qoute_switch == '1') {
            $wrap_class = 'col-lg-8 col-xs-12 col-sm-8 col-md-8';
            if (isset($atts['sortings']) && !empty($atts['sortings']) != '') {
                $sorter_params = $atts['sortings'];
                $arrange_html = '';
                if ((array) count($sorter_params) > 0) {
                    foreach ($sorter_params as $sorter) {
                        switch ($sorter['sorter']) {
                            /* Qoute case */
                            case 'qoute':
                                $arrange_html .= $qa_html;
                                break;
                            /* Categories case */
                            case 'categories':
                                $arrange_html .= $cat_section;
                                break;
                            /* Qoute case */
                            case 'slider':
                                $arrange_html .= $cand_slider_html;
                                break;
                        }
                    }
                }
                $side_bar_widgets = '<div class="col-lg-4 col-sm-4 col-xs-12 col-md-4">
								' . $arrange_html . '
								</div>';
            }
        }
        /* Background Image */
        $bg_img = '';
        if (isset($section_bg_img['url'])) {
            $bgImageURL = $section_bg_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: url(' . $bgImageURL . ') no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
        }
            
        echo '<section class="n-job-listing5" ' . str_replace('\\', "", $bg_img) . '>
				<div class="container">
					<div class="row">
						<div class="' . esc_attr($wrap_class) . '">
							<div class="n-listing-text">
								' . $section_heading . '
								' . $section_tagline . '
							</div>
							' . $tab_html . '
						</div>
						' . $side_bar_widgets . '
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
