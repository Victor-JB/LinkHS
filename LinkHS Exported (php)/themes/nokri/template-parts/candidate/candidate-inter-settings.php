<?php

$user_id                =    get_current_user_id();
$setting_data           =    get_user_meta($user_id,'_cand_settings','true');
$setting_data           =    $setting_data != ""   ? unserialize($setting_data)  :  array();


$cand_phone_setting     =  isset($setting_data['cand_phone_setting'])     ?  $setting_data['cand_phone_setting'] : "";
$cand_email_setting     =  isset($setting_data['cand_email_setting'])     ?  $setting_data['cand_email_setting'] : "";
$cand_adress_setting    =  isset($setting_data['cand_adress_setting'])    ?  $setting_data['cand_adress_setting'] : "";
$cand_dob_setting       =  isset($setting_data['cand_dob_setting'])       ?  $setting_data['cand_dob_setting'] : "";
$cand_resume_setting    =  isset($setting_data['cand_resume_setting'])    ?  $setting_data['cand_resume_setting'] : "";
$cand_generate_setting  =  isset($setting_data['cand_generate_setting'])  ?  $setting_data['cand_generate_setting'] : "";
$cand_save_setting      =  isset($setting_data['cand_save_setting'])      ?  $setting_data['cand_save_setting'] : "";
 
?>
<form id="candidate-settings" method="post" enctype="multipart/form-data" autocomplete="off">
<div class="main-body">
<div class="dashboard-edit-profile">
    <h4 class="dashboard-heading"><?php echo esc_html__( 'Candidate Settings', 'nokri' ); ?> </h4>
        <div class="row">                
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class=""><?php echo esc_html__( 'Show phone Number', 'nokri' ); ?></label>
                    <select  class="select-generat form-control" name="cand_phone_setting" >
                        <option value="other" <?php if ( $cand_phone_setting == 'other') { echo "selected"; } ; ?>><?php echo esc_html__( 'Select option', 'nokri' ); ?></option>
                        <option value="yes" <?php if ( $cand_phone_setting == 'yes') { echo "selected"; } ; ?>><?php echo esc_html__( 'Yes', 'nokri' ); ?></option>
                        <option value="no" <?php if ( $cand_phone_setting == 'no') { echo "selected"; } ; ?>><?php echo esc_html__( 'No', 'nokri' ); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class=""><?php echo esc_html__( 'Show Email', 'nokri' ); ?></label>
                    <select  class="select-generat form-control" name="cand_email_setting" >
                        <option value="other" <?php if ( $cand_email_setting == 'other') { echo "selected"; } ; ?>><?php echo esc_html__( 'Select option', 'nokri' ); ?></option>
                        <option value="yes" <?php if ( $cand_email_setting == 'yes') { echo "selected"; } ; ?>><?php echo esc_html__( 'Yes', 'nokri' ); ?></option>
                        <option value="no" <?php if ( $cand_email_setting == 'no') { echo "selected"; } ; ?>><?php echo esc_html__( 'No', 'nokri' ); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class=""><?php echo esc_html__( 'Show Adress', 'nokri' ); ?></label>
                    <select  class="select-generat form-control" name="cand_adress_setting" >
                        <option value="other" <?php if ( $cand_adress_setting == 'other') { echo "selected"; } ; ?>><?php echo esc_html__( 'Select option', 'nokri' ); ?></option>
                        <option value="yes" <?php if ( $cand_adress_setting == 'yes') { echo "selected"; } ; ?>><?php echo esc_html__( 'Yes', 'nokri' ); ?></option>
                        <option value="no" <?php if ( $cand_adress_setting == 'no') { echo "selected"; } ; ?>><?php echo esc_html__( 'No', 'nokri' ); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class=""><?php echo esc_html__( 'Show Dob', 'nokri' ); ?></label>
                    <select  class="select-generat form-control" name="cand_dob_setting" >
                        <option value="other" <?php if ( $cand_dob_setting == 'other') { echo "selected"; } ; ?>><?php echo esc_html__( 'Select option', 'nokri' ); ?></option>
                        <option value="yes" <?php if ( $cand_dob_setting == 'yes') { echo "selected"; } ; ?>><?php echo esc_html__( 'Yes', 'nokri' ); ?></option>
                        <option value="no" <?php if ( $cand_dob_setting == '') { echo "selected"; } ; ?>><?php echo esc_html__( 'No', 'nokri' ); ?></option>
                    </select>
                </div>
            </div>
               <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class=""><?php echo esc_html__( 'Show Save Resumes', 'nokri' ); ?></label>
                    <select  class="select-generat form-control" name="cand_save_setting" >
                        <option value="other" <?php if ( $cand_save_setting == 'other') { echo "selected"; } ; ?>><?php echo esc_html__( 'Select option', 'nokri' ); ?></option>
                        <option value="yes" <?php if ( $cand_save_setting == 'yes') { echo "selected"; } ; ?>><?php echo esc_html__( 'Yes', 'nokri' ); ?></option>
                        <option value="no" <?php if ( $cand_save_setting == 'no') { echo "selected"; } ; ?>><?php echo esc_html__( 'No', 'nokri' ); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class=""><?php echo esc_html__( 'Show Download Resume', 'nokri' ); ?></label>
                    <select  class="select-generat form-control" name="cand_resume_setting" >
                        <option value="other" <?php if ( $cand_resume_setting == 'other') { echo "selected"; } ; ?>><?php echo esc_html__( 'Select option', 'nokri' ); ?></option>
                        <option value="yes" <?php if ( $cand_resume_setting == 'yes') { echo "selected"; } ; ?>><?php echo esc_html__( 'Yes', 'nokri' ); ?></option>
                        <option value="no" <?php if ( $cand_resume_setting == 'no') { echo "selected"; } ; ?>><?php echo esc_html__( 'No', 'nokri' ); ?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 col-sm-6">
                <div class="form-group">
                    <label class=""><?php echo esc_html__( 'Show Generate Resume', 'nokri' ); ?></label>
                    <select  class="select-generat form-control" name="cand_generate_setting" >
                        <option value ="other" <?php if ( $cand_generate_setting == '') { echo "selected"; } ; ?>><?php echo esc_html__( 'Select option', 'nokri' ); ?></option>
                        <option value ="yes" <?php if ( $cand_generate_setting == 'yes') { echo "selected"; } ; ?>><?php echo esc_html__( 'Yes', 'nokri' ); ?></option>
                        <option value ="no" <?php if ( $cand_generate_setting == 'no') { echo "selected"; } ; ?>><?php echo esc_html__( 'No', 'nokri' ); ?></option>
                    </select>
                </div>
            </div>  
            <div class="col-md-12 col-xs-12 col-sm-12">
                <input type="submit" value="<?php echo esc_html__('Save Settings','nokri'); ?>" class="btn n-btn-flat cand_settings_save">
                <input type="button" disabled="" value="Processing..." class="btn n-btn-flat cand_settings_pro" > 
            </div>
        </div>
</div>
</div>
</form>