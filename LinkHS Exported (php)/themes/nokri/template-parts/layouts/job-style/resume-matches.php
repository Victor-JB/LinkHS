<?php
global $nokri;
$job_id	       			   =	  get_the_ID();
$user_id       			   =      get_current_user_id();
$job_type        		   =      wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
$job_type	     		   =	  isset( $job_type[0] ) ? $job_type[0] : '';
$job_salary       		   = 	  wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
$job_salary	      		   =	  isset( $job_salary[0] ) ? $job_salary[0] : '';
$job_salary_type           =      wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
$job_salary_type	       =	  isset( $job_salary_type[0] ) ? $job_salary_type[0] : '';
$job_currency              =      wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
$job_currency	           =	  isset( $job_currency[0] ) ? $job_currency[0] : '';
$company_name  			   =      get_user_meta($user_id, '_emp_name', true);
$job_expiry                =      get_post_meta($job_id, '_job_date', true);
$job_status                =      get_post_meta($job_id, '_job_status', true);
if($job_status == 'inactive')
{
	$job_status            =      esc_html__('inactive', 'nokri' );
}
/* Expiry Date */ 
$package_date  =    get_user_meta( $user_id, '_sb_expire_ads', true );
$today         =    date("Y-m-d");
$take_action   =    true;
$expiry_date_string =  strtotime($package_date);
$today_string 		=  strtotime($today);
if($today_string > $expiry_date_string)
{
	$take_action = false;
}
$job_ap_status =     $job_status;
$staus_clr     =     'warning';
if ($job_status == 'active')
{
	$job_ap_status  =     esc_html__('active', 'nokri' );
	$staus_clr      =     'success';
}
$resume_counts =  nokri_get_resume_count($job_id);
/* Getting Company  Profile Photo */ 
if( get_user_meta($user_id, '_sb_user_pic', true ) != "" )
{
	$attach_id   =	get_user_meta($user_id, '_sb_user_pic', true );
	$image_link  = wp_get_attachment_image_src( $attach_id, 'nokri_job_post_single' );
}

/* Calling Funtion Job Class For Badges */ 
$single_job_badges	=	nokri_job_class_badg($job_id);
$job_badge_text     =   $premium_txt = '';
if( count( $single_job_badges ) > 0) 
{	
	foreach( $single_job_badges as $job_badge => $val )
		{
			$job_badge_text .= '<a href="#">'.esc_html(ucfirst($job_badge)).'</a>';
		}
		if(!empty($job_badge_text))
		{
			$premium_txt = '<div class="job-class">'.$job_badge_text.'</div>';
		}
}
/* Dashboard Page */
$dashboard_id = '';
if((isset($nokri['sb_dashboard_page'])) && $nokri['sb_dashboard_page']  != '' )
{
 	$dashboard_id =  ($nokri['sb_dashboard_page']);
}
$myurl     =   get_the_permalink($dashboard_id);
$final_url =   esc_url(nokri_set_url_params_multi($myurl,'tab-data','match-list','id',esc_attr( $job_id)));
?>
<tr>
    <td><a class= "job-title" href="<?php echo get_the_permalink($job_id); ?>"><?php the_title(); ?></a>
<p><strong><?php echo esc_html__( 'Posted Date', 'nokri' ); ?>: </strong><?php echo get_the_date(); ?></p>
<?php echo "".$premium_txt; ?>
    </td>
    <td> 
     <span class="label label-<?php echo esc_attr( $staus_clr); ?>"><?php echo esc_html( $job_ap_status); ?></span>
    </td>
    <td> 
     <?php echo date_i18n(get_option('date_format'), strtotime($job_expiry)); ?>
    </td>
    <td> 
    	<a href="<?php echo ''.$final_url; ?>" class="btn n-btn-custom btn-small"><?php echo esc_html__( 'View Resumes', 'nokri' ); ?></a>
	</td>
</tr>