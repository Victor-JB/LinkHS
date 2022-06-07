<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Cat_With_Img extends Widget_Base {

    public function get_name() {
        return 'categories-with-images';
    }

    public function get_title() {
        return __('Categories With Images', 'nokri-elementor');
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
                'cats_section_clr',
                [
                    'label' => __('Select Background color', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(array(
                        esc_html__('Select Option', 'nokri-elementor') => '',
                        esc_html__('Sky BLue', 'nokri-elementor') => 'light-grey',
                        esc_html__('White', 'nokri-elementor') => '',
                            ))
                ]
        );
        $this->add_control(
                'section_title',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );  
        $this->add_control(
                'button_txt',
                [
                    'label' => __('Button text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->add_control(
                'link',
                [
                    'label' => __('Link', 'propertya-elementor'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => __('https://your-link.com', 'propertya-elementor'),
                    'show_external' => true,
                    'default' => [
                        'url' => '#',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
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
                'cat',
                [
                    'label' => __('Select hot categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_get_parests_elementor('job_category', 'no'),
                ]
        );

        $repeater->add_control(
                'cat_img',
                [
                    'label' => __('Category Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    "description" => esc_html__('64x64', 'nokri-elementor'),
                ]
        );
        $this->add_control(
                'cats',
                [
                    'label' => __('Select hot categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'countries' => '{{ { countries }}}',
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

        if (isset($atts['cats']) && $atts['cats'] != '') {
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
                        if (!$category)
                            continue;
                        /* Category Image */
                        $cat_img = '';
                        if (isset($row['cat_img']['url'])) {
                            $img = $row['cat_img']['url'];
                            
                            $cat_img = '<span class="images-icon"><img src="' . esc_url($img) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '"></span>';
                        }
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($category->term_id, 'job_category');
                        $count_cat = esc_html__('Opening', 'nokri-elementor');
                        if ($category->count > 1) {
                            $count_cat = esc_html__('Openings', 'nokri-elementor');
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
                    if (isset($row['cat_img']['url'])) {
                        $img = $row['cat_img']['url'];
                       
                        $cat_img = '<img src="' . esc_url($img) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '">';
                    }
                    foreach ($ad_cats as $cat) {
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($cat->term_id, 'job_category');
                        $count_cat = esc_html__('Opening', 'nokri-elementor');
                        if ($cat->count > 1) {
                            $count_cat = esc_html__('Openings', 'nokri-elementor');
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
        if (isset($button_txt)) {
            $btn_txt = $button_txt;
            $btn = elementor_ThemeBtn($link, 'btn n-btn-flat btn-mid', false, '', '', $btn_txt);
        }

    
        $section_clr = (isset($cats_section_clr) && $cats_section_clr != "") ? $cats_section_clr : "";
        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? '<h2>' . $section_title . '</h2>' : "";



        echo '<section class="n-featured-cat" id="scroll_cats" ' . $section_clr . '>
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
