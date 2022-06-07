<?php
$user_id = get_current_user_id();
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
/* Getting saved resumes id's */

$is_member = get_user_meta($user_id, '_sb_is_member', true);
if (isset($is_member) && $is_member != '') {
    $resumes_array = nokri_get_member_emp_saved_resumes_ids();
} else {
    $resumes_array = nokri_emp_saved_resumes_ids();
}

// total no of User to display
$limit = isset($nokri['user_pagination']) ? $nokri['user_pagination'] : 5;
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$offset = ($page * $limit) - $limit;
$user_query = new WP_User_Query(
        array(
    'include' => $resumes_array,
    'search' => "" . esc_attr($c_name) . "*",
    'number' => $limit,
    'offset' => $offset,
    'order' => $c_order,
        ));
$cand_followers = $user_query->get_results();

$pages_number = ceil($user_query->get_total() / $limit);


$company_id = $li = $follower_id = '';
/* Checking if user is a member of an Employer */
$membersPermiss = get_user_meta($user_id, 'member_permissions', true);
if (isset($is_member) && $is_member != '') {
    if (isset($membersPermiss['save_cands']) && $membersPermiss['save_cands'] != '') {
        ?>
        <div class="cp-loader"></div>
        <div class="dashboard-job-filters">
            <div class="row">
                <form method="GET" id="emp_saved_resumes_form">
                    <input type="hidden" name="tab-data" value="saved-resumes" >
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo esc_html__('Name', 'nokri'); ?></label>
                            <input type="text" value="<?php echo esc_html($c_name); ?>" <?php
                            if ($order == 'ASC') {
                                echo "selected";
                            };
                            ?> class="form-control" name="c_name" placeholder="<?php echo esc_html__('Keyword or Name', 'nokri'); ?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-sm-6">
                        <div class="form-group">
                            <label class=""><?php echo esc_html__('Sort by', 'nokri'); ?> </label>
                            <select class="js-example-basic-single emp_saved_resumes_form" name="c_order">
                                <option value=""><?php echo esc_html__('Select an option', 'nokri'); ?></option>
                                <option value="ASC" <?php
                                if ($c_order == 'ASC') {
                                    echo "selected";
                                };
                                ?>><?php echo esc_html__('ASC', 'nokri'); ?></option>
                                <option value="DESC" <?php
                                if ($c_order == 'DESC') {
                                    echo "selected";
                                };
                                ?>><?php echo esc_html__('DESC', 'nokri'); ?></option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="main-body">
            <div class="dashboard-job-stats followers">
                <h4><?php echo esc_html__('Saved Candidates', 'nokri'); ?></h4>
                <div class="dashboard-posted-jobs">
                    <div class="posted-job-list resume-on-jobs header-title">
                        <ul class="list-inline">
                            <li class="resume-id"><?php echo esc_html__('Id', 'nokri'); ?></li>
                            <li class="posted-job-title"> <?php echo esc_html__('Candidate Name', 'nokri'); ?></li>
                            <li class="posted-job-expiration"> <?php echo esc_html__('Profile Link', 'nokri'); ?></li>
                            <li class="posted-job-action"><?php echo esc_html__(' Action', 'nokri'); ?></li>
                        </ul>
                    </div>
                    <?php
                    if (isset($cand_followers) && count($cand_followers) > 0) {
                        $count = 1;
                        foreach ($cand_followers as $follower) {
                            $follower_id = $follower->ID;
                            /* Getting Followers Profile Photo */
                            $attach_dp_id = get_user_meta($follower_id, '_cand_dp', true);
                            $image_dp_link = wp_get_attachment_image_src($attach_dp_id, '');
                            $follower_img_html = '';
                            if (isset($image_dp_link[0]) && esc_url($image_dp_link[0]) != '') {
                                $follower_img_html = '<div class="posted-job-title-img">
					<a href="javascript:void(0)"><img src="' . esc_url($image_dp_link[0]) . '" class="img-responsive" alt="' . esc_html__('Image', 'nokri') . '"></a>
				</div>';
                            }
                            $headline_html = '';
                            if (get_user_meta($follower_id, '_user_headline', true) != '') {
                                $headline_html = '<p>' . get_user_meta($follower_id, '_user_headline', true) . '</p>';
                            }
                            $li .= ' <div class="posted-job-list resume-on-jobs" id="company-box-' . esc_attr($follower_id) . '">
		<ul class="list-inline">
			<li class="resume-id">' . esc_attr($count) . '</li>
			<li class="posted-job-title">
				' . $follower_img_html . '
				<div class="posted-job-title-meta">
					<a href="' . esc_url(get_author_posts_url($follower_id)) . '">' . $follower->display_name . '</a>
					' . $headline_html . '
				</div>
			</li>
			<li class="posted-job-expiration"><a href="' . esc_url(get_author_posts_url($follower_id)) . '" class="btn btn-custom"> ' . esc_html__('View Profile', 'nokri') . ' </a></li>
			<li class="posted-job-action"> 
				<a href="#" class="btn btn-custom del_saved_resume"  data-id="' . $follower_id . '"> ' . esc_html__('Remove', 'nokri') . ' </a>
			</li>
		</ul>
	</div>';
                            $count++;
                        }
                        echo "" . $li;
                        ?>  
                    </div>
                    <div class="pagination-box clearfix">
                        <ul class="pagination">
                            <?php echo nokri_user_pagination($pages_number, $page); ?> 
                        </ul>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="dashboard-posted-jobs">
                <div class="notification-box">
                    <div class="notification-box-icon"><span class="ti-info-alt"></span></div>
                    <h4><?php echo esc_html__('No saved resume found', 'nokri'); ?></h4>
                </div>
            </div>
            <?php
        }
    }
} else {
    ?>
    <div class="cp-loader"></div>
    <div class="dashboard-job-filters">
        <div class="row">
            <form method="GET" id="emp_saved_resumes_form">
                <input type="hidden" name="tab-data" value="saved-resumes" >
                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class=""><?php echo esc_html__('Name', 'nokri'); ?></label>
                        <input type="text" value="<?php echo esc_html($c_name); ?>" <?php
                        if ($order == 'ASC') {
                            echo "selected";
                        };
                        ?> class="form-control" name="c_name" placeholder="<?php echo esc_html__('Keyword or Name', 'nokri'); ?>">
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class="form-group">
                        <label class=""><?php echo esc_html__('Sort by', 'nokri'); ?> </label>
                        <select class="js-example-basic-single emp_saved_resumes_form" name="c_order">
                            <option value=""><?php echo esc_html__('Select an option', 'nokri'); ?></option>
                            <option value="ASC" <?php
                            if ($c_order == 'ASC') {
                                echo "selected";
                            };
                            ?>><?php echo esc_html__('ASC', 'nokri'); ?></option>
                            <option value="DESC" <?php
                            if ($c_order == 'DESC') {
                                echo "selected";
                            };
                            ?>><?php echo esc_html__('DESC', 'nokri'); ?></option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="main-body">
        <div class="dashboard-job-stats followers">
            <h4><?php echo esc_html__('Saved Candidates', 'nokri'); ?></h4>
            <div class="dashboard-posted-jobs">
                <div class="posted-job-list resume-on-jobs header-title">
                    <ul class="list-inline">
                        <li class="resume-id"><?php echo esc_html__('Id', 'nokri'); ?></li>
                        <li class="posted-job-title"> <?php echo esc_html__('Candidate Name', 'nokri'); ?></li>
                        <li class="posted-job-expiration"> <?php echo esc_html__('Profile Link', 'nokri'); ?></li>
                        <li class="posted-job-action"><?php echo esc_html__(' Action', 'nokri'); ?></li>
                    </ul>
                </div>
                <?php
                if (isset($cand_followers) && count($cand_followers) > 0) {
                    $count = 1;
                    foreach ($cand_followers as $follower) {
                        $follower_id = $follower->ID;
                        /* Getting Followers Profile Photo */
                        $attach_dp_id = get_user_meta($follower_id, '_cand_dp', true);
                        $image_dp_link = wp_get_attachment_image_src($attach_dp_id, '');
                        $follower_img_html = '';
                        if (isset($image_dp_link[0]) && esc_url($image_dp_link[0]) != '') {
                            $follower_img_html = '<div class="posted-job-title-img">
					<a href="javascript:void(0)"><img src="' . esc_url($image_dp_link[0]) . '" class="img-responsive" alt="' . esc_html__('Image', 'nokri') . '"></a>
				</div>';
                        }
                        $headline_html = '';
                        if (get_user_meta($follower_id, '_user_headline', true) != '') {
                            $headline_html = '<p>' . get_user_meta($follower_id, '_user_headline', true) . '</p>';
                        }
                        $li .= ' <div class="posted-job-list resume-on-jobs" id="company-box-' . esc_attr($follower_id) . '">
		<ul class="list-inline">
			<li class="resume-id">' . esc_attr($count) . '</li>
			<li class="posted-job-title">
				' . $follower_img_html . '
				<div class="posted-job-title-meta">
					<a href="' . esc_url(get_author_posts_url($follower_id)) . '">' . $follower->display_name . '</a>
					' . $headline_html . '
				</div>
			</li>
			<li class="posted-job-expiration"><a href="' . esc_url(get_author_posts_url($follower_id)) . '" class="btn btn-custom"> ' . esc_html__('View Profile', 'nokri') . ' </a></li>
			<li class="posted-job-action"> 
				<a href="#" class="btn btn-custom del_saved_resume"  data-id="' . $follower_id . '"> ' . esc_html__('Remove', 'nokri') . ' </a>
			</li>
		</ul>
	</div>';
                        $count++;
                    }
                    echo "" . $li;
                    ?>  
                </div>
                <div class="pagination-box clearfix">
                    <ul class="pagination">
                        <?php echo nokri_user_pagination($pages_number, $page); ?> 
                    </ul>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="dashboard-posted-jobs">
            <div class="notification-box">
                <div class="notification-box-icon"><span class="ti-info-alt"></span></div>
                <h4><?php echo esc_html__('No saved resume found', 'nokri'); ?></h4>
            </div>
        </div>
        <?php
    }
}
