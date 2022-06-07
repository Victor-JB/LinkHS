<?php
/* Template Name: Dashboard */ 
get_header();
global $nokri;
echo nokri_check_if_not_logged();
$user_id = get_current_user_id();
if( current_user_can('administrator'))
{
	update_user_meta($user_id, '_sb_reg_type', 1);
}
/*Admin can post */
$admin_post = ( isset($nokri['job_post_for_admin']) && $nokri['job_post_for_admin'] != ""  ) ? $nokri['job_post_for_admin'] : '';
if($admin_post && !current_user_can('administrator') && get_user_meta($user_id, '_sb_reg_type', true) == '' ) {update_user_meta($user_id, '_sb_reg_type', 0); }
if (get_user_meta($user_id, '_sb_reg_type', true) == '')
{ 
	$term_link = '';
	if((isset($nokri['term_condition'])) && $nokri['term_condition']  != '' )
	{
		 $term_link =  ($nokri['term_condition']);
	}
	$bg_url        = nokri_section_bg_url();
?>
<section class="n-pages-breadcrumb social-choose" <?php echo "".($bg_url); ?>>
  	<div class="container">
    	<div class="row">
        </div>
    </div>
  </section>
<section class="n-job-pages-section">
  	<div class="container">
    	<div class="row">
            <form id="social_login_form" >
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="n-job-pages user-section">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2  col-sm-offset-2">
                     	<div class="error-404">
                        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            	<h3><?php echo esc_html__( 'Please Select Your Account Type','nokri' ); ?></h3>
                               
                                <div class="btn-group" id="status" data-toggle="buttons">
                                   <label class="btn btn-default btn-md">
                                   <input type="radio" value="1" name="sb_reg_type" data-parsley-required="true">
                                   <?php echo esc_html__( 'Employer', 'nokri' ); ?>
                                   </label>
                                   <label class="btn btn-default btn-md active">
                                   <input type="radio" value="0" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__( 'Please Select Type', 'nokri' ); ?>" name="sb_reg_type" checked="checked">
									<?php echo esc_html__( 'Candidate', 'nokri' ); ?>
                                   </label>
                                </div>
                             </div>
                            
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 
                                <div class="buttons-area">                                  
                                   <div class="form-group">
                                       <input type="checkbox" id="check_social_term"  name="icheck_box_terms" class="input-icheck-others" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__( 'Please accept terms and conditions.', 'nokri' ); ?>">
                                      <p><?php echo esc_html__( 'I am agree to', 'nokri' ); ?> <a href="<?php echo get_the_permalink($term_link); ?>" target="_blank"><?php echo esc_html__( 'terms and conditions', 'nokri' ); ?></a></p>
                                   </div>
                                    <input type="submit" class="btn n-btn-flat btn-mid" id="social_login_btn" value="<?php echo esc_html__( 'Continue','nokri' ); ?>">
                                   
                                </div>
                                 
                                
                             </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
  </section>
<?php 
}
else if(get_user_meta($user_id, '_sb_reg_type', true) == '1')
{
	 get_template_part( 'template-parts/employer/employer', 'dashboard');
}
else
{ 
	 get_template_part( 'template-parts/candidate/candidate', 'dashboard');
}
get_footer();