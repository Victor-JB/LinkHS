<?php
// Resend Email
add_action('wp_ajax_sb_resend_email', 'nokri_resend_email');
add_action('wp_ajax_nopriv_sb_resend_email', 'nokri_resend_email');

function nokri_resend_email() {
    $email = $_POST['usr_email'];
    $user = get_user_by('email', $email);
    if (get_user_meta($user->ID, 'sb_resent_email', true) != 'yes') {

        nokri_email_on_new_user($user->ID, '', false);
        update_user_meta($user->ID, 'sb_resent_email', 'yes');
    }
    die();
}

/* Employer Sending Email */

if (!function_exists('nokri_employer_status_email')) {

    function nokri_employer_status_email($job_id, $candidate_id, $subject, $body) {
        global $nokri;
        // Auhtor info
        $author_id = get_post_field('post_author', $job_id);
        $author_id = get_userdata($author_id);
        $author_name = $author_id->display_name;
        $author_email = $author_id->user_email;
        $author_job_title = get_the_title($job_id);
        // Candidate  info
        $candidate_id = get_userdata($candidate_id);
        $candidate_name = $candidate_id->display_name;
        $candidate_email = $candidate_id->user_email;
        $subject = $subject;
        $from = $nokri['sb_job_status_message_from'];
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");

        wp_mail($candidate_email, $subject, $body, $headers);
    }

}

// contact me function
function nokri_contact_me_email($reciver_id, $sender_email, $sender_name, $subject_form, $message) {
    global $nokri;
    if (isset($nokri['sb_new_cotact_message']) && $nokri['sb_new_cotact_message'] != "" && isset($nokri['sb_new_cotact_from']) && $nokri['sb_new_cotact_from'] != "") {

        // receiver info
        $reciver_id = get_userdata($reciver_id);
        $reciver_name = $reciver_id->display_name;
        $reciver_email = $reciver_id->user_email;

        // sender info
        $sender_email = $sender_email;
        $subject = $subject_form != "" ? $subject_form : $nokri['sb_new_cotact_message'];

        $from = $nokri['sb_new_cotact_from'];
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");

        $msg_keywords = array('%site_name%', '%display_name%', '%email%', '%subject%', '%message%', "%receiver_name%");
        $msg_replaces = array(get_bloginfo('name'), $sender_name, $sender_email, $subject, $message, $reciver_name);

        $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_new_cotact_body']);
        wp_mail($reciver_email, $subject, $body, $headers);
    }
}

//Zoom new meeting invitation 

if (!function_exists('nokri_send_candidate_meeting_link')) {

    function nokri_send_candidate_meeting_link($url, $meeting_id, $meeting_pass, $cand_id, $job_id, $meetingTime, $meet_duration) {

        global $nokri;

        $author_id = get_current_user_id();
        $author_data = get_userdata($author_id);
        $author_name = $author_data->display_name;

        $cand_data = get_userdata($cand_id);
        $cand_email = $cand_data->user_email;
        $cand_name = $cand_data->display_name;

        $author_job_title = get_the_title($job_id);

        $job_link = get_the_permalink($job_id);

        $subject = $nokri['nokri_send_cand_meeting_subject'];
        $from = $nokri['nokri_send_cand_meeting_from'];
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");

        $msg_keywords = array('%site_name%', '%job_title%', '%job_link%', '%cand_name%', '%emp_name%', '%meeting_url%', '%meeting_id%', '%meeting_pass%', '%meeting_time%', '%meet_duration%');
        $msg_replaces = array(get_bloginfo('name'), $author_job_title, $job_link, $cand_name, $author_name, $url, $meeting_id, $meeting_pass, $meetingTime, $meet_duration);

        $body = str_replace($msg_keywords, $msg_replaces, $nokri['nokri_send_cand_meeting_body']);

        wp_mail($cand_email, $subject, $body, $headers);
    }

}

// New job applier function
function nokri_new_candidate_apply($job_id, $candidate_id) {
    global $nokri;
    if ($nokri['sb_send_email_on_apply'] == '1' && isset($nokri['sb_msg_on_new_apply']) && $nokri['sb_msg_on_new_apply'] != "" && isset($nokri['sb_msg_from_on_new_apply']) && $nokri['sb_msg_from_on_new_apply'] != "") {
        // Auhtor info
        $author_id = get_post_field('post_author', $job_id);
        $author_id = get_userdata($author_id);
        $author_name = $author_id->display_name;
        $author_email = $author_id->user_email;
        // If job apply is with external link 
        $ext_email = get_post_meta($job_id, '_job_apply_mail', true);
        if ($ext_email != '') {
            $author_email = $ext_email;
        }
        $author_job_title = get_the_title($job_id);
        // Candidate  info
        $candidate_id = get_userdata($candidate_id);
        $candidate_link = get_author_posts_url($candidate_id);
        $job_link = get_the_permalink($job_id);
        $candidate_name = $candidate_id->display_name;
        $subject = $nokri['sb_msg_subject_on_new_apply'];
        $from = $nokri['sb_msg_from_on_new_apply'];
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $msg_keywords = array('%site_name%', '%job_title%', '%candidate_name%', '%candidate_link%', '%job_link%', '%message%');
        $msg_replaces = array(get_bloginfo('name'), $author_job_title, $candidate_name, $candidate_link, $job_link);
        $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_msg_on_new_apply']);
        wp_mail($author_email, $subject, $body, $headers);
    }
}

//send welcome message to applier

function nokri_welcome_applier($job_id, $cand_id) {
    global $nokri;
    if ($nokri['sb_send_welcome_email_on_apply'] == '1' && isset($nokri['sb_welcome_msg_on_new_apply']) && $nokri['sb_welcome_msg_on_new_apply'] != "") {


        //company details
        $job_title = get_the_title($job_id);
        $author_id = get_post_field('post_author', $job_id);
        $author_link = get_author_posts_url($author_id);
        $author_id = get_userdata($author_id);
        $author_name = $author_id->display_name;
        $author_email = $author_id->user_email;

        // Candidate  info
        $candidate_data = get_userdata($cand_id);
        $candidate_link = get_author_posts_url($cand_id);
        $job_link = get_the_permalink($job_id);
        $candidate_name = $candidate_data->display_name;
        $cand_email = $candidate_data->user_email;
        $subject = $nokri['sb_welcome_msg_subject_on_new_apply'];
        $from = $nokri['sb_welcome_msg_from_on_new_apply'];

        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $msg_keywords = array('%site_name%', '%job_title%', '%job_link%', '%comp_name%', '%comp_link%', '%candidate_name%', '%candidate_link%', '%message%');

        $msg_replaces = array(get_bloginfo('name'), $job_title, $job_link, $author_name, $author_link, $candidate_name, $candidate_link);
        $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_welcome_msg_on_new_apply']);

        wp_mail($cand_email, $subject, $body, $headers);
    }
}

// Apply with out login
function nokri_apply_without_login_password($user_id = '', $password = '', $job_id = '') {
    global $nokri;
    if (isset($nokri['sb_without_login_email_message']) && $nokri['sb_without_login_email_message'] != "" && isset($nokri['sb_without_login_from']) && $nokri['sb_without_login_from'] != "") {
        // Candidate  info
        $user_id = get_userdata($user_id);
        $user_name = $user_id->display_name;
        $user_email = $user_id->user_email;
        /* Job Information */
        $job_id = $job_id;
        $job_title = get_the_title($job_id);
        $subject = $nokri['sb_without_login_email_message'];
        $from = $nokri['sb_without_login_from'];
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $msg_keywords = array('%site_name%', '%display_name%', '%subject%', '%email%', '%password%', '%job_title%', '%message%');
        $msg_replaces = array(get_bloginfo('name'), $user_name, $subject, $user_email, $password, $job_title,);
        $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_without_login_body']);
        wp_mail($user_email, $subject, $body, $headers);
    }
}

// Email on new User
function nokri_email_on_new_user($user_id, $social = '', $admin_email = true) {
    global $nokri;

    if (isset($nokri['sb_new_user_email_to_admin']) && $nokri['sb_new_user_email_to_admin'] && $admin_email) {
        if (isset($nokri['sb_new_user_admin_message_admin']) && $nokri['sb_new_user_admin_message_admin'] != "" && isset($nokri['sb_new_user_admin_message_from_admin']) && $nokri['sb_new_user_admin_message_from_admin'] != "") {
            $to = get_option('admin_email');
            $subject = $nokri['sb_new_user_admin_message_subject_admin'];
            $from = $nokri['sb_new_user_admin_message_from_admin'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");

            // User info
            $user_info = get_userdata($user_id);
            $msg_keywords = array('%site_name%', '%display_name%', '%email%');
            $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, $user_info->user_email);

            $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_new_user_admin_message_admin']);
            wp_mail($to, $subject, $body, $headers);
        }
    }
    if (isset($nokri['sb_new_user_email_to_user']) && $nokri['sb_new_user_email_to_user']) {

        if (isset($nokri['sb_new_user_message']) && $nokri['sb_new_user_message'] != "" && isset($nokri['sb_new_user_message_from']) && $nokri['sb_new_user_message_from'] != "") {
            // User info
            $user_info = get_userdata($user_id);
            $to = $user_info->user_email;
            $subject = $nokri['sb_new_user_message_subject'];
            $from = $nokri['sb_new_user_message_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $user_name = $user_info->user_email;
            if ($social != '')
                $user_name .= "(Password: $social )";

            $verification_link = '';
            if (isset($nokri['sb_new_user_email_verification']) && $nokri['sb_new_user_email_verification'] && $social == "") {
                $token = get_user_meta($user_id, 'sb_email_verification_token', true);
                if ($token == "") {
                    $token = nokri_randomString(50);
                }
                $verification_link = trailingslashit(get_home_url()) . '?verification_key=' . $token . '-sb-uid-' . $user_id;

                update_user_meta($user_id, 'sb_email_verification_token', $token);
            }

            $msg_keywords = array('%site_name%', '%user_name%', '%display_name%', '%verification_link%');
            $msg_replaces = array(get_bloginfo('name'), $user_name, $user_info->display_name, $verification_link);
            $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_new_user_message']);
            wp_mail($to, $subject, $body, $headers);
        }
    }
}

// Ajax handler for Forgot Password
add_action('wp_ajax_sb_forgot_password', 'nokri_forgot_password');
add_action('wp_ajax_nopriv_sb_forgot_password', 'nokri_forgot_password');

// Forgot Password
function nokri_forgot_password() {
    global $nokri;
    // Getting values
    $params = array();
    parse_str($_POST['sb_data'], $params);
    $email = $params['sb_forgot_email'];
    if (email_exists($email) == true) {
        // lets generate our new password
        $random_password = wp_generate_password(12, false);

        $to = $email;
        $subject = __('Your new password', 'redux-framework');
        $body = __('Your new password is: ', 'redux-framework') . $random_password;
        $from = get_bloginfo('name');

        if (isset($nokri['sb_forgot_password_from']) && $nokri['sb_forgot_password_from'] != "") {
            $from = $nokri['sb_forgot_password_from'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($nokri['sb_forgot_password_message']) && $nokri['sb_forgot_password_message'] != "") {
            $subject_keywords = array('%site_name%');
            $subject_replaces = array(get_bloginfo('name'));
            $subject = str_replace($subject_keywords, $subject_replaces, $nokri['sb_forgot_password_subject']);

            $token = nokri_randomString(50);
            $user = get_user_by('email', $email);
            $msg_keywords = array('%site_name%', '%user%', '%reset_link%');
            $reset_link = trailingslashit(get_home_url()) . '?token=' . $token . '-sb-uid-' . $user->ID;
            $msg_replaces = array(get_bloginfo('name'), $user->display_name, $reset_link);
            $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_forgot_password_message']);
        }
        $mail = wp_mail($to, $subject, $body, $headers);
        if ($mail) {
            // Get user data by field and data, other field are ID, slug, slug and login
            update_user_meta($user->ID, 'sb_password_forget_token', $token);
            echo "1";
        } else {
            echo __('Email server not responding', 'redux-framework');
        }
    } else {
        echo __('Email is not resgistered with us.', 'redux-framework');
    }
    die();
}

// Email on Job Post
function nokri_get_notify_on_ad_post($pid) {
    global $nokri;
    if (isset($nokri['sb_send_email_on_ad_post']) && $nokri['sb_send_email_on_ad_post'] == '1') {
        $to = $nokri['ad_post_email_value'];
        $subject = __('New Job', 'redux-framework') . '-' . get_bloginfo('name');
        $body = '<html><body><p>' . __('Got new ad', 'redux-framework') . ' <a href="' . get_edit_post_link($pid) . '">' . get_the_title($pid) . '</a></p></body></html>';
        $from = get_bloginfo('name');
        if (isset($nokri['sb_msg_from_on_new_ad']) && $nokri['sb_msg_from_on_new_ad'] != "") {
            $from = $nokri['sb_msg_from_on_new_ad'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($nokri['sb_msg_on_new_ad']) && $nokri['sb_msg_on_new_ad'] != "") {
            $author_id = get_post_field('post_author', $pid);
            $user_info = get_userdata($author_id);
            $subject_keywords = array('%site_name%', '%job_owner%', '%job_title%');
            $subject_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid));
            $subject = str_replace($subject_keywords, $subject_replaces, $nokri['sb_msg_subject_on_new_ad']);
            $msg_keywords = array('%site_name%', '%job_owner%', '%job_title%', '%job_link%');
            $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid), get_the_permalink($pid));
            $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_msg_on_new_ad']);
        }
        wp_mail($to, $subject, $body, $headers);
    }
}

/* Email job to anyone */

function nokri_email_job_to_anyone($pid, $user_email) {
    global $nokri;
    if (isset($nokri['sb_email_job_to_anyone_subj']) && $nokri['sb_email_job_to_anyone_from']) {
        // Job  info
        $job_id = $pid;
        $job_title = get_the_title($pid);
        $job_link = get_the_permalink($pid);
        $subject = $nokri['sb_email_job_to_anyone_subj'];
        $from = $nokri['sb_email_job_to_anyone_from'];
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $msg_keywords = array('%site_name%', '%job_title%', '%job_link%');
        $msg_replaces = array(get_bloginfo('name'), $job_title, $job_link);
        $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_email_job_to_anyone_body']);
        $sent = wp_mail($user_email, $subject, $body, $headers);
        if ($sent)
            return true;
    }
}

/* Email job alert */
if (!function_exists('nokri_email_job_alerts')) {

    function nokri_email_job_alerts($pid, $user_email) {
        global $nokri;
        if (isset($nokri['sb_email_job_alerts_subj']) && $nokri['sb_email_job_alerts_subj'] != '') {
            // Job  info                         
            $job_id = $pid;
            $job_title = get_the_title($pid);
            $job_link = get_the_permalink($pid);
            $subject = $nokri['sb_email_job_alerts_subj'];
            $from = $nokri['sb_email_job_alerts_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $msg_keywords = array('%site_name%', '%job_title%', '%job_link%');
            $msg_replaces = array(get_bloginfo('name'), $job_title, $job_link);
            $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_email_job_alerts_body']);
            wp_mail($user_email, $subject, $body, $headers);
        }
    }

}

/* Before pacakge expiry Email */
if (!function_exists('nokri_before_package_expiry_notify')) {

    function nokri_before_package_expiry_notify($user_id) {
        global $nokri;

        if (isset($nokri['sb_package_expiry_message']) && $nokri['sb_package_expiry_message'] != '') {
            $user_id = $user_id;
            $user_data = get_userdata($user_id);
            $user_email = $user_data->user_email;
            $display_name = $user_data->display_name;
            $subject = $nokri['sb_package_expiry_message'];
            $from = $nokri['sb_before_package_expiry_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $days = isset($nokri['sb_package_expiry_days']) ? $nokri['sb_package_expiry_days'] : 1;
            $tommorow = Date('Y-m-d', strtotime("$days days"));
            $msg_keywords = array('%display_name%', '%site_name%', '%message%', '%subject%');
            $msg_replaces = array($display_name, get_bloginfo('name'), $tommorow, $subject);
            $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_before_package_expiry_body']);
            wp_mail($user_email, $subject, $body, $headers);
        }
    }

}

/* Before pacakge expiry Email */
if (!function_exists('nokri_before_jobs_expiry_notify')) {

    function nokri_before_jobs_expiry_notify($job_id, $expired) {

        global $nokri;
        if (isset($nokri['sb_jobs_expiry_message']) && $nokri['sb_jobs_expiry_message'] != '') {
            $user_id = get_post_field('post_author', $job_id);
            $user_data = get_userdata($user_id);
            $user_email = $user_data->user_email;
            $display_name = $user_data->display_name;
            $job_name = get_the_title($job_id);
            $job_url = get_the_permalink($job_id);
            $job_deadline_n = get_post_meta($job_id, '_job_date', true);
            $subject = $nokri['sb_jobs_expiry_message'];
            $from = $nokri['sb_before_jobs_expiry_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");

            $msg_keywords = array('%display_name%', '%site_name%', '%job_name%', '%job_url%', '%date%');
            $msg_replaces = array($display_name, get_bloginfo('name'), $job_name, $job_url, $job_deadline_n);

            if ($expired == "yes") {
                $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_after_jobs_expiry_body']);
            } else {
                $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_before_jobs_expiry_body']);
            }
            wp_mail($user_email, $subject, $body, $headers);
        }
    }

}

if (!function_exists('nokri_base64Encode')) {

    function nokri_base64Encode($json) {
        return base64_encode($json);
    }

}
if (!function_exists('nokri_base64Decode')) {

    function nokri_base64Decode($json) {
        return base64_decode($json);
    }

}


if (!function_exists('nokri_downloadfiles_option')) {

    function nokri_downloadfiles_option($theFile = '') {
        if (!$theFile) {
            return;
        }
        //clean the fileurl
        $file_url = stripslashes(trim($theFile));
        $file_url = preg_replace('/\?.*/', '', $file_url);
        //get filename
        $file_name = basename($file_url);
        //get fileextension                      
        $file_extension = pathinfo($file_name);
        //security check
        $fileName = strtolower($file_name);

        $whitelist = array('txt', 'pdf', 'doc', 'docx');

        if (!in_array(end(explode('.', $fileName)), $whitelist)) {
            exit('Invalid file!');
        }
        if (strpos($file_url, '.php') == true) {
            die("Invalid file!");
        }
        $file_new_name = $file_name;
        $content_type = "";
        //check filetype
        switch ($file_extension['extension']) {
            case "txt":
                $content_type = "file/txt";
                break;
            case "pdf":
                $content_type = "file/pdf";
                break;
            case "doc":
                $content_type = "file/doc";
                break;
            case "docx":
            case "docx":
                $content_type = "file/docx";
                break;
            default:
                $content_type = "application/force-download";
        }
        $content_type = apply_filters("ibenic_content_type", $content_type, $file_extension['extension']);
        header("Expires: 0");
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header('Cache-Control: pre-check=0, post-check=0, max-age=0', false);
        header("Pragma: no-cache");
        header("Content-type: {$content_type}");
        header("Content-Disposition:attachment; filename={$file_new_name}");
        header("Content-Type: application/force-download");
        ob_clean();
        flush();
        readfile("{$file_url}");
    }

}

// Ajax handler for newsletter
add_action('wp_ajax_sb_mailchimp_subcribe', 'nokri_mailchimp_subcribe');
add_action('wp_ajax_nopriv_sb_mailchimp_subcribe', 'nokri_mailchimp_subcribe');

// Addind Subcriber into Mailchimp
function nokri_mailchimp_subcribe() {
    global $nokri;
    $listid = $nokri['mailchimp_api_list_id'];
    $sb_action = $_POST['sb_action'];

    $apiKey = $nokri['mailchimp_api_key'];
    // Getting value from form
    $email = $_POST['sb_email'];
    $fname = '';
    $lname = '';

    // MailChimp API URL
    $memberID = md5(strtolower($email));
    $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listid . '/members/' . $memberID;

    // member information
    $json = json_encode(array(
        'email_address' => $email,
        'status' => 'subscribed',
        'merge_fields' => array(
            'FNAME' => $fname,
            'LNAME' => $lname
        )
    ));

    // send a HTTP POST request with curl
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    // store the status message based on response code
    $mcdata = json_decode($result);
    if (!empty($mcdata->error)) {
        echo 0;
    } else {
        echo 1;
    }
    die();
}

// Free packgae function
if (!function_exists('nokri_free_package')) {

    function nokri_free_package($product_id, $user_id = '') {
        global $nokri;
        if ($user_id != '') {
            $uid = $user_id;
        } else {
            $uid = get_current_user_id();
        }
        if (get_user_meta($uid, '_sb_reg_type', true) == '0')
            return '';
        $cand_is_search = (int) get_post_meta($product_id, 'is_candidates_search', true);
        $cand_search_val = (int) get_post_meta($product_id, 'candidate_search_values', true);
        $c_terms = get_terms('job_class', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
        $cand_bump_add = (int) get_post_meta($product_id, 'pack_bump_ads_limit', true);

        if (count($c_terms) > 0) {
            foreach ($c_terms as $c_term) {
                $meta_name = '';
                $get_origtermid = nokri_get_origional_term_id($c_term->term_id);
                $meta_name = 'package_job_class_' . $get_origtermid;
                $class = (int) get_post_meta($product_id, $meta_name, true);
                if ($class == '-1') {
                    update_user_meta($uid, $meta_name, (int) '-1');
                } else if (is_numeric($class) && $class > 0) {
                    $no_of_jobs = (int) get_user_meta($uid, $meta_name, true);
                    if ($class != 0) {
                        $new_jobs = $class + $no_of_jobs;
                    }
                    update_user_meta($uid, $meta_name, (int) $new_jobs);
                }
            }
        }
        $is_pkg_free = get_post_meta($product_id, 'op_pkg_typ', true);

        if ($is_pkg_free == 1) {
            update_user_meta($uid, 'avail_free_package', (int) '1');
        }
        
        //adding bump up adds
        if ($cand_bump_add != "") {
            $bump_up = get_user_meta($uid, 'bump_ads_limit', true);
            if ($bump_up == "") {
                update_user_meta($uid, 'bump_ads_limit', $cand_bump_add);
            } else if ($bump_up == "-1") {
                update_user_meta($uid, 'bump_ads_limit', "-1");
            } else {
                $new_bump_up = (int) $cand_bump_add + (int) $bump_up;
                update_user_meta($uid, 'bump_ads_limit', $new_bump_up);
            }
        }

        //feature profiles logic
        //Features profiles
        $emp_feature_profile = (int) get_post_meta($product_id, 'pack_emp_featured_profile', true);
        if ($emp_feature_profile == '-1') {
            update_user_meta($uid, '_emp_feature_profile', '-1');
        } else {
            $expiry_feature_date = get_user_meta($uid, '_emp_feature_profile', true);
            $exp_date = strtotime($expiry_feature_date);
            $today = strtotime(date('Y-m-d'));
            if ($expiry_feature_date && $today > $exp_date) {
                $new_featur_expiry = date('Y-m-d', strtotime("+$emp_feature_profile days"));
            } else {
                $date_created = date_create($expiry_feature_date);
                date_add($date_created, date_interval_create_from_date_string("$emp_feature_profile days"));
                $new_featur_expiry = date_format($date_created, "Y-m-d");
            }
            update_user_meta($uid, '_emp_feature_profile', $new_featur_expiry);
        }
        // Expiry date logic
        $days = get_post_meta($product_id, 'package_expiry_days', true);
        if ($days == '-1') {
            update_user_meta($uid, '_sb_expire_ads', '-1');
        } else {
            $expiry_date = get_user_meta($uid, '_sb_expire_ads', true);
            $e_date = strtotime($expiry_date);
            $today = strtotime(date('Y-m-d'));
            if ($expiry_date && $today > $e_date) {
                $new_expiry = date('Y-m-d', strtotime("+$days days"));
            } else {
                $date = date_create($expiry_date);
                date_add($date, date_interval_create_from_date_string("$days days"));
                $new_expiry = date_format($date, "Y-m-d");
            }
            update_user_meta($uid, '_sb_expire_ads', $new_expiry);
            /* Updating candidate search */
            if ((isset($nokri['cand_search_mode'])) && $nokri['cand_search_mode'] == '2') {
                /* Counting existing values */
                if ($cand_search_val == '-1') {
                    update_user_meta($uid, '_sb_cand_search_value', (int) '-1');
                } else if (is_numeric($cand_search_val) && $cand_search_val > 0) {
                    $no_of_search = get_user_meta($uid, '_sb_cand_search_value', $cand_is_search);

                    if ($no_of_search != "") {

                        $new_searches = $cand_search_val + (int) $no_of_search;
                    } else {

                        $new_searches = $cand_search_val;
                    }
                    update_user_meta($uid, '_sb_cand_search_value', (int) $new_searches);
                } else {
                    update_user_meta($uid, '_sb_cand_search_value', (int) '0');
                }
                update_user_meta($uid, '_sb_cand_is_search', $cand_is_search);
            }
        }
    }

}
// Free packgae function for candidate
if (!function_exists('nokri_free_package_for_candidate')) {

    function nokri_free_package_for_candidate($product_id, $user_id = '') {
        global $nokri;
        if ($user_id != '') {
            $uid = $user_id;
        } else {
            $uid = get_current_user_id();
        }
        if (get_user_meta($uid, '_sb_reg_type', true) == '1')
            return '';

        $candidate_jobs = (int) get_post_meta($product_id, 'candidate_jobs', true);
        $candidate_feature_list = (int) get_post_meta($product_id, 'candidate_feature_list', true);
        // Expiry date logic
        $days = get_post_meta($product_id, 'package_expiry_days', true);
        if ($days == '-1') {
            update_user_meta($uid, '_sb_expire_ads', '-1');
        } else {
            $expiry_date = get_user_meta($uid, '_sb_expire_ads', true);
            $e_date = strtotime($expiry_date);
            $today = strtotime(date('Y-m-d'));
            if ($expiry_date && $today > $e_date) {
                $new_expiry = date('Y-m-d', strtotime("+$days days"));
            } else {
                $date = date_create($expiry_date);
                date_add($date, date_interval_create_from_date_string("$days days"));
                $new_expiry = date_format($date, "Y-m-d");
            }
            update_user_meta($uid, '_sb_expire_ads', $new_expiry);
        }
        /* Job info */
        if ($candidate_jobs != '') {
            update_user_meta($uid, '_candidate_applied_jobs', $candidate_jobs);
        }
        /* free package */
        $is_pkg_free = get_post_meta($product_id, 'op_pkg_typ', true);

        if ($is_pkg_free == 1) {
            update_user_meta($uid, 'avail_free_package', (int) '1');
        }
        /* Feature profile info */
        $days = get_post_meta($product_id, 'candidate_feature_list', true);
        if ($days == '-1') {
            update_user_meta($uid, '_candidate_feature_profile', '-1');
            update_user_meta($uid, '_is_candidate_featured', '1');
        } else {
            $expiry_date = get_user_meta($uid, '_candidate_feature_profile', true);
            $e_date = strtotime($expiry_date);
            $today = strtotime(date('Y-m-d'));
            if ($expiry_date && $today > $e_date) {
                $new_expiry = date('Y-m-d', strtotime("+$days days"));
            } else {
                $date = date_create($expiry_date);
                date_add($date, date_interval_create_from_date_string("$days days"));
                $new_expiry = date_format($date, "Y-m-d");
            }
            update_user_meta($uid, '_is_candidate_featured', '1');
            update_user_meta($uid, '_candidate_feature_profile', $new_expiry);
        }
    }

}
// After Successfull payment
add_action('woocommerce_order_status_completed', 'nokri_after_payment');
if (!function_exists('nokri_after_payment')) {

    function nokri_after_payment($order_id) {
        global $nokri;
        global $woocommerce;
        $order = new WC_Order($order_id);
        $uid = get_post_meta($order_id, '_customer_user', true);
        $user_type = get_user_meta($uid, '_sb_reg_type', true);
        $product_id = isset($nokri['job_alert_package']) ? $nokri['job_alert_package'] : "";

        if ($user_type == "1") {
            $c_terms = get_terms('job_class', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
            $items = $order->get_items();
            foreach ($items as $item) {
                $product_id = $item['product_id'];
                $cand_is_search = (int) get_post_meta($product_id, 'is_candidates_search', true);
                $cand_search_val = (int) get_post_meta($product_id, 'candidate_search_values', true);
                if (count((array) $c_terms) > 0) {
                    foreach ($c_terms as $c_term) {
                        $meta_name = '';
                        $get_origtermid = nokri_get_origional_term_id($c_term->term_id);
                        $meta_name = 'package_job_class_' . $get_origtermid;
                        $class = (int) get_post_meta($product_id, $meta_name, true);
                        if ($class == '-1') {
                            update_user_meta($uid, $meta_name, (int) '-1');
                        } else if (is_numeric($class) && $class > 0) {
                            $no_of_jobs = get_user_meta($uid, $meta_name, true);
                            $new_jobs = $class + (int) ( $no_of_jobs);
                            update_user_meta($uid, $meta_name, (int) $new_jobs);
                        }
                    }
                }
                $cand_bump_add = (int) get_post_meta($product_id, 'pack_bump_ads_limit', true);
                if ($cand_bump_add != "") {
                    $bump_up = get_user_meta($uid, 'bump_ads_limit', true);
                    if ($bump_up == "") {
                        update_user_meta($uid, 'bump_ads_limit', $cand_bump_add);
                    } else if ($bump_up == "-1") {
                        update_user_meta($uid, 'bump_ads_limit', "-1");
                    } else {
                        $new_bump_up = (int) $cand_bump_add + (int) $bump_up;
                        update_user_meta($uid, 'bump_ads_limit', $new_bump_up);
                    }
                }

                //Features profiles
                $emp_feature_profile = (int) get_post_meta($product_id, 'pack_emp_featured_profile', true);
                if ($emp_feature_profile == '-1') {
                    update_user_meta($uid, '_emp_feature_profile', '-1');
                } else {
                    $expiry_feature_date = get_user_meta($uid, '_emp_feature_profile', true);
                    $exp_date = strtotime($expiry_feature_date);
                    $today = strtotime(date('Y-m-d'));
                    if ($expiry_feature_date && $today > $exp_date) {
                        $new_featur_expiry = date('Y-m-d', strtotime("+$emp_feature_profile days"));
                    } else {
                        $date_created = date_create($expiry_feature_date);
                        date_add($date_created, date_interval_create_from_date_string("$emp_feature_profile days"));
                        $new_featur_expiry = date_format($date_created, "Y-m-d");
                    }
                    update_user_meta($uid, '_emp_feature_profile', $new_featur_expiry);
                }
                // Expiry date logic
                $days = get_post_meta($product_id, 'package_expiry_days', true);
                if ($days == '-1') {
                    update_user_meta($uid, '_sb_expire_ads', '-1');
                } else {
                    $expiry_date = get_user_meta($uid, '_sb_expire_ads', true);
                    $e_date = strtotime($expiry_date);
                    $today = strtotime(date('Y-m-d'));
                    if ($expiry_date && $today > $e_date) {
                        $new_expiry = date('Y-m-d', strtotime("+$days days"));
                    } else {
                        $date = date_create($expiry_date);
                        date_add($date, date_interval_create_from_date_string("$days days"));
                        $new_expiry = date_format($date, "Y-m-d");
                    }
                    update_user_meta($uid, '_sb_expire_ads', $new_expiry);
                    /* Updating candidate search */
                    if ((isset($nokri['cand_search_mode'])) && $nokri['cand_search_mode'] == '2') {
                        /* Counting existing values */
                        if ($cand_search_val == '-1') {
                            update_user_meta($uid, '_sb_cand_search_value', (int) '-1');
                        } else if (is_numeric($cand_search_val) && $cand_search_val > 0) {
                            $no_of_search = get_user_meta($uid, '_sb_cand_search_value', true);
                            $new_searches = $cand_search_val + (int) $no_of_search;
                            update_user_meta($uid, '_sb_cand_search_value', (int) $new_searches);
                        }
                        update_user_meta($uid, '_sb_cand_is_search', $cand_is_search);
                    }
                }
            }
        } else if ($user_type == "0") {
            $items = $order->get_items();
            foreach ($items as $item) {
                $product_id = $item['product_id'];
                $op_pkg_for = get_post_meta($product_id, 'op_pkg_for', true);
                if ($op_pkg_for != "3") {
                    $candidate_jobs = (int) get_post_meta($product_id, 'candidate_jobs', true);
                    $candidate_feature_list = (int) get_post_meta($product_id, 'candidate_feature_list', true);
                    // Expiry date logic
                    $days = get_post_meta($product_id, 'package_expiry_days', true);
                    if ($days == '-1') {
                        update_user_meta($uid, '_sb_expire_ads', '-1');
                    } else {
                        $expiry_date = get_user_meta($uid, '_sb_expire_ads', true);
                        $e_date = strtotime($expiry_date);
                        $today = strtotime(date('Y-m-d'));
                        if ($expiry_date && $today > $e_date) {
                            $new_expiry = date('Y-m-d', strtotime("+$days days"));
                        } else {
                            $date = date_create($expiry_date);
                            date_add($date, date_interval_create_from_date_string("$days days"));
                            $new_expiry = date_format($date, "Y-m-d");
                        }
                        update_user_meta($uid, '_sb_expire_ads', $new_expiry);
                    }
                    /* Job info */
                    if ($candidate_jobs != '' && $candidate_jobs == '-1') {

                        update_user_meta($uid, '_candidate_applied_jobs', '-1');
                    } else {
                        $saved_jobs = (int) get_user_meta($uid, '_candidate_applied_jobs', true);
                        $total_apply_job = $candidate_jobs;
                        if ($saved_jobs != "" && $saved_jobs == '-1') {

                            $total_apply_job = $candidate_jobs;
                            update_user_meta($uid, '_candidate_applied_jobs', $total_apply_job);
                        } else {

                            $total_apply_job = $saved_jobs + $candidate_jobs;
                        }
                        update_user_meta($uid, '_candidate_applied_jobs', $total_apply_job);
                    }

                    /* Feature profile info */
                    $days = get_post_meta($product_id, 'candidate_feature_list', true);
                    if ($days == '-1') {
                        update_user_meta($uid, '_candidate_feature_profile', '-1');
                        update_user_meta($uid, '_is_candidate_featured', '1');
                    } else {
                        $expiry_date = get_user_meta($uid, '_candidate_feature_profile', true);
                        $e_date = strtotime($expiry_date);
                        $today = strtotime(date('Y-m-d'));
                        if ($expiry_date && $today > $e_date) {
                            $new_expiry = date('Y-m-d', strtotime("+$days days"));
                        } else {
                            $date = date_create($expiry_date);
                            date_add($date, date_interval_create_from_date_string("$days days"));
                            $new_expiry = date_format($date, "Y-m-d");
                        }
                        update_user_meta($uid, '_candidate_feature_profile', $new_expiry);
                        update_user_meta($uid, '_is_candidate_featured', '1');
                    }
                } else if ($op_pkg_for == "3") {

                    $item_id = $item->get_id();
                    $alert_data = wc_get_order_item_meta($item_id, 'temp_alert', true);
                    $random_string = nokri_randomString(5);
                    update_user_meta($uid, '_cand_alerts_' . $uid . $random_string, ($alert_data));
                    delete_user_meta($uid, 'temp_test_alert');
                    if (get_user_meta($uid, '_cand_alerts_en', true) == '') {
                        update_user_meta($uid, '_cand_alerts_en', 1);
                    }
                }
            }
        }
    }

}
// Linkedin handling
if (!function_exists('nokri_linked_handling')) {

    function nokri_linked_handling($code) {
        global $nokri;
        $client_id = ($nokri['linkedin_api_key']);
        $client_secret = ($nokri['linkedin_api_secret']);
        $redirect_uri = ($nokri['redirect_uri']);
        //$api_cal       =  'https://api.linkedin.com/v1/people/~';
        $api_cal = "https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))";
        //$api_cal = "https://api.linkedin.com/v2/me?projection=(id,firstName,lastName)";
        if ($code != "") {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.linkedin.com/oauth/v2/accessToken");
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=" . $code . "&redirect_uri=$redirect_uri&client_id=$client_id&client_secret=$client_secret");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);
        }

        //For Email 	
        $Url = "https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))";
        $token = json_decode($server_output)->access_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $token,
            'X-Restli-Protocol-Version: 2.0.0',
            'Accept: application/json',
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $response = curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($response, $headerSize);
        $response_body = json_decode($body, true);

        $userEmail = (isset($response_body['elements'][0]['handle~']['emailAddress'])) ? $response_body['elements'][0]['handle~']['emailAddress'] : '';

        //For Profile
        $Url = "https://api.linkedin.com/v2/me";
        $token = json_decode($server_output)->access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $token,
            'X-Restli-Protocol-Version: 2.0.0',
            'Accept: application/json',
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $response = curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($response, $headerSize);
        $response_body = json_decode($body, true);
        //print_r($response_body['elements'][0]['handle~']['emailAddress']);

        $fname = (isset($response_body['localizedFirstName'])) ? $response_body['localizedFirstName'] : '';
        $lname = (isset($response_body['localizedLastName'])) ? $response_body['localizedLastName'] : '';
        $res = array();
        $res[] = $fname;
        $res[] = $lname;
        $res[] = $userEmail;

        return $res;
    }

}

/* ========================= */
/* Remove Empty P From Content */
/* ========================= */
if (!function_exists('nokri_remove_empty_p')) {

    function nokri_remove_empty_p($content) {
        $content = force_balance_tags($content);
        $content = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
        $content = preg_replace('~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content);
        return $content;
    }

}
add_filter('the_content', 'nokri_remove_empty_p', 20, 1);

/* ------------------------------------------------ */
/* // Remove notices in Redux */
/* ------------------------------------------------ */
add_action('init', 'nokri_removeDemoModeLink');

function nokri_removeDemoModeLink() { // Be sure to rename this function to something more unique
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2);
    }
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
    }
}

/* Hide admin bar */
add_action('after_setup_theme', 'nokri_hide_adminbar');
if (!function_exists('nokri_hide_adminbar')) {

    function nokri_hide_adminbar() {
        if (is_user_logged_in() && !is_admin() && !( defined('DOING_AJAX') && DOING_AJAX )) {
            $user = wp_get_current_user();
            if (in_array('subscriber', $user->roles)) {
                // user has subscriber role
                show_admin_bar(false);
            }
        }
    }

}

/* For Demo Data Settings Starts */
// Ajax handler for add to cart
add_action('wp_ajax_demo_data_start', 'nokri_before_install_demo_data');

// Addind Subcriber into Mailchimp
function nokri_before_install_demo_data() {
    if (get_option('nokri_fresh_installation') != 'no') {
        update_option('nokri_fresh_installation', $_POST['is_fresh']);
    }
    die();
}

// Importing data
function nokri_importing_data($demo_type) {

    global $wpdb;
    $sql_file_OR_content;
    if ($demo_type == 'Demo') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/demo-eng.sql';
    } else if ($demo_type == 'Arabic') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/demo-ar.sql';
    } else if ($demo_type == 'Hindi') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/demo-hin.sql';
    }

    $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ? $sql_file_OR_content : file_get_contents($sql_file_OR_content) );

    $allLines = explode("\n", $SQL_CONTENT);
    $zzzzzz = $wpdb->query('SET foreign_key_checks = 0');
    preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n" . $SQL_CONTENT, $target_tables);
    foreach ($target_tables[2] as $table) {
        $wpdb->query('DROP TABLE IF EXISTS ' . $table);
    }
    $zzzzzz = $wpdb->query('SET foreign_key_checks = 1');
    //$wpdb->query("SET NAMES 'utf8'");	
    $templine = ''; // Temporary variable, used to store current query
    foreach ($allLines as $line) {
        // Loop through each line
        if (substr($line, 0, 2) != '--' && $line != '') {
            $templine .= $line;  // (if it is not a comment..) Add this line to the current segment
            if (substr(trim($line), -1, 1) == ';') {  // If it has a semicolon at the end, it's the end of the query
                if ($wpdb->prefix != 'wp_') {
                    $templine = str_replace("`wp_", "`$wpdb->prefix", $templine);
                }
                if (!$wpdb->query($templine)) {
                    //print('Error performing query \'<strong>' . $templine . '\': ' . $wpdb->error . '<br /><br />');
                }
                $templine = ''; // set variable to empty, to start picking up the lines after ";"
            }
        }
    }
    //return 'Importing finished. Now, Delete the import file.';
}

/* For Demo Data Settings ends */

/* * ********************* */
/* User type information */
/* * ******************* */

function new_user_type($contactmethods) {
    $contactmethods['user_type'] = __('User Type', 'redux-framework');
    return $contactmethods;
}

add_filter('new_user_type', 'new_user_type', 10, 1);

function new_modify_user_table($column) {
    $column['user_type'] = __('User Type', 'redux-framework');
    return $column;
}

add_filter('manage_users_columns', 'new_modify_user_table');

function new_modify_user_table_row($val, $column_name, $user_id) {
    switch ($column_name) {
        case 'user_type' :
            $user_tpye_info = __('Candidate', 'redux-framework');
            if (get_user_meta($user_id, '_sb_reg_type', true) == 1) {
                $user_tpye_info = __('Employer', 'redux-framework');
            }
            return $user_tpye_info;
            break;
        default:
    }
    return $val;
}

add_filter('manage_users_custom_column', 'new_modify_user_table_row', 10, 3);

class Nokri_Demo_OCDI {

    function __construct() {
        add_filter('pt-ocdi/plugin_intro_text', array($this, 'nokri_ocdi_plugin_intro_text'));
        add_filter('pt-ocdi/import_files', array($this, 'nokri_ocdi_import_files'));
        add_action('pt-ocdi/after_import', array($this, 'nokri_ocdi_after_import'));
        add_filter('pt-ocdi/disable_pt_branding', array($this, '__return_true'));
        //add_action( 'pt-ocdi/enable_wp_customize_save_hooks',  array( $this, '__return_true') );		
    }

    function nokri_ocdi_import_files() {

        $allDemos = array();
        if (class_exists('WPBakeryVisualComposerAbstract')) {
            /* LTR Demo Options */
            $text = " - " . __('Imported', 'redux-framework') . "";
            $notice = $this->nokri_ocdi_before_content_import('Demo');
            $notice2 = ($notice != "" ) ? $text : "";
            $allDemos[] = array(
                'import_file_name' => 'Demo' . $notice2,
                'categories' => array('LTR Demo'),
                'local_import_file' => nokri_PLUGIN_PATH . 'demo-data/Demo/content.xml',
                'local_import_widget_file' => nokri_PLUGIN_PATH . 'demo-data/Demo/widgets.json',
                'local_import_customizer_file' => nokri_PLUGIN_PATH . 'demo-data/Demo/customizer.dat',
                'local_import_redux' => array(
                    array('file_path' => nokri_PLUGIN_PATH . 'demo-data/Demo/theme-options.json', 'option_name' => 'nokri',),),
                'import_preview_image_url' => nokri_PLUGIN_URL . 'demo-data/Demo/screen-image.png',
                'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
                'preview_url' => 'https://jobs.nokriwp.com/',
            );
            /* LTR Demo Options */

            /* LTR Demo Options */
            $text = " - " . __('Imported', 'redux-framework') . "";
            $notice = $this->nokri_ocdi_before_content_import('Hindi');
            $notice2 = ($notice != "" ) ? $text : "";
            $allDemos[] = array(
                'import_file_name' => 'Hindi' . $notice2,
                'categories' => array('LTR Demo'),
                'local_import_file' => nokri_PLUGIN_PATH . 'demo-data/Hindi/content.xml',
                'local_import_widget_file' => nokri_PLUGIN_PATH . 'demo-data/Hindi/widgets.json',
                'local_import_customizer_file' => nokri_PLUGIN_PATH . 'demo-data/Hindi/customizer.dat',
                'local_import_redux' => array(
                    array('file_path' => nokri_PLUGIN_PATH . 'demo-data/Hindi/theme-options.json', 'option_name' => 'nokri',),),
                'import_preview_image_url' => nokri_PLUGIN_URL . 'demo-data/Hindi/screen-image.png',
                'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
                'preview_url' => 'https://jobs.nokriwp.com/hindi/',
            );

            /* RTL Demo Options */
            $notice = $this->nokri_ocdi_before_content_import('Arabic');
            $notice2 = ($notice != "" ) ? $text : "";
            $allDemos[] = array(
                'import_file_name' => 'Arabic' . $notice2,
                'categories' => array('RTL Demo'),
                'local_import_file' => nokri_PLUGIN_PATH . 'demo-data/Arabic/content.xml',
                'local_import_widget_file' => nokri_PLUGIN_PATH . 'demo-data/Arabic/widgets.json',
                'local_import_customizer_file' => nokri_PLUGIN_PATH . 'demo-data/Arabic/customizer.dat',
                'local_import_redux' => array(
                    array('file_path' => nokri_PLUGIN_PATH . 'demo-data/Arabic/theme-options.json', 'option_name' => 'nokri',),),
                'import_preview_image_url' => nokri_PLUGIN_URL . 'demo-data/Arabic/screen-image.png',
                'import_notice' => $notice . '' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
                'preview_url' => 'https://jobs.nokriwp.com/rtl/',
            );
            /* RTL Demo Options */
        }
        if (class_exists('Nokri_Elementor')) {
            $text = " - " . __('Imported', 'redux-framework') . "";
            $notice = $this->nokri_ocdi_before_content_import('Demo-elementor');
            $notice2 = ($notice != "" ) ? $text : "";
            $allDemos[] = array(
                'import_file_name' => 'Demo-elementor' . $notice2,
                'categories' => array('LTR Demo'),
                'local_import_file' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor/content.xml',
                'local_import_widget_file' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor/widgets.txt',
                // 'local_import_customizer_file' => nokri_PLUGIN_PATH . 'demo-data/Demo/customizer.dat',
                'local_import_redux' => array(
                    array('file_path' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor/theme-options.txt', 'option_name' => 'nokri',),),
                'import_preview_image_url' => nokri_PLUGIN_URL . 'demo-data/Demo-elementor/screen-image.png',
                'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
                'preview_url' => 'https://elementor.nokriwp.com/',
            );
            $notice = $this->nokri_ocdi_before_content_import('Arabic-elementor');
            $notice2 = ($notice != "" ) ? $text : "";
            $allDemos[] = array(
                'import_file_name' => 'Arabic-elementor' . $notice2,
                'categories' => array('RTL Demo'),
                'local_import_file' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor-Arabic/content.xml',
                'local_import_widget_file' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor-Arabic/widgets.txt',
                //  'local_import_customizer_file' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor-Arabic/customizer.dat',
                'local_import_redux' => array(
                    array('file_path' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor-Arabic/theme-options.txt', 'option_name' => 'nokri',),),
                'import_preview_image_url' => nokri_PLUGIN_URL . 'demo-data/Demo-elementor-Arabic/screen-image.png',
                'import_notice' => $notice . '' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
                'preview_url' => 'https://elementor.nokriwp.com/rtl/',
            );
        }
        return $allDemos;
    }

    function nokri_ocdi_before_content_import($a) {
        $msg = '';
        $fresh_installation = (array) get_option('_nokri_ocdi_demos');
        if (in_array("$a", $fresh_installation)) {
            $msg = __('Note: This demo data is already imported.', 'redux-framework');
            $msg = "<strong style='color:red;'>" . $msg . "</strong><br />";
        }
        return $msg;
    }

    function nokri_ocdi_options($demo_type = array()) {
        if (isset($demo_type)) {
            $fresh_installation = (array) get_option('_nokri_ocdi_demos');
            $result = array_merge($fresh_installation, $demo_type);
            $result = array_unique($result);
            update_option('_nokri_ocdi_demos', $result);
        }
        $fresh_installation = (array) get_option('_nokri_ocdi_demos');
    }

    function nokri_ocdi_after_import($selected_import) {

        //echo "This will be displayed on all after imports!";
        $fresh_installation = get_option('nokri_fresh_installation');
        if ($fresh_installation != 'no') {
            //if($fresh_installation == 'yes'){
            global $wpdb;
            $wpdb->query("TRUNCATE TABLE $wpdb->term_relationships");
            $wpdb->query("TRUNCATE TABLE $wpdb->term_taxonomy");
            $wpdb->query("TRUNCATE TABLE $wpdb->termmeta");
            $wpdb->query("TRUNCATE TABLE $wpdb->terms");
            //}
        }

        if ('Demo' === $selected_import['import_file_name']) {

            //$primary_menu = get_term_by('name', 'Main Navigation', 'nav_menu');
            //if (isset($primary_menu->term_id)) {set_theme_mod('nav_menu_locations', array('main-nav' => $primary_menu->term_id)); }
            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            // Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('Home 3');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                nokri_importing_data('Demo');
            }
            update_option('nokri_fresh_installation', 'no');
            $this->nokri_ocdi_options(array('Demo'));
        }
        if ('Demo-elementor' === $selected_import['import_file_name']) {

            //$primary_menu = get_term_by('name', 'Main Navigation', 'nav_menu');
            //if (isset($primary_menu->term_id)) {set_theme_mod('nav_menu_locations', array('main-nav' => $primary_menu->term_id)); }

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            // Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('Home 3');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                nokri_importing_data('Demo');
            }
            update_option('nokri_fresh_installation', 'no');
            $this->nokri_ocdi_options(array('Demo'));
        }

        if ('Hindi' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            // Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('Home 3');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                nokri_importing_data('Demo');
            }
            update_option('nokri_fresh_installation', 'no');
            $this->nokri_ocdi_options(array('Demo'));
        }
        if ('Arabic' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            // Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('الكاجو مصنفة');
            $blog_page_id = get_page_by_title('مدون');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                nokri_importing_data('Arabic');
            }
            update_option('nokri_fresh_installation', 'no');
            $this->nokri_ocdi_options(array('Arabic'));
        }
        if ('Arabic-elementor' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            // Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('الكاجو مصنفة');
            $blog_page_id = get_page_by_title('مدون');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                nokri_importing_data('Arabic');
            }
            update_option('nokri_fresh_installation', 'no');
            $this->nokri_ocdi_options(array('Arabic'));
        }

        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/');
    }

    function nokri_ocdi_plugin_intro_text($default_text) {
        $default_text .= '<div class="ocdi__intro-text"><h4 id="before">Before Importing Demo</h4>
	<p><strong>Before importing one of the demos available it is advisable to check the following list</strong>. <br />All these queues are important and will ensure that the import of a demo ends successfully. In the event that something should go wrong with your import, open a ticket and <a href="https://scriptsbundle.ticksy.com/" target="_blank">contact our Technical Support</a>.</p>
	<ul>
	<li><strong>Theme Activation</strong> – Please make sure to activate the theme to be able to access the demo import section</li>
	<li><strong>Required Plugins</strong> – Install and activate all required plugins</li>
	<li><strong>Other Plugins</strong> – Is recommended to <strong>disable all other plugins that are not required</strong>. Such as plugins to create coming soon pages, plugins to manage the cache, plugin to manage SEO, etc &#8230; You will reactivate your personal plugins later as soon as the import process is finished</li>
	</ul>
	<h4>Requirements for demo importing</h4>
	<p>To correctly import a demo please make sure that your hosting is running the following features:</p>
	<p><strong>WordPress Requirements</strong></p>
	<ul>
	<li>WordPress 4.6+</li>
	<li>PHP 5.6+</li>
	<li>MySQL 5.6+</li>
	</ul>
	<p><strong>Recommended PHP configuration limits</strong></p>
	<p>*If the import stalls and fails to respond after a few minutes it because your hosting is suffering from PHP configuration limits. You should contact your hosting provider and ask them to increase those limits to a minimum as follows:</p>
	<ul>
	<li>max_execution_time 3000</li>
	<li>memory_limit 256M</li>
	<li>post_max_size 100M</li>
	<li>upload_max_filesize 81M</li>
	</ul></div>
	<p><strong>*Please note that you can import 1 demo data select it carefully.</strong></p>
	<hr />';

        return $default_text;
    }

}

$nokri_demo_ocdi = new Nokri_Demo_OCDI();

/* * *************************************** */
/* Nokri taxonomies custom feilds function */
/* * *************************************** */
if (!function_exists('nokri_get_term_form')) {

    function nokri_get_term_form($term_id = '', $post_id = '', $formType = 'dynamic', $is_array = '') {

        global $nokri;
        $data = ($formType == 'dynamic' && $term_id != "") ? sb_text_field_value($term_id) : sb_getTerms('custom');
        if ($is_array == 'arr')
            return $data;
        $dataHTML = '';
        foreach ($data as $d) {
            $name = $d['name'];
            $slug = $d['slug'];
            if ($formType == 'static') {
                $showme = 1;
                if (isset($nokri["allow_job_tags"]) && $slug == 'job_tags') {
                    $showme = $nokri["allow_job_tags"];
                }
                if (isset($nokri["allow_job_type"]) && $slug == 'job_type') {
                    $showme = $nokri["allow_job_type"];
                }
                if (isset($nokri["allow_job_qualifications"]) && $slug == 'job_qualifications') {
                    $showme = $nokri["allow_job_qualifications"];
                }
                if (isset($nokri["allow_job_level"]) && $slug == 'job_level') {
                    $showme = $nokri["allow_job_level"];
                }
                if (isset($nokri["allow_job_salary"]) && $slug == 'job_salary') {
                    $showme = $nokri["allow_job_salary"];
                }
                if (isset($nokri["allow_job_salary_type"]) && $slug == 'job_salary_type') {
                    $showme = $nokri["allow_job_salary_type"];
                }
                if (isset($nokri["allow_job_skills"]) && $slug == 'job_skills') {
                    $showme = $nokri["allow_job_skills"];
                }
                if (isset($nokri["allow_job_experience"]) && $slug == 'job_experience') {
                    $showme = $nokri["allow_job_experience"];
                }
                if (isset($nokri["allow_job_currency"]) && $slug == 'job_currency') {
                    $showme = $nokri["allow_job_currency"];
                }
                $is_show = $showme;
                $is_this_req = 1;
            } else {
                $is_show = $d['is_show'];
                $is_this_req = $d['is_req'];
            }
            $is_req = $is_this_req;
            $is_search = $d['is_search'];
            $is_type = $d['is_type'];
            $required = (isset($is_req) && $is_req == 1 ) ? ' required="required"' : '';
            if ($is_show == 1) {
                if ($slug == 'job_tags') {
                    $is_type = 'textfield';
                }
                if ($is_type == 'textfield') {
                    $inputVal = get_post_meta($post_id, '_' . $slug, true);
                    if ($slug == 'job_tags') {
                        $tags_array = wp_get_object_terms($post_id, 'job_tags', array('fields' => 'names'));
                        $inputVal = implode(',', $tags_array);
                    }
                    $select_col = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
                    if ($slug == 'job_tags') {
                        $select_col = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
                    };
                    $dataHTML .= '<div class="' . esc_attr($select_col) . '">
                         		  <div class="form-group">
                          		  <label>' . ucfirst($name) . '</label>
								  <input class="form-control" name="' . $slug . '" id="' . $slug . '" value="' . $inputVal . '" ' . $required . ' /></div></div>';
                } else {
                    $values = nokri_get_cats($slug, 0);
                    if (!empty($values) && count((array) $values) > 0) {
                        $multiple = '';
                        $select_name = $slug;
                        $select_col = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
                        if ($slug == 'job_skills') {
                            $multiple = 'multiple';
                            $select_name = 'job_skills[]';
                            $select_col = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
                        };
                        $dataHTML .= '<div class="' . esc_attr($select_col) . '">
							  			 <div class="form-group">
							  			 <label>' . $name . '</label>
							  			 <select class="category form-control" id="' . $slug . '" name="' . $select_name . '" ' . $required . ' data-parsley-error-message="' . esc_html__('This field is required', 'redux-framework') . ' " ' . $multiple . '>
										<option value="">' . esc_html__('Select Option', 'redux-framework') . '</option>';
                        foreach ($values as $val) {
                            if (isset($val->term_id) && $val->term_id != "") {
                                $id = $val->term_id;
                                $name = $val->name;
                                $job_tax = wp_get_post_terms($post_id, $slug, array("fields" => "ids"));
                                $job_tax = isset($job_tax[0]) ? $job_tax[0] : '';
                                $job_skills = wp_get_post_terms($post_id, 'job_skills', array("fields" => "ids"));
                                $selected = ( $job_tax == $val->term_id ) ? 'selected="selected"' : '';
                                if ($slug == 'job_skills') {
                                    if (in_array($val->term_id, $job_skills)) {
                                        $selected = 'selected="selected"';
                                    }
                                }
                                $dataHTML .= '<option value="' . $id . '"' . $selected . '>' . $name . '</option>';
                            }
                        }
                        $dataHTML .= '</select></div></div>';
                    }
                }
            }
        }
        return $dataHTML;
    }

}
/* Nokri static form */
if (!function_exists('nokri_get_static_form')) {

    function nokri_get_static_form($term_id = '', $post_id = '') {
        $html = '';
        $display_size = '';
        $price = '';
        $required = '';
        global $nokri;
        $size_arr = explode('-', $nokri['sb_upload_attach_size']);
        $display_size = $size_arr[1];
        $actual_size = $size_arr[0];

        $vals[] = array(
            'type' => 'textfield',
            'post_meta' => '_job_video',
            'is_show' => '_sb_default_cat_video_show',
            'is_req' => '_sb_default_cat_video_required',
            'main_title' => esc_html__('Youtube Video Link', 'redux-framework'),
            'sub_title' => '',
            'field_name' => 'job_video',
            'field_id' => 'job_video',
            'field_value' => '',
            'field_req' => $required,
            'cat_name' => '',
            'field_class' => '',
            'columns' => '12',
            'data-parsley-type' => 'url',
            'data-parsley-message' => esc_html__('This field is required.', 'redux-framework'),
        );
        $vals[] = array(
            'type' => 'image',
            'post_meta' => '',
            'is_show' => '_sb_default_cat_image_show',
            'is_req' => '_sb_default_cat_image_required',
            'main_title' => esc_html__('Click the box below to upload job attachments!', 'redux-framework'),
            'sub_title' => esc_html__('upload with a max file size of ', 'redux-framework') . $display_size,
            'field_name' => 'dropzone',
            'field_id' => 'dropzone_custom',
            'field_value' => '',
            'field_req' => $required,
            'cat_name' => '',
            'field_class' => ' dropzone',
            'columns' => '12',
            'data-parsley-type' => '',
            'data-parsley-message' => esc_html__('This field is required.', 'redux-framework'),
        );
        foreach ($vals as $val) {
            $type = $val['type'];
            $html .= nokri_return_input($type, $post_id, $term_id, $val);
        }

        return $html;
    }

}
/* Input For More Custom Inputs */
if (!function_exists('nokri_more_inputs')) {

    function nokri_more_inputs() {
        $r['job_posts']['name'] = esc_html__('Number of vacancies', 'redux-framework');
        $r['job_posts']['slug'] = 'job_posts';
        $r['job_posts']['is_show'] = '1';
        $r['job_posts']['is_req'] = '1';
        $r['job_posts']['is_search'] = '1';
        $r['job_posts']['is_type'] = 'textfield';
        return $r;
    }

}
// importing indeed jobs 
add_action('wp_ajax_sb_import_indeed_job', 'sb_import_indeed_job_fun');
add_action('wp_ajax_sb_import_indeed_job', 'sb_import_indeed_job_fun');

function sb_import_indeed_job_fun() {
    $params = array();
    parse_str($_POST['sb_indeed_param'], $params);
    global $nokri;
    $publisher_id = isset($params['pub_id']) ? $params['pub_id'] : '';
    $job_keyword = isset($params['job_keyword']) ? $params['job_keyword'] : '';
    $job_country = isset($params['job_country']) ? $params['job_country'] : '';
    $job_location = isset($params['job_location']) ? $params['job_location'] : '';
    $job_type = isset($params['job_type']) ? $params['job_type'] : '';
    $sort_by = isset($params['sort_by']) ? $params['sort_by'] : '';
    $jobs_num = isset($params['jobs_num']) ? $params['jobs_num'] : '';
    $job_expiry = isset($params['job_date']) ? $params['job_date'] : '';
    $jobs_by = isset($params['jobs_by']) ? $params['jobs_by'] : '';
    $user_agent = esc_url($_SERVER['HTTP_USER_AGENT']);

    $default_jobs_num = isset($params['jobs_num_default']) ? $params['jobs_num_default'] : '';

    if ($jobs_num == '') {

        $jobs_num = $default_jobs_num;
    }
    $api_url = "https://api.indeed.com/ads/apisearch/";

    if ($publisher_id == '') {
        echo '0|' . __("Please add valid publisher id.", 'redux-framework');
        die();
    }
    if ($job_keyword == '') {
        echo '1|' . __("Please add keyword to search job.", 'redux-framework');
        die();
    }
    if ($job_country == '') {
        echo '2|' . __("Please Select country first.", 'redux-framework');
        die();
    }
    $final_url = "https://api.indeed.com/ads/apisearch?publisher=$publisher_id&q=$job_keyword&l=$job_location&sort=$sort_by&radius=&st=&jt=$job_type&start=&limit=$jobs_num&format=json&fromage=&filter=&latlong=1&co=$job_country&chnl=&userip=1.2.3.4&useragent=$user_agent&v=2";

    $request = wp_remote_get($final_url);
    $req_body = wp_remote_retrieve_body($request);

    if (is_wp_error($request)) {
        echo '3|' . __("Something went wrong.", 'redux-framework');
        die();
    }

    $data = json_decode($req_body);

    $job_arr = array();
    $jobs_result = isset($data->results) ? $data->results : array();
    $jobs_found = count($jobs_result);
    if ($jobs_found == '') {
        echo '4|' . __("No job found.", 'redux-framework');
        die();
    } else {
        foreach ($jobs_result as $job) {

            $job_title = isset($job->jobtitle) ? $job->jobtitle : '';
            $job_desc = isset($job->snippet) ? $job->snippet : '';
            $job_url = isset($job->url) ? $job->url : '';
            $job_latitude = isset($job->latitude) ? $job->latitude : '';
            $job_longitude = isset($job->longitude) ? $job->longitude : '';
            $job_location = isset($job->formattedLocationFull) ? $job->formattedLocationFull : '';

            $job_id = wp_insert_post(array(
                'post_title' => $job_title,
                'post_type' => 'job_post',
                'post_content' => $job_desc,
                'post_status' => 'publish',
            ));
            if ($job_expiry != '') {
                update_post_meta($job_id, '_job_date', $job_expiry);
            }
            if ($job_latitude != '') {
                update_post_meta($job_id, '_job_lat', $job_latitude);
            }
            if ($job_longitude != '') {
                update_post_meta($job_id, '_job_long', $job_longitude);
            }
            if ($job_location != '') {
                update_post_meta($job_id, 'job_format_location', $job_location);
            }
            if ($job_url != '') {
                update_post_meta($job_id, '_job_apply_with', 'exter');
                update_post_meta($job_id, '_job_apply_url', $job_url);
            }
            update_post_meta($job_id, '_job_status', 'active');
            $job_arr[] = $job_id;
        }
    }
    $posted_jobs = count($job_arr);
    if ($posted_jobs > 0) {
        echo '5|' . __("$posted_jobs jobs has been imported.", 'redux-framework');
    }
    die();
}

add_action('wp', 'nokri_remove_admin_bar');

if (!function_exists('nokri_remove_admin_bar')) {

    function nokri_remove_admin_bar() {
        global $nokri;
        $admin_bar_check = isset($nokri['admin_top_bar_switch']) ? $nokri['admin_top_bar_switch'] : "";
        if ($admin_bar_check) {

            if (is_user_logged_in()) {
                show_admin_bar(false);
            }
        } else {
            show_admin_bar(true);
        }
    }

}
//set paid alert 
add_action('woocommerce_new_order_item', 'add_order_item_meta', 10, 2);

function add_order_item_meta($item_id, $values) {
    global $nokri;
    $is_paid = isset($nokri['job_alert_paid_switch']) ? $nokri['job_alert_paid_switch'] : false;
    $user_id = get_current_user_id();
    $alert_data = get_user_meta($user_id, 'temp_test_alert', true);
    if ($is_paid && $alert_data != "") {
        $key = 'temp_alert';
        wc_update_order_item_meta($item_id, $key, $alert_data);
    }
}

/* Admin Dashboard Statistics/Graph of total compnay Data */
add_filter('pre_get_document_title', 'nokri_change_job_archive_title', 9999);

/**
 * Add a new dashboard widget.
 */
function nokri_add_dashboard_widgets() {

    wp_add_dashboard_widget('dashboard_widget', 'Complete Data', 'nokri_dashboard_statistics');
}

add_action('wp_dashboard_setup', 'nokri_add_dashboard_widgets');

/**
 * Output the contents of the dashboard widget
 */
function nokri_dashboard_statistics() {

    //Total published posts
    $count_posts = wp_count_posts();
    $published_posts = $count_posts->publish;

    //Total no of users
    $result = count_users();
    $total_users = $result['total_users'];

    //Total no of subscribers
    $total_subscribers = count(get_users(array('role' => 'subscriber')));

    //Getting Total Employers
    $employer_qry = array(
        'key' => '_sb_reg_type',
        'value' => '1',
        'compare' => '='
    );
    $order = 'DESC';
    $orderby = 'meta_value';

    // Query args
    $argssss = array(
        'order' => $order,
        'orderby' => array(
            $orderby,
            'registered',
        ),
        'role__in' => array('editor', 'administrator', 'subscriber'),
        'meta_query' => array(array(
                'relation' => 'OR',
            ),
            array(
                'key' => '_sb_is_member',
                'compare' => 'NOT EXISTS'
            ),
            $employer_qry
        )
    );
    // Create the WP_User_Query object
    $wp_user_query = new WP_User_Query($argssss);
    // Get the results
    $total_reg_employer = $wp_user_query->get_total();

    //Getting Total Candiddates
    $candidate_qry = array(
        'key' => '_sb_reg_type',
        'value' => '0',
        'compare' => '='
    );
    $order = 'DESC';
    $orderby = 'meta_value';

    // Query args
    $argss = array(
        'order' => $order,
        'orderby' => array(
            $orderby,
            'registered',
        ),
        'role__in' => array('editor', 'administrator', 'subscriber'),
        'meta_query' => array(array(
                'relation' => 'OR',
            ),
            array(
                'key' => '_sb_is_member',
                'compare' => 'NOT EXISTS'
            ),
            $candidate_qry
        )
    );
    // Create the WP_User_Query object
    $wp_cand_query = new WP_User_Query($argss);
    // Get the results
    $total_reg_cands = $wp_cand_query->get_total();

    //Getting Total Employer Members
    $members_qry = array(
        'key' => '_sb_is_member',
        'value' => '1',
        'compare' => '='
    );
    $order = 'DESC';
    $orderby = 'meta_value';

    // Query args
    $args = array(
        'order' => $order,
        'orderby' => array(
            $orderby,
            'registered',
        ),
        'role__in' => array('editor', 'administrator', 'subscriber'),
        'meta_query' => array(array(
                'relation' => 'OR',
            ),
            $members_qry
        )
    );
    // Create the WP_User_Query object
    $wp_mem_query = new WP_User_Query($args);
    // Get the results
    $employer_members = $wp_mem_query->get_total();
    ?>
    <div class="container" id="chartcontainer">
        <canvas id="myChart" style="position: relative; height:50vh; width:25vw"></canvas>
    </div>
    <script language="Javascript">

        let myChart = document.getElementById('myChart').getContext('2d');
        // Global Options
        Chart.defaults.global.responsive = true;
        Chart.defaults.global.defaultFontFamily = 'Times';
        Chart.defaults.global.defaultFontSize = 15;
        Chart.defaults.global.defaultFontColor = '#000';
        var no_of_published_jobs = '<?php echo esc_attr($published_posts); ?>';
        var no_of_users = '<?php echo esc_attr($total_users); ?>';
        var no_of_subscribers = '<?php echo esc_attr($total_subscribers); ?>';
        var reg_employers = '<?php echo esc_attr($total_reg_employer); ?>';
        var reg_candidates = '<?php echo esc_attr($total_reg_cands); ?>';
        var reg_members = '<?php echo esc_attr($employer_members); ?>';
        let massPopChart = new Chart(myChart, {
            type: 'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
            data: {
                labels: ['<?php echo esc_html__('Published Jobs', 'nokri'); ?>', '<?php echo esc_html__('Total Users', 'nokri'); ?>', '<?php echo esc_html__('Subscribers', 'nokri'); ?>', '<?php echo esc_html__('Registered Companies', 'nokri'); ?>', '<?php echo esc_html__('Registered Candidates', 'nokri'); ?>', '<?php echo esc_html__('Employers Members', 'nokri'); ?>'],
                datasets: [{
                        label: '<?php echo esc_html__('', 'nokri'); ?>',
                        data: [
                            no_of_published_jobs,
                            no_of_users,
                            no_of_subscribers,
                            reg_employers,
                            reg_candidates,
                            reg_members
                        ],
                        //backgroundColor:'green',
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.4)',
                            'rgba(54, 162, 235, 0.4)',
                            'rgba(255, 206, 86, 0.4)',
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(255, 159, 64, 0.4)'
                        ],
                        borderWidth: 1,
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        hoverBorderWidth: 1,
                    }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Company Statistics',
                    fontSize: 25,
                    fontColor: '#000'
                },
                legend: {
                    display: false,
                    labels: {
                        fontColor: '#000',
                    }
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        bottom: 0,
                        top: 0
                    }

                },
                tooltips: {
                    enabled: true
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>
    <?php
}

/* Function Admin for Dashboard Documentation Links */
if (!function_exists('nokri_admin_dashboard_section')) {

    function nokri_admin_dashboard_section() {
        global $pagenow;
        if ($pagenow != "index.php") {
            return '';
        }
        ?>
        <div class="wr-ap">
            <br />
            <div id="welcome-panel" class="welcome-panel">
                <div class="welcome-panel-content">
                    <h2><?php esc_html_e("Nokri - Classified WordPress Theme", "nokri"); ?></h2>
                </div>
                <div class="welcome-panel-column-container">
                    <div class="welcome-panel-column">
                        <h3><?php esc_html_e("Get Started", "nokri"); ?></h3>
                        <p>
                            <?php esc_html_e("Docementation will helps you to understand the theme flow and will help you to setup the theme accordingly. Click the button below to go to the docementation.", "nokri"); ?></p>
                        <a class="button button-primary button-hero load-customize hide-if-no-customize" href="https://documentation.scriptsbundle.com/"  target="_blank"><?php esc_html_e("Docementation", "nokri"); ?></a>
                    </div>
                    <div class="welcome-panel-column">
                        <h3><?php esc_html_e("Having Issues? Get Support!", "nokri"); ?></h3>
                        <p>
                            <?php esc_html_e("If you are facing any issue regarding setting up the theme. You can contact our support team they will be very happy to assist you.", "nokri"); ?></p>
                        <a class="button button-primary button-hero load-customize hide-if-no-customize" href="https://scriptsbundle.ticksy.com/"  target="_blank"><?php esc_html_e("Get Theme Support", "nokri"); ?></a>                    
                    </div>
                    <div class="welcome-panel-column welcome-panel-last">
                        <h3><?php esc_html_e("Looking For Customizations?", "nokri"); ?></h3>
                        <?php esc_html_e("Looking to add more features in the theme no problem. Our development team will customize the theme according to your requirnments. Click the link below to contact us.", "nokri"); ?></p>
                        <a class="button button-primary button-hero load-customize hide-if-no-customize" href="https://scriptsbundle.com/freelancer/"  target="_blank"><?php esc_html_e("Looking For Customization?", "nokri"); ?></a>  
                    </div>
                </div>
                <br />
                <p class="hide-if-no-customize">
                    <?php esc_html_e("by", "nokri"); ?>, <a href="https://themeforest.net/user/scriptsbundle/portfolio" target="_blank"><?php esc_html_e("ScriptsBundle", "nokri"); ?></a>
                </p>

            </div>
        </div>
        <?php
    }

    add_action('admin_notices', 'nokri_admin_dashboard_section');
}