<?php
/* Template Name: Candidate Resume */ 
$cand_skills = $skill_tags =  $portfolio_html = '';
get_header();
global $nokri;
if( isset( $_GET['cid'] ) && $_GET['cid'] != "" )
{
	 $user_crnt_id	=	$_GET['cid'];
}
else 
{
	$user_crnt_id = get_current_user_id();
}
$user_info  =        wp_get_current_user();
$registered =        $user_info->user_registered;
/* Getting User Skills Tags */
$cand_skills	= get_user_meta($user_crnt_id, '_cand_skills', true);
if($cand_skills != '') 
  {
	$taxonomies = get_terms('job_skills', array('hide_empty' => false , 'orderby'=> 'id', 'order' => 'ASC' ,  'parent'   => 0  ));
	if(count($taxonomies) > 0) {
		foreach($taxonomies as $taxonomy)
 			{
	 			if (in_array( $taxonomy->term_id, $cand_skills ))
				$skill_tags .= '<li> <i class="ti-check"></i>'.esc_html($taxonomy->name).'</li>';
 			}
		}

	}
/* Getting Candidate Dp */
$image_link[0] =  get_template_directory_uri(). '/images/candidate-dp.jpg';
if( isset( $nokri['nokri_user_dp']['url'] ) && $nokri['nokri_user_dp']['url'] != "" )
{
	$image_link = array($nokri['nokri_user_dp']['url']);	
}
if( get_user_meta($user_crnt_id, '_cand_dp', true ) != "" )
{
	$attach_id =	get_user_meta($user_crnt_id, '_cand_dp', true );
	$image_link = wp_get_attachment_image_src( $attach_id, '' );
}
/* Getting Candidate Portfolio */
if( get_user_meta( $user_crnt_id, '_cand_portfolio', true ) != "" )
 {	
	$port = get_user_meta( $user_crnt_id, '_cand_portfolio', true );
	$portfolios = explode(',', $port);
	foreach($portfolios as $portfolio)
	{	
	$portfolio_image_sm = wp_get_attachment_image_src( $portfolio, 'nokri_job_hundred' );
	$portfolio_image_lg = wp_get_attachment_image_src( $portfolio, 'nokri_cand_large' );
	$portfolio_html .= '<a data-fancybox="gallery" class="portfolio-gallery" href="'.esc_url($portfolio_image_lg[0]).'"><img src="'.esc_url($portfolio_image_sm[0]).'"></a>';	}
 }
$cand_dob = '';
$cand_dob = get_user_meta($user_crnt_id, '_cand_dob', true);
?>
<div class="col-md-4 col-sm-5 col-xs-12 col-md-push-8">
    <div class="main-profile-card">
        <div class="contact-box">
            <div class="contact-img">
                <img src="<?php echo esc_url($image_link[0]); ?>" class="img-responsive img-circle" alt="<?php echo esc_html__( 'candidate profile image', 'nokri' ); ?>">
            </div>
            <div class="contact-caption">
                <h4><?php echo esc_html($user_info->display_name); ?></h4>
                <span><?php echo  nokri_candidate_user_meta('_user_headline'); ?></span>
            </div>
            <ul class="social-links list-inline">
                <?php if(get_user_meta($user_crnt_id, '_cand_fb', true) != '') { ?>
                <li> <a href="<?php echo  esc_url(get_user_meta($user_crnt_id, '_cand_fb', true)); ?> " target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/006-facebook.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>"></a></li>
                <?php } if(get_user_meta($user_crnt_id, '_cand_twiter', true) != '') { ?>
                <li> <a href="<?php echo  esc_url(get_user_meta($user_crnt_id, '_cand_twiter', true)); ?>" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/004-twitter.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>"></a></li>
                <?php } if(get_user_meta($user_crnt_id, '_cand_google', true) != '') { ?>
                <li> <a href="<?php echo  esc_url(get_user_meta($user_crnt_id, '_cand_google', true)); ?>" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/003-google-plus.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>"></a></li>
                <?php } if(get_user_meta($user_crnt_id, '_cand_linked', true) != '') { ?>
                <li> <a href="<?php echo  esc_url(get_user_meta($user_crnt_id, '_cand_linked', true)); ?>" target="_blank"><img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/005-linkedin.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>"></a></li>
                 <?php } ?>
            </ul>
        </div>
        <div class="resume-detail">
                            <h4><?php echo esc_html__( 'Candidate Detail', 'nokri' ); ?></h4>
                            <ul>
                            <li>
                            <img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/011-calendar.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>">
                            <div class="resume-detail-meta"><small><?php echo esc_html__( 'Member Since:', 'nokri' ); ?></small> <strong><?php echo  date( "M Y", strtotime( $registered ) ) ; ?></strong></div>
                            </li>
                            	<?php if( get_user_meta($user_crnt_id, '_cand_dob', true) != '' ) { ?>
                                <li><img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/012-man.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>">
								<div class="resume-detail-meta"><small><?php echo esc_html__( 'Date of Birth:', 'nokri' ); ?></small> <strong><?php echo date_i18n(get_option('date_format'), strtotime($cand_dob)); ?></strong></div>
                                </li>
                                <?php }  if( get_user_meta($user_crnt_id, '_sb_contact', true) != '' ) {  ?>
                                <li><img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/009-phone-receiver.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>">
                                <div class="resume-detail-meta"><small><?php echo esc_html__( 'Cell No', 'nokri' ); ?></small><strong><?php echo   esc_html(get_user_meta($user_crnt_id, '_sb_contact', true)); ?></strong></div>
                                </li>
                                <?php }  ?>
                                <li><img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/008-email.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>">
                                <div class="resume-detail-meta"><small><?php echo esc_html__( 'Email Address', 'nokri' ); ?></small><strong><?php echo  esc_html($user_info->user_email); ?></strong></div>
                                </li>
                                <?php if( get_user_meta($user_crnt_id, '_cand_address', true) != '' ) {  ?>
                                <li><img src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/007-placeholder.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>">
                                <div class="resume-detail-meta"> <small><?php echo esc_html__( 'Address', 'nokri' ); ?></small><strong><?php echo  esc_html(get_user_meta($user_crnt_id, '_cand_address', true)); ?></strong></div>
                               </li>
                                <?php } ?>
                            </ul>
                        </div>
    </div>
    <?php
    if((isset($nokri['cand_contact_form'])) && $nokri['cand_contact_form']  != '' ) { ?>
    <div class="candidate-contact-form">
            <h4><?php echo esc_html__( 'Candidate Contact', 'nokri' ); ?></h4>
            <?php 
            $contact_form_input = '';
            $cand_contact_form_code =  ($nokri['cand_contact_form']);
            $shortCode 				=  nokri_clean_shortcode($cand_contact_form_code);
            $contact_form_input 	=  do_shortcode($shortCode);
            echo do_shortcode( $contact_form_input ); 
            ?>
        </div>
        <?php }  ?>
</div>
<div class="col-md-8 col-sm-7 col-xs-12 col-md-pull-4">
    <div class="main-body">
     <?php 
     /* Checking Profile Percent */
    $profile_percent = get_user_meta( $user_crnt_id, '_cand_profile_percent',  true);
    if ( $profile_percent > 20) { 
    /* Checking Education*/
     $cand_education = get_user_meta($user_crnt_id, '_cand_education', true); 
     if ( $cand_education  && $cand_education[0]['degree_name'] != '' ) {  ?>
        <div class="resume-box">
            <?php  if ( get_user_meta($user_crnt_id, '_cand_intro', true) != '') { ?>
            <h4><?php echo esc_html__( 'About Me', 'nokri' ); ?></h4>
            <p><?php echo  get_user_meta($user_crnt_id, '_cand_intro', true);?></p>
            <?php } ?>
        </div>
         <?php if(!empty($skill_tags)) { ?>
        <div class="resume-box">
    <div class="timeline-box">
    <img class="heading-icon" src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/010-skills.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>"></i>
        <h4><?php echo esc_html__( 'Skills', 'nokri' ); ?></h4>
        <ul class="skills-box list-inline">
            <?php echo "".($skill_tags); ?>
        </ul>
    </div>
  </div>
        <?php } ?>
        <div class="resume-box">
            <div class="timeline-box">
            <img class="heading-icon" src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/013-graduation-hat.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>">
                <h4><?php echo esc_html__( 'Education', 'nokri' ); ?> </h4>
                <ul class="education">
                                <?php
               foreach($cand_education as $edu) { 
		       $degre_name		= (isset($edu['degree_name']))       ?  '<div class="lead">'.esc_html($edu['degree_name']).'<div>' :   '';
			   $degre_strt		= (isset($edu['degree_start']))      ?  $edu['degree_start'] :   '';
			   $degre_insti	    = (isset($edu['degree_institute']))  ?  '<div class="type ">'.esc_html($edu['degree_institute']).'</div>'   :   '';
			  $degre_details	  = (isset($edu['degree_detail']))   ? '<p class="info">'.$edu['degree_detail'].'</p>'   :   '';
								?>
                                <li><span></span>
                                    <div>
                                      <div class="date"><?php echo esc_html($degre_strt)." "; 
                                      if($edu['degree_end'] != '') { echo '-'.esc_html($edu['degree_end']); } ?></div>
                                       <?php echo "".($degre_name).($degre_insti).($degre_details);?>
                                        </div>
                                    </li>
                                     <?php } ?>
                                </ul>
            </div>
            </div>
        <?php } 
        $cand_profession	= get_user_meta($user_crnt_id, '_cand_profession', true);
        if ( $cand_profession  && $cand_profession[0]['project_organization'] != '') { ?>
        <div class="resume-box">
            <div class="timeline-box">
            <img class="heading-icon" src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/015-google-plus.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>">
                <h4><?php echo esc_html__( 'Work Experience', 'nokri' ); ?></h4>
                <ul class="education">
                                 <?php 
                                 foreach($cand_profession as $profession) {
									 $project_end = $profession['project_end'];
									 if($profession['project_end'] == '')
									 {
										$project_end =  esc_html__( 'Currently working', 'nokri' );
									 }
$project_role	= (isset($profession['project_role'])) ? '<div class="lead">'.esc_html($profession['project_role']).'<div>' :   '';
$project_org	= (isset($profession['project_organization']))? '<div class="type ">'.$profession['project_organization'].'<div>' :   '';
$project_strt	= (isset($profession['project_start']))  ? esc_html($profession['project_start'])   :   '';
$project_detail	= (isset($profession['project_desc']))  ? '<div class="info">'.$profession['project_desc'].'</div>'   :   '';				
									  ?>
                                   <li><span></span>
                                        <div>
                                      	<div class="date"><?php echo esc_html($project_strt)." "; 
                                      if($project_end != '') { echo '-'.($project_end); } ?></div>
                                       <?php echo "".($project_role).($project_org).($project_detail);?>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
            </div>
        </div>
        <?php } 
        $cand_certifications	=  get_user_meta($user_crnt_id, '_cand_certifications', true);
        if ( $cand_certifications  && $cand_certifications[0]['certification_name'] != '') { ?>
                    <div class="resume-box">
                        <div class="timeline-box">
                        <img class="heading-icon" src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/002-medal.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>">
                            <h4><?php echo esc_html__( 'Awards and Certificates', 'nokri' ); ?></h4>
                            <ul class="education">
                                             <?php 
                                             foreach($cand_certifications as $certification) { 
                                             if ($certification['certification_name'] != '') {
												 
$certi_name	= (isset($certification['certification_name'])) ? '<div class="lead">'.esc_html($certification['certification_name']).'<div>' :   '';
$certi_durat = (isset($certification['certification_duration']))  ? '<span>'.esc_html($certification['certification_duration']).'</span>'   :   '';
$certi_inst	= (isset($certification['certification_institute']))? '<div class="type ">'.$certification['certification_institute'].$certi_durat.'<div>' :   '';
$certi_strt	= (isset($certification['certification_start']))  ? esc_html($certification['certification_start'])   :   '';
$certi_detail	= (isset($certification['certification_desc']))  ? '<div class="info">'.$certification['certification_desc'].'</div>'   :   '';
                                             ?>
                                                <li><span></span>
                                                    <div>
                                      <div class="date"><?php echo esc_attr($certi_strt)." "; 
                                      if($certification['certification_end'] != '') { echo '-'.esc_html($certification['certification_end']); } ?></div>
                                       <?php echo "".($certi_name).($degre_insti).($certi_detail);?> 
                                                    </div>
                                                </li>
                                                <?php }  } ?>
                                            </ul>
                            </div> 
                        </div>
                        <?php  } 
                        if ($portfolio_html) { ?>
                        <div class="resume-box">
                        <div class="timeline-box">
                         <img class="heading-icon" src="<?php echo get_template_directory_uri();?>/images/resume-detail-icons/portfolio.png" alt="<?php echo esc_html__( 'icon', 'nokri' ); ?>">
                        <h4><?php echo esc_html__( 'My Portfolio', 'nokri' ); ?></h4>
                        <?php echo "".$portfolio_html; ?>
                        </div>
                         </div>
                    <?php  } 
                  } else { ?>
        <div class="resume-box">
        <div class="timeline-box">
         <h4><?php echo esc_html__( 'Add your education details at least to show up your profile', 'nokri' ); ?></h4>
         </div>
         </div>
        <?php } ?>
            </div>
        </div>