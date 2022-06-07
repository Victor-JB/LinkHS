<?php
function nokri_taxonomy_add_new_meta_field($term)
{
	$term_id = $term->term_id;
	$html = '';
	$tax_html = '';
	$result = get_term_meta( $term_id , '_sb_dynamic_form_fields' , true);
	
		if(isset($result) && $result != "")
		{
			$formData = sb_dynamic_form_data($result);	
			foreach($formData as $r)
			{
				if(trim($r['types']) != "") { $html .= sb_dynamic_form_fields($r, 'yes'); }
			}			
		}						
			$templateVideoShow = '_sb_default_cat_video_show';
			$templateVideoRequired = '_sb_default_cat_video_required';

			$templateVideoShowValue = sb_custom_form_data($result, $templateVideoShow);
			$templateVideoRequiredValue = sb_custom_form_data($result, $templateVideoRequired);	
				
			$templateImageShow = '_sb_default_cat_image_show';
			$templateImageRequired = '_sb_default_cat_image_required';
	
			$templateImageShowValue = sb_custom_form_data($result, $templateImageShow);
			$templateImageRequiredValue = sb_custom_form_data($result, $templateImageRequired);		
	
	?>
	                   			              	     			              
	     			                   			              
<table class="wp-list-table widefat striped">
	
<tbody id="sortables">
	<tr>
	<td colspan="3">
		
		<p class="submit inline-edit-save">
				<strong><?php //echo __('Those are default fields you can show or hide them.', 'redux-framework'); ?></strong>
		</p>
		
	</td> </tr>
	<tr class="user-rich-editing-wrap">
	<th class="name column-name">
		<strong><?php echo __('Field Name', 'redux-framework'); ?></strong>
	</th>					
	<th class="username column-username has-row-actions column-primary">
	<strong><?php echo __('Status', 'redux-framework'); ?></strong>			
	</th>
	<th class="username column-username has-row-actions column-primary">
		<strong><?php echo __('Is Required?', 'redux-framework'); ?></strong>
	</th>
  </tr>
	<tr class="user-rich-editing-wrap">
	<td class="name column-name">
		<label for="rich_editing"><?php echo __('Video URL', 'redux-framework');?></label>
	</td>					
	<td class="username column-username has-row-actions column-primary">
		<label for="<?php echo $templateVideoShow; ?>">

		<select name="<?php echo $templateVideoShow; ?>" id="<?php echo $templateVideoShow; ?>">
			<option value="1"  <?php echo nokri_option_selected($templateVideoShowValue, '1'); ?>><?php echo __('Show', 'redux-framework');?></option>
			<option value="0" <?php echo nokri_option_selected($templateVideoShowValue, '0'); ?>><?php echo __('Hide', 'redux-framework');?></option>

		</select>	
		</label>					
	</td>
	<td class="username column-username has-row-actions column-primary">
		<label for="<?php echo $templateVideoRequired; ?>">
		
		<select name="<?php echo $templateVideoRequired; ?>" id="<?php echo $templateVideoRequired; ?>">
				<option value="1" <?php echo nokri_option_selected($templateVideoRequiredValue, '1'); ?>><?php echo __('Yes', 'redux-framework');?></option>
				<option value="0" <?php echo nokri_option_selected($templateVideoRequiredValue, '0'); ?>><?php echo __('No', 'redux-framework');?></option>
		</select>			
		</label>
	</td>
  </tr>

	
	<tr class="user-rich-editing-wrap">
	<td class="name column-name">
		<label for="rich_editing"><?php echo __('Job Attachments', 'redux-framework'); ?></label>
	</td>					
	<td class="username column-username has-row-actions column-primary">
		<label for="<?php echo $templateImageShow; ?>">

		<select name="<?php echo $templateImageShow; ?>" id="<?php echo $templateImageShow; ?>">
			<option value="1" <?php echo nokri_option_selected($templateImageShowValue, '1'); ?>><?php echo __('Show', 'redux-framework');?></option>
			<option value="0" <?php echo nokri_option_selected($templateImageShowValue, '0'); ?>><?php echo __('Hide', 'redux-framework');?></option>
		</select>	
		</label>					
	</td>
	<td class="username column-username has-row-actions column-primary">
		<label for="<?php echo $templateImageRequired; ?>">
		
		<select name="<?php echo $templateImageRequired; ?>" id="<?php echo $templateImageRequired; ?>">
				<option value="1"  <?php echo nokri_option_selected($templateImageRequiredValue, '1'); ?>><?php echo __('Yes', 'redux-framework');?></option>
				<option value="0" <?php echo nokri_option_selected($templateImageRequiredValue, '0'); ?>><?php echo __('No', 'redux-framework');?></option>
		</select>		
        </label>	
	</td>
  </tr>
	  			  
  			  			  			  
  			  			  			  			  			  
</tbody>
</table>	     

<br /><br /><br />

<!--ui-sortable-->
<div class="wrap-z">
    <div id="poststuff">
        <div id="postbox-container" class="postbox-container">
            <div class="meta-box-sortables " id="normal-sortables">

	
	<table class="wp-list-table widefat striped">
		<thead >
	<tr>
	<td colspan="4">
		
		<p class="submit inline-edit-save">
				<strong><?php echo __('Those are default fields you can show or hide them.', 'redux-framework'); ?></strong>
				</p>
		
	</td> </tr>
	<tr class="user-rich-editing-wrap">
	<th class="name column-name">
		<strong><?php echo __('Field Name', 'redux-framework'); ?></strong>
	</th>					
	<th class="username column-username has-row-actions column-primary">
	<strong><?php echo __('Status', 'redux-framework'); ?></strong>			
	</th>
	<th class="username column-username has-row-actions column-primary">
		<strong><?php echo __('Is Required?', 'redux-framework'); ?></strong>
	</th>
	<th class="username column-username has-row-actions column-primary">
		<strong><?php echo __('In Search', 'redux-framework'); ?></strong>
	</th>    
  </tr>
  
		</thead>
          
     <tbody class="custom_fields_wrap1 custom_fields_table" id="sortable" >     
          <?php echo sb_text_field_data( $term_id  ); ?>
          
  </tbody>
  
  </table>
        </div></div></div></div>     			                   			              



<!--ui-sortable-->
<div class="wrap-z">
    <div id="poststuff">
        <div id="postbox-container" class="postbox-container">
            <div class="meta-box-sortables " id="normal-sortables">

	
	<table class="wp-list-table widefat striped">
		<tbody class="custom_fields_wrap custom_fields_table" id="sortable" >
			
			<?php echo $html; ?>
			<!--tr goes here-->		
		</tbody>
		<tfoot>
			<br />
			<tr>
				<td colspan="4">
					<input id="add-custom-field-button" class="button button-primary add_field_button" value="<?php echo __('Add More Fields', 'redux-framework');?>" type="button"> 
				</td>
			</tr>
		</tfoot>
	</table>    
  
              </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
  
  
    <?php
    }

function nokri_option_selected($key, $val)
{
	return ($key == $val) ? 'selected="selected"' : '';
	
}
function sb_custom_form_data($result = '', $key = '')
{
	
	$arr = '';
	$res = array();
	if( $result != "" && $key != "")
	{
		$baseDecode = base64_decode($result);
		$arr =  json_decode($baseDecode, true);	
		$arr = is_array($arr) ? array_map('stripslashes_deep', $arr) : stripslashes($arr);		
		return (@$arr["$key"]);
	}
	
}
  

function sb_dynamic_form_data($result = '')
{
	$arr = '';
	$res = array();
	if( $result != "")
	{
		$baseDecode = base64_decode($result);
		$arr =  json_decode($baseDecode, true);		
		
		$arr = is_array($arr) ? array_map('stripslashes_deep', $arr) : stripslashes($arr);
		
		$formTypes = isset($arr['_sb_dynamic_form_types']) ? $arr['_sb_dynamic_form_types'] : array();
		$countArr = count((array) $formTypes);
		$i = 0;
		
		if($countArr > 0 && $formTypes != "")
		{
			for($i =0; $i <= $countArr; $i++)
			{
				$res[$i]['types']    = isset($arr['_sb_dynamic_form_types'][$i]) ? $arr['_sb_dynamic_form_types'][$i] : '';
				$res[$i]['titles']   = isset($arr['_sb_dynamic_form_titles'][$i]) ? $arr['_sb_dynamic_form_titles'][$i] : '';	
				$res[$i]['columns']   = isset($arr['_sb_dynamic_form_columns'][$i]) ? $arr['_sb_dynamic_form_columns'][$i] : '';
				$res[$i]['slugs'] 	 = isset($arr['_sb_dynamic_form_slugs'][$i]) ? $arr['_sb_dynamic_form_slugs'][$i] : '';	
				$res[$i]['values'] 	 = isset($arr['_sb_dynamic_form_values'][$i]) ? $arr['_sb_dynamic_form_values'][$i] : '';
				$res[$i]['status'] 	 = isset($arr['_sb_dynamic_form_status'][$i]) ? $arr['_sb_dynamic_form_status'][$i] : '';	
				$res[$i]['requires'] = isset($arr['_sb_dynamic_form_requires'][$i]) ? $arr['_sb_dynamic_form_requires'][$i] : '';
				$res[$i]['in_search'] = isset($arr['_sb_dynamic_form_in_search'][$i]) ? $arr['_sb_dynamic_form_in_search'][$i] : '';
				
			}
		}	
	}
	
	return $res;
}

function nokri_getCats_desc($postId)
{
 $terms = wp_get_post_terms( $postId, 'job_category', array( 'orderby' => 'id', 'order' => 'DESC' ) );
 $deepestTerm = false;
 $maxDepth = -1;
 $c = 0;
 foreach ($terms as $term) 
 {
  $ancestors = get_ancestors( $term->term_id, 'job_category' );
  $termDepth = count((array) $ancestors);
   $deepestTerm[$c] = $term;
   $maxDepth = $termDepth;
   $c++;
 } 
 return ($deepestTerm);
}
function nokriCustomFieldsHTML($post_id = '')
{
	global $nokri;
	$style = '1';
	if((isset($nokri['job_post_style'])) && $nokri['job_post_style']  != '' )
	{
		$style = $nokri['job_post_style'];
	}
	
	
	$html =  $cols = '';
	if($post_id == "") return;
    $terms = nokri_getCats_desc($post_id); 
	if(count((array) $terms) > 0 && $terms !=""){
     foreach ($terms as $term) {
		$term_id = $term->term_id;
		$t = nokri_dynamic_templateID($term_id);
		if($t) break;
     }			 
		
		
		
		$html =  $cols = '';	
		$taxs = nokri_get_term_form( '', '', 'static', 'arr');
		
		if(count((array) $taxs ) > 0 )
		{
			foreach( $taxs as $tax )
			{
				$slug = $tax['slug'];
				$titles = ucfirst( $tax['name'] );				
				if($slug == 'ad_features' ) continue;
				$values = get_post_meta($post_id, '_nokri_'.$slug, true);	
				if( $values != "" ) 
				{
					$html .=  '<div class="col-sm-4 col-md-4 col-xs-12 no-padding"><span><strong>'.esc_html($titles).'</strong> :</span> '.esc_html($values).'</div>';	
				}
					
			}	
		}
	
		$templateID = nokri_dynamic_templateID($term_id);
		$result = get_term_meta( $templateID , '_sb_dynamic_form_fields' , true);	
		
				
		if(isset($result) && $result != "")
		{
			$formData = sb_dynamic_form_data($result);	
			if(count((array) $formData) > 0)
			{
				foreach($formData as $data)
				{	
					$values   = get_post_meta($post_id, "_nokri_tpl_field_".$data['slugs'], true );	
				    $value = json_decode($values);
					$value = (is_array( $value ) ) ? implode(", ",$value) : $values;
					
					$titles   = ($data['titles']);
					
					if( $value != "" )
					{
						if(isset( $data['types'] ) && $data['types'] == 5)
						{
							$value = '<a href="'.esc_url($value).'" target="_blank">'.esc_url($value).'</a>';
						}
						else if(isset( $data['types'] ) && $data['types'] == 4)
						{
							$value = date_i18n( get_option( 'date_format' ), strtotime( $value ) );
						}						
						else
						{
						    $value = esc_html($value);	
						}
						
						if ($style == '2')
						{
						$html .=  '<li>
                           <div class="short-detail-icon">
                              <img src="'.get_template_directory_uri().'/images/icons/tick-icon.png" class="img-responsive" alt="'. esc_attr__('icon', 'nokri' ).'">
                           </div>
                           <div class="short-detail-meta">
                              <small>'.esc_html($titles).'</small>
                              <strong>'.($value).'</strong>
                           </div>
                        </li>';
						}
						else
						{
							$html .=  '<li>
									   <small>'.esc_html($titles).'</small>
									   <strong>'.($value).'</strong>
									</li>';
						}
					}
					
					
				}
			}
		}
		

	}
	return $html;
	
}




function sb_text_field_value( $term_id = '', $is_widget = '') 
{
	$result = get_term_meta( $term_id , '_sb_dynamic_form_fields' , true);
	$arType1 = array();
	if( $result != "")
	{
		$baseDecode = base64_decode($result);
		$arr 		= json_decode($baseDecode, true);				
		$arr 		= is_array($arr) ? array_map('stripslashes_deep', $arr) : stripslashes($arr);
		$formTypes = isset($arr['_sb_tax_fields_name']) ? $arr['_sb_tax_fields_name'] : array();
		
		$countArr = count($formTypes);
		$i = 0;
		if($countArr > 0 && $formTypes != "")
		{
		    $taxonomy_objects = get_object_taxonomies( 'job_post', 'objects' );
		    
			for($i = 0; $i <= $countArr; $i++)
			{
				$name   		= isset($arr['_sb_tax_fields_name'][$i]) ? $arr['_sb_tax_fields_name'][$i] : '';
				$slug    		= isset($arr['_sb_tax_fields_slug'][$i]) ? $arr['_sb_tax_fields_slug'][$i] : '';
				$is_show   		= isset($arr['_sb_tax_fields_is_show'][$i]) ? $arr['_sb_tax_fields_is_show'][$i] : '';	
				$is_req   		= isset($arr['_sb_tax_fields_is_req'][$i]) ? $arr['_sb_tax_fields_is_req'][$i] : '';
				$is_search		= isset($arr['_sb_tax_fields_is_search'][$i]) ? $arr['_sb_tax_fields_is_search'][$i] : '';
				$is_type		= isset($arr['_sb_tax_fields_is_type'][$i]) ? $arr['_sb_tax_fields_is_type'][$i] : '';	
				
				
				foreach( $taxonomy_objects as $taxonomy_object)
				{
					if($taxonomy_object->name == $slug ){
						$name = $taxonomy_object->label;
						break;
					}
				}			
			
				
				
				$arType1[$slug] = array('name' => $name, 'slug' => $slug, 'is_show' => $is_show, 'is_req' => $is_req, 'is_search' => $is_search,'is_type' => $is_type);
			}
		}	
	}	
	
	return ( isset($is_widget) && $is_widget != "" && isset($arType1["$is_widget"]['is_search']) ) ? $arType1["$is_widget"]['is_search'] : $arType1;
	
}
function sb_text_field_data( $term_id )
{
		$result = get_term_meta( $term_id , '_sb_dynamic_form_fields' , true);
		$arr = '';
		$res = array();	
		$arType = nokri_more_inputs();
		$arType1 = array();
		$taxonomy_objects = get_object_taxonomies( 'job_post', 'objects' );
		$countNum = 0;
	 
	   foreach( $taxonomy_objects as $taxonomy_object)
	   {
			if('sb_dynamic_form_templates' == $taxonomy_object->name ) continue ;
			if('job_category' == $taxonomy_object->name ) continue ;
			//if('job_tags' == $taxonomy_object->name ) continue ;
			if('ad_location' == $taxonomy_object->name ) continue ;
			if('job_class' == $taxonomy_object->name ) continue ;
			$arType[$taxonomy_object->name] = array('name' => $taxonomy_object->label, 'slug' => $taxonomy_object->name, 'is_show' => 1, 'is_req' => 0, 'is_search' => 1, 'is_type' => 'select');
	   }  	 
	
	if( $result != "")
	{
		$baseDecode = base64_decode($result);
		$arr 		= json_decode($baseDecode, true);				
		$arr 		= is_array($arr) ? array_map('stripslashes_deep', $arr) : stripslashes($arr);
		$formTypes = isset($arr['_sb_tax_fields_name']) ? $arr['_sb_tax_fields_name'] : array();
		$countArr = count((array) $formTypes);
		$i = 0;
		if($countArr > 0 && $formTypes != "")
		{
			for($i =0; $i <= $countArr; $i++)
			{
				$name   	= isset($arr['_sb_tax_fields_name'][$i]) ? $arr['_sb_tax_fields_name'][$i] : '';
				$slug    	= isset($arr['_sb_tax_fields_slug'][$i]) ? $arr['_sb_tax_fields_slug'][$i] : '';
				$is_show   	= isset($arr['_sb_tax_fields_is_show'][$i]) ? $arr['_sb_tax_fields_is_show'][$i] : '';	
				$is_req   	= isset($arr['_sb_tax_fields_is_req'][$i]) ? $arr['_sb_tax_fields_is_req'][$i] : '';
				$is_search	= isset($arr['_sb_tax_fields_is_search'][$i]) ? $arr['_sb_tax_fields_is_search'][$i] : '';
				$is_type	= isset($arr['_sb_tax_fields_is_type'][$i]) ? $arr['_sb_tax_fields_is_type'][$i] : '';	
			
				unset($arType[$slug]);
				$arType1[$slug] = array('name' => $name, 'slug' => $slug, 'is_show' => $is_show, 'is_req' => $is_req, 'is_search' => $is_search, 'is_type' => $is_type);
			}
		}	
	}	
	
	$resultzz = array_merge($arType,$arType1);	
			
	$name = $slug = $show = $req = $search = $moreHTML  ='' ;
	$show1 = $show2 = $req1 = $req2 = $search1 = $search2 = '';	
	$countNum = 0;
	foreach($resultzz as $r )
	{
	  
	 	if($r['slug'] != ""){
		$name    	= $r['name'];
		$slug    	= $r['slug'];
		$show   	= $r['is_show'];	
		$req   		= $r['is_req'];
		$search		= $r['is_search'];
		$is_type		= $r['is_type'];
		
		$show1 			= ($show == 1) ? 'selected="selected"' : '';
		$show2 			= ($show == 0) ? 'selected="selected"' : '';	
		$req1 			= ($req == 1) ? 'selected="selected"' : '';
		$req2 			= ($req == 0) ? 'selected="selected"' : '';	
		$search1 		= ($search == 1) ? 'selected="selected"' : '';
		$search2 		= ($search == 0) ? 'selected="selected"' : '';	
   
   		if( $slug == 'ad_features' )
		{
			
			$is_req_field = '<input type="hidden" name="_sb_tax_fields_is_req[]" value="0" />';
			$is_search_field = '<input type="hidden" name="_sb_tax_fields_is_search[]" value="0" />';
			
		}
		else
		{
			$is_req_field = '<select name="_sb_tax_fields_is_req[]" id="_sb_tax_fields_is_req">
					<option value="1" '. $req1 .'>'. __("Show", "redux-framework").'</option>
					<option value="0"  '. $req2 .'>'. __("Hide", "redux-framework").'</option>
			</select>';		
			
			$is_search_field = '<select name="_sb_tax_fields_is_search[]" id="_sb_tax_fields_is_search">
							<option value="1" '.$search1.'>'. __("Show", "redux-framework").'</option>
							<option value="0"  '. $search2.'>'. __("Hide", "redux-framework").'</option>
					</select>	';				
				
		}
   		//ad_features
   
		$moreHTML  .= 	'<tr class="user-rich-editing-wrap">
				<td class="name column-name">
					<label for="rich_editing">'.ucfirst($name).'</label>
					<input type="hidden" name="_sb_tax_fields_slug[]" value="'.$slug.'" />
					<input type="hidden" name="_sb_tax_fields_name[]" value="'.$name.'" />
					<input type="hidden" name="_sb_tax_fields_is_type[]" value="'.$is_type.'" />
				</td>					
				<td class="username column-username has-row-actions column-primary">
					<label for="_sb_tax_fields_is_show">
					<select name="_sb_tax_fields_is_show[]" id="_sb_tax_fields_is_show">
						<option value="1" '.$show1.'>'. __("Show", "redux-framework").'</option>
						<option value="0" '.$show2.'>'. __("Hide", "redux-framework").'</option>
					</select>	
					</label>					
				</td>
				<td class="username column-username has-row-actions column-primary">
					<label for="_sb_tax_fields_is_req">
						'.$is_req_field.'
				</label>
				</td>
				<td class="username column-username has-row-actions column-primary">
					<label for="_sb_tax_fields_is_search">
						'.$is_search_field.'
				</label>
				</td></tr> 	              
			';	   
	   
	   
	}	
   }
		return $moreHTML;
}

function sb_dynamic_form_fields($results = '', $loop = '')
{
	$type = $title = $value = $status = $require = $selectVals = $columns = $slugs = $in_search = '' ;
	if($loop != "" && $results != "")
	{
		$type  		= (isset($results['types'])) ? $results['types'] : '';
		$title 		= (isset($results['titles'])) ? $results['titles'] : '';
		$slugs    	= (isset($results['slugs'])) ? $results['slugs'] : '';
		$columns   	= (isset($results['columns'])) ? $results['columns'] : '';
		$value 		= (isset($results['values'])) ? $results['values'] : '';
		$status 	= (isset($results['status'])) ? $results['status'] : '';
		$require  	= (isset($results['requires'])) ? $results['requires'] : '';
		$in_search 	= (isset($results['in_search'])) ? $results['in_search'] : '';
		
	}
	
	/*Get values and add in fields starts*/
		
		$type1 = ($type == 1) ? 'selected="selected"' : '';
	    $type2 = ($type == 2) ? 'selected="selected"' : '';
	    $type3 = ($type == 3) ? 'selected="selected"' : '';
		$type4 = ($type == 4) ? 'selected="selected"' : '';
		$type5 = ($type == 5) ? 'selected="selected"' : '';
	
		$textareaHide = ($type == 2 || $type == 3) ? '' : 'style="display:none;"';

		$status1 = ($status == 1) ? 'selected="selected"' : '';
	    $status2 = ($status == 0) ? 'selected="selected"' : '';

		$require1 = ($require == 1) ? 'selected="selected"' : '';
	    $require2 = ($require == 0) ? 'selected="selected"' : '';
	
		$Columnselected1 = ($columns == 12) ? 'selected="selected"' : '';
		$Columnselected2 = ($columns == 6) ? 'selected="selected"' : '';
		$Columnselected3 = ($columns == 4) ? 'selected="selected"' : '';
		$Columnselected4 = ($columns == 3) ? 'selected="selected"' : '';
	
		$inSearchSelect1 = ($in_search == 'no') ? 'selected="selected"' : '';
		$inSearchSelect2 = ($in_search == 'yes') ? 'selected="selected"' : '';
	/*Get values and add in fields ends */

	$selectNameAttr 	= '_sb_dynamic_form_types[]';
	$inputNameAttr		= '_sb_dynamic_form_titles[]';
	$columnSelect		= '_sb_dynamic_form_columns[]';
	$inputSlugNameAttr	= '_sb_dynamic_form_slugs[]';
	$checkboxNameAttr 	= '_sb_dynamic_form_requires[]';
	$remBtnAttr 		= '_sb_dynamic_form_removes[]';
	$statusBtnAttr 		= '_sb_dynamic_form_status[]';
	$valuesAttr 		= '_sb_dynamic_form_values[]';
	$inSearchSelect 	= '_sb_dynamic_form_in_search[]';

	$fieldName = __('Field Name', 'redux-framework');
	$fieldSlugName = __('Slug Name', 'redux-framework');
	$columnName = __('Columns', 'redux-framework');
	$slectName = __('Select Option', 'redux-framework');
	$valuesName = __('Enter Values', 'redux-framework');
	$requiredName = __('Required?', 'redux-framework');
	$remdName = __('Remove Field', 'redux-framework');
	$statusName = __('Status', 'redux-framework');	
	$inSearchName = __('In Search', 'redux-framework');	
	
	$dynamic = '';//__('Those are dynamic fields you can add texfield and select options as much as you want.', 'redux-framework');
	
	$titleName = isset($title) ? $title : __('New Field', 'redux-framework');
	$slugsId  = (isset($slugs) && $slugs != "") ? $slugs : rand(1,100000);
	
	$moreHTML = '<tr class="inline-edit-row">
	<td>
	
<div class="postbox " id="postbox-1-'.$slugsId.'">
	<div title="'.__('Click to toggle', 'redux-framework').'" class="handlediv"><br></div>

<button type="button" class="handlediv button-link" aria-expanded="false">
<span class="toggle-indicator" aria-hidden="true"></span></button>
	
	<h3 class="hndle"><span>'.$titleName.'&nbsp;</span></h3>
	<div class="inside">
					
	
	<p class="submit inline-edit-save">
	<strong>'.$dynamic.'</strong>
	</p>
	<fieldset class="inline-edit-col-left">
		<br class="clear">
		<div>
			<div class="wp-clearfix">
				<label class="input-text-wrap">
				<span class="title">'.$slectName.'</span> 
				<select name="'.$selectNameAttr.'" class="hideValuesBox" required="required">
					<option value="">'. __('Select Option', 'redux-framework').'</option>
					<option value="1" '.$type1.'>'. __('Input - Textfield', 'redux-framework').'</option>
					<option value="2" '.$type2.'>'. __('Options - Select Box', 'redux-framework').'</option>						
					<option value="3" '.$type3.'>'. __('Options - Check Box', 'redux-framework').'</option>	
					<option value="4" '.$type4.'>'. __('Date - Input', 'redux-framework').'</option>
					<option value="5" '.$type5.'>'. __('Website URL', 'redux-framework').'</option>					
				</select>
				
					&nbsp;&nbsp;&nbsp;
			<label class="inline-edit-status alignright">
			<span class="title">'. $inSearchName .'</span>
			<select name="'.$inSearchSelect.'" required="required">
				<option value="yes" '.$inSearchSelect2.'>'. __('Yes', 'redux-framework').'</option>
				<option value="no" '.$inSearchSelect1.'>'. __('No', 'redux-framework').'</option>
				
			</select>
			
		</label>	

				&nbsp;&nbsp;&nbsp;
			<label class="inline-edit-status alignright">
			<span class="title">'. $columnName .'</span>
			<select name="'.$columnSelect.'" required="required">
				<option value="12" '.$Columnselected1.'>'. __('1/12 Column', 'redux-framework').'</option>
				<option value="6" '.$Columnselected2.'>'. __('1/6 Column', 'redux-framework').'</option>
				<option value="4" '.$Columnselected3.'>'. __('1/3 Column', 'redux-framework').'</option>
				<option value="3" '.$Columnselected4.'>'. __('1/4 Column', 'redux-framework').'</option>
			</select>
			
		</label>

				&nbsp;&nbsp;&nbsp;
			<label class="inline-edit-status alignright">
			<span class="title">'. $requiredName .'</span>
			<select name="'.$checkboxNameAttr.'" required="required">
				<option value="">'. __('Select Option', 'redux-framework').'</option>
				<option value="1" '.$require1.'>'. __('Yes', 'redux-framework').'</option>
				<option value="0" '.$require2.'>'. __('No', 'redux-framework').'</option>						
			</select>
			
		</label>				
				&nbsp;&nbsp;&nbsp;
			<label class="inline-edit-status alignright">
			<span class="title">'. $statusName .'</span>
			<select name="'.$statusBtnAttr.'" required="required">
				<option value="">'. __('Select Option', 'redux-framework').'</option>
				<option value="1" '.$status1.'>'. __('Active', 'redux-framework').'</option>
				<option value="0" '.$status2.'>'. __('Inactive', 'redux-framework').'</option>						
			</select>
			&nbsp;&nbsp;&nbsp;
			</label>			
			</div>
			<div class="wp-clearfix">
			<label>
			<span class="title">'.$fieldName.'</span>
			<span class="input-text-wrap">
				<input class="ptitle sb-get-tilte" value="'.$title.'" type="text" name="'.$inputNameAttr.'" required="required">
				<span>'.__("Enter Field title here.", "redux-framework").'</span>
			</span> 
		</label>
		<label>
		<span class="title">'.$fieldSlugName.'</span>
		<span class="input-text-wrap">
			<input class="ptitle sb-get-slug" value="'.$slugs.'" type="text" name="'.$inputSlugNameAttr.'" required="required" readonly>
			<input type="Checkbox" class="sb-get-slug-edit"><strong>('.__("Edit","redux-framework").')</strong>
			<span>'.__("Enter the slug name, it must be unique and chage it with causion. only alpha numeric and _", "redux-framework").'</span>
		</span> 
	</label>	
	</div>
		<label class="values-label" '.$textareaHide.'>
			<span class="title">'. $valuesName .'</span>
			<span class="input-text-wrap">
			<textarea cols="22" rows="1" class="tax_input_post_tag" name="'.$valuesAttr.'">'.$value.'</textarea>
				<span>'.__("Enter Values seprated by ", "redux-framework").' | </span>
			</span>
		</label>
<button type="button" class="button button-primary cancel alignright sb_custom_rem_btn"  name="'.$remBtnAttr.'">' .$remdName. '</button>
<br class="clear">
<br class="clear">
	</div>
	</fieldset>
	<br class="clear">	
	

                    </div>
                </div>	
	</td>
	</tr>';
	
	
	return ' '.$moreHTML.'';
}

// Save extra taxonomy fields callback function.
function my_taxonomy_save_taxonomy_meta( $term_id ) 
{
	
	if ( isset( $_POST ) ) {
		$data = wp_json_encode( $_POST);
		$data = base64_encode($data);
		update_term_meta( $term_id, '_sb_dynamic_form_fields', $data );		
	}
}  


//add_action( 'created_sb_dynamic_form_templates', 'my_taxonomy_save_taxonomy_meta');
add_action( 'edit_sb_dynamic_form_templates', 'my_taxonomy_save_taxonomy_meta');

// Register Custom Taxonomy
function custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Category Templates', 'Taxonomy General Name', 'redux-framework'),
		'singular_name'              => _x( 'Category Template', 'Taxonomy Singular Name', 'redux-framework'),
		'menu_name'                  => __( 'Category Templates', 'redux-framework'),
		'all_items'                  => __( 'All Items', 'redux-framework'),
		'parent_item'                => __( 'Parent Item', 'redux-framework'),
		'parent_item_colon'          => __( 'Parent Item:', 'redux-framework'),
		'new_item_name'              => __( 'New Item Name', 'redux-framework'),
		'add_new_item'               => __( 'Add New Item', 'redux-framework'),
		'edit_item'                  => __( 'Edit Item', 'redux-framework'),
		'update_item'                => __( 'Update Item', 'redux-framework'),
		'view_item'                  => __( 'View Item', 'redux-framework'),
		'separate_items_with_commas' => __( 'Separate items with commas', 'redux-framework'),
		'add_or_remove_items'        => __( 'Add or remove items', 'redux-framework'),
		'choose_from_most_used'      => __( 'Choose from the most used', 'redux-framework'),
		'popular_items'              => __( 'Popular Items', 'redux-framework'),
		'search_items'               => __( 'Search Items', 'redux-framework'),
		'not_found'                  => __( 'Not Found', 'redux-framework'),
		'no_terms'                   => __( 'No items', 'redux-framework'),
		'items_list'                 => __( 'Items list', 'redux-framework'),
		'items_list_navigation'      => __( 'Items list navigation', 'redux-framework'),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'sb_dynamic_form_templates', array( 'job_post' ), $args );

}
add_action( 'init', 'custom_taxonomy', 0 );

add_action( 'sb_dynamic_form_templates_edit_form_fields', 'nokri_taxonomy_add_new_meta_field', 10, 2 );

/* Add Javascript/Jquery Code Here */
if( isset($_GET['taxonomy'] ) && 'sb_dynamic_form_templates' == $_GET['taxonomy'])
{
	add_action('admin_footer','nokri_admin_scripts_enqueue_cat_templates');	
}
function nokri_admin_scripts_enqueue_cat_templates()
{
	wp_enqueue_script( 'postbox' );
	$confirmDelMeg = __('Are You sure you want to remove this field.', 'redux-framework');
	$moreHTML = sb_dynamic_form_fields();
	$output = str_replace(array("\r\n", "\r"), "\n", $moreHTML);
	$lines = explode("\n", $output);
	$new_lines = array();
	foreach ($lines as $i => $line) {
		if(!empty($line))
			$new_lines[] = trim($line);
	}
	$moreHTML = implode($new_lines);
	?>
                       
<style type="text/css">
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
	.custom_fields_table tr{
		border: 1px solid #CCCACA;
	}
	
	#sortable .postbox
	{
		margin-bottom: 10px !important; 
		margin-top: 10px !important;
	}	
  </style>
 
 
  <script type="text/javascript">
  jQuery( function() {
    jQuery( "#sortable" ).sortable();
    jQuery( "#sortable" ).disableSelection();
  } );
	  
jQuery(document).on('ready', function($){
    postboxes.save_state = function(){
        return;
    };
    postboxes.save_order = function(){
        return;
    };
    postboxes.add_postbox_toggles();
});	  
  </script>
<script type="text/javascript">
		

function sb_confirm_delete_template(){confirm('<?php echo $confirmDelMeg; ?>'); return; }

jQuery(document).ready(function() {

	var max_fields      = 10000; 
    var wrapper         = jQuery(".custom_fields_wrap"); 
    var add_button      = jQuery("#add-custom-field-button");
	var rmv_add_button  = jQuery(".sb_custom_rem_btn"); 
   
    var x = 1; 
    jQuery(add_button).click(function(e){ 
        e.preventDefault();
        if(x < max_fields){ 
            x++; 
            jQuery(wrapper).append('<?php echo ($moreHTML); ?>'); 			
        }
    });
   
	jQuery(wrapper).on("click",".sb_custom_rem_btn", function(e){ 
        e.preventDefault(); 
		jQuery(this).closest('tr').remove(); x--;
    })
	
	
	jQuery(wrapper).on("click","#submit", function(e){ 
			jQuery('input.sb-get-slug').each(function() {
				if(jQuery(this).val() == this.defaultValue) {
						alert('<?php echo __("Duplicate Slug Name", "redux-framework"); ?>');
						return false;
				}		
			});
	});
	//sb-get-slug-edit
	jQuery(wrapper).on("click",".sb-get-slug-edit", function(e){ 
			var checkedval = jQuery(this).is(':checked');
			if(checkedval)
			{
				
				jQuery(this).closest('tr').find('input.sb-get-slug').removeAttr('readonly');
				
			}
			else
			{
				jQuery(this).closest('tr').find('input.sb-get-slug').attr('readonly','readonly');
			}
			
	 });
	
	jQuery(wrapper).on("change",".hideValuesBox", function(e){ 
	
        e.preventDefault(); 
		
		var selectVal = jQuery(this).val();
		if( selectVal == 1 || selectVal == 4 || selectVal == 5)
		{
			jQuery(this).parent().parent().parent().find('label[class=values-label]').hide();
		}
		else
		{
			jQuery(this).parent().parent().parent().find('label[class=values-label]').show();
		}
				
		
	 });
	
	jQuery(wrapper).on("change",".sb-get-tilte", function(e){ 
		
		var isData = jQuery(this).parent().parent().parent().find('input.sb-get-slug').val();
		
		if(isData == "")
		{
			var selectVal 	= jQuery(this).val();
			var string 		= selectVal.toLowerCase();
			var slugVal 	=  string.trim().replace(/[^a-z0-9]+/gi, '_');		
			jQuery(this).parent().parent().parent().find('input.sb-get-slug').val(slugVal);
		}
	 });
	
});		


jQuery(document).ready(function($) 
{
     jQuery('.meta-box-sortables').sortable({
         opacity: 0.6,
         revert: true,
         cursor: 'move',
         handle: '.hndle'
     });
});	
	
	</script>
<?php
}



function sb_add_template_to_cat()
{
	
	$terms = get_terms( array( 'taxonomy' => 'sb_dynamic_form_templates', 'hide_empty' => false, 'parent' => 0, ) );

	$optionsHtml = '';
	foreach($terms as $tr)
	{		
		$term_id = isset($_GET['tag_ID']) ? $_GET['tag_ID'] : '';
		$result = get_term_meta( $term_id , '_sb_category_template' , true);
		$selected = ($result == $tr->term_id) ? 'selected="selected"' : '';
		$optionsHtml  .= '<option value="'.esc_attr($tr->term_id).'" '.$selected.'>'.esc_html($tr->name).'</option>';
		$selected1 = ( $result == 0 ) ? 'selected="selected"' : '';
	}
	?>
   
        <tr class="form-field term-parent-wrap">
        <th scope="row"><label for="parent"><?php _e( 'Select Template', 'redux-framework' ); ?></label></th>
        <td>
            <select name="_sb_ad_template">	
                <option value=""><?php echo __('Select Option', 'redux-framework');?></option>
                <option value="0" <?php echo @$selected1; ?>><?php echo __('Default Template', 'redux-framework');?></option>
                <?php echo ($optionsHtml);?>	
            </select>  
        <p class="description"><?php echo __('You can assign this template to only 1st level category. It will not work with sub categories.', 'redux-framework');?></p>			
        <br /></td>
                </tr>

	<?php
}



add_action( 'job_category_add_form_fields', 'sb_add_template_to_cat', 10, 2 );
add_action( 'job_category_edit_form_fields', 'sb_add_template_to_cat', 10, 2 );


/* Asign template to category */
function nokri_assign_template_to_category( $term_id ) {
	if ( isset( $_POST ) ) {
		$templateID = isset($_POST['_sb_ad_template']) ?  $_POST['_sb_ad_template'] : "";
		update_term_meta( $term_id, '_sb_category_template', $templateID );		
	}
	else
	{
		update_term_meta( $term_id, '_sb_category_template', 0 );	
	}
}  
add_action( 'create_job_category', 'nokri_assign_template_to_category');
add_action( 'edit_job_category', 'nokri_assign_template_to_category');


/*For Front End*/
function nokri_dynamic_templateID($cat_id)
{
	
	$termTemplate = '';
	if($cat_id != "")
	{	

		$termTemplate	= get_term_meta( $cat_id , '_sb_category_template' , true);
		
		$go_next = ($termTemplate == "" || $termTemplate == 0) ? true : false;
		if($go_next)
		{
			$parent = get_term($cat_id);
			if( $parent->parent > 0)
			{
				
				$cat_id = $parent->parent;
				$termTemplate	= get_term_meta( $cat_id , '_sb_category_template' , true);
				
				$go_next = ($termTemplate == "" || $termTemplate == 0) ? true : false;
				$parent = get_term($cat_id);
				if( $parent->parent > 0 && $go_next)
				{
					
					$cat_id = $parent->parent;
					
					$termTemplate	= get_term_meta( $cat_id , '_sb_category_template' , true);
					$parent = get_term($cat_id);
					
					$go_next = ($termTemplate == "" || $termTemplate == 0) ? true : false;
					if( $parent->parent > 0  && $go_next)
					{
						
						$cat_id = $parent->parent;
						$termTemplate	= get_term_meta( $cat_id , '_sb_category_template' , true);
						$parent = get_term($cat_id);
						$go_next = ($termTemplate == "" || $termTemplate == 0) ? true : false;
						if( $parent->parent > 0  && $go_next)
						{
							$cat_id = $parent->parent;
							$termTemplate	= get_term_meta( $cat_id , '_sb_category_template' , true);
							$parent = get_term($cat_id);
							$go_next = ($termTemplate == "" || $termTemplate == 0) ? true : false;
							if( $parent->parent > 0  && $go_next )
							{
								$cat_id = $parent->parent;
								$termTemplate	= get_term_meta( $cat_id , '_sb_category_template' , true);
							}							
						}						
					}	
						
				}				
			}
		}
	}
	
	return $termTemplate;
	
}


//Dynamic Fields starts
add_action('wp_ajax_sb_get_sub_template', 'nokri_post_ad_fields');
function nokri_post_ad_fields()
{
	$html  		  = 	'';
	$id 		  = 	isset($_POST['is_update']) ? $_POST['is_update'] : '';
	$cat_id 	  = 	isset($_POST['cat_id'])    ? $_POST['cat_id'] : '';
	$termTemplate = 	nokri_dynamic_templateID($cat_id);
	$html  		 .= 	nokri_get_term_form( $termTemplate, $id );
	$html  		 .= 	nokri_get_dynamic_form($termTemplate, $id);
	$html        .=     nokri_get_static_form($termTemplate, $id);	
	echo  $html;
	die();
}
//Dynamic fields ends

function nokri_returnHTML($id = '')
{
	
	if($id == "") return '';
	$html = $mainCatId =  '';
	$cats	=	nokri_get_ad_cats ( $id );
	foreach( $cats as $cat )  { $mainCatId = $cat['id']; }		
	$termTemplate  = 	nokri_dynamic_templateID($mainCatId);	
	$html  		  .= 	nokri_get_term_form( $termTemplate, $id );
	$html         .=	nokri_get_static_form($termTemplate, $id);
	$html         .=	nokri_get_dynamic_form($termTemplate, $id);
        return $html;
	
}

function nokri_get_dynamic_form($term_id = '', $post_id = '')
{
	$html = '';
	if($term_id == '') return $html;
	$result = get_term_meta( $term_id , '_sb_dynamic_form_fields' , true);
	if(isset($result) && $result != "")
	{
		$formData = sb_dynamic_form_data($result);	
		foreach($formData as $data)
		{	
			$status   = ($data['status']);
			if( isset($status) && $status == 1 )
			{
			$types    = ($data['types']);
			$titles   = ($data['titles']);			
			$key	  = '_nokri_tpl_field_'.$data['slugs'];
			$slugs    = 'cat_template_field['. $key . ']';			
			$values   = ($data['values']);			
			$columns  = ($data['columns']);
			$requires = '';

			if(isset($data['requires']) && $data['requires'] && '1')
			{
				$message = 'data-parsley-error-message="'. __( 'This field is required.', 'nokri' ) .'"';
				$requires = 'selected="selected" data-parsley-required="true" '. $message; 
			}
		
			$fieldValue = (isset( $post_id ) &&  $post_id!= "") ?  get_post_meta($post_id, $key, true ) : '';
			
			if($types == 1){

			$html .=	'<div class="col-md-'.$columns.' col-lg-'.$columns.' col-xs-12 col-sm-12">
				    <div class="form-group">
					 <label>'.esc_html($titles).'</label>
					 <input class="form-control" name="'.esc_attr($slugs).'" value="'.$fieldValue.'" type="text" '.$requires.'>
				  </div></div>
			  ';
			}
			$options = '';
			if($types == 2){

			$vals = @explode("|", $values );	
			
			foreach($vals as $val)
			{
				$selected = ($fieldValue == $val) ? 'selected="selected"' : '';
				$options .= '<option value="'.esc_html(trim($val)).'" '.$selected.'>'.esc_html($val).'</option>';
			}
			
			$html .= '
			  <div class="col-md-'.$columns.' col-lg-'.$columns.' col-xs-12 col-sm-12 margin-bottom-20">
			  <div class="form-group">
				 <label class="control-label">'.esc_html($titles).'</label>
				 <select class="category form-control" name="'.esc_attr($slugs).'" '.$requires.'>
					<option value="">'.__("Select Option", "nokri").'</option>
					'.$options.'
				 </select>
			  </div></div>';
			}
			if($types == 3){
					$options = '';
					$vals = @explode("|", $values ); 
					$loop =1;
					$fieldValue = json_decode($fieldValue, true);
					foreach($vals as $val)
					{
					 $checked =  '';
					 if( isset( $fieldValue ) && $fieldValue != "" )
					 {
					  	$checked = in_array($val, $fieldValue) ? 'checked="checked"' : ''; 
					 }
						 
					 $options .= '<li class="col-md-4 col-sm-6 col-xs-12 no-padding"><input type="checkbox" id="minimal-checkbox-'.$loop.'"  value="'.esc_html(trim($val)).'" '.$checked.' name="'.esc_attr($slugs).'['.$val.']"><label for="minimal-checkbox-'.$loop.'">'.esc_html($val).'</label></li>';
					 $loop++;
					}
					  
				   $html .=  '
					 <div class="col-md-'.$columns.' col-lg-'.$columns.' col-xs-12 col-sm-12 margin-bottom-20">
					 <div class="form-group">
					 <label class="control-label">'.esc_html($titles).'</label>
					 <div class="skin-minimal"><ul class="list">'.$options.'</ul></div>
					 </div></div>';
			   }
			/*For Date Field*/   
			if($types == 4){
			$html .=	'
				  <div class="col-md-'.$columns.' col-lg-'.$columns.' col-xs-12 col-sm-12 margin-bottom-20 calendar-div">
				  <div class="form-group">
					 <label class="control-label">'.esc_html($titles).'</label>
					 <input class="form-control dynamic-form-date-fields datepicker-here-dynamic" name="'.esc_attr($slugs).'" value="'.$fieldValue.'" type="text" '.$requires.'><i class="fa fa-calendar"></i>
				  </div> </div>
			  ';
			}
			/*For Website URL*/   
			if($types == 5){
			$valid_message = __("Please enter a valid website URL", "redux-framework");
			$html .=	'<div class="col-md-'.$columns.' col-lg-'.$columns.' col-xs-12 col-sm-12 margin-bottom-20 ">
						 <div class="form-group">
					    <label class="control-label">'.esc_html($titles).'</label>
					    <input class="form-control" name="'.esc_attr($slugs).'" value="'.$fieldValue.'" type="url" '.$requires.' data-required-message="'.esc_attr($valid_message).'" data-parsley-type="url" >
				       </div></div>';
			}
			
			
			       		
			}/*Status ends*/
		}
		
	}	
	return $html;
	
}


function nokri_return_input($type = 'textfield',$post_id = '', $term_id = '', $vals = array())
{
	$html			= '';
	$post_id 		= $post_id;
	$term_id 		= $term_id;
	$post_meta		= isset($vals['post_meta']) ? $vals['post_meta'] : '';
	$is_show 		= isset($vals['is_show']) 	? $vals['is_show'] : '';
	$is_req 		= isset($vals['is_req']) 	? $vals['is_req'] : '';
	$title 			= isset($vals['main_title']) 	? $vals['main_title'] : '';
	$subtitle 		= isset($vals['sub_title']) 	? $vals['sub_title'] : '';
	$fieldName 		= isset($vals['field_name']) 	? $vals['field_name'] : '';
	$fieldID 		= isset($vals['field_id']) 		? $vals['field_id'] : '';
	$fieldClass		= isset($vals['field_class']) 	? $vals['field_class'] : '';
	$fieldVals 		= isset($vals['field_value']) 	? $vals['field_value'] : '';
	$fieldReq 		= isset($vals['field_req']) 	? $vals['field_req'] : '';
	$catName 		= isset($vals['cat_name']) 		? $vals['cat_name'] : '';
	$columns 		= isset($vals['columns']) 		? $vals['columns'] : '6';
	$dataType 		= isset($vals['data-parsley-type']) 		? $vals['data-parsley-type'] : '';
	$dataMsg 		= isset($vals['data-parsley-message']) 		? $vals['data-parsley-message'] : '';
	$result 		= get_term_meta( $term_id , '_sb_dynamic_form_fields' , true);
	$showField 		= sb_custom_form_data($result, $is_show);
	$reqField 		= sb_custom_form_data($result, $is_req);
	$req 			= ($reqField == 1) ? 'true' : 'false';
	$dataTypes 		= ($dataType != '') ? 'data-parsley-type="'.$dataType.'" ' : '';
	$required 		= 'data-parsley-required="'.$req.'" '.$dataTypes.' data-parsley-error-message="'.$dataMsg .'"';
	
	$showField 		= ($term_id == "") ? 1 : $showField;
	
	$small_html	=	'';
	
	
	
	if( $subtitle != "" )
	{
		$small_html = ' <small>'. $subtitle . '</small>';
	}
	
	if($type == 'textfield' && $showField == 1)
	{
		if($post_meta != "")
		{
			$fieldVals = get_post_meta($post_id, $post_meta, true);	
		}
		else
		{
			$tags_array = wp_get_object_terms( $post_id,  $catName, array('fields' => 'names') );
			$fieldVals	=	implode( ',', $tags_array );	
		}
		
		
	$html .= '
			<div class="col-md-'.$columns.' col-lg-'.$columns.' col-xs-12 col-sm-12 margin-bottom-20">
			<div class="form-group">
			<label>'. $title . $small_html .'</label>
			<input class="form-control '.$fieldClass.'" name="'.$fieldName.'" id="'.$fieldID.'" value="'.$fieldVals.'" '.$required.' />
			</div></div>';				

	}
	
	
	
	if($type == 'image' && $showField == 1)
	{
		
		$html .= '
			  <div class="col-md-'.$columns.' col-lg-'.$columns.' col-xs-12 col-sm-12 margin-bottom-20">
			  <div class="form-group">
			  	<label>'. $title . $small_html. '</small></label>
				 <div id="'.$fieldID.'" class="'.$fieldClass.'" '.$required.'></div>
				 </div>
			  </div>
		   ';
		
	}
	
	
	if($type == 'select' && $showField == 1)
	{	
		$optHtml  = '';
		
		$fieldVals = get_post_meta($post_id, $post_meta, true);
		
		$conditions	=	nokri_get_cats($catName , 0 );
		foreach( $conditions as $con )
		{
			$selected	=	( $fieldVals == $con->name ) ? $selected = 'selected="selected"' : '';			
			$optHtml	.='<option value="'.$con->term_id.'|'.$con->name.'"'.$selected.'>'. $con->name . '</option>';
		}		
		
		$html	.= '
			  <div class="col-md-'.$columns.' col-lg-12 col-xs-12 col-sm-12 margin-bottom-20">
			  <div class="form-group">
			  <label>'. $title . $small_html . '</label>
			  <select class="'.$fieldClass.' form-control" id="'.$fieldID.'" name="'.$fieldName.'" '.$required.'>
			  <option value="">'. __('Select Option', 'nokri' ) . '</option>'.$optHtml.'</select></div></div>';	

	}
	
	if($type == 'select_custom' && $showField == 1)
	{ 
		$optHtml  = '';
		
		$fieldValz = get_post_meta($post_id, $post_meta, true);  
		$conditions = $fieldVals;
		foreach( $conditions as $key => $val )
		{
			$selected = ( $fieldValz == $key ) ? $selected = 'selected="selected"' : '';   
			$optHtml .='<option value="'.$key.'"'.$selected.'>'. $val . '</option>';
		}  
		
		$html .= '
		<div class="col-md-'.$columns.' col-lg-'.$columns.' col-xs-12 col-sm-12 margin-bottom-20">
		<label class="control-label">'. $title . $small_html . '</label>
		<select class="'.$fieldClass.' form-control" id="'.$fieldID.'" name="'.$fieldName.'" '.$required.'>
		<option value="">'. __('Select Option', 'nokri' ) . '</option>'.$optHtml.'</select></div>'; 
	
	}	
	
		return $html;
	

}

if ( class_exists ('Redux'))
{
	$get_val = get_option('nokri');
	$pakage_type = isset($get_val['nokri_package_type'])?$get_val['nokri_package_type']:'';
	
	
	if($pakage_type != "" && $pakage_type == 'category_based' )
	{
		//just for category based pricings
		add_action( 'add_meta_boxes', 'sb_rane_meta_box_add_adons',2 );
		add_action( 'admin_print_scripts', 'nokriAddProductTypeJS' );
		
		function sb_rane_meta_box_add_adons()
		{
			global $nokri;
			add_meta_box( 'sb_thmemes_nokri_metaboxes_adons', __('Package Essentials/Adons','redux-framework' ), 'sb_render_meta_product_adons', 'product', 'normal', 'high' );
		}
		
		function sb_render_meta_product_adons( $post = '')
		{
		 // We'll use this nonce field later on when saving.
			wp_nonce_field( 'my_meta_box_nonce_product', 'meta_box_nonce_product' );
		?>
		
		<div class="margin_top">
		<p><?php echo __('Category Type/Adosn','redux-framework' ); ?></p>
			<select name="category_and_adons" style="width:100%; height:40px;" onChange="return nokri_catPricing_changeType();">
				
				<option value=""><?php echo esc_html__( 'Select Option', 'redux-framework' ); ?></option>    	
				<option value="category_based" <?php if( get_post_meta($post->ID, "nokri_package_type", true) == 'category_based' ) echo 'selected'; ?>>
					<?php echo esc_html__( 'Categories Based Template', 'redux-framework' ); ?>
				</option>
				<option value="adons_based" <?php if( get_post_meta($post->ID, "nokri_package_type", true) == 'adons_based' ) echo 'selected'; ?>>
					<?php echo esc_html__( 'Post Ad - Adons', 'redux-framework' ); ?>
				</option>
			</select>
		</div>
		
		
		<div class="margin_top post-ads-adons2" <?php if( get_post_meta($post->ID, "nokri_package_type", true) == 'category_based' ) echo 'style="display:none;"'; ?>>
		<p><?php echo __('Select Adons','redux-framework' ); ?></p>
			<select name="category_adons_ad_type" style="width:100%; height:40px;" required>
				
				
				<option value="featured" <?php if( get_post_meta($post->ID, "nokri_package_ad_type", true) == 'featured' ) echo 'selected'; ?>>
					<?php echo esc_html__( 'Featured Ad', 'redux-framework' ); ?>
				</option>
				<option value="bump" <?php if( get_post_meta($post->ID, "nokri_package_ad_type", true) == 'bump' ) echo 'selected'; ?>>
					<?php echo esc_html__( 'Bump Ad', 'redux-framework' ); ?>
				</option>
			</select>
		</div>
		
		
		<div class="post-ads-adons" <?php if( get_post_meta($post->ID, "nokri_package_type", true) == 'adons_based' ) echo 'style="display:none;"'; ?>>
		
		
		<div class="margin_top">
		<p><strong><?php echo __('Categories','redux-framework' ); ?></strong></p>
		
		<?php
		
			$pkgCats = array();	
			$pkgCats =  get_post_meta($post->ID, "nokri_package_cats", true);
			$pkgCats = (isset($pkgCats) && $pkgCats != "") ? $pkgCats : array();
			$checkBox = '';
			$cats	=	nokri_get_cats('job_category' , 0 );
			if(count((array) $cats) > 0){
				foreach( $cats as $cat )
				{
		
					$boxVal = $cat->term_id;//.'|'.$cat->name;
					$selected = (in_array($boxVal, $pkgCats)) ? 'checked="checked"' : '';
		
					$checkBox	.=	'<input type="checkbox" name="nokri_package_cats[]" value="'.$boxVal.'" '.$selected.'>'. $cat->name . '<br />';
		
		
				}
			}
			echo $checkBox;
		?>        
			
		</div>
		
		</div>
		<?php
		}
		// Saving Metabox data 
		add_action( 'save_post', 'sb_themes_meta_save_product_adons' );
		function sb_themes_meta_save_product_adons( $post_id )
		{
		  // Bail if we're doing an auto save
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			 
		// if our nonce isn't there, or we can't verify it, bail
			if( !isset( $_POST['meta_box_nonce_product'] ) || !wp_verify_nonce( $_POST['meta_box_nonce_product'], 'my_meta_box_nonce_product' ) ) return;
			 
			// if our current user can't edit this post, bail
			if( !current_user_can( 'edit_post' ) ) return;
			
			// Make sure your data is set before trying to save it
			if( isset( $_POST['category_and_adons'] ) )
				update_post_meta( $post_id, 'nokri_package_type', $_POST['category_and_adons'] );
			
			if( isset( $_POST['category_and_adons'] ) && $_POST['category_and_adons'] != "category_based" ){
		 
				update_post_meta( $post_id, 'nokri_package_ad_type', $_POST['category_adons_ad_type'] );
			}
			
			if( isset( $_POST['category_and_adons'] ) && $_POST['category_and_adons'] == "category_based" ){
					update_post_meta( $post_id, 'nokri_package_cats', $_POST['nokri_package_cats'] );
			}
		}
	
	}
	else
	{
		add_action( 'add_meta_boxes', 'nokri_packages_based',2 );
		function nokri_packages_based()
		{
			add_meta_box( 'nokri_metaboxes_packages', __('Package Essentials','redux-framework' ), 'nokri_render_meta_product_adons', 'product', 'normal', 'high' );
		}
		
		function nokri_render_meta_product_adons( $post = '')
		{
		 // We'll use this nonce field later on when saving.
			wp_nonce_field( 'my_meta_box_nonce_product', 'meta_box_nonce_product' );
		?>
		
        <div class="margin_top">
        <p><?php echo __('Package Expiry','redux-framework' ); ?></p>
            <input type="text" name="package_expiry_days" class="project_meta" placeholder="<?php echo esc_attr__('Like 30, 40 or 50 but must be an inter value.', 'redux-framework' ); ?>" size="30" value="<?php echo esc_attr( get_post_meta($post->ID, "package_expiry_days", true) ); ?>" id="package_expiry_days" spellcheck="true" autocomplete="off">
            <div><?php echo __( 'Expiry in days, -1 means never experied unless used it.', 'redux-framework' ); ?></div>
        </div>
        <div>
        <p><?php echo __('Simple Ads','redux-framework' ); ?></p>
            <input type="text" name="package_free_ads" class="project_meta" placeholder="<?php echo esc_attr__('Must be an inter value.', 'redux-framework' ); ?>" size="30" value="<?php echo esc_attr( get_post_meta($post->ID, "package_free_ads", true) ); ?>" id="package_free_ads" spellcheck="true" autocomplete="off">
        </div>
        <div>
        <p><?php echo __('Featured Ads','redux-framework' ); ?></p>
            <input type="text" name="package_featured_ads" class="project_meta" placeholder="<?php echo esc_attr__('Must be an inter value.', 'redux-framework' ); ?>" size="30" value="<?php echo esc_attr( get_post_meta($post->ID, "package_featured_ads", true) ); ?>" id="package_featured_ads" spellcheck="true" autocomplete="off">
        </div>
        <div>
        <p><?php echo __('Bump Ads','redux-framework' ); ?></p>
            <input type="text" name="package_bump_ads" class="project_meta" placeholder="<?php echo esc_attr__('Must be an inter value.', 'redux-framework' ); ?>" size="30" value="<?php echo esc_attr( get_post_meta($post->ID, "package_bump_ads", true) ); ?>" id="package_bump_ads" spellcheck="true" autocomplete="off">
        </div>
        
		<?php
		}
		// Saving Metabox data 
		add_action( 'save_post', 'nokri_themes_meta_save_product_adons' );
		function nokri_themes_meta_save_product_adons( $post_id )
		{
			// Bail if we're doing an auto save
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// if our nonce isn't there, or we can't verify it, bail
			if( !isset( $_POST['meta_box_nonce_product'] ) || !wp_verify_nonce( $_POST['meta_box_nonce_product'], 'my_meta_box_nonce_product' ) ) return;
			// if our current user can't edit this post, bail
			if( !current_user_can( 'edit_post' ) ) return;
			
			if( isset( $_POST['package_expiry_days'] ) )
				update_post_meta( $post_id, 'package_expiry_days', $_POST['package_expiry_days'] );
				
			if( isset( $_POST['package_free_ads'] ) )
				update_post_meta( $post_id, 'package_free_ads', $_POST['package_free_ads'] );
				
			if( isset( $_POST['package_featured_ads'] ) )
				update_post_meta( $post_id, 'package_featured_ads', $_POST['package_featured_ads'] );
				
			if( isset( $_POST['package_bump_ads'] ) )
				update_post_meta( $post_id, 'package_bump_ads', $_POST['package_bump_ads'] );
		}
	}
	
}


function sb_getTerms()
{
		$taxonomy_objects = get_object_taxonomies( 'job_post', 'objects' );
		$arType = array();
		   foreach( $taxonomy_objects as $taxonomy_object)
		   {
				if('sb_dynamic_form_templates' == $taxonomy_object->name ) continue ;
				if('job_category' == $taxonomy_object->name ) continue ;
				if('ad_tags' == $taxonomy_object->name) continue ;
				if('ad_location' == $taxonomy_object->name ) continue ;
				if('job_class' == $taxonomy_object->name ) continue ;
				$arType[$taxonomy_object->name] = array('name' => $taxonomy_object->label, 'slug' => $taxonomy_object->name, 'is_show' => 1, 'is_req' => 0, 'is_search' => 1, 'is_type' => 'select');
		   }  
	   $inputs 	= nokri_more_inputs();	
	   $arType 	= array_merge($inputs,$arType);
	  
		wp_reset_postdata();
		return $arType;
}
function nokriAddProductTypeJS()
{
	?>
	<script type="text/javascript">
		
		function nokri_catPricing_changeType()
		{
			
			var type = jQuery("select[name=category_and_adons]").val();
			if('adons_based' == type)
			{
				/*//category_based,*/
				jQuery(".post-ads-adons").hide();
				jQuery(".post-ads-adons2").show();
			}
			else
			{
				jQuery(".post-ads-adons2").hide();
				jQuery(".post-ads-adons").show();
				
			}
			
		}
	</script>
	<?php 
}