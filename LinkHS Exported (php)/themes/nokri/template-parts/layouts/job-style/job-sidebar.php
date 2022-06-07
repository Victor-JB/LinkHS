<?php 
global $nokri;
$job_id	   =	get_the_ID();
$user_id   =   get_current_user_id();
/* Getting Job Taxonomies Details */ 
$job_type        		   =      wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
$job_type	     		   =	  isset( $job_type[0] ) ? $job_type[0] : '';
$job_qualifications        =      wp_get_post_terms($job_id, 'job_qualifications', array("fields" => "ids"));
$job_qualifications	       =	  isset( $job_qualifications[0] ) ? $job_qualifications[0] : '';
$job_level        		   =      wp_get_post_terms($job_id, 'job_level', array("fields" => "ids"));
$job_level	               =	  isset( $job_level[0] ) ? $job_level[0] : '';
$job_salary       		   = 	  wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
$job_salary	      		   =	  isset( $job_salary[0] ) ? $job_salary[0] : '';
$job_salary_type           =      wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
$job_salary_type	       =	  isset( $job_salary_type[0] ) ? $job_salary_type[0] : '';
$job_experience   		   =      wp_get_post_terms($job_id, 'job_experience', array("fields" => "ids"));
$job_experience	  		   =	  isset( $job_experience[0] ) ? $job_experience[0] : '';
$job_currency              =      wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
$job_currency	           =	  isset( $job_currency[0] ) ? $job_currency[0] : '';
$job_shift                 =      wp_get_post_terms($job_id, 'job_shift', array("fields" => "ids"));
$job_shift	               =	  isset( $job_shift[0] ) ? $job_shift[0] : '';
/* Getting Job Meta Details */ 
$job_deadline    =     get_post_meta($job_id, '_job_date', true);
$ad_mapLocation	 =     get_post_meta($job_id, '_job_address', true);
$ad_map_lat	     =     get_post_meta($job_id, '_job_lat', true);
$ad_map_long	 =     get_post_meta($job_id, '_job_long', true);
$job_phone	     =     get_post_meta($job_id, '_job_phone', true);
$job_vacancy	 =     get_post_meta($job_id, '_job_posts', true);
$cats	         =	   nokri_get_ad_cats ( $job_id, 'ID' );
$post_date       =     get_the_date(' M j ,Y' );
/* Getting User Company Default Values*/ 
$post_author_id     =  get_post_field( 'post_author', $job_id );
$web 		        =  get_user_meta($post_author_id, '_emp_web', true);
$company_name       =  get_the_author_meta( 'display_name', $post_author_id ); 
/* Getting Profile Photo */
$image_link[0] =  get_template_directory_uri(). '/images/candidate-dp.jpg';
if( isset( $nokri['nokri_user_dp']['url'] ) && $nokri['nokri_user_dp']['url'] != "" )
{
	$image_link = array($nokri['nokri_user_dp']['url']);	
}
if( get_user_meta($post_author_id, '_sb_user_pic', true ) != "" )
{
	$attach_id  =	get_user_meta($post_author_id, '_sb_user_pic', true );
	$image_link =   wp_get_attachment_image_src( $attach_id, 'nokri_job_post_single' );
}
/* Getting Job Skills  */
$job_skills      = array();
$job_skills      =  get_post_meta($job_id, '_job_skills', true);
$skill_tags      =  '';
if(is_array($job_skills))
 {
	$taxonomies = get_terms('job_skills', array('hide_empty' => false , 'orderby'=> 'id', 'order' => 'ASC' ,  'parent'   => 0  ));
	if(count($taxonomies) > 0)
	   {
		 foreach($taxonomies as $taxonomy)
				{
					if (in_array( $taxonomy->term_id, $job_skills ))
					$skill_tags .= " ".esc_html($taxonomy->name)." ".',';
				}
	  }
}
/* Advertisment*/
$advertisement = isset( $nokri['single_banner'] )  ?    $nokri['single_banner']     :   '';
$opening_text  = esc_html__('opening', 'nokri' );
if($job_vacancy > 1)
{
	$opening_text = esc_html__('openings', 'nokri' );
}
?>
<div class="col-md-4 col-sm-12 col-xs-12 col-md-push-8">
   <div class="job-detail-widget">
      <h4><?php echo esc_html__('Job Details', 'nokri' ); ?></h4>
      <ul>
         <li>
            <?php echo esc_html__('Job Experience :', 'nokri' )." "; ?> <strong><?php echo nokri_job_post_single_taxonomies('job_experience', $job_experience); ?></strong>
         </li>
         <li>
            <?php echo esc_html__('Job Level :', 'nokri' )." "; ?> <strong><?php echo nokri_job_post_single_taxonomies('job_level', $job_level); ?></strong>
         </li>
         <li>
            <?php echo esc_html__('Job Type :', 'nokri' ). " "; ?> <strong><?php echo nokri_job_post_single_taxonomies('job_type', $job_type); ?></strong>
         </li>
         <li>
            <?php echo esc_html__('Job Shift :', 'nokri' ). " "; ?> <strong><?php echo nokri_job_post_single_taxonomies('job_shift', $job_shift); ?></strong>
         </li>
         <li>
            <?php echo esc_html__('Job Qualifications : ', 'nokri' ); ?><strong><?php echo nokri_job_post_single_taxonomies('job_qualifications', $job_qualifications); ?></strong>
         </li>
         <li>
            <?php echo esc_html__('Job Salary :', 'nokri' ); ?> <strong><?php echo nokri_job_post_single_taxonomies('job_currency', $job_currency)." ".nokri_job_post_single_taxonomies('job_salary', $job_salary)."/".nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type); ?></strong>
         </li>
         <li>
            <?php echo esc_html__('Posted On : ', 'nokri' ); ?><strong><?php echo esc_html($post_date); ?></strong>
         </li>
         <li>
            <?php echo esc_html__('No. of Openings :', 'nokri' )." "; ?><strong><?php echo esc_html($job_vacancy)." "; ?><?php echo esc_html($opening_text); ?></strong>
         </li>
         <li>
            <?php echo esc_html__('Job Skills :', 'nokri' )." "; ?> <strong><?php echo  rtrim($skill_tags, ','); ?></strong>
         </li>
         <li>
            <?php echo esc_html(get_post_meta( $job_id, '_job_address', true )); ?>
         </li>
      </ul>
   </div>
   <div class="contact-box hidden-xs hidden-sm">
      <div class="contact-img">
         <img src="<?php echo esc_url($image_link[0]); ?>" class="img-responsive" alt="<?php echo esc_attr__('company profile image', 'nokri' ); ?>">
      </div>
      <div class="contact-caption">
         <h4>
            <a href="<?php echo esc_url(get_author_posts_url($post_author_id));?>">
               <?php echo esc_html($company_name); ?></a>
         </h4>
      </div>
      <ul class="social-links list-inline">
      <li> <a href="<?php echo get_user_meta( $post_author_id, '_emp_fb',true); ?>"><img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/006-facebook.png" alt="<?php echo esc_attr__( 'icon', 'nokri' ); ?>"></a></li>
      <li> <a href="<?php echo get_user_meta( $post_author_id, '_emp_twitter',true); ?>"><img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/004-twitter.png" alt="<?php echo esc_attr__( 'icon', 'nokri' ); ?>"></a></li>
      <li> <a href="<?php echo get_user_meta( $post_author_id, '_emp_google',true); ?>"><img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/003-google-plus.png" alt="<?php echo esc_attr__( 'icon', 'nokri' ); ?>"></a></li>
      <li> <a href="<?php echo get_user_meta( $post_author_id, '_emp_linked',true); ?>"><img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/005-linkedin.png" alt="<?php echo esc_attr__( 'icon', 'nokri' ); ?>"></a></li>
      </ul>
      <?php
	  	if(get_user_meta( $user_id, '_sb_reg_type',true) == 0)
		{
         $comp_follow = get_user_meta( $user_id, '_cand_follow_company_'.$post_author_id,true);
         if ( $comp_follow ) {  ?>
      <a   class="btn btn-custom"><?php echo esc_html__('Followed', 'nokri' ); ?></a>
      <?php } else { ?>
      <a  data-value="<?php echo esc_attr( $post_author_id );?>" id="follow_company" class="btn btn-custom"><?php echo esc_html__('Follow', 'nokri' ); ?></a>
      <?php } }  ?>
   </div>
   <div class="single-job-map">
      <div id="map-contact">
         <!--Displaying User Seted Location On Map -->
         <div id="itemMap" style="height: 200px;"></div>
         <input type="hidden" id="lat" value="<?php echo esc_attr($ad_map_lat); ?>" />
         <input type="hidden" id="lon" value="<?php echo esc_attr($ad_map_long); ?>" />
         <!-- End Location On Map -->
      </div>
   </div>
   <?php if($advertisement != '') { ?>
   <div class="job-detail-widget hidden-xs hidden-sm">
   <?php echo ("".$advertisement); ?>
   </div>
    <?php } ?>
</div>