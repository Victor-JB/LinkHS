<?php
/* Make cats selected on update Job */

global $nokri;
$cat_html = nokri_add_taxonomies_on_job_alert('job_category');
$today = date("Y/m/d");
$allow_map = isset($nokri['nokri_allow_map']) ? $nokri['nokri_allow_map'] : true;
        if ($allow_map) {
$mapType = nokri_mapType();
}else{
    $mapType = '';
}
$paid_alert_check    = isset($nokri['job_alert_paid_switch'])  ?   $nokri['job_alert_paid_switch']   :  false;
$alert_end   = "";
if($paid_alert_check){
    
    $product_id   = isset($nokri['job_alert_package'])   ?   $nokri['job_alert_package'] : "";
    $days = get_post_meta($product_id, 'package_expiry_days', true);   
    $end_date = date("Y/m/d",strtotime("+$days days"));
    $alert_end     =    '<input type="hidden" name="alert_end" value='.$end_date.'>';
}


?>
<div class="cp-loader"></div>
<div class="modal fade resume-action-modal" id="job-alert-subscribtion">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
           <?php if($paid_alert_check){  ?>
            
                <form method="post" id="alert_job_form" class="alert-job-modal-popup">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo esc_html__('Want to subscribe job alerts?', 'nokri'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>
                                <?php echo __('Alert Name', 'nokri'); ?><span class="color-red">*</span>
                            </label>
                            <input placeholder="<?php echo __('Enter alert name', 'nokri'); ?>" class="form-control" type="text" data-parsley-required="true" data-parsley-error-message="<?php echo __('Please enter alert name', 'nokri'); ?>" data-parsley-trigger="change" name="alert_name">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>
                                <?php echo __('Your Email', 'nokri'); ?><span class="color-red">*</span>
                            </label>
                            <input placeholder="<?php echo __('Enter your email address', 'nokri'); ?>" class="form-control" type="email" data-parsley-type="email" data-parsley-required="true" data-parsley-error-message="<?php echo __('Please enter your valid email', 'nokri'); ?>" data-parsley-trigger="change" name="alert_email">
                        </div>
                    </div>
                                
                    <?php if (nokri_add_taxonomies_on_job_alert_paid('ad_location', true)) { ?>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label>
                                    <?php echo __('Job Location', 'nokri'); ?><span class="color-red">*</span>
                                </label>
                                <select class="select-generat" data-allow-clear="true"  id="alert_sub_loc" data-parsley-required="true" data-parsley-error-message="<?php echo __('Please select an option', 'nokri'); ?>">
                                    <option value=""><?php echo __('Select an option', 'nokri'); ?></option>
                                    <?php echo nokri_add_taxonomies_on_job_alert_paid('ad_location', ''); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group" id="get_child_loc_lev1">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div id="get_child_loc_lev2" class="form-group">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div id="get_child_loc_lev5" class="form-group">
                            </div>
                        </div>
                      
                    <?php } if (nokri_add_taxonomies_on_job_alert_paid('job_category', true)) { ?>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label>
                                    <?php echo __('Job Category', 'nokri'); ?><span class="color-red">*</span>
                                </label>
                                <select class="select-generat" data-allow-clear="true" data-parsley-required="true"  id="alert_sub_cat" data-parsley-error-message="<?php echo __('Please select an option', 'nokri'); ?>">
                                    <option value=""><?php echo __('Select an option', 'nokri'); ?></option>
                                    <?php echo nokri_add_taxonomies_on_job_alert_paid('job_category', ''); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group" id="get_child_lev1">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div id="get_child_lev2" class="form-group">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div id="get_child_lev5" class="margin-top-10">
                            </div>
                        </div>
                        <input type="hidden" name="alert_category" id="get_cat_val" value="" />
                         <input type="hidden" name="alert_location" id="get_cat_loc" value="" />
                    <?php }  echo ''.$alert_end ?>
                    <input type="hidden" name="alert_start" value="<?php echo ''.($today); ?>" />
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn n-btn-flat btn-mid btn-block" id="submit_paid_alerts">
                            <?php echo esc_html__('Submit', 'nokri'); ?>
                        </button>
                    </div>
                </div>
            </form>
           
            
           <?php } else  { ?>
            <form method="post" id="alert_job_form" class="alert-job-modal-popup">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo esc_html__('Want to subscribe job alerts?', 'nokri'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>
                                <?php echo __('Alert Name', 'nokri'); ?><span class="color-red">*</span>
                            </label>
                            <input placeholder="<?php echo __('Enter alert name', 'nokri'); ?>" class="form-control" type="text" data-parsley-required="true" data-parsley-error-message="<?php echo __('Please enter alert name', 'nokri'); ?>" data-parsley-trigger="change" name="alert_name">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>
                                <?php echo __('Your Email', 'nokri'); ?><span class="color-red">*</span>
                            </label>
                            <input placeholder="<?php echo __('Enter your email address', 'nokri'); ?>" class="form-control" type="email" data-parsley-type="email" data-parsley-required="true" data-parsley-error-message="<?php echo __('Please enter your valid email', 'nokri'); ?>" data-parsley-trigger="change" name="alert_email">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>
                                <?php echo __('Select email frequency', 'nokri'); ?><span class="color-red">*</span>
                            </label>
                            <select class="select-generat" data-allow-clear="true" data-parsley-required="true" data-parsley-error-message="<?php echo __('Please select an option', 'nokri'); ?>" name="alert_frequency">

                                <option value="1"><?php echo __('Daily', 'nokri'); ?></option>
                                <option value="7"><?php echo __('Weekly', 'nokri'); ?></option>
                                <option value="15"><?php echo __('Fortnightly', 'nokri'); ?></option>
                                <option value="30"><?php echo __('Monthly', 'nokri'); ?></option>
                                <option value="12"><?php echo __('Yearly', 'nokri'); ?></option>
                            </select>
                        </div>
                    </div>
                    <?php if (($mapType == 'google_map') && nokri_add_taxonomies_on_job_alert('ad_geo_location', true)) { ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>
                                    <?php echo __('Add your current location', 'nokri'); ?><span class="color-red">*</span>
                                </label>
                                <input type="hidden" id="is_post_job" value="1" />	
                                <input type="text" class="form-control" name="sb_user_address2" id="sb_user_address2" value="" placeholder="<?php echo esc_html__('Enter map address', 'nokri'); ?>" >

                                <a href="javascript:void(0);" id="your_current_location_alert2" title="<?php echo esc_html__('You Current Location', 'nokri'); ?>"><i class="fa fa-crosshairs"></i></a>

                            </div>
                        </div>
                    <?php } ?>
                    <?php if (nokri_add_taxonomies_on_job_alert('job_type', true)) { ?>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label>
                                    <?php echo __('Job Type', 'nokri'); ?><span class="color-red">*</span>
                                </label>
                                <select class="select-generat" data-allow-clear="true" data-parsley-required="true" name="alert_type" data-parsley-error-message="<?php echo __('Please select an option', 'nokri'); ?>">
                                    <option value=""><?php echo __('Select an option', 'nokri'); ?></option>
                                    <?php echo nokri_add_taxonomies_on_job_alert('job_type', ''); ?>
                                </select>
                            </div>
                        </div>
                    <?php } if (nokri_add_taxonomies_on_job_alert('job_experience', true)) { ?>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label>
                                    <?php echo __('Job Experience', 'nokri'); ?><span class="color-red">*</span>
                                </label>
                                <select class="select-generat" data-allow-clear="true" data-parsley-required="true" name="alert_experience" data-parsley-error-message="<?php echo __('Please select an option', 'nokri'); ?>">
                                    <option value=""><?php echo __('Select an option', 'nokri'); ?></option>
                                    <?php echo nokri_add_taxonomies_on_job_alert('job_experience', ''); ?>
                                </select>
                            </div>
                        </div>
                    <?php } if (nokri_add_taxonomies_on_job_alert('ad_location', true)) { ?>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label>
                                    <?php echo __('Job Location', 'nokri'); ?><span class="color-red">*</span>
                                </label>
                                <select class="select-generat" data-allow-clear="true"  id="alert_sub_loc" data-parsley-required="true" data-parsley-error-message="<?php echo __('Please select an option', 'nokri'); ?>">
                                    <option value=""><?php echo __('Select an option', 'nokri'); ?></option>
                                    <?php echo nokri_add_taxonomies_on_job_alert('ad_location', ''); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group" id="get_child_loc_lev1">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div id="get_child_loc_lev2" class="form-group">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div id="get_child_loc_lev5" class="form-group">
                            </div>
                        </div>
                      
                    <?php } if (nokri_add_taxonomies_on_job_alert('job_category', true)) { ?>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label>
                                    <?php echo __('Job Category', 'nokri'); ?><span class="color-red">*</span>
                                </label>
                                <select class="select-generat" data-allow-clear="true" data-parsley-required="true"  id="alert_sub_cat" data-parsley-error-message="<?php echo __('Please select an option', 'nokri'); ?>">
                                    <option value=""><?php echo __('Select an option', 'nokri'); ?></option>
                                    <?php echo nokri_add_taxonomies_on_job_alert('job_category', ''); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group" id="get_child_lev1">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div id="get_child_lev2" class="form-group">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div id="get_child_lev5" class="margin-top-10">
                            </div>
                        </div>
                        <input type="hidden" name="alert_category" id="get_cat_val" value="" />
                         <input type="hidden" name="alert_location" id="get_cat_loc" value="" />
                    <?php } ?>
                    <input type="hidden" name="alert_start" value="<?php echo ''.($today); ?>" />
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn n-btn-flat btn-mid btn-block" id="job_alerts">
                            <?php echo esc_html__('Submit', 'nokri'); ?>
                        </button>
                    </div>
                </div>
            </form>
            
            <?php } ?>
        </div>
    </div>
</div>
