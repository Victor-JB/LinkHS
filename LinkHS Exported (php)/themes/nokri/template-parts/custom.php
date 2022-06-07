<?php
if(isset($_GET['cat-id']) && $_GET['cat-id'] != "" && is_numeric($_GET['cat-id']))
{

$term_id = $_GET['cat-id'];
$result = nokri_dynamic_templateID($term_id);
$templateID = get_term_meta( $result , '_sb_dynamic_form_fields' , true);	
if(isset($templateID) && $templateID != "")
{
	$formData = sb_dynamic_form_data($templateID);	
	$customHTML = '';
	foreach($formData as $r)
	{
if( isset($r['types']) && trim($r['types']) != "") {
			if(isset($r['types'] ) && $r['types'] == 5) {continue;}
$in_search = (isset($r['in_search']) && $r['in_search'] == "yes") ? 1 : 0;
if($r['titles'] != "" && $r['slugs'] != "" && $in_search == 1){			
	
$customHTML .= '<div class="custom-feilds">

		<label class="label-heading">'.$r['titles'].'</label>
	 	<div class="skin-minimal">
			<form method="get" action="'.get_the_permalink( $nokri['sb_search_page'] ).'" class="custom-search-form">';			
			$fieldName = "custom[".esc_attr($r['slugs'])."]";
			
					
			$fieldValue = (isset($_GET["custom"]) && isset($_GET['custom'][esc_attr($r['slugs'])])) ? $_GET['custom'][esc_attr($r['slugs'])] : '';
			if(isset($r['types'] ) && $r['types'] == 1)
			{
				$customHTML .= '<div class="form-group">
                     <input type="text"  class="form-control" name="'.$fieldName.'" placeholder="'.esc_attr($r['titles']).'" >
					  <button type="submit" class="btn n-btn-flat btn-mid"><i class="fa fa-search"></i></button>
                </div>
				<div class="form-group form-action">
               
                </div>';
			}
			if(isset($r['types'] ) && $r['types'] == 2)
			{
				$options = '';
				if(isset($r['values'] ) && $r['values'] != '')
				{
					$varArrs = @explode("|", $r['values']);
					$options .= '<option value="0">'.esc_html__("Select Option", "nokri").'</option>';
					foreach($varArrs as $varArr)
					{
						$selected = ($fieldValue == $varArr) ? 'selected="selected"' : '';
						$options .= '<option value="'.esc_attr($varArr).'" '.$selected.'>'.esc_html($varArr).'</option>';
					}
				}
				$customHTML .= '<div class="form-group"><select name="'.$fieldName.'" class="questions-category" >'.$options.'</select></div><input type="submit" class="btn n-btn-flat btn-mid" value="'. esc_html__( 'Search', 'nokri' ).'">';
					
			}
			
				if(isset($r['types'] ) && $r['types'] == 3)
			   {
				$options = '';
				if(isset($r['values'] ) && $r['values'] != '')
				{
				 $varArrs = @explode("|", $r['values']);
					 
				 $loop = 1;
				 foreach($varArrs as $val)
				 {
				
				  $checked = '';
				  if( isset( $fieldValue ) && $fieldValue != "")
				  {
				   //$checked = in_array($val, $fieldValue) ? 'checked="checked"' : '';
				   $checked = ($val == $fieldValue) ? 'checked="checked"' : '';
				  }
				  //$checked = ( $val == $fieldValue) ? 'checked="checked"' : '';     
				  //$options .= '<li><input type="checkbox" id="minimal-checkbox-'.$loop.'"  value="'.esc_html($val).'" '.$checked.' name="'.$fieldName.'['.$val.']"><label for="minimal-checkbox-'.$loop.'">'.esc_html($val).'</label></li>';
				  $options .= '<li><input type="radio" id="minimal-checkbox-'.$loop.'"  value="'.esc_html($val).'" '.$checked.' name="'.$fieldName.'"><label for="minimal-checkbox-'.$loop.'">'.esc_html($val).'</label></li>';
				  $loop++;     
				 
				 
				 }
				}
				//$customHTML .= '<select name="'.$fieldName.'" class="custom-search-select" >'.$options.'</select>';    
				$customHTML .= '<div class="form-group"><div class="skin-minimal"><ul class="list">'.$options.'</ul></div></div><input type="submit" class="btn n-btn-flat btn-mid" value="'. esc_html__( 'Search', 'nokri' ).'">';
			   }	
			   
			if(isset($r['types'] ) && $r['types'] == 4)
			{
				$customHTML .= '<div class="form-group">
                     <input type="text"  class="datepicker-here-dynamic form-control" name="'.$fieldName.'" placeholder="'.esc_attr($r['titles']).'">
					 <button type="submit" class="btn n-btn-flat btn-mid"><i class="fa fa-search"></i></button>
                </div>
				<div class="form-group form-action">
                </div>';
			}			   			
				$customHTML  .=	 nokri_search_params( $fieldName );
				$customHTML .= '</form></div></div>';
				
				//echo ''.$customHTML;
		
		}
}
	}
}				
	
}

?>