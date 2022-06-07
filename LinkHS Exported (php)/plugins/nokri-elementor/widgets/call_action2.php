<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Call_Action2 extends Widget_Base {

    public function get_name() {
        return 'call-to-action2';
    }

    public function get_title() {
        return __('Call To Action 2', 'nokri-elementor');
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
                'call_action_bg_img',
                [
                    'label' => __('Background Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,                                   
                ]
        );
         $this->add_control(
                'call_action_img',
                [
                    'label' => __('Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    
                   
                ]
        );
        $this->add_control(
                'call_action_heading',
                [
                    'label' => __('Section Heading', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'call_action_details',
                [
                    'label' => __('Section Details', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
                'link_section',
                [
                    'label' => __('Links)', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'btn_txt',
                [
                    'label' => __('Some Detail', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
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

      $section_heading = (isset($call_action_heading) && $call_action_heading != "") ? '<h3>'.$call_action_heading.'</h3>' : "";
/*Section Details */
$section_details = (isset($call_action_details) && $call_action_details != "") ? '<p>'.$call_action_details.'</p>' : "";
$paras = explode("|", $section_details);
$paragraph_html = '';
foreach($paras as $para)
{
	$paragraph_html .= '<p>'.$para.'</p>';
}
 
/*Link*/
$btn = '';
  
        if (isset($btn_txt)) {
            $btn = elementor_ThemeBtn($link, 'btn n-btn-flat btn-mid', false,'','',$btn_txt);
        }

/* Background Image */
$bg_img = '';
if( isset($call_action_bg_img['url']) )
{
$bgImageURL	=	$call_action_bg_img['url'];
$bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background: url('.$bgImageURL.') no-repeat; -webkit-background-size: contain; -moz-background-size: cover; -o-background-size: contain; background-size: contain; background-position: center center; background-attachment:scroll;"' : "";
}
/*Section Image */
$section_img = '';       
        if(isset($call_action_img['url'] ))
{
	$img 		=  	$call_action_img['url'];
	$img_thumb 	= 	$img;
}

echo '<section class="n-call-to-action-two light-grey nopadding" >
         <div class="container-fluid">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="row">
                     <div class="n-call-to-box">
                        <div class="row">
                           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 hidden-md">
                              <div class="img-side-fluid" '.str_replace('\\',"",$bg_img).'>
                                 <img src="'.$img_thumb.'" class="img-responsive" alt="'.esc_attr__('image', 'nokri-elementor').'">
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                              <div class="n-call-to-action-text">
                                 '.$section_heading.'
                                '.$paragraph_html.'
                              </div>
                              <div class="n-extra-btn-section">
                                '.$btn.'
                              </div>
                           </div>
                        </div>
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
