<?php
global $nokri;
/* Title*/
$description = isset($nokri['subscribe_description']) ? '<p>'.$nokri['subscribe_description'].'</p>': '';
/*Description*/
$subscribe_text = isset($nokri['subscribe_text']) ? '<div class="n-ltr-style">'.$nokri['subscribe_text'].'</div>': '';
/*logo*/ 
$footerlogo  = nokri_footer_logo();
/*logo below text*/
$logo_below_text = isset($nokri['logo_below_text']) ? '<p>'.$nokri['logo_below_text'].'</p>' : '';
/*Is home page */
$class_content = '';
if(!is_front_page())
{    
	$class_content = 'n-newsleter-content2';
} 
/* Full footer switch */
if((isset($nokri['footer_full'])) && $nokri['footer_full'] == 1) { ?>
<section class="n-footer-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-12  <?php echo esc_attr($class_content); ?>">
          <div class="n-newsleter-content">
              <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
                <div class="n-newletter">
                  <?php echo ''.$subscribe_text." ".$description; ?>
                </div>
              </div>
              <div class="col-lg-6 col-xs-12 col-sm-6 col-md-6">
                <div class="input-group">
                  <form onSubmit="return checkVals();">
                     <div class="form-group">       
                     <input name="sb_email" class="form-control" id="sb_email" placeholder="<?php echo esc_html__('Enter Email','nokri'); ?> " type="text" autocomplete="off" required>
                     </div>
                     <span class="input-group-btn">
                     <button id="save_email" type="button" type="submit" class="btn n-btn-flat"><i class="fa fa-long-arrow-right"></i></button>
                     <input class="btn n-btn-flat btn-block no-display" id="processing_req" value="" type="button">
                     <input type="hidden" id="sb_action" value="footer_action" />
                     </span>
                    </form> 
                  </div>
              </div>
          </div>
  </div>
    </div>
  </div>
  <div class="container">
    <div class="row gta">
      <div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
      <div class="n-footer-links">
          <?php echo nokri_footer_input_texts('job_locations_links_text','','h4',''); ?>
          <ul>
            <?php echo nokri_footer_job_taxonomies_links('ad_location','job_locations_links','job-location'); ?>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
        <div class="n-footer-details"> 
		 <?php echo ''.($footerlogo)." ".$logo_below_text." ".nokri_social_footer_sorter(''); ?>
        </div>
      </div>
      <div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
        <div class="n-footer-links">
          <?php echo nokri_footer_input_texts('footer_hot_links','','h4',''); ?>
          <ul>
            <?php echo nokri_foot_hot_links_blend(); ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
<?php if((isset($nokri['footer_copy_rights_section'])) && $nokri['footer_copy_rights_section'] == 1) { ?>
  <div class="n-footer-bar">
  <?php $ft_last = isset($nokri['footer_last_section']) ? $nokri['footer_last_section']:  esc_html__("All rights reserved. ScriptsBundle", "nokri");
		 $ft_last_name = isset($nokri['footer_last_name']) ? $nokri['footer_last_name']:  esc_html__("ScriptsBundle", "nokri");
		 $ft_last_link = isset($nokri['footer_last_link']) ? $nokri['footer_last_link']:  esc_html__("#", "nokri"); ?>
  <p><?php echo ''.($ft_last); ?> <a href="<?php echo esc_url($ft_last_link); ?>" target="_blank"> <?php echo ''.($ft_last_name); ?> </a></p>
  </div>
</section>
<?php } }