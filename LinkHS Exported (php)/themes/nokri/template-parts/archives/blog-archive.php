<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nokri
 */

/* Side Bar Check */
$blog_sidebar  = isset( $nokri['main_blog_side_bar'] )  ?    $nokri['main_blog_side_bar']  :    '1';
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
<section class="n-blog-section">
    <div class="container">
        <div class="row">
                <?php if( $blog_sidebar == 2) 
                {
                    echo "".($sidebar);	
                }
                 ?>
                <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="row">
                    <div  class="mansi">
                        <?php  
                        if ( have_posts() ) 
                        { 
                            while ( have_posts() )
                            { 
                                the_post();
                                get_template_part( 'template-parts/pages/blog/layout','grid');
                            }
                        }
                        else
                        {
                            echo '<h3>'. esc_html__( 'No Result Found', 'nokri' ).'</h3>';
                        }
                        ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <nav aria-label="Page navigation">
                                    <?php echo nokri_blogs_pagination(); ?>
                                 </nav>
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
</section>