<?php

/**
 * For full documentation, please visit: http://docs.reduxframework.com/
 * For a more extensive sample-config file, you may look at:
 * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
 */
if (!class_exists('Redux')) {
    return;
}
// This is your option name where all the Redux data is stored.
$opt_name = 'nokri';

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */
$theme = wp_get_theme(); // For use with some settings. Not necessary.
$args = array(
    'opt_name' => 'nokri',
    'dev_mode' => false,
    'display_name' => esc_html__('Theme Options', 'nokri'),
    'display_version' => '1.4.7',
    'page_title' => esc_html__('Theme Options', 'nokri'),
    'update_notice' => false,
    'admin_bar' => TRUE,
    'menu_type' => 'submenu',
    'menu_title' => esc_html__('Theme Options', 'nokri'),
    'allow_sub_menu' => TRUE,
    'page_parent_post_type' => 'your_post_type',
    'customizer' => TRUE,
    'default_show' => TRUE,
    'default_mark' => '*',
    'hints' => array(
        'icon_position' => 'right',
        'icon_size' => 'normal',
        'tip_style' => array(
            'color' => 'light',
        ),
        'tip_position' => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect' => array(
            'show' => array(
                'duration' => '500',
                'event' => 'mouseover',
            ),
            'hide' => array(
                'duration' => '500',
                'event' => 'mouseleave unfocus',
            ),
        ),
    ),
    'output' => TRUE,
    'output_tag' => TRUE,
    'settings_api' => TRUE,
    'cdn_check_time' => '1440',
    'compiler' => TRUE,
    'global_variable' => 'nokri',
    'page_permissions' => 'manage_options',
    'save_defaults' => TRUE,
    'show_import_export' => TRUE,
    'database' => 'options',
    'transient_time' => '3600',
    'network_sites' => TRUE,
);
Redux::setArgs($opt_name, $args);
$tabs = array(
    array(
        'id' => 'redux-help-tab-1',
        'title' => esc_html__('Theme Information 1', 'nokri'),
        'content' => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'nokri')
    ),
    array(
        'id' => 'redux-help-tab-2',
        'title' => esc_html__('Theme Information 2', 'nokri'),
        'content' => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'nokri')
    )
);
Redux::setHelpTab($opt_name, $tabs);
// Set the help sidebar
$content = esc_html__('<p>This is the sidebar content, HTML is allowed.</p>', 'nokri');
Redux::setHelpSidebar($opt_name, $content);
/* ------------------General Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('General Settings', 'nokri'),
    'id' => 'nokri_theme_ggene',
    'desc' => '',
    'icon' => 'el el-wrench',
    'fields' => array(
        array(
            'id' => 'is_demo_mode',
            'type' => 'switch',
            'title' => esc_html__('Demo mode', 'nokri'),
            'subtitle' => esc_html__('Enable/Disable demo mode ', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'admin_top_bar_switch',
            'type' => 'switch',
            'title' => esc_html__('Admin top bar', 'nokri'),
            'subtitle' => esc_html__('Disable admin top bar', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'loader_img_switch',
            'type' => 'switch',
            'title' => esc_html__('Preloader', 'nokri'),
            'subtitle' => esc_html__('Enable/Disable Preloader ', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('loader_img_switch', '=', array('1')),
            'id' => 'loader_text',
            'type' => 'text',
            'title' => esc_html__('Preloader text', 'nokri'),
        ),
        array(
            'required' => array('loader_img_switch', '=', array('1')),
            'id' => 'loader_img',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Preloader image', 'nokri'),
            'compiler' => 'true',
            'subtitle' => esc_html__('Dimensions: 200 x 200', 'nokri'),
            'default' => array('url' => get_template_directory_uri() . '/images/candidate-dp.jpg'),
        ),
        array(
            'id' => 'front_colour',
            'type' => 'switch',
            'title' => __('Colour Plate', 'nokri'),
            'subtitle' => __('Enable/Disable Colour Plate At Front End ', 'nokri'),
            'default' => false,
        ),
        $fields = array(
    'id' => 'button-set-colour',
    'type' => 'button_set',
    'title' => __('Select Theme Colour', 'nokri'),
    'subtitle' => __('Select Your Desired Colour For Theme', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'defualt' => 'Default',
        'yellow' => 'Yellow',
        'dark-blue' => 'Dark Blue',
        'red' => 'Red',
        'orange' => 'Orange',
        'green' => 'Green',
        'purple' => 'Purple',
    ),
    'defualt' => 'defualt'
        ),
        array(
            'id' => 'section_bg_img',
            'type' => 'background',
            'background-color' => false,
            'url' => true,
            'title' => esc_html__('Upload section background image', 'nokri'),
            'compiler' => 'true',
            'default' => array(
                'background-image' => get_template_directory_uri() . '/images/footer.png',
                'background-repeat' => 'no-repeat',
                'background-size' => 'cover',
                'background-position' => 'center center',
                'background-attachment' => 'fixed'
            )
        ),
        array(
            'id' => 'nokri_widget_style',
            'type' => 'switch',
            'title' => __('Old Widget Style', 'nokri'),
            'subtitle' => __('Enable/Disable Old Widget Style', 'nokri'),
            'desc' => __('On This option only if you want to use Old Classic Editor Widget style on the Backend Widget Section.', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'nokri_admin_job_alerts',
            'type' => 'switch',
            'title' => __('Jobs Alert Notifications', 'nokri'),
            'subtitle' => __('Enable/Disable Admin dashboard Jobs alert', 'nokri'),
            'desc' => __('With On this Button Admin can see on dashboard notifications which candidate subscribe Jobs Alert', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'scroll_to_top',
            'type' => 'switch',
            'title' => esc_html__('Scroll to top', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'nokri_user_dp',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Default user picture', 'nokri'),
            'compiler' => 'true',
            'subtitle' => esc_html__('Dimensions: 200 x 200', 'nokri'),
            'default' => array('url' => get_template_directory_uri() . '/images/candidate-dp.jpg'),
        ),
        array(
            'id' => 'sb_location_allowed',
            'type' => 'switch',
            'title' => __('Allowed all countries', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'sb_list_allowed_country',
            'type' => 'select',
            'options' => nokri_get_all_countries(),
            'multi' => true,
            'title' => __('Select Countries', 'nokri'),
            'required' => array('sb_location_allowed', '=', array('0')),
            'desc' => __('You can select max 5 countries as per GOOGLE limit.', 'nokri') . ' ' . nokri_make_link('https://developers.google.com/maps/documentation/javascript/3.exp/reference#ComponentRestrictions', __('Read More', 'nokri')),
        ),
        array(
            'id' => 'sb_allow_empty_cats',
            'type' => 'switch',
            'title' => __('Hide empty categories', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'sb_allow_auto_order_complete',
            'type' => 'switch',
            'title' => __('Auto order approve', 'nokri'),
            'default' => false,
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => esc_html__('Header Settings', 'nokri'),
    'id' => 'nokri_theme_genral',
    'desc' => '',
    'icon' => 'el el-wrench',
));
Redux::setSection($opt_name, array(
    'title' => esc_html__('Header Selection', 'nokri'),
    'id' => 'header_designs',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        /*         * ****************** */
        /* Header Selection */
        /*         * ***************** */
        array(
            'id' => 'main_header_style',
            'type' => 'button_set',
            'title' => esc_html__('Select Header', 'nokri'),
            'options' => array(
                '1' => esc_html__('Transparent', 'nokri'),
                '2' => esc_html__('Standard', 'nokri'),
            ),
            'default' => '1',
        ),
        /* Hide/show Elementor Pro full Header */
        array(
            //'required' => array( 'main_header_style', '=', array( '2') ),
            'id' => 'is_elementor_header',
            'type' => 'switch',
            'title' => esc_html__('Elementor Pro Header', 'nokri'),
            'subtitle' => esc_html__('Enable/Disable Elementor Pro Header', 'nokri'),
            'desc' => esc_html__('On this option only if you want to use custom header and using Elementor Pro Version', 'nokri'),
            'default' => false,
        ),
        array(
            //'required' => array( 'main_header_style', '=', array( '2') ),
            'id' => 'is_sticky_menu',
            'type' => 'switch',
            'title' => esc_html__('Sticky Menu', 'nokri'),
            'subtitle' => esc_html__('Enable/Disable Sticky Menu', 'nokri'),
            'default' => false,
        ),
        array(
            //'required' => array( 'main_header_style', '=', array( '2') ),
            'id' => 'menu_full_width',
            'type' => 'switch',
            'title' => esc_html__('Menu Full Width', 'nokri'),
            'subtitle' => esc_html__('Enable/Disable Full Width Menu', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'header_top_bar',
            //'required' => array('main_header_style', '=', array('1,2')),
            'type' => 'switch',
            'title' => esc_html__('Header top bar', 'nokri'),
            'subtitle' => esc_html__('Hide/Show top bar', 'nokri'),
            'default' => false,
            'desc' => __('In transparent header it will work only in dashboard', 'nokri'),
        ),
        $fields = array(
    'required' => array('header_top_bar', '=', array('1')),
    'id' => 'header_top_bar_style',
    'type' => 'button_set',
    'title' => __('Select Topbar Style', 'nokri'),
    'multi' => false,
    'options' => array(
        '1' => __('Style 1', 'nokri'),
        '2' => __('Style 2', 'nokri'),
        '3' => __('Style 3', 'nokri'),
    ),
    'default' => '1',
        ),
        array(
            'required' => array('header_top_bar', '=', array('1')),
            'id' => 'contact_switch',
            'type' => 'switch',
            'title' => esc_html__('Contact us', 'nokri'),
            'subtitle' => esc_html__('Hide/Show contact us', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('contact_switch', '=', array('1')),
            'id' => 'top_bar_sorter1',
            'type' => 'sortable',
            'desc' => esc_html__('Drags To Sort Like You Want', 'nokri'),
            'label' => true,
            'options' => array(
                'Email' => 'Support@domain.com',
                'Phone Number' => '+921234567',
                'Address' => '',
            ),
            'default' => array(
                'Email' => 'Support@domain.com ',
                'Address' => '',
            )
        ),
        array(
            'required' => array('header_top_bar_style', '=', array('2', '3')),
            'id' => 'header_top_bar_links_switch',
            'type' => 'switch',
            'title' => esc_html__('Hot Links', 'nokri'),
            'subtitle' => esc_html__('Hide/Show hot links', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('header_top_bar_links_switch', '=', array('1')),
            'id' => 'header_top_bar_links',
            'type' => 'select',
            'data' => 'pages',
            'multi' => true,
            'title' => esc_html__('Hot Links ', 'nokri'),
            'subtitle' => esc_html__('Select Pages That Show On Top Bar', 'nokri'),
            'default' => array('2'),
        ),
        array(
            'required' => array('header_top_bar_style', '=', array('1')),
            'id' => 'social_switch',
            'type' => 'switch',
            'title' => esc_html__('Social Links', 'nokri'),
            'subtitle' => esc_html__('Hide/Show Social Links', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('social_switch', '=', array('1')),
            'id' => 'top_bar_social_sorter',
            'type' => 'sortable',
            'desc' => esc_html__('Drags To Sort Like You Want', 'nokri'),
            'label' => true,
            'options' => array(
                'Face Book' => 'www.facebook.com',
                'Twitter' => 'www.twitter.com',
                'Instagram' => 'www.Instagram.com',
                'LinkedIn' => 'www.LinkedIn.com',
                'Behance' => 'www.Behance.com',
                'Pintrest' => 'www.Pintrest.com',
                'Youtube' => 'www.Pintrest.com',
            ),
            'default' => array(
                'Face Book' => 'www.facebook.com',
                'Twitter' => 'www.twitter.com',
                'Instagram' => 'www.Instagram.com',
                'LinkedIn' => 'www.LinkedIn.com',
                'Behance' => 'www.Behance.com',
                'Youtube' => 'www.Youtube.com',
            )
        ),
        /* nav background */
        array(
            'required' => array('main_header_style', '=', array('1', '2', '3')),
            'id' => 'user_bar_switch',
            'type' => 'switch',
            'title' => esc_html__('User Icon And Button', 'nokri'),
            'subtitle' => esc_html__('Hide/Show User Icon And Button ', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('user_bar_switch', '=', array('1')),
            'id' => 'nav_bar_post_btn',
            'type' => 'text',
            'title' => esc_html__('Employer Button Text', 'nokri'),
            'default' => esc_html__('Job Post', 'nokri'),
        ),
        array(
            'required' => array('user_bar_switch', '=', array('1')),
            'id' => 'nav_bar_post_btn_link',
            'type' => 'select',
            'data' => 'pages',
            'multi' => false,
            'title' => esc_html__('Employer Job Post Link ', 'nokri'),
            'subtitle' => esc_html__('Select Page', 'nokri'),
            'default' => array('266'),
        ),
        array(
            'required' => array('user_bar_switch', '=', array('1')),
            'id' => 'nav_bar_post_btn_icon',
            'type' => 'text',
            'title' => esc_html__('Employer Button Icon', 'nokri'),
            'default' => 'fa fa-plus-square',
            'desc' => __('Click to explore more icons', 'nokri') . ' ' . nokri_make_link('https://fontawesome.com/v4.7.0/icons/', __('Get Icons', 'nokri')),
        ),
        array(
            'required' => array('user_bar_switch', '=', array('1')),
            'id' => 'cand_nav_bar_post_btn',
            'type' => 'text',
            'title' => esc_html__('Candidate Button Text', 'nokri'),
            'default' => esc_html__('All Jobs', 'nokri'),
        ),
        array(
            'required' => array('user_bar_switch', '=', array('1')),
            'id' => 'cand_nav_bar_post_btn_icon',
            'type' => 'text',
            'title' => esc_html__('Candidate Button Icon', 'nokri'),
            'default' => 'fa fa-newspaper-o',
            'desc' => __('Click to explore more icons', 'nokri') . ' ' . nokri_make_link('https://fontawesome.com/v4.7.0/icons/', __('Get Icons', 'nokri')),
        ),
        array(
            'required' => array('user_bar_switch', '=', array('1')),
            'id' => 'cand_nav_bar_post_btn_link',
            'type' => 'select',
            'data' => 'pages',
            'multi' => false,
            'title' => esc_html__('Candidate Page Link ', 'nokri'),
            'subtitle' => esc_html__('Job search page for candidate', 'nokri'),
            'default' => array('274'),
        ),
        /* Without login */
        array(
            'id' => 'wo_log_btn_txt',
            'type' => 'text',
            'title' => esc_html__('Guest Button Text', 'nokri'),
            'default' => esc_html__('Job Post', 'nokri'),
        ),
        array(
            'id' => 'wo_log_btn_icon',
            'type' => 'text',
            'title' => esc_html__('Guest Button Icon', 'nokri'),
            'default' => 'fa fa-plus-square',
            'desc' => __('Click to explore more icons', 'nokri') . ' ' . nokri_make_link('https://fontawesome.com/v4.7.0/icons/', __('Get Icons', 'nokri')),
        ),
        array(
            'id' => 'wo_log_btn_link',
            'type' => 'select',
            'data' => 'pages',
            'multi' => false,
            'title' => esc_html__('Guest Button Link ', 'nokri'),
            'subtitle' => esc_html__('Select required page link', 'nokri'),
            'default' => array('266'),
        ),
        /* Without login */


        /* Top bar settings */
        array(
            'required' => array('top_main_page_bar', '=', array('1')),
            'id' => 'header_job_post_page',
            'type' => 'select',
            'data' => 'pages',
            'multi' => false,
            'title' => esc_html__('Job Post Page ', 'nokri'),
            'subtitle' => esc_html__('Select Page', 'nokri'),
            'default' => array('266'),
        ),
        array(
            'required' => array('top_main_page_bar', '=', array('1')),
            'id' => 'header_job_post_page_icon',
            'type' => 'text',
            'title' => esc_html__('Job Post Page Icon', 'nokri'),
            'default' => 'fa fa-plus-square',
            'desc' => __('Click to explore more icons', 'nokri') . ' ' . nokri_make_link('https://fontawesome.com/v4.7.0/icons/', __('Get Icons', 'nokri')),
        ),
        array(
            'required' => array('top_main_page_bar', '=', array('1')),
            'id' => 'top_main_page_bar_user_switch',
            'type' => 'switch',
            'title' => esc_html__('User Button', 'nokri'),
            'subtitle' => esc_html__('Hide/Show User Button ', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('top_main_page_bar_user_switch', '=', array('1')),
            'id' => 'header_user_btn_icon',
            'type' => 'text',
            'title' => esc_html__('User Button Icon', 'nokri'),
            'default' => 'fa fa-user',
            'desc' => __('Click to explore more icons', 'nokri') . ' ' . nokri_make_link('https://fontawesome.com/v4.7.0/icons/', __('Get Icons', 'nokri')),
        ),
        /* ------------------Logo Settings----------------------- */
        array(
            'id' => 'header_logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Upload Header Logo', 'nokri'),
            'compiler' => 'true',
            'desc' => esc_html__('Size 230 * 40', 'nokri'),
            'subtitle' => esc_html__('upload Site Logo Here', 'nokri'),
            'default' => array('url' => get_template_directory_uri() . '/images/logo.png'),
        ),
        /* -----Dashborad logo--- */
        array(
            'id' => 'dashborad_header_logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Upload dashboard logo', 'nokri'),
            'compiler' => 'true',
            'desc' => esc_html__('Size 230 * 40', 'nokri'),
            'subtitle' => esc_html__('Upload dashboard logo', 'nokri'),
            'default' => array('url' => get_template_directory_uri() . '/images/logo.png'),
        ),
        array(
            'id' => 'banners_code',
            'type' => 'textarea',
            'title' => __('Custom CSS/Javascript', 'nokri'),
            'subtitle' => __('Paste your style/scripts here ', 'nokri'),
            'default' => '',
        ),
    )
));
/* ------------------ Url Rewriting Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Url Rewriting', 'nokri'),
    'id' => 'sb-api-settings-rewrite',
    'desc' => '',
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'sb_url_rewriting_enable',
            'type' => 'switch',
            'title' => __('Enable url rewriting for job details', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'sb_ad_slug',
            'type' => 'text',
            'title' => __('Nokri joabboard slug', 'nokri'),
            'required' => array('sb_url_rewriting_enable', '=', '1'),
            'default' => "",
        ),
        array(
            'id' => 'sb_url_rewriting_users',
            'type' => 'switch',
            'title' => __('Enable url rewriting for users', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'employer_txt',
            'type' => 'text',
            'title' => __('Employer slug', 'nokri'),
            'required' => array('sb_url_rewriting_users', '=', '1'),
            'default' => "",
        ),
        array(
            'id' => 'candidate_txt',
            'type' => 'text',
            'title' => __('Candidate slug', 'nokri'),
            'required' => array('sb_url_rewriting_users', '=', '1'),
            'default' => "",
        ),
        array(
            'id' => 'sb_attched_files_slug_rewriting',
            'type' => 'switch',
            'title' => __('Rewrite Attchments slug', 'nokri'),
            'subtitle' => __('Rewrite slug of uploaded docs/pdfs', 'nokri'),
            'desc' => __('NOTE: On if you you have knowledge for slug rewrite else ignore this.', 'nokri'),
            'default' => false,
        ),
    )
));
/* Map Settings Starts From Here */
Redux::setSection($opt_name, array(
    'title' => __('Map Settings', 'nokri'),
    'id' => 'map_settings',
    'desc' => __("Here you can setup the Map Settings for the theme. We have two type of map api's.", "nokri"),
    'icon' => 'el el-map-marker-alt',
    'fields' => array(
        array(
            'id' => 'nokri_allow_map',
            'type' => 'switch',
            'title' => esc_html__('Maps Hide/Show', 'nokri'),
            'subtitle' => esc_html__('Use this for maps on/off', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'map-setings-map-type',
            'type' => 'button_set',
            'title' => __('Map Type', 'nokri'),
            'subtitle' => __('Select Map', 'nokri'),
            'required' => array('nokri_allow_map', '=', true),
            'desc' => __('Select map type you want to add in the theme. By default google map is activated.', 'nokri'),
            'options' => array(
                'google_map' => __('Google Map', 'nokri'),
                'leafletjs_map' => __('Leafletjs/OpenStreet Map', 'nokri'),
            ),
            'default' => 'google_map'
        ),
        array(
            'id' => 'allow_lat_lon',
            'type' => 'switch',
            'title' => esc_html__('Latitude & Longitude', 'nokri'),
            'required' => array('nokri_allow_map', '=', true),
            'subtitle' => esc_html__('Keep this button on while using Maps', 'nokri'),
            'desc' => esc_html__('This will be display on ad post page for pin point map', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'sb_default_lat',
            'type' => 'text',
            'title' => esc_html__('Latitude', 'nokri'),
            'subtitle' => esc_html__('for default map.', 'nokri'),
            'required' => array('allow_lat_lon', '=', true),
            'default' => '40.7127837',
        ),
        array(
            'id' => 'sb_default_long',
            'type' => 'text',
            'title' => esc_html__('Longitude', 'nokri'),
            'subtitle' => esc_html__('for default map.', 'nokri'),
            'required' => array('allow_lat_lon', '=', true),
            'default' => '-74.00594130000002',
        ),
    )
));
/* ------------------ Zoom API Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Zoom API Setting', 'nokri'),
    'id' => 'sb-zoom-settings',
    'desc' => '',
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'zoom_meeting_btn',
            'type' => 'switch',
            'title' => esc_html__('Zoom Meetings', 'nokri'),
            'desc' => esc_html__('On/Off Zoom Meetings', 'nokri'),
            'default' => false,
        ),
)));
/* ------------------ API Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('API Settings', 'nokri'),
    'id' => 'sb-api-settings',
    'desc' => '',
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'mailchimp_api_list_id',
            'type' => 'text',
            'title' => esc_html__('MailChimp List Id', 'nokri'),
            'desc' => nokri_make_link('https://kb.mailchimp.com/lists/manage-contacts/find-your-list-id', esc_html__('How to Find it', 'nokri')),
        ),
        array(
            'id' => 'gmap_api_key',
            'type' => 'text',
            'title' => esc_html__('Google API Key for map', 'nokri'),
            'desc' => nokri_make_link('https://developers.google.com/maps/documentation/javascript/get-api-key', esc_html__('How to Find it', 'nokri')),
            'default' => 'AIzaSyB_La6qmewwbVnTZu5mn3tVrtu6oMaSXaI',
        ),
        array(
            'id' => 'fb_api_key',
            'type' => 'text',
            'title' => esc_html__('Facebook Client ID', 'nokri'),
            'desc' => nokri_make_link('https://developers.facebook.com/?advanced_app_create=true', esc_html__('How to Make', 'nokri')),
        ),
        array(
            'id' => 'gmail_api_key',
            'type' => 'text',
            'title' => esc_html__('Gmail Client ID', 'nokri'),
            'desc' => nokri_make_link('https://console.developers.google.com/apis/api/gmail/', esc_html__('How to Find it', 'nokri')),
        ),
        array(
            'id' => 'linkedin_api_key',
            'type' => 'text',
            'title' => esc_html__('Linkedin api key', 'nokri'),
            'desc' => nokri_make_link('https://developer.linkedin.com/docs/oauth2#', esc_html__('How to Find it', 'nokri')),
        ),
        array(
            'id' => 'linkedin_api_secret',
            'type' => 'text',
            'title' => esc_html__('Linkedin secret', 'nokri'),
        //'desc' => nokri_make_link ( 'https://console.developers.google.com/apis/api/gmail/' , esc_html__( 'How to Find it' , 'nokri' ) ),
        ),
        array(
            'id' => 'google_recaptcha_key',
            'type' => 'text',
            'title' => esc_html__('Google ReCAPTCHA API Key', 'nokri'),
            'subtitle' => '',
            'desc' => nokri_make_link('https://www.google.com/recaptcha/admin', esc_html__('How to Find it', 'nokri')),
            'default' => '',
        ),
        array(
            'id' => 'google_recaptcha_secret_key',
            'type' => 'text',
            'title' => esc_html__('Google ReCAPTCHA API Secret', 'nokri'),
            'subtitle' => '',
            'desc' => nokri_make_link('https://www.google.com/recaptcha/admin', esc_html__('How to Find it', 'nokri')),
            'default' => '',
        ),
        array(
            'id' => 'firebase_switch',
            'type' => 'switch',
            'title' => __('Enable Firebase Authentication', 'nokri'),
            'desc' => esc_html__('This option is for mobile number verification for both Employers and candidates', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'firebase_project_id',
            'required' => array('firebase_switch', '=', true),
            'type' => 'text',
            'title' => esc_html__('Firebase Project ID', 'nokri'),
            'subtitle' => '',
            'desc' => nokri_make_link('https://console.firebase.google.com/project/fir-demo-project/overview', esc_html__('How to Find it', 'nokri')),
            'default' => '',
        ),
        array(
            'id' => 'firebase_app_id',
            'required' => array('firebase_switch', '=', true),
            'type' => 'text',
            'title' => esc_html__('Firebase App ID', 'nokri'),
            'subtitle' => '',
            'desc' => nokri_make_link('https://console.firebase.google.com/project/', esc_html__('How to Find it', 'nokri')),
            'default' => '',
        ),
        array(
            'id' => 'firebase_sender_id',
            'required' => array('firebase_switch', '=', true),
            'type' => 'text',
            'title' => esc_html__('Firebase Sender ID', 'nokri'),
            'subtitle' => '',
            'desc' => nokri_make_link('https://console.firebase.google.com/project/nokri-auth/settings/cloudmessaging/', esc_html__('How to Find it', 'nokri')),
            'default' => '',
        ),
        array(
            'id' => 'firebase_api_key',
            'required' => array('firebase_switch', '=', true),
            'type' => 'text',
            'title' => esc_html__('Firebase Api Key', 'nokri'),
            'subtitle' => '',
            'desc' => nokri_make_link('https://console.firebase.google.com/project/fir-demo-project/overview', esc_html__('How to Find it', 'nokri')),
            'default' => '',
        ),
        array(
            'id' => 'redirect_uri',
            'type' => 'text',
            'title' => esc_html__('Redirect URI', 'nokri'),
            'desc' => esc_html__('Must be URI where you want to redirect after athentication, it will be your web url.', 'nokri'),
        ),
    )
));
/* ------------------Job  Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Jobs Settings', 'nokri'),
    'id' => 'nokri_jobs_genral',
    'desc' => '',
    'icon' => 'el el-briefcase',
));
/* Job post form setting */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Job Post Form', 'nokri'),
    'id' => 'sb_job_post_form_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'icon' => 'el el-list-alt',
    'fields' => array(
        array(
            'id' => 'job_post_form',
            'type' => 'button_set',
            'title' => esc_html__('Select job post form', 'nokri'),
            'options' => array(
                '0' => esc_html__('Default form', 'nokri'),
                '1' => esc_html__('Category base', 'nokri'),
            ),
            'default' => '0',
        ),
        array(
            'id' => 'job_apply_with',
            'type' => 'switch',
            'title' => esc_html__('Job with external Source', 'nokri'),
            'desc' => esc_html__('Enable/disable job apply with external link', 'nokri'),
            'default' => false,
        ),
        $fields = array(
    'required' => array('job_apply_with', '=', array('1')),
    'id' => 'job_external_source',
    'type' => 'button_set',
    'title' => __('Select external apply options', 'nokri'),
    'desc' => __('You can select multiple', 'nokri'),
    'multi' => true,
    //Must provide key => value pairs for options
    'options' => array(
        'inter' => __('Internal Link', 'nokri'),
        'exter' => __('External Link', 'nokri'),
        'mail' => __('Email', 'nokri'),
        'whatsapp' => __('Whatsapp', 'nokri'),
    ),
    'default' => 'inter',
        ),
        /* Custom feilds options */
        array(
            'id' => 'default_job_attachment',
            'type' => 'switch',
            'title' => esc_html__('Job Attachments', 'nokri'),
            'desc' => esc_html__('Enable/disable attachments', 'nokri'),
            'default' => false,
        ),
        array(
            //'required' => array( 'job_post_form', '=', array( '1' ) ),
            'id' => 'sb_upload_attach_size',
            'type' => 'select',
            'title' => esc_html__('Attachment size', 'nokri'),
            'options' => array('307200-300kb' => '300kb', '614400-600kb' => '600kb', '819200-800kb' => '800kb', '1048576-1MB' => '1MB', '2097152-2MB' => '2MB', '3145728-3MB' => '3MB', '4194304-4MB' => '4MB', '5242880-5MB' => '5MB'),
            'default' => '819200-800kb',
        ),
        array(
            //'required' => array( 'job_post_form', '=', array( '1' ) ),
            'id' => 'sb_upload_attach_limit',
            'type' => 'select',
            'title' => esc_html__('Attachment limit', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15),
            'default' => 5,
        ),
        $fields = array(
    //'required' => array( 'job_post_form', '=', array( '1' ) ),
    'id' => 'sb_upload_attach_format',
    'type' => 'button_set',
    'title' => __('Select attachments formats', 'nokri'),
    'desc' => __('You can select multiple file formats', 'nokri'),
    'multi' => true,
    //Must provide key => value pairs for options
    'options' => array(
        'pdf' => __('Pdf', 'nokri'),
        'doc' => __('Doc', 'nokri'),
        'docx' => __('Docx', 'nokri'),
        'jpg' => __('Jpg', 'nokri'),
        'png' => __('Png', 'nokri'),
        'jpeg' => __('Jpeg', 'nokri'),
        'gif' => __('Gif', 'nokri'),
        'txt' => __('Txt', 'nokri'),
    ),
    'default' => 'pdf',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_qualifications',
    'type' => 'button_set',
    'title' => __('Qualifications Taxonomy', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_qualifications', '=', array('show', 'required')),
            'id' => 'quali_txt',
            'type' => 'text',
            'title' => esc_html__('Qualifications Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_type',
    'type' => 'button_set',
    'title' => __('Type Taxonomy', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_type', '=', array('show', 'required')),
            'id' => 'type_txt',
            'type' => 'text',
            'title' => esc_html__('Type Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_salary_type',
    'type' => 'button_set',
    'title' => __('Salary Type Taxonomy', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_salary_type', '=', array('show', 'required')),
            'id' => 'salary_type_txt',
            'type' => 'text',
            'title' => esc_html__('Salary Type Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_currency',
    'type' => 'button_set',
    'title' => __('Currency Taxonomy', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_currency', '=', array('show', 'required')),
            'id' => 'job_currency_txt',
            'type' => 'text',
            'title' => esc_html__('Currency Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_salary',
    'type' => 'button_set',
    'title' => __('Salary Taxonomy', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_salary', '=', array('show', 'required')),
            'id' => 'job_salary_txt',
            'type' => 'text',
            'title' => esc_html__('Salary Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_experience',
    'type' => 'button_set',
    'title' => __('Experience Taxonomy', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_experience', '=', array('show', 'required')),
            'id' => 'experience_txt',
            'type' => 'text',
            'title' => esc_html__('Experience Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_shift',
    'type' => 'button_set',
    'title' => __('Shift Taxonomy', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_shift', '=', array('show', 'required')),
            'id' => 'shift_txt',
            'type' => 'text',
            'title' => esc_html__('Shift Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_level',
    'type' => 'button_set',
    'title' => __('Level Taxonomy', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_level', '=', array('show', 'required')),
            'id' => 'level_txt',
            'type' => 'text',
            'title' => esc_html__('Level Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_vacancy',
    'type' => 'button_set',
    'title' => __('Job Vacancies', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_vacancy', '=', array('show', 'required')),
            'id' => 'vacancy_txt',
            'type' => 'text',
            'title' => esc_html__('Vacancies Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_skills',
    'type' => 'button_set',
    'title' => __('Skills Taxonomy', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_skills', '=', array('show', 'required')),
            'id' => 'skills_txt',
            'type' => 'text',
            'title' => esc_html__('Skills Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_tags',
    'type' => 'button_set',
    'title' => __('Tags Taxonomy', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_tags', '=', array('show', 'required')),
            'id' => 'tags_txt',
            'type' => 'text',
            'title' => esc_html__('Tags Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_skills',
    'type' => 'button_set',
    'title' => __('Skills Taxonomy', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_skills', '=', array('show', 'required')),
            'id' => 'skills_txt',
            'type' => 'text',
            'title' => esc_html__('Skills Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_countries',
    'type' => 'button_set',
    'title' => __('Countries Taxonomy', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        $fields = array(
    'required' => array('job_post_form', '=', array('0')),
    'id' => 'allow_job_adress',
    'type' => 'button_set',
    'title' => __('Map Address', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'required',
        ),
        array(
            'required' => array('allow_job_adress', '=', array('show', 'required')),
            'id' => 'adres_txt',
            'type' => 'text',
            'title' => esc_html__('Address Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
/* Job Post Setting start */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Job Post', 'nokri'),
    'id' => 'sb_job_posts_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'icon' => 'el el-ok',
    'fields' => array(
        array(
            'id' => 'job_post_for_admin',
            'type' => 'switch',
            'title' => esc_html__('Only admin can post', 'nokri'),
            'desc' => esc_html__('Enable if only admin can post jobs', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('job_post_for_admin', '=', true),
            'id' => 'job_post_for_admin_message',
            'type' => 'textarea',
            'title' => esc_html__('Message on job post', 'nokri'),
            'subtitle' => esc_html__('This message is for already registred employers', 'nokri'),
            'default' => esc_html__('Admin disabled job posting', 'nokri'),
        ),
        array(
            'id' => 'sb_ad_approval',
            'type' => 'select',
            'options' => array('auto' => 'Auto Approved', 'manual' => 'Admin manual approval'),
            'title' => esc_html__('Job Approval', 'nokri'),
            'default' => 'auto',
        ),
        array(
            'id' => 'sb_update_approval',
            'type' => 'select',
            'options' => array('auto' => 'Auto Approved', 'manual' => 'Admin manual approval'),
            'title' => esc_html__('Job Update Approval', 'nokri'),
            'default' => 'auto',
        ),
        array(
            'id' => 'job_post_note',
            'type' => 'textarea',
            'title' => esc_html__('Job Post Note', 'nokri'),
            'desc' => esc_html__('This Will Show On Job Post Page', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'allow_lat_lon_btn',
            'type' => 'switch',
            'title' => esc_html__('Latitude & Longitude', 'nokri'),
            'desc' => esc_html__('This will be display on ad post page for pin point map', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'sb_default_lat_job',
            'type' => 'text',
            'title' => esc_html__('Latitude', 'nokri'),
            'subtitle' => esc_html__('for default map.', 'nokri'),
            'required' => array('allow_lat_lon_btn', '=', true),
            'default' => '40.7127837',
        ),
        array(
            'id' => 'sb_default_long_job',
            'type' => 'text',
            'title' => esc_html__('Longitude', 'nokri'),
            'subtitle' => esc_html__('for default map.', 'nokri'),
            'required' => array('allow_lat_lon_btn', '=', true),
            'default' => '-74.00594130000002',
        ),
        array(
            'id' => 'allow_bump_jobs',
            'type' => 'switch',
            'title' => __('Add Bump up jobs', 'nokri'),
            'subtitle' => __('For employers', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'allow_remotely_jobs_post',
            'type' => 'switch',
            'title' => __('Work Remotely', 'nokri'),
            'subtitle' => __('For employers enabel/disable remotely work aginst job', 'nokri'),
            'desc' => esc_html__('This option will On/off remotely work option on Job Post Page ', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'restrict_job_update',
            'type' => 'switch',
            'title' => __('Restrict user to update job', 'nokri'),
            'subtitle' => __('Emplyer cant update job', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'days_of_jobs_update',
            'required' => array('restrict_job_update', '=', '1'),
            'type' => 'select',
            'title' => esc_html__('Days to restrcit job update', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 15 => 15, 15 => 15, 16 => 16,
                17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21, 22 => 22, 23 => 23, 24 => 24, 25 => 25),
            'default' => 5,
            'desc' => esc_html__('Add days to restrict job update', 'nokri'),
        ),
        array(
            'id' => 'job_exp_limit_switch',
            'type' => 'switch',
            'title' => esc_html__('Job Expiry limit', 'nokri'),
            'desc' => esc_html__('Restriction on job expiry date', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('relateds_jobs_switch', '=', array('1')),
            'id' => 'job_exp_limit',
            'type' => 'spinner',
            'title' => __('Job expiry days', 'nokri'),
            'desc' => __('Set number days for job expiry', 'nokri'),
            'default' => '30',
            'min' => '1',
            'step' => '5',
            'max' => '1000',
            'required' => array('job_exp_limit_switch', '=', array('1')),
        ),
        array(
            'id' => 'bad_words_filter',
            'type' => 'textarea',
            'title' => esc_html__('Bad Words Filter', 'nokri'),
            'subtitle' => esc_html__('comma separated', 'nokri'),
            'placeholder' => esc_html__('word1,word2', 'nokri'),
            'desc' => esc_html__('These words will be removed from job Title and Description', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'bad_words_replace',
            'type' => 'text',
            'title' => esc_html__('Bad Words Replace Word', 'nokri'),
            'desc' => esc_html__('These words will be replace with above bad words list from job Title and Description', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'sb_post_ad_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Job Post Page', 'nokri'),
            'default' => array('17'),
        ),
        array(
            'id' => 'addon_text',
            'type' => 'text',
            'title' => esc_html__('Addon  Text', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'allow_questinares',
            'type' => 'switch',
            'title' => esc_html__('Questionnaire', 'nokri'),
            'desc' => esc_html__('Allow questionnaire on job post page', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('allow_questinares', '=', array('1')),
            'id' => 'question_label',
            'type' => 'text',
            'title' => esc_html__('Question Label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('allow_questinares', '=', array('1')),
            'id' => 'question_plc',
            'type' => 'text',
            'title' => esc_html__('Question Placeholder', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('allow_questinares', '=', array('1')),
            'id' => 'question_ad_btn',
            'type' => 'text',
            'title' => esc_html__('Add More Button Title', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('allow_questinares', '=', array('1')),
            'id' => 'question_rem_btn',
            'type' => 'text',
            'title' => esc_html__('Remove Button Title', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'job_cat_level_1',
            'type' => 'text',
            'title' => esc_html__('Category Heading Level 1', 'nokri'),
            'default' => 'Job category',
        ),
        array(
            'id' => 'job_cat_level_2',
            'type' => 'text',
            'title' => esc_html__('Category Heading Level 2', 'nokri'),
            'default' => 'Sub category',
        ),
        array(
            'id' => 'job_cat_level_3',
            'type' => 'text',
            'title' => esc_html__('Category Heading Level 3', 'nokri'),
            'default' => 'Sub sub category',
        ),
        array(
            'id' => 'job_cat_level_4',
            'type' => 'text',
            'title' => esc_html__('Category Heading Level 4', 'nokri'),
            'default' => 'Sub sub sub category',
        ),
        array(
            'id' => 'job_country_level_heading',
            'type' => 'text',
            'title' => esc_html__('Location section heading', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'job_country_level_1',
            'type' => 'text',
            'title' => esc_html__('Location Heading Level 1', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'job_country_level_2',
            'type' => 'text',
            'title' => esc_html__('Location Heading Level 2', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'job_country_level_3',
            'type' => 'text',
            'title' => esc_html__('Location Heading Level 3', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'job_country_level_4',
            'type' => 'text',
            'title' => esc_html__('Location Heading Level 4', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'job_map_heading_txt',
            'type' => 'text',
            'title' => esc_html__('Map heading text', 'nokri'),
            'default' => '',
        ),
    )
));
/* Single Job setting start */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Job Detail', 'nokri'),
    'id' => 'sb_job_details_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'icon' => 'el el-photo',
    'fields' => array(
        array(
            'id' => 'job_post_style',
            'type' => 'button_set',
            'title' => esc_html__('Single Page Style', 'nokri'),
            'options' => array(
                '1' => esc_html__('Style 1', 'nokri'),
                '2' => esc_html__('Style 2', 'nokri'),
                '4' => esc_html__('Style 3', 'nokri'),
            ),
            'default' => '1',
        ),
        array(
            'id' => 'single_resume_counter',
            'type' => 'switch',
            'title' => __('Enable/disable total Applicants counter', 'nokri'),
            'subtitle' => __('Hide/show total applicants counter who applied on Job', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'single_job_schema',
            'type' => 'switch',
            'title' => esc_html__('Enable/disable job schema', 'nokri'),
            'desc' => esc_html__('Hide/show job schema', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'single_job_tags',
            'type' => 'switch',
            'title' => esc_html__('Enable/disable job tags', 'nokri'),
            'desc' => esc_html__('Hide/show related job tags on job detail page', 'nokri'),
            'default' => true,
        ),
        /* Apply without login */
        array(
            'id' => 'apply_without_login',
            'type' => 'switch',
            'title' => esc_html__('Apply without login', 'nokri'),
            'desc' => esc_html__('Enable/disable apply without login', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'upload_resume_option',
            'type' => 'button_set',
            'title' => __('Upload resume', 'nokri'),
            'desc' => __('Upload resume while apply on job (login user)', 'nokri'),
            'options' => array(
                'req' => __('Required', 'nokri'),
                'opt' => __('Optional', 'nokri'),
                'no-field' => __('Hide field', 'nokri'),
            ),
            'default' => 'req',
        ),
        array(
            'id' => 'job_apply_on_detail',
            'type' => 'switch',
            'title' => esc_html__('Apply to jobs on detail page', 'nokri'),
            'default' => false,
            'description' => esc_html__('Candidate can only apply on job from job detail page', 'nokri'),
        ),
        array(
            'id' => 'cand_linkedin_apply',
            'type' => 'switch',
            'title' => esc_html__('Linkedin Apply', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'email_job_anyone_switch',
            'type' => 'switch',
            'title' => esc_html__('Email Job To Anyone', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => '_nokri_cand_report_job',
            'type' => 'switch',
            'title' => esc_html__('Report Job to Admin', 'nokri'),
            'description' => esc_html__('Candidate can report a job to admin on the job details page', 'nokri'),
            'default' => false,
        ),
        $fields = array(
    'required' => array('_nokri_cand_report_job', '=', array('1')),
    'id' => 'number_of_job_reports',
    'type' => 'spinner',
    'title' => __('Allowed Number of Job Reports', 'nokri'),
    'desc' => __('Set number of Reports', 'nokri'),
    'default' => '5',
    'min' => '1',
    'step' => '2',
    'max' => '20',
        ),
        array(
            'required' => array('_nokri_cand_report_job', '=', array('1')),
            'id' => 'nokri_job_report_text1',
            'type' => 'text',
            'title' => esc_html__('Enter Report Heading', 'nokri'),
            'default' => esc_html__('This is Spam', 'nokri'),
        ),
        array(
            'required' => array('_nokri_cand_report_job', '=', array('1')),
            'id' => 'nokri_job_report_text2',
            'type' => 'text',
            'title' => esc_html__('Enter Report Heading', 'nokri'),
            'default' => esc_html__('Abusive Content'),
        ),
        array(
            'required' => array('_nokri_cand_report_job', '=', array('1')),
            'id' => 'nokri_job_report_text3',
            'type' => 'text',
            'title' => esc_html__('Enter Report Heading', 'nokri'),
            'default' => esc_html__('Fake Employer', 'nokri'),
        ),
        array(
            'required' => array('_nokri_cand_report_job', '=', array('1')),
            'id' => 'nokri_job_report_text4',
            'type' => 'text',
            'title' => esc_html__('Enter Report Heading', 'nokri'),
            'default' => esc_html__('Job does not exist', 'nokri'),
        ),
        array(
            'required' => array('_nokri_cand_report_job', '=', array('1')),
            'id' => 'nokri_job_report_text_desc',
            'type' => 'text',
            'title' => esc_html__('Enter Report Description Heading', 'nokri'),
            'default' => esc_html__('Job does not exist', 'nokri'),
        ),
        array(
            'id' => 'social_media_logo_switch',
            'type' => 'switch',
            'title' => esc_html__('Customize social media image', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('social_media_logo_switch', '=', array('1')),
            'id' => 'social_media_share_logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Upload Social image here ', 'nokri'),
            'compiler' => 'true',
            'desc' => esc_html__('Size 700 * 500', 'nokri'),
            'subtitle' => esc_html__('upload Social share', 'nokri'),
            'default' => array('url' => get_template_directory_uri() . '/images/logo.png'),
        ),
        array(
            'id' => 'relateds_jobs_switch',
            'type' => 'switch',
            'title' => esc_html__('Enable/disable related jobs', 'nokri'),
            'desc' => esc_html__('Hide/show related jobs on job detail page', 'nokri'),
            'default' => true,
        ),
        $fields = array(
    'required' => array('relateds_jobs_switch', '=', array('1')),
    'id' => 'relateds_jobs_numbers',
    'type' => 'spinner',
    'title' => __('Related jobs number', 'nokri'),
    'desc' => __('Set number of jobs', 'nokri'),
    'default' => '5',
    'min' => '1',
    'step' => '2',
    'max' => '20',
        ),
        array(
            'id' => 'nearby_job_switch',
            'type' => 'switch',
            'title' => esc_html__('Enable/disable Nearby jobs ', 'nokri'),
            'desc' => esc_html__('Hide/show nearby jobs on job detail page', 'nokri'),
            'default' => false,
        ),
        $fields = array(
    'required' => array('nearby_job_switch', '=', array('1')),
    'id' => 'nearby_jobs_numbers',
    'type' => 'spinner',
    'title' => __('Near by jobs number', 'nokri'),
    'desc' => __('Set number of jobs', 'nokri'),
    'default' => '5',
    'min' => '1',
    'max' => '20',
        ),
        $fields = array(
    'required' => array('nearby_job_switch', '=', array('1')),
    'id' => 'nearby_jobs_distance',
    'type' => 'spinner',
    'title' => __('Near by jobs Distance', 'nokri'),
    'desc' => __('Set Distance', 'nokri'),
    'default' => '10',
    'step' => '10',
        ),
        array(
            'required' => array('nearby_job_switch', '=', array('1')),
            'id' => 'nearby_jobs_unit',
            'type' => 'button_set',
            'title' => esc_html__('Search page Layout', 'nokri'),
            'options' => array(
                'km' => 'KM',
                'mile' => 'Mile',
            ),
            'default' => 'km'
        ),
        array(
            'id' => 'formated_text_allow_check',
            'type' => 'switch',
            'title' => esc_html__('Allow formated text', 'nokri'),
            'desc' => esc_html__('Allow formated text in job description', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'single_job_advert_switch',
            'type' => 'switch',
            'title' => esc_html__('Enable/disable Advertisement', 'nokri'),
            'desc' => esc_html__('Hide/show related advertisement on job detail job', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('single_job_advert_switch', '=', array('1')),
            'id' => 'single_job_advert_up',
            'type' => 'textarea',
            'title' => esc_html__('Above the Job description', 'nokri'),
            'subtitle' => __('728 x 90', 'nokri'),
            'desc' => __('Wrap into div class="n-advert-box" if static image', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('single_job_advert_switch', '=', array('1')),
            'id' => 'single_job_advert_down',
            'type' => 'textarea',
            'title' => esc_html__('Below the Job description', 'nokri'),
            'subtitle' => __('728 x 90', 'nokri'),
            'desc' => __('Wrap into div class="n-advert-box" if static image', 'nokri'),
            'default' => '',
        ),
    )
));
/* Job Search setting start */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Job Search', 'nokri'),
    'id' => 'sb_job_search_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'icon' => 'el el-search',
    'fields' => array(
        array(
            'id' => 'sb_search_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Search Page', 'nokri'),
            'default' => array('13'),
        ),
        array(
            //'required' => array( 'main_header_style', '=', array( '2') ),
            'id' => 'page_full_width',
            'type' => 'switch',
            'title' => esc_html__('Page Full Width', 'nokri'),
            'subtitle' => esc_html__('Enable/Disable Full Width Jobs Page', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'search_page_layout',
            'type' => 'button_set',
            'title' => esc_html__('Search page Layout', 'nokri'),
            'options' => array(
                '1' => 'Grid Stlye',
                '2' => 'List Style',
                '3' => 'With Map',
            ),
            'default' => '1'
        ),
        array(
            'id' => 'search_page_widget_style',
            'type' => 'button_set',
            'title' => esc_html__('Search page Layout', 'nokri'),
            'options' => array(
                '1' => 'Horizontal',
                '2' => 'Vertical',
            ),
            'default' => '2'
        ),
        array(
            'id' => 'search_mobile_filter',
            'type' => 'switch',
            'title' => esc_html__('Show mobile Filters', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('search_page_layout', '=', array('3')),
            'id' => 'map_marker_img',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Map marker image', 'nokri'),
            'compiler' => 'true',
            'default' => array('url' => get_template_directory_uri() . '/images/map-loacation.png'),
        ),
        array(
            'id' => 'premium_jobs_class_switch',
            'type' => 'switch',
            'title' => esc_html__('Premium Jobs', 'nokri'),
            'subtitle' => esc_html__('Hide/Show Premium Jobs at top of job list', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'premium_jobs_class_title',
            'type' => 'text',
            'title' => esc_html__('Section title', 'nokri'),
            'default' => esc_html__('Premium jobs', 'nokri'),
        ),
        array(
            'required' => array('premium_jobs_class_switch', '=', array('1')),
            'id' => 'premium_jobs_class',
            'type' => 'select',
            'data' => 'terms',
            'args' => array(
                'taxonomies' => 'job_class', 'hide_empty' => false,
            ),
            'multi' => true,
            'sortable' => false,
            'title' => __('Select Job Class ', 'nokri'),
            'desc' => __('job show top on search page', 'nokri'),
        ),
        array(
            'required' => array('premium_jobs_class_switch', '=', array('1')),
            'id' => 'premium_jobs_class_number',
            'type' => 'spinner',
            'title' => __('Number Of Jobs', 'nokri'),
            'desc' => __('Select Number Of job that show on search page', 'nokri'),
            'default' => '5',
            'min' => '1',
            'step' => '1',
            'max' => '50',
        ),
        array(
            'id' => 'job_alerts_switch',
            'type' => 'switch',
            'title' => esc_html__('Job alert button', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('job_alerts_switch', '=', array('1')),
            'id' => 'job_alert_paid_switch',
            'type' => 'switch',
            'title' => esc_html__('Paid job alert', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array(
                array('job_alerts_switch', '=', array('1')),
                array('job_alert_paid_switch', '=', false),
            ),
            'id' => 'job_alerts_tax',
            'type' => 'button_set',
            'title' => __('Select your desired options', 'nokri'),
            'desc' => __('You can select multiples options ,Select one Geo location Or custom Location', 'nokri'),
            'multi' => true,
            //Must provide key => value pairs for options
            'options' => array(
                'job_category' => __('Job Category', 'nokri'),
                'job_type' => __('Job Type', 'nokri'),
                'job_experience' => __('Job Experience', 'nokri'),
                'ad_location' => __('Job Location', 'nokri'),
                'ad_geo_location' => __('Geo Location', 'nokri'),
            ),
            'default' => 'job_category',
        ),
        array(
            'required' => array(
                array('job_alerts_switch', '=', array('1')),
                array('job_alert_paid_switch', '=', true),
            ),
            'id' => 'job_alert_package',
            'type' => 'select',
            'options' => nokri_get_products_theme_options('3'),
            'multi' => false,
            'sortable' => false,
            'title' => __('Alert Package', 'nokri'),
            'subtitle' => __('Select Alert Package ', 'nokri'),
        ),
        array(
            'required' => array(
                array('job_alerts_switch', '=', array('1')),
                array('job_alert_paid_switch', '=', true),
            ),
            'id' => 'paid_job_alerts_tax',
            'type' => 'button_set',
            'title' => __('Select your desired options', 'nokri'),
            'desc' => __('You can select multiples options', 'nokri'),
            'multi' => true,
            //Must provide key => value pairs for options
            'options' => array(
                'job_category' => __('Job Category', 'nokri'),
                'ad_location' => __('Job Location', 'nokri'),
            ),
            'default' => 'job_category',
        ),
        array(
            'required' => array('job_alerts_switch', '=', array('1')),
            'id' => 'job_alerts_title',
            'type' => 'text',
            'title' => esc_html__('Job alerts', 'nokri'),
            'default' => esc_html__('Job alerts', 'nokri'),
        ),
        array(
            'required' => array('job_alerts_switch', '=', array('1')),
            'id' => 'job_alerts_tagline',
            'type' => 'text',
            'title' => esc_html__('Job alert tagline', 'nokri'),
            'default' => esc_html__('Receive emails for the latest jobs matching your search criteria', 'nokri'),
        ),
        array(
            'required' => array('job_alerts_switch', '=', array('1')),
            'id' => 'job_alerts_btn',
            'type' => 'text',
            'title' => esc_html__('Job alert button title ', 'nokri'),
            'default' => esc_html__('Job Alerts', 'nokri'),
        ),
        array(
            'id' => 'cat_level_2',
            'type' => 'text',
            'title' => esc_html__('Category Heading Level 2', 'nokri'),
            'default' => 'Sub Category',
        ),
        array(
            'id' => 'cat_level_3',
            'type' => 'text',
            'title' => esc_html__('Category Heading Level 3', 'nokri'),
            'default' => 'Sub Sub Category',
        ),
        array(
            'id' => 'cat_level_4',
            'type' => 'text',
            'title' => esc_html__('Category Heading Level 4', 'nokri'),
            'default' => 'Sub Sub Sub Category',
        ),
        array(
            'id' => 'multi_job_search_form',
            'type' => 'switch',
            'title' => esc_html__('Enable/disable multi Search', 'nokri'),
            'desc' => esc_html__('Enable/disable multi Search form on Search page', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'job_search_loader',
            'type' => 'switch',
            'title' => esc_html__('On off Loader on Search page', 'nokri'),
            'desc' => esc_html__('On off Loader on Search page', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'search_job_advert_switch',
            'type' => 'switch',
            'title' => esc_html__('Enable/disable Advertisement', 'nokri'),
            'desc' => esc_html__('Hide/show related advertisement on search page', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('search_job_advert_switch', '=', array('1')),
            'id' => 'search_job_advert_up',
            'type' => 'textarea',
            'title' => esc_html__('Above the search Result', 'nokri'),
            'subtitle' => __('728 x 90', 'nokri'),
            'desc' => __('Wrap into div class="n-advert-box" if static image', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('search_job_advert_switch', '=', array('1')),
            'id' => 'search_job_advert_down',
            'type' => 'textarea',
            'title' => esc_html__('Below the search Result', 'nokri'),
            'subtitle' => __('728 x 90', 'nokri'),
            'desc' => __('Wrap into div class="n-advert-box" if static image', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'search_layout',
            'type' => 'button_set',
            'title' => esc_html__('Search Layout', 'nokri'),
            'options' => array(
                'list_1' => 'List 1',
            ),
            'default' => 'list_1'
        ),
    )
));
/* ------------------Users Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Users Settings', 'nokri'),
    'id' => 'nokri_users_genral',
    'desc' => '',
    'icon' => 'el el-user',
));
/* ------------------Genreal  options ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('General', 'nokri'),
    'id' => 'sb_user_profile_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'desc' => __('Settings for both employers and candidates', 'nokri'),
    'fields' => array(
        array(
            'id' => 'user_phone_verification',
            'type' => 'switch',
            'title' => __('Mobile number verification on register', 'nokri'),
            'subtitle' => __('code will be sent to user for verification', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'user_assign_pkg',
            'type' => 'switch',
            'title' => __('Assign package to employer', 'nokri'),
            'subtitle' => __('Assign package at time of registration', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('user_assign_pkg', '=', array('1')),
            'id' => 'register_package',
            'type' => 'select',
            'options' => nokri_get_products_theme_options('1'),
            'multi' => false,
            'sortable' => false,
            'title' => __('Select Employer Package', 'nokri'),
            'subtitle' => __('Select only free package', 'nokri'),
        ),
        array(
            'id' => 'cand_assign_pkg',
            'type' => 'switch',
            'title' => __('Assign package to candidate', 'nokri'),
            'subtitle' => __('Assign package at time of registration', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('cand_assign_pkg', '=', array('1')),
            'id' => 'cand_register_package',
            'type' => 'select',
            'options' => nokri_get_products_theme_options('0'),
            'multi' => false,
            'sortable' => false,
            'title' => __('Select Candidate Package', 'nokri'),
            'subtitle' => __('Select only free package', 'nokri'),
        ),
        array(
            'id' => 'cand_profile_redirect',
            'type' => 'switch',
            'title' => __('Restrict candidates', 'nokri'),
            'subtitle' => __('Show candidates profile to registered user only', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'sb_upload_profile_pic_size',
            'type' => 'select',
            'title' => esc_html__('Profile picture max size', 'nokri'),
            'options' => array('307200-300kb' => '300kb', '614400-600kb' => '600kb', '819200-800kb' => '800kb', '1048576-1MB' => '1MB', '2097152-2MB' => '2MB', '3145728-3MB' => '3MB', '4194304-4MB' => '4MB', '5242880-5MB' => '5MB'),
            'default' => '819200-800kb',
        ),
        array(
            'id' => 'user_phone_email',
            'type' => 'switch',
            'title' => __('Hide/Show phone and email', 'nokri'),
            'default' => true
        ),
        array(
            'id' => 'user_contact_form',
            'type' => 'switch',
            'title' => __('Hide/Show contact form', 'nokri'),
            'default' => true
        ),
        array(
            'id' => 'password_validator_switch',
            'type' => 'switch',
            'title' => __('Show validators on registration password', 'nokri'),
            'default' => false
        ),
        array(
            'id' => 'user_contact_form_recaptcha',
            'type' => 'switch',
            'title' => __('Hide/Show recaptcha in contact form', 'nokri'),
            'required' => array('user_contact_form', '=', '1'),
            'default' => true
        ),
        array(
            'id' => 'signin_form_recaptcha_switch',
            'type' => 'switch',
            'title' => __('Hide/Show recaptcha on login form', 'nokri'),
            'default' => false
        ),
        array(
            'id' => 'user_contact_social',
            'type' => 'switch',
            'title' => __('Hide/Show social links', 'nokri'),
            'default' => true
        ),
        array(
            'id' => 'user_profile_delete_option',
            'type' => 'switch',
            'title' => __('Account delete option', 'nokri'),
            'subtitle' => __('Allow users to delete account', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'nokri_user_profile_avatar',
            'type' => 'switch',
            'title' => __('Change user avatar to its profile image in admin dashboard', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'user_crop_dp_switch',
            'type' => 'switch',
            'title' => __('Crop user profile image', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'subscribe_on_user_register',
            'type' => 'switch',
            'title' => __('Subscribe Users On Registration', 'nokri'),
            'subtitle' => __('MailChimp List ID', 'nokri'),
            'default' => false
        ),
        array(
            'id' => 'subscribe_on_user_register_listid',
            'type' => 'text',
            'title' => __('MailChimp List ID', 'nokri'),
            'required' => array('subscribe_on_user_register', '=', true),
            'default' => '',
            'desc' => nokri_make_link('http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id', __('How to Find it', 'nokri')),
        ),
        array(
            'required' => array('subscribe_on_user_register', '=', true),
            'id' => 'subscriber_checkbox_on_register',
            'type' => 'switch',
            'title' => __('Show Confirmation Checkbox', 'nokri'),
            'desc' => __('show confirmation checkbox on registraction form', 'nokri'),
            'default' => false
        ),
        array(
            'id' => 'subscriber_checkbox_on_register_text',
            'type' => 'text',
            'title' => __('Confimation checkbox text', 'nokri'),
            'required' => array('subscriber_checkbox_on_register', '=', true),
            'default' => __('subscribe for latest news and updates', 'nokri'),
        ),
        array(
            'id' => 'user_profile_dashboard_txt',
            'type' => 'text',
            'title' => esc_html__('User dashboard text', 'nokri'),
            'default' => __('Howdy !', 'nokri'),
        ),
        array(
            'id' => 'default_profile_option',
            'type' => 'button_set',
            'title' => __('default user profile', 'nokri'),
            'desc' => __('Set user profile while registration', 'nokri'),
            'options' => array(
                'pub' => __('Public', 'nokri'),
                'priv' => __('private', 'nokri'),
            ),
            'default' => 'pub',
        ),
        array(
            'id' => 'user_private_txt',
            'type' => 'textarea',
            'title' => esc_html__('Private profile text', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'user_address_invoice',
            'type' => 'text',
            'title' => esc_html__('Company address on inovice', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'user_pagination',
            'type' => 'spinner',
            'title' => esc_html__('Show Users Per Page', 'nokri'),
            'desc' => __('Set number of user per page', 'nokri'),
            'default' => '10',
            'min' => '1',
            'step' => '1',
            'max' => '1000',
        ),
        array(
            'id' => 'user_custom_feild_txt',
            'type' => 'text',
            'title' => esc_html__('Custom Fields Section Text', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'id' => 'custom_registration_feilds',
    'type' => 'select',
    'title' => __('Registration Custom Fields', 'nokri'),
    'desc' => __('Select custom fields for registration page', 'nokri'),
    'data' => 'posts',
    'args' => array(
        'post_type' => 'custom_feilds',
        'posts_per_page' => -1,
        'orderby' => 'Date',
        'order' => 'ASC',
        'suppress_filters' => false,
    )
        ),
        $fields = array(
    'id' => 'custom_employer_feilds',
    'type' => 'select',
    'title' => __('Employer Custom Fields', 'nokri'),
    'desc' => __('Select custom fields for employer page', 'nokri'),
    'data' => 'posts',
    'args' => array(
        'post_type' => 'custom_feilds',
        'posts_per_page' => -1,
        'orderby' => 'Date',
        'order' => 'ASC',
        'suppress_filters' => false,
    )
        ),
        $fields = array(
    'id' => 'custom_candidate_feilds',
    'type' => 'select',
    'title' => __('Candidates Custom Fields', 'nokri'),
    'desc' => __('Select custom fields for candidate page', 'nokri'),
    'data' => 'posts',
    'args' => array(
        'post_type' => 'custom_feilds',
        'posts_per_page' => -1,
        'orderby' => 'Date',
        'order' => 'ASC',
        'suppress_filters' => false,
    )
        ),
    )
));
/* ------------------Users Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Employers Settings', 'nokri'),
    'id' => 'nokri_users_employer',
    'desc' => '',
    'icon' => 'el el-adult',
));
/* ------------------Employer  options ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Employers', 'nokri'),
    'id' => 'sb_employers_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'emp_profile_style',
            'type' => 'button_set',
            'title' => esc_html__('Employer Details Page Style', 'nokri'),
            'options' => array(
                '1' => esc_html__('Style 1', 'nokri'),
                '2' => esc_html__('Style 2', 'nokri'),
                '3' => esc_html__('Style 3', 'nokri'),
                '4' => esc_html__('Style 4', 'nokri'),
            ),
            'default' => '1',
        ),
        array(
            'id' => 'emp_listing_style',
            'type' => 'button_set',
            'title' => esc_html__('Employer Listing Style', 'nokri'),
            'options' => array(
                '1' => esc_html__('Style 1', 'nokri'),
                '2' => esc_html__('Style 2', 'nokri'),
            ),
            'default' => '1',
        ),
        array(
            'id' => 'emp_team_members',
            'type' => 'switch',
            'title' => esc_html__('Employer Team Members', 'nokri'),
            'subtitle' => esc_html__('Hide/show Employer Team Members on Employers dashboard and on detail page', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'emp_account_members',
            'type' => 'switch',
            'title' => esc_html__('Employer Account Members', 'nokri'),
            'subtitle' => esc_html__('Hide/show Employer Account Members on Employers Dashboard', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'team_member_pic_size',
            'type' => 'select',
            'title' => esc_html__('Team Member picture max size', 'nokri'),
            'options' => array('307200-300kb' => '300kb', '614400-600kb' => '600kb', '819200-800kb' => '800kb', '1048576-1MB' => '1MB', '2097152-2MB' => '2MB', '3145728-3MB' => '3MB', '4194304-4MB' => '4MB', '5242880-5MB' => '5MB'),
            'default' => '819200-800kb',
        ),
        array(
            'id' => 'emp_last_login_status',
            'type' => 'switch',
            'title' => esc_html__('Employer Last login time', 'nokri'),
            'subtitle' => esc_html__('Hide/show Employer Last login time on Employers detail page', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'employe_half_name_switch',
            'type' => 'switch',
            'title' => __('Employeer dotted name', 'nokri'),
            'subtitle' => __('Show hide Employeer dotted name', 'nokri'),
            'default' => false,
        ),
    )
));
/* ========================= */
/* Menu Setting */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Menu Setting', 'nokri'),
    'id' => 'sb_employer_menu',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        /* Menu sorter */
        array(
            'id' => 'employer_menu_sorter',
            'type' => 'sortable',
            'desc' => esc_html__('Click and drag for sorting', 'nokri'),
            'label' => false,
            'options' => array(
                'dashboard' => esc_html__('Dashboard', 'nokri'),
                'update_profile' => esc_html__('Udpdate Profile', 'nokri'),
                'view_my_profile' => esc_html__('View My Profile', 'nokri'),
                'my_jobs' => esc_html__('My Jobs', 'nokri'),
                'email_templates' => esc_html__('Email Templates', 'nokri'),
                'matched_resumes' => esc_html__('Matched Resumes', 'nokri'),
                'saved_resumes' => esc_html__('Saved Resumes', 'nokri'),
                'followers' => esc_html__('Followers', 'nokri'),
                'my_package' => esc_html__('My Package', 'nokri'),
                'my_rating' => esc_html__('My Ratings', 'nokri'),
                'my_orders' => esc_html__('My Orders', 'nokri'),
                'cart' => esc_html__('Cart', 'nokri'),
                'logout' => esc_html__('Logout', 'nokri'),
                'zoom_meeting' => esc_html__('Zoom Meeting Settings', 'nokri'),
            ),
            'default' => array(
                'dashboard' => esc_html__('Dashboard', 'nokri'),
                'update_profile' => esc_html__('Udpdate Profile', 'nokri'),
                'view_my_profile' => esc_html__('View My Profile', 'nokri'),
                'my_jobs' => esc_html__('My Jobs', 'nokri'),
                'email_templates' => esc_html__('Email Templates', 'nokri'),
                'matched_resumes' => esc_html__('Matched Resumes', 'nokri'),
                'saved_resumes' => esc_html__('Saved Resumes', 'nokri'),
                'followers' => esc_html__('Followers', 'nokri'),
                'my_package' => esc_html__('My Package', 'nokri'),
                'my_orders' => esc_html__('My Orders', 'nokri'),
                'cart' => esc_html__('Cart', 'nokri'),
                'logout' => esc_html__('Logout', 'nokri'),
            )
        ),
    )
));
/* ========================= */
/* Employer rating         */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Employer Rating', 'nokri'),
    'id' => 'sb_emp_review_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'sb_enable_user_ratting',
            'type' => 'switch',
            'title' => esc_html__('Enable User Rating', 'nokri'),
            'subtitle' => esc_html__('To logged in users', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'sb_reviews_title',
            'type' => 'text',
            'title' => esc_html__('Reviews Title', 'nokri'),
            'default' => "Employer  Reviews: ",
            'required' => array('sb_enable_user_ratting', '=', '1'),
        ),
        array(
            'id' => 'sb_write_reviews_title',
            'type' => 'text',
            'title' => esc_html__('Write Review Title', 'nokri'),
            'default' => "Write a Reviews:",
            'required' => array('sb_enable_user_ratting', '=', '1'),
        ),
        array(
            'id' => 'email_to_user_on_rating',
            'type' => 'switch',
            'title' => esc_html__('Send Email to user', 'nokri'),
            'subtitle' => esc_html__('on new ratting', 'nokri'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => true,
        ),
        array(
            'id' => 'sb_reviews_count_limit',
            'type' => 'text',
            'title' => esc_html__('Button after number of reviews', 'nokri'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => "5",
            'desc' => esc_html__('This option will work for both dashboard and reviews on user profile page', 'nokri'),
        ),
        array(
            'id' => 'sb_first_rating_stars_title',
            'type' => 'text',
            'title' => esc_html__('First Rating Stars Title', 'nokri'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => "Company Culture",
        ),
        array(
            'id' => 'sb_second_rating_stars_title',
            'type' => 'text',
            'title' => esc_html__('Secong Rating Stars Title', 'nokri'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => "Salary Transfer",
        ),
        array(
            'id' => 'sb_third_rating_stars_title',
            'type' => 'text',
            'title' => esc_html__('Third Rating Stars Title', 'nokri'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => "Growth Opportunities",
        ),
        array(
            'id' => 'employer_reviews',
            'type' => 'select',
            'data' => 'pages',
            'title' => __('Select review page', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Employer Profile */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Employer Basic', 'nokri'),
    'id' => 'sb_emp_prof_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        /* Name: */
        array(
            'id' => 'emp_name_label',
            'type' => 'text',
            'title' => esc_html__('Company Name Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Headline: */
        array(
            'id' => 'emp_section_label',
            'type' => 'text',
            'title' => esc_html__('Basic Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'id' => 'emp_heading_setting',
    'type' => 'button_set',
    'title' => __('Headline:', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_heading_setting', '=', array('show', 'required')),
            'id' => 'emp_heading_label',
            'type' => 'text',
            'title' => esc_html__('Headline Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_heading_setting', '=', array('show', 'required')),
            'id' => 'emp_heading_plc',
            'type' => 'text',
            'title' => esc_html__('Headline Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Email: */
        array(
            'id' => 'emp_email_label',
            'type' => 'text',
            'title' => esc_html__('Email Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Phone: */
        $fields = array(
    'id' => 'emp_phone_setting',
    'type' => 'button_set',
    'title' => __('Phone', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_phone_setting', '=', array('show', 'required')),
            'id' => 'emp_phone_label',
            'type' => 'text',
            'title' => esc_html__('Phone Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_phone_setting', '=', array('show', 'required')),
            'id' => 'emp_phone_plc',
            'type' => 'text',
            'title' => esc_html__('Phone Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Website: */
        $fields = array(
    'id' => 'emp_web_setting',
    'type' => 'button_set',
    'title' => __('Website', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_web_setting', '=', array('show', 'required')),
            'id' => 'emp_web_label',
            'type' => 'text',
            'title' => esc_html__('Website Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_web_setting', '=', array('show', 'required')),
            'id' => 'emp_web_plc',
            'type' => 'text',
            'title' => esc_html__('Website Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Profile Image: */
        $fields = array(
    'id' => 'emp_dp_setting',
    'type' => 'button_set',
    'title' => __('Profile Image', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_dp_setting', '=', array('show', 'required')),
            'id' => 'emp_dp_label',
            'type' => 'text',
            'title' => esc_html__('Profile Image Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_dp_setting', '=', array('show', 'required')),
            'id' => 'emp_dp_plc',
            'type' => 'text',
            'title' => esc_html__('Profile Image Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'id' => 'emp_cover_setting',
    'type' => 'button_set',
    'title' => __('Cover Image', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_cover_setting', '=', array('show', 'required')),
            'id' => 'emp_cover_label',
            'type' => 'text',
            'title' => esc_html__('Cover Image Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Set your profile: */
        $fields = array(
    'id' => 'emp_prof_setting',
    'type' => 'button_set',
    'title' => __('Pulbic/Private Set Profile Option', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_prof_setting', '=', array('show', 'required')),
            'id' => 'emp_prof_label',
            'type' => 'text',
            'title' => esc_html__('Set your profile Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* About yourself: */
        $fields = array(
    'id' => 'emp_about_setting',
    'type' => 'button_set',
    'title' => __('About', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_about_setting', '=', array('show', 'required')),
            'id' => 'emp_about_label',
            'type' => 'text',
            'title' => esc_html__('About Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Company Details */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Employer Specialization', 'nokri'),
    'id' => 'sb_emp_details_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'emp_spec_switch',
            'type' => 'switch',
            'title' => __('Hide/Show company Specialization section', 'nokri'),
            'default' => true
        ),
        array(
            'required' => array('emp_spec_switch', '=', 1),
            'id' => 'emp_detail_label',
            'type' => 'text',
            'title' => esc_html__('Specialization Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('emp_spec_switch', '=', 1),
    'id' => 'emp_spec_setting',
    'type' => 'button_set',
    'title' => __('Specialization', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_spec_setting', '=', array('show', 'required')),
            'id' => 'emp_spec_label',
            'type' => 'text',
            'title' => esc_html__('Specialization Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* No. of Employees: */
        $fields = array(
    'required' => array('emp_spec_switch', '=', 1),
    'id' => 'emp_no_emp_setting',
    'type' => 'button_set',
    'title' => __('No. of Employees', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_no_emp_setting', '=', array('show', 'required')),
            'id' => 'emp_no_emp_label',
            'type' => 'text',
            'title' => esc_html__('No. of Employees Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_no_emp_setting', '=', array('show', 'required')),
            'id' => 'emp_no_emp_plc',
            'type' => 'text',
            'title' => esc_html__('No. of Employees Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Established In: */
        $fields = array(
    'required' => array('emp_spec_switch', '=', 1),
    'id' => 'emp_est_setting',
    'type' => 'button_set',
    'title' => __('Established In', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_est_setting', '=', array('show', 'required')),
            'id' => 'emp_est_label',
            'type' => 'text',
            'title' => esc_html__('Established In Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Social Links */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Employer Social', 'nokri'),
    'id' => 'sb_emp_social_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'emp_social_section_switch',
            'type' => 'switch',
            'title' => __('Social Links Section', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('emp_social_section_switch', '=', 1),
            'id' => 'emp_social_section_label',
            'type' => 'text',
            'title' => esc_html__('Social Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        /* Face Book */
        $fields = array(
    'required' => array('emp_social_section_switch', '=', 1),
    'id' => 'emp_fb_setting',
    'type' => 'button_set',
    'title' => __('Facebook', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for facebook field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_fb_setting', '=', array('show', 'required')),
            'id' => 'emp_fb_label',
            'type' => 'text',
            'title' => esc_html__('Facebook Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_fb_setting', '=', array('show', 'required')),
            'id' => 'emp_fb_plc',
            'type' => 'text',
            'title' => esc_html__('Facebook Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Twitter */
        $fields = array(
    'required' => array('emp_social_section_switch', '=', 1),
    'id' => 'emp_twtr_setting',
    'type' => 'button_set',
    'title' => __('Twitter', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for Twitter field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_fb_setting', '=', array('show', 'required')),
            'id' => 'emp_twtr_label',
            'type' => 'text',
            'title' => esc_html__('Twitter Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_fb_setting', '=', array('show', 'required')),
            'id' => 'emp_twtr_plc',
            'type' => 'text',
            'title' => esc_html__('Twitter Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* LinkedIn */
        $fields = array(
    'required' => array('emp_social_section_switch', '=', 1),
    'id' => 'emp_linked_setting',
    'type' => 'button_set',
    'title' => __('LinkedIn', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for LinkedIn field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_linked_setting', '=', array('show', 'required')),
            'id' => 'emp_linked_label',
            'type' => 'text',
            'title' => esc_html__('LinkedIn Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_linked_setting', '=', array('show', 'required')),
            'id' => 'emp_linked_plc',
            'type' => 'text',
            'title' => esc_html__('LinkedIn Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Instagram */
        $fields = array(
    'required' => array('emp_social_section_switch', '=', 1),
    'id' => 'emp_insta_setting',
    'type' => 'button_set',
    'title' => __('Instagram', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for Instagram field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_insta_setting', '=', array('show', 'required')),
            'id' => 'emp_insta_label',
            'type' => 'text',
            'title' => esc_html__('Instagram Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_insta_setting', '=', array('show', 'required')),
            'id' => 'emp_insta_plc',
            'type' => 'text',
            'title' => esc_html__('Instagram Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Location */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Employer Location', 'nokri'),
    'id' => 'sb_emp_loc_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'emp_loc_switch',
            'type' => 'switch',
            'title' => __('Location Section', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('emp_loc_switch', '=', 1),
            'id' => 'emp_map_switch',
            'type' => 'switch',
            'title' => __('Map Location', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('emp_loc_switch', '=', 1),
            'id' => 'emp_loc_section_label',
            'type' => 'text',
            'title' => esc_html__('Location Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        /* Address field */
        array(
            'required' => array('emp_map_switch', '=', 1),
            'id' => 'emp_address_label',
            'type' => 'text',
            'title' => esc_html__('Address Field Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_map_switch', '=', 1),
            'id' => 'emp_lat_label',
            'type' => 'text',
            'title' => esc_html__('Latitude Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_map_switch', '=', 1),
            'id' => 'emp_long_label',
            'type' => 'text',
            'title' => esc_html__('Longitude Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_loc_switch', '=', 1),
            'id' => 'emp_custom_switch',
            'type' => 'switch',
            'title' => __('Custom Location ', 'nokri'),
            'subtitle' => __('Enable/disable custom location', 'nokri'),
            'default' => true,
        ),
    )
));
/* ========================= */
/* Company Portfolio */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Employer Portfolio', 'nokri'),
    'id' => 'sb_emp_port_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'emp_port_switch',
            'type' => 'switch',
            'title' => __('Portfolio Section', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('emp_port_switch', '=', 1),
            'id' => 'emp_port_section_heading',
            'type' => 'text',
            'title' => esc_html__('Portfolio Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        /* Portfolio upload */
        $fields = array(
    'required' => array('emp_port_switch', '=', 1),
    'id' => 'emp_port_setting',
    'type' => 'button_set',
    'title' => __('Portfolio', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for portfolio upload', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_port_setting', '=', array('show', 'required')),
            'id' => 'emp_port_section_label',
            'type' => 'text',
            'title' => esc_html__('Portfolio Section Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_port_setting', '=', array('show', 'required')),
            'id' => 'sb_comp_img_limit',
            'type' => 'select',
            'title' => esc_html__('Images upload limit', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15),
            'default' => 5,
        ),
        array(
            'required' => array('emp_port_setting', '=', array('show', 'required')),
            'id' => 'sb_comp_img_size',
            'type' => 'select',
            'title' => esc_html__('Image max size', 'nokri'),
            'options' => array('307200-300kb' => '300kb', '614400-600kb' => '600kb', '819200-800kb' => '800kb', '1048576-1MB' => '1MB', '2097152-2MB' => '2MB', '3145728-3MB' => '3MB', '4194304-4MB' => '4MB', '5242880-5MB' => '5MB'),
            'default' => '819200-800kb',
        ),
        /* Video url */
        $fields = array(
    'required' => array('emp_port_switch', '=', 1),
    'id' => 'emp_port_vid_setting',
    'type' => 'button_set',
    'title' => __('Video url', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for video url', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('emp_port_vid_setting', '=', array('show', 'required')),
            'id' => 'emp_port_vid_label',
            'type' => 'text',
            'title' => esc_html__('Video url label', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('emp_port_vid_setting', '=', array('show', 'required')),
            'id' => 'emp_port_vid_plc',
            'type' => 'text',
            'title' => esc_html__('Video url Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Company Detail Page */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Employer Detail', 'nokri'),
    'id' => 'sb_emp_detail_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'emp_det_follow_btn',
            'type' => 'switch',
            'title' => __('Follow Button', 'nokri'),
            'subtitle' => __('Enable/disable follow button', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'reg_custom_fields_switch',
            'type' => 'switch',
            'title' => __('Custom Fields Switch', 'nokri'),
            'desc' => __('Display custom fields on the Employer Dashboard update Profile', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'emp_det',
            'type' => 'text',
            'title' => esc_html__('Sidebar Detail label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'emp_mem_sinc',
            'type' => 'text',
            'title' => esc_html__('Member since label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'emp_open_pos',
            'type' => 'text',
            'title' => esc_html__('Open positions label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'emp_cont_lab',
            'type' => 'text',
            'title' => esc_html__('Contact label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'emp_gall_lab',
            'type' => 'text',
            'title' => esc_html__('Gallery label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'emp_vid_lab',
            'type' => 'text',
            'title' => esc_html__('Video label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => esc_html__('Employer General', 'nokri'),
    'id' => 'sb_emp_general_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'emp_download_resumes_switch',
            'type' => 'switch',
            'title' => __('Download Resumes Against job', 'nokri'),
            'subtitle' => __('Enable/disable download button', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'nokri_jobs_graph_switch',
            'type' => 'switch',
            'title' => __('Jobs Graph Chart', 'nokri'),
            'subtitle' => __('Enable/disable Graph Chart', 'nokri'),
            'desc' => __('On frontend Emlpoyer Dashboard Show/hide Company Graph chart', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'nokri_resume_graph_switch',
            'type' => 'switch',
            'title' => __('Resume Graph Chart', 'nokri'),
            'subtitle' => __('Enable/disable Graph Chart', 'nokri'),
            'desc' => __('On frontend Emlpoyer Dashboard Show/hide Company Graph chart', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'emp_counter_switch_',
            'type' => 'switch',
            'title' => __('Company Stats Counter', 'nokri'),
            'subtitle' => __('Enable/disable Company Stats Counter', 'nokri'),
            'desc' => __('On frontend Emlpoyer Dashboard Show/hide Company Stats Counter', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'emp_single_jobs_stats_',
            'type' => 'switch',
            'title' => __('Employer Single Job Stats', 'nokri'),
            'subtitle' => __('Enable/disable Company Stats', 'nokri'),
            'desc' => __('On frontend Emlpoyer Dashboard Show/hide single Job Resumes', 'nokri'),
            'default' => false,
        ),
    ),
));
/* ------------------Users Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidates Settings', 'nokri'),
    'id' => 'nokri_users_candidates',
    'desc' => '',
    'icon' => 'el el-child',
));
/* * ****************** */
/* Candidates  options */
/* * ***************** */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidates', 'nokri'),
    'id' => 'sb_candidates_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'cand_resume_style',
            'type' => 'button_set',
            'title' => esc_html__('Candidate Detail Page Style', 'nokri'),
            'options' => array(
                '1' => esc_html__('Style 1', 'nokri'),
                '2' => esc_html__('Style 2', 'nokri'),
                '3' => esc_html__('Style 3', 'nokri'),
            ),
            'default' => '1',
        ),
        array(
            'id' => 'cand_listing_style',
            'type' => 'button_set',
            'title' => esc_html__('Candidate Listing Style', 'nokri'),
            'options' => array(
                '1' => esc_html__('Style 1', 'nokri'),
                '2' => esc_html__('Style 2', 'nokri'),
            ),
            'default' => '1',
        ),
        array(
            'id' => 'cand_last_login_status',
            'type' => 'switch',
            'title' => esc_html__('Enable/disable Candidate Last login time', 'nokri'),
            'subtitle' => esc_html__('Hide/show Candidate Last login time on Candidates detail page', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'job_apply_package_base',
            'type' => 'button_set',
            'title' => esc_html__('Apply on jobs', 'nokri'),
            'options' => array(
                '2' => esc_html__('Free', 'nokri'),
                '1' => esc_html__('Package Base', 'nokri'),
            ),
            'default' => '2',
        ),
        array(
            'required' => array('job_apply_package_base', '=', array('2')),
            'id' => 'job_apply_package_base_wl',
            'type' => 'button_set',
            'title' => esc_html__('Apply on external link jobs', 'nokri'),
            'options' => array(
                '1' => esc_html__('With Login', 'nokri'),
                '2' => esc_html__('Without Login', 'nokri'),
            ),
            'default' => '2',
        ),
        array(
            'id' => 'cand_search_mode',
            'type' => 'button_set',
            'title' => esc_html__('Candidate Search', 'nokri'),
            'options' => array(
                '1' => esc_html__('Free', 'nokri'),
                '2' => esc_html__('Package Base', 'nokri'),
            ),
            'default' => '1',
        ),
        array(
            'id' => 'cand_resume_down',
            'type' => 'switch',
            'title' => __('Publically Resume Download', 'nokri'),
            'subtitle' => __('Enable/disable resume download', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'cand_graph_chart_btn',
            'type' => 'switch',
            'title' => __('Activity Graph Chart', 'nokri'),
            'subtitle' => __('Enable/disable graph chart', 'nokri'),
            'desc' => __('Hide/show graph chart on frontend Candidate dashboard', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'cand_counter_data',
            'type' => 'switch',
            'title' => __('Activity Graph Counter', 'nokri'),
            'subtitle' => __('Enable/disable graph counter', 'nokri'),
            'desc' => __('Hide/show graph counter on frontend Candidate dashboard', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'cand_resume_gen',
            'type' => 'switch',
            'title' => __('Publically Generate Resume', 'nokri'),
            'subtitle' => __('Enable/disable resume generate', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'cand_resume_gen_dashboard',
            'type' => 'switch',
            'title' => __('Dashboard Generate Resume', 'nokri'),
            'subtitle' => __('Enable/disable resume generate from dashboard', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('cand_resume_gen', '=', array('1')),
            'id' => 'cand_resume_generate_page',
            'type' => 'select',
            'data' => 'pages',
            'multi' => false,
            'title' => esc_html__('Resume generate page', 'nokri'),
            'subtitle' => esc_html__('Select Page', 'nokri'),
        ),
        array(
            'id' => 'cand_half_name_switch',
            'type' => 'switch',
            'title' => __('Candidate dotted name', 'nokri'),
            'subtitle' => __('Show hide candidate dotted name', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'cand_job_notif',
            'type' => 'button_set',
            'title' => esc_html__('Job Notifications For', 'nokri'),
            'options' => array(
                '1' => esc_html__('All Companies', 'nokri'),
                '2' => esc_html__('Followed Companies', 'nokri'),
                '3' => esc_html__('Off', 'nokri'),
            ),
            'default' => '1',
        ),
        array(
            'required' => array('cand_job_notif', '=', array('1', '2')),
            'id' => 'cand_job_notif_txt',
            'type' => 'text',
            'title' => esc_html__('Notification Text', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_advertisment',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'nokri'),
            'subtitle' => __('728 x 90', 'nokri'),
            'desc' => __('Advertisement on candidate profile', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'user_low_profile_txt_btn',
            'type' => 'switch',
            'title' => __('Hide/Show low profile alert', 'nokri'),
            'default' => true
        ),
        array(
            'required' => array('user_low_profile_txt_btn', '=', array('1')),
            'id' => 'user_low_profile_txt',
            'type' => 'textarea',
            'title' => esc_html__('Low profile alert text', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'sb_upload_limit',
            'type' => 'select',
            'title' => esc_html__('Portfolio upload limit', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15),
            'default' => 5,
        ),
        array(
            'id' => 'sb_upload_size',
            'type' => 'select',
            'title' => esc_html__('Portfolio max size', 'nokri'),
            'options' => array('307200-300kb' => '300kb', '614400-600kb' => '600kb', '819200-800kb' => '800kb', '1048576-1MB' => '1MB', '2097152-2MB' => '2MB', '3145728-3MB' => '3MB', '4194304-4MB' => '4MB', '5242880-5MB' => '5MB'),
            'default' => '819200-800kb',
        ),
        array(
            'id' => 'sb_upload_resume_limit',
            'type' => 'select',
            'title' => esc_html__('Resumes upload limit', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15),
            'default' => 5,
        ),
        array(
            'id' => 'sb_upload_resume_size',
            'type' => 'select',
            'title' => esc_html__('Resume max size', 'nokri'),
            'options' => array('307200-300kb' => '300kb', '614400-600kb' => '600kb', '819200-800kb' => '800kb', '1048576-1MB' => '1MB', '2097152-2MB' => '2MB', '3145728-3MB' => '3MB', '4194304-4MB' => '4MB', '5242880-5MB' => '5MB'),
            'default' => '819200-800kb',
        ),
    )
));
/* ========================= */
/* Profile Rating */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Menu Setting', 'nokri'),
    'id' => 'sb_candidates_menu',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        /* Menu sorter */
        array(
            'id' => 'candidate_menu_sorter',
            'type' => 'sortable',
            'desc' => esc_html__('Click and drag for sorting', 'nokri'),
            'label' => false,
            'options' => array(
                'dashboard' => esc_html__('Dashboard', 'nokri'),
                'update_profile' => esc_html__('Update Profile', 'nokri'),
                'view_my_profile' => esc_html__('View My Profile', 'nokri'),
                'my_resumes' => esc_html__('My Resumes', 'nokri'),
                'jobs_applied' => esc_html__('Jobs Applied', 'nokri'),
                'saved_jobs' => esc_html__('Saved Jobs', 'nokri'),
                'followed_companies' => esc_html__('Followed Companies', 'nokri'),
                'job_alerts' => esc_html__('Job Alerts', 'nokri'),
                'my_package' => esc_html__('My Package', 'nokri'),
                'my_orders' => esc_html__('My Orders', 'nokri'),
                'cart' => esc_html__('Cart', 'nokri'),
                'logout' => esc_html__('Logout', 'nokri'),
                'setting' => esc_html__('Settings', 'nokri'),
                'my_rating' => esc_html__('My Ratings', 'nokri'),
                'nokri_gen_resume' => esc_html__('Generate Resume', 'nokri'),
            ),
            'default' => array(
                'dashboard' => esc_html__('Dashboard', 'nokri'),
                'update_profile' => esc_html__('Update Profile', 'nokri'),
                'view_my_profile' => esc_html__('View My Profile', 'nokri'),
                'my_resumes' => esc_html__('My Resumes', 'nokri'),
                'nokri_gen_resume' => esc_html__('Generate Resume', 'nokri'),
                'jobs_applied' => esc_html__('Jobs Applied', 'nokri'),
                'saved_jobs' => esc_html__('Saved Jobs', 'nokri'),
                'followed_companies' => esc_html__('Followed Companies', 'nokri'),
                'job_alerts' => esc_html__('Job Alerts', 'nokri'),
                'my_package' => esc_html__('My Package', 'nokri'),
                'my_orders' => esc_html__('My Orders', 'nokri'),
                'cart' => esc_html__('Cart', 'nokri'),
                'logout' => esc_html__('Logout', 'nokri'),
            )
        ),
)));
/* ========================= */
/* Profile Rating */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Profile Scoring', 'nokri'),
    'id' => 'sb_candidates_scoring',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'cand_per_switch',
            'type' => 'switch',
            'title' => __('Enable Candiate scoring', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('cand_per_switch', '=', array('1')),
            'id' => 'cand_prof_restrict',
            'type' => 'switch',
            'title' => __('Restrict Candidate to Apply', 'nokri'),
            'subtitle' => __('Restrict Candiate to Apply on job with low scoring', 'nokri'),
            'default' => true,
        ),
        $fields = array(
    'required' => array('cand_per_switch', '=', array('1')),
    'required' => array('cand_prof_restrict', '=', array('1')),
    'id' => 'restrict_per_apply_job',
    'type' => 'spinner',
    'title' => __('Percentage for job Applying', 'nokri'),
    'subtitle' => __('Set Percentage for candidate while applying on job', 'nokri'),
    'desc' => __('Make sure total sum should be equal to hundred', 'nokri'),
    'default' => '20',
    'min' => '1',
    'step' => '1',
    'max' => '100',
        ),
        $fields = array(
    'id' => 'default_info',
    'type' => 'spinner',
    'title' => __('After Registration', 'nokri'),
    'subtitle' => __('Set weightage', 'nokri'),
    'desc' => __('Make sure total sum should be equal to hundred', 'nokri'),
    'default' => '5',
    'min' => '1',
    'step' => '1',
    'max' => '100',
        ),
        $fields = array(
    'id' => 'person_info',
    'type' => 'spinner',
    'title' => __('Personal Informations', 'nokri'),
    'subtitle' => __('Set weightage', 'nokri'),
    'desc' => __('Make sure total sum should be equal to hundred', 'nokri'),
    'default' => '10',
    'min' => '1',
    'step' => '1',
    'max' => '100',
        ),
        $fields = array(
    'id' => 'skill_info',
    'type' => 'spinner',
    'title' => __('Skills Informations', 'nokri'),
    'subtitle' => __('Set weightage', 'nokri'),
    'desc' => __('Make sure total sum should be equal to hundred', 'nokri'),
    'default' => '20',
    'min' => '1',
    'step' => '1',
    'max' => '100',
        ),
        $fields = array(
    'id' => 'edu_info',
    'type' => 'spinner',
    'title' => __('Education Informations', 'nokri'),
    'subtitle' => __('Set weightage', 'nokri'),
    'desc' => __('Make sure total sum should be equal to hundred', 'nokri'),
    'default' => '20',
    'min' => '1',
    'step' => '1',
    'max' => '100',
        ),
        $fields = array(
    'id' => 'prof_info',
    'type' => 'spinner',
    'title' => __('Profession Informations', 'nokri'),
    'subtitle' => __('Set weightage', 'nokri'),
    'desc' => __('Make sure total sum should be equal to hundred', 'nokri'),
    'default' => '20',
    'min' => '1',
    'step' => '1',
    'max' => '100',
        ),
        $fields = array(
    'id' => 'cert_info',
    'type' => 'spinner',
    'title' => __('Certification Informations', 'nokri'),
    'subtitle' => __('Set weightage', 'nokri'),
    'desc' => __('Make sure total sum should be equal to hundred', 'nokri'),
    'default' => '20',
    'min' => '1',
    'step' => '1',
    'max' => '100',
        ),
        $fields = array(
    'id' => 'social_info',
    'type' => 'spinner',
    'title' => __('Social Informations', 'nokri'),
    'subtitle' => __('Set weightage', 'nokri'),
    'desc' => __('Make sure total sum should be equal to hundred', 'nokri'),
    'default' => '5',
    'min' => '1',
    'step' => '1',
    'max' => '100',
        ),
        $fields = array(
    'id' => 'resume_info',
    'type' => 'spinner',
    'title' => __('Resume Informations', 'nokri'),
    'subtitle' => __('Set weightage', 'nokri'),
    'desc' => __('Make sure total sum should be equal to hundred', 'nokri'),
    'default' => '20',
    'min' => '1',
    'step' => '1',
    'max' => '100',
        ),
    )
));
/* ========================= */
/* Employer rating         */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidate Rating', 'nokri'),
    'id' => 'sb_cand_review_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'sb_enable_cand_ratting',
            'type' => 'switch',
            'title' => esc_html__('Enable User Rating', 'nokri'),
            'subtitle' => esc_html__('To logged in users', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'sb_cand_reviews_title',
            'type' => 'text',
            'title' => esc_html__('Reviews Title', 'nokri'),
            'default' => "Candidates  Reviews: ",
            'required' => array('sb_enable_cand_ratting', '=', '1'),
        ),
        array(
            'id' => 'cand_write_reviews_title',
            'type' => 'text',
            'title' => esc_html__('Write Review Title', 'nokri'),
            'default' => "Write a Reviews:",
            'required' => array('sb_enable_cand_ratting', '=', '1'),
        ),
        array(
            'id' => 'email_to_cand_on_rating',
            'type' => 'switch',
            'title' => esc_html__('Send Email to user', 'nokri'),
            'subtitle' => esc_html__('on new ratting', 'nokri'),
            'required' => array('sb_enable_cand_ratting', '=', '1'),
            'default' => true,
        ),
        array(
            'id' => 'cand_reviews_count_limit',
            'type' => 'text',
            'title' => esc_html__('Button after number of reviews', 'nokri'),
            'required' => array('sb_enable_cand_ratting', '=', '1'),
            'default' => "5",
            'desc' => esc_html__('This option will work for both dashboard and reviews on user profile page', 'nokri'),
        ),
        array(
            'id' => 'cand_first_rating_stars_title',
            'type' => 'text',
            'title' => esc_html__('First Rating Stars Title', 'nokri'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => "Company Culture",
        ),
        array(
            'id' => 'cand_second_rating_stars_title',
            'type' => 'text',
            'title' => esc_html__('Secong Rating Stars Title', 'nokri'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => "Salary Transfer",
        ),
        array(
            'id' => 'cand_third_rating_stars_title',
            'type' => 'text',
            'title' => esc_html__('Third Rating Stars Title', 'nokri'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => "Growth Opportunities",
        ),
        array(
            'id' => 'cand_review_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => __('Select review page', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Personal Settings */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidate Personal', 'nokri'),
    'id' => 'sb_candidates_personal_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'cand_prof_sec_label',
            'type' => 'text',
            'title' => esc_html__('Personal Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_name_label',
            'type' => 'text',
            'title' => esc_html__('Name Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Profession */
        $fields = array(
    'id' => 'cand_profession_setting',
    'type' => 'button_set',
    'title' => __('Profession', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_profession_setting', '=', array('show', 'required')),
            'id' => 'cand_profession_label',
            'type' => 'text',
            'title' => esc_html__('Profession Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_profession_setting', '=', array('show', 'required')),
            'id' => 'cand_profession_plc',
            'type' => 'text',
            'title' => esc_html__('Profession Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Phone */
        $fields = array(
    'id' => 'cand_phone_setting',
    'type' => 'button_set',
    'title' => __('Phone', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_phone_setting', '=', array('show', 'required')),
            'id' => 'cand_phone_label',
            'type' => 'text',
            'title' => esc_html__('Phone Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_phone_setting', '=', array('show', 'required')),
            'id' => 'cand_phone_plc',
            'type' => 'text',
            'title' => esc_html__('Phone Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Date Of Birth */
        $fields = array(
    'id' => 'cand_dob_setting',
    'type' => 'button_set',
    'title' => __('Date Of Birth', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_dob_setting', '=', array('show', 'required')),
            'id' => 'cand_dob_label',
            'type' => 'text',
            'title' => esc_html__('Date Of Birth Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Gender */
        $fields = array(
    'id' => 'cand_gend_setting',
    'type' => 'button_set',
    'title' => __('Gender', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_gend_setting', '=', array('show', 'required')),
            'id' => 'cand_gend_label',
            'type' => 'text',
            'title' => esc_html__('Gender Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Profile Image */
        $fields = array(
    'id' => 'cand_dp_setting',
    'type' => 'button_set',
    'title' => __('Profile Image', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_dp_setting', '=', array('show')),
            'id' => 'cand_dp_label',
            'type' => 'text',
            'title' => esc_html__('Profile Image Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'id' => 'cand_cover_setting',
    'type' => 'button_set',
    'title' => __('Cover Image', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_cover_setting', '=', array('show', 'required')),
            'id' => 'cand_cover_label',
            'type' => 'text',
            'title' => esc_html__('Cover Image Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Experience */
        $fields = array(
    'id' => 'cand_exper_setting',
    'type' => 'button_set',
    'title' => __('Experience', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_exper_setting', '=', array('show', 'required')),
            'id' => 'cand_exper_label',
            'type' => 'text',
            'title' => esc_html__('Experience Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Level */
        $fields = array(
    'id' => 'cand_level_setting',
    'type' => 'button_set',
    'title' => __('Level', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_level_setting', '=', array('show', 'required')),
            'id' => 'cand_level_label',
            'type' => 'text',
            'title' => esc_html__('Level Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Qualification */
        $fields = array(
    'id' => 'cand_quali_setting',
    'type' => 'button_set',
    'title' => __('Qualification', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_quali_setting', '=', array('show', 'required')),
            'id' => 'cand_quali_label2',
            'type' => 'text',
            'title' => esc_html__('Qualification Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Type */
        $fields = array(
    'id' => 'cand_type_setting',
    'type' => 'button_set',
    'title' => __('Type', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_type_setting', '=', array('show', 'required')),
            'id' => 'cand_type_label',
            'type' => 'text',
            'title' => esc_html__('Type Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Salary Type */
        $fields = array(
    'id' => 'cand_salary_type_setting',
    'type' => 'button_set',
    'title' => __('Salary Type', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_salary_type_setting', '=', array('show', 'required')),
            'id' => 'cand_salary_type_label',
            'type' => 'text',
            'title' => esc_html__('Salary Type Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Salary Range */
        $fields = array(
    'id' => 'cand_salary_range_setting',
    'type' => 'button_set',
    'title' => __('Salary Range', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_salary_range_setting', '=', array('show', 'required')),
            'id' => 'cand_salary_range_label',
            'type' => 'text',
            'title' => esc_html__('Salary Range Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Salary Currency */
        $fields = array(
    'id' => 'cand_salary_curren_setting',
    'type' => 'button_set',
    'title' => __('Salary Currency', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_salary_curren_setting', '=', array('show', 'required')),
            'id' => 'cand_salary_curren_label',
            'type' => 'text',
            'title' => esc_html__('Salary Currency Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Profile */
        $fields = array(
    'id' => 'cand_prof_setting',
    'type' => 'button_set',
    'title' => __('Pulbic/Private Set Profile Option', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_prof_setting', '=', array('show', 'required')),
            'id' => 'cand_profile_label',
            'type' => 'text',
            'title' => esc_html__('Set Profile Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* About yourSelf */
        $fields = array(
    'id' => 'cand_about_setting',
    'type' => 'button_set',
    'title' => __('About yourSelf', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_about_setting', '=', array('show', 'required')),
            'id' => 'cand_about_label',
            'type' => 'text',
            'title' => esc_html__('About yourSelf Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Scheduled Hours */
        array(
            'id' => 'cand_hours_swicth',
            'type' => 'switch',
            'title' => esc_html__('Candidates Scheduled hours', 'nokri'),
            'desc' => esc_html__('Show hide candidate scheduled hours', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('cand_hours_swicth', '=', true),
            'id' => 'cand_hours_label',
            'type' => 'text',
            'title' => esc_html__('Candidate schedule label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Section Button */
        array(
            'id' => 'cand_about_btn',
            'type' => 'text',
            'title' => esc_html__('Save Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Skills Settings */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidate Skills', 'nokri'),
    'id' => 'sb_candidates_skills_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        /* Skills */
        array(
            'id' => 'skill_section_switch',
            'type' => 'switch',
            'title' => __('Skills Section', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'skills_as_tag',
            'required' => array('skill_section_switch', '=', 1),
            'type' => 'switch',
            'title' => __('Show Skills as tag', 'nokri'),
            'subtitle' => __('Show skills as searchable tag', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('skill_section_switch', '=', 1),
            'id' => 'skill_section_label',
            'type' => 'text',
            'title' => esc_html__('Skills Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        $fields = array(
    'required' => array('skill_section_switch', '=', 1),
    'id' => 'cand_skills_setting',
    'type' => 'button_set',
    'title' => __('Skills', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_skills_setting', '=', array('show', 'required')),
            'id' => 'cand_skills_label',
            'type' => 'text',
            'title' => esc_html__('Skills Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_skills_setting', '=', array('show', 'required')),
            'id' => 'cand_skills_value_label',
            'type' => 'text',
            'title' => esc_html__('Skills Percentage Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_skills_setting', '=', array('show', 'required')),
            'id' => 'cand_skills_value_plc',
            'type' => 'text',
            'title' => esc_html__('Skills Percentage Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Add Button */
        array(
            'required' => array('cand_skills_setting', '=', array('show', 'required')),
            'id' => 'cand_skills_add',
            'type' => 'text',
            'title' => esc_html__('Add Skills Button', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Remove Button */
        array(
            'required' => array('cand_skills_setting', '=', array('show', 'required')),
            'id' => 'cand_skills_rem',
            'type' => 'text',
            'title' => esc_html__('Remove Skills Button', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Section Button */
        array(
            'required' => array('cand_skills_setting', '=', array('show', 'required')),
            'id' => 'cand_skills_btn',
            'type' => 'text',
            'title' => esc_html__('Save Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Resumes Settings */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidate Resumes', 'nokri'),
    'id' => 'sb_candidates_resumes_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'resume_section_switch',
            'type' => 'switch',
            'title' => __('Resume Section', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('resume_section_switch', '=', 1),
            'id' => 'resume_section_label',
            'type' => 'text',
            'title' => esc_html__('Resume Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        /* Resumes */
        $fields = array(
    'required' => array('resume_section_switch', '=', 1),
    'id' => 'cand_resumes_setting',
    'type' => 'button_set',
    'title' => __('Resumes', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for resumes field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_resumes_setting', '=', array('show', 'required')),
            'id' => 'cand_resume_label',
            'type' => 'text',
            'title' => esc_html__('Resume Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_resumes_setting', '=', array('show', 'required')),
            'id' => 'cand_video_resume_switch',
            'type' => 'switch',
            'title' => esc_html__('Upload Video directly', 'nokri'),
            'desc' => esc_html__('Upload your resume video', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'cand_video_resume_limit',
            'required' => array('cand_video_resume_switch', '=', true),
            'type' => 'select',
            'title' => esc_html__('set limit for upload video', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 15 => 15, 20 => 20, 30 => 30),
            'default' => 4,
        ),
        /* Video Resume Url */
        $fields = array(
    'required' => array('cand_video_resume_switch', '=', false),
    'id' => 'cand_video_resume_setting',
    'type' => 'button_set',
    'title' => __('Video Resume', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_video_resume_setting', '=', array('show', 'required')),
            'id' => 'cand_video_resume_label',
            'type' => 'text',
            'title' => esc_html__('Video Resume Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_video_resume_setting', '=', array('show', 'required')),
            'id' => 'cand_video_resume_plc',
            'type' => 'text',
            'title' => esc_html__('Video Resume Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Section Button */
        array(
            'required' => array('resume_section_switch', '=', 1),
            'id' => 'cand_resume_btn',
            'type' => 'text',
            'title' => esc_html__('Save Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));


/* ========================= */
/* Education Settings */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidate Education', 'nokri'),
    'id' => 'sb_candidates_education_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'education_section_switch',
            'type' => 'switch',
            'title' => __('Education Section', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('education_section_switch', '=', 1),
            'id' => 'education_section_label',
            'type' => 'text',
            'title' => esc_html__('Education Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        /* Qualification Title */
        $fields = array(
    'required' => array('education_section_switch', '=', 1),
    'id' => 'cand_quali_title',
    'type' => 'button_set',
    'title' => __('Qualification Title', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for education field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_quali_title', '=', array('show', 'required')),
            'id' => 'cand_quali_label',
            'type' => 'text',
            'title' => esc_html__('Qualification Title Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_quali_title', '=', array('show', 'required')),
            'id' => 'cand_quali_plc',
            'type' => 'text',
            'title' => esc_html__('Qualification Title Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Institute Name */
        $fields = array(
    'required' => array('education_section_switch', '=', 1),
    'id' => 'cand_quali_inst',
    'type' => 'button_set',
    'title' => __('Institute Name', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_quali_inst', '=', array('show', 'required')),
            'id' => 'cand_inst_label',
            'type' => 'text',
            'title' => esc_html__('Institute Name Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_quali_inst', '=', array('show', 'required')),
            'id' => 'cand_inst_plc',
            'type' => 'text',
            'title' => esc_html__('Institute Name Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Start Date */
        $fields = array(
    'required' => array('education_section_switch', '=', 1),
    'id' => 'cand_quali_start',
    'type' => 'button_set',
    'title' => __('Start Date', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_quali_start', '=', array('show', 'required')),
            'id' => 'cand_quali_start_label',
            'type' => 'text',
            'title' => esc_html__('Start Date Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* End Date */
        $fields = array(
    'required' => array('education_section_switch', '=', 1),
    'id' => 'cand_quali_end',
    'type' => 'button_set',
    'title' => __('End Date', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_quali_end', '=', array('show', 'required')),
            'id' => 'cand_quali_end_label',
            'type' => 'text',
            'title' => esc_html__('End Date Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Percentage */
        $fields = array(
    'required' => array('education_section_switch', '=', 1),
    'id' => 'cand_quali_percent',
    'type' => 'button_set',
    'title' => __('Percentage', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_quali_percent', '=', array('show', 'required')),
            'id' => 'cand_quali_percent_label',
            'type' => 'text',
            'title' => esc_html__('Percentage Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_quali_percent', '=', array('show', 'required')),
            'id' => 'cand_quali_percent_plc',
            'type' => 'text',
            'title' => esc_html__('Percentage Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired paceholder', 'nokri'),
            'default' => '',
        ),
        /* Grades */
        $fields = array(
    'required' => array('education_section_switch', '=', 1),
    'id' => 'cand_quali_grades',
    'type' => 'button_set',
    'title' => __('Grades', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_quali_grades', '=', array('show', 'required')),
            'id' => 'cand_quali_grades_label',
            'type' => 'text',
            'title' => esc_html__('Grades Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_quali_grades', '=', array('show', 'required')),
            'id' => 'cand_quali_grades_plc',
            'type' => 'text',
            'title' => esc_html__('Grades Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Description */
        $fields = array(
    'required' => array('education_section_switch', '=', 1),
    'id' => 'cand_quali_desc',
    'type' => 'button_set',
    'title' => __('Description', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_quali_desc', '=', array('show', 'required')),
            'id' => 'cand_quali_desc_label',
            'type' => 'text',
            'title' => esc_html__('Description Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Add New Education Label */
        array(
            'required' => array('education_section_switch', '=', 1),
            'id' => 'cand_quali_add_new',
            'type' => 'text',
            'title' => esc_html__('Add New Education Label', 'nokri'),
            'desc' => esc_html__('Enter your desired newly education heading', 'nokri'),
            'default' => '',
        ),
        /* Add More Button */
        array(
            'required' => array('education_section_switch', '=', 1),
            'id' => 'cand_quali_add',
            'type' => 'text',
            'title' => esc_html__('Add More Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Remove Button */
        array(
            'required' => array('education_section_switch', '=', 1),
            'id' => 'cand_quali_rem',
            'type' => 'text',
            'title' => esc_html__('Remove Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Section Button */
        array(
            'required' => array('education_section_switch', '=', 1),
            'id' => 'cand_quali_btn',
            'type' => 'text',
            'title' => esc_html__('Save Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Experience Settings */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidate Experience', 'nokri'),
    'id' => 'sb_candidates_experience_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'profession_section_switch',
            'type' => 'switch',
            'title' => __('Profession Section', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('profession_section_switch', '=', 1),
            'id' => 'experience_section_label',
            'type' => 'text',
            'title' => esc_html__('Experience Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        /* Organization Name */
        $fields = array(
    'required' => array('profession_section_switch', '=', 1),
    'id' => 'cand_exper_title',
    'type' => 'button_set',
    'title' => __('Organization Name', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for experience field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_exper_title', '=', array('show', 'required')),
            'id' => 'cand_org_label',
            'type' => 'text',
            'title' => esc_html__('Organization Name Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_exper_title', '=', array('show', 'required')),
            'id' => 'cand_org_plc',
            'type' => 'text',
            'title' => esc_html__('Organization Name Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Your Role */
        $fields = array(
    'required' => array('profession_section_switch', '=', 1),
    'id' => 'cand_exper_role',
    'type' => 'button_set',
    'title' => __('Your Role', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_exper_role', '=', array('show', 'required')),
            'id' => 'cand_exper_role_label',
            'type' => 'text',
            'title' => esc_html__('Your Role Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_exper_role', '=', array('show', 'required')),
            'id' => 'cand_exper_role_plc',
            'type' => 'text',
            'title' => esc_html__('Your Role Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Job Start Date */
        $fields = array(
    'required' => array('profession_section_switch', '=', 1),
    'id' => 'cand_exper_start',
    'type' => 'button_set',
    'title' => __('Job Start Date', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_exper_start', '=', array('show', 'required')),
            'id' => 'cand_exper_start_label',
            'type' => 'text',
            'title' => esc_html__('Start Date Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Job End Date */
        $fields = array(
    'required' => array('profession_section_switch', '=', 1),
    'id' => 'cand_exper_end',
    'type' => 'button_set',
    'title' => __('Job End Date', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_exper_end', '=', array('show', 'required')),
            'id' => 'cand_exper_end_label',
            'type' => 'text',
            'title' => esc_html__('Job End Date Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Currently Working */
        array(
            'required' => array('profession_section_switch', '=', 1),
            'id' => 'cand_exper_current_label',
            'type' => 'text',
            'title' => esc_html__('Currently Working Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Description */
        $fields = array(
    'required' => array('profession_section_switch', '=', 1),
    'id' => 'cand_exper_desc',
    'type' => 'button_set',
    'title' => __('Description', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_exper_desc', '=', array('show', 'required')),
            'id' => 'cand_exper_desc_label',
            'type' => 'text',
            'title' => esc_html__('Description Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Add New Education Label */
        array(
            'required' => array('profession_section_switch', '=', 1),
            'id' => 'cand_exper_add_new',
            'type' => 'text',
            'title' => esc_html__('Add New Experience Label', 'nokri'),
            'desc' => esc_html__('Enter your desired newly experience heading', 'nokri'),
            'default' => '',
        ),
        /* Add More Button */
        array(
            'required' => array('profession_section_switch', '=', 1),
            'id' => 'cand_exper_add',
            'type' => 'text',
            'title' => esc_html__('Add More Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Remove Button */
        array(
            'required' => array('profession_section_switch', '=', 1),
            'id' => 'cand_exper_rem',
            'type' => 'text',
            'title' => esc_html__('Remove Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Section Button */
        array(
            'required' => array('profession_section_switch', '=', 1),
            'id' => 'cand_exper_btn',
            'type' => 'text',
            'title' => esc_html__('Save Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Certifications Settings */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidate Certifications', 'nokri'),
    'id' => 'sb_candidates_certification_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'certification_section_switch',
            'type' => 'switch',
            'title' => __('Certification Section', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('certification_section_switch', '=', 1),
            'id' => 'certification_section_label',
            'type' => 'text',
            'title' => esc_html__('Certifications Detail Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        /* Certification Title */
        $fields = array(
    'required' => array('certification_section_switch', '=', 1),
    'id' => 'cand_certi_title',
    'type' => 'button_set',
    'title' => __('Certification Title', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for certification field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_certi_title', '=', array('show', 'required')),
            'id' => 'cand_certi_label',
            'type' => 'text',
            'title' => esc_html__('Certification Title Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_certi_title', '=', array('show', 'required')),
            'id' => 'cand_certi_plc',
            'type' => 'text',
            'title' => esc_html__('Certification Title Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Certification Start Date */
        $fields = array(
    'required' => array('certification_section_switch', '=', 1),
    'id' => 'cand_certi_start',
    'type' => 'button_set',
    'title' => __('Start Date', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_certi_start', '=', array('show', 'required')),
            'id' => 'cand_certi_start_label',
            'type' => 'text',
            'title' => esc_html__('Start Date Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* End Date */
        $fields = array(
    'required' => array('certification_section_switch', '=', 1),
    'id' => 'cand_certi_end',
    'type' => 'button_set',
    'title' => __('End Date', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_certi_end', '=', array('show', 'required')),
            'id' => 'cand_certi_end_label',
            'type' => 'text',
            'title' => esc_html__('End Date Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Certification Duration */
        $fields = array(
    'required' => array('certification_section_switch', '=', 1),
    'id' => 'cand_certi_dur',
    'type' => 'button_set',
    'title' => __('Certification Duration', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_certi_dur', '=', array('show', 'required')),
            'id' => 'cand_certi_dur_label',
            'type' => 'text',
            'title' => esc_html__('Duration Name Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_certi_dur', '=', array('show', 'required')),
            'id' => 'cand_certi_dur_plc',
            'type' => 'text',
            'title' => esc_html__('Duration Name Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Certification Institute */
        $fields = array(
    'required' => array('certification_section_switch', '=', 1),
    'id' => 'cand_certi_inst',
    'type' => 'button_set',
    'title' => __('Institute Name', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_certi_inst', '=', array('show', 'required')),
            'id' => 'cand_certi_inst_label',
            'type' => 'text',
            'title' => esc_html__('Institute Name Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_certi_inst', '=', array('show', 'required')),
            'id' => 'cand_certi_inst_plc',
            'type' => 'text',
            'title' => esc_html__('Institute Name Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Description */
        $fields = array(
    'required' => array('certification_section_switch', '=', 1),
    'id' => 'cand_certi_desc',
    'type' => 'button_set',
    'title' => __('Description', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_certi_desc', '=', array('show', 'required')),
            'id' => 'cand_quali_certi_label',
            'type' => 'text',
            'title' => esc_html__('Description Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Add New Certification Label */
        array(
            'required' => array('certification_section_switch', '=', 1),
            'id' => 'cand_exper_add_new',
            'type' => 'text',
            'title' => esc_html__('Add New Certification Label', 'nokri'),
            'desc' => esc_html__('Enter your desired newly certification heading', 'nokri'),
            'default' => '',
        ),
        /* Add More Button */
        array(
            'required' => array('certification_section_switch', '=', 1),
            'id' => 'cand_exper_add',
            'type' => 'text',
            'title' => esc_html__('Add More Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Remove Button */
        array(
            'required' => array('certification_section_switch', '=', 1),
            'id' => 'cand_exper_rem',
            'type' => 'text',
            'title' => esc_html__('Remove Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Section Button */
        array(
            'required' => array('certification_section_switch', '=', 1),
            'id' => 'cand_certi_btn',
            'type' => 'text',
            'title' => esc_html__('Save Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Portfolio Settings */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidate Portfolio', 'nokri'),
    'id' => 'sb_candidates_portfolio_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'portfolio_section_switch',
            'type' => 'switch',
            'title' => __('Portfolio Section', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('portfolio_section_switch', '=', 1),
            'id' => 'portfolio_section_label',
            'type' => 'text',
            'title' => esc_html__('Portfolio Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        /* Portfolio */
        $fields = array(
    'required' => array('portfolio_section_switch', '=', 1),
    'id' => 'cand_portfolio_setting',
    'type' => 'button_set',
    'title' => __('Portfolio', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for portfolio field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_portfolio_setting', '=', array('show', 'required')),
            'id' => 'cand_portfolio_label',
            'type' => 'text',
            'title' => esc_html__('Portfolio Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        /* Video Portfolio Url */
        $fields = array(
    'required' => array('portfolio_section_switch', '=', 1),
    'id' => 'cand_portfolio_video',
    'type' => 'button_set',
    'title' => __('Video Portfolio Link', 'nokri'),
    'multi' => false,
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_portfolio_video', '=', array('show', 'required')),
            'id' => 'cand_portfolio_video_label',
            'type' => 'text',
            'title' => esc_html__('Video Portfolio Link Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_portfolio_video', '=', array('show', 'required')),
            'id' => 'cand_portfolio_video_plc',
            'type' => 'text',
            'title' => esc_html__('Video Portfolio Link Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Section Button */
        array(
            'required' => array('portfolio_section_switch', '=', 1),
            'id' => 'cand_portfolio_btn',
            'type' => 'text',
            'title' => esc_html__('Save Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Social Links */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidate Social', 'nokri'),
    'id' => 'sb_candidates_social_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'social_section_switch',
            'type' => 'switch',
            'title' => __('Social Links Section', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('social_section_switch', '=', 1),
            'id' => 'social_section_label',
            'type' => 'text',
            'title' => esc_html__('Social Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        /* Face Book */
        $fields = array(
    'required' => array('social_section_switch', '=', 1),
    'id' => 'cand_fb_setting',
    'type' => 'button_set',
    'title' => __('Facebook', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for face book field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_fb_setting', '=', array('show', 'required')),
            'id' => 'cand_fb_label',
            'type' => 'text',
            'title' => esc_html__('Facebook Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_fb_setting', '=', array('show', 'required')),
            'id' => 'cand_fb_plc',
            'type' => 'text',
            'title' => esc_html__('Facebook Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Twitter */
        $fields = array(
    'required' => array('social_section_switch', '=', 1),
    'id' => 'cand_twtr_setting',
    'type' => 'button_set',
    'title' => __('Twitter', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for Twitter field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_fb_setting', '=', array('show', 'required')),
            'id' => 'cand_twtr_label',
            'type' => 'text',
            'title' => esc_html__('Twitter Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_fb_setting', '=', array('show', 'required')),
            'id' => 'cand_twtr_plc',
            'type' => 'text',
            'title' => esc_html__('Twitter Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* LinkedIn */
        $fields = array(
    'required' => array('social_section_switch', '=', 1),
    'id' => 'cand_linked_setting',
    'type' => 'button_set',
    'title' => __('LinkedIn', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for LinkedIn field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_linked_setting', '=', array('show', 'required')),
            'id' => 'cand_linked_label',
            'type' => 'text',
            'title' => esc_html__('LinkedIn Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_linked_setting', '=', array('show', 'required')),
            'id' => 'cand_linked_plc',
            'type' => 'text',
            'title' => esc_html__('LinkedIn Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Instagram */
        $fields = array(
    'required' => array('social_section_switch', '=', 1),
    'id' => 'cand_insta_setting',
    'type' => 'button_set',
    'title' => __('Instagram', 'nokri'),
    'multi' => false,
    'desc' => esc_html__('Select option for Instagram field', 'nokri'),
    //Must provide key => value pairs for options
    'options' => array(
        'show' => __('Show', 'nokri'),
        'hide' => __('Hide', 'nokri'),
        'required' => __('Required', 'nokri'),
    ),
    'default' => 'show',
        ),
        array(
            'required' => array('cand_insta_setting', '=', array('show', 'required')),
            'id' => 'cand_insta_label',
            'type' => 'text',
            'title' => esc_html__('Instagram Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_insta_setting', '=', array('show', 'required')),
            'id' => 'cand_insta_plc',
            'type' => 'text',
            'title' => esc_html__('Instagram Placeholder', 'nokri'),
            'desc' => esc_html__('Enter your desired placeholder', 'nokri'),
            'default' => '',
        ),
        /* Section Button */
        array(
            'required' => array('social_section_switch', '=', 1),
            'id' => 'cand_social_btn',
            'type' => 'text',
            'title' => esc_html__('Save Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Social Links */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidate Location', 'nokri'),
    'id' => 'sb_candidates_loc_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'cand_loc_switch',
            'type' => 'switch',
            'title' => __('Location Section', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('cand_loc_switch', '=', 1),
            'id' => 'cand_map_switch',
            'type' => 'switch',
            'title' => __('Map Location', 'nokri'),
            'subtitle' => __('Enable/disable section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('cand_loc_switch', '=', 1),
            'id' => 'loc_section_label',
            'type' => 'text',
            'title' => esc_html__('Location Section Heading', 'nokri'),
            'desc' => esc_html__('Enter your desired heading', 'nokri'),
            'default' => '',
        ),
        /* Address field */
        array(
            'required' => array('cand_map_switch', '=', 1),
            'id' => 'cand_address_label',
            'type' => 'text',
            'title' => esc_html__('Address Field Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_map_switch', '=', 1),
            'id' => 'cand_lat_label',
            'type' => 'text',
            'title' => esc_html__('Latitude Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'required' => array('cand_map_switch', '=', 1),
            'id' => 'cand_long_label',
            'type' => 'text',
            'title' => esc_html__('Longitude Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_custom_switch',
            'type' => 'switch',
            'title' => __('Custom Location ', 'nokri'),
            'subtitle' => __('Enable/disable custom location', 'nokri'),
            'default' => true,
        ),
        /* Section Button */
        array(
            'required' => array('cand_loc_switch', '=', 1),
            'id' => 'cand_social_btn',
            'type' => 'text',
            'title' => esc_html__('Save Button Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Candidate Detail Page */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Candidate Detail', 'nokri'),
    'id' => 'sb_cand_detail_settings',
    'subsection' => true,
    'customizer_width' => '700px',
    'fields' => array(
        array(
            'id' => 'cand_custom_fields_switch',
            'type' => 'switch',
            'title' => __('Custom Fields Switch', 'nokri'),
            'desc' => __('Display custom fields on the Candidate Dashboard update Profile', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'cand_det',
            'type' => 'text',
            'title' => esc_html__('Candidate Detail label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_mem',
            'type' => 'text',
            'title' => esc_html__('Member since label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_gend',
            'type' => 'text',
            'title' => esc_html__('Gender label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_salary',
            'type' => 'text',
            'title' => esc_html__('Candidate Salary Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_about',
            'type' => 'text',
            'title' => esc_html__('Candidate About label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_save_resume',
            'type' => 'text',
            'title' => esc_html__('Save Resume Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_generate_resume',
            'type' => 'text',
            'title' => esc_html__('Generate Resume Label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_skills_label',
            'type' => 'text',
            'title' => esc_html__('Skill label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_portfolio_label',
            'type' => 'text',
            'title' => esc_html__('Portfolio label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_vid_lab',
            'type' => 'text',
            'title' => esc_html__('Video label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_cont_lab',
            'type' => 'text',
            'title' => esc_html__('Contact label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_edu_lab',
            'type' => 'text',
            'title' => esc_html__('Education section label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_prof_lab',
            'type' => 'text',
            'title' => esc_html__('Profession section label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
        array(
            'id' => 'cand_certi_lab',
            'type' => 'text',
            'title' => esc_html__('Certification section label', 'nokri'),
            'desc' => esc_html__('Enter your desired label', 'nokri'),
            'default' => '',
        ),
    )
));
/* ========================= */
/* Pages Settings */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('External Jobs API', 'nokri'),
    'id' => 'jobs_apis',
    'customizer_width' => '700px',
    'fields' => array(
    )
));
/* ------------------ Jooble API Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Jooble API Setting', 'nokri'),
    'id' => 'nokri-jooble-settings',
    'desc' => '',
    'subsection' => true,
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'jooble_api_btn',
            'type' => 'switch',
            'title' => esc_html__('On/Off Jooble Api', 'nokri'),
            'desc' => esc_html__('On/Off Jooble Api', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('jooble_api_btn', '=', array('1')),
            'id' => 'nokri_jooble_api_key',
            'type' => 'text',
            'title' => esc_html__('Jooble Api Key', 'nokri'),
            'subtitle' => esc_html__('Please Enter your Api key Here', 'nokri'),
            'desc' => nokri_make_link('https://jooble.org/api/about', esc_html__('How to get your API Key', 'nokri')),
        ),
        array(
            'id' => 'nokri_jooble_import_jobs',
            'required' => array('jooble_api_btn', '=', '1'),
            'type' => 'select',
            'title' => esc_html__('Jobs limit', 'nokri'),
            'subtitle' => esc_html__('Select jobs limit to display', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 15 => 15, 15 => 15, 16 => 16,
                17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21, 22 => 22, 23 => 23, 24 => 24, 25 => 25),
            'default' => 5,
            'desc' => esc_html__('Add default number of jobs to post maximum 25', 'nokri'),
        ),
        array(
            'required' => array('jooble_api_btn', '=', array('1')),
            'id' => 'jooble_job_position',
            'type' => 'button_set',
            'title' => esc_html__('Jobs Position', 'nokri'),
            'subtitle' => esc_html__('Jobs display position', 'nokri'),
            'options' => array(
                '1' => esc_html__('Top', 'nokri'),
                '2' => esc_html__('Bottom', 'nokri'),
            ),
            'default' => '1',
            'desc' => esc_html__('Select to display Jooble jobs on Top/Bottom of Regular jobs. ', 'nokri'),
        ),
)));
/* ------------------ Reedco API Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Reedco Jobs Api', 'nokri'),
    'id' => 'nokri-reedco-settings',
    'desc' => '',
    'subsection' => true,
    'icon' => 'el el-cog',
    'fields' => array(
        array(
            'id' => 'reedco_jobs_api_btn',
            'type' => 'switch',
            'title' => esc_html__('Reedco Jobs', 'nokri'),
            'desc' => esc_html__('On/Off Reedco Api', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('reedco_jobs_api_btn', '=', array('1')),
            'id' => 'nokri_reedco_api_key',
            'type' => 'text',
            'title' => esc_html__('Reedco Api Key', 'nokri'),
            'subtitle' => esc_html__('Please Enter your Api key Here', 'nokri'),
            'desc' => nokri_make_link('https://www.reed.co.uk/developers/Jobseeker', esc_html__('How to get your API Key', 'nokri')),
        ),
        array(
            'id' => 'nokri_reedco_import_jobs',
            'required' => array('reedco_jobs_api_btn', '=', '1'),
            'type' => 'select',
            'title' => esc_html__('Jobs limit', 'nokri'),
            'subtitle' => esc_html__('Select jobs limit to display', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 15 => 15, 15 => 15, 16 => 16,
                17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21, 22 => 22, 23 => 23, 24 => 24, 25 => 25, 26 => 26, 27 => 27, 28 => 28, 29 => 29, 30 => 30, 31 => 31, 32 => 32, 33 => 33, 34 => 34, 35 => 35,),
            'default' => 5,
            'desc' => esc_html__('Add default number of jobs to post maximum 35', 'nokri'),
        ),
)));
/* ------------------ GitHub Jobs Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('GitHub Jobs Settings', 'nokri'),
    'id' => 'nokri-gitjobs-settings',
    'desc' => '',
    'subsection' => true,
    'icon' => 'el el-wrench',
    'fields' => array(
        array(
            'id' => 'gitjob_btn',
            'type' => 'switch',
            'title' => esc_html__('GitHub Jobs', 'nokri'),
            'desc' => esc_html__('On/Off GitHub Jobs Api', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'nokri_git_jobs_limit',
            'required' => array('gitjob_btn', '=', '1'),
            'type' => 'select',
            'title' => esc_html__('Jobs limit', 'nokri'),
            'subtitle' => esc_html__('Select jobs limit to display', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 15 => 15, 15 => 15, 16 => 16,
                17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21, 22 => 22, 23 => 23, 24 => 24, 25 => 25, 26 => 26, 27 => 27, 28 => 28, 29 => 29, 30 => 30, 31 => 31, 32 => 32, 33 => 33, 34 => 34, 35 => 35,),
            'default' => 5,
            'desc' => esc_html__('Add default number of jobs to post maximum 35', 'nokri'),
        ),
)));
/* ------------------  CareerJet Jobs ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('CareerJet API Setting', 'nokri'),
    'id' => 'nokri-careerjet-settings',
    'desc' => '',
    'subsection' => true,
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'careerjet_api_btn',
            'type' => 'switch',
            'title' => esc_html__('CareerJet Jobs', 'nokri'),
            'desc' => esc_html__('On/Off import CareerJet  Jobs', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('careerjet_api_btn', '=', array('1')),
            'id' => 'careerJet_api_key',
            'type' => 'text',
            'title' => esc_html__('Careerjet Api Key', 'nokri'),
            'subtitle' => esc_html__('Please Enter your Api key Here', 'nokri'),
            'desc' => nokri_make_link('https://www.careerjet.com/partners/signup.html', esc_html__('How to get your API Key', 'nokri')),
        ),
        array(
            'id' => 'nokri_careerjet_import_jobs',
            'required' => array('careerjet_api_btn', '=', '1'),
            'type' => 'select',
            'title' => esc_html__('Jobs limit', 'nokri'),
            'subtitle' => esc_html__('Select jobs limit to display', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 15 => 15, 15 => 15, 16 => 16,
                17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21, 22 => 22, 23 => 23, 24 => 24, 25 => 25),
            'default' => 5,
            'desc' => esc_html__('Add default number of jobs to post maximum 25', 'nokri'),
        ),
)));
/* ------------------ Adzuna Jobs Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Adzuna Jobs Settings', 'nokri'),
    'id' => 'nokri-adzunajobs-settings',
    'desc' => '',
    'subsection' => true,
    'icon' => 'el el-wrench',
    'fields' => array(
        array(
            'id' => 'adzunajobs_btn',
            'type' => 'switch',
            'title' => esc_html__('Adzuna Jobs', 'nokri'),
            'desc' => esc_html__('On/Off Adzuna Jobs Api', 'nokri'),
            'default' => false,
        ),
        array(
            'required' => array('adzunajobs_btn', '=', array('1')),
            'id' => 'nokri_adzuna_api_id',
            'type' => 'text',
            'title' => esc_html__('Adzuna Api ID', 'nokri'),
            'subtitle' => esc_html__('Please Enter your Api key Here', 'nokri'),
            'desc' => nokri_make_link('https://developer.adzuna.com/docs/search', esc_html__('How to get your API Key', 'nokri')),
        ),
        array(
            'required' => array('adzunajobs_btn', '=', array('1')),
            'id' => 'nokri_adzuna_api_key',
            'type' => 'text',
            'title' => esc_html__('Adzuna Api Key', 'nokri'),
            'subtitle' => esc_html__('Please Enter your Api key Here', 'nokri'),
            'desc' => nokri_make_link('https://developer.adzuna.com/docs/search', esc_html__('How to get your API Key', 'nokri')),
        ),
        array(
            'id' => 'nokri_adzuna_loc_keyword',
            'required' => array('adzunajobs_btn', '=', '1'),
            'type' => 'select',
            'title' => esc_html__('Country for Jobs', 'nokri'),
            'subtitle' => esc_html__('Select a country for job to display', 'nokri'),
            'options' => array('ca' => 'ca', 'au' => 'au', 'gb' => 'gb', 'br' => 'br', 'br' => 'br', 'de' => 'de', 'fr' => 'fr', 'in' => 'in', 'it' => 'it', 'nl' => 'nl', 'nz' => 'nz', 'pl' => 'pl',
                'ru' => 'ru', 'sg' => 'sg', 'us' => 'us', 'ra' => 'ra',),
            'default' => 'gb',
            'desc' => nokri_make_link('https://en.wikipedia.org/wiki/ISO_3166-1', esc_html__('ISO 8601 country code of the country of interest', 'nokri')),
        ),
        array(
            'id' => 'nokri_adzuna_jobs_limit',
            'required' => array('adzunajobs_btn', '=', '1'),
            'type' => 'select',
            'title' => esc_html__('Jobs limit', 'nokri'),
            'subtitle' => esc_html__('Select jobs limit to display', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 15 => 15, 15 => 15, 16 => 16,
                17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21, 22 => 22, 23 => 23, 24 => 24, 25 => 25, 26 => 26, 27 => 27, 28 => 28, 29 => 29, 30 => 30, 31 => 31, 32 => 32, 33 => 33, 34 => 34, 35 => 35,),
            'default' => 5,
            'desc' => esc_html__('Add default number of jobs to post maximum 35', 'nokri'),
        ),
)));
/* ------------------ Remotive Jobs Api ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Remotive Jobs Api', 'nokri'),
    'id' => 'nokri-remotive-sec-settings',
    'desc' => '',
    'subsection' => true,
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'remotive_api_btn',
            'type' => 'switch',
            'title' => esc_html__('Remotive Api', 'nokri'),
            'desc' => esc_html__('On/Off Remotive Api', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'nokri_remotive_import_jobs',
            'required' => array('remotive_api_btn', '=', '1'),
            'type' => 'select',
            'title' => esc_html__('Jobs limit', 'nokri'),
            'subtitle' => esc_html__('Select jobs limit to display', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 15 => 15, 15 => 15, 16 => 16,
                17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21, 22 => 22, 23 => 23, 24 => 24, 25 => 25),
            'default' => 5,
            'desc' => esc_html__('Add default number of jobs to post maximum 25', 'nokri'),
        ),
)));
Redux::setSection($opt_name, array(
    'title' => esc_html__('Indeed Settting', 'nokri'),
    'id' => 'nokri-indeed-jobs-setting',
    'desc' => 'Here Setup Your Indeed import accordingly',
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'nokri_indeed_publisher_id',
            //'required' => array('nokri_indeed_import_switch' ,'=' , '1'),
            'type' => 'text',
            'title' => esc_html__('Indeed Publisher ID', 'nokri'),
            'desc' => nokri_make_link('https://www.indeed.com/publisher', esc_html__('How to Find it', 'nokri')),
        ),
        array(
            'id' => 'nokri_indeed_default_job_import',
            //   'required' => array('nokri_indeed_import_switch' ,'=' , '1'),
            'type' => 'select',
            'title' => esc_html__('Attachment limit', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 15 => 15, 15 => 15, 16 => 16,
                17 => 17, 18 => 18, 19 => 19, 20 => 20, 21 => 21, 22 => 22, 23 => 23, 24 => 24, 25 => 25),
            'default' => 5,
            'desc' => esc_html__('add deafult number of jobs to post maximum 25', ''),
        ),
        array(
            'id' => 'nokri_indeed_jobsnumber_switch',
            'type' => 'switch',
            'title' => esc_html__('Jobs number Filter', 'nokri'),
            'subtitle' => 'Hide/show jobs number Filter',
            'default' => true,
        ),
        array(
            'id' => 'sb_indeeed_search_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('indeed search  Page', 'nokri'),
            'subtitle' => 'Select Your Indeed Search Page',
        ),
)));
/* ========================= */
/* Pages Settings */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Page Setups', 'nokri'),
    'id' => 'nokri-page-linkss',
    'desc' => 'Here Setup Your Pages Accordingly',
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'sb_sign_in_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Sign In Page', 'nokri'),
            'subtitle' => 'Select Your Signin Page',
            'default' => array('156'),
        ),
        array(
            'id' => 'sb_sign_up_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Sign Up Page', 'nokri'),
            'subtitle' => 'Select Your Signup Page',
            'default' => array('145'),
        ),
        array(
            'id' => 'term_condition',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Term And Condition Page', 'nokri'),
            'subtitle' => 'Term And Condition Page',
            'default' => array('6'),
        ),
        array(
            'id' => 'terms_text',
            'type' => 'text',
            'title' => esc_html__('Terms & Conditions', 'nokri'),
            'placeholder' => __('Must add text to show Terms & Conditions', 'nokri'),
            'subtitle' => __('Enter Text for Terms and Conditions', 'nokri'),
            'desc' => __('This text will display at the Front End', 'nokri'),
        ),
        array(
            'id' => 'sb_dashboard_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Dashboard Page', 'nokri'),
            'subtitle' => 'Select Redirecting Page After Employer Signup/Signin',
            'default' => array('235'),
        ),
        array(
            'id' => 'candidates_search_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Candidates Page', 'nokri'),
            'subtitle' => 'Select candidates search page',
            'default' => array('239'),
        ),
        array(
            'id' => 'employer_search_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Employer page', 'nokri'),
            'subtitle' => 'Select employer search page',
            'default' => array('424'),
        ),
        array(
            'id' => 'package_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Purchase Package', 'nokri'),
            'subtitle' => 'Set Your Purchase Package Page',
            'default' => array('441'),
        ),
        array(
            'id' => 'cand_package_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Candidate  Packages', 'nokri'),
            'subtitle' => 'Set Your Candidate Package Page',
            'default' => array('441'),
        ),
        array(
            'id' => 'contact_us',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Contact  us page', 'nokri'),
            'subtitle' => 'Set Your Contact us Page',
            'default' => array('291'),
        ),
        array(
            'id' => 'about_us',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('About  us', 'nokri'),
            'subtitle' => 'Set your about us page',
            'default' => array('289'),
        ),
    )
));
/* ========================= */
/* Email Templates */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => __('Email Templates', 'nokri'),
    'id' => 'nokri-email-templates',
    'desc' => '',
    'icon' => 'el el-pencil',
    'fields' => array(
    )
));
Redux::setSection($opt_name, array(
    'title' => __('New user contact', "nokri"),
    'id' => 'sb_new_cotact_email',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* New contact message template */
        array(
            'id' => 'sb_new_cotact_message',
            'type' => 'text',
            'title' => __('New user contact subject', 'nokri'),
            'default' => 'New contact message',
        ),
        array(
            'id' => 'sb_new_cotact_from',
            'type' => 'text',
            'title' => __('New user email FROM for Admin', 'nokri'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_new_cotact_body',
            'type' => 'editor',
            'title' => __('New user contact template', 'nokri'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %display_name%, %email% ,%subject%,%message% will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %receiver_name%</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
New contact message recieved on  %site_name%;

<p>Name: %display_name% </p>

<p>Email: %email% </p>

<p>Subject: %subject% </p>

<p>Message: %message% </p>

&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
    )
));
/* * *************************** */
/* Before package expiry email */
/* * *************************** */
Redux::setSection($opt_name, array(
    'title' => __('Mail Before Package Expiry', "nokri"),
    'id' => 'sb_before_package_expiry_email',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* Before Pakage expire  alert email */

        array(
            //'required' => array( 'job_post_form', '=', array( '1' ) ),
            'id' => 'sb_package_expiry_days',
            'type' => 'select',
            'title' => esc_html__('Select days to notify', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15),
            'default' => 1,
            'description' => esc_html__('Select days before you notify about package expiry', 'nokri'),
        ),
        array(
            'id' => 'sb_package_expiry_message',
            'type' => 'text',
            'title' => __('package expiry subject', 'nokri'),
            'default' => 'Package expiry notification',
        ),
        array(
            'id' => 'sb_before_package_expiry_from',
            'type' => 'text',
            'title' => __('package expiry email FROM ', 'nokri'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_before_package_expiry_body',
            'type' => 'editor',
            'title' => __('Before package expiry email template', 'nokri'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %display_name%, ,%subject%,%message% (here message reflects date)will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello </span>%display_name%</p>
New Message received  from %site_name%;
<p>Subject: %subject%</p>
<p>Message: your package is going to be expired on  %message%</p>
 
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
 </div>
</td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>',
        ),
    )
));
/* * *************************** */
/* Job Expiry Notification expiry email */
/* * *************************** */
Redux::setSection($opt_name, array(
    'title' => __('Job Expiry Email', "nokri"),
    'id' => 'sb_before_jobs_expiry_email',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* Before Pakage expire  alert email */


        array(
            //'required' => array( 'job_post_form', '=', array( '1' ) ),
            'id' => 'sb_job_expiry_days',
            'type' => 'select',
            'title' => esc_html__('Select days to notify', 'nokri'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15),
            'default' => 1,
            'description' => esc_html__('Select days before you notify about job expiry', 'nokri'),
        ),
        array(
            'id' => 'sb_jobs_expiry_message',
            'type' => 'text',
            'title' => __('Jobs expiry subject', 'nokri'),
            'default' => 'Jobs expiry notification',
        ),
        array(
            'id' => 'sb_before_jobs_expiry_from',
            'type' => 'text',
            'title' => __('Jobs expiry email FROM ', 'nokri'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_before_jobs_expiry_body',
            'type' => 'editor',
            'title' => __('Before jobs expiry email template', 'nokri'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %display_name%, ,%job_name%,%job_url% ,%date% will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello </span>%display_name%</p>
New Message received  from %site_name%;

<p>Message: your job <a href="%job_url%">%job_name%</a> is going to expire on %date%</p>
 
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
 </div>
</td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>',
        ),
        array(
            'id' => 'sb_after_jobs_expiry_body',
            'type' => 'editor',
            'title' => __('After jobs expiry email template', 'nokri'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %display_name%, ,%job_name%,%job_url% ,%date% will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello </span>%display_name%</p>
New Message received  from %site_name%;

<p>Message: your job <a href="%job_url%">%job_name%</a> has expired on  %date%</p>
 
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
 </div>
</td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>',
        ),
    )
));
/* * *************************** */
/* With out login apply email */
/* * *************************** */
Redux::setSection($opt_name, array(
    'title' => __('Apply without login ', "nokri"),
    'id' => 'sb_without_login_email',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'sb_without_login_email_message',
            'type' => 'text',
            'title' => __('Apply message subject', 'nokri'),
            'default' => __('New applier message', 'nokri'),
        ),
        array(
            'id' => 'sb_without_login_from',
            'type' => 'text',
            'title' => __('New user email FROM for Admin', 'nokri'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_without_login_body',
            'type' => 'editor',
            'title' => __('New applier email template', 'nokri'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %display_name%,%subject%,%email%,%password%,%job_title% will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello Admin</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
New apply  %site_name%;

<p>Name: %display_name% </p>

<p>Subject: %subject% </p>

<p>Email: %email% </p>

<p>Password: %password% </p>

<p>Job title: %job_title% </p>


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
    )
));
/* * *************************** */
/*  Zoom Candidate Meeting url Mail */
/* * *************************** */
Redux::setSection($opt_name, array(
    'title' => __('Send Zoom meeting link to candidate', "nokri"),
    'id' => 'nokri_send_cand_meeting_link',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'nokri_send_cand_meeting_subject',
            'type' => 'text',
            'title' => __('Meeting Invitation subject', 'nokri'),
            'default' => __('New applier message', 'nokri'),
        ),
        array(
            'id' => 'nokri_send_cand_meeting_from',
            'type' => 'text',
            'title' => __('New meeting link from', 'nokri'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'nokri_send_cand_meeting_body',
            'type' => 'editor',
            'title' => __('New applier email template', 'nokri'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% ,%cand_name%,%emp_name%,%job_title% ,%meeting_url% ,%meeting_id% ,%meeting_pass% ,%meeting_time% ,%meet_duration% will be translated accordingly', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
                    <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
                        <div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
                            <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
                                <tbody>
                                    <tr>
                                        <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                                            <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                        <td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">

                                                            A Designing and development company</td>
                                                    </tr>
                                                    <tr>
                                                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %cand_name%  You have a new Meeting invitation</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>

                                                        New Meeting  %site_name%;

                                                        <p>Company name: %emp_name% </p>
                                                        <p>Job title:<a href = "%job_link%"> %job_title% </p>
                                                        <p>Meeting URL: %meeting_url% </p>
                                                        <p>Meeting ID: %meeting_id% </p>
                                                        <p>Meeting Password: %meeting_pass% </p>
                                                        <p>Meeting Start Time: %meeting_time% </p>
                                                        <p>Meeting Duration: %meet_duration% </p>

                                                        &nbsp;
                                                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
                                                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
                                                </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
                    <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                &nbsp;

            </div></td>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
    </tr>
</tbody>
</table>
&nbsp;',
        ),
    )
));
/* * ********* */
/* Email job */
/* * ******** */
Redux::setSection($opt_name, array(
    'title' => __('Email Job To Anyone', "nokri"),
    'id' => 'sb_email_job_to_anyone',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'sb_email_job_to_anyone_subj',
            'type' => 'text',
            'title' => __('Email Subject', 'nokri'),
            'default' => __('Job For You', 'nokri'),
        ),
        array(
            'id' => 'sb_email_job_to_anyone_from',
            'type' => 'text',
            'title' => __('New user email FROM for Admin', 'nokri'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_email_job_to_anyone_body',
            'type' => 'editor',
            'title' => __('New applier email template', 'nokri'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %job_title%, %job_link% will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
<p>Job Title: %job_title% </p>

<p>Job Link: %job_link% </p>


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
    )
));
/* * ***************** */
/* Email job alerts */
/* * ***************** */
Redux::setSection($opt_name, array(
    'title' => __('Email job alerts', "nokri"),
    'id' => 'sb_email_job_alerts',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'sb_email_job_alerts_subj',
            'type' => 'text',
            'title' => __('Email Subject', 'nokri'),
            'default' => __('Job For You', 'nokri'),
        ),
        array(
            'id' => 'sb_email_job_alerts_from',
            'type' => 'text',
            'title' => __('New user email FROM for Admin', 'nokri'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_email_job_alerts_body',
            'type' => 'editor',
            'title' => __('Job alerts email template', 'nokri'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %job_title%, %job_link% will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
<p>Job Title: %job_title% </p>

<p>Job Link: %job_link% </p>


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Candidate status', "nokri"),
    'id' => 'sb_job_status_email_template',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* Job status email template */
        array(
            'id' => 'sb_job_status_subject',
            'type' => 'text',
            'title' => __('Candidate status email template subject for Admin', 'nokri'),
            'default' => 'Apllication status',
        ),
        array(
            'id' => 'sb_job_status_message_from',
            'type' => 'text',
            'title' => __('New user email FROM for Admin', 'nokri'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('New User Register Email', "nokri"),
    'id' => 'api_new_user_register_template_admin',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'sb_new_user_email_to_admin',
            'type' => 'switch',
            'title' => __('New User Email to Admin', 'nokri'),
            'default' => true
        ),
        array(
            'id' => 'sb_new_user_admin_message_subject_admin',
            'type' => 'text',
            'title' => __('New user email template subject for Admin', 'nokri'),
            'default' => 'New User Registration',
        ),
        array(
            'id' => 'sb_new_user_admin_message_from_admin',
            'type' => 'text',
            'title' => __('New user email FROM for Admin', 'nokri'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_new_user_admin_message_admin',
            'type' => 'editor',
            'title' => __('New user email template for Admin', 'nokri'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %display_name%, %email% will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello Admin</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
New user has registered on your site %site_name%;

Name: %display_name%

Email: %email%

&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('User Welcome/Confirmation', "nokri"),
    'id' => 'api_new_user_register_template',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'sb_new_user_email_to_user',
            'type' => 'switch',
            'title' => __('Welcome Email to User', 'nokri'),
            'default' => true
        ),
        array(
            'id' => 'sb_new_user_email_verification',
            'type' => 'switch',
            'title' => __('New user email verification', 'nokri'),
            'default' => false,
            'desc' => __('If verfication on then please update your new user email template by verification link.', 'nokri'),
        ),
        array(
            'id' => 'admin_contact_page',
            'type' => 'select',
            'data' => 'pages',
            'multi' => false,
            'title' => __('Contact to Admin', 'nokri'),
            'required' => array('sb_new_user_email_verification', '=', array('1')),
            'desc' => __('Select the page if verification email is not sent to new user.', 'nokri'),
        ),
        /* New User Registration email template */
        array(
            'id' => 'sb_new_user_message_subject',
            'type' => 'text',
            'title' => __('New user email template subject', 'nokri'),
            'default' => 'New User Registration',
        ),
        array(
            'id' => 'sb_new_user_message_from',
            'type' => 'text',
            'title' => __('New user email FROM', 'nokri'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_new_user_message',
            'type' => 'editor',
            'title' => __('New user email template', 'nokri'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %user_name% %display_name% %verification_link% will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %display_name%</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
Welcome to %site_name%.
<br />
Your details are below;
<br />

Username: %user_name%
<br />


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('New Password', "nokri"),
    'id' => 'api_new_user_password_template',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* New Password email subject email template */
        array(
            'id' => 'sb_forgot_password_subject',
            'type' => 'text',
            'title' => esc_html__('New Password email subject', 'nokri'),
            'desc' => esc_html__('%site_name% will be translated accordingly.', 'nokri'),
            'default' => 'New Password - nokri',
        ),
        array(
            'id' => 'sb_forgot_password_from',
            'type' => 'text',
            'title' => esc_html__('New Password email FROM', 'nokri'),
            'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_forgot_password_message',
            'type' => 'editor',
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'title' => esc_html__('New Password template', 'nokri'),
            'desc' => esc_html__('%site_name% , %user% , %reset_link% will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %user%</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
Your new password is %password%
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('New Job Post', "nokri"),
    'id' => 'api_new_user_new_job_template',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* New job email email template */
        array(
            'id' => 'sb_send_email_on_ad_post',
            'type' => 'switch',
            'title' => esc_html__('Send email on job Post', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'ad_post_email_value',
            'type' => 'text',
            'title' => esc_html__('Email for notification.', 'nokri'),
            'required' => array('sb_send_email_on_ad_post', '=', '1'),
            'default' => get_option('admin_email'),
        ),
        array(
            'id' => 'sb_msg_subject_on_new_ad',
            'type' => 'text',
            'title' => esc_html__('New job email subject', 'nokri'),
            'desc' => esc_html__('%site_name% , %job_owner% , %job_title% will be translated accordingly.', 'nokri'),
            'default' => 'You have new job - nokri',
        ),
        array(
            'id' => 'sb_msg_from_on_new_ad',
            'type' => 'text',
            'title' => esc_html__('New job FROM', 'nokri'),
            'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_msg_on_new_ad',
            'type' => 'editor',
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'title' => esc_html__('New job Posted Message', 'nokri'),
            'desc' => esc_html__('%site_name% , %job_owner% , %job_title% , %job_link% will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><br/>
A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>Admin,</b></span></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">You\'ve new job;</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Title: %job_title%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Link: <a href="%job_link%">%job_title%</a></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Poster: %job_owner%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('New Apply On Job', "nokri"),
    'id' => 'api_new_user_new_apply_template',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* New job email email template */
        array(
            'id' => 'sb_send_email_on_apply',
            'type' => 'switch',
            'title' => esc_html__('Send email on job apply', 'nokri'),
            'default' => true,
        ),
        array(
            'id' => 'sb_send_email_from',
            'type' => 'text',
            'title' => esc_html__('Email for notification.', 'nokri'),
            'required' => array('sb_send_email_on_apply', '=', '1'),
            'default' => get_option('admin_email'),
        ),
        array(
            'id' => 'sb_msg_subject_on_new_apply',
            'type' => 'text',
            'title' => esc_html__('New apply job email subject', 'nokri'),
            'default' => esc_html__('You have new applier', 'nokri'),
        ),
        array(
            'id' => 'sb_msg_from_on_new_apply',
            'type' => 'text',
            'title' => esc_html__('FROM', 'nokri'),
            'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_msg_on_new_apply',
            'type' => 'editor',
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'title' => esc_html__('New apply  Message', 'nokri'),
            'desc' => esc_html__('%site_name% ,%job_title% , %candidate_name% will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><br/>
A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"></span></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">You\'ve new job apply;</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
Title: %job_title%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
Candidate name: %candidate_name%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
Candidate cover: %candidate_cover%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;
</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
    )
));
//Message to applier after applying job
Redux::setSection($opt_name, array(
    'title' => __('Applier welcome message', "nokri"),
    'id' => 'nokri_new_applier_welcome_message_template',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* New job email email template */
        array(
            'id' => 'sb_send_welcome_email_on_apply',
            'type' => 'switch',
            'title' => esc_html__('Send welcome email on job apply', 'nokri'),
            'default' => false,
        ),
        array(
            'id' => 'sb_welcome_msg_subject_on_new_apply',
            'type' => 'text',
            'title' => esc_html__('New apply job email subject', 'nokri'),
            'required' => array('sb_send_welcome_email_on_apply', '=', '1'),
            'default' => esc_html__('Welcome to', 'nokri'),
        ),
        array(
            'id' => 'sb_welcome_msg_from_on_new_apply',
            'type' => 'text',
            'title' => esc_html__('FROM', 'nokri'),
            'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'nokri'),
            'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
            'required' => array('sb_send_welcome_email_on_apply', '=', '1'),
        ),
        array(
            'id' => 'sb_welcome_msg_on_new_apply',
            'type' => 'editor',
            'required' => array('sb_send_welcome_email_on_apply', '=', '1'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'title' => esc_html__('New apply  Message', 'nokri'),
            'desc' => esc_html__('%site_name% ,%job_title% , %candidate_name% , %candidate_link% , %job_lnk%  , %comp_name% , %comp_link% will be translated accordingly.', 'nokri'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><br />A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Welcome</span></p>
<p>Candidate name:  <a href = "%candidate_link%">  %candidate_name%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">You have successfully Applied on  <a href="%job_link%"> %job_title%  </a>  offered  by  <a href ="%comp_link%"> %comp_name% </a> ;</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">We will get back to you shortly.</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"> </p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
 </div>
</td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"> </td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>',
        ),
    )
));

/* ========================= */
/* Blog Settings */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Blog Settings', 'nokri'),
    'id' => 'blog_post_settings',
    'customizer_width' => '500px',
    'icon' => 'el el-edit',
));
Redux::setSection($opt_name, array(
    'title' => esc_html__('Main Page', 'nokri'),
    'id' => 'edit-blog',
    //'icon'  => 'el el-home'
    'desc' => esc_html__('Here Make Settings You Want At Main Blog Page ', 'nokri'),
    'subsection' => true,
    'fields' => array(
        array(
            'required' => array('breadcrumb_switch', '=', array('1')),
            'id' => 'bread_blog',
            'type' => 'text',
            'title' => esc_html__('Main Blog Page', 'nokri'),
            'subtitle' => esc_html__('Type Your Text', 'nokri'),
            'default' => esc_html__('Latest Stories', 'nokri'),
        ),
        array(
            'id' => 'main_blog_side_bar',
            'type' => 'button_set',
            'title' => esc_html__('Select Side Bar', 'nokri'),
            'options' => array(
                '1' => esc_html__('Right Side Bar', 'nokri'),
                '2' => esc_html__('Left Side Bar', 'nokri'),
            ),
            'default' => '1',
        ),
        array(
            'id' => 'theme_date',
            'type' => 'switch',
            'title' => esc_html__('Posted date', 'nokri'),
            'subtitle' => esc_html__('Hide/show posted date', 'nokri'),
            'default' => true,
        ),
    ),
));
Redux::setSection($opt_name, array(
    'title' => esc_html__('Single Page', 'nokri'),
    'id' => 'single-blog',
    //'icon'  => 'el el-home'
    'desc' => esc_html__('Here Make Settings You Want At Single Blog Page ', 'nokri'),
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'single_blog_side_bar',
            'type' => 'button_set',
            'title' => esc_html__('Select Side Bar', 'nokri'),
            'options' => array(
                '1' => esc_html__('Right Side Bar', 'nokri'),
                '2' => esc_html__('Left Side Bar', 'nokri'),
            ),
            'default' => '1',
        ),
    ),
));
Redux::setSection($opt_name, array(
    'title' => esc_html__('404 Page Settings', 'nokri'),
    'id' => 'page_settings_not',
    //'icon'  => 'el el-home'
    'subsection' => true,
    'desc' => esc_html__('Here You Can Make Setting Of 404 page', 'nokri'),
    'fields' => array(
        array(
            'id' => '404_bg_img',
            'type' => 'background',
            'url' => true,
            'background-color' => false,
            'title' => esc_html__('Upload section bg image', 'nokri'),
            'compiler' => 'true',
            'default' => array(
                'background-image' => '',
                'background-repeat' => 'no-repeat',
                'background-size' => 'cover',
                'background-position' => 'center bottom',
                'background-attachment' => 'scroll'
            )
        ),
        array(
            'id' => '404-heading',
            'type' => 'text',
            'title' => esc_html__('Heading', 'nokri'),
            'subtitle' => esc_html__('Type Your Text', 'nokri'),
            'default' => 404,
        ),
        array(
            'id' => '404-text',
            'type' => 'text',
            'title' => esc_html__('Tagline', 'nokri'),
            'subtitle' => esc_html__('Type Your Text', 'nokri'),
            'default' => esc_html__('Whoops! Page Not Found', 'nokri'),
        ),
        array(
            'id' => '404-text-area',
            'type' => 'textarea',
            'title' => esc_html__('Description', 'nokri'),
            'subtitle' => esc_html__('Type Your Text', 'nokri'),
            'default' => esc_html__('Sorry, the page you are looking for is not exit.', 'nokri'),
        ),
        array(
            'id' => '404-btn-text',
            'type' => 'text',
            'title' => esc_html__('Button Text', 'nokri'),
            'subtitle' => esc_html__('Type Text On Button', 'nokri'),
            'default' => esc_html__('Take Me Home', 'nokri'),
        ),
    )
));
/* ========================= */
/*      Footer Settings      */
/* ========================= */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Footer Settings', 'nokri'),
    'id' => 'footer_settings',
    'desc' => esc_html__('Footers Settings', 'nokri'),
    'icon' => 'el el-screen'
));
Redux::setSection($opt_name, array(
    'title' => esc_html__('Details', 'nokri'),
    'id' => 'footer_section_details',
    'desc' => esc_html__('Here You Can Set Footer Settings', 'nokri'),
    'subsection' => true,
    'fields' => array(
        /* Hide/show Elementor Pro full footer */
        array(
            //'required' => array( 'main_header_style', '=', array( '2') ),
            'id' => 'is_elementor_footer',
            'type' => 'switch',
            'title' => esc_html__('Elementor Pro Footer', 'nokri'),
            'subtitle' => esc_html__('Enable/Disable Elementor Pro Footer', 'nokri'),
            'desc' => esc_html__('On this option only if you want to use custom footer and using Elementor Pro Version', 'nokri'),
            'default' => false,
        ),
        /* Hide/show full footer */
        array(
            'id' => 'footer_full',
            'type' => 'switch',
            'title' => esc_html__('Footer Widget', 'nokri'),
            'subtitle' => esc_html__('Hide/Show Footer', 'nokri'),
            'default' => false,
        ),
        /* Footer background */
        array(
            'id' => 'footer_bg_img',
            'type' => 'background',
            'background-color' => false,
            'url' => true,
            'title' => esc_html__('Upload Footer Image', 'nokri'),
            'compiler' => 'true',
            'desc' => esc_html__('Size 200 * 90', 'nokri'),
            'subtitle' => esc_html__('Upload Footer Bg Image', 'nokri'),
            'default' => array(
                'background-image' => get_template_directory_uri() . '/images/footer.png',
                'background-repeat' => 'no-repeat',
                'background-size' => 'cover',
                'background-position' => 'center center',
                'background-attachment' => 'fixed'
            ),
            'required' => array('select_footer_layout', '=', array('1', '2', '4')),
        ),
        /* Footer selection */
        array(
            'id' => 'select_footer_layout',
            'type' => 'button_set',
            'title' => esc_html__('Select Footer Style', 'nokri'),
            'subtitle' => esc_html__('Select Footer You Want ', 'nokri'),
            'options' => array(
                '1' => esc_html__('Footer 1', 'nokri'),
                '2' => esc_html__('Footer 2', 'nokri'),
                '3' => esc_html__('Footer 3', 'nokri'),
                '4' => esc_html__('Footer 4', 'nokri'),
                '5' => esc_html__('Footer 5', 'nokri'),
            ),
            'default' => '1',
        ),
        array(
            'required' => array('select_footer_layout', '=', array('4')),
            'id' => 'select_footer_image',
            'type' => 'button_set',
            'title' => esc_html__('Select Background Image Option', 'nokri'),
            'options' => array(
                '1' => esc_html__('Transparent Image', 'nokri'),
                '2' => esc_html__('Standard Image', 'nokri'),
            ),
            'default' => '1',
        ),
        /* Footer sorter */
        array(
            'required' => array('select_footer_layout', '=', array('3')),
            'id' => 'opt_footer3_sorter',
            'type' => 'sorter',
            'title' => esc_html__('Footer soter', 'nokri'),
            'subtitle' => esc_html__('Enable olny four at a time', 'nokri'),
            'desc' => esc_html__('Organize how you want the layout to appear on the footer', 'nokri'),
            'compiler' => 'true',
            'options' => array(
                'enabled' => array(
                    'loc' => 'Location',
                    'skills' => 'Skills',
                    'cat' => 'Categories',
                    'news' => 'News Letter',
                    'hot' => 'Hot Links',
                    'app' => 'App section',
                ),
                'disabled' => array(
                ),
            ),),
        /* Logo footer */
        array(
            'required' => array('select_footer_layout', '=', array('2', '3', '4', '5')),
            'id' => 'footer_bg',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Upload Footer Logo', 'nokri'),
            'compiler' => 'true',
            'desc' => esc_html__('Size 200 * 90', 'nokri'),
            'subtitle' => esc_html__('Upload Footer Logo Here', 'nokri'),
            'default' => array('url' => get_template_directory_uri() . '/images/logo.png'),
        ),
        array(
            'required' => array('select_footer_layout', '=', array('5')),
            'id' => 'logo_below_text',
            'type' => 'text',
            'title' => esc_html__('Tag Line', 'nokri'),
            'subtitle' => esc_html__('Text below the logo', 'nokri'),
            'default' => '',
        ),
        /* Subscribe our newsletters */
        array(
            'required' => array('select_footer_layout', '=', array('1', '3', '5')),
            'id' => 'subscribe_text',
            'type' => 'text',
            'title' => esc_html__('Subscribe news letter', 'nokri'),
            'subtitle' => esc_html__('Section text', 'nokri'),
            'default' => esc_html__('Subscribe our newsletters', 'nokri'),
        ),
        array(
            'required' => array('select_footer_layout', '=', array('1', '4', '5')),
            'id' => 'subscribe_description',
            'type' => 'textarea',
            'title' => esc_html__('Section Description', 'nokri'),
            'default' => esc_html__('Are you interested in nokri new features and update? subscribe now!.', 'nokri'),
        ),
        /* Socail links */
        array(
            'id' => 'footer_social_sorter',
            'type' => 'sortable',
            'desc' => esc_html__('Drags To Sort Like You Want', 'nokri'),
            'label' => true,
            'options' => array(
                'Face Book' => 'www.facebook.com',
                'Twitter' => 'www.twitter.com',
                'Instagram' => 'www.instagram.com',
                'LinkedIn' => 'www.linkedIn.com',
                'Behance' => 'www.behance.com',
                'Pintrest' => 'www.pintrest.com',
                'Youtube' => 'www.youtube.com',
            ),
            'default' => array(
                'Face Book' => 'www.facebook.com',
                'Twitter' => 'www.twitter.com',
                'Instagram' => 'www.Instagram.com',
                'LinkedIn' => 'www.linkedIn.com',
                'Behance' => 'www.behance.com',
                'Youtube' => 'www.youtube.com',
            )
        ),
        /* Job location */
        array(
            'required' => array('select_footer_layout', '=', array('1', '2', '3', '5')),
            'id' => 'job_locations_links_text',
            'type' => 'text',
            'title' => esc_html__('Job Locations Text', 'nokri'),
            'subtitle' => esc_html__('Type Your Job Locations Text', 'nokri'),
            'default' => esc_html__('Job Locations', 'nokri'),
        ),
        array(
            'required' => array('select_footer_layout', '=', array('1', '2', '3', '5')),
            'id' => 'job_locations_links',
            'type' => 'select',
            'multi' => true,
            'title' => esc_html__('Select job locations', 'nokri'),
            'data' => 'terms',
            'args' => array(
                'taxonomies' => 'ad_location', 'hide_empty' => false,
            ),
        ),
        /* Job categories */
        array(
            'required' => array('select_footer_layout', '=', array('3')),
            'id' => 'job_categories_txt',
            'type' => 'text',
            'title' => esc_html__('Job Categories Text', 'nokri'),
            'subtitle' => esc_html__('Type Your Job Categories Text', 'nokri'),
            'default' => esc_html__('Job Categories', 'nokri'),
        ),
        array(
            'required' => array('select_footer_layout', '=', array('3')),
            'id' => 'job_categories_links',
            'type' => 'select',
            'multi' => true,
            'title' => esc_html__('Select job categories', 'nokri'),
            'data' => 'terms',
            'args' => array(
                'taxonomies' => 'job_category', 'hide_empty' => false,
            ),
        ),
        /* Job Skills */
        array(
            'required' => array('select_footer_layout', '=', array('3')),
            'id' => 'job_skills_txt',
            'type' => 'text',
            'title' => esc_html__('Job Skills Text', 'nokri'),
            'subtitle' => esc_html__('Type Your Job Skills Text', 'nokri'),
            'default' => esc_html__('Job Skills', 'nokri'),
        ),
        array(
            'required' => array('select_footer_layout', '=', array('3')),
            'id' => 'job_skills_links',
            'type' => 'select',
            'multi' => true,
            'title' => esc_html__('Select job skills', 'nokri'),
            'data' => 'terms',
            'args' => array(
                'taxonomies' => 'job_skills', 'hide_empty' => false,
            ),
        ),
        /* App section */
        array(
            'required' => array('select_footer_layout', '=', array('1', '2', '3')),
            'id' => 'is_show_app_section',
            'type' => 'switch',
            'title' => esc_html__('App section', 'nokri'),
            'subtitle' => esc_html__('Hide/Show App section', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('is_show_app_section', '=', array('1')),
            'id' => 'app_section_title',
            'type' => 'text',
            'title' => esc_html__('Apps section title', 'nokri'),
            'subtitle' => esc_html__('Enter apps section title text', 'nokri'),
            'default' => esc_html__('Get Our Apps', 'nokri'),
        ),
        /* Play store section */
        array(
            'required' => array('is_show_app_section', '=', array('1')),
            'id' => 'play_store_tagline',
            'type' => 'text',
            'title' => esc_html__('Tag line', 'nokri'),
            'subtitle' => esc_html__('Enter tagline', 'nokri'),
            'default' => esc_html__('Get it on', 'nokri'),
        ),
        array(
            'required' => array('is_show_app_section', '=', array('1')),
            'id' => 'play_store_heading',
            'type' => 'text',
            'title' => esc_html__('Play store heading', 'nokri'),
            'subtitle' => esc_html__('Enter play store heading', 'nokri'),
            'default' => esc_html__('Play store', 'nokri'),
        ),
        array(
            'required' => array('is_show_app_section', '=', array('1')),
            'id' => 'play_store_link',
            'type' => 'text',
            'title' => esc_html__('Play store link', 'nokri'),
            'subtitle' => esc_html__('Enter play store link', 'nokri'),
        ),
        /* Apple store section */
        array(
            'required' => array('is_show_app_section', '=', array('1')),
            'id' => 'apple_store_tagline',
            'type' => 'text',
            'title' => esc_html__('Tag line', 'nokri'),
            'subtitle' => esc_html__('Enter tagline', 'nokri'),
            'default' => esc_html__('Get it on', 'nokri'),
        ),
        array(
            'required' => array('is_show_app_section', '=', array('1')),
            'id' => 'apple_store_heading',
            'type' => 'text',
            'title' => esc_html__('Apple store heading', 'nokri'),
            'subtitle' => esc_html__('Enter apple store heading', 'nokri'),
            'default' => esc_html__('Apple store', 'nokri'),
        ),
        array(
            'required' => array('is_show_app_section', '=', array('1')),
            'id' => 'apple_store_link',
            'type' => 'text',
            'title' => esc_html__('Play store link', 'nokri'),
            'subtitle' => esc_html__('Enter apple store link', 'nokri'),
        ),
        /* Hot links footer1 */
        array(
            'required' => array('select_footer_layout', '=', array('1', '5')),
            'id' => 'footer_hot_links',
            'type' => 'text',
            'title' => esc_html__('Hot Links Text', 'nokri'),
            'subtitle' => esc_html__('Type Your Hot Links Text', 'nokri'),
            'default' => esc_html__('Hot Links', 'nokri'),
        ),
        array(
            'required' => array('select_footer_layout', '=', array('1', '5')),
            'id' => 'opt_multi_select_footer_hot_Links',
            'type' => 'select',
            'data' => 'pages',
            'multi' => true,
            'title' => esc_html__('Hot Links ', 'nokri'),
            'subtitle' => esc_html__('Select Pages That Show On Footer', 'nokri'),
            'default' => array('2'),
        ),
        /* copyrights section */
        array(
            'id' => 'footer_copy_rights_section',
            'type' => 'switch',
            'title' => esc_html__('Copy Rights Switch', 'nokri'),
            'subtitle' => esc_html__('Hide/Show Copy Rights', 'nokri'),
            'default' => true,
        ),
        array(
            'required' => array('select_footer_layout', '=', array('3')),
            'id' => 'job_locations_copy_links',
            'type' => 'select',
            'multi' => true,
            'title' => esc_html__('Select desired locations', 'nokri'),
            'data' => 'terms',
            'args' => array(
                'taxonomies' => 'ad_location', 'hide_empty' => false,
            ),
        ),
        /* Subscribe our newsletters */
        array(
            'required' => array('select_footer_layout', '=', array('4')),
            'id' => 'subscribe_text4',
            'type' => 'text',
            'title' => esc_html__('Subscribe news letter', 'nokri'),
            'subtitle' => esc_html__('Section text', 'nokri'),
            'default' => esc_html__('Subscribe our newsletters', 'nokri'),
        ),
        array(
            'required' => array('footer_copy_rights_section', '=', array('1')),
            'id' => 'footer_last_section',
            'type' => 'text',
            'title' => esc_html__('Copy Rights', 'nokri'),
            'subtitle' => esc_html__('Type Your Rights', 'nokri'),
            'default' => esc_html__('All rights reserved. nokri', 'nokri'),
        ),
        array(
            'required' => array('footer_copy_rights_section', '=', array('1')),
            'id' => 'footer_last_name',
            'type' => 'text',
            'title' => esc_html__('Company Name', 'nokri'),
            'subtitle' => esc_html__('Type Your Company Name', 'nokri'),
            'default' => esc_html__('ScriptsBundle', 'nokri'),
        ),
        array(
            'required' => array('footer_copy_rights_section', '=', array('1')),
            'id' => 'footer_last_link',
            'type' => 'text',
            'title' => esc_html__('Company URL', 'nokri'),
            'subtitle' => esc_html__('Put Your Company URL', 'nokri'),
            'default' => 'http://themeforest.net/user/scriptsbundle',
        ),
        array(
            'id' => 'banners_code_footer',
            'type' => 'textarea',
            'title' => __('Custom CSS/Javascript', 'nokri'),
            'subtitle' => __('Paste your style/scripts here ', 'nokri'),
            'default' => '',
        ),
    ),
));
/* * ** Wpml settings Options */
do_action('nokri_wpml_settings_options', $opt_name);
