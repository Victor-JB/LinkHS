<?php
get_header();

global $nokri;

if (post_password_required()) {
    echo get_the_password_form();
} else {
    $user_id = get_current_user_id();
    /* Sigin Page */
    $signin_page = '';
    if ((isset($nokri['sb_sign_in_page'])) && $nokri['sb_sign_in_page'] != '') {
        $signin_page = ($nokri['sb_sign_in_page']);
    }
    /* package Page */
    $package_page = '';
    if ((isset($nokri['package_page'])) && $nokri['package_page'] != '') {
        $package_page = ($nokri['package_page']);
    }
    /* Candidate search mode */
    if (isset($nokri['cand_search_mode']) && $nokri['cand_search_mode'] == "2") {
        if (!is_user_logged_in()) {
            echo nokri_redirect(get_the_permalink($signin_page));
        }
    }
    /* search section bg */
    $list_bg_url = '';
    if (isset($nokri['candidate_list_bg_img'])) {
        $list_bg_url = nokri_getBGStyle('candidate_list_bg_img');
    }
    /* Template Name: Candidates */
    $title = '';
    if (isset($_GET['cand_title']) && $_GET['cand_title'] != "") {
        $title = $_GET['cand_title'];
    }
    $level = '';
    if (isset($_GET['cand_level']) && $_GET['cand_level'] != "") {
        $level = $_GET['cand_level'];
    }
    $skills = '';
    if (isset($_GET['cand_skills']) && $_GET['cand_skills'] != "") {
        $skills = $_GET['cand_skills'];
    }

    $type_qry = '';
    if (isset($_GET['cand_type']) && $_GET['cand_type'] != "") {
        $type_qry = array(
            'key' => '_cand_type',
            'value' => $_GET['cand_type'],
            'compare' => '='
        );
    }

    $level_qry = '';
    if (isset($_GET['cand_level']) && $_GET['cand_level'] != "") {
        $level_qry = array(
            'key' => '_cand_level',
            'value' => $_GET['cand_level'],
            'compare' => '='
        );
    }

    $skills_qry = '';
    if (isset($_GET['cand_skills']) && $_GET['cand_skills'] != "") {
        $skills_qry = array(
            'key' => '_cand_skills',
            'value' => $_GET['cand_skills'],
            'compare' => 'like'
        );
    }
    $experience_qry = '';
    if (isset($_GET['cand_experience']) && $_GET['cand_experience'] != "") {
        $experience_qry = array(
            'key' => '_cand_experience',
            'value' => $_GET['cand_experience'],
            'compare' => '='
        );
    }
    $salary_qry = '';
    if (isset($_GET['cand-salary']) && $_GET['cand-salary'] != "") {
        $salary_qry = array(
            'key' => '_cand_salary_range',
            'value' => $_GET['cand-salary'],
            'compare' => '='
        );
    }
    $salary_type_qry = '';
    if (isset($_GET['cand-salary-type']) && $_GET['cand-salary-type'] != "") {
        $salary_type_qry = array(
            'key' => '_cand_salary_type',
            'value' => $_GET['cand-salary-type'],
            'compare' => '='
        );
    }
    $salary_type_curren = '';
    if (isset($_GET['cand-salary-currency']) && $_GET['cand-salary-currency'] != "") {
        $salary_type_curren = array(
            'key' => '_cand_salary_curren',
            'value' => $_GET['cand-salary-currency'],
            'compare' => '='
        );
    }
    $location_qry = '';
    if (isset($_GET['job-location']) && $_GET['job-location'] != "") {
        $location_qry = array(
            'key' => '_cand_custom_location',
            'value' => $_GET['job-location'],
            'compare' => 'like'
        );
    }

    $headline_qry = '';
    if (isset($_GET['cand-headline']) && $_GET['cand-headline'] != "") {
        $headline_qry = array(
            'key' => '_user_headline',
            'value' => $_GET['cand-headline'],
            'compare' => 'like'
        );
    }
    $gender_qry = '';
    if (isset($_GET['cand-gender']) && $_GET['cand-gender'] != "") {
        $gender_qry = array(
            'key' => '_cand_gender',
            'value' => $_GET['cand-gender'],
            'compare' => '='
        );
    }
    $qualification_qry = '';
    if (isset($_GET['cand-qualification']) && $_GET['cand-qualification'] != "") {
        $qualification_qry = array(
            'key' => '_cand_qualification',
            'value' => $_GET['cand-qualification'],
            'compare' => '='
        );
    }
    $cands_qry = array(
        'key' => '_sb_reg_type',
        'value' => '0',
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
// total no of User to display
    $limit = isset($nokri['user_pagination']) ? $nokri['user_pagination'] : 10;
    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $offset = ($page * $limit) - $limit;
// Query args
    $args = array(
        'search' => "" . esc_attr($title) . "*",
        'order' => $order,
        'orderby' => array(
            $orderby,
            'registered',
        ),
        'number' => $limit,
        'offset' => $offset,
        'role__in' => array('editor', 'administrator', 'subscriber'),
        'paged ' => $page,
        'meta_query' => array(
            array(
                'relation' => 'OR',
                array(
                    'key' => '_is_candidate_featured',
                    'compare' => 'NOT EXISTS'
                ),
                array(
                    'key' => '_is_candidate_featured',
                    'compare' => 'EXISTS'
                )),
            $type_qry,
            $cands_qry,
            $level_qry,
            $skills_qry,
            $salary_qry,
            $salary_type_qry,
            $salary_type_curren,
            $experience_qry,
            $location_qry,
            $headline_qry,
            $gender_qry,
            $qualification_qry
        ),
    );
// Create the WP_User_Query object
    $wp_user_query = new WP_User_Query($args);
// Get the results
    $users = $wp_user_query->get_results();
    $total_users = $wp_user_query->get_total();
    $pages_number = ceil($total_users / $limit);
    if ($total_users > 0) {
        $users_found = esc_html__("Candidates found", 'nokri') . " " . '(' . $total_users . ')';
    } else {
        $users_found = esc_html__("No candidates found", 'nokri');
    }
    /* Search allowed */
    $is_allowed = nokri_is_cand_search_allowed();


    if (!$is_allowed) {
        echo nokri_redirect(get_the_permalink($package_page));
    }
    /* Layout style */
    $style = ( isset($nokri['cand_listing_style']) && $nokri['cand_listing_style'] != "" ) ? $nokri['cand_listing_style'] : "1";
    ?>
    <section class="n-featured-candidates n-search-page"> 
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <aside class="new-sidebar">
                                <div class="heading">
                                    <h4> <?php echo esc_html__("Search Filters", 'nokri'); ?></h4> 
                                    <a href="<?php echo get_the_permalink($nokri['candidates_search_page']); ?>"><?php echo esc_html__("Clear All", 'nokri'); ?></a>
                                </div>
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <?php echo get_sidebar('candidates'); ?>
                                </div>
                            </aside>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="n-search-main">
                                <div class="n-bread-crumb">
                                    <ol class="breadcrumb">
                                        <li> <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html__("Home", 'nokri'); ?></a></li>
                                        <li class="active"><a href="javascript:void(0);" class="active"><?php echo esc_html__("Candidate Search", 'nokri'); ?></a></li>
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
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="n-company-grids">
                                                <div class="row">
                                                    <div class="n-featured-candidates-box mansi">
                                                        <?php
                                                        /* Query User results */
                                                        if (!empty($users)) {
                                                            // Loop through results
                                                            foreach ($users as $user) {
                                                                $cand_id = $user->ID;
                                                                echo nokri_candidates_get_grid_layouts($cand_id, $style);
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
            </div>
        </div>
    </section>
    <?php
}
get_footer();
