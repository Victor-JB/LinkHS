<?php
global $nokri;
if (isset($_GET['verification_key']) && $_GET['verification_key'] != "" && !is_user_logged_in()):
    $token = $_GET['verification_key'];
    $token_arr = explode('-sb-uid-', $token);
    $key = $token_arr[0];
    $uid = $token_arr[1];
    $token_db = get_user_meta($uid, 'sb_email_verification_token', true);
    if ($token_db != $key):
        ?>
        <div id="token-expire" class="alert custom-alert custom-alert--danger" role="alert">
            <div class="custom-alert__top-side">
                <span class="alert-icon custom-alert__icon  ti-face-sad "></span>
                <div class="custom-alert__body">
                    <h6 class="custom-alert__heading">
                        <?php echo esc_html__('Token Expired!', 'nokri'); ?>
                    </h6>
                    <div class="custom-alert__content">
                        <?php echo esc_html__("The security token included in the request is expired.", 'nokri'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else :
        ?>
        <div id="token-verif" class="alert custom-alert custom-alert--success" role="alert">
            <div class="custom-alert__top-side">
                <span class="alert-icon custom-alert__icon ti-face-smile "></span>
                <div class="custom-alert__body">
                    <h6 class="custom-alert__heading">
                        <?php echo esc_html__(' Congratulation!', 'nokri'); ?>
                    </h6>
                    <div class="custom-alert__content">
                        <?php echo esc_html__("Your account has been verified.", 'nokri'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        update_user_meta($uid, 'sb_email_verification_token', '');
        $user = new WP_User($uid);
        $user->set_role('subscriber');
    endif;
endif;