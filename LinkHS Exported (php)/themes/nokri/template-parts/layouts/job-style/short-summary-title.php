<?php global $nokri;
$job_deadline = $job_type = $job_level = $job_shift = $job_experience = $job_skills = $job_salary = $job_qualifications = $job_currency = $ad_mapLocation = $ad_map_lat  = $post_apply_status =  $ad_map_long = $job_phone = $cats = $project = $web = $company_name = $single_job_badges  = $box_class  = '';
$job_id	=	get_the_ID();
 nokri_display_adLocation($job_id);
$current_user    =  wp_get_current_user();
$user_id         =  get_current_user_id();
$post_author_id  = get_post_field( 'post_author', $job_id );
$resume_exist    =  get_post_meta( $job_id, '_job_applied_status_'.$user_id,true);
$job_categories  =  wp_get_object_terms( $job_id,  array('job_category'), array('orderby' => 'term_group') );
/* Getting Job Details */ 
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
$ad_mapLocation	 =     get_post_meta($job_id, '_job_address', true);
$ad_map_lat	     =     get_post_meta($job_id, '_job_lat', true);
$ad_map_long	 =     get_post_meta($job_id, '_job_long', true);
$job_phone	     =     get_post_meta($job_id, '_job_phone', true);
$job_vacancy	 =     get_post_meta($job_id, '_job_posts', true);
$cats	         =	   nokri_get_ad_cats ( $job_id, 'ID' );
$post_date       =     get_the_date(' M j ,Y' ); 
/* Calling Funtion Job Class For Badges */ 
$single_job_badges	=	nokri_job_class_badg($job_id);
$job_badge_text     =   '';
if( count((array)  $single_job_badges ) > 0) 
{	
	foreach( $single_job_badges as $job_badge => $val )
		{
			$term_vals =  get_term_meta($val);
			$bg_color  =  get_term_meta( $val, '_job_class_term_color_bg', true );
			 $color    =  get_term_meta( $val, '_job_class_term_color', true );
			
			$style_color = '';
			if($color != "" )
			{
				$style_color = 'style=" background-color: '.$bg_color.' !important; color: '.$color.' !important;"';
			}
			$job_badge_text .= '<li><a href="'.get_the_permalink($nokri['sb_search_page']).'?job_class='.$val.'" class="job-class-tags-anchor" '.$style_color.'><span>'.esc_html(ucfirst($job_badge)).'</span></a></li>';
		}  
}
/* Selecting Single Job Style  */ 
$style = $nokri['job_post_style'];
if( isset($style) && $style == 'style2'  )
{
	$single_class = 'single-job-section single-job-section-2';	
}
else if (isset($style) && $style == 'style3')
{
	$single_class =	'single-job-section-2  job-single-style-white';
}
else if (isset($style) && $style == 'style1')
{
	$single_class =	'single-job-section single-job-section-2';
	$box_class    =	'job-single-style';
}
/* Setting job Expiration */
$job_deadline_n     =  get_post_meta($job_id, '_job_date', true);
$job_deadline       =  date_i18n(get_option('date_format'), strtotime($job_deadline_n));
$today              =  date("m/d/Y");
$expiry_date_string =  strtotime($job_deadline_n);
$today_string 		=  strtotime($today);

if($today_string > $expiry_date_string)
{
	update_post_meta($job_id, '_job_status', 'inactive');
}
/* Getting job Aplly Expiration Status */
 $post_apply_status = get_post_meta($job_id, '_job_status', true);
 ?>
 <section class="<?php echo esc_attr($single_class);?>">
   <div class="container">
      <div class="row">
      <div class="<?php echo esc_attr($box_class);?>">
       <?php if(get_post_status( $job_id ) == 'pending') { ?>
       <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="alert alert-info alert-dismissable alert-style-1">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="ti-info-alt"></i><?php echo esc_html__( 'Your job is awaiting admin approval', 'nokri' ); ?> 
                </div>
                </div>
                <?php } ?>
      <?php
	  if((isset($nokri['main_header_style'])) && $nokri['main_header_style']  != '2' && $nokri['main_header_style']  != '4'  ){?>
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="single-job-detail-box">
               <div class="row">
                  <div class="col-md-7 col-sm-12 col-xs-12">
                     <div class="job-detail-2">
                        <h2><?php the_title(); ?></h2>
                        <div class="job-detail-meta">
                           <ul>
                              <li><i class="fa fa-location-arrow"></i><?php echo nokri_job_country($job_id,''); ?></li>
                              <li><i class="fa fa-clock-o"></i><?php echo nokri_job_post_single_taxonomies('job_type', $job_type); ?></li>
                              <li><i class="fa fa-calendar-o"></i><?php echo esc_html__( 'Deadline:', 'nokri' ); ?><strong> <?php echo esc_html($job_deadline); ?></strong></li>
                           </ul>
                        </div>
                        <ul class="job-class-tags-2">
						 		<?php echo "".($job_badge_text); ?>
                          </ul>
                     </div>
                  </div>
                  <?php 
				  /* Author Check */
				  if ($user_id == $post_author_id ) { ?>
                  <div class="col-md-5 col-sm-12 col-xs-12">
                     <div class="apply-job">
                     <a class="btn btn-theme" href="<?php echo get_the_permalink( $nokri['sb_post_ad_page'] ); ?>?id=<?php echo esc_attr( $job_id );  ?>" > <i class="ti-pencil-alt"></i><?php echo " ".esc_html__( 'Edit Job', 'nokri' ); ?></a>
                     </div>
                  </div>
                  <?php } 
				  /* Employer Check */
				  if(get_user_meta($user_id, '_sb_reg_type', true) == 0) 
				  {
					 	if($post_apply_status == 'active')
 						{ 
					   ?>
                      <div class="col-md-5 col-sm-12 col-xs-12">
                         <div class="apply-job">
                            <a href="javascript:void(0)" class="btn btn-theme apply_job" data-job-id="<?php echo esc_attr( $job_id );?>" data-toggle="modal" data-target="#myModal"><?php echo esc_html__( 'Apply Now', 'nokri' ); ?></a>
                            
                             <?php
							/* Linkedin key*/
$linkedin_api_key = '';
if((isset($nokri['linkedin_api_key'])) && $nokri['linkedin_api_key']  != '' && (isset($nokri['linkedin_api_secret'])) && $nokri['linkedin_api_secret']  != '' && (isset($nokri['redirect_uri'])) && $nokri['redirect_uri']  != '' )
{
	$linkedin_api_key =  ($nokri['linkedin_api_key']);
	$linkedin_secret_key =  ($nokri['linkedin_api_secret']);
	$redirect_uri =  ($nokri['redirect_uri']);
									$state = 'not_logged_in-' . $job_id;
									if(is_user_logged_in())
									{
										$state = 'logged_in-' . $job_id;
									}
									
echo '<a href="https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id='.$linkedin_api_key.'&redirect_uri='.$redirect_uri.'&state='.esc_attr($state).'&scope=r_emailaddress r_basicprofile" class="btn btn-theme bookmark">'.esc_html__( 'Apply With LinkedIn', 'nokri' ).'</a>'; 
}
?>
                            
 
                            <?php  $job_bookmark = get_post_meta( $job_id, '_job_saved_value_'.$user_id, true);
                               if ( $job_bookmark == '' ) { ?>
                            <a class="btn btn-success tool-tip save_job" data-value="<?php echo esc_attr( $job_id );?>"  title="<?php echo esc_html__( 'Save Job', 'nokri' ); ?>"> <i class="fa fa-heart"></i></a>
                            <?php } else { ?>
                            <a class="btn btn-success tool-tip saved" disbaled  title="<?php echo esc_html__( 'Already Saved', 'nokri' ); ?>"> <i class="fa fa-heart-o"></i></a>
                            <?php } ?>
                         </div>
                      </div>
                      <?php } else { ?>
			   			<div class="col-md-5 col-sm-12 col-xs-12">
                         <div class="apply-job">
                            <a class="btn btn-theme"><?php echo esc_html__( 'Job Expired', 'nokri' ); ?></a>
                            </div>
                            </div>
			 		  <?php  }  } ?>   
               </div>
            </div>
         </div>
         <?php } ?>
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
               <?php echo get_template_part( 'template-parts/layouts/job-style/job','sidebar'); ?>
               <div class="col-md-8 col-sm-12 col-xs-12 col-md-pull-4">
                  <div class="single-job-detail">
                     <h4><?php echo esc_html__('Job Description', 'nokri' ); ?></h4>
                     <?php echo get_the_content(); ?>
                  </div>
               </div>
               <div class="col-md-8 col-sm-12 col-xs-12 col-md-pull-4">
               		<?php echo get_template_part( 'template-parts/layouts/job-style/related','jobs'); ?>
               </div>
            </div>
         </div>
       </div>
      </div>
   </div>
   <input type="hidden" id="is_apply" value="<?php echo esc_attr($job_id); ?>" />
</section>