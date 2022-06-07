<?php global $nokri;
$bg_url = '';
if ( isset( $nokri['footer_bg_img'] ) )
{
	$bg_url = nokri_getBGStyle('footer_bg_img');
}
/* Hot Links text */
$foot_hot_links = isset($nokri['footer_hot_links']) ? '<h4>'.$nokri['footer_hot_links'].'</h4>': '';
/* App section title */
$app_section_title = isset($nokri['footer_hot_links4']) ? '<h4>'.$nokri['footer_hot_links4'].'</h4>': '<h4>' .esc_html__("Hot Links", "nokri").'</h4>';
/* Job location text */
$job_location_text = isset($nokri['job_locations_links_text']) ? '<h4>'.$nokri['job_locations_links_text'].'</h4>':  '<h4>'.esc_html__("Job Locations", "nokri").'</h4>';
/* App store title*/
$app_section_title = isset($nokri['app_section_title']) ? '<h4>'.$nokri['app_section_title'].'</h4>':  '';
/* play store tagline */
$play_store_tagline = isset($nokri['play_store_tagline']) ? '<small>'.$nokri['play_store_tagline'].'</small>':  '';
/* play store heading */
$play_store_heading = isset($nokri['play_store_heading']) ? '<h5>'.$nokri['play_store_heading'].'</h5>':  '';
/* play store link */
$play_store_link = isset($nokri['play_store_link']) ? $nokri['play_store_link'] :  '';
/* app store tagline */
$apple_store_tagline = isset($nokri['apple_store_tagline']) ? '<small>'.$nokri['apple_store_tagline'].'</small>':  '';
/* app store tagline */
$apple_store_heading = isset($nokri['apple_store_heading']) ? '<h5>'.$nokri['apple_store_heading'].'</h5>':  '';
/* app store link */
$apple_store_link = isset($nokri['apple_store_link']) ? $nokri['apple_store_link'] :  '';
/* is show app section */
$is_show_app_section = isset($nokri['is_show_app_section']) ? $nokri['is_show_app_section'] :  '';
$app_section_col = '<div class="col-sm-10 col-md-9 col-lg-9 col-xs-12 no-app-section">';
if($is_show_app_section)
{
	$app_section_col = '<div class="col-sm-6 col-md-5 col-lg-5 col-xs-12">';
}
/* Full footer switch */
if((isset($nokri['footer_full'])) && $nokri['footer_full'] == 1)
{
?>
<section class="n-footer-transparent footer-two" <?php echo nokri_returnEcho($bg_url); ?>>
         <div class="container">
            <div class="row">
               <div class="col-lg-3 col-sm-3 col-md-2 col-xs-12">
                  <div class="n-footer-block">
                   <?php
					$footerlogo = '';
					if( isset( $nokri['footer_bg']['url'] ) && $nokri['footer_bg']['url'] != "" )
					{
					$logo = ( $nokri['footer_bg']['url'] ); 
					$footerlogo = '<img class="img-responsive footer-logo" src="'.$logo.'"  alt="'.esc_attr__("logo", "nokri").'" >';
					}
					else {
					$footerlogo = '<img class="img-responsive footer-logo" src="'.get_template_directory_uri().'/images/logo-white.png" alt="'.esc_attr__("logo", "nokri").'" >';
					}
					echo ''.($footerlogo). nokri_social_footer_sorter('n-social-bar'); ?>
                  </div>
               </div>
               <?php echo ''.$app_section_col; ?>
                  <div class="n-footer-block">
                     <?php echo ''.($job_location_text); ?>
                     <ul class="n-page-links multiple">
                        <?php echo nokri_footer_job_locations_links_blend(); ?>
                     </ul>
                  </div>
               </div>
               <?php if ($is_show_app_section) { ?>
               <div class="col-sm-4 col-md-4 col-lg-4 col-xs-12">
                  <div class="n-footer-block">
                    
                  <?php echo ''.($app_section_title); ?>
                        <?php if($play_store_link != ""){ ?>
                  	<div class="n-app-btn">
                    	<a href="<?php echo ''.($play_store_link); ?>" target="_blank">
                            <div class="icon">
                                <i class="fa fa-play"></i>
                            </div>
                            <div class="n-icon-text">
                                <?php echo ''.($play_store_tagline).($play_store_heading); ?>
                            </div>
                        </a>
                    </div>                
                      <?php } if($apple_store_link != ""){   ?>
                    <div class="n-app-btn">                                            
                    	<a href="<?php echo ''.($apple_store_link); ?>" target="_blank">
                            <div class="icon">
                                <i class="fa fa-apple"></i>
                            </div>
                            <div class="n-icon-text">
                               <?php echo ''.($apple_store_tagline).($apple_store_heading); ?>
                            </div>
                        </a>
                    </div>
                      <?php } ?>
                </div>
               </div>
               <?php } ?>
            </div>
         </div>
         <?php if((isset($nokri['footer_copy_rights_section'])) && $nokri['footer_copy_rights_section'] == 1 ) { ?>
         <div class="n-footer-bottom">
            <div class="container">
               <div class="row">
               <?php
				 $ft_last = isset($nokri['footer_last_section']) ? $nokri['footer_last_section']:  esc_html__("All rights reserved. ScriptsBundle", "nokri");
				 $ft_last_name = isset($nokri['footer_last_name']) ? $nokri['footer_last_name']:  esc_html__("ScriptsBundle", "nokri");
				 $ft_last_link = isset($nokri['footer_last_link']) ? $nokri['footer_last_link']:  esc_html__("#", "nokri"); ?>
                  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                     <p><?php echo esc_html($ft_last); ?> <a href="<?php echo esc_url($ft_last_link); ?>" target="_blank"> <?php echo esc_html($ft_last_name); ?> </a></p>
                  </div>
               </div>
            </div>
         </div>
         <?php }    ?>
      </section>    
<?php }