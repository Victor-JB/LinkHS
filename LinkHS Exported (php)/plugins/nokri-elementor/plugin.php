<?php
namespace ElementorNokri;
/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {
	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	/* call constructor */
	public function __construct() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
		add_action( 'elementor/elements/categories_registered',  [ $this, 'add_elementor_widget_categories' ]  );

		/* include render html file */
		require_once( __DIR__ . '/shortcodes-html.php' );
                require_once( __DIR__ . '/functions.php' );
	}
	/**
	 * Include Widgets files
	 *
	 */
	private function include_widgets_files() {	              		
                require_once( __DIR__ . '/widgets/search_paralex_2_new.php' );
                require_once( __DIR__ . '/widgets/search_paralex_2.php');
                require_once( __DIR__ . '/widgets/search_paralex_sidebar.php');  
                require_once( __DIR__ . '/widgets/main_section_paralex.php');                 
                require_once( __DIR__ . '/widgets/hero_section.php');
                require_once( __DIR__ . '/widgets/hero_section1.php');
                require_once( __DIR__ . '/widgets/hero_section2.php');
                require_once( __DIR__ . '/widgets/hero_section3.php');
                require_once( __DIR__ . '/widgets/hero_premium_section.php' );
                require_once( __DIR__ . '/widgets/about_us.php' );
                require_once( __DIR__ . '/widgets/about_tabs.php' );                                                                         
                require_once( __DIR__ . '/widgets/client_with_bg.php' );               
                require_once( __DIR__ . '/widgets/categories_slider.php' );
                require_once( __DIR__ . '/widgets/categories_with_images.php' );               
                require_once( __DIR__ . '/widgets/categories_with_image2.php' );
                require_once( __DIR__ . '/widgets/categories_with_images_new.php' );
                require_once( __DIR__ . '/widgets/call_action.php' );
                require_once( __DIR__ . '/widgets/call_action2.php' );
                require_once( __DIR__ . '/widgets/call_action3.php' );
                require_once( __DIR__ . '/widgets/call_action4.php' );                
                require_once( __DIR__ . '/widgets/premium_jobs.php' );
                require_once( __DIR__ . '/widgets/premium_jobs_grid.php' ); 
                require_once( __DIR__ . '/widgets/premium_jobs_with_tabs.php' );
                require_once( __DIR__ . '/widgets/premium_jobs_with_tabs2.php' );
                require_once( __DIR__ . '/widgets/recent_jobs.php' );
                require_once( __DIR__ . '/widgets/recent_jobs_list.php' );                           
                require_once( __DIR__ . '/widgets/featured_candidates.php');
                require_once( __DIR__ . '/widgets/featured_candidates2.php');
                require_once( __DIR__ . '/widgets/featured_candidates3.php');
                require_once( __DIR__ . '/widgets/pricing.php');
                require_once( __DIR__ . '/widgets/pricing_modern.php');
                require_once( __DIR__ . '/widgets/pricing_cand.php');                             
                require_once( __DIR__ . '/widgets/success_stories.php' );
                require_once( __DIR__ . '/widgets/success_stories1.php' );
                require_once( __DIR__ . '/widgets/success_stories_slider.php' );                
                require_once( __DIR__ . '/widgets/app_section.php' );
                require_once( __DIR__ . '/widgets/appsection_modern.php' );
                require_once( __DIR__ . '/widgets/blog_posts.php' );
                require_once( __DIR__ . '/widgets/blog_post_modern.php' );                          
                require_once( __DIR__ . '/widgets/emp_list.php' );
                require_once( __DIR__ . '/widgets/employer_slider.php' );
                require_once( __DIR__ . '/widgets/client_with_bg.php' );
                require_once( __DIR__ . '/widgets/cand_emp_sec.php' );
                require_once( __DIR__ . '/widgets/cand_emp_sec1.php' );
                require_once( __DIR__ . '/widgets/cand_emp_sec2.php' );               
                require_once( __DIR__ . '/widgets/how_works.php');
                require_once( __DIR__ . '/widgets/jobs_cand_cat_section.php');
                require_once( __DIR__ . '/widgets/top_hirings.php');
                require_once( __DIR__ . '/widgets/top_hirings_slider.php');
                require_once( __DIR__ . '/widgets/job_location_images.php'); 
                require_once( __DIR__ . '/widgets/advertisment.php'); 
                require_once( __DIR__ . '/widgets/contact_us.php'); 
                require_once( __DIR__ . '/widgets/signin.php'); 
                require_once( __DIR__ . '/widgets/signup.php');                
	}
	
	//Ad Shortcode Category
	public function add_elementor_widget_categories($category_manager)
	{
            $category_manager->add_category(
				'nokritheme',
				[
					'title' => __( 'Nokri Widgets', 'nokri-elementor' ),
					'icon' => 'fa fa-home',
				]
            );
    }
	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();
		// Register Widgets
		 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Section_New());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Section_paralex()); 
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Section_Paralex_Sidebar());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Section_Main_Paralex());                                                           
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Premium_Section());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Section());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Section1());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Section2());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Section3());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\About_Us());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\About_Us_Tabs());                
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Cat_Slider());                      
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Cat_With_Back());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Cat_With_Img());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Cat_With_Img_New());                
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_Action());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_Action2());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_Action3()); 
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_Action4());                              
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Premium_Jobs());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Premium_Jobs_Grid());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Premium_Jobs_Tabs());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Premium_Jobs_Tab2());                                                  
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Recent_Jobs());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Recent_Jobs_List());               
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Featured_Candidates());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Featured_Candidates2()); 
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Featured_Candidates3()); 
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Pricing_Sec());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Pricing_Modern_Sec());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Pricing_Cand());                 
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Success_Stories());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Success_Stories1()); 
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Success_Stories_Slider()); 
                 
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\App_Section());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\App_Section_Modern());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Blog_Post_Modern());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Blog_Post());                                                
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Emp_List());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Emp_Slider());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Our_Client());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Cand_Emp_Sec());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Cand_Emp_Sec1());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Cand_Emp_Sec2());                 
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\How_Works());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Job_Cand_Cat());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Top_Hiring());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Top_Hiring_Slider());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Location_Images()); 
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Advertise_Sec());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Contact_Us_Sec());
                 \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Signin_Sec());
                  \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Signup_Sec());
                 
                 
                 
                 
                 
	}
}

Plugin::instance();