<?php  if ( is_active_sidebar( 'nokri_shop-sidebar' ) )
{   
    echo '<div class="col-md-4 col-sm-12 col-xs-12"><aside class="blog-sidebar">';
    dynamic_sidebar('nokri_shop-sidebar'); 
    echo '</aside>';
     
}