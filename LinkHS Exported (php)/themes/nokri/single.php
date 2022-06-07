<?php get_header();
global $nokri; 
global $post;
the_post();
$pid = get_the_ID();
/* Side Bar Check */
$blog_sidebar = isset( $nokri['single_blog_side_bar'] ) ? $nokri['single_blog_side_bar'] : '1';
$right_sidebar = $left_sidebar = '';
$layout = $main_col = '';
/* Side Bar In Variable */
ob_start();
dynamic_sidebar('blog_sidebar');
$sidebar = '<div class="col-md-4 col-sm-12 col-xs-12">
                            <aside class="blog-sidebar">'.ob_get_contents().'</aside>
                        </div>';
ob_end_clean();
?>
<section class="blog-detail-page">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
      <?php if( $blog_sidebar == 2) 
		{
			echo "".($sidebar);	
		}
		 ?>
        <div class="col-md-8 col-sm-12 col-xs-12">
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <div class="blog-post">
            <?php
			$has_post_img = '';
			if ( has_post_thumbnail() )
			 { 
			 $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
                        
				echo '<div class="post-img"> <img src="'.get_the_post_thumbnail_url(get_the_ID(),'full').'" alt="'.esc_attr__('image', 'nokri' ).'" class="img-responsive"> <a href="javascript:void(0)" class="author-icon">'.get_avatar( $post->post_author, $size = '45', $default = '', $alt= '', array( 'class' => array( 'img-responsive' ,'img-circle') )).'</a> </div>';
			 }
			 ?>
            <div class="blog-single post-desc entry-content">
              <div class="post-info"> 
              <?php if( isset( $nokri['theme_date'] ) && $nokri['theme_date'] == '1'   ) { ?>
              <a href="javascript:void(0)"><?php echo  get_the_time(get_option( 'date_format' )); ?></a>
              <?php } ?> 
              <a href="javascript:void(0)"><?php echo get_comments_number($pid)." ".__("comment", "nokri"); ?></a> 
              </div>
              <h1 class="post-title"><?php echo the_title(); ?></h1>
              <?php the_content();
			  if(has_tag()) { ?>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <nav aria-label="Page navigation">
					<?php echo nokri_pagination_unit_test(); ?>
              </nav>
                </div>
              <div class="tagcloud"> 
              <i class="fa fa-tags"></i> <?php  echo nokri_posts_tags() ; ?>
              </div>
              <?php }  ?>
            </div>
          </div>
			<div class="comments-container entry-content">
		 	 <?php comments_template(); ?>
			</div>
			
            </div>
        </div>
        <?php if( $blog_sidebar == 1) 
		{
			echo "".($sidebar);	
		}
		 ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>