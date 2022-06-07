<?php
/* Template Name: Page Employer */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#page-search
 *
 * @package nokri
 */
$current_user_id = get_current_user_id();
get_header();
global $nokri;
$title = '';
if (isset($_GET['emp_title']) && $_GET['emp_title'] != "") {
    $title = $_GET['emp_title'];
}
$cands_qry = array(
    'key' => '_sb_reg_type',
    'value' => '1',
    'compare' => '='
);

$order = 'DESC';
$orderby = 'meta_value';
if (isset($_GET['order']) && $_GET['order'] == 'name') {
    $orderby = 'display_name';
    $order = 'ASC';
} elseif (isset($_GET['order']) && $_GET['order'] == 'date') {
    $orderby = 'registered';
    $order = 'DESC';
}
$location_qry = '';
if (isset($_GET['job-location']) && $_GET['job-location'] != "") {
    $location_qry = array(
        'key' => '_emp_custom_location',
        'value' => $_GET['job-location'],
        'compare' => 'like'
    );
}
$skills_qry = '';
if (isset($_GET['emp_skills']) && $_GET['emp_skills'] != "") {
    $skills_qry = array(
        'key' => '_emp_skills',
        'value' => $_GET['emp_skills'],
        'compare' => 'like'
    );
}
// total no of User to display
$limit = isset($nokri['user_pagination']) ? $nokri['user_pagination'] : 10;
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$offset = ($page * $limit) - $limit;
// Query args
$args = array(
    'search' => "*" . esc_attr($title) . "*",
    'order' => $order,
    'orderby' => array(
        $orderby,
        'registered',
    ),
    'number' => $limit,
    'offset' => $offset,
    'role__in' => array('editor', 'administrator', 'subscriber'),
    'meta_query' => array(array(
            'relation' => 'OR',
            array(
                'key' => '_emp_feature_profile',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key' => '_emp_feature_profile',
                'compare' => 'EXISTS'
            ),
        ),
        array(
            'key' => '_sb_is_member',
            'compare' => 'NOT EXISTS'
        ),
        $cands_qry,
        $location_qry,
        $skills_qry)
);
// Create the WP_User_Query object
$wp_user_query = new WP_User_Query($args);
// Get the results
$users = $wp_user_query->get_results();
$total_users = $wp_user_query->get_total();
$pages_number = ceil($total_users / $limit);

if ($total_users > 0) {
    $users_found = esc_html__("Employer found", 'nokri') . " " . '(' . $total_users . ')';
} else {
    $users_found = esc_html__("No Employer found", 'nokri');
}
/* search section bg */
$list_bg_url = '';
if (isset($nokri['candidate_list_bg_img'])) {
    $list_bg_url = nokri_getBGStyle('candidate_list_bg_img');
}

$emp_layout = ( isset($nokri['emp_listing_style']) && $nokri['emp_listing_style'] != "" ) ? $nokri['emp_listing_style'] : "1";
?>
<section class="n-search-page n-user-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <aside class="new-sidebar">
                            <div class="heading">
                                <h4> <?php echo esc_html__("Search Filters", "nokri"); ?></h4>
                                <a href="<?php echo get_the_permalink(); ?>"><?php echo esc_html__("Clear All", "nokri"); ?></a>                  
                                <a role="button" class="" data-toggle="collapse" href="#accordion" aria-expanded="true" id="panel_acordian"></a>                           
                            </div> 
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php echo get_sidebar('employers'); ?>
                            </div>
                        </aside>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="n-search-main">
                            <div class="n-bread-crumb">
                                <ol class="breadcrumb">
                                    <li> <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html__("Home", 'nokri'); ?></a></li>
                                    <li class="active"><a href="javascript:void(0);" class="active"><?php echo esc_html__("Employer Search", 'nokri'); ?></a></li>
                                </ol>
                            </div>
                            <div class="heading-area">
                                <div class="row">
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <h4><?php echo esc_html($users_found); ?></h4>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <form method="GET" id="candiate_order">
                                            <select class="js-example-basic-single form-control candidates_orders" data-allow-clear="true" data-placeholder="<?php echo esc_html__("Select option", 'nokri'); ?>" style="width: 100%" name="order">
                                                <option value="0"><?php echo esc_html__("Select order", 'nokri'); ?></option>
                                                <option value="name" <?php if (isset($_GET['order']) && $_GET['order'] == 'name') echo "selected=selected"; ?>><?php echo esc_html__("Alphabatically", 'nokri'); ?></option>
                                                <option value="date" <?php if (isset($_GET['order']) && $_GET['order'] == 'date') echo "selected=selected"; ?>><?php echo esc_html__("New registered", 'nokri'); ?></option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="n-search-listing n-featured-jobs">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
                                    <div class="row">
                                        <div class="n-company-grids mansi">
                                            <?php
                                            /* Query User results */
                                            if (!empty($users)) {
                                                // Loop through results
                                                foreach ($users as $user) {
                                                    $user_id = $user->ID;
                                                    $user_name = nokri_employe_return_dotted_name($user->display_name);
                                                    //$user_name = $user->display_name;
                                                    /* Profile Pic  */
                                                    $image_dp_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                                                    if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
                                                        $image_dp_link = array($nokri['nokri_user_dp']['url']);
                                                    }
                                                    if (get_user_meta($user_id, '_sb_user_pic', true) != '') {
                                                        $attach_dp_id = get_user_meta($user_id, '_sb_user_pic', true);
                                                        $image_dp_link = wp_get_attachment_image_src($attach_dp_id, '');
                                                    }
                                                    if (empty($image_dp_link[0])) {
                                                        $image_dp_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                                                    }
                                                    $user_post_count = count_user_posts($user_id, 'job_post');
                                                    $user_post_count_html = '<span class="job-openings">' . $user_post_count . " " . esc_html__('Openings', 'nokri') . '</span>';
                                                    $emp_address = get_user_meta($user_id, '_emp_map_location', true);
                                                    /* Social links */
                                                    $fb_link = $twitter_link = $google_link = $linkedin_link = '';
                                                    $emp_fb = get_user_meta($user_id, '_emp_fb', true);
                                                    $emp_twitter = get_user_meta($user_id, '_emp_twitter', true);
                                                    $emp_google = get_user_meta($user_id, '_emp_google', true);
                                                    $emp_linkedin = get_user_meta($user_id, '_emp_linked', true);
                                                    if ($emp_fb) {
                                                        $fb_link = '<li><a href="' . esc_url($emp_fb) . '"><img src="' . get_template_directory_uri() . '/images/icons/006-facebook.png" alt="' . esc_attr__('icon', 'nokri') . '"></a></li>';
                                                    }
                                                    if ($emp_twitter) {
                                                        $twitter_link = '<li><a href="' . esc_url($emp_twitter) . '"><img src="' . get_template_directory_uri() . '/images/icons/004-twitter.png" alt="' . esc_attr__('icon', 'nokri') . '"></a></li>';
                                                    }
                                                    if ($emp_google) {
                                                        $google_link = '<li><a href="' . esc_url($emp_google) . '"><img src="' . get_template_directory_uri() . '/images/icons/003-google-plus.png" alt="' . esc_attr__('icon', 'nokri') . '"></a></li>';
                                                    }
                                                    if ($emp_linkedin) {
                                                        $linkedin_link = '<li><a href="' . esc_url($emp_linkedin) . '"><img src="' . get_template_directory_uri() . '/images/icons/005-linkedin.png" alt="' . esc_attr__('icon', 'nokri') . '"></a></li>';
                                                    }
                                                    /* Social links */
                                                    $adress_html = '';
                                                    if ($emp_address) {
                                                        $adress_html = '<p class="location"><i class="la la-map-marker"></i>' . " " . $emp_address . '</p>';
                                                    }
                                                    $social_icons = '';
                                                    if ($emp_fb || $emp_twitter || $emp_google || $emp_linkedin) {
                                                        $social_icons = '<div class="n-company-bottom"><ul class="social-links list-inline">' . "" . $fb_link . $twitter_link . $google_link . $linkedin_link . '</ul></div>';
                                                    }
                                                    /* follow company */
                                                    $follow_btn = '';
                                                    $follow_switch = isset($nokri['emp_det_follow_btn']) ? $nokri['emp_det_follow_btn'] : false;
                                                    if (get_user_meta($current_user_id, '_sb_reg_type', true) == 0 && $follow_switch) {
                                                        $comp_follow = get_user_meta($current_user_id, '_cand_follow_company_' . $user_id, true);
                                                        if ($comp_follow) {
                                                            $follow_btn = '<a   class="btn n-btn-rounded">' . esc_html__('Followed', 'nokri') . '</a>';
                                                        } else {
                                                            $follow_btn = '<a  data-value="' . esc_attr($user_id) . '"  class="btn n-btn-rounded follow_company"><i class="fa fa-send-o"></i>' . " " . esc_html__('Follow', 'nokri') . '</a>';
                                                        }
                                                    }
                                                    $company_tot_jobs = ( count_user_posts($user_id, 'job_post') );
                                                    $open_positions_txt = esc_html__('Open postion', 'nokri');
                                                    $postion_html = '';
                                                    if ($company_tot_jobs < 1) {
                                                        $postion_html = '<span>' . esc_html__('No open postion', 'nokri') . '</span>';
                                                    }
                                                    if ($company_tot_jobs > 1) {
                                                        $open_positions_txt = esc_html__('Open postions', 'nokri');
                                                    }
                                                    if ($company_tot_jobs) {
                                                        $postion_html = '<span>' . $company_tot_jobs . " " . $open_positions_txt . '</span>';
                                                    }
                                                    $intro_html = '';
                                                    $emp_intro = get_user_meta($user_id, '_emp_intro', true);
                                                    if ($emp_intro) {
                                                        $intro_html = '<p>' . wp_trim_words($emp_intro, 20, '…') . '</p>';
                                                    }

                                                    $featured_date = get_user_meta($user_id, '_emp_feature_profile', true);
                                                    $is_featured = false;
                                                    $today = date("Y-m-d");
                                                    $expiry_date_string = strtotime($featured_date);
                                                    $today_string = strtotime($today);
                                                    if ($today_string > $expiry_date_string) {
                                                        delete_user_meta($user_id, '_emp_feature_profile');
                                                        delete_user_meta($user_id, '_is_emp_featured');
                                                    } else {
                                                        $is_featured = true;
                                                    }
                                                    $featured = "";
                                                    if (isset($is_featured) && $is_featured) {
                                                        $featured = '<div class="features-star"><i class="fa fa-star"></i></div>';
                                                    };

                                                    $rtl_class = $bg_url = '';
                                                    $cover_pic = get_user_meta($user_id, '_sb_user_cover', true);

                                                    if ($cover_pic != "") {
                                                        $bg_url = wp_get_attachment_url($cover_pic);
                                                    } else {
                                                        $bg_url = get_template_directory_uri() . '/images/777.png';
                                                    }
                                                    $follow_btn_emp = '';
                                                    $follow_switch_emp = isset($nokri['emp_det_follow_btn']) ? $nokri['emp_det_follow_btn'] : false;
                                                    if (get_user_meta($current_user_id, '_sb_reg_type', true) == 0 && $follow_switch_emp) {
                                                        $comp_follow_emp = get_user_meta($current_user_id, '_cand_follow_company_' . $user_id, true);
                                                        if ($comp_follow_emp) {
                                                            $follow_btn_emp = '<div class="n-grid-icons"><a  data-value="' . esc_attr($user_id) . '"><i class="fa fa-heart"></i></a></div>';
                                                        } else {
                                                            $follow_btn_emp = '<div class="n-grid-icons"><a  data-value="' . esc_attr($user_id) . '"  class="follow_company"><i class="fa fa-heart-o"></i></a></div>';
                                                        }
                                                    }
                                                    $social_icons1 = '';
                                                    if ($emp_fb || $emp_twitter || $emp_google || $emp_linkedin) {
                                                        $social_icons1 = '<span class="icons-click"><i class="fa fa-share-alt"><div class="n-grid-icon-list0"><ul>' . "" . $fb_link . $twitter_link . $google_link . $linkedin_link . '</ul></div></i></span>';
                                                    } else {
                                                        $social_icons1 = '';
                                                    }
                                                    if ($emp_layout == 1) {
                                                        ?>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="n-company-grid-single">
                                                                <?php echo ''.$featured; ?>
                                                                <div class="n-company-grid-img">
                                                                    <div class="n-company-logo">
                                                                        <a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>"> <img src="<?php echo esc_url($image_dp_link[0]); ?>" class="img-responsive" alt="<?php echo esc_attr__('image', 'nokri'); ?>"></a>
                                                                    </div>
                                                                    <div class="n-company-title">
                                                                        <h3><a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>"><?php echo esc_html($user_name); ?></a></h3>
                                                                        <?php echo "" . ($adress_html); ?>
                                                                    </div>
                                                                    <div class="n-company-follow">
                                                                        <?php echo "" . ($follow_btn); ?>
                                                                    </div>
                                                                </div>
                                                                <?php echo "" . ($social_icons); ?>
                                                            </div>
                                                        </div>
                                                    <?php } if ($emp_layout == 2) { ?>
                                                        <div class="col-lg-6 col-xl-12 col-sm-6 col-md-4">
                                                            <div class="n-grid-box">
                                                                <div class="n-grid-img">
                                                                    <?php echo ''.$featured; ?>
                                                                    <div class="n-grid-overlay">
                                                                        <img src="<?php echo esc_url($bg_url); ?>" alt="" class="img-responsive">
                                                                    </div>
                                                                    <?php echo "" . ($follow_btn_emp); ?>
                                                                    <div class="n-grid-style-background">
                                                                        <a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>"> <img src="<?php echo esc_url($image_dp_link[0]); ?>" class="img-responsive" alt="<?php echo esc_attr__('image', 'nokri'); ?>"></a>
                                                                    </div>
                                                                </div>
                                                                <div class="n-grid-details">
                                                                    <a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>"><h3><?php echo esc_html($user_name); ?></h3></a>                                                                  
                                                                    <?php echo "" . ($social_icons1); ?>
                                                                    <?php echo "" . ($adress_html); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <?php echo nokri_user_pagination($pages_number, $page); ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
get_footer();