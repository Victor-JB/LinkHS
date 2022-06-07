<?php

if (isset($_GET['code'])) {
    $response = nokri_linked_handling($_GET['code']);

    if (count($response) > 0) {
        $email = isset($response[2]) ? $response[2] : '';
        $fname = isset($response[0]) ? $response[0] : '';
        $lname = isset($response[1]) ? $response[1] : '';

        $headline = $publicProfileUrl = '';
        if ($email == "") {
            $GLOBALS['action_type'] = '1';
        } else {
            if (isset($_GET['state']) && $_GET['state'] == 'popup') {
                $res = nokri_check_social_user_linkedin('5868', $email, $fname . ' ' . $lname, $headline, $publicProfileUrl);

                if ($res == 2) {
                    $GLOBALS['action_type'] = '2';
                    $user_id = get_current_user_id();
                    $fname_lname = $fname . " " . $lname;
                    wp_update_user(array('ID' => $user_id, 'display_name' => $fname_lname));
                    update_user_meta($user_id, '_user_headline', $headline);
                } else {
                    $GLOBALS['action_type'] = '3';
                }
            } else {
                $state_arr = explode('-', $_GET['state']);
                $job_id = $state_arr[1];
                $action = $state_arr[0];
                if (is_user_logged_in()) {
                    $user_id = get_current_user_id();
                    // applying for job						
                    $is_applied = nokri_apply_by_linkedin($job_id, $user_id, $publicProfileUrl);
                    if ($is_applied) {
                        $GLOBALS['action_type'] = '4';
                    } else {
                        $GLOBALS['action_type'] = '5';
                    }

                    // redirect to job
                    nokri_js_redirect(get_the_permalink($job_id));
                } else {
                    $res = nokri_check_social_user('5868', $email, $fname . ' ' . $lname, $headline, $publicProfileUrl);
                    $user_id = get_current_user_id();
                    update_user_meta($user_id, '_sb_reg_type', 0);
                    // applying for job
                    $is_applied = nokri_apply_by_linkedin($job_id, $user_id, $publicProfileUrl);
                    if ($is_applied) {
                        $GLOBALS['action_type'] = '6';
                    } else {
                        $GLOBALS['action_type'] = '7';
                        nokri_jspopup(__("Already applied for this job.", 'nokri'), 'error');
                    }
                }
            }
        }
    }
}