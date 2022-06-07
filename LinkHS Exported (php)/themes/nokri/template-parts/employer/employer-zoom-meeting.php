<?php
global $nokri;
$current_user = wp_get_current_user();
$employer_id = get_current_user_id($current_user);
$user_client_id = get_user_meta($employer_id, '_sb_zoom_client_id', true);
$user_client_secret = get_user_meta($employer_id, '_sb_zoom_client_secret', true);
$user_zoom_email = get_user_meta($employer_id, '_sb_zoom_email', true);

$user_refresh_token = get_user_meta($employer_id, 'emp_zoom_refresh_token', true);

$alredy_auth = false;
if ($alredy_auth == true) {
    // 
    echo '<p>' . esc_html_e('Happy. You are authorized with Zoom', 'nokri') . '</p>';
}
//echo $user_refresh_token;
?>   
<form method="post"  class="nokri_zoom_auth"<?php echo '' . ($alredy_auth ? ' style="display: none;"' : '') ?>>
    <div class="main-body"> 
        <div class="dashboard-social-links">
            <div class="dashboard-edit-profile"> 
                <h4 class="dashboard-heading"><?php echo esc_html__('Zoom Meetings Settings', 'nokri'); ?></h4>

                <div class="cp-loader"></div>
                <div class="col-md-12 col-xs-12 col-sm-6">            
                    <div class="form-group">
                        <span><?php esc_html_e('Zoom Registerd Email', 'nokri') ?></span>
                        <input type="text" name="sb_zoom_email" value="<?php echo '' . ($user_zoom_email) ?>" placeholder="<?php esc_html_e('Enter Zoom Registerd Email', 'nokri') ?>"  class="form-control">
                    </div> 
                </div>
                <div class="col-md-12 col-xs-12 col-sm-6">
                    <div class="form-group">
                        <span><?php esc_html_e('Zoom Client ID', 'nokri') ?></span>
                        <input type="text" name="nokri_sb_client_id" value="<?php echo ''.($user_client_id); ?>" placeholder="<?php esc_html_e('Enter Zoom Client ID', 'nokri') ?>"  class="form-control">
                    </div>
                    
                        <div class="form-group">
                            <span><?php esc_html_e('Client Secret Key', 'nokri') ?></span>
                            <input type="text" name="sb_client_secret" value="<?php echo '' . ($user_client_secret) ?>" placeholder="<?php esc_html_e('Enter Client Secret Key', 'nokri') ?>"  class="form-control">
                        </div> 
                    
                </div>
            </div>
            <div>
                <input type="submit" id="btn_zoom" class="btn n-btn-flat" value="<?php esc_html_e('Authorization with Zoom', 'nokri') ?>">
            </div>
            <p><a href="https://marketplace.zoom.us/develop/create" target="_blank" class="n_getzoom_link"><?php echo esc_html__('How to find Zoom Keys?', 'nokri'); ?></a></p>
        </div>
</form>