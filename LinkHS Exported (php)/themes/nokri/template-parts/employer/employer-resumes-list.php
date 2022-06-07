<?php
global $nokri;
$rtl_class = '';
if (is_rtl()) {
    $rtl_class = "flip";
}
$cand_status = '';
if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
}
$user_info = wp_get_current_user();
$user_id = get_current_user_id();
/* Getting Applied Status */
$apllied_actions = nokri_canidate_apply_status();
$options = '';
foreach ($apllied_actions as $val => $key) {
    $options .= '<option value="' . esc_attr($val) . '">' . esc_html($key) . '</option>';
}
$cand_msg = esc_html__('No candidate sorted with this status', 'nokri');
//if($job_id == '')
//{
$cand_msg = esc_html__('No candidate apply yet', 'nokri');

//}

$cand_loc = isset($_GET['cand_loc']) ? $_GET['cand_loc'] : "";
$cand_name = isset($_GET['cand_name']) ? $_GET['cand_name'] : "";
$cand_gender = isset($_GET['cand_gender']) ? $_GET['cand_gender'] : "";

$cand_loc_meta = array();


if ($cand_loc != "") {
    $cand_loc_meta[] = array(
        'key' => '_cand_custom_location',
        'value' => $cand_loc,
        'compare' => 'like'
    );
}
$cand_gender_meta = array();
if ($cand_gender != "") {
    $cand_gender_meta[] = array(
        'key' => '_cand_gender',
        'value' => $cand_gender,
        'compare' => "=",
    );
}

/* Query For Getting All Resumes Against Job */
$status_wise = false;
$c_status = '';
$extra = " AND meta_key like '_job_applied_resume_%'";
if (isset($_GET['c_status'])) {

    if (isset($_GET['c_status']) && $_GET['c_status'] != "") {
        $c_status = $_GET['c_status'];
        $extra = " AND meta_key LIKE '_job_applied_status_%' AND meta_value = '$c_status'";
        $status_wise = true;
    }
}
$c_name = '';
if (isset($_POST['c_name'])) {
    if (isset($_POST['c_name']) && $_POST['c_name'] != "") {
        $c_name = $_POST['c_name'];
    }
}
$applier = array();
global $wpdb;
$query = "SELECT * FROM $wpdb->postmeta WHERE post_id = '$job_id' $extra";
$applier_resumes = $wpdb->get_results($query);
/* Check Is Resume Exist */
if (count($applier_resumes) != 0) {
    if (count($applier_resumes) > 0) {
        foreach ($applier_resumes as $resumes) {
            if ($status_wise) {
                $array_data = explode('_', $resumes->meta_key);
                $applier[] = $array_data[4];
            } else {
                $array_data = explode('|', $resumes->meta_value);
                $applier[] = $array_data[0];
            }
        }
    }
    if ($status_wise && count($applier) == 0) {
        $applier[] = '@#/!';
    }
    /* For Pagination */
    // total no of User to display
    $limit = isset($nokri['user_pagination']) ? $nokri['user_pagination'] : 5;
    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $offset = ($page * $limit) - $limit;
    $args = array(
        'search' => "*" . esc_attr($cand_name) . "*",
        'number' => $limit,
        'offset' => $offset,
        'include' => $applier,
        'order ' => 'ASC',
        'search_columns' => array('display_name',),
        'meta_query' => array(
            $cand_loc_meta,
            $cand_gender_meta,
        ),
    );
    $user_query = new WP_User_Query($args);
    $authors = $user_query->get_results();
    $pages_number = ceil($user_query->get_total() / $limit);
    $resume_table = $resume_link = '';
    if ($authors) {
        $sr_no = '1';
        foreach ($authors as $author) {
            // get all the user's id's
            $candidate_id = ($author->ID);
            $user = get_userdata($candidate_id);
            $cand_resume = get_post_meta($job_id, '_job_applied_resume_' . $candidate_id, true);
            $cand_status = get_post_meta($job_id, '_job_applied_status_' . $candidate_id, true);
            $cand_final = nokri_canidate_apply_status($cand_status);
            $cand_headline = get_user_meta($candidate_id, '_user_headline', true);
            $job_date = get_post_meta($job_id, '_job_applied_date_' . $candidate_id, true);
            $cand_cover = get_post_meta($job_id, '_job_applied_cover_' . $candidate_id, true);
            $cand_intro_vid = get_user_meta($candidate_id, '_cand_intro_vid', true);
            $cand_video_resume_switch = isset($nokri['cand_video_resume_switch']) ? $nokri['cand_video_resume_switch'] : false;
            $cand_video_resumes = get_user_meta($candidate_id, 'cand_video_resumes', true);

            if ($cand_video_resume_switch && $cand_video_resumes != "") {
                $video_url = wp_get_attachment_url($cand_video_resumes);
                $cand_intro_vid = $video_url;
            }
            $user_job_key = $candidate_id . '|' . $job_id;

            $array_data = explode('|', $cand_resume);
            $attachment_id = isset($array_data[1]) ? $array_data[1] : '';
            /* Resume status colours */
            $counter_active = '';
            if ($cand_status == '0') {
                $label_class = 'default';
                $counter_active = "counter-active";
            } elseif ($cand_status == '1') {
                $label_class = 'info';
                $counter_active = "counter-active";
            } elseif ($cand_status == '2') {
                $label_class = 'danger';
                $counter_active = "counter-active";
            } elseif ($cand_status == '3') {
                $label_class = 'primary';
                $counter_active = "counter-active";
            } elseif ($cand_status == '4') {
                $label_class = 'warning';
                $counter_active = "counter-active";
            } elseif ($cand_status == '5') {
                $label_class = 'success';
                $counter_active = "counter-active";
            }
            if (is_numeric($attachment_id)) {
                $resume_link = '<a href="' . get_permalink($attachment_id) . '?attachment_id=' . $attachment_id . '&download_file=1"">' . esc_html__('Download', 'nokri') . '</a>';
            } else {
                $resume_link = '<a href="' . get_author_posts_url($candidate_id) . '">' . esc_html__('View profile', 'nokri') . '</a>';
            }
            /* Getting Candidate Dp */
            $image_dp_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
            if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
                $image_dp_link = array($nokri['nokri_user_dp']['url']);
            }
            if (get_user_meta($candidate_id, '_cand_dp', true) != "") {
                $attach_dp_id = get_user_meta($candidate_id, '_cand_dp', true);
                $image_dp_link = wp_get_attachment_image_src($attach_dp_id, 'nokri_job_hundred');
            }
            /* If video exisst */
            $video_pop = '';
            if ($cand_intro_vid != '') {
                $video_pop = '<li class="tool-tip" title="' . esc_attr__('View Video', 'nokri') . '"><a class="bla-1" href="' . esc_html($cand_intro_vid) . '"><i class="la la-file-video-o"></i></a></li>';
                echo '<input type="hidden" id="is_intro_vid" value="1" />';
            }
            $is_active_whizchat = nokri_check_plugin_active('whizz-chat/whizz-chat.php');

            $chat_button = "";
            if ($is_active_whizchat) {

                $chat_button = '<li class="tool-tip chat_toggler" data-page_id="" data-user_id =  "' . $candidate_id . '"   title="' . esc_attr__('Chat with user', 'nokri') . '"><i class="la la-comments"></i></li>';
            }
            $zoom_button = "";
            $is_access = (isset($nokri['zoom_meeting_btn'])) ? $nokri['zoom_meeting_btn'] : false;
            if ($is_access) {
                $zoom_button = '<li class="tool-tip nokri_zoom_meeting" title="' . esc_attr__('Zoom Meeting', 'nokri') . '"   data-applierId="' . esc_attr($candidate_id) . '"data-jobid="' . esc_attr($job_id) . '"> 
            <a href="javascript:void(0)"    data-toggle="modal" data-target="#zoom_modal"><i class="fa fa-video-camera"></i></a></li>';
            }
            $resume_table .= '  <tr>
                <td>' . esc_html($sr_no) . '</td>
                 <td>
            <div class="posted-job-title-img gt">
                <a href="' . get_author_posts_url($candidate_id) . '"><img src="' . $image_dp_link[0] . '" class="img-responsive img-circle" alt="' . esc_html__('Candidate Image', 'nokri') . '"></a>
            </div> 
            <div class="posted-job-title-meta">
                <a  href="' . get_author_posts_url($candidate_id) . '" target="_blank"  class="cand-view-prof" data-cand_status="' . esc_attr($cand_status) . '"  data-cand_id = "' . esc_attr($candidate_id) . '" data-job_id = "' . esc_attr($job_id) . '">' . esc_html($author->display_name) . '</a>
                <p>' . esc_html($cand_headline) . '</p>
            </div>
            </td>
            <td><span class="label label-' . esc_attr($label_class) . '">' . esc_html($cand_final) . '</span></td>
            <td>' . esc_html(date_i18n(get_option('date_format'), strtotime($job_date))) . '</td>
            <td class="posted-job-action">
            <ul class="list-inline">
                <li class="tool-tip" title="' . esc_attr__('Take Action', 'nokri') . '"> 
                    <a href="javascript:void(0)" class="label candidate_resume_action" data-applierId="' . esc_attr($candidate_id) . '" data-jobid="' . esc_attr($job_id) . '"  data-toggle="modal" data-target="#myModal"><i class="la la-files-o"></i></a></li>
                <li class="tool-tip candidate_short_det" title="' . esc_attr__('Application Details', 'nokri') . '" data-applierId="' . esc_attr($candidate_id) . '" data-jobid="' . esc_attr($job_id) . '" data-attachid="' . esc_attr($attachment_id) . '" ><a href="" class="label" data-toggle="modal" data-target="#short-detail-modal" ><i class="la la-edit"></i></a></li>
                ' . $video_pop . '
                <li class="tool-tip del-this-resume" data-resume-id="' . esc_attr($user_job_key) . '" title="' . esc_attr__('Delete Resume', 'nokri') . '"><i class="la la la-trash"></i></li>
                ' . $chat_button . '
                ' . $zoom_button . '
            </ul></td></tr> ';
            $sr_no++;
        }
    }
    ?>
    <div class="cp-loader"></div>
    <div id="zoom_meeting_container"></div>

    <div class="dashboard-job-filters">  
        <div class="row">
            <form  method="get" id="applier_filter_form" >
                <input type="hidden" name="tab-data" value="resumes-list" />
                <input type="hidden" name="id" value="<?php echo esc_attr($job_id) ?>" />
                <input type="hidden" name="form" >
                <div class="col-md-4 col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label class=""><?php echo esc_html__('Name', 'nokri'); ?></label>
                        <input type="text" name="cand_name" class="form-control" placeholder="<?php echo esc_html__('Name', 'nokri'); ?>" value="<?php echo ''.($cand_name); ?>">
                        <a href="javascript:void(0);" class="a-btn submit_applier_form" ><i class="ti-search"></i></a>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label class=""><?php echo esc_html__('Candidate Location', 'nokri'); ?> </label>
                        <select name="cand_loc" class="select-generat form-control applier_filter_select">
                            <option value=""><?php echo esc_html__('Select Location', 'nokri'); ?></option>
                            <?php echo nokri_return_taxanomy_options('ad_location', $cand_loc, false); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label class=""><?php echo esc_html__('Gender', 'nokri'); ?></label>
                        <select  class="select-generat form-control applier_filter_select" name="cand_gender" <?php echo nokri_feilds_operat('cand_gend_setting', 'required'); ?>>
                            <option value=""><?php echo esc_html__('Select Gender', 'nokri'); ?></option>   
                            <option value="male" <?php
                            if ($cand_gender == 'male') {
                                echo "selected";
                            };
                            ?>><?php echo esc_html__('Male', 'nokri'); ?></option>
                            <option value="female" <?php
                            if ($cand_gender == 'female') {
                                echo "selected";
                            };
                            ?>><?php echo esc_html__('Female', 'nokri'); ?></option>
                            <option value="other" <?php
                            if ($cand_gender == 'other') {
                                echo "selected";
                            };
                            ?>><?php echo esc_html__('Other', 'nokri'); ?></option>
                        </select>
                    </div>
                </div>
                <?php echo nokri_form_lang_field_callback(true); ?>
            </form>
        </div>
        <table class="cand-status-filter">    
            <tr>
                <td class="<?php
                if ($c_status == '0') {
                    echo "counter-active";
                }
                ?>" ><a    href="<?php echo nokri_change_url('c_status', 0); ?>"><?php echo esc_html__('Received', 'nokri') . " ( " . show_cand_counter(0) . " )"; ?></a> </td> 
                <td  class="<?php
                if ($c_status == '1') {
                    echo "counter-active";
                }
                ?>" ><a   href="<?php echo nokri_change_url('c_status', 1) ?>"><?php echo esc_html__('Viewed', 'nokri') . " ( " . show_cand_counter(1) . " )"; ?></a> </td>            
                <td class="<?php
                if ($c_status == '3') {
                    echo "counter-active";
                }
                ?>" ><a    href="<?php echo nokri_change_url('c_status', 3); ?>"><?php echo esc_html__('Short Listed', 'nokri') . " ( " . show_cand_counter(3) . " )"; ?></a> </td> 
                <td class="<?php
                if ($c_status == '4') {
                    echo "counter-active";
                }
                ?>" ><a  href="<?php echo nokri_change_url('c_status', 4); ?>"><?php echo esc_html__('Interviewed', 'nokri') . " ( " . show_cand_counter(4) . " )"; ?> </a> </td> 
                <td class="<?php
                if ($c_status == '2') {
                    echo "counter-active";
                }
                ?>" ><a    href="<?php echo nokri_change_url('c_status', 2); ?>"><?php echo esc_html__('Rejected ', 'nokri') . " ( " . show_cand_counter(2) . " )"; ?></a> </td> 
                <td class="<?php
                if ($c_status == '5') {
                    echo "counter-active";
                }
                ?>" ><a   href="<?php echo nokri_change_url('c_status', 5); ?>"><?php echo esc_html__('Selected', 'nokri') . " ( " . show_cand_counter(5) . " )"; ?> </a> </td>          
            </tr>    
        </table> 
    </div>
    <div class="main-body">
        <div class="dashboard-job-stats">

            <span class="align-button"><h4><?php echo esc_html__('Applications on ', 'nokri') . get_the_title($job_id); ?></h4></span>
            <?php if (isset($nokri['emp_download_resumes_switch']) && $nokri['emp_download_resumes_switch']) { ?>
                <span class="align-button btn-right"> <a class="btn n-btn-custom download_admin_resumes" href="javascript:void(0)" data-job-id=<?php echo esc_attr($job_id); ?>><?php echo esc_html__('Download resumes', 'nokri'); ?> </a></span>
            <?php } ?>
            <div class="dashboard-posted-jobs">
                <div class="table-responsive">    
                    <table class="table dashboard-table table-fit">
                        <thead>
                            <tr class="posted-job-list resume-on-jobs header-title" >
                                <th> <?php echo esc_html__('Id', 'nokri') ?></th>
                                <th> <?php echo esc_html__('Candidate Name', 'nokri') ?></th>
                                <th> <?php echo esc_html__('Status', 'nokri') ?></th>
                                <th> <?php echo esc_html__('Applied on', 'nokri') ?></th>
                                <th> <?php echo esc_html__('Action', 'nokri') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo "" . ($resume_table); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination-box clearfix">
                <ul class="pagination">
                    <?php echo nokri_user_pagination($pages_number, $page); ?> 
                </ul>
            </div>
        </div>
    </div>
    <input type="hidden" id="action_job_id" value="<?php echo esc_attr($job_id); ?>" />

    <?php
} else {
    $cand_msg = esc_html__('No candidate found', 'nokri');
    ?>
    <div class="dashboard-job-filters">
        <div class="row">
            <form  method="get" id="applier_filter_form" >
                <input type="hidden" name="tab-data" value="resumes-list" />
                <input type="hidden" name="id" value="<?php echo esc_attr($job_id) ?>" />

                <input type="hidden" name="form" >
                <div class="col-md-4 col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label class=""><?php echo esc_html__('Name', 'nokri'); ?></label>
                        <input type="text" name="cand_name" class="form-control" placeholder="<?php echo esc_html__('Name', 'nokri'); ?>" value="<?php echo esc_html($cand_name); ?>">
                        <a href="javascript:void(0);" class="a-btn submit_applier_form" ><i class="ti-search"></i></a>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label class=""><?php echo esc_html__('Candidate Location', 'nokri'); ?> </label>
                        <select name="cand_loc" class="select-generat form-control applier_filter_select">
                            <option value=""><?php echo esc_html__('Select Location', 'nokri'); ?></option>
                            <?php echo nokri_return_taxanomy_options('ad_location', $cand_loc, false); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label class=""><?php echo esc_html__('Gender', 'nokri'); ?></label>
                        <select  class="select-generat form-control applier_filter_select" name="cand_gender" <?php echo nokri_feilds_operat('cand_gend_setting', 'required'); ?>>
                            <option value="male" <?php
                            if ($cand_gender == 'male') {
                                echo "selected";
                            };
                            ?>><?php echo esc_html__('Male', 'nokri'); ?></option>
                            <option value="female" <?php
                            if ($cand_gender == 'female') {
                                echo "selected";
                            };
                            ?>><?php echo esc_html__('Female', 'nokri'); ?></option>
                            <option value="other" <?php
                            if ($cand_gender == 'other') {
                                echo "selected";
                            };
                            ?>><?php echo esc_html__('Other', 'nokri'); ?></option>
                        </select>
                    </div>
                </div>
                <?php echo nokri_form_lang_field_callback(true); ?>
            </form>
        </div>

        <table class="cand-status-filter">    
            <tr>
                <td class="<?php
                if ($c_status == '0') {
                    echo "counter-active";
                }
                ?>" ><a    href="<?php echo nokri_change_url('c_status', 0); ?>"><?php echo esc_html__('Received', 'nokri') . " ( " . show_cand_counter(0) . " )"; ?></a> </td> 
                <td  class="<?php
                if ($c_status == '1') {
                    echo "counter-active";
                }
                ?>" ><a   href="<?php echo nokri_change_url('c_status', 1) ?>"><?php echo esc_html__('Viewed', 'nokri') . " ( " . show_cand_counter(1) . " )"; ?></a> </td>            
                <td class="<?php
                if ($c_status == '3') {
                    echo "counter-active";
                }
                ?>" ><a    href="<?php echo nokri_change_url('c_status', 3); ?>"><?php echo esc_html__('Short Listed', 'nokri') . " ( " . show_cand_counter(3) . " )"; ?></a> </td> 
                <td class="<?php
                if ($c_status == '4') {
                    echo "counter-active";
                }
                ?>" ><a  href="<?php echo nokri_change_url('c_status', 4); ?>"><?php echo esc_html__('Interviewed', 'nokri') . " ( " . show_cand_counter(4) . " )"; ?> </a> </td> 
                <td class="<?php
                if ($c_status == '2') {
                    echo "counter-active";
                }
                ?>" ><a    href="<?php echo nokri_change_url('c_status', 2); ?>"><?php echo esc_html__('Rejected ', 'nokri') . " ( " . show_cand_counter(2) . " )"; ?></a> </td> 
                <td class="<?php
                if ($c_status == '5') {
                    echo "counter-active";
                }
                ?>" ><a   href="<?php echo nokri_change_url('c_status', 5); ?>"><?php echo esc_html__('Selected', 'nokri') . " ( " . show_cand_counter(5) . " )"; ?> </a> </td>          
            </tr>     
        </table>
    </div>
    <div class="main-body">
        <div class="dashboard-posted-jobs">
            <div class="notification-box">
                <div class="notification-box-icon"><span class="ti-info-alt"></span></div>
                <h4><?php echo esc_html($cand_msg); ?></h4>
            </div>
        </div>
    </div>
<?php } ?>
<?php

function nokri_change_url($key, $value) {

    $dashboard_id = '';
    if ((isset($nokri['sb_dashboard_page'])) && $nokri['sb_dashboard_page'] != '') {
        $dashboard_id = ($nokri['sb_dashboard_page']);
    }
    $job_id = '';
    if (isset($_GET['id'])) {
        $job_id = $_GET['id'];
    }

    $myurl = get_the_permalink($dashboard_id);
    $final_url = esc_url(nokri_set_url_params_multi($myurl, 'tab-data', 'resumes-list', 'id', $job_id, $key, $value));

    return $final_url;
}

function show_cand_counter($status_id) {

    global $wpdb;
    $job_id = '';
    if (isset($_GET['id'])) {
        $job_id = $_GET['id'];
    }
    $extra = " AND meta_key LIKE '_job_applied_status_%' AND meta_value = '$status_id'";
    $query = "SELECT * FROM $wpdb->postmeta WHERE post_id = '$job_id' $extra";
    $applier_resumes = $wpdb->get_results($query);

    /* Check Is Resume Exist */
    $applier = array();
    if (count($applier_resumes) != 0) {
        if (count($applier_resumes) > 0) {
            foreach ($applier_resumes as $resumes) {
                $array_data = explode('_', $resumes->meta_key);
                $users_existence = get_userdata($array_data[4]);
                if ($users_existence) {
                    $applier[] = $array_data[4];
                }
            }
        }
    }
    return count($applier);
}
