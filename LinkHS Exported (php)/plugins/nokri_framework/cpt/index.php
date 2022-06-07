<?php 
// Register post  type and taxonomy
add_action( 'init', 'sb_themes_custom_types' );
function sb_themes_custom_types() {
	// Register Post type
    $args = array(
      'public' => true,
      'label'  => 'Portfolio',
	  'supports' => array( 'thumbnail', 'title', 'editor' )
    );
    register_post_type( 'project', $args );
	
	// Register taxonomy
	register_taxonomy('project_cats',array('project'), array(
    'hierarchical' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'project_cat' ),
  ));
	
	
}

// Register metaboxes
add_action( 'add_meta_boxes', 'cd_meta_box_add' );
function cd_meta_box_add()
{
    add_meta_box( 'sb_thmemes_metaboxes', 'Project Details', 'sb_render_meta', 'project', 'normal', 'high' );
}
function sb_render_meta( $post )
{
 // We'll use this nonce field later on when saving.
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
?>
<div class="margin_top">
	<input type="text" name="project_url" class="project_meta" placeholder="<?php echo crane_translate( 'project_url_heading' ); ?>" size="30" value="<?php echo esc_attr( get_post_meta($post->ID, "project_url", true) ); ?>" id="project_url" spellcheck="true" autocomplete="off">
</div>
<div class="margin_top">
	<input type="text" name="client" class="project_meta" placeholder="<?php echo crane_translate( 'project_client_heading' ); ?>" size="30" value="<?php echo esc_attr( get_post_meta($post->ID, "client", true) ); ?>" id="client" spellcheck="true" autocomplete="off">
</div>
<div class="margin_top">
	<input type="text" name="created_by" class="project_meta" placeholder="<?php echo crane_translate( 'project_created_heading' ); ?>" size="30" value="<?php echo esc_attr( get_post_meta($post->ID, "created_by", true) ); ?>" id="created_by" spellcheck="true" autocomplete="off">
</div>
<div class="margin_top">
	<input type="date" name="completed" class="project_meta" placeholder="<?php echo crane_translate( 'project_created_date_heading' ); ?>" size="30" value="<?php echo esc_attr( get_post_meta($post->ID, "completed", true) ); ?>" id="completed" spellcheck="true" autocomplete="off">
</div>
<div class="margin_top">
	<input type="text" name="skills" class="project_meta" placeholder="<?php echo crane_translate( 'project_skills_heading' ); ?>" size="30" value="<?php echo esc_attr( get_post_meta($post->ID, "skills", true) ); ?>" id="skills" spellcheck="true" autocomplete="off">
</div>

<?php
}

// Saving Metabox data 
add_action( 'save_post', 'sb_themes_meta_save' );
function sb_themes_meta_save( $post_id )
{
  // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
// if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
	
	// Make sure your data is set before trying to save it
    if( isset( $_POST['project_url'] ) )
        update_post_meta( $post_id, 'project_url', $_POST['project_url'] );
		
    if( isset( $_POST['client'] ) )
        update_post_meta( $post_id, 'client', $_POST['client'] );
		
    if( isset( $_POST['created_by'] ) )
        update_post_meta( $post_id, 'created_by', $_POST['created_by'] );
		
    if( isset( $_POST['completed'] ) )
        update_post_meta( $post_id, 'completed', $_POST['completed'] );
		
    if( isset( $_POST['skills'] ) )
        update_post_meta( $post_id, 'skills', $_POST['skills'] );
}

// Register metaboxes for Products
add_action( 'add_meta_boxes', 'sb_rane_meta_box_add' );
function sb_rane_meta_box_add()
{
    add_meta_box( 'sb_thmemes_rane_metaboxes', 'Product Ribbon', 'sb_render_meta_product', 'product', 'normal', 'high' );
}
function sb_render_meta_product( $post )
{
 // We'll use this nonce field later on when saving.
    wp_nonce_field( 'my_meta_box_nonce_product', 'meta_box_nonce_product' );
?>
<div class="margin_top">
	<input type="text" name="ribbion_text" class="project_meta" placeholder="<?php echo esc_attr__('Ribbion Text', 'sb_framework' ); ?>" size="30" value="<?php echo esc_attr( get_post_meta($post->ID, "ribbion_text", true) ); ?>" id="ribbion_text" spellcheck="true" autocomplete="off">
</div>
<div class="margin_top">
    <select name="ribbion_color" style="width:100%; height:40px;">
    	<option value="new" <?php if( get_post_meta($post->ID, "ribbion_color", true) == 'new' ) echo 'selected'; ?>>
			<?php echo esc_html__( 'Green', 'sb_framework' ); ?>
		</option>
    	<option value="sale" <?php if( get_post_meta($post->ID, "ribbion_color", true) == 'sale' ) echo 'selected'; ?>>
			<?php echo esc_html__( 'Purple', 'sb_framework' ); ?>
		</option>
    </select>
</div>

<?php
}
// Saving Metabox data 
add_action( 'save_post', 'sb_themes_meta_save_product' );
function sb_themes_meta_save_product( $post_id )
{
  // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
// if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce_product'] ) || !wp_verify_nonce( $_POST['meta_box_nonce_product'], 'my_meta_box_nonce_product' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
	
	// Make sure your data is set before trying to save it
    if( isset( $_POST['ribbion_text'] ) )
        update_post_meta( $post_id, 'ribbion_text', $_POST['ribbion_text'] );
		
    if( isset( $_POST['ribbion_color'] ) )
        update_post_meta( $post_id, 'ribbion_color', $_POST['ribbion_color'] );
		
}