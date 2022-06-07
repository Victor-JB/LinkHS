<?php
if (!function_exists('nokri_comments_list')) {

    function nokri_comments_list($comment, $args, $depth) {
        //checks if were using a div or ol|ul for our output
        $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
        if (get_avatar($comment, $args['avatar_size']) != "") {
            $my_class = 'comment-body';
        } else {
            $my_class = 'comment-body no-marg';
        }
        ?>
        <<?php echo '' . $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($args['has_children'] ? 'parent' : '', $comment); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="<?php echo esc_attr($my_class); ?>">
            <div class="comment-wrapper">
                <div class="comment-meta-wrapper align-items-center">
                    <div class="gravatar">
                        <?php
                        if (0 != $args['avatar_size']) {
                            echo get_avatar($comment, $args['avatar_size']);
                        }
                        ?>
                    </div>
                    <div class="comment-meta">
                        <div class="comment-author">
                            <?php printf(sprintf('<div class="comment-author-linkz">%s</div>', get_comment_author_link($comment))); ?>
                            <time class="comment-meta-item"><?php printf(__('%1$s at %2$s', 'nokri'), get_comment_date('', $comment), sprintf('<a class="comment-author-link">%s</a>', get_comment_time())); ?></time>
                        </div>
                    </div>
                </div>
                <div class="comment-content">
                    <?php comment_text(); ?>
                    <?php if ('0' == $comment->comment_approved) : ?>
                        <p class="comment-awaiting-moderation"><?php esc_html__('Your comment is awaiting moderation.', 'nokri'); ?></p>
                    <?php endif; ?>
                    <?php
                    $reply_link = preg_replace('/comment-reply-link/', 'comment-reply-link ',
                            get_comment_reply_link(array_merge($args, array('reply_text' => esc_html__('Reply', 'nokri'), 'depth' => $depth, 'max_depth' => $args['max_depth']))), 1);
                    ?>
                    <?php
                    if ($reply_link != "") {
                        ?>
                        <?php echo wp_kses($reply_link, nokri_required_tags()); ?>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </article>
        <?php
    }

}
if (!function_exists('nokri_convert_to_array')) {

    function nokri_convert_to_array($data = array()) {
        $count = 0;
        $arr = array();
        foreach ($data as $key => $val) {
            $key = str_replace("'", "", $key);
            $arr[$key] = $val;
        }
        $count = count($arr);
        return array("count" => $count, "arr" => $arr);
    }

}
if (!function_exists('nokri_convert_to_array_22')) {

    function nokri_convert_to_array_22($input) {
        if (is_array($input)) {
            $input = array_map('nokri_stripslashesFull', $input);
        } elseif (is_object($input)) {
            $vars = get_object_vars($input);
            foreach ($vars as $k => $v) {
                $input->{$k} = nokri_stripslashesFull($v);
            }
        } else {
            $input = stripslashes($input);
        }
        return $input;
    }

}
/* ========================= */
/* Top Bar Sorter   */
/* ========================= */
if (!function_exists('nokri_top_bar_sorter')) {

    function nokri_top_bar_sorter($type = '') {
        global $nokri;
        if (isset($nokri['top_bar_sorter1']) && $nokri['top_bar_sorter1'] != "") {
            $info = $nokri['top_bar_sorter1'];
        }
        $sort = '';
        if (count((array) $info) > 0) {
            foreach ($info as $opt => $val) {
                if ($opt == 'Email' && $val != "") {
                    if ($type == 'ul') {
                        $sort .= '<li><a href="mailto:' . esc_attr($val) . '"><i class="fa fa-envelope"></i>' . $val . '</a></li>';
                    } else {
                        $sort .= '<a href="mailto:' . esc_attr($val) . '"><i class="fa fa-envelope"></i>' . $val . '</a>';
                    }
                }
                if ($opt == 'Phone Number' && $val != "") {
                    if ($type == 'ul') {
                        $sort .= '<li><a href="tel:' . esc_attr($val) . '"><i class="fa fa-phone"></i>' . $val . '</a></li>';
                    } else {
                        $sort .= '<a href="tel:' . esc_attr($val) . '"><i class="fa fa-phone"></i> ' . $val . '</a>';
                    }
                }
                if ($opt == 'Address' && $val != "") {
                    if ($type == 'ul') {
                        $sort .= '<li><a href="#"><i class="fa fa-map-marker"></i>' . $val . '</a></li>';
                    } else {
                        $sort .= '<a href="#"><i class="fa fa-map-marker"></i> ' . $val . '</a>';
                    }
                }
            }
        }
        return $sort;
    }

}
/* ========================= */
/*  Top Bar Social  Sorter   */
/* ========================= */
if (!function_exists('nokri_top_bar_social_sorter')) {

    function nokri_top_bar_social_sorter() {
        global $nokri;

        $rtl_class = '';
        if (is_rtl()) {
            $rtl_class = "flip";
        }

        if (isset($nokri['top_bar_social_sorter']) && $nokri['top_bar_social_sorter'] != "") {
            $top_social = $nokri['top_bar_social_sorter'];
        }
        $socails = '';
        if (count((array) $top_social) > 0) {
            foreach ($top_social as $optn => $valu) {
                if ($optn == 'Face Book' && $valu != "") {
                    $socails .= '<li><a href="' . esc_url($valu) . '" class="social-facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>';
                }
                if ($optn == 'Twitter' && $valu != "") {
                    $socails .= '<li><a href="' . esc_url($valu) . '" class="social-twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>';
                }
                if ($optn == 'Instagram' && $valu != "") {
                    $socails .= '<li><a href="' . esc_url($valu) . '" class="social-instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>';
                }
                if ($optn == 'LinkedIn' && $valu != "") {
                    $socails .= '<li><a href="' . esc_url($valu) . '" class="social-linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>';
                }
                if ($optn == 'Behance' && $valu != "") {
                    $socails .= '<li><a href="' . esc_url($valu) . '" class="social-behance" target="_blank"><i class="fa fa-behance"></i></a></li>';
                }
                if ($optn == 'Pintrest' && $valu != "") {
                    $socails .= '<li><a href="' . esc_url($valu) . '" class="social-pinterest" target="_blank"><i class="fa fa-pinterest"></i></a></li>';
                }
                if ($optn == 'Youtube' && $valu != "") {
                    $socails .= '<li><a href="' . esc_url($valu) . '" class="social-pinterest" target="_blank"><i class="fa fa-youtube"></i></a></li>';
                }
            }
        }
        return ' <ul class="header-social pull-left ' . esc_attr($rtl_class) . '">' . $socails . '</ul>';
    }

}
/* ========================= */
/*  Top Bar Pages Links Function   */
/* ========================= */
if (!function_exists('nokri_top_pages_links')) {

    function nokri_top_pages_links() {
        global $nokri;
        $top_bar_links = '';
        $top_pages = isset($nokri['opt_multi_select_top_bar_pages']) ? $nokri['opt_multi_select_top_bar_pages'] : array();
        if (count((array) $top_pages) > 0) {
            foreach ($top_pages as $page) {
                $top_bar_links .= '<p><a href="' . esc_url(get_the_permalink($page)) . '"><i class="fa fa-lock"></i>' . get_the_title($page) . '</a></p>';
            }
        }
        return $top_bar_links;
    }

}
/* ========================= */
/*  Header Pages Links Function   */
/* ========================= */
if (!function_exists('nokri_top_header_pages_links')) {

    function nokri_top_header_pages_links() {
        global $nokri;
        $top_links = '';
        $top_pages = isset($nokri['opt_multi_select_header_pages']) ? $nokri['opt_multi_select_header_pages'] : array();
        if (count((array) $top_pages) > 0 && count((array) $top_pages) == 2) {
            foreach ($top_pages as $page) {
                $top_links .= '<li><a href="' . esc_url(get_the_permalink($page)) . '">' . get_the_title($page) . '</a></li>';
            }
        }
        return $top_links;
    }

}
/* ========================= */
/*  Social Profile Links Sorter   */
/* ========================= */
if (!function_exists('nokri_social_footer_sorter')) {

    function nokri_social_footer_sorter($class = '') {
        global $nokri;
        if (isset($nokri['footer_social_sorter']) && $nokri['footer_social_sorter'] != "") {
            $infor1 = $nokri['footer_social_sorter'];
        }
        $sorter = '';
        if (count((array) $infor1) > 0) {
            foreach ($infor1 as $optn => $valu) {
                if ($optn == 'Face Book' && $valu != "") {
                    if ($class == 'nth-social-icons' || $class == '') {
                        $sorter .= '<li><a href="' . esc_url($valu) . '" target="_blank"><i class="fa fa-facebook"></i></a></li>';
                    } else {
                        $sorter .= '<li><a class="fa fa-facebook"  href="' . esc_url($valu) . '" target="_blank"></a></li>';
                    }
                }
                if ($optn == 'Twitter' && $valu != "") {
                    if ($class == 'nth-social-icons' || $class == '') {
                        $sorter .= '<li><a href="' . esc_url($valu) . '" target="_blank"><i class="fa fa-twitter"></i></a></li>';
                    } else {
                        $sorter .= '<li><a class="fa fa-twitter" href="' . esc_url($valu) . '" target="_blank"></a></li>';
                    }
                }
                if ($optn == 'Instagram' && $valu != "") {
                    if ($class == 'nth-social-icons' || $class == '') {
                        $sorter .= '<li><a href="' . esc_url($valu) . '" target="_blank"><i class="fa fa-instagram"></i></a></li>';
                    } else {
                        $sorter .= '<li><a class="fa fa-instagram" href="' . esc_url($valu) . '" target="_blank"></a></li>';
                    }
                }
                if ($optn == 'LinkedIn' && $valu != "") {
                    if ($class == 'nth-social-icons' || $class == '') {
                        $sorter .= '<li><a href="' . esc_url($valu) . '" target="_blank"><i class="fa fa-linkedin"></i></a></li>';
                    } else {
                        $sorter .= '<li><a class="fa fa-linkedin" href="' . esc_url($valu) . '" target="_blank"></a></li>';
                    }
                }
                if ($optn == 'Behance' && $valu != "") {
                    if ($class == 'nth-social-icons' || $class == '') {
                        $sorter .= '<li><a href="' . esc_url($valu) . '" target="_blank"><i class="fa fa-behance"></i></a></li>';
                    } else {
                        $sorter .= '<li><a class="fa fa-behance" href="' . esc_url($valu) . '" target="_blank"></a></li>';
                    }
                }
                if ($optn == 'Pintrest' && $valu != "") {
                    if ($class == 'nth-social-icons' || $class == '') {
                        $sorter .= '<li><a href="' . esc_url($valu) . '" target="_blank"><i class="fa fa-pinterest"></i></a></li>';
                    } else {
                        $sorter .= '<li><a class="fa fa-pinterest" href="' . esc_url($valu) . '" target="_blank"></a></li>';
                    }
                }
                if ($optn == 'Youtube' && $valu != "") {
                    if ($class == 'nth-social-icons' || $class == '') {
                        $sorter .= '<li><a href="' . esc_url($valu) . '" target="_blank"><i class="fa fa-youtube"></i></a></li>';
                    } else {
                        $sorter .= '<li><a class="fa fa-youtube" href="' . esc_url($valu) . '" target="_blank"></a></li>';
                    }
                }
            }
        }
        return '<div class="' . esc_attr($class) . '"><ul>' . $sorter . '</ul></div>';
    }

}
/* ========================= */
/* Footer Hot Links    */
/* ========================= */
if (!function_exists('nokri_foot_hot_links')) {

    function nokri_foot_hot_links() {
        global $nokri;
        $foot_hot_links = '';
        $hot_links = isset($nokri['opt_multi_select_footer_hot_Links']) ? $nokri['opt_multi_select_footer_hot_Links'] : array();
        if (count((array) $hot_links) > 0 && $hot_links != '') {
            foreach ($hot_links as $link) {
                $foot_hot_links .= '<li> <a href="' . esc_url(get_the_permalink($link)) . '">' . get_the_title($link) . ' </a> </li>';
            }
        }
        return $foot_hot_links;
    }

}
/* ========================= */
/* Top Bar Hot Links    */
/* ========================= */
if (!function_exists('nokri_topbar_hot_links')) {

    function nokri_topbar_hot_links() {
        global $nokri;
        $foot_hot_links = '';
        $hot_links = isset($nokri['header_top_bar_links']) ? $nokri['header_top_bar_links'] : array();
        if (count((array) $hot_links) > 0 && $hot_links != '') {
            foreach ($hot_links as $link) {
                $foot_hot_links .= '<li> <a href="' . esc_url(get_the_permalink($link)) . '">' . get_the_title($link) . ' </a> </li>';
            }
        }
        return $foot_hot_links;
    }

}
/* ========================= */
/* Footer Contact Us Sorter   */
/* ========================= */
if (!function_exists('nokri_contact_us_sorter')) {

    function nokri_contact_us_sorter() {
        global $nokri;
        $contact_info = '';
        if (isset($nokri['footer_contact_us_sorter']) && $nokri['footer_contact_us_sorter'] != "") {
            $contact_info = $nokri['footer_contact_us_sorter'];
        }
        $foot_contact = '';
        if (count((array) $contact_info) > 0) {
            foreach ($contact_info as $option => $value) {
                if ($option == 'Adress' && $value != '') {
                    $foot_contact .= '<li><i class="fa fa-map-marker"></i>' . $value . '</li>';
                }
                if ($option == 'Phone Number' && $value != '') {
                    $foot_contact .= '<li><i class="fa fa-phone"></i>' . $value . '</li>';
                }
                if ($option == 'Email' && $value != '') {
                    $foot_contact .= '<li><i class="fa fa-envelope"></i>' . $value . '</li>';
                }
                if ($option == 'Time' && $value != '') {
                    $foot_contact .= '<li><i class="fa fa-clock-o"></i>' . $value . '</li>';
                }
            }
        }
        return $foot_contact;
    }

}
/* ========================= */
/* Footer Contact Us Sorter footer4  */
/* ========================= */
if (!function_exists('nokri_contact_us_sorter_footer_blend')) {

    function nokri_contact_us_sorter_footer_blend() {
        global $nokri;
        $contact_info = '';
        if (isset($nokri['footer_contact_us_sorter4']) && $nokri['footer_contact_us_sorter4'] != "") {
            $contact_info = $nokri['footer_contact_us_sorter4'];
        }
        $foot_contact = '';
        if (count((array) $contact_info) > 0) {
            foreach ($contact_info as $option => $value) {
                if ($option == 'Adress' && $value != '') {
                    $foot_contact .= '<li><i class="fa fa-map-marker"></i>' . $value . '</li>';
                }
                if ($option == 'Phone Number' && $value != '') {
                    $foot_contact .= '<li><i class="fa fa-phone"></i>' . $value . '</li>';
                }
                if ($option == 'Email' && $value != '') {
                    $foot_contact .= '<li><i class="fa fa-envelope"></i>' . $value . '</li>';
                }
                if ($option == 'Time' && $value != '') {
                    $foot_contact .= '<li><i class="fa fa-clock-o"></i>' . $value . '</li>';
                }
            }
        }
        return $foot_contact;
    }

}
/* ========================= */
/* Footer Hot Links  Blend  */
/* ========================= */
if (!function_exists('nokri_foot_hot_links_blend')) {

    function nokri_foot_hot_links_blend() {
        global $nokri;
        $foot_hot_links = '';
        $hot_links = isset($nokri['opt_multi_select_footer_hot_Links']) ? $nokri['opt_multi_select_footer_hot_Links'] : array();
        if (count((array) $hot_links) > 0 && $hot_links != '') {
            foreach ($hot_links as $link) {
                $foot_hot_links .= '<li> <a href="' . esc_url(get_the_permalink($link)) . '">' . get_the_title(nokri_language_page_id_callback($link)) . ' </a> </li>';
            }
        }
        return $foot_hot_links;
    }

}
/* ========================= */
/*  Small Footer Social Sorter   */
/* ========================= */
if (!function_exists('nokri_sm_social_footer_sorter')) {

    function nokri_sm_social_footer_sorter() {
        global $nokri;
        if (isset($nokri['small_footer_social_sorter']) && $nokri['small_footer_social_sorter'] != "") {
            $infor1 = $nokri['small_footer_social_sorter'];
        }
        $sorter = '';
        if (count((array) $infor1) > 0) {
            foreach ($infor1 as $optn => $valu) {
                if ($optn == 'Face Book' && $valu != "") {
                    $sorter .= '<li><a href="' . $valu . '" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>';
                }
                if ($optn == 'Twitter' && $valu != "") {
                    $sorter .= '<li><a href="' . $valu . '" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>';
                }
                if ($optn == 'LinkedIn' && $valu != "") {
                    $sorter .= '<li><a href="' . $valu . '" class="icoLinkedin" title="Linkedin +"><i class="fa fa-linkedin"></i></a></li>';
                }
                if ($optn == 'Google+' && $valu != "") {
                    $sorter .= '<li><a href="' . $valu . '" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>';
                }
            }
        }
        return ' <div class="col-md-6 col-sm-6 col-xs-12">
			<ul class="social-network social-circle onwhite">
				' . $sorter . '
			</ul>
		</div>';
    }

}
/* ========================= */
/*  Footer Job Type Functions  */
/* ========================= */
if (!function_exists('nokri_footer_job_type_links')) {

    function nokri_footer_job_type_links() {
        global $nokri;
        $fetch_data = '';
        if (is_array($nokri['job_type_links']) && $nokri['job_type_links'] != "") {
            $footer_job_type_links = $nokri['job_type_links'];
            if (count((array) $footer_job_type_links) > 0) {
                foreach ($footer_job_type_links as $key => $val) {
                    $term = get_term($val, 'job_type');
                    $fetch_data .= '<li><a href="' . get_the_permalink($nokri['sb_search_page']) . '?job_shift=' . $val . '">' . $term->name . '</a></li>';
                }
            }
        }
        return $fetch_data;
    }

}
/* ========================= */
/*  Footer Job Shift Functions  */
/* ========================= */
if (!function_exists('nokri_footer_job_shift_links')) {

    function nokri_footer_job_shift_links() {
        global $nokri;
        $fetch_data = '';
        if (is_array($nokri['job_shift_links']) && $nokri['job_shift_links'] != "") {
            $footer_job_shift_links = $nokri['job_shift_links'];
            if (count((array) $footer_job_shift_links) > 0) {
                foreach ($footer_job_shift_links as $key => $val) {
                    $term = get_term($val, 'job_shift');
                    $fetch_data .= '<li><a href="' . get_the_permalink($nokri['sb_search_page']) . '?job_shift=' . $val . '">' . $term->name . '</a></li>';
                }
            }
        }
        return $fetch_data;
    }

}
/* ========================= */
/*  Footer Job Location Functions  */
/* ========================= */
if (!function_exists('nokri_footer_job_locations_links')) {

    function nokri_footer_job_locations_links() {
        global $nokri;
        $fetch_job_locations = '';
        if (is_array($nokri['job_locations_links']) && $nokri['job_locations_links'] != "") {
            $footer_job_locations_links = $nokri['job_locations_links'];
            if (count((array) $footer_job_locations_links) > 0) {
                foreach ($footer_job_locations_links as $key => $val) {

                    $term = get_term($val, 'ad_location');
                    $fetch_job_locations .= '<li><a href="' . get_the_permalink($nokri['sb_search_page']) . '?job-location=' . $val . '">' . $term->name . '</a></li>';
                }
            }
        }
        return $fetch_job_locations;
    }

}
/* ========================= */
/*  Footer Job Location meld  */
/* ========================= */
if (!function_exists('nokri_footer_job_locations_links_blend')) {

    function nokri_footer_job_locations_links_blend() {
        global $nokri;
        $fetch_job_locations = '';
        if (isset($nokri['job_locations_links']) && is_array($nokri['job_locations_links']) && $nokri['job_locations_links'] != "") {
            $footer_job_locations_links = $nokri['job_locations_links'];
            if (count((array) $footer_job_locations_links) > 0) {
                foreach ($footer_job_locations_links as $key => $val) {


                    $term = get_term($val, 'ad_location');

                    if ($term) {
                        $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job-location', esc_attr($val));
                        $final_url = esc_url(nokri_page_lang_url_callback($link));
                        $fetch_job_locations .= '<li><a href="' . $final_url . '">' . $term->name . '</a></li>';
                    }
                }
            }
        }
        return $fetch_job_locations;
    }

}
/* =================== */
/*  Footer inputs text */
/* ================== */
if (!function_exists('nokri_footer_input_texts')) {

    function nokri_footer_input_texts($key = '', $class = '', $heading = '', $type = '') {
        global $nokri;
        if (isset($nokri[$key]) && $nokri[$key] != '') {
            if (isset($heading) && $heading != '') {
                return '<' . ($heading) . '>' . $nokri[$key] . '</' . ($heading) . '>';
            } else {
                return $nokri[$key];
            }
        }
    }

}
/* ========================= */
/*  Footer Job taxonomies links  */
/* ========================= */
if (!function_exists('nokri_footer_job_taxonomies_links')) {

    function nokri_footer_job_taxonomies_links($taxonomy = '', $key = '', $qstring = '') {
        global $nokri;
        $fetch_job_taxonomy = '';
        if (isset($nokri[$key]) && is_array($nokri[$key]) && $nokri[$key] != "") {
            $footer_job_taxonomy_links = $nokri[$key];
            if (count((array) $footer_job_taxonomy_links) > 0) {
                foreach ($footer_job_taxonomy_links as $key => $val) {
                    $term = get_term($val, $taxonomy);
                    if ($term) {
                        $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), $qstring, esc_attr($val));
                        $final_url = esc_url(nokri_page_lang_url_callback($link));
                        $fetch_job_taxonomy .= '<li><a href="' . $final_url . '">' . $term->name . '</a></li>';
                    }
                }
            }
        }
        return $fetch_job_taxonomy;
    }

}
/* ============== */
/*  Footer 3 Sorter */
/* =============== */
if (!function_exists('nokri_footer_sorter')) {

    function nokri_footer_sorter() {
        global $nokri;
        $layout = $nokri['opt_footer3_sorter']['enabled'];
        if ($layout) {
            foreach ($layout as $key => $value) {
                switch ($key) {
                    /* Category case */
                    case 'cat': echo '<div class="col-sm-6 col-md-2 col-xs-12"><div class="footer_block">
                                     ' . nokri_footer_input_texts('job_categories_txt', '', 'h4', '') . '
                                      <ul class="footer-links">
                                      ' . nokri_footer_job_taxonomies_links('job_category', 'job_categories_links', 'cat_id') . '
                                      </ul>
                                      </ul>
                                      </div>
                                      </div>';
                        break;
                    /* Skills case */
                    case 'skills': echo '<div class="col-sm-6 col-md-2 col-xs-12"><div class="footer_block">
                                     ' . nokri_footer_input_texts('job_skills_txt', '', 'h4', '') . '
                                      <ul class="footer-links">
                                      ' . nokri_footer_job_taxonomies_links('job_skills', 'job_skills_links', 'job_skills') . '
                                      </ul>
                                      </ul>
                                      </div>
                                      </div>';
                        break;
                    /* News Letter case */
                    case 'news': echo '<div class="col-sm-6 col-md-4 col-xs-12">
										<div class="footer_block"> 
										  ' . nokri_footer_input_texts('subscribe_text', '', 'h4', '') . '
										  <div class="subscription-form">
											<form onSubmit="return checkVals();">
											 <div class="form-group">       
											 <input name="sb_email" class="form-control" id="sb_email" placeholder="' . esc_html__('Enter your email address', 'nokri') . '" type="text" autocomplete="off" required>
											 </div>
											 <button id="save_email" type="button"  type="submit" class="btn n-btn-flat btn-block">' . esc_html__('Send', 'nokri') . '<i class="ti-angle-right"></i></button>
											
											 <input class="btn n-btn-flat btn-block no-display" id="processing_req" value="<' . esc_html__('Processing...', 'nokri') . '" type="button">
											 <input type="hidden" id="sb_action" value="footer_action" />
										   </form>
										  </div>
										  ' . nokri_social_footer_sorter('social-bar') . '
										</div>
									  </div>';
                        break;
                    /* Location case */
                    case 'loc': echo '<div class="col-sm-6 col-md-2 col-xs-12"><div class="footer_block">
                                     ' . nokri_footer_input_texts('job_locations_links_text', '', 'h4', '') . '
                                      <ul class="footer-links">
                                      ' . nokri_footer_job_taxonomies_links('ad_location', 'job_locations_links', 'job-location') . '
                                      </ul>
                                      </ul>
                                      </div>
                                      </div>';
                        break;
                    /* Hot links case */
                    case 'hot': echo '<div class="col-sm-6 col-md-2 col-xs-12">
									<div class="footer_block">
									 ' . nokri_footer_input_texts('footer_hot_links', '', 'h4', '') . '
									  <ul class="footer-links">
										' . nokri_foot_hot_links_blend() . '
									  </ul>
									</div>
								  </div>';
                        break;
                    /* App section case */
                    case 'app': echo '<div class="col-sm-6 col-md-2 col-lg-2 col-xs-12">
										<div class="n-footer-block">
										  ' . nokri_footer_input_texts('app_section_title', '', 'h4', '') . '
											<div class="n-app-btn">
												<a href="' . nokri_footer_input_texts('play_store_link', '', '', '') . '" target="_blank">
													<div class="icon">
														<i class="fa fa-play"></i>
													</div>
													<div class="n-icon-text">
														' . nokri_footer_input_texts('play_store_tagline', '', 'small', '') . nokri_footer_input_texts('play_store_heading', '', 'h5', '') . '
													</div>
												</a>
											</div>
											<div class="n-app-btn">
												<a href="' . nokri_footer_input_texts('apple_store_link', '', '', '') . '" target="_blank">
													<div class="icon">
														<i class="fa fa-apple"></i>
													</div>
													<div class="n-icon-text">
													  ' . nokri_footer_input_texts('apple_store_tagline', '', 'small', '') . nokri_footer_input_texts('apple_store_heading', '', 'h5', '') . '
													</div>
												</a>
											</div>
										</div>
									</div>';
                        break;
                }
            }
        }
    }

}
/* ========================= */
/*  Function For Pagination In Blog Grids Styles */
/* ========================= */
if (!function_exists('nokri_blogs_pagination')) {

    function nokri_blogs_pagination($pages = '', $range = 4) {
        $paginationHTML = '';
        $showitems = ($range * 2) + 1;
        global $paged;
        if (empty($paged)) {
            $paged = 1;
        }
        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }
        if (1 != $pages) {
            $paginationHTML .= '';
            $paginationHTML .= '<ul class="pagination">';
            if ($paged > 1 && $showitems < $pages) {
                $paginationHTML .= "<li><a href='" . get_pagenum_link($paged - 1) . "' aria-label='Previous'><span aria-hidden='true'><i class='fa fa-angle-left'></i></span></a></li>";
            }
            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                    $paginationHTML .= ($paged == $i) ? "<li class=\"active\"><span>" . $i . " <span class=\"sr-only\">(current)</span></span></li>" : "<li><a href='" . get_pagenum_link($i) . "'>" . $i . "</a></li>";
                }
            }
            if ($paged < $pages && $showitems < $pages) {
                $paginationHTML .= "<li><a href=\"" . get_pagenum_link($paged + 1) . "\"  aria-label='Next'><span aria-hidden='true'><i class='fa fa-angle-right'></i></span></a></li>";
            }
            $paginationHTML .= "</ul>";
        }
        return $paginationHTML;
    }

}
/* ========================= */
/*  Function Hide/Show Whole Theme Post Meta */
/* ========================= */
if (!function_exists('nokri_post_meta')) {

    function nokri_post_meta($comment = '', $date = '') {
        global $nokri;
        global $post;
        $blogMeta = '';
        if (isset($nokri['theme_post_meta']) && $nokri['theme_post_meta'] == 1) {
            $blogMeta .= '<div class="post-info">';
            if ($date != "") {
                if (isset($nokri['theme_date']) && $nokri['theme_date'] == 1) {
                    $blogMeta .= '<a href="javascript:void(0)" >' . get_the_time(get_option('date_format')) . '</a>';
                }
            }
            if ($comment != "") {
                if (isset($nokri['theme_cmnt']) && $nokri['theme_cmnt'] == 1) {
                    $comments_count = get_comments_number(get_the_ID());
                    $comments_text = __("&nbsp;comment", "nokri");
                    if ($comments_count > 1) {
                        $comments_text = __("&nbsp;comments", "nokri");
                    }
                    $blogMeta .= '<a href="javascript:void(0)"><i class="ti-comments"></i>' . get_comments_number(get_the_ID()) . $comments_text . '</a>';
                }
            }
            $blogMeta .= '</div>';
        } else {
            $blogMeta .= '<div class="post-info">';
            $blogMeta .= '<a href="javascript:void(0)">' . get_the_time(get_option('date_format')) . '</a>';
            $comments_count = get_comments_number(get_the_ID());
            $comments_text = __("&nbsp;comment", "nokri");
            if ($comments_count > 0) {
                $comments_text = __("comments", "nokri");
            }
            if (comments_open()) {
                $blogMeta .= '<a href="javascript:void(0)">' . get_comments_number(get_the_ID()) . " " . $comments_text . '</a>';
            }
            $blogMeta .= '</div>';
        }
        return $blogMeta;
    }

}
/* ========================= */
/*  Post Tags   Function   */
/* ========================= */
if (!function_exists('nokri_posts_tags')) {

    function nokri_posts_tags() {
        global $nokri;
        /* Tags Limit */
        $blog_tags = isset($nokri['single_blog_tags_no']) ? $nokri['single_blog_tags_no'] : '';
        $args_footer_s = array(
            'number' => $blog_tags,
            'order' => 'DESC'
        );
        $post_id = get_the_ID();
        $tags = wp_get_post_tags($post_id, $args_footer_s);
        $html = '';
        if (count((array) $tags) > 0) {
            foreach ($tags as $tag) {
                $tag_link = get_tag_link($tag->term_id);
                $html .= "<a href='{$tag_link}' >";
                $html .= "#{$tag->name}</a>";
            }
        }
        return '' . $html . '';
    }

}
/* ========================= */
/*  Get BreadCrumb Heading   */
/* ========================= */
if (!function_exists('nokri_bread_crumb_heading')) {

    function nokri_bread_crumb_heading() {
        $page_heading = '';
        global $nokri;
        /* Main Blog Page Text */
        $blog_main = isset($nokri['bread_blog']) ? $nokri['bread_blog'] : esc_html__("Latest Stories", "nokri");
        /* Single Blog Page Text */
        $blog_single = isset($nokri['bread_blog_single']) ? $nokri['bread_blog_single'] : esc_html__("Blog Detail", "nokri");
        /* Search Page Text */
        $blog_search = isset($nokri['bread_blog_search']) ? $nokri['bread_blog_search'] : esc_html__("Search Results For", "nokri");

        if (is_search()) {
            $string = esc_html__('entire web', 'nokri');
            if (get_search_query() != "") {
                $string = get_search_query();
            }
            $page_heading = sprintf(esc_html__('Search Results for: %s', 'nokri'), esc_html($string));
        } else if (is_category()) {
            $page_heading = esc_html(single_cat_title("", false));
        } else if (is_tag()) {
            $page_heading = esc_html__('Tag: ', 'nokri') . esc_html(single_tag_title("", false));
        } else if (is_404()) {
            $page_heading = esc_html__('Page not found', 'nokri');
        } else if (is_author()) {
            $author_id = get_query_var('author');
            $author = get_user_by('ID', $author_id);
            $page_heading = $author->display_name;
        } else if (is_tax()) {
            $page_heading = esc_html(single_cat_title("", false));
        } else if (is_singular('job_post')) {
            $page_heading = esc_html__('Job details', 'nokri');
        } else if (is_archive()) {
            $page_heading = esc_html__('Blog Archive', 'nokri');
        } else if (is_home()) {
            $page_heading = $blog_main;
        } else if (is_singular('post')) {
            $page_heading .= $blog_single;
        } else if (is_singular('page')) {
            $page_heading = get_the_title();
        } else if (is_singular('ad_post')) {
            $page_heading = get_the_title();
        }
        return $page_heading;
    }

}
// Breadcrumb
if (!function_exists('nokri_breadcrumb')) {

    function nokri_breadcrumb() {
        $string = '';
        global $nokri;
        /* Main Blog Page Text */
        $blog_main = isset($nokri['bread_blog']) ? $nokri['bread_blog'] : esc_html__("Latest Stories", "nokri");
        if (is_category()) {
            $string .= esc_html(single_tag_title("", false));
        } else if (is_single()) {
            $string .= esc_html(get_the_title());
        } elseif (is_page()) {
            $string .= esc_html(get_the_title());
        } elseif (is_tag()) {
            $string .= esc_html(single_tag_title("", false));
        } elseif (is_search()) {
            $string .= esc_html(get_search_query());
        } elseif (is_404()) {
            $string .= esc_html__('Page not Found', 'nokri');
        } elseif (is_author()) {
            $string .= esc_html__('Author', 'nokri');
        } else if (is_tax()) {
            $string .= esc_html(single_cat_title("", false));
        } elseif (is_archive()) {
            $string .= esc_html__('Archive', 'nokri');
        } else if (is_home()) {
            $string = $blog_main;
        }
        return $string;
    }

}
/* ========================= */
/* Footer Dark Recent Posts  Function   */
/* ========================= */
if (!function_exists('nokri_footer_posts')) {

    function nokri_footer_posts() {
        global $nokri;
        /* Post Order */
        $ft_ordr = isset($nokri['select_footer_post_ordr']) ? $nokri['select_footer_post_ordr'] : "DESC";
        $recent_args = array(
            'posts_per_page' => (int) 2, 'order' => $ft_ordr, 'post_type' => 'post');
        $foot_rel = '';
        $recent_posts = new WP_Query($recent_args);
        $post_id = get_the_ID();
        if ($recent_posts->have_posts()) :
            while ($recent_posts->have_posts()) :
                $recent_posts->the_post();
                $img_html = '';
                if (has_post_thumbnail($recent_posts->ID)) {
                    $img_html = '<span><a class="plus" href="' . esc_url(get_the_permalink($recent_posts->ID)) . '">' . get_the_post_thumbnail($recent_posts->ID, 'nokri_job_hundred') . '<i>+</i></a></span>';
                }
                $foot_rel .= '<li>
						' . $img_html . '
						<p><a href="' . esc_url(get_the_permalink($recent_posts->ID)) . '">' . get_the_title($recent_posts->ID) . '</a></p>
						<h3>' . get_the_time(get_option('date_format')) . '</h3>
					 </li>';
            endwhile;
        endif;
        /* Section Title */
        $ft_post_title = isset($nokri['foot_post_section_title']) ? '<h4>' . $nokri['foot_post_section_title'] . '</h4>' : "";
        return '<div class="col-sm-6 col-md-4 col-xs-12">
								<div class="footer_block dark_gry">
									' . $ft_post_title . '
									<ul class="recentpost">
									   ' . $foot_rel . '
									</ul>
								</div>
							</div>';
    }

}
/* ========================= */
/* Remove gallery from content */
/* ========================= */
add_filter('the_content', 'nokri_shortcode_gallery');
if (!function_exists('nokri_shortcode_gallery')) {

    function nokri_shortcode_gallery($content) {
        preg_match_all('/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER);
        if (!empty($matches)) {
            foreach ($matches as $shortcode) {
                $post_type = get_post_format(get_the_ID());
                if ('gallery' === $shortcode[2] && $post_type == 'gallery') {
                    $pos = strpos($content, $shortcode[0]);
                    if ($pos !== false)
                        return substr_replace($content, '', $pos, strlen($shortcode[0]));
                }
            }
        }
        return $content;
    }

}
/* For Contact Form 7 */
if (!function_exists('nokri_clean_shortcode')) {

    function nokri_clean_shortcode($string) {
        $replace = str_replace("`{`", "[", $string);
        $replace = str_replace("`}`", "]", $replace);
        $replace = str_replace("``", '"', $replace);
        return $replace;
    }

}
/* ========================= */
/*  Search Function   */
/* ========================= */
if (!function_exists('nokri_search_results_title')) {

    function nokri_search_results_title() {
        $result_title = '';
        $search_txt = '';
        global $nokri;
        if (is_search()) {
            global $wp_query;
            if ($wp_query->post_count == 1) {
                $result_title .= esc_html__("Result Found For", "nokri");
            } else {
                $result_title .= $wp_query->found_posts . esc_html__('&nbsp; Matches Found For', 'nokri');
            }

            $result_title .= ' "' . esc_html($wp_query->query_vars['s'], 1) . '"';

            return ( $result_title );
        }
    }

}
/* ========================= */
/* Pagination In Unit Test   Function   */
/* ========================= */
if (!function_exists('nokri_pagination_unit_test')) {

    function nokri_pagination_unit_test() {

        $args = array(
            'before' => '<ul class="pagination">',
            'after' => '</ul>',
            'before_link' => '<li>',
            'after_link' => '</li>',
            'current_before' => '<li class="active">',
            'current_after' => '</li>',
            'previouspagelink' => '&laquo;',
            'nextpagelink' => '&raquo;'
        );
        nokri_bootstrap_link_pages($args);
    }

}
if (!function_exists('nokri_bootstrap_link_pages')) {

    function nokri_bootstrap_link_pages($args = array()) {
        $defaults = array(
            'before' => '<p>' . esc_html__('Pages:', 'nokri'),
            'after' => '</p>',
            'before_link' => '',
            'after_link' => '',
            'current_before' => '',
            'current_after' => '',
            'link_before' => '',
            'link_after' => '',
            'pagelink' => '%',
            'echo' => 1
        );
        $r = wp_parse_args($args, $defaults);
        $r = apply_filters('wp_link_pages_args', $r);
        extract($r, EXTR_SKIP);
        global $page, $numpages, $multipage, $more, $pagenow;
        if (!$multipage) {
            return;
        }
        $output = $before;
        for ($i = 1; $i < ($numpages + 1); $i++) {
            $j = str_replace('%', $i, $pagelink);
            $output .= ' ';
            if ($i != $page || (!$more && 1 == $page)) {
                $output .= "{$before_link}" . _wp_link_page($i) . "{$link_before}{$j}{$link_after}</a>{$after_link}";
            } else {
                $output .= "{$current_before}{$link_before}<a>{$j}</a>{$link_after}{$current_after}";
            }
        }
        echo nokri_returnEcho($output . $after);
    }

}
/* ========================= */
/* Categories Count Function */
/* ========================= */
if (!function_exists('nokri_get_category_count')) {

    function nokri_get_category_count($input = '') {
        global $wpdb;
        if ($input == '') {
            $category = get_the_category();
            return $category[0]->category_count;
        } elseif (is_numeric($input)) {
            $SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$input";
            return $wpdb->get_var($SQL);
        } else {
            $SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->terms.slug='$input'";
            return $wpdb->get_var($SQL);
        }
    }

}
/* ========================= */
/*  Style Wp Default Search Widget */
/* ========================= */
if (!function_exists('nokri_search_form')) {

    function nokri_search_form($form) {
        $form = '<div class="search-blog">
							  <form role="search" method="get" class="search-form" id="searchform" action="' . esc_url(home_url('/')) . '">
							   <div class="input-group stylish-input-group">
								  <input class="form-control" placeholder="' . esc_html__('Search Here', 'nokri') . '" value="' . get_search_query() . '" name="s" type="search">
								  <span class="input-group-addon">
								  <button type="submit" ><span class="fa fa-search"></span></button>
								  </span> 
							   </div>
								</form> 
							</div>';
        return $form;
    }

}
add_filter('get_search_form', 'nokri_search_form');
/* ========================= */
/*  Exclude Pages from Search Results */
/* ========================= */
if (!function_exists('nokri_SearchFilter')) {

    function nokri_SearchFilter($query) {
        global $nokri;
        if ($query->is_search) {
            if (isset($nokri['sb_search_page']) && $nokri['sb_search_page'] != "" && is_page()) {
                if (get_page_template_slug($nokri['sb_search_page']) == get_page_template_slug(get_the_ID())) {

                    $query->set('post_type', 'job_post');
                }
            } else if (get_page_template_slug($nokri['sb_dashboard_page']) == get_page_template_slug(get_the_ID())) {
                $query->set('post_type', 'job_post');
            } else {
                $query->set('post_type', 'post');
            }
            return $query;
        }
    }

}
if (!is_admin()) {
    add_filter('pre_get_posts', 'nokri_SearchFilter');
}
/* ========================= */
/*  Wp Link Pages And Tags For Theme Check */
/* ========================= */
$args = '';
wp_link_pages($args);
the_tags();
/* ========================= */
/*     Page Break           */
/* ========================= */
/* Add Next Page Button in First Row */
add_filter('mce_buttons', 'nokri_next_page_button', 1, 2); // 1st row

/**
 * Add Next Page/Page Break Button
 * in WordPress Visual Editor
 * 
 * @link https://shellcreeper.com/?p=889
 */
function nokri_next_page_button($buttons, $id) {

    /* only add this for content editor */
    if ('content' != $id)
        return $buttons;

    /* add next page after more tag button */
    array_splice($buttons, 13, 0, 'wp_page');

    return $buttons;
}

/*
  Basic functions.
 */
/* ------------------------------------------------ */
/* nokri_close_tags */
/* ------------------------------------------------ */
if (!function_exists('nokri_close_tags')) {

    function nokri_close_tags($html) {
        preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];   #put all closed tags into an array
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count((array) $openedtags);

        if (count((array) $closedtags) == $len_opened) {

            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i = 0; $i < $len_opened; $i++) {

            if (!in_array($openedtags[$i], $closedtags)) {

                $html .= '</' . $openedtags[$i] . '>';
            } else {

                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }

}
/* ------------------------------------------------ */
/* Comments */
/* ------------------------------------------------ */
if (!function_exists('nokri_comments_list')) :

    function nokri_comments_list($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        global $nokri;
        $rtl_class = '';
        if (is_rtl()) {
            $rtl_class = "flip";
        }

        $img = '';
        if (get_avatar_url($comment, 44) != "") {
            $img = '<img class="pull-left ' . esc_attr($rtl_class) . ' hidden-xs img-circle" alt="' . esc_html__('Avatar', 'nokri') . '" src="' . esc_url(get_avatar_url($comment, 22)) . '" />';
        }
        ?>

        <li class="comment" id="comment-<?php esc_attr(comment_ID()); ?>">
            <div class="comment-info">
                <?php echo "" . $img; ?>
                <div class="author-desc">
                    <div class="author-title">
                        <strong><?php comment_author(); ?></strong>
                        <ul class="list-inline">
                            <li><a href="javascript:void(0);"><?php echo esc_html(get_comment_date()) . " " . esc_html(get_comment_time()); ?></a></li>
                            <?php
                            $myclass = ' active-color';
                            $reply_link = preg_replace('/comment-reply-link/', 'comment-reply-link ' . $myclass,
                                    get_comment_reply_link(array_merge($args, array('reply_text' => esc_html__('Reply', 'nokri'), 'depth' => $depth, 'max_depth' => $args['max_depth']))), 1);
                            ?>
                            <?php
                            if ($reply_link != "") {
                                ?>
                                <li><?php echo wp_kses($reply_link, nokri_required_tags()); ?>
                                    <?php
                                }
                                ?>
                            </li>
                        </ul>
                    </div>
                    <?php comment_text(); ?>
                </div>
            </div>
            <?php
            if ($args['has_children'] == "") {
                echo '</li>';
            }
            ?>
            <?php
        }

    endif;
    /* ------------------------------------------------ */
    /* Pagination */
    /* ------------------------------------------------ */
    if (!function_exists('nokri_pagination')) {

        function nokri_pagination() {
            if (is_singular()) {
                return;
            }
            global $wp_query;
            /** Stop execution if there's only 1 page */
            if ($wp_query->max_num_pages <= 1)
                return;

            $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
            $max = intval($wp_query->max_num_pages);

            /** 	Add current page to the array */
            if ($paged >= 1)
                $links[] = $paged;

            /** 	Add the pages around the current page to the array */
            if ($paged >= 3) {
                $links[] = $paged - 1;
                $links[] = $paged - 2;
            }

            if (( $paged + 2 ) <= $max) {
                $links[] = $paged + 2;
                $links[] = $paged + 1;
            }

            echo '<ul class="pagination pagination-large">' . "\n";

            if (get_previous_posts_link())
                printf('<li>%s</li>' . "\n", get_previous_posts_link());

            /** 	Link to first page, plus ellipses if necessary */
            if (!in_array(1, $links)) {
                $class = 1 == $paged ? ' class="active"' : '';

                printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

                if (!in_array(2, $links))
                    echo '<li><a href="javascript:void(0);">...</a></li>';
            }

            /** 	Link to current page, plus 2 pages in either direction if necessary */
            sort($links);
            foreach ((array) $links as $link) {
                $class = $paged == $link ? ' class="active"' : '';
                printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
            }

            /** 	Link to last page, plus ellipses if necessary */
            if (!in_array($max, $links)) {
                if (!in_array($max - 1, $links))
                    echo '<li><a href="javascript:void(0);">...</a></li>' . "\n";
                $class = $paged == $max ? ' class="active"' : '';
                printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
            }

            if (get_next_posts_link())
                printf('<li>%s</li>' . "\n", get_next_posts_link());
            echo '</ul>' . "\n";
        }

    }
    if (!function_exists('nokri_pagination_search')) {

        function nokri_pagination_search($wp_query) {
            if (is_singular())
            //return;
            //global $wp_query;
            /** Stop execution if there's only 1 page */
                if ($wp_query->max_num_pages <= 1)
                    return;

            $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
            $max = intval($wp_query->max_num_pages);

            /** 	Add current page to the array */
            if ($paged >= 1)
                $links[] = $paged;

            /** 	Add the pages around the current page to the array */
            if ($paged >= 3) {
                $links[] = $paged - 1;
                $links[] = $paged - 2;
            }

            if (( $paged + 2 ) <= $max) {
                $links[] = $paged + 2;
                $links[] = $paged + 1;
            }

            echo '<ul class="pagination pagination-lg">' . "\n";

            if (get_previous_posts_link())
                printf('<li>%s</li>' . "\n", get_previous_posts_link());

            /** 	Link to first page, plus ellipses if necessary */
            if (!in_array(1, $links)) {
                $class = 1 == $paged ? ' class="active"' : '';

                printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

                if (!in_array(2, $links))
                    echo '<li><a href="javascript:void(0);">...</a></li>';
            }

            /** 	Link to current page, plus 2 pages in either direction if necessary */
            sort($links);
            foreach ((array) $links as $link) {

                $class = $paged == $link ? ' class="active"' : '';
                printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
            }

            /** 	Link to last page, plus ellipses if necessary */
            if (!in_array($max, $links)) {
                if (!in_array($max - 1, $links))
                    echo '<li><a href="javascript:void(0);">...</a></li>' . "\n";
                $class = $paged == $max ? ' class="active"' : '';
                printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
            }


            if (get_next_posts_link_custom($wp_query))
                printf('<li>%s</li>' . "\n", get_next_posts_link_custom($wp_query));

            echo '</ul>' . "\n";
        }

    }
    if (!function_exists('get_next_posts_link_custom')) {

        function get_next_posts_link_custom($wp_query, $label = null, $max_page = 0) {
            global $paged;
            if (!$max_page)
                $max_page = $wp_query->max_num_pages;

            if (!$paged)
                $paged = 1;

            $nextpage = intval($paged) + 1;

            if (null === $label)
                $label = esc_html__('Next Page &raquo;', 'nokri');

            if ($nextpage <= $max_page) {
                /**
                 * Filters the anchor tag attributes for the next posts page link.
                 *
                 * @since 2.7.0
                 *
                 * @param string $attributes Attributes for the anchor tag.
                 */
                $attr = apply_filters('next_posts_link_attributes', '');

                return '<a href="' . next_posts($max_page, false) . "\" $attr>" . preg_replace('/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label) . '</a>';
            }
        }

    }
    if (!function_exists('nokri_getCatID')) {

// Return Category ID
        function nokri_getCatID() {
            return esc_html(get_cat_id(single_cat_title("", false)));
        }

    }
// get post description as per need. 
    if (!function_exists('nokri_words_count')) {

        function nokri_words_count($contect = '', $limit = 180) {
            $string = '';
            $contents = strip_tags(strip_shortcodes($contect));
            $contents = nokri_removeURL($contents);
            $removeSpaces = str_replace(" ", "", $contents);
            $contents = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $contents);
            if (strlen($removeSpaces) > $limit) {
                return substr(str_replace("&nbsp;", "", $contents), 0, $limit) . '...';
            } else {
                return str_replace("&nbsp;", "", $contents);
            }
        }

    }
    if (!function_exists('nokri_required_attributes')) {

        function nokri_required_attributes() {
            return $default_attribs = array(
                'id' => array(),
                'src' => array(),
                'href' => array(),
                'target' => array(),
                'class' => array(),
                'title' => array(),
                'type' => array(),
                'style' => array(),
                'data' => array(),
                'role' => array(),
                'aria-haspopup' => array(),
                'aria-expanded' => array(),
                'data-toggle' => array(),
                'data-hover' => array(),
                'data-animations' => array(),
                'data-mce-id' => array(),
                'data-mce-style' => array(),
                'data-mce-bogus' => array(),
                'data-href' => array(),
                'data-tabs' => array(),
                'data-small-header' => array(),
                'data-adapt-container-width' => array(),
                'data-height' => array(),
                'data-hide-cover' => array(),
                'data-show-facepile' => array(),
            );
        }

    }
    if (!function_exists('nokri_required_tags')) {

        function nokri_required_tags() {
            return $allowed_tags = array(
                'div' => nokri_required_attributes(),
                'span' => nokri_required_attributes(),
                'p' => nokri_required_attributes(),
                'a' => array_merge(nokri_required_attributes(), array(
                    'href' => array(),
                    'target' => array('_blank', '_top'),
                )),
                'u' => nokri_required_attributes(),
                'br' => nokri_required_attributes(),
                'i' => nokri_required_attributes(),
                'q' => nokri_required_attributes(),
                'b' => nokri_required_attributes(),
                'ul' => nokri_required_attributes(),
                'ol' => nokri_required_attributes(),
                'li' => nokri_required_attributes(),
                'br' => nokri_required_attributes(),
                'hr' => nokri_required_attributes(),
                'strong' => nokri_required_attributes(),
                'blockquote' => nokri_required_attributes(),
                'del' => nokri_required_attributes(),
                'strike' => nokri_required_attributes(),
                'em' => nokri_required_attributes(),
                'code' => nokri_required_attributes(),
                'style' => nokri_required_attributes(),
                'script' => nokri_required_attributes(),
                'img' => nokri_required_attributes(),
            );
        }

    }
// pages links
    paginate_comments_links();
    the_post_thumbnail();
// get feature image
    if (!function_exists('nokri_get_feature_image')) {

        function nokri_get_feature_image($post_id, $image_size) {
            return wp_get_attachment_image_src(get_post_thumbnail_id(esc_html($post_id)), $image_size);
        }

    }
    /* Add Next Page Button in First Row */
    add_filter('mce_buttons', 'nokri_my_next_page_button', 1, 2); // 1st row
    /**
     * Add Next Page/Page Break Button
     * in WordPress Visual Editor
     */
    if (!function_exists('nokri_my_next_page_button')) {

        function nokri_my_next_page_button($buttons, $id) {

            /* only add this for content editor */
            if ('content' != $id)
                return $buttons;

            /* add next page after more tag button */
            array_splice($buttons, 13, 0, 'wp_page');

            return $buttons;
        }

    }
// search only within posts.
    if (!function_exists('nokri_search_filter')) {

        function nokri_search_filter($query) {


            if ($query->is_author) {
                $query->set('post_type', array('job_post'));
            }

            return $query;
        }

    }
    if (!is_admin() && isset($_GET['type']) && $_GET['type'] == 'job_post') {
        //add_filter('pre_get_posts','nokri_search_filter');
    }
// get post format icon
    if (!function_exists('nokri_post_format_icon')) {

        function nokri_post_format_icon($format = '') {
            if ($format == "") {
                return 'ion-ios-star';
            }
            $format_icons = array('audio' => 'ion-volume-medium', 'video' => 'ion-videocamera', 'image' => 'ion-images', 'quote' => 'ion-quote');
            return $format_icons[$format];
        }

    }
// get current page url
    if (!function_exists('nokri_get_current_url')) {

        function nokri_get_current_url() {

            return $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }

    }
// return numbers array
    if (!function_exists('nokri_addNumbers')) {

        function nokri_addNumbers($r = 20) {
            $numArr = '';
            for ($i = 1; $i <= $r; $i++) {
                $numArr[$i] = $i;
            }
            return $numArr;
        }

    }
// check post format if exist
    if (!function_exists('nokri_post_format_exist')) {

        function nokri_post_format_exist($format = '') {
            $formats = array('', 'image', 'audio', 'video', 'quote');
            if (in_array($format, $formats)) {
                return true;
            } else {
                return false;
            }
        }

    }
    if (!function_exists('nokri_get_cats')) {

        function nokri_get_cats($taxonomy = 'category', $parent_of = 0, $child_of = 0, $no_hide = true) {
            global $nokri;
            $hide_empty = isset($nokri['sb_allow_empty_cats']) ? $nokri['sb_allow_empty_cats'] : false;
            $hide_empty_val = false;


            if ($hide_empty && 'job_category' == $taxonomy && $no_hide) {

                $hide_empty_val = true;
            }
            $defaults = array(
                'taxonomy' => $taxonomy,
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => $hide_empty_val,
                'exclude' => array(),
                'exclude_tree' => array(),
                'number' => '',
                'offset' => '',
                'fields' => 'all',
                'name' => '',
                'slug' => '',
                'hierarchical' => true,
                'search' => '',
                'name__like' => '',
                'description__like' => '',
                'pad_counts' => false,
                'get' => '',
                'child_of' => $child_of,
                'parent' => $parent_of,
                'childless' => false,
                'cache_domain' => 'core',
                'update_term_meta_cache' => true,
                'meta_query' => ''
            );
            $defaults = nokri_wpml_show_all_posts_callback($defaults);
            return get_terms($defaults);
        }

    }
// remove url from excerpt
    if (!function_exists('nokri_removeURL')) {

        function nokri_removeURL($string) {
            return preg_replace("/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i", '', $string);
        }

    }
// Get param value of VC
    if (!function_exists('nokri_get_param_vc')) {

        function nokri_get_param_vc($break, $string) {
            $arr = explode($break, $string);
            $res = explode(' ', $arr[1]);
            $r = explode('"', $res[0]);
            return $r[1];
        }

    }
// getting social icon array
    if (!function_exists('nokri_social_icons')) {

        function nokri_social_icons($social_network) {
            $social_icons = array(
                'Facebook' => 'fa fa-facebook',
                'Twitter' => 'fa fa-twitter ',
                'Linkedin' => 'fa fa-linkedin ',
                'Google' => 'fa fa-google-plus',
                'YouTube' => 'fa fa-youtube-play',
                'Vimeo' => 'fa fa-vimeo ',
                'Pinterest' => 'fa fa-pinterest ',
                'Tumblr' => 'fa fa-tumblr ',
                'Instagram' => 'fa fa-instagram',
                'Reddit' => 'fa fa-reddit ',
                'Flickr' => 'fa fa-flickr ',
                'StumbleUpon' => 'fa fa-stumbleupon',
                'Delicious' => 'fa fa-delicious ',
                'dribble' => 'fa fa-dribbble ',
                'behance' => 'fa fa-behance',
                'DeviantART' => 'fa fa-deviantart',
            );
            return $social_icons[$social_network];
        }

    }
    add_filter('wp_list_categories', 'nokri_cat_count_span');
    if (!function_exists('nokri_cat_count_span')) {

        function nokri_cat_count_span($links) {
            $links = str_replace('</a> (', '</a> <span class="pull-right">(', $links);
            $links = str_replace(')', ')</span>', $links);
            return $links;
        }

    }
// Translation
    if (!function_exists('nokri_translate')) {

        function nokri_translate($index) {
            $strings = array(
                'variation_not_available' => esc_html__('This product is currently out of stock and unavailable.', 'nokri'),
                'adding_to_cart' => esc_html__('Adding...', 'nokri'),
                'add_to_cart' => esc_html__('add to cart', 'nokri'),
                'view_cart' => esc_html__('View Cart', 'nokri'),
                'cart_success_msg' => esc_html__('Product Added successfully.', 'nokri'),
                'cart_success' => esc_html__('Success', 'nokri'),
                'cart_error_msg' => esc_html__('Something went wrong, please try it again.', 'nokri'),
                'cart_error' => esc_html__('Error', 'nokri'),
                'email_error_msg' => esc_html__('Please add valid email.', 'nokri'),
                'mc_success_msg' => esc_html__('Thank you, we will get back to you.', 'nokri'),
                'mc_error_msg' => esc_html__('There is some error, please check your API-KEY and LIST-ID.', 'nokri'),
            );


            return $strings[$index];
        }

    }
    if (!function_exists('nokri_get_comments')) {

        function nokri_get_comments() {
            echo get_comments_number() . " " . esc_html__('comments', 'nokri');
        }

    }
    if (!function_exists('nokri_get_date')) {

        function nokri_get_date($PID) {
            echo get_the_date(get_option('date_format'), $PID);
        }

    }
    if (isset($_GET['post_status']) && $_GET['post_status'] == 'trash' && $_GET['post_type'] == '_sb_country') {
        add_action('admin_notices', 'nokri_notice_for_delete_country');
    }
    if (!function_exists('nokri_notice_for_delete_country')) {

        function nokri_notice_for_delete_country() {
            ?>
            <div class="notice notice-info">
                <strong><p><?php echo esc_html__('If you delete country permanently then all associated states and cities will be deleted with it.', 'nokri'); ?></p></strong>
            </div>	
            <?php
        }

    }
    if (isset($_GET['post_type'])) {
        if ($_GET['post_type'] == '_sb_country') {
            add_action('admin_notices', 'nokri_notice_for_add_country');
        }
    }
    if (!function_exists('nokri_notice_for_add_country')) {

        function nokri_notice_for_add_country() {
            ?>
            <div class="notice notice-info">
                <p><?php echo esc_html__('Must need to aad country NAME as google list like United Arab Emirates, check it', 'nokri'); ?>
                    <a href="https://developers.google.com/public-data/docs/canonical/countries_csv" target="_blank">
                        <strong><?php echo esc_html__('HERE', 'nokri'); ?></strong>
                    </a>
                </p>
            </div>	
            <?php
        }

    }
    if (!function_exists('nokri_redirect')) {

        function nokri_redirect($url = '') {
            return '<script>window.location = "' . $url . '";</script>';
        }

    }
    add_action('init', 'nokri_StartSession', 1);
    if (!function_exists('nokri_StartSession')) {

        function nokri_StartSession() {
            if (!session_id()) {
                //   session_start();
            }
        }

    }
// Bad word filter
    if (!function_exists('nokri_badwords_filter')) {

        function nokri_badwords_filter($words = array(), $string = "", $replacement = "") {
            foreach ($words as $word) {
                $string = str_replace($word, $replacement, $string);
            }
            return $string;
        }

    }
// Time Ago
    if (!function_exists('nokri_timeago')) {

        function nokri_timeago($date) {
            $timestamp = strtotime($date);

            $strTime = array(esc_html__('second', 'nokri'), esc_html__('minute', 'nokri'), esc_html__('hour', 'nokri'), esc_html__('day', 'nokri'), esc_html__('month', 'nokri'), esc_html__('year', 'nokri'));
            $length = array("60", "60", "24", "30", "12", "10");

            $currentTime = time();
            if ($currentTime >= $timestamp) {
                $diff = time() - $timestamp;
                for ($i = 0; $diff >= $length[$i] && $i < count((array) $length) - 1; $i++) {
                    $diff = $diff / $length[$i];
                }

                $diff = round($diff);
                return $diff . " " . $strTime[$i] . esc_html__('(s) ago', 'nokri');
            }
        }

    }
// nokri search params
    if (!function_exists('nokri_search_params')) {

        function nokri_search_params($index, $second = '') {

            $param = $_SERVER['QUERY_STRING'];
            $res = '';
            if (isset($param)) {
                parse_str($_SERVER['QUERY_STRING'], $vars);
                foreach ($vars as $key => $val) {
                    if ($key == $index)
                        continue;

                    if ($second != "") {
                        if ($key == $second)
                            continue;
                    }

                    if (isset($vars['custom']) && count((array) $vars['custom']) > 0 && 'custom' == $key) {
                        foreach ($vars['custom'] as $ckey => $cval) {
                            $name = "custom[$ckey]";
                            if ($name == $index) {
                                continue;
                            }
                            $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                        }
                    } else {

                        if (!array($val)) {
                            $res .= '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" />';
                        }
                    }
                }
            }
            return $res;
        }

    }
// Get parents of custom taxonomy
    if (!function_exists('nokri_get_taxonomy_parents')) {

        function nokri_get_taxonomy_parents($id, $taxonomy, $link = true, $separator = ' &raquo; ', $nicename = false, $visited = array()) {

            $chain = '';

            $parent = get_term($id, $taxonomy);

            if (is_wp_error($parent)) {
                echo esc_html("Fail", "nokri");
                return $parent;
            }

            if ($nicename) {
                $name = $parent->slug;
            } else {
                $name = $parent->name;
            }

            if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) {

                $visited[] = $parent->parent;

                $chain .= nokri_get_taxonomy_parents($parent->parent, $taxonomy, $link, $separator, $nicename, $visited);
            }

            if ($link) {
                $chain .= '<a href="' . esc_url(get_term_link((int) $parent->term_id, $taxonomy)) . '" title="' . esc_attr(sprintf(esc_html__("View all posts in %s", 'nokri'), $parent->name)) . '">' . $name . '</a>' . $separator;
            } else {
                $chain .= $separator . $name;
            }
            return $chain;
        }

    }
    if (!function_exists('nokri_display_cats')) {

        function nokri_display_cats($pid) {
            global $nokri;
            $type = '';
            $link = '';
            if (isset($nokri['cat_and_location']) && $nokri['cat_and_location'] != '') {
                $type = $nokri_theme['cat_and_location'];
                $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
                $cats_html = '';
                foreach ($post_categories as $c) {
                    $cat = get_category($c);
                    if ($type == 'search') {
                        $link = get_the_permalink($nokri['sb_search_page']) . '?cat-id=' . $cat->term_id;
                    } else {
                        $link = get_category_link($cat->term_id);
                    }
                    $cats_html .= '<span class="padding_cats"><a href="' . $link . '">' . esc_html($cat->name) . '</a></span>';
                }
                return $cats_html;
            }
        }

    }
    if (!function_exists('nokri_removeCPTCommentsFromWidget')) {

        function nokri_removeCPTCommentsFromWidget($example) {
            $ar = array('post_type' => 'post');
            return $ar;
        }

    }
    add_filter('widget_comments_args', 'nokri_removeCPTCommentsFromWidget');
    if (!function_exists('nokri_randomString')) {

        function nokri_randomString($length = 50) {
            $str = "";
            $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
            $max = count((array) $characters) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $str .= $characters[$rand];
            }
            return $str;
        }

    }
    if (!function_exists('nokri_canidate_apply_status')) {

        function nokri_canidate_apply_status($getName = '') {
            $arr = array(
                "0" => __("Received", 'nokri'),
                "1" => __("In Review", 'nokri'),
                "2" => __("Rejected ", 'nokri'),
                "3" => __("Shortlist", 'nokri'),
                "4" => __("Interview", 'nokri'),
                "5" => __("Selected", 'nokri'),
            );
            return ( $getName == "" ) ? $arr : $arr["$getName"];
        }

    }
    if (!function_exists('nokri_get_resumes_list')) {

        function nokri_get_resumes_list($user_id = '') {
            global $wpdb;
            /* Query For Getting All Resumes Against Job */
            $query = "SELECT meta_key, meta_value FROM $wpdb->usermeta WHERE user_id = '$user_id' AND meta_key like '_email_temp_name_$user_id%' ";
            $resumes = $wpdb->get_results($query);

            $data = array();
            foreach ($resumes as $resume) {
                $temps = nokri_base64Decode($resume->meta_value);
                $value = json_decode($temps, true);
                $data["$resume->meta_key"] = $value;
            }
            return $data;
        }

    }
    /* Setting up employer and canidate links starts */
    add_action('init', 'nokri_wpse17106_init');

    function nokri_wpse17106_init() {
        global $nokri;
        /* Employer slug */
        $employer_slug = ( isset($nokri['employer_txt']) && $nokri['employer_txt'] != "" ) ? $nokri['employer_txt'] : 'employer';
        /* Candidate slug */
        $candidate_slug = ( isset($nokri['candidate_txt']) && $nokri['candidate_txt'] != "" ) ? $nokri['candidate_txt'] : 'candidate';
        global $wp_rewrite;
        $author_levels = array($employer_slug, $candidate_slug);
        add_rewrite_tag('%author_level%', '(' . implode('|', $author_levels) . ')');
        $wp_rewrite->author_base = '%author_level%';
    }

    add_filter('author_rewrite_rules', 'nokri_wpse17106_author_rewrite_rules');

    function nokri_wpse17106_author_rewrite_rules($author_rewrite_rules) {
        foreach ($author_rewrite_rules as $pattern => $substitution) {
            if (FALSE === strpos($substitution, 'author_name')) {
                unset($author_rewrite_rules[$pattern]);
            }
        }
        return $author_rewrite_rules;
    }

    add_filter('author_link', 'nokri_wpse17106_author_link', 10, 2);

    function nokri_wpse17106_author_link($link, $author_id) {
        global $nokri;
        /* Employer slug */
        $employer_slug = ( isset($nokri['employer_txt']) && $nokri['employer_txt'] != "" ) ? $nokri['employer_txt'] : 'employer';
        /* Candidate slug */
        $candidate_slug = ( isset($nokri['candidate_txt']) && $nokri['candidate_txt'] != "" ) ? $nokri['candidate_txt'] : 'candidate';
        $author_levels = '';
        get_user_meta($author_id, '_sb_reg_type', true);

        if (get_user_meta($author_id, '_sb_reg_type', true) == 1) {
            $author_levels = $employer_slug;
        } else if (get_user_meta($author_id, '_sb_reg_type', true) == 0) {
            $author_levels = $candidate_slug;
        }

        if ($author_levels != "") {
            $link = str_replace('%author_level%', $author_levels, $link);
        }

        return $link;
    }

    /* Setting up employer and canidate links ends */
//then add users to query_vars:
    add_filter('query_vars', 'users_query_vars');

    function users_query_vars($vars) {
        // add lid to the valid list of variables
        $new_vars = array('users');
        $vars = $new_vars + $vars;
        return $vars;
    }

//
    function user_rewrite_rules($wp_rewrite) {
        $newrules = array();
        $new_rules['users/(\d*)$'] = 'index.php?author=$matches[1]';
        $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
    }

    add_filter('generate_rewrite_rules', 'user_rewrite_rules');
    if (!function_exists('nokri_static_strings')) {

        function nokri_static_strings() {
            global $nokri;
            if (is_rtl()) {
                $custom_js = 'nokri-custom-rtl';
            } else {
                $custom_js = 'nokri-custom';
            }
            /* Map type */
            $mapType = nokri_mapType();
            $is_sticky_menu = isset($nokri['is_sticky_menu']) ? $nokri['is_sticky_menu'] : false;
            if ($is_sticky_menu) {
                $is_sticky_menu = true;
            }
            wp_localize_script(
                    $custom_js, // name of js file
                    'get_strings',
                    array(
                        /* Generic Texts */
                        'confirmation' => esc_html__('Confirmation!', 'nokri'),
                        'content' => esc_html__('Are you sure you want to do this?', 'nokri'),
                        'btn_cnfrm' => esc_html__('Confirm', 'nokri'),
                        'btn_cancel' => esc_html__('Cancel', 'nokri'),
                        'success' => esc_html__('Success!', 'nokri'),
                        'action_success' => esc_html__('Action performed successfully', 'nokri'),
                        'action_remove' => esc_html__('Remove File', 'nokri'),
                        'browse_btn' => esc_html__('Browse', 'nokri'),
                        'remove_btn' => esc_html__('Remove', 'nokri'),
                        'select_btn' => nokri_feilds_label('emp_dp_plc', esc_html__('Select file', 'nokri')),
                        'new_btn' => esc_html__('New', 'nokri'),
                        'showNumber' => esc_html__('Show Number', 'nokri'),
                        'no_res' => esc_html__('No results found', 'nokri'),
                        'is_cat_temp' => isset($nokri['job_post_form']) ? $nokri['job_post_form'] : '0',
                        'external_apply' => esc_html__('You are redirecting to external apply ', 'nokri'),
                        'max_select' => esc_html__('You can select only ', 'nokri'),
                        /* For Regteration Email */
                        'rgstr_info' => esc_html__('Information', 'nokri'),
                        'rgstr_resend' => esc_html__('Resend email', 'nokri'),
                        'rgstr_close' => esc_html__('Close', 'nokri'),
                        /* For Skills */
                        'skillshead' => esc_html__('Add another skill (new)', 'nokri'),
                        'skilltitle' => esc_html__('Skill Title', 'nokri'),
                        'skillvalue' => esc_html__('Skill Value', 'nokri'),
                        'degremov' => esc_html__('Remove', 'nokri'),
                        /* For Certifications */
                        'certhead' => esc_html__('Certification additional field', 'nokri'),
                        'certtitle' => esc_html__('Certification title', 'nokri'),
                        'certstrt' => esc_html__('Certification start', 'nokri'),
                        'certend' => esc_html__('Certification end', 'nokri'),
                        'certdur' => esc_html__('Certification duration', 'nokri'),
                        'certinst' => esc_html__('Certification institute', 'nokri'),
                        'certdesc' => esc_html__('Certification description', 'nokri'),
                        /* For Selects Resumes */
                        'resume_select' => esc_html__('Select your resume', 'nokri'),
                        /* For Selects Resumes */
                        'template_select' => esc_html__('Select email template', 'nokri'),
                        'select_placeholder' => esc_html__('Select option', 'nokri'),
                        /* For Selects Options */
                        'option_select' => esc_html__('Select an option', 'nokri'),
                        /* For Skill Tags */
                        'select_tags' => esc_html__('Set skill percentage value (only integers)', 'nokri'),
                        /* For jobs Tags */
                        'select_jobs_tags' => esc_html__('Add tags', 'nokri'),
                        /* For General Tags */
                        'select_tags_gen' => esc_html__('Add a tag', 'nokri'),
                        /* For Already Aplly */
                        'apply_msg' => esc_html__('Oooooppss!!', 'nokri'),
                        'apply_details' => esc_html__('You have already apllied on this job', 'nokri'),
                        'cand_status_change' => esc_html__('Candidate has moved to viewed profile', 'nokri'),
                        /* For Datepicker */
                        'one' => __('One Star', 'nokri'),
                        'two' => __('Two Stars', 'nokri'),
                        'three' => __('Three Stars', 'nokri'),
                        'four' => __('Four Stars', 'nokri'),
                        'five' => __('Five Stars', 'nokri'),
                        'noStars' => __('Not Rated', 'nokri'),
                        'Sunday' => __('Sunday', 'nokri'),
                        'Monday' => __('Monday', 'nokri'),
                        'Tuesday' => __('Tuesday', 'nokri'),
                        'Wednesday' => __('Wednesday', 'nokri'),
                        'Thursday' => __('Thursday', 'nokri'),
                        'Friday' => __('Friday', 'nokri'),
                        'Saturday' => __('Saturday', 'nokri'),
                        'Sun' => __('Sun', 'nokri'),
                        'Mon' => __('Mon', 'nokri'),
                        'Tue' => __('Tue', 'nokri'),
                        'Wed' => __('Wed', 'nokri'),
                        'Thu' => __('Thu', 'nokri'),
                        'Fri' => __('Fri', 'nokri'),
                        'Sat' => __('Sat', 'nokri'),
                        'Su' => __('Su', 'nokri'),
                        'Mo' => __('Mo', 'nokri'),
                        'Tu' => __('Tu', 'nokri'),
                        'We' => __('We', 'nokri'),
                        'Th' => __('Th', 'nokri'),
                        'Fr' => __('Fr', 'nokri'),
                        'Sa' => __('Sa', 'nokri'),
                        'January' => __('January', 'nokri'),
                        'February' => __('February', 'nokri'),
                        'March' => __('March', 'nokri'),
                        'April' => __('April', 'nokri'),
                        'May' => __('May', 'nokri'),
                        'June' => __('June', 'nokri'),
                        'July' => __('July', 'nokri'),
                        'August' => __('August', 'nokri'),
                        'September' => __('September', 'nokri'),
                        'October' => __('October', 'nokri'),
                        'November' => __('November', 'nokri'),
                        'December' => __('December', 'nokri'),
                        'Jan' => __('Jan', 'nokri'),
                        'Feb' => __('Feb', 'nokri'),
                        'Mar' => __('Mar', 'nokri'),
                        'Apr' => __('Apr', 'nokri'),
                        'May' => __('May', 'nokri'),
                        'Jun' => __('Jun', 'nokri'),
                        'Jul' => __('July', 'nokri'),
                        'Aug' => __('Aug', 'nokri'),
                        'Sep' => __('Sep', 'nokri'),
                        'Oct' => __('Oct', 'nokri'),
                        'Nov' => __('Nov', 'nokri'),
                        'Dec' => __('Dec', 'nokri'),
                        'Today' => __('Today', 'nokri'),
                        'Clear' => __('Clear', 'nokri'),
                        'dateFormat' => __('dateFormat', 'nokri'),
                        'timeFormat' => __('timeFormat', 'nokri'),
                        /* For editor */
                        'p_text' => __('Paragraph', 'nokri'),
                        'nokri_map_type' => $mapType,
                        /* For sticky header */
                        'is_sticky_menu' => $is_sticky_menu,
                        /* For apply */
                        'apply_without' => esc_html__('Applied successfully', 'nokri'),
                        /* For apply */
                        'apply_with' => esc_html__('Applied successfully', 'nokri'),
                        /* For Education */
                        'quali_inst' => nokri_feilds_operat('cand_quali_inst', 'show'),
                        's_date' => nokri_feilds_operat('cand_quali_start', 'show'),
                        'e_date' => nokri_feilds_operat('cand_quali_end', 'show'),
                        'percent' => nokri_feilds_operat('cand_quali_percent', 'show'),
                        'grade' => nokri_feilds_operat('cand_quali_grades', 'show'),
                        'desc' => nokri_feilds_operat('cand_quali_desc', 'show'),
                        /* Titles and placeholders */
                        'deghead' => nokri_feilds_label('cand_quali_add_new', esc_html__('Qualification Title', 'nokri')),
                        'degremov' => nokri_feilds_label('cand_quali_rem', esc_html__('Remove', 'nokri')),
                        /* For degree title feild */
                        'degtitle' => nokri_feilds_label('cand_quali_label', esc_html__('Qualification Title', 'nokri')),
                        'deg_plc' => nokri_feilds_label('cand_quali_plc', esc_html__('Degree Title', 'nokri')),
                        'deg_req' => nokri_feilds_operat('cand_quali_title', 'required'),
                        /* For degree institute feild */
                        'inst_title' => nokri_feilds_label('cand_inst_label', esc_html__('Institute Name', 'nokri')),
                        'inst_plc' => nokri_feilds_label('cand_inst_plc', esc_html__('Institute Name', 'nokri')),
                        'inst_req' => nokri_feilds_operat('cand_quali_inst', 'required'),
                        /* For degree Start date feild */
                        'sdate_title' => nokri_feilds_label('cand_quali_start_label', esc_html__('Start Date', 'nokri')),
                        'sdate_req' => nokri_feilds_operat('cand_quali_inst', 'required'),
                        /* For degree end date feild */
                        'edate_title' => nokri_feilds_label('cand_quali_end_label', esc_html__('End Date', 'nokri')),
                        'edate_req' => nokri_feilds_operat('cand_quali_end', 'required'),
                        /* For degree Percentage feild */
                        'perc_title' => nokri_feilds_label('cand_quali_percent_label', esc_html__('Percentage', 'nokri')),
                        'perc_plc' => nokri_feilds_label('cand_quali_percent_plc', esc_html__('Only digits allowed without % sign e.g 80.0', 'nokri')),
                        'perc_req' => nokri_feilds_operat('cand_quali_end', 'required'),
                        /* For degree Grades feild */
                        'grad_title' => nokri_feilds_label('cand_quali_grades_label', esc_html__('Grades', 'nokri')),
                        'grad_plc' => nokri_feilds_label('cand_quali_grades_plc', esc_html__('Only Grade Letter e.g A+,B,C', 'nokri')),
                        'grad_req' => nokri_feilds_operat('cand_quali_grades', 'required'),
                        /* For degree end date feild */
                        'desc_title' => nokri_feilds_label('cand_quali_desc_label', esc_html__('Description', 'nokri')),
                        'desc_req' => nokri_feilds_operat('cand_quali_desc', 'required'),
                        /* For Job Experience */
                        /* Titles and placeholders */
                        'prof_head' => nokri_feilds_label('cand_exper_add_new', esc_html__('Profession additional field', 'nokri')),
                        'prof_remov' => nokri_feilds_label('cand_exper_rem', esc_html__('Remove', 'nokri')),
                        /* For Organization */
                        'org_title' => nokri_feilds_label('cand_org_label', esc_html__('Organization Name', 'nokri')),
                        'org_plc' => nokri_feilds_label('cand_org_plc', esc_html__('Organization Name', 'nokri')),
                        'org_req' => nokri_feilds_operat('cand_quali_desc', 'required'),
                        /* For Your Role */
                        'prof_role' => nokri_feilds_operat('cand_exper_role', 'show'),
                        'role_title' => nokri_feilds_label('cand_exper_role_label', esc_html__('Your Role', 'nokri')),
                        'role_plc' => nokri_feilds_label('cand_exper_role_plc', esc_html__('Software Engineer Etc', 'nokri')),
                        'role_req' => nokri_feilds_operat('cand_exper_role', 'required'),
                        /* For job Start date feild */
                        'strt_show' => nokri_feilds_operat('cand_exper_start', 'show'),
                        'strt_title' => nokri_feilds_label('cand_exper_start_label', esc_html__('Job start Date', 'nokri')),
                        'strt_req' => nokri_feilds_operat('cand_exper_start', 'required'),
                        /* For job end date feild */
                        'edate_show' => nokri_feilds_operat('cand_exper_end', 'show'),
                        'edate_title' => nokri_feilds_label('cand_exper_end_label', esc_html__('Job End Date', 'nokri')),
                        'edate_req' => nokri_feilds_operat('cand_exper_end', 'required'),
                        'edate_curr' => nokri_feilds_label('cand_exper_current_label', esc_html__('Are You Currently Working There?', 'nokri')),
                        /* For profession desc */
                        'desc_show' => nokri_feilds_operat('cand_exper_desc', 'show'),
                        'desc_title' => nokri_feilds_label('cand_exper_desc_label', esc_html__('Description', 'nokri')),
                        'desc_req' => nokri_feilds_operat('cand_exper_desc', 'required'),
                        /* For Certifications */
                        /* Titles and placeholders */
                        'cert_head' => nokri_feilds_label('cand_exper_add_new', esc_html__('Certification additional field', 'nokri')),
                        'cert_remov' => nokri_feilds_label('cand_exper_rem', esc_html__('Remove', 'nokri')),
                        /* For Certification Title */
                        'certi_title' => nokri_feilds_label('cand_certi_label', esc_html__('Certification Title', 'nokri')),
                        'certi_plc' => nokri_feilds_label('cand_certi_plc', esc_html__('Certification Title', 'nokri')),
                        'certi_req' => nokri_feilds_operat('cand_certi_title', 'required'),
                        /* For certification Start date feild */
                        'certi_sdate_show' => nokri_feilds_operat('cand_certi_start', 'show'),
                        'certi_sdate_title' => nokri_feilds_label('cand_certi_start_label', esc_html__('Certification Start Date', 'nokri')),
                        'certi_sdate_req' => nokri_feilds_operat('cand_certi_start', 'required'),
                        /* For certification end date feild */
                        'certi_edate_show' => nokri_feilds_operat('cand_certi_end', 'show'),
                        'certi_edate_title' => nokri_feilds_label('cand_certi_end_label', esc_html__('Certification End Date', 'nokri')),
                        'certi_edate_req' => nokri_feilds_operat('cand_certi_end', 'required'),
                        /* For certification duration */
                        'certi_dur_show' => nokri_feilds_operat('cand_certi_dur', 'show'),
                        'certi_dur_title' => nokri_feilds_label('cand_certi_dur_label', esc_html__('Certification Duration', 'nokri')),
                        'certi_dur_plc' => nokri_feilds_label('cand_certi_dur_plc', esc_html__('Certification Duration', 'nokri')),
                        'certi_dur_req' => nokri_feilds_operat('cand_certi_dur', 'required'),
                        /* For institute name duration */
                        'certi_inst_show' => nokri_feilds_operat('cand_certi_inst', 'show'),
                        'certi_inst_title' => nokri_feilds_label('cand_certi_inst_label', esc_html__('Certification Institute', 'nokri')),
                        'certi_inst_plc' => nokri_feilds_label('cand_certi_inst_plc', esc_html__('Certification Institute', 'nokri')),
                        'certi_inst_req' => nokri_feilds_operat('cand_certi_inst', 'required'),
                        /* For profession desc */
                        'desc_show' => nokri_feilds_operat('cand_certi_desc', 'show'),
                        'desc_title' => nokri_feilds_label('cand_quali_certi_label', esc_html__('Description', 'nokri')),
                        'desc_req' => nokri_feilds_operat('cand_certi_desc', 'required'),
                        'password_confirm' => esc_html__('Password does not match', 'nokri'),
                        'no_resume' => esc_html__('No Resumes found', 'nokri'),
                        'resume_video_limit' => isset($nokri['cand_video_resume_limit']) ? $nokri['cand_video_resume_limit'] : 2,
                        'nonce' => wp_create_nonce('ajax-nonce'),
                        'verification_message' => esc_html__('Verification code is sent to', 'nokri'),
                        'lowercase_validation' => esc_html__('password must contain at least 1 lowercas letter.', 'nokri'),
                        'uppercase_validation' => esc_html__('password must contain at least 1 uppercase letter.', 'nokri'),
                        'number_validation' => esc_html__('password must contain at least 1 number.', 'nokri'),
                        'limit_validation' => esc_html__('password must be 8 digit', 'nokri'),
                        'no_bump_up' => esc_html__('Don not have more bump up', 'nokri'),
                        /* Graphs Chart */
                        'posted_jobs' => esc_html__('Posted Jobs', 'nokri'),
                        'graph_months' => esc_html__('Month', 'nokri'),
                        'jobs_posted' => esc_html__('Jobs Posted', 'nokri'),
                        'post_job_details' => esc_html__('Job Post Details', 'nokri'),
                        'received_res' => esc_html__('Received Resumes', 'nokri'),
                        'res_receiving_date' => esc_html__('Resume Receiving Date', 'nokri'),
                        'total_res' => esc_html__('Total Resumes', 'nokri'),
                        'res_details' => esc_html__('Resume Details', 'nokri'),
                        'job_post_details' => esc_html__('Job Post Details', 'nokri'),
                        'resume_recv_date' => esc_html__('Resume Receiving Date', 'nokri'),
                        'cand_res_details' => esc_html__('Resume Details', 'nokri'),
                        'cand_job_applied' => esc_html__('Jobs Applied ', 'nokri'),
                        'cand_applied_date' => esc_html__('Applied Date', 'nokri'),
                        'cand_applied_jobs' => esc_html__('Applied on Jobs', 'nokri'),
                    )
            );
        }

        add_action('wp_enqueue_scripts', 'nokri_static_strings', 100);
    }
    /* For Childs Categories */
    if (!function_exists('nokri_get_jobs_cats')) {

        function nokri_get_jobs_cats($id, $by = 'name', $for_country = false) {
            $taxonomy = 'job_category'; //Put your custom taxonomy term here

            if ($for_country) {
                $taxonomy = 'ad_location';
            } else {
                $taxonomy = 'job_category'; //Put your custom taxonomy term here
            }

            $terms = wp_get_post_terms($id, $taxonomy);
            $cats = array();
            $myparentID = '';
            foreach ($terms as $term) {
                if ($term->parent == 0) {
                    $myparent = $term;
                    $myparentID = $myparent->term_id;
                    $cats[] = array('name' => $myparent->name, 'id' => $myparent->term_id);
                    break;
                }
            }

            if ($myparentID != "") {
                $mychildID = '';
                // Right, the parent is set, now let's get the children
                foreach ($terms as $term) {
                    if ($term->parent == $myparentID) { // this ignores the parent of the current post taxonomy
                        $child_term = $term; // this gets the children of the current post taxonomy	
                        $mychildID = $child_term->term_id;
                        $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                        break;
                    }
                }
                if ($mychildID != "") {
                    $mychildchildID = '';
                    // Right, the parent is set, now let's get the children
                    foreach ($terms as $term) {
                        if ($term->parent == $mychildID) { // this ignores the parent of the current post taxonomy
                            $child_term = $term; // this gets the children of the current post taxonomy
                            $mychildchildID = $child_term->term_id;
                            $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                            break;
                        }
                    }
                    if ($mychildchildID != "") {
                        // Right, the parent is set, now let's get the children
                        foreach ($terms as $term) {
                            if ($term->parent == $mychildchildID) { // this ignores the parent of the current post taxonomy
                                $child_term = $term; // this gets the children of the current post taxonomy	  
                                $cats[] = array('name' => $child_term->name, 'id' => $child_term->term_id);
                                break;
                            }
                        }
                    }
                }
            }
            return $cats;
            $post_categories = wp_get_object_terms($id, array('ad_cats'), array('orderby' => 'term_group'));
            $cats = array();
            foreach ($post_categories as $c) {
                $cat = get_term($c);
                $cats[] = array('name' => $cat->name, 'id' => $cat->term_id);
            }
            return $cats;
        }

    }
    add_filter('register_post_type_args', 'nokri_register_post_type_args', 10, 2);
    if (!function_exists('nokri_register_post_type_args')) {

        function nokri_register_post_type_args($args, $post_type) {

            $nokri_theme_values = get_option('nokri');
            if (isset($nokri_theme_values['sb_url_rewriting_enable']) && $nokri_theme_values['sb_url_rewriting_enable'] && isset($nokri_theme_values['sb_ad_slug']) && $nokri_theme_values['sb_ad_slug'] != "") {
                if ('job_post' === $post_type) {
                    $old_slug = 'job_post';
                    if (get_option('sb_ad_old_slug') != "") {
                        $old_slug = get_option('sb_ad_old_slug');
                    }
                    $args['rewrite']['slug'] = $nokri_theme_values['sb_ad_slug'];
                    update_option('sb_ad_old_slug', $nokri_theme_values['sb_ad_slug']);
                    if (($current_rules = get_option('rewrite_rules'))) {
                        foreach ($current_rules as $key => $val) {
                            if (strpos($key, $old_slug) !== false) {
                                add_rewrite_rule(str_ireplace($old_slug, $nokri_theme_values['sb_ad_slug'], $key), $val, 'top');
                            }
                        }
                    }
                }
            }
            return $args;
        }

    }

    function remove_empty_tags_recursive($str, $repto = NULL) {
        //** Return if string not given or empty.
        if (!is_string($str) || trim($str) == '')
            return $str;

        //** Recursive empty HTML tags.
        return preg_replace(
                '/<([^<\/>]*)>([\s]*?|(?R))<\/\1>/imsU',
                //** Replace with nothing if string empty.
                !is_string($repto) ? '' : $repto,
                //** Source string
                $str
        );
    }

    /* Hiding admin bar css */
    add_action('get_header', 'nokri_listing_remove_admin_login_header');

    function nokri_listing_remove_admin_login_header() {
        remove_action('wp_head', '_admin_bar_bump_cb');
    }

    /*     * *********************** */
    /* Radius Search Function  */
    /*     * *********************** */
    if (!function_exists('nokri_radius_search_theme')) {

        function nokri_radius_search_theme($data_arr = array(), $check_db = true) {

            $data = array();
            $user_id = get_current_user_id();
            $success = false;

            if (isset($data_arr) && !empty($data_arr)) {
                $nearby_data = $data_arr;
            }

            if (isset($nearby_data) && $nearby_data != "") {

                //array("latitude" => $latitude, "longitude" => $longitude, "distance" => $distance );
                $original_lat = $nearby_data['latitude'];
                $original_long = $nearby_data['longitude'];
                $distance = $nearby_data['distance'];

                $lat = $original_lat; //latitude
                $lon = $original_long; //longitude
                $distance = $distance; //your distance in KM
                $R = 6371.009; //constant earth radius. You can add precision here if you wish

                $maxLat = $lat + rad2deg($distance / $R);
                $minLat = $lat - rad2deg($distance / $R);
                $maxLon = $lon + rad2deg(asin($distance / $R) / @cos(deg2rad($lat)));
                $minLon = $lon - rad2deg(asin($distance / $R) / @cos(deg2rad($lat)));

                $data['radius'] = $R;
                $data['distance'] = $distance;
                $data['lat']['original'] = $original_lat;
                $data['long']['original'] = $original_long;
                $data['lat']['min'] = $minLat;
                $data['lat']['max'] = $maxLat;
                $data['long']['min'] = $minLon;
                $data['long']['max'] = $maxLon;
            }


            return $data;
        }

    }
    /* ======================================== */
    /* Getting candiates job alerts Frequency   */
    /* ======================================== */
    if (!function_exists('nokri_get_candidates_job_alerts_freq')) {

        function nokri_get_candidates_job_alerts_freq($getvalue = '') {
            $frequency_array = array(
                "1" => __("Daily", 'nokri'),
                "7" => __("Weekly", 'nokri'),
                "15" => __("Fortnightly", 'nokri'),
                "30" => __("Monthly", 'nokri'),
                "12" => __("Yearly", 'nokri'),
            );
            return ( $getvalue == "" ) ? $frequency_array : $frequency_array["$getvalue"];
        }

    }
    /* ============================== */
    /* Getting candiates job alerts */
    /* =============================== */
    if (!function_exists('nokri_get_candidates_job_alerts')) {

        function nokri_get_candidates_job_alerts($user_id = '') {
            global $wpdb;
            /* Query For Getting All Resumes Against Job */
            $query = "SELECT meta_key, meta_value FROM $wpdb->usermeta WHERE user_id = '$user_id' AND meta_key like '_cand_alerts_$user_id%' ";
            $resumes = $wpdb->get_results($query);
            $data = array();
            foreach ($resumes as $resume) {
                $value = json_decode($resume->meta_value, true);
                $data["$resume->meta_key"] = $value;
            }
            return $data;
        }

    }
// Get sub cats
    add_action('wp_ajax_get_child_lev1', 'nokri_get_child_lev1');
    add_action('wp_ajax_nopriv_nokri_get_child_lev1', 'nokri_get_child_lev1');
    if (!function_exists('nokri_get_child_lev1')) {

        function nokri_get_child_lev1() {
            global $nokri;
            $heading = (isset($nokri['cat_level_2']) && $nokri['cat_level_2'] != "") ? $nokri['cat_level_2'] : "";
            $cat_id = $_POST['cat_id'];
            $taxanomy = isset($_POST['tax']) ? $_POST['tax'] : "";
            if ($taxanomy == 'ad_location') {
                $tax = 'ad_location';
                $heading = (isset($nokri['job_country_level_2']) && $nokri['job_country_level_2'] != "") ? $nokri['job_country_level_2'] : "";
                $id = 'child_lev1_loc';
            } else {
                $tax = 'job_category';
                $id = 'child_lev1';
            }
            $ad_cats = nokri_get_cats($tax, $cat_id);
            $res = '';
            if (count((array) $ad_cats) > 0) {
                $res .= '<label>' . $heading . '</label>';
                $res .= '<select class="questions-category form-control"  id="' . $id . '">';
                $res .= '<option label="' . esc_html__('Select Option', 'nokri') . '"></option>';
                foreach ($ad_cats as $ad_cat) {
                    $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '</option>';
                }
                $res .= '</select>';
                echo nokri_returnEcho($res);
            }
            die();
        }

    }
// Get sub cats Version
    add_action('wp_ajax_get_child_lev2', 'nokri_get_child_lev2');
    add_action('wp_ajax_nopriv_get_child_lev2', 'nokri_get_child_lev2');
    if (!function_exists('nokri_get_child_lev2')) {

        function nokri_get_child_lev2() {
            global $nokri;
            $heading = '';
            if (isset($nokri['cat_level_3']) && $nokri['cat_level_3'] != "") {
                $heading = $nokri['cat_level_3'];
            }
            $cat_id = $_POST['cat_id'];
            $taxanomy = isset($_POST['tax']) ? $_POST['tax'] : "";
            if ($taxanomy == 'ad_location') {
                $tax = 'ad_location';
                $heading = (isset($nokri['job_country_level_3']) && $nokri['job_country_level_3'] != "") ? $nokri['job_country_level_3'] : "";
                $id = 'child_lev2_loc';
            } else {
                $tax = 'job_category';
                $id = 'child_lev2';
            }
            $ad_cats = nokri_get_cats($tax, $cat_id);
            $res = '';
            if (count((array) $ad_cats) > 0) {
                $res .= '<label>' . $heading . '</label>';
                $res .= '<select class="search-select form-control"  id="' . $id . '">';
                $res .= '<option label="' . esc_html__('Select Option', 'nokri') . '"></option>';
                foreach ($ad_cats as $ad_cat) {
                    $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '</option>';
                }
                $res .= '</select>';
                echo nokri_returnEcho($res);
            }
            die();
        }

    }
// Get sub cats Version 4th Level
    add_action('wp_ajax_get_child_lev3', 'nokri_get_child_lev3');
    add_action('wp_ajax_nopriv_get_child_lev3', 'nokri_get_child_lev3');
    if (!function_exists('nokri_get_child_lev3')) {

        function nokri_get_child_lev3() {
            global $nokri;
            $heading = '';
            if (isset($nokri['cat_level_4']) && $nokri['cat_level_4'] != "") {
                $heading = $nokri['cat_level_4'];
            }
            $cat_id = $_POST['cat_id'];
            $taxanomy = isset($_POST['tax']) ? $_POST['tax'] : "";
            if ($taxanomy == 'ad_location') {
                $tax = 'ad_location';
                $heading = (isset($nokri['job_country_level_4']) && $nokri['job_country_level_4'] != "") ? $nokri['job_country_level_4'] : "";
                $id = 'get_child_lev3_loc';
            } else {
                $tax = 'job_category';
                $id = 'get_child_lev3';
            }
            $ad_cats = nokri_get_cats($tax, $cat_id);
            $res = '';
            if (count((array) $ad_cats) > 0) {
                $res .= '<label>' . $heading . '</label>';
                $res .= '<select class="search-select form-control"  id="' . $id . '">';
                $res .= '<option value="kl">' . esc_html__('Select Option', 'nokri') . '</option>';
                foreach ($ad_cats as $ad_cat) {
                    $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '</option>';
                }
                $res .= '</select>';
                echo nokri_returnEcho($res);
            }
            die();
        }

    }
// Get sub cats Version 4th Level
    add_action('wp_ajax_get_child_lev4', 'nokri_get_child_lev4');
    add_action('wp_ajax_nopriv_get_child_lev4', 'nokri_get_child_lev4');
    if (!function_exists('nokri_get_child_lev4')) {

        function nokri_get_child_lev4() {
            $cat_id = $_POST['cat_id'];
            echo nokri_returnEcho($cat_id);
            die();
        }

    }
    /* ====================================== */
    /* Getting Taxonomies at job alert form */
    /* ====================================== */
    if (!function_exists('nokri_add_taxonomies_on_job_alert')) {

        function nokri_add_taxonomies_on_job_alert($taxonomy_name = '', $is_show = '') {
            global $nokri;
            $taxnomy_html = '';
            $formats = array();

            $is_valid = false;
            if (isset($nokri['job_alerts_tax']) && !empty($nokri['job_alerts_tax'])) {
                foreach ((array) $nokri['job_alerts_tax'] as $key => $value) {
                    $formats[] = $value;
                }
            }
            if (in_array($taxonomy_name, $formats)) {
                $is_valid = true;
            }
            if (isset($taxonomy_name) && $taxonomy_name != '' && $is_valid) {
                $taxnomy_terms = nokri_get_cats($taxonomy_name, 0);
                $taxnomy_html = '';
                if (!empty($taxnomy_terms) && !is_wp_error($taxnomy_terms)) {
                    foreach ($taxnomy_terms as $term) {
                        $taxnomy_html .= '<option value="' . esc_attr($term->term_id) . '" >' . esc_html($term->name) . '</option>';
                    }
                }
            }
            if (isset($is_show) && $is_show) {
                return $is_valid;
            } else {
                return $taxnomy_html;
            }
        }

    }

    /* ====================================== */
    /* Getting Taxonomies at paid job alert form */
    /* ====================================== */
    if (!function_exists('nokri_add_taxonomies_on_job_alert_paid')) {

        function nokri_add_taxonomies_on_job_alert_paid($taxonomy_name = '', $is_show = '') {
            global $nokri;
            $taxnomy_html = '';
            $formats = array('job_category');
            $is_valid = false;
            if (isset($nokri['paid_job_alerts_tax']) && !empty($nokri['paid_job_alerts_tax'])) {
                foreach ((array) $nokri['paid_job_alerts_tax'] as $key => $value) {
                    $formats[] = $value;
                }
            }
            if (in_array($taxonomy_name, $formats)) {
                $is_valid = true;
            }
            if (isset($taxonomy_name) && $taxonomy_name != '' && $is_valid) {
                $taxnomy_terms = nokri_get_cats($taxonomy_name, 0);
                $taxnomy_html = '';
                if (!empty($taxnomy_terms) && !is_wp_error($taxnomy_terms)) {
                    foreach ($taxnomy_terms as $term) {
                        $taxnomy_html .= '<option value="' . esc_attr($term->term_id) . '" >' . esc_html($term->name) . '</option>';
                    }
                }
            }
            if (isset($is_show) && $is_show) {
                return $is_valid;
            } else {
                return $taxnomy_html;
            }
        }

    }
    /* ====================================== */
    /* Getting candidates alerts taxonomy name */
    /* ====================================== */
    if (!function_exists('nokri_get_alert_tax_name')) {

        function nokri_get_alert_tax_name($val = '', $tax_name = '') {
            $term_name = '';
            if (isset($val) && !empty($val)) {
                $terms = get_term_by('id', $val, $tax_name);
                $term_name = $terms->name;
            }
            return $term_name;
        }

    }
    /* ====================================== */
    /* Getting candidates alerts categories */
    /* ====================================== */
    if (!function_exists('nokri_get_alerts_category_subscription')) {

        function nokri_get_alerts_category_subscription($user_id = '', $alert_type = array()) {
            $job_alert = nokri_get_candidates_job_alerts($user_id);
            if (isset($job_alert) && !empty($job_alert)) {
                $terms = array();
                foreach ($job_alert as $key => $val) {
                    $value = (isset($val[$alert_type]) && $val[$alert_type] != '' ) ? $val[$alert_type] : '';
                    $terms[] = $value;
                }
            }
            return $terms;
        }

    }


    /* ====================================== */
    /* Getting candidates alerts geolocation  */
    /* ====================================== */
    if (!function_exists('nokri_get_alerts_geolocation_subscription')) {

        function nokri_get_alerts_geolocation_subscription($user_id = '', $alert_type = array()) {
            $job_alert = nokri_get_candidates_job_alerts($user_id);
            if (isset($job_alert) && !empty($job_alert)) {
                $terms = array();
                foreach ($job_alert as $key => $val) {
                    $value = (isset($val[$alert_type]) && $val[$alert_type] != '' ) ? $val[$alert_type] : '';
                    $terms[] = $value;
                }
            }
            return $terms;
        }

    }
    /* ============================== */
    /* Query sending job alerts */
    /* =============================== */
    if (!function_exists('nokri_send_alerts_jobs')) {

        function nokri_send_alerts_jobs($user_id = '') {

            $today = getdate();
            $current_id = $user_id;

            $query = array(
                'post_type' => 'job_post',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
                'date_query' => array(
                    array(
                        'year' => $today['year'],
                        'month' => $today['mon'],
                        'day' => $today['mday'],
                    ),
                ),
            );
            $loop = new WP_Query($query);
            $notification = '';
            $valid = false;
            while ($loop->have_posts()) {
                $loop->the_post();
                $job_id = get_the_ID();
                $valid = true;
                $post_author_id = get_post_field('post_author', $job_id);
                $company_name = get_the_author_meta('display_name', $post_author_id);
                /* Getting cand informations */
                $cand_category = nokri_get_alerts_category_subscription($current_id, 'alert_category');
                $cand_geo_location = nokri_get_alerts_geolocation_subscription($current_id, 'sb_user_address');
                $job_address = get_post_meta($job_id, '_job_address', true);
                $job_address_array = array();
                $job_address_array[] = $job_address;
                $cand_type = nokri_get_alerts_category_subscription($current_id, 'alert_type');
                $cand_experience = nokri_get_alerts_category_subscription($current_id, 'alert_experience');
                $cand_location = nokri_get_alerts_category_subscription($current_id, 'alert_location');
                /* Getting Job informations */
                $job_category = wp_get_post_terms($job_id, 'job_category', array("fields" => "ids"));
                $job_type = wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
                $job_experience = wp_get_post_terms($job_id, 'job_experience', array("fields" => "ids"));
                $job_location = wp_get_post_terms($job_id, 'ad_location', array("fields" => "ids"));
                /* Validating taxonmies */
                $geo_check = $loc_check = false;
                if (!empty($cand_category)) {

                    $valid = nokri_validating_alert_taxonomy($cand_category, $job_category);
                }
                if (!empty($cand_type[0])) {

                    $valid = nokri_validating_alert_taxonomy($cand_type, $job_type);
                }
                if (!empty($cand_experience[0])) {
                    $valid = nokri_validating_alert_taxonomy($cand_experience, $job_experience);
                }

                if (!empty($cand_geo_location[0])) {

                    $valid = nokri_validating_alert_taxonomy($job_address_array, $cand_geo_location);
                }

                if (!empty($cand_location[0])) {
                    $valid = nokri_validating_alert_taxonomy($cand_location, $job_location);
                }
            }
            wp_reset_postdata();
            if ($valid) {
                $notification = $job_id;
            }
            return $notification;
        }

    }



    /* ============================== */
    /* Validating job alert taxonomies */
    /* =============================== */
    if (!function_exists('nokri_validating_alert_taxonomy')) {

        function nokri_validating_alert_taxonomy($cand_tax = '', $job_tax = '') {
            $validate = false;
            if (!empty($cand_tax) && !empty($job_tax) && is_array($cand_tax) && is_array($job_tax)) {
                $final_array = array_intersect($cand_tax, $job_tax);
                if (count($final_array) > 0) {
                    $validate = true;
                }
            }
            return $validate;
        }

    }
    /* ============================== */
    /* Sending automatic scheduled email */
    /* =============================== */

    function nokri_job_alerts_function() {
        global $nokri;
        $is_paid = isset($nokri['job_alert_paid_switch']) ? $nokri['job_alert_paid_switch'] : false;
        if (!$is_paid) {
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
                        'key' => '_cand_alerts_en',
                        'value' => '',
                        'compare' => '!='
                    ),
                ),
            );
            $user_query = new WP_User_Query($args);
            $candidates = $user_query->get_results();
            $required_user_html = $job_id = '';
            if (!empty($candidates)) {
                foreach ($candidates as $candidate) {

                    $user_id = $candidate->ID;
                    $job_alert = nokri_get_candidates_job_alerts($user_id);
                    $job_id = nokri_send_alerts_jobs($user_id);
                    if (isset($job_alert) && !empty($job_alert)) {
                        foreach ($job_alert as $key => $val) {
                            $job_id = nokri_send_alerts_jobs($user_id);
                            $alert_name = $val['alert_name'];
                            $alert_category = $val['alert_category'];
                            $alert_email = $val['alert_email'];
                            $alert_freq = $val['alert_frequency'];
                            $alert_start = $val['alert_start'];
                            $today = date('Y/m/d');
                            if ($alert_freq == '1') {
                                $date_to_sent = $today;
                            } else {
                                $date_to_sent = date('Y/m/d', strtotime($alert_start . "+$alert_freq days"));
                            }
                            if ($date_to_sent == $today && $job_id != '') {
                                $val['alert_start'] = $date_to_sent;
                                $my_alert = json_encode($val);
                                nokri_email_job_alerts($job_id, $alert_email);
                                if (function_exists('nokri_job_alert_notification')) {
                                    $test = nokri_job_alert_notification("androaid", $job_id, $user_id);
                                }
                                update_user_meta($user_id, $key, ($my_alert));
                            }
                        }
                    }
                }
            }
        }
    }

    /* ============================== */
    /* Package before expiry notify  */
    /* =============================== */

    function nokri_send_alerts_package_expiry_function() {

        global $nokri;
        $days = isset($nokri['sb_package_expiry_days']) ? $nokri['sb_package_expiry_days'] : 1;
        $tommorow = Date('Y-m-d', strtotime("$days days"));
        $user_query = new WP_User_Query(
                array(
            'meta_query' => array(
                array(
                    'key' => '_sb_expire_ads',
                    'value' => $tommorow,
                ),
            )
                )
        );
        $authors = $user_query->get_results();
        if (!empty($authors)) {
            foreach ($authors as $author) {
                nokri_before_package_expiry_notify($author->ID);
            }
            wp_reset_postdata();
        }
    }

    add_filter('cron_schedules', 'nokri_send_job_alerts_email');

    function nokri_send_job_alerts_email($schedules) {
        $schedules['every_seven_hours'] = array(
            'interval' => 25200,
            'display' => __('Every 7 Hours', 'nokri')
        );
        return $schedules;
    }

// Schedule an action if it's not already scheduled
    if (!wp_next_scheduled('nokri_send_job_alerts_email')) {

        wp_schedule_event(time(), 'every_seven_hours', 'nokri_send_job_alerts_email');
    }
// Hook into that action that'll fire every three minutes
    add_action('nokri_send_job_alerts_email', 'nokri_job_alerts_function');




    /* cron job for sending notification for pacakge expiry before 1 day */

    add_filter('cron_schedules', 'nokri_send_alerts_package_expiry');

    function nokri_send_alerts_package_expiry($schedules) {
        $schedules['once_daily'] = array(
            'interval' => 86400,
            'display' => __('Once Daily', 'nokri')
        );
        return $schedules;
    }

    if (!wp_next_scheduled('nokri_send_alerts_package_expiry')) {

        wp_schedule_event(time(), 'once_daily', 'nokri_send_alerts_package_expiry');
    }
    add_action('nokri_send_alerts_package_expiry', 'nokri_send_alerts_package_expiry_function');




    /* ============================== */
    /* Jobs before expiry notify  */

    function nokri_jobs_expiry_function() {


        global $nokri;

        $days = isset($nokri['sb_package_expiry_days']) ? $nokri['sb_package_expiry_days'] : 1;
        $tomorrow = date("m/d/Y", strtotime("$days days"));
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'job_post',
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_job_status',
                    'value' => 'active',
                    'compare' => '=',
                ),
                array(
                    'key' => '_job_date',
                    'value' => $tomorrow,
                    'compare' => '='
                )
            ),
        );
        //   $args = nokri_wpml_show_all_posts_callback($args);
        $results = new WP_Query($args);
        if ($results->have_posts()) {
            while ($results->have_posts()) {
                $results->the_post();
                $job_id = get_the_ID();

                nokri_before_jobs_expiry_notify($job_id, "no");
            }
            wp_reset_postdata();
        }

        //notify on expired jobs          
        $args2 = array(
            'posts_per_page' => -1,
            'post_type' => 'job_post',
            'post_status' => array('publish', 'draft'),
            'meta_query' => array(
                array(
                    'key' => '_job_date',
                    'value' => date("m/d/Y", strtotime("-1 days")),
                    'compare' => '='
                )
            ),
        );
        $results2 = new WP_Query($args2);

        if ($results2->have_posts()) {
            while ($results2->have_posts()) {
                $results2->the_post();
                $job_id = get_the_ID();
                nokri_before_jobs_expiry_notify($job_id, "yes");
                update_post_meta($job_id, '_job_status', 'inactive');
            }
            wp_reset_postdata();
        }
    }

    add_filter('cron_schedules', 'nokri_send_jobs_expiry');

    function nokri_send_jobs_expiry($schedules) {
        $schedules['once_daily'] = array(
            'interval' => 86400,
            'display' => __('Once Daily', 'nokri')
        );
        return $schedules;
    }

    if (!wp_next_scheduled('nokri_send_jobs_expiry')) {

        wp_schedule_event(time(), 'once_daily', 'nokri_send_jobs_expiry');
    }

    add_action('nokri_send_jobs_expiry', 'nokri_jobs_expiry_function');
//end cron jobs