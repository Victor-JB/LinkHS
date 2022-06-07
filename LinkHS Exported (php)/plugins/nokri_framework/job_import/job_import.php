<?php 
/*
Plugin Name: Job add on
Description: A super awesome add-on for WP All Import!
Version: 1.0
Author: WP All Import
*/
include "rapid-addon.php";

final class my_first_add_on {

    protected static $instance;

    protected $add_on;
	
	protected function __construct() {
        
    // Define the add-on
        $this->add_on = new RapidAddon( 'nokri Jobs import', 'my_first_addon' );
        $this->add_on->add_text( 'Please add valid taxanomies id.' );
	$this->add_on->add_field('_job_date', 'Job Expiry', 'text'); 
        $this->add_on->add_field('_job_posts', 'number of vacancies', 'text');
        $this->add_on->add_field('_job_address', 'Job Adress', 'text'); 
        $this->add_on->add_field('_job_lat', 'Job latitide', 'text'); 
        $this->add_on->add_field('_job_long', 'Job longitude', 'text'); 
        $this->add_on->add_field('_job_apply_with', 'job apply with(inter,email,whatsapp,exter)', 'text'); 
        $this->add_on->add_field('_job_video', 'Job Video', 'text'); 
	$this->add_on->set_import_function([ $this, 'import' ]);
        add_action( 'init', [ $this, 'init' ] );
	}
    static public function get_instance() {
        if ( self::$instance == NULL ) {
            self::$instance = new self();
        }
        return self::$instance;   
	}	
	public function import( $post_id, $data, $import_options, $article ) { 
             wp_set_post_terms($post_id, 420, 'job_shift');
             wp_set_object_terms($post_id, 420, 'job_shift');
            
  
   $fields_static  = array( 
      '_job_date',
      '_job_posts',
      '_job_lat',
      '_job_long',
      '_job_apply_with',
      '_job_video',
      '_job_address',
      );
    foreach ( $fields_static as $field_static ) { 
        // Make sure the user has allowed this field to be updated.
        if ( empty( $article['ID'] ) || $this->add_on->can_update_meta( $field, $import_options ) ) { 
            // Update the custom field with the imported data.
            update_post_meta( $post_id, $field_static, $data[ $field_static ] ); 
        } 
    } 
    
    
     
}

	
	
	public function init() {
    $this->add_on->run();

}

}

my_first_add_on::get_instance();