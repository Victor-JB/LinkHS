<?php function sb_load_bread_bg() {

    ?>
<style type="text/css">
<?php 
	
	if( $rane_theme['sb_bread_crumb']['url'] != "" )
	{

?>
	.breadcrumbs-area
	{
		background: url("<?php echo esc_url( $rane_theme['sb_bread_crumb']['url'] ); ?>") no-repeat scroll !important;
		background-size: cover !important;
	}
	<?php
	}
	if( $rane_theme['sb_bread_crumb_shop']['url'] != "" )
	{

	?>
	.shop_bg_para
	{
		background: url("<?php echo esc_url( $rane_theme['sb_bread_crumb_shop']['url'] ); ?>") no-repeat scroll !important;
		background-size: cover !important;
	}
	
	<?php
	}
	if( $rane_theme['sb_bread_crumb_project']['url'] != "" )
	{
	?>
	.project_bg_para
	{
		background: url("<?php echo esc_url( $rane_theme['sb_bread_crumb_project']['url'] ); ?>") no-repeat scroll !important;
		background-size: cover !important;
	}
	<?php
	}
	if( $rane_theme['footer_bg']['url'] != "" )
	{
	?>
.footer-area
{
    background-color: #191919;
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    color: #c9c9c9;
    background-image: url("<?php echo esc_url( $rane_theme['footer_bg']['url'] ); ?>");
    font-family: "Source Sans Pro", sans-serif;
    position: relative;
}
	<?php
	}
	if( $rane_theme['sb_comming_soon_bg']['url'] != "" )
	{
	?>
	
.maintenance-page {
    background: rgba(0, 0, 0, 0) url("<?php echo esc_url( $rane_theme['sb_comming_soon_bg']['url'] ); ?>") no-repeat center center;
    background-size: cover;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    position: relative;
}
<?php
	}
?>
</style>
    <?php
}
add_action( 'wp_footer', 'sb_load_bread_bg' , "100" );

?>