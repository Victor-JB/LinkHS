<?php
global $nokri; 
$user_info =   wp_get_current_user();
$user_id   =   get_current_user_id();
?>
<div class="cp-loader"></div>
   <div class="main-body">
    <div class="dashboard-job-stats dashboard-email-templates">
<?php
/* Getting Email Templates */
$resumes = nokri_get_resumes_list( $user_id );
if( isset( $resumes ) && count($resumes) > 0) {
$resume_table =  '';
$sr_no = '1';
foreach( $resumes as $key => $val )
{
	
	$edit_link  =   esc_url(nokri_set_url_params_multi(get_the_permalink(),'tab-data','email-templates','edit-id',$key));	
	$delet_link =   get_the_permalink()."?tab-data=email-templates-list&del_id=".$key;
	$resume_table .=  '<div class="posted-job-list" id="email_temp_del-'.$key.'">
						<ul class="list-inline">
							<li class="email-template-id">'.esc_attr($sr_no).'</li>
							<li class="posted-job-title"> 
								<a href="javascript:void(0)">'. esc_html($val['name']).'</a>
							</li>
							<li class="posted-job-expiration">'.date_i18n(get_option('date_format'), strtotime($val['date'])).'</li>
							<li class="posted-job-action"> 
								<ul class="list-inline">
									<li class="tool-tip" title="'.esc_html__( 'View/Update', 'nokri' ).'"> <a href="'.esc_url($edit_link).'" class="label label-info"> <i class="ti-pencil-alt"></i></a></li>
									<li class="tool-tip del_email_template" data-tempId="'.esc_attr($key).'"  title="'.esc_html__( 'Delete', 'nokri' ).'"><a href="#" class="label label-danger"> <i class="ti-trash"></i></a></li>
								</ul>
							</li>
						</ul>
					</div>';
	 $sr_no++;
 }
?>
 <h4><?php echo esc_html__( 'All Email Templates', 'nokri' ); ?></h4>
 <div class="dashboard-posted-jobs">
            <div class="posted-job-list header-title">
                <ul class="list-inline">
                    <li class="email-template-id">#</li>
                    <li class="posted-job-title"><?php echo esc_html__( ' Email Template Name', 'nokri' ); ?></li>
                    <li class="posted-job-expiration"> <?php echo esc_html__( 'Created on', 'nokri' ); ?></li>
                    <li class="posted-job-action"> <?php echo esc_html__( 'Action', 'nokri' ); ?></li>
                </ul>
            </div>
             <?php echo "".$resume_table; ?>
        </div>
<?php  }  else { ?>
<div class="dashboard-posted-jobs">
    <div class="notification-box">
        <div class="notification-box-icon"><span class="ti-info-alt"></span></div>
        <h4><?php echo esc_html__( 'No email template found', 'nokri' ); ?></h4>
    </div>
</div>
<?php } ?>
</div>
</div>