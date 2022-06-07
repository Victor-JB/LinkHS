<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Blog_Post extends Widget_Base {

    public function get_name() {
        return 'blog_post';
    }

    public function get_title() {
        return __('Blog post', 'nokri-elementor');
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
                    'label' => __('Hot Cats', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );


        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'categories',
                [
                    'label' => __('Category', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_get_parests_elementor('category', 'no'),
                ]
        );
        $this->add_control(
                'blog_posts',
                [
                    'label' => __('Add Category', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                // 'categories' => '{{ { countries }}}',
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
        require trailingslashit(get_template_directory()) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
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
        /* View  Link */
        $read_more = '';
        if (isset($link)) {
            $read_more = '<div class="n-extra-btn-section">' . nokri_ThemeBtn($link, 'btn n-btn-flat btn-mid btn-clear', false) . '</div>';
        }

        /* Post Numbers */
        $section_post_no = (isset($blog_posts_no) && $blog_posts_no != "") ? $blog_posts_no +1 : "6";
        /* Post Orders */
        $section_post_ordr = (isset($blog_posts_order) && $blog_posts_order != "") ? $blog_posts_order : "ASC";
        $args = array(
            'posts_per_page' => $section_post_no,
            'post_type' => 'post',
            'order' => $section_post_ordr,
            'orderby'  => 'date', 
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $cats_arr,
                ),
            ),
        );
        $the_query = new \WP_Query($args);
        $blogs_html = '';
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $pid = get_the_ID();
                /* Post Title Limit */
                $blog_posts_title_limit = "3";
                if (isset($blog_posts_title_no) && $blog_posts_title_no != "") {
                    $blog_posts_title_limit = $blog_posts_title_no;
                }
                $thumb_html = '';
                if (has_post_thumbnail()) {
                    $thumb_html = '<div class="n-blog-top">
                        	<a href="' . esc_url(get_the_permalink($pid)) . '"> ' . get_the_post_thumbnail($pid, 'nokri_post_standard', array('class' => 'img-responsive')) . ' </a>
                        </div>';
                }


                $blogs_html .= '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                	<div class="n-blog-box">
                    	' . ($thumb_html) . '
                        <div class="n-blog-bottom">
                        	<ul>
                            	<li>' . get_the_time(get_option('date_format')) . '</li>
                            </ul>
                            <h4> <a href="' . esc_url(get_the_permalink($pid)) . '">' . get_the_title($pid) . ' </a></h4>
                            <p>' . nokri_words_count(get_the_excerpt(), 105) . ' </p>
                            <a href="' . esc_url(get_the_permalink($pid)) . '" class="read-more">' . __("Read More", "nokri-elementor") . '</a>
                            <a href="javascript:void(0)" class="author-icon">' . get_avatar($the_query->post_author, $size = '45', $default = '', $alt = '', array('class' => array('img-responsive', 'img-circle'))) . '</a>
                        </div>
                    </div>
                </div>';
            }
            wp_reset_postdata();
        }
        /* Section Color */
        $section_clr = (isset($blog_posts_clr) && $blog_posts_clr != "") ? $blog_posts_clr : "";
        echo '<section class="n-blog-section ' . esc_attr($section_clr) . '">
    <div class="container">
      <div class="row">
        ' . $header . '
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
               ' . $blogs_html . '
            </div>
			' . $read_more . '
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
