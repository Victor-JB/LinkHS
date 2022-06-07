<?php
get_header();
global $nokri;
/* Selecting Single Job Style  */
$style = '1';
if ((isset($nokri['job_post_style'])) && $nokri['job_post_style'] != '') {
    $style = $nokri['job_post_style'];
}

if (have_posts()) {
    while (have_posts()) {
        the_post();
        $job_id = get_the_ID();
        get_template_part('template-parts/layouts/job-style/style', $style);
    }
} else {
    get_template_part('template-parts/content', 'none');
}
?>
<div class="cp-loader"></div>
<?php
get_footer();
