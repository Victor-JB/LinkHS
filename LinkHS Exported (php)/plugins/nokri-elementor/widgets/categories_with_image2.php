<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Cat_With_Back extends Widget_Base {

    public function get_name() {
        return 'categories-with-background';
    }

    public function get_title() {
        return __('Categories With Background', 'nokri-elementor');
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
                'images_section',
                [
                    'label' => __('Images)', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'section_img',
                [
                    'label' => __('Background Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'basic_section',
                [
                    'label' => __('Basic)', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
                'section_desc',
                [
                    'label' => __('Section Description', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::WYSIWYG,
                ]
        );

        $this->add_control(
                'section_open_txt',
                [
                    'label' => __('Opening Text', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'section_open_txt2',
                [
                    'label' => __('Multiple openings text', 'nokri-elementor'),
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
            /* Opening txt */
            $one_opening = (isset($section_open_txt) && $section_open_txt != "") ? $section_open_txt : esc_html__('Openings', 'nokri-elementor');
            $more_opening = (isset($section_open_txt2) && $section_open_txt2 != "") ? $section_open_txt2 : esc_html__('Openings', 'nokri-elementor');
            if (count((array) $rows) > 0) {
                $cats_html = '';
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        if ($row['cat'] == 'all') {
                            $cats = true;
                            break;
                        }
                        
                             
                        $category = get_term_by('slug', $row['cat'], 'job_category');
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($category->term_id, 'job_category');
                       
                     
                        /* Category Image */
                        $cat_img = '';
                        if (isset($row['cat_img']['url'])) {
                            $img = $row['cat_img']['url'];
                            $img_thumb = $img;
                            $cat_img = '<div class="cat-icons"><img src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '"></div>';
                        }
                        $count_cat = $one_opening;
                        if ($category->count > 1) {
                            $count_cat = $more_opening;
                        }
                        $cats_html .= '<li><a href="' . nokri_cat_link_page($category->term_id) . '" >
						' . $cat_img . '
						' . $category->name . '
						<span>(' . $custom_count . " " . $count_cat . ')</span>
						<span class="arrow"> <i class="ti-arrow-right"></i></span>
						</a>
						</li>';
                    }
                }
                if ($cats) {
                    $ad_cats = nokri_get_cats('job_category', 0);
                    /* Category Image */
                    $cat_img = '';
                    if (isset($row['cat_img'])) {
                      
                        
                        $img = wp_get_attachment_image_src($row['cat_img'], '');
                        $img_thumb = $img[0];
                        $cat_img = '<img src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri-elementor') . '">';
                    }
                    foreach ($ad_cats as $cat) {
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($cat->term_id, 'job_category');
                        $count_cat = $one_opening;
                        ;
                        if ($cat->count > 1) {
                            $count_cat = $more_opening;
                        }
                        $cats_html .= '<li><a href="' . nokri_cat_link_page($cat->term_id) . '" >
						' . $cat_img . '
						' . $cat->name . '
						<span>(' . $custom_count . " " . $count_cat . ')</span>
						<span class="arrow"> <i class="ti-arrow-right"></i></span>
						</a>
						</li>';
                    }
                }
            }
        }
        /* Background Image */
        $bg_img = '';
        if (isset($section_img['url'])) {
            $bgImageURL = $section_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: url(' . $bgImageURL . ') no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: contain; background-position: center center; background-attachment:scroll;"' : "";
        }
        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? '<h2>' . $section_title . '</h2>' : "";
        /* Section description */
        $section_description = (isset($section_desc) && $section_desc != "") ? '<p>' . $section_desc . '</p>' : "";

        /* Link 1 */
        $btn = '';     
        if (isset($button_txt)) {
            $btn_txt  =   $button_txt;
          

            $btn = elementor_ThemeBtn($link, 'btn n-btn-flat btn-mid', false,'','',$btn_txt);
          
        }


        echo  '<section class="categories-section-2" id="elegent_catz" '.str_replace('\\',"",$bg_img).'>
    <div class="container">
        <div class="row">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="heading-title black">
                    '.$section_title.'
                 '.$section_description.'
                </div>
              </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="categories-boxes-2">
                	<div class="row">
                  <ul class="popular-categories">
				  '.$cats_html.'
				  </ul>
                    </div>
                </div>
                <div class="n-extra-btn-section">
            	'.$btn.'
            </div>
            </div>
        </div>
    </div>
</section>
   ';
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
