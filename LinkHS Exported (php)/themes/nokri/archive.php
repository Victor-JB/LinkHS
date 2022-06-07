<?php

get_header();
global $nokri;
$current_category = get_queried_object();
if (empty($current_category)) {
    get_template_part('template-parts/archives/blog', 'archive');
} else {
    $current_category_name = isset($current_category->taxonomy) ? $current_category->taxonomy : '';
    $term_id = isset($current_category->term_id) ? $current_category->term_id : '';
    $taxonomies = array('job_category', 'job_tags', 'job_type', 'job_qualifications', 'job_level', 'job_salary', 'job_salary_type', 'job_skills', 'job_experience', 'job_currency', 'job_shift', 'job_class', 'ad_location');
    if (in_array($current_category_name, $taxonomies)) {
        if (isset($nokri['sb_search_page'])) {
            if (isset($nokri['cat_and_location']) && $nokri['cat_and_location'] != '') {
                $type = $nokri['cat_and_location'];
            }
            /* Search page check */
            if ($type == 'search') {
                if ($current_category_name == 'job_category') {
                    wp_redirect(get_the_permalink($nokri['sb_search_page']) . '?cat-id=' . $term_id);
                } else if ($current_category_name == 'ad_location') {
                    wp_redirect(get_the_permalink($nokri['sb_search_page']) . '?job-location=' . $term_id);
                } else {
                    wp_redirect(get_the_permalink($nokri['sb_search_page']) . '?' . $current_category_name . '=' . $term_id);
                }
            } else {
                get_template_part('template-parts/archives/job', 'archive');
            }
        }
    } else {
        get_template_part('template-parts/archives/blog', 'archive');
    }
}
get_footer();
