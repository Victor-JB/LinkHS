<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Top_Hiring_Slider extends Widget_Base {

    public function get_name() {
        return 'top-hiring-slider';
    }

    public function get_title() {
        return __('Top Hiring Slider', 'nokri-elementor');
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
                'section_bg_img',
                [
                    'label' => __('Select Backgroun color', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                     "description" => esc_html__('1920 x 448', 'nokri-elementor'),
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
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
                'employer_section',
                [
                    'label' => __('Select Employers', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'employer_img',
                [
                    'label' => __('Select employer', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    "description" => esc_html__('190 x 125', 'nokri-elementor'),
                ]
        );

        $repeater->add_control(
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
                ]
        );
        $this->add_control(
                'employers',
                [
                    'label' => __('Select Employers', 'nokri-elementor'),
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
        
        $hiring_html = ''; 
      if(isset($atts['employers']) && !empty($atts['employers']) != '')
{
	$rows = $atts['employers'];
	$hiring_html = '';
	if( (array)count( $rows ) > 0 )
	{
		foreach($rows as $row ) 
		{
			$img_html = '';
			if(isset( $row['employer_img']['url']) &&  $row['employer_img']['url']!='') 
			{
				
				$img  = $row['employer_img']['url'];
				if(isset( $row['link']['url']) &&  $row['link']['url'] !='')
				{
					$url      =  $row['link']['url'];
					$img_html =  '<div class="item"><a href="'.esc_url($url).'">
									<div class="n-hiring2-bg"> <img src="'.$img.'" alt="'.esc_attr__("image", "nokri-elementor").'" class="img-responsive"></div></a></div>';
				}
				else
				{
					$img_html = '<div class="item">
					<div class="n-hiring2-bg"> <img src="'.$img.'" alt="'.esc_attr__("image", "nokri-elementor").'" class="img-responsive"> </div></div>';
				}
			}
				/*Story Html */		
				$hiring_html .= $img_html;
		 }
	}
}
  /*Section Image */
$bg_img = '';
if( isset($section_bg_img['url']) )
{
$bgImageURL	=	$section_bg_img['url'];
$bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url('.$bgImageURL.') no-repeat scroll center center / cover;"' : "";
}
  /*Section name */
$section_title = (isset($section_title) && $section_title != "") ? '<h3>'.$section_title.'</h3>' : "";
 /*Section desc */
$section_descs = (isset($section_desc) && $section_desc != "") ? '<p>'.$section_desc.'</p>' : "";
   echo  '<section class="n-hiring-employ2"  '.str_replace('\\',"",$bg_img).'>
				<div class="container">
					<div class="row">
					<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
						<div class="heading-penel">
						'.$section_title.'
						'.$section_descs.'
						</div>
					</div>
					<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
						<div class="hiring-slider owl-carousel owl-theme">
						'.$hiring_html.'
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
