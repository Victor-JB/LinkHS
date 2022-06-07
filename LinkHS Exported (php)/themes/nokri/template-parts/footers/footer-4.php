<?php global $nokri;
$bg_url = get_template_directory_uri(). '/images/footer.png';
$footer_colour = '';
if ( isset( $nokri['footer_bg_img'] ) )
{
	$bg_url = nokri_getBGStyle('footer_bg_img');
}
/* Section description*/
$description = isset($nokri['subscribe_description']) ? '<div class="nth-footer-text"><p>'.$nokri['subscribe_description'].'</p>
            </div>': '';
/* subscribe newsletter text */
$subscribe = isset($nokri['subscribe_text4']) ? $nokri['subscribe_text4'] : '';
/* Footer Logo */
$footerlogo  = nokri_footer_logo();
/* Background Image */
$bg_img    = isset($nokri['select_footer_image']) ? $nokri['select_footer_image'] : '1';
$bg_class  = '';
if($bg_img == '2')
{ $bg_class = 'n-footer-style'; }
/* Full footer switch */
if((isset($nokri['footer_full'])) && $nokri['footer_full'] == 1)
{
?>
<section class="nth-footer-4 <?php echo esc_attr($bg_class); ?>" <?php echo nokri_returnEcho($bg_url); ?>>
    <div class="container">
        <div class="row">			
            <div class="col-lg-8 col-sm-7 col-md-7 col-xs-12">
            <div class="nth-logo-footer">
                    <?php echo ''.$footerlogo; ?>
                </div>	
            <?php echo ''.$description; ?>
        </div>
        <div class="col-lg-4 col-sm-3 col-xs-12">
            <?php echo nokri_social_footer_sorter('nth-social-icons'); ?>
        </div>
        </div>
    </div>
 <?php if((isset($nokri['footer_copy_rights_section'])) && $nokri['footer_copy_rights_section'] == 1) { ?>
    <div class="nth-footer-content">
        <div class="container">
            <div class="row">
            <?php $ft_last = isset($nokri['footer_last_section']) ? $nokri['footer_last_section']:  esc_html__("All rights reserved. ScriptsBundle", "nokri");
		 $ft_last_name = isset($nokri['footer_last_name']) ? $nokri['footer_last_name']:  esc_html__("ScriptsBundle", "nokri");
		 $ft_last_link = isset($nokri['footer_last_link']) ? $nokri['footer_last_link']:  esc_html__("#", "nokri"); ?>
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                    <div class="nth-footer-theme">
                        <p><?php echo esc_html($ft_last); ?> <a href="<?php echo esc_url($ft_last_link); ?>" target="_blank"> <?php echo esc_html($ft_last_name); ?> </a></p>
                    </div>
                </div>
                <?php if ($subscribe != '') { ?> 
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 input-style">					
                <div class="input-group">
                 <form onSubmit="return checkVals();">
                 <div class="form-group">       
                 <input name="sb_email" class="form-control" id="sb_email" placeholder="<?php echo esc_html($subscribe); ?> " type="text" autocomplete="off" required>
                 </div>
                 <span class="input-group-btn">
                 <button id="save_email" type="button" type="submit" class="btn n-btn-flat"><i class="fa fa-long-arrow-right"></i></button>
                 <input class="btn n-btn-flat btn-block no-display" id="processing_req" value="" type="button">
                 <input type="hidden" id="sb_action" value="footer_action" />
                 </span>
                </form>
                </div>					
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
     <?php } ?>
</section>
<?php }