<?php
/* Signin in Page */
global $nokri;
$sigin_page = $url = '';
if ((isset($nokri['sb_sign_in_page'])) && $nokri['sb_sign_in_page'] != '') {
    $sigin_page = ($nokri['sb_sign_in_page']);
}
// Password Reset Html	
if (isset($_GET['token']) && $_GET['token'] != "" && !is_user_logged_in()) {
    ?>
    <input type="hidden" id="nokri_password_mismatch_msg"  value="<?php echo __('Password not matched.', 'nokri'); ?>" />
    <div id="sb_reset_password_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header rte">
                    <h2 class="modal-title"><?php echo __('Set your Password', 'nokri'); ?></h2>
                </div>
                <form id="sb-reset-password-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo __('New Password', 'nokri'); ?></label>
                            <input placeholder="<?php echo __('Enter Password', 'nokri'); ?>" class="form-control" type="password" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field this required.', 'nokri'); ?>" data-parsley-trigger="change" name="sb_new_password" id="sb_new_password">
                        </div>
                        <div class="form-group">
                            <label><?php echo __('Confirm New Password', 'nokri'); ?></label>
                            <input placeholder="<?php echo __('Confirm Password', 'nokri'); ?>" class="form-control" type="password" data-parsley-required="true" data-parsley-error-message="<?php echo __('This field this required.', 'nokri'); ?>" data-parsley-trigger="change" name="sb_confirm_new_password" id="sb_confirm_new_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <br/>
                        <button class="btn btn-theme btn-sm" type="submit" id="sb_reset_password_submit"><?php echo __('Change Password', 'nokri'); ?></button>
                        <button class="btn btn-theme btn-sm" type="button" id="sb_reset_password_msg"><?php echo __('Processing...', 'nokri'); ?></button>
                        <input type="hidden" name="token" value="<?php echo esc_attr($_GET['token']); ?>" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
// Email verificatioon	
if (isset($_GET['verification_key']) && $_GET['verification_key'] != "" && !is_user_logged_in()) {
    $token = $_GET['verification_key'];
    $token_arr = explode('-sb-uid-', $token);
    $key = $token_arr[0];
    $uid = $token_arr[1];
    $token_db = get_user_meta($uid, 'sb_email_verification_token', true);
    if ($token_db != $key) {
        echo '<script>jQuery(window).load(function($) { toastr.error("' . __("Invalid security token.", 'nokri') . '", "", {timeOut: 3500,"closeButton": true, "positionClass": "toast-top-right"}); });</script>';
    } else {

        update_user_meta($uid, 'sb_email_verification_token', '');
        // Set the user's role (and implicitly remove the previous role).
        $user = new WP_User($uid);
        $user->set_role('subscriber');
        $url = get_the_permalink($sigin_page);
        echo '<script>jQuery(window).load(function($) { 		
		toastr.success("' . __("Your account has been verified.", 'nokri') . '", "", {
                    timeOut: 3500,
                    "closeButton": true, 
                    "positionClass": "toast-top-right" ,                  
                    onHidden: function () {
                      window.location = "' . $url . '";
                     }                    
                  }); });		
		</script>';

        header("refresh:2;url=$url");
    }
}