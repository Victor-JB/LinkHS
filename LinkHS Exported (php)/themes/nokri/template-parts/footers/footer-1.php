<?php global $nokri;
$bg_url = get_template_directory_uri(). '/images/footer.png';
$footer_colour = '';
if ( isset( $nokri['footer_bg_img'] ) )
{
	$bg_url = nokri_getBGStyle('footer_bg_img');
}
/* subscribe newsletter text */
$subscribe = isset($nokri['subscribe_text']) ? '<h4>'.$nokri['subscribe_text'].'</h4>': '<h4>' .esc_html__("Subscribe our newsletters", "nokri").'</h4>';
/* subscribe newsletter descrition */
$subscribe_description = isset($nokri['subscribe_description']) ? '<p>'.$nokri['subscribe_description'].'</p>': '';
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
$app_section_col = '<div class="col-sm-12 col-md-7 col-lg-7 col-xs-12 no-app-section">';
if($is_show_app_section)
{
	$app_section_col = '<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">';
}
/* Is nokri frame work active */
$plugin =  true;
if ( in_array( 'nokri_framework/index.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
{
/* Full footer switch */
if((isset($nokri['footer_full'])) && $nokri['footer_full'] == 1)
{
 ?>
<section class="n-footer-transparent" <?php echo nokri_returnEcho($bg_url); ?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-md-3 col-xs-12">
                <div class="n-footer-block">
                 <?php echo ''.($subscribe); ?>
                  <div class="n-subscription-form">
                    <?php echo ''.($subscribe_description); ?>
                    <form onSubmit="return checkVals();">
                          <div class="form-group">       
                         <input name="sb_email" class="form-control" id="sb_email" placeholder="<?php echo esc_html__( 'Enter your email address', 'nokri' ); ?>" type="text" autocomplete="off" required>
                         </div>
                         <button id="save_email" type="button"> <i class="fa fa-paper-plane"></i> </button>
                         <input class="btn btn-theme btn-block no-display" id="processing_req" value="<?php echo esc_html__( 'Processing...', 'nokri' ); ?>" type="button">
                         <input type="hidden" id="sb_action" value="footer_action" />
                      </form>
                  </div>
                  <?php echo nokri_social_footer_sorter('n-social-bar'); ?>
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
            <div class="visible-sm clearfix"></div>
            <?php if ($is_show_app_section) { ?>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xs-12">
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
                      <?php  }   ?>
                </div>
            </div>
            <?php } ?>
            <div class="col-sm-6 col-md-2 col-lg-2 col-xs-12">
                <div class="n-footer-block">
                 <?php echo ''.($foot_hot_links); ?>
                  <ul class="n-page-links">
                     <?php  echo nokri_foot_hot_links_blend(); ?>
                  </ul>
                </div>
            </div>
        </div>
      </div>
      <?php if((isset($nokri['footer_copy_rights_section'])) && $nokri['footer_copy_rights_section'] == 1 &&  $nokri['select_footer_layout'] == '1' ) { ?>
    <div class="n-footer-bottom">
      <div class="container">
        <div class="row">
        <?php
		 $ft_last = isset($nokri['footer_last_section']) ? $nokri['footer_last_section']:  esc_html__("All rights reserved. ScriptsBundle", "nokri");
		 $ft_last_name = isset($nokri['footer_last_name']) ? $nokri['footer_last_name']:  esc_html__("ScriptsBundle", "nokri");
		 $ft_last_link = isset($nokri['footer_last_link']) ? $nokri['footer_last_link']:  esc_html__("#", "nokri"); ?>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <p><?php echo esc_html($ft_last); ?> <a href="<?php echo esc_url($ft_last_link); ?>" target="_blank"> <?php echo esc_html($ft_last_name); ?> </a></p>
          </div>
        </div>
      </div>
    </div>
     <?php }    ?>
  </section>
<?php }  } else { ?>
<section class="n-footer-transparent not-plugin-active" <?php echo "".($bg_url); ?>>
    <div class="n-footer-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <p> <?php echo esc_html__('Reproduction of material from scriptsBundle without permission is strictly prohibited','nokri'); ?> </p>
            <p>&copy;<?php echo date("Y").'-'.esc_html__("Nokri Job Board wordpress theme - All Rights Reserved. Made By ", "nokri"); ?> <a href="http://themeforest.net/user/scriptsbundle"> ScriptsBundle </a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php }