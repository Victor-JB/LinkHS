<?php

/* Author Page */
get_header();
global $nokri;
$author_id = get_query_var('author');
$author = get_user_by('ID', $author_id);
$current_user_id = get_current_user_id();
$registered = $author->user_registered;
/* Getting User Type */
if (get_user_meta($author_id, '_sb_reg_type', true) == '1') {

    $profile_style = ( isset($nokri['emp_profile_style']) && $nokri['emp_profile_style'] != "" ) ? $nokri['emp_profile_style'] : "1";
    get_template_part('template-parts/profiles/employer', 'profile' . $profile_style);
} else {

    $resume_style = ( isset($nokri['cand_resume_style']) && $nokri['cand_resume_style'] != "" ) ? $nokri['cand_resume_style'] : "1";
    get_template_part('template-parts/profiles/candidate', 'resume' . $resume_style);
}
get_footer();
