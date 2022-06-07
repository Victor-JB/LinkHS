<?php
// Register metaboxes for Products
add_action( 'add_meta_boxes', 'sb_meta_box_post_ad_edit' );
function sb_meta_box_post_ad_edit()
{
    add_meta_box( 'sb_thmemes_ad_post_carspot_metaboxes_edit', __('Update AD','redux-framework' ), 'sb_render_meta_post_ad_edit', 'ad_post', 'normal', 'high' );
}
function sb_render_meta_post_ad_edit( $post )
{
	global $carspot_theme;
?>
<div class="margin_top">
	<h1 align="center">
    <a href="<?php echo get_the_permalink( $carspot_theme['sb_post_ad_page'] ) . '?id=' . $post->ID; ?>" target="_blank">
		<?php echo __('Update this AD','redux-framework' ); ?>
    </a>
    </h1>
    <br/>
</div>
<?php
}

// Register metaboxes for Products
add_action( 'add_meta_boxes', 'sb_meta_box_post_ad' );
function sb_meta_box_post_ad()
{
    add_meta_box( 'sb_thmemes_ad_post_carspot_metaboxes', __('Ad Type','redux-framework' ), 'sb_render_meta_post_ad', 'ad_post', 'normal', 'high' );
}
function sb_render_meta_post_ad( $post )
{
 // We'll use this nonce field later on when saving.
    wp_nonce_field( 'sb_ad_meta_box_nonce_ad_post', 'meta_box_nonce_ad_post' );
?>

<div class="margin_top">
    <select name="_carspot_is_feature" style="width:100%; height:40px;">
    	<option value="1" <?php if( get_post_meta($post->ID, "_carspot_is_feature", true) == '1' ) echo 'selected'; ?>>
			<?php echo esc_html__( 'Featured', 'redux-framework' ); ?>
		</option>
    	<option value="0" <?php if( get_post_meta($post->ID, "_carspot_is_feature", true) == '0' ) echo 'selected'; ?>>
			<?php echo esc_html__( 'Simple', 'redux-framework' ); ?>
		</option>
    </select>
</div>
<?php
}
// Saving Metabox data 
add_action( 'save_post', 'sb_themes_meta_save_ad_post' );
function sb_themes_meta_save_ad_post( $post_id )
{
  // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
// if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce_ad_post'] ) || !wp_verify_nonce( $_POST['meta_box_nonce_ad_post'], 'sb_ad_meta_box_nonce_ad_post' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
	
	// Make sure your data is set before trying to save it
    if( isset( $_POST['_carspot_is_feature'] ) )
	{
		if( $_POST['_carspot_is_feature'] == get_post_meta($post_id, "_carspot_is_feature", true) )
		{
			return;
		}
		else
		{
			update_post_meta( $post_id, '_carspot_is_feature', $_POST['_carspot_is_feature'] );
			if( $_POST['_carspot_is_feature'] == '1' )
				update_post_meta( $post_id, '_carspot_is_feature_date', date('Y-m-d'));
		}
	}
}

// Email on ad publish
add_action( 'transition_post_status', 'sb_send_mails_on_publish', 10, 3 );
function sb_send_mails_on_publish( $new_status, $old_status, $post )
{
    if ( 'publish' !== $new_status or 'publish' === $old_status
        or 'ad_post' !== get_post_type( $post ) )
        return;
		
	global $carspot_theme;
	if( isset( $carspot_theme['email_on_ad_approval'] ) && $carspot_theme['email_on_ad_approval'] )
	{
		carspot_get_notify_on_ad_approval( $post );
	}

}