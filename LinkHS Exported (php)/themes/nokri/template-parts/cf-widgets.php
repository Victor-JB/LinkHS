<?php 
global $nokri;

$custom_cat_flag = FALSE;
$custom_cat_flag   =   (isset($nokri['job_post_form']) && $nokri['job_post_form'] == "1") ? true : false;
 $term_id = (isset($_GET['cat-id']) && $_GET['cat-id'] != "" && is_numeric($_GET['cat-id'])) ?  $_GET['cat-id'] : "";
 $customHTML  = "";
if ($custom_cat_flag && $term_id != '') {
    
 $result = nokri_dynamic_templateID($term_id);
 
 
   $templateID = get_term_meta($result, '_sb_dynamic_form_fields', true);
   
   if (isset($templateID) && $templateID != "") {
        $formData = sb_dynamic_form_data($templateID);
        $customHTML .= '';
        $sb_search_page    = get_the_permalink($nokri['sb_search_page']);
        
        foreach ($formData as $r) {
              
            if (isset($r['types']) && trim($r['types']) != "") {
                if (isset($r['status']) && $r['status'] == 0) {  continue; }
                if (isset($r['types']) && $r['types'] == 5) {  continue; }

                $in_search = (isset($r['in_search']) && $r['in_search'] == "yes") ? 1 : 0;

                if ($r['titles'] != "" && $r['slugs'] != "" && $in_search == 1) {
                    $rand_ids = rand(123, 1234567);

                    global $wp;
                 

                    $open_widget_cus = false;
                    $open_collapse = '';

                    if (isset($instance['open_widget']) && $instance['open_widget']) {
                       
                    }

                   
                    $customHTML .= '<div class="panel panel-default">
  <div class="panel-heading" role="tab" id="heading-' . $rand_ids . '">
   <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordions" href="#custom-cate-' . $rand_ids . '" aria-expanded="' . $open_widget_cus . '" aria-controls="heading-' . $rand_ids . '">' . esc_html($title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title'])) . ' ' . esc_html($r['titles']) . '</a></div>
 
  <div id="custom-cate-' . $rand_ids . '" class="panel-collapse collapse' . $open_collapse . '" role="tabpanel" aria-labelledby="heading-' . $rand_ids . '" aria-expanded="' . $open_widget_cus . '"><div class="panel-body">'
                            . ' <form method="get" action="' . nokri_returnEcho($sb_search_page) . '" class="custom-search-form">';
                    $fieldName = "custom[" . esc_attr($r['slugs']) . "]";
                    $fieldValue = '';
                    $fieldValue = (isset($_GET["custom"]) && isset($_GET['custom'][esc_attr($r['slugs'])])) ? $_GET['custom'][esc_attr($r['slugs'])] : '';
                    if (isset($r['types']) && $r['types'] == 1) {
                        $customHTML .= '<div class="form-group"><input placeholder="' . esc_attr($r['titles']) . '" name="' . $fieldName . '" value="' . $fieldValue . '" type="text" class="form-control"></div><button type="submit"  class="btn n-btn-flat btn-mid">'. esc_html__('search','nokri').'</button>';
                    }

                    if (isset($r['types']) && $r['types'] == 2) {
                        $options = '';
                        if (isset($r['values']) && $r['values'] != '') {
                            $varArrs = @explode("|", $r['values']);
                            $options .= '<option value="0">' . esc_html__("Select Option", "nokri") . '</option>';
                            foreach ($varArrs as $varArr) {
                                $selected = ($fieldValue == $varArr) ? 'selected="selected"' : '';
                                $options .= '<option value="' . esc_attr($varArr) . '" ' . $selected . '>' . esc_html($varArr) . '</option>';
                            }
                        }
                        $customHTML .= '<div class="form-group"><select name="' . $fieldName . '" class="custom-search-select form-control" >' . $options . '</select></div><input type="submit" class="btn n-btn-flat btn-mid" id="" value="'. esc_attr__('Search','nokri').'">';
                    }

                    if (isset($r['types']) && $r['types'] == 3) {
                        $options = '';
                        if (isset($r['values']) && $r['values'] != '') {
                            $fieldName = "custom[" . esc_attr($r['slugs']) . "]";
                            $varArrs = @explode("|", $r['values']);

                            $loop = 1;
                            foreach ($varArrs as $val) {

                                $checked = '';
                                if (isset($fieldValue) && $fieldValue != "") {
                                    if (isset($fieldValue) && is_array($fieldValue)) {
                                        $checked = (in_array($val, $fieldValue)) ? 'checked="checked"' : '';
                                    } else {
                                        $checked = ($val == $fieldValue) ? 'checked="checked"' : '';
                                    }
                                }

                                $options .= '<li><input type="radio"  class="input-icheck-search" id="minimal-checkbox-' . $loop . '"  value="' . esc_html($val) . '" ' . $checked . ' name="' . $fieldName . '"><label for="minimal-checkbox-' . $loop . '">' . esc_html($val) . '</label></li>';
                                $loop++;
                            }
                        }
                        $customHTML .= '<ul class="list">' . $options . '</ul>';
                    }

                

                    if (isset($r['types']) && $r['types'] == 4) {

                        $minVal = (isset($_GET["min_custom"]) && isset($_GET['min_custom'][esc_attr($r['slugs'])])) ? $_GET['min_custom'][esc_attr($r['slugs'])] : '';
                        $maxVal = (isset($_GET["max_custom"]) && isset($_GET['max_custom'][esc_attr($r['slugs'])])) ? $_GET['max_custom'][esc_attr($r['slugs'])] : '';

                        $btn_cls = 'btn btn-theme btn-sm btn-block';
                        $customHTML .= '<div class="clearfix"></div><div class="search-widget col-md-12 no-padding"><input placeholder="' . esc_attr(__("From", "nokri")) . '" name="min_' . $fieldName . '" value="' . $minVal . '" type="text" class="dynamic-form-date-fields"><button type="submit" onclick="return false;"><i class="fa fa-calendar"></i></button></div><div class="search-widget col-md-12 no-padding"><input placeholder="' . esc_attr(__("To", "nokri")) . '" name="max_' . $fieldName . '" value="' . $maxVal . '" type="text" class="dynamic-form-date-fields"><button type="submit" onclick="return false;"><i class="fa fa-calendar"></i></button></div>
				<div class="col-md-12 no-padding"><button type="submit" class="' . esc_attr($btn_cls) . '"><i class="fa fa-search"></i></button></div>';
                    }
                

                    $customHTML .= nokri_search_params($fieldName);
                   $customHTML .= '</div></div></form></div>';
                }
            }
        }
        
         
     echo ''.$customHTML;
}}
?>