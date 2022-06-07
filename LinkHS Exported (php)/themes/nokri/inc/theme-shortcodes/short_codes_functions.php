<?php

if (!function_exists('nokri_color_text')) {

    function nokri_color_text($str) {
        preg_match('~{color}([^{]*){/color}~i', $str, $match);
        if (isset($match[1])) {
            $search = "{color}" . $match[1] . "{/color}";
            $replace = '<span class="heading-color">' . $match[1] . '</span>';
            $str = str_replace($search, $replace, $str);
        }
        return $str;
    }

}

if (!function_exists('nokri_getHeader')) {

    function nokri_getHeader($sb_section_title, $sb_section_description) {
        $title = '';
        if ($sb_section_title != '') {
            $title = '<h2>' . $sb_section_title . '</h2>';
        }
        $desc = '';
        if ($sb_section_description != '') {
            $desc = '<p>' . $sb_section_description . '</p>';
        }
        $header_html = '';
        if ($title || $desc != '') {
            $header_html = '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="heading-title black">
                                ' . $title . '
                                 ' . $desc . '
                            </div>
                        </div>';
        }
        return $header_html;
    }

}
// Get param array
if (!function_exists('nokri_generate_type')) {

    function nokri_generate_type($heading = '', $type = '', $para_name = '', $description = '', $group = '', $values = array(), $default = '', $class = 'vc_col-sm-12 vc_column', $dependency = '', $holder = 'div') {

        $val = '';
        if (count((array) $values) > 0) {
            $val = $values;
        }

        return array(
            "group" => $group,
            "type" => $type,
            "holder" => $holder,
            "class" => "",
            "heading" => $heading,
            "param_name" => $para_name,
            "value" => $val,
            "description" => $description,
            "edit_field_class" => $class,
            "std" => $default,
            'dependency' => $dependency,
        );
    }

}

if (!function_exists('nokri_ThemeBtn')) {

    function nokri_ThemeBtn($section_btn = '', $class = '', $onlyAttr = false, $iconBefore = '', $iconAfter = '') {
        $buttonHTML = "";
        if (isset($section_btn) && $section_btn != "") {
            $button = nokri_extarct_link($section_btn);
            $class = ( $class != "" ) ? 'class="' . esc_attr($class) . '"' : '';
            $rel = ( isset($button["rel"]) && $button["rel"] != "" ) ? ' rel="' . esc_attr($button["rel"]) . ' "' : "";
            $href = ( isset($button["url"]) && $button["url"] != "" ) ? ' href="' . esc_url($button["url"]) . ' "' : "javascript:void(0);";
            $title = ( isset($button["title"]) && $button["title"] != "" ) ? ' title="' . esc_attr($button["title"]) . '"' : "";
            $target = ( isset($button["target"]) && $button["target"] != "" ) ? ' target="' . esc_attr($button["target"]) . '"' : "";
            $titleText = ( isset($button["title"]) && $button["title"] != "" ) ? esc_html($button["title"]) : "";

            if (isset($button["url"]) && $button["url"] != "") {
                $btn = ( $onlyAttr == true ) ? $href . $target . $class . $rel : '<a ' . $href . ' ' . $target . ' ' . $class . ' ' . $rel . '>' . $iconBefore . ' ' . esc_html($titleText) . ' ' . $iconAfter . '</a>';
                $buttonHTML = ( isset($title) ) ? $btn : "";
            }
        }
        return $buttonHTML;
    }

}

if (!function_exists('nokri_extarct_link')) {

    function nokri_extarct_link($string) {
        if ($string != "") {
            $arr = explode('|', $string);
            list($url, $title, $target, $rel) = $arr;
            $rel = urldecode(nokri_themeGetExplode($rel, ':', '1'));
            $url = urldecode(nokri_themeGetExplode($url, ':', '1'));
            $title = urldecode(nokri_themeGetExplode($title, ':', '1'));
            $target = urldecode(nokri_themeGetExplode($target, ':', '1'));
            return array("url" => $url, "title" => $title, "target" => $target, "rel" => $rel);
        }
    }

}

if (!function_exists('nokri_themeGetExplode')) {

    function nokri_themeGetExplode($string = "", $explod = "", $index = "") {
        $ar = '';
        if ($string != "") {
            $exp = explode($explod, $string);
            $ar = ( $index != "" ) ? $exp[$index] : $exp;
        }
        return ( $ar != "" ) ? $ar : "";
    }

}

// BG Color or Image
if (!function_exists('nokri_bg_func')) {

    function nokri_bg_func($sb_bg_color, $sb_bg = '') {
        $bg = '';
        if ($sb_bg_color == 'bg_img') {
            $bgimg = wp_get_attachment_image_src($sb_bg, 'full');
            if ($bgimg[0] != "") {
                $bg = $bgimg[0];
            }
        }
        return array('url' => $bg, 'color' => $sb_bg_color);
    }

}

if (!function_exists('nokri_returnImgSrc')) {

    function nokri_returnImgSrc($id, $size = 'full', $showHtml = false, $class = '', $alt = '') {

        $img = '';
        if (isset($id) && $id != "") {
            if ($showHtml == false) {
                $img1 = wp_get_attachment_image_src($id, $size);

                $img = isset($img1[0]) ? $img1[0] : "";
            } else {
                $class = ( $class != "" ) ? 'class="' . esc_attr($class) . '"' : '';
                $alt = ( $alt != "" ) ? 'alt="' . ($alt) . '"' : '';
                $img1 = wp_get_attachment_image_src($id, $size);
                $img = '<img src="' . esc_url($img1[0]) . '" ' . $class . ' ' . $alt . '>';
            }
        }
        return $img;
    }

}

if (!function_exists('nokri_VCImage')) {

    function nokri_VCImage($imgName = '') {
        $val = '';
        if ($imgName != "") {
            $path = esc_url(trailingslashit(get_template_directory_uri()) . 'vc_images/' . $imgName);
            $val = '<img src="' . esc_url($path) . '" style="width:100%" class="img-responsive">';
        }
        return $val;
    }

}

// Get cats
if (!function_exists('nokri_cats')) {

    function nokri_cats($taxonomy = 'ad_cats', $all = 'yes') {
        if (taxonomy_exists($taxonomy)) {
            $ad_cats = get_terms($taxonomy, array('hide_empty' => 0));
            if ($all == 'yes')
                $cats = array('All' => 'all');
            else
                $cats = array();
            if (count((array) $ad_cats) > 0 && $ad_cats != "") {
                foreach ($ad_cats as $cat) {
                    $cats[$cat->name . ' (' . $cat->count . ')'] = $cat->slug;
                }
            }
            return $cats;
        }
    }

}

if (!function_exists('nokri_get_parests')) {

    function nokri_get_parests($taxonomy, $all = 'yes') {
        if (taxonomy_exists($taxonomy)) {
            $ad_cats = nokri_get_cats($taxonomy, 0);
            if ($all == 'yes')
                $cats = array('All' => 'all');
            else
                $cats = array();
            if (count((array) $ad_cats) > 0 && $ad_cats != "") {
                foreach ($ad_cats as $cat) {
                    $cats[$cat->name . ' (' . $cat->count . ')'] = $cat->slug;
                }
            }
            return $cats;
        }
    }

}
if (!function_exists('nokri_sort_sections')) {

    function nokri_sort_sections($values = array()) {
        $options = array();
        if (count((array) $values) > 0 && $values != "") {
            foreach ($values as $key => $value) {
                $options[$value] = $key;
            }
        }
        return $options;
    }

}
if (!function_exists('nokri_get_all')) {

    function nokri_get_all($taxonomy, $all = 'yes') {
        if (taxonomy_exists($taxonomy)) {
            $ad_cats = nokri_get_cats($taxonomy, 0);
            if ($all == 'yes')
                $cats = array('All' => 'all');
            else
                $cats = array();
            if (count((array) $ad_cats) > 0 && $ad_cats != "") {
                foreach ($ad_cats as $cat) {
                    $cats[$cat->name] = $cat->name;
                }
            }
            return $cats;
        }
    }

}
// Get Taxonomies
if (!function_exists('nokri_get_all_taxonomies')) {

    function nokri_get_all_taxonomies($cpt_name) {
        $customPostTaxonomies = get_object_taxonomies($cpt_name, 'object');

        if (count((array) $customPostTaxonomies) > 0) {
            $taxonomies_name = array();
            foreach ($customPostTaxonomies as $tax) {
                $taxonomies_name[$tax->label] = $tax->name;
            }
            return $taxonomies_name;
        }
    }

}
/* Getting Jobs Class Jobs */
if (!function_exists('nokri_job_class')) {

    function nokri_job_class($taxonomy_name = '') {
        $taxonomies = get_terms($taxonomy_name, array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC', 'parent' => 0));

        $option = array();
        if (taxonomy_exists($taxonomy_name)) {
            if (isset($taxonomies) && count((array) $taxonomies) > 0) {
                foreach ($taxonomies as $taxonomy) {
                    $emp_class_check = get_term_meta($taxonomy->term_id, 'emp_class_check', true);
                    if ($emp_class_check == '1') {
                        continue;
                    }
                    $option[$taxonomy->name] = $taxonomy->term_id;
                }
            }
        }

        return $option;
    }

}
/* ========================= */
/*   Get All employes Function   */
/* ========================= */
if (!function_exists('nokri_top_employers_lists_shortcodes')) {

    function nokri_top_employers_lists_shortcodes($getvalue = '') {
        /* WP User Query */
        $args = array(
            'order' => 'DESC',
            'meta_query' => array(
                array(
                    'key' => '_sb_reg_type',
                    'value' => "1",
                    'compare' => '='
                ),
            )
        );
        $user_query = new WP_User_Query($args);
        $authors = $user_query->get_results();
        $count_res = count($authors);
        $employers_array = array();
        if (!empty($authors)) {
            $employers_array = array();
            if (count((array) $authors) > 0 && $authors != "") {
                foreach ($authors as $author) {
                    $employers_array[$author->display_name] = $author->ID;
                }
            }
            return $employers_array;
        }
    }

}

/* =============================== */
/*   Get All featured candidates   */
/* ============================== */

if (!function_exists('nokri_get_featured_candidates')) {

    function nokri_get_featured_candidates() {
        /* WP User Query */
        $args = array(
            'order' => 'DESC',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_sb_reg_type',
                    'value' => '0',
                    'compare' => '='
                ),
                array(
                    'key' => '_candidate_feature_profile',
                    'value' => 'null',
                    'compare' => '!='
                ),
            ),
        );
        $user_query = new WP_User_Query($args);
        $authors = $user_query->get_results();
        $count_res = count($authors);
        $employers_array = array();
        if (!empty($authors)) {
            $employers_array = array();
            if (count((array) $authors) > 0 && $authors != "") {
                foreach ($authors as $author) {
                    $employers_array[$author->display_name] = $author->ID;
                }
            }
            return $employers_array;
        }
    }

}
// Update Products
if (!function_exists('nokri_update_products')) {

    function nokri_update_products() {
        $user_id = get_current_user_id();
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'ID',
            'meta_query' => array(array('key' => 'op_pkg_for', 'compare' => 'NOT EXISTS',),),);
        $products = array('Select Product' => '');
        $packages = new WP_Query($args);
        if ($packages->have_posts()) {
            while ($packages->have_posts()) {
                $packages->the_post();
                $product_id = get_the_ID();
                update_post_meta($product_id, 'op_pkg_for', 1);
                update_user_meta($user_id, 'pkg_updated', 1);
            }
        }
    }

}
// Get Products
if (!function_exists('nokri_get_products')) {

    function nokri_get_products() {
        if (!class_exists('WooCommerce')) {
            return;
        }
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'ID',
            'meta_query' => array(array('key' => 'op_pkg_for', 'value' => '1', 'compare' => '=',),),
        );
        $products = array('Select Product' => '');
        $packages = new WP_Query($args);
        if ($packages->have_posts()) {
            while ($packages->have_posts()) {
                $packages->the_post();
                $products[get_the_title()] = get_the_ID();
            }
            wp_reset_postdata();
        }
        return $products;
    }

}
// Get Products for candidate
if (!function_exists('nokri_get_products_cand')) {

    function nokri_get_products_cand() {
        if (!class_exists('WooCommerce')) {
            return;
        }
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'ID',
            'meta_query' => array(array('key' => 'op_pkg_for', 'value' => '0', 'compare' => '=',),),);
        $products = array('Select Product' => '');
        $packages = new WP_Query($args);
        if ($packages->have_posts()) {
            while ($packages->have_posts()) {
                $packages->the_post();
                $products[get_the_title()] = get_the_ID();
            }
            wp_reset_postdata();
        }
        return $products;
    }

}

if (!function_exists('nokri_get_location')) {

    function nokri_get_location($call_back = '') {
        global $nokri_theme;
        $api_key = $nokri_theme['gmap_api_key'];
        return $snippnet = '<script src="https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&libraries=places&callback=' . $call_back . '" type="text/javascript"></script>';
    }

}
// get latitude and longitude
if (!function_exists('nokri_lat_long')) {

    function nokri_lat_long($address) {
        $api_key = $nokri_theme['gmap_api_key'];
        $param = "?address=" . $address . "&key=" . $api_key;
        $url = esc_url("https://maps.googleapis.com/maps/api/geocode/json") . $param;
        $json = wp_remote_get($url);
        $res = $data = json_decode($json['body'], true);
        $latitude = $res['results'][0]['geometry']['location']['lat'];
        $longitude = $res['results'][0]['geometry']['location']['lng'];
        $send_data = array();
        $send_data[] = $latitude;
        $send_data[] = $longitude;
        return $send_data;
    }

}
if (!function_exists('nokri_add_location')) {

    function nokri_add_location($country = '', $state = '', $city = '') {
        global $wpdb;
        $country_data = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE post_type = '_sb_country' AND post_title LIKE '%$country%'");
        $country_id = $country_data->ID;
        $table_name = $wpdb->prefix . 'nokri_locations';
        $state_id = 0;
        $is_state = $wpdb->get_row("SELECT lid FROM $table_name WHERE country_id = '$country_id' AND location_type = 'state'  AND name = '$state'");
        if (!isset($is_state->lid)) {
            $res = nokri_lat_long($state . $country);
            $wpdb->query("INSERT INTO $table_name (name,latitude,longitude,country_id,state_id,location_type) VALUES ('" . $state . "','" . $res[0] . "','" . $res[1] . "','" . $country_id . "','$state_id','state')");
            $state_id = $wpdb->insert_id;
        } else {
            $state_id = $is_state->lid;
        }
        $is_city = $wpdb->get_row("SELECT lid FROM $table_name WHERE country_id = '$country_id' AND location_type = 'city'  AND name = '$city'");
        if (!isset($is_city->lid)) {
            $res = nokri_lat_long($city . $country);

            $wpdb->query("INSERT INTO $table_name (name,latitude,longitude,country_id,state_id,location_type) VALUES ('" . $city . "','" . $res[0] . "','" . $res[1] . "','" . $country_id . "','$state_id','city')");
        }
    }

}

// Making shortcode function
if (!function_exists('nokri_clean_shortcode')) {

    function nokri_clean_shortcode($string) {
        $replace = str_replace("`{`", "[", $string);
        $replace = str_replace("`}`", "]", $replace);
        $replace = str_replace("``", '"', $replace);
        return $replace;
    }

}

// Get Reviews cats
if (!function_exists('nokri_reviews_cats')) {

    function nokri_reviews_cats($taxonomy = 'reviews_cats', $all = 'yes') {
        if (taxonomy_exists($taxonomy)) {
            $ad_cats = get_terms($taxonomy, array('hide_empty' => 0));
            if ($all == 'yes')
                $cats = array('All' => 'all');
            else
                $cats = array();
            if (count((array) $ad_cats) > 0) {
                foreach ($ad_cats as $cat) {
                    $cats[$cat->name . ' (' . $cat->count . ')'] = $cat->slug;
                }
            }
            return $cats;
        }
    }

}

if (!function_exists('nokri_cat_link_page')) {

    function nokri_cat_link_page($category_id, $type = '') {
        global $nokri;
        $final_url = '';
        $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'cat-id', esc_attr($category_id));
        $final_url = esc_url(nokri_page_lang_url_callback($link));
        if ($type == 'category') {
            $link = get_category_link($category_id);
        }
        return $final_url;
    }

}

if (!function_exists('nokri_texnomy_link_page')) {

    function nokri_texnomy_link_page($texnomy_type, $type = '') {
        global $nokri_theme;
        $link = get_the_permalink($nokri_theme['sb_search_page']) . '?body_type=' . $texnomy_type;
        if ($type == 'category') {
            $link = get_category_link($category_id);
        }
        return $link;
    }

}

if (!function_exists('nokri_location_page_link')) {

    function nokri_location_page_link($location_id = '', $type = '') {
        global $nokri;
        $final_url = '';
        $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job-location', esc_attr($location_id));
        $final_url = esc_url(nokri_page_lang_url_callback($link));
        if ($type == 'category') {
            $link = get_category_link($location_id);
        }
        return $final_url;
    }

}
// Get Products
if (!function_exists('nokri_get_products')) {

    function nokri_get_products() {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'ID'
        );
        $products = array('Select Product' => '');
        $packages = new WP_Query($args);
        if ($packages->have_posts()) {
            while ($packages->have_posts()) {
                $packages->the_post();
                $products[get_the_title()] = get_the_ID();
            }
        }
        return $products;
    }

}
if (!function_exists('nokri_color_text')) {

    function nokri_color_text($str) {
        preg_match('~{color}([^{]*){/color}~i', $str, $match);
        if (isset($match[1])) {
            $search = "{color}" . $match[1] . "{/color}";
            $replace = '<span>' . $match[1] . '</span>';
            $str = str_replace($search, $replace, $str);
        }
        return $str;
    }

}