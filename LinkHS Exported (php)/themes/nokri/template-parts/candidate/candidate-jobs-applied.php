<?php
global $nokri;
$current_id = get_current_user_id();
$candidate = get_user_meta($current_id, '_sb_reg_type', true);
/* All Job Page */
$all_jobs = '';
if ((isset($nokri['sb_all_job_page'])) && $nokri['sb_all_job_page'] != '') {
    $all_jobs = ($nokri['sb_all_job_page']);
}
$job_name = '';
if (isset($_GET['job_name'])) {
    $job_name = $_GET['job_name'];
}
?>
<div class="main-body">
    <div class="cp-loader"></div>
    <div class="dashboard-job-stats">
        <div class="dashboard-job-filters">
            <div class="row">
                <div class="col-md-7 col-xs-12 col-sm-6">
                    <h4><?php echo esc_html__('Your applied jobs', 'nokri'); ?></h4>
                </div>
                <div class="col-md-5 col-xs-12 col-sm-4">
                    <div class="form-group">
                        <form role="search"  id="job_search" method="get" class="searchform ">
                            <input type="hidden" name="candidate-page" value="jobs-applied" >
                            <input type="text" class="form-control" name="job_name" value="<?php echo esc_html($job_name); ?>" placeholder="<?php echo esc_html__('Keyword or name', 'nokri'); ?>">
                            <a href="javascript:void(0)" class="a-btn no-top search_aplied_job"><i class="ti-search"></i></a>
                            <?php echo nokri_form_lang_field_callback(true); ?>
                        </form>
                    </div>
                </div>  
            </div>
        </div>
        <div class="dashboard-posted-jobs">
            <div class="posted-job-list jobs-saved header-title">
                <ul class="list-inline">

                    <li class="posted-job-title"><?php echo esc_html__('Title', 'nokri'); ?></li>
                    <li class="posted-job-status"><?php echo esc_html__('Status', 'nokri'); ?></li>            
                    <li class="posted-job-status"><?php echo esc_html__('Type', 'nokri'); ?></li>
                    <li class="posted-job-expiration"><?php echo esc_html__('Applied on', 'nokri'); ?></li>
                    <li class="posted-job-expiration"><?php echo esc_html__('Detail ', 'nokri'); ?></li>
                </ul>
            </div>
            <?php
//pagination
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => 'job_post',
                's' => $job_name,
                'paged' => $paged,
                'posts_per_page' => get_option('posts_per_page'),
                'meta_key' => '_job_applied_date_' . $current_id,
                'orderby' => 'meta_value',
                'order' => 'date',
                'meta_query' => array(
                    'relation' => 'AND',
                    array('key' => '_job_applied_resume_' . $current_id),
                    array(
                        'key' => '_job_status',
                        'value' => 'active',
                        'compare' => '='
                    ),
                ),
            );
            $args = nokri_wpml_show_all_posts_callback($args);
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                $count = 1;
                while ($query->have_posts()) {
                    $query->the_post();
                    $query->post_author;
                    $job_id = get_the_id();
                    $post_author_id = get_post_field('post_author', $job_id);
                    $company_name = get_the_author_meta('display_name', $post_author_id);
                    $job_type = wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
                    $job_type = isset($job_type[0]) ? $job_type[0] : '';
                    $job_salary = wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
                    $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
                    $job_currency = wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
                    $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
                    $job_salary_type = wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
                    $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
                    $job_date = get_post_meta($job_id, '_job_applied_date_' . $current_id, true);
                    $job_date = date_i18n(get_option('date_format'), strtotime($job_date));
                    $job_cvr = get_post_meta($job_id, '_job_applied_resume_' . $current_id, true);
                    $cand_status = get_post_meta($job_id, '_job_applied_status_' . $current_id, true);

                    $cand_final = nokri_canidate_apply_status($cand_status);
                    /* Getting Questions Answers */
                    $label_class = '';
                    if ($cand_status == '0') {
                        $label_class = 'default';
                    } elseif ($cand_status == '1') {
                        $label_class = 'info';
                    } elseif ($cand_status == '2') {
                        $label_class = 'danger';
                    } elseif ($cand_status == '3') {
                        $label_class = 'primary';
                    } elseif ($cand_status == '4') {
                        $label_class = 'warning';
                    } elseif ($cand_status == '5') {
                        $label_class = 'success';
                    }

                    /* Getting Company  Profile Photo */
                    $image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                    if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
                        $image_link = array($nokri['nokri_user_dp']['url']);
                    }
                    if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
                        $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
                        $image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
                    }
                    ?>
                    <div class="posted-job-list jobs-saved">
                        <ul class="list-inline">

                            <li class="posted-job-title">
                                <?php if (esc_url($image_link[0])) { ?>
                                    <div class="posted-job-title-img">
                                        <a href="javascript:void(0)"><img src="<?php echo esc_url($image_link[0]); ?>" class="img-responsive" alt="<?php echo esc_html__('micheal', 'nokri'); ?>"></a>
                                    </div>
                                <?php } ?> 
                                <div class="posted-job-title-meta">
                                    <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?> </a>
                                    <p><?php echo esc_html($company_name); ?></p>
                                </div>
                            </li>
                            <li class="posted-job-status"> <span class="label label-<?php echo esc_attr($label_class); ?>"><?php echo esc_html($cand_final); ?></span></li>
                            <li class="posted-job-status"> <span class="label label-default"><?php echo nokri_job_post_single_taxonomies('job_type', $job_type); ?></span></li>
                            <li class="posted-job-expiration"><?php echo esc_attr($job_date); ?></li>
                            <li class="posted-job-action"> 
                                <a href="javascript:void(0)" class="btn btn-custom view_app" data-value = "<?php echo esc_attr($job_id); ?>" data-toggle="modal"   data-target="#appmodel"><?php echo esc_html__('Details', 'nokri'); ?></a>
                            </li>
                        </ul>
                    </div>	
                    <?php
                    $count++;
                }
            } else {
                ?>
                <div class="dashboard-posted-jobs">
                    <div class="notification-box">
                        <div class="notification-box-icon"><span class="ti-info-alt"></span></div>
                        <h4><?php echo esc_html__('You have not applied for any job yet', 'nokri'); ?></h4>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="pagination-box clearfix">
<?php echo nokri_job_pagination($query); ?>
        </div>