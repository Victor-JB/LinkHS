<?php 
global $nokri;
$user_id    = get_current_user_id();
$c_name   	= isset($_GET['c_name'])  && $_GET['c_name']  != ""    ?  $_GET['c_name']     :   '';
$c_order   	= isset($_GET['c_order']) && $_GET['c_order'] != ""    ?  $_GET['c_order']    :   '';
$job_id   	= isset($_GET['id'])      && $_GET['id']      != ""    ?  $_GET['id']         :   '';
/* Updating skills values */
nokri_jobs_matches_candidates($job_id);
/* Getting matched resumes candidates ids */
$resumes_array = nokri_get_candidates_ids_for_matched_resumes($job_id);
if(!empty($resumes_array))
{
// total no of User to display
$limit   	= 2 ;//isset( $nokri['user_pagination'] ) ?    $nokri['user_pagination']     :   5;
$page    	= (get_query_var('paged')) ? get_query_var('paged') : 1;
$offset  	= ($page * $limit) - $limit;
$user_query = new WP_User_Query(
 array( 
 'include'  =>  $resumes_array,
 'search'   => "".esc_attr( $c_name )."*",
 'number'	=>  $limit,
 'orderby'  => 'meta_value_num',
 'meta_key' => '_cand_skills_sum', 
 'offset'	=>  $offset,
 'order'    =>  $c_order,
  )  );
$cand_followers = 	$user_query->get_results();
$pages_number   = 	ceil($user_query->get_total()/$limit);
$company_id     = 	$li  =  $follower_id =  '';
?>
<div class="cp-loader"></div>
<div class="dashboard-job-filters">
    <div class="row">
    <form method="GET" id="emp_matched_resumes_form">
    <input type="hidden" name="tab-data" value="match-list" >
    <input type="hidden" name="id" value="<?php echo  esc_attr($job_id); ?>" >
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="form-group">
                <label class=""><?php echo  esc_html__( 'Name', 'nokri' ); ?></label>
                <input type="text" value="<?php echo esc_html($c_name); ?>" <?php if ( $order == 'ASC') { echo "selected"; } ; ?> class="form-control" name="c_name" placeholder="<?php echo  esc_html__( 'Keyword or Name', 'nokri' ); ?>">
                <a href="javascript:void(0);" class="a-btn emp_matched_resumes_form"><i class="ti-search"></i></a>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="form-group">
                <label class=""><?php echo  esc_html__( 'Sort by', 'nokri' ); ?> </label>
                <select class="js-example-basic-single emp_matched_resumes_form" name="c_order">
                    <option value=""><?php echo  esc_html__( 'Select an option', 'nokri' ); ?></option>
                    <option value="ASC" <?php if ( $c_order == 'ASC') { echo "selected"; } ; ?>><?php echo  esc_html__( 'ASC', 'nokri' ); ?></option>
                    <option value="DESC" <?php if ( $c_order == 'DESC') { echo "selected"; } ; ?>><?php echo  esc_html__( 'DESC', 'nokri' ); ?></option>
                </select>
            </div>
        </div>
        <?php echo nokri_form_lang_field_callback(true); ?>
        </form>
    </div>
</div>
<div class="main-body">
<div class="dashboard-job-stats followers">
    <h4><?php echo  esc_html__( 'Matched Candidates', 'nokri' ); ?></h4>
    <div class="dashboard-posted-jobs">
        <div class="posted-job-list resume-on-jobs header-title">
            <ul class="list-inline">
                <li class="posted-job-title"> <?php echo  esc_html__( 'Candidate Name', 'nokri' ); ?></li>
                <li class="posted-job-expiration"> <?php echo  esc_html__('Resume', 'nokri' ); ?></li>
                <li class="posted-job-action"><?php echo  esc_html__( 'Profile', 'nokri' ); ?></li>
            </ul>
        </div>
<?php
if ( isset ($cand_followers) && count($cand_followers) > 0)
{
	$download_btn  =  '';
	$count = 1;
	 foreach ( $cand_followers as $follower ) 
	 {
				$follower_id   = $follower->ID;
				 $download_btn  =  $li = '';
				 /* Getting Followers Profile Photo */
				 $dp            =   nokri_get_user_profile_pic($follower_id,'_cand_dp');
				 $resume_id	    =   nokri_get_resume_publically($follower_id,'id');
				 if($resume_id != '')
				 {
					 $download_btn = '<a class="btn btn-custom update_pkg" href="javascript:void(0)" data-attachId='.esc_attr($resume_id).' data-candId='.esc_attr($follower_id).'><i class="fa fa-download"></i> '.esc_html__( 'Download', 'nokri' ).'</a>';
				 }
				 else
				 {
					 $download_btn = '<a class="btn btn-custom" href="javascript:void(0)">'.esc_html__( 'Not Uploaded', 'nokri' ).'</a>';
				 }
				 $registered    =   date_i18n(get_option('date_format'), strtotime($follower->user_registered));
				 $headline_html =   '';
				 if(get_user_meta($follower_id, '_user_headline', true ) != '')
				 {
					 $headline_html = '<p>'.get_user_meta($follower_id, '_user_headline', true ).'</p>';
				 }
					echo ''.$li .= '<div class="posted-job-list resume-on-jobs" id="company-box-'.esc_attr($follower_id).'">
								<ul class="list-inline">
									<li class="posted-job-title">
										<div class="posted-job-title-img">
											<a href="javascript:void(0)">
												<img src="'.esc_url($dp).'" class="img-responsive" alt="'.esc_html__( 'Image', 'nokri' ).'">
											</a>
										</div>
										<div class="posted-job-title-meta">	<a href="'.esc_url(get_author_posts_url($follower_id)).'">'.$follower->display_name.'</a>
											'.$headline_html.'</div>
									</li>
									<li class="posted-job-expiration ">'.$download_btn.'</li>
									<li class="posted-job-action"><a href="'.esc_url(get_author_posts_url($follower_id)).'" class="btn btn-custom" target="_blank"> '.esc_html__( 'View Profile', 'nokri' ).' </a>
									</li>
								</ul>
							</div>';
							$count++;
		}
					
}
?>  
 </div>
        <div class="pagination-box clearfix">
        <ul class="pagination">
            <?php echo nokri_user_pagination($pages_number,$page);?> 
        </ul>
        </div>
    </div>
</div>
<?php } else { ?>
<div class="dashboard-job-filters">
    <div class="row">
    <form method="GET" id="emp_matched_resumes_form">
    <input type="hidden" name="tab-data" value="match-list" >
    <input type="hidden" name="id" value="<?php echo  esc_attr($job_id); ?>" >
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="form-group">
                <label class=""><?php echo  esc_html__( 'Name', 'nokri' ); ?></label>
                <input type="text" value="<?php echo esc_html($c_name); ?>" <?php if ( $order == 'ASC') { echo "selected"; } ; ?> class="form-control" name="c_name" placeholder="<?php echo  esc_html__( 'Keyword or Name', 'nokri' ); ?>">
                <a href="javascript:void(0);" class="a-btn emp_matched_resumes_form"><i class="ti-search"></i></a>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="form-group">
                <label class=""><?php echo  esc_html__( 'Sort by', 'nokri' ); ?> </label>
                <select class="select-generat emp_matched_resumes_form" name="c_order">
                    <option value=""><?php echo  esc_html__( 'Select an option', 'nokri' ); ?></option>
                    <option value="ASC" <?php if ( $c_order == 'ASC') { echo "selected"; } ; ?>><?php echo  esc_html__( 'ASC', 'nokri' ); ?></option>
                    <option value="DESC" <?php if ( $c_order == 'DESC') { echo "selected"; } ; ?>><?php echo  esc_html__( 'DESC', 'nokri' ); ?></option>
                </select>
            </div>
        </div>
        <?php echo nokri_form_lang_field_callback(true); ?>
        </form>
    </div>
</div>
<div class="main-body">
<div class="dashboard-job-stats followers">
    <div class="notification-box">
        <div class="notification-box-icon"><span class="ti-info-alt"></span></div>
        <h4><?php echo esc_html__( 'No matched resume found', 'nokri' ); ?></h4>
    </div>
</div>
</div>
<?php }