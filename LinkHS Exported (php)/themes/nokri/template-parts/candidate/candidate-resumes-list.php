<?php
global $nokri;
$user_info = wp_get_current_user();
$user_id = get_current_user_id();
/* Getting All Resumes */
$cand_resume = get_user_meta($user_id, '_cand_resume', true);
if ($cand_resume) {
    $cand_resumes = explode(',', $cand_resume);
    $resume_table = $link = $final_url = '';
    $sr_no = '1';
    foreach ($cand_resumes as $resume) {
        $link = nokri_set_url_param(get_the_permalink($resume), 'attachment_id', esc_attr($resume));
        $final_url = esc_url(nokri_page_lang_url_callback($link));
        $resume_table .= '<div class="posted-job-list resume-on-jobs">
								<ul class="list-inline">
									<li class="resume-id">' . $sr_no . '</li>
									<li class="posted-job-title">
										<div class="posted-job-title-meta">
											<a href="javascript:void(0)">' . basename(get_attached_file($resume)) . '</a>
										</div>
									</li>
									 <li class="posted-job-expiration"> 
										<a href="' . $final_url . '&download_file=1" class="btn btn-custom ">' . esc_html__('Download', 'nokri') . '</a>
									</li>
									<li class="posted-job-action"> 
										<a  class="btn btn-custom del_my_resume" value="' . esc_attr($resume) . '" id="del_my_resume">' . esc_html__('Delete', 'nokri') . '</a>
									</li>
								</ul>
							</div>';
        $sr_no++;
    }
    ?>
    <div class="cp-loader"></div>
    <div class="main-body">
        <div class="dashboard-job-stats followers">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h4><?php echo esc_html__('Your Uploaded Resumes', 'nokri'); ?></h4>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <div class="file-upload-wrapper" data-text="<?php echo esc_html__("Click to upload", "nokri"); ?>">
                            <input name="my_cv_upload[]" type="file" class="file-upload-field upload_resume_tab" data-show-preview="false" data-show-upload="false">
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-posted-jobs">
                <div class="posted-job-list resume-on-jobs header-title">
                    <ul class="list-inline">
                        <li class="resume-id"><?php echo esc_html__('#', 'nokri'); ?></li>
                        <li class="posted-job-title"><?php echo esc_html__('Resume Name', 'nokri'); ?></li>
                        <li class="posted-job-expiration"><?php echo esc_html__('Download', 'nokri'); ?></li>
                        <li class="posted-job-action"><?php echo esc_html__('Delete', 'nokri'); ?></li>

                    </ul>
                </div>
                <?php echo "" . $resume_table; ?>
            </div>
            <div class="pagination-box clearfix">
                <ul class="pagination">
                    <?php echo nokri_blogs_pagination(); ?>
                </ul>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="main-body">
        <div class="dashboard-job-stats followers">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <h4><?php echo esc_html__('Your Uploaded Resumes', 'nokri'); ?></h4>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                        <div class="file-upload-wrapper" data-text="<?php echo esc_html__("Click to upload", "nokri"); ?>">
                            <input name="my_cv_upload[]" type="file" class="file-upload-field upload_resume_tab" data-show-preview="false" data-show-upload="false">
                        </div>
                    </div>
                </div>



            </div>
        </div>
        <div class="dashboard-posted-jobs">
            <div class="notification-box">
                <div class="notification-box-icon"><span class="ti-info-alt"></span></div>
                <h4><?php echo esc_html__('You have not uploaded any resume yet', 'nokri'); ?></h4>
            </div>
        </div>
    </div>
    <?php
}