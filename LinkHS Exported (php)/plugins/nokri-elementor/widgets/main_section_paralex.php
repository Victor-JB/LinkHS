<?php

namespace ElementorNokri\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Hero_Section_Main_Paralex extends Widget_Base {

    public function get_name() {
        return 'hero-section-main-paralex';
    }

    public function get_title() {
        return __('Advance Search - Tabs', 'nokri-elementor');
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
                'search_section_img',
                [
                    'label' => __('Background Image', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    "description" => esc_html__('1263 x 147', 'nokri-elementor'),
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
                'section_tagline',
                [
                    'label' => __('Section Tagline', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'category_section',
                [
                    'label' => __('categories', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
                ]
        );
        $this->add_control(
                'want_to_show',
                [
                    'label' => __('Do you want to show sub locations', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'no',
                    'options' => [
                        'yes' => __('yes', 'nokri-elementor'),
                        'no' => __('no', 'nokri-elementor'),
                    ],
                ]
        );


        $this->end_controls_section();



        $this->start_controls_section(
                'country_section',
                [
                    'label' => __('Countries', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'country',
                [
                    'label' => __('Select Country', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => array_flip(nokri_get_all('ad_location', 'yes')),
                ]
        );
        $this->add_control(
                'countries',
                [
                    'label' => __('Select Countries ( All or Selective )', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                ]
        );
        $this->add_control(
                'want_to_show_loc',
                [
                    'label' => __('Do you want to show sub locations', 'plugin-domain'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'no',
                    'options' => [
                        'yes' => __('yes', 'nokri-elementor'),
                        'no' => __('no', 'nokri-elementor'),
                    ],
                ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
                'category_hot_section',
                [
                    'label' => __('Hot Cats', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'hot_title',
                [
                    'label' => __('Section Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'hot_cat',
                [
                    'label' => __('Select hot categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_get_parests_elementor('job_category', 'no'),
                ]
        );
        $this->add_control(
                'hot_cats',
                [
                    'label' => __('Select hot categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    
                ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
                'category_slider_section',
                [
                    'label' => __('Slider Cats', 'nokri-elementor'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'cats_title',
                [
                    'label' => __('Section Title', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
        );
        $this->add_control(
                'btn_txt',
                [
                    'label' => __('Button text', 'nokri-elementor'),
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

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
                'cat_slider',
                [
                    'label' => __('Select hot categories', 'nokri-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => nokri_get_parests_elementor('job_category', 'yes'),
                ]
        );
        $this->add_control(
                'cat_sliders',
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

        if (isset($want_to_show) && $want_to_show == "yes") {
            
        }
        // For Job Category
         $cats_html = '';
        if (isset($atts['cats']) && !empty($atts['cats']) != '') {
            $rows = $atts['cats'];
            $cats = false;
           
            if (count($rows) > 0) {
                $cats_html .= '';
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        if ($row['cat'] == 'all') {
                            $cats = true;
                            $cats_html = '';
                            break;
                        }
                        $category = get_term_by('slug', $row['cat'], 'job_category');
                        if (count(array($category)) == 0)
                            continue;

                        if (isset($want_to_show) && $want_to_show == "yes") {

                            $ad_cats_sub = nokri_get_cats('job_category', $category->term_id);
                            if (count(array($ad_cats_sub)) > 0) {
                                $cats_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                                foreach ($ad_cats_sub as $ad_cats_subz) {
                                    $cats_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                                }
                                $cats_html .= '</option>';
                            } else {
                                $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                            }
                        } else {
                            $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    }
                }

                if ($cats) {
                    $ad_cats = nokri_get_cats('job_category', 0);
                    foreach ($ad_cats as $cat) {
                        if (isset($want_to_show) && $want_to_show == "yes") {
                            //sub cat
                            $ad_sub_cats = nokri_get_cats('job_category', $cat->term_id);
                            if (count(array($ad_sub_cats)) > 0) {
                                $cats_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                                foreach ($ad_sub_cats as $sub_cat) {
                                    $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                    //sub sub cat
                                    $ad_sub_sub_cats = nokri_get_cats('job_category', $sub_cat->term_id);
                                    if (count($ad_sub_sub_cats) > 0) {
                                        foreach ($ad_sub_sub_cats as $sub_cat_sub) {
                                            $cats_html .= '<option value="' . $sub_cat_sub->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;' . $sub_cat_sub->name . '  (' . $sub_cat_sub->count . ') </option>';
                                            //sub sub sub cat
                                            $ad_sub_sub_sub_cats = nokri_get_cats('job_category', $sub_cat_sub->term_id);
                                            if (count($ad_sub_sub_sub_cats) > 0) {
                                                foreach ($ad_sub_sub_sub_cats as $sub_cat) {
                                                    $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;- &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                                }
                                            }
                                        }
                                    }
                                }
                                $cats_html .= '</option>';
                            } else {
                                $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                            }
                        } else {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    }
                }
            }
        }
        
        
       
        // countries
            $countries_html 	=	'';
		if(isset($atts['countries']) && !empty($atts['countries']) != '')
       {
			$rows = $atts['countries'];
			$countries_sub	=	false;
			$countries_html 	=	'';
			if( count( $rows ) > 0 )
			{
				$countries_html  .= '';
				foreach($rows as $row )
				{
					if( isset( $row['country'] )  )
					{
						if($row['country'] == 'all' )
						{
							$countries_sub = true;
							$countries_html  = '';
							break;
						}
						$locations = get_term_by('slug', $row['country'], 'ad_location');
						if( count( array($locations) ) == 0 )
						continue;
						if(isset($want_to_show_loc) && $want_to_show_loc == "yes")
						{
							$ad_cats_sub	=	nokri_get_cats('ad_location' , $locations->term_id );
							if(count(array($ad_cats_sub)) > 0 )
							{
								$countries_html  .= '<option value="'.$locations->term_id.'" >'.$locations->name.'  ('.$locations->count.')' ;
								foreach( $ad_cats_sub as $ad_cats_subz )
								{
									$countries_html  .= '<option value="'.$ad_cats_subz->term_id.'">'.'&nbsp;&nbsp; - &nbsp;' .$ad_cats_subz->name.'  ('.$ad_cats_subz->count.') </option>';
								}
								$countries_html  .='</option>';
							}
							else
							{
								$countries_html  .= '<option value="'.$category->term_id.'">'.$category->name. '   ('.$category->count.')</option>';
							}
						}
						else
						{
							$countries_html  .= '<option value="'.$locations->term_id.'">'.$locations->name. '  ('.$locations->count.')</option>';
						}
						
					}
				}
                                
                                
                                
                               
                                
				if( $countries_sub )
				{
					$ad_cats = nokri_get_cats('ad_location', 0 );
					foreach( $ad_cats as $cat )
					{
						if(isset($want_to_show_loc) && $want_to_show_loc == "yes")
						{
						   //sub cat
							$ad_sub_cats	=	nokri_get_cats('ad_location' , $cat->term_id );
							if(count($ad_sub_cats) > 0 )
							{
								$countries_html  .= '<option value="'.$cat->term_id.'" >'.$cat->name.'  ('.$cat->count.')' ;
								foreach( $ad_sub_cats as $sub_cat )
								{
									$countries_html  .= '<option value="'.$sub_cat->term_id.'">'.'&nbsp;&nbsp; - &nbsp;' .$sub_cat->name.'  ('.$sub_cat->count.') </option>';
									 //sub sub cat
									 $ad_sub_sub_cats	=	nokri_get_cats('ad_location' , $sub_cat->term_id );
									 if(count($ad_sub_sub_cats) > 0 )
										{
											foreach( $ad_sub_sub_cats as $sub_cat_sub )
											{
												$countries_html  .= '<option value="'.$sub_cat_sub->term_id.'">'.'&nbsp;&nbsp; - &nbsp; - &nbsp;' .$sub_cat_sub->name.'  ('.$sub_cat_sub->count.') </option>';
												//sub sub sub cat
												 $ad_sub_sub_sub_cats	=	nokri_get_cats('ad_location' , $sub_cat_sub->term_id );
												 if(count($ad_sub_sub_sub_cats) > 0 )
												 {
													foreach( $ad_sub_sub_sub_cats as $sub_cat )
													{
														$countries_html  .= '<option value="'.$sub_cat->term_id.'">'.'&nbsp;&nbsp; - &nbsp; - &nbsp;- &nbsp;' .$sub_cat->name.'  ('.$sub_cat->count.') </option>';
													}
												 }
											}
										}
								}
								$countries_html  .='</option>';	
							}
							else
							{
								$countries_html  .= '<option value="'.$cat->term_id.'">'.$cat->name.'   ('.$cat->count.')</option>';
							}
						}
						else
						{
							$countries_html  .= '<option value="'.$cat->term_id.'">'.$cat->name.'  ('.$cat->count.')</option>';
						}
					}
					
				}
			}
	   }
        // For hot categories
        $hot_cats_html = '';
        if (isset($atts['hot_cats']) && !empty($atts['hot_cats'])) {
            $rows_hot_cats = $atts['hot_cats'];
            $year_countries = false;
            $hot_cats_html = '';
            $get_year = '';
            if (count($rows_hot_cats) > 0) {
                foreach ($rows_hot_cats as $rows_hot_cat) {
                    if (isset($rows_hot_cat['hot_cat'])) {
                        if ($rows_hot_cat['hot_cat'] == 'all') {
                            $year_countries = true;
                            $countries_html = '';
                            break;
                        }
                         $get_hot_cat = array();
                        if($rows_hot_cat['hot_cat']!="")
                        {
                        $get_hot_cat = get_term_by('slug', $rows_hot_cat['hot_cat'], 'job_category');
                                          
                        if (count((array) $get_hot_cat) == 0)
                            continue;
                        $hot_cats_html .= '<a href="' . nokri_cat_link_page($get_hot_cat->term_id) . '">' . $get_hot_cat->name . '</a>';
                    }
                }
            }
        } }  
        /* Section Title */
        $main_section_title = (isset($section_title) && $section_title != "") ? ' <h1>' . $section_title . '</h1>' : "";
        /* Section Tagline */
        $main_section_tagline = (isset($section_tagline) && $section_tagline != "") ? ' <p>' . $section_tagline . '</p>' : "";
        /* hot Title */
        $hot_section_title = (isset($hot_title) && $hot_title != "") ? '<span class="n-most-cat-title">' . $hot_title . '</span>' : "";
        /* Background Image */
        $bg_img = '';
        if (isset($search_section_img['url'])) {
            $bgImageURL = $search_section_img['url'];
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $bgImageURL . ') no-repeat scroll center center / cover;"' : "";
        }
        // For cats slider
        $cats_slide_html = '';
        if (!empty($atts['cat_sliders'])) {
            $rows_sliders = $atts['cat_sliders'];
            $cats_slide = false;
            if (count((array) $rows_sliders) > 0) {
                $cats_slide_html .= '';
                foreach ($rows_sliders as $rows_slider) {
                    if (isset($rows_slider['cat_slider'])) {
                        if ($rows_slider['cat_slider'] == 'all') {
                            $cats_slide = true;
                            break;
                        }
                        $category = get_term_by('slug', $rows_slider['cat_slider'], 'job_category');
                        if (count((array) $category) == 0)
                            continue;
                        $count_cat = esc_html__('Opening', 'nokri-elementor');
                        if ($category->count > 1) {
                            $count_cat = esc_html__('Openings', 'nokri-elementor');
                        }
                        $cats_slide_html .= '<div class="item">
											<div class="n-cats">
												<a href="' . nokri_cat_link_page($category->term_id) . '">
													<h4>' . $category->name . '</h4>
													<p>(' . $category->count . " " . $count_cat . ')</p>
												</a>
											</div>
										</div>';
                    }
                }
                if ($cats_slide) {
                    $count_cat = '';
                    $ad_cats = nokri_get_cats('job_category', 0);
                    foreach ($ad_cats as $cat) {
                        if ($cat->count > 1) {
                            $count_cat = esc_html__('Openings', 'nokri-elementor');
                        } else {
                            $count_cat = esc_html__('Opening', 'nokri-elementor');
                        }
                        $cats_slide_html .= '<div class="item">
											<div class="n-cats">
												<a href="' . nokri_cat_link_page($cat->term_id) . '">
													<h4>' . $cat->name . '</h4>
													<p>(' . $cat->count . " " . $count_cat . ')</p>
												</a>
											</div>
										</div>';
                    }
                }
            }
        }
        /* Section Title */
        $cats_title = (isset($cats_title) && $cats_title != "") ? ' <h4>' . $cats_title . '</h4>' : "";
        /* Link  */
       $btn = '';
  
        if (isset($btn_txt)) {
            $btn = elementor_ThemeBtn($link, '', false,'','',$btn_txt);
        }
        echo '<section class="n-hero-section" ' . str_replace('\\', "", $bg_img) . '>
    <div class="container">
      <div class="row">
      		<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2">
            	<div class="n-hero-box">
                    <div class="n-hero-main-text">
                        ' . $main_section_title . '
                        ' . $main_section_tagline . '
                    </div>
                    <div class="n-hero-form-cat">
                        <div class="n-most-cat">
                            ' . $hot_section_title . '
                            <span class="n-most-cat-list">
                                ' . $hot_cats_html . '
                            </span>
                        </div>
                        <div class="n-saech-form">
							<form  method="get" action="' . get_the_permalink($nokri['sb_search_page']) . '">
								' . nokri_form_lang_field_callback(false) . '
                            	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                	<div class="row">
                                    	<div class="form-group">
										 <input type="text" class="form-control" name="job-title" placeholder="' . esc_html__('Search Keyword', 'nokri-elementor') . '">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                	<div class="row">
                                        <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="' . esc_html__('Select Category', 'nokri-elementor') . '" style="width: 100%" name="cat-id">
                                             <option label="' . esc_html__('Select Category', 'nokri-elementor') . '"></option>
                     					' . $cats_html . '
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
                                	<div class="row">
                                        <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="' . esc_html__('Select Location', 'nokri-elementor') . '" style="width: 100%" name="job-location">
                                         <option value="">' . esc_html__('Select Location', 'nokri-elementor') . '</option>
                                           ' . $countries_html . '
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                	<div class="row">
									<button type="submit" class="btn n-btn-flat">' . esc_html__('Search', 'nokri-elementor') . '<i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </div>
    <div class="n-hero-cat-section" id="hero-cat-parralex">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                    <div class="n-category-box">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <div class="n-hero-cat-heading">
                                ' . $cats_title . '
                                ' . $btn . '
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                            <div class="main-hero-cat owl-carousel owl-theme ">
                              ' . $cats_slide_html . '
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
