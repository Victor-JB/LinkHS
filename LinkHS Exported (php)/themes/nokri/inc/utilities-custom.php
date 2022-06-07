<?php
/* ========================= */
/* Time Ago Function */
/* ========================= */
if (!function_exists('nokri_time_ago')) {

    function nokri_time_ago() {
        return human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
    }

}

if (!function_exists('nokri_get_echoVal')) {

    function nokri_get_echoVal($value = '') {
        return $value;
    }

}
if (!function_exists('nokri_getBGStyle')) {

    function nokri_getBGStyle($optname = '') {
        if ($optname == '')
            return '';
        global $nokri;
        $bg_size = '';
        $bg_attachment = '';
        $bg_repeat = '';
        $bg_position = '';
        $bgarea = $nokri["$optname"];
        $bg_img = '\\s\\t\\y\\l\\e="';

        if (isset($bgarea['background-color']) && $bgarea['background-color'] != "") {
            $bg_img .= ' background: ' . $bgarea['background-color'] . ';';
        }
        if (isset($bgarea['background-image']) && $bgarea['background-image'] != "") {
            $bg_size = $bgarea['background-size'];
            $bg_attachment = $bgarea['background-attachment'];
            $bg_repeat = $bgarea['background-repeat'];
            $bg_position = $bgarea['background-position'];
            $bg_img .= ' background: url(' . $bgarea['background-image'] . '); ';
            $bg_img .= ' background-repeat: ' . $bg_repeat . ';';
            $bg_img .= ' background-size: ' . $bg_size . '; ';
            $bg_img .= ' background-position: ' . $bg_position . '; ';
            $bg_img .= ' background-attachment: ' . $bg_attachment . '; ';
        }
        $bg_img .= '"';
        return str_replace('\\', "", $bg_img);
    }

}
if (!function_exists('nokri_user_cover_bg_url')) {

    function nokri_user_cover_bg_url($optname = '') {
        if ($optname == '')
            return '';

        $bg_repeat = "no-repeat";
        $bg_size = "cover";
        $bg_position = "center center";
        $bg_attachment = "scroll";
        $bg_img = '\\s\\t\\y\\l\\e="';
        $bg_img .= ' background: url(' . wp_get_attachment_url($optname) . '); ';
        $bg_img .= ' background-repeat: ' . $bg_repeat . ';';
        $bg_img .= ' background-size: ' . $bg_size . '; ';
        $bg_img .= ' background-position: ' . $bg_position . '; ';
        $bg_img .= ' background-attachment: ' . $bg_attachment . '; ';
        $bg_img .= '"';
        return str_replace('\\', "", $bg_img);
    }

}

if (!function_exists('nokri_valid_json')) {

    function nokri_valid_json($json) {
        return is_array(json_decode($json, true)) ? true : false;
    }

}
/* Employer Dashboard */
if (!function_exists('nokri_employer_dashboard')) {

    function nokri_employer_dashboard($heading = '', $key = '', $des = '') {
        global $nokri;
        $current_user = wp_get_current_user();
        $user_id = get_current_user_id();
        $type = $detail = '';
        if ($key == 'email') {
            $type .= '<dt>' . $heading . '</dt><dd>' . $current_user->user_email . '</dd>';
        }
        if (get_user_meta($user_id, $key, true) != '' && $des != 'yes') {

            $response = get_user_meta($user_id, $key, true);
            $t = nokri_valid_json($response);
            $value = '';
            if ($t) {
                $response = json_decode($response, true);

                foreach ($response as $r) {
                    $term = get_term($r, 'job_category');
                    $value .= $term->name . ', ';
                }
                $value = rtrim($value, ", ");
            } else {
                $value = $response;
            }
            $type .= '<dt>' . $heading . '</dt><dd>' . $value . '</dd>';
        } else if ($des == 'yes') {
            $type .= '<div class="heading-inner"><p class="title">' . $heading . '</p></div><p>' . get_user_meta($user_id, $key, true) . '</p>';
        }
        return $type;
    }

}
/* Employer Social Icons */
if (!function_exists('nokri_employer_dashboard_socail_links')) {

    function nokri_employer_dashboard_socail_links() {
        global $nokri;
        $current_user = wp_get_current_user();
        $user_id = get_current_user_id();
        $icons = '';
        if (get_user_meta($user_id, '_emp_fb', true) != '') {
            $icons .= '<li><a href="' . get_user_meta($user_id, '_emp_fb', true) . '" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>';
        }
        if (get_user_meta($user_id, '_emp_twitter', true) != '') {
            $icons .= '<li><a href="' . get_user_meta($user_id, '_emp_twitter', true) . '" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>';
        }
        if (get_user_meta($user_id, '_emp_linked', true) != '') {
            $icons .= '<li><a href="' . get_user_meta($user_id, '_emp_linked', true) . '" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>';
        }
        if (get_user_meta($user_id, '_emp_google', true) != '') {
            $icons .= '<li><a href="' . get_user_meta($user_id, '_emp_google', true) . '" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>';
        }
        return '<div class="resume-social">
                <ul class="social-network social-circle onwhite">
                    ' . $icons . '
                </ul>
             </div>';
    }

}
/* Employer Side Navigation Pages */
if (!function_exists('nokri_employer_dashboard_side_links')) {

    function nokri_employer_dashboard_side_links() {
        global $nokri;
        $emp_side_edit = '';
        if ((isset($nokri['sb_emp_edit_profile'])) && $nokri['sb_emp_edit_profile'] != '') {
            $emp_side_edit = ($nokri['sb_emp_edit_profile']);
        }
        return '<li class="active"><a href="' . get_the_permalink($emp_side_edit) . '"><i class="fa fa-user"></i>' . esc_html__('Edit Profile', 'nokri') . '</a></li>';
    }

}
/* Employer Getting Simple Jobs */
if (!function_exists('nokri_simple_jobs')) {

    function nokri_simple_jobs($is_expire = '') {
        $current_id = get_current_user_id();
        /* Checking if Employer have Account Members with job posting permissions */
        $emp_id = get_user_meta($current_id, 'account_owner', true);
        $member_id = get_user_meta($current_id, '_sb_is_member', true);
        if (isset($member_id) && $member_id != '') {
            $user_id = $emp_id;
        } else {
            $user_id = $current_id;
        }
        $args = array(
            'taxonomy' => 'job_class',
            'order' => 'ASC',
            'hide_empty' => false,
            'hierarchical' => false,
            'parent' => 0,
        );
        $job_terms = get_terms($args);
        /* Getting Simple Job Class Value */
        $simple_job_id = $term_id = '';
        foreach ($job_terms as $job_term) {
            $term_id = nokri_get_origional_term_id($job_term->term_id);
            if ($is_expire) {
                $meta_name = 'package_job_class_' . $term_id;
                $job_class = update_user_meta($user_id, $meta_name, '');
            } else {
                if (get_term_meta($term_id, 'emp_class_check', true) == '1') {
                    $simple_job_id = $term_id;
                    break;
                }
            }
        }
        return $simple_job_id;
    }

}
/* Employer Package Expired Notification */
if (!function_exists('nokri_employer_package_expire_notify')) {

    function nokri_employer_package_expire_notify() {
        $user_id = get_current_user_id();
        $pkg_message = '';
        $job_class_free = nokri_simple_jobs();
        $regular_jobs = get_user_meta($user_id, 'package_job_class_' . $job_class_free, true);
        if ($regular_jobs == '') {
            $pkg_message = 're';
        }
        $expiry_date = get_user_meta($user_id, '_sb_expire_ads', true);
        $today = date("Y-m-d");
        $expiry_date_string = strtotime($expiry_date);
        $today_string = strtotime($today);
        if ($expiry_date != '-1') {
            if ($today_string > $expiry_date_string) {
                $pkg_message = 'pe';
            }
        }
        if ($expiry_date == '') {
            $pkg_message = 'np';
        }
        return $pkg_message;
    }

}
/* Candidate Package Expired Notification */
if (!function_exists('nokri_candidate_package_expire_notify')) {

    function nokri_candidate_package_expire_notify() {
        $user_id = get_current_user_id();
        $pkg_message = '';
        $applied_jobs = get_user_meta($user_id, '_candidate_applied_jobs', true);
        if ($applied_jobs == '' || $applied_jobs == '0') {
            $pkg_message = 'ae';
        }
        $expiry_date = get_user_meta($user_id, '_sb_expire_ads', true);
        $today = date("Y-m-d");
        $expiry_date_string = strtotime($expiry_date);
        $today_string = strtotime($today);
        if ($expiry_date != '-1') {
            if ($today_string > $expiry_date_string) {
                $pkg_message = 'pe';
                update_user_meta($user_id, '_candidate_applied_jobs', '0');
                update_user_meta($user_id, '_candidate_feature_profile', '');
            }
        }
        if ($expiry_date == '') {
            $pkg_message = 'np';
        }
        return $pkg_message;
    }

}
/* Resume access package check */
if (!function_exists('nokri_resume_access_package_check')) {

    function nokri_resume_access_package_check() {
        $user_id = get_current_user_id();
        $pkg_message = 'ac';
        $res_access = get_user_meta($user_id, '_sb_cand_search_value', true);
        if ($res_access == '' || $res_access == '0') {
            $pkg_message = 'ae';
        }
        $expiry_date = get_user_meta($user_id, '_sb_expire_ads', true);
        $today = date("Y-m-d");
        $expiry_date_string = strtotime($expiry_date);
        $today_string = strtotime($today);
        if ($today_string > $expiry_date_string) {
            $pkg_message = 'pe';
            update_user_meta($user_id, '_sb_cand_search_value', '0');
        }
        if ($expiry_date == '') {
            $pkg_message = 'np';
        }
        if ($res_access == '-1') {
            $pkg_message = 'en';
        }
        return $pkg_message;
    }

}
if (!function_exists('nokri_randomString')) {

    function nokri_randomString($length = 50) {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count((array) $characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

}
/* Load Search Countries */
if (!function_exists('nokri_load_search_countries')) {

    function nokri_load_search_countries($action_on_complete = '') {
        global $nokri;
        $stricts = '';
        if (isset($nokri['sb_location_allowed']) && !$nokri['sb_location_allowed'] && isset($nokri['sb_list_allowed_country'])) {
            $stricts = "componentRestrictions: {country: " . json_encode($nokri['sb_list_allowed_country']) . "}";
        }


        echo "<script>
       function nokri_location() {
      var input = document.getElementById('sb_user_address');
      var action_on_complete    =   '" . $action_on_complete . "';
      var options = { " . $stricts . "
 };     
      var autocomplete = new google.maps.places.Autocomplete(input, options);
      if( action_on_complete )
      {
       new google.maps.event.addListener(autocomplete, 'place_changed', function() {
      // document.getElementById('sb_loading').style.display    = 'block';
    var place = autocomplete.getPlace();
    document.getElementById('ad_map_lat').value = place.geometry.location.lat();
    document.getElementById('ad_map_long').value = place.geometry.location.lng();
    var markers = [
        {
            'title': '',
            'lat': place.geometry.location.lat(),
            'lng': place.geometry.location.lng(),
        },
    ];
    
    my_g_map(markers);
    //document.getElementById('sb_loading').style.display   = 'none';
});
       }
   }
   
   </script>";
    }

}
/* Getting All Countries */
if (!function_exists('nokri_get_all_countries')) {

    function nokri_get_all_countries() {
        $args = array(
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'post_type' => '_sb_country',
            'post_status' => 'publish',
        );
        $countries = get_posts($args);
        $res = array();
        foreach ($countries as $country) {
            $res[$country->post_excerpt] = $country->post_title;
        }
        return $res;
    }

}
if (!function_exists('nokri_make_link')) {

    function nokri_make_link($url, $text) {
        return wp_kses("<a href='" . esc_url($url) . "' target='_blank'>", nokri_required_tags()) . $text . wp_kses('</a>', nokri_required_tags());
    }

}
if (!function_exists('nokri_required_tags')) {

    function nokri_required_tags() {
        return $allowed_tags = array(
            'div' => nokri_required_attributes(),
            'span' => nokri_required_attributes(),
            'p' => nokri_required_attributes(),
            'a' => array_merge(nokri_required_attributes(), array(
                'href' => array(),
                'target' => array('_blank', '_top'),
            )),
            'u' => nokri_required_attributes(),
            'br' => nokri_required_attributes(),
            'i' => nokri_required_attributes(),
            'q' => nokri_required_attributes(),
            'b' => nokri_required_attributes(),
            'ul' => nokri_required_attributes(),
            'ol' => nokri_required_attributes(),
            'li' => nokri_required_attributes(),
            'br' => nokri_required_attributes(),
            'hr' => nokri_required_attributes(),
            'strong' => nokri_required_attributes(),
            'blockquote' => nokri_required_attributes(),
            'del' => nokri_required_attributes(),
            'strike' => nokri_required_attributes(),
            'em' => nokri_required_attributes(),
            'code' => nokri_required_attributes(),
            'style' => nokri_required_attributes(),
            'script' => nokri_required_attributes(),
            'img' => nokri_required_attributes(),
        );
    }

}
if (!function_exists('nokri_required_attributes')) {

    function nokri_required_attributes() {
        return $default_attribs = array(
            'id' => array(),
            'src' => array(),
            'href' => array(),
            'target' => array(),
            //      'class' => array(),
            'title' => array(),
            'type' => array(),
            'style' => array(),
            'data' => array(),
            'role' => array(),
            'aria-haspopup' => array(),
            'aria-expanded' => array(),
            'data-toggle' => array(),
            'data-hover' => array(),
            'data-animations' => array(),
            'data-mce-id' => array(),
            'data-mce-style' => array(),
            'data-mce-bogus' => array(),
            'data-href' => array(),
            'data-tabs' => array(),
            'data-small-header' => array(),
            'data-adapt-container-width' => array(),
            'data-height' => array(),
            'data-hide-cover' => array(),
            'data-show-facepile' => array(),
        );
    }

}
/* Getting Selected Taxonomies Name */
if (!function_exists('nokri_job_post_taxonomies')) {

    function nokri_job_post_taxonomies($taxonomy_name = '', $value = '') {

        $id = 'job_skills' == $taxonomy_name ? 'name' : 'id';

        $taxonomies = get_terms($taxonomy_name, array('hide_empty' => false, 'orderby' => $id, 'order' => 'ASC', 'parent' => 0));
        $option = '';
        if (count((array) $taxonomies) > 0) {
            foreach ($taxonomies as $taxonomy) {
                $selected = ( $value == $taxonomy->term_id ) ? 'selected="selected"' : '';
                $option .= '<option value="' . esc_attr($taxonomy->term_id) . '" ' . $selected . '>' . esc_html($taxonomy->name) . '</option>';
            }
        }
        return $option;
    }

}
/* * ******************************************* */
/* Getting Checkbox Taxonomies From Widget   */
/* * ******************************************* */
if (!function_exists('nokri_job_search_taxonomies_checkboxes')) {

    function
    nokri_job_search_taxonomies_checkboxes($taxonomy_name = '', $instance = array()) {
        $max_record = $title = '';
        $max_record = $instance['no_of_records'] ? $instance['no_of_records'] : 3;
        $is_open = $instance['is_open'] == 'open' ? 'in' : '';
        $is_show = true;
        if (isset($_GET[$taxonomy_name]) && $_GET[$taxonomy_name] != "") {
            $is_show = false;
            $is_open = 'in';
        }
        global $nokri;
        $taxonomies = get_terms($taxonomy_name, array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC', 'parent' => 0));
        $option = '';
        $more_html = '';
        $multi_searach = ( isset($nokri['multi_job_search_form']) && $nokri['multi_job_search_form'] != "" ) ? $nokri['multi_job_search_form'] : false;

        $search_class = "input-icheck-search";

        if ($multi_searach) {

            $search_class = "input-icheck-search-custom";
        }

        if (count((array) $taxonomies) > 0) {
            $count = 1;
            $showed = true;
            foreach ($taxonomies as $taxonomy) {

                /* Skipping Free Job Class */
                $emp_class_check = get_term_meta($taxonomy->term_id, 'emp_class_check', true);
                if ($emp_class_check == 1) {
                    continue;
                }
                $selected = '';
                if (isset($_GET[$taxonomy_name]) && $_GET[$taxonomy_name] != "" && $_GET[$taxonomy_name] == $taxonomy->term_id) {
                    $selected = 'checked = "checked"';
                }
                $toggle = '';
                if ($max_record > 0 && $count > $max_record && $is_show) {
                    $toggle = 'hide_nexts hide_nexts-' . $taxonomy_name;
                }
                if ($max_record < $count && $is_show && $showed) {
                    $showed = false;
                    $more_html = '<li class="show-more"><small><a href="javascript:void(0);" class="show_next" data-tax-id="' . esc_attr($taxonomy_name) . '">' . __('Show more', 'nokri') . '</a></small><li>';
                }
                if ($multi_searach) {

                    $name = $taxonomy_name . '[]';
                    $option .= '<li class="' . esc_attr($toggle) . '"><input class="' . $search_class . ' change_select" value = "' . esc_attr($taxonomy->term_id) . '" name = "' . $taxonomy_name . '" type="checkbox" ' . esc_attr($selected) . '><label>' . esc_html($taxonomy->name) . '</label></li>';
                } else {
                    $option .= '<li class="' . esc_attr($toggle) . '"><input class="' . $search_class . ' change_select" value = "' . esc_attr($taxonomy->term_id) . '" name = "' . $taxonomy_name . '" type="radio" ' . esc_attr($selected) . ' ><label>' . esc_html($taxonomy->name) . '</label></li>';
                }
                $count++;
            }
            $option .= $more_html;
        }

        $cls = $is_open == 'in' ? 'active' : '';
        $collapsed = 'collapsed';
        if ($is_open == 'in') {
            $collapsed = '';
        }

        if (!empty($instance['title'])) {
            $title = apply_filters('widget_title', $instance['title']);
        }
        if ($multi_searach) {
            $form = '
                                        <ul class="list">
                                          ' . $option . '
                                       </ul>';
        } else {
            $form = '<form  method="get"  action="' . get_the_permalink($nokri['sb_search_page']) . '" >
                                        <ul class="list">
                                          ' . $option . '
                                       </ul>
                 ' . nokri_search_params($taxonomy_name) . '
        </form>';
        }

        return '<div class="panel panel-default">
                                    <div class="panel-heading ' . esc_attr($cls) . '" role="tab" >
                                      
                                        <a class="' . esc_attr($collapsed) . '" role="button" data-toggle="collapse" href="#collapse-' . esc_attr($taxonomy_name) . '" >                                                ' . $title . '  
                                        </a>
                                     
                                    </div>
                                    <div id="collapse-' . esc_attr($taxonomy_name) . '" class="panel-collapse collapse ' . esc_attr($is_open) . '">
                                      <div class="panel-body">
                    ' . $form . '                 
                                      </div>
                                    </div>
                                  </div>';
    }

}
/* ========================= */
/*   Get All employess Function   */
/* ========================= */
/* ========================= */
/*   Get All employess Function   */
/* ========================= */
if (!function_exists('nokri_apply_with_external_source')) {

    function nokri_apply_with_external_source($job_id = '') {
        $apply_button = '';
        global $nokri;
        $job_apply_with = get_post_meta($job_id, '_job_apply_with', true);
        $job_apply_url = get_post_meta($job_id, '_job_apply_url', true);
        $job_apply_mail = get_post_meta($job_id, '_job_apply_mail', true);
        $job_apply_whatsapp = get_post_meta($job_id, '_job_apply_whatsapp', true);

        $apply_status = nokri_job_apply_status($job_id);
        $apply_now_text = esc_html__('Apply now', 'nokri');

        $href = "javascript:void(0)";
        $exter_app = "external_apply";
        $email_app = "email_apply";
        $whatspp_app = "whatsapp_apply";
        $simple_app = "apply_job";
        $modal_target = "#myModal";
        $href_whatsapp = "https://api.whatsapp.com/send?phone=$job_apply_whatsapp";


        if (isset($nokri['job_apply_on_detail']) && $nokri['job_apply_on_detail']) {

            $href = get_the_permalink($job_id);
            $exter_app = "";
            $email_app = "";
            $whatspp_app = "";
            $simple_app = "";
            $modal_target = "";
            $href_whatsapp = get_the_permalink($job_id);
        }
        if ($apply_status != "") {
            $apply_now_text = esc_html__('Applied', 'nokri');
        }

        if ($job_apply_with == 'exter') {
            $apply_button = '<a href="' . $href . '" class="btn n-btn-rounded btn-mid btn-clear  ' . $exter_app . ' " data-job-id="' . esc_attr($job_id) . '"  data-job-exter="' . ( $job_apply_url ) . '">' . esc_html($apply_now_text) . '</a>';
        } else if ($job_apply_with == 'mail') {
            $apply_button = '<a href="' . $href . '" class="btn n-btn-rounded btn-mid btn-clear ' . $email_app . '" data-job-id="' . esc_attr($job_id) . '" data-job-exter="' . ( $job_apply_mail ) . '">' . $apply_now_text . '</a>';
        } else if ($job_apply_with == 'whatsapp') {
            $apply_button = '<a href="' . $href_whatsapp . '" class="btn n-btn-rounded btn-mid btn-clear ' . $whatspp_app . '" data-job-id="' . esc_attr($job_id) . '" data-job-exter="' . ( $job_apply_whatsapp ) . '">' . $apply_now_text . '</a>';
        } else {
            $apply_button = '<a href="' . $href . '" class="btn n-btn-rounded ' . $simple_app . '" data-toggle="modal" data-target="' . $modal_target . '"  data-job-id=' . esc_attr($job_id) . '>' . esc_html($apply_now_text) . ' </a>';
        }
        return $apply_button;
    }

}

/* ========================= */
/*   Get All employess Function   */
/* ========================= */
if (!function_exists('nokri_job_apply_status')) {

    function nokri_job_apply_status($job_id) {

        $user_id = get_current_user_id();
        $applid = get_post_meta($job_id, '_job_applied_resume_' . $user_id, true);
        return $applid;
    }

}
/* ========================= */
/*   Get All employess Function   */
/* ========================= */
if (!function_exists('nokri_top_employers_lists')) {

    function nokri_top_employers_lists() {
        /* WP User Query */
        $args = array(
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => '_sb_reg_type',
                    'value' => "1",
                    'compare' => '='
                ),
            )
        );
        $user_query = new WP_User_Query($args);
        $authors = $user_query->get_results();
        $count_res = count($authors);
        $employers_array = array();
        if (!empty($authors)) {
            if (count((array) $authors) > 0 && $authors != "") {
                foreach ($authors as $author) {
                    $employers_array[$author->ID] = $author->display_name;
                }
            }
        }
        return $employers_array;
    }

}
/* ================================== */
/*  Boost job with add on        */
/* =================================== */
if (!function_exists('nokri_validate_employer_premium_jobs')) {

    function nokri_validate_employer_premium_jobs() {

        $current_user = get_current_user_id();
        /* Checking if Employer have Account Members with job posting permissions */
        $emp_id = get_user_meta($current_user, 'account_owner', true);
        $member_id = get_user_meta($current_user, '_sb_is_member', true);
        if (isset($member_id) && $member_id != '') {
            $user_id = $emp_id;
        } else {
            $user_id = $current_user;
        }
        $job_bost = false;
        if (current_user_can('administrator')) {
            $job_bost = true;
        }
        if (get_user_meta($user_id, '_sb_expire_ads', true) != '') {
            $job_classes = get_terms(array('taxonomy' => 'job_class', 'hide_empty' => false,));

            foreach ($job_classes as $job_class) {
                $term_id = $job_class->term_id;
                $job_class_user_meta = get_user_meta($user_id, 'package_job_class_' . $term_id, true);
                $emp_class_check = get_term_meta($job_class->term_id, 'emp_class_check', true);
                if ($job_class_user_meta > 0 && $emp_class_check != 1) {
                    $job_bost = true;
                }
            }
        }
        return $job_bost;
    }

}
/* * ********************* */
/* Employer sidebar html  */
/* * ********************* */
if (!function_exists('nokri_top_employers_search')) {

    function nokri_top_employers_search() {
        global $nokri;
        $employers = array();
        if (isset($nokri['multi_company_select']) && $nokri['multi_company_select'] != '') {
            $employers = $nokri['multi_company_select'];
        }

        $employers_array = array();

        if (count((array) $employers) > 0 && $employers != "") {
            foreach ($employers as $key => $value) {
                $employers_array[] = $value;
            }
        }
        /* WP User Query */
        $args = array(
            'order' => 'DESC',
            'include' => $employers_array,
        );
        $user_query = new WP_User_Query($args);
        $authors = $user_query->get_results();
        $required_user_html = '';
        if (!empty($authors)) {
            foreach ($authors as $author) {
                $user_id = $author->ID;
                $user_name = $author->display_name;
                /* Profile Pic  */
                $image_dp_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
                    $image_dp_link = array($nokri['nokri_user_dp']['url']);
                }
                if (get_user_meta($user_id, '_sb_user_pic', true) != '') {
                    $attach_dp_id = get_user_meta($user_id, '_sb_user_pic', true);
                    $image_dp_link = wp_get_attachment_image_src($attach_dp_id, '');
                }
                $user_post_count = count_user_posts($user_id, 'job_post');
                $user_post_count_html = '<span class="job-openings">' . $user_post_count . " " . esc_html__('Openings', 'nokri') . '</span>';
                $required_user_html .= '<a href="' . esc_url(get_author_posts_url($user_id)) . '">
                                    <div class="company-list-box">
                                        <span class="company-list-img">
                                            <img src="' . esc_url($image_dp_link[0]) . '" class="img-responsive" alt="' . esc_attr__('Image', 'nokri') . '">
                                        </span>
                                        <div class="company-list-box-detail">
                                            <h5>' . $user_name . '</h5>
                                           <p>' . get_user_meta($user_id, '_user_headline', true) . '</p>
                                           ' . $user_post_count_html . '
                                        </div>
                                    </div>
                                </a>';
            }
        }
        if (isset($nokri['multi_company_select']) && $nokri['multi_company_select'] != '') {
            return $required_user_html;
        }
    }

}
/* Getting  Taxonomies Name  From Widget  */
if (!function_exists('nokri_job_search_taxonomies')) {

    function nokri_job_search_taxonomies($taxonomy_name = '', $value = '') {
        global $nokri;
        $taxonomies = get_terms($taxonomy_name, array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC', 'parent' => 0));
        $option = '';
        if (count((array) $taxonomies) > 0) {
            foreach ($taxonomies as $taxonomy) {
                $selected = '';
                if (isset($_GET[$taxonomy_name]) && $_GET[$taxonomy_name] != "" && $_GET[$taxonomy_name] == $taxonomy->term_id) {
                    $selected = 'selected = "selected"';
                }
                $option .= '<option value="' . esc_attr($taxonomy->term_id) . '" ' . $selected . '>' . esc_html($taxonomy->name) . '</option>';
            }
        }
        return '<form  method="get" action="' . get_the_permalink($nokri['sb_search_page']) . '">   
                <div class="categories-module">
                 <div class="form-group">
                <select  class="select-category form-control change_select" name ="' . $taxonomy_name . '">
                <option label="' . esc_html__('Select Option', 'nokri') . '"></option>
                ' . $option . '
                </select>
                 </div>
                </div>' . nokri_search_params($taxonomy_name) . '</form>';
    }

}
// Job search params
if (!function_exists('nokri_search_params')) {

    function nokri_search_params($index, $second = '') {

        $param = $_SERVER['QUERY_STRING'];
        $res = '';
        if (isset($param)) {
            parse_str($_SERVER['QUERY_STRING'], $vars);
            foreach ($vars as $key => $val) {
                if ($key == $index)
                    continue;
                if ($second != "") {
                    if ($key == $second)
                        continue;
                }
                if (isset($vars['custom']) && count((array) $vars['custom']) > 0 && 'custom' == $key) {
                    foreach ($vars['custom'] as $ckey => $cval) {
                        $name = "custom[$ckey]";
                        if ($name == $index) {
                            continue;
                        }
                        $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                    }
                } else {

                    $res .= '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" />';
                }
            }
        }
        return $res;
    }

}
/* Getting Taxonomies Name On Single Page */
if (!function_exists('nokri_job_post_single_taxonomies')) {

    function nokri_job_post_single_taxonomies($taxonomy_name = '', $value = '') {
        $taxonomies_single = get_term_by('id', $value, $taxonomy_name);

        if ($taxonomies_single) {
            return $taxonomies_single->name;
        }
    }

}
/* Getting Public Resume */
if (!function_exists('nokri_get_resume_publically')) {

    function nokri_get_resume_publically($user_id = '', $type = '') {
        $download_btn = $attach_id = $link = $final_url = '';
        $ids_array = get_user_meta($user_id, '_cand_resume', true);
        if (!empty($ids_array)) {
            $ids_array = explode(',', $ids_array);
            $attach_id = $ids_array[0];
            $link = nokri_set_url_param(get_the_permalink($attach_id), 'attachment_id', esc_attr($attach_id));
            $final_url = esc_url(nokri_page_lang_url_callback($link));
            $download_btn = '<a class="btn n-btn-custom btn-block" href="' . $final_url . '&download_file=1"><i class="fa fa-download"></i>' . esc_html__('Download Resume', 'nokri') . '</a>';
        }
        if ($type == 'id') {
            return $attach_id;
        } else {
            return $download_btn;
        }
    }

}
/* Getting Public Resume on active jobs tabs */
if (!function_exists('nokri_get_tab_resume_publically')) {

    function nokri_get_tab_resume_publically($user_id = '', $type = '') {

        $download_btn = $attach_id = $link = $final_url = '';
        $ids_array = get_user_meta($user_id, '_cand_resume', true);

        if (!empty($ids_array)) {
            $ids_array = explode(',', $ids_array);
            $attach_id = $ids_array[0];
            $link = nokri_set_url_param(get_the_permalink($attach_id), 'attachment_id', esc_attr($attach_id));
            $final_url = esc_url(nokri_page_lang_url_callback($link));
            $download_btn = '<a class="btn btn-default" href="' . $final_url . '&download_file=1">' . esc_html__('Download', 'nokri') . '</a>';
        }
        if ($type == 'id') {
            return $attach_id;
        } else {
            return $download_btn;
        }
    }

}
/* Getting Taxonomies Name And Colour */
if (!function_exists('nokri_job_search_taxonomy')) {

    function nokri_job_search_taxonomy($id = '') {
        global $nokri;
        $ids = wp_get_post_terms($id, 'job_type');
        if ((array) $ids && isset($ids[0]->term_id) && $ids[0]->term_id != "") {
            foreach ($ids as $idz) {
                $term_vals = get_term_meta($idz->term_id);
                $color_bg = get_term_meta($idz->term_id, '_job_type_term_color', true);
                $color = get_term_meta($idz->term_id, '_job_type_term_color_bg', true);
                $style_color = '';
                if ($color_bg != "") {
                    $style_color = 'background-color: ' . $color . ';  color: ' . $color_bg . ';';
                }

                return '<a href="' . get_the_permalink($nokri['sb_search_page']) . '?job_type=' . $idz->term_id . '" class="label part-time"  style= "' . ($style_color) . '">' . esc_html($idz->name) . '</a>';
            }
        }
    }

}
/* Getting Taxonomies Name And Colour */
if (!function_exists('nokri_job_class_taxonomy_colour')) {

    function nokri_job_class_taxonomy_colour($id = '') {
        global $nokri;
        $ids = wp_get_post_terms($id, 'job_class');
        if ((array) $ids && isset($ids[0]->term_id) && $ids[0]->term_id != "") {
            foreach ($ids as $idz) {
                $term_vals = get_term_meta($idz->term_id);
                $color = get_term_meta($idz->term_id, '_job_class_term_color', true);
                $style_color = '';
                if ($color != "") {
                    $style_color = 'style=" color: ' . $color . ' !important; border: 1px solid ' . $color . ' !important;"';
                }
                return '<a href="' . get_the_permalink($nokri['sb_search_page']) . '?job_type=' . $idz->term_id . '" class="mata-detail part" ' . $style_color . '>' . $idz->name . '</a>';
            }
        }
    }

}
/* Getting All Sub Level Categories */
if (!function_exists('nokri_get_ad_cats')) {

    function nokri_get_ad_cats($id, $by = 'name') {
        $post_categories = wp_get_object_terms($id, 'job_category', array('orderby' => 'term_group'));
        $cats = array();
        foreach ($post_categories as $c) {
            $cat = get_category($c);
            $cats[] = array('name' => $cat->name, 'id' => $cat->term_id);
        }
        return $cats;
    }

}
/* Terms Child */
add_action('wp_ajax_get_cats', 'nokri_term_child');
add_action('wp_ajax_nopriv_get_cats', 'nokri_term_child');
if (!function_exists('nokri_term_child')) {

    function nokri_term_child() {
        $cat_id = ($_POST['cat_id']);
        $taxonomy = 'job_category';
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
            'parent' => $cat_id,
        ));
        $taxo = '';

        if (!empty($terms)) {
            $taxo .= '<option value="0">' . esc_html__('Select Option', 'nokri') . '</option>';
        }
        foreach ($terms as $term) {
            $taxo .= '<option value="' . $term->term_id . '">' . $term->name . '</option>';
        }


        echo "" . $taxo;

        die();
    }

}
// Get sub cats
add_action('wp_ajax_sb_get_sub_cat_search', 'nokri_get_sub_cats_search');
add_action('wp_ajax_nopriv_sb_get_sub_cat_search', 'nokri_get_sub_cats_search');
if (!function_exists('nokri_get_sub_cats_search')) {

    function nokri_get_sub_cats_search() {
        global $nokri;
        $heading = (isset($nokri['cat_level_2']) && $nokri['cat_level_2'] != "") ? $nokri['cat_level_2'] : "";
        $cat_id = $_POST['cat_id'];
        $ad_cats = nokri_get_cats('job_category', $cat_id);
        $res = '';
        if (count((array) $ad_cats) > 0) {
            $res .= '<label>' . $heading . '</label>';
            $res .= '<select class="questions-category form-control"  id="cats_response">';
            $res .= '<option label="' . esc_html__('Select Option', 'nokri') . '"></option>';
            foreach ($ad_cats as $ad_cat) {
                $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '</option>';
            }
            $res .= '</select>';
            echo nokri_returnEcho($res);
        }
        die();
    }

}
// Get sub cats Version
add_action('wp_ajax_sb_get_sub_sub_cat_search', 'nokri_get_sub_sub_cats_search');
add_action('wp_ajax_nopriv_sb_get_sub_sub_cat_search', 'nokri_get_sub_sub_cats_search');
if (!function_exists('nokri_get_sub_sub_cats_search')) {

    function nokri_get_sub_sub_cats_search() {
        global $nokri;
        $heading = '';
        if (isset($nokri['cat_level_3']) && $nokri['cat_level_3'] != "") {
            $heading = $nokri['cat_level_3'];
        }
        $cat_id = $_POST['cat_id'];
        $ad_cats = nokri_get_cats('job_category', $cat_id);
        $res = '';
        if (count((array) $ad_cats) > 0) {
            $res .= '<label>' . $heading . '</label>';
            $res .= '<select class="search-select form-control"  id="select_version">';
            $res .= '<option label="' . esc_html__('Select Option', 'nokri') . '"></option>';
            foreach ($ad_cats as $ad_cat) {
                $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '</option>';
            }
            $res .= '</select>';
            echo nokri_returnEcho($res);
        }
        die();
    }

}
// Get sub cats Version 4th Level
add_action('wp_ajax_sb_get_sub_sub_sub_cat_search', 'nokri_get_sub_sub_sub_cats_forth_search');
add_action('wp_ajax_nopriv_sb_get_sub_sub_sub_cat_search', 'nokri_get_sub_sub_sub_cats_forth_search');
if (!function_exists('nokri_get_sub_sub_sub_cats_forth_search')) {

    function nokri_get_sub_sub_sub_cats_forth_search() {
        global $nokri;
        $heading = '';
        if (isset($nokri['cat_level_4']) && $nokri['cat_level_4'] != "") {
            $heading = $nokri['cat_level_4'];
        }
        $cat_id = $_POST['cat_id'];
        $ad_cats = nokri_get_cats('job_category', $cat_id);
        $res = '';
        if (count((array) $ad_cats) > 0) {
            $res .= '<label>' . $heading . '</label>';
            $res .= '<select class="search-select form-control"  id="select_forth">';
            $res .= '<option label="' . esc_html__('Select Option', 'nokri') . '"></option>';
            foreach ($ad_cats as $ad_cat) {
                $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '</option>';
            }
            $res .= '</select>';
            echo nokri_returnEcho($res);
        }
        die();
    }

}
// Get Countries
add_action('wp_ajax_get_countries_search', 'nokri_get_countries_search');
add_action('wp_ajax_nopriv_get_countries_search', 'nokri_get_countries_search');
if (!function_exists('nokri_get_countries_search')) {

    function nokri_get_countries_search() {
        global $nokri;
        $heading = '';
        if (isset($nokri['job_country_level_2']) && $nokri['job_country_level_2'] != "") {
            $heading = $nokri['job_country_level_2'];
        }
        $country_id = $_POST['country_id'];
        $job_countries = nokri_get_cats('ad_location', $country_id);
        $res = '';
        if (count((array) $job_countries) > 0) {
            $res .= '<label>' . $heading . '</label>';
            $res .= '<select class="questions-category form-control"  id="countries_response">';
            $res .= '<option label="' . esc_html__('Select Option', 'nokri') . '"></option>';
            foreach ($job_countries as $job_country) {
                $res .= '<option value=' . esc_attr($job_country->term_id) . '>' . esc_html($job_country->name) . '</option>';
            }
            $res .= '</select>';
            echo nokri_returnEcho($res);
        }
        die();
    }

}
// Get States
add_action('wp_ajax_get_states_search', 'nokri_get_states_search');
add_action('wp_ajax_nopriv_get_states_search', 'nokri_get_states_search');
if (!function_exists('nokri_get_states_search')) {

    function nokri_get_states_search() {
        global $nokri;
        $heading = '';
        if (isset($nokri['job_country_level_3']) && $nokri['job_country_level_3'] != "") {
            $heading = $nokri['job_country_level_3'];
        }
        $country_id = $_POST['country_id'];
        $job_countries = nokri_get_cats('ad_location', $country_id);
        $res = '';
        if (count((array) $job_countries) > 0) {
            $res .= '<label>' . $heading . '</label>';
            $res .= '<select class="questions-category form-control"  id="state_response">';
            $res .= '<option label="' . esc_html__('Select Option', 'nokri') . '"></option>';
            foreach ($job_countries as $job_country) {
                $res .= '<option value=' . esc_attr($job_country->term_id) . '>' . esc_html($job_country->name) . '</option>';
            }
            $res .= '</select>';
            echo nokri_returnEcho($res);
        }
        die();
    }

}
// Get Cities
add_action('wp_ajax_get_cities_search', 'nokri_get_cities_search');
add_action('wp_ajax_nopriv_get_cities_search', 'nokri_get_cities_search');
if (!function_exists('nokri_get_cities_search')) {

    function nokri_get_cities_search() {
        global $nokri;
        $heading = '';
        if (isset($nokri['job_country_level_4']) && $nokri['job_country_level_4'] != "") {
            $heading = $nokri['job_country_level_4'];
        }
        $country_id = $_POST['country_id'];
        $job_countries = nokri_get_cats('ad_location', $country_id);
        $res = '';
        if (count((array) $job_countries) > 0) {
            $res .= '<label>' . $heading . '</label>';
            $res .= '<select class="questions-category form-control"  id="cities_response">';
            $res .= '<option label="' . esc_html__('Select Option', 'nokri') . '"></option>';
            foreach ($job_countries as $job_country) {
                $res .= '<option value=' . esc_attr($job_country->term_id) . '>' . esc_html($job_country->name) . '</option>';
            }
            $res .= '</select>';
            echo nokri_returnEcho($res);
        }
        die();
    }

}
/* Getting Job Post Countries */
if (!function_exists('nokri_get_job_country')) {

    function nokri_get_job_country($id, $by = 'name') {
        $post_countries = wp_get_object_terms($id, array('ad_location'), array('orderby' => 'term_group'));
        $countries = array();
        foreach ($post_countries as $country) {
            $related_result = get_category($country);
            $countries[] = array('name' => $related_result->name, 'id' => $related_result->term_id);
        }
        return $countries;
    }

}
/* Getting Job Post Country City States */
if (!function_exists('nokri_display_adLocation')) {

    function nokri_display_adLocation($pid) {
        global $nokri;
        $ad_country = '';
        $type = '';
        $type = isset($nokri['cat_and_location']) ? $nokri['cat_and_location'] : '';
        $ad_country = wp_get_object_terms($pid, array('ad_location'), array('orderby' => 'term_group'));
        $all_locations = array();
        foreach ($ad_country as $ad_count) {
            $country_ads = get_term($ad_count);
            $item = array(
                'term_id' => $country_ads->term_id,
                'location' => $country_ads->name
            );
            $all_locations[] = $item;
        }
        $location_html = '';
        if (count((array) $all_locations) > 0) {
            $limit = count((array) $all_locations) - 1;
            for ($i = $limit; $i >= 0; $i--) {
                if ($type == 'search') {

                    $location_html .= '<a href="' . get_the_permalink($nokri['sb_search_page']) . '?country_id=' . $all_locations[$i]['term_id'] . '">' . esc_html($all_locations[$i]['location']) . '</a>, ';
                } else {
                    $location_html .= '<a href="' . get_term_link($all_locations[$i]['term_id']) . '">' . esc_html($all_locations[$i]['location']) . '</a>, ';
                }
            }
        }
        return rtrim($location_html, ', ');
    }

}
/* Getting Candidate Skills value and bar */
if (!function_exists('nokri_candidate_skill_bar')) {

    function nokri_candidate_skill_bar($user_crnt_id = '') {
        global $nokri;
        $skills_bar = '';
        $cand_skills = $cand_skills_values = array();
        $cand_skills_values = get_user_meta($user_crnt_id, '_cand_skills_values', true);
        $cand_skills = get_user_meta($user_crnt_id, '_cand_skills', true);
        if (isset($cand_skills) && !empty($cand_skills) && count($cand_skills) > 0) {
            foreach ($cand_skills as $key => $csv) {
                $term = get_term_by('id', $csv, 'job_skills');
                if ($term) {
                    $skill_lavel = 100;
                    if (isset($cand_skills_values) && is_array($cand_skills_values)) {
                        if (array_key_exists($key, $cand_skills_values)) {
                            $skill_lavel = $cand_skills_values[$key];
                        }
                    }
                    $array_skills[] = array("name" => $term->name, "value" => $skill_lavel, "id" => $term->term_id);
                }
            }
        }

        $skill_as_tag = isset($nokri['skills_as_tag']) ? $nokri['skills_as_tag'] : false;
        $candidate_search_page = $nokri['candidates_search_page'];
        if (isset($array_skills) && !empty($array_skills)) {
            foreach ($array_skills as $r) {
                $link = get_the_permalink($candidate_search_page) . "?cand_skills=" . $r["id"];
                if ($skill_as_tag) {

                    $skills_bar .= '<a href="' . $link . '" class="skills_tags" target="_blank"> ' . esc_html($r["name"]) . '</a>';
                } else {
                    $skills_bar .= '<div class="bar-wrapper">
                    <span class="progress-text">' . $r["name"] . '</span>
                    <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="' . $r["value"] . '" aria-valuemin="0" aria-valuemax="100" > <span  class="popOver" data-toggle="tooltip" data-placement="top" title="' . $r["value"] . '%"> </span> 
                                                </div>
                    </div>
                </div>';
                }
            }
        }
        return $skills_bar;
    }

}
/* Getting Candidate Portfolio */
if (!function_exists('nokri_candidate_portfolio')) {

    function nokri_candidate_portfolio($user_crnt_id = '') {
        $portfolio_html = '';
        if (get_user_meta($user_crnt_id, '_cand_portfolio', true) != "") {
            $port = get_user_meta($user_crnt_id, '_cand_portfolio', true);
            $portfolios = explode(',', $port);
            foreach ($portfolios as $portfolio) {
                $portfolio_image_sm = wp_get_attachment_image_src($portfolio, 'nokri_job_hundred');
                $portfolio_image_lg = wp_get_attachment_image_src($portfolio, 'nokri_cand_large');
                $portfolio_html .= '<li><a class="portfolio-gallery" data-fancybox="gallery" href="' . esc_url($portfolio_image_lg[0]) . '"><img src="' . esc_url($portfolio_image_sm[0]) . '" alt= "' . esc_html__('portfolio image', 'nokri') . '"></a></li>';
            }
        }
        return $portfolio_html;
    }

}
/* * ******************************************* */
/* Getting candidates ids for matched resumes */
/* * ******************************************* */
if (!function_exists('nokri_get_candidates_ids_for_matched_resumes')) {

    function nokri_get_candidates_ids_for_matched_resumes($job_id = '') {
        $candidates_ids = array();
        $user_query = new WP_User_Query(
                array(
            'orderby' => 'meta_value_num',
            'meta_key' => '_cand_skills_sum',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_sb_reg_type',
                    'value' => '0',
                    'compare' => '='
                ),
                array(
                    'key' => '_cand_skills_sum',
                    'value' => array(0, 1000000000),
                    'type' => 'numeric',
                    'compare' => 'BETWEEN'
                ),
            ),
        ));
        $candidates = $user_query->get_results();
        if (isset($candidates) && count($candidates) > 0) {
            foreach ($candidates as $candidate) {
                $candidate_id = $candidate->ID;
                $job_skills = wp_get_post_terms($job_id, 'job_skills', array("fields" => "ids"));
                $cand_skills = get_user_meta($candidate_id, '_cand_skills', true);
                if (is_array($cand_skills) && is_array($job_skills)) {
                    $final_array = array_intersect($cand_skills, $job_skills);
                    if (count($final_array) > 0) {
                        $candidates_ids[] = $candidate_id;
                    }
                }
            }
        }
        return $candidates_ids;
    }

}
/* Getting Job Class For Badges */
if (!function_exists('nokri_job_class_badg')) {

    function nokri_job_class_badg($job_id = '') {
        $term_ids = array();
        $job_class_badges = get_terms(array('taxonomy' => 'job_class', 'hide_empty' => false,));
        foreach ($job_class_badges as $job_class_badge) {
            $term_id = $job_class_badge->term_id;
            $job_class_post_meta = get_post_meta($job_id, 'package_job_class_' . $term_id, true);
            if ($job_class_post_meta == $term_id)
                $term_ids[$job_class_badge->name] = $job_class_post_meta;
        }
        return $term_ids;
    }

}
/* * *************************************** */
/* Calling Funtion Job Class For Badges */
/* * *************************************** */
if (!function_exists('nokri_premium_job_class_badges')) {

    function nokri_premium_job_class_badges($job_id = '') {
        global $nokri;
        $job_badge_ul = '';
        $single_job_badges = wp_get_post_terms($job_id, 'job_class', array("fields" => "ids"));
        $featured_html = $premium_val = $premium_class = $job_badge_text = $job_badge_ul = '';
        if (count((array) $single_job_badges) > 0) {
            $premium_class = 'featured-box';
            foreach ($single_job_badges as $job_badge => $val) {

                $term_vals = get_term_meta($val);
                $terms = get_term_by('id', $val, 'job_class');
                $bg_color = get_term_meta($val, '_job_class_term_color_bg', true);
                $color = get_term_meta($val, '_job_class_term_color', true);
                $style_li = $style_anch = '';
                if ($color != "") {
                    $style_li = 'style=" background-color: ' . $bg_color . ' !important;"';
                    $style_anch = 'style="color: ' . $color . ' !important;"';
                }

                $premium_val = get_post_meta($job_id, 'package_job_class_' . $val, true);
                $featured_html = ' <div class="features-star-2"><i class="fa fa-star"></i></div>';
                $search_url = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job_class', $val);
                $job_badge_text .= '<li ' . $style_li . '><a href="' . esc_url(nokri_page_lang_url_callback($search_url)) . '" class="job-class-tags-anchor" ' . $style_anch . '>' . esc_html(ucfirst($terms->name)) . '</a></li>';
            }

            return $job_badge_ul = '<ul class="featured-badge-list">' . "" . ($job_badge_text) . '</ul>';
        }
    }

}
/* * *************************************** */
/* Getting Selected Skills For Candidate */
/* * *************************************** */
if (!function_exists('nokri_candidate_skills')) {

    function nokri_candidate_skills($taxonomy_name = '', $meta_key = '') {

        $cand_skills = array();
        $user_info = wp_get_current_user();
        $user_crnt_id = $user_info->ID;

        $cand_skills = get_user_meta($user_crnt_id, $meta_key, true);

        $taxonomies = get_terms($taxonomy_name, array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC', 'parent' => 0));
        $option = '';
        if (count((array) $taxonomies) > 0) {

            foreach ($taxonomies as $taxonomy) {
                $selected = '';
                if (count((array) $cand_skills) > 0 && is_array($cand_skills)) {
                    if (in_array($taxonomy->term_id, $cand_skills)) {
                        $selected = 'selected="selected"';
                    }
                }
                $option .= '<option value="' . esc_attr($taxonomy->term_id) . '" ' . $selected . '>' . esc_html($taxonomy->name) . '</option>';
            }
        }
        return $option;
    }

}
/* * *************************************** */
/* Getting Job Selected Skills For Job */
/* * *************************************** */
if (!function_exists('nokri_job_selected_skills')) {

    function nokri_job_selected_skills($taxonomy_name = '', $meta_key = '', $job_skills = '') {
        $taxonomies = get_terms($taxonomy_name, array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC', 'parent' => 0));
        $option = '';
        if (empty($job_skills)) {
            $job_skills = array();
        }

        if (count((array) $taxonomies) > 0) {
            foreach ($taxonomies as $taxonomy) {
                if (in_array($taxonomy->term_id, $job_skills)) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                $option .= '<option value="' . esc_attr($taxonomy->term_id) . '" ' . $selected . '>' . esc_html($taxonomy->name) . '</option>';
            }
        }

        return $option;
    }

}
/* * ********************** */
/* Candidates grid layouts */
/* * ********************** */
if (!function_exists('nokri_candidates_get_grid_layouts')) {

    function nokri_candidates_get_grid_layouts($cand_id = '', $layout = '') {



        $cand_data = get_userdata($cand_id);
        /* Profile Pic  */
        $image_dp_link = nokri_get_user_profile_pic($cand_id, '_cand_dp');
        /* Getting Employer Skills  */
        $skill_tags = nokri_get_candidates_skills($cand_id, '');
        $cand_headline = get_user_meta($cand_id, '_user_headline', true);
        $emp_address = get_user_meta($cand_id, '_cand_address', true);

        $adress_html = '';

        $featured_date = get_user_meta($cand_id, '_candidate_feature_profile', true);
        $is_featured = false;
        $today = date("Y-m-d");
        $expiry_date_string = strtotime($featured_date);
        $today_string = strtotime($today);
        if ($today_string > $expiry_date_string) {
            delete_user_meta($cand_id, '_candidate_feature_profile');
            delete_user_meta($cand_id, '_is_candidate_featured');
        } else {
            $is_featured = true;
        }
        $featured = "";
        if (isset($is_featured) && $is_featured) {
            $featured = '<div class="features-star"><i class="fa fa-star"></i></div>';
        };

        if ($emp_address) {
            $adress_html = '<i class="fa fa-map-marker"></i><p>' . $emp_address . '</p>';
        }

        $cand_name = nokri_return_dotted_name($cand_data->display_name);

        if ($layout == 1) {
            return $layout = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <div class="n-featured-single">
                              <div class="n-featured-candidates-single-top">
                                                            <a href="javascript:void(0)" class="bookmark-icon active saving_resume" data-cand-id=' . esc_attr($cand_id) . '><i class="fa fa-heart-o"></i></a>
                                                          ' . $featured . '
                                 <div class="n-candidate-title">
                                    <h4><a href="' . esc_url(get_author_posts_url($cand_id)) . '">' . $cand_name . '</a></h4>
                                    <p>' . esc_html($cand_headline) . '</p>
                                 </div>
                                 <div class="n-canididate-avatar">
                                   <a href="' . esc_url(get_author_posts_url($cand_id)) . '"><img src="' . esc_url($image_dp_link) . '" class="img-responsive" alt="' . esc_attr__("logo", 'nokri') . '"></a>
                                 </div>
                                 <div class="n-candidate-location">
                                   ' . ($adress_html) . '
                                 </div>
                                 <div class="n-candidate-skills">
                                  ' . "" . $skill_tags . '
                                 </div>
                              </div>
                              <div class="n-candidates-single-bottom">
                                 <a href="' . esc_url(get_author_posts_url($cand_id)) . '">' . esc_html__('View Profile', 'nokri') . '</a>
                              </div>
                           </div>
                        </div>';
        } else {
            return $layout = '<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                            <div class="candidates-grid">
                                <div class="candidate-meta-box">
                                                                ' . $featured . '
                                    <a href="' . esc_url(get_author_posts_url($cand_id)) . '"><img src="' . esc_url($image_dp_link) . '" class="img-responsive" alt="' . esc_attr__("logo", 'nokri') . '"></a>
                                    <div class="candidate-meta">
                                        <div class="cand-name">
                                            <a href="' . esc_url(get_author_posts_url($cand_id)) . '">' . esc_html($cand_name) . '</a>
                                        </div>
                                        <p>' . esc_html($cand_headline) . '</p>
                                    </div>
                                </div>
                                <div class="cand-skills">
                                    ' . "" . $skill_tags . '
                                </div>
                                <div class="cand-btns">
                                    <ul>
                                        <li><a href="' . esc_url(get_author_posts_url($cand_id)) . '">' . esc_html__('View Profile', 'nokri') . '</a></li>
                                        <li class="cand-fav saving_resume" data-cand-id="' . esc_attr($cand_id) . '"><a href="javascript:void(0)"><i class="fa fa-heart-o"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>';
        }
    }

}
/* * *************************************** */
/*    Getting User Meta Of Candidate     */
/* * *************************************** */
if (!function_exists('nokri_candidate_user_meta')) {

    function nokri_candidate_user_meta($meta_key = '') {
        $user_info = $user_crnt_id = $candidate_meta_value = '';
        $user_info = wp_get_current_user();
        $user_crnt_id = $user_info->ID;
        if (get_user_meta($user_crnt_id, $meta_key, true) != '') {
            $candidate_meta_value = get_user_meta($user_crnt_id, $meta_key, true);
        }
        return $candidate_meta_value;
    }

}
/* * *************************************** */
/*    Getting User Meta Of Candidate     */
/* * *************************************** */
if (!function_exists('nokri_fields_validation')) {

    function nokri_fields_validation($message = '') {
        $validation_msg = 'data-parsley-error-message=' . $message . '';
        return $validation_msg;
    }

}
/* * *************************************** */
/*    Getting Post Counts    */
/* * *************************************** */
if (!function_exists('nokri_get_jobs_count')) {

    function nokri_get_jobs_count($user_id, $status) {
        $args = array(
            'post_type' => 'job_post',
            'orderby' => 'date',
            'order' => 'DESC',
            'author' => $user_id,
            'post_status' => $status,
        );
        $args = nokri_wpml_show_all_posts_callback($args);
        $query = new WP_Query($args);
        $job_html = '';
        if ($query->have_posts()) {
            return $post_found = $query->found_posts;
        } else {
            return $post_found = $query->found_posts;
        }
    }

}
/* * *************************************** */
/*    Getting Resumes  Counts On Job    */
/* * *************************************** */
if (!function_exists('nokri_get_resume_count')) {

    function nokri_get_resume_count($job_id) {
        global $wpdb;
        $query = $wpdb->get_results("SELECT meta_id FROM $wpdb->postmeta WHERE (meta_key LIKE '_job_applied_resume_%' AND post_id = '" . $job_id . "')");
        $query2 = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = '$job_id' AND meta_key LIKE '_job_applied_resume_%'");
        if (!empty($query2)) {
            foreach ($query2 as $resumes) {
                $value = $resumes->meta_value;
                $cand_id = explode("|", $value);
                if (!empty($cand_id)) {
                    $user = get_userdata($cand_id[0]);
                    if ($user === false) {
                        delete_post_meta($job_id, '_job_applied_resume_' . $cand_id[0]);
                    }
                }
            }
        }
        return count((array) $query);
    }

}
/* * *************************************** */
/*    Replace Ul in pagination   */
/* * *************************************** */
if (!function_exists('nokri_strip_single_tag')) {

    function nokri_strip_single_tag($str, $tag) {

        $str = preg_replace('/<' . $tag . '[^>]*>/i', '', $str);

        $str = preg_replace('/<\/' . $tag . '>/i', '', $str);

        return $str;
    }

}
/* * *************************************** */
/*    WP Query  pagination   */
/* * *************************************** */
if (!function_exists('nokri_job_pagination')) {

    function nokri_job_pagination($max_num_pages) {
        $big = 999999999; // need an unlikely integer
        $pages = paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?pg=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $max_num_pages->max_num_pages,
            'type' => 'array',
            'prev_next' => true,
            'prev_text' => __('<< Prev', 'nokri'),
            'next_text' => __('Next >>', 'nokri'),
                )
        );

        if (is_array($pages)) {
            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');

            $pagination = '<ul class="pagination">';
            foreach ($pages as $page) {
                $pagination .= "<li>$page</li>";
            }
            $pagination .= '</ul>';
            return $pagination;
        }
    }

}

/* * *************************************** */
/*    WP Query  pagination   */
/* * *************************************** */
if (!function_exists('indeed_job_pagination')) {

    function indeed_job_pagination($pages, $current_page) {

        $big = 999999999; // need an unlikely integer
        if ($pages > 10) {
            $num_of_pages = ($pages / 10) + 1;
            $pages = paginate_links(array(
                'base' => str_replace($big, '%#%', html_entity_decode(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $num_of_pages,
                'type' => 'array',
                'prev_next' => true,
                'prev_text' => __('<< Prev', 'nokri'),
                'next_text' => __('Next >>', 'nokri'),
                    )
            );

            if (is_array($pages)) {
                $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');

                $pagination = '<ul class="pagination">';
                foreach ($pages as $page) {
                    $pagination .= "<li>$page</li>";
                }
                $pagination .= '</ul>';
                return $pagination;
            }
        }
    }

}
/* * *************************************** */
/*    WP User Query  pagination   */
/* * *************************************** */
if (!function_exists('nokri_user_pagination')) {

    function nokri_user_pagination($total_records, $current_page) {
// Check if a records is set.
        if (!isset($total_records))
            return;
        if (!isset($current_page))
            return;
        $big = 99999999;
        $args = array(
            'base' => str_replace($big, '%#%', html_entity_decode(get_pagenum_link($big))),
            'format' => '?page=%#%',
            'total' => $total_records,
            'current' => $current_page,
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
            'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
            'type' => 'list');

        return nokri_strip_single_tag(paginate_links($args), 'ul');
    }

}
/* ========================= */
/*   Salary Type Values Function   */
/* ========================= */
if (!function_exists('nokri_salary_type_values')) {

    function nokri_salary_type_values($getvalue = '') {
        $salary_array = array(
            "0" => __("Per Month", 'nokri'),
            "1" => __("Per Year", 'nokri'),
            "2" => __("Per Hour", 'nokri'),
        );

        return ( $getvalue == "" ) ? $salary_array : $salary_array["$getvalue"];
    }

}
/* ========================= */
/*   Salary Type Function   */
/* ========================= */
if (!function_exists('nokri_job_post_salary_type')) {

    function nokri_job_post_salary_type($select_val = '') {
        global $nokri;
        $salry_type = '';
        $salry_type = isset($nokri['job_post_salary_type']) ? $nokri['job_post_salary_type'] : array();
        $salary_values = '';
        if (count((array) $salry_type) > 0 && $salry_type != '') {
            foreach ($salry_type as $type) {
                if ($select_val == $type) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                $salary_values .= '<option value="' . $type . '" ' . $selected . ' >' . nokri_salary_type_values($type) . '</option>';
            }
        }
        return $salary_values;
    }

}
/* ========================= */
/*  User Registration   */
/* ========================= */
if (!function_exists('nokri_authorization')) {

    function nokri_authorization() {
        if (!is_user_logged_in()):
            get_template_part('template-parts/registration/registration', 'popup');
            get_template_part('template-parts/registration/login', 'popup');
        endif;
    }

}

function nokri_redirect_to_request($redirect_to, $request, $user) {
//is there a user to check?
    if (isset($user->roles) && is_array($user->roles)) {
//check for admins
        if (in_array('administrator', $user->roles)) {
// redirect them to the default place
            return $redirect_to;
        } else {
            return home_url();
        }
    } else {
        return $redirect_to;
    }
}

add_filter('login_redirect', 'nokri_redirect_to_request', 10, 3);
/* ========================= */
/*  User loged In   */
/* ========================= */
if (!function_exists('nokri_check_if_not_logged')) {

    function nokri_check_if_not_logged() {
        if (get_current_user_id() == "") {
            echo nokri_redirect(home_url('/'));
        }
    }

}
/* ================================== */
/*  Check User Log In Before Action   */
/* =================================== */
if (!function_exists('nokri_check_user_activity')) {

    function nokri_check_user_activity() {
        if (get_current_user_id() == "") {
            echo "2";
            die();
        }
    }

}
/* ================================== */
/*  Check User Type Activity         */
/* =================================== */
if (!function_exists('nokri_check_user_type')) {

    function nokri_check_user_type() {
        $user_id = get_current_user_id();

        if (get_user_meta($user_id, '_sb_reg_type', true) == '1') {
            echo "3";
            die();
        }
    }

}
/* ========================= */
/*  Footer Logo  */
/* ========================= */
if (!function_exists('nokri_footer_logo')) {

    function nokri_footer_logo() {
        global $nokri;
        $footerlogo = '';
        if (isset($nokri['footer_bg']['url']) && $nokri['footer_bg']['url'] != "") {
            $logo = ( $nokri['footer_bg']['url'] );
            $footerlogo = '<img class="img-responsive footer-logo" src="' . $logo . '"  alt="' . esc_attr__("logo", "nokri") . '" >';
        } else {
            $footerlogo = '<img class="img-responsive footer-logo" src="' . get_template_directory_uri() . '/images/logo-white.png" alt="' . esc_attr__("logo", "nokri") . '" >';
        }
        return $footerlogo;
    }

}

/* ========================= */
/*  Employer Menu Sorter  */
/* ========================= */
if (!function_exists('nokri_employer_menu_sorter')) {

    function nokri_employer_menu_sorter($user_id = '') {
        global $nokri;
        $sorter = '';
        if (isset($nokri['employer_menu_sorter']) && $nokri['employer_menu_sorter'] != "") {
            $menus = $nokri['employer_menu_sorter'];
        }
        if (count((array) $menus) > 0) {
            foreach ($menus as $optn => $valu) {
                if (($optn == 'dashboard' || $optn == 'Dashboard') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Dashboard', 'nokri');
                    $sorter .= '<li><a href="' . get_the_permalink() . '"><span class="la la-tachometer"></span>' . ($valu) . '</a></li>';
                }
                if (($optn == 'update_profile' || $optn == 'Udpdate Profile' ) && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Udpdate Profile', 'nokri');
                    $dashboard_update_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'edit-profile');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($dashboard_update_url)) . '"><span class="la la-edit"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'view_my_profile' || $optn == 'View My Profile' ) && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('View My Profile', 'nokri');
                    $sorter .= '<li><a href="' . esc_url(get_author_posts_url($user_id)) . '"><span class="la la-user"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'my_jobs' || $optn == 'My Jobs') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('My Jobs', 'nokri');
                    $active_job_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'active-jobs');
                    $inactive_job_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'inactive-jobs');
                    $pending_job_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'pending-jobs');
                    $sorter .= '<li>
                            <div class="profile-menu-link">
                              <span class="la la-bars"></span>' . ($label) . '<i class="fa fa-angle-down"></i>
                            </div>
                            <ul class="submenu">
                              <li><a href="' . esc_url(nokri_page_lang_url_callback($active_job_url)) . '">' . esc_html__(' Active Jobs', 'nokri') . '</a></li>
                              <li><a href="' . esc_url(nokri_page_lang_url_callback($inactive_job_url)) . '">' . esc_html__('In-Active Jobs', 'nokri') . '</a></li>
                              <li><a href="' . esc_url(nokri_page_lang_url_callback($pending_job_url)) . '">' . esc_html__('Pending Jobs', 'nokri') . '</a></li>
                            </ul>
                          </li>';
                }
                if (($optn == 'email_templates' || $optn == 'Email Templates' ) && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Email Templates', 'nokri');
                    $email_temp_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'email-templates');
                    $email_temp_list_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'email-templates-list');
                    $sorter .= '<li>
                            <div class="profile-menu-link">
                              <span class="fa fa-envelope-o"></span>' . ($label) . '<i class="fa fa-angle-down"></i>
                            </div>
                            <ul class="submenu">
                              <li><a href="' . esc_url(nokri_page_lang_url_callback($email_temp_url)) . '">' . esc_html__('Add Email Template', 'nokri') . '</a></li>
                              <li><a href="' . esc_url(nokri_page_lang_url_callback($email_temp_list_url)) . '">' . esc_html__('Email Templates', 'nokri') . '</a></li>
                            </ul>
                          </li>';
                }
                if (($optn == 'matched_resumes' || $optn == 'Matched Resumes') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Matched Resumes', 'nokri');
                    $matched_resume_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'matched-resumes');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($matched_resume_url)) . '"><span class="la la-external-link"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'saved_resumes' || $optn == 'Saved Resumes' ) && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Saved Resumes', 'nokri');
                    $saved_resume_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'saved-resumes');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($saved_resume_url)) . '"><span class="la la-file-pdf-o"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'followers' || $optn == 'Followers') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Followers', 'nokri');
                    $followers_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'our-followers');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($followers_url)) . '"><span class="fa fa-users"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'my_package' || $optn == 'My Package') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('My Package', 'nokri');
                    $packages_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'my-packages');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($packages_url)) . '"><span class="la la-list-alt"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'my_rating' || $optn == 'My Ratings') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('My Ratings', 'nokri');
                    $packages_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'my_ratings');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($packages_url)) . '"><span class="la la-star"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'my_orders' || $optn == 'My Orders') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('My Orders', 'nokri');
                    $orders_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'my-orders');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($orders_url)) . '"><span class="la la-check-circle"></span>' . ($label) . '</a></li>';
                }

                if (($optn == 'cart' || $optn == 'Cart') && $valu != "") {
                    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                        global $woocommerce;
                        $label = isset($valu) ? $valu : esc_html__('Cart', 'nokri');
                        $sorter .= '<li><a href="' . wc_get_cart_url() . '"><span class="la la-shopping-cart"></span>' . ($label) . '</a></li>';
                    }
                }
                $is_access = (isset($nokri['zoom_meeting_btn']) ? $nokri['zoom_meeting_btn'] : false);
                if ($is_access) {

                    if (($optn == 'zoom_meeting' || $optn == 'My nokri_zoom_meeting') && $valu != "") {
                        $label = isset($valu) ? $valu : esc_html__('Zoom Meeting Settings', 'nokri');
                        $meet_authorization = nokri_set_url_param(get_the_permalink(), 'tab-data', 'zoom-meeting');
                        $meet_schedules = nokri_set_url_param(get_the_permalink(), 'tab-data', 'zoom-scheduled');
                        $sorter .= '<li>
                            <div class="profile-menu-link">
                              <span class="fa fa-video-camera"></span>' . ($label) . '<i class="fa fa-angle-down"></i>
                            </div>
                            <ul class="submenu">
                            <li><a href="' . esc_url(nokri_page_lang_url_callback($meet_authorization)) . '">' . esc_html__(' Zoom Authorization', 'nokri') . '</a></li>
                              <li><a href="' . esc_url(nokri_page_lang_url_callback($meet_schedules)) . '">' . esc_html__(' Meetings Schedule', 'nokri') . '</a></li>
                              
                            </ul>
                          </li>';
                    }
                }
                if (($optn == 'logout' || $optn == 'Logout') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Logout', 'nokri');
                    $sorter .= '<li><a href="' . wp_logout_url(home_url()) . '"><span class="la la-sign-out"></span>' . ($label) . '</a></li>';
                }
            }
        }
        return $sorter;
    }

}

/* ============================= */
/*  Employer Members Menu Sorter */
/* ============================= */
if (!function_exists('nokri_employer_member_menu_sorter')) {

    function nokri_employer_member_menu_sorter($user_id = '') {
        global $nokri;
        $sorter = '';
        if (isset($nokri['employer_menu_sorter']) && $nokri['employer_menu_sorter'] != "") {
            $menus = $nokri['employer_menu_sorter'];
        }
        $membersPermiss = get_user_meta($user_id, 'member_permissions', true);
        if (count((array) $menus) > 0) {
            foreach ($menus as $optn => $valu) {
                if (isset($membersPermiss['emp_dashboard']) && $membersPermiss['emp_dashboard'] != '') {
                    if (($optn == 'dashboard' || $optn == 'Dashboard') && $valu != "") {
                        $label = isset($valu) ? $valu : esc_html__('Dashboard', 'nokri');
                        $sorter .= '<li><a href="' . get_the_permalink() . '"><span class="la la-tachometer"></span>' . ($valu) . '</a></li>';
                    }
                }
                if (isset($membersPermiss['edit_profile']) && $membersPermiss['edit_profile'] != '') {
                    if (($optn == 'update_profile' || $optn == 'Udpdate Profile' ) && $valu != "") {
                        $label = isset($valu) ? $valu : esc_html__('Udpdate Profile', 'nokri');
                        $dashboard_update_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'edit-profile');
                        $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($dashboard_update_url)) . '"><span class="la la-edit"></span>' . ($label) . '</a></li>';
                    }
                }
                if (($optn == 'view_my_profile' || $optn == 'View My Profile' ) && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('View My Profile', 'nokri');
                    $sorter .= '<li><a href="' . esc_url(get_author_posts_url($user_id)) . '"><span class="la la-user"></span>' . ($label) . '</a></li>';
                }
                if (isset($membersPermiss['manag_jobs']) && $membersPermiss['manag_jobs'] != '') {
                    if (($optn == 'my_jobs' || $optn == 'My Jobs') && $valu != "") {
                        $label = isset($valu) ? $valu : esc_html__('My Jobs', 'nokri');
                        $active_job_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'active-jobs');
                        $inactive_job_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'inactive-jobs');
                        $pending_job_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'pending-jobs');
                        $sorter .= '<li>
                            <div class="profile-menu-link">
                              <span class="la la-bars"></span>' . ($label) . '<i class="fa fa-angle-down"></i>
                            </div>
                            <ul class="submenu">
                              <li><a href="' . esc_url(nokri_page_lang_url_callback($active_job_url)) . '">' . esc_html__(' Active Jobs', 'nokri') . '</a></li>
                              <li><a href="' . esc_url(nokri_page_lang_url_callback($inactive_job_url)) . '">' . esc_html__('In-Active Jobs', 'nokri') . '</a></li>
                              <li><a href="' . esc_url(nokri_page_lang_url_callback($pending_job_url)) . '">' . esc_html__('Pending Jobs', 'nokri') . '</a></li>
                            </ul>
                          </li>';
                    }
                }
                if (isset($membersPermiss['save_cands']) && $membersPermiss['save_cands'] != '') {
                    if (($optn == 'saved_resumes' || $optn == 'Saved Resumes' ) && $valu != "") {
                        $label = isset($valu) ? $valu : esc_html__('Saved Resumes', 'nokri');
                        $saved_resume_url = nokri_set_url_param(get_the_permalink(), 'tab-data', 'saved-resumes');
                        $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($saved_resume_url)) . '"><span class="la la-file-pdf-o"></span>' . ($label) . '</a></li>';
                    }
                }
                if (($optn == 'logout' || $optn == 'Logout') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Logout', 'nokri');
                    $sorter .= '<li><a href="' . wp_logout_url(home_url()) . '"><span class="la la-sign-out"></span>' . ($label) . '</a></li>';
                }
            }
        }
        return $sorter;
    }

}
/* ========================= */
/*  Candidate Menu Sorter  */
/* ========================= */
if (!function_exists('nokri_candidate_menu_sorter')) {

    function nokri_candidate_menu_sorter($user_id = '') {
        global $nokri;
        $sorter = '';
        if (isset($nokri['candidate_menu_sorter']) && $nokri['candidate_menu_sorter'] != "") {
            $menus = $nokri['candidate_menu_sorter'];
        }
        /* Is applying job package base */
        $is_apply_pkg_base = ( isset($nokri['job_apply_package_base']) && $nokri['job_apply_package_base'] != "" ) ? $nokri['job_apply_package_base'] : false;
        /* Is job alerts */
        $job_alerts = ( isset($nokri['job_alerts_switch']) && $nokri['job_alerts_switch'] != "" ) ? $nokri['job_alerts_switch'] : false;
        if (count((array) $menus) > 0) {
            foreach ($menus as $optn => $valu) {
                if (($optn == 'dashboard' || $optn == 'Dashboard') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Dashboard', 'nokri');
                    $sorter .= '<li><a href="' . get_the_permalink() . '"><span class="la la-tachometer"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'update_profile' || $optn == 'Update Profile') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Update Profile', 'nokri');
                    $dashboard_update_url = nokri_set_url_param(get_the_permalink(), 'candidate-page', 'edit-profile');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($dashboard_update_url)) . '"><span class="la la-edit"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'view_my_profile' || $optn == 'View My Profile') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('View My Profile', 'nokri');
                    $sorter .= '<li><a href="' . esc_url(get_author_posts_url($user_id)) . '"><span class="la la-user"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'my_resumes' || $optn == 'My Resumes') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('My Resumes', 'nokri');
                    $resumes_list = nokri_set_url_param(get_the_permalink(), 'candidate-page', 'resumes-list');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($resumes_list)) . '"><span class="la la-file-pdf-o"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'nokri_gen_resume' || $optn == 'Generate Resumes') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Generate Resumes', 'nokri');
                    $resumes_list = nokri_set_url_param(get_the_permalink(), 'candidate-page', 'generate-resume');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($resumes_list)) . '"><span class="la la-file-pdf-o"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'jobs_applied' || $optn == 'Jobs Applied') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Jobs Applied', 'nokri');
                    $jobs_applied = nokri_set_url_param(get_the_permalink(), 'candidate-page', 'jobs-applied');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($jobs_applied)) . '"><span class="la la-bars"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'saved_jobs' || $optn == 'Saved Jobs') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Saved Jobs', 'nokri');
                    $saved_jobs = nokri_set_url_param(get_the_permalink(), 'candidate-page', 'saved-jobs');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($saved_jobs)) . '"><span class="la la-bookmark"></span>' . ($label) . '</a></li>';
                }

                if (($optn == 'my_rating' || $optn == 'My rating') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('My ratings', 'nokri');
                    $my_rating = nokri_set_url_param(get_the_permalink(), 'candidate-page', 'my_ratings');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($my_rating)) . '"><span class="la la-star"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'followed_companies' || $optn == 'Followed Companies') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Followed Companies', 'nokri');
                    $followed_companies = nokri_set_url_param(get_the_permalink(), 'candidate-page', 'followed-companies');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($followed_companies)) . '"><span class="la la-external-link"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'job_alerts' || $optn == 'Job Alerts') && $valu != "" && $job_alerts) {
                    $label = isset($valu) ? $valu : esc_html__('Job Alerts', 'nokri');
                    $job_alerts = nokri_set_url_param(get_the_permalink(), 'candidate-page', 'job-alerts');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($job_alerts)) . '"><span class="la la-bell"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'my_package' || $optn == 'My Package' ) && $valu != "" && $is_apply_pkg_base) {
                    $label = isset($valu) ? $valu : esc_html__('My Package', 'nokri');
                    $my_packages = nokri_set_url_param(get_the_permalink(), 'candidate-page', 'my-packages');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($my_packages)) . '"><span class="la la-list-alt"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'my_orders' || $optn == 'My Orders') && $valu != "" && $is_apply_pkg_base) {
                    $label = isset($valu) ? $valu : esc_html__('My Orders', 'nokri');
                    $my_orders = nokri_set_url_param(get_the_permalink(), 'candidate-page', 'my-orders');
                    $sorter .= '<li><a href="' . esc_url(nokri_page_lang_url_callback($my_orders)) . '"><span class="la la-check-circle"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'cart' || $optn == 'Cart') && $valu != "") {
                    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                        global $woocommerce;
                        $label = isset($valu) ? $valu : esc_html__('Cart', 'nokri');
                        $sorter .= '<li><a href="' . wc_get_cart_url() . '"><span class="la la-shopping-cart"></span>' . ($label) . '</a></li>';
                    }
                }
                if (($optn == 'logout' || $optn == 'Logout') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Logout', 'nokri');
                    $sorter .= '<li><a href="' . wp_logout_url(home_url()) . '"><span class="la la-sign-out"></span>' . ($label) . '</a></li>';
                }
                if (($optn == 'settings' || $optn == 'setting') && $valu != "") {
                    $label = isset($valu) ? $valu : esc_html__('Settings', 'nokri');
                    $followed_companies = nokri_set_url_param(get_the_permalink(), 'candidate-page', 'inter-settings');
                    $sorter .= '<li><a href="' . esc_url($followed_companies) . '"><span class="la la-wrench"></span>' . ($label) . '</a></li>';
                }
            }
        }
        return $sorter;
    }

}
/* ================================== */
/*  Return Job Country                */
/* =================================== */
if (!function_exists('nokri_job_country')) {

    function nokri_job_country($pid, $icon = '') {
        global $nokri;
        $ad_country = '';
        $ad_country = wp_get_object_terms($pid, array('ad_location'), array('orderby' => 'term_group'));
        $all_locations = array();
        foreach ($ad_country as $ad_count) {
            $country_ads = get_term($ad_count);
            $item = array(
                'term_id' => $country_ads->term_id,
                'location' => $country_ads->name
            );
            $all_locations[] = $item;
        }
        $location_html = '';
        if (count($all_locations) > 0) {
            $limit = count($all_locations) - 1;
            for ($i = $limit; $i >= 0; $i--) {
                $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job-location', esc_attr($all_locations[$i]['term_id']));
                $final_url = esc_url(nokri_page_lang_url_callback($link));
                if ($icon == 'yes') {
                    $location_html .= '<li><a href="' . $final_url . '"> <i class="fa fa-map-marker" aria-hidden="true"></i>' . esc_html($all_locations[$i]['location']) . '</a></li>';
                } else {
                    $location_html .= '<a href="' . $final_url . '">' . ' ' . '' . esc_html($all_locations[$i]['location']) . '</a>';
                }
            }
        }
        return rtrim($location_html, ', ');
    }

}
/* ================================== */
/*  Return Job Categories         */
/* =================================== */
if (!function_exists('nokri_job_categories_with_chlid')) {

    function nokri_job_categories_with_chlid($pid) {
        global $nokri;
        $post_categories = wp_get_object_terms($pid, array('job_category'), array('orderby' => 'term_group'));
        $cats_html = '';
        foreach ($post_categories as $c) {
            $cat = get_term($c);
            $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'cat-id', esc_attr($cat->term_id));
            $final_url = esc_url(nokri_page_lang_url_callback($link));
            $cats_html .= '<a href="' . $final_url . '">' . esc_html($cat->name) . '</a>, ';
        }
        return rtrim($cats_html, ', ');
    }

}
if (!function_exists('nokri_job_categories_with_chlid_no_href')) {

    function nokri_job_categories_with_chlid_no_href($pid, $taxonomy = '') {
        global $nokri;
        $post_categories = wp_get_object_terms($pid, array($taxonomy), array('orderby' => 'term_group'));
        $cats_html = '';
        foreach ($post_categories as $c) {
            $cat = get_term($c);
            $cats_html .= esc_html($cat->name) . "" . ', ';
        }
        return rtrim($cats_html, ', ');
    }

}
// Get parents of custom taxonomy
if (!function_exists('nokri_get_taxonomy_parents')) {

    function nokri_get_taxonomy_parents($id, $taxonomy, $link = true, $separator = ' &raquo; ', $nicename = false, $visited = array()) {

        $chain = '';

        $parent = get_term($id, $taxonomy);

        if (is_wp_error($parent)) {
            echo "fail";
            return $parent;
        }

        if ($nicename) {
            $name = $parent->slug;
        } else {
            $name = $parent->name;
        }

        if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) {

            $visited[] = $parent->parent;

            $chain .= nokri_get_taxonomy_parents($parent->parent, $taxonomy, $link, $separator, $nicename, $visited);
        }

        return $chain;
    }

}
if (!function_exists('nokri_jspopup')) {

    function nokri_jspopup($msg = '', $type = '') {
        echo("<script>jQuery(document).ready(function($) { toastr." . $type . "('" . $msg . "', '', {
                                    timeOut: 2500,
                                    'closeButton': true,
                                    'positionClass': 'toast-top-right'
                                }); });</script>");
    }

}
if (!function_exists('nokri_js_redirect')) {

    function nokri_js_redirect($url) {
        echo("<script>jQuery(document).ready(function($) { window.location = '" . $url . "' });</script>");
    }

}
//Allow Pending jobs to be viewed by listing/product owner
if (!function_exists('posts_for_current_author')) {

    function posts_for_current_author($query) {
        if (isset($_GET['post_type']) && $_GET['post_type'] == "job_post" && isset($_GET['p'])) {
            $post_id = $_GET['p'];
            $post_author = get_post_field('post_author', $post_id);
            if (is_user_logged_in() && get_current_user_id() == $post_author) {
                $query->set('post_status', array('publish', 'pending'));
                return $query;
            } else {
                return $query;
            }
        } else {
            return $query;
        }
    }

}
add_filter('pre_get_posts', 'posts_for_current_author');
/* ======================================== */
/*  Return Candidate Information From Linkedin */
/* ======================================== */
if (!function_exists('nokri_linkedin_access')) {

    function nokri_linkedin_access($code) {
        $server_output2 = nokri_linked_handling($code);
        $user_data = json_decode($server_output2);

        return $user_data;
    }

}
/* =============== */
/* Section bg */
/* =============== */
if (!function_exists('nokri_section_bg_url')) {

    function nokri_section_bg_url() {
        global $nokri;
        $section_bg_img_url = '';
        if (isset($nokri['section_bg_img'])) {
            $section_bg_img_url = nokri_getBGStyle('section_bg_img');
        }

        return $section_bg_img_url;
    }

}
/* =============== */
/* Is Page function */
/* =============== */
if (!function_exists('nokri_is_page_check')) {

    function nokri_is_page_check() {
        global $nokri;
        $page_id = get_the_id();
        $is_valid = false;

        if (!empty($nokri)) {

            if ($nokri['sb_sign_up_page'] == $page_id) {
                $is_valid = true;
            } else if ($nokri['sb_sign_in_page'] == $page_id) {
                $is_valid = true;
            } else if ($nokri['contact_us'] == $page_id) {
                $is_valid = true;
            } else if ($nokri['about_us'] == $page_id) {
                $is_valid = false;
            } else if (is_author()) {
                $is_valid = true;
            } else if (is_singular('job_post') && ($nokri['main_header_style']) == '1') {
                $is_valid = true;
            } else if (is_404()) {
                $is_valid = true;
            }
        }


        return $is_valid;
    }

}
/* =============== */
/* Maptype function */
/* =============== */
if (!function_exists('nokri_mapType')) {

    function nokri_mapType() {
        global $nokri;
        $mapType = 'google_map';
        if (isset($nokri['map-setings-map-type']) && $nokri['map-setings-map-type'] != '') {
            $mapType = $nokri['map-setings-map-type'];
        }
        return $mapType;
    }

}
// get post description as per need. 
if (!function_exists('nokri_words_count')) {

    function nokri_words_count($contect = '', $limit = 180) {
        $string = '';
        $contents = strip_tags(strip_shortcodes($contect));
        $contents = nokri_removeURL($contents);
        $removeSpaces = str_replace(" ", "", $contents);
        $contents = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $contents);
        if (strlen($removeSpaces) > $limit) {
            return mb_substr(str_replace("&nbsp;", "", $contents), 0, $limit) . '...';
        } else {
            return str_replace("&nbsp;", "", $contents);
        }
    }

}
/* =============== */
/* Demo enable function */
/* =============== */
if (!function_exists('nokri_demo_mode')) {

    function nokri_demo_mode() {
        global $nokri;
        $is_demo_mode = false;
        if (isset($nokri['is_demo_mode']) && $nokri['is_demo_mode'] == '1') {
            $is_demo_mode = $nokri['is_demo_mode'];
            $is_demo_mode = true;
        }

        return $is_demo_mode;
    }

}
/* Getting Selected Taxonomies Name */
if (!function_exists('nokri_cand_skills_values')) {

    function nokri_cand_skills_values($skill_value = '') {
        for ($i = 5; $i <= 100;
        ) {
            $array_values[] = $i;
            $i = $i + 5;
        }
        $option = '';
        if (empty($skill_value)) {
            $skill_value = array();
        }
        if (count((array) $array_values) > 0) {
            foreach ($array_values as $array_value) {
                if (in_array($array_value, $skill_value)) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                $option .= '<option value="' . esc_attr($array_value) . '" ' . $selected . '>' . esc_html($array_value) . '</option>';
            }
        }

        return $option;
    }

}
if (!function_exists('nokri_cand_skills_values')) {

    function nokri_user_id_exists($user) {
        global $wpdb;
        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE ID = %d", $user));
        if ($count == 1) {
            return true;
        } else {
            return false;
        }
    }

}
if (!function_exists('nokri_cand_del_resume_keys')) {

    function nokri_cand_del_resume_keys($candidate_id = '') {
        if (!user_id_exists($candidate_id)) {
            delete_post_meta($job_id, '_job_applied_date_' . $candidate_id);
            delete_post_meta($job_id, '_job_applied_resume_' . $candidate_id);
            delete_post_meta($job_id, '_job_applied_status_' . $candidate_id);
        }
    }

}
/* Employer Allowed Candidate search */
if (!function_exists('nokri_is_cand_search_allowed')) {

    function nokri_is_cand_search_allowed() {
        global $nokri;
        $current_user_id = get_current_user_id();
        $expiry_date = get_user_meta($current_user_id, '_sb_expire_ads', true);
        $remaining_searches = get_user_meta($current_user_id, '_sb_cand_search_value', true);
        $today = date("Y-m-d");
        $expiry_date_string = strtotime($expiry_date);
        $today_string = strtotime($today);
        $can_search = true;
        if (isset($nokri['cand_search_mode']) && $nokri['cand_search_mode'] == '2') {
            if ($remaining_searches != '-1' && !current_user_can('administrator')) {
                if ($today_string > $expiry_date_string) {
                    update_user_meta($current_user_id, '_sb_cand_viewed_resumes', '');
                    update_user_meta($current_user_id, '_sb_cand_search_value', '0');
                }
                if ($remaining_searches <= 0 || $today_string > $expiry_date_string) {
                    $can_search = false;
                }
            }
        }
        return $can_search;
    }

}
/* * ********************* */
/* Category count function */
/* * ********************* */
if (!function_exists('nokri_get_opening_count')) {

    function nokri_get_opening_count($term_id = '', $tax_name = '') {
        $custom_count = '';
        if ($tax_name == '') {
            $tax_name = 'job_category';
        }
        $query = new WP_Query(
                array(
            'post_type' => 'job_post',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => $tax_name,
                    'field' => 'term_id',
                    'terms' => array($term_id),
                    'operator' => 'IN',
                ),
            ),
            'meta_query' => array(
                array(
                    'key' => '_job_status',
                    'value' => 'active',
                    'compare' => '=',
                ),
            ),
        ));
        $custom_count = $query->found_posts;
        wp_reset_postdata();
        return $custom_count;
    }

}

if (!function_exists('nokri_get_products_theme_options')) {

    function nokri_get_products_theme_options($for = '') {
        $packages_arr = array('' => __('Select a package', 'nokri'));
        if (!class_exists('WooCommerce')) {
//return $packages_arr;
        } else {
            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'fields' => 'ids',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'ID',
                'meta_query' => array(array('key' => 'op_pkg_for', 'value' => $for, 'compare' => '=',),)
                    ,);
            $the_query = new WP_Query($args);
// The Loop
            if ($the_query->have_posts()) :
                while ($the_query->have_posts()) : $the_query->the_post();
                    global $post;
                    $packages_arr[$post] = get_the_title($post);
                endwhile;
            endif;
// Reset Post Data
            wp_reset_postdata();
            return $packages_arr;
        }
    }

}
/* * ********************* */
/* Assign Free Package */
/* * ********************* */
if (!function_exists('nokri_assign_free_package')) {

    function nokri_assign_free_package() {
        global $nokri;
        $package_id = '';
        if (isset($nokri['register_package']) && $nokri['register_package'] != '') {
            $package_id = $nokri['register_package'];
        }
        return $package_id;
    }

}

/* * ********************* */
/* Assign Free Package Candidate */
/* * ********************* */
if (!function_exists('nokri_candidate_assign_free_package')) {

    function nokri_candidate_assign_free_package() {
        global $nokri;
        $package_id = '';
        if (isset($nokri['cand_register_package']) && $nokri['cand_register_package'] != '') {
            $package_id = $nokri['cand_register_package'];
        }
        return $package_id;
    }

}
// Removing on add to cart if an item is already in cart
add_filter('woocommerce_add_cart_item_data', 'nokri_remove_before_add_to_cart');

function nokri_remove_before_add_to_cart($cart_item_data) {
    WC()->cart->empty_cart();
    return $cart_item_data;
}

/* * *************************** */
/* Job post feilds operations */
/* * ************************** */
if (!function_exists('nokri_job_post_feilds_operations')) {

    function nokri_feilds_operat($key = '', $type = 'show') {
        global $nokri;
        if ($type == 'show') {
            if ((!empty($nokri["$key"]) && $nokri["$key"] == 'show') || !empty($nokri["$key"]) && $nokri["$key"] == 'required') {
                return true;
            } else {
                return false;
            }
        }
        if ($type == 'required') {
            return (!empty($nokri["$key"]) && $nokri["$key"] == 'required') ? ' data-parsley-required="true"' : '';
        }
    }

}
/* * *************************** */
/* Getting candidates skills */
/* * ************************** */
if (!function_exists('nokri_get_candidates_skills')) {

    function nokri_get_candidates_skills($user_id = '', $layout = '') {
        global $nokri;
        $emp_skills = get_user_meta($user_id, '_cand_skills', true);
        $skill_tags = $total_skills = '';
        if ((array) $emp_skills && $emp_skills > 0) {
            $taxonomies = get_terms('job_skills', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC', 'parent' => 0));
            if (count((array) $taxonomies) > 0) {
                $count = 0;
                foreach ($taxonomies as $taxonomy) {
                    if (in_array($taxonomy->term_id, $emp_skills)) {
                        $link = nokri_set_url_param(get_the_permalink($nokri['candidates_search_page']), 'cand_skills', esc_attr($taxonomy->term_id));
                        $final_url = esc_url(nokri_page_lang_url_callback($link));
                        if ($layout == 'ul') {
                            $skill_tags .= '<li><a href="' . $final_url . '">' . esc_html($taxonomy->name) . '</a></li>';
                        } else {
                            $skill_tags .= '<a href="' . $final_url . '">' . esc_html($taxonomy->name) . '</a>';
                        }
                        if ($count == 2) {
                            break;
                        }
                        $count++;
                    }
                }
            }
        }
        return $skill_tags;
    }

}
/* * *************************** */
/* Getting Last country value */
/* * ************************** */
if (!function_exists('nokri_get_candidates_location')) {

    function nokri_get_candidates_location($user_id = '') {
        $job_locations = array();
        $last_location = '';
        $job_locations = wp_get_object_terms($pid, array('ad_location'), array('orderby' => 'term_group'));
        if (!empty($job_locations)) {
            foreach ($job_locations as $location) {
                $last_location = '<a href="' . get_the_permalink($nokri['sb_search_page']) . '?job-location=' . $location->term_id . '">' . $location->name . '</a>';
            }
        }
    }

}
/* * *************************** */
/* Job post feilds label */
/* * ************************** */
if (!function_exists('nokri_feilds_label')) {

    function nokri_feilds_label($key = '', $default = '') {
        global $nokri;
        return (!empty($nokri["$key"]) && $nokri["$key"] != '') ? $nokri["$key"] : $default;
    }

}
/* ================================== */
/*  Getting saved resumes id's   */
/* =================================== */
if (!function_exists('nokri_emp_saved_resumes_ids')) {

    function nokri_emp_saved_resumes_ids() {
        $resumesArray = array();
        $emp_id = get_current_user_id();
        $resumes = get_user_meta($emp_id, '_emp_saved_resume_' . $emp_id, true);
        $resumesArray = explode(',', $resumes);
        return $resumesArray;
    }

}
/* ============================================= */
/*  Getting Member saved resumes of Owner id's   */
/* ============================================= */
if (!function_exists('nokri_get_member_emp_saved_resumes_ids')) {

    function nokri_get_member_emp_saved_resumes_ids() {
        $resumesArray = array();
        $user_id = get_current_user_id();
        $emp_id = get_user_meta($user_id, 'account_owner', true);
        $resumes = get_user_meta($emp_id, '_emp_saved_resume_' . $emp_id, true);
        $resumesArray = explode(',', $resumes);
        return $resumesArray;
    }

}

/* ================================== */
/*  Getting All candidaites skills  */
/* =================================== */
if (!function_exists('nokri_jobs_matches_candidates')) {

    function nokri_jobs_matches_candidates($job_id = '') {
        /* Candidate Job Notifications */
        $job_skills = wp_get_post_terms($job_id, 'job_skills', array("fields" => "ids"));
//$skillsz = array();
        $cands_meta_qry2['relation'] = 'OR';
        foreach ($job_skills as $skill) {
            $cands_meta_qry2[] = array('key' => '_cand_skills', 'value' => $skill, 'compare' => 'LIKE');
        }
        $cands_meta_qry = array();
        $cands_meta_qry[] = array('key' => '_sb_reg_type', 'value' => '0', 'compare' => '=');
        $args = array('role' => 'subscriber', 'meta_query' => array($cands_meta_qry, $cands_meta_qry2));
// Create the WP_User_Query object
        $wp_user_query = new WP_User_Query($args);
        $users = $wp_user_query->get_results();
        $total_users = $wp_user_query->get_total();
        $notification = array();
        if (!empty($users) && $job_id != '') {
// Loop through results
            foreach ($users as $user) {
                $cand_id = $user->ID;
                $cand_name = $user->display_name;
                $cand_skills_value = get_user_meta($cand_id, '_cand_skills_values', true);
                $cand_skills_sum = isset($cand_skills_value) && !empty($cand_skills_value) && is_array($cand_skills_value) ? array_sum($cand_skills_value) : '';
                update_user_meta($cand_id, '_cand_skills_sum', sanitize_text_field($cand_skills_sum));
                $notification[] = $cand_id;
            }
        }
        return $notification;
    }

}
/* ================================== */
/*  Getting User profile picture  */
/* =================================== */
if (!function_exists('nokri_get_user_profile_pic')) {

    function nokri_get_user_profile_pic($user_id = '', $user_key = '') {
        global $nokri;
        $image_dp_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
        if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
            $image_dp_link = array($nokri['nokri_user_dp']['url']);
        }
        if (get_user_meta($user_id, $user_key, true) != '') {
            $attach_dp_id = get_user_meta($user_id, $user_key, true);
            $image_dp_link = wp_get_attachment_image_src($attach_dp_id, '');
        }
        return $image_dp_link[0];
    }

}
/* ================================== */
/*  Getting Job Informations   */
/* =================================== */
if (!function_exists('nokri_get_jobs_informations')) {

    function nokri_get_jobs_informations($job_id = '', $term_name = '') {
        global $nokri;
        $user_id = get_current_user_id();
        $post_author_id = get_post_field('post_author', $job_id);
        $job_type = wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
        $job_type = isset($job_type[0]) ? $job_type[0] : '';
        $job_salary = wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
        $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
        $job_currency = wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
        $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
        $job_salary_type = wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
        $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
        /* Getting Profile Photo */
        $rel_image_link = nokri_get_user_profile_pic($post_author_id, '_sb_user_pic');
        /* Calling Funtion Job Class For Badges */
        $job_badge_text = nokri_premium_job_class_badges($job_id);
        if ($job_badge_text != '') {
            $featured_html = '<div class="features-star"><i class="fa fa-star"></i></div>';
        }
        /* Getting Last country value */
        $job_locations = array();
        $last_location = '';
        $job_locations = wp_get_object_terms($job_id, array('ad_location'), array('orderby' => 'term_group'));
        if (!empty($job_locations)) {
            foreach ($job_locations as $location) {
                $search_url = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job-location', $location->term_id);
                $last_location = '<a href="' . esc_url(nokri_page_lang_url_callback($search_url)) . '">' . $location->name . '</a>';
            }
        }
        /* save job */
        $user_id = '';
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
        }
        $job_bookmark = get_post_meta($job_id, '_job_saved_value_' . $user_id, true);
        if ($job_bookmark == '') {
            $save_job = '<a href="javascript:void(0)" class="n-job-saved save_job" data-value = "' . $job_id . '"><i class="fa fa-heart-o"></i></a>';
        } else {
            $save_job = '<a href="javascript:void(0)" class="n-job-saved saved"><i class="fa fa-heart"></i></a>';
        }
    }

}
/* ================== */
/*  Get Custom Feilds  */
/* ================== */
if (!function_exists('nokri_get_custom_feilds')) {

    function nokri_get_custom_feilds($author_id = '', $feilds_for = '', $id = '', $edit_profile = '', $show_profile = '') {
        if ($author_id == '') {
            $user_id = get_current_user_id();
        } else {
            $user_id = $author_id;
        }
        $edit_profile = $edit_profile;
        $args = array(
            'p' => $id,
            'post_type' => 'custom_feilds',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(array('key' => '_custom_feild_for', 'value' => $feilds_for)),
        );
        $args = nokri_wpml_show_all_posts_callback($args);
        $posts = new WP_Query($args);
        $custom_feilds = '';
        if ($posts->have_posts()) {
            while ($posts->have_posts()) {
                $posts->the_post();
                the_content();
                $id = get_the_id();
                $custom_feilds_for = get_post_meta($id, '_custom_feild_for', true);
                $custom_feilds = json_decode(get_post_meta($id, '_custom_feilds', true));
            }
        }
        wp_reset_query();
        $custom_feilds_html = $read_only = $requires = '';
        if (is_array($custom_feilds)) {
            foreach ($custom_feilds as $value) {
                $field_type = $value->feild_type;
                $field_label = $value->feild_label;
                $field_value = $value->feild_value;
                $field_req = $value->feild_req;
                $field_pub = $value->feild_pub;
                $field_values = (explode("|", $field_value));
                if (!$show_profile) {
                    /* Check boxes */
                    if ($field_type == 'RadioButton') {
                        $check_html = '';
                        foreach ($field_values as $value) {
                            $field_slug = preg_replace('/\s+/', '', $field_label);
                            $meta_value = get_user_meta($user_id, $field_slug, true);
                            $checked = ($meta_value == $value) ? 'checked="checked"' : '';
                            if ($field_req) {
                                $message = 'data-parsley-error-message="' . __('This field is required.', 'nokri') . '"';
                                $requires = 'data-parsley-required="true" ' . $message;
                            }
                            $check_html .= '<li><input type="radio" name="_custom_[' . $field_slug . ']" class="input-icheck-others" ' . esc_attr($checked) . '  value="' . esc_attr($value) . '" ' . $requires . '><p>' . esc_html($value) . '</p></li>';
                        }
                        $custom_feilds_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                         <label class="">' . esc_html($field_label) . '</label>
                                                            <ul class="custom-radiobox">
                                                                ' . $check_html . ' 
                                                            </ul>
                                                        </div>
                                                    </div>';
                    }
                    /* Input */
                    if ($field_type == 'Input') {
                        $field_slug = preg_replace('/\s+/', '', $field_label);
                        $meta_value = get_user_meta($user_id, $field_slug, true);
                        if ($field_req == 'Yes') {
                            $message = 'data-parsley-error-message="' . __('This field is required.', 'nokri') . '"';
                            $requires = 'data-parsley-required="true" ' . $message;
                        }
                        $custom_feilds_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="form-group">
                            <input placeholder="' . $field_label . '" class="form-control" type="text" ' . $requires . ' name="_custom_[' . $field_slug . ']" value="' . $meta_value . '">
                        </div></div>';
                    }
                    /* Number */
                    if ($field_type == 'Number') {
                        $field_slug = preg_replace('/\s+/', '', $field_label);
                        $meta_value = get_user_meta($user_id, $field_slug, true);
                        $requires = '';
                        if ($field_req == 'Yes') {
                            $message = 'data-parsley-error-message="' . __('This field is required.', 'nokri') . '"';
                            $requires = 'data-parsley-required="true" ' . $message;
                        }
                        $custom_feilds_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="form-group">
                            <input placeholder="' . $field_label . '" class="form-control" type="Number" data-parsley-type="digits" ' . $requires . ' name="_custom_[' . $field_slug . ']" value="' . $meta_value . '">
                        </div></div>';
                    }
                    /* Text Area */
                    if ($field_type == 'Text Area') {
                        $field_slug = preg_replace('/\s+/', '', $field_label);
                        $meta_value = get_user_meta($user_id, $field_slug, true);
                        $requires = '';
                        if ($field_req == 'Yes') {
                            $message = 'data-parsley-error-message="' . __('This field is required.', 'nokri') . '"';
                            $requires = 'data-parsley-required="true" ' . $message;
                        }
                        $custom_feilds_html .= '<div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="">' . esc_html($field_label) . '</label>
                                                        <textarea  name="_custom_[' . $field_slug . ']" class="form-control"   cols="30" rows="10" ' . ($requires) . '>' . esc_html($meta_value) . '</textarea>
                                                    </div>
                                                </div>';
                    }
                    /* Select Box */
                    if ($field_type == 'Select Box') {
                        $options = $selected = '';
                        $field_slug = preg_replace('/\s+/', '', $field_label);
                        $meta_value = get_user_meta($user_id, $field_slug, true);
                        $options = '<option value = "">' . esc_html__('Select option', 'nokri') . '</option>';

                        foreach ($field_values as $value) {
                            $selected = ($value == $meta_value) ? 'selected="selected"' : '';
                            $options .= '<option value="' . esc_attr($value) . '" ' . esc_attr($selected) . '>' . esc_html($value) . '</option>';
                        }
                        $requires = '';
                        if ($field_req == 'Yes') {
                            $message = 'data-parsley-error-message="' . __('This field is required.', 'nokri') . '"';
                            $requires = 'data-parsley-required="true" ' . $message;
                        }
                        $custom_feilds_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label>' . esc_html($field_label) . '</label>
                                                                <select class="js-example-basic-single" name="_custom_[' . $field_slug . ']" ' . $requires . '>
                                                                    ' . ($options) . ' 
                                                                </select>
                                                        </div>
                                                    </div>';
                    }
                    /* Date  */
                    if ($field_type == 'Date') {
                        $field_slug = preg_replace('/\s+/', '', $field_label);
                        $meta_value = get_user_meta($user_id, $field_slug, true);
                        $requires = '';
                        if ($field_req == 'Yes') {
                            $message = 'data-parsley-error-message="' . __('This field is required.', 'nokri') . '"';
                            $requires = 'data-parsley-required="true" ' . $message;
                        }


                        $custom_feilds_html .= '<div class="col-md-12 col-xs-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label >' . esc_html($field_label) . '</label>
                                                            <input type="text"   value="' . esc_attr($meta_value) . '" name="_custom_[' . $field_slug . ']" class="datepicker-custom-feilds form-control" ' . ($requires) . '/>
                                                        </div>
                                                    </div>';
                    }
                } else {
                    if ($field_pub == 'Yes') {
                        $field_slug = preg_replace('/\s+/', '', $field_label);
                        $meta_value = get_user_meta($user_id, $field_slug, true);
                        if ($meta_value != '')
                            $custom_feilds_html .= '<li><small>' . $field_label . '</small><strong>' . $meta_value . '</li></strong>';
                        else
                            $custom_feilds_html .= '';
                    }
                }
            }
        }
        return $custom_feilds_html;
    }

}
/* ======================== */
/*  Get Questions Answers  */
/* ======================= */
if (!function_exists('nokri_get_questions_answers')) {

    function nokri_get_questions_answers($job_id = '', $candidate_id = '') {
        $qstn_ans_html = '';
        $job_questions = $cand_answers = array();
        $job_questions = get_post_meta($job_id, '_job_questions', true);
        $cand_answers = get_user_meta($candidate_id, '_job_answers' . $candidate_id, true);
        if (isset($job_questions) && !empty($job_questions) && count($job_questions) > 0) {
            foreach ($job_questions as $key => $csv) {
                if (isset($cand_answers) && is_array($cand_answers)) {
                    if (array_key_exists($key, $cand_answers)) {
                        $skill_lavel = $cand_answers[$key];
                    }
                }
                $qstn_ans[] = array("question" => $csv, "answer" => $skill_lavel);
            }
        }
        if (isset($qstn_ans) && !empty($qstn_ans)) {
            foreach ($qstn_ans as $res) {
                $qstn_ans_html .= '<label> ' . esc_html__("Question", "nokri") . ' : ' . esc_html($res['question']) . '</label><p>' . esc_html__("Answer", "nokri") . ' : ' . esc_html($res['answer']) . '</p>';
            }
        }
        return $qstn_ans_html;
    }

}
/* ====================================== */
/*  Computing Candidate Profile Percent  */
/* ===================================== */
if (!function_exists('nokri_updating_candidate_profile_percent')) {

    function nokri_updating_candidate_profile_percent() {
        $user_crnt_id = get_current_user_id();
        global $nokri;
        $profile_percent = isset($nokri['default_info']) ? $nokri['default_info'] : 5;
        /* Personal Info */
        $person = isset($nokri['person_info']) ? $nokri['person_info'] : 10;
        $cand_pesonal = get_user_meta($user_crnt_id, '_cand_intro', true);

        if ($cand_pesonal != '') {
            $profile_percent = $person + $profile_percent;
        }
        /* Skills */
        $skill = isset($nokri['skill_info']) ? $nokri['skill_info'] : 20;
        $cand_skills = get_user_meta($user_crnt_id, '_cand_skills', true);


        if (isset($cand_skills) && !empty($cand_skills) && $cand_skills[0] != 0) {

            $profile_percent = $skill + $profile_percent;
        }

        /* Resume Percentage */
        $resume = isset($nokri['resume_info']) ? $nokri['resume_info'] : 20;
        $cand_resume = get_user_meta($user_crnt_id, '_cand_resume', true);

        if (isset($cand_resume) && !empty($cand_resume) && $cand_resume[0] != '') {
            $profile_percent = $resume + $profile_percent;
        }

        /* Education */
        $edu = isset($nokri['edu_info']) ? $nokri['edu_info'] : 20;
        $cand_education = get_user_meta($user_crnt_id, '_cand_education', true);

        if ($cand_education && $cand_education[0]['degree_name'] != '') {

            $profile_percent = $edu + $profile_percent;
        }
        /* Profession */
        $prof = isset($nokri['prof_info']) ? $nokri['prof_info'] : 20;
        $cand_profession = get_user_meta($user_crnt_id, '_cand_profession', true);

        if ($cand_profession && $cand_profession[0]['project_organization'] != '') {
            $profile_percent = $prof + $profile_percent;
        }
        /* Certification */
        $cert = isset($nokri['cert_info']) ? $nokri['cert_info'] : 20;
        $cand_certif = get_user_meta($user_crnt_id, '_cand_certifications', true);

        if ($cand_certif && $cand_certif[0]['certification_name'] != '') {
            $profile_percent = $cert + $profile_percent;
        }

        /* Social */
        $social = isset($nokri['social_info']) ? $nokri['social_info'] : 5;
        $cand_fb = get_user_meta($user_crnt_id, '_cand_fb', true);
        $cand_tw = get_user_meta($user_crnt_id, '_cand_twiter', true);
        $cand_gog = get_user_meta($user_crnt_id, '_cand_google', true);
        $cand_lk = get_user_meta($user_crnt_id, '_cand_linked', true);
        if ($cand_fb || $cand_tw || $cand_gog || $cand_lk) {
            $profile_percent = $social + $profile_percent;
        }
        if ($profile_percent != '') {
            if ($profile_percent > 100) {
                $profile_percent = 100;
            }
            update_user_meta($user_crnt_id, '_cand_profile_percent', $profile_percent);
        }
    }

}
/* * ********************************* */
/* if parameter are multiple like 4 */
/* * ********************************* */
if (!function_exists('nokri_set_url_params_multi')) {

    function nokri_set_url_params_multi($nokri_listing = '', $key1 = '', $value1 = '', $key2 = '', $value2 = '', $key3 = '', $val3 = '') {
        if ($nokri_listing != '') {
            $nokri_listing = add_query_arg(array($key1 => $value1, $key2 => $value2, $key3 => $val3), $nokri_listing);
            $nokri_listing = nokri_page_lang_url_callback($nokri_listing);
        }
        return $nokri_listing;
    }

}
/* * ********************************* */
/* == set url params for wpml == */
/* * ********************************* */
if (!function_exists('nokri_set_url_param')) {

    function nokri_set_url_param($nokri_listing = '', $key = '', $value = '') {
        if ($nokri_listing != '') {
            $nokri_listing = add_query_arg(array($key => $value), $nokri_listing);
        }
        return $nokri_listing;
    }

}
/* * ********************************* */
/* Getting origional Term ID */
/* * ********************************* */
if (!function_exists('nokri_get_origional_term_id')) {

    function nokri_get_origional_term_id($term_id = '') {
        global $sitepress;
        if (function_exists('icl_object_id')) {
            $term_id = icl_object_id($term_id, 'job_class', false, $sitepress->get_default_language());
        }
        return $term_id;
    }

}
/* * ********************************* */
/* get current page id for redirect in  wpml */
/* * ********************************* */
if (!function_exists('nokri_language_page_id_callback')) {

    function nokri_language_page_id_callback($page_id = '') {
        global $sitepress;
        if (function_exists('icl_object_id') && function_exists('wpml_init_language_switcher') && $page_id != '' && is_numeric($page_id)) {
            $language_code = $sitepress->get_current_language();
            $lang_page_id = icl_object_id($page_id, 'page', false, $language_code);
            if ($lang_page_id <= 0) {
                $lang_page_id = $page_id;
            }
            return $lang_page_id;
        } else {
            return $page_id;
        }
    }

}
/* * ********************************* */
/* == check page language url for wpml  == */
/* * ********************************* */
if (!function_exists('nokri_page_lang_url_callback')) {

    function nokri_page_lang_url_callback($page_url = '') {
        global $sitepress;
        if (function_exists('icl_object_id') && $page_url != '') {
            $page_url = apply_filters('wpml_permalink', $page_url, ICL_LANGUAGE_CODE, true);
        }
        return $page_url;
    }

}
/* * ********************************* */
/* == check page language url for wpml  == */
/* * ********************************* */
if (!function_exists('nokri_get_origional_product_id')) {

    function nokri_get_origional_product_id($product_id = '') {
        global $sitepress;
        if (function_exists('icl_object_id')) {
            $wpml_options = get_option('icl_sitepress_settings');
            $default_lang = $wpml_options['default_language'];
            $product_id = icl_object_id($product_id, 'product', false, $default_lang);
        }
        return $product_id;
    }

}
/* * ********************************* */
/* include hidden value for language parameter */
/* * ********************************* */
if (!function_exists('nokri_form_lang_field_callback')) {

    function nokri_form_lang_field_callback($echo = false) {
        global $sitepress;
        $hidden_lang_html = '';
        if (function_exists('icl_object_id')) {
            if ($sitepress->get_setting('language_negotiation_type') == 3) {
                $hidden_lang_html = '<input name="lang" type="hidden" value="' . ICL_LANGUAGE_CODE . '">';
            }
        }
        if ($echo) {
            echo nokri_returnEcho($hidden_lang_html);
        } else {
            return $hidden_lang_html;
        }
    }

}

function nokri_returnEcho($html = '') {
    return $html;
}

/* * ********************************* */
/* Adding supress in query */
/* * ********************************* */
if (!function_exists('nokri_wpml_show_all_posts_callback')) {

    function nokri_wpml_show_all_posts_callback($query_args = array()) {
        global $nokri;
        global $sitepress;
        $nokri_show_posts = isset($nokri['nokri_display_all_lang']) ? $nokri['nokri_display_all_lang'] : false;
        if (function_exists('icl_object_id') && $query_args != '' && $nokri_show_posts) {
            nokri_reset_wpml_taxonomy_data();
            $query_args['suppress_filters'] = true;
        }
        return $query_args;
    }

}
/* * ********************************* */
/* Duplicate post in all language or in current language */
/* * ********************************* */
if (!function_exists('nokri_duplicate_posts_lang_callback')) {

    function nokri_duplicate_posts_lang_callback($org_post_id = 0) {
        global $sitepress;
        $nokri_duplicate_post = false;
        if (class_exists('Redux')) {
            $_duplicate_post = Redux::getOption('nokri', 'nokri_duplicate_jobs');
        }
        if (function_exists('icl_object_id') && $org_post_id != 0 && $_duplicate_post) {
            $language_details_original = $sitepress->get_element_language_details($org_post_id, 'post_job_post');
            if (!class_exists('TranslationManagement')) {
                include(ABSPATH . 'wp-content/plugins/sitepress-multilingual-cms/inc/translation-management/translation-management.class.php');
            }
            foreach ($sitepress->get_active_languages() as $lang => $details) {
                if ($lang != $language_details_original->language_code) {
                    $iclTranslationManagement = new TranslationManagement();
                    $iclTranslationManagement->make_duplicate($org_post_id, $lang);
                }
            }
        }
    }

}
if (!function_exists('nokri_show_taxonomy_all')) {

    function nokri_show_taxonomy_all($taxo_id, $taxo_nme) {
        global $sitepress;
        $nokri_show_posts = false;
        if (class_exists('Redux')) {
            $nokri_show_posts = Redux::getOption('nokri', 'nokri_display_all_lang');
        }
        if (function_exists('icl_object_id') && $nokri_show_posts) {
            $languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');
            $taxo = array();
            foreach ($languages as $val) {
                $taxo[] = apply_filters('wpml_object_id', $taxo_id, $taxo_nme, FALSE, $val['code']);
            }
//return original id if only one language.
            return $taxo;
        } else {
            return $taxo_id;
        }
    }

}
/* * ********************************* */
/* Resetting taxonomy arguments wpml */
/* * ********************************* */
if (!function_exists('nokri_reset_wpml_taxonomy_data')) {

    function nokri_reset_wpml_taxonomy_data() {
        if (!is_admin()) {
            global $sitepress;
            remove_filter('get_terms_args', array($sitepress, 'get_terms_args_filter'), 10);
            remove_filter('get_term', array($sitepress, 'get_term_adjust_id'), 1);
            remove_filter('terms_clauses', array($sitepress, 'terms_clauses'), 10);
        }
    }

}
/* * ********************************* */
/* Language Switcher Front End */
/* * ********************************* */
if (!function_exists('nokri_language_switcher')) {

    function nokri_language_switcher() {
        global $nokri;
        if (function_exists('icl_object_id')) {
            $lang_link = '';
            $languages = icl_get_languages('skip_missing=0&orderby=code');
            $final_img = esc_url(trailingslashit(get_template_directory_uri()) . 'images/translation.png');
            if (isset($nokri['all_lang_img']['url']) && $nokri['all_lang_img']['url'] != "") {
                $final_img = $nokri['all_lang_img']['url'];
            }
            $lang_name = ( isset($nokri['all_lang_txt']) && $nokri['all_lang_txt'] != "" ) ? $nokri['all_lang_txt'] : esc_html__('All Languages', 'nokri');
            if (!empty($languages)) {
                ?>
                <div class="dropup ad-language">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo esc_url($final_img); ?>" alt=""/>
                        <?php echo esc_html($lang_name); ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($languages as $lang) {
                            if ($lang['active']) {
                                $lang_link = "javascript:void(0)";
                            } else {
                                $lang_link = esc_url($lang['url']);
                            }
                            ?>
                            <li>
                                <a href="<?php echo '' . $lang_link; ?>">
                                    <img src="<?php echo esc_url($lang['country_flag_url']); ?>"><?php echo icl_disp_language($lang['native_name']); ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php
            }
        }
    }

}
/* * ********************************* */
/* Wpml theme options hook */
/* * ********************************* */
add_action('nokri_wpml_settings_options', 'nokri_wpml_settings_options_callback', 10, 1);
if (!function_exists('nokri_wpml_settings_options_callback')) {

    function nokri_wpml_settings_options_callback($opt_name = '') {
        $options = '';
        if (!function_exists('icl_object_id')) {
            return $options;
        }
        $options = array(
            'title' => __('WPML Settings', 'nokri'),
            'id' => 'sb-wpml-settings',
            'desc' => '',
            'icon' => 'el el-globe',
            'fields' => array(
                array(
                    'id' => 'nokri_display_wpml_in_nav',
                    'type' => 'switch',
                    'title' => esc_html__('Display Languages in Navigation Menu', 'nokri'),
                    'subtitle' => esc_html__('Enable/Disable in all languages in nav menu ', 'nokri'),
                    'default' => false,
                ),
                array(
                    'id' => 'nokri_duplicate_jobs',
                    'type' => 'switch',
                    'title' => esc_html__('Duplicate new jobs in all languages', 'nokri'),
                    'subtitle' => esc_html__('Enable/Disable duplication ', 'nokri'),
                    'default' => false,
                ),
                array(
                    'id' => 'nokri_display_all_lang',
                    'type' => 'switch',
                    'title' => esc_html__('Display jobs in all languages', 'nokri'),
                    'subtitle' => esc_html__('Enable/Disable in all languages ', 'nokri'),
                    'default' => false,
                ),
                array(
                    'id' => 'nokri_lang_switch_frnt',
                    'type' => 'switch',
                    'title' => esc_html__('Show/Hide language switcher at front end', 'nokri'),
                    'subtitle' => esc_html__('Enable/Disable switcher ', 'nokri'),
                    'default' => false,
                ),
                array(
                    'required' => array('nokri_lang_switch_frnt', '=', array('1')),
                    'id' => 'all_lang_txt',
                    'type' => 'text',
                    'title' => __('Language Dropup Text', 'nokri'),
                    'default' => '',
                ),
                array(
                    'required' => array('nokri_lang_switch_frnt', '=', array('1')),
                    'id' => 'all_lang_img',
                    'type' => 'media',
                    'url' => true,
                    'title' => esc_html__('Language Dropup Image', 'nokri'),
                    'compiler' => 'true',
                    'subtitle' => esc_html__('Dimensions: 200 x 200', 'nokri'),
                    'default' => array('url' => get_template_directory_uri() . '/images/translation.png'),
                ),
            )
        );
        Redux::setSection($opt_name, $options);
    }

}
/* * ********************************* */
/* Wpml page translation */
/* * ********************************* */
if (!function_exists('nokri_language_page_id_callback')) {

    function nokri_language_page_id_callback($page_id = '') {
        global $sitepress;
        if (function_exists('icl_object_id') && function_exists('wpml_init_language_switcher') && $page_id != '' && is_numeric($page_id)) {
            $language_code = $sitepress->get_current_language();
            $lang_page_id = icl_object_id($page_id, 'page', false, $language_code);
            if ($lang_page_id <= 0) {
                $lang_page_id = $page_id;
            }
            return $lang_page_id;
        } else {
            return $page_id;
        }
    }

}

/* change candidate status received  to viewed when emp view profilew */
add_action('wp_ajax_can_set_auto_viewed', 'nokri_can_set_auto_viewed');
add_action('wp_ajax_can_set_auto_viewed', 'nokri_can_set_auto_viewed');
if (!function_exists('nokri_can_set_auto_viewed')) {

    function nokri_can_set_auto_viewed() {

        $cand_status = $_POST['cand_status'];
        $cand_id = $_POST['cand_id'];
        $job_id = $_POST['job_id'];



        if ($cand_status != '' && $cand_id != '' && $job_id != '') {

            update_post_meta($job_id, '_job_applied_status_' . $cand_id, $cand_status + 1);
            echo "1";
        } else {
            echo "0";
        }
        die();
    }

}

function strip_tags_content($text, $tags = '', $invert = FALSE) {

    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
    $tags = array_unique($tags[1]);
    $output = '';
    if (is_array($tags) AND count($tags) > 0) {
        if ($invert == FALSE) {
            $output = preg_replace('@<(?!(?:' . implode('|', $tags) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
        } else {
            $output = preg_replace('@<(' . implode('|', $tags) . ')\b.*?>.*?</\1>@si', '', $text);
        }
    } elseif ($invert == FALSE) {
        $output = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    if (strpos($output, ">") != '') {
        return '';
    } else {
        return esc_html($output);
    }
}

/* counting avg user rating */
if (!function_exists('avg_user_rating')) {

    function avg_user_rating($user_id = '') {
        $total_ratings_count = nokri_employer_review_count($user_id);
        $args = array(
            'user_id' => $user_id,
            'type' => 'dealer_review',
        );

        $get_rating = get_comments($args);
        if (count((array) $get_rating) > 0) {
            $avg_array = array();
            foreach ($get_rating as $get_ratings) {
                $comment_ids = $get_ratings->comment_ID;

                $service_stars = get_comment_meta($comment_ids, '_rating_service', true);
                $process_stars = get_comment_meta($comment_ids, '_rating_proces', true);
                $selection_stars = get_comment_meta($comment_ids, '_rating_selection', true);

                $single_avg = 0;
                $total_stars = $service_stars + $process_stars + $selection_stars;
                $single_avg = round($total_stars / "3", 1);


                $avg_array[] = $single_avg;
            }
            $total_sum = array_sum($avg_array);

            $total_avg = round($total_sum / $total_ratings_count, 1);
            //return $avg_array ;
            $html = '<ul class="review-stars">';
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $total_avg)
                    $html .= '<li class="star colored-star"><i class="fa fa-star"></i></li>';
                else
                    $html .= '<li class="star"><i class="fa fa-star"></i></li>';
            }
            $html .= '</ul>';
            return $html;
        }
    }

}
if (!function_exists('review_pagination')) {

    function review_pagination($total_records, $current_page) {
//$total_record.'' ;
//$current_page.'b';
// Check if a records is set.
        if (!isset($total_records))
            return;
        if (!isset($current_page))
            return;
        $next_text = esc_html__('Next Page »', 'nokri');
        $prev_text = esc_html__('« Previous Page', 'nokri');
        $args = array(
            'base' => add_query_arg('paged', '%#%'),
            'format' => '?paged=%#%',
            'total' => $total_records,
            'current' => $current_page,
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => $prev_text,
            'next_text' => $next_text,
            'type' => 'plain');
        return paginate_links($args);
    }

}

//last login
if (!function_exists('nokri_get_last_login')) {

    function nokri_get_last_login($uid) {
        $from = get_user_meta($uid, '_sb_last_login', true);
        $last = ($from) ? $from : time();
        return human_time_diff($last, time());
    }

}


if (!function_exists('emp_get_custom_location')) {

    function emp_get_custom_location($author_id) {
        $emp_custom_location = get_user_meta($author_id, '_emp_custom_location', true);
        $levelz = count((array) $emp_custom_location);
        $emp_custom_location_txt = "";
        $ad_countries = nokri_get_cats('ad_location', 0);
        $country_html = '';

        if (isset($emp_custom_location[0])) {

            $term = get_term_by('id', $emp_custom_location[0], 'ad_location');
            $emp_custom_location_txt = isset($term->name) ? $term->name : "";
        }
        if (isset($emp_custom_location[1])) {

            $term = get_term_by('id', $emp_custom_location[1], 'ad_location');
            $emp_custom_location_txt .= isset($term->name) ? "," . $term->name . "," : "";
        }
        if (isset($emp_custom_location[2])) {

            $term = get_term_by('id', $emp_custom_location[2], 'ad_location');
            $emp_custom_location_txt .= isset($term->name) ? $term->name . "," : "";
        }
        if (isset($emp_custom_location[3])) {

            $term = get_term_by('id', $emp_custom_location[3], 'ad_location');
            $emp_custom_location_txt .= isset($term->name) ? $term->name : "";
        }

        return $emp_custom_location_txt;
    }

}

//Check if page is elementor page or simple page
function nokri_check_is_elementor($page_id) {

    if (class_exists('Elementor\Plugin')) {
        return \Elementor\Plugin::$instance->db->is_built_with_elementor($page_id);
    } else {
        return false;
    }
}

//count all review of employer

if (!function_exists('nokri_employer_review_count')) {

    function nokri_employer_review_count($author_id) {
        $new_reviews = '';
        $args = array(
            'user_id' => $author_id,
            'type' => 'dealer_review',
        );
        $total_reviews = count((array) get_comments($args));
        return $total_reviews;
    }

    add_action('wp_enqueue_scripts', 'nokri_employer_review_count', 100);
}

//Allow formated text or not
function nokri_get_formated_description($content) {
    $allow_tags = array(
        'br' => array(),
        'em' => array(),
        'strong' => array(),
        'ul' => nokri_required_attributes(),
        'ol' => nokri_required_attributes(),
        'p' => nokri_required_attributes(),
        'b' => array(),
        'i' => array(),
        'u' => array(),
        'li' => array(),
    );
    $string = wp_kses($content, $allow_tags);
    return '<p class="details">' . nl2br($string) . '</p>';
}

//auto completed order for woocomerce
add_action('woocommerce_thankyou', 'custom_woocommerce_auto_order_status');

function custom_woocommerce_auto_order_status($order_id) {
    if (!$order_id) {
        return;
    }
    global $nokri;
    $is_approve = isset($nokri['sb_allow_auto_order_complete']) ? $nokri['sb_allow_auto_order_complete'] : false;
    $order = wc_get_order($order_id);
    if ($is_approve) {
        $order->update_status('completed');
    } else {
        $order->update_status("processing", 'Imported order', TRUE);
    }
}

/* check candidate settings */

function nokri_check_cand_settings($value = "") {
    $show = true;
    if ($value == "no") {
        $show = false;
    }
    return $show;
}

// verify nonces 

if (!function_exists('nokri_verify_nonce')) {

    function nokri_verify_nonce($nonce, $key) {

        if (!wp_verify_nonce($nonce, $key)) {

            $message = esc_html__('Direct acces not allowed', 'nokri');
            die($message);
        }
    }

}

// custom 
// cand dotted name 
if (!function_exists('nokri_return_dotted_name')) {

    function nokri_return_dotted_name($name) {
        global $nokri;

        $is_dotted = isset($nokri['cand_half_name_switch']) ? $nokri['cand_half_name_switch'] : false;
        if ($is_dotted) {
            $name_split = explode(' ', $name);
            if (isset($name_split[1]) && isset($name_split[1][0])) {
                return $name_split[0] . " " . $name_split[1][0] . ".....";
            } else {

                return $name;
            }
        } else {
            return $name;
        }
    }

}

// Employeer dotted name 
if (!function_exists('nokri_employe_return_dotted_name')) {

    function nokri_employe_return_dotted_name($name) {
        global $nokri;

        $is_dotted = isset($nokri['employe_half_name_switch']) ? $nokri['employe_half_name_switch'] : false;
        if ($is_dotted) {
            $name_split = explode(' ', $name);
            if (isset($name_split[1]) && isset($name_split[1][0])) {
                return $name_split[0] . " " . $name_split[1][0] . ".....";
            } else {

                return $name;
            }
        } else {
            return $name;
        }
    }

}

//  Getting horizontal search bar html structure 
function nokri_return_horizontal_search_bar() {

    global $nokri;

    $job_title = isset($_GET['job-title']) ? $_GET['job-title'] : "";

    $selected_cat = isset($_GET['cat-id']) ? $_GET['cat-id'] : "";
    $cats_html = nokri_return_taxanomy_options('job_category', $selected_cat, true);

    $selected_loc = isset($_GET['job-location']) ? $_GET['job-location'] : "";
    $countries_html = nokri_return_taxanomy_options('ad_location', $selected_loc, true);

    $multi_searach = ( isset($nokri['multi_job_search_form']) && $nokri['multi_job_search_form'] != "" ) ? $nokri['multi_job_search_form'] : false;
    ?>

    <li>
        <div class="form-group">
            <label><?php echo esc_html__('Job Title', 'nokri') ?></label>
            <input type="text" id="autocomplete-dynamic" autocomplete="off" class="form-control" name="job-title" value="<?php echo esc_attr($job_title); ?>" placeholder="<?php echo esc_html__('Enter keyword or title', 'nokri'); ?>">

        </div>
    </li>
    <li>
        <div class="form-group">
            <label><?php echo esc_html__('Select Category', 'nokri'); ?></label>
            <select class="js-example-basic-single" name="cat-id">
                <?php echo '' . $cats_html; ?>
            </select>
        </div>
    </li>
    <li>
        <div class="form-group">
            <label><?php echo esc_html__('Search by Location', 'nokri'); ?></label>
            <select class="js-example-basic-single" name="job-location">
                <?php echo '' . $countries_html; ?>
            </select>
        </div>
    </li>



    <?php
    $sidebars_widgets = wp_get_sidebars_widgets();

    if (isset($sidebars_widgets['horizontal_searchbar'])) {
        foreach ($sidebars_widgets['horizontal_searchbar'] as $id) {
            $wdgtvar = 'widget_' . _get_widget_id_base($id);
            $idvar = _get_widget_id_base($id);
            $instance = get_option($wdgtvar);
            $idbs = str_replace($idvar . '-', '', $id);
            $taxonomy_name = isset($instance[$idbs]['taxonomy_list']) ? $instance[$idbs]['taxonomy_list'] : "";
            $taxonomy_title = isset($instance[$idbs]['title']) ? $instance[$idbs]['title'] : "";
            if ($taxonomy_name != "") {
                $taxonomies = get_terms($taxonomy_name, array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC', 'parent' => 0));
                $option = '<option value="">' . esc_html__('Select Option', 'nokri') . '</option>';
                $more_html = '';
                if (count((array) $taxonomies) > 0) {
                    $showed = true;
                    foreach ($taxonomies as $taxonomy) {

                        /* Skipping Free Job Class */
                        $emp_class_check = get_term_meta($taxonomy->term_id, 'emp_class_check', true);
                        if ($emp_class_check == 1) {
                            continue;
                        }
                        $selected = '';
                        if (isset($_GET[$taxonomy_name]) && $_GET[$taxonomy_name] != "" && $_GET[$taxonomy_name] == $taxonomy->term_id) {
                            $selected = "selected";
                        }
                        $option .= '<option value="' . $taxonomy->term_id . '"  ' . $selected . '>' . $taxonomy->name . '</option>';
                    }
                }
                if ($multi_searach) {
                    ?>
                    <li class="res-toggle">
                        <div class="form-group">
                            <label><?php echo esc_html($taxonomy_title) ?></label>
                            <select class="js-example-basic-single" name="<?php echo esc_attr($taxonomy_name); ?>">
                                <?php echo '' . $option; ?>
                            </select>
                        </div>
                    </li>              
                <?php } else { ?>       
                    <li class="res-toggle">
                        <form method="get" action="<?php echo get_the_permalink($nokri['sb_search_page']) ?>">
                            <div class="form-group">
                                <label><?php echo esc_html($taxonomy_title) ?></label>
                                <select class="js-example-basic-single select_submit" name="<?php echo esc_attr($taxonomy_name); ?>">
                                    <?php echo '' . $option; ?>
                                </select>
                            </div>
                            <?php echo nokri_search_params($taxonomy_name) ?>
                        </form>
                    </li> 

                    <?php
                }
            }
        }
    }
    ?>
    <li class="btn-filter-search">
        <div class="form-group">
            <div class="form-btn">
                <input type="submit" class="btn n-btn-flat"  value="<?php echo esc_attr__('Search', 'nokri') ?>">
                <a href="javascript:void(0)" class="btn n-btn-flat adv_opt"><?php echo esc_html__('Advance', 'nokri'); ?></a>
            </div>
        </div>
    </li>
    <?php
}

//returning select options for taxanomy

if (!function_exists('nokri_return_taxanomy_options')) {

    function nokri_return_taxanomy_options($taxanomy_name, $selected_opt, $count = true) {
        $cat_taxanomy = nokri_get_cats($taxanomy_name);
        $cats_html = "";
        $cats_html = '<option value="">' . esc_html__('Select Option', 'nokri') . '</option>';
        $selected = "";
        foreach ($cat_taxanomy as $cat) {
            $selected = "";
            if ($selected_opt == $cat->term_id) {
                $selected = "selected";
            }

            $ad_sub_cats = nokri_get_cats($taxanomy_name, $cat->term_id);
            $cat_count = "";
            if ($count) {
                $cat_count = "($cat->count)";
            }
            if (count($ad_sub_cats) > 0) {

                $cats_html .= '<option value="' . $cat->term_id . '"  ' . $selected . '>' . $cat->name . $cat_count;
                $selected_sub = "";
                foreach ($ad_sub_cats as $sub_cat) {
                    $selected_sub = "";
                    if ($selected_opt == $sub_cat->term_id) {
                        $selected_sub = "selected";
                    }

                    $cat_count = "";
                    if ($count) {
                        $cat_count = "($sub_cat->count)";
                    }
                    $cats_html .= '<option value="' . $sub_cat->term_id . '" ' . $selected_sub . '>' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . $cat_count . '</option>';
                    //sub sub cat
                    $ad_sub_sub_cats = nokri_get_cats($taxanomy_name, $sub_cat->term_id);
                    if (count($ad_sub_sub_cats) > 0) {
                        foreach ($ad_sub_sub_cats as $sub_cat_sub) {
                            $cat_count_sub = "";
                            if ($count) {
                                $cat_count_sub = "($sub_cat_sub->count)";
                            }
                            $selected_sub_sub = "";
                            if ($selected_opt == $sub_cat_sub->term_id) {
                                $selected_sub_sub = "selected";
                            }
                            $cats_html .= '<option value="' . $sub_cat_sub->term_id . '"   ' . $selected_sub_sub . '>' . '&nbsp;&nbsp; - &nbsp; - &nbsp;' . $sub_cat_sub->name . $cat_count_sub . ' </option>';
                            //sub sub sub cat
                            $ad_sub_sub_sub_cats = nokri_get_cats($taxanomy_name, $sub_cat_sub->term_id);
                            if (count($ad_sub_sub_sub_cats) > 0) {
                                foreach ($ad_sub_sub_sub_cats as $sub_cat) {
                                    $cat_sub_sub_count = "";
                                    if ($count) {
                                        $cat_sub_sub_count = $sub_cat->count;
                                    }
                                    $selected_sub_sub_sub = "";
                                    if ($selected_opt == $sub_cat->term_id) {
                                        $selected_sub_sub_sub = "selected";
                                    }

                                    $cats_html .= '<option value="' . $sub_cat->term_id . '"  ' . $selected_sub_sub_sub . '>' . '&nbsp;&nbsp; - &nbsp; - &nbsp;- &nbsp;' . $sub_cat->name . $cat_sub_sub_count . '</option>';
                                }
                            }
                        }
                    }
                }
                $cats_html .= '</option>';
            } else {
                $cats_html .= '<option value="' . $cat->term_id . '"  ' . $selected . '>' . $cat->name . $cat_count . '</option>';
            }
        }
        return $cats_html;
    }

}


//scheduled hours 
if (!function_exists('nokri_fetch_business_hours')) {

    function nokri_fetch_business_hours($user_id, $from_app = false) {
        $days_name = nokri_week_days($from_app);
        $days = array();
//check option is yes or not
        if (get_user_meta($user_id, 'nokri_business_hours', true) != "") {
            $listing_is_opened = get_user_meta($user_id, 'nokri_business_hours', true);
            $days = array();
            $custom_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');


            for ($a = 0; $a <= 6; $a++) {
                $week_days = lcfirst($custom_days[$a]);
                if (get_user_meta($user_id, '_timingz_' . $week_days . '_open', true) == 1) {
                    //days which are opened
                    $time_from = date('H:i', strtotime(get_user_meta($user_id, '_timingz_' . $week_days . '_from', true)));
                    $time_to = date('H:i', strtotime(get_user_meta($user_id, '_timingz_' . $week_days . '_to', true)));

                    if ($from_app) {

                        $time_from = date('h:i A', strtotime(get_user_meta($user_id, '_timingz_' . $week_days . '_from', true)));
                        $time_to = date('h:i A', strtotime(get_user_meta($user_id, '_timingz_' . $week_days . '_to', true)));
                        $days[] = array("day_name" => $days_name[$a], "start_time" => $time_from, "end_time" => $time_to, "closed" => false, "day_key" => $custom_days[$a]);
                    } else {
                        $days[] = array("day_name" => $days_name[$a], "start_time" => $time_from, "end_time" => $time_to, "closed" => false);
                    }
                } else {
                    //days which are closed
                    $time_from = date('H:i', strtotime(get_user_meta($user_id, '_timingz_' . $week_days . '_from', true)));
                    $time_to = date('H:i', strtotime(get_user_meta($user_id, '_timingz_' . $week_days . '_to', true)));

                    if ($from_app) {

                        $time_from = date('h:i A', strtotime(get_user_meta($user_id, '_timingz_' . $week_days . '_from', true)));
                        $time_to = date('h:i A', strtotime(get_user_meta($user_id, '_timingz_' . $week_days . '_to', true)));
                        $days[] = array("day_name" => $days_name[$a], "start_time" => $time_from, "end_time" => $time_to, "closed" => true, "day_key" => $custom_days[$a]);
                    } else {
                        $days[] = array("day_name" => $days_name[$a], "start_time" => $time_from, "end_time" => $time_to, "closed" => true);
                    }
                }
            }
            return $days;
        }
    }

}

//busines hour status
// Check Status Of Business Hours
if (!function_exists('nokri_business_hours_status')) {

    function nokri_business_hours_status($user_id) {
        if (get_user_meta($user_id, 'nokri_business_hours', true) == '1') {

            return '2';
        } else if (get_user_meta($user_id, 'nokri_business_hours', true) == '') {
            return '';
        } else {

            $listing_timezone = get_user_meta($user_id, 'nokri_user_timezone', true);
            if (nokri_checktimezone($listing_timezone) == true) {
                if ($listing_timezone != "") {
                    $current_day = lcfirst(date("l"));


                    $date = new DateTime("now", new DateTimeZone($listing_timezone));
                    $currentTime = $date->format('Y-m-d H:i:s');

                    $custom_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

                    $times = array();
                    for ($a = 0; $a <= 6; $a++) {
                        $week_days = lcfirst($custom_days[$a]);
                        $startTime = date('g:i a', strtotime(get_user_meta($user_id, '_timingz_' . $week_days . '_from', true)));
                        $endTime = date('g:i a', strtotime(get_user_meta($user_id, '_timingz_' . $week_days . '_to', true)));


                        $times[substr($week_days, 0, 3)] = $startTime . ' - ' . $endTime;
                    }
                    $currentTime = strtotime($currentTime);
                    return nokri_isOpen($currentTime, $times);
                }
            }
        }
    }

}

/* Bussines hours show */
if (!function_exists('nokri_show_business_hours')) {

    function nokri_show_business_hours($listing_id) {
        global $nokri_options;
        $days_name = nokri_week_days();
        $custom_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

        $days = '';
        $listing_is_opened = 0;
        //check option is yes or not
        $listing_is_opened = get_user_meta($listing_id, 'nokri_business_hours', true);

        if ($listing_is_opened == 2) {
            $days = array();
            for ($a = 0; $a <= 6; $a++) {
                $week_days = lcfirst($custom_days[$a]);
                //current day
                $current_day = lcfirst(date("l"));
                if ($current_day == $week_days) {
                    $current_day = $current_day;
                } else {
                    $current_day = '';
                }
                if (get_user_meta($listing_id, '_timingz_' . $week_days . '_open', true) == 1) {
                    //days which are opened
                    $user_id = get_post_field('post_author', $listing_id);
                    if (get_user_meta($user_id, 'nokri_user_hours_type', true) != "" && get_user_meta($user_id, 'nokri_user_hours_type', true) == "24") {
                        $time_from = date('H:i:s', strtotime(get_user_meta($listing_id, '_timingz_' . $week_days . '_from', true)));
                        $time_to = date('H:i:s', strtotime(get_user_meta($listing_id, '_timingz_' . $week_days . '_to', true)));
                    } else {
                        $time_from = date('g:i a', strtotime(get_user_meta($listing_id, '_timingz_' . $week_days . '_from', true)));
                        $time_to = date('g:i a', strtotime(get_user_meta($listing_id, '_timingz_' . $week_days . '_to', true)));
                    }

                    $days[] = array("day_name" => $days_name[$a], "start_time" => $time_from, "end_time" => $time_to, "closed" => '', "current_day" => $current_day);
                } else {
                    //days which are closed
                    $days[] = array("day_name" => $days_name[$a], "closed" => '1', "current_day" => $current_day);
                }
            }
            return $days;
        }
    }

}
/* check valid timezones */
if (!function_exists('nokri_checktimezone')) {

    function nokri_checktimezone($timezone) {
        $zoneList = timezone_identifiers_list(); # list of (all) valid timezones
        if (in_array($timezone, $zoneList)) {
            return true;
        } else {
            return false;
        }
    }

}
if (!function_exists('nokri_week_days')) {

    function nokri_week_days($from_app = false) {

        if ($from_app) {
            return array(0 => esc_html__('M', 'nokri'), 1 => esc_html__('T', 'nokri'), 2 => esc_html__('W', 'nokri'), 3 => esc_html__('T', 'nokri'), 4 => esc_html__('F', 'nokri'), 5 => esc_html__('S', 'nokri'), 6 => esc_html__('S', 'nokri'));
        } else {
            return array(0 => esc_html__('Monday', 'nokri'), 1 => esc_html__('Tuesday', 'nokri'), 2 => esc_html__('Wednesday', 'nokri'), 3 => esc_html__('Thursday', 'nokri'), 4 => esc_html__('Friday', 'nokri'), 5 => esc_html__('Saturday', 'nokri'), 6 => esc_html__('Sunday', 'nokri'));
        }
    }

}
/* Check open Hours */

function nokri_is_open_hours($now, $times) {
    $open = 0; // time until closing in seconds or 0 if closed
// merge opening hours of today and the day before
    $hours = array_merge(compileHours($times, strtotime('yesterday', $now)), compileHours($times, $now));

    foreach ($hours as $h) {
        if ($now >= $h[0] and $now < $h[1]) {
            $open = $h[1] - $now;
            return $open;
        }
    }
    return $open;
}

function nokri_compileHours($times, $timestamp) {
    $times = $times[strtolower(date('D', $timestamp))];
    if (!strpos($times, '-'))
        return array();
    $hours = explode(",", $times);
    $hours = array_map('explode', array_pad(array(), count($hours), '-'), $hours);
    $hours = array_map('array_map', array_pad(array(), count($hours), 'strtotime'), $hours, array_pad(array(), count($hours), array_pad(array(), 2, $timestamp)));
    end($hours);
    if ($hours[key($hours)][0] > $hours[key($hours)][1])
        $hours[key($hours)][1] = strtotime('+1 day', $hours[key($hours)][1]);
    return $hours;
}

function nokri_isOpen($now, $times) {
    $open = "0"; // time until closing in seconds or 0 if closed
// merge opening hours of today and the day before
    $hours = array_merge(nokri_compileHours($times, strtotime('yesterday', $now)), nokri_compileHours($times, $now));
    foreach ($hours as $h) {
        if ($now >= $h[0] and $now < $h[1]) {
            $open = $h[1] - $now;
            return $open;
        }
    }
    return $open;
}

/* Calculate differnece  between two jobs */
if (!function_exists('nokri_nearby_distance')) {

    function nokri_nearby_distance($lat1, $lon1, $lat2, $lon2, $unit) {
        $rounded_value = $final_distance = '';
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        if ($unit == "KM") {
            $final_distance = ($miles * 1.609344);
            $dist = round($final_distance, 1);
            return $dist;
        } else {
            $dist = round($miles, 1);
            return $dist;
        }
    }

}
//  mobile phone verification

if (!function_exists('nokri_send_sms')) {

    function nokri_send_sms($receiver_ph, $code) {
        global $nokri;
        $message = __('Your verification code is', 'nokri') . " " . $code;
        $gateway = nokri_verify_sms_gateway();

        if ($gateway == "iletimerkezi-sms") {
            $ilt_data = get_option('ilt_option');

            $options = ilt_get_options();
            $options['number_to'] = $receiver_ph;
            $options['message'] = $message;
            $args = wp_parse_args($args, $options);
            $is_args_valid = ilt_validate_sms_args($args);

            if (!$is_args_valid) {
                extract($args);
                $message = apply_filters('ilt_sms_message', $message, $args);
                try {
                    $client = Emarka\Sms\Client::createClient(['api_key' => $args['public_key'], 'secret' => $args['private_key'], 'sender' => $args['sender'],]);
                    $response = $client->send($receiver_ph, $message);
                    if (!$response) {
                        $is_args_valid = ilt_log_entry_format(__('[Api Error] Connection error', 'nokri'), $args);
                        $return = false;
                    } else {
                        $is_args_valid = ilt_log_entry_format(sprintf(__('Success! Message ID: %s', 'nokri'), $response), $args);
                        $return = true;
                    }
                } catch (\Exception $e) {
                    $is_args_valid = ilt_log_entry_format(sprintf(__('[Api Error] %s ', 'nokri'), $e->getMessage()), $args);
                    $return = false;
                }
            } else {
                $return = false;
            }

            ilt_update_logs($is_args_valid, $args['logging']);
            return $return;
        }

        if ($gateway == "twilio") {
            $twl_data = get_option('twl_option');

            $account_sid = $twl_data['account_sid'];
            $auth_token = $twl_data['auth_token'];
            $twilio_phone_number = $twl_data['number_from'];

            $client = new Twilio\Rest\Client($account_sid, $auth_token);
            try {
                $response = $client->messages->create($receiver_ph, array("from" => $twilio_phone_number, "body" => $message));
                return $response;
            } catch (\Exception $e) {
                echo '0|' . $e->getMessage();
                die();
            }
        }
    }

}

if (!function_exists('nokri_verify_sms_gateway')) {

    function nokri_verify_sms_gateway() {
        global $nokri;
        $gateway = '';
        if (in_array('wp-twilio-core/core.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $gateway = 'twilio';
        } else if (in_array('wp-iletimerkezi-sms/core.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $gateway = 'iletimerkezi-sms';
        }

        return $gateway;
    }

}


add_filter('get_avatar', 'nokri_user_avatar_image', 1, 5);

if (!function_exists('nokri_user_avatar_image')) {

    function nokri_user_avatar_image($avatar, $id_or_email, $size, $default, $alt) {
        global $nokri;
        $avatar_allow = isset($nokri['nokri_user_profile_avatar']) && $nokri['nokri_user_profile_avatar'] ? true : false;

        if ($avatar_allow) {
            $user = false;
            if (is_numeric($id_or_email)) {
                $id = (int) $id_or_email;
                $user = get_user_by('id', $id);
            } elseif (is_object($id_or_email)) {
                if (!empty($id_or_email->user_id)) {
                    $id = (int) $id_or_email->user_id;
                    $user = get_user_by('id', $id);
                }
            } else {
                $user = get_user_by('email', $id_or_email);
            }
            if ($user && is_object($user)) {
                if ($user->data->ID != '') {

                    $user_id = $user->data->ID;
                    $user_type = get_user_meta($user_id, '_sb_reg_type', true);
                    if ($user_type == '1') {

                        $image_link = get_template_directory_uri() . '/images/candidate-dp.jpg';

                        if (get_user_meta($user_id, '_sb_user_pic', true) != "") {
                            $attach_id = get_user_meta($user_id, '_sb_user_pic', true);
                            if (is_numeric($attach_id)) {
                                $src = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
                                $image_link = isset($src[0]) && $src[0] != "" ? $src[0] : "";
                            }
                        }
                    } else {
                        $image_link = nokri_get_user_profile_pic($user_id, '_cand_dp');
                    }
                    if (isset($image_link) && $image_link != "") {

                        $headers = @get_headers($image_link);
                        if (strpos($headers[0], '404') === false) {
                            $image_link = $image_link;
                        } else {
                            $image_link = $user_pic;
                        }
                    } else {
                        $image_link = $user_pic;
                    }
                    $avatar = $image_link;
                    $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
                }
            }
        }
        return $avatar;
    }

}
/* subscribe user on registration */
if (!function_exists('nokri_subscribe_user_on_registration')) {

    function nokri_subscribe_user_on_registration($user_id) {

        global $nokri;
        if (isset($nokri['subscribe_on_user_register'])) {

            if (isset($nokri['subscribe_on_user_register_listid']) && $nokri['subscribe_on_user_register_listid'] != "") {

                $listid = ( isset($nokri['subscribe_on_user_register_listid'])) ? $nokri['subscribe_on_user_register_listid'] : '';

                $apiKey = ( isset($nokri['mailchimp_api_key']) ) ? $nokri['mailchimp_api_key'] : '';

                if ($apiKey == "" || $listid == "") {
                    return '';
                }
                $user_info = get_userdata($user_id);
                if ($user_info) {
                    $email = $user_info->user_email;
                    $lname = $user_info->last_name;
                    $fname = $user_info->first_name;
                    if ($email) {
                        ;
                        $memberID = md5(strtolower($email));
                        $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
                        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listid . '/members/' . $memberID;
                        $json = json_encode(array(
                            'email_address' => $email,
                            'status' => 'subscribed',
                            'merge_fields' => array(
                                'FNAME' => $fname,
                                'LNAME' => $lname
                            )
                        ));
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
                    }
                }
            }
        }
    }

}

if (!function_exists('nokri_fetch_product_images')) {

    function nokri_fetch_product_images($productId) {
        $product = wc_get_product($productId);
        $attachmentIds = $product->get_gallery_image_ids();
        $attachmentIds[] = $product->get_image_id();
        return $attachmentIds;
    }

}

if (!class_exists('dwt_listing_products_shop')) {

    class dwt_listing_products_shop {

        // user object
        var $user_info;

        public function __construct() {
            $this->user_info = get_userdata(get_current_user_id());
        }

        // Get Shop Products
        function dwt_listing_shop_listings_shop_grid($product_id, $column_size = '', $clearfix = '') {
            if (empty($product_id)) {
                return;
            }

            $is_product = wc_get_product($product_id);
            $average = $review_count = $rating_count = $rating_stars = $product_img = $sale_banner = '';
            if ($is_product->is_on_sale()) {
                $sale_banner = '<span class="prod-sale-banner">' . esc_html__('Sale', 'nokri') . '</span>';
            }

            $img = $is_product->get_image_id();
            $photo = wp_get_attachment_image_src($img, 'dwt_listing_woo-thumb');
            if (!empty($photo)) {
                if ($photo[0] != "") {
                    $product_img = '<img class="img-responsive" alt="' . get_the_title($product_id) . '" src="' . esc_url($photo[0]) . '">';
                }
            } else {
                $product_img = '<img class="img-responsive" alt="' . get_the_title($product_id) . '" src="' . esc_url(wc_placeholder_img_src()) . '">';
            }

            if ('yes' === get_option('woocommerce_enable_review_rating')) {
                $rating_count = $is_product->get_rating_count();
                $review_count = $is_product->get_review_count();
                $average = $is_product->get_average_rating();
                if ($rating_count > 0) {
                    $rating_stars = wc_get_rating_html($average, $rating_count);
                }
            }
            $additional_div = '';
            if ($column_size == '4') {
                $column_size = 'col-md-4 col-sm-4 col-xs-12';
                if ($clearfix != "") {
                    if ($clearfix++ % 3 == 0) {
                        $additional_div = '<div class="clearfix"></div>';
                    }
                }
            } else {
                $column_size = 'col-md-3 col-sm-4 col-xs-12';
                if ($clearfix != "") {
                    if ($clearfix++ % 4 == 0) {
                        $additional_div = '<div class="clearfix"></div>';
                    }
                }
            }
            return '' . $additional_div . '<div class="' . $column_size . ' masonery_item">
             <a href="' . get_the_permalink($product_id) . '">
                <div class="dwt_listing_shop-grid foo">
                <div class="dwt_listing_shop-grid-description">
                    <div class="shop-img-rapper">
                        ' . $sale_banner . '
                        ' . $product_img . '
                        <div class="hover-effect">
                            <div><i class="ti-eye"></i></div>
                        </div>
                    </div>
                    <div class="title-wrapper">
                        <h2 class="woocommerce-loop-product__title">' . get_the_title($product_id) . ' </h2>
                    </div>
                        <div class="price-wrapper">
                        ' . $rating_stars . '
                            <span class="price">
                            ' . $is_product->get_price_html() . '
                            </span>
                        </div>
                    </div>
                </div>
                </a>
            </div>';
        }

        // Get Shop Products Slider
        function dwt_listing_shop_listings_shop_slider($product_id) {
            if (empty($product_id)) {
                return;
            }
            $is_product = wc_get_product($product_id);
            $average = $review_count = $rating_count = $rating_stars = $product_img = $sale_banner = '';
            if ($is_product->is_on_sale()) {
                $sale_banner = '<span class="prod-sale-banner">' . esc_html__('Sale', 'nokri') . '</span>';
            }
            $img = $is_product->get_image_id();
            $photo = wp_get_attachment_image_src($img, 'dwt_listing_woo-thumb');
            if ($photo != '') {
                if ($photo[0] != "") {
                    $product_img = '<img class="img-responsive" alt="' . get_the_title($product_id) . '" src="' . esc_url($photo[0]) . '">';
                }
            } else {
                $product_img = '<img class="img-responsive" alt="' . get_the_title($product_id) . '" src="' . esc_url(wc_placeholder_img_src()) . '">';
            }
            if ('yes' === get_option('woocommerce_enable_review_rating')) {
                $rating_count = $is_product->get_rating_count();
                $review_count = $is_product->get_review_count();
                $average = $is_product->get_average_rating();
                if ($rating_count > 0) {
                    $rating_stars = wc_get_rating_html($average, $rating_count);
                }
            }
            return '<div class="item">
             <a href="' . get_the_permalink($product_id) . '">
                <div class="dwt_listing_shop-grid">
                <div class="dwt_listing_shop-grid-description">
                    <div class="shop-img-rapper">
                        ' . $sale_banner . '
                        ' . $product_img . '
                        <div class="hover-effect">
                            <div><i class="ti-eye"></i></div>
                        </div>
                    </div>
                    <div class="title-wrapper">
                        <h2 class="woocommerce-loop-product__title">' . get_the_title($product_id) . ' </h2>
                    </div>
                        <div class="price-wrapper">
                        ' . $rating_stars . '
                            <span class="price">
                            ' . $is_product->get_price_html() . '
                            </span>
                        </div>
                    </div>
                </div>
                </a>
            </div>';
        }

    }

}

/* Remotely Work */
if (!function_exists('job_nokri_remotely_work')) {

    function job_nokri_remotely_work($job_id) {
        global $nokri;
        $remotely_work = get_post_meta($job_id, '_n_remotely_work', true);
        $ad_map_lat = get_post_meta($job_id, '_job_lat', true);
        $ad_map_long = get_post_meta($job_id, '_job_long', true);
        if ($remotely_work != '') {
            $job_location = '<div class="n-single-job-company">
                                <div class="dingle-job-company-meta"> 
                                        <h4>' . esc_html__('Job Location', 'nokri') . '</h4>
                                    <div class="contact-caption">                               
                                        <div class="view-profile "><h4>' . esc_html__('Work Remotely', 'nokri') . '</h4></div>                                   
                                    </div>
                                </div>                        
                            </div>';
        } else {
            $job_location = ' <div class="n-single-job-company">
                                    <div class="dingle-job-company-meta">
                                        <div id="itemMap" style="height:300px;" ></div>
                                            <input type="hidden" id="lat" value="' . esc_attr($ad_map_lat) . '" />
                                            <input type="hidden" id="lon" value="' . esc_attr($ad_map_long) . '" />
                                    </div>
                            </div>';
        }
        return $job_location;
    }

}

/* Location for job pages remotely/custom */
if (!function_exists('nokri_work_location_custom')) {

    function nokri_work_location_custom($job_id) {
        global $nokri;

        $remotely_work = get_post_meta($job_id, '_n_remotely_work', true);
        $job_location = "";
        if ($remotely_work != '') {
            $job_location = esc_html__('Work Remotely', 'nokri');
        } else {
            $job_location = nokri_job_country($job_id);
        }
        return $job_location;
    }

}

if (!function_exists('nokri_check_plugin_active')) {

    function nokri_check_plugin_active($plugin = "") {
        $is_active = false;
        if (in_array($plugin, get_option('active_plugins'))) {
            $is_active = true;
        }
        return $is_active;
    }

}
/* Jooble APi Integration to get jobs */
if (!function_exists('nokri_get_jooble_jobs')) {

    function nokri_get_jooble_jobs() {

        global $nokri;
        $user_id = get_current_user_id();
        if (isset($nokri['nokri_jooble_api_key']) && $nokri['nokri_jooble_api_key'] != '') {

            $api_key = $nokri['nokri_jooble_api_key'];
        }
        $url = "https://jooble.org/api/";
        $keywords = isset($_GET['job-title']) && $_GET['job-title'] ? $_GET['job-title'] : 'IT';
        $location = isset($_GET['job-location']) && $_GET['job-title'] ? $_GET['job-location'] : '';
        $data = array(
            'keywords' => $keywords,
            'location' => $location,
        );
        $data_str = json_encode($data, true);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . "" . $api_key);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($server_output, true);
        //print response
        return $result;
    }

}

/* Reedco Jobs Api Integration */
if (!function_exists('nokri_get_reedco_jobs')) {

    function nokri_get_reedco_jobs() {
        global $nokri;
        if (isset($nokri['nokri_reedco_api_key']) && $nokri['nokri_reedco_api_key'] != '') {

            $api_key = $nokri['nokri_reedco_api_key'];
        }
        $password = "";
        $keywords = isset($_GET['job-title']) && $_GET['job-title'] ? $_GET['job-title'] : 'web-developer';
        $location = isset($_GET['job-location']) && $_GET['job-title'] ? $_GET['job-location'] : '';
        /* Curl Initialization */
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.reed.co.uk/api/1.0/search?keywords='.$keywords.'&location='.$location.'",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic " . base64_encode($api_key . ":" . $password)
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $results = json_decode($response, true);
        return $results;
    }

}

/* Github Jobs Api Integration */
if (!function_exists('nokri_get_github_jobs')) {

    function nokri_get_github_jobs() {
        global $nokri;
        $keywordss = isset($_GET['job-title']) && $_GET['job-title'] ? $_GET['job-title'] : 'web+developer';
        $locations = isset($_GET['job-location']) && $_GET['job-title'] ? $_GET['job-location'] : '';
        $url = "https://jobs.github.com/positions.json?description=";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . '' . $keywordss . '&location=' . $locations,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $jobs_data = json_decode($response);
        return $jobs_data;
    }

}
/* Adzuna Jobs Integration */
if (!function_exists('nokri_import_adzuna_jobs')) {

    function nokri_import_adzuna_jobs() {

        global $nokri;
        if (isset($nokri['nokri_adzuna_api_id']) && $nokri['nokri_adzuna_api_id'] != '') {
            $apiID = $nokri['nokri_adzuna_api_id'];
        }
        if (isset($nokri['nokri_adzuna_api_key']) && $nokri['nokri_adzuna_api_key'] != '') {
            $apiKey = $nokri['nokri_adzuna_api_key'];
        }
        if (isset($nokri['nokri_adzuna_loc_keyword']) && $nokri['nokri_adzuna_loc_keyword'] != '') {
            $locKeyword = $nokri['nokri_adzuna_loc_keyword'];
        }
        $keywordss = isset($_GET['job-title']) && $_GET['job-title'] ? $_GET['job-title'] : 'web';
        //$locations = isset($_GET['job-location']) && $_GET['job-title'] ? $_GET['job-location'] : 'ca';
        $url = 'http://api.adzuna.com/v1/api/jobs/' . $locKeyword . '/search/1?app_id=' . $apiID . '&app_key=' . $apiKey . '&results_per_page=35&what=' . $keywordss . '&content-type=application/json';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $jobs_data = json_decode($response);
        return $jobs_data;
        //echo ''.$response;
    }

}
/* Candidate low profile scoring restriction */
if (!function_exists('low_prof_scoring_restrict')) {

    function low_prof_scoring_restrict() {

        global $nokri;
        $user_id = get_current_user_id();
        $percaentage_switch = isset($nokri['cand_per_switch']) ? $nokri['cand_per_switch'] : false;
        if ($percaentage_switch == true) {

            $profile_percent = get_user_meta($user_id, '_cand_profile_percent', true);
            $low_scoring_btn = isset($nokri['cand_prof_restrict']) ? $nokri['cand_prof_restrict'] : true;
            $profile_scoring = ( isset($nokri['restrict_per_apply_job']) && $nokri['restrict_per_apply_job'] != "" ) ? $nokri['restrict_per_apply_job'] : 20;

            if ($low_scoring_btn == false) {
                echo esc_html__('You can not apply for this Job with low scoring - ', 'nokri') . '' . $profile_percent . esc_html__('%', 'nokri');
            } if ($low_scoring_btn == true && $profile_percent < $profile_scoring) {
                echo esc_html__('Please Update your profile minimum ', 'nokri') . '' . $profile_scoring . esc_html__('% to apply this job', 'nokri');
            }
        }
    }

}
/* CareerJet Jobs */
if (!function_exists('nokri_get_careerjet_jobs')) {

    function nokri_get_careerjet_jobs() {

        global $nokri;
        $user_id = get_current_user_id();
        require trailingslashit(get_template_directory()) . "template-parts/careerjet_api.php";
        $keywords = isset($_GET['job-title']) && $_GET['job-title'] ? $_GET['job-title'] : 'IT';
        $location = isset($_GET['job-location']) && $_GET['job-title'] ? $_GET['job-location'] : '';
        $apikey = isset($nokri['careerJet_api_key']) && $nokri['careerJet_api_key'] ? $nokri['careerJet_api_key'] : '';
        $api = new Careerjet_API('en_GB');
        // $page = 1; # Or from parameters.
        $result = $api->search(array(
            'keywords' => $keywords,
            'location' => $location,
            //'page' => $page,
            'affid' => $apikey,
        ));
        if ($result->type == 'JOBS') {
            // echo "Found " . $result->hits . " jobs";
            // echo " on " . $result->pages . " pages\n";
            $jobs = $result->jobs;
            $final_array = $eachrecord = array();
            foreach ($jobs as $job) {
                $eachrecord['url'] = $job->url;
                $eachrecord['date'] = $job->date;
                $eachrecord['title'] = $job->title;
                $eachrecord['salary'] = $job->salary;
                $eachrecord['company'] = $job->company;
                $eachrecord['locations'] = $job->locations;
                $eachrecord['description'] = $job->description;
                // $eachrecord['salary_max'] = $job->salary_max;
                $final_array[] = $eachrecord;
            }
            if (is_array($final_array) && !empty($final_array)) {
                return $final_array;
            }
        }
    }

}

/* funtion to change slug as title and Post ID */
add_action('add_attachment', 'sb_nokri_attachment_id_as_slug');
if (!function_exists('sb_nokri_attachment_id_as_slug')) {

    function sb_nokri_attachment_id_as_slug($post_id) {
        if (get_post_field('post_name', $post_id) != $post_id) {
            $filetitle = get_the_title($post_id);
            wp_update_post(
                    array(
                        'ID' => $post_id,
                        'post_name' => $filetitle . ' - ' . $post_id,
                    )
            );
        }
    }

}
/* Change Existing Media files Slug */
if (!function_exists('nokri_update_slug_pdf_attachments')) {

    function nokri_update_slug_pdf_attachments() {

        $args = '';
        query_posts($args);
        while (have_posts()) : the_post();

            $unsupported_mimes = array('image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/tiff', 'image/x-icon', 'video/mp4');
            $all_mimes = get_allowed_mime_types();
            $accepted_mimes = array_diff($all_mimes, $unsupported_mimes);
            $args = array(
                'post_mime_type' => $accepted_mimes,
                'order' => 'DES',
                'orderby' => 'date',
                'post_type' => 'attachment',
                'numberposts' => -1,
            );
            $attachments = get_posts($args);
            if ($attachments) {
                foreach ($attachments as $attachment) {

                    $post_id = $attachment->ID;
                    $postTitle = $attachment->post_title;
                    wp_update_post(
                            array(
                                'ID' => $post_id,
                                'post_name' => $postTitle . '-sb-' . $post_id,
                            )
                    );
                }
            }
        endwhile;
    }

}

/* Assig Employer Member to Employer Permission based Right */
if (!function_exists('nokri_account_member_id_as_employer')) {

    function nokri_account_member_id_as_employer() {
        $current_id = get_current_user_id();

        /* Checking if Employer have Account Members with job posting permissions */
        $emp_id = get_user_meta($current_id, 'account_owner', true);
        $member_id = get_user_meta($current_id, '_sb_is_member', true);
        if (isset($member_id) && $member_id != '') {

            $user_id = $emp_id;
        } else {
            $user_id = $current_id;
        }
        return $user_id;
    }

}
/* Funtion to getting username from user object */
if (!function_exists('nokri_get_display_name')) {

    function nokri_get_display_name($user_id) {
        if (!$user = get_userdata($user_id)) {
            return false;
        }
        return $user->data->display_name;
    }

}
/* Function if user number is verified */
if (!function_exists('nokri_firebase_verified_number')) {

    function nokri_firebase_verified_number($user_id) {
        global $nokri;

        /* checking if number is verified */
        $verified_pho = get_user_meta($user_id, '_sb_verified_contact', true);
        $phoneNo = get_user_meta($user_id, '_sb_contact', true);

        if ($verified_pho == $phoneNo) {

            $numberVer = esc_html__('Number Verified ✅', 'nokri');
        } elseif ($verified_pho != $phoneNo) {

            $numberVer = esc_html__('Number Not verified ❌', 'nokri');
        } else {
            $numberVer = '';
        }
        return $numberVer;
    }

}

/* Getting Total Saved Resumes Count */
if (!function_exists('nokri_get_total_saved_resume_count')) {

    function nokri_get_total_saved_resume_count($user_id) {

        global $nokri;
        $c_name = '';
        if (isset($_GET['c_name'])) {
            if (isset($_GET['c_name']) && $_GET['c_name'] != "") {
                $c_name = $_GET['c_name'];
            }
        }
        $c_order = 'DESC';
        if (isset($_GET['c_order'])) {
            if (isset($_GET['c_order']) && $_GET['c_order'] != "") {
                $c_order = $_GET['c_order'];
            }
        }
        $resumes_array = nokri_emp_saved_resumes_ids();
        // total no of User to display
        $user_query = new WP_User_Query(
                array(
            'include' => $resumes_array,
            'search' => "" . esc_attr($c_name) . "*",
            'order' => $c_order,
        ));
        $total = $user_query->get_total();
        return $total;
    }

}
/* Getting Total Company Followers */

if (!function_exists('nokri_count_emp_followers')) {

    function nokri_count_emp_followers($user_id) {

        global $nokri;
        //$user_id = get_current_user_id();
        $c_name = '';
        if (isset($_GET['c_name'])) {
            if (isset($_GET['c_name']) && $_GET['c_name'] != "") {
                $c_name = $_GET['c_name'];
            }
        }
        $c_order = 'DESC';
        if (isset($_GET['c_order'])) {
            if (isset($_GET['c_order']) && $_GET['c_order'] != "") {
                $c_order = $_GET['c_order'];
            }
        }
        /* Getting Company Followers */
        // total no of User to display
        $limit = isset($nokri['user_pagination']) ? $nokri['user_pagination'] : 5;
        $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $offset = ($page * $limit) - $limit;
        $user_query = new WP_User_Query(
                array(
            'meta_key' => '_cand_follow_company_' . $user_id,
            'meta_value' => $user_id,
            'meta_compare' => 'LIKE',
            'search' => "*" . esc_attr($c_name) . "*",
            'number' => $limit,
            'offset' => $offset,
            'order' => $c_order,
        ));
        $emp_followers = $user_query->get_total();
        return $emp_followers;
    }

}
/* Get candidate saved jobs count */
if (!function_exists('nokri_get_cand_save_jobs_count')) {

    function nokri_get_cand_save_jobs_count($user_id) {

        global $nokri;
        $job_name = '';
        $job_order = 'DESC';
        if (isset($_GET['job_name'])) {
            $job_name = $_GET['job_name'];
        }
        $args = array(
            'post_type' => 'job_post',
            's' => $job_name,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_query' => array(array('key' => '_job_saved_value_' . $user_id,),),
        );
        $query = new WP_Query($args);
        $saved_jobs = $query->found_posts;
        return $saved_jobs;
    }

}
/* Getting Inactive jobs count */
if (!function_exists('nokri_inactive_jobs_count')) {

    function nokri_inactive_jobs_count($user_id) {

        global $nokri;
        //$user_id = get_current_user_id();
        $args = array(
            'author' => $user_id, 'post_type' => 'job_post', 'post_status' => array('publish', 'draft'),
            'meta_query' => array(
                array(
                    'key' => '_job_status',
                    'value' => 'inactive',
                    'compare' => '=',
                ),
            ),
        );
        $query = new WP_Query($args);
        $inactive_jobs = $query->found_posts;
        return $inactive_jobs;
    }

}

/* Getting Pending jobs count */
if (!function_exists('nokri_pending_jobs_count')) {

    function nokri_pending_jobs_count($user_id) {

        global $nokri;
        $job_name = (isset($_GET['job_name']) && $_GET['job_name'] != "") ? $_GET['job_name'] : '';
        $args = array('author' => $user_id, 'post_type' => 'job_post', 'post_status' => 'pending', 's' => $job_name);

        $query = new WP_Query($args);
        $pending_jobs = $query->found_posts;
        return $pending_jobs;
    }

}

/* Getting Resume counters */
if (!function_exists('nokri_admin_resume_counter')) {

    function nokri_admin_resume_counter($user_id) {

        //$user_id = get_current_user_id();
        /* Getting Company Published Jobs */
        $job_ids = '';
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'job_post',
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $paged,
            'author' => $user_id,
            'post_status' => array('publish'),
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            $job_id = array();
            while ($query->have_posts()) {

                $query->the_post();
                $job_id[] = get_the_ID();
            }
            wp_reset_postdata();
            $job_ids = implode(",", $job_id);
        }
        return ($job_ids );
    }

}

/* Cand Applied Jobs Stats */
if (!function_exists('nokri_cand_jobs_stats')) {

    function nokri_cand_jobs_stats($current_id) {

        $job_name = '';
        if (isset($_GET['job_name'])) {
            $job_name = $_GET['job_name'];
        }
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'job_post',
            's' => $job_name,
            'paged' => $paged,
            'posts_per_page' => get_option('posts_per_page'),
            'meta_key' => '_job_applied_date_' . $current_id,
            'orderby' => 'meta_value',
            'order' => 'date',
            'meta_query' => array(
                'relation' => 'AND',
                array('key' => '_job_applied_resume_' . $current_id),
                array(
                    'key' => '_job_status',
                    'value' => 'active',
                    'compare' => '='
                ),
            ),
        );
        $args = nokri_wpml_show_all_posts_callback($args);
        $query = new WP_Query($args);
        return $query;
    }

}

/* Remotive Jobs APi Integration to get jobs */
if (!function_exists('nokri_get_remotive_jobs')) {

    function nokri_get_remotive_jobs() {

        global $nokri;
        // https://remotive.io/api/remote-jobs?category=software-dev
        $url = "https://remotive.io/api/remote-jobs?";
        //$keywords = isset($_GET['job-title']) && $_GET['job-title'] ? $_GET['job-title'] : 'IT';
        //$location = isset($_GET['job-location']) && $_GET['job-title'] ? $_GET['job-location'] : '';
        $jobs_limit = isset($nokri['nokri_remotive_import_jobs']) ? $nokri['nokri_remotive_import_jobs'] : 5;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . 'limit=' . $jobs_limit,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($response, true);
        //print response
        return $result;
    }

}
if (!function_exists('nokri_get_candidate_alerts_list')) {

    function nokri_get_candidate_alerts_list() {

        global $nokri;
        $args = array(
            'order' => 'DESC',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_sb_reg_type',
                    'value' => '0',
                    'compare' => '='
                ),
                array(
                    'key' => '_cand_alerts_en',
                    'value' => '',
                    'compare' => '!='
                ),
            ),
        );
        $user_query = new WP_User_Query($args);
        $candidates = $user_query->get_results();

        return $candidates;
    }

}
/* Function to get count statistics against single active job appliers */
if (!function_exists('nokri_single_active_job_applier_count')) {

    function nokri_single_active_job_applier_count($job_id) {

        global $wpdb;
        $resume_query = "SELECT count(meta_id) as resume_count
                         FROM $wpdb->postmeta WHERE post_id IN ($job_id) AND meta_key like '_job_applied_resume_%'
                         GROUP BY meta_value ORDER BY meta_id LIMIT 7";
        $counts_resumes = array_reverse($wpdb->get_results($resume_query));
        $resume_count = "";
        if (isset($counts_resumes) && $counts_resumes != '') {
            foreach ($counts_resumes as $resume_counter) {

                $resume_count .= $resume_counter->resume_count . ', ';
            }
        }
        return $resume_count;
    }

}

/* Function to get applied dates statistics against single active job */
if (!function_exists('nokri_active_jobs_appliers_date')) {

    function nokri_active_jobs_appliers_date($job_id) {

        global $wpdb;
        $query = "SELECT * FROM $wpdb->postmeta WHERE post_id IN ($job_id) AND meta_key like '_job_applied_resume_%' "
                . "ORDER BY meta_id DESC LIMIT 7";
        $appliers_resumes = $wpdb->get_results($query);

        $applied_date = array();
        if (isset($appliers_resumes) && count($appliers_resumes) > 0) {

            foreach ($appliers_resumes as $resumes) {

                $array_data = explode('|', $resumes->meta_value);
                $applier = $array_data[0];
                $apply_dates = get_post_meta($resumes->post_id, '_job_applied_date_' . $applier, true);
                if (!empty($applier)) {
                    $user = get_userdata($applier);
                    if ($user === false) {
                        delete_post_meta($job_id, '_job_applied_resume_' . $applier);
                    }
                }
                $applied_date[] = $apply_dates;
            }
        }
        return json_encode($applied_date);
    }

}
/* Total No of reports counter against a single Job */
if (!function_exists('nokri_count_user_reports_against_job')) {

    function nokri_count_user_reports_against_job($job_id) {

        global $wpdb;
        $total_count = ("SELECT count(meta_id) as reports_count,post_id FROM $wpdb->postmeta WHERE post_id IN ($job_id) AND (meta_key = '_sb_job_report_user')");
        $total_reports = $wpdb->get_results($total_count);

        $reports_counter = "";
        if (isset($total_reports) && $total_reports != '') {
            foreach ($total_reports as $no_of_reports) {

                $reports_counter = $no_of_reports->reports_count;
            }
        }
        return $reports_counter;
    }

}

/* Function to get applied dates statistics against all active job */
if (!function_exists('nokri_all_active_jobs_appliers_date')) {

    function nokri_all_active_jobs_appliers_date($job_id) {

        global $wpdb;
        $query = "SELECT * FROM $wpdb->postmeta WHERE post_id IN ($job_id) AND meta_key like '_job_applied_resume_%' "
                . "ORDER BY meta_id DESC LIMIT 15";
        $appliers_resumes = $wpdb->get_results($query);

        $applied_date = array();
        if (isset($appliers_resumes) && count($appliers_resumes) > 0) {

            foreach ($appliers_resumes as $resumes) {

                $array_data = explode('|', $resumes->meta_value);
                $applier = $array_data[0];
                $apply_dates = get_post_meta($resumes->post_id, '_job_applied_date_' . $applier, true);
                if (!empty($applier)) {
                    $user = get_userdata($applier);
                    if ($user === false) {
                        delete_post_meta($job_id, '_job_applied_resume_' . $applier);
                    }
                }
                $applied_date[] = $apply_dates;
            }
        }
        return json_encode($applied_date);
    }

}