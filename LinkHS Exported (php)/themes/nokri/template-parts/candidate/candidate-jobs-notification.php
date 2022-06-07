<?php
$user_id = get_current_user_id();
/* Candidate Job Notifiactions */
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'job_post',
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => $paged,
    'post_status' => array('publish'),
    'meta_query' => array(
        array(
            'key' => '_job_status',
            'value' => 'active',
            'compare' => '=',
        ),
    ),
    'date_query' => array(
        array(
            'after' => '5 month ago'
        )
    )
);
$args = nokri_wpml_show_all_posts_callback($args);
$query = new WP_Query($args);
$notification = '';
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $job_id = get_the_ID();
        $post_author_id = get_post_field('post_author', $job_id);
        $company_name = get_the_author_meta('display_name', $post_author_id);
        $job_skills = wp_get_post_terms($job_id, 'job_skills', array("fields" => "ids"));
        $cand_skills = get_user_meta($user_id, '_cand_skills', true);
        if (is_array($job_skills) && is_array($cand_skills)) {
            $final_array = array_intersect($job_skills, $cand_skills);
            if (count($final_array) > 0) {
                $notification .= '<li>
                                    <div class="notif-single">
                                        <a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html($company_name) . " " . '</a>' . esc_html__('Posted New Job', 'nokri') . '<a href="' . get_the_permalink($job_id) . '" class="notif-job-title">' . " " . get_the_title() . '</a>
                                    </div>
				<span class="notif-timing"><i class="icon-clock"></i>' . nokri_time_ago() . '</span>
				</li>';
            }
        }
    }
    wp_reset_postdata();
    ?>
    <div class="cp-loader"></div>
    <div class="main-body">
        <div class="notification-area">
            <h4> <?php echo esc_html__('All Jobs Suggestions', 'nokri'); ?></h4>
            <div class="notif-box">
                <ul>
                    <?php echo '' . ($notification); ?>
                </ul>
            </div>
            <div class="pagination-box clearfix">
                <?php //echo nokri_job_pagination( $query );?>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-info alert-dismissable alert-style-1">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="ti-info-alt"></i><?php echo esc_html__('You have no notification yet', 'nokri'); ?>
        </div>
        <?php
    }