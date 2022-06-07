<?php
/* ========================= */
/* Nokri Search Widget */
/* ========================= */
global $nokri;

/* Adds search_Widget widget */

if (!class_exists('nokri_search_job')) {

    class nokri_search_job extends WP_Widget {

        /** Register widget with WordPress */
        function __construct() {
            parent::__construct(
                    'nokri_search_job', // Base ID
                    esc_html__('Nokri search by keyword', 'nokri'), // Name
                    array('description' => esc_html__('Show Search Box', 'nokri'),) // Args
            );
        }
        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {

            global $nokri;
            $title = '';
            $in = '';
            $collapsed = 'collapsed';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }

            if (isset($_GET['job-title']) && $_GET['job-title'] != "") {
                $title = $_GET['job-title'];
                $in = 'in';
            }
            ?>				
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab">
                    <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#search-widget">
                        <?php echo nokri_returnEcho($instance['title']); ?>
                    </a>
                </div>
                <div id="search-widget" class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel" >
                    <div class="panel-body">
                        <form role="search" method="get" action = "<?php echo get_the_permalink($nokri['sb_search_page']); ?>">
                            <div class="form-group">
                                <input type="text" class="form-control" value="<?php echo esc_attr($title); ?>" name="job-title" placeholder="<?php echo esc_html__('Search Here', 'nokri') ?>">
                            </div>
                            <div class="form-group form-action">
                                <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                            </div>
                            <?php echo nokri_search_params('job-title'); ?>
                            <?php echo nokri_form_lang_field_callback(true); ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {
            $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
            /* Seting Open Or Not */
            $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'nokri'); ?></label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <!--Open/Close  --->
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
                    esc_attr_e('Set Widget',
                            'nokri');
                    ?>
                </label> 
                <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                    <option value="open" <?php
                    if ($is_open == 'open') {
                        echo "selected";
                    };
                    ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                    <option value="close" <?php
                    if ($is_open == 'close') {
                        echo "selected";
                    };
                    ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
                </select>
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            /* Save open/close */
            $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
            return $instance;
        }

    }

}

// register Foo_Widget widget
function nokri_search_job() {
    register_widget('nokri_search_job');
}

add_action('widgets_init', 'nokri_search_job');

/* ========================= */
/*  Category widget In Search */
/* ========================= */

class nokri_search_categories extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_search_categories', // Base ID
                esc_html__('Nokri Search Categories', 'nokri'), // Name
                array('description' => esc_html__('Show All Job Categories', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {

        /* Make cats selected on update Job */
        if (taxonomy_exists('job_category')) {

            global $nokri;
            $multi_searach = ( isset($nokri['multi_job_search_form']) && $nokri['multi_job_search_form'] != "" ) ? $nokri['multi_job_search_form'] : false;
            $ad_cats = nokri_get_cats('job_category', 0);
            if (count((array) $ad_cats) > 0) {
                $cats_html = '';
                $cats_html .= '<option value="asa">' . esc_html__('Select an option', 'nokri') . '</option>';
                foreach ($ad_cats as $ad_cat) {
                    $selected = '';
                    if (isset($_GET['cat-id']) && $_GET['cat-id'] == $ad_cat->term_id) {
                        $selected = 'selected = "selected"';
                    }
                    $cats_html .= '<option value="' . esc_attr($ad_cat->term_id) . '" ' . $selected . '>' . esc_html($ad_cat->name) . '</option>';
                }
                global $nokri;
                $in = 'collapsed';
                $collapsed = 'collapsed';
                if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                    $in = 'in';
                    $collapsed = '';
                }
                if (isset($_GET['job_cat']) && $_GET['job_cat'] != "") {
                    $in = 'in';
                }
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading active" role="tab" >
                        <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#collapse-job_category">
                            <?php
                            if (!empty($instance['title'])) {
                                echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
                            }
                            ?>
                        </a>
                    </div>
                    <div id="collapse-job_category"  class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel" >
                        <div class="panel-body">
                            <?php
                            if (isset($_GET['cat-id']) && $_GET['cat-id'] != "") {
                                ?>
                                <div class="cat_head"><span><?php echo nokri_get_taxonomy_parents($_GET['cat-id'], 'job_category', false); ?></span></div>
                                <?php
                            }
                            ?>
                            <form method="get" id="search_form" action="<?php echo get_the_permalink($nokri['sb_search_page']); ?>">
                                <div class="cp-loader"></div>
                                <div class="form-group">
                                    <select class="questions-category form-control" data-parsley-required="true" id="make_id">
                                        <?php echo "" . $cats_html; ?>
                                    </select>
                                </div>
                                <div class="form-group" id="select_modal">

                                </div>
                                <div id="select_modals" class="form-group">

                                </div>
                                <div id="select_forth_div" class="margin-top-10">

                                </div>
                                <div class="form-group form-action">
                                </div>
                                <input type="button" class="btn n-btn-flat btn-mid" id="category_search" value="<?php echo esc_html__('Search', 'nokri'); ?>">
                                <input type="hidden" name="cat-id" id="cat_id" value="" />
                                <?php
                                if (!$multi_searach) {
                                    echo nokri_search_params('cat-id');
                                }
                                ?>
                                <?php echo nokri_form_lang_field_callback(true) ?>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        echo nokri_returnEcho($args['after_widget']);
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
                esc_attr_e('Title:',
                        'nokri');
                ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
            echo

            esc_attr($this->get_field_name('title'));
            ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
                esc_attr_e('Set Widget',
                        'nokri');
                ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
                if ($is_open == 'open') {
                    echo "selected";
                };
                ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
                if ($is_open == 'close') {
                    echo "selected";
                };
                ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';

        return $instance;
    }

}

// register nokri Widget widget
function nokri_search_categories() {
    register_widget('nokri_search_categories');
}

add_action('widgets_init', 'nokri_search_categories');

/* ========================= */
/*  Custom search widget */
/* ========================= */

class nokri_custom_search_widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_custom_search_widget', // Base ID
                esc_html__('Custom Search', 'nokri'), // Name
                array('description' => esc_html__('Show Custom Search', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        global $nokri;
        $in = '';
        $collapsed = 'collapsed';
        if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
            $in = 'in';
            $collapsed = '';
        }
        if (isset($_GET['cat-id']) && $_GET['cat-id'] != "") {
            $in = 'in';
        }
        ?>
        <div class="panel panel-default">
            <div class="panel-heading active" role="tab" >
                <a role="button" data-toggle="collapse" href="#collapse-custom_category">
                    <?php
                    if (!empty($instance['title'])) {
                        echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
                    }
                    ?>
                </a>
            </div>
            <div id="collapse-custom_category"  class="panel-collapse collapse <?php echo esc_attr($in); ?> " role="tabpanel" >
                <div class="panel-body">
                    <?php
                    $customHTML = '';
                    require trailingslashit(get_template_directory()) . 'template-parts/custom.php';
                    echo "" . $customHTML;
                    ?>
                </div></div></div>

        <?php
        echo nokri_returnEcho($args['after_widget']);
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
                esc_attr_e('Title:',
                        'nokri');
                ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
            echo

            esc_attr($this->get_field_name('title'));
            ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
                esc_attr_e('Set Widget',
                        'nokri');
                ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
                if ($is_open == 'open') {
                    echo "selected";
                };
                ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
                if ($is_open == 'close') {
                    echo "selected";
                };
                ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';

        return $instance;
    }

}

// register nokri Widget widget
function nokri_custom_search_widget() {
    register_widget('nokri_custom_search_widget');
}

add_action('widgets_init', 'nokri_custom_search_widget');

/* ========================= */
/* Radius Search widget   */
/* ========================= */

class nokri_radius_search extends WP_Widget {

    /** Register widget with WordPress */
    function __construct() {
        parent::__construct(
                'nokri_radius_search', // Base ID
                esc_html__('Nokri Radius Search', 'nokri'), // Name
                array('description' => esc_html__('Compatible only with map search page', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * 
     * 
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {

        global $nokri;
        /* Search page lay out */
        $search_page_layout = ( isset($nokri['search_page_layout']) && $nokri['search_page_layout'] != "" ) ? $nokri['search_page_layout'] : "";
        $title = '';
        $in = '';
        $collapsed = 'collapsed';
        if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
            $in = 'in';
            $collapsed = '';
        }

        if (isset($_GET['job-title']) && $_GET['job-title'] != "") {
            $title = $_GET['job-title'];
            $in = 'in';
        }
        if ($search_page_layout == '3') {
            wp_enqueue_script('google-map-callback', false);
            echo '<script>
			var x=document.getElementById("demo");
			function getLocation()
			{
			if (navigator.geolocation)
			{                      
			navigator.geolocation.getCurrentPosition(showPosition);
                                         
			}
			else{x.innerHTML="Geolocation is not supported by this browser.";}
			}
			function showPosition(position)
			{         
                        
				document.getElementById("radius_lat").value = position.coords.latitude;
				document.getElementById("radius_long").value = position.coords.longitude;  
			}
			getLocation();
                         
                     function nokri_location() {
                     var input = document.getElementById("sb_user_address");
	              var action_on_complete	= "1";
                      var autocomplete = new google.maps.places.Autocomplete(input);
	              new google.maps.event.addListener(autocomplete, "place_changed", function() {
               	  // document.getElementById("sb_loading").style.display	= "block";
                     var place = autocomplete.getPlace();
	             document.getElementById("radius_lat").value = place.geometry.location.lat();
                     document.getElementById("radius_long").value = place.geometry.location.lng();
                    });
                    }
			</script>';
        }
        $distance = '';
        if (isset($_GET['distance'])) {
            $distance = $_GET['distance'];
        }
        $adress = '';
        if (isset($_GET['sb_user_address'])) {
            $adress = $_GET['sb_user_address'];
        }
        ?>				
        <div class="panel panel-default">
            <div class="panel-heading active" role="tab">
                <a role="button" data-toggle="collapse" href="#radius_search" class="<?php echo esc_attr($collapsed); ?>"> 
                    <?php echo nokri_returnEcho($instance['title']); ?>
                </a>
            </div>
            <div id="radius_search" class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel" >
                <div class="panel-body">
                    <form role="search" method="get" action = "<?php echo get_the_permalink($nokri['sb_search_page']); ?>" class="custom-search-form">
                        <div class="form-group">
                            <input type="text" class="form-control" value="<?php echo esc_attr($adress); ?>" name="sb_user_address" id="sb_user_address" placeholder="<?php echo esc_html__('Enter Map Address', 'nokri') ?>">
                            <a href="javascript:void(0);" id="your_current_location_alert" title="<?php echo esc_html__('You Current Location', 'nokri'); ?>"><i class="fa fa-crosshairs"></i></a>
                            <input type="Number" class="form-control" value="<?php echo esc_attr($distance); ?>" name="distance" placeholder="<?php echo esc_html__('Number of miles', 'nokri') ?>">                           
                            <input type="hidden" id="radius_lat"  value="" name="radius_lat">
                            <input type="hidden" id="radius_long"  value="" name="radius_long">
                            <button type="submit" class="btn n-btn-flat btn-mid"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="form-group form-action">
                        </div>
                        <?php
                        // echo nokri_search_params('distance');
                        ?>
                        <?php echo nokri_form_lang_field_callback(true)
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'nokri'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/Close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
                esc_attr_e('Set Widget',
                        'nokri');
                ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
                if ($is_open == 'open') {
                    echo "selected";
                };
                ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
                if ($is_open == 'close') {
                    echo "selected";
                };
                ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        return $instance;
    }

}

// register Foo_Widget widget
function nokri_radius_search() {
    register_widget('nokri_radius_search');
}

add_action('widgets_init', 'nokri_radius_search');



/* ========================= */
/* All In One Taxonomy Widget */
/* ========================= */

// nokri framework is active
if (in_array('nokri_framework/index.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    class nokri_search_widget extends WP_Widget {
        /*  Register widget with WordPress. */

        function __construct() {
            parent::__construct(
                    'nokri_search_widget', // Base ID
                    esc_html__('Nokri All Search Widget', 'nokri'), // Name
                    array('description' => esc_html__('Add All Search Widget', 'nokri'),) // Args
            );
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {

            $taxonomy_list = (!empty($instance['taxonomy_list']) ) ? $instance['taxonomy_list'] : 'job_category';
            global $nokri;
            /* Displaying  Taxonomies Terms On Widet   */

            echo nokri_job_search_taxonomies_checkboxes($taxonomy_list, $instance);
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {
            $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
            /* Select Field */
            $taxonomy_list = !empty($instance['taxonomy_list']) ? $instance['taxonomy_list'] : esc_html__('Select Widget', 'nokri');
            /* Number Of Records */
            $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
            /* Seting Open Or Not */
            $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
                    esc_attr_e('Title:',
                            'nokri');
                    ?></label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
                echo

                esc_attr($this->get_field_name('title'));
                ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <!-- Select Field  --->
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('post_order')); ?>"><?php
                    esc_attr_e('Select Widget',
                            'nokri');
                    ?>
                </label> 
                <select name="<?php echo esc_attr($this->get_field_name('taxonomy_list')); ?>" id="<?php echo esc_attr($this->get_field_id('taxonomy_list')); ?>" class="widefat">
                    <?php
                    /* Getting All Taxonomies Of CPT */
                    $customPostTaxonomies = get_object_taxonomies('job_post', 'object');
                    if (count($customPostTaxonomies) > 0) {
                        foreach ($customPostTaxonomies as $tax) {
                            if ($tax->name == 'sb_dynamic_form_templates') {
                                continue;
                            }
                            $selected = ($taxonomy_list == $tax->name) ? 'selected' : '';

                            echo '<option value="' . esc_html($tax->name) . '" ' . $selected . '>' . esc_html($tax->labels->singular_name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </p>
            <!--Open/Close  --->
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>"><?php
            esc_attr_e('By Default Number of Records:',
                    'nokri');
                    ?></label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>" name="<?php
                    echo

                    esc_attr($this->get_field_name('no_of_records'));
                    ?>" type="number" value="<?php echo esc_attr($no_of_records); ?>">
            </p>
            <!--Number Of Records  --->
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
            esc_attr_e('Set Widget',
                    'nokri');
                    ?>
                </label> 
                <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                    <option value="open" <?php
            if ($is_open == 'open') {
                echo "selected";
            };
                    ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                    <option value="close" <?php
                            if ($is_open == 'close') {
                                echo "selected";
                            };
                            ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
                </select>
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            /* Third Feild */
            $instance['taxonomy_list'] = (!empty($new_instance['taxonomy_list']) ) ? strip_tags($new_instance['taxonomy_list']) : '';
            /* Save Number Of Records */
            $instance['no_of_records'] = (!empty($new_instance['no_of_records']) ) ? strip_tags($new_instance['no_of_records']) : '';
            /* Save open/close */
            $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';

            return $instance;
        }

    }

    // Register  All In One Taxonomy Widget
    function nokri_search_widget() {
        register_widget('nokri_search_widget');
    }

    add_action('widgets_init', 'nokri_search_widget');
}
/* ========================= */
/*  Location widget In Search */
/* ========================= */

class nokri_search_location extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_search_location', // Base ID
                esc_html__('Nokri Custom Locations', 'nokri'), // Name
                array('description' => esc_html__('Show All Job Locations', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        /*  Select Country,  City, State */
        $search_countries = nokri_get_cats('ad_location', 0);

        global $nokri;
        $multi_searach = ( isset($nokri['multi_job_search_form']) && $nokri['multi_job_search_form'] != "" ) ? $nokri['multi_job_search_form'] : false;

        if (count($search_countries) > 0) {
            $cats_html = '';
            $cats_html .= '<option value="0">' . esc_html__('Select an option', 'nokri') . '</option>';
            foreach ($search_countries as $search_country) {
                $selected = '';
                if (isset($_GET['job-location']) && $_GET['job-location'] == $search_country->term_id) {
                    $selected = 'selected = "selected"';
                }
                $cats_html .= '<option value="' . esc_attr($search_country->term_id) . '" ' . $selected . '>' . esc_html($search_country->name) . '</option>';
            }
            global $nokri;
            $in = '';
            $collapsed = 'collapsed';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            if (isset($_GET['location']) && $_GET['location'] != "") {
                $in = 'in';
            }
            /*  for job search/candidate search */
            if (isset($instance['for']) && $instance['for'] == 'job') {
                $form_for = get_the_permalink($nokri['sb_search_page']);
            } else if (isset($instance['for']) && $instance['for'] == 'cand') {
                $form_for = get_the_permalink($nokri['candidates_search_page']);
            } else {
                $form_for = get_the_permalink($nokri['employer_search_page']);
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab" >
                    <a class="<?php echo esc_attr($collapsed); ?>" role="button" data-toggle="collapse" href="#location_search">
                        <?php
                        if (!empty($instance['title'])) {
                            echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
                        }
                        ?>
                    </a>
                </div>
                <div id="location_search"  class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel">
                    <div class="panel-body">
                        <?php
                        if (isset($_GET['job-location']) && $_GET['job-location'] != "") {
                            ?>
                            <div class="cat_head"><span><?php echo nokri_get_taxonomy_parents($_GET['job-location'], 'ad_location', false); ?></span></div>
                            <?php
                        }
                        ?>
                        <form method="get" id="search_form" action="<?php echo "" . ($form_for); ?>">
                            <div class="cp-loader"></div>
                            <div class="form-group">
                                <select class="questions-category form-control" data-parsley-required="true" id="countries_id" >
                                    <?php echo "" . $cats_html; ?>
                                </select>
                            </div>
                            <div class="form-group" id="select_modal_countries"></div>
                            <div id="select_modals_state" class="form-group"></div>
                            <div id="select_forth_div_city" class="margin-top-10"></div>
                            <div class="form-group form-action">
                            </div>
                            <input type="button" class="btn n-btn-flat btn-mid location_search" id="location_search_btn" value="<?php echo esc_html__('Search', 'nokri'); ?>">
                            <input type="hidden" name="job-location" id="location_id" value="" />
                            <?php
                            if (!$multi_searach) {
                                echo nokri_search_params('job-location');
                            }
                            ?>
                            <?php echo nokri_form_lang_field_callback(true); ?>
                        </form>
                    </div>
                </div>
            </div>      
            <?php
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        /* Seting job search/candidate search */
        $for = !empty($instance['for']) ? $instance['for'] : esc_html__('Select Widget for', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
        esc_attr_e('Title:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('title'));
        ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <!--job search/candidate search  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('for')); ?>"><?php
        esc_attr_e('Widget For',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('for')); ?>" id="<?php echo esc_attr($this->get_field_id('for')); ?>" class="widefat">
                <option value="job" <?php
        if ($for == 'job') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Jobs search', 'nokri'); ?></option>
                <option value="cand" <?php
        if ($for == 'cand') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('candidates search', 'nokri'); ?></option> 
                <option value="emp" <?php
        if ($for == 'emp') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Employers search', 'nokri'); ?></option>    				
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        /* job search/candidate search  */
        $instance['for'] = (!empty($new_instance['for']) ) ? strip_tags($new_instance['for']) : '';

        return $instance;
    }

}

// register nokri Widget widget
function nokri_search_location() {
    register_widget('nokri_search_location');
}

add_action('widgets_init', 'nokri_search_location');


/* ========================= */
/* Candidate Title widget In Search */
/* ========================= */

class nokri_search_candidate extends WP_Widget {

    /** Register widget with WordPress */
    function __construct() {
        parent::__construct(
                'nokri_search_candidate', // Base ID
                esc_html__('Candidate Title', 'nokri'), // Name
                array('description' => esc_html__('Get candidate by title', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {

        global $nokri;
        $title = '';
        $in = '';
        $collapsed = 'collapsed';
        if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
            $in = 'in';
            $collapsed = '';
        }
        if (isset($_GET['cand_title']) && $_GET['cand_title'] != "") {
            $title = $_GET['cand_title'];
            $in = 'in';
        }
        ?>				
        <div class="panel panel-default">
            <div class="panel-heading active" role="tab">
                <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#search-widget">
                    <?php echo nokri_returnEcho($instance['title']); ?>
                </a>
            </div>
            <div id="search-widget" class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel" >
                <div class="panel-body">
                    <form role="search" method="get" action = "<?php echo get_the_permalink($nokri['candidates_search_page']); ?>">
                        <div class="form-group">
                            <input type="text"  class="form-control" value="<?php echo esc_html($title); ?>" name="cand_title" placeholder="<?php echo esc_html__('Search Here', 'nokri') ?>" >
                        </div>
                        <div class="form-group form-action">
                            <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                        </div>
                        <?php echo nokri_search_params('cand-title'); ?>
                        <?php echo nokri_form_lang_field_callback(true) ?>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'nokri'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/Close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        return $instance;
    }

}

// register Foo_Widget widget
function nokri_search_candidate() {
    register_widget('nokri_search_candidate');
}

add_action('widgets_init', 'nokri_search_candidate');

/* ========================= */
/* Candidate Headline widget In Search */
/* ========================= */

class nokri_search_candidate_headline extends WP_Widget {

    /** Register widget with WordPress */
    function __construct() {
        parent::__construct(
                'nokri_search_candidate_headline', // Base ID
                esc_html__('Candidate Headline', 'nokri'), // Name
                array('description' => esc_html__('Get candidate by headline', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {

        global $nokri;
        $title = '';
        $in = '';
        $collapsed = 'collapsed';
        if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
            $in = 'in';
            $collapsed = '';
        }
        if (isset($_GET['cand-headline']) && $_GET['cand-headline'] != "") {
            $title = $_GET['cand-headline'];
            $in = 'in';
        }
        ?>				
        <div class="panel panel-default">
            <div class="panel-heading active" role="tab">
                <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#search-headline">
                    <?php echo nokri_returnEcho($instance['title']); ?>
                </a>
            </div>
            <div id="search-headline" class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel" >
                <div class="panel-body">
                    <form role="search" class="custom-search-form" method="get" action = "<?php echo get_the_permalink($nokri['candidates_search_page']); ?>">
                        <div class="form-group">
                            <input type="text"  class="form-control" value="<?php echo esc_html($title); ?>" name="cand-headline" placeholder="<?php echo esc_html__('e.g Developer...', 'nokri') ?>" >
                            <button type="submit" class="btn n-btn-flat btn-mid"><i class="fa fa-search"></i></button>
                        </div>
                        <?php echo nokri_search_params('cand-headline'); ?>
                        <?php echo nokri_form_lang_field_callback(true) ?>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'nokri'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/Close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        return $instance;
    }

}

// register Foo_Widget widget
function nokri_search_candidate_headline() {
    register_widget('nokri_search_candidate_headline');
}

add_action('widgets_init', 'nokri_search_candidate_headline');

/* ========================= */
/*  Candidates Type widget   */
/* ========================= */

class nokri_search_candidate_type extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_search_candidate_type', // Base ID
                esc_html__('Candidate Type', 'nokri'), // Name
                array('description' => esc_html__('Show All candidate type', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        $max_record = $instance['no_of_records'] ? $instance['no_of_records'] : 3;


        /*  Select Country,  City, State */
        $search_types = nokri_get_cats('job_type', 0);
        if (count((array) $search_types) > 0) {
            $type_html = '';
            $count = 1;
            $cls = '';
            $showed = false;
            $cur_cls = 'sb_type';
            $is_run = true;
            foreach ($search_types as $search_type) {
                $selected = '';
                if (isset($_GET['cand_type']) && $_GET['cand_type'] == $search_type->term_id) {
                    $selected = 'checked = "checked"';
                }
                if ($count > $max_record && $is_run) {
                    $cls = 'hide_type hide_li';
                    $showed = true;
                    $is_run = false;
                }
                if ($showed) {
                    $showed = false;
                    $type_html .= '<li class="show-more hide_now_' . esc_attr($cur_cls) . '"><small><a href="javascript:void(0);" class="show_records" data-attr-id="hide_type" data-attr-hide="' . esc_attr($cur_cls) . '">' . __('Show more', 'nokri') . '</a></small></li>';
                }
                $type_html .= '<li class="' . esc_attr($cls) . '"><input class="input-icheck input-icheck-search cand_type_form" ' . esc_attr($selected) . ' value="' . esc_attr($search_type->term_id) . '" type="radio"  name="cand_type"> <label>' . esc_html($search_type->name) . '</label></li>';
                $count++;
            }
            global $nokri;
            $in = 'collapsed';
            $collapsed = '';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            if (isset($_GET['cand_type']) && $_GET['cand_type'] != "") {
                $in = 'in';
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab" >
                    <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#cand_job_type">
                        <?php
                        if (!empty($instance['title'])) {
                            echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
                        }
                        ?>
                    </a>
                </div>
                <div id="cand_job_type"  class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel">
                    <form method="get" id="cand_type_form"  action="<?php echo get_the_permalink($nokri['candidates_search_page']); ?>">
                        <div class="panel-body">
                            <ul class="list">
                                <?php echo "" . ($type_html); ?>
                            </ul>
                        </div>
                        <?php echo nokri_search_params('cand_type'); ?>
                        <?php echo nokri_form_lang_field_callback(true) ?>
                    </form>
                </div>
            </div>     
            <?php
        }
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
        esc_attr_e('Title:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('title'));
        ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <!--Number Of Records  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>"><?php
        esc_attr_e('By Default Number of Records:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('no_of_records'));
        ?>" type="number" value="<?php echo esc_attr($no_of_records); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        /* Save Number Of Records */
        $instance['no_of_records'] = (!empty($new_instance['no_of_records']) ) ? strip_tags($new_instance['no_of_records']) : '';
        return $instance;
    }

}

// register nokri Widget widget
function nokri_search_candidate_type() {
    register_widget('nokri_search_candidate_type');
}

add_action('widgets_init', 'nokri_search_candidate_type');


/* candiate skills * */

class nokri_search_candidate_skills extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_search_candidate_skills', // Base ID
                esc_html__('Search by candidate skills', 'nokri'), // Name
                array('description' => esc_html__('Show candidate by skills', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        /*  Select Country,  City, State */
        $search_types = nokri_get_cats('job_skills', 0);
        if (count((array) $search_types) > 0) {
            $skill_html = '';
            $count = 1;
            $cls = '';
            $showed = false;
            $cur_cls = 'sb_skills';
            $is_run = true;
            foreach ($search_types as $search_type) {
                $selected = '';
                if (isset($_GET['cand_skills']) && $_GET['cand_skills'] == $search_type->term_id) {
                    $selected = 'checked = "checked"';
                }

                if ($count > $no_of_records && $is_run) {
                    $cls = 'hide_skills hide_li';
                    $showed = true;
                    $is_run = false;
                }
                if ($showed) {
                    $showed = false;
                    $skill_html .= '<li class="show-more hide_now_' . esc_attr($cur_cls) . '"><small><a href="javascript:void(0);" class="show_records" data-attr-id="hide_skills" data-attr-hide="' . esc_attr($cur_cls) . '">' . __('Show more', 'nokri') . '</a></small></li>';
                }

                $skill_html .= '<li class="' . esc_attr($cls) . '"><input class="input-icheck input-icheck-search cand_skills_form" ' . esc_attr($selected) . ' value="' . esc_attr($search_type->term_id) . '" type="radio"  name="cand_skills"> <label>' . esc_html($search_type->name) . '</label></li>';
                $count++;
            }
            global $nokri;
            $in = 'collapsed';
            $collapsed = '';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            if (isset($_GET['cand_skills']) && $_GET['cand_skills'] != "") {
                $in = 'in';
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab" >
                    <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#cand_job_skills">
                        <?php echo "" . $instance['title']; ?>
                    </a>
                </div>
                <div id="cand_job_skills"  class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel">
                    <form method="get" id="cand_skills_form"  action="<?php echo get_the_permalink($nokri['candidates_search_page']); ?>">
                        <div class="panel-body">
                            <ul class="list">
                                <?php echo "" . ($skill_html); ?>
                            </ul>
                        </div>
                        <?php echo nokri_search_params('cand_skills'); ?>
                    </form>

                </div>
            </div>     
            <?php
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
        esc_attr_e('Title:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('title'));
        ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <!--Number of records --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>"><?php
        esc_attr_e('By Default Number of Records:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('no_of_records'));
        ?>" type="number" value="<?php echo esc_attr($no_of_records); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        /* Save Number Of Records */
        $instance['no_of_records'] = (!empty($new_instance['no_of_records']) ) ? strip_tags($new_instance['no_of_records']) : '';
        return $instance;
    }

}

// register nokri Widget widget
function nokri_search_candidate_skills() {
    register_widget('nokri_search_candidate_skills');
}

add_action('widgets_init', 'nokri_search_candidate_skills');





/* ========================= */
/*  Candidates Level widget   */
/* ========================= */

class nokri_search_candidate_level extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_search_candidate_level', // Base ID
                esc_html__('Candidate Level', 'nokri'), // Name
                array('description' => esc_html__('Show candidates by level', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        /*  Select Country,  City, State */
        $search_types = nokri_get_cats('job_level', 0);
        if (count((array) $search_types) > 0) {
            $type_html = '';
            $count = 1;
            $showed = false;
            $cls = '';
            $cur_cls = 'sb_level';
            $is_run = true;
            foreach ($search_types as $search_type) {
                $selected = '';
                if (isset($_GET['cand_level']) && $_GET['cand_level'] == $search_type->term_id) {
                    $selected = 'checked = "checked"';
                }
                if ($count > $no_of_records && $is_run) {
                    $cls = 'hide_level hide_li';
                    $showed = true;
                    $is_run = false;
                }
                if ($showed) {
                    $showed = false;
                    $type_html .= '<li class="show-more hide_now_' . esc_attr($cur_cls) . '"><small><a href="javascript:void(0);" class="show_records" data-attr-id="hide_level" data-attr-hide="' . esc_attr($cur_cls) . '">' . __('Show more', 'nokri') . '</a></small></li>';
                }


                $type_html .= '<li class="' . esc_attr($cls) . '"><input class="input-icheck input-icheck-search cand_level_form" ' . esc_attr($selected) . ' value="' . esc_attr($search_type->term_id) . '" type="radio"  name="cand_level"> <label>' . esc_html($search_type->name) . '</label></li>';
                $count++;
            }
            global $nokri;
            $in = 'collapsed';
            $collapsed = '';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            if (isset($_GET['cand_level']) && $_GET['cand_level'] != "") {
                $in = 'in';
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab" >
                    <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#cand_job_level">
                        <?php
                        if (!empty($instance['title'])) {
                            echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
                        }
                        ?>
                    </a>
                </div>
                <div id="cand_job_level" class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel">
                    <form method="get" id="cand_level_form" class="search_candidates_form" action="<?php echo get_the_permalink($nokri['candidates_search_page']); ?>">
                        <div class="panel-body">
                            <ul class="list">
                                <?php echo "" . ($type_html); ?>
                            </ul>
                        </div>
                        <?php echo nokri_search_params('cand_level'); ?>
                        <?php echo nokri_form_lang_field_callback(true) ?>
                    </form>

                </div>
            </div>     
            <?php
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
        esc_attr_e('Title:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('title'));
        ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <!-- Number of records  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>"><?php
        esc_attr_e('By Default Number of Records:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('no_of_records'));
        ?>" type="number" value="<?php echo esc_attr($no_of_records); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        /* Save Number Of Records */
        $instance['no_of_records'] = (!empty($new_instance['no_of_records']) ) ? strip_tags($new_instance['no_of_records']) : '';
        return $instance;
    }

}

// register nokri Widget widget
function nokri_search_candidate_level() {
    register_widget('nokri_search_candidate_level');
}

add_action('widgets_init', 'nokri_search_candidate_level');

/* ========================= */
/*  Candidates Experience widget   */
/* ========================= */

class nokri_search_candidate_experience extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_search_candidate_experience', // Base ID
                esc_html__('Candidate Experience', 'nokri'), // Name
                array('description' => esc_html__('Show candidates by experience', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        /*  Select Country,  City, State */
        $search_types = nokri_get_cats('job_experience', 0);
        if (count((array) $search_types) > 0) {
            $type_html = '';
            $count = 1;
            $showed = false;
            $cls = '';
            $cur_cls = 'sb_experience';
            $is_run = true;
            foreach ($search_types as $search_type) {
                $selected = '';
                if (isset($_GET['cand_experience']) && $_GET['cand_experience'] == $search_type->term_id) {
                    $selected = 'checked = "checked"';
                }
                if ($count > $no_of_records && $is_run) {
                    $cls = 'hide_experience hide_li';
                    $showed = true;
                    $is_run = false;
                }
                if ($showed) {
                    $showed = false;
                    $type_html .= '<li class="show-more show-more hide_now_' . esc_attr($cur_cls) . '"><small><a href="javascript:void(0);" class="show_records" data-attr-id="hide_experience" data-attr-hide="' . esc_attr($cur_cls) . '">' . __('Show more', 'nokri') . '</a></small></li>';
                }


                $type_html .= '<li class="' . esc_attr($cls) . '"><input class="input-icheck input-icheck-search cand_experience_form" ' . esc_attr($selected) . ' value="' . esc_attr($search_type->term_id) . '" type="radio"  name="cand_experience"> <label>' . esc_html($search_type->name) . '</label></li>';
                $count++;
            }
            global $nokri;
            $in = 'collapsed';
            $collapsed = '';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            if (isset($_GET['cand_experience']) && $_GET['cand_experience'] != "") {
                $in = 'in';
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab" >
                    <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#cand_job_experience">
                        <?php
                        if (!empty($instance['title'])) {
                            echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
                        }
                        ?>
                    </a>
                </div>
                <div id="cand_job_experience" class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel">
                    <form method="get" id="cand_experience_form" class="search_candidates_form" action="<?php echo get_the_permalink($nokri['candidates_search_page']); ?>">
                        <div class="panel-body">
                            <ul class="list">
                                <?php echo "" . ($type_html); ?>
                            </ul>
                        </div>
                        <?php echo nokri_search_params('cand_experience'); ?>
                        <?php echo nokri_form_lang_field_callback(true) ?>
                    </form>

                </div>
            </div>     
            <?php
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
        esc_attr_e('Title:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('title'));
        ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <!-- Number of records  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>"><?php
        esc_attr_e('By Default Number of Records:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('no_of_records'));
        ?>" type="number" value="<?php echo esc_attr($no_of_records); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        /* Save Number Of Records */
        $instance['no_of_records'] = (!empty($new_instance['no_of_records']) ) ? strip_tags($new_instance['no_of_records']) : '';
        return $instance;
    }

}

// register nokri Widget widget
function nokri_search_candidate_experience() {
    register_widget('nokri_search_candidate_experience');
}

add_action('widgets_init', 'nokri_search_candidate_experience');

/* ========================= */
/*  Candidates Qualification widget   */
/* ========================= */

class nokri_search_candidate_qualification extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_search_candidate_qualification', // Base ID
                esc_html__('Candidate Qualifications', 'nokri'), // Name
                array('description' => esc_html__('Show candidates by qualification', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        /*  Select Country,  City, State */
        $search_types = nokri_get_cats('job_qualifications', 0);
        if (count((array) $search_types) > 0) {
            $type_html = '';
            $count = 1;
            $showed = false;
            $cls = '';
            $cur_cls = 'sb_qualifications';
            $is_run = true;
            foreach ($search_types as $search_type) {
                $selected = '';
                if (isset($_GET['cand-qualification']) && $_GET['cand-qualification'] == $search_type->term_id) {
                    $selected = 'checked = "checked"';
                }
                if ($count > $no_of_records && $is_run) {
                    $cls = 'hide_qualification hide_li';
                    $showed = true;
                    $is_run = false;
                }
                if ($showed) {
                    $showed = false;
                    $type_html .= '<li class="show-more show-more hide_now_' . esc_attr($cur_cls) . '"><small><a href="javascript:void(0);" class="show_records" data-attr-id="hide_qualification" data-attr-hide="' . esc_attr($cur_cls) . '">' . __('Show more', 'nokri') . '</a></small></li>';
                }


                $type_html .= '<li class="' . esc_attr($cls) . '"><input class="input-icheck input-icheck-search cand_experience_form" ' . esc_attr($selected) . ' value="' . esc_attr($search_type->term_id) . '" type="radio"  name="cand-qualification"> <label>' . esc_html($search_type->name) . '</label></li>';
                $count++;
            }
            global $nokri;
            $in = '';
            $collapsed = 'collapsed';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            if (isset($_GET['cand-qualification']) && $_GET['cand-qualification'] != "") {
                $in = 'in';
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab" >
                    <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#cand_job_qualification">
                        <?php
                        if (!empty($instance['title'])) {
                            echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
                        }
                        ?>
                    </a>
                </div>
                <div id="cand_job_qualification" class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel">
                    <form method="get" id="cand_quali_form" class="search_candidates_form" action="<?php echo get_the_permalink($nokri['candidates_search_page']); ?>">
                        <div class="panel-body">
                            <ul class="list">
                                <?php echo "" . ($type_html); ?>
                            </ul>
                        </div>
                        <?php echo nokri_search_params('cand-qualification'); ?>
                        <?php echo nokri_form_lang_field_callback(true) ?>
                    </form>
                </div>
            </div>     
            <?php
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
        esc_attr_e('Title:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('title'));
        ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <!-- Number of records  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>"><?php
        esc_attr_e('By Default Number of Records:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('no_of_records'));
        ?>" type="number" value="<?php echo esc_attr($no_of_records); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        /* Save Number Of Records */
        $instance['no_of_records'] = (!empty($new_instance['no_of_records']) ) ? strip_tags($new_instance['no_of_records']) : '';
        return $instance;
    }

}

// register nokri Widget widget
function nokri_search_candidate_qualification() {
    register_widget('nokri_search_candidate_qualification');
}

add_action('widgets_init', 'nokri_search_candidate_qualification');


/* ========================= */
/*  Candidates Gender widget   */
/* ========================= */

class nokri_search_candidate_gender extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_search_candidate_gender', // Base ID
                esc_html__('Candidate Gender', 'nokri'), // Name
                array('description' => esc_html__('Show candidates by gender', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        /* Gender values array */
        $search_types = array('male' => esc_html__('Male', 'nokri'), 'female' => esc_html__('Female', 'nokri'), 'other' => esc_html__('Other', 'nokri'));
        if (count((array) $search_types) > 0) {
            $type_html = '';
            $count = 1;
            $showed = false;
            $cls = '';
            $cur_cls = 'sb_gender';
            $is_run = true;
            foreach ($search_types as $key => $value) {
                $selected = '';
                if (isset($_GET['cand-gender']) && $_GET['cand-gender'] == $key) {
                    $selected = 'checked = "checked"';
                }
                if ($count > $no_of_records && $is_run) {
                    $cls = 'hide_gender hide_li';
                    $showed = true;
                    $is_run = false;
                }
                if ($showed) {
                    $showed = false;
                    $type_html .= '<li class="show-more show-more hide_now_' . esc_attr($cur_cls) . '"><small><a href="javascript:void(0);" class="show_records" data-attr-id="hide_experience" data-attr-hide="' . esc_attr($cur_cls) . '">' . __('Show more', 'nokri') . '</a></small></li>';
                }


                $type_html .= '<li class="' . esc_attr($cls) . '"><input class="input-icheck input-icheck-search cand_experience_form" ' . esc_attr($selected) . ' value="' . esc_attr($key) . '" type="radio"  name="cand-gender"> <label>' . esc_html($value) . '</label></li>';
                $count++;
            }
            global $nokri;
            $in = '';
            $collapsed = 'collapsed';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            if (isset($_GET['cand-gender']) && $_GET['cand-gender'] != "") {
                $in = 'in';
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab" >
                    <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#cand_gender">
                        <?php
                        if (!empty($instance['title'])) {
                            echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
                        }
                        ?>
                    </a>
                </div>
                <div id="cand_gender" class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel">
                    <form method="get" id="cand_experience_form" class="search_candidates_form" action="<?php echo get_the_permalink($nokri['candidates_search_page']); ?>">
                        <div class="panel-body">
                            <ul class="list">
                                <?php echo "" . ($type_html); ?>
                            </ul>
                        </div>
                        <?php echo nokri_search_params('cand-gender'); ?>
                        <?php echo nokri_form_lang_field_callback(true) ?>
                    </form>
                </div>
            </div>     
            <?php
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
        esc_attr_e('Title:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('title'));
        ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <!-- Number of records  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>"><?php
        esc_attr_e('By Default Number of Records:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('no_of_records'));
        ?>" type="number" value="<?php echo esc_attr($no_of_records); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        /* Save Number Of Records */
        $instance['no_of_records'] = (!empty($new_instance['no_of_records']) ) ? strip_tags($new_instance['no_of_records']) : '';
        return $instance;
    }

}

// register nokri Widget widget
function nokri_search_candidate_gender() {
    register_widget('nokri_search_candidate_gender');
}

add_action('widgets_init', 'nokri_search_candidate_gender');




/* ========================= */
/*  Candidates Salary Widget  */
/* ========================= */

class nokri_search_candidate_salary1 extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_search_candidate_salary1', // Base ID
                esc_html__('Candidate Salary Range', 'nokri'), // Name
                array('description' => esc_html__('Show candidate by salary', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        /*  Select Country,  City, State */
        $salary_html = '';
        $search_types = nokri_get_cats('job_salary', 0);
        if (count((array) $search_types) > 0) {
            $salary_html = '';
            $count = 1;
            $cls = '';
            $showed = false;
            $cur_cls = 'sb_salary';
            $is_run = true;
            foreach ($search_types as $search_type) {
                $selected = '';
                if (isset($_GET['cand-salary']) && $_GET['cand-salary'] == $search_type->term_id) {
                    $selected = 'checked = "checked"';
                }

                if ($count > $no_of_records && $is_run) {
                    $cls = 'hide_salary hide_li';
                    $showed = true;
                    $is_run = false;
                }
                if ($showed) {
                    $showed = false;
                    $salary_html .= '<li class="show-more hide_now_' . esc_attr($cur_cls) . '"><small><a href="javascript:void(0);" class="show_records" data-attr-id="hide_salary" data-attr-hide="' . esc_attr($cur_cls) . '">' . __('Show more', 'nokri') . '</a></small></li>';
                }

                $salary_html .= '<li class="' . esc_attr($cls) . '"><input class="input-icheck input-icheck-search cand_salary_form" ' . esc_attr($selected) . ' value="' . esc_attr($search_type->term_id) . '" type="radio"  name="cand-salary"> <label>' . esc_html($search_type->name) . '</label></li>';
                $count++;
            }
            global $nokri;
            $in = '';
            $collapsed = 'collapsed';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            if (isset($_GET['cand-salary']) && $_GET['cand-salary'] != "") {
                $in = 'in';
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab" >
                    <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#cand_job_salary">
                        <?php
                        if (!empty($instance['title'])) {
                            echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
                        }
                        ?>
                    </a>
                </div>
                <div id="cand_job_salary"  class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel">
                    <form method="get" id="cand_job_salary"  action="<?php echo get_the_permalink($nokri['candidates_search_page']); ?>">
                        <div class="panel-body">
                            <ul class="list">
                                <?php echo "" . ($salary_html); ?>
                            </ul>
                        </div>
                        <?php echo nokri_search_params('cand-salary'); ?>
                        <?php echo nokri_form_lang_field_callback(true) ?>
                    </form>
                </div>
            </div>     
            <?php
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
        esc_attr_e('Title:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('title'));
        ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <!--Number of records --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>"><?php
        esc_attr_e('By Default Number of Records:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('no_of_records'));
        ?>" type="number" value="<?php echo esc_attr($no_of_records); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        /* Save Number Of Records */
        $instance['no_of_records'] = (!empty($new_instance['no_of_records']) ) ? strip_tags($new_instance['no_of_records']) : '';
        return $instance;
    }

}

// register nokri Widget widget
function nokri_search_candidate_salary1() {
    register_widget('nokri_search_candidate_salary1');
}

add_action('widgets_init', 'nokri_search_candidate_salary1');

/* ========================= */
/*  Candidates Salary Type Widget  */
/* ========================= */

class nokri_search_candidate_salary_type extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_search_candidate_salary_type', // Base ID
                esc_html__('Candidate Salary Type', 'nokri'), // Name
                array('description' => esc_html__('Show candidate by salary', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        /*  Select Country,  City, State */
        $salary_html = '';
        $salary_type_html = '';
        $search_types = nokri_get_cats('job_salary_type', 0);
        if (count((array) $search_types) > 0) {
            $salary_type_html = '';
            $count = 1;
            $cls = '';
            $showed = false;
            $cur_cls = 'sb_salary_type';
            $is_run = true;
            foreach ($search_types as $search_type) {
                $selected = '';
                if (isset($_GET['cand-salary-type']) && $_GET['cand-salary-type'] == $search_type->term_id) {
                    $selected = 'checked = "checked"';
                }

                if ($count > $no_of_records && $is_run) {
                    $cls = 'hide_salary_type hide_li';
                    $showed = true;
                    $is_run = false;
                }
                if ($showed) {
                    $showed = false;
                    $salary_html .= '<li class="show-more hide_now_' . esc_attr($cur_cls) . '"><small><a href="javascript:void(0);" class="show_records" data-attr-id="hide_salary_type" data-attr-hide="' . esc_attr($cur_cls) . '">' . __('Show more', 'nokri') . '</a></small></li>';
                }

                $salary_html .= '<li class="' . esc_attr($cls) . '"><input class="input-icheck input-icheck-search cand_salary_form" ' . esc_attr($selected) . ' value="' . esc_attr($search_type->term_id) . '" type="radio"  name="cand-salary-type"> <label>' . esc_html($search_type->name) . '</label></li>';
                $count++;
            }
            global $nokri;
            $in = '';
            $collapsed = 'collapsed';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            if (isset($_GET['cand-salary']) && $_GET['cand-salary'] != "") {
                $in = 'in';
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab" >
                    <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#cand_job_salary_type">
                        <?php
                        if (!empty($instance['title'])) {
                            echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
                        }
                        ?>
                    </a>
                </div>
                <div id="cand_job_salary_type"  class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel">
                    <form method="get" id="cand_job_salary_type"  action="<?php echo get_the_permalink($nokri['candidates_search_page']); ?>">
                        <div class="panel-body">
                            <ul class="list">
                                <?php echo "" . ($salary_html); ?>
                            </ul>
                        </div>
                        <?php echo nokri_search_params('cand-salary-type'); ?>
                        <?php echo nokri_form_lang_field_callback(true) ?>
                    </form>
                </div>
            </div>     
            <?php
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
        esc_attr_e('Title:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('title'));
        ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <!--Number of records --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>"><?php
        esc_attr_e('By Default Number of Records:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('no_of_records'));
        ?>" type="number" value="<?php echo esc_attr($no_of_records); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        /* Save Number Of Records */
        $instance['no_of_records'] = (!empty($new_instance['no_of_records']) ) ? strip_tags($new_instance['no_of_records']) : '';
        return $instance;
    }

}

// register nokri Widget widget
function nokri_search_candidate_salary_type() {
    register_widget('nokri_search_candidate_salary_type');
}

add_action('widgets_init', 'nokri_search_candidate_salary_type');

/* ========================= */
/*  Candidates Salary Currency Widget  */
/* ========================= */

class nokri_search_candidate_salary_currency extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_search_candidate_salary_currency', // Base ID
                esc_html__('Candidate Salary Currency', 'nokri'), // Name
                array('description' => esc_html__('Show candidate by salary currency', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        /*  Currency Values */
        $salary_html = '';
        $search_types = nokri_get_cats('job_currency', 0);
        if (count((array) $search_types) > 0) {
            $salary_type_html = '';
            $count = 1;
            $cls = '';
            $showed = false;
            $cur_cls = 'sb_salary_currency';
            $is_run = true;
            foreach ($search_types as $search_type) {
                $selected = '';
                if (isset($_GET['cand-salary-currency']) && $_GET['cand-salary-currency'] == $search_type->term_id) {
                    $selected = 'checked = "checked"';
                }

                if ($count > $no_of_records && $is_run) {
                    $cls = 'hide_salary_currency hide_li';
                    $showed = true;
                    $is_run = false;
                }
                if ($showed) {
                    $showed = false;
                    $salary_html .= '<li class="show-more hide_now_' . esc_attr($cur_cls) . '"><small><a href="javascript:void(0);" class="show_records" data-attr-id="hide_salary_currency" data-attr-hide="' . esc_attr($cur_cls) . '">' . __('Show more', 'nokri') . '</a></small></li>';
                }

                $salary_html .= '<li class="' . esc_attr($cls) . '"><input class="input-icheck input-icheck-search cand_salary_form" ' . esc_attr($selected) . ' value="' . esc_attr($search_type->term_id) . '" type="radio"  name="cand-salary-currency"> <label>' . esc_html($search_type->name) . '</label></li>';
                $count++;
            }
            global $nokri;
            $in = '';
            $collapsed = 'collapsed';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            if (isset($_GET['cand-salary-currency']) && $_GET['cand-salary-currency'] != "") {
                $in = 'in';
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab" >
                    <a role="button" class="<?php echo esc_attr($collapsed); ?>" data-toggle="collapse" href="#cand_job_salary_currency">
                        <?php
                        if (!empty($instance['title'])) {
                            echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
                        }
                        ?>
                    </a>
                </div>
                <div id="cand_job_salary_currency"  class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel">
                    <form method="get" id="cand_salary_form"  action="<?php echo get_the_permalink($nokri['candidates_search_page']); ?>">
                        <div class="panel-body">
                            <ul class="list">
                                <?php echo "" . ($salary_html); ?>
                            </ul>
                        </div>
                        <?php echo nokri_search_params('cand-salary-currency'); ?>
                        <?php echo nokri_form_lang_field_callback(true) ?>
                    </form>
                </div>
            </div>     
            <?php
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
        esc_attr_e('Title:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('title'));
        ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <!--Number of records --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>"><?php
        esc_attr_e('By Default Number of Records:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('no_of_records'));
        ?>" type="number" value="<?php echo esc_attr($no_of_records); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        /* Save Number Of Records */
        $instance['no_of_records'] = (!empty($new_instance['no_of_records']) ) ? strip_tags($new_instance['no_of_records']) : '';
        return $instance;
    }

}

// register nokri Widget widget
function nokri_search_candidate_salary_currency() {
    register_widget('nokri_search_candidate_salary_currency');
}

add_action('widgets_init', 'nokri_search_candidate_salary_currency');




/* ========================= */
/*  Employer skill widget  */
/* ========================= */

class nokri_search_employer_skills extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_search_employer_skills', // Base ID
                esc_html__('Employer Specialization', 'nokri'), // Name
                array('description' => esc_html__('Show employer by specialization', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        /*  Select Country,  City, State */
        $search_types = nokri_get_cats('emp_specialization', 0);
        if (count((array) $search_types) > 0) {
            $skill_html = '';
            $count = 1;
            $cls = '';
            $showed = false;
            $cur_cls = 'sb_skills';
            $is_run = true;
            foreach ($search_types as $search_type) {
                $selected = '';
                if (isset($_GET['emp_skills']) && $_GET['emp_skills'] == $search_type->term_id) {
                    $selected = 'checked = "checked"';
                }

                if ($count > $no_of_records && $is_run) {
                    $cls = 'hide_skills hide_li';
                    $showed = true;
                    $is_run = false;
                }
                if ($showed) {
                    $showed = false;
                    $skill_html .= '<li class="show-more hide_now_' . esc_attr($cur_cls) . '"><small><a href="javascript:void(0);" class="show_records" data-attr-id="hide_skills" data-attr-hide="' . esc_attr($cur_cls) . '">' . __('Show more', 'nokri') . '</a></small></li>';
                }

                $skill_html .= '<li class="' . esc_attr($cls) . '"><input class="input-icheck input-icheck-search cand_skills_form" ' . esc_attr($selected) . ' value="' . esc_attr($search_type->term_id) . '" type="radio"  name="emp_skills"> <label>' . esc_html($search_type->name) . '</label></li>';
                $count++;
            }
            global $nokri;
            $in = '';
            $collapsed = 'collapsed';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            if (isset($_GET['emp_skills']) && $_GET['emp_skills'] != "") {
                $in = 'in';
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab" >
                    <a role="button" data-toggle="collapse" href="#emp_job_skills">
                        <?php
                        if (!empty($instance['title'])) {
                            echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
                        }
                        ?>
                    </a>
                </div>
                <div id="emp_job_skills"  class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel">
                    <form method="get" id="emp_job_skills"  action="<?php echo get_the_permalink($nokri['employer_search_page']); ?>">
                        <div class="panel-body">
                            <ul class="list">
                                <?php echo "" . ($skill_html); ?>
                            </ul>
                        </div>
                        <?php echo nokri_search_params('emp_skills'); ?>
                        <?php echo nokri_form_lang_field_callback(true) ?>
                    </form>
                </div>
            </div>     
            <?php
        }
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        /* Number Of Records */
        $no_of_records = !empty($instance['no_of_records']) ? $instance['no_of_records'] : esc_html__('Select Number', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php
        esc_attr_e('Title:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('title'));
        ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <!--Number of records --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>"><?php
        esc_attr_e('By Default Number of Records:',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_records')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('no_of_records'));
        ?>" type="number" value="<?php echo esc_attr($no_of_records); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        /* Save Number Of Records */
        $instance['no_of_records'] = (!empty($new_instance['no_of_records']) ) ? strip_tags($new_instance['no_of_records']) : '';
        return $instance;
    }

}

// register nokri Widget widget
function nokri_search_employer_skills() {
    register_widget('nokri_search_employer_skills');
}

add_action('widgets_init', 'nokri_search_employer_skills');

/* ========================= */
/*  blog search widget  */
/* ========================= */

/* Adds search_Widget widget */

class nokri_search_blogs extends WP_Widget {

    /** Register widget with WordPress */
    function __construct() {
        parent::__construct(
                'nokri_search', // Base ID
                esc_html__('blog posts Search', 'nokri'), // Name
                array('description' => esc_html__('Show Search Box', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.rss
     */
    public function widget($args, $instance) {
        echo nokri_returnEcho($args['before_widget']);
        if (!empty($instance['title'])) {
            echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
        }
        ?>
        <div class="search-blog">
            <form role="search" method="get" id="search-form" action="<?php echo home_url('/'); ?>">
                <div class="input-group stylish-input-group">
                    <input  class="form-control" type="text"  value="<?php the_search_query(); ?>" name="s" id="s" placeholder="<?php echo esc_html__('Search here', 'nokri'); ?>" >
                    <span class="input-group-addon">
                        <button type="submit" id="search-submit"> <span class="fa fa-search"></span> </button>
                    </span> 
                </div>
                <?php echo nokri_form_lang_field_callback(true) ?>
            </form> 
        </div>   

        <?php
        echo '' . ( $args['after_widget'] );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'nokri'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

}

// register Foo_Widget widget
function nokri_search_blogs() {
    register_widget('nokri_search_blogs');
}

add_action('widgets_init', 'nokri_search_blogs');

/* ========================= */
/*  Add recent Posts widget */
/* ========================= */

class nokri_popular_posts extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_popular_posts', // Base ID
                esc_html__('Recent Blog posts ', 'nokri'), // Name
                array('description' => esc_html__('Show Your Blog Posts ', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        echo nokri_returnEcho($args['before_widget']);
        if (!empty($instance['title'])) {
            echo nokri_returnEcho($args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']);
        }
        ?>
        <ul class="related-post">
            <?php
            $limits_pops = (!empty($instance['limits_pops']) ) ? $instance['limits_pops'] : '5';
            $popularpost = new WP_Query(array(
                'posts_per_page' => $limits_pops,
                'order' => 'DESC'
            ));

            while ($popularpost->have_posts()) : $popularpost->the_post();
                $pid = get_the_ID();
                ?>
                <li> 		<?php if (has_post_thumbnail()) { ?>
                        <div class="recent-ads-list-image">
                            <a href="<?php esc_url(the_permalink($pid)); ?>" class="recent-ads-list-image-inner"><?php the_post_thumbnail('nokri_thumb_100', array('class' => 'img-responsive')); ?></a>
                        </div>
                    <?php } ?>
                    <div class="recent-ads-list-content">
                        <a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 7, '...'); ?></a>
                        <span><i class="fa fa-calendar"></i><?php the_time(get_option('date_format')); ?> </span>
                    </div>
                </li>
                <?php
            endwhile;
            wp_reset_query();
            ?>
        </ul>
        <?php
        echo nokri_returnEcho($args['after_widget']);
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Second Field */
        $limits_pops = !empty($instance['limits_pops']) ? $instance['limits_pops'] : esc_html__('Post No', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'nokri'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!-- Second Field  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('limits_pops')); ?>"><?php
        esc_attr_e('No Of Posts ',
                'nokri');
        ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('limits_pops')); ?>" name="<?php
        echo

        esc_attr($this->get_field_name('limits_pops'));
        ?>" type="number" value="<?php echo esc_attr($limits_pops); ?>">
        </p>
        <p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            /* Second Feild */
            $instance['limits_pops'] = (!empty($new_instance['limits_pops']) ) ? strip_tags($new_instance['limits_pops']) : '';

            return $instance;
        }

    }

// register Popular Posts widget
    function nokri_popular_posts() {
        register_widget('nokri_popular_posts');
    }

    add_action('widgets_init', 'nokri_popular_posts');

    /* ========================= */
    /* Employer Title widget In Search */
    /* ========================= */

    class nokri_search_employer extends WP_Widget {

        /** Register widget with WordPress */
        function __construct() {
            parent::__construct(
                    'nokri_search_employer', // Base ID
                    esc_html__('Employer Title', 'nokri'), // Name
                    array('description' => esc_html__('Get employer by title', 'nokri'),) // Args
            );
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {

            global $nokri;
            $title = '';
            $in = '';
            $collapsed = 'collapsed';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            if (isset($_GET['emp_title']) && $_GET['emp_title'] != "") {
                $title = $_GET['emp_title'];
                $in = 'in';
            }
            ?>				
        <div class="panel panel-default">
            <div class="panel-heading active" role="tab">
                <a role="button" data-toggle="collapse" href="#search-widget">
                    <?php echo nokri_returnEcho($instance['title']); ?>
                </a>
            </div>
            <div id="search-widget" class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel" >
                <div class="panel-body">
                    <form role="search" method="get" action = "<?php echo get_the_permalink($nokri['employer_search_page']); ?>">
                        <div class="form-group">
                            <input type="text"  class="form-control" value="<?php echo esc_html($title); ?>" name="emp_title" placeholder="<?php echo esc_html__('Search Here', 'nokri') ?>" >
                        </div>
                        <div class="form-group form-action">
                            <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                        </div>
                        <?php echo nokri_search_params('emp_title'); ?>
                        <?php echo nokri_form_lang_field_callback(true) ?>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'nokri'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/Close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        return $instance;
    }

}

// register Foo_Widget widget
function nokri_search_employer() {
    register_widget('nokri_search_employer');
}

add_action('widgets_init', 'nokri_search_employer');


/* ========================================= */
/* Employer Advertisement widget In Search */
/* ======================================= */

if (!class_exists('Advertisementwidget_Widget')) {

    class Advertisementwidget_Widget extends WP_Widget {

        function __construct() {
            parent::__construct(
                    'advertisementwidget_widget', // Base ID
                    esc_html__('Advertisement Widget', 'nokri'),
                    array('description' => esc_html__('Get Advertisement Widget', 'nokri'),) // Args
            );
        }

        public function widget($args, $instance) {
            echo '' . $args['before_widget'];
            global $nokri;
            $in = '';
            $collapsed = 'collapsed';
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            ?>				
            <div class="panel panel-default">
                <div class="panel-heading active" role="tab">
                    <a role="button" data-toggle="collapse" href="#advertisment-widget">
                        <?php echo nokri_returnEcho($instance['title']); ?>
                    </a>
                </div>
                <div id="advertisment-widget" class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel" >
                    <div class="panel-body">
                        <?php echo "" . ($instance['source_img'] ); ?>
                    </div>
                </div>
            </div>
            <?php
            // Output generated fields

            echo '' . $args['after_widget'];
        }

        public function form($instance) {
            $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
            /* Source image */
            $source_img = !empty($instance['source_img']) ? $instance['source_img'] : '';
            /* Seting Open Or Not */
            $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'nokri'); ?></label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <!--Source image --->
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('source_img')); ?>"><?php esc_attr_e('Paste source:', 'nokri'); ?></label> 	<textarea rows="4" cols="50"  id="<?php echo esc_attr($this->get_field_id('source_img')); ?>" name="<?php echo esc_attr($this->get_field_name('source_img')); ?>"><?php echo esc_attr($source_img); ?></textarea>
            </p>
            <!--Open/Close  --->
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
            esc_attr_e('Set Widget',
                    'nokri');
            ?>
                </label> 
                <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                    <option value="open" <?php
            if ($is_open == 'open') {
                echo "selected";
            };
            ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                    <option value="close" <?php
            if ($is_open == 'close') {
                echo "selected";
            };
            ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
                </select>
            </p>
            <?php
        }

        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';

            /* Save Source image */
            $instance['source_img'] = (!empty($new_instance['source_img']) ) ? ( $new_instance['source_img'] ) : '';
            /* Save open/close */
            $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
            return $instance;
        }

    }

}

function register_advertisementwidget_widget() {
    register_widget('Advertisementwidget_Widget');
}

add_action('widgets_init', 'register_advertisementwidget_widget');


add_action('widgets_init', function() {
    register_widget('nokri_listing_blog_posts');
});
if (!class_exists('nokri_listing_blog_posts')) {

    class nokri_listing_blog_posts extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {
            // Instantiate the parent object
            parent::__construct(false, 'Nokri Recent Blog Posts');
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {
            global $post;
            if ($instance['nokri_listing_post_no'] == "") {
                $instance['nokri_listing_post_no'] = 5;
            }
            $args = array('post_type' => 'post', 'posts_per_page' => $instance['nokri_listing_post_no'], 'orderby' => 'date', 'order' => 'DESC');
            $recent_posts = get_posts($args);
            ?>
            <div class="widget">
                <div class="widget-heading">
                    <h4 class="panel-title"><?php echo esc_html($instance['title']); ?></h4>
                </div>
                <div class="recent-ads">
                    <?php foreach ($recent_posts as $recent_post): ?>
                        <div class="recent-ads-list">
                            <div class="recent-ads-container">
                                <?php
                                if (has_post_thumbnail($recent_post->ID)):
                                    $get_img_src = '';
                                    $get_img_src = nokri_get_feature_image($recent_post->ID, 'nokri_blog_recent_post');
                                    ?>
                                    <div class="recent-ads-list-image">
                                        <a href="#" class="recent-ads-list-image-inner">
                                            <img src="<?php echo esc_url($get_img_src[0]); ?>" alt="<?php echo "" . ( get_the_title($recent_post->ID) ); ?>">
                                        </a>
                                    </div>
                                <?php endif; ?>	   
                                <div class="recent-ads-list-content">
                                    <h3 class="recent-ads-list-title">
                                        <a href="<?php echo esc_url(get_the_permalink($recent_post->ID)); ?>"><?php echo esc_html(get_the_title($recent_post->ID)); ?></a>
                                    </h3>
                                    <ul class="recent-ads-list-location">
                                        <?php
                                        $category = '';
                                        $category = get_the_category($recent_post->ID);
                                        ?>
                                        <li><a href="<?php echo esc_url(get_category_link($category[0]->cat_ID)); ?>"><?php echo '' . $category[0]->cat_name; ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>	  
                </div>
            </div>
            <?php
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Nokri Recent Blog Posts', 'nokri');
            }
            if (isset($instance['nokri_listing_post_no'])) {
                $nokri_listing_post_no = $instance['nokri_listing_post_no'];
            } else {
                $nokri_listing_post_no = 5;
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>" >
                    <?php echo esc_html__('Title:', 'nokri'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('nokri_listing_post_no')); ?>">
                    <?php esc_html__('How many posts to display:', 'nokri'); ?>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('nokri_listing_post_no')); ?>" name="<?php echo esc_attr($this->get_field_name('nokri_listing_post_no')); ?>" type="text" value="<?php echo esc_attr($nokri_listing_post_no); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            $instance['nokri_listing_post_no'] = (!empty($new_instance['nokri_listing_post_no']) ) ? strip_tags($new_instance['nokri_listing_post_no']) : '';
            return $instance;
        }

    }

    // Recent Posts
}

/* ========================= */
/* Search By keywords jobs  */
/* ========================= */

class nokri_job_keyword_new extends WP_Widget {

    /** Register widget with WordPress */
    function __construct() {
        parent::__construct(
                'nokri_job_keyword_new', // Base ID
                esc_html__('Nokri Jobs Search By Keyword', 'nokri'), // Name
                array('description' => esc_html__('Add widget for search jobs by keywords', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {

        global $nokri;

        $title = '';
        $in = '';
        $collapsed = 'collapsed';
        $multi_searach = ( isset($nokri['multi_job_search_form']) && $nokri['multi_job_search_form'] != "" ) ? $nokri['multi_job_search_form'] : false;
        if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
            $in = 'in';
            $collapsed = '';
        }

        if (isset($_GET['job-title']) && $_GET['job-title'] != "") {
            $title = $_GET['job-title'];
            $in = 'in';
        }
        ?>				
        <div class="panel panel-default">
            <div class="panel-heading active" role="tab">
                <a role="button" data-toggle="collapse" href="#job_keyword">
                    <?php echo nokri_returnEcho($instance['title']); ?>
                </a>
            </div>
            <div id="job_keyword" class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel" >
                <div class="panel-body">                 
                    <form role="search" method="get"   action = "<?php echo get_the_permalink($nokri['sb_search_page']); ?>" class="custom-search-form">
                        <div class="form-group">
                            <input type="text" id="autocomplete-dynamic" autocomplete="off" class="form-control" name="job-title" value="<?php echo esc_attr($title); ?>" placeholder="<?php echo esc_html__('Enter keyword or title', 'nokri') ?>">
                            <?php if (!$multi_searach) { ?> <button type="submit" class="btn n-btn-flat btn-mid"><i class="fa fa-search"></i></button> <?php } ?>
                        </div>
                        <div class="form-group form-action">
                        </div>
                        <?php
                        if (!$multi_searach) {
                            echo nokri_search_params('job-title');
                            echo nokri_form_lang_field_callback(true);
                        }
                        ?>

                    </form>               
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'nokri');
        /* Seting Open Or Not */
        $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'nokri'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <!--Open/Close  --->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
        esc_attr_e('Set Widget',
                'nokri');
        ?>
            </label> 
            <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                <option value="open" <?php
        if ($is_open == 'open') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                <option value="close" <?php
        if ($is_open == 'close') {
            echo "selected";
        };
        ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
            </select>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
        return $instance;
    }

}

// register Foo_Widget widget
function nokri_job_keyword_new() {
    register_widget('nokri_job_keyword_new');
}

add_action('widgets_init', 'nokri_job_keyword_new');


//custom field search widgets


add_action('widgets_init', function() {
    register_widget('Nokri_custom_fields_widget');
});
if (!class_exists('Nokri_custom_fields_widget')) {

    class Nokri_custom_fields_widget extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {
            $widget_ops = array(
                'classname' => 'Nokri_custom_fields_widget',
                'description' => __('Only for job search page', 'nokri'),
            );
            // Instantiate the parent object
            parent::__construct(false, __('Jobs Custom Fields Search', 'nokri'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget($args, $instance) {
            $collapsed = 'collapsed';
            $in = "";
            if (isset($instance['is_open']) && $instance['is_open'] == 'open') {
                $in = 'in';
                $collapsed = '';
            }
            global $nokri;
            $term_id = '';
            $customHTML = '';
            if (isset($_GET['cat-id']) && $_GET['cat-id'] != "") {
                ?>
                <?php get_template_part('template-parts/cf', 'widgets'); ?>
                <?php
            }
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance) {

            $title = ( isset($instance['title']) ) ? $instance['title'] : esc_html__('Search By:', 'nokri');
            $is_open = !empty($instance['is_open']) ? $instance['is_open'] : esc_html__('Select Widget Type', 'nokri');
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>" >
                    <?php echo esc_html__('Title:', 'nokri'); ?> <small><?php echo esc_html__('You can leave it empty as well', 'nokri'); ?></small>
                </label> 
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            <p><?php echo esc_html__('You can show/hide the specific type from categories custom fields where you created it.', 'nokri'); ?> </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('is_open')); ?>"><?php
                    esc_attr_e('Set Widget',
                            'nokri');
                    ?>
                </label> 
                <select name="<?php echo esc_attr($this->get_field_name('is_open')); ?>" id="<?php echo esc_attr($this->get_field_id('is_open')); ?>" class="widefat">
                    <option value="open" <?php
            if ($is_open == 'open') {
                echo "selected";
            };
                    ?> ><?php echo esc_html__('Open', 'nokri'); ?></option>
                    <option value="close" <?php
            if ($is_open == 'close') {
                echo "selected";
            };
                    ?> ><?php echo esc_html__('Close', 'nokri'); ?></option>    				
                </select>
            </p>

            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            $instance['is_open'] = (!empty($new_instance['is_open']) ) ? strip_tags($new_instance['is_open']) : '';
            return $instance;
        }

    }

    /* Custom Search */
}





/* ========================= */
/*  Feature candidate        */
/* ========================= */

class nokri_feature_candidate_widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_feature_candidate_widget', // Base ID
                esc_html__('Featured Candidates', 'nokri'), // Name
                array('description' => esc_html__('Show Feature Candidates', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        global $nokri;
        $title = isset($instance['title']) ? $instance['title'] : "";
        $no_of_employers = isset($instance['no_of_employers']) ? $instance['no_of_employers'] : "";


        $args = array(
            'order' => 'DESC',
            'meta_key' => '_is_candidate_featured',
            'number' => $no_of_employers,
            'orderby' => 'registered',
            'role__in' => array('editor', 'administrator', 'subscriber'),
        );
        // Create the WP_User_Query object
        $wp_user_query = new WP_User_Query($args);
        $users = $wp_user_query->get_results();
        $cand_datas = "";
        if (!empty($users)) {
            // Loop through results
            foreach ($users as $user) {
                $cand_id = $user->ID;
                $cand_data = get_userdata($cand_id);
                /* Profile Pic  */
                $image_dp_link = nokri_get_user_profile_pic($cand_id, '_cand_dp');


                /* Getting Employer Skills  */
                $cand_headline = get_user_meta($cand_id, '_user_headline', true);
                if (!isset($image_dp_link[0]) && empty($image_dp_link[0])) {
                    $image_dp_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                }


                $cand_name = $cand_data->display_name;

                $cand_datas .= '<li>
                            <div class="recently-added-img"><a href="' . esc_url(get_author_posts_url($cand_id)) . '"> <img class="img-fluid" src="' . $image_dp_link . '" alt=""> </a> </div>
                            <div class="recently-added-desc">
                                <h4><a href="' . esc_url(get_author_posts_url($cand_id)) . '">' . esc_html($cand_name) . '</a></h4>
                                <div class="main-rate mb-1"><span class="main-reg-pricing "> ' . esc_html($cand_headline) . '</span></span></div>
                            </div>
                        </li>';
            }
        }
        ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab">
                <a class="collapsed" role="button" data-toggle="collapse" href="#feature-candidate" aria-expanded="false">												
                    <?php echo esc_html($title) ?>
                </a>
            </div>
            <div class="panel-collapse"  id="feature-candidate">
                <div class="panel-body">
                    <ul class="widget-inner-container recently-added" >
                        <?php echo nokri_returnEcho($cand_datas); ?>
                    </ul>
                </div>
            </div>
        </div>


        <?php
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {




        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = esc_html__('Featured Employers', 'nokri');
        }
        if (isset($instance['no_of_employers'])) {
            $no_of_employers = $instance['no_of_employers'];
        } else {
            $no_of_employers = 5;
        }
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>" >
                <?php echo esc_html__('Title:', 'nokri'); ?>
            </label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_employers')); ?>">
                <?php esc_html__('How many Candidates to display:', 'nokri'); ?>
            </label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_employers')); ?>" name="<?php echo esc_attr($this->get_field_name('no_of_employers')); ?>" type="text" value="<?php echo esc_attr($no_of_employers); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['no_of_employers'] = (!empty($new_instance['no_of_employers']) ) ? strip_tags($new_instance['no_of_employers']) : '';

        return $instance;
    }

}

// register nokri Widget widget
function nokri_feature_candidate_widget() {
    register_widget('nokri_feature_candidate_widget');
}

add_action('widgets_init', 'nokri_feature_candidate_widget');

/* ========================= */
/*  Custom search widget */
/* ========================= */

class nokri_feature_employer_widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
                'nokri_feature_employer_widget', // Base ID
                esc_html__('Featured Employer', 'nokri'), // Name
                array('description' => esc_html__('Show Feature Employer', 'nokri'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        global $nokri;
        $title = isset($instance['title']) ? $instance['title'] : "";
        $no_of_employers = isset($instance['no_of_employers']) ? $instance['no_of_employers'] : "";

        // Query args
        $args = array(
            'order' => 'DESC',
            'orderby' => array(
                'registered',
            ),
            'number' => $no_of_employers,
            'role__in' => array('editor', 'administrator', 'subscriber'),
            'meta_query' => array(array(
                    'relation' => 'OR',
                    array(
                        'key' => '_emp_feature_profile',
                        'compare' => 'EXISTS'
                    ),
                ),
                array(
                    'key' => '_sb_is_member',
                    'compare' => 'NOT EXISTS'
                ),
                array(
                    'key' => '_is_candidate_featured',
                    'compare' => 'NOT EXISTS'
                ),
            )
        );
        // Create the WP_User_Query object
        $wp_user_query = new WP_User_Query($args);
        $users = $wp_user_query->get_results();
        $cand_datas = "";
        if (!empty($users)) {
            // Loop through results
            foreach ($users as $user) {

                $user_id = $user->ID;
                $user_name = $user->display_name;
                /* Profile Pic  */
                $image_dp_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
                    $image_dp_link = array($nokri['nokri_user_dp']['url']);
                }
                if (get_user_meta($user_id, '_sb_user_pic', true) != '') {
                    $attach_dp_id = get_user_meta($user_id, '_sb_user_pic', true);
                    $image_dp_link = wp_get_attachment_image_src($attach_dp_id, '');
                }
                if (empty($image_dp_link[0])) {
                    $image_dp_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                }

                $user_post_count = count_user_posts($user_id, 'job_post');

                $no_of_employers = get_user_meta($user_id, '_emp_nos', true);
                $no_of_employers = $no_of_employers != "" ? $no_of_employers : 0;

                $cand_datas .= '<li class="list-group-item">
                                    <div class="avatar avatar-online"> <a href="' . esc_url(get_author_posts_url($user_id)) . '"><img src="' . $image_dp_link[0] . '" class="img-fluid"> </a></div>
                                    <div class="list-body">
                                      <h4><a href="' . esc_url(get_author_posts_url($user_id)) . '">' . $user_name . '</a></h4>
                                      <div class="list-meta">
                                        <ul class="">
                                          <li class="list-meta-with-icons single-d-views">' . esc_html('Jobs', 'nokri') . ' : ' . $user_post_count . '</li>
                                          <li class="list-meta-with-icons single-d-views"> ' . esc_html__('Employees', 'nokri') . ' : ' . esc_html($no_of_employers) . ' </li>
                                        </ul>
                                      </div>
                                    </div>
                                  </li>';
            }
        }
        ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab">
                <a class="collapsed" role="button" data-toggle="collapse" href="#feature-employer" aria-expanded="false">												
                    <?php echo esc_html($title) ?>
                </a>
            </div >        
            <ul class="list-group list-group-flush"  id="feature-employer">
                <?php echo nokri_returnEcho($cand_datas); ?>
            </ul>              
        </div>
        <?php
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance) {

        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = esc_html__('Featured Employers', 'nokri');
        }
        if (isset($instance['no_of_employers'])) {
            $no_of_employers = $instance['no_of_employers'];
        } else {
            $no_of_employers = 5;
        }
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>" >
                <?php echo esc_html__('Title:', 'nokri'); ?>
            </label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('no_of_employers')); ?>">
                <?php esc_html__('How many Employers to display:', 'nokri'); ?>
            </label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_employers')); ?>" name="<?php echo esc_attr($this->get_field_name('no_of_employers')); ?>" type="text" value="<?php echo esc_attr($no_of_employers); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        /* Save open/close */
        $instance['no_of_employers'] = (!empty($new_instance['no_of_employers']) ) ? strip_tags($new_instance['no_of_employers']) : '';

        return $instance;
    }

}

// register nokri Widget widget
function nokri_feature_employer_widget() {
    register_widget('nokri_feature_employer_widget');
}

add_action('widgets_init', 'nokri_feature_employer_widget');
