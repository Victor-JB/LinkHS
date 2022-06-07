<?php
global $nokri; 
$current_id   =  get_current_user_id();
$company_name = '';
if(isset($_GET['comp_title']))
{
	$company_name =  $_GET['comp_title'];
}
$order = 'DESC';
if(isset($_GET['comp_order']))
 {
     $order 		  =  $_GET['comp_order'];
 }
 ?>
 <div class="dashboard-job-filters">
    <div class="row">
      <form role="search"  id="company_form" method="get" class="searchform">
        <div class="col-md-6 col-xs-12 col-sm-6">
        <input type="hidden" name="candidate-page" value="followed-companies" >
            <div class="form-group">
                <label ><?php echo esc_html__('Name', 'nokri' ); ?></label>
                <input type="text" name="comp_title" value="<?php echo esc_html($company_name); ?>"  class="form-control" placeholder="<?php echo esc_html__('Keyword or Name', 'nokri' ); ?>">
                 <a href="javascript:void(0)" class="a-btn search_company"><i class="ti-search"></i></a>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="form-group">
                <label><?php echo esc_html__('Sort by', 'nokri' ); ?> </label>
                <select class="select-generat form-control search_company" name="comp_order">
                    <option>&nbsp;</option>
                    <option value="ASC" <?php if ( $order == 'ASC') { echo "selected"; } ; ?>><?php echo esc_html__('ASC', 'nokri' ); ?></option>
                    <option value="DESC" <?php if ( $order == 'DESC') { echo "selected"; } ; ?>><?php echo esc_html__('DESC', 'nokri' ); ?></option>
                </select>
            </div>
        </div>
        <?php echo nokri_form_lang_field_callback(true); ?>
        </form>
    </div>
</div>
 <div class="main-body">
<div class="dashboard-job-stats followers">
    <h4><?php echo esc_html__('Followed Companies', 'nokri' ); ?></h4>
    <div class="dashboard-posted-jobs">
        <div class="posted-job-list resume-on-jobs header-title">
            <ul class="list-inline">
                <li class="resume-id"><?php echo esc_html__('#', 'nokri' ); ?></li>
                <li class="posted-job-title"><?php echo esc_html__('Company Name', 'nokri' ); ?></li>
                <li class="posted-job-expiration"><?php echo esc_html__('Open Positions', 'nokri' ); ?></li>
                <li class="posted-job-action"><?php echo esc_html__('Action', 'nokri' ); ?></li>
                
            </ul>
        </div>
<div class="cp-loader"></div>
 <?php
 $get_result      =  nokri_following_company_ids($current_id);
if(count( (array) $get_result) != 0)
 {
// total no of User to display
$limit = isset( $nokri['user_pagination'] )         ?    $nokri['user_pagination']     :   5;
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$offset = ($page * $limit) - $limit;	 
	 
 $args            =  array(
'search'         => "*".esc_attr( $company_name )."*",
'order'          => $order, 
'include'        => $get_result,
 'number'	     => $limit,
 'offset'	     => $offset,
'search_columns' => array('display_name',),
				   );
$users           =   new WP_User_Query( $args );
$cand_followings =   $users->get_results();
$pages_number = ceil($users->get_total()/$limit);
$count = 1;
foreach ( $cand_followings as $key => $object ) 
 {
   $company_id	  =	$object->ID;
/* Getting Company  Profile Photo  */
$image_link[0] =  get_template_directory_uri(). '/images/candidate-dp.jpg';
if( isset( $nokri['nokri_user_dp']['url'] ) && $nokri['nokri_user_dp']['url'] != "" )
{
	$image_link = array($nokri['nokri_user_dp']['url']);	
}
if( get_user_meta($company_id, '_sb_user_pic', true ) != "" )
{
	$attach_id =	get_user_meta($company_id, '_sb_user_pic', true );
	$image_link = wp_get_attachment_image_src( $attach_id, 'nokri_job_post_single' );
}
$company_tot_jobs  = ( count_user_posts( $company_id , 'job_post' ) );	 
 ?>
 <div class="posted-job-list resume-on-jobs" id="company-box-<?php echo esc_attr($company_id);?>">
    <ul class="list-inline">
        <li class="resume-id"><?php echo esc_attr($count); ?></li>
        <li class="posted-job-title">
        <?php if (esc_url($image_link[0])) { ?>
            <div class="posted-job-title-img">
                 <a href="<?php echo esc_url(get_author_posts_url($company_id)); ?>"><img src="<?php echo esc_url($image_link[0]); ?>" class="img-responsive img-circle" alt="<?php echo esc_html__('company Image', 'nokri'); ?>"></a>
            </div> 
            <?php } ?> 
            <div class="posted-job-title-meta">
                <a href="<?php echo esc_url(get_author_posts_url($company_id));  ?>"><?php echo the_author_meta( 'display_name', $company_id ); ?> </a>
                <p><?php echo get_user_meta($company_id, '_user_headline', true ); ?></p>
            </div>
        </li>
       <li class="posted-job-expiration"><a href="<?php echo esc_url(get_author_posts_url($company_id));  ?>"><?php echo esc_attr($company_tot_jobs); ?></a> </li>
        <li class="posted-job-action"> 
            <a  data-value="<?php echo esc_attr($company_id);?>" class="btn btn-custom unfollow_comp" ><?php echo esc_html__('Remove', 'nokri'); ?></a>
        </li>
        
    </ul>
</div>
<?php $count++; } ?>
</div>
        <div class="pagination-box clearfix">
            <ul class="pagination">
                <?php echo nokri_user_pagination($pages_number,$page);?> 
            </ul>
        </div>
    </div>
</div>
<?php } else { ?>
<div class="main-body">
<div class="dashboard-posted-jobs">
    <div class="notification-box">
        <div class="notification-box-icon"><span class="ti-info-alt"></span></div>
        <h4><?php echo esc_html__( 'No followed company', 'nokri' ); ?></h4>
    </div>
</div>
</div>
<?php } 


