<?php  if ( is_active_sidebar( 'blog_sidebar' ) ){ ?>
<div class="col-md-4 col-sm-12 col-xs-12">
	<aside>
		 <?php dynamic_sidebar('blog_sidebar'); ?>
	</aside>
</div>
<?php } ?>