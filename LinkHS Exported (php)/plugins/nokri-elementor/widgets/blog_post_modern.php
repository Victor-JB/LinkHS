<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Blog_Post_Modern extends Widget_Base {

    public function get_name() {
        return 'blog_post_modern';
    }

    public function get_title() {
        return __('Blog post Modern', 'nokri-elementor');
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
                    'label' => __('Basic)', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'blog_posts_clr',
                [
                    'label' => __('Select Posts color', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Option', 'nokri-elementor') => '',
                        esc_html__('White', 'nokri-elementor') => '',
                        esc_html__('Gray', 'nokri-elementor') => 'light-grey',
                            ))
                ]
        );
        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_description',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
                'post_section',
                [
                    'label' => __('Post Options', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $this->add_control(
                'blog_posts_no',
                [
                    'label' => __('Number Of Post To Show', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => range(1, 50),
                ]
        );
        $this->add_control(
                'blog_posts_title_no',
                [
                    'label' => __('Number of words in title', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => range(1, 50),
                ]
        );
        $this->add_control(
                'blog_posts_order',
                [
                    'label' => __('Select Posts Order', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Option', 'nokri-elementor') => '',
                        esc_html__('ASCENDING', 'nokri-elementor') => 'ASC',
                        esc_html__('DESCENDING', 'nokri-elementor') => 'DESC',
                            ))
                ]
        );
        
        $this->end_controls_section();
         $this->start_controls_section(
                'category_section',
                [
                    'label' => __('Categories', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
       

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'categories',
                [
                    'label' => __('Category', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_get_parests_elementor('category', 'yes'),
                ]
        );
        $this->add_control(
                'blog_posts',
                [
                    'label' => __('Add Category', 'nokri-elementor'),
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
        require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
        extract($settings);

        if (isset($atts['blog_posts']) && $atts['blog_posts'] != '') {
            $rows = $atts['blog_posts'];
            $cats_arr = array();
            if (count((array) $rows) > 0) {
                foreach ($rows as $row) {
                    $cats_arr[] = $row['categories'];
                }
            }
        }
        $cat_tax = '';
        $all_tax = isset($cats_arr[0]) ? $cats_arr[0] : '';

        if (!empty($cats_arr) && $all_tax != "all") {

            $cat_tax = array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $cats_arr,
            );
        }
        /* Post Numbers */
        $section_post_no = (isset($blog_posts_no) && $blog_posts_no != "") ? $blog_posts_no + 1: "6";
        /* Post Orders */
        $section_post_ordr = (isset($blog_posts_order) && $blog_posts_order != "") ? $blog_posts_order : "ASC";
        $args = array(
            'posts_per_page' => $section_post_no,
            'post_type' => 'post',
            'order' => $section_post_ordr,
            'tax_query' => array(
                $cat_tax
            ),
        );
        $the_query = new \WP_Query($args);
        $blogs_html = '';
        if ($the_query->have_posts()) {
            $num = 1;
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $pid = get_the_ID();
                $author_id = get_post_field('post_author', $pid);
                /* Post Title Limit */
                $blog_posts_title_limit = "3";
                if (isset($blog_posts_title_no) && $blog_posts_title_no != "") {
                    $blog_posts_title_limit = $blog_posts_title_no ;
                }
                $thumb_html = '';
                if (has_post_thumbnail()) {
                    $thumb_html = '<div class="nth-latest-product">
									<a href="' . esc_url(get_the_permalink($pid)) . '"> ' . get_the_post_thumbnail($pid, 'nokri_post_standard', array('class' => 'img-responsive')) . ' </a>
								</div>';
                }
                $blogs_html .= '<div class="col-lg-4 col-sm-6 col-md-4 col-xs-12">
											<div class="nth-latest-content">
												' . $thumb_html . '
												<div class="nth-latest-box">
													<div class="nth-latest-cb">
														<div class="nth-latest-details">
															<a href="' . esc_url(get_the_permalink($pid)) . '">
																<h4>' . get_the_title($pid) . '</h4>
															</a>
														</div>
														<div class="nth-latest-in">
															<ul>
																<li><i class="fa fa-comments"></i><span>' . get_comments_number($pid) . '</span>
																</li>
																<li><i class="fa fa-calendar"></i><span>' . get_the_time(get_option('date_format')) . '</span>
																</li>
															</ul>
														</div>
													</div>
													<div class="nth-latest-blog">
														<div class="nth-latest-profile">
														' . get_avatar($the_query->post_author, $size = '45', $default = '', $alt = '', array('class' => array('img-responsive'))) . ' <span class="nth-style-0">' . get_the_author_meta('display_name', $author_id) . '</span> 
														</div>
														<div class="nth-latest-jobs"> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> 
														</div>
													</div>
												</div>
											</div>
										</div>';
                //if($num % 3 == 0){$blogs_html .= '<div class="clearfix"></div>';}
                $num++;
            }
            wp_reset_postdata();
        }
        /* Section Color */
        $section_clr = (isset($blog_posts_clr) && $blog_posts_clr != "") ? $blog_posts_clr : "";
        echo '<section class="nth-latest-update nth-latest2 nth-latest3" ' . esc_attr($section_clr) . '>
			<div class="container">
			<div class="row">
			     ' . $header . '
				 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
					 <div class="row">
						' . $blogs_html . '
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
