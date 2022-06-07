<?php
/*
 * Make theme available for translation.
 * Translations can be filed in the /languages/ directory.
 * If you're building a theme based on nokri, use a find and replace
 * to change ''rane to the name of your theme in all the template files.
 */
load_theme_textdomain('nokri', trailingslashit(get_template_directory()) . 'languages/');
add_theme_support('automatic-feed-links');
add_theme_support("title-tag");

add_theme_support('woocommerce');


if (!isset($content_width))
    $content_width = 900;
$args1 = $args2 = array();
add_theme_support("custom-background", $args1);
add_theme_support("custom-header", $args2);
define('NOKRI_ALLOW_EDITING', true);
posts_nav_link();
paginate_comments_links();
/* Customize  Excerpt Word Count Lenght */

function nokri_excerpt_length() {
    return 20;
}

add_filter('excerpt_length', 'nokri_excerpt_length');
/* ========================= */
/* Add  Theme Support */
/* ========================= */
add_theme_support('post-thumbnails');
/* 2 coloumn Blog Thumbnail Size */
add_image_size('nokri_job_post_single', 150, 150, true);
/* 100 Thumbnail Size */
add_image_size('nokri_job_hundred', 100, 100, true);
/* Shortcode Home Slider Size */
add_image_size('nokri_home_slider', 1583, 620, true);
/* Shortcode About Us Pic */
add_image_size('nokri_about_pic', 500, 338, true);
/* Candidate Portfolio Small */
add_image_size('nokri_cand_small', 300, 300, true);
/* Candidate Portfolio Large */
add_image_size('nokri_cand_large', 1000, 1000, true);
/* Candidate Portfolio Large */
add_image_size('nokri_blog_author', 45, 45, true);
/* Candidate Portfolio Large */
add_image_size('nokri_jobs_map', 80, 80, true);
// Add Feature Image  Theme Support
add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote ', 'status', 'video', 'audio', 'chat'));
add_action('after_setup_theme', 'nokri_child_theme_posts_formats', 11);

function nokri_child_theme_posts_formats() {
    add_theme_support('post-formats', array(
        'aside',
        'audio',
        'chat',
        'gallery',
        'image',
        'link',
        'quote',
        'status',
        'video',
    ));
}

/* ========================= */
/* Registering Side Bar */
/* ========================= */

function nokri_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Blog sidebar', 'nokri'),
        'id' => 'blog_sidebar',
        'description' => esc_html__('Widgets in this area will be shown on all posts and pages.', 'nokri'),
        'before_widget' => '<div id="%1$s" class="widget  search-blog">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-heading">',
        'after_title' => '</div>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Search sidebar', 'nokri'),
        'id' => 'search_sidebar',
        'description' => esc_html__('Widgets in this area will be shown on search pages.', 'nokri'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => esc_html__('Search Bar 2', 'nokri'),
        'id' => 'horizontal_searchbar',
        'description' => esc_html__('Widgets in this area will be shown on search pages.', 'nokri'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => esc_html__('Candidates sidebar', 'nokri'),
        'id' => 'candidates_sidebar',
        'description' => esc_html__('Widgets in this area will be shown on search pages.', 'nokri'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => esc_html__('Employer sidebar', 'nokri'),
        'id' => 'employers_sidebar',
        'description' => esc_html__('Widgets in this area will be shown on search pages.', 'nokri'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));

    register_sidebar(array(
        'name' => esc_html__('Shop Sidebar', "nokri"),
        'id' => 'nokri_shop-sidebar',
        'before_widget' => '<div class="widget"><div id="%1$s">',
        'after_widget' => '</div></div>',
        'before_title' => '<div class="widget-heading"><h4 class="panel-title"><a href="javascript:void(0)">',
        'after_title' => '</a></h4></div>'
    ));
}

add_action('widgets_init', 'nokri_widgets_init');
/* Remove blog widgets form search sidebar */
add_filter('sidebars_widgets', 'nokri_remove_search_side_bar_blog_widgets');

function nokri_remove_search_side_bar_blog_widgets($sidebars_widgets) {
    foreach ($sidebars_widgets as $widget_area => $widget_list) {
        if ($widget_area == 'search_sidebar') {
            foreach ($widget_list as $pos => $widget_id) {
                $arr_w = array('archives-2', 'categories-2', 'meta-2');
                if (in_array($widget_id, $arr_w)) {
                    unset($sidebars_widgets[$widget_area][$pos]);
                }
            }
        }
    }
    return $sidebars_widgets;
}

/* * * Registers an editor stylesheet for the theme *** */

function nokri_theme_add_editor_styles() {
    add_editor_style('editor.css');
}

add_action('admin_init', 'nokri_theme_add_editor_styles');
/* register nav menu and footer nav */
register_nav_menus(
        array(
            'main-nav' => 'Main Navigation',
        )
);

/* * *** Function for the use of Old Widget Style *** */
if (!function_exists('nokri_use_widgets_block_editor')) {

    function nokri_use_widgets_block_editor($use_widgets_block_editor) {

        global $nokri;

        $widget_style = isset($nokri['nokri_widget_style']) ? $nokri['nokri_widget_style'] : false;
        if ($widget_style) {
            return false;
        }
        return $use_widgets_block_editor;
    }

    add_filter('use_widgets_block_editor', 'nokri_use_widgets_block_editor');
}
/*Adding the column*/
function sb_nokri_user_id_column($columns) {
    $columns['user_id'] = 'ID';
    return $columns;
}

add_filter('manage_users_columns', 'sb_nokri_user_id_column');

/*Column content*/
function nokri_user_id_column_content($value, $column_name, $user_id) {
    if ('user_id' == $column_name) {
        return $user_id;
    }
    return $value;
}

add_action('manage_users_custom_column', 'nokri_user_id_column_content', 10, 3);

/* Column style (you can skip this if you want)*/
function nokri_user_id_column_style() {
    echo '<style>.column-user_id{width: 5%}</style>';
}

add_action('admin_head-users.php', 'nokri_user_id_column_style');