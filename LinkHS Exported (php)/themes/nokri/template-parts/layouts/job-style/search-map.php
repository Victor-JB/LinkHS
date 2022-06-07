<?php
global $nokri;
/* Getting Title From Query String */
$title = '';
if (isset($_GET['job-title']) && $_GET['job-title'] != "") {
    $title = $_GET['job-title'];
}
/* Getting All Taxonomy From Query String */
$taxonomies = array('job_type', 'ad_title', 'cat_id', 'job_category', 'job_tags', 'job_qualifications', 'job_level', 'job_salary', 'job_currency', 'job_skills', 'job_experience', 'job_currency', 'job_shift', 'job_class', 'ad_location');
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
/* Passing Query String Results To Arguments */
$order = 'DESC';
if (isset($_GET['order_job'])) {
    if (isset($_GET['order_job']) && $_GET['order_job'] != "") {
        $order = $_GET['order_job'];
    }
}

/* Custom feilds search satrts */
$custom_search = array();
if (isset($_GET['custom'])) {
    foreach ($_GET['custom'] as $key => $val) {
        if (is_array($val)) {
            $arr = array();
            $metaKey = '_nokri_tpl_field_' . $key;

            foreach ($val as $v) {

                $custom_search[] = array(
                    'key' => $metaKey,
                    'value' => $v,
                    'compare' => 'LIKE',
                );
            }
        } else {
            if (trim($val) == "0") {
                continue;
            }

            $val = stripslashes_deep($val);

            $metaKey = '_nokri_tpl_field_' . $key;
            $custom_search[] = array(
                'key' => $metaKey,
                'value' => $val,
                'compare' => 'LIKE',
            );
        }
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


if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} else if (get_query_var('page')) {
    /* This will occur if on front page. */
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
$html = '';


$args = array(
    'tax_query' => array($category, $job_salary, $title, $job_type, $job_category, $job_tags, $job_qualifications, $job_level, $job_skills, $job_experience, $job_currency, $job_shift, $job_class, $location, $location_keyword),
    's' => $title,
    'posts_per_page' => get_option('posts_per_page'),
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

$results = new WP_Query($args);
if ($results->found_posts > 0) {
    $message = __('Available Jobs', 'nokri');
} else {
    $message = __('No Jobs Matched', 'nokri');
}
/* Default */
$lat = ( isset($nokri['sb_default_lat']) && $nokri['sb_default_lat'] != "" ) ? $nokri['sb_default_lat'] : 40.7127837;
$long = ( isset($nokri['sb_default_long']) && $nokri['sb_default_long'] != "" ) ? $nokri['sb_default_long'] : -74.00594130000002;
/* Premium Jobs Top Query */
$premium_jobs_class_num = ( isset($nokri['premium_jobs_class_number']) && $nokri['premium_jobs_class_number'] != "" ) ? $nokri['premium_jobs_class_number'] : "";

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
        'tax_query' => array($job_classes, $category),
        'posts_per_page' => $premium_jobs_class_num,
        'post_type' => 'job_post',
        'post_status' => 'publish',
        'orderby' => 'rand',
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
        $advert_up = '<div class="n-advert-box">' . $nokri['search_job_advert_up'] . '</div>';
    }
    /* Below jobs */
    if (isset($nokri['search_job_advert_down']) && $nokri['search_job_advert_down'] != "") {
        $advert_down = '<div class="n-advert-box">' . $nokri['search_job_advert_down'] . '</div>';
    }
}
/* Is job alerts */
$job_alerts = ( isset($nokri['job_alerts_switch']) && $nokri['job_alerts_switch'] != "" ) ? $nokri['job_alerts_switch'] : false;
/* Job alert title */
$job_alerts_title = ( isset($nokri['job_alerts_title']) && $nokri['job_alerts_title'] != "" ) ? $nokri['job_alerts_title'] : '';
/* Job alert tagline */
$job_alerts_tagline = ( isset($nokri['job_alerts_tagline']) && $nokri['job_alerts_tagline'] != "" ) ? $nokri['job_alerts_tagline'] : '';
/* Job alert btn */
$job_alerts_btn = ( isset($nokri['job_alerts_btn']) && $nokri['job_alerts_btn'] != "" ) ? $nokri['job_alerts_btn'] : '';
$loader_image = get_template_directory_uri() . '/images/loader-img.png';

$jooble_position = isset($nokri['jooble_job_position']) ? $nokri['jooble_job_position'] : '1';
?>
<div class="search-page-with-map sidebars">
    <?php get_sidebar('map'); ?>
    <div class="left-part">
        <div class="col-md-12 col-xs-12 col-sm-12 side-listings">
            <div class="n-search-main">
                <div class="heading-area">
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <h4><?php echo esc_html($message) . " " . '(' . esc_html($results->found_posts) . ')'; ?></h4>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <form method="GET" id="job_order_search">
                                <select class="js-example-basic-single form-control change_order" data-allow-clear="true" data-placeholder="<?php echo esc_html__("Select Option", "nokri"); ?>" style="width: 100%" name="order_job">
                                    <option value="0" ><?php echo esc_html__("Select Option", "nokri"); ?></option>
                                    <option value="ASC" <?php
                                    if ($order == 'ASC') {
                                        echo "selected";
                                    };
                                    ?> ><?php echo esc_html__("Ascending", "nokri"); ?></option>
                                    <option value="DESC" <?php
                                    if ($order == 'DESC') {
                                        echo "selected";
                                    };
                                    ?>><?php echo esc_html__("Descending ", "nokri"); ?></option>
                                </select>
                                <?php echo nokri_form_lang_field_callback(true) ?>
                            </form>
                        </div>
                    </div>
                </div>
                <?php echo '' . $advert_up; ?>
                <?php if ($job_alerts) { ?>
                    <div class="jobs-alert-box">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <span><?php echo esc_html($job_alerts_title); ?></span>
                            <p><?php echo esc_html($job_alerts_tagline); ?></p>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <a href="javascript:void(0)" class="btn n-btn-flat job_alert"><?php echo esc_html($job_alerts_btn); ?></a>
                        </div>
                    </div>
                <?php } ?>
                <div class="n-search-listing n-featured-jobs featured">
                    <div class="n-featured-job-boxes">
                        <?php
                        if (isset($nokri['premium_jobs_class_switch']) && $nokri['premium_jobs_class_switch'] == '1') {
                            /* Section Title */
                            $section_title = (isset($nokri['premium_jobs_class_title']) && $nokri['premium_jobs_class_title'] != "") ? '<div class="heading"><h4>' . $nokri['premium_jobs_class_title'] . '</h4></div>' : "";
                            echo ''.($section_title);
                            /* Premium jobs in list style */
                            $results_premium = new WP_Query($args_premium);
                            $current_layout = $nokri['search_layout'];
                            $layouts = array('list_1', 'list_2', 'list_3');
                            if ($results_premium->have_posts()) {
                                if (in_array($current_layout, $layouts)) {
                                    require trailingslashit(get_template_directory()) . "template-parts/layouts/job-style/search-layout-premium-list2.php";
                                    echo '' . $out;
                                }
                                wp_reset_postdata();
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="n-search-listing n-featured-jobs jooble-jobs-area">
                    <h3><?php echo esc_html__('Regular Jobs', 'nokri'); ?></h3>
                    <div class="n-featured-job-boxes">
                        <?php
                        if ($jooble_position == 1) {
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
                                            $date = date("F j, Y, g:i a");
                                            $jooble_updated = $date;
                                            $jooble_html .= '<div class = "n-job-single ">                                  
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
                                                                        <span> <strong>' . esc_html('Job type', 'nokri') . '</strong>' . esc_html($jooble_type) . '</span>
                                                                        <span> <strong>' . esc_html('Posted', 'nokri') . '</strong>' . esc_html($jooble_updated) . '</span>
                                                                    </li>
                                                                    <li class = "n-job-btns">
                                                                        <a href = "' . esc_url($jooble_link) . '" class = "btn n-btn-rounded " target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>
                                                                    </li>
                                                                </ul>
                                                                   <p class ="n-jooble-bottom">' . esc_html__('powered by Jooble', 'nokri') . '</p>                                                   
                                                       </div> </div>';
                                            $counter++;
                                        }
                                    }
                                    ?> 
                                    <?php echo '' . $jooble_html; ?>
                                </div> 
                                <div class="clear-both"></div>.
                                <?php
                            }
                        }
                        ?> 
                        <?php
                        /* Regular Search Query */
                        $map_listings = '';
                        $marker = trailingslashit(get_template_directory_uri()) . 'images/map-loacation.png';
                        if (isset($nokri['map_marker_img']['url']) && $nokri['map_marker_img']['url'] != "") {
                            $marker1 = array($nokri['map_marker_img']['url']);
                            $marker = $marker1[0];
                        }
                        if ($results->have_posts()) {
                            $map_listings = '<script>var addressPoints = [';
                            $html = '';
                            while ($results->have_posts()) {
                                $results->the_post();
                                $pid = get_the_ID();
                                $author_id = get_post_field('post_author', $pid);
                                $jobs = new jobs();
                                $job_type = wp_get_post_terms($pid, 'job_type', array("fields" => "ids"));
                                $job_type = isset($job_type[0]) ? $job_type[0] : '';
                                $ad_map_lat = get_post_meta($pid, '_job_lat', true);
                                $ad_map_long = get_post_meta($pid, '_job_long', true);
                                $ad_mapLocation = get_post_meta($pid, '_job_address', true);
                                echo '' . $jobs->nokri_search_layout_list_3($pid);
                                $replace_title = stripslashes_deep(wp_strip_all_tags(str_replace("|", " ", get_the_title($pid))));
                                $map_listings .= '{
                                                    "title":"' . $replace_title . '",
                                                    "job_link":"' . get_the_permalink($pid) . '",
                                                    "job_type":"' . nokri_job_post_single_taxonomies('job_type', $job_type) . '",
                                                    "job_address":"' . $ad_mapLocation . '",
                                                    "lat":"' . $ad_map_lat . '",
                                                    "lng":"' . $ad_map_long . '",
						},';
                            }
                            $map_listings .= ']; </script>';
                            /* Restore original Post Data */
                            wp_reset_postdata();
                        } else {
                            $map_listings = '<script>var addressPoints = [];</script>';
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
                                            $date = date("F j, Y, g:i a");
                                            $jooble_updated = $date;
                                            $jooble_html .= '<div class = "n-job-single ">                                  
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
                                                                        <span> <strong>Job type</strong>' . esc_html($jooble_type) . '</span>
                                                                        <span> <strong>Posted:</strong>' . esc_html($jooble_updated) . '</span>
                                                                    </li>
                                                                    <li class = "n-job-btns">
                                                                        <a href = "' . esc_url($jooble_link) . '" class = "btn n-btn-rounded " target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>
                                                                    </li>
                                                                </ul>
                                                                   <p class ="n-jooble-bottom">' . esc_html__('powered by Jooble', 'nokri') . '</p>                                                   
                                                       </div> </div>';
                                            $counter++;
                                        }
                                    }
                                    ?> 
                                    <?php echo nokri_returnEcho($jooble_html); ?>
                                </div>
                                <div class="clear-both"></div>.
                                <?php
                            }
                        }
                        ?> 
                        <!--GitHub Jobs Integration-->
                        <?php
                        $github_html = "";
                        $is_accessed = (isset($nokri['gitjob_btn']) ? $nokri['gitjob_btn'] : false);
                        $jobs_limt = (isset($nokri['nokri_git_jobs_limit']) ? $nokri['nokri_git_jobs_limit'] : 5);
                        if ($is_accessed) {
                            ?>
                            <div class="n-featured-job-boxes jooble-jobs-area" >
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
                                                                        <span> <strong>Job type</strong>' . esc_html($git_jobs_type) . '</span>
                                                                        <span> <strong>Posted:</strong>' . esc_html($git_jobs_created_at) . '</span>
                                                                    </li>
                                                                    <li class = "n-job-btns">
                                                                        <a href = "' . esc_url($git_jobs_url) . '" class = "btn n-btn-rounded " target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>
                                                                    </li>
                                                                </ul>
                                                                   <p class ="n-jooble-bottom">' . esc_html__('Found on GitHub', 'nokri') . '</p>                                                   
                                                       </div> </div>';
                                        $counter++;
                                    }
                                }
                                echo nokri_returnEcho($github_html);
                                ?></div>
                            <div class="clear-both"></div>.
                            <?php
                        }
                        ?>
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
                                }
                            }
                            echo nokri_returnEcho($careerJet_html);
                            ?>
                            <div class="clear-both"></div>.
                            <?php
                        }
                        ?>
                        <!--Getting All ReedCo Jobs-->
                        <?php
                        $reedco_html = "";
                        $counters = 0;
                        $jobs_counter = (isset($nokri['nokri_reedco_import_jobs']) ? $nokri['nokri_reedco_import_jobs'] : 5);
                        $is_allowed = (isset($nokri['reedco_jobs_api_btn']) ? $nokri['reedco_jobs_api_btn'] : false);
                        if ($is_allowed) {
                            /* Getting All ReedCo Jobs Function */
                            $all_reedco_jobs = nokri_get_reedco_jobs();
                            if (is_array($all_reedco_jobs) && !empty($all_reedco_jobs)) {
                                foreach ($all_reedco_jobs as $reedco_jobs) {
                                    if (is_array($reedco_jobs) && !empty($reedco_jobs)) {
                                        foreach ($reedco_jobs as $reedco_job) {
                                            if ($counters >= $jobs_counter) {
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
                                            //$postDate = human_time_diff(strtotime($postDate), current_time('timestamp')) . ' ' . esc_html__('ago', 'nokri');
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
                                                                        <span> <strong>' . esc_html__('Posted', 'nokri') . '</strong>' . esc_html($postDate) . '</span>
                                                                        <span> <strong>' . esc_html__('Expiry', 'nokri') . '</strong>' . esc_html($expirationDate) . '</span>
                                                                        <span> <strong>' . esc_html__('Minimum Salary', 'nokri') . '</strong>' . esc_html($minimumSalary) . '</span>
                                                                        <span> <strong>' . esc_html__('Currency', 'nokri') . '</strong>' . esc_html($currency) . '</span>
                                                                    </li>
                                                                    <li class = "n-job-btns">
                                                                        <a href = "' . esc_url($jobUrl) . '" class = "btn n-btn-rounded " target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>
                                                                    </li>
                                                                </ul>
                                                                   <p class ="n-jooble-bottom">' . esc_html__('Found on ReedCo', 'nokri') . '</p>                                                   
                                                       </div> </div>';
                                            $counters++;
                                        }
                                    }
                                    echo nokri_returnEcho($reedco_html);
                                    ?>
                                    <div class="clear-both"></div>
                                    <?php
                                }
                            }
                        }
                        ?>                           
                        <!--Getting All Adzuna TotalJobs-->
                        <?php
                        $adzuna_html = "";
                        $is_accessedd = (isset($nokri['adzunajobs_btn']) ? $nokri['adzunajobs_btn'] : false);
                        $jobs_limts = (isset($nokri['nokri_adzuna_jobs_limit']) ? $nokri['nokri_adzuna_jobs_limit'] : 5);
                        if ($is_accessedd == true) {
                            ?>
                            <div class="n-featured-job-boxes jooble-jobs-area" >
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
                                                                                        <span><i class = "ti-location-pin"></i> <a href = "' . esc_url($adzujobs_url) . '">' . esc_html($adzujobs_city) . '</a></span><span><i class = "ti-tag"></i> <a href = "' . esc_url($adzujobs_url) . '">' . esc_html($adzujobs_title) . '</a></span>
                                                                                    </p>

                                                                                </li>
                                                                                <li class = "n-job-short">
                                                                                    <span> <strong>' . esc_html__('Posted', 'nokri') . '</strong>' . esc_html($adzujobs_created) . '</span>
                                                                                    <span> <strong>' . esc_html__('Minimum Salary', 'nokri') . '</strong>' . esc_html($adzujobs_salary_min) . '</span>
                                                                                    
                                                                                </li>
                                                                                <li class = "n-job-btns">
                                                                                    <a href = "' . esc_url($adzujobs_url) . '" class = "btn n-btn-rounded " target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>
                                                                                </li>
                                                                            </ul>
                                                                               <p class ="n-jooble-bottom">' . esc_html__('By Adzuna TotalJobs', 'nokri') . '</p>                                                   
                                                                   </div> </div>';
                                        $counter++;
                                    }
                                }
                                echo nokri_returnEcho($adzuna_html);
                                ?></div>
                            <div class="clear-both"></div>
                            <?php
                        }
                        ?> 
                        <!-- Remotive Jobs Integration API -->
                        <?php
                        $remotive_html = "";
                        $remotive_api_btn = isset($nokri['remotive_api_btn']) ? $nokri['remotive_api_btn'] : false;
                        if ($remotive_api_btn) {
                            ?>
                            <div class="n-featured-job-boxes jooble-jobs-area" >
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
                                        $remotive_html .= '<div class = "n-job-single ">                                  
                                                                        <div class = "n-job-detail">
                                                                            <ul class = "list-inline">
                                                                                <li class = "n-job-title-box">
                                                                                    <h4><a href = "' . esc_url($remotive_link) . '">' . esc_html($remotive_title) . '</a></h4>
                                                                                    <p class = "company-name"><a href = "' . esc_url($remotive_link) . '" class = "">' . esc_html($remotive_company_name) . '</a></p>
                                                                                    <p>
                                                                                        <span><i class = "ti-location-pin"></i> <a href = "' . esc_url($remotive_link) . '">' . esc_html($candidate_required_location) . '</a></span><span><i class = "ti-tag"></i> <a href = "' . esc_url($remotive_link) . '">' . esc_html($remotive_category) . '</a></span>
                                                                                    </p>

                                                                                </li>
                                                                                <li class = "n-job-short">
                                                                                    <span> <strong>' . esc_html__('Posted', 'nokri') . '</strong>' . esc_html($remotive_publication_date) . '</span>
                                                                                    <span> <strong>' . esc_html__('Salary', 'nokri') . '</strong>' . esc_html($remotive_salary) . '</span>
                                                                                    
                                                                                </li>
                                                                                <li class = "n-job-btns">
                                                                                    <a href = "' . esc_url($remotive_link) . '" class = "btn n-btn-rounded " target ="_blank">' . esc_html__('Apply now', 'nokri') . '</a>
                                                                                </li>
                                                                            </ul>
                                                                               <p class ="n-jooble-bottom">' . esc_html__('By Remotive Jobs', 'nokri') . '</p>                                                   
                                                                   </div> </div>';
                                    }
                                }

                                echo '' . ($remotive_html);
                                ?></div>
                            <div class="clear-both"></div>

                        <?php } ?>


                        <div class = "n-featured-job-boxes"  id="jobs_container"></div>
                        <div class="clearfix"></div>
                        <?php echo '' . ($advert_down); ?>
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
    <div class="right-part">
        <div class="map" id="mapid"></div>
    </div>
</div>
<?php echo '' . $map_listings; ?>
<script>

    jQuery(window).load(function () {
        var ps = new PerfectScrollbar('.side-filters');
        var ps = new PerfectScrollbar('.side-listings');
    });

    var map = L.map('mapid').setView([<?php echo '' . $lat; ?>, <?php echo '' . $long; ?>], 12);
    L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(map);
    var myIcon = L.icon({
        iconUrl: '<?php echo '' . $marker; ?>',
        iconRetinaUrl: '<?php echo '' . $marker; ?>',
        iconSize: [64, 64],
        iconAnchor: [28, 21],
        popupAnchor: [0, -22]
    });
    var markerClusters = L.markerClusterGroup();
    for (var i = 0; i < addressPoints.length; ++i)
    {

        var popup = '<div class="on-map-jobs"><div class="n-job-single"><div class="n-job-detail"><ul class="list-inline"><li class="n-job-title-box"><h4><a href="' + addressPoints[i].job_link + '">' + addressPoints[i].title + '</a><span>' + addressPoints[i].job_type + '</span></h4><p><i class="ti-location-pin"></i>' + addressPoints[i].job_address + '</p></li></ul></div></div></div>';


        var m = L.marker([addressPoints[i].lat, addressPoints[i].lng], {icon: myIcon})
                .bindPopup(popup);

        markerClusters.addLayer(m);
        map.fitBounds(markerClusters.getBounds());
        map.addLayer(markerClusters);
    }
    map.addLayer(markerClusters);
</script>