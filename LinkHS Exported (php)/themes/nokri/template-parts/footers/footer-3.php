<?php global $nokri;
$bg_url = get_template_directory_uri(). '/images/footer.png';
$footer_colour = '';
if ( isset( $nokri['footer_bg_img'] ) )
{
	$bg_url = nokri_getBGStyle('footer_bg_img');
}
/* subscribe newsletter text */
$subscribe = isset($nokri['subscribe_text']) ? '<h4>'.$nokri['subscribe_text'].'</h4>': '<h4>' .esc_html__("Subscribe our newsletters", "nokri").'</h4>';
/* Hot Links text */
$foot_hot_links = isset($nokri['footer_hot_links']) ? '<h4>'.$nokri['footer_hot_links'].'</h4>': '';
/* Job location text */
$job_location_text = isset($nokri['job_locations_links_text']) ? '<h4>'.$nokri['job_locations_links_text'].'</h4>':  '<h4>'.esc_html__("Job Locations", "nokri").'</h4>';
/* Job category text */
$job_cat_text = isset($nokri['job_categories_txt']) ? '<h4>'.$nokri['job_categories_txt'].'</h4>':  '<h4>'.esc_html__("Job Category", "nokri").'</h4>';
/* Job skills text */
$job_skill_text = isset($nokri['job_skills_txt']) ? '<h4>'.$nokri['job_skills_txt'].'</h4>':  '<h4>'.esc_html__("Job Skills", "nokri").'</h4>';
/* Full footer switch */
if((isset($nokri['footer_full'])) && $nokri['footer_full'] == 1)
{
?>
<footer class="footer footer-white">
  <div class="container">
    <div class="row">
    	<?php echo nokri_footer_sorter(); ?>
    </div>
  </div>
</footer>
<?php if((isset($nokri['footer_copy_rights_section'])) && $nokri['footer_copy_rights_section'] == 1 &&  $nokri['select_footer_layout'] == '3' ) { ?>
<section class="footer-bottom-section light-grey">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="footer-bottom">
            <div class="row">
            <?php $ft_last = isset($nokri['footer_last_section']) ? $nokri['footer_last_section']:  esc_html__("All rights reserved. ScriptsBundle", "nokri");
		 $ft_last_name = isset($nokri['footer_last_name']) ? $nokri['footer_last_name']:  esc_html__("ScriptsBundle", "nokri");
		 $ft_last_link = isset($nokri['footer_last_link']) ? $nokri['footer_last_link']:  esc_html__("#", "nokri"); ?>
              <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                <p><?php echo esc_html($ft_last); ?> <a href="<?php echo esc_url($ft_last_link); ?>" target="_blank"> <?php echo esc_html($ft_last_name); ?> </a></p>
              </div>
              <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 hidden-xs hidden-sm">
                <ul class="footer-menu">
                  <?php echo nokri_footer_job_taxonomies_links('ad_location','job_locations_copy_links','job-location'); ?>
                </ul>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section> 
 <?php  } } ?>