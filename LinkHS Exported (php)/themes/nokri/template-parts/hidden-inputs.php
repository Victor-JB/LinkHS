<?php
global $nokri;
/* Add */
 if((isset($nokri['add-postition'])) && $nokri['add-postition']  == '2' )
    {
	 echo ''.($nokri['add-code']);
 	}
/* Redirect Page */
 $dashboard_page = '';
 if((isset($nokri['sb_dashboard_page'])) && $nokri['sb_dashboard_page']  != '' )
    {
	 $dashboard_page =  ($nokri['sb_dashboard_page']);
 	}
/* Saving Default Longitiutde and latitude values*/
$ad_map_lat = '';
if((isset($nokri['sb_default_lat'])) && $nokri['sb_default_lat']  != '' ?  $nokri['sb_default_lat'] : '40.7127837')
{
	$ad_map_lat =  ($nokri['sb_default_lat']);
}
$ad_map_long = '';
if((isset($nokri['sb_default_long'])) && $nokri['sb_default_long']  != '' ? $nokri['sb_default_long'] :'-74.00594130000002' )
{
	$ad_map_long =  ($nokri['sb_default_long']);
}
		
/* Getting Api  values*/	
$fb_api_key = '';
if((isset($nokri['fb_api_key'])) && $nokri['fb_api_key']  != '' )
{
	$fb_api_key =  ($nokri['fb_api_key']);
}

$gmail_api_key = '';
if((isset($nokri['gmail_api_key'])) && $nokri['gmail_api_key']  != '' )
{
	$gmail_api_key =  ($nokri['gmail_api_key']);
}


$linkedin_api_key = '';
if((isset($nokri['linkedin_api_key'])) && $nokri['linkedin_api_key']  != '' )
{
	$linkedin_api_key =  ($nokri['linkedin_api_key']);
}

$linkedin_secret_key = '';
if((isset($nokri['linkedin_api_secret'])) && $nokri['linkedin_api_secret']  != '' )
{
	$linkedin_secret_key =  ($nokri['linkedin_api_secret']);
}

$redirect_uri = '';
if((isset($nokri['redirect_uri'])) && $nokri['redirect_uri']  != '' )
{
	$redirect_uri =  ($nokri['redirect_uri']);
}	

$email_user = '';
if(isset( $nokri['sb_new_user_email_verification'] ))
{
	 $email_user = $nokri['sb_new_user_email_verification'];
}
/* Google map key */
$is_gmap =  '';
if( isset( $nokri['gmap_api_key'] ) && $nokri['gmap_api_key'] != ""  )
{
	$is_gmap =  '1';
}
$ad_map_lat_job = $ad_map_long_job = '';
if( isset( $_GET['id'] ) && 'page-job-post.php' == basename( get_page_template() ) )
{
	$ad_map_lat_job	 	= get_post_meta($_GET['id'], '_job_lat', true);
	$ad_map_long_job	= get_post_meta($_GET['id'], '_job_long', true);
}



$allow_map = isset($nokri['nokri_allow_map']) ? $nokri['nokri_allow_map'] : true;

$lat = ( $ad_map_lat_job != "" && $ad_map_long_job != ""  ) ? $ad_map_lat_job : $ad_map_lat;
$lon = ( $ad_map_lat_job != "" && $ad_map_long_job != ""  ) ? $ad_map_long_job : $ad_map_long;

/* Sticky menu */
$is_sticky_menu = isset($nokri['is_sticky_menu']) ? $nokri['is_sticky_menu']  : false;
if($is_sticky_menu)
{
   $is_sticky_menu = true; 
}
/* admin post message */
$admin_message = isset($nokri['job_post_for_admin_message']) ? $nokri['job_post_for_admin_message']  : esc_html__( 'Only admin can post jobs', 'nokri' );
?>
<input type="hidden" id="latoz" value="<?php echo esc_attr($lat); ?>" />
<input type="hidden" id="langoz" value="<?php echo esc_attr($lon); ?>" />
<input type="hidden" id="nokri_ajax_url" value="<?php echo admin_url( 'admin-ajax.php' ); ?>" />
<input type="hidden" id="profile_page" value="<?php echo get_the_permalink( $dashboard_page ); ?>" />
<input type="hidden" id="dashboard_page" value="<?php echo get_the_permalink( $dashboard_page ); ?>" />
<input type="hidden" id="nokri_forgot_msg" value="<?php echo esc_html__( 'Reset link has been sent on your email.', 'nokri' ); ?>" />
<input type="hidden" id="nokri_emp_profile_save" value="<?php echo esc_html__( 'Saved successfully', 'nokri' ); ?>" />
<input type="hidden" id="nokri_dp_save" value="<?php echo esc_html__( 'Profile picture updated successfully ', 'nokri' ); ?>" />
<input type="hidden" id="nokri_cover_save" value="<?php echo esc_html__( 'Cover picture updated successfully ', 'nokri' ); ?>" />
<input type="hidden" id="nokri_emp_job_post" value="<?php echo esc_html__( 'Job posted successfully ', 'nokri' ); ?>" />
<input type="hidden" id="job_post_error" value="<?php echo esc_html__( 'Please login first', 'nokri' ); ?>" />
<input type="hidden" id="job_aplly_error" value="<?php echo esc_html__( 'Sorry...! your are not elgible for job', 'nokri' ); ?>" />
<input type="hidden" id="job_cv_action" value="<?php echo esc_html__( 'Action saved Successfully', 'nokri' ); ?>" />
<input type="hidden" id="job_cv_action_fail" value="<?php echo esc_html__( 'Action failed', 'nokri' ); ?>" />
<input type="hidden" id="superadmin" value="<?php echo esc_html__( 'Admin account can not delete from here', 'nokri' ); ?>" />
<input type="hidden" id="facebook_key" value="<?php echo esc_attr($fb_api_key); ?>" />
<input type="hidden" id="google_key" value="<?php echo esc_attr($gmail_api_key); ?>" />
<input type="hidden" id="linked_in_key" value="<?php echo esc_attr($linkedin_api_key); ?>" />
<input type="hidden" id="linked_in_secret" value="<?php echo esc_attr($linkedin_secret_key); ?>" />
<input type="hidden" id="redirect_uri" value="<?php echo esc_url( $redirect_uri ); ?>" /> 
<input type="hidden" id="not_log_in" value="<?php echo esc_html__( 'Please login first', 'nokri' ); ?>" />
<input type="hidden" id="not_cand" value="<?php echo esc_html__( 'Candidates can perform this', 'nokri' ); ?>" />
<input type="hidden" id="not_emp" value="<?php echo esc_html__( 'Employers can perform this', 'nokri' ); ?>" />
<input type="hidden" id="saved_job" value="<?php echo esc_html__( 'Already saved.', 'nokri' ); ?>" />
<input type="hidden" id="saved_job_success" value="<?php echo esc_html__( 'Job saved successfully', 'nokri' ); ?>" />
<input type="hidden" id="chimp_mail_valid" value="<?php echo esc_html__( 'Email not valid', 'nokri' ); ?>" />
<input type="hidden" id="chimp_success" value="<?php echo esc_html__( 'Thanks for subscription', 'nokri' ); ?>" />
<input type="hidden" id="comp_folow_success" value="<?php echo esc_html__( 'Company followed successfully', 'nokri' ); ?>" />
<input type="hidden" id="resume_save_success" value="<?php echo esc_html__( 'Resume Uploaded Successfully', 'nokri' ); ?>" />
<input type="hidden" id="emp_resume_save" value="<?php echo esc_html__( 'Resume Saved Successfully', 'nokri' ); ?>" />
<input type="hidden" id="already_resume_saved" value="<?php echo esc_html__( 'Already saved', 'nokri' ); ?>" />
<input type="hidden" id="is_email_on" value="<?php echo ''.($email_user); ?>" />
<input type="hidden" id="old_password_miss" value="<?php echo esc_html__( 'Enter old password', 'nokri' ); ?>" />
<input type="hidden" id="new_password" value="<?php echo esc_html__( 'Enter new password', 'nokri' ); ?>" />
<input type="hidden" id="old_password" value="<?php echo esc_html__( 'Invalid old password', 'nokri' ); ?>" />
<input type="hidden" id="set_password" value="<?php echo esc_html__( 'Password updated', 'nokri' ); ?>" />
<input type="hidden" id="contact_sent" value="<?php echo esc_html__( 'Message sent', 'nokri' ); ?>" />
<input type="hidden" id="demo_mode" value="<?php echo esc_html__( 'Edit in demo user not allowed', 'nokri' ); ?>" />
<input type="hidden" id="del_msg" value="<?php echo esc_html__( 'Deleted successfully', 'nokri' ); ?>" />
<input type="hidden" id="is_sticky_menu" value="<?php echo ''.($is_sticky_menu ); ?>" />
<input type="hidden" id="is_gmap" value="<?php echo ''.($is_gmap); ?>" />
<input type="hidden" id="validate_vid" value="<?php echo esc_html__( 'Invalid video resume link', 'nokri' ); ?>" />
<input type="hidden" id="upload_doc" value="<?php echo esc_html__( 'Please upload resume', 'nokri' ); ?>" />
<input type="hidden" id="email_exist" value="<?php echo esc_html__( 'Email already exists, please login to apply', 'nokri' ); ?>" />
<input type="hidden" id="some_wrong" value="<?php echo esc_html__( 'Email not sent', 'nokri' ); ?>" />
<input type="hidden" id="add_skills_value" value="<?php echo esc_html__( 'Set Your Skills Percentage', 'nokri' ); ?>" />
<input type="hidden" id="cand_pkg_expire" value="<?php echo esc_html__( 'Package Expired', 'nokri' ); ?>" /> 
<input type="hidden" id="only_admin" value="<?php echo ''.$admin_message; ?>" />