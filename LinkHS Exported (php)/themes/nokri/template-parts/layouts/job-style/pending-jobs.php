<?php
global $nokri;
$job_id	       =	 get_the_ID();
$user_id       =     get_current_user_id();
$job_type      =     wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
$job_type	   =     isset( $job_type[0] ) ? $job_type[0] : '';
$job_salary    =     wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
$job_salary	   =     isset( $job_salary[0] ) ? $job_salary[0] : '';
$company_name  =     get_user_meta($user_id, '_emp_name', true);
$job_expiry    =     get_post_meta($job_id, '_job_date', true);
$job_status    =     get_post_meta($job_id, '_job_status', true);
$job_ap_status =     get_post_status( $job_id);
if ($job_ap_status == 'pending')
{
	$job_ap_status = esc_html__('pending', 'nokri' );
}
$staus_clr     =     'warning';
if ($job_ap_status == 'publish')
{
	$staus_clr = 'success';
}
$resume_counts =  nokri_get_resume_count($job_id);
/* Getting Company  Profile Photo */ 
if( get_user_meta($user_id, '_sb_user_pic', true ) != "" )
{
	$attach_id =	get_user_meta($user_id, '_sb_user_pic', true );
	$image_link = wp_get_attachment_image_src( $attach_id, 'nokri_job_post_single' );
}

/* Calling Funtion Job Class For Badges */ 
$single_job_badges	=	nokri_job_class_badg($job_id);
$job_badge_text     =   '';
if( count((array)$single_job_badges ) > 0) 
{	
	foreach( $single_job_badges as $job_badge => $val )
		{
			$job_badge_text .= '<a href="javascript:void(0)">'.esc_html(ucfirst($job_badge)).'</a>';
		}
}
$link      = nokri_set_url_param(get_the_permalink($nokri['sb_post_ad_page']), 'id', esc_attr( $job_id ));
$final_url = esc_url(nokri_page_lang_url_callback($link));
?>
<div class="cp-loader"></div>
<div class="posted-job-list" id="all-jobs-list-box2-<?php echo esc_attr($job_id); ?>">
    <ul class="list-inline">
        <li class="posted-job-title"> 
            <a href="<?php echo get_the_permalink($job_id); ?>"><?php echo get_the_title(); ?></a>
            <p><strong><?php echo esc_html__( 'Posted Date', 'nokri' ); ?>: </strong><?php echo get_the_date(); ?></p>
            <div class="job-class"> 
               <?php echo "".$job_badge_text ?>
            </div>
        </li>
        <li class="posted-job-status"><span class="label label-<?php echo esc_attr( $staus_clr); ?>"><?php echo esc_html( $job_ap_status); ?></span></li>
        <li class="posted-job-applicants"><?php echo esc_attr($resume_counts); ?></li>
        <li class="posted-job-expiration"><?php echo date_i18n(get_option('date_format'), strtotime($job_expiry)); ?></li>
        <li class="posted-job-action"> 
            <ul class="list-inline">
                <li class="tool-tip" title="<?php echo esc_html__( 'Edit Job', 'nokri' ); ?>"><a href="<?php echo ''.$final_url;  ?>" class="label label-info"> <i class="ti-pencil-alt"></i></a></li>
                <li class="tool-tip" title="<?php echo esc_html__( 'Delete Job', 'nokri' ); ?>"><a href="javascript:void(0)" data-value="<?php echo esc_attr( $job_id );?>" class="label label-danger del_my_job"><i class="ti-trash"></i></a></li>
            </ul>
        </li>
        
    </ul>
</div>