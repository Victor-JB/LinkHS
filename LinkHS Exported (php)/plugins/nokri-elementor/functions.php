<?php 


//getting url of default images
if ( ! function_exists( 'nokri_VCImage' ) ) {
function nokri_ELImage($imgName = '')
{
 $val = '';
 if( $imgName != "" )
 {
  $path = esc_url( trailingslashit( get_template_directory_uri () ) . 'vc_images/'.$imgName );
  
 }
 return  $path ;
}
}
//getting button 
if ( ! function_exists( 'elementor_ThemeBtn' ) ) {
function elementor_ThemeBtn($section_btn = '', $class = '' , $onlyAttr = false, $iconBefore = '', $iconAfter = '' ,$btn_txt = "")
{
 $buttonHTML = "";
 if( isset( $section_btn ) && $section_btn != "") 
 {
 $button =  $section_btn;
 

  $class = ( $class != "" ) ? 'class="'.esc_attr($class).'"' : ''; 
  $href   = ( isset( $button["url"] ) && $button["url"] != "" ) ? ' href="'.esc_url($button["url"]). ' "' : "javascript:void(0);";
  
  $target = ( isset( $button["is_external"] ) && $button["is_external"] == 1 ) ? ' target="'.esc_attr('_blank'). '"' : "";
 
	if( isset( $btn_txt ) && $btn_txt != ""  )
	{
	 $btn = ( $onlyAttr == true ) ? $href. $target. $class : '<a '.$href.' '.$target.' '.$class.'>'.$iconBefore.' '.esc_html($btn_txt).' ' .$iconAfter.'</a>';
  		$buttonHTML = ( isset( $btn_txt ) ) ? $btn : "";
	}
 }
 return $buttonHTML;
}
}


/* Getting Jobs Class Jobs */
if ( ! function_exists( 'nokri_job_class_elementor' ) ) 
{	
		 function nokri_job_class_elementor($taxonomy_name = '')
		 {
				$taxonomies =  get_terms($taxonomy_name, array('hide_empty' => false , 'orderby'=> 'id', 'order' => 'ASC' ,'parent'   => 0  )); 
				
				$option	    =  array();
				if(taxonomy_exists($taxonomy_name))
				{
					if( isset($taxonomies) && count((array)  $taxonomies ) > 0 )
					{
						foreach( $taxonomies as $taxonomy )
						{
							$emp_class_check     	    = get_term_meta($taxonomy->term_id, 'emp_class_check', true);
							if($emp_class_check == '1')
							{
								continue;
							}
							$option[$taxonomy->term_id]	=  $taxonomy->name; 
						}
					}
				}
				
				return $option;		
		 }
}


/* ========================= */
/*   Get All employes Function   */
/* ========================= */

if ( ! function_exists( 'nokri_top_employers_lists_elementor' ) )
 {
	function nokri_top_employers_lists_elementor($getvalue = '' )
	 {
		 /* WP User Query */
		$args 			= 	array (
		'order' 		=> 	'DESC',
		'meta_query' 	=> 	array(
		array(
		'key'     		=> 	'_sb_reg_type',
		'value'   		=> 	"1",
		'compare' 		=> 	'='
			),
		)
	);
	$user_query   = new WP_User_Query($args);	
	$authors      = $user_query->get_results();
	$count_res    = count($authors);
	$employers_array = array();
	if (!empty($authors))
	{
		$employers_array	= array();
		if( count((array)  $authors ) > 0 && $authors != "" )
		{
			foreach( $authors as $author )
			{
				$employers_array[$author->ID] =  $author->display_name;
			}
		}
	return $employers_array;
	}
	}
}


function nokri_elementor_forntend_edit(){   
    $state = false;    
    if(isset($_REQUEST['action'])  && ($_REQUEST['action'] == 'elementor'   || $_REQUEST['action'] == 'elementor_ajax' )){        
        $state  =  true;
    }
    else if(isset($_REQUEST['preview'])  && $_REQUEST['preview'] == 'true'){       
        $state  =  true;
    }   
    else{
         $state  = false;
    }    
   return $state;
    
}

if ( ! function_exists( 'nokri_get_parests_elementor' ) )
{
	function nokri_get_parests_elementor( $taxonomy , $all = 'yes' )
	{
		if(taxonomy_exists($taxonomy))
		{
			$ad_cats = nokri_get_cats($taxonomy , 0 );
			if( $all == 'yes' ) $cats	= array( 'all' => 'All' );
			else $cats	= array();
			if( count((array)  $ad_cats ) > 0 && $ad_cats !="" )
			{
				foreach( $ad_cats as $cat )
				{
					$cats[$cat->slug]	= $cat->name .' (' . $cat->count . ')';
				}
			}
			return $cats;
		}
	}
}


