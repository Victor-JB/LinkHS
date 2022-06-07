<?php
// Register Custom Post Type
function custom_post_type() {
	$labels = array(
		'name'                  => _x( 'Custom Fields', 'Post Type General Name', 'redux-framework' ),
		'singular_name'         => _x( 'Custom Feild', 'Post Type Singular Name', 'redux-framework' ),
		'menu_name'             => __( 'Custom Fields', 'redux-framework' ),
		'name_admin_bar'        => __( 'Custom Feild', 'redux-framework' ),
		'archives'              => __( 'Item Archives', 'redux-framework' ),
		'attributes'            => __( 'Item Attributes', 'redux-framework' ),
		'parent_item_colon'     => __( 'Parent Item:', 'redux-framework' ),
		'all_items'             => __( 'All Items', 'redux-framework' ),
		'add_new_item'          => __( 'Add New Item', 'redux-framework' ),
		'add_new'               => __( 'Add New', 'redux-framework' ),
		'new_item'              => __( 'New Item', 'redux-framework' ),
		'edit_item'             => __( 'Edit Item', 'redux-framework' ),
		'update_item'           => __( 'Update Item', 'redux-framework' ),
		'view_item'             => __( 'View Item', 'redux-framework' ),
		'view_items'            => __( 'View Items', 'redux-framework' ),
		'search_items'          => __( 'Search Item', 'redux-framework' ),
		'not_found'             => __( 'Not found', 'redux-framework' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'redux-framework' ),
		'featured_image'        => __( 'Featured Image', 'redux-framework' ),
		'set_featured_image'    => __( 'Set featured image', 'redux-framework' ),
		'remove_featured_image' => __( 'Remove featured image', 'redux-framework' ),
		'use_featured_image'    => __( 'Use as featured image', 'redux-framework' ),
		'insert_into_item'      => __( 'Insert into item', 'redux-framework' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'redux-framework' ),
		'items_list'            => __( 'Items list', 'redux-framework' ),
		'items_list_navigation' => __( 'Items list navigation', 'redux-framework' ),
		'filter_items_list'     => __( 'Filter items list', 'redux-framework' ),
	);
	$args = array(
		'label'                 => __( 'Custom Feild', 'redux-framework' ),
		'description'           => __( 'Post Type Description', 'redux-framework' ),
		'labels'                => $labels,
		'supports'              => array( 'title'),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 25,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => false,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'custom_feilds', $args );

}
add_action( 'init', 'custom_post_type', 0 );




function feilds_for_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function feilds_for_add_meta_box() {
	add_meta_box(
		'feilds_for-feilds-for',
		__( 'Custom Fields For', 'redux-framework' ),
		'feilds_for_html',
		'custom_feilds',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'feilds_for_add_meta_box' );

function feilds_for_html( $post) {
	wp_nonce_field( '_feilds_for_nonce', 'feilds_for_nonce' );
	$custom_feilds_for  = get_post_meta($post->ID, '_custom_feild_for', true );
	 ?>

	<p>
		<label for="custom_feild_for"><?php _e( 'Select Fields For', 'feilds_for' ); ?></label><br>
		<select name="custom_feild_for" id="custom_feild_for">
			<option <?php echo ($custom_feilds_for === 'Registration' ) ? 'selected=selected' : '' ?>><?php echo __( 'Registration', 'redux-framework' ); ?></option>
			<option <?php echo ($custom_feilds_for === 'Candidate' ) ? 'selected=selected' : '' ?>><?php echo __( 'Candidate', 'redux-framework' ); ?></option>
			<option <?php echo ($custom_feilds_for === 'Employer' ) ? 'selected=selected' : '' ?>><?php echo __( 'Employer', 'redux-framework' ); ?></option>
		</select>
	</p><?php
}

function feilds_for_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['feilds_for_nonce'] ) || ! wp_verify_nonce( $_POST['feilds_for_nonce'], '_feilds_for_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	
	
	
	if ( isset( $_POST['custom_feild_for'] ) )
		update_post_meta( $post_id, '_custom_feild_for', esc_attr( $_POST['custom_feild_for'] ) );
}
add_action( 'save_post', 'feilds_for_save' );

/*
	Usage: feilds_for_get_meta( 'feilds_for_select_feilds_for' )
*/


/* Meta Feilds For End*/





function custom_feilds_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function custom_feilds_add_meta_box() {
	add_meta_box(
		'custom_feilds-custom-feilds',
		__( 'Create Custom Fields Below', 'redux-framework' ),
		'custom_feilds_html',
		'custom_feilds',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'custom_feilds_add_meta_box' );

function custom_feilds_html( $post) {
	wp_nonce_field( '_custom_feilds_nonce', 'custom_feilds_nonce' );
	 $custom_feilds  = json_decode(get_post_meta($post->ID, '_custom_feilds', true ));
	 ?>
	<div id="custom_feilds_wrapper">
    <?php 
    $count   = 1;
	$none    = '';
	$del_btn = '<input type="button" class="btn-admin btn-remove" value="DELETE" onclick=delete_row(custom_repeat'.$count.')>';
    if (is_array($custom_feilds) )
	{
		 foreach($custom_feilds as $value) 
		 {
			   $textareaHide = ($value->feild_value == '') ? 'style="display:none;"' : '';
	?>
        <div class="custom_feilds_repeats" id="custom_repeat<?php echo $count; ?>">
            <p>
                <label for="custom_feilds_select_an_option" class="custom_fields_wrap"><?php _e( 'select an option', 'redux-framework' ); ?></label><br>
                <select name="custom_feilds_select_an_option[]" id="custom_feilds_select_an_option" class="select_feild_type">
                <option value="o"><?php echo __( 'Select Required Field', 'redux-framework' ); ?></option>
                    <option <?php echo ($value->feild_type  === 'Input' ) ? 'selected=selected' : '' ?>><?php echo __( 'Input', 'redux-framework' ); ?></option>
                    <option <?php echo ($value->feild_type === 'RadioButton' ) ? 'selected=selected' : '' ?>><?php echo __( 'RadioButton', 'redux-framework' ); ?></option>
                    <option <?php echo ($value->feild_type === 'Select Box' ) ? 'selected=selected' : '' ?>><?php echo __( 'Select Box', 'redux-framework' ); ?></option>
                    <option <?php echo ($value->feild_type === 'Text Area' ) ? 'selected=selected': '' ?>><?php echo __( 'Text Area', 'redux-framework' ); ?></option>
                    <option <?php echo ($value->feild_type === 'Date' ) ? 'selected=selected' : '' ?>><?php echo __( 'Date', 'redux-framework' ); ?></option>
                    <option <?php echo ($value->feild_type === 'Number' ) ? 'selected=selected' : '' ?>><?php echo __( 'Number', 'redux-framework' ); ?></option>
                </select>
            </p>
            <p class="custom_feilds_labels">
                <label for="custom_feilds_labels"><?php _e( ' Enter Field Label', 'redux-framework' ); ?></label><br>
                <input type="text" name="custom_feilds_label[]" value="<?php echo $value->feild_label; ?>" required="required">
            </p>
            <p class="custom_feilds_values" <?php echo ($textareaHide); ?>>
                <label for="custom_feilds_values"><?php _e( 'Enter Values (Separate each value with | sign)', 'redux-framework' ); ?></label><br>
                <textarea rows="2" cols="156" name="custom_feilds_values[]" id="custom_feilds_values" required ><?php echo $value->feild_value; ?> </textarea>
            </p>
            <p>
                <label for="custom_feilds_is_feild_req"><?php _e( 'Is Field required', 'redux-framework' ); ?></label><br>
                <select name="custom_feilds_is_feild_req[]" id="custom_feilds_is_feild_req">
                    <option <?php echo ($value->feild_req === 'Yes' ) ? 'selected' : '' ?>><?php echo __( 'Yes', 'redux-framework' ); ?></option>
                    <option <?php echo ($value->feild_req === 'No' ) ? 'selected' : '' ?>><?php echo __( 'No', 'redux-framework' ); ?></option>
                    
                </select>
            </p>
            <p>
                <label for="custom_feilds_is_feild_public"><?php _e( 'Is field show in public profile', 'redux-framework' ); ?></label><br>
                <select name="custom_feilds_is_feild_public[]" id="custom_feilds_is_feild_public">
                    <option <?php echo ($value->feild_pub === 'Yes' ) ? 'selected' : '' ?>><?php echo __( 'Yes', 'redux-framework' ); ?></option>
                    <option <?php echo ($value->feild_pub === 'No' ) ? 'selected' : '' ?>><?php echo __( 'No', 'redux-framework' ); ?></option>
                    
                </select>
            </p>
            <?php echo '<input type="button" class="btn-admin btn-remove" value="DELETE" onclick=delete_row("custom_repeat'.$count.'")>'; ?>
        </div>
    <?php  $count++; } }  ?>
   </div>
    <p>
	   <input type="button" class="btn-admin btn-add " onclick="add_row();" value="<?php echo esc_attr__('+ Add More','redux-framework');?>">
	</p>
   <?php
   }
function custom_feilds_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! isset( $_POST['custom_feilds_nonce'] ) || ! wp_verify_nonce( $_POST['custom_feilds_nonce'], '_custom_feilds_nonce' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	
	if ( isset( $_POST['feilds_for_select_feilds_forfeilds_for_select_feilds_for'] ) )
		update_post_meta( $post_id, '_custom_feild_for', esc_attr( $_POST['feilds_for_select_feilds_for'] ) );
	
	

	for($i = 0; $i < count($_POST['custom_feilds_select_an_option']); $i++)
	{
		$floor_name = isset( $_POST[ 'custom_feilds_select_an_option' ][$i] ) ? sanitize_text_field( $_POST[ 'custom_feilds_select_an_option' ][$i] ) : '';
		$feilds[] = array(
					    'feild_type'  =>  $_POST['custom_feilds_select_an_option'][$i],
						'feild_label' =>  $_POST['custom_feilds_label'][$i],
					    'feild_value' =>  $_POST['custom_feilds_values'][$i],
						'feild_req'   =>  $_POST['custom_feilds_is_feild_req'][$i],
						'feild_pub'   =>  $_POST['custom_feilds_is_feild_public'][$i],
			 		);
		
		
	}
	
	
	$final_feilds_data = wp_json_encode($feilds, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
	update_post_meta($post_id, '_custom_feilds', $final_feilds_data);	
}
add_action( 'save_post', 'custom_feilds_save');

/*
	Usage: custom_feilds_get_meta( 'custom_feilds_select_option_for' )
	Usage: custom_feilds_get_meta( 'custom_feilds_select_an_option' )
	Usage: custom_feilds_get_meta( 'custom_feilds_show_in_profile' )
*/


/* Add Javascript/Jquery Code Here */
function this_screen() {
  $current_screen = get_current_screen();
  if( $current_screen ->id === "custom_feilds") {
   add_action('admin_footer','nokri_admin_scripts_enqueue_custom_feilds');	
  }
}
add_action( 'current_screen', 'this_screen' );
function nokri_admin_scripts_enqueue_custom_feilds()
{
?>
<script type="text/javascript">
function add_row()
{
		$rowno = jQuery("#custom_feilds_wrapper .custom_feilds_repeats").length;
	    $rowno = $rowno+1;
		jQuery("#custom_feilds_wrapper").append('<div class="custom_feilds_repeats" id="custom_repeat'+$rowno+'"><p><label for="custom_feilds_select_an_option" class="custom_fields_wrap"><?php _e( 'select an option', 'redux-framework' ); ?></label><br><select name="custom_feilds_select_an_option[]" id="custom_feilds_select_an_option" class="select_feild_type"><option value="o"><?php echo __( 'Select Required Field', 'redux-framework' ); ?></option><option value="Input"><?php echo __( 'Input', 'redux-framework' ); ?></option><option value="RadioButton"><?php echo __( 'RadioButton', 'redux-framework' ); ?></option><option value="Select Box"><?php echo __( 'Select Box', 'redux-framework' ); ?></option><option value="Text Area"><?php echo __( 'Text Area', 'redux-framework' ); ?></option><option  value="Date"><?php echo __( 'Date', 'redux-framework' ); ?></option><option value="Number"><?php echo __( 'Number', 'redux-framework' ); ?></option></select></p><p class="custom_feilds_labels"><label for="custom_feilds_labels"><?php _e( ' Enter Field Label', 'redux-framework' ); ?></label><br><input type="text" name="custom_feilds_label[]" required="required" ></p><p class="custom_feilds_values"><label for="custom_feilds_values"><?php _e( 'Enter Values (Separate each value with | sign) ', 'redux-framework' ); ?></label><br><textarea rows="2" cols="156" name="custom_feilds_values[]" data-parsley-required="true" id="custom_feilds_values" ></textarea></p><p><label for="custom_feilds_is_feild_req"><?php _e( 'Is Field required', 'redux-framework' ); ?></label><br><select name="custom_feilds_is_feild_req[]" id="custom_feilds_is_feild_req"><option <?php echo (custom_feilds_get_meta( 'custom_feilds_is_feild_req' ) === 'Yes' ) ? 'selected' : '' ?>><?php echo __( 'Yes', 'redux-framework' ); ?></option><option <?php echo (custom_feilds_get_meta( 'custom_feilds_is_feild_req' ) === 'No' ) ? 'selected' : '' ?>><?php echo __( 'No', 'redux-framework' ); ?></option></select></p><p><label for="custom_feilds_is_feild_public"><?php _e( 'Is Field show in public profile', 'redux-framework' ); ?></label><br><select name="custom_feilds_is_feild_public[]" id="custom_feilds_is_feild_public"><option <?php echo (custom_feilds_get_meta( 'custom_feilds_is_feild_public' ) === 'Yes' ) ? 'selected' : '' ?>><?php echo __( 'Yes', 'redux-framework' ); ?></option><option <?php echo (custom_feilds_get_meta( 'custom_feilds_is_feild_public' ) === 'No' ) ? 'selected' : '' ?>><?php echo __( 'No', 'redux-framework' ); ?></option></select></p><input type="button" class="btn-admin btn-remove" value="DELETE" onclick=delete_row("custom_repeat'+$rowno+'")></div>');
}

function delete_row(rowno)
{
	var conBox = confirm("Are you sure ?");
    if(conBox){ 
       jQuery('#'+rowno).remove();
    }
    else
        return;
}

jQuery(document.body).on('change', '#custom_feilds_select_an_option', function(e){
var selectVal = jQuery(this).val();
if( selectVal == 'Input' || selectVal == 'Date' ||  selectVal == 'Number' ||  selectVal == 'Text Area')
{
	 jQuery('.custom_feilds_values').hide();
}
else
{
	jQuery('.custom_feilds_values').show();
}
});
</script>
<?php
}