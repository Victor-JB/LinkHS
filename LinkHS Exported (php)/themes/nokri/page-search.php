<?php
get_header();
/* Template Name: Page Search */
global $nokri;
/* Getting Title From Query String */
$title = '';
if (isset($_GET['job-title']) && $_GET['job-title'] != "") {
    $title = $_GET['job-title'];
}
/* RTL check */
$rtl_class = '';
if (is_rtl()) {
    $rtl_class = "flip";
}
/* search section bg */
$search_bg_url = '';
if (isset($nokri['search_bg_img'])) {
    $search_bg_url = nokri_getBGStyle('search_bg_img');
}

/* Getting All Taxonomy From Query String */
$taxonomies = array('job_type', 'ad_title', 'cat_id', 'job_category', 'job_tags', 'job_qualifications', 'job_level', 'job_salary', 'job_currency', 'job_skills', 'job_experience', 'job_currency', 'job_shift', 'job_class', 'job-location', 'ad_location',);
foreach ($taxonomies as $tax) {
    $$tax = '';
    if (isset($_GET[$tax]) && $_GET[$tax] != "") {
        $$tax = array(
            array('taxonomy' => $tax, 'field' => 'term_id', 'terms' => $_GET[$tax]),);
    }
}
$category = '';
if (isset($_GET['cat-id']) && $_GET['cat-id'] != "") {
    $category = array(
        array(
            'taxonomy' => 'job_category',
            'field' => 'term_id',
            'terms' => $_GET['cat-id'],
        ),
    );
}
$location = '';
if (isset($_GET['job-location']) && $_GET['job-location'] != "") {
    $location = array(
        array(
            'taxonomy' => 'ad_location',
            'field' => 'term_id',
            'terms' => $_GET['job-location'],
        ),
    );
}

$location_keyword = '';
if (isset($_GET['loc_keyword']) && $_GET['loc_keyword'] != "") {
    $location_keyword = array(
        array(
            'taxonomy' => 'ad_location',
            'field' => 'name',
            'terms' => $_GET['loc_keyword'],
            'operator' => 'LIKE'
        ),
    );
}

/* Custom feilds search satrts */
$custom_search = array();
if (isset($_GET['custom'])) {
    foreach ($_GET['custom'] as $key => $val) {

        $val = stripslashes_deep($val);
        $metaKey = '_nokri_tpl_field_' . $key;
        $custom_search[] = array(
            'key' => $metaKey,
            'value' => $val,
            'compare' => 'LIKE',
        );
    }
}
/* Custom feilds search ends */

/* Radius search starts */
$lat_lng_meta_query = array();
if (isset($_GET['radius_lat']) && isset($_GET['radius_long'])) {
    $latitude = $_GET['radius_lat'];
    $longitude = $_GET['radius_long'];
}
if (!empty($latitude) && !empty($longitude)) {
    $distance = '30';
    if (!empty($_GET['distance']) && !empty($_GET['distance'])) {
        $distance = $_GET['distance'];
    }
    $data_array = array("latitude" => $latitude, "longitude" => $longitude, "distance" => $distance);
    $type_lat = "'DECIMAL'";
    $type_lon = "'DECIMAL'";
    $lats_longs = nokri_radius_search_theme($data_array, false);

    if (!empty($lats_longs) && count((array) $lats_longs) > 0) {
        if ($latitude > 0) {
            $lat_lng_meta_query[] = array(
                'key' => '_job_lat',
                'value' => array($lats_longs['lat']['min'], $lats_longs['lat']['max']),
                'compare' => 'BETWEEN',
            );
        } else {
            $lat_lng_meta_query[] = array(
                'key' => '_job_lat',
                'value' => array($lats_longs['lat']['max'], $lats_longs['lat']['min']),
                'compare' => 'BETWEEN',
            );
        }
        if ($longitude > 0) {
            $lat_lng_meta_query[] = array(
                'key' => '_job_long',
                'value' => array($lats_longs['long']['min'], $lats_longs['long']['max']),
                'compare' => 'BETWEEN',
            );
        } else {
            $lat_lng_meta_query[] = array(
                'key' => '_job_long',
                'value' => array($lats_longs['long']['max'], $lats_longs['long']['min']),
                'compare' => 'BETWEEN',
            );
        }
    }
}
/* Radius search ends */

/* Passing Query String Results To Arguments */
$order = 'DESC';
if (isset($_GET['order_job'])) {
    if (isset($_GET['order_job']) && $_GET['order_job'] != "") {
        $order = $_GET['order_job'];
    }
}
$featur_excluded = '';

if (isset($nokri['premium_jobs_class_switch']) && $nokri['premium_jobs_class_switch']) {
    if (isset($nokri['premium_jobs_class']) && $nokri['premium_jobs_class'] != '') {

        $featur_excluded = array(
            'taxonomy' => 'job_class',
            'field' => 'term_id',
            'terms' => $nokri['premium_jobs_class'],
            'operator' => 'NOT IN',
        );
    }
}
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} else if (get_query_var('page')) {
    /* This will occur if on front page. */
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
/* Checking If Location tax Is empty */
if ($location == '') {
    if (isset($_GET['ad_location']) && $_GET['ad_location'] != "") {
        $location = array(
            array(
                'taxonomy' => 'ad_location',
                'field' => 'term_id',
                'terms' => $_GET['ad_location'],
            ),
        );
    }
}
$args = array(
    'tax_query' => array($category, $job_salary, $title, $job_type, $job_category, $job_tags, $job_qualifications, $job_level, $job_skills, $job_experience, $job_currency, $job_shift, $job_class, $location, $location_keyword, $featur_excluded),
    'posts_per_page' => get_option('posts_per_page'),
    's' => $title,
    'post_type' => 'job_post',
    'post_status' => 'publish',
    'order' => $order,
    'orderby' => 'date',
    'paged' => $paged,
    'meta_query' => array(
        array(
            'key' => '_job_status',
            'value' => 'active',
            'compare' => '=',
        ),
        $custom_search,
        $lat_lng_meta_query,
    ),
);
$args = nokri_wpml_show_all_posts_callback($args);
$results = new WP_Query($args);

if ($results->found_posts > 0) {
    $message = __('Available Jobs', 'nokri');
} else {
    $message = __('No Jobs Matched', 'nokri');
}
$side_bar_emp_title = ( isset($nokri['multi_company_select_title']) && $nokri['multi_company_select_title'] != "" ) ? '<div class="widget-heading"><span class="title">' . $nokri['multi_company_select_title'] . '</span></div>' : "";
/* Premium Jobs Top Query */
$premium_jobs_class_num = ( isset($nokri['premium_jobs_class_number']) && $nokri['premium_jobs_class_number'] != "" ) ? $nokri['premium_jobs_class_number'] : "";
$args_premium = array();
if (isset($nokri['premium_jobs_class']) && $nokri['premium_jobs_class'] != '') {
    $job_classes = '';
    $job_classes = array(
        array(
            'taxonomy' => 'job_class',
            'field' => 'term_id',
            'terms' => $nokri['premium_jobs_class'],
            'operator' => 'IN',
        ),
    );
    $args_premium = array(
        'tax_query' => array($job_classes, $category, $location),
        's' => $title,
        'posts_per_page' => $premium_jobs_class_num,
        'post_type' => 'job_post',
        'post_status' => 'publish',
        'orderby' => 'rand',
        'order' => $order,
        'orderby' => 'date',
        'meta_query' => array(
            array(
                'key' => '_job_status',
                'value' => 'active',
                'compare' => '=',
            ),
        ),
    );
}
/* Advertisement Module */
$advert_up = $advert_down = '';
if (isset($nokri['search_job_advert_switch']) && $nokri['search_job_advert_switch'] == "1") {
    /* Above joba */
    if (isset($nokri['search_job_advert_up']) && $nokri['search_job_advert_up'] != "") {
        $advert_up = $nokri['search_job_advert_up'];
    }
    /* Below jobs */
    if (isset($nokri['search_job_advert_down']) && $nokri['search_job_advert_down'] != "") {
        $advert_down = $nokri['search_job_advert_down'];
    }
}
/* Search page lay out */
$search_page_layout = ( isset($nokri['search_page_layout']) && $nokri['search_page_layout'] != "" ) ? $nokri['search_page_layout'] : "";
/* Is job alerts */
$job_alerts = ( isset($nokri['job_alerts_switch']) && $nokri['job_alerts_switch'] != "" ) ? $nokri['job_alerts_switch'] : false;
/* Job alert title */
$job_alerts_title = ( isset($nokri['job_alerts_title']) && $nokri['job_alerts_title'] != "" ) ? $nokri['job_alerts_title'] : '';
/* Job alert tagline */
$job_alerts_tagline = ( isset($nokri['job_alerts_tagline']) && $nokri['job_alerts_tagline'] != "" ) ? $nokri['job_alerts_tagline'] : '';
/* Job alert btn */
$job_alerts_btn = ( isset($nokri['job_alerts_btn']) && $nokri['job_alerts_btn'] != "" ) ? $nokri['job_alerts_btn'] : '';
$multi_searach = ( isset($nokri['multi_job_search_form']) && $nokri['multi_job_search_form'] != "" ) ? $nokri['multi_job_search_form'] : false;
$loader_image = get_template_directory_uri() . '/images/loader-img.png';
$current_layout = $nokri['search_layout'];
$pull_class = "";
$push_class = "";
$horizontal_class = "";
$horizontal_searh = ( isset($nokri['search_page_widget_style']) && $nokri['search_page_widget_style'] != "" ) ? $nokri['search_page_widget_style'] : 2;
$show_mob_filter = isset($nokri['search_mobile_filter']) ? $nokri['search_mobile_filter'] : false;
$is_mobile = wp_is_mobile() && !$show_mob_filter ? "collapse" : "collapse in";
$jooble_position = isset($nokri['jooble_job_position']) ? $nokri['jooble_job_position'] : '1';
$full_width = '';
if ($horizontal_searh == "1" && $search_page_layout != "3") {
    $horizontal_class = "horizontal";
    /* Full width menu settings */
    $full_width = '';
    $is_full_width = isset($nokri['page_full_width']) ? $nokri['page_full_width'] : false;
    if ($is_full_width) {
        $full_width = '-fluid';
    }
    ?>
    <section class="padding horizontal_search <?php echo esc_attr($show_mob_filter) ? 'mobile-filters' : ''; ?>">
        <a class="btn n-btn-flat filter-close-btn" href="javascript:void(0);"><i class="fa fa-close"></i></a>
        <div class="container<?php echo esc_attr($full_width); ?>">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div class="jobs-form">
                        <form method="get" action = "<?php echo get_the_permalink($nokri['sb_search_page']); ?>" id="jobs_searh_form">
                            <ul>
                                <?php nokri_return_horizontal_search_bar(); ?>

                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if ($show_mob_filter) { ?>
        <div class="mobile-filters-btn">
            <a class="btn n-btn-flat" href="javascript:void(0);"><?php esc_html_e("Filters", "nokri"); ?><i class="fa fa-filter"></i></a>
        </div>
    <?php } ?>
    <?php
}
if ($search_page_layout == 1) {
    ?>
    <div class="cp-loader"></div>
    <section class="n-search-page" >
        <div class="container<?php echo esc_attr($full_width); ?>">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">                      
                            <aside class="new-sidebar <?php echo esc_attr($show_mob_filter && $horizontal_searh == "2") ? 'mobile-filters' : ''; ?>">
                                <div class="heading">
                                    <h4> <?php echo esc_html__("Search Filters", "nokri"); ?></h4>
                                    <a href="<?php echo get_the_permalink($nokri['sb_search_page']); ?>"><?php echo esc_html__("Clear All", "nokri"); ?></a>                  
                                    <a role="button" class="" data-toggle="" href="#accordion" aria-expanded="true" id="panel_acordian"></a>                           
                                </div>  
                                <a class="btn filter-close-btn" href="javascript:void(0);"><i class="fa fa-close" aria-hidden="true"></i></a>
                                <?php if ($multi_searach && $horizontal_searh != "1") { ?>
                                    <form method="get" id="all_search_form">
                                        <div class = "panel-group" id = "accordion" role = "tablist" aria-multiselectable = "true">
                                            <button type = "submit" class = "submit-all-form btn n-btn-flat btn-block" ><?php echo esc_html__('Search', 'nokri')
                                    ?></button>    
                                            <?php get_sidebar('widget'); ?>
                                            <button type = "submit" class = "submit-all-form btn n-btn-flat btn-block" ><?php echo esc_html__('Search', 'nokri')
                                            ?></button>    
                                        </div>
                                    </form>
                                <?php } elseif ($multi_searach && $horizontal_searh != "2") { ?>
                                    <form method="get" id="all_search_form">
                                        <div class = "panel-group" id = "accordion" role = "tablist" aria-multiselectable = "true">
                                            <button type = "submit" class = "submit-all-form btn n-btn-flat btn-block" ><?php echo esc_html__('Search', 'nokri')
                                    ?></button>    
                                            <?php get_sidebar('widget'); ?>
                                            <button type = "submit" class = "submit-all-form btn n-btn-flat btn-block" ><?php echo esc_html__('Search', 'nokri')
                                            ?></button>    
                                        </div>
                                    </form><?php } else {
                                            ?>
                                    <div class = "panel-group  <?php echo esc_attr($is_mobile) ?>" id = "accordion" role = "tablist" aria-multiselectable = "true">                                                                  
                                        <?php get_sidebar('widget'); ?>                                 
                                    </div>
                                <?php } ?>
                            </aside>
                        </div>
                        <?php if ($show_mob_filter && $horizontal_searh != "1") { ?>
                            <div class="mobile-filters-btn">
                                <a class="btn n-btn-flat" href="javascript:void(0);"><?php esc_html_e("Filters", "nokri"); ?><i class="fa fa-filter"></i></a>
                            </div>
                        <?php } ?>
                        <?php
                        /* Premium Job Top Query */
                        if (isset($nokri['premium_jobs_class_switch']) && $nokri['premium_jobs_class_switch'] == '1') {
                            $results_premium = new WP_Query($args_premium);
                            if ($results_premium->have_posts()) {
                                $pull_class = "col-lg-pull-3";
                                $push_class = "col-lg-push-6";
                                /* Section Title */
                                $section_title = (isset($nokri['premium_jobs_class_title']) && $nokri['premium_jobs_class_title'] != "") ? '<div class="heading"><h4>' . $nokri['premium_jobs_class_title'] . '</h4></div>' : "";
                                ?>
                                <div class="col-lg-3 col-md-8 col-sm-12 col-xs-12 <?php echo esc_attr($push_class) ?> ">
                                    <aside class="new-sidebar">
                                        <?php echo '' . $section_title; ?>
                                        <div class="vertical-job-slider verticalCarousel">
                                            <ul class="slider-1">
                                                <?php
                                                $layouts = array('list_1', 'list_2', 'list_3');
                                                if (in_array($current_layout, $layouts)) {
                                                    require trailingslashit(get_template_directory()) . "template-parts/layouts/job-style/search-layout-premium-list.php";
                                                    echo '' . $out;
                                                } else {
                                                    require trailingslashit(get_template_directory()) . "template-parts/layouts/job-style/search-layout-premium-grid.php";
                                                    echo '' . $out;
                                                }
                                                wp_reset_postdata();
                                                ?>
                                            </ul>
                                        </div>
                                    </aside>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12 <?php echo '' . $pull_class ?>">
                            <div class="n-search-main">
                                <div class="n-bread-crumb">
                                    <ol class="breadcrumb">
                                        <li> <a href=""><?php echo esc_html__("Home", "nokri"); ?></a></li>
                                        <li class="active"><a href="javascript:void(0);" class="active"><?php echo esc_html__("Search Page", "nokri"); ?></a></li>
                                    </ol>
                                </div>
                                <div class="heading-area" <?php echo '' . ($search_bg_url); ?>>
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <h4><?php echo esc_html($message) . " " . '(' . esc_html($results->found_posts) . ')'; ?></h4>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <form method="GET" id="emp_active_job">
                                                <select class="js-example-basic-single form-control  emp_active_job" data-allow-clear="true" data-placeholder="<?php echo esc_html__("Select Option", "nokri"); ?>" style="width: 100%" name="order_job" id="order_job">
                                                    <option value="" ><?php echo esc_html__("Select Option", "nokri"); ?></option>
                                                    <option value="ASC" <?php
                                                    if ($order == 'ASC') {
                                                        echo "selected";
                                                    };
                                                    ?>><?php echo esc_html__("Ascending", "nokri"); ?></option>
                                                    <option value="DESC" <?php
                                                    if ($order == 'DESC') {
                                                        echo "selected";
                                                    };
                                                    ?>><?php echo esc_html__("Descending ", "nokri"); ?></option>
                                                </select>
                                                <?php
                                                if (!$multi_searach) {
                                                    echo nokri_search_params('order_job');
                                                }
                                                ?>
                                                <?php echo nokri_form_lang_field_callback(true); ?> 
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($job_alerts) { ?>
                                    <div class="jobs-alert-box">
                                        <div class="row">
                                            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                                <span><?php echo esc_html($job_alerts_title); ?></span>
                                                <p><?php echo esc_html($job_alerts_tagline); ?></p>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                <a href="javascript:void(0)" class="btn n-btn-flat job_alert"><?php echo esc_html($job_alerts_btn); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="n-search-listing n-featured-jobs-two">
                                    <div class="row">
                                        <div class="n-advert-display-grid"> 
                                            <?php echo '' . $advert_up; ?>
                                        </div>
                                        <div class="n-features-job-two-box" id="">
                                            <?php
                                            if ($jooble_position == 1) {
                                                $jooble_html = "";
                                                $is_access = (isset($nokri['jooble_api_btn']) ? $nokri['jooble_api_btn'] : false);
                                                $jobs_counter = (isset($nokri['nokri_jooble_import_jobs']) ? $nokri['nokri_jooble_import_jobs'] : 5);
                                                if ($is_access) {
                                                    ?>
                                                    <div class="n-featured-job-boxes jooble-jobs-area" >
                                                        <?php
                                                        $all_jooble_jobs = nokri_get_jooble_jobs();
                                                        $counter = 0;
                                                        if (is_array($all_jooble_jobs) && !empty($all_jooble_jobs)) {
                                                            foreach ($all_jooble_jobs['jobs'] as $jooble_jobs) {
                                                                if ($counter >= $jobs_counter) {
                                                                    break;
                                                                }
                                                                $jooble_job_id = isset($jooble_jobs['id']) ? $jooble_jobs['id'] : '';
                                                                $jooble_title = isset($jooble_jobs['title']) ? $jooble_jobs['title'] : '';
                                                                $jooble_link = isset($jooble_jobs['link']) ? $jooble_jobs['link'] : '';
                                                                $jooble_source = isset($jooble_jobs['source']) ? $jooble_jobs['source'] : '';
                                                                $jooble_company = isset($jooble_jobs['company']) ? $jooble_jobs['company'] : '';
                                                                $jooble_location = isset($jooble_jobs['location']) ? $jooble_jobs['location'] : '';
                                                                $jooble_updated = isset($jooble_jobs['updated']) ? $jooble_jobs['updated'] : '';
                                                                $jooble_type = isset($jooble_jobs['type']) ? $jooble_jobs['type'] : '';
                                                                $jooble_updated = human_time_diff(strtotime($jooble_updated), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                                $jooble_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                    <div class="n-featured-single">
                                                                                       <div class="n-featured-single-top">
                                                                                          <div class="n-featured-singel-meta">
                                                                                             <h4><a href="' . esc_url($jooble_link) . '">' . esc_html($jooble_title) . '</a></h4>                                                                                            
                                                                                             <p><i class="fa fa-user"></i><a href="' . esc_url($jooble_link) . '" class="">' . esc_html($jooble_company) . ' </a><i class="fa fa-map-marker"></i><a href="' . esc_url($jooble_link) . '">' . esc_url($jooble_location) . '</a></p>
                                                                                          </div>
                                                                                       </div>
                                                                                       <div class="n-featured-single-bottom">
                                                                                          <ul class="">
                                                                                             <li> <i class="fa fa-clock-o"></i>' . esc_html($jooble_updated) . '</li>

                                                                                             <li> <i class="fa fa-hand-o-right"></i>' . esc_html($jooble_type) . '</li>
                                                                                          </ul>  
                                                                                       </div>
                                                                                       <p class ="n-jooble-bottom">' . esc_html__('powered by Jooble', 'nokri') . '</p>
                                                                                    </div>
                                                                                 </div>';
                                                                $counter++;
                                                            }
                                                        }
                                                        ?> 
                                                        <?php echo '' . $jooble_html; ?>
                                                    </div> 
                                                    <div class="clear-both"></div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            /* Regular Search Query */
                                            if ($results->have_posts()) {

                                                $layouts = array('list_1', 'list_2', 'list_3');
                                                if (in_array($current_layout, $layouts)) {
                                                    require trailingslashit(get_template_directory()) . "template-parts/layouts/job-style/search-layout-list.php";
                                                    echo '' . ($out);
                                                } else {
                                                    require trailingslashit(get_template_directory()) . "template-parts/layouts/job-style/search-layout-grid.php";
                                                    echo '' . ($out);
                                                }
                                                /* Restore original Post Data */
                                                wp_reset_postdata();
                                            }
                                            ?>
                                            <?php
                                            if ($jooble_position == 2) {
                                                $jooble_html = "";
                                                $is_access = (isset($nokri['jooble_api_btn']) ? $nokri['jooble_api_btn'] : false);
                                                $jobs_counter = (isset($nokri['nokri_jooble_import_jobs']) ? $nokri['nokri_jooble_import_jobs'] : 5);
                                                if ($is_access) {
                                                    ?>
                                                    <div class="n-featured-job-boxes jooble-jobs-area" >
                                                        <?php
                                                        $counter = 0;
                                                        $all_jooble_jobs = nokri_get_jooble_jobs();
                                                        if (is_array($all_jooble_jobs) && !empty($all_jooble_jobs)) {
                                                            foreach ($all_jooble_jobs['jobs'] as $jooble_jobs) {
                                                                if ($counter >= $jobs_counter) {
                                                                    break;
                                                                }
                                                                $jooble_job_id = isset($jooble_jobs['id']) ? $jooble_jobs['id'] : '';
                                                                $jooble_title = isset($jooble_jobs['title']) ? $jooble_jobs['title'] : '';
                                                                $jooble_link = isset($jooble_jobs['link']) ? $jooble_jobs['link'] : '';
                                                                $jooble_source = isset($jooble_jobs['source']) ? $jooble_jobs['source'] : '';
                                                                $jooble_company = isset($jooble_jobs['company']) ? $jooble_jobs['company'] : '';
                                                                $jooble_location = isset($jooble_jobs['location']) ? $jooble_jobs['location'] : '';
                                                                $jooble_updated = isset($jooble_jobs['updated']) ? $jooble_jobs['updated'] : '';
                                                                $jooble_type = isset($jooble_jobs['type']) ? $jooble_jobs['type'] : '';
                                                                $jooble_updated = human_time_diff(strtotime($jooble_updated), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                                $jooble_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                    <div class="n-featured-single">
                                                                                       <div class="n-featured-single-top">
                                                                                          <div class="n-featured-singel-meta">
                                                                                             <h4><a href="' . esc_url($jooble_link) . '">' . esc_html($jooble_title) . '</a></h4>
                                                                                             
                                                                                             <p><i class="fa fa-user"></i><a href="' . esc_url($jooble_link) . '" class="">' . esc_html($jooble_company) . ' </a><i class="fa fa-map-marker"></i><a href="' . esc_url($jooble_link) . '">' . esc_url($jooble_location) . '</a></p> 

                                                                                          </div>

                                                                                       </div>
                                                                                       <div class="n-featured-single-bottom">
                                                                                          <ul class="">
                                                                                             <li> <i class="fa fa-clock-o"></i>' . esc_html($jooble_updated) . '</li>

                                                                                             <li> <i class="fa fa-hand-o-right"></i>' . esc_html($jooble_type) . '</li>
                                                                                          </ul>  
                                                                                       </div>
                                                                                       <p class ="n-jooble-bottom">' . esc_html__('powered by Jooble', 'nokri') . '</p>
                                                                                    </div>
                                                                                 </div>';
                                                                $counter++;
                                                            }
                                                        }
                                                        ?> 
                                                        <?php echo '' . $jooble_html; ?>
                                                    </div> 
                                                    <div class="clear-both"></div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <div class="clearfix"></div>
                                            <?php
                                            $counter = 0;
                                            $is_allow = (isset($nokri['careerjet_api_btn']) ? $nokri['careerjet_api_btn'] : false);
                                            if ($is_allow) {
                                                $jobs_counter = (isset($nokri['nokri_careerjet_import_jobs']) ? $nokri['nokri_careerjet_import_jobs'] : 5);
                                                $careerJetJobs = nokri_get_careerjet_jobs();
                                                if (is_array($careerJetJobs) && !empty($careerJetJobs)) {
                                                    foreach ($careerJetJobs as $get_jet_jobs) {
                                                        if (is_array($get_jet_jobs) && !empty($get_jet_jobs)) {

                                                            if ($counter >= $jobs_counter) {
                                                                break;
                                                            }
                                                            $job_url = isset($get_jet_jobs['url']) ? $get_jet_jobs['url'] : '';
                                                            $job_date = isset($get_jet_jobs['date']) ? $get_jet_jobs['date'] : '';
                                                            $job_title = isset($get_jet_jobs['title']) ? $get_jet_jobs['title'] : '';
                                                            $job_salary = isset($get_jet_jobs['salary']) ? $get_jet_jobs['salary'] : '';
                                                            $job_company = isset($get_jet_jobs['company']) ? $get_jet_jobs['company'] : '';
                                                            $job_locations = isset($get_jet_jobs['locations']) ? $get_jet_jobs['locations'] : '';
                                                            $job_salary_max = isset($get_jet_jobs['salary_max']) ? $get_jet_jobs['salary_max'] : '';
                                                            $job_description = isset($get_jet_jobs['description']) ? $get_jet_jobs['description'] : '';
                                                            $job_date = human_time_diff(strtotime($job_date), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                            $careerJet_html = "";
                                                            $careerJet_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                                                                                    <div class="n-featured-single">
                                                                                       <div class="n-featured-single-top">
                                                                                          <div class="n-featured-singel-meta">
                                                                                             <h4><a href="' . esc_url($job_url) . '">' . esc_html($job_title) . '</a></h4>
                                                                                             
                                                                                             <p><i class="fa fa-user"></i><a href="' . esc_url($job_url) . '" class="">' . esc_html($job_company) . ' </a><i class="fa fa-map-marker"></i><a href="' . esc_url($job_url) . '">' . esc_url($job_locations) . '</a></p> 
                                                                                                 <p><i class="fa fa-money"></i>' . esc_html__('Salary', 'nokri') . '-' . esc_html($job_salary) . '</p>
                                                                                          </div>

                                                                                       </div>
                                                                                       <div class="n-featured-single-bottom">
                                                                                          <ul class="">
                                                                                             <li> <i class="fa fa-clock-o"></i>' . esc_html($job_date) . '</li>
                                                                                             
                                                                                          </ul>  
                                                                                       </div>
                                                                                       <p class ="n-jooble-bottom">' . esc_html__('found on careerjet', 'nokri') . '</p>
                                                                                    </div>
                                                                                 </div>';
                                                            $counter++;
                                                            echo nokri_returnEcho($careerJet_html);
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <!--GitHub Jobs Integration-->
                                            <?php
                                            $github_html = "";
                                            $is_accessed = (isset($nokri['gitjob_btn']) ? $nokri['gitjob_btn'] : false);
                                            $jobs_limt = (isset($nokri['nokri_git_jobs_limit']) ? $nokri['nokri_git_jobs_limit'] : 5);
                                            if ($is_accessed) {
                                                $counter = 0;
                                                $git_jobs_data = nokri_get_github_jobs();
                                                $all_git_jobs = json_decode(json_encode($git_jobs_data), TRUE);
                                                $git_jobs = $data_array = array();
                                                if (is_array($all_git_jobs) && !empty($all_git_jobs)) {
                                                    foreach ($all_git_jobs as $key => $github_jobs) {
                                                        if ($counter >= $jobs_limt) {
                                                            break;
                                                        }
                                                        $git_jobs_id = isset($github_jobs['id']) ? $github_jobs['id'] : '';
                                                        $git_jobs_url = isset($github_jobs['url']) ? $github_jobs['url'] : '';
                                                        $git_jobs_type = isset($github_jobs['type']) ? $github_jobs['type'] : '';
                                                        $git_jobs_title = isset($github_jobs['title']) ? $github_jobs['title'] : '';
                                                        $git_jobs_company = isset($github_jobs['company']) ? $github_jobs['company'] : '';
                                                        $git_jobs_location = isset($github_jobs['location']) ? $github_jobs['location'] : '';
                                                        $git_jobs_created_at = isset($github_jobs['created_at']) ? $github_jobs['created_at'] : '';
                                                        $git_jobs_description = isset($github_jobs['description']) ? $github_jobs['description'] : '';
                                                        $git_jobs_company_url = isset($github_jobs['company_url']) ? $github_jobs['company_url'] : '';
                                                        $git_jobs_created_at = human_time_diff(strtotime($git_jobs_created_at), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                        $github_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                                                                                    <div class="n-featured-single">
                                                                                       <div class="n-featured-single-top">
                                                                                          <div class="n-featured-singel-meta">
                                                                                             <h4><a href="' . esc_url($git_jobs_url) . '">' . esc_html($git_jobs_title) . '</a></h4>
                                                                                             
                                                                                             <p><i class="fa fa-user"></i><a href="' . esc_url($git_jobs_url) . '" class="">' . esc_html($git_jobs_company) . ' </a><i class="fa fa-map-marker"></i><a href="' . esc_url($git_jobs_url) . '">' . esc_url($git_jobs_location) . '</a></p> 
                                                                                                 
                                                                                          </div>

                                                                                       </div>
                                                                                       <div class="n-featured-single-bottom">
                                                                                          <ul class="">
                                                                                             <li> <i class="fa fa-clock-o"></i>' . esc_html($git_jobs_created_at) . '</li>
                                                                                             <li> <i class="fa fa-hand-o-right"></i>' . esc_html($git_jobs_type) . '</li>
                                                                                          </ul>  
                                                                                       </div>
                                                                                       <p class ="n-jooble-bottom">' . esc_html__('found on GitHub', 'nokri') . '</p>
                                                                                    </div>
                                                                                 </div>';
                                                        $counter++;
                                                    }
                                                }
                                                echo nokri_returnEcho($github_html);
                                            }
                                            ?>
                                            <!--Getting All ReedCo Jobs-->
                                            <?php
                                            $reedco_html = "";
                                            $jobs_counter = (isset($nokri['nokri_reedco_import_jobs']) ? $nokri['nokri_reedco_import_jobs'] : 5);
                                            $is_allowed = (isset($nokri['reedco_jobs_api_btn']) ? $nokri['reedco_jobs_api_btn'] : false);
                                            if ($is_allowed) {
                                                ?>
                                                <div class="n-featured-job-boxes" >
                                                    <?php
                                                    $counter = 0;
                                                    /* Getting All ReedCo Jobs Function */
                                                    $all_reedco_jobs = nokri_get_reedco_jobs();
                                                    if (is_array($all_reedco_jobs) && !empty($all_reedco_jobs)) {
                                                        foreach ($all_reedco_jobs as $reedco_jobs) {
                                                            if (is_array($reedco_jobs) && !empty($reedco_jobs)) {
                                                                foreach ($reedco_jobs as $reedco_job) {
                                                                    if ($counter >= $jobs_counter) {
                                                                        break;
                                                                    }
                                                                    $jobId = isset($reedco_job['jobId']) ? $reedco_job['jobId'] : '';
                                                                    $postDate = isset($reedco_job['date']) ? $reedco_job['date'] : '';
                                                                    $jobUrl = isset($reedco_job['jobUrl']) ? $reedco_job['jobUrl'] : '';
                                                                    $jobTitle = isset($reedco_job['jobTitle']) ? $reedco_job['jobTitle'] : '';
                                                                    $currency = isset($reedco_job['currency']) ? $reedco_job['currency'] : '';
                                                                    $locationName = isset($reedco_job['locationName']) ? $reedco_job['locationName'] : '';
                                                                    $employerName = isset($reedco_job['employerName']) ? $reedco_job['employerName'] : '';
                                                                    $minimumSalary = isset($reedco_job['minimumSalary']) ? $reedco_job['minimumSalary'] : '';
                                                                    $maximumSalary = isset($reedco_job['maximumSalary']) ? $reedco_job['maximumSalary'] : '';
                                                                    $expirationDate = isset($reedco_job['expirationDate']) ? $reedco_job['expirationDate'] : '';
                                                                    $jobDescription = isset($reedco_job['jobDescription']) ? $reedco_job['jobDescription'] : '';
                                                                    $date = str_replace('/', '-', $postDate);
                                                                    $postDate = human_time_diff(strtotime($date), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                                    $reedco_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                    <div class="n-featured-single">
                                                                                       <div class="n-featured-single-top">
                                                                                          <div class="n-featured-singel-meta">
                                                                                             <h4><a href="' . esc_url($jobUrl) . '">' . esc_html($jobTitle) . '</a></h4>
                                                                                             
                                                                                             <p><i class="fa fa-user"></i><a href="' . esc_url($jobUrl) . '" class="">' . esc_html($employerName) . ' </a><i class="fa fa-map-marker"></i><a href="' . esc_url($jobUrl) . '">' . esc_url($locationName) . '</a></p> 
                                                                                                 <p><i class="fa fa-money"></i>' . esc_html__('Min Salary', 'nokri') . ' ' . esc_html($minimumSalary) . ' ' . '<i class="fa fa-dollar"></i>' . esc_html__('Currency', 'nokri') . ' ' . esc_html($currency) . '</p>                                                                                                
                                                                                          </div>
                                                                                       </div>
                                                                                       <div class="n-featured-single-bottom">
                                                                                          <ul class="">
                                                                                             <li> <i class="fa fa-clock-o"></i>' . esc_html__('Post Date', 'nokri') . ' ' . esc_html($postDate) . '</li>
                                                                                                 <li> <i class="fa fa-clock-o"></i>' . esc_html__('Exp Date', 'nokri') . ' ' . esc_html($expirationDate) . '</li>
                                                                                          </ul>  
                                                                                       </div>
                                                                                       <p class ="n-jooble-bottom">' . esc_html__('get By ReedCo', 'nokri') . '</p>
                                                                                    </div>
                                                                                 </div>';
                                                                    $counter++;
                                                                    echo nokri_returnEcho($reedco_html);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>
                                                <!--Getting All Adzuna TotalJobs-->
                                                <?php
                                                $adzuna_html = "";
                                                $is_accessedd = (isset($nokri['adzunajobs_btn']) ? $nokri['adzunajobs_btn'] : false);
                                                $jobs_limts = (isset($nokri['nokri_adzuna_jobs_limit']) ? $nokri['nokri_adzuna_jobs_limit'] : 5);
                                                if ($is_accessedd) {
                                                    ?>
                                                    <div class="n-featured-job-boxes" >
                                                        <?php
                                                        $counter = 0;
                                                        $adzuJobs = nokri_import_adzuna_jobs();
                                                        $all_adzuna_jobs = json_decode(json_encode($adzuJobs), TRUE);
                                                        if (is_array($all_adzuna_jobs) || is_object($all_adzuna_jobs) && !empty($all_adzuna_jobs)) {
                                                            foreach ($all_adzuna_jobs['results'] as $adzunaJobs) {

                                                                if ($counter >= $jobs_limts) {
                                                                    break;
                                                                }
                                                                //Removed <strong>, </strong> from title with string replace.
                                                                $adzujobs_title_str = isset($adzunaJobs['title']) ? $adzunaJobs['title'] : '';
                                                                $adzujobs_title_str1 = str_replace("<strong>", "", $adzujobs_title_str);
                                                                $adzujobs_title = str_replace("</strong>", "", $adzujobs_title_str1);
                                                                $adzujobs_id = isset($adzunaJobs['id']) ? $adzunaJobs['id'] : '';
                                                                $adzujobs_created = isset($adzunaJobs['created']) ? $adzunaJobs['created'] : '';
                                                                $adzujobs_city = isset($adzunaJobs['location']['area'][1]) ? $adzunaJobs['location']['area'][1] : '';
                                                                $adzujobs_country = isset($adzunaJobs['location']['area'][0]) ? $adzunaJobs['location']['area'][0] : '';
                                                                $adzujobs_url = isset($adzunaJobs['redirect_url']) ? $adzunaJobs['redirect_url'] : '';
                                                                $adzujobs_salary_max = isset($adzunaJobs['salary_max']) ? $adzunaJobs['salary_max'] : '';
                                                                $adzujobs_salary_min = isset($adzunaJobs['salary_min']) ? $adzunaJobs['salary_min'] : '';
                                                                $adzujobs_company_url = isset($adzunaJobs['company_url']) ? $adzunaJobs['company_url'] : '';
                                                                $adzujobs_description = isset($adzunaJobs['description']) ? $adzunaJobs['description'] : '';
                                                                $adzujobs_company = isset($adzunaJobs['company']['display_name']) ? $adzunaJobs['company']['display_name'] : '';
                                                                $adzujobs_created = human_time_diff(strtotime($adzujobs_created), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                                $adzuna_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                                                                                    <div class="n-featured-single">
                                                                                       <div class="n-featured-single-top">
                                                                                          <div class="n-featured-singel-meta">
                                                                                             <h4><a href="' . esc_url($adzujobs_url) . '">' . esc_html($adzujobs_title) . '</a></h4>
                                                                                             
                                                                                             <p><i class="fa fa-user"></i><a href="' . esc_url($adzujobs_url) . '" class="">' . esc_html($adzujobs_company) . ' </a><i class="fa fa-map-marker"></i><a href="' . esc_url($adzujobs_url) . '">' . esc_url($adzujobs_city) . '</a></p> 
                                                                                                 <p><i class="fa fa-money"></i>' . esc_html__('Min Salary', 'nokri') . ' ' . esc_html($adzujobs_salary_min) . '</p>
                                                                                                 
                                                                                          </div>

                                                                                       </div>
                                                                                       <div class="n-featured-single-bottom">
                                                                                          <ul class="">
                                                                                             <li> <i class="fa fa-clock-o"></i>' . esc_html__('Post Date', 'nokri') . ' ' . esc_html($adzujobs_created) . '</li>
                                                                                                 
                                                                                          </ul>  
                                                                                       </div>
                                                                                       <p class ="n-jooble-bottom">' . esc_html__('by Adzuna Totaljobs', 'nokri') . '</p>
                                                                                    </div>
                                                                                 </div>';
                                                                $counter++;
                                                                echo nokri_returnEcho($adzuna_html);
                                                            }
                                                        }
                                                    }
                                                    $remotive_html = "";
                                                    $remotive_api_btn = isset($nokri['remotive_api_btn']) ? $nokri['remotive_api_btn'] : false;
                                                    if ($remotive_api_btn) {
                                                        ?>
                                                        <div class="n-featured-job-boxes" >
                                                            <?php
                                                            $all_remotive_jobs = nokri_get_remotive_jobs();
                                                            if (is_array($all_remotive_jobs) && !empty($all_remotive_jobs)) {
                                                                foreach ($all_remotive_jobs['jobs'] as $remotive_jobs) {

                                                                    $remotive_job_id = isset($remotive_jobs['id']) ? $remotive_jobs['id'] : '';
                                                                    $remotive_title = isset($remotive_jobs['title']) ? $remotive_jobs['title'] : '';
                                                                    $company_description = isset($remotive_jobs['description']) ? $remotive_jobs['description'] : '';
                                                                    $remotive_link = isset($remotive_jobs['url']) ? $remotive_jobs['url'] : '';
                                                                    $remotive_category = isset($remotive_jobs['category']) ? $remotive_jobs['category'] : '';
                                                                    $remotive_company_name = isset($remotive_jobs['company_name']) ? $remotive_jobs['company_name'] : '';
                                                                    $remotive_publication_date = isset($remotive_jobs['publication_date']) ? $remotive_jobs['publication_date'] : '';
                                                                    $remotive_job_type = isset($remotive_jobs['job_type']) ? $remotive_jobs['job_type'] : '';
                                                                    $remotive_publication_date = human_time_diff(strtotime($remotive_publication_date), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                                    $remotive_salary = isset($remotive_jobs['salary']) ? $remotive_jobs['salary'] : '';
                                                                    $company_logo_url = isset($remotive_jobs['company_logo_url']) ? $remotive_jobs['company_logo_url'] : '';
                                                                    $candidate_required_location = isset($remotive_jobs['candidate_required_location']) ? $remotive_jobs['candidate_required_location'] : '';

                                                                    $remotive_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                                                                                    <div class="n-featured-single">
                                                                                       <div class="n-featured-single-top">
                                                                                          <div class="n-featured-singel-meta">
                                                                                             <h4><a href="' . esc_url($remotive_link) . '">' . esc_html($remotive_title) . '</a></h4>
                                                                                             <p><i class="fa fa-user"></i><a href="' . esc_url($remotive_link) . '" class="">' . esc_html($remotive_company_name) . ' </a><i class="fa fa-map-marker"></i><a href="' . esc_url($remotive_link) . '">' . esc_html($candidate_required_location) . '</a></p>
                                                                                                 <p><i class="fa fa-money"></i>' . esc_html__('Salary', 'nokri') . ' ' . esc_html($remotive_salary) . '</p>                                                                                                
                                                                                          </div>
                                                                                       </div>
                                                                                       <div class="n-featured-single-bottom">
                                                                                          <ul class="">
                                                                                             <li> <i class="fa fa-clock-o"></i>' . esc_html__('Post Date', 'nokri') . ' ' . esc_html($remotive_publication_date) . '</li>    
                                                                                          </ul>  
                                                                                       </div>
                                                                                       <p class ="n-jooble-bottom">' . esc_html__('by Remotive Jobs', 'nokri') . '</p>
                                                                                    </div>
                                                                                 </div>';
                                                                }
                                                            }
                                                        }
                                                        echo '' . ($remotive_html);
                                                        ?>
                                                        <div class="n-features-job-two-box" id="jobs_container"></div>
                                                        <div class="n-advert-display-grid">
                                                            <?php echo '' . ($advert_down); ?></div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                                            <?php if (isset($nokri['job_search_loader']) && $nokri['job_search_loader'] && $results->have_posts()) { ?>
                                                                <div  class = "loader_container" style="display: none"> 
                                                                    <img class="loader_img" src="<?php echo esc_url($loader_image) ?>" >
                                                                    <img class="loader_img" src="<?php echo esc_url($loader_image) ?>">
                                                                    <img class="loader_img" src="<?php echo esc_url($loader_image) ?>" >
                                                                </div>
                                                                <center>
                                                                    <button class="btn n-btn-flat" id="more_jobs"><?php echo esc_html__('More Jobs', 'nokri') ?><span class="fa fa-spinner"></span></button>
                                                                </center>
                                                                <input type="hidden" id="page_number" value="1" />
                                                                <input type="hidden" id="more_loading" value="1" />
                                                                <input type="hidden" id="page_url" value ="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" />
                                                            <?php } else { ?>
                                                                <nav aria-label="Page navigation">
                                                                    <?php echo nokri_job_pagination($results); ?>
                                                                </nav>                                         
                                                            <?php } ?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </section>
                <?php
            } else if ($search_page_layout == 2) {
                $full_width = '';
                $is_full_width = isset($nokri['page_full_width']) ? $nokri['page_full_width'] : false;
                if ($is_full_width) {
                    $full_width = '-fluid';
                }
                ?>
                <section class="n-search-page<?php echo esc_html($horizontal_class) ?>" >
                    <div class="container<?php echo esc_attr($full_width); ?>">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row">                      
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">                                            
                                        <aside class="new-sidebar  <?php echo nokri_returnEcho($show_mob_filter && $horizontal_searh == "2") ? 'mobile-filters' : ''; ?>">                       
                                            <div class="heading">
                                                <h4> <?php echo esc_html__("Search Filters", "nokri"); ?></h4>
                                                <a href="<?php echo get_the_permalink($nokri['sb_search_page']); ?>"><?php echo esc_html__("Clear All", "nokri"); ?></a>
                                                <a role="button" class="" data-toggle="collapse" href="#accordion" aria-expanded="true" id="panel_acordian"></a>                                 
                                            </div>
                                            <a class="btn filter-close-btn" href="javascript:void(0);"><i class="fa fa-close" aria-hidden="true"></i></a>
                                            <?php if ($multi_searach && $horizontal_searh == "1") { ?>
                                                <form method="get" id="all_search_form">
                                                    <div class = "panel-group" id = "accordion" role = "tablist" aria-multiselectable = "true">
                                                        <button type = "submit" class = "submit-all-form btn n-btn-flat btn-block" ><?php echo esc_html__('Search', 'nokri')
                                                ?></button>
                                                        <?php get_sidebar('widget'); ?>
                                                        <button type = "submit" class = "submit-all-form btn n-btn-flat btn-block" ><?php echo esc_html__('Search', 'nokri')
                                                        ?></button>    
                                                    </div>
                                                </form>
                                            <?php } elseif ($multi_searach && $horizontal_searh == "2") { ?>
                                                <form method="get" id="all_search_form">
                                                    <div class = "panel-group" id = "accordion" role = "tablist" aria-multiselectable = "true">
                                                        <button type = "submit" class = "submit-all-form btn n-btn-flat btn-block" ><?php echo esc_html__('Search', 'nokri')
                                                ?></button>
                                                        <?php get_sidebar('widget'); ?>
                                                        <button type = "submit" class = "submit-all-form btn n-btn-flat btn-block" ><?php echo esc_html__('Search', 'nokri')
                                                        ?></button>    
                                                    </div>
                                                </form>
                                            <?php } else { ?>
                                                <div class = "panel-group  <?php echo esc_attr($is_mobile) ?>" id = "accordion" role = "tablist" aria-multiselectable = "true">                                                                  
                                                    <?php get_sidebar('widget'); ?>                                 
                                                </div>
                                            <?php } ?>
                                        </aside>
                                    </div>
                                    <?php if ($show_mob_filter && $horizontal_searh != "1") { ?>
                                        <div class="mobile-filters-btn">
                                            <a class="btn n-btn-flat" href="javascript:void(0);"><?php esc_html_e("Filters", "nokri"); ?><i class="fa fa-filter"></i></a>
                                        </div>
                                    <?php } ?>
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <div class="n-search-main">
                                            <div class="n-bread-crumb">
                                                <ol class="breadcrumb">
                                                    <li> <a href="javascript:void(0)"><?php echo esc_html__("Home", "nokri"); ?></a></li>
                                                    <li class="active"><a href="javascript:void(0);" class="active"><?php echo esc_html__("Search Page", "nokri"); ?></a></li>
                                                </ol>
                                            </div>
                                            <div class="heading-area">
                                                <div class="row">
                                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                                        <h4><?php echo esc_html($message) . " " . '(' . esc_html($results->found_posts) . ')'; ?></h4>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                        <form method="GET" id="emp_active_job">
                                                            <select class="js-example-basic-single form-control emp_active_job" data-allow-clear="true" data-placeholder="<?php echo esc_html__("Select Option", "nokri"); ?>" style="width: 100%" name="order_job" id="order_job">
                                                                <option value="" ><?php echo esc_html__("Select Option", "nokri"); ?></option>
                                                                <option value="ASC" <?php
                                                                if ($order == 'ASC') {
                                                                    echo "selected";
                                                                };
                                                                ?>><?php echo esc_html__("Ascending", "nokri"); ?></option>
                                                                <option value="DESC" <?php
                                                                if ($order == 'DESC') {
                                                                    echo "selected";
                                                                };
                                                                ?>><?php echo esc_html__("Descending ", "nokri"); ?></option>
                                                            </select>
                                                            <?php echo nokri_form_lang_field_callback(true); ?>
                                                            <?php
                                                            if (!$multi_searach) {
                                                                echo nokri_search_params('order_job');
                                                            }
                                                            ?>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($job_alerts) { ?>
                                                <div class="jobs-alert-box">
                                                    <div class="row">
                                                        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                                                            <span><?php echo esc_html($job_alerts_title); ?></span>
                                                            <p><?php echo esc_html($job_alerts_tagline); ?></p>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                                                            <a href="javascript:void(0)" class="btn n-btn-flat job_alert"><?php echo esc_html($job_alerts_btn); ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="n-advert-display"> 
                                                <?php echo '' . $advert_up; ?>
                                            </div>
                                            <?php
                                            if (isset($nokri['premium_jobs_class_switch']) && $nokri['premium_jobs_class_switch'] == '1') {
                                                $section_title = (isset($nokri['premium_jobs_class_title']) && $nokri['premium_jobs_class_title'] != "") ? '<h3>' . $nokri['premium_jobs_class_title'] . '</h3>' : "";
                                                echo "<div class='n-search-listing n-featured-jobs featured'>";
                                                /* Premium jobs in list style */
                                                $results_premium = new WP_Query($args_premium);
                                                $current_layout = $nokri['search_layout'];
                                                $layouts = array('list_1', 'list_2', 'list_3');
                                                if ($results_premium->have_posts()) {
                                                    echo '' . $section_title;
                                                    echo "<div class='n-featured-job-boxes'>";
                                                    if (in_array($current_layout, $layouts)) {
                                                        require trailingslashit(get_template_directory()) . "template-parts/layouts/job-style/search-layout-premium-list2.php";
                                                        echo '' . ($out);
                                                    }
                                                    wp_reset_postdata();
                                                    echo "</div>";
                                                }
                                                echo "</div>";
                                            }
                                            ?>
                                            <div class="n-search-listing n-featured-jobs jooble-jobs-area">
                                                <h3><?php echo esc_html__('Regular Jobs', 'nokri') ?></h3>
                                                <?php
                                                if ($jooble_position == 1) {
                                                    $jooble_html = "";
                                                    $is_access = (isset($nokri['jooble_api_btn']) ? $nokri['jooble_api_btn'] : false);
                                                    $jobs_counter = (isset($nokri['nokri_jooble_import_jobs']) ? $nokri['nokri_jooble_import_jobs'] : 5);
                                                    if ($is_access) {
                                                        ?>
                                                        <div class="n-featured-job-boxes" >
                                                            <?php
                                                            $counter = 0;
                                                            $all_jooble_jobs = nokri_get_jooble_jobs();
                                                            if (is_array($all_jooble_jobs) && !empty($all_jooble_jobs)) {
                                                                foreach ($all_jooble_jobs['jobs'] as $jooble_jobs) {
                                                                    if ($counter >= $jobs_counter) {
                                                                        break;
                                                                    }
                                                                    $jooble_job_id = isset($jooble_jobs['id']) ? $jooble_jobs['id'] : '';
                                                                    $jooble_title = isset($jooble_jobs['title']) ? $jooble_jobs['title'] : '';
                                                                    $jooble_link = isset($jooble_jobs['link']) ? $jooble_jobs['link'] : '';
                                                                    $jooble_source = isset($jooble_jobs['source']) ? $jooble_jobs['source'] : '';
                                                                    $jooble_company = isset($jooble_jobs['company']) ? $jooble_jobs['company'] : '';
                                                                    $jooble_location = isset($jooble_jobs['location']) ? $jooble_jobs['location'] : '';
                                                                    $jooble_updated = isset($jooble_jobs['updated']) ? $jooble_jobs['updated'] : '';
                                                                    $jooble_type = isset($jooble_jobs['type']) ? $jooble_jobs['type'] : '';
                                                                    $jooble_updated = human_time_diff(strtotime($jooble_updated), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                                    $jooble_html .= '<div class = "n-job-single n-jooble-single">                                  
                                                                                    <div class = "n-job-detail">
                                                                                        <ul class = "list-inline">
                                                                                            <li class = "n-job-title-box">
                                                                                                <h4><a href = "' . esc_url($jooble_link) . '">' . esc_html($jooble_title) . '</a></h4>
                                                                                                <p class = "company-name"><a href = "' . esc_url($jooble_link) . '" class = "">' . esc_html($jooble_company) . '</a></p>
                                                                                                <p>
                                                                                                    <span><i class = "ti-location-pin"></i> <a href = "' . esc_url($jooble_link) . '">' . esc_html($jooble_location) . '</a></span><span><i class = "ti-tag"></i> <a href = "' . esc_url($jooble_link) . '">' . esc_html($jooble_title) . '</a></span>
                                                                                                </p>
                                                                                            </li>
                                                                                            <li class = "n-job-short">
                                                                                                <span> <strong>' . esc_html__('Job type', 'nokri') . '</strong>' . esc_html($jooble_type) . '</span>
                                                                                                <span> <strong>' . esc_html__('Posted', 'nokri') . '</strong>' . esc_html($jooble_updated) . '</span>
                                                                                            </li>
                                                                                            <li class = "n-job-btns">
                                                                                                <a href = "' . esc_url($jooble_link) . '" class = "btn n-btn-rounded" target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>
                                                                                            </li>
                                                                                        </ul>
                                                                                        <p class ="n-jooble-bottom">' . esc_html__('powered by Jooble', 'nokri') . '</p>
                                                                                    </div></div>';
                                                                    $counter++;
                                                                }
                                                            }
                                                            echo nokri_returnEcho($jooble_html);
                                                            ?>
                                                            <div class="clear-both"></div>
                                                        </div> 

                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <div class="n-featured-job-boxes">
                                                    <?php
                                                    /* Regular Search Query */
                                                    if ($results->have_posts()) {
                                                        $current_layout = $nokri['search_layout'];
                                                        $layouts = array('list_1', 'list_2', 'list_3');
                                                        if ($results->have_posts()) {
                                                            if (in_array($current_layout, $layouts)) {
                                                                require trailingslashit(get_template_directory()) . "template-parts/layouts/job-style/search-layout-full.php";
                                                                echo '' . ($out);
                                                            } else {
                                                                require trailingslashit(get_template_directory()) . "template-parts/layouts/job-style/search-layout-grid.php";
                                                                echo '' . ($out);
                                                            }
                                                            /* Restore original Post Data */
                                                            wp_reset_postdata();
                                                        }
                                                    }
                                                    ?>
                                                    <div class="n-featured-job-boxes" id="jobs_container"></div>
                                                    <?php
                                                    if ($jooble_position == 2) {
                                                        $jooble_html = "";
                                                        $is_access = (isset($nokri['jooble_api_btn']) ? $nokri['jooble_api_btn'] : false);
                                                        $jobs_counter = (isset($nokri['nokri_jooble_import_jobs']) ? $nokri['nokri_jooble_import_jobs'] : 5);
                                                        if ($is_access) {
                                                            ?>
                                                            <div class="n-featured-job-boxes" >
                                                                <?php
                                                                $counter = 0;
                                                                $all_jooble_jobs = nokri_get_jooble_jobs();
                                                                if (is_array($all_jooble_jobs) && !empty($all_jooble_jobs)) {
                                                                    foreach ($all_jooble_jobs['jobs'] as $jooble_jobs) {
                                                                        if ($counter >= $jobs_counter) {
                                                                            break;
                                                                        }
                                                                        $jooble_job_id = isset($jooble_jobs['id']) ? $jooble_jobs['id'] : '';
                                                                        $jooble_title = isset($jooble_jobs['title']) ? $jooble_jobs['title'] : '';
                                                                        $jooble_link = isset($jooble_jobs['link']) ? $jooble_jobs['link'] : '';
                                                                        $jooble_source = isset($jooble_jobs['source']) ? $jooble_jobs['source'] : '';
                                                                        $jooble_company = isset($jooble_jobs['company']) ? $jooble_jobs['company'] : '';
                                                                        $jooble_location = isset($jooble_jobs['location']) ? $jooble_jobs['location'] : '';
                                                                        $jooble_updated = isset($jooble_jobs['updated']) ? $jooble_jobs['updated'] : '';
                                                                        $jooble_type = isset($jooble_jobs['type']) ? $jooble_jobs['type'] : '';
                                                                        $jooble_updated = human_time_diff(strtotime($jooble_updated), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                                        $jooble_html .= '                                                           
                                                                                <div class = "n-job-single ">                                  
                                                                                <div class = "n-job-detail">
                                                                                    <ul class = "list-inline">
                                                                                        <li class = "n-job-title-box">
                                                                                            <h4><a href = "' . esc_url($jooble_link) . '">' . esc_html($jooble_title) . '</a></h4>
                                                                                            <p class = "company-name"><a href = "' . esc_url($jooble_link) . '" class = "">' . esc_html($jooble_company) . '</a></p>
                                                                                            <p>
                                                                                                <span><i class = "ti-location-pin"></i> <a href = "' . esc_url($jooble_link) . '">' . esc_html($jooble_location) . '</a></span><span><i class = "ti-tag"></i> <a href = "' . esc_url($jooble_link) . '">' . esc_html($jooble_title) . '</a></span>
                                                                                            </p>

                                                                                        </li>
                                                                                        <li class = "n-job-short">
                                                                                            <span> <strong>' . esc_html__('Job type', 'nokri') . '</strong>' . esc_html($jooble_type) . '</span>
                                                                                            <span> <strong>' . esc_html__('Posted', 'nokri') . '</strong>' . esc_html($jooble_updated) . '</span>
                                                                                        </li>
                                                                                        <li class = "n-job-btns">
                                                                                            <a href = "' . esc_url($jooble_link) . '" class = "btn n-btn-rounded" target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>

                                                                                        </li>
                                                                                    </ul>
                                                                                    <p class ="n-jooble-bottom">' . esc_html__('powered by Jooble', 'nokri') . '</p>
                                                                                </div></div>';
                                                                        $counter++;
                                                                    }
                                                                }
                                                                ?> 
                                                                <?php echo '' . $jooble_html; ?>
                                                            </div> 
                                                            <div class="clear-both"></div>

                                                            <?php
                                                        }
                                                    }
                                                    ?> 
                                                    <div class="clearfix"></div>
                                                    <!-- CareerJet Jobs Import -->
                                                    <?php
                                                    $counter = 0;
                                                    $is_allow = (isset($nokri['careerjet_api_btn']) ? $nokri['careerjet_api_btn'] : false);
                                                    if ($is_allow) {
                                                        $jobs_counter = (isset($nokri['nokri_careerjet_import_jobs']) ? $nokri['nokri_careerjet_import_jobs'] : 5);
                                                        $careerJetJobs = nokri_get_careerjet_jobs();
                                                        if (is_array($careerJetJobs) && !empty($careerJetJobs)) {
                                                            foreach ($careerJetJobs as $get_jet_jobs) {
                                                                if ($counter >= $jobs_counter) {
                                                                    break;
                                                                }
                                                                $job_url = isset($get_jet_jobs['url']) ? $get_jet_jobs['url'] : '';
                                                                $job_date = isset($get_jet_jobs['date']) ? $get_jet_jobs['date'] : '';
                                                                $job_title = isset($get_jet_jobs['title']) ? $get_jet_jobs['title'] : '';
                                                                $job_salary = isset($get_jet_jobs['salary']) ? $get_jet_jobs['salary'] : '';
                                                                $job_company = isset($get_jet_jobs['company']) ? $get_jet_jobs['company'] : '';
                                                                $job_locations = isset($get_jet_jobs['locations']) ? $get_jet_jobs['locations'] : '';
                                                                $job_salary_max = isset($get_jet_jobs['salary_max']) ? $get_jet_jobs['salary_max'] : '';
                                                                $job_description = isset($get_jet_jobs['description']) ? $get_jet_jobs['description'] : '';
                                                                $job_date = human_time_diff(strtotime($job_date), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                                $careerJet_html = "";
                                                                $careerJet_html .= '<div class = "n-job-single ">                                  
                                                                            <div class = "n-job-detail">
                                                                                <ul class = "list-inline">
                                                                                    <li class = "n-job-title-box">
                                                                                        <h4><a href = "' . esc_url($job_url) . '">' . esc_html($job_title) . '</a></h4>
                                                                                        <p class = "company-name"><a href = "' . esc_url($job_url) . '" class = "">' . esc_html($job_company) . '</a></p>
                                                                                        <p>
                                                                                            <span><i class = "ti-location-pin"></i> <a href = "' . esc_url($job_url) . '">' . esc_html($job_locations) . '</a></span><span><i class = "ti-tag"></i> <a href = "' . esc_url($job_url) . '">' . esc_html($job_title) . '</a></span>
                                                                                        </p>
                                                                                    </li>
                                                                                    <li class = "n-job-short">
                                                                                        <span> <strong>' . esc_html__('Salary', 'nokri') . '</strong>' . esc_html($job_salary) . '</span>
                                                                                        <span> <strong>' . esc_html__('Date Posted', 'nokri') . '</strong>' . esc_html($job_date) . '</span>
                                                                                    </li>
                                                                                    <li class = "n-job-btns">
                                                                                        <a href = "' . esc_url($job_url) . '" class = "btn n-btn-rounded" target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>
                                                                                    </li>
                                                                                </ul>
                                                                                <p class ="n-jooble-bottom">' . esc_html__('found on careerjet', 'nokri') . '</p>
                                                                            </div></div>';
                                                                $counter++;
                                                                echo nokri_returnEcho($careerJet_html);
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <div class="clear-both"></div>
                                                    <!--GitHub Jobs Integration-->
                                                    <?php
                                                    $github_html = "";
                                                    $is_accessed = (isset($nokri['gitjob_btn']) ? $nokri['gitjob_btn'] : false);
                                                    $jobs_limt = (isset($nokri['nokri_git_jobs_limit']) ? $nokri['nokri_git_jobs_limit'] : 5);
                                                    if ($is_accessed) {
                                                        ?>
                                                        <div class="n-featured-job-boxes" >
                                                            <?php
                                                            $counter = 0;
                                                            $git_jobs_data = nokri_get_github_jobs();

                                                            $all_git_jobs = json_decode(json_encode($git_jobs_data), TRUE);
                                                            $git_jobs = $data_array = array();
                                                            if (is_array($all_git_jobs) && !empty($all_git_jobs)) {
                                                                foreach ($all_git_jobs as $key => $github_jobs) {
                                                                    if ($counter >= $jobs_limt) {
                                                                        break;
                                                                    }
                                                                    $git_jobs_id = isset($github_jobs['id']) ? $github_jobs['id'] : '';
                                                                    $git_jobs_url = isset($github_jobs['url']) ? $github_jobs['url'] : '';
                                                                    $git_jobs_type = isset($github_jobs['type']) ? $github_jobs['type'] : '';
                                                                    $git_jobs_title = isset($github_jobs['title']) ? $github_jobs['title'] : '';
                                                                    $git_jobs_company = isset($github_jobs['company']) ? $github_jobs['company'] : '';
                                                                    $git_jobs_location = isset($github_jobs['location']) ? $github_jobs['location'] : '';
                                                                    $git_jobs_created_at = isset($github_jobs['created_at']) ? $github_jobs['created_at'] : '';
                                                                    $git_jobs_description = isset($github_jobs['description']) ? $github_jobs['description'] : '';
                                                                    $git_jobs_company_url = isset($github_jobs['company_url']) ? $github_jobs['company_url'] : '';
                                                                    $git_jobs_created_at = human_time_diff(strtotime($git_jobs_created_at), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                                    $github_html .= '<div class = "n-job-single ">                                  
                                                                                <div class = "n-job-detail">
                                                                                    <ul class = "list-inline">
                                                                                        <li class = "n-job-title-box">
                                                                                            <h4><a href = "' . esc_url($git_jobs_url) . '">' . esc_html($git_jobs_title) . '</a></h4>
                                                                                            <p class = "company-name"><a href = "' . esc_url($git_jobs_url) . '" class = "">' . esc_html($git_jobs_company) . '</a></p>
                                                                                            <p>
                                                                                                <span><i class = "ti-location-pin"></i> <a href = "' . esc_url($git_jobs_url) . '">' . esc_html($git_jobs_location) . '</a></span><span><i class = "ti-tag"></i> <a href = "' . esc_url($git_jobs_url) . '">' . esc_html($git_jobs_title) . '</a></span>
                                                                                            </p>

                                                                                        </li>
                                                                                        <li class = "n-job-short">
                                                                                            <span> <strong>' . esc_html__('Job type', 'nokri') . '</strong>' . esc_html($git_jobs_type) . '</span>
                                                                                            <span> <strong>' . esc_html__('Posted', 'nokri') . '</strong>' . esc_html($git_jobs_created_at) . '</span>
                                                                                        </li>
                                                                                        <li class = "n-job-btns">
                                                                                            <a href = "' . esc_url($git_jobs_url) . '" class = "btn n-btn-rounded" target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>
                                                                                        </li>
                                                                                    </ul>
                                                                                    <p class ="n-jooble-bottom">' . esc_html__('Found on GitHub', 'nokri') . '</p>
                                                                                </div></div>';
                                                                    $counter++;
                                                                }
                                                            }
                                                            echo nokri_returnEcho($github_html);
                                                            ?>
                                                        </div> 
                                                        <div class="clear-both"></div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <!--Getting All ReedCo Jobs-->
                                                    <?php
                                                    $reedco_html = "";
                                                    $jobs_counter = (isset($nokri['nokri_reedco_import_jobs']) ? $nokri['nokri_reedco_import_jobs'] : 5);
                                                    $is_allowed = (isset($nokri['reedco_jobs_api_btn']) ? $nokri['reedco_jobs_api_btn'] : false);
                                                    if ($is_allowed) {
                                                        ?>
                                                        <div class="n-featured-job-boxes" >
                                                            <?php
                                                            $counter = 0;
                                                            /* Getting All ReedCo Jobs Function */
                                                            $all_reedco_jobs = nokri_get_reedco_jobs();
                                                            if (is_array($all_reedco_jobs) && !empty($all_reedco_jobs)) {
                                                                foreach ($all_reedco_jobs as $reedco_jobs) {
                                                                    if (is_array($reedco_jobs) && !empty($reedco_jobs)) {
                                                                        foreach ($reedco_jobs as $reedco_job) {
                                                                            if ($counter >= $jobs_counter) {
                                                                                break;
                                                                            }
                                                                            $jobId = isset($reedco_job['jobId']) ? $reedco_job['jobId'] : '';
                                                                            $postDate = isset($reedco_job['date']) ? $reedco_job['date'] : '';
                                                                            $jobUrl = isset($reedco_job['jobUrl']) ? $reedco_job['jobUrl'] : '';
                                                                            $jobTitle = isset($reedco_job['jobTitle']) ? $reedco_job['jobTitle'] : '';
                                                                            $currency = isset($reedco_job['currency']) ? $reedco_job['currency'] : '';
                                                                            $locationName = isset($reedco_job['locationName']) ? $reedco_job['locationName'] : '';
                                                                            $employerName = isset($reedco_job['employerName']) ? $reedco_job['employerName'] : '';
                                                                            $minimumSalary = isset($reedco_job['minimumSalary']) ? $reedco_job['minimumSalary'] : '';
                                                                            $maximumSalary = isset($reedco_job['maximumSalary']) ? $reedco_job['maximumSalary'] : '';
                                                                            $expirationDate = isset($reedco_job['expirationDate']) ? $reedco_job['expirationDate'] : '';
                                                                            $jobDescription = isset($reedco_job['jobDescription']) ? $reedco_job['jobDescription'] : '';
                                                                            $date = str_replace('/', '-', $postDate);
                                                                            $postDate = human_time_diff(strtotime($date), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                                            $reedco_html .= '<div class = "n-job-single ">                                  
                                                                                                <div class = "n-job-detail">
                                                                                                    <ul class = "list-inline">
                                                                                                        <li class = "n-job-title-box">
                                                                                                            <h4><a href = "' . esc_url($jobUrl) . '">' . esc_html($jobTitle) . '</a></h4>
                                                                                                            <p class = "company-name"><a href = "' . esc_url($jobUrl) . '" class = "">' . esc_html($employerName) . '</a></p>
                                                                                                            <p>
                                                                                                                <span><i class = "ti-location-pin"></i> <a href = "' . esc_url($jobUrl) . '">' . esc_html($locationName) . '</a></span><span><i class = "ti-tag"></i> <a href = "' . esc_url($jobUrl) . '">' . esc_html($jobTitle) . '</a></span>
                                                                                                            </p>

                                                                                                        </li>
                                                                                                        <li class = "n-job-short">
                                                                                                            <span> <strong>' . esc_html__('Minimum Salary', 'nokri') . '</strong>' . esc_html($minimumSalary) . '</span>
                                                                                                            <span> <strong>' . esc_html__('Currency', 'nokri') . '</strong>' . esc_html($currency) . '</span>
                                                                                                            <span> <strong>' . esc_html__('Posted', 'nokri') . '</strong>' . esc_html($postDate) . '</span>
                                                                                                            <span> <strong>' . esc_html__('Expiry Date', 'nokri') . '</strong>' . esc_html($expirationDate) . '</span>
                                                                                                        </li>
                                                                                                        <li class = "n-job-btns">
                                                                                                        <a href = "' . esc_url($jobUrl) . '" class = "btn n-btn-rounded" target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>
                                                                                                        </li>
                                                                                                    </ul>
                                                                                                    <p class ="n-jooble-bottom">' . esc_html__('get By ReedCo', 'nokri') . '</p>
                                                                                                </div></div>';
                                                                            $counter++;
                                                                        }
                                                                    }
                                                                }
                                                                echo nokri_returnEcho($reedco_html);
                                                                ?> 
                                                            </div> 
                                                            <div class="clear-both"></div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <!--Adzuna Jobs Integration-->
                                                    <?php
                                                    $adzuna_html = "";
                                                    $is_accessedd = (isset($nokri['adzunajobs_btn']) ? $nokri['adzunajobs_btn'] : false);
                                                    $jobs_limts = (isset($nokri['nokri_adzuna_jobs_limit']) ? $nokri['nokri_adzuna_jobs_limit'] : 5);
                                                    if ($is_accessedd) {
                                                        ?>
                                                        <div class="n-featured-job-boxes" >
                                                            <?php
                                                            $counter = 0;
                                                            $adzuJobs = nokri_import_adzuna_jobs();
                                                            $all_adzuna_jobs = json_decode(json_encode($adzuJobs), TRUE);
                                                            if (is_array($all_adzuna_jobs) || is_object($all_adzuna_jobs) && !empty($all_adzuna_jobs)) {
                                                                foreach ($all_adzuna_jobs['results'] as $adzunaJobs) {

                                                                    if ($counter >= $jobs_limts) {
                                                                        break;
                                                                    }
                                                                    //Removed <strong>, </strong> from title with string replace.
                                                                    $adzujobs_title_str = isset($adzunaJobs['title']) ? $adzunaJobs['title'] : '';
                                                                    $adzujobs_title_str1 = str_replace("<strong>", "", $adzujobs_title_str);
                                                                    $adzujobs_title = str_replace("</strong>", "", $adzujobs_title_str1);
                                                                    $adzujobs_id = isset($adzunaJobs['id']) ? $adzunaJobs['id'] : '';
                                                                    $adzujobs_created = isset($adzunaJobs['created']) ? $adzunaJobs['created'] : '';
                                                                    $adzujobs_city = isset($adzunaJobs['location']['area'][1]) ? $adzunaJobs['location']['area'][1] : '';
                                                                    $adzujobs_country = isset($adzunaJobs['location']['area'][0]) ? $adzunaJobs['location']['area'][0] : '';
                                                                    $adzujobs_url = isset($adzunaJobs['redirect_url']) ? $adzunaJobs['redirect_url'] : '';
                                                                    $adzujobs_salary_max = isset($adzunaJobs['salary_max']) ? $adzunaJobs['salary_max'] : '';
                                                                    $adzujobs_salary_min = isset($adzunaJobs['salary_min']) ? $adzunaJobs['salary_min'] : '';
                                                                    $adzujobs_company_url = isset($adzunaJobs['company_url']) ? $adzunaJobs['company_url'] : '';
                                                                    $adzujobs_description = isset($adzunaJobs['description']) ? $adzunaJobs['description'] : '';
                                                                    $adzujobs_company = isset($adzunaJobs['company']['display_name']) ? $adzunaJobs['company']['display_name'] : '';
                                                                    $adzujobs_created = human_time_diff(strtotime($adzujobs_created), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                                    $adzuna_html .= '<div class = "n-job-single ">                                  
                                                                        <div class = "n-job-detail">
                                                                            <ul class = "list-inline">
                                                                                <li class = "n-job-title-box">
                                                                                    <h4><a href = "' . esc_url($adzujobs_url) . '">' . esc_html($adzujobs_title) . '</a></h4>
                                                                                    <p class = "company-name"><a href = "' . esc_url($adzujobs_url) . '" class = "">' . esc_html($adzujobs_company) . '</a></p>
                                                                                    <p>
                                                                                        <span><i class = "ti-location-pin"></i> <a href = "' . esc_url($adzujobs_url) . '">' . esc_html($adzujobs_city) . '</a></span><span><i class = "ti-tag"></i> <a href = "' . esc_url($adzujobs_url) . '">' . esc_html($adzujobs_country) . '</a></span>
                                                                                    </p>

                                                                                </li>
                                                                                <li class = "n-job-short">
                                                                                    <span> <strong>' . esc_html__('Posted', 'nokri') . '</strong>' . esc_html($adzujobs_created) . '</span>
                                                                                    <span> <strong>' . esc_html__('Max Salary', 'nokri') . '</strong>' . esc_html($adzujobs_salary_max) . '</span>
                                                                                    
                                                                                </li>
                                                                                <li class = "n-job-btns">
                                                                                    <a href = "' . esc_url($adzujobs_url) . '" class = "btn n-btn-rounded" target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>

                                                                                </li>
                                                                            </ul>
                                                                            <p class ="n-jooble-bottom">' . esc_html__('By Adzuna TotalJobs', 'nokri') . '</p>
                                                                        </div></div>';
                                                                    $counter++;
                                                                }
                                                            }

                                                            echo nokri_returnEcho($adzuna_html);
                                                            ?>
                                                        </div>                                   
                                                        <div class="clear-both"></div>
                                                    <?php } ?>
                                                    <!-- Remotive Jobs Integration API -->
                                                    <?php
                                                    $remotive_html = "";
                                                    $remotive_api_btn = isset($nokri['remotive_api_btn']) ? $nokri['remotive_api_btn'] : false;
                                                    if ($remotive_api_btn) {
                                                        ?>
                                                        <div class="n-featured-job-boxes" >
                                                            <?php
                                                            $all_remotive_jobs = nokri_get_remotive_jobs();
                                                            if (is_array($all_remotive_jobs) && !empty($all_remotive_jobs)) {
                                                                foreach ($all_remotive_jobs['jobs'] as $remotive_jobs) {

                                                                    $remotive_job_id = isset($remotive_jobs['id']) ? $remotive_jobs['id'] : '';
                                                                    $remotive_title = isset($remotive_jobs['title']) ? $remotive_jobs['title'] : '';
                                                                    $company_description = isset($remotive_jobs['description']) ? $remotive_jobs['description'] : '';
                                                                    $remotive_link = isset($remotive_jobs['url']) ? $remotive_jobs['url'] : '';
                                                                    $remotive_category = isset($remotive_jobs['category']) ? $remotive_jobs['category'] : '';
                                                                    $remotive_company_name = isset($remotive_jobs['company_name']) ? $remotive_jobs['company_name'] : '';
                                                                    $remotive_publication_date = isset($remotive_jobs['publication_date']) ? $remotive_jobs['publication_date'] : '';
                                                                    $remotive_job_type = isset($remotive_jobs['job_type']) ? $remotive_jobs['job_type'] : '';
                                                                    $remotive_publication_date = human_time_diff(strtotime($remotive_publication_date), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
                                                                    $remotive_salary = isset($remotive_jobs['salary']) ? $remotive_jobs['salary'] : '';
                                                                    $company_logo_url = isset($remotive_jobs['company_logo_url']) ? $remotive_jobs['company_logo_url'] : '';
                                                                    $candidate_required_location = isset($remotive_jobs['candidate_required_location']) ? $remotive_jobs['candidate_required_location'] : '';

                                                                    $remotive_html .= '<div class = "n-job-single">                                  
                                                                        <div class = "n-job-detail">
                                                                            <ul class = "list-inline">
                                                                                <li class = "n-job-title-box">
                                                                                    <h4><a href = "' . esc_url($remotive_link) . '">' . esc_html($remotive_title) . '</a></h4>
                                                                                    <p class = "company-name"><a href = "' . esc_url($remotive_link) . '" class = "">' . esc_html($remotive_company_name) . '</a></p>
                                                                                    <p>
                                                                                        <span><i class = "ti-location-pin"></i> <a href = "' . esc_url($remotive_link) . '">' . esc_html($candidate_required_location) . '</a></span><span>
                                                                                    </p>
                                                                                </li>
                                                                                <li class = "n-job-short">
                                                                                    <span> <strong>' . esc_html__('Posted', 'nokri') . '</strong>' . esc_html($remotive_publication_date) . '</span>
                                                                                    <span> <strong>' . esc_html__('Salary', 'nokri') . '</strong>' . esc_html($remotive_salary) . '</span>
                                                                                    <span> <strong>' . esc_html__('Required Location', 'nokri') . '</strong>' . esc_html($candidate_required_location) . '</span>
                                                                                </li>
                                                                                <li class = "n-job-btns">
                                                                                    <a href = "' . esc_url($remotive_link) . '" class = "btn n-btn-rounded" target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>
                                                                                </li>
                                                                            </ul>
                                                                            <p class ="n-jooble-bottom">' . esc_html__('By Remotive jobs', 'nokri') . '</p>
                                                                        </div></div>';
                                                                }
                                                            }
                                                            echo '' . ($remotive_html);
                                                            ?>
                                                        </div>
                                                        <div class="clear-both"></div>
                                                    <?php } ?>
                                                    <div class="n-advert-display"> 
                                                        <?php echo nokri_returnEcho($advert_down); ?>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                                        <?php if (isset($nokri['job_search_loader']) && $nokri['job_search_loader'] && $results->have_posts()) { ?>
                                                            <div  class = "loader_container" style="display: none"> 
                                                                <img class="loader_img" src="<?php echo esc_url($loader_image) ?>" >
                                                                <img class="loader_img" src="<?php echo esc_url($loader_image) ?>">
                                                                <img class="loader_img" src="<?php echo esc_url($loader_image) ?>" >
                                                            </div>
                                                            <center>
                                                                <button class="btn n-btn-flat" id="more_jobs"><?php echo esc_html__('More jobs', 'nokri') ?><span class="fa fa-spinner"></span></button>
                                                            </center>
                                                            <input type="hidden" id="page_number" value="1" />
                                                            <input type="hidden" id="more_loading" value="1" />
                                                            <input type="hidden" id="page_url" value ="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" />
                                                        <?php } else { ?>                                                    
                                                            <nav aria-label="Page navigation">
                                                                <?php echo nokri_job_pagination($results); ?>
                                                            </nav>                                         
                                                        <?php } ?>
                                                    </div>
                                                </div>                                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--footer section-->
                <?php
            } else {
                /* Getting map layout */
                get_template_part('template-parts/layouts/job-style/search', 'map');
            }
            get_footer();
            