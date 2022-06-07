<?php
global $nokri;
$rtl_class = (is_rtl()) ? "flip" : "";
/* Background image */
if (isset($nokri['section_bg_img'])) {
    $bg_url = nokri_getBGStyle('section_bg_img');
} else {
    $bgImageURL = get_template_directory_uri() . '/images/footer.png';
    $bg_url = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $bgImageURL . ')  no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: center center; background-attachment:scroll;"' : "";
}
$current_id = get_current_user_id();
/* Getting Either Emp Or Cand */
if (get_user_meta($current_id, '_sb_reg_type', true) == '1') {
    $dp_key = '_sb_user_pic';
} else {
    $dp_key = '_cand_dp';
}
/* Search Page */
$search_page_layout = ( isset($nokri['search_page_layout']) && $nokri['search_page_layout'] != "" ) ? $nokri['search_page_layout'] : "";
/* Getting Candidate Dp */
if (get_user_meta($current_id, $dp_key, true) != "") {
    $attach_dp_id = get_user_meta($current_id, $dp_key, true);
    $image_dp_link = wp_get_attachment_image_src($attach_dp_id, 'nokri_job_hundred');
} else {
    $image_dp_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
}
/* Header Logo */
$headerlogo = '';
$logo = get_template_directory_uri() . '/images/logo.png';
if (isset($nokri['header_logo']['url']) && $nokri['header_logo']['url'] != "") {
    $logo = ( $nokri['header_logo']['url'] );
}
/* Dashboard Page */
$dashboard_id = ( isset($nokri['sb_dashboard_page']) && $nokri['sb_dashboard_page'] != "" ) ? $nokri['sb_dashboard_page'] : "";
/* Post Job Page */
$page_id = ( isset($nokri['sb_post_ad_page']) && $nokri['sb_post_ad_page'] != "" ) ? $nokri['sb_post_ad_page'] : "";
/* All Job Page */
$page_id = ( isset($nokri['sb_all_job_page']) && $nokri['sb_all_job_page'] != "" ) ? $nokri['sb_all_job_page'] : "";
/* Button text Option */
$btn_text = '';
$btn_text_def = esc_html__("Job Post", "nokri");
if ((isset($nokri['nav_bar_post_btn'])) && $nokri['nav_bar_post_btn'] != '') {
    $btn_text = ($nokri['nav_bar_post_btn']);
    $btn_text_def = ($nokri['nav_bar_post_btn']);
}
/* Button Icon Option */
$btn_icon = '';
if ((isset($nokri['nav_bar_post_btn_icon'])) && $nokri['nav_bar_post_btn_icon'] != '') {
    $btn_icon = ($nokri['nav_bar_post_btn_icon']);
}
/* Button link */
$job_post = '';
if ((isset($nokri['nav_bar_post_btn_link'])) && $nokri['nav_bar_post_btn_link'] != '') {
    $job_post = ($nokri['nav_bar_post_btn_link']);
}
/* Candidate Button text Option */
$cand_btn_text = '';
if ((isset($nokri['cand_nav_bar_post_btn'])) && $nokri['cand_nav_bar_post_btn'] != '') {
    $cand_btn_text = ($nokri['cand_nav_bar_post_btn']);
}
/* Candidate Button Icon Option */
$cand_btn_icon = '';
if ((isset($nokri['cand_nav_bar_post_btn_icon'])) && $nokri['cand_nav_bar_post_btn_icon'] != '') {
    $cand_btn_icon = ($nokri['cand_nav_bar_post_btn_icon']);
}
/* Candidate Button link */
$cand_job_post = '';
if ((isset($nokri['cand_nav_bar_post_btn_link'])) && $nokri['cand_nav_bar_post_btn_link'] != '') {
    $cand_job_post = ($nokri['cand_nav_bar_post_btn_link']);
}
/* Job Button Check */
$job_button = $job_link = '';
if (get_user_meta($current_id, '_sb_reg_type', true) == '1') {
    $job_button = esc_html($btn_text);
    $job_link = ($job_post);
    $bnt_class = esc_attr($btn_icon);
} else {
    $job_button = esc_html($cand_btn_text);
    $job_link = $cand_job_post;
    $bnt_class = esc_attr($cand_btn_icon);
}
$is_map = false;
if (wp_basename(get_page_template()) == 'page-search.php' && $search_page_layout == '3') {
    $is_map = true;
}
/* Dashboard class check */
if (wp_basename(get_page_template()) == 'page-dashboard.php' || $is_map) {
    $dashboard_class = 'n-admin-header';
    $dashboard_fluid = '-fluid';
    $is_dashboard_page = true;
} else {
    $dashboard_class = 'fa-change-black n-header-trabsparent';
    $dashboard_fluid = '';
    $is_dashboard_page = false;
}
/* page check for nav bg */
$page_check = nokri_is_page_check();
if (is_search()) {
    $page_check = false;
}

if (isset($_GET['s'])) {
    $page_check = false;
}

if (is_404()) {
    $page_check = true;
}
if (is_author()) {
    $page_check = true;
}
if (is_singular('job_post') && isset($nokri['job_post_style']) && $nokri['job_post_style'] == '2') {
    $page_check = true;
}

if (is_singular('job_post') && isset($nokri['job_post_style']) && $nokri['job_post_style'] == '1') {
    $page_check = false;
}

if (isset($_GET['s'])) {
    $page_check = false;
}
if (wp_basename(get_page_template()) == 'page-job-post.php') {
    $page_check = true;
}

$bread_class = 'as-breadcrumb';

if (wp_basename(get_page_template()) == 'page-home.php' || $page_check) {
    $bread_class = '';
}
/* Signin  Page */
$signin = ( isset($nokri['sb_sign_in_page']) && $nokri['sb_sign_in_page'] != "" ) ? $nokri['sb_sign_in_page'] : "";
/* Signup  Page */
$signup = ( isset($nokri['sb_sign_up_page']) && $nokri['sb_sign_up_page'] != "" ) ? $nokri['sb_sign_up_page'] : "";
/* Dashboard logo  */
if (basename(get_page_template()) == 'page-dashboard.php') {
    $headerlogo = '';
    $logo = get_template_directory_uri() . '/images/logo-dash.png';
    if (isset($nokri['dashborad_header_logo']['url']) && $nokri['dashborad_header_logo']['url'] != "") {
        $logo = ( $nokri['dashborad_header_logo']['url'] );
    }
}
/* With out login button settings */
$wo_txt = isset($nokri['wo_log_btn_txt']) ? $nokri['wo_log_btn_txt'] : '';
$wo_link = isset($nokri['wo_log_btn_link']) ? $nokri['wo_log_btn_link'] : '';
$wo_icon = isset($nokri['wo_log_btn_icon']) ? $nokri['wo_log_btn_icon'] : '';
/* Full width menu settings */
$full_width = '';
$is_full_width = isset($nokri['menu_full_width']) ? $nokri['menu_full_width'] : false;
if ($is_full_width == true && $dashboard_fluid != '') {
    $full_width = '<div class="container' . esc_attr($dashboard_fluid) . '">';
} else if ($is_full_width == false && $dashboard_fluid = '') {
    $full_width = '<div class="container-fluid' . esc_attr($dashboard_fluid) . '">';
} else if ($is_full_width == true) {
    $full_width = '<div class="container-fluid">';
} else {
    $full_width = '<div class="container">';
}
?>
<div class="transparent-header-1">
    <nav id="menu-1" class="mega-menu <?php echo esc_attr($dashboard_class) . " " . $bread_class; ?>" <?php
    if (wp_basename(get_page_template()) != 'page-home.php' && $page_check == false) {
        echo str_replace('\\', "", $bg_url);
    }
    ?>>
        <section class="menu-list-items ">
            <?php echo nokri_returnEcho($full_width); ?>
            <ul class="menu-logo">
                <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php echo '<img  src="' . esc_url($logo) . '" class="img-responsive" alt="' . esc_attr__("logo", "nokri") . '" >'; ?></a></li>
            </ul>
            <ul class="menu-button">
                <?php
                /* User Icon And Button */
                if ((isset($nokri['user_bar_switch'])) && $nokri['user_bar_switch'] == '1') {
                    if (is_user_logged_in()) {
                        ?>
                        <li class="profile-pic dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo esc_url($image_dp_link[0]); ?>" alt="<?php echo esc_attr__("image", "nokri") ?>" class="img-circle" width="36"><span class="hidden-xs hidden-sm"></span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo get_the_permalink($dashboard_id); ?>"><i class="fa fa-user"></i><?php echo esc_html__('Dashboard', 'nokri'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo wp_logout_url(home_url()); ?>"><i class="fa fa-power-off"></i><?php echo esc_html__('Logout', 'nokri'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <?php
                        $usercheck = get_user_meta($current_id, '_sb_reg_type', true);
                        $memberData = get_user_meta($current_id, '_sb_is_member', true);
                        $Permissions = get_user_meta($current_id, 'member_permissions', true);
                        $userPermiss = isset($Permissions['ad_post']) && $Permissions['ad_post'] != '';
                        if ($current_id == $usercheck) {
                            echo '<li><a href="' . get_the_permalink($job_link) . '"class="btn n-btn-flat"><i class="' . esc_attr($bnt_class) . '"></i>' . esc_html($job_button) . '</a></li>';
                        } else if ($memberData != '' && $userPermiss != '') {
                            echo '<li><a href="' . get_the_permalink($job_link) . '"class="btn n-btn-flat"><i class="' . esc_attr($bnt_class) . '"></i>' . esc_html($job_button) . '</a></li>';
                        } else if ($memberData != '' && $userPermiss == '') {
                            
                        } else {
                            echo '<li><a href="' . get_the_permalink($job_link) . '"class="btn n-btn-flat"><i class="' . esc_attr($bnt_class) . '"></i>' . esc_html($job_button) . '</a></li>';
                        }
                    } else {
                        ?>
                        <li>
                            <a href="<?php echo get_the_permalink($signin); ?>" class="n-login-header"><i class="fa fa-sign-in"></i><?php echo esc_html__('Login', 'nokri'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo get_the_permalink($signup); ?>" class="n-login-header"><i class="fa fa-user-plus"></i><?php echo esc_html__('Register', 'nokri'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo get_the_permalink($wo_link); ?>" class="btn n-btn-flat"><i class="<?php echo esc_attr($wo_icon); ?>"></i><?php echo esc_html($wo_txt); ?></a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
            <ul class="menu-links <?php echo esc_attr($rtl_class); ?>">
                <?php echo nokri_themeMenu('main-nav'); ?>
            </ul>
            </div>
        </section>
    </nav> 
</div>
<?php
if (wp_basename(get_page_template()) == 'page-dashboard.php' || $is_map) {
    echo '</div>';
}
?>     
<div class="clearfix"></div>
<input type="hidden" id="is_dashboard_page" value="<?php echo esc_attr($is_dashboard_page); ?> ">