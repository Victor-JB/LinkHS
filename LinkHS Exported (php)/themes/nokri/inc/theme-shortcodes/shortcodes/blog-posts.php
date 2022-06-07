<?php
/* ------------------------------------------------ */
/* Blog Posts */
/* ------------------------------------------------ */

function blog_posts_short()
{
	vc_map(array(
		"name" => esc_html__("Blog Posts", 'nokri') ,
		"base" => "blog_posts_base",
		"category" => esc_html__("Theme Shortcodes", 'nokri') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'nokri' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'nokri' ),
		   'param_name' => 'order_field_key',
		   'description' => nokri_VCImage('nokri_blog_posts.png') . esc_html__( 'Ouput of the shortcode will be look like this.', 'nokri' 			),
		  ),
		 array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Select Posts Order", 'nokri') ,
		"param_name" => "blog_posts_clr",
		"admin_label" => true,
		"value" => array( 
		esc_html__('Select Option', 'nokri') => '', 
		esc_html__('White', 'nokri') =>'',
		esc_html__('Gray', 'nokri') =>'light-grey',
		),
		),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "textfield",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Heading", 'nokri' ),
		"param_name" => "section_title",
		),
		array(
		"group" => esc_html__("Basic", "nokri"),
		"type" => "textarea",
		"holder" => "div",
		"class" => "",
		"heading" => esc_html__( "Section Details", 'nokri' ),
		"param_name" => "section_description",
		),
		array(
		"group" => esc_html__("Post Options", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Number Of Post To Show", 'nokri') ,
		"param_name" => "blog_posts_no",
		"admin_label" => true,
		"value" => range( 1, 50 ),
		),
		array(
		"group" => esc_html__("Post Options", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Number of words in title", 'nokri') ,
		"param_name" => "blog_posts_title_no",
		"admin_label" => true,
		"value" => range( 1, 50 ),
		),
		array(
		"group" => esc_html__("Post Options", "nokri"),
		"type" => "dropdown",
		"heading" => esc_html__("Select Posts Order", 'nokri') ,
		"param_name" => "blog_posts_order",
		"admin_label" => true,
		"value" => array( 
		esc_html__('Select Option', 'nokri') => '', 
		esc_html__('ASCENDING', 'nokri') =>'ASC',
		esc_html__('DESCENDING', 'nokri') =>'DESC',
		),
		),
		
		
		array(
		'group' => esc_html__( 'Post Options', 'nokri' ),
		"type" => "vc_link",
		"heading" => esc_html__( "Read More Link", 'nokri' ),
		"param_name" => "link",
		),
		
		
		array
		(
		'group' => esc_html__( 'Select Categories', 'nokri' ),
		'type' => 'param_group',
		'heading' => esc_html__( 'Add Category', 'nokri' ),
		'param_name' => 'blog_posts',
		'value' => '',
		'params' => array
		(
				 array(
				 "type" => "dropdown",
				 "heading" => esc_html__("Category", 'nokri') ,
				 "param_name" => "categories",
				 "admin_label" => true,
				 "value" => nokri_get_parests('category','yes'),
    			),
   		    )
 			),
	),
	));
}

add_action('vc_before_init', 'blog_posts_short');

function blog_posts_short_base_func($atts, $content = '')
{
	require trailingslashit( get_template_directory () ) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
	
	extract(shortcode_atts(array(
		'order_field_key'   => '',
		'blog_posts_clr' => '',
		'blog_posts_order' => '',
		'blog_posts' => '',   
		'blog_posts_no' => '', 
		'blog_posts_title_no' => '',
		'link' => '',  
	) , $atts));
	if(isset($atts['blog_posts']) && $atts['blog_posts'] != '')
	{
		$rows = vc_param_group_parse_atts( $atts['blog_posts'] );
		$cats_arr = array();
		if( count((array)  $rows ) > 0) 
		{
		foreach($rows as $row )
			{
				$cats_arr[] = $row['categories'];
			}
		}
	}
/*View  Link */
$read_more = '';
if( isset( $link) )
{
	$read_more = '<div class="n-extra-btn-section">'.nokri_ThemeBtn($link, 'btn n-btn-flat btn-mid btn-clear',false).'</div>';
}	
	
/*Post Numbers*/
$section_post_no = (isset($blog_posts_no) && $blog_posts_no != "") ? $blog_posts_no : "6";	
/*Post Orders */
$section_post_ordr = (isset($blog_posts_order) && $blog_posts_order != "") ? $blog_posts_order : "ASC";	
	$args = array(
	'posts_per_page' => $section_post_no, 
    'post_type' => 'post',
	'order' => $section_post_ordr,
    'tax_query' => array(
        array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $cats_arr,
        ),
    ),
);
$the_query = new WP_Query( $args ); 
$blogs_html = '';
 if ( $the_query->have_posts() ) 
 {
  while ($the_query->have_posts())
   { 
   $the_query->the_post();
   $pid = get_the_ID();
 /* Post Title Limit */
 $blog_posts_title_limit= "3";
if(isset($blog_posts_title_no) && $blog_posts_title_no  != "")
{
	$blog_posts_title_limit = $blog_posts_title_no;
}
$thumb_html = '';
if ( has_post_thumbnail() ) 
{
	$thumb_html = '<div class="n-blog-top">
                        	<a href="'. esc_url(get_the_permalink($pid)).'"> '. get_the_post_thumbnail($pid,'nokri_post_standard',array('class'=>'img-responsive') ).' </a>
                        </div>';
}


$blogs_html .= '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                	<div class="n-blog-box">
                    	'.($thumb_html).'
                        <div class="n-blog-bottom">
                        	<ul>
                            	<li>'. get_the_time(get_option( 'date_format' )).'</li>
                            </ul>
                            <h4> <a href="'. esc_url(get_the_permalink($pid)).'">'.get_the_title($pid).' </a></h4>
                            <p>'.nokri_words_count(get_the_excerpt(), 105).' </p>
                            <a href="'. esc_url(get_the_permalink($pid)).'" class="read-more">'.__("Read More", "nokri").'</a>
                            <a href="javascript:void(0)" class="author-icon">'.get_avatar( $the_query->post_author, $size = '45', $default = '', $alt= '', array( 'class' => array( 'img-responsive' ,'img-circle') )).'</a>
                        </div>
                    </div>
                </div>';
}
 wp_reset_postdata(); 
 }	
 /*Section Color */
$section_clr = (isset($blog_posts_clr) && $blog_posts_clr != "") ? $blog_posts_clr : "";
return '<section class="n-blog-section '.esc_attr($section_clr).'">
    <div class="container">
      <div class="row">
        '.$header.'
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
               '.$blogs_html.'
            </div>
			'.$read_more.'
        </div>
      </div>
    </div>
  </section>';
}
if (function_exists('nokri_add_code'))
{
	nokri_add_code('blog_posts_base', 'blog_posts_short_base_func');
}